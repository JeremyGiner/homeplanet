-- MySQL dump 10.13  Distrib 5.7.19, for Win64 (x86_64)
--
-- Host: localhost    Database: homeplanet
-- ------------------------------------------------------
-- Server version	5.7.19

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping data for table `_view_note`
--

/*!40000 ALTER TABLE `_view_note` DISABLE KEYS */;
INSERT INTO `_view_note` VALUES ('sold','# Get sold quantity\r\nSELECT \r\n	seller.id AS pawn_id,\r\n	city.id AS city_id,\r\n	prodinputtype.ressource_id AS ressource_id,\r\n	LEAST( \r\n		FLOOR( prodinputtype.quantity * prod.percent_max ),\r\n		population.quantity\r\n	) AS quantity\r\nFROM player\r\nJOIN pawn AS seller ON seller.player_id = player.id\r\nJOIN prod ON prod.pawn_id = seller.id\r\nJOIN prodtype \r\n	ON prodtype.id = prod.prodtype_id \r\n	AND prodtype.ressource_id = 1/*Credit*/\r\nJOIN prodinput ON prodinput.prod_id = prod.id\r\nJOIN prodinputtype ON prodinputtype.id = prodinput.prodinputtype_id\r\nJOIN city  \r\n	ON city.location_x = prod.location_x \r\n	AND city.location_y = prod.location_y\r\nJOIN population ON population.city_id = city.id\r\nJOIN demand \r\n	ON demand.city_id = city.id\r\n	AND demand.ressource_id = prodinputtype.ressource_id'),('player_ext','SELECT \r\n	player.id as player_id,\r\n	IFNULL(tcontract.value,0) as contract,\r\n	IFNULL(trevenue.value,0)\r\n	- IFNULL(tcharge.value,0)\r\n	AS income\r\nFROM player\r\n\r\n# JOIN contract owned by player\r\nLEFT JOIN (\r\n	SELECT\r\n		 pawn.player_id,\r\n		 IFNULL(SUM(pawn.grade), 0) as value\r\n	FROM pawn\r\n	JOIN pawntype ON pawntype.id = pawn.type_id \r\n	GROUP BY pawn.player_id\r\n) as tcontract ON tcontract.player_id = player.id\r\n\r\n# JOIN sold product\r\nLEFT JOIN (\r\n	SELECT \r\n		pawn.player_id as player_id,\r\n		IFNULL(\r\n			SUM(\r\n				demand.price_modifier \r\n				* ressource.baseprice \r\n				* sold.quantity \r\n			),\r\n			0\r\n		) as value\r\n	FROM pawn\r\n	JOIN sold ON sold.pawn_id = pawn.id\r\n	JOIN demand \r\n		ON demand.city_id = sold.city_id\r\n		AND demand.ressource_id = sold.ressource_id\r\n	JOIN ressource ON ressource.id = sold.ressource_id\r\n	GROUP BY pawn.player_id\r\n) as trevenue ON trevenue.player_id = player.id\r\n\r\n#JOIN buy\r\nLEFT JOIN (\r\n	SELECT \r\n		pawn.player_id as player_id,\r\n		IFNULL(\r\n			SUM(\r\n				demand.price_modifier \r\n				* ressource.baseprice \r\n				#* prodtype_buyer.quantity \r\n			),\r\n			0\r\n		) as value\r\n	FROM pawn\r\n	JOIN prod ON prod.pawn_id = pawn.id\r\n	JOIN prodtype ON prodtype.id = prod.prodtype_id\r\n	JOIN city \r\n		ON  city.location_x = prod.location_x\r\n		AND city.location_y = prod.location_y\r\n	JOIN demand \r\n		ON demand.city_id = city.id \r\n		AND demand.ressource_id = prodtype.ressource_id\r\n	JOIN ressource ON ressource.id = demand.ressource_id\r\n	GROUP BY pawn.player_id\r\n) as tcharge ON tcharge.player_id = player.id\r\n	\r\n'),('city_distance','SELECT \r\n	c0.id as city0_id,\r\n	c1.id as city1_id,\r\n	abs(c1.location_x - c0.location_x)\r\n	+abs(c1.location_y - c0.location_y) as dist\r\nFROM city as c0\r\nLEFT JOIN city as c1 ON c1.id != c0.id\r\n'),('relationship','SELECT \r\n	relationshipmodifier.player_id,\r\n	relationshipmodifier.sovereign_id,\r\n	relationshipmodifier.type_id\r\nFROM relationshipmodifier\r\n\r\nUNION\r\n\r\nSELECT \r\n	player.id,\r\n	player.allegeance,\r\n	2 #allegeance\r\nFROM player\r\nWHERE player.allegeance IS NOT NULL'),('influence_relationship','SELECT \r\n	city.id as city_id,\r\n	relationship.sovereign_id,\r\n	SUM(sold.quantity) as value\r\nFROM city\r\nJOIN sold ON sold.city_id = city.id\r\nJOIN pawn ON pawn.id = sold.pawn_id\r\nJOIN relationship ON relationship.player_id = pawn.player_id\r\nGROUP BY city.id, relationship.sovereign_id'),('influence','	SELECT \r\n		influencemodifier.city_id,\r\n		influencemodifier.sovereign_id,\r\n		influencemodifier.type_id,\r\n		influencemodifier.value\r\n	FROM influencemodifier\r\nUNION\r\n	SELECT\r\n		influence_relationship.city_id,\r\n		influence_relationship.sovereign_id,\r\n		4, #provider\r\n		influence_relationship.value\r\n	FROM influence_relationship'),('city_sovereign','SELECT \r\n	`t`.`city_id` AS `city_id`,\r\n	MIN(`t`.`sovereign_id`) AS `sovereign_id`,\r\n	`t`.`sum_value` AS `sum_value` \r\nFROM `gigablaster`.`influence_sum` `t` \r\nJOIN (\r\n	SELECT \r\n		`influence_sum`.`city_id` AS `city_id`,\r\n		MAX(`influence_sum`.`sum_value`) AS `max_value` \r\n	FROM `gigablaster`.`influence_sum` \r\n	GROUP BY `influence_sum`.`city_id`\r\n) `tmax` \r\n	ON `tmax`.`city_id` = `t`.`city_id`\r\n	AND `t`.`sum_value` = `tmax`.`max_value`\r\nGROUP BY `t`.`city_id`'),('prod_sum','SELECT \r\n	pawn.player_id,\r\n	prod.location_x AS location_x,\r\n	prod.location_y AS location_y,\r\n	prodtype.ressource_id AS ressource_id, \r\n	FLOOR(SUM((prodtype.quantity * prod.percent_max ))) AS quantity\r\nFROM prod\r\nJOIN prodtype ON prodtype.id = prod.prodtype_id\r\nJOIN pawn ON pawn.id = prod.pawn_id\r\nGROUP BY prod.location_x,prod.location_y,prodtype.ressource_id,pawn.player_id'),('prodinput_sum','SELECT \r\n	pawn.player_id,\r\n	prodinput.location_x,\r\n	prodinput.location_y,\r\n	prodinputtype.ressource_id,\r\n	SUM(prodinputtype.quantity * prod.grade) as quantity\r\nFROM prodinput\r\nJOIN prod ON prod.id = prodinput.prod_id\r\nJOIN pawn ON pawn.id = prod.pawn_id\r\nJOIN prodinputtype ON prodinputtype.id = prodinput.prodinputtype_id\r\nGROUP BY \r\n	pawn.player_id,\r\n	prodinput.location_x,\r\n	prodinput.location_y,\r\n	prodinputtype.ressource_id'),('prodinput_dynamicquantity','SELECT \r\n	prodinput.id AS prodinput_id,\r\n	IF( ISNULL(demand.price_modifier),NULL,(demand.price_modifier * ressource.baseprice)) AS quantity \r\nFROM prodinput \r\nJOIN prodinputtype ON prodinputtype.id = prodinput.prodinputtype_id \r\n	AND prodinputtype.ressource_id = 1 \r\n	AND prodinputtype.quantity IS NULL\r\nLEFT JOIN city ON city.location_x = prodinput.location_x AND city.location_y = prodinput.location_y\r\nLEFT JOIN demand ON demand.city_id = city.id AND demand.ressource_id = prodinputtype.ressource_id\r\nLEFT JOIN ressource ON ressource.id = demand.ressource_id'),('tilecapacityovercrowd','SELECT \r\n	pawn_location_assoc.location_x, \r\n	pawn_location_assoc.location_y, \r\n	tilecapacityrequirement.type_id,\r\n	SUM(tilecapacityrequirement.quantity * pawn.grade) as quantity\r\nFROM pawn \r\nJOIN pawn_location_assoc ON pawn_location_assoc.pawn_id = pawn.id\r\nJOIN pawntype ON pawntype.id = pawn.type_id\r\nJOIN tilecapacityrequirement ON tilecapacityrequirement.pawntype_id = pawntype.id\r\nGROUP BY pawn_location_assoc.location_x,pawn_location_assoc.location_y, tilecapacityrequirement.type_id');
/*!40000 ALTER TABLE `_view_note` ENABLE KEYS */;

--
-- Dumping data for table `attribute`
--

/*!40000 ALTER TABLE `attribute` DISABLE KEYS */;
INSERT INTO `attribute` VALUES (1,2,NULL),(2,3,'land:3'),(3,3,'land:5'),(4,3,'naval:10');
/*!40000 ALTER TABLE `attribute` ENABLE KEYS */;

--
-- Dumping data for table `attributetype`
--

/*!40000 ALTER TABLE `attributetype` DISABLE KEYS */;
INSERT INTO `attributetype` VALUES (1,'prod_slot'),(2,'move'),(3,'transport'),(4,'stealth');
/*!40000 ALTER TABLE `attributetype` ENABLE KEYS */;

--
-- Dumping data for table `budgetplan`
--

/*!40000 ALTER TABLE `budgetplan` DISABLE KEYS */;
/*!40000 ALTER TABLE `budgetplan` ENABLE KEYS */;

--
-- Dumping data for table `budgetplantype`
--

/*!40000 ALTER TABLE `budgetplantype` DISABLE KEYS */;
INSERT INTO `budgetplantype` VALUES (1,'military : defence'),(2,'military : offence'),(3,'public services'),(4,'research'),(5,'culture');
/*!40000 ALTER TABLE `budgetplantype` ENABLE KEYS */;

--
-- Dumping data for table `character`
--

/*!40000 ALTER TABLE `character` DISABLE KEYS */;
/*!40000 ALTER TABLE `character` ENABLE KEYS */;

--
-- Dumping data for table `character_acquaintance`
--

