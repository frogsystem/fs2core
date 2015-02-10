-- phpMyAdmin SQL Dump
-- version 4.2.0
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 20, 2015 at 03:22 AM
-- Server version: 5.6.15-log
-- PHP Version: 5.4.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `fs2`
--

-- --------------------------------------------------------

--
-- Table structure for table `fs2_admin_cp`
--

DROP TABLE IF EXISTS `fs2_admin_cp`;
CREATE TABLE IF NOT EXISTS `fs2_admin_cp` (
  `page_id` varchar(255) NOT NULL,
  `group_id` varchar(20) NOT NULL,
  `page_file` varchar(255) NOT NULL,
  `page_pos` tinyint(3) NOT NULL DEFAULT '0',
  `page_int_sub_perm` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fs2_admin_cp`
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
('dlcommentedit', 'downloads', 'admin_dlcommentedit.php', 6, 0),
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
('tpl_topdownloads', 'templates', 'admin_template_topdownloads.php', 25, 0),
('tpl_styleselect', 'templates', 'admin_template_styleselect.php', 26, 0),
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
('timedpic_edit', 'gallery_preview', 'admin_randompic_time.php', 4, 0),
('statgfx', 'popup', 'admin_statgfx.php', 0, 0),
('table_admin', 'db', 'admin_table_admin.php', 1, 0),
('social_meta_tags', 'socialmedia', 'admin_social_meta_tags.php', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fs2_admin_groups`
--

DROP TABLE IF EXISTS `fs2_admin_groups`;
CREATE TABLE IF NOT EXISTS `fs2_admin_groups` (
  `group_id` varchar(20) NOT NULL,
  `menu_id` varchar(20) NOT NULL,
  `group_pos` tinyint(3) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `fs2_admin_groups`
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
('db', 'system', 4),
('search', 'general', 4),
('popup', 'none', 0),
('socialmedia', 'promo', 3);

-- --------------------------------------------------------

--
-- Table structure for table `fs2_admin_inherited`
--

DROP TABLE IF EXISTS `fs2_admin_inherited`;
CREATE TABLE IF NOT EXISTS `fs2_admin_inherited` (
  `group_id` varchar(255) NOT NULL,
  `pass_to` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fs2_admin_inherited`
--

INSERT INTO `fs2_admin_inherited` (`group_id`, `pass_to`) VALUES
('applets', 'find_applet'),
('news', 'find_user'),
('articles', 'find_user'),
('news', 'news_preview'),
('articles', 'article_preview'),
('stats', 'statgfx');

-- --------------------------------------------------------

--
-- Table structure for table `fs2_aliases`
--

DROP TABLE IF EXISTS `fs2_aliases`;
CREATE TABLE IF NOT EXISTS `fs2_aliases` (
`alias_id` mediumint(8) NOT NULL,
  `alias_go` varchar(100) NOT NULL,
  `alias_forward_to` varchar(100) NOT NULL,
  `alias_active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `fs2_aliases`
--

INSERT INTO `fs2_aliases` (`alias_id`, `alias_go`, `alias_forward_to`, `alias_active`) VALUES
(1, 'news_detail', 'comments', 1);

-- --------------------------------------------------------

--
-- Table structure for table `fs2_announcement`
--

DROP TABLE IF EXISTS `fs2_announcement`;
CREATE TABLE IF NOT EXISTS `fs2_announcement` (
  `id` smallint(4) NOT NULL,
  `announcement_text` text,
  `show_announcement` tinyint(1) NOT NULL DEFAULT '0',
  `activate_announcement` tinyint(1) NOT NULL DEFAULT '0',
  `ann_html` tinyint(1) NOT NULL DEFAULT '1',
  `ann_fscode` tinyint(1) NOT NULL DEFAULT '1',
  `ann_para` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fs2_announcement`
--

INSERT INTO `fs2_announcement` (`id`, `announcement_text`, `show_announcement`, `activate_announcement`, `ann_html`, `ann_fscode`, `ann_para`) VALUES
(1, '', 2, 0, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `fs2_applets`
--

DROP TABLE IF EXISTS `fs2_applets`;
CREATE TABLE IF NOT EXISTS `fs2_applets` (
`applet_id` mediumint(8) NOT NULL,
  `applet_file` varchar(100) NOT NULL,
  `applet_active` tinyint(1) NOT NULL DEFAULT '1',
  `applet_include` tinyint(1) NOT NULL DEFAULT '1',
  `applet_output` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `fs2_applets`
--

INSERT INTO `fs2_applets` (`applet_id`, `applet_file`, `applet_active`, `applet_include`, `applet_output`) VALUES
(2, 'user-menu', 1, 2, 1),
(3, 'announcement', 1, 2, 1),
(4, 'mini-statistics', 1, 2, 1),
(5, 'poll-system', 1, 2, 1),
(6, 'preview-image', 1, 2, 1),
(7, 'shop-system', 1, 2, 1),
(8, 'topdownloads', 1, 2, 1),
(11, 'dl-forwarding', 1, 1, 0),
(9, 'mini-search', 1, 1, 1),
(10, 'affiliates', 1, 2, 1),
(12, 'social-meta-tags', 1, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `fs2_articles`
--

DROP TABLE IF EXISTS `fs2_articles`;
CREATE TABLE IF NOT EXISTS `fs2_articles` (
  `article_id` mediumint(8) NOT NULL,
  `article_url` varchar(100) DEFAULT NULL,
  `article_title` varchar(255) NOT NULL,
  `article_date` int(11) DEFAULT NULL,
  `article_user` mediumint(8) DEFAULT NULL,
  `article_text` text NOT NULL,
  `article_html` tinyint(1) NOT NULL DEFAULT '1',
  `article_fscode` tinyint(1) NOT NULL DEFAULT '1',
  `article_para` tinyint(1) NOT NULL DEFAULT '1',
  `article_cat_id` mediumint(8) NOT NULL,
  `article_search_update` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fs2_articles`
--

INSERT INTO `fs2_articles` (`article_id`, `article_url`, `article_title`, `article_date`, `article_user`, `article_text`, `article_html`, `article_fscode`, `article_para`, `article_cat_id`, `article_search_update`) VALUES
(1, 'fscode', 'FSCode Liste', 1302472800, 1, 'Das System dieser Webseite bietet dir die Möglichkeit einfache Codes zur besseren Darstellung deiner Beiträge zu verwenden. Diese sogenannten [b]FSCodes[/b] erlauben dir daher HTML-Formatierungen zu verwenden, ohne dass du dich mit HTML auskennen musst. Mit ihnen hast du die Möglichkeit verschiedene Elemente in deine Beiträge einzubauen bzw. ihren Text zu formatieren.\r\n\r\nHier findest du eine [b]Übersicht über alle verfügbaren FSCodes[/b] und ihre Verwendung. Allerdings ist es möglich, dass nicht alle Codes zur Verwendung freigeschaltet sind.\r\n\r\n[html fscode]\r\n<table width="100%" cellpadding="0" cellspacing="10" border="0"><tr><td width="50%">\r\n[b][u][size=3]FS-Code:[/size][/u][/b]\r\n</td><td width="50%">\r\n[b][u][size=3]Beispiel:[/size][/u][/b]\r\n</td></tr><tr><td>\r\n[nofscode][b]fetter Text[/b][/nofscode]\r\n</td><td>\r\n[b]fetter Text[/b]\r\n</td></tr><tr><td>\r\n[nofscode][i]kursiver Text[/i][/nofscode]\r\n</td><td>\r\n[i]kursiver Text[/i]\r\n</td></tr><tr><td>\r\n[nofscode][u]unterstrichener Text[u][/nofscode]\r\n</td><td>\r\n[u]unterstrichener Text[/u]\r\n</td></tr><tr><td>\r\n[nofscode][s]durchgestrichener Text[/s][/nofscode]\r\n</td><td>\r\n[s]durchgestrichener Text[/s]\r\n</td></tr><tr><td>\r\n[nofscode][center]zentrierter Text[/center][/nofscode]\r\n</td><td>\r\n[center]zentrierter Text[/center]\r\n</td></tr><tr><td>\r\n[nofscode][font=Schriftart]Text in Schriftart[/font][/nofscode]\r\n</td><td>\r\n[font=Arial]Text in Arial[/font]</td></tr><tr><td>\r\n[nofscode][color=Farbcode]Text in Farbe[/color][/nofscode]\r\n</td><td>\r\n[color=#FF0000]Text in Rot (Farbcode: #FF0000)[/color]\r\n</td></tr><tr><td>\r\n[nofscode][size=Größe]Text in Größe 0[/size][/nofscode]\r\n</td><td>\r\n[size=0]Text in Größe 0[/size]\r\n</td></tr><tr><td>\r\n[nofscode][size=Größe]Text in Größe 1[/size][/nofscode]\r\n</td><td>\r\n[size=1]Text in Größe 1[/size]\r\n</td></tr><tr><td>\r\n[nofscode][size=Größe]Text in Größe 2[/size][/nofscode]\r\n</td><td>\r\n[size=2]Text in Größe 2[/size]\r\n</td></tr><tr><td>\r\n[nofscode][size=Größe]Text in Größe 3[/size][/nofscode]\r\n</td><td>\r\n[size=3]Text in Größe 3[/size]\r\n</td></tr><tr><td>\r\n[nofscode][size=Größe]Text in Größe 4[/size][/nofscode]\r\n</td><td>\r\n[size=4]Text in Größe 4[/size]\r\n</td></tr><tr><td>\r\n[nofscode][size=Größe]Text in Größe 5[/size][/nofscode]\r\n</td><td>\r\n[size=5]Text in Größe 5[/size]\r\n</td></tr><tr><td>\r\n[nofscode][size=Größe]Text in Größe 6[/size][/nofscode]\r\n</td><td>\r\n[size=6]Text in Größe 6[/size]\r\n</td></tr><tr><td>\r\n[nofscode][size=Größe]Text in Größe 7[/size][/nofscode]\r\n</td><td>\r\n[size=7]Text in Größe 7[/size]\r\n</td></tr><tr><td>\r\n[nofscode][nofscode]Text mit [b]FS[/b]Code[/nofscode][/nofscode]\r\n</td><td>\r\n[nofscode]kein [b]fetter[/b] Text[/nofscode]\r\n</td></tr><tr><td colspan="2"><hr></td></tr><tr><td>\r\n[nofscode][url]Linkadresse[/url][/nofscode]\r\n</td><td>\r\n[url]http://www.example.com[/url]\r\n</td></tr><tr><td>\r\n[nofscode][url=Linkadresse]Linktext[/url][/nofscode]\r\n</td><td>\r\n[url=http://www.example.com]Linktext[/url]\r\n</td></tr><tr><td>\r\n[nofscode][home]Seitenlink[/home][/nofscode]\r\n</td><td>\r\n[home]news[/home]\r\n</td></tr> <tr><td>\r\n[nofscode][home=Seitenlink]Linktext[/home][/nofscode]\r\n</td><td>\r\n[home=news]Linktext[/home]\r\n</td></tr><tr><td>\r\n[nofscode][email]Email-Adresse[/email][/nofscode]</td><td>\r\n[email]max.mustermann@example.com[/email]\r\n</td></tr> <tr><td>\r\n[nofscode][email=Email-Adresse]Beispieltext[/email][/nofscode]\r\n</td><td>\r\n[email=max.mustermann@example.com]Beispieltext[/email]\r\n</td></tr> <tr><td colspan="2"><hr></td></tr><tr><td>\r\n[nofscode][list]\r\n[*]Listenelement\r\n[*]Listenelement\r\n[/list][/nofscode]</td><td>[list]\r\n[*]Listenelement\r\n[*]Listenelement\r\n[/list]\r\n</td></tr> <tr><td>\r\n[nofscode][numlist]\r\n[*]Listenelement\r\n[*]Listenelement\r\n[/numlist][/nofscode]\r\n</td><td>\r\n[numlist]\r\n[*]Listenelement\r\n[*]Listenelement\r\n[/numlist]\r\n</td></tr> <tr><td>\r\n[nofscode][quote]Ein Zitat[/quote][/nofscode]\r\n</td><td>\r\n[quote]Ein Zitat[/quote]\r\n</td></tr><tr><td>\r\n[nofscode][quote=Quelle]Ein Zitat[/quote][/nofscode]\r\n</td><td>\r\n[quote=Quelle]Ein Zitat[/quote]\r\n</td></tr><tr><td>\r\n[nofscode][code]Schrift mit fester Breite[/code][/nofscode]\r\n</td><td>\r\n[code]Schrift mit fester Breite[/code]\r\n</td></tr><tr><td colspan="2"><hr></td></tr><tr><td>\r\n[nofscode][img]Bildadresse[/img][/nofscode]\r\n</td><td>\r\n[img]http://placehold.it/150x100[/img]\r\n</td></tr><tr><td>\r\n[nofscode][img=right]Bildadresse[/img][/nofscode]\r\n</td><td>\r\n[img=right]http://placehold.it/150x100[/img] Das hier ist ein Beispieltext. Die Grafik ist rechts platziert und der Text fließt links um sie herum.\r\n</td></tr><tr><td>\r\n[nofscode][img=left]Bildadresse[/img][/nofscode]\r\n</td><td>\r\n[img=left]http://placehold.it/150x100[/img] Das hier ist ein Beispieltext. Die Grafik ist links platziert und der Text fließt rechts um sie herum.\r\n</td></tr></table>\r\n[/html]', 0, 1, 1, 1, 1421719445),
(2, '', 'ie 8 test', 1302480000, 1, 'ie 8 test', 1, 1, 1, 1, 1302560322),
(3, 'sds', 'fsdfsdf', 1302739200, 1, 'sdf', 1, 1, 1, 1, 1302797133),
(4, 'sd', 'hallo', 1302739200, 1, 'sdfsdf', 1, 1, 1, 1, 1302797137),
(5, 'sss', 'sdfdfdf', 1372888800, 1, 'sdfsdfdf', 1, 1, 1, 1, 1372971785),
(6, 'search_help', 'Suchregeln', 0, 0, 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumyeirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diamvoluptua. At vero eos et accusam et justo duo dolores.\r\n\r\n[i]Beispiele:[/i]\r\n[font=monospace]mäuse[/font] => Findet Inhalte mit "Mäuse", "mäuse" oder "Maeuse"\r\n\r\n\r\n[b]Phonetische Suche[/b]\r\nLorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumyeirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diamvoluptua. At vero eos et accusam et justo duo dolores.\r\n\r\n[i]Beispiele:[/i]\r\n[font=monospace]team[/font] => Findet Inhalte mit "Team", "Tim", "Teen", etc,\r\n\r\n\r\n[b]Suche nach Teilwörtern: *[/b]\r\nLorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumyeirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diamvoluptua. At vero eos et accusam et justo duo dolores.\r\n\r\n\r\n[b]Mehrere Suchbegriffe: AND [/b]\r\nLorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumyeirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diamvoluptua. At vero eos et accusam et justo duo\r\n[i]Beispiele:[/i]\r\n[font=monospace]frosch internet[/font] => Findet Inhalte mit "frosch" UND "internet"\r\n[font=monospace]hund AND katze[/font] => Findet Inhalte mit "hund" UND "katze"\r\n\r\n\r\n[b]Suchbegriffe auschließen: ![/b]\r\nLorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumyeirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diamvoluptua. At vero eos et accusam et justo duo dolores.\r\n\r\n[i]Beispiele:[/i]\r\n[font=monospace]maus katze !hund[/font] => Findet Inhalte mit "maus" UND "katze", aber OHNE "hund"\r\n\r\n\r\n[b]ODER-Vereinigung: OR[/b]\r\nLorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumyeirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diamvoluptua. At vero eos et accusam et justo duo dolores.\r\n\r\n[i]Beispiele:[/i]\r\n[font=monospace]papagei OR rabe[/font] => Findet Inhalte mit "papagei" ODER "rabe"\r\n\r\n\r\n[b]Entweder-oder-Suche: XOR[/b]\r\nLorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumyeirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diamvoluptua. At vero eos et accusam et justo duo dolores.\r\n\r\n[i]Beispiele:[/i]\r\n[font=monospace]frau XOR mann[/font] => Findet Inhalte mit "frau" aber NICHT "mann" und umgekehrt\r\n\r\n\r\n[b]Mehrere Operatoren mit Klammern[/b]\r\nLorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumyeirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diamvoluptua. At vero eos et accusam et justo duo dolores.\r\n\r\n[i]Beispiele:[/i]\r\n[font=monospace]kind AND (hund XOR katze)[/font] => Findet Inhalte mit "kind" die entweder "hund" oder "katze" enthalten', 1, 1, 1, 1, 1397751822);

-- --------------------------------------------------------

--
-- Table structure for table `fs2_articles_cat`
--

DROP TABLE IF EXISTS `fs2_articles_cat`;
CREATE TABLE IF NOT EXISTS `fs2_articles_cat` (
`cat_id` smallint(6) NOT NULL,
  `cat_name` varchar(100) DEFAULT NULL,
  `cat_description` text NOT NULL,
  `cat_date` int(11) NOT NULL,
  `cat_user` mediumint(8) NOT NULL DEFAULT '1'
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `fs2_articles_cat`
--

INSERT INTO `fs2_articles_cat` (`cat_id`, `cat_name`, `cat_description`, `cat_date`, `cat_user`) VALUES
(1, 'Artikel', '', 1302472800, 1);

-- --------------------------------------------------------

--
-- Table structure for table `fs2_b8_wordlist`
--

DROP TABLE IF EXISTS `fs2_b8_wordlist`;
CREATE TABLE IF NOT EXISTS `fs2_b8_wordlist` (
  `token` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `count_ham` int(10) unsigned DEFAULT NULL,
  `count_spam` int(10) unsigned DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fs2_b8_wordlist`
--

INSERT INTO `fs2_b8_wordlist` (`token`, `count_ham`, `count_spam`) VALUES
('b8*dbversion', 3, NULL),
('b8*texts', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fs2_cimg`
--

DROP TABLE IF EXISTS `fs2_cimg`;
CREATE TABLE IF NOT EXISTS `fs2_cimg` (
`id` mediumint(8) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(4) NOT NULL,
  `hasthumb` tinyint(1) NOT NULL,
  `cat` mediumint(8) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `fs2_cimg_cats`
--

DROP TABLE IF EXISTS `fs2_cimg_cats`;
CREATE TABLE IF NOT EXISTS `fs2_cimg_cats` (
`id` mediumint(8) NOT NULL,
  `name` varchar(25) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `fs2_cimg_cats`
--

INSERT INTO `fs2_cimg_cats` (`id`, `name`, `description`) VALUES
(1, 'Test', ''),
(2, 'dfgdf', 'gfgfg');

-- --------------------------------------------------------

--
-- Table structure for table `fs2_comments`
--

DROP TABLE IF EXISTS `fs2_comments`;
CREATE TABLE IF NOT EXISTS `fs2_comments` (
`comment_id` mediumint(8) NOT NULL,
  `content_id` mediumint(8) NOT NULL,
  `content_type` varchar(32) NOT NULL,
  `comment_poster` varchar(32) DEFAULT NULL,
  `comment_poster_id` mediumint(8) DEFAULT NULL,
  `comment_poster_ip` varchar(16) NOT NULL,
  `comment_date` int(11) DEFAULT NULL,
  `comment_title` varchar(100) DEFAULT NULL,
  `comment_text` text,
  `comment_classification` tinyint(4) NOT NULL DEFAULT '0',
  `spam_probability` float NOT NULL DEFAULT '0.5',
  `needs_update` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `fs2_comments`
--

INSERT INTO `fs2_comments` (`comment_id`, `content_id`, `content_type`, `comment_poster`, `comment_poster_id`, `comment_poster_ip`, `comment_date`, `comment_title`, `comment_text`, `comment_classification`, `spam_probability`, `needs_update`) VALUES
(3, 5, 'news', '1', 1, '127.0.0.1', 1306441173, 'hans', 'hans', 1, 0.5, 0),
(6, 11, 'dl', '1', 1, '::1', 1373196687, 'test', 'test', 0, 0.5, 0),
(7, 45, 'news', '1', 1, '127.0.0.1', 1421365902, 'test', 'test', 1, 0.5, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fs2_config`
--

DROP TABLE IF EXISTS `fs2_config`;
CREATE TABLE IF NOT EXISTS `fs2_config` (
  `config_name` varchar(30) NOT NULL,
  `config_data` text NOT NULL,
  `config_loadhook` varchar(255) NOT NULL DEFAULT 'none'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fs2_config`
--

INSERT INTO `fs2_config` (`config_name`, `config_data`, `config_loadhook`) VALUES
('main', '{"title":"Hansen''s wunderbare Welt","dyn_title":"1","dyn_title_ext":"{..title..} \\u00bb {..ext..}","admin_mail":"mail@sweil.de","description":"","keywords":"","publisher":"","copyright":"","style_id":"2","allow_other_designs":"1","show_favicon":"1","home":"0","home_text":"","language_text":"de_DE","feed":"rss20","date":"d.m.Y","time":"H:i \\\\U\\\\h\\\\r","datetime":"d.m.Y, H:i \\\\U\\\\h\\\\r","timezone":"Europe\\/Berlin","auto_forward":"4","page":"<div align=\\"center\\" style=\\"width:270px;\\"><div style=\\"width:70px; float:left;\\">{..prev..}&nbsp;<\\/div>Seite <b>{..page_number..}<\\/b> von <b>{..total_pages..}<\\/b><div style=\\"width:70px; float:right;\\">&nbsp;{..next..}<\\/div><\\/div>","page_prev":"<a href=\\"{..url..}\\">\\u00ab&nbsp;zur\\u00fcck<\\/a>&nbsp|","page_next":"|&nbsp<a href=\\"{..url..}\\">weiter&nbsp\\u00bb<\\/a>","style_tag":"lightfrog","version":"2.alix6","url_style":"seo","protocol":"http:\\/\\/","url":"localhost\\/fs2\\/www\\/","other_protocol":"1","count_referers":"1"}', 'startup'),
('system', '{"var_loop":20}', 'startup'),
('env', '{}', ''),
('info', '{}', 'startup'),
('articles', '{"acp_per_page":"50","html_code":"2","fs_code":"4","para_handling":"4","cat_pic_x":"150","cat_pic_y":"150","cat_pic_size":"1024","com_rights":"0","com_antispam":"0","com_sort":"0","acp_view":"2"}', 'none'),
('search', '{"id":"0","search_num_previews":"10","search_and":"AND, and, &&","search_or":"OR, or, ||","search_xor":"XOR, xor","search_not":"!, -","search_wildcard":"*, %","search_min_word_length":"3","search_allow_phonetic":"1","search_use_stopwords":"1"}', 'none'),
('cronjobs', '{"last_cronjob_time":"1421719443","last_cronjob_time_daily":"1421638281","last_cronjob_time_hourly":"1421719201","search_index_update":"1","ref_cron":"1","ref_days":"5","ref_hits":"5","ref_contact":"first","ref_age":"older","ref_amount":"less"}', 'startup'),
('captcha', '{"captcha_bg_color":"FAFCF1","captcha_bg_transparent":"0","captcha_text_color":"AB30AB","captcha_first_lower":"1","captcha_first_upper":"5","captcha_second_lower":"1","captcha_second_upper":"5","captcha_use_addition":"1","captcha_use_subtraction":"1","captcha_use_multiplication":"0","captcha_create_easy_arithmetics":"1","captcha_x":"58","captcha_y":"18","captcha_show_questionmark":"0","captcha_use_spaces":"1","captcha_show_multiplication_as_x":"1","captcha_start_text_x":"0","captcha_start_text_y":"0","captcha_font_size":"5","captcha_font_file":""}', 'none'),
('downloads', '{"screen_x":"1024","screen_y":"768","thumb_x":"120","thumb_y":"90","quickinsert":"test''","dl_rights":"2","dl_show_sub_cats":"0","dl_comments":"1"}', 'none'),
('affiliates', '{"partner_anzahl":"5","small_x":"88","small_y":"31","big_x":"468","big_y":"60","big_allow":"1","file_size":"1024","small_allow":"0"}', 'none'),
('news', '{"num_news":"11","num_head":"5","html_code":"2","fs_code":"4","para_handling":"4","cat_pic_x":"150","cat_pic_y":"150","cat_pic_size":"1024","com_rights":"2","com_antispam":"2","news_headline_lenght":"20","acp_per_page":"3","acp_view":"2","com_sort":"DESC","news_headline_ext":"&nbsp;...","acp_force_cat_selection":"1"}', 'none'),
('video_player', '{"cfg_player_x":"500","cfg_player_y":"280","cfg_autoplay":"0","cfg_autoload":"1","cfg_buffer":"5","cfg_buffermessage":"Buffering _n_","cfg_buffercolor":"#FFFFFF","cfg_bufferbgcolor":"#000000","cfg_buffershowbg":"0","cfg_titlesize":"20","cfg_titlecolor":"#FFFFFF","cfg_margin":"5","cfg_showstop":"1","cfg_showvolume":"1","cfg_showtime":"1","cfg_showplayer":"autohide","cfg_showloading":"always","cfg_showfullscreen":"1","cfg_showmouse":"autohide","cfg_loop":"0","cfg_playercolor":"#a6a6a6","cfg_loadingcolor":"#000000","cfg_bgcolor":"#FAFCF1","cfg_bgcolor1":"#E7E7E7","cfg_bgcolor2":"#cccccc","cfg_buttoncolor":"#000000","cfg_buttonovercolor":"#E7E7E7","cfg_slidercolor1":"#cccccc","cfg_slidercolor2":"#bbbbbb","cfg_sliderovercolor":"#E7E7E7","cfg_loadonstop":"1","cfg_onclick":"playpause","cfg_ondoubleclick":"fullscreen","cfg_playertimeout":"1500","cfg_videobgcolor":"#000000","cfg_volume":"100","cfg_shortcut":"1","cfg_playeralpha":"100","cfg_top1_url":"","cfg_top1_x":"0","cfg_top1_y":"0","cfg_showiconplay":"1","cfg_iconplaycolor":"#FFFFFF","cfg_iconplaybgcolor":"#000000","cfg_iconplaybgalpha":"75","cfg_showtitleandstartimage":"0"}', 'none'),
('polls', '{"answerbar_width":"100","answerbar_type":"0"}', 'none'),
('press', '{"game_navi":"1","cat_navi":"1","lang_navi":"0","show_press":"0","show_root":"0","order_by":"press_date","order_type":"desc"}', 'none'),
('preview_images', '{"active":"1","type_priority":"1","use_priority_only":"0","timed_deltime":"604800"}', 'none'),
('groups', '{"group_pic_x":"250","group_pic_y":"25","group_pic_size":"100"}', 'none'),
('screens', '{"screen_x":"3500","screen_y":"3500","screen_thumb_x":"120","screen_thumb_y":"90","screen_size":"2048","screen_rows":"5","screen_cols":"3","screen_order":"id","screen_sort":"desc","show_type":"1","show_size_x":"950","show_size_y":"700","show_img_x":"800","show_img_y":"600","wp_x":"2000","wp_y":"2000","wp_thumb_x":"200","wp_thumb_y":"150","wp_size":"2048","wp_rows":"6","wp_cols":"2","wp_order":"id","wp_sort":"desc"}', 'none'),
('users', '{"user_per_page":"30","registration_antispam":"1","avatar_x":"110","avatar_y":"110","avatar_size":"20","reg_date_format":"l, j. F Y","user_list_reg_date_format":"j. F Y"}', 'none'),
('social_meta_tags', '{"use_google_plus":"1","google_plus_page":"+TheWitcherDE","use_schema_org":"1","use_twitter_card":"1","twitter_site":"@TheWitcherDE","use_open_graph":"1","fb_admins":"1234,5678","og_section":"Technology","site_name":"","default_image":"","news_cat_prepend":": ","enable_news":"1","enable_articles":"1","enable_downloads":"1","use_news_cat_prepend":"1","use_external_images":""}', 'none');

-- --------------------------------------------------------

--
-- Table structure for table `fs2_counter`
--

DROP TABLE IF EXISTS `fs2_counter`;
CREATE TABLE IF NOT EXISTS `fs2_counter` (
  `id` tinyint(1) NOT NULL,
  `visits` int(11) unsigned NOT NULL DEFAULT '0',
  `hits` int(11) unsigned NOT NULL DEFAULT '0',
  `user` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `artikel` smallint(6) unsigned NOT NULL DEFAULT '0',
  `news` smallint(6) unsigned NOT NULL DEFAULT '0',
  `comments` mediumint(8) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fs2_counter`
--

INSERT INTO `fs2_counter` (`id`, `visits`, `hits`, `user`, `artikel`, `news`, `comments`) VALUES
(1, 114, 3742, 5, 6, 18, 3);

-- --------------------------------------------------------

--
-- Table structure for table `fs2_counter_ref`
--

DROP TABLE IF EXISTS `fs2_counter_ref`;
CREATE TABLE IF NOT EXISTS `fs2_counter_ref` (
  `ref_url` varchar(255) DEFAULT NULL,
  `ref_count` int(11) DEFAULT NULL,
  `ref_first` int(11) DEFAULT NULL,
  `ref_last` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fs2_counter_ref`
--

INSERT INTO `fs2_counter_ref` (`ref_url`, `ref_count`, `ref_first`, `ref_last`) VALUES
('http://localhost/', 55, 1302557491, 1307980522),
('http://localhost/fs2/', 46, 1316955935, 1421714721);

-- --------------------------------------------------------

--
-- Table structure for table `fs2_counter_stat`
--

DROP TABLE IF EXISTS `fs2_counter_stat`;
CREATE TABLE IF NOT EXISTS `fs2_counter_stat` (
  `s_year` int(4) NOT NULL DEFAULT '0',
  `s_month` int(2) NOT NULL DEFAULT '0',
  `s_day` int(2) NOT NULL DEFAULT '0',
  `s_visits` int(11) DEFAULT NULL,
  `s_hits` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fs2_counter_stat`
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
(2012, 7, 5, 0, 2),
(2012, 7, 8, 0, 7),
(2012, 7, 9, 1, 65),
(2012, 10, 25, 0, 22),
(2012, 11, 8, 0, 16),
(2012, 11, 9, 2, 45),
(2012, 11, 10, 0, 33),
(2012, 11, 11, 1, 41),
(2012, 11, 12, 1, 89),
(2012, 11, 13, 1, 1),
(2013, 2, 27, 1, 1),
(2013, 5, 12, 1, 2),
(2013, 6, 28, 2, 20),
(2013, 6, 29, 1, 1),
(2013, 7, 4, 1, 13),
(2013, 7, 5, 3, 131),
(2013, 7, 6, 1, 134),
(2013, 7, 7, 1, 42),
(2013, 7, 8, 1, 39),
(2013, 7, 9, 1, 1),
(2013, 7, 14, 1, 31),
(2014, 4, 17, 1, 35),
(2014, 5, 20, 1, 2),
(2015, 1, 2, 1, 14),
(2015, 1, 3, 1, 1),
(2015, 1, 4, 2, 125),
(2015, 1, 5, 1, 42),
(2015, 1, 14, 1, 25),
(2015, 1, 15, 1, 1),
(2015, 1, 16, 1, 36),
(2015, 1, 17, 1, 101),
(2015, 1, 18, 1, 47),
(2015, 1, 19, 1, 1),
(2015, 1, 20, 1, 56);

-- --------------------------------------------------------

--
-- Table structure for table `fs2_dl`
--

DROP TABLE IF EXISTS `fs2_dl`;
CREATE TABLE IF NOT EXISTS `fs2_dl` (
`dl_id` mediumint(8) NOT NULL,
  `cat_id` mediumint(8) DEFAULT NULL,
  `user_id` mediumint(8) DEFAULT NULL,
  `dl_date` int(11) DEFAULT NULL,
  `dl_name` varchar(100) DEFAULT NULL,
  `dl_text` text,
  `dl_autor` varchar(100) DEFAULT NULL,
  `dl_autor_url` varchar(255) DEFAULT NULL,
  `dl_open` tinyint(4) DEFAULT NULL,
  `dl_search_update` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `fs2_dl`
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
-- Table structure for table `fs2_dl_cat`
--

DROP TABLE IF EXISTS `fs2_dl_cat`;
CREATE TABLE IF NOT EXISTS `fs2_dl_cat` (
`cat_id` mediumint(8) NOT NULL,
  `subcat_id` mediumint(8) NOT NULL DEFAULT '0',
  `cat_name` varchar(100) DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `fs2_dl_cat`
--

INSERT INTO `fs2_dl_cat` (`cat_id`, `subcat_id`, `cat_name`) VALUES
(1, 0, 'Downloads'),
(2, 1, 'test2'),
(4, 0, 'sdfsdf'),
(5, 4, 'hans'),
(6, 5, 'wurst');

-- --------------------------------------------------------

--
-- Table structure for table `fs2_dl_files`
--

DROP TABLE IF EXISTS `fs2_dl_files`;
CREATE TABLE IF NOT EXISTS `fs2_dl_files` (
  `dl_id` mediumint(8) DEFAULT NULL,
`file_id` mediumint(8) NOT NULL,
  `file_count` mediumint(8) NOT NULL DEFAULT '0',
  `file_name` varchar(100) DEFAULT NULL,
  `file_url` varchar(255) DEFAULT NULL,
  `file_size` mediumint(8) NOT NULL DEFAULT '0',
  `file_is_mirror` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `fs2_dl_files`
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
-- Table structure for table `fs2_editor_config`
--

DROP TABLE IF EXISTS `fs2_editor_config`;
CREATE TABLE IF NOT EXISTS `fs2_editor_config` (
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
  `do_smilies` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fs2_editor_config`
--

INSERT INTO `fs2_editor_config` (`id`, `smilies_rows`, `smilies_cols`, `textarea_width`, `textarea_height`, `bold`, `italic`, `underline`, `strike`, `center`, `font`, `color`, `size`, `list`, `numlist`, `img`, `cimg`, `url`, `home`, `email`, `code`, `quote`, `noparse`, `smilies`, `do_bold`, `do_italic`, `do_underline`, `do_strike`, `do_center`, `do_font`, `do_color`, `do_size`, `do_list`, `do_numlist`, `do_img`, `do_cimg`, `do_url`, `do_home`, `do_email`, `do_code`, `do_quote`, `do_noparse`, `do_smilies`) VALUES
(1, 5, 2, 355, 120, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 1, 0, 1, 0, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `fs2_email`
--

DROP TABLE IF EXISTS `fs2_email`;
CREATE TABLE IF NOT EXISTS `fs2_email` (
  `id` tinyint(1) NOT NULL DEFAULT '1',
  `signup` text NOT NULL,
  `change_password` text NOT NULL,
  `delete_account` text NOT NULL,
  `change_password_ack` text NOT NULL,
  `use_admin_mail` tinyint(1) NOT NULL DEFAULT '1',
  `email` varchar(100) NOT NULL,
  `html` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fs2_email`
--

INSERT INTO `fs2_email` (`id`, `signup`, `change_password`, `delete_account`, `change_password_ack`, `use_admin_mail`, `email`, `html`) VALUES
(1, 'Hallo  {..user_name..},\r\n\r\nDu hast dich bei $VAR(page_title) registriert. Deine Zugangsdaten sind:\r\n\r\nBenutzername: {..user_name..}\r\nPasswort: {..new_password..}\r\n\r\nFalls du deine Daten ändern möchtest, kannst du das gerne auf deiner [url=$URL(user_edit[1])]Profilseite[/url] tun.\r\n\r\nDein Team von $VAR(page_title)!', 'Hallo {..user_name..},\r\n\r\nDein Passwort bei $VAR(page_title) wurde geändert. Deine neuen Zugangsdaten sind:\r\n\r\nBenutzername: {..user_name..}\r\nPasswort: {..new_password..}\r\n\r\nFalls du deine Daten ändern möchtest, kannst du das gerne auf deiner [url=$URL(user_edit[1])]Profilseite[/url] tun.\r\n\r\nDein Team von $VAR(page_title)!', 'Hallo {username},\r\n\r\nSchade, dass du dich von unserer Seite abgemeldet hast. Falls du es dir doch noch anders überlegen willst, [url={virtualhost}]kannst du ja nochmal rein schauen[/url].\r\n\r\nDein Webseiten-Team!', 'Hallo {..user_name..},\r\n\r\nDu hast für deinen Account auf $VAR(page_title) ein neues Passwort angefordert. Um den Vorgang abzuschließen musst du nur noch innerhalb der nächsten zwei Tage den folgenden Link anklicken: [url={..new_password_url..}]Neues Passwort setzen[/url]\r\n\r\nFalls du [b]kein[/b] neues Passwort angefordert hast, ignoriere diese E-Mail einfach. Du kannst dich weiterhin mit deinem bisherigen Passwort bei uns anmelden.\r\n\r\nDein Team von $VAR(page_title)!', 1, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `fs2_ftp`
--

DROP TABLE IF EXISTS `fs2_ftp`;
CREATE TABLE IF NOT EXISTS `fs2_ftp` (
`ftp_id` mediumint(9) NOT NULL,
  `ftp_title` varchar(100) NOT NULL,
  `ftp_type` varchar(10) NOT NULL,
  `ftp_url` varchar(255) NOT NULL,
  `ftp_user` varchar(255) NOT NULL,
  `ftp_pw` varchar(255) NOT NULL,
  `ftp_ssl` tinyint(1) NOT NULL,
  `ftp_http_url` varchar(255) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `fs2_ftp`
--

INSERT INTO `fs2_ftp` (`ftp_id`, `ftp_title`, `ftp_type`, `ftp_url`, `ftp_user`, `ftp_pw`, `ftp_ssl`, `ftp_http_url`) VALUES
(1, 'DL-Server', 'dl', 'ftp.suse.de', 'anonymous', 'anonymous', 0, 'ftp://ftp.suse.de');

-- --------------------------------------------------------

--
-- Table structure for table `fs2_hashes`
--

DROP TABLE IF EXISTS `fs2_hashes`;
CREATE TABLE IF NOT EXISTS `fs2_hashes` (
`id` mediumint(8) NOT NULL,
  `hash` varchar(40) CHARACTER SET utf8 NOT NULL,
  `type` varchar(20) CHARACTER SET utf8 NOT NULL,
  `typeId` mediumint(8) NOT NULL,
  `deleteTime` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fs2_news`
--

DROP TABLE IF EXISTS `fs2_news`;
CREATE TABLE IF NOT EXISTS `fs2_news` (
`news_id` mediumint(8) NOT NULL,
  `cat_id` smallint(6) DEFAULT NULL,
  `user_id` mediumint(8) DEFAULT NULL,
  `news_date` int(11) DEFAULT NULL,
  `news_title` varchar(255) DEFAULT NULL,
  `news_text` text,
  `news_active` tinyint(1) NOT NULL DEFAULT '1',
  `news_comments_allowed` tinyint(1) NOT NULL DEFAULT '1',
  `news_search_update` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=47 ;

--
-- Dumping data for table `fs2_news`
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
(44, 2, 1, 1340724960, 'test', 'test', 1, 1, 0),
(45, 1, 1, 1373021880, 'test', 'test', 1, 1, 0),
(46, 2, 1, 1373021880, 'test', '[player]2[/player]', 1, 1, 1421565505);

-- --------------------------------------------------------

--
-- Table structure for table `fs2_news_cat`
--

DROP TABLE IF EXISTS `fs2_news_cat`;
CREATE TABLE IF NOT EXISTS `fs2_news_cat` (
`cat_id` smallint(6) NOT NULL,
  `cat_name` varchar(100) DEFAULT NULL,
  `cat_description` text NOT NULL,
  `cat_date` int(11) NOT NULL,
  `cat_user` mediumint(8) NOT NULL DEFAULT '1'
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `fs2_news_cat`
--

INSERT INTO `fs2_news_cat` (`cat_id`, `cat_name`, `cat_description`, `cat_date`, `cat_user`) VALUES
(1, 'News', '', 1302517148, 1),
(2, 'The Witcher: Assassins of Kings', '', 1307814857, 1);

-- --------------------------------------------------------

--
-- Table structure for table `fs2_news_links`
--

DROP TABLE IF EXISTS `fs2_news_links`;
CREATE TABLE IF NOT EXISTS `fs2_news_links` (
  `news_id` mediumint(8) DEFAULT NULL,
`link_id` mediumint(8) NOT NULL,
  `link_name` varchar(100) DEFAULT NULL,
  `link_url` varchar(255) DEFAULT NULL,
  `link_target` tinyint(4) DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=105 ;

--
-- Dumping data for table `fs2_news_links`
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
-- Table structure for table `fs2_partner`
--

DROP TABLE IF EXISTS `fs2_partner`;
CREATE TABLE IF NOT EXISTS `fs2_partner` (
`partner_id` smallint(3) unsigned NOT NULL,
  `partner_name` varchar(150) NOT NULL,
  `partner_link` varchar(250) NOT NULL,
  `partner_beschreibung` text NOT NULL,
  `partner_permanent` tinyint(1) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `fs2_partner`
--

INSERT INTO `fs2_partner` (`partner_id`, `partner_name`, `partner_link`, `partner_beschreibung`, `partner_permanent`) VALUES
(1, 'asdasd', 'http://asasdasd', 'asdasdasasdasd', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fs2_player`
--

DROP TABLE IF EXISTS `fs2_player`;
CREATE TABLE IF NOT EXISTS `fs2_player` (
`video_id` mediumint(8) NOT NULL,
  `video_type` tinyint(1) NOT NULL DEFAULT '1',
  `video_x` text NOT NULL,
  `video_title` varchar(100) NOT NULL,
  `video_lenght` smallint(6) NOT NULL DEFAULT '0',
  `video_desc` text NOT NULL,
  `dl_id` mediumint(8) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `fs2_player`
--

INSERT INTO `fs2_player` (`video_id`, `video_type`, `video_x`, `video_title`, `video_lenght`, `video_desc`, `dl_id`) VALUES
(1, 1, 'http://dl.worldofplayers.de/wop/witcher/witcher2/sonstiges/ausgepackt.flv', 'Test', 80, 'Test', 0),
(2, 1, 'http://localhost/cdpr-gc-video.flv', 'test', 0, 'test', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fs2_poll`
--

DROP TABLE IF EXISTS `fs2_poll`;
CREATE TABLE IF NOT EXISTS `fs2_poll` (
`poll_id` mediumint(8) NOT NULL,
  `poll_quest` varchar(255) DEFAULT NULL,
  `poll_start` int(11) DEFAULT NULL,
  `poll_end` int(11) DEFAULT NULL,
  `poll_type` tinyint(4) DEFAULT NULL,
  `poll_participants` mediumint(8) NOT NULL DEFAULT '0'
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `fs2_poll`
--

INSERT INTO `fs2_poll` (`poll_id`, `poll_quest`, `poll_start`, `poll_end`, `poll_type`, `poll_participants`) VALUES
(1, 'wurst', 1306414980, 1309093380, 1, 0),
(2, 'ok', 1306414980, 1306416540, 0, 0),
(3, 'test2', 1306416480, 1309094880, 1, 1),
(4, 'Test1', 1316985420, 1319577420, 0, 1),
(5, 'Test2', 1316985420, 1319577420, 0, 1),
(6, 'Test3', 1316990760, 1319582760, 1, 1),
(7, 'Test4', 1316990760, 1319582760, 0, 1),
(8, 'Wurst ''oder" Käse?', 1340789940, 1354012740, 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `fs2_poll_answers`
--

DROP TABLE IF EXISTS `fs2_poll_answers`;
CREATE TABLE IF NOT EXISTS `fs2_poll_answers` (
  `poll_id` mediumint(8) DEFAULT NULL,
`answer_id` mediumint(8) NOT NULL,
  `answer` varchar(255) DEFAULT NULL,
  `answer_count` mediumint(8) NOT NULL DEFAULT '0'
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `fs2_poll_answers`
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
(8, 24, 'Käse', 1);

-- --------------------------------------------------------

--
-- Table structure for table `fs2_poll_voters`
--

DROP TABLE IF EXISTS `fs2_poll_voters`;
CREATE TABLE IF NOT EXISTS `fs2_poll_voters` (
`voter_id` mediumint(8) NOT NULL,
  `poll_id` mediumint(8) NOT NULL DEFAULT '0',
  `ip_address` varchar(15) NOT NULL DEFAULT '0.0.0.0',
  `time` int(32) NOT NULL DEFAULT '0'
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `fs2_press`
--

DROP TABLE IF EXISTS `fs2_press`;
CREATE TABLE IF NOT EXISTS `fs2_press` (
`press_id` smallint(6) NOT NULL,
  `press_title` varchar(255) NOT NULL,
  `press_url` varchar(255) NOT NULL,
  `press_date` int(12) NOT NULL,
  `press_intro` text NOT NULL,
  `press_text` text NOT NULL,
  `press_note` text NOT NULL,
  `press_lang` int(11) NOT NULL,
  `press_game` tinyint(2) NOT NULL,
  `press_cat` tinyint(2) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `fs2_press`
--

INSERT INTO `fs2_press` (`press_id`, `press_title`, `press_url`, `press_date`, `press_intro`, `press_text`, `press_note`, `press_lang`, `press_game`, `press_cat`) VALUES
(1, 'nix', 'http://ASDASD', 1306368000, '', 'ASD', '', 2, 4, 6),
(3, 'TEST', '3', 1306368000, '', 'ASD', '', 2, 4, 6);

-- --------------------------------------------------------

--
-- Table structure for table `fs2_press_admin`
--

DROP TABLE IF EXISTS `fs2_press_admin`;
CREATE TABLE IF NOT EXISTS `fs2_press_admin` (
`id` mediumint(8) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `fs2_press_admin`
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
-- Table structure for table `fs2_screen`
--

DROP TABLE IF EXISTS `fs2_screen`;
CREATE TABLE IF NOT EXISTS `fs2_screen` (
`screen_id` mediumint(8) NOT NULL,
  `cat_id` smallint(6) unsigned DEFAULT NULL,
  `screen_name` varchar(255) DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `fs2_screen`
--

INSERT INTO `fs2_screen` (`screen_id`, `cat_id`, `screen_name`) VALUES
(11, 1, ''),
(12, 1, ''),
(13, 1, ''),
(14, 1, ''),
(15, 1, ''),
(17, 1, ''),
(18, 1, ''),
(19, 1, ''),
(20, 1, ''),
(21, 1, ''),
(22, 1, ''),
(23, 1, ''),
(28, 1, ''),
(29, 1, 'sdfsdf');

-- --------------------------------------------------------

--
-- Table structure for table `fs2_screen_cat`
--

DROP TABLE IF EXISTS `fs2_screen_cat`;
CREATE TABLE IF NOT EXISTS `fs2_screen_cat` (
`cat_id` smallint(6) NOT NULL,
  `cat_name` varchar(255) DEFAULT NULL,
  `cat_type` tinyint(1) NOT NULL DEFAULT '0',
  `cat_visibility` tinyint(1) NOT NULL DEFAULT '1',
  `cat_date` int(11) NOT NULL DEFAULT '0',
  `randompic` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `fs2_screen_cat`
--

INSERT INTO `fs2_screen_cat` (`cat_id`, `cat_name`, `cat_type`, `cat_visibility`, `cat_date`, `randompic`) VALUES
(1, 'Screenshots', 1, 1, 1302517148, 1),
(2, 'Wallpaper', 2, 1, 1302517148, 0),
(5, 'Test', 1, 1, 1352456924, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fs2_screen_random`
--

DROP TABLE IF EXISTS `fs2_screen_random`;
CREATE TABLE IF NOT EXISTS `fs2_screen_random` (
`random_id` mediumint(8) NOT NULL,
  `screen_id` mediumint(8) NOT NULL,
  `start` int(11) NOT NULL,
  `end` int(11) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `fs2_search_index`
--

DROP TABLE IF EXISTS `fs2_search_index`;
CREATE TABLE IF NOT EXISTS `fs2_search_index` (
`search_index_id` mediumint(8) NOT NULL,
  `search_index_word_id` mediumint(8) NOT NULL DEFAULT '0',
  `search_index_type` enum('news','articles','dl') NOT NULL DEFAULT 'news',
  `search_index_document_id` mediumint(8) NOT NULL DEFAULT '0',
  `search_index_count` smallint(5) NOT NULL DEFAULT '0'
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2857 ;

--
-- Dumping data for table `fs2_search_index`
--

INSERT INTO `fs2_search_index` (`search_index_id`, `search_index_word_id`, `search_index_type`, `search_index_document_id`, `search_index_count`) VALUES
(2560, 23, 'news', 1, 1),
(2559, 22, 'news', 1, 1),
(2558, 21, 'news', 1, 1),
(2557, 20, 'news', 1, 1),
(2556, 19, 'news', 1, 1),
(2555, 18, 'news', 1, 1),
(2554, 17, 'news', 1, 1),
(2553, 16, 'news', 1, 1),
(2552, 15, 'news', 1, 1),
(2551, 14, 'news', 1, 1),
(2550, 13, 'news', 1, 1),
(2549, 12, 'news', 1, 1),
(2548, 11, 'news', 1, 1),
(2547, 10, 'news', 1, 2),
(2546, 9, 'news', 1, 1),
(2545, 8, 'news', 1, 1),
(2544, 7, 'news', 1, 1),
(2543, 6, 'news', 1, 1),
(2542, 5, 'news', 1, 1),
(2652, 33, 'articles', 2, 2),
(2766, 162, 'dl', 11, 1),
(2765, 161, 'dl', 11, 1),
(2764, 160, 'dl', 11, 1),
(2763, 159, 'dl', 11, 1),
(2762, 158, 'dl', 10, 1),
(2761, 157, 'dl', 10, 1),
(2760, 156, 'dl', 10, 1),
(2759, 155, 'dl', 10, 1),
(2758, 154, 'dl', 10, 1),
(2757, 153, 'dl', 9, 1),
(2756, 2, 'dl', 9, 1),
(2755, 1, 'dl', 9, 1),
(2754, 152, 'dl', 1, 1),
(2753, 34, 'dl', 1, 1),
(2752, 33, 'dl', 1, 1),
(2751, 65, 'dl', 7, 1),
(2750, 151, 'dl', 6, 1),
(2749, 65, 'dl', 6, 1),
(2748, 66, 'dl', 5, 1),
(2747, 65, 'dl', 5, 1),
(2746, 34, 'dl', 4, 1),
(2745, 34, 'dl', 3, 1),
(2744, 34, 'dl', 2, 1),
(2852, 163, 'articles', 1, 3),
(2851, 150, 'articles', 1, 2),
(2850, 149, 'articles', 1, 2),
(2849, 148, 'articles', 1, 2),
(2848, 147, 'articles', 1, 2),
(2847, 146, 'articles', 1, 2),
(2846, 145, 'articles', 1, 3),
(2845, 144, 'articles', 1, 3),
(2844, 143, 'articles', 1, 3),
(2843, 142, 'articles', 1, 3),
(2842, 140, 'articles', 1, 3),
(2541, 4, 'news', 1, 1),
(2540, 3, 'news', 1, 1),
(2539, 2, 'news', 1, 1),
(2538, 1, 'news', 1, 5),
(2841, 139, 'articles', 1, 2),
(2840, 138, 'articles', 1, 2),
(2839, 137, 'articles', 1, 2),
(2838, 136, 'articles', 1, 4),
(2837, 135, 'articles', 1, 8),
(2836, 134, 'articles', 1, 4),
(2835, 133, 'articles', 1, 1),
(2834, 132, 'articles', 1, 1),
(2833, 131, 'articles', 1, 1),
(2832, 130, 'articles', 1, 1),
(2831, 129, 'articles', 1, 1),
(2830, 128, 'articles', 1, 4),
(2829, 127, 'articles', 1, 2),
(2828, 126, 'articles', 1, 2),
(2827, 125, 'articles', 1, 4),
(2826, 124, 'articles', 1, 4),
(2825, 123, 'articles', 1, 1),
(2824, 122, 'articles', 1, 3),
(2823, 120, 'articles', 1, 16),
(2822, 119, 'articles', 1, 1),
(2821, 118, 'articles', 1, 1),
(2820, 117, 'articles', 1, 1),
(2819, 116, 'articles', 1, 1),
(2651, 45, 'news', 42, 1),
(2818, 115, 'articles', 1, 1),
(2817, 114, 'articles', 1, 2),
(2816, 113, 'articles', 1, 2),
(2815, 112, 'articles', 1, 2),
(2814, 111, 'articles', 1, 2),
(2813, 110, 'articles', 1, 3),
(2812, 109, 'articles', 1, 1),
(2811, 108, 'articles', 1, 1),
(2810, 107, 'articles', 1, 1),
(2809, 106, 'articles', 1, 1),
(2808, 105, 'articles', 1, 1),
(2807, 104, 'articles', 1, 3),
(2806, 103, 'articles', 1, 2),
(2805, 102, 'articles', 1, 1),
(2804, 101, 'articles', 1, 1),
(2803, 100, 'articles', 1, 1),
(2802, 99, 'articles', 1, 2),
(2801, 98, 'articles', 1, 1),
(2800, 97, 'articles', 1, 1),
(2799, 96, 'articles', 1, 1),
(2798, 95, 'articles', 1, 1),
(2797, 94, 'articles', 1, 35),
(2796, 93, 'articles', 1, 1),
(2795, 92, 'articles', 1, 1),
(2794, 91, 'articles', 1, 1),
(2793, 90, 'articles', 1, 1),
(2792, 89, 'articles', 1, 1),
(2650, 63, 'news', 39, 2),
(2649, 62, 'news', 39, 4),
(2648, 61, 'news', 39, 1),
(2647, 43, 'news', 39, 6),
(2646, 33, 'news', 39, 15),
(2645, 60, 'news', 38, 1),
(2791, 88, 'articles', 1, 1),
(2790, 87, 'articles', 1, 1),
(2789, 86, 'articles', 1, 1),
(2788, 85, 'articles', 1, 1),
(2787, 84, 'articles', 1, 1),
(2786, 83, 'articles', 1, 2),
(2785, 82, 'articles', 1, 1),
(2784, 81, 'articles', 1, 2),
(2783, 80, 'articles', 1, 1),
(2782, 79, 'articles', 1, 2),
(2781, 78, 'articles', 1, 2),
(2780, 77, 'articles', 1, 1),
(2779, 76, 'articles', 1, 1),
(2778, 75, 'articles', 1, 1),
(2777, 74, 'articles', 1, 2),
(2776, 73, 'articles', 1, 1),
(2775, 72, 'articles', 1, 2),
(2774, 71, 'articles', 1, 2),
(2773, 70, 'articles', 1, 1),
(2772, 69, 'articles', 1, 1),
(2771, 68, 'articles', 1, 1),
(2770, 67, 'articles', 1, 2),
(2769, 53, 'articles', 1, 1),
(2644, 59, 'news', 38, 1),
(2643, 58, 'news', 38, 1),
(2642, 57, 'news', 38, 1),
(2641, 56, 'news', 38, 1),
(2768, 43, 'articles', 1, 1),
(2767, 26, 'articles', 1, 2),
(2655, 66, 'articles', 4, 1),
(2654, 65, 'articles', 3, 1),
(2640, 55, 'news', 38, 1),
(2639, 52, 'news', 38, 1),
(2638, 33, 'news', 38, 1),
(2637, 54, 'news', 37, 3),
(2636, 53, 'news', 37, 3),
(2635, 52, 'news', 37, 3),
(2634, 51, 'news', 37, 4),
(2633, 33, 'news', 37, 1),
(2632, 50, 'news', 36, 1),
(2631, 49, 'news', 36, 1),
(2630, 8, 'news', 36, 2),
(2629, 48, 'news', 7, 1),
(2628, 36, 'news', 7, 1),
(2627, 35, 'news', 7, 2),
(2626, 33, 'news', 7, 1),
(2625, 33, 'news', 44, 2),
(2624, 47, 'news', 43, 1),
(2623, 46, 'news', 43, 1),
(2622, 45, 'news', 41, 1),
(2621, 44, 'news', 40, 1),
(2620, 43, 'news', 40, 1),
(2619, 42, 'news', 40, 1),
(2618, 41, 'news', 40, 1),
(2617, 40, 'news', 40, 1),
(2616, 39, 'news', 40, 1),
(2615, 38, 'news', 40, 1),
(2614, 37, 'news', 40, 1),
(2613, 8, 'news', 35, 2),
(2612, 33, 'news', 34, 1),
(2611, 32, 'news', 34, 1),
(2610, 31, 'news', 34, 1),
(2609, 30, 'news', 34, 1),
(2608, 29, 'news', 34, 1),
(2607, 28, 'news', 34, 1),
(2606, 27, 'news', 34, 1),
(2605, 26, 'news', 34, 1),
(2604, 25, 'news', 34, 1),
(2603, 24, 'news', 34, 1),
(2602, 23, 'news', 34, 1),
(2601, 22, 'news', 34, 1),
(2600, 21, 'news', 34, 1),
(2599, 20, 'news', 34, 1),
(2598, 19, 'news', 34, 1),
(2597, 18, 'news', 34, 1),
(2596, 17, 'news', 34, 1),
(2595, 16, 'news', 34, 1),
(2653, 64, 'articles', 3, 1),
(2594, 15, 'news', 34, 1),
(2593, 14, 'news', 34, 1),
(2592, 13, 'news', 34, 1),
(2591, 12, 'news', 34, 1),
(2590, 11, 'news', 34, 1),
(2589, 10, 'news', 34, 2),
(2588, 9, 'news', 34, 1),
(2587, 8, 'news', 34, 1),
(2586, 7, 'news', 34, 1),
(2585, 6, 'news', 34, 1),
(2584, 5, 'news', 34, 1),
(2583, 4, 'news', 34, 1),
(2582, 3, 'news', 34, 1),
(2581, 2, 'news', 34, 1),
(2580, 1, 'news', 34, 5),
(2579, 36, 'news', 33, 1),
(2578, 35, 'news', 33, 1),
(2577, 33, 'news', 33, 1),
(2576, 12, 'news', 33, 1),
(2575, 36, 'news', 32, 1),
(2574, 35, 'news', 32, 1),
(2573, 33, 'news', 32, 1),
(2572, 12, 'news', 32, 1),
(2571, 34, 'news', 5, 2),
(2570, 33, 'news', 5, 2),
(2569, 32, 'news', 1, 1),
(2568, 31, 'news', 1, 1),
(2567, 30, 'news', 1, 1),
(2566, 29, 'news', 1, 1),
(2565, 28, 'news', 1, 1),
(2564, 27, 'news', 1, 1),
(2563, 26, 'news', 1, 1),
(2562, 25, 'news', 1, 1),
(2561, 24, 'news', 1, 1),
(2853, 33, 'news', 45, 2),
(2854, 33, 'news', 46, 2),
(2855, 164, 'articles', 5, 1),
(2856, 165, 'articles', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `fs2_search_time`
--

DROP TABLE IF EXISTS `fs2_search_time`;
CREATE TABLE IF NOT EXISTS `fs2_search_time` (
`search_time_id` mediumint(8) NOT NULL,
  `search_time_type` enum('news','articles','dl') NOT NULL DEFAULT 'news',
  `search_time_document_id` mediumint(8) NOT NULL,
  `search_time_date` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=319 ;

--
-- Dumping data for table `fs2_search_time`
--

INSERT INTO `fs2_search_time` (`search_time_id`, `search_time_type`, `search_time_document_id`, `search_time_date`) VALUES
(315, 'dl', 11, 1341852981),
(314, 'dl', 10, 1341852981),
(313, 'dl', 9, 1341852981),
(312, 'dl', 1, 1341852981),
(311, 'dl', 7, 1341852981),
(310, 'dl', 6, 1341852981),
(309, 'dl', 5, 1341852981),
(308, 'dl', 4, 1341852981),
(307, 'dl', 3, 1341852981),
(306, 'dl', 2, 1341852981),
(305, 'articles', 1, 1361970764),
(304, 'articles', 4, 1341852981),
(303, 'articles', 3, 1341852981),
(302, 'articles', 2, 1341852981),
(295, 'news', 44, 1341852981),
(294, 'news', 43, 1341852981),
(293, 'news', 41, 1341852981),
(292, 'news', 40, 1341852981),
(291, 'news', 35, 1341852981),
(290, 'news', 34, 1341852981),
(289, 'news', 33, 1341852981),
(288, 'news', 32, 1341852981),
(287, 'news', 5, 1341852981),
(286, 'news', 1, 1341852981),
(299, 'news', 38, 1341852981),
(298, 'news', 37, 1341852981),
(297, 'news', 36, 1341852981),
(296, 'news', 7, 1341852981),
(301, 'news', 42, 1341852981),
(300, 'news', 39, 1341852981),
(316, 'news', 45, 1373021954),
(317, 'news', 46, 1373021954),
(318, 'articles', 5, 1373021954);

-- --------------------------------------------------------

--
-- Table structure for table `fs2_search_words`
--

DROP TABLE IF EXISTS `fs2_search_words`;
CREATE TABLE IF NOT EXISTS `fs2_search_words` (
`search_word_id` mediumint(8) NOT NULL,
  `search_word` varchar(32) NOT NULL DEFAULT ''
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=166 ;

--
-- Dumping data for table `fs2_search_words`
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
(37, 'ueberarbeitete'),
(38, 'umfrage'),
(39, 'besten'),
(40, 'entwicklerstudio'),
(41, 'aller'),
(42, 'zeiten'),
(43, 'news'),
(44, 'bkah'),
(45, ''),
(46, 'tsdsdfsd'),
(47, 'fsdfsdfsdfsdfsdf'),
(48, 'testvuuepdate'),
(49, 'tim'),
(50, 'timmy'),
(51, 'poll'),
(52, 'app'),
(53, 'system'),
(54, 'php'),
(55, 'dieseappgibtesnicht'),
(56, 'snippetnot'),
(57, 'nav'),
(58, 'navnot'),
(59, 'var'),
(60, 'varnot'),
(61, 'home'),
(62, 'comments'),
(63, 'amp'),
(64, 'fsdfsdf'),
(65, 'sdf'),
(66, 'sdfsdf'),
(67, 'fscode'),
(68, 'liste'),
(69, 'webseite'),
(70, 'bietet'),
(71, 'dir'),
(72, 'moeglichkeit'),
(73, 'einfache'),
(74, 'codes'),
(75, 'besseren'),
(76, 'darstellung'),
(77, 'deiner'),
(78, 'beitraege'),
(79, 'verwenden'),
(80, 'sogenannten'),
(81, 'fscodes'),
(82, 'erlauben'),
(83, 'html'),
(84, 'formatierungen'),
(85, 'dich'),
(86, 'auskennen'),
(87, 'musst'),
(88, 'hast'),
(89, 'verschiedene'),
(90, 'elemente'),
(91, 'deine'),
(92, 'einzubauen'),
(93, 'bzw'),
(94, 'text'),
(95, 'formatieren'),
(96, 'findest'),
(97, 'uebersicht'),
(98, 'verfuegbaren'),
(99, 'verwendung'),
(100, 'allerdings'),
(101, 'moeglich'),
(102, 'freigeschaltet'),
(103, 'table'),
(104, 'width'),
(105, 'cellpadding'),
(106, 'cellspacing'),
(107, 'border'),
(108, 'code'),
(109, 'beispiel'),
(110, 'fetter'),
(111, 'kursiver'),
(112, 'unterstrichener'),
(113, 'durchgestrichener'),
(114, 'zentrierter'),
(115, 'schriftart'),
(116, 'arial'),
(117, 'farbe'),
(118, 'rot'),
(119, 'farbcode'),
(120, 'groesse'),
(121, 'nbsp'),
(122, 'colspan'),
(123, 'linkadresse'),
(124, 'http'),
(125, 'www'),
(126, 'example'),
(127, 'com'),
(128, 'linktext'),
(129, 'seitenlink'),
(130, 'email'),
(131, 'adresse'),
(132, 'max'),
(133, 'mustermann'),
(134, 'beispieltext'),
(135, 'listenelement'),
(136, 'zitat'),
(137, 'schrift'),
(138, 'fester'),
(139, 'breite'),
(140, 'bildadresse'),
(141, 'url'),
(142, 'images'),
(143, 'icons'),
(144, 'logo'),
(145, 'gif'),
(146, 'grafik'),
(147, 'rechts'),
(148, 'platziert'),
(149, 'fliesst'),
(150, 'herum'),
(151, 'wsd'),
(152, 'testsdfsdfsdf'),
(153, 'asda'),
(154, 'hansens'),
(155, 'wunderbare'),
(156, 'weasddes'),
(157, 'wissensasd'),
(158, 'asdasd'),
(159, 'download'),
(160, 'libapr'),
(161, 'src'),
(162, 'rpm'),
(163, 'localhost'),
(164, 'sdfdfdf'),
(165, 'sdfsdfdf');

-- --------------------------------------------------------

--
-- Table structure for table `fs2_shop`
--

DROP TABLE IF EXISTS `fs2_shop`;
CREATE TABLE IF NOT EXISTS `fs2_shop` (
`artikel_id` mediumint(8) NOT NULL,
  `artikel_name` varchar(100) DEFAULT NULL,
  `artikel_url` varchar(255) DEFAULT NULL,
  `artikel_text` text,
  `artikel_preis` varchar(10) DEFAULT NULL,
  `artikel_hot` tinyint(4) DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `fs2_shop`
--

INSERT INTO `fs2_shop` (`artikel_id`, `artikel_name`, `artikel_url`, `artikel_text`, `artikel_preis`, `artikel_hot`) VALUES
(1, 'test', 'Amazon', 'Tolles Handy', 'EUR 12', 1),
(2, 'sd', 'sd', '', '2', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fs2_smilies`
--

DROP TABLE IF EXISTS `fs2_smilies`;
CREATE TABLE IF NOT EXISTS `fs2_smilies` (
`id` mediumint(8) NOT NULL,
  `replace_string` varchar(15) NOT NULL,
  `order` mediumint(8) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `fs2_smilies`
--

INSERT INTO `fs2_smilies` (`id`, `replace_string`, `order`) VALUES
(1, ':-)', 1),
(2, ':-(', 2),
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
-- Table structure for table `fs2_snippets`
--

DROP TABLE IF EXISTS `fs2_snippets`;
CREATE TABLE IF NOT EXISTS `fs2_snippets` (
`snippet_id` mediumint(8) NOT NULL,
  `snippet_tag` varchar(100) NOT NULL,
  `snippet_text` text NOT NULL,
  `snippet_active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `fs2_snippets`
--

INSERT INTO `fs2_snippets` (`snippet_id`, `snippet_tag`, `snippet_text`, `snippet_active`) VALUES
(1, '[%feeds%]', '<p>\r\n  <b>News-Feeds:</b>\r\n</p>\r\n<p align="center">\r\n  <a href="$URL(feed[xml=rss091])" target="_self"><img src="$VAR(style_icons)feeds/rss091.gif" alt="RSS 0.91" title="RSS 0.91" border="0"></a><br>\r\n  <a href="$URL(feed[xml=rss10])" target="_self"><img src="$VAR(style_icons)feeds/rss10.gif" alt="RSS 1.0" title="RSS 1.0" border="0"></a><br>\r\n  <a href="$URL(feed[xml=rss20])" target="_self"><img src="$VAR(style_icons)feeds/rss20.gif" alt="RSS 2.0" title="RSS 2.0" border="0"></a><br>\r\n  <a href="$URL(feed[xml=atom10])" target="_self"><img src="$VAR(style_icons)feeds/atom10.gif" alt="Atom 1.0" title="Atom 1.0" border="0"></a>\r\n</p>', 1);

-- --------------------------------------------------------

--
-- Table structure for table `fs2_styles`
--

DROP TABLE IF EXISTS `fs2_styles`;
CREATE TABLE IF NOT EXISTS `fs2_styles` (
`style_id` mediumint(8) NOT NULL,
  `style_tag` varchar(30) NOT NULL,
  `style_allow_use` tinyint(1) NOT NULL DEFAULT '1',
  `style_allow_edit` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `fs2_styles`
--

INSERT INTO `fs2_styles` (`style_id`, `style_tag`, `style_allow_use`, `style_allow_edit`) VALUES
(1, 'default', 0, 0),
(2, 'lightfrog', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `fs2_user`
--

DROP TABLE IF EXISTS `fs2_user`;
CREATE TABLE IF NOT EXISTS `fs2_user` (
`user_id` mediumint(8) NOT NULL,
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
  `user_skype` varchar(50) DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `fs2_user`
--

INSERT INTO `fs2_user` (`user_id`, `user_name`, `user_password`, `user_salt`, `user_mail`, `user_is_staff`, `user_group`, `user_is_admin`, `user_reg_date`, `user_show_mail`, `user_homepage`, `user_icq`, `user_aim`, `user_wlm`, `user_yim`, `user_skype`) VALUES
(1, 'admin', '7085d0eaaa5857f5ef88ab5ea7da9051', 'tL9z1MC3p3', 'mail@sweil.de', 1, 1, 1, 1302517173, 0, '', '', '', '', '', ''),
(2, 'test', '0c35412b82a52ff0f65cfd183cfca421', '1b6uGVHMFO', 'asd@hallo.de', 1, 0, 0, 1306274400, 0, '', '', '', '', '', ''),
(3, 'tester', 'fa085482aa8c10eb796792ea2ec938c1', 'KGJEcaHyVq', 'mail@moritzkornher.de', 0, 0, 0, 1373109834, 0, '', '', '', '', '', ''),
(4, 'tester5', 'dfc59ea79af442d663cdcddeb9616066', 'r3NQ66bmjF', 'blah@sweil.de', 0, 0, 0, 1373061600, 0, '', '', '', '', '', ''),
(5, 'Aqua', '3f1d2e6ae16444d2bfae4dac7b40f1b9', '7O7ELf5Qrz', 'test@sweil.de', 0, 0, 0, 1373124893, 0, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fs2_useronline`
--

DROP TABLE IF EXISTS `fs2_useronline`;
CREATE TABLE IF NOT EXISTS `fs2_useronline` (
  `ip` varchar(30) NOT NULL,
  `user_id` mediumint(8) NOT NULL DEFAULT '0',
  `date` int(30) DEFAULT NULL
) ENGINE=MEMORY DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fs2_useronline`
--

INSERT INTO `fs2_useronline` (`ip`, `user_id`, `date`) VALUES
('127.0.0.1', 1, 1421719444);

-- --------------------------------------------------------

--
-- Table structure for table `fs2_user_groups`
--

DROP TABLE IF EXISTS `fs2_user_groups`;
CREATE TABLE IF NOT EXISTS `fs2_user_groups` (
`user_group_id` mediumint(8) NOT NULL,
  `user_group_name` varchar(50) NOT NULL,
  `user_group_description` text,
  `user_group_title` varchar(50) DEFAULT NULL,
  `user_group_color` varchar(6) NOT NULL DEFAULT '-1',
  `user_group_highlight` tinyint(1) NOT NULL DEFAULT '0',
  `user_group_date` int(11) NOT NULL,
  `user_group_user` mediumint(8) NOT NULL DEFAULT '1'
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `fs2_user_groups`
--

INSERT INTO `fs2_user_groups` (`user_group_id`, `user_group_name`, `user_group_description`, `user_group_title`, `user_group_color`, `user_group_highlight`, `user_group_date`, `user_group_user`) VALUES
(1, 'Administrator', '', 'Administrator', '008800', 1, 1302472800, 1),
(2, 'test', '', '', '-1', 0, 1373148000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `fs2_user_permissions`
--

DROP TABLE IF EXISTS `fs2_user_permissions`;
CREATE TABLE IF NOT EXISTS `fs2_user_permissions` (
  `perm_id` varchar(255) NOT NULL,
  `x_id` mediumint(8) NOT NULL,
  `perm_for_group` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fs2_user_permissions`
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
-- Table structure for table `fs2_wallpaper`
--

DROP TABLE IF EXISTS `fs2_wallpaper`;
CREATE TABLE IF NOT EXISTS `fs2_wallpaper` (
`wallpaper_id` mediumint(8) NOT NULL,
  `wallpaper_name` varchar(255) NOT NULL,
  `wallpaper_title` varchar(255) NOT NULL,
  `cat_id` mediumint(8) NOT NULL DEFAULT '0'
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 PACK_KEYS=1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `fs2_wallpaper_sizes`
--

DROP TABLE IF EXISTS `fs2_wallpaper_sizes`;
CREATE TABLE IF NOT EXISTS `fs2_wallpaper_sizes` (
`size_id` mediumint(8) NOT NULL,
  `wallpaper_id` mediumint(8) NOT NULL DEFAULT '0',
  `size` varchar(255) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 PACK_KEYS=1 AUTO_INCREMENT=4 ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fs2_admin_cp`
--
ALTER TABLE `fs2_admin_cp`
 ADD PRIMARY KEY (`page_id`);

--
-- Indexes for table `fs2_aliases`
--
ALTER TABLE `fs2_aliases`
 ADD PRIMARY KEY (`alias_id`), ADD KEY `alias_go` (`alias_go`);

--
-- Indexes for table `fs2_announcement`
--
ALTER TABLE `fs2_announcement`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fs2_applets`
--
ALTER TABLE `fs2_applets`
 ADD PRIMARY KEY (`applet_id`), ADD UNIQUE KEY `applet_file` (`applet_file`);

--
-- Indexes for table `fs2_articles`
--
ALTER TABLE `fs2_articles`
 ADD PRIMARY KEY (`article_id`), ADD KEY `article_url` (`article_url`), ADD FULLTEXT KEY `article_text` (`article_title`,`article_text`);

--
-- Indexes for table `fs2_articles_cat`
--
ALTER TABLE `fs2_articles_cat`
 ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `fs2_b8_wordlist`
--
ALTER TABLE `fs2_b8_wordlist`
 ADD PRIMARY KEY (`token`);

--
-- Indexes for table `fs2_cimg`
--
ALTER TABLE `fs2_cimg`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fs2_cimg_cats`
--
ALTER TABLE `fs2_cimg_cats`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fs2_comments`
--
ALTER TABLE `fs2_comments`
 ADD PRIMARY KEY (`comment_id`), ADD FULLTEXT KEY `comment_title_text` (`comment_text`,`comment_title`);

--
-- Indexes for table `fs2_config`
--
ALTER TABLE `fs2_config`
 ADD UNIQUE KEY `config_name` (`config_name`);

--
-- Indexes for table `fs2_counter`
--
ALTER TABLE `fs2_counter`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fs2_counter_ref`
--
ALTER TABLE `fs2_counter_ref`
 ADD KEY `ref_url` (`ref_url`);

--
-- Indexes for table `fs2_counter_stat`
--
ALTER TABLE `fs2_counter_stat`
 ADD PRIMARY KEY (`s_year`,`s_month`,`s_day`);

--
-- Indexes for table `fs2_dl`
--
ALTER TABLE `fs2_dl`
 ADD PRIMARY KEY (`dl_id`), ADD FULLTEXT KEY `dl_name_text` (`dl_name`,`dl_text`);

--
-- Indexes for table `fs2_dl_cat`
--
ALTER TABLE `fs2_dl_cat`
 ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `fs2_dl_files`
--
ALTER TABLE `fs2_dl_files`
 ADD PRIMARY KEY (`file_id`), ADD KEY `dl_id` (`dl_id`);

--
-- Indexes for table `fs2_editor_config`
--
ALTER TABLE `fs2_editor_config`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fs2_email`
--
ALTER TABLE `fs2_email`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fs2_ftp`
--
ALTER TABLE `fs2_ftp`
 ADD PRIMARY KEY (`ftp_id`);

--
-- Indexes for table `fs2_hashes`
--
ALTER TABLE `fs2_hashes`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `hash` (`hash`);

--
-- Indexes for table `fs2_news`
--
ALTER TABLE `fs2_news`
 ADD PRIMARY KEY (`news_id`), ADD FULLTEXT KEY `news_title_text` (`news_title`,`news_text`);

--
-- Indexes for table `fs2_news_cat`
--
ALTER TABLE `fs2_news_cat`
 ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `fs2_news_links`
--
ALTER TABLE `fs2_news_links`
 ADD PRIMARY KEY (`link_id`);

--
-- Indexes for table `fs2_partner`
--
ALTER TABLE `fs2_partner`
 ADD PRIMARY KEY (`partner_id`);

--
-- Indexes for table `fs2_player`
--
ALTER TABLE `fs2_player`
 ADD PRIMARY KEY (`video_id`);

--
-- Indexes for table `fs2_poll`
--
ALTER TABLE `fs2_poll`
 ADD PRIMARY KEY (`poll_id`);

--
-- Indexes for table `fs2_poll_answers`
--
ALTER TABLE `fs2_poll_answers`
 ADD PRIMARY KEY (`answer_id`);

--
-- Indexes for table `fs2_poll_voters`
--
ALTER TABLE `fs2_poll_voters`
 ADD PRIMARY KEY (`voter_id`);

--
-- Indexes for table `fs2_press`
--
ALTER TABLE `fs2_press`
 ADD PRIMARY KEY (`press_id`);

--
-- Indexes for table `fs2_press_admin`
--
ALTER TABLE `fs2_press_admin`
 ADD PRIMARY KEY (`id`,`type`);

--
-- Indexes for table `fs2_screen`
--
ALTER TABLE `fs2_screen`
 ADD PRIMARY KEY (`screen_id`), ADD KEY `cat_id` (`cat_id`);

--
-- Indexes for table `fs2_screen_cat`
--
ALTER TABLE `fs2_screen_cat`
 ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `fs2_screen_random`
--
ALTER TABLE `fs2_screen_random`
 ADD PRIMARY KEY (`random_id`);

--
-- Indexes for table `fs2_search_index`
--
ALTER TABLE `fs2_search_index`
 ADD PRIMARY KEY (`search_index_id`), ADD UNIQUE KEY `un_search_index_word_id` (`search_index_word_id`,`search_index_type`,`search_index_document_id`);

--
-- Indexes for table `fs2_search_time`
--
ALTER TABLE `fs2_search_time`
 ADD PRIMARY KEY (`search_time_id`), ADD UNIQUE KEY `un_search_time_type` (`search_time_type`,`search_time_document_id`);

--
-- Indexes for table `fs2_search_words`
--
ALTER TABLE `fs2_search_words`
 ADD PRIMARY KEY (`search_word_id`), ADD UNIQUE KEY `search_word` (`search_word`);

--
-- Indexes for table `fs2_shop`
--
ALTER TABLE `fs2_shop`
 ADD PRIMARY KEY (`artikel_id`);

--
-- Indexes for table `fs2_smilies`
--
ALTER TABLE `fs2_smilies`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fs2_snippets`
--
ALTER TABLE `fs2_snippets`
 ADD PRIMARY KEY (`snippet_id`), ADD UNIQUE KEY `snippet_tag` (`snippet_tag`);

--
-- Indexes for table `fs2_styles`
--
ALTER TABLE `fs2_styles`
 ADD PRIMARY KEY (`style_id`), ADD UNIQUE KEY `style_tag` (`style_tag`);

--
-- Indexes for table `fs2_user`
--
ALTER TABLE `fs2_user`
 ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `fs2_useronline`
--
ALTER TABLE `fs2_useronline`
 ADD PRIMARY KEY (`ip`);

--
-- Indexes for table `fs2_user_groups`
--
ALTER TABLE `fs2_user_groups`
 ADD PRIMARY KEY (`user_group_id`);

--
-- Indexes for table `fs2_user_permissions`
--
ALTER TABLE `fs2_user_permissions`
 ADD PRIMARY KEY (`perm_id`,`x_id`,`perm_for_group`);

--
-- Indexes for table `fs2_wallpaper`
--
ALTER TABLE `fs2_wallpaper`
 ADD PRIMARY KEY (`wallpaper_id`);

--
-- Indexes for table `fs2_wallpaper_sizes`
--
ALTER TABLE `fs2_wallpaper_sizes`
 ADD PRIMARY KEY (`size_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fs2_aliases`
--
ALTER TABLE `fs2_aliases`
MODIFY `alias_id` mediumint(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `fs2_applets`
--
ALTER TABLE `fs2_applets`
MODIFY `applet_id` mediumint(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `fs2_articles`
--
ALTER TABLE `fs2_articles`
AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `fs2_articles_cat`
--
ALTER TABLE `fs2_articles_cat`
MODIFY `cat_id` smallint(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `fs2_cimg`
--
ALTER TABLE `fs2_cimg`
MODIFY `id` mediumint(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `fs2_cimg_cats`
--
ALTER TABLE `fs2_cimg_cats`
MODIFY `id` mediumint(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `fs2_comments`
--
ALTER TABLE `fs2_comments`
MODIFY `comment_id` mediumint(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `fs2_dl`
--
ALTER TABLE `fs2_dl`
MODIFY `dl_id` mediumint(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `fs2_dl_cat`
--
ALTER TABLE `fs2_dl_cat`
MODIFY `cat_id` mediumint(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `fs2_dl_files`
--
ALTER TABLE `fs2_dl_files`
MODIFY `file_id` mediumint(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `fs2_ftp`
--
ALTER TABLE `fs2_ftp`
MODIFY `ftp_id` mediumint(9) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `fs2_hashes`
--
ALTER TABLE `fs2_hashes`
MODIFY `id` mediumint(8) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fs2_news`
--
ALTER TABLE `fs2_news`
MODIFY `news_id` mediumint(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT for table `fs2_news_cat`
--
ALTER TABLE `fs2_news_cat`
MODIFY `cat_id` smallint(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `fs2_news_links`
--
ALTER TABLE `fs2_news_links`
MODIFY `link_id` mediumint(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=105;
--
-- AUTO_INCREMENT for table `fs2_partner`
--
ALTER TABLE `fs2_partner`
MODIFY `partner_id` smallint(3) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `fs2_player`
--
ALTER TABLE `fs2_player`
MODIFY `video_id` mediumint(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `fs2_poll`
--
ALTER TABLE `fs2_poll`
MODIFY `poll_id` mediumint(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `fs2_poll_answers`
--
ALTER TABLE `fs2_poll_answers`
MODIFY `answer_id` mediumint(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `fs2_poll_voters`
--
ALTER TABLE `fs2_poll_voters`
MODIFY `voter_id` mediumint(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `fs2_press`
--
ALTER TABLE `fs2_press`
MODIFY `press_id` smallint(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `fs2_press_admin`
--
ALTER TABLE `fs2_press_admin`
MODIFY `id` mediumint(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `fs2_screen`
--
ALTER TABLE `fs2_screen`
MODIFY `screen_id` mediumint(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `fs2_screen_cat`
--
ALTER TABLE `fs2_screen_cat`
MODIFY `cat_id` smallint(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `fs2_screen_random`
--
ALTER TABLE `fs2_screen_random`
MODIFY `random_id` mediumint(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `fs2_search_index`
--
ALTER TABLE `fs2_search_index`
MODIFY `search_index_id` mediumint(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2857;
--
-- AUTO_INCREMENT for table `fs2_search_time`
--
ALTER TABLE `fs2_search_time`
MODIFY `search_time_id` mediumint(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=319;
--
-- AUTO_INCREMENT for table `fs2_search_words`
--
ALTER TABLE `fs2_search_words`
MODIFY `search_word_id` mediumint(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=166;
--
-- AUTO_INCREMENT for table `fs2_shop`
--
ALTER TABLE `fs2_shop`
MODIFY `artikel_id` mediumint(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `fs2_smilies`
--
ALTER TABLE `fs2_smilies`
MODIFY `id` mediumint(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `fs2_snippets`
--
ALTER TABLE `fs2_snippets`
MODIFY `snippet_id` mediumint(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `fs2_styles`
--
ALTER TABLE `fs2_styles`
MODIFY `style_id` mediumint(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `fs2_user`
--
ALTER TABLE `fs2_user`
MODIFY `user_id` mediumint(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `fs2_user_groups`
--
ALTER TABLE `fs2_user_groups`
MODIFY `user_group_id` mediumint(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `fs2_wallpaper`
--
ALTER TABLE `fs2_wallpaper`
MODIFY `wallpaper_id` mediumint(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `fs2_wallpaper_sizes`
--
ALTER TABLE `fs2_wallpaper_sizes`
MODIFY `size_id` mediumint(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
