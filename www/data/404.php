<?php
header("Status: 404 Not Found", true, 404);
$template = sys_message($FD->text('frontend', "sysmessage"), '<b><font color="red">Error 404:</font></b> '.$FD->text('frontend', "file_not_found").'.');
$global_config_arr['dyn_title_page'] = "Error 404";
?>
