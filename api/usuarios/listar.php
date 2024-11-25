// api/usuarios/listar.php
<?php
include_once '../../config/database.php';
include_once '../../models/Usuario.php';
include_once '../cors.php';

$database = new Database();
$db = $database->getConnection();

$usuario = new Usuario($db);
$stmt = $usuario->listar();
$num = $stmt->rowCount();

if($num > 0) {
    $usuarios_arr = array();
    $usuarios_arr["registros"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $usuario_item = array(
            "id" => $id,
            "nome" => $nome,
            "email" => $email
        );
        array_push($usuarios_arr["registros"], $usuario_item);
    }

    http_response_code(200);
    echo json_encode($usuarios_arr);
} else {
    http_response_code(404);
    echo json_encode(array("mensagem" => "Nenhum usuário encontrado."));
}