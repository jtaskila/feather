<?php declare(strict_types = 1);

namespace Feather\Console;

interface CommandInterface {
    public function getName(): string;
    public function getHelp(): string;
    public function getArgs(): array;
    public function execute($input): int;
}