<?php declare(strict_types=1);

namespace Feather\Database\Schema\Column;

use Feather\Database\Exceptions\DatabaseException;

class Varchar implements ColumnInterface
{
    private bool $nullable = true;
    private ?string $default = null; 
    private int $length = 255;

    public function setNullable(bool $nullable): Varchar
    {
        $this->nullable = $nullable;

        return $this;
    }

    public function setDefault(?string $default): Varchar
    {
        $this->default = $default;

        return $this;
    }

    public function setLength(int $length): Varchar 
    {
        $this->length = $length;

        return $this;
    }


    public function getType(): string
    {
        return 'VARCHAR';
    }

    public function getDefinition(): string
    {
        $definition = \sprintf(
            '%s(%s)',
            $this->getType(),
            $this->length
        );

        if ($this->nullable) {
            $definition = $definition . ' NULL';
        } else {
            $definition = $definition . ' NOT NULL';
        }

        if ($this->default !== null) {
            $definition = $definition . ' DEFAULT "' . $this->default . '"';
        } else {
            if (!$this->nullable) {
                throw new DatabaseException('Varchar column can not have null default if it is not nullable');
            }
            $definition = $definition . ' DEFAULT NULL';
        }

        return $definition;
    }
}