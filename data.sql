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
-- Dumping data for table gigablaster.city: ~1 rows (approximately)
/*!40000 ALTER TABLE `city` DISABLE KEYS */;
INSERT INTO `city` (`id`, `label`, `location_x`, `location_y`) VALUES
	(3, '', 8, 5);
/*!40000 ALTER TABLE `city` ENABLE KEYS */;

-- Dumping data for table gigablaster.demand: ~3 rows (approximately)
/*!40000 ALTER TABLE `demand` DISABLE KEYS */;
INSERT INTO `demand` (`city_id`, `ressource_id`, `percent`, `sold`, `price_modifier`) VALUES
	(3, 4, 1, 0, 5);
INSERT INTO `demand` (`city_id`, `ressource_id`, `percent`, `sold`, `price_modifier`) VALUES
	(3, 13, 1, 0, 5);
INSERT INTO `demand` (`city_id`, `ressource_id`, `percent`, `sold`, `price_modifier`) VALUES
	(3, 14, 1, 0, 5);
/*!40000 ALTER TABLE `demand` ENABLE KEYS */;

-- Dumping data for table gigablaster.entity: ~4 rows (approximately)
/*!40000 ALTER TABLE `entity` DISABLE KEYS */;
INSERT INTO `entity` (`id`, `user_id`, `type_id`, `label`) VALUES
	(7, NULL, 10, NULL);
INSERT INTO `entity` (`id`, `user_id`, `type_id`, `label`) VALUES
	(8, NULL, 10, NULL);
INSERT INTO `entity` (`id`, `user_id`, `type_id`, `label`) VALUES
	(9, NULL, 10, NULL);
INSERT INTO `entity` (`id`, `user_id`, `type_id`, `label`) VALUES
	(103, 1, 2, NULL);
INSERT INTO `entity` (`id`, `user_id`, `type_id`, `label`) VALUES
	(104, 1, 4, NULL);
/*!40000 ALTER TABLE `entity` ENABLE KEYS */;

-- Dumping data for table gigablaster.entitytype: ~12 rows (approximately)
/*!40000 ALTER TABLE `entitytype` DISABLE KEYS */;
INSERT INTO `entitytype` (`id`, `label`, `value_base`) VALUES
	(2, 'wood cutter', 1000);
INSERT INTO `entitytype` (`id`, `label`, `value_base`) VALUES
	(3, 'sawmill', 100);
INSERT INTO `entitytype` (`id`, `label`, `value_base`) VALUES
	(4, 'merchant', 0);
INSERT INTO `entitytype` (`id`, `label`, `value_base`) VALUES
	(5, 'quarry', 1000000000);
INSERT INTO `entitytype` (`id`, `label`, `value_base`) VALUES
	(6, 'workshop', 100);
INSERT INTO `entitytype` (`id`, `label`, `value_base`) VALUES
	(7, 'blacksmith', 100);
INSERT INTO `entitytype` (`id`, `label`, `value_base`) VALUES
	(8, 'farm', 100);
INSERT INTO `entitytype` (`id`, `label`, `value_base`) VALUES
	(9, 'well', 100);
INSERT INTO `entitytype` (`id`, `label`, `value_base`) VALUES
	(10, 'trade route', 0);
INSERT INTO `entitytype` (`id`, `label`, `value_base`) VALUES
	(11, 'windmill', 100);
INSERT INTO `entitytype` (`id`, `label`, `value_base`) VALUES
	(12, 'bakery', 100);
/*!40000 ALTER TABLE `entitytype` ENABLE KEYS */;

-- Dumping data for table gigablaster.entitytype_prodtype_assoc: ~17 rows (approximately)
/*!40000 ALTER TABLE `entitytype_prodtype_assoc` DISABLE KEYS */;
INSERT INTO `entitytype_prodtype_assoc` (`entitytype_id`, `prodtype_id`) VALUES
	(2, 2);
INSERT INTO `entitytype_prodtype_assoc` (`entitytype_id`, `prodtype_id`) VALUES
	(3, 3);
INSERT INTO `entitytype_prodtype_assoc` (`entitytype_id`, `prodtype_id`) VALUES
	(4, 200);
INSERT INTO `entitytype_prodtype_assoc` (`entitytype_id`, `prodtype_id`) VALUES
	(4, 201);
INSERT INTO `entitytype_prodtype_assoc` (`entitytype_id`, `prodtype_id`) VALUES
	(4, 202);
