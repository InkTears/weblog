/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50719
Source Host           : localhost:3306
Source Database       : weblog

Target Server Type    : MYSQL
Target Server Version : 50719
File Encoding         : 65001

Date: 2017-12-21 12:17:21
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `billet`
-- ----------------------------
DROP TABLE IF EXISTS `billet`;
CREATE TABLE `billet` (
  `id_billet` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `login` varchar(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `chapo` varchar(500) NOT NULL,
  `content` text NOT NULL,
  `id_categories` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id_billet`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of billet
-- ----------------------------

-- ----------------------------
-- Table structure for `comment`
-- ----------------------------
DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `id_comment` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET latin1 NOT NULL,
  `email` varchar(255) CHARACTER SET latin1 NOT NULL,
  `content` text CHARACTER SET latin1 NOT NULL,
  `created` datetime NOT NULL,
  `ref` varchar(60) CHARACTER SET latin1 NOT NULL,
  `ref_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  PRIMARY KEY (`id_comment`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of comment
-- ----------------------------

-- ----------------------------
-- Table pour les catégories
-- ----------------------------

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
`id_categorie` int(11) NOT NULL,
`name` set(0) NOT NULL,
PRIMARY KEY (`id_categorie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- ----------------------------
-- Table structure for `contact`
-- ----------------------------
DROP TABLE IF EXISTS `contact`;
CREATE TABLE `contact` (
  `id_contact` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `sujet` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `lu` tinyint(1) DEFAULT '0',
  `created` datetime NOT NULL,
  PRIMARY KEY (`id_contact`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of contact
-- ----------------------------

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `admin` int(11) NOT NULL DEFAULT '0',
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
