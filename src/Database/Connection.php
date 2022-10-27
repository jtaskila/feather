<?php declare(strict_types=1);

namespace Feather\Database;

use Feather\Database\Data\Credentials;
use PDO;

class Connection  
{
    private ?PDO $connection = null; 
    private Credentials $credentials;

    public function __construct(
        Credentials $credentials 
    ) {
        $this->credentials = $credentials;
    }

    /**
     * Get the PDO connection or if it doesn't exists yet, create one.
     */
    public function getConnection() : PDO
    {
        if (!$this->connection) {
            try {
                $this->connection = new PDO(
                    $this->getDsn(), 
                    $this->credentials->getUsername(), 
                    $this->credentials->getPassword()
                );
            } catch (\PDOException $e) {
                throw new \Exception('Can not create a database connection');
            }
        }
        return $this->connection;
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
        return 'mysql:host='.$this->credentials->getHost().
        ';dbname='.$this->credentials->getDatabase().
        ';charset='.$this->credentials->getCharset().';';
    }
}