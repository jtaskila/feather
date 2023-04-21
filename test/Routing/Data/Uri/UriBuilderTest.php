<?php declare(strict_types=1);

namespace Feather\Test\Routing\Data\Uri;

use Feather\AppInfo;
use Feather\Routing\Data\Uri\UriBuilder;
use PHPUnit\Framework\TestCase;

final class UriBuilderTest extends TestCase
{
    private UriBuilder $testObject;
    private string $testUrl = 'https://test.com/testing/page?query=593&search=test';
    
    public function __construct(string $name)
    {
        parent::__construct($name);
        
        $appInfo = new AppInfo('', '', 'https://test.com');
        $this->testObject = new UriBuilder($appInfo);
    }

    public function testGettingUriFromUrl(): void
    {
        $expectedUri = '/testing/page?query=593&search=test';
        
        $uri = $this->testObject->getUriFromUrl($this->testUrl);
        
        $this->assertEquals($expectedUri, $uri);
    }
    
    public function testGettingExplodedUri(): void
    {
        $expected = [
            'testing',
            'page'
        ];
        
        $explodedUri = $this->testObject->getExplodedUri($this->testUrl);
        
        $this->assertEquals($expected, $explodedUri);
    }
    
    public function testGettingExplodedQueryParams(): void
    {
        $expected = [
            'query' => '593',
            'search' => 'test'
        ];
        
        $explodedQueryParams = $this->testObject->getExplodedQueryParams($this->testUrl);
        
        $this->assertEquals($expected, $explodedQueryParams);
    }
}