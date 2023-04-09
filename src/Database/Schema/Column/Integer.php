<?php declare(strict_types=1);

namespace Feather\Database\Schema\Column;

use Feather\Database\Exceptions\DatabaseException;

class Integer implements ColumnInterface
{
    private bool $nullable = true;
    private bool $unsigned = false;
    private ?int $default = null;

    public function setNullable(bool $nullable): Integer
    {
        $this->nullable = $nullable;

        return $this;
    }

    public function setUnsigned(bool $unsigned): Integer 
    {
        $this->unsigned = $unsigned;

        return $this;
    }


    public function setDefault(?int $default): Integer 
    {
        $this->default = $default;

        return $this;
    }


    public function getType(): string
    {
        return 'INT';
    }

    public function getDefinition(): string
    {
        $definition = $this->getType();
        
        if ($this->unsigned) {
            $definition = $definition . ' UNSIGNED';
        }

        if ($this->nullable) {
            $definition = $definition . ' NULL';
        } else {
            $definition = $definition . ' NOT NULL';
        }

        if ($this->default !== null) {
            $definition = $definition . ' DEFAULT ' . $this->default;
        } else {
            if (!$this->nullable) {
                throw new DatabaseException('Integer column can not have null default if it is not nullable');
            }
            $definition = $definition . ' DEFAULT NULL';
        }


        return $definition;
    }
}