/*!40000 ALTER TABLE `character_acquaintance` DISABLE KEYS */;
INSERT INTO `character_acquaintance` VALUES (6,1),(6,2);
/*!40000 ALTER TABLE `character_acquaintance` ENABLE KEYS */;

--
-- Dumping data for table `character_characterhistory`
--

/*!40000 ALTER TABLE `character_characterhistory` DISABLE KEYS */;
/*!40000 ALTER TABLE `character_characterhistory` ENABLE KEYS */;

--
-- Dumping data for table `character_expression`
--

/*!40000 ALTER TABLE `character_expression` DISABLE KEYS */;
/*!40000 ALTER TABLE `character_expression` ENABLE KEYS */;

--
-- Dumping data for table `character_knowledge`
--

/*!40000 ALTER TABLE `character_knowledge` DISABLE KEYS */;
/*!40000 ALTER TABLE `character_knowledge` ENABLE KEYS */;

--
-- Dumping data for table `characterhistory`
--

/*!40000 ALTER TABLE `characterhistory` DISABLE KEYS */;
INSERT INTO `characterhistory` VALUES (9,'wedding_proposal','{\"proposer\":{\"class\":\"homeplanet\\\\Entity\\\\Character\",\"id\":14},\"proposed\":{\"class\":\"homeplanet\\\\Entity\\\\Character\",\"id\":15},\"accepted\":true}',49),(10,'wedding_proposal','{\"proposer\":{\"class\":\"homeplanet\\\\Entity\\\\Character\",\"id\":16},\"proposed\":{\"class\":\"homeplanet\\\\Entity\\\\Character\",\"id\":17},\"accepted\":true}',49),(11,'wedding_proposal','{\"proposer\":{\"class\":\"homeplanet\\\\Entity\\\\Character\",\"id\":19},\"proposed\":{\"class\":\"homeplanet\\\\Entity\\\\Character\",\"id\":18},\"accepted\":true}',49),(12,'child_birth','{\"mother\":{\"class\":\"Proxies\\\\__CG__\\\\homeplanet\\\\Entity\\\\Character\",\"id\":15},\"father\":{\"class\":\"homeplanet\\\\Entity\\\\Character\",\"id\":14},\"child\":{\"class\":\"homeplanet\\\\Entity\\\\Character\",\"id\":23}}',52),(13,'child_birth','{\"mother\":{\"class\":\"Proxies\\\\__CG__\\\\homeplanet\\\\Entity\\\\Character\",\"id\":17},\"father\":{\"class\":\"homeplanet\\\\Entity\\\\Character\",\"id\":16},\"child\":{\"class\":\"homeplanet\\\\Entity\\\\Character\",\"id\":24}}',52),(14,'child_birth','{\"mother\":{\"class\":\"Proxies\\\\__CG__\\\\homeplanet\\\\Entity\\\\Character\",\"id\":19},\"father\":{\"class\":\"homeplanet\\\\Entity\\\\Character\",\"id\":18},\"child\":{\"class\":\"homeplanet\\\\Entity\\\\Character\",\"id\":25}}',53),(15,'job_new','{\"character\":{\"class\":\"homeplanet\\\\Entity\\\\Character\",\"id\":18},\"house\":{\"class\":\"Proxies\\\\__CG__\\\\homeplanet\\\\Entity\\\\House\",\"id\":4}}',54);
/*!40000 ALTER TABLE `characterhistory` ENABLE KEYS */;

--
-- Dumping data for table `characternamereference`
--

/*!40000 ALTER TABLE `characternamereference` DISABLE KEYS */;
INSERT INTO `characternamereference` VALUES (1,'PENELOPE','GUINESS'),(2,'NICK','WAHLBERG'),(3,'ED','CHASE'),(4,'JENNIFER','DAVIS'),(5,'JOHNNY','LOLLOBRIGIDA'),(6,'BETTE','NICHOLSON'),(7,'GRACE','MOSTEL'),(8,'MATTHEW','JOHANSSON'),(9,'JOE','SWANK'),(10,'CHRISTIAN','GABLE'),(11,'ZERO','CAGE'),(12,'KARL','BERRY'),(13,'UMA','WOOD'),(14,'VIVIEN','BERGEN'),(15,'CUBA','OLIVIER'),(16,'FRED','COSTNER'),(17,'HELEN','VOIGHT'),(18,'DAN','TORN'),(19,'BOB','FAWCETT'),(20,'LUCILLE','TRACY'),(21,'KIRSTEN','PALTROW'),(22,'ELVIS','MARX'),(23,'SANDRA','KILMER'),(24,'CAMERON','STREEP'),(25,'KEVIN','BLOOM'),(26,'RIP','CRAWFORD'),(27,'JULIA','MCQUEEN'),(28,'WOODY','HOFFMAN'),(29,'ALEC','WAYNE'),(30,'SANDRA','PECK'),(31,'SISSY','SOBIESKI'),(32,'TIM','HACKMAN'),(33,'MILLA','PECK'),(34,'AUDREY','OLIVIER'),(35,'JUDY','DEAN'),(36,'BURT','DUKAKIS'),(37,'VAL','BOLGER'),(38,'TOM','MCKELLEN'),(39,'GOLDIE','BRODY'),(40,'JOHNNY','CAGE'),(41,'JODIE','DEGENERES'),(42,'TOM','MIRANDA'),(43,'KIRK','JOVOVICH'),(44,'NICK','STALLONE'),(45,'REESE','KILMER'),(46,'PARKER','GOLDBERG'),(47,'JULIA','BARRYMORE'),(48,'FRANCES','DAY-LEWIS'),(49,'ANNE','CRONYN'),(50,'NATALIE','HOPKINS'),(51,'GARY','PHOENIX'),(52,'CARMEN','HUNT'),(53,'MENA','TEMPLE'),(54,'PENELOPE','PINKETT'),(55,'FAY','KILMER'),(56,'DAN','HARRIS'),(57,'JUDE','CRUISE'),(58,'CHRISTIAN','AKROYD'),(59,'DUSTIN','TAUTOU'),(60,'HENRY','BERRY'),(61,'CHRISTIAN','NEESON'),(62,'JAYNE','NEESON'),(63,'CAMERON','WRAY'),(64,'RAY','JOHANSSON'),(65,'ANGELA','HUDSON'),(66,'MARY','TANDY'),(67,'JESSICA','BAILEY'),(68,'RIP','WINSLET'),(69,'KENNETH','PALTROW'),(70,'MICHELLE','MCCONAUGHEY'),(71,'ADAM','GRANT'),(72,'SEAN','WILLIAMS'),(73,'GARY','PENN'),(74,'MILLA','KEITEL'),(75,'BURT','POSEY'),(76,'ANGELINA','ASTAIRE'),(77,'CARY','MCCONAUGHEY'),(78,'GROUCHO','SINATRA'),(79,'MAE','HOFFMAN'),(80,'RALPH','CRUZ'),(81,'SCARLETT','DAMON'),(82,'WOODY','JOLIE'),(83,'BEN','WILLIS'),(84,'JAMES','PITT'),(85,'MINNIE','ZELLWEGER'),(86,'GREG','CHAPLIN'),(87,'SPENCER','PECK'),(88,'KENNETH','PESCI'),(89,'CHARLIZE','DENCH'),(90,'SEAN','GUINESS'),(91,'CHRISTOPHER','BERRY'),(92,'KIRSTEN','AKROYD'),(93,'ELLEN','PRESLEY'),(94,'KENNETH','TORN'),(95,'DARYL','WAHLBERG'),(96,'GENE','WILLIS'),(97,'MEG','HAWKE'),(98,'CHRIS','BRIDGES'),(99,'JIM','MOSTEL'),(100,'SPENCER','DEPP'),(101,'SUSAN','DAVIS'),(102,'WALTER','TORN'),(103,'MATTHEW','LEIGH'),(104,'PENELOPE','CRONYN'),(105,'SIDNEY','CROWE'),(106,'GROUCHO','DUNST'),(107,'GINA','DEGENERES'),(108,'WARREN','NOLTE'),(109,'SYLVESTER','DERN'),(110,'SUSAN','DAVIS'),(111,'CAMERON','ZELLWEGER'),(112,'RUSSELL','BACALL'),(113,'MORGAN','HOPKINS'),(114,'MORGAN','MCDORMAND'),(115,'HARRISON','BALE'),(116,'DAN','STREEP'),(117,'RENEE','TRACY'),(118,'CUBA','ALLEN'),(119,'WARREN','JACKMAN'),(120,'PENELOPE','MONROE'),(121,'LIZA','BERGMAN'),(122,'SALMA','NOLTE'),(123,'JULIANNE','DENCH'),(124,'SCARLETT','BENING'),(125,'ALBERT','NOLTE'),(126,'FRANCES','TOMEI'),(127,'KEVIN','GARLAND'),(128,'CATE','MCQUEEN'),(129,'DARYL','CRAWFORD'),(130,'GRETA','KEITEL'),(131,'JANE','JACKMAN'),(132,'ADAM','HOPPER'),(133,'RICHARD','PENN'),(134,'GENE','HOPKINS'),(135,'RITA','REYNOLDS'),(136,'ED','MANSFIELD'),(137,'MORGAN','WILLIAMS'),(138,'LUCILLE','DEE'),(139,'EWAN','GOODING'),(140,'WHOOPI','HURT'),(141,'CATE','HARRIS'),(142,'JADA','RYDER'),(143,'RIVER','DEAN'),(144,'ANGELA','WITHERSPOON'),(145,'KIM','ALLEN'),(146,'ALBERT','JOHANSSON'),(147,'FAY','WINSLET'),(148,'EMILY','DEE'),(149,'RUSSELL','TEMPLE'),(150,'JAYNE','NOLTE'),(151,'GEOFFREY','HESTON'),(152,'BEN','HARRIS'),(153,'MINNIE','KILMER'),(154,'MERYL','GIBSON'),(155,'IAN','TANDY'),(156,'FAY','WOOD'),(157,'GRETA','MALDEN'),(158,'VIVIEN','BASINGER'),(159,'LAURA','BRODY'),(160,'CHRIS','DEPP'),(161,'HARVEY','HOPE'),(162,'OPRAH','KILMER'),(163,'CHRISTOPHER','WEST'),(164,'HUMPHREY','WILLIS'),(165,'AL','GARLAND'),(166,'NICK','DEGENERES'),(167,'LAURENCE','BULLOCK'),(168,'WILL','WILSON'),(169,'KENNETH','HOFFMAN'),(170,'MENA','HOPPER'),(171,'OLYMPIA','PFEIFFER'),(172,'GROUCHO','WILLIAMS'),(173,'ALAN','DREYFUSS'),(174,'MICHAEL','BENING'),(175,'WILLIAM','HACKMAN'),(176,'JON','CHASE'),(177,'GENE','MCKELLEN'),(178,'LISA','MONROE'),(179,'ED','GUINESS'),(180,'JEFF','SILVERSTONE'),(181,'MATTHEW','CARREY'),(182,'DEBBIE','AKROYD'),(183,'RUSSELL','CLOSE'),(184,'HUMPHREY','GARLAND'),(185,'MICHAEL','BOLGER'),(186,'JULIA','ZELLWEGER'),(187,'RENEE','BALL'),(188,'ROCK','DUKAKIS'),(189,'CUBA','BIRCH'),(190,'AUDREY','BAILEY'),(191,'GREGORY','GOODING'),(192,'JOHN','SUVARI'),(193,'BURT','TEMPLE'),(194,'MERYL','ALLEN'),(195,'JAYNE','SILVERSTONE'),(196,'BELA','WALKEN'),(197,'REESE','WEST'),(198,'MARY','KEITEL'),(199,'JULIA','FAWCETT'),(200,'THORA','TEMPLE');
/*!40000 ALTER TABLE `characternamereference` ENABLE KEYS */;