INSERT INTO `entitytype_prodtype_assoc` (`entitytype_id`, `prodtype_id`) VALUES
	(4, 203);
INSERT INTO `entitytype_prodtype_assoc` (`entitytype_id`, `prodtype_id`) VALUES
	(4, 204);
INSERT INTO `entitytype_prodtype_assoc` (`entitytype_id`, `prodtype_id`) VALUES
	(5, 4);
INSERT INTO `entitytype_prodtype_assoc` (`entitytype_id`, `prodtype_id`) VALUES
	(6, 5);
INSERT INTO `entitytype_prodtype_assoc` (`entitytype_id`, `prodtype_id`) VALUES
	(8, 490);
INSERT INTO `entitytype_prodtype_assoc` (`entitytype_id`, `prodtype_id`) VALUES
	(10, 9);
INSERT INTO `entitytype_prodtype_assoc` (`entitytype_id`, `prodtype_id`) VALUES
	(10, 101);
INSERT INTO `entitytype_prodtype_assoc` (`entitytype_id`, `prodtype_id`) VALUES
	(10, 102);
INSERT INTO `entitytype_prodtype_assoc` (`entitytype_id`, `prodtype_id`) VALUES
	(10, 103);
INSERT INTO `entitytype_prodtype_assoc` (`entitytype_id`, `prodtype_id`) VALUES
	(10, 104);
INSERT INTO `entitytype_prodtype_assoc` (`entitytype_id`, `prodtype_id`) VALUES
	(11, 7);
INSERT INTO `entitytype_prodtype_assoc` (`entitytype_id`, `prodtype_id`) VALUES
	(12, 8);
/*!40000 ALTER TABLE `entitytype_prodtype_assoc` ENABLE KEYS */;

-- Dumping data for table gigablaster.entity_location_assoc: ~1 rows (approximately)
/*!40000 ALTER TABLE `entity_location_assoc` DISABLE KEYS */;
INSERT INTO `entity_location_assoc` (`entity_id`, `location_x`, `location_y`) VALUES
	(103, 8, 5);
INSERT INTO `entity_location_assoc` (`entity_id`, `location_x`, `location_y`) VALUES
	(104, 8, 5);
/*!40000 ALTER TABLE `entity_location_assoc` ENABLE KEYS */;

-- Dumping data for table gigablaster.gamestate: ~0 rows (approximately)
/*!40000 ALTER TABLE `gamestate` DISABLE KEYS */;
/*!40000 ALTER TABLE `gamestate` ENABLE KEYS */;

-- Dumping data for table gigablaster.player: ~0 rows (approximately)
/*!40000 ALTER TABLE `player` DISABLE KEYS */;
INSERT INTO `player` (`user_id`, `name`, `credit`, `income`) VALUES
	(1, 'Sir toto', 96875, 15);
INSERT INTO `player` (`user_id`, `name`, `credit`, `income`) VALUES
	(2, 'Mastert itit', 100, 0);
/*!40000 ALTER TABLE `player` ENABLE KEYS */;

-- Dumping data for table gigablaster.population: ~1 rows (approximately)
/*!40000 ALTER TABLE `population` DISABLE KEYS */;
INSERT INTO `population` (`city_id`, `quantity`, `growth`) VALUES
	(3, 10, 0);
/*!40000 ALTER TABLE `population` ENABLE KEYS */;

-- Dumping data for table gigablaster.prod: ~1 rows (approximately)
/*!40000 ALTER TABLE `prod` DISABLE KEYS */;
INSERT INTO `prod` (`id`, `entity_id`, `prodtype_id`, `location_x`, `location_y`, `percent_max`) VALUES
	(51, 103, 2, 8, 5, 1);
INSERT INTO `prod` (`id`, `entity_id`, `prodtype_id`, `location_x`, `location_y`, `percent_max`) VALUES
	(52, 104, 200, 8, 5, 1);
/*!40000 ALTER TABLE `prod` ENABLE KEYS */;

-- Dumping data for table gigablaster.prodinput: ~0 rows (approximately)
/*!40000 ALTER TABLE `prodinput` DISABLE KEYS */;
INSERT INTO `prodinput` (`id`, `prod_id`, `prodinputtype_id`, `location_x`, `location_y`) VALUES
	(52, 51, 4, 8, 5);
INSERT INTO `prodinput` (`id`, `prod_id`, `prodinputtype_id`, `location_x`, `location_y`) VALUES
	(53, 52, 200, 8, 5);
