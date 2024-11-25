<?php
// config/database.php
class Database {
    private $host = "localhost";
    private $database = "seu_banco";
    private $username = "seu_usuario";
    private $password = "sua_senha";
    private $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->database,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        } catch(PDOException $e) {
            echo "Erro de conexão: " . $e->getMessage();
        }

        return $this->conn;
    }
}