/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50051
Source Host           : localhost:3306
Source Database       : vip310242

Target Server Type    : MYSQL
Target Server Version : 50051
File Encoding         : 65001

Date: 2015-04-08 16:07:16
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `emlog_xiaotou`
-- ----------------------------
DROP TABLE IF EXISTS `emlog_xiaotou`;
CREATE TABLE `emlog_xiaotou` (
  `cid` int(11) NOT NULL auto_increment,
  `title` varchar(200) default NULL,
  `sitename` varchar(200) default NULL COMMENT '网站名称',
  `siteurl` varchar(200) default NULL COMMENT '网站首页',
  `url_reg` varchar(200) default NULL COMMENT '匹配URL正则',
  `title_start` text,
  `title_end` text,
  `body_start` text,
  `body_end` text,
  `lastlink_type` smallint(4) default NULL,
  PRIMARY KEY  (`cid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of emlog_xiaotou
-- ----------------------------
INSERT INTO `emlog_xiaotou` VALUES ('1', 'CSDN\'s blog', 'CSDN', 'http://blog.csdn.net', 'http://blog.csdn.net(.)*', '<span class=\"link_title\">', '</span>', '<div id=\"article_content\" class=\"article_content\">', '</div><!-- Baidu Button BEGIN -->', null);
INSERT INTO `emlog_xiaotou` VALUES ('3', '新闻——简明现代魔法', '简明现代魔法', 'http://www.nowamagic.net', 'http://www.nowamagic.net/librarys/news/detail/\\S+', '<div class=\"title\">', '</', '<div class=\"gen3\">', '</div>', null);
INSERT INTO `emlog_xiaotou` VALUES ('4', '晚八点——简明现代魔法', '简明现代魔法', 'http://www.nowamagic.net/librarys/eight/', 'http://www.nowamagic.net/librarys/eight/posts/\\S+', '<h2 class=\"gen3_title\">', '</', '<div class=\"postnavi gen3\">', '<div style=\" padding:22px 0 6px 0; height:30px;\">', null);
