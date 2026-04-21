<?php
header('Content-Type: application/json; charset=utf-8');
include_once('../config.php');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'Método inválido. Use GET.'
    ]);
    exit;
}

$idcliente = isset($_GET['idcliente']) ? (int) $_GET['idcliente'] : 0;

if ($idcliente <= 0) {
    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'ID do cliente inválido.'
    ]);
    exit;
}

$sql = "
SELECT 
    a.idaluguel,
    a.statuspagamento,
    a.status_aluguel,
    a.custototalaluguel,
    a.datadeinicioaluguel,
    a.datafinalaluguel,
    v.placa,
    v.cor,
    v.ano,
    m.nome AS modelo,
    m.marca
FROM alugueis a
JOIN veiculos v ON a.idveiculo = v.idveiculo
JOIN modelo m ON v.idmodelo = m.idmodelo
WHERE a.idcliente = ?
ORDER BY a.idaluguel DESC
";

$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $idcliente);
$stmt->execute();
$result = $stmt->get_result();

$alugueis = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $alugueis[] = [
            'idaluguel' => $row['idaluguel'],
            'carro' => $row['marca'] . ' ' . $row['modelo'],
            'placa' => $row['placa'],
            'cor' => $row['cor'],
            'ano' => $row['ano'],
            'retirada' => $row['datadeinicioaluguel'],
            'devolucao' => $row['datafinalaluguel'],
            'status' => $row['status_aluguel'],
            'pagamento' => $row['statuspagamento'],
            'valor_total' => (float)$row['custototalaluguel']
        ];
    }
}

echo json_encode([
    'sucesso' => true,
    'total' => count($alugueis),
    'alugueis' => $alugueis
]);
?>