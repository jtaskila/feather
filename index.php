<?php
/**
 * Minimal index.php example 
 */

require 'vendor/autoload.php';

use Feather\Core\FeatherDi;
use Feather\Api;
use App\Resources\Index;
use App\Resources\Page;
use Feather\AppInterface;
use Feather\Middleware\Forbidden;

class App implements AppInterface
{
    private Api $api;

    public function __construct(
        Api $api 
    ) {
        $this->api = $api;        
    }
    
    public function setup() : void 
    {   
        $this->api->router->setMiddleware([Forbidden::class]);
        $this->api->router->registerResource('/', Index::class);
        $this->api->router->registerResource('/page', Page::class);
    }

    public function run() : void 
    {
       $this->api->run(true);
    }
}

$di = FeatherDi::getInstance();
$app = $di->get(App::class);
$app->setup();
$app->run();
