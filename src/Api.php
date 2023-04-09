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
    private string $version;
    private ?string $rootDir = null;

    public function __construct(
        Router $router,
        Resolver $resolver,
        ResponseFactory $responseFactory,
        string $version
    ) {
        $this->router = $router;
        $this->resolver = $resolver;
        $this->responseFactory = $responseFactory;
        $this->version = $version;
    }

    public function run() 
    {
        if (!$this->rootDir) {
            throw new \Exception('Root directory is not set');
        }

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

    /** 
     * Get Feather version
     */
    public function getVersion(): string 
    {
        return $this->version;
    }

    /** 
     * Set projects root directory 
     */
    public function setRootDir(string $rootDir): Api 
    {
        $this->rootDir = $rootDir;

        return $this;
    }

    /**
     * Get the project root directory 
     */
    public function getRootDir(): ?string 
    {
        return $this->rootDir;
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