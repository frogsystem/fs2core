<?php if (!defined('ACP_GO')) die('Unauthorized access!');
    header('Status: 403 Forbidden', true, 403);
    systext($FD->text("admin", "403_error"), $FD->text("admin", "access_denied"), 'red', $FD->text("admin", "icon_lock_forbidden"));
?>