/*!40000 ALTER TABLE `prodinput` ENABLE KEYS */;

-- Dumping data for table gigablaster.prodinputtype: ~14 rows (approximately)
/*!40000 ALTER TABLE `prodinputtype` DISABLE KEYS */;
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(3, 14, 1, NULL);
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(4, 34, 1, 'forest');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(5, 49, 1, 'wheat to floor');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(6, 50, 1, 'floor to bread');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(7, 4, 1, 'transport: wood');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(8, 4, 1, 'sell : wood');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(101, 5, 1, 'transport: plank');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(102, 49, 1, 'transport: wheat');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(103, 50, 1, 'transport: floor');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(104, 51, 1, 'transport: bread');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(200, 4, 1, 'sell: wood');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(201, 5, 1, 'sell: plank');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(202, 49, 1, 'sell: wheat');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(203, 50, 1, 'sell: floor');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(204, 51, 1, 'sell: bread');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(330, 33, 1, 'field to wheat');
/*!40000 ALTER TABLE `prodinputtype` ENABLE KEYS */;

-- Dumping data for table gigablaster.prodtype: ~17 rows (approximately)
/*!40000 ALTER TABLE `prodtype` DISABLE KEYS */;
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(2, 4, 1, 'pinewood cuter');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(3, 5, 1, 'pinewood saw');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(4, 14, 1, 'stone');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(5, 13, 1, 'tool');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(7, 50, 1, 'whet to floor');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(8, 51, 1, 'floor to bread');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(9, 4, 1, 'transport: pinewood');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(101, 5, 1, 'transport: pinewood plank');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(102, 49, 1, 'transport: wheat');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(103, 50, 1, 'transport: floor');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(104, 51, 1, 'transport: bread');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(200, 1, 1, 'sell: pinewood');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(201, 1, 1, 'sell: plank');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(202, 1, 1, 'sell: wheat');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(203, 1, 1, 'sell: floor');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(204, 1, 1, 'sell: bread');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(490, 49, 1, 'field to wheat');
/*!40000 ALTER TABLE `prodtype` ENABLE KEYS */;

-- Dumping data for table gigablaster.prodtype_prodinputtype_assoc: ~17 rows (approximately)
/*!40000 ALTER TABLE `prodtype_prodinputtype_assoc` DISABLE KEYS */;
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(2, 4);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(3, 2);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(5, 2);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(6, 4);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(7, 5);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(7, 9);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(8, 6);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(9, 7);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(10, 8);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(11, 9);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(101, 101);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(102, 102);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(103, 103);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(104, 104);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(200, 200);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(201, 201);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(202, 202);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(203, 203);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(204, 204);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(490, 330);
/*!40000 ALTER TABLE `prodtype_prodinputtype_assoc` ENABLE KEYS */;

-- Dumping data for table gigablaster.rescategory: ~10 rows (approximately)
/*!40000 ALTER TABLE `rescategory` DISABLE KEYS */;
INSERT INTO `rescategory` (`id`, `label`) VALUES
	(3, 'advance');
INSERT INTO `rescategory` (`id`, `label`) VALUES
	(2, 'basic');
INSERT INTO `rescategory` (`id`, `label`) VALUES
	(5, 'basic food');
INSERT INTO `rescategory` (`id`, `label`) VALUES
	(1, 'essential');
INSERT INTO `rescategory` (`id`, `label`) VALUES
	(10, 'inessential');
INSERT INTO `rescategory` (`id`, `label`) VALUES
	(4, 'luxury');
INSERT INTO `rescategory` (`id`, `label`) VALUES
	(8, 'metal bar');
INSERT INTO `rescategory` (`id`, `label`) VALUES
	(7, 'ore');
INSERT INTO `rescategory` (`id`, `label`) VALUES
	(11, 'special');
INSERT INTO `rescategory` (`id`, `label`) VALUES
	(6, 'stone');
/*!40000 ALTER TABLE `rescategory` ENABLE KEYS */;

