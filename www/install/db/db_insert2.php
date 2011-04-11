<?php

include("inc/install_login.php");
unset($template);


// fs_poll
mysql_query("DROP TABLE IF EXISTS `".$pref."poll`", $db);
mysql_query("CREATE TABLE `".$pref."poll` (
  `poll_id` mediumint(8) NOT NULL auto_increment,
  `poll_quest` varchar(255) default NULL,
  `poll_start` int(11) default NULL,
  `poll_end` int(11) default NULL,
  `poll_type` tinyint(4) default NULL,
  `poll_participants` mediumint(8) NOT NULL default '0',
  PRIMARY KEY  (`poll_id`)
) TYPE=MyISAM AUTO_INCREMENT=1", $db);
$template .= "<li><b>".$pref."poll</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";


// fs_poll_answers
mysql_query("DROP TABLE IF EXISTS `".$pref."poll_answers`", $db);
mysql_query("CREATE TABLE `".$pref."poll_answers` (
  `poll_id` mediumint(8) default NULL,
  `answer_id` mediumint(8) NOT NULL auto_increment,
  `answer` varchar(255) default NULL,
  `answer_count` mediumint(8) NOT NULL default '0',
  PRIMARY KEY  (`answer_id`)
) TYPE=MyISAM AUTO_INCREMENT=1", $db);
$template .= "<li><b>".$pref."poll_answers</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";


