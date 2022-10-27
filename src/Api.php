<?php declare(strict_types=1);

namespace Feather;

use Feather\Routing\Router;
use Feather\Resources\MethodResolver;
use Feather\Routing\Exceptions\ResourceNotFoundException;

class Api
{
    public Router $router;
    private MethodResolver $resolver;
    private bool $debug = false;
    private string $version;

    public function __construct(
        Router $router,
        MethodResolver $resolver,
        string $version
    ) {
        $this->router = $router;
        $this->resolver = $resolver;
        $this->version = $version;
    }

    public function getVersion() : string 
    {
        return $this->version;
    }

    public function run($debug = false) 
    {
        $this->debug = $debug;

        try {
            $resource = $this->router->getResource();
            $response = $this->resolver->run($resource);
            $response->serve();
        } catch (ResourceNotFoundException $e) {            
            echo "No resource found";
        } catch (\Throwable $e) {
            if ($this->debug) {
                throw $e;
            }
            echo "Server has encountered an error and is unable to process your request";
        }
    }
}