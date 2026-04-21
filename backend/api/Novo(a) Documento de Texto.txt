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

$idcliente = isset($_POST['idcliente']) ? (int) $_POST['idcliente'] : 0;
$idveiculo = isset($_POST['idveiculo']) ? (int) $_POST['idveiculo'] : 0;
$retirada = isset($_POST['retirada']) ? trim($_POST['retirada']) : '';
$devolucao = isset($_POST['devolucao']) ? trim($_POST['devolucao']) : '';
$local = isset($_POST['local']) ? trim($_POST['local']) : '';

if ($idcliente <= 0 || $idveiculo <= 0 || empty($retirada) || empty($devolucao) || empty($local)) {
    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'Todos os campos são obrigatórios.'
    ]);
    exit;
}

if ($devolucao <= $retirada) {
    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'A data de devolução deve ser maior que a data de retirada.'
    ]);
    exit;
}

/* verificar veículo */
$sqlVeiculo = "SELECT idveiculo, valor_diaria, disponivel FROM veiculos WHERE idveiculo = ?";
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
        'mensagem' => 'Este veículo não está disponível.'
    ]);
    exit;
}

/* calcular dias */
$dataRetiradaObj = new DateTime($retirada);
$dataDevolucaoObj = new DateTime($devolucao);
$intervalo = $dataRetiradaObj->diff($dataDevolucaoObj);
$qtdDias = (int)$intervalo->days;

if ($qtdDias <= 0) {
    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'Quantidade de dias inválida.'
    ]);
    exit;
}

$valorDiaria = (float)$veiculo['valor_diaria'];
$valorTotal = $valorDiaria * $qtdDias;

/* verificar conflito */
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
    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'Este veículo já possui aluguel ativo ou reservado.'
    ]);
    exit;
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
    $idaluguel = $stmtInsert->insert_id;

    $sqlAtualizaVeiculo = "UPDATE veiculos SET disponivel = 0, status_veiculo = 'Alugado' WHERE idveiculo = ?";
    $stmtAtualizaVeiculo = $conexao->prepare($sqlAtualizaVeiculo);
    $stmtAtualizaVeiculo->bind_param("i", $idveiculo);
    $stmtAtualizaVeiculo->execute();

    echo json_encode([
        'sucesso' => true,
        'mensagem' => 'Aluguel realizado com sucesso.',
        'aluguel' => [
            'idaluguel' => $idaluguel,
            'idcliente' => $idcliente,
            'idveiculo' => $idveiculo,
            'retirada' => $retirada,
            'devolucao' => $devolucao,
            'local' => $local,
            'qtd_dias' => $qtdDias,
            'valor_diaria' => $valorDiaria,
            'valor_total' => $valorTotal,
            'status' => 'Ativo',
            'pagamento' => 'Pendente'
        ]
    ]);
} else {
    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'Erro ao salvar aluguel.',
        'erro' => $stmtInsert->error
    ]);
}
?>