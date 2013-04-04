<?php
function user_login ( $username, $password, $iscookie )
{
    global $FD;

    $username = savesql($username);
    $password = savesql($password);
    $index = $FD->sql()->conn()->query('SELECT * FROM '.$FD->config('pref')."user WHERE user_name = '".$username."'");
    $row = $index->fetch(PDO::FETCH_ASSOC);
    if ($row === false) {
        $_GET['go'] = 'login';
        if ( $iscookie ) {
            delete_cookie ();
        }
        return 1;  // Fehlercode 1: User nicht vorhanden
    } else {
        $dbuserpass = $row['user_password'];
        $dbuserid = $row['user_id'];
        $username = $row['user_name'];
        $usersalt = $row['user_salt'];

        if ($iscookie===false) {
            $password = md5 ( $password.$usersalt );
        }

        if ($password == $dbuserpass) {
            $_SESSION['user_level'] = 'loggedin';
            $_SESSION['user_id'] = $dbuserid;
            $_SESSION['user_name'] = $username;
            return 0;  // Login akzeptiert
        }
        else {
            $_GET['go'] = 'login';
            if ( $iscookie ) {
                delete_cookie ();
            }
            return 2;  // Fehlercode 2: Falsches Passwort
        }
    }
}


function set_cookie ( $username, $password )
{
    global $FD;

    $username = savesql($username);
    $password = savesql($password);
    $index = $FD->sql()->conn()->query('SELECT * FROM '.$FD->config('pref')."user WHERE user_name = '$username'");
    $row = $index->fetch(PDO::FETCH_ASSOC);
    if ($row === false)
    {
        return false;
    }
    else
    {

        $dbuserpass = $row['user_password'];
        $dbuserid = $row['user_id'];
        $dbusersalt= $row['user_salt'];
        $password = md5 ( $password.$dbusersalt );

        if ($password == $dbuserpass)
        {
            $inhalt = $password . $username;
            setcookie ('login', $inhalt, time()+2592000, '/' );
            return true;  // Login akzeptiert
        }
        else
        {
            return false;
        }
    }
}


function delete_cookie ()
{
    setcookie ( 'login', '', time()-1000, '/' );
}


function logout_user()
{
    session_unset ();
    session_destroy ();
    $_SESSION = array();
    delete_cookie ();
}


/////////////////////////
//// Do Cookie Stuff ////
/////////////////////////
if ( isset($_POST['login']) && $_POST['login'] == 1 ) {
    $FD->setConfig('login_state', user_login ( $_POST['username'], $_POST['userpassword'], FALSE));
} elseif ( isset($_COOKIE['login']) && $_SESSION['user_level'] != 'loggedin') {
    $userpassword = substr ( $_COOKIE['login'], 0, 32 );
    $username = substr ( $_COOKIE['login'], 32, strlen ( $_COOKIE['login'] ) );
    $FD->setConfig('login_state', user_login ( $username,  $userpassword, TRUE));
}

if ( isset($_POST['stayonline']) && $_POST['stayonline'] == 1 && $FD->config('login_state') == 0 ) {
    set_cookie ( $_POST['username'], $_POST['userpassword'] );
}


////////////////
//// Logout ////
////////////////
if ( isset($_GET['go']) && $_GET['go'] == 'logout' && $_POST['go'] != 'login' ) {
    logout_user();
}
?>
