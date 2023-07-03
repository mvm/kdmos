-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.1.29-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win32
-- HeidiSQL Versión:             9.5.0.5295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Volcando estructura de base de datos para bdtsw
DROP DATABASE IF EXISTS `bdtsw`;
CREATE DATABASE IF NOT EXISTS `bdtsw` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `bdtsw`;

-- Volcando estructura para tabla bdtsw.options
DROP TABLE IF EXISTS `options`;
CREATE TABLE IF NOT EXISTS `options` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `survey_id` varchar(255) NOT NULL,
  `day` date NOT NULL,
  `start` time NOT NULL,
  `end` time NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tabla_id` (`survey_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla bdtsw.options: ~2 rows (aproximadamente)
DELETE FROM `options`;
/*!40000 ALTER TABLE `options` DISABLE KEYS */;
INSERT INTO `options` (`id`, `survey_id`, `day`, `start`, `end`) VALUES
	(1, 'd7ujehsuwnd98', '2018-10-31', '10:00:00', '12:00:00'),
	(2, 'd7ujehsuwnd98', '2018-10-27', '15:00:00', '18:00:00');
/*!40000 ALTER TABLE `options` ENABLE KEYS */;

-- Volcando estructura para tabla bdtsw.surveys
DROP TABLE IF EXISTS `surveys`;
CREATE TABLE IF NOT EXISTS `surveys` (
  `id` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(600) DEFAULT NULL,
  `creator` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_creator` (`creator`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla bdtsw.surveys: ~1 rows (aproximadamente)
DELETE FROM `surveys`;
/*!40000 ALTER TABLE `surveys` DISABLE KEYS */;
INSERT INTO `surveys` (`id`, `title`, `description`, `creator`) VALUES
	('d7ujehsuwnd98', 'Reunion Marronera', NULL, 1);
/*!40000 ALTER TABLE `surveys` ENABLE KEYS */;

-- Volcando estructura para tabla bdtsw.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla bdtsw.users: ~0 rows (aproximadamente)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `surname`, `email`, `pass`) VALUES
	(1, 'Alberto', 'Lopez', 'alberto@gmail.com', 'pruebatsw'),
	(2, 'Manolo', 'Eldelbombo', 'manolo@gmail.com', 'manolete');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Volcando estructura para tabla bdtsw.votes
DROP TABLE IF EXISTS `votes`;
CREATE TABLE IF NOT EXISTS `votes` (
  `user_id` int(10) unsigned NOT NULL,
  `option_id` int(10) unsigned NOT NULL,
  `vote` enum('Y','N','NS') DEFAULT 'NS',
  PRIMARY KEY (`user_id`,`option_id`),
  KEY `fk_option_id` (`option_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `options` ADD CONSTRAINT `fk_survey` FOREIGN KEY (`survey_id`) REFERENCES `surveys` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `votes` ADD CONSTRAINT `fk_option_id` FOREIGN KEY (`option_id`) REFERENCES `options` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `votes` ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `surveys` ADD CONSTRAINT `fk_creator` FOREIGN KEY (`creator`) REFERENCES `users` (`id`);

DELETE FROM `votes`;
/*!40000 ALTER TABLE `votes` DISABLE KEYS */;
INSERT INTO `votes` (`user_id`, `option_id`, `vote`) VALUES
	(1, 1, 'N'),
	(1, 2, 'Y'),
	(2, 1, 'NS'),
	(2, 2, 'Y');
/*!40000 ALTER TABLE `votes` ENABLE KEYS */;

grant all privileges on bdtsw.* to kdamosuser@localhost identified by "kdamospass";

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
