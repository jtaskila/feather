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
use Feather\Middleware\Default\BasicAuth;
use Feather\Database\Schema\Migrator;
use Feather\Database\Schema\Table;

class App implements AppInterface
{
    private Api $api;
    private Migrator $migrator;
    private BasicAuth $basicAuth;

    public function __construct(
        Api $api,
        Migrator $migrator,
        BasicAuth $basicAuth
    ) {
        $this->api = $api;
        $this->migrator = $migrator;
        $this->basicAuth = $basicAuth;
    }
    
    public function setup(): void
    {   
        /**
         * Configure app
         */
         $this->api->setDebugMode(true);

        /**
         * Configure middleware
         */
        $this->basicAuth->setRealm('test')
            ->setUser('test')
            ->setPassword('test');

        /**
         * Register database tables
         */
        $this->migrator->registerTable(Table::class);

        /**
         * Register middleware and routes
         */
        //$this->api->router->setMiddleware([BasicAuth::class]);
        $this->api->router->registerResource('/user', Index::class);
        $this->api->router->registerResource('/', Page::class);
    }

    public function run(): void
    {
       $this->api->run();
    }
}

$di = FeatherDi::init(__DIR__);
$app = $di->get(App::class);
$app->setup();
$app->run();