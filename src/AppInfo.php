<?php declare(strict_types=1);

namespace Feather;

use Feather\Core\Di\Singleton;

/**
 * Class provides general information of the application instance
 *
 * This is a special class which is instantiated on the DI container startup
 */
class AppInfo implements Singleton
{
    private string $rootDir;
    private string $version;

    public function __construct(
        string $rootDir,
        string $version
    ) {
        $this->rootDir = $rootDir;
        $this->version = $version;
    }

    public function getRootDir(): string
    {
        return $this->rootDir;
    }

    public function getFeatherVersion(): string
    {
        return $this->version;
    }
}