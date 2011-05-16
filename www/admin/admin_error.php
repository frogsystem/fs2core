<?php
    header("Status: 403 Forbidden", true, 403);
    systext($TEXT['admin']->get("403_error"), $TEXT['admin']->get("access_denied"), "red", $TEXT['admin']->get("icon_lock_forbidden"));
?>
