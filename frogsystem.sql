-- phpMyAdmin SQL Dump
-- version 3.1.3.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 17. Juni 2010 um 17:31
-- Server Version: 5.1.33
-- PHP-Version: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `frogsystem`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_admin_cp`
--

DROP TABLE IF EXISTS `fs_admin_cp`;
CREATE TABLE IF NOT EXISTS `fs_admin_cp` (
  `page_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `group_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `page_file` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `page_pos` tinyint(3) NOT NULL DEFAULT '0',
  `page_int_sub_perm` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`page_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `fs_admin_cp`
--

INSERT INTO `fs_admin_cp` (`page_id`, `group_id`, `page_file`, `page_pos`, `page_int_sub_perm`) VALUES
('start_general', '-1', 'general', 1, 0),
('start_content', '-1', 'content', 2, 0),
('start_media', '-1', 'media', 3, 0),
('start_interactive', '-1', 'interactive', 4, 0),
('start_promo', '-1', 'promo', 5, 0),
('start_user', '-1', 'user', 6, 0),
('start_styles', '-1', 'styles', 7, 0),
('start_system', '-1', 'system', 8, 0),
('start_mods', '-1', 'mods', 9, 0),
('gen_config', 'general', 'admin_general_config.php', 1, 0),
('gen_announcement', 'general', 'admin_allannouncement.php', 2, 0),
('gen_captcha', 'general', 'admin_captcha_config.php', 2, 0),
('gen_emails', 'general', 'admin_allemail.php', 4, 0),
('gen_phpinfo', 'general', 'admin_allphpinfo.php', 5, 0),
('editor_config', 'fseditor', 'admin_editor_config.php', 1, 0),
('editor_design', 'fseditor', 'admin_editor_design.php', 2, 0),
('editor_smilies', 'fseditor', 'admin_editor_smilies.php', 3, 0),
('editor_fscodes', 'fseditor', 'admin_editor_fscode.php', 4, 0),
('stat_view', 'stats', 'admin_statview.php', 1, 0),
('stat_edit', 'stats', 'admin_statedit.php', 2, 0),
('stat_ref', 'stats', 'admin_statref.php', 3, 0),
('stat_space', 'stats', 'admin_statspace.php', 4, 0),
('news_config', 'news', 'admin_news_config.php', 1, 0),
('news_delete', 'news', 'news_edit', 1, 1),
('news_add', 'news', 'admin_news_add.php', 2, 0),
('news_comments', 'news', 'news_edit', 2, 1),
('news_edit', 'news', 'admin_news_edit.php', 3, 0),
('news_cat', 'news', 'admin_news_cat.php', 4, 0),
('articles_config', 'articles', 'admin_articles_config.php', 1, 0),
('articles_add', 'articles', 'admin_articles_add.php', 2, 0),
('articles_edit', 'articles', 'admin_articles_edit.php', 3, 0),
('articles_cat', 'articles', 'admin_articles_cat.php', 4, 0),
('press_config', 'press', 'admin_press_config.php', 1, 0),
('press_add', 'press', 'admin_press_add.php', 2, 0),
('press_edit', 'press', 'admin_press_edit.php', 3, 0),
('press_admin', 'press', 'admin_press_admin.php', 4, 0),
('cimg_add', 'cimg', 'admin_cimg.php', 1, 0),
('cimg_admin', 'cimg', 'admin_cimgdel.php', 2, 0),
('gallery_config', 'gallery', 'admin_screenconfig.php', 1, 0),
('gallery_cat', 'gallery', 'admin_screencat.php', 2, 0),
('gallery_newcat', 'gallery', 'admin_screennewcat.php', 3, 0),
('screens_add', 'gallery_img', 'admin_screenadd.php', 1, 0),
('screens_edit', 'gallery_img', 'admin_screenedit.php', 2, 0),
('wp_add', 'gallery_wp', 'admin_wallpaperadd.php', 1, 0),
('wp_edit', 'gallery_wp', 'admin_wallpaperedit.php', 2, 0),
('randompic_config', 'gallery_preview', 'admin_randompic_config.php', 1, 0),
('randompic_cat', 'gallery_preview', 'admin_randompic_cat.php', 2, 0),
('timedpic_add', 'gallery_timed', 'admin_randompic_time_add.php', 1, 0),
('timedpic_edit', 'gallery_timed', 'admin_randompic_time.php', 2, 0),
('dl_config', 'downloads', 'admin_dlconfig.php', 1, 0),
('dl_add', 'downloads', 'admin_dladd.php', 2, 0),
('dl_edit', 'downloads', 'admin_dledit.php', 3, 0),
('dl_cat', 'downloads', 'admin_dlcat.php', 4, 0),
('dl_newcat', 'downloads', 'admin_dlnewcat.php', 5, 0),
('player_config', 'player', 'admin_player_config.php', 1, 0),
('player_add', 'player', 'admin_player_add.php', 2, 0),
('player_edit', 'player', 'admin_player_edit.php', 3, 0),
('poll_config', 'polls', 'admin_pollconfig.php', 1, 0),
('poll_add', 'polls', 'admin_polladd.php', 2, 0),
('poll_edit', 'polls', 'admin_polledit.php', 3, 0),
('partner_config', 'affiliates', 'admin_partnerconfig.php', 1, 0),
('partner_add', 'affiliates', 'admin_partneradd.php', 2, 0),
('partner_edit', 'affiliates', 'admin_partneredit.php', 3, 0),
('shop_add', 'shop', 'admin_shopadd.php', 1, 0),
('shop_edit', 'shop', 'admin_shopedit.php', 2, 0),
('user_config', 'users', 'admin_user_config.php', 1, 0),
('user_add', 'users', 'admin_user_add.php', 2, 0),
('user_edit', 'users', 'admin_user_edit.php', 3, 0),
('user_rights', 'users', 'admin_user_rights.php', 4, 0),
('style_add', 'styles', 'admin_style_add.php', 1, 0),
('style_management', 'styles', 'admin_style_management.php', 2, 0),
('style_css', 'styles', 'admin_template_css.php', 3, 0),
('style_js', 'styles', 'admin_template_js.php', 4, 0),
('style_nav', 'styles', 'admin_template_nav.php', 5, 0),
('tpl_general', 'templates', 'admin_template_general.php', 1, 0),
('tpl_user', 'templates', 'admin_template_user.php', 2, 0),
('tpl_articles', 'templates', 'admin_template_articles.php', 3, 0),
('tpl_news', 'templates', 'admin_template_news.php', 3, 0),
('tpl_search', 'templates', 'admin_template_search.php', 3, 0),
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
('group_config', 'groups', 'admin_group_config.php', 1, 0),
('group_admin', 'groups', 'admin_group_admin.php', 2, 0),
('group_rights', 'groups', 'admin_group_rights.php', 3, 0),
('applets_add', 'applets', 'admin_applets_add.php', 1, 0),
('applets_delete', 'applets', 'applets_edit', 1, 1),
('applets_edit', 'applets', 'admin_applets_edit.php', 2, 0),
('snippets_add', 'snippets', 'admin_snippets_add.php', 1, 0),
('snippets_delete', 'snippets', 'snippets_edit', 1, 1),
('snippets_edit', 'snippets', 'admin_snippets_edit.php', 2, 0),
('aliases_add', 'aliases', 'admin_aliases_add.php', 1, 0),
('aliases_delete', 'aliases', 'aliases_edit', 1, 1),
('aliases_edit', 'aliases', 'admin_aliases_edit.php', 2, 0),
('search_config', 'search', 'admin_search_config.php', 1, 0),
('search_index', 'search', 'admin_search_index.php', 2, 0),
('fscode_add', 'fscodes', 'admin_fscode_add.php', 1, 0),
('fscode_add_php', 'fscodes', 'fscode_add', 1, 1),
('fscode_edit', 'fscodes', 'admin_fscode_edit.php', 2, 0),
('fscode_edit_php', 'fscodes', 'fscode_edit', 2, 1),
('fscode_edit_remove', 'fscodes', 'fscode_edit', 2, 1),
('fscode_settings', 'fscodes', 'admin_fscode_config', 3, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_admin_groups`
--

DROP TABLE IF EXISTS `fs_admin_groups`;
CREATE TABLE IF NOT EXISTS `fs_admin_groups` (
  `group_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `menu_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `group_pos` tinyint(3) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Daten für Tabelle `fs_admin_groups`
--

INSERT INTO `fs_admin_groups` (`group_id`, `menu_id`, `group_pos`) VALUES
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
('gallery_timed', 'media', 5),
('downloads', 'media', 6),
('player', 'media', 7),
('polls', 'interactive', 1),
('affiliates', 'promo', 1),
('shop', 'promo', 2),
('users', 'user', 1),
('styles', 'styles', 1),
('templates', 'styles', 2),
('groups', 'user', 2),
('applets', 'system', 2),
('snippets', 'system', 3),
('aliases', 'system', 1),
('search', 'general', 4),
('fscodes', 'system', 4);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_aliases`
--

DROP TABLE IF EXISTS `fs_aliases`;
CREATE TABLE IF NOT EXISTS `fs_aliases` (
  `alias_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `alias_go` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `alias_forward_to` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `alias_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`alias_id`),
  KEY `alias_go` (`alias_go`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC AUTO_INCREMENT=9 ;

--
-- Daten für Tabelle `fs_aliases`
--

INSERT INTO `fs_aliases` (`alias_id`, `alias_go`, `alias_forward_to`, `alias_active`) VALUES
(1, 'screenshots', 'gallery', 1),
(2, 'wallpaper', 'gallery', 1),
(3, 'profil', 'user', 1),
(4, 'editprofil', 'user_edit', 1),
(5, 'members', 'user_list', 1),
(6, 'partner', 'affiliates', 1),
(7, 'pollarchiv', 'polls', 1),
(8, 'newsarchiv', 'news_search', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_announcement`
--

DROP TABLE IF EXISTS `fs_announcement`;
CREATE TABLE IF NOT EXISTS `fs_announcement` (
  `id` smallint(4) NOT NULL,
  `announcement_text` text COLLATE utf8_unicode_ci,
  `show_announcement` tinyint(1) NOT NULL DEFAULT '0',
  `activate_announcement` tinyint(1) NOT NULL DEFAULT '0',
  `ann_html` tinyint(1) NOT NULL DEFAULT '1',
  `ann_fscode` tinyint(1) NOT NULL DEFAULT '1',
  `ann_para` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `fs_announcement`
--

INSERT INTO `fs_announcement` (`id`, `announcement_text`, `show_announcement`, `activate_announcement`, `ann_html`, `ann_fscode`, `ann_para`) VALUES
(1, '', 2, 0, 1, 1, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_applets`
--

DROP TABLE IF EXISTS `fs_applets`;
CREATE TABLE IF NOT EXISTS `fs_applets` (
  `applet_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `applet_file` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `applet_active` tinyint(1) NOT NULL DEFAULT '1',
  `applet_output` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`applet_id`),
  UNIQUE KEY `applet_file` (`applet_file`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC AUTO_INCREMENT=10 ;

--
-- Daten für Tabelle `fs_applets`
--

INSERT INTO `fs_applets` (`applet_id`, `applet_file`, `applet_active`, `applet_output`) VALUES
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
-- Tabellenstruktur für Tabelle `fs_articles`
--

DROP TABLE IF EXISTS `fs_articles`;
CREATE TABLE IF NOT EXISTS `fs_articles` (
  `article_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `article_url` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `article_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `article_date` int(11) DEFAULT NULL,
  `article_user` mediumint(8) DEFAULT NULL,
  `article_text` text COLLATE utf8_unicode_ci NOT NULL,
  `article_html` tinyint(1) NOT NULL DEFAULT '1',
  `article_fscode` tinyint(1) NOT NULL DEFAULT '1',
  `article_para` tinyint(1) NOT NULL DEFAULT '1',
  `article_cat_id` mediumint(8) NOT NULL,
  `article_search_update` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`article_id`),
  KEY `article_url` (`article_url`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `fs_articles`
--

INSERT INTO `fs_articles` (`article_id`, `article_url`, `article_title`, `article_date`, `article_user`, `article_text`, `article_html`, `article_fscode`, `article_para`, `article_cat_id`, `article_search_update`) VALUES
(1, 'fscode', 'FSCode Liste', 1265756400, 1, 'Das System dieser Webseite bietet dir die Möglichkeit einfache Codes zur besseren Darstellung deiner Beiträge zu verwenden. Diese sogenannten [b]FSCodes[/b] erlauben dir daher HTML-Formatierungen zu verwenden, ohne dass du dich mit HTML auskennen musst. Mit ihnen hast du die Möglichkeit verschiedene Elemente in deine Beiträge einzubauen bzw. ihren Text zu formatieren.\r\n\r\nHier findest du eine [b]Übersicht über alle verfügbaren FSCodes[/b] und ihre Verwendung. Allerdings ist es möglich, dass nicht alle Codes zur Verwendung freigeschaltet sind.\r\n\r\n<table width="100%" cellpadding="0" cellspacing="10" border="0"><tr><td width="50%">[b][u][size=3]FS-Code:[/size][/u][/b]</td><td width="50%">[b][u][size=3]Beispiel:[/size][/u][/b]</td></tr><tr><td>[noparse][b]fetter Text[/b][/noparse]</td><td>[b]fetter Text[/b]</td></tr><tr><td>[noparse][i]kursiver Text[/i][/noparse]</td><td>[i]kursiver Text[/i]</td></tr><tr><td>[noparse][u]unterstrichener Text[u][/noparse]</td><td>[u]unterstrichener Text[/u]</td></tr><tr><td>[noparse][s]durchgestrichener Text[/s][/noparse]</td><td>[s]durchgestrichener Text[/s]</td></tr><tr><td>[noparse][center]zentrierter Text[/center][/noparse]</td><td>[center]zentrierter Text[/center]</td></tr><tr><td>[noparse][font=Schriftart]Text in Schriftart[/font][/noparse]</td><td>[font=Arial]Text in Arial[/font]</td></tr><tr><td>[noparse][color=Farbcode]Text in Farbe[/color][/noparse]</td><td>[color=#FF0000]Text in Rot (Farbcode: #FF0000)[/color]</td></tr><tr><td>[noparse][size=Größe]Text in Größe 0[/size][/noparse]</td><td>[size=0]Text in Größe 0[/size]</td></tr><tr><td>[noparse][size=Größe]Text in Größe 1[/size][/noparse]</td><td>[size=1]Text in Größe 1[/size]</td></tr><tr><td>[noparse][size=Größe]Text in Größe 2[/size][/noparse]</td><td>[size=2]Text in Größe 2[/size]</td></tr><tr><td>[noparse][size=Größe]Text in Größe 3[/size][/noparse]</td><td>[size=3]Text in Größe 3[/size]</td></tr><tr><td>[noparse][size=Größe]Text in Größe 4[/size][/noparse]</td><td>[size=4]Text in Größe 4[/size]</td></tr><tr><td>[noparse][size=Größe]Text in Größe 5[/size][/noparse]</td><td>[size=5]Text in Größe 5[/size]</td></tr><tr><td>[noparse][size=Größe]Text in Größe 6[/size][/noparse]</td><td>[size=6]Text in Größe 6[/size]</td></tr><tr><td>[noparse][size=Größe]Text in Größe 7[/size][/noparse]</td><td>[size=7]Text&nbsp;in&nbsp;Größe&nbsp;7[/size]</td></tr><tr><td>[noparse][noparse]Text mit [b]FS[/b]Code[/noparse][/noparse]</td><td>[noparse]kein [b]fetter[/b] Text[/noparse]</td></tr> <tr><td colspan="2"><hr /></td></tr> <tr><td>[noparse][url]Linkadresse[/url][/noparse]</td><td>[url]http://www.example.com[/url]</td></tr> <tr><td>[noparse][url=Linkadresse]Linktext[/url][/noparse]</td><td>[url=http://www.example.com]Linktext[/url]</td></tr> <tr><td>[noparse][home]Seitenlink[/home][/noparse]</td><td>[home]news[/home]</td></tr> <tr><td>[noparse][home=Seitenlink]Linktext[/home][/noparse]</td><td>[home=news]Linktext[/home]</td></tr> <tr><td>[noparse][email]Email-Adresse[/email][/noparse]</td><td>[email]max.mustermann@example.com[/email]</td></tr> <tr><td>[noparse][email=Email-Adresse]Beispieltext[/email][/noparse]</td><td>[email=max.mustermann@example.com]Beispieltext[/email]</td></tr> <tr><td colspan="2"><hr /></td></tr> <tr><td>[noparse][list]<br>[*]Listenelement<br>[*]Listenelement<br>[/list][/noparse]</td><td>[list]<br>[*]Listenelement<br>[*]Listenelement<br>[/list]</td></tr> <tr><td>[noparse][numlist]<br>[*]Listenelement<br>[*]Listenelement<br>[/numlist][/noparse]</td><td>[numlist]<br>[*]Listenelement<br>[*]Listenelement<br>[/numlist]</td></tr> <tr><td>[noparse][quote]Ein Zitat[/quote][/noparse]</td><td>[quote]Ein Zitat[/quote]</td></tr><tr><td>[noparse][quote=Quelle]Ein Zitat[/quote][/noparse]</td><td>[quote=Quelle]Ein Zitat[/quote]</td></tr><tr><td>[noparse][code]Schrift mit fester Breite[/code][/noparse]</td><td>[code]Schrift mit fester Breite[/code]</td></tr><tr><td colspan="2"><hr /></td></tr><tr><td>[noparse][img]Bildadresse[/img][/noparse]</td><td>[img]$VAR(url)images/icons/logo.gif[/img]</td></tr><tr><td>[noparse][img=right]Bildadresse[/img][/noparse]</td><td>[img=right]$VAR(url)images/icons/logo.gif[/img] Das hier ist ein Beispieltext. Die Grafik ist rechts platziert und der Text fließt links um sie herum.</td></tr><tr><td>[noparse][img=left]Bildadresse[/img][/noparse]</td><td>[img=left]$VAR(url)images/icons/logo.gif[/img] Das hier ist ein Beispieltext. Die Grafik ist links platziert und der Text fließt rechts um sie herum.</td></tr></table>', 1, 1, 1, 1, 1265787778);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_articles_cat`
--

DROP TABLE IF EXISTS `fs_articles_cat`;
CREATE TABLE IF NOT EXISTS `fs_articles_cat` (
  `cat_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cat_description` text COLLATE utf8_unicode_ci NOT NULL,
  `cat_date` int(11) NOT NULL,
  `cat_user` mediumint(8) NOT NULL DEFAULT '1',
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `fs_articles_cat`
--

INSERT INTO `fs_articles_cat` (`cat_id`, `cat_name`, `cat_description`, `cat_date`, `cat_user`) VALUES
(1, 'Artikel', '', 1215295200, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_articles_config`
--

DROP TABLE IF EXISTS `fs_articles_config`;
CREATE TABLE IF NOT EXISTS `fs_articles_config` (
  `id` tinyint(1) NOT NULL,
  `html_code` tinyint(4) NOT NULL DEFAULT '1',
  `fs_code` tinyint(4) NOT NULL DEFAULT '1',
  `para_handling` tinyint(4) NOT NULL DEFAULT '1',
  `cat_pic_x` smallint(4) NOT NULL DEFAULT '0',
  `cat_pic_y` smallint(4) NOT NULL DEFAULT '0',
  `cat_pic_size` smallint(4) NOT NULL DEFAULT '0',
  `com_rights` tinyint(1) NOT NULL DEFAULT '1',
  `com_antispam` tinyint(1) NOT NULL DEFAULT '1',
  `com_sort` varchar(4) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'DESC',
  `acp_per_page` smallint(3) NOT NULL DEFAULT '15',
  `acp_view` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `fs_articles_config`
--

INSERT INTO `fs_articles_config` (`id`, `html_code`, `fs_code`, `para_handling`, `cat_pic_x`, `cat_pic_y`, `cat_pic_size`, `com_rights`, `com_antispam`, `com_sort`, `acp_per_page`, `acp_view`) VALUES
(1, 2, 4, 2, 150, 150, 1024, 2, 1, 'DESC', 15, 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_captcha_config`
--

DROP TABLE IF EXISTS `fs_captcha_config`;
CREATE TABLE IF NOT EXISTS `fs_captcha_config` (
  `id` tinyint(1) NOT NULL,
  `captcha_bg_color` varchar(6) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'FFFFFF',
  `captcha_bg_transparent` tinyint(1) NOT NULL DEFAULT '0',
  `captcha_text_color` varchar(6) COLLATE utf8_unicode_ci NOT NULL DEFAULT '000000',
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
  `captcha_font_file` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Daten für Tabelle `fs_captcha_config`
--

INSERT INTO `fs_captcha_config` (`id`, `captcha_bg_color`, `captcha_bg_transparent`, `captcha_text_color`, `captcha_first_lower`, `captcha_first_upper`, `captcha_second_lower`, `captcha_second_upper`, `captcha_use_addition`, `captcha_use_subtraction`, `captcha_use_multiplication`, `captcha_create_easy_arithmetics`, `captcha_x`, `captcha_y`, `captcha_show_questionmark`, `captcha_use_spaces`, `captcha_show_multiplication_as_x`, `captcha_start_text_x`, `captcha_start_text_y`, `captcha_font_size`, `captcha_font_file`) VALUES
(1, 'FFFFFF', 1, '000000', 1, 5, 1, 5, 1, 1, 0, 1, 58, 18, 0, 1, 1, 0, 0, 3, '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_counter`
--

DROP TABLE IF EXISTS `fs_counter`;
CREATE TABLE IF NOT EXISTS `fs_counter` (
  `id` tinyint(1) NOT NULL,
  `visits` int(11) unsigned NOT NULL DEFAULT '0',
  `hits` int(11) unsigned NOT NULL DEFAULT '0',
  `user` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `artikel` smallint(6) unsigned NOT NULL DEFAULT '0',
  `news` smallint(6) unsigned NOT NULL DEFAULT '0',
  `comments` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `fs_counter`
--

INSERT INTO `fs_counter` (`id`, `visits`, `hits`, `user`, `artikel`, `news`, `comments`) VALUES
(1, 82, 3824, 2, 1, 2, 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_counter_ref`
--

DROP TABLE IF EXISTS `fs_counter_ref`;
CREATE TABLE IF NOT EXISTS `fs_counter_ref` (
  `ref_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ref_count` int(11) DEFAULT NULL,
  `ref_first` int(11) DEFAULT NULL,
  `ref_last` int(11) DEFAULT NULL,
  KEY `ref_url` (`ref_url`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `fs_counter_ref`
--

INSERT INTO `fs_counter_ref` (`ref_url`, `ref_count`, `ref_first`, `ref_last`) VALUES
('http://alix.worldofgothic.com/alix5/admin/?go=gen_config', 1, 1263252925, 1263252925),
('http://localhost/fs2/', 120, 1263499887, 1274366422),
('http://alix.worldofgothic.com/beta4/admin/?go=gen_config', 2, 1267197504, 1267197505),
('http://demo.frogsystem.de/admin/?go=gen_config', 1, 1267198063, 1267198063),
('http://localhost/', 28, 1273256730, 1276781709),
('http://localhost/fs/', 2, 1273256740, 1273256922),
('http://localhost/fs/www/', 1, 1273256927, 1273256927);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_counter_stat`
--

DROP TABLE IF EXISTS `fs_counter_stat`;
CREATE TABLE IF NOT EXISTS `fs_counter_stat` (
  `s_year` int(4) NOT NULL DEFAULT '0',
  `s_month` int(2) NOT NULL DEFAULT '0',
  `s_day` int(2) NOT NULL DEFAULT '0',
  `s_visits` int(11) DEFAULT NULL,
  `s_hits` int(11) DEFAULT NULL,
  PRIMARY KEY (`s_year`,`s_month`,`s_day`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `fs_counter_stat`
--

INSERT INTO `fs_counter_stat` (`s_year`, `s_month`, `s_day`, `s_visits`, `s_hits`) VALUES
(2010, 1, 12, 3, 5),
(2010, 1, 14, 1, 5),
(2010, 1, 15, 1, 2),
(2010, 1, 16, 1, 61),
(2010, 1, 17, 2, 317),
(2010, 1, 18, 2, 23),
(2010, 1, 19, 1, 27),
(2010, 1, 21, 1, 86),
(2010, 1, 22, 3, 682),
(2010, 1, 23, 1, 914),
(2010, 1, 24, 2, 20),
(2010, 1, 25, 2, 104),
(2010, 1, 26, 1, 51),
(2010, 1, 29, 1, 4),
(2010, 2, 9, 2, 9),
(2010, 2, 10, 3, 16),
(2010, 2, 11, 3, 82),
(2010, 2, 12, 1, 178),
(2010, 2, 13, 2, 2),
(2010, 2, 14, 1, 13),
(2010, 2, 19, 1, 489),
(2010, 2, 20, 1, 436),
(2010, 2, 22, 1, 2),
(2010, 2, 24, 1, 1),
(2010, 2, 26, 1, 57),
(2010, 2, 27, 1, 1),
(2010, 3, 9, 1, 7),
(2010, 3, 17, 1, 1),
(2010, 3, 24, 1, 2),
(2010, 4, 9, 1, 7),
(2010, 4, 11, 1, 15),
(2010, 4, 21, 1, 2),
(2010, 5, 7, 2, 22),
(2010, 5, 8, 3, 86),
(2010, 5, 9, 2, 3),
(2010, 5, 10, 1, 4),
(2010, 5, 11, 2, 5),
(2010, 5, 12, 1, 5),
(2010, 5, 14, 2, 6),
(2010, 5, 16, 1, 8),
(2010, 5, 17, 1, 2),
(2010, 5, 18, 1, 2),
(2010, 5, 19, 1, 2),
(2010, 5, 20, 1, 4),
(2010, 5, 25, 3, 8),
(2010, 5, 26, 1, 2),
(2010, 5, 27, 2, 6),
(2010, 5, 28, 1, 2),
(2010, 6, 7, 1, 4),
(2010, 6, 8, 1, 4),
(2010, 6, 9, 2, 5),
(2010, 6, 10, 1, 4),
(2010, 6, 14, 2, 6),
(2010, 6, 15, 1, 4),
(2010, 6, 16, 2, 7),
(2010, 6, 17, 1, 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_dl`
--

DROP TABLE IF EXISTS `fs_dl`;
CREATE TABLE IF NOT EXISTS `fs_dl` (
  `dl_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `cat_id` mediumint(8) DEFAULT NULL,
  `user_id` mediumint(8) DEFAULT NULL,
  `dl_date` int(11) DEFAULT NULL,
  `dl_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dl_text` text COLLATE utf8_unicode_ci,
  `dl_autor` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dl_autor_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dl_open` tinyint(4) DEFAULT NULL,
  `dl_search_update` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`dl_id`),
  FULLTEXT KEY `dl_name_text` (`dl_name`,`dl_text`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `fs_dl`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_dl_cat`
--

DROP TABLE IF EXISTS `fs_dl_cat`;
CREATE TABLE IF NOT EXISTS `fs_dl_cat` (
  `cat_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `subcat_id` mediumint(8) NOT NULL DEFAULT '0',
  `cat_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `fs_dl_cat`
--

INSERT INTO `fs_dl_cat` (`cat_id`, `subcat_id`, `cat_name`) VALUES
(1, 0, 'Downloads');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_dl_config`
--

DROP TABLE IF EXISTS `fs_dl_config`;
CREATE TABLE IF NOT EXISTS `fs_dl_config` (
  `id` tinyint(1) NOT NULL,
  `screen_x` int(11) DEFAULT NULL,
  `screen_y` int(11) DEFAULT NULL,
  `thumb_x` int(11) DEFAULT NULL,
  `thumb_y` int(11) DEFAULT NULL,
  `quickinsert` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dl_rights` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `fs_dl_config`
--

INSERT INTO `fs_dl_config` (`id`, `screen_x`, `screen_y`, `thumb_x`, `thumb_y`, `quickinsert`, `dl_rights`) VALUES
(1, 1024, 768, 120, 90, 'http://example.com', 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_dl_files`
--

DROP TABLE IF EXISTS `fs_dl_files`;
CREATE TABLE IF NOT EXISTS `fs_dl_files` (
  `dl_id` mediumint(8) DEFAULT NULL,
  `file_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `file_count` mediumint(8) NOT NULL DEFAULT '0',
  `file_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_size` mediumint(8) NOT NULL DEFAULT '0',
  `file_is_mirror` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`file_id`),
  KEY `dl_id` (`dl_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `fs_dl_files`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_docs_classes`
--

DROP TABLE IF EXISTS `fs_docs_classes`;
CREATE TABLE IF NOT EXISTS `fs_docs_classes` (
  `id` tinyint(2) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `desc` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Daten für Tabelle `fs_docs_classes`
--

INSERT INTO `fs_docs_classes` (`id`, `name`, `desc`) VALUES
(1, 'fileaccess', 'Regelt den Zugriff auf Dateien'),
(2, 'template', 'Verwaltet das Templatesystem.'),
(3, 'lang', 'Verwaltet das die Sprach-Dateien.\r\nDiese Klasse wird von [home=doc&c=4]langDataInit[/home] verwendet.'),
(4, 'langDataInit', 'Initialisiert die Sprach-Dateien.');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_docs_functions`
--

DROP TABLE IF EXISTS `fs_docs_functions`;
CREATE TABLE IF NOT EXISTS `fs_docs_functions` (
  `id` tinyint(3) NOT NULL AUTO_INCREMENT,
  `class` tinyint(2) NOT NULL,
  `type` varchar(10) NOT NULL DEFAULT 'public',
  `name` varchar(50) NOT NULL,
  `desc` text NOT NULL,
  `ret` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=81 ;

--
-- Daten für Tabelle `fs_docs_functions`
--

INSERT INTO `fs_docs_functions` (`id`, `class`, `type`, `name`, `desc`, `ret`) VALUES
(1, 1, 'public', '__construct', 'Diese Funktion initialisiert die Klasse.', 'void'),
(2, 1, 'public', 'getFileData', 'Gibt den Inhalt der Datei filename als String der Länge maxlen Bytes von offset an aus.\r\n\r\nDiese Funktion ist ein Alias zu [php=file-get-contents]file_get_contents[/php].', 'string'),
(3, 1, 'public', 'getFileArray', 'Liest die Datei filename in ein Array.', 'array'),
(4, 1, 'public', 'putFileData', 'Schreibt data in die Datei filename.\r\nWenn filename nicht existiert, wird die Datei angelegt.\r\nSonst wird die alte Datei überschrieben, wenn nicht das [b]FILE_APPEND[/b]-Flag gesetzt wurde.\r\n\r\nDiese Funktion ist ein Alias zu [php=file-put-contents]file_put_contents[/php].', 'int'),
(5, 1, 'public', 'deleteFile', 'Löscht die Datei filename.', 'bool'),
(6, 1, 'public', 'createDir', 'Erzeugt ein neues Verzeichnis pathname.', 'bool'),
(7, 1, 'public', 'deleteAny', 'Löscht das Verzeichnis bzw. die Datei filename.', 'bool'),
(8, 1, 'public', 'copyAny', 'Kopiert ein vollständiges Verzeichnis oder eine Datei von source nach destination', 'bool'),
(9, 2, 'public', '__construct', 'Initialisiert die Klasse.\r\n\r\nDiese Funktion setzt den Style auf den im AdminCP gewählten Style. (Siehe dazu [home=doc&f=10]setStyle[/home])', 'void'),
(10, 2, 'public', 'setStyle', 'Setzt den Style auf style.', 'void'),
(11, 2, 'private', 'getStyle', 'Gibt den aktuellen [home=doc&v=3]Style[/home] zurück.', 'string'),
(12, 2, 'public', 'getOpener', 'Gibt den [home=doc&v=1]Opener[/home] zurück.', 'string'),
(13, 2, 'public', 'getCloser', 'Gibt den [home=doc&v=2]Closer[/home] zurück.', 'string'),
(14, 2, 'public', 'setFile', 'Ändert die [home=doc&v=4]Datei[/home], aus denen die [home=doc&v=9]Templates[/home] ausgelesen werden in file.', 'void'),
(15, 2, 'private', 'getFile', 'Gibt den mit [home=doc&f=14]setFile[/home] gesetzen [home=doc&v=4]Dateinamen[/home] zurück.', 'string'),
(16, 2, 'private', 'setSections', 'Ändert die [home=doc&v=7]Sections[/home].', 'void'),
(17, 2, 'private', 'getSectionNumber', 'Gibt die ID der [home=doc&v=7]Section[/home] section zurück.', 'string'),
(18, 2, 'private', 'setSectionsContent', 'Setzt [home=doc&v=8]sections_content[/home] auf content.', 'void'),
(19, 2, 'private', 'getSectionContent', 'Gibt das Template der ID section_number zurück.\r\n\r\nHinweis: Die ID kann mittels der [home=doc&v=7]section[/home] über [home=doc&f=17]getSectionNumber[/home] ermittelt werden.', 'string'),
(20, 2, 'public', 'clearSectionCache', 'Setzt [home=doc&v=7]sections[/home] und [home=doc&v=8]sections_content[/home] auf ihre Initialwerte zurück.', 'void'),
(21, 2, 'public', 'clearTags', 'Löscht alle mittels [home=doc&f=28]tag[/home] definierten Templatevariablen.', 'void'),
(22, 2, 'public', 'deleteTag', 'Löscht den Tag tag aus [home=doc&v=6]tags[/home].', 'void'),
(23, 2, 'public', 'setClearUnassigned', 'Setzt [home=doc&v=5]clear_unassigned[/home] auf bool.\r\n\r\n[b]Hinweis:[/b] Diese Funktion hat momentan noch keine Auswirkungen auf die Templates.', 'void'),
(24, 2, 'private', 'setTemplate', 'Setzt [home=doc&v=9]template[/home] auf template.', 'void'),
(25, 2, 'private', 'getTemplate', 'Gibt [home=doc&v=9]template[/home] zurück.', 'string'),
(26, 2, 'public', 'load', 'Lädt das Template section in [home=doc&v=9]template[/home].', 'void'),
(27, 2, 'public', 'display', 'Gibt [home=doc&v=9]template[/home] zurück, nach dem alle [home=doc&v=6]Tags[/home] durch ihren Ersetzungstext ersetzt wurden.', 'string'),
(28, 2, 'public', 'tag', 'Definiert einen [home=doc&v=6]Tag[/home] namens tag mit dem Wert value.', 'void'),
(29, 2, 'public', '__destruct', 'Löscht alle Tags und setzt [home=doc&v=7]sections[/home] und [home=doc&v=8]sections_content[/home] auf ihre Initialwerte zurück.', 'void'),
(30, 0, 'public', 'kill_replacements', 'Ersetzt alle FS-Systemzeichenketten in TEXT.\r\nZu den FS-Systemzeichenketten gehörten:\r\n[b]{..[/b], [b]..}[/b], [b]&#x5B;%[/b], [b]%&#x5D;[/b], [b]$NAV([/b], [b]$APP([/b] und [b]$VAR[/b].\r\n\r\nIst KILLHTML auf TRUE gesetzt, wird anschließend die Funktion [php=htmlspecialchars]htmlspecialchars[/php] auf TEXT angewendet.\r\nIst STRIPSLASHES auf TRUE gesetzt, wird anschließend die Funktion [php=stripslashes]stripslashes[/php] auf TEXT angewendet.', 'string'),
(31, 0, 'public', 'get_page_nav', 'Gibt das Seitennavigationstemplate zurück.\r\nDas Seitennavigationstemplate kann unter AdminCP » Allgemein » Allgemein » Konfiguration » Seitennavigation bearbeitet werden.', 'string'),
(32, 0, 'public', 'is_language_text', 'Prüft, ob TEXT ein gültiges Sprachkürzel ist.\r\nEin gültiges Sprachkürzel wäre z.B. "de_DE".', 'bool'),
(33, 0, 'public', 'hex2dec_color', 'Wandelt COLOR in eine Farbe des Dezimalsystems um.\r\nDie Farbe wird als Array von r (Rotanteil), g (Grünanteil) und b (Blauanteil) zurückgegeben.\r\nIst COLOR keine gültige Hexadezimalfarbe, wird false zurückgegeben.', 'Array'),
(34, 0, 'public', 'is_hexcolor', 'Prüft, ob COLOR eine Gültige Hexadezimalfarbe ist.', 'bool'),
(35, 0, 'public', 'scandir_filter', 'Führt die Funktion [php=scandir]scandir[/php] auf das Verzeichnis FOLDER aus, wobei alle in EXTRA und in BAD enthaltende Elemente nicht zurückgegeben werden', 'array'),
(36, 0, 'public', 'scandir_ext', 'Gibt ein Array mit den Namen der Dateien im Verzeichnis FOLDER zurück, deren Dateiendung FILE_EXT ist.\r\nDie Dateien in EXTRA und BAD werden nicht mit angezeigt.\r\nWenn FOLDER kein Verzeichnis ist, wird false zurückgegeben.', 'array'),
(37, 0, 'public', 'get_user_rank', 'Gibt in Array aus Informationen über der Gruppe GROUP_ID zurück.', 'array'),
(38, 0, 'public', 'date_loc', 'Diese Funktion ist in Prinzip ein Alias zu [php=date]date[/php].\r\nDer Unterschied besteht darin, dass die englischen Wochentags- und Monatsnamen in die jeweils gewählte Sprache übersetzt werden und, dass TIMESTAMP nicht optional ist.', 'string'),
(39, 0, 'public', 'get_sub_cats', 'Gibt ein Array aus den Downloadkategorien zurück, die Unterkategorien der Kategorie CAT_ID sind.\r\nDie Unterkategorien der Unterkategorien werden ebenfalls in das Array eingefügt.', 'array'),
(40, 0, 'public', 'create_dl_cat', '???\r\nDie Funktion wird nicht verwendet', 'string'),
(41, 0, 'public', 'get_timed_pic', 'Gibt ein Array aus Informationen über ein zeitgesteuertes Zufallsbild aus.\r\n\r\nFalls kein zeitgesteuertes Zufallsbild existiert, wird false zurückgegeben.', 'array'),
(42, 0, 'public', 'get_random_pic', 'Gibt ein Array aus Informationen über ein Zufallsbild aus.\r\n\r\nFalls kein Zufallsbild existiert, wird false zurückgegeben.', 'array'),
(43, 0, 'public', 'get_pagenav_start', 'Gibt ein Array aus Informationen über die Seiten eine Mehrseitigen Auswahl im AdminCP aus. (z.B. Artikelauswahl auf der &bdquo;Artikel bearbeiten&rdquo;-Seite)', 'array'),
(44, 0, 'public', 'get_filter_where', 'Generiert aus dem Filterausdruck der Referrersuche (AdminCP » Allgemein » Statistik » Referrer) eine Mysql-WHERE-Bedingung.', 'string'),
(45, 0, 'public', 'generate_pwd', 'Generiert ein Passwort der Länge LENGHT', 'string'),
(46, 0, 'public', 'check_captcha', 'Prüft, ob SOLUTION die Lösung des zuletzt geladenen Captchas ist.', 'bool'),
(47, 0, 'public', 'is_in_staff', 'Prüft, ob der User der ID USER_ID ein Seitenmitarbeiter ist.', 'bool'),
(48, 0, 'public', 'is_admin', 'Prüft, ob der Benutzer der ID USER_ID ein Administrator ist.', 'bool'),
(49, 0, 'public', 'get_template', 'Ein nicht mehr verwendbares Überbleibsel aus alix4-Zeiten, das das Template namens TEMPLATE_NAME lädt.\r\n\r\n[b]Hinweis:[/b] Das benutzen dieser Funktion wird einen MySQL-Error provozieren, da die Tabelle &bdquo;fs2_template&rdquo; in alix5 entfernt wurde!', 'string'),
(50, 0, 'public', 'get_email_template', 'Gibt das E-Mail-Template namens TEMPLATE_NAME zurück.', 'string'),
(51, 0, 'public', 'send_mail', 'Sendet eine E-Mail-Nachricht.', 'bool'),
(52, 0, 'public', 'create_textarea', 'Erstellt einen IWAC-Editor.', 'string'),
(53, 0, 'public', 'create_textarea_button', 'Erzeugt einen IWAC-Button.', 'string'),
(54, 0, 'public', 'create_textarea_seperator', 'Erzeugt einen Gruppen-Teiler für die IWAC-Buttons ein.', 'string'),
(55, 0, 'public', 'sys_message', 'Erzeugt eine Systemnachricht mit dem Titel TITLE.', 'string'),
(56, 0, 'public', 'forward_message', 'Erzeugt einen Weiterleitungshinweis mit dem Titel TITLE.', 'string'),
(57, 0, 'public', 'point_number', 'Formatiert zahl so, dass sie keine Nachkommstellen und die Tausenderstellen mit einem Punkt getrennt sind.', 'string'),
(58, 0, 'public', 'truncate_string', 'Kürzt den Text in string auf maxlength ohne ein Wort zu zerstören.\r\nDer Rückgabestring ist (ohne extention) immer [b]höchstens[/b] maxlength Zeichen lang.\r\nAn das Ende des Rückgabestrings wird extention angehängt.', 'string'),
(59, 0, 'public', 'cut_in_string', 'Kürzt eine Text so, dass nur der Anfang und das Ende des Strings zu sehen sind und der Mittelteil durch replacement ersetzt wird.', 'string'),
(60, 0, 'public', 'get_dl_categories', 'Gibt, ähnlich wie [home=doc&f=39]get_sub_cats[/home], ein Array der Downloadkategorien zurück, wobei in diesem Fall auch das Level der Hierarchie, der Kategoriename und die Übergalerie zurückgegeben wird.', 'void'),
(61, 0, 'public', 'display_news', 'Erzeugt die Darstellung einer News, deren Informationen in news_arr gespeichert sind.', 'string'),
(62, 0, 'public', 'getsize', 'Konvertiert eine Dateigröße SIZE (in Bytes) in KB, MB, GB oder TB.', 'string'),
(63, 0, 'public', 'markword', 'Markiert alle word in text.', 'string'),
(64, 0, 'public', 'html_nl2br', 'Fügt für alle Zeilenumbrüche in TEXT &bdquo;&lt;br&gt;&rdquo; ein.', 'string'),
(65, 0, 'public', 'savesql', 'Führt auf TEXT diverse Funktionen aus um die Möglichkeit von SQL-Injections möglichst klein zu halten.', 'string'),
(66, 0, 'public', 'unquote', 'Entfernt Backslashes (\\\\) vor doppelten und einfachen Anführungszeichen, doppelten Backslashes sowie vor NULLs in TEXT, wenn [url=http://www.php.net/manual/info.configuration.php#ini.magic-quotes-gpc]magic_quotes_gpc[/url] aktiviert ist.', 'string'),
(67, 0, 'public', 'killhtml', 'Entfernt HTML-Zeichen (wie &lt;, &gt;, ...) und Backslashes in TEXT.', 'string'),
(68, 0, 'public', 'fscode', 'Wandelt alle FS-Codes in text in ihre HTML-Darstellungen um.', 'string'),
(69, 0, 'public', 'killfs', 'Löscht alle FS-Codes aus text', 'string'),
(70, 0, 'public', 'checkVotedPoll', 'Prüft, ob der Besucher mit der aktuellen IP schon an der Umfrage pollid teilgenommen hat und löscht Einträge über Benutzer, die älter als einen Tag sind.', 'bool'),
(71, 0, 'public', 'registerVoter', 'Registriert, dass ein Benutzer für die Umfrage pollid schon abgestimmt hat um Mehrfachvotigs zu unterbinden.', 'void'),
(72, 3, 'public', '__construct', 'Diese Funktion initialisiert die Klasse.', 'void'),
(73, 3, 'public', 'disableAdd', 'Sicherheitsfunktion ist das Hinzufügen von Sprachdaten unmöglich macht.', 'void'),
(74, 3, 'public', 'getAllowState', 'Gibt den aktuellen Wert von [home=doc&v=12]allow_add[/home] zurück.', 'void'),
(75, 3, 'public', 'add', 'Fügt eine Sprachausdruck hinzu.', 'void'),
(76, 3, 'public', 'get', 'Gibt den Wert des Ausdruckes tag zurück.\r\nIst tag nicht Definiert, wird stattdessen "LOCALIZE: tag" zurückgegeben.', 'string'),
(77, 3, 'public', '__destruct', 'Setzt [home=doc&v=13]phrases[/home] und [home=doc&v=10]local[/home] aus ihre Initialwerte zurück.', 'void'),
(78, 4, 'public', '__construct', 'Initialisiert mit Hilfe von [home=doc&c=3]lang[/home] die Sprachdaten der Sprache local und der Datei type.php', ''),
(79, 4, 'public', 'get', 'Diese Funktion ist ein Alias zu [home=doc&f=76]lang::get[/home].', 'string'),
(80, 4, 'public', '__destruct', 'Setzt alle Klassenvariablen auf null.', 'void');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_docs_params`
--

DROP TABLE IF EXISTS `fs_docs_params`;
CREATE TABLE IF NOT EXISTS `fs_docs_params` (
  `function` tinyint(3) NOT NULL,
  `internal_id` mediumint(8) NOT NULL,
  `name` varchar(50) NOT NULL,
  `type` varchar(20) NOT NULL,
  `initval` varchar(100) NOT NULL,
  `desc` text NOT NULL,
  `isref` tinyint(1) NOT NULL DEFAULT '0',
  KEY `function` (`function`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `fs_docs_params`
--

INSERT INTO `fs_docs_params` (`function`, `internal_id`, `name`, `type`, `initval`, `desc`, `isref`) VALUES
(2, 1, 'filename', 'string', '', 'Der Name der auszulesenden Datei.', 0),
(2, 2, 'flags', 'int', '0', 'Suche der Datei im include-path.', 0),
(2, 3, 'context', 'resource', 'null', 'Ein mit [php=stream-context-create]stream_context_create[/php] erzeugter Kontext.', 0),
(2, 4, 'offset', 'int', '-1', 'Index des ersten auszulesenden Zeichens.', 0),
(2, 5, 'maxlen', 'int', '-1', 'Anzahl der auszulesenden Bytes.', 0),
(3, 1, 'filename', 'string', '', 'Die einzulesende Datei.', 0),
(3, 2, 'flags', 'int', '0', 'Ein oder mehrere Flags, die die Ausgabe beeinflussen.\r\nNäheres ist in der PHP-Dokumentation unter [php=file]file[/php] zu finden.', 0),
(3, 3, 'context', 'resource', 'null', 'Ein mit [php=stream-context-create]stream_context_create[/php] erzeugter Kontext.', 0),
(4, 1, 'filename', 'string', '', 'Name der Datei, in die geschrieben werden soll.', 0),
(4, 2, 'data', 'mixed', '', 'Die Daten, die in die Datei geschrieben werden sollen.', 0),
(4, 3, 'flags', 'int', '0', 'Ein oder mehrere Flags, die das Schreiben beeinflussen.\r\nNäheres ist in der PHP-Dokumentation unter [php=file-put-contents]file_put_contents[/php] zu finden.', 0),
(4, 4, 'context', 'resource', 'null', 'Ein mit [php=stream-context-create]stream_context_create[/php] erzeugter Kontext.', 0),
(5, 1, 'filename', 'string', '', 'Die zu löschende Datei.', 0),
(5, 2, 'context', 'resource', 'null', 'Ein mit [php=stream-context-create]stream_context_create[/php] erzeugter Kontext.', 0),
(6, 1, 'pathname', 'string', '', 'Der Pfad zum Verzeichnis.', 0),
(6, 2, 'mode', 'int', '0777', 'Die Zugriffsrechte des Verzeichnisses.\r\n\r\nFür nähere Angaben siehe [php=chmod]chmod[/php].', 0),
(6, 3, 'recursive', 'bool', 'false', 'Ermöglicht das Erstellen von verschachtelten Verzeichnissen.', 0),
(6, 4, 'context', 'resource', 'null', 'Ein mit [php=stream-context-create]stream_context_create[/php] erzeugter Kontext.', 0),
(7, 1, 'filename', 'string', '', 'Die zu löschende Datei bzw. das zu löschende Verzeichnis.', 0),
(7, 2, 'recursive', 'bool', 'false', 'Gibt an, ob das Verzeichnis rekursiv gelöscht werden soll.\r\n[b]Wichtig:[/b] Dies ist zwingend erforderlich, wenn das Verzeichnis Dateien enthält.', 0),
(8, 1, 'source', 'string', '', 'Die Quelldatei bzw. das Quellverzeichnis, die/das kopiert werden soll.', 0),
(8, 2, 'destination', 'string', '', 'Das Zielverzeichnis bzw. die Zieldatei.\r\nHinweis: Falls die [i]destination[/i] nicht existiert, wird es angelegt.\r\n[b]Hinweis:[/b] Existierende Dateien werden überschrieben.', 0),
(8, 3, 'foldermode', 'int', '0777', 'Die Zugriffsrechte des Verzeichnisses bzw. der Verzeichnisse.\r\n\r\nFür nähere Angaben siehe [php=chmod]chmod[/php].', 0),
(8, 4, 'filemode', 'int', '0777', 'Die Zugriffsrechte der Datei(en).\r\n\r\nFür nähere Angaben siehe [php=chmod]chmod[/php].', 0),
(10, 1, 'style', 'string', '', 'Der Name des Styles, der aktiviert werden soll.', 0),
(14, 1, 'file', 'string', '', 'Der Name der Datei, aus der die Templates ausgelesen werden sollen.', 0),
(16, 1, 'section', 'array', '', 'Die [home=doc&v=7]Sections[/home].', 0),
(17, 1, 'section', 'string', '', 'Name der [home=doc&v=7]Section[/home].', 0),
(18, 1, 'content', 'array', '', 'Das [home=doc&v=8]Sections_Content[/home]-Array.', 0),
(22, 1, 'tag', 'string', '', 'Der zu löschende Tag.', 0),
(19, 1, 'section_number', 'int', '', 'Die ID der [home=doc&v=7]Section[/home].', 0),
(23, 1, 'bool', 'bool', '', 'Der Wert, der [home=doc&v=5]clear_unassigned[/home] zugewiesen wird.', 0),
(24, 1, 'template', 'string', '', 'Setzt name des Templates.', 0),
(26, 1, 'section', 'string', '', 'Das zu ladende Template.', 0),
(28, 1, 'tag', 'string', '', 'Der Name des Tags.', 0),
(28, 2, 'value', 'string', '', 'Der Wert, durch den tag ersetzt werden soll.', 0),
(30, 1, 'TEXT', 'string', '', 'Der zu behandelnde Text', 0),
(30, 2, 'KILLHTML', 'bool', 'false', 'Bestimmt, ob zusätzlich [php=htmlspecialchars]htmlspecialchars[/php] auf TEXT angewendet werden soll.', 0),
(30, 3, 'STRIPSLASHES', 'bool', 'false', 'Bestimmt, ob zusätzlich [php=stripslashes]stripslashes[/php] auf TEXT angewendet werden soll.', 0),
(31, 1, 'PAGE', 'int', '', 'Die aktuelle Seite.', 0),
(31, 2, 'NUM_OF_PAGES', 'int', '', 'Gesamtzahl der Seiten', 0),
(31, 3, 'PER_PAGE', 'int', '', 'Anzahl der Einträge pro Seite.', 0),
(31, 4, 'NUM_OF_ENTRIES', 'int', '', 'Gesamtzahl der Einträge.', 0),
(31, 5, 'URL_TEMPLATE', 'string', '', 'Ein Template für die URL zu den Seiten.\r\nDas Template sollte die Variable {..page_num..} enthalten. Für sie wird dann die Seitenzahl eingefügt.', 0),
(32, 1, 'TEXT', 'string', '', 'Der zu untersuchende Text.', 0),
(33, 1, 'COLOR', 'string', '', 'Die zu konvertierende Farbe.', 0),
(34, 1, 'COLOR', 'string', '', 'Der zu prüfende String.', 0),
(35, 1, 'FOLDER', 'string', '', 'Das zu untersuchende Verzeichnis.', 0),
(35, 2, 'EXTRA', 'array', 'array()', 'Ein Array aus Dateien, die nicht zurückgegeben werden sollen.', 0),
(35, 3, 'BAD', 'array', 'array ( ".", "..", ".DS_Store", "_notes", "Thumbs.db", ".svn" )', 'Ein weiteres Array von Dateien, die nicht zurückgegeben werden sollen.', 0),
(36, 1, 'FOLDER', 'string', '', 'Das zu durchsuchende Verzeichnis.', 0),
(36, 2, 'FILE_EXT', 'string', '', 'Die Dateiendung der Dateien nach denen gesucht werden soll.', 0),
(36, 3, 'EXTRA', 'array', 'array()', 'Ein Array aus Dateien, die nicht zurückgegeben werden sollen.', 0),
(36, 4, 'BAD', 'array', 'array ( ".", "..", ".DS_Store", "_notes", "Thumbs.db", ".svn" )', 'Ein weiteres Array von Dateien, die nicht zurückgegeben werden sollen.', 0),
(37, 1, 'GROUP_ID', 'int', '', 'Die Gruppenid der Gruppe, von der die Informationen zurückgegeben werden sollen', 0),
(37, 2, 'IS_ADMIN', 'int', '0', 'Diese Variable wird hat nur die Funktion sicherzustellen, dass auch eine Gruppe ausgelesen wird, wenn der User Admin ist, aber keiner anderen Gruppe angehört.', 0),
(38, 1, 'DATE_STRING', 'string', '', 'Eine nach dem [php=date]date[/php]-Syntax formatierte Zeichenkette', 0),
(38, 2, 'TIMESTAMP', 'string', '', 'Der zu formatierende Zeitstempel.', 0),
(39, 1, 'CAT_ID', 'int', '', 'Die Kategorie nach deren Unterkategorien gesucht werden soll.', 0),
(39, 2, 'REC_SUB_CAT_ARRAY', 'array', '', 'Ein Array aus schon vorhandenen Kategorien.\r\nDieser Parameter wird für den rekursiven Aufruf der Funktion benötigt, bei der die Unterkategorien zweiter und höherer Generation ermittelt werden.\r\nDer Startparameter sollte "array()" sein.', 0),
(40, 1, 'CAT_ID', 'int', '', 'Die Kategorie für die die Funktion ausgeführt werden soll.', 0),
(40, 2, 'GET_ID', 'int', '', 'Die aktuelle Kategorie.', 0),
(40, 3, 'NAVI_TEMPLATE', 'string', '', 'Das Template.', 0),
(43, 1, 'NUM_OF_ENTRIES', 'int', '', 'Gesamtzahl der Einträge.', 0),
(43, 2, 'ENTRIES_PER_PAGE', 'int', '', 'Anzahl der Einträge pro Seite.', 0),
(43, 3, 'START', 'int', '', 'Nummer des ersten auszulesenden Eintrages.', 0),
(44, 1, 'FILTER', 'string', '', 'Der Filerausdruck.', 0),
(44, 2, 'SEARCH_FIELD', 'string', '', 'Die zu durchsuchende Spalte. (In der Referrersuche &bdquo;ref_url&rdquo;)', 0),
(45, 1, 'LENGHT', 'int', '10', 'Die Länge des Passwortes.', 0),
(46, 1, 'SOLUTION', 'string', '', 'Die eingegebene Zeichenkette.', 0),
(46, 2, 'ACTIVATION', 'int', '', 'Eine Zahl, die die Strenge des Captchas setzt.\r\nMögliche Werte:\r\n0 - Niemand muss ein Captcha lösen.\r\n1 - Nur unangemeldete Benutzer müssen das Captcha lösen.\r\n3 - Alle nicht-Seitenmitarbeiter müssen das Captcha lösen.\r\n4 - Alle nicht-Administratoren müssen das Captcha lösen.', 0),
(47, 1, 'USER_ID', 'int', '', 'Der zu untersuchende Benutzer.', 0),
(48, 1, 'USER_ID', 'int', '', 'Der zu untersuchende Benutzer.', 0),
(49, 1, 'TEMPLATE_NAME', 'string', '', 'Der Name des auszugebende Templates.', 0),
(50, 1, 'TEMPLATE_NAME', 'string', '', 'Der Name des auszugebende Templates.', 0),
(51, 1, 'TO', 'string', '', 'Der Empfänger der Mail.', 0),
(51, 2, 'SUBJECT', 'string', '', 'Der Betreff der Mail.', 0),
(51, 3, 'TEXT', 'string', '', 'Der zu versendende Text.\r\nWenn <a href="#param_4">HTML</a> false ist &bdquo;html&rdquo; ist und das Verwenden von HTML im AdminCP aktiviert wurde, wird der Text zusätzlich mit [home=doc&f=68]FS-Codes[/home] formtiert.', 0),
(51, 4, 'HTML', 'bool', 'false', 'Bestimmt, ob der Text mit HTML formatiert werden kann.', 0),
(51, 5, 'FROM', 'string', 'false', 'Der Absender der Mail.\r\nFalls kein Empfänger angegeben wird oder die Admin-Mailadresse als Standard angegeben wurde, wird die Admin-Mailadresse verwendet.', 0),
(52, 1, 'name', 'string', '', 'Wert des Id- und Name-Attributes der Textarea.', 0),
(52, 2, 'text', 'string', '""', 'Der Inhalt der Textarea.', 0),
(52, 3, 'width', 'int', '""', 'Die Breite der Textarea in Pixeln.', 0),
(52, 4, 'height', 'int', '""', 'Die Höhe der Textarea.', 0),
(52, 5, 'class', 'string', '""', 'Der Wert des Class-Attributes der Textarea.', 0),
(52, 6, 'all', 'bool', 'true', 'Legt fest, ob für alle FS-Codes ein IWAC-Button eingefügt werden soll.', 0),
(52, 7, 'fs_smilies', 'int', '0', 'Legt fest, ob die Smilies auch dann angezeigt werden sollen, wenn <a href="#param_5">all</a> false ist.', 0),
(52, 8, 'fs_b', 'int', '0', 'Legt fest, ob der Button für den FS-Code &bdquo;b&rdquo; auch dann angezeigt werden sollen, wenn <a href="#param_5">all</a> false ist.', 0),
(52, 9, 'fs_i', 'int', '0', 'Legt fest, ob der Button für den FS-Code &bdquo;i&rdquo; auch dann angezeigt werden sollen, wenn <a href="#param_5">all</a> false ist.', 0),
(52, 10, 'fs_u', 'int', '0', 'Legt fest, ob der Button für den FS-Code &bdquo;u&rdquo; auch dann angezeigt werden sollen, wenn <a href="#param_5">all</a> false ist.', 0),
(52, 11, 'fs_s', 'int', '0', 'Legt fest, ob der Button für den FS-Code &bdquo;s&rdquo; auch dann angezeigt werden sollen, wenn <a href="#param_5">all</a> false ist.', 0),
(52, 12, 'fs_center', 'int', '0', 'Legt fest, ob der Button für den FS-Code &bdquo;center&rdquo; auch dann angezeigt werden sollen, wenn <a href="#param_5">all</a> false ist.', 0),
(52, 13, 'fs_font', 'int', '0', 'Legt fest, ob der Button für den FS-Code &bdquo;font&rdquo; auch dann angezeigt werden sollen, wenn <a href="#param_5">all</a> false ist.', 0),
(52, 14, 'fs_color', 'int', '0', 'Legt fest, ob der Button für den FS-Code &bdquo;color&rdquo; auch dann angezeigt werden sollen, wenn <a href="#param_5">all</a> false ist.', 0),
(52, 15, 'fs_size', 'int', '0', 'Legt fest, ob der Button für den FS-Code &bdquo;size&rdquo; auch dann angezeigt werden sollen, wenn <a href="#param_5">all</a> false ist.', 0),
(52, 16, 'fs_img', 'int', '0', 'Legt fest, ob der Button für den FS-Code &bdquo;img&rdquo; auch dann angezeigt werden sollen, wenn <a href="#param_5">all</a> false ist.', 0),
(52, 17, 'fs_cimg', 'int', '0', 'Legt fest, ob der Button für den FS-Code &bdquo;cimg&rdquo; auch dann angezeigt werden sollen, wenn <a href="#param_5">all</a> false ist.', 0),
(52, 18, 'fs_url', 'int', '0', 'Legt fest, ob der Button für den FS-Code &bdquo;url&rdquo; auch dann angezeigt werden sollen, wenn <a href="#param_5">all</a> false ist.', 0),
(52, 19, 'fs_home', 'int', '0', 'Legt fest, ob der Button für den FS-Code &bdquo;home&rdquo; auch dann angezeigt werden sollen, wenn <a href="#param_5">all</a> false ist.', 0),
(52, 20, 'fs_email', 'int', '0', 'Legt fest, ob der Button für den FS-Code &bdquo;email&rdquo; auch dann angezeigt werden sollen, wenn <a href="#param_5">all</a> false ist.', 0),
(52, 21, 'fs_code', 'int', '0', 'Legt fest, ob der Button für den FS-Code &bdquo;code&rdquo; auch dann angezeigt werden sollen, wenn <a href="#param_5">all</a> false ist.', 0),
(52, 22, 'fs_quote', 'int', '0', 'Legt fest, ob der Button für den FS-Code &bdquo;quote&rdquo; auch dann angezeigt werden sollen, wenn <a href="#param_5">all</a> false ist.', 0),
(52, 23, 'fs_noparse', 'int', '0', 'Legt fest, ob der Button für den FS-Code &bdquo;noparse&rdquo; auch dann angezeigt werden sollen, wenn <a href="#param_5">all</a> false ist.', 0),
(53, 1, 'img_file_name', 'string', '', 'URL zum Bild für den Button.', 0),
(53, 2, 'alt', 'string', '', 'Alternativer Text für den Button.', 0),
(53, 3, 'title', 'string', '', 'Beschreibungstext für den Button.', 0),
(53, 4, 'insert', 'string', '', 'Wert der onClick-Attributes des Buttons.', 0),
(55, 1, 'TITLE', 'string', '', 'Der Titel der Nachricht.', 0),
(55, 2, 'MESSAGE', 'string', '', 'Die Nachricht.', 0),
(56, 1, 'TITLE', 'string', '', 'Der Titel der Weiterleitungsnachricht.', 0),
(56, 2, 'MESSAGE', 'string', '', 'Die Weiterleitungsnachricht.', 0),
(56, 3, 'URL', 'string', '', 'Die URL zu der der Benutzer weitergeleitet werden soll.', 0),
(57, 1, 'zahl', 'int', '', 'Die zu formatierende Zahl.', 0),
(58, 1, 'string', 'string', '', 'Der zu kürzende Text.', 0),
(58, 2, 'maxlength', 'int', '', 'Die maximale Länge des Rückgabestrings.', 0),
(58, 3, 'extention', 'string', '', 'Ein String, der an das Ende der Rückgabe angehängt wird. (z.B. &bdquo;...&rdquo;)', 0),
(59, 1, 'string', 'string', '', 'Der zu kürzende String.', 0),
(59, 2, 'maxlength', 'int', '', 'Die maximale Länge des Ausgabestrings.', 0),
(59, 3, 'replacement', 'string', '', 'Der Text, der in der Mitte des Strings eingefügt werden soll. (z.B. &bdquo;...&rdquo;)', 0),
(60, 1, 'IDs', 'array', '', 'Das Array der Kategorien', 1),
(60, 2, 'CAT_ID', 'int', '', 'Die ID der aktuellen Kategorie.', 0),
(60, 3, 'SHOW_SUB', 'int', '0', 'Legt fest, ob die Unterkategorien aller Kategorien angezeigt werden sollen.', 0),
(60, 4, 'ID', 'int', '0', 'ID der Kategorie, deren Informationen zurückgegeben werden sollen.\r\n\r\nHinweis: Sollte beim Aufruf der Funktion 0 bleiben. Dieser Parameter wird nur für den rekursiven Ausruf der Funktion benötigt.', 0),
(60, 5, 'LEVEL', 'int', '-1', 'Das Level der Hierarchie der aktuellen Kategorie.\r\n\r\nHinweis: Sollte beim Aufruf der Funktion -1 bleiben. Dieser Parameter wird nur für den rekursiven Ausruf der Funktion benötigt.', 0),
(61, 1, 'news_arr', 'array', '', 'Ein Array aus Informationen über die News.\r\nDieses Array entspricht dem Array, das mittels [php=mysql-query]mysql_query[/php] aus der Datenbank ausgelesen wurde.', 0),
(61, 2, 'html_code', 'int', '', 'Legt fest, ob in der News HTML verwendet werden kann.\r\n2 und 4 stehen für true;\r\n1 und 3 für false.', 0),
(61, 3, 'fs_code', 'int', '', 'Legt fest, ob in der News FS-Code verwendet werden kann.\r\n2 und 4 stehen für true;\r\n1 und 3 für false.', 0),
(61, 4, 'para_handling', 'int', '', 'Legt fest, ob Zeilenumbrüche automatisch durch ein durch einen HTML-Zeilenumbruch ersetzt werden sollen.\r\n2 und 4 stehen für true;\r\n1 und 3 für false.', 0),
(62, 1, 'SIZE', 'int', '', 'Die Größe der Datei in Bytes.', 0),
(63, 1, 'text', 'string', '', 'Der Text, in dem <a href="#param_2">word</a> markiert werden soll.', 0),
(63, 2, 'word', 'string', '', 'Der zu markierende Ausdruck.', 0),
(64, 1, 'TEXT', 'string', '', 'Der zu formatierende Text.', 0),
(65, 1, 'TEXT', 'string', '', 'Der zu sichernde String.', 0),
(66, 1, 'TEXT', 'string', '', 'Der zu behandelnde String.', 0),
(67, 1, 'TEXT', 'string', '', 'Der zu behandelnde String.', 0),
(68, 1, 'text', 'string', '', 'Der zu behandelnde Text.', 0),
(68, 2, 'all', 'bool', 'true', 'Legt fest, ob alle FS-Codes umgewandelt werden sollen oder die Umwandlung pro FS-Code vorgenommen werden soll.', 0),
(68, 3, 'html', 'bool', 'false', 'Legt fest, ob HTML in <a href="#param_1">text</a> erlaubt sein soll.', 0),
(68, 4, 'para', 'bool', 'false', 'Legt fest, ob Zeilenumbrüche automatisch durch ein durch einen HTML-Zeilenumbruch ersetzt werden sollen.', 0),
(68, 5, 'do_b', 'int', '0', 'Legt fest, ob der Button für den FS-Code &bdquo;b&rdquo; auch dann angezeigt werden sollen, wenn <a href="#param_2">all</a> false ist.', 0),
(68, 6, 'do_i', 'int', '0', 'Legt fest, ob der Button für den FS-Code &bdquo;i&rdquo; auch dann angezeigt werden sollen, wenn <a href="#param_2">all</a> false ist.', 0),
(68, 6, 'do_u', 'int', '0', 'Legt fest, ob der Button für den FS-Code &bdquo;u&rdquo; auch dann angezeigt werden sollen, wenn <a href="#param_2">all</a> false ist.', 0),
(68, 7, 'do_s', 'int', '0', 'Legt fest, ob der Button für den FS-Code &bdquo;s&rdquo; auch dann angezeigt werden sollen, wenn <a href="#param_2">all</a> false ist.', 0),
(68, 8, 'do_center', 'int', '0', 'Legt fest, ob der Button für den FS-Code &bdquo;center&rdquo; auch dann angezeigt werden sollen, wenn <a href="#param_2">all</a> false ist.', 0),
(68, 9, 'do_url', 'int', '0', 'Legt fest, ob der Button für den FS-Code &bdquo;url&rdquo; auch dann angezeigt werden sollen, wenn <a href="#param_2">all</a> false ist.', 0),
(68, 10, 'do_homelink', 'int', '0', 'Legt fest, ob der Button für den FS-Code &bdquo;home&rdquo; auch dann angezeigt werden sollen, wenn <a href="#param_2">all</a> false ist.', 0),
(68, 11, 'do_email', 'int', '0', 'Legt fest, ob der Button für den FS-Code &bdquo;email&rdquo; auch dann angezeigt werden sollen, wenn <a href="#param_2">all</a> false ist.', 0),
(68, 12, 'do_img', 'int', '0', 'Legt fest, ob der Button für den FS-Code &bdquo;img&rdquo; auch dann angezeigt werden sollen, wenn <a href="#param_2">all</a> false ist.', 0),
(68, 13, 'do_cimg', 'int', '0', 'Legt fest, ob der Button für den FS-Code &bdquo;cimg&rdquo; auch dann angezeigt werden sollen, wenn <a href="#param_2">all</a> false ist.', 0),
(68, 14, 'do_list', 'int', '0', 'Legt fest, ob der Button für den FS-Code &bdquo;list&rdquo; auch dann angezeigt werden sollen, wenn <a href="#param_2">all</a> false ist.', 0),
(68, 15, 'do_numlist', 'int', '0', 'Legt fest, ob der Button für den FS-Code &bdquo;numlist&rdquo; auch dann angezeigt werden sollen, wenn <a href="#param_2">all</a> false ist.', 0),
(68, 16, 'do_font', 'int', '0', 'Legt fest, ob der Button für den FS-Code &bdquo;font&rdquo; auch dann angezeigt werden sollen, wenn <a href="#param_2">all</a> false ist.', 0),
(68, 17, 'do_color', 'int', '0', 'Legt fest, ob der Button für den FS-Code &bdquo;color&rdquo; auch dann angezeigt werden sollen, wenn <a href="#param_2">all</a> false ist.', 0),
(68, 18, 'do_size', 'int', '0', 'Legt fest, ob der Button für den FS-Code &bdquo;size&rdquo; auch dann angezeigt werden sollen, wenn <a href="#param_2">all</a> false ist.', 0),
(68, 19, 'do_code', 'int', '0', 'Legt fest, ob der Button für den FS-Code &bdquo;code&rdquo; auch dann angezeigt werden sollen, wenn <a href="#param_2">all</a> false ist.', 0),
(68, 20, 'do_quote', 'int', '0', 'Legt fest, ob der Button für den FS-Code &bdquo;quote&rdquo; auch dann angezeigt werden sollen, wenn <a href="#param_2">all</a> false ist.', 0),
(68, 21, 'do_noparse', 'int', '0', 'Legt fest, ob der Button für den FS-Code &bdquo;noparse&rdquo; auch dann angezeigt werden sollen, wenn <a href="#param_2">all</a> false ist.', 0),
(68, 22, 'do_', 'int', '0', 'Legt fest, ob der Button für den FS-Code &bdquo;&rdquo; auch dann angezeigt werden sollen, wenn <a href="#param_2">all</a> false ist.', 0),
(68, 23, 'do_smilies', 'int', '0', 'Legt fest, ob der Button für den FS-Code &bdquo;smilies&rdquo; auch dann angezeigt werden sollen, wenn <a href="#param_2">all</a> false ist.', 0),
(68, 24, 'do_player', 'int', '0', 'Legt fest, ob der Button für den FS-Code &bdquo;player&rdquo; auch dann angezeigt werden sollen, wenn <a href="#param_2">all</a> false ist.', 0),
(69, 1, 'text', 'string', '', 'Der zu formatierende String.', 0),
(70, 1, 'pollid', 'int', '', 'ID der zu prüfenden Umfrage.', 0),
(71, 1, 'pollid', 'int', '', 'ID der Umfrage für die der Benutzer abgestimmt hat.', 0),
(71, 2, 'voter_ip', 'string', '', 'IP des Benutzers.', 0),
(72, 1, 'local', 'string', '', '???\r\nSinnlose Variable', 0),
(75, 1, 'tag', 'string', '', 'Der Name des Ausdrucks.\r\nIst der Parameter von [home=doc&f=76]get[/home]', 0),
(75, 2, 'text', 'string', '', 'Der Wert des Ausdruckes.', 0),
(76, 1, 'tag', 'string', '', 'Name des Ausdruckes, der zurückgegeben werden soll.', 0),
(78, 1, 'local', 'string', '', 'Sprachkürzel der Sprache, aus der die Sprachausdrücke importiert werden sollen.', 0),
(78, 2, 'type', 'string', '', 'Name der Sprachdatei.', 0),
(79, 1, 'tag', 'string', '', 'Name des Ausdruckes, der zurückgegeben werden soll.', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_docs_variables`
--

DROP TABLE IF EXISTS `fs_docs_variables`;
CREATE TABLE IF NOT EXISTS `fs_docs_variables` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `type` varchar(15) NOT NULL,
  `name` varchar(50) NOT NULL,
  `desc` text NOT NULL,
  `class` tinyint(3) NOT NULL,
  `initval` varchar(50) NOT NULL,
  `content` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Daten für Tabelle `fs_docs_variables`
--

INSERT INTO `fs_docs_variables` (`id`, `type`, `name`, `desc`, `class`, `initval`, `content`) VALUES
(1, 'const', 'OPENER', 'Der String, mit dem eine Template-Variable beginnt.', 2, '{..', 'string'),
(2, 'const', 'CLOSER', 'Der String, mit dem eine Template-Variable endet.', 2, '..}', 'string'),
(3, 'private', 'style', 'Der Style, aus dem die Templates geladen werden.\r\n\r\nDiese Variable kann mittels [home=doc&f=10]setStyle[/home] geändert werden.', 2, 'default', 'string'),
(4, 'private', 'file', 'Die Datei aus denen die Templates geladen werden.\r\n\r\nDiese Variable kann mittels [hom=doc&f=14]setFile[/home] geändert werden.', 2, 'null', 'string'),
(5, 'private', 'clear_unassigned', 'Legt fest, ob nicht definierte Tags aus dem Template entfernt werden.\r\n\r\nHinweis: Tags, die mit [home=doc&f=22]deleteTag[/home] gelöscht wurden werden nicht ersetzt.\r\n\r\n[b]Hinweis:[/b] Diese Funktion hat momentan noch keine Auswirkungen auf die Templates.', 2, 'false', 'bool'),
(6, 'private', 'tags', 'Ein Array, das die definierten Template-Variablen und deren ersetzungstext enthält.\r\n\r\nEine neue Variable kann durch [home=doc&f=28]tag[/home] hinzugefügt werden.', 2, 'array()', 'array'),
(7, 'private', 'sections', 'Ein Array, in dem die aus [home=doc&v=4]file[/home] ausgelesenen Templatebezeichnungen gespeichert werden.\r\n\r\nHinweis: Dieses Array enthält nur die [b]Bezeichnungen[/b] (z.B. MAINPAGE). Der Inhalt der Templates wird in [home=doc&v=8]sections_content[/home] gespeichert.', 2, 'array()', 'array'),
(8, 'private', 'sections_content', 'Ein Array, in dem die aus [home=doc&v=4]file[/home] ausgelesenen Templates gespeichert werden.\r\n\r\nHinweis: Dieses Array enthält den [b]Inhalt[/b] der Templates. Die Bezeichnungen der Templates werden in [home=doc&v=7]sections[/home] gespeichert.', 2, 'array()', 'array'),
(9, 'private', 'template', 'Ein String, in dem das das aktuelle Template gespeichert wird.\r\n\r\nDiese Variable wird mittels [home=doc&f=26]load[/home] geändert.', 2, 'null', 'string'),
(10, 'private', 'local', '???\r\nSinnlose Variable', 3, 'null', 'string'),
(11, 'private', 'type', '???\r\nSinnlose Variable', 3, '', ''),
(12, 'private', 'allow_add', 'Legt fest, ob neue Sprachausdrücke definiert werden können.', 3, 'true', 'bool'),
(13, 'private', 'phrases', 'Ein Array, das alle Sprachausdrücke beinhaltet.', 3, 'array()', 'array'),
(14, 'private', 'local', 'Beinhaltet das Sprachkürzel.', 4, 'null', 'string'),
(15, 'private', 'type', 'Beinhaltet den Dateinamen.', 4, 'null', 'string'),
(16, 'private', 'langData', 'Beinhaltet eine Referenz auf die Klasse [home=doc&c=3]lang[/home].', 4, '', 'object');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_editor_config`
--

DROP TABLE IF EXISTS `fs_editor_config`;
CREATE TABLE IF NOT EXISTS `fs_editor_config` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `fs_editor_config`
--

INSERT INTO `fs_editor_config` (`id`, `smilies_rows`, `smilies_cols`, `textarea_width`, `textarea_height`, `bold`, `italic`, `underline`, `strike`, `center`, `font`, `color`, `size`, `list`, `numlist`, `img`, `cimg`, `url`, `home`, `email`, `code`, `quote`, `noparse`, `smilies`, `do_bold`, `do_italic`, `do_underline`, `do_strike`, `do_center`, `do_font`, `do_color`, `do_size`, `do_list`, `do_numlist`, `do_img`, `do_cimg`, `do_url`, `do_home`, `do_email`, `do_code`, `do_quote`, `do_noparse`, `do_smilies`) VALUES
(1, 5, 2, 355, 120, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 1, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 0, 1, 0, 1, 0, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_email`
--

DROP TABLE IF EXISTS `fs_email`;
CREATE TABLE IF NOT EXISTS `fs_email` (
  `id` tinyint(1) NOT NULL DEFAULT '1',
  `signup` text COLLATE utf8_unicode_ci NOT NULL,
  `change_password` text COLLATE utf8_unicode_ci NOT NULL,
  `delete_account` text COLLATE utf8_unicode_ci NOT NULL,
  `use_admin_mail` tinyint(1) NOT NULL DEFAULT '1',
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `html` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `fs_email`
--

INSERT INTO `fs_email` (`id`, `signup`, `change_password`, `delete_account`, `use_admin_mail`, `email`, `html`) VALUES
(1, 'Hallo  {..user_name..},\r\n\r\nDu hast dich bei $VAR(page_title) registriert. Deine Zugangsdaten sind:\r\n\r\nBenutzername: {..user_name..}\r\nPasswort: {..new_password..}\r\n\r\nFalls du deine Daten ändern möchtest, kannst du das gerne auf deiner [url=$VAR(url)?go=editprofil]Profilseite[/url] tun.\r\n\r\nDein Team von $VAR(page_title)!', 'Hallo {..user_name..},\r\n\r\nDein Passwort bei $VAR(page_title) wurde geändert. Deine neuen Zugangsdaten sind:\r\n\r\nBenutzername: {..user_name..}\r\nPasswort: {..new_password..}\r\n\r\nFalls du deine Daten ändern möchtest, kannst du das gerne auf deiner [url=$VAR(url)?go=editprofil]Profilseite[/url] tun.\r\n\r\nDein Team von $VAR(page_title)!', 'Hallo {username},\r\n\r\nSchade, dass du dich von unserer Seite abgemeldet hast. Falls du es dir doch noch anders überlegen willst, [url={virtualhost}]kannst du ja nochmal rein schauen[/url].\r\n\r\nDein Webseiten-Team!', 1, '', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_fscodes`
--

DROP TABLE IF EXISTS `fs_fscodes`;
CREATE TABLE IF NOT EXISTS `fs_fscodes` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL,
  `contenttype` varchar(20) NOT NULL,
  `callbacktype` tinyint(1) NOT NULL,
  `allowin` varchar(100) NOT NULL,
  `disallowin` varchar(100) NOT NULL,
  `param_1` text NOT NULL,
  `param_2` text NOT NULL,
  `php` text NOT NULL,
  `active` tinyint(1) NOT NULL,
  `added` varchar(25) NOT NULL,
  `edited` varchar(25) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Daten für Tabelle `fs_fscodes`
--

INSERT INTO `fs_fscodes` (`id`, `name`, `contenttype`, `callbacktype`, `allowin`, `disallowin`, `param_1`, `param_2`, `php`, `active`, `added`, `edited`) VALUES
(1, 'b', 'inline', 0, 'listitem, block, inline, link', '', '<b>', '</b>', '', 1, '1 1265756400', '0'),
(2, 'i', 'inline', 0, 'listitem, block, inline, link', '', '<i>', '</i>', '', 1, '1 1265756400', '0'),
(3, 'u', 'inline', 0, 'listitem, block, inline, link', '', '<span style="text-decoration:underline;">', '</span>', '', 1, '1 1265756400', '0'),
(4, 's', 'inline', 0, 'listitem, block, inline, link', '', '<span style="text-decoration:line-through;">', '</span>', '', 1, '1 1265756400', '0'),
(5, 'center', 'inline', 0, 'listitem, block, inline, link', '', '<p align="center">', '</p>', '', 1, '1 1265756400', '0'),
(6, 'url', 'link', 5, 'listitem, block, inline', 'link', '<a href="{..x..}" target="_blank">{..x..}</a>', '<a href="{..y..}" target="_blank">{..x..}</a>', '', 1, '1 1265756400', '0'),
(7, 'home', 'link', 5, 'listitem, block, inline', 'link', '', '', 'global $global_config_arr;\r\nif ($action == ''validate'') {\r\nreturn true;\r\n}\r\nif (!isset ($attributes[''default''])) {\r\nreturn ''<a href="''.$global_config_arr[virtualhost]."?go=".htmlspecialchars ($content).''" target="_self">''.$page_url."?go=".htmlspecialchars ($content).''</a>'';\r\n}\r\nreturn ''<a href="''.$global_config_arr[virtualhost]."?go=".htmlspecialchars ($attributes[''default'']).''" target="_self">''.$content.''</a>'';', 1, '1 1265756400', '0'),
(8, 'email', 'link', 5, 'listitem, block, inline', 'link', '<a href="mailto:{..x..}">{..x..}</a>', '<a href="mailto:{..y..}">{..x..}</a>', '', 1, '1 1265756400', '0'),
(9, 'img', 'image', 5, 'listitem, block, inline, link', '', '<img src="{..x..}" alt="{..x..}">', '<img src="{..x..}" alt="{..x..}" align="{..y..}">', '', 1, '1 1265756400', '0'),
(10, 'cimg', 'image', 5, 'listitem, block, inline, link', '', '', '', 'global $global_config_arr;\r\nif ($action == ''validate'') {\r\nreturn true;\r\n}\r\nif (!isset ($attributes[''default''])) {\r\nreturn ''<img src="''.$global_config_arr[virtualhost]."images/content/".htmlspecialchars ($content).''" alt="''.htmlspecialchars ($content).''">'';\r\n}\r\nreturn ''<img src="''.$global_config_arr[virtualhost]."images/content/".htmlspecialchars ($content).''" alt="''.htmlspecialchars ($content).''" align="''.htmlspecialchars($attributes[''default'']).''">'';', 1, '1 1265756400', '0'),
(11, 'player', 'block', 5, 'block, inline', 'listitem, link', '', '', 'if ($action == ''validate'') {\r\nreturn true;\r\n}\r\nif (!isset ($attributes[''default''])) {\r\nreturn get_player ( $content );\r\n}\r\n$res = explode ( ",", $attributes[''default''], 2 );\r\nintval($res[0]);\r\nintval($res[1]);\r\nreturn get_player ( $content, $res[0], $res[1] );', 1, '1 1265756400', '0'),
(12, 'list', 'list', 0, 'block, listitem', 'link', '<ul>', '</ul>', '', 1, '1 1265756400', '0'),
(13, 'numlist', 'list', 0, 'block, listitem', 'link', '<ol>', '</ol>', '', 1, '1 1265756400', '0'),
(14, '*', 'listitem', 0, 'list', '', '<li>', '</li>', '', 1, '1 1265756400', '0'),
(15, 'font', 'inline', 2, 'listitem, block, inline, link', '', '{..x..}', '<span style="font-family:{..y..};">{..x..}</span>', '', 1, '1 1265756400', '0'),
(16, 'color', 'inline', 2, 'listitem, block, inline, link', '', '{..x..}', '<span style="color:{..y..};">{..x..}</span>', '', 1, '1 1265756400', '0'),
(17, 'size', 'inline', 2, 'listitem, block, inline, link', '', '', '', 'if ($action == ''validate'') {\r\nif (!isset ($attributes[''default''])) { return false; }\r\nelse {\r\n$font_sizes = array(0,1,2,3,4,5,6,7);\r\nif (!in_array($attributes[''default''], $font_sizes)) { return false; }\r\nelse { return true; }\r\n}\r\n}\r\nif (isset ($attributes[''default''])) {\r\n$arr_num = $attributes[''default''];\r\n$font_sizes_values = array("70%","85%","100%","125%","155%","195%","225%","300%");\r\nreturn ''<span style="font-size:''.$font_sizes_values[$arr_num].'';">''.$content.''</span>'';\r\n}', 1, '1 1265756400', '0'),
(18, 'code', 'block', 2, 'listitem, block, inline', 'link', '<table cellpadding="5" align="center" border="0" width="90%">\r\n  <tr>\r\n    <td>\r\n      <b>Code:</b>\r\n    </td>\r\n  </tr>\r\n  <tr>\r\n    <td style="font-family:Courier New; border-collapse: collapse; border:1px dotted #000000;">\r\n      <code>{..x..}</code>\r\n    </td>\r\n  </tr>\r\n</table>', '<table cellpadding="5" align="center" border="0" width="90%">\r\n  <tr>\r\n    <td>\r\n      <b>Code:</b>\r\n    </td>\r\n  </tr>\r\n  <tr>\r\n    <td style="font-family:Courier New; border-collapse: collapse; border:1px dotted #000000;">\r\n      <code>{..x..}</code>\r\n    </td>\r\n  </tr>\r\n</table>', '', 1, '1 1265756400', '0'),
(19, 'quote', 'block', 2, 'listitem&#44; block&#44; inline', 'list', '<table cellpadding=\\"5\\" align=\\"center\\" border=\\"0\\" width=\\"90%\\">\r\n  <tr>\r\n    <td>\r\n      <b>Zitat:</b>\r\n    </td>\r\n  </tr>\r\n  <tr>\r\n    <td style=\\"border-collapse:collapse; border:1px dotted #000000;\\">\r\n      <q>{..x..}</q>\r\n    </td>\r\n  </tr>\r\n</table>', '<table cellpadding=\\"5\\" align=\\"center\\" border=\\"0\\" width=\\"90%\\">\r\n  <tr>\r\n    <td>\r\n      <b>Zitat von <cite>{..y..}</cite>:</b>\r\n    </td>\r\n  </tr>\r\n  <tr>\r\n    <td style=\\"border-collapse:collapse; border:1px dotted #000000;\\">\r\n      <q cite=\\"{..y..}\\">{..x..}</q>\r\n    </td>\r\n  </tr>\r\n</table>', '', 1, '1 1265756400', '0'),
(20, 'noparse', 'inline', 5, 'listitem, block, inline, link', '', '', '', 'if ($action == \\''validate\\'') {\r\nreturn true;\r\n}\r\nreturn $content;\r\n', 1, '1 1265756400', '0');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_fscodes_flag`
--

DROP TABLE IF EXISTS `fs_fscodes_flag`;
CREATE TABLE IF NOT EXISTS `fs_fscodes_flag` (
  `code` mediumint(8) NOT NULL,
  `name` smallint(2) NOT NULL,
  `value` smallint(2) NOT NULL,
  KEY `code` (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `fs_fscodes_flag`
--

INSERT INTO `fs_fscodes_flag` (`code`, `name`, `value`) VALUES
(5, 7, 2),
(12, 3, 2),
(12, 5, 2),
(12, 7, 2),
(14, 2, 1),
(14, 8, 1),
(18, 7, 1),
(18, 7, 2),
(19, 7, 1),
(19, 7, 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_fscode_config`
--

DROP TABLE IF EXISTS `fs_fscode_config`;
CREATE TABLE IF NOT EXISTS `fs_fscode_config` (
  `type` varchar(25) NOT NULL,
  `value` varchar(50) NOT NULL,
  UNIQUE KEY `type` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `fs_fscode_config`
--

INSERT INTO `fs_fscode_config` (`type`, `value`) VALUES
('file_height', '50'),
('file_size', '99'),
('file_width', '50');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_global_config`
--

DROP TABLE IF EXISTS `fs_global_config`;
CREATE TABLE IF NOT EXISTS `fs_global_config` (
  `id` tinyint(1) NOT NULL DEFAULT '1',
  `version` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0.9',
  `virtualhost` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `admin_mail` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `dyn_title` tinyint(1) NOT NULL,
  `dyn_title_ext` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `keywords` text COLLATE utf8_unicode_ci NOT NULL,
  `publisher` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `copyright` text COLLATE utf8_unicode_ci NOT NULL,
  `show_favicon` tinyint(1) NOT NULL DEFAULT '0',
  `style_id` mediumint(8) NOT NULL DEFAULT '0',
  `style_tag` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'default',
  `allow_other_designs` tinyint(1) NOT NULL DEFAULT '1',
  `date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `time` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `datetime` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `page` text COLLATE utf8_unicode_ci NOT NULL,
  `page_next` text COLLATE utf8_unicode_ci NOT NULL,
  `page_prev` text COLLATE utf8_unicode_ci NOT NULL,
  `random_timed_deltime` int(12) NOT NULL DEFAULT '0',
  `feed` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `language_text` varchar(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'de_DE',
  `home` tinyint(1) NOT NULL DEFAULT '0',
  `home_text` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `auto_forward` int(2) NOT NULL DEFAULT '3',
  `search_index_update` tinyint(1) NOT NULL DEFAULT '1',
  `search_index_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `fs_global_config`
--

INSERT INTO `fs_global_config` (`id`, `version`, `virtualhost`, `admin_mail`, `title`, `dyn_title`, `dyn_title_ext`, `description`, `keywords`, `publisher`, `copyright`, `show_favicon`, `style_id`, `style_tag`, `allow_other_designs`, `date`, `time`, `datetime`, `page`, `page_next`, `page_prev`, `random_timed_deltime`, `feed`, `language_text`, `home`, `home_text`, `auto_forward`, `search_index_update`, `search_index_time`) VALUES
(1, '2.alix5', 'http://localhost/fs2/www/', 'admin@admin.de', 'Frogsystem 2', 1, '{title} - {ext}', 'Frogsystem 2 - your way to nature', 'CMS, Content, Management, System, Frog, Alix', 'Sweil, Kermit, rockfest, Wal', 'Frogsystem-Team [http://www.frogsystem.de]', 0, 1, 'lightfrog', 1, 'd.m.Y', 'H:i \\\\U\\\\h\\\\r', 'd.m.Y, H:i \\\\U\\\\h\\\\r', '<div align=\\"center\\" style=\\"width:270px;\\"><div style=\\"width:70px; float:left;\\">{..prev..}&nbsp;</div>Seite <b>{..page_number..}</b> von <b>{..total_pages..}</b><div style=\\"width:70px; float:right;\\">&nbsp;{..next..}</div></div>', '|&nbsp;<a href=\\"{..url..}\\">weiter&nbsp;»</a>', '<a href=\\"{..url..}\\">«&nbsp;zurück</a>&nbsp;|', 604800, 'rss20', 'de_DE', 0, '', 4, 2, 1276781709);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_iplist`
--

DROP TABLE IF EXISTS `fs_iplist`;
CREATE TABLE IF NOT EXISTS `fs_iplist` (
  `ip` varchar(18) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ip`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `fs_iplist`
--

INSERT INTO `fs_iplist` (`ip`) VALUES
('127.0.0.1');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_news`
--

DROP TABLE IF EXISTS `fs_news`;
CREATE TABLE IF NOT EXISTS `fs_news` (
  `news_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `cat_id` smallint(6) DEFAULT NULL,
  `user_id` mediumint(8) DEFAULT NULL,
  `news_date` int(11) DEFAULT NULL,
  `news_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `news_text` text COLLATE utf8_unicode_ci,
  `news_active` tinyint(1) NOT NULL DEFAULT '1',
  `news_comments_allowed` tinyint(1) NOT NULL DEFAULT '1',
  `news_search_update` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`news_id`),
  FULLTEXT KEY `news_title_text` (`news_title`,`news_text`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC AUTO_INCREMENT=143 ;

--
-- Daten für Tabelle `fs_news`
--

INSERT INTO `fs_news` (`news_id`, `cat_id`, `user_id`, `news_date`, `news_title`, `news_text`, `news_active`, `news_comments_allowed`, `news_search_update`) VALUES
(1, 1, 1, 1263251880, 'Hallo Webmaster!', 'Herzlich Willkommen in deinem frisch installierten Frogsystem 2.alix4! Das Frogsystem 2-Team wünscht dir viel Spaß und Erfolg mit deiner Seite. text beispiel\r\n\r\n[center]Weitere Informationen und Hilfe bei Problemen gibt es auf der offiziellen Homepage des Frogsystem 2 und in den zugehörigen Supportforen. Wir haben dir beides unten verlinkt. Schau doch mal vorbei![/center]\r\n\r\nUnd jetzt an die Arbeit! ;-)', 1, 1, 1269453612);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_news_cat`
--

DROP TABLE IF EXISTS `fs_news_cat`;
CREATE TABLE IF NOT EXISTS `fs_news_cat` (
  `cat_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cat_description` text COLLATE utf8_unicode_ci NOT NULL,
  `cat_date` int(11) NOT NULL,
  `cat_user` mediumint(8) NOT NULL DEFAULT '1',
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `fs_news_cat`
--

INSERT INTO `fs_news_cat` (`cat_id`, `cat_name`, `cat_description`, `cat_date`, `cat_user`) VALUES
(1, 'News', '', 1263251923, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_news_comments`
--

DROP TABLE IF EXISTS `fs_news_comments`;
CREATE TABLE IF NOT EXISTS `fs_news_comments` (
  `comment_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `news_id` mediumint(8) DEFAULT NULL,
  `comment_poster` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `comment_poster_id` mediumint(8) DEFAULT NULL,
  `comment_poster_ip` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `comment_date` int(11) DEFAULT NULL,
  `comment_title` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `comment_text` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`comment_id`),
  FULLTEXT KEY `comment_text` (`comment_text`),
  FULLTEXT KEY `comment_title` (`comment_title`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC AUTO_INCREMENT=4 ;

--
-- Daten für Tabelle `fs_news_comments`
--

INSERT INTO `fs_news_comments` (`comment_id`, `news_id`, `comment_poster`, `comment_poster_id`, `comment_poster_ip`, `comment_date`, `comment_title`, `comment_text`) VALUES
(2, 1, 'Hans Wurst', 0, '127.0.0.1', 1266663394, 'Geile Seite!!!', 'Ich liebe euch alle ;)'),
(3, 1, '1', 1, '127.0.0.1', 1270829419, 'me', '\\''sdfsdfSD\\'' FDS\\''f\\''DsF\\''\\''\\\\\\\\\\\\\\\\dßasßdsaß\\\\\\\\ß\\"\\"\\"');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_news_config`
--

DROP TABLE IF EXISTS `fs_news_config`;
CREATE TABLE IF NOT EXISTS `fs_news_config` (
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
  `com_sort` varchar(4) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'DESC',
  `news_headline_lenght` smallint(3) NOT NULL DEFAULT '-1',
  `news_headline_ext` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `acp_per_page` smallint(3) NOT NULL DEFAULT '15',
  `acp_view` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `fs_news_config`
--

INSERT INTO `fs_news_config` (`id`, `num_news`, `num_head`, `html_code`, `fs_code`, `para_handling`, `cat_pic_x`, `cat_pic_y`, `cat_pic_size`, `com_rights`, `com_antispam`, `com_sort`, `news_headline_lenght`, `news_headline_ext`, `acp_per_page`, `acp_view`) VALUES
(1, 10, 5, 2, 4, 4, 150, 150, 1024, 2, 2, 'DESC', 40, ' ...', 15, 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_news_links`
--

DROP TABLE IF EXISTS `fs_news_links`;
CREATE TABLE IF NOT EXISTS `fs_news_links` (
  `news_id` mediumint(8) DEFAULT NULL,
  `link_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `link_name` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `link_url` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `link_target` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`link_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC AUTO_INCREMENT=23 ;

--
-- Daten für Tabelle `fs_news_links`
--

INSERT INTO `fs_news_links` (`news_id`, `link_id`, `link_name`, `link_url`, `link_target`) VALUES
(1, 22, 'Frogsystem 2 Supportforum', 'http://forum.sweil.de/viewforum.php?f=7', 1),
(1, 21, 'Offizielle Frogsystem 2 Homepage', 'http://www.frogsystem.de', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_partner`
--

DROP TABLE IF EXISTS `fs_partner`;
CREATE TABLE IF NOT EXISTS `fs_partner` (
  `partner_id` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
  `partner_name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `partner_link` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `partner_beschreibung` text COLLATE utf8_unicode_ci NOT NULL,
  `partner_permanent` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`partner_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `fs_partner`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_partner_config`
--

DROP TABLE IF EXISTS `fs_partner_config`;
CREATE TABLE IF NOT EXISTS `fs_partner_config` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `fs_partner_config`
--

INSERT INTO `fs_partner_config` (`id`, `partner_anzahl`, `small_x`, `small_y`, `small_allow`, `big_x`, `big_y`, `big_allow`, `file_size`) VALUES
(1, 5, 88, 31, 1, 468, 60, 1, 1024);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_player`
--

DROP TABLE IF EXISTS `fs_player`;
CREATE TABLE IF NOT EXISTS `fs_player` (
  `video_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `video_type` tinyint(1) NOT NULL DEFAULT '1',
  `video_x` text COLLATE utf8_unicode_ci NOT NULL,
  `video_title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `video_lenght` smallint(6) NOT NULL DEFAULT '0',
  `video_desc` text COLLATE utf8_unicode_ci NOT NULL,
  `dl_id` mediumint(8) NOT NULL,
  PRIMARY KEY (`video_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `fs_player`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_player_config`
--

DROP TABLE IF EXISTS `fs_player_config`;
CREATE TABLE IF NOT EXISTS `fs_player_config` (
  `id` tinyint(1) NOT NULL DEFAULT '1',
  `cfg_autoplay` tinyint(1) NOT NULL DEFAULT '1',
  `cfg_autoload` tinyint(1) NOT NULL DEFAULT '1',
  `cfg_buffer` smallint(2) NOT NULL DEFAULT '5',
  `cfg_buffermessage` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Buffering _n_',
  `cfg_buffercolor` varchar(6) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'FFFFFF',
  `cfg_bufferbgcolor` varchar(6) COLLATE utf8_unicode_ci NOT NULL DEFAULT '000000',
  `cfg_buffershowbg` tinyint(1) NOT NULL DEFAULT '1',
  `cfg_titlesize` smallint(2) NOT NULL DEFAULT '20',
  `cfg_titlecolor` varchar(6) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'FFFFFF',
  `cfg_margin` smallint(2) NOT NULL DEFAULT '0',
  `cfg_showstop` tinyint(1) NOT NULL DEFAULT '1',
  `cfg_showvolume` tinyint(1) NOT NULL DEFAULT '1',
  `cfg_showtime` tinyint(1) NOT NULL DEFAULT '1',
  `cfg_showplayer` varchar(8) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'always',
  `cfg_showloading` varchar(8) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'always',
  `cfg_showfullscreen` tinyint(1) NOT NULL DEFAULT '1',
  `cfg_showmouse` varchar(8) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'autohide',
  `cfg_loop` tinyint(1) NOT NULL DEFAULT '0',
  `cfg_playercolor` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `cfg_loadingcolor` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `cfg_bgcolor` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `cfg_bgcolor1` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `cfg_bgcolor2` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `cfg_buttoncolor` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `cfg_buttonovercolor` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `cfg_slidercolor1` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `cfg_slidercolor2` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `cfg_sliderovercolor` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `cfg_loadonstop` tinyint(1) NOT NULL DEFAULT '0',
  `cfg_onclick` varchar(9) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'playpause',
  `cfg_ondoubleclick` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'fullscreen',
  `cfg_playertimeout` mediumint(6) NOT NULL DEFAULT '1500',
  `cfg_videobgcolor` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `cfg_volume` smallint(3) NOT NULL DEFAULT '80',
  `cfg_shortcut` tinyint(1) NOT NULL DEFAULT '0',
  `cfg_playeralpha` smallint(3) NOT NULL DEFAULT '0',
  `cfg_top1_url` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `cfg_top1_x` smallint(4) NOT NULL,
  `cfg_top1_y` smallint(4) NOT NULL,
  `cfg_showiconplay` tinyint(1) NOT NULL DEFAULT '1',
  `cfg_iconplaycolor` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `cfg_iconplaybgcolor` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `cfg_iconplaybgalpha` smallint(3) NOT NULL DEFAULT '100',
  `cfg_showtitleandstartimage` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `fs_player_config`
--

INSERT INTO `fs_player_config` (`id`, `cfg_autoplay`, `cfg_autoload`, `cfg_buffer`, `cfg_buffermessage`, `cfg_buffercolor`, `cfg_bufferbgcolor`, `cfg_buffershowbg`, `cfg_titlesize`, `cfg_titlecolor`, `cfg_margin`, `cfg_showstop`, `cfg_showvolume`, `cfg_showtime`, `cfg_showplayer`, `cfg_showloading`, `cfg_showfullscreen`, `cfg_showmouse`, `cfg_loop`, `cfg_playercolor`, `cfg_loadingcolor`, `cfg_bgcolor`, `cfg_bgcolor1`, `cfg_bgcolor2`, `cfg_buttoncolor`, `cfg_buttonovercolor`, `cfg_slidercolor1`, `cfg_slidercolor2`, `cfg_sliderovercolor`, `cfg_loadonstop`, `cfg_onclick`, `cfg_ondoubleclick`, `cfg_playertimeout`, `cfg_videobgcolor`, `cfg_volume`, `cfg_shortcut`, `cfg_playeralpha`, `cfg_top1_url`, `cfg_top1_x`, `cfg_top1_y`, `cfg_showiconplay`, `cfg_iconplaycolor`, `cfg_iconplaybgcolor`, `cfg_iconplaybgalpha`, `cfg_showtitleandstartimage`) VALUES
(1, 0, 1, 5, 'Buffering _n_', 'FFFFFF', '000000', 1, 20, 'FFFFFF', 5, 1, 1, 1, 'autohide', 'autohide', 1, 'always', 0, '000000', 'FFFF00', 'EEEEEE', '7C7C7C', '333333', 'FFFFFF', 'FFFF00', 'cccccc', '888888', 'FFFF00', 1, 'playpause', 'fullscreen', 1500, '000000', 100, 1, 100, '', 0, 0, 1, 'FFFFFF', '000000', 75, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_poll`
--

DROP TABLE IF EXISTS `fs_poll`;
CREATE TABLE IF NOT EXISTS `fs_poll` (
  `poll_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `poll_quest` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `poll_start` int(11) DEFAULT NULL,
  `poll_end` int(11) DEFAULT NULL,
  `poll_type` tinyint(4) DEFAULT NULL,
  `poll_participants` mediumint(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`poll_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `fs_poll`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_poll_answers`
--

DROP TABLE IF EXISTS `fs_poll_answers`;
CREATE TABLE IF NOT EXISTS `fs_poll_answers` (
  `poll_id` mediumint(8) DEFAULT NULL,
  `answer_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `answer` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `answer_count` mediumint(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`answer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `fs_poll_answers`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_poll_config`
--

DROP TABLE IF EXISTS `fs_poll_config`;
CREATE TABLE IF NOT EXISTS `fs_poll_config` (
  `id` tinyint(1) NOT NULL,
  `answerbar_width` smallint(3) NOT NULL DEFAULT '100',
  `answerbar_type` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `fs_poll_config`
--

INSERT INTO `fs_poll_config` (`id`, `answerbar_width`, `answerbar_type`) VALUES
(1, 100, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_poll_voters`
--

DROP TABLE IF EXISTS `fs_poll_voters`;
CREATE TABLE IF NOT EXISTS `fs_poll_voters` (
  `voter_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `poll_id` mediumint(8) NOT NULL DEFAULT '0',
  `ip_address` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0.0.0.0',
  `time` int(32) NOT NULL DEFAULT '0',
  PRIMARY KEY (`voter_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `fs_poll_voters`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_press`
--

DROP TABLE IF EXISTS `fs_press`;
CREATE TABLE IF NOT EXISTS `fs_press` (
  `press_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `press_title` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `press_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `press_date` int(12) NOT NULL,
  `press_intro` text COLLATE utf8_unicode_ci NOT NULL,
  `press_text` text COLLATE utf8_unicode_ci NOT NULL,
  `press_note` text COLLATE utf8_unicode_ci NOT NULL,
  `press_lang` int(11) NOT NULL,
  `press_game` tinyint(2) NOT NULL,
  `press_cat` tinyint(2) NOT NULL,
  PRIMARY KEY (`press_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `fs_press`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_press_admin`
--

DROP TABLE IF EXISTS `fs_press_admin`;
CREATE TABLE IF NOT EXISTS `fs_press_admin` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`,`type`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Daten für Tabelle `fs_press_admin`
--

INSERT INTO `fs_press_admin` (`id`, `type`, `title`) VALUES
(1, 3, 'Deutsch'),
(2, 3, 'Englisch'),
(3, 2, 'Preview'),
(4, 1, 'Beispiel-Spiel'),
(5, 2, 'Review'),
(6, 2, 'Interview');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_press_config`
--

DROP TABLE IF EXISTS `fs_press_config`;
CREATE TABLE IF NOT EXISTS `fs_press_config` (
  `id` mediumint(8) NOT NULL DEFAULT '1',
  `game_navi` tinyint(1) NOT NULL DEFAULT '0',
  `cat_navi` tinyint(1) NOT NULL DEFAULT '0',
  `lang_navi` tinyint(1) NOT NULL DEFAULT '0',
  `show_press` tinyint(1) NOT NULL DEFAULT '1',
  `show_root` tinyint(1) NOT NULL DEFAULT '0',
  `order_by` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `order_type` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `fs_press_config`
--

INSERT INTO `fs_press_config` (`id`, `game_navi`, `cat_navi`, `lang_navi`, `show_press`, `show_root`, `order_by`, `order_type`) VALUES
(1, 1, 1, 0, 0, 0, 'press_date', 'desc');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_screen`
--

DROP TABLE IF EXISTS `fs_screen`;
CREATE TABLE IF NOT EXISTS `fs_screen` (
  `screen_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `cat_id` smallint(6) unsigned DEFAULT NULL,
  `screen_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`screen_id`),
  KEY `cat_id` (`cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Daten für Tabelle `fs_screen`
--

INSERT INTO `fs_screen` (`screen_id`, `cat_id`, `screen_name`) VALUES
(1, 1, ''),
(2, 1, '22222'),
(3, 1, 'test');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_screen_cat`
--

DROP TABLE IF EXISTS `fs_screen_cat`;
CREATE TABLE IF NOT EXISTS `fs_screen_cat` (
  `cat_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `cat_name` char(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cat_type` tinyint(1) NOT NULL DEFAULT '0',
  `cat_visibility` tinyint(1) NOT NULL DEFAULT '1',
  `cat_date` int(11) NOT NULL DEFAULT '0',
  `randompic` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=FIXED AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `fs_screen_cat`
--

INSERT INTO `fs_screen_cat` (`cat_id`, `cat_name`, `cat_type`, `cat_visibility`, `cat_date`, `randompic`) VALUES
(1, 'Screenshots', 1, 1, 1263252062, 1),
(2, 'Wallpaper', 2, 1, 1263252062, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_screen_config`
--

DROP TABLE IF EXISTS `fs_screen_config`;
CREATE TABLE IF NOT EXISTS `fs_screen_config` (
  `id` tinyint(1) NOT NULL,
  `screen_x` int(4) DEFAULT NULL,
  `screen_y` int(4) DEFAULT NULL,
  `screen_thumb_x` int(4) DEFAULT NULL,
  `screen_thumb_y` int(4) DEFAULT NULL,
  `screen_size` int(4) DEFAULT NULL,
  `screen_rows` int(2) NOT NULL,
  `screen_cols` int(2) NOT NULL,
  `screen_order` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `screen_sort` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `show_type` tinyint(1) NOT NULL DEFAULT '0',
  `show_size_x` smallint(4) NOT NULL DEFAULT '0',
  `show_size_y` smallint(4) NOT NULL DEFAULT '0',
  `show_img_x` int(4) DEFAULT NULL,
  `show_img_y` int(4) DEFAULT NULL,
  `wp_x` int(4) DEFAULT NULL,
  `wp_y` int(4) DEFAULT NULL,
  `wp_thumb_x` int(4) DEFAULT NULL,
  `wp_thumb_y` int(4) DEFAULT NULL,
  `wp_order` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `wp_size` int(4) DEFAULT NULL,
  `wp_rows` int(2) NOT NULL,
  `wp_cols` int(2) NOT NULL,
  `wp_sort` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `fs_screen_config`
--

INSERT INTO `fs_screen_config` (`id`, `screen_x`, `screen_y`, `screen_thumb_x`, `screen_thumb_y`, `screen_size`, `screen_rows`, `screen_cols`, `screen_order`, `screen_sort`, `show_type`, `show_size_x`, `show_size_y`, `show_img_x`, `show_img_y`, `wp_x`, `wp_y`, `wp_thumb_x`, `wp_thumb_y`, `wp_order`, `wp_size`, `wp_rows`, `wp_cols`, `wp_sort`) VALUES
(1, 1500, 1500, 120, 90, 1024, 5, 3, 'id', 'desc', 1, 950, 700, 800, 600, 2000, 2000, 200, 150, 'id', 1536, 6, 2, 'desc');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_screen_random`
--

DROP TABLE IF EXISTS `fs_screen_random`;
CREATE TABLE IF NOT EXISTS `fs_screen_random` (
  `random_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `screen_id` mediumint(8) NOT NULL,
  `start` int(11) NOT NULL,
  `end` int(11) NOT NULL,
  PRIMARY KEY (`random_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `fs_screen_random`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_screen_random_config`
--

DROP TABLE IF EXISTS `fs_screen_random_config`;
CREATE TABLE IF NOT EXISTS `fs_screen_random_config` (
  `id` mediumint(8) NOT NULL DEFAULT '1',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `type_priority` tinyint(1) NOT NULL DEFAULT '1',
  `use_priority_only` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `fs_screen_random_config`
--

INSERT INTO `fs_screen_random_config` (`id`, `active`, `type_priority`, `use_priority_only`) VALUES
(1, 1, 2, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_search_config`
--

DROP TABLE IF EXISTS `fs_search_config`;
CREATE TABLE IF NOT EXISTS `fs_search_config` (
  `id` int(1) NOT NULL,
  `search_num_previews` smallint(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=FIXED;

--
-- Daten für Tabelle `fs_search_config`
--

INSERT INTO `fs_search_config` (`id`, `search_num_previews`) VALUES
(1, 10);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_search_index`
--

DROP TABLE IF EXISTS `fs_search_index`;
CREATE TABLE IF NOT EXISTS `fs_search_index` (
  `search_index_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `search_index_word_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `search_index_type` enum('news','articles','dl') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'news',
  `search_index_document_id` mediumint(8) NOT NULL DEFAULT '0',
  `search_index_count` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`search_index_id`),
  UNIQUE KEY `un_search_index_word_id` (`search_index_word_id`,`search_index_type`,`search_index_document_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=FIXED AUTO_INCREMENT=7341 ;

--
-- Daten für Tabelle `fs_search_index`
--

INSERT INTO `fs_search_index` (`search_index_id`, `search_index_word_id`, `search_index_type`, `search_index_document_id`, `search_index_count`) VALUES
(7273, 118, 'articles', 1, 1),
(7272, 117, 'articles', 1, 2),
(7271, 116, 'articles', 1, 2),
(7270, 115, 'articles', 1, 2),
(7269, 114, 'articles', 1, 2),
(7268, 113, 'articles', 1, 2),
(7267, 112, 'articles', 1, 2),
(7266, 111, 'articles', 1, 1),
(7265, 110, 'articles', 1, 3),
(7264, 109, 'articles', 1, 6),
(7263, 108, 'articles', 1, 2),
(7262, 107, 'articles', 1, 2),
(7261, 106, 'articles', 1, 2),
(7260, 105, 'articles', 1, 2),
(7259, 104, 'articles', 1, 6),
(7258, 103, 'articles', 1, 4),
(7257, 102, 'articles', 1, 2),
(7256, 101, 'articles', 1, 2),
(7255, 100, 'articles', 1, 4),
(7254, 99, 'articles', 1, 2),
(7253, 98, 'articles', 1, 4),
(7252, 97, 'articles', 1, 1),
(7251, 96, 'articles', 1, 1),
(7250, 95, 'articles', 1, 2),
(7249, 94, 'articles', 1, 6),
(7248, 93, 'articles', 1, 1),
(7247, 92, 'articles', 1, 1),
(7246, 91, 'articles', 1, 2),
(7245, 90, 'articles', 1, 4),
(7244, 89, 'articles', 1, 4),
(7243, 88, 'articles', 1, 2),
(7242, 87, 'articles', 1, 2),
(7241, 86, 'articles', 1, 2),
(7240, 85, 'articles', 1, 2),
(7239, 84, 'articles', 1, 2),
(7238, 83, 'articles', 1, 4),
(7237, 82, 'articles', 1, 2),
(7236, 81, 'articles', 1, 3),
(7235, 80, 'articles', 1, 24),
(7234, 79, 'articles', 1, 16),
(7233, 78, 'articles', 1, 1),
(7232, 77, 'articles', 1, 1),
(7231, 76, 'articles', 1, 2),
(7230, 75, 'articles', 1, 2),
(7229, 74, 'articles', 1, 1),
(7228, 73, 'articles', 1, 2),
(7227, 72, 'articles', 1, 2),
(7226, 71, 'articles', 1, 2),
(7225, 70, 'articles', 1, 2),
(7224, 69, 'articles', 1, 2),
(7223, 68, 'articles', 1, 2),
(7222, 67, 'articles', 1, 2),
(7221, 66, 'articles', 1, 3),
(7220, 65, 'articles', 1, 5),
(7219, 64, 'articles', 1, 1),
(7218, 63, 'articles', 1, 1),
(7217, 62, 'articles', 1, 1),
(7216, 61, 'articles', 1, 2),
(7215, 60, 'articles', 1, 1),
(7214, 59, 'articles', 1, 1),
(7213, 58, 'articles', 1, 1),
(7212, 57, 'articles', 1, 1),
(7340, 30, 'news', 1, 1),
(7339, 29, 'news', 1, 1),
(7338, 28, 'news', 1, 1),
(7337, 27, 'news', 1, 1),
(7336, 26, 'news', 1, 1),
(7335, 25, 'news', 1, 1),
(7334, 24, 'news', 1, 1),
(7333, 23, 'news', 1, 1),
(7332, 22, 'news', 1, 1),
(7331, 21, 'news', 1, 1),
(7330, 20, 'news', 1, 1),
(7329, 19, 'news', 1, 1),
(7328, 18, 'news', 1, 1),
(7327, 17, 'news', 1, 1),
(7326, 16, 'news', 1, 1),
(7325, 15, 'news', 1, 1),
(7324, 14, 'news', 1, 1),
(7323, 13, 'news', 1, 1),
(7322, 12, 'news', 1, 1),
(7321, 11, 'news', 1, 2),
(7320, 10, 'news', 1, 1),
(7319, 9, 'news', 1, 1),
(7318, 8, 'news', 1, 1),
(7317, 7, 'news', 1, 3),
(7316, 6, 'news', 1, 1),
(7315, 5, 'news', 1, 1),
(7314, 4, 'news', 1, 1),
(7313, 3, 'news', 1, 1),
(7312, 2, 'news', 1, 1),
(7311, 1, 'news', 1, 1),
(7211, 56, 'articles', 1, 1),
(7210, 55, 'articles', 1, 1),
(7209, 54, 'articles', 1, 1),
(7208, 53, 'articles', 1, 1),
(7207, 52, 'articles', 1, 1),
(7206, 51, 'articles', 1, 1),
(7205, 50, 'articles', 1, 1),
(7204, 49, 'articles', 1, 1),
(7203, 48, 'articles', 1, 1),
(7202, 47, 'articles', 1, 1),
(7201, 46, 'articles', 1, 2),
(7200, 45, 'articles', 1, 1),
(7199, 44, 'articles', 1, 2),
(7198, 43, 'articles', 1, 1),
(7197, 42, 'articles', 1, 2),
(7196, 41, 'articles', 1, 2),
(7195, 40, 'articles', 1, 1),
(7194, 39, 'articles', 1, 1),
(7193, 38, 'articles', 1, 2),
(7192, 37, 'articles', 1, 1),
(7191, 36, 'articles', 1, 2),
(7190, 35, 'articles', 1, 1),
(7189, 34, 'articles', 1, 1),
(7188, 33, 'articles', 1, 1),
(7187, 32, 'articles', 1, 1),
(7186, 31, 'articles', 1, 1),
(7185, 17, 'articles', 1, 1),
(7184, 16, 'articles', 1, 35),
(7183, 14, 'articles', 1, 1),
(7182, 11, 'articles', 1, 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_search_time`
--

DROP TABLE IF EXISTS `fs_search_time`;
CREATE TABLE IF NOT EXISTS `fs_search_time` (
  `search_time_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `search_time_type` enum('news','articles','dl') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'news',
  `search_time_document_id` mediumint(8) NOT NULL,
  `search_time_date` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`search_time_id`),
  UNIQUE KEY `un_search_time_type` (`search_time_type`,`search_time_document_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=FIXED AUTO_INCREMENT=161 ;

--
-- Daten für Tabelle `fs_search_time`
--

INSERT INTO `fs_search_time` (`search_time_id`, `search_time_type`, `search_time_document_id`, `search_time_date`) VALUES
(157, 'news', 1, 1270826777),
(158, 'articles', 1, 1265895157),
(159, 'news', 139, 1265895773),
(160, 'news', 140, 1265895773);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_search_words`
--

DROP TABLE IF EXISTS `fs_search_words`;
CREATE TABLE IF NOT EXISTS `fs_search_words` (
  `search_word_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `search_word` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`search_word_id`),
  UNIQUE KEY `search_word` (`search_word`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=120 ;

--
-- Daten für Tabelle `fs_search_words`
--

INSERT INTO `fs_search_words` (`search_word_id`, `search_word`) VALUES
(1, 'webmaster'),
(2, 'herzlich'),
(3, 'willkommen'),
(4, 'deinem'),
(5, 'frisch'),
(6, 'installierten'),
(7, 'frogsystem'),
(8, 'alix'),
(9, 'team'),
(10, 'wuenscht'),
(11, 'dir'),
(12, 'spass'),
(13, 'erfolg'),
(14, 'deiner'),
(15, 'seite'),
(16, 'text'),
(17, 'beispiel'),
(18, 'informationen'),
(19, 'hilfe'),
(20, 'problemen'),
(21, 'offiziellen'),
(22, 'homepage'),
(23, 'zugehoerigen'),
(24, 'supportforen'),
(25, 'unten'),
(26, 'verlinkt'),
(27, 'schau'),
(28, 'mal'),
(29, 'jetzt'),
(30, 'arbeit'),
(31, 'fscode'),
(32, 'liste'),
(33, 'system'),
(34, 'webseite'),
(35, 'bietet'),
(36, 'moeglichkeit'),
(37, 'einfache'),
(38, 'codes'),
(39, 'besseren'),
(40, 'darstellung'),
(41, 'beitraege'),
(42, 'verwenden'),
(43, 'sogenannten'),
(44, 'fscodes'),
(45, 'erlauben'),
(46, 'html'),
(47, 'formatierungen'),
(48, 'dich'),
(49, 'auskennen'),
(50, 'musst'),
(51, 'hast'),
(52, 'verschiedene'),
(53, 'elemente'),
(54, 'deine'),
(55, 'einzubauen'),
(56, 'bzw'),
(57, 'formatieren'),
(58, 'findest'),
(59, 'uebersicht'),
(60, 'verfuegbaren'),
(61, 'verwendung'),
(62, 'allerdings'),
(63, 'moeglich'),
(64, 'freigeschaltet'),
(65, 'code'),
(66, 'fetter'),
(67, 'kursiver'),
(68, 'unterstrichener'),
(69, 'durchgestrichener'),
(70, 'center'),
(71, 'zentrierter'),
(72, 'font'),
(73, 'schriftart'),
(74, 'arial'),
(75, 'color'),
(76, 'farbcode'),
(77, 'farbe'),
(78, 'rot'),
(79, 'size'),
(80, 'groesse'),
(81, 'nbsp'),
(82, 'noparse'),
(83, 'url'),
(84, 'linkadresse'),
(85, 'http'),
(86, 'www'),
(87, 'example'),
(88, 'com'),
(89, 'linktext'),
(90, 'home'),
(91, 'seitenlink'),
(92, 'localhost'),
(93, 'news'),
(94, 'email'),
(95, 'adresse'),
(96, 'max'),
(97, 'mustermann'),
(98, 'beispieltext'),
(99, 'list'),
(100, 'listenelement'),
(101, 'listenelementlistenelement'),
(102, 'numlist'),
(103, 'quote'),
(104, 'zitat'),
(105, 'quelle'),
(106, 'schrift'),
(107, 'fester'),
(108, 'breite'),
(109, 'img'),
(110, 'bildadresse'),
(111, 'right'),
(112, 'grafik'),
(113, 'rechts'),
(114, 'platziert'),
(115, 'fliesst'),
(116, 'links'),
(117, 'herum'),
(118, 'left'),
(119, 'test');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_shop`
--

DROP TABLE IF EXISTS `fs_shop`;
CREATE TABLE IF NOT EXISTS `fs_shop` (
  `artikel_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `artikel_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `artikel_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `artikel_text` text COLLATE utf8_unicode_ci,
  `artikel_preis` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `artikel_hot` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`artikel_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `fs_shop`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_smilies`
--

DROP TABLE IF EXISTS `fs_smilies`;
CREATE TABLE IF NOT EXISTS `fs_smilies` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `replace_string` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `order` mediumint(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Daten für Tabelle `fs_smilies`
--

INSERT INTO `fs_smilies` (`id`, `replace_string`, `order`) VALUES
(1, ':-)', 1),
(2, ':-(', 2),
(3, ';-)', 3),
(4, ':-P', 4),
(5, 'xD', 5),
(6, ':-o', 6),
(7, '^_^', 7),
(8, ':-/', 10),
(9, ':-]', 9),
(10, '&gt;-(', 8);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_snippets`
--

DROP TABLE IF EXISTS `fs_snippets`;
CREATE TABLE IF NOT EXISTS `fs_snippets` (
  `snippet_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `snippet_tag` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `snippet_text` text COLLATE utf8_unicode_ci NOT NULL,
  `snippet_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`snippet_id`),
  UNIQUE KEY `snippet_tag` (`snippet_tag`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC AUTO_INCREMENT=4 ;

--
-- Daten für Tabelle `fs_snippets`
--

INSERT INTO `fs_snippets` (`snippet_id`, `snippet_tag`, `snippet_text`, `snippet_active`) VALUES
(1, '[%feeds%]', '<p>\r\n  <b>News-Feeds:</b>\r\n</p>\r\n<p align=\\"center\\">\r\n  <a href=\\"$VAR(url)feeds/rss091.php\\" target=\\"_self\\"><img src=\\"$VAR(style_icons)feeds/rss091.gif\\" alt=\\"RSS 0.91\\" title=\\"RSS 0.91\\" border=\\"0\\"></a><br>\r\n  <a href=\\"$VAR(url)feeds/rss10.php\\" target=\\"_self\\"><img src=\\"$VAR(style_icons)feeds/rss10.gif\\" alt=\\"RSS 1.0\\" title=\\"RSS 1.0\\" border=\\"0\\"></a><br>\r\n  <a href=\\"$VAR(url)feeds/rss20.php\\" target=\\"_self\\"><img src=\\"$VAR(style_icons)feeds/rss20.gif\\" alt=\\"RSS 2.0\\" title=\\"RSS 2.0\\" border=\\"0\\"></a><br>\r\n  <a href=\\"$VAR(url)feeds/atom10.php\\" target=\\"_self\\"><img src=\\"$VAR(style_icons)feeds/atom10.gif\\" alt=\\"Atom 1.0\\" title=\\"Atom 1.0\\" border=\\"0\\"></a>\r\n</p>', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_styles`
--

DROP TABLE IF EXISTS `fs_styles`;
CREATE TABLE IF NOT EXISTS `fs_styles` (
  `style_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `style_tag` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `style_allow_use` tinyint(1) NOT NULL DEFAULT '1',
  `style_allow_edit` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`style_id`),
  UNIQUE KEY `style_tag` (`style_tag`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC AUTO_INCREMENT=4 ;

--
-- Daten für Tabelle `fs_styles`
--

INSERT INTO `fs_styles` (`style_id`, `style_tag`, `style_allow_use`, `style_allow_edit`) VALUES
(0, 'default', 0, 0),
(1, 'lightfrog', 1, 1),
(3, 'darkfrog', 0, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_user`
--

DROP TABLE IF EXISTS `fs_user`;
CREATE TABLE IF NOT EXISTS `fs_user` (
  `user_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `user_name` char(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_password` char(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_salt` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `user_mail` char(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_is_staff` tinyint(1) NOT NULL DEFAULT '0',
  `user_group` mediumint(8) NOT NULL DEFAULT '0',
  `user_is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `user_reg_date` int(11) DEFAULT NULL,
  `user_show_mail` tinyint(4) NOT NULL DEFAULT '0',
  `user_homepage` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_icq` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_aim` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_wlm` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_yim` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_skype` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `fs_user`
--

INSERT INTO `fs_user` (`user_id`, `user_name`, `user_password`, `user_salt`, `user_mail`, `user_is_staff`, `user_group`, `user_is_admin`, `user_reg_date`, `user_show_mail`, `user_homepage`, `user_icq`, `user_aim`, `user_wlm`, `user_yim`, `user_skype`) VALUES
(1, 'admin', '6cdd7286f7e3b73008cef8a887bb7b80', 'SWEempPQBm', 'admin@frogsystem.de', 1, 0, 1, 1263252177, 1, 'http://www.frogsystem.de', '', '', '', '', ''),
(2, 'test', 'ae22d0fe766803a13abf01ba5bfab4e4', 'rU1cvt0uz7', 'test', 1, 1, 0, 1268089200, 0, '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_useronline`
--

DROP TABLE IF EXISTS `fs_useronline`;
CREATE TABLE IF NOT EXISTS `fs_useronline` (
  `ip` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` mediumint(8) NOT NULL DEFAULT '0',
  `date` int(30) DEFAULT NULL,
  PRIMARY KEY (`ip`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `fs_useronline`
--

INSERT INTO `fs_useronline` (`ip`, `user_id`, `date`) VALUES
('127.0.0.1', 1, 1276781732);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_user_config`
--

DROP TABLE IF EXISTS `fs_user_config`;
CREATE TABLE IF NOT EXISTS `fs_user_config` (
  `id` tinyint(1) NOT NULL,
  `user_per_page` tinyint(3) NOT NULL,
  `registration_antispam` tinyint(1) NOT NULL DEFAULT '0',
  `avatar_x` smallint(3) NOT NULL DEFAULT '110',
  `avatar_y` smallint(3) NOT NULL DEFAULT '110',
  `avatar_size` smallint(4) NOT NULL DEFAULT '1024',
  `group_pic_x` smallint(3) NOT NULL DEFAULT '250',
  `group_pic_y` smallint(3) NOT NULL DEFAULT '25',
  `group_pic_size` smallint(4) NOT NULL DEFAULT '1024',
  `reg_date_format` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `user_list_reg_date_format` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `fs_user_config`
--

INSERT INTO `fs_user_config` (`id`, `user_per_page`, `registration_antispam`, `avatar_x`, `avatar_y`, `avatar_size`, `group_pic_x`, `group_pic_y`, `group_pic_size`, `reg_date_format`, `user_list_reg_date_format`) VALUES
(1, -1, 1, 110, 110, 20, 250, 25, 50, 'l, j. F Y', 'j. F Y');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_user_groups`
--

DROP TABLE IF EXISTS `fs_user_groups`;
CREATE TABLE IF NOT EXISTS `fs_user_groups` (
  `user_group_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `user_group_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `user_group_description` text COLLATE utf8_unicode_ci,
  `user_group_title` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_group_color` varchar(6) COLLATE utf8_unicode_ci NOT NULL DEFAULT '-1',
  `user_group_highlight` tinyint(1) NOT NULL DEFAULT '0',
  `user_group_date` int(11) NOT NULL,
  `user_group_user` mediumint(8) NOT NULL DEFAULT '1',
  PRIMARY KEY (`user_group_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `fs_user_groups`
--

INSERT INTO `fs_user_groups` (`user_group_id`, `user_group_name`, `user_group_description`, `user_group_title`, `user_group_color`, `user_group_highlight`, `user_group_date`, `user_group_user`) VALUES
(0, 'Administrator', '', 'Chef vom Dienst', '008800', 1, 1223676000, 1),
(1, 'Mitarbeiter', NULL, NULL, '-1', 0, 1268131619, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_user_permissions`
--

DROP TABLE IF EXISTS `fs_user_permissions`;
CREATE TABLE IF NOT EXISTS `fs_user_permissions` (
  `perm_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `x_id` mediumint(8) NOT NULL,
  `perm_for_group` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`perm_id`,`x_id`,`perm_for_group`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `fs_user_permissions`
--

INSERT INTO `fs_user_permissions` (`perm_id`, `x_id`, `perm_for_group`) VALUES
('fscode_add', 2, 0),
('news_add', 1, 1),
('news_cat', 1, 1),
('news_comments', 1, 1),
('news_delete', 1, 1),
('news_edit', 1, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_wallpaper`
--

DROP TABLE IF EXISTS `fs_wallpaper`;
CREATE TABLE IF NOT EXISTS `fs_wallpaper` (
  `wallpaper_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `wallpaper_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `wallpaper_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cat_id` mediumint(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`wallpaper_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci PACK_KEYS=1 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `fs_wallpaper`
--

INSERT INTO `fs_wallpaper` (`wallpaper_id`, `wallpaper_name`, `wallpaper_title`, `cat_id`) VALUES
(1, 'test', 'test', 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_wallpaper_sizes`
--

DROP TABLE IF EXISTS `fs_wallpaper_sizes`;
CREATE TABLE IF NOT EXISTS `fs_wallpaper_sizes` (
  `size_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `wallpaper_id` mediumint(8) NOT NULL DEFAULT '0',
  `size` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`size_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci PACK_KEYS=1 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `fs_wallpaper_sizes`
--

INSERT INTO `fs_wallpaper_sizes` (`size_id`, `wallpaper_id`, `size`) VALUES
(1, 1, '1920x1200');
