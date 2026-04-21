<?php
session_start();
include_once('config.php');

if (!isset($_SESSION['idcliente'])) {
    header('Location: Login.html');
    exit;
}

$idcliente = $_SESSION['idcliente'];
$nomeCliente = isset($_SESSION['nome']) ? $_SESSION['nome'] : 'Cliente';

/* buscar carros disponíveis */
$sqlVeiculos = "
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

$resultVeiculos = $conexao->query($sqlVeiculos);

/* buscar alugueis do cliente logado */
$sqlAlugueis = "
SELECT 
    a.idaluguel,
    a.statuspagamento,
    a.status_aluguel,
    a.custototalaluguel,
    a.datadeinicioaluguel,
    a.datafinalaluguel,
    v.idveiculo,
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

$stmtAlugueis = $conexao->prepare($sqlAlugueis);
$stmtAlugueis->bind_param("i", $idcliente);
$stmtAlugueis->execute();
$resultAlugueis = $stmtAlugueis->get_result();

/* função para imagem */
function obterImagemCarro($modelo, $imagemBanco) {
    if (!empty($imagemBanco) && file_exists($imagemBanco)) {
        return $imagemBanco;
    }

    $modeloLower = mb_strtolower($modelo);

    if (strpos($modeloLower, 'onix') !== false) return './images/carro1.jpg';
    if (strpos($modeloLower, 'hb20') !== false) return './images/carro2.jpg';
    if (strpos($modeloLower, 'gol') !== false) return './images/carro1.jpg';
    if (strpos($modeloLower, 'civic') !== false) return './images/carro2.jpg';
    if (strpos($modeloLower, 'ranger') !== false) return './images/carro1.jpg';
    if (strpos($modeloLower, 'compass') !== false) return './images/carro2.jpg';

    return './images/carro1.jpg';
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AlugaCar | Área do Cliente</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #000;
      color: #fff;
    }

    a {
      color: #b366ff;
      text-decoration: none;
      font-weight: bold;
    }

    .nav-topo {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 20px;
      border-bottom: 1px solid #666;
      flex-wrap: wrap;
      gap: 10px;
    }

    .nav-links a {
      margin-right: 20px;
    }

    .topo-cliente {
      margin: 20px;
      padding: 15px;
      border-radius: 10px;
      border: 1px solid #888;
      font-size: 22px;
      font-weight: bold;
      color: #fff;
      background: rgba(255,255,255,0.03);
    }

    .secao-principal {
      padding: 20px;
    }

    .titulo-secao {
      margin-bottom: 15px;
      font-size: 28px;
      font-weight: bold;
      color: #fff;
    }

    .layout-reserva {
      display: flex;
      gap: 20px;
      align-items: flex-start;
      flex-wrap: wrap;
    }

    .coluna-carros {
      flex: 2;
      min-width: 320px;
    }

    .coluna-reserva {
      flex: 1;
      min-width: 320px;
    }

    .grid-carros {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
    }

    .card-carro {
      width: 280px;
      border: 1px solid #aaa;
      border-radius: 12px;
      overflow: hidden;
      padding: 12px;
      background: #111;
      color: #fff;
    }

    .card-carro img {
      width: 100%;
      height: 180px;
      object-fit: cover;
      border-radius: 8px;
      display: block;
      background: #222;
    }

    .nome-carro {
      margin-top: 12px;
      font-size: 20px;
      font-weight: bold;
      color: #fff;
    }

    .detalhes-carro {
      margin-top: 8px;
      line-height: 1.8;
      font-size: 15px;
      color: #fff;
    }

    .detalhes-carro strong {
      color: #ff5c5c;
    }

    .btn-escolher {
      margin-top: 12px;
      padding: 10px 14px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-weight: bold;
      background: #fff;
      color: #000;
    }

    .box-reserva {
      border: 1px solid #aaa;
      border-radius: 12px;
      padding: 20px;
      display: none;
      background: #111;
      color: #fff;
    }

    .box-reserva h3 {
      margin-top: 0;
      font-size: 26px;
      color: #fff;
    }

    .box-reserva p,
    .box-reserva label {
      color: #fff;
    }

    .box-reserva label {
      display: block;
      margin-top: 12px;
      margin-bottom: 6px;
      font-weight: bold;
    }

    .box-reserva input {
      width: 100%;
      padding: 12px;
      border-radius: 8px;
      border: 1px solid #888;
      background: #fff;
      color: #000;
    }

    .box-reserva button {
      margin-top: 18px;
      width: 100%;
      padding: 12px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-weight: bold;
      font-size: 16px;
      background: #fff;
      color: #000;
    }

    .erro {
      margin-top: 10px;
      color: #ff5c5c;
      display: none;
    }

    .secao-alugueis {
      margin: 30px 20px;
      padding: 20px;
      border: 1px solid #888;
      border-radius: 12px;
      background: #111;
      color: #fff;
    }

    .secao-alugueis h2 {
      margin-top: 0;
      font-size: 28px;
      color: #fff;
    }

    .card-aluguel {
      border: 1px solid #666;
      border-radius: 10px;
      padding: 15px;
      margin-bottom: 15px;
      line-height: 1.9;
      background: #181818;
      color: #fff;
    }

    .card-aluguel strong {
      color: #ff5c5c;
    }

    .sem-carros {
      padding: 20px;
      border: 1px dashed #888;
      border-radius: 10px;
      color: #fff;
    }

    @media (max-width: 900px) {
      .layout-reserva {
        flex-direction: column;
      }

      .card-carro {
        width: 100%;
      }
    }
  </style>
