<?php
defined('EMLOG_ROOT') or die('access deined!');
function callback_init(){
	$DB = MySql::getInstance();
	$sql="SHOW   TABLES   LIKE   '".DB_PREFIX."xiaotou';";
	$query=$DB->query($sql);
	$tb_num=$DB->num_rows($query);
	if($tb_num==0){
		echo "初始化，新建表。。。";
		$dbcharset = 'utf8';
		$type = 'MYISAM';
		$add = $DB->getMysqlVersion() > '4.1' ? "ENGINE=".$type." DEFAULT CHARSET=".$dbcharset.";":"TYPE=".$type.";";
		$sql = "
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
		)
		".$add;	
		$DB->query($sql);
	$sql="INSERT INTO 'emlog_xiaotou' VALUES ('1', 'CSDN\'s blog', 'CSDN', 'http://blog.csdn.net', 'http://blog.csdn.net(.)*', '<span class=\"link_title\">', '</span>', '<div id=\"article_content\" class=\"article_content\">', '</div><!-- Baidu Button BEGIN -->', null);
INSERT INTO 'emlog_xiaotou' VALUES ('3', '新闻——简明现代魔法', '简明现代魔法', 'http://www.nowamagic.net', 'http://www.nowamagic.net/librarys/news/detail/\\S+', '<div class=\"title\">', '</', '<div class=\"gen3\">', '</div>', null);
INSERT INTO 'emlog_xiaotou' VALUES ('4', '晚八点——简明现代魔法', '简明现代魔法', 'http://www.nowamagic.net/librarys/eight/', 'http://www.nowamagic.net/librarys/eight/posts/\\S+', '<h2 class=\"gen3_title\">', '</', '<div class=\"postnavi gen3\">', '<div style=\" padding:22px 0 6px 0; height:30px;\">', null);";
		$DB->query($sql);
		header("Location: ./plugin.php?plugin=emlog_xiaotou&setting=true");
		return;
	}
}
function callback_rm(){
	
}
?>