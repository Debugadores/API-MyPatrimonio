// models/Usuario.php
<?php
class Usuario {
    private $conn;
    private $tableName = "users";

    // Propriedades correspondentes às colunas do banco de dados
    public $id;
    public $nome;
    public $usuario;
    public $email;
    public $password;
    public $telefone;
    public $genero;
    public $status;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para criar novo usuário
    public function criar() {
        $query = "INSERT INTO " . $this->tableName . " 
                  SET nome = :nome, 
                      usuario = :usuario, 
                      email = :email, 
                      password = :password, 
                      telefone = :telefone, 
                      genero = :genero, 
                      status = :status, 
                      created_at = :created_at";

        $stmt = $this->conn->prepare($query);

        // Sanitizar e processar dados
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->usuario = htmlspecialchars(strip_tags($this->usuario));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = password_hash(htmlspecialchars(strip_tags($this->password)), PASSWORD_DEFAULT);
        $this->telefone = htmlspecialchars(strip_tags($this->telefone));
        $this->genero = htmlspecialchars(strip_tags($this->genero));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->created_at = date('Y-m-d H:i:s');

        // Bind dos valores
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":usuario", $this->usuario);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":telefone", $this->telefone);
        $stmt->bindParam(":genero", $this->genero);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":created_at", $this->created_at);

        // Execução
        if ($stmt->execute()) {
            return true;
        }

        // Log de erros
        error_log("Erro ao criar usuário: " . implode(", ", $stmt->errorInfo()));

        return false;
    }

    // Método para listar usuários
    public function listar() {
        $query = "SELECT id, nome, usuario, email, telefone, genero, status, created_at 
                  FROM " . $this->tableName;

        $stmt = $this->conn->prepare($query);

        if ($stmt->execute()) {
            return $stmt;
        }

        // Log de erros
        error_log("Erro ao listar usuários: " . implode(", ", $stmt->errorInfo()));

        return false;
    }
}
?>