--
-- Dumping data for table `city`
--

/*!40000 ALTER TABLE `city` DISABLE KEYS */;
/*!40000 ALTER TABLE `city` ENABLE KEYS */;

--
-- Dumping data for table `citynamereference`
--

/*!40000 ALTER TABLE `citynamereference` DISABLE KEYS */;
INSERT INTO `citynamereference` VALUES (1,'A Corua (La Corua)'),(2,'Abha'),(3,'Abu Dhabi'),(4,'Acua'),(5,'Adana'),(6,'Addis Abeba'),(7,'Aden'),(8,'Adoni'),(9,'Ahmadnagar'),(10,'Akishima'),(11,'Akron'),(12,'al-Ayn'),(13,'al-Hawiya'),(14,'al-Manama'),(15,'al-Qadarif'),(16,'al-Qatif'),(17,'Alessandria'),(18,'Allappuzha (Alleppey)'),(19,'Allende'),(20,'Almirante Brown'),(21,'Alvorada'),(22,'Ambattur'),(23,'Amersfoort'),(24,'Amroha'),(25,'Angra dos Reis'),(26,'Anpolis'),(27,'Antofagasta'),(28,'Aparecida de Goinia'),(29,'Apeldoorn'),(30,'Araatuba'),(31,'Arak'),(32,'Arecibo'),(33,'Arlington'),(34,'Ashdod'),(35,'Ashgabat'),(36,'Ashqelon'),(37,'Asuncin'),(38,'Athenai'),(39,'Atinsk'),(40,'Atlixco'),(41,'Augusta-Richmond County'),(42,'Aurora'),(43,'Avellaneda'),(44,'Bag'),(45,'Baha Blanca'),(46,'Baicheng'),(47,'Baiyin'),(48,'Baku'),(49,'Balaiha'),(50,'Balikesir'),(51,'Balurghat'),(52,'Bamenda'),(53,'Bandar Seri Begawan'),(54,'Banjul'),(55,'Barcelona'),(56,'Basel'),(57,'Bat Yam'),(58,'Batman'),(59,'Batna'),(60,'Battambang'),(61,'Baybay'),(62,'Bayugan'),(63,'Bchar'),(64,'Beira'),(65,'Bellevue'),(66,'Belm'),(67,'Benguela'),(68,'Beni-Mellal'),(69,'Benin City'),(70,'Bergamo'),(71,'Berhampore (Baharampur)'),(72,'Bern'),(73,'Bhavnagar'),(74,'Bhilwara'),(75,'Bhimavaram'),(76,'Bhopal'),(77,'Bhusawal'),(78,'Bijapur'),(79,'Bilbays'),(80,'Binzhou'),(81,'Birgunj'),(82,'Bislig'),(83,'Blumenau'),(84,'Boa Vista'),(85,'Boksburg'),(86,'Botosani'),(87,'Botshabelo'),(88,'Bradford'),(89,'Braslia'),(90,'Bratislava'),(91,'Brescia'),(92,'Brest'),(93,'Brindisi'),(94,'Brockton'),(95,'Bucuresti'),(96,'Buenaventura'),(97,'Bydgoszcz'),(98,'Cabuyao'),(99,'Callao'),(100,'Cam Ranh'),(101,'Cape Coral'),(102,'Caracas'),(103,'Carmen'),(104,'Cavite'),(105,'Cayenne'),(106,'Celaya'),(107,'Chandrapur'),(108,'Changhwa'),(109,'Changzhou'),(110,'Chapra'),(111,'Charlotte Amalie'),(112,'Chatsworth'),(113,'Cheju'),(114,'Chiayi'),(115,'Chisinau'),(116,'Chungho'),(117,'Cianjur'),(118,'Ciomas'),(119,'Ciparay'),(120,'Citrus Heights'),(121,'Citt del Vaticano'),(122,'Ciudad del Este'),(123,'Clarksville'),(124,'Coacalco de Berriozbal'),(125,'Coatzacoalcos'),(126,'Compton'),(127,'Coquimbo'),(128,'Crdoba'),(129,'Cuauhtmoc'),(130,'Cuautla'),(131,'Cuernavaca'),(132,'Cuman'),(133,'Czestochowa'),(134,'Dadu'),(135,'Dallas'),(136,'Datong'),(137,'Daugavpils'),(138,'Davao'),(139,'Daxian'),(140,'Dayton'),(141,'Deba Habe'),(142,'Denizli'),(143,'Dhaka'),(144,'Dhule (Dhulia)'),(145,'Dongying'),(146,'Donostia-San Sebastin'),(147,'Dos Quebradas'),(148,'Duisburg'),(149,'Dundee'),(150,'Dzerzinsk'),(151,'Ede'),(152,'Effon-Alaiye'),(153,'El Alto'),(154,'El Fuerte'),(155,'El Monte'),(156,'Elista'),(157,'Emeishan'),(158,'Emmen'),(159,'Enshi'),(160,'Erlangen'),(161,'Escobar'),(162,'Esfahan'),(163,'Eskisehir'),(164,'Etawah'),(165,'Ezeiza'),(166,'Ezhou'),(167,'Faaa'),(168,'Fengshan'),(169,'Firozabad'),(170,'Florencia'),(171,'Fontana'),(172,'Fukuyama'),(173,'Funafuti'),(174,'Fuyu'),(175,'Fuzhou'),(176,'Gandhinagar'),(177,'Garden Grove'),(178,'Garland'),(179,'Gatineau'),(180,'Gaziantep'),(181,'Gijn'),(182,'Gingoog'),(183,'Goinia'),(184,'Gorontalo'),(185,'Grand Prairie'),(186,'Graz'),(187,'Greensboro'),(188,'Guadalajara'),(189,'Guaruj'),(190,'guas Lindas de Gois'),(191,'Gulbarga'),(192,'Hagonoy'),(193,'Haining'),(194,'Haiphong'),(195,'Haldia'),(196,'Halifax'),(197,'Halisahar'),(198,'Halle/Saale'),(199,'Hami'),(200,'Hamilton'),(201,'Hanoi'),(202,'Hidalgo'),(203,'Higashiosaka'),(204,'Hino'),(205,'Hiroshima'),(206,'Hodeida'),(207,'Hohhot'),(208,'Hoshiarpur'),(209,'Hsichuh'),(210,'Huaian'),(211,'Hubli-Dharwad'),(212,'Huejutla de Reyes'),(213,'Huixquilucan'),(214,'Hunuco'),(215,'Ibirit'),(216,'Idfu'),(217,'Ife'),(218,'Ikerre'),(219,'Iligan'),(220,'Ilorin'),(221,'Imus'),(222,'Inegl'),(223,'Ipoh'),(224,'Isesaki'),(225,'Ivanovo'),(226,'Iwaki'),(227,'Iwakuni'),(228,'Iwatsuki'),(229,'Izumisano'),(230,'Jaffna'),(231,'Jaipur'),(232,'Jakarta'),(233,'Jalib al-Shuyukh'),(234,'Jamalpur'),(235,'Jaroslavl'),(236,'Jastrzebie-Zdrj'),(237,'Jedda'),(238,'Jelets'),(239,'Jhansi'),(240,'Jinchang'),(241,'Jining'),(242,'Jinzhou'),(243,'Jodhpur'),(244,'Johannesburg'),(245,'Joliet'),(246,'Jos Azueta'),(247,'Juazeiro do Norte'),(248,'Juiz de Fora'),(249,'Junan'),(250,'Jurez'),(251,'Kabul'),(252,'Kaduna'),(253,'Kakamigahara'),(254,'Kaliningrad'),(255,'Kalisz'),(256,'Kamakura'),(257,'Kamarhati'),(258,'Kamjanets-Podilskyi'),(259,'Kamyin'),(260,'Kanazawa'),(261,'Kanchrapara'),(262,'Kansas City'),(263,'Karnal'),(264,'Katihar'),(265,'Kermanshah'),(266,'Kilis'),(267,'Kimberley'),(268,'Kimchon'),(269,'Kingstown'),(270,'Kirovo-Tepetsk'),(271,'Kisumu'),(272,'Kitwe'),(273,'Klerksdorp'),(274,'Kolpino'),(275,'Konotop'),(276,'Koriyama'),(277,'Korla'),(278,'Korolev'),(279,'Kowloon and New Kowloon'),(280,'Kragujevac'),(281,'Ktahya'),(282,'Kuching'),(283,'Kumbakonam'),(284,'Kurashiki'),(285,'Kurgan'),(286,'Kursk'),(287,'Kuwana'),(288,'La Paz'),(289,'La Plata'),(290,'La Romana'),(291,'Laiwu'),(292,'Lancaster'),(293,'Laohekou'),(294,'Lapu-Lapu'),(295,'Laredo'),(296,'Lausanne'),(297,'Le Mans'),(298,'Lengshuijiang'),(299,'Leshan'),(300,'Lethbridge'),(301,'Lhokseumawe'),(302,'Liaocheng'),(303,'Liepaja'),(304,'Lilongwe'),(305,'Lima'),(306,'Lincoln'),(307,'Linz'),(308,'Lipetsk'),(309,'Livorno'),(310,'Ljubertsy'),(311,'Loja'),(312,'London'),(313,'London'),(314,'Lublin'),(315,'Lubumbashi'),(316,'Lungtan'),(317,'Luzinia'),(318,'Madiun'),(319,'Mahajanga'),(320,'Maikop'),(321,'Malm'),(322,'Manchester'),(323,'Mandaluyong'),(324,'Mandi Bahauddin'),(325,'Mannheim'),(326,'Maracabo'),(327,'Mardan'),(328,'Maring'),(329,'Masqat'),(330,'Matamoros'),(331,'Matsue'),(332,'Meixian'),(333,'Memphis'),(334,'Merlo'),(335,'Mexicali'),(336,'Miraj'),(337,'Mit Ghamr'),(338,'Miyakonojo'),(339,'Mogiljov'),(340,'Molodetno'),(341,'Monclova'),(342,'Monywa'),(343,'Moscow'),(344,'Mosul'),(345,'Mukateve'),(346,'Munger (Monghyr)'),(347,'Mwanza'),(348,'Mwene-Ditu'),(349,'Myingyan'),(350,'Mysore'),(351,'Naala-Porto'),(352,'Nabereznyje Telny'),(353,'Nador'),(354,'Nagaon'),(355,'Nagareyama'),(356,'Najafabad'),(357,'Naju'),(358,'Nakhon Sawan'),(359,'Nam Dinh'),(360,'Namibe'),(361,'Nantou'),(362,'Nanyang'),(363,'NDjamna'),(364,'Newcastle'),(365,'Nezahualcyotl'),(366,'Nha Trang'),(367,'Niznekamsk'),(368,'Novi Sad'),(369,'Novoterkassk'),(370,'Nukualofa'),(371,'Nuuk'),(372,'Nyeri'),(373,'Ocumare del Tuy'),(374,'Ogbomosho'),(375,'Okara'),(376,'Okayama'),(377,'Okinawa'),(378,'Olomouc'),(379,'Omdurman'),(380,'Omiya'),(381,'Ondo'),(382,'Onomichi'),(383,'Oshawa'),(384,'Osmaniye'),(385,'ostka'),(386,'Otsu'),(387,'Oulu'),(388,'Ourense (Orense)'),(389,'Owo'),(390,'Oyo'),(391,'Ozamis'),(392,'Paarl'),(393,'Pachuca de Soto'),(394,'Pak Kret'),(395,'Palghat (Palakkad)'),(396,'Pangkal Pinang'),(397,'Papeete'),(398,'Parbhani'),(399,'Pathankot'),(400,'Patiala'),(401,'Patras'),(402,'Pavlodar'),(403,'Pemalang'),(404,'Peoria'),(405,'Pereira'),(406,'Phnom Penh'),(407,'Pingxiang'),(408,'Pjatigorsk'),(409,'Plock'),(410,'Po'),(411,'Ponce'),(412,'Pontianak'),(413,'Poos de Caldas'),(414,'Portoviejo'),(415,'Probolinggo'),(416,'Pudukkottai'),(417,'Pune'),(418,'Purnea (Purnia)'),(419,'Purwakarta'),(420,'Pyongyang'),(421,'Qalyub'),(422,'Qinhuangdao'),(423,'Qomsheh'),(424,'Quilmes'),(425,'Rae Bareli'),(426,'Rajkot'),(427,'Rampur'),(428,'Rancagua'),(429,'Ranchi'),(430,'Richmond Hill'),(431,'Rio Claro'),(432,'Rizhao'),(433,'Roanoke'),(434,'Robamba'),(435,'Rockford'),(436,'Ruse'),(437,'Rustenburg'),(438,'s-Hertogenbosch'),(439,'Saarbrcken'),(440,'Sagamihara'),(441,'Saint Louis'),(442,'Saint-Denis'),(443,'Sal'),(444,'Salala'),(445,'Salamanca'),(446,'Salinas'),(447,'Salzburg'),(448,'Sambhal'),(449,'San Bernardino'),(450,'San Felipe de Puerto Plata'),(451,'San Felipe del Progreso'),(452,'San Juan Bautista Tuxtepec'),(453,'San Lorenzo'),(454,'San Miguel de Tucumn'),(455,'Sanaa'),(456,'Santa Brbara dOeste'),(457,'Santa F'),(458,'Santa Rosa'),(459,'Santiago de Compostela'),(460,'Santiago de los Caballeros'),(461,'Santo Andr'),(462,'Sanya'),(463,'Sasebo'),(464,'Satna'),(465,'Sawhaj'),(466,'Serpuhov'),(467,'Shahr-e Kord'),(468,'Shanwei'),(469,'Shaoguan'),(470,'Sharja'),(471,'Shenzhen'),(472,'Shikarpur'),(473,'Shimoga'),(474,'Shimonoseki'),(475,'Shivapuri'),(476,'Shubra al-Khayma'),(477,'Siegen'),(478,'Siliguri (Shiliguri)'),(479,'Simferopol'),(480,'Sincelejo'),(481,'Sirjan'),(482,'Sivas'),(483,'Skikda'),(484,'Smolensk'),(485,'So Bernardo do Campo'),(486,'So Leopoldo'),(487,'Sogamoso'),(488,'Sokoto'),(489,'Songkhla'),(490,'Sorocaba'),(491,'Soshanguve'),(492,'Sousse'),(493,'South Hill'),(494,'Southampton'),(495,'Southend-on-Sea'),(496,'Southport'),(497,'Springs'),(498,'Stara Zagora'),(499,'Sterling Heights'),(500,'Stockport'),(501,'Sucre'),(502,'Suihua'),(503,'Sullana'),(504,'Sultanbeyli'),(505,'Sumqayit'),(506,'Sumy'),(507,'Sungai Petani'),(508,'Sunnyvale'),(509,'Surakarta'),(510,'Syktyvkar'),(511,'Syrakusa'),(512,'Szkesfehrvr'),(513,'Tabora'),(514,'Tabriz'),(515,'Tabuk'),(516,'Tafuna'),(517,'Taguig'),(518,'Taizz'),(519,'Talavera'),(520,'Tallahassee'),(521,'Tama'),(522,'Tambaram'),(523,'Tanauan'),(524,'Tandil'),(525,'Tangail'),(526,'Tanshui'),(527,'Tanza'),(528,'Tarlac'),(529,'Tarsus'),(530,'Tartu'),(531,'Teboksary'),(532,'Tegal'),(533,'Tel Aviv-Jaffa'),(534,'Tete'),(535,'Tianjin'),(536,'Tiefa'),(537,'Tieli'),(538,'Tokat'),(539,'Tonghae'),(540,'Tongliao'),(541,'Torren'),(542,'Touliu'),(543,'Toulon'),(544,'Toulouse'),(545,'Trshavn'),(546,'Tsaotun'),(547,'Tsuyama'),(548,'Tuguegarao'),(549,'Tychy'),(550,'Udaipur'),(551,'Udine'),(552,'Ueda'),(553,'Uijongbu'),(554,'Uluberia'),(555,'Urawa'),(556,'Uruapan'),(557,'Usak'),(558,'Usolje-Sibirskoje'),(559,'Uttarpara-Kotrung'),(560,'Vaduz'),(561,'Valencia'),(562,'Valle de la Pascua'),(563,'Valle de Santiago'),(564,'Valparai'),(565,'Vancouver'),(566,'Varanasi (Benares)'),(567,'Vicente Lpez'),(568,'Vijayawada'),(569,'Vila Velha'),(570,'Vilnius'),(571,'Vinh'),(572,'Vitria de Santo Anto'),(573,'Warren'),(574,'Weifang'),(575,'Witten'),(576,'Woodridge'),(577,'Wroclaw'),(578,'Xiangfan'),(579,'Xiangtan'),(580,'Xintai'),(581,'Xinxiang'),(582,'Yamuna Nagar'),(583,'Yangor'),(584,'Yantai'),(585,'Yaound'),(586,'Yerevan'),(587,'Yinchuan'),(588,'Yingkou'),(589,'York'),(590,'Yuncheng'),(591,'Yuzhou'),(592,'Zalantun'),(593,'Zanzibar'),(594,'Zaoyang'),(595,'Zapopan'),(596,'Zaria'),(597,'Zeleznogorsk'),(598,'Zhezqazghan'),(599,'Zhoushan'),(600,'Ziguinchor');
/*!40000 ALTER TABLE `citynamereference` ENABLE KEYS */;

