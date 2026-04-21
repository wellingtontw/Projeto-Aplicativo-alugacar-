<?php
header('Content-Type: application/json; charset=utf-8');
include_once('../config.php');

/* buscar carros disponíveis */
$sql = "
SELECT 
    v.idveiculo,
    v.placa,
    v.cor,
    v.ano,
    v.valor_diaria,
    v.imagem,
    m.nome AS modelo,
    m.marca
FROM veiculos v
JOIN modelo m ON v.idmodelo = m.idmodelo
WHERE v.disponivel = 1
ORDER BY v.idveiculo ASC
";

$result = $conexao->query($sql);

$carros = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        $carros[] = [
            'idveiculo' => $row['idveiculo'],
            'nome' => $row['marca'] . ' ' . $row['modelo'],
            'placa' => $row['placa'],
            'cor' => $row['cor'],
            'ano' => $row['ano'],
            'valor_diaria' => (float)$row['valor_diaria'],
            'imagem' => !empty($row['imagem']) ? $row['imagem'] : null
        ];
    }
}

echo json_encode([
    'sucesso' => true,
    'total' => count($carros),
    'carros' => $carros
]);
?>