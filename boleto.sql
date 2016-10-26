-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Máquina: localhost
-- Data de Criação: 08-Abr-2016 às 19:53
-- Versão do servidor: 5.5.40-36.1
-- versão do PHP: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de Dados: `felip978_boleto`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `bancos`
--

CREATE TABLE IF NOT EXISTS `bancos` (
  `id_banco` int(30) NOT NULL AUTO_INCREMENT,
  `nome_banco` varchar(200) NOT NULL,
  `carteira` varchar(4) NOT NULL,
  `agencia` int(30) NOT NULL,
  `digito_ag` int(5) NOT NULL,
  `conta` int(10) NOT NULL,
  `digito_co` int(5) NOT NULL,
  `nosso_numero` int(20) NOT NULL,
  `tipo_cobranca` varchar(20) NOT NULL,
  `convenio` varchar(30) NOT NULL,
  `contrato` varchar(30) NOT NULL,
  `tipo_carteira` varchar(5) NOT NULL,
  `situacao` int(1) NOT NULL,
  `img` varchar(50) NOT NULL,
  `img2` varchar(200) NOT NULL,
  `link` varchar(60) NOT NULL,
  PRIMARY KEY (`id_banco`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `bancos`
--

INSERT INTO `bancos` (`id_banco`, `nome_banco`, `carteira`, `agencia`, `digito_ag`, `conta`, `digito_co`, `nosso_numero`, `tipo_cobranca`, `convenio`, `contrato`, `tipo_carteira`, `situacao`, `img`, `img2`, `link`) VALUES
(1, 'BANCO DO BRASIL', '19', 3307, 3, 105162, 8, 0, '2', '2535632', '', '', 0, 'bb.png', 'bb2.png', 'boleto_bb.php'),
(2, 'BRADESCO', '09', 2344, 2, 19423, 9, 0, '', '', '', '', 1, 'bradesco.png', 'bradesco2.png', 'boleto_bradesco.php'),
(3, 'CAIXA ECONOMICA', '02', 4068, 0, 242997, 0, 0, '', '242997', '', 'CR', 0, 'caixa.png', 'caixa2.png', 'boleto_cef_sigcb.php'),
(4, 'ITAU', '178', 6633, 0, 19236, 1, 0, '', '', '', '', 0, 'itau.png', 'itau2.png', 'boleto_itau.php');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente`
--

CREATE TABLE IF NOT EXISTS `cliente` (
  `id_cliente` int(30) NOT NULL AUTO_INCREMENT,
  `id_grupo` int(30) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `cpfcnpj` varchar(18) NOT NULL,
  `rg` varchar(20) NOT NULL,
  `inscricao` varchar(50) NOT NULL,
  `endereco` varchar(200) NOT NULL,
  `numero` int(10) NOT NULL,
  `complemento` varchar(200) NOT NULL,
  `bairro` varchar(200) NOT NULL,
  `cidade` varchar(200) NOT NULL,
  `uf` varchar(20) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `cep` varchar(15) NOT NULL,
  `email` varchar(250) NOT NULL,
  `obs` text NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `bloqueado` varchar(1) NOT NULL,
  `senha` varchar(10) NOT NULL,
  PRIMARY KEY (`id_cliente`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Extraindo dados da tabela `cliente`
--

INSERT INTO `cliente` (`id_cliente`, `id_grupo`, `nome`, `cpfcnpj`, `rg`, `inscricao`, `endereco`, `numero`, `complemento`, `bairro`, `cidade`, `uf`, `telefone`, `cep`, `email`, `obs`, `valor`, `bloqueado`, `senha`) VALUES
(1, 5, 'ELSON', '000.000.000-00', '', '', 'Avenida Marcílio Dias', 0, '', '', 'Resende', 'RJ', '24992372669', '27510080', 'contato@scriptcerto.com.br', '', '20.00', 'N', '123'),
(2, 5, 'PIETRO LORENZO HEITOR PEREIRA', '3.130.343/3324-45', '27.611.118-7', '', 'Avenida Marcílio Dias', 954, 'CASA', '', 'Resende', 'RJ', '24992372669', '27510080', 'contato@scriptcerto.com.br', '', '50.00', 'N', '123'),
(3, 0, 'Santiago Lacerda elias', '3.130.343/3324-45', '', '', 'Avenida Marcílio Dias', 0, '', '', 'Resende', 'RJ', '24992372669', '27510080', 'santelias@yahoo.com.br', '', '330.00', 'N', '123'),
(4, 0, 'Santiago Lacerda elias', '3.130.343/3324-45', '', '', 'Avenida Marcílio Dias', 0, '', '', 'Resende', 'RJ', '24992372669', '27510080', 'santelias@yahoo.com.br', '', '330.00', 'N', '123'),
(5, 5, 'WIILIAM', '', '', '', 'Avenida Marcílio Dias', 0, '', '', 'Resende', 'RJ', '24992372669', '27510080', 'contato@scriptcerto.com.br', '', '444.44', 'N', '123');

-- --------------------------------------------------------

--
-- Estrutura da tabela `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `cpf` varchar(50) NOT NULL,
  `endereco` varchar(250) NOT NULL,
  `cidade` varchar(200) NOT NULL,
  `uf` varchar(2) NOT NULL,
  `logo` varchar(200) NOT NULL,
  `receber` varchar(3) NOT NULL,
  `dias` varchar(2) NOT NULL,
  `multa_atrazo` varchar(10) NOT NULL,
  `juro` varchar(50) NOT NULL,
  `demo1` varchar(200) NOT NULL,
  `demo2` varchar(200) NOT NULL,
  `demo3` varchar(200) NOT NULL,
  `demo4` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `config`
--

INSERT INTO `config` (`id`, `nome`, `email`, `cpf`, `endereco`, `cidade`, `uf`, `logo`, `receber`, `dias`, `multa_atrazo`, `juro`, `demo1`, `demo2`, `demo3`, `demo4`) VALUES
(1, 'ScriptCerto', 'contato@scriptcerto.com.br', '02.326.5ee/0001-23', 'Rua PA-2', 'Anicuns', 'RJ', '1ab581a8f991acd.png', '10', '30', '2', '0.5', 'dados de instrucoes 1', 'dados de instrucoes 2', 'dados de instrucoes 3', 'dados de instrucoes 4');

-- --------------------------------------------------------

--
-- Estrutura da tabela `faturas`
--

CREATE TABLE IF NOT EXISTS `faturas` (
  `id_venda` bigint(60) NOT NULL AUTO_INCREMENT,
  `nosso_numero` bigint(60) NOT NULL,
  `modulo` varchar(50) NOT NULL,
  `codbanco` varchar(10) NOT NULL,
  `dbaixa` date NOT NULL,
  `banco_receb` varchar(20) NOT NULL,
  `dv_receb` int(2) NOT NULL,
  `banco` varchar(30) NOT NULL,
  `id_cliente` int(30) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `ref` varchar(250) NOT NULL,
  `data` date NOT NULL,
  `data_venci` date NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `valor_recebido` decimal(10,2) NOT NULL,
  `situacao` varchar(1) NOT NULL,
  `num_doc` varchar(30) NOT NULL,
  `condmail` int(1) NOT NULL,
  `emailcli` varchar(100) NOT NULL,
  `tipofatura` varchar(20) NOT NULL,
  PRIMARY KEY (`id_venda`),
  UNIQUE KEY `id_venda` (`id_venda`),
  UNIQUE KEY `num_doc` (`num_doc`),
  KEY `id_venda_2` (`id_venda`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Extraindo dados da tabela `faturas`
--

INSERT INTO `faturas` (`id_venda`, `nosso_numero`, `modulo`, `codbanco`, `dbaixa`, `banco_receb`, `dv_receb`, `banco`, `id_cliente`, `nome`, `ref`, `data`, `data_venci`, `valor`, `valor_recebido`, `situacao`, `num_doc`, `condmail`, `emailcli`, `tipofatura`) VALUES
(1, 0, '', '', '2016-04-08', '', 0, 'felip978_boleto', 1, 'ELSON', 'loja', '2016-04-08', '2016-04-09', '200.00', '200.00', 'B', '0', 0, 'elsoneal@gmail.com', 'AVULSO'),
(2, 0, '', '', '0000-00-00', '', 0, 'felip978_boleto', 3, 'Santiago Lacerda elias', 'TESTE', '2016-04-08', '2016-04-11', '340.00', '0.00', 'P', '343453', 0, 'santelias@yahoo.com.br', 'AVULSO'),
(3, 0, '', '', '0000-00-00', '', 0, 'felip978_boleto', 3, 'Santiago Lacerda elias', 'TESTE', '2016-04-08', '2016-04-11', '434.00', '0.00', 'P', '3434', 0, 'santelias@yahoo.com.br', 'AVULSO'),
(4, 0, '', '', '0000-00-00', '', 0, 'felip978_boleto', 4, 'Santiago Lacerda elias', 'TESTE', '2016-04-08', '2016-04-18', '440.00', '0.00', 'P', '333', 0, 'santelias@yahoo.com.br', 'AVULSO'),
(5, 54, '', '', '0000-00-00', '', 0, 'BRADESCO', 1, 'ELSON', 'TESTE', '2016-04-08', '2016-04-18', '33.00', '0.00', 'P', '45435', 0, 'contato@scriptcerto.com.br', 'AVULSO'),
(6, 0, '', '', '0000-00-00', '', 0, 'felip978_boleto', 1, 'ELSON', 'TESTE', '2016-04-08', '2016-04-12', '500.00', '0.00', 'P', '0454', 0, 'contato@scriptcerto.com.br', 'AVULSO'),
(7, 0, '', '', '0000-00-00', '', 0, 'felip978_boleto', 1, 'ELSON', 'TESTE', '2016-04-08', '2016-04-12', '330.00', '0.00', 'P', '343242', 0, 'contato@scriptcerto.com.br', 'AVULSO'),
(8, 0, '', '', '0000-00-00', '', 0, 'felip978_boleto', 5, 'WIILIAM', 'teste', '2016-04-08', '2016-04-18', '44.44', '0.00', 'P', '534', 0, 'contato@scriptcerto.com.br', 'AVULSO'),
(9, 0, '', '', '0000-00-00', '', 0, 'felip978_boleto', 5, 'WIILIAM', 'eee', '2016-04-08', '2016-04-11', '220.00', '0.00', 'P', 'eee', 0, 'contato@scriptcerto.com.br', 'AVULSO'),
(10, 0, '', '', '0000-00-00', '', 0, 'felip978_boleto', 5, 'WIILIAM', '333', '2016-04-08', '2016-04-11', '330.00', '0.00', 'P', '04545', 0, 'contato@scriptcerto.com.br', 'AVULSO');

-- --------------------------------------------------------

--
-- Estrutura da tabela `financeiro`
--

CREATE TABLE IF NOT EXISTS `financeiro` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `banco` varchar(50) NOT NULL,
  `ag_receb` varchar(200) NOT NULL,
  `dv_receb` varchar(200) NOT NULL,
  `nosso_numero` bigint(30) NOT NULL,
  `vencimento` varchar(50) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nosso_numero_2` (`nosso_numero`),
  KEY `nosso_numero` (`nosso_numero`),
  KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `flux_entrada`
--

CREATE TABLE IF NOT EXISTS `flux_entrada` (
  `id_entrada` int(50) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(2) CHARACTER SET utf8 NOT NULL,
  `data` date NOT NULL,
  `id_plano` int(50) NOT NULL,
  `descricao` varchar(200) CHARACTER SET utf8 NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_entrada`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=128 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `flux_fixas`
--

CREATE TABLE IF NOT EXISTS `flux_fixas` (
  `id_fixa` int(20) NOT NULL AUTO_INCREMENT,
  `descricao_fixa` varchar(200) NOT NULL,
  `dia_vencimento` varchar(2) NOT NULL,
  `valor_fixa` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_fixa`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `flux_planos`
--

CREATE TABLE IF NOT EXISTS `flux_planos` (
  `id_plano` int(50) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(200) NOT NULL,
  PRIMARY KEY (`id_plano`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `grupo`
--

CREATE TABLE IF NOT EXISTS `grupo` (
  `id_grupo` int(10) NOT NULL AUTO_INCREMENT,
  `nomegrupo` varchar(200) NOT NULL,
  `meses` int(3) NOT NULL,
  `dia` int(2) NOT NULL,
  `valor` varchar(20) NOT NULL,
  PRIMARY KEY (`id_grupo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Extraindo dados da tabela `grupo`
--

INSERT INTO `grupo` (`id_grupo`, `nomegrupo`, `meses`, `dia`, `valor`) VALUES
(1, 'AVULSO', 0, 0, ''),
(5, 'teste', 1, 10, '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `maile`
--

CREATE TABLE IF NOT EXISTS `maile` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `empresa` varchar(250) NOT NULL,
  `url` varchar(250) NOT NULL,
  `porta` varchar(20) NOT NULL,
  `endereco` varchar(250) NOT NULL,
  `limitemail` varchar(30) NOT NULL,
  `aviso` varchar(250) NOT NULL,
  `avisofataberto` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `senha` varchar(30) NOT NULL,
  `text1` longtext NOT NULL,
  `text2` longtext NOT NULL,
  `text3` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `maile`
--

INSERT INTO `maile` (`id`, `empresa`, `url`, `porta`, `endereco`, `limitemail`, `aviso`, `avisofataberto`, `email`, `senha`, `text1`, `text2`, `text3`) VALUES
(1, ' SCRIPT CERTO', 'MAIL.SCRIPTCERTO.COM.BR', '25', 'http://scriptcerto.com.br/geradorboleto/', '250', 'Aviso de Fatura gerada', 'Reaviso de cobrança', 'contato@scriptcerto.com.br', '021377887', '<h2>Nome empreda</h2>\r\n<hr />\r\n<p><strong>Ol&aacute; [NomedoCliente],</strong></p>\r\n<p><strong>Voc&ecirc; tem uma nova fatura.<br /></strong></p>\r\n<ul>\r\n<li><strong>Valor:</strong> [valor]</li>\r\n<li><strong>Vencimento:</strong> [vencimento]</li>\r\n<li><strong>N&ordm; da Fatura: </strong>[numeroFatura]</li>\r\n</ul>\r\n<p><strong>Refer&ecirc;nte a:</strong> [Descricaodafatura]</p>\r\n<p><strong>Para efetuar o pagamento, copie e cole o link abaixo em seu navegador"</strong></p>\r\n<p>[link]</p>\r\n<p>- Central de atendimento no e-mail: contato@playsistemas.com.br<br /> - 2&ordm; Via do Boleto, solicite no e-mail:&nbsp;contato@playsistemas.com.br</p>\r\n<hr />\r\n<p><strong>AVISO LEGAL</strong>: Esta mensagem &eacute; destinada exclusivamente para a(s) pessoa(s) a quem &eacute; dirigida, podendo conter informa&ccedil;&atilde;o confidencial e/ou legalmente privilegiada. Se voc&ecirc; n&atilde;o for destinat&aacute;rio desta mensagem, desde j&aacute; fica notificado de abster-se a divulgar, copiar, distribuir, examinar ou, de qualquer forma, utilizar a informa&ccedil;&atilde;o contida nesta mensagem, por ser ilegal. Caso voc&ecirc; tenha recebido esta mensagem por engano, pedimos que nos retorne este E-Mail, promovendo, desde logo, a elimina&ccedil;&atilde;o do seu conte&uacute;do em sua base de dados, registros ou sistema de controle. Fica desprovida de efic&aacute;cia e validade a mensagem que contiver v&iacute;nculos obrigacionais, expedida por quem n&atilde;o detenha poderes de representa&ccedil;&atilde;o.</p>', '<h2>Griff Sistemas</h2>\r\n<hr />\r\n<p><strong>Ol&aacute; [NomedoCliente],</strong></p>\r\n<p><strong>Ainda n&atilde;o identificamos o pagamento da fatura descrita a baixo:</strong></p>\r\n<ul>\r\n<li><strong>Valor:</strong> [valor]</li>\r\n<li><strong>Vencimento:</strong> [vencimento]</li>\r\n<li><strong>N&ordm; da Fatura: </strong>[numeroFatura]</li>\r\n</ul>\r\n<p><strong>Refer&ecirc;nte a:</strong> [Descricaodafatura]</p>\r\n<p><strong>Para efetuar o pagamento, clique no bot&atilde;o abaixo "Realizar Pagamento"</strong></p>\r\n<p>[link]</p>\r\n<p>- Central de atendimento no e-mail: <strong>suporte@griffsistemas.com.br</strong><br /> - 2&ordm; Via do Boleto, solicite no e-mail: <strong>financeiro@griffsistemas.com.br</strong></p>\r\n<hr />\r\n<p><strong>AVISO LEGAL</strong>: Esta mensagem &eacute; destinada exclusivamente para a(s) pessoa(s) a quem &eacute; dirigida, podendo conter informa&ccedil;&atilde;o confidencial e/ou legalmente privilegiada. Se voc&ecirc; n&atilde;o for destinat&aacute;rio desta mensagem, desde j&aacute; fica notificado de abster-se a divulgar, copiar, distribuir, examinar ou, de qualquer forma, utilizar a informa&ccedil;&atilde;o contida nesta mensagem, por ser ilegal. Caso voc&ecirc; tenha recebido esta mensagem por engano, pedimos que nos retorne este E-Mail, promovendo, desde logo, a elimina&ccedil;&atilde;o do seu conte&uacute;do em sua base de dados, registros ou sistema de controle. Fica desprovida de efic&aacute;cia e validade a mensagem que contiver v&iacute;nculos obrigacionais, expedida por quem n&atilde;o detenha poderes de representa&ccedil;&atilde;o.</p>', '<p>Seu cadastro foi efetuado com sucesso em nosso sistema.</p>\r\n\r\n<p>Segue seus dados de acesso: testesasdf</p>\r\n');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pag_extra`
--

CREATE TABLE IF NOT EXISTS `pag_extra` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user` varchar(100) DEFAULT NULL,
  `pass` varchar(200) DEFAULT NULL,
  `assinatura` varchar(200) DEFAULT NULL,
  `logo` varchar(200) DEFAULT NULL,
  `ativo` varchar(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `pag_extra`
--

INSERT INTO `pag_extra` (`id`, `user`, `pass`, `assinatura`, `logo`, `ativo`) VALUES
(1, 'elsoneal_api1.gmail.com', '932QL8EPEZK3BSDL', 'An5ns1Kso7MWUdW4ErQKJJJ4qi4-Aze.bSGE.ELVBCX3IEMrd3PIKf.Q', 'http://www.barreirao.com/logos/logopay.png', 'nao');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id_usuario` int(10) NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL,
  `login` varchar(20) NOT NULL,
  `senha` varchar(10) NOT NULL,
  `hash` varchar(250) NOT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nome`, `login`, `senha`, `hash`) VALUES
(1, 'Administrador', 'admin', 'admin', 'c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
