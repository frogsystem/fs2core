<?php
session_unset();
systext ( "Sie sind jetzt ausgeloggt", $TEXT['admin']->get("info"), FALSE, $TEXT['admin']->get("icon_logout") );

require ( FS2_ROOT_PATH . "admin/admin_login.php" );

?>