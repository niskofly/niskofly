# ************************************************************
# Sequel Pro SQL dump
# Версия 4499
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Адрес: 127.0.0.1 (MySQL 5.6.17)
# Схема: headin
# Время создания: 2015-12-29 10:52:02 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Дамп таблицы test_logic
# ------------------------------------------------------------

DROP TABLE IF EXISTS `test_logic`;

CREATE TABLE `test_logic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `test_id` int(11) NOT NULL,
  `ordering` int(11) NOT NULL DEFAULT '10',
  `points_min` int(11) DEFAULT NULL,
  `points_max` int(11) DEFAULT NULL,
  `result` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `test_logic` WRITE;
/*!40000 ALTER TABLE `test_logic` DISABLE KEYS */;

INSERT INTO `test_logic` (`id`, `test_id`, `ordering`, `points_min`, `points_max`, `result`)
VALUES
	(1,2,10,1,5,'<p>Ваш уровень: elementary</p>'),
	(2,2,20,6,10,'<p>Ваш уровень: pre-intermediate</p>'),
	(3,2,30,11,15,'<p>Ваш уровень: intermediate</p>'),
	(4,2,40,16,20,'<p>Ваш уровень: upper-intermediate</p>'),
	(5,2,50,21,25,'<p>Ваш уровень: advanced</p>');

/*!40000 ALTER TABLE `test_logic` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы tests
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tests`;

CREATE TABLE `tests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `ordering` int(11) NOT NULL DEFAULT '10',
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `tests` WRITE;
/*!40000 ALTER TABLE `tests` DISABLE KEYS */;

INSERT INTO `tests` (`id`, `language_id`, `name`, `active`, `ordering`, `description`)
VALUES
	(2,NULL,'English Test for Maxim',1,10,'<p>Предлагаем вам пройти этот тест</p>');

/*!40000 ALTER TABLE `tests` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы tests_answers
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tests_answers`;

CREATE TABLE `tests_answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `testquestion_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `points` int(11) NOT NULL DEFAULT '0',
  `active` tinyint(1) DEFAULT '1',
  `ordering` int(11) NOT NULL DEFAULT '10',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `tests_answers` WRITE;
/*!40000 ALTER TABLE `tests_answers` DISABLE KEYS */;

