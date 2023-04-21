<?php declare(strict_types=1);

namespace Feather\Test\Routing\Data\Uri;

use Feather\Routing\Data\Uri\Uri;
use Feather\Routing\Data\Uri\UriFactory;
use Feather\Routing\Data\Uri\UriParamMapper;
use PHPUnit\Framework\TestCase;

final class UriParamMapperTest extends TestCase
{
    private UriParamMapper $testObject;
    private UriFactory $uriFactory;
    
    public function __construct(string $name)
    {
        parent::__construct($name);
        
        $this->uriFactory = $this->createMock(UriFactory::class);
        $this->uriFactory->method('createInstance')->willReturn(
            new Uri([], [])
        );
        
        $this->testObject = new UriParamMapper($this->uriFactory);
    }
    
    public function testMatchingUris(): void
    {
        $realUri = new Uri(
            ['user','123', 'posts'],
            []
        );
        
        $resourceUri = new Uri(
            ['user', '<id>', 'posts'],
            []
        );
           
        $this->assertTrue($this->testObject->matchUri($realUri, $resourceUri));
    }
    
    public function testNotMatchingUris(): void
    {
        $realUri = new Uri(
            ['user','123'],
            []
        );

        $resourceUri = new Uri(
            ['user', '<id>', 'posts'],
            []
        );

        $this->assertFalse($this->testObject->matchUri($realUri, $resourceUri));
    }
}