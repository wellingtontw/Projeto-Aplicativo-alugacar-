<?php
header('Content-Type: application/json; charset=utf-8');
include_once('../config.php');

$idcliente = isset($_GET['idcliente']) ? intval($_GET['idcliente']) : 0;

if ($idcliente <= 0) {
    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'Cliente inválido.'
    ]);
    exit;
}

$sql = "SELECT 
            a.idaluguel,
            a.idcliente,
            a.idveiculo,
            a.retirada,
            a.devolucao,
            a.local,
            a.valor_total,
            a.status,
            a.pagamento,
            v.nome AS carro,
            v.placa
        FROM alugueis a
        INNER JOIN veiculo v ON a.idveiculo = v.idveiculo
        WHERE a.idcliente = ?
        ORDER BY a.idaluguel DESC";

$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $idcliente);
$stmt->execute();
$result = $stmt->get_result();

$alugueis = [];

while ($row = $result->fetch_assoc()) {
    $alugueis[] = [
        'idaluguel' => $row['idaluguel'],
        'idcliente' => $row['idcliente'],
        'idveiculo' => $row['idveiculo'],
        'carro' => $row['carro'],
        'placa' => $row['placa'],
        'retirada' => $row['retirada'],
        'devolucao' => $row['devolucao'],
        'local' => $row['local'],
        'valor_total' => $row['valor_total'],
        'status' => $row['status'],
        'pagamento' => $row['pagamento']
    ];
}

echo json_encode([
    'sucesso' => true,
    'total' => count($alugueis),
    'alugueis' => $alugueis
]);
?>
