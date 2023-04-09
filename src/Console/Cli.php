<?php declare(strict_types = 1);

namespace Feather\Console;

use Feather\Core\FeatherDi;

class Cli 
{
    private array $commands;
    private array $args;
    private ?string $command;

    public function __construct(
        FeatherDi $di, 
        array $commands = []
    ) {
        $this->commands = $di->getArray(
            $commands, 
            CommandInterface::class
        );
        $this->args = $this->parseArguments();
        $this->command = $this->args[1] ?? null;
    }

    private function parseArguments(): array  
    {
        global $argv;
        $args = $argv;
        unset($args[0]);
        return $args;
    }

    public function run()
    {
        if (empty($this->command)) {
            throw new \Exception('No command input detected');
        }

        /** @var CommandInterface $command */
        foreach ($this->commands as $command) {
            if ($command->getName() === $this->command) {
                $command->execute('asd');
                break;
            }
        }
    }
}