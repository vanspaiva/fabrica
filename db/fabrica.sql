-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Tempo de geração: 09/08/2024 às 15:44
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
-- Banco de dados: `fabrica`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `colaborador_etapas`
--

CREATE TABLE `colaborador_etapas` (
  `id` int(11) NOT NULL,
  `idUser` int(11) DEFAULT NULL,
  `idEtapa` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `correlacao_produto`
--

CREATE TABLE `correlacao_produto` (
  `id` int(11) NOT NULL,
  `idProdutoPrincipal` int(11) DEFAULT NULL,
  `idProdutoSecundario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `departamento`
--

CREATE TABLE `departamento` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `departamento`
--

INSERT INTO `departamento` (`id`, `nome`) VALUES
(2, 'Qualidade'),
(3, 'Serviços Gerais'),
(4, 'Produção');

-- --------------------------------------------------------

--
-- Estrutura para tabela `departamentos_form_inf_003`
--

CREATE TABLE `departamentos_form_inf_003` (
  `id_departamento` int(11) NOT NULL,
  `nome_departamento` varchar(255) DEFAULT NULL,
  `id_setor` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `departamentos_form_inf_003`
--

INSERT INTO `departamentos_form_inf_003` (`id_departamento`, `nome_departamento`, `id_setor`) VALUES
(32, 'Sala de Descanso', 1),
(33, 'ADM/Financeiro', 1),
(34, 'Marketing/Comercial', 1),
(35, 'CPD', 1),
(36, 'Sala de Jogos', 1),
(37, 'Auditório', 1),
(38, 'Presidência', 1),
(39, 'Lounge', 1),
(40, 'Sala de Reunião 1º andar', 1),
(41, 'Sala de Reunião (Térreo)', 1),
(42, 'Corredor dos Armários', 1),
(43, 'Estoque CPMH', 1),
(44, 'Estoque OSTEOFIX', 1),
(45, 'Laje Técnica', 1),
(46, 'Banheiro Masculino  1º andar', 2),
(47, 'Banheiro Masculino (Térreo)', 2),
(48, 'Banheiro Feminino  1º andar', 2),
(49, 'Banheiro Feminino (Térreo)', 2),
(50, 'Copa', 3),
(51, 'Cozinha', 3),
(52, 'Fabrica', 4);

-- --------------------------------------------------------

--
-- Estrutura para tabela `descricao_atividades`
--

CREATE TABLE `descricao_atividades` (
  `id` int(11) NOT NULL,
  `descricao` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `descricao_atividades`
--

INSERT INTO `descricao_atividades` (`id`, `descricao`) VALUES
(1, 'Verificação e drenagem da água'),
(2, 'Limpar bandejas e serpentinas - lavar as bandejas e serpentinas com remoção do biofilme (lodo), sem o uso de produtos desengraxantes e corrosivos (higienizador e bactericidas)'),
(3, 'Limpeza do gabinete - limpar o gabinete do condicionador e ventiladores (carcaça e rotor)'),
(4, 'Limpeza dos filtros - verificação e eliminação de sujeiras, danos e corrosão e frestas dos filtros'),
(5, 'Trocar filtros'),
(6, 'Verificação da fixação'),
(7, 'Verificação de vazamentos nas ligações flexíveis'),
(8, 'Estado de conservação do isolamento termo-acústico'),
(9, 'Vedação dos painéis de fechamento do gabinete'),
(10, 'Manutenção mecânica'),
(11, 'Manutenção elétrica'),
(12, 'outros');

-- --------------------------------------------------------

--
-- Estrutura para tabela `estados`
--

CREATE TABLE `estados` (
  `ufId` int(11) NOT NULL,
  `ufNomeExtenso` varchar(100) NOT NULL,
  `ufAbreviacao` varchar(2) NOT NULL,
  `ufRegiao` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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

CREATE TABLE `etapa` (
  `id` int(11) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `parametro1` text DEFAULT NULL,
  `parametro2` text DEFAULT NULL,
  `iterev` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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

CREATE TABLE `etapasos` (
  `etapaId` int(11) NOT NULL,
  `etapaNome` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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

CREATE TABLE `etapa_fluxo` (
  `id` int(11) NOT NULL,
  `idfluxo` int(11) NOT NULL,
  `idetapa` int(11) NOT NULL,
  `ordem` int(11) NOT NULL,
  `duracao` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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

CREATE TABLE `filedownload` (
  `fileId` int(11) NOT NULL,
  `fileRealName` text NOT NULL,
  `fileOsRef` int(11) NOT NULL,
  `filePath` varchar(500) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
(34, 'https://firebasestorage.googleapis.com/v0/b/sistemas-fabrica.appspot.com/o/arquivosOS%2Fxxx%2F3188A920.X74-DX.%20-%20Placa%202%2C0%20Ancoragem%20Trava%20Fio%20YY%2030%C2%BA%20-%20Direita%20%5BLASER%20CUT%20-%20LONGA%5D.DXF?alt=media&token=e4b8015b-fd47-43b9-9c49-915356e1fe05', 29, '../arquivos/29'),
(35, '', 30, '../arquivos/30'),
(36, '', 31, '../arquivos/31'),
(37, '', 32, '../arquivos/32'),
(38, '', 33, '../arquivos/33'),
(39, '', 34, '../arquivos/34'),
(40, '', 35, '../arquivos/35'),
(41, '', 36, '../arquivos/36'),
(42, '', 37, '../arquivos/37'),
(43, '', 38, '../arquivos/38'),
(44, '', 39, '../arquivos/39'),
(45, 'https://firebasestorage.googleapis.com/v0/b/sistemas-fabrica.appspot.com/o/arquivosOS%2FN%2FA%2F3789Captura%20de%20tela%202024-07-11%20092551.png?alt=media&token=d66a327f-af9d-49bc-9f0a-b2c0c0b31bc6', 40, '../arquivos/40'),
(46, 'https://firebasestorage.googleapis.com/v0/b/sistemas-fabrica.appspot.com/o/arquivosOS%2FN%2FA%2F8541Placa_parafusos.DXF?alt=media&token=cefa3ff1-e8aa-4d51-be84-a97ca7dbc98e', 41, '../arquivos/41'),
(47, 'none', 10, '../arquivos/10'),
(48, 'none', 11, '../arquivos/11'),
(49, 'https://firebasestorage.googleapis.com/v0/b/sistemas-fabrica.appspot.com/o/arquivosOS%2FN%2FA%2F6889PE%C3%87A%20003%20-%20GUIA.DXF?alt=media&token=e0de05e8-c09f-4e99-83d0-34178376d19f', 42, '../arquivos/42'),
(50, 'none', 12, '../arquivos/12'),
(51, '', 43, '../arquivos/43'),
(52, 'https://firebasestorage.googleapis.com/v0/b/sistemas-fabrica.appspot.com/o/arquivosOS%2FN%2FA%2F9878P-50001%20-%20Cabeca%20condilar%20P.pdf?alt=media&token=8b7de427-421d-40cb-b581-107cf9e20139', 44, '../arquivos/44'),
(53, 'https://firebasestorage.googleapis.com/v0/b/sistemas-fabrica.appspot.com/o/arquivosOS%2FN%2FA%2F6648haste%20para%20ensaio.pdf?alt=media&token=e97e1ebb-1616-4f7f-9452-0e8f40852708', 45, '../arquivos/45'),
(54, 'https://firebasestorage.googleapis.com/v0/b/sistemas-fabrica.appspot.com/o/arquivosOS%2FN%2FA%2F2274Prot.%20Impr.%20Corpos%20de%20Prova%20-%20Riton%20-%20Virgem.pdf?alt=media&token=5adfa87d-eff7-493d-a0a9-b165db733625', 46, '../arquivos/46'),
(55, '', 47, '../arquivos/47'),
(56, '', 48, '../arquivos/48'),
(57, '', 49, '../arquivos/49'),
(58, '', 50, '../arquivos/50'),
(59, '', 51, '../arquivos/51'),
(60, 'https://firebasestorage.googleapis.com/v0/b/sistemas-fabrica.appspot.com/o/arquivosOS%2FN%2FA%2F2802impress%C3%A3o%20teste%20prizma.STL?alt=media&token=3e834146-6fe5-4846-afbe-711ae810aede', 52, '../arquivos/52'),
(61, '', 53, '../arquivos/53'),
(62, '', 54, '../arquivos/54'),
(63, '', 55, '../arquivos/55'),
(64, '', 56, '../arquivos/56'),
(65, '', 57, '../arquivos/57'),
(66, 'none', 13, '../arquivos/13'),
(67, '', 58, '../arquivos/58'),
(68, '', 59, '../arquivos/59'),
(69, '', 60, '../arquivos/60'),
(70, '', 61, '../arquivos/61'),
(71, '', 62, '../arquivos/62'),
(72, '', 63, '../arquivos/63'),
(73, '', 64, '../arquivos/64'),
(74, '', 65, '../arquivos/65');

-- --------------------------------------------------------

--
-- Estrutura para tabela `fluxo`
--

CREATE TABLE `fluxo` (
  `id` int(11) NOT NULL,
  `nome` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
-- Estrutura para tabela `fluxo_setor`
--

CREATE TABLE `fluxo_setor` (
  `id` int(11) NOT NULL,
  `idfluxo` int(11) NOT NULL,
  `idetapa` int(11) NOT NULL,
  `ordem` int(11) NOT NULL,
  `duracao` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `form_inf_003`
--

CREATE TABLE `form_inf_003` (
  `id` int(11) NOT NULL,
  `setor` varchar(25) NOT NULL,
  `area_adm` varchar(100) DEFAULT NULL,
  `data` date NOT NULL,
  `periodo` varchar(10) DEFAULT NULL,
  `responsavel` varchar(10) DEFAULT NULL,
  `id_user_criador` int(11) DEFAULT NULL,
  `tipo_limpeza` varchar(256) NOT NULL,
  `conferido` enum('APROV','PEND') NOT NULL DEFAULT 'PEND',
  `data_publicacao` date DEFAULT '2023-10-18',
  `data_validade` date DEFAULT '2025-10-18'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `form_inf_003`
--

INSERT INTO `form_inf_003` (`id`, `setor`, `area_adm`, `data`, `periodo`, `responsavel`, `id_user_criador`, `tipo_limpeza`, `conferido`, `data_publicacao`, `data_validade`) VALUES
(32, '4. Produção', 'Fabrica', '2024-07-11', 'Manhã', 'Kellyta', 30, '1. Vidros e Divisórias\n2. Piso\n3. Prateleiras/Armários\n4. Bancadas\n', 'PEND', '2023-10-18', '2025-10-18');

-- --------------------------------------------------------

--
-- Estrutura para tabela `frmstatus`
--

CREATE TABLE `frmstatus` (
  `id` int(11) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `frmstatus`
--

INSERT INTO `frmstatus` (`id`, `status`) VALUES
(1, 'Pendente'),
(2, 'Concluída');

-- --------------------------------------------------------

--
-- Estrutura para tabela `frm_inf_004`
--

CREATE TABLE `frm_inf_004` (
  `id` int(11) NOT NULL,
  `data_publicacao` date DEFAULT NULL,
  `data_validade` date DEFAULT NULL,
  `data_manutencao` date DEFAULT NULL,
  `modelo` varchar(20) DEFAULT 'springer',
  `descricao_setor` text DEFAULT NULL,
  `descricao_atividades` tinytext DEFAULT NULL,
  `frmstatus_id` int(11) DEFAULT NULL,
  `responsavel` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `frm_inf_004_atividades`
--

CREATE TABLE `frm_inf_004_atividades` (
  `id` int(11) NOT NULL,
  `frm_inf_004_id` int(11) NOT NULL,
  `descricao_atividades_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `frm_inf_004_atividades`
--

INSERT INTO `frm_inf_004_atividades` (`id`, `frm_inf_004_id`, `descricao_atividades_id`) VALUES
(32, 32, 1),
(33, 32, 2),
(34, 33, 1),
(35, 33, 3);

-- --------------------------------------------------------

--
-- Estrutura para tabela `logatividades`
--

CREATE TABLE `logatividades` (
  `logId` int(11) NOT NULL,
  `logOsRef` varchar(100) NOT NULL,
  `logHorario` timestamp NOT NULL DEFAULT current_timestamp(),
  `logStatus` varchar(50) NOT NULL,
  `logUser` varchar(200) NOT NULL,
  `logTipo` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `logatividades`
--

INSERT INTO `logatividades` (`logId`, `logOsRef`, `logHorario`, `logStatus`, `logUser`, `logTipo`) VALUES
(14, '6', '2021-11-29 20:49:05', 'CONCLUÍDO', 'vanessapaiva', NULL),
(13, '7', '2021-11-29 20:49:04', 'CONCLUÍDO', 'vanessapaiva', NULL),
(12, '6', '2021-11-29 20:48:56', 'EM ANDAMENTO', 'vanessapaiva', NULL),
(17, '7', '2021-11-29 20:55:58', 'EM ANDAMENTO', 'vanessapaiva', NULL),
(16, '7', '2021-11-29 20:55:32', 'CRIADO', 'vanessapaiva', NULL),
(18, '7', '2021-11-29 20:56:23', 'CONCLUÍDO', 'vanessapaiva', NULL),
(19, '8', '2021-11-29 21:12:00', 'CRIADO', 'vanessapaiva', NULL),
(20, '6', '2021-11-29 21:12:09', 'EM ANDAMENTO', 'vanessapaiva', NULL),
(21, '9', '2021-11-29 21:17:56', 'EM ANDAMENTO', 'vanessapaiva', NULL),
(22, '8', '2021-11-29 21:18:19', 'EM ANDAMENTO', 'vanessapaiva', NULL),
(23, '9', '2021-11-29 21:18:21', 'CONCLUÍDO', 'vanessapaiva', NULL),
(24, '9', '2021-11-29 21:19:59', 'CRIADO', 'vanessapaiva', NULL),
(25, '8', '2021-11-30 16:28:04', 'PAUSADO', 'vanessapaiva', NULL),
(26, '10', '2021-11-30 16:28:31', 'CRIADO', 'vanessapaiva', NULL),
(27, '11', '2021-11-30 17:46:35', 'CRIADO', 'vanessapaiva', NULL),
(28, '11', '2021-11-30 17:46:57', 'CRIADO', 'vanessapaiva', NULL),
(29, '11', '2021-11-30 17:48:09', 'CRIADO', 'vanessapaiva', NULL),
(30, '10', '2021-11-30 21:15:45', 'EM ANDAMENTO', 'vanessapaiva', NULL),
(31, '10', '2021-11-30 21:15:50', 'PAUSADO', 'vanessapaiva', NULL),
(32, '11', '2021-11-30 21:34:12', 'CRIADO', 'vanessapaiva', NULL),
(33, '6', '2021-12-08 13:20:19', 'CONCLUÍDO', 'vanessapaiva', NULL),
(34, '8', '2021-12-08 13:24:37', 'EM ANDAMENTO', 'vanessapaiva', NULL),
(35, '8', '2022-01-24 18:07:20', 'PAUSADO', 'vanessapaiva', NULL),
(36, '8', '2022-02-03 12:52:20', 'EM ANDAMENTO', 'vanessapaiva', NULL),
(37, '8', '2022-02-03 12:54:09', 'PAUSADO', 'vanessapaiva', NULL),
(38, '8', '2022-11-21 15:03:29', 'EM ANDAMENTO', 'vanessapaiva', NULL),
(39, '8', '2022-11-21 15:03:41', 'PAUSADO', 'vanessapaiva', NULL),
(40, '8', '2023-04-06 12:32:04', 'EM ANDAMENTO', 'vanessapaiva', NULL),
(41, '8', '2023-04-06 12:32:35', 'PAUSADO', 'vanessapaiva', NULL),
(42, '12', '2024-05-14 18:02:37', 'CRIADO', 'vanessapaiva', NULL),
(43, '12', '2024-05-14 18:02:53', 'EM ANDAMENTO', 'vanessapaiva', NULL),
(44, '12', '2024-05-14 18:03:09', 'PAUSADO', 'vanessapaiva', NULL),
(45, '12', '2024-05-14 18:03:14', 'EM ANDAMENTO', 'vanessapaiva', NULL),
(46, '12', '2024-05-14 18:03:17', 'CONCLUÍDO', 'vanessapaiva', NULL),
(47, '13', '2024-05-16 20:37:08', 'EM ANDAMENTO', 'antonia', NULL),
(48, '13', '2024-05-16 20:37:28', 'PAUSADO', 'antonia', NULL),
(49, '13', '2024-05-16 20:41:03', 'PAUSADO', 'antonia', NULL),
(50, '13', '2024-05-17 10:49:16', 'EM ANDAMENTO', 'evellyn', NULL),
(51, '13', '2024-05-17 10:49:36', 'CONCLUÍDO', 'evellyn', NULL),
(52, '14', '2024-05-21 10:22:40', 'EM ANDAMENTO', 'evellyn', NULL),
(53, '15', '2024-05-21 10:23:00', 'EM ANDAMENTO', 'evellyn', NULL),
(54, '15', '2024-05-21 10:23:05', 'CONCLUÍDO', 'evellyn', NULL),
(55, '14', '2024-05-21 13:15:09', 'CONCLUÍDO', 'vanessapaiva', NULL),
(56, '16', '2024-05-28 14:14:58', 'EM ANDAMENTO', 'vanessapaiva', NULL),
(57, '16', '2024-05-28 14:15:01', 'PAUSADO', 'vanessapaiva', NULL),
(58, '16', '2024-05-28 14:15:03', 'EM ANDAMENTO', 'vanessapaiva', NULL),
(59, '16', '2024-05-28 14:15:05', 'CONCLUÍDO', 'vanessapaiva', NULL),
(60, '20', '2024-05-30 14:22:16', 'EM ANDAMENTO', 'joicecensi', NULL),
(61, '17', '2024-05-30 14:22:53', 'EM ANDAMENTO', 'joicecensi', NULL),
(62, '20', '2024-05-30 14:23:08', 'CRIADO', 'joicecensi', NULL),
(63, '19', '2024-05-30 14:23:19', 'CRIADO', 'joicecensi', NULL),
(64, '19', '2024-05-30 14:24:19', 'EM ANDAMENTO', 'joicecensi', NULL),
(65, '22', '2024-06-04 12:00:35', 'CONCLUÍDO', 'joicecensi', NULL),
(66, '17', '2024-06-04 12:01:04', 'EM ANDAMENTO', 'joicecensi', NULL),
(67, '17', '2024-06-04 12:01:58', 'CONCLUÍDO', 'joicecensi', NULL),
(68, '19', '2024-06-04 12:02:17', 'EM ANDAMENTO', 'joicecensi', NULL),
(69, '19', '2024-06-04 12:02:28', 'CONCLUÍDO', 'joicecensi', NULL),
(70, '20', '2024-06-04 12:02:43', 'CRIADO', 'joicecensi', NULL),
(71, '20', '2024-06-04 12:02:55', 'CONCLUÍDO', 'joicecensi', NULL),
(72, '23', '2024-06-05 10:02:26', 'CONCLUÍDO', 'joicecensi', NULL),
(73, '21', '2024-06-06 10:04:57', 'CONCLUÍDO', 'joicecensi', NULL),
(74, '24', '2024-06-06 10:05:14', 'CONCLUÍDO', 'joicecensi', NULL),
(75, '19', '2024-06-07 09:56:14', 'EM ANDAMENTO', 'joicecensi', NULL),
(76, '21', '2024-06-07 09:56:29', 'EM ANDAMENTO', 'joicecensi', NULL),
(77, '25', '2024-06-11 11:06:03', 'CRIADO', 'joicecensi', NULL),
(78, '25', '2024-06-11 11:06:14', 'EM ANDAMENTO', 'joicecensi', NULL),
(79, '26', '2024-06-12 16:22:29', 'CONCLUÍDO', 'joicecensi', NULL),
(80, '29', '2024-06-13 18:08:33', 'CRIADO', 'smorbeckcpmh', NULL),
(81, '38', '2024-07-10 11:48:43', 'CRIADO', 'joicecensi', 'os'),
(82, '38', '2024-07-10 11:48:54', 'CONCLUÍDO', 'joicecensi', 'os'),
(83, '36', '2024-07-10 11:49:48', 'CONCLUÍDO', 'joicecensi', 'os'),
(84, '39', '2024-07-10 12:12:33', 'EM ANDAMENTO', 'joicecensi', 'os'),
(85, '35', '2024-07-10 12:12:45', 'CONCLUÍDO', 'joicecensi', 'os'),
(86, '40', '2024-07-11 12:27:25', 'CRIADO', 'heloizabianca', 'os'),
(87, '40', '2024-07-11 12:28:12', 'CRIADO', 'heloizabianca', 'os'),
(88, '9', '2024-07-12 17:39:56', 'CRIADO', 'samuel', 'om'),
(89, '40', '2024-07-15 12:01:19', 'EM ANDAMENTO', 'joicecensi', 'os'),
(90, '9', '2024-07-15 12:04:53', 'CRIADO', 'samuel', 'om'),
(91, '10', '2024-07-15 12:27:09', 'CRIADO', 'samuel', 'om'),
(92, '11', '2024-07-16 13:08:01', 'CRIADO', 'thaistivelli', 'om'),
(93, '12', '2024-07-16 14:36:54', 'CRIADO', 'thaistivelli', 'om'),
(94, '41', '2024-07-16 16:02:45', 'EM ANDAMENTO', 'joicecensi', 'os'),
(95, '41', '2024-07-16 16:02:59', 'EM ANDAMENTO', 'joicecensi', 'os'),
(96, '46', '2024-07-22 15:52:02', 'EM ANDAMENTO', 'joicecensi', 'os'),
(97, '49', '2024-07-23 17:21:49', 'CRIADO', 'thaistivelli', 'os'),
(98, '48', '2024-07-24 18:50:40', 'CONCLUÍDO', 'joicecensi', 'os'),
(99, '49', '2024-07-24 18:50:58', 'EM ANDAMENTO', 'joicecensi', 'os'),
(100, '33', '2024-07-24 18:51:53', 'CONCLUÍDO', 'joicecensi', 'os'),
(101, '45', '2024-07-24 18:53:45', 'CONCLUÍDO', 'joicecensi', 'os'),
(102, '44', '2024-07-24 18:54:17', 'CRIADO', 'joicecensi', 'os'),
(103, '34', '2024-07-24 18:54:46', 'CONCLUÍDO', 'joicecensi', 'os'),
(104, '32', '2024-07-24 18:55:05', 'CONCLUÍDO', 'joicecensi', 'os'),
(105, '39', '2024-07-26 13:52:35', 'CONCLUÍDO', 'joicecensi', 'os'),
(106, '43', '2024-07-26 13:53:01', 'CONCLUÍDO', 'joicecensi', 'os'),
(107, '41', '2024-07-26 13:53:14', 'CONCLUÍDO', 'joicecensi', 'os'),
(108, '50', '2024-07-26 14:01:07', 'CONCLUÍDO', 'joicecensi', 'os'),
(109, '47', '2024-07-26 14:01:31', 'CONCLUÍDO', 'joicecensi', 'os'),
(110, '49', '2024-08-01 15:13:57', 'CONCLUÍDO', 'joicecensi', 'os'),
(111, '52', '2024-08-01 19:58:33', 'EM ANDAMENTO', 'joicecensi', 'os'),
(112, '54', '2024-08-05 17:40:29', 'CRIADO', 'jefersonlucas', 'os'),
(113, '40', '2024-08-06 15:05:07', 'CONCLUÍDO', 'joicecensi', 'os'),
(114, '54', '2024-08-06 15:06:57', 'CONCLUÍDO', 'joicecensi', 'os'),
(115, '55', '2024-08-06 15:09:08', 'EM ANDAMENTO', 'joicecensi', 'os'),
(116, '56', '2024-08-06 15:09:22', 'EM ANDAMENTO', 'joicecensi', 'os'),
(117, '57', '2024-08-06 15:10:21', 'CRIADO', 'joicecensi', 'os'),
(118, '57', '2024-08-06 15:10:29', 'EM ANDAMENTO', 'joicecensi', 'os'),
(119, '55', '2024-08-06 19:04:58', 'REQUALIFICADO', 'joicecensi', 'os'),
(120, '56', '2024-08-06 19:05:05', 'REQUALIFICADO', 'joicecensi', 'os'),
(121, '57', '2024-08-06 19:05:13', 'REQUALIFICADO', 'joicecensi', 'os'),
(122, '58', '2024-08-06 19:05:29', 'EM ANDAMENTO', 'joicecensi', 'os'),
(123, '54', '2024-08-06 19:54:47', 'CONCLUÍDO', 'jefersonlucas', 'os'),
(124, '55', '2024-08-06 19:57:45', 'REQUALIFICADO', 'jefersonlucas', 'os'),
(125, '56', '2024-08-06 19:59:08', 'REQUALIFICADO', 'jefersonlucas', 'os'),
(126, '57', '2024-08-06 20:01:42', 'REQUALIFICADO', 'jefersonlucas', 'os'),
(127, '57', '2024-08-06 20:06:30', 'REQUALIFICADO', 'jefersonlucas', 'os'),
(128, '54', '2024-08-06 20:06:54', 'CONCLUÍDO', 'jefersonlucas', 'os'),
(129, '55', '2024-08-06 20:07:14', 'REQUALIFICADO', 'jefersonlucas', 'os'),
(130, '56', '2024-08-06 20:07:37', 'REQUALIFICADO', 'jefersonlucas', 'os'),
(131, '57', '2024-08-06 20:07:48', 'REQUALIFICADO', 'jefersonlucas', 'os'),
(132, '54', '2024-08-06 20:08:14', 'CONCLUÍDO', 'jefersonlucas', 'os'),
(133, '55', '2024-08-06 20:08:29', 'REQUALIFICADO', 'jefersonlucas', 'os'),
(134, '56', '2024-08-06 20:08:48', 'REQUALIFICADO', 'jefersonlucas', 'os'),
(135, '57', '2024-08-06 20:09:47', 'REQUALIFICADO', 'jefersonlucas', 'os'),
(136, '54', '2024-08-06 20:19:16', 'CONCLUÍDO', 'jefersonlucas', 'os'),
(137, '54', '2024-08-07 14:48:57', 'CONCLUÍDO', 'jefersonlucas', 'os');

-- --------------------------------------------------------

--
-- Estrutura para tabela `log_atividades_producao`
--

CREATE TABLE `log_atividades_producao` (
  `id` int(11) NOT NULL,
  `idRealizacaoProducao` int(11) DEFAULT NULL,
  `idEtapa` int(11) NOT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `idStatus` int(11) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `hora` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `log_atividades_producao`
--

INSERT INTO `log_atividades_producao` (`id`, `idRealizacaoProducao`, `idEtapa`, `idUsuario`, `idStatus`, `data`, `hora`) VALUES
(2, 47, 72, 20, 2, '2024-06-20', '14:14:43'),
(3, 23, 31, 21, 2, '2024-06-20', '14:20:49'),
(4, 23, 31, 21, 6, '2024-06-20', '14:20:53'),
(5, 23, 31, 21, 7, '2024-06-20', '14:20:53'),
(6, 17, 72, 6, 2, '2024-07-04', '08:50:14'),
(7, 17, 72, 6, 3, '2024-07-04', '08:50:16'),
(8, 17, 72, 6, 2, '2024-07-04', '08:50:18'),
(9, 17, 72, 6, 4, '2024-07-04', '08:50:19'),
(10, 18, 74, 6, 2, '2024-07-08', '11:15:31'),
(11, 18, 74, 6, 3, '2024-07-08', '11:15:34'),
(12, 18, 74, 6, 2, '2024-07-08', '11:15:36'),
(13, 18, 74, 6, 4, '2024-07-08', '11:15:38'),
(14, 19, 28, 6, 2, '2024-07-08', '11:15:48'),
(15, 19, 28, 6, 3, '2024-07-08', '11:15:50'),
(16, 19, 28, 6, 2, '2024-07-08', '11:15:51'),
(17, 19, 28, 6, 4, '2024-07-08', '11:15:52'),
(18, 24, 4, 35, 2, '2024-08-05', '13:40:55'),
(19, 24, 4, 35, 3, '2024-08-05', '13:41:01');

-- --------------------------------------------------------

--
-- Estrutura para tabela `maquina_manutencao_mensal`
--

CREATE TABLE `maquina_manutencao_mensal` (
  `idMaquina` varchar(50) NOT NULL,
  `idManutencaoMensal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `maquina_manutencao_mensal`
--

INSERT INTO `maquina_manutencao_mensal` (`idMaquina`, `idManutencaoMensal`) VALUES
('MAQ.001', 1),
('MAQ.002', 1),
('MAQ.002', 3),
('MAQ.003', 1),
('MAQ.003', 3),
('MAQ.005', 6),
('MAQ.005', 5),
('MAQ.012', 6),
('MAQ.012', 7),
('MAQ.012', 8),
('MAQ.013', 9),
('MAQ.013', 10),
('MAQ.013', 6),
('MAQ.001', 1),
('MAQ.002', 1),
('MAQ.002', 3),
('MAQ.003', 1),
('MAQ.003', 3),
('MAQ.005', 6),
('MAQ.005', 5),
('MAQ.012', 6),
('MAQ.012', 7),
('MAQ.012', 8),
('MAQ.013', 9),
('MAQ.013', 10),
('MAQ.013', 6);

-- --------------------------------------------------------

--
-- Estrutura para tabela `maquina_manutencao_semanal`
--

CREATE TABLE `maquina_manutencao_semanal` (
  `idMaquina` varchar(50) NOT NULL,
  `idManutencaoSemanal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `maquina_manutencao_semanal`
--

INSERT INTO `maquina_manutencao_semanal` (`idMaquina`, `idManutencaoSemanal`) VALUES
('MAQ.001', 1),
('MAQ.001', 2),
('MAQ.001', 3),
('MAQ.001', 4),
('MAQ.002', 1),
('MAQ.002', 2),
('MAQ.002', 3),
('MAQ.002', 5),
('MAQ.002', 6),
('MAQ.002', 7),
('MAQ.002', 8),
('MAQ.002', 9),
('MAQ.002', 18),
('MAQ.003', 1),
('MAQ.003', 2),
('MAQ.003', 5),
('MAQ.003', 6),
('MAQ.003', 7),
('MAQ.003', 3),
('MAQ.003', 8),
('MAQ.003', 9),
('MAQ.003', 19),
('MAQ.005', 1),
('MAQ.005', 20),
('MAQ.005', 11),
('MAQ.005', 12),
('MAQ.012', 13),
('MAQ.012', 14),
('MAQ.012', 15),
('MAQ.012', 16),
('MAQ.012', 17),
('MAQ.013', 20),
('MAQ.001', 1),
('MAQ.001', 2),
('MAQ.001', 3),
('MAQ.001', 4),
('MAQ.002', 1),
('MAQ.002', 2),
('MAQ.002', 3),
('MAQ.002', 5),
('MAQ.002', 6),
('MAQ.002', 7),
('MAQ.002', 8),
('MAQ.002', 9),
('MAQ.002', 18),
('MAQ.003', 1),
('MAQ.003', 2),
('MAQ.003', 5),
('MAQ.003', 6),
('MAQ.003', 7),
('MAQ.003', 3),
('MAQ.003', 8),
('MAQ.003', 9),
('MAQ.003', 19),
('MAQ.005', 1),
('MAQ.005', 20),
('MAQ.005', 11),
('MAQ.005', 12),
('MAQ.012', 13),
('MAQ.012', 14),
('MAQ.012', 15),
('MAQ.012', 16),
('MAQ.012', 17),
('MAQ.013', 20);

-- --------------------------------------------------------

--
-- Estrutura para tabela `mesesano`
--

CREATE TABLE `mesesano` (
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
-- Estrutura para tabela `ommanutencaomensal`
--

CREATE TABLE `ommanutencaomensal` (
  `id` int(11) NOT NULL,
  `descricaoMensal` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `ommanutencaomensal`
--

INSERT INTO `ommanutencaomensal` (`id`, `descricaoMensal`) VALUES
(1, 'Limpeza externa do equipamento'),
(2, 'Limpeza das ventoinhas de ar'),
(3, 'Completar óleo lubrificante dos eixos'),
(4, 'Limpeza dos filtros e ventoinhas de ar'),
(5, 'Engraxar os eixos e barramentos'),
(6, 'Limpeza dos filtros de ar'),
(7, 'Limpeza ou substituição das lentes do cabeçote do laser'),
(8, 'Limpeza ou substituição do bico do cabeçote do laser'),
(9, 'Completar nível de água'),
(10, 'Verificar reservatório de graxa de lubrificação'),
(1, 'Limpeza externa do equipamento'),
(2, 'Limpeza das ventoinhas de ar'),
(3, 'Completar óleo lubrificante dos eixos'),
(4, 'Limpeza dos filtros e ventoinhas de ar'),
(5, 'Engraxar os eixos e barramentos'),
(6, 'Limpeza dos filtros de ar'),
(7, 'Limpeza ou substituição das lentes do cabeçote do laser'),
(8, 'Limpeza ou substituição do bico do cabeçote do laser'),
(9, 'Completar nível de água'),
(10, 'Verificar reservatório de graxa de lubrificação');

-- --------------------------------------------------------

--
-- Estrutura para tabela `ommanutencaosemanal`
--

CREATE TABLE `ommanutencaosemanal` (
  `id` int(11) NOT NULL,
  `descricaoSemanal` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `ommanutencaosemanal`
--

INSERT INTO `ommanutencaosemanal` (`id`, `descricaoSemanal`) VALUES
(1, 'Limpeza interna da área de usinagem'),
(2, 'Verificar concentração e completar nível de óleo solúvel'),
(3, 'Limpeza da haste e do receptor da probe'),
(4, 'Retirada de cavaco'),
(5, 'Limpeza da probe de medição de ferramenta'),
(6, 'Lubrificação interna da pinça de pega da ferramenta (spindle)'),
(7, 'Verificar nível de graxa de lubrificação'),
(8, 'Calibração completa da probe'),
(9, 'Retirada de cavaco na saída de ar das ventoinhas traseiras.'),
(10, 'Verificar concentração e completar nível de óleo integral'),
(11, 'Limpeza externa do equipamento'),
(12, 'Verificar nível de óleo de lubrificação'),
(13, 'Limpeza geral da máquina'),
(14, 'Lubrificação das guias'),
(15, 'Verificar reservatório de fluido do chiller'),
(16, 'Verificação das válvulas de argônio, oxigênio e nitrogênio'),
(17, 'Verificar se cilindros estão devidamente amarrados na posição vertical'),
(18, 'Limpeza geral do equipamento'),
(19, 'Completar nível de óleo integral'),
(20, 'Limpeza do equipamento'),
(1, 'Limpeza interna da área de usinagem'),
(2, 'Verificar concentração e completar nível de óleo solúvel'),
(3, 'Limpeza da haste e do receptor da probe'),
(4, 'Retirada de cavaco'),
(5, 'Limpeza da probe de medição de ferramenta'),
(6, 'Lubrificação interna da pinça de pega da ferramenta (spindle)'),
(7, 'Verificar nível de graxa de lubrificação'),
(8, 'Calibração completa da probe'),
(9, 'Retirada de cavaco na saída de ar das ventoinhas traseiras.'),
(10, 'Verificar concentração e completar nível de óleo integral'),
(11, 'Limpeza externa do equipamento'),
(12, 'Verificar nível de óleo de lubrificação'),
(13, 'Limpeza geral da máquina'),
(14, 'Lubrificação das guias'),
(15, 'Verificar reservatório de fluido do chiller'),
(16, 'Verificação das válvulas de argônio, oxigênio e nitrogênio'),
(17, 'Verificar se cilindros estão devidamente amarrados na posição vertical'),
(18, 'Limpeza geral do equipamento'),
(19, 'Completar nível de óleo integral'),
(20, 'Limpeza do equipamento');

-- --------------------------------------------------------

--
-- Estrutura para tabela `omregistromanutencao`
--

CREATE TABLE `omregistromanutencao` (
  `id` int(11) NOT NULL,
  `idMaquina` varchar(50) NOT NULL,
  `idManutencaoSemanal` int(11) DEFAULT NULL,
  `idManutencaoMensal` int(11) DEFAULT NULL,
  `dataPrevista` date NOT NULL,
  `dataRealizada` date DEFAULT NULL,
  `responsavel` varchar(255) NOT NULL,
  `observacao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `omusersmanutencao`
--

CREATE TABLE `omusersmanutencao` (
  `id` int(11) NOT NULL,
  `usersManutencao` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `omusersmanutencao`
--

INSERT INTO `omusersmanutencao` (`id`, `usersManutencao`) VALUES
(1, 'Rayro Rodrigues Soares'),
(2, 'Benjamim Wenderson Santos Soares'),
(3, 'Fernando Lima De Sousa'),
(4, 'Jessika Karoliny Da Silva Queiros'),
(5, 'Tania Guedes de Oliveira'),
(1, 'Rayro Rodrigues Soares'),
(2, 'Benjamim Wenderson Santos Soares'),
(3, 'Fernando Lima De Sousa'),
(4, 'Jessika Karoliny Da Silva Queiros'),
(5, 'Tania Guedes de Oliveira');

-- --------------------------------------------------------

--
-- Estrutura para tabela `om_maquina`
--

CREATE TABLE `om_maquina` (
  `tipo` varchar(50) NOT NULL,
  `idMaquina` varchar(50) NOT NULL,
  `omNomeMaquina` varchar(100) NOT NULL,
  `omIdentificadorMaquina` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `om_maquina`
--

INSERT INTO `om_maquina` (`tipo`, `idMaquina`, `omNomeMaquina`, `omIdentificadorMaquina`) VALUES
('Produção', 'AMB.001', 'Sala limpa', ''),
('Produção', 'MAQ.001', 'CNC', 'RODERS / RXP400DSC /'),
('Produção', 'MAQ.002', 'CNC', 'HASS / VF-2-SE /'),
('Produção', 'MAQ.003', 'CNC', 'HASS/ VF-2-SE /'),
('Produção', 'MAQ.004', 'CNC', 'LASERDENTA / OPENMILL500B / 00182'),
('Produção', 'MAQ.005', 'CNC Torno Tipo Suiço', 'CITIZEN / A20-3F7 / AG5166'),
('Produção', 'MAQ.006', 'Impressora 3D Filamento', 'PRUSA / ALVA /'),
('Produção', 'MAQ.007', 'Impressora 3D Filamento', 'PRUSA / TESLA /'),
('Produção', 'MAQ.008', 'Impressora 3D Filamento', 'PRUSA / BABBAGE /'),
('Produção', 'MAQ.009', 'Impressora 3D Filamento', 'RAISE/RAISE PRO2/'),
('Produção', 'MAQ.010', 'Impressora 3D Resina', 'FORMLABS / FORM3 /'),
('Produção', 'MAQ.011', 'Impressora 3D Resina', 'FORMLABS / TRUSTY GOOSE /'),
('Produção', 'MAQ.012', 'Corte a laser Metal', 'GOLDEN LASER / GF-6060 /'),
('Produção', 'MAQ.013', 'Máquina de Eletroerosão', 'FANUC / ROBOCUT A-C400iB /'),
('Produção', 'MAQ.014', 'Torno Mecânico', 'NARDINE / MS205 /'),
('Produção', 'MAQ.015', 'Laser CO2', 'NOVACUT / KM-5030D /'),
('Produção', 'MAQ.016', 'Laser Fibra (gravação)', '- / MF-30EC /'),
('Produção', 'MAQ.017', 'Serra de Fita', 'VITOR&BUONO / VB-1018M /'),
('Produção', 'MAQ.018', 'Tamboreador (Total Finishing', 'TOTAL FINISHING / CITRON3D /'),
('Produção', 'MAQ.019', 'Furadeira', 'SCHULZ PRATIKA / FSC25P / 1217500018'),
('Produção', 'MAQ.020', 'Lavadora Ultrassônica - Limpeza Final', 'CTA ULTRASONIC SYSTEMS / UPL 50A'),
('Produção', 'MAQ.021', 'Jato de Areia', 'BRASIBRAS / BR090707 /'),
('Produção', 'MAQ.022', 'Seladora (com alavanca', ''),
('Produção', 'MAQ.023', 'Prensa Térmica', ''),
('Produção', 'MAQ.024', 'Seladora (com pedal)', 'FLOCKCLOR / PEDAL'),
('Produção', 'MAQ.025', 'Impressora de Etiquetas', ''),
('Produção', 'MAQ.026', 'Compressor de Ar', 'ATLAS / /'),
('Produção', 'MAQ.027', 'Motor de Polimento', ''),
('Produção', 'MAQ.028', 'Politriz', 'POLIMAXX / 20000RMP'),
('Produção', 'MAQ.029', 'Guilhotina', 'NEWTON / 5 / 559577'),
('Produção', 'MAQ.030', 'Prensa Hidraulica Manual (azul)', 'MARCON / MPH-15 /'),
('Produção', 'MAQ.031', 'Prensa Hidraulica Elétrica', 'HIDRAUMAK / PKM80'),
('Produção', 'MAQ.032', 'Esmeril', 'MOTOMIL / MIMI-50 / -'),
('Produção', 'MAQ.033', 'Afiadora de Ferramentas', 'VITOR&BUONO / PP-U3 / -'),
('Produção', 'MAQ.035', 'Lavadora Ultrassônica', 'CRISTOFOLI / /'),
('Produção', 'MAQ.036', 'Forno Industrial', 'NABERTHERM / LH120-12 /'),
('Produção', 'MAQ.037', 'Furo Rápido', 'TOP EDM / WSH-10 /'),
('Produção', 'MAQ.038', 'Impressora 3D Metal', 'RENISHAW / RenAM 500S /'),
('Produção', 'MAQ.039', 'Capela de Fluxo Laminar', 'SPPENCER /'),
('Produção', 'MAQ.040', 'Impressora 3D Filamento', '3DGENGE / DOUBLE P255 /'),
('Produção', 'MAQ.041', 'Impressora 3D Filamento', 'CREATBOT / F160 / -'),
('Produção', 'MAQ.042', 'Impressora 3D Filamento', 'CREATBOT / F160 / -'),
('Produção', 'MAQ.043', 'Sistema HVAC (sala limpa)', ''),
('Produção', 'MAQ.044', 'Forno Industrial', 'JUNG / 10090 /'),
('Produção', 'MAQ.045', 'Impressora de Etiquetas', ''),
('Produção', 'MAQ.046', 'Lavadora Ultrassônica', 'CTA ULTRASONIC SYSTEMS / UPL 50A /'),
('Produção', 'MAQ.047', 'Destilador', 'CRISTOFOLI / /'),
('Produção', 'MAQ.048', 'Mini Caldeira', 'MINI / /'),
('Produção', 'MAQ.049A', 'Retífica', 'ODONTOMEGA / S1 / CR210326789'),
('Produção', 'MAQ.049B', 'Retífica', 'ODONTOMEGA / S1 / CR0510220102'),
('Produção', 'MAQ.049C', 'Retífica', 'ODONTOMEGA / S1 / CR210328658'),
('Produção', 'MAQ.049D', 'Retífica', 'ODONTOMEGA / S1 / CR210326905'),
('Produção', 'MAQ.050', 'Fonte (Instruterm) - Anodização', 'STAR POWER / /'),
('Produção', 'MAQ.051A', 'Impressoras de Etiquetas', ''),
('Produção', 'MAQ.051B', 'Impressoras de Etiquetas', 'ZEBRA / ZD220 /'),
('Produção', 'MAQ.051C', 'Impressoras de Etiquetas', 'ENERGISTER / GC420t'),
('Produção', 'MAQ.051D', 'Impressoras de Etiquetas', 'ZEBRA / ZD220 /'),
('Produção', 'MAQ.052', 'Destilador', 'PILSEN/ SSDEST 5L /'),
('Produção', 'MAQ.053', 'Filtro', ''),
('Produção', 'MAQ.054', 'Sobrador Térmico', 'VONDER / STV200 / 22050262702'),
('Produção', 'MAQ.055', 'Lixadeira de Fita', 'VONDER / LCV375 /'),
('Produção', 'MAQ.056', 'Tamboreador', 'CARLO DI GIORGI / CDGMAXI /'),
('Produção', 'MAQ.057', 'Dessecador', ''),
('Produção', 'MAQ.058', 'Estufa', 'OLIDEF / /'),
('Produção', 'MAQ.059', 'Prensa Hidraulica 4 Toneladas ', 'VH MIDAS DENTAL PRODUCTS / 4TON /'),
('Produção', 'MAQ.060', 'Form Wash', 'FORMLABS / FORM WASH / HONYDEWDOVE'),
('Produção', 'MAQ.061', 'Form Cure', 'FORMLABS / FORM CURE / RUBYLOBSTER'),
('Produção', 'MAQ.062', 'Impressora 3D Resina', 'DAZZ / L120 PRO /'),
('Produção', 'MAQ.063', 'Impressora 3D Filamento', 'CREATBOT / F160 / -'),
('Produção', 'MAQ.064', 'Impressora 3D Filamento', 'CREATBOT / F160 / -'),
('Produção', 'MAQ.065', 'Peneira Renishaw', 'RENISHAW / /'),
('Produção', 'MAQ.066', 'Desumidificador', 'CHKWAI'),
('Produção', 'MAQ.067', 'Impressora 3D Metal', 'RITON / PXT-150 /'),
('Produção', 'MAQ.068', 'Impressora 3D Metal', 'RITON / PXT-150 /'),
('Produção', 'MAQ.069', 'Router CNC 4 eixos', ''),
('Produção', 'MAQ.070', 'Impressora 3D Resina', 'DAZZ / L120 /'),
('Produção', 'MAQ.071', 'Térmica', 'RODERS-TEC / RIS65 /'),
('Produção', 'MAQ.072', 'Compressor Puma', 'PUMA /'),
('Outros', 'MAQ.073', 'Autoclave Cristofoli', 'CRISTOFOLI / CLASS DD 12INOX /'),
('Produção', 'MAQ.074', 'Capela Hiperquimica', 'NOVACUT / /'),
('Produção', 'MAQ.075', 'Serra de Fita Horizontal', 'BAND SAW / /'),
('Produção', 'MAQ.076', 'Serra de Fita Horizontal', 'BAND SAW / /'),
('Produção', 'MAQ.077', 'Prensa Hidráulica Preta', 'MAX / VH03'),
('Produção', 'MAQ.078', 'Forno Industrial', 'RITON / RT-1300 /'),
('Produção', 'MAQ.079', 'Injetora', 'HAITIAN / SA 2000II'),
('Produção', 'MAQ.080', 'Termoformagem', 'VACUUM FORMING'),
('Produção', 'MAQ.081', 'Empacotador Circular', ''),
('Produção', 'MAQ.082', 'Empacotador Linear', ''),
('Produção', 'MAQ.083', 'Impressora 3D Filamento', 'CREATBOT / PEEK-300 /'),
('Produção', 'MAQ.084', 'Fonte (Eletromédicos', ''),
('Outros', 'MAQ.085', 'Estufa Bacteriológica', '7LAB / SSB-11L'),
('Produção', 'MAQ.086', 'Forno Infrared Redflow Oven (Eletromédicos)', ''),
('Produção', 'MAQ.087', 'Pick and Place', 'NEODEN 4 / /'),
('Produção', 'MAQ.088', 'Bobinadeira', ''),
('Produção', 'MAQ.089', 'Desumidificador', 'CHKAWAI / /'),
('Produção', 'MAQ.090', 'Serra de Fita', 'RITON / DLY18F1 /'),
('Produção', 'MAQ.091', 'Serra de Fita', 'RITON / DLY18F1 /'),
('Produção', 'MAQ.092', 'Capela de Fluxo Laminar', 'HIPPERQUIMICA / VERTCAL PER'),
('Produção', 'MAQ.093', 'Destilador - Osmose ', 'PURIMATE / ORM 16F /'),
('Produção', 'MAQ.095', 'Lavadora Ultrassônica', 'CTA ULTRASONIC SYSTEMS / UPL 50A /'),
('Produção', 'MAQ.096', 'Projetor de Perfil', 'DIGIMESS / 400.400 / -'),
('Produção', 'MAQ.097', 'CNC Torno Tipo Suiço', 'CITIZEN / L120E-2M12 / QF4389'),
('Produção', 'MAQ.098', 'Destilador', 'SOLID STELL / PILSEN /'),
('Produção', 'MAQ.099', 'CNC', 'YENADENT / D43N'),
('Produção', 'MAQ.100', 'Estufa', 'MYLABBOR'),
('Produção', 'MAQ.101A', 'Impressora 3D Filamento', 'CREATBOT / F160 /'),
('Produção', 'MAQ.101B', 'Impressora 3D Filamento', 'CREATBOT / F160 /'),
('Produção', 'MAQ.101C', 'Impressora 3D Filamento', 'CREATBOT / F160 /'),
('Produção', 'MAQ.102', 'Contador de Colonias Digital', 'GLOBAL TRADE TECNOLIGA / J3V /'),
('Produção', 'MAQ.103', 'Maquina de Ensaios (Tração/Compressão) (', 'DONGGUAN LIXIAN INSTRUMENT SCIENTIFIC / HZ-1009A / 201912160302'),
('Inspeção da Qualidade', 'MAQ.104', 'Projetor de Perfil', 'EASSON / SP 4030 /');

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
  `omDtEntregasDesejada` varchar(100) DEFAULT NULL,
  `omDtEntregaReal` varchar(200) DEFAULT NULL,
  `dtExecucao` varchar(100) DEFAULT NULL,
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
  `tempoNaoOperacional` varchar(30) NOT NULL,
  `desAlinhamento` varchar(300) NOT NULL,
  `dataAlinhamento` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `ordenmanutencao`
--

INSERT INTO `ordenmanutencao` (`omId`, `omUserCriador`, `omNomeCriador`, `omEmailCriador`, `omDtCriacao`, `omDtUpdate`, `omUserIp`, `omSetor`, `omDescricao`, `omNomeArquivo`, `omGrauUrgencia`, `omDtEntregasDesejada`, `omDtEntregaReal`, `dtExecucao`, `omObs`, `omStatus`, `omTipoManutencao`, `omOperacional`, `omAcaoQualidade`, `omRequalificar`, `omIdRespRequalificar`, `omIdRespManutencao`, `idMaquina`, `omNomeMaquina`, `omIdentificadorMaquina`, `tempoNaoOperacional`, `desAlinhamento`, `dataAlinhamento`) VALUES
(1, 'Administrador', 'vanessapaiva', 'vanessa.paiva@fixgrupo.com.br', '2024-06-17 13:47:49', '2024-06-17 13:47:49', '127.0.0.1', ' Anodização', 'aGFDDH DGDFGD ', NULL, '3', '2024-06-21', NULL, NULL, NULL, 'CONCLUÍDO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL),
(2, 'Administrador', 'vanessapaiva', 'vanessa.paiva@fixgrupo.com.br', '2024-06-17 15:10:10', '2024-06-17 15:10:10', '127.0.0.1', ' Jateamento', 'Gucugc', NULL, '2', '2024-06-20', NULL, NULL, NULL, 'PAUSADO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL),
(3, 'Administrador', 'thaistivelli', 'thais.tivelli@fixhealth.com.br', '2024-06-18 20:54:06', '2024-06-18 20:54:06', '127.0.0.1', ' Anodização', 'teste', NULL, '1', '2024-06-25', NULL, NULL, 'teste', 'EM ANDAMENTO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL),
(4, 'Administrador', 'thaistivelli', 'thais.tivelli@fixhealth.com.br', '2024-06-18 21:23:17', '2024-06-18 21:23:17', '127.0.0.1', ' Impressão Filamento/Resina', 'Manutenção: preventiva ou corretiva?\r\nA maquina está operacional: sim ou não // ação da qualidade: verificar a plaquinha de não operacional ou verificar se realmente deve estar opericional\r\nDescreva a', NULL, '3', '2024-06-20', NULL, NULL, 'Descreva a manutenção que precisa ser feita. // verificar necessidade de requalificação. Quem vai estar responsavel pela requalificação', 'CRIADO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL),
(5, 'Gestor(a)', 'thaistivelli', 'thais.tivelli@fixhealth.com.br', '2024-06-20 16:56:43', '2024-06-20 16:56:43', '127.0.0.1', 'Anodização', 'teste', NULL, '5', '2024-06-21', '2024-07-18', NULL, 'teste', 'CRIADO', 'preventiva', 'sim', 'op1', 'sim', 8, 16, NULL, NULL, NULL, '', '', NULL),
(9, 'Administrador', 'samuel', 'samuel@teste.com', '2024-07-09 19:51:41', '2024-07-09 19:51:41', '127.0.0.1', 'Anodização', 'Lorem ipsum', NULL, '1', '2024-07-10', '2024-07-30', '2024-07-29', 'TESTE', 'CRIADO', '', '', 'op1', 'sim', 29, 29, NULL, NULL, NULL, '', '', NULL),
(13, 'Administrador', 'brunateste', 'brunateste@teste.com', '2024-08-06 15:53:24', '2024-08-06 15:53:24', '127.0.0.1', 'None', 'teste ', NULL, '2', NULL, NULL, NULL, 'observação', 'CRIADO', 'Manutenção Preventiva', 'Não Operável', NULL, NULL, NULL, NULL, 'MAQ.005', 'CNC Torno Tipo Suiço', 'CITIZEN / A20-3F7 / AG5166', '10 DIAS', '', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `ordenservico`
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
(29, 'Colaborador(a)', 'smorbeckcpmh', 'sullivan.morbeck@fixhealth.com.br', '2024-06-13 18:07:11', '2024-06-13 18:07:11', '127.0.0.1', 'Usinagem', 'xxx', 'xxx', 'xxx', 'https://firebasestorage.googleapis.com/v0/b/sistemas-fabrica.appspot.com/o/arquivosOS%2Fxxx%2F3188A920.X74-DX.%20-%20Placa%202%2C0%20Ancoragem%20Trava%20Fio%20YY%2030%C2%BA%20-%20Direita%20%5BLASER%20CUT%20-%20LONGA%5D.DXF?alt=media&token=e4b8015b-fd47-43b9-9c49-915356e1fe05', '1', '2024-06-13', '2024-06-13', '2021-06-13', 'TESTE DE EXTENSÃO DE ARQUIVOS DA FERRAMENTA DE UPLOAD', 'CRIADO'),
(30, 'Colaborador(a)', 'carollinacastro', 'carollina.castro@fixhealth.com.br', '2024-06-17 15:02:29', '2024-06-17 15:02:29', '127.0.0.1', 'Impressão Filamento/Resina', 'Referente a NCBNLVQ5, replicar o pedido 11823 (Smartmold), paciente EPZ, dra Danielle Sales. No final é preciso ter molde negativo de silicone, molde de filamento e PMMA.\r\nRecomendo Usar o mesmo fatia', '0093/0424', '11823', '', '4', '2024-06-25', '2024-06-25', '', 'Qualquer dúvida procurar Carollina ou Augusto da Qualidade', 'EM ANDAMENTO'),
(31, 'Administrador', 'carollinacastro', 'carollina.castro@fixhealth.com.br', '2024-06-17 20:02:12', '2024-06-17 20:02:12', '127.0.0.1', 'Limpeza 1', 'SACOTQTAH - Chave de mão para troca de produto de reclamação de cliente. Passar por acabamento (apenas para tirar as marcas de uso), inspeção1, limpeza, inspeção 3, embalagem final e rotulagem.', '0019/0823', '', '', '4', '2024-06-19', '2024-06-20', '', 'Qualquer dúvida procurar Carollina da Qualidade', 'CONCLUÍDO'),
(32, 'Colaborador(a)', 'smorbeckcpmh', 'sullivan.morbeck@fixhealth.com.br', '2024-06-18 11:02:37', '2024-06-18 11:02:37', '127.0.0.1', 'Usinagem', 'Fabricação de AncorFix, modelos A920.173-X3, A920.174-X3, A920.175-X3 e A920.175-X4. 6 unidades de cada para reunião com o Ertty.', 'N/A', 'N/A', '', '5', '2024-06-18', '2024-06-28', '', 'Farei pessoalmente a fabricação destes itens, de modo que não será necessário a utilização de mão de obra da fábrica.', 'CONCLUÍDO'),
(33, 'Colaborador(a)', 'joicecensi', 'joice.censi@fixhealth.com.br', '2024-06-19 14:19:21', '2024-06-19 14:19:21', '127.0.0.1', 'Usinagem', 'Molde PEEK', '', '', '', '4', '2024-06-25', '2024-06-26', '', '', 'CONCLUÍDO'),
(34, 'Colaborador(a)', 'joicecensi', 'joice.censi@fixhealth.com.br', '2024-06-19 14:23:38', '2024-06-19 14:23:38', '127.0.0.1', 'Usinagem', 'CORTE CHAPAS FOSSA', '', '', '', '4', '2024-06-19', '2024-06-19', '', '', 'CONCLUÍDO'),
(35, 'Colaborador(a)', 'vitormaman', 'vitor.maman@fixhealth.com.br', '2024-06-19 20:21:48', '2024-06-19 20:21:48', '127.0.0.1', 'Impressão Filamento/Resina', 'Preciso que seja impresso as bases: negativas e positiva, referente ao smartmold da região do zigoma esquerdo, que foi informado que estava com iniciais do paciente ilegíveis, para assim, descobrirmos', '0013/0624', '12032', '', '5', '2024-06-21', '2024-06-26', '2024-06-24', 'https://cpmhindustria.sharepoint.com/:f:/s/GRUPOFIX/Ep2xO45CFe1AoN8vHR1UYpAB9b3ToU9ouWjTlha19gKIIQ?e=5uAqPX', 'CONCLUÍDO'),
(36, 'Colaborador(a)', 'joicecensi', 'joice.censi@fixhealth.com.br', '2024-06-26 13:31:23', '2024-06-26 13:31:23', '127.0.0.1', 'Usinagem', 'Impressão de Customlife para teste de Usinagem\r\nImpressão RITON', '', '', '', '0', '2024-06-29', '2024-06-29', '2024-07-02', '', 'CONCLUÍDO'),
(37, 'Colaborador(a)', 'josemendonca', 'jose.mendonca@fixhealth.com.br', '2024-06-27 10:46:11', '2024-06-27 10:46:11', '127.0.0.1', 'Embalagem', 'Embalar para o semi acabado, as tampas de proteção (Cicatrizado) 200 unidades Lote: 240618100001', '240618100001', 'N/A', '', '0', '2024-06-27', '2024-07-10', '2024-07-09', '', 'CONCLUÍDO'),
(38, 'Colaborador(a)', 'josemendonca', 'jose.mendonca@fixhealth.com.br', '2024-06-27 10:52:59', '2024-06-27 10:52:59', '127.0.0.1', 'Embalagem', 'Embalar Parafusos-MU-1.4 referente ao LOTE: 0858/1223 - 188 unidades', '0858/1223', 'N/A', '', '0', '2024-06-27', '2024-07-10', '2024-07-09', '', 'CONCLUÍDO'),
(39, 'Colaborador(a)', 'anielyalves', 'aniely.alves@fixhealth.com.br', '2024-07-09 17:01:20', '2024-07-09 17:01:20', '127.0.0.1', 'Usinagem', 'Temos 4 cabeças impressas em filamento que estão vazias. As cabeças possuem os implantes dos produtos e são usadas para exposição. Solicito o preenchimento pelo material mais adequado do interior da c', 'n/a', 'n/a', '', '4', '2024-07-16', '2024-07-26', '', 'Qualquer duvida, posso auxiliar', 'CONCLUÍDO'),
(40, 'Colaborador(a)', 'heloizabianca', 'heloiza.bianca@fixhealth.com.br', '2024-07-11 12:26:42', '2024-07-11 12:26:42', '127.0.0.1', 'Embalagem', 'Embalar os dispositivos \\\'Custom LIFE\\\" utilizados no roadtour para serem reutilizados no ensaio de usabilidade do IMPLANTIZE DPS. Desta forma, os dispositivos deverão ser embalados conforme email enc', 'N/A', 'N/A', 'https://firebasestorage.googleapis.com/v0/b/sistemas-fabrica.appspot.com/o/arquivosOS%2FN%2FA%2F3789Captura%20de%20tela%202024-07-11%20092551.png?alt=media&token=d66a327f-af9d-49bc-9f0a-b2c0c0b31bc6', '4', '2024-07-19', '2024-07-19', '2024-07-15', 'Quaiquer duvida entre em contato com o ramal 8883 - falar com Aline Ribeirou ou Heloiza Assis', 'CONCLUÍDO'),
(41, 'Colaborador(a)', 'leonardodiaz', 'leonardo.diaz@fixhealth.com.br', '2024-07-12 13:44:42', '2024-07-12 13:44:42', '127.0.0.1', 'Usinagem', 'Fazer os cortes a laser na placa de polímero com os diâmetros do desenho para colocar os parafusos que irão para o tratamento químico. ', 'N/A', 'N/A', 'https://firebasestorage.googleapis.com/v0/b/sistemas-fabrica.appspot.com/o/arquivosOS%2FN%2FA%2F8541Placa_parafusos.DXF?alt=media&token=cefa3ff1-e8aa-4d51-be84-a97ca7dbc98e', '2', '2024-07-19', '2024-07-26', '', '', 'CONCLUÍDO'),
(42, 'Colaborador(a)', 'lucassousa', 'lucas.sousa@fixhealth.com.br', '2024-07-15 17:54:46', '2024-07-15 17:54:46', '127.0.0.1', ' Usinagem', 'Para desenvolvimento da padronização do processo de SLA... Testes realizados com peças de rugosidade mensurável. ', 'N/A', 'N/A', 'https://firebasestorage.googleapis.com/v0/b/sistemas-fabrica.appspot.com/o/arquivosOS%2FN%2FA%2F6889PE%C3%87A%20003%20-%20GUIA.DXF?alt=media&token=e0de05e8-c09f-4e99-83d0-34178376d19f', '1', '2024-07-15', NULL, NULL, NULL, 'CRIADO'),
(43, 'Colaborador(a)', 'leonardodiaz', 'leonardo.diaz@fixhealth.com.br', '2024-07-17 12:02:48', '2024-07-17 12:02:48', '127.0.0.1', 'Impressão Filamento/Resina', 'Fazer impressão da caixa de proteção em ABS para fonte para resolver um SAC. ', 'N/A', 'N/A', '', '5', '2024-07-19', '2024-07-26', '', '', 'CONCLUÍDO'),
(44, 'Colaborador(a)', 'gabrielfreitas', 'gabriel.freitas@fixhealth.com.br', '2024-07-22 12:31:25', '2024-07-22 12:31:25', '127.0.0.1', 'Usinagem', 'Preciso verificar se as novas tolerâncias presentes nas próteses ATM e cabeça condilar nos fornecerão o encaixe correto, para isso iremos realizar ensaios de tração com alguns corpos de prova. Preciso', 'N/A', 'N/A', 'https://firebasestorage.googleapis.com/v0/b/sistemas-fabrica.appspot.com/o/arquivosOS%2FN%2FA%2F9878P-50001%20-%20Cabeca%20condilar%20P.pdf?alt=media&token=8b7de427-421d-40cb-b581-107cf9e20139', '4', '2024-07-31', '20224-07-24', '', 'PEDIDO CRIADO NO CALISTO - ENTREGA 02/07', 'CRIADO'),
(45, 'Colaborador(a)', 'gabrielfreitas', 'gabriel.freitas@fixhealth.com.br', '2024-07-22 12:32:24', '2024-07-22 12:32:24', '127.0.0.1', 'Usinagem', 'Preciso verificar se as novas tolerâncias presentes nas próteses ATM e cabeça condilar nos fornecerão o encaixe correto, para isso iremos realizar ensaios de tração com alguns corpos de prova. Preciso', 'N/A', 'N/A', 'https://firebasestorage.googleapis.com/v0/b/sistemas-fabrica.appspot.com/o/arquivosOS%2FN%2FA%2F6648haste%20para%20ensaio.pdf?alt=media&token=e97e1ebb-1616-4f7f-9452-0e8f40852708', '4', '2024-07-31', '2024-07-24', '', 'FEITO PEDIDO CALISTO - ENTREGA 02/08', 'CONCLUÍDO'),
(46, 'Colaborador(a)', 'lucassousa', 'lucas.sousa@fixhealth.com.br', '2024-07-22 15:38:54', '2024-07-22 15:38:54', '127.0.0.1', 'Impressão Titânio', 'Realizar impressão metálica na MAQ.067 - Riton, utilizando o novo perfil de fatiamento e configurações da maquina, para ensaios de tração. Corpos de prova conforme protocolo anexado!', 'N/A', 'N/A', 'https://firebasestorage.googleapis.com/v0/b/sistemas-fabrica.appspot.com/o/arquivosOS%2FN%2FA%2F2274Prot.%20Impr.%20Corpos%20de%20Prova%20-%20Riton%20-%20Virgem.pdf?alt=media&token=5adfa87d-eff7-493d-a0a9-b165db733625', '3', '2024-07-26', '2024-08-26', '', 'QUALIFICAÇÃO DE EQUIPAMENTOS', 'EM ANDAMENTO'),
(47, 'Colaborador(a)', 'lucassousa', 'lucas.sousa@fixhealth.com.br', '2024-07-22 17:50:09', '2024-07-22 17:50:09', '127.0.0.1', 'Usinagem', 'Realizar cortes chapa 1 mm ou 0,8 mm para dispositivo de inspeção para os parafusos.', 'N/A', 'N/A', '', '3', '2024-07-26', '2024-07-26', '', 'DISPOSITIVO INSPEÇÃO PARAFUSOS.', 'CONCLUÍDO'),
(48, 'Colaborador(a)', 'joicecensi', 'joice.censi@fixhealth.com.br', '2024-07-23 13:35:52', '2024-07-23 13:35:52', '127.0.0.1', 'Impressão Titânio', 'Impressão teste para Customlife Max + Mand no Blender. \r\nImpressão: 4 itens (2 biomodelos max e mand e 2 customlife max e mand)', '', '', '', '3', '2024-07-29', '2024-07-24', '2024-07-23', 'João vai acompanhar o teste. Arquivos no drive. ', 'CONCLUÍDO'),
(49, 'Gestor(a)', 'thaistivelli', 'thais.tivelli@fixhealth.com.br', '2024-07-23 17:20:38', '2024-07-23 17:20:38', '127.0.0.1', 'Impressão Filamento/Resina', 'Preciso que imprima o protótipo que o Leonardo de projetos enviará direto para o Jairo. Será impressa em ABS e conforme especificações no solidworks do Leonardo.', '', '', '', '4', '2024-07-25', '2024-07-25', '', 'Qualquer duvida procurar Thais (qualidade)', 'CONCLUÍDO'),
(50, 'Colaborador(a)', 'heloizabianca', 'heloiza.bianca@fixhealth.com.br', '2024-07-24 13:28:50', '2024-07-24 13:28:50', '127.0.0.1', 'Embalagem', 'Solicito que as próteses e guias do ensaio de usabilidade anteriormente embalados em graus + blister, seja reembalado em duplo blister. \r\nfeito pedido para esta demanda. ', 'N/A', 'N/A', '', '5', '2024-07-26', '2024-07-26', '', 'Quaiquer duvida entre em contato com o ramal 8883 - falar com Aline Ribeirou ou Heloiza Assis', 'CONCLUÍDO'),
(51, 'Colaborador(a)', 'lucassousa', 'lucas.sousa@fixhealth.com.br', '2024-07-31 17:25:48', '2024-07-31 17:25:48', '127.0.0.1', ' Impressão Titânio', 'Realizar impressão em 3D em titânio com pó Oversize na RITON MAQ.067 ou 068. Este componente servirá como protótipo para substituir as cascas do smartmold. OBS.: OS ARQUIVOS JA FORAM ENVIADOS PARA O J', 'N/A', 'N/A', '', '3', '2024-08-07', NULL, NULL, NULL, 'CRIADO'),
(52, 'Colaborador(a)', 'gabrielfreitas', 'gabriel.freitas@fixhealth.com.br', '2024-08-01 19:06:02', '2024-08-01 19:06:02', '127.0.0.1', 'Impressão Filamento/Resina', 'Realizar impressão com nova resina clear para verificar sua resistência a flexão quando comparada com a resina atualmente utilizada. Serão impressos ao menos 7 corpos de provas com cada resina, dando ', 'N/A', 'N/A', 'https://firebasestorage.googleapis.com/v0/b/sistemas-fabrica.appspot.com/o/arquivosOS%2FN%2FA%2F2802impress%C3%A3o%20teste%20prizma.STL?alt=media&token=3e834146-6fe5-4846-afbe-711ae810aede', '3', '2024-08-09', '2024-08-05', '', 'Serão realizadas impressões com a resina atual (SMARTDENT CLEAR) e com a resina teste (PRIZMA BIOSPRINT)', 'EM ANDAMENTO'),
(53, 'Colaborador(a)', 'heloizabianca', 'heloiza.bianca@fixhealth.com.br', '2024-08-02 13:54:31', '2024-08-02 13:54:31', '127.0.0.1', ' Gravação', 'Gravar a frase \\\"NÃO IMPLANTÁVEL\\\" nos seguintes itens reprovados que estão armazenados na Inspeção: \r\n16 Customlifes \r\n6 Guias de corte e perfuração \r\n5 barras \r\n2 Reconstruções \r\n3 ATMs \r\n20 placas ', NULL, NULL, '', '3', '2024-08-09', NULL, NULL, NULL, 'CRIADO'),
(54, 'Colaborador(a)', 'jefersonlucas', 'jeferson.lucas@fixhealth.com.br', '2024-08-02 15:59:11', '2024-08-02 15:59:11', '127.0.0.1', 'Embalagem', 'embalagem e etiquetagem das canulas diros que se encontram disponiveis ,foi feita a inspeção .\r\nquantidade 150 unidades .  466-020/100/10  fabricado 05/02/2024  - validade 05-02-2028 lote 9808 ', '9808 ', 'embalagem', '', '5', '2024-08-05', '2024-08-05', '', '', 'CONCLUÍDO'),
(55, 'Colaborador(a)', 'jefersonlucas', 'jeferson.lucas@fixhealth.com.br', '2024-08-05 17:42:26', '2024-08-05 17:42:26', '127.0.0.1', 'Embalagem', 'solcito a embalagem das canulas Diros \r\n 40 unidades  . 466-020/100/10-SC  fabricado 13/03/2024 validade 13/03/2028\r\nlote  10148', '10148', '.', '', '5', '2024-08-05', '2024-08-12', '', '', 'REQUALIFICADO'),
(56, 'Colaborador(a)', 'jefersonlucas', 'jeferson.lucas@fixhealth.com.br', '2024-08-05 17:46:28', '2024-08-05 17:46:28', '127.0.0.1', 'Embalagem', 'Solicito a embalagem das canulas da Diros  \r\n60 unidades . 466-020/100/10-SC fabricado 20-03-2024 validade 20/03/2028 . \r\nlote 10190', '10190', '.', '', '5', '2024-08-05', '2024-08-13', '', '', 'REQUALIFICADO'),
(57, 'Colaborador(a)', 'jefersonlucas', 'jeferson.lucas@fixhealth.com.br', '2024-08-05 17:49:14', '2024-08-05 17:49:14', '127.0.0.1', 'Embalagem', 'Solicito a embalagem das canulas Diros \r\n60 unidades 466-020/150/10 fabricado 05-02-2024 validade 05-02-2028  \r\nlote 9812', '9812', '.', '', '5', '2024-08-05', '2024-08-14', '', '', 'REQUALIFICADO'),
(58, 'Colaborador(a)', 'lucassousa', 'lucas.sousa@fixhealth.com.br', '2024-08-06 18:42:13', '2024-08-06 18:42:13', '127.0.0.1', 'Usinagem', 'Realizar cortes a laser em material EVA de 3 e 10 mm de espessura. ', 'N/A', 'N/A', '', '0', '2024-08-09', '2024-08-09', '', 'Arquivo DXF de corte enviado para SLACK Jairo Ferreira.', 'EM ANDAMENTO'),
(59, 'Colaborador(a)', 'joicecensi', 'joice.censi@fixhealth.com.br', '2024-08-06 19:12:54', '2024-08-06 19:12:54', '127.0.0.1', ' Usinagem', 'Cortar chapa do molde de polietileno em 2 conjuntos - Dúvidas chamar Amorim', NULL, NULL, '', '3', '2024-08-09', NULL, NULL, NULL, 'CRIADO'),
(60, 'Colaborador(a)', 'joicecensi', 'joice.censi@fixhealth.com.br', '2024-08-06 19:30:28', '2024-08-06 19:30:28', '127.0.0.1', ' Impressão Titânio', 'Impressão do molde para moldagem de polietileno. ', NULL, NULL, '', '3', '2024-08-06', NULL, NULL, 'impresso com pó de titânio oversize ', 'CRIADO'),
(63, 'Colaborador(a)', 'lucassousa', 'lucas.sousa@fixhealth.com.br', '2024-08-07 15:43:48', '2024-08-07 15:43:48', '127.0.0.1', ' Usinagem', 'Realizar corte em material EVA de 100 mm de espessura - 1 peça de cada arquivo cabeça condilar M e P. ', 'N/A', 'N/A', '', '3', '2024-08-14', NULL, NULL, 'Arquivo DXF de corte enviado para SLACK Jairo Ferreira.', 'CRIADO'),
(61, 'Colaborador(a)', 'jefersonlucas', 'jeferson.lucas@fixhealth.com.br', '2024-08-06 20:13:22', '2024-08-06 20:13:22', '127.0.0.1', ' Embalagem', 'solicito a embalagem de 40 canulas  , fabricaçao 13-02-2024 validade 13-02-2028 . lote 9900 ', '9900', '.', '', '5', '2024-08-07', NULL, NULL, NULL, 'CRIADO'),
(62, 'Colaborador(a)', 'joicecensi', 'joice.censi@fixhealth.com.br', '2024-08-07 10:13:11', '2024-08-07 10:13:11', '127.0.0.1', ' Impressão Filamento/Resina', 'Impressão de filamento para peças de teste de anodização. ', NULL, NULL, '', '2', '2024-08-09', NULL, NULL, 'Pedido Thais Tivelli', 'CRIADO'),
(64, 'Colaborador(a)', 'heloizabianca', 'heloiza.bianca@fixhealth.com.br', '2024-08-08 11:19:05', '2024-08-08 11:19:05', '127.0.0.1', ' Embalagem', 'Reembalar o smartmold entregue a colaboradora Jessika, para retirada do copo de medição. ', 'N/A', 'N/A', '', '4', '2024-08-08', NULL, NULL, NULL, 'CRIADO'),
(65, 'Colaborador(a)', 'joicecensi', 'joice.censi@fixhealth.com.br', '2024-08-09 11:11:20', '2024-08-09 11:11:20', '127.0.0.1', ' Usinagem', 'Limpeza da plataforma Renishaw', NULL, NULL, '', '1', '2024-09-30', NULL, NULL, 'Responsável Rayro. ', 'CRIADO');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `projetista` varchar(255) DEFAULT NULL,
  `dr` varchar(255) DEFAULT NULL,
  `pac` varchar(255) DEFAULT NULL,
  `rep` varchar(255) DEFAULT NULL,
  `pedido` varchar(255) DEFAULT NULL,
  `dt` date DEFAULT NULL,
  `produto` varchar(255) DEFAULT NULL,
  `dataEntrega` date DEFAULT NULL,
  `fluxo` int(11) DEFAULT NULL,
  `lote` varchar(100) DEFAULT NULL,
  `cdgprod` text DEFAULT NULL,
  `qtds` text DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `diasparaproduzir` int(11) DEFAULT NULL,
  `taxa_extra` int(11) DEFAULT NULL,
  `nacional_internacional` varchar(20) DEFAULT NULL,
  `obs` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `pedidos`
--

INSERT INTO `pedidos` (`id`, `projetista`, `dr`, `pac`, `rep`, `pedido`, `dt`, `produto`, `dataEntrega`, `fluxo`, `lote`, `cdgprod`, `qtds`, `descricao`, `diasparaproduzir`, `taxa_extra`, `nacional_internacional`, `obs`) VALUES
(59, NULL, ' Souza', 'GVC', NULL, '2045', '2024-08-09', NULL, NULL, 1, '011', NULL, NULL, NULL, NULL, 1, '', 'observação'),
(60, NULL, ' Souza', 'GRA', NULL, '056', '2024-08-09', NULL, NULL, 1, 'd', NULL, NULL, NULL, NULL, 1, 'nacional', 'obs teste final');

-- --------------------------------------------------------

--
-- Estrutura para tabela `produto`
--

CREATE TABLE `produto` (
  `id` int(11) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `codigo` varchar(50) DEFAULT NULL,
  `idfluxo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `prodId` int(11) NOT NULL,
  `prodCodCallisto` varchar(48) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `prodDescricao` varchar(128) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `prodAnvisa` varchar(128) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `prodCategoria` varchar(48) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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

CREATE TABLE `realizacaoproducao` (
  `id` int(11) NOT NULL,
  `idPedido` int(11) DEFAULT NULL,
  `idFluxo` int(11) DEFAULT NULL,
  `numOrdem` int(11) DEFAULT NULL,
  `idEtapa` int(11) DEFAULT NULL,
  `idStatus` int(11) NOT NULL,
  `dataRealizacao` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `realizacaoproducao`
--

INSERT INTO `realizacaoproducao` (`id`, `idPedido`, `idFluxo`, `numOrdem`, `idEtapa`, `idStatus`, `dataRealizacao`) VALUES
(32, 16, 17, 1, 72, 1, '2024-06-21'),
(31, 12, 17, 15, 13, 1, '2024-07-09'),
(30, 12, 17, 14, 18, 1, '2024-07-08'),
(29, 12, 17, 13, 35, 1, '2024-07-05'),
(28, 12, 17, 12, 52, 1, '2024-07-04'),
(27, 12, 17, 11, 23, 1, '2024-07-03'),
(26, 12, 17, 10, 33, 1, '2024-07-02'),
(25, 12, 17, 9, 65, 1, '2024-07-01'),
(24, 12, 17, 8, 4, 3, '2024-06-28'),
(23, 12, 17, 7, 31, 7, '2024-06-27'),
(22, 12, 17, 6, 1, 1, '2024-06-26'),
(21, 12, 17, 5, 88, 1, '2024-06-25'),
(20, 12, 17, 4, 87, 1, '2024-06-24'),
(19, 12, 17, 3, 28, 4, '2024-06-21'),
(18, 12, 17, 2, 74, 4, '2024-06-20'),
(17, 12, 17, 1, 72, 4, '2024-06-19'),
(33, 16, 17, 2, 74, 1, '2024-06-24'),
(34, 16, 17, 3, 28, 1, '2024-06-25'),
(35, 16, 17, 4, 87, 1, '2024-06-26'),
(36, 16, 17, 5, 88, 1, '2024-06-27'),
(37, 16, 17, 6, 1, 1, '2024-06-28'),
(38, 16, 17, 7, 31, 1, '2024-07-01'),
(39, 16, 17, 8, 4, 1, '2024-07-02'),
(40, 16, 17, 9, 65, 1, '2024-07-03'),
(41, 16, 17, 10, 33, 1, '2024-07-04'),
(42, 16, 17, 11, 23, 1, '2024-07-05'),
(43, 16, 17, 12, 52, 1, '2024-07-08'),
(44, 16, 17, 13, 35, 1, '2024-07-09'),
(45, 16, 17, 14, 18, 1, '2024-07-10'),
(46, 16, 17, 15, 13, 1, '2024-07-11'),
(47, 17, 17, 1, 72, 2, '2024-06-21'),
(48, 17, 17, 2, 74, 1, '2024-06-24'),
(49, 17, 17, 3, 28, 1, '2024-06-25'),
(50, 17, 17, 4, 87, 1, '2024-06-26'),
(51, 17, 17, 5, 88, 1, '2024-06-27'),
(52, 17, 17, 6, 1, 1, '2024-06-28'),
(53, 17, 17, 7, 31, 1, '2024-07-01'),
(54, 17, 17, 8, 4, 1, '2024-07-02'),
(55, 17, 17, 9, 65, 1, '2024-07-03'),
(56, 17, 17, 10, 33, 1, '2024-07-04'),
(57, 17, 17, 11, 23, 1, '2024-07-05'),
(58, 17, 17, 12, 52, 1, '2024-07-08'),
(59, 17, 17, 13, 35, 1, '2024-07-09'),
(60, 17, 17, 14, 18, 1, '2024-07-10'),
(61, 17, 17, 15, 13, 1, '2024-07-11'),
(62, 59, 1, 1, 79, 1, '2024-08-09'),
(63, 59, 1, 2, 88, 1, '2024-08-09'),
(64, 59, 1, 3, 82, 1, '2024-08-09'),
(65, 59, 1, 4, 31, 1, '2024-08-12'),
(66, 59, 1, 5, 3, 1, '2024-08-12'),
(67, 59, 1, 6, 23, 1, '2024-08-13'),
(68, 59, 1, 7, 52, 1, '2024-08-13'),
(69, 59, 1, 8, 35, 1, '2024-08-13'),
(70, 59, 1, 9, 13, 1, '2024-08-13');

-- --------------------------------------------------------

--
-- Estrutura para tabela `setor`
--

CREATE TABLE `setor` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `setor`
--

INSERT INTO `setor` (`id`, `nome`) VALUES
(1, 'PROGRAMAÇÃO E IMPRESSÃO'),
(2, 'TRATAMENTO TÉRMICO'),
(3, 'USINAGEM'),
(4, 'ACABAMENTO'),
(5, 'INSPEÇÃO 1'),
(6, 'SLA E ANODIZAÇÃO'),
(7, 'MOLDAGEM E ANODIZAÇÃO'),
(8, 'INSPEÇÃO 2'),
(9, 'GRAVAÇÃO'),
(10, 'LIMPEZA'),
(11, 'INSPEÇÃO 3'),
(12, 'EMBALAGEM ESTÉRIL'),
(13, 'ESTERILIZAÇÃO'),
(14, 'EMB ROTULAGEM FINAL'),
(15, 'LIBERAÇÃO FINAL');

-- --------------------------------------------------------

--
-- Estrutura para tabela `setores_form_inf_003`
--

CREATE TABLE `setores_form_inf_003` (
  `id_setor` int(11) NOT NULL,
  `nome_setor` varchar(70) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `setores_form_inf_003`
--

INSERT INTO `setores_form_inf_003` (`id_setor`, `nome_setor`) VALUES
(1, 'Áreas Administrativas'),
(2, 'Banheiro'),
(3, 'Copa / Cozinha'),
(4, 'Produção');

-- --------------------------------------------------------

--
-- Estrutura para tabela `setor_arcondicionado`
--

CREATE TABLE `setor_arcondicionado` (
  `id` int(11) NOT NULL,
  `descricao_setores` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `setor_arcondicionado`
--

INSERT INTO `setor_arcondicionado` (`id`, `descricao_setores`) VALUES
(1, 'SALA DE REUNIÃO TERREO'),
(2, 'SALA PCP'),
(3, 'SALA ENGENHARIA/PROJETOS'),
(4, 'SALA MANUTENÇÃO'),
(5, 'SALA IMPRESSORA TITANIUM'),
(6, 'SALA IMPRESSORAS FILAMENTO'),
(7, 'SALA QUALIDADE INSPEÇÃO'),
(8, 'SALA ESTOQUE CPMH'),
(0, 'SALA ESTOQUE BRASFIX'),
(10, 'SALA ESTOQUE OSTEOFIX'),
(11, 'SALA REUNIÃO 1º ANDAR'),
(12, 'SALA LOUNGE'),
(13, 'SALA PRESIDENCIA'),
(14, 'AUDITORIO'),
(15, 'CPD'),
(16, 'SALA DE JOGOS'),
(17, 'SALA ADMINISTRATIVO/FINANCEIRO'),
(18, 'SALA MARKETING/DIRETORIA'),
(19, 'SALA DE DESCANSO'),
(20, 'SALA DE REUNIÃO TERREO'),
(21, 'SALA PCP'),
(22, 'SALA ENGENHARIA/PROJETOS'),
(23, 'SALA MANUTENÇÃO'),
(24, 'SALA IMPRESSORA TITANIUM'),
(25, 'SALA IMPRESSORAS FILAMENTO'),
(57, 'SALA QUALIDADE INSPEÇÃO'),
(58, 'SALA ESTOQUE CPMH'),
(59, 'SALA ESTOQUE BRASFIX'),
(60, 'SALA ESTOQUE OSTEOFIX'),
(61, 'SALA REUNIÃO 1º ANDAR'),
(62, 'SALA LOUNGE'),
(63, 'SALA PRESIDENCIA'),
(64, 'AUDITORIO'),
(65, 'CPD'),
(66, 'SALA DE JOGOS'),
(67, 'SALA ADMINISTRATIVO/FINANCEIRO'),
(68, 'SALA MARKETING/DIRETORIA'),
(69, 'SALA DE DESCANSO'),
(70, 'SALA DE REUNIÃO TERREO'),
(71, 'SALA PCP'),
(72, 'SALA ENGENHARIA/PROJETOS'),
(73, 'SALA MANUTENÇÃO'),
(74, 'SALA IMPRESSORA TITANIUM'),
(75, 'SALA IMPRESSORAS FILAMENTO'),
(76, 'SALA QUALIDADE INSPEÇÃO'),
(77, 'SALA ESTOQUE CPMH'),
(78, 'SALA ESTOQUE BRASFIX'),
(79, 'SALA ESTOQUE OSTEOFIX'),
(80, 'SALA REUNIÃO 1º ANDAR'),
(81, 'SALA LOUNGE'),
(82, 'SALA PRESIDENCIA'),
(83, 'AUDITORIO'),
(84, 'CPD'),
(85, 'SALA DE JOGOS'),
(86, 'SALA ADMINISTRATIVO/FINANCEIRO'),
(87, 'SALA MARKETING/DIRETORIA'),
(88, 'SALA DE DESCANSO'),
(89, 'SALA DE REUNIÃO TERREO'),
(90, 'SALA PCP'),
(91, 'SALA ENGENHARIA/PROJETOS'),
(92, 'SALA MANUTENÇÃO'),
(93, 'SALA IMPRESSORA TITANIUM'),
(94, 'SALA IMPRESSORAS FILAMENTO'),
(95, 'SALA QUALIDADE INSPEÇÃO'),
(96, 'SALA ESTOQUE CPMH'),
(97, 'SALA ESTOQUE BRASFIX'),
(98, 'SALA ESTOQUE OSTEOFIX'),
(99, 'SALA REUNIÃO 1º ANDAR'),
(100, 'SALA LOUNGE'),
(101, 'SALA PRESIDENCIA'),
(102, 'AUDITORIO'),
(103, 'CPD'),
(104, 'SALA DE JOGOS'),
(105, 'SALA ADMINISTRATIVO/FINANCEIRO'),
(106, 'SALA MARKETING/DIRETORIA'),
(107, 'SALA DE DESCANSO'),
(108, 'SALA DE REUNIÃO TERREO'),
(109, 'SALA PCP'),
(110, 'SALA ENGENHARIA/PROJETOS'),
(111, 'SALA MANUTENÇÃO'),
(112, 'SALA IMPRESSORA TITANIUM'),
(113, 'SALA IMPRESSORAS FILAMENTO'),
(114, 'SALA QUALIDADE INSPEÇÃO'),
(115, 'SALA ESTOQUE CPMH'),
(116, 'SALA ESTOQUE BRASFIX'),
(117, 'SALA ESTOQUE OSTEOFIX'),
(118, 'SALA REUNIÃO 1º ANDAR'),
(119, 'SALA LOUNGE'),
(120, 'SALA PRESIDENCIA'),
(121, 'AUDITORIO'),
(122, 'CPD'),
(123, 'SALA DE JOGOS'),
(124, 'SALA ADMINISTRATIVO/FINANCEIRO'),
(125, 'SALA MARKETING/DIRETORIA'),
(126, 'SALA DE DESCANSO'),
(127, 'SALA DE REUNIÃO TERREO'),
(128, 'SALA PCP'),
(129, 'SALA ENGENHARIA/PROJETOS'),
(130, 'SALA MANUTENÇÃO'),
(131, 'SALA IMPRESSORA TITANIUM'),
(132, 'SALA IMPRESSORAS FILAMENTO'),
(133, 'SALA QUALIDADE INSPEÇÃO'),
(134, 'SALA ESTOQUE CPMH'),
(135, 'SALA ESTOQUE BRASFIX'),
(136, 'SALA ESTOQUE OSTEOFIX'),
(137, 'SALA REUNIÃO 1º ANDAR'),
(138, 'SALA LOUNGE'),
(139, 'SALA PRESIDENCIA'),
(140, 'AUDITORIO'),
(141, 'CPD'),
(142, 'SALA DE JOGOS'),
(143, 'SALA ADMINISTRATIVO/FINANCEIRO'),
(144, 'SALA MARKETING/DIRETORIA'),
(145, 'SALA DE DESCANSO'),
(146, 'SALA DE REUNIÃO TERREO'),
(147, 'SALA PCP'),
(148, 'SALA ENGENHARIA/PROJETOS'),
(149, 'SALA MANUTENÇÃO'),
(150, 'SALA IMPRESSORA TITANIUM'),
(151, 'SALA IMPRESSORAS FILAMENTO'),
(152, 'SALA QUALIDADE INSPEÇÃO'),
(153, 'SALA ESTOQUE CPMH'),
(154, 'SALA ESTOQUE BRASFIX'),
(155, 'SALA ESTOQUE OSTEOFIX'),
(156, 'SALA REUNIÃO 1º ANDAR'),
(157, 'SALA LOUNGE'),
(158, 'SALA PRESIDENCIA'),
(159, 'AUDITORIO'),
(160, 'CPD'),
(161, 'SALA DE JOGOS'),
(162, 'SALA ADMINISTRATIVO/FINANCEIRO'),
(163, 'SALA MARKETING/DIRETORIA'),
(164, 'SALA DE DESCANSO'),
(165, 'SALA DE REUNIÃO TERREO'),
(166, 'SALA PCP'),
(167, 'SALA ENGENHARIA/PROJETOS'),
(168, 'SALA MANUTENÇÃO'),
(169, 'SALA IMPRESSORA TITANIUM'),
(170, 'SALA IMPRESSORAS FILAMENTO'),
(171, 'SALA QUALIDADE INSPEÇÃO'),
(172, 'SALA ESTOQUE CPMH'),
(173, 'SALA ESTOQUE BRASFIX'),
(174, 'SALA ESTOQUE OSTEOFIX'),
(175, 'SALA REUNIÃO 1º ANDAR'),
(176, 'SALA LOUNGE'),
(177, 'SALA PRESIDENCIA'),
(178, 'AUDITORIO'),
(179, 'CPD'),
(180, 'SALA DE JOGOS'),
(181, 'SALA ADMINISTRATIVO/FINANCEIRO'),
(182, 'SALA MARKETING/DIRETORIA'),
(183, 'SALA DE DESCANSO');

-- --------------------------------------------------------

--
-- Estrutura para tabela `setor_etapa`
--

CREATE TABLE `setor_etapa` (
  `id` int(11) NOT NULL,
  `idsetor` int(11) NOT NULL,
  `idetapa` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `setor_etapa`
--

INSERT INTO `setor_etapa` (`id`, `idsetor`, `idetapa`) VALUES
(7, 14, 13),
(6, 11, 35),
(5, 10, 52),
(4, 9, 23),
(3, 7, 3),
(2, 5, 31),
(1, 3, 88);

-- --------------------------------------------------------

--
-- Estrutura para tabela `setor_resp`
--

CREATE TABLE `setor_resp` (
  `idSetor` int(11) NOT NULL,
  `idResp` int(11) NOT NULL,
  `id` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `setor_resp`
--

INSERT INTO `setor_resp` (`idSetor`, `idResp`, `id`) VALUES
(4, 33, ''),
(14, 33, '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `statusetapa`
--

CREATE TABLE `statusetapa` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `tipo` varchar(255) DEFAULT NULL,
  `cor` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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

CREATE TABLE `statusos` (
  `stId` int(11) NOT NULL,
  `stNome` varchar(30) NOT NULL,
  `stPosicao` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `statusos`
--

INSERT INTO `statusos` (`stId`, `stNome`, `stPosicao`) VALUES
(5, 'CRIADO', 1),
(6, 'EM ANDAMENTO', 2),
(7, 'PAUSADO', 3),
(8, 'CONCLUÍDO', 4),
(9, 'REQUALIFICADO', 5);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tempo_corrido`
--

CREATE TABLE `tempo_corrido` (
  `id` int(11) NOT NULL,
  `idPedido` int(11) DEFAULT NULL,
  `idEtapa` int(11) DEFAULT NULL,
  `tempoCorrido` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tipocadastroexterno`
--

CREATE TABLE `tipocadastroexterno` (
  `tpcadexId` int(11) NOT NULL,
  `tpcadexCodCadastro` varchar(10) NOT NULL,
  `tpcadexNome` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tipocadastrointerno`
--

CREATE TABLE `tipocadastrointerno` (
  `tpcadinId` int(11) NOT NULL,
  `tpcadinCodCadastro` varchar(10) NOT NULL,
  `tpcadinNome` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
  `usersCel` varchar(20) DEFAULT NULL,
  `usersDepartamento` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`usersId`, `usersName`, `usersEmail`, `usersUid`, `usersPerm`, `usersPwd`, `usersAprov`, `usersUf`, `usersIdentificador`, `usersCel`, `usersDepartamento`) VALUES
(1, 'Vanessa Paz Araújo Paiva', 'vanessa.paiva@fixgrupo.com.br', 'vanessapaiva', '1ADM', '$2y$10$ZEfQEoYPH6mSHTtSDRgCIugAPTECJP3CMs0ejrsnnvYJ0OSRSXiAO', 'APROV', 'DF', '123456', '(61) 98365-2810', NULL),
(8, 'Sullivan Maciel Morbeck', 'sullivan.morbeck@fixhealth.com.br', 'smorbeckcpmh', '3COL', '$2y$10$TZYl13zhPPR0Hfg3fHFkw.BmNbeONomYJoX2gEDN3OVP93wa/4SZ2', 'APROV', 'DF', '', '(61) 98479-7922', 4),
(31, 'Aniely Caetano Alves', 'aniely.alves@fixhealth.com.br', 'anielyalves', '3COL', '$2y$10$ZiUC7mYvrAypbiBqmnJaEO3FpbviwYT/fxOiRSzV6FcWBnWvFoswW', 'APROV', 'DF', NULL, '8869', 2),
(6, 'Antonia Felix', 'antonia.santos@fixhealth.com.br', 'antonia', '1ADM', '$2y$10$RuNicEZcmcRwu./ySZjMkuzQoLJirGqCKkv8jwekeFxl3G6xyRJeu', 'APROV', 'DF', '', '(61) 30288-868', 4),
(24, 'rayro Rodrigues Soares', 'rayro.rodrigues@fixgrupo.com.br', 'rayrorodrigues', '3COL', '$2y$10$Quil8RSDl0aYUmbsr1bJpuzZbrZVE5BSCDr3ElBQ1F0UFocn/rOd.', 'APROV', 'DF', NULL, '8856', 4),
(25, 'jose carlos de Mendonça', 'jose.mendonca@fixhealth.com.br', 'josemendonca', '3COL', '$2y$10$6GeCOdfTaJ6BCSk1Jl98MeTScTeX28qj5fGyPA1ur2kdW8dc4vpqm', 'APROV', 'DF', NULL, '8878', 4),
(14, 'Joice Censi', 'joice.censi@fixhealth.com.br', 'joicecensi', '3COL', '$2y$10$KmZdlONmqP02C5WUNIZG.uCiS7oeoIpRBcTQs1X1GNH7B4uaVHqLi', 'APROV', 'DF', '', '8871', 4),
(15, 'Lucas Mariano de Sousa', 'lucas.sousa@fixhealth.com.br', 'lucassousa', '3COL', '$2y$10$cz0fVjQU7IeSxhEz7vHgheCmsXkgiFfHlK7zfFriCZIIKoNBhG0m2', 'APROV', 'DF', '', '8863', 4),
(16, 'Tânia guedes de oliveira ', 'tania.oliveira@fixhealth.com.br', 'taniaoliveira', '3COL', '$2y$10$1kDuk17KzSceGcL4E4eJueY3ikZS1fjNJre5XfZBnJhzQGAPTRgVi', 'APROV', 'DF', '', '8856', 4),
(18, 'gabriel Luna Freitas', 'gabriel.freitas@fixhealth.com.br', 'gabrielfreitas', '3COL', '$2y$10$0ZPqOk30Uyf.Y/Nhnqe/6ekAxsTlasyuDb9doHaj12tpd18hhcqF2', 'APROV', 'DF', '', '8863', 4),
(19, 'jeferson lucas dos anjos', 'jeferson.lucas@fixhealth.com.br', 'jefersonlucas', '3COL', '$2y$10$gmFP4e1Ta4iZbgxt5.WknuglhOl6F/eJVt0qYOt2yaQOqQmvyDENy', 'APROV', 'DF', '', '8870', 4),
(20, 'Thais Tivelli', 'thais.tivelli@fixhealth.com.br', 'thaistivelli', '2GES', '$2y$10$Ta2If9s77I9feYVRKI7wYOBPyHVnenXq8J32yquvmIZ14F6sF3olu', 'APROV', 'DF', '', '8883', 2),
(21, 'Hellen Iasmin Cardoso de oliveira', 'hellen.oliveira@fixhealth.com.br', 'hellenoliveira', '3COL', '$2y$10$35YxRT5YXw9bpbm55UeWZetaBUF9XVeFVfgzyTKZ0/3P1FK3y6nZG', 'APROV', 'DF', '', '8883', 2),
(22, 'Carollina Amanda Chaves Abitbol Castro', 'carollina.castro@fixhealth.com.br', 'carollinacastro', '2GES', '$2y$10$ZnffYxXdNtEHg3mhmu3Q6Oia/8Ri1isXde0gSLFOrn7Vj3WV.26OK', 'APROV', 'DF', '', '8883', 2),
(23, 'Vitor Hugo Pereira De Maman', 'vitor.maman@fixhealth.com.br', 'vitormaman', '3COL', '$2y$10$x1IXtzhRwNcZSezrZmSGKOYbIXEakyygz9o4Q5mZ.C1lVv6oeu2Re', 'APROV', 'DF', '', '(61) 3028-8887', 4),
(26, 'Lucas Ponte Portela', 'cpmh@cpmh.com.br', 'cpmh', '3COL', '$2y$10$oU0vIa.59aE.pIUeqL/W3OWmavtGtrpNr9aJ6JUlZlVB8EPw6OyYq', 'APROV', 'DF', NULL, '8870', 2),
(27, 'Paulo de jesus matos júnior', 'paulo.junior@fixhealth.com.br', 'paulojunior', '3COL', '$2y$10$YYdX9cGrPEfHt8cUFih1cuB94E..9Huy4Z1odp1l5UiX0u99.YcNi', 'APROV', 'DF', NULL, '8870', 2),
(28, 'Lucas Ponte Portela', 'lucas.portela@fixhealth.com.br', 'lucasportela', '3COL', '$2y$10$yiw1biE2qSUQvrjbS3kqU.jGfQDo1xjQS.tMgyXUbDhFAerGPFNYS', 'APROV', 'DF', NULL, '8870', 2),
(29, 'Samuel de oliveira silva ', 'samuel.silva@fixhealth.combr', 'samuelsilva', '3COL', '$2y$10$xV81N8YDzJiHsJDx8mVnw.6sI8edHAc5yCmlsxhdGp4qkPO57d0g6', 'APROV', 'DF', NULL, '0000', 3),
(30, 'Samuel de oliveira silva ', 'samuel@teste.com', 'samuel', '1ADM', '$2y$10$4sd9dqqgn2Teut7Pg5nbfeUco.jDVy/TxxCG2tsMdGsJqqo5BgAEC', 'APROV', 'DF', NULL, '0000', 3),
(32, 'heloiza bianca moreira', 'heloiza.bianca@fixhealth.com.br', 'heloizabianca', '3COL', '$2y$10$tEsgymJgAMvBYswbWsDvTu1yU1B4F4hNfXhWtXNEr9sS2W8uv.yqy', 'APROV', 'DF', NULL, '8883', 2),
(33, 'Bruna Coelho', 'bruna.coelho@fixhealth.com.br', 'brunacoelho', '1ADM', '$2y$10$qLd3YszV1kYjh913ZSzZVulVGC6UItc.RBvvKcekp13HDC9AV1lQa', 'APROV', 'DF', NULL, '0000', 4),
(34, 'Leonardo Moisés German diaz ', 'leonardo.diaz@fixhealth.com.br', 'leonardodiaz', '3COL', '$2y$10$41U1LPsOYyGi7P9JceMVU.nWWM2LCm0rX9V4zckBELsr.gvNCzZSS', 'APROV', 'DF', NULL, '8863', 4),
(35, 'bruna gomes', 'brunateste@teste.com', 'brunateste', '1ADM', '$2y$10$mOZ8jVctzw3DZHFybOPXGuv6yKnVYKSfn4PirXtRkKF8Z1XzkD1FK', 'APROV', 'DF', NULL, '0000', 4),
(36, 'João Victor Moncaio Avelar Muniz', 'joao.avelar@fixhealth.com.br', 'joaoavelar', '3COL', '$2y$10$AD8EvEj1nfeCwCHefLNzbu3RjbS8dw2kd1g7mPLGEGfJDAfziqOcS', 'APROV', 'DF', NULL, '61982548344', 4),
(37, 'teste', 'testeProducao@teste.com', 'testeproducao', '3COL', '$2y$10$6P.WQ1cm67yLUgcY3P1DN..ZYG1uOv5F/4O/EWpAFM7B.UBNueXkS', 'APROV', 'DF', NULL, '000', 4);

-- --------------------------------------------------------

--
-- Estrutura para tabela `user_setor`
--

CREATE TABLE `user_setor` (
  `id` int(11) NOT NULL,
  `idsetor` int(11) NOT NULL,
  `iduser` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
-- Índices de tabela `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `departamentos_form_inf_003`
--
ALTER TABLE `departamentos_form_inf_003`
  ADD PRIMARY KEY (`id_departamento`),
  ADD KEY `id_setor` (`id_setor`);

--
-- Índices de tabela `descricao_atividades`
--
ALTER TABLE `descricao_atividades`
  ADD PRIMARY KEY (`id`);

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
-- Índices de tabela `form_inf_003`
--
ALTER TABLE `form_inf_003`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user_criador` (`id_user_criador`);

--
-- Índices de tabela `frmstatus`
--
ALTER TABLE `frmstatus`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `frm_inf_004`
--
ALTER TABLE `frm_inf_004`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_setor` (`descricao_setor`(1000)),
  ADD KEY `fk_frmstatus` (`frmstatus_id`);

--
-- Índices de tabela `frm_inf_004_atividades`
--
ALTER TABLE `frm_inf_004_atividades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `frm_inf_004_id` (`frm_inf_004_id`),
  ADD KEY `descricao_atividades_id` (`descricao_atividades_id`);

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
-- Índices de tabela `maquina_manutencao_mensal`
--
ALTER TABLE `maquina_manutencao_mensal`
  ADD KEY `idMaquina` (`idMaquina`),
  ADD KEY `idManutencaoMensal` (`idManutencaoMensal`);

--
-- Índices de tabela `maquina_manutencao_semanal`
--
ALTER TABLE `maquina_manutencao_semanal`
  ADD KEY `idMaquina` (`idMaquina`),
  ADD KEY `idManutencaoSemanal` (`idManutencaoSemanal`);

--
-- Índices de tabela `mesesano`
--
ALTER TABLE `mesesano`
  ADD PRIMARY KEY (`mesId`);

--
-- Índices de tabela `omregistromanutencao`
--
ALTER TABLE `omregistromanutencao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idMaquina` (`idMaquina`),
  ADD KEY `idManutencaoSemanal` (`idManutencaoSemanal`),
  ADD KEY `idManutencaoMensal` (`idManutencaoMensal`);

--
-- Índices de tabela `om_maquina`
--
ALTER TABLE `om_maquina`
  ADD PRIMARY KEY (`idMaquina`);

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
-- Índices de tabela `setores_form_inf_003`
--
ALTER TABLE `setores_form_inf_003`
  ADD PRIMARY KEY (`id_setor`);

--
-- Índices de tabela `setor_arcondicionado`
--
ALTER TABLE `setor_arcondicionado`
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
-- AUTO_INCREMENT de tabela `departamento`
--
ALTER TABLE `departamento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `departamentos_form_inf_003`
--
ALTER TABLE `departamentos_form_inf_003`
  MODIFY `id_departamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de tabela `descricao_atividades`
--
ALTER TABLE `descricao_atividades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

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
  MODIFY `fileId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT de tabela `fluxo`
--
ALTER TABLE `fluxo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT de tabela `form_inf_003`
--
ALTER TABLE `form_inf_003`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de tabela `frmstatus`
--
ALTER TABLE `frmstatus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de tabela `frm_inf_004`
--
ALTER TABLE `frm_inf_004`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de tabela `frm_inf_004_atividades`
--
ALTER TABLE `frm_inf_004_atividades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de tabela `logatividades`
--
ALTER TABLE `logatividades`
  MODIFY `logId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT de tabela `log_atividades_producao`
--
ALTER TABLE `log_atividades_producao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de tabela `mesesano`
--
ALTER TABLE `mesesano`
  MODIFY `mesId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `omregistromanutencao`
--
ALTER TABLE `omregistromanutencao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `ordenmanutencao`
--
ALTER TABLE `ordenmanutencao`
  MODIFY `omId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `ordenservico`
--
ALTER TABLE `ordenservico`
  MODIFY `osId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT de tabela `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

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
-- AUTO_INCREMENT de tabela `realizacaoproducao`
--
ALTER TABLE `realizacaoproducao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT de tabela `setor`
--
ALTER TABLE `setor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `setores_form_inf_003`
--
ALTER TABLE `setores_form_inf_003`
  MODIFY `id_setor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de tabela `setor_arcondicionado`
--
ALTER TABLE `setor_arcondicionado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=184;

--
-- AUTO_INCREMENT de tabela `setor_etapa`
--
ALTER TABLE `setor_etapa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de tabela `statusetapa`
--
ALTER TABLE `statusetapa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `statusos`
--
ALTER TABLE `statusos`
  MODIFY `stId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `tempo_corrido`
--
ALTER TABLE `tempo_corrido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `usersId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

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
-- Restrições para tabelas `omregistromanutencao`
--
ALTER TABLE `omregistromanutencao`
  ADD CONSTRAINT `omregistromanutencao_ibfk_1` FOREIGN KEY (`idMaquina`) REFERENCES `om_maquina` (`idMaquina`),
  ADD CONSTRAINT `omregistromanutencao_ibfk_2` FOREIGN KEY (`idManutencaoSemanal`) REFERENCES `maquina_manutencao_semanal` (`idManutencaoSemanal`),
  ADD CONSTRAINT `omregistromanutencao_ibfk_3` FOREIGN KEY (`idManutencaoMensal`) REFERENCES `maquina_manutencao_mensal` (`idManutencaoMensal`);

--
-- Restrições para tabelas `produto`
--
ALTER TABLE `produto`
  ADD CONSTRAINT `produto_ibfk_1` FOREIGN KEY (`idfluxo`) REFERENCES `fluxo` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
