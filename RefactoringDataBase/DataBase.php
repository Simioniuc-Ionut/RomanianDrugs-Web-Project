<?php

class Database {
    private string $host = "127.0.0.1:3306";
    private string $db_name = "projectdb";
    private string $username = "root";
    private string $password = "";
    public PDO $conn;

    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connected successfully to database";
        } catch(PDOException $e) {
            echo "Connection failed to database: " . $e->getMessage();
        }
    }

    public function prepare($sql): bool|PDOStatement
    {
        return $this->conn->prepare($sql);
    }

}

?>
