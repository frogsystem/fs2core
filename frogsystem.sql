-- phpMyAdmin SQL Dump
-- version 2.10.0.2
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Jun 26, 2007 at 05:53 PM
-- Server version: 5.0.37
-- PHP Version: 5.2.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Database: `frogsystem`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `fs_admin_cp`
-- 

DROP TABLE IF EXISTS `fs_admin_cp`;
CREATE TABLE IF NOT EXISTS `fs_admin_cp` (
  `id` mediumint(8) NOT NULL auto_increment,
  `page_call` varchar(255) collate latin1_general_ci NOT NULL default '',
  `page_title` varchar(255) collate latin1_general_ci NOT NULL default '',
  `link_title` varchar(255) collate latin1_general_ci NOT NULL default '',
  `permission` varchar(255) collate latin1_general_ci NOT NULL default '',
  `file` varchar(255) collate latin1_general_ci NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=67 ;

-- 
-- Dumping data for table `fs_admin_cp`
-- 

REPLACE INTO `fs_admin_cp` (`id`, `page_call`, `page_title`, `link_title`, `permission`, `file`) VALUES 
(1, 'allconfig', 'KONFIGURATION', 'Konfiguration', 'perm_allconfig', 'admin_allconfig.php'),
(2, 'allannouncement', 'ANKÜNDIGUNG', 'Ankündigung', 'perm_allannouncement', 'admin_allannouncement.php'),
(3, 'allphpinfo', 'PHP INFO', 'PHP Info', 'perm_allphpinfo', 'admin_allphpinfo.php'),
(4, 'newsadd', 'NEWS HINZUFÜGEN', 'schreiben', 'perm_newsadd', 'admin_newsadd.php'),
(5, 'newsedit', 'NEWS ARCHIV', 'Archiv / editieren', 'perm_newsedit', 'admin_newsedit.php'),
(6, 'commentedit', 'KOMMENTAR EDITIEREN', '', 'perm_newsedit', 'admin_commentedit.php'),
(7, 'news_cat_manage', 'KATEGORIE VERWALTEN', 'Kategorien verwalten', 'perm_newscat', 'admin_news_cat_manage.php'),
(8, 'news_cat_create', 'KATEGORIE HINZUFÜGEN', 'Kategorie hinzufügen', 'perm_newsnewcat', 'admin_news_cat_create.php'),
(9, 'newsconfig', 'NEWS KONFIGURATION', 'Konfiguration', 'perm_newsconfig', 'admin_newsconfig.php'),
(10, 'dladd', 'DOWNLOAD HINZUFÜGEN', 'hinzufügen', 'perm_dladd', 'admin_dladd.php'),
(11, 'dledit', 'DOWNLOAD BEARBEITEN', 'bearbeiten', 'perm_dledit', 'admin_dledit.php'),
(12, 'dlcat', 'DOWNLOAD KATEGORIEN', 'Kategorien', 'perm_dlcat', 'admin_dlcat.php'),
(13, 'dlnewcat', 'DOWNLOAD KATEGORIE HINZUFÜGEN', 'Neue Kategorie', 'perm_dlnewcat', 'admin_dlnewcat.php'),
(14, 'dlconfig', 'DOWNLOAD KONFIGURATION', 'Konfiguration', 'perm_dladd', 'admin_dlconfig.php'),
(15, 'polladd', 'UMFRAGE HINZUFÜGEN', 'hinzufügen', 'perm_polladd', 'admin_polladd.php'),
(16, 'polledit', 'UMFRAGEN ARCHIV', 'Archiv / editieren', 'perm_polledit', 'admin_polledit.php'),
(17, 'randompic_cat', 'ZUFALLSBILD KATEGORIE AUSWAHL', 'Kategorie Auswahl', 'perm_potmadd', 'admin_randompic_cat.php'),
(18, 'potmedit', 'POTM ÜBERSICHT', '', 'perm_potmedit', 'admin_potmedit.php'),
(19, 'screenadd', 'SCREENSHOT HINZUFÜGEN', 'Bild hinzufügen', 'perm_screenadd', 'admin_screenadd.php'),
(20, 'screenedit', 'SCREENSHOT ÜBERSICHT', 'Übersicht', 'perm_screenedit', 'admin_screenedit.php'),
(21, 'screencat', 'GALERIE KATEGORIEN', 'Kategorien verwalten', 'perm_screencat', 'admin_screencat.php'),
(22, 'screennewcat', 'GALERIE KATEGORIE HINZUFÜGEN', 'Kategorie hinzufügen', 'perm_screennewcat', 'admin_screennewcat.php'),
(23, 'screenconfig', 'SCREENSHOT KONFIGURATION', 'Konfiguration', 'perm_screenconfig', 'admin_screenconfig.php'),
(24, 'wallpaperadd', 'WALLPAPER HINZUFÜGEN', 'Wallpaper hinzufügen', 'perm_screenadd', 'admin_wallpaperadd.php'),
(25, 'wallpaperedit', 'WALLPAPER BEARBEITEN', 'Wallpaper bearbeiten', 'perm_screenedit', 'admin_wallpaperedit.php'),
(26, 'shopadd', 'ARTIKEL HINZUFÜGEN', 'Artikel hinzufügen', 'perm_shopadd', 'admin_shopadd.php'),
(27, 'shopedit', 'ARTIKEL ÜBERSICHT', 'Übersicht', 'perm_shopedit', 'admin_shopedit.php'),
(28, 'map', 'COMMUNITY MAP BEARBEITEN', '', 'perm_map', 'admin_map.php'),
(29, 'statview', 'STATISTIK ANZEIGEN', 'anzeigen', 'perm_statview', 'admin_statview.php'),
(30, 'statedit', 'STATISTIK BEARBEITEN', 'bearbeiten', 'perm_statedit', 'admin_statedit.php'),
(31, 'statref', 'REFERRER ANZEIGEN', 'referrer', 'perm_statref', 'admin_statref.php'),
(32, 'statspace', 'SPEICHERPLATZ STATISTIK', 'Speicherplatz', 'perm_statspace', 'admin_statspace.php'),
(33, 'useradd', 'USER HINZUFÜGEN', 'hinzufügen', 'perm_useradd', 'admin_useradd.php'),
(34, 'useredit', 'USER BEARBEITEN', 'bearbeiten', 'perm_useredit', 'admin_useredit.php'),
(35, 'userrights', 'USER RECHTE', 'Rechte', 'perm_userrights', 'admin_userrights.php'),
(36, 'artikeladd', 'ARTIKEL SCHREIBEN', 'schreiben', 'perm_artikeladd', 'admin_artikeladd.php'),
(37, 'artikeledit', 'ARTIKEL BEARBEITEN', 'editieren', 'perm_artikeledit', 'admin_artikeledit.php'),
(38, 'cimgadd', 'BILDER HOCHLADEN', 'Bilder hochladen', 'perm_artikeladd', 'admin_cimg.php'),
(39, 'cimgdel', 'BILDER LÖSCHEN', 'Bilder löschen', 'perm_artikeledit', 'admin_cimgdel.php'),
(40, 'artikeltemplate', 'ARTIKEL TEMPLATE BEARBEITEN', 'Template', 'perm_templateedit', 'admin_template_artikel.php'),
(41, 'polltemplate', 'UMFRAGEN TEMPLATE BEARBEITEN', 'Template', 'perm_templateedit', 'admin_template_poll.php'),
(42, 'randompictemplate', 'ZUFALLSBILD TEMPLATE BEARBEITEN', 'Template', 'perm_templateedit', 'admin_template_randompic.php'),
(43, 'shoptemplate', 'SHOP TEMPLATE BEARBEITEN', 'Template', 'perm_templateedit', 'admin_template_shop.php'),
(44, 'newstemplate', 'NEWS TEMPLATE BEARBEITEN', 'Template', 'perm_templateedit', 'admin_template_news.php'),
(45, 'alltemplate', 'ALLGEMEINE TEMPLATES BEARBEITEN', 'Template', 'perm_templateedit', 'admin_template_all.php'),
(46, 'dltemplate', 'DOWNLOAD TEMPLATE BEARBEITEN', 'Template', 'perm_templateedit', 'admin_template_dl.php'),
(47, 'screenshottemplate', 'SCREENSHOT TEMPLATE BEARBEITEN', 'Template', 'perm_templateedit', 'admin_template_screenshot.php'),
(48, 'usertemplate', 'USER TEMPLATE BEARBEITEN', 'Template', 'perm_templateedit', 'admin_template_user.php'),
(49, 'csstemplate', 'CSS DATEI BEARBEITEN', 'CSS', 'perm_templateedit', 'admin_template_css.php'),
(50, 'template_manage', 'DESIGNS VERWALTEN', 'verwalten', 'perm_templateedit', 'admin_template_manage.php'),
(51, 'template_create', 'DESIGN ERSTELLEN', 'erstellen', 'perm_templateedit', 'admin_template_create.php'),
(52, 'emailtemplate', 'E-MAILS BEARBEITEN', 'E-Mails', 'perm_templateedit', 'admin_template_email.php'),
(53, 'profil', 'PROFIL BEARBEITEN', 'bearbeiten', '1', 'admin_profil.php'),
(54, 'partneradd', 'PARTNER HINZUFÜGEN', 'Partnerseite hinzufügen', 'perm_partneradd', 'admin_partneradd.php'),
(55, 'partneredit', 'PARTNER EDITIEREN', 'Partnerseite editieren', 'perm_partneredit', 'admin_partneredit.php'),
(56, 'partnerconfig', 'PARTNERSEITEN EINSTELLUNGEN', 'Konfiguration', 'perm_partneredit', 'admin_partnerconfig.php'),
(57, 'partnertemplate', 'PARTNER TEMPLATE BEARBEITEN', 'Template', 'perm_templateedit', 'admin_template_partner.php'),
(58, 'includes_new', 'INCLUDE HINZUFÜGEN', 'hinzufügen', 'perm_allconfig', 'admin_includes_new.php'),
(59, 'includes_edit', 'INCLUDES BEARBEITEN', 'Übersicht (bearbeiten)', 'perm_allconfig', 'admin_includes_edit.php'),
(60, 'zone_create', 'ZONE ERSTELLEN', 'erstellen', 'perm_templateedit', 'admin_zone_create.php'),
(61, 'zone_manage', 'ZONEN VERWALTEN', 'verwalten', 'perm_templateedit', 'admin_zone_manage.php'),
(62, 'zone_config', 'ZONEN EINSTELLUNGEN', 'Konfiguration', 'perm_templateedit', 'admin_zone_config.php'),
(63, 'press_add', 'PRESSEVERÖFFENTLICHUNG EINTRAGEN', 'eintragen', '1', 'admin_press_add.php'),
(64, 'press_edit', 'PRESSEVERÖFFENTLICHUNG EDITIEREN', 'bearbeiten', '1', 'admin_press_edit.php'),
(65, 'randompic_time', 'ZUFALLSBILD ZEITGESTEUERTE AUSWAHL', 'Zeitgest. &Uuml;bersicht', 'perm_potmadd', 'admin_randompic_time.php'),
(66, 'randompic_time_add', 'ZEITGESTEUERTES ZUFALLSBILD HINZUF&Uuml;GEN', 'Neues zeitgest. Zufallsb.', 'perm_potmadd', 'admin_randompic_time_add.php');

-- --------------------------------------------------------

-- 
-- Table structure for table `fs_announcement`
-- 

DROP TABLE IF EXISTS `fs_announcement`;
CREATE TABLE IF NOT EXISTS `fs_announcement` (
  `text` text collate latin1_general_ci
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- 
-- Dumping data for table `fs_announcement`
-- 

REPLACE INTO `fs_announcement` (`text`) VALUES 
('hö3');

-- --------------------------------------------------------

-- 
-- Table structure for table `fs_artikel`
-- 

DROP TABLE IF EXISTS `fs_artikel`;
CREATE TABLE IF NOT EXISTS `fs_artikel` (
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
-- Dumping data for table `fs_artikel`
-- 

REPLACE INTO `fs_artikel` (`artikel_url`, `artikel_title`, `artikel_date`, `artikel_user`, `artikel_text`, `artikel_index`, `artikel_fscode`) VALUES 
('lorem_ipsum', 'Lorem Ipsum', 1157493600, '1', 'Lorem ipsum sint mandamus id vix, mel eu meliore assentior, sit eu mutat repudiandae. Mnesarchum neglegentur pro eu, ut inermis scaevola incorrupte vis, et omnis ubique pri. Eu ius oporteat periculis, ut stet dicta tation sed. Pro ut omnium deserunt adolescens, cum suas mundi an, eu modo dolores senserit sit. Vel no nibh honestatis, eum et dicta erant dictas.\r\n\r\nEtiam doctus ei vix, vix te alii expetendis. Usu ne novum lobortis mandamus, diceret periculis ad est. Pro an dicta latine, ex laoreet vituperatoribus quando vis, quo in nemore sanctus laoreet. Ut pericula argumentum usu. Ne duo assum populo. Nec deserunt perpetua euripidis eu, ne quo zzril postea instructior, an his putant aeterno.\r\n\r\nEi vel timeam contentiones intellegebat, decore dicta vituperatoribus eu quo, atqui ceteros his an. Has id libris hendrerit, vix semper labores nonummy no. In sit vidisse moderatius. Fugit posidonium ne qui, ex has liber volutpat. Duo maluisset delicatissimi id, nihil fastidii perpetua ei vix. Qui ei audire delenit, ea habeo commodo molestiae sea, his eu graeci noluisse lobortis.', 1, 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `fs_cmap_user`
-- 

DROP TABLE IF EXISTS `fs_cmap_user`;
CREATE TABLE IF NOT EXISTS `fs_cmap_user` (
  `user_id` mediumint(8) NOT NULL auto_increment,
  `land_id` tinyint(2) default NULL,
  `user_name` char(100) collate latin1_general_ci default NULL,
  `x_pos` smallint(5) default NULL,
  `y_pos` smallint(5) default NULL,
  `user_ort` char(100) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `fs_cmap_user`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `fs_counter`
-- 

DROP TABLE IF EXISTS `fs_counter`;
CREATE TABLE IF NOT EXISTS `fs_counter` (
  `visits` int(11) unsigned NOT NULL default '0',
  `hits` int(11) unsigned NOT NULL default '0',
  `user` mediumint(8) unsigned NOT NULL default '0',
  `artikel` smallint(6) unsigned NOT NULL default '0',
  `news` smallint(6) unsigned NOT NULL default '0',
  `comments` mediumint(8) unsigned NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- 
-- Dumping data for table `fs_counter`
-- 

REPLACE INTO `fs_counter` (`visits`, `hits`, `user`, `artikel`, `news`, `comments`) VALUES 
(54, 8083, 3, 1, 2, 16);

-- --------------------------------------------------------

-- 
-- Table structure for table `fs_counter_ref`
-- 

DROP TABLE IF EXISTS `fs_counter_ref`;
CREATE TABLE IF NOT EXISTS `fs_counter_ref` (
  `ref_url` char(255) collate latin1_general_ci default NULL,
  `ref_count` int(11) default NULL,
  `ref_date` int(11) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- 
-- Dumping data for table `fs_counter_ref`
-- 

REPLACE INTO `fs_counter_ref` (`ref_url`, `ref_count`, `ref_date`) VALUES 
('http://localhost/frogsystem/www/admin/', 103, 1156976125),
('http://localhost/frogsystem/www/admin/index.php?go=allconfig', 175, 1156977187),
('http://localhost/frogsystem/www/admin/index.php', 1668, 1156977293),
('http://localhost/frogsystem/www/admin/index.php?go=allanouncement', 76, 1156977514),
('http://localhost/frogsystem/www/admin/index.php?go=allphpinfo', 35, 1156977515),
('http://localhost/frogsystem/www/admin/index.php?go=newsadd', 80, 1156977517),
('http://localhost/frogsystem/www/admin/index.php?go=artikeladd', 100, 1156977518),
('http://localhost/frogsystem/www/admin/index.php?go=dladd', 32, 1156977519),
('http://localhost/frogsystem/www/admin/index.php?go=dledit', 21, 1156977519),
('http://localhost/frogsystem/www/admin/index.php?go=csstemplate', 80, 1156977715),
('http://localhost/frogsystem/www/admin/index.php?go=alltemplate', 220, 1156983165),
('http://localhost/frogsystem/www/admin/index.php?go=dlnewcat', 16, 1156983174),
('http://localhost/frogsystem/www/admin/index.php?go=newscat', 7, 1156983175),
('http://localhost/frogsystem/www/admin/index.php?go=newsnewcat', 4, 1156983182),
('http://localhost/frogsystem/www/admin/index.php?go=dlcat', 22, 1156983187),
('http://localhost/frogsystem/www/admin/index.php?go=newsconfig', 37, 1156983191),
('http://localhost/frogsystem/www/admin/index.php?go=newsedit', 50, 1156983196),
('http://localhost/frogsystem/www/admin/index.php?go=news_cat_create', 50, 1156984857),
('http://localhost/frogsystem/www/admin/index.php?go=news_cat_manage', 135, 1156984861),
('http://localhost/frogsystem/', 40, 1157243034),
('http://localhost/frogsystem/www/admin/admin_finduser.php', 35, 1157319909),
('http://localhost/frogsystem/www/admin/index.php?go=useradd', 4, 1157325559),
('http://localhost/frogsystem/www/admin/index.php?go=useredit', 16, 1157325568),
('http://localhost/frogsystem/www/', 107, 1157325614),
('http://localhost/frogsystem/www/admin/index.php?go=statview', 6, 1157325926),
('http://localhost/frogsystem/www/admin/index.php?go=statedit', 5, 1157325944),
('http://localhost/frogsystem/www/admin/index.php?go=map&landid=1', 9, 1157325958),
('http://localhost/frogsystem/www/admin/index.php?go=map&landid=2', 5, 1157325959),
('http://localhost/frogsystem/www/admin/index.php?go=map&landid=3', 4, 1157325962),
('http://localhost/frogsystem/www/admin/index.php?go=screenadd', 14, 1157326805),
('http://localhost/frogsystem/www/admin/index.php?go=template_create', 80, 1157410727),
('http://localhost/frogsystem/www/admin/index.php?go=template_manage', 76, 1157410727),
('http://localhost/frogsystem/www/admin/index.php?go=emailtemplate', 21, 1157421671),
('http://localhost/frogsystem/www/admin/index.php?go=artikeledit', 40, 1157462773),
('http://localhost/frogsystem/www/admin/index.php?go=cimgadd', 33, 1157463048),
('http://localhost/frogsystem/www/admin/index.php?go=cimgdel', 131, 1157463050),
('http://localhost/frogsystem/www/admin/index.php?go=cimgdel&unlink=kraftwelle.jpg', 1, 1157464359),
('http://localhost/frogsystem/www/admin/index.php?go=cimgdel&unlink=kraftwelle_s.jpg', 1, 1157465528),
('http://localhost/frogsystem/www/admin/index.php?go=cimgdel&unlink=karte.jpg', 2, 1157465774),
('http://localhost/frogsystem/www/admin/index.php?go=cimgdel&unlink=karte2.jpg', 2, 1157465797),
('http://localhost/frogsystem/www/admin/index.php?go=cimgdel&unlink=karte2_s.jpg', 1, 1157465828),
('http://localhost/frogsystem/www/admin/index.php?go=cimgdel&unlink=karte_s.jpg', 1, 1157465832),
('http://localhost/frogsystem/www/admin/index.php?go=cimgdel&unlink=Neu%20Textdokument.txt', 2, 1157468782),
('http://localhost/frogsystem/www/admin/index.php?go=cimgdel&unlink=zblubb.jpg', 1, 1157469907),
('http://localhost/frogsystem/www/admin/index.php?go=cimgdel&unlink=lbubb.jpg', 1, 1157469909),
('http://localhost/frogsystem/www/admin/index.php?go=cimgdel&unlink=aads.jpg', 1, 1157470082),
('http://localhost/frogsystem/www/admin/index.php?go=cimgdel&unlink=m%F6p.jpg', 1, 1157470121),
('http://localhost/frogsystem/www/admin/index.php?go=cimgdel&unlink=aasasdasd.jpg', 1, 1157470279),
('http://localhost/frogsystem/www/admin/index.php?go=polladd', 40, 1157540226),
('http://localhost/frogsystem/www/admin/admin_artikelprev.php', 4, 1157541892),
('http://localhost/frogsystem/www/admin/index.php?go=cimgdel&unlink=sd.jpg', 1, 1157551098),
('http://localhost/frogsystem/www/admin/index.php?go=cimgdel&unlink=hintergrund.gif', 3, 1157551251),
('http://localhost/frogsystem/www/admin/index.php?go=cimgdel&unlink=impressum.gif', 1, 1157551391),
('http://localhost/frogsystem/www/admin/index.php?go=cimgdel&unlink=infos.gif', 1, 1157551397),
('http://localhost/frogsystem/www/admin/index.php?go=cimgdel&unlink=kommentare.gif', 1, 1157551403),
('http://localhost/frogsystem/www/admin/index.php?go=cimgdel&unlink=links.gif', 1, 1157551721),
('http://localhost/frogsystem/www/admin/index.php?go=cimgdel&unlink=logo.gif', 1, 1157551857),
('http://localhost/frogsystem/www/admin/index.php?go=cimgdel&unlink=menu_l_all.jpg', 2, 1157551873),
('http://localhost/frogsystem/www/admin/index.php?go=cimgdel&unlink=menu_l_bottom.gif', 1, 1157551976),
('http://localhost/frogsystem/www/admin/index.php?go=cimgdel&unlink=menu_l_top1.jpg', 2, 1157551981),
('http://localhost/frogsystem/www/admin/index.php?go=cimgdel&unlink=menu_l_top2-hov.jpg', 1, 1157552011),
('http://localhost/frogsystem/www/admin/index.php?go=cimgdel&unlink=menu_l_top2.jpg', 1, 1157552105),
('http://localhost/frogsystem/www/admin/index.php?go=cimgdel&unlink=menu_l_top3.jpg', 1, 1157552201),
('http://localhost/frogsystem/www/admin/index.php?go=cimgdel&unlink=menu_l_top4.jpg', 1, 1157552229),
('http://localhost/frogsystem/www/admin/index.php?go=cimgdel&unlink=menu_l_top5.jpg', 2, 1157552322),
('http://localhost/frogsystem/www/admin/index.php?go=cimgdel&unlink=menu_l_top6.jpg', 1, 1157552328),
('http://localhost/frogsystem/www/admin/index.php?go=cimgdel&unlink=menu_l_top7.jpg', 1, 1157552833),
('http://localhost/frogsystem/www/admin/index.php?go=cimgdel&unlink=artworks.gif', 1, 1157552872),
('http://localhost/frogsystem/www/admin/index.php?go=cimgdel&unlink=bg.jpg', 1, 1157553016),
('http://localhost/frogsystem/www/admin/index.php?go=cimgdel&unlink=downloads.gif', 1, 1157553149),
('http://localhost/frogsystem/www/admin/index.php?go=cimgdel&unlink=ecke_r.jpg', 1, 1157553219),
('http://localhost/frogsystem/www/admin/index.php?go=cimgdel&unlink=ee.jpg', 1, 1157553390),
('http://localhost/frogsystem/www/admin/index.php?go=cimgdel&unlink=features.gif', 1, 1157553392),
('http://localhost/frogsystem/www/admin/index.php?go=cimgdel&unlink=ecke_l.jpg', 1, 1157553395),
('http://localhost/frogsystem/www/admin/index.php?go=cimgdel&unlink=fakten.gif', 1, 1157553397),
('http://localhost/frogsystem/www/?design=1', 4, 1157562684),
('http://localhost/frogsystem/www/admin/index.php?go=dltemplate', 25, 1157564757),
('http://localhost/frogsystem/www/?design=0', 1, 1157565070),
('http://localhost/frogsystem/www/?go=newsarchiv', 36, 1157565071),
('http://localhost/frogsystem/www/?go=pollarchiv', 20, 1157565071),
('http://localhost/frogsystem/www/?go=shop', 11, 1157565072),
('http://localhost/frogsystem/www/?go=screenshots', 23, 1157565073),
('http://localhost/frogsystem/www/?go=map', 12, 1157565073),
('http://localhost/frogsystem/www/?go=download', 63, 1157565076),
('http://localhost/frogsystem/www/?go=news', 282, 1157565080),
('http://localhost/frogsystem/www/?go=comments&id=6', 15, 1157572613),
('http://localhost/frogsystem/www/?go=editprofil', 6, 1157572643),
('http://localhost/frogsystem/www/?go=pollarchiv&pollid=1', 1, 1157573147),
('http://localhost/frogsystem/www/?go=download&catid=2', 41, 1157573344),
('http://localhost/frogsystem/www/admin/index.php?go=screenconfig', 23, 1157839786),
('http://localhost/frogsystem/www/admin/index.php?go=dlconfig', 31, 1157839950),
('http://localhost/frogsystem/www/?go=dlfile&fileid=1', 23, 1157841855),
('http://localhost/frogsystem/www/?go=download&catid=0', 3, 1157844078),
('http://localhost/frogsystem/www/?go=download&keyword=tes', 3, 1157844079),
('http://localhost/frogsystem/www/?go=download&keyword=sdsdsd', 1, 1157844094),
('http://localhost/frogsystem/www/?go=logout', 7, 1158258823),
('http://localhost/frogsystem/www/?go=map&design=1', 3, 1159364015),
('http://localhost/frogsystem/www/?go=news&design=1', 5, 1159364082),
('http://localhost/frogsystem/www/admin/index.php?go=polltemplate', 40, 1159365371),
('http://localhost/frogsystem/www/admin/index.php?go=polledit', 20, 1159365528),
('http://localhost/frogsystem/www/admin/index.php?go=newstemplate', 7, 1159372197),
('http://localhost/frogsystem/www/admin/index.php?go=cimgdel&unlink=ssd.gif', 1, 1159376742),
('http://localhost/frogsystem/www/admin/index.php?go=screenedit', 28, 1159376877),
('http://localhost/frogsystem/www/admin/index.php?go=screennewcat', 42, 1159376882),
('http://localhost/frogsystem/www/admin/index.php?go=screencat', 48, 1159376928),
('http://localhost/frogsystem/www/admin/index.php?go=statview&PHPSESSID=&s_year=2006&s_month=9', 4, 1160258599),
('http://localhost/frogsystem/www/admin/index.php?go=statview&PHPSESSID=&s_year=2006&s_month=10', 2, 1160258601),
('http://localhost/frogsystem/www/admin/index.php?go=potmadd', 11, 1160258704),
('http://localhost/frogsystem/www/admin/index.php?go=potmedit', 1, 1160258833),
('http://localhost/frogsystem/www/admin/index.php?go=randompic_cat', 10, 1160259916),
('http://projectgw.pr.funpic.de/', 3, 1160298304),
('http://localhost/frogsystem/www/?go=screenshots&catid=7', 4, 1160779960),
('http://localhost/frogsystem/www/?go=screenshots&catid=6', 1, 1160779964),
('http://localhost/frogsystem/www/admin/index.php?go=wallpaperadd', 46, 1160820408),
('http://localhost/frogsystem/www/admin/index.php?go=wallpaperedit', 53, 1160829357),
('http://localhost/frogsystem/www/admin/index.php?go=statref', 4, 1160835558),
('http://localhost/frogsystem/www/admin/index.php?go=statspace', 1, 1160835576),
('http://localhost/frogsystem/www/admin/index.php?go=shopadd', 7, 1161506718),
('http://localhost/frogsystem/www/admin/index.php?go=shopedit', 5, 1161506722),
('http://localhost/frogsystem/www/admin/index.php?go=artikeltemplate', 4, 1161973154),
('http://localhost/frogsystem/www/admin/index.php?go=screenshottemplate', 2, 1161973162),
('http://localhost/frogsystem/www/admin/index.php?go=potmtemplate', 2, 1161973172),
('http://localhost/frogsystem/www/admin/index.php?go=randompictemplate', 5, 1161973272),
('http://localhost/frogsystem/www/admin/index.php?go=usertemplate', 4, 1161973322),
('http://localhost/frogsystem/www/admin/index.php?go=profil', 24, 1161973531),
('http://localhost/frogsystem/www/admin/index.php?go=shoptemplate', 4, 1161976761),
('http://localhost/frogsystem/www/admin/index.php?go=userrights', 3, 1161977848),
('http://localhost/frogsystem/www/admin/index.php?go=partneradd', 12, 1162468650),
('http://localhost/frogsystem/www/admin/index.php?go=partneredit', 20, 1162468655),
('http://localhost/frogsystem/www/admin/index.php?go=partnerconfig', 12, 1162468660),
('http://localhost/frogsystem/www/admin/index.php?go=partnertemplate', 24, 1162468736),
('http://localhost/frogsystem/www/?go=partner', 12, 1162477531),
('http://localhost/frogsystem/www/admin/index.php?go=includes_edit', 62, 1162824535),
('http://localhost/frogsystem/www/admin/index.php?go=includes_new', 47, 1162826317),
('http://localhost/frogsystem/www/admin/?go=allconfig', 13, 1165325938),
('http://localhost/frogsystem/www/admin/?go=allphpinfo', 7, 1165325960),
('http://localhost/frogsystem/www/admin/?go=alltemplate', 5, 1165325988),
('http://localhost/frogsystem/www/admin/?go=allannouncement', 25, 1165326014),
('http://localhost/frogsystem/www/admin/index.php?go=allannouncement', 18, 1165326040),
('http://localhost/frogsystem/www/admin/?go=includes_edit', 15, 1166460593),
('http://localhost/frogsystem/www/admin/?go=includes_new', 19, 1166462395),
('http://localhost/frogsystem/www/admin/?go=polladd', 3, 1166462407),
('http://localhost/frogsystem/www/admin/?go=polledit', 1, 1166462435),
('http://localhost/frogsystem/www/admin/?go=usertemplate', 3, 1169900932),
('http://localhost/frogsystem/www/?go=pollarchiv&pollid=4', 5, 1169904420),
('http://localhost/www/', 17, 1169930753),
('http://localhost/www/admin/', 22, 1169933267),
('http://localhost/www/?go=news', 19, 1169933847),
('http://localhost/www/?go=newsarchiv', 2, 1169947079),
('http://localhost/www/?go=pollarchiv', 29, 1169947080),
('http://localhost/www/?go=members', 4, 1169951505),
('http://localhost/www/?go=comments&id=6', 23, 1169952937),
('http://localhost/www/?go=map', 1, 1169955003),
('http://localhost/www/?go=screenshots', 1, 1169955005),
('http://localhost/www/?go=screenshots&catid=7', 1, 1169955013),
('http://localhost/www/?go=comments&id=5', 1, 1169955109),
('http://localhost/www/?go=editprofil', 2, 1169993165),
('http://localhost/www//admin/', 6, 1169993178),
('http://localhost/www//admin/?go=allconfig', 2, 1169993377),
('http://localhost/www/?go=profil&userid=1', 2, 1170010945),
('http://localhost/www//admin/?go=includes_edit', 1, 1170013364),
('http://localhost/www//admin/?go=includes_new', 1, 1170013368),
('http://localhost/www//admin/?go=emailtemplate', 5, 1170013370),
('http://localhost/www//admin/?go=allphpinfo', 1, 1170013386),
('http://localhost/www//admin/?go=allannouncement', 1, 1170013388),
('http://localhost/www//admin/?go=alltemplate', 18, 1170013396),
('http://localhost/www//admin/?go=template_create', 2, 1170013481),
('http://localhost/www//admin/?go=template_manage', 1, 1170013485),
('http://localhost/www//admin/?go=artikeltemplate', 1, 1170013577),
('http://localhost/www//admin/?go=polltemplate', 15, 1170013580),
('http://localhost/www/admin/?go=allconfig', 7, 1170087701),
('http://localhost/www/admin/?go=allannouncement', 8, 1170087703),
('http://localhost/www/admin/?go=allphpinfo', 2, 1170087707),
('http://localhost/www/admin/?go=admin_ajax.php', 1, 1170093175),
('http://localhost/www/admin/?go=includes_edit', 1, 1170093336),
('http://127.0.0.1/www/admin/', 7, 1170093648),
('http://127.0.0.1/www/admin/?go=allannouncement', 3, 1170111423),
('http://127.0.0.1/www/admin/#', 19, 1170111606),
('http://127.0.0.1/www/admin/?go=allconfig', 2, 1170112445),
('http://127.0.0.1/www/admin/?go=allphpinfo', 1, 1170112447),
('http://127.0.0.1/www/admin/?go=randompic_cat', 8, 1170112590),
('http://127.0.0.1/www/admin/?go=screennewcat', 2, 1170112594),
('http://127.0.0.1/www/admin/?go=screencat', 5, 1170112625),
('http://127.0.0.1/www/admin/?go=randompictemplate', 2, 1170112679),
('http://127.0.0.1/www/', 25, 1170157883),
('http://localhost/www/admin/?go=polltemplate', 39, 1170158013),
('http://localhost/www/admin/?go=dltemplate', 1, 1170160917),
('http://localhost/www/?go=pollarchiv&orderby=name', 7, 1170161735),
('http://localhost/www/?go=pollarchiv&orderby=voters', 2, 1170161738),
('http://localhost/www/?go=pollarchiv&orderby=date', 2, 1170161739),
('http://localhost/www/?go=pollarchiv&orderby=name_desc', 2, 1170267159),
('http://localhost/www/?go=pollarchiv&orderby=name_asc', 1, 1170267164),
('http://localhost/www/?go=pollarchiv&orderby=voters_desc', 2, 1170267168),
('http://localhost/www/?go=pollarchiv&orderby=voters_asc', 1, 1170267176),
('http://localhost/www/?go=pollarchiv&orderby=date_desc', 1, 1170267186),
('http://localhost/www//admin/?go=dltemplate', 3, 1170280667),
('http://localhost/frogsystem/www/admin/index.php?go=zone_create', 22, 1172074097),
('http://localhost/frogsystem/www/admin/index.php?go=zone_manage', 4, 1172074098),
('http://localhost/frogsystem/www/admin/index.php?go=zone_config', 8, 1172074099),
('http://localhost/frogsystem/www/admin/?go=zone_create', 10, 1172085991),
('http://localhost/frogsystem/www/admin/?go=polltemplate', 1, 1174573451),
('http://localhost/frogsystem/www/admin/?go=template_create', 17, 1174577109),
('http://localhost/frogsystem/www/admin/?go=zone_manage', 8, 1174577123),
('http://localhost/frogsystem/www/admin/?go=artikeladd', 3, 1174603165),
('http://localhost/frogsystem/www/admin/?go=newstemplate', 3, 1174603200),
('http://localhost/frogsystem/www/?go=downlo', 2, 1174603906),
('http://localhost/frogsystem/www/admin/index.php?go=press_add', 23, 1174604352),
('http://localhost/frogsystem/www/admin/index.php?go=press_edit', 17, 1174604356),
('http://localhost/frogsystem/www/admin/?go=newsedit', 4, 1174651149),
('http://localhost/frogsystem/www/admin/?go=artikeledit', 3, 1174651164),
('http://localhost/frogsystem/www/admin/?go=cimgadd', 6, 1174651180),
('http://localhost/frogsystem/www/admin/?go=template_manage', 7, 1174651488),
('http://localhost/frogsystem/www/admin/?go=emailtemplate', 5, 1174660137),
('http://localhost/frogsystem/www/admin/?go=screencat', 1, 1174672184),
('http://localhost/frogsystem/www/admin/?go=news_cat_create', 3, 1174672203),
('http://localhost/frogsystem/www/admin/?go=zone_config', 3, 1174672268),
('http://localhost/frogsystem/www/admin/?go=press_edit', 6, 1174672437),
('http://localhost/frogsystem/www/admin/?go=csstemplate', 1, 1174672659),
('http://localhost/frogsystem/www/admin/?go=newsconfig', 1, 1174672667),
('http://localhost/frogsystem/www/admin/?go=newsadd', 4, 1174672679),
('http://localhost/frogsystem/www/admin/?go=artikeltemplate', 1, 1174672682),
('http://localhost/frogsystem/www/admin/?go=cimgdel', 2, 1174673098),
('http://localhost/frogsystem/www/admin/?go=useredit', 5, 1174673172),
('http://localhost/frogsystem/www/?go=profil&userid=3', 2, 1174673275),
('http://localhost/frogsystem/www/admin/index.php?go=logout', 20, 1174673678),
('http://localhost/frogsystem/www/admin/index.php?go=logout&sid=', 17, 1174673692),
('http://localhost/frogsystem/www/admin/index.php?go=login', 39, 1174673965),
('http://localhost/frogsystem/www/admin/?go=dladd', 1, 1174675774),
('http://localhost/frogsystem/www/admin/?go=logout', 1, 1174698725),
('http://localhost/frogsystem/www/admin/?go=press_add', 1, 1174737386),
('http://localhost/frogsystem/www/admin/?go=userrights', 1, 1176750458),
('http://localhost/frogsystem/www/admin/?go=useradd', 2, 1176750468),
('http://localhost/fs2/www/admin/', 17, 1176760481),
('http://localhost/fs2/www/admin/?go=allconfig', 14, 1176760485),
('http://localhost/fs2/www/', 56, 1176760566),
('http://localhost/fs2/www/?go=newsarchiv', 19, 1176761187),
('http://localhost/fs2/', 66, 1177684365),
('http://localhost/fs2/www/?go=screenshots', 13, 1177684371),
('http://localhost/fs2/www/?go=screenshots&catid=7', 1, 1177684373),
('http://sweil.dyndns.org/fs2/', 2, 1177691888),
('http://localhost/fs2/www/admin/?go=press_add', 2, 1178634943),
('http://localhost/fs2/www/admin/?go=press_edit', 2, 1178634946),
('http://localhost/fs2/www/admin/?go=alltemplate', 52, 1178634985),
('http://localhost/fs2/www/admin/?go=newsadd', 83, 1179739621),
('http://localhost/fs2/www/admin/?go=newsedit', 294, 1179739623),
('http://localhost/fs2/www/admin/?go=newsconfig', 13, 1179740180),
('http://localhost/fs2/www/admin/?go=news_cat_manage', 7, 1179740256),
('http://localhost/fs2/www/admin/?go=newstemplate', 39, 1179741920),
('http://localhost/fs2/www/?go=comments&id=6', 2, 1179743152),
('http://localhost/fs2/www/admin/?go=usertemplate', 14, 1179743297),
('http://localhost/fs2/www/?go=download', 9, 1179743536),
('http://localhost/fs2/www/admin/?go=useredit', 1, 1179743630),
('http://localhost/fs2/www/?go=logout', 3, 1179743650),
('http://localhost/fs2/www/?go=news', 46, 1179743654),
('http://localhost/fs2/www/?go=editprofil', 1, 1179743662),
('http://localhost/fs2/www//?go=dlfile&fileid=1', 3, 1179743824),
('http://localhost/fs2/www/admin/?go=csstemplate', 43, 1179743833),
('http://localhost/fs2/www/?go=pollarchiv', 43, 1179743954),
('http://localhost/fs2/www//?go=pollarchiv&pollid=4', 13, 1179743964),
('http://localhost/fs2/www//?go=pollarchiv&pollid=5', 4, 1179743969),
('http://localhost/fs2/www//?go=pollarchiv&pollid=3', 1, 1179743972),
('http://localhost/fs2/www//?go=pollarchiv&pollid=2', 1, 1179743976),
('http://localhost/fs2/www//?go=pollarchiv&orderby=voters_desc', 10, 1179743985),
('http://localhost/fs2/www//?go=pollarchiv&orderby=voters_asc', 4, 1179743986),
('http://localhost/fs2/www//?go=pollarchiv&orderby=name_desc', 4, 1179743992),
('http://localhost/fs2/www//?go=pollarchiv&orderby=date_desc', 7, 1179743994),
('http://localhost/fs2/www//?go=pollarchiv&orderby=date_asc', 6, 1179743996),
('http://localhost/fs2/www//?go=pollarchiv&orderby=name_asc', 3, 1179744086),
('http://localhost/fs2/www//', 1, 1179749085),
('http://localhost/fs2/www//?go=comments&id=6', 4, 1179749091),
('http://localhost/fs2/www/admin/?go=allannouncement', 3, 1179750280),
('http://localhost/fs2/www/admin/?go=cimgadd', 3, 1179751905),
('http://localhost/fs2/www/admin/?go=cimgdel', 1, 1179751992),
('http://localhost/fs2/www/admin/?go=artikeledit', 1, 1179752886),
('http://localhost/fs2/www/admin/admin_finduser.php', 4, 1179930908),
('http://localhost/fs2/www/admin/?go=profil', 1, 1179931451),
('http://localhost/fs2/www/admin/?go=login', 4, 1179931456),
('http://localhost/fs2/www/admin/?go=polltemplate', 39, 1180018868),
('http://localhost/fs2/www//?go=pollarchiv', 6, 1180019739),
('http://localhost/fs2/www//?go=pollarchiv&sort=enddate_desc', 26, 1180020050),
('http://localhost/fs2/www//?go=pollarchiv&sort=startdate_desc', 4, 1180020054),
('http://localhost/fs2/www//?go=pollarchiv&sort=voters_desc', 8, 1180020057),
('http://localhost/fs2/www//?go=pollarchiv&sort=enddate_asc', 32, 1180020077),
('http://localhost/fs2/www//?go=pollarchiv&sort=startdate_asc', 9, 1180020213),
('http://localhost/fs2/www//?go=pollarchiv&sort=voters_asc', 10, 1180020215),
('http://localhost/fs2/www//?go=pollarchiv&sort=name_desc', 2, 1180020217),
('http://localhost/fs2/www//?go=pollarchiv&sort=name_asc', 2, 1180020250),
('http://localhost/fs2/www//?go=pollarchiv&pollid=1', 1, 1180021666),
('http://localhost/fs2/www/?go=shop', 4, 1180021846),
('http://localhost/fs2/www//?go=screenshots&catid=6', 1, 1180042256),
('http://localhost/fs2/www/admin/?go=allphpinfo', 2, 1180115365),
('http://localhost/fs2/www/admin/?go=template_create', 1, 1180115426),
('http://localhost/fs2/www/admin/?go=template_manage', 6, 1180115428),
('http://localhost/fs2/www/?go=map', 3, 1180121985),
('http://localhost/fs2/www/admin/?go=shoptemplate', 39, 1181740206),
('http://localhost/fs2/www/admin/?go=artikeltemplate', 2, 1181742064),
('http://localhost/fs2/www/admin/?go=dltemplate', 38, 1181742586),
('http://localhost/fs2/www/?go=download&keyword=sd', 2, 1181743655),
('http://localhost/fs2/www/?go=download&catid=2', 23, 1181743665),
('http://localhost/fs2/www/?go=download&catid=2&keyword=sd', 3, 1181743666),
('http://localhost/fs2/www/?go=download&catid=2&keyword=gg', 1, 1181743924),
('http://localhost/fs2/www/?go=dlfile&fileid=1', 1, 1181744144),
('http://localhost/fs2/www/?keyword=get&go=download&catid=2', 1, 1181744202),
('http://localhost/fs2/www/admin/?go=includes_new', 2, 1181936293),
('http://localhost/fs2/www/admin/?go=includes_edit', 1, 1181936295),
('http://localhost/fs/', 1, 1182700813),
('http://localhost/fs/www/', 1, 1182700822),
('http://localhost/fs2/www/admin/?go=randompic_cat', 1, 1182701203),
('http://localhost/fs2/www/admin/index.php', 36, 1182701208),
('http://localhost/fs2/www/admin/?go=randompic_time', 3, 1182704721),
('http://localhost/fs2/www/admin/?go=randompic_time_add', 52, 1182865466),
('http://localhost/fs2/www/admin/admin_findpicture.php', 45, 1182866644),
('http://localhost/fs2/www/admin/?go=screenadd', 2, 1182870962),
('http://localhost/fs2/www/admin/?go=screenedit', 1, 1182871137);

-- --------------------------------------------------------

-- 
-- Table structure for table `fs_counter_stat`
-- 

DROP TABLE IF EXISTS `fs_counter_stat`;
CREATE TABLE IF NOT EXISTS `fs_counter_stat` (
  `s_year` int(4) default NULL,
  `s_month` int(2) default NULL,
  `s_day` int(2) default NULL,
  `s_visits` int(11) default NULL,
  `s_hits` int(11) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- 
-- Dumping data for table `fs_counter_stat`
-- 

REPLACE INTO `fs_counter_stat` (`s_year`, `s_month`, `s_day`, `s_visits`, `s_hits`) VALUES 
(2006, 8, 31, 1, 151),
(2006, 9, 3, 1, 172),
(2006, 9, 4, 0, 272),
(2006, 9, 5, 1, 500),
(2006, 9, 6, 1, 519),
(2006, 9, 9, 1, 1),
(2006, 9, 10, 1, 210),
(2006, 9, 14, 1, 5),
(2006, 9, 27, 1, 491),
(2006, 9, 28, 1, 6),
(2006, 10, 3, 1, 15),
(2006, 10, 7, 1, 152),
(2006, 10, 7, 1, 152),
(2006, 10, 8, 0, 106),
(2006, 10, 12, 1, 1),
(2006, 10, 14, 2, 335),
(2006, 10, 14, 2, 335),
(2006, 10, 18, 1, 9),
(2006, 10, 22, 1, 277),
(2006, 10, 23, 0, 48),
(2006, 10, 27, 2, 291),
(2006, 10, 27, 2, 291),
(2006, 10, 29, 1, 3),
(2006, 11, 2, 1, 161),
(2006, 11, 2, 1, 161),
(2006, 11, 6, 1, 104),
(2006, 11, 6, 1, 104),
(2006, 11, 7, 0, 2),
(2006, 11, 9, 1, 1),
(2006, 11, 15, 2, 17),
(2006, 11, 15, 2, 17),
(2006, 11, 24, 1, 4),
(2006, 12, 5, 1, 197),
(2006, 12, 18, 1, 22),
(2006, 12, 21, 1, 27),
(2007, 1, 27, 1, 211),
(2007, 1, 28, 1, 253),
(2007, 1, 29, 1, 377),
(2007, 1, 30, 1, 155),
(2007, 1, 31, 1, 47),
(2007, 2, 1, 0, 2),
(2007, 2, 21, 1, 151),
(2007, 3, 19, 1, 356),
(2007, 3, 20, 1, 186),
(2007, 3, 22, 1, 79),
(2007, 3, 23, 1, 604),
(2007, 3, 24, 0, 62),
(2007, 3, 25, 1, 7),
(2007, 4, 13, 1, 1),
(2007, 4, 15, 1, 1),
(2007, 4, 16, 1, 22),
(2007, 4, 17, 0, 13),
(2007, 4, 27, 2, 5),
(2007, 4, 28, 0, 1),
(2007, 5, 8, 1, 9),
(2007, 5, 21, 1, 326),
(2007, 5, 23, 1, 120),
(2007, 5, 24, 1, 281),
(2007, 5, 25, 1, 325),
(2007, 6, 11, 1, 14),
(2007, 6, 13, 1, 119),
(2007, 6, 15, 1, 35),
(2007, 6, 24, 1, 58),
(2007, 6, 26, 1, 164);

-- --------------------------------------------------------

-- 
-- Table structure for table `fs_dl`
-- 

DROP TABLE IF EXISTS `fs_dl`;
CREATE TABLE IF NOT EXISTS `fs_dl` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `fs_dl`
-- 

REPLACE INTO `fs_dl` (`dl_id`, `cat_id`, `user_id`, `dl_date`, `dl_name`, `dl_text`, `dl_autor`, `dl_autor_url`, `dl_open`) VALUES 
(1, 2, 1, 1157841305, 'sdsdsd', 'dfgfdfsdfs', 'Sweil', 'http://www.10tacle.sk/', 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `fs_dl_cat`
-- 

DROP TABLE IF EXISTS `fs_dl_cat`;
CREATE TABLE IF NOT EXISTS `fs_dl_cat` (
  `cat_id` mediumint(8) NOT NULL auto_increment,
  `subcat_id` mediumint(8) NOT NULL default '0',
  `cat_name` char(100) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `fs_dl_cat`
-- 

REPLACE INTO `fs_dl_cat` (`cat_id`, `subcat_id`, `cat_name`) VALUES 
(2, 0, 'Videos');

-- --------------------------------------------------------

-- 
-- Table structure for table `fs_dl_config`
-- 

DROP TABLE IF EXISTS `fs_dl_config`;
CREATE TABLE IF NOT EXISTS `fs_dl_config` (
  `screen_x` int(11) default NULL,
  `screen_y` int(11) default NULL,
  `thumb_x` int(11) default NULL,
  `thumb_y` int(11) default NULL,
  `quickinsert` varchar(255) collate latin1_general_ci NOT NULL default '',
  `dl_rights` tinyint(1) NOT NULL default '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- 
-- Dumping data for table `fs_dl_config`
-- 

REPLACE INTO `fs_dl_config` (`screen_x`, `screen_y`, `thumb_x`, `thumb_y`, `quickinsert`, `dl_rights`) VALUES 
(1024, 768, 120, 90, 'http://ftp.worldofplayers.net/frogsystem/', 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `fs_dl_files`
-- 

DROP TABLE IF EXISTS `fs_dl_files`;
CREATE TABLE IF NOT EXISTS `fs_dl_files` (
  `dl_id` mediumint(8) default NULL,
  `file_id` mediumint(8) NOT NULL auto_increment,
  `file_count` mediumint(8) NOT NULL default '0',
  `file_name` varchar(100) collate latin1_general_ci default NULL,
  `file_url` varchar(255) collate latin1_general_ci default NULL,
  `file_size` mediumint(8) NOT NULL default '0',
  `file_is_mirror` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`file_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=5 ;

-- 
-- Dumping data for table `fs_dl_files`
-- 

REPLACE INTO `fs_dl_files` (`dl_id`, `file_id`, `file_count`, `file_name`, `file_url`, `file_size`, `file_is_mirror`) VALUES 
(1, 1, 7, 'Test', 'http://ftp.worldofplayers.net/frogsystem/hallo.test', 43335, 0),
(1, 2, 26, 'Test @ www.ggg.de', 'http://ftp.worldofplayers.net/frogsystem/muss.zip', 43335, 1),
(1, 3, 25, 'Test @ www.ggg.de', 'http://ftp.worldofplayers.net/frogsystem/muss.zip', 43335, 1),
(1, 4, 27, 'Test @ www.ggg.de', 'http://ftp.worldofplayers.net/frogsystem/muss.zip', 43335, 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `fs_global_config`
-- 

DROP TABLE IF EXISTS `fs_global_config`;
CREATE TABLE IF NOT EXISTS `fs_global_config` (
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
  `show_announcement` tinyint(1) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- 
-- Dumping data for table `fs_global_config`
-- 

REPLACE INTO `fs_global_config` (`id`, `virtualhost`, `admin_mail`, `title`, `description`, `keywords`, `author`, `show_favicon`, `design`, `allow_other_designs`, `show_announcement`) VALUES 
(1, 'http://localhost/fs2/www/', 'admin@frogsystem.de', 'FrogSystem', 'FrogSystem - Your Way to Nature', 'CMS, content, management, system', 'Kermit, Sweil, rockfest, Wal, Don-Esteban, Fizzban', 0, 0, 1, 2);

-- --------------------------------------------------------

-- 
-- Table structure for table `fs_includes`
-- 

DROP TABLE IF EXISTS `fs_includes`;
CREATE TABLE IF NOT EXISTS `fs_includes` (
  `id` mediumint(8) NOT NULL auto_increment,
  `replace_string` varchar(255) collate latin1_general_ci NOT NULL default '',
  `replace_thing` text collate latin1_general_ci NOT NULL,
  `include_type` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=6 ;

-- 
-- Dumping data for table `fs_includes`
-- 

REPLACE INTO `fs_includes` (`id`, `replace_string`, `replace_thing`, `include_type`) VALUES 
(1, '[%test%]', 'hallo', 1),
(4, '[%netzwerk%]', 'http://www.worldofplayers.de/netzwerk.inc.php', 3),
(5, '[%x%]', 'http://www.google.de', 3);

-- --------------------------------------------------------

-- 
-- Table structure for table `fs_iplist`
-- 

DROP TABLE IF EXISTS `fs_iplist`;
CREATE TABLE IF NOT EXISTS `fs_iplist` (
  `deltime` int(20) default NULL,
  `ip` varchar(18) collate latin1_general_ci default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- 
-- Dumping data for table `fs_iplist`
-- 

REPLACE INTO `fs_iplist` (`deltime`, `ip`) VALUES 
(1182864594, '127.0.0.1');

-- --------------------------------------------------------

-- 
-- Table structure for table `fs_news`
-- 

DROP TABLE IF EXISTS `fs_news`;
CREATE TABLE IF NOT EXISTS `fs_news` (
  `news_id` mediumint(8) NOT NULL auto_increment,
  `cat_id` smallint(6) default NULL,
  `user_id` mediumint(8) default NULL,
  `news_date` int(11) default NULL,
  `news_title` varchar(100) collate latin1_general_ci default NULL,
  `news_text` text collate latin1_general_ci,
  PRIMARY KEY  (`news_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=10 ;

-- 
-- Dumping data for table `fs_news`
-- 

REPLACE INTO `fs_news` (`news_id`, `cat_id`, `user_id`, `news_date`, `news_title`, `news_text`) VALUES 
(6, 6, 1, 1157411940, 'Vocent feugait', 'Vocent feugait te eam, id pro nihil quaestio. Mei probo graeci ea. Euismod gubergren complectitur id mea. Vel prompta volutpat postulant et, nec meis detraxit an. Facer mentitum dissentiet per ne, id regione singulis antiopam cum.\r\n\r\nEx vel falli viderer habemus. Ea ius repudiare constituto vituperata, ad omnis nominavi ius. Usu mollis verear delicata id, nec et facete facilisi consequuntur. Illud utamur quo at, cibo corrumpit reprimique an pri.\r\n\r\nPer imperdiet iracundia ei, iudico quaeque inermis vel te, aliquando forensibus at vel. Error choro definitiones ius ei. Vel choro legimus ut, quo no nonumy appellantur instructior. Eum vocent singulis et, quodsi reprehendunt vix cu, eu aliquid volumus hendrerit quo.\r\n\r\nMea at solum doctus habemus. An labore assueverit mea, in essent aliquyam conceptam nec. Eligendi luptatum iudicabit an vim. Quem neglegentur est at. Quot mediocritatem te usu, at mea volutpat tincidunt. Ea ius sapientem ocurreret contentiones.\r\n\r\nErat omittam fabellas ei sit, quodsi vulputate ius cu. Vero utroque phaedrum sed an, ea cum diam scaevola moderatius, ad hinc graeco duo. Ex mei numquam voluptua, ex has fuisset cotidieque, justo habemus definitionem ei has. Eum nobis possit conclusionemque ea. Perpetua gubergren usu cu. Ne inani assentior mei.');

-- --------------------------------------------------------

-- 
-- Table structure for table `fs_news_cat`
-- 

DROP TABLE IF EXISTS `fs_news_cat`;
CREATE TABLE IF NOT EXISTS `fs_news_cat` (
  `cat_id` smallint(6) NOT NULL auto_increment,
  `cat_name` varchar(100) collate latin1_general_ci default NULL,
  `cat_description` text collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=7 ;

-- 
-- Dumping data for table `fs_news_cat`
-- 

REPLACE INTO `fs_news_cat` (`cat_id`, `cat_name`, `cat_description`) VALUES 
(6, 'Latein', 'In dieser Kategorie werden Texte nur auf Latein gepostet.');

-- --------------------------------------------------------

-- 
-- Table structure for table `fs_news_comments`
-- 

DROP TABLE IF EXISTS `fs_news_comments`;
CREATE TABLE IF NOT EXISTS `fs_news_comments` (
  `comment_id` mediumint(8) NOT NULL auto_increment,
  `news_id` mediumint(8) default NULL,
  `comment_poster` varchar(32) collate latin1_general_ci default NULL,
  `comment_poster_id` mediumint(8) default NULL,
  `comment_date` int(11) default NULL,
  `comment_title` varchar(100) collate latin1_general_ci default NULL,
  `comment_text` text collate latin1_general_ci,
  PRIMARY KEY  (`comment_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=13 ;

-- 
-- Dumping data for table `fs_news_comments`
-- 

REPLACE INTO `fs_news_comments` (`comment_id`, `news_id`, `comment_poster`, `comment_poster_id`, `comment_date`, `comment_title`, `comment_text`) VALUES 
(2, 6, 'asdsa', 0, 1169953620, 'b, i, u, s', '[b]fett[/b]\r\n[i]kursiv[/i]\r\n[u]unterstrichen[/u]\r\n[s]durchgestrichen[/s]'),
(4, 6, '', 1, 1169999393, 'center, url, home, email', '[center]zentriert[/CENTER]\r\n\r\n[url]http://google.de[/url]\r\n[url=http://google.de]Google.de[/url]\r\n\r\n[home]newsarchiv[/home]\r\n[home=newsarchiv]Alte News anzeigen[/home]\r\n\r\n[email]admin@frogsystem.de[/email]\r\n[email=admin@frogsystem.de]Email-Adresse des Admins[/email]'),
(5, 6, '', 1, 1169999432, 'img, cimg', '[img]http://forum.worldofplayers.de/layouts/wop/buttons/reply.gif[/img]\r\n[img=right]http://forum.worldofplayers.de/layouts/wop/buttons/reply.gif[/img]\r\n\r\n[cimg]test.gif[/cimg]\r\n[cimg=right]test.gif[/cimg]'),
(6, 6, '', 1, 1169999566, 'list, numlist', '[list][*]test 1\r\n[*]test 2\r\n[*]test 3[/list]\r\n[numlist][*]test 1\r\n[*]test 2\r\n[*]test 3[/numlist]'),
(7, 6, '', 1, 1170001566, 'font, color, size', '[font=courier]Text in Courier[/font]\r\n\r\n[color=red]Rote Schrift[/color]\r\n\r\n[size=5]Große Schrift[/size]'),
(8, 6, '', 1, 1170002001, 'code, quote, noparse', '[quote]Ich bin nicht der Herrscher der Welt; die Welt beherrscht mich![/quote]\r\n\r\n[quote=Sweil]Ich bin nicht der Herrscher der Welt; die Welt beherrscht mich![/quote]\r\n\r\n[code]Ich bin nicht der Herrscher der Welt; die Welt beherrscht mich![/code]\r\n\r\n[noparse][b]Kein fetter Text![/b][/noparse]'),
(9, 6, '', 1, 1170003505, 'smilies', ':-) ;-) xD :-P §sweet');

-- --------------------------------------------------------

-- 
-- Table structure for table `fs_news_config`
-- 

DROP TABLE IF EXISTS `fs_news_config`;
CREATE TABLE IF NOT EXISTS `fs_news_config` (
  `num_news` int(11) default NULL,
  `num_head` int(11) default NULL,
  `html_code` tinyint(4) default NULL,
  `fs_code` tinyint(4) default NULL,
  `para_handling` tinyint(4) default NULL,
  `cat_pic_x` mediumint(4) NOT NULL default '0',
  `cat_pic_y` mediumint(4) NOT NULL default '0',
  `com_rights` tinyint(1) NOT NULL default '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- 
-- Dumping data for table `fs_news_config`
-- 

REPLACE INTO `fs_news_config` (`num_news`, `num_head`, `html_code`, `fs_code`, `para_handling`, `cat_pic_x`, `cat_pic_y`, `com_rights`) VALUES 
(10, 6, 2, 4, 2, 150, 150, 2);

-- --------------------------------------------------------

-- 
-- Table structure for table `fs_news_links`
-- 

DROP TABLE IF EXISTS `fs_news_links`;
CREATE TABLE IF NOT EXISTS `fs_news_links` (
  `news_id` mediumint(8) default NULL,
  `link_id` mediumint(8) NOT NULL auto_increment,
  `link_name` varchar(100) collate latin1_general_ci default NULL,
  `link_url` varchar(255) collate latin1_general_ci default NULL,
  `link_target` tinyint(4) default NULL,
  PRIMARY KEY  (`link_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=7 ;

-- 
-- Dumping data for table `fs_news_links`
-- 

REPLACE INTO `fs_news_links` (`news_id`, `link_id`, `link_name`, `link_url`, `link_target`) VALUES 
(6, 6, 'Generator', 'http://www.lorem-ipsum.info/generator3-de', 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `fs_partner`
-- 

DROP TABLE IF EXISTS `fs_partner`;
CREATE TABLE IF NOT EXISTS `fs_partner` (
  `partner_id` smallint(3) unsigned NOT NULL auto_increment,
  `partner_name` varchar(150) collate latin1_general_ci NOT NULL default '',
  `partner_link` varchar(250) collate latin1_general_ci NOT NULL default '',
  `partner_beschreibung` text collate latin1_general_ci NOT NULL,
  `partner_permanent` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`partner_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `fs_partner`
-- 

REPLACE INTO `fs_partner` (`partner_id`, `partner_name`, `partner_link`, `partner_beschreibung`, `partner_permanent`) VALUES 
(2, 'DSA - Drakensang', 'http://www.dsa-drakensang.de', 'Drakensang ist ein super Spiel!', 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `fs_partner_config`
-- 

DROP TABLE IF EXISTS `fs_partner_config`;
CREATE TABLE IF NOT EXISTS `fs_partner_config` (
  `partner_anzahl` tinyint(2) NOT NULL default '0',
  `small_x` int(11) NOT NULL default '0',
  `small_y` int(11) NOT NULL default '0',
  `small_allow` tinyint(1) NOT NULL default '0',
  `big_x` int(11) NOT NULL default '0',
  `big_y` int(11) NOT NULL default '0',
  `big_allow` tinyint(1) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- 
-- Dumping data for table `fs_partner_config`
-- 

REPLACE INTO `fs_partner_config` (`partner_anzahl`, `small_x`, `small_y`, `small_allow`, `big_x`, `big_y`, `big_allow`) VALUES 
(5, 88, 31, 0, 468, 60, 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `fs_permissions`
-- 

DROP TABLE IF EXISTS `fs_permissions`;
CREATE TABLE IF NOT EXISTS `fs_permissions` (
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
-- Dumping data for table `fs_permissions`
-- 

REPLACE INTO `fs_permissions` (`user_id`, `perm_newsadd`, `perm_newsedit`, `perm_newscat`, `perm_newsnewcat`, `perm_newsconfig`, `perm_dladd`, `perm_dledit`, `perm_dlcat`, `perm_dlnewcat`, `perm_polladd`, `perm_polledit`, `perm_potmadd`, `perm_potmedit`, `perm_screenadd`, `perm_screenedit`, `perm_screencat`, `perm_screennewcat`, `perm_screenconfig`, `perm_shopadd`, `perm_shopedit`, `perm_statedit`, `perm_useradd`, `perm_useredit`, `perm_userrights`, `perm_map`, `perm_statview`, `perm_statref`, `perm_artikeladd`, `perm_artikeledit`, `perm_templateedit`, `perm_allphpinfo`, `perm_allconfig`, `perm_allannouncement`, `perm_statspace`, `perm_gbedit`, `perm_gbcat`, `perm_partneradd`, `perm_partneredit`) VALUES 
(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(2, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(4, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `fs_poll`
-- 

DROP TABLE IF EXISTS `fs_poll`;
CREATE TABLE IF NOT EXISTS `fs_poll` (
  `poll_id` mediumint(8) NOT NULL auto_increment,
  `poll_quest` char(255) collate latin1_general_ci default NULL,
  `poll_start` int(11) default NULL,
  `poll_end` int(11) default NULL,
  `poll_type` tinyint(4) default NULL,
  `poll_participants` mediumint(8) NOT NULL default '0',
  PRIMARY KEY  (`poll_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=6 ;

-- 
-- Dumping data for table `fs_poll`
-- 

REPLACE INTO `fs_poll` (`poll_id`, `poll_quest`, `poll_start`, `poll_end`, `poll_type`, `poll_participants`) VALUES 
(1, 'Weiter Machen?', 1157540160, 1160132160, 0, 0),
(2, 'möp?', 1159364100, 1161956100, 1, 0),
(3, 'jhk', 1154013780, 1161962580, 0, 0),
(4, '^test', 1166462340, 1180266360, 1, 30),
(5, 'hehe', 1174404180, 1177078980, 1, 2);

-- --------------------------------------------------------

-- 
-- Table structure for table `fs_poll_answers`
-- 

DROP TABLE IF EXISTS `fs_poll_answers`;
CREATE TABLE IF NOT EXISTS `fs_poll_answers` (
  `poll_id` mediumint(8) default NULL,
  `answer_id` mediumint(8) NOT NULL auto_increment,
  `answer` varchar(255) collate latin1_general_ci default NULL,
  `answer_count` mediumint(8) NOT NULL default '0',
  PRIMARY KEY  (`answer_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=12 ;

-- 
-- Dumping data for table `fs_poll_answers`
-- 

REPLACE INTO `fs_poll_answers` (`poll_id`, `answer_id`, `answer`, `answer_count`) VALUES 
(1, 1, 'Ja', 8),
(1, 2, 'Nein', 4),
(2, 3, 'blubb', 5),
(2, 4, 'gg', 3),
(2, 5, 'dfsdfsdf', 3),
(3, 6, 'hjk', 0),
(3, 7, 'hjkh', 0),
(4, 8, 'hallo', 18),
(4, 9, 'hallihallo', 20),
(5, 10, '1', 1),
(5, 11, '2', 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `fs_poll_voters`
-- 

DROP TABLE IF EXISTS `fs_poll_voters`;
CREATE TABLE IF NOT EXISTS `fs_poll_voters` (
  `voter_id` mediumint(8) unsigned NOT NULL auto_increment,
  `poll_id` mediumint(8) unsigned NOT NULL default '0',
  `ip_address` varchar(15) collate latin1_general_ci NOT NULL default '0.0.0.0',
  `time` int(32) NOT NULL default '0',
  PRIMARY KEY  (`voter_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=20 ;

-- 
-- Dumping data for table `fs_poll_voters`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `fs_press`
-- 

DROP TABLE IF EXISTS `fs_press`;
CREATE TABLE IF NOT EXISTS `fs_press` (
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
-- Dumping data for table `fs_press`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `fs_press_cat`
-- 

DROP TABLE IF EXISTS `fs_press_cat`;
CREATE TABLE IF NOT EXISTS `fs_press_cat` (
  `press_cat_id` smallint(6) NOT NULL auto_increment,
  `press_cat_name` varchar(100) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`press_cat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `fs_press_cat`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `fs_press_game`
-- 

DROP TABLE IF EXISTS `fs_press_game`;
CREATE TABLE IF NOT EXISTS `fs_press_game` (
  `press_game_id` smallint(6) NOT NULL auto_increment,
  `press_game_name` varchar(100) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`press_game_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `fs_press_game`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `fs_screen`
-- 

DROP TABLE IF EXISTS `fs_screen`;
CREATE TABLE IF NOT EXISTS `fs_screen` (
  `screen_id` mediumint(8) NOT NULL auto_increment,
  `cat_id` smallint(6) unsigned default NULL,
  `screen_name` char(100) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`screen_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=16 ;

-- 
-- Dumping data for table `fs_screen`
-- 

REPLACE INTO `fs_screen` (`screen_id`, `cat_id`, `screen_name`) VALUES 
(5, 7, 'test'),
(4, 7, ''),
(6, 7, ''),
(12, 7, ''),
(11, 7, ''),
(13, 7, ''),
(14, 7, ''),

-- --------------------------------------------------------

-- 
-- Table structure for table `fs_screen_cat`
-- 

DROP TABLE IF EXISTS `fs_screen_cat`;
CREATE TABLE IF NOT EXISTS `fs_screen_cat` (
  `cat_id` smallint(6) unsigned NOT NULL auto_increment,
  `cat_name` char(100) collate latin1_general_ci default NULL,
  `cat_type` tinyint(1) NOT NULL default '0',
  `cat_visibility` tinyint(1) NOT NULL default '1',
  `cat_date` int(11) NOT NULL default '0',
  `randompic` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=8 ;

-- 
-- Dumping data for table `fs_screen_cat`
-- 

REPLACE INTO `fs_screen_cat` (`cat_id`, `cat_name`, `cat_type`, `cat_visibility`, `cat_date`, `randompic`) VALUES 
(6, 'Wallpaper', 2, 2, 1160258165, 0),
(7, 'Screenshots', 1, 1, 1160260023, 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `fs_screen_config`
-- 

DROP TABLE IF EXISTS `fs_screen_config`;
CREATE TABLE IF NOT EXISTS `fs_screen_config` (
  `screen_x` int(11) default NULL,
  `screen_y` int(11) default NULL,
  `thumb_x` int(11) default NULL,
  `thumb_y` int(11) default NULL,
  `max_size` int(11) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- 
-- Dumping data for table `fs_screen_config`
-- 

REPLACE INTO `fs_screen_config` (`screen_x`, `screen_y`, `thumb_x`, `thumb_y`, `max_size`) VALUES 
(5000, 5000, 120, 90, 2048);

-- --------------------------------------------------------

-- 
-- Table structure for table `fs_screen_random`
-- 

DROP TABLE IF EXISTS `fs_screen_random`;
CREATE TABLE IF NOT EXISTS `fs_screen_random` (
  `random_id` int(10) unsigned NOT NULL auto_increment,
  `screen_id` int(11) NOT NULL,
  `start` int(11) NOT NULL,
  `end` int(11) NOT NULL,
  PRIMARY KEY  (`random_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- 
-- Dumping data for table `fs_screen_random`
-- 

REPLACE INTO `fs_screen_random` (`random_id`, `screen_id`, `start`, `end`) VALUES 
(3, 14, 1182872640, 1182876240);

-- --------------------------------------------------------

-- 
-- Table structure for table `fs_shop`
-- 

DROP TABLE IF EXISTS `fs_shop`;
CREATE TABLE IF NOT EXISTS `fs_shop` (
  `artikel_id` smallint(6) unsigned NOT NULL auto_increment,
  `artikel_name` varchar(100) collate latin1_general_ci default NULL,
  `artikel_url` varchar(255) collate latin1_general_ci default NULL,
  `artikel_text` text collate latin1_general_ci,
  `artikel_preis` varchar(10) collate latin1_general_ci default NULL,
  `artikel_hot` tinyint(4) default NULL,
  PRIMARY KEY  (`artikel_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=5 ;

-- 
-- Dumping data for table `fs_shop`
-- 

REPLACE INTO `fs_shop` (`artikel_id`, `artikel_name`, `artikel_url`, `artikel_text`, `artikel_preis`, `artikel_hot`) VALUES 
(1, 'Guild Wars Nightfall', 'http://www.amazon.de/NCsoft-Europe-Guild-Wars-Nightfall/dp/B000I2J5BU/sr=8-1/qid=1161969497/ref=pd_ka_1/028-6232893-0480517?ie=UTF8&s=videogames', 'Guild Wars – der Kampf geht weiter! Die Finsternis bricht herein, das Licht muss siegen ... Wenn ein korrupter Herrscher die Macht eines verstorbenen Gottes herbeiruft, bedarf es einer Gruppe unerschrockener Helden, um den Kontinent Elona vor der schleichenden Dunkelheit zu retten. Guild Wars Nightfall ist die dritte epische Herausforderung aus dem preisgekrönten Guild Wars-Universum und wird sowohl neue also auch erfahrene Guild Wars-Spieler gleichermaßen begeistern!\r\n\r\nJeder Held schreibt seine eigene Geschichte. Die Handlungen der Spieler werden drastische Konsequenzen nach sich ziehen und die Gruppe wird zum verlängerten Arm des Charakters. So haben Sie Guild Wars noch nie zuvor gesehen!', '38,95', 0),
(2, 'Factions', 'http://www.amazon.de/NCsoft-Europe-Guild-Wars-Nightfall/dp/B000I2J5BU/sr=8-1/qid=1161969497/ref=pd_ka_1/028-6232893-0480517?ie=UTF8&s=videogames', 'Guild Wars – der Kampf geht weiter! Die Finsternis bricht herein, das Licht muss siegen ... Wenn ein korrupter Herrscher die Macht eines verstorbenen Gottes herbeiruft, bedarf es einer Gruppe unerschrockener Helden, um den Kontinent Elona vor der schleichenden Dunkelheit zu retten. Guild Wars Nightfall ist die dritte epische Herausforderung aus dem preisgekrönten Guild Wars-Universum und wird sowohl neue also auch erfahrene Guild Wars-Spieler gleichermaßen begeistern!\r\n\r\nJeder Held schreibt seine eigene Geschichte. Die Handlungen der Spieler werden drastische Konsequenzen nach sich ziehen und die Gruppe wird zum verlängerten Arm des Charakters. So haben Sie Guild Wars noch nie zuvor gesehen!', '56,65', 1),
(3, 'test gain', 'ddd', 'dddddddddxd', '8,99', 0),
(4, 'asf', 'sdf', 'asdfasdf', '434,8', 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `fs_smilies`
-- 

DROP TABLE IF EXISTS `fs_smilies`;
CREATE TABLE IF NOT EXISTS `fs_smilies` (
  `id` mediumint(6) NOT NULL auto_increment,
  `replace_string` varchar(15) collate latin1_general_ci NOT NULL,
  `image_name` varchar(255) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=31 ;

-- 
-- Dumping data for table `fs_smilies`
-- 

REPLACE INTO `fs_smilies` (`id`, `replace_string`, `image_name`) VALUES 
(1, ':-)', 'happy.gif'),
(2, ':-(', 'sad.gif'),
(3, ';-)', 'wink.gif'),
(4, ':-P', 'tongue.gif'),
(5, 'xD', 'grin.gif'),
(6, ':-o', 'shocked.gif'),
(7, '^_^', 'sweet.gif'),
(8, ':-/', 'neutral.gif'),
(9, ':-]', 'satisfied.gif'),
(10, '>-(', 'angry.gif'),
(11, '§afraid', 'afraid.gif'),
(12, '§angry', 'angry.gif'),
(13, '§wink', 'wink.gif'),
(14, '§confused', 'confused.gif'),
(15, '§cool', 'cool.gif'),
(16, '§grin', 'grin.gif'),
(17, '§happy', 'happy.gif'),
(18, '§ko', 'ko.gif'),
(19, '§laugh', 'laughing.gif'),
(20, '§mad', 'mad.gif'),
(21, '§neutral', 'neutral.gif'),
(22, '§rolleyes', 'rolleyes.gif'),
(23, '§sad', 'sad.gif'),
(24, '§satisfied', 'satisfied.gif'),
(25, '§shock', 'shocked.gif'),
(26, '§sigh', 'sigh.gif'),
(27, '§sleep', 'sleep.gif'),
(28, '§sweet', 'sweet.gif'),
(29, '§tongue', 'tongue.gif'),
(30, '§yawn', 'yawn.gif');

-- --------------------------------------------------------

-- 
-- Table structure for table `fs_template`
-- 

DROP TABLE IF EXISTS `fs_template`;
CREATE TABLE IF NOT EXISTS `fs_template` (
  `id` tinyint(4) NOT NULL default '0',
  `name` varchar(100) collate latin1_general_ci NOT NULL default '',
  `indexphp` text collate latin1_general_ci NOT NULL,
  `date` text collate latin1_general_ci NOT NULL,
  `artikel_body` text collate latin1_general_ci NOT NULL,
  `artikel_autor` text collate latin1_general_ci NOT NULL,
  `potm_body` text collate latin1_general_ci NOT NULL,
  `potm_nobody` text collate latin1_general_ci NOT NULL,
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
  `pic_viewer` text collate latin1_general_ci NOT NULL,
  `user_user_menu` text collate latin1_general_ci NOT NULL,
  `user_admin_link` text collate latin1_general_ci NOT NULL,
  `user_login` text collate latin1_general_ci NOT NULL,
  `user_profiledit` text collate latin1_general_ci NOT NULL,
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
  `members_body` text collate latin1_general_ci NOT NULL,
  `members_user` text collate latin1_general_ci NOT NULL,
  `members_admin` text collate latin1_general_ci NOT NULL,
  `code_tag` text collate latin1_general_ci NOT NULL,
  `quote_tag` text collate latin1_general_ci NOT NULL,
  `quote_tag_name` text collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci PACK_KEYS=1;

-- 
-- Dumping data for table `fs_template`
-- 

REPLACE INTO `fs_template` (`id`, `name`, `indexphp`, `date`, `artikel_body`, `artikel_autor`, `potm_body`, `potm_nobody`, `shop_body`, `shop_hot`, `news_link`, `news_related_links`, `news_headline`, `main_menu`, `news_comment_body`, `news_comment_autor`, `news_comment_form`, `news_comment_form_name`, `news_search_form`, `error`, `news_headline_body`, `user_mini_login`, `shop_main_body`, `shop_artikel`, `dl_navigation`, `dl_search_field`, `dl_body`, `dl_datei_preview`, `dl_file_body`, `dl_file`, `dl_file_is_mirror`, `dl_stats`, `dl_quick_links`, `screenshot_pic`, `screenshot_body`, `screenshot_cat`, `screenshot_cat_body`, `pic_viewer`, `user_user_menu`, `user_admin_link`, `user_login`, `user_profiledit`, `community_map`, `poll_body`, `poll_line`, `poll_main_body`, `poll_main_line`, `poll_result`, `poll_result_line`, `poll_list`, `poll_list_line`, `poll_no_poll`, `user_profil`, `statistik`, `user_register`, `news_body`, `announcement`, `email_register`, `email_passchange`, `partner_eintrag`, `partner_main_body`, `partner_navi_eintrag`, `partner_navi_body`, `members_body`, `members_user`, `members_admin`, `code_tag`, `quote_tag`, `quote_tag_name`) VALUES 
(0, 'default', '<body>\r\n    <div id="head_shadow"></div>\r\n    <div id="head"></div>\r\n\r\n\r\n    <div id="menu_l_shadow">\r\n        <div id="menu_l">\r\n{main_menu}\r\n        </div>\r\n    </div>\r\n    <div id="main_container">\r\n        <div id="main_shadow">\r\n            <div id="main">\r\n{announcement}\r\n{content}\r\n            </div>\r\n        </div>\r\n        <p>\r\n    </div>\r\n\r\n    <div id="menu_r_shadow">\r\n        <div id="menu_r">\r\n{user}<br><br>\r\nZufallsbild:<br>\r\n{randompic}<br><br>\r\nShop:<br>\r\n{shop}<br><br>\r\nUmfrage:<br>\r\n{poll}<br><br>\r\nPartner:<br>\r\n{partner}<br><br>\r\nStatistik:<br>\r\n{stats}<br><br>\r\nNetzwerk:<br>\r\n[%netzwerk%]\r\n<br><br>\r\n        </div>\r\n    </div>\r\n</body>', '', '<div class="news_head" style="height:10px;">\r\n   <span style="float:left;">\r\n       <b>{titel}</b>\r\n   </span>\r\n   <span class="small" style="float:right;">\r\n       <b>{datum}</b>\r\n   </span>\r\n</div>\r\n<div>\r\n   {text}\r\n</div>\r\n<div>\r\n   <span class="small" style="float:right;">\r\n       {autor}\r\n   </span>\r\n</div>\r\n<p></p>', 'geschrieben von <a class="small" href="{profillink}">{username}</a>', '<img class=\\"thumb\\" onClick=\\"open(\\''{link}\\'',\\''Picture\\'',\\''width=900,height=710,screenX=0,screenY=0\\'')\\" src=\\"{thumb}\\" alt=\\"{titel}\\">', '<div class=\\"small\\" align=\\"center\\">\r\n     Kein Zufallsbild aktiv\r\n</div>', '{hotlinks}', '<div align="center">\r\n    <a style="font-weight:bold;" class="small" target="_blank" href="{link}">{titel}</a>\r\n</div>', '<li><a href=\\"{url}\\" target=\\"{target}\\">{name}</a></li>', '<p>\r\n<b>Related Links:</b>\r\n<ul>\r\n    {links}\r\n</ul>', '<span class=\\"small\\">{datum} </span><a class=\\"small\\" href=\\"{url}\\">{titel}</a><br>', '<b>Allgemein</b><br>\r\n<a class="small" href="{virtualhost}?go=news">- News</a><br>\r\n<a class="small" href="{virtualhost}?go=newsarchiv">- News Archiv</a><br>\r\n<a class="small" href="{virtualhost}?go=pollarchiv">- Umfragen Archiv</a><br>\r\n<a class="small" href="{virtualhost}?go=shop">- Shop</a><br>\r\n<a class="small" href="{virtualhost}?go=screenshots">- Screenshots</a><br>\r\n<a class="small" href="{virtualhost}?go=map">- Community Map</a><br>\r\n<a class="small" href="{virtualhost}?go=download">- Downloads</a><br>', '<div class=\\"news_head\\" style=\\"height:10px;\\">\r\n    <span style=\\"float:left;\\">\r\n        <b>{titel}</b>\r\n    </span>\r\n    <span class=\\"small\\" style=\\"float:right;\\">\r\n        <b>{datum}</b>\r\n    </span>\r\n</div>\r\n<div style=\\"padding:3px;\\">\r\n    <table border=\\"0\\" cellpadding=\\"0\\" cellspacing=\\"0\\" width=\\"100%\\">\r\n        <tr>\r\n            <td align=\\"left\\" valign=\\"top\\">\r\n                {autor_avatar}\r\n            </td>\r\n            <td valign=\\"top\\" align=\\"left\\">\r\n                {text}\r\n            </td>\r\n        </tr>\r\n    </table>\r\n</div>\r\n<div class=\\"news_footer\\">\r\n    <span class=\\"small\\" style=\\"float:right;\\">\r\n        geschrieben von: {autor}</a>\r\n    </span>\r\n</div>\r\n<br /><br /><br />', '<a class=\\"small\\" href=\\"{url}\\">{name}</a>', '<script type=\\"text/javascript\\"> \r\n<!-- \r\n    function chkFormular() \r\n    {\r\n        if((document.getElementById(\\"name\\").value == \\"\\") ||\r\n           (document.getElementById(\\"title\\").value == \\"\\") ||\r\n           (document.getElementById(\\"text\\").value == \\"\\"))\r\n        {\r\n            alert (\\"Du hast nicht alle Felder ausgefüllt\\"); \r\n            return false;\r\n        }\r\n    } \r\n//--> \r\n</script> \r\n\r\n<b id=\\"add\\">Kommentar hinzufügen</b><p>\r\n<div>\r\n    <form action=\\"\\" method=\\"post\\" onSubmit=\\"return chkFormular()\\">\r\n        <input type=\\"hidden\\" name=\\"go\\" value=\\"comments\\">\r\n        <input type=\\"hidden\\" name=\\"addcomment\\" value=\\"1\\">\r\n        <input type=\\"hidden\\" name=\\"id\\" value=\\"{newsid}\\">\r\n        <table width=\\"100%\\"> \r\n            <tr>\r\n                <td align=\\"left\\">\r\n                    <b>Name: </b>\r\n                </td>\r\n                <td align=\\"left\\">\r\n                    {name_input}\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td align=\\"left\\">\r\n                    <b>Titel: </b>\r\n                </td>\r\n                <td align=\\"left\\">\r\n                    <input class=\\"text\\" name=\\"title\\" id=\\"title\\" size=\\"32\\" maxlength=\\"32\\">\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td align=\\"left\\" valign=\\"top\\">\r\n                    <b>Text:</b>\r\n                </td>\r\n                <td align=\\"left\\">\r\n                    <textarea rows=\\"8\\" cols=\\"50\\" class=\\"text\\" id=\\"text\\" name=\\"text\\"></textarea>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td></td>\r\n                <td align=\\"left\\">\r\n                    <input class=\\"button\\" type=\\"submit\\" value=\\"Absenden\\">\r\n                </td>\r\n            </tr>\r\n        </table>\r\n    </form>\r\n</div><p>', '<input class=\\"text\\" name=\\"name\\" id=\\"name\\" size=\\"32\\" maxlength=\\"25\\">\r\n<span class=\\"small\\"> Willst du dich </span>\r\n<a class=\\"small\\" href=\\"?go=login\\">einloggen?</a>', '<script type=\\"text/javascript\\"> \r\n<!-- \r\n    function chkFormular() \r\n    {\r\n        if (document.getElementById(\\"keyword\\").value.length < \\"4\\")\r\n        {\r\n            alert(\\"Es müssen mehr als 3 Zeichen sein\\"); \r\n            return false;\r\n        }\r\n    } \r\n//--> \r\n</script> \r\n\r\n<b>NEWSARCHIV</b><p>\r\n<div>\r\n    <form action=\\"\\" method=\\"post\\">\r\n        <input type=\\"hidden\\" name=\\"go\\" value=\\"newsarchiv\\">\r\n        <b>News aus dem: </b>\r\n        <select class=\\"text\\" name=\\"monat\\">\r\n            <option value=\\"1\\">Januar</option>\r\n            <option value=\\"2\\">Februar</option>\r\n            <option value=\\"3\\">März</option>\r\n            <option value=\\"4\\">April</option>\r\n            <option value=\\"5\\">Mai</option>\r\n            <option value=\\"6\\">Juni</option>\r\n            <option value=\\"7\\">Juli</option>\r\n            <option value=\\"8\\">August</option>\r\n            <option value=\\"9\\">September</option>\r\n            <option value=\\"10\\">Oktober</option>\r\n            <option value=\\"11\\">November</option>\r\n            <option value=\\"12\\">Dezember</option>\r\n        </select>\r\n        <select class=\\"text\\" name=\\"jahr\\">\r\n            {years}\r\n        </select>\r\n        <input class=\\"button\\" type=\\"submit\\" value=\\"Anzeigen\\">\r\n    </form>\r\n    <p>\r\n    oder\r\n    <p>\r\n    <form action=\\"\\" method=\\"post\\" onSubmit=\\"return chkFormular()\\">\r\n        <input type=\\"hidden\\" name=\\"go\\" value=\\"newsarchiv\\">\r\n        <b>Nach: </b>\r\n        <input class=\\"text\\" id=\\"keyword\\" name=\\"keyword\\" size=\\"30\\" maxlength=\\"20\\">\r\n        <input class=\\"button\\" type=\\"submit\\" value=\\"Suchen\\">\r\n    </form>\r\n</div>\r\n<p></p>', '<b>{titel}</b><br>\r\n{meldung}\r\n<p></p>', '<b>NEWS</b><p>\r\n<div>\r\n    <b>Headlines:</b><br>\r\n    {headlines}\r\n</div>\r\n<div>\r\n    <b>Downloads:</b><br>\r\n    {downloads}\r\n</div>\r\n<p>', '<tr>\r\n    <b>Einloggen</b>\r\n</tr>\r\n<tr>\r\n    <td align=\\"center\\">\r\n        <form action=\\"\\" method=\\"post\\">\r\n            <input type=\\"hidden\\" name=\\"go\\" value=\\"login\\">\r\n            <input type=\\"hidden\\" name=\\"login\\" value=\\"1\\">\r\n            <table align=\\"center\\" border=\\"0\\" cellpadding=\\"0\\" cellspacing=\\"0\\" width=\\"120\\">\r\n                <tr>\r\n                    <td align=\\"right\\">\r\n                        <font class=\\"small\\">Name:</font>\r\n                    </td>\r\n                    <td>\r\n                        <input class=\\"text\\" size=\\"10\\" name=\\"username\\" maxlength=\\"100\\">\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <td align=\\"right\\">\r\n                        <font class=\\"small\\">Pass:</font>\r\n                    </td>\r\n                    <td>\r\n                        <input class=\\"text\\" size=\\"10\\" type=\\"password\\" name=\\"userpassword\\" maxlength=\\"16\\">\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <td align=\\"center\\" colspan=\\"2\\">\r\n                        <input type=\\"checkbox\\" name=\\"stayonline\\" value=\\"1\\" checked>\r\n                        <font class=\\"small\\">eingelogt bleiben</font>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <td align=\\"center\\" colspan=\\"2\\">\r\n                        <input class=\\"button\\" type=\\"submit\\" value=\\"Anmelden\\">\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <td colspan=\\"2\\" align=\\"center\\">\r\n                        <a class=\\"small\\" href=\\"?go=register\\">Noch nicht registriert?</a>\r\n                    </td>\r\n                </tr>\r\n            </table>\r\n        </form>\r\n    </td>\r\n</tr>', '<b>SHOP</b><p>\r\n<table width="100%">\r\n    {artikel}\r\n</table>', '<tr>\r\n    <td align="left" valign="top" width="60" rowspan="4">\r\n        <img border="0" style="cursor:pointer;" onClick=open(''showimg.php?pic={bild}'',''Picture'',''width=900,height=710,screenX=0,screenY=0'') src="{thumbnail}">\r\n    </td>\r\n    <td align="left" width="100">\r\n        <b>Titel:</b>\r\n    </td>\r\n        <td align="left">\r\n            {titel}\r\n        </td>\r\n    </tr>\r\n<tr>\r\n    <td align="left" valign="top">\r\n        <b>Beschreibung:</b>\r\n    </td>\r\n    <td align="left" valign="top">\r\n        {beschreibung}</td>\r\n    </tr>\r\n<tr>\r\n    <td align="left">\r\n        <b>Preis:</b>\r\n    </td>\r\n    <td align="left">\r\n        {preis} ¤\r\n    </td>\r\n</tr>\r\n<tr>\r\n    <td align="left"></td>\r\n    <td align="left">\r\n        <a href="{bestell_url}" target="_blank">Jetzt bestellen!</a>\r\n    </td>\r\n</tr>\r\n<tr>\r\n    <td colspan="3">\r\n         \r\n    </td>\r\n</tr>', '<img border="0" src="images/design/{icon}">\r\n<a href="{kategorie_url}">{kategorie_name}</a><br>', '<form action="" method="get">\r\n<tr>\r\n  <td colspan="3" align="right"><br /> <b>Kategorie durchsuchen:</b></td>\r\n  <td colspan="1" align="left"><br /> \r\n    <input class="text" size="20" name="keyword" value="{keyword}">\r\n    <input class="button" type="submit" value="Go">\r\n    <input class="button" type="button" value="Alle anzeigen" onclick="location=''{all_url}''">\r\n    <input type="hidden" name="go" value="download">\r\n    {input_cat}</td>\r\n</tr>\r\n\r\n</form>', '<b>DOWNLOADS</b><p>\r\n{navigation}\r\n<table border="0" cellpadding="0" cellspacing="2" width="100%">\r\n<tr>\r\n  <td style="border: 1px solid #000000; padding: 3px;"><strong>Titel</strong></td>\r\n  <td style="border: 1px solid #000000; padding: 3px;"><strong>Kategorie</strong></td>\r\n  <td style="border: 1px solid #000000; padding: 3px;"><strong>Uploaddatum</strong></td>\r\n  <td style="border: 1px solid #000000; padding: 3px;"><strong>Beschreibung</strong></td>\r\n </tr>\r\n{dateien}\r\n{suchfeld}\r\n</table>', '<tr>\r\n  <td style="border: 1px solid #000000; padding: 3px;"><a href="{url}"><b>{name}</b></a></td>\r\n  <td style="border: 1px solid #000000; padding: 3px;" align="center" valign="middle">{cat}</td>\r\n  <td style="border: 1px solid #000000; padding: 3px;" align="center" valign="middle">{datum}</td>\r\n  <td style="border: 1px solid #000000; padding: 3px;">{text}</td>\r\n </tr>', '<b>DOWNLOADS -> {titel}</b><p>\r\n{navigation}\r\n    <table width="100%">\r\n        <tr>\r\n            <td align="left" width="130" rowspan="6" valign="top">\r\n                <img class="thumb" onClick=open(''showimg.php?pic={bild}'',''Picture'',''width=900,height=710,screenX=0,screenY=0'') src="{thumbnail}">\r\n            </td>\r\n        </tr>\r\n         <tr>\r\n            <td align="left" colspan="2" height="20" valign="top">\r\n                <b>{titel}</b>\r\n            </td>\r\n        </tr>\r\n       <tr>\r\n            <td align="left" width="75">\r\n                <b>Kategorie:</b>\r\n            </td>\r\n            <td align="left">\r\n                {cat}\r\n            </td>\r\n        </tr>\r\n       <tr>\r\n            <td align="left" width="75">\r\n                <b>Datum:</b>\r\n            </td>\r\n            <td align="left">\r\n                {datum}\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td align="left" width="75">\r\n                <b>Uploader:</b>\r\n            </td>\r\n            <td align="left">\r\n                <a href="{uploader_url}">{uploader}</a>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td align="left" width="75">\r\n                <b>Autor:</b>\r\n            </td>\r\n            <td align="left">\r\n                {autor_link}\r\n            </td>\r\n        </tr>\r\n    </table>\r\n    <br>\r\n    <table width="100%">\r\n        <tr>\r\n            <td align="left" valign="top" width="130">\r\n                <b>Beschreibung:</b>\r\n            </td>\r\n            <td align="left">\r\n                {text}\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan="2"></td>\r\n        </tr>\r\n        <tr>\r\n             <td align="left" valign="top">\r\n                 <b>Dateien:</b>\r\n             </td>\r\n             <td align="left">{messages}\r\n             </td>\r\n         </tr>\r\n         <tr>\r\n             <td colspan="2"></td>\r\n         </tr>\r\n    </table>\r\n\r\n<table border="0" cellpadding="0" cellspacing="2" width="100%">\r\n<tr>\r\n  <td style="border: 1px solid #000000; padding: 3px;" colspan="2" ><strong>Datei (Download)</strong></td>\r\n  <td style="border: 1px solid #000000; padding: 3px;"><strong>Größe</strong></td>\r\n  <td style="border: 1px solid #000000; padding: 3px;"><strong>Traffic</strong></td>\r\n  <td style="border: 1px solid #000000; padding: 3px;"><strong>Downloads</strong></td>\r\n</tr>\r\n{files}\r\n<tr>\r\n  <td colspan="5" style="border: 1px solid #000000; padding: 3px;"><img alt="" src="images/design/null.gif"></td>\r\n</tr>\r\n{stats}\r\n</table>', '<tr>\r\n  <td style="border: 1px solid #000000; padding: 3px;"{mirror_col}><a target="_blank" href="{url}"><b>{name}</b></a></td>{mirror_ext}\r\n  <td style="border: 1px solid #000000; padding: 3px;">{size}</td>\r\n  <td style="border: 1px solid #000000; padding: 3px;">{traffic}</td>\r\n  <td style="border: 1px solid #000000; padding: 3px;">{hits}</td>\r\n</tr>', '<td style="border: 1px solid #000000; padding: 3px;" align="center" valign="middle"><b>Mirror!</b></td>', '<tr>\r\n              <td style="border: 1px solid #000000; padding: 3px;" colspan="2" >{number}</strong></td>\r\n              <td style="border: 1px solid #000000; padding: 3px;">{size}</td>\r\n              <td style="border: 1px solid #000000; padding: 3px;">{traffic}</td>\r\n              <td style="border: 1px solid #000000; padding: 3px;">{hits}</td>\r\n              </tr>', '<span class="small">{datum} </span><a class="small" href="{url}">{name}</a><br>', '<td class="small" align="center" valign="top">\r\n    <img class="thumb" onClick="open(''{url}'',''Picture'',''width=950,height=710,screenX=0,screenY=0'')" src="{thumbnail}" alt="{text}"><br>\r\n    {text}\r\n</td>', '<b>SCREENSHOT KATEGORIEN</b><p>\r\n<table width="100%">\r\n{kategorien}\r\n</table>', '<tr>\r\n    <td align="left">\r\n        <a href="{url}">{name}</a>\r\n    </td>\r\n    <td align="left">\r\n        erstellt am {datum}\r\n    </td>\r\n    <td align="left">\r\n        {menge} Bilder\r\n    </td>\r\n</tr>', '<b>SCREENSHOTS: {titel}</b><p>\r\n<table border="0" cellpadding="" cellspacing="10" width="100%">\r\n{screenshots}\r\n</table>', '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">\r\n<html>\r\n<head>\r\n    <title>Dungeon-Lords</title>\r\n    <link rel="stylesheet" type="text/css" href="inc/dl.css">\r\n    <meta name="keywords" content="Dungeon, Lords, Dungeon Lords, RPG, Rollenspiel, Schwerter, Fantasy, Game, Spiel, news, demo, lösung, tipps, fanseite, offiziell, screenshots, forum, downloads, download, videos, trailer">\r\n</head>\r\n<body>\r\n    <div align="center">\r\n        <table border="0" cellpadding="0" cellspacing="0" width="900" style="background-image:url(images/design/sp_bg.jpg); height:710px">\r\n            <tr>\r\n                <td width="900" colspan="3" style="background-image:url(images/design/sp_bn_o.jpg);" height="16"></td>\r\n            </tr>\r\n            <tr>\r\n                <td width="90" style="background-image:url(images/design/sp_bn_l.jpg);" height="60"></td>\r\n                <td width="468" height="60" bgcolor="#000000">{bannercode}</td>\r\n                <td width="342" style="background-image:url(images/design/sp_bn_r.jpg);" height="60"></td>\r\n            </tr>\r\n            <tr>\r\n                <td width="900" colspan="3" style="background-image:url(images/design/sp_bn_u.jpg);" height="14"></td>\r\n            </tr>\r\n            <tr>\r\n                <td width="900" style="background-image:url(images/design/loading.gif);" align="center" colspan="3" height="620">\r\n                    <table border="0" cellpadding="0" cellspacing="0">\r\n                        <tr>\r\n                            <td>{zurück_grafik}</td>\r\n                            <td width="300" height="200">\r\n                                <img src="{bild}" onclick="javascipt:self.close();" border="0" alt="{text}"></td>\r\n                            <td>{weiter_grafik}</td>\r\n                        </tr>\r\n                    </table>\r\n                    <b>{text}</b>\r\n                </td>\r\n            </tr>\r\n        </table>\r\n    </div>\r\n</body>\r\n</html>', '<b>Willkommen {username}</b><br>\r\n<a class=\\"small\\" href=\\"{virtualhost}?go=editprofil\\">- Mein Profil</a><br>\r\n{admin}\r\n<a class=\\"small\\" href=\\"{virtualhost}?go=logout\\">- Logout</a>', '<a class=\\''small\\'' href=\\''{virtualhost}admin\\''>- Admin-CP</a><br />', '<div class=\\"field_head\\" style=\\"padding-left:60px; width:516px;\\">\r\n    <font class=\\"h1\\" style=\\"float:left; padding-top:14px;\\">Login</font>\r\n</div>\r\n<div class=\\"field_middle\\" align=\\"left\\">\r\n    <form action=\\"\\" method=\\"post\\">\r\n        <input type=\\"hidden\\" name=\\"go\\" value=\\"login\\">\r\n        <input type=\\"hidden\\" name=\\"login\\" value=\\"1\\">\r\n        <table align=\\"center\\" border=\\"0\\" cellpadding=\\"4\\" cellspacing=\\"0\\">\r\n            <tr>\r\n                <td align=\\"right\\">\r\n                    <b>Name:</b>\r\n                </td>\r\n                <td>\r\n                    <input class=\\"text\\" size=\\"33\\" name=\\"username\\" maxlength=\\"100\\">\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td align=\\"right\\">\r\n                    <b>Passwort:</b>\r\n                </td>\r\n                <td>\r\n                    <input class=\\"text\\" size=\\"33\\" type=\\"password\\" name=\\"userpassword\\" maxlength=\\"16\\">\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td align=\\"right\\">\r\n                    <b>Angemeldet bleiben:</b>\r\n                </td>\r\n                <td>\r\n                    <input type=\\"checkbox\\" name=\\"stayonline\\" value=\\"1\\" checked>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td colspan=\\"2\\" align=\\"center\\">\r\n                    <input class=\\"button\\" type=\\"submit\\" value=\\"Login\\">\r\n                </td>\r\n            </tr>\r\n        </table>\r\n    </form>\r\n    <p>\r\n    Du hast dich noch nicht registriert? Dann wirds jetzt aber Zeit ;) -> \r\n    <a href=\\"?go=register\\">registrieren</a>\r\n    <p>\r\n</div>\r\n<div class=\\"field_footer\\"></div>\r\n<p></p>', '<b>PROFIL ÄNDERN ({username})</b><p>\r\n<form action=\\"\\" method=\\"post\\" enctype=\\"multipart/form-data\\">\r\n    <input type=\\"hidden\\" name=\\"go\\" value=\\"editprofil\\">\r\n    <table align=\\"center\\" border=\\"0\\" cellpadding=\\"4\\" cellspacing=\\"0\\">\r\n        <tr>\r\n            <td width=\\"50%\\" valign=\\"top\\">\r\n                <b>Benutzerbild:</b>\r\n            </td>\r\n            <td width=\\"50%\\">\r\n                {avatar}\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td>\r\n                <b>Benutzerbild hochladen:</b><br>\r\n                <font class=\\"small\\">Nur wenn das alte überschrieben werden soll (max 110x110 px)</font>\r\n            </td>\r\n            <td>\r\n                <input class=\\"text\\" size=\\"16\\" type=\\"file\\" name=\\"userpic\\">\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td>\r\n                <b>E-Mail:</b><br>\r\n                <font class=\\"small\\">Deine E-Mail Adresse</font>\r\n            </td>\r\n            <td>\r\n                <input class=\\"text\\" size=\\"34\\" value=\\"{email}\\" name=\\"usermail\\" maxlength=\\"100\\">\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td>\r\n                <b>E-Mail zeigen:</b><br>\r\n                <font class=\\"small\\">Zeige die E-Mail im öffentlichen Profil</font>\r\n            </td>\r\n            <td>\r\n                <input value=\\"1\\" name=\\"showmail\\" type=\\"checkbox\\" {email_zeigen}>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td>\r\n                <b>Neues Passwort:</b><br>\r\n                <font class=\\"small\\">Nur eintragen, wenn du ein neues Passwort erstellen willst</font>\r\n            </td>\r\n            <td>\r\n                <input class=\\"text\\" size=\\"33\\" type=\\"password\\" name=\\"userpassword\\" maxlength=\\"16\\">\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan=\\"2\\" align=\\"center\\">\r\n                <input class=\\"button\\" type=\\"submit\\" value=\\"Absenden\\">\r\n            </td>\r\n        </tr>\r\n    </table>\r\n</form>', '<div class="field_head" style="padding-left:60px; width:516px;">\r\n    <font class="h1" style="float:left; padding-top:14px;">Community Map</font>\r\n</div>\r\n<div class="field_middle" align="left">\r\n    {karte}\r\n    <div align="right">\r\n        <font class="small">Zum betrachten der Karte wird Flash benötigt: </font><br>\r\n        <img border="0" src="images/design/flash_rune.gif" align="middle">\r\n        <a target="_blank" href="http://www.adobe.com/go/getflashplayer">\r\n            <img border="0" src="images/design/flash_download_now.gif" align="middle">\r\n        </a>\r\n    </div>\r\n</div>\r\n<div class="field_footer"></div>\r\n<p></p>', '<form name=\\"poll\\" action=\\"\\" method=\\"post\\">\r\n    <input type=\\"hidden\\" name=\\"pollid\\" value=\\"{poll_id}\\">\r\n    <table align=\\"center\\" border=\\"0\\" cellpadding=\\"0\\" cellspacing=\\"0\\" width=\\"100%\\">\r\n        <tr>\r\n            <td class=\\"small\\" colspan=\\"2\\" align=\\"center\\">\r\n                <b>{question}</b>\r\n            </td>\r\n        </tr>\r\n{answers}\r\n        <tr>\r\n            <td colspan=\\"2\\" align=\\"center\\" ><br />\r\n                <input class=\\"button\\" type=\\"submit\\" value=\\"Abstimmen\\" {button_state}><br />\r\n<a class=\\"small\\" href=\\"?go=pollarchiv&pollid={poll_id}\\"><b>Ergebnis anzeigen!</b></a>\r\n            </td>\r\n        </tr>\r\n    </table>\r\n</form>', '<tr>\r\n    <td valign=\\"top\\">\r\n        <input type=\\"{type}\\" name=\\"answer{multiple}\\" value=\\"{answer_id}\\">\r\n    </td>\r\n    <td align=\\"left\\" class=\\"small\\">\r\n        {answer}\r\n    </td>\r\n</tr>', '<b>UMFRAGEN ARCHIV</b><p>\r\n<b>{frage}</b><p>\r\n<table width=\\"100%\\">\r\n{antworten}\r\n   <tr><td> </td></tr>\r\n   <tr><td align=\\"left\\">Anzahl der Teilnehmer: </td><td align=\\"left\\" colspan=\\"2\\"><b>{participants}</b></td></tr>\r\n   <tr><td align=\\"left\\">Anzahl der Stimmen: </td><td align=\\"left\\" colspan=\\"2\\"><b>{stimmen}</b></td></tr>\r\n   <tr><td align=\\"left\\">Art der Umfrage: </td><td align=\\"left\\" colspan=\\"2\\">{typ}</td></tr>\r\n   <tr><td align=\\"left\\">Umfragedauer:</td><td align=\\"left\\" colspan=\\"2\\">{start_datum} bis {end_datum}</td></tr>\r\n</table>', '<tr>\r\n    <td align=\\"left\\">{antwort}</td>\r\n    <td align=\\"left\\">{stimmen}</td>\r\n    <td align=\\"left\\">\r\n        <div style=\\"width:{balken_breite}px; height:4px; font-size:1px; background-color:#00FF00;\\">\r\n    </td>\r\n</tr>', '<table align=\\"center\\" border=\\"0\\" cellpadding=\\"0\\" cellspacing=\\"0\\" width=\\"100%\\">\r\n    <tr>\r\n        <td class=\\"small\\" colspan=\\"2\\" align=\\"center\\">\r\n            <b>{question}</b>\r\n        </td>\r\n    </tr>\r\n{answers}\r\n</table>\r\n<div class=\\"small\\">Teilnehmer: {participants}</div>\r\n<b>Bereits abgestimmt!</b>', '<tr>\r\n    <td align=\\"left\\" class=\\"small\\" colspan=\\"2\\">\r\n        {answer}\r\n    </td>\r\n</tr>\r\n<tr>\r\n    <td align=\\"left\\" class=\\"small\\">\r\n        {percentage}\r\n    </td>\r\n    <td align=\\"left\\">\r\n        <div style=\\"width:{bar_width}px; height:4px; font-size:1px; background-color:#00FF00;\\">\r\n    </td>\r\n</tr>', '<b>UMFRAGEN ARCHIV</b><p>\r\n<table border=\\"0\\" width=\\"100%\\" cellpadding=\\"2\\" cellspacing=\\"0\\">\r\n<tr>\r\n  <td align=\\"left\\"><a href=\\"?go=pollarchiv&sort=name_{order_name}\\" style=\\"color: #000\\"><b>Frage {arrow_name}</b></a></td>\r\n  <td align=\\"left\\" width=\\"100\\"><a href=\\"?go=pollarchiv&sort=voters_{order_voters}\\" style=\\"color: #000\\"><b>Teilnehmer {arrow_voters}</b></a></td>\r\n  <td align=\\"left\\" width=\\"70\\"><a href=\\"?go=pollarchiv&sort=startdate_{order_startdate}\\" style=\\"color: #000\\"><b>von {arrow_startdate}</b></a></td>\r\n  <td align=\\"left\\" width=\\"10\\"></td>\r\n  <td align=\\"left\\" width=\\"70\\"><a href=\\"?go=pollarchiv&sort=enddate_{order_enddate}\\" style=\\"color: #000\\"><b>bis {arrow_enddate}</b></a></td>\r\n</tr>\r\n{umfragen}\r\n</table>\r\n<p>', '  <tr>\r\n   <td align=\\"left\\"><a href=\\"{url}\\">{frage}</a></td>\r\n   <td align=\\"left\\">{voters}</td>\r\n   <td align=\\"left\\" class=\\"small\\">{start_datum}</td>\r\n   <td align=\\"left\\" class=\\"small\\">-</td>\r\n   <td align=\\"left\\" class=\\"small\\">{end_datum}</td>\r\n  </tr>', '<div class=\\"small\\" align=\\"center\\">\r\n    Zur Zeit keine<br>Umfrage aktiv\r\n</div>', '<b>PROFIL VON {username}</b><p>\r\n<table align=\\"center\\" border=\\"0\\" cellpadding=\\"4\\" cellspacing=\\"0\\">\r\n    <tr>\r\n        <td width=\\"50%\\" valign=\\"top\\">\r\n            <b>Benutzerbild:</b>\r\n        </td>\r\n        <td width=\\"50%\\">\r\n            {avatar}\r\n        </td>\r\n    </tr>\r\n    <tr>\r\n        <td>\r\n            <b>E-Mail:</b>\r\n        </td>\r\n        <td>\r\n            {email}\r\n        </td>\r\n    </tr>\r\n    <tr>\r\n        <td>\r\n            <b>Registriert seit:</b>\r\n        </td>\r\n        <td>\r\n            {reg_datum}\r\n        </td>\r\n    </tr>\r\n    <tr>\r\n        <td>\r\n            <b>Geschriebene Kommentare:</b>\r\n        </td>\r\n        <td>\r\n            {kommentare}\r\n        </td>\r\n    </tr>\r\n    <tr>\r\n        <td>\r\n            <b>Geschriebene News:</b>\r\n        </td>\r\n        <td>\r\n            {news}\r\n        </td>\r\n    </tr>\r\n    <tr>\r\n        <td>\r\n            <b>Geschriebene Artikel:</b>\r\n        </td>\r\n        <td>\r\n            {artikel}\r\n        </td>\r\n    </tr>\r\n</table>', '- <b>{visits}</b> Visits<br>\r\n- <b>{visits_heute}</b> Visits heute<br>\r\n- <b>{hits}</b> Hits<br>\r\n- <b>{hits_heute}</b> Hits heute<br>\r\n- <b>{user_online}</b> Besucher online<p>\r\n- <b>{user}</b> registrierte User<br>\r\n- <b>{news}</b> News<br>\r\n- <b>{kommentare}</b> Kommentare<br>\r\n- <b>{artikel}</b> Artikel', '<script type=\\"text/javascript\\"> \r\n<!-- \r\nfunction chkFormular() \r\n{\r\n    if((document.getElementById(\\"username\\").value == \\"\\") ||\r\n       (document.getElementById(\\"usermail\\").value == \\"\\") ||\r\n       (document.getElementById(\\"userpass1\\").value == \\"\\") ||\r\n       (document.getElementById(\\"userpass2\\").value == \\"\\"))\r\n    {\r\n        alert(\\"Du hast nicht alle Felder ausgefüllt\\"); \r\n        return false;\r\n    }\r\n    if(document.getElementById(\\"userpass1\\").value != document.getElementById(\\"userpass2\\").value)\r\n    {\r\n        alert(\\"Passwöter sind verschieden\\"); \r\n        return false;\r\n    }\r\n} \r\n//--> \r\n</script> \r\n\r\n<b>REGISTRIEREN</b><p>\r\n<div>\r\n    Registriere dich im Frog System, um in den Genuss erweiterter Features zu kommen. Dazu zählen bisher:\r\n    <ul>\r\n        <li>Zugriff auf unsere Downloads</li>\r\n        <li>Hochladen eines eigenen Benutzerbildes, für die von dir geschriebenen Kommentare</li>\r\n    </ul>\r\n    Weitere Features werden folgen.\r\n    <p>\r\n    <form action=\\"\\" method=\\"post\\" onSubmit=\\"return chkFormular()\\">\r\n        <input type=\\"hidden\\" value=\\"register\\" name=\\"go\\">\r\n        <table border=\\"0\\" cellpadding=\\"2\\" cellspacing=\\"0\\" align=\\"center\\">\r\n            <tr>\r\n                <td align=\\"right\\">\r\n                    <b>Name:</b>\r\n                </td>\r\n                <td>\r\n                    <input class=\\"text\\" size=\\"30\\" name=\\"username\\" id=\\"username\\" maxlength=\\"100\\">\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td align=\\"right\\">\r\n                    <b>Passwort:</b>\r\n                </td>\r\n                <td>\r\n                    <input class=\\"text\\" size=\\"30\\" name=\\"userpass1\\" id=\\"userpass1\\" type=\\"password\\" maxlength=\\"16\\">\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td align=\\"right\\">\r\n                    <b>Passwort wiederholen:</b>\r\n                </td>\r\n                <td>\r\n                    <input class=\\"text\\" size=\\"30\\" name=\\"userpass2\\" id=\\"userpass2\\" type=\\"password\\" maxlength=\\"16\\">\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td align=\\"right\\">\r\n                    <b>E-Mail:</b>\r\n                </td>\r\n                <td>\r\n                    <input class=\\"text\\" size=\\"30\\" name=\\"usermail\\" id=\\"usermail\\" maxlength=\\"100\\">\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td colspan=\\"2\\" align=\\"center\\">\r\n                    <input type=\\"submit\\" class=\\"button\\" value=\\"Registrieren\\">\r\n                </td>\r\n            </tr>\r\n        </table>\r\n    </form>\r\n    <p>\r\n</div>', '<div class=\\"news_head\\" style=\\"height:10px;\\" id =\\"{newsid}\\">\r\n    <span style=\\"float:left;\\">\r\n        <img src=\\"{kategorie_bildname}\\" alt=\\"\\"><b>[{kategorie_name}] {titel}</b>\r\n    </span>\r\n    <span class=\\"small\\" style=\\"float:right;\\">\r\n        <b>{datum}</b>\r\n    </span>\r\n</div>\r\n<div style=\\"padding:3px;\\">\r\n    {text}\r\n    {related_links}\r\n</div>\r\n<div class=\\"news_footer\\">\r\n    <span class=\\"small\\" style=\\"float:left;\\">\r\n        <a class=\\"small\\" href=\\"{kommentar_url}\\">Kommentare ({kommentar_anzahl})</a>\r\n    </span>\r\n    <span class=\\"small\\" style=\\"float:right;\\">\r\n        geschrieben von: <a class=\\"small\\" href=\\"{autor_profilurl}\\">{autor}</a>\r\n    </span>\r\n</div>\r\n<br><br>', '<b>Ankündigung:</b>\r\n<br><br>\r\n    {meldung}\r\n<br><br>', 'Hallo {username}\r\n\r\nDu hast dich im Frog System registriert. Deine Logindaten sind:\r\nUsername: {username}\r\nPasswort: {passwort}', 'Hallo {username}\r\n\r\nDein Passwort im Frog System wurde geändert.\r\nDas neue Lautet: {passwort}', 'hilfe', 'Partner:\r\n{partner}', '<div align="center">\r\n  <a href="{url}" target="_blank">\r\n    <img src="{bild}" border="0" alt="{name}"  title="{name}">\r\n  </a>\r\n  <br>\r\n</div>', '{permanents}\r\n\r\n<div align="center"><br><b>\r\nZufallsauswahl:</b><br>\r\n\r\n{non-permanents}\r\n\r\n<a href="?go=partner">alle Partner</a></div><br>', '<b>Members List</b><br />\r\n<table width="50%" align="center" cellpadding="0" cellspacing="0" border="0">\r\n<tr>\r\n  <td><b>Username</b></td>\r\n  <td><b>Join date</b></td>\r\n  <td><b>E-Mail</b></td>\r\n</tr>\r\n{members}\r\n</table>', '<tr>\r\n  <td><a href="?go=profil&userid={user_id}" class="small">{user_name}</a></td>\r\n  <td>{reg_date}</td>\r\n  <td>{user_mail}</td>\r\n</tr>', '<tr>\r\n  <td><a href="?go=profil&userid={user_id}" class="small"><b><i>{user_name}</i></b></a></td>\r\n  <td>{reg_date}</td>\r\n  <td>{user_mail}</td>\r\n</tr>', '<table cellpadding="5" align="center" border="0" width="90%">\r\n<tr><td><b><font face="verdana" size="2">Code:</font></b></td></tr>\r\n<tr><td style="border-collapse: collapse; border-style: dotted; border-color:#000000; border-width: 1"><font face="Courier New">{text}</font>\r\n</td></tr></table>', '<table cellpadding="5" align="center" border="0" width="90%">\r\n<tr><td><b><font face="verdana" size="2">Zitat:</font></b></td></tr>\r\n<tr><td style="border-collapse: collapse; border-style: dotted; border-color:#000000; border-width: 1">{text}\r\n</td></tr></table>', '<table cellpadding="5" align="center" border="0" width="90%">\r\n<tr><td><b><font face="verdana" size="2">Zitat von {author}:</font></b></td></tr>\r\n<tr><td style="border-collapse: collapse; border-style: dotted; border-color:#000000; border-width: 1">{text}\r\n</td></tr></table>');

-- --------------------------------------------------------

-- 
-- Table structure for table `fs_user`
-- 

DROP TABLE IF EXISTS `fs_user`;
CREATE TABLE IF NOT EXISTS `fs_user` (
  `user_id` mediumint(8) NOT NULL auto_increment,
  `user_name` char(100) collate latin1_general_ci default NULL,
  `user_password` char(32) collate latin1_general_ci default NULL,
  `user_mail` char(100) collate latin1_general_ci default NULL,
  `is_admin` tinyint(4) NOT NULL default '0',
  `reg_date` int(11) default NULL,
  `show_mail` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=5 ;

-- 
-- Dumping data for table `fs_user`
-- 

REPLACE INTO `fs_user` (`user_id`, `user_name`, `user_password`, `user_mail`, `is_admin`, `reg_date`, `show_mail`) VALUES 
(1, 'Sweil', '4e65f3c20bc1f5a16bc62b7f4083e226', 'moritz@tolkien-fan.de', 1, 1215468000, 1),
(2, 'klick', '098f6bcd4621d373cade4e832627b4f6', 'e@mail.de', 1, 1157320800, 0),
(3, 'rockfest', '78a2794d1740863fef81b74bb91340b5', 'moritz@tolkien-fan.de', 1, 1156975994, 1),
(4, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@admin.de', 1, 1207260000, 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `fs_useronline`
-- 

DROP TABLE IF EXISTS `fs_useronline`;
CREATE TABLE IF NOT EXISTS `fs_useronline` (
  `ip` varchar(30) collate latin1_general_ci default NULL,
  `host` varchar(200) collate latin1_general_ci default NULL,
  `date` int(30) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- 
-- Dumping data for table `fs_useronline`
-- 

REPLACE INTO `fs_useronline` (`ip`, `host`, `date`) VALUES 
('127.0.0.1', NULL, 1182872982);

-- --------------------------------------------------------

-- 
-- Table structure for table `fs_wallpaper`
-- 

DROP TABLE IF EXISTS `fs_wallpaper`;
CREATE TABLE IF NOT EXISTS `fs_wallpaper` (
  `wallpaper_id` mediumint(8) NOT NULL auto_increment,
  `wallpaper_name` varchar(255) collate latin1_general_ci NOT NULL default '',
  `wallpaper_title` varchar(255) collate latin1_general_ci NOT NULL default '',
  `cat_id` mediumint(8) NOT NULL default '0',
  PRIMARY KEY  (`wallpaper_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci PACK_KEYS=1 AUTO_INCREMENT=21 ;

-- 
-- Dumping data for table `fs_wallpaper`
-- 

REPLACE INTO `fs_wallpaper` (`wallpaper_id`, `wallpaper_name`, `wallpaper_title`, `cat_id`) VALUES 
(20, 'forbiddencity', 'von ArenaNet', 6);

-- --------------------------------------------------------

-- 
-- Table structure for table `fs_wallpaper_sizes`
-- 

DROP TABLE IF EXISTS `fs_wallpaper_sizes`;
CREATE TABLE IF NOT EXISTS `fs_wallpaper_sizes` (
  `size_id` mediumint(8) NOT NULL auto_increment,
  `wallpaper_id` mediumint(8) NOT NULL default '0',
  `size` varchar(255) collate latin1_general_ci NOT NULL default '',
  PRIMARY KEY  (`size_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci PACK_KEYS=1 AUTO_INCREMENT=32 ;

-- 
-- Dumping data for table `fs_wallpaper_sizes`
-- 

REPLACE INTO `fs_wallpaper_sizes` (`size_id`, `wallpaper_id`, `size`) VALUES 
(27, 20, '1280x960'),
(30, 20, '1280x1024'),
(13, 20, '1600x1200'),
(31, 20, '800x600');

-- --------------------------------------------------------

-- 
-- Table structure for table `fs_zones`
-- 

DROP TABLE IF EXISTS `fs_zones`;
CREATE TABLE IF NOT EXISTS `fs_zones` (
  `id` mediumint(8) NOT NULL auto_increment,
  `name` varchar(30) collate latin1_general_ci NOT NULL,
  `design_id` mediumint(8) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci PACK_KEYS=0 AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `fs_zones`
-- 

REPLACE INTO `fs_zones` (`id`, `name`, `design_id`) VALUES 
(1, 'rot', 1),
(2, 'blau', 0);

