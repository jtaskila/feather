<?php declare(strict_types = 1);

namespace Feather\Console\Commands;

use Feather\Console\CommandInterface;
use Feather\Database\Schema\Migrator;
use Feather\Database\Exceptions\DatabaseException;

class DatabaseMigrate implements CommandInterface
{
    private Migrator $migrator;

    public function __construct(
        Migrator $migrator
    ) {
        $this->migrator = $migrator;
    }

    public function getName(): string
    {
        return 'db:migrate';
    }

    public function getHelp(): string
    {
        return 'Command executes database migrations';
    }

    public function getArgs(): array
    {
        return [];
    }

    public function execute($input): int
    {
        echo 'Migrating database...'.PHP_EOL;
        try {
            $this->migrator->migrate();
        } catch (DatabaseException $e) {
            echo 'Error occured during database migration: '.$e->getMessage().PHP_EOL;
            return -1;
        }
        echo 'Migrations executed succesfully'.PHP_EOL;

        return 0;
    }
}