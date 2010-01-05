-- phpMyAdmin SQL Dump
-- version 3.1.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 05. Januar 2010 um 19:30
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
('aliases_delete', 26, 'löschen', 'löschen', 'aliases_edit', 1, 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC AUTO_INCREMENT=27 ;

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
(26, 'Aliasse', 'system', 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=12 ;

--
-- Daten für Tabelle `fs_aliases`
--

INSERT INTO `fs_aliases` (`alias_id`, `alias_go`, `alias_forward_to`, `alias_active`) VALUES
(1, 'screenshots', 'gallery', 1),
(2, 'wallpaper', 'gallery', 1),
(3, 'profil', 'user', 1),
(4, 'editprofil', 'user_edit', 1),
(5, 'members', 'user_list', 1),
(11, 'partner', 'affiliates', 1);

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
(1, '', 2, 0, 1, 1, 0);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC AUTO_INCREMENT=16 ;

--
-- Daten für Tabelle `fs_applets`
--

INSERT INTO `fs_applets` (`applet_id`, `applet_file`, `applet_active`, `applet_output`) VALUES
(7, 'affiliates', 1, 1),
(13, 'user-menu', 1, 1),
(8, 'announcement', 1, 1),
(9, 'mini-statistics', 1, 1),
(10, 'poll-system', 1, 1),
(11, 'preview-image', 1, 1),
(12, 'shop-system', 1, 1),
(15, 'dl-forwarding', 1, 0);

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
  PRIMARY KEY (`article_id`),
  KEY `article_url` (`article_url`),
  FULLTEXT KEY `article_search` (`article_title`,`article_text`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `fs_articles`
--

INSERT INTO `fs_articles` (`article_id`, `article_url`, `article_title`, `article_date`, `article_user`, `article_text`, `article_html`, `article_fscode`, `article_para`, `article_cat_id`) VALUES
(1, 'fscode', 'FSCode Liste', 1262127600, 1, 'Das System dieser Webseite bietet dir die Möglichkeit einfache Codes zur besseren Darstellung deiner Beiträge zu verwenden. Diese sogenannten [b]FSCodes[/b] erlauben dir daher HTML-Formatierungen zu verwenden, ohne dass du dich mit HTML auskennen musst. Mit ihnen hast du die Möglichkeit verschiedene Elemente in deine Beiträge einzubauen bzw. ihren Text zu formatieren.\r\n\r\nHier findest du eine [b]Übersicht über alle verfügbaren FSCodes[/b] und ihre Verwendung. Allerdings ist es möglich, dass nicht alle Codes zur Verwendung freigeschaltet sind.\r\n\r\n<table width=\\"100%\\" cellpadding=\\"0\\" cellspacing=\\"10\\" border=\\"0\\"><tr><td width=\\"50%\\">[b][u][size=3]FS-Code:[/size][/u][/b]</td><td width=\\"50%\\">[b][u][size=3]Beispiel:[/size][/u][/b]</td></tr><tr><td>[noparse][b]fetter Text[/b][/noparse]</td><td>[b]fetter Text[/b]</td></tr><tr><td>[noparse][i]kursiverText[/i][/noparse]</td><td>[i]kursiver Text[/i]</td></tr><tr><td>[noparse][u]unterstrichener Text[u][/noparse]</td><td>[u]unterstrichener Text[/u]</td></tr><tr><td>[noparse][s]durchgestrichener Text[/s][/noparse]</td><td>[s]durchgestrichener Text[/s]</td></tr><tr><td>[noparse][center]zentrierter Text[/center][/noparse]</td><td>[center]zentrierter Text[/center]</td></tr><tr><td>[noparse][font=Schriftart]Text in Schriftart[/font][/noparse]</td><td>[font=Arial]Text in Arial[/font]</td></tr><tr><td>[noparse][color=Farbcode]Text in Farbe[/color][/noparse]</td><td>[color=#FF0000]Text in Rot (Farbcode: #FF0000)[/color]</td></tr><tr><td>[noparse][size=Größe]Text in Größe 0[/size][/noparse]</td><td>[size=0]Text in Größe 0[/size]</td></tr><tr><td>[noparse][size=Größe]Text in Größe 1[/size][/noparse]</td><td>[size=1]Text in Größe 1[/size]</td></tr><tr><td>[noparse][size=Größe]Text in Größe 2[/size][/noparse]</td><td>[size=2]Text in Größe 2[/size]</td></tr><tr><td>[noparse][size=Größe]Text in Größe 3[/size][/noparse]</td><td>[size=3]Text in Größe 3[/size]</td></tr><tr><td>[noparse][size=Größe]Text in Größe 4[/size][/noparse]</td><td>[size=4]Text in Größe 4[/size]</td></tr><tr><td>[noparse][size=Größe]Text in Größe 5[/size][/noparse]</td><td>[size=5]Text in Größe 5[/size]</td></tr><tr><td>[noparse][size=Größe]Text in Größe 6[/size][/noparse]</td><td>[size=6]Text in Größe 6[/size]</td></tr><tr><td>[noparse][size=Größe]Text in Größe 7[/size][/noparse]</td><td>[size=7]Text&nbsp;in&nbsp;Größe&nbsp;7[/size]</td></tr><tr><td>[noparse][noparse]Text mit [b]FS[/b]Code[/noparse][/noparse]</td><td>[noparse]kein [b]fetter[/b] Text[/noparse]</td></tr> <tr><td colspan=\\"2\\"><hr /></td></tr> <tr><td>[noparse][url]Linkadresse[/url][/noparse]</td><td>[url]http://www.example.com[/url]</td></tr> <tr><td>[noparse][url=Linkadresse]Linktext[/url][/noparse]</td><td>[url=http://www.example.com]Linktext[/url]</td></tr> <tr><td>[noparse][home]Seitenlink[/home][/noparse]</td><td>[home]news[/home]</td></tr> <tr><td>[noparse][home=Seitenlink]Linktext[/home][/noparse]</td><td>[home=news]Linktext[/home]</td></tr> <tr><td>[noparse][email]Email-Adresse[/email][/noparse]</td><td>[email]max.mustermann@example.com[/email]</td></tr> <tr><td>[noparse][email=Email-Adresse]Beispieltext[/email][/noparse]</td><td>[email=max.mustermann@example.com]Beispieltext[/email]</td></tr> <tr><td colspan=\\"2\\"><hr /></td></tr> <tr><td>[noparse][list]<br>[*]Listenelement<br>[*]Listenelement<br>[/list][/noparse]</td><td>[list]<br>[*]Listenelement<br>[*]Listenelement<br>[/list]</td></tr> <tr><td>[noparse][numlist]<br>[*]Listenelement<br>[*]Listenelement<br>[/numlist][/noparse]</td><td>[numlist]<br>[*]Listenelement<br>[*]Listenelement<br>[/numlist]</td></tr> <tr><td>[noparse][quote]Ein Zitat[/quote][/noparse]</td><td>[quote]Ein Zitat[/quote]</td></tr><tr><td>[noparse][quote=Quelle]Ein Zitat[/quote][/noparse]</td><td>[quote=Quelle]Ein Zitat[/quote]</td></tr><tr><td>[noparse][code]Schrift mit fester Breite[/code][/noparse]</td><td>[code]Schrift mit fester Breite[/code]</td></tr><tr><td colspan=\\"2\\"><hr /></td></tr><tr><td>[noparse][img]Bildadresse[/img][/noparse]</td><td>[img]$VAR(url)images/icons/logo.gif[/img]</td></tr><tr><td>[noparse][img=right]Bildadresse[/img][/noparse]</td><td>[img=right]$VAR(url)images/icons/logo.gif[/img] Das hier ist ein Beispieltext. Die Grafik ist rechts platziert und der Text fließt links um sie herum.</td></tr><tr><td>[noparse][img=left]Bildadresse[/img][/noparse]</td><td>[img=left]$VAR(url)images/icons/logo.gif[/img] Das hier ist ein Beispieltext. Die Grafik ist links platziert und der Text fließt rechts um sie herum.</td></tr></table>', 1, 1, 1, 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

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
(1, 2, 4, 2, 150, 150, 1024, 1, 1, 'DESC', 15, 2);

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
(1, 'FFFFFF', 1, '000000', 1, 5, 1, 5, 1, 1, 1, 1, 58, 18, 0, 1, 1, 0, 0, 3, '');

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
(1, 108, 5418, 6, 1, 2, 2);

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
('http://localhost/fs2/', 231, 1223919890, 1262706816),
('http://sweil.dyndns.org/fs2/', 1, 1231250810, 1231250810),
('http://sweil.dyndns.org/fs2/www/', 1, 1231250815, 1231250815),
('http://localhost/', 1, 1235171569, 1235171569),
('http://localhost/fs2/src/', 3, 1259448679, 1259448933);

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
(2008, 10, 13, 1, 8),
(2008, 11, 18, 2, 54),
(2009, 1, 6, 2, 44),
(2009, 1, 8, 1, 9),
(2009, 1, 10, 1, 9),
(2009, 1, 11, 2, 4),
(2009, 1, 25, 1, 2),
(2009, 2, 5, 1, 1),
(2009, 2, 13, 1, 2),
(2009, 2, 19, 1, 2),
(2009, 2, 20, 1, 2),
(2009, 2, 21, 1, 1),
(2009, 2, 23, 1, 4),
(2009, 4, 23, 1, 2),
(2009, 4, 24, 3, 86),
(2009, 4, 27, 1, 7),
(2009, 5, 16, 1, 102),
(2009, 5, 18, 1, 188),
(2009, 5, 22, 2, 179),
(2009, 6, 7, 1, 2),
(2009, 6, 11, 1, 2),
(2009, 6, 12, 1, 4),
(2009, 6, 20, 1, 1),
(2009, 6, 21, 1, 1),
(2009, 7, 2, 1, 1),
(2009, 7, 3, 1, 1),
(2009, 7, 11, 2, 10),
(2009, 7, 13, 1, 3),
(2009, 7, 17, 1, 1),
(2009, 7, 20, 1, 1),
(2009, 7, 24, 1, 1),
(2009, 8, 24, 1, 14),
(2009, 9, 17, 1, 5),
(2009, 9, 18, 3, 37),
(2009, 9, 21, 1, 1),
(2009, 9, 24, 1, 3),
(2009, 9, 25, 1, 1),
(2009, 9, 29, 1, 1),
(2009, 10, 1, 2, 2),
(2009, 10, 2, 1, 25),
(2009, 10, 5, 1, 2),
(2009, 10, 6, 1, 31),
(2009, 10, 7, 1, 2),
(2009, 10, 8, 1, 1),
(2009, 10, 9, 1, 2),
(2009, 10, 10, 2, 32),
(2009, 10, 13, 2, 398),
(2009, 10, 14, 1, 31),
(2009, 10, 15, 1, 197),
(2009, 10, 18, 1, 437),
(2009, 10, 23, 1, 1),
(2009, 11, 12, 1, 28),
(2009, 11, 13, 1, 144),
(2009, 11, 14, 2, 82),
(2009, 11, 15, 3, 951),
(2009, 11, 16, 2, 568),
(2009, 11, 23, 1, 655),
(2009, 11, 28, 4, 25),
(2009, 11, 29, 3, 9),
(2009, 11, 30, 2, 54),
(2009, 12, 2, 1, 10),
(2009, 12, 3, 1, 6),
(2009, 12, 8, 1, 9),
(2009, 12, 10, 1, 3),
(2009, 12, 11, 2, 5),
(2009, 12, 13, 1, 18),
(2009, 12, 15, 1, 1),
(2009, 12, 16, 2, 56),
(2009, 12, 19, 2, 23),
(2009, 12, 20, 1, 4),
(2009, 12, 21, 2, 16),
(2009, 12, 23, 1, 1),
(2009, 12, 24, 1, 1),
(2009, 12, 26, 1, 195),
(2009, 12, 30, 2, 68),
(2010, 1, 1, 1, 20),
(2010, 1, 2, 1, 3),
(2010, 1, 3, 1, 3),
(2010, 1, 4, 1, 191),
(2010, 1, 5, 2, 312);

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
  PRIMARY KEY (`dl_id`),
  FULLTEXT KEY `dl_text` (`dl_text`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `fs_dl`
--

INSERT INTO `fs_dl` (`dl_id`, `cat_id`, `user_id`, `dl_date`, `dl_name`, `dl_text`, `dl_autor`, `dl_autor_url`, `dl_open`) VALUES
(1, 1, 1, 1262712732, 'FS2', 'test', 'Test', '', 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `fs_dl_files`
--

INSERT INTO `fs_dl_files` (`dl_id`, `file_id`, `file_count`, `file_name`, `file_url`, `file_size`, `file_is_mirror`) VALUES
(1, 1, 44, 'FS2', 'http://www.frogsystem.de/?go=dlfile&fileid=1', 605, 1);

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
(1, 5, 2, 357, 120, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 1, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 0, 1, 0, 1, 0, 1);

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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `fs_global_config`
--

INSERT INTO `fs_global_config` (`id`, `version`, `virtualhost`, `admin_mail`, `title`, `dyn_title`, `dyn_title_ext`, `description`, `keywords`, `publisher`, `copyright`, `show_favicon`, `style_id`, `style_tag`, `allow_other_designs`, `date`, `time`, `datetime`, `page`, `page_next`, `page_prev`, `random_timed_deltime`, `feed`, `language_text`, `home`, `home_text`, `auto_forward`) VALUES
(1, '2.alix4', 'http://localhost/fs2/www/', 'admin@admin.de', 'Frogsystem 2', 1, '{title} - {ext}', 'Frogsystem 2 - your way to nature', 'CMS, Content, Management, System, Frog, Alix', 'Kermit, Sweil, rockfest, Wal, Don-Esteban, Fizzban', 'Frogsystem-Team [http://www.frogsystem.de]', 0, 5, 'lightfrog', 0, 'd.m.Y', 'H:i Uhr', 'd.m.Y H:i Uhr', '<div align="center" style="width:270px;"><div style="width:70px; float:left;">{..prev..}&nbsp;</div>Seite <b>{..page_number..}</b> von <b>{..total_pages..}</b><div style="width:70px; float:right;">&nbsp;{..next..}</div></div>', '|&nbsp;<a href="{..url..}">weiter&nbsp;»</a>', '<a href="{..url..}">«&nbsp;zurück</a>&nbsp;|', 604800, 'rss20', 'de_DE', 0, '', 4);

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

INSERT INTO `fs_iplist` (`ip`) VALUES
('127.0.0.1');

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
  PRIMARY KEY (`news_id`),
  FULLTEXT KEY `news_search` (`news_title`,`news_text`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Daten für Tabelle `fs_news`
--

INSERT INTO `fs_news` (`news_id`, `cat_id`, `user_id`, `news_date`, `news_title`, `news_text`, `news_active`, `news_comments_allowed`) VALUES
(1, 1, 1, 1223718060, 'Herzlich Willkommen!', '[b]Hallo Webmaster![/b]\r\n\r\nHerzlich Willkommen in deinem deinem frisch installierten Frogsystem 2.alix4! Das Frogsystem 2-Team wünscht dir viel Spaß und Erfolg mit deiner Seite.\r\n\r\nWeitere Informationen und Hilfe bei Problemen gibt es auf der offiziellen Homepage des Frogsystem 2 und in den zugehörigen Supportforen. Wir haben dir beides unten verlinkt. Schau doch mal vorbei!\r\n\r\nUnd jetzt an die Arbeit! ;-)', 1, 1),
(10, 1, 1, 1261395600, 'gdfdf', 'dffg', 1, 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `fs_news_cat`
--

INSERT INTO `fs_news_cat` (`cat_id`, `cat_name`, `cat_description`, `cat_date`, `cat_user`) VALUES
(1, 'News', '', 1215295200, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_news_comments`
--

DROP TABLE IF EXISTS `fs_news_comments`;
CREATE TABLE `fs_news_comments` (
  `comment_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `news_id` mediumint(8) DEFAULT NULL,
  `comment_poster` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `comment_poster_id` mediumint(8) DEFAULT NULL,
  `comment_poster_ip` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `comment_date` int(11) DEFAULT NULL,
  `comment_title` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `comment_text` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`comment_id`),
  FULLTEXT KEY `comment_text` (`comment_text`),
  FULLTEXT KEY `comment_title` (`comment_title`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

--
-- Daten für Tabelle `fs_news_comments`
--

INSERT INTO `fs_news_comments` (`comment_id`, `news_id`, `comment_poster`, `comment_poster_id`, `comment_poster_ip`, `comment_date`, `comment_title`, `comment_text`) VALUES
(14, 1, '1', 1, '127.0.0.1', 1259614099, 'neu', 'neu'),
(15, 1, '1', 1, '127.0.0.1', 1259878579, 'vvv', '[b]b[/b]\r\n[b][i]cc[/b][/i]\r\n[i]i[/i]');

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
(1, 10, 5, 2, 4, 1, 150, 150, 1024, 2, 2, 'DESC', 40, ' ...', 15, 2);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Daten für Tabelle `fs_news_links`
--

INSERT INTO `fs_news_links` (`news_id`, `link_id`, `link_name`, `link_url`, `link_target`) VALUES
(1, 9, 'Offizielle Frogsystem 2 Homepage', 'http://www.frogsystem.de', 1),
(1, 10, 'Frogsystem 2 Supportforum', 'http://forum.sweil.de/viewforum.php?f=7', 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Daten für Tabelle `fs_partner`
--

INSERT INTO `fs_partner` (`partner_id`, `partner_name`, `partner_link`, `partner_beschreibung`, `partner_permanent`) VALUES
(4, 'conquest', 'http://conquest.de', 'blubb', 1),
(5, 'dragon age', 'http://da.de', 'drachen', 0);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

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
(3, 2, 'Beispiel-Kategorie „Preview“'),
(4, 1, 'Beispiel-Spiel „G“'),
(5, 2, 'Beispiel-Kategorie „Review“'),
(6, 2, 'Beispiel-Kategorie „Interview“');

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
  `screen_name` char(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`screen_id`),
  KEY `cat_id` (`cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Daten für Tabelle `fs_screen`
--

INSERT INTO `fs_screen` (`screen_id`, `cat_id`, `screen_name`) VALUES
(1, 1, '1'),
(2, 1, '22'),
(3, 3, 'tttttttttttt');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Daten für Tabelle `fs_screen_cat`
--

INSERT INTO `fs_screen_cat` (`cat_id`, `cat_name`, `cat_type`, `cat_visibility`, `cat_date`, `randompic`) VALUES
(1, 'Screenshots', 1, 1, 1187549776, 1),
(2, 'Wallpaper', 2, 1, 1187549782, 0),
(3, 'test', 1, 0, 1262371358, 0);

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
(1, 1500, 1500, 120, 90, 1024, 6, 3, 'id', 'desc', 1, 950, 700, 800, 600, 2000, 2000, 200, 150, 'id', 1536, 6, 2, 'desc');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Daten für Tabelle `fs_shop`
--

INSERT INTO `fs_shop` (`artikel_id`, `artikel_name`, `artikel_url`, `artikel_text`, `artikel_preis`, `artikel_hot`) VALUES
(3, 'Departed: Unter Feinden [Blu-ray]', 'http://www.amazon.de/Departed-Feinden-Blu-ray-Leonardo-DiCaprio/dp/B000PC6GRE/ref=sr_1_2?ie=UTF8&s=dvd&qid=1260977964&sr=8-2-spell', 'Meister-Regisseur Martin Scorsese kehrt mit Departed - Unter Feinden zu den Straßengangster-Wurzeln seiner Karriere zurück und liefert seinen vielleicht besten Film seit Casino (1995) ab. Da es sich bei diesem spannenden Krimi um ein Remake des hochgelobten Hongkong-Polizei-Thrillers Infernal Affairs (2002) handelt, wurde Scorseses Film von Kritikern und Kinoliebhabern sehr skeptisch unter die Lupe genommen. Und während Scorseses intensive Inszenierung und sein Star-gespicktes Ensemble reichlich Lob verdienen, bemängelten einige besonders aufmerksame Zuschauer auch schluderiges Handwerk in Bezug auf schlecht abgestimmte Einstellungswechsel und Anschlussfehler. Aber egal mit wieviel Bewunderung man Scorsese grundsätzlich begegnet, es ist kaum zu leugnen, dass einer der besten Filmemacher Amerikas mit Departed – Unter Feinden ein weiteres Markenzeichen seines meisterhaften Stils abgeliefert hat, für maximalen Effekt konstruiert mit einer atemberaubenden Serie von plötzlichen Wendungen und bösen Überraschungen.\r\n\r\nDie Geschichte ist ein verzwicktes Katz-und-Maus-Spiel, aber diesmal sind die Katze und die Maus beide Maulwürfe: Colin Sullivan (Matt Damon) ist ein ambitionierter Polizist, der schnell die Karriereleiter hochsteigt, doch tatsächlich unterwandert er die Polizei von Boston als Spitzel für den Gangsterboss Frank Costello (Jack Nicholson). Billy Costigan (Leonardo DiCaprio) ist ein heißblütiger Jungpolizist, der wiederum scheinbar entlassen wurde, um als vermeintlich vertrauenswürdiger Handlanger undercover in Costellos Verbrecherorganisation zu ermitteln. Während sich die vielschichtige Story entwickelt (brillant adaptiert und ausgearbeitet von Königreich der Himmel-Drehbuchautor William Monahan), werden Costigan und Sullivan jeweils mit der Suche nach dem Maulwurf betraut (sie suchen sich quasi selbst) und umgarnen gleichzeitig die Psychiaterin (Vera Farmiga), bei der sie beide in Behandlung sind. ', '13,97 €', 0),
(2, 'Blade Runner - 2-Disc Special Edition [Blu-ray]', 'http://www.amazon.de/Blade-Runner-2-Disc-Special-Blu-ray/dp/B000X9WWVS/ref=sr_1_1?ie=UTF8&s=dvd&qid=1260977499&sr=8-1', 'Als Ridley Scotts Director\\''s Cut von Blade Runner 1993 veröffentlicht wurde, wunderten sich viele Kinogänger, warum das Studio diese Version nicht schon elf Jahre zuvor in die Kinos gebracht hatte. Diese neu geschnittene Version ist viel besser, vor allem, da Unnötiges eliminiert (zum Beispiel die albernen und überflüssigen Kommentare aus dem Off sowie das falsche Happy End) sowie wirklich Wichtiges erneuert wurde (die Charaktere werden ein bisschen schärfer gezeichnet und es gibt einen sehr schönen, kurzen Traum, in dem ein Einhorn auftritt.\r\n\r\nHarrison Ford hat die Kommentare einst gesprochen, da ihn das Studio dazu \\"genötigt\\" hatte. In den Chefetagen des produzierenden Studios hatte man geglaubt, der Zuschauer brauche weitere Erklärungen, um der Geschichte besser folgen zu können. Ford hat später zugegeben, diese Kommentare absichtlich sehr schlecht und lieblos gesprochen zu haben, weil er glaubte, sie würden dann keine weitere Verwendung finden (Moral: Überschätze niemals den Geschmack von Filmproduzenten.', '15,95 €', 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC AUTO_INCREMENT=5 ;

--
-- Daten für Tabelle `fs_snippets`
--

INSERT INTO `fs_snippets` (`snippet_id`, `snippet_tag`, `snippet_text`, `snippet_active`) VALUES
(4, '[%feeds%]', '<p>\r\n  <b>News-Feeds:</b>\r\n</p>\r\n<p align=\\"center\\">\r\n  <a href=\\"$VAR(url)feeds/rss091.php\\" target=\\"_self\\"><img src=\\"$VAR(style_icons)feeds/rss091.gif\\" alt=\\"RSS 0.91\\" title=\\"RSS 0.91\\" border=\\"0\\"></a><br>\r\n  <a href=\\"$VAR(url)feeds/rss10.php\\" target=\\"_self\\"><img src=\\"$VAR(style_icons)feeds/rss10.gif\\" alt=\\"RSS 1.0\\" title=\\"RSS 1.0\\" border=\\"0\\"></a><br>\r\n  <a href=\\"$VAR(url)feeds/rss20.php\\" target=\\"_self\\"><img src=\\"$VAR(style_icons)feeds/rss20.gif\\" alt=\\"RSS 2.0\\" title=\\"RSS 2.0\\" border=\\"0\\"></a><br>\r\n  <a href=\\"$VAR(url)feeds/atom10.php\\" target=\\"_self\\"><img src=\\"$VAR(style_icons)feeds/atom10.gif\\" alt=\\"Atom 1.0\\" title=\\"Atom 1.0\\" border=\\"0\\"></a>\r\n</p>', 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC AUTO_INCREMENT=37 ;

--
-- Daten für Tabelle `fs_styles`
--

INSERT INTO `fs_styles` (`style_id`, `style_tag`, `style_allow_use`, `style_allow_edit`) VALUES
(0, 'default', 0, 0),
(5, 'lightfrog', 1, 1),
(11, 'darkfrog', 1, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_template`
--

DROP TABLE IF EXISTS `fs_template`;
CREATE TABLE `fs_template` (
  `id` tinyint(4) NOT NULL DEFAULT '0',
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `style_css` text COLLATE utf8_unicode_ci NOT NULL,
  `js_userfunctions` text COLLATE utf8_unicode_ci NOT NULL,
  `indexphp` text COLLATE utf8_unicode_ci NOT NULL,
  `doctype` text COLLATE utf8_unicode_ci NOT NULL,
  `artikel_body` text COLLATE utf8_unicode_ci NOT NULL,
  `artikel_autor` text COLLATE utf8_unicode_ci NOT NULL,
  `randompic_body` text COLLATE utf8_unicode_ci NOT NULL,
  `randompic_nobody` text COLLATE utf8_unicode_ci NOT NULL,
  `shop_body` text COLLATE utf8_unicode_ci NOT NULL,
  `shop_hot` text COLLATE utf8_unicode_ci NOT NULL,
  `news_link` text COLLATE utf8_unicode_ci NOT NULL,
  `news_related_links` text COLLATE utf8_unicode_ci NOT NULL,
  `news_headline` text COLLATE utf8_unicode_ci NOT NULL,
  `main_menu` text COLLATE utf8_unicode_ci NOT NULL,
  `news_comment_body` text COLLATE utf8_unicode_ci NOT NULL,
  `news_comment_autor` text COLLATE utf8_unicode_ci NOT NULL,
  `news_comment_form` text COLLATE utf8_unicode_ci NOT NULL,
  `news_comment_form_name` text COLLATE utf8_unicode_ci NOT NULL,
  `news_comment_form_spam` text COLLATE utf8_unicode_ci NOT NULL,
  `news_comment_form_spamtext` text COLLATE utf8_unicode_ci NOT NULL,
  `news_search_form` text COLLATE utf8_unicode_ci NOT NULL,
  `error` text COLLATE utf8_unicode_ci NOT NULL,
  `news_headline_body` text COLLATE utf8_unicode_ci NOT NULL,
  `user_mini_login` text COLLATE utf8_unicode_ci NOT NULL,
  `shop_main_body` text COLLATE utf8_unicode_ci NOT NULL,
  `shop_artikel` text COLLATE utf8_unicode_ci NOT NULL,
  `dl_navigation` text COLLATE utf8_unicode_ci NOT NULL,
  `dl_search_field` text COLLATE utf8_unicode_ci NOT NULL,
  `dl_body` text COLLATE utf8_unicode_ci NOT NULL,
  `dl_datei_preview` text COLLATE utf8_unicode_ci NOT NULL,
  `dl_file_body` text COLLATE utf8_unicode_ci NOT NULL,
  `dl_file` text COLLATE utf8_unicode_ci NOT NULL,
  `dl_file_is_mirror` text COLLATE utf8_unicode_ci NOT NULL,
  `dl_stats` text COLLATE utf8_unicode_ci NOT NULL,
  `dl_quick_links` text COLLATE utf8_unicode_ci NOT NULL,
  `screenshot_pic` text COLLATE utf8_unicode_ci NOT NULL,
  `screenshot_body` text COLLATE utf8_unicode_ci NOT NULL,
  `screenshot_cat` text COLLATE utf8_unicode_ci NOT NULL,
  `screenshot_cat_body` text COLLATE utf8_unicode_ci NOT NULL,
  `wallpaper_pic` text COLLATE utf8_unicode_ci NOT NULL,
  `wallpaper_sizes` text COLLATE utf8_unicode_ci NOT NULL,
  `pic_viewer` text COLLATE utf8_unicode_ci NOT NULL,
  `user_user_menu` text COLLATE utf8_unicode_ci NOT NULL,
  `user_admin_link` text COLLATE utf8_unicode_ci NOT NULL,
  `user_login` text COLLATE utf8_unicode_ci NOT NULL,
  `user_profiledit` text COLLATE utf8_unicode_ci NOT NULL,
  `user_memberlist_body` text COLLATE utf8_unicode_ci NOT NULL,
  `user_memberlist_userline` text COLLATE utf8_unicode_ci NOT NULL,
  `user_memberlist_adminline` text COLLATE utf8_unicode_ci NOT NULL,
  `user_spam` text COLLATE utf8_unicode_ci NOT NULL,
  `user_spamtext` text COLLATE utf8_unicode_ci NOT NULL,
  `community_map` text COLLATE utf8_unicode_ci NOT NULL,
  `poll_body` text COLLATE utf8_unicode_ci NOT NULL,
  `poll_line` text COLLATE utf8_unicode_ci NOT NULL,
  `poll_main_body` text COLLATE utf8_unicode_ci NOT NULL,
  `poll_main_line` text COLLATE utf8_unicode_ci NOT NULL,
  `poll_result` text COLLATE utf8_unicode_ci NOT NULL,
  `poll_result_line` text COLLATE utf8_unicode_ci NOT NULL,
  `poll_list` text COLLATE utf8_unicode_ci NOT NULL,
  `poll_list_line` text COLLATE utf8_unicode_ci NOT NULL,
  `poll_no_poll` text COLLATE utf8_unicode_ci NOT NULL,
  `user_profil` text COLLATE utf8_unicode_ci NOT NULL,
  `statistik` text COLLATE utf8_unicode_ci NOT NULL,
  `user_register` text COLLATE utf8_unicode_ci NOT NULL,
  `news_body` text COLLATE utf8_unicode_ci NOT NULL,
  `news_container` text COLLATE utf8_unicode_ci NOT NULL,
  `news_comment_container` text COLLATE utf8_unicode_ci NOT NULL,
  `announcement` text COLLATE utf8_unicode_ci NOT NULL,
  `email_register` text COLLATE utf8_unicode_ci NOT NULL,
  `email_passchange` text COLLATE utf8_unicode_ci NOT NULL,
  `partner_eintrag` text COLLATE utf8_unicode_ci NOT NULL,
  `partner_main_body` text COLLATE utf8_unicode_ci NOT NULL,
  `partner_navi_eintrag` text COLLATE utf8_unicode_ci NOT NULL,
  `partner_navi_body` text COLLATE utf8_unicode_ci NOT NULL,
  `code_tag` text COLLATE utf8_unicode_ci NOT NULL,
  `quote_tag` text COLLATE utf8_unicode_ci NOT NULL,
  `quote_tag_name` text COLLATE utf8_unicode_ci NOT NULL,
  `editor_design` text COLLATE utf8_unicode_ci NOT NULL,
  `editor_css` text COLLATE utf8_unicode_ci NOT NULL,
  `editor_button` text COLLATE utf8_unicode_ci NOT NULL,
  `editor_seperator` text COLLATE utf8_unicode_ci NOT NULL,
  `press_navi_line` text COLLATE utf8_unicode_ci NOT NULL,
  `press_navi_main` text COLLATE utf8_unicode_ci NOT NULL,
  `press_intro` text COLLATE utf8_unicode_ci NOT NULL,
  `press_note` text COLLATE utf8_unicode_ci NOT NULL,
  `press_body` text COLLATE utf8_unicode_ci NOT NULL,
  `press_main_body` text COLLATE utf8_unicode_ci NOT NULL,
  `press_container` text COLLATE utf8_unicode_ci NOT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci PACK_KEYS=1;

--
-- Daten für Tabelle `fs_template`
--

INSERT INTO `fs_template` (`id`, `name`, `style_css`, `js_userfunctions`, `indexphp`, `doctype`, `artikel_body`, `artikel_autor`, `randompic_body`, `randompic_nobody`, `shop_body`, `shop_hot`, `news_link`, `news_related_links`, `news_headline`, `main_menu`, `news_comment_body`, `news_comment_autor`, `news_comment_form`, `news_comment_form_name`, `news_comment_form_spam`, `news_comment_form_spamtext`, `news_search_form`, `error`, `news_headline_body`, `user_mini_login`, `shop_main_body`, `shop_artikel`, `dl_navigation`, `dl_search_field`, `dl_body`, `dl_datei_preview`, `dl_file_body`, `dl_file`, `dl_file_is_mirror`, `dl_stats`, `dl_quick_links`, `screenshot_pic`, `screenshot_body`, `screenshot_cat`, `screenshot_cat_body`, `wallpaper_pic`, `wallpaper_sizes`, `pic_viewer`, `user_user_menu`, `user_admin_link`, `user_login`, `user_profiledit`, `user_memberlist_body`, `user_memberlist_userline`, `user_memberlist_adminline`, `user_spam`, `user_spamtext`, `community_map`, `poll_body`, `poll_line`, `poll_main_body`, `poll_main_line`, `poll_result`, `poll_result_line`, `poll_list`, `poll_list_line`, `poll_no_poll`, `user_profil`, `statistik`, `user_register`, `news_body`, `news_container`, `news_comment_container`, `announcement`, `email_register`, `email_passchange`, `partner_eintrag`, `partner_main_body`, `partner_navi_eintrag`, `partner_navi_body`, `code_tag`, `quote_tag`, `quote_tag_name`, `editor_design`, `editor_css`, `editor_button`, `editor_seperator`, `press_navi_line`, `press_navi_main`, `press_intro`, `press_note`, `press_body`, `press_main_body`, `press_container`) VALUES
(1, 'arbeit', 'body\r\n{\r\n    background-color:#7EC46B;\r\n    margin:0px;\r\n    font-family:Verdana;\r\n    color:#000000;\r\n    font-size:8pt;\r\n}\r\n.small\r\n{\r\n    font-size:7pt;\r\n}\r\n.pointer\r\n{\r\n    cursor:pointer;\r\n}\r\n\r\na\r\n{\r\n    color:#008800;\r\n    font-size:8pt;\r\n    text-decoration:none;\r\n}\r\na.small\r\n{\r\n    color:#008800;\r\n    font-size:7pt;\r\n    text-decoration:none;\r\n}\r\n\r\n.thumb\r\n{\r\n    cursor:pointer;\r\n}\r\n\r\n\r\n#head_shadow\r\n{\r\n    position:absolute;\r\n    z-index:1;\r\n    background-color:#2B4325;\r\n    top:26px;\r\n    height:86px;\r\n    left:50%;\r\n    width:870px;\r\n    margin-left:-433px;\r\n}\r\n#head\r\n{\r\n    position:absolute;\r\n    z-index:2;\r\n    background-color:#EEEEEE;\r\n    background-image:url("images/icons/logo.gif");\r\n    top:24px;\r\n    height:84px;\r\n    left:50%;\r\n    width:868px;\r\n    margin-left:-435px;\r\n    border:1px solid #000000;\r\n}\r\n\r\n#menu_l_shadow\r\n{\r\n    position:absolute;\r\n    z-index:1;\r\n    background-color:#2B4325;\r\n    top:120px;\r\n    left:50%;\r\n    width:120px;\r\n    margin-left:-433px;\r\n}\r\n#menu_l\r\n{\r\n    position:relative;\r\n    z-index:2;\r\n    background-color:#EEEEEE;\r\n    top:-2px;\r\n    left:-2px;;\r\n    width:112px;\r\n    border:1px solid #000000;\r\n    padding:3px;\r\n    font-size:7pt;\r\n}\r\n\r\n#main_container\r\n{\r\n    position:absolute;\r\n    z-index:0;\r\n    top:120px;\r\n    left:50%;\r\n    width:612px;\r\n    margin-left:-304px;\r\n}\r\n#main_shadow\r\n{\r\n    position:relative;\r\n    z-index:1;\r\n    background-color:#2B4325;\r\n    width:612px;\r\n}\r\n#main\r\n{\r\n    position:relative;\r\n    z-index:2;\r\n    background-color:#EEEEEE;\r\n    top:-2px;\r\n    left:-2px;;\r\n    width:600px;\r\n    border:1px solid #000000;\r\n    padding:5px;\r\n    padding-bottom:15px;\r\n}\r\n\r\n#menu_r_shadow\r\n{\r\n    position:absolute;\r\n    z-index:1;\r\n    background-color:#2B4325;\r\n    top:120px;\r\n    left:50%;\r\n    width:120px;\r\n    margin-left:317px;\r\n}\r\n#menu_r\r\n{\r\n    position:relative;\r\n    z-index:2;\r\n    background-color:#EEEEEE;\r\n    top:-2px;\r\n    left:-2px;;\r\n    width:112px;\r\n    border:1px solid #000000;\r\n    padding:3px;\r\n    font-size:7pt;\r\n}\r\n\r\n.news_head\r\n{\r\n    padding-bottom:2px;\r\n    border-bottom:1px solid #000000;\r\n}\r\n.news_footer\r\n{\r\n    padding-top:2px;\r\n    border-top:1px solid #000000;\r\n}\r\n\r\n.text\r\n{\r\n    border:1px solid #000000;\r\n    background-color: #CCCCCC;\r\n    font-family:Verdana;\r\n    color:#000000;\r\n    font-size:8pt;\r\n}\r\n.button\r\n{\r\n    border:1px solid #000000;\r\n    background-color: #CCCCCC;\r\n    font-family:Verdana;\r\n    color:#000000;\r\n    font-size:7pt;\r\n}', 'function chkFormularComment()\r\n    {\r\n        if((document.getElementById("name").value == "") ||\r\n           (document.getElementById("title").value == "") ||\r\n           (document.getElementById("text").value == ""))\r\n        {\r\n            alert ("Du hast nicht alle Felder ausgefüllt");\r\n            return false;\r\n        }\r\n    }\r\n    \r\nfunction chkFormularNewsSearch()\r\n    {\r\n        if (document.getElementById("keyword").value.length < "4")\r\n        {\r\n            alert("Es müssen mehr als 3 Zeichen sein");\r\n            return false;\r\n        }\r\n    }\r\n\r\nfunction chkFormularRegister() \r\n{\r\n    if((document.getElementById("username").value == "") ||\r\n       (document.getElementById("usermail").value == "") ||\r\n       (document.getElementById("newpwd").value == "") ||\r\n       (document.getElementById("wdhpwd").value == ""))\r\n    {\r\n        alert("Du hast nicht alle Felder ausgefüllt"); \r\n        return false;\r\n    }\r\n    if(document.getElementById("newpwd").value != document.getElementById("wdhpwd").value)\r\n    {\r\n        alert("Passwöter sind verschieden"); \r\n        return false;\r\n    }\r\n}', '<body>\r\n    <div id="head_shadow"></div>\r\n    <div id="head"></div>\r\n\r\n    <div id="menu_l_shadow">\r\n        <div id="menu_l">\r\n{main_menu}\r\n        </div>\r\n    </div>\r\n    <div id="main_container">\r\n        <div id="main_shadow">\r\n            <div id="main">\r\n{announcement}\r\n{content}\r\n            </div>\r\n        </div>\r\n        <div style="width:100%; text-align:center; margin-top:10px; font-size:7pt; padding-bottom:10px;">{copyright}</div>\r\n    </div>\r\n\r\n    <div id="menu_r_shadow">\r\n        <div id="menu_r">\r\n{user}<br><br>\r\nZufallsbild:<br>\r\n{randompic}<br>\r\nShop:<br>\r\n{shop}<br><br>\r\nUmfrage:<br>\r\n{poll}<br>\r\nPartner:<br>\r\n{partner}\r\nStatistik:<br>\r\n{stats}<br><br>\r\nNews-Feeds:<br>\r\n[%feeds%]\r\n        </div>\r\n    </div>\r\n</body>', '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">', '<div class="news_head" style="height:10px;">\r\n   <span style="float:left;">\r\n       <b>{title}</b>\r\n   </span>\r\n   <span class="small" style="float:right;">\r\n       <b>{date}</b>\r\n   </span>\r\n</div>\r\n<div>\r\n   {text}\r\n</div>\r\n<div>\r\n   <span class="small" style="float:right;">\r\n       {author_template}\r\n   </span>\r\n</div>', 'geschrieben von <a class="small" href="{profile_url}">{user_name}</a>', '<img class=\\"thumb\\" onClick=\\"open(\\''{link}\\'',\\''Picture\\'',\\''width=900,height=710,screenX=0,screenY=0\\'')\\" src=\\"{thumb}\\" alt=\\"{titel}\\">', '<div class=\\"small\\" align=\\"center\\">\r\n     Kein Zufallsbild aktiv\r\n</div>', '{hotlinks}', '<div align="center">\r\n    <a style="font-weight:bold;" class="small" target="_blank" href="{link}">{titel}</a>\r\n</div>', '<li><a href="{url}" target="{target}">{name}</a></li>', '<p>\r\n<b>Related Links:</b>\r\n<ul>\r\n    {links}\r\n</ul>', '<span class="small">{datum} </span><a class="small" href="{url}">{titel}</a><br>', '<b>Allgemein</b><br>\r\n<a class="small" href="{virtualhost}?go=news">- News</a><br>\r\n<a class="small" href="{virtualhost}?go=newsarchiv">- News Archiv</a><br>\r\n<a class="small" href="{virtualhost}?go=members">- Mitgliederliste</a><br>\r\n<a class="small" href="{virtualhost}?go=pollarchiv">- Umfragen Archiv</a><br>\r\n<a class="small" href="{virtualhost}?go=gallery">- Galerie</a><br>\r\n<a class="small" href="{virtualhost}?go=download">- Downloads</a><br>\r\n<a class="small" href="{virtualhost}?go=press">- Presseberichte</a><br>\r\n<a class="small" href="{virtualhost}?go=fscode">- FSCode</a><br>\r\n<a class="small" href="{virtualhost}?go=partner">- Partnerseiten</a><br>\r\n<a class="small" href="{virtualhost}?go=shop">- Shop</a><br>', '<div class="news_head" style="height:10px;">\r\n    <span style="float:left;">\r\n        <b>{titel}</b>\r\n    </span>\r\n    <span class="small" style="float:right;">\r\n        <b>{datum}</b>\r\n    </span>\r\n</div>\r\n<div style="padding:3px;">\r\n    <table border="0" cellpadding="0" cellspacing="0" width="100%">\r\n        <tr>\r\n            <td align="left" valign="top">\r\n                {autor_avatar}\r\n            </td>\r\n            <td valign="top" align="left">\r\n                {text}\r\n            </td>\r\n        </tr>\r\n    </table>\r\n</div>\r\n<div class="news_footer">\r\n    <span class="small" style="float:right;">\r\n        geschrieben von: {autor}</a>\r\n    </span>\r\n</div>\r\n<br><br><br>', '<a class="small" href="{url}">{name}</a>', '<b id="add">Kommentar hinzufügen</b><p>\r\n<div>\r\n    <form action="" method="post" onSubmit="return chkFormularComment()">\r\n       <input type="hidden" name="go" value="comments">\r\n       <input type="hidden" name="addcomment" value="1">\r\n       <input type="hidden" name="id" value="{newsid}">\r\n       <table width="100%">\r\n           <tr>\r\n               <td align="left">\r\n                   <b>Name: </b>\r\n               </td>\r\n               <td align="left">\r\n                   {name_input}\r\n               </td>\r\n           </tr>\r\n           <tr>\r\n               <td align="left">\r\n                   <b>Titel: </b>\r\n               </td>\r\n               <td align="left">\r\n                   <input class="text" name="title" id="title" size="32" maxlength="32">\r\n               </td>\r\n           </tr>\r\n{antispam}\r\n           <tr>\r\n               <td align="left" valign="top">\r\n                   <b>Text:</b><br />\r\n                     <font class="small">Html ist {html}.<br />\r\n                     FScode ist {fs_code}.</font>\r\n               </td>\r\n               <td align="left">\r\n                   {textarea}\r\n               </td>\r\n           </tr>\r\n           <tr>\r\n               <td></td>\r\n               <td align="left">\r\n                   <input class="button" type="submit" value="Absenden">\r\n               </td>\r\n           </tr>\r\n           <tr>\r\n               <td></td>\r\n               <td align="left">\r\n                  {antispamtext}\r\n               </td>\r\n           </tr>\r\n       </table>\r\n   </form>\r\n</div><p>', '<input class="text" name="name" id="name" size="32" maxlength="25">\r\n<span class="small"> Willst du dich </span>\r\n<a class="small" href="?go=login">einloggen?</a>', '<tr>\r\n                <td align="left">\r\n                    <img src="{captcha_url}">\r\n                </td>\r\n                <td align="left">\r\n                    <input class="text" name="spam" id="spam" size="32" maxlength="25">\r\n<span class="small">Bitte löse diese kleine Rechenaufgabe.</span> <a class="small" href="#antispam">Warum? *</a>\r\n                </td>\r\n            </tr>', '<br /><br />\r\n <table border="0" cellspacing="0" cellpadding="0" width="60%">\r\n  <tr>\r\n   <td valign="top" align="left">\r\n<div id="antispam"><font size="1">* Auf dieser Seite kann jeder einen Kommentar zu einer News abgeben. Leider ist sie dadurch ein beliebtes Ziel von sog. Spam-Bots - speziellen Programmen, die automatisiert und zum Teil massenhaft Links zu anderen Internetseiten platziern. Um das zu verhindern müssen nicht registrierte User eine einfache Rechenaufgabe lösen, die für die meisten Spam-Bots aber nicht lösbar ist. Wenn du nicht jedesmal eine solche Aufgabe lösen möchtest, kannst du dich einfach bei uns <a href="?go=register">registrieren</a>.</font></div>\r\n   </td>\r\n  </tr>\r\n </table>', '<b>NEWSARCHIV</b><p>\r\n<div>\r\n   <form action="" method="post">\r\n       <input type="hidden" name="go" value="newsarchiv">\r\n       <b>News aus dem: </b>\r\n       <select class="text" name="monat">\r\n           <option value="1">Januar</option>\r\n           <option value="2">Februar</option>\r\n           <option value="3">März</option>\r\n           <option value="4">April</option>\r\n           <option value="5">Mai</option>\r\n           <option value="6">Juni</option>\r\n           <option value="7">Juli</option>\r\n           <option value="8">August</option>\r\n           <option value="9">September</option>\r\n           <option value="10">Oktober</option>\r\n           <option value="11">November</option>\r\n           <option value="12">Dezember</option>\r\n       </select>\r\n       <select class="text" name="jahr">\r\n           {years}\r\n       </select>\r\n       <input class="button" type="submit" value="Anzeigen">\r\n   </form>\r\n   <p>\r\n   oder\r\n   <p>\r\n   <form action="" method="post" onSubmit="return chkFormularNewsSearch()">\r\n       <input type="hidden" name="go" value="newsarchiv">\r\n       <b>Nach: </b>\r\n       <input class="text" id="keyword" name="keyword" size="30" maxlength="20">\r\n       <input class="button" type="submit" value="Suchen">\r\n   </form>\r\n</div>\r\n<p></p>', '<b>{titel}</b><br>\r\n{meldung}\r\n<p></p>', '<div>\r\n    <b>Headlines:</b><br>\r\n    {headlines}\r\n</div>\r\n<div>\r\n    <b>Downloads:</b><br>\r\n    {downloads}\r\n</div>', '<tr>\r\n    <b>Einloggen</b>\r\n</tr>\r\n<tr>\r\n    <td align="center">\r\n        <form action="" method="post">\r\n            <input type="hidden" name="go" value="login">\r\n            <input type="hidden" name="login" value="1">\r\n            <table align="center" border="0" cellpadding="0" cellspacing="0" width="120">\r\n                <tr>\r\n                    <td align="right">\r\n                        <font class="small">Name:</font>\r\n                    </td>\r\n                    <td>\r\n                        <input class="text" size="10" name="username" maxlength="100">\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <td align="right">\r\n                        <font class="small">Pass:</font>\r\n                    </td>\r\n                    <td>\r\n                        <input class="text" size="10" type="password" name="userpassword" maxlength="16">\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <td align="center" colspan="2">\r\n                        <input type="checkbox" name="stayonline" value="1" checked>\r\n                        <font class="small">eingeloggt bleiben</font>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <td align="center" colspan="2">\r\n                        <input class="button" type="submit" value="Anmelden">\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan="2" align="center">\r\n                        <a class="small" href="?go=register">Noch nicht registriert?</a>\r\n                    </td>\r\n                </tr>\r\n            </table>\r\n        </form>\r\n    </td>\r\n</tr>', '<b>SHOP</b><p>\r\n<table width="100%">\r\n    {artikel}\r\n</table>', '<tr>\r\n    <td align="left" valign="top" width="60" rowspan="4">\r\n        <img border="0" style="cursor:pointer;" onClick=open(''showimg.php?pic={bild}'',''Picture'',''width=900,height=710,screenX=0,screenY=0'') src="{thumbnail}">\r\n    </td>\r\n    <td align="left" width="100">\r\n        <b>Titel:</b>\r\n    </td>\r\n        <td align="left">\r\n            {titel}\r\n        </td>\r\n    </tr>\r\n<tr>\r\n    <td align="left" valign="top">\r\n        <b>Beschreibung:</b>\r\n    </td>\r\n    <td align="left" valign="top">\r\n        {beschreibung}</td>\r\n    </tr>\r\n<tr>\r\n    <td align="left">\r\n        <b>Preis:</b>\r\n    </td>\r\n    <td align="left">\r\n        {preis} ¤\r\n    </td>\r\n</tr>\r\n<tr>\r\n    <td align="left"></td>\r\n    <td align="left">\r\n        <a href="{bestell_url}" target="_blank">Jetzt bestellen!</a>\r\n    </td>\r\n</tr>\r\n<tr>\r\n    <td colspan="3">\r\n         \r\n    </td>\r\n</tr>', '<img border="0" src="images/design/{icon}">\r\n<a href="{kategorie_url}">{kategorie_name}</a><br>', '<form action="" method="get">\r\n<tr>\r\n  <td colspan="3" align="right"><br /> <b>Kategorie durchsuchen:</b></td>\r\n  <td colspan="1" align="left"><br /> \r\n    <input class="text" size="20" name="keyword" value="{keyword}">\r\n    <input class="button" type="submit" value="Go">\r\n    <input class="button" type="button" value="Alle anzeigen" onclick="location=''{all_url}''">\r\n    <input type="hidden" name="go" value="download">\r\n    {input_cat}</td>\r\n</tr>\r\n\r\n</form>', '<b>DOWNLOADS</b><p>\r\n{navigation}\r\n<table border="0" cellpadding="0" cellspacing="2" width="100%">\r\n<tr>\r\n  <td style="border: 1px solid #000000; padding: 3px;"><strong>Titel</strong></td>\r\n  <td style="border: 1px solid #000000; padding: 3px;"><strong>Kategorie</strong></td>\r\n  <td style="border: 1px solid #000000; padding: 3px;"><strong>Uploaddatum</strong></td>\r\n  <td style="border: 1px solid #000000; padding: 3px;"><strong>Beschreibung</strong></td>\r\n </tr>\r\n{dateien}\r\n{suchfeld}\r\n</table>', '<tr>\r\n  <td style="border: 1px solid #000000; padding: 3px;"><a href="{url}"><b>{name}</b></a></td>\r\n  <td style="border: 1px solid #000000; padding: 3px;" align="center" valign="middle">{cat}</td>\r\n  <td style="border: 1px solid #000000; padding: 3px;" align="center" valign="middle">{datum}</td>\r\n  <td style="border: 1px solid #000000; padding: 3px;">{text}</td>\r\n </tr>', '<b>DOWNLOADS -> {titel}</b><p>\r\n{navigation}\r\n    <table width="100%">\r\n        <tr>\r\n            <td align="left" width="130" rowspan="6" valign="top">\r\n                <img class="thumb" onClick=open(''showimg.php?pic={bild}'',''Picture'',''width=900,height=710,screenX=0,screenY=0'') src="{thumbnail}">\r\n            </td>\r\n        </tr>\r\n         <tr>\r\n            <td align="left" colspan="2" height="20" valign="top">\r\n                <b>{titel}</b>\r\n            </td>\r\n        </tr>\r\n       <tr>\r\n            <td align="left" width="75">\r\n                <b>Kategorie:</b>\r\n            </td>\r\n            <td align="left">\r\n                {cat}\r\n            </td>\r\n        </tr>\r\n       <tr>\r\n            <td align="left" width="75">\r\n                <b>Datum:</b>\r\n            </td>\r\n            <td align="left">\r\n                {datum}\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td align="left" width="75">\r\n                <b>Uploader:</b>\r\n            </td>\r\n            <td align="left">\r\n                <a href="{uploader_url}">{uploader}</a>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td align="left" width="75">\r\n                <b>Autor:</b>\r\n            </td>\r\n            <td align="left">\r\n                {autor_link}\r\n            </td>\r\n        </tr>\r\n    </table>\r\n    <br>\r\n    <table width="100%">\r\n        <tr>\r\n            <td align="left" valign="top" width="130">\r\n                <b>Beschreibung:</b>\r\n            </td>\r\n            <td align="left" valign="top">{text}\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan="2"></td>\r\n        </tr>\r\n        <tr>\r\n             <td align="left" valign="top">\r\n                 <b>Dateien:</b>\r\n             </td>\r\n             <td align="left">{messages}\r\n             </td>\r\n         </tr>\r\n         <tr>\r\n             <td colspan="2"></td>\r\n         </tr>\r\n    </table>\r\n\r\n<table border="0" cellpadding="0" cellspacing="2" width="100%">\r\n<tr>\r\n  <td style="border: 1px solid #000000; padding: 3px;" colspan="2" ><strong>Datei (Download)</strong></td>\r\n  <td style="border: 1px solid #000000; padding: 3px;"><strong>Größe</strong></td>\r\n  <td style="border: 1px solid #000000; padding: 3px;"><strong>Traffic</strong></td>\r\n  <td style="border: 1px solid #000000; padding: 3px;"><strong>Downloads</strong></td>\r\n</tr>\r\n{files}\r\n<tr>\r\n  <td colspan="5" style="border: 1px solid #000000; padding: 3px;"><img alt="" src="images/design/null.gif"></td>\r\n</tr>\r\n{stats}\r\n</table>', '<tr>\r\n  <td style="border: 1px solid #000000; padding: 3px;"{mirror_col}><a target="_blank" href="{url}"><b>{name}</b></a></td>{mirror_ext}\r\n  <td style="border: 1px solid #000000; padding: 3px;">{size}</td>\r\n  <td style="border: 1px solid #000000; padding: 3px;">{traffic}</td>\r\n  <td style="border: 1px solid #000000; padding: 3px;">{hits}</td>\r\n</tr>', '<td style="border: 1px solid #000000; padding: 3px;" align="center" valign="middle"><b>Mirror!</b></td>', '<tr>\r\n              <td style="border: 1px solid #000000; padding: 3px;" colspan="2" >{number}</strong></td>\r\n              <td style="border: 1px solid #000000; padding: 3px;">{size}</td>\r\n              <td style="border: 1px solid #000000; padding: 3px;">{traffic}</td>\r\n              <td style="border: 1px solid #000000; padding: 3px;">{hits}</td>\r\n              </tr>', '<span class="small">{datum} </span><a class="small" href="{url}">{name}</a><br>', '<td align="center" valign="top">\r\n    <img class="thumb" onClick="open(''{url}'',''Picture'',''width=950,height=710,screenX=0,screenY=0'')" src="{thumbnail}" alt="{text}"><br>\r\n    {text}\r\n</td>', '<b>SCREENSHOT KATEGORIEN</b><p>\r\n<table width="100%">\r\n{cats}\r\n</table>', '<tr>\r\n    <td align="left">\r\n        <a href="{url}">{name}</a>\r\n    </td>\r\n    <td align="left">\r\n        erstellt am {datum}\r\n    </td>\r\n    <td align="left">\r\n        {menge} Bilder\r\n    </td>\r\n</tr>', '<b>SCREENSHOTS: {title}</b><p>\r\n<center>{page}</center><br />\r\n<table border="0" cellpadding="" cellspacing="10" width="100%">\r\n{screenshots}\r\n</table>', '<td align="center" valign="top">\r\n  <b>{text}</b><br />\r\n  <img src="{thumb_url}" alt="" />\r\n  <br /><br />\r\n  <b>Verfügbare Größen:</b>\r\n  {sizes}\r\n  <br />\r\n</td>', '<br />- <a href="{url}" target="_blank">{size}</a>', '<body leftmargin="0" topmargin="0">\r\n\r\n<center>\r\n<table cellspacing="0" cellpadding="3">\r\n <tr align="center">\r\n  <td>\r\n   <a href="{bild_url}" target="_blank">{bild}</a><br><b>{text}</b>\r\n  </td>\r\n </tr>\r\n <tr>\r\n</table>\r\n<table cellspacing="0" cellpadding="3">\r\n <tr>\r\n  <td width="33%" align="right">\r\n   <b>{weiter_grafik}</b>\r\n  </td>\r\n  <td width="33%" align="center">\r\n   <b>{close}</b>\r\n  </td>\r\n  <td width="33%" align="left">\r\n   <b>{zurück_grafik}</b>\r\n  </td>\r\n </tr>\r\n</table>\r\n</center>\r\n\r\n</body>', '<b>Willkommen {username}</b><br>\r\n<a class="small" href="{virtualhost}?go=editprofil">- Mein Profil</a><br>\r\n{admin}\r\n<a class="small" href="{logout}">- Logout</a>', '<a class=''small'' href=''{adminlink}'' target="_self">- Admin-CP</a><br />', '<div class="field_head" style="padding-left:60px; width:516px;">\r\n    <font class="h1" style="float:left; padding-top:14px;">Login</font>\r\n</div>\r\n<div class="field_middle" align="left">\r\n    <form action="" method="post">\r\n        <input type="hidden" name="go" value="login">\r\n        <input type="hidden" name="login" value="1">\r\n        <table align="center" border="0" cellpadding="4" cellspacing="0">\r\n            <tr>\r\n                <td align="right">\r\n                    <b>Name:</b>\r\n                </td>\r\n                <td>\r\n                    <input class="text" size="33" name="username" maxlength="100">\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td align="right">\r\n                    <b>Passwort:</b>\r\n                </td>\r\n                <td>\r\n                    <input class="text" size="33" type="password" name="userpassword" maxlength="16">\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td align="right">\r\n                    <b>Angemeldet bleiben:</b>\r\n                </td>\r\n                <td>\r\n                    <input type="checkbox" name="stayonline" value="1" checked>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td colspan="2" align="center">\r\n                    <input class="button" type="submit" value="Login">\r\n                </td>\r\n            </tr>\r\n        </table>\r\n    </form>\r\n    <p>\r\n    Du hast dich noch nicht registriert? Dann wirds jetzt aber Zeit ;) -> \r\n    <a href="?go=register">registrieren</a>\r\n    <p>\r\n</div>\r\n<div class="field_footer"></div>\r\n<p></p>', '<b>PROFIL ÄNDERN ({username})</b><p>\r\n<form action="" method="post" enctype="multipart/form-data">\r\n    <input type="hidden" name="go" value="editprofil">\r\n    <table align="center" border="0" cellpadding="4" cellspacing="0">\r\n        <tr>\r\n            <td width="50%" valign="top">\r\n                <b>Benutzerbild:</b>\r\n            </td>\r\n            <td width="50%">\r\n                {avatar}\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td>\r\n                <b>Benutzerbild hochladen:</b><br>\r\n                <font class="small">Nur wenn das alte überschrieben werden soll (max 110x110 px)</font>\r\n            </td>\r\n            <td>\r\n                <input class="text" size="16" type="file" name="userpic">\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td>\r\n                <b>E-Mail:</b><br>\r\n                <font class="small">Deine E-Mail Adresse</font>\r\n            </td>\r\n            <td>\r\n                <input class="text" size="34" value="{email}" name="usermail" maxlength="100">\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td>\r\n                <b>E-Mail zeigen:</b><br>\r\n                <font class="small">Zeige die E-Mail im öffentlichen Profil</font>\r\n            </td>\r\n            <td>\r\n                <input value="1" name="showmail" type="checkbox" {email_zeigen}>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan="2">\r\n                <br><b>Folgende Daten musst du nur angeben, wenn du dein Passwort ändern möchtest:</b><br>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td>\r\n                <b>Altes Passwort:</b><br>\r\n                <font class="small">Zur Sicherheit musst du zuerst dein altes Passwort eingeben</font>\r\n            </td>\r\n            <td>\r\n                <input class="text" size="33" type="password" name="oldpwd" maxlength="16" autocomplete="off">\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td>\r\n                <b>Neues Passwort:</b><br>\r\n                <font class="small">Gib jetzt dein gewünschtes neues Passwort ein</font>\r\n            </td>\r\n            <td>\r\n                <input class="text" size="33" type="password" name="newpwd" maxlength="16" autocomplete="off">\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td>\r\n                <b>Neues Passwort wiederholen:</b><br>\r\n                <font class="small">Wiederhole dieses Passwort jetzt nocheinmal zur Sicherheit</font>\r\n            </td>\r\n            <td>\r\n                <input class="text" size="33" type="password" name="wdhpwd" maxlength="16" autocomplete="off">\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan="2" align="center">\r\n                <input class="button" type="submit" value="Absenden">\r\n            </td>\r\n        </tr>\r\n    </table>\r\n</form>', '<b>Members List</b><br /><br />\r\n<table width="100%" border="0">\r\n<tr>\r\n  <td><b>Avatar</b></td>\r\n  <td><a href="?go=members&sort=name_{order_name}" style="color:#000;"><b>Benutzername</b> {arrow_name}</a></td>\r\n  <td><b>E-Mail</b></td>\r\n  <td><a href="?go=members&sort=regdate_{order_regdate}" style="color:#000;"><b>Registriert seit</b> {arrow_regdate}</a></td>\r\n  <td><a href="?go=members&sort=news_{order_news}" style="color:#000;"><b>News</b> {arrow_news}</a></td>\r\n  <td><a href="?go=members&sort=articles_{order_articles}" style="color:#000;"><b>Artikel</b> {arrow_articles}</a></td>\r\n  <td><a href="?go=members&sort=comments_{order_comments}" style="color:#000;"><b>Kommentare</b> {arrow_comments}</a></td>\r\n</tr>\r\n{members}\r\n</table><br /><br />\r\n<center>{page}</center>', '<tr>\r\n  <td align="center">{avatar}</td>\r\n  <td><a href="{userlink}" class="small">{username}</a></td>\r\n  <td>{email}</td>\r\n  <td align="center">{reg_date}</td>\r\n  <td align="center">{news}</td>\r\n  <td align="center">{articles}</td>\r\n  <td align="center">{comments}</td>\r\n</tr>', '<tr>\r\n  <td align="center">{avatar}</td>\r\n  <td><a href="{userlink}" class="small"><b><i>{username}</i></b></a></td>\r\n  <td>{email}</td>\r\n  <td align="center">{reg_date}</td>\r\n  <td align="center">{news}</td>\r\n  <td align="center">{articles}</td>\r\n  <td align="center">{comments}</td>\r\n</tr>', '<tr valign="top">\r\n                <td align="right" style="padding-top:4px;">\r\n                    <img src="{captcha_url}">\r\n                </td>\r\n                <td>\r\n                    <input class="text" name="spam" id="spam" size="30" maxlength="25"><br />\r\n<span class="small">Bitte löse diese kleine Rechenaufgabe.</span>\r\n                </td>\r\n            </tr>', '<br /><br />\r\n <table border="0" cellspacing="0" cellpadding="0" width="60%">\r\n  <tr>\r\n   <td valign="top" align="left">\r\n<div id="antispam"><font size="1">* Auf dieser Seite kann jeder einen Kommentar zu einer News abgeben. Leider ist sie dadurch ein beliebtes Ziel von sog. Spam-Bots - speziellen Programmen, die automatisiert und zum Teil massenhaft Links zu anderen Internetseiten platzieren. Um das zu verhindern müssen nicht registrierte User eine einfache Rechenaufgabe lösen, die für die meisten Spam-Bots aber nicht lösbar ist. Wenn du nicht jedesmal eine solche Aufgabe lösen möchtest, kannst du dich einfach bei uns <a href="?go=register">registrieren</a>.</font></div>\r\n   </td>\r\n  </tr>\r\n </table>', '<div class="field_head" style="padding-left:60px; width:516px;">\r\n    <font class="h1" style="float:left; padding-top:14px;">Community Map</font>\r\n</div>\r\n<div class="field_middle" align="left">\r\n    {karte}\r\n    <div align="right">\r\n        <font class="small">Zum betrachten der Karte wird Flash benötigt: </font><br>\r\n        <img border="0" src="images/design/flash_rune.gif" align="middle">\r\n        <a target="_blank" href="http://www.adobe.com/go/getflashplayer">\r\n            <img border="0" src="images/design/flash_download_now.gif" align="middle">\r\n        </a>\r\n    </div>\r\n</div>\r\n<div class="field_footer"></div>\r\n<p></p>', '<form name="poll" action="" method="post">\r\n    <input type="hidden" name="pollid" value="{poll_id}">\r\n    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">\r\n        <tr>\r\n            <td class="small" colspan="2" align="center">\r\n                <b>{question}</b>\r\n            </td>\r\n        </tr>\r\n{answers}\r\n        <tr>\r\n            <td colspan="2" align="center" ><br />\r\n                <input class="button" type="submit" value="Abstimmen" {button_state}><br />\r\n<a class="small" href="?go=pollarchiv&pollid={poll_id}"><b>Ergebnis anzeigen!</b></a>\r\n            </td>\r\n        </tr>\r\n    </table>\r\n</form>', '<tr>\r\n    <td valign="top">\r\n        <input type="{type}" name="answer{multiple}" value="{answer_id}">\r\n    </td>\r\n    <td align="left" class="small">\r\n        {answer}\r\n    </td>\r\n</tr>', '<b>UMFRAGEN ARCHIV</b><p>\r\n<b>{frage}</b><p>\r\n<table width="100%">\r\n{antworten}\r\n   <tr><td> </td></tr>\r\n   <tr><td align="left">Anzahl der Teilnehmer: </td><td align="left" colspan="2"><b>{participants}</b></td></tr>\r\n   <tr><td align="left">Anzahl der Stimmen: </td><td align="left" colspan="2"><b>{stimmen}</b></td></tr>\r\n   <tr><td align="left">Art der Umfrage: </td><td align="left" colspan="2">{typ}</td></tr>\r\n   <tr><td align="left">Umfragedauer:</td><td align="left" colspan="2">{start_datum} bis {end_datum}</td></tr>\r\n</table>', '<tr>\r\n    <td align="left">{antwort}</td>\r\n    <td align="left">{stimmen}</td>\r\n    <td align="left">\r\n        <div style="width:{balken_breite}px; height:4px; font-size:1px; background-color:#00FF00;">\r\n    </td>\r\n</tr>', '<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">\r\n    <tr>\r\n        <td class="small" colspan="2" align="center">\r\n            <b>{question}</b>\r\n        </td>\r\n    </tr>\r\n{answers}\r\n</table>\r\n<div class="small">Teilnehmer: {participants}</div>\r\n<b>Bereits abgestimmt!</b>', '<tr>\r\n    <td align="left" class="small" colspan="2">\r\n        {answer}\r\n    </td>\r\n</tr>\r\n<tr>\r\n    <td align="left" class="small">\r\n        {percentage}\r\n    </td>\r\n    <td align="left" style="width:100%;">\r\n        <div style="width:{bar_width}; height:4px; font-size:1px; background-color:#00FF00;">\r\n    </td>\r\n</tr>', '<b>UMFRAGEN ARCHIV</b><p>\r\n<table border="0" width="100%" cellpadding="2" cellspacing="0">\r\n<tr>\r\n  <td align="left"><a href="?go=pollarchiv&sort=name_{order_name}" style="color: #000"><b>Frage {arrow_name}</b></a></td>\r\n  <td align="left" width="100"><a href="?go=pollarchiv&sort=voters_{order_voters}" style="color: #000"><b>Teilnehmer {arrow_voters}</b></a></td>\r\n  <td align="left" width="70"><a href="?go=pollarchiv&sort=startdate_{order_startdate}" style="color: #000"><b>von {arrow_startdate}</b></a></td>\r\n  <td align="left" width="10"></td>\r\n  <td align="left" width="70"><a href="?go=pollarchiv&sort=enddate_{order_enddate}" style="color: #000"><b>bis {arrow_enddate}</b></a></td>\r\n</tr>\r\n{umfragen}\r\n</table>\r\n<p>', '<tr>\r\n   <td align="left"><a href="{url}">{frage}</a></td>\r\n   <td align="left">{voters}</td>\r\n   <td align="left" class="small">{start_datum}</td>\r\n   <td align="left" class="small">-</td>\r\n   <td align="left" class="small">{end_datum}</td>\r\n  </tr>', '<div class="small" align="center">\r\n    Zur Zeit keine<br>Umfrage aktiv\r\n</div>', '<b>PROFIL VON {username}</b><p>\r\n<table align="center" border="0" cellpadding="4" cellspacing="0">\r\n    <tr>\r\n        <td width="50%" valign="top">\r\n            <b>Benutzerbild:</b>\r\n        </td>\r\n        <td width="50%">\r\n            {avatar}\r\n        </td>\r\n    </tr>\r\n    <tr>\r\n        <td>\r\n            <b>E-Mail:</b>\r\n        </td>\r\n        <td>\r\n            {email}\r\n        </td>\r\n    </tr>\r\n    <tr>\r\n        <td>\r\n            <b>Registriert seit:</b>\r\n        </td>\r\n        <td>\r\n            {reg_datum}\r\n        </td>\r\n    </tr>\r\n    <tr>\r\n        <td>\r\n            <b>Geschriebene Kommentare:</b>\r\n        </td>\r\n        <td>\r\n            {kommentare}\r\n        </td>\r\n    </tr>\r\n    <tr>\r\n        <td>\r\n            <b>Geschriebene News:</b>\r\n        </td>\r\n        <td>\r\n            {news}\r\n        </td>\r\n    </tr>\r\n    <tr>\r\n        <td>\r\n            <b>Geschriebene Artikel:</b>\r\n        </td>\r\n        <td>\r\n            {artikel}\r\n        </td>\r\n    </tr>\r\n</table>', '- <b>{visits}</b> Visits<br>\r\n- <b>{visits_today}</b> Visits heute<br>\r\n- <b>{hits}</b> Hits<br>\r\n- <b>{hits_today}</b> Hits heute<br><br>\r\n\r\n- <b>{visitors_online}</b> Besucher online<br>\r\n- <b>{registered_online}</b> registrierte <br>\r\n- <b>{guests_online}</b> Gäste<br><br>\r\n\r\n- <b>{registered_users}</b> registrierte User<br>\r\n- <b>{news}</b> News<br>\r\n- <b>{comments}</b> Kommentare<br>\r\n- <b>{articles}</b> Artikel', '<b>REGISTRIEREN</b><p>\r\n<div>\r\n    Registriere dich im Frog System, um in den Genuss erweiterter Features zu kommen. Dazu zählen bisher:\r\n    <ul>\r\n        <li>Zugriff auf unsere Downloads</li>\r\n        <li>Hochladen eines eigenen Benutzerbildes, für die von dir geschriebenen Kommentare</li>\r\n    </ul>\r\n    Weitere Features werden folgen.\r\n    <p>\r\n    <form action="" method="post" onSubmit="return chkFormularRegister()">\r\n        <input type="hidden" value="register" name="go">\r\n        <table border="0" cellpadding="2" cellspacing="0" align="center">\r\n            <tr>\r\n                <td align="right">\r\n                    <b>Name:</b>\r\n                </td>\r\n                <td>\r\n                    <input class="text" size="30" name="username" id="username" maxlength="100">\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td align="right">\r\n                    <b>Passwort:</b>\r\n                </td>\r\n                <td>\r\n                    <input class="text" size="30" name="newpwd" id="newpwd" type="password" maxlength="16" autocomplete="off">\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td align="right">\r\n                    <b>Passwort wiederholen:</b>\r\n                </td>\r\n                <td>\r\n                    <input class="text" size="30" name="wdhpwd" id="wdhpwd" type="password" maxlength="16" autocomplete="off">\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td align="right">\r\n                    <b>E-Mail:</b>\r\n                </td>\r\n                <td>\r\n                    <input class="text" size="30" name="usermail" id="usermail" maxlength="100">\r\n                </td>\r\n            </tr>\r\n{antispam}\r\n            <tr>\r\n                <td colspan="2" align="center">\r\n                    <input type="submit" class="button" value="Registrieren">\r\n                </td>\r\n            </tr>\r\n        </table>\r\n    </form>\r\n    <p>\r\n</div>', '<div class="news_head" style="height:10px;" id ="{newsid}">\r\n    <span style="float:left;">\r\n       <b>[{kategorie_name}] {titel}</b>\r\n    </span>\r\n    <span class="small" style="float:right;">\r\n        <b>{datum}</b>\r\n    </span>\r\n</div>\r\n<div style="padding:3px;">\r\n    {text}\r\n    {related_links}\r\n</div>\r\n<div class="news_footer">\r\n    <span class="small" style="float:left;">\r\n        <a class="small" href="{kommentar_url}">Kommentare ({kommentar_anzahl})</a>\r\n    </span>\r\n    <span class="small" style="float:right;">\r\n        geschrieben von: <a class="small" href="{autor_profilurl}">{autor}</a>\r\n    </span>\r\n</div>\r\n<br><br>', '<b>NEWS</b><p>\r\n{headlines}<p>\r\n{news}', '{news}<p>\r\n{comments}<p>\r\n{comment_form}', '<b>Ankündigung:</b>\r\n<br><br>\r\n    {announcement_text}\r\n<br><br>', 'Hallo {username},\r\n\r\nDu hast dich im Frogsystem registriert. Deine Logindaten sind:\r\n\r\nUsername: {username}\r\nPasswort: {password}', 'Hallo {username},\r\n\r\nDein Passwort im Frogsystem wurde geändert. Deine neuen Logindaten sind:\r\n\r\nUsername: {username}\r\nPasswort: {password}', '<div align="center">\r\n  <b>{name}</b><br />\r\n  <a href="{url}" target="_blank">\r\n    <img src="{img_url}" border="0" alt="{name}"  title="{name}">\r\n  </a>\r\n  <br />\r\n  {text}\r\n</div>', 'Partner:\r\n{partner_all}', '<div align="center">\r\n  <a href="{url}" target="_blank">\r\n    <img src="{button_url}" border="0" alt="{name}"  title="{name}">\r\n  </a>\r\n  <br>\r\n</div>', '{permanents}\r\n\r\n<div align="center"><br><b>\r\nZufallsauswahl:</b><br>\r\n\r\n{non_permanents}\r\n\r\n<a href="?go=partner">alle Partner</a></div><br>', '<table cellpadding="5" align="center" border="0" width="90%">\r\n<tr><td><b><font face="verdana" size="2">Code:</font></b></td></tr>\r\n<tr><td style="border-collapse: collapse; border-style: dotted; border-color:#000000; border-width: 1"><font face="Courier New">{text}</font>\r\n</td></tr></table>', '<table cellpadding="5" align="center" border="0" width="90%">\r\n<tr><td><b><font face="verdana" size="2">Zitat:</font></b></td></tr>\r\n<tr><td style="border-collapse: collapse; border-style: dotted; border-color:#000000; border-width: 1">{text}\r\n</td></tr></table>', '<table cellpadding="5" align="center" border="0" width="90%">\r\n<tr><td><b><font face="verdana" size="2">Zitat von {author}:</font></b></td></tr>\r\n<tr><td style="border-collapse: collapse; border-style: dotted; border-color:#000000; border-width: 1">{text}\r\n</td></tr></table>', '<table cellpadding="0" cellspacing="0" border="0" style="padding-bottom:4px">\r\n  <tr valign="bottom">\r\n    {buttons}\r\n  </tr>\r\n</table>\r\n\r\n<table cellpadding="0" cellspacing="0" border="0">\r\n  <tr valign="top">\r\n    <td>\r\n      <textarea {style}>{text}</textarea>\r\n    </td>\r\n    <td style="width:4px; empty-cells:show;">\r\n    </td>\r\n    <td>\r\n      {smilies}\r\n    </td>\r\n  </tr>\r\n</table>\r\n<br />', '.editor_button {\r\n  font-size:8pt;\r\n  font-family:Verdana;\r\n  border:1px solid #000000;\r\n  background-color:#CCCCCC;\r\n  width:20px;\r\n  height:20px;\r\n  cursor:pointer;\r\n  text-align:center;\r\n}\r\n.editor_button:hover {\r\n  background-color:#A5E5A5;\r\n}\r\n.editor_td {\r\n  width:24px;\r\n  height:23px;\r\n  vertical-align:bottom;\r\n  text-align:left;\r\n}\r\n.editor_td_seperator {\r\n  width:5px;\r\n  height:23px;\r\n  background-image:url("images/icons/separator.gif");\r\n  background-repeat:no-repeat;\r\n  background-position:top left;\r\n}\r\n.editor_smilies {\r\n  cursor:pointer;\r\n  padding:0px;\r\n}', '  <td class="editor_td">\r\n    <div class="editor_button" {javascript}>\r\n      <img src="{img_url}" alt="{alt}" title="{title}" />\r\n    </div>\r\n  </td>', '<td class="editor_td_seperator"></td>', '<a href="{navi_url}"><img src="{icon_url}" alt="" border="0">   {title}</a><br>', '{lines}', '<b>{intro_text}</b><br><br>', '<br><br><b>{note_text}</b>', '<tr valign="top">\r\n  <td>\r\n   <img src="{lang_img_url}" alt="{lang_title}" title="{lang_title}">\r\n  </td>\r\n  <td>\r\n   <a href="{url}" target="_blank">\r\n    <b>{title}</b>\r\n   </a>\r\n   <br>{date}\r\n  </td>\r\n  <td style="text-align: justify;">\r\n   {intro}\r\n   {text}\r\n   {note}\r\n  </td>\r\n </tr>', '<b>PRESSEBERICHTE</b>\r\n<br />\r\n{navigation}\r\n{press_container}', '<br /><br />\r\n<table cellspacing="12">\r\n <tr>\r\n  <td></td>\r\n  <td><b>Seite / Datum</b></td>\r\n  <td><b>Leseprobe</b></td>\r\n </tr>\r\n {press_releases}\r\n</table>');
INSERT INTO `fs_template` (`id`, `name`, `style_css`, `js_userfunctions`, `indexphp`, `doctype`, `artikel_body`, `artikel_autor`, `randompic_body`, `randompic_nobody`, `shop_body`, `shop_hot`, `news_link`, `news_related_links`, `news_headline`, `main_menu`, `news_comment_body`, `news_comment_autor`, `news_comment_form`, `news_comment_form_name`, `news_comment_form_spam`, `news_comment_form_spamtext`, `news_search_form`, `error`, `news_headline_body`, `user_mini_login`, `shop_main_body`, `shop_artikel`, `dl_navigation`, `dl_search_field`, `dl_body`, `dl_datei_preview`, `dl_file_body`, `dl_file`, `dl_file_is_mirror`, `dl_stats`, `dl_quick_links`, `screenshot_pic`, `screenshot_body`, `screenshot_cat`, `screenshot_cat_body`, `wallpaper_pic`, `wallpaper_sizes`, `pic_viewer`, `user_user_menu`, `user_admin_link`, `user_login`, `user_profiledit`, `user_memberlist_body`, `user_memberlist_userline`, `user_memberlist_adminline`, `user_spam`, `user_spamtext`, `community_map`, `poll_body`, `poll_line`, `poll_main_body`, `poll_main_line`, `poll_result`, `poll_result_line`, `poll_list`, `poll_list_line`, `poll_no_poll`, `user_profil`, `statistik`, `user_register`, `news_body`, `news_container`, `news_comment_container`, `announcement`, `email_register`, `email_passchange`, `partner_eintrag`, `partner_main_body`, `partner_navi_eintrag`, `partner_navi_body`, `code_tag`, `quote_tag`, `quote_tag_name`, `editor_design`, `editor_css`, `editor_button`, `editor_seperator`, `press_navi_line`, `press_navi_main`, `press_intro`, `press_note`, `press_body`, `press_main_body`, `press_container`) VALUES
(0, 'default', 'body\r\n{\r\n    background-color:#7EC46B;\r\n    margin:0px;\r\n    font-family:Verdana;\r\n    color:#000000;\r\n    font-size:8pt;\r\n}\r\n.small\r\n{\r\n    font-size:7pt;\r\n}\r\n\r\na\r\n{\r\n    color:#008800;\r\n    font-size:8pt;\r\n    text-decoration:none;\r\n}\r\na.small\r\n{\r\n    color:#008800;\r\n    font-size:7pt;\r\n    text-decoration:none;\r\n}\r\n\r\n.thumb\r\n{\r\n    cursor:pointer;\r\n}\r\n\r\n\r\n#head_shadow\r\n{\r\n    position:absolute;\r\n    z-index:1;\r\n    background-color:#2B4325;\r\n    top:26px;\r\n    height:86px;\r\n    left:50%;\r\n    width:870px;\r\n    margin-left:-433px;\r\n}\r\n#head\r\n{\r\n    position:absolute;\r\n    z-index:2;\r\n    background-color:#EEEEEE;\r\n    background-image:url("images/icons/logo.gif");\r\n    top:24px;\r\n    height:84px;\r\n    left:50%;\r\n    width:868px;\r\n    margin-left:-435px;\r\n    border:1px solid #000000;\r\n}\r\n\r\n#menu_l_shadow\r\n{\r\n    position:absolute;\r\n    z-index:1;\r\n    background-color:#2B4325;\r\n    top:120px;\r\n    left:50%;\r\n    width:120px;\r\n    margin-left:-433px;\r\n}\r\n#menu_l\r\n{\r\n    position:relative;\r\n    z-index:2;\r\n    background-color:#EEEEEE;\r\n    top:-2px;\r\n    left:-2px;;\r\n    width:112px;\r\n    border:1px solid #000000;\r\n    padding:3px;\r\n    font-size:7pt;\r\n}\r\n\r\n#main_container\r\n{\r\n    position:absolute;\r\n    z-index:0;\r\n    top:120px;\r\n    left:50%;\r\n    width:612px;\r\n    margin-left:-304px;\r\n}\r\n#main_shadow\r\n{\r\n    position:relative;\r\n    z-index:1;\r\n    background-color:#2B4325;\r\n    width:612px;\r\n}\r\n#main\r\n{\r\n    position:relative;\r\n    z-index:2;\r\n    background-color:#EEEEEE;\r\n    top:-2px;\r\n    left:-2px;;\r\n    width:600px;\r\n    border:1px solid #000000;\r\n    padding:5px;\r\n    padding-bottom:15px;\r\n}\r\n\r\n#menu_r_shadow\r\n{\r\n    position:absolute;\r\n    z-index:1;\r\n    background-color:#2B4325;\r\n    top:120px;\r\n    left:50%;\r\n    width:120px;\r\n    margin-left:317px;\r\n}\r\n#menu_r\r\n{\r\n    position:relative;\r\n    z-index:2;\r\n    background-color:#EEEEEE;\r\n    top:-2px;\r\n    left:-2px;;\r\n    width:112px;\r\n    border:1px solid #000000;\r\n    padding:3px;\r\n    font-size:7pt;\r\n}\r\n\r\n.news_head\r\n{\r\n    padding-bottom:2px;\r\n    border-bottom:1px solid #000000;\r\n}\r\n.news_footer\r\n{\r\n    padding-top:2px;\r\n    border-top:1px solid #000000;\r\n}\r\n\r\n.text\r\n{\r\n    border:1px solid #000000;\r\n    background-color: #CCCCCC;\r\n    font-family:Verdana;\r\n    color:#000000;\r\n    font-size:8pt;\r\n}\r\n.button\r\n{\r\n    border:1px solid #000000;\r\n    background-color: #CCCCCC;\r\n    font-family:Verdana;\r\n    color:#000000;\r\n    font-size:7pt;\r\n}', 'function chkFormularComment()\r\n    {\r\n        if((document.getElementById("name").value == "") ||\r\n           (document.getElementById("title").value == "") ||\r\n           (document.getElementById("text").value == ""))\r\n        {\r\n            alert ("Du hast nicht alle Felder ausgefüllt");\r\n            return false;\r\n        }\r\n    }\r\n    \r\nfunction chkFormularNewsSearch()\r\n    {\r\n        if (document.getElementById("keyword").value.length < "4")\r\n        {\r\n            alert("Es müssen mehr als 3 Zeichen sein");\r\n            return false;\r\n        }\r\n    }\r\n\r\nfunction chkFormularRegister() \r\n{\r\n    if((document.getElementById("username").value == "") ||\r\n       (document.getElementById("usermail").value == "") ||\r\n       (document.getElementById("newpwd").value == "") ||\r\n       (document.getElementById("wdhpwd").value == ""))\r\n    {\r\n        alert("Du hast nicht alle Felder ausgefüllt"); \r\n        return false;\r\n    }\r\n    if(document.getElementById("newpwd").value != document.getElementById("wdhpwd").value)\r\n    {\r\n        alert("Passwöter sind verschieden"); \r\n        return false;\r\n    }\r\n}', '<body>\r\n    <div id="head_shadow"></div>\r\n    <div id="head"></div>\r\n\r\n    <div id="menu_l_shadow">\r\n        <div id="menu_l">\r\n{main_menu}\r\n        </div>\r\n    </div>\r\n    <div id="main_container">\r\n        <div id="main_shadow">\r\n            <div id="main">\r\n{announcement}\r\n{content}\r\n            </div>\r\n        </div>\r\n        <div style="width:100%; text-align:center; margin-top:10px; font-size:7pt; padding-bottom:10px;">{copyright}</div>\r\n    </div>\r\n\r\n    <div id="menu_r_shadow">\r\n        <div id="menu_r">\r\n{user}<br><br>\r\nZufallsbild:<br>\r\n{randompic}<br>\r\nShop:<br>\r\n{shop}<br><br>\r\nUmfrage:<br>\r\n{poll}<br>\r\nPartner:<br>\r\n{partner}\r\nStatistik:<br>\r\n{stats}<br><br>\r\nNews-Feeds:<br>\r\n[%feeds%]\r\n        </div>\r\n    </div>\r\n</body>', '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">', '<div class="news_head" style="height:10px;">\r\n   <span style="float:left;">\r\n       <b>{title}</b>\r\n   </span>\r\n   <span class="small" style="float:right;">\r\n       <b>{date}</b>\r\n   </span>\r\n</div>\r\n<div>\r\n   {text}\r\n</div>\r\n<div>\r\n   <span class="small" style="float:right;">\r\n       {author_template}\r\n   </span>\r\n</div>', 'geschrieben von <a class="small" href="{profile_url}">{user_name}</a>', '<img class=\\"thumb\\" onClick=\\"open(\\''{link}\\'',\\''Picture\\'',\\''width=900,height=710,screenX=0,screenY=0\\'')\\" src=\\"{thumb}\\" alt=\\"{titel}\\">', '<div class=\\"small\\" align=\\"center\\">\r\n     Kein Zufallsbild aktiv\r\n</div>', '{hotlinks}', '<div align="center">\r\n    <a style="font-weight:bold;" class="small" target="_blank" href="{link}">{titel}</a>\r\n</div>', '<li><a href="{url}" target="{target}">{name}</a></li>', '<p>\r\n<b>Related Links:</b>\r\n<ul>\r\n    {links}\r\n</ul>', '<span class="small">{datum} </span><a class="small" href="{url}">{titel}</a><br>', '<b>Allgemein</b><br>\r\n<a class="small" href="{virtualhost}?go=news">- News</a><br>\r\n<a class="small" href="{virtualhost}?go=newsarchiv">- News Archiv</a><br>\r\n<a class="small" href="{virtualhost}?go=members">- Mitgliederliste</a><br>\r\n<a class="small" href="{virtualhost}?go=pollarchiv">- Umfragen Archiv</a><br>\r\n<a class="small" href="{virtualhost}?go=gallery">- Galerie</a><br>\r\n<a class="small" href="{virtualhost}?go=download">- Downloads</a><br>\r\n<a class="small" href="{virtualhost}?go=press">- Presseberichte</a><br>\r\n<a class="small" href="{virtualhost}?go=fscode">- FSCode</a><br>\r\n<a class="small" href="{virtualhost}?go=partner">- Partnerseiten</a><br>\r\n<a class="small" href="{virtualhost}?go=shop">- Shop</a><br>', '<div class="news_head" style="height:10px;">\r\n    <span style="float:left;">\r\n        <b>{titel}</b>\r\n    </span>\r\n    <span class="small" style="float:right;">\r\n        <b>{datum}</b>\r\n    </span>\r\n</div>\r\n<div style="padding:3px;">\r\n    <table border="0" cellpadding="0" cellspacing="0" width="100%">\r\n        <tr>\r\n            <td align="left" valign="top">\r\n                {autor_avatar}\r\n            </td>\r\n            <td valign="top" align="left">\r\n                {text}\r\n            </td>\r\n        </tr>\r\n    </table>\r\n</div>\r\n<div class="news_footer">\r\n    <span class="small" style="float:right;">\r\n        geschrieben von: {autor}</a>\r\n    </span>\r\n</div>\r\n<br><br><br>', '<a class="small" href="{url}">{name}</a>', '<b id="add">Kommentar hinzufügen</b><p>\r\n<div>\r\n    <form action="" method="post" onSubmit="return chkFormularComment()">\r\n       <input type="hidden" name="go" value="comments">\r\n       <input type="hidden" name="addcomment" value="1">\r\n       <input type="hidden" name="id" value="{newsid}">\r\n       <table width="100%">\r\n           <tr>\r\n               <td align="left">\r\n                   <b>Name: </b>\r\n               </td>\r\n               <td align="left">\r\n                   {name_input}\r\n               </td>\r\n           </tr>\r\n           <tr>\r\n               <td align="left">\r\n                   <b>Titel: </b>\r\n               </td>\r\n               <td align="left">\r\n                   <input class="text" name="title" id="title" size="32" maxlength="32">\r\n               </td>\r\n           </tr>\r\n{antispam}\r\n           <tr>\r\n               <td align="left" valign="top">\r\n                   <b>Text:</b><br />\r\n                     <font class="small">Html ist {html}.<br />\r\n                     FScode ist {fs_code}.</font>\r\n               </td>\r\n               <td align="left">\r\n                   {textarea}\r\n               </td>\r\n           </tr>\r\n           <tr>\r\n               <td></td>\r\n               <td align="left">\r\n                   <input class="button" type="submit" value="Absenden">\r\n               </td>\r\n           </tr>\r\n           <tr>\r\n               <td></td>\r\n               <td align="left">\r\n                  {antispamtext}\r\n               </td>\r\n           </tr>\r\n       </table>\r\n   </form>\r\n</div><p>', '<input class="text" name="name" id="name" size="32" maxlength="25">\r\n<span class="small"> Willst du dich </span>\r\n<a class="small" href="?go=login">einloggen?</a>', '<tr>\r\n                <td align="left">\r\n                    <img src="{captcha_url}">\r\n                </td>\r\n                <td align="left">\r\n                    <input class="text" name="spam" id="spam" size="32" maxlength="25">\r\n<span class="small">Bitte löse diese kleine Rechenaufgabe.</span> <a class="small" href="#antispam">Warum? *</a>\r\n                </td>\r\n            </tr>', '<br /><br />\r\n <table border="0" cellspacing="0" cellpadding="0" width="60%">\r\n  <tr>\r\n   <td valign="top" align="left">\r\n<div id="antispam"><font size="1">* Auf dieser Seite kann jeder einen Kommentar zu einer News abgeben. Leider ist sie dadurch ein beliebtes Ziel von sog. Spam-Bots - speziellen Programmen, die automatisiert und zum Teil massenhaft Links zu anderen Internetseiten platziern. Um das zu verhindern müssen nicht registrierte User eine einfache Rechenaufgabe lösen, die für die meisten Spam-Bots aber nicht lösbar ist. Wenn du nicht jedesmal eine solche Aufgabe lösen möchtest, kannst du dich einfach bei uns <a href="?go=register">registrieren</a>.</font></div>\r\n   </td>\r\n  </tr>\r\n </table>', '<b>NEWSARCHIV</b><p>\r\n<div>\r\n   <form action="" method="post">\r\n       <input type="hidden" name="go" value="newsarchiv">\r\n       <b>News aus dem: </b>\r\n       <select class="text" name="monat">\r\n           <option value="1">Januar</option>\r\n           <option value="2">Februar</option>\r\n           <option value="3">März</option>\r\n           <option value="4">April</option>\r\n           <option value="5">Mai</option>\r\n           <option value="6">Juni</option>\r\n           <option value="7">Juli</option>\r\n           <option value="8">August</option>\r\n           <option value="9">September</option>\r\n           <option value="10">Oktober</option>\r\n           <option value="11">November</option>\r\n           <option value="12">Dezember</option>\r\n       </select>\r\n       <select class="text" name="jahr">\r\n           {years}\r\n       </select>\r\n       <input class="button" type="submit" value="Anzeigen">\r\n   </form>\r\n   <p>\r\n   oder\r\n   <p>\r\n   <form action="" method="post" onSubmit="return chkFormularNewsSearch()">\r\n       <input type="hidden" name="go" value="newsarchiv">\r\n       <b>Nach: </b>\r\n       <input class="text" id="keyword" name="keyword" size="30" maxlength="20">\r\n       <input class="button" type="submit" value="Suchen">\r\n   </form>\r\n</div>\r\n<p></p>', '<b>{titel}</b><br>\r\n{meldung}\r\n<p></p>', '<div>\r\n    <b>Headlines:</b><br>\r\n    {headlines}\r\n</div>\r\n<div>\r\n    <b>Downloads:</b><br>\r\n    {downloads}\r\n</div>', '<tr>\r\n    <b>Einloggen</b>\r\n</tr>\r\n<tr>\r\n    <td align="center">\r\n        <form action="" method="post">\r\n            <input type="hidden" name="go" value="login">\r\n            <input type="hidden" name="login" value="1">\r\n            <table align="center" border="0" cellpadding="0" cellspacing="0" width="120">\r\n                <tr>\r\n                    <td align="right">\r\n                        <font class="small">Name:</font>\r\n                    </td>\r\n                    <td>\r\n                        <input class="text" size="10" name="username" maxlength="100">\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <td align="right">\r\n                        <font class="small">Pass:</font>\r\n                    </td>\r\n                    <td>\r\n                        <input class="text" size="10" type="password" name="userpassword" maxlength="16">\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <td align="center" colspan="2">\r\n                        <input type="checkbox" name="stayonline" value="1" checked>\r\n                        <font class="small">eingeloggt bleiben</font>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <td align="center" colspan="2">\r\n                        <input class="button" type="submit" value="Anmelden">\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan="2" align="center">\r\n                        <a class="small" href="?go=register">Noch nicht registriert?</a>\r\n                    </td>\r\n                </tr>\r\n            </table>\r\n        </form>\r\n    </td>\r\n</tr>', '<b>SHOP</b><p>\r\n<table width="100%">\r\n    {artikel}\r\n</table>', '<tr>\r\n    <td align="left" valign="top" width="60" rowspan="4">\r\n        <img border="0" style="cursor:pointer;" onClick=open(''showimg.php?pic={bild}'',''Picture'',''width=900,height=710,screenX=0,screenY=0'') src="{thumbnail}">\r\n    </td>\r\n    <td align="left" width="100">\r\n        <b>Titel:</b>\r\n    </td>\r\n        <td align="left">\r\n            {titel}\r\n        </td>\r\n    </tr>\r\n<tr>\r\n    <td align="left" valign="top">\r\n        <b>Beschreibung:</b>\r\n    </td>\r\n    <td align="left" valign="top">\r\n        {beschreibung}</td>\r\n    </tr>\r\n<tr>\r\n    <td align="left">\r\n        <b>Preis:</b>\r\n    </td>\r\n    <td align="left">\r\n        {preis} ¤\r\n    </td>\r\n</tr>\r\n<tr>\r\n    <td align="left"></td>\r\n    <td align="left">\r\n        <a href="{bestell_url}" target="_blank">Jetzt bestellen!</a>\r\n    </td>\r\n</tr>\r\n<tr>\r\n    <td colspan="3">\r\n         \r\n    </td>\r\n</tr>', '<img border="0" src="images/design/{icon}">\r\n<a href="{kategorie_url}">{kategorie_name}</a><br>', '<form action="" method="get">\r\n<tr>\r\n  <td colspan="3" align="right"><br /> <b>Kategorie durchsuchen:</b></td>\r\n  <td colspan="1" align="left"><br /> \r\n    <input class="text" size="20" name="keyword" value="{keyword}">\r\n    <input class="button" type="submit" value="Go">\r\n    <input class="button" type="button" value="Alle anzeigen" onclick="location=''{all_url}''">\r\n    <input type="hidden" name="go" value="download">\r\n    {input_cat}</td>\r\n</tr>\r\n\r\n</form>', '<b>DOWNLOADS</b><p>\r\n{navigation}\r\n<table border="0" cellpadding="0" cellspacing="2" width="100%">\r\n<tr>\r\n  <td style="border: 1px solid #000000; padding: 3px;"><strong>Titel</strong></td>\r\n  <td style="border: 1px solid #000000; padding: 3px;"><strong>Kategorie</strong></td>\r\n  <td style="border: 1px solid #000000; padding: 3px;"><strong>Uploaddatum</strong></td>\r\n  <td style="border: 1px solid #000000; padding: 3px;"><strong>Beschreibung</strong></td>\r\n </tr>\r\n{dateien}\r\n{suchfeld}\r\n</table>', '<tr>\r\n  <td style="border: 1px solid #000000; padding: 3px;"><a href="{url}"><b>{name}</b></a></td>\r\n  <td style="border: 1px solid #000000; padding: 3px;" align="center" valign="middle">{cat}</td>\r\n  <td style="border: 1px solid #000000; padding: 3px;" align="center" valign="middle">{datum}</td>\r\n  <td style="border: 1px solid #000000; padding: 3px;">{text}</td>\r\n </tr>', '<b>DOWNLOADS -> {titel}</b><p>\r\n{navigation}\r\n    <table width="100%">\r\n        <tr>\r\n            <td align="left" width="130" rowspan="6" valign="top">\r\n                <img class="thumb" onClick=open(''showimg.php?pic={bild}'',''Picture'',''width=900,height=710,screenX=0,screenY=0'') src="{thumbnail}">\r\n            </td>\r\n        </tr>\r\n         <tr>\r\n            <td align="left" colspan="2" height="20" valign="top">\r\n                <b>{titel}</b>\r\n            </td>\r\n        </tr>\r\n       <tr>\r\n            <td align="left" width="75">\r\n                <b>Kategorie:</b>\r\n            </td>\r\n            <td align="left">\r\n                {cat}\r\n            </td>\r\n        </tr>\r\n       <tr>\r\n            <td align="left" width="75">\r\n                <b>Datum:</b>\r\n            </td>\r\n            <td align="left">\r\n                {datum}\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td align="left" width="75">\r\n                <b>Uploader:</b>\r\n            </td>\r\n            <td align="left">\r\n                <a href="{uploader_url}">{uploader}</a>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td align="left" width="75">\r\n                <b>Autor:</b>\r\n            </td>\r\n            <td align="left">\r\n                {autor_link}\r\n            </td>\r\n        </tr>\r\n    </table>\r\n    <br>\r\n    <table width="100%">\r\n        <tr>\r\n            <td align="left" valign="top" width="130">\r\n                <b>Beschreibung:</b>\r\n            </td>\r\n            <td align="left" valign="top">{text}\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan="2"></td>\r\n        </tr>\r\n        <tr>\r\n             <td align="left" valign="top">\r\n                 <b>Dateien:</b>\r\n             </td>\r\n             <td align="left">{messages}\r\n             </td>\r\n         </tr>\r\n         <tr>\r\n             <td colspan="2"></td>\r\n         </tr>\r\n    </table>\r\n\r\n<table border="0" cellpadding="0" cellspacing="2" width="100%">\r\n<tr>\r\n  <td style="border: 1px solid #000000; padding: 3px;" colspan="2" ><strong>Datei (Download)</strong></td>\r\n  <td style="border: 1px solid #000000; padding: 3px;"><strong>Größe</strong></td>\r\n  <td style="border: 1px solid #000000; padding: 3px;"><strong>Traffic</strong></td>\r\n  <td style="border: 1px solid #000000; padding: 3px;"><strong>Downloads</strong></td>\r\n</tr>\r\n{files}\r\n<tr>\r\n  <td colspan="5" style="border: 1px solid #000000; padding: 3px;"><img alt="" src="images/design/null.gif"></td>\r\n</tr>\r\n{stats}\r\n</table>', '<tr>\r\n  <td style="border: 1px solid #000000; padding: 3px;"{mirror_col}><a target="_blank" href="{url}"><b>{name}</b></a></td>{mirror_ext}\r\n  <td style="border: 1px solid #000000; padding: 3px;">{size}</td>\r\n  <td style="border: 1px solid #000000; padding: 3px;">{traffic}</td>\r\n  <td style="border: 1px solid #000000; padding: 3px;">{hits}</td>\r\n</tr>', '<td style="border: 1px solid #000000; padding: 3px;" align="center" valign="middle"><b>Mirror!</b></td>', '<tr>\r\n              <td style="border: 1px solid #000000; padding: 3px;" colspan="2" >{number}</strong></td>\r\n              <td style="border: 1px solid #000000; padding: 3px;">{size}</td>\r\n              <td style="border: 1px solid #000000; padding: 3px;">{traffic}</td>\r\n              <td style="border: 1px solid #000000; padding: 3px;">{hits}</td>\r\n              </tr>', '<span class="small">{datum} </span><a class="small" href="{url}">{name}</a><br>', '<td align="center" valign="top">\r\n    <img class="thumb" onClick="open(''{url}'',''Picture'',''width=950,height=710,screenX=0,screenY=0'')" src="{thumbnail}" alt="{text}"><br>\r\n    {text}\r\n</td>', '<b>SCREENSHOT KATEGORIEN</b><p>\r\n<table width="100%">\r\n{cats}\r\n</table>', '<tr>\r\n    <td align="left">\r\n        <a href="{url}">{name}</a>\r\n    </td>\r\n    <td align="left">\r\n        erstellt am {datum}\r\n    </td>\r\n    <td align="left">\r\n        {menge} Bilder\r\n    </td>\r\n</tr>', '<b>SCREENSHOTS: {title}</b><p>\r\n<center>{page}</center><br />\r\n<table border="0" cellpadding="" cellspacing="10" width="100%">\r\n{screenshots}\r\n</table>', '<td align="center" valign="top">\r\n  <b>{text}</b><br />\r\n  <img src="{thumb_url}" alt="" />\r\n  <br /><br />\r\n  <b>Verfügbare Größen:</b>\r\n  {sizes}\r\n  <br />\r\n</td>', '<br />- <a href="{url}" target="_blank">{size}</a>', '<body leftmargin="0" topmargin="0">\r\n\r\n<center>\r\n<table cellspacing="0" cellpadding="3">\r\n <tr align="center">\r\n  <td>\r\n   <a href="{bild_url}" target="_blank">{bild}</a><br><b>{text}</b>\r\n  </td>\r\n </tr>\r\n <tr>\r\n</table>\r\n<table cellspacing="0" cellpadding="3">\r\n <tr>\r\n  <td width="33%" align="right">\r\n   <b>{weiter_grafik}</b>\r\n  </td>\r\n  <td width="33%" align="center">\r\n   <b>{close}</b>\r\n  </td>\r\n  <td width="33%" align="left">\r\n   <b>{zurück_grafik}</b>\r\n  </td>\r\n </tr>\r\n</table>\r\n</center>\r\n\r\n</body>', '<b>Willkommen {username}</b><br>\r\n<a class="small" href="{virtualhost}?go=editprofil">- Mein Profil</a><br>\r\n{admin}\r\n<a class="small" href="{logout}">- Logout</a>', '<a class=''small'' href=''{adminlink}'' target="_self">- Admin-CP</a><br />', '<div class="field_head" style="padding-left:60px; width:516px;">\r\n    <font class="h1" style="float:left; padding-top:14px;">Login</font>\r\n</div>\r\n<div class="field_middle" align="left">\r\n    <form action="" method="post">\r\n        <input type="hidden" name="go" value="login">\r\n        <input type="hidden" name="login" value="1">\r\n        <table align="center" border="0" cellpadding="4" cellspacing="0">\r\n            <tr>\r\n                <td align="right">\r\n                    <b>Name:</b>\r\n                </td>\r\n                <td>\r\n                    <input class="text" size="33" name="username" maxlength="100">\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td align="right">\r\n                    <b>Passwort:</b>\r\n                </td>\r\n                <td>\r\n                    <input class="text" size="33" type="password" name="userpassword" maxlength="16">\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td align="right">\r\n                    <b>Angemeldet bleiben:</b>\r\n                </td>\r\n                <td>\r\n                    <input type="checkbox" name="stayonline" value="1" checked>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td colspan="2" align="center">\r\n                    <input class="button" type="submit" value="Login">\r\n                </td>\r\n            </tr>\r\n        </table>\r\n    </form>\r\n    <p>\r\n    Du hast dich noch nicht registriert? Dann wirds jetzt aber Zeit ;) -> \r\n    <a href="?go=register">registrieren</a>\r\n    <p>\r\n</div>\r\n<div class="field_footer"></div>\r\n<p></p>', '<b>PROFIL ÄNDERN ({username})</b><p>\r\n<form action="" method="post" enctype="multipart/form-data">\r\n    <input type="hidden" name="go" value="editprofil">\r\n    <table align="center" border="0" cellpadding="4" cellspacing="0">\r\n        <tr>\r\n            <td width="50%" valign="top">\r\n                <b>Benutzerbild:</b>\r\n            </td>\r\n            <td width="50%">\r\n                {avatar}\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td>\r\n                <b>Benutzerbild hochladen:</b><br>\r\n                <font class="small">Nur wenn das alte überschrieben werden soll (max 110x110 px)</font>\r\n            </td>\r\n            <td>\r\n                <input class="text" size="16" type="file" name="userpic">\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td>\r\n                <b>E-Mail:</b><br>\r\n                <font class="small">Deine E-Mail Adresse</font>\r\n            </td>\r\n            <td>\r\n                <input class="text" size="34" value="{email}" name="usermail" maxlength="100">\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td>\r\n                <b>E-Mail zeigen:</b><br>\r\n                <font class="small">Zeige die E-Mail im öffentlichen Profil</font>\r\n            </td>\r\n            <td>\r\n                <input value="1" name="showmail" type="checkbox" {email_zeigen}>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan="2">\r\n                <br><b>Folgende Daten musst du nur angeben, wenn du dein Passwort ändern möchtest:</b><br>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td>\r\n                <b>Altes Passwort:</b><br>\r\n                <font class="small">Zur Sicherheit musst du zuerst dein altes Passwort eingeben</font>\r\n            </td>\r\n            <td>\r\n                <input class="text" size="33" type="password" name="oldpwd" maxlength="16" autocomplete="off">\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td>\r\n                <b>Neues Passwort:</b><br>\r\n                <font class="small">Gib jetzt dein gewünschtes neues Passwort ein</font>\r\n            </td>\r\n            <td>\r\n                <input class="text" size="33" type="password" name="newpwd" maxlength="16" autocomplete="off">\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td>\r\n                <b>Neues Passwort wiederholen:</b><br>\r\n                <font class="small">Wiederhole dieses Passwort jetzt nocheinmal zur Sicherheit</font>\r\n            </td>\r\n            <td>\r\n                <input class="text" size="33" type="password" name="wdhpwd" maxlength="16" autocomplete="off">\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan="2" align="center">\r\n                <input class="button" type="submit" value="Absenden">\r\n            </td>\r\n        </tr>\r\n    </table>\r\n</form>', '<b>Members List</b><br /><br />\r\n<table width="100%" border="0">\r\n<tr>\r\n  <td><b>Avatar</b></td>\r\n  <td><a href="?go=members&sort=name_{order_name}" style="color:#000;"><b>Benutzername</b> {arrow_name}</a></td>\r\n  <td><b>E-Mail</b></td>\r\n  <td><a href="?go=members&sort=regdate_{order_regdate}" style="color:#000;"><b>Registriert seit</b> {arrow_regdate}</a></td>\r\n  <td><a href="?go=members&sort=news_{order_news}" style="color:#000;"><b>News</b> {arrow_news}</a></td>\r\n  <td><a href="?go=members&sort=articles_{order_articles}" style="color:#000;"><b>Artikel</b> {arrow_articles}</a></td>\r\n  <td><a href="?go=members&sort=comments_{order_comments}" style="color:#000;"><b>Kommentare</b> {arrow_comments}</a></td>\r\n</tr>\r\n{members}\r\n</table><br /><br />\r\n<center>{page}</center>', '<tr>\r\n  <td align="center">{avatar}</td>\r\n  <td><a href="{userlink}" class="small">{username}</a></td>\r\n  <td>{email}</td>\r\n  <td align="center">{reg_date}</td>\r\n  <td align="center">{news}</td>\r\n  <td align="center">{articles}</td>\r\n  <td align="center">{comments}</td>\r\n</tr>', '<tr>\r\n  <td align="center">{avatar}</td>\r\n  <td><a href="{userlink}" class="small"><b><i>{username}</i></b></a></td>\r\n  <td>{email}</td>\r\n  <td align="center">{reg_date}</td>\r\n  <td align="center">{news}</td>\r\n  <td align="center">{articles}</td>\r\n  <td align="center">{comments}</td>\r\n</tr>', '<tr valign="top">\r\n                <td align="right" style="padding-top:4px;">\r\n                    <img src="{captcha_url}">\r\n                </td>\r\n                <td>\r\n                    <input class="text" name="spam" id="spam" size="30" maxlength="25"><br />\r\n<span class="small">Bitte löse diese kleine Rechenaufgabe.</span>\r\n                </td>\r\n            </tr>', '<br /><br />\r\n <table border="0" cellspacing="0" cellpadding="0" width="60%">\r\n  <tr>\r\n   <td valign="top" align="left">\r\n<div id="antispam"><font size="1">* Auf dieser Seite kann jeder einen Kommentar zu einer News abgeben. Leider ist sie dadurch ein beliebtes Ziel von sog. Spam-Bots - speziellen Programmen, die automatisiert und zum Teil massenhaft Links zu anderen Internetseiten platzieren. Um das zu verhindern müssen nicht registrierte User eine einfache Rechenaufgabe lösen, die für die meisten Spam-Bots aber nicht lösbar ist. Wenn du nicht jedesmal eine solche Aufgabe lösen möchtest, kannst du dich einfach bei uns <a href="?go=register">registrieren</a>.</font></div>\r\n   </td>\r\n  </tr>\r\n </table>', '<div class="field_head" style="padding-left:60px; width:516px;">\r\n    <font class="h1" style="float:left; padding-top:14px;">Community Map</font>\r\n</div>\r\n<div class="field_middle" align="left">\r\n    {karte}\r\n    <div align="right">\r\n        <font class="small">Zum betrachten der Karte wird Flash benötigt: </font><br>\r\n        <img border="0" src="images/design/flash_rune.gif" align="middle">\r\n        <a target="_blank" href="http://www.adobe.com/go/getflashplayer">\r\n            <img border="0" src="images/design/flash_download_now.gif" align="middle">\r\n        </a>\r\n    </div>\r\n</div>\r\n<div class="field_footer"></div>\r\n<p></p>', '<form name="poll" action="" method="post">\r\n    <input type="hidden" name="pollid" value="{poll_id}">\r\n    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">\r\n        <tr>\r\n            <td class="small" colspan="2" align="center">\r\n                <b>{question}</b>\r\n            </td>\r\n        </tr>\r\n{answers}\r\n        <tr>\r\n            <td colspan="2" align="center" ><br />\r\n                <input class="button" type="submit" value="Abstimmen" {button_state}><br />\r\n<a class="small" href="?go=pollarchiv&pollid={poll_id}"><b>Ergebnis anzeigen!</b></a>\r\n            </td>\r\n        </tr>\r\n    </table>\r\n</form>', '<tr>\r\n    <td valign="top">\r\n        <input type="{type}" name="answer{multiple}" value="{answer_id}">\r\n    </td>\r\n    <td align="left" class="small">\r\n        {answer}\r\n    </td>\r\n</tr>', '<b>UMFRAGEN ARCHIV</b><p>\r\n<b>{frage}</b><p>\r\n<table width="100%">\r\n{antworten}\r\n   <tr><td> </td></tr>\r\n   <tr><td align="left">Anzahl der Teilnehmer: </td><td align="left" colspan="2"><b>{participants}</b></td></tr>\r\n   <tr><td align="left">Anzahl der Stimmen: </td><td align="left" colspan="2"><b>{stimmen}</b></td></tr>\r\n   <tr><td align="left">Art der Umfrage: </td><td align="left" colspan="2">{typ}</td></tr>\r\n   <tr><td align="left">Umfragedauer:</td><td align="left" colspan="2">{start_datum} bis {end_datum}</td></tr>\r\n</table>', '<tr>\r\n    <td align="left">{antwort}</td>\r\n    <td align="left">{stimmen}</td>\r\n    <td align="left">\r\n        <div style="width:{balken_breite}px; height:4px; font-size:1px; background-color:#00FF00;">\r\n    </td>\r\n</tr>', '<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">\r\n    <tr>\r\n        <td class="small" colspan="2" align="center">\r\n            <b>{question}</b>\r\n        </td>\r\n    </tr>\r\n{answers}\r\n</table>\r\n<div class="small">Teilnehmer: {participants}</div>\r\n<b>Bereits abgestimmt!</b>', '<tr>\r\n    <td align="left" class="small" colspan="2">\r\n        {answer}\r\n    </td>\r\n</tr>\r\n<tr>\r\n    <td align="left" class="small">\r\n        {percentage}\r\n    </td>\r\n    <td align="left" style="width:100%;">\r\n        <div style="width:{bar_width}; height:4px; font-size:1px; background-color:#00FF00;">\r\n    </td>\r\n</tr>', '<b>UMFRAGEN ARCHIV</b><p>\r\n<table border="0" width="100%" cellpadding="2" cellspacing="0">\r\n<tr>\r\n  <td align="left"><a href="?go=pollarchiv&sort=name_{order_name}" style="color: #000"><b>Frage {arrow_name}</b></a></td>\r\n  <td align="left" width="100"><a href="?go=pollarchiv&sort=voters_{order_voters}" style="color: #000"><b>Teilnehmer {arrow_voters}</b></a></td>\r\n  <td align="left" width="70"><a href="?go=pollarchiv&sort=startdate_{order_startdate}" style="color: #000"><b>von {arrow_startdate}</b></a></td>\r\n  <td align="left" width="10"></td>\r\n  <td align="left" width="70"><a href="?go=pollarchiv&sort=enddate_{order_enddate}" style="color: #000"><b>bis {arrow_enddate}</b></a></td>\r\n</tr>\r\n{umfragen}\r\n</table>\r\n<p>', '<tr>\r\n   <td align="left"><a href="{url}">{frage}</a></td>\r\n   <td align="left">{voters}</td>\r\n   <td align="left" class="small">{start_datum}</td>\r\n   <td align="left" class="small">-</td>\r\n   <td align="left" class="small">{end_datum}</td>\r\n  </tr>', '<div class="small" align="center">\r\n    Zur Zeit keine<br>Umfrage aktiv\r\n</div>', '<b>PROFIL VON {username}</b><p>\r\n<table align="center" border="0" cellpadding="4" cellspacing="0">\r\n    <tr>\r\n        <td width="50%" valign="top">\r\n            <b>Benutzerbild:</b>\r\n        </td>\r\n        <td width="50%">\r\n            {avatar}\r\n        </td>\r\n    </tr>\r\n    <tr>\r\n        <td>\r\n            <b>E-Mail:</b>\r\n        </td>\r\n        <td>\r\n            {email}\r\n        </td>\r\n    </tr>\r\n    <tr>\r\n        <td>\r\n            <b>Registriert seit:</b>\r\n        </td>\r\n        <td>\r\n            {reg_datum}\r\n        </td>\r\n    </tr>\r\n    <tr>\r\n        <td>\r\n            <b>Geschriebene Kommentare:</b>\r\n        </td>\r\n        <td>\r\n            {kommentare}\r\n        </td>\r\n    </tr>\r\n    <tr>\r\n        <td>\r\n            <b>Geschriebene News:</b>\r\n        </td>\r\n        <td>\r\n            {news}\r\n        </td>\r\n    </tr>\r\n    <tr>\r\n        <td>\r\n            <b>Geschriebene Artikel:</b>\r\n        </td>\r\n        <td>\r\n            {artikel}\r\n        </td>\r\n    </tr>\r\n</table>', '- <b>{visits}</b> Visits<br>\r\n- <b>{visits_today}</b> Visits heute<br>\r\n- <b>{hits}</b> Hits<br>\r\n- <b>{hits_today}</b> Hits heute<br><br>\r\n\r\n- <b>{visitors_online}</b> Besucher online<br>\r\n- <b>{registered_online}</b> registrierte <br>\r\n- <b>{guests_online}</b> Gäste<br><br>\r\n\r\n- <b>{registered_users}</b> registrierte User<br>\r\n- <b>{news}</b> News<br>\r\n- <b>{comments}</b> Kommentare<br>\r\n- <b>{articles}</b> Artikel', '<b>REGISTRIEREN</b><p>\r\n<div>\r\n    Registriere dich im Frog System, um in den Genuss erweiterter Features zu kommen. Dazu zählen bisher:\r\n    <ul>\r\n        <li>Zugriff auf unsere Downloads</li>\r\n        <li>Hochladen eines eigenen Benutzerbildes, für die von dir geschriebenen Kommentare</li>\r\n    </ul>\r\n    Weitere Features werden folgen.\r\n    <p>\r\n    <form action="" method="post" onSubmit="return chkFormularRegister()">\r\n        <input type="hidden" value="register" name="go">\r\n        <table border="0" cellpadding="2" cellspacing="0" align="center">\r\n            <tr>\r\n                <td align="right">\r\n                    <b>Name:</b>\r\n                </td>\r\n                <td>\r\n                    <input class="text" size="30" name="username" id="username" maxlength="100">\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td align="right">\r\n                    <b>Passwort:</b>\r\n                </td>\r\n                <td>\r\n                    <input class="text" size="30" name="newpwd" id="newpwd" type="password" maxlength="16" autocomplete="off">\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td align="right">\r\n                    <b>Passwort wiederholen:</b>\r\n                </td>\r\n                <td>\r\n                    <input class="text" size="30" name="wdhpwd" id="wdhpwd" type="password" maxlength="16" autocomplete="off">\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td align="right">\r\n                    <b>E-Mail:</b>\r\n                </td>\r\n                <td>\r\n                    <input class="text" size="30" name="usermail" id="usermail" maxlength="100">\r\n                </td>\r\n            </tr>\r\n{antispam}\r\n            <tr>\r\n                <td colspan="2" align="center">\r\n                    <input type="submit" class="button" value="Registrieren">\r\n                </td>\r\n            </tr>\r\n        </table>\r\n    </form>\r\n    <p>\r\n</div>', '<div class="news_head" style="height:10px;" id ="{newsid}">\r\n    <span style="float:left;">\r\n       <b>[{kategorie_name}] {titel}</b>\r\n    </span>\r\n    <span class="small" style="float:right;">\r\n        <b>{datum}</b>\r\n    </span>\r\n</div>\r\n<div style="padding:3px;">\r\n    {text}\r\n    {related_links}\r\n</div>\r\n<div class="news_footer">\r\n    <span class="small" style="float:left;">\r\n        <a class="small" href="{kommentar_url}">Kommentare ({kommentar_anzahl})</a>\r\n    </span>\r\n    <span class="small" style="float:right;">\r\n        geschrieben von: <a class="small" href="{autor_profilurl}">{autor}</a>\r\n    </span>\r\n</div>\r\n<br><br>', '<b>NEWS</b><p>\r\n{headlines}<p>\r\n{news}', '{news}<p>\r\n{comments}<p>\r\n{comment_form}', '<b>Ankündigung:</b>\r\n<br><br>\r\n    {announcement_text}\r\n<br><br>', 'Hallo {username},\r\n\r\nDu hast dich im Frogsystem registriert. Deine Logindaten sind:\r\n\r\nUsername: {username}\r\nPasswort: {password}', 'Hallo {username},\r\n\r\nDein Passwort im Frogsystem wurde geändert. Deine neuen Logindaten sind:\r\n\r\nUsername: {username}\r\nPasswort: {password}', '<div align="center">\r\n  <b>{name}</b><br />\r\n  <a href="{url}" target="_blank">\r\n    <img src="{img_url}" border="0" alt="{name}"  title="{name}">\r\n  </a>\r\n  <br />\r\n  {text}\r\n</div>', 'Partner:\r\n{partner_all}', '<div align="center">\r\n  <a href="{url}" target="_blank">\r\n    <img src="{button_url}" border="0" alt="{name}"  title="{name}">\r\n  </a>\r\n  <br>\r\n</div>', '{permanents}\r\n\r\n<div align="center"><br><b>\r\nZufallsauswahl:</b><br>\r\n\r\n{non_permanents}\r\n\r\n<a href="?go=partner">alle Partner</a></div><br>', '<table cellpadding="5" align="center" border="0" width="90%">\r\n<tr><td><b><font face="verdana" size="2">Code:</font></b></td></tr>\r\n<tr><td style="border-collapse: collapse; border-style: dotted; border-color:#000000; border-width: 1"><font face="Courier New">{text}</font>\r\n</td></tr></table>', '<table cellpadding="5" align="center" border="0" width="90%">\r\n<tr><td><b><font face="verdana" size="2">Zitat:</font></b></td></tr>\r\n<tr><td style="border-collapse: collapse; border-style: dotted; border-color:#000000; border-width: 1">{text}\r\n</td></tr></table>', '<table cellpadding="5" align="center" border="0" width="90%">\r\n<tr><td><b><font face="verdana" size="2">Zitat von {author}:</font></b></td></tr>\r\n<tr><td style="border-collapse: collapse; border-style: dotted; border-color:#000000; border-width: 1">{text}\r\n</td></tr></table>', '<table cellpadding="0" cellspacing="0" border="0" style="padding-bottom:4px">\r\n  <tr valign="bottom">\r\n    {buttons}\r\n  </tr>\r\n</table>\r\n\r\n<table cellpadding="0" cellspacing="0" border="0">\r\n  <tr valign="top">\r\n    <td>\r\n      <textarea {style}>{text}</textarea>\r\n    </td>\r\n    <td style="width:4px; empty-cells:show;">\r\n    </td>\r\n    <td>\r\n      {smilies}\r\n    </td>\r\n  </tr>\r\n</table>\r\n<br />', '.editor_button {\r\n  font-size:8pt;\r\n  font-family:Verdana;\r\n  border:1px solid #000000;\r\n  background-color:#CCCCCC;\r\n  width:20px;\r\n  height:20px;\r\n  cursor:pointer;\r\n  text-align:center;\r\n}\r\n.editor_button:hover {\r\n  background-color:#A5E5A5;\r\n}\r\n.editor_td {\r\n  width:24px;\r\n  height:23px;\r\n  vertical-align:bottom;\r\n  text-align:left;\r\n}\r\n.editor_td_seperator {\r\n  width:5px;\r\n  height:23px;\r\n  background-image:url("images/icons/separator.gif");\r\n  background-repeat:no-repeat;\r\n  background-position:top left;\r\n}\r\n.editor_smilies {\r\n  cursor:pointer;\r\n  padding:0px;\r\n}', '  <td class="editor_td">\r\n    <div class="editor_button" {javascript}>\r\n      <img src="{img_url}" alt="{alt}" title="{title}" />\r\n    </div>\r\n  </td>', '<td class="editor_td_seperator"></td>', 'v', '', '', '', '', '', '');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Daten für Tabelle `fs_user`
--

INSERT INTO `fs_user` (`user_id`, `user_name`, `user_password`, `user_salt`, `user_mail`, `user_is_staff`, `user_group`, `user_is_admin`, `user_reg_date`, `user_show_mail`, `user_homepage`, `user_icq`, `user_aim`, `user_wlm`, `user_yim`, `user_skype`) VALUES
(1, 'admin', '72ce90aed8b19ef984eca6e0a0df977d', '5NdWu7dA6v', 'admin@frogsystem.de', 1, 0, 1, 1207260000, 1, 'http://www.frogsystem.de', '', '', '', '', ''),
(2, 'test', '0b6d71e7ba83facb3081858c8a8d0c68', 'wDJ6w9JPIA', 'mail@sweil.de', 1, 1, 0, 1240783200, 0, '', '', '', '', '', ''),
(3, 'super', 'ad568fff6880715044d6eb4e7ae26c07', 'fXEGPvDGs8', 'super', 0, 0, 0, 1258245681, 0, '', '', '', '', '', ''),
(4, 'buh', 'c476b70654f68ce27b689305f40945da', '3EAttd60cA', 'buh', 0, 0, 0, 1258245858, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'MaxiPower97', 'eeb1890ecd1d6da2bbf7e05ff7c4169b', 'BltilsgvlI', 'max.mustermann@example.com', 0, 0, 0, 1258239600, 1, '', '', '', '', '', ''),
(6, '5', 'ab961e32b08740f3623f3c2b39e3ac34', 'E6cB0FSdG3', '5', 0, 0, 0, 1259007229, 0, NULL, NULL, NULL, NULL, NULL, NULL);

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

INSERT INTO `fs_useronline` (`ip`, `user_id`, `date`) VALUES
('127.0.0.1', 1, 1262716166);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `fs_user_groups`
--

INSERT INTO `fs_user_groups` (`user_group_id`, `user_group_name`, `user_group_description`, `user_group_title`, `user_group_color`, `user_group_highlight`, `user_group_date`, `user_group_user`) VALUES
(0, 'Administrator', '', 'Chef vom Dienst', '008800', 1, 1223676000, 1),
(1, 'test', '', '', '-1', 0, 1255125600, 1);

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
('news_comments', 2, 0),
('news_edit', 1, 1);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci PACK_KEYS=1 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `fs_wallpaper`
--


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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci PACK_KEYS=1 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `fs_wallpaper_sizes`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_zones`
--

DROP TABLE IF EXISTS `fs_zones`;
CREATE TABLE `fs_zones` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `design_id` mediumint(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci PACK_KEYS=0 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `fs_zones`
--

