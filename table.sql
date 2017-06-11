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
  KEY `location_x_location_y` (`location_x`,`location_y`),
  KEY `label` (`label`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gigablaster.demand
CREATE TABLE IF NOT EXISTS `demand` (
  `city_id` int(10) unsigned NOT NULL,
  `ressource_id` int(10) unsigned NOT NULL,
  `percent` float unsigned NOT NULL,
  `sold` int(10) unsigned NOT NULL DEFAULT '0',
  `price_modifier` float unsigned NOT NULL DEFAULT '0' COMMENT 'calc by proc demand_update',
  `value` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`city_id`,`ressource_id`),
  KEY `FK_demand_ressource` (`ressource_id`),
  CONSTRAINT `FK_demand_city` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_demand_ressource` FOREIGN KEY (`ressource_id`) REFERENCES `ressource` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gigablaster.influencemodifier
CREATE TABLE IF NOT EXISTS `influencemodifier` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sovereign_id` int(10) unsigned NOT NULL,
  `city_id` int(10) unsigned NOT NULL,
  `type_id` int(10) unsigned NOT NULL,
  `value` int(11) NOT NULL DEFAULT '0',
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
  `value` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gigablaster.pawn
CREATE TABLE IF NOT EXISTS `pawn` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `player_id` int(10) unsigned DEFAULT NULL,
  `type_id` int(10) unsigned NOT NULL DEFAULT '1',
  `label` varchar(200) DEFAULT NULL,
  `grade` int(10) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `FK_entity_player` (`player_id`),
  KEY `FK_entity_entitytype` (`type_id`),
  CONSTRAINT `FK_entity_entitytype` FOREIGN KEY (`type_id`) REFERENCES `pawntype` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gigablaster.pawntype
CREATE TABLE IF NOT EXISTS `pawntype` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned NOT NULL DEFAULT '1',
  `label` varchar(250) NOT NULL,
  `value_base` int(10) unsigned NOT NULL DEFAULT '0',
  `description` text,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `FK_pawntype_pawntypecategory` FOREIGN KEY (`category_id`) REFERENCES `pawntypecategory` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gigablaster.pawntypecategory
CREATE TABLE IF NOT EXISTS `pawntypecategory` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gigablaster.pawntype_prodtype_assoc
CREATE TABLE IF NOT EXISTS `pawntype_prodtype_assoc` (
  `pawntype_id` int(11) unsigned NOT NULL,
  `prodtype_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`pawntype_id`,`prodtype_id`),
  KEY `FK_pawntype_prodtype_assoc_prodtype` (`prodtype_id`),
  CONSTRAINT `FK_pawntype_prodtype_assoc_pawntype` FOREIGN KEY (`pawntype_id`) REFERENCES `pawntype` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_pawntype_prodtype_assoc_prodtype` FOREIGN KEY (`prodtype_id`) REFERENCES `prodtype` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gigablaster.pawn_location_assoc
CREATE TABLE IF NOT EXISTS `pawn_location_assoc` (
  `pawn_id` int(10) unsigned NOT NULL,
  `location_x` int(10) NOT NULL,
  `location_y` int(10) NOT NULL,
  PRIMARY KEY (`pawn_id`,`location_x`,`location_y`),
  CONSTRAINT `FK_entity_location_assoc_entity` FOREIGN KEY (`pawn_id`) REFERENCES `pawn` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gigablaster.player
CREATE TABLE IF NOT EXISTS `player` (
  `user_id` int(10) unsigned NOT NULL,
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
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


-- Dumping structure for table gigablaster.post
CREATE TABLE IF NOT EXISTS `post` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gigablaster.prod
CREATE TABLE IF NOT EXISTS `prod` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pawn_id` int(10) unsigned NOT NULL,
  `prodtype_id` int(10) unsigned NOT NULL,
  `location_x` int(11) NOT NULL,
  `location_y` int(11) NOT NULL,
  `percent_max` int(11) NOT NULL DEFAULT '0',
  `grade` int(10) unsigned NOT NULL DEFAULT '1',
  `updated` tinyint(3) unsigned NOT NULL DEFAULT '0',
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
  PRIMARY KEY (`id`),
  KEY `FK_prodinputtype_ressource` (`ressource_id`),
  CONSTRAINT `FK_prodinputtype_ressource` FOREIGN KEY (`ressource_id`) REFERENCES `ressource` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gigablaster.prodtype
CREATE TABLE IF NOT EXISTS `prodtype` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ressource_id` int(10) unsigned NOT NULL DEFAULT '0',
  `quantity` int(10) NOT NULL DEFAULT '0',
  `comment` text,
  PRIMARY KEY (`id`),
  KEY `FK_prodtype_ressource` (`ressource_id`),
  CONSTRAINT `FK_prodtype_ressource` FOREIGN KEY (`ressource_id`) REFERENCES `ressource` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gigablaster.prodtype_prodinputtype_assoc
CREATE TABLE IF NOT EXISTS `prodtype_prodinputtype_assoc` (
  `prodtype_id` int(11) unsigned NOT NULL,
  `prodinputtype_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`prodtype_id`,`prodinputtype_id`),
  KEY `FK_prodtype_prodinputtype_assoc_prodinputtype` (`prodinputtype_id`),
  CONSTRAINT `FK_prodtype_prodinputtype_assoc_prodinputtype` FOREIGN KEY (`prodinputtype_id`) REFERENCES `prodinputtype` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_prodtype_prodinputtype_assoc_prodtype` FOREIGN KEY (`prodtype_id`) REFERENCES `prodtype` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gigablaster.relationshipmodifier
CREATE TABLE IF NOT EXISTS `relationshipmodifier` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `player_id` int(10) unsigned NOT NULL,
  `sovereign_id` int(10) unsigned NOT NULL,
  `type_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `player_id` (`player_id`),
  KEY `sovereign_id` (`sovereign_id`),
  KEY `type_id` (`type_id`),
  CONSTRAINT `FK_relationshipmodifier_player` FOREIGN KEY (`player_id`) REFERENCES `player` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_relationshipmodifier_sovereign` FOREIGN KEY (`sovereign_id`) REFERENCES `sovereign` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gigablaster.relationshiptype
CREATE TABLE IF NOT EXISTS `relationshiptype` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(50) DEFAULT NULL,
  `description` text NOT NULL,
  `value` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
  `description` text,
  PRIMARY KEY (`id`),
  KEY `natural` (`natural`),
  KEY `baseprice` (`baseprice`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gigablaster.ressource_rescategory
CREATE TABLE IF NOT EXISTS `ressource_rescategory` (
  `rescat_id` int(10) unsigned NOT NULL,
  `res_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`rescat_id`,`res_id`),
  KEY `FK_ressource_rescategory_ressource` (`res_id`),
  CONSTRAINT `FK_ressource_rescategory_rescategory` FOREIGN KEY (`rescat_id`) REFERENCES `rescategory` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_ressource_rescategory_ressource` FOREIGN KEY (`res_id`) REFERENCES `ressource` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gigablaster.sovereign
CREATE TABLE IF NOT EXISTS `sovereign` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(50) DEFAULT NULL,
  `capital` int(10) unsigned NOT NULL,
  `taxe_ratio` float unsigned NOT NULL DEFAULT '1',
  `budget` int(10) unsigned NOT NULL DEFAULT '0',
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
	`city0_id` INT(10) UNSIGNED NOT NULL,
	`city1_id` INT(10) UNSIGNED NULL,
	`dist` BIGINT(13) NULL
) ENGINE=MyISAM;


-- Dumping structure for view gigablaster.city_sovereign
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `city_sovereign` (
	`city_id` INT(10) UNSIGNED NOT NULL,
	`sovereign_id` INT(11) UNSIGNED NULL,
	`sum_value` DECIMAL(60,0) NULL
) ENGINE=MyISAM;


-- Dumping structure for view gigablaster.influence
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `influence` (
	`city_id` INT(11) UNSIGNED NOT NULL,
	`sovereign_id` INT(11) UNSIGNED NOT NULL,
	`type_id` BIGINT(20) UNSIGNED NOT NULL,
	`value` DECIMAL(38,0) NULL
) ENGINE=MyISAM;


-- Dumping structure for view gigablaster.influence_relationship
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `influence_relationship` (
	`city_id` INT(10) UNSIGNED NOT NULL,
	`sovereign_id` INT(10) UNSIGNED NOT NULL,
	`value` DECIMAL(38,0) NULL
) ENGINE=MyISAM;


-- Dumping structure for view gigablaster.influence_sum
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `influence_sum` (
	`city_id` INT(10) UNSIGNED NOT NULL,
	`sovereign_id` INT(11) UNSIGNED NULL,
	`sum_value` DECIMAL(60,0) NULL
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
	`player_id` INT(10) UNSIGNED NOT NULL,
	`cart_used` DECIMAL(32,0) NOT NULL,
	`income` DOUBLE NOT NULL
) ENGINE=MyISAM;


-- Dumping structure for view gigablaster.prodinput_sum
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `prodinput_sum` (
	`player_id` INT(10) UNSIGNED NULL,
	`location_x` INT(10) UNSIGNED NOT NULL,
	`location_y` INT(10) UNSIGNED NOT NULL,
	`ressource_id` INT(10) UNSIGNED NOT NULL,
	`quantity` DECIMAL(42,0) NULL
) ENGINE=MyISAM;


-- Dumping structure for view gigablaster.prod_sum
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `prod_sum` (
	`player_id` INT(10) UNSIGNED NULL,
	`location_x` INT(11) NOT NULL,
	`location_y` INT(11) NOT NULL,
	`ressource_id` INT(10) UNSIGNED NOT NULL,
	`quantity` DECIMAL(16,0) NULL
) ENGINE=MyISAM;


-- Dumping structure for view gigablaster.relationship
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `relationship` (
	`id` INT(10) UNSIGNED NOT NULL,
	`player_id` INT(10) UNSIGNED NOT NULL,
	`sovereign_id` INT(10) UNSIGNED NOT NULL,
	`type_id` INT(10) UNSIGNED NOT NULL
) ENGINE=MyISAM;


-- Dumping structure for view gigablaster.sold
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `sold` (
	`seller_id` INT(10) UNSIGNED NOT NULL,
	`buyer_id` INT(10) UNSIGNED NOT NULL,
	`ressource_id` INT(10) UNSIGNED NOT NULL,
	`quantity` DECIMAL(16,0) NOT NULL
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


-- Dumping structure for procedure gigablaster.demand_update_pricemodifier
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `demand_update_pricemodifier`()
BEGIN
	# Upate
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
					20 - 10 * (
						SUM(sold.quantity /*TODO: - bought.quantity */ )
						/ demand.value
					)
				))
			) AS price_modifier_new
		FROM demand
		
		# Get sold if any
		LEFT JOIN sold 
			ON demand.city_id = sold.buyer_id 
			AND demand.ressource_id = sold.ressource_id
			
		GROUP BY demand.city_id, demand.ressource_id
	) as t ON t.city_id = demand.city_id AND t.ressource_id = demand.ressource_id
	SET demand.price_modifier = t.price_modifier_new;
END//
DELIMITER ;


-- Dumping structure for procedure gigablaster.demand_update_value
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `demand_update_value`()
BEGIN

	# Disable full_group_only disable 
	SET SESSION sql_mode = '';

	# Upate basic food and essential value to population quantity
	UPDATE demand
	JOIN
	(
		# Get new price modifier
		# Require full_group_only disabled
		SELECT 
			demand.city_id,
			demand.ressource_id,
			population.quantity AS value_new
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
		#LEFT JOIN sold 
		#	ON demand.city_id = sold.buyer_id 
		#	AND demand.ressource_id = sold.ressource_id
			
		GROUP BY demand.city_id, demand.ressource_id
	) as t ON t.city_id = demand.city_id AND t.ressource_id = demand.ressource_id
	SET demand.value = t.value_new;
	
	# Upate innessential and luxury on random value
	UPDATE demand
	JOIN
	(
		SELECT 
			demand.city_id,
			demand.ressource_id,
			ROUND(RAND() * 1 * population.quantity ) AS value_new
		FROM demand
		
		# Include basic food
		JOIN ressource ON ressource.id = demand.ressource_id
		JOIN ressource_rescategory 
			ON ressource_rescategory.res_id = ressource.id
			AND (
				ressource_rescategory.rescat_id = 10/*inessential*/
				OR ressource_rescategory.rescat_id != 4/*luxury*/
			)
		
		# Get related population
		JOIN population ON population.city_id = demand.city_id
		
			
		GROUP BY demand.city_id, demand.ressource_id
	) as t ON t.city_id = demand.city_id AND t.ressource_id = demand.ressource_id
	SET demand.value = t.value_new;
	
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


-- Dumping structure for procedure gigablaster.influence_military_update
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `influence_military_update`()
BEGIN

	# Create military influence on city already under control
	INSERT INTO influencemodifier ( city_id, sovereign_id, type_id, value )
	SELECT 
		city_sovereign.city_id,
		city_sovereign.sovereign_id,
		3, #military
		sovereign.budget
	FROM city_sovereign
	JOIN sovereign ON sovereign.id = city_sovereign.sovereign_id
	JOIN influence_sum ON influence_sum.sovereign_id = sovereign.id
	ON DUPLICATE KEY UPDATE influencemodifier.value = sovereign.budget;
	
	# Delete military on city out of control
	DELETE influencemodifier
	FROM influencemodifier
	LEFT JOIN city_sovereign ON city_sovereign.city_id = influencemodifier.city_id
		AND city_sovereign.sovereign_id = influencemodifier.sovereign_id
	WHERE influencemodifier.type_id = 3 #military
		AND city_sovereign.city_id IS NULL;
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
			MIN(
				( 
					( prodinputtype.quantity * prod.grade / prodinput_sum.quantity ) * IFNULL(prod_sum.quantity, 0)
				) /*/ (prodinputtype.quantity * prod.grade)*/
			) as percent
		FROM prod
		JOIN pawn ON pawn.id = prod.pawn_id
		JOIN prodtype ON prodtype.id = prod.prodtype_id
		JOIN prodinput ON prodinput.prod_id = prod.id
		JOIN prodinputtype ON prodinputtype.id = prodinput.prodinputtype_id
		LEFT JOIN prod_sum 
			ON prod_sum.location_x = prodinput.location_x
			AND prod_sum.location_y = prodinput.location_y
			AND prod_sum.ressource_id = prodinputtype.ressource_id
		LEFT JOIN prodinput_sum
			ON prodinput_sum.player_id = pawn.player_id
			AND prodinput_sum.location_x = prodinput.location_x
			AND prodinput_sum.location_y = prodinput.location_y
			AND prodinput_sum.ressource_id = prodinputtype.ressource_id
		JOIN ressource 
			ON ressource.id = prodinputtype.ressource_id
			AND ressource.`natural` = 0
		WHERE prodtype.ressource_id != 1 # exclude sell
		GROUP BY prod.id
	) AS tprod_percent ON prod.id = tprod_percent.prod_id
	SET prod.percent_max = FLOOR(tprod_percent.percent);
	
/* ____________________________________________________________________________________
	Update SELL prod percent depending on the availability of prodinput and the demand */
	UPDATE prod 
	
	JOIN (
		SELECT 
			prod.id as prod_id,
			MIN(
				( 
					( (prodinputtype.quantity * prod.grade) / prodinput_sum.quantity ) * IFNULL(prod_sum.quantity, 0) 
				)/* / (prodinputtype.quantity * prod.grade)*/
			)
			* IF(MAX(demand.price_modifier) IS NULL,0,1) # Check if demand at this location
			as percent
		FROM prod
		JOIN pawn ON pawn.id = prod.pawn_id
		
		# Filter prodtype: seller
		JOIN prodtype 
			ON prodtype.id = prod.prodtype_id
			AND prodtype.ressource_id = 1
		
		JOIN prodinput ON prodinput.prod_id = prod.id
		JOIN prodinputtype ON prodinputtype.id = prodinput.prodinputtype_id
		
		# Get sum of output at this location for product needed
		LEFT JOIN prod_sum 
			ON prod_sum.location_x = prodinput.location_x
			AND prod_sum.location_y = prodinput.location_y
			AND prod_sum.ressource_id = prodinputtype.ressource_id
			
		# Get sum of need of other input at this location
		LEFT JOIN prodinput_sum
			ON prodinput_sum.player_id = pawn.player_id
			AND prodinput_sum.location_x = prodinput.location_x
			AND prodinput_sum.location_y = prodinput.location_y
			AND prodinput_sum.ressource_id = prodinputtype.ressource_id
		
		# Get demand at this location
		LEFT JOIN city 
			ON city.location_x = prod.location_x
			AND city.location_y = prod.location_y
		LEFT JOIN demand 
			ON demand.city_id = city.id
			AND demand.ressource_id = prodinputtype.ressource_id
		
		GROUP BY prod.id

	) AS tprod_percent ON prod.id = tprod_percent.prod_id
	SET prod.percent_max = FLOOR(tprod_percent.percent);

/* ____________________________________________________________________________________
Update BUY prod percent */
	UPDATE prod 
	
	JOIN (
		SELECT 
			prod.id as prod_id,
			LEAST(
				1.0,
				IF(
					tcost.cost = 0,
					1.0,
					player.credit / tcost.cost
				)
			)
			* IF(MAX(demand.price_modifier) IS NULL,0,1) as percent
		FROM prod
		JOIN prodtype ON prodtype.id = prod.prodtype_id
		
		# FILTER prod of type buy
		JOIN prodinput ON prodinput.prod_id = prod.id
		JOIN prodinputtype 
			ON prodinputtype.id = prodinput.prodinputtype_id
			AND prodinputtype.ressource_id = 1 # buy only
		
		# JOIN demand
		LEFT JOIN city 
			ON city.location_x = prod.location_x
			AND city.location_y = prod.location_y
		LEFT JOIN demand 
			ON demand.city_id = city.id
			AND demand.ressource_id = prodtype.ressource_id
		
		# JOIN player
		JOIN pawn ON prod.pawn_id = pawn.id
		JOIN player ON player.id = pawn.player_id
		
		# JOIN Player total buy cost 
		JOIN (
			SELECT 
				player.id as player_id,
				IFNULL( SUM( demand.price_modifier * ressource.baseprice ), 0)  as cost
			FROM prod
			JOIN prodtype ON prodtype.id = prod.prodtype_id
			JOIN pawn ON prod.pawn_id = pawn.id
			JOIN player ON player.id = pawn.player_id
			LEFT JOIN city 
				ON city.location_x = prod.location_x
				AND city.location_y = prod.location_y
			LEFT JOIN demand 
				ON demand.city_id = city.id
				AND demand.ressource_id = prodtype.ressource_id
			LEFT JOIN ressource ON ressource.id = demand.ressource_id
			GROUP BY player.id
		) as tcost ON tcost.player_id = player.id
		
		GROUP BY prod.id
	) AS tprod_percent ON prod.id = tprod_percent.prod_id
	SET prod.percent_max = FLOOR(tprod_percent.percent);
	
END//
DELIMITER ;


-- Dumping structure for procedure gigablaster.prod_update_single
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `prod_update_single`()
BEGIN


	DECLARE c INT DEFAULT 0;
	
	REPEAT
	
	/* Mark prods affected by this change */
		UPDATE prod 
		JOIN prodinput ON prodinput.prod_id = prod.id
		JOIN prodinputtype ON prodinputtype.id = prodinput.prodinputtype_id
		JOIN (
			SELECT 
				prod.location_x,
				prod.location_y,
				prodtype.ressource_id as ressource_id
			FROM prod 
			JOIN prodtype ON prodtype.id = prod.prodtype_id 
			WHERE prod.updated = 0
		) t 
			ON t.ressource_id = prodinputtype.ressource_id
			AND t.location_x = prodinput.location_x
			AND t.location_y = prodinput.location_y
		
		SET prod.updated = 0
		;
	
	UNTIL ROW_COUNT() = 0 END REPEAT;
	
	
	
	
	
	
REPEAT
	/*
		SET @changing_prod = (
			SELECT 
				prod.location_x,
				prod.location_y,
				prodtype.ressource_id as ressource_id
			FROM prod 
			JOIN prodtype ON prodtype.id = prod.prodtype_id 
			WHERE prod.updated = 0
		);
	*/
	/*
	CREATE TEMPORARY TABLE IF NOT EXISTS changing_prod AS (
		SELECT 
			prod.location_x,
			prod.location_y,
			prodtype.ressource_id as ressource_id
		FROM prod 
		JOIN prodtype ON prodtype.id = prod.prodtype_id 
		WHERE prod.updated = 0
	);
	*/
	SET c = 0;
/* Update prod percent depending on the availability of prodinput */
		UPDATE prod 
		
		JOIN (
			SELECT 
				prod.pawn_id,
				prod.id as prod_id,
				prod.location_x,
				prod.location_y,
				MIN( get_prod_ratio(prodinputtype.quantity, prod.grade, prodinput_sum.quantity, IFNULL(prod_sum.quantity, 0) ) )
				as percent
			FROM prod
			JOIN pawn ON pawn.id = prod.pawn_id
			JOIN prodtype ON prodtype.id = prod.prodtype_id
			JOIN prodinput ON prodinput.prod_id = prod.id
			JOIN prodinputtype ON prodinputtype.id = prodinput.prodinputtype_id
			LEFT JOIN prod_sum 
				ON prod_sum.location_x = prodinput.location_x
				AND prod_sum.location_y = prodinput.location_y
				AND prod_sum.ressource_id = prodinputtype.ressource_id
			LEFT JOIN prodinput_sum
				ON prodinput_sum.player_id = pawn.player_id
				AND prodinput_sum.location_x = prodinput.location_x
				AND prodinput_sum.location_y = prodinput.location_y
				AND prodinput_sum.ressource_id = prodinputtype.ressource_id
			JOIN ressource 
				ON ressource.id = prodinputtype.ressource_id
				AND ressource.`natural` = 0
				
			# exclude sell
			WHERE prodtype.ressource_id != 1 
			#TODO : exclude buy
			
			# Filter production already updated
			AND prod.updated = 0
			
			GROUP BY prod.id
		) AS tprod_percent ON prod.id = tprod_percent.prod_id
		SET prod.percent_max = FLOOR(tprod_percent.percent);
		
		SET c = c + ROW_COUNT();
		
/* ____________________________________________________________________________________
	Update SELL prod percent depending on the availability of prodinput and the demand */
		UPDATE prod 
		
		JOIN (
			SELECT 
				prod.id as prod_id,
				MIN( get_prod_ratio(prodinputtype.quantity, prod.grade, prodinput_sum.quantity, IFNULL(prod_sum.quantity, 0) ) )
				as percent
			FROM prod
			JOIN pawn ON pawn.id = prod.pawn_id
			
			# Filter prodtype: seller
			JOIN prodtype 
				ON prodtype.id = prod.prodtype_id
				AND prodtype.ressource_id = 1
			
			JOIN prodinput ON prodinput.prod_id = prod.id
			JOIN prodinputtype ON prodinputtype.id = prodinput.prodinputtype_id
			
			# Get sum of output at this location for product needed
			LEFT JOIN prod_sum 
				ON prod_sum.location_x = prodinput.location_x
				AND prod_sum.location_y = prodinput.location_y
				AND prod_sum.ressource_id = prodinputtype.ressource_id
				
			# Get sum of need of other input at this location
			LEFT JOIN prodinput_sum
				ON prodinput_sum.player_id = pawn.player_id
				AND prodinput_sum.location_x = prodinput.location_x
				AND prodinput_sum.location_y = prodinput.location_y
				AND prodinput_sum.ressource_id = prodinputtype.ressource_id
			
			# Get demand at this location
			LEFT JOIN city 
				ON city.location_x = prod.location_x
				AND city.location_y = prod.location_y
			LEFT JOIN demand 
				ON demand.city_id = city.id
				AND demand.ressource_id = prodinputtype.ressource_id
				
			# Filter production already updated
			WHERE prod.updated = 0
			
			GROUP BY prod.id
	
		) AS tprod_percent ON prod.id = tprod_percent.prod_id
		SET prod.percent_max = FLOOR(tprod_percent.percent);
		
	SET c = c + ROW_COUNT();
	
/* ____________________________________________________________________________________
Update BUY prod percent */
		UPDATE prod 
		
		JOIN (
			SELECT 
				prod.id as prod_id,
				LEAST(
					1.0,
					IF(
						tcost.cost = 0,
						1.0,
						player.credit / tcost.cost
					)
				)
				* IF(MAX(demand.price_modifier) IS NULL,0,1) as percent
			FROM prod
			JOIN prodtype ON prodtype.id = prod.prodtype_id
			
			# FILTER prod of type buy
			JOIN prodinput ON prodinput.prod_id = prod.id
			JOIN prodinputtype 
				ON prodinputtype.id = prodinput.prodinputtype_id
				AND prodinputtype.ressource_id = 1 # buy only
			
			# JOIN demand
			LEFT JOIN city 
				ON city.location_x = prod.location_x
				AND city.location_y = prod.location_y
			LEFT JOIN demand 
				ON demand.city_id = city.id
				AND demand.ressource_id = prodtype.ressource_id
			
			# JOIN player
			JOIN pawn ON prod.pawn_id = pawn.id
			JOIN player ON player.id = pawn.player_id
			
			# JOIN Player total buy cost 
			JOIN (
				SELECT 
					player.id as player_id,
					IFNULL( SUM( demand.price_modifier * ressource.baseprice ), 0)  as cost
				FROM prod
				JOIN prodtype ON prodtype.id = prod.prodtype_id
				JOIN pawn ON prod.pawn_id = pawn.id
				JOIN player ON player.id = pawn.player_id
				LEFT JOIN city 
					ON city.location_x = prod.location_x
					AND city.location_y = prod.location_y
				LEFT JOIN demand 
					ON demand.city_id = city.id
					AND demand.ressource_id = prodtype.ressource_id
				LEFT JOIN ressource ON ressource.id = demand.ressource_id
				GROUP BY player.id
			) as tcost ON tcost.player_id = player.id
			
			# Filter production already updated
			WHERE prod.updated = 0
			
			GROUP BY prod.id
		) AS tprod_percent ON prod.id = tprod_percent.prod_id
		SET prod.percent_max = FLOOR(tprod_percent.percent);
	
	SET c = c + ROW_COUNT();
		
/* ____________________________________________________________________________________
Failt safe harvester */
	
		UPDATE prod 
		
		# Get prod with natural input
		JOIN prodinput ON prodinput.prod_id = prod.id
		JOIN prodinputtype ON prodinputtype.id = prodinput.prodinputtype_id
		JOIN ressource 
			ON ressource.id = prodinputtype.ressource_id
			AND ressource.`natural` = 1
		
		SET prod.updated = 1
		
		# Filter production already updated
		WHERE prod.updated = 0
		;
	SET c = c + ROW_COUNT();
		
/* ____________________________________________________________________________________
 */

UNTIL c = 0 END REPEAT;
	
	UPDATE prod SET prod.updated = 1 WHERE prod.updated = 0;

END//
DELIMITER ;


-- Dumping structure for procedure gigablaster.reset
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `reset`()
BEGIN
	DELETE FROM pawn;
	DELETE FROM city;
	DELETE FROM sovereign;
END//
DELIMITER ;


-- Dumping structure for procedure gigablaster.sovereign_budget_update
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sovereign_budget_update`()
BEGIN

	UPDATE sovereign 
	JOIN (
		SELECT 
			city_sovereign.sovereign_id,
			SUM(population.quantity) as pop
		FROM city
		JOIN city_sovereign ON city_sovereign.city_id = city.id
		JOIN population ON population.city_id = city.id
		GROUP BY city_sovereign.sovereign_id
	) t ON t.sovereign_id = sovereign.id
	SET sovereign.budget = t.pop * sovereign.taxe_ratio;
END//
DELIMITER ;


-- Dumping structure for procedure gigablaster.sovereign_spawn
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sovereign_spawn`()
BEGIN
	DECLARE bDone INT;

	DECLARE city_id INT;
	DECLARE sovereign_id INT;
	
	DECLARE curs CURSOR FOR
		# Get all big city with no influence 
		SELECT 
			city.id as city_id 
		FROM city
		JOIN population ON population.city_id = city.id
		JOIN influence_sum ON influence_sum.city_id = city.id 
			AND influence_sum.sum_value IS NULL
		WHERE population.quantity >= 10;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET bDone = 1;

	OPEN curs;

	SET bDone = 0;
	loopy: LOOP
		
		FETCH curs INTO city_id;
		IF bDone = 1 THEN LEAVE loopy; END IF;
		
		START TRANSACTION;
			INSERT INTO sovereign(capital)
			VALUES (city_id);
			
			SET sovereign_id = LAST_INSERT_ID();
			
			INSERT INTO influencemodifier(sovereign_id,city_id,type_id,value)
			VALUES (sovereign_id,city_id,1,100);
		COMMIT;
	
	END LOOP loopy;

	CLOSE curs;
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
	
	CALL `demand_update_value`();
	CALL `demand_update_pricemodifier`();
	
	CALL `income_update`();
	CALL `credit_update`();
	
	CALL `sovereign_budget_update`();
	CALL `influence_military_update`();
	CALL `sovereign_spawn`();
END//
DELIMITER ;


-- Dumping structure for function gigablaster.get_prod_ratio
DELIMITER //
CREATE DEFINER=`root`@`localhost` FUNCTION `get_prod_ratio`(`inputQ` INT, `grade` INT, `inputTotal` INT, `suppliedTotal` INT) RETURNS float
BEGIN
/*
Calc prod : 
	 (inputQ*grade) / inputQ total asked = ratio input
	 ratio input * supplied total = allocated ress
	 inputQ / allocated ress = percent
	 percent.max(1) * grade = mult
*/
	RETURN 
		LEAST( 1,
			(
				( inputQ*grade / inputTotal )
				* suppliedTotal
			) 
			/(inputQ*grade)
		) * grade
	;
END//
DELIMITER ;


-- Dumping structure for view gigablaster.city_distance
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `city_distance`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `city_distance` AS select `c0`.`id` AS `city0_id`,`c1`.`id` AS `city1_id`,(abs((`c1`.`location_x` - `c0`.`location_x`)) + abs((`c1`.`location_y` - `c0`.`location_y`))) AS `dist` from (`city` `c0` left join `city` `c1` on((`c1`.`id` <> `c0`.`id`)));


-- Dumping structure for view gigablaster.city_sovereign
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `city_sovereign`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `city_sovereign` AS select `t`.`city_id` AS `city_id`,min(`t`.`sovereign_id`) AS `sovereign_id`,`t`.`sum_value` AS `sum_value` from (`gigablaster`.`influence_sum` `t` join (select `influence_sum`.`city_id` AS `city_id`,max(`influence_sum`.`sum_value`) AS `max_value` from `gigablaster`.`influence_sum` group by `influence_sum`.`city_id`) `tmax` on(((`tmax`.`city_id` = `t`.`city_id`) and (`t`.`sum_value` = `tmax`.`max_value`)))) group by `t`.`city_id`;


-- Dumping structure for view gigablaster.influence
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `influence`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `influence` AS select `influencemodifier`.`city_id` AS `city_id`,`influencemodifier`.`sovereign_id` AS `sovereign_id`,`influencemodifier`.`type_id` AS `type_id`,`influencemodifier`.`value` AS `value` from `influencemodifier` union select `influence_relationship`.`city_id` AS `city_id`,`influence_relationship`.`sovereign_id` AS `sovereign_id`,4 AS `4`,`influence_relationship`.`value` AS `value` from `influence_relationship`;


-- Dumping structure for view gigablaster.influence_relationship
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `influence_relationship`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `influence_relationship` AS select `city`.`id` AS `city_id`,`relationship`.`sovereign_id` AS `sovereign_id`,sum(`sold`.`quantity`) AS `value` from (((`city` join `sold` on((`sold`.`buyer_id` = `city`.`id`))) join `pawn` on((`pawn`.`id` = `sold`.`seller_id`))) join `relationship` on((`relationship`.`player_id` = `pawn`.`player_id`))) group by `city`.`id`,`relationship`.`sovereign_id`;


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
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `player_ext` AS select `gigablaster`.`player`.`id` AS `player_id`,ifnull(`tcartused`.`value`,0) AS `cart_used`,(ifnull(`trevenue`.`value`,0) - ifnull(`tcharge`.`value`,0)) AS `income` from (((`gigablaster`.`player` left join (select `gigablaster`.`pawn`.`player_id` AS `player_id`,ifnull(sum(`gigablaster`.`pawn`.`grade`),0) AS `value` from (`gigablaster`.`pawn` join `gigablaster`.`pawntype` on((`gigablaster`.`pawntype`.`id` = `gigablaster`.`pawn`.`type_id`))) where (`gigablaster`.`pawntype`.`category_id` = 4) group by `gigablaster`.`pawn`.`player_id`) `tcartused` on((`tcartused`.`player_id` = `gigablaster`.`player`.`id`))) left join (select `gigablaster`.`pawn`.`player_id` AS `player_id`,ifnull(sum(((`gigablaster`.`demand`.`price_modifier` * `gigablaster`.`ressource`.`baseprice`) * `sold`.`quantity`)),0) AS `value` from (((`gigablaster`.`pawn` join `gigablaster`.`sold` on((`sold`.`seller_id` = `gigablaster`.`pawn`.`id`))) join `gigablaster`.`demand` on(((`gigablaster`.`demand`.`city_id` = `sold`.`buyer_id`) and (`gigablaster`.`demand`.`ressource_id` = `sold`.`ressource_id`)))) join `gigablaster`.`ressource` on((`gigablaster`.`ressource`.`id` = `sold`.`ressource_id`))) group by `gigablaster`.`pawn`.`player_id`) `trevenue` on((`trevenue`.`player_id` = `gigablaster`.`player`.`id`))) left join (select `gigablaster`.`pawn`.`player_id` AS `player_id`,ifnull(sum((`gigablaster`.`demand`.`price_modifier` * `gigablaster`.`ressource`.`baseprice`)),0) AS `value` from (((((`gigablaster`.`pawn` join `gigablaster`.`prod` on((`gigablaster`.`prod`.`pawn_id` = `gigablaster`.`pawn`.`id`))) join `gigablaster`.`prodtype` on((`gigablaster`.`prodtype`.`id` = `gigablaster`.`prod`.`prodtype_id`))) join `gigablaster`.`city` on(((`gigablaster`.`city`.`location_x` = `gigablaster`.`prod`.`location_x`) and (`gigablaster`.`city`.`location_y` = `gigablaster`.`prod`.`location_y`)))) join `gigablaster`.`demand` on(((`gigablaster`.`demand`.`city_id` = `gigablaster`.`city`.`id`) and (`gigablaster`.`demand`.`ressource_id` = `gigablaster`.`prodtype`.`ressource_id`)))) join `gigablaster`.`ressource` on((`gigablaster`.`ressource`.`id` = `gigablaster`.`demand`.`ressource_id`))) group by `gigablaster`.`pawn`.`player_id`) `tcharge` on((`tcharge`.`player_id` = `gigablaster`.`player`.`id`)));


-- Dumping structure for view gigablaster.prodinput_sum
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `prodinput_sum`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `prodinput_sum` AS select `pawn`.`player_id` AS `player_id`,`prodinput`.`location_x` AS `location_x`,`prodinput`.`location_y` AS `location_y`,`prodinputtype`.`ressource_id` AS `ressource_id`,sum((`prodinputtype`.`quantity` * `prod`.`grade`)) AS `quantity` from (((`prodinput` join `prod` on((`prod`.`id` = `prodinput`.`prod_id`))) join `pawn` on((`pawn`.`id` = `prod`.`pawn_id`))) join `prodinputtype` on((`prodinputtype`.`id` = `prodinput`.`prodinputtype_id`))) group by `pawn`.`player_id`,`prodinput`.`location_x`,`prodinput`.`location_y`,`prodinputtype`.`ressource_id`;


-- Dumping structure for view gigablaster.prod_sum
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `prod_sum`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `prod_sum` AS select `pawn`.`player_id` AS `player_id`,`prod`.`location_x` AS `location_x`,`prod`.`location_y` AS `location_y`,`prodtype`.`ressource_id` AS `ressource_id`,floor(sum((`prodtype`.`quantity` * `prod`.`percent_max`))) AS `quantity` from ((`prod` join `prodtype` on((`prodtype`.`id` = `prod`.`prodtype_id`))) join `pawn` on((`pawn`.`id` = `prod`.`pawn_id`))) group by `prod`.`location_x`,`prod`.`location_y`,`prodtype`.`ressource_id`,`pawn`.`player_id`;


-- Dumping structure for view gigablaster.relationship
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `relationship`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `relationship` AS select `relationshipmodifier`.`id` AS `id`,`relationshipmodifier`.`player_id` AS `player_id`,`relationshipmodifier`.`sovereign_id` AS `sovereign_id`,`relationshipmodifier`.`type_id` AS `type_id` from `relationshipmodifier`;


-- Dumping structure for view gigablaster.sold
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `sold`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `sold` AS select `seller`.`id` AS `seller_id`,`buyer`.`id` AS `buyer_id`,`prodinputtype`.`ressource_id` AS `ressource_id`,floor((`prodinputtype`.`quantity` * `prod`.`percent_max`)) AS `quantity` from (((((((`player` join `pawn` `seller` on((`seller`.`player_id` = `player`.`id`))) join `prod` on((`prod`.`pawn_id` = `seller`.`id`))) join `prodtype` on(((`prodtype`.`id` = `prod`.`prodtype_id`) and (`prodtype`.`ressource_id` = 1)))) join `prodinput` on((`prodinput`.`prod_id` = `prod`.`id`))) join `prodinputtype` on((`prodinputtype`.`id` = `prodinput`.`prodinputtype_id`))) join `city` `buyer` on(((`buyer`.`location_x` = `prod`.`location_x`) and (`buyer`.`location_y` = `prod`.`location_y`)))) join `demand` on(((`demand`.`city_id` = `buyer`.`id`) and (`demand`.`ressource_id` = `prodinputtype`.`ressource_id`))));
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
