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

-- Dumping structure for table gigablaster.city
CREATE TABLE IF NOT EXISTS `city` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(50) NOT NULL DEFAULT '',
  `location_x` int(10) NOT NULL,
  `location_y` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `location_x_location_y_unique` (`location_x`,`location_y`),
  KEY `location_x_location_y` (`location_x`,`location_y`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gigablaster.demand
CREATE TABLE IF NOT EXISTS `demand` (
  `city_id` int(10) unsigned NOT NULL,
  `ressource_id` int(10) unsigned NOT NULL,
  `percent` float unsigned NOT NULL,
  `sold` int(10) unsigned NOT NULL DEFAULT '0',
  `price_modifier` float unsigned NOT NULL DEFAULT '0' COMMENT 'calc by proc demand_update',
  PRIMARY KEY (`city_id`,`ressource_id`),
  CONSTRAINT `FK_demand_city` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
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


-- Dumping structure for table gigablaster.influence
CREATE TABLE IF NOT EXISTS `influence` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sovereign_id` int(10) unsigned NOT NULL,
  `city_id` int(10) unsigned NOT NULL,
  `type_id` int(10) unsigned NOT NULL,
  `value` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sovereing_id_city_id` (`sovereign_id`,`city_id`,`type_id`),
  KEY `FK_sovereign_city_influencetype` (`type_id`),
  KEY `sovereing_city_type` (`sovereign_id`,`city_id`,`type_id`),
  KEY `FK_sovereign_city_entity` (`city_id`),
  CONSTRAINT `FK_sovereign_city_entity` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_sovereign_city_influencetype` FOREIGN KEY (`type_id`) REFERENCES `influencetype` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_sovereign_city_sovereign` FOREIGN KEY (`sovereign_id`) REFERENCES `sovereign` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gigablaster.influencetype
CREATE TABLE IF NOT EXISTS `influencetype` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gigablaster.pawn
CREATE TABLE IF NOT EXISTS `pawn` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `player_id` int(10) unsigned DEFAULT NULL,
  `type_id` int(10) unsigned NOT NULL DEFAULT '1',
  `label` varchar(200) DEFAULT NULL,
  `level` int(10) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `FK_entity_entitytype` (`type_id`),
  KEY `FK_entity_player` (`player_id`),
  CONSTRAINT `FK_entity_entitytype` FOREIGN KEY (`type_id`) REFERENCES `pawntype` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gigablaster.pawntype
CREATE TABLE IF NOT EXISTS `pawntype` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(250) NOT NULL,
  `value_base` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gigablaster.pawntype_prodtype_assoc
CREATE TABLE IF NOT EXISTS `pawntype_prodtype_assoc` (
  `pawntype_id` int(11) unsigned NOT NULL,
  `prodtype_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`pawntype_id`,`prodtype_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gigablaster.pawn_location_assoc
CREATE TABLE IF NOT EXISTS `pawn_location_assoc` (
  `pawn_id` int(10) unsigned NOT NULL,
  `location_x` int(10) NOT NULL,
  `location_y` int(10) NOT NULL,
  PRIMARY KEY (`pawn_id`,`location_x`,`location_y`),
  CONSTRAINT `FK_entity_location_assoc_entity` FOREIGN KEY (`pawn_id`) REFERENCES `pawn` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gigablaster.player
CREATE TABLE IF NOT EXISTS `player` (
  `user_id` int(10) unsigned NOT NULL,
  `id` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(250) NOT NULL,
  `credit` int(10) unsigned NOT NULL DEFAULT '0',
  `income` int(10) unsigned NOT NULL DEFAULT '0',
  `cart` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `FK_player_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gigablaster.population
CREATE TABLE IF NOT EXISTS `population` (
  `city_id` int(10) unsigned NOT NULL,
  `quantity` int(10) unsigned NOT NULL,
  `growth` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`city_id`),
  CONSTRAINT `FK_population_city` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gigablaster.prod
CREATE TABLE IF NOT EXISTS `prod` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pawn_id` int(10) unsigned NOT NULL,
  `prodtype_id` int(10) unsigned NOT NULL,
  `location_x` int(11) NOT NULL,
  `location_y` int(11) NOT NULL,
  `percent_max` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_prod_prodtype` (`prodtype_id`),
  KEY `FK_prod_pawn` (`pawn_id`),
  CONSTRAINT `FK_prod_pawn` FOREIGN KEY (`pawn_id`) REFERENCES `pawn` (`id`) ON DELETE CASCADE,
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
  `ressource_id` int(10) unsigned NOT NULL,
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


-- Dumping structure for table gigablaster.sovereign
CREATE TABLE IF NOT EXISTS `sovereign` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(50) DEFAULT NULL,
  `capital` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_sovereign_city` (`capital`)
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


-- Dumping structure for table gigablaster._view_note
CREATE TABLE IF NOT EXISTS `_view_note` (
  `view_name` varchar(50) DEFAULT NULL,
  `formated` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='view query properly formated';

-- Data exporting was unselected.


-- Dumping structure for view gigablaster.city_distance
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `city_distance` (
	`pawn0_id` INT(10) UNSIGNED NOT NULL,
	`pawn1_id` INT(10) UNSIGNED NULL,
	`dist` BIGINT(13) NOT NULL
) ENGINE=MyISAM;


-- Dumping structure for view gigablaster.city_sovereign
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `city_sovereign` (
	`city_id` INT(10) UNSIGNED NOT NULL,
	`sovereign_id` INT(10) UNSIGNED NULL,
	`sum_value` DECIMAL(32,0) NULL
) ENGINE=MyISAM;


-- Dumping structure for view gigablaster.influence_sum
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `influence_sum` (
	`city_id` INT(10) UNSIGNED NOT NULL,
	`sovereign_id` INT(10) UNSIGNED NULL,
	`sum_value` DECIMAL(32,0) NULL
) ENGINE=MyISAM;


-- Dumping structure for view gigablaster.overcrowd
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `overcrowd` (
	`ressource_id` INT(10) UNSIGNED NOT NULL,
	`location_x` INT(10) UNSIGNED NOT NULL,
	`location_y` INT(10) UNSIGNED NOT NULL,
	`quantity` DECIMAL(32,0) NULL
) ENGINE=MyISAM;


-- Dumping structure for view gigablaster.player_ext
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `player_ext` (
	`player_id` INT(10) UNSIGNED NULL,
	`cart_used` DECIMAL(32,0) NULL
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
	`buyer_id` INT(10) UNSIGNED NOT NULL,
	`ressource_id` INT(10) UNSIGNED NOT NULL,
	`quantity` INT(10) UNSIGNED NOT NULL
) ENGINE=MyISAM;


-- Dumping structure for procedure gigablaster.city_spawn
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `city_spawn`()
BEGIN

		DECLARE bDone INT;

		DECLARE city_id INT;
		DECLARE location_x INT;    -- or approriate type
		DECLARE location_y INT;
		
		DECLARE curs CURSOR FOR
			/* Get all spawn point (location with a production but no city)*/
			SELECT 
				prod.location_x, 
				prod.location_y
			FROM prod
			LEFT JOIN city AS city_location 
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
				INSERT INTO city(location_x,location_y)
				VALUES (location_x,location_y);
				
				SET city_id = LAST_INSERT_ID();
				
				INSERT INTO population(city_id,quantity)
				VALUES (city_id,10);
				
				INSERT INTO demand(city_id,ressource_id,percent)
				SELECT city_id, res_id ,1.0
				FROM ressource_rescategory
				WHERE rescat_id IN (1,5,10,4,11);
			COMMIT;
		
		END LOOP loopy;

		CLOSE curs;
END//
DELIMITER ;


-- Dumping structure for procedure gigablaster.cleanup
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `cleanup`()
BEGIN
/*
	DELETE prod
	FROM prod 
	LEFT JOIN entity ON entity.id = prod.entity_id
	WHERE entity.id IS NULL;
	
	DELETE prodinput
	FROM prodinput 
	LEFT JOIN prod ON prod.id = prodinput.prod_id
	WHERE prod.id IS NULL;
	*/
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

	# Disable full_group_only disable 
	SET SESSION sql_mode = '';

	# Upate basic food and essential price modifier
	UPDATE demand
	JOIN
	(
		# Get new price modifier
		# Require full_group_only disabled
		SELECT 
			demand.city_id,
			demand.ressource_id,
			IF( SUM(sold.quantity) IS NULL,
				20,	#
				LEAST(
					20,
				GREATEST(
					1,
					20- SUM(sold.quantity)*10
					/ population.quantity
					
				))
			) AS price_modifier_new
		FROM demand
		
		# Include basic food
		JOIN ressource ON ressource.id = demand.ressource_id
		JOIN ressource_rescategory 
			ON ressource_rescategory.res_id = ressource.id
			AND (
				ressource_rescategory.rescat_id = 5/*basic food*/
				OR ressource_rescategory.rescat_id = 1/*essential*/
			)
		
		# Get related population
		JOIN population ON population.city_id = demand.city_id
		
		# Get sold if any
		LEFT JOIN sold 
			ON demand.city_id = sold.buyer_id 
			AND demand.ressource_id = sold.ressource_id
			
		GROUP BY demand.city_id, demand.ressource_id
	) as t ON t.city_id = demand.city_id AND t.ressource_id = demand.ressource_id
	SET demand.price_modifier = t.price_modifier_new;
	
END//
DELIMITER ;


-- Dumping structure for procedure gigablaster.income_update
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `income_update`()
BEGIN
	UPDATE player
	JOIN (
		SELECT 
			player.id,
			IFNULL(
				SUM(demand.price_modifier * ressource.baseprice * sold.quantity ),
				0
			) AS income
		FROM player
		LEFT JOIN pawn ON pawn.player_id = player.id
		LEFT JOIN sold ON sold.seller_id = pawn.id
		LEFT JOIN demand ON demand.city_id = sold.buyer_id
		LEFT JOIN ressource ON ressource.id = sold.ressource_id
		GROUP BY player.id
	) AS t ON t.id = player.id
	SET player.income = t.income;
END//
DELIMITER ;


-- Dumping structure for procedure gigablaster.population_growth_update
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `population_growth_update`()
BEGIN
	UPDATE population 
	JOIN (
		SELECT 
			demand.city_id,
			((-AVG(demand.price_modifier)+10)/10)*0.25 AS growth_percent
		FROM demand
		JOIN ressource ON ressource.id = demand.ressource_id
		JOIN ressource_rescategory ON ressource_rescategory.res_id = ressource.id
		WHERE ressource_rescategory.rescat_id = 5 #basic foor
			OR ressource_rescategory.rescat_id = 1 #essential
		GROUP BY demand.city_id
	) t ON population.city_id = t.city_id
	SET population.growth = FLOOR(t.growth_percent * population.quantity);
END//
DELIMITER ;


-- Dumping structure for procedure gigablaster.population_quantity_update
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `population_quantity_update`()
BEGIN
	UPDATE population
	SET population.quantity = GREATEST(10,population.quantity + population.growth);
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
			prod.pawn_id,
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
			ON prod_sum.location_x = prodinput.location_x
			AND prod_sum.location_y = prodinput.location_y
			AND prod_sum.ressource_id = prodinputtype.ressource_id
		LEFT JOIN prodinput_sum
			ON prodinput_sum.location_x = prodinput.location_x
			AND prodinput_sum.location_y = prodinput.location_y
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


-- Dumping structure for procedure gigablaster.turn
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `turn`()
BEGIN
	CALL `prod_percent_update`();
	
	CALL `population_growth_update`();
	CALL `population_quantity_update`();
	
	CALL `city_spawn`();
	
	CALL `demand_update`();
	
	CALL `income_update`();
	CALL `credit_update`();
END//
DELIMITER ;


-- Dumping structure for view gigablaster.city_distance
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `city_distance`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `city_distance` AS select `et0`.`id` AS `pawn0_id`,`et1`.`id` AS `pawn1_id`,(abs((`loc0`.`location_x` - `loc1`.`location_x`)) + abs((`loc0`.`location_y` - `loc1`.`location_y`))) AS `dist` from (((`pawn` `et0` join `pawn_location_assoc` `loc0` on((`loc0`.`pawn_id` = `et0`.`id`))) left join `pawn` `et1` on((`et0`.`id` <> `et1`.`id`))) join `pawn_location_assoc` `loc1` on((`loc1`.`pawn_id` = `et1`.`id`))) where ((`et0`.`type_id` = 1) and (`et1`.`type_id` = 1));


-- Dumping structure for view gigablaster.city_sovereign
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `city_sovereign`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `city_sovereign` AS select `t`.`city_id` AS `city_id`,`t`.`sovereign_id` AS `sovereign_id`,`t`.`sum_value` AS `sum_value` from (`gigablaster`.`influence_sum` `t` join (select `influence_sum`.`city_id` AS `city_id`,max(`influence_sum`.`sum_value`) AS `max_value` from `gigablaster`.`influence_sum` group by `influence_sum`.`city_id`) `tmax` on(((`tmax`.`city_id` = `t`.`city_id`) and (`t`.`sum_value` = `tmax`.`max_value`))));


-- Dumping structure for view gigablaster.influence_sum
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `influence_sum`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `influence_sum` AS select `city`.`id` AS `city_id`,`influence`.`sovereign_id` AS `sovereign_id`,sum(`influence`.`value`) AS `sum_value` from (`city` left join `influence` on((`influence`.`city_id` = `city`.`id`))) group by `city`.`id`,`influence`.`sovereign_id`;


-- Dumping structure for view gigablaster.overcrowd
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `overcrowd`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `overcrowd` AS select `prodinputtype`.`ressource_id` AS `ressource_id`,`prodinput`.`location_x` AS `location_x`,`prodinput`.`location_y` AS `location_y`,sum(`prodinputtype`.`quantity`) AS `quantity` from ((`prodinput` join `prodinputtype` on((`prodinputtype`.`id` = `prodinput`.`prodinputtype_id`))) join `ressource` on(((`ressource`.`id` = `prodinputtype`.`ressource_id`) and (`ressource`.`natural` = 1)))) group by `prodinputtype`.`ressource_id`,`prodinput`.`location_x`,`prodinput`.`location_y`;


-- Dumping structure for view gigablaster.player_ext
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `player_ext`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `player_ext` AS select `t_cart`.`player_id` AS `player_id`,`t_cart`.`cart_used` AS `cart_used` from (select `gigablaster`.`pawn`.`player_id` AS `player_id`,sum(`gigablaster`.`pawn`.`level`) AS `cart_used` from `gigablaster`.`pawn` where (`gigablaster`.`pawn`.`type_id` = 10) group by `gigablaster`.`pawn`.`player_id`) `t_cart`;


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
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `sold` AS select `seller`.`id` AS `seller_id`,`buyer`.`id` AS `buyer_id`,`prodinputtype`.`ressource_id` AS `ressource_id`,`prodinputtype`.`quantity` AS `quantity` from ((((((`player` join `pawn` `seller` on((`seller`.`player_id` = `player`.`id`))) join `prod` on((`prod`.`pawn_id` = `seller`.`id`))) join `prodtype` on(((`prodtype`.`id` = `prod`.`prodtype_id`) and (`prodtype`.`ressource_id` = 1)))) join `prodinput` on((`prodinput`.`prod_id` = `prod`.`id`))) join `prodinputtype` on((`prodinputtype`.`id` = `prodinput`.`prodinputtype_id`))) join `city` `buyer` on(((`buyer`.`location_x` = `prod`.`location_x`) and (`buyer`.`location_y` = `prod`.`location_y`))));
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
