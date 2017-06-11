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

-- Dumping data for table gigablaster.demand: ~22 rows (approximately)
/*!40000 ALTER TABLE `demand` DISABLE KEYS */;
/*!40000 ALTER TABLE `demand` ENABLE KEYS */;

-- Dumping data for table gigablaster.event: ~0 rows (approximately)
/*!40000 ALTER TABLE `event` DISABLE KEYS */;
/*!40000 ALTER TABLE `event` ENABLE KEYS */;

-- Dumping data for table gigablaster.gamestate: ~0 rows (approximately)
/*!40000 ALTER TABLE `gamestate` DISABLE KEYS */;
/*!40000 ALTER TABLE `gamestate` ENABLE KEYS */;

-- Dumping data for table gigablaster.influencemodifier: ~2 rows (approximately)
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

-- Dumping data for table gigablaster.notification: ~0 rows (approximately)
/*!40000 ALTER TABLE `notification` DISABLE KEYS */;
/*!40000 ALTER TABLE `notification` ENABLE KEYS */;

-- Dumping data for table gigablaster.pawn: ~8 rows (approximately)
/*!40000 ALTER TABLE `pawn` DISABLE KEYS */;
/*!40000 ALTER TABLE `pawn` ENABLE KEYS */;

-- Dumping data for table gigablaster.pawntype: ~26 rows (approximately)
/*!40000 ALTER TABLE `pawntype` DISABLE KEYS */;
INSERT INTO `pawntype` (`id`, `category_id`, `label`, `value_base`, `description`) VALUES
	(1, 1, 'farm', 100, 'Produce wheats, honey, fruits and vegetables');
INSERT INTO `pawntype` (`id`, `category_id`, `label`, `value_base`, `description`) VALUES
	(2, 1, 'wood cutter', 100, 'Produce wood log');
INSERT INTO `pawntype` (`id`, `category_id`, `label`, `value_base`, `description`) VALUES
	(3, 1, 'mine', 100, 'Produce iron and gold');
INSERT INTO `pawntype` (`id`, `category_id`, `label`, `value_base`, `description`) VALUES
	(5, 1, 'quarry', 1000000000, 'Produce stone');
INSERT INTO `pawntype` (`id`, `category_id`, `label`, `value_base`, `description`) VALUES
	(6, 1, 'hunting camp', 100, 'Produce meat');
INSERT INTO `pawntype` (`id`, `category_id`, `label`, `value_base`, `description`) VALUES
	(7, 1, 'fishing boat', 100, 'Produce fish and crustacean');
INSERT INTO `pawntype` (`id`, `category_id`, `label`, `value_base`, `description`) VALUES
	(8, 1, 'herb collector', 1000000000, NULL);
INSERT INTO `pawntype` (`id`, `category_id`, `label`, `value_base`, `description`) VALUES
	(30, 1, 'restaurant', 100, 'Produce delicacy and sell food');
INSERT INTO `pawntype` (`id`, `category_id`, `label`, `value_base`, `description`) VALUES
	(100, 2, 'sawmill', 100, 'Produce wood plank');
INSERT INTO `pawntype` (`id`, `category_id`, `label`, `value_base`, `description`) VALUES
	(101, 2, 'windmill', 100, 'Produce floor');
INSERT INTO `pawntype` (`id`, `category_id`, `label`, `value_base`, `description`) VALUES
	(103, 2, 'smelter', 100, 'Smelt and refine metals');
INSERT INTO `pawntype` (`id`, `category_id`, `label`, `value_base`, `description`) VALUES
	(200, 3, 'bakery', 100, 'Produce bread and delicacy');
INSERT INTO `pawntype` (`id`, `category_id`, `label`, `value_base`, `description`) VALUES
	(201, 3, 'blacksmith', 100, 'Produce sword');
INSERT INTO `pawntype` (`id`, `category_id`, `label`, `value_base`, `description`) VALUES
	(202, 3, 'art workshop', 100, 'Produce jewelry, painting and watch');
INSERT INTO `pawntype` (`id`, `category_id`, `label`, `value_base`, `description`) VALUES
	(203, 3, 'stable', 100, 'Produce horse');
INSERT INTO `pawntype` (`id`, `category_id`, `label`, `value_base`, `description`) VALUES
	(204, 3, 'apothecary', 100, 'Produce medicine and soap');
INSERT INTO `pawntype` (`id`, `category_id`, `label`, `value_base`, `description`) VALUES
	(205, 3, 'tailor', 100, 'Produce outfit');
INSERT INTO `pawntype` (`id`, `category_id`, `label`, `value_base`, `description`) VALUES
	(206, 3, 'workshop', 100, 'Produce tools, books and toys');
INSERT INTO `pawntype` (`id`, `category_id`, `label`, `value_base`, `description`) VALUES
	(207, 3, 'carpenter', 100, 'Produce furniture');
INSERT INTO `pawntype` (`id`, `category_id`, `label`, `value_base`, `description`) VALUES
	(208, 3, 'building crew', 100, 'Produce housing');
INSERT INTO `pawntype` (`id`, `category_id`, `label`, `value_base`, `description`) VALUES
	(209, 3, 'bookbinder', 100, 'Produce book');
INSERT INTO `pawntype` (`id`, `category_id`, `label`, `value_base`, `description`) VALUES
	(1000, 4, 'cart', 0, 'A basic mean of transportation for resources.');
INSERT INTO `pawntype` (`id`, `category_id`, `label`, `value_base`, `description`) VALUES
	(1001, 4, 'wagon', 100, 'A four-wheeled vehicle pulled by draught animals.\r\nCan carry ressources further away than a cart.');
INSERT INTO `pawntype` (`id`, `category_id`, `label`, `value_base`, `description`) VALUES
	(1002, 4, 'boat', 200, 'A sailing vessel that carries ressources across sea and rivers.');
INSERT INTO `pawntype` (`id`, `category_id`, `label`, `value_base`, `description`) VALUES
	(2000, 5, 'traveling merchant', 100, 'A merchant able to sell and buy a wide variety of ressources in small quantity.\r\nIn addition he is also able to travel from town to town.');
