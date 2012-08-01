-- adjustments of admin_cp table for top modules template

INSERT INTO `fs_admin_cp` (`page_id`, `group_id`, `page_title`, `page_link`, `page_file`, `page_pos`, `page_int_sub_perm`)
VALUES ('tpl_topmodules', '22', 'Top Modules bearbeiten', 'Top Modules', 'admin_template_topmodules.php', '25', '0');

-- adjustments of applets table for top modules applet
INSERT INTO `fs_applets` (`applet_file`, `applet_active`, `applet_output`)
VALUES ('topmodules', '1', '1');

