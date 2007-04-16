<?php
include("config.inc.php");
include("functions.php");
include("adminfunctions.php");

echo'
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <title>Frog System</title>
    <link rel="stylesheet" type="text/css" href="admin.css">
</head>
<body>
    <div id="main" style="left:10px; top:10px; margin-left:0px;">
        <div id="mainshadow" style="width:300px;">
            <div id="maincontent" style="width:300px;">
                <img border="0" src="img/pointer.gif" width="5" height="8" alt=""> 
                <font style="font-size:8pt;"><b>USER SUCHEN</b></font>
                <div align="center">
                    <p>
';

echo'
                    <form action="'.$PHP_SELF.'" method="post">
                        <input type="hidden" value="useredit" name="go">
                        <table border="0" cellpadding="2" cellspacing="0" width="280">
                            <tr>
                                <td align="center" class="configthin" width="50%">
                                    <input value="'.$_POST[filter].'" class="text" name="filter" size="30">
                                    <input class="button" type="submit" value="Suchen">
                                </td>
                            </tr>
                        </table>
                    </form>
';

if (isset($_POST[filter]))
{
    echo'
                    <table border="0" cellpadding="2" cellspacing="0" width="280">
                        <tr>
                            <td align="center" class="config" width="50%">
                                Username
                            </td>
                        </tr>
    ';
    $_POST[filter] = savesql($_POST[filter]);
    $index = mysql_query("SELECT * FROM fs_user WHERE user_name LIKE '%$_POST[filter]%' ORDER BY user_name", $db);
    while ($user_arr = mysql_fetch_array($index))
    {
        $user_arr[user_name] = $user_arr[user_name];
        $username = ($user_arr[is_admin] == 1) ? "<b>$user_arr[user_name]</b>" : $user_arr[user_name];

echo'
                        <tr name="'.$user_arr[user_id].'" value="'.$user_arr[user_name].'" style="cursor:pointer;"
                            onmouseover="this.style.backgroundColor=\'#DDDDDD\'"
                            onmouseout="this.style.backgroundColor=\'#EEEEEE\'"
                            onmousedown="javascript:opener.document.getElementById(\'username\').value=\''.$user_arr[user_name].'\';
                                         javascript:opener.document.getElementById(\'userid\').value=\''.$user_arr[user_id].'\';
                                         self.close();">
                            <td class="configthin">
                                '.$username.'
                            </td>
                        </tr>
        ';
    }
    echo'
                    </table>
    ';
}

echo'
                </div>
            </div>
        </div>
        <p>
    </div>
</body>
</html>
';

?>