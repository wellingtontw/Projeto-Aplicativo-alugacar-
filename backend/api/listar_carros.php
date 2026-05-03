<?php
header('Content-Type: application/json; charset=utf-8');
include_once('../config.php');

$sql = "SELECT 
            idveiculo,
            nome,
            placa,
            cor,
            ano,
            valor_diaria,
            imagem
        FROM veiculo";

$result = $conexao->query($sql);

if (!$result) {
    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'Erro ao buscar carros.',
        'erro_sql' => $conexao->error
    ]);
    exit;
}

$carros = [];

while ($row = $result->fetch_assoc()) {
    $carros[] = [
        'idveiculo' => $row['idveiculo'],
        'nome' => $row['nome'],
        'placa' => $row['placa'],
        'cor' => $row['cor'],
        'ano' => $row['ano'],
        'valor_diaria' => (float)$row['valor_diaria'],
        'imagem' => $row['imagem']
    ];
}

echo json_encode([
    'sucesso' => true,
    'total' => count($carros),
    'carros' => $carros
]);
?>
