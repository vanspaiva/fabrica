-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 17/06/2024 às 14:07
-- Versão do servidor: 10.11.7-MariaDB-cll-lve
-- Versão do PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `u777557116_bdcpmhfabrica`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `colaborador_etapas`
--

CREATE TABLE IF NOT EXISTS `colaborador_etapas` (
  `id` int(11) NOT NULL,
  `idUser` int(11) DEFAULT NULL,
  `idEtapa` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `correlacao_produto`
--

CREATE TABLE IF NOT EXISTS `correlacao_produto` (
  `id` int(11) NOT NULL,
  `idProdutoPrincipal` int(11) DEFAULT NULL,
  `idProdutoSecundario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `estados`
--

CREATE TABLE IF NOT EXISTS `estados` (
  `ufId` int(11) NOT NULL,
  `ufNomeExtenso` varchar(100) NOT NULL,
  `ufAbreviacao` varchar(2) NOT NULL,
  `ufRegiao` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Despejando dados para a tabela `estados`
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
(27, 'Tocantins', 'TO', 'Norte');

-- --------------------------------------------------------

--
-- Estrutura para tabela `etapa`
--

CREATE TABLE IF NOT EXISTS `etapa` (
  `id` int(11) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `parametro1` text DEFAULT NULL,
  `parametro2` text DEFAULT NULL,
  `iterev` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Despejando dados para a tabela `etapa`
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
-- Estrutura para tabela `etapasos`
--

CREATE TABLE IF NOT EXISTS `etapasos` (
  `etapaId` int(11) NOT NULL,
  `etapaNome` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Despejando dados para a tabela `etapasos`
--

INSERT INTO `etapasos` (`etapaId`, `etapaNome`) VALUES
(1, 'Jateamento'),
(5, 'Limpeza 1'),
(3, 'Anodização'),
(6, 'Limpeza 2'),
(7, 'Inspeção'),
(8, 'Embalagem'),
(10, 'Gravação'),
(11, 'Impressão Titânio'),
(12, 'Impressão Filamento/Resina'),
(13, 'Usinagem');

-- --------------------------------------------------------

--
-- Estrutura para tabela `etapa_fluxo`
--

CREATE TABLE IF NOT EXISTS `etapa_fluxo` (
  `id` int(11) NOT NULL,
  `idfluxo` int(11) NOT NULL,
  `idetapa` int(11) NOT NULL,
  `ordem` int(11) NOT NULL,
  `duracao` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Despejando dados para a tabela `etapa_fluxo`
--

INSERT INTO `etapa_fluxo` (`id`, `idfluxo`, `idetapa`, `ordem`, `duracao`) VALUES
(1, 1, 79, 1, 0),
(2, 1, 88, 2, 18),
(3, 1, 82, 3, 0),
(4, 1, 31, 4, 1),
(5, 1, 3, 5, 9),
(6, 1, 23, 6, 1),
(7, 1, 52, 7, 2),
(8, 1, 35, 8, 1),
(9, 1, 13, 9, 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `filedownload`
--

CREATE TABLE IF NOT EXISTS `filedownload` (
  `fileId` int(11) NOT NULL,
  `fileRealName` text NOT NULL,
  `fileOsRef` int(11) NOT NULL,
  `filePath` varchar(500) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Despejando dados para a tabela `filedownload`
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
(19, 'https://firebasestorage.googleapis.com/v0/b/sistemas-fabrica.appspot.com/o/myimages%2F1252shelf-desktop-fenh3cg20lhwdbvx.jpg?alt=media&token=ee24878a-f816-4fd4-9639-a99c1f4b020b', 14, '../arquivos/14'),
(20, 'https://firebasestorage.googleapis.com/v0/b/sistemas-fabrica.appspot.com/o/myimages%2F6526shelf-desktop-fenh3cg20lhwdbvx.zip?alt=media&token=1064b479-48e0-40d2-b0d5-1f892061b223', 15, '../arquivos/15'),
(21, 'https://firebasestorage.googleapis.com/v0/b/sistemas-fabrica.appspot.com/o/arquivosOS%2F89879%2F2779qrdoce-form-evento.png?alt=media&token=84a4642a-75e5-4360-8a49-6bf98a550b56', 16, '../arquivos/16'),
(22, 'https://firebasestorage.googleapis.com/v0/b/sistemas-fabrica.appspot.com/o/arquivosOS%2F0038%2F0424%2F19378156288%20(3).pdf?alt=media&token=3efd4aca-4d76-4c1b-a2ea-fa9c8d1c1113', 17, '../arquivos/17'),
(23, '', 18, '../arquivos/18'),
(24, '', 19, '../arquivos/19'),
(25, '', 20, '../arquivos/20'),
(26, 'https://firebasestorage.googleapis.com/v0/b/sistemas-fabrica.appspot.com/o/arquivosOS%2FN%2FA%2F2967pr%C3%B3tese%20para%20ensaio.zip?alt=media&token=2fa4aee0-5ffc-421b-9845-d6be6c565408', 21, '../arquivos/21'),
(27, '', 22, '../arquivos/22'),
(28, '', 23, '../arquivos/23'),
(29, '', 24, '../arquivos/24'),
(30, '', 25, '../arquivos/25'),
(31, 'https://firebasestorage.googleapis.com/v0/b/sistemas-fabrica.appspot.com/o/arquivosOS%2F0157%2F0524%2F5302REGISTRO_BIOM_11986.png?alt=media&token=94edd0ca-1ae5-45e2-a78f-3ed166f20442', 26, '../arquivos/26'),
(32, '', 27, '../arquivos/27'),
(33, '', 28, '../arquivos/28'),
(34, 'https://firebasestorage.googleapis.com/v0/b/sistemas-fabrica.appspot.com/o/arquivosOS%2Fxxx%2F3188A920.X74-DX.%20-%20Placa%202%2C0%20Ancoragem%20Trava%20Fio%20YY%2030%C2%BA%20-%20Direita%20%5BLASER%20CUT%20-%20LONGA%5D.DXF?alt=media&token=e4b8015b-fd47-43b9-9c49-915356e1fe05', 29, '../arquivos/29');

-- --------------------------------------------------------

--
-- Estrutura para tabela `fluxo`
--

CREATE TABLE IF NOT EXISTS `fluxo` (
  `id` int(11) NOT NULL,
  `nome` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Despejando dados para a tabela `fluxo`
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
-- Estrutura para tabela `logatividades`
--

CREATE TABLE IF NOT EXISTS `logatividades` (
  `logId` int(11) NOT NULL,
  `logOsRef` varchar(100) NOT NULL,
  `logHorario` timestamp NOT NULL DEFAULT current_timestamp(),
  `logStatus` varchar(50) NOT NULL,
  `logUser` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Despejando dados para a tabela `logatividades`
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
(52, '14', '2024-05-21 10:22:40', 'EM ANDAMENTO', 'evellyn'),
(53, '15', '2024-05-21 10:23:00', 'EM ANDAMENTO', 'evellyn'),
(54, '15', '2024-05-21 10:23:05', 'CONCLUÍDO', 'evellyn'),
(55, '14', '2024-05-21 13:15:09', 'CONCLUÍDO', 'vanessapaiva'),
(56, '16', '2024-05-28 14:14:58', 'EM ANDAMENTO', 'vanessapaiva'),
(57, '16', '2024-05-28 14:15:01', 'PAUSADO', 'vanessapaiva'),
(58, '16', '2024-05-28 14:15:03', 'EM ANDAMENTO', 'vanessapaiva'),
(59, '16', '2024-05-28 14:15:05', 'CONCLUÍDO', 'vanessapaiva'),
(60, '20', '2024-05-30 14:22:16', 'EM ANDAMENTO', 'joicecensi'),
(61, '17', '2024-05-30 14:22:53', 'EM ANDAMENTO', 'joicecensi'),
(62, '20', '2024-05-30 14:23:08', 'CRIADO', 'joicecensi'),
(63, '19', '2024-05-30 14:23:19', 'CRIADO', 'joicecensi'),
(64, '19', '2024-05-30 14:24:19', 'EM ANDAMENTO', 'joicecensi'),
(65, '22', '2024-06-04 12:00:35', 'CONCLUÍDO', 'joicecensi'),
(66, '17', '2024-06-04 12:01:04', 'EM ANDAMENTO', 'joicecensi'),
(67, '17', '2024-06-04 12:01:58', 'CONCLUÍDO', 'joicecensi'),
(68, '19', '2024-06-04 12:02:17', 'EM ANDAMENTO', 'joicecensi'),
(69, '19', '2024-06-04 12:02:28', 'CONCLUÍDO', 'joicecensi'),
(70, '20', '2024-06-04 12:02:43', 'CRIADO', 'joicecensi'),
(71, '20', '2024-06-04 12:02:55', 'CONCLUÍDO', 'joicecensi'),
(72, '23', '2024-06-05 10:02:26', 'CONCLUÍDO', 'joicecensi'),
(73, '21', '2024-06-06 10:04:57', 'CONCLUÍDO', 'joicecensi'),
(74, '24', '2024-06-06 10:05:14', 'CONCLUÍDO', 'joicecensi'),
(75, '19', '2024-06-07 09:56:14', 'EM ANDAMENTO', 'joicecensi'),
(76, '21', '2024-06-07 09:56:29', 'EM ANDAMENTO', 'joicecensi'),
(77, '25', '2024-06-11 11:06:03', 'CRIADO', 'joicecensi'),
(78, '25', '2024-06-11 11:06:14', 'EM ANDAMENTO', 'joicecensi'),
(79, '26', '2024-06-12 16:22:29', 'CONCLUÍDO', 'joicecensi'),
(80, '29', '2024-06-13 18:08:33', 'CRIADO', 'smorbeckcpmh');

-- --------------------------------------------------------

--
-- Estrutura para tabela `log_atividades_producao`
--

CREATE TABLE IF NOT EXISTS `log_atividades_producao` (
  `id` int(11) NOT NULL,
  `idRealizacaoProducao` int(11) DEFAULT NULL,
  `idEtapa` int(11) NOT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `idStatus` int(11) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `hora` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Despejando dados para a tabela `log_atividades_producao`
--

INSERT INTO `log_atividades_producao` (`id`, `idRealizacaoProducao`, `idEtapa`, `idUsuario`, `idStatus`, `data`, `hora`) VALUES
(1, 0, 72, 1, 2, '2024-06-17', '10:57:15');

-- --------------------------------------------------------

--
-- Estrutura para tabela `mesesano`
--

CREATE TABLE IF NOT EXISTS `mesesano` (
  `mesId` int(11) NOT NULL,
  `mesNum` int(11) NOT NULL,
  `mesNome` varchar(20) NOT NULL,
  `mesAbrv` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `mesesano`
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
-- Estrutura para tabela `ordenmanutencao`
--

  CREATE TABLE `ordenmanutencao` (
  `omId` int(11) NOT NULL,
  `omUserCriador` varchar(200) NOT NULL,
  `omNomeCriador` varchar(200) NOT NULL,
  `omEmailCriador` varchar(200) NOT NULL,
  `omDtCriacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `omDtUpdate` timestamp NOT NULL DEFAULT current_timestamp(),
  `omUserIp` varchar(20) NOT NULL,
  `omSetor` varchar(200) DEFAULT NULL,
  `omDescricao` varchar(200) NOT NULL,
  `omNomeArquivo` text DEFAULT NULL,
  `omGrauUrgencia` varchar(10) NOT NULL,
  `omObs` text DEFAULT NULL,
  `omStatus` varchar(20) NOT NULL,
  `omTipoManutencao` varchar(100) DEFAULT NULL,
  `omOperacional` varchar(100) DEFAULT NULL,
  `omAcaoQualidade` varchar(3) DEFAULT NULL,
  `omRequalificar` varchar(3) DEFAULT NULL,
  `omIdRespRequalificar` int(11) DEFAULT NULL,
  `omIdRespManutencao` int(11) DEFAULT NULL,
  `idMaquina` varchar(50) DEFAULT NULL,
  `omNomeMaquina` varchar(100) DEFAULT NULL,
  `omIdentificadorMaquina` varchar(255) DEFAULT NULL,
  `tempoNaoOperacional` varchar(255) DEFAULT NULL,
  `desAlinhamento` varchar(255) DEFAULT NULL,
  `dataAlinhamento` date DEFAULT NULL
   CONSTRAINT `fk_ordem_maquina_id` FOREIGN KEY (`idMaquina`) REFERENCES `om_maquina` (`idMaquina`);
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `ordenmanutencao`
--

INSERT INTO `ordenmanutencao` (`omId`, `omUserCriador`, `omNomeCriador`, `omEmailCriador`, `omDtCriacao`, `omDtUpdate`, `omUserIp`, `omSetor`, `omDescricao`, `omNumMaquina`, `omNomeMaquina`, `omNomeArquivo`, `omGrauUrgencia`, `omDtEntregasDesejada`, `omDtEntregaReal`, `dtExecucao`, `omObs`, `omStatus`) VALUES
(1, 'Administrador', 'vanessapaiva', 'vanessa.paiva@fixgrupo.com.br', '2024-06-17 13:47:49', '2024-06-17 13:47:49', '127.0.0.1', ' Anodização', 'aGFDDH DGDFGD ', '1234', 'TESTE 123', NULL, '3', '2024-06-21', NULL, NULL, NULL, 'CRIADO');

-- --------------------------------------------------------

--
-- Estrutura para tabela `ordenservico`
--

CREATE TABLE IF NOT EXISTS `ordenservico` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Despejando dados para a tabela `ordenservico`
--

INSERT INTO `ordenservico` (`osId`, `osUserCriador`, `osNomeCriador`, `osEmailCriador`, `osDtCriacao`, `osDtUpdate`, `osUserIp`, `osSetor`, `osDescricao`, `osLote`, `osNPed`, `osNomeArquivo`, `osGrauUrgencia`, `osDtEntregasDesejada`, `osDtEntregaReal`, `dtExecucao`, `osObs`, `osStatus`) VALUES
(22, 'Colaborador(a)', 'taniaoliveira', 'tania.oliveira@fixhealth.com.br', '2024-06-04 11:39:10', '2024-06-04 11:39:10', '127.0.0.1', 'Anodização', 'É preciso fazer outro template pois o silicone foi reprovado e teve que ser per', '0038/0524', '11925', '', '5', '2024-06-04', '2024-06-04', '2024-06-04', 'Urgente!!!', 'CONCLUÍDO'),
(20, 'Colaborador(a)', 'joicecensi', 'joice.censi@fixhealth.com.br', '2024-05-30 14:19:21', '2024-05-30 14:19:21', '127.0.0.1', 'Impressão Filamento/Resina', 'Fazer reimpressão em PLA do Biomodelo. ', '0048/0524', '11926', '', '2', '2024-05-30', '2024-05-31', '2024-06-04', '', 'CONCLUÍDO'),
(19, 'Colaborador(a)', 'lucassousa', 'lucas.sousa@fixhealth.com.br', '2024-05-29 19:38:00', '2024-05-29 19:38:00', '127.0.0.1', 'Impressão Titânio', 'Realizar impressão dos copos de prova de acordo com o protocolo de impressão de corpos de prova utilizando PÓ OVERSIZE Ti-6AL-4V.', '', '', '', '4', '2024-06-07', '2024-05-31', '2024-06-04', 'Protocolo de impressão impresso e será entregue juntamente com a O.S.', 'EM ANDAMENTO'),
(17, 'Colaborador(a)', 'taniaoliveira', 'tania.oliveira@fixhealth.com.br', '2024-05-29 18:42:57', '2024-05-29 18:42:57', '127.0.0.1', 'Anodização', 'Preciso fazer o template do fastmold, para ser testado no mold', '0038/0424', '11925', 'https://firebasestorage.googleapis.com/v0/b/sistemas-fabrica.appspot.com/o/arquivosOS%2F0038%2F0424%2F19378156288%20(3).pdf?alt=media&token=3efd4aca-4d76-4c1b-a2ea-fa9c8d1c1113', '5', '2024-05-29', '2024-05-30', '2024-06-04', 'Preciso o mais rápido possível ', 'CONCLUÍDO'),
(21, 'Colaborador(a)', 'gabrielfreitas', 'gabriel.freitas@fixhealth.com.br', '2024-05-30 14:55:50', '2024-05-30 14:55:50', '127.0.0.1', 'Impressão Titânio', 'Deve ser usinada em titânio F136 (mesmo material em que são usinadas as ATMs de estoque) corpos de prova que serão usados para ensaio de desmontagem da cabeça condilar.', 'N/A', '', 'https://firebasestorage.googleapis.com/v0/b/sistemas-fabrica.appspot.com/o/arquivosOS%2FN%2FA%2F2967pr%C3%B3tese%20para%20ensaio.zip?alt=media&token=2fa4aee0-5ffc-421b-9845-d6be6c565408', '4', '2024-06-03', '2024-06-06', '', 'Não há setor de usinagem, por isso coloquei como impressão em titânio.', 'EM ANDAMENTO'),
(23, 'Colaborador(a)', 'jefersonlucas', 'jeferson.lucas@fixhealth.com.br', '2024-06-04 18:24:19', '2024-06-04 18:24:19', '127.0.0.1', 'Embalagem', 'Boa tarde , \r\nSolicito o serviço de embalagem das seguintes quantidades de parafusos :\r\n A920.501-07-MP  = 200 UNIDADES \r\nA920.501-10 - MP = 100 UNIDADES \r\nA920.502-05-MP = 500 UNIDADES \r\n Lembrando q', '.', '.', '', '5', '2024-06-07', '2024-06-04', '2024-06-05', 'Necessitamos o quanto antes pois nosso estoque se encontra baixo e temos cursos em vista para atendermos .', 'CONCLUÍDO'),
(24, 'Colaborador(a)', 'jefersonlucas', 'jeferson.lucas@fixhealth.com.br', '2024-06-05 12:46:44', '2024-06-05 12:46:44', '127.0.0.1', 'Embalagem', 'Embalar 500 parafusos auto perfurante . \r\nA920.501-05-MP  \r\nOs parafusos precisam ser entregues no estoque como Produto acabado .', '.', '.', '', '5', '2024-06-05', '2024-06-05', '2024-06-06', '', 'CONCLUÍDO'),
(25, 'Colaborador(a)', 'jefersonlucas', 'jeferson.lucas@fixhealth.com.br', '2024-06-10 13:10:35', '2024-06-10 13:10:35', '127.0.0.1', 'Gravação', 'gravar o nome OSTEOFIX nas peças de mão contem 3 unidades . ', '.', '.', '', '5', '2024-06-10', '2024-06-11', '', '', 'EM ANDAMENTO'),
(26, 'Colaborador(a)', 'joicecensi', 'joice.censi@fixhealth.com.br', '2024-06-11 12:16:39', '2024-06-11 12:16:39', '127.0.0.1', 'Impressão Filamento/Resina', 'Impressão de Biomodelo Pré operatório de mandíbula. \r\nSolicitação Dr. Hugo. \r\n\r\nOS para fins de registro. \r\nVou gerar a OP para colocar em produção. ', '0157/0524', '11986', 'https://firebasestorage.googleapis.com/v0/b/sistemas-fabrica.appspot.com/o/arquivosOS%2F0157%2F0524%2F5302REGISTRO_BIOM_11986.png?alt=media&token=94edd0ca-1ae5-45e2-a78f-3ed166f20442', '3', '2024-06-14', '2024-06-11', '2024-06-12', '', 'CONCLUÍDO'),
(27, 'Colaborador(a)', 'joicecensi', 'joice.censi@fixhealth.com.br', '2024-06-12 19:24:12', '2024-06-12 19:24:12', '127.0.0.1', ' Usinagem', 'XXXX', 'XXX', 'XXX', '', '', '2024-06-13', NULL, NULL, NULL, 'CRIADO'),
(28, 'Colaborador(a)', 'smorbeckcpmh', 'sullivan.morbeck@fixhealth.com.br', '2024-06-13 17:58:26', '2024-06-13 17:58:26', '127.0.0.1', ' Usinagem', 'Dispositivo para usinagem de chanfros das placas AncorFix, séries A920.X73 e A920.X74.', 'N/A', 'N/A', '', '5', '2024-06-14', NULL, NULL, 'A usinagem deste dispositivo é necessária para realização da produção das placas para ensaio mecânico.', 'CRIADO'),
(29, 'Colaborador(a)', 'smorbeckcpmh', 'sullivan.morbeck@fixhealth.com.br', '2024-06-13 18:07:11', '2024-06-13 18:07:11', '127.0.0.1', 'Usinagem', 'xxx', 'xxx', 'xxx', 'https://firebasestorage.googleapis.com/v0/b/sistemas-fabrica.appspot.com/o/arquivosOS%2Fxxx%2F3188A920.X74-DX.%20-%20Placa%202%2C0%20Ancoragem%20Trava%20Fio%20YY%2030%C2%BA%20-%20Direita%20%5BLASER%20CUT%20-%20LONGA%5D.DXF?alt=media&token=e4b8015b-fd47-43b9-9c49-915356e1fe05', '1', '2024-06-13', '2024-06-13', '2021-06-13', 'TESTE DE EXTENSÃO DE ARQUIVOS DA FERRAMENTA DE UPLOAD', 'CRIADO');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedidos`
--

CREATE TABLE IF NOT EXISTS `pedidos` (
  `id` int(11) NOT NULL,
  `projetista` varchar(255) DEFAULT NULL,
  `dr` varchar(255) DEFAULT NULL,
  `pac` varchar(255) DEFAULT NULL,
  `rep` varchar(255) DEFAULT NULL,
  `pedido` varchar(255) DEFAULT NULL,
  `dt` date DEFAULT NULL,
  `produto` varchar(255) DEFAULT NULL,
  `fluxo` int(11) DEFAULT NULL,
  `lote` varchar(100) DEFAULT NULL,
  `cdgprod` text DEFAULT NULL,
  `qtds` text DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `diasparaproduzir` int(11) DEFAULT NULL,
  `taxa_extra` int(11) DEFAULT NULL,
  `nacional_internacional` varchar(20) DEFAULT NULL,
  `obs` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Despejando dados para a tabela `pedidos`
--
/* 
INSERT INTO `pedidos` (`id`, `projetista`, `dr`, `pac`, `rep`, `pedido`, `dt`, `produto`, `dataEntrega`, `fluxo`, `lote`, `cdgprod`, `qtds`, `descricao`, `diasparaproduzir`, `taxa_extra`, `nacional_internacional`, `obs`) VALUES
(1, 'Lucas', 'Doutor Teste', 'ABC', 'julianaaguiar', '125456', '2024-06-07', 'ORTOGNÁTICA', '2024-07-05', 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Wilton', 'Farid Miguel Damen', 'GFCB', 'tatianecpmh', '12047', '2024-06-07', 'CUSTOMLIFE', NULL, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'joao.avelar', 'Sandro Lucas', 'MFRAC', 'neandrobarbosa', '12004', '2024-06-07', 'CUSTOMLIFE', NULL, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, NULL, 'Teste', 'ABC', NULL, '1234', '2024-06-17', NULL, '2024-07-15', 17, '1234', NULL, NULL, NULL, 20, 0, 'nacional', ''),
(5, NULL, 'Teste 1', 'Def', NULL, '1345', '2024-06-17', NULL, '2024-07-15', 17, '12445', NULL, NULL, NULL, 20, 0, 'nacional', 'e'); */

-- --------------------------------------------------------

--
-- Estrutura para tabela `produto`
--

CREATE TABLE IF NOT EXISTS `produto` (
  `id` int(11) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `codigo` varchar(50) DEFAULT NULL,
  `idfluxo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE IF NOT EXISTS `produtos` (
  `prodId` int(11) NOT NULL,
  `prodCodCallisto` varchar(48) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `prodDescricao` varchar(128) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `prodAnvisa` varchar(128) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `prodCategoria` varchar(48) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`prodId`, `prodCodCallisto`, `prodDescricao`, `prodAnvisa`, `prodCategoria`) VALUES
(7, 'E200.013-1 D', 'SMARTMOLD ZIGOMA PMMA - UNILATERAL Dir', '80859840124', 'CMF'),
(8, 'E200.013-1 E', 'SMARTMOLD ZIGOMA PMMA - UNILATERAL Esq', '80859840124', 'CMF'),
(9, 'E200.011-F', 'SMARTMOLD ZIGOMA PMMA - BILATERAL ', '80859840124', 'CMF'),
(11, 'E200.011-G', 'SMARTMOLD PARANASAL PMMA - Dir + Esq', '80859840124', 'CMF'),
(12, 'E200.011-H', 'SMARTMOLD MENTO  PMMA', '80859840124', 'CMF'),
(13, 'E200.011-I', 'SMARTMOLD MENTO BIPARTIDO PMMA', '80859840124', 'CMF'),
(14, 'E200.011-KD', 'SMARTMOLD ANG DE MANDIBULA  PMMA - DIR', '80859840124', 'CMF'),
(15, 'E200.011-KE', 'SMARTMOLD ANG DE MANDIBULA  PMMA - ESQ', '80859840124', 'CMF'),
(16, 'E200.011-J', 'SMARTMOLD ANG DE MANDIBULA  PMMA - Dir + Esq', '80859840124', 'CMF'),
(17, 'E200.011-L', 'SMARTMOLD PRÉ-MAXILA  ', '80859840124', 'CMF'),
(18, 'PC-703-MAN*', 'MESH MAND TITÂNIO SOB MEDIDA M', 'Licença Especial ', 'CRÂNIO'),
(19, 'PC-703-MAX*', 'MESH MAXILA TITÂNIO SOB MEDIDA M', 'Licença Especial ', 'CRÂNIO'),
(20, 'PC-704MAN*', 'MESH MAND TITÂNIO SOB MEDIDA G', 'Licença Especial ', 'CRÂNIO'),
(21, 'PC-704MAX*', 'MESH MAXILA TITÂNIO SOB MEDIDA G', 'Licença Especial', 'CRÂNIO'),
(22, 'E200.016-1*', 'FAST CMF CRANIO EM PMMA (s/ template <50cm3)', 'E- 80859840195', 'CRÂNIO'),
(23, 'E200.016-2*', 'FAST CMF CRANIO EM PMMA (s/ template >51cm3)', 'E- 80859840195', 'CRÂNIO'),
(24, 'E200.013-1', 'FASTMOLD CRANIO PMMA P < 30cm3', 'E - 80859849002', 'CRÂNIO'),
(25, 'E200.013-5*', ' FASTMOLD CRANIO PMMA M 31 a 60cm3', 'E - 80859849002', 'CRÂNIO'),
(26, 'E200.013-6*', 'FASTMOLD CRANIO PMMA  G > 61cm3', 'E - 80859849002', 'CRÂNIO'),
(27, 'PC-201-P1*', 'CRÂNIO SOB MEDIDA PEEK  P < 30cm³', 'Licença Especial', 'CRÂNIO'),
(28, 'PC-201-P2*', 'CRÂNIO SOB MEDIDA PEEK  M - 31 a 60cm3', 'Licença Especial ', 'CRÂNIO'),
(29, 'PC-201-P3*', 'CRÂNIO SOB MEDIDA  PEEK G > 61cm3', 'Licença Especial ', 'CRÂNIO'),
(30, 'PC-201-T1*', 'CRÂNIO TITÂNIO C/ TRABECULADO - P <30cm³', 'Licença Especial ', 'CRÂNIO'),
(31, 'PC-201-T2*', 'CRÂNIO TITÂNIO C/ TRABECULADO  - M - 31 a 60cm3', 'Licença Especial ', 'CRÂNIO'),
(32, 'PC-201-T3*', 'CRÂNIO TITÂNIO C/ TRABECULADO G > 61cm3', 'Licença Especial ', 'CRÂNIO'),
(33, 'PC-301-P1*', 'RECONSTRUÇÃO ORBITA EM PEEK - 1', 'Licença Especial', 'CMF'),
(34, 'PC-301-P2*', 'RECONSTRUÇÃO ORBITA EM PEEK - 2', 'Licença Especial ', 'CMF'),
(35, 'PC-302-P1*', 'RECONSTRUÇÃO MAXILAR EM PEEK - 1 ', 'Licença Especial ', 'CMF'),
(36, 'PC-302-P2*', 'RECONSTRUÇÃO MAXILAR EM PEEK - 2 ', 'Licença Especial ', 'CMF'),
(37, 'PC-303-P1*', 'RECONSTRUÇÃO MANDIBULAR EM PEEK - 1 ', 'Licença Especial ', 'CMF'),
(38, 'PC-303-P2*', 'RECONSTRUÇÃO MANDIBULAR EM PEEK - 2', 'Licença Especial ', 'CMF'),
(39, 'PC-304-P1*', 'RECONSTRUÇÃO  ZIGOMA PEEK - 1', 'Licença Especial ', 'CMF'),
(40, 'PC-304-P2*', 'RECONSTRUÇÃO  ZIGOMA PEEK  - 2', 'Licença Especial ', 'CMF'),
(41, 'PC-305-P1*', 'RECONSTRUÇÃO INFRAORBITÁRIO  EM PEEK - 1', 'Licença Especial ', 'CMF'),
(42, 'PC-305-P2*', 'RECONSTRUÇÃO INFRAORBITÁRIO  PEEK - 2', 'Licença Especial ', 'CMF'),
(43, 'PC-306-P1*', 'RECONSTRUÇÃO GLABELA PEEK-1', 'Licença Especial', 'CMF'),
(44, 'PC-306-P2*', 'RECONSTRUÇÃO GLABELA PEEK-2', 'Licença Especial', 'CMF'),
(45, 'PC-501-P1*', 'RECONSTRUÇÃO FRONTAL EM PEEK-1', 'Licença Especial', 'CMF'),
(46, 'PC-501-P2*', 'RECONSTRUÇÃO FRONTAL EM PEEK-2', 'Licença Especial', 'CMF'),
(47, 'PC-507-P1', 'RECONSTRUÇÃO ANG DE MAND. Dir.+Esq PEEK', 'Licença Especial', 'CMF'),
(48, 'PC-507-P2', 'RECONSTRUÇÃO ANG DE MAND. Esq PEEK', 'Licença Especial', 'CMF'),
(49, 'PC-507-P3', 'RECONSTRUÇÃO ANG DE MAND. Dir. PEEK', 'Licença Especial', 'CMF'),
(50, 'PC-402-P1 MEN*', 'RECONSTRUÇÃO MENTO PEEK 1', 'Licença Especial', 'CMF'),
(51, 'PC-402-P2 MEN*', 'RECONSTRUÇÃO MENTO PEEK 2', 'Licença Especial', 'Selecione categoria'),
(52, 'PC-301-T1*', 'RECONSTRUÇÃO ORBITA TIÂNIO TRABECULADO - 1', 'Licença Especial', 'CMF'),
(53, 'PC-301-T2*', 'RECONSTRUÇÃO ORBITA TIÂNIO TRABECULADO - 2', 'Licença Especial', 'CMF'),
(54, 'PC-302-T1*', 'RECONSTRUÇÃO MAXILA TITÂNIO TRABECULADO- 1 ', 'Licença Especial', 'CMF'),
(55, 'PC-302-T2*', 'RECONSTRUÇÃO MAXILA TITÂNIO TRABECULADO- 2 ', 'Licença Especial ', 'CMF'),
(56, 'PC-303-T1*', 'RECONSTRUÇÃO MANDIBULA TITÂNIO TRABECULADO - 1', 'Licença Especial', 'CMF'),
(57, 'PC-303-T2*', 'RECONSTRUÇÃO MANDIBULA TITÂNIO TRABECULADO - 2', 'Licença Especial', 'CMF'),
(58, 'PC-304-T1*', 'RECONSTRUÇÃO ZIGOMA TITÂNIO TRABECULADO- 1', 'Licença Especial', 'CMF'),
(59, 'PC-304-T2*', 'RECONSTRUÇÃO  ZIGOMA TITÂNIO TRABECULADO- 2', 'Licença Especial', 'CMF'),
(60, 'PC-305-T1*', 'RECONSTRUÇÃO INFRAORBITÁRIO TITÂNIO TRABECULADO - 1', 'Licença Especial', 'CMF'),
(61, 'PC-305-T2*', 'RECONSTRUÇÃO INFRAORBITÁRIO TITÂNIO TRABECULADO - 2', 'Licença Especial', 'CMF'),
(62, 'PC-306-T1*', 'RECONSTRUÇÃO GLABELA  TITÂNIO TRABECULADO- 1', 'Licença Especial', 'CMF'),
(63, 'PC-306-T2*', 'RECONSTRUÇÃO GLABELA  TITÂNIO TRABECULADO- 2', 'Licença Especial', 'CMF'),
(64, 'PC-402MEN ', 'RECONSTRUÇÃO MENTO TITÂNIO TRABECULADO- 1', 'Licença Especial', 'CMF'),
(65, 'PC-403MEN ', 'RECONSTRUÇÃO MENTO TITÂNIO TRABECULADO- 2', 'Licença Especial', 'CMF'),
(66, 'PC-507-T1 ', 'RECONSTRUÇÃO ANG DE MAND. Esq TITÂNIO TRABECULADO- 1', 'Licença Especial', 'CMF'),
(67, 'PC-507-T2 ', 'RECONSTRUÇÃO ANG DE MAND. Dir. TITÂNIO TRABECULADO- 2', 'Licença Especial', 'CMF'),
(68, 'PC-501-T1*', 'RECONSTRUÇÃO FRONTAL TITÂNIO TRABECULADO - 1', 'Licença Especial', 'CMF'),
(69, 'PC-501-T2*', 'RECONSTRUÇÃO FRONTAL TITÂNIO TRABECULADO - 2', 'Licença Especial', 'CMF'),
(70, 'KITPC-505D*', 'SISTEMA ATM TITÂNIO TRABECULADO COM SLA / PAR. BLOQUEADO E FOSSA SINTERIZADA DE 30º - D - 1', 'Licença Especial', 'CMF'),
(71, 'PC-700 MAX MAN', 'CUSTOMLIFE - RECONSTRUÇÃO MAXILA + MANDIBULA', 'Licença Especial', 'CMF'),
(72, 'KITPC-505E*', 'SISTEMA ATM TITÂNIO TRABECULADO COM SLA / PAR. BLOQUEADO E FOSSA SINTERIZADA DE 30º - E - 1', 'Licença Especial', 'CMF'),
(73, 'KITPC-506D*', 'SISTEMA ATM TITÂNIO TRABECULADO COM SLA / PAR. BLOQUEADO E FOSSA SINTERIZADA DE 30º - D - 2', 'Licença Especial', 'CMF'),
(74, 'KITPC-506E*', 'SISTEMA ATM TITÂNIO TRABECULADO COM SLA / PAR. BLOQUEADO E FOSSA SINTERIZADA DE 30º- E - 2', 'Licença Especial', 'CMF'),
(75, 'KITPC-6000', 'ORTOGNATICA SOB MEDIDA MAXILA', 'Licença Especial', 'CMF'),
(76, 'KITPC-6001', 'ORTOGNATICA SOB MEDIDA MANDIBULA', 'Licença Especial', 'CMF'),
(77, 'KITPC-6002', 'ORTOGNATICA SOB MEDIDA MAXILA, MANDIBULA E MENTO', 'Licença Especial', 'CMF'),
(78, 'PC-701-MAXP*', 'CUSTOMLIFE - RECONSTRUÇÃO MAXILA ATROFICA  PARCIAL', 'Licença Especial', 'CMF'),
(79, 'PC-701-MANP*', 'CUSTOMLIFE - RECONSTRUÇÃO MANDIBULA ATROFICA PARCIAL', 'Licença Especial', 'CMF'),
(80, 'ATA.B', 'ATA BUCO-MAXILO-FACIAL', 'N/A', 'ATA'),
(81, 'ATA.B 2976  - HOF', 'ATA HOF (Harmonização) ', 'N/A', 'ATA'),
(82, 'ATA.Cl', 'ATA COLUNA LOMBAR', 'N/A', 'ATA'),
(83, 'ATA.O', 'ATA OTORRINOLARINGISTA', 'N/A', 'ATA'),
(84, 'ATA.Cl', 'ATA COLUNA CERVICAL ', 'N/A', 'ATA'),
(85, 'ATA HOF', 'ATA pre smartmold (abatimento depois na compra so smartmold)', 'N/A', 'ATA'),
(86, 'ATA PP', 'ATA pre-projeto (abatimento depois no customlife) ', 'N/A', 'ATA'),
(87, 'ATA.OM', 'ATA OMBRO ', 'N/A', 'ATA'),
(88, 'E200.012-1', 'Guia de Osteotomia A / corticotomia', '80859840201', 'CMF'),
(89, 'E200.012-10', 'Guia de Osteotomia J / MAX ', '80859840201', 'CMF'),
(90, 'E200.012-11', 'Guia de Osteotomia K / MAND', '80859840201', 'CMF'),
(91, 'E200.012-12', 'Guia de Osteotomia L / mento ', '80859840201', 'CMF'),
(92, 'E200.012-13', 'Guia de Osteotomia M / cranio ', '80859840201', 'CMF'),
(93, 'E200.012-14', 'Guia de Osteotomia N', '80859840201', 'CMF'),
(94, 'E200.012-15', 'Guia de Osteotomia O', '80859840201', 'CMF'),
(95, 'E200.012-16', 'Guia de Osteotomia P / coluna ', '80859840201', 'CMF'),
(96, 'E200.007', 'Surgicalguide Intermediário', '80859840069', 'CMF'),
(97, 'E200.008', 'Surgicalguide Final', '80859840069', 'CMF'),
(98, 'P-5.00.01-D', 'Fossa articular P – Direita', '80859840212', 'CMF'),
(99, 'P-5.DF.01-D', 'Dispositivo fossa de corte e perfuração para articulação pequena - Direita', '80859840169', 'CMF'),
(100, 'P-5.10.01-D', 'Placa mandibular curta com cabeça condilar P - Direita', '80859840212', 'CMF'),
(102, 'P-5.20.01-D', 'Placa mandibular média com cabeça condilar P – Direita  ', '80859840212', 'CMF'),
(103, 'P-5.20.DM-D', 'Dispositivo mandibular MEDIA M para corte e perfuração - Direita', '80859840169', 'CMF'),
(104, 'P-5.30.01-D', 'Placa mandibular longa com cabeça condilar P – Direita', '80859840212', 'CMF'),
(105, 'P-5.30.DM-D', 'Dispositivo mandibular G para corte e perfuração – Direita', '80859840169', 'CMF'),
(106, 'P-5.00.01-E', ' Fossa Articular P', '80859840212', 'CMF'),
(107, 'P-5.DF.01-E', 'Dispositivo fossa de corte e perfuração para articulação pequena – esquerda', '80859840169', 'CMF'),
(108, 'P-5.10.01-E', 'Placa mandibular curta com cabeça condilar P - Esquerda', '80859840212', 'CMF'),
(109, 'P-5.10.DM-E', 'Dispositivo mandibular CURTA P para corte e perfuração – esquerda ', '80859840169', 'CMF'),
(110, 'P-5.20.01-E', 'Placa mandibular média com cabeça condilar P – Esquerda', '80859840212', 'CMF'),
(111, 'P-5.20.DM-E', 'Dispositivo mandibular MEDIA M para corte e perfuração – esquerda', '80859840169', 'CMF'),
(112, 'P-5.30.01-E', 'Placa mandibular longa com cabeça condilar P – Esquerda', '80859840212', 'CMF'),
(113, 'P-5.30.DM-E', 'Dispositivo mandibular LONGA G para corte e perfuração – esquerda ', '80859840169', 'CMF'),
(114, 'P-5.00.02-D', 'Fossa articular M – Direita', '80859840212', 'CMF'),
(115, 'P-5.DF.02-D', 'Dispositivo fossa de corte e perfuração para articulação média - Direita', '80859840169', 'CMF'),
(116, 'P-5.10.02-D', 'Placa mandibular curta com cabeça condilar M – Direita', '80859840212', 'CMF'),
(117, 'P-5.20.02-D', 'Placa mandibular média com cabeça condilar M – Direita ', '80859840212', 'CMF'),
(118, 'P-5.30.02-D', 'Placa mandibular longa com cabeça condilar M – Direita', '80859840212', 'CMF'),
(122, 'P-5.00.01-E', 'Fossa Articular M', '80859840212', 'CMF'),
(123, 'P-5.DF.02-E', 'Dispositivo fossa de corte e perfuração para articulação média – esquerda', '80859840169', 'CMF'),
(124, 'P-5.10.02-E', 'Placa mandibular curta com cabeça condilar M – Esquerda', '80859840212', 'CMF'),
(125, 'P-5.20.02-E', 'Placa mandibular média com cabeça condilar M – Esquerda', '80859840212', 'CMF'),
(126, 'P-5.30.02-E', 'Placa mandibular longa com cabeça condilar M – Esquerda', '80859840212', 'CMF'),
(127, 'P-5.10.DM-E', 'Dispositivo mandibular CURTA P para corte e perfuração – esquerda', '80859840169', 'CMF'),
(128, 'P-5.20.DM-E', 'Dispositivo mandibular MEDIA M para corte e perfuração – esquerda', '80859840169', 'CMF'),
(129, 'P-5.30.DM-E', 'Dispositivo mandibular LONGA G para corte e perfuração – esquerda', '80859840169', 'CMF'),
(130, 'PC-920.210', 'Parafuso 2,0 x 10 Bloqueado', '80859840212', 'EXTRA'),
(131, 'PC-920.205', 'Parafuso 2,0 x 05 Bloqueado', '80859840212', 'EXTRA'),
(132, 'PC-924.210', 'Parafuso 2,4 x 10 Bloqueado', '80859840212', 'EXTRA'),
(134, 'P-5.10.DM-D', 'Dispositivo mandibular P para corte e perfuração – Direita', '80859840169', 'CMF'),
(135, 'T30.200', 'Caixa ATM Super Instrumental', ' ', 'EXTRA'),
(136, 'T30.101', 'Caixa ATM Básica Parafusos', ' ', 'EXTRA'),
(137, 'PC-702-MAXT*', 'CUSTOMLIFE - RECONSTRUÇÃO MAXILA ATROFICA TOTAL', 'Licença Especial', 'CMF'),
(138, 'PC-702-MANT*', 'CUSTOMLIFE - RECONSTRUÇÃO MANDIBULA ATROFICA TOTAL', 'Licença Especial', 'CMF');

-- --------------------------------------------------------

--
-- Estrutura para tabela `realizacaoproducao`
--

CREATE TABLE IF NOT EXISTS `realizacaoproducao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idPedido` int(11) DEFAULT NULL,
  `idFluxo` int(11) DEFAULT NULL,
  `numOrdem` int(11) DEFAULT NULL,
  `idEtapa` int(11) DEFAULT NULL,
  `idStatus` int(11) NOT NULL,
  `fazendo` date DEFAULT NULL,
  `dataPausado` date DEFAULT NULL,
  `dataRealizacao` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

ALTER TABLE `realizacaoproducao`
  ADD CONSTRAINT `realizacaoproducao_ibfk_1` FOREIGN KEY (`idPedido`) REFERENCES `pedidos` (`id`),
  ADD CONSTRAINT `realizacaoproducao_ibfk_2` FOREIGN KEY (`idFluxo`) REFERENCES `fluxo` (`id`),
  ADD CONSTRAINT `realizacaoproducao_ibfk_3` FOREIGN KEY (`idEtapa`) REFERENCES `etapa` (`id`);

--
-- Despejando dados para a tabela `realizacaoproducao`
--

INSERT INTO `realizacaoproducao` (`id`, `idPedido`, `idFluxo`, `numOrdem`, `idEtapa`, `idStatus`, `dataRealizacao`) VALUES
(0, 4, 17, 1, 72, 4, '2024-06-18');

-- --------------------------------------------------------

--
-- Estrutura para tabela `setor`
--

CREATE TABLE `setor` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `duracao` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `setor`
--

INSERT INTO `setor` (`id`, `nome`, `duracao`) VALUES
(12, 'EMBALAGEM ESTÉRIL', 2),
(11, 'INSPEÇÃO 3', 1),
(10, 'LIMPEZA', 2),
(9, 'GRAVAÇÃO', 1),
(8, 'INSPEÇÃO 2', 1),
(7, 'MOLDAGEM E ANODIZAÇÃO', 9),
(6, 'SLA E ANODIZAÇÃO', 9),
(5, 'INSPEÇÃO 1', 1),
(4, 'ACABAMENTO', 9),
(3, 'USINAGEM', 18),
(2, 'TRATAMENTO TÉRMICO', 18),
(1, 'PROGRAMAÇÃO E IMPRESSÃO', 18),
(13, 'ESTERILIZAÇÃO', 9),
(14, 'EMB ROTULAGEM FINAL', 2),
(15, 'LIBERAÇÃO FINAL', 2);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `setor`
--
ALTER TABLE `setor`
  ADD PRIMARY KEY (`id`);


-- --------------------------------------------------------

--
-- Estrutura para tabela `setor_etapa`
--

CREATE TABLE IF NOT EXISTS `setor_etapa` (
  `id` int(11) NOT NULL,
  `idsetor` int(11) NOT NULL,
  `idetapa` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `statusetapa`
--

CREATE TABLE IF NOT EXISTS `statusetapa` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `tipo` varchar(255) DEFAULT NULL,
  `cor` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Despejando dados para a tabela `statusetapa`
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
-- Estrutura para tabela `statusos`
--

CREATE TABLE IF NOT EXISTS `statusos` (
  `stId` int(11) NOT NULL,
  `stNome` varchar(30) NOT NULL,
  `stPosicao` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Despejando dados para a tabela `statusos`
--

INSERT INTO `statusos` (`stId`, `stNome`, `stPosicao`) VALUES
(5, 'CRIADO', 1),
(6, 'EM ANDAMENTO', 2),
(7, 'PAUSADO', 3),
(8, 'CONCLUÍDO', 4);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tempo_corrido`
--

CREATE TABLE IF NOT EXISTS `tempo_corrido` (
  `id` int(11) NOT NULL,
  `idPedido` int(11) DEFAULT NULL,
  `idEtapa` int(11) DEFAULT NULL,
  `tempoCorrido` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tipocadastroexterno`
--

CREATE TABLE IF NOT EXISTS `tipocadastroexterno` (
  `tpcadexId` int(11) NOT NULL,
  `tpcadexCodCadastro` varchar(10) NOT NULL,
  `tpcadexNome` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tipocadastrointerno`
--

CREATE TABLE IF NOT EXISTS `tipocadastrointerno` (
  `tpcadinId` int(11) NOT NULL,
  `tpcadinCodCadastro` varchar(10) NOT NULL,
  `tpcadinNome` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Despejando dados para a tabela `tipocadastrointerno`
--

INSERT INTO `tipocadastrointerno` (`tpcadinId`, `tpcadinCodCadastro`, `tpcadinNome`) VALUES
(1, '1ADM', 'Administrador'),
(11, '3COL', 'Colaborador(a)'),
(10, '2GES', 'Gestor(a)');

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE IF NOT EXISTS `users` (
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
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`usersId`, `usersName`, `usersEmail`, `usersUid`, `usersPerm`, `usersPwd`, `usersAprov`, `usersUf`, `usersIdentificador`, `usersCel`) VALUES
(1, 'Vanessa Paz Araújo Paiva', 'vanessa.paiva@fixgrupo.com.br', 'vanessapaiva', '1ADM', '$2y$10$ZEfQEoYPH6mSHTtSDRgCIugAPTECJP3CMs0ejrsnnvYJ0OSRSXiAO', 'APROV', 'DF', '123456', '(61) 98365-2810'),
(8, 'Sullivan Maciel Morbeck', 'sullivan.morbeck@fixhealth.com.br', 'smorbeckcpmh', '3COL', '$2y$10$TZYl13zhPPR0Hfg3fHFkw.BmNbeONomYJoX2gEDN3OVP93wa/4SZ2', 'APROV', 'DF', 'smorbeckcpmh', '(61) 98479-7922'),
(7, 'Evellyn Pamplona', 'evellyn.pamplona@fixhealth.com.br', 'evellyn', '2GES', '$2y$10$BR2tVeooGe0BVZxZlT8b1umG1z6qX3Ndp8Dk7WEN1FD4VGjLSCo9K', 'APROV', 'DF', '1111', '6130288856'),
(6, 'Antonia Felix', 'antonia.santos@fixhealth.com.br', 'antonia', '2GES', '$2y$10$RuNicEZcmcRwu./ySZjMkuzQoLJirGqCKkv8jwekeFxl3G6xyRJeu', 'APROV', 'DF', '123', '(61) 30288-868'),
(11, 'Sistemas Grupofix', 'sistemas@fixgrupo.com.br', 'sistemas', '3COL', '$2y$10$8AvfUdyqbc5YnruSOOrd9e0kpp0jJuWsuN8xwHq.fliM9MIMFAgly', 'APROV', 'DF', NULL, '8862'),
(17, 'Vanessa Paiva', 'vanespaiva@gmail.com', 'vanespaiva', '3COL', '$2y$10$PV19tgShDTriSvJMvnV60e8zCXn8WGqLw5jGHjspBOQB1Sldbr57S', 'APROV', 'DF', NULL, '8862'),
(14, 'Joice Censi', 'joice.censi@fixhealth.com.br', 'joicecensi', '3COL', '$2y$10$KmZdlONmqP02C5WUNIZG.uCiS7oeoIpRBcTQs1X1GNH7B4uaVHqLi', 'APROV', 'DF', NULL, '8871'),
(15, 'Lucas Mariano de Sousa', 'lucas.sousa@fixhealth.com.br', 'lucassousa', '3COL', '$2y$10$cz0fVjQU7IeSxhEz7vHgheCmsXkgiFfHlK7zfFriCZIIKoNBhG0m2', 'APROV', 'DF', NULL, '8863'),
(16, 'Tânia guedes de oliveira ', 'tania.oliveira@fixhealth.com.br', 'taniaoliveira', '3COL', '$2y$10$1kDuk17KzSceGcL4E4eJueY3ikZS1fjNJre5XfZBnJhzQGAPTRgVi', 'APROV', 'DF', NULL, '8856'),
(18, 'gabriel Luna Freitas', 'gabriel.freitas@fixhealth.com.br', 'gabrielfreitas', '3COL', '$2y$10$0ZPqOk30Uyf.Y/Nhnqe/6ekAxsTlasyuDb9doHaj12tpd18hhcqF2', 'APROV', 'DF', NULL, '8863'),
(19, 'jeferson lucas dos anjos', 'jeferson.lucas@fixhealth.com.br', 'jefersonlucas', '3COL', '$2y$10$gmFP4e1Ta4iZbgxt5.WknuglhOl6F/eJVt0qYOt2yaQOqQmvyDENy', 'APROV', 'DF', NULL, '8870'),
(20, 'Thais Tivelli', 'thais.tivelli@fixhealth.com.br', 'thaistivelli', '3COL', '$2y$10$Ta2If9s77I9feYVRKI7wYOBPyHVnenXq8J32yquvmIZ14F6sF3olu', 'APROV', 'DF', NULL, '8883'),
(21, 'Hellen Iasmin Cardoso de oliveira', 'hellen.oliveira@fixhealth.com.br', 'hellenoliveira', '3COL', '$2y$10$Z6w7yWzd831H7.T1p/kCDOkpguwuzxSNNK6Qep1EjHo0QhkiwdOcC', 'APROV', 'DF', NULL, '8883');

-- --------------------------------------------------------

--
-- Estrutura para tabela `user_setor`
--

CREATE TABLE IF NOT EXISTS `user_setor` (
  `id` int(11) NOT NULL,
  `idsetor` int(11) NOT NULL,
  `iduser` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `colaborador_etapas`
--
ALTER TABLE `colaborador_etapas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUser` (`idUser`),
  ADD KEY `idEtapa` (`idEtapa`);

--
-- Índices de tabela `correlacao_produto`
--
ALTER TABLE `correlacao_produto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idProdutoPrincipal` (`idProdutoPrincipal`),
  ADD KEY `idProdutoSecundario` (`idProdutoSecundario`);

--
-- Índices de tabela `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`ufId`);

--
-- Índices de tabela `etapa`
--
ALTER TABLE `etapa`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `etapasos`
--
ALTER TABLE `etapasos`
  ADD PRIMARY KEY (`etapaId`);

--
-- Índices de tabela `etapa_fluxo`
--
ALTER TABLE `etapa_fluxo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idfluxo` (`idfluxo`),
  ADD KEY `idetapa` (`idetapa`);

--
-- Índices de tabela `filedownload`
--
ALTER TABLE `filedownload`
  ADD PRIMARY KEY (`fileId`);

--
-- Índices de tabela `fluxo`
--
ALTER TABLE `fluxo`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `logatividades`
--
ALTER TABLE `logatividades`
  ADD PRIMARY KEY (`logId`);

--
-- Índices de tabela `log_atividades_producao`
--
ALTER TABLE `log_atividades_producao`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `mesesano`
--
ALTER TABLE `mesesano`
  ADD PRIMARY KEY (`mesId`);

--
-- Índices de tabela `ordenmanutencao`
--
ALTER TABLE `ordenmanutencao`
  ADD PRIMARY KEY (`omId`);

--
-- Índices de tabela `ordenservico`
--
ALTER TABLE `ordenservico`
  ADD PRIMARY KEY (`osId`);

--
-- Índices de tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idfluxo` (`idfluxo`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`prodId`);

--
-- Índices de tabela `realizacaoproducao`
--
ALTER TABLE `realizacaoproducao`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `setor`
--
ALTER TABLE `setor`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `setor_etapa`
--
ALTER TABLE `setor_etapa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idsetor` (`idsetor`),
  ADD KEY `idetapa` (`idetapa`);

--
-- Índices de tabela `statusetapa`
--
ALTER TABLE `statusetapa`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `statusos`
--
ALTER TABLE `statusos`
  ADD PRIMARY KEY (`stId`);

--
-- Índices de tabela `tempo_corrido`
--
ALTER TABLE `tempo_corrido`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tipocadastroexterno`
--
ALTER TABLE `tipocadastroexterno`
  ADD PRIMARY KEY (`tpcadexId`);

--
-- Índices de tabela `tipocadastrointerno`
--
ALTER TABLE `tipocadastrointerno`
  ADD PRIMARY KEY (`tpcadinId`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`usersId`);

--
-- Índices de tabela `user_setor`
--
ALTER TABLE `user_setor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idsetor` (`idsetor`),
  ADD KEY `iduser` (`iduser`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `colaborador_etapas`
--
ALTER TABLE `colaborador_etapas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `correlacao_produto`
--
ALTER TABLE `correlacao_produto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `estados`
--
ALTER TABLE `estados`
  MODIFY `ufId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de tabela `etapa`
--
ALTER TABLE `etapa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT de tabela `etapasos`
--
ALTER TABLE `etapasos`
  MODIFY `etapaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `etapa_fluxo`
--
ALTER TABLE `etapa_fluxo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de tabela `filedownload`
--
ALTER TABLE `filedownload`
  MODIFY `fileId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de tabela `fluxo`
--
ALTER TABLE `fluxo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT de tabela `logatividades`
--
ALTER TABLE `logatividades`
  MODIFY `logId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT de tabela `mesesano`
--
ALTER TABLE `mesesano`
  MODIFY `mesId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `ordenmanutencao`
--
ALTER TABLE `ordenmanutencao`
  MODIFY `omId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `ordenservico`
--
ALTER TABLE `ordenservico`
  MODIFY `osId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de tabela `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `prodId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT de tabela `setor`
--
ALTER TABLE `setor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `setor_etapa`
--
ALTER TABLE `setor_etapa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `usersId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de tabela `user_setor`
--
ALTER TABLE `user_setor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `correlacao_produto`
--
ALTER TABLE `correlacao_produto`
  ADD CONSTRAINT `correlacao_produto_ibfk_1` FOREIGN KEY (`idProdutoPrincipal`) REFERENCES `produto` (`id`),
  ADD CONSTRAINT `correlacao_produto_ibfk_2` FOREIGN KEY (`idProdutoSecundario`) REFERENCES `produto` (`id`);

--
-- Restrições para tabelas `etapa_fluxo`
--
ALTER TABLE `etapa_fluxo`
  ADD CONSTRAINT `etapa_fluxo_ibfk_1` FOREIGN KEY (`idfluxo`) REFERENCES `fluxo` (`id`),
  ADD CONSTRAINT `etapa_fluxo_ibfk_2` FOREIGN KEY (`idetapa`) REFERENCES `etapa` (`id`);

--
-- Restrições para tabelas `produto`
--
ALTER TABLE `produto`
  ADD CONSTRAINT `produto_ibfk_1` FOREIGN KEY (`idfluxo`) REFERENCES `fluxo` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
CREATE TABLE `fluxo_setor` (
  `id` int(11) NOT NULL,
  `idfluxo` int(11) NOT NULL,
  `idetapa` int(11) NOT NULL,
  `ordem` int(11) NOT NULL,
  `duracao` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


ALTER TABLE `fluxo_setor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_fluxo` (`idFluxo`),
  ADD KEY `fk_setor` (`idSetor`);

--
-- Despejando dados para a tabela `etapa_fluxo`
--

INSERT INTO `fluxo_setor` (`id`, `idfluxo`, `idsetor`, `ordem`, `duracao`) VALUES
(1, 1, 3, 1, 48),
(2, 1, 5, 2, 1),
(3, 1, 6, 3, 24),
(4, 1, 9, 4, 1),
(5, 1, 10, 5, 2),
(6, 1, 11, 6, 1),
(7, 1, 14, 7, 2);
