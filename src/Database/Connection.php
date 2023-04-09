<?php declare(strict_types=1);

namespace Feather\Database;

use Feather\Database\Data\Credentials;
use Feather\Database\Exceptions\DatabaseException;
use PDO;

class Connection  
{
    private ?PDO $connection = null; 
    private Credentials $credentials;
    private bool $transactionOpen = false;

    public function __construct(
        Credentials $credentials 
    ) {
        $this->credentials = $credentials;
    }

    /**
     * Get the PDO connection or if it doesn't exists yet, create one.
     */
    public function getConnection(): PDO
    {
        if (!$this->connection) {
            try {
                $this->connection = new PDO(
                    $this->getDsn(), 
                    $this->credentials->getUsername(), 
                    $this->credentials->getPassword(),
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                );
            } catch (\PDOException $e) {
                throw new DatabaseException('Can not create a database connection');
            }
        }

        return $this->connection;
    }

    public function startTransaction(): void 
    {
        if ($this->transactionOpen) {
            throw new DatabaseException('Transaction is already started');
        }
        
        $connection = $this->getConnection();
        $connection->beginTransaction();
        $this->transactionOpen = true;
    }

    public function commitTransaction(): void 
    {
        if (!$this->transactionOpen) {
            throw new DatabaseException('No transaction open to commit');
        }

        $connection = $this->getConnection();
        $connection->commit();

        $this->transactionOpen = false;
    }

    public function cancelTransaction(): void 
    {
        if (!$this->transactionOpen) {
            throw new DatabaseException('No transaction open to rollback');
        }

        $connection = $this->getConnection();
        $connection->rollBack();

        $this->transactionOpen = false;
    }

    /**
     * Close the PDO connection 
     */
    public function closeConnection() : void
    {
        $this->connection = null;
    }

    /**
     * Prepare the connection string 
     */
    private function getDsn() : string 
    {        
        return 'mysql:host='.$this->credentials->getHost() .
        ';dbname=' . $this->credentials->getDatabase() .
        ';charset=' . $this->credentials->getCharset() . ';';
    }
}