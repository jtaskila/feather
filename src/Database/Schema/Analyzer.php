<?php declare(strict_types=1);

namespace Feather\Database\Schema;

use Feather\Database\Exceptions\DatabaseException;
use Feather\Database\Query;

class Analyzer 
{
    private Query $query;

    public function __construct(
        Query $query 
    ) {
        $this->query = $query;
    }

    public function tableExists(string $table): bool 
    {
        return true;
    }

    public function getTableColumns(string $table): array  
    {
        if (!$this->tableExists($table)) {
            throw new DatabaseException('Table ' . $table . ' does not exists');
        }

        return [];
    }

    public function columnExists(string $table, string $column): bool 
    {
        if (!$this->tableExists($table)) {
            return false;
        }
        
        return true;
    }

    public function getColumn(string $table, string $column): array 
    {
        if (!$this->columnExists($table, $column)) {
            throw new DatabaseException('Column ' . $column . ' in table ' . $table . ' does not exist');
        }
        return [];
    }
}