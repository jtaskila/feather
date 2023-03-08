<?php declare(strict_types=1);

namespace Feather\Database;

use Feather\Database\Exceptions\DatabaseException;
use Feather\Database\Exceptions\EntityNotFoundException;

class DataRepository 
{
    private Query $query;
    private string $primaryColumn;

    public function __construct(
        Query $query,
        string $primaryColumn 
    ) {
        $this->query = $query;
        $this->primaryColumn = $primaryColumn;
    }

    /**
     * Get single entity from database by id
     */
    public function getById(string $table, mixed $id, array $columns = []): array 
    {
        try {
            $data = $this->query->execute(
                'SELECT * FROM ' . $table . ' WHERE ' . $this->primaryColumn . '=:id',
                [':id' => $id]
            );

            if (empty($data)) {
                throw new EntityNotFoundException('No such entity in ' . $table . ' with id: ' . $id);    
            }

            return $data[0];
        } catch (DatabaseException $e) {
            throw new EntityNotFoundException('Database error when trying to find entity in ' . $table . ' with id: ' . $id);
        }
    }

    /**
     * Get list of entities which match the criteria
     */
    public function get(string $table, string $column, mixed $value): array 
    {
        try {
            $data = $this->query->execute(
                'SELECT * FROM ' . $table . ' WHERE ' . $column . '=:value',
                [':value' => $value]
            );

            if (empty($data)) {
                throw new EntityNotFoundException('No such entities in ' . $table . ' with '  . $column . ': ' . $value);    
            }

            return $data;
        } catch (DatabaseException $e) {
            throw new EntityNotFoundException('Database error when trying to find entities in ' . $table . ' with '  . $column . ': ' . $value);
        }
    }

    /**
     * Save row to database 
     */
    public function create(string $table, array $data): mixed 
    {
        if (array_key_exists($this->primaryColumn, $data) && $data[$this->primaryColumn] !== null) {
            throw new DatabaseException('Can not create entity. Entity with id already exists');
        }
        return 0;
    }

    /**
     * Update row in database 
     */
    public function update(string $table, array $data): mixed 
    {
        return 0;
    }
}