INSERT INTO `pawntype` (`id`, `category_id`, `label`, `value_base`, `description`) VALUES
	(2001, 5, 'market stall', 100, 'A merchant able to sell end product.');
/*!40000 ALTER TABLE `pawntype` ENABLE KEYS */;

-- Dumping data for table gigablaster.pawntypecategory: ~5 rows (approximately)
/*!40000 ALTER TABLE `pawntypecategory` DISABLE KEYS */;
INSERT INTO `pawntypecategory` (`id`, `label`) VALUES
	(1, 'tech zero');
INSERT INTO `pawntypecategory` (`id`, `label`) VALUES
	(2, 'tech one');
INSERT INTO `pawntypecategory` (`id`, `label`) VALUES
	(3, 'tech three');
INSERT INTO `pawntypecategory` (`id`, `label`) VALUES
	(4, 'transporter');
INSERT INTO `pawntypecategory` (`id`, `label`) VALUES
	(5, 'merchant');
/*!40000 ALTER TABLE `pawntypecategory` ENABLE KEYS */;

-- Dumping data for table gigablaster.pawntype_prodtype_assoc: ~289 rows (approximately)
/*!40000 ALTER TABLE `pawntype_prodtype_assoc` DISABLE KEYS */;
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1, 1002);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(101, 1003);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2, 1004);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(100, 1005);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(203, 1006);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(205, 1007);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(3, 1008);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(103, 1009);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(3, 1010);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(103, 1011);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(5, 1012);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(8, 1014);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(200, 1100);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(6, 1101);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(7, 1102);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1, 1103);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1, 1104);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(206, 1110);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(205, 1111);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(204, 1112);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(208, 1113);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(207, 1115);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(203, 1116);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(209, 1122);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(206, 1123);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(200, 1130);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(202, 1131);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(202, 1132);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(202, 1133);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(201, 1141);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 2002);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 2002);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 2003);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 2003);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 2004);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 2004);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 2005);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 2005);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 2006);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 2006);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 2007);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 2007);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 2008);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 2008);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 2009);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 2009);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 2010);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 2010);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 2011);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 2011);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 2012);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 2012);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 2013);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 2013);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 2014);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 2014);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 2033);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 2033);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 2034);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 2034);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 2100);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 2100);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 2101);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 2101);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 2102);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 2102);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 2103);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 2103);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 2104);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 2104);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 2105);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 2105);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 2110);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 2110);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 2111);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 2111);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 2112);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 2112);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 2113);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 2113);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 2115);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 2115);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 2116);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 2116);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 2120);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 2120);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 2121);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 2121);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 2122);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 2122);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 2123);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 2123);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 2130);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 2130);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 2131);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 2131);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 2132);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 2132);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 2133);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 2133);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 2140);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 2140);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 2141);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 2141);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 3002);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 3002);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 3003);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 3003);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 3004);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 3004);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 3005);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 3005);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 3006);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 3006);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 3007);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 3007);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 3008);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 3008);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 3009);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 3009);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 3010);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 3010);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 3011);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 3011);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 3012);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 3012);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 3013);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 3013);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 3014);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 3014);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 3033);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 3033);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 3034);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 3034);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 3100);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 3100);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 3101);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 3101);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 3102);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 3102);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 3103);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 3103);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 3104);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 3104);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 3105);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 3105);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 3110);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 3110);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 3111);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 3111);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 3112);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 3112);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 3113);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 3113);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 3115);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 3115);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 3116);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 3116);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 3120);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 3120);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 3121);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 3121);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 3122);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 3122);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 3123);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 3123);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 3130);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 3130);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 3131);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 3131);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 3132);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 3132);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 3133);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 3133);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 3140);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 3140);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2000, 3141);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(2001, 3141);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1000, 4002);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1001, 4002);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1002, 4002);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1000, 4003);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1001, 4003);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1002, 4003);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1000, 4004);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1001, 4004);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1002, 4004);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1000, 4005);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1001, 4005);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1002, 4005);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1000, 4006);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1001, 4006);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1002, 4006);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1000, 4007);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1001, 4007);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1002, 4007);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1000, 4008);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1001, 4008);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1002, 4008);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1000, 4009);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1001, 4009);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1002, 4009);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1000, 4010);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1001, 4010);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1002, 4010);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1000, 4011);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1001, 4011);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1002, 4011);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1000, 4012);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1001, 4012);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1002, 4012);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1000, 4013);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1001, 4013);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1002, 4013);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1000, 4014);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1001, 4014);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1002, 4014);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1000, 4033);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1001, 4033);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1002, 4033);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1000, 4034);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1001, 4034);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1002, 4034);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1000, 4100);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1001, 4100);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1002, 4100);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1000, 4101);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1001, 4101);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1002, 4101);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1000, 4102);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1001, 4102);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1002, 4102);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1000, 4103);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1001, 4103);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1002, 4103);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1000, 4104);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1001, 4104);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1002, 4104);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1000, 4105);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1001, 4105);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1002, 4105);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1000, 4110);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1001, 4110);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1002, 4110);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1000, 4111);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1001, 4111);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1002, 4111);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1000, 4112);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1001, 4112);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1002, 4112);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1000, 4113);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1001, 4113);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1002, 4113);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1000, 4115);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1001, 4115);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1002, 4115);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1000, 4116);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1001, 4116);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1002, 4116);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1000, 4120);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1001, 4120);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1002, 4120);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1000, 4121);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1001, 4121);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1002, 4121);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1000, 4122);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1001, 4122);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1002, 4122);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1000, 4123);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1001, 4123);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1002, 4123);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1000, 4130);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1001, 4130);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1002, 4130);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1000, 4131);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1001, 4131);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1002, 4131);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1000, 4132);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1001, 4132);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1002, 4132);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1000, 4133);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1001, 4133);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1002, 4133);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1000, 4140);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1001, 4140);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1002, 4140);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1000, 4141);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1001, 4141);
INSERT INTO `pawntype_prodtype_assoc` (`pawntype_id`, `prodtype_id`) VALUES
	(1002, 4141);
