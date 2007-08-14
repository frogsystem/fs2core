-- phpMyAdmin SQL Dump
-- version 2.10.2
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Erstellungszeit: 14. August 2007 um 23:37
-- Server Version: 5.0.45
-- PHP-Version: 5.2.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Datenbank: `frogsystem`
-- 

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `fs_admin_cp`
-- 

DROP TABLE IF EXISTS `fs_admin_cp`;
CREATE TABLE `fs_admin_cp` (
  `id` mediumint(8) NOT NULL auto_increment,
  `page_call` varchar(255) collate latin1_general_ci NOT NULL default '',
  `page_title` varchar(255) collate latin1_general_ci NOT NULL default '',
  `link_title` varchar(255) collate latin1_general_ci NOT NULL default '',
  `permission` varchar(255) collate latin1_general_ci NOT NULL default '',
  `file` varchar(255) collate latin1_general_ci NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=81 ;

-- 
-- Daten für Tabelle `fs_admin_cp`
-- 

REPLACE INTO `fs_admin_cp` VALUES (1, 'allconfig', 'KONFIGURATION', 'Konfiguration', 'perm_allconfig', 'admin_allconfig.php');
REPLACE INTO `fs_admin_cp` VALUES (2, 'allannouncement', 'ANKÜNDIGUNG', 'Ankündigung', 'perm_allannouncement', 'admin_allannouncement.php');
REPLACE INTO `fs_admin_cp` VALUES (3, 'allphpinfo', 'PHP INFO', 'PHP Info', 'perm_allphpinfo', 'admin_allphpinfo.php');
REPLACE INTO `fs_admin_cp` VALUES (4, 'newsadd', 'NEWS HINZUFÜGEN', 'schreiben', 'perm_newsadd', 'admin_newsadd.php');
REPLACE INTO `fs_admin_cp` VALUES (5, 'newsedit', 'NEWS ARCHIV', 'Archiv / editieren', 'perm_newsedit', 'admin_newsedit.php');
REPLACE INTO `fs_admin_cp` VALUES (6, 'commentedit', 'KOMMENTAR EDITIEREN', '', 'perm_newsedit', 'admin_commentedit.php');
REPLACE INTO `fs_admin_cp` VALUES (7, 'news_cat_manage', 'KATEGORIE VERWALTEN', 'Kategorien verwalten', 'perm_newscat', 'admin_news_cat_manage.php');
REPLACE INTO `fs_admin_cp` VALUES (8, 'news_cat_create', 'KATEGORIE HINZUFÜGEN', 'Kategorie hinzufügen', 'perm_newsnewcat', 'admin_news_cat_create.php');
REPLACE INTO `fs_admin_cp` VALUES (9, 'newsconfig', 'NEWS KONFIGURATION', 'Konfiguration', 'perm_newsconfig', 'admin_newsconfig.php');
REPLACE INTO `fs_admin_cp` VALUES (10, 'dladd', 'DOWNLOAD HINZUFÜGEN', 'hinzufügen', 'perm_dladd', 'admin_dladd.php');
REPLACE INTO `fs_admin_cp` VALUES (11, 'dledit', 'DOWNLOAD BEARBEITEN', 'bearbeiten', 'perm_dledit', 'admin_dledit.php');
REPLACE INTO `fs_admin_cp` VALUES (12, 'dlcat', 'DOWNLOAD KATEGORIEN', 'Kategorien', 'perm_dlcat', 'admin_dlcat.php');
REPLACE INTO `fs_admin_cp` VALUES (13, 'dlnewcat', 'DOWNLOAD KATEGORIE HINZUFÜGEN', 'Neue Kategorie', 'perm_dlnewcat', 'admin_dlnewcat.php');
REPLACE INTO `fs_admin_cp` VALUES (14, 'dlconfig', 'DOWNLOAD KONFIGURATION', 'Konfiguration', 'perm_dladd', 'admin_dlconfig.php');
REPLACE INTO `fs_admin_cp` VALUES (15, 'polladd', 'UMFRAGE HINZUFÜGEN', 'hinzufügen', 'perm_polladd', 'admin_polladd.php');
REPLACE INTO `fs_admin_cp` VALUES (16, 'polledit', 'UMFRAGEN ARCHIV', 'Archiv / editieren', 'perm_polledit', 'admin_polledit.php');
REPLACE INTO `fs_admin_cp` VALUES (17, 'randompic_cat', 'ZUFALLSBILD KATEGORIE AUSWAHL', 'Kategorie Auswahl', 'perm_potmadd', 'admin_randompic_cat.php');
REPLACE INTO `fs_admin_cp` VALUES (18, 'potmedit', 'POTM ÜBERSICHT', '', 'perm_potmedit', 'admin_potmedit.php');
REPLACE INTO `fs_admin_cp` VALUES (19, 'screenadd', 'SCREENSHOT HINZUFÜGEN', 'Bild hinzufügen', 'perm_screenadd', 'admin_screenadd.php');
REPLACE INTO `fs_admin_cp` VALUES (20, 'screenedit', 'SCREENSHOT ÜBERSICHT', 'Übersicht', 'perm_screenedit', 'admin_screenedit.php');
REPLACE INTO `fs_admin_cp` VALUES (21, 'screencat', 'GALERIE KATEGORIEN', 'Kategorien verwalten', 'perm_screencat', 'admin_screencat.php');
REPLACE INTO `fs_admin_cp` VALUES (22, 'screennewcat', 'GALERIE KATEGORIE HINZUFÜGEN', 'Kategorie hinzufügen', 'perm_screennewcat', 'admin_screennewcat.php');
REPLACE INTO `fs_admin_cp` VALUES (23, 'screenconfig', 'SCREENSHOT KONFIGURATION', 'Konfiguration', 'perm_screenconfig', 'admin_screenconfig.php');
REPLACE INTO `fs_admin_cp` VALUES (24, 'wallpaperadd', 'WALLPAPER HINZUFÜGEN', 'Wallpaper hinzufügen', 'perm_screenadd', 'admin_wallpaperadd.php');
REPLACE INTO `fs_admin_cp` VALUES (25, 'wallpaperedit', 'WALLPAPER BEARBEITEN', 'Wallpaper bearbeiten', 'perm_screenedit', 'admin_wallpaperedit.php');
REPLACE INTO `fs_admin_cp` VALUES (26, 'shopadd', 'ARTIKEL HINZUFÜGEN', 'Artikel hinzufügen', 'perm_shopadd', 'admin_shopadd.php');
REPLACE INTO `fs_admin_cp` VALUES (27, 'shopedit', 'ARTIKEL ÜBERSICHT', 'Übersicht', 'perm_shopedit', 'admin_shopedit.php');
REPLACE INTO `fs_admin_cp` VALUES (74, 'map', 'COMMUNITY MAP BEARBEITEN', '', 'perm_map', 'admin_map.php');
REPLACE INTO `fs_admin_cp` VALUES (29, 'statview', 'STATISTIK ANZEIGEN', 'anzeigen', 'perm_statview', 'admin_statview.php');
REPLACE INTO `fs_admin_cp` VALUES (30, 'statedit', 'STATISTIK BEARBEITEN', 'bearbeiten', 'perm_statedit', 'admin_statedit.php');
REPLACE INTO `fs_admin_cp` VALUES (31, 'statref', 'REFERRER ANZEIGEN', 'referrer', 'perm_statref', 'admin_statref.php');
REPLACE INTO `fs_admin_cp` VALUES (32, 'statspace', 'SPEICHERPLATZ STATISTIK', 'Speicherplatz', 'perm_statspace', 'admin_statspace.php');
REPLACE INTO `fs_admin_cp` VALUES (33, 'useradd', 'USER HINZUFÜGEN', 'hinzufügen', 'perm_useradd', 'admin_useradd.php');
REPLACE INTO `fs_admin_cp` VALUES (34, 'useredit', 'USER BEARBEITEN', 'bearbeiten', 'perm_useredit', 'admin_useredit.php');
REPLACE INTO `fs_admin_cp` VALUES (35, 'userrights', 'USER RECHTE', 'Rechte', 'perm_userrights', 'admin_userrights.php');
REPLACE INTO `fs_admin_cp` VALUES (36, 'artikeladd', 'ARTIKEL SCHREIBEN', 'schreiben', 'perm_artikeladd', 'admin_artikeladd.php');
REPLACE INTO `fs_admin_cp` VALUES (37, 'artikeledit', 'ARTIKEL BEARBEITEN', 'editieren', 'perm_artikeledit', 'admin_artikeledit.php');
REPLACE INTO `fs_admin_cp` VALUES (38, 'cimgadd', 'BILDER HOCHLADEN', 'Bilder hochladen', 'perm_artikeladd', 'admin_cimg.php');
REPLACE INTO `fs_admin_cp` VALUES (39, 'cimgdel', 'BILDER LÖSCHEN', 'Bilder löschen', 'perm_artikeledit', 'admin_cimgdel.php');
REPLACE INTO `fs_admin_cp` VALUES (40, 'artikeltemplate', 'ARTIKEL TEMPLATE BEARBEITEN', 'Artikel', 'perm_templateedit', 'admin_template_artikel.php');
REPLACE INTO `fs_admin_cp` VALUES (41, 'polltemplate', 'UMFRAGEN TEMPLATE BEARBEITEN', 'Umfragen', 'perm_templateedit', 'admin_template_poll.php');
REPLACE INTO `fs_admin_cp` VALUES (42, 'randompictemplate', 'ZUFALLSBILD TEMPLATE BEARBEITEN', 'Zufallsbild', 'perm_templateedit', 'admin_template_randompic.php');
REPLACE INTO `fs_admin_cp` VALUES (43, 'shoptemplate', 'SHOP TEMPLATE BEARBEITEN', 'Shop', 'perm_templateedit', 'admin_template_shop.php');
REPLACE INTO `fs_admin_cp` VALUES (44, 'newstemplate', 'NEWS TEMPLATE BEARBEITEN', 'News', 'perm_templateedit', 'admin_template_news.php');
REPLACE INTO `fs_admin_cp` VALUES (45, 'alltemplate', 'ALLGEMEINE TEMPLATES BEARBEITEN', 'Allgemein', 'perm_templateedit', 'admin_template_all.php');
REPLACE INTO `fs_admin_cp` VALUES (46, 'dltemplate', 'DOWNLOAD TEMPLATE BEARBEITEN', 'Downloads', 'perm_templateedit', 'admin_template_dl.php');
REPLACE INTO `fs_admin_cp` VALUES (47, 'screenshottemplate', 'SCREENSHOT TEMPLATE BEARBEITEN', 'Screenshots', 'perm_templateedit', 'admin_template_screenshot.php');
REPLACE INTO `fs_admin_cp` VALUES (48, 'usertemplate', 'USER TEMPLATE BEARBEITEN', 'User', 'perm_templateedit', 'admin_template_user.php');
REPLACE INTO `fs_admin_cp` VALUES (49, 'csstemplate', 'CSS DATEI BEARBEITEN', 'CSS', 'perm_templateedit', 'admin_template_css.php');
REPLACE INTO `fs_admin_cp` VALUES (50, 'template_manage', 'DESIGNS VERWALTEN', 'verwalten', 'perm_templateedit', 'admin_template_manage.php');
REPLACE INTO `fs_admin_cp` VALUES (51, 'template_create', 'DESIGN ERSTELLEN', 'erstellen', 'perm_templateedit', 'admin_template_create.php');
REPLACE INTO `fs_admin_cp` VALUES (52, 'emailtemplate', 'E-MAILS BEARBEITEN', 'E-Mails', 'perm_templateedit', 'admin_template_email.php');
REPLACE INTO `fs_admin_cp` VALUES (53, 'profil', 'PROFIL BEARBEITEN', 'bearbeiten', '1', 'admin_profil.php');
REPLACE INTO `fs_admin_cp` VALUES (54, 'partneradd', 'PARTNER HINZUFÜGEN', 'hinzufügen', 'perm_partneradd', 'admin_partneradd.php');
REPLACE INTO `fs_admin_cp` VALUES (55, 'partneredit', 'PARTNER EDITIEREN', 'bearbeiten', 'perm_partneredit', 'admin_partneredit.php');
REPLACE INTO `fs_admin_cp` VALUES (56, 'partnerconfig', 'PARTNERSEITEN EINSTELLUNGEN', 'Konfiguration', 'perm_partneredit', 'admin_partnerconfig.php');
REPLACE INTO `fs_admin_cp` VALUES (57, 'partnertemplate', 'PARTNER TEMPLATE BEARBEITEN', 'Partnerseiten', 'perm_templateedit', 'admin_template_partner.php');
REPLACE INTO `fs_admin_cp` VALUES (58, 'includes_new', 'INCLUDE HINZUFÜGEN', 'hinzufügen', 'perm_allconfig', 'admin_includes_new.php');
REPLACE INTO `fs_admin_cp` VALUES (59, 'includes_edit', 'INCLUDES BEARBEITEN', 'Übersicht (bearbeiten)', 'perm_allconfig', 'admin_includes_edit.php');
REPLACE INTO `fs_admin_cp` VALUES (60, 'zone_create', 'ZONE ERSTELLEN', 'erstellen', 'perm_templateedit', 'admin_zone_create.php');
REPLACE INTO `fs_admin_cp` VALUES (61, 'zone_manage', 'ZONEN VERWALTEN', 'verwalten', 'perm_templateedit', 'admin_zone_manage.php');
REPLACE INTO `fs_admin_cp` VALUES (62, 'zone_config', 'ZONEN EINSTELLUNGEN', 'Konfiguration', 'perm_templateedit', 'admin_zone_config.php');
REPLACE INTO `fs_admin_cp` VALUES (63, 'press_add', 'PRESSEVERÖFFENTLICHUNG EINTRAGEN', 'eintragen', '1', 'admin_press_add.php');
REPLACE INTO `fs_admin_cp` VALUES (64, 'press_edit', 'PRESSEVERÖFFENTLICHUNG EDITIEREN', 'bearbeiten', '1', 'admin_press_edit.php');
REPLACE INTO `fs_admin_cp` VALUES (65, 'randompic_time', 'ZEITGESTEUERTE ZUFALLSBILDER  ÜBERSICHT', 'zeitgest. ZBs bearbeiten', 'perm_potmadd', 'admin_randompic_time.php');
REPLACE INTO `fs_admin_cp` VALUES (66, 'randompic_time_add', 'ZEITGESTEUERTES ZUFALLSBILD HINZUF&Uuml;GEN', 'Zeitgesteuerte ZBs', 'perm_potmadd', 'admin_randompic_time_add.php');
REPLACE INTO `fs_admin_cp` VALUES (67, 'randompic_config', 'ZUFALLSBILD KONFIGURATION', 'Konfiguration', 'perm_potmadd', 'admin_randompic_config.php');
REPLACE INTO `fs_admin_cp` VALUES (68, 'userlist', 'MITGLIEDERLISTE KONFIGURIEREN', 'Mitgliederliste', '1', 'admin_userlist.php');
REPLACE INTO `fs_admin_cp` VALUES (69, 'map&amp;landid=1', '', 'Deutschland', 'perm_map', '');
REPLACE INTO `fs_admin_cp` VALUES (70, 'map&amp;landid=2', '', 'Schweiz', 'perm_map', '');
REPLACE INTO `fs_admin_cp` VALUES (75, 'logout', 'LOGOUT', 'Logout', '1', 'admin_logout.php');
REPLACE INTO `fs_admin_cp` VALUES (71, 'map&amp;landid=3', '', 'Österreich', 'perm_map', '');
REPLACE INTO `fs_admin_cp` VALUES (76, 'editorsmilies', 'SMILIES VERWALTEN', 'Smilies', '1', 'admin_editor_smilies.php');
REPLACE INTO `fs_admin_cp` VALUES (73, 'login', 'LOGIN', 'Login', '1', 'admin_login.php');
REPLACE INTO `fs_admin_cp` VALUES (77, 'editorconfig', 'EDITOR KONFIGURATION', 'Konfiguration', '1', 'admin_editor_config.php');
REPLACE INTO `fs_admin_cp` VALUES (78, 'editordesign', 'EDITOR DARSTELLUNG', 'Darstellung', '1', 'admin_editor_design.php');
REPLACE INTO `fs_admin_cp` VALUES (79, 'editorfscode', 'FS CODE VERWALTUNG', 'FS-Codes', '1', 'admin_editor_fscode.php');
REPLACE INTO `fs_admin_cp` VALUES (80, 'wallpapertemplate', 'WALLPAPER TEMPLATE BEARBEITEN  ', 'Wallpaper', '1', 'admin_template_wallpaper.php');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `fs_announcement`
-- 

DROP TABLE IF EXISTS `fs_announcement`;
CREATE TABLE `fs_announcement` (
  `text` text collate latin1_general_ci
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- 
-- Daten für Tabelle `fs_announcement`
-- 

REPLACE INTO `fs_announcement` VALUES ('Dies ist eine Test-Ankündigung!');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `fs_artikel`
-- 

DROP TABLE IF EXISTS `fs_artikel`;
CREATE TABLE `fs_artikel` (
  `artikel_url` varchar(100) collate latin1_general_ci NOT NULL default '',
  `artikel_title` varchar(100) collate latin1_general_ci default NULL,
  `artikel_date` int(11) default NULL,
  `artikel_user` varchar(100) collate latin1_general_ci default NULL,
  `artikel_text` mediumtext collate latin1_general_ci,
  `artikel_index` tinyint(4) default NULL,
  `artikel_fscode` tinyint(4) default NULL,
  PRIMARY KEY  (`artikel_url`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- 
-- Daten für Tabelle `fs_artikel`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `fs_cmap_user`
-- 

DROP TABLE IF EXISTS `fs_cmap_user`;
CREATE TABLE `fs_cmap_user` (
  `user_id` mediumint(8) NOT NULL auto_increment,
  `land_id` tinyint(2) default NULL,
  `user_name` char(100) collate latin1_general_ci default NULL,
  `x_pos` smallint(5) default NULL,
  `y_pos` smallint(5) default NULL,
  `user_ort` char(100) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=3 ;

-- 
-- Daten für Tabelle `fs_cmap_user`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `fs_counter`
-- 

DROP TABLE IF EXISTS `fs_counter`;
CREATE TABLE `fs_counter` (
  `visits` int(11) unsigned NOT NULL default '0',
  `hits` int(11) unsigned NOT NULL default '0',
  `user` mediumint(8) unsigned NOT NULL default '0',
  `artikel` smallint(6) unsigned NOT NULL default '0',
  `news` smallint(6) unsigned NOT NULL default '0',
  `comments` mediumint(8) unsigned NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- 
-- Daten für Tabelle `fs_counter`
-- 

REPLACE INTO `fs_counter` VALUES (5, 852, 1, 0, 1, 1);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `fs_counter_ref`
-- 

DROP TABLE IF EXISTS `fs_counter_ref`;
CREATE TABLE `fs_counter_ref` (
  `ref_url` char(255) collate latin1_general_ci default NULL,
  `ref_count` int(11) default NULL,
  `ref_date` int(11) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- 
-- Daten für Tabelle `fs_counter_ref`
-- 

REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/?go=map', 1, 1186939097);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/?go=news', 60, 1186939098);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/', 16, 1186939099);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/?mid=general', 18, 1186939101);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/?mid=content', 6, 1186939102);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/?mid=content&go=newsadd&sid=', 5, 1186939111);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/?mid=content&go=news_cat_create&sid=', 2, 1186939118);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/', 56, 1186939142);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/', 14, 1186940050);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/?mid=user', 2, 1186940054);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/?mid=styles', 5, 1186940055);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/?mid=styles&go=alltemplate&sid=', 5, 1186940058);
REPLACE INTO `fs_counter_ref` VALUES ('http://projectoffset.worldofplayers.de/', 1, 1186941079);
REPLACE INTO `fs_counter_ref` VALUES ('http://projectoffset.worldofplayers.de/admin/index.php', 1, 1186941575);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/?mid=styles&go=csstemplate&sid=', 6, 1186944603);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/index.php', 11, 1186946327);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/index.php?mid=content', 17, 1186946329);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/index.php?mid=content&go=newsadd&sid=', 11, 1186946330);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/index.php?mid=content&go=newsedit&sid=', 9, 1186946332);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/index.php?mid=media', 4, 1186946408);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/index.php?mid=styles', 11, 1186946410);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/index.php?mid=styles&go=csstemplate&sid=', 2, 1186946471);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/index.php?mid=general', 16, 1186946502);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/index.php?mid=content&go=news_cat_create&sid=', 1, 1186946555);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/index.php?mid=general&go=editordesign&sid=', 89, 1186946610);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/index.php?mid=general&go=editorfscode&sid=', 3, 1186946611);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/index.php?mid=general&go=includes_edit&sid=', 1, 1186946612);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/index.php?mid=general&go=statedit&sid=', 1, 1186946615);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/index.php?go=logout', 3, 1186946773);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/index.php?go=login', 6, 1186946775);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/index.php?mid=promo', 1, 1186946781);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/index.php?mid=styles&go=zone_config&sid=', 1, 1186946785);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/index.php?mid=styles&go=dltemplate&sid=', 1, 1186946787);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/index.php?mid=styles&go=alltemplate&sid=', 2, 1186946819);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/index.php?mid=general&go=newnews', 1, 1186946916);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/index.php?mid=general&go=newsadd', 1, 1186948069);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/index.php?mid=content&go=news_cat_manage&sid=', 2, 1186948073);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/index.php?mid=media&go=randompic_cat&sid=', 2, 1186950678);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/index.php?mid=media&go=screennewcat&sid=', 5, 1186950682);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/index.php?mid=media&go=screencat&sid=', 10, 1186950976);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/index.php?mid=media&go=screenadd&sid=', 2, 1186951002);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/index.php?mid=media&go=screenconfig&sid=', 1, 1186951047);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/index.php?mid=styles&go=template_create&sid=', 1, 1186951108);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/index.php?mid=styles&go=template_manage&sid=', 1, 1186951366);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/?go=screenshots&catid=2', 1, 1186953120);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/?mid=content&go=newsconfig&sid=', 1, 1186953129);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/?mid=media', 5, 1186953131);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/?mid=media&go=screenconfig&sid=', 3, 1186954973);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/?mid=general&go=includes_edit&sid=', 7, 1186954981);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/?mid=general&go=includes_new&sid=', 13, 1186954983);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/?mid=general&go=editorsmilies&sid=', 8, 1186956407);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/?mid=general&go=editorsmilies&oid=1&action=movedown&sid=', 3, 1187009017);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/?mid=general&go=editorconfig&sid=', 14, 1187009043);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/?mid=general&go=editordesign&sid=', 11, 1187009044);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/?mid=user&go=userlist&sid=', 1, 1187009172);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/?mid=media&go=randompic_cat&sid=', 2, 1187011074);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/?mid=media&go=randompic_time_add&sid=', 2, 1187011076);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/?mid=media&go=randompic_time&sid=', 1, 1187011082);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/?mid=media&go=randompic_config&sid=', 1, 1187011116);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/?mid=general&go=allconfig&sid=', 3, 1187012594);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/?go=logout', 1, 1187012808);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/?go=login', 2, 1187012809);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/?go=comments&id=1', 21, 1187017053);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/?go=pollarchiv', 3, 1187017093);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/res/', 9, 1187017937);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/index.php?mid=general&go=editorconfig&sid=', 46, 1187018159);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/index.php?mid=general&go=editorsmilies&sid=', 15, 1187018160);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/index.php?mid=general&go=editorsmilies&oid=5&action=moveup&sid=', 1, 1187019639);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/index.php?mid=general&go=editorsmilies&oid=4&action=moveup&sid=', 2, 1187019822);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/index.php?mid=general&go=editorsmilies&oid=3&action=moveup&sid=', 9, 1187019866);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/?mid=content&go=newsedit&sid=', 1, 1187022744);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/?go=profil&userid=1', 4, 1187028627);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/?go=editprofil', 2, 1187028659);
REPLACE INTO `fs_counter_ref` VALUES ('http://sweil.dyndns.org/fs2/www/?go=comments&id=1', 4, 1187030319);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/?go=screenshots', 31, 1187036366);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/?mid=media&go=screennewcat&sid=', 10, 1187036399);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/?mid=media&go=screencat&sid=', 10, 1187036400);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/?go=screenshots&catid=3', 20, 1187036607);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/?go=screenshots&catid=1', 15, 1187036997);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/?mid=media&go=screenadd&sid=', 11, 1187040752);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/?go=screenshots&catid=1&page=2', 4, 1187040793);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/?go=gallery', 2, 1187121926);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/?go=wallpaper', 17, 1187121949);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/?mid=media&go=wallpaperadd&sid=', 3, 1187121992);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/?mid=media&go=wallpaperedit&sid=', 10, 1187122000);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/?mid=media&go=screenedit&sid=', 2, 1187122046);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/?mid=styles&go=screenshottemplate&sid=', 2, 1187122516);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/index.php?mid=styles&go=screenshottemplate&sid=', 5, 1187122543);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/index.php?mid=styles&go=artikeltemplate&sid=', 1, 1187123095);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/index.php?mid=styles&go=randompictemplate&sid=', 1, 1187123096);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/index.php?mid=styles&go=wallpapertemplate&sid=', 12, 1187123098);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/?go=screenshots&catid=4', 2, 1187125659);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/index.php?mid=general&go=allannouncement&sid=', 1, 1187125743);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/?go=gallery&catid=1&page=2', 8, 1187126019);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/?go=gallery&catid=1&page=1', 6, 1187126020);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/?go=screenshots&catid=1&page=1', 2, 1187126241);
REPLACE INTO `fs_counter_ref` VALUES ('http://localhost/fs2/www/admin/index.php?mid=general&go=allconfig&sid=', 1, 1187126374);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `fs_counter_stat`
-- 

