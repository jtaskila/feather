<?php declare(strict_types=1);

namespace Feather\Http;

use Feather\Core\FeatherDi;
use Feather\Http\Data\Status;
use Feather\Http\Response;

/**
 * Factory class for creating HTTP responses
 */
class ResponseFactory 
{
    private FeatherDi $featherDi;

    public function __construct(
        FeatherDi $featherDi
    ) {
        $this->featherDi = $featherDi;        
    }

    public function create(int $status = Status::OK, ?string $body = null): Response
    {
        /** @var Response $response */
        $response = $this->featherDi->getUnique(Response::class, 
            [
                'status' => $status,
                'body' => $body
            ]
        );

        return $response;
    }
}