</head>
<body>

  <div class="nav-topo">
    <div class="nav-links">
      <a href="#carros">Carros disponíveis</a>
      <a href="#meus-alugueis">Meus Aluguéis</a>
    </div>

    <div class="acoes-topo">
      <a href="Login.html">Sair</a>
    </div>
  </div>

  <div class="topo-cliente">
    Olá, <?php echo htmlspecialchars($nomeCliente); ?>!
  </div>

  <section class="secao-principal" id="carros">
    <div class="titulo-secao">Carros disponíveis</div>

    <div class="layout-reserva">
      <div class="coluna-carros">
        <div class="grid-carros">
          <?php if ($resultVeiculos && $resultVeiculos->num_rows > 0): ?>
            <?php while ($veiculo = $resultVeiculos->fetch_assoc()): ?>
              <?php
                $nomeCompleto = $veiculo['marca'] . ' ' . $veiculo['modelo'];
                $imagemFinal = obterImagemCarro($veiculo['modelo'], $veiculo['imagem']);
              ?>
              <div class="card-carro">
                <img src="<?php echo htmlspecialchars($imagemFinal); ?>" alt="<?php echo htmlspecialchars($nomeCompleto); ?>">

                <div class="nome-carro">
                  <?php echo htmlspecialchars($nomeCompleto); ?>
                </div>

                <div class="detalhes-carro">
                  <strong>Placa:</strong> <?php echo htmlspecialchars($veiculo['placa']); ?><br>
                  <strong>Cor:</strong> <?php echo htmlspecialchars($veiculo['cor']); ?><br>
                  <strong>Ano:</strong> <?php echo htmlspecialchars($veiculo['ano']); ?><br>
                  <strong>Valor diária:</strong> R$ <?php echo number_format($veiculo['valor_diaria'], 2, ',', '.'); ?>
                </div>

                <button
                  type="button"
                  class="btn-escolher selecionar-carro"
                  data-id="<?php echo $veiculo['idveiculo']; ?>"
                  data-carro="<?php echo htmlspecialchars($nomeCompleto); ?>">
                  Escolher
                </button>
              </div>
            <?php endwhile; ?>
          <?php else: ?>
            <div class="sem-carros">
              Nenhum carro disponível no momento.
            </div>
          <?php endif; ?>
        </div>
      </div>

      <div class="coluna-reserva">
        <div class="box-reserva" id="boxReserva">
          <h3>Faça sua reserva</h3>
          <p id="carroSelecionado" style="font-weight: bold;"></p>

          <form id="formReserva" action="alugar_carro.php" method="POST">
            <input type="hidden" id="idveiculo" name="idveiculo">

            <label for="retirada">Retirada:</label>
            <input type="date" id="retirada" name="retirada" required>

            <label for="devolucao">Devolução:</label>
            <input type="date" id="devolucao" name="devolucao" required>

            <label for="local">Local:</label>
            <input type="text" id="local" name="local" placeholder="Cidade ou aeroporto" required>

            <div class="erro" id="erroDatas">
              A devolução deve ser após a retirada.
            </div>

            <button type="submit">Confirmar Aluguel</button>
          </form>
        </div>
      </div>
    </div>
  </section>

  <section class="secao-alugueis" id="meus-alugueis">
    <h2>Meus Aluguéis</h2>

    <?php if ($resultAlugueis->num_rows > 0): ?>
      <?php while ($row = $resultAlugueis->fetch_assoc()): ?>
        <div class="card-aluguel">
          <strong>Carro:</strong> <?php echo htmlspecialchars($row['marca'] . ' ' . $row['modelo']); ?><br>
          <strong>Placa:</strong> <?php echo htmlspecialchars($row['placa']); ?><br>
          <strong>Cor:</strong> <?php echo htmlspecialchars($row['cor']); ?><br>
          <strong>Ano:</strong> <?php echo htmlspecialchars($row['ano']); ?><br>
          <strong>Retirada:</strong> <?php echo htmlspecialchars($row['datadeinicioaluguel']); ?><br>
          <strong>Devolução:</strong> <?php echo htmlspecialchars($row['datafinalaluguel']); ?><br>
          <strong>Status do aluguel:</strong> <?php echo htmlspecialchars($row['status_aluguel']); ?><br>
          <strong>Status do pagamento:</strong> <?php echo htmlspecialchars($row['statuspagamento']); ?><br>
          <strong>Valor:</strong> R$ <?php echo number_format($row['custototalaluguel'], 2, ',', '.'); ?><br>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p>Você ainda não alugou nenhum carro.</p>
    <?php endif; ?>
  </section>

  <script>
    function formatDate(date) {
      return date.toISOString().split('T')[0];
    }

    document.addEventListener('DOMContentLoaded', () => {
      const hoje = new Date();
      const amanha = new Date(hoje);
      amanha.setDate(hoje.getDate() + 1);

      const retirada = document.getElementById('retirada');
      const devolucao = document.getElementById('devolucao');
      const erroDatas = document.getElementById('erroDatas');
      const form = document.getElementById('formReserva');
      const boxReserva = document.getElementById('boxReserva');

      retirada.value = formatDate(hoje);
      retirada.min = formatDate(hoje);

      devolucao.value = formatDate(amanha);
      devolucao.min = formatDate(amanha);

      retirada.addEventListener('change', () => {
        const novaRetirada = new Date(retirada.value);
        const novaDevolucaoMin = new Date(novaRetirada);
        novaDevolucaoMin.setDate(novaDevolucaoMin.getDate() + 1);

        devolucao.min = formatDate(novaDevolucaoMin);

        if (new Date(devolucao.value) < novaDevolucaoMin) {
          devolucao.value = formatDate(novaDevolucaoMin);
        }
      });

      form.addEventListener('submit', function(event) {
        const dataRetirada = new Date(retirada.value);
        const dataDevolucao = new Date(devolucao.value);

        if (dataDevolucao <= dataRetirada) {
          event.preventDefault();
          erroDatas.style.display = 'block';
        } else {
          erroDatas.style.display = 'none';
        }
      });

      const botoesCarros = document.querySelectorAll('.selecionar-carro');

      botoesCarros.forEach(botao => {
        botao.addEventListener('click', () => {
          const nomeCarro = botao.getAttribute('data-carro');
          const idCarro = botao.getAttribute('data-id');

          document.getElementById('idveiculo').value = idCarro;
          document.getElementById('carroSelecionado').textContent = `Carro selecionado: ${nomeCarro}`;
          boxReserva.style.display = 'block';

          boxReserva.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
      });
    });
  </script>

</body>
</html>