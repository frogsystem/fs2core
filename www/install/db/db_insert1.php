<?php

include("inc/install_login.php");
unset($template);


// fs_admin_cp
mysql_query("DROP TABLE IF EXISTS `".$pref."admin_cp`", $db);
mysql_query("CREATE TABLE `".$pref."admin_cp` (
  `page_id` varchar(255) NOT NULL,
  `group_id` mediumint(8) NOT NULL,
  `page_title` varchar(255) NOT NULL,
  `page_link` varchar(255) NOT NULL,
  `page_file` varchar(255) NOT NULL,
  `page_pos` tinyint(3) NOT NULL DEFAULT '0',
  `page_int_sub_perm` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`page_id`)
) TYPE=MyISAM", $db);
$template .= "<li><b>".$pref."admin_cp</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";
mysql_query("
INSERT INTO `".$pref."admin_cp` (`page_id`, `group_id`, `page_title`, `page_link`, `page_file`, `page_pos`, `page_int_sub_perm`) VALUES
('start_general', -1, 'Allgemein', 'general', 'start_general.php', 1, 0),
('start_content', -1, 'Inhalt', 'content', 'start_content.php', 2, 0),
('start_media', -1, 'Media', 'media', 'start_media.php', 3, 0),
('start_interactive', -1, 'Interaktiv', 'interactive', 'start_interactive.php', 4, 0),
('start_promo', -1, 'Promotion', 'promo', 'start_promo.php', 5, 0),
('start_user', -1, 'User', 'user', 'start_user.php', 6, 0),
('start_styles', -1, 'Styles', 'styles', 'start_styles.php', 7, 0),
('start_system', -1, 'System', 'system', 'start_system.php', 8, 0),
('start_mods', -1, 'AddOns', 'mods', 'start_mods.php', 9, 0),
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
('news_delete', 5, 'löschen', 'löschen', 'news_edit', 1, 1),
('news_add', 5, 'schreiben', 'schreiben', 'admin_news_add.php', 2, 0),
('news_comments', 5, 'Kommentare', 'Kommentare', 'news_edit', 2, 1),
('news_edit', 5, 'bearbeiten', 'bearbeiten', 'admin_news_edit.php', 3, 0),
('news_cat', 5, 'Kategorien verwalten', 'Kategorien', 'admin_news_cat.php', 4, 0),
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
('tpl_search', 22, '„Suche“ bearbeiten', 'Suche', 'admin_template_search.php', 3, 0),
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
('tpl_player', 22, '„Flash-Player“ bearbeiten', 'Flash-Player', 'admin_template_player.php', 20, 0),
('group_config', 23, 'Konfiguration ändern', 'Konfiguration', 'admin_group_config.php', 1, 0),
('group_admin', 23, 'Gruppenverwaltung', 'verwalten', 'admin_group_admin.php', 2, 0),
('group_rights', 23, 'Rechte ändern', 'Rechte', 'admin_group_rights.php', 3, 0),
('applets_add', 24, 'hinzufügen', 'hinzufügen', 'admin_applets_add.php', 1, 0),
('applets_delete', 24, 'löschen', 'löschen', 'applets_edit', 1, 1),
('applets_edit', 24, 'bearbeiten', 'bearbeiten', 'admin_applets_edit.php', 2, 0),
('snippets_add', 25, 'hinzufügen', 'hinzufügen', 'admin_snippets_add.php', 1, 0),
('snippets_delete', 25, 'löschen', 'löschen', 'snippets_edit', 1, 1),
('snippets_edit', 25, 'bearbeiten', 'bearbeiten', 'admin_snippets_edit.php', 2, 0),
('aliases_add', 26, 'hinzufügen', 'hinzufügen', 'admin_aliases_add.php', 1, 0),
('aliases_delete', 26, 'löschen', 'löschen', 'aliases_edit', 1, 1),
('aliases_edit', 26, 'bearbeiten', 'bearbeiten', 'admin_aliases_edit.php', 2, 0),
('search_config', 27, 'Konfiguration', 'Konfiguration', 'admin_search_config.php', 1, 0),
('search_index', 27, 'Suchindex', 'Suchindex', 'admin_search_index.php', 2, 0)
", $db);
$template .= "<li><b>".$pref."admin_cp</b> ".$_LANG[db_insert][fill]." ".check_mysqlerror(mysql_error())."</li>";


// fs_admin_groups
mysql_query("DROP TABLE IF EXISTS `".$pref."admin_groups`", $db);
mysql_query("CREATE TABLE `".$pref."admin_groups` (
  `group_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `group_title` text NOT NULL,
  `menu_id` varchar(20) NOT NULL,
  `group_pos` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`group_id`)
) TYPE=MyISAM  AUTO_INCREMENT=29", $db);
$template .= "<li><b>".$pref."admin_groups</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";
mysql_query("
INSERT INTO `".$pref."admin_groups` (`group_id`, `group_title`, `menu_id`, `group_pos`) VALUES
(5, 'News', 'content', 1),
(6, 'Artikel', 'content', 2),
(7, 'Presseberichte', 'content', 3),
(8, 'Inhaltsbilder', 'content', 4),
(1, 'Allgemein', 'general', 1),
(2, 'Editor', 'general', 2),
(3, 'Statistik', 'general', 3),
(27, 'Suche', 'general', 4),
(16, 'Umfragen', 'interactive', 1),
(17, 'Community Map', 'interactive', 2),
(9, 'Galerie', 'media', 1),
(10, 'Galerie-Bilder', 'media', 2),
(11, 'Wallpaper', 'media', 3),
(12, 'Zufallsbilder', 'media', 4),
(13, 'Zeitgesteuerte ZB', 'media', 5),
(14, 'Downloads', 'media', 6),
(15, 'Videos', 'media', 7),
(-1, 'Startseite', 'none', 0),
(28, 'hidden', 'none', 0),
(18, 'Partnerseiten', 'promo', 1),
(19, 'Shop', 'promo', 2),
(21, 'Styles', 'styles', 1),
(22, 'Templates', 'styles', 2),
(24, 'Applets', 'system', 2),
(25, 'Schnipsel', 'system', 3),
(26, 'Aliasse', 'system', 1),
(20, 'Benutzer', 'user', 1),
(23, 'Gruppen', 'user', 2)
", $db);
$template .= "<li><b>".$pref."admin_groups</b> ".$_LANG[db_insert][fill]." ".check_mysqlerror(mysql_error())."</li>";


// fs_aliases
mysql_query("DROP TABLE IF EXISTS `".$pref."aliases`", $db);
mysql_query("CREATE TABLE `".$pref."aliases` (
  `alias_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `alias_go` varchar(100) NOT NULL,
  `alias_forward_to` varchar(100) NOT NULL,
  `alias_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY  (`alias_id`),
  KEY `alias_go` (`alias_go`)
) TYPE=MyISAM AUTO_INCREMENT=1", $db);
$template .= "<li><b>".$pref."aliases</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";


// fs_announcement
mysql_query("DROP TABLE IF EXISTS `".$pref."announcement`", $db);
mysql_query("CREATE TABLE `".$pref."announcement` (
  `id` smallint(4) NOT NULL,
  `announcement_text` text,
  `show_announcement` tinyint(1) NOT NULL default '0',
  `activate_announcement` tinyint(1) NOT NULL default '0',
  `ann_html` tinyint(1) NOT NULL default '1',
  `ann_fscode` tinyint(1) NOT NULL default '1',
  `ann_para` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM", $db);
$template .= "<li><b>".$pref."announcement</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";
mysql_query("
INSERT INTO `".$pref."announcement` (`id`, `announcement_text`, `show_announcement`, `activate_announcement`, `ann_html`, `ann_fscode`, `ann_para`) VALUES
(1, '', 2, 0, 1, 1, 1)", $db);
$template .= "<li><b>".$pref."announcement</b> ".$_LANG[db_insert][fill]." ".check_mysqlerror(mysql_error())."</li>";


// fs_applets
mysql_query("DROP TABLE IF EXISTS `".$pref."applets`", $db);
mysql_query("CREATE TABLE `".$pref."applets` (
  `applet_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `applet_file` varchar(100) NOT NULL,
  `applet_active` tinyint(1) NOT NULL DEFAULT '1',
  `applet_output` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`applet_id`),
  UNIQUE KEY `applet_file` (`applet_file`)
) TYPE=MyISAM AUTO_INCREMENT=10", $db);
$template .= "<li><b>".$pref."applets</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";
mysql_query("
INSERT INTO `".$pref."applets` (`applet_id`, `applet_file`, `applet_active`, `applet_output`) VALUES
(1, 'affiliates', 1, 1),
(2, 'user-menu', 1, 1),
(3, 'announcement', 1, 1),
(4, 'mini-statistics', 1, 1),
(5, 'poll-system', 1, 1),
(6, 'preview-image', 1, 1),
(7, 'shop-system', 1, 1),
(8, 'dl-forwarding', 1, 0),
(9, 'mini-search', 1, 1)
", $db);
$template .= "<li><b>".$pref."applets</b> ".$_LANG[db_insert][fill]." ".check_mysqlerror(mysql_error())."</li>";


// fs_articles
mysql_query("DROP TABLE IF EXISTS `".$pref."articles`", $db);
mysql_query("CREATE TABLE `".$pref."articles` (
  `article_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `article_url` varchar(100) DEFAULT NULL,
  `article_title` varchar(255) NOT NULL,
  `article_date` int(11) default NULL,
  `article_user` mediumint(8) DEFAULT NULL,
  `article_text` text NOT NULL,
  `article_html` tinyint(1) NOT NULL DEFAULT '1',
  `article_fscode` tinyint(1) NOT NULL DEFAULT '1',
  `article_para` tinyint(1) NOT NULL DEFAULT '1',
  `article_cat_id` mediumint(8) NOT NULL,
  `article_search_update` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`article_id`),
  KEY `article_url` (`article_url`),
  FULLTEXT KEY `article_text` (`article_title`,`article_text`)
) TYPE=MyISAM  AUTO_INCREMENT=2", $db);
$template .= "<li><b>".$pref."articles</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";
mysql_query("INSERT INTO `".$pref."articles` (`article_id`, `article_url`, `article_title`, `article_date`, `article_user`, `article_text`, `article_html`, `article_fscode`, `article_para`, `article_cat_id`, `article_search_update`) VALUES
(1, 'fscode', 'FSCode Liste', ".$THE_TIME.", 1, '".addslashes("Das System dieser Webseite bietet dir die Möglichkeit einfache Codes zur besseren Darstellung deiner Beiträge zu verwenden. Diese sogenannten [b]FSCodes[/b] erlauben dir daher HTML-Formatierungen zu verwenden, ohne dass du dich mit HTML auskennen musst. Mit ihnen hast du die Möglichkeit verschiedene Elemente in deine Beiträge einzubauen bzw. ihren Text zu formatieren.\r\n\r\nHier findest du eine [b]Übersicht über alle verfügbaren FSCodes[/b] und ihre Verwendung. Allerdings ist es möglich, dass nicht alle Codes zur Verwendung freigeschaltet sind.\r\n\r\n<table width=\\\"100%\\\" cellpadding=\\\"0\\\" cellspacing=\\\"10\\\" border=\\\"0\\\"><tr><td width=\\\"50%\\\">[b][u][size=3]FS-Code:[/size][/u][/b]</td><td width=\\\"50%\\\">[b][u][size=3]Beispiel:[/size][/u][/b]</td></tr><tr><td>[noparse][b]fetter Text[/b][/noparse]</td><td>[b]fetter Text[/b]</td></tr><tr><td>[noparse][i]kursiver Text[/i][/noparse]</td><td>[i]kursiver Text[/i]</td></tr><tr><td>[noparse][u]unterstrichener Text[u][/noparse]</td><td>[u]unterstrichener Text[/u]</td></tr><tr><td>[noparse][s]durchgestrichener Text[/s][/noparse]</td><td>[s]durchgestrichener Text[/s]</td></tr><tr><td>[noparse][center]zentrierter Text[/center][/noparse]</td><td>[center]zentrierter Text[/center]</td></tr><tr><td>[noparse][font=Schriftart]Text in Schriftart[/font][/noparse]</td><td>[font=Arial]Text in Arial[/font]</td></tr><tr><td>[noparse][color=Farbcode]Text in Farbe[/color][/noparse]</td><td>[color=#FF0000]Text in Rot (Farbcode: #FF0000)[/color]</td></tr><tr><td>[noparse][size=Größe]Text in Größe 0[/size][/noparse]</td><td>[size=0]Text in Größe 0[/size]</td></tr><tr><td>[noparse][size=Größe]Text in Größe 1[/size][/noparse]</td><td>[size=1]Text in Größe 1[/size]</td></tr><tr><td>[noparse][size=Größe]Text in Größe 2[/size][/noparse]</td><td>[size=2]Text in Größe 2[/size]</td></tr><tr><td>[noparse][size=Größe]Text in Größe 3[/size][/noparse]</td><td>[size=3]Text in Größe 3[/size]</td></tr><tr><td>[noparse][size=Größe]Text in Größe 4[/size][/noparse]</td><td>[size=4]Text in Größe 4[/size]</td></tr><tr><td>[noparse][size=Größe]Text in Größe 5[/size][/noparse]</td><td>[size=5]Text in Größe 5[/size]</td></tr><tr><td>[noparse][size=Größe]Text in Größe 6[/size][/noparse]</td><td>[size=6]Text in Größe 6[/size]</td></tr><tr><td>[noparse][size=Größe]Text in Größe 7[/size][/noparse]</td><td>[size=7]Text&nbsp;in&nbsp;Größe&nbsp;7[/size]</td></tr><tr><td>[noparse][noparse]Text mit [b]FS[/b]Code[/noparse][/noparse]</td><td>[noparse]kein [b]fetter[/b] Text[/noparse]</td></tr> <tr><td colspan=\\\"2\\\"><hr></td></tr> <tr><td>[noparse][url]Linkadresse[/url][/noparse]</td><td>[url]http://www.example.com[/url]</td></tr> <tr><td>[noparse][url=Linkadresse]Linktext[/url][/noparse]</td><td>[url=http://www.example.com]Linktext[/url]</td></tr> <tr><td>[noparse][home]Seitenlink[/home][/noparse]</td><td>[home]news[/home]</td></tr> <tr><td>[noparse][home=Seitenlink]Linktext[/home][/noparse]</td><td>[home=news]Linktext[/home]</td></tr> <tr><td>[noparse][email]Email-Adresse[/email][/noparse]</td><td>[email]max.mustermann@example.com[/email]</td></tr> <tr><td>[noparse][email=Email-Adresse]Beispieltext[/email][/noparse]</td><td>[email=max.mustermann@example.com]Beispieltext[/email]</td></tr> <tr><td colspan=\\\"2\\\"><hr></td></tr> <tr><td>[noparse][list]<br>[*]Listenelement<br>[*]Listenelement<br>[/list][/noparse]</td><td>[list]<br>[*]Listenelement<br>[*]Listenelement<br>[/list]</td></tr> <tr><td>[noparse][numlist]<br>[*]Listenelement<br>[*]Listenelement<br>[/numlist][/noparse]</td><td>[numlist]<br>[*]Listenelement<br>[*]Listenelement<br>[/numlist]</td></tr> <tr><td>[noparse][quote]Ein Zitat[/quote][/noparse]</td><td>[quote]Ein Zitat[/quote]</td></tr><tr><td>[noparse][quote=Quelle]Ein Zitat[/quote][/noparse]</td><td>[quote=Quelle]Ein Zitat[/quote]</td></tr><tr><td>[noparse][code]Schrift mit fester Breite[/code][/noparse]</td><td>[code]Schrift mit fester Breite[/code]</td></tr><tr><td colspan=\\\"2\\\"><hr></td></tr><tr><td>[noparse][img]Bildadresse[/img][/noparse]</td><td>[img]\$VAR(url)images/icons/logo.gif[/img]</td></tr><tr><td>[noparse][img=right]Bildadresse[/img][/noparse]</td><td>[img=right]\$VAR(url)images/icons/logo.gif[/img] Das hier ist ein Beispieltext. Die Grafik ist rechts platziert und der Text fließt links um sie herum.</td></tr><tr><td>[noparse][img=left]Bildadresse[/img][/noparse]</td><td>[img=left]\$VAR(url)images/icons/logo.gif[/img] Das hier ist ein Beispieltext. Die Grafik ist links platziert und der Text fließt rechts um sie herum.</td></tr></table>")."', 1, 1, 1, 1, 0)
", $db);
$template .= "<li><b>".$pref."articles</b> ".$_LANG[db_insert][fill]." ".check_mysqlerror(mysql_error())."</li>";


// fs_articles_cat
mysql_query("DROP TABLE IF EXISTS `".$pref."articles_cat`", $db);
mysql_query("CREATE TABLE `".$pref."articles_cat` (
  `cat_id` smallint(6) NOT NULL auto_increment,
  `cat_name` varchar(100) default NULL,
  `cat_description` text NOT NULL,
  `cat_date` int(11) NOT NULL,
  `cat_user` mediumint(8) NOT NULL default '1',
  PRIMARY KEY  (`cat_id`)
) TYPE=MyISAM  AUTO_INCREMENT=2", $db);
$template .= "<li><b>".$pref."articles_cat</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";
mysql_query("INSERT INTO `".$pref."articles_cat` (`cat_id`, `cat_name`, `cat_description`, `cat_date`, `cat_user`) VALUES
(1, 'Artikel', '', ".$THE_TIME.", 1)", $db);
$template .= "<li><b>".$pref."articles_cat</b> ".$_LANG[db_insert][fill]." ".check_mysqlerror(mysql_error())."</li>";


// fs_articles_config
mysql_query("DROP TABLE IF EXISTS `".$pref."articles_config`", $db);
mysql_query("CREATE TABLE `".$pref."articles_config` (
  `id` tinyint(1) NOT NULL,
  `html_code` tinyint(4) NOT NULL default '1',
  `fs_code` tinyint(4) NOT NULL default '1',
  `para_handling` tinyint(4) NOT NULL default '1',
  `cat_pic_x` smallint(4) NOT NULL default '0',
  `cat_pic_y` smallint(4) NOT NULL default '0',
  `cat_pic_size` smallint(4) NOT NULL default '0',
  `com_rights` tinyint(1) NOT NULL default '1',
  `com_antispam` tinyint(1) NOT NULL default '1',
  `com_sort` varchar(4) NOT NULL default 'DESC',
  `acp_per_page` smallint(3) NOT NULL default '15',
  `acp_view` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM", $db);
$template .= "<li><b>".$pref."articles_config</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";
mysql_query("INSERT INTO `".$pref."articles_config` (`id`, `html_code`, `fs_code`, `para_handling`, `cat_pic_x`, `cat_pic_y`, `cat_pic_size`, `com_rights`, `com_antispam`, `com_sort`, `acp_per_page`, `acp_view`) VALUES
(1, 2, 4, 4, 150, 150, 1024, 2, 1, 'DESC', 15, 2)", $db);
$template .= "<li><b>".$pref."articles_config</b> ".$_LANG[db_insert][fill]." ".check_mysqlerror(mysql_error())."</li>";


// fs_captcha_config
mysql_query("DROP TABLE IF EXISTS `".$pref."captcha_config`", $db);
mysql_query("CREATE TABLE `".$pref."captcha_config` (
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
) TYPE=MyISAM", $db);
$template .= "<li><b>".$pref."captcha_config</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";
mysql_query("INSERT INTO `".$pref."captcha_config` (`id`, `captcha_bg_color`, `captcha_bg_transparent`, `captcha_text_color`, `captcha_first_lower`, `captcha_first_upper`, `captcha_second_lower`, `captcha_second_upper`, `captcha_use_addition`, `captcha_use_subtraction`, `captcha_use_multiplication`, `captcha_create_easy_arithmetics`, `captcha_x`, `captcha_y`, `captcha_show_questionmark`, `captcha_use_spaces`, `captcha_show_multiplication_as_x`, `captcha_start_text_x`, `captcha_start_text_y`, `captcha_font_size`, `captcha_font_file`) VALUES
(1, 'FFFFFF', 1, '000000', 1, 5, 1, 5, 1, 1, 0, 1, 58, 18, 0, 1, 1, 0, 0, 3, '')", $db);
$template .= "<li><b>".$pref."captcha_config</b> ".$_LANG[db_insert][fill]." ".check_mysqlerror(mysql_error())."</li>";


// fs_counter
mysql_query("DROP TABLE IF EXISTS `".$pref."counter`", $db);
mysql_query("CREATE TABLE `".$pref."counter` (
  `id` tinyint(1) NOT NULL,
  `visits` int(11) unsigned NOT NULL DEFAULT '0',
  `hits` int(11) unsigned NOT NULL DEFAULT '0',
  `user` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `artikel` smallint(6) unsigned NOT NULL DEFAULT '0',
  `news` smallint(6) unsigned NOT NULL DEFAULT '0',
  `comments` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM", $db);
$template .= "<li><b>".$pref."counter</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";
mysql_query("INSERT INTO `".$pref."counter` (`id`, `visits`, `hits`, `user`, `artikel`, `news`, `comments`) VALUES
(1, 0, 0, 1, 1, 1, 0)", $db);
$template .= "<li><b>".$pref."counter</b> ".$_LANG[db_insert][fill]." ".check_mysqlerror(mysql_error())."</li>";


// fs_counter_ref
mysql_query("DROP TABLE IF EXISTS `".$pref."counter_ref`", $db);
mysql_query("CREATE TABLE `".$pref."counter_ref` (
  `ref_url` varchar(255) default NULL,
  `ref_count` int(11) default NULL,
  `ref_first` int(11) default NULL,
  `ref_last` int(11) default NULL,
  KEY `ref_url` (`ref_url`)
) TYPE=MyISAM", $db);
$template .= "<li><b>".$pref."counter_ref</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";


// fs_counter_stat
mysql_query("DROP TABLE IF EXISTS `".$pref."counter_stat`", $db);
mysql_query("CREATE TABLE `".$pref."counter_stat` (
  `s_year` int(4) NOT NULL default '0',
  `s_month` int(2) NOT NULL default '0',
  `s_day` int(2) NOT NULL default '0',
  `s_visits` int(11) default NULL,
  `s_hits` int(11) default NULL,
  PRIMARY KEY  (`s_year`,`s_month`,`s_day`)
) TYPE=MyISAM", $db);
$template .= "<li><b>".$pref."counter_stat</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";


// fs_dl
mysql_query("DROP TABLE IF EXISTS `".$pref."dl`", $db);
mysql_query("CREATE TABLE `".$pref."dl` (
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
  PRIMARY KEY  (`dl_id`),
  FULLTEXT KEY `dl_name_text` (`dl_name`,`dl_text`)
) TYPE=MyISAM AUTO_INCREMENT=1", $db);
$template .= "<li><b>".$pref."dl</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";


// fs_dl_cat
mysql_query("DROP TABLE IF EXISTS `".$pref."dl_cat`", $db);
mysql_query("CREATE TABLE `".$pref."dl_cat` (
  `cat_id` mediumint(8) NOT NULL auto_increment,
  `subcat_id` mediumint(8) NOT NULL default '0',
  `cat_name` varchar(100) default NULL,
  PRIMARY KEY  (`cat_id`)
) TYPE=MyISAM  AUTO_INCREMENT=2", $db);
$template .= "<li><b>".$pref."dl_cat</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";
mysql_query("INSERT INTO `".$pref."dl_cat` (`cat_id`, `subcat_id`, `cat_name`) VALUES
(1, 0, 'Downloads')", $db);
$template .= "<li><b>".$pref."dl_cat</b> ".$_LANG[db_insert][fill]." ".check_mysqlerror(mysql_error())."</li>";


// fs_dl_config
mysql_query("DROP TABLE IF EXISTS `".$pref."dl_config`", $db);
mysql_query("CREATE TABLE `".$pref."dl_config` (
  `id` tinyint(1) NOT NULL,
  `screen_x` int(11) DEFAULT NULL,
  `screen_y` int(11) DEFAULT NULL,
  `thumb_x` int(11) DEFAULT NULL,
  `thumb_y` int(11) DEFAULT NULL,
  `quickinsert` varchar(255) NOT NULL,
  `dl_rights` tinyint(1) NOT NULL DEFAULT '1',
  `dl_show_sub_cats` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM", $db);
$template .= "<li><b>".$pref."dl_config</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";
mysql_query("INSERT INTO `".$pref."dl_config` (`id`, `screen_x`, `screen_y`, `thumb_x`, `thumb_y`, `quickinsert`, `dl_rights`, `dl_show_sub_cats`) VALUES
(1, 1024, 768, 120, 90, '', 2, 0)", $db);
$template .= "<li><b>".$pref."dl_config</b> ".$_LANG[db_insert][fill]." ".check_mysqlerror(mysql_error())."</li>";


// fs_dl_files
mysql_query("DROP TABLE IF EXISTS `".$pref."dl_files`", $db);
mysql_query("CREATE TABLE `".$pref."dl_files` (
  `dl_id` mediumint(8) default NULL,
  `file_id` mediumint(8) NOT NULL auto_increment,
  `file_count` mediumint(8) NOT NULL default '0',
  `file_name` varchar(100) default NULL,
  `file_url` varchar(255) default NULL,
  `file_size` mediumint(8) NOT NULL default '0',
  `file_is_mirror` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`file_id`),
  KEY `dl_id` (`dl_id`)
) TYPE=MyISAM AUTO_INCREMENT=1", $db);
$template .= "<li><b>".$pref."dl_files</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";


// fs_editor_config
mysql_query("DROP TABLE IF EXISTS `".$pref."editor_config`", $db);
mysql_query("CREATE TABLE `".$pref."editor_config` (
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
  `list` tinyint(1) NOT NULL,
  `numlist` tinyint(1) NOT NULL,
  `img` tinyint(1) NOT NULL default '0',
  `cimg` tinyint(1) NOT NULL default '0',
  `url` tinyint(1) NOT NULL default '0',
  `home` tinyint(1) NOT NULL default '0',
  `email` tinyint(1) NOT NULL default '0',
  `code` tinyint(1) NOT NULL default '0',
  `quote` tinyint(1) NOT NULL default '0',
  `noparse` tinyint(1) NOT NULL default '0',
  `smilies` tinyint(1) NOT NULL default '0',
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
  PRIMARY KEY  (`id`)
) TYPE=MyISAM", $db);
$template .= "<li><b>".$pref."editor_config</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";
mysql_query("INSERT INTO `".$pref."editor_config` (`id`, `smilies_rows`, `smilies_cols`, `textarea_width`, `textarea_height`, `bold`, `italic`, `underline`, `strike`, `center`, `font`, `color`, `size`, `list`, `numlist`, `img`, `cimg`, `url`, `home`, `email`, `code`, `quote`, `noparse`, `smilies`, `do_bold`, `do_italic`, `do_underline`, `do_strike`, `do_center`, `do_font`, `do_color`, `do_size`, `do_list`, `do_numlist`, `do_img`, `do_cimg`, `do_url`, `do_home`, `do_email`, `do_code`, `do_quote`, `do_noparse`, `do_smilies`) VALUES
(1, 5, 2, 355, 120, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 1, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1)", $db);
$template .= "<li><b>".$pref."editor_config</b> ".$_LANG[db_insert][fill]." ".check_mysqlerror(mysql_error())."</li>";


// fs_email
mysql_query("DROP TABLE IF EXISTS `".$pref."email`", $db);
mysql_query("CREATE TABLE `".$pref."email` (
  `id` tinyint(1) NOT NULL default '1',
  `signup` text NOT NULL,
  `change_password` text NOT NULL,
  `delete_account` text NOT NULL,
  `use_admin_mail` tinyint(1) NOT NULL default '1',
  `email` varchar(100) NOT NULL,
  `html` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM", $db);
$template .= "<li><b>".$pref."email</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";
mysql_query("
INSERT INTO `".$pref."email` (`id`, `signup`, `change_password`, `delete_account`, `use_admin_mail`, `email`, `html`) VALUES
(1, 'Hallo  {..user_name..},\r\n\r\nDu hast dich bei \$VAR(page_title) registriert. Deine Zugangsdaten sind:\r\n\r\nBenutzername: {..user_name..}\r\nPasswort: {..new_password..}\r\n\r\nFalls du deine Daten ändern möchtest, kannst du das gerne auf deiner [url=\$VAR(url)?go=editprofil]Profilseite[/url] tun.\r\n\r\nDein Team von \$VAR(page_title)!', 'Hallo {..user_name..},\r\n\r\nDein Passwort bei \$VAR(page_title) wurde geändert. Deine neuen Zugangsdaten sind:\r\n\r\nBenutzername: {..user_name..}\r\nPasswort: {..new_password..}\r\n\r\nFalls du deine Daten ändern möchtest, kannst du das gerne auf deiner [url=\$VAR(url)?go=editprofil]Profilseite[/url] tun.\r\n\r\nDein Team von \$VAR(page_title)!', 'Hallo {username},\r\n\r\nSchade, dass du dich von unserer Seite abgemeldet hast. Falls du es dir doch noch anders überlegen willst, [url={virtualhost}]kannst du ja nochmal rein schauen[/url].\r\n\r\nDein Webseiten-Team!', 1, '', 1)
", $db);
$template .= "<li><b>".$pref."email</b> ".$_LANG[db_insert][fill]." ".check_mysqlerror(mysql_error())."</li>";


// fs_global_config
mysql_query("DROP TABLE IF EXISTS `".$pref."global_config`", $db);
mysql_query("CREATE TABLE `".$pref."global_config` (
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
  PRIMARY KEY  (`id`)
) TYPE=MyISAM", $db);
$template .= "<li><b>".$pref."global_config</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";
mysql_query("
INSERT INTO `".$pref."global_config` (`id`, `dyn_title`, `dyn_title_ext`, `description`, `keywords`, `publisher`, `copyright`, `show_favicon`, `style_id`, `style_tag`, `allow_other_designs`, `date`, `time`, `datetime`, `page`, `page_next`, `page_prev`, `random_timed_deltime`, `feed`, `language_text`, `home`, `home_text`, `auto_forward`, `search_index_update`, `search_index_time`) VALUES
(1, 1, '{title} - {ext}', '', '', '', '', 0, 1, 'lightfrog', 0, 'd.m.Y', '".addslashes("H:i \\\\U\\\\h\\\\r")."', '".addslashes("d.m.Y, H:i \\\\U\\\\h\\\\r")."', '".addslashes("<div align=\\\"center\\\" style=\\\"width:270px;\\\"><div style=\\\"width:70px; float:left;\\\">{..prev..}&nbsp;</div>Seite <b>{..page_number..}</b> von <b>{..total_pages..}</b><div style=\\\"width:70px; float:right;\\\">&nbsp;{..next..}</div></div>")."', '".addslashes("|&nbsp;<a href=\\\"{..url..}\\\">weiter&nbsp;»</a>")."', '".addslashes("<a href=\\\"{..url..}\\\">«&nbsp;zurück</a>&nbsp;|")."', 604800, 'rss20', 'de_DE', 0, '', 4, 2, 0)
", $db);
$template .= "<li><b>".$pref."global_config</b> ".$_LANG[db_insert][fill]." ".check_mysqlerror(mysql_error())."</li>";


// fs_iplist
mysql_query("DROP TABLE IF EXISTS `".$pref."iplist`", $db);
mysql_query("CREATE TABLE `".$pref."iplist` (
  `ip` varchar(18) NOT NULL,
  PRIMARY KEY  (`ip`)
) TYPE=MEMORY", $db);
$template .= "<li><b>".$pref."iplist</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";


// fs_news
mysql_query("DROP TABLE IF EXISTS `".$pref."news`", $db);
mysql_query("CREATE TABLE `".$pref."news` (
  `news_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `cat_id` smallint(6) DEFAULT NULL,
  `user_id` mediumint(8) DEFAULT NULL,
  `news_date` int(11) DEFAULT NULL,
  `news_title` varchar(255) DEFAULT NULL,
  `news_text` text,
  `news_active` tinyint(1) NOT NULL DEFAULT '1',
  `news_comments_allowed` tinyint(1) NOT NULL DEFAULT '1',
  `news_search_update` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`news_id`),
  FULLTEXT KEY `news_title_text` (`news_title`,`news_text`)
) TYPE=MyISAM  AUTO_INCREMENT=2", $db);
$template .= "<li><b>".$pref."news</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";
mysql_query("INSERT INTO `".$pref."news` (`news_id`, `cat_id`, `user_id`, `news_date`, `news_title`, `news_text`, `news_active`, `news_comments_allowed`, `news_search_update`) VALUES
(1, 1, 1, ".$THE_TIME.", 'Frogsystem 2.alix5 - Installation erfolgreich', 'Herzlich Willkommen in deinem frisch installierten Frogsystem 2!\r\nDas Frogsystem 2-Team wünscht viel Spaß und Erfolg mit der Seite.\r\n\r\nWeitere Informationen und Hilfe bei Problemen gibt es auf der offiziellen Homepage des Frogsystem 2, in den zugehörigen Supportforen und dem neuen Dokumentations-Wiki. Die wichtigsten Links haben wir unten zusammengefasst. Einfach mal vorbei schauen!\r\n\r\nDein Frogsystem 2-Team', 1, 1, 0)
", $db);
$template .= "<li><b>".$pref."news</b> ".$_LANG[db_insert][fill]." ".check_mysqlerror(mysql_error())."</li>";


// fs_news_cat
mysql_query("DROP TABLE IF EXISTS `".$pref."news_cat`", $db);
mysql_query("CREATE TABLE `".$pref."news_cat` (
  `cat_id` smallint(6) NOT NULL auto_increment,
  `cat_name` varchar(100) default NULL,
  `cat_description` text NOT NULL,
  `cat_date` int(11) NOT NULL,
  `cat_user` mediumint(8) NOT NULL default '1',
  PRIMARY KEY  (`cat_id`)
) TYPE=MyISAM  AUTO_INCREMENT=2", $db);
$template .= "<li><b>".$pref."news_cat</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";
mysql_query("INSERT INTO `".$pref."news_cat` (`cat_id`, `cat_name`, `cat_description`, `cat_date`, `cat_user`) VALUES
(1, 'News', '', ".$THE_TIME.", 1)", $db);
$template .= "<li><b>".$pref."news_cat</b> ".$_LANG[db_insert][fill]." ".check_mysqlerror(mysql_error())."</li>";


// fs_news_comments
mysql_query("DROP TABLE IF EXISTS `".$pref."news_comments`", $db);
mysql_query("CREATE TABLE `".$pref."news_comments` (
  `comment_id` mediumint(8) NOT NULL auto_increment,
  `news_id` mediumint(8) default NULL,
  `comment_poster` varchar(32) default NULL,
  `comment_poster_id` mediumint(8) default NULL,
  `comment_poster_ip` varchar(16) NOT NULL,
  `comment_date` int(11) default NULL,
  `comment_title` varchar(100) default NULL,
  `comment_text` text,
  PRIMARY KEY  (`comment_id`),
  FULLTEXT KEY `comment_title_text` (`comment_text`,`comment_title`)
) TYPE=MyISAM AUTO_INCREMENT=1", $db);
$template .= "<li><b>".$pref."news_comments</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";


// fs_news_config
mysql_query("DROP TABLE IF EXISTS `".$pref."news_config`", $db);
mysql_query("CREATE TABLE `".$pref."news_config` (
  `id` tinyint(1) NOT NULL,
  `num_news` int(11) default NULL,
  `num_head` int(11) default NULL,
  `html_code` tinyint(4) default NULL,
  `fs_code` tinyint(4) default NULL,
  `para_handling` tinyint(4) default NULL,
  `cat_pic_x` smallint(4) NOT NULL default '0',
  `cat_pic_y` smallint(4) NOT NULL default '0',
  `cat_pic_size` smallint(4) NOT NULL default '0',
  `com_rights` tinyint(1) NOT NULL default '1',
  `com_antispam` tinyint(1) NOT NULL default '1',
  `com_sort` varchar(4) NOT NULL default 'DESC',
  `news_headline_lenght` smallint(3) NOT NULL default '-1',
  `news_headline_ext` varchar(30) NOT NULL,
  `acp_per_page` smallint(3) NOT NULL default '15',
  `acp_view` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM", $db);
$template .= "<li><b>".$pref."news_config</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";
mysql_query("INSERT INTO `".$pref."news_config` (`id`, `num_news`, `num_head`, `html_code`, `fs_code`, `para_handling`, `cat_pic_x`, `cat_pic_y`, `cat_pic_size`, `com_rights`, `com_antispam`, `com_sort`, `news_headline_lenght`, `news_headline_ext`, `acp_per_page`, `acp_view`) VALUES
(1, 10, 5, 2, 4, 4, 150, 150, 1024, 2, 1, 'DESC', 25, ' ...', 15, 2)
", $db);
$template .= "<li><b>".$pref."news_config</b> ".$_LANG[db_insert][fill]." ".check_mysqlerror(mysql_error())."</li>";


// fs_news_links
mysql_query("DROP TABLE IF EXISTS `".$pref."news_links`", $db);
mysql_query("CREATE TABLE `".$pref."news_links` (
  `news_id` mediumint(8) default NULL,
  `link_id` mediumint(8) NOT NULL auto_increment,
  `link_name` varchar(100) default NULL,
  `link_url` varchar(255) default NULL,
  `link_target` tinyint(4) default NULL,
  PRIMARY KEY  (`link_id`)
) TYPE=MyISAM  AUTO_INCREMENT=4", $db);
$template .= "<li><b>".$pref."news_links</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";
mysql_query("INSERT INTO `".$pref."news_links` (`news_id`, `link_id`, `link_name`, `link_url`, `link_target`) VALUES
(1, 1, 'Offizielle Frogsystem 2 Homepage', 'http://www.frogsystem.de', 1),
(1, 2, 'Frogsystem 2 Supportforum', 'http://forum.sweil.de/viewforum.php?f=7', 1),
(1, 3, 'Frogsystem 2 Dokumentations-Wiki', 'http://wiki.frogsystem.de/', 1)
", $db);
$template .= "<li><b>".$pref."news_links</b> ".$_LANG[db_insert][fill]." ".check_mysqlerror(mysql_error())."</li>";


// fs_partner
mysql_query("DROP TABLE IF EXISTS `".$pref."partner`", $db);
mysql_query("CREATE TABLE `".$pref."partner` (
  `partner_id` smallint(3) unsigned NOT NULL auto_increment,
  `partner_name` varchar(150) NOT NULL,
  `partner_link` varchar(250) NOT NULL,
  `partner_beschreibung` text NOT NULL,
  `partner_permanent` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`partner_id`)
) TYPE=MyISAM AUTO_INCREMENT=1", $db);
$template .= "<li><b>".$pref."partner</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";


// fs_partner_config
mysql_query("DROP TABLE IF EXISTS `".$pref."partner_config`", $db);
mysql_query("CREATE TABLE `".$pref."partner_config` (
  `id` tinyint(1) NOT NULL default '1',
  `partner_anzahl` tinyint(2) NOT NULL default '0',
  `small_x` int(4) NOT NULL default '0',
  `small_y` int(4) NOT NULL default '0',
  `small_allow` tinyint(1) NOT NULL default '0',
  `big_x` int(4) NOT NULL default '0',
  `big_y` int(4) NOT NULL default '0',
  `big_allow` tinyint(1) NOT NULL default '0',
  `file_size` int(4) NOT NULL default '1024',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM", $db);
$template .= "<li><b>".$pref."partner_config</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";
mysql_query("INSERT INTO `".$pref."partner_config` (`id`, `partner_anzahl`, `small_x`, `small_y`, `small_allow`, `big_x`, `big_y`, `big_allow`, `file_size`) VALUES
(1, 5, 88, 31, 0, 468, 60, 1, 1024)", $db);
$template .= "<li><b>".$pref."partner_config</b> ".$_LANG[db_insert][fill]." ".check_mysqlerror(mysql_error())."</li>";


// fs_player
mysql_query("DROP TABLE IF EXISTS `".$pref."player`", $db);
mysql_query("CREATE TABLE `".$pref."player` (
  `video_id` mediumint(8) NOT NULL auto_increment,
  `video_type` tinyint(1) NOT NULL default '1',
  `video_x` text NOT NULL,
  `video_title` varchar(100) NOT NULL,
  `video_lenght` smallint(6) NOT NULL default '0',
  `video_desc` text NOT NULL,
  `dl_id` mediumint(8) NOT NULL,
  PRIMARY KEY  (`video_id`)
) TYPE=MyISAM AUTO_INCREMENT=1", $db);
$template .= "<li><b>".$pref."player</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";


// fs_player_config
mysql_query("DROP TABLE IF EXISTS `".$pref."player_config`", $db);
mysql_query("CREATE TABLE `".$pref."player_config` (
  `id` tinyint(1) NOT NULL default '1',
  `cfg_autoplay` tinyint(1) NOT NULL default '1',
  `cfg_autoload` tinyint(1) NOT NULL default '1',
  `cfg_buffer` smallint(2) NOT NULL default '5',
  `cfg_buffermessage` varchar(100) NOT NULL default 'Buffering _n_',
  `cfg_buffercolor` varchar(6) NOT NULL default 'FFFFFF',
  `cfg_bufferbgcolor` varchar(6) NOT NULL default '000000',
  `cfg_buffershowbg` tinyint(1) NOT NULL default '1',
  `cfg_titlesize` smallint(2) NOT NULL default '20',
  `cfg_titlecolor` varchar(6) NOT NULL default 'FFFFFF',
  `cfg_margin` smallint(2) NOT NULL default '0',
  `cfg_showstop` tinyint(1) NOT NULL default '1',
  `cfg_showvolume` tinyint(1) NOT NULL default '1',
  `cfg_showtime` tinyint(1) NOT NULL default '1',
  `cfg_showplayer` varchar(8) NOT NULL default 'always',
  `cfg_showloading` varchar(8) NOT NULL default 'always',
  `cfg_showfullscreen` tinyint(1) NOT NULL default '1',
  `cfg_showmouse` varchar(8) NOT NULL default 'autohide',
  `cfg_loop` tinyint(1) NOT NULL default '0',
  `cfg_playercolor` varchar(6) NOT NULL,
  `cfg_loadingcolor` varchar(6) NOT NULL,
  `cfg_bgcolor` varchar(6) NOT NULL,
  `cfg_bgcolor1` varchar(6) NOT NULL,
  `cfg_bgcolor2` varchar(6) NOT NULL,
  `cfg_buttoncolor` varchar(6) NOT NULL,
  `cfg_buttonovercolor` varchar(6) NOT NULL,
  `cfg_slidercolor1` varchar(6) NOT NULL,
  `cfg_slidercolor2` varchar(6) NOT NULL,
  `cfg_sliderovercolor` varchar(6) NOT NULL,
  `cfg_loadonstop` tinyint(1) NOT NULL default '0',
  `cfg_onclick` varchar(9) NOT NULL default 'playpause',
  `cfg_ondoubleclick` varchar(10) NOT NULL default 'fullscreen',
  `cfg_playertimeout` mediumint(6) NOT NULL default '1500',
  `cfg_videobgcolor` varchar(6) NOT NULL,
  `cfg_volume` smallint(3) NOT NULL default '80',
  `cfg_shortcut` tinyint(1) NOT NULL default '0',
  `cfg_playeralpha` smallint(3) NOT NULL default '0',
  `cfg_top1_url` varchar(100) NOT NULL,
  `cfg_top1_x` smallint(4) NOT NULL,
  `cfg_top1_y` smallint(4) NOT NULL,
  `cfg_showiconplay` tinyint(1) NOT NULL default '1',
  `cfg_iconplaycolor` varchar(6) NOT NULL,
  `cfg_iconplaybgcolor` varchar(6) NOT NULL,
  `cfg_iconplaybgalpha` smallint(3) NOT NULL default '100',
  `cfg_showtitleandstartimage` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM", $db);
$template .= "<li><b>".$pref."player_config</b> ".$_LANG[db_insert][create]." ".check_mysqlerror(mysql_error())."</li>";
mysql_query("INSERT INTO `".$pref."player_config` (`id`, `cfg_autoplay`, `cfg_autoload`, `cfg_buffer`, `cfg_buffermessage`, `cfg_buffercolor`, `cfg_bufferbgcolor`, `cfg_buffershowbg`, `cfg_titlesize`, `cfg_titlecolor`, `cfg_margin`, `cfg_showstop`, `cfg_showvolume`, `cfg_showtime`, `cfg_showplayer`, `cfg_showloading`, `cfg_showfullscreen`, `cfg_showmouse`, `cfg_loop`, `cfg_playercolor`, `cfg_loadingcolor`, `cfg_bgcolor`, `cfg_bgcolor1`, `cfg_bgcolor2`, `cfg_buttoncolor`, `cfg_buttonovercolor`, `cfg_slidercolor1`, `cfg_slidercolor2`, `cfg_sliderovercolor`, `cfg_loadonstop`, `cfg_onclick`, `cfg_ondoubleclick`, `cfg_playertimeout`, `cfg_videobgcolor`, `cfg_volume`, `cfg_shortcut`, `cfg_playeralpha`, `cfg_top1_url`, `cfg_top1_x`, `cfg_top1_y`, `cfg_showiconplay`, `cfg_iconplaycolor`, `cfg_iconplaybgcolor`, `cfg_iconplaybgalpha`, `cfg_showtitleandstartimage`) VALUES
(1, 0, 1, 5, 'Buffering _n_', 'FFFFFF', '000000', 0, 20, 'FFFFFF', 5, 1, 1, 1, 'autohide', 'always', 1, 'autohide', 0, 'a6a6a6', '000000', 'FAFCF1', 'E7E7E7', 'cccccc', '000000', 'E7E7E7', 'cccccc', 'bbbbbb', 'E7E7E7', 1, 'playpause', 'fullscreen', 1500, '000000', 100, 1, 100, '', 0, 0, 1, 'FFFFFF', '000000', 75, 0)
", $db);
$template .= "<li><b>".$pref."player_config</b> ".$_LANG[db_insert][fill]." ".check_mysqlerror(mysql_error())."</li>";

mysql_close();
?>