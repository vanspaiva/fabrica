-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 05-Jun-2024 às 16:32
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

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

--
-- Estrutura da tabela `estados`
--

CREATE TABLE `estados` (
  `ufId` int(11) NOT NULL,
  `ufNomeExtenso` varchar(100) NOT NULL,
  `ufAbreviacao` varchar(2) NOT NULL,
  `ufRegiao` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `estados`
--

INSERT INTO `estados` (`ufId`, `ufNomeExtenso`, `ufAbreviacao`, `ufRegiao`) VALUES
(1, 'Acre', 'AC', 'Norte'),
(2, 'Alagoas', 'AL', 'Nordeste'),
(3, 'Amapá', 'AP', 'Norte'),
(4, 'Amazonas', 'AM', 'Norte'),
(5, 'Bahia', 'BA', 'Nordeste'),
(6, 'Ceará', 'CE', 'Nordeste'),
(7, 'Distrito Federal', 'DF', 'Centro-Oeste'),
(8, 'Espírito Santo', 'ES', 'Sudeste'),
(9, 'Goiás', 'GO', 'Centro-Oeste'),
(10, 'Maranhão', 'MA', 'Nordeste'),
(11, 'Mato Grosso', 'MT', 'Centro-Oeste'),
(12, 'Mato Grosso do Sul', 'MS', 'Centro-Oeste'),
(13, 'Minas Gerais', 'MG', 'Sudeste'),
(14, 'Pará', 'PA', 'Norte'),
(15, 'Paraíba', 'PB', 'Nordeste'),
(16, 'Pará', 'PR', 'Sul'),
(17, 'Pernambuco', 'PE', 'Nordeste'),
(18, 'Piauí', 'PI', 'Nordeste'),
(19, 'Rio de Janeiro', 'RJ', 'Sudeste'),
(20, 'Rio Grande do Norte', 'RN', 'Nordeste'),
(21, 'Rio Grande do Sul', 'RS', 'Sul'),
(22, 'Rondônia', 'RO', 'Norte'),
(23, 'Roraima', 'RR', 'Norte'),
(24, 'Santa Catarina', 'SC', 'Sul'),
(25, 'São Paulo', 'SP', 'Sudeste'),
(26, 'Sergipe', 'SE', 'Nordeste'),
(28, 'Tocantins', 'TO', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `etapa`
--

CREATE TABLE `etapa` (
  `id` int(11) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `parametro1` text DEFAULT NULL,
  `parametro2` text DEFAULT NULL,
  `iterev` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `etapa`
--

INSERT INTO `etapa` (`id`, `nome`, `parametro1`, `parametro2`, `iterev`) VALUES
(1, 'Acabamento', NULL, NULL, 'IT/rev: IT.PRO.'),
(2, 'Anodização Alumínio', 'Lote da Solução:', NULL, 'IT/rev: IT.PRO.030/00'),
(3, 'Anodização Ti', 'Lote da Solução:', NULL, 'IT/rev: IT.PRO.013/00'),
(4, 'Ataque Ácido (SLA)', 'Lote da Solução:', NULL, 'IT/rev: IT.PRO.043/00'),
(5, 'Atividade Adicional', NULL, NULL, 'IT/rev:'),
(6, 'Conformação', 'Temperatura:', NULL, NULL),
(7, 'Controle de Qualidade', NULL, NULL, 'IT/rev: IT.PRO.017/00 e IT.PRO.018/00'),
(8, 'Cortar Bordas', 'Máquina:', NULL, 'IT/rev: IT.PRO.004/00'),
(9, 'Corte a Fio', 'Programa:', 'Máquina: Qtd. REFUGO:', 'IT/rev:'),
(10, 'Corte a Laser', 'Potência: Velocidade:', 'Arquivo:', NULL),
(11, 'Decapagem', 'Lote da Solução:', 'Tempo:', NULL),
(12, 'Diamantação', 'saída:', 'entrada:', NULL),
(13, 'Emb. Final e Rotulagem', 'Qtd. Impressa: Resp.:', 'Qtd. Utilizada: Qtd. Destruida:', 'Conferido Por:'),
(14, 'Emb. não Estéril Blister', 'Temperatura: Tempo:', 'Máquina:', 'IT/rev: IT.PRO.015/00'),
(15, 'Emb. não Estéril Polietileno', NULL, NULL, 'IT/rev: IT.PRO.015/00'),
(16, 'Emb. Semi Acabado', 'Qtd. Imp./Utili./Destru.: / /', 'Resp.:___________ Conf. Por:___________', 'IT/rev: IT.PRO.015/00'),
(17, 'Embalagem Eletromédico', NULL, NULL, NULL),
(18, 'Embalagem Estéril', 'Temperatura: Tempo: Máquina:', 'Conferido encaixe da prótese no biomodelo? S N/A', 'IT/rev: IT.PRO.001/00'),
(19, 'Encaixe de Anilhas', 'Ø do furo da anilha:', NULL, NULL),
(20, 'Fabricação Bottom Layer', NULL, NULL, 'IT/rev: IT.PRO.014/00'),
(21, 'Fabricação Top Layer', NULL, NULL, 'IT/rev: IT.PRO.014/00'),
(22, 'Furações', NULL, NULL, NULL),
(23, 'Gravação', 'Potência: Velocidade:', 'Arquivo:', 'IT/rev: IT.PRO.024/00'),
(24, 'Gravação e Testes de Desempenho da Placa', NULL, NULL, 'IT/rev: IT.PRO.014/00'),
(25, 'Guilhotinar', 'Máquina:', NULL, 'IT/rev: IT.PRO.004/00'),
(26, 'Impressão', 'Programa:', 'Máquina:', 'IT/rev: IT.PRO.038/00'),
(27, 'Impressão AL', 'Programa:', 'Máquina: MAQ. 067', 'IT/rev: IT.PRO.044/00'),
(28, 'Impressão Ti', 'Programa:', 'Máquina: MAQ. 038', 'IT/rev: IT.PRO.044/00'),
(29, 'Injeção', NULL, NULL, 'IT/rev: IT.PRO.010/00'),
(30, 'Inspeção Eletromédico', NULL, NULL, 'IT/rev: IT.PRO.014/00'),
(31, 'Inspeção Intermediária 1', 'Qtds Aprov: Reprovado:', 'Qtd. Perda:', 'IT/rev: IT.INS.008/00'),
(32, 'Inspeção Intermediária 1.', 'Qtds Aprov: Reprovado:', 'Qtd. Perda:', 'IT/rev: IT.INS.009/00'),
(33, 'Inspeção Intermediária 2', 'Qtds Aprov: Reprovado:', 'Qtd. Perda:', 'IT/rev: IT.INS.008/00'),
(34, 'Inspeção Intermediária 2.', 'Qtds Aprov: Reprovado:', 'Qtd. Perda:', 'IT/rev: IT.INS.009/00'),
(35, 'Inspeção Intermediária 3', 'Qtds Aprov: Reprovado:', 'Qtd. Perda:', 'IT/rev: IT.INS.008/00'),
(36, 'Inspeção Intermediária 3.', 'Qtds Aprov: Reprovado:', 'Qtd. Perda:', 'IT/rev: IT.INS.009/00'),
(37, 'Instalação Bomba d´agua', NULL, NULL, 'IT/rev: IT.PRO.017/00 e IT.PRO.018/00'),
(38, 'Instalação carcaça frontal e touchscreen', NULL, NULL, 'IT/rev: IT.PRO.017/00 e IT.PRO.018/00'),
(39, 'Instalação carcaça traseira', NULL, NULL, 'IT/rev: IT.PRO.017/00 e IT.PRO.018/00'),
(40, 'Instalação Componentes Solda Manual', NULL, NULL, 'IT/rev: IT.PRO.014/00'),
(41, 'Instalação conector e fonte maniplo', NULL, NULL, 'IT/rev: IT.PRO.017/00 e IT.PRO.018/00'),
(42, 'Instalação controle de energia', NULL, NULL, 'IT/rev: IT.PRO.017/00 e IT.PRO.018/00'),
(43, 'Instalação Fonte', NULL, NULL, 'IT/rev: IT.PRO.017/00 e IT.PRO.018/00'),
(44, 'Instalação Fonto 12V e sistema de refrigeração', NULL, NULL, 'IT/rev: IT.PRO.017/00 e IT.PRO.018/00'),
(45, 'Instalação Placa mãe e fonte', NULL, NULL, 'IT/rev: IT.PRO.017/00 e IT.PRO.018/00'),
(46, 'Instalação Resevatório d´agua', NULL, NULL, 'IT/rev: IT.PRO.017/00 e IT.PRO.018/00'),
(47, 'Instalação Rodas', NULL, NULL, 'IT/rev: IT.PRO.017/00 e IT.PRO.018/00'),
(48, 'Intalação da Fiação elétrica', NULL, NULL, 'IT/rev: IT.PRO.017/00 e IT.PRO.018/00'),
(49, 'Jateamento', NULL, NULL, 'IT/rev: IT.PRO.057/00'),
(50, 'Jateamento.', 'Apenas se o material estiver com manchas', NULL, 'IT/rev: IT.PRO.057/00'),
(51, 'Liberação final', NULL, NULL, NULL),
(52, 'Limpeza', 'Detergente enzimático:', 'Lote detergente:', 'IT/rev: IT.PRO.005/00'),
(53, 'Limpeza de Impressões', 'Insumo', NULL, 'IT/rev: IT.PRO.005/00'),
(54, 'Limpeza externa', 'Insumo', NULL, 'IT/rev: IT.PRO.005/00'),
(55, 'Moldagem Cimento', NULL, NULL, 'IT/rev: IT.PRO.052/00'),
(56, 'Moldagem Polietileno', 'Temperatura:', 'Tempo:', 'IT/rev: IT.PRO.051/00'),
(57, 'moldagem Silicone', 'Qtd:', 'lote:', 'IT/rev: IT.PRO.053/00'),
(58, 'Montagem', NULL, NULL, NULL),
(59, 'Montagem de Côndilo', NULL, NULL, 'IT/rev: IT.PRO.032/00'),
(60, 'Montagem Estrutra Metálica', NULL, NULL, 'IT/rev: IT.PRO.017/00 e IT.PRO.018/00'),
(61, 'Passivação Al', 'Lote da Solução:', NULL, 'IT/rev: IT.PRO.030/00'),
(62, 'Passivação CoCrMo', 'Lote da Solução:', NULL, 'IT/rev: IT.PRO.025/00'),
(63, 'Passivação Placa Mandibular', 'Lote da Solução:', NULL, 'IT/rev: IT.PRO.025/00'),
(64, 'Passivação por Imersão', 'Lote da Solução:', NULL, 'IT/rev:'),
(65, 'Passivação Ti', 'Lote da Solução:', NULL, 'IT/rev: IT.PRO.013/00'),
(66, 'Pintura Estrutura Metálica', NULL, NULL, 'IT/rev: IT.PRO.017/00 e IT.PRO.018/00'),
(67, 'Planej. CAD', 'Arquivo:', 'Data do aceite:', 'IT/rev:'),
(68, 'Planej. Cirúrgico.', 'Arquivo: Data do aceite:', 'Necessário Impressão de arcadas? Sim Não', 'IT/rev:'),
(69, 'Planej. Fechamento Arquivo', 'Data de envio:', 'REV final:', 'IT/rev:'),
(70, 'Planej. Segmentação', 'Arquivo:', NULL, 'IT/rev:'),
(71, 'Preparação MP', NULL, NULL, 'IT/rev: IT.PRO.034/00'),
(72, 'Programação CAM', 'Arquivo:', NULL, 'IT/rev: IT.PRO.036/00'),
(73, 'Programação Impressão Al', 'Arquivo:', NULL, 'IT/rev: IT.PRO.044/00'),
(74, 'Programação Impressão Ti', 'Arquivo:', NULL, 'IT/rev: IT.PRO.044/00'),
(75, 'Rebarbação', NULL, NULL, 'IT/rev: IT.PRO.010/00'),
(76, 'Rosqueamento', NULL, NULL, 'IT/rev: IT.PRO.058/00'),
(77, 'Separação cabeça condilar', NULL, NULL, 'IT/rev: IT.PRO.034/00'),
(78, 'Separação Componentes', NULL, NULL, 'IT/rev: IT.PRO.014/00'),
(79, 'Separação MP', NULL, NULL, 'IT/rev: IT.PRO.034/00'),
(80, 'Separação MP', 'Qtd. Imp./Utili./Destru.: / /', 'Resp.:___________ Conf. Por:___________', 'IT/rev: IT.PRO.034/00'),
(81, 'Setup da Injetora', NULL, NULL, 'IT/rev: IT.PRO.010/00'),
(82, 'Tamboreamento', NULL, NULL, 'IT/rev: IT.PRO.029/00'),
(83, 'Termoformagem', 'Temperatura:', 'Máquina:', 'IT/rev: IT.PRO.004/00'),
(84, 'Teste de funcionamento e calibração', NULL, NULL, 'IT/rev: IT.PRO.017/00 e IT.PRO.018/00'),
(85, 'Torno', NULL, 'Máquina: Qtd. REFUGO:', 'IT/rev: IT.PRO.054/00'),
(86, 'Tratamento Térmico externo', NULL, NULL, 'NÚMERO DA NOTA FISCAL:'),
(87, 'Tratamento Térmico', 'Programa:', 'Temperatura:', 'IT/rev: IT.PRO.045/00'),
(88, 'Usinagem', 'Programa:', 'Máquina:', 'IT/rev: IT.PRO.060/00'),
(89, 'Usinagem calota', 'Programa:', 'Máquina:', NULL),
(90, 'Usinagem citizen', 'Programa:', NULL, NULL),
(91, 'Usinagem Frente', 'Programa:', 'Máquina:', 'IT/rev: IT.PRO.004/00'),
(92, 'Usinagem matriz', 'Programa:', 'Máquina:', NULL),
(93, 'Usinagem Verso', 'Programa:', 'Máquina:', 'IT/rev: IT.PRO.004/00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `etapasos`
--

CREATE TABLE `etapasos` (
  `etapaId` int(11) NOT NULL,
  `etapaNome` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `etapasos`
--

INSERT INTO `etapasos` (`etapaId`, `etapaNome`) VALUES
(1, 'Jateamento'),
(5, 'Limpeza 1'),
(3, 'Anodização'),
(6, 'Limpeza 2'),
(7, 'Inspeção'),
(8, 'Embalagem'),
(10, 'Gravação');

-- --------------------------------------------------------

--
-- Estrutura da tabela `etapa_fluxo`
--

CREATE TABLE `etapa_fluxo` (
  `id` int(11) NOT NULL,
  `idfluxo` int(11) NOT NULL,
  `idetapa` int(11) NOT NULL,
  `ordem` int(11) NOT NULL,
  `duracao` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `etapa_fluxo`
--

INSERT INTO `etapa_fluxo` (`id`, `idfluxo`, `idetapa`, `ordem`, `duracao`) VALUES
(2, 1, 1, 2, 1),
(3, 1, 31, 3, 1),
(4, 1, 2, 4, 2.5),
(5, 1, 4, 5, 2.5),
(6, 1, 33, 6, 1),
(7, 1, 23, 7, 1),
(9, 1, 35, 10, 1),
(12, 1, 88, 1, 1),
(13, 1, 13, 11, 2),
(14, 1, 3, 9, 1),
(17, 1, 52, 8, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `filedownload`
--

CREATE TABLE `filedownload` (
  `fileId` int(11) NOT NULL,
  `fileRealName` text NOT NULL,
  `fileOsRef` int(11) NOT NULL,
  `filePath` varchar(500) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `filedownload`
--

INSERT INTO `filedownload` (`fileId`, `fileRealName`, `fileOsRef`, `filePath`) VALUES
(1, '4034-produtos.csv', 4, 'arquivos/4034-produtos.csv'),
(2, '5498-produtos.csv', 0, 'arquivos/5498-produtos.csv'),
(3, '2799-produtos.csv', 4, '../arquivos/2799-produtos.csv'),
(4, '4325-desenho da isa.png', 4, '/arquivos/4325-desenho da isa.png'),
(5, '9561-desenho da isa.png', 4, 'arquivos/4/9561-desenho da isa.png'),
(6, '6999-desenho da isa.png', 4, 'arquivos/4'),
(7, '9554-produtos.csv', 4, 'arquivos/4'),
(8, '2357-produtos.csv', 4, 'arquivos/4'),
(9, '3894-desenho da isa.png', 4, 'arquivos/4'),
(10, '9548-Atividades para Fábrica (respostas).pdf', 4, '../arquivos/4'),
(11, '7545-desenho da isa.png', 4, '../arquivos/4'),
(12, '6295-desenho da isa.png', 5, '../arquivos/5'),
(13, '2470-desenho da isa.png', 6, '../arquivos/6'),
(14, '5682-TO-DO LIST CONECTA.docx', 7, '../arquivos/7'),
(15, '3159-produtos.csv', 8, '../arquivos/8'),
(16, '8996-', 9, '../arquivos/9'),
(17, '8076-', 10, '../arquivos/10'),
(18, '2315-php-barcode-master.zip', 11, '../arquivos/11'),
(19, 'https://firebasestorage.googleapis.com/v0/b/sistemas-fabrica.appspot.com/o/myimages%2F1398F%C3%A1brica.pdf?alt=media&token=5e73077b-6ce7-4dab-9c19-af9790585aa4', 14, '../arquivos/14'),
(20, '', 15, '../arquivos/15'),
(21, '', 16, '../arquivos/16');

-- --------------------------------------------------------

--
-- Estrutura da tabela `fluxo`
--

CREATE TABLE `fluxo` (
  `id` int(11) NOT NULL,
  `nome` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `fluxo`
--

INSERT INTO `fluxo` (`id`, `nome`) VALUES
(1, 'Ancorfix'),
(2, 'ATM'),
(3, 'ATM CABEÇA CONDILAR MP'),
(4, 'ATM Fossa (customizada)'),
(5, 'ATM Placa (customizada)'),
(6, 'ATM PLACA (ESTOQUE) (MP)'),
(7, 'ATM PLACA (ESTOQUE)'),
(8, 'FOSSA DE ESTOQUE MP'),
(9, 'FOSSA DE ESTOQUE'),
(10, 'BARRA'),
(11, 'Biomodelo ETO'),
(12, 'Biomodelo NS'),
(13, 'BRANCO'),
(14, 'Chaves e brocas'),
(15, 'Crânio Peek'),
(16, 'Crânio Ti'),
(17, 'Customlife'),
(18, 'Desenvolvimento'),
(19, 'FRESA DIAMANTADA'),
(20, 'Cabeça condilar'),
(21, 'PLACA TEMPLATE ATM DE ESTOQUE'),
(22, 'GUIAS ATM DE ESTOQUE FOSSA'),
(23, 'GUIAS ATM DE ESTOQUE MP'),
(24, 'Guias sem anilha ETO'),
(25, 'Guias sem anilha NS'),
(26, 'Guias titanio'),
(27, 'HF-108'),
(28, 'Implante teste'),
(29, 'Instrumental 2'),
(30, 'Instrumental'),
(31, 'Instrumental ponta de chave'),
(32, 'Kit cirurgico'),
(33, 'Malhas'),
(34, 'Mostruario'),
(35, 'Multi Unit estéril'),
(36, 'Multi Unit'),
(37, 'Ortognatica curso'),
(38, 'Ortognatica Impressão'),
(39, 'Ortognática usi+imp'),
(40, 'Ortopedia'),
(41, 'Ortopedia ETO'),
(42, 'CAIXA CUSTOM ETO'),
(43, 'Ortopedia fabricado'),
(44, 'Ortopedia produção interna'),
(45, 'Parafuso MP'),
(46, 'Parafuso não esteril'),
(47, 'Parafuso esteril'),
(48, 'Parafuso SLA esteril'),
(49, 'Parafuso SLA (MP)'),
(50, 'Planejamento'),
(51, 'Reconstrucao PEEK'),
(52, 'Reconstrucao Ti'),
(53, 'Smartmold'),
(54, 'Templante em alumínio'),
(55, 'TORQUÍMETRO'),
(56, 'EVP case frontal'),
(57, 'EVP case traseiro'),
(58, 'EVP Placas'),
(59, 'EVP Manifold'),
(60, 'EVP Main board'),
(61, 'CHAVES TORQUÍMETRO'),
(62, 'Conector');

-- --------------------------------------------------------

--
-- Estrutura da tabela `logatividades`
--

CREATE TABLE `logatividades` (
  `logId` int(11) NOT NULL,
  `logOsRef` varchar(100) NOT NULL,
  `logHorario` timestamp NOT NULL DEFAULT current_timestamp(),
  `logStatus` varchar(50) NOT NULL,
  `logUser` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `logatividades`
--

INSERT INTO `logatividades` (`logId`, `logOsRef`, `logHorario`, `logStatus`, `logUser`) VALUES
(14, '6', '2021-11-29 20:49:05', 'CONCLUÍDO', 'vanessapaiva'),
(13, '7', '2021-11-29 20:49:04', 'CONCLUÍDO', 'vanessapaiva'),
(12, '6', '2021-11-29 20:48:56', 'EM ANDAMENTO', 'vanessapaiva'),
(17, '7', '2021-11-29 20:55:58', 'EM ANDAMENTO', 'vanessapaiva'),
(16, '7', '2021-11-29 20:55:32', 'CRIADO', 'vanessapaiva'),
(18, '7', '2021-11-29 20:56:23', 'CONCLUÍDO', 'vanessapaiva'),
(19, '8', '2021-11-29 21:12:00', 'CRIADO', 'vanessapaiva'),
(20, '6', '2021-11-29 21:12:09', 'EM ANDAMENTO', 'vanessapaiva'),
(21, '9', '2021-11-29 21:17:56', 'EM ANDAMENTO', 'vanessapaiva'),
(22, '8', '2021-11-29 21:18:19', 'EM ANDAMENTO', 'vanessapaiva'),
(23, '9', '2021-11-29 21:18:21', 'CONCLUÍDO', 'vanessapaiva'),
(24, '9', '2021-11-29 21:19:59', 'CRIADO', 'vanessapaiva'),
(25, '8', '2021-11-30 16:28:04', 'PAUSADO', 'vanessapaiva'),
(26, '10', '2021-11-30 16:28:31', 'CRIADO', 'vanessapaiva'),
(27, '11', '2021-11-30 17:46:35', 'CRIADO', 'vanessapaiva'),
(28, '11', '2021-11-30 17:46:57', 'CRIADO', 'vanessapaiva'),
(29, '11', '2021-11-30 17:48:09', 'CRIADO', 'vanessapaiva'),
(30, '10', '2021-11-30 21:15:45', 'EM ANDAMENTO', 'vanessapaiva'),
(31, '10', '2021-11-30 21:15:50', 'PAUSADO', 'vanessapaiva'),
(32, '11', '2021-11-30 21:34:12', 'CRIADO', 'vanessapaiva'),
(33, '6', '2021-12-08 13:20:19', 'CONCLUÍDO', 'vanessapaiva'),
(34, '8', '2021-12-08 13:24:37', 'EM ANDAMENTO', 'vanessapaiva'),
(35, '8', '2022-01-24 18:07:20', 'PAUSADO', 'vanessapaiva'),
(36, '8', '2022-02-03 12:52:20', 'EM ANDAMENTO', 'vanessapaiva'),
(37, '8', '2022-02-03 12:54:09', 'PAUSADO', 'vanessapaiva'),
(38, '8', '2022-11-21 15:03:29', 'EM ANDAMENTO', 'vanessapaiva'),
(39, '8', '2022-11-21 15:03:41', 'PAUSADO', 'vanessapaiva'),
(40, '8', '2023-04-06 12:32:04', 'EM ANDAMENTO', 'vanessapaiva'),
(41, '8', '2023-04-06 12:32:35', 'PAUSADO', 'vanessapaiva'),
(42, '12', '2024-05-14 18:02:37', 'CRIADO', 'vanessapaiva'),
(43, '12', '2024-05-14 18:02:53', 'EM ANDAMENTO', 'vanessapaiva'),
(44, '12', '2024-05-14 18:03:09', 'PAUSADO', 'vanessapaiva'),
(45, '12', '2024-05-14 18:03:14', 'EM ANDAMENTO', 'vanessapaiva'),
(46, '12', '2024-05-14 18:03:17', 'CONCLUÍDO', 'vanessapaiva'),
(47, '13', '2024-05-16 20:37:08', 'EM ANDAMENTO', 'antonia'),
(48, '13', '2024-05-16 20:37:28', 'PAUSADO', 'antonia'),
(49, '13', '2024-05-16 20:41:03', 'PAUSADO', 'antonia'),
(50, '13', '2024-05-17 10:49:16', 'EM ANDAMENTO', 'evellyn'),
(51, '13', '2024-05-17 10:49:36', 'CONCLUÍDO', 'evellyn'),
(52, '16', '2024-05-31 20:11:38', 'EM ANDAMENTO', 'vanessa'),
(53, '16', '2024-05-31 20:12:06', 'PAUSADO', 'vanessa'),
(54, '16', '2024-05-31 20:12:07', 'EM ANDAMENTO', 'vanessa'),
(55, '16', '2024-05-31 20:12:09', 'PAUSADO', 'vanessa');

-- --------------------------------------------------------

--
-- Estrutura da tabela `mesesano`
--

CREATE TABLE `mesesano` (
  `mesId` int(11) NOT NULL,
  `mesNum` int(11) NOT NULL,
  `mesNome` varchar(20) NOT NULL,
  `mesAbrv` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Extraindo dados da tabela `mesesano`
--

INSERT INTO `mesesano` (`mesId`, `mesNum`, `mesNome`, `mesAbrv`) VALUES
(1, 1, 'Janeiro', 'Jan'),
(2, 2, 'Fevereiro', 'Fev'),
(3, 3, 'Março', 'Mar'),
(4, 4, 'Abril', 'Abr'),
(5, 5, 'Maio', 'Mai'),
(6, 6, 'Junho', 'Jun'),
(7, 7, 'Julho', 'Jul'),
(8, 8, 'Agosto', 'Ago'),
(9, 9, 'Setembro', 'Set'),
(10, 10, 'Outubro', 'Out'),
(11, 11, 'Novembro', 'Nov'),
(12, 12, 'Dezembro', 'Dez');

-- --------------------------------------------------------

--
-- Estrutura da tabela `ordenservico`
--

CREATE TABLE `ordenservico` (
  `osId` int(11) NOT NULL,
  `osUserCriador` varchar(200) NOT NULL,
  `osNomeCriador` varchar(200) NOT NULL,
  `osEmailCriador` varchar(200) NOT NULL,
  `osDtCriacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `osDtUpdate` timestamp NOT NULL DEFAULT current_timestamp(),
  `osUserIp` varchar(20) NOT NULL,
  `osSetor` varchar(200) NOT NULL,
  `osDescricao` varchar(200) NOT NULL,
  `osLote` varchar(50) DEFAULT NULL,
  `osNPed` varchar(50) DEFAULT NULL,
  `osNomeArquivo` text DEFAULT NULL,
  `osGrauUrgencia` varchar(10) NOT NULL,
  `osDtEntregasDesejada` varchar(100) NOT NULL,
  `osDtEntregaReal` varchar(200) DEFAULT NULL,
  `dtExecucao` varchar(100) DEFAULT NULL,
  `osObs` text DEFAULT NULL,
  `osStatus` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `ordenservico`
--

INSERT INTO `ordenservico` (`osId`, `osUserCriador`, `osNomeCriador`, `osEmailCriador`, `osDtCriacao`, `osDtUpdate`, `osUserIp`, `osSetor`, `osDescricao`, `osLote`, `osNPed`, `osNomeArquivo`, `osGrauUrgencia`, `osDtEntregasDesejada`, `osDtEntregaReal`, `dtExecucao`, `osObs`, `osStatus`) VALUES
(16, 'Administrador', 'vanessa', 'vanessa.paiva@fixgrupo.com.br', '2024-05-29 19:40:30', '2024-05-29 19:40:30', '10.1.1.108', ' Anodização', 'SGDFGDFSGSD', '123456', '125', '', '5', '2024-05-30', NULL, NULL, NULL, 'PAUSADO');

-- --------------------------------------------------------

--
-- Estrutura da tabela `statusos`
--

CREATE TABLE `statusos` (
  `stId` int(11) NOT NULL,
  `stNome` varchar(30) NOT NULL,
  `stPosicao` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `statusos`
--

INSERT INTO `statusos` (`stId`, `stNome`, `stPosicao`) VALUES
(5, 'CRIADO', 1),
(6, 'EM ANDAMENTO', 2),
(7, 'PAUSADO', 3),
(8, 'CONCLUÍDO', 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipocadastroexterno`
--

CREATE TABLE `tipocadastroexterno` (
  `tpcadexId` int(11) NOT NULL,
  `tpcadexCodCadastro` varchar(10) NOT NULL,
  `tpcadexNome` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipocadastrointerno`
--

CREATE TABLE `tipocadastrointerno` (
  `tpcadinId` int(11) NOT NULL,
  `tpcadinCodCadastro` varchar(10) NOT NULL,
  `tpcadinNome` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `tipocadastrointerno`
--

INSERT INTO `tipocadastrointerno` (`tpcadinId`, `tpcadinCodCadastro`, `tpcadinNome`) VALUES
(1, '1ADM', 'Administrador'),
(11, '3COL', 'Colaborador(a)'),
(10, '2GES', 'Gestor(a)');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `usersId` int(11) NOT NULL,
  `usersName` varchar(128) NOT NULL,
  `usersEmail` varchar(128) NOT NULL,
  `usersUid` varchar(128) NOT NULL,
  `usersPerm` varchar(128) NOT NULL,
  `usersPwd` varchar(128) NOT NULL,
  `usersAprov` varchar(20) NOT NULL,
  `usersUf` varchar(11) DEFAULT NULL,
  `usersIdentificador` varchar(128) DEFAULT NULL,
  `usersCel` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`usersId`, `usersName`, `usersEmail`, `usersUid`, `usersPerm`, `usersPwd`, `usersAprov`, `usersUf`, `usersIdentificador`, `usersCel`) VALUES
(1, 'Vanessa Paz Araújo Paiva', 'vanessa.paiva@fixgrupo.com.br', 'vanessa', '1ADM', '$2y$10$VEZ2rmjLA8Bi7FcMWpWt6.uw1I56NSr15MbETMuD3109o8.lLF0Iu', 'APROV', 'DF', '123456', '(61) 98365-2810'),
(8, 'Sullivan Maciel Morbeck', 'sullivan.morbeck@fixhealth.com.br', 'smorbeckcpmh', '3COL', '$2y$10$TZYl13zhPPR0Hfg3fHFkw.BmNbeONomYJoX2gEDN3OVP93wa/4SZ2', 'APROV', 'DF', 'smorbeckcpmh', '(61) 98479-7922'),
(7, 'Evellyn Pamplona', 'evellyn.pamplona@fixhealth.com.br', 'evellyn', '2GES', '$2y$10$BR2tVeooGe0BVZxZlT8b1umG1z6qX3Ndp8Dk7WEN1FD4VGjLSCo9K', 'APROV', 'DF', '1111', '6130288856'),
(6, 'Antonia Felix', 'antonia.santos@fixhealth.com.br', 'antonia', '2GES', '$2y$10$RuNicEZcmcRwu./ySZjMkuzQoLJirGqCKkv8jwekeFxl3G6xyRJeu', 'APROV', 'DF', '123', '(61) 30288-868'),
(12, 'Joice Censi', 'joice.censi@fixhealth.com.br', 'joicecensi', '3COL', '$2y$10$sd32MJL3tacnjOzLnO.0AeAPDZMFSsAjo/Ip.XDmUqylTdTjGUH0C', 'APROV', 'DF', NULL, '8871');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`ufId`);

--
-- Índices para tabela `etapa`
--
ALTER TABLE `etapa`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `etapasos`
--
ALTER TABLE `etapasos`
  ADD PRIMARY KEY (`etapaId`);

--
-- Índices para tabela `etapa_fluxo`
--
ALTER TABLE `etapa_fluxo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idfluxo` (`idfluxo`),
  ADD KEY `idetapa` (`idetapa`);

--
-- Índices para tabela `filedownload`
--
ALTER TABLE `filedownload`
  ADD PRIMARY KEY (`fileId`);

--
-- Índices para tabela `fluxo`
--
ALTER TABLE `fluxo`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `logatividades`
--
ALTER TABLE `logatividades`
  ADD PRIMARY KEY (`logId`);

--
-- Índices para tabela `mesesano`
--
ALTER TABLE `mesesano`
  ADD PRIMARY KEY (`mesId`);

--
-- Índices para tabela `ordenservico`
--
ALTER TABLE `ordenservico`
  ADD PRIMARY KEY (`osId`);


--
-- Índices para tabela `statusos`
--
ALTER TABLE `statusos`
  ADD PRIMARY KEY (`stId`);

--
-- Índices para tabela `tipocadastroexterno`
--
ALTER TABLE `tipocadastroexterno`
  ADD PRIMARY KEY (`tpcadexId`);

--
-- Índices para tabela `tipocadastrointerno`
--
ALTER TABLE `tipocadastrointerno`
  ADD PRIMARY KEY (`tpcadinId`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`usersId`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `estados`
--
ALTER TABLE `estados`
  MODIFY `ufId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de tabela `etapa`
--
ALTER TABLE `etapa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT de tabela `etapasos`
--
ALTER TABLE `etapasos`
  MODIFY `etapaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `etapa_fluxo`
--
ALTER TABLE `etapa_fluxo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `filedownload`
--
ALTER TABLE `filedownload`
  MODIFY `fileId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de tabela `fluxo`
--
ALTER TABLE `fluxo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT de tabela `logatividades`
--
ALTER TABLE `logatividades`
  MODIFY `logId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT de tabela `mesesano`
--
ALTER TABLE `mesesano`
  MODIFY `mesId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `ordenservico`
--
ALTER TABLE `ordenservico`
  MODIFY `osId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `statusos`
--
ALTER TABLE `statusos`
  MODIFY `stId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `tipocadastroexterno`
--
ALTER TABLE `tipocadastroexterno`
  MODIFY `tpcadexId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `tipocadastrointerno`
--
ALTER TABLE `tipocadastrointerno`
  MODIFY `tpcadinId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `usersId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `etapa_fluxo`
--
ALTER TABLE `etapa_fluxo`
  ADD CONSTRAINT `etapa_fluxo_ibfk_1` FOREIGN KEY (`idfluxo`) REFERENCES `fluxo` (`id`),
  ADD CONSTRAINT `etapa_fluxo_ibfk_2` FOREIGN KEY (`idetapa`) REFERENCES `etapa` (`id`);


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


-- Estrutura da tabela `produtos`

CREATE TABLE PRODUTOS (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descricao TEXT NOT NULL,
    codigoCllisto VARCHAR(100) NOT NULL,
    idFluxo INT NOT NULL
);

---- Estrutura da tabela `correlacao_produtos


CREATE TABLE CORRELACAO_PRODUTO (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    idMaster INT NOT NULL,
    IdSecundario INT NOT NULL,
    FOREIGN KEY (idMaster) REFERENCES PRODUTOS(id),
    FOREIGN KEY (IdSecundario) REFERENCES PRODUTOS(id)
);  

/* ============================ Tabelas do FORM INF 004  ========================== */ 

CREATE TABLE `frm_inf_004` (
  `id` int NOT NULL AUTO_INCREMENT,
  `data_publicacao` date DEFAULT NULL,
  `data_validade` date DEFAULT NULL,
  `data_manutencao` date DEFAULT NULL,
  `modelo` varchar(20) DEFAULT 'springer',
  `descricao_setor` text DEFAULT NULL,
  `descricao_atividades` text(255),
  `frmstatus_id` int DEFAULT NULL,
  `responsavel` varchar(255),
  PRIMARY KEY (`id`),
  KEY `fk_setor` (`descricao_setor`),
    KEY `fk_frmstatus` (`frmstatus_id`),
    CONSTRAINT `fk_setor` FOREIGN KEY (`descricao_setor`) REFERENCES `setor_arcondicionado` (`id`),
    CONSTRAINT `fk_frmstatus` FOREIGN KEY (`frmstatus_id`) REFERENCES `frmstatus` (`id`)
)ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

---- Estrutura da tabela `SETOR_ARCONDICIONADO'

CREATE TABLE SETOR_ARCONDICIONADO (
id INT PRIMARY KEY AUTO_INCREMENT, 
descricao_setores text
)ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;
INSERT INTO SETOR_ARCONDICIONADO (descricao_setores) VALUES
('SALA DE REUNIÃO TERREO'),
('SALA PCP'),
('SALA ENGENHARIA/PROJETOS'),
('SALA MANUTENÇÃO'),
('SALA IMPRESSORA TITANIUM'),
('SALA IMPRESSORAS FILAMENTO'),
('SALA QUALIDADE INSPEÇÃO'),
('SALA ESTOQUE CPMH'),
('SALA ESTOQUE BRASFIX'),
('SALA ESTOQUE OSTEOFIX'),
('SALA REUNIÃO 1º ANDAR'),
('SALA LOUNGE'),
('SALA PRESIDENCIA'),
('AUDITORIO'),
('CPD'),
('SALA DE JOGOS'),
('SALA ADMINISTRATIVO/FINANCEIRO'),
('SALA MARKETING/DIRETORIA'),
('SALA DE DESCANSO');

--  tabela frmstatus
CREATE TABLE frmstatus (
    id INT PRIMARY KEY AUTO_INCREMENT,
    status VARCHAR(20) NOT NULL
)ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;
INSERT INTO frmstatus (status) VALUES
('Pendente'),
('Concluída');


---- Estrutura da tabela `DESCRICAO_ATIVIDADES'

CREATE TABLE DESCRICAO_ATIVIDADES (
id INT PRIMARY KEY AUTO_INCREMENT,
descricao TEXT
)ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

INSERT INTO descricao_atividades (descricao) VALUES
('Verificação e drenagem da água'),
('Limpar bandejas e serpentinas - lavar as bandejas e serpentinas com remoção do biofilme (lodo), sem o uso de produtos desengraxantes e corrosivos (higienizador e bactericidas)'),
('Limpeza do gabinete - limpar o gabinete do condicionador e ventiladores (carcaça e rotor)'),
('Limpeza dos filtros - verificação e eliminação de sujeiras, danos e corrosão e frestas dos filtros'),
('Trocar filtros'),
('Verificação da fixação'),
('Verificação de vazamentos nas ligações flexíveis'),
('Estado de conservação do isolamento termo-acústico'),
('Vedação dos painéis de fechamento do gabinete'),
('Manutenção mecânica'),
('Manutenção elétrica'),
('outros');

CREATE TABLE `frm_inf_004_atividades` (
  `id` int NOT NULL AUTO_INCREMENT,
  `frm_inf_004_id` int NOT NULL,
  `descricao_atividades_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `frm_inf_004_id` (`frm_inf_004_id`),
  KEY `descricao_atividades_id` (`descricao_atividades_id`),
  CONSTRAINT `frm_inf_004_atividades_ibfk_1` FOREIGN KEY (`frm_inf_004_id`) REFERENCES `frm_inf_004` (`id`),
  CONSTRAINT `frm_inf_004_atividades_ibfk_2` FOREIGN KEY (`descricao_atividades_id`) REFERENCES `descricao_atividades` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=latin1; -- adiconar para chaves secundarias --




<<<<<<< HEAD

/* ============================ Tabelas do FORM INF 003  ========================== */

CREATE TABLE IF NOT EXISTS form_inf_003 (
    `id` INT NOT NULL AUTO_INCREMENT,
    `setor` VARCHAR(25) NOT NULL,
    `area_adm` VARCHAR(100),
    `data` DATE NOT NULL,
    `periodo` VARCHAR(10),
    `responsavel` VARCHAR(10),
    `id_user_criador` INT,
    `tipo_limpeza` VARCHAR(256) NOT NULL,
    `conferido` ENUM('APROV','PEND') NOT NULL DEFAULT 'PEND',
    `data_publicacao` DATE DEFAULT '2023-10-18',
    `data_validade` DATE DEFAULT '2025-10-18',
    PRIMARY KEY(`id`),
    FOREIGN KEY (`id_user_criador`) REFERENCES `users`(`usersId`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

CREATE TABLE  IF NOT EXISTS setores_form_inf_003(
id_setor INT NOT NULL AUTO_INCREMENT,
nome_setor VARCHAR(70) NOT NULL,
PRIMARY KEY (`id_setor`)
)ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

INSERT INTO setores_form_inf_003 Values 
(1,'Áreas Administrativas'),
(2,'Banheiro'),
(3,'Copa / Cozinha'),
(4, 'Produção');

CREATE TABLE IF NOT EXISTS departamentos_form_inf_003(
id INT NOT NULL AUTO_INCREMENT,
nome VARCHAR(90) NOT NULL,
id_setor INT NOT NULL,
PRIMARY KEY (`id`),
FOREIGN KEY(`id_setor`) REFERENCES setores_form_inf_003(`id_setor`)
)ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

INSERT INTO departamentos_form_inf_003 (nome, id_setor) VALUES
('Sala de Descanso', 1),
('ADM/Financeiro', 1),
('Marketing/Comercial', 1),
('CPD', 1),
('Sala de Jogos', 1),
('Auditório', 1),
('Presidência', 1),
('Lounge', 1),
('Sala de Reunião 1º andar', 1),
('Sala de Reunião (Térreo)', 1),
('Corredor dos Armários', 1),
('Estoque CPMH', 1),
('Estoque OSTEOFIX', 1),
('Laje Técnica', 1)
('Banheiro Masculino  1º andar', 2),
('Banheiro Masculino (Térreo)',2),
('Banheiro Feminino  1º andar', 2),
('Banheiro Feminino (Térreo)',2)
('Copa', 3),
('Cozinha',3)
('Fabrica', 4);
=======


ALTER TABLE departamentos_form_inf_003
CHANGE nome nome_departamento VARCHAR(255);

ALTER TABLE departamentos_form_inf_003
CHANGE id id_departamento INT AUTO_INCREMENT;


/* ALTERAÇÃO NA TABELA DE ORDEM DE MANUTENÇÃO */

ALTER TABLE ordenmanutencao
MODIFY COLUMN omDtEntregasDesejada varchar(100) NULL;

ALTER TABLE ordenmanutencao
MODIFY COLUMN omSetor varchar(200) NULL;

ALTER TABLE ordenmanutencao
MODIFY COLUMN omOperacional varchar(100) DEFAULT NULL;

ALTER TABLE ordenmanutencao
MODIFY COLUMN omTipoManutencao varchar(100) DEFAULT NULL;

ALTER TABLE logatividades
ADD COLUMN logTipo VARCHAR(255);
