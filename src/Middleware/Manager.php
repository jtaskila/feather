<?php declare(strict_types=1);

namespace Feather\Middleware;

use Feather\Core\FeatherDi;

class Manager 
{
    private FeatherDi $di;

    public function __construct(
        FeatherDi $di
    ) {
        $this->di = $di;
    }

    public function initMiddleware(array $middlewareClasses): array 
    {
        return $this->di->getArray($middlewareClasses, MiddlewareInterface::class);
    }
}