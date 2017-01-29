-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.14 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table gigablaster.demand
CREATE TABLE IF NOT EXISTS `demand` (
  `entity_id` int(10) unsigned NOT NULL,
  `ressource_id` int(10) unsigned NOT NULL,
  `percent` float unsigned NOT NULL,
  `sold` int(10) unsigned NOT NULL DEFAULT '0',
  `price_modifier` float unsigned NOT NULL DEFAULT '0' COMMENT 'calc by proc demand_update',
  PRIMARY KEY (`entity_id`,`ressource_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gigablaster.entity
CREATE TABLE IF NOT EXISTS `entity` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `type_id` int(10) unsigned NOT NULL DEFAULT '1',
  `label` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_entity_entitytype` (`type_id`),
  KEY `FK_entity_user` (`user_id`),
  CONSTRAINT `FK_entity_entitytype` FOREIGN KEY (`type_id`) REFERENCES `entitytype` (`id`),
  CONSTRAINT `FK_entity_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gigablaster.entitytype
CREATE TABLE IF NOT EXISTS `entitytype` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(250) NOT NULL,
  `value_base` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gigablaster.entitytype_prodtype_assoc
CREATE TABLE IF NOT EXISTS `entitytype_prodtype_assoc` (
  `entitytype_id` int(11) unsigned NOT NULL,
  `prodtype_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`entitytype_id`,`prodtype_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gigablaster.entity_location_assoc
CREATE TABLE IF NOT EXISTS `entity_location_assoc` (
  `entity_id` int(10) unsigned NOT NULL,
  `location_x` int(10) unsigned NOT NULL,
  `location_y` int(10) unsigned NOT NULL,
  PRIMARY KEY (`entity_id`,`location_x`,`location_y`),
  CONSTRAINT `FK_entity_location_assoc_entity` FOREIGN KEY (`entity_id`) REFERENCES `entity` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gigablaster.gamestate
CREATE TABLE IF NOT EXISTS `gamestate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `time_origin` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `turn` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gigablaster.player
CREATE TABLE IF NOT EXISTS `player` (
  `user_id` int(10) unsigned NOT NULL,
  `name` varchar(250) NOT NULL,
  `credit` int(10) unsigned NOT NULL DEFAULT '0',
  `income` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`),
  CONSTRAINT `FK_player_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gigablaster.population
CREATE TABLE IF NOT EXISTS `population` (
  `entity_id` int(10) unsigned NOT NULL,
  `quantity` int(10) unsigned NOT NULL DEFAULT '10',
  `growth` float unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`entity_id`),
  CONSTRAINT `FK_population_entity` FOREIGN KEY (`entity_id`) REFERENCES `entity` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gigablaster.prod
CREATE TABLE IF NOT EXISTS `prod` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entity_id` int(10) unsigned NOT NULL,
  `prodtype_id` int(10) unsigned NOT NULL,
  `location_x` int(11) NOT NULL,
  `location_y` int(11) NOT NULL,
  `percent_max` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_prod_prodtype` (`prodtype_id`),
  KEY `FK_prod_entity` (`entity_id`),
  CONSTRAINT `FK_prod_entity` FOREIGN KEY (`entity_id`) REFERENCES `entity` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_prod_prodtype` FOREIGN KEY (`prodtype_id`) REFERENCES `prodtype` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='entity_prod_assoc';

-- Data exporting was unselected.


-- Dumping structure for table gigablaster.prodinput
CREATE TABLE IF NOT EXISTS `prodinput` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `prod_id` int(10) unsigned NOT NULL,
  `prodinputtype_id` int(10) unsigned NOT NULL,
  `location_x` int(10) unsigned NOT NULL,
  `location_y` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_prodinput_prod` (`prod_id`),
  KEY `FK_prodinput_prodinputtype` (`prodinputtype_id`),
  CONSTRAINT `FK_prodinput_prod` FOREIGN KEY (`prod_id`) REFERENCES `prod` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_prodinput_prodinputtype` FOREIGN KEY (`prodinputtype_id`) REFERENCES `prodinputtype` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='entprodassoc_prodinput_assoc';

-- Data exporting was unselected.


-- Dumping structure for table gigablaster.prodinputtype
CREATE TABLE IF NOT EXISTS `prodinputtype` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ressource_id` int(10) unsigned NOT NULL DEFAULT '0',
  `quantity` int(10) unsigned NOT NULL DEFAULT '0',
  `comment` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gigablaster.prodtype
CREATE TABLE IF NOT EXISTS `prodtype` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ressource_id` int(10) unsigned NOT NULL DEFAULT '0',
  `quantity` int(10) NOT NULL DEFAULT '0',
  `comment` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gigablaster.prodtype_prodinputtype_assoc
CREATE TABLE IF NOT EXISTS `prodtype_prodinputtype_assoc` (
  `prodtype_id` int(11) unsigned NOT NULL,
  `prodinputtype_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`prodtype_id`,`prodinputtype_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gigablaster.rescategory
CREATE TABLE IF NOT EXISTS `rescategory` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(250) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `label` (`label`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gigablaster.ressource
CREATE TABLE IF NOT EXISTS `ressource` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(250) NOT NULL DEFAULT '0',
  `baseprice` int(10) unsigned NOT NULL DEFAULT '1',
  `natural` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'bool',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gigablaster.ressource_rescategory
CREATE TABLE IF NOT EXISTS `ressource_rescategory` (
  `rescat_id` int(10) unsigned NOT NULL,
  `res_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`rescat_id`,`res_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gigablaster.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `player_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_shadow` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='toto@gmail.com\r\npass';

-- Data exporting was unselected.


-- Dumping structure for view gigablaster.overcrowd
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `overcrowd` (
	`ressource_id` INT(10) UNSIGNED NOT NULL,
	`location_x` INT(10) UNSIGNED NOT NULL,
	`location_y` INT(10) UNSIGNED NOT NULL,
	`quantity` DECIMAL(32,0) NULL
) ENGINE=MyISAM;


-- Dumping structure for view gigablaster.prodinput_sum
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `prodinput_sum` (
	`location_x` INT(10) UNSIGNED NOT NULL,
	`location_y` INT(10) UNSIGNED NOT NULL,
	`ressource_id` INT(10) UNSIGNED NOT NULL,
	`quantity` DECIMAL(32,0) NULL
) ENGINE=MyISAM;


-- Dumping structure for view gigablaster.prod_sum
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `prod_sum` (
	`location_x` INT(11) NOT NULL,
	`location_y` INT(11) NOT NULL,
	`ressource_id` INT(10) UNSIGNED NOT NULL,
	`quantity` DOUBLE(17,0) NULL
) ENGINE=MyISAM;


-- Dumping structure for view gigablaster.sold
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `sold` (
	`seller_id` INT(10) UNSIGNED NOT NULL,
	`ressource_id` INT(10) UNSIGNED NOT NULL,
	`quantity` INT(10) UNSIGNED NOT NULL,
	`buyer_id` INT(10) UNSIGNED NOT NULL
) ENGINE=MyISAM;


-- Dumping structure for procedure gigablaster.city_spawn
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `city_spawn`()
BEGIN

		DECLARE bDone INT;

		DECLARE entity_id INT;
		DECLARE location_x INT;    -- or approriate type
		DECLARE location_y INT;
		
		DECLARE curs CURSOR FOR
			/* Get all spawn point (location with a production but no city)*/
			SELECT 
				prod.location_x, 
				prod.location_y
			FROM prod
			
			LEFT JOIN (
				SELECT 
					entity.id,
					entity_location_assoc.location_x,
					entity_location_assoc.location_y
				FROM entity
				JOIN entity_location_assoc ON entity_location_assoc.entity_id = entity.id
				WHERE entity.type_id = 1 #City
			) AS city_location 
				ON city_location.location_x = prod.location_x
				AND city_location.location_y = prod.location_y
			WHERE city_location.id IS NULL
			GROUP BY prod.location_x, prod.location_y;
		DECLARE CONTINUE HANDLER FOR NOT FOUND SET bDone = 1;

		OPEN curs;

		SET bDone = 0;
		loopy: LOOP
			
			FETCH curs INTO location_x, location_y;
			IF bDone = 1 THEN LEAVE loopy; END IF;
			
			START TRANSACTION;
				INSERT INTO entity(type_id)
				VALUES (1);
				
				SET entity_id = LAST_INSERT_ID();
				INSERT INTO entity_location_assoc(entity_id,location_x,location_y)
				VALUES (entity_id,location_x,location_y);
				
				INSERT INTO population(entity_id)
				VALUES (entity_id);
				
				INSERT INTO demand(entity_id,ressource_id,percent)
				VALUES (entity_id,4,1.0),
					(entity_id,14,1.0),
					(entity_id,13,1.0);
			COMMIT;
		
		END LOOP loopy;

		CLOSE curs;
END//
DELIMITER ;


-- Dumping structure for procedure gigablaster.cleanup
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `cleanup`()
BEGIN
	DELETE prod
	FROM prod 
	LEFT JOIN entity ON entity.id = prod.entity_id
	WHERE entity.id IS NULL;
	
	DELETE prodinput
	FROM prodinput 
	LEFT JOIN prod ON prod.id = prodinput.prod_id
	WHERE prod.id IS NULL;
END//
DELIMITER ;


-- Dumping structure for procedure gigablaster.credit_update
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `credit_update`()
BEGIN
	UPDATE player
	SET player.credit = player.credit + player.income;
END//
DELIMITER ;


-- Dumping structure for procedure gigablaster.demand_update
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `demand_update`()
BEGIN
	UPDATE demand
	JOIN
	(
		SELECT 
			demand.entity_id,
			demand.ressource_id,
			SUM(sold.quantity) AS sold_new,
			((population.quantity * demand.percent) /
			GREATEST(1,SUM(sold.quantity))) AS price_modifier_new
		FROM sold
		JOIN demand 
			ON demand.entity_id = sold.buyer_id 
			AND demand.ressource_id = sold.ressource_id
		JOIN population ON population.entity_id = sold.buyer_id
		JOIN ressource ON ressource.id = sold.ressource_id
		
		GROUP BY buyer_id, ressource.id
	) as t ON t.entity_id = demand.entity_id AND t.ressource_id = demand.ressource_id
	SET demand.sold = t.sold_new, demand.price_modifier = t.price_modifier_new;
	
	UPDATE demand
	JOIN
	(
		SELECT 
			demand.entity_id,
			demand.ressource_id,
			0 AS sold_new,
			5 AS price_modifier_new
		FROM demand
		LEFT JOIN sold 
			ON demand.entity_id = sold.buyer_id 
			AND demand.ressource_id = sold.ressource_id
			AND demand.entity_id = NULL
	) as t ON t.entity_id = demand.entity_id AND t.ressource_id = demand.ressource_id
	SET demand.sold = t.sold_new, demand.price_modifier = t.price_modifier_new;
END//
DELIMITER ;


-- Dumping structure for procedure gigablaster.income_update
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `income_update`()
BEGIN
	UPDATE player
	JOIN (
		SELECT 
			entity.user_id,
			SUM(demand.price_modifier * ressource.baseprice * sold.quantity ) AS income
		FROM sold
		JOIN entity on entity.id = sold.seller_id
		JOIN demand ON demand.entity_id = sold.buyer_id
		JOIN ressource ON ressource.id = sold.ressource_id
		
		GROUP BY entity.user_id
	) AS t ON t.user_id = player.user_id
	SET player.income = t.income;
END//
DELIMITER ;


-- Dumping structure for procedure gigablaster.prod_percent_update
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `prod_percent_update`()
BEGIN
/* Update prod with no prod input required to 1.0 */
	UPDATE prod 
	LEFT JOIN prodinput ON prodinput.prod_id = prod.id
	SET prod.percent_max=1
	WHERE prodinput.prod_id IS NULL;

/* Update prod percent depending on the availability of prodinput */
	UPDATE prod 
	
	JOIN (
		SELECT 
			prod.entity_id,
			prod.id as prod_id,
			prod.location_x,
			prod.location_y,
			LEAST(
				1.0,
				MIN(
					( 
						( prodinputtype.quantity / prodinput_sum.quantity ) * IFNULL(prod_sum.quantity, 0) 
					) / prodinputtype.quantity
				)
			) as percent
		FROM prod
		JOIN prodtype ON prodtype.id = prod.prodtype_id
		JOIN prodinput ON prodinput.prod_id = prod.id
		JOIN prodinputtype ON prodinputtype.id = prodinput.prodinputtype_id
		LEFT JOIN prod_sum 
			ON prod_sum.location_x = prod.location_x
			AND prod_sum.location_y = prod.location_y
			AND prod_sum.ressource_id = prodinputtype.ressource_id
		LEFT JOIN prodinput_sum
			ON prodinput_sum.location_x = prod.location_x
			AND prodinput_sum.location_y = prod.location_y
			AND prodinput_sum.ressource_id = prodinputtype.ressource_id
		JOIN ressource 
			ON ressource.id = prodinputtype.ressource_id
			AND ressource.`natural` = 0
		
		GROUP BY prod.id
	) AS tprod_percent ON prod.id = tprod_percent.prod_id
	SET prod.percent_max = tprod_percent.percent;
	
	
END//
DELIMITER ;


-- Dumping structure for procedure gigablaster.reset
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `reset`()
BEGIN
	TRUNCATE entity;
	TRUNCATE entity_location_assoc;
	TRUNCATE prod;
	TRUNCATE population;
	TRUNCATE prodinput;
	TRUNCATE location;
	TRUNCATE demand;
END//
DELIMITER ;


-- Dumping structure for procedure gigablaster.test
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `test`()
BEGIN
	INSERT INTO entity(type_id)
	SELECT 3;
	SELECT LAST_INSERT_ID();
END//
DELIMITER ;


-- Dumping structure for procedure gigablaster.turn
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `turn`()
BEGIN
	CALL `prod_percent_update`();
	
	CALL `city_spawn`();
	
	CALL `demand_update`();
	
	CALL `income_update`();
	CALL `credit_update`();
END//
DELIMITER ;


-- Dumping structure for view gigablaster.overcrowd
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `overcrowd`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `overcrowd` AS select `prodinputtype`.`ressource_id` AS `ressource_id`,`prodinput`.`location_x` AS `location_x`,`prodinput`.`location_y` AS `location_y`,sum(`prodinputtype`.`quantity`) AS `quantity` from ((`prodinput` join `prodinputtype` on((`prodinputtype`.`id` = `prodinput`.`prodinputtype_id`))) join `ressource` on(((`ressource`.`id` = `prodinputtype`.`ressource_id`) and (`ressource`.`natural` = 1)))) group by `prodinputtype`.`ressource_id`,`prodinput`.`location_x`,`prodinput`.`location_y`;


-- Dumping structure for view gigablaster.prodinput_sum
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `prodinput_sum`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `prodinput_sum` AS select `prodinput`.`location_x` AS `location_x`,`prodinput`.`location_y` AS `location_y`,`prodinputtype`.`ressource_id` AS `ressource_id`,sum(`prodinputtype`.`quantity`) AS `quantity` from (`prodinput` join `prodinputtype` on((`prodinputtype`.`id` = `prodinput`.`prodinputtype_id`))) group by `prodinput`.`location_x`,`prodinput`.`location_y`,`prodinputtype`.`ressource_id`;


-- Dumping structure for view gigablaster.prod_sum
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `prod_sum`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `prod_sum` AS select `prod`.`location_x` AS `location_x`,`prod`.`location_y` AS `location_y`,`prodtype`.`ressource_id` AS `ressource_id`,floor(sum((`prodtype`.`quantity` * `prod`.`percent_max`))) AS `quantity` from (`prod` join `prodtype` on((`prodtype`.`id` = `prod`.`prodtype_id`))) group by `prod`.`location_x`,`prod`.`location_y`,`prodtype`.`ressource_id`;


-- Dumping structure for view gigablaster.sold
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `sold`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `sold` AS select `seller`.`id` AS `seller_id`,`prodinputtype`.`ressource_id` AS `ressource_id`,`prodinputtype`.`quantity` AS `quantity`,`buyer`.`id` AS `buyer_id` from (((((((`player` join `entity` `seller` on((`seller`.`user_id` = `player`.`user_id`))) join `prod` on((`prod`.`entity_id` = `seller`.`id`))) join `prodtype` on(((`prodtype`.`id` = `prod`.`prodtype_id`) and (`prodtype`.`ressource_id` = 1)))) join `prodinput` on((`prodinput`.`prod_id` = `prod`.`id`))) join `prodinputtype` on((`prodinputtype`.`id` = `prodinput`.`prodinputtype_id`))) join `entity` `buyer` on((`buyer`.`type_id` = 1))) join `entity_location_assoc` on(((`entity_location_assoc`.`entity_id` = `buyer`.`id`) and (`entity_location_assoc`.`location_x` = `prod`.`location_x`) and (`entity_location_assoc`.`location_y` = `prod`.`location_y`))));
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
