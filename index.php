<?php
/**
 * Minimal index.php example 
 */

require 'vendor/autoload.php';

use Feather\Core\FeatherDi;
use Feather\Api;
use App\Resources\Index;

/**
 * Method 1. Use application main class 
 */
class App 
{
    private Api $api;

    public function __construct(
        Api $api 
    ) {
        $this->api = $api;        
    }
    
    public function setup() : void 
    {        
        $this->api->router->registerResource('/', Index::class);
    }

    public function run() : void 
    {
       $this->api->run();
    }
}

$di = FeatherDi::getInstance();
$app = $di->get(App::class);
$app->setup();
$app->run();
