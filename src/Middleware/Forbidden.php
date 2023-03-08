<?php declare(strict_types=1);

namespace Feather\Middleware;

use Feather\Http\Data\Status;
use Feather\Http\Request;
use Feather\Http\Response;
use Feather\Http\ResponseFactory;

class Forbidden implements MiddlewareInterface
{
    private ResponseFactory $responseFactory;

    public function __construct(
        ResponseFactory $responseFactory
    ) {
        $this->responseFactory = $responseFactory;
    }

    public function run(Request $request): ?Response 
    {
        return $this->responseFactory->create(
            Status::FORBIDDEN, 
            $this->generateBody()
        );
    }

    private function generateBody(): string 
    {
        return \json_encode(['error' => 'forbidden']);
    }
}