/*!40000 ALTER TABLE `pawntype_prodtype_assoc` ENABLE KEYS */;

-- Dumping data for table gigablaster.pawn_location_assoc: ~8 rows (approximately)
/*!40000 ALTER TABLE `pawn_location_assoc` DISABLE KEYS */;
/*!40000 ALTER TABLE `pawn_location_assoc` ENABLE KEYS */;

-- Dumping data for table gigablaster.player: ~3 rows (approximately)
/*!40000 ALTER TABLE `player` DISABLE KEYS */;
INSERT INTO `player` (`user_id`, `id`, `name`, `credit`, `income`, `cart`) VALUES
	(1, 1, 'Lord toto', 10680, 0, 1);
INSERT INTO `player` (`user_id`, `id`, `name`, `credit`, `income`, `cart`) VALUES
	(2, 2, 'Mastert itit', 100, 0, 5);
INSERT INTO `player` (`user_id`, `id`, `name`, `credit`, `income`, `cart`) VALUES
	(4, 5, 'test', 100, 0, 1);
/*!40000 ALTER TABLE `player` ENABLE KEYS */;

-- Dumping data for table gigablaster.population: ~0 rows (approximately)
/*!40000 ALTER TABLE `population` DISABLE KEYS */;
/*!40000 ALTER TABLE `population` ENABLE KEYS */;

-- Dumping data for table gigablaster.post: 0 rows
/*!40000 ALTER TABLE `post` DISABLE KEYS */;
/*!40000 ALTER TABLE `post` ENABLE KEYS */;

-- Dumping data for table gigablaster.prod: ~7 rows (approximately)
/*!40000 ALTER TABLE `prod` DISABLE KEYS */;
/*!40000 ALTER TABLE `prod` ENABLE KEYS */;

-- Dumping data for table gigablaster.prodinput: ~7 rows (approximately)
/*!40000 ALTER TABLE `prodinput` DISABLE KEYS */;
/*!40000 ALTER TABLE `prodinput` ENABLE KEYS */;

