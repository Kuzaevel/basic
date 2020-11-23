-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.7.20-log - MySQL Community Server (GPL)
-- Операционная система:         Win32
-- HeidiSQL Версия:              10.1.0.5464
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Дамп структуры базы данных basic
CREATE DATABASE IF NOT EXISTS `basic` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `basic`;

-- Дамп структуры для таблица basic.author
CREATE TABLE IF NOT EXISTS `author` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fio` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы basic.author: ~9 rows (приблизительно)
/*!40000 ALTER TABLE `author` DISABLE KEYS */;
INSERT INTO `author` (`id`, `fio`) VALUES
	(1, 'Gambardella, Matthew'),
	(2, 'O\'Brien, Tim'),
	(3, 'Galos, Mike'),
	(4, 'Ralls, Kim'),
	(5, 'Corets, Eva'),
	(6, 'Knorr, Stefan'),
	(7, 'Randall, Cynthia'),
	(8, 'Thurman, Paula'),
	(9, 'Kress, Peter');
/*!40000 ALTER TABLE `author` ENABLE KEYS */;

-- Дамп структуры для таблица basic.book
CREATE TABLE IF NOT EXISTS `book` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_author` int(11) NOT NULL DEFAULT '1',
  `name` varchar(100) NOT NULL,
  `price` int(11) DEFAULT '2000',
  `id_genre` int(11) NOT NULL DEFAULT '3',
  PRIMARY KEY (`id`),
  KEY `fk_author` (`id_author`),
  KEY `fk_genre` (`id_genre`),
  CONSTRAINT `fk_author` FOREIGN KEY (`id_author`) REFERENCES `author` (`id`),
  CONSTRAINT `fk_genre` FOREIGN KEY (`id_genre`) REFERENCES `genre` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы basic.book: ~12 rows (приблизительно)
/*!40000 ALTER TABLE `book` DISABLE KEYS */;
INSERT INTO `book` (`id`, `id_author`, `name`, `price`, `id_genre`) VALUES
	(1, 1, 'XML Developer\'s Guide', 3506, 3),
	(2, 1, 'Microsoft .NET: The Programming Bible', 3201, 3),
	(3, 2, 'MSXML3: A Comprehensive Guide', 3201, 3),
	(4, 3, 'Visual Studio 7: A Comprehensive Guide', 3201, 3),
	(5, 4, 'Midnight Rain', 428, 4),
	(6, 5, 'Maeve Ascendant', 428, 6),
	(7, 5, 'Oberon\'s Legacy', 428, 4),
	(8, 5, 'The Sundered Grail', 428, 4),
	(9, 6, 'Creepy Crawlies', 356, 5),
	(10, 7, 'Lover Birds', 356, 6),
	(11, 8, 'Splish Splash', 356, 6),
	(12, 9, 'Paradox Lost', 356, 7);
/*!40000 ALTER TABLE `book` ENABLE KEYS */;

-- Дамп структуры для таблица basic.genre
CREATE TABLE IF NOT EXISTS `genre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы basic.genre: ~7 rows (приблизительно)
/*!40000 ALTER TABLE `genre` DISABLE KEYS */;
INSERT INTO `genre` (`id`, `name`) VALUES
	(1, 'Classic'),
	(2, 'Tail'),
	(3, 'Computer'),
	(4, 'Fantasy'),
	(5, 'Horror'),
	(6, 'Romance'),
	(7, 'Science Fiction');
/*!40000 ALTER TABLE `genre` ENABLE KEYS */;

-- Дамп структуры для таблица basic.token
CREATE TABLE IF NOT EXISTS `token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `token` varchar(50) DEFAULT NULL,
  `expired_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-token-user_id` (`user_id`),
  CONSTRAINT `idx-token-user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы basic.token: ~3 rows (приблизительно)
/*!40000 ALTER TABLE `token` DISABLE KEYS */;
INSERT INTO `token` (`id`, `user_id`, `token`, `expired_at`) VALUES
	(25, 1, '44H67gG2NAuF2Ng0IgnO_ofNJK4iEu13', 1605872540),
	(26, 2, 'ykMp9PKzPv39bDQL78UwsxzZunwVVgO5', 1605872551),
	(27, 1, 'ZI8qMNlQeCdmjraw6wVWE8WlL61QM2-V', 1605872864);
/*!40000 ALTER TABLE `token` ENABLE KEYS */;

-- Дамп структуры для таблица basic.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(512) NOT NULL,
  `email` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '10',
   `created_at` int(11) NULL DEFAULT NULL,
   `updated_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы basic.users: ~3 rows (приблизительно)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `password`, `email`, `description`, `status`) VALUES
	(1, 'admin', '$2y$13$BPSfIVibw60IAIQQSwXWRuAl.5oPMI33EjJIUqoBFxbMuFXf4iA4q', 'admin@base.ru', 'admin user', 10),
	(2, 'user', '$2y$13$BPSfIVibw60IAIQQSwXWRuAl.5oPMI33EjJIUqoBFxbMuFXf4iA4q', 'user@email.ru', NULL, 10),
	(3, 'user1', '$2y$13$BPSfIVibw60IAIQQSwXWRuAl.5oPMI33EjJIUqoBFxbMuFXf4iA4q', 'user1@email.ru', NULL, 10);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
