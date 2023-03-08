<?php declare(strict_types=1);

namespace Feather\Resources;

use Feather\Http\Response;
use Feather\Http\ResponseFactory;
use Feather\Http\Data\Status;
use Feather\Middleware\MiddlewareInterface;

class Resource
{
    private $responseFactory;
    private $middleware = [];

    public function __construct(
        ResponseFactory $responseFactory
    ) {
        $this->responseFactory = $responseFactory;
    }

    public function setMiddleware(array $middleware): Resource 
    {
        foreach ($middleware as $ware) {
            if (!$ware instanceof MiddlewareInterface) {
                throw new \Exception('Invalid middleware');
            }

            $this->middleware[] = $ware;
        }

        return $this;
    }

    /**
     * @return MiddlewareInterface[]
     */
    public function getMiddleware(): array 
    {
        return $this->middleware;
    }

    public function get(): Response
    {
        return $this->responseFactory->create(Status::NOT_ALLOWED_METHOD);
    }

    public function post(): Response
    {
        return $this->responseFactory->create(Status::NOT_ALLOWED_METHOD);
    }

    public function put(): Response
    {
        return $this->responseFactory->create(Status::NOT_ALLOWED_METHOD);
    }

    public function patch(): Response
    {
        return $this->responseFactory->create(Status::NOT_ALLOWED_METHOD);
    }

    public function options(): Response
    {
        return $this->responseFactory->create(Status::NOT_ALLOWED_METHOD);
    }

    public function head(): Response
    {
        return $this->responseFactory->create(Status::NOT_ALLOWED_METHOD);
    }
}