-- Dumping data for table gigablaster.prodinputtype: ~192 rows (approximately)
/*!40000 ALTER TABLE `prodinputtype` DISABLE KEYS */;
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(2, 4, 1, 'wood to plank');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(3, 12, 1, NULL);
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(4, 34, 1, 'forest');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(5, 2, 1, 'wheat to floor');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(6, 3, 1, 'floor to bread');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(7, 4, 1, 'transport: wood');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(8, 44, 1, 'iron deposit to ore');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(9, 8, 1, 'iron ore to bar');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(101, 5, 1, 'transport: plank');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(102, 2, 1, 'transport: wheat');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(103, 3, 1, 'transport: floor');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(104, 100, 1, 'transport: bread');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(200, 4, 1, 'sell: wood');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(201, 5, 1, 'sell: plank');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(202, 2, 1, 'sell: wheat');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(203, 3, 1, 'sell: floor');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(204, 100, 1, 'sell: bread');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(300, 1, 1, 'buy: wood');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(301, 1, 1, 'buy: wood plank');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(302, 1, 1, 'buy: wheat');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(330, 33, 1, 'field to wheat');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(333, 9, 1, 'iron bar to tool');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(810, 33, 1, 'field to vegetable');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(10020, 33, 1, 'produce: wheat');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(10030, 2, 1, 'produce: floor');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(10040, 34, 1, 'produce: wood');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(10050, 4, 1, 'produce: wood plank');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(10060, 33, 1, 'produce: wool');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(10070, 6, 1, 'produce: cloth');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(10080, 44, 1, 'produce: iron ore');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(10090, 8, 1, 'produce: iron bar');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(10100, 45, 1, 'produce: gold ore');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(10110, 10, 1, 'produce: gold bar');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(10120, 37, 1, 'produce: stone');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(10130, 4, 1, 'produce: paper');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(10140, 34, 1, 'produce: medecinal herb');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(11000, 3, 1, 'produce: bread');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(11010, 34, 1, 'produce: meat');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(11020, 35, 1, 'produce: fish');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(11030, 33, 1, 'produce: fruit');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(11040, 33, 1, 'produce: vegetable');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(11050, 35, 1, 'produce: crustaceans');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(11100, 4, 1, 'produce: tool');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(11101, 9, 1, 'produce: tool');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(11110, 7, 1, 'produce: outfit');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(11120, 14, 1, 'produce: medicine');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(11130, 5, 1, 'produce: housing');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(11131, 12, 1, 'produce: housing');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(11150, 5, 1, 'produce: furniture');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(11160, 33, 1, 'produce: horse');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(11200, 101, 1, 'produce: soap');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(11210, 33, 1, 'produce: honey');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(11220, 13, 1, 'produce: book');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(11230, 4, 1, 'produce: toy');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(11231, 9, 1, 'produce: toy');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(11300, 100, 1, 'produce: delicacy');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(11301, 121, 1, 'produce: delicacy');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(11302, 103, 1, 'produce: delicacy');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(11310, 7, 1, 'produce: painting');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(11320, 11, 1, 'produce: jewelry');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(11330, 9, 1, 'produce: watch');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(11331, 11, 1, 'produce: watch');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(11400, 5, 1, 'produce: crate');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(11410, 9, 1, 'produce: weapon');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(20020, 2, 1, 'sell: wheat');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(20030, 3, 1, 'sell: floor');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(20040, 4, 1, 'sell: wood');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(20050, 5, 1, 'sell: wood plank');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(20060, 6, 1, 'sell: wool');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(20070, 7, 1, 'sell: cloth');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(20080, 8, 1, 'sell: iron ore');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(20090, 9, 1, 'sell: iron bar');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(20100, 10, 1, 'sell: gold ore');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(20110, 11, 1, 'sell: gold bar');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(20120, 12, 1, 'sell: stone');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(20130, 13, 1, 'sell: paper');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(20140, 14, 1, 'sell: medecinal herb');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(20330, 33, 1, 'sell: field');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(20340, 34, 1, 'sell: forest');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(20350, 35, 1, 'sell: fish deposit');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(20360, 36, 1, 'sell: crustacean deposit');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(20370, 37, 1, 'sell: stone deposit');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(20440, 44, 1, 'sell: iron deposit');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(20450, 45, 1, 'sell: gold deposit');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(21000, 100, 1, 'sell: bread');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(21010, 101, 1, 'sell: meat');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(21020, 102, 1, 'sell: fish');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(21030, 103, 1, 'sell: fruit');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(21040, 104, 1, 'sell: vegetable');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(21050, 105, 1, 'sell: crustaceans');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(21100, 110, 1, 'sell: tool');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(21110, 111, 1, 'sell: outfit');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(21120, 112, 1, 'sell: medicine');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(21130, 113, 1, 'sell: housing');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(21150, 115, 1, 'sell: furniture');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(21160, 116, 1, 'sell: horse');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(21200, 120, 1, 'sell: soap');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(21210, 121, 1, 'sell: honey');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(21220, 122, 1, 'sell: book');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(21230, 123, 1, 'sell: toy');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(21300, 130, 1, 'sell: delicacy');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(21310, 131, 1, 'sell: painting');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(21320, 132, 1, 'sell: jewelry');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(21330, 133, 1, 'sell: watch');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(21400, 140, 1, 'sell: crate');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(21410, 141, 1, 'sell: weapon');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(30010, 1, 1, 'buy: Credit(sell/buy)');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(30020, 1, 1, 'buy: wheat');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(30030, 1, 1, 'buy: floor');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(30040, 1, 1, 'buy: wood');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(30050, 1, 1, 'buy: wood plank');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(30060, 1, 1, 'buy: wool');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(30070, 1, 1, 'buy: cloth');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(30080, 1, 1, 'buy: iron ore');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(30090, 1, 1, 'buy: iron bar');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(30100, 1, 1, 'buy: gold ore');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(30110, 1, 1, 'buy: gold bar');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(30120, 1, 1, 'buy: stone');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(30130, 1, 1, 'buy: paper');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(30140, 1, 1, 'buy: medecinal herb');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(30330, 1, 1, 'buy: field');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(30340, 1, 1, 'buy: forest');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(30350, 1, 1, 'buy: fish deposit');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(30360, 1, 1, 'buy: crustacean deposit');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(30370, 1, 1, 'buy: stone deposit');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(30440, 1, 1, 'buy: iron deposit');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(30450, 1, 1, 'buy: gold deposit');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(31000, 1, 1, 'buy: bread');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(31010, 1, 1, 'buy: meat');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(31020, 1, 1, 'buy: fish');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(31030, 1, 1, 'buy: fruit');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(31040, 1, 1, 'buy: vegetable');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(31050, 1, 1, 'buy: crustaceans');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(31100, 1, 1, 'buy: tool');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(31110, 1, 1, 'buy: outfit');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(31120, 1, 1, 'buy: medicine');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(31130, 1, 1, 'buy: housing');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(31150, 1, 1, 'buy: furniture');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(31160, 1, 1, 'buy: horse');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(31200, 1, 1, 'buy: soap');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(31210, 1, 1, 'buy: honey');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(31220, 1, 1, 'buy: book');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(31230, 1, 1, 'buy: toy');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(31300, 1, 1, 'buy: delicacy');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(31310, 1, 1, 'buy: painting');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(31320, 1, 1, 'buy: jewelry');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(31330, 1, 1, 'buy: watch');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(31400, 1, 1, 'buy: crate');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(31410, 1, 1, 'buy: weapon');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(40010, 1, 1, 'transport: Credit(sell/buy)');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(40020, 2, 1, 'transport: wheat');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(40030, 3, 1, 'transport: floor');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(40040, 4, 1, 'transport: wood');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(40050, 5, 1, 'transport: wood plank');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(40060, 6, 1, 'transport: wool');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(40070, 7, 1, 'transport: cloth');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(40080, 8, 1, 'transport: iron ore');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(40090, 9, 1, 'transport: iron bar');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(40100, 10, 1, 'transport: gold ore');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(40110, 11, 1, 'transport: gold bar');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(40120, 12, 1, 'transport: stone');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(40130, 13, 1, 'transport: paper');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(40140, 14, 1, 'transport: medecinal herb');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(40330, 33, 1, 'transport: field');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(40340, 34, 1, 'transport: forest');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(40350, 35, 1, 'transport: fish deposit');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(40360, 36, 1, 'transport: crustacean deposit');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(40370, 37, 1, 'transport: stone deposit');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(40440, 44, 1, 'transport: iron deposit');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(40450, 45, 1, 'transport: gold deposit');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(41000, 100, 1, 'transport: bread');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(41010, 101, 1, 'transport: meat');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(41020, 102, 1, 'transport: fish');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(41030, 103, 1, 'transport: fruit');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(41040, 104, 1, 'transport: vegetable');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(41050, 105, 1, 'transport: crustaceans');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(41100, 110, 1, 'transport: tool');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(41110, 111, 1, 'transport: outfit');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(41120, 112, 1, 'transport: medicine');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(41130, 113, 1, 'transport: housing');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(41150, 115, 1, 'transport: furniture');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(41160, 116, 1, 'transport: horse');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(41200, 120, 1, 'transport: soap');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(41210, 121, 1, 'transport: honey');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(41220, 122, 1, 'transport: book');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(41230, 123, 1, 'transport: toy');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(41300, 130, 1, 'transport: delicacy');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(41310, 131, 1, 'transport: painting');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(41320, 132, 1, 'transport: jewelry');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(41330, 133, 1, 'transport: watch');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(41400, 140, 1, 'transport: crate');
INSERT INTO `prodinputtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(41410, 141, 1, 'transport: weapon');
/*!40000 ALTER TABLE `prodinputtype` ENABLE KEYS */;

-- Dumping data for table gigablaster.prodtype: ~186 rows (approximately)
/*!40000 ALTER TABLE `prodtype` DISABLE KEYS */;
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(2, 4, 1, 'pinewood cuter');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(3, 5, 1, 'pinewood saw');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(5, 110, 1, 'tool');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(7, 3, 1, 'whet to floor');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(8, 100, 1, 'floor to bread');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(9, 4, 1, 'transport: pinewood');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(10, 8, 1, 'iron deposit to ore');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(11, 9, 1, 'iron ore to bar');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(101, 5, 1, 'transport: pinewood plank');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(102, 2, 1, 'transport: wheat');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(103, 3, 1, 'transport: floor');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(104, 100, 1, 'transport: bread');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(140, 12, 1, 'stone');
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
	(300, 4, 1, 'buy: wood');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(301, 5, 1, 'buy: plank');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(302, 2, 1, 'buy: wheat');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(303, 3, 1, 'buy: floor');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(490, 2, 1, 'field to wheat');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(1002, 2, 1, 'produce: wheat');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(1003, 3, 1, 'produce: floor');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(1004, 4, 1, 'produce: wood');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(1005, 5, 1, 'produce: wood plank');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(1006, 6, 1, 'produce: wool');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(1007, 7, 1, 'produce: cloth');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(1008, 8, 1, 'produce: iron ore');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(1009, 9, 1, 'produce: iron bar');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(1010, 10, 1, 'produce: gold ore');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(1011, 11, 1, 'produce: gold bar');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(1012, 12, 1, 'produce: stone');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(1013, 13, 1, 'produce: paper');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(1014, 14, 1, 'produce: medecinal herb');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(1100, 100, 1, 'produce: bread');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(1101, 101, 1, 'produce: meat');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(1102, 102, 1, 'produce: fish');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(1103, 103, 1, 'produce: fruit');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(1104, 104, 1, 'produce: vegetable');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(1105, 105, 1, 'produce: crustaceans');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(1110, 110, 1, 'produce: tool');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(1111, 111, 1, 'produce: outfit');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(1112, 112, 1, 'produce: medicine');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(1113, 113, 1, 'produce: housing');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(1115, 115, 1, 'produce: furniture');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(1116, 116, 1, 'produce: horse');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(1120, 120, 1, 'produce: soap');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(1121, 121, 1, 'produce: honey');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(1122, 122, 1, 'produce: book');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(1123, 123, 1, 'produce: toy');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(1130, 130, 1, 'produce: delicacy');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(1131, 131, 1, 'produce: painting');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(1132, 132, 1, 'produce: jewelry');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(1133, 133, 1, 'produce: watch');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(1140, 140, 1, 'produce: crate');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(1141, 141, 1, 'produce: weapon');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(2002, 1, 1, 'sell: wheat');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(2003, 1, 1, 'sell: floor');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(2004, 1, 1, 'sell: wood');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(2005, 1, 1, 'sell: wood plank');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(2006, 1, 1, 'sell: wool');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(2007, 1, 1, 'sell: cloth');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(2008, 1, 1, 'sell: iron ore');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(2009, 1, 1, 'sell: iron bar');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(2010, 1, 1, 'sell: gold ore');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(2011, 1, 1, 'sell: gold bar');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(2012, 1, 1, 'sell: stone');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(2013, 1, 1, 'sell: paper');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(2014, 1, 1, 'sell: medecinal herb');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(2033, 1, 1, 'sell: field');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(2034, 1, 1, 'sell: forest');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(2100, 1, 1, 'sell: bread');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(2101, 1, 1, 'sell: meat');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(2102, 1, 1, 'sell: fish');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(2103, 1, 1, 'sell: fruit');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(2104, 1, 1, 'sell: vegetable');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(2105, 1, 1, 'sell: crustaceans');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(2110, 1, 1, 'sell: tool');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(2111, 1, 1, 'sell: outfit');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(2112, 1, 1, 'sell: medicine');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(2113, 1, 1, 'sell: housing');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(2115, 1, 1, 'sell: furniture');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(2116, 1, 1, 'sell: horse');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(2120, 1, 1, 'sell: soap');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(2121, 1, 1, 'sell: honey');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(2122, 1, 1, 'sell: book');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(2123, 1, 1, 'sell: toy');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(2130, 1, 1, 'sell: delicacy');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(2131, 1, 1, 'sell: painting');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(2132, 1, 1, 'sell: jewelry');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(2133, 1, 1, 'sell: watch');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(2140, 1, 1, 'sell: crate');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(2141, 1, 1, 'sell: weapon');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(3002, 2, 1, 'buy: wheat');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(3003, 3, 1, 'buy: floor');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(3004, 4, 1, 'buy: wood');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(3005, 5, 1, 'buy: wood plank');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(3006, 6, 1, 'buy: wool');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(3007, 7, 1, 'buy: cloth');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(3008, 8, 1, 'buy: iron ore');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(3009, 9, 1, 'buy: iron bar');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(3010, 10, 1, 'buy: gold ore');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(3011, 11, 1, 'buy: gold bar');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(3012, 12, 1, 'buy: stone');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(3013, 13, 1, 'buy: paper');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(3014, 14, 1, 'buy: medecinal herb');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(3033, 33, 1, 'buy: field');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(3034, 34, 1, 'buy: forest');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(3100, 100, 1, 'buy: bread');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(3101, 101, 1, 'buy: meat');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(3102, 102, 1, 'buy: fish');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(3103, 103, 1, 'buy: fruit');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(3104, 104, 1, 'buy: vegetable');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(3105, 105, 1, 'buy: crustaceans');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(3110, 110, 1, 'buy: tool');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(3111, 111, 1, 'buy: outfit');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(3112, 112, 1, 'buy: medicine');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(3113, 113, 1, 'buy: housing');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(3115, 115, 1, 'buy: furniture');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(3116, 116, 1, 'buy: horse');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(3120, 120, 1, 'buy: soap');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(3121, 121, 1, 'buy: honey');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(3122, 122, 1, 'buy: book');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(3123, 123, 1, 'buy: toy');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(3130, 130, 1, 'buy: delicacy');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(3131, 131, 1, 'buy: painting');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(3132, 132, 1, 'buy: jewelry');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(3133, 133, 1, 'buy: watch');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(3140, 140, 1, 'buy: crate');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(3141, 141, 1, 'buy: weapon');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(4002, 2, 1, 'transport: wheat');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(4003, 3, 1, 'transport: floor');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(4004, 4, 1, 'transport: wood');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(4005, 5, 1, 'transport: wood plank');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(4006, 6, 1, 'transport: wool');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(4007, 7, 1, 'transport: cloth');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(4008, 8, 1, 'transport: iron ore');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(4009, 9, 1, 'transport: iron bar');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(4010, 10, 1, 'transport: gold ore');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(4011, 11, 1, 'transport: gold bar');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(4012, 12, 1, 'transport: stone');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(4013, 13, 1, 'transport: paper');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(4014, 14, 1, 'transport: medecinal herb');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(4033, 33, 1, 'transport: field');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(4034, 34, 1, 'transport: forest');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(4100, 100, 1, 'transport: bread');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(4101, 101, 1, 'transport: meat');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(4102, 102, 1, 'transport: fish');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(4103, 103, 1, 'transport: fruit');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(4104, 104, 1, 'transport: vegetable');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(4105, 105, 1, 'transport: crustaceans');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(4110, 110, 1, 'transport: tool');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(4111, 111, 1, 'transport: outfit');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(4112, 112, 1, 'transport: medicine');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(4113, 113, 1, 'transport: housing');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(4115, 115, 1, 'transport: furniture');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(4116, 116, 1, 'transport: horse');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(4120, 120, 1, 'transport: soap');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(4121, 121, 1, 'transport: honey');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(4122, 122, 1, 'transport: book');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(4123, 123, 1, 'transport: toy');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(4130, 130, 1, 'transport: delicacy');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(4131, 131, 1, 'transport: painting');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(4132, 132, 1, 'transport: jewelry');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(4133, 133, 1, 'transport: watch');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(4140, 140, 1, 'transport: crate');
INSERT INTO `prodtype` (`id`, `ressource_id`, `quantity`, `comment`) VALUES
	(4141, 141, 1, 'transport: weapon');
/*!40000 ALTER TABLE `prodtype` ENABLE KEYS */;

-- Dumping data for table gigablaster.prodtype_prodinputtype_assoc: ~152 rows (approximately)
/*!40000 ALTER TABLE `prodtype_prodinputtype_assoc` DISABLE KEYS */;
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(1002, 10020);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(1003, 10030);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(1004, 10040);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(1005, 10050);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(1006, 10060);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(1007, 10070);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(1008, 10080);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(1009, 10090);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(1010, 10100);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(1011, 10110);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(1012, 10120);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(1013, 10130);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(1014, 10140);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(1100, 11000);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(1101, 11010);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(1102, 11020);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(1103, 11030);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(1104, 11040);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(1105, 11050);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(1110, 11100);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(1110, 11101);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(1111, 11110);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(1112, 11120);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(1113, 11130);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(1113, 11131);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(1115, 11150);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(1116, 11160);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(1120, 11200);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(1121, 11210);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(1122, 11220);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(1123, 11230);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(1123, 11231);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(1130, 11300);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(1130, 11301);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(1130, 11302);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(1131, 11310);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(1132, 11320);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(1133, 11330);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(1133, 11331);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(1140, 11400);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(1141, 11410);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(2002, 20020);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(2003, 20030);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(2004, 20040);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(2005, 20050);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(2006, 20060);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(2007, 20070);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(2008, 20080);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(2009, 20090);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(2010, 20100);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(2011, 20110);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(2012, 20120);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(2013, 20130);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(2014, 20140);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(2033, 20330);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(2034, 20340);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(2100, 21000);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(2101, 21010);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(2102, 21020);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(2103, 21030);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(2104, 21040);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(2105, 21050);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(2110, 21100);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(2111, 21110);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(2112, 21120);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(2113, 21130);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(2115, 21150);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(2116, 21160);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(2120, 21200);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(2121, 21210);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(2122, 21220);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(2123, 21230);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(2130, 21300);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(2131, 21310);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(2132, 21320);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(2133, 21330);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(2140, 21400);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(2141, 21410);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(3002, 30020);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(3003, 30030);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(3004, 30040);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(3005, 30050);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(3006, 30060);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(3007, 30070);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(3008, 30080);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(3009, 30090);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(3010, 30100);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(3011, 30110);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(3012, 30120);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(3013, 30130);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(3014, 30140);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(3033, 30330);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(3034, 30340);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(3100, 31000);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(3101, 31010);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(3102, 31020);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(3103, 31030);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(3104, 31040);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(3105, 31050);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(3110, 31100);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(3111, 31110);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(3112, 31120);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(3113, 31130);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(3115, 31150);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(3116, 31160);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(3120, 31200);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(3121, 31210);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(3122, 31220);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(3123, 31230);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(3130, 31300);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(3131, 31310);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(3132, 31320);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(3133, 31330);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(3140, 31400);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(3141, 31410);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(4002, 40020);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(4003, 40030);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(4004, 40040);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(4005, 40050);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(4006, 40060);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(4007, 40070);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(4008, 40080);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(4009, 40090);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(4010, 40100);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(4011, 40110);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(4012, 40120);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(4013, 40130);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(4014, 40140);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(4033, 40330);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(4034, 40340);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(4100, 41000);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(4101, 41010);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(4102, 41020);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(4103, 41030);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(4104, 41040);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(4105, 41050);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(4110, 41100);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(4111, 41110);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(4112, 41120);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(4113, 41130);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(4115, 41150);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(4116, 41160);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(4120, 41200);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(4121, 41210);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(4122, 41220);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(4123, 41230);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(4130, 41300);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(4131, 41310);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(4132, 41320);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(4133, 41330);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(4140, 41400);
INSERT INTO `prodtype_prodinputtype_assoc` (`prodtype_id`, `prodinputtype_id`) VALUES
	(4141, 41410);
/*!40000 ALTER TABLE `prodtype_prodinputtype_assoc` ENABLE KEYS */;

-- Dumping data for table gigablaster.relationshipmodifier: ~0 rows (approximately)
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

-- Dumping data for table gigablaster.ressource: ~43 rows (approximately)
/*!40000 ALTER TABLE `ressource` DISABLE KEYS */;
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`, `description`) VALUES
	(1, 'Credit(sell/buy)', 1, 0, NULL);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`, `description`) VALUES
	(2, 'wheat', 1, 0, NULL);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`, `description`) VALUES
	(3, 'floor', 2, 0, NULL);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`, `description`) VALUES
	(4, 'wood', 1, 0, NULL);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`, `description`) VALUES
	(5, 'wood plank', 2, 0, NULL);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`, `description`) VALUES
	(6, 'wool', 1, 0, NULL);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`, `description`) VALUES
	(7, 'cloth', 1, 0, NULL);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`, `description`) VALUES
	(8, 'iron ore', 1, 0, NULL);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`, `description`) VALUES
	(9, 'iron bar', 1, 0, NULL);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`, `description`) VALUES
	(10, 'gold ore', 5, 0, NULL);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`, `description`) VALUES
	(11, 'gold bar', 10, 0, NULL);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`, `description`) VALUES
	(12, 'stone', 1, 0, NULL);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`, `description`) VALUES
	(13, 'paper', 1, 0, NULL);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`, `description`) VALUES
	(14, 'medecinal herb', 1, 0, NULL);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`, `description`) VALUES
	(33, 'field', 0, 1, NULL);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`, `description`) VALUES
	(34, 'forest', 0, 1, NULL);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`, `description`) VALUES
	(35, 'fish deposit', 0, 1, NULL);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`, `description`) VALUES
	(36, 'crustacean deposit', 0, 1, NULL);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`, `description`) VALUES
	(37, 'stone deposit', 0, 1, NULL);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`, `description`) VALUES
	(44, 'iron deposit', 0, 1, NULL);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`, `description`) VALUES
	(45, 'gold deposit', 0, 1, NULL);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`, `description`) VALUES
	(100, 'bread', 4, 0, NULL);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`, `description`) VALUES
	(101, 'meat', 1, 0, NULL);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`, `description`) VALUES
	(102, 'fish', 1, 0, NULL);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`, `description`) VALUES
	(103, 'fruit', 1, 0, NULL);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`, `description`) VALUES
	(104, 'vegetable', 1, 0, NULL);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`, `description`) VALUES
	(105, 'crustaceans', 1, 0, NULL);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`, `description`) VALUES
	(110, 'tool', 1, 0, NULL);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`, `description`) VALUES
	(111, 'outfit', 1, 0, NULL);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`, `description`) VALUES
	(112, 'medicine', 1, 0, NULL);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`, `description`) VALUES
	(113, 'housing', 1, 0, NULL);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`, `description`) VALUES
	(115, 'furniture', 1, 0, NULL);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`, `description`) VALUES
	(116, 'horse', 1, 0, NULL);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`, `description`) VALUES
	(120, 'soap', 1, 0, NULL);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`, `description`) VALUES
	(121, 'honey', 1, 0, NULL);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`, `description`) VALUES
	(122, 'book', 1, 0, NULL);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`, `description`) VALUES
	(123, 'toy', 1, 0, NULL);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`, `description`) VALUES
	(130, 'delicacy', 1, 0, NULL);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`, `description`) VALUES
	(131, 'painting', 1, 0, NULL);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`, `description`) VALUES
	(132, 'jewelry', 1, 0, NULL);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`, `description`) VALUES
	(133, 'watch', 1, 0, NULL);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`, `description`) VALUES
	(140, 'crate', 1, 0, NULL);
INSERT INTO `ressource` (`id`, `label`, `baseprice`, `natural`, `description`) VALUES
	(141, 'weapon', 1, 0, NULL);
/*!40000 ALTER TABLE `ressource` ENABLE KEYS */;

-- Dumping data for table gigablaster.ressource_rescategory: ~64 rows (approximately)
/*!40000 ALTER TABLE `ressource_rescategory` DISABLE KEYS */;
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 2);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 3);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 4);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 5);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 6);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 7);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 8);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 9);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 10);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 11);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 12);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 13);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 14);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(12, 33);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(12, 34);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(12, 35);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(12, 37);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(12, 44);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(12, 45);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(5, 100);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 100);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(5, 101);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 101);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(5, 102);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 102);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(5, 103);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 103);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(5, 104);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 104);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(5, 105);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 105);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(1, 110);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 110);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(1, 111);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 111);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(1, 112);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 112);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(1, 113);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 113);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(1, 115);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 115);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(1, 116);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 116);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(10, 120);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 120);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(10, 121);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 121);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(10, 122);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 122);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(10, 123);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 123);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(4, 130);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 130);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(4, 131);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 131);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(4, 132);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 132);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(4, 133);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 133);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(11, 140);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 140);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(11, 141);
INSERT INTO `ressource_rescategory` (`rescat_id`, `res_id`) VALUES
	(13, 141);
/*!40000 ALTER TABLE `ressource_rescategory` ENABLE KEYS */;

-- Dumping data for table gigablaster.sovereign: ~0 rows (approximately)
/*!40000 ALTER TABLE `sovereign` DISABLE KEYS */;
/*!40000 ALTER TABLE `sovereign` ENABLE KEYS */;

-- Dumping data for table gigablaster.user: ~2 rows (approximately)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `player_name`, `email`, `password_shadow`) VALUES
	(1, 'Toto', 'toto@gmail.com', '$2y$12$905JS5gAdmNS.c5VM10ksObhf9sBsWDnl8opgKS6kBJlZ6qxyPIPS');
INSERT INTO `user` (`id`, `player_name`, `email`, `password_shadow`) VALUES
	(2, 'Titi', 'titi@gmail.com', '$2y$12$905JS5gAdmNS.c5VM10ksObhf9sBsWDnl8opgKS6kBJlZ6qxyPIPS');
INSERT INTO `user` (`id`, `player_name`, `email`, `password_shadow`) VALUES
	(4, 'Tester', 'test@toto.com', '$2y$12$dwCvQDoF5yd2korjJGsojuxIaWohx4txT1d2PWcynqQJz.omjnELK');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

-- Dumping data for table gigablaster._view_note: 9 rows
/*!40000 ALTER TABLE `_view_note` DISABLE KEYS */;
INSERT INTO `_view_note` (`view_name`, `formated`) VALUES
	('sold', 'SELECT \r\n	seller.id AS seller_id,\r\n	buyer.id AS buyer_id,\r\n	prodinputtype.ressource_id AS ressource_id,\r\n	FLOOR( prodinputtype.quantity\r\n	* prod.percent_max ) AS quantity\r\nFROM player\r\nJOIN pawn AS seller ON seller.player_id = player.id\r\nJOIN prod ON prod.pawn_id = seller.id\r\nJOIN prodtype \r\n	ON prodtype.id = prod.prodtype_id \r\n	AND prodtype.ressource_id = 1/*Credit*/\r\nJOIN prodinput ON prodinput.prod_id = prod.id\r\nJOIN prodinputtype ON prodinputtype.id = prodinput.prodinputtype_id\r\nJOIN city as buyer \r\n	ON buyer.location_x = prod.location_x \r\n	AND buyer.location_y = prod.location_y\r\nJOIN demand \r\n	ON demand.city_id = buyer.id\r\n	AND demand.ressource_id = prodinputtype.ressource_id');
INSERT INTO `_view_note` (`view_name`, `formated`) VALUES
	('player_ext', 'SELECT \r\n	player.id as player_id,\r\n	IFNULL(tcartused.value,0) as cart_used,\r\n	IFNULL(trevenue.value,0)\r\n	- IFNULL(tcharge.value,0)\r\n	AS income\r\nFROM player\r\n\r\n# JOIN cart owned by player\r\nLEFT JOIN (\r\n	SELECT\r\n		 pawn.player_id,\r\n		 IFNULL(SUM(pawn.grade), 0) as value\r\n	FROM pawn\r\n	JOIN pawntype ON pawntype.id = pawn.type_id \r\n	WHERE pawntype.category_id = 4 #transporter\r\n	GROUP BY pawn.player_id\r\n) as tcartused ON tcartused.player_id = player.id\r\n\r\n# JOIN sold product\r\nLEFT JOIN (\r\n	SELECT \r\n		pawn.player_id as player_id,\r\n		IFNULL(\r\n			SUM(\r\n				demand.price_modifier \r\n				* ressource.baseprice \r\n				* sold.quantity \r\n			),\r\n			0\r\n		) as value\r\n	FROM pawn\r\n	JOIN sold ON sold.seller_id = pawn.id\r\n	JOIN demand \r\n		ON demand.city_id = sold.buyer_id\r\n		AND demand.ressource_id = sold.ressource_id\r\n	JOIN ressource ON ressource.id = sold.ressource_id\r\n	GROUP BY pawn.player_id\r\n) as trevenue ON trevenue.player_id = player.id\r\n\r\n#JOIN buy\r\nLEFT JOIN (\r\n	SELECT \r\n		pawn.player_id as player_id,\r\n		IFNULL(\r\n			SUM(\r\n				demand.price_modifier \r\n				* ressource.baseprice \r\n				#* prodtype_buyer.quantity \r\n			),\r\n			0\r\n		) as value\r\n	FROM pawn\r\n	JOIN prod ON prod.pawn_id = pawn.id\r\n	JOIN prodtype ON prodtype.id = prod.prodtype_id\r\n	JOIN city \r\n		ON  city.location_x = prod.location_x\r\n		AND city.location_y = prod.location_y\r\n	JOIN demand \r\n		ON demand.city_id = city.id \r\n		AND demand.ressource_id = prodtype.ressource_id\r\n	JOIN ressource ON ressource.id = demand.ressource_id\r\n	GROUP BY pawn.player_id\r\n) as tcharge ON tcharge.player_id = player.id\r\n	\r\n');
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
INSERT INTO `_view_note` (`view_name`, `formated`) VALUES
	('prod_sum', 'SELECT \r\n	pawn.player_id,\r\n	prod.location_x AS location_x,\r\n	prod.location_y AS location_y,\r\n	prodtype.ressource_id AS ressource_id, \r\n	FLOOR(SUM((prodtype.quantity * prod.percent_max ))) AS quantity\r\nFROM prod\r\nJOIN prodtype ON prodtype.id = prod.prodtype_id\r\nJOIN pawn ON pawn.id = prod.pawn_id\r\nGROUP BY prod.location_x,prod.location_y,prodtype.ressource_id,pawn.player_id');
INSERT INTO `_view_note` (`view_name`, `formated`) VALUES
	('prodinput_sum', 'SELECT \r\n	pawn.player_id,\r\n	prodinput.location_x,\r\n	prodinput.location_y,\r\n	prodinputtype.ressource_id,\r\n	SUM(prodinputtype.quantity * prod.grade) as quantity\r\nFROM prodinput\r\nJOIN prod ON prod.id = prodinput.prod_id\r\nJOIN pawn ON pawn.id = prod.pawn_id\r\nJOIN prodinputtype ON prodinputtype.id = prodinput.prodinputtype_id\r\nGROUP BY \r\n	pawn.player_id,\r\n	prodinput.location_x,\r\n	prodinput.location_y,\r\n	prodinputtype.ressource_id');
/*!40000 ALTER TABLE `_view_note` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
