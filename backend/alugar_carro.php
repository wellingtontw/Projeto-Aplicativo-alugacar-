<?php
session_start();
include_once('config.php');

if (!isset($_SESSION['idcliente'])) {
    die("Usuário não está logado.");
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Requisição inválida.");
}

$idcliente = $_SESSION['idcliente'];

$idveiculo = isset($_POST['idveiculo']) ? (int) $_POST['idveiculo'] : 0;
$retirada = isset($_POST['retirada']) ? $_POST['retirada'] : '';
$devolucao = isset($_POST['devolucao']) ? $_POST['devolucao'] : '';
$local = isset($_POST['local']) ? trim($_POST['local']) : '';

if ($idveiculo <= 0 || empty($retirada) || empty($devolucao) || empty($local)) {
    die("Preencha todos os campos.");
}

if ($devolucao <= $retirada) {
    die("A data de devolução deve ser maior que a data de retirada.");
}

/* verificar se o veículo existe e está disponível */
$sqlVeiculo = "SELECT idveiculo, valor_diaria, disponivel FROM veiculos WHERE idveiculo = ?";
$stmtVeiculo = $conexao->prepare($sqlVeiculo);
$stmtVeiculo->bind_param("i", $idveiculo);
$stmtVeiculo->execute();
$resultVeiculo = $stmtVeiculo->get_result();

if ($resultVeiculo->num_rows === 0) {
    die("Veículo não encontrado.");
}

$veiculo = $resultVeiculo->fetch_assoc();

if ((int)$veiculo['disponivel'] !== 1) {
    die("Este veículo não está mais disponível.");
}

/* calcular quantidade de dias */
$dataRetiradaObj = new DateTime($retirada);
$dataDevolucaoObj = new DateTime($devolucao);
$intervalo = $dataRetiradaObj->diff($dataDevolucaoObj);
$qtdDias = (int)$intervalo->days;

if ($qtdDias <= 0) {
    die("A quantidade de dias do aluguel é inválida.");
}

$valorDiaria = (float)$veiculo['valor_diaria'];
$valorTotal = $valorDiaria * $qtdDias;

/* evitar conflito: verificar se já existe aluguel ativo para esse veículo */
$sqlConflito = "
SELECT idaluguel 
FROM alugueis
WHERE idveiculo = ?
AND status_aluguel IN ('Reservado', 'Ativo')
LIMIT 1
";

$stmtConflito = $conexao->prepare($sqlConflito);
$stmtConflito->bind_param("i", $idveiculo);
$stmtConflito->execute();
$resultConflito = $stmtConflito->get_result();

if ($resultConflito->num_rows > 0) {
    die("Este veículo já possui um aluguel ativo ou reservado.");
}

/* inserir aluguel */
$sqlInsert = "
INSERT INTO alugueis
(idveiculo, idcliente, statuspagamento, status_aluguel, custototalaluguel, datadeinicioaluguel, datafinalaluguel)
VALUES (?, ?, 'Pendente', 'Ativo', ?, ?, ?)
";

$stmtInsert = $conexao->prepare($sqlInsert);
$stmtInsert->bind_param("iidss", $idveiculo, $idcliente, $valorTotal, $retirada, $devolucao);

if ($stmtInsert->execute()) {
    $sqlAtualizaVeiculo = "UPDATE veiculos SET disponivel = 0, status_veiculo = 'Alugado' WHERE idveiculo = ?";
    $stmtAtualizaVeiculo = $conexao->prepare($sqlAtualizaVeiculo);
    $stmtAtualizaVeiculo->bind_param("i", $idveiculo);
    $stmtAtualizaVeiculo->execute();

    header("Location: PaginaUsuario.php");
    exit;
} else {
    echo "Erro ao salvar aluguel: " . $stmtInsert->error;
}
?>