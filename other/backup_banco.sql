-- --------------------------------------------------------
-- Servidor:                     localhost
-- Versão do servidor:           5.7.24 - MySQL Community Server (GPL)
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Copiando estrutura do banco de dados para db_cppd
DROP DATABASE IF EXISTS `db_cppd`;
CREATE DATABASE IF NOT EXISTS `db_cppd` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `db_cppd`;

-- Copiando estrutura para tabela db_cppd.avaliacao
DROP TABLE IF EXISTS `avaliacao`;
CREATE TABLE IF NOT EXISTS `avaliacao` (
  `idavaliacao` int(11) NOT NULL,
  `numero_processo` varchar(45) DEFAULT NULL,
  `data_abertura` date DEFAULT NULL,
  `data_homologacao` date DEFAULT NULL,
  `avaliacao_discente` varchar(245) DEFAULT NULL,
  `avaliacao_docente` varchar(245) DEFAULT NULL,
  `avalicao_chefia` varchar(245) DEFAULT NULL,
  `carreira_idcarreira` int(11) NOT NULL,
  PRIMARY KEY (`idavaliacao`),
  KEY `fk_avaliacao_carreira1_idx` (`carreira_idcarreira`),
  CONSTRAINT `fk_avaliacao_carreira1` FOREIGN KEY (`carreira_idcarreira`) REFERENCES `carreira` (`idcarreira`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela db_cppd.avaliacao: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `avaliacao` DISABLE KEYS */;
/*!40000 ALTER TABLE `avaliacao` ENABLE KEYS */;

-- Copiando estrutura para tabela db_cppd.carreira
DROP TABLE IF EXISTS `carreira`;
CREATE TABLE IF NOT EXISTS `carreira` (
  `idcarreira` int(11) NOT NULL,
  `classe_idclasse` int(11) NOT NULL,
  `nivel_idnivel` int(11) NOT NULL,
  `servidor_idservidor` int(11) NOT NULL,
  `data_aquisicao` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idcarreira`),
  KEY `fk_carreira_classe1_idx` (`classe_idclasse`),
  KEY `fk_carreira_nivel1_idx` (`nivel_idnivel`),
  KEY `fk_carreira_servidor1_idx` (`servidor_idservidor`),
  CONSTRAINT `fk_carreira_classe1` FOREIGN KEY (`classe_idclasse`) REFERENCES `classe` (`idclasse`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_carreira_nivel1` FOREIGN KEY (`nivel_idnivel`) REFERENCES `nivel` (`idnivel`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_carreira_servidor1` FOREIGN KEY (`servidor_idservidor`) REFERENCES `servidor` (`idservidor`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela db_cppd.carreira: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `carreira` DISABLE KEYS */;
/*!40000 ALTER TABLE `carreira` ENABLE KEYS */;

-- Copiando estrutura para tabela db_cppd.chefe
DROP TABLE IF EXISTS `chefe`;
CREATE TABLE IF NOT EXISTS `chefe` (
  `servidor_idservidor` int(11) NOT NULL,
  `servidor_chefe` int(11) NOT NULL,
  PRIMARY KEY (`servidor_idservidor`,`servidor_chefe`),
  KEY `fk_servidor_has_servidor_servidor2_idx` (`servidor_chefe`),
  KEY `fk_servidor_has_servidor_servidor1_idx` (`servidor_idservidor`),
  CONSTRAINT `fk_servidor_has_servidor_servidor1` FOREIGN KEY (`servidor_idservidor`) REFERENCES `servidor` (`idservidor`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_servidor_has_servidor_servidor2` FOREIGN KEY (`servidor_chefe`) REFERENCES `servidor` (`idservidor`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela db_cppd.chefe: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `chefe` DISABLE KEYS */;
/*!40000 ALTER TABLE `chefe` ENABLE KEYS */;

-- Copiando estrutura para tabela db_cppd.classe
DROP TABLE IF EXISTS `classe`;
CREATE TABLE IF NOT EXISTS `classe` (
  `idclasse` int(11) NOT NULL,
  `classe` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idclasse`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela db_cppd.classe: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `classe` DISABLE KEYS */;
/*!40000 ALTER TABLE `classe` ENABLE KEYS */;

-- Copiando estrutura para tabela db_cppd.nivel
DROP TABLE IF EXISTS `nivel`;
CREATE TABLE IF NOT EXISTS `nivel` (
  `idnivel` int(11) NOT NULL,
  `nivel` varchar(45) DEFAULT NULL,
  `classe_idclasse` int(11) NOT NULL,
  PRIMARY KEY (`idnivel`),
  KEY `fk_nivel_classe_idx` (`classe_idclasse`),
  CONSTRAINT `fk_nivel_classe` FOREIGN KEY (`classe_idclasse`) REFERENCES `classe` (`idclasse`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela db_cppd.nivel: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `nivel` DISABLE KEYS */;
/*!40000 ALTER TABLE `nivel` ENABLE KEYS */;

-- Copiando estrutura para tabela db_cppd.servidor
DROP TABLE IF EXISTS `servidor`;
CREATE TABLE IF NOT EXISTS `servidor` (
  `idservidor` int(11) NOT NULL AUTO_INCREMENT,
  `siape` varchar(45) DEFAULT NULL,
  `nome` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `data_ingresso` date DEFAULT NULL,
  `situacao_idsituacao` int(11) NOT NULL,
  PRIMARY KEY (`idservidor`),
  KEY `fk_servidor_situacao1_idx` (`situacao_idsituacao`),
  CONSTRAINT `fk_servidor_situacao1` FOREIGN KEY (`situacao_idsituacao`) REFERENCES `situacao` (`idsituacao`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela db_cppd.servidor: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `servidor` DISABLE KEYS */;
REPLACE INTO `servidor` (`idservidor`, `siape`, `nome`, `email`, `data_ingresso`, `situacao_idsituacao`) VALUES
	(2, '423423', 'Ivan Paulino Pereira', 'ivan.pereira@ifsuldeminas.edu.br', '2021-04-06', 1);
/*!40000 ALTER TABLE `servidor` ENABLE KEYS */;

-- Copiando estrutura para tabela db_cppd.servidor_titulacao
DROP TABLE IF EXISTS `servidor_titulacao`;
CREATE TABLE IF NOT EXISTS `servidor_titulacao` (
  `servidor_idservidor` int(11) NOT NULL,
  `titulacao_idtitulacao` int(11) NOT NULL,
  `data` date DEFAULT NULL,
  PRIMARY KEY (`servidor_idservidor`,`titulacao_idtitulacao`),
  KEY `fk_servidor_has_titulacao_titulacao1_idx` (`titulacao_idtitulacao`),
  KEY `fk_servidor_has_titulacao_servidor1_idx` (`servidor_idservidor`),
  CONSTRAINT `fk_servidor_has_titulacao_servidor1` FOREIGN KEY (`servidor_idservidor`) REFERENCES `servidor` (`idservidor`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_servidor_has_titulacao_titulacao1` FOREIGN KEY (`titulacao_idtitulacao`) REFERENCES `titulacao` (`idtitulacao`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela db_cppd.servidor_titulacao: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `servidor_titulacao` DISABLE KEYS */;
/*!40000 ALTER TABLE `servidor_titulacao` ENABLE KEYS */;

-- Copiando estrutura para tabela db_cppd.situacao
DROP TABLE IF EXISTS `situacao`;
CREATE TABLE IF NOT EXISTS `situacao` (
  `idsituacao` int(11) NOT NULL AUTO_INCREMENT,
  `situacao` varchar(45) DEFAULT NULL,
  `especificacao` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idsituacao`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela db_cppd.situacao: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `situacao` DISABLE KEYS */;
REPLACE INTO `situacao` (`idsituacao`, `situacao`, `especificacao`) VALUES
	(1, 'Grupo I', 'Professor exclusivamente em atividades de ensino, pesquisa e extensão.'),
	(2, 'Grupo II', 'Docentes em exercício exclusivo de cargo/função.');
/*!40000 ALTER TABLE `situacao` ENABLE KEYS */;

-- Copiando estrutura para tabela db_cppd.titulacao
DROP TABLE IF EXISTS `titulacao`;
CREATE TABLE IF NOT EXISTS `titulacao` (
  `idtitulacao` int(11) NOT NULL,
  `formacao` varchar(45) DEFAULT NULL,
  `titulacao` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idtitulacao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela db_cppd.titulacao: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `titulacao` DISABLE KEYS */;
/*!40000 ALTER TABLE `titulacao` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
