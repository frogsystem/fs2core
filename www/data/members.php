<?php

$users_sql = mysql_query("SELECT * FROM fs_user");
$index = mysql_query("SELECT members_user FROM fs_template WHERE id = '$global_config_arr[design]'");
$user_temp = stripslashes(mysql_result($index, 0, "members_user"));
	
$index = mysql_query("SELECT members_admin FROM fs_template WHERE id = '$global_config_arr[design]'");
$admin_temp = stripslashes(mysql_result($index, 0, "members_admin"));

while ($user = mysql_fetch_assoc($users_sql)) {
	if ($user['is_admin']==1) $temp = $admin_temp;
	else $temp = $user_temp;

	$temp = str_replace("{user_id}", $user['user_id'], $temp);
	$temp = str_replace("{user_name}", $user['user_name'], $temp);
	$temp = str_replace("{reg_date}", date('d-M-Y', $user['reg_date']), $temp);
	if ($user['show_mail']==1) $temp = str_replace("{user_mail}", $user['user_mail'], $temp);
	else $temp = str_replace("{user_mail}", "", $temp);
	
	$members_list .= $temp;
}

$index = mysql_query("SELECT members_body FROM fs_template WHERE id = '$global_config_arr[design]'");
$template = stripslashes(mysql_result($index, 0, "members_body"));
$template = str_replace("{members}", $members_list, $template);

?>