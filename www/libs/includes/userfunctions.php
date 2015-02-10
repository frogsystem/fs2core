<?php

/////////////////////////////////////////
//// Generate random password string ////
/////////////////////////////////////////
function generate_pwd ($LENGHT = 10)
{
    $charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789';
    $code = '';
    $real_strlen = strlen($charset) - 1;
    mt_srand((double)microtime() * 1001000);

    while(strlen($code) < $LENGHT) {
        $code .= $charset[mt_rand (0,$real_strlen)];
    }
    return $code;
}


function user_login ( $username, $password, $iscookie )
{
    global $FD;

    $index = $FD->db()->conn()->prepare('SELECT * FROM '.$FD->env('DB_PREFIX')."user WHERE user_name = ?");
    $index->execute(array($username));
    $row = $index->fetch(PDO::FETCH_ASSOC);
    if ($row === false) {
        $FD->setConfig('goto', 'login');
        $FD->setConfig('env', 'goto', 'login');

        if ( $iscookie ) {
            delete_cookie ();
        }
        return 1;  // error code 1: user does not exist
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
            $FD->setConfig('goto', 'login');
            $FD->setConfig('env', 'goto', 'login');
            if ( $iscookie ) {
                delete_cookie ();
            }
            return 2;  // error code 2: wrong password
        }
    }
}


function set_cookie ( $username, $password )
{
    global $FD;

    $index = $FD->db()->conn()->prepare('SELECT * FROM '.$FD->env('DB_PREFIX').'user WHERE user_name = ?');
    $index->execute(array($username));
    $row = $index->fetch(PDO::FETCH_ASSOC);
    if ($row === false)
    {
        return false;
    }
    else
    {

        $dbuserpass = $row['user_password'];
        //$dbuserid = $row['user_id'];
        $dbusersalt= $row['user_salt'];
        $password = md5 ( $password.$dbusersalt );

        if ($password == $dbuserpass)
        {
            $inhalt = $password . $username;
            setcookie ('login', $inhalt, time()+2592000, '/' );
            return true;  // login accepted
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


function userlogin() {
    // Login in User
    if (!is_loggedin()) {
        global $FD;
        // From Post
        if (isset($_POST['login']) && $_POST['login'] == 1) {
            $FD->setConfig('login_state', user_login($_POST['username'], $_POST['userpassword'], FALSE));
        // From Cookie
        } elseif(isset($_COOKIE['login'])) {
            $userpassword = substr ($_COOKIE['login'], 0, 32);
            $username = substr($_COOKIE['login'], 32, strlen($_COOKIE['login']));
            $FD->setConfig('login_state', user_login($username, $userpassword, TRUE));
        }

        // stay online?
        if (isset($_POST['stayonline']) && $_POST['stayonline'] == 1 && $FD->config('login_state') == 0) {
            set_cookie ($_POST['username'], $_POST['userpassword']);
        }
    }
}


///////////////////////
//// Localize Date ////
///////////////////////
function get_user_rank ( $GROUP_ID, $IS_ADMIN = 0 )
{
    global $FD;

    if ( $GROUP_ID == 0) {
        $retrun_arr['user_group_id'] = 0;
        $retrun_arr['user_group_name'] = '';
        $retrun_arr['user_group_title'] = '';
        $retrun_arr['user_group_rank'] = '';
    } else {
        $index = $FD->db()->conn()->query ( '
            SELECT *
            FROM `'.$FD->env('DB_PREFIX')."user_groups`
            WHERE `user_group_id` = '".$GROUP_ID."'");
        $group_arr = $index->fetch(PDO::FETCH_ASSOC);

        settype ( $group_arr['user_group_id'], 'integer' );
        $group_arr['user_group_image'] = ( image_exists ( '/group-images', 'staff_'.$group_arr['user_group_id'] ) ? '<img src="'.image_url ( '/group-images', 'staff_'.$group_arr['user_group_id'] ).'" alt="'.$FD->text('frontend', 'group_image_of').' '.$group_arr['user_group_name'].'">' : '' );

        unset ( $title_style );
        $title_style = ( $group_arr['user_group_color'] != -1 ? 'color:#'.$group_arr['user_group_color'].';' : '' );
        switch ( $group_arr['user_group_highlight'] ) {
            case 1:
                $highlight_css = 'font-weight:bold;';
                break;
            case 2:
                $highlight_css = 'font-style:italic;';
                break;
            case 5:
                $highlight_css = 'font-weight:bold;font-style:italic;';
                break;
            default:
                $highlight_css = '';
                break;
        }
        $title_style .= $highlight_css;
        $group_arr['user_group_title_colored'] = '<span style="'.$title_style.'">'.$group_arr['user_group_title'].'</span>';

        $rank_template = new template();
        $rank_template->setFile ( '0_user.tpl' );
        $rank_template->load ( 'USERRANK' );
        $rank_template->tag ( 'group_name', $group_arr['user_group_name'] );
        $rank_template->tag ( 'group_image', $group_arr['user_group_image'] );
        $rank_template->tag ( 'group_image_url', image_url ( '/group-images', 'staff_'.$group_arr['user_group_id'] ) );
        $rank_template->tag ( 'group_title', $group_arr['user_group_title_colored'] );
        $rank_template->tag ( 'group_title_text_only', $group_arr['user_group_title'] );
        $rank_template = $rank_template->display ();

        $retrun_arr['user_group_id'] = $group_arr['user_group_id'];
        $retrun_arr['user_group_name'] = $group_arr['user_group_name'];
        $retrun_arr['user_group_title'] = $group_arr['user_group_title'];
        $retrun_arr['user_group_rank'] = $rank_template;
    }
    return $retrun_arr;
}



//////////////////////////
//// User is in Staff ////
//////////////////////////

function is_in_staff ( $USER_ID )
{
    global $FD;

    settype ( $USER_ID, 'integer' );

    if ( $USER_ID ) {
        $index = $FD->db()->conn()->query ( '
                                SELECT user_id, user_is_staff, user_is_admin
                                FROM '.$FD->env('DB_PREFIX')."user
                                WHERE user_id = '".$USER_ID."'
                                LIMIT 0,1");
        if ( $row = $index->fetch(PDO::FETCH_ASSOC) ) {
            if ( $row['user_is_staff'] == 1 || $row['user_is_admin'] == 1 || $row['user_id'] == 1 ) {
                 return TRUE;
            }
        }
    }
    return FALSE;
}

///////////////////////
//// User is Admin ////
///////////////////////

function is_admin ( $USER_ID )
{
    global $FD;

    settype ( $USER_ID, 'integer' );

    if ( $USER_ID ) {
        $index = $FD->db()->conn()->query ( '
                                SELECT user_id, user_is_admin
                                FROM '.$FD->env('DB_PREFIX')."user
                                WHERE user_id = '".$USER_ID."'
                                LIMIT 0,1" );
        if ( $row = $index->fetch(PDO::FETCH_ASSOC) ) {
            if ( $row['user_is_admin'] == 1 || $row['user_id'] == 1 ) {
                 return TRUE;
            }
        }
    }
    return FALSE;
}


/////////////////////////////////////
//// Check for User Permissions  ////
/////////////////////////////////////
function has_perm ($perm) {
    return (isset($_SESSION[$perm]) && $_SESSION[$perm] === 1);
}
function is_authorized () {
    return (isset($_SESSION['user_level']) && $_SESSION['user_level'] === 'authorized');
}
function is_loggedin () {
    return ((isset($_SESSION['user_level']) && $_SESSION['user_level'] === 'loggedin') || is_authorized ());
}



?>
