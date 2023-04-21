<?php declare(strict_types=1);

namespace Feather\Test;

use PHPUnit\Framework\TestCase;

final class AppInfoTest extends TestCase
{
    public function testObjectState(): void
    {
        $rootDir = '/root/directory';
        $version = '0.0.1';
        
        $object = new \Feather\AppInfo($rootDir, $version);
        
        $this->assertEquals($rootDir, $object->getRootDir());
        $this->assertEquals($version, $object->getFeatherVersion());
    }
}