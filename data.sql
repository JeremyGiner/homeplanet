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
-- Dumping data for table gigablaster.city: ~0 rows (approximately)
/*!40000 ALTER TABLE `city` DISABLE KEYS */;
/*!40000 ALTER TABLE `city` ENABLE KEYS */;

-- Dumping data for table gigablaster.demand: ~0 rows (approximately)
/*!40000 ALTER TABLE `demand` DISABLE KEYS */;
/*!40000 ALTER TABLE `demand` ENABLE KEYS */;

-- Dumping data for table gigablaster.gamestate: ~0 rows (approximately)
/*!40000 ALTER TABLE `gamestate` DISABLE KEYS */;
/*!40000 ALTER TABLE `gamestate` ENABLE KEYS */;

-- Dumping data for table gigablaster.influencemodifier: ~0 rows (approximately)
/*!40000 ALTER TABLE `influencemodifier` DISABLE KEYS */;
/*!40000 ALTER TABLE `influencemodifier` ENABLE KEYS */;

-- Dumping data for table gigablaster.influencetype: ~2 rows (approximately)
/*!40000 ALTER TABLE `influencetype` DISABLE KEYS */;
INSERT INTO `influencetype` (`id`, `label`, `value`) VALUES
	(1, 'economic', 10);
INSERT INTO `influencetype` (`id`, `label`, `value`) VALUES
	(2, 'politic', 10);
INSERT INTO `influencetype` (`id`, `label`, `value`) VALUES
	(3, 'military', 1);
INSERT INTO `influencetype` (`id`, `label`, `value`) VALUES
	(4, 'provider', 1);
/*!40000 ALTER TABLE `influencetype` ENABLE KEYS */;

-- Dumping data for table gigablaster.pawn: ~0 rows (approximately)
/*!40000 ALTER TABLE `pawn` DISABLE KEYS */;
/*!40000 ALTER TABLE `pawn` ENABLE KEYS */;

-- Dumping data for table gigablaster.pawntype: ~12 rows (approximately)
/*!40000 ALTER TABLE `pawntype` DISABLE KEYS */;
INSERT INTO `pawntype` (`id`, `label`, `value_base`) VALUES
	(2, 'wood cutter', 1000);
INSERT INTO `pawntype` (`id`, `label`, `value_base`) VALUES
	(3, 'sawmill', 100);
INSERT INTO `pawntype` (`id`, `label`, `value_base`) VALUES
	(4, 'merchant', 0);
INSERT INTO `pawntype` (`id`, `label`, `value_base`) VALUES
	(5, 'quarry', 1000000000);
INSERT INTO `pawntype` (`id`, `label`, `value_base`) VALUES
	(6, 'workshop', 100);
INSERT INTO `pawntype` (`id`, `label`, `value_base`) VALUES
	(7, 'blacksmith', 100);
INSERT INTO `pawntype` (`id`, `label`, `value_base`) VALUES
	(8, 'farm', 100);
INSERT INTO `pawntype` (`id`, `label`, `value_base`) VALUES
	(10, 'trade route', 0);
INSERT INTO `pawntype` (`id`, `label`, `value_base`) VALUES
	(11, 'windmill', 100);
INSERT INTO `pawntype` (`id`, `label`, `value_base`) VALUES
	(12, 'bakery', 100);
INSERT INTO `pawntype` (`id`, `label`, `value_base`) VALUES
	(20, 'mine', 100);
INSERT INTO `pawntype` (`id`, `label`, `value_base`) VALUES
	(21, 'smelter', 100);
/*!40000 ALTER TABLE `pawntype` ENABLE KEYS */;

-- Dumping data for table gigablaster.pawntype_prodtype_assoc: ~20 rows (approximately)
/*!40000 ALTER TABLE `pawntype_prodtype_assoc` DISABLE KEYS */;
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2, 2);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(3, 3);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(4, 200);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(4, 201);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(4, 202);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(4, 203);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(4, 204);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(5, 140);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(6, 5);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(8, 81);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(8, 490);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(10, 9);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(10, 101);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(10, 102);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(10, 103);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(10, 104);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(11, 7);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(12, 8);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(20, 10);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(21, 11);
/*!40000 ALTER TABLE `pawntype_prodtype_assoc` ENABLE KEYS */;

