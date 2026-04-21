<?php
header('Content-Type: application/json; charset=utf-8');
include_once('../config.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'Método inválido. Use POST.'
    ]);
    exit;
}

$cpf = isset($_POST['cpf']) ? trim($_POST['cpf']) : '';
$senha = isset($_POST['senha']) ? trim($_POST['senha']) : '';

if (empty($cpf) || empty($senha)) {
    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'CPF e senha são obrigatórios.'
    ]);
    exit;
}

$sql = "SELECT idcliente, nome, cpf, email, telefone FROM cliente WHERE cpf = ? AND senha = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("ss", $cpf, $senha);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();

    echo json_encode([
        'sucesso' => true,
        'mensagem' => 'Login realizado com sucesso.',
        'cliente' => [
            'idcliente' => $usuario['idcliente'],
            'nome' => $usuario['nome'],
            'cpf' => $usuario['cpf'],
            'email' => $usuario['email'],
            'telefone' => $usuario['telefone']
        ]
    ]);
} else {
    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'CPF ou senha inválidos.'
    ]);
}
?>