-- Dumping data for table gigablaster.ressource: ~57 rows (approximately)
/*!40000 ALTER TABLE `ressource` DISABLE KEYS */;
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(1, 'Credit(sell/buy)', 1, 0);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(4, 'pinewood', 1, 0);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(5, 'pinewood plank', 2, 0);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(13, 'tool', 1, 0);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(14, 'stone', 1, 0);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(15, 'Marble', 1, 0);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(16, 'Granite', 1, 0);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(20, 'Bows', 1, 0);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(33, 'field', 0, 1);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(34, 'forest', 0, 1);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(35, 'fresh water', 0, 1);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(36, 'salt water', 0, 1);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(37, 'stone deposit', 0, 1);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(38, 'marble deposit', 0, 1);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(39, 'granite deposit', 0, 1);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(40, 'limestone deposit', 0, 1);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(41, 'sandstone deposit', 0, 1);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(42, 'copper deposit', 0, 1);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(43, 'tin deposit', 0, 1);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(44, 'iron deposit', 0, 1);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(45, 'coal deposit', 0, 1);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(46, 'wool', 1, 0);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(47, 'cloth', 1, 0);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(48, 'clothing', 1, 0);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(49, 'wheat', 1, 0);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(50, 'floor', 2, 0);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(51, 'bread', 4, 0);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(100, 'meat', 1, 0);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(101, 'soap', 1, 0);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(102, 'fish', 1, 0);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(103, 'honey', 1, 0);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(104, 'paper', 1, 0);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(105, 'book', 1, 0);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(106, 'sugar', 1, 0);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(107, 'candy', 1, 0);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(108, 'crate', 1, 0);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(109, 'painting', 1, 0);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(110, 'sword', 1, 0);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(111, 'jewelry', 1, 0);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(112, 'medecinal herb', 1, 0);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(113, 'medicine', 1, 0);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(114, 'crustaceans', 1, 0);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(115, 'fruit', 1, 0);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(116, 'vegetable', 1, 0);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(117, 'housing', 1, 0);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(200, 'coal', 1, 0);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(201, 'copper ore', 1, 0);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(202, 'copper bar', 2, 0);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(203, 'tin ore', 1, 0);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(204, 'tin bar', 1, 0);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(205, 'bronze bar', 1, 0);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(206, 'iron ore', 1, 0);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(207, 'iron bar', 1, 0);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(208, 'steel bar', 1, 0);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(209, 'silver ore', 1, 0);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(210, 'silver bar', 1, 0);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(211, 'gold ore', 5, 0);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(212, 'gold bar', 10, 0);
/*!40000 ALTER TABLE `ressource` ENABLE KEYS */;

-- Dumping data for table gigablaster.ressource_rescategory: ~18 rows (approximately)
/*!40000 ALTER TABLE `ressource_rescategory` DISABLE KEYS */;
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(1, 13);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(1, 48);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(1, 117);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(4, 109);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(4, 111);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(5, 51);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(5, 100);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(5, 102);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(5, 114);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(5, 115);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(5, 116);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(10, 101);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(10, 103);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(10, 105);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(10, 107);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(10, 113);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(11, 108);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(11, 110);
/*!40000 ALTER TABLE `ressource_rescategory` ENABLE KEYS */;

-- Dumping data for table gigablaster.user: ~2 rows (approximately)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `player_name`, `email`, `password_shadow`) VALUES
	(1, 'Toto', 'toto@gmail.com', '$2y$12$905JS5gAdmNS.c5VM10ksObhf9sBsWDnl8opgKS6kBJlZ6qxyPIPS');
INSERT INTO `user` (`id`, `player_name`, `email`, `password_shadow`) VALUES
	(2, 'Titi', 'titi@gmail.com', '$2y$12$905JS5gAdmNS.c5VM10ksObhf9sBsWDnl8opgKS6kBJlZ6qxyPIPS');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

-- Dumping data for table gigablaster._view_note: 1 rows
/*!40000 ALTER TABLE `_view_note` DISABLE KEYS */;
INSERT INTO `_view_note` (`formated`) VALUES
	('SELECT \r\n	seller.id AS seller_id,\r\n	buyer.id AS buyer_id,\r\n	prodinputtype.ressource_id AS ressource_id,\r\n	prodinputtype.quantity AS quantity\r\nFROM player\r\nJOIN entity AS seller ON seller.user_id = player.user_id\r\nJOIN prod ON prod.entity_id = seller.id\r\nJOIN prodtype ON prodtype.id = prod.prodtype_id \r\n	AND prodtype.ressource_id = 1/*Credit*/\r\nJOIN prodinput ON prodinput.prod_id = prod.id\r\nJOIN prodinputtype ON prodinputtype.id = prodinput.prodinputtype_id\r\nJOIN city as buyer \r\n	ON buyer.location_x = prod.location_x \r\n	AND buyer.location_y = prod.location_y');
/*!40000 ALTER TABLE `_view_note` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
