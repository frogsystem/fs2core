-- phpMyAdmin SQL Dump
-- version 3.1.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 06. Mai 2010 um 22:09
-- Server Version: 5.1.30
-- PHP-Version: 5.2.8

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
CREATE TABLE `fs_admin_cp` (
  `page_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `group_id` mediumint(8) NOT NULL,
  `page_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `page_link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `page_file` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `page_pos` tinyint(3) NOT NULL DEFAULT '0',
  `page_int_sub_perm` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`page_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `fs_admin_cp`
--

INSERT INTO `fs_admin_cp` (`page_id`, `group_id`, `page_title`, `page_link`, `page_file`, `page_pos`, `page_int_sub_perm`) VALUES
('start_general', -1, 'Allgemein', 'general', 'start_general.php', 1, 0),
('start_content', -1, 'Inhalt', 'content', 'start_content.php', 2, 0),
('start_media', -1, 'Media', 'media', 'start_media.php', 3, 0),
('start_interactive', -1, 'Interaktiv', 'interactive', 'start_interactive.php', 4, 0),
('start_promo', -1, 'Promotion', 'promo', 'start_promo.php', 5, 0),
('start_user', -1, 'User', 'user', 'start_user.php', 6, 0),
('start_styles', -1, 'Styles', 'styles', 'start_styles.php', 7, 0),
('start_system', -1, 'System', 'system', 'start_system.php', 8, 0),
('start_mods', -1, 'AddOns', 'mods', 'start_mods.php', 9, 0),
('zone_config', 0, 'Konfiguration ändern', 'Konfiguration', 'admin_zone_config.php', 1, 0),
('zone_create', 0, 'erstellen', 'erstellen', 'admin_zone_create.php', 2, 0),
('zone_admin', 0, 'verwalten', 'verwalten', 'admin_zone_manage.php', 3, 0),
('gen_config', 1, 'Seitenkonfiguration', 'Konfiguration', 'admin_general_config.php', 1, 0),
('gen_announcement', 1, 'Ankündigung', 'Ankündigung', 'admin_allannouncement.php', 2, 0),
('gen_captcha', 1, 'Captcha Konfiguration', 'Captcha', 'admin_captcha_config.php', 2, 0),
('gen_emails', 1, 'E-Mail-Vorlagen bearbeiten', 'E-Mails', 'admin_allemail.php', 4, 0),
('gen_phpinfo', 1, 'PHP & Server Informationen', 'PHP Info', 'admin_allphpinfo.php', 5, 0),
('editor_config', 2, 'Konfiguration ändern', 'Konfiguration', 'admin_editor_config.php', 1, 0),
('editor_design', 2, 'Darstellung bearbeiten', 'Darstellung', 'admin_editor_design.php', 2, 0),
('editor_smilies', 2, 'Smilies verwalten', 'Smilies', 'admin_editor_smilies.php', 3, 0),
('editor_fscodes', 2, 'FSCodes bearbeiten', 'FSCodes', 'admin_editor_fscode.php', 4, 0),
('stat_view', 3, 'anzeigen', 'anzeigen', 'admin_statview.php', 1, 0),
('stat_edit', 3, 'bearbeiten', 'bearbeiten', 'admin_statedit.php', 2, 0),
('stat_ref', 3, 'Referrer anzeigen & verwalten', 'Referrer', 'admin_statref.php', 3, 0),
('stat_space', 3, 'Speicherplatz Übersicht', 'Speicherplatz', 'admin_statspace.php', 4, 0),
('news_config', 5, 'Konfiguration ändern', 'Konfiguration', 'admin_news_config.php', 1, 0),
('news_add', 5, 'schreiben', 'schreiben', 'admin_news_add.php', 2, 0),
('news_edit', 5, 'bearbeiten', 'bearbeiten', 'admin_news_edit.php', 3, 0),
('news_cat', 5, 'Kategorien verwalten', 'Kategorien', 'admin_news_cat.php', 4, 0),
('news_delete', 5, 'löschen', 'löschen', 'news_edit', 1, 1),
('news_comments', 5, 'Kommentare', 'Kommentare', 'news_edit', 2, 1),
('articles_config', 6, 'Konfiguration ändern', 'Konfiguration', 'admin_articles_config.php', 1, 0),
('articles_add', 6, 'schreiben', 'schreiben', 'admin_articles_add.php', 2, 0),
('articles_edit', 6, 'bearbeiten', 'bearbeiten', 'admin_articles_edit.php', 3, 0),
('articles_cat', 6, 'Kategorien verwalten', 'Kategorien', 'admin_articles_cat.php', 4, 0),
('press_config', 7, 'Konfiguration ändern', 'Konfiguration', 'admin_press_config.php', 1, 0),
('press_add', 7, 'hinzufügen', 'hinzufügen', 'admin_press_add.php', 2, 0),
('press_edit', 7, 'bearbeiten', 'bearbeiten', 'admin_press_edit.php', 3, 0),
('press_admin', 7, 'Verwaltung', 'Verwaltung', 'admin_press_admin.php', 4, 0),
('cimg_add', 8, 'hinzufügen', 'hinzufügen', 'admin_cimg.php', 1, 0),
('cimg_admin', 8, 'verwalten', 'verwalten', 'admin_cimgdel.php', 2, 0),
('gallery_config', 9, 'Konfiguration ändern', 'Konfiguration', 'admin_screenconfig.php', 1, 0),
('gallery_cat', 9, 'Kategorien verwalten', 'Kategorien', 'admin_screencat.php', 2, 0),
('gallery_newcat', 9, 'Neue Kategorie', 'Neue Kategorie', 'admin_screennewcat.php', 3, 0),
('screens_add', 10, 'hinzufügen', 'hinzufügen', 'admin_screenadd.php', 1, 0),
('screens_edit', 10, 'bearbeiten', 'bearbeiten', 'admin_screenedit.php', 2, 0),
('wp_add', 11, 'hinzufügen', 'hinzufügen', 'admin_wallpaperadd.php', 1, 0),
('wp_edit', 11, 'bearbeiten', 'bearbeiten', 'admin_wallpaperedit.php', 2, 0),
('randompic_config', 12, 'Konfiguration ändern', 'Konfiguration', 'admin_randompic_config.php', 1, 0),
('randompic_cat', 12, 'Kategorien auswählen', 'Kategorie Auswahl', 'admin_randompic_cat.php', 2, 0),
('timedpic_add', 13, 'hinzufügen', 'hinzufügen', 'admin_randompic_time_add.php', 1, 0),
('timedpic_edit', 13, 'verwalten', 'verwalten', 'admin_randompic_time.php', 2, 0),
('dl_config', 14, 'Konfiguration ändern', 'Konfiguration', 'admin_dlconfig.php', 1, 0),
('dl_add', 14, 'hinzufügen', 'hinzufügen', 'admin_dladd.php', 2, 0),
('dl_edit', 14, 'bearbeiten', 'bearbeiten', 'admin_dledit.php', 3, 0),
('dl_cat', 14, 'Kategorien verwalten', 'Kategorien', 'admin_dlcat.php', 4, 0),
('dl_newcat', 14, 'Neue Kategorie', 'Neue Kategorie', 'admin_dlnewcat.php', 5, 0),
('player_config', 15, 'Konfiguration ändern', 'Konfiguration', 'admin_player_config.php', 1, 0),
('player_add', 15, 'hinzufügen', 'hinzufügen', 'admin_player_add.php', 2, 0),
('player_edit', 15, 'bearbeiten', 'bearbeiten', 'admin_player_edit.php', 3, 0),
('poll_config', 16, 'Konfiguration ändern', 'Konfiguration', 'admin_pollconfig.php', 1, 0),
('poll_add', 16, 'hinzufügen', 'hinzufügen', 'admin_polladd.php', 2, 0),
('poll_edit', 16, 'bearbeiten', 'bearbeiten', 'admin_polledit.php', 3, 0),
('partner_config', 18, 'Konfiguration ändern', 'Konfiguration', 'admin_partnerconfig.php', 1, 0),
('partner_add', 18, 'hinzufügen', 'hinzufügen', 'admin_partneradd.php', 2, 0),
('partner_edit', 18, 'bearbeiten', 'bearbeiten', 'admin_partneredit.php', 3, 0),
('shop_add', 19, 'Produkt hinzufügen', 'Neues Produkt', 'admin_shopadd.php', 1, 0),
('shop_edit', 19, 'Produkt Übersicht', 'Übersicht', 'admin_shopedit.php', 2, 0),
('user_config', 20, 'Kofiguration ändern', 'Kofiguration', 'admin_user_config.php', 1, 0),
('user_add', 20, 'hinzufügen', 'hinzufügen', 'admin_user_add.php', 2, 0),
('user_edit', 20, 'bearbeiten', 'bearbeiten', 'admin_user_edit.php', 3, 0),
('user_rights', 20, 'Rechte ändern', 'Rechte', 'admin_user_rights.php', 4, 0),
('style_add', 21, 'erstellen', 'erstellen', 'admin_style_add.php', 1, 0),
('style_management', 21, 'verwalten', 'verwalten', 'admin_style_management.php', 2, 0),
('style_css', 21, 'CSS-Dateien bearbeiten', 'CSS-Dateien', 'admin_template_css.php', 3, 0),
('style_js', 21, 'Java Script-Dateien bearbeiten', 'JS-Dateien', 'admin_template_js.php', 4, 0),
('style_nav', 21, 'Navigations-Dateien bearbeiten', 'Navigationen', 'admin_template_nav.php', 5, 0),
('tpl_general', 22, '„Allgemein“ bearbeiten', 'Allgemein', 'admin_template_general.php', 1, 0),
('tpl_user', 22, '„Benutzer“ bearbeiten', 'Benutzer', 'admin_template_user.php', 2, 0),
('tpl_articles', 22, '„Artikel“ bearbeiten', 'Artikel', 'admin_template_articles.php', 3, 0),
('tpl_news', 22, '„News“ bearbeiten', 'News', 'admin_template_news.php', 3, 0),
('tpl_poll', 22, '„Umfragen“ bearbeiten', 'Umfragen', 'admin_template_poll.php', 4, 0),
('tpl_press', 22, '„Presseberichte“ bearbeiten', 'Presseberichte', 'admin_template_press.php', 5, 0),
('tpl_screens', 22, '„Screenshots“ bearbeiten', 'Screenshots', 'admin_template_screenshot.php', 6, 0),
('tpl_wp', 22, '„Wallpaper“ bearbeiten', 'Wallpaper', 'admin_template_wallpaper.php', 7, 0),
('tpl_previewimg', 22, '„Vorschaubild“ bearbeiten', 'Vorschaubild', 'admin_template_previewimg.php', 8, 0),
('tpl_dl', 22, '„Downloads“ bearbeiten', 'Downloads', 'admin_template_dl.php', 9, 0),
('tpl_shop', 22, '„Shop“ bearbeiten', 'Shop', 'admin_template_shop.php', 10, 0),
('tpl_affiliates', 22, '„Partnerseiten“ bearbeiten', 'Partnerseiten', 'admin_template_affiliates.php', 11, 0),
('tpl_editor', 22, '„Editor“ bearbeiten', 'Editor', 'admin_editor_design.php', 13, 0),
('tpl_fscodes', 22, '„FSCodes“ bearbeiten', 'FSCodes', 'admin_editor_fscode.php', 14, 0),
('group_config', 23, 'Konfiguration ändern', 'Konfiguration', 'admin_group_config.php', 1, 0),
('group_admin', 23, 'Gruppenverwaltung', 'verwalten', 'admin_group_admin.php', 2, 0),
('group_rights', 23, 'Rechte ändern', 'Rechte', 'admin_group_rights.php', 3, 0),
('applets_add', 24, 'hinzufügen', 'hinzufügen', 'admin_applets_add.php', 1, 0),
('applets_edit', 24, 'bearbeiten', 'bearbeiten', 'admin_applets_edit.php', 2, 0),
('applets_delete', 24, 'löschen', 'löschen', 'applets_edit', 1, 1),
('snippets_add', 25, 'hinzufügen', 'hinzufügen', 'admin_snippets_add.php', 1, 0),
('snippets_edit', 25, 'bearbeiten', 'bearbeiten', 'admin_snippets_edit.php', 2, 0),
('snippets_delete', 25, 'löschen', 'löschen', 'snippets_edit', 1, 1),
('aliases_add', 26, 'hinzufügen', 'hinzufügen', 'admin_aliases_add.php', 1, 0),
('aliases_edit', 26, 'bearbeiten', 'bearbeiten', 'admin_aliases_edit.php', 2, 0),
('aliases_delete', 26, 'löschen', 'löschen', 'aliases_edit', 1, 1),
('tpl_search', 22, '„Suche“ bearbeiten', 'Suche', 'admin_template_search.php', 3, 0),
('search_config', 27, 'Konfiguration', 'Konfiguration', 'admin_search_config.php', 1, 0),
('search_index', 27, 'Suchindex', 'Suchindex', 'admin_search_index.php', 2, 0),
('tpl_player', 22, '„Flash-Player“ bearbeiten', 'Flash-Player', 'admin_template_player.php', 20, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_admin_groups`
--

DROP TABLE IF EXISTS `fs_admin_groups`;
CREATE TABLE `fs_admin_groups` (
  `group_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `group_title` text COLLATE utf8_unicode_ci NOT NULL,
  `menu_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `group_pos` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC AUTO_INCREMENT=28 ;

--
-- Daten für Tabelle `fs_admin_groups`
--

INSERT INTO `fs_admin_groups` (`group_id`, `group_title`, `menu_id`, `group_pos`) VALUES
(-1, 'Startseite', 'none', 0),
(0, 'hidden', 'none', 0),
(1, 'Allgemein', 'general', 1),
(2, 'Editor', 'general', 2),
(3, 'Statistik', 'general', 3),
(4, 'Includes', 'system', 1),
(5, 'News', 'content', 1),
(6, 'Artikel', 'content', 2),
(7, 'Presseberichte', 'content', 3),
(8, 'Inhaltsbilder', 'content', 4),
(9, 'Galerie', 'media', 1),
(10, 'Galerie-Bilder', 'media', 2),
(11, 'Wallpaper', 'media', 3),
(12, 'Zufallsbilder', 'media', 4),
(13, 'Zeitgesteuerte ZB', 'media', 5),
(14, 'Downloads', 'media', 6),
(15, 'Videos', 'media', 7),
(16, 'Umfragen', 'interactive', 1),
(17, 'Community Map', 'interactive', 2),
(18, 'Partnerseiten', 'promo', 1),
(19, 'Shop', 'promo', 2),
(20, 'Benutzer', 'user', 1),
(21, 'Styles', 'styles', 1),
(22, 'Templates', 'styles', 2),
(23, 'Gruppen', 'user', 2),
(24, 'Applets', 'system', 2),
(25, 'Schnipsel', 'system', 3),
(26, 'Aliasse', 'system', 1),
(27, 'Suche', 'general', 4);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_aliases`
--

DROP TABLE IF EXISTS `fs_aliases`;
CREATE TABLE `fs_aliases` (
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
CREATE TABLE `fs_announcement` (
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
CREATE TABLE `fs_applets` (
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
CREATE TABLE `fs_articles` (
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
CREATE TABLE `fs_articles_cat` (
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
CREATE TABLE `fs_articles_config` (
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
CREATE TABLE `fs_captcha_config` (
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
CREATE TABLE `fs_counter` (
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
(1, 46, 3621, 2, 1, 2, 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_counter_ref`
--

DROP TABLE IF EXISTS `fs_counter_ref`;
CREATE TABLE `fs_counter_ref` (
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
('http://localhost/fs2/', 98, 1263499887, 1271879785),
('http://alix.worldofgothic.com/beta4/admin/?go=gen_config', 2, 1267197504, 1267197505),
('http://demo.frogsystem.de/admin/?go=gen_config', 1, 1267198063, 1267198063);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_counter_stat`
--

DROP TABLE IF EXISTS `fs_counter_stat`;
CREATE TABLE `fs_counter_stat` (
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
(2010, 4, 21, 1, 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_dl`
--

DROP TABLE IF EXISTS `fs_dl`;
CREATE TABLE `fs_dl` (
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
CREATE TABLE `fs_dl_cat` (
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
CREATE TABLE `fs_dl_config` (
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
CREATE TABLE `fs_dl_files` (
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
-- Tabellenstruktur für Tabelle `fs_editor_config`
--

DROP TABLE IF EXISTS `fs_editor_config`;
CREATE TABLE `fs_editor_config` (
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
CREATE TABLE `fs_email` (
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
-- Tabellenstruktur für Tabelle `fs_global_config`
--

DROP TABLE IF EXISTS `fs_global_config`;
CREATE TABLE `fs_global_config` (
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
  `show_favicon` tinyint(1) NOT NULL DEFAULT '1',
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
(1, '2.alix5', 'http://localhost/fs2/www/', 'admin@admin.de', 'Frogsystem 2', 1, '{title} - {ext}', 'Frogsystem 2 - your way to nature', 'CMS, Content, Management, System, Frog, Alix', 'Sweil, Kermit, rockfest, Wal', 'Frogsystem-Team [http://www.frogsystem.de]', 0, 1, 'lightfrog', 1, 'd.m.Y', 'H:i \\\\U\\\\h\\\\r', 'd.m.Y, H:i \\\\U\\\\h\\\\r', '<div align=\\"center\\" style=\\"width:270px;\\"><div style=\\"width:70px; float:left;\\">{..prev..}&nbsp;</div>Seite <b>{..page_number..}</b> von <b>{..total_pages..}</b><div style=\\"width:70px; float:right;\\">&nbsp;{..next..}</div></div>', '|&nbsp;<a href=\\"{..url..}\\">weiter&nbsp;»</a>', '<a href=\\"{..url..}\\">«&nbsp;zurück</a>&nbsp;|', 604800, 'rss20', 'de_DE', 0, '', 4, 2, 1271879785);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_iplist`
--

DROP TABLE IF EXISTS `fs_iplist`;
CREATE TABLE `fs_iplist` (
  `ip` varchar(18) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ip`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `fs_iplist`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_news`
--

DROP TABLE IF EXISTS `fs_news`;
CREATE TABLE `fs_news` (
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
CREATE TABLE `fs_news_cat` (
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
CREATE TABLE `fs_news_comments` (
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
CREATE TABLE `fs_news_config` (
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
CREATE TABLE `fs_news_links` (
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
CREATE TABLE `fs_partner` (
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
CREATE TABLE `fs_partner_config` (
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
CREATE TABLE `fs_player` (
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
CREATE TABLE `fs_player_config` (
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
CREATE TABLE `fs_poll` (
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
CREATE TABLE `fs_poll_answers` (
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
CREATE TABLE `fs_poll_config` (
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
CREATE TABLE `fs_poll_voters` (
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
CREATE TABLE `fs_press` (
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
CREATE TABLE `fs_press_admin` (
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
CREATE TABLE `fs_press_config` (
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
CREATE TABLE `fs_screen` (
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
CREATE TABLE `fs_screen_cat` (
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
CREATE TABLE `fs_screen_config` (
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
CREATE TABLE `fs_screen_random` (
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
CREATE TABLE `fs_screen_random_config` (
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
CREATE TABLE `fs_search_config` (
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
CREATE TABLE `fs_search_index` (
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
CREATE TABLE `fs_search_time` (
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
CREATE TABLE `fs_search_words` (
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
CREATE TABLE `fs_shop` (
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
CREATE TABLE `fs_smilies` (
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
CREATE TABLE `fs_snippets` (
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
CREATE TABLE `fs_styles` (
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
CREATE TABLE `fs_user` (
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
CREATE TABLE `fs_useronline` (
  `ip` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` mediumint(8) NOT NULL DEFAULT '0',
  `date` int(30) DEFAULT NULL,
  PRIMARY KEY (`ip`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `fs_useronline`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_user_config`
--

DROP TABLE IF EXISTS `fs_user_config`;
CREATE TABLE `fs_user_config` (
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
CREATE TABLE `fs_user_groups` (
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
CREATE TABLE `fs_user_permissions` (
  `perm_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `x_id` mediumint(8) NOT NULL,
  `perm_for_group` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`perm_id`,`x_id`,`perm_for_group`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `fs_user_permissions`
--

INSERT INTO `fs_user_permissions` (`perm_id`, `x_id`, `perm_for_group`) VALUES
('news_add', 1, 1),
('news_add', 2, 0),
('news_cat', 1, 1),
('news_comments', 1, 1),
('news_delete', 1, 1),
('news_edit', 1, 1),
('news_edit', 2, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_wallpaper`
--

DROP TABLE IF EXISTS `fs_wallpaper`;
CREATE TABLE `fs_wallpaper` (
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
CREATE TABLE `fs_wallpaper_sizes` (
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
