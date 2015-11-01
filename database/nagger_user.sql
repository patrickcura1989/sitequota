/*
SQLyog Community v10.3 Beta1
MySQL - 5.1.52-community : Database - sitequota
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`sitequota` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `sitequota`;

/*Table structure for table `owning_team` */

DROP TABLE IF EXISTS `owning_team`;

CREATE TABLE `owning_team` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owning_team` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `owning_team` */

insert  into `owning_team`(`id`,`owning_team`) values (1,'BEA L2'),(2,'SWAT'),(3,'BPM');

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `team` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;

/*Data for the table `user` */

insert  into `user`(`id`,`emp_id`,`email`,`first_name`,`last_name`,`team`) values (1,'21666748','adrian-lester.tan@hp.com','Adrian','Tan',1),(25,'21438158',NULL,NULL,NULL,1),(26,'21966671',NULL,NULL,NULL,1),(27,'21705010',NULL,NULL,NULL,1),(28,'21909392',NULL,NULL,NULL,1),(29,'21825216',NULL,NULL,NULL,1),(30,'21696795',NULL,NULL,NULL,1),(31,'21825182',NULL,NULL,NULL,1),(32,'21693099',NULL,NULL,NULL,1),(33,'21603825',NULL,NULL,NULL,1),(34,'21761924',NULL,NULL,NULL,3),(35,'21904844',NULL,NULL,NULL,3),(36,'20375266',NULL,NULL,NULL,3),(37,'21762366',NULL,NULL,NULL,3),(38,'21760520',NULL,NULL,NULL,3),(39,'21900041',NULL,NULL,NULL,3),(40,'21872117',NULL,NULL,NULL,2),(41,'21648147',NULL,NULL,NULL,2),(42,'21791973',NULL,NULL,NULL,2),(43,'21791979',NULL,NULL,NULL,2),(44,'20423773',NULL,NULL,NULL,2),(45,'20252835',NULL,NULL,NULL,2),(46,'21748488',NULL,NULL,NULL,2),(47,'21765678',NULL,NULL,NULL,2);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
