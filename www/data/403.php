<?php
header(http_response_text(403), true, 403);
$template = sys_message($FD->text('frontend', 'sysmessage'), '<b><span color="red">Error 403:</span></b> '.$FD->text('frontend', 'access_denied').'.');
$FD->setConfig('info', 'page_title', 'Error 403');
?>