-- Dumping data for table gigablaster.pawn_location_assoc: ~0 rows (approximately)
/*!40000 ALTER TABLE `pawn_location_assoc` DISABLE KEYS */;
/*!40000 ALTER TABLE `pawn_location_assoc` ENABLE KEYS */;

-- Dumping data for table gigablaster.player: ~2 rows (approximately)
/*!40000 ALTER TABLE `player` DISABLE KEYS */;
INSERT INTO `player` (`user_id`, `id`, `name`, `credit`, `income`, `cart`) VALUES
	(1, 1, 'Sir toto', 700, 0, 3);
INSERT INTO `player` (`user_id`, `id`, `name`, `credit`, `income`, `cart`) VALUES
	(2, 2, 'Mastert itit', 100, 0, 5);
/*!40000 ALTER TABLE `player` ENABLE KEYS */;

-- Dumping data for table gigablaster.population: ~0 rows (approximately)
/*!40000 ALTER TABLE `population` DISABLE KEYS */;
/*!40000 ALTER TABLE `population` ENABLE KEYS */;

-- Dumping data for table gigablaster.prod: ~0 rows (approximately)
/*!40000 ALTER TABLE `prod` DISABLE KEYS */;
/*!40000 ALTER TABLE `prod` ENABLE KEYS */;

-- Dumping data for table gigablaster.prodinput: ~0 rows (approximately)
/*!40000 ALTER TABLE `prodinput` DISABLE KEYS */;
/*!40000 ALTER TABLE `prodinput` ENABLE KEYS */;

-- Dumping data for table gigablaster.prodinputtype: ~21 rows (approximately)
/*!40000 ALTER TABLE `prodinputtype` DISABLE KEYS */;
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(2, 4, 1, 'wood to plank');
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
	(8, 44, 1, 'iron deposit to ore');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(9, 206, 1, 'iron ore to bar');
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
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(333, 207, 1, 'iron bar to tool');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(810, 33, 1, 'field to vegetable');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(1400, 37, 1, 'stone deposit');
/*!40000 ALTER TABLE `prodinputtype` ENABLE KEYS */;

-- Dumping data for table gigablaster.prodtype: ~20 rows (approximately)
/*!40000 ALTER TABLE `prodtype` DISABLE KEYS */;
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(2, 4, 1, 'pinewood cuter');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(3, 5, 1, 'pinewood saw');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(5, 13, 1, 'tool');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(7, 50, 1, 'whet to floor');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(8, 51, 1, 'floor to bread');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(9, 4, 1, 'transport: pinewood');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(10, 206, 1, 'iron deposit to ore');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(11, 207, 1, 'iron ore to bar');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(101, 5, 1, 'transport: pinewood plank');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(102, 49, 1, 'transport: wheat');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(103, 50, 1, 'transport: floor');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(104, 51, 1, 'transport: bread');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(140, 14, 1, 'stone');
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
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(1160, 116, 1, 'field to vegetable');
/*!40000 ALTER TABLE `prodtype` ENABLE KEYS */;

-- Dumping data for table gigablaster.prodtype_prodinputtype_assoc: ~22 rows (approximately)
/*!40000 ALTER TABLE `prodtype_prodinputtype_assoc` DISABLE KEYS */;
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(2, 4);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(3, 2);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(5, 2);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(5, 333);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(6, 4);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(7, 5);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(8, 6);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(9, 7);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(10, 8);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(11, 9);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(81, 810);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(101, 101);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(102, 102);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(103, 103);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(104, 104);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(140, 1400);
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

-- Dumping data for table gigablaster.relationshipmodifier: ~2 rows (approximately)
/*!40000 ALTER TABLE `relationshipmodifier` DISABLE KEYS */;
/*!40000 ALTER TABLE `relationshipmodifier` ENABLE KEYS */;

