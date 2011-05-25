<?php
// Start Session
session_start();

// fs2 include path
set_include_path ( '.' );
define ( FS2_ROOT_PATH, "./../", TRUE );

require( FS2_ROOT_PATH . "login.inc.php");
require( FS2_ROOT_PATH . "includes/functions.php");
require( FS2_ROOT_PATH . "includes/adminfunctions.php");
require(FS2_ROOT_PATH . "lang/de_DE/admin/admin_phrases_de.php");

echo'
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <title>'.$admin_phrases[finduser][pagetitle].'</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body id="find_body">

            <div id="find_head">
                &nbsp;<img border="0" src="img/pointer.png" alt="" style="vertical-align:text-top">
                <b>'.$admin_phrases[finduser][searchforuser].'</b>
            </div>
            <div align="center">
';

echo'
                    <form action="'.$PHP_SELF.'" method="post">
                        <table border="0" cellpadding="2" cellspacing="0">
                            <tr>
                                <td align="center" class="configthin" width="100%">
                                    <input value="'.$_POST[filter].'" class="text" name="filter" size="30">
                                    <input class="button" type="submit" value="'.$admin_phrases[common][search_button].'">
                                </td>
                            </tr>
                        </table>
                    </form>
';

if (isset($_POST[filter]))
{
    echo'
                    <br />
     <div id="find_container">
         <div id="find_top">&raquo; '.$admin_phrases[finduser][selectuser].'</div>
             <table border="0" cellpadding="5" cellspacing="0" width="287" style="padding-left:13px;">
    ';
    $_POST[filter] = savesql($_POST[filter]);
    $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."user WHERE user_name LIKE '%$_POST[filter]%' ORDER BY user_name", $db);
    while ($user_arr = mysql_fetch_array($index))
    {
        $user_arr[user_name] = $user_arr[user_name];
        $username = ($user_arr[is_admin] == 1) ? "<b>$user_arr[user_name]</b>" : $user_arr[user_name];

echo'
                        <tr name="'.$user_arr[user_id].'" value="'.$user_arr[user_name].'" style="cursor:pointer;"
                            onmouseover="this.style.backgroundColor=\'#EEEEEE\';"
                            onmouseout="this.style.backgroundColor=\'transparent\';"
                            onclick="javascript:opener.document.getElementById(\'username\').value=\''.$user_arr[user_name].'\';
                                         javascript:opener.document.getElementById(\'userid\').value=\''.$user_arr[user_id].'\';
                                         self.close();">
                            <td>
                                &raquo; '.$username.'
                            </td>
                        </tr>
        ';
    }
    if (mysql_num_rows($index) <= 0) {
        echo '<table border="0" cellpadding="2" cellspacing="0" width="287" style="padding-left:13px;">
                  <tr>
                      <td align="center">'.$admin_phrases[finduser][nousersfound].'</td>
                  </tr>';
    }
    echo'
                    </table>
         </div>
         <div id="find_foot"></div>
    ';
}

echo'
    </div>
</body>
</html>
';

?>
