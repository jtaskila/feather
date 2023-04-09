<?php declare(strict_types=1);

namespace Feather\Database\Schema\Column;

use Feather\Database\Exceptions\DatabaseException;

class Text implements ColumnInterface
{
    private bool $nullable = true;
    private ?string $default = null; 

    public function setNullable(bool $nullable): Text
    {
        $this->nullable = $nullable;

        return $this;
    }

    public function setDefault(?string $default): Text
    {
        $this->default = $default;

        return $this;
    }


    public function getType(): string
    {
        return 'TEXT';
    }

    public function getDefinition(): string
    {
        $definition = $this->getType();

        if ($this->nullable) {
            $definition = $definition . ' NULL';
        } else {
            $definition = $definition . ' NOT NULL';
        }

        if ($this->default !== null) {
            $definition = $definition . ' DEFAULT "' . $this->default . '"';
        } else {
            if (!$this->nullable) {
                throw new DatabaseException('Text column can not have null default if it is not nullable');
            }
            $definition = $definition . ' DEFAULT NULL';
        }

        return $definition;
    }
}