INSERT INTO `tests_answers` (`id`, `testquestion_id`, `name`, `points`, `active`, `ordering`)
VALUES
	(1,1,'Is',1,1,10),
	(2,1,'Am',0,1,20),
	(3,1,'Work',0,1,30),
	(4,1,'Works',0,1,40),
	(5,2,'In',0,1,10),
	(6,2,'From',1,1,20),
	(7,2,'Likes',0,1,30),
	(8,2,'Live',0,1,40),
	(9,3,'Is',1,1,10),
	(10,3,'Are',0,1,20),
	(11,3,'Does',0,1,30),
	(12,3,'Do',0,1,40),
	(13,4,'Much',0,1,10),
	(14,4,'Any',0,1,20),
	(15,4,'Some',1,1,30),
	(16,4,'A',0,1,40),
	(17,5,'Work',0,1,10),
	(18,5,'Is working',0,1,20),
	(19,5,'Manager',0,1,30),
	(20,5,'Works',1,1,40),
	(21,6,'Am getting up',0,1,10),
	(22,6,'Get up',1,1,20),
	(23,6,'Gets up',0,1,30),
	(24,6,'Getting up',0,1,40),
	(25,7,'Are listen',0,1,10),
	(26,7,'Are listening',1,1,20),
	(27,7,'Listening',0,1,30),
	(28,7,'Listen',0,1,40),
	(29,8,'Has',0,1,10),
	(30,8,'Use to have',0,1,20),
	(31,8,'Was having',0,1,30),
	(32,8,'Used to have',1,1,40),
	(33,9,'Are made',1,1,10),
	(34,9,'Made',0,1,20),
	(35,9,'Was made',0,1,30),
	(36,9,'Make',0,1,40),
	(37,10,'Was he do',0,1,10),
	(38,10,'Does he do',0,1,20),
	(39,10,'He did',0,1,30),
	(40,10,'Was he doing',1,1,40),
	(41,11,'Aunt',0,1,10),
	(42,11,'Aunt’s',1,1,20),
	(43,11,'Aunts',0,1,30),
	(44,11,'Aunts’',0,1,40),
	(45,12,'Cooking',1,1,10),
	(46,12,'To cook',0,1,20),
	(47,12,'Cook',0,1,30),
	(48,12,'I cook',0,1,40),
	(49,13,'Have known',1,1,10),
	(50,13,'Have been knowing',0,1,20),
	(51,13,'Knew',0,1,30),
	(52,13,'Know',0,1,40),
	(53,14,'Is finishing',0,1,10),
	(54,14,'Will finish',0,1,20),
	(55,14,'Finishes',1,1,30),
	(56,14,'Finish',0,1,40),
	(57,15,'Has checked',0,1,10),
	(58,15,'Had checked',1,1,20),
	(59,15,'Checked',0,1,30),
	(60,15,'Has been checked',0,1,40),
	(61,16,'So that',0,1,10),
	(62,16,'Unless',0,1,20),
	(63,16,'As long as',1,1,30),
	(64,16,'As if',0,1,40),
	(65,17,'Which live',0,1,10),
	(66,17,'Living',1,1,20),
	(67,17,'Who lives',0,1,30),
	(68,17,'Are living',0,1,40),
	(69,18,'Hearing',1,1,10),
	(70,18,'Hear',0,1,20),
	(71,18,'Be heard',0,1,30),
	(72,18,'Have heard',0,1,40),
	(73,19,'Would have',0,1,10),
	(74,19,'Will have',0,1,20),
	(75,19,'Will have had',0,1,30),
	(76,19,'Would have had',1,1,40),
	(77,20,'To be',0,1,10),
	(78,20,'He is',0,1,20),
	(79,20,'Being',1,1,30),
	(80,20,'Not to be',0,1,40),
	(81,21,'Late',1,1,10),
	(82,21,'Lately',0,1,20),
	(83,21,'Recently',0,1,30),
	(84,21,'Later',0,1,40),
	(85,22,'Thoroughly',0,1,10),
	(86,22,'Sincerely',0,1,20),
	(87,22,'Absolutely',0,1,30),
	(88,22,'Strongly',1,1,40),
	(89,23,'Chair',0,1,10),
	(90,23,'Moon',1,1,20),
	(91,23,'Feet',0,1,30),
	(92,23,'Back',0,1,40),
	(93,24,'Giving',1,1,10),
	(94,24,'Have given',0,1,20),
	(95,24,'Given',0,1,30),
	(96,24,'Have been giving',0,1,40),
	(97,25,'To discover',1,1,10),
	(98,25,'Discovering',0,1,20),
	(99,25,'Being discovered',0,1,30),
	(100,25,'To have discovered',0,1,40);

/*!40000 ALTER TABLE `tests_answers` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы tests_questions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tests_questions`;

CREATE TABLE `tests_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `test_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `ordering` int(11) NOT NULL DEFAULT '10',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `tests_questions` WRITE;
/*!40000 ALTER TABLE `tests_questions` DISABLE KEYS */;

INSERT INTO `tests_questions` (`id`, `test_id`, `name`, `active`, `ordering`)
VALUES
	(1,2,'My mother … a doctor.',1,10),
	(2,2,'Angela is … Mexico. She speaks Spanish.',1,20),
	(3,2,'Where … your wife from?',1,30),
	(4,2,'There are … people outside.',1,40),
	(5,2,'My brother … in a bank.',1,50),
	(6,2,'I usually … at seven o’clock.',1,60),
	(7,2,'They … to the teacher at the moment.',1,70),
	(8,2,'Sarah … blonde hair but now she is quite dark.',1,80),
	(9,2,'These cars … in Germany.',1,90),
	(10,2,'What …when you opened the door?',1,100),
	(11,2,'We stayed at my … place last summer.',1,110),
	(12,2,'I don’t mind … tonight if you do the dishes.',1,120),
	(13,2,'I … Miguel for years. He’s my neighbor.',1,130),
	(14,2,'Sandra is going to the cinema tonight if she … her homework.',1,140),
	(15,2,'Andy … his bike before he went on a cycling holiday.',1,150),
	(16,2,'It’s easy to install … you follow the instructions carefully.',1,160),
	(17,2,'People … next to the airport are fed up with the noise.',1,170),
	(18,2,'I look forward to … from you soon.',1,180),
	(19,2,'If you had come to the party, you … a great time.',1,190),
	(20,2,'… mean he never bought anyone a present.',1,200),
	(21,2,'I don’t know why she always arrives … .',1,210),
	(22,2,'I’ve been … dedicated to my training programme.',1,220),
	(23,2,'When they told me I had passed the test, I was over the ',1,230),
	(24,2,'… that this was her first attempt, I think that was a pretty decent performance.',1,240),
	(25,2,'He appears … the truth.',1,250);

/*!40000 ALTER TABLE `tests_questions` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
