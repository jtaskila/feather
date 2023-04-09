<?php 

namespace App\Resources;

use App\Models\UserAddress;
use Feather\Api;
use Feather\Core\FeatherDi;
use Feather\Database\Query;
use Feather\Database\DataRepository;
use Feather\Http\Response;
use Feather\Http\ResponseFactory;
use Feather\Http\Data\ContentType;
use Feather\Http\Request;
use Feather\Resources\Resource;

class Index extends Resource
{
    private ResponseFactory $responseFactory;

    private FeatherDi $featherDi;

    public function __construct(
        FeatherDi $featherDi, 
        ResponseFactory $responseFactory
    ) {
        parent::__construct($responseFactory);
        $this->responseFactory = $responseFactory;
        $this->featherDi = $featherDi;
    }

    public function get(): Response
    { 
        $response = $this->responseFactory->create(200);
        $response->setBody(json_encode(['message' => 'index']));
        return $response;
    }

    public function post() : Response 
    {
        $response = $this->responseFactory->create(200);        
        $response->setContentType(ContentType::JSON);

        return $response;
    }
}