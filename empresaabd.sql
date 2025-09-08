-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 08/06/2025 às 23:32
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
-- Banco de dados: `empresaabd`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `funcionarios`
--

CREATE TABLE `funcionarios` (
  `idFunc` int(11) NOT NULL,
  `nickname` varchar(50) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `funcao` enum('gerente','funcionario','repositor') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `funcionarios`
--

INSERT INTO `funcionarios` (`idFunc`, `nickname`, `senha`, `nome`, `email`, `funcao`) VALUES
(1, 'admin', '$2y$10$dzwXP3oxYfamnsdOONY2herwkcgHt0nt1BuPXrNVGtnR6fp0ye8T2', 'Rafaela Brocco ', 'admin@gmail.com', 'gerente'),
(2, 'Isabelly', '$2y$10$zMrp6JEVt/phrkP7eszBa.1fLy9H2CqWv2St.SxL2taT4yQex1BhG', 'Isabelly Rodrigues ', 'isa110801@gmail.com', 'gerente'),
(3, 'lavi', '$2y$10$yp5wBdxV71RtEmzmHNllDO9tFeivmXG97CVxMqRePZiCyc9omVGeO', 'Lavinia Santiago', 'lavi123@gmail.com', 'funcionario'),
(4, 'Mari', '$2y$10$ATRwhgDpOwTFd3w5XB4bMuCa/9EGN5hr.raUdbVLoCNZQ8i9uoxvu', 'Mariana Dauzacher Generoso', 'mari1234@gmail.com', 'funcionario'),
(0, 'miguel', '$2y$10$Xmhm4CdDM3TNI6as49pm1u/yzGATLHNzXw.N9.v6hZFkf/fmgEt4i', 'Miguel de Jesus', 'migueljesus@gmail.com', 'repositor');

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `quantidade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `preco`, `quantidade`) VALUES
(2, 'LOL Surprise', 69.90, 1300),
(3, 'Casa da Barbie', 249.99, 500);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
