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
    private string $baseUrl;

    public function __construct(
        string $rootDir,
        string $version,
        string $baseUrl = ''
    ) {
        $this->rootDir = $rootDir;
        $this->version = $version;
        $this->baseUrl = $baseUrl;

        if (empty($baseUrl)) {
            $this->baseUrl = $_SERVER['PHP_SELF'];
        }

    }

    public function getRootDir(): string
    {
        return $this->rootDir;
    }

    public function getFeatherVersion(): string
    {
        return $this->version;
    }

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }
}