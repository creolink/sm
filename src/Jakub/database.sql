
CREATE USER 'smetrics'@'localhost' IDENTIFIED BY 'smetrics';
GRANT ALL ON smnewsportal.* TO 'smetrics'@'localhost';
FLUSH PRIVILEGES;

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT=0;

START TRANSACTION;

CREATE DATABASE IF NOT EXISTS `smnewsportal` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'unique autonumerated id, id of article',
  `topic_id` int(11) unsigned NOT NULL COMMENT 'id of topic === topic.id',
  `title` varchar(255) NOT NULL COMMENT 'title of article',
  `author` varchar(255) NOT NULL COMMENT 'author of article',
  `text` longtext NOT NULL COMMENT 'content of article',
  PRIMARY KEY (`id`),
  KEY `topic_id` (`topic_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='articles list' AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `topic`;
CREATE TABLE IF NOT EXISTS `topic` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'unique autonumbered id, id of topic',
  `title` varchar(255) NOT NULL COMMENT 'title of topic',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='list of topics' AUTO_INCREMENT=1 ;

ALTER TABLE `article` ADD CONSTRAINT `article_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

SET FOREIGN_KEY_CHECKS=1;

COMMIT;

#SET FOREIGN_KEY_CHECKS=0; TRUNCATE TABLE `topic`; TRUNCATE TABLE `article`; SET FOREIGN_KEY_CHECKS=1;