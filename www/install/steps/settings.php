<?php
unset($template);
unset($error);
$lfs = $_POST['lfs'];

//////////////////////////////
//// Eingaben verarbeiten ////
//////////////////////////////

//Eingabe von Step 1 wird verarbeitet
if ($_POST['sended'] == 1 && $lfs == 0
    && (isset($_POST['url']) AND trim($_POST['url']) != "")
   )
{
    if( substr($_POST['url'], -1, 1) != "/" ) {
        $_POST['url'] = $_POST['url'] . "/";
    }

    include("inc/install_login.php");
    mysql_query("UPDATE `".$pref."global_config`
    SET
        `version`='".file_get_contents("inc/version.txt")."',
        `virtualhost`='".savesql($_POST['url'])."'
    WHERE `id` = 1", $db);
    mysql_close();
    
    $lfs = 1;
    $step = 2;
}

//Eingabe von Step 2 wird verarbeitet
elseif ($_POST['sended'] == 2 && $lfs == 1
    && (isset($_POST['title']) AND trim($_POST['title']) != "")
    && (isset($_POST['admin_mail']) AND trim($_POST['admin_mail']) != "")
   )
{
    include("inc/install_login.php");

    $_POST['admin_mail'] = savesql($_POST['admin_mail']);
    $_POST['title'] = savesql($_POST['title']);

    mysql_query("UPDATE ".$pref."global_config
                 SET admin_mail = '".$_POST['admin_mail']."',
                     title = '".$_POST['title']."'
                 WHERE id = '1'", $db);
    mysql_close();

    $lfs = 2;
    $step = 2;
}

///////////////////////////////
//// Contenttitel erzeugen ////
///////////////////////////////
switch ($step) {
  case 2:
    $contenttitle = $_LANG[steps][settings][step][2][long_title];
    break;
  default:
    $step = 1;
    $contenttitle = $_LANG[steps][settings][step][1][long_title];
    break;
}


//////////////////////
//// Step 1 - URL ////
//////////////////////
if ($step == 1 && $lfs == 0 && $go == "settings")
{
    if ($_POST['sended'] == 1) {
        $notice = $_LANG[steps][settings][step][2][error1];
    }
    else {
        $notice = $_LANG[steps][settings][step][1][info_text];
    }

    $template = '

    '.$notice.'<br><br>
    <form action="?go=settings&step=1&lang='.$lang.'" method="post" autocomplete="off">
        <input type="hidden" name="sended" value="1">
        <input type="hidden" name="lfs" value="'.$lfs.'">
        <table border="0" cellpadding="0" cellspacing="0" width="500" align="center">
            <tr>
                <td class="config">
                    '.$_LANG[steps][settings][step][1][url].':<br>
                    <span class="small">'.$_LANG[steps][settings][step][1][url_desc].'</span>
                </td>
                <td class="input">
                    <input class="input" name="url" value="'.$_POST['url'].'" autocomplete="off">
                </td>
            </tr>
        </table><br>
        <button type="submit" value="" class="button">
            '.$_LANG[main][arrow].' '.$_LANG[steps][settings][step][1][button].'
        </button>
    </form>

    ';

    unset($notice);
}

////////////////////////////////
//// Step 2 - Informationen ////
////////////////////////////////
elseif ($step == 2 && $lfs == 1 && $go == "settings")
{
    if ($_POST['sended'] == 2) {
        $notice = $_LANG[steps][settings][step][2][error1];
    }
    else {
        $notice = $_LANG[steps][settings][step][2][info_text];
        $_POST['show_favicon'] = 1;
        include("inc/install_login.php");
        $index = mysql_query("SELECT `user_mail` FROM `".$pref."user` WHERE `user_id` = '1'", $db);
        $_POST['admin_mail'] = htmlspecialchars ( stripslashes(mysql_result($index, 0, "user_mail")));
        mysql_close();
    }

    $template = '

    '.$notice.'<br><br>
    <form action="?go=settings&step=2&lang='.$lang.'" method="post" autocomplete="off">
        <input type="hidden" name="sended" value="2">
        <input type="hidden" name="lfs" value="'.$lfs.'">
        <table border="0" cellpadding="0" cellspacing="0" width="500" align="center">
            <tr>
                <td class="config">
                    '.$_LANG[steps][settings][step][2][pagetitle].':<br>
                    <span class="small">'.$_LANG[steps][settings][step][2][pagetitle_desc].'</span>
                </td>
                <td class="input">
                    <input class="input" name="title" value="'.$_POST['title'].'" autocomplete="off">
                </td>
            </tr>
            <tr>
                <td class="config">
                    '.$_LANG[steps][settings][step][2][mail].':<br>
                    <span class="small">'.$_LANG[steps][settings][step][2][mail_desc].'</span>
                </td>
                <td class="input">
                    <input class="input" name="admin_mail" value="'.$_POST['admin_mail'].'" autocomplete="off">
                </td>
            </tr>
        </table><br>
        <button type="submit" value="" class="button">
            '.$_LANG[main][arrow].' '.$_LANG[steps][settings][step][2][button].'
        </button>
    </form>

    ';

    unset($notice);
}


/////////////////////////////
//// Step 3.1 - Features ////
/////////////////////////////
elseif ($step == 3 && $lfs == 2 && $go == "settings")
{
    if ($_POST['sended'] == 3 ) {
        $notice = $_LANG[steps][settings][step][3][error1];
    }
    else {
        $notice = $_LANG[steps][settings][step][3][info_text];
        $_POST['feed'] = "rss20";
        $_POST['registration_antispam'] = 1;
        $_POST['date'] = 'd.m.Y';
    }

    $template = '

    '.$notice.'<br><br>
    <form action="?go=settings&step=3&lang='.$lang.'" method="post" autocomplete="off">
        <input type="hidden" name="sended" value="3">
        <input type="hidden" name="lfs" value="'.$lfs.'">
        <table border="0" cellpadding="0" cellspacing="0" width="500" align="center">
            <tr>
                <td class="config">
                    '.$_LANG[steps][settings][step][3][feed].':<br>
                    <span class="small">'.$_LANG[steps][settings][step][3][feed_desc].'</span>
                </td>
                <td class="input">
                    <select class="input" name="feed" size="1">';

                        $template .= '<option value="rss091"';
                        if ($_POST['feed'] == "rss091")
                            $template .= ' selected="selected"';
                        $template .= '>RSS 0.91</option>';

                        $template .= '<option value="rss10"';
                        if ($_POST['feed'] == "rss10")
                            $template .= ' selected="selected"';
                        $template .= '>RSS 1.0</option>';

                        $template .= '<option value="rss20"';
                        if ($_POST['feed'] == "rss20")
                            $template .= ' selected="selected"';
                        $template .= '>RSS 2.0</option>';

                        $template .= '<option value="atom10"';
                        if ($_POST['feed'] == "atom10")
                            $template .= ' selected="selected"';
                        $template .= '>Atom 1.0</option>';
    $template .= '
                    </select>
                </td>
            </tr>
            <tr>
                <td class="config">
                    '.$_LANG[steps][settings][step][3][date].':<br>
                    <span class="small">'.$_LANG[steps][settings][step][3][date_desc].'</span>
                </td>
                <td class="input">
                    <input class="input" name="date" value="'.$_POST['date'].'" autocomplete="off"><br>
                    <span class="small">'.$_LANG[steps][settings][step][3][date_info].'</span>
                </td>
            </tr>
        </table><br><br>
        <button type="submit" value="" class="button">
            '.$_LANG[main][arrow].' '.$_LANG[steps][settings][step][3][button].'
        </button>
    </form>

    ';

    unset($notice);
}

//////////////////////////////
//// Step 3.2 - Abschluss ////
//////////////////////////////
elseif ($step == 2 && $lfs == 2 && $go == "settings")
{
    $contenttitle = $_LANG[steps][settings][end_title];
    $notice = $_LANG[steps][settings][end_info];

    $template = '

    '.$notice.'<br><br>
    <form action="?go=files&step=1&lang='.$lang.'" method="post">
        <input type="hidden" name="lfs" value="0">
        <button type="submit" value="" class="button">
            '.$_LANG[main][arrow].' '.$_LANG[steps][settings][end_button].'
        </button>
    </form>

    ';

    unset($notice);
}

?>