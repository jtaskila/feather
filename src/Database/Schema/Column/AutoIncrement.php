<?php declare(strict_types=1);

namespace Feather\Database\Schema\Column;

use Feather\Database\Exceptions\DatabaseException;

class AutoIncrement implements ColumnInterface
{
    public function getType(): string 
    {
        return 'BIGINT';
    }

    public function getDefinition(): string
    {
        $definition = $this->getType() . 
            ' UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY';

        return $definition;
    }
}