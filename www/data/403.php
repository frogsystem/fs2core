<?php
header(http_response_text(403), true, 403);
$template = sys_message($FD->text('frontend', "sysmessage"), '<b><font color="red">Error 403:</font></b> '.$FD->text('frontend', "access_denied").'.');
$global_config_arr['dyn_title_page'] = "Error 403";
?>
