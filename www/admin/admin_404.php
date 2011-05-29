<?php
    header("Status: 404 Not Found", true, 404);
    systext($TEXT['admin']->get("404_error"), $TEXT['admin']->get("file_not_found"), "red", $TEXT['admin']->get("icon_error"));
?>
