<?php

namespace HDNET\SecurityTxt\Handler;

use HDNET\SecurityTxt\Middleware\SecurityTxtMiddleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Http\Response;
use TYPO3\CMS\Core\Site\Entity\SiteInterface;

class SecurityTxtHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $siteConfiguration = $this->getSiteConfiguration($request);

        $config = $siteConfiguration;

        $lines = [];

        // @todo use right site setting fields
        if (!empty($config['contact'])) {
            foreach ((array)$config['contact'] as $contact) {
                $lines[] = 'Contact: ' . $contact;
            }
        }

        // @todo use right site setting fields
        foreach (['encryption', 'acknowledgments', 'policy', 'hiring'] as $field) {
            if (!empty($config[$field])) {
                $lines[] = ucfirst($field) . ': ' . $config[$field];
            }
        }

        // @todo use right site setting fields
        if (!empty($config['preferredLanguages'])) {
            $lines[] = 'Preferred-Languages: ' . $config['preferredLanguages'];
        }

        // Add technical field: canonical
        /** @var SiteInterface $site */
        $site = $request->getAttribute('site');
        $lines[] = 'Canonical: ' . $site->getBase()->withPath(SecurityTxtMiddleware::SECURITY_TXT_PATH);

        // Add technical field: expires
        // @todo check "relative buf fixed date" with Expires header and encryption option
        $date = (new \DateTimeImmutable())->modify('last day of next month');
        $lines[] = 'Expires: ' . $date->format(\DateTime::RFC3339);

        return $this->buildTxtResponse(implode("\n", $lines) . "\n");
    }

    protected function getSiteConfiguration(ServerRequestInterface $request): array
    {
        $site = $request->getAttribute('site');
        return $site instanceof SiteInterface ? $site->getConfiguration() : [];
    }

    protected function buildTxtResponse(string $body): ResponseInterface
    {
        $response = new Response();
        $response->getBody()->write($body);
        return $response
            ->withHeader('Content-Type', 'text/plain')
            ->withStatus(200);
    }
}
