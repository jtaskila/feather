<?php 

namespace Feather\Database\Data;

/**
 * Data class for holding database credentials
 * Credentials can be injected from DI configuration 
 */
class Credentials 
{
    private string $host;
    private string $database;
    private string $username;
    private string $password;
    private string $charset;

    public function __construct(
        string $host,
        string $database,
        string $username,
        string $password,
        string $charset = 'utf8mb4'
    ) {
        $this->host = $host;
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;
        $this->charset = $charset;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getDatabase(): string
    {
        return $this->database;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getCharset(): string
    {
         return $this->charset;
    }
}