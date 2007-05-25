<?php

if (isset($_GET[info]))
{
    phpinfo();
}
elseif ($_SESSION[user_level] == "authorised")
{
    echo '<iframe style="width:600px; height:600px;" src="admin_allphpinfo.php?info=true"></iframe>';
}
?>