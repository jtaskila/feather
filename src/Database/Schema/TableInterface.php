<?php declare(strict_types=1);

namespace Feather\Database\Schema;

interface TableInterface 
{
    /**
     * Returns the name of the table 
     */
    public function getName(): string;

    /**
     * Returns the specified schema for the table 
     */
    public function getSchema(): array;

    /**
     * Returns the specified indexes for the table 
     */
    public function getIndexes(): array;

    /**
     * Returns the specified foreign keys for the table 
     */
    public function getForeignKeys(): array;
}