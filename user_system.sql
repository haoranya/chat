/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50721
Source Host           : localhost:3306
Source Database       : user_system

Target Server Type    : MYSQL
Target Server Version : 50721
File Encoding         : 65001

Date: 2018-11-15 21:24:35
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for all_chat
-- ----------------------------
DROP TABLE IF EXISTS `all_chat`;
CREATE TABLE `all_chat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  `uname` varchar(255) NOT NULL,
  `time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of all_chat
-- ----------------------------

-- ----------------------------
-- Table structure for single_chat
-- ----------------------------
DROP TABLE IF EXISTS `single_chat`;
CREATE TABLE `single_chat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uname` varchar(255) NOT NULL,
  `self_obj` int(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  `time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of single_chat
-- ----------------------------

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `uname` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `tel_num` varchar(255) NOT NULL,
  `reg_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('2', '张三', 'e10adc3949ba59abbe56e057f20f883e', '13043733516', '2018-11-14 15:13:51');
INSERT INTO `users` VALUES ('3', '李四', 'e10adc3949ba59abbe56e057f20f883e', '13084213809', '2018-11-14 15:14:08');
INSERT INTO `users` VALUES ('4', '王五', 'e10adc3949ba59abbe56e057f20f883e', '13084217656', '2018-11-14 15:14:23');
INSERT INTO `users` VALUES ('7', 'text', '202cb962ac59075b964b07152d234b70', '17805202005', '2018-11-14 19:52:15');
