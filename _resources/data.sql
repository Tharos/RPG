SET foreign_key_checks = 0;

INSERT INTO `player` (`id`, `credits`) VALUES
	('A', 120),
	('B', 80),
	('C', 20);

INSERT INTO `item` (`id`, `owner_id`, `price`, `place`) VALUES
	(1, 'B', 20, 'inventory'),
	(2, 'A', 10, 'marketplace'),
	(3, 'A', 20, 'marketplace'),
	(4, 'B', 100, 'inventory'),
	(5, 'C', 40, 'marketplace');
