<?php declare(strict_types=1);

namespace Feather\Resources;

use Feather\Http\Response;
use Feather\Http\ResponseFactory;
use Feather\Http\Data\Status;

class Resource
{
    protected $responseFactory;

    public function __construct(
        ResponseFactory $responseFactory
    ) {
        $this->responseFactory = $responseFactory;
    }

    public function get() : Response
    {
        return $this->responseFactory->create(Status::NOT_ALLOWED_METHOD);
    }

    public function post() : Response
    {
        return $this->responseFactory->create(Status::NOT_ALLOWED_METHOD);
    }

    public function put() : Response
    {
        return $this->responseFactory->create(Status::NOT_ALLOWED_METHOD);
    }

    public function patch() : Response
    {
        return $this->responseFactory->create(Status::NOT_ALLOWED_METHOD);
    }

    public function options() : Response
    {
        return $this->responseFactory->create(Status::NOT_ALLOWED_METHOD);
    }

    public function head() : Response
    {
        return $this->responseFactory->create(Status::NOT_ALLOWED_METHOD);
    }
}