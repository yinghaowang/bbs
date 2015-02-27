SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `roc_balance`
-- ----------------------------
DROP TABLE IF EXISTS `roc_balance`;
CREATE TABLE `roc_balance` (
  `bid` mediumint(8) NOT NULL AUTO_INCREMENT,
  `uid` mediumint(8) NOT NULL,
  `type` tinyint(2) NOT NULL,
  `balance` mediumint(8) NOT NULL,
  `changed` mediumint(8) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`bid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of roc_balance
-- ----------------------------

-- ----------------------------
-- Table structure for `roc_club`
-- ----------------------------
DROP TABLE IF EXISTS `roc_club`;
CREATE TABLE `roc_club` (
  `cid` mediumint(8) NOT NULL AUTO_INCREMENT,
  `clubname` char(26) NOT NULL,
  `position` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`cid`),
  UNIQUE KEY `clubname` (`clubname`),
  KEY `position` (`position`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of roc_club
-- ----------------------------

-- ----------------------------
-- Table structure for `roc_commend`
-- ----------------------------
DROP TABLE IF EXISTS `roc_commend`;
CREATE TABLE `roc_commend` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `tid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`cid`,`uid`,`tid`),
  KEY `uid` (`uid`),
  KEY `fuid` (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of roc_commend
-- ----------------------------

-- ----------------------------
-- Table structure for `roc_favorite`
-- ----------------------------
DROP TABLE IF EXISTS `roc_favorite`;
CREATE TABLE `roc_favorite` (
  `fid` mediumint(8) NOT NULL AUTO_INCREMENT,
  `fuid` mediumint(8) NOT NULL,
  `uid` mediumint(8) NOT NULL,
  `tid` mediumint(8) NOT NULL,
  PRIMARY KEY (`fid`),
  KEY `fuid` (`fuid`,`fid`),
  KEY `id` (`tid`,`fuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of roc_favorite
-- ----------------------------

-- ----------------------------
-- Table structure for `roc_follow`
-- ----------------------------
DROP TABLE IF EXISTS `roc_follow`;
CREATE TABLE `roc_follow` (
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `fuid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`,`fuid`),
  KEY `uid` (`uid`),
  KEY `fuid` (`fuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of roc_follow
-- ----------------------------

-- ----------------------------
-- Table structure for `roc_notification`
-- ----------------------------
DROP TABLE IF EXISTS `roc_notification`;
CREATE TABLE `roc_notification` (
  `nid` mediumint(8) NOT NULL AUTO_INCREMENT,
  `atuid` mediumint(8) NOT NULL,
  `uid` mediumint(8) NOT NULL,
  `tid` mediumint(8) NOT NULL,
  `pid` mediumint(8) NOT NULL,
  `isread` tinyint(1) unsigned zerofill NOT NULL DEFAULT '0',
  PRIMARY KEY (`nid`),
  KEY `atuid` (`atuid`,`isread`,`nid`),
  KEY `tid` (`tid`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of roc_notification
-- ----------------------------

-- ----------------------------
-- Table structure for `roc_reply`
-- ----------------------------
DROP TABLE IF EXISTS `roc_reply`;
CREATE TABLE `roc_reply` (
  `pid` mediumint(8) NOT NULL AUTO_INCREMENT,
  `tid` mediumint(8) NOT NULL,
  `uid` mediumint(8) NOT NULL,
  `message` varchar(200) NOT NULL,
  `pictures` varchar(265) NOT NULL,
  `client` varchar(14) NOT NULL,
  `posttime` int(10) NOT NULL,
  PRIMARY KEY (`pid`),
  KEY `tid` (`tid`,`pid`),
  KEY `uid` (`uid`,`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of roc_reply
-- ----------------------------

-- ----------------------------
-- Table structure for `roc_resetpwd`
-- ----------------------------
DROP TABLE IF EXISTS `roc_resetpwd`;
CREATE TABLE `roc_resetpwd` (
  `uid` mediumint(8) NOT NULL,
  `code` char(32) NOT NULL,
  `dateline` int(10) NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `code` (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of roc_resetpwd
-- ----------------------------

-- ----------------------------
-- Table structure for `roc_topic`
-- ----------------------------
DROP TABLE IF EXISTS `roc_topic`;
CREATE TABLE `roc_topic` (
  `tid` mediumint(8) NOT NULL AUTO_INCREMENT,
  `uid` mediumint(8) NOT NULL,
  `cid` mediumint(8) NOT NULL,
  `message` text NOT NULL,
  `pictures` varchar(265) NOT NULL,
  `client` varchar(14) NOT NULL,
  `posttime` int(11) NOT NULL,
  `lasttime` int(11) NOT NULL,
  `istop` tinyint(1) unsigned zerofill NOT NULL,
  `comments` mediumint(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`tid`,`cid`),
  KEY `uid` (`uid`,`tid`),
  KEY `cid` (`cid`,`lasttime`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of roc_topic
-- ----------------------------

-- ----------------------------
-- Table structure for `roc_user`
-- ----------------------------
DROP TABLE IF EXISTS `roc_user`;
CREATE TABLE `roc_user` (
  `uid` mediumint(8) NOT NULL AUTO_INCREMENT,
  `nickname` char(26) NOT NULL,
  `email` char(36) NOT NULL,
  `signature` varchar(32) NOT NULL,
  `password` char(32) NOT NULL,
  `regtime` int(11) NOT NULL,
  `lasttime` int(11) NOT NULL,
  `qqid` char(32) NOT NULL,
  `money` mediumint(8) NOT NULL,
  `groupid` tinyint(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `nickname` (`nickname`),
  KEY `email` (`email`),
  KEY `qqid` (`qqid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of roc_user
-- ----------------------------

-- ----------------------------
-- Table structure for `roc_whisper`
-- ----------------------------
DROP TABLE IF EXISTS `roc_whisper`;
CREATE TABLE `roc_whisper` (
  `wid` mediumint(8) NOT NULL AUTO_INCREMENT,
  `atuid` mediumint(8) NOT NULL,
  `uid` mediumint(8) NOT NULL,
  `message` varchar(255) NOT NULL,
  `posttime` int(11) NOT NULL,
  `isread` tinyint(1) NOT NULL DEFAULT '0',
  `del_flag` mediumint(8) NOT NULL,
  PRIMARY KEY (`wid`),
  KEY `atuid` (`atuid`,`isread`,`wid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of roc_whisper
-- ----------------------------
