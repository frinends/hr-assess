/*
Navicat MySQL Data Transfer

Source Server         : shenhua
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : shenhua

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-01-18 10:30:40
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for sh_examine_task_weight
-- ----------------------------
DROP TABLE IF EXISTS `sh_examine_task_weight`;
CREATE TABLE `sh_examine_task_weight` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` int(11) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `rank` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sh_examine_task_weight
-- ----------------------------
INSERT INTO `sh_examine_task_weight` VALUES ('4', '52', '40', '1');
INSERT INTO `sh_examine_task_weight` VALUES ('5', '52', '30', '10,2,11,6,7,8,9');
INSERT INTO `sh_examine_task_weight` VALUES ('6', '52', '30', '0,5');