DROP TABLE IF EXISTS `fs_counter_stat`;
CREATE TABLE `fs_counter_stat` (
  `s_year` int(4) default NULL,
  `s_month` int(2) default NULL,
  `s_day` int(2) default NULL,
  `s_visits` int(11) default NULL,
  `s_hits` int(11) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- 
-- Daten für Tabelle `fs_counter_stat`
-- 

REPLACE INTO `fs_counter_stat` VALUES (2007, 8, 12, 1, 176);
REPLACE INTO `fs_counter_stat` VALUES (2007, 8, 13, 3, 544);
REPLACE INTO `fs_counter_stat` VALUES (2007, 8, 14, 1, 132);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `fs_dl`
-- 

DROP TABLE IF EXISTS `fs_dl`;
CREATE TABLE `fs_dl` (
  `dl_id` mediumint(8) NOT NULL auto_increment,
  `cat_id` mediumint(8) default NULL,
  `user_id` mediumint(8) default NULL,
  `dl_date` int(11) default NULL,
  `dl_name` varchar(100) collate latin1_general_ci default NULL,
  `dl_text` text collate latin1_general_ci,
  `dl_autor` varchar(100) collate latin1_general_ci default NULL,
  `dl_autor_url` varchar(255) collate latin1_general_ci default NULL,
  `dl_open` tinyint(4) default NULL,
  PRIMARY KEY  (`dl_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- 
-- Daten für Tabelle `fs_dl`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `fs_dl_cat`
-- 

DROP TABLE IF EXISTS `fs_dl_cat`;
CREATE TABLE `fs_dl_cat` (
  `cat_id` mediumint(8) NOT NULL auto_increment,
  `subcat_id` mediumint(8) NOT NULL default '0',
  `cat_name` char(100) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`cat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- 
-- Daten für Tabelle `fs_dl_cat`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `fs_dl_config`
-- 

DROP TABLE IF EXISTS `fs_dl_config`;
CREATE TABLE `fs_dl_config` (
  `screen_x` int(11) default NULL,
  `screen_y` int(11) default NULL,
  `thumb_x` int(11) default NULL,
  `thumb_y` int(11) default NULL,
  `quickinsert` varchar(255) collate latin1_general_ci NOT NULL default '',
  `dl_rights` tinyint(1) NOT NULL default '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- 
-- Daten für Tabelle `fs_dl_config`
-- 

REPLACE INTO `fs_dl_config` VALUES (1024, 768, 120, 90, 'http://ftp.worldofplayers.net/frogsystem/', 1);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `fs_dl_files`
-- 

DROP TABLE IF EXISTS `fs_dl_files`;
CREATE TABLE `fs_dl_files` (
  `dl_id` mediumint(8) default NULL,
  `file_id` mediumint(8) NOT NULL auto_increment,
  `file_count` mediumint(8) NOT NULL default '0',
  `file_name` varchar(100) collate latin1_general_ci default NULL,
  `file_url` varchar(255) collate latin1_general_ci default NULL,
  `file_size` mediumint(8) NOT NULL default '0',
  `file_is_mirror` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`file_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- 
-- Daten für Tabelle `fs_dl_files`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `fs_editor_config`
-- 

DROP TABLE IF EXISTS `fs_editor_config`;
CREATE TABLE `fs_editor_config` (
  `id` tinyint(1) NOT NULL default '1',
  `smilies_rows` int(2) NOT NULL,
  `smilies_cols` int(2) NOT NULL,
  `textarea_width` int(3) NOT NULL,
  `textarea_height` int(3) NOT NULL,
  `bold` tinyint(1) NOT NULL default '0',
  `italic` tinyint(1) NOT NULL default '0',
  `underline` tinyint(1) NOT NULL default '0',
  `strike` tinyint(1) NOT NULL default '0',
  `center` tinyint(1) NOT NULL default '0',
  `font` tinyint(1) NOT NULL default '0',
  `color` tinyint(1) NOT NULL default '0',
  `size` tinyint(1) NOT NULL default '0',
  `img` tinyint(1) NOT NULL default '0',
  `cimg` tinyint(1) NOT NULL default '0',
  `url` tinyint(1) NOT NULL default '0',
  `home` tinyint(1) NOT NULL default '0',
  `email` tinyint(1) NOT NULL default '0',
  `code` tinyint(1) NOT NULL default '0',
  `quote` tinyint(1) NOT NULL default '0',
  `noparse` tinyint(1) NOT NULL default '0',
  `smilies` tinyint(1) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- 
-- Daten für Tabelle `fs_editor_config`
-- 

REPLACE INTO `fs_editor_config` VALUES (1, 5, 2, 357, 120, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 0, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `fs_global_config`
-- 

DROP TABLE IF EXISTS `fs_global_config`;
CREATE TABLE `fs_global_config` (
  `id` tinyint(1) NOT NULL default '1',
  `virtualhost` varchar(255) collate latin1_general_ci NOT NULL default '',
  `admin_mail` varchar(100) collate latin1_general_ci NOT NULL default '',
  `title` varchar(100) collate latin1_general_ci NOT NULL default '',
  `description` varchar(255) collate latin1_general_ci NOT NULL default '',
  `keywords` varchar(255) collate latin1_general_ci NOT NULL default '',
  `author` varchar(100) collate latin1_general_ci NOT NULL default '',
  `show_favicon` tinyint(1) NOT NULL default '1',
  `design` tinyint(4) NOT NULL default '0',
  `allow_other_designs` tinyint(1) NOT NULL default '1',
  `show_announcement` tinyint(1) NOT NULL default '0',
  `date` varchar(255) collate latin1_general_ci NOT NULL,
  `page` varchar(255) collate latin1_general_ci NOT NULL,
  `page_next` varchar(255) collate latin1_general_ci NOT NULL,
  `page_prev` varchar(255) collate latin1_general_ci NOT NULL,
  `registration_antispam` tinyint(1) NOT NULL,
  `random_timed_deltime` int(12) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- 
-- Daten für Tabelle `fs_global_config`
-- 

REPLACE INTO `fs_global_config` VALUES (1, 'http://localhost/fs2/www/', 'admin@frogsystem.de', 'Frogsystem 2', 'FrogSystem - Your Way to Nature', 'dfdf', 'Kermit, Sweil, rockfest, Wal, Don-Esteban, Fizzban', 0, 0, 1, 2, 'd.m.Y', '{prev}Seite {page_number} von {total_pages}{next}', '<a href=\\"{url}\\"> »</a>', '<a href=\\"{url}\\">« </a>', 1, 604800);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `fs_includes`
-- 

DROP TABLE IF EXISTS `fs_includes`;
CREATE TABLE `fs_includes` (
  `id` mediumint(8) NOT NULL auto_increment,
  `replace_string` varchar(255) collate latin1_general_ci NOT NULL default '',
  `replace_thing` text collate latin1_general_ci NOT NULL,
  `include_type` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

-- 
-- Daten für Tabelle `fs_includes`
-- 

REPLACE INTO `fs_includes` VALUES (1, '[%netzwerk%]', 'wop.inc.php', 2);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `fs_iplist`
-- 

DROP TABLE IF EXISTS `fs_iplist`;
CREATE TABLE `fs_iplist` (
  `deltime` int(20) default NULL,
  `ip` varchar(18) collate latin1_general_ci default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- 
-- Daten für Tabelle `fs_iplist`
-- 

REPLACE INTO `fs_iplist` VALUES (1187121915, '127.0.0.1');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `fs_news`
-- 

DROP TABLE IF EXISTS `fs_news`;
CREATE TABLE `fs_news` (
  `news_id` mediumint(8) NOT NULL auto_increment,
  `cat_id` smallint(6) default NULL,
  `user_id` mediumint(8) default NULL,
  `news_date` int(11) default NULL,
  `news_title` varchar(100) collate latin1_general_ci default NULL,
  `news_text` text collate latin1_general_ci,
  PRIMARY KEY  (`news_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

-- 
-- Daten für Tabelle `fs_news`
-- 

REPLACE INTO `fs_news` VALUES (1, 1, 1, 1186939080, 'Lorem Ipsum', 'Lorem Ipsum');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `fs_news_cat`
-- 

DROP TABLE IF EXISTS `fs_news_cat`;
CREATE TABLE `fs_news_cat` (
  `cat_id` smallint(6) NOT NULL auto_increment,
  `cat_name` varchar(100) collate latin1_general_ci default NULL,
  `cat_description` text collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

-- 
-- Daten für Tabelle `fs_news_cat`
-- 

REPLACE INTO `fs_news_cat` VALUES (1, 'latein', '');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `fs_news_comments`
-- 

DROP TABLE IF EXISTS `fs_news_comments`;
CREATE TABLE `fs_news_comments` (
  `comment_id` mediumint(8) NOT NULL auto_increment,
  `news_id` mediumint(8) default NULL,
  `comment_poster` varchar(32) collate latin1_general_ci default NULL,
  `comment_poster_id` mediumint(8) default NULL,
  `comment_date` int(11) default NULL,
  `comment_title` varchar(100) collate latin1_general_ci default NULL,
  `comment_text` text collate latin1_general_ci,
  PRIMARY KEY  (`comment_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

-- 
-- Daten für Tabelle `fs_news_comments`
-- 

REPLACE INTO `fs_news_comments` VALUES (1, 1, '1', 1, 1187028975, 'Smilies', ':-):-(;-)xD:-o^_^:-/:-]>-(');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `fs_news_config`
-- 

DROP TABLE IF EXISTS `fs_news_config`;
CREATE TABLE `fs_news_config` (
  `num_news` int(11) default NULL,
  `num_head` int(11) default NULL,
  `html_code` tinyint(4) default NULL,
  `fs_code` tinyint(4) default NULL,
  `para_handling` tinyint(4) default NULL,
  `cat_pic_x` mediumint(4) NOT NULL default '0',
  `cat_pic_y` mediumint(4) NOT NULL default '0',
  `com_rights` tinyint(1) NOT NULL default '1',
  `com_antispam` tinyint(1) NOT NULL default '1',
  `com_sort` varchar(40) collate latin1_general_ci NOT NULL default 'DESC'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- 
-- Daten für Tabelle `fs_news_config`
-- 

REPLACE INTO `fs_news_config` VALUES (10, 6, 2, 4, 2, 150, 150, 2, 1, 'desc');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `fs_news_links`
-- 

DROP TABLE IF EXISTS `fs_news_links`;
CREATE TABLE `fs_news_links` (
  `news_id` mediumint(8) default NULL,
  `link_id` mediumint(8) NOT NULL auto_increment,
  `link_name` varchar(100) collate latin1_general_ci default NULL,
  `link_url` varchar(255) collate latin1_general_ci default NULL,
  `link_target` tinyint(4) default NULL,
  PRIMARY KEY  (`link_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- 
-- Daten für Tabelle `fs_news_links`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `fs_partner`
-- 

DROP TABLE IF EXISTS `fs_partner`;
CREATE TABLE `fs_partner` (
  `partner_id` smallint(3) unsigned NOT NULL auto_increment,
  `partner_name` varchar(150) collate latin1_general_ci NOT NULL default '',
  `partner_link` varchar(250) collate latin1_general_ci NOT NULL default '',
  `partner_beschreibung` text collate latin1_general_ci NOT NULL,
  `partner_permanent` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`partner_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- 
-- Daten für Tabelle `fs_partner`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `fs_partner_config`
-- 

DROP TABLE IF EXISTS `fs_partner_config`;
CREATE TABLE `fs_partner_config` (
  `partner_anzahl` tinyint(2) NOT NULL default '0',
  `small_x` int(11) NOT NULL default '0',
  `small_y` int(11) NOT NULL default '0',
  `small_allow` tinyint(1) NOT NULL default '0',
  `big_x` int(11) NOT NULL default '0',
  `big_y` int(11) NOT NULL default '0',
  `big_allow` tinyint(1) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- 
-- Daten für Tabelle `fs_partner_config`
-- 

REPLACE INTO `fs_partner_config` VALUES (5, 88, 31, 0, 468, 60, 1);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `fs_permissions`
-- 

DROP TABLE IF EXISTS `fs_permissions`;
CREATE TABLE `fs_permissions` (
  `user_id` mediumint(8) default NULL,
  `perm_newsadd` tinyint(4) NOT NULL default '0',
  `perm_newsedit` tinyint(4) NOT NULL default '0',
  `perm_newscat` tinyint(4) NOT NULL default '0',
  `perm_newsnewcat` tinyint(4) NOT NULL default '0',
  `perm_newsconfig` tinyint(4) NOT NULL default '0',
  `perm_dladd` tinyint(4) NOT NULL default '0',
  `perm_dledit` tinyint(4) NOT NULL default '0',
  `perm_dlcat` tinyint(4) NOT NULL default '0',
  `perm_dlnewcat` tinyint(4) NOT NULL default '0',
  `perm_polladd` tinyint(4) NOT NULL default '0',
  `perm_polledit` tinyint(4) NOT NULL default '0',
  `perm_potmadd` tinyint(4) NOT NULL default '0',
  `perm_potmedit` tinyint(4) NOT NULL default '0',
  `perm_screenadd` tinyint(4) NOT NULL default '0',
  `perm_screenedit` tinyint(4) NOT NULL default '0',
  `perm_screencat` tinyint(4) NOT NULL default '0',
  `perm_screennewcat` tinyint(4) NOT NULL default '0',
  `perm_screenconfig` tinyint(4) NOT NULL default '0',
  `perm_shopadd` tinyint(4) NOT NULL default '0',
  `perm_shopedit` tinyint(4) NOT NULL default '0',
  `perm_statedit` tinyint(4) NOT NULL default '0',
  `perm_useradd` tinyint(4) NOT NULL default '0',
  `perm_useredit` tinyint(4) NOT NULL default '0',
  `perm_userrights` tinyint(4) NOT NULL default '0',
  `perm_map` tinyint(4) NOT NULL default '0',
  `perm_statview` tinyint(4) NOT NULL default '0',
  `perm_statref` tinyint(4) NOT NULL default '0',
  `perm_artikeladd` tinyint(4) NOT NULL default '0',
  `perm_artikeledit` tinyint(4) NOT NULL default '0',
  `perm_templateedit` tinyint(4) NOT NULL default '0',
  `perm_allphpinfo` tinyint(4) NOT NULL default '0',
  `perm_allconfig` tinyint(4) NOT NULL default '0',
  `perm_allannouncement` tinyint(4) NOT NULL default '0',
  `perm_statspace` tinyint(4) NOT NULL default '0',
  `perm_gbedit` tinyint(4) NOT NULL default '0',
  `perm_gbcat` tinyint(4) NOT NULL default '0',
  `perm_partneradd` tinyint(4) NOT NULL default '0',
  `perm_partneredit` tinyint(4) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- 
-- Daten für Tabelle `fs_permissions`
-- 

REPLACE INTO `fs_permissions` VALUES (1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `fs_poll`
-- 

DROP TABLE IF EXISTS `fs_poll`;
CREATE TABLE `fs_poll` (
  `poll_id` mediumint(8) NOT NULL auto_increment,
  `poll_quest` char(255) collate latin1_general_ci default NULL,
  `poll_start` int(11) default NULL,
  `poll_end` int(11) default NULL,
  `poll_type` tinyint(4) default NULL,
  `poll_participants` mediumint(8) NOT NULL default '0',
  PRIMARY KEY  (`poll_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- 
-- Daten für Tabelle `fs_poll`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `fs_poll_answers`
-- 

DROP TABLE IF EXISTS `fs_poll_answers`;
CREATE TABLE `fs_poll_answers` (
  `poll_id` mediumint(8) default NULL,
  `answer_id` mediumint(8) NOT NULL auto_increment,
  `answer` varchar(255) collate latin1_general_ci default NULL,
  `answer_count` mediumint(8) NOT NULL default '0',
  PRIMARY KEY  (`answer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- 
-- Daten für Tabelle `fs_poll_answers`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `fs_poll_voters`
-- 

DROP TABLE IF EXISTS `fs_poll_voters`;
CREATE TABLE `fs_poll_voters` (
  `voter_id` mediumint(8) unsigned NOT NULL auto_increment,
  `poll_id` mediumint(8) unsigned NOT NULL default '0',
  `ip_address` varchar(15) collate latin1_general_ci NOT NULL default '0.0.0.0',
  `time` int(32) NOT NULL default '0',
  PRIMARY KEY  (`voter_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- 
-- Daten für Tabelle `fs_poll_voters`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `fs_press`
-- 

DROP TABLE IF EXISTS `fs_press`;
CREATE TABLE `fs_press` (
  `press_id` smallint(6) NOT NULL auto_increment,
  `press_title` varchar(150) collate latin1_general_ci NOT NULL,
  `press_url` varchar(255) collate latin1_general_ci NOT NULL,
  `press_date` int(12) NOT NULL,
  `press_text` text collate latin1_general_ci NOT NULL,
  `press_lang` tinyint(2) NOT NULL,
  `press_game` tinyint(2) NOT NULL,
  `press_cat` tinyint(2) NOT NULL,
  `press_rating` varchar(100) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`press_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- 
-- Daten für Tabelle `fs_press`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `fs_press_cat`
-- 

DROP TABLE IF EXISTS `fs_press_cat`;
CREATE TABLE `fs_press_cat` (
  `press_cat_id` smallint(6) NOT NULL auto_increment,
  `press_cat_name` varchar(100) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`press_cat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- 
-- Daten für Tabelle `fs_press_cat`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `fs_press_game`
-- 

DROP TABLE IF EXISTS `fs_press_game`;
CREATE TABLE `fs_press_game` (
  `press_game_id` smallint(6) NOT NULL auto_increment,
  `press_game_name` varchar(100) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`press_game_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- 
-- Daten für Tabelle `fs_press_game`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `fs_screen`
-- 

DROP TABLE IF EXISTS `fs_screen`;
CREATE TABLE `fs_screen` (
  `screen_id` mediumint(8) NOT NULL auto_increment,
  `cat_id` smallint(6) unsigned default NULL,
  `screen_name` char(100) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`screen_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=11 ;

-- 
-- Daten für Tabelle `fs_screen`
-- 

REPLACE INTO `fs_screen` VALUES (1, 1, '');
REPLACE INTO `fs_screen` VALUES (2, 1, '');
REPLACE INTO `fs_screen` VALUES (3, 1, '');
REPLACE INTO `fs_screen` VALUES (4, 1, '');
REPLACE INTO `fs_screen` VALUES (5, 1, '');
REPLACE INTO `fs_screen` VALUES (6, 1, '');
REPLACE INTO `fs_screen` VALUES (7, 1, '');
REPLACE INTO `fs_screen` VALUES (8, 1, '');
REPLACE INTO `fs_screen` VALUES (9, 1, '');
REPLACE INTO `fs_screen` VALUES (10, 1, '');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `fs_screen_cat`
-- 

DROP TABLE IF EXISTS `fs_screen_cat`;
CREATE TABLE `fs_screen_cat` (
  `cat_id` smallint(6) unsigned NOT NULL auto_increment,
  `cat_name` char(100) collate latin1_general_ci default NULL,
  `cat_type` tinyint(1) NOT NULL default '0',
  `cat_visibility` tinyint(1) NOT NULL default '1',
  `cat_date` int(11) NOT NULL default '0',
  `randompic` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=5 ;

-- 
-- Daten für Tabelle `fs_screen_cat`
-- 

REPLACE INTO `fs_screen_cat` VALUES (1, 'sichtbar', 1, 2, 1187036417, 0);
REPLACE INTO `fs_screen_cat` VALUES (2, 'nicht in Auswahl', 1, 2, 1187036435, 0);
REPLACE INTO `fs_screen_cat` VALUES (3, 'nicht sichtbar', 1, 0, 1187036440, 0);
REPLACE INTO `fs_screen_cat` VALUES (4, 'Bilder', 2, 1, 1187122022, 0);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `fs_screen_config`
-- 

DROP TABLE IF EXISTS `fs_screen_config`;
CREATE TABLE `fs_screen_config` (
  `screen_x` int(11) default NULL,
  `screen_y` int(11) default NULL,
  `thumb_x` int(11) default NULL,
  `thumb_y` int(11) default NULL,
  `max_size` int(11) NOT NULL default '0',
  `pics_per_row` tinyint(1) NOT NULL,
  `pics_per_page` tinyint(2) NOT NULL,
  `sort` varchar(4) collate latin1_general_ci NOT NULL,
  `show_img_x` int(4) NOT NULL,
  `show_img_y` int(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- 
-- Daten für Tabelle `fs_screen_config`
-- 

REPLACE INTO `fs_screen_config` VALUES (5000, 5000, 120, 90, 2048, 3, 6, 'desc', 800, 600);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `fs_screen_random`
-- 

DROP TABLE IF EXISTS `fs_screen_random`;
CREATE TABLE `fs_screen_random` (
  `random_id` int(10) unsigned NOT NULL auto_increment,
  `screen_id` int(11) NOT NULL,
  `start` int(11) NOT NULL,
  `end` int(11) NOT NULL,
  PRIMARY KEY  (`random_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Daten für Tabelle `fs_screen_random`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `fs_screen_random_config`
-- 

DROP TABLE IF EXISTS `fs_screen_random_config`;
CREATE TABLE `fs_screen_random_config` (
  `id` mediumint(9) NOT NULL default '1',
  `active` tinyint(1) NOT NULL default '1',
  `type_priority` tinyint(1) NOT NULL default '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- 
-- Daten für Tabelle `fs_screen_random_config`
-- 

REPLACE INTO `fs_screen_random_config` VALUES (1, 1, 1);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `fs_shop`
-- 

DROP TABLE IF EXISTS `fs_shop`;
CREATE TABLE `fs_shop` (
  `artikel_id` smallint(6) unsigned NOT NULL auto_increment,
  `artikel_name` varchar(100) collate latin1_general_ci default NULL,
  `artikel_url` varchar(255) collate latin1_general_ci default NULL,
  `artikel_text` text collate latin1_general_ci,
  `artikel_preis` varchar(10) collate latin1_general_ci default NULL,
  `artikel_hot` tinyint(4) default NULL,
  PRIMARY KEY  (`artikel_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- 
-- Daten für Tabelle `fs_shop`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `fs_smilies`
-- 

DROP TABLE IF EXISTS `fs_smilies`;
CREATE TABLE `fs_smilies` (
  `id` mediumint(6) NOT NULL auto_increment,
  `replace_string` varchar(15) collate latin1_general_ci NOT NULL,
  `order` int(3) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=11 ;

-- 
-- Daten für Tabelle `fs_smilies`
-- 

REPLACE INTO `fs_smilies` VALUES (1, ':-)', 1);
REPLACE INTO `fs_smilies` VALUES (2, ':-(', 2);
REPLACE INTO `fs_smilies` VALUES (3, ';-)', 3);
REPLACE INTO `fs_smilies` VALUES (4, ':-P', 4);
REPLACE INTO `fs_smilies` VALUES (5, 'xD', 5);
REPLACE INTO `fs_smilies` VALUES (6, ':-o', 6);
REPLACE INTO `fs_smilies` VALUES (7, '^_^', 7);
REPLACE INTO `fs_smilies` VALUES (8, ':-/', 8);
REPLACE INTO `fs_smilies` VALUES (9, ':-]', 9);
REPLACE INTO `fs_smilies` VALUES (10, '&gt;-(', 10);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `fs_template`
-- 

DROP TABLE IF EXISTS `fs_template`;
CREATE TABLE `fs_template` (
  `id` tinyint(4) NOT NULL default '0',
  `name` varchar(100) collate latin1_general_ci NOT NULL default '',
  `indexphp` text collate latin1_general_ci NOT NULL,
  `artikel_body` text collate latin1_general_ci NOT NULL,
  `artikel_autor` text collate latin1_general_ci NOT NULL,
  `randompic_body` text collate latin1_general_ci NOT NULL,
  `randompic_nobody` text collate latin1_general_ci NOT NULL,
  `shop_body` text collate latin1_general_ci NOT NULL,
  `shop_hot` text collate latin1_general_ci NOT NULL,
  `news_link` text collate latin1_general_ci NOT NULL,
  `news_related_links` text collate latin1_general_ci NOT NULL,
  `news_headline` text collate latin1_general_ci NOT NULL,
  `main_menu` text collate latin1_general_ci NOT NULL,
  `news_comment_body` text collate latin1_general_ci NOT NULL,
  `news_comment_autor` text collate latin1_general_ci NOT NULL,
  `news_comment_form` text collate latin1_general_ci NOT NULL,
  `news_comment_form_name` text collate latin1_general_ci NOT NULL,
  `news_comment_form_spam` text collate latin1_general_ci NOT NULL,
  `news_comment_form_spamtext` text collate latin1_general_ci NOT NULL,
  `news_search_form` text collate latin1_general_ci NOT NULL,
  `error` text collate latin1_general_ci NOT NULL,
  `news_headline_body` text collate latin1_general_ci NOT NULL,
  `user_mini_login` text collate latin1_general_ci NOT NULL,
  `shop_main_body` text collate latin1_general_ci NOT NULL,
  `shop_artikel` text collate latin1_general_ci NOT NULL,
  `dl_navigation` text collate latin1_general_ci NOT NULL,
  `dl_search_field` text collate latin1_general_ci NOT NULL,
  `dl_body` text collate latin1_general_ci NOT NULL,
  `dl_datei_preview` text collate latin1_general_ci NOT NULL,
  `dl_file_body` text collate latin1_general_ci NOT NULL,
  `dl_file` text collate latin1_general_ci NOT NULL,
  `dl_file_is_mirror` text collate latin1_general_ci NOT NULL,
  `dl_stats` text collate latin1_general_ci NOT NULL,
  `dl_quick_links` text collate latin1_general_ci NOT NULL,
  `screenshot_pic` text collate latin1_general_ci NOT NULL,
  `screenshot_body` text collate latin1_general_ci NOT NULL,
  `screenshot_cat` text collate latin1_general_ci NOT NULL,
  `screenshot_cat_body` text collate latin1_general_ci NOT NULL,
  `wallpaper_pic` text collate latin1_general_ci NOT NULL,
  `wallpaper_sizes` text collate latin1_general_ci NOT NULL,
  `pic_viewer` text collate latin1_general_ci NOT NULL,
  `user_user_menu` text collate latin1_general_ci NOT NULL,
  `user_admin_link` text collate latin1_general_ci NOT NULL,
  `user_login` text collate latin1_general_ci NOT NULL,
  `user_profiledit` text collate latin1_general_ci NOT NULL,
  `user_memberlist_body` text collate latin1_general_ci NOT NULL,
  `user_memberlist_userline` text collate latin1_general_ci NOT NULL,
  `user_memberlist_adminline` text collate latin1_general_ci NOT NULL,
  `user_spam` text collate latin1_general_ci NOT NULL,
  `user_spamtext` text collate latin1_general_ci NOT NULL,
  `community_map` text collate latin1_general_ci NOT NULL,
  `poll_body` text collate latin1_general_ci NOT NULL,
  `poll_line` text collate latin1_general_ci NOT NULL,
  `poll_main_body` text collate latin1_general_ci NOT NULL,
  `poll_main_line` text collate latin1_general_ci NOT NULL,
  `poll_result` text collate latin1_general_ci NOT NULL,
  `poll_result_line` text collate latin1_general_ci NOT NULL,
  `poll_list` text collate latin1_general_ci NOT NULL,
  `poll_list_line` text collate latin1_general_ci NOT NULL,
  `poll_no_poll` text collate latin1_general_ci NOT NULL,
  `user_profil` text collate latin1_general_ci NOT NULL,
  `statistik` text collate latin1_general_ci NOT NULL,
  `user_register` text collate latin1_general_ci NOT NULL,
  `news_body` text collate latin1_general_ci NOT NULL,
  `announcement` text collate latin1_general_ci NOT NULL,
  `email_register` text collate latin1_general_ci NOT NULL,
  `email_passchange` text collate latin1_general_ci NOT NULL,
  `partner_eintrag` text collate latin1_general_ci NOT NULL,
  `partner_main_body` text collate latin1_general_ci NOT NULL,
  `partner_navi_eintrag` text collate latin1_general_ci NOT NULL,
  `partner_navi_body` text collate latin1_general_ci NOT NULL,
  `code_tag` text collate latin1_general_ci NOT NULL,
  `quote_tag` text collate latin1_general_ci NOT NULL,
  `quote_tag_name` text collate latin1_general_ci NOT NULL,
  `editor_design` text collate latin1_general_ci NOT NULL,
  `editor_css` text collate latin1_general_ci NOT NULL,
  `editor_button` text collate latin1_general_ci NOT NULL,
  `editor_seperator` text collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci PACK_KEYS=1;

-- 
-- Daten für Tabelle `fs_template`
-- 

REPLACE INTO `fs_template` VALUES (0, 'default', '<body>\r\n    <div id="head_shadow"></div>\r\n    <div id="head">[%test%]<br />[%hallo%]</div>\r\n\r\n\r\n    <div id="menu_l_shadow">\r\n        <div id="menu_l">\r\n{main_menu}\r\n        </div>\r\n    </div>\r\n    <div id="main_container">\r\n        <div id="main_shadow">\r\n            <div id="main">\r\n{announcement}\r\n{content}\r\n            </div>\r\n        </div>\r\n        <p>\r\n    </div>\r\n\r\n    <div id="menu_r_shadow">\r\n        <div id="menu_r">\r\n{user}<br><br>\r\n{randompic}\r\nShop:<br>\r\n{shop}<br><br>\r\nUmfrage:<br>\r\n{poll}<br><br>\r\nPartner:<br>\r\n{partner}<br><br>\r\nStatistik:<br>\r\n{stats}<br><br>\r\nNetzwerk:<br>\r\n[%netzwerk%]\r\n<br><br>\r\n        </div>\r\n    </div>\r\n</body>', '<div class="news_head" style="height:10px;">\r\n   <span style="float:left;">\r\n       <b>{titel}</b>\r\n   </span>\r\n   <span class="small" style="float:right;">\r\n       <b>{datum}</b>\r\n   </span>\r\n</div>\r\n<div>\r\n   {text}\r\n</div>\r\n<div>\r\n   <span class="small" style="float:right;">\r\n       {autor}\r\n   </span>\r\n</div>\r\n<p></p>', 'geschrieben von <a class="small" href="{profillink}">{username}</a>', '<img class=\\"thumb\\" onClick=\\"open(\\''{link}\\'',\\''Picture\\'',\\''width=900,height=710,screenX=0,screenY=0\\'')\\" src=\\"{thumb}\\" alt=\\"{titel}\\">', '<div class=\\"small\\" align=\\"center\\">\r\n     Kein Zufallsbild aktiv\r\n</div>', '{hotlinks}', '<div align="center">\r\n    <a style="font-weight:bold;" class="small" target="_blank" href="{link}">{titel}</a>\r\n</div>', '<li><a href="{url}" target="{target}">{name}</a></li>', '<p>\r\n<b>Related Links:</b>\r\n<ul>\r\n    {links}\r\n</ul>', '<span class="small">{datum} </span><a class="small" href="{url}">{titel}</a><br>', '<b>Allgemein</b><br>\r\n<a class="small" href="{virtualhost}?go=news">- News</a><br>\r\n<a class="small" href="{virtualhost}?go=newsarchiv">- News Archiv</a><br>\r\n<a class="small" href="{virtualhost}?go=pollarchiv">- Umfragen Archiv</a><br>\r\n<a class="small" href="{virtualhost}?go=shop">- Shop</a><br>\r\n<a class="small" href="{virtualhost}?go=screenshots">- Screenshots</a><br>\r\n<a class="small" href="{virtualhost}?go=map">- Community Map</a><br>\r\n<a class="small" href="{virtualhost}?go=members">- Mitgliederliste</a><br>\r\n<a class="small" href="{virtualhost}?go=download">- Downloads</a><br>', '<div class="news_head" style="height:10px;">\r\n    <span style="float:left;">\r\n        <b>{titel}</b>\r\n    </span>\r\n    <span class="small" style="float:right;">\r\n        <b>{datum}</b>\r\n    </span>\r\n</div>\r\n<div style="padding:3px;">\r\n    <table border="0" cellpadding="0" cellspacing="0" width="100%">\r\n        <tr>\r\n            <td align="left" valign="top">\r\n                {autor_avatar}\r\n            </td>\r\n            <td valign="top" align="left">\r\n                {text}\r\n            </td>\r\n        </tr>\r\n    </table>\r\n</div>\r\n<div class="news_footer">\r\n    <span class="small" style="float:right;">\r\n        geschrieben von: {autor}</a>\r\n    </span>\r\n</div>\r\n<br /><br /><br />', '<a class="small" href="{url}">{name}</a>', '<script type="text/javascript"> \r\n<!-- \r\n    function chkFormular() \r\n    {\r\n        if((document.getElementById("name").value == "") ||\r\n           (document.getElementById("title").value == "") ||\r\n           (document.getElementById("text").value == ""))\r\n        {\r\n            alert ("Du hast nicht alle Felder ausgefüllt"); \r\n            return false;\r\n        }\r\n    } \r\n//--> \r\n</script> \r\n\r\n<b id="add">Kommentar hinzufügen</b><p>\r\n<div>\r\n    <form action="" method="post" onSubmit="return chkFormular()">\r\n        <input type="hidden" name="go" value="comments">\r\n        <input type="hidden" name="addcomment" value="1">\r\n        <input type="hidden" name="id" value="{newsid}">\r\n        <table width="100%"> \r\n            <tr>\r\n                <td align="left">\r\n                    <b>Name: </b>\r\n                </td>\r\n                <td align="left">\r\n                    {name_input}\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td align="left">\r\n                    <b>Titel: </b>\r\n                </td>\r\n                <td align="left">\r\n                    <input class="text" name="title" id="title" size="32" maxlength="32">\r\n                </td>\r\n            </tr>\r\n{antispam}\r\n            <tr>\r\n                <td align="left" valign="top">\r\n                    <b>Text:</b><br />\r\n                      <font class="small">Html ist {html}.<br />\r\n                      FScode ist {fs_code}.</font>\r\n                </td>\r\n                <td align="left">\r\n                    {textarea}\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td></td>\r\n                <td align="left">\r\n                    <input class="button" type="submit" value="Absenden">\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td></td>\r\n                <td align="left">\r\n                   {antispamtext}\r\n                </td>\r\n            </tr>\r\n        </table>\r\n    </form>\r\n</div><p>', '<input class="text" name="name" id="name" size="32" maxlength="25">\r\n<span class="small"> Willst du dich </span>\r\n<a class="small" href="?go=login">einloggen?</a>', '<tr>\r\n                <td align="left">\r\n                    <img src="{captcha_url}">\r\n                </td>\r\n                <td align="left">\r\n                    <input class="text" name="spam" id="spam" size="32" maxlength="25">\r\n<span class="small">Bitte löse diese kleine Rechenaufgabe.</span> <a class="small" href="#antispam">Warum? *</a>\r\n                </td>\r\n            </tr>', '<br /><br />\r\n <table border="0" cellspacing="0" cellpadding="0" width="60%">\r\n  <tr>\r\n   <td valign="top" align="left">\r\n<div id="antispam"><font size="1">* Auf dieser Seite kann jeder einen Kommentar zu einer News abgeben. Leider ist sie dadurch ein beliebtes Ziel von sog. Spam-Bots - speziellen Programmen, die automatisiert und zum Teil massenhaft Links zu anderen Internetseiten platziern. Um das zu verhindern müssen nicht registrierte User eine einfache Rechenaufgabe lösen, die für die meisten Spam-Bots aber nicht lösbar ist. Wenn du nicht jedesmal eine solche Aufgabe lösen möchtest, kannst du dich einfach bei uns <a href="?go=register">registrieren</a>.</font></div>\r\n   </td>\r\n  </tr>\r\n </table>', '<script type="text/javascript"> \r\n<!-- \r\n    function chkFormular() \r\n    {\r\n        if (document.getElementById("keyword").value.length < "4")\r\n        {\r\n            alert("Es müssen mehr als 3 Zeichen sein"); \r\n            return false;\r\n        }\r\n    } \r\n//--> \r\n</script> \r\n\r\n<b>NEWSARCHIV</b><p>\r\n<div>\r\n    <form action="" method="post">\r\n        <input type="hidden" name="go" value="newsarchiv">\r\n        <b>News aus dem: </b>\r\n        <select class="text" name="monat">\r\n            <option value="1">Januar</option>\r\n            <option value="2">Februar</option>\r\n            <option value="3">März</option>\r\n            <option value="4">April</option>\r\n            <option value="5">Mai</option>\r\n            <option value="6">Juni</option>\r\n            <option value="7">Juli</option>\r\n            <option value="8">August</option>\r\n            <option value="9">September</option>\r\n            <option value="10">Oktober</option>\r\n            <option value="11">November</option>\r\n            <option value="12">Dezember</option>\r\n        </select>\r\n        <select class="text" name="jahr">\r\n            {years}\r\n        </select>\r\n        <input class="button" type="submit" value="Anzeigen">\r\n    </form>\r\n    <p>\r\n    oder\r\n    <p>\r\n    <form action="" method="post" onSubmit="return chkFormular()">\r\n        <input type="hidden" name="go" value="newsarchiv">\r\n        <b>Nach: </b>\r\n        <input class="text" id="keyword" name="keyword" size="30" maxlength="20">\r\n        <input class="button" type="submit" value="Suchen">\r\n    </form>\r\n</div>\r\n<p></p>', '<b>{titel}</b><br>\r\n{meldung}\r\n<p></p>', '<b>NEWS</b><p>\r\n<div>\r\n    <b>Headlines:</b><br>\r\n    {headlines}\r\n</div>\r\n<div>\r\n    <b>Downloads:</b><br>\r\n    {downloads}\r\n</div>\r\n<p>', '<tr>\r\n    <b>Einloggen</b>\r\n</tr>\r\n<tr>\r\n    <td align="center">\r\n        <form action="" method="post">\r\n            <input type="hidden" name="go" value="login">\r\n            <input type="hidden" name="login" value="1">\r\n            <table align="center" border="0" cellpadding="0" cellspacing="0" width="120">\r\n                <tr>\r\n                    <td align="right">\r\n                        <font class="small">Name:</font>\r\n                    </td>\r\n                    <td>\r\n                        <input class="text" size="10" name="username" maxlength="100">\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <td align="right">\r\n                        <font class="small">Pass:</font>\r\n                    </td>\r\n                    <td>\r\n                        <input class="text" size="10" type="password" name="userpassword" maxlength="16">\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <td align="center" colspan="2">\r\n                        <input type="checkbox" name="stayonline" value="1" checked>\r\n                        <font class="small">eingeloggt bleiben</font>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <td align="center" colspan="2">\r\n                        <input class="button" type="submit" value="Anmelden">\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan="2" align="center">\r\n                        <a class="small" href="?go=register">Noch nicht registriert?</a>\r\n                    </td>\r\n                </tr>\r\n            </table>\r\n        </form>\r\n    </td>\r\n</tr>', '<b>SHOP</b><p>\r\n<table width="100%">\r\n    {artikel}\r\n</table>', '<tr>\r\n    <td align="left" valign="top" width="60" rowspan="4">\r\n        <img border="0" style="cursor:pointer;" onClick=open(''showimg.php?pic={bild}'',''Picture'',''width=900,height=710,screenX=0,screenY=0'') src="{thumbnail}">\r\n    </td>\r\n    <td align="left" width="100">\r\n        <b>Titel:</b>\r\n    </td>\r\n        <td align="left">\r\n            {titel}\r\n        </td>\r\n    </tr>\r\n<tr>\r\n    <td align="left" valign="top">\r\n        <b>Beschreibung:</b>\r\n    </td>\r\n    <td align="left" valign="top">\r\n        {beschreibung}</td>\r\n    </tr>\r\n<tr>\r\n    <td align="left">\r\n        <b>Preis:</b>\r\n    </td>\r\n    <td align="left">\r\n        {preis} ¤\r\n    </td>\r\n</tr>\r\n<tr>\r\n    <td align="left"></td>\r\n    <td align="left">\r\n        <a href="{bestell_url}" target="_blank">Jetzt bestellen!</a>\r\n    </td>\r\n</tr>\r\n<tr>\r\n    <td colspan="3">\r\n         \r\n    </td>\r\n</tr>', '<img border="0" src="images/design/{icon}">\r\n<a href="{kategorie_url}">{kategorie_name}</a><br>', '<form action="" method="get">\r\n<tr>\r\n  <td colspan="3" align="right"><br /> <b>Kategorie durchsuchen:</b></td>\r\n  <td colspan="1" align="left"><br /> \r\n    <input class="text" size="20" name="keyword" value="{keyword}">\r\n    <input class="button" type="submit" value="Go">\r\n    <input class="button" type="button" value="Alle anzeigen" onclick="location=''{all_url}''">\r\n    <input type="hidden" name="go" value="download">\r\n    {input_cat}</td>\r\n</tr>\r\n\r\n</form>', '<b>DOWNLOADS</b><p>\r\n{navigation}\r\n<table border="0" cellpadding="0" cellspacing="2" width="100%">\r\n<tr>\r\n  <td style="border: 1px solid #000000; padding: 3px;"><strong>Titel</strong></td>\r\n  <td style="border: 1px solid #000000; padding: 3px;"><strong>Kategorie</strong></td>\r\n  <td style="border: 1px solid #000000; padding: 3px;"><strong>Uploaddatum</strong></td>\r\n  <td style="border: 1px solid #000000; padding: 3px;"><strong>Beschreibung</strong></td>\r\n </tr>\r\n{dateien}\r\n{suchfeld}\r\n</table>', '<tr>\r\n  <td style="border: 1px solid #000000; padding: 3px;"><a href="{url}"><b>{name}</b></a></td>\r\n  <td style="border: 1px solid #000000; padding: 3px;" align="center" valign="middle">{cat}</td>\r\n  <td style="border: 1px solid #000000; padding: 3px;" align="center" valign="middle">{datum}</td>\r\n  <td style="border: 1px solid #000000; padding: 3px;">{text}</td>\r\n </tr>', '<b>DOWNLOADS -> {titel}</b><p>\r\n{navigation}\r\n    <table width="100%">\r\n        <tr>\r\n            <td align="left" width="130" rowspan="6" valign="top">\r\n                <img class="thumb" onClick=open(''showimg.php?pic={bild}'',''Picture'',''width=900,height=710,screenX=0,screenY=0'') src="{thumbnail}">\r\n            </td>\r\n        </tr>\r\n         <tr>\r\n            <td align="left" colspan="2" height="20" valign="top">\r\n                <b>{titel}</b>\r\n            </td>\r\n        </tr>\r\n       <tr>\r\n            <td align="left" width="75">\r\n                <b>Kategorie:</b>\r\n            </td>\r\n            <td align="left">\r\n                {cat}\r\n            </td>\r\n        </tr>\r\n       <tr>\r\n            <td align="left" width="75">\r\n                <b>Datum:</b>\r\n            </td>\r\n            <td align="left">\r\n                {datum}\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td align="left" width="75">\r\n                <b>Uploader:</b>\r\n            </td>\r\n            <td align="left">\r\n                <a href="{uploader_url}">{uploader}</a>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td align="left" width="75">\r\n                <b>Autor:</b>\r\n            </td>\r\n            <td align="left">\r\n                {autor_link}\r\n            </td>\r\n        </tr>\r\n    </table>\r\n    <br>\r\n    <table width="100%">\r\n        <tr>\r\n            <td align="left" valign="top" width="130">\r\n                <b>Beschreibung:</b>\r\n            </td>\r\n            <td align="left" valign="top">{text}\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan="2"></td>\r\n        </tr>\r\n        <tr>\r\n             <td align="left" valign="top">\r\n                 <b>Dateien:</b>\r\n             </td>\r\n             <td align="left">{messages}\r\n             </td>\r\n         </tr>\r\n         <tr>\r\n             <td colspan="2"></td>\r\n         </tr>\r\n    </table>\r\n\r\n<table border="0" cellpadding="0" cellspacing="2" width="100%">\r\n<tr>\r\n  <td style="border: 1px solid #000000; padding: 3px;" colspan="2" ><strong>Datei (Download)</strong></td>\r\n  <td style="border: 1px solid #000000; padding: 3px;"><strong>Größe</strong></td>\r\n  <td style="border: 1px solid #000000; padding: 3px;"><strong>Traffic</strong></td>\r\n  <td style="border: 1px solid #000000; padding: 3px;"><strong>Downloads</strong></td>\r\n</tr>\r\n{files}\r\n<tr>\r\n  <td colspan="5" style="border: 1px solid #000000; padding: 3px;"><img alt="" src="images/design/null.gif"></td>\r\n</tr>\r\n{stats}\r\n</table>', '<tr>\r\n  <td style="border: 1px solid #000000; padding: 3px;"{mirror_col}><a target="_blank" href="{url}"><b>{name}</b></a></td>{mirror_ext}\r\n  <td style="border: 1px solid #000000; padding: 3px;">{size}</td>\r\n  <td style="border: 1px solid #000000; padding: 3px;">{traffic}</td>\r\n  <td style="border: 1px solid #000000; padding: 3px;">{hits}</td>\r\n</tr>', '<td style="border: 1px solid #000000; padding: 3px;" align="center" valign="middle"><b>Mirror!</b></td>', '<tr>\r\n              <td style="border: 1px solid #000000; padding: 3px;" colspan="2" >{number}</strong></td>\r\n              <td style="border: 1px solid #000000; padding: 3px;">{size}</td>\r\n              <td style="border: 1px solid #000000; padding: 3px;">{traffic}</td>\r\n              <td style="border: 1px solid #000000; padding: 3px;">{hits}</td>\r\n              </tr>', '<span class="small">{datum} </span><a class="small" href="{url}">{name}</a><br>', '<td class="small" align="center" valign="top">\r\n    <img class="thumb" onClick="open(''{url}'',''Picture'',''width=950,height=710,screenX=0,screenY=0'')" src="{thumbnail}" alt="{text}"><br>\r\n    {text}\r\n</td>', '<b>SCREENSHOT KATEGORIEN</b><p>\r\n<table width="100%">\r\n{cats}\r\n</table>', '<tr>\r\n    <td align="left">\r\n        <a href="{url}">{name}</a>\r\n    </td>\r\n    <td align="left">\r\n        erstellt am {datum}\r\n    </td>\r\n    <td align="left">\r\n        {menge} Bilder\r\n    </td>\r\n</tr>', '<b>SCREENSHOTS: {title}</b><p>\r\n<center>{page}</center><br />\r\n<table border="0" cellpadding="" cellspacing="10" width="100%">\r\n{screenshots}\r\n</table>', '<td align="center" valign="top">\r\n  <b>{text}</b><br />\r\n  <img src="{thumb_url}" alt="" />\r\n  <br /><br />\r\n  <b>Verfügbare Größen:</b>\r\n  {sizes}\r\n  <br />\r\n</td>', '<br />- <a href="{url}" target="_blank">{size}</a>', '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">\r\n<html>\r\n<head>\r\n    <title>DSA-Drakensang</title>\r\n    <link rel="stylesheet" type="text/css" href="inc/fs.css">\r\n    <LINK REL="SHORTCUT ICON" HREF="images/design/dsa.ico">\r\n</head>\r\n<body style="background-image:url(images/design/bg.jpg); background-position:center top;" leftmargin="0" topmargin="0">\r\n<center>\r\n{bannercode}\r\n<table style="border-width:2px; border-style:solid; border-color:#774C1F;" cellspacing="0" cellpadding="3">\r\n <tr align="center">\r\n  <td>\r\n   <a href="{bild_url}" target="_blank">{bild}</a><br><b>{text}</b>\r\n  </td>\r\n </tr>\r\n <tr>\r\n</table>\r\n<table cellspacing="0" cellpadding="3">\r\n <tr>\r\n  <td width="33%" align="right">\r\n   <b>{weiter_grafik}</b>\r\n  </td>\r\n  <td width="33%" align="center">\r\n   <b>{close}</b>\r\n  </td>\r\n  <td width="33%" align="left">\r\n   <b>{zurück_grafik}</b>\r\n  </td>\r\n </tr>\r\n</table>\r\n</center>\r\n\r\n</body>\r\n</html>', '<b>Willkommen {username}</b><br>\r\n<a class="small" href="{virtualhost}?go=editprofil">- Mein Profil</a><br>\r\n{admin}\r\n<a class="small" href="{logout}">- Logout</a>', '<a class=''small'' href=''{adminlink}'' target="_self">- Admin-CP</a><br />', '<div class="field_head" style="padding-left:60px; width:516px;">\r\n    <font class="h1" style="float:left; padding-top:14px;">Login</font>\r\n</div>\r\n<div class="field_middle" align="left">\r\n    <form action="" method="post">\r\n        <input type="hidden" name="go" value="login">\r\n        <input type="hidden" name="login" value="1">\r\n        <table align="center" border="0" cellpadding="4" cellspacing="0">\r\n            <tr>\r\n                <td align="right">\r\n                    <b>Name:</b>\r\n                </td>\r\n                <td>\r\n                    <input class="text" size="33" name="username" maxlength="100">\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td align="right">\r\n                    <b>Passwort:</b>\r\n                </td>\r\n                <td>\r\n                    <input class="text" size="33" type="password" name="userpassword" maxlength="16">\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td align="right">\r\n                    <b>Angemeldet bleiben:</b>\r\n                </td>\r\n                <td>\r\n                    <input type="checkbox" name="stayonline" value="1" checked>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td colspan="2" align="center">\r\n                    <input class="button" type="submit" value="Login">\r\n                </td>\r\n            </tr>\r\n        </table>\r\n    </form>\r\n    <p>\r\n    Du hast dich noch nicht registriert? Dann wirds jetzt aber Zeit ;) -> \r\n    <a href="?go=register">registrieren</a>\r\n    <p>\r\n</div>\r\n<div class="field_footer"></div>\r\n<p></p>', '<b>PROFIL ÄNDERN ({username})</b><p>\r\n<form action="" method="post" enctype="multipart/form-data">\r\n    <input type="hidden" name="go" value="editprofil">\r\n    <table align="center" border="0" cellpadding="4" cellspacing="0">\r\n        <tr>\r\n            <td width="50%" valign="top">\r\n                <b>Benutzerbild:</b>\r\n            </td>\r\n            <td width="50%">\r\n                {avatar}\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td>\r\n                <b>Benutzerbild hochladen:</b><br>\r\n                <font class="small">Nur wenn das alte überschrieben werden soll (max 110x110 px)</font>\r\n            </td>\r\n            <td>\r\n                <input class="text" size="16" type="file" name="userpic">\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td>\r\n                <b>E-Mail:</b><br>\r\n                <font class="small">Deine E-Mail Adresse</font>\r\n            </td>\r\n            <td>\r\n                <input class="text" size="34" value="{email}" name="usermail" maxlength="100">\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td>\r\n                <b>E-Mail zeigen:</b><br>\r\n                <font class="small">Zeige die E-Mail im öffentlichen Profil</font>\r\n            </td>\r\n            <td>\r\n                <input value="1" name="showmail" type="checkbox" {email_zeigen}>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td>\r\n                <b>Neues Passwort:</b><br>\r\n                <font class="small">Nur eintragen, wenn du ein neues Passwort erstellen willst</font>\r\n            </td>\r\n            <td>\r\n                <input class="text" size="33" type="password" name="userpassword" maxlength="16">\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan="2" align="center">\r\n                <input class="button" type="submit" value="Absenden">\r\n            </td>\r\n        </tr>\r\n    </table>\r\n</form>', '<b>Members List</b><br /><br />\r\n<table width="100%" border="0">\r\n<tr>\r\n  <td><b>Avatar</b></td>\r\n  <td><a href="?go=members&sort=name_{order_name}" style="color:#000;"><b>Benutzername</b> {arrow_name}</a></td>\r\n  <td><b>E-Mail</b></td>\r\n  <td><a href="?go=members&sort=regdate_{order_regdate}" style="color:#000;"><b>Registriert seit</b> {arrow_regdate}</a></td>\r\n  <td><a href="?go=members&sort=news_{order_news}" style="color:#000;"><b>News</b> {arrow_news}</a></td>\r\n  <td><a href="?go=members&sort=articles_{order_articles}" style="color:#000;"><b>Artikel</b> {arrow_articles}</a></td>\r\n  <td><a href="?go=members&sort=comments_{order_comments}" style="color:#000;"><b>Kommentare</b> {arrow_comments}</a></td>\r\n</tr>\r\n{members}\r\n</table><br /><br />\r\n<center>{page}</center>', '<tr>\r\n  <td align="center">{avatar}</td>\r\n  <td><a href="{userlink}" class="small">{username}</a></td>\r\n  <td>{email}</td>\r\n  <td align="center">{reg_date}</td>\r\n  <td align="center">{news}</td>\r\n  <td align="center">{articles}</td>\r\n  <td align="center">{comments}</td>\r\n</tr>', '<tr>\r\n  <td align="center">{avatar}</td>\r\n  <td><a href="{userlink}" class="small"><b><i>{username}</i></b></a></td>\r\n  <td>{email}</td>\r\n  <td align="center">{reg_date}</td>\r\n  <td align="center">{news}</td>\r\n  <td align="center">{articles}</td>\r\n  <td align="center">{comments}</td>\r\n</tr>', '<tr>\r\n                <td align="right">\r\n                    <img src="{captcha_url}">\r\n                </td>\r\n                <td>\r\n                    <input class="text" name="spam" id="spam" size="30" maxlength="25"><br />\r\n<span class="small">Bitte löse diese kleine Rechenaufgabe.</span>\r\n                </td>\r\n            </tr>', '<br /><br />\r\n <table border="0" cellspacing="0" cellpadding="0" width="60%">\r\n  <tr>\r\n   <td valign="top" align="left">\r\n<div id="antispam"><font size="1">* Auf dieser Seite kann jeder einen Kommentar zu einer News abgeben. Leider ist sie dadurch ein beliebtes Ziel von sog. Spam-Bots - speziellen Programmen, die automatisiert und zum Teil massenhaft Links zu anderen Internetseiten platzieren. Um das zu verhindern müssen nicht registrierte User eine einfache Rechenaufgabe lösen, die für die meisten Spam-Bots aber nicht lösbar ist. Wenn du nicht jedesmal eine solche Aufgabe lösen möchtest, kannst du dich einfach bei uns <a href="?go=register">registrieren</a>.</font></div>\r\n   </td>\r\n  </tr>\r\n </table>', '<div class="field_head" style="padding-left:60px; width:516px;">\r\n    <font class="h1" style="float:left; padding-top:14px;">Community Map</font>\r\n</div>\r\n<div class="field_middle" align="left">\r\n    {karte}\r\n    <div align="right">\r\n        <font class="small">Zum betrachten der Karte wird Flash benötigt: </font><br>\r\n        <img border="0" src="images/design/flash_rune.gif" align="middle">\r\n        <a target="_blank" href="http://www.adobe.com/go/getflashplayer">\r\n            <img border="0" src="images/design/flash_download_now.gif" align="middle">\r\n        </a>\r\n    </div>\r\n</div>\r\n<div class="field_footer"></div>\r\n<p></p>', '<form name=\\"poll\\" action=\\"\\" method=\\"post\\">\r\n    <input type=\\"hidden\\" name=\\"pollid\\" value=\\"{poll_id}\\">\r\n    <table align=\\"center\\" border=\\"0\\" cellpadding=\\"0\\" cellspacing=\\"0\\" width=\\"100%\\">\r\n        <tr>\r\n            <td class=\\"small\\" colspan=\\"2\\" align=\\"center\\">\r\n                <b>{question}</b>\r\n            </td>\r\n        </tr>\r\n{answers}\r\n        <tr>\r\n            <td colspan=\\"2\\" align=\\"center\\" ><br />\r\n                <input class=\\"button\\" type=\\"submit\\" value=\\"Abstimmen\\" {button_state}><br />\r\n<a class=\\"small\\" href=\\"?go=pollarchiv&pollid={poll_id}\\"><b>Ergebnis anzeigen!</b></a>\r\n            </td>\r\n        </tr>\r\n    </table>\r\n</form>', '<tr>\r\n    <td valign=\\"top\\">\r\n        <input type=\\"{type}\\" name=\\"answer{multiple}\\" value=\\"{answer_id}\\">\r\n    </td>\r\n    <td align=\\"left\\" class=\\"small\\">\r\n        {answer}\r\n    </td>\r\n</tr>', '<b>UMFRAGEN ARCHIV</b><p>\r\n<b>{frage}</b><p>\r\n<table width=\\"100%\\">\r\n{antworten}\r\n   <tr><td> </td></tr>\r\n   <tr><td align=\\"left\\">Anzahl der Teilnehmer: </td><td align=\\"left\\" colspan=\\"2\\"><b>{participants}</b></td></tr>\r\n   <tr><td align=\\"left\\">Anzahl der Stimmen: </td><td align=\\"left\\" colspan=\\"2\\"><b>{stimmen}</b></td></tr>\r\n   <tr><td align=\\"left\\">Art der Umfrage: </td><td align=\\"left\\" colspan=\\"2\\">{typ}</td></tr>\r\n   <tr><td align=\\"left\\">Umfragedauer:</td><td align=\\"left\\" colspan=\\"2\\">{start_datum} bis {end_datum}</td></tr>\r\n</table>', '<tr>\r\n    <td align=\\"left\\">{antwort}</td>\r\n    <td align=\\"left\\">{stimmen}</td>\r\n    <td align=\\"left\\">\r\n        <div style=\\"width:{balken_breite}px; height:4px; font-size:1px; background-color:#00FF00;\\">\r\n    </td>\r\n</tr>', '<table align=\\"center\\" border=\\"0\\" cellpadding=\\"0\\" cellspacing=\\"0\\" width=\\"100%\\">\r\n    <tr>\r\n        <td class=\\"small\\" colspan=\\"2\\" align=\\"center\\">\r\n            <b>{question}</b>\r\n        </td>\r\n    </tr>\r\n{answers}\r\n</table>\r\n<div class=\\"small\\">Teilnehmer: {participants}</div>\r\n<b>Bereits abgestimmt!</b>', '<tr>\r\n    <td align=\\"left\\" class=\\"small\\" colspan=\\"2\\">\r\n        {answer}\r\n    </td>\r\n</tr>\r\n<tr>\r\n    <td align=\\"left\\" class=\\"small\\">\r\n        {percentage}\r\n    </td>\r\n    <td align=\\"left\\">\r\n        <div style=\\"width:{bar_width}px; height:4px; font-size:1px; background-color:#00FF00;\\">\r\n    </td>\r\n</tr>', '<b>UMFRAGEN ARCHIV</b><p>\r\n<table border=\\"0\\" width=\\"100%\\" cellpadding=\\"2\\" cellspacing=\\"0\\">\r\n<tr>\r\n  <td align=\\"left\\"><a href=\\"?go=pollarchiv&sort=name_{order_name}\\" style=\\"color: #000\\"><b>Frage {arrow_name}</b></a></td>\r\n  <td align=\\"left\\" width=\\"100\\"><a href=\\"?go=pollarchiv&sort=voters_{order_voters}\\" style=\\"color: #000\\"><b>Teilnehmer {arrow_voters}</b></a></td>\r\n  <td align=\\"left\\" width=\\"70\\"><a href=\\"?go=pollarchiv&sort=startdate_{order_startdate}\\" style=\\"color: #000\\"><b>von {arrow_startdate}</b></a></td>\r\n  <td align=\\"left\\" width=\\"10\\"></td>\r\n  <td align=\\"left\\" width=\\"70\\"><a href=\\"?go=pollarchiv&sort=enddate_{order_enddate}\\" style=\\"color: #000\\"><b>bis {arrow_enddate}</b></a></td>\r\n</tr>\r\n{umfragen}\r\n</table>\r\n<p>', '  <tr>\r\n   <td align=\\"left\\"><a href=\\"{url}\\">{frage}</a></td>\r\n   <td align=\\"left\\">{voters}</td>\r\n   <td align=\\"left\\" class=\\"small\\">{start_datum}</td>\r\n   <td align=\\"left\\" class=\\"small\\">-</td>\r\n   <td align=\\"left\\" class=\\"small\\">{end_datum}</td>\r\n  </tr>', '<div class=\\"small\\" align=\\"center\\">\r\n    Zur Zeit keine<br>Umfrage aktiv\r\n</div>', '<b>PROFIL VON {username}</b><p>\r\n<table align="center" border="0" cellpadding="4" cellspacing="0">\r\n    <tr>\r\n        <td width="50%" valign="top">\r\n            <b>Benutzerbild:</b>\r\n        </td>\r\n        <td width="50%">\r\n            {avatar}\r\n        </td>\r\n    </tr>\r\n    <tr>\r\n        <td>\r\n            <b>E-Mail:</b>\r\n        </td>\r\n        <td>\r\n            {email}\r\n        </td>\r\n    </tr>\r\n    <tr>\r\n        <td>\r\n            <b>Registriert seit:</b>\r\n        </td>\r\n        <td>\r\n            {reg_datum}\r\n        </td>\r\n    </tr>\r\n    <tr>\r\n        <td>\r\n            <b>Geschriebene Kommentare:</b>\r\n        </td>\r\n        <td>\r\n            {kommentare}\r\n        </td>\r\n    </tr>\r\n    <tr>\r\n        <td>\r\n            <b>Geschriebene News:</b>\r\n        </td>\r\n        <td>\r\n            {news}\r\n        </td>\r\n    </tr>\r\n    <tr>\r\n        <td>\r\n            <b>Geschriebene Artikel:</b>\r\n        </td>\r\n        <td>\r\n            {artikel}\r\n        </td>\r\n    </tr>\r\n</table>', '- <b>{visits}</b> Visits<br>\r\n- <b>{visits_heute}</b> Visits heute<br>\r\n- <b>{hits}</b> Hits<br>\r\n- <b>{hits_heute}</b> Hits heute<br>\r\n- <b>{user_online}</b> Besucher online<p>\r\n- <b>{user}</b> registrierte User<br>\r\n- <b>{news}</b> News<br>\r\n- <b>{kommentare}</b> Kommentare<br>\r\n- <b>{artikel}</b> Artikel', '<script type="text/javascript"> \r\n<!-- \r\nfunction chkFormular() \r\n{\r\n    if((document.getElementById("username").value == "") ||\r\n       (document.getElementById("usermail").value == "") ||\r\n       (document.getElementById("userpass1").value == "") ||\r\n       (document.getElementById("userpass2").value == ""))\r\n    {\r\n        alert("Du hast nicht alle Felder ausgefüllt"); \r\n        return false;\r\n    }\r\n    if(document.getElementById("userpass1").value != document.getElementById("userpass2").value)\r\n    {\r\n        alert("Passwöter sind verschieden"); \r\n        return false;\r\n    }\r\n} \r\n//--> \r\n</script> \r\n\r\n<b>REGISTRIEREN</b><p>\r\n<div>\r\n    Registriere dich im Frog System, um in den Genuss erweiterter Features zu kommen. Dazu zählen bisher:\r\n    <ul>\r\n        <li>Zugriff auf unsere Downloads</li>\r\n        <li>Hochladen eines eigenen Benutzerbildes, für die von dir geschriebenen Kommentare</li>\r\n    </ul>\r\n    Weitere Features werden folgen.\r\n    <p>\r\n    <form action="" method="post" onSubmit="return chkFormular()">\r\n        <input type="hidden" value="register" name="go">\r\n        <table border="0" cellpadding="2" cellspacing="0" align="center">\r\n            <tr>\r\n                <td align="right">\r\n                    <b>Name:</b>\r\n                </td>\r\n                <td>\r\n                    <input class="text" size="30" name="username" id="username" maxlength="100">\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td align="right">\r\n                    <b>Passwort:</b>\r\n                </td>\r\n                <td>\r\n                    <input class="text" size="30" name="userpass1" id="userpass1" type="password" maxlength="16">\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td align="right">\r\n                    <b>Passwort wiederholen:</b>\r\n                </td>\r\n                <td>\r\n                    <input class="text" size="30" name="userpass2" id="userpass2" type="password" maxlength="16">\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td align="right">\r\n                    <b>E-Mail:</b>\r\n                </td>\r\n                <td>\r\n                    <input class="text" size="30" name="usermail" id="usermail" maxlength="100">\r\n                </td>\r\n            </tr>\r\n{antispam}\r\n            <tr>\r\n                <td colspan="2" align="center">\r\n                    <input type="submit" class="button" value="Registrieren">\r\n                </td>\r\n            </tr>\r\n        </table>\r\n    </form>\r\n    <p>\r\n</div>', '<div class="news_head" style="height:10px;" id ="{newsid}">\r\n    <span style="float:left;">\r\n        <img src="{kategorie_bildname}" alt=""><b>[{kategorie_name}] {titel}</b>\r\n    </span>\r\n    <span class="small" style="float:right;">\r\n        <b>{datum}</b>\r\n    </span>\r\n</div>\r\n<div style="padding:3px;">\r\n    {text}\r\n    {related_links}\r\n</div>\r\n<div class="news_footer">\r\n    <span class="small" style="float:left;">\r\n        <a class="small" href="{kommentar_url}">Kommentare ({kommentar_anzahl})</a>\r\n    </span>\r\n    <span class="small" style="float:right;">\r\n        geschrieben von: <a class="small" href="{autor_profilurl}">{autor}</a>\r\n    </span>\r\n</div>\r\n<br><br>', '<b>Ankündigung:</b>\r\n<br><br>\r\n    {meldung}\r\n<br><br>', 'Hallo {username}\r\n\r\nDu hast dich im Frog System registriert. Deine Logindaten sind:\r\nUsername: {username}\r\nPasswort: {passwort}', 'Hallo {username}\r\n\r\nDein Passwort im Frog System wurde geändert.\r\nDas neue Lautet: {passwort}', '<div align="center">\r\n  <a href="{url}" target="_blank">\r\n    <img src="{bild}" border="0" alt="{name}"  title="{name}">\r\n  </a>\r\n  <br>\r\n</div>', 'Partner:\r\n{partner}', '<div align="center">\r\n  <a href="{url}" target="_blank">\r\n    <img src="{bild}" border="0" alt="{name}"  title="{name}">\r\n  </a>\r\n  <br>\r\n</div>', '{permanents}\r\n\r\n<div align="center"><br><b>\r\nZufallsauswahl:</b><br>\r\n\r\n{non-permanents}\r\n\r\n<a href="?go=partner">alle Partner</a></div><br>', '<table cellpadding="5" align="center" border="0" width="90%">\r\n<tr><td><b><font face="verdana" size="2">Code:</font></b></td></tr>\r\n<tr><td style="border-collapse: collapse; border-style: dotted; border-color:#000000; border-width: 1"><font face="Courier New">{text}</font>\r\n</td></tr></table>', '<table cellpadding="5" align="center" border="0" width="90%">\r\n<tr><td><b><font face="verdana" size="2">Zitat:</font></b></td></tr>\r\n<tr><td style="border-collapse: collapse; border-style: dotted; border-color:#000000; border-width: 1">{text}\r\n</td></tr></table>', '<table cellpadding="5" align="center" border="0" width="90%">\r\n<tr><td><b><font face="verdana" size="2">Zitat von {author}:</font></b></td></tr>\r\n<tr><td style="border-collapse: collapse; border-style: dotted; border-color:#000000; border-width: 1">{text}\r\n</td></tr></table>', '<table cellpadding="0" cellspacing="0" border="0" style="padding-bottom:4px">\r\n  <tr valign="bottom">\r\n    {buttons}\r\n  </tr>\r\n</table>\r\n\r\n<table cellpadding="0" cellspacing="0" border="0">\r\n  <tr valign="top">\r\n    <td>\r\n      <textarea {style}>{text}</textarea>\r\n    </td>\r\n    <td style="width:4px; empty-cells:show;">\r\n    </td>\r\n    <td>\r\n      {smilies}\r\n    </td>\r\n  </tr>\r\n</table>\r\n<br />', '.editor_button {\r\n  font-size:8pt;\r\n  font-family:Verdana;\r\n  border:1px solid #000000;\r\n  background-color:#B7B7B7;\r\n  width:20px;\r\n  height:20px;\r\n  cursor:pointer;\r\n  text-align:center;\r\n}\r\n.editor_button:hover {\r\n  background-color:#A5E5A5;\r\n}\r\n.editor_td {\r\n  width:24px;\r\n  height:23px;\r\n  vertical-align:bottom;\r\n  text-align:left;\r\n}\r\n.editor_td_seperator {\r\n  width:5px;\r\n  height:23px;\r\n  background-image:url("images/icons/separator.gif");\r\n  background-repeat:no-repeat;\r\n  background-position:top left;\r\n}\r\n.editor_smilies {\r\n  cursor:pointer;\r\n  padding:0px;\r\n}', '<td class="editor_td">\r\n    <div class="editor_button" {javascript}>\r\n      <img src="{img_url}" alt="{alt}" title="{title}" />\r\n    </div>\r\n  </td>', '<td class="editor_td_seperator"></td>');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `fs_user`
-- 

DROP TABLE IF EXISTS `fs_user`;
CREATE TABLE `fs_user` (
  `user_id` mediumint(8) NOT NULL auto_increment,
  `user_name` char(100) collate latin1_general_ci default NULL,
  `user_password` char(32) collate latin1_general_ci default NULL,
  `user_mail` char(100) collate latin1_general_ci default NULL,
  `is_admin` tinyint(4) NOT NULL default '0',
  `reg_date` int(11) default NULL,
  `show_mail` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=7 ;

-- 
-- Daten für Tabelle `fs_user`
-- 

REPLACE INTO `fs_user` VALUES (1, 'Sweil', '4e65f3c20bc1f5a16bc62b7f4083e226', 'moritz@tolkien-fan.de', 1, 1215468000, 1);
REPLACE INTO `fs_user` VALUES (2, 'klick', '098f6bcd4621d373cade4e832627b4f6', 'e@mail.de', 1, 1157320800, 0);
REPLACE INTO `fs_user` VALUES (3, 'rockfest', '78a2794d1740863fef81b74bb91340b5', 'moritz@tolkien-fan.de', 1, 1156975994, 1);
REPLACE INTO `fs_user` VALUES (4, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@admin.de', 1, 1207260000, 0);
REPLACE INTO `fs_user` VALUES (5, 'hallo', '73c18c59a39b18382081ec00bb456d43', 'morits', 0, 1186523202, 0);
REPLACE INTO `fs_user` VALUES (6, 'ffgffg', '633de4b0c14ca52ea2432a3c8a5c4c31', 'ff', 0, 1186523903, 0);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `fs_userlist_config`
-- 

DROP TABLE IF EXISTS `fs_userlist_config`;
CREATE TABLE `fs_userlist_config` (
  `id` tinyint(1) NOT NULL,
  `user_per_page` tinyint(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- 
-- Daten für Tabelle `fs_userlist_config`
-- 

REPLACE INTO `fs_userlist_config` VALUES (1, 50);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `fs_useronline`
-- 

DROP TABLE IF EXISTS `fs_useronline`;
CREATE TABLE `fs_useronline` (
  `ip` varchar(30) collate latin1_general_ci default NULL,
  `host` varchar(200) collate latin1_general_ci default NULL,
  `date` int(30) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- 
-- Daten für Tabelle `fs_useronline`
-- 

REPLACE INTO `fs_useronline` VALUES ('127.0.0.1', NULL, 1187126374);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `fs_wallpaper`
-- 

DROP TABLE IF EXISTS `fs_wallpaper`;
CREATE TABLE `fs_wallpaper` (
  `wallpaper_id` mediumint(8) NOT NULL auto_increment,
  `wallpaper_name` varchar(255) collate latin1_general_ci NOT NULL default '',
  `wallpaper_title` varchar(255) collate latin1_general_ci NOT NULL default '',
  `cat_id` mediumint(8) NOT NULL default '0',
  PRIMARY KEY  (`wallpaper_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci PACK_KEYS=1 AUTO_INCREMENT=2 ;

-- 
-- Daten für Tabelle `fs_wallpaper`
-- 

REPLACE INTO `fs_wallpaper` VALUES (1, 'test', 'haha', 4);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `fs_wallpaper_sizes`
-- 

DROP TABLE IF EXISTS `fs_wallpaper_sizes`;
CREATE TABLE `fs_wallpaper_sizes` (
  `size_id` mediumint(8) NOT NULL auto_increment,
  `wallpaper_id` mediumint(8) NOT NULL default '0',
  `size` varchar(255) collate latin1_general_ci NOT NULL default '',
  PRIMARY KEY  (`size_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci PACK_KEYS=1 AUTO_INCREMENT=2 ;

-- 
-- Daten für Tabelle `fs_wallpaper_sizes`
-- 

REPLACE INTO `fs_wallpaper_sizes` VALUES (1, 1, '800x600');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `fs_zones`
-- 

DROP TABLE IF EXISTS `fs_zones`;
CREATE TABLE `fs_zones` (
  `id` mediumint(8) NOT NULL auto_increment,
  `name` varchar(30) collate latin1_general_ci NOT NULL,
  `design_id` mediumint(8) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci PACK_KEYS=0 AUTO_INCREMENT=1 ;

-- 
-- Daten für Tabelle `fs_zones`
-- 

