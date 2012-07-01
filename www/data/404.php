<?php
header(http_response_text(404), true, 404);
$template = sys_message($FD->text('frontend', 'sysmessage'), '<b><font color="red">Error 404:</font></b> '.$FD->text('frontend', 'file_not_found').'.');
$FD->setConfig('dyn_title_page', 'Error 404');
?>
