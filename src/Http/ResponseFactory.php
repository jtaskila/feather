<?php declare(strict_types=1);

namespace Feather\Http;

use Feather\Core\FeatherDi;
use Feather\Http\Response;

class ResponseFactory 
{
    private FeatherDi $featherDi;

    public function __construct(
        FeatherDi $featherDi
    )
    {
        $this->featherDi = $featherDi;        
    }

    public function create(int $status, ?string $body = null) : Response
    {
        return $this->featherDi->getUnique(Response::class, 
            [
                'status' => $status,
                'body' => $body
            ]
        );
    }
}