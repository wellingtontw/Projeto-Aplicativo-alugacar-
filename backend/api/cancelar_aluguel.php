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

$idaluguel = isset($_POST['idaluguel']) ? (int) $_POST['idaluguel'] : 0;

if ($idaluguel <= 0) {
    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'ID do aluguel inválido.'
    ]);
    exit;
}

/* buscar aluguel */
$sqlBusca = "SELECT idveiculo, status_aluguel FROM alugueis WHERE idaluguel = ?";
$stmtBusca = $conexao->prepare($sqlBusca);
$stmtBusca->bind_param("i", $idaluguel);
$stmtBusca->execute();
$resultBusca = $stmtBusca->get_result();

if ($resultBusca->num_rows === 0) {
    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'Aluguel não encontrado.'
    ]);
    exit;
}

$aluguel = $resultBusca->fetch_assoc();
$idveiculo = (int)$aluguel['idveiculo'];

if ($aluguel['status_aluguel'] === 'Cancelado') {
    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'Este aluguel já foi cancelado.'
    ]);
    exit;
}

/* cancelar aluguel */
$sqlUpdate = "UPDATE alugueis SET status_aluguel = 'Cancelado' WHERE idaluguel = ?";
$stmtUpdate = $conexao->prepare($sqlUpdate);
$stmtUpdate->bind_param("i", $idaluguel);

if ($stmtUpdate->execute()) {
    /* liberar veículo novamente */
    $sqlVeiculo = "UPDATE veiculos SET disponivel = 1, status_veiculo = 'Disponível' WHERE idveiculo = ?";
    $stmtVeiculo = $conexao->prepare($sqlVeiculo);
    $stmtVeiculo->bind_param("i", $idveiculo);
    $stmtVeiculo->execute();

    echo json_encode([
        'sucesso' => true,
        'mensagem' => 'Aluguel cancelado com sucesso.'
    ]);
} else {
    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'Erro ao cancelar aluguel.'
    ]);
}
?>