--
-- Dumping data for table `conversation`
--

/*!40000 ALTER TABLE `conversation` DISABLE KEYS */;
/*!40000 ALTER TABLE `conversation` ENABLE KEYS */;

--
-- Dumping data for table `deck`
--

/*!40000 ALTER TABLE `deck` DISABLE KEYS */;
INSERT INTO `deck` VALUES (1,'Commun tongue');
/*!40000 ALTER TABLE `deck` ENABLE KEYS */;

--
-- Dumping data for table `deck_expression`
--

/*!40000 ALTER TABLE `deck_expression` DISABLE KEYS */;
INSERT INTO `deck_expression` VALUES (1,1),(1,2),(1,3),(1,4),(1,5),(1,6),(1,7),(1,8);
/*!40000 ALTER TABLE `deck_expression` ENABLE KEYS */;

--
-- Dumping data for table `demand`
--

/*!40000 ALTER TABLE `demand` DISABLE KEYS */;
/*!40000 ALTER TABLE `demand` ENABLE KEYS */;

--
-- Dumping data for table `expression`
--

/*!40000 ALTER TABLE `expression` DISABLE KEYS */;
INSERT INTO `expression` VALUES (1,'state facts',' ','O:33:\"homeplanet\\validator\\ValidatorAnd\":1:{s:37:\"\0homeplanet\\validator\\ValidatorAnd\0_a\";a:1:{i:0;O:45:\"homeplanet\\validator\\conversation\\TailRequire\":1:{s:59:\"\0homeplanet\\validator\\conversation\\TailRequire\0_iPointIndex\";i:0;}}}','a:4:{i:0;O:41:\"homeplanet\\modifier\\conversation\\AddPoint\":2:{s:50:\"\0homeplanet\\modifier\\conversation\\AddPoint\0_iValue\";i:1;s:55:\"\0homeplanet\\modifier\\conversation\\AddPoint\0_iPointIndex\";i:0;}i:1;O:41:\"homeplanet\\modifier\\conversation\\AddPoint\":2:{s:50:\"\0homeplanet\\modifier\\conversation\\AddPoint\0_iValue\";i:1;s:55:\"\0homeplanet\\modifier\\conversation\\AddPoint\0_iPointIndex\";i:1;}i:2;O:41:\"homeplanet\\modifier\\conversation\\AddPoint\":2:{s:50:\"\0homeplanet\\modifier\\conversation\\AddPoint\0_iValue\";i:1;s:55:\"\0homeplanet\\modifier\\conversation\\AddPoint\0_iPointIndex\";i:3;}i:3;O:40:\"homeplanet\\modifier\\conversation\\AddTail\":1:{s:54:\"\0homeplanet\\modifier\\conversation\\AddTail\0_aPointIndex\";a:3:{i:0;i:0;i:1;i:1;i:2;i:3;}}}',NULL),(2,'prove',' ','O:33:\"homeplanet\\validator\\ValidatorAnd\":1:{s:37:\"\0homeplanet\\validator\\ValidatorAnd\0_a\";a:1:{i:0;O:45:\"homeplanet\\validator\\conversation\\TailRequire\":1:{s:59:\"\0homeplanet\\validator\\conversation\\TailRequire\0_iPointIndex\";i:0;}}}','a:2:{i:0;O:40:\"homeplanet\\modifier\\conversation\\AddTail\":1:{s:54:\"\0homeplanet\\modifier\\conversation\\AddTail\0_aPointIndex\";a:3:{i:0;i:0;i:1;i:1;i:2;i:3;}}i:1;O:42:\"homeplanet\\modifier\\conversation\\AddDebate\":1:{s:51:\"\0homeplanet\\modifier\\conversation\\AddDebate\0_iValue\";i:1;}}',NULL),(3,'yell',' ','O:33:\"homeplanet\\validator\\ValidatorAnd\":1:{s:37:\"\0homeplanet\\validator\\ValidatorAnd\0_a\";a:1:{i:0;O:45:\"homeplanet\\validator\\conversation\\TailRequire\":1:{s:59:\"\0homeplanet\\validator\\conversation\\TailRequire\0_iPointIndex\";i:1;}}}','a:4:{i:0;O:41:\"homeplanet\\modifier\\conversation\\AddPoint\":2:{s:50:\"\0homeplanet\\modifier\\conversation\\AddPoint\0_iValue\";i:1;s:55:\"\0homeplanet\\modifier\\conversation\\AddPoint\0_iPointIndex\";i:0;}i:1;O:41:\"homeplanet\\modifier\\conversation\\AddPoint\":2:{s:50:\"\0homeplanet\\modifier\\conversation\\AddPoint\0_iValue\";i:1;s:55:\"\0homeplanet\\modifier\\conversation\\AddPoint\0_iPointIndex\";i:1;}i:2;O:41:\"homeplanet\\modifier\\conversation\\AddPoint\":2:{s:50:\"\0homeplanet\\modifier\\conversation\\AddPoint\0_iValue\";i:1;s:55:\"\0homeplanet\\modifier\\conversation\\AddPoint\0_iPointIndex\";i:2;}i:3;O:40:\"homeplanet\\modifier\\conversation\\AddTail\":1:{s:54:\"\0homeplanet\\modifier\\conversation\\AddTail\0_aPointIndex\";a:3:{i:0;i:0;i:1;i:1;i:2;i:2;}}}',NULL),(4,'command',' ','O:33:\"homeplanet\\validator\\ValidatorAnd\":1:{s:37:\"\0homeplanet\\validator\\ValidatorAnd\0_a\";a:1:{i:0;O:45:\"homeplanet\\validator\\conversation\\TailRequire\":1:{s:59:\"\0homeplanet\\validator\\conversation\\TailRequire\0_iPointIndex\";i:1;}}}','a:2:{i:0;O:40:\"homeplanet\\modifier\\conversation\\AddTail\":1:{s:54:\"\0homeplanet\\modifier\\conversation\\AddTail\0_aPointIndex\";a:3:{i:0;i:0;i:1;i:1;i:2;i:2;}}i:1;O:42:\"homeplanet\\modifier\\conversation\\AddDebate\":1:{s:51:\"\0homeplanet\\modifier\\conversation\\AddDebate\0_iValue\";i:1;}}',NULL),(5,'poetry',' ','O:33:\"homeplanet\\validator\\ValidatorAnd\":1:{s:37:\"\0homeplanet\\validator\\ValidatorAnd\0_a\";a:1:{i:0;O:45:\"homeplanet\\validator\\conversation\\TailRequire\":1:{s:59:\"\0homeplanet\\validator\\conversation\\TailRequire\0_iPointIndex\";i:2;}}}','a:4:{i:0;O:41:\"homeplanet\\modifier\\conversation\\AddPoint\":2:{s:50:\"\0homeplanet\\modifier\\conversation\\AddPoint\0_iValue\";i:1;s:55:\"\0homeplanet\\modifier\\conversation\\AddPoint\0_iPointIndex\";i:0;}i:1;O:41:\"homeplanet\\modifier\\conversation\\AddPoint\":2:{s:50:\"\0homeplanet\\modifier\\conversation\\AddPoint\0_iValue\";i:1;s:55:\"\0homeplanet\\modifier\\conversation\\AddPoint\0_iPointIndex\";i:2;}i:2;O:41:\"homeplanet\\modifier\\conversation\\AddPoint\":2:{s:50:\"\0homeplanet\\modifier\\conversation\\AddPoint\0_iValue\";i:1;s:55:\"\0homeplanet\\modifier\\conversation\\AddPoint\0_iPointIndex\";i:3;}i:3;O:40:\"homeplanet\\modifier\\conversation\\AddTail\":1:{s:54:\"\0homeplanet\\modifier\\conversation\\AddTail\0_aPointIndex\";a:3:{i:0;i:0;i:1;i:2;i:2;i:3;}}}',NULL),(6,'sway',' ','O:33:\"homeplanet\\validator\\ValidatorAnd\":1:{s:37:\"\0homeplanet\\validator\\ValidatorAnd\0_a\";a:1:{i:0;O:45:\"homeplanet\\validator\\conversation\\TailRequire\":1:{s:59:\"\0homeplanet\\validator\\conversation\\TailRequire\0_iPointIndex\";i:2;}}}','a:2:{i:0;O:40:\"homeplanet\\modifier\\conversation\\AddTail\":1:{s:54:\"\0homeplanet\\modifier\\conversation\\AddTail\0_aPointIndex\";a:3:{i:0;i:0;i:1;i:2;i:2;i:3;}}i:1;O:42:\"homeplanet\\modifier\\conversation\\AddDebate\":1:{s:51:\"\0homeplanet\\modifier\\conversation\\AddDebate\0_iValue\";i:1;}}',NULL),(7,'joke',' ','O:33:\"homeplanet\\validator\\ValidatorAnd\":1:{s:37:\"\0homeplanet\\validator\\ValidatorAnd\0_a\";a:1:{i:0;O:45:\"homeplanet\\validator\\conversation\\TailRequire\":1:{s:59:\"\0homeplanet\\validator\\conversation\\TailRequire\0_iPointIndex\";i:3;}}}','a:4:{i:0;O:41:\"homeplanet\\modifier\\conversation\\AddPoint\":2:{s:50:\"\0homeplanet\\modifier\\conversation\\AddPoint\0_iValue\";i:1;s:55:\"\0homeplanet\\modifier\\conversation\\AddPoint\0_iPointIndex\";i:1;}i:1;O:41:\"homeplanet\\modifier\\conversation\\AddPoint\":2:{s:50:\"\0homeplanet\\modifier\\conversation\\AddPoint\0_iValue\";i:1;s:55:\"\0homeplanet\\modifier\\conversation\\AddPoint\0_iPointIndex\";i:2;}i:2;O:41:\"homeplanet\\modifier\\conversation\\AddPoint\":2:{s:50:\"\0homeplanet\\modifier\\conversation\\AddPoint\0_iValue\";i:1;s:55:\"\0homeplanet\\modifier\\conversation\\AddPoint\0_iPointIndex\";i:3;}i:3;O:40:\"homeplanet\\modifier\\conversation\\AddTail\":1:{s:54:\"\0homeplanet\\modifier\\conversation\\AddTail\0_aPointIndex\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}}',NULL),(8,'appeal',' ','O:33:\"homeplanet\\validator\\ValidatorAnd\":1:{s:37:\"\0homeplanet\\validator\\ValidatorAnd\0_a\";a:1:{i:0;O:45:\"homeplanet\\validator\\conversation\\TailRequire\":1:{s:59:\"\0homeplanet\\validator\\conversation\\TailRequire\0_iPointIndex\";i:3;}}}','a:2:{i:0;O:40:\"homeplanet\\modifier\\conversation\\AddTail\":1:{s:54:\"\0homeplanet\\modifier\\conversation\\AddTail\0_aPointIndex\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:1;O:42:\"homeplanet\\modifier\\conversation\\AddDebate\":1:{s:51:\"\0homeplanet\\modifier\\conversation\\AddDebate\0_iValue\";i:1;}}',NULL);
/*!40000 ALTER TABLE `expression` ENABLE KEYS */;

