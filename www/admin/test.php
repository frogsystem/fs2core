<?php

echo'
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <link rel="stylesheet" type="text/css" href="admin.css">
    <script type="text/javascript" src="functions.js"></script>

</head><body>';

//'.$PHP_SELF.'?go='.$createlink_arr[page_call].$session_url.'

echo '<a onclick="xmlhttpPost(\'admin_allconfig.php\')" class="menu" href="#">Test</a>';

echo '<div id="maincontent"></div></body></html>';

?>
