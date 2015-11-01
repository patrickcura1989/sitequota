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

/*Table structure for table `fulfillment` */

DROP TABLE IF EXISTS `fulfillment`;

CREATE TABLE `fulfillment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fulfillment_number` varchar(100) DEFAULT NULL,
  `swt_date` varchar(100) DEFAULT NULL,
  `swt_time` varchar(100) DEFAULT NULL,
  `cwt_date` varchar(100) DEFAULT NULL,
  `cwt_time` varchar(100) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `request_type` varchar(100) DEFAULT NULL,
  `service` varchar(100) DEFAULT NULL,
  `service_type` varchar(100) DEFAULT NULL,
  `ci` varchar(100) DEFAULT NULL,
  `reported` varchar(100) DEFAULT NULL,
  `sla` varchar(100) DEFAULT NULL,
  `closed_date` varchar(100) DEFAULT NULL,
  `assignment_group` varchar(100) DEFAULT NULL,
  `assignee` varchar(100) DEFAULT NULL,
  `closure_code` varchar(100) DEFAULT NULL,
  `sla_percent` varchar(100) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `request_priority` varchar(100) DEFAULT NULL,
  `owning_team` int(11) DEFAULT NULL,
  `owner` varchar(100) DEFAULT NULL,
  `comments` varchar(1000) DEFAULT NULL,
  `sync_date` date DEFAULT NULL,
  `sync_time` time DEFAULT NULL,
  `added_date` date DEFAULT NULL,
  `added_time` time DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=490 DEFAULT CHARSET=latin1;

/*Table structure for table `handover_updates` */

DROP TABLE IF EXISTS `handover_updates`;

CREATE TABLE `handover_updates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_number` varchar(100) DEFAULT NULL,
  `update_text` varchar(1000) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `ticket_id` int(11) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=159 DEFAULT CHARSET=latin1;

/*Table structure for table `incidents` */

DROP TABLE IF EXISTS `incidents`;

CREATE TABLE `incidents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `incident_number` varchar(100) DEFAULT NULL,
  `reported` varchar(100) DEFAULT NULL,
  `swt_date` varchar(100) DEFAULT NULL,
  `swt_time` varchar(100) DEFAULT NULL,
  `cwt_date` varchar(100) DEFAULT NULL,
  `cwt_time` varchar(100) DEFAULT NULL,
  `impact` varchar(100) DEFAULT NULL,
  `urgency` varchar(100) DEFAULT NULL,
  `priority` varchar(100) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `area` varchar(100) DEFAULT NULL,
  `sub_area` varchar(100) DEFAULT NULL,
  `current_status` varchar(100) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `target_date` varchar(100) DEFAULT NULL,
  `affected_ci` varchar(100) DEFAULT NULL,
  `service` varchar(100) DEFAULT NULL,
  `queue` varchar(100) DEFAULT NULL,
  `assignee` varchar(100) DEFAULT NULL,
  `service_impact` varchar(100) DEFAULT NULL,
  `closure_code` varchar(100) DEFAULT NULL,
  `sla_percent` varchar(10) DEFAULT NULL,
  `owning_team` int(11) DEFAULT NULL,
  `owner` varchar(200) DEFAULT NULL,
  `comments` varchar(1000) DEFAULT NULL,
  `sync_date` date DEFAULT NULL,
  `sync_time` time DEFAULT NULL,
  `added_date` date DEFAULT NULL,
  `added_time` time DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=323 DEFAULT CHARSET=latin1;

/*Table structure for table `owning_team` */

DROP TABLE IF EXISTS `owning_team`;

CREATE TABLE `owning_team` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owning_team` varchar(100) DEFAULT NULL,
  `team_email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Table structure for table `queue_change_fr` */

DROP TABLE IF EXISTS `queue_change_fr`;

CREATE TABLE `queue_change_fr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) DEFAULT NULL,
  `owning_team` varchar(100) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `queue_change_im` */

DROP TABLE IF EXISTS `queue_change_im`;

CREATE TABLE `queue_change_im` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) DEFAULT NULL,
  `owning_team` varchar(100) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
