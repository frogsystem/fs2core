-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 21. Juni 2011 um 09:08
-- Server Version: 5.5.8
-- PHP-Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `test`
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
('gallery_config', 'gallery', 'admin_gallery_config.php', 1, 0),
('gallery_img_add', 'gallery', 'gallery_img', 1, 1),
('gallery_wp_add', 'gallery', 'gallery_wp', 1, 1),
('gallery_cat', 'gallery', 'admin_gallery_cat.php', 2, 0),
('gallery_img_edit', 'gallery', 'gallery_img', 2, 1),
('gallery_wp_edit', 'gallery', 'gallery_wp', 2, 1),
('gallery_folder', 'gallery', 'admin_gallery_folder.php', 3, 0),
('gallery_img', 'gallery', 'admin_gallery_img.php', 3, 0),
('gallery_wp', 'gallery', 'admin_gallery_wp.php', 4, 0),
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
('user_rights', 'users', 'admin_user_rights.php', 4, 0);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `fs2_aliases`
--


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
  `applet_output` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`applet_id`),
  UNIQUE KEY `applet_file` (`applet_file`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Daten für Tabelle `fs2_applets`
--

INSERT INTO `fs2_applets` (`applet_id`, `applet_file`, `applet_active`, `applet_output`) VALUES
(1, 'affiliates', 1, 1),
(2, 'user-menu', 1, 1),
(3, 'announcement', 1, 1),
(4, 'mini-statistics', 1, 1),
(5, 'poll-system', 1, 1),
(6, 'preview-image', 1, 1),
(7, 'shop-system', 1, 1),
(8, 'dl-forwarding', 1, 0),
(9, 'mini-search', 1, 1);

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
-- Tabellenstruktur für Tabelle `fs2_articles_config`
--

DROP TABLE IF EXISTS `fs2_articles_config`;
CREATE TABLE `fs2_articles_config` (
  `id` tinyint(1) NOT NULL,
  `html_code` tinyint(4) NOT NULL DEFAULT '1',
  `fs_code` tinyint(4) NOT NULL DEFAULT '1',
  `para_handling` tinyint(4) NOT NULL DEFAULT '1',
  `cat_pic_x` smallint(4) NOT NULL DEFAULT '0',
  `cat_pic_y` smallint(4) NOT NULL DEFAULT '0',
  `cat_pic_size` smallint(4) NOT NULL DEFAULT '0',
  `com_rights` tinyint(1) NOT NULL DEFAULT '1',
  `com_antispam` tinyint(1) NOT NULL DEFAULT '1',
  `com_sort` varchar(4) NOT NULL DEFAULT 'DESC',
  `acp_per_page` smallint(3) NOT NULL DEFAULT '15',
  `acp_view` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `fs2_articles_config`
--

INSERT INTO `fs2_articles_config` (`id`, `html_code`, `fs_code`, `para_handling`, `cat_pic_x`, `cat_pic_y`, `cat_pic_size`, `com_rights`, `com_antispam`, `com_sort`, `acp_per_page`, `acp_view`) VALUES
(1, 2, 4, 4, 150, 150, 1024, 2, 1, 'DESC', 15, 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_captcha_config`
--

DROP TABLE IF EXISTS `fs2_captcha_config`;
CREATE TABLE `fs2_captcha_config` (
  `id` tinyint(1) NOT NULL,
  `captcha_bg_color` varchar(6) NOT NULL DEFAULT 'FFFFFF',
  `captcha_bg_transparent` tinyint(1) NOT NULL DEFAULT '0',
  `captcha_text_color` varchar(6) NOT NULL DEFAULT '000000',
  `captcha_first_lower` smallint(3) NOT NULL DEFAULT '1',
  `captcha_first_upper` smallint(3) NOT NULL DEFAULT '5',
  `captcha_second_lower` smallint(3) NOT NULL DEFAULT '1',
  `captcha_second_upper` smallint(3) NOT NULL DEFAULT '5',
  `captcha_use_addition` tinyint(1) NOT NULL DEFAULT '1',
  `captcha_use_subtraction` tinyint(1) NOT NULL DEFAULT '0',
  `captcha_use_multiplication` tinyint(1) NOT NULL DEFAULT '0',
  `captcha_create_easy_arithmetics` tinyint(1) NOT NULL DEFAULT '1',
  `captcha_x` smallint(3) NOT NULL DEFAULT '80',
  `captcha_y` smallint(2) NOT NULL DEFAULT '15',
  `captcha_show_questionmark` tinyint(1) NOT NULL DEFAULT '1',
  `captcha_use_spaces` tinyint(1) NOT NULL DEFAULT '1',
  `captcha_show_multiplication_as_x` tinyint(1) NOT NULL DEFAULT '1',
  `captcha_start_text_x` smallint(3) NOT NULL DEFAULT '0',
  `captcha_start_text_y` smallint(2) NOT NULL DEFAULT '0',
  `captcha_font_size` smallint(2) NOT NULL DEFAULT '3',
  `captcha_font_file` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `fs2_captcha_config`
--

INSERT INTO `fs2_captcha_config` (`id`, `captcha_bg_color`, `captcha_bg_transparent`, `captcha_text_color`, `captcha_first_lower`, `captcha_first_upper`, `captcha_second_lower`, `captcha_second_upper`, `captcha_use_addition`, `captcha_use_subtraction`, `captcha_use_multiplication`, `captcha_create_easy_arithmetics`, `captcha_x`, `captcha_y`, `captcha_show_questionmark`, `captcha_use_spaces`, `captcha_show_multiplication_as_x`, `captcha_start_text_x`, `captcha_start_text_y`, `captcha_font_size`, `captcha_font_file`) VALUES
(1, 'FFFFFF', 1, '000000', 1, 5, 1, 5, 1, 1, 0, 1, 58, 18, 0, 1, 1, 0, 0, 3, '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_config_system`
--

DROP TABLE IF EXISTS `fs2_config_system`;
CREATE TABLE `fs2_config_system` (
  `id` smallint(2) NOT NULL,
  `var_loop` mediumint(8) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `fs2_config_system`
--

INSERT INTO `fs2_config_system` (`id`, `var_loop`) VALUES
(1, 20);

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
(1, 31, 387, 2, 4, 65519, 1);

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
('http://localhost/', 55, 1302557491, 1307980522);

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
(2011, 6, 13, 1, 10);

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
-- Tabellenstruktur für Tabelle `fs2_dl_config`
--

DROP TABLE IF EXISTS `fs2_dl_config`;
CREATE TABLE `fs2_dl_config` (
  `id` tinyint(1) NOT NULL,
  `screen_x` int(11) DEFAULT NULL,
  `screen_y` int(11) DEFAULT NULL,
  `thumb_x` int(11) DEFAULT NULL,
  `thumb_y` int(11) DEFAULT NULL,
  `quickinsert` varchar(255) NOT NULL,
  `dl_rights` tinyint(1) NOT NULL DEFAULT '1',
  `dl_show_sub_cats` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `fs2_dl_config`
--

INSERT INTO `fs2_dl_config` (`id`, `screen_x`, `screen_y`, `thumb_x`, `thumb_y`, `quickinsert`, `dl_rights`, `dl_show_sub_cats`) VALUES
(1, 1024, 768, 120, 90, 'test', 2, 0);

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
  `use_admin_mail` tinyint(1) NOT NULL DEFAULT '1',
  `email` varchar(100) NOT NULL,
  `html` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `fs2_email`
--

INSERT INTO `fs2_email` (`id`, `signup`, `change_password`, `delete_account`, `use_admin_mail`, `email`, `html`) VALUES
(1, 'Hallo  {..user_name..},\r\n\r\nDu hast dich bei $VAR(page_title) registriert. Deine Zugangsdaten sind:\r\n\r\nBenutzername: {..user_name..}\r\nPasswort: {..new_password..}\r\n\r\nFalls du deine Daten ändern möchtest, kannst du das gerne auf deiner [url=$VAR(url)?go=editprofil]Profilseite[/url] tun.\r\n\r\nDein Team von $VAR(page_title)!', 'Hallo {..user_name..},\r\n\r\nDein Passwort bei $VAR(page_title) wurde geändert. Deine neuen Zugangsdaten sind:\r\n\r\nBenutzername: {..user_name..}\r\nPasswort: {..new_password..}\r\n\r\nFalls du deine Daten ändern möchtest, kannst du das gerne auf deiner [url=$VAR(url)?go=editprofil]Profilseite[/url] tun.\r\n\r\nDein Team von $VAR(page_title)!', 'Hallo {username},\r\n\r\nSchade, dass du dich von unserer Seite abgemeldet hast. Falls du es dir doch noch anders überlegen willst, [url={virtualhost}]kannst du ja nochmal rein schauen[/url].\r\n\r\nDein Webseiten-Team!', 1, '', 1);

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
-- Tabellenstruktur für Tabelle `fs2_global_config`
--

DROP TABLE IF EXISTS `fs2_global_config`;
CREATE TABLE `fs2_global_config` (
  `id` tinyint(1) NOT NULL DEFAULT '1',
  `version` varchar(10) NOT NULL DEFAULT '0.9',
  `virtualhost` varchar(255) NOT NULL,
  `admin_mail` varchar(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `dyn_title` tinyint(1) NOT NULL,
  `dyn_title_ext` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `keywords` text NOT NULL,
  `publisher` varchar(255) NOT NULL,
  `copyright` text NOT NULL,
  `show_favicon` tinyint(1) NOT NULL DEFAULT '1',
  `style_id` mediumint(8) NOT NULL DEFAULT '0',
  `style_tag` varchar(30) NOT NULL DEFAULT 'default',
  `allow_other_designs` tinyint(1) NOT NULL DEFAULT '1',
  `date` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `datetime` varchar(255) NOT NULL,
  `timezone` varchar(255) NOT NULL DEFAULT 'default',
  `page` text NOT NULL,
  `page_next` text NOT NULL,
  `page_prev` text NOT NULL,
  `random_timed_deltime` int(12) NOT NULL DEFAULT '0',
  `feed` varchar(15) NOT NULL,
  `language_text` varchar(5) NOT NULL DEFAULT 'de_DE',
  `home` tinyint(1) NOT NULL DEFAULT '0',
  `home_text` varchar(100) NOT NULL,
  `auto_forward` int(2) NOT NULL DEFAULT '3',
  `search_index_update` tinyint(1) NOT NULL DEFAULT '1',
  `search_index_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `fs2_global_config`
--

INSERT INTO `fs2_global_config` (`id`, `version`, `virtualhost`, `admin_mail`, `title`, `dyn_title`, `dyn_title_ext`, `description`, `keywords`, `publisher`, `copyright`, `show_favicon`, `style_id`, `style_tag`, `allow_other_designs`, `date`, `time`, `datetime`, `timezone`, `page`, `page_next`, `page_prev`, `random_timed_deltime`, `feed`, `language_text`, `home`, `home_text`, `auto_forward`, `search_index_update`, `search_index_time`) VALUES
(1, '2.alix6', 'http://localhost/fs2/www/', 'mail@sweil.de', 'Hansens wunderbare Welt', 1, '{..title..} » {..ext..}', '', '', '', '', 1, 1, 'lightfrog', 1, 'd.m.Y', 'H:i \\\\U\\\\h\\\\r', 'd.m.Y, H:i \\\\U\\\\h\\\\r', 'Europe/Berlin', '<div align=\\"center\\" style=\\"width:270px;\\"><div style=\\"width:70px; float:left;\\">{..prev..}&nbsp;</div>Seite <b>{..page_number..}</b> von <b>{..total_pages..}</b><div style=\\"width:70px; float:right;\\">&nbsp;{..next..}</div></div>', '|&nbsp;<a href=\\"{..url..}\\">weiter&nbsp;»</a>', '<a href=\\"{..url..}\\">«&nbsp;zurück</a>&nbsp;|', 604800, 'rss20', 'de_DE', 0, '', 4, 2, 1307969075);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_iplist`
--

DROP TABLE IF EXISTS `fs2_iplist`;
CREATE TABLE `fs2_iplist` (
  `ip` varchar(18) NOT NULL,
  PRIMARY KEY (`ip`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `fs2_iplist`
--

INSERT INTO `fs2_iplist` (`ip`) VALUES
('127.0.0.1');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;

--
-- Daten für Tabelle `fs2_news`
--

INSERT INTO `fs2_news` (`news_id`, `cat_id`, `user_id`, `news_date`, `news_title`, `news_text`, `news_active`, `news_comments_allowed`, `news_search_update`) VALUES
(1, 1, 1, 1302517148, 'Frogsystem 2.alix5 - Installation erfolgreich', 'Herzlich Willkommen in deinem frisch installierten Frogsystem 2!\r\nDas Frogsystem 2-Team wünscht viel Spaß und Erfolg mit der Seite.\r\n\r\nWeitere Informationen und Hilfe bei Problemen gibt es auf der offiziellen Homepage des Frogsystem 2, in den zugehörigen Supportforen und dem neuen Dokumentations-Wiki. Die wichtigsten Links haben wir unten zusammengefasst. Einfach mal vorbei schauen!\r\n\r\nDein Frogsystem 2-Team', 1, 1, 0),
(5, 1, 1, 1302567540, 'ie 8 test update', 'ie 8 test update', 1, 1, 1303288547),
(7, 1, 1, 1302560460, 'safari test uüpdate', 'safari testvuüpdate', 1, 1, 1302560525);

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
-- Tabellenstruktur für Tabelle `fs2_news_config`
--

DROP TABLE IF EXISTS `fs2_news_config`;
CREATE TABLE `fs2_news_config` (
  `id` tinyint(1) NOT NULL,
  `num_news` int(11) DEFAULT NULL,
  `num_head` int(11) DEFAULT NULL,
  `html_code` tinyint(4) DEFAULT NULL,
  `fs_code` tinyint(4) DEFAULT NULL,
  `para_handling` tinyint(4) DEFAULT NULL,
  `cat_pic_x` smallint(4) NOT NULL DEFAULT '0',
  `cat_pic_y` smallint(4) NOT NULL DEFAULT '0',
  `cat_pic_size` smallint(4) NOT NULL DEFAULT '0',
  `com_rights` tinyint(1) NOT NULL DEFAULT '1',
  `com_antispam` tinyint(1) NOT NULL DEFAULT '1',
  `com_sort` varchar(4) NOT NULL DEFAULT 'DESC',
  `news_headline_lenght` smallint(3) NOT NULL DEFAULT '-1',
  `news_headline_ext` varchar(30) NOT NULL,
  `acp_per_page` smallint(3) NOT NULL DEFAULT '15',
  `acp_view` tinyint(1) NOT NULL DEFAULT '1',
  `acp_force_cat_selection` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `fs2_news_config`
--

INSERT INTO `fs2_news_config` (`id`, `num_news`, `num_head`, `html_code`, `fs_code`, `para_handling`, `cat_pic_x`, `cat_pic_y`, `cat_pic_size`, `com_rights`, `com_antispam`, `com_sort`, `news_headline_lenght`, `news_headline_ext`, `acp_per_page`, `acp_view`, `acp_force_cat_selection`) VALUES
(1, 10, 5, 2, 4, 4, 150, 150, 1024, 2, 1, 'DESC', 20, ' ...', 25, 2, 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=63 ;

--
-- Daten für Tabelle `fs2_news_links`
--

INSERT INTO `fs2_news_links` (`news_id`, `link_id`, `link_name`, `link_url`, `link_target`) VALUES
(1, 1, 'Offizielle Frogsystem 2 Homepage', 'http://www.frogsystem.de', 1),
(1, 2, 'Frogsystem 2 Supportforum', 'http://forum.sweil.de/viewforum.php?f=7', 1),
(1, 3, 'Frogsystem 2 Dokumentations-Wiki', 'http://wiki.frogsystem.de/', 1),
(5, 7, 'sdfsdfsdf', 'http://', 0),
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
(30, 57, 'Test', 'http://www.test.de', 1);

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
-- Tabellenstruktur für Tabelle `fs2_partner_config`
--

DROP TABLE IF EXISTS `fs2_partner_config`;
CREATE TABLE `fs2_partner_config` (
  `id` tinyint(1) NOT NULL DEFAULT '1',
  `partner_anzahl` tinyint(2) NOT NULL DEFAULT '0',
  `small_x` int(4) NOT NULL DEFAULT '0',
  `small_y` int(4) NOT NULL DEFAULT '0',
  `small_allow` tinyint(1) NOT NULL DEFAULT '0',
  `big_x` int(4) NOT NULL DEFAULT '0',
  `big_y` int(4) NOT NULL DEFAULT '0',
  `big_allow` tinyint(1) NOT NULL DEFAULT '0',
  `file_size` int(4) NOT NULL DEFAULT '1024',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `fs2_partner_config`
--

INSERT INTO `fs2_partner_config` (`id`, `partner_anzahl`, `small_x`, `small_y`, `small_allow`, `big_x`, `big_y`, `big_allow`, `file_size`) VALUES
(1, 5, 88, 31, 0, 468, 60, 1, 1024);

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
-- Tabellenstruktur für Tabelle `fs2_player_config`
--

DROP TABLE IF EXISTS `fs2_player_config`;
CREATE TABLE `fs2_player_config` (
  `id` tinyint(1) NOT NULL DEFAULT '1',
  `cfg_player_x` mediumint(9) NOT NULL,
  `cfg_player_y` mediumint(9) NOT NULL,
  `cfg_autoplay` tinyint(1) NOT NULL DEFAULT '1',
  `cfg_autoload` tinyint(1) NOT NULL DEFAULT '1',
  `cfg_buffer` smallint(2) NOT NULL DEFAULT '5',
  `cfg_buffermessage` varchar(100) NOT NULL DEFAULT 'Buffering _n_',
  `cfg_buffercolor` varchar(7) NOT NULL DEFAULT '#FFFFFF',
  `cfg_bufferbgcolor` varchar(7) NOT NULL DEFAULT '#000000',
  `cfg_buffershowbg` tinyint(1) NOT NULL DEFAULT '1',
  `cfg_titlesize` smallint(2) NOT NULL DEFAULT '20',
  `cfg_titlecolor` varchar(7) NOT NULL DEFAULT '#FFFFFF',
  `cfg_margin` smallint(2) NOT NULL DEFAULT '0',
  `cfg_showstop` tinyint(1) NOT NULL DEFAULT '1',
  `cfg_showvolume` tinyint(1) NOT NULL DEFAULT '1',
  `cfg_showtime` tinyint(1) NOT NULL DEFAULT '1',
  `cfg_showplayer` varchar(8) NOT NULL DEFAULT 'always',
  `cfg_showloading` varchar(8) NOT NULL DEFAULT 'always',
  `cfg_showfullscreen` tinyint(1) NOT NULL DEFAULT '1',
  `cfg_showmouse` varchar(8) NOT NULL DEFAULT 'autohide',
  `cfg_loop` tinyint(1) NOT NULL DEFAULT '0',
  `cfg_playercolor` varchar(7) NOT NULL,
  `cfg_loadingcolor` varchar(7) NOT NULL,
  `cfg_bgcolor` varchar(7) NOT NULL,
  `cfg_bgcolor1` varchar(7) NOT NULL,
  `cfg_bgcolor2` varchar(7) NOT NULL,
  `cfg_buttoncolor` varchar(7) NOT NULL,
  `cfg_buttonovercolor` varchar(7) NOT NULL,
  `cfg_slidercolor1` varchar(7) NOT NULL,
  `cfg_slidercolor2` varchar(7) NOT NULL,
  `cfg_sliderovercolor` varchar(7) NOT NULL,
  `cfg_loadonstop` tinyint(1) NOT NULL DEFAULT '0',
  `cfg_onclick` varchar(9) NOT NULL DEFAULT 'playpause',
  `cfg_ondoubleclick` varchar(10) NOT NULL DEFAULT 'fullscreen',
  `cfg_playertimeout` mediumint(6) NOT NULL DEFAULT '1500',
  `cfg_videobgcolor` varchar(7) NOT NULL,
  `cfg_volume` smallint(3) NOT NULL DEFAULT '80',
  `cfg_shortcut` tinyint(1) NOT NULL DEFAULT '0',
  `cfg_playeralpha` smallint(3) NOT NULL DEFAULT '0',
  `cfg_top1_url` varchar(100) NOT NULL,
  `cfg_top1_x` smallint(4) NOT NULL,
  `cfg_top1_y` smallint(4) NOT NULL,
  `cfg_showiconplay` tinyint(1) NOT NULL DEFAULT '1',
  `cfg_iconplaycolor` varchar(7) NOT NULL,
  `cfg_iconplaybgcolor` varchar(7) NOT NULL,
  `cfg_iconplaybgalpha` smallint(3) NOT NULL DEFAULT '100',
  `cfg_showtitleandstartimage` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `fs2_player_config`
--

INSERT INTO `fs2_player_config` (`id`, `cfg_player_x`, `cfg_player_y`, `cfg_autoplay`, `cfg_autoload`, `cfg_buffer`, `cfg_buffermessage`, `cfg_buffercolor`, `cfg_bufferbgcolor`, `cfg_buffershowbg`, `cfg_titlesize`, `cfg_titlecolor`, `cfg_margin`, `cfg_showstop`, `cfg_showvolume`, `cfg_showtime`, `cfg_showplayer`, `cfg_showloading`, `cfg_showfullscreen`, `cfg_showmouse`, `cfg_loop`, `cfg_playercolor`, `cfg_loadingcolor`, `cfg_bgcolor`, `cfg_bgcolor1`, `cfg_bgcolor2`, `cfg_buttoncolor`, `cfg_buttonovercolor`, `cfg_slidercolor1`, `cfg_slidercolor2`, `cfg_sliderovercolor`, `cfg_loadonstop`, `cfg_onclick`, `cfg_ondoubleclick`, `cfg_playertimeout`, `cfg_videobgcolor`, `cfg_volume`, `cfg_shortcut`, `cfg_playeralpha`, `cfg_top1_url`, `cfg_top1_x`, `cfg_top1_y`, `cfg_showiconplay`, `cfg_iconplaycolor`, `cfg_iconplaybgcolor`, `cfg_iconplaybgalpha`, `cfg_showtitleandstartimage`) VALUES
(1, 500, 280, 0, 1, 5, 'Buffering _n_', '#FFFFFF', '#000000', 0, 20, '#FFFFFF', 5, 1, 1, 1, 'autohide', 'always', 1, 'autohide', 0, '#a6a6a6', '#000000', '#FAFCF1', '#E7E7E7', '#cccccc', '#000000', '#E7E7E7', '#cccccc', '#bbbbbb', '#E7E7E7', 1, 'playpause', 'fullscreen', 1500, '#000000', 100, 1, 100, '', 0, 0, 1, '#FFFFFF', '#000000', 75, 0);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Daten für Tabelle `fs2_poll`
--

INSERT INTO `fs2_poll` (`poll_id`, `poll_quest`, `poll_start`, `poll_end`, `poll_type`, `poll_participants`) VALUES
(1, 'wurst', 1306414980, 1309093380, 1, 0),
(2, 'ok', 1306414980, 1306416540, 0, 0),
(3, 'test2', 1306416480, 1309094880, 1, 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

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
(2, 8, 'd', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_poll_config`
--

DROP TABLE IF EXISTS `fs2_poll_config`;
CREATE TABLE `fs2_poll_config` (
  `id` tinyint(1) NOT NULL,
  `answerbar_width` smallint(3) NOT NULL DEFAULT '100',
  `answerbar_type` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `fs2_poll_config`
--

INSERT INTO `fs2_poll_config` (`id`, `answerbar_width`, `answerbar_type`) VALUES
(1, 100, 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

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
-- Tabellenstruktur für Tabelle `fs2_press_config`
--

DROP TABLE IF EXISTS `fs2_press_config`;
CREATE TABLE `fs2_press_config` (
  `id` mediumint(8) NOT NULL DEFAULT '1',
  `game_navi` tinyint(1) NOT NULL DEFAULT '0',
  `cat_navi` tinyint(1) NOT NULL DEFAULT '0',
  `lang_navi` tinyint(1) NOT NULL DEFAULT '0',
  `show_press` tinyint(1) NOT NULL DEFAULT '1',
  `show_root` tinyint(1) NOT NULL DEFAULT '0',
  `order_by` varchar(10) NOT NULL,
  `order_type` varchar(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `fs2_press_config`
--

INSERT INTO `fs2_press_config` (`id`, `game_navi`, `cat_navi`, `lang_navi`, `show_press`, `show_root`, `order_by`, `order_type`) VALUES
(1, 1, 1, 0, 0, 0, 'press_date', 'desc');

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
-- Tabellenstruktur für Tabelle `fs2_screen_config`
--

DROP TABLE IF EXISTS `fs2_screen_config`;
CREATE TABLE `fs2_screen_config` (
  `id` tinyint(1) NOT NULL,
  `screen_x` int(4) DEFAULT NULL,
  `screen_y` int(4) DEFAULT NULL,
  `screen_thumb_x` int(4) DEFAULT NULL,
  `screen_thumb_y` int(4) DEFAULT NULL,
  `screen_size` int(4) DEFAULT NULL,
  `screen_rows` int(2) NOT NULL,
  `screen_cols` int(2) NOT NULL,
  `screen_order` varchar(10) NOT NULL,
  `screen_sort` varchar(4) NOT NULL,
  `show_type` tinyint(1) NOT NULL DEFAULT '0',
  `show_size_x` smallint(4) NOT NULL DEFAULT '0',
  `show_size_y` smallint(4) NOT NULL DEFAULT '0',
  `show_img_x` int(4) DEFAULT NULL,
  `show_img_y` int(4) DEFAULT NULL,
  `wp_x` int(4) DEFAULT NULL,
  `wp_y` int(4) DEFAULT NULL,
  `wp_thumb_x` int(4) DEFAULT NULL,
  `wp_thumb_y` int(4) DEFAULT NULL,
  `wp_order` varchar(10) NOT NULL,
  `wp_size` int(4) DEFAULT NULL,
  `wp_rows` int(2) NOT NULL,
  `wp_cols` int(2) NOT NULL,
  `wp_sort` varchar(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `fs2_screen_config`
--

INSERT INTO `fs2_screen_config` (`id`, `screen_x`, `screen_y`, `screen_thumb_x`, `screen_thumb_y`, `screen_size`, `screen_rows`, `screen_cols`, `screen_order`, `screen_sort`, `show_type`, `show_size_x`, `show_size_y`, `show_img_x`, `show_img_y`, `wp_x`, `wp_y`, `wp_thumb_x`, `wp_thumb_y`, `wp_order`, `wp_size`, `wp_rows`, `wp_cols`, `wp_sort`) VALUES
(1, 1500, 1500, 120, 90, 1024, 5, 3, 'id', 'desc', 1, 950, 700, 800, 600, 2000, 2000, 200, 150, 'id', 1536, 6, 2, 'desc');

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
-- Tabellenstruktur für Tabelle `fs2_screen_random_config`
--

DROP TABLE IF EXISTS `fs2_screen_random_config`;
CREATE TABLE `fs2_screen_random_config` (
  `id` mediumint(8) NOT NULL DEFAULT '1',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `type_priority` tinyint(1) NOT NULL DEFAULT '1',
  `use_priority_only` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `fs2_screen_random_config`
--

INSERT INTO `fs2_screen_random_config` (`id`, `active`, `type_priority`, `use_priority_only`) VALUES
(1, 1, 1, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_search_config`
--

DROP TABLE IF EXISTS `fs2_search_config`;
CREATE TABLE `fs2_search_config` (
  `id` tinyint(1) NOT NULL,
  `search_num_previews` smallint(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `fs2_search_config`
--

INSERT INTO `fs2_search_config` (`id`, `search_num_previews`) VALUES
(1, 10);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=265 ;

--
-- Daten für Tabelle `fs2_search_index`
--

INSERT INTO `fs2_search_index` (`search_index_id`, `search_index_word_id`, `search_index_type`, `search_index_document_id`, `search_index_count`) VALUES
(1, 1, 'news', 1, 5),
(2, 2, 'news', 1, 1),
(3, 3, 'news', 1, 1),
(4, 4, 'news', 1, 1),
(5, 5, 'news', 1, 1),
(6, 6, 'news', 1, 1),
(7, 7, 'news', 1, 1),
(8, 8, 'news', 1, 1),
(9, 9, 'news', 1, 1),
(10, 10, 'news', 1, 2),
(11, 11, 'news', 1, 1),
(12, 12, 'news', 1, 1),
(13, 13, 'news', 1, 1),
(14, 14, 'news', 1, 1),
(15, 15, 'news', 1, 1),
(16, 16, 'news', 1, 1),
(17, 17, 'news', 1, 1),
(18, 18, 'news', 1, 1),
(19, 19, 'news', 1, 1),
(20, 20, 'news', 1, 1),
(21, 21, 'news', 1, 1),
(22, 22, 'news', 1, 1),
(23, 23, 'news', 1, 1),
(24, 24, 'news', 1, 1),
(25, 25, 'news', 1, 1),
(26, 26, 'news', 1, 1),
(27, 27, 'news', 1, 1),
(28, 28, 'news', 1, 1),
(29, 29, 'news', 1, 1),
(30, 30, 'news', 1, 1),
(31, 31, 'news', 1, 1),
(32, 32, 'news', 1, 1),
(238, 123, 'articles', 1, 1),
(237, 122, 'articles', 1, 2),
(236, 121, 'articles', 1, 2),
(235, 120, 'articles', 1, 2),
(234, 119, 'articles', 1, 2),
(233, 118, 'articles', 1, 2),
(232, 117, 'articles', 1, 1),
(231, 116, 'articles', 1, 3),
(230, 115, 'articles', 1, 6),
(229, 114, 'articles', 1, 2),
(228, 113, 'articles', 1, 2),
(227, 112, 'articles', 1, 2),
(226, 111, 'articles', 1, 2),
(225, 110, 'articles', 1, 6),
(224, 109, 'articles', 1, 4),
(223, 108, 'articles', 1, 2),
(222, 107, 'articles', 1, 2),
(221, 106, 'articles', 1, 4),
(220, 105, 'articles', 1, 2),
(219, 104, 'articles', 1, 4),
(218, 103, 'articles', 1, 1),
(217, 102, 'articles', 1, 1),
(216, 101, 'articles', 1, 2),
(215, 100, 'articles', 1, 6),
(214, 99, 'articles', 1, 1),
(213, 98, 'articles', 1, 1),
(212, 97, 'articles', 1, 2),
(211, 96, 'articles', 1, 4),
(210, 95, 'articles', 1, 4),
(209, 94, 'articles', 1, 2),
(208, 93, 'articles', 1, 2),
(207, 92, 'articles', 1, 1),
(206, 91, 'articles', 1, 2),
(205, 90, 'articles', 1, 2),
(204, 89, 'articles', 1, 4),
(203, 88, 'articles', 1, 2),
(202, 87, 'articles', 1, 3),
(201, 86, 'articles', 1, 24),
(200, 85, 'articles', 1, 16),
(199, 84, 'articles', 1, 1),
(198, 83, 'articles', 1, 1),
(197, 82, 'articles', 1, 2),
(196, 81, 'articles', 1, 2),
(195, 80, 'articles', 1, 1),
(194, 79, 'articles', 1, 2),
(193, 78, 'articles', 1, 2),
(192, 77, 'articles', 1, 2),
(191, 76, 'articles', 1, 2),
(190, 75, 'articles', 1, 2),
(189, 74, 'articles', 1, 2),
(188, 73, 'articles', 1, 2),
(187, 72, 'articles', 1, 3),
(186, 71, 'articles', 1, 1),
(185, 70, 'articles', 1, 5),
(184, 69, 'articles', 1, 1),
(183, 68, 'articles', 1, 1),
(182, 67, 'articles', 1, 1),
(181, 66, 'articles', 1, 2),
(180, 65, 'articles', 1, 1),
(179, 64, 'articles', 1, 1),
(178, 63, 'articles', 1, 1),
(177, 62, 'articles', 1, 1),
(176, 61, 'articles', 1, 35),
(175, 60, 'articles', 1, 1),
(174, 59, 'articles', 1, 1),
(173, 58, 'articles', 1, 1),
(172, 57, 'articles', 1, 1),
(171, 56, 'articles', 1, 1),
(170, 55, 'articles', 1, 1),
(169, 54, 'articles', 1, 1),
(168, 53, 'articles', 1, 1),
(167, 52, 'articles', 1, 1),
(166, 51, 'articles', 1, 1),
(165, 50, 'articles', 1, 2),
(164, 49, 'articles', 1, 1),
(163, 48, 'articles', 1, 2),
(162, 47, 'articles', 1, 1),
(161, 46, 'articles', 1, 2),
(160, 45, 'articles', 1, 2),
(159, 44, 'articles', 1, 1),
(158, 43, 'articles', 1, 1),
(157, 42, 'articles', 1, 1),
(156, 41, 'articles', 1, 2),
(155, 40, 'articles', 1, 1),
(154, 39, 'articles', 1, 2),
(153, 38, 'articles', 1, 2),
(152, 37, 'articles', 1, 1),
(151, 36, 'articles', 1, 1),
(150, 35, 'articles', 1, 1),
(149, 34, 'articles', 1, 1),
(148, 33, 'articles', 1, 1),
(147, 26, 'articles', 1, 2),
(125, 124, 'news', 7, 2),
(126, 125, 'news', 7, 1),
(127, 126, 'news', 7, 1),
(128, 127, 'news', 7, 1),
(240, 128, 'news', 5, 2),
(239, 125, 'news', 5, 2),
(131, 125, 'articles', 2, 2),
(132, 128, 'dl', 2, 1),
(133, 128, 'dl', 3, 1),
(134, 128, 'dl', 4, 1),
(135, 129, 'dl', 5, 1),
(136, 130, 'dl', 5, 1),
(137, 130, 'dl', 6, 1),
(138, 131, 'dl', 6, 1),
(139, 130, 'dl', 7, 1),
(140, 125, 'dl', 1, 1),
(141, 128, 'dl', 1, 1),
(142, 132, 'dl', 1, 1),
(241, 1, 'dl', 9, 1),
(144, 130, 'articles', 3, 1),
(145, 134, 'articles', 3, 1),
(146, 129, 'articles', 4, 1),
(242, 2, 'dl', 9, 1),
(243, 135, 'dl', 9, 1),
(244, 136, 'dl', 10, 1),
(245, 137, 'dl', 10, 1),
(246, 138, 'dl', 10, 1),
(247, 139, 'dl', 10, 1),
(248, 140, 'dl', 10, 1),
(260, 150, 'news', 27, 1),
(259, 129, 'news', 27, 1),
(262, 150, 'news', 28, 1),
(261, 129, 'news', 28, 1),
(253, 144, 'dl', 11, 1),
(254, 145, 'dl', 11, 1),
(255, 146, 'dl', 11, 1),
(256, 147, 'dl', 11, 1),
(264, 152, 'news', 29, 1),
(263, 151, 'news', 29, 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Daten für Tabelle `fs2_search_time`
--

INSERT INTO `fs2_search_time` (`search_time_id`, `search_time_type`, `search_time_document_id`, `search_time_date`) VALUES
(1, 'news', 1, 1302517203),
(2, 'articles', 1, 1303288510),
(3, 'news', 7, 1302597454),
(4, 'news', 5, 1304937983),
(5, 'articles', 2, 1302597454),
(6, 'dl', 2, 1302688670),
(7, 'dl', 3, 1302688670),
(8, 'dl', 4, 1302688670),
(9, 'dl', 5, 1302688670),
(10, 'dl', 6, 1302688670),
(11, 'dl', 7, 1302688670),
(12, 'dl', 1, 1302688671),
(13, 'dl', 8, 1302688671),
(14, 'articles', 3, 1303288510),
(15, 'articles', 4, 1303288510),
(16, 'dl', 9, 1306662345),
(17, 'dl', 10, 1306662345),
(18, 'news', 9, 1307022293),
(19, 'news', 10, 1307022293),
(20, 'dl', 11, 1307022293),
(21, 'news', 11, 1307185130),
(22, 'news', 27, 1307884434),
(23, 'news', 28, 1307884434),
(24, 'news', 29, 1307884434);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=153 ;

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
(33, 'fscode'),
(34, 'liste'),
(35, 'system'),
(36, 'webseite'),
(37, 'bietet'),
(38, 'dir'),
(39, 'moeglichkeit'),
(40, 'einfache'),
(41, 'codes'),
(42, 'besseren'),
(43, 'darstellung'),
(44, 'deiner'),
(45, 'beitraege'),
(46, 'verwenden'),
(47, 'sogenannten'),
(48, 'fscodes'),
(49, 'erlauben'),
(50, 'html'),
(51, 'formatierungen'),
(52, 'dich'),
(53, 'auskennen'),
(54, 'musst'),
(55, 'hast'),
(56, 'verschiedene'),
(57, 'elemente'),
(58, 'deine'),
(59, 'einzubauen'),
(60, 'bzw'),
(61, 'text'),
(62, 'formatieren'),
(63, 'findest'),
(64, 'uebersicht'),
(65, 'verfuegbaren'),
(66, 'verwendung'),
(67, 'allerdings'),
(68, 'moeglich'),
(69, 'freigeschaltet'),
(70, 'code'),
(71, 'beispiel'),
(72, 'fetter'),
(73, 'kursiver'),
(74, 'unterstrichener'),
(75, 'durchgestrichener'),
(76, 'center'),
(77, 'zentrierter'),
(78, 'font'),
(79, 'schriftart'),
(80, 'arial'),
(81, 'color'),
(82, 'farbcode'),
(83, 'farbe'),
(84, 'rot'),
(85, 'size'),
(86, 'groesse'),
(87, 'nbsp'),
(88, 'noparse'),
(89, 'url'),
(90, 'linkadresse'),
(91, 'http'),
(92, 'www'),
(93, 'example'),
(94, 'com'),
(95, 'linktext'),
(96, 'home'),
(97, 'seitenlink'),
(98, 'localhost'),
(99, 'news'),
(100, 'email'),
(101, 'adresse'),
(102, 'max'),
(103, 'mustermann'),
(104, 'beispieltext'),
(105, 'list'),
(106, 'listenelement'),
(107, 'listenelementlistenelement'),
(108, 'numlist'),
(109, 'quote'),
(110, 'zitat'),
(111, 'quelle'),
(112, 'schrift'),
(113, 'fester'),
(114, 'breite'),
(115, 'img'),
(116, 'bildadresse'),
(117, 'right'),
(118, 'grafik'),
(119, 'rechts'),
(120, 'platziert'),
(121, 'fliesst'),
(122, 'herum'),
(123, 'left'),
(124, 'safari'),
(125, 'test'),
(126, 'uuepdate'),
(127, 'testvuuepdate'),
(128, 'update'),
(129, 'sdfsdf'),
(130, 'sdf'),
(131, 'wsd'),
(132, 'testsdfsdfsdf'),
(133, ''),
(134, 'fsdfsdf'),
(135, 'asda'),
(136, 'hansens'),
(137, 'wunderbare'),
(138, 'weasddes'),
(139, 'wissensasd'),
(140, 'asdasd'),
(141, 'fsdfsdfds'),
(142, 'sdfsdfsd'),
(143, 'video'),
(144, 'download'),
(145, 'libapr'),
(146, 'src'),
(147, 'rpm'),
(148, 'sdfsdfsdf'),
(149, 'sdsdf'),
(150, 'fsdfsd'),
(151, 'hans'),
(152, 'wurst');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `fs2_styles`
--

INSERT INTO `fs2_styles` (`style_id`, `style_tag`, `style_allow_use`, `style_allow_edit`) VALUES
(1, 'lightfrog', 1, 1),
(0, 'default', 0, 0);

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
(2, 'test', '387b018e822b1936bbc114a2b9347396', 'XMg4s6acP6', 'asd@hallo.de', 1, 0, 0, 1306281600, 0, '', '', '', '', '', '');

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
('127.0.0.1', 1, 1307982128);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_user_config`
--

DROP TABLE IF EXISTS `fs2_user_config`;
CREATE TABLE `fs2_user_config` (
  `id` tinyint(1) NOT NULL,
  `user_per_page` tinyint(3) NOT NULL,
  `registration_antispam` tinyint(1) NOT NULL DEFAULT '0',
  `avatar_x` smallint(3) NOT NULL DEFAULT '110',
  `avatar_y` smallint(3) NOT NULL DEFAULT '110',
  `avatar_size` smallint(4) NOT NULL DEFAULT '1024',
  `group_pic_x` smallint(3) NOT NULL DEFAULT '250',
  `group_pic_y` smallint(3) NOT NULL DEFAULT '25',
  `group_pic_size` smallint(4) NOT NULL DEFAULT '1024',
  `reg_date_format` varchar(50) NOT NULL,
  `user_list_reg_date_format` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `fs2_user_config`
--

INSERT INTO `fs2_user_config` (`id`, `user_per_page`, `registration_antispam`, `avatar_x`, `avatar_y`, `avatar_size`, `group_pic_x`, `group_pic_y`, `group_pic_size`, `reg_date_format`, `user_list_reg_date_format`) VALUES
(1, 50, 1, 110, 110, 20, 250, 25, 50, 'l, j. F Y', 'j. F Y');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

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