--
-- Dumping data for table `gamestate`
--

/*!40000 ALTER TABLE `gamestate` DISABLE KEYS */;
INSERT INTO `gamestate` VALUES (1,61,'Avalon');
/*!40000 ALTER TABLE `gamestate` ENABLE KEYS */;

--
-- Dumping data for table `house`
--

/*!40000 ALTER TABLE `house` DISABLE KEYS */;
/*!40000 ALTER TABLE `house` ENABLE KEYS */;

--
-- Dumping data for table `influencemodifier`
--

/*!40000 ALTER TABLE `influencemodifier` DISABLE KEYS */;
/*!40000 ALTER TABLE `influencemodifier` ENABLE KEYS */;

--
-- Dumping data for table `influencetype`
--

/*!40000 ALTER TABLE `influencetype` DISABLE KEYS */;
INSERT INTO `influencetype` VALUES (1,'economic',10),(2,'politic',10),(3,'military',1),(4,'provider',1);
/*!40000 ALTER TABLE `influencetype` ENABLE KEYS */;

--
-- Dumping data for table `knowledge`
--

/*!40000 ALTER TABLE `knowledge` DISABLE KEYS */;
INSERT INTO `knowledge` VALUES (1,'history part 1',1,NULL,NULL);
/*!40000 ALTER TABLE `knowledge` ENABLE KEYS */;

--
-- Dumping data for table `knowledgecategory`
--

/*!40000 ALTER TABLE `knowledgecategory` DISABLE KEYS */;
INSERT INTO `knowledgecategory` VALUES (1,'lore');
/*!40000 ALTER TABLE `knowledgecategory` ENABLE KEYS */;

--
-- Dumping data for table `pawn`
--

/*!40000 ALTER TABLE `pawn` DISABLE KEYS */;
/*!40000 ALTER TABLE `pawn` ENABLE KEYS */;

--
-- Dumping data for table `pawn_location_assoc`
--

