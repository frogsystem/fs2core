-- adjustments of admin_cp table for top downloads template

INSERT INTO `fs_admin_cp` (`page_id`, `group_id`, `page_title`, `page_link`, `page_file`, `page_pos`, `page_int_sub_perm`)
VALUES ('tpl_topdownloads', '22', 'Top Downloads bearbeiten', 'Top Downloads', 'admin_template_topdownloads.php', '25', '0');

-- adjustments of applets table for top downloads applet
INSERT INTO `fs_applets` (`applet_file`, `applet_active`, `applet_output`)
VALUES ('topdownloads', '1', '1');

