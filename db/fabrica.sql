-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 12-Jun-2024 às 10:42
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
-- Estrutura da tabela `colaborador_etapas`
--

DROP TABLE IF EXISTS `colaborador_etapas`;
CREATE TABLE IF NOT EXISTS `colaborador_etapas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `idUser` int DEFAULT NULL,
  `idEtapa` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idUser` (`idUser`),
  KEY `idEtapa` (`idEtapa`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `colaborador_etapas`
--

INSERT INTO `colaborador_etapas` (`id`, `idUser`, `idEtapa`) VALUES
(23, 12, 74),
(22, 12, 72),
(21, 12, 1),
(24, 12, 79);

-- --------------------------------------------------------

--
-- Estrutura da tabela `correlacao_produto`
--

DROP TABLE IF EXISTS `correlacao_produto`;
CREATE TABLE IF NOT EXISTS `correlacao_produto` (
  `id` int NOT NULL AUTO_INCREMENT,
  `idProdutoPrincipal` int DEFAULT NULL,
  `idProdutoSecundario` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idProdutoPrincipal` (`idProdutoPrincipal`),
  KEY `idProdutoSecundario` (`idProdutoSecundario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `estados`
--

DROP TABLE IF EXISTS `estados`;
CREATE TABLE IF NOT EXISTS `estados` (
  `ufId` int NOT NULL AUTO_INCREMENT,
  `ufNomeExtenso` varchar(100) NOT NULL,
  `ufAbreviacao` varchar(2) NOT NULL,
  `ufRegiao` varchar(100) NOT NULL,
  PRIMARY KEY (`ufId`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

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

DROP TABLE IF EXISTS `etapa`;
CREATE TABLE IF NOT EXISTS `etapa` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL,
  `parametro1` text,
  `parametro2` text,
  `iterev` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=utf8;

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

DROP TABLE IF EXISTS `etapasos`;
CREATE TABLE IF NOT EXISTS `etapasos` (
  `etapaId` int NOT NULL AUTO_INCREMENT,
  `etapaNome` varchar(30) NOT NULL,
  PRIMARY KEY (`etapaId`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

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

DROP TABLE IF EXISTS `etapa_fluxo`;
CREATE TABLE IF NOT EXISTS `etapa_fluxo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `idfluxo` int NOT NULL,
  `idetapa` int NOT NULL,
  `ordem` int NOT NULL,
  `duracao` float NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idfluxo` (`idfluxo`),
  KEY `idetapa` (`idetapa`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

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
(17, 1, 52, 8, 1),
(18, 17, 72, 1, 1),
(19, 17, 74, 2, 1),
(20, 17, 28, 3, 1),
(21, 17, 87, 4, 1),
(22, 17, 88, 5, 1),
(23, 17, 1, 6, 1),
(24, 17, 31, 7, 1),
(25, 17, 4, 8, 1),
(26, 17, 65, 9, 1),
(27, 17, 33, 10, 1),
(28, 17, 23, 11, 1),
(29, 17, 52, 12, 1),
(30, 17, 35, 13, 1),
(31, 17, 18, 14, 1),
(32, 17, 13, 15, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `filedownload`
--

DROP TABLE IF EXISTS `filedownload`;
CREATE TABLE IF NOT EXISTS `filedownload` (
  `fileId` int NOT NULL AUTO_INCREMENT,
  `fileRealName` text NOT NULL,
  `fileOsRef` int NOT NULL,
  `filePath` varchar(500) NOT NULL,
  PRIMARY KEY (`fileId`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

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

DROP TABLE IF EXISTS `fluxo`;
CREATE TABLE IF NOT EXISTS `fluxo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8;

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
(17, 'CUSTOMLIFE'),
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

DROP TABLE IF EXISTS `logatividades`;
CREATE TABLE IF NOT EXISTS `logatividades` (
  `logId` int NOT NULL AUTO_INCREMENT,
  `logOsRef` varchar(100) NOT NULL,
  `logHorario` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `logStatus` varchar(50) NOT NULL,
  `logUser` varchar(200) NOT NULL,
  PRIMARY KEY (`logId`)
) ENGINE=MyISAM AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;

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
-- Estrutura da tabela `log_atividades_producao`
--

DROP TABLE IF EXISTS `log_atividades_producao`;
CREATE TABLE IF NOT EXISTS `log_atividades_producao` (
  `id` int NOT NULL AUTO_INCREMENT,
  `idRealizacaoProducao` int DEFAULT NULL,
  `idEtapa` int NOT NULL,
  `idUsuario` int DEFAULT NULL,
  `idStatus` int DEFAULT NULL,
  `data` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `log_atividades_producao`
--

INSERT INTO `log_atividades_producao` (`id`, `idRealizacaoProducao`, `idEtapa`, `idUsuario`, `idStatus`, `data`, `hora`) VALUES
(6, 94, 72, 1, 2, '2024-06-11', '15:51:37'),
(7, 94, 72, 1, 3, '2024-06-11', '15:51:44'),
(8, 94, 72, 12, 2, '2024-06-11', '18:01:37'),
(9, 94, 72, 12, 4, '2024-06-11', '18:01:58'),
(10, 95, 74, 12, 2, '2024-06-11', '18:14:59'),
(11, 65, 74, 12, 2, '2024-06-11', '18:15:07'),
(12, 95, 74, 12, 4, '2024-06-12', '07:39:24'),
(13, 65, 74, 12, 4, '2024-06-12', '07:39:31');

-- --------------------------------------------------------

--
-- Estrutura da tabela `mesesano`
--

DROP TABLE IF EXISTS `mesesano`;
CREATE TABLE IF NOT EXISTS `mesesano` (
  `mesId` int NOT NULL AUTO_INCREMENT,
  `mesNum` int NOT NULL,
  `mesNome` varchar(20) NOT NULL,
  `mesAbrv` varchar(3) NOT NULL,
  PRIMARY KEY (`mesId`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

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

DROP TABLE IF EXISTS `ordenservico`;
CREATE TABLE IF NOT EXISTS `ordenservico` (
  `osId` int NOT NULL AUTO_INCREMENT,
  `osUserCriador` varchar(200) NOT NULL,
  `osNomeCriador` varchar(200) NOT NULL,
  `osEmailCriador` varchar(200) NOT NULL,
  `osDtCriacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `osDtUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `osUserIp` varchar(20) NOT NULL,
  `osSetor` varchar(200) NOT NULL,
  `osDescricao` varchar(200) NOT NULL,
  `osLote` varchar(50) DEFAULT NULL,
  `osNPed` varchar(50) DEFAULT NULL,
  `osNomeArquivo` text,
  `osGrauUrgencia` varchar(10) NOT NULL,
  `osDtEntregasDesejada` varchar(100) NOT NULL,
  `osDtEntregaReal` varchar(200) DEFAULT NULL,
  `dtExecucao` varchar(100) DEFAULT NULL,
  `osObs` text,
  `osStatus` varchar(20) NOT NULL,
  PRIMARY KEY (`osId`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `ordenservico`
--

INSERT INTO `ordenservico` (`osId`, `osUserCriador`, `osNomeCriador`, `osEmailCriador`, `osDtCriacao`, `osDtUpdate`, `osUserIp`, `osSetor`, `osDescricao`, `osLote`, `osNPed`, `osNomeArquivo`, `osGrauUrgencia`, `osDtEntregasDesejada`, `osDtEntregaReal`, `dtExecucao`, `osObs`, `osStatus`) VALUES
(16, 'Administrador', 'vanessa', 'vanessa.paiva@fixgrupo.com.br', '2024-05-29 19:40:30', '2024-05-29 19:40:30', '10.1.1.108', ' Anodização', 'SGDFGDFSGSD', '123456', '125', '', '5', '2024-05-30', NULL, NULL, NULL, 'PAUSADO');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
CREATE TABLE IF NOT EXISTS `pedidos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `projetista` varchar(255) DEFAULT NULL,
  `dr` varchar(255) DEFAULT NULL,
  `pac` varchar(255) DEFAULT NULL,
  `rep` varchar(255) DEFAULT NULL,
  `pedido` varchar(255) DEFAULT NULL,
  `dt` date DEFAULT NULL,
  `produto` varchar(255) DEFAULT NULL,
  `dataEntrega` date DEFAULT NULL,
  `fluxo` int DEFAULT NULL,
  `lote` varchar(100) NOT NULL,
  `cdgprod` text NOT NULL,
  `qtds` text NOT NULL,
  `descricao` text NOT NULL,
  `diasparaproduzir` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `pedidos`
--

INSERT INTO `pedidos` (`id`, `projetista`, `dr`, `pac`, `rep`, `pedido`, `dt`, `produto`, `dataEntrega`, `fluxo`, `lote`, `cdgprod`, `qtds`, `descricao`, `diasparaproduzir`) VALUES
(27, 'joao.avelar', 'Kleber Correa Leite', 'EPS', 'tatianecpmh', '11900', '2024-06-07', 'CUSTOMLIFE', '2024-06-27', 17, '0369/0424', 'PC-353-2', '1', 'RECONSTRUÇÃO PARA MAXILA ATRÓFICA TOTAL', 14),
(28, 'joao.avelar', 'Hugo Santos Cunha', 'FAVP', 'neandrobarbosa', '11834', '2024-06-07', 'SMARTMOLD - 7 mm - 7', '2024-06-13', NULL, '0142/0424', 'E200.011-I', '0', '0', 20),
(29, 'daniel.lima', 'Vanessa Rodrigues Pacífico', 'JAZ', 'neandrobarbosa', '11907', '2024-06-07', 'SMARTMOLD - 5 mm - 5', '2024-06-13', NULL, '', 'E200.011-H*ET41.001', '1*1', 'SMARTMOLD MENTO  PMMA*BROCA Ø1,6 x 21 x 100mm', 20),
(30, 'daniel.lima', 'Saul Peñaloza', 'CHK', 'saulzapatta', '11887', '2024-06-07', 'RECONSTRUÇÃO ÓSSEA', '2024-06-30', 17, '0311/0424', 'PC-303-T2', '1', 'RECONSTRUÇÃO MANDIBULA TITÂNIO TRABECULADO - 2', 15),
(31, 'pedro.franco', 'Danielle Sales Marques Da Cruz Pantoja', 'WMP', 'neandrobarbosa', '11870', '2024-06-07', 'SMARTMOLD - 10 mm - ', '2024-06-30', NULL, '0258/0424', 'E200.011-H*E200.011-J', '1*1', 'SMARTMOLD MENTO  PMMA*SMARTMOLD ANG DE MANDIBULA  PMMA - Dir + Esq', 15),
(32, 'joao.avelar', 'Carlos Contreras', 'NFS', 'saulzapatta', '11796', '2024-06-07', 'ORTOGNÁTICA', '2024-06-28', 38, '0061/0424', 'KITPC-505D*KITPC-6002', '1*1', 'SISTEMA ATM TITÂNIO TRABECULADO COM SLA / PAR. BLOQUEADO E FOSSA SINTERIZADA DE 30º - D - 1*ORTOGNATICA SOB MEDIDA MAXILA, MANDIBULA E MENTO', 15),
(33, 'joao.avelar', 'Marcos Vidal Rivas', 'DNJ', 'neandrobarbosa', '11893', '2024-06-07', 'CUSTOMLIFE', '2024-06-27', 17, '0329/0424', 'PC-353-2', '1', 'RECONSTRUÇÃO PARA MAXILA ATRÓFICA TOTAL', 14);

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto`
--

DROP TABLE IF EXISTS `produto`;
CREATE TABLE IF NOT EXISTS `produto` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL,
  `codigo` varchar(50) DEFAULT NULL,
  `idfluxo` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idfluxo` (`idfluxo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `idStatus` int NOT NULL,
  `dataRealizacao` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=109 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `realizacaoproducao`
--

INSERT INTO `realizacaoproducao` (`id`, `idPedido`, `idFluxo`, `numOrdem`, `idEtapa`, `idStatus`, `dataRealizacao`) VALUES
(93, 27, 17, 15, 13, 1, '2024-06-28'),
(92, 27, 17, 14, 18, 1, '2024-06-27'),
(91, 27, 17, 13, 35, 1, '2024-06-26'),
(90, 27, 17, 12, 52, 1, '2024-06-25'),
(89, 27, 17, 11, 23, 1, '2024-06-24'),
(88, 27, 17, 10, 33, 1, '2024-06-21'),
(87, 27, 17, 9, 65, 1, '2024-06-20'),
(86, 27, 17, 8, 4, 1, '2024-06-19'),
(85, 27, 17, 7, 31, 1, '2024-06-18'),
(84, 27, 17, 6, 1, 1, '2024-06-17'),
(83, 27, 17, 5, 88, 1, '2024-06-14'),
(82, 27, 17, 4, 87, 1, '2024-06-13'),
(81, 27, 17, 3, 28, 1, '2024-06-12'),
(80, 27, 17, 2, 74, 1, '2024-06-11'),
(79, 27, 17, 1, 72, 1, '2024-06-10'),
(78, 33, 17, 15, 13, 1, '2024-06-28'),
(77, 33, 17, 14, 18, 1, '2024-06-27'),
(76, 33, 17, 13, 35, 1, '2024-06-26'),
(75, 33, 17, 12, 52, 1, '2024-06-25'),
(74, 33, 17, 11, 23, 1, '2024-06-24'),
(73, 33, 17, 10, 33, 1, '2024-06-21'),
(72, 33, 17, 9, 65, 1, '2024-06-20'),
(71, 33, 17, 8, 4, 1, '2024-06-19'),
(70, 33, 17, 7, 31, 1, '2024-06-18'),
(69, 33, 17, 6, 1, 1, '2024-06-17'),
(68, 33, 17, 5, 88, 1, '2024-06-14'),
(67, 33, 17, 4, 87, 1, '2024-06-13'),
(66, 33, 17, 3, 28, 1, '2024-06-12'),
(65, 33, 17, 2, 74, 4, '2024-06-11'),
(64, 33, 17, 1, 72, 1, '2024-06-10'),
(94, 30, 17, 1, 72, 4, '2024-06-10'),
(95, 30, 17, 2, 74, 4, '2024-06-11'),
(96, 30, 17, 3, 28, 1, '2024-06-12'),
(97, 30, 17, 4, 87, 1, '2024-06-13'),
(98, 30, 17, 5, 88, 1, '2024-06-14'),
(99, 30, 17, 6, 1, 1, '2024-06-17'),
(100, 30, 17, 7, 31, 1, '2024-06-18'),
(101, 30, 17, 8, 4, 1, '2024-06-19'),
(102, 30, 17, 9, 65, 1, '2024-06-20'),
(103, 30, 17, 10, 33, 1, '2024-06-21'),
(104, 30, 17, 11, 23, 1, '2024-06-24'),
(105, 30, 17, 12, 52, 1, '2024-06-25'),
(106, 30, 17, 13, 35, 1, '2024-06-26'),
(107, 30, 17, 14, 18, 1, '2024-06-27'),
(108, 30, 17, 15, 13, 1, '2024-06-28');

-- --------------------------------------------------------

--
-- Estrutura da tabela `statusetapa`
--

DROP TABLE IF EXISTS `statusetapa`;
CREATE TABLE IF NOT EXISTS `statusetapa` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  `tipo` varchar(255) DEFAULT NULL,
  `cor` varchar(7) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `statusetapa`
--

INSERT INTO `statusetapa` (`id`, `nome`, `tipo`, `cor`) VALUES
(1, 'Aguardando', 'Todos', '#4F4F51'),
(2, 'Fazendo', 'Todos', '#007bff'),
(3, 'Pausado', 'Todos', '#ee7624'),
(4, 'Concluído', 'Produção', '#28a745'),
(5, 'Aprovado', 'Qualidade', '#28a745'),
(6, 'Reprovado', 'Qualidade', '#dc3545'),
(7, 'Aguardando R.', 'Produção', '#4F4F51'),
(8, 'Fazendo R.', 'Produção', '#007bff'),
(9, 'Pausado R.', 'Produção', '#ee7624'),
(10, 'Concluído R.', 'Produção', '#28a745');

-- --------------------------------------------------------

--
-- Estrutura da tabela `statusos`
--

DROP TABLE IF EXISTS `statusos`;
CREATE TABLE IF NOT EXISTS `statusos` (
  `stId` int NOT NULL AUTO_INCREMENT,
  `stNome` varchar(30) NOT NULL,
  `stPosicao` int NOT NULL,
  PRIMARY KEY (`stId`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

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
-- Estrutura da tabela `tempo_corrido`
--

DROP TABLE IF EXISTS `tempo_corrido`;
CREATE TABLE IF NOT EXISTS `tempo_corrido` (
  `id` int NOT NULL AUTO_INCREMENT,
  `idPedido` int DEFAULT NULL,
  `idEtapa` int DEFAULT NULL,
  `tempoCorrido` time DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipocadastroexterno`
--

DROP TABLE IF EXISTS `tipocadastroexterno`;
CREATE TABLE IF NOT EXISTS `tipocadastroexterno` (
  `tpcadexId` int NOT NULL AUTO_INCREMENT,
  `tpcadexCodCadastro` varchar(10) NOT NULL,
  `tpcadexNome` varchar(30) NOT NULL,
  PRIMARY KEY (`tpcadexId`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipocadastrointerno`
--

DROP TABLE IF EXISTS `tipocadastrointerno`;
CREATE TABLE IF NOT EXISTS `tipocadastrointerno` (
  `tpcadinId` int NOT NULL AUTO_INCREMENT,
  `tpcadinCodCadastro` varchar(10) NOT NULL,
  `tpcadinNome` varchar(20) NOT NULL,
  PRIMARY KEY (`tpcadinId`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

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

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `usersId` int NOT NULL AUTO_INCREMENT,
  `usersName` varchar(128) NOT NULL,
  `usersEmail` varchar(128) NOT NULL,
  `usersUid` varchar(128) NOT NULL,
  `usersPerm` varchar(128) NOT NULL,
  `usersPwd` varchar(128) NOT NULL,
  `usersAprov` varchar(20) NOT NULL,
  `usersUf` varchar(11) DEFAULT NULL,
  `usersIdentificador` varchar(128) DEFAULT NULL,
  `usersCel` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`usersId`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`usersId`, `usersName`, `usersEmail`, `usersUid`, `usersPerm`, `usersPwd`, `usersAprov`, `usersUf`, `usersIdentificador`, `usersCel`) VALUES
(1, 'Vanessa Paz Araújo Paiva', 'vanessa.paiva@fixgrupo.com.br', 'vanessa', '1ADM', '$2y$10$VEZ2rmjLA8Bi7FcMWpWt6.uw1I56NSr15MbETMuD3109o8.lLF0Iu', 'APROV', 'DF', '123456', '(61) 98365-2810'),
(8, 'Sullivan Maciel Morbeck', 'sullivan.morbeck@fixhealth.com.br', 'smorbeckcpmh', '3COL', '$2y$10$TZYl13zhPPR0Hfg3fHFkw.BmNbeONomYJoX2gEDN3OVP93wa/4SZ2', 'APROV', 'DF', 'smorbeckcpmh', '(61) 98479-7922'),
(7, 'Evellyn Pamplona', 'evellyn.pamplona@fixhealth.com.br', 'evellyn', '2GES', '$2y$10$BR2tVeooGe0BVZxZlT8b1umG1z6qX3Ndp8Dk7WEN1FD4VGjLSCo9K', 'APROV', 'DF', '1111', '6130288856'),
(6, 'Antonia Felix', 'antonia.santos@fixhealth.com.br', 'antonia', '2GES', '$2y$10$RuNicEZcmcRwu./ySZjMkuzQoLJirGqCKkv8jwekeFxl3G6xyRJeu', 'APROV', 'DF', '123', '(61) 30288-868'),
(12, 'Joice Censi', 'joice.censi@fixhealth.com.br', 'joicecensi', '3COL', '$2y$10$VEZ2rmjLA8Bi7FcMWpWt6.uw1I56NSr15MbETMuD3109o8.lLF0Iu', 'APROV', 'DF', NULL, '8871');

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `correlacao_produto`
--
ALTER TABLE `correlacao_produto`
  ADD CONSTRAINT `correlacao_produto_ibfk_1` FOREIGN KEY (`idProdutoPrincipal`) REFERENCES `produto` (`id`),
  ADD CONSTRAINT `correlacao_produto_ibfk_2` FOREIGN KEY (`idProdutoSecundario`) REFERENCES `produto` (`id`);

--
-- Limitadores para a tabela `etapa_fluxo`
--
ALTER TABLE `etapa_fluxo`
  ADD CONSTRAINT `etapa_fluxo_ibfk_1` FOREIGN KEY (`idfluxo`) REFERENCES `fluxo` (`id`),
  ADD CONSTRAINT `etapa_fluxo_ibfk_2` FOREIGN KEY (`idetapa`) REFERENCES `etapa` (`id`);

--
-- Limitadores para a tabela `produto`
--
ALTER TABLE `produto`
  ADD CONSTRAINT `produto_ibfk_1` FOREIGN KEY (`idfluxo`) REFERENCES `fluxo` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