/*!40000 ALTER TABLE `pawn_location_assoc` DISABLE KEYS */;
/*!40000 ALTER TABLE `pawn_location_assoc` ENABLE KEYS */;

--
-- Dumping data for table `pawntype`
--

/*!40000 ALTER TABLE `pawntype` DISABLE KEYS */;
INSERT INTO `pawntype` VALUES (1,1,'farm',100,1,'Produce wheats, honey, fruits and vegetables'),(2,1,'wood cutter',100,1,'Produce wood log'),(3,1,'mine',100,1,'Produce iron and gold'),(5,1,'quarry',1000000000,1,'Produce stone'),(6,1,'hunting camp',100,1,'Produce meat'),(7,1,'fishing boat',100,1,'Produce fish and crustacean'),(8,1,'herb collector',1000000000,1,NULL),(100,2,'sawmill',100,1,'Produce wood plank'),(101,2,'windmill',100,1,'Produce floor'),(103,2,'smelter',100,1,'Smelt and refine metals'),(200,3,'bakery',100,1,'Produce bread and delicacy'),(201,3,'blacksmith',100,1,'Produce sword'),(202,3,'art workshop',100,1,'Produce jewelry, painting and watch'),(203,3,'stable',100,1,'Produce horse'),(204,3,'apothecary',100,1,'Produce medicine and soap'),(205,3,'tailor',100,1,'Produce outfit'),(206,3,'workshop',100,1,'Produce tools, books and toys'),(207,3,'carpenter',100,1,'Produce furniture'),(208,3,'building crew',100,1,'Produce housing'),(209,3,'bookbinder',100,1,'Produce book'),(1000,4,'cart',0,1,'A basic mean of transportation for resources.'),(1001,4,'wagon',100,1,'A four-wheeled vehicle pulled by draught animals.\r\nCan carry ressources further away than a cart.'),(1002,4,'boat',200,1,'A sailing vessel that carries ressources across sea and rivers.'),(2000,5,'traveling merchant',100,1,'A merchant able to sell and buy a wide variety of ressources in small quantity.\r\nIn addition he is also able to travel from town to town.'),(2001,5,'market stall',100,1,'A merchant able to sell end product.'),(2002,5,'restaurant',100,1,'Produce delicacy and sell food'),(3000,6,'contract : manual labor',0,0,NULL);
/*!40000 ALTER TABLE `pawntype` ENABLE KEYS */;

--
-- Dumping data for table `pawntype_attribute`
--

/*!40000 ALTER TABLE `pawntype_attribute` DISABLE KEYS */;
INSERT INTO `pawntype_attribute` VALUES (1000,2),(1001,3),(1002,4);
/*!40000 ALTER TABLE `pawntype_attribute` ENABLE KEYS */;

--
-- Dumping data for table `pawntype_prodtype_assoc`
--

/*!40000 ALTER TABLE `pawntype_prodtype_assoc` DISABLE KEYS */;
INSERT INTO `pawntype_prodtype_assoc` VALUES (1,1002),(101,1003),(2,1004),(100,1005),(203,1006),(205,1007),(3,1008),(103,1009),(3,1010),(103,1011),(5,1012),(8,1014),(200,1100),(6,1101),(7,1102),(1,1103),(1,1104),(206,1110),(205,1111),(204,1112),(208,1113),(207,1115),(203,1116),(209,1122),(206,1123),(200,1130),(202,1131),(202,1132),(202,1133),(201,1141),(2000,2002),(2001,2002),(2000,2003),(2001,2003),(2000,2004),(2001,2004),(2000,2005),(2001,2005),(2000,2006),(2001,2006),(2000,2007),(2001,2007),(2000,2008),(2001,2008),(2000,2009),(2001,2009),(2000,2010),(2001,2010),(2000,2011),(2001,2011),(2000,2012),(2001,2012),(2000,2013),(2001,2013),(2000,2014),(2001,2014),(2000,2033),(2001,2033),(2000,2034),(2001,2034),(2000,2100),(2001,2100),(2000,2101),(2001,2101),(2000,2102),(2001,2102),(2000,2103),(2001,2103),(2000,2104),(2001,2104),(2000,2105),(2001,2105),(2000,2110),(2001,2110),(2000,2111),(2001,2111),(2000,2112),(2001,2112),(2000,2113),(2001,2113),(2000,2115),(2001,2115),(2000,2116),(2001,2116),(2000,2120),(2001,2120),(2000,2121),(2001,2121),(2000,2122),(2001,2122),(2000,2123),(2001,2123),(2000,2130),(2001,2130),(2000,2131),(2001,2131),(2000,2132),(2001,2132),(2000,2133),(2001,2133),(2000,2140),(2001,2140),(2000,2141),(2001,2141),(2000,3002),(2001,3002),(2000,3003),(2001,3003),(2000,3004),(2001,3004),(2000,3005),(2001,3005),(2000,3006),(2001,3006),(2000,3007),(2001,3007),(2000,3008),(2001,3008),(2000,3009),(2001,3009),(2000,3010),(2001,3010),(2000,3011),(2001,3011),(2000,3012),(2001,3012),(2000,3013),(2001,3013),(2000,3014),(2001,3014),(2000,3100),(2001,3100),(2000,3101),(2001,3101),(2000,3102),(2001,3102),(2000,3103),(2001,3103),(2000,3104),(2001,3104),(2000,3105),(2001,3105),(2000,3110),(2001,3110),(2000,3111),(2001,3111),(2000,3112),(2001,3112),(2000,3113),(2001,3113),(2000,3115),(2001,3115),(2000,3116),(2001,3116),(2000,3120),(2001,3120),(2000,3121),(2001,3121),(2000,3122),(2001,3122),(2000,3123),(2001,3123),(2000,3130),(2001,3130),(2000,3131),(2001,3131),(2000,3132),(2001,3132),(2000,3133),(2001,3133),(2000,3140),(2001,3140),(2000,3141),(2001,3141),(3000,3500),(1000,4002),(1001,4002),(1002,4002),(1000,4003),(1001,4003),(1002,4003),(1000,4004),(1001,4004),(1002,4004),(1000,4005),(1001,4005),(1002,4005),(1000,4006),(1001,4006),(1002,4006),(1000,4007),(1001,4007),(1002,4007),(1000,4008),(1001,4008),(1002,4008),(1000,4009),(1001,4009),(1002,4009),(1000,4010),(1001,4010),(1002,4010),(1000,4011),(1001,4011),(1002,4011),(1000,4012),(1001,4012),(1002,4012),(1000,4013),(1001,4013),(1002,4013),(1000,4014),(1001,4014),(1002,4014),(1000,4100),(1001,4100),(1002,4100),(1000,4101),(1001,4101),(1002,4101),(1000,4102),(1001,4102),(1002,4102),(1000,4103),(1001,4103),(1002,4103),(1000,4104),(1001,4104),(1002,4104),(1000,4105),(1001,4105),(1002,4105),(1000,4110),(1001,4110),(1002,4110),(1000,4111),(1001,4111),(1002,4111),(1000,4112),(1001,4112),(1002,4112),(1000,4113),(1001,4113),(1002,4113),(1000,4115),(1001,4115),(1002,4115),(1000,4116),(1001,4116),(1002,4116),(1000,4120),(1001,4120),(1002,4120),(1000,4121),(1001,4121),(1002,4121),(1000,4122),(1001,4122),(1002,4122),(1000,4123),(1001,4123),(1002,4123),(1000,4130),(1001,4130),(1002,4130),(1000,4131),(1001,4131),(1002,4131),(1000,4132),(1001,4132),(1002,4132),(1000,4133),(1001,4133),(1002,4133),(1000,4140),(1001,4140),(1002,4140),(1000,4141),(1001,4141),(1002,4141);
/*!40000 ALTER TABLE `pawntype_prodtype_assoc` ENABLE KEYS */;

--
-- Dumping data for table `pawntypecategory`
--

/*!40000 ALTER TABLE `pawntypecategory` DISABLE KEYS */;
INSERT INTO `pawntypecategory` VALUES (1,'tech zero'),(2,'tech one'),(3,'tech three'),(4,'transporter'),(5,'merchant'),(6,'other');
/*!40000 ALTER TABLE `pawntypecategory` ENABLE KEYS */;

--
-- Dumping data for table `player`
--

/*!40000 ALTER TABLE `player` DISABLE KEYS */;
/*!40000 ALTER TABLE `player` ENABLE KEYS */;

--
-- Dumping data for table `population`
--

/*!40000 ALTER TABLE `population` DISABLE KEYS */;
/*!40000 ALTER TABLE `population` ENABLE KEYS */;

--
-- Dumping data for table `prod`
--

/*!40000 ALTER TABLE `prod` DISABLE KEYS */;
/*!40000 ALTER TABLE `prod` ENABLE KEYS */;

--
-- Dumping data for table `prod_updatequeue`
--

/*!40000 ALTER TABLE `prod_updatequeue` DISABLE KEYS */;
/*!40000 ALTER TABLE `prod_updatequeue` ENABLE KEYS */;

--
-- Dumping data for table `prodinput`
--

/*!40000 ALTER TABLE `prodinput` DISABLE KEYS */;
/*!40000 ALTER TABLE `prodinput` ENABLE KEYS */;

--
-- Dumping data for table `prodinputtype`
--

