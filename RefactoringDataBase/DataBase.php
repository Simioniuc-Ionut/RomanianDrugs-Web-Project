<?php
require_once 'model/DataManager.php';
require_once 'model/DrugManager.php'; // Ajustează calea către clasa DrugManager
class Database {
    public $error;
    private string $host = "127.0.0.1:3306";
    private string $db_name = "projectdb";
    private string $username = "root";
    private string $password = "";
    public PDO $conn;

    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch(PDOException $e) {
            $this->error=$e;
            echo "Connection failed to database: " . $e->getMessage();
        }
    }

    public function prepare($sql): bool|PDOStatement
    {
        return $this->conn->prepare($sql);
    }

}

?>
