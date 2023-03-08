<?php 
require 'vendor/autoload.php';

/**use Feather\Core\FeatherDi;
use Feather\Routing\Data\Uri\UriFactory;
use Feather\Routing\Data\Uri\UriParamMapper;

$featherDi = FeatherDi::getInstance();
$f = $featherDi->get(UriFactory::class);
$mapper = $featherDi->get(UriParamMapper::class);


$uri1 = $f->create('http://localhost/test/2453/test?asd=test');
$uri2 = $f->create('http://localhost/test/<id>/<str>');


$uri = $mapper->mapParams($uri1, $uri2);

print_r($uri->getUri());
echo "<br>================<br>";
print_r($uri->getQueryParams());
echo "<br>================<br>";
print_r($uri->getUriParams());


*/

use Feather\Api;
use Feather\Core\FeatherDi;
use Feather\DiConfig;
use Feather\Core\DiConfigInterface;
use Feather\Database\Connection;
use Feather\Database\Data\Credentials;
use Feather\Database\Query\Builder;

$conf = [    
    Credentials::class => [
        'host'     => 'localhost',
        'database' => 'test',
        'username' => 'username',
        'password' => 'password'
    ]
];

interface TestInterface 
{
    public function test() : void;
}

class Test1 implements TestInterface{
    public function test() : void 
    {
        echo "Test1";
    }
}

class Test2 implements TestInterface{
    public function test() : void 
    {
        echo "Test2";
    }
}

interface TestInterface2{
    public function test2() : void;
}

$objArray = [
    'tesst1' => Test1::class,
    'test2' => Test2::class 
];


/*
$di = FeatherDi::getInstance();
$objects = $di->getArray($objArray, TestInterface::class);
echo '<pre>';
print_r($di->getConfig());
echo '</pre>';
*/

$di = FeatherDi::getInstance();
/** @var Builder  */
$builder = $di->get(Builder::class);

$query = $builder->select()->from('users')->where('id', '=', '24');

echo $builder->create();
