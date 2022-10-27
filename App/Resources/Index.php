<?php 

namespace App\Resources;

use Feather\Api;
use Feather\Http\Response;
use Feather\Http\ResponseFactory;
use Feather\Http\Data\ContentType;
use Feather\Http\Request;
use Feather\Resources\Resource;

class Index extends Resource
{
    private Request $request;
    private Api $api;

    public function __construct(
        Request $request, 
        ResponseFactory $responseFactory,
        Api $api 
    ) {
        parent::__construct($responseFactory);
        
        $this->request = $request;
        $this->api = $api;
    }

    public function get() : Response 
    { 
        $response = $this->responseFactory->create(200);
        $body = ['Feather' => $this->api->getVersion()];
        $response->setBody(json_encode($body));
        return $response;
    }

    public function post() : Response 
    {
        $response = $this->responseFactory->create(200);        
        $response->setContentType(ContentType::JSON);

        return $response;
    }
}