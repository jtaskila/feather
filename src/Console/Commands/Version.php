<?php declare(strict_types = 1);

namespace Feather\Console\Commands;

use Feather\Api;
use Feather\Console\CommandInterface;

class Version implements CommandInterface
{
    private Api $api;

    public function __construct(
        Api $api
    ) {
        $this->api = $api;
    }

    public function getName(): string 
    {
        return 'version';
    }

    public function getHelp(): string 
    {
        return 'Command to get Feather version';
    }

    public function getArgs(): array 
    {
        return [];
    }

    public function execute($input): int
    {
        echo 'Feather version: ' . $this->api->getVersion();
        return 0;
    }
}