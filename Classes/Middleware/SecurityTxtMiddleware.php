<?php

declare(strict_types=1);

namespace HDNET\SecurityTxt\Middleware;

use HDNET\SecurityTxt\Handler\SecurityTxtHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class SecurityTxtMiddleware implements MiddlewareInterface
{
    public const string SECURITY_TXT_PATH = '/.well-known/security.txt';

    public function __construct(protected SecurityTxtHandler $securityTxtHandler) {}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($request->getUri()->getPath() === self::SECURITY_TXT_PATH) {
            return $this->securityTxtHandler->handle($request);
        }

        return $handler->handle($request);
    }
}
