<?php declare(strict_types=1);

namespace Feather\Resources;

use Feather\Http\Request;
use Feather\Http\Response;
use Feather\Resources\Resource;
use Feather\Http\Data\Method;

/**
 * Class which handles HTTP method resolving and calling
 * the appropriate middleware for each resource & request 
 */
class Resolver
{
    private Request $request;

    public function __construct(
        Request $request
    ) {
        $this->request = $request;
    }

    public function run(Resource $resource): Response 
    {
        switch ($this->request->getMethod()) {
            case Method::GET:
                return $this->executeMiddleware($resource) ?? $resource->get();
            case Method::POST:
                return $this->executeMiddleware($resource) ?? $resource->post();
            case Method::PUT:
                return $this->executeMiddleware($resource) ?? $resource->put();
            case Method::OPTIONS:
                return $this->executeMiddleware($resource) ?? $resource->options();
            case Method::HEAD: 
                return $this->executeMiddleware($resource) ?? $resource->head();
            
        }
    }

    public function executeMiddleware(Resource $resource): ?Response
    {
        foreach ($resource->getMiddleware() as $middleware) 
        {
            $result = $middleware->run($this->request);

            if ($result) {
                return $result;
            }
        }

        return null;
    }
}