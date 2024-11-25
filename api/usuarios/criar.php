// api/usuarios/criar.php
<?php
include_once '../../config/database.php';
include_once '../../models/Usuario.php';
include_once '../cors.php';

$database = new Database();
$db = $database->getConnection();

$usuario = new Usuario($db);

$data = json_decode(file_get_contents("php://input"));

if(!empty($data->nome) && !empty($data->email) && !empty($data->senha)) {
    $usuario->nome = $data->nome;
    $usuario->email = $data->email;
    $usuario->senha = password_hash($data->senha, PASSWORD_DEFAULT);

    if($usuario->criar()) {
        http_response_code(201);
        echo json_encode(array("mensagem" => "Usuário criado com sucesso."));
    } else {
        http_response_code(503);
        echo json_encode(array("mensagem" => "Não foi possível criar o usuário."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("mensagem" => "Dados incompletos."));
}
