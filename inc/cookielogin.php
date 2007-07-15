<?php
function user_login($username, $password, $iscookie)
{
    global $db;

    $username = savesql($username);
    $password = savesql($password);
    $index = mysql_query("select * from fs_user where user_name = '$username'", $db);
    $rows = mysql_num_rows($index);
    if ($rows == 0)
    {
        return 1;  // Fehlercode 1: User nicht vorhanden
    }
    else
    {
        if ($iscookie===false)
        {
            $password = md5($password);
        }
        $dbuserpass = mysql_result($index, 0, "user_password");
        $dbuserid = mysql_result($index, 0, "user_id");
        $username = mysql_result($index, 0, "user_name");
        if ($password == $dbuserpass)
        {
            $_SESSION["user_level"] = "loggedin";
            $_SESSION["user_id"] = $dbuserid;
            $_SESSION["user_name"] = $username;
            return 0;  // Login akzeptiert
        }
        else
        {
            return 2;  // Fehlercode 2: Falsches Passwort
        }
    }
}



function set_cookie($username, $password)
{
    global $db;

    $username = savesql($username);
    $password = savesql($password);
    $index = mysql_query("select * from fs_user where user_name = '$username'", $db);
    $rows = mysql_num_rows($index);
    if ($rows == 0)
    {
        return false;
    }
    else
    {
        $password = md5($password);
        $dbuserpass = mysql_result($index, 0, "user_password");
        $dbuserid = mysql_result($index, 0, "user_id");
        if ($password == $dbuserpass)
        {
            $inhalt = $password . $username;
            setcookie ("login", $inhalt, time()+2592000, "/");
            return true;  // Login akzeptiert
        }
        else
        {
            return false;
        }
    }
}

///////////////////////////
///////// Cookie //////////
///////////////////////////

if ($_POST[stayonline]==1)
{
    set_cookie($_POST[username], $_POST[userpassword]);
}

if ($HTTP_COOKIE_VARS["login"])
{
    $userpassword = substr($HTTP_COOKIE_VARS["login"], 0, 32);
    $username = substr($HTTP_COOKIE_VARS["login"], 32, strlen($HTTP_COOKIE_VARS["login"]));
    user_login($username, $userpassword, true);
}

if ($_POST[login]==1)
{
    user_login($_POST[username], $_POST[userpassword], false);
}

///////////////////////////
///////// Logout //////////
///////////////////////////

if ($_GET[go] == "logout" AND $_POST[go] != "login")
{
 session_unset();
 session_destroy();
 $_SESSION = array();
 setcookie ("login", "", time()-1000, "/");
}

?>