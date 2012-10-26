-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs_comments`
--

DROP TABLE IF EXISTS `fs_comments`;
CREATE TABLE `fs_comments` (
  `comment_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `content_id` mediumint(8) NOT NULL,
  `content_type` varchar(32) NOT NULL,
  `comment_poster` varchar(32) DEFAULT NULL,
  `comment_poster_id` mediumint(8) DEFAULT NULL,
  `comment_poster_ip` varchar(16) NOT NULL,
  `comment_date` int(11) DEFAULT NULL,
  `comment_title` varchar(100) DEFAULT NULL,
  `comment_text` text,
  PRIMARY KEY (`comment_id`),
  FULLTEXT KEY `comment_title_text` (`comment_text`,`comment_title`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