// fs_poll_config
mysql_query("DROP TABLE IF EXISTS `".$pref."poll_config`", $db);
mysql_query("CREATE TABLE `".$pref."poll_config` (
  `id` tinyint(1) NOT NULL,
  `answerbar_width` smallint(3) NOT NULL default '100',
  `answerbar_type` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM", $db);
$template .= "<li><b>".$pref."poll_config</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";
mysql_query("INSERT INTO `".$pref."poll_config` (`id`, `answerbar_width`, `answerbar_type`) VALUES
(1, 100, 1)", $db);
$template .= "<li><b>".$pref."poll_config</b> ".$_LANG[db_insert][fill]." ".check_mysqlerror(mysql_error())."</li>";


// fs_poll_voters
mysql_query("DROP TABLE IF EXISTS `".$pref."poll_voters`", $db);
mysql_query("CREATE TABLE `".$pref."poll_voters` (
  `voter_id` mediumint(8) NOT NULL auto_increment,
  `poll_id` mediumint(8) NOT NULL default '0',
  `ip_address` varchar(15) NOT NULL default '0.0.0.0',
  `time` int(32) NOT NULL default '0',
  PRIMARY KEY  (`voter_id`)
) TYPE=MyISAM AUTO_INCREMENT=1", $db);
$template .= "<li><b>".$pref."poll_voters</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";


// fs_press
mysql_query("DROP TABLE IF EXISTS `".$pref."press`", $db);
mysql_query("CREATE TABLE `".$pref."press` (
  `press_id` smallint(6) NOT NULL auto_increment,
  `press_title` varchar(255) NOT NULL,
  `press_url` varchar(255) NOT NULL,
  `press_date` int(12) NOT NULL,
  `press_intro` text NOT NULL,
  `press_text` text NOT NULL,
  `press_note` text NOT NULL,
  `press_lang` int(11) NOT NULL,
  `press_game` tinyint(2) NOT NULL,
  `press_cat` tinyint(2) NOT NULL,
  PRIMARY KEY  (`press_id`)
) TYPE=MyISAM AUTO_INCREMENT=1", $db);
$template .= "<li><b>".$pref."press</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";


// fs_press_admin
mysql_query("DROP TABLE IF EXISTS `".$pref."press_admin`", $db);
mysql_query("CREATE TABLE `".$pref."press_admin` (
  `id` mediumint(8) NOT NULL auto_increment,
  `type` tinyint(1) NOT NULL default '0',
  `title` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`,`type`)
) TYPE=MyISAM  AUTO_INCREMENT=7", $db);
$template .= "<li><b>".$pref."press_admin</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";
mysql_query("
INSERT INTO `".$pref."press_admin` (`id`, `type`, `title`) VALUES
(1, 3, 'Deutsch'),
(2, 3, 'Englisch'),
(3, 2, 'Preview'),
(4, 1, 'Beispiel-Spiel'),
(5, 2, 'Review'),
(6, 2, 'Interview')
", $db);
$template .= "<li><b>".$pref."press_admin</b> ".$_LANG[db_insert][fill]." ".check_mysqlerror(mysql_error())."</li>";


// fs_press_config
mysql_query("DROP TABLE IF EXISTS `".$pref."press_config`", $db);
mysql_query("CREATE TABLE `".$pref."press_config` (
  `id` mediumint(8) NOT NULL default '1',
  `game_navi` tinyint(1) NOT NULL default '0',
  `cat_navi` tinyint(1) NOT NULL default '0',
  `lang_navi` tinyint(1) NOT NULL default '0',
  `show_press` tinyint(1) NOT NULL default '1',
  `show_root` tinyint(1) NOT NULL default '0',
  `order_by` varchar(10) NOT NULL,
  `order_type` varchar(4) NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM", $db);
$template .= "<li><b>".$pref."press_config</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";
mysql_query("INSERT INTO `".$pref."press_config` (`id`, `game_navi`, `cat_navi`, `lang_navi`, `show_press`, `show_root`, `order_by`, `order_type`) VALUES
(1, 1, 1, 0, 0, 0, 'press_date', 'desc')", $db);
$template .= "<li><b>".$pref."press_config</b> ".$_LANG[db_insert][fill]." ".check_mysqlerror(mysql_error())."</li>";


// fs_screen
mysql_query("DROP TABLE IF EXISTS `".$pref."screen`", $db);
mysql_query("CREATE TABLE `".$pref."screen` (
  `screen_id` mediumint(8) NOT NULL auto_increment,
  `cat_id` smallint(6) unsigned default NULL,
  `screen_name` varchar(255) default NULL,
  PRIMARY KEY  (`screen_id`),
  KEY `cat_id` (`cat_id`)
) TYPE=MyISAM AUTO_INCREMENT=1", $db);
$template .= "<li><b>".$pref."screen</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";


// fs_screen_cat
mysql_query("DROP TABLE IF EXISTS `".$pref."screen_cat`", $db);
mysql_query("CREATE TABLE `".$pref."screen_cat` (
  `cat_id` smallint(6) NOT NULL auto_increment,
  `cat_name` varchar(255) default NULL,
  `cat_type` tinyint(1) NOT NULL default '0',
  `cat_visibility` tinyint(1) NOT NULL default '1',
  `cat_date` int(11) NOT NULL default '0',
  `randompic` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`cat_id`)
) TYPE=MyISAM  AUTO_INCREMENT=3", $db);
$template .= "<li><b>".$pref."screen_cat</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";
mysql_query("INSERT INTO `".$pref."screen_cat` (`cat_id`, `cat_name`, `cat_type`, `cat_visibility`, `cat_date`, `randompic`) VALUES
(1, 'Screenshots', 1, 1, ".$THE_TIME.", 1),
(2, 'Wallpaper', 2, 1, ".$THE_TIME.", 0)", $db);
$template .= "<li><b>".$pref."screen_cat</b> ".$_LANG[db_insert][fill]." ".check_mysqlerror(mysql_error())."</li>";


// fs_screen_config
mysql_query("DROP TABLE IF EXISTS `".$pref."screen_config`", $db);
mysql_query("CREATE TABLE `".$pref."screen_config` (
  `id` tinyint(1) NOT NULL,
  `screen_x` int(4) default NULL,
  `screen_y` int(4) default NULL,
  `screen_thumb_x` int(4) default NULL,
  `screen_thumb_y` int(4) default NULL,
  `screen_size` int(4) default NULL,
  `screen_rows` int(2) NOT NULL,
  `screen_cols` int(2) NOT NULL,
  `screen_order` varchar(10) NOT NULL,
  `screen_sort` varchar(4) NOT NULL,
  `show_type` tinyint(1) NOT NULL default '0',
  `show_size_x` smallint(4) NOT NULL default '0',
  `show_size_y` smallint(4) NOT NULL default '0',
  `show_img_x` int(4) default NULL,
  `show_img_y` int(4) default NULL,
  `wp_x` int(4) default NULL,
  `wp_y` int(4) default NULL,
  `wp_thumb_x` int(4) default NULL,
  `wp_thumb_y` int(4) default NULL,
  `wp_order` varchar(10) NOT NULL,
  `wp_size` int(4) default NULL,
  `wp_rows` int(2) NOT NULL,
  `wp_cols` int(2) NOT NULL,
  `wp_sort` varchar(4) NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM", $db);
$template .= "<li><b>".$pref."screen_config</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";
mysql_query("INSERT INTO `".$pref."screen_config` (`id`, `screen_x`, `screen_y`, `screen_thumb_x`, `screen_thumb_y`, `screen_size`, `screen_rows`, `screen_cols`, `screen_order`, `screen_sort`, `show_type`, `show_size_x`, `show_size_y`, `show_img_x`, `show_img_y`, `wp_x`, `wp_y`, `wp_thumb_x`, `wp_thumb_y`, `wp_order`, `wp_size`, `wp_rows`, `wp_cols`, `wp_sort`) VALUES
(1, 1500, 1500, 120, 90, 1024, 5, 3, 'id', 'desc', 1, 950, 700, 800, 600, 2000, 2000, 200, 150, 'id', 1536, 6, 2, 'desc')
", $db);
$template .= "<li><b>".$pref."screen_config</b> ".$_LANG[db_insert][fill]." ".check_mysqlerror(mysql_error())."</li>";


// fs_screen_random
mysql_query("DROP TABLE IF EXISTS `".$pref."screen_random`", $db);
mysql_query("CREATE TABLE `".$pref."screen_random` (
  `random_id` mediumint(8) NOT NULL auto_increment,
  `screen_id` mediumint(8) NOT NULL,
  `start` int(11) NOT NULL,
  `end` int(11) NOT NULL,
  PRIMARY KEY  (`random_id`)
) TYPE=MyISAM AUTO_INCREMENT=1", $db);
$template .= "<li><b>".$pref."screen_random</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";


// fs_screen_random_config
mysql_query("DROP TABLE IF EXISTS `".$pref."screen_random_config`", $db);
mysql_query("CREATE TABLE `".$pref."screen_random_config` (
  `id` mediumint(8) NOT NULL default '1',
  `active` tinyint(1) NOT NULL default '1',
  `type_priority` tinyint(1) NOT NULL default '1',
  `use_priority_only` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM", $db);
$template .= "<li><b>".$pref."screen_random_config</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";
mysql_query("INSERT INTO `".$pref."screen_random_config` (`id`, `active`, `type_priority`, `use_priority_only`) VALUES
(1, 1, 1, 0)", $db);
$template .= "<li><b>".$pref."screen_random_config</b> ".$_LANG[db_insert][fill]." ".check_mysqlerror(mysql_error())."</li>";


// fs_search_config
mysql_query("DROP TABLE IF EXISTS `".$pref."search_config`", $db);
mysql_query("CREATE TABLE `".$pref."search_config` (
  `id` tinyint(1) NOT NULL,
  `search_num_previews` smallint(2) NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM", $db);
$template .= "<li><b>".$pref."search_config</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";
mysql_query("INSERT INTO `".$pref."search_config` (`id`, `search_num_previews`) VALUES
(1, 10)", $db);
$template .= "<li><b>".$pref."search_config</b> ".$_LANG[db_insert][fill]." ".check_mysqlerror(mysql_error())."</li>";


// fs_search_index
mysql_query("DROP TABLE IF EXISTS `".$pref."search_index`", $db);
mysql_query("CREATE TABLE `".$pref."search_index` (
  `search_index_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `search_index_word_id` mediumint(8) NOT NULL DEFAULT '0',
  `search_index_type` enum('news','articles','dl') NOT NULL DEFAULT 'news',
  `search_index_document_id` mediumint(8) NOT NULL DEFAULT '0',
  `search_index_count` smallint(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`search_index_id`),
  UNIQUE KEY `un_search_index_word_id` (`search_index_word_id`,`search_index_type`,`search_index_document_id`)
) TYPE=MyISAM AUTO_INCREMENT=1", $db);
$template .= "<li><b>".$pref."search_index</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";


// fs_search_time
mysql_query("DROP TABLE IF EXISTS `".$pref."search_time`", $db);
mysql_query("CREATE TABLE `".$pref."search_time` (
  `search_time_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `search_time_type` enum('news','articles','dl') NOT NULL DEFAULT 'news',
  `search_time_document_id` mediumint(8) NOT NULL,
  `search_time_date` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`search_time_id`),
  UNIQUE KEY `un_search_time_type` (`search_time_type`,`search_time_document_id`)
) TYPE=MyISAM AUTO_INCREMENT=1", $db);
$template .= "<li><b>".$pref."search_time</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";


// fs_search_words
mysql_query("DROP TABLE IF EXISTS `".$pref."search_words`", $db);
mysql_query("CREATE TABLE `".$pref."search_words` (
  `search_word_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `search_word` varchar(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`search_word_id`),
  UNIQUE KEY `search_word` (`search_word`)
) TYPE=MyISAM AUTO_INCREMENT=1", $db);
$template .= "<li><b>".$pref."search_words</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";


// fs_shop
mysql_query("DROP TABLE IF EXISTS `".$pref."shop`", $db);
mysql_query("CREATE TABLE `".$pref."shop` (
  `artikel_id` mediumint(8) NOT NULL auto_increment,
  `artikel_name` varchar(100) default NULL,
  `artikel_url` varchar(255) default NULL,
  `artikel_text` text,
  `artikel_preis` varchar(10) default NULL,
  `artikel_hot` tinyint(4) default NULL,
  PRIMARY KEY  (`artikel_id`)
) TYPE=MyISAM AUTO_INCREMENT=1", $db);
$template .= "<li><b>".$pref."shop</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";


// fs_smilies
mysql_query("DROP TABLE IF EXISTS `".$pref."smilies`", $db);
mysql_query("CREATE TABLE `".$pref."smilies` (
  `id` mediumint(8) NOT NULL auto_increment,
  `replace_string` varchar(15) NOT NULL,
  `order` mediumint(8) NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM  AUTO_INCREMENT=11", $db);
$template .= "<li><b>".$pref."smilies</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";
mysql_query("
INSERT INTO `".$pref."smilies` (`id`, `replace_string`, `order`) VALUES
(1, ':-)', 1),
(2, ':-(', 2),
(3, ';-)', 3),
(4, ':-P', 4),
(5, 'xD', 5),
(6, ':-o', 6),
(7, '^_^', 7),
(8, ':-/', 8),
(9, ':-]', 9),
(10, '&gt;-(', 10)
", $db);
$template .= "<li><b>".$pref."smilies</b> ".$_LANG[db_insert][fill]." ".check_mysqlerror(mysql_error())."</li>";


// fs_snippets
mysql_query("DROP TABLE IF EXISTS `".$pref."snippets`", $db);
mysql_query("CREATE TABLE `".$pref."snippets` (
  `snippet_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `snippet_tag` varchar(100) NOT NULL,
  `snippet_text` text NOT NULL,
  `snippet_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`snippet_id`),
  UNIQUE KEY `snippet_tag` (`snippet_tag`)
) TYPE=MyISAM  AUTO_INCREMENT=2", $db);
$template .= "<li><b>".$pref."snippets</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";
mysql_query("
INSERT INTO `".$pref."snippets` (`snippet_id`, `snippet_tag`, `snippet_text`, `snippet_active`) VALUES
(1, '[%feeds%]', '".addslashes("<p>\r\n  <b>News-Feeds:</b>\r\n</p>\r\n<p align=\\\"center\\\">\r\n  <a href=\\\"\$VAR(url)feeds/rss091.php\\\" target=\\\"_self\\\"><img src=\\\"\$VAR(style_icons)feeds/rss091.gif\\\" alt=\\\"RSS 0.91\\\" title=\\\"RSS 0.91\\\" border=\\\"0\\\"></a><br>\r\n  <a href=\\\"\$VAR(url)feeds/rss10.php\\\" target=\\\"_self\\\"><img src=\\\"\$VAR(style_icons)feeds/rss10.gif\\\" alt=\\\"RSS 1.0\\\" title=\\\"RSS 1.0\\\" border=\\\"0\\\"></a><br>\r\n  <a href=\\\"\$VAR(url)feeds/rss20.php\\\" target=\\\"_self\\\"><img src=\\\"\$VAR(style_icons)feeds/rss20.gif\\\" alt=\\\"RSS 2.0\\\" title=\\\"RSS 2.0\\\" border=\\\"0\\\"></a><br>\r\n  <a href=\\\"\$VAR(url)feeds/atom10.php\\\" target=\\\"_self\\\"><img src=\\\"\$VAR(style_icons)feeds/atom10.gif\\\" alt=\\\"Atom 1.0\\\" title=\\\"Atom 1.0\\\" border=\\\"0\\\"></a>\r\n</p>")."', 1)
", $db);
$template .= "<li><b>".$pref."snippets</b> ".$_LANG[db_insert][fill]." ".check_mysqlerror(mysql_error())."</li>";


// fs_styles
mysql_query("DROP TABLE IF EXISTS `".$pref."styles`", $db);
mysql_query("CREATE TABLE `".$pref."styles` (
  `style_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `style_tag` varchar(30) NOT NULL,
  `style_allow_use` tinyint(1) NOT NULL DEFAULT '1',
  `style_allow_edit` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`style_id`),
  UNIQUE KEY `style_tag` (`style_tag`)
) TYPE=MyISAM  AUTO_INCREMENT=2", $db);
$template .= "<li><b>".$pref."styles</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";
mysql_query("
INSERT INTO `".$pref."styles` (`style_id`, `style_tag`, `style_allow_use`, `style_allow_edit`) VALUES
(1, 'lightfrog', 1, 1),
(0, 'default', 0, 0)
", $db);
$error = "";
$error = ($error == "" ) ? mysql_error() : "<br>".mysql_error();
mysql_query("UPDATE `".$pref."styles` SET `style_id` = '0' WHERE `style_tag` = 'default' LIMIT 1", $db);
$error = ($error == "" ) ? mysql_error() : "<br>".mysql_error();
mysql_query("ALTER TABLE `".$pref."styles` AUTO_INCREMENT = 2", $db);
$error = ($error == "" ) ? mysql_error() : "<br>".mysql_error();
$template .= "<li><b>".$pref."styles</b> ".$_LANG[db_insert][fill]." ".check_mysqlerror($error)."</li>";


// fs_user
mysql_query("DROP TABLE IF EXISTS `".$pref."user`", $db);
mysql_query("CREATE TABLE `".$pref."user` (
  `user_id` mediumint(8) NOT NULL auto_increment,
  `user_name` char(100) default NULL,
  `user_password` char(32) default NULL,
  `user_salt` varchar(10) NOT NULL,
  `user_mail` char(100) default NULL,
  `user_is_staff` tinyint(1) NOT NULL default '0',
  `user_group` mediumint(8) NOT NULL default '0',
  `user_is_admin` tinyint(1) NOT NULL default '0',
  `user_reg_date` int(11) default NULL,
  `user_show_mail` tinyint(4) NOT NULL default '0',
  `user_homepage` varchar(100) default NULL,
  `user_icq` varchar(50) default NULL,
  `user_aim` varchar(50) default NULL,
  `user_wlm` varchar(50) default NULL,
  `user_yim` varchar(50) default NULL,
  `user_skype` varchar(50) default NULL,
  PRIMARY KEY  (`user_id`)
) TYPE=MyISAM  AUTO_INCREMENT=1", $db);
$template .= "<li><b>".$pref."user</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";

// fs_useronline
mysql_query("DROP TABLE IF EXISTS `".$pref."useronline`", $db);
mysql_query("CREATE TABLE `".$pref."useronline` (
  `ip` varchar(30) NOT NULL,
  `user_id` mediumint(8) NOT NULL default '0',
  `date` int(30) default NULL,
  PRIMARY KEY  (`ip`)
) TYPE=MEMORY", $db);
$template .= "<li><b>".$pref."useronline</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";


// fs_user_config
mysql_query("DROP TABLE IF EXISTS `".$pref."user_config`", $db);
mysql_query("CREATE TABLE `".$pref."user_config` (
  `id` tinyint(1) NOT NULL,
  `user_per_page` tinyint(3) NOT NULL,
  `registration_antispam` tinyint(1) NOT NULL default '0',
  `avatar_x` smallint(3) NOT NULL default '110',
  `avatar_y` smallint(3) NOT NULL default '110',
  `avatar_size` smallint(4) NOT NULL default '1024',
  `group_pic_x` smallint(3) NOT NULL default '250',
  `group_pic_y` smallint(3) NOT NULL default '25',
  `group_pic_size` smallint(4) NOT NULL default '1024',
  `reg_date_format` varchar(50) NOT NULL,
  `user_list_reg_date_format` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM", $db);
$template .= "<li><b>".$pref."user_config</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";
mysql_query("INSERT INTO `".$pref."user_config` (`id`, `user_per_page`, `registration_antispam`, `avatar_x`, `avatar_y`, `avatar_size`, `group_pic_x`, `group_pic_y`, `group_pic_size`, `reg_date_format`, `user_list_reg_date_format`) VALUES
(1, 50, 1, 110, 110, 20, 250, 25, 50, 'l, j. F Y', 'j. F Y')", $db);
$template .= "<li><b>".$pref."user_config</b> ".$_LANG[db_insert][fill]." ".check_mysqlerror(mysql_error())."</li>";


// fs_user_groups
mysql_query("DROP TABLE IF EXISTS `".$pref."user_groups`", $db);
mysql_query("CREATE TABLE `".$pref."user_groups` (
  `user_group_id` mediumint(8) NOT NULL auto_increment,
  `user_group_name` varchar(50) NOT NULL,
  `user_group_description` text,
  `user_group_title` varchar(50) default NULL,
  `user_group_color` varchar(6) NOT NULL default '-1',
  `user_group_highlight` tinyint(1) NOT NULL default '0',
  `user_group_date` int(11) NOT NULL,
  `user_group_user` mediumint(8) NOT NULL default '1',
  PRIMARY KEY  (`user_group_id`)
) TYPE=MyISAM AUTO_INCREMENT=1", $db);
$template .= "<li><b>".$pref."user_groups</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";
mysql_query("INSERT INTO `".$pref."user_groups` (`user_group_id`, `user_group_name`, `user_group_description`, `user_group_title`, `user_group_color`, `user_group_highlight`, `user_group_date`, `user_group_user`) VALUES
(0, 'Administrator', '', 'Administrator', '008800', 1, ".$THE_TIME.", 1)", $db);
$error = "";
$error = ($error == "" ) ? mysql_error() : "<br>".mysql_error();
mysql_query("UPDATE `".$pref."user_groups` SET `user_group_id` = '0' WHERE `user_group_name` = 'Administrator' LIMIT 1", $db);
$error = ($error == "" ) ? mysql_error() : "<br>".mysql_error();
mysql_query("ALTER TABLE `".$pref."user_groups` AUTO_INCREMENT = 1", $db);
$error = ($error == "" ) ? mysql_error() : "<br>".mysql_error();
$template .= "<li><b>".$pref."user_groups</b> ".$_LANG[db_insert][fill]." ".check_mysqlerror($error)."</li>";


// fs_user_permissions
mysql_query("DROP TABLE IF EXISTS `".$pref."user_permissions`", $db);
mysql_query("CREATE TABLE `".$pref."user_permissions` (
  `perm_id` varchar(255) NOT NULL,
  `x_id` mediumint(8) NOT NULL,
  `perm_for_group` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`perm_id`,`x_id`,`perm_for_group`)
) TYPE=MyISAM", $db);
$template .= "<li><b>".$pref."user_permissions</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";


// fs_wallpaper
mysql_query("DROP TABLE IF EXISTS `".$pref."wallpaper`", $db);
mysql_query("CREATE TABLE `".$pref."wallpaper` (
  `wallpaper_id` mediumint(8) NOT NULL auto_increment,
  `wallpaper_name` varchar(255) NOT NULL,
  `wallpaper_title` varchar(255) NOT NULL,
  `cat_id` mediumint(8) NOT NULL default '0',
  PRIMARY KEY  (`wallpaper_id`)
) TYPE=MyISAM PACK_KEYS=1 AUTO_INCREMENT=1", $db);
$template .= "<li><b>".$pref."wallpaper</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";


// fs_wallpaper_sizes
mysql_query("DROP TABLE IF EXISTS `".$pref."wallpaper_sizes`", $db);
mysql_query("CREATE TABLE `".$pref."wallpaper_sizes` (
  `size_id` mediumint(8) NOT NULL auto_increment,
  `wallpaper_id` mediumint(8) NOT NULL default '0',
  `size` varchar(255) NOT NULL,
  PRIMARY KEY  (`size_id`)
) TYPE=MyISAM PACK_KEYS=1 AUTO_INCREMENT=1", $db);
$template .= "<li><b>".$pref."wallpaper_sizes</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";

mysql_close();
?>