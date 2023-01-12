/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : db_event_management

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2023-01-06 13:51:28
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tbl_frontdesk_users
-- ----------------------------
DROP TABLE IF EXISTS `tbl_frontdesk_users`;
CREATE TABLE `tbl_frontdesk_users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `pwd` varchar(200) NOT NULL,
  `bdate` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8_general_ci;

-- ----------------------------
-- Records of tbl_frontdesk_users
-- ----------------------------

-- ----------------------------
-- Table structure for tbl_holidays
-- ----------------------------
DROP TABLE IF EXISTS `tbl_holidays`;
CREATE TABLE `tbl_holidays` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `date` varchar(20) NOT NULL,
  `reason` varchar(100) NOT NULL,
  `bdate` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8_general_ci;

-- ----------------------------
-- Records of tbl_holidays
-- ----------------------------

-- ----------------------------
-- Table structure for tbl_reservations
-- ----------------------------
DROP TABLE IF EXISTS `tbl_reservations`;
CREATE TABLE `tbl_reservations` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` varchar(10) NOT NULL,
  `name` varchar(20) NOT NULL,
  `namethai` varchar(100) NOT NULL,
  `ucount` int(10) NOT NULL,
  `rdate` varchar(100) NOT NULL,
  `status` varchar(10) NOT NULL,
  `details` varchar(255) NOT NULL DEFAULT '',
  `comments` varchar(250) NOT NULL,
  `bdate` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8_general_ci;

-- ----------------------------
-- Records of tbl_reservations
-- ----------------------------

-- ----------------------------
-- Table structure for tbl_users
-- ----------------------------
DROP TABLE IF EXISTS `tbl_users`;
CREATE TABLE `tbl_users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `namethai` varchar(100) NOT NULL,
  `pwd` varchar(200) NOT NULL,
  `address` varchar(250) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `type` varchar(10) NOT NULL,
  `status` varchar(10) NOT NULL,
  `bdate` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8_general_ci;

-- ----------------------------
-- Records of tbl_users
-- ----------------------------
INSERT INTO `tbl_users` VALUES ('1', 'admin', 'IT ???.????????', '123456', '???.????????', '0804066967', 'IT@IT.com', 'admin', 'active', '2023-01-06 13:46:58');
