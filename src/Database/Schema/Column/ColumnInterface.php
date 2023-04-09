<?php declare(strict_types=1);

namespace Feather\Database\Schema\Column;

interface ColumnInterface
{
    /**
     * Returns SQL compatible type of the column
     */
    public function getType(): string;

    /**
     * Returns create column definition
     */
    public function getDefinition(): string;
}