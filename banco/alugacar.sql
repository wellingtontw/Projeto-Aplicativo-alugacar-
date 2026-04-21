-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Tempo de geração: 21/04/2026 às 21:40
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `alugacar`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `administradores`
--

CREATE TABLE `administradores` (
  `idadmin` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `administradores`
--

INSERT INTO `administradores` (`idadmin`, `usuario`, `senha`, `nome`) VALUES
(1, '123', '321', 'Administrador Principal');

-- --------------------------------------------------------

--
-- Estrutura para tabela `alugueis`
--

CREATE TABLE `alugueis` (
  `idaluguel` int(11) NOT NULL,
  `idveiculo` int(11) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `statuspagamento` varchar(20) NOT NULL DEFAULT 'Pendente',
  `status_aluguel` varchar(30) NOT NULL DEFAULT 'Reservado',
  `custototalaluguel` decimal(10,2) NOT NULL,
  `datadeinicioaluguel` date NOT NULL,
  `datafinalaluguel` date NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `alugueis`
--

INSERT INTO `alugueis` (`idaluguel`, `idveiculo`, `idcliente`, `statuspagamento`, `status_aluguel`, `custototalaluguel`, `datadeinicioaluguel`, `datafinalaluguel`, `criado_em`) VALUES
(1, 1, 1, 'Pago', 'Finalizado', 350.00, '2025-05-01', '2025-05-05', '2026-04-19 17:28:24'),
(2, 2, 2, 'Pendente', 'Ativo', 420.50, '2025-05-10', '2025-05-14', '2026-04-19 17:28:24'),
(3, 3, 3, 'Pago', 'Finalizado', 280.75, '2025-05-15', '2025-05-17', '2026-04-19 17:28:24'),
(4, 1, 1, 'Pendente', 'Cancelado', 200.00, '2026-04-19', '2026-04-20', '2026-04-19 18:28:26'),
(5, 1, 1, 'Pendente', 'Cancelado', 200.00, '2026-04-19', '2026-04-20', '2026-04-19 18:32:25'),
(6, 1, 1, 'Pendente', 'Cancelado', 200.00, '2026-04-19', '2026-04-20', '2026-04-19 18:32:53'),
(7, 6, 1, 'Pendente', 'Cancelado', 250.00, '2026-04-19', '2026-04-20', '2026-04-19 19:12:42'),
(8, 5, 1, 'Pendente', 'Cancelado', 840.00, '2026-04-21', '2026-04-24', '2026-04-19 19:43:32'),
(9, 3, 2, 'Pendente', 'Ativo', 115.00, '2026-04-21', '2026-04-22', '2026-04-21 14:16:01'),
(10, 6, 1, 'Pendente', 'Cancelado', 500.00, '2026-04-21', '2026-04-23', '2026-04-21 17:13:03'),
(11, 5, 1, 'Pendente', 'Cancelado', 840.00, '2026-04-21', '2026-04-24', '2026-04-21 18:35:32'),
(12, 6, 1, 'Pendente', 'Cancelado', 1750.00, '2026-04-23', '2026-04-30', '2026-04-21 18:39:58'),
(13, 4, 1, 'Pendente', 'Cancelado', 220.00, '2026-04-21', '2026-04-22', '2026-04-21 18:40:03'),
(14, 1, 1, 'Pendente', 'Cancelado', 120.00, '2026-04-21', '2026-04-22', '2026-04-21 18:56:18');

-- --------------------------------------------------------

--
-- Estrutura para tabela `avaliacoes`
--

CREATE TABLE `avaliacoes` (
  `idavaliacao` int(11) NOT NULL,
  `idclienteavaliado` int(11) DEFAULT NULL,
  `classificacaocarro` int(11) DEFAULT NULL,
  `datavaliacao` date DEFAULT NULL,
  `comentariocliente` varchar(200) DEFAULT NULL,
  `comentarioavaliador` varchar(200) DEFAULT NULL,
  `idcliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `avaliacoes`
--

INSERT INTO `avaliacoes` (`idavaliacao`, `idclienteavaliado`, `classificacaocarro`, `datavaliacao`, `comentariocliente`, `comentarioavaliador`, `idcliente`) VALUES
(1, 1, 5, '2025-05-05', 'Carro excelente!', 'Obrigado pela avaliação.', 1),
(2, 2, 4, '2025-05-14', 'Bom carro, mas poderia ser mais novo.', 'Agradecemos o feedback.', 2),
(3, 3, 5, '2025-05-17', 'Ótimo custo-benefício.', 'Ficamos felizes que gostou!', 3);

-- --------------------------------------------------------

--
-- Estrutura para tabela `categoria`
--

CREATE TABLE `categoria` (
  `idcateg` int(11) NOT NULL,
  `descricao` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `categoria`
--

INSERT INTO `categoria` (`idcateg`, `descricao`) VALUES
(1, 'Compacto'),
(2, 'Sedan'),
(3, 'SUV');

-- --------------------------------------------------------

--
-- Estrutura para tabela `cliente`
--

CREATE TABLE `cliente` (
  `idcliente` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cpf` varchar(15) NOT NULL,
  `cnh` varchar(20) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `senha` varchar(255) NOT NULL,
  `habilitacao` date DEFAULT NULL,
  `endereco` varchar(200) DEFAULT NULL,
  `datnasc` date DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cliente`
--

INSERT INTO `cliente` (`idcliente`, `nome`, `cpf`, `cnh`, `telefone`, `email`, `senha`, `habilitacao`, `endereco`, `datnasc`, `criado_em`) VALUES
(1, 'João Silva', '123.456.789-00', '1234567890', '(11) 98765-4321', 'joao@alugacar.com', '123456', '2020-01-15', 'Rua das Flores, 123', '1985-05-20', '2026-04-19 17:28:24'),
(2, 'Maria Souza', '987.654.321-00', '0987654321', '(21) 91234-5678', 'maria@alugacar.com', '123456', '2018-08-10', 'Avenida Principal, 456', '1992-11-01', '2026-04-19 17:28:24'),
(3, 'Carlos Oliveira', '456.789.012-00', '5432109876', '(41) 99999-8888', 'carlos@alugacar.com', '123456', '2021-03-22', 'Travessa da Mata, 789', '1988-07-25', '2026-04-19 17:28:24');

-- --------------------------------------------------------

--
-- Estrutura para tabela `contrato`
--

CREATE TABLE `contrato` (
  `idcontrato` int(11) NOT NULL,
  `idaluguel` int(11) NOT NULL,
  `fracao` varchar(50) DEFAULT NULL,
  `adicionais` varchar(200) DEFAULT NULL,
  `despesas` decimal(10,2) DEFAULT NULL,
  `seguro` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `contrato`
--

INSERT INTO `contrato` (`idcontrato`, `idaluguel`, `fracao`, `adicionais`, `despesas`, `seguro`) VALUES
(1, 1, 'Integral', 'Seguro básico incluído', 15.00, 25.00),
(2, 2, 'Diária', 'Navegador GPS', 10.00, 30.00),
(3, 3, 'Fim de Semana', 'Cadeira de bebê', 5.00, 20.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `filiais`
--

CREATE TABLE `filiais` (
  `idfilial` int(11) NOT NULL,
  `cnpj` varchar(20) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `endereco` varchar(200) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `cnpj_matriz` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `filiais`
--

INSERT INTO `filiais` (`idfilial`, `cnpj`, `nome`, `endereco`, `telefone`, `email`, `cnpj_matriz`) VALUES
(61, '74389787000161', 'alugacarrio', 'Avenida Doutor Manoel Valente de Lima, 22, Cidade Universitária, Rio de Janeiro', '0800500400', 'alugacarrio@contato.com', '71882723000100'),
(62, '48825567000123', 'alugacarpr', 'Rua Emir Calluf, 2, Tarumã, Curitiba', '4535436688', 'alugacarpr@contato.com', '71882723000100'),
(63, '71882723000163', 'alugacarsp', '04860-000 - Rua Francisco Correia Vasques - Jardim São Rafael - São Paulo', '0800500400', 'alugacarsp@contato.com', '71882723000100');

-- --------------------------------------------------------

--
-- Estrutura para tabela `modelo`
--

CREATE TABLE `modelo` (
  `idmodelo` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `marca` varchar(50) NOT NULL,
  `descricao` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `modelo`
--

INSERT INTO `modelo` (`idmodelo`, `nome`, `marca`, `descricao`) VALUES
(101, 'Onix', 'Chevrolet', 'Hatch compacto popular'),
(102, 'HB20', 'Hyundai', 'Hatch compacto moderno'),
(103, 'Gol', 'Volkswagen', 'Hatch compacto tradicional'),
(104, 'Civic', 'Honda', 'Sedan confortável'),
(105, 'Ranger', 'Ford', 'Picape robusta'),
(106, 'Compass', 'Jeep', 'SUV premium');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pagamentos`
--

CREATE TABLE `pagamentos` (
  `idpagamento` int(11) NOT NULL,
  `idaluguelcliente` int(11) DEFAULT NULL,
  `datapag` date DEFAULT NULL,
  `valorpag` decimal(10,2) DEFAULT NULL,
  `metodopag` varchar(50) DEFAULT NULL,
  `idaluguel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pagamentos`
--

INSERT INTO `pagamentos` (`idpagamento`, `idaluguelcliente`, `datapag`, `valorpag`, `metodopag`, `idaluguel`) VALUES
(1, 1, '2025-05-01', 350.00, 'Cartão de Crédito', 1),
(2, 2, '2025-05-10', 200.00, 'Pix', 2),
(3, 3, '2025-05-17', 280.75, 'Boleto', 3);

-- --------------------------------------------------------

--
-- Estrutura para tabela `sit_alugacar`
--

CREATE TABLE `sit_alugacar` (
  `cnpj` varchar(20) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `endereco` varchar(200) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `sit_alugacar`
--

INSERT INTO `sit_alugacar` (`cnpj`, `nome`, `telefone`, `endereco`, `email`) VALUES
('71882723000100', 'AlugaCar Ltda.', '0800500400', '04860-000 - Rua Francisco Correia Vasques - Jardim São Rafael - São Paulo', 'contato@alugacar.com');

-- --------------------------------------------------------

--
-- Estrutura para tabela `veiculos`
--

CREATE TABLE `veiculos` (
  `idveiculo` int(11) NOT NULL,
  `placa` varchar(10) NOT NULL,
  `chassi` varchar(25) NOT NULL,
  `cor` varchar(20) DEFAULT NULL,
  `ano` int(11) DEFAULT NULL,
  `idmodelo` int(11) NOT NULL,
  `idfilial` int(11) NOT NULL,
  `idcateg` int(11) NOT NULL,
  `valor_diaria` decimal(10,2) NOT NULL DEFAULT 0.00,
  `imagem` varchar(255) DEFAULT NULL,
  `disponivel` tinyint(1) NOT NULL DEFAULT 1,
  `status_veiculo` varchar(30) NOT NULL DEFAULT 'Disponível'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `veiculos`
--

INSERT INTO `veiculos` (`idveiculo`, `placa`, `chassi`, `cor`, `ano`, `idmodelo`, `idfilial`, `idcateg`, `valor_diaria`, `imagem`, `disponivel`, `status_veiculo`) VALUES
(1, 'ABC1234', '12345678901234567890', 'Branco', 2023, 101, 63, 1, 120.00, 'imagens/cronos.jpg', 1, 'Disponível'),
(2, 'DEF5678', '09876543210987654321', 'Prata', 2022, 102, 61, 1, 130.00, 'imagens/creta.jpg', 1, 'Disponível'),
(3, 'GHI9012', 'ABCDEFGHIJ1234567890', 'Vermelho', 2024, 103, 62, 1, 115.00, 'imagens/cronos.jpg', 1, 'Disponível'),
(4, 'JKL3456', 'ZXCVBNMASDFGHJKL12345', 'Preto', 2023, 104, 63, 2, 220.00, 'imagens/creta.jpg', 1, 'Disponível'),
(5, 'MNO7890', 'QWERTYUIOPLKJHGFDSA12', 'Cinza', 2024, 105, 61, 3, 280.00, 'imagens/kwid.png', 1, 'Disponível'),
(6, 'PQR2468', 'LMNOPQRSTUVXWYZ123456', 'Azul', 2024, 106, 62, 3, 250.00, 'imagens/compass.png', 1, 'Disponível');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`idadmin`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- Índices de tabela `alugueis`
--
ALTER TABLE `alugueis`
  ADD PRIMARY KEY (`idaluguel`),
  ADD KEY `fk_aluguel_veiculo` (`idveiculo`),
  ADD KEY `fk_aluguel_cliente` (`idcliente`);

--
-- Índices de tabela `avaliacoes`
--
ALTER TABLE `avaliacoes`
  ADD PRIMARY KEY (`idavaliacao`),
  ADD KEY `fk_avaliacao_cliente` (`idcliente`);

--
-- Índices de tabela `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idcateg`);

--
-- Índices de tabela `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idcliente`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD UNIQUE KEY `cnh` (`cnh`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices de tabela `contrato`
--
ALTER TABLE `contrato`
  ADD PRIMARY KEY (`idcontrato`),
  ADD KEY `fk_contrato_aluguel` (`idaluguel`);

--
-- Índices de tabela `filiais`
--
ALTER TABLE `filiais`
  ADD PRIMARY KEY (`idfilial`),
  ADD UNIQUE KEY `cnpj` (`cnpj`),
  ADD KEY `fk_filial_matriz` (`cnpj_matriz`);

--
-- Índices de tabela `modelo`
--
ALTER TABLE `modelo`
  ADD PRIMARY KEY (`idmodelo`);

--
-- Índices de tabela `pagamentos`
--
ALTER TABLE `pagamentos`
  ADD PRIMARY KEY (`idpagamento`),
  ADD KEY `fk_pagamento_aluguel` (`idaluguel`);

--
-- Índices de tabela `sit_alugacar`
--
ALTER TABLE `sit_alugacar`
  ADD PRIMARY KEY (`cnpj`);

--
-- Índices de tabela `veiculos`
--
ALTER TABLE `veiculos`
  ADD PRIMARY KEY (`idveiculo`),
  ADD UNIQUE KEY `placa` (`placa`),
  ADD UNIQUE KEY `chassi` (`chassi`),
  ADD KEY `fk_veiculo_modelo` (`idmodelo`),
  ADD KEY `fk_veiculo_filial` (`idfilial`),
  ADD KEY `fk_veiculo_categoria` (`idcateg`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `administradores`
--
ALTER TABLE `administradores`
  MODIFY `idadmin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `alugueis`
--
ALTER TABLE `alugueis`
  MODIFY `idaluguel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `avaliacoes`
--
ALTER TABLE `avaliacoes`
  MODIFY `idavaliacao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idcliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `contrato`
--
ALTER TABLE `contrato`
  MODIFY `idcontrato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `pagamentos`
--
ALTER TABLE `pagamentos`
  MODIFY `idpagamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `veiculos`
--
ALTER TABLE `veiculos`
  MODIFY `idveiculo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `alugueis`
--
ALTER TABLE `alugueis`
  ADD CONSTRAINT `fk_aluguel_cliente` FOREIGN KEY (`idcliente`) REFERENCES `cliente` (`idcliente`),
  ADD CONSTRAINT `fk_aluguel_veiculo` FOREIGN KEY (`idveiculo`) REFERENCES `veiculos` (`idveiculo`);

--
-- Restrições para tabelas `avaliacoes`
--
ALTER TABLE `avaliacoes`
  ADD CONSTRAINT `fk_avaliacao_cliente` FOREIGN KEY (`idcliente`) REFERENCES `cliente` (`idcliente`);

--
-- Restrições para tabelas `contrato`
--
ALTER TABLE `contrato`
  ADD CONSTRAINT `fk_contrato_aluguel` FOREIGN KEY (`idaluguel`) REFERENCES `alugueis` (`idaluguel`);

--
-- Restrições para tabelas `filiais`
--
ALTER TABLE `filiais`
  ADD CONSTRAINT `fk_filial_matriz` FOREIGN KEY (`cnpj_matriz`) REFERENCES `sit_alugacar` (`cnpj`);

--
-- Restrições para tabelas `pagamentos`
--
ALTER TABLE `pagamentos`
  ADD CONSTRAINT `fk_pagamento_aluguel` FOREIGN KEY (`idaluguel`) REFERENCES `alugueis` (`idaluguel`);

--
-- Restrições para tabelas `veiculos`
--
ALTER TABLE `veiculos`
  ADD CONSTRAINT `fk_veiculo_categoria` FOREIGN KEY (`idcateg`) REFERENCES `categoria` (`idcateg`),
  ADD CONSTRAINT `fk_veiculo_filial` FOREIGN KEY (`idfilial`) REFERENCES `filiais` (`idfilial`),
  ADD CONSTRAINT `fk_veiculo_modelo` FOREIGN KEY (`idmodelo`) REFERENCES `modelo` (`idmodelo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
