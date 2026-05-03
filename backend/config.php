<?php
// TEMPORÁRIO até criar banco online
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'alugacar';
$port = 3306;

$conexao = @new mysqli($dbHost, $dbUsername, $dbPassword, $dbName, $port);

if ($conexao->connect_error) {
    // não derruba a API, só retorna mensagem
    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Banco ainda não configurado"
    ]);
    exit;
}
?>