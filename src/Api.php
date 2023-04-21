<?php declare(strict_types=1);

namespace Feather;

use Exception;
use Feather\Http\ResponseFactory;
use Feather\Routing\Router;
use Feather\Resources\Resolver;
use Feather\Routing\Exceptions\ResourceNotFoundException;

class Api
{
    public Router $router;
    private Resolver $resolver;
    private ResponseFactory $responseFactory;
    private bool $debug = false;

    public function __construct(
        Router $router,
        Resolver $resolver,
        ResponseFactory $responseFactory,
    ) {
        $this->router = $router;
        $this->resolver = $resolver;
        $this->responseFactory = $responseFactory;
    }

    /**
     * @throws \Throwable
     */
    public function run(): void
    {
        if (defined('FEATHER_CLI_MODE')) {
            return;
        }

        try {
            $resource = $this->router->getResource();
            $response = $this->resolver->run($resource);
            $response->serve();
        } catch (ResourceNotFoundException $e) {            
            $this->responseFactory->create(
                404, 
                \json_encode(
                    [
                        'message' => 'No resource found'
                    ]
                )
            )->serve();
        } catch (\Throwable $e) {
            if ($this->debug) {
                throw $e;
            }
            $this->responseFactory->create(
                500, 
                \json_encode(
                    [
                        'message' => 'Server encountered an error and is unable to process your request'
                    ]
                )
            )->serve();
            
        }
    }

    public function setDebugMode(bool $debug): Api 
    {
        $this->debug = $debug;

        return $this;
    }

    public function getDebugMode(): bool 
    {
        return $this->debug;
    }
}