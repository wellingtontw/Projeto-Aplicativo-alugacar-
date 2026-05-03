<?php
mysqli_report(MYSQLI_REPORT_OFF);

$dbHost = 'tramway.proxy.rlwy.net';
$dbUsername = 'root';
$dbPassword = 'usJugAuzsSNpkGEAroRWEQVCtWdycOls';
$dbName = 'railway';
$port = 28070;

$conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName, $port);

if ($conexao->connect_error) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Erro ao conectar no banco de dados.",
        "erro" => $conexao->connect_error
    ]);
    exit;
}
?>