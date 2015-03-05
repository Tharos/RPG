SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE TABLE `item` (
  `id` int(11) NOT NULL,
  `owner_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `place` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'inventory',
  PRIMARY KEY (`id`),
  KEY `IDX_1F1B251E7E3C61F9` (`owner_id`),
  CONSTRAINT `FK_1F1B251E7E3C61F9` FOREIGN KEY (`owner_id`) REFERENCES `player` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `player` (
  `id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `credits` int(11) NOT NULL DEFAULT '100',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `player_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B6BD307F99E6F5DF` (`player_id`),
  CONSTRAINT `FK_B6BD307F99E6F5DF` FOREIGN KEY (`player_id`) REFERENCES `player` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

