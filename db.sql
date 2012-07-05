-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 05. Juli 2012 um 07:37
-- Server Version: 5.1.53
-- PHP-Version: 5.3.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `fs2`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_admin_cp`
--

DROP TABLE IF EXISTS `fs2_admin_cp`;
CREATE TABLE `fs2_admin_cp` (
  `page_id` varchar(255) NOT NULL,
  `group_id` varchar(20) NOT NULL,
  `page_file` varchar(255) NOT NULL,
  `page_pos` tinyint(3) NOT NULL DEFAULT '0',
  `page_int_sub_perm` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`page_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `fs2_admin_cp`
--

INSERT INTO `fs2_admin_cp` (`page_id`, `group_id`, `page_file`, `page_pos`, `page_int_sub_perm`) VALUES
('start_general', '-1', 'general', 1, 0),
('start_content', '-1', 'content', 2, 0),
('start_media', '-1', 'media', 3, 0),
('start_interactive', '-1', 'interactive', 4, 0),
('start_promo', '-1', 'promo', 5, 0),
('start_user', '-1', 'user', 6, 0),
('start_styles', '-1', 'styles', 7, 0),
('start_system', '-1', 'system', 8, 0),
('start_mods', '-1', 'mods', 9, 0),
('partner_config', 'affiliates', 'admin_partnerconfig.php', 1, 0),
('partner_add', 'affiliates', 'admin_partneradd.php', 2, 0),
('partner_edit', 'affiliates', 'admin_partneredit.php', 3, 0),
('aliases_add', 'aliases', 'admin_aliases_add.php', 1, 0),
('aliases_delete', 'aliases', 'aliases_edit', 1, 1),
('aliases_edit', 'aliases', 'admin_aliases_edit.php', 2, 0),
('applets_add', 'applets', 'admin_applets_add.php', 1, 0),
('applets_delete', 'applets', 'applets_edit', 1, 1),
('applets_edit', 'applets', 'admin_applets_edit.php', 2, 0),
('articles_config', 'articles', 'admin_articles_config.php', 1, 0),
('articles_add', 'articles', 'admin_articles_add.php', 2, 0),
('articles_edit', 'articles', 'admin_articles_edit.php', 3, 0),
('articles_cat', 'articles', 'admin_articles_cat.php', 4, 0),
('cimg_add', 'cimg', 'admin_cimg.php', 1, 0),
('cimg_admin', 'cimg', 'admin_cimgdel.php', 2, 0),
('dl_config', 'downloads', 'admin_dlconfig.php', 1, 0),
('dl_add', 'downloads', 'admin_dladd.php', 2, 0),
('dl_edit', 'downloads', 'admin_dledit.php', 3, 0),
('dl_cat', 'downloads', 'admin_dlcat.php', 4, 0),
('dl_newcat', 'downloads', 'admin_dlnewcat.php', 5, 0),
('editor_config', 'fseditor', 'admin_editor_config.php', 1, 0),
('editor_design', 'fseditor', 'admin_editor_design.php', 2, 0),
('editor_smilies', 'fseditor', 'admin_editor_smilies.php', 3, 0),
('editor_fscodes', 'fseditor', 'admin_editor_fscode.php', 4, 0),
('gallery_config', 'gallery', 'admin_screenconfig.php', 1, 0),
('screens_add', 'gallery_img', 'admin_screenadd.php', 1, 0),
('wp_add', 'gallery_wp', 'admin_wallpaperadd.php', 1, 0),
('gallery_cat', 'gallery', 'admin_screencat.php', 2, 0),
('randompic_config', 'gallery_preview', 'admin_randompic_config.php', 1, 0),
('gallery_newcat', 'gallery', 'admin_screennewcat.php', 3, 0),
('screens_edit', 'gallery_img', 'admin_screenedit.php', 2, 0),
('wp_edit', 'gallery_wp', 'admin_wallpaperedit.php', 2, 0),
('gen_config', 'general', 'admin_general_config.php', 1, 0),
('gen_announcement', 'general', 'admin_allannouncement.php', 2, 0),
('gen_captcha', 'general', 'admin_captcha_config.php', 2, 0),
('gen_emails', 'general', 'admin_allemail.php', 4, 0),
('gen_phpinfo', 'general', 'admin_allphpinfo.php', 5, 0),
('group_config', 'groups', 'admin_group_config.php', 1, 0),
('group_admin', 'groups', 'admin_group_admin.php', 2, 0),
('group_rights', 'groups', 'admin_group_rights.php', 3, 0),
('news_config', 'news', 'admin_news_config.php', 1, 0),
('news_delete', 'news', 'news_edit', 1, 1),
('news_add', 'news', 'admin_news_add.php', 2, 0),
('news_comments', 'news', 'news_edit', 2, 1),
('news_edit', 'news', 'admin_news_edit.php', 3, 0),
('news_cat', 'news', 'admin_news_cat.php', 4, 0),
('player_config', 'player', 'admin_player_config.php', 1, 0),
('player_add', 'player', 'admin_player_add.php', 2, 0),
('player_edit', 'player', 'admin_player_edit.php', 3, 0),
('poll_config', 'polls', 'admin_pollconfig.php', 1, 0),
('poll_add', 'polls', 'admin_polladd.php', 2, 0),
('poll_edit', 'polls', 'admin_polledit.php', 3, 0),
('article_preview', 'popup', 'admin_articles_prev.php', 0, 0),
('find_applet', 'popup', 'admin_find_applet.php', 0, 0),
('find_file', 'popup', 'admin_find_file.php', 0, 0),
('find_gallery_img', 'popup', 'admin_findpicture.php', 0, 0),
('find_user', 'popup', 'admin_finduser.php', 0, 0),
('frogpad', 'popup', 'admin_frogpad.php', 0, 0),
('news_preview', 'popup', 'admin_news_prev.php', 0, 0),
('press_config', 'press', 'admin_press_config.php', 1, 0),
('press_add', 'press', 'admin_press_add.php', 2, 0),
('press_edit', 'press', 'admin_press_edit.php', 3, 0),
('press_admin', 'press', 'admin_press_admin.php', 4, 0),
('search_config', 'search', 'admin_search_config.php', 1, 0),
('search_index', 'search', 'admin_search_index.php', 2, 0),
('shop_add', 'shop', 'admin_shopadd.php', 1, 0),
('shop_edit', 'shop', 'admin_shopedit.php', 2, 0),
('snippets_add', 'snippets', 'admin_snippets_add.php', 1, 0),
('snippets_delete', 'snippets', 'snippets_edit', 1, 1),
('snippets_edit', 'snippets', 'admin_snippets_edit.php', 2, 0),
('stat_view', 'stats', 'admin_statview.php', 1, 0),
('stat_edit', 'stats', 'admin_statedit.php', 2, 0),
('stat_ref', 'stats', 'admin_statref.php', 3, 0),
('style_add', 'styles', 'admin_style_add.php', 1, 0),
('style_management', 'styles', 'admin_style_management.php', 2, 0),
('style_css', 'styles', 'admin_template_css.php', 3, 0),
('style_js', 'styles', 'admin_template_js.php', 4, 0),
('style_nav', 'styles', 'admin_template_nav.php', 5, 0),
('tpl_main', 'templates', 'admin_template_main.php', 1, 0),
('tpl_general', 'templates', 'admin_template_general.php', 2, 0),
('tpl_user', 'templates', 'admin_template_user.php', 2, 0),
('tpl_articles', 'templates', 'admin_template_articles.php', 3, 0),
('tpl_news', 'templates', 'admin_template_news.php', 3, 0),
('tpl_search', 'templates', 'admin_template_search.php', 3, 0),
('tpl_viewer', 'templates', 'admin_template_viewer.php', 3, 0),
('tpl_poll', 'templates', 'admin_template_poll.php', 4, 0),
('tpl_press', 'templates', 'admin_template_press.php', 5, 0),
('tpl_screens', 'templates', 'admin_template_screenshot.php', 6, 0),
('tpl_wp', 'templates', 'admin_template_wallpaper.php', 7, 0),
('tpl_previewimg', 'templates', 'admin_template_previewimg.php', 8, 0),
('tpl_dl', 'templates', 'admin_template_dl.php', 9, 0),
('tpl_shop', 'templates', 'admin_template_shop.php', 10, 0),
('tpl_affiliates', 'templates', 'admin_template_affiliates.php', 11, 0),
('tpl_editor', 'templates', 'admin_editor_design.php', 13, 0),
('tpl_fscodes', 'templates', 'admin_editor_fscode.php', 14, 0),
('tpl_player', 'templates', 'admin_template_player.php', 20, 0),
('user_config', 'users', 'admin_user_config.php', 1, 0),
('user_add', 'users', 'admin_user_add.php', 2, 0),
('user_edit', 'users', 'admin_user_edit.php', 3, 0),
('user_rights', 'users', 'admin_user_rights.php', 4, 0),
('news_comments_list', 'news', 'admin_news_comments_list.php', 4, 0),
('cimg_cat', 'cimg', 'admin_cimgcats.php', 3, 0),
('cimg_import', 'cimg', 'admin_cimgimport.php', 4, 0),
('stat_ref_delete', 'stats', 'stat_ref', 1, 1),
('randompic_cat', 'gallery_preview', 'admin_randompic_cat.php', 2, 0),
('timedpic_add', 'gallery_preview', 'admin_randompic_time_add.php', 3, 0),
('timedpic_edit', 'gallery_preview', 'admin_randompic_time.php', 4, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_admin_groups`
--

DROP TABLE IF EXISTS `fs2_admin_groups`;
CREATE TABLE `fs2_admin_groups` (
  `group_id` varchar(20) NOT NULL,
  `menu_id` varchar(20) NOT NULL,
  `group_pos` tinyint(3) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Daten für Tabelle `fs2_admin_groups`
--

INSERT INTO `fs2_admin_groups` (`group_id`, `menu_id`, `group_pos`) VALUES
('-1', 'none', 0),
('0', 'none', 0),
('general', 'general', 1),
('fseditor', 'general', 2),
('stats', 'general', 3),
('news', 'content', 1),
('articles', 'content', 2),
('press', 'content', 3),
('cimg', 'content', 4),
('gallery', 'media', 1),
('gallery_img', 'media', 2),
('gallery_wp', 'media', 3),
('gallery_preview', 'media', 4),
('downloads', 'media', 6),
('player', 'media', 7),
('polls', 'interactive', 1),
('affiliates', 'promo', 1),
('shop', 'promo', 2),
('users', 'user', 1),
('styles', 'styles', 1),
('templates', 'styles', 2),
('groups', 'user', 2),
('applets', 'system', 1),
('snippets', 'system', 2),
('aliases', 'system', 3),
('search', 'general', 4),
('popup', 'none', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_admin_inherited`
--

DROP TABLE IF EXISTS `fs2_admin_inherited`;
CREATE TABLE `fs2_admin_inherited` (
  `group_id` varchar(255) NOT NULL,
  `pass_to` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `fs2_admin_inherited`
--

INSERT INTO `fs2_admin_inherited` (`group_id`, `pass_to`) VALUES
('applets', 'find_applet'),
('news', 'find_user'),
('articles', 'find_user'),
('news', 'news_preview'),
('articles', 'article_preview');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_aliases`
--

DROP TABLE IF EXISTS `fs2_aliases`;
CREATE TABLE `fs2_aliases` (
  `alias_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `alias_go` varchar(100) NOT NULL,
  `alias_forward_to` varchar(100) NOT NULL,
  `alias_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`alias_id`),
  KEY `alias_go` (`alias_go`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `fs2_aliases`
--

INSERT INTO `fs2_aliases` (`alias_id`, `alias_go`, `alias_forward_to`, `alias_active`) VALUES
(1, 'news_detail', 'comments', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_announcement`
--

DROP TABLE IF EXISTS `fs2_announcement`;
CREATE TABLE `fs2_announcement` (
  `id` smallint(4) NOT NULL,
  `announcement_text` text,
  `show_announcement` tinyint(1) NOT NULL DEFAULT '0',
  `activate_announcement` tinyint(1) NOT NULL DEFAULT '0',
  `ann_html` tinyint(1) NOT NULL DEFAULT '1',
  `ann_fscode` tinyint(1) NOT NULL DEFAULT '1',
  `ann_para` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `fs2_announcement`
--

INSERT INTO `fs2_announcement` (`id`, `announcement_text`, `show_announcement`, `activate_announcement`, `ann_html`, `ann_fscode`, `ann_para`) VALUES
(1, '', 2, 0, 1, 1, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_applets`
--

DROP TABLE IF EXISTS `fs2_applets`;
CREATE TABLE `fs2_applets` (
  `applet_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `applet_file` varchar(100) NOT NULL,
  `applet_active` tinyint(1) NOT NULL DEFAULT '1',
  `applet_include` tinyint(1) NOT NULL DEFAULT '1',
  `applet_output` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`applet_id`),
  UNIQUE KEY `applet_file` (`applet_file`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Daten für Tabelle `fs2_applets`
--

INSERT INTO `fs2_applets` (`applet_id`, `applet_file`, `applet_active`, `applet_include`, `applet_output`) VALUES
(2, 'user-menu', 1, 2, 1),
(3, 'announcement', 1, 2, 1),
(4, 'mini-statistics', 1, 2, 1),
(5, 'poll-system', 1, 2, 1),
(6, 'preview-image', 1, 2, 1),
(7, 'shop-system', 1, 2, 1),
(11, 'dl-forwarding', 1, 1, 0),
(9, 'mini-search', 1, 1, 1),
(10, 'affiliates', 1, 2, 1),
(12, 'test', 1, 2, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_articles`
--

DROP TABLE IF EXISTS `fs2_articles`;
CREATE TABLE `fs2_articles` (
  `article_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `article_url` varchar(100) DEFAULT NULL,
  `article_title` varchar(255) NOT NULL,
  `article_date` int(11) DEFAULT NULL,
  `article_user` mediumint(8) DEFAULT NULL,
  `article_text` text NOT NULL,
  `article_html` tinyint(1) NOT NULL DEFAULT '1',
  `article_fscode` tinyint(1) NOT NULL DEFAULT '1',
  `article_para` tinyint(1) NOT NULL DEFAULT '1',
  `article_cat_id` mediumint(8) NOT NULL,
  `article_search_update` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`article_id`),
  KEY `article_url` (`article_url`),
  FULLTEXT KEY `article_text` (`article_title`,`article_text`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Daten für Tabelle `fs2_articles`
--

INSERT INTO `fs2_articles` (`article_id`, `article_url`, `article_title`, `article_date`, `article_user`, `article_text`, `article_html`, `article_fscode`, `article_para`, `article_cat_id`, `article_search_update`) VALUES
(1, 'fscode', 'FSCode Liste', 1302480000, 1, 'Das System dieser Webseite bietet dir die Möglichkeit einfache Codes zur besseren Darstellung deiner Beiträge zu verwenden. Diese sogenannten [b]FSCodes[/b] erlauben dir daher HTML-Formatierungen zu verwenden, ohne dass du dich mit HTML auskennen musst. Mit ihnen hast du die Möglichkeit verschiedene Elemente in deine Beiträge einzubauen bzw. ihren Text zu formatieren.\r\n\r\nHier findest du eine [b]Übersicht über alle verfügbaren FSCodes[/b] und ihre Verwendung. Allerdings ist es möglich, dass nicht alle Codes zur Verwendung freigeschaltet sind.\r\n\r\n<table width=\\"100%\\" cellpadding=\\"0\\" cellspacing=\\"10\\" border=\\"0\\"><tr><td width=\\"50%\\">[b][u][size=3]FS-Code:[/size][/u][/b]</td><td width=\\"50%\\">[b][u][size=3]Beispiel:[/size][/u][/b]</td></tr><tr><td>[noparse][b]fetter Text[/b][/noparse]</td><td>[b]fetter Text[/b]</td></tr><tr><td>[noparse][i]kursiver Text[/i][/noparse]</td><td>[i]kursiver Text[/i]</td></tr><tr><td>[noparse][u]unterstrichener Text[u][/noparse]</td><td>[u]unterstrichener Text[/u]</td></tr><tr><td>[noparse][s]durchgestrichener Text[/s][/noparse]</td><td>[s]durchgestrichener Text[/s]</td></tr><tr><td>[noparse][center]zentrierter Text[/center][/noparse]</td><td>[center]zentrierter Text[/center]</td></tr><tr><td>[noparse][font=Schriftart]Text in Schriftart[/font][/noparse]</td><td>[font=Arial]Text in Arial[/font]</td></tr><tr><td>[noparse][color=Farbcode]Text in Farbe[/color][/noparse]</td><td>[color=#FF0000]Text in Rot (Farbcode: #FF0000)[/color]</td></tr><tr><td>[noparse][size=Größe]Text in Größe 0[/size][/noparse]</td><td>[size=0]Text in Größe 0[/size]</td></tr><tr><td>[noparse][size=Größe]Text in Größe 1[/size][/noparse]</td><td>[size=1]Text in Größe 1[/size]</td></tr><tr><td>[noparse][size=Größe]Text in Größe 2[/size][/noparse]</td><td>[size=2]Text in Größe 2[/size]</td></tr><tr><td>[noparse][size=Größe]Text in Größe 3[/size][/noparse]</td><td>[size=3]Text in Größe 3[/size]</td></tr><tr><td>[noparse][size=Größe]Text in Größe 4[/size][/noparse]</td><td>[size=4]Text in Größe 4[/size]</td></tr><tr><td>[noparse][size=Größe]Text in Größe 5[/size][/noparse]</td><td>[size=5]Text in Größe 5[/size]</td></tr><tr><td>[noparse][size=Größe]Text in Größe 6[/size][/noparse]</td><td>[size=6]Text in Größe 6[/size]</td></tr><tr><td>[noparse][size=Größe]Text in Größe 7[/size][/noparse]</td><td>[size=7]Text&nbsp;in&nbsp;Größe&nbsp;7[/size]</td></tr><tr><td>[noparse][noparse]Text mit [b]FS[/b]Code[/noparse][/noparse]</td><td>[noparse]kein [b]fetter[/b] Text[/noparse]</td></tr> <tr><td colspan=\\"2\\"><hr></td></tr> <tr><td>[noparse][url]Linkadresse[/url][/noparse]</td><td>[url]http://www.example.com[/url]</td></tr> <tr><td>[noparse][url=Linkadresse]Linktext[/url][/noparse]</td><td>[url=http://www.example.com]Linktext[/url]</td></tr> <tr><td>[noparse][home]Seitenlink[/home][/noparse]</td><td>[home]news[/home]</td></tr> <tr><td>[noparse][home=Seitenlink]Linktext[/home][/noparse]</td><td>[home=news]Linktext[/home]</td></tr> <tr><td>[noparse][email]Email-Adresse[/email][/noparse]</td><td>[email]max.mustermann@example.com[/email]</td></tr> <tr><td>[noparse][email=Email-Adresse]Beispieltext[/email][/noparse]</td><td>[email=max.mustermann@example.com]Beispieltext[/email]</td></tr> <tr><td colspan=\\"2\\"><hr></td></tr> <tr><td>[noparse][list]<br>[*]Listenelement<br>[*]Listenelement<br>[/list][/noparse]</td><td>[list]<br>[*]Listenelement<br>[*]Listenelement<br>[/list]</td></tr> <tr><td>[noparse][numlist]<br>[*]Listenelement<br>[*]Listenelement<br>[/numlist][/noparse]</td><td>[numlist]<br>[*]Listenelement<br>[*]Listenelement<br>[/numlist]</td></tr> <tr><td>[noparse][quote]Ein Zitat[/quote][/noparse]</td><td>[quote]Ein Zitat[/quote]</td></tr><tr><td>[noparse][quote=Quelle]Ein Zitat[/quote][/noparse]</td><td>[quote=Quelle]Ein Zitat[/quote]</td></tr><tr><td>[noparse][code]Schrift mit fester Breite[/code][/noparse]</td><td>[code]Schrift mit fester Breite[/code]</td></tr><tr><td colspan=\\"2\\"><hr></td></tr><tr><td>[noparse][img]Bildadresse[/img][/noparse]</td><td>[img]$VAR(url)images/icons/logo.gif[/img]</td></tr><tr><td>[noparse][img=right]Bildadresse[/img][/noparse]</td><td>[img=right]$VAR(url)images/icons/logo.gif[/img] Das hier ist ein Beispieltext. Die Grafik ist rechts platziert und der Text fließt links um sie herum.</td></tr><tr><td>[noparse][img=left]Bildadresse[/img][/noparse]</td><td>[img=left]$VAR(url)images/icons/logo.gif[/img] Das hier ist ein Beispieltext. Die Grafik ist links platziert und der Text fließt rechts um sie herum.</td></tr></table>', 1, 1, 1, 1, 1302797140),
(2, '', 'ie 8 test', 1302480000, 1, 'ie 8 test', 1, 1, 1, 1, 1302560322),
(3, 'sds', 'fsdfsdf', 1302739200, 1, 'sdf', 1, 1, 1, 1, 1302797133),
(4, 'sd', 'hallo', 1302739200, 1, 'sdfsdf', 1, 1, 1, 1, 1302797137);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_articles_cat`
--

DROP TABLE IF EXISTS `fs2_articles_cat`;
CREATE TABLE `fs2_articles_cat` (
  `cat_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(100) DEFAULT NULL,
  `cat_description` text NOT NULL,
  `cat_date` int(11) NOT NULL,
  `cat_user` mediumint(8) NOT NULL DEFAULT '1',
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `fs2_articles_cat`
--

INSERT INTO `fs2_articles_cat` (`cat_id`, `cat_name`, `cat_description`, `cat_date`, `cat_user`) VALUES
(1, 'Artikel', '', 1302517148, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_cimg`
--

DROP TABLE IF EXISTS `fs2_cimg`;
CREATE TABLE `fs2_cimg` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` varchar(4) NOT NULL,
  `hasthumb` tinyint(1) NOT NULL,
  `cat` mediumint(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `fs2_cimg`
--

INSERT INTO `fs2_cimg` (`id`, `name`, `type`, `hasthumb`, `cat`) VALUES
(1, 'camerazoom-20111218133317187', 'jpg', 0, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_cimg_cats`
--

DROP TABLE IF EXISTS `fs2_cimg_cats`;
CREATE TABLE `fs2_cimg_cats` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `fs2_cimg_cats`
--

INSERT INTO `fs2_cimg_cats` (`id`, `name`, `description`) VALUES
(1, 'Test', ''),
(2, 'dfgdf', 'gfgfg');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_config`
--

DROP TABLE IF EXISTS `fs2_config`;
CREATE TABLE `fs2_config` (
  `config_name` varchar(30) NOT NULL,
  `config_data` text NOT NULL,
  `config_loadhook` varchar(255) NOT NULL DEFAULT 'none',
  KEY `config_name` (`config_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `fs2_config`
--

INSERT INTO `fs2_config` (`config_name`, `config_data`, `config_loadhook`) VALUES
('main', '{\\"title\\":\\"Hansen\\''s wunderbare Welt\\",\\"dyn_title\\":\\"1\\",\\"dyn_title_ext\\":\\"{..title..} \\\\u00bb {..ext..}\\",\\"admin_mail\\":\\"mail@sweil.de\\",\\"description\\":\\"\\",\\"keywords\\":\\"\\",\\"publisher\\":\\"\\",\\"copyright\\":\\"\\",\\"style_id\\":\\"1\\",\\"allow_other_designs\\":\\"1\\",\\"show_favicon\\":\\"1\\",\\"home\\":\\"0\\",\\"home_text\\":\\"\\",\\"language_text\\":\\"de_DE\\",\\"feed\\":\\"rss20\\",\\"date\\":\\"d.m.Y\\",\\"time\\":\\"H:i \\\\\\\\U\\\\\\\\h\\\\\\\\r\\",\\"datetime\\":\\"d.m.Y, H:i \\\\\\\\U\\\\\\\\h\\\\\\\\r\\",\\"timezone\\":\\"Europe\\\\/Berlin\\",\\"auto_forward\\":\\"4\\",\\"page\\":\\"<div align=\\\\\\"center\\\\\\" style=\\\\\\"width:270px;\\\\\\"><div style=\\\\\\"width:70px; float:left;\\\\\\">{..prev..}\\\\u00a0<\\\\/div>Seite <b>{..page_number..}<\\\\/b> von <b>{..total_pages..}<\\\\/b><div style=\\\\\\"width:70px; float:right;\\\\\\">\\\\u00a0{..next..}<\\\\/div><\\\\/div>\\",\\"page_prev\\":\\"<a href=\\\\\\"{..url..}\\\\\\">\\\\u00ab\\\\u00a0zur\\\\u00fcck<\\\\/a>\\\\u00a0|\\",\\"page_next\\":\\"|\\\\u00a0<a href=\\\\\\"{..url..}\\\\\\">weiter \\\\u00bb<\\\\/a>\\",\\"style_tag\\":\\"lightfrog\\",\\"version\\":\\"2.alix6\\",\\"url_style\\":\\"seo\\",\\"protocol\\":\\"http:\\\\/\\\\/\\",\\"url\\":\\"localhost\\\\/fs2\\\\/www\\\\/\\",\\"other_protocol\\":\\"1\\",\\"count_referers\\":\\"1\\"}', 'startup'),
('system', '{\\"var_loop\\":20}', 'startup'),
('env', '{}', 'startup'),
('info', '{}', 'startup'),
('articles', '{\\"acp_per_page\\":\\"3\\",\\"html_code\\":\\"2\\",\\"fs_code\\":\\"4\\",\\"para_handling\\":\\"4\\",\\"cat_pic_x\\":\\"150\\",\\"cat_pic_y\\":\\"150\\",\\"cat_pic_size\\":\\"1024\\",\\"com_rights\\":\\"2\\",\\"com_antispam\\":\\"1\\",\\"com_sort\\":\\"ASC\\",\\"acp_view\\":\\"2\\"}', 'none'),
('search', '{\\"id\\":\\"0\\",\\"search_num_previews\\":\\"10\\",\\"search_and\\":\\"AND, and, &&\\",\\"search_or\\":\\"OR, or, ||\\",\\"search_xor\\":\\"XOR, xor\\",\\"search_not\\":\\"!, -\\",\\"search_wildcard\\":\\"*, %\\",\\"search_min_word_length\\":\\"3\\",\\"search_allow_phonetic\\":\\"1\\",\\"search_use_stopwords\\":\\"1\\"}', 'none'),
('cronjobs', '{\\"last_cronjob_time\\":\\"1341473400\\",\\"last_cronjob_time_daily\\":\\"1341439213\\",\\"last_cronjob_time_hourly\\":\\"1341471617\\",\\"search_index_update\\":\\"2\\",\\"ref_cron\\":\\"1\\",\\"ref_days\\":\\"5\\",\\"ref_hits\\":\\"3\\",\\"ref_contact\\":\\"first\\",\\"ref_age\\":\\"older\\",\\"ref_amount\\":\\"less\\"}', 'startup'),
('captcha', '{\\"captcha_bg_color\\":\\"FAFCF1\\",\\"captcha_bg_transparent\\":\\"0\\",\\"captcha_text_color\\":\\"000000\\",\\"captcha_first_lower\\":\\"1\\",\\"captcha_first_upper\\":\\"5\\",\\"captcha_second_lower\\":\\"1\\",\\"captcha_second_upper\\":\\"5\\",\\"captcha_use_addition\\":\\"1\\",\\"captcha_use_subtraction\\":\\"1\\",\\"captcha_use_multiplication\\":\\"0\\",\\"captcha_create_easy_arithmetics\\":\\"1\\",\\"captcha_x\\":\\"58\\",\\"captcha_y\\":\\"18\\",\\"captcha_show_questionmark\\":\\"0\\",\\"captcha_use_spaces\\":\\"1\\",\\"captcha_show_multiplication_as_x\\":\\"1\\",\\"captcha_start_text_x\\":\\"0\\",\\"captcha_start_text_y\\":\\"0\\",\\"captcha_font_size\\":\\"5\\",\\"captcha_font_file\\":\\"\\"}', 'none'),
('downloads', '{\\"screen_x\\":\\"1024\\",\\"screen_y\\":\\"768\\",\\"thumb_x\\":\\"120\\",\\"thumb_y\\":\\"90\\",\\"quickinsert\\":\\"test\\''\\",\\"dl_rights\\":\\"2\\",\\"dl_show_sub_cats\\":\\"1\\"}', 'none'),
('affiliates', '{\\"partner_anzahl\\":\\"5\\",\\"small_x\\":\\"88\\",\\"small_y\\":\\"31\\",\\"big_x\\":\\"468\\",\\"big_y\\":\\"60\\",\\"big_allow\\":\\"1\\",\\"file_size\\":\\"1024\\",\\"small_allow\\":\\"0\\"}', 'none'),
('news', '{\\"num_news\\":\\"11\\",\\"num_head\\":\\"5\\",\\"html_code\\":\\"2\\",\\"fs_code\\":\\"4\\",\\"para_handling\\":\\"4\\",\\"cat_pic_x\\":\\"150\\",\\"cat_pic_y\\":\\"150\\",\\"cat_pic_size\\":\\"1024\\",\\"com_rights\\":\\"2\\",\\"com_antispam\\":\\"2\\",\\"news_headline_lenght\\":\\"20\\",\\"acp_per_page\\":\\"15\\",\\"acp_view\\":\\"2\\",\\"com_sort\\":\\"DESC\\",\\"news_headline_ext\\":\\" ...\\",\\"acp_force_cat_selection\\":\\"1\\"}', 'none'),
('video_player', '{\\"cfg_player_x\\":\\"500\\",\\"cfg_player_y\\":\\"280\\",\\"cfg_autoplay\\":\\"0\\",\\"cfg_autoload\\":\\"1\\",\\"cfg_buffer\\":\\"5\\",\\"cfg_buffermessage\\":\\"Buffering _n_\\",\\"cfg_buffercolor\\":\\"#FFFFFF\\",\\"cfg_bufferbgcolor\\":\\"#000000\\",\\"cfg_buffershowbg\\":\\"0\\",\\"cfg_titlesize\\":\\"20\\",\\"cfg_titlecolor\\":\\"#FFFFFF\\",\\"cfg_margin\\":\\"5\\",\\"cfg_showstop\\":\\"1\\",\\"cfg_showvolume\\":\\"1\\",\\"cfg_showtime\\":\\"1\\",\\"cfg_showplayer\\":\\"autohide\\",\\"cfg_showloading\\":\\"always\\",\\"cfg_showfullscreen\\":\\"1\\",\\"cfg_showmouse\\":\\"autohide\\",\\"cfg_loop\\":\\"0\\",\\"cfg_playercolor\\":\\"#a6a6a6\\",\\"cfg_loadingcolor\\":\\"#000000\\",\\"cfg_bgcolor\\":\\"#FAFCF1\\",\\"cfg_bgcolor1\\":\\"#E7E7E7\\",\\"cfg_bgcolor2\\":\\"#cccccc\\",\\"cfg_buttoncolor\\":\\"#000000\\",\\"cfg_buttonovercolor\\":\\"#E7E7E7\\",\\"cfg_slidercolor1\\":\\"#cccccc\\",\\"cfg_slidercolor2\\":\\"#bbbbbb\\",\\"cfg_sliderovercolor\\":\\"#E7E7E7\\",\\"cfg_loadonstop\\":\\"1\\",\\"cfg_onclick\\":\\"playpause\\",\\"cfg_ondoubleclick\\":\\"fullscreen\\",\\"cfg_playertimeout\\":\\"1500\\",\\"cfg_videobgcolor\\":\\"#000000\\",\\"cfg_volume\\":\\"100\\",\\"cfg_shortcut\\":\\"1\\",\\"cfg_playeralpha\\":\\"100\\",\\"cfg_top1_url\\":\\"\\",\\"cfg_top1_x\\":\\"0\\",\\"cfg_top1_y\\":\\"0\\",\\"cfg_showiconplay\\":\\"1\\",\\"cfg_iconplaycolor\\":\\"#FFFFFF\\",\\"cfg_iconplaybgcolor\\":\\"#000000\\",\\"cfg_iconplaybgalpha\\":\\"75\\",\\"cfg_showtitleandstartimage\\":\\"0\\"}', 'none'),
('polls', '{\\"answerbar_width\\":\\"100\\",\\"answerbar_type\\":\\"0\\"}', 'none'),
('press', '{\\"game_navi\\":\\"1\\",\\"cat_navi\\":\\"1\\",\\"lang_navi\\":\\"0\\",\\"show_press\\":\\"0\\",\\"show_root\\":\\"0\\",\\"order_by\\":\\"press_date\\",\\"order_type\\":\\"desc\\"}', 'none'),
('preview_images', '{\\"active\\":\\"1\\",\\"type_priority\\":\\"1\\",\\"use_priority_only\\":\\"0\\",\\"timed_deltime\\":\\"604800\\"}', 'none'),
('groups', '{\\"group_pic_x\\":\\"250\\",\\"group_pic_y\\":\\"25\\",\\"group_pic_size\\":\\"100\\"}', 'none'),
('screens', '{\\"screen_x\\":\\"1500\\",\\"screen_y\\":\\"1500\\",\\"screen_thumb_x\\":\\"120\\",\\"screen_thumb_y\\":\\"90\\",\\"screen_size\\":\\"1024\\",\\"screen_rows\\":\\"5\\",\\"screen_cols\\":\\"3\\",\\"screen_order\\":\\"id\\",\\"screen_sort\\":\\"desc\\",\\"show_type\\":\\"1\\",\\"show_size_x\\":\\"950\\",\\"show_size_y\\":\\"700\\",\\"show_img_x\\":\\"800\\",\\"show_img_y\\":\\"600\\",\\"wp_x\\":\\"2000\\",\\"wp_y\\":\\"2000\\",\\"wp_thumb_x\\":\\"200\\",\\"wp_thumb_y\\":\\"150\\",\\"wp_size\\":\\"1536\\",\\"wp_rows\\":\\"6\\",\\"wp_cols\\":\\"2\\",\\"wp_order\\":\\"id\\",\\"wp_sort\\":\\"desc\\"}', 'none'),
('users', '{\\"user_per_page\\":\\"30\\",\\"registration_antispam\\":\\"1\\",\\"avatar_x\\":\\"110\\",\\"avatar_y\\":\\"110\\",\\"avatar_size\\":\\"20\\",\\"reg_date_format\\":\\"l, j. F Y\\",\\"user_list_reg_date_format\\":\\"j. F Y\\"}', 'none');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_counter`
--

DROP TABLE IF EXISTS `fs2_counter`;
CREATE TABLE `fs2_counter` (
  `id` tinyint(1) NOT NULL,
  `visits` int(11) unsigned NOT NULL DEFAULT '0',
  `hits` int(11) unsigned NOT NULL DEFAULT '0',
  `user` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `artikel` smallint(6) unsigned NOT NULL DEFAULT '0',
  `news` smallint(6) unsigned NOT NULL DEFAULT '0',
  `comments` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `fs2_counter`
--

INSERT INTO `fs2_counter` (`id`, `visits`, `hits`, `user`, `artikel`, `news`, `comments`) VALUES
(1, 78, 2522, 2, 4, 65528, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_counter_ref`
--

DROP TABLE IF EXISTS `fs2_counter_ref`;
CREATE TABLE `fs2_counter_ref` (
  `ref_url` varchar(255) DEFAULT NULL,
  `ref_count` int(11) DEFAULT NULL,
  `ref_first` int(11) DEFAULT NULL,
  `ref_last` int(11) DEFAULT NULL,
  KEY `ref_url` (`ref_url`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `fs2_counter_ref`
--

INSERT INTO `fs2_counter_ref` (`ref_url`, `ref_count`, `ref_first`, `ref_last`) VALUES
('http://localhost/', 55, 1302557491, 1307980522),
('http://localhost/fs2/', 18, 1316955935, 1341432966);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_counter_stat`
--

DROP TABLE IF EXISTS `fs2_counter_stat`;
CREATE TABLE `fs2_counter_stat` (
  `s_year` int(4) NOT NULL DEFAULT '0',
  `s_month` int(2) NOT NULL DEFAULT '0',
  `s_day` int(2) NOT NULL DEFAULT '0',
  `s_visits` int(11) DEFAULT NULL,
  `s_hits` int(11) DEFAULT NULL,
  PRIMARY KEY (`s_year`,`s_month`,`s_day`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `fs2_counter_stat`
--

INSERT INTO `fs2_counter_stat` (`s_year`, `s_month`, `s_day`, `s_visits`, `s_hits`) VALUES
(2011, 4, 11, 4, 22),
(2011, 4, 12, 1, 5),
(2011, 4, 13, 1, 17),
(2011, 4, 14, 1, 9),
(2011, 4, 20, 1, 1),
(2011, 5, 9, 1, 121),
(2011, 5, 11, 1, 7),
(2011, 5, 12, 1, 5),
(2011, 5, 13, 1, 11),
(2011, 5, 15, 1, 1),
(2011, 5, 16, 1, 17),
(2011, 5, 22, 1, 8),
(2011, 5, 23, 1, 3),
(2011, 5, 24, 1, 5),
(2011, 5, 25, 1, 12),
(2011, 5, 26, 1, 27),
(2011, 5, 29, 3, 77),
(2011, 6, 2, 1, 1),
(2011, 6, 3, 1, 2),
(2011, 6, 4, 1, 2),
(2011, 6, 5, 1, 16),
(2011, 6, 10, 1, 2),
(2011, 6, 11, 1, 3),
(2011, 6, 12, 2, 3),
(2011, 6, 13, 1, 10),
(2011, 6, 22, 1, 32),
(2011, 6, 27, 1, 2),
(2011, 6, 30, 1, 13),
(2011, 7, 1, 2, 141),
(2011, 7, 7, 1, 267),
(2011, 7, 8, 1, 56),
(2011, 7, 11, 2, 152),
(2011, 7, 12, 1, 171),
(2011, 7, 13, 1, 47),
(2011, 7, 20, 1, 1),
(2011, 9, 25, 1, 237),
(2011, 9, 26, 2, 235),
(2011, 9, 27, 2, 225),
(2011, 9, 28, 1, 23),
(2011, 9, 29, 1, 2),
(2011, 10, 8, 1, 69),
(2011, 10, 9, 1, 21),
(2011, 10, 16, 2, 137),
(2011, 10, 17, 1, 10),
(2011, 10, 18, 1, 47),
(2011, 10, 20, 1, 2),
(2011, 11, 3, 1, 49),
(2011, 12, 28, 1, 8),
(2011, 12, 29, 2, 2),
(2012, 2, 3, 1, 4),
(2012, 6, 12, 1, 2),
(2012, 6, 18, 1, 6),
(2012, 6, 19, 1, 14),
(2012, 6, 21, 2, 25),
(2012, 6, 23, 1, 5),
(2012, 6, 25, 1, 7),
(2012, 6, 26, 2, 62),
(2012, 6, 27, 1, 6),
(2012, 7, 2, 1, 23),
(2012, 7, 3, 1, 10),
(2012, 7, 4, 2, 20),
(2012, 7, 5, 0, 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_dl`
--

DROP TABLE IF EXISTS `fs2_dl`;
CREATE TABLE `fs2_dl` (
  `dl_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `cat_id` mediumint(8) DEFAULT NULL,
  `user_id` mediumint(8) DEFAULT NULL,
  `dl_date` int(11) DEFAULT NULL,
  `dl_name` varchar(100) DEFAULT NULL,
  `dl_text` text,
  `dl_autor` varchar(100) DEFAULT NULL,
  `dl_autor_url` varchar(255) DEFAULT NULL,
  `dl_open` tinyint(4) DEFAULT NULL,
  `dl_search_update` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`dl_id`),
  FULLTEXT KEY `dl_name_text` (`dl_name`,`dl_text`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Daten für Tabelle `fs2_dl`
--

INSERT INTO `fs2_dl` (`dl_id`, `cat_id`, `user_id`, `dl_date`, `dl_name`, `dl_text`, `dl_autor`, `dl_autor_url`, `dl_open`, `dl_search_update`) VALUES
(1, 1, 1, 1302597530, 'ff test update', 'ff testsdfsdfsdf', '', '', 1, 1302598819),
(2, 1, 1, 1302597571, 'ie8 update', 'ie8', '', '', 1, 1302597626),
(3, 1, 1, 1302597584, 'ie7 update', 'ie7', '', '', 1, 1302597631),
(4, 1, 1, 1302597600, 'ie6 update', 'ie6', '', '', 1, 1302597635),
(5, 1, 1, 1302597816, 'sdfsdf', 'sdf', '', '', 1, 1302597816),
(6, 1, 1, 1302597870, 'wsd', 'sdf', '', '', 1, 1302597870),
(7, 1, 1, 1302597934, 'sdf', 'sd', '', '', 1, 1302597934),
(9, 1, 1, 1306417405, 'Frogsystem 2.alix6', 'asda', 'asd', 'asd', 1, 1306417405),
(10, 1, 1, 1306417420, 'Hansens wunderbare Weasddes Wissensasd', 'asdasd', 'asdas', 'asd', 1, 1306417420),
(11, 1, 1, 1306684436, 'A Download', 'libapr1-1.2.2-1.1.src.rpm', 'Suse', '', 1, 1306684436);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_dl_cat`
--

DROP TABLE IF EXISTS `fs2_dl_cat`;
CREATE TABLE `fs2_dl_cat` (
  `cat_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `subcat_id` mediumint(8) NOT NULL DEFAULT '0',
  `cat_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Daten für Tabelle `fs2_dl_cat`
--

INSERT INTO `fs2_dl_cat` (`cat_id`, `subcat_id`, `cat_name`) VALUES
(1, 0, 'Downloads'),
(2, 1, 'test2'),
(4, 0, 'sdfsdf'),
(5, 4, 'hans'),
(6, 5, 'wurst');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_dl_files`
--

DROP TABLE IF EXISTS `fs2_dl_files`;
CREATE TABLE `fs2_dl_files` (
  `dl_id` mediumint(8) DEFAULT NULL,
  `file_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `file_count` mediumint(8) NOT NULL DEFAULT '0',
  `file_name` varchar(100) DEFAULT NULL,
  `file_url` varchar(255) DEFAULT NULL,
  `file_size` mediumint(8) NOT NULL DEFAULT '0',
  `file_is_mirror` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`file_id`),
  KEY `dl_id` (`dl_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Daten für Tabelle `fs2_dl_files`
--

INSERT INTO `fs2_dl_files` (`dl_id`, `file_id`, `file_count`, `file_name`, `file_url`, `file_size`, `file_is_mirror`) VALUES
(1, 1, 0, '42', 'test', 42, 0),
(2, 2, 0, 'ie8', 'test', 123, 0),
(3, 3, 0, 'ie7', '123', 23, 0),
(4, 4, 0, 'ie6', 'sdf', 234, 0),
(6, 5, 0, '3', 'd', 45, 0),
(9, 7, 0, 'asd', 'test', 33, 0),
(10, 8, 0, 'sd', 'asd', 3, 0),
(11, 10, 1, 'libapr1-1.2libapr1-1.2.2-1.1.src.rpm.2-1.1.src.rpm', 'ftp://ftp.suse.de/pub/projects/apache/libapr1/10.0-x86_64/libapr1-1.2.2-1.1.src.rpm', 906, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_editor_config`
--

DROP TABLE IF EXISTS `fs2_editor_config`;
CREATE TABLE `fs2_editor_config` (
  `id` tinyint(1) NOT NULL DEFAULT '1',
  `smilies_rows` int(2) NOT NULL,
  `smilies_cols` int(2) NOT NULL,
  `textarea_width` int(3) NOT NULL,
  `textarea_height` int(3) NOT NULL,
  `bold` tinyint(1) NOT NULL DEFAULT '0',
  `italic` tinyint(1) NOT NULL DEFAULT '0',
  `underline` tinyint(1) NOT NULL DEFAULT '0',
  `strike` tinyint(1) NOT NULL DEFAULT '0',
  `center` tinyint(1) NOT NULL DEFAULT '0',
  `font` tinyint(1) NOT NULL DEFAULT '0',
  `color` tinyint(1) NOT NULL DEFAULT '0',
  `size` tinyint(1) NOT NULL DEFAULT '0',
  `list` tinyint(1) NOT NULL,
  `numlist` tinyint(1) NOT NULL,
  `img` tinyint(1) NOT NULL DEFAULT '0',
  `cimg` tinyint(1) NOT NULL DEFAULT '0',
  `url` tinyint(1) NOT NULL DEFAULT '0',
  `home` tinyint(1) NOT NULL DEFAULT '0',
  `email` tinyint(1) NOT NULL DEFAULT '0',
  `code` tinyint(1) NOT NULL DEFAULT '0',
  `quote` tinyint(1) NOT NULL DEFAULT '0',
  `noparse` tinyint(1) NOT NULL DEFAULT '0',
  `smilies` tinyint(1) NOT NULL DEFAULT '0',
  `do_bold` tinyint(1) NOT NULL,
  `do_italic` tinyint(1) NOT NULL,
  `do_underline` tinyint(1) NOT NULL,
  `do_strike` tinyint(1) NOT NULL,
  `do_center` tinyint(1) NOT NULL,
  `do_font` tinyint(1) NOT NULL,
  `do_color` tinyint(1) NOT NULL,
  `do_size` tinyint(1) NOT NULL,
  `do_list` tinyint(1) NOT NULL,
  `do_numlist` tinyint(1) NOT NULL,
  `do_img` tinyint(1) NOT NULL,
  `do_cimg` tinyint(1) NOT NULL,
  `do_url` tinyint(1) NOT NULL,
  `do_home` tinyint(1) NOT NULL,
  `do_email` tinyint(1) NOT NULL,
  `do_code` tinyint(1) NOT NULL,
  `do_quote` tinyint(1) NOT NULL,
  `do_noparse` tinyint(1) NOT NULL,
  `do_smilies` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `fs2_editor_config`
--

INSERT INTO `fs2_editor_config` (`id`, `smilies_rows`, `smilies_cols`, `textarea_width`, `textarea_height`, `bold`, `italic`, `underline`, `strike`, `center`, `font`, `color`, `size`, `list`, `numlist`, `img`, `cimg`, `url`, `home`, `email`, `code`, `quote`, `noparse`, `smilies`, `do_bold`, `do_italic`, `do_underline`, `do_strike`, `do_center`, `do_font`, `do_color`, `do_size`, `do_list`, `do_numlist`, `do_img`, `do_cimg`, `do_url`, `do_home`, `do_email`, `do_code`, `do_quote`, `do_noparse`, `do_smilies`) VALUES
(1, 5, 2, 355, 120, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 1, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_email`
--

DROP TABLE IF EXISTS `fs2_email`;
CREATE TABLE `fs2_email` (
  `id` tinyint(1) NOT NULL DEFAULT '1',
  `signup` text NOT NULL,
  `change_password` text NOT NULL,
  `delete_account` text NOT NULL,
  `change_password_ack` text NOT NULL,
  `use_admin_mail` tinyint(1) NOT NULL DEFAULT '1',
  `email` varchar(100) NOT NULL,
  `html` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `fs2_email`
--

INSERT INTO `fs2_email` (`id`, `signup`, `change_password`, `delete_account`, `change_password_ack`, `use_admin_mail`, `email`, `html`) VALUES
(1, 'Hallo  {..user_name..},\r\n\r\nDu hast dich bei $VAR(page_title) registriert. Deine Zugangsdaten sind:\r\n\r\nBenutzername: {..user_name..}\r\nPasswort: {..new_password..}\r\n\r\nFalls du deine Daten ändern möchtest, kannst du das gerne auf deiner [url=$VAR(url)?go=editprofil]Profilseite[/url] tun.\r\n\r\nDein Team von $VAR(page_title)!', 'Hallo {..user_name..},\r\n\r\nDein Passwort bei $VAR(page_title) wurde geändert. Deine neuen Zugangsdaten sind:\r\n\r\nBenutzername: {..user_name..}\r\nPasswort: {..new_password..}\r\n\r\nFalls du deine Daten ändern möchtest, kannst du das gerne auf deiner [url=$VAR(url)?go=user_edit]Profilseite[/url] tun.\r\n\r\nDein Team von $VAR(page_title)!', 'Hallo {username},\r\n\r\nSchade, dass du dich von unserer Seite abgemeldet hast. Falls du es dir doch noch anders überlegen willst, [url={virtualhost}]kannst du ja nochmal rein schauen[/url].\r\n\r\nDein Webseiten-Team!', 'Hallo {..user_name..},\r\n\r\nDu hast für deinen Account auf $VAR(page_title) ein neues Passwort angefordert. Um den Vorgang abzuschließen musst du nur noch innerhalb der nächsten zwei Tage den folgenden Link anklicken: [url={..new_password_url..}]Neues Passwort setzen[/url]\r\n\r\nFalls du [b]kein[/b] neues Passwort angefordert hast, ignoriere diese E-Mail einfach. Du kannst dich weiterhin mit deinem bisherigen Passwort bei uns anmelden.\r\n\r\nDein Team von $VAR(page_title)!', 1, '', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_ftp`
--

DROP TABLE IF EXISTS `fs2_ftp`;
CREATE TABLE `fs2_ftp` (
  `ftp_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `ftp_title` varchar(100) NOT NULL,
  `ftp_type` varchar(10) NOT NULL,
  `ftp_url` varchar(255) NOT NULL,
  `ftp_user` varchar(255) NOT NULL,
  `ftp_pw` varchar(255) NOT NULL,
  `ftp_ssl` tinyint(1) NOT NULL,
  `ftp_http_url` varchar(255) NOT NULL,
  PRIMARY KEY (`ftp_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `fs2_ftp`
--

INSERT INTO `fs2_ftp` (`ftp_id`, `ftp_title`, `ftp_type`, `ftp_url`, `ftp_user`, `ftp_pw`, `ftp_ssl`, `ftp_http_url`) VALUES
(1, 'DL-Server', 'dl', 'ftp.suse.de', 'anonymous', 'anonymous', 0, 'ftp://ftp.suse.de');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_hashes`
--

DROP TABLE IF EXISTS `fs2_hashes`;
CREATE TABLE `fs2_hashes` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `hash` varchar(40) CHARACTER SET utf8 NOT NULL,
  `type` varchar(20) CHARACTER SET utf8 NOT NULL,
  `typeId` mediumint(8) NOT NULL,
  `deleteTime` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `hash` (`hash`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `fs2_hashes`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_news`
--

DROP TABLE IF EXISTS `fs2_news`;
CREATE TABLE `fs2_news` (
  `news_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `cat_id` smallint(6) DEFAULT NULL,
  `user_id` mediumint(8) DEFAULT NULL,
  `news_date` int(11) DEFAULT NULL,
  `news_title` varchar(255) DEFAULT NULL,
  `news_text` text,
  `news_active` tinyint(1) NOT NULL DEFAULT '1',
  `news_comments_allowed` tinyint(1) NOT NULL DEFAULT '1',
  `news_search_update` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`news_id`),
  FULLTEXT KEY `news_title_text` (`news_title`,`news_text`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=45 ;

--
-- Daten für Tabelle `fs2_news`
--

INSERT INTO `fs2_news` (`news_id`, `cat_id`, `user_id`, `news_date`, `news_title`, `news_text`, `news_active`, `news_comments_allowed`, `news_search_update`) VALUES
(1, 1, 1, 1302517148, 'Frogsystem 2.alix5 - Installation erfolgreich', 'Herzlich Willkommen in deinem frisch installierten Frogsystem 2!\r\nDas Frogsystem 2-Team wünscht viel Spaß und Erfolg mit der Seite.\r\n\r\nWeitere Informationen und Hilfe bei Problemen gibt es auf der offiziellen Homepage des Frogsystem 2, in den zugehörigen Supportforen und dem neuen Dokumentations-Wiki. Die wichtigsten Links haben wir unten zusammengefasst. Einfach mal vorbei schauen!\r\n\r\nDein Frogsystem 2-Team', 1, 1, 0),
(5, 1, 1, 1302567540, 'ie 8 test update2', 'ie 8 test update', 1, 1, 0),
(7, 1, 1, 1302560460, 'safari test uüpdate', 'safari testvuüpdate', 1, 1, 1302560525),
(32, 1, 1, 1302571260, 'safari test uüpdate', 'spaß', 1, 1, 0),
(33, 1, 1, 1302571260, 'safari test uüpdate', 'spaß', 1, 1, 0),
(34, 1, 1, 1302517140, 'Frogsystem 2.alix5 - Installation erfolgreich', 'Herzlich Willkommen in deinem frisch installierten Frogsystem 2!\r\nDas Frogsystem 2-Team wünscht viel Spaß und Erfolg mit der Seite.\r\n\r\nWeitere Informationen und Hilfe bei Problemen gibt es auf der offiziellen Homepage des Frogsystem 2, in den zugehörigen Supportforen und dem neuen Dokumentations-Wiki. Die wichtigsten Links haben wir unten zusammengefasst. Einfach mal vorbei schauen!\r\n\r\nDein Frogsystem 2-Team\r\n\r\ntest', 1, 1, 0),
(35, 1, 1, 1310069220, 'frisch2', 'frisch2', 1, 1, 0),
(36, 1, 1, 1310069220, 'frisch2', 'frisch2\r\ntim\r\ntimmy', 1, 1, 1310509434),
(37, 1, 1, 1316987520, 'Poll Test', 'hallo\r\n\r\n$APP(poll-system.php)\r\n\r\n--------\r\n\r\n$APP(poll-system.php[4])\r\n\r\n---------\r\n\r\n$APP(poll-system.php[1])', 1, 1, 1316990207),
(38, 2, 1, 1317067500, 'Test', '$APP(dieseappgibtesnicht)\r\n[%snippetnot%]\r\n$NAV(navnot)\r\n$VAR(Varnot)', 1, 1, 1317068575),
(39, 2, 1, 1318076760, 'home test', '[home=news]Test 1[/home]\r\n[home]news[/home]\r\n-------------------\r\n[home=comments&amp;id=39]Test 1[/home]\r\n[home]comments&amp;id=39[/home]\r\n-------------------\r\n[home=comments&id=39]Test 1[/home]\r\n[home]comments&id=39[/home]\r\n-------------------\r\n[home]news[foo=bar][/home]\r\n[home]news[foo=bar hans=wurst][/home]\r\n-------------------\r\n[home=news foo=bar]Test 4[/home]\r\n[home=news foo=bar hans=wurst]Test 5[/home]\r\n-------------------\r\n[home=news&hans=wurst foo=bar]Test 6[/home]\r\n[home=news&amp;hans=wurst foo=bar]Test 7[/home]\r\n\r\n-------------------\r\n-------------------\r\n\r\n[noparse][home=news]Test 1[/home]\r\n[home]news[/home]\r\n-------------------\r\n[home=comments&amp;id=39]Test 1[/home]\r\n[home]comments&amp;id=39[/home]\r\n-------------------\r\n[home=comments&id=39]Test 1[/home]\r\n[home]comments&id=39[/home]\r\n-------------------\r\n[home]news[foo=bar][/home]\r\n[home]news[foo=bar hans=wurst][/home]\r\n-------------------\r\n[home=news foo=bar]Test 4[/home]\r\n[home=news foo=bar hans=wurst ]Test 5[/home]\r\n-------------------\r\n[home=news&hans=wurst foo=bar]Test 6[/home]\r\n[home=news&amp;hans=wurst foo=bar]Test 7[/home][/noparse]', 1, 1, 1318079355),
(40, 2, 1, 1318963680, 'Überarbeitete Umfrage zum besten Entwicklerstudio aller Zeiten (News) ', 'bkah', 1, 1, 0),
(41, 1, 1, 1325103780, 'Hallo', 'Hallo', 1, 1, 0),
(42, 1, 1, 1325103780, 'Hallo', 'Hallo', 1, 1, 1325104446),
(43, 1, 1, 1325104440, 'Tsdsdfsd', 'fsdfsdfsdfsdfsdf', 1, 1, 0),
(44, 2, 1, 1340724960, 'test', 'test', 1, 1, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_news_cat`
--

DROP TABLE IF EXISTS `fs2_news_cat`;
CREATE TABLE `fs2_news_cat` (
  `cat_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(100) DEFAULT NULL,
  `cat_description` text NOT NULL,
  `cat_date` int(11) NOT NULL,
  `cat_user` mediumint(8) NOT NULL DEFAULT '1',
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `fs2_news_cat`
--

INSERT INTO `fs2_news_cat` (`cat_id`, `cat_name`, `cat_description`, `cat_date`, `cat_user`) VALUES
(1, 'News', '', 1302517148, 1),
(2, 'The Witcher: Assassins of Kings', '', 1307814857, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_news_comments`
--

DROP TABLE IF EXISTS `fs2_news_comments`;
CREATE TABLE `fs2_news_comments` (
  `comment_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `news_id` mediumint(8) DEFAULT NULL,
  `comment_poster` varchar(32) DEFAULT NULL,
  `comment_poster_id` mediumint(8) DEFAULT NULL,
  `comment_poster_ip` varchar(16) NOT NULL,
  `comment_date` int(11) DEFAULT NULL,
  `comment_title` varchar(100) DEFAULT NULL,
  `comment_text` text,
  PRIMARY KEY (`comment_id`),
  FULLTEXT KEY `comment_title_text` (`comment_text`,`comment_title`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Daten für Tabelle `fs2_news_comments`
--

INSERT INTO `fs2_news_comments` (`comment_id`, `news_id`, `comment_poster`, `comment_poster_id`, `comment_poster_ip`, `comment_date`, `comment_title`, `comment_text`) VALUES
(3, 5, '1', 1, '127.0.0.1', 1306441173, 'hans', 'hans');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_news_links`
--

DROP TABLE IF EXISTS `fs2_news_links`;
CREATE TABLE `fs2_news_links` (
  `news_id` mediumint(8) DEFAULT NULL,
  `link_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `link_name` varchar(100) DEFAULT NULL,
  `link_url` varchar(255) DEFAULT NULL,
  `link_target` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`link_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=105 ;

--
-- Daten für Tabelle `fs2_news_links`
--

INSERT INTO `fs2_news_links` (`news_id`, `link_id`, `link_name`, `link_url`, `link_target`) VALUES
(1, 1, 'Offizielle Frogsystem 2 Homepage', 'http://www.frogsystem.de', 1),
(1, 2, 'Frogsystem 2 Supportforum', 'http://forum.sweil.de/viewforum.php?f=7', 1),
(1, 3, 'Frogsystem 2 Dokumentations-Wiki', 'http://wiki.frogsystem.de/', 1),
(2, 6, 'sdfsdf', 'http://', 0),
(27, 49, 'WoP', 'http://www.worldofplayers.de', 1),
(27, 48, 'Test', 'http://www.test.de', 1),
(27, 50, 'Home', 'http://localhost/fs2.6/', 0),
(28, 51, 'Test', 'http://www.test.de', 1),
(28, 52, 'Home', 'http://localhost/fs2.6/', 0),
(28, 53, 'WoP', 'http://www.worldofplayers.de', 1),
(29, 54, 'Test', 'http://www.test.de', 1),
(29, 55, 'Home', 'http://localhost/fs2.6/', 0),
(29, 56, 'WoP', 'http://www.worldofplayers.de', 1),
(31, 62, 'WoP', 'http://www.worldofplayers.de', 1),
(31, 61, 'Home', 'http://localhost/fs2.6/', 0),
(31, 60, 'Test', 'http://www.test.de', 1),
(30, 59, 'WoP', 'http://www.worldofplayers.de', 1),
(30, 58, 'Home', 'http://localhost/fs2.6/', 0),
(30, 57, 'Test', 'http://www.test.de', 1),
(34, 63, 'Offizielle Frogsystem 2 Homepage', 'http://www.frogsystem.de', 1),
(34, 64, 'Frogsystem 2 Supportforum', 'http://forum.sweil.de/viewforum.php?f=7', 1),
(34, 65, 'Frogsystem 2 Dokumentations-Wiki', 'http://wiki.frogsystem.de/', 1),
(36, 99, 'Diskussion im Forum', 'http://www.sweil.de', 0),
(5, 68, 'dd', 'http://ff', 0),
(5, 69, 'gdfg', 'http://ff', 1),
(42, 100, 'Test', 'http://asdasdasd', 0),
(42, 101, 'asdasd', 'http://asdasd', 0),
(43, 102, 'sdfsdf', 'http://sdfsdfsd', 1),
(43, 103, 'sdfsd', 'http://sdfsdf', 0),
(44, 104, 'test', 'http://sdsd', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_partner`
--

DROP TABLE IF EXISTS `fs2_partner`;
CREATE TABLE `fs2_partner` (
  `partner_id` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
  `partner_name` varchar(150) NOT NULL,
  `partner_link` varchar(250) NOT NULL,
  `partner_beschreibung` text NOT NULL,
  `partner_permanent` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`partner_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `fs2_partner`
--

INSERT INTO `fs2_partner` (`partner_id`, `partner_name`, `partner_link`, `partner_beschreibung`, `partner_permanent`) VALUES
(1, 'asdasd', 'http://asasdasd', 'asdasdasasdasd', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_player`
--

DROP TABLE IF EXISTS `fs2_player`;
CREATE TABLE `fs2_player` (
  `video_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `video_type` tinyint(1) NOT NULL DEFAULT '1',
  `video_x` text NOT NULL,
  `video_title` varchar(100) NOT NULL,
  `video_lenght` smallint(6) NOT NULL DEFAULT '0',
  `video_desc` text NOT NULL,
  `dl_id` mediumint(8) NOT NULL,
  PRIMARY KEY (`video_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `fs2_player`
--

INSERT INTO `fs2_player` (`video_id`, `video_type`, `video_x`, `video_title`, `video_lenght`, `video_desc`, `dl_id`) VALUES
(1, 1, 'http://dl.worldofplayers.de/wop/witcher/witcher2/sonstiges/ausgepackt.flv', 'Test', 80, 'Test', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_poll`
--

DROP TABLE IF EXISTS `fs2_poll`;
CREATE TABLE `fs2_poll` (
  `poll_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `poll_quest` varchar(255) DEFAULT NULL,
  `poll_start` int(11) DEFAULT NULL,
  `poll_end` int(11) DEFAULT NULL,
  `poll_type` tinyint(4) DEFAULT NULL,
  `poll_participants` mediumint(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`poll_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Daten für Tabelle `fs2_poll`
--

INSERT INTO `fs2_poll` (`poll_id`, `poll_quest`, `poll_start`, `poll_end`, `poll_type`, `poll_participants`) VALUES
(1, 'wurst', 1306414980, 1309093380, 1, 0),
(2, 'ok', 1306414980, 1306416540, 0, 0),
(3, 'test2', 1306416480, 1309094880, 1, 1),
(4, 'Test1', 1316985420, 1319577420, 0, 1),
(5, 'Test2', 1316985420, 1319577420, 0, 1),
(6, 'Test3', 1316990760, 1319582760, 1, 1),
(7, 'Test4', 1316990760, 1319582760, 0, 1),
(8, 'Wurst \\''oder\\" Käse?', 1340789940, 1354012740, 0, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_poll_answers`
--

DROP TABLE IF EXISTS `fs2_poll_answers`;
CREATE TABLE `fs2_poll_answers` (
  `poll_id` mediumint(8) DEFAULT NULL,
  `answer_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `answer` varchar(255) DEFAULT NULL,
  `answer_count` mediumint(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`answer_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Daten für Tabelle `fs2_poll_answers`
--

INSERT INTO `fs2_poll_answers` (`poll_id`, `answer_id`, `answer`, `answer_count`) VALUES
(1, 1, 'test', 0),
(1, 2, 'test', 0),
(1, 3, 'test', 0),
(1, 4, 'test', 0),
(3, 5, '1', 1),
(3, 6, '1', 1),
(2, 7, 'd', 0),
(2, 8, 'd', 0),
(4, 9, 'A', 1),
(4, 10, 'B', 0),
(3, 11, 'A', 0),
(3, 12, 'B', 0),
(5, 13, 'A', 0),
(5, 14, 'B', 1),
(6, 15, 'A', 0),
(6, 16, 'B', 0),
(6, 17, 'C', 1),
(6, 18, 'D', 0),
(6, 19, '', 0),
(6, 20, '', 0),
(7, 21, 'asd', 1),
(7, 22, 'asd', 0),
(8, 23, 'Wurst', 1),
(8, 24, 'Käse', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_poll_voters`
--

DROP TABLE IF EXISTS `fs2_poll_voters`;
CREATE TABLE `fs2_poll_voters` (
  `voter_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `poll_id` mediumint(8) NOT NULL DEFAULT '0',
  `ip_address` varchar(15) NOT NULL DEFAULT '0.0.0.0',
  `time` int(32) NOT NULL DEFAULT '0',
  PRIMARY KEY (`voter_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Daten für Tabelle `fs2_poll_voters`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_press`
--

DROP TABLE IF EXISTS `fs2_press`;
CREATE TABLE `fs2_press` (
  `press_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `press_title` varchar(255) NOT NULL,
  `press_url` varchar(255) NOT NULL,
  `press_date` int(12) NOT NULL,
  `press_intro` text NOT NULL,
  `press_text` text NOT NULL,
  `press_note` text NOT NULL,
  `press_lang` int(11) NOT NULL,
  `press_game` tinyint(2) NOT NULL,
  `press_cat` tinyint(2) NOT NULL,
  PRIMARY KEY (`press_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Daten für Tabelle `fs2_press`
--

INSERT INTO `fs2_press` (`press_id`, `press_title`, `press_url`, `press_date`, `press_intro`, `press_text`, `press_note`, `press_lang`, `press_game`, `press_cat`) VALUES
(1, 'nix', 'http://ASDASD', 1306368000, '', 'ASD', '', 2, 4, 6),
(3, 'TEST', '3', 1306368000, '', 'ASD', '', 2, 4, 6);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_press_admin`
--

DROP TABLE IF EXISTS `fs2_press_admin`;
CREATE TABLE `fs2_press_admin` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`,`type`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Daten für Tabelle `fs2_press_admin`
--

INSERT INTO `fs2_press_admin` (`id`, `type`, `title`) VALUES
(1, 3, 'Test'),
(2, 3, 'Englisch'),
(3, 2, 'Preview'),
(4, 1, 'Beispiel-Spiel'),
(5, 2, 'Review'),
(6, 2, 'Interview');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_screen`
--

DROP TABLE IF EXISTS `fs2_screen`;
CREATE TABLE `fs2_screen` (
  `screen_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `cat_id` smallint(6) unsigned DEFAULT NULL,
  `screen_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`screen_id`),
  KEY `cat_id` (`cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Daten für Tabelle `fs2_screen`
--

INSERT INTO `fs2_screen` (`screen_id`, `cat_id`, `screen_name`) VALUES
(11, 1, ''),
(12, 1, ''),
(13, 1, ''),
(14, 1, ''),
(15, 1, ''),
(16, 1, ''),
(17, 1, ''),
(18, 1, ''),
(19, 1, ''),
(20, 1, ''),
(21, 1, ''),
(22, 1, ''),
(23, 1, '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_screen_cat`
--

DROP TABLE IF EXISTS `fs2_screen_cat`;
CREATE TABLE `fs2_screen_cat` (
  `cat_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(255) DEFAULT NULL,
  `cat_type` tinyint(1) NOT NULL DEFAULT '0',
  `cat_visibility` tinyint(1) NOT NULL DEFAULT '1',
  `cat_date` int(11) NOT NULL DEFAULT '0',
  `randompic` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `fs2_screen_cat`
--

INSERT INTO `fs2_screen_cat` (`cat_id`, `cat_name`, `cat_type`, `cat_visibility`, `cat_date`, `randompic`) VALUES
(1, 'Screenshots', 1, 1, 1302517148, 1),
(2, 'Wallpaper', 2, 1, 1302517148, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_screen_random`
--

DROP TABLE IF EXISTS `fs2_screen_random`;
CREATE TABLE `fs2_screen_random` (
  `random_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `screen_id` mediumint(8) NOT NULL,
  `start` int(11) NOT NULL,
  `end` int(11) NOT NULL,
  PRIMARY KEY (`random_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `fs2_screen_random`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_search_index`
--

DROP TABLE IF EXISTS `fs2_search_index`;
CREATE TABLE `fs2_search_index` (
  `search_index_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `search_index_word_id` mediumint(8) NOT NULL DEFAULT '0',
  `search_index_type` enum('news','articles','dl') NOT NULL DEFAULT 'news',
  `search_index_document_id` mediumint(8) NOT NULL DEFAULT '0',
  `search_index_count` smallint(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`search_index_id`),
  UNIQUE KEY `un_search_index_word_id` (`search_index_word_id`,`search_index_type`,`search_index_document_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1851 ;

--
-- Daten für Tabelle `fs2_search_index`
--

INSERT INTO `fs2_search_index` (`search_index_id`, `search_index_word_id`, `search_index_type`, `search_index_document_id`, `search_index_count`) VALUES
(1734, 169, 'news', 42, 1),
(1733, 164, 'news', 39, 2),
(1732, 163, 'news', 39, 4),
(1731, 108, 'news', 39, 6),
(1730, 105, 'news', 39, 1),
(1729, 33, 'news', 39, 15),
(1728, 155, 'news', 38, 1),
(1727, 154, 'news', 38, 1),
(1726, 153, 'news', 38, 1),
(1725, 152, 'news', 38, 1),
(1724, 151, 'news', 38, 1),
(1723, 150, 'news', 38, 1),
(1722, 148, 'news', 38, 1),
(1721, 33, 'news', 38, 1),
(1720, 149, 'news', 37, 3),
(1719, 148, 'news', 37, 3),
(1718, 147, 'news', 37, 4),
(1717, 44, 'news', 37, 3),
(1716, 33, 'news', 37, 1),
(1826, 181, 'articles', 1, 3),
(1825, 180, 'articles', 1, 3),
(1824, 179, 'articles', 1, 3),
(1823, 178, 'articles', 1, 3),
(1822, 177, 'articles', 1, 3),
(1821, 176, 'articles', 1, 1),
(1820, 175, 'articles', 1, 1),
(1819, 174, 'articles', 1, 1),
(1818, 173, 'articles', 1, 3),
(1817, 172, 'articles', 1, 2),
(1816, 154, 'articles', 1, 3),
(1815, 131, 'articles', 1, 2),
(1814, 130, 'articles', 1, 2),
(1813, 129, 'articles', 1, 2),
(1812, 128, 'articles', 1, 2),
(1811, 127, 'articles', 1, 2),
(1810, 125, 'articles', 1, 3),
(1809, 123, 'articles', 1, 2),
(1808, 122, 'articles', 1, 2),
(1807, 121, 'articles', 1, 2),
(1806, 119, 'articles', 1, 4),
(1805, 115, 'articles', 1, 8),
(1804, 113, 'articles', 1, 4),
(1803, 112, 'articles', 1, 1),
(1802, 111, 'articles', 1, 1),
(1801, 110, 'articles', 1, 1),
(1800, 109, 'articles', 1, 1),
(1799, 108, 'articles', 1, 1),
(1798, 106, 'articles', 1, 1),
(1797, 104, 'articles', 1, 4),
(1796, 103, 'articles', 1, 2),
(1795, 102, 'articles', 1, 2),
(1849, 144, 'dl', 11, 1),
(1848, 143, 'dl', 11, 1),
(1847, 142, 'dl', 11, 1),
(1846, 141, 'dl', 11, 1),
(1794, 101, 'articles', 1, 1),
(1715, 146, 'news', 36, 1),
(1714, 145, 'news', 36, 1),
(1713, 8, 'news', 36, 2),
(1712, 37, 'news', 7, 1),
(1845, 140, 'dl', 10, 1),
(1844, 139, 'dl', 10, 1),
(1843, 138, 'dl', 10, 1),
(1842, 137, 'dl', 10, 1),
(1841, 136, 'dl', 10, 1),
(1840, 135, 'dl', 9, 1),
(1839, 2, 'dl', 9, 1),
(1838, 1, 'dl', 9, 1),
(1837, 134, 'dl', 1, 1),
(1836, 34, 'dl', 1, 1),
(1835, 33, 'dl', 1, 1),
(1834, 40, 'dl', 7, 1),
(1833, 133, 'dl', 6, 1),
(1832, 40, 'dl', 6, 1),
(1831, 41, 'dl', 5, 1),
(1830, 40, 'dl', 5, 1),
(1829, 34, 'dl', 4, 1),
(1828, 34, 'dl', 3, 1),
(1827, 34, 'dl', 2, 1),
(1793, 100, 'articles', 1, 1),
(1792, 99, 'articles', 1, 1),
(1791, 98, 'articles', 1, 3),
(1790, 96, 'articles', 1, 3),
(1711, 36, 'news', 7, 1),
(1789, 95, 'articles', 1, 16),
(1788, 93, 'articles', 1, 1),
(1787, 92, 'articles', 1, 1),
(1786, 91, 'articles', 1, 1),
(1785, 89, 'articles', 1, 1),
(1784, 88, 'articles', 1, 1),
(1783, 86, 'articles', 1, 2),
(1782, 84, 'articles', 1, 2),
(1781, 83, 'articles', 1, 2),
(1780, 82, 'articles', 1, 2),
(1779, 81, 'articles', 1, 3),
(1778, 80, 'articles', 1, 1),
(1777, 79, 'articles', 1, 1),
(1776, 78, 'articles', 1, 1),
(1775, 77, 'articles', 1, 1),
(1774, 76, 'articles', 1, 1),
(1773, 75, 'articles', 1, 2),
(1772, 74, 'articles', 1, 1),
(1771, 73, 'articles', 1, 1),
(1770, 72, 'articles', 1, 1),
(1769, 71, 'articles', 1, 1),
(1768, 70, 'articles', 1, 35),
(1767, 69, 'articles', 1, 1),
(1766, 68, 'articles', 1, 1),
(1765, 67, 'articles', 1, 1),
(1764, 66, 'articles', 1, 1),
(1763, 65, 'articles', 1, 1),
(1710, 35, 'news', 7, 2),
(1709, 33, 'news', 7, 1),
(1708, 171, 'news', 43, 1),
(1707, 170, 'news', 43, 1),
(1706, 169, 'news', 41, 1),
(1705, 162, 'news', 40, 1),
(1762, 64, 'articles', 1, 1),
(1761, 63, 'articles', 1, 1),
(1760, 62, 'articles', 1, 1),
(1759, 61, 'articles', 1, 1),
(1758, 60, 'articles', 1, 1),
(1757, 59, 'articles', 1, 2),
(1756, 58, 'articles', 1, 1),
(1755, 57, 'articles', 1, 2),
(1754, 56, 'articles', 1, 1),
(1753, 55, 'articles', 1, 2),
(1752, 54, 'articles', 1, 2),
(1751, 53, 'articles', 1, 1),
(1750, 52, 'articles', 1, 1),
(1749, 51, 'articles', 1, 1),
(1748, 50, 'articles', 1, 2),
(1747, 49, 'articles', 1, 1),
(1746, 48, 'articles', 1, 2),
(1745, 47, 'articles', 1, 2),
(1744, 46, 'articles', 1, 1),
(1743, 45, 'articles', 1, 1),
(1742, 44, 'articles', 1, 1),
(1741, 43, 'articles', 1, 1),
(1740, 42, 'articles', 1, 2),
(1704, 161, 'news', 40, 1),
(1703, 160, 'news', 40, 1),
(1702, 159, 'news', 40, 1),
(1701, 158, 'news', 40, 1),
(1739, 26, 'articles', 1, 2),
(1738, 41, 'articles', 4, 1),
(1737, 40, 'articles', 3, 1),
(1736, 39, 'articles', 3, 1),
(1700, 157, 'news', 40, 1),
(1699, 156, 'news', 40, 1),
(1698, 108, 'news', 40, 1),
(1697, 8, 'news', 35, 2),
(1696, 33, 'news', 34, 1),
(1695, 32, 'news', 34, 1),
(1694, 31, 'news', 34, 1),
(1693, 30, 'news', 34, 1),
(1692, 29, 'news', 34, 1),
(1691, 28, 'news', 34, 1),
(1690, 27, 'news', 34, 1),
(1689, 26, 'news', 34, 1),
(1688, 25, 'news', 34, 1),
(1687, 24, 'news', 34, 1),
(1686, 23, 'news', 34, 1),
(1685, 22, 'news', 34, 1),
(1684, 21, 'news', 34, 1),
(1683, 20, 'news', 34, 1),
(1682, 19, 'news', 34, 1),
(1681, 18, 'news', 34, 1),
(1680, 17, 'news', 34, 1),
(1679, 16, 'news', 34, 1),
(1678, 15, 'news', 34, 1),
(1677, 14, 'news', 34, 1),
(1676, 13, 'news', 34, 1),
(1675, 12, 'news', 34, 1),
(1674, 11, 'news', 34, 1),
(1673, 10, 'news', 34, 2),
(1672, 9, 'news', 34, 1),
(1671, 8, 'news', 34, 1),
(1670, 7, 'news', 34, 1),
(1669, 6, 'news', 34, 1),
(1668, 5, 'news', 34, 1),
(1667, 4, 'news', 34, 1),
(1666, 3, 'news', 34, 1),
(1665, 2, 'news', 34, 1),
(1664, 1, 'news', 34, 5),
(1663, 36, 'news', 33, 1),
(1662, 35, 'news', 33, 1),
(1661, 33, 'news', 33, 1),
(1660, 12, 'news', 33, 1),
(1659, 36, 'news', 32, 1),
(1658, 35, 'news', 32, 1),
(1657, 33, 'news', 32, 1),
(1656, 12, 'news', 32, 1),
(1655, 34, 'news', 5, 2),
(1735, 33, 'articles', 2, 2),
(1654, 33, 'news', 5, 2),
(1653, 32, 'news', 1, 1),
(1652, 31, 'news', 1, 1),
(1651, 30, 'news', 1, 1),
(1650, 29, 'news', 1, 1),
(1649, 28, 'news', 1, 1),
(1648, 27, 'news', 1, 1),
(1647, 26, 'news', 1, 1),
(1646, 25, 'news', 1, 1),
(1645, 24, 'news', 1, 1),
(1644, 23, 'news', 1, 1),
(1643, 22, 'news', 1, 1),
(1642, 21, 'news', 1, 1),
(1641, 20, 'news', 1, 1),
(1640, 19, 'news', 1, 1),
(1639, 18, 'news', 1, 1),
(1638, 17, 'news', 1, 1),
(1637, 16, 'news', 1, 1),
(1636, 15, 'news', 1, 1),
(1635, 14, 'news', 1, 1),
(1634, 13, 'news', 1, 1),
(1633, 12, 'news', 1, 1),
(1632, 11, 'news', 1, 1),
(1631, 10, 'news', 1, 2),
(1630, 9, 'news', 1, 1),
(1629, 8, 'news', 1, 1),
(1628, 7, 'news', 1, 1),
(1627, 6, 'news', 1, 1),
(1626, 5, 'news', 1, 1),
(1625, 4, 'news', 1, 1),
(1624, 3, 'news', 1, 1),
(1623, 2, 'news', 1, 1),
(1622, 1, 'news', 1, 5),
(1850, 33, 'news', 44, 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_search_time`
--

DROP TABLE IF EXISTS `fs2_search_time`;
CREATE TABLE `fs2_search_time` (
  `search_time_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `search_time_type` enum('news','articles','dl') NOT NULL DEFAULT 'news',
  `search_time_document_id` mediumint(8) NOT NULL,
  `search_time_date` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`search_time_id`),
  UNIQUE KEY `un_search_time_type` (`search_time_type`,`search_time_document_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=196 ;

--
-- Daten für Tabelle `fs2_search_time`
--

INSERT INTO `fs2_search_time` (`search_time_id`, `search_time_type`, `search_time_document_id`, `search_time_date`) VALUES
(194, 'dl', 11, 1340294806),
(182, 'articles', 3, 1340294806),
(183, 'articles', 4, 1340294806),
(184, 'articles', 1, 1340294806),
(193, 'dl', 10, 1340294806),
(192, 'dl', 9, 1340294806),
(191, 'dl', 1, 1340294806),
(190, 'dl', 7, 1340294806),
(189, 'dl', 6, 1340294806),
(188, 'dl', 5, 1340294806),
(181, 'articles', 2, 1340294806),
(187, 'dl', 4, 1340294806),
(186, 'dl', 3, 1340294806),
(185, 'dl', 2, 1340294806),
(177, 'news', 37, 1340294806),
(176, 'news', 36, 1340294806),
(175, 'news', 7, 1340294806),
(174, 'news', 43, 1340294806),
(173, 'news', 41, 1340294806),
(172, 'news', 40, 1340294806),
(171, 'news', 35, 1340294806),
(170, 'news', 34, 1340294806),
(169, 'news', 33, 1340294806),
(168, 'news', 32, 1340294806),
(167, 'news', 5, 1340294806),
(166, 'news', 1, 1340294806),
(178, 'news', 38, 1340294806),
(179, 'news', 39, 1340294806),
(180, 'news', 42, 1340294806),
(195, 'news', 44, 1340787648);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_search_words`
--

DROP TABLE IF EXISTS `fs2_search_words`;
CREATE TABLE `fs2_search_words` (
  `search_word_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `search_word` varchar(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`search_word_id`),
  UNIQUE KEY `search_word` (`search_word`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=182 ;

--
-- Daten für Tabelle `fs2_search_words`
--

INSERT INTO `fs2_search_words` (`search_word_id`, `search_word`) VALUES
(1, 'frogsystem'),
(2, 'alix'),
(3, 'installation'),
(4, 'erfolgreich'),
(5, 'herzlich'),
(6, 'willkommen'),
(7, 'deinem'),
(8, 'frisch'),
(9, 'installierten'),
(10, 'team'),
(11, 'wuenscht'),
(12, 'spass'),
(13, 'erfolg'),
(14, 'seite'),
(15, 'informationen'),
(16, 'hilfe'),
(17, 'problemen'),
(18, 'offiziellen'),
(19, 'homepage'),
(20, 'zugehoerigen'),
(21, 'supportforen'),
(22, 'neuen'),
(23, 'dokumentations'),
(24, 'wiki'),
(25, 'wichtigsten'),
(26, 'links'),
(27, 'unten'),
(28, 'zusammengefasst'),
(29, 'einfach'),
(30, 'mal'),
(31, 'schauen'),
(32, 'dein'),
(33, 'test'),
(34, 'update'),
(35, 'safari'),
(36, 'uuepdate'),
(37, 'testvuuepdate'),
(38, 'timtimmy'),
(39, 'fsdfsdf'),
(40, 'sdf'),
(41, 'sdfsdf'),
(42, 'fscode'),
(43, 'liste'),
(44, 'system'),
(45, 'webseite'),
(46, 'bietet'),
(47, 'dir'),
(48, 'moeglichkeit'),
(49, 'einfache'),
(50, 'codes'),
(51, 'besseren'),
(52, 'darstellung'),
(53, 'deiner'),
(54, 'beitraege'),
(55, 'verwenden'),
(56, 'sogenannten'),
(57, 'fscodes'),
(58, 'erlauben'),
(59, 'html'),
(60, 'formatierungen'),
(61, 'dich'),
(62, 'auskennen'),
(63, 'musst'),
(64, 'hast'),
(65, 'verschiedene'),
(66, 'elemente'),
(67, 'deine'),
(68, 'einzubauen'),
(69, 'bzw'),
(70, 'text'),
(71, 'formatieren'),
(72, 'findest'),
(73, 'uebersicht'),
(74, 'verfuegbaren'),
(75, 'verwendung'),
(76, 'allerdings'),
(77, 'moeglich'),
(78, 'freigeschaltet'),
(79, 'code'),
(80, 'beispiel'),
(81, 'fetter'),
(82, 'kursiver'),
(83, 'unterstrichener'),
(84, 'durchgestrichener'),
(85, 'center'),
(86, 'zentrierter'),
(87, 'font'),
(88, 'schriftart'),
(89, 'arial'),
(90, 'color'),
(91, 'farbcode'),
(92, 'farbe'),
(93, 'rot'),
(94, 'size'),
(95, 'groesse'),
(96, 'nbsp'),
(97, 'noparse'),
(98, 'url'),
(99, 'linkadresse'),
(100, 'http'),
(101, 'www'),
(102, 'example'),
(103, 'com'),
(104, 'linktext'),
(105, 'home'),
(106, 'seitenlink'),
(107, 'localhost'),
(108, 'news'),
(109, 'email'),
(110, 'adresse'),
(111, 'max'),
(112, 'mustermann'),
(113, 'beispieltext'),
(114, 'list'),
(115, 'listenelement'),
(116, 'listenelementlistenelement'),
(117, 'numlist'),
(118, 'quote'),
(119, 'zitat'),
(120, 'quelle'),
(121, 'schrift'),
(122, 'fester'),
(123, 'breite'),
(124, 'img'),
(125, 'bildadresse'),
(126, 'right'),
(127, 'grafik'),
(128, 'rechts'),
(129, 'platziert'),
(130, 'fliesst'),
(131, 'herum'),
(132, 'left'),
(133, 'wsd'),
(134, 'testsdfsdfsdf'),
(135, 'asda'),
(136, 'hansens'),
(137, 'wunderbare'),
(138, 'weasddes'),
(139, 'wissensasd'),
(140, 'asdasd'),
(141, 'download'),
(142, 'libapr'),
(143, 'src'),
(144, 'rpm'),
(145, 'tim'),
(146, 'timmy'),
(147, 'poll'),
(148, 'app'),
(149, 'php'),
(150, 'dieseappgibtesnicht'),
(151, 'snippetnot'),
(152, 'nav'),
(153, 'navnot'),
(154, 'var'),
(155, 'varnot'),
(156, 'ueberarbeitete'),
(157, 'umfrage'),
(158, 'besten'),
(159, 'entwicklerstudio'),
(160, 'aller'),
(161, 'zeiten'),
(162, 'bkah'),
(163, 'comments'),
(164, 'amp'),
(165, 'foo'),
(166, 'bar'),
(167, 'hans'),
(168, 'wurst'),
(169, ''),
(170, 'tsdsdfsd'),
(171, 'fsdfsdfsdfsdfsdf'),
(172, 'table'),
(173, 'width'),
(174, 'cellpadding'),
(175, 'cellspacing'),
(176, 'border'),
(177, 'colspan'),
(178, 'images'),
(179, 'icons'),
(180, 'logo'),
(181, 'gif');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_shop`
--

DROP TABLE IF EXISTS `fs2_shop`;
CREATE TABLE `fs2_shop` (
  `artikel_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `artikel_name` varchar(100) DEFAULT NULL,
  `artikel_url` varchar(255) DEFAULT NULL,
  `artikel_text` text,
  `artikel_preis` varchar(10) DEFAULT NULL,
  `artikel_hot` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`artikel_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `fs2_shop`
--

INSERT INTO `fs2_shop` (`artikel_id`, `artikel_name`, `artikel_url`, `artikel_text`, `artikel_preis`, `artikel_hot`) VALUES
(1, 'test', 'Amazon', 'Tolles Handy', 'EUR 12', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_smilies`
--

DROP TABLE IF EXISTS `fs2_smilies`;
CREATE TABLE `fs2_smilies` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `replace_string` varchar(15) NOT NULL,
  `order` mediumint(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Daten für Tabelle `fs2_smilies`
--

INSERT INTO `fs2_smilies` (`id`, `replace_string`, `order`) VALUES
(1, ':-)', 2),
(2, ':-(', 1),
(3, ';-)', 3),
(4, ':-P', 4),
(5, 'xD', 5),
(6, ':-o', 6),
(7, '^_^', 7),
(8, ':-/', 8),
(9, ':-]', 9),
(10, '&gt;-(', 10);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_snippets`
--

DROP TABLE IF EXISTS `fs2_snippets`;
CREATE TABLE `fs2_snippets` (
  `snippet_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `snippet_tag` varchar(100) NOT NULL,
  `snippet_text` text NOT NULL,
  `snippet_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`snippet_id`),
  UNIQUE KEY `snippet_tag` (`snippet_tag`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `fs2_snippets`
--

INSERT INTO `fs2_snippets` (`snippet_id`, `snippet_tag`, `snippet_text`, `snippet_active`) VALUES
(1, '[%feeds%]', '<p>\r\n  <b>News-Feeds:</b>\r\n</p>\r\n<p align=\\"center\\">\r\n  <a href=\\"$VAR(url)feeds/rss091.php\\" target=\\"_self\\"><img src=\\"$VAR(style_icons)feeds/rss091.gif\\" alt=\\"RSS 0.91\\" title=\\"RSS 0.91\\" border=\\"0\\"></a><br>\r\n  <a href=\\"$VAR(url)feeds/rss10.php\\" target=\\"_self\\"><img src=\\"$VAR(style_icons)feeds/rss10.gif\\" alt=\\"RSS 1.0\\" title=\\"RSS 1.0\\" border=\\"0\\"></a><br>\r\n  <a href=\\"$VAR(url)feeds/rss20.php\\" target=\\"_self\\"><img src=\\"$VAR(style_icons)feeds/rss20.gif\\" alt=\\"RSS 2.0\\" title=\\"RSS 2.0\\" border=\\"0\\"></a><br>\r\n  <a href=\\"$VAR(url)feeds/atom10.php\\" target=\\"_self\\"><img src=\\"$VAR(style_icons)feeds/atom10.gif\\" alt=\\"Atom 1.0\\" title=\\"Atom 1.0\\" border=\\"0\\"></a>\r\n</p>', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_styles`
--

DROP TABLE IF EXISTS `fs2_styles`;
CREATE TABLE `fs2_styles` (
  `style_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `style_tag` varchar(30) NOT NULL,
  `style_allow_use` tinyint(1) NOT NULL DEFAULT '1',
  `style_allow_edit` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`style_id`),
  UNIQUE KEY `style_tag` (`style_tag`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `fs2_styles`
--

INSERT INTO `fs2_styles` (`style_id`, `style_tag`, `style_allow_use`, `style_allow_edit`) VALUES
(1, 'lightfrog', 1, 1),
(2, 'default', 0, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_user`
--

DROP TABLE IF EXISTS `fs2_user`;
CREATE TABLE `fs2_user` (
  `user_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `user_name` char(100) DEFAULT NULL,
  `user_password` char(32) DEFAULT NULL,
  `user_salt` varchar(10) NOT NULL,
  `user_mail` char(100) DEFAULT NULL,
  `user_is_staff` tinyint(1) NOT NULL DEFAULT '0',
  `user_group` mediumint(8) NOT NULL DEFAULT '0',
  `user_is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `user_reg_date` int(11) DEFAULT NULL,
  `user_show_mail` tinyint(4) NOT NULL DEFAULT '0',
  `user_homepage` varchar(100) DEFAULT NULL,
  `user_icq` varchar(50) DEFAULT NULL,
  `user_aim` varchar(50) DEFAULT NULL,
  `user_wlm` varchar(50) DEFAULT NULL,
  `user_yim` varchar(50) DEFAULT NULL,
  `user_skype` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `fs2_user`
--

INSERT INTO `fs2_user` (`user_id`, `user_name`, `user_password`, `user_salt`, `user_mail`, `user_is_staff`, `user_group`, `user_is_admin`, `user_reg_date`, `user_show_mail`, `user_homepage`, `user_icq`, `user_aim`, `user_wlm`, `user_yim`, `user_skype`) VALUES
(1, 'admin', 'fed81761ca322b59c39599ab264e9129', '5Y5FNoZlgO', 'mail@sweil.de', 1, 0, 1, 1302517173, 0, '', '', '', '', '', ''),
(2, 'test', '7536490f62673f20cf771bca4767799b', 'EcA0ybxfP1', 'asd@hallo.de', 1, 1, 0, 1306274400, 0, '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_useronline`
--

DROP TABLE IF EXISTS `fs2_useronline`;
CREATE TABLE `fs2_useronline` (
  `ip` varchar(30) NOT NULL,
  `user_id` mediumint(8) NOT NULL DEFAULT '0',
  `date` int(30) DEFAULT NULL,
  PRIMARY KEY (`ip`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `fs2_useronline`
--

INSERT INTO `fs2_useronline` (`ip`, `user_id`, `date`) VALUES
('127.0.0.1', 1, 1341471622);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_user_groups`
--

DROP TABLE IF EXISTS `fs2_user_groups`;
CREATE TABLE `fs2_user_groups` (
  `user_group_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `user_group_name` varchar(50) NOT NULL,
  `user_group_description` text,
  `user_group_title` varchar(50) DEFAULT NULL,
  `user_group_color` varchar(6) NOT NULL DEFAULT '-1',
  `user_group_highlight` tinyint(1) NOT NULL DEFAULT '0',
  `user_group_date` int(11) NOT NULL,
  `user_group_user` mediumint(8) NOT NULL DEFAULT '1',
  PRIMARY KEY (`user_group_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `fs2_user_groups`
--

INSERT INTO `fs2_user_groups` (`user_group_id`, `user_group_name`, `user_group_description`, `user_group_title`, `user_group_color`, `user_group_highlight`, `user_group_date`, `user_group_user`) VALUES
(0, 'Administrator', '', 'Administrator', '008800', 1, 1302517148, 1),
(1, 'sdfsdf', '', '', '-1', 0, 1306281600, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_user_permissions`
--

DROP TABLE IF EXISTS `fs2_user_permissions`;
CREATE TABLE `fs2_user_permissions` (
  `perm_id` varchar(255) NOT NULL,
  `x_id` mediumint(8) NOT NULL,
  `perm_for_group` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`perm_id`,`x_id`,`perm_for_group`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `fs2_user_permissions`
--

INSERT INTO `fs2_user_permissions` (`perm_id`, `x_id`, `perm_for_group`) VALUES
('applets_add', 2, 0),
('applets_delete', 2, 0),
('applets_edit', 2, 0),
('news_add', 2, 0),
('news_comments', 2, 0),
('news_config', 2, 0),
('news_delete', 2, 0),
('news_edit', 2, 0),
('partner_add', 2, 0),
('partner_config', 2, 0),
('partner_edit', 2, 0),
('style_add', 2, 0),
('style_css', 2, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_wallpaper`
--

DROP TABLE IF EXISTS `fs2_wallpaper`;
CREATE TABLE `fs2_wallpaper` (
  `wallpaper_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `wallpaper_name` varchar(255) NOT NULL,
  `wallpaper_title` varchar(255) NOT NULL,
  `cat_id` mediumint(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`wallpaper_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 PACK_KEYS=1 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `fs2_wallpaper`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_wallpaper_sizes`
--

DROP TABLE IF EXISTS `fs2_wallpaper_sizes`;
CREATE TABLE `fs2_wallpaper_sizes` (
  `size_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `wallpaper_id` mediumint(8) NOT NULL DEFAULT '0',
  `size` varchar(255) NOT NULL,
  PRIMARY KEY (`size_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 PACK_KEYS=1 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `fs2_wallpaper_sizes`
--

