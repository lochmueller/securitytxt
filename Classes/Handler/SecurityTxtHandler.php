<?php

declare(strict_types=1);

namespace HDNET\SecurityTxt\Handler;

use HDNET\SecurityTxt\Middleware\SecurityTxtMiddleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Http\Response;
use TYPO3\CMS\Core\Site\Entity\SiteInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class SecurityTxtHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $siteConfiguration = $this->getSiteConfiguration($request);

        $lines = [];
        foreach (['contact', 'encryption', 'acknowledgments', 'policy', 'hiring', 'csaf'] as $field) {
            if (!empty($siteConfiguration['securitytxt' . ucfirst($field)])) {
                $values = GeneralUtility::trimExplode(',', $siteConfiguration['securitytxt' . ucfirst($field)], true);
                foreach ($values as $item) {
                    $lines[] = ucfirst($field) . ': ' . $item;
                }
            }
        }

        if (!empty($siteConfiguration['securitytxtPreferredLanguages'])) {
            $lines[] = 'Preferred-Languages: ' . $siteConfiguration['securitytxtPreferredLanguages'];
        }

        // Add technical field: canonical
        /** @var SiteInterface $site */
        $site = $request->getAttribute('site');
        $lines[] = 'Canonical: ' . $site->getBase()->withPath(SecurityTxtMiddleware::SECURITY_TXT_PATH);

        // Add technical field: expires
        $relativeDate = $siteConfiguration['securitytxtRelativeDate'] ?? 'last day of next month';
        $date = (new \DateTimeImmutable())->modify($relativeDate)->setTime(12, 0);
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
