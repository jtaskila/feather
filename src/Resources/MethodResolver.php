<?php declare(strict_types=1);

namespace Feather\Resources;

use Feather\Http\Request;
use Feather\Http\Response;
use Feather\Resources\Resource;
use Feather\Http\Data\Method;

class MethodResolver
{
    private Request $request;

    public function __construct(
        Request $request
    ) {
        $this->request = $request;
    }

    public function run(Resource $resource) : Response 
    {
        switch ($this->request->getMethod()) {
            case Method::GET:
                return $resource->get();
            case Method::POST:
                return $resource->post();
            case Method::PUT:
                return $resource->put();
        }
    }
}