-- Dumping data for table gigablaster.relationshiptype: 1 rows
/*!40000 ALTER TABLE `relationshiptype` DISABLE KEYS */;
INSERT INTO `relationshiptype` (`id`, `label`, `description`, `value`) VALUES
	(1, 'gift', 'Sovereign have been given a gift.', 10);
/*!40000 ALTER TABLE `relationshiptype` ENABLE KEYS */;

-- Dumping data for table gigablaster.rescategory: ~10 rows (approximately)
/*!40000 ALTER TABLE `rescategory` DISABLE KEYS */;
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
	(12, 'natural');
INSERT INTO `rescategory` (`id`, `label`) VALUES
	(7, 'ore');
INSERT INTO `rescategory` (`id`, `label`) VALUES
	(11, 'special');
INSERT INTO `rescategory` (`id`, `label`) VALUES
	(6, 'stone');
INSERT INTO `rescategory` (`id`, `label`) VALUES
	(13, 'tradable');
/*!40000 ALTER TABLE `rescategory` ENABLE KEYS */;

-- Dumping data for table gigablaster.ressource: ~57 rows (approximately)
/*!40000 ALTER TABLE `ressource` DISABLE KEYS */;
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(1, 'Credit(sell/buy)', 1, 0);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(4, 'wood', 1, 0);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(5, 'wood plank', 2, 0);
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
	(35, 'fish deposit', 0, 1);
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
	(45, 'gold deposit', 0, 1);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(46, 'wool', 1, 0);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(47, 'cloth', 1, 0);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(48, 'outfit', 1, 0);
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
	(107, 'toy', 1, 0);
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
	(118, 'furniture', 1, 0);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(119, 'salt', 1, 0);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(120, 'horse', 1, 0);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(121, 'watch', 1, 0);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`) VALUES
	(122, 'delicacy', 1, 0);
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

-- Dumping data for table gigablaster.ressource_rescategory: ~76 rows (approximately)
/*!40000 ALTER TABLE `ressource_rescategory` DISABLE KEYS */;
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(1, 13);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(1, 48);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(1, 113);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(1, 117);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(1, 118);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(1, 120);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(4, 109);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(4, 111);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(4, 121);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(4, 122);
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
	(11, 108);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(11, 110);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(12, 33);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(12, 34);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(12, 35);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(12, 36);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(12, 37);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(12, 38);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(12, 39);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(12, 40);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(12, 41);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(12, 42);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(12, 43);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(12, 44);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(12, 45);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 4);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 5);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 13);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 14);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 16);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 46);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 47);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 48);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 49);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 50);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 51);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 100);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 101);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 102);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 103);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 104);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 105);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 106);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 107);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 108);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 109);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 110);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 111);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 112);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 113);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 114);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 115);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 116);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 117);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 118);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 120);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 121);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 122);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 206);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 207);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 209);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 210);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 211);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 212);
/*!40000 ALTER TABLE `ressource_rescategory` ENABLE KEYS */;

-- Dumping data for table gigablaster.sovereign: ~3 rows (approximately)
/*!40000 ALTER TABLE `sovereign` DISABLE KEYS */;
/*!40000 ALTER TABLE `sovereign` ENABLE KEYS */;

-- Dumping data for table gigablaster.user: ~2 rows (approximately)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `player_name`, `email`, `password_shadow`) VALUES
	(1, 'Toto', 'toto@gmail.com', '$2y$12$905JS5gAdmNS.c5VM10ksObhf9sBsWDnl8opgKS6kBJlZ6qxyPIPS');
INSERT INTO `user` (`id`, `player_name`, `email`, `password_shadow`) VALUES
	(2, 'Titi', 'titi@gmail.com', '$2y$12$905JS5gAdmNS.c5VM10ksObhf9sBsWDnl8opgKS6kBJlZ6qxyPIPS');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

-- Dumping data for table gigablaster._view_note: 7 rows
/*!40000 ALTER TABLE `_view_note` DISABLE KEYS */;
INSERT INTO `_view_note` (`view_name`, `formated`) VALUES
	('sold', 'SELECT \r\n	seller.id AS seller_id,\r\n	buyer.id AS buyer_id,\r\n	prodinputtype.ressource_id AS ressource_id,\r\n	FLOOR( prodinputtype.quantity\r\n	* prod.percent_max ) AS quantity\r\nFROM player\r\nJOIN pawn AS seller ON seller.player_id = player.id\r\nJOIN prod ON prod.pawn_id = seller.id\r\nJOIN prodtype \r\n	ON prodtype.id = prod.prodtype_id \r\n	AND prodtype.ressource_id = 1/*Credit*/\r\nJOIN prodinput ON prodinput.prod_id = prod.id\r\nJOIN prodinputtype ON prodinputtype.id = prodinput.prodinputtype_id\r\nJOIN city as buyer \r\n	ON buyer.location_x = prod.location_x \r\n	AND buyer.location_y = prod.location_y\r\nJOIN demand \r\n	ON demand.city_id = buyer.id\r\n	AND demand.ressource_id = prodinputtype.ressource_id');
INSERT INTO `_view_note` (`view_name`, `formated`) VALUES
	('player_ext', 'SELECT * \r\nFROM (\r\n	SELECT \r\n		player.id as player_id,\r\n		IFNULL(SUM(pawn.`level`), 0) as cart_used\r\n	FROM player\r\n	LEFT JOIN pawn ON pawn.player_id = player.id\r\n		AND pawn.type_id = 10 #transport\r\n	GROUP BY player.id\r\n) t_cart');
INSERT INTO `_view_note` (`view_name`, `formated`) VALUES
	('city_distance', 'SELECT \r\n	c0.id as city0_id,\r\n	c1.id as city1_id,\r\n	abs(c1.location_x - c0.location_x)\r\n	+abs(c1.location_y - c0.location_y) as dist\r\nFROM city as c0\r\nLEFT JOIN city as c1 ON c1.id != c0.id\r\n');
INSERT INTO `_view_note` (`view_name`, `formated`) VALUES
	('relationship', 'SELECT \r\n	*\r\nFROM relationshipmodifier');
INSERT INTO `_view_note` (`view_name`, `formated`) VALUES
	('influence_relationship', 'SELECT \r\n	city.id as city_id,\r\n	relationship.sovereign_id,\r\n	SUM(sold.quantity) as value\r\nFROM city\r\nJOIN sold ON sold.buyer_id = city.id\r\nJOIN pawn ON pawn.id = sold.seller_id\r\nJOIN relationship ON relationship.player_id = pawn.player_id\r\nGROUP BY city.id, relationship.sovereign_id');
INSERT INTO `_view_note` (`view_name`, `formated`) VALUES
	('influence', '	SELECT \r\n		influencemodifier.city_id,\r\n		influencemodifier.sovereign_id,\r\n		influencemodifier.type_id,\r\n		influencemodifier.value\r\n	FROM influencemodifier\r\nUNION\r\n	SELECT\r\n		influence_relationship.city_id,\r\n		influence_relationship.sovereign_id,\r\n		4, #provider\r\n		influence_relationship.value\r\n	FROM influence_relationship');
INSERT INTO `_view_note` (`view_name`, `formated`) VALUES
	('city_sovereign', 'SELECT \r\n	`t`.`city_id` AS `city_id`,\r\n	MIN(`t`.`sovereign_id`) AS `sovereign_id`,\r\n	`t`.`sum_value` AS `sum_value` \r\nFROM `gigablaster`.`influence_sum` `t` \r\nJOIN (\r\n	SELECT \r\n		`influence_sum`.`city_id` AS `city_id`,\r\n		MAX(`influence_sum`.`sum_value`) AS `max_value` \r\n	FROM `gigablaster`.`influence_sum` \r\n	GROUP BY `influence_sum`.`city_id`\r\n) `tmax` \r\n	ON `tmax`.`city_id` = `t`.`city_id`\r\n	AND `t`.`sum_value` = `tmax`.`max_value`\r\nGROUP BY `t`.`city_id`');
/*!40000 ALTER TABLE `_view_note` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
