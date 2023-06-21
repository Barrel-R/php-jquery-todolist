<?php

class Connection
{
    // Database config
    private $host = 'localhost';
    private $dbName = 'xneo_crud';
    private $username = 'root';
    private $password = '';
    
    public function connect() {
        try {
            $connection = new PDO("mysql:host={$this->host};dbname={$this->dbName}", $this->username, $this->password);
        
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
            $connection->exec('SET NAMES utf8');
        
            return $connection;
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
    
        }
    }
}