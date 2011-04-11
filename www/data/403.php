<?php
header("Status: 403 Forbidden", true, 403);
$template = sys_message($phrases[sysmessage], '<b><font color="red">Error 403:</font></b> '.$phrases[access_denied].'.');
$global_config_arr['dyn_title_page'] = "Error 403";
?>