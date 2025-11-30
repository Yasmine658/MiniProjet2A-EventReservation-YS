<?php

class Database {
    private $host = 'localhost';
    private $port = '3306';
    private $db_name = 'mini_event';
    private $username = 'root';
    private $password = 'root';
    private $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};port={$this->port};dbname={$this->db_name};charset=utf8mb4",
                $this->username,
                $this->password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        } catch(PDOException $e) {
            echo "Erreur de connexion : " . $e->getMessage();
        }

        return $this->conn;
    }
}
