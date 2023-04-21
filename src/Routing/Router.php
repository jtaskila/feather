<?php declare(strict_types=1);

namespace Feather\Routing;

use Feather\Core\Collection\Collection;
use Feather\Core\Collection\CollectionFactory;
use Feather\Http\Request;
use Feather\Middleware\Manager as MiddlewareManager;
use Feather\Resources\Resource;
use Feather\Resources\ResourceFactory;
use Feather\Routing\Data\Uri\UriFactory;
use Feather\Routing\Data\Uri\UriParamMapper;
use Feather\Routing\Exceptions\ResourceNotFoundException;

class Router 
{
    private Collection $resources;
    private ResourceFactory $resourceFactory;
    private UriFactory $uriFactory;
    private UriParamMapper $uriParamMapper;
    private MiddlewareManager $middlewareManager;
    private Request $request;
    private array $middleware = [];

    public function __construct(
        CollectionFactory $collectionFactory,
        ResourceFactory $resourceFactory,
        UriFactory $uriFactory,
        UriParamMapper $uriParamMapper,
        MiddlewareManager $middlewareManager,
        Request $request
    ) {
        $this->resources = $collectionFactory->create(Resource::class);        
        $this->resourceFactory = $resourceFactory;
        $this->uriFactory = $uriFactory;
        $this->uriParamMapper = $uriParamMapper;
        $this->middlewareManager = $middlewareManager;
        $this->request = $request;
    }

    /**
     * Initializes and registers a new resource for the Router 
     */
    public function registerResource(string $uri, string $resourceClass, array $middleware = []) 
    {
        $resource = $this->resourceFactory->create($resourceClass);
        $resource->setMiddleware(
            \array_merge(
                $this->middleware, 
                $this->middlewareManager->initMiddleware(
                    $middleware
                )
            )
        );

        $this->resources->add($uri, $resource);
    }

    public function setMiddleware(array $middleware): Router 
    {
        $this->middleware = $this->middlewareManager->initMiddleware($middleware);
        
        return $this;
    }

    /**
     * Returns the resource which is declared to handle the incoming request 
     */
    public function getResource(): Resource
    {
        $requestUri = $this->uriFactory->create($this->request->getUrl());

        foreach ($this->resources->items() as $uri => $resource) 
        {
            $resourceUri = $this->uriFactory->create($uri);

            if ($this->uriParamMapper->matchUri($requestUri, $resourceUri)) {
                /**
                 * Injecting the complete Uri object to current request 
                 */
                $newUri = $this->uriParamMapper->mapParams($requestUri, $resourceUri);
                $this->request->setUri($newUri);

                /**
                 * Returning the matched resource 
                 */
                return $resource;
            }
        }

        throw new ResourceNotFoundException('No resource found for: '.$this->request->getUrl());
    }

}