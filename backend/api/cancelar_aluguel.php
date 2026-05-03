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

$idaluguel = isset($_POST['idaluguel']) ? intval($_POST['idaluguel']) : 0;

if ($idaluguel <= 0) {
    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'ID do aluguel inválido.'
    ]);
    exit;
}

$sqlBusca = "SELECT idveiculo FROM alugueis WHERE idaluguel = ?";
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
$idveiculo = intval($aluguel['idveiculo']);

$sqlCancela = "UPDATE alugueis 
               SET status = 'Cancelado',
                   status_aluguel = 'Cancelado'
               WHERE idaluguel = ?";

$stmtCancela = $conexao->prepare($sqlCancela);
$stmtCancela->bind_param("i", $idaluguel);

if (!$stmtCancela->execute()) {
    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'Erro ao cancelar aluguel.',
        'erro' => $conexao->error
    ]);
    exit;
}

$sqlVeiculo = "UPDATE veiculo 
               SET disponivel = 1,
                   status_veiculo = 'Disponível'
               WHERE idveiculo = ?";

$stmtVeiculo = $conexao->prepare($sqlVeiculo);
$stmtVeiculo->bind_param("i", $idveiculo);
$stmtVeiculo->execute();

echo json_encode([
    'sucesso' => true,
    'mensagem' => 'Aluguel cancelado com sucesso.'
]);
?>
