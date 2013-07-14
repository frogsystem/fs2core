<?php if (!defined('ACP_GO')) die('Unauthorized access!');
    header('Status: 404 Not Found', true, 404);
    systext($FD->text("admin", "404_error"), $FD->text("admin", "file_not_found"), 'red', $FD->text("admin", "icon_error"));
?>
