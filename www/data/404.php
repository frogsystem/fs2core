<?php
header("Status: 404 Not Found", true, 404);
$template = sys_message($phrases[sysmessage], '<b><font color="red">Error 404:</font></b> '.$phrases[file_not_found].'.');

?>