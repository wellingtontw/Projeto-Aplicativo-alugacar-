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

$idcliente = isset($_POST['idcliente']) ? intval($_POST['idcliente']) : 0;
$idveiculo = isset($_POST['idveiculo']) ? intval($_POST['idveiculo']) : 0;
$retirada = isset($_POST['retirada']) ? trim($_POST['retirada']) : '';
$devolucao = isset($_POST['devolucao']) ? trim($_POST['devolucao']) : '';
$local = isset($_POST['local']) ? trim($_POST['local']) : '';

if ($idcliente <= 0 || $idveiculo <= 0 || empty($retirada) || empty($devolucao) || empty($local)) {
    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'Dados obrigatórios não enviados.'
    ]);
    exit;
}

$sqlVeiculo = "SELECT valor_diaria, disponivel FROM veiculo WHERE idveiculo = ?";
$stmtVeiculo = $conexao->prepare($sqlVeiculo);
$stmtVeiculo->bind_param("i", $idveiculo);
$stmtVeiculo->execute();
$resultVeiculo = $stmtVeiculo->get_result();

if ($resultVeiculo->num_rows === 0) {
    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'Veículo não encontrado.'
    ]);
    exit;
}

$veiculo = $resultVeiculo->fetch_assoc();

if ((int)$veiculo['disponivel'] !== 1) {
    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'Veículo indisponível.'
    ]);
    exit;
}

$dataInicio = new DateTime($retirada);
$dataFim = new DateTime($devolucao);
$diferenca = $dataInicio->diff($dataFim)->days;

if ($diferenca <= 0) {
    $diferenca = 1;
}

$valorTotal = $diferenca * floatval($veiculo['valor_diaria']);

$sqlInsert = "INSERT INTO alugueis 
(idcliente, idveiculo, retirada, devolucao, local, valor_total, status, pagamento, statuspagamento, status_aluguel, custototalaluguel, datadeinicioaluguel, datafinalaluguel)
VALUES (?, ?, ?, ?, ?, ?, 'Ativo', 'Pendente', 'Pendente', 'Ativo', ?, ?, ?)";

$stmtInsert = $conexao->prepare($sqlInsert);
$stmtInsert->bind_param(
    "iisssdsss",
    $idcliente,
    $idveiculo,
    $retirada,
    $devolucao,
    $local,
    $valorTotal,
    $valorTotal,
    $retirada,
    $devolucao
);

if ($stmtInsert->execute()) {
    $sqlUpdate = "UPDATE veiculo SET disponivel = 0, status_veiculo = 'Alugado' WHERE idveiculo = ?";
    $stmtUpdate = $conexao->prepare($sqlUpdate);
    $stmtUpdate->bind_param("i", $idveiculo);
    $stmtUpdate->execute();

    echo json_encode([
        'sucesso' => true,
        'mensagem' => 'Aluguel realizado com sucesso.',
        'valor_total' => $valorTotal
    ]);
} else {
    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'Erro ao registrar aluguel.',
        'erro' => $conexao->error
    ]);
}
?>
