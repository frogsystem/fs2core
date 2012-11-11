<?php
header(http_response_text(404), true, 404);
$template = sys_message($FD->text('frontend', 'sysmessage'), '<b><span color="red">Error 404:</span></b> '.$FD->text('frontend', 'file_not_found').'.');
$FD->setConfig('info', 'page_title', 'Error 404');
?>
