-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 10-Jun-2024 às 11:51
-- Versão do servidor: 8.0.21
-- versão do PHP: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `fabrica`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `realizacaoproducao`
--

DROP TABLE IF EXISTS `realizacaoproducao`;
CREATE TABLE IF NOT EXISTS `realizacaoproducao` (
  `id` int NOT NULL AUTO_INCREMENT,
  `idPedido` int DEFAULT NULL,
  `idFluxo` int DEFAULT NULL,
  `numOrdem` int DEFAULT NULL,
  `idEtapa` int DEFAULT NULL,
  `dataRealizacao` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `realizacaoproducao`
--

INSERT INTO `realizacaoproducao` (`id`, `idPedido`, `idFluxo`, `numOrdem`, `idEtapa`, `dataRealizacao`) VALUES
(33, 33, 17, 15, 13, '2024-06-22'),
(32, 33, 17, 14, 18, '2024-06-21'),
(31, 33, 17, 13, 35, '2024-06-20'),
(30, 33, 17, 12, 52, '2024-06-19'),
(29, 33, 17, 11, 23, '2024-06-18'),
(28, 33, 17, 10, 33, '2024-06-17'),
(27, 33, 17, 9, 65, '2024-06-16'),
(26, 33, 17, 8, 4, '2024-06-15'),
(25, 33, 17, 7, 31, '2024-06-14'),
(24, 33, 17, 6, 1, '2024-06-13'),
(23, 33, 17, 5, 88, '2024-06-12'),
(22, 33, 17, 4, 87, '2024-06-11'),
(21, 33, 17, 3, 28, '2024-06-10'),
(20, 33, 17, 2, 74, '2024-06-09'),
(19, 33, 17, 1, 72, '2024-06-08');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