/*!40000 ALTER TABLE `prodinputtype` DISABLE KEYS */;
INSERT INTO `prodinputtype` VALUES (2,4,1,'wood to plank'),(3,12,1,NULL),(5,2,1,'wheat to floor'),(6,3,1,'floor to bread'),(7,4,1,'transport: wood'),(9,8,1,'iron ore to bar'),(101,5,1,'transport: plank'),(102,2,1,'transport: wheat'),(103,3,1,'transport: floor'),(104,100,1,'transport: bread'),(200,4,1,'sell: wood'),(201,5,1,'sell: plank'),(202,2,1,'sell: wheat'),(203,3,1,'sell: floor'),(204,100,1,'sell: bread'),(10030,2,1,'produce: floor'),(10050,4,1,'produce: wood plank'),(10070,6,1,'produce: cloth'),(10090,8,1,'produce: iron bar'),(10110,10,1,'produce: gold bar'),(10130,4,1,'produce: paper'),(11000,3,1,'produce: bread'),(11100,4,1,'produce: tool'),(11101,9,1,'produce: tool'),(11110,7,1,'produce: outfit'),(11120,14,1,'produce: medicine'),(11130,5,1,'produce: housing'),(11131,12,1,'produce: housing'),(11150,5,1,'produce: furniture'),(11200,101,1,'produce: soap'),(11220,13,1,'produce: book'),(11230,4,1,'produce: toy'),(11231,9,1,'produce: toy'),(11300,100,1,'produce: delicacy'),(11301,121,1,'produce: delicacy'),(11302,103,1,'produce: delicacy'),(11310,7,1,'produce: painting'),(11320,11,1,'produce: jewelry'),(11330,9,1,'produce: watch'),(11331,11,1,'produce: watch'),(11400,5,1,'produce: crate'),(11410,9,1,'produce: weapon'),(20020,2,1,'sell: wheat'),(20030,3,1,'sell: floor'),(20040,4,1,'sell: wood'),(20050,5,1,'sell: wood plank'),(20060,6,1,'sell: wool'),(20070,7,1,'sell: cloth'),(20080,8,1,'sell: iron ore'),(20090,9,1,'sell: iron bar'),(20100,10,1,'sell: gold ore'),(20110,11,1,'sell: gold bar'),(20120,12,1,'sell: stone'),(20130,13,1,'sell: paper'),(20140,14,1,'sell: medecinal herb'),(21000,100,1,'sell: bread'),(21010,101,1,'sell: meat'),(21020,102,1,'sell: fish'),(21030,103,1,'sell: fruit'),(21040,104,1,'sell: vegetable'),(21050,105,1,'sell: crustaceans'),(21100,110,1,'sell: tool'),(21110,111,1,'sell: outfit'),(21120,112,1,'sell: medicine'),(21130,113,1,'sell: housing'),(21150,115,1,'sell: furniture'),(21160,116,1,'sell: horse'),(21200,120,1,'sell: soap'),(21210,121,1,'sell: honey'),(21220,122,1,'sell: book'),(21230,123,1,'sell: toy'),(21300,130,1,'sell: delicacy'),(21310,131,1,'sell: painting'),(21320,132,1,'sell: jewelry'),(21330,133,1,'sell: watch'),(21400,140,1,'sell: crate'),(21410,141,1,'sell: weapon'),(30010,1,NULL,'buy: Credit(sell/buy)'),(30020,1,NULL,'buy: wheat'),(30030,1,NULL,'buy: floor'),(30040,1,NULL,'buy: wood'),(30050,1,NULL,'buy: wood plank'),(30060,1,NULL,'buy: wool'),(30070,1,NULL,'buy: cloth'),(30080,1,NULL,'buy: iron ore'),(30090,1,NULL,'buy: iron bar'),(30100,1,NULL,'buy: gold ore'),(30110,1,NULL,'buy: gold bar'),(30120,1,NULL,'buy: stone'),(30130,1,NULL,'buy: paper'),(30140,1,NULL,'buy: medecinal herb'),(30330,1,NULL,'buy: field'),(30340,1,NULL,'buy: forest'),(30350,1,NULL,'buy: fish deposit'),(30360,1,NULL,'buy: crustacean deposit'),(30370,1,NULL,'buy: stone deposit'),(30440,1,NULL,'buy: iron deposit'),(30450,1,NULL,'buy: gold deposit'),(31000,1,NULL,'buy: bread'),(31010,1,NULL,'buy: meat'),(31020,1,NULL,'buy: fish'),(31030,1,NULL,'buy: fruit'),(31040,1,NULL,'buy: vegetable'),(31050,1,NULL,'buy: crustaceans'),(31100,1,NULL,'buy: tool'),(31110,1,NULL,'buy: outfit'),(31120,1,NULL,'buy: medicine'),(31130,1,NULL,'buy: housing'),(31150,1,NULL,'buy: furniture'),(31160,1,NULL,'buy: horse'),(31200,1,NULL,'buy: soap'),(31210,1,NULL,'buy: honey'),(31220,1,NULL,'buy: book'),(31230,1,NULL,'buy: toy'),(31300,1,NULL,'buy: delicacy'),(31310,1,NULL,'buy: painting'),(31320,1,NULL,'buy: jewelry'),(31330,1,NULL,'buy: watch'),(31400,1,NULL,'buy: crate'),(31410,1,NULL,'buy: weapon'),(40010,1,1,'transport: Credit(sell/buy)'),(40020,2,1,'transport: wheat'),(40030,3,1,'transport: floor'),(40040,4,1,'transport: wood'),(40050,5,1,'transport: wood plank'),(40060,6,1,'transport: wool'),(40070,7,1,'transport: cloth'),(40080,8,1,'transport: iron ore'),(40090,9,1,'transport: iron bar'),(40100,10,1,'transport: gold ore'),(40110,11,1,'transport: gold bar'),(40120,12,1,'transport: stone'),(40130,13,1,'transport: paper'),(40140,14,1,'transport: medecinal herb'),(41000,100,1,'transport: bread'),(41010,101,1,'transport: meat'),(41020,102,1,'transport: fish'),(41030,103,1,'transport: fruit'),(41040,104,1,'transport: vegetable'),(41050,105,1,'transport: crustaceans'),(41100,110,1,'transport: tool'),(41110,111,1,'transport: outfit'),(41120,112,1,'transport: medicine'),(41130,113,1,'transport: housing'),(41150,115,1,'transport: furniture'),(41160,116,1,'transport: horse'),(41200,120,1,'transport: soap'),(41210,121,1,'transport: honey'),(41220,122,1,'transport: book'),(41230,123,1,'transport: toy'),(41300,130,1,'transport: delicacy'),(41310,131,1,'transport: painting'),(41320,132,1,'transport: jewelry'),(41330,133,1,'transport: watch'),(41400,140,1,'transport: crate'),(41410,141,1,'transport: weapon'),(50000,500,1,'require : manual labor'),(50001,500,5,'require : large manual labor');
/*!40000 ALTER TABLE `prodinputtype` ENABLE KEYS */;

--
-- Dumping data for table `prodtype`
--

/*!40000 ALTER TABLE `prodtype` DISABLE KEYS */;
INSERT INTO `prodtype` VALUES (2,4,1,'pinewood cuter'),(3,5,1,'pinewood saw'),(5,110,1,'tool'),(7,3,1,'whet to floor'),(8,100,1,'floor to bread'),(9,4,1,'transport: pinewood'),(10,8,1,'iron deposit to ore'),(11,9,1,'iron ore to bar'),(101,5,1,'transport: pinewood plank'),(102,2,1,'transport: wheat'),(103,3,1,'transport: floor'),(104,100,1,'transport: bread'),(140,12,1,'stone'),(200,1,1,'sell: pinewood'),(201,1,1,'sell: plank'),(202,1,1,'sell: wheat'),(203,1,1,'sell: floor'),(204,1,1,'sell: bread'),(300,4,1,'buy: wood'),(301,5,1,'buy: plank'),(302,2,1,'buy: wheat'),(303,3,1,'buy: floor'),(490,2,1,'field to wheat'),(1002,2,1,'produce: wheat'),(1003,3,1,'produce: floor'),(1004,4,1,'produce: wood'),(1005,5,1,'produce: wood plank'),(1006,6,1,'produce: wool'),(1007,7,1,'produce: cloth'),(1008,8,1,'produce: iron ore'),(1009,9,1,'produce: iron bar'),(1010,10,1,'produce: gold ore'),(1011,11,1,'produce: gold bar'),(1012,12,1,'produce: stone'),(1013,13,1,'produce: paper'),(1014,14,1,'produce: medecinal herb'),(1100,100,1,'produce: bread'),(1101,101,1,'produce: meat'),(1102,102,1,'produce: fish'),(1103,103,1,'produce: fruit'),(1104,104,1,'produce: vegetable'),(1105,105,1,'produce: crustaceans'),(1110,110,1,'produce: tool'),(1111,111,1,'produce: outfit'),(1112,112,1,'produce: medicine'),(1113,113,1,'produce: housing'),(1115,115,1,'produce: furniture'),(1116,116,1,'produce: horse'),(1120,120,1,'produce: soap'),(1121,121,1,'produce: honey'),(1122,122,1,'produce: book'),(1123,123,1,'produce: toy'),(1130,130,1,'produce: delicacy'),(1131,131,1,'produce: painting'),(1132,132,1,'produce: jewelry'),(1133,133,1,'produce: watch'),(1140,140,1,'produce: crate'),(1141,141,1,'produce: weapon'),(2002,1,1,'sell: wheat'),(2003,1,1,'sell: floor'),(2004,1,1,'sell: wood'),(2005,1,1,'sell: wood plank'),(2006,1,1,'sell: wool'),(2007,1,1,'sell: cloth'),(2008,1,1,'sell: iron ore'),(2009,1,1,'sell: iron bar'),(2010,1,1,'sell: gold ore'),(2011,1,1,'sell: gold bar'),(2012,1,1,'sell: stone'),(2013,1,1,'sell: paper'),(2014,1,1,'sell: medecinal herb'),(2033,1,1,'sell: field'),(2034,1,1,'sell: forest'),(2100,1,1,'sell: bread'),(2101,1,1,'sell: meat'),(2102,1,1,'sell: fish'),(2103,1,1,'sell: fruit'),(2104,1,1,'sell: vegetable'),(2105,1,1,'sell: crustaceans'),(2110,1,1,'sell: tool'),(2111,1,1,'sell: outfit'),(2112,1,1,'sell: medicine'),(2113,1,1,'sell: housing'),(2115,1,1,'sell: furniture'),(2116,1,1,'sell: horse'),(2120,1,1,'sell: soap'),(2121,1,1,'sell: honey'),(2122,1,1,'sell: book'),(2123,1,1,'sell: toy'),(2130,1,1,'sell: delicacy'),(2131,1,1,'sell: painting'),(2132,1,1,'sell: jewelry'),(2133,1,1,'sell: watch'),(2140,1,1,'sell: crate'),(2141,1,1,'sell: weapon'),(3002,2,1,'buy: wheat'),(3003,3,1,'buy: floor'),(3004,4,1,'buy: wood'),(3005,5,1,'buy: wood plank'),(3006,6,1,'buy: wool'),(3007,7,1,'buy: cloth'),(3008,8,1,'buy: iron ore'),(3009,9,1,'buy: iron bar'),(3010,10,1,'buy: gold ore'),(3011,11,1,'buy: gold bar'),(3012,12,1,'buy: stone'),(3013,13,1,'buy: paper'),(3014,14,1,'buy: medecinal herb'),(3100,100,1,'buy: bread'),(3101,101,1,'buy: meat'),(3102,102,1,'buy: fish'),(3103,103,1,'buy: fruit'),(3104,104,1,'buy: vegetable'),(3105,105,1,'buy: crustaceans'),(3110,110,1,'buy: tool'),(3111,111,1,'buy: outfit'),(3112,112,1,'buy: medicine'),(3113,113,1,'buy: housing'),(3115,115,1,'buy: furniture'),(3116,116,1,'buy: horse'),(3120,120,1,'buy: soap'),(3121,121,1,'buy: honey'),(3122,122,1,'buy: book'),(3123,123,1,'buy: toy'),(3130,130,1,'buy: delicacy'),(3131,131,1,'buy: painting'),(3132,132,1,'buy: jewelry'),(3133,133,1,'buy: watch'),(3140,140,1,'buy: crate'),(3141,141,1,'buy: weapon'),(3500,500,1,'buy: manual labor'),(4002,2,1,'transport: wheat'),(4003,3,1,'transport: floor'),(4004,4,1,'transport: wood'),(4005,5,1,'transport: wood plank'),(4006,6,1,'transport: wool'),(4007,7,1,'transport: cloth'),(4008,8,1,'transport: iron ore'),(4009,9,1,'transport: iron bar'),(4010,10,1,'transport: gold ore'),(4011,11,1,'transport: gold bar'),(4012,12,1,'transport: stone'),(4013,13,1,'transport: paper'),(4014,14,1,'transport: medecinal herb'),(4100,100,1,'transport: bread'),(4101,101,1,'transport: meat'),(4102,102,1,'transport: fish'),(4103,103,1,'transport: fruit'),(4104,104,1,'transport: vegetable'),(4105,105,1,'transport: crustaceans'),(4110,110,1,'transport: tool'),(4111,111,1,'transport: outfit'),(4112,112,1,'transport: medicine'),(4113,113,1,'transport: housing'),(4115,115,1,'transport: furniture'),(4116,116,1,'transport: horse'),(4120,120,1,'transport: soap'),(4121,121,1,'transport: honey'),(4122,122,1,'transport: book'),(4123,123,1,'transport: toy'),(4130,130,1,'transport: delicacy'),(4131,131,1,'transport: painting'),(4132,132,1,'transport: jewelry'),(4133,133,1,'transport: watch'),(4140,140,1,'transport: crate'),(4141,141,1,'transport: weapon');
/*!40000 ALTER TABLE `prodtype` ENABLE KEYS */;

