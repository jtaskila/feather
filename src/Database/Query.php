<?php declare(strict_types=1);

namespace Feather\Database;

use Feather\Database\Exceptions\DatabaseException;
use PDOException;

class Query 
{
    private Connection $connection;

    public function __construct(
        Connection $connection 
    ) {
        $this->connection = $connection;
    }

    /**
     * Execute a raw SQL query 
     */
    public function execute(string $query, array $variables = []) : array 
    {
        $pdo = $this->connection->getConnection();

        try {
            $query = $pdo->prepare($query);
            $query->execute($variables);
            return $query->fetchAll(\PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            throw new DatabaseException($e->getMessage());
        }
    }
}