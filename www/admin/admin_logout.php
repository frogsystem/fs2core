<?php if (!defined('ACP_GO')) die('Unauthorized access!');

session_unset();
systext ( 'Sie sind jetzt ausgeloggt', $FD->text("admin", "info"), FALSE, $FD->text("admin", "icon_logout") );

require ( FS2SOURCE . '/admin/admin_login.php' );

?>