--
-- Dumping data for table `prodtype_prodinputtype_assoc`
--

/*!40000 ALTER TABLE `prodtype_prodinputtype_assoc` DISABLE KEYS */;
INSERT INTO `prodtype_prodinputtype_assoc` VALUES (1003,10030),(1005,10050),(1007,10070),(1009,10090),(1011,10110),(1013,10130),(1100,11000),(1110,11100),(1110,11101),(1111,11110),(1112,11120),(1113,11130),(1113,11131),(1115,11150),(1120,11200),(1122,11220),(1123,11230),(1123,11231),(1130,11300),(1130,11301),(1130,11302),(1131,11310),(1132,11320),(1133,11330),(1133,11331),(1140,11400),(1141,11410),(2002,20020),(2003,20030),(2004,20040),(2005,20050),(2006,20060),(2007,20070),(2008,20080),(2009,20090),(2010,20100),(2011,20110),(2012,20120),(2013,20130),(2014,20140),(2100,21000),(2101,21010),(2102,21020),(2103,21030),(2104,21040),(2105,21050),(2110,21100),(2111,21110),(2112,21120),(2113,21130),(2115,21150),(2116,21160),(2120,21200),(2121,21210),(2122,21220),(2123,21230),(2130,21300),(2131,21310),(2132,21320),(2133,21330),(2140,21400),(2141,21410),(3002,30020),(3003,30030),(3004,30040),(3005,30050),(3006,30060),(3007,30070),(3008,30080),(3009,30090),(3010,30100),(3011,30110),(3012,30120),(3013,30130),(3014,30140),(3100,31000),(3101,31010),(3102,31020),(3103,31030),(3104,31040),(3105,31050),(3110,31100),(3111,31110),(3112,31120),(3113,31130),(3115,31150),(3116,31160),(3120,31200),(3121,31210),(3122,31220),(3123,31230),(3130,31300),(3131,31310),(3132,31320),(3133,31330),(3140,31400),(3141,31410),(4002,40020),(4003,40030),(4004,40040),(4005,40050),(4006,40060),(4007,40070),(4008,40080),(4009,40090),(4010,40100),(4011,40110),(4012,40120),(4013,40130),(4014,40140),(4100,41000),(4101,41010),(4102,41020),(4103,41030),(4104,41040),(4105,41050),(4110,41100),(4111,41110),(4112,41120),(4113,41130),(4115,41150),(4116,41160),(4120,41200),(4121,41210),(4122,41220),(4123,41230),(4130,41300),(4131,41310),(4132,41320),(4133,41330),(4140,41400),(4141,41410),(1002,50000),(1008,50000),(1012,50000),(1101,50000),(1102,50000),(1103,50000),(1104,50000),(1105,50000),(1010,50001);
/*!40000 ALTER TABLE `prodtype_prodinputtype_assoc` ENABLE KEYS */;

--
-- Dumping data for table `relationshipmodifier`
--

/*!40000 ALTER TABLE `relationshipmodifier` DISABLE KEYS */;
/*!40000 ALTER TABLE `relationshipmodifier` ENABLE KEYS */;

--
-- Dumping data for table `relationshiptype`
--

/*!40000 ALTER TABLE `relationshiptype` DISABLE KEYS */;
INSERT INTO `relationshiptype` VALUES (1,'gift','Sovereign have been given a gift.',10),(2,'allegeance','Allegeance pleage to this soveriegn',100);
/*!40000 ALTER TABLE `relationshiptype` ENABLE KEYS */;

--
-- Dumping data for table `rescategory`
--

/*!40000 ALTER TABLE `rescategory` DISABLE KEYS */;
INSERT INTO `rescategory` VALUES (5,'basic food'),(1,'essential'),(10,'inessential'),(4,'luxury'),(8,'metal bar'),(12,'natural'),(7,'ore'),(11,'special'),(6,'stone'),(13,'tradable');
/*!40000 ALTER TABLE `rescategory` ENABLE KEYS */;

--
-- Dumping data for table `ressource`
--

/*!40000 ALTER TABLE `ressource` DISABLE KEYS */;
INSERT INTO `ressource` VALUES (1,'Credit(sell/buy)',1,0,NULL),(2,'wheat',1,0,NULL),(3,'floor',2,0,NULL),(4,'wood',1,0,NULL),(5,'wood plank',2,0,NULL),(6,'wool',1,0,NULL),(7,'cloth',1,0,NULL),(8,'iron ore',1,0,NULL),(9,'iron bar',1,0,NULL),(10,'gold ore',5,0,NULL),(11,'gold bar',10,0,NULL),(12,'stone',1,0,NULL),(13,'paper',1,0,NULL),(14,'medecinal herb',1,0,NULL),(100,'bread',4,0,NULL),(101,'meat',1,0,NULL),(102,'fish',1,0,NULL),(103,'fruit',1,0,NULL),(104,'vegetable',1,0,NULL),(105,'crustaceans',1,0,NULL),(110,'tool',1,0,NULL),(111,'outfit',1,0,NULL),(112,'medicine',1,0,NULL),(113,'housing',1,0,NULL),(115,'furniture',1,0,NULL),(116,'horse',1,0,NULL),(120,'soap',1,0,NULL),(121,'honey',1,0,NULL),(122,'book',1,0,NULL),(123,'toy',1,0,NULL),(130,'delicacy',1,0,NULL),(131,'painting',1,0,NULL),(132,'jewelry',1,0,NULL),(133,'watch',1,0,NULL),(140,'crate',1,0,NULL),(141,'weapon',1,0,NULL),(500,'manual labor',0,0,NULL);
/*!40000 ALTER TABLE `ressource` ENABLE KEYS */;

--
-- Dumping data for table `ressource_rescategory`
--

/*!40000 ALTER TABLE `ressource_rescategory` DISABLE KEYS */;
INSERT INTO `ressource_rescategory` VALUES (13,2),(13,3),(13,4),(13,5),(13,6),(13,7),(13,8),(13,9),(13,10),(13,11),(13,12),(13,13),(13,14),(5,100),(13,100),(5,101),(13,101),(5,102),(13,102),(5,103),(13,103),(5,104),(13,104),(5,105),(13,105),(1,110),(13,110),(1,111),(13,111),(1,112),(13,112),(1,113),(13,113),(1,115),(13,115),(1,116),(13,116),(10,120),(13,120),(10,121),(13,121),(10,122),(13,122),(10,123),(13,123),(4,130),(13,130),(4,131),(13,131),(4,132),(13,132),(4,133),(13,133),(11,140),(13,140),(11,141),(13,141);
/*!40000 ALTER TABLE `ressource_rescategory` ENABLE KEYS */;

--
-- Dumping data for table `sovereign`
--

/*!40000 ALTER TABLE `sovereign` DISABLE KEYS */;
/*!40000 ALTER TABLE `sovereign` ENABLE KEYS */;

--
-- Dumping data for table `tilecapacityrequirement`
--

/*!40000 ALTER TABLE `tilecapacityrequirement` DISABLE KEYS */;
INSERT INTO `tilecapacityrequirement` VALUES (1,1,33,1),(2,7,35,1),(3,8,34,1),(4,6,34,1),(5,3,37,1),(6,5,37,1),(7,2,34,1);
/*!40000 ALTER TABLE `tilecapacityrequirement` ENABLE KEYS */;

--
-- Dumping data for table `tilecapacitytype`
--

/*!40000 ALTER TABLE `tilecapacitytype` DISABLE KEYS */;
INSERT INTO `tilecapacitytype` VALUES (33,'grassland'),(34,'forest'),(35,'fish deposit'),(36,'crustacean deposit'),(37,'stone deposit'),(44,'iron deposit'),(45,'gold deposit');
/*!40000 ALTER TABLE `tilecapacitytype` ENABLE KEYS */;

--
-- Dumping data for table `user`
--

/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'toto@gmail.com','$2y$12$905JS5gAdmNS.c5VM10ksObhf9sBsWDnl8opgKS6kBJlZ6qxyPIPS'),(2,'titi@gmail.com','$2y$12$905JS5gAdmNS.c5VM10ksObhf9sBsWDnl8opgKS6kBJlZ6qxyPIPS'),(4,'test@toto.com','$2y$12$dwCvQDoF5yd2korjJGsojuxIaWohx4txT1d2PWcynqQJz.omjnELK'),(5,'toto.test@gmail.com','$2y$12$k818k0aIOQBKLW1ykK7.tuN6eiZ1fj0/Z29EkUEV8b.541kPoaOnG');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed
