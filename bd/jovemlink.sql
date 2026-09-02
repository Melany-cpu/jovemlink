-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 19/08/2026 às 19:59
-- Versão do servidor: 8.4.8
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `jovemlink`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `candidato`
--

CREATE TABLE `candidato` (
  `idCandidato` int NOT NULL,
  `fotoUsuario` varchar(255) DEFAULT NULL,
  `dataNascimentoUsuario` date DEFAULT NULL,
  `nomeUsuario` varchar(100) DEFAULT NULL,
  `cpfUsuario` varchar(14) DEFAULT NULL,
  `emailUsuario` varchar(100) DEFAULT NULL,
  `estadoUsuario` varchar(50) DEFAULT NULL,
  `cidadeUsuario` varchar(50) DEFAULT NULL,
  `senhaUsuario` varchar(255) DEFAULT NULL,
  `nivelUsuario` int DEFAULT NULL,
  `dataCadastro` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `candidatura`
--

CREATE TABLE `candidatura` (
  `idCandidatura` int NOT NULL,
  `idCandidato` int NOT NULL,
  `idVaga` int NOT NULL,
  `dataCandidatura` datetime DEFAULT CURRENT_TIMESTAMP,
  `statusCandidatura` varchar(50) DEFAULT 'Em Análise'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `empresa`
--

CREATE TABLE `empresa` (
  `idEmpresa` int NOT NULL,
  `fotoEmpresa` varchar(255) DEFAULT NULL,
  `nomeEmpresa` varchar(250) NOT NULL,
  `razaoSocialEmpresa` varchar(250) NOT NULL,
  `dataFundacaoEmpresa` date DEFAULT NULL,
  `cnpjEmpresa` varchar(20) NOT NULL,
  `estadoEmpresa` varchar(2) DEFAULT NULL,
  `cidadeEmpresa` varchar(100) DEFAULT NULL,
  `emailEmpresa` varchar(150) NOT NULL,
  `senhaEmpresa` varchar(255) NOT NULL,
  `dataCadastro` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int NOT NULL,
  `fotoUsuario` varchar(255) NOT NULL,
  `dataNascimentoUsuario` date NOT NULL,
  `nomeUsuario` varchar(100) NOT NULL,
  `cpfUsuario` varchar(14) NOT NULL,
  `emailUsuario` varchar(100) NOT NULL,
  `estadoUsuario` varchar(50) NOT NULL,
  `cidadeUsuario` varchar(50) NOT NULL,
  `senhaUsuario` varchar(32) NOT NULL,
  `confirmarSenhaUsuario` varchar(32) NOT NULL,
  `nivelUsuario` varchar(20) DEFAULT 'usuario',
  `dataCadastro` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `fotoUsuario`, `dataNascimentoUsuario`, `nomeUsuario`, `cpfUsuario`, `emailUsuario`, `estadoUsuario`, `cidadeUsuario`, `senhaUsuario`, `confirmarSenhaUsuario`, `nivelUsuario`, `dataCadastro`) VALUES
(1, 'assets/img/elisregina26.jpg', '0200-03-12', 'mel', '34243423432', 'mel@gmail.com', 'PR', 'imbau', '202cb962ac59075b964b07152d234b70', '202cb962ac59075b964b07152d234b70', 'usuario', '2026-08-19 17:34:46'),
(2, 'assets/img/Captura de tela 2026-08-17 161940.png', '2026-08-22', 'mnel', '31244343424', 'mnel@gmail.com', 'PR', 'imbau', '202cb962ac59075b964b07152d234b70', '202cb962ac59075b964b07152d234b70', 'usuario', '2026-08-19 17:42:07'),
(3, 'assets/img/Captura de tela 2026-03-17 114552.png', '2026-08-08', 'sara', '32424342343', 'sara@gmail.com', 'PR', 'imbau', '202cb962ac59075b964b07152d234b70', '202cb962ac59075b964b07152d234b70', 'usuario', '2026-08-19 17:55:36');

-- --------------------------------------------------------

--
-- Estrutura para tabela `vaga`
--

CREATE TABLE `vaga` (
  `idVaga` int NOT NULL,
  `idEmpresa` int NOT NULL,
  `tituloVaga` varchar(200) NOT NULL,
  `descricaoVaga` text NOT NULL,
  `requisitosVaga` text,
  `modalidadeVaga` varchar(50) DEFAULT 'Presencial',
  `salarioVaga` decimal(10,2) DEFAULT NULL,
  `cidadeVaga` varchar(100) DEFAULT NULL,
  `estadoVaga` varchar(2) DEFAULT NULL,
  `statusVaga` varchar(20) DEFAULT 'Ativa',
  `dataCriacao` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `candidato`
--
ALTER TABLE `candidato`
  ADD PRIMARY KEY (`idCandidato`),
  ADD UNIQUE KEY `cpfCandidato` (`cpfUsuario`),
  ADD UNIQUE KEY `emailCandidato` (`emailUsuario`);

--
-- Índices de tabela `candidatura`
--
ALTER TABLE `candidatura`
  ADD PRIMARY KEY (`idCandidatura`),
  ADD KEY `fk_candidatura_candidato` (`idCandidato`),
  ADD KEY `fk_candidatura_vaga` (`idVaga`);

--
-- Índices de tabela `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`idEmpresa`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`);

--
-- Índices de tabela `vaga`
--
ALTER TABLE `vaga`
  ADD PRIMARY KEY (`idVaga`),
  ADD KEY `fk_vaga_empresa` (`idEmpresa`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `candidato`
--
ALTER TABLE `candidato`
  MODIFY `idCandidato` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `candidatura`
--
ALTER TABLE `candidatura`
  MODIFY `idCandidatura` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `empresa`
--
ALTER TABLE `empresa`
  MODIFY `idEmpresa` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `vaga`
--
ALTER TABLE `vaga`
  MODIFY `idVaga` int NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `candidatura`
--
ALTER TABLE `candidatura`
  ADD CONSTRAINT `fk_candidatura_candidato` FOREIGN KEY (`idCandidato`) REFERENCES `candidato` (`idCandidato`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_candidatura_vaga` FOREIGN KEY (`idVaga`) REFERENCES `vaga` (`idVaga`) ON DELETE CASCADE;

--
-- Restrições para tabelas `vaga`
--
ALTER TABLE `vaga`
  ADD CONSTRAINT `fk_vaga_empresa` FOREIGN KEY (`idEmpresa`) REFERENCES `empresa` (`idEmpresa`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
