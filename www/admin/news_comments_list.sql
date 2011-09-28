--
-- Zusatz für Tabelle `fs2_news_comments`
-- 
-- einmalig nach Installation der Datei admin_news_comments_list.php auszuführen
--

INSERT INTO `fs2_admin_cp` (`page_id`, `group_id`, `page_title`, `page_link`, `page_file`, `page_pos`, `page_int_sub_perm`)
VALUES ('news_comments_list', 5, 'Kommentare', 'Kommentare', 'admin_news_comments_list.php', 4, 0);
