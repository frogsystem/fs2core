<?php
unset($template);
unset($error);
$lfs = $_POST['lfs'];

unset($folders);
$folders[] = "images/cat/";
$folders[] = "images/content/";
$folders[] = "images/downloads/";
$folders[] = "images/partner/";
$folders[] = "images/press/";
$folders[] = "images/screenshots/";
$folders[] = "images/shop/";
$folders[] = "images/smilies/";
$folders[] = "images/wallpaper/";
$folders[] = "media/group-images/";
$folders[] = "media/user-images/";
$folders[] = "styles/";
$folders[] = "styles/lightfrog/";
$folders[] = "styles/lightfrog/0_affiliates.tpl";
$folders[] = "styles/lightfrog/0_articles.tpl";
$folders[] = "styles/lightfrog/0_downloads.tpl";
$folders[] = "styles/lightfrog/0_editor.tpl";
$folders[] = "styles/lightfrog/0_fscodes.tpl";
$folders[] = "styles/lightfrog/0_general.tpl";
$folders[] = "styles/lightfrog/0_news.tpl";
$folders[] = "styles/lightfrog/0_player.tpl";
$folders[] = "styles/lightfrog/0_polls.tpl";
$folders[] = "styles/lightfrog/0_press.tpl";
$folders[] = "styles/lightfrog/0_previewimg.tpl";
$folders[] = "styles/lightfrog/0_screenshots.tpl";
$folders[] = "styles/lightfrog/0_search.tpl";
$folders[] = "styles/lightfrog/0_shop.tpl";
$folders[] = "styles/lightfrog/0_user.tpl";
$folders[] = "styles/lightfrog/0_wallpapers.tpl";
$folders[] = "styles/lightfrog/classes.css";
$folders[] = "styles/lightfrog/editor.css";
$folders[] = "styles/lightfrog/imageviewer.css";
$folders[] = "styles/lightfrog/import.css";
$folders[] = "styles/lightfrog/left.nav";
$folders[] = "styles/lightfrog/main.css";
$folders[] = "styles/lightfrog/main.js";
$folders[] = "styles/lightfrog/style.ini";

$folders_show = $folders;

//////////////////////////////
//// Eingaben verarbeiten ////
//////////////////////////////

//Eingabe von Step 1 wird verarbeitet
if ($_POST['sended'] == 1 && $lfs == 0
    && true
   )
{
    //Anti-Spam Code setzen
    $datei = file("copy/login.inc.php");
    $datei[14] = '$spam = "'.generate_spamcode(10).'"; //Anti-Spam Encryption-Code'."\n";

    if ( file_write_contents("copy/login.inc.php", $datei) && file_write_contents("../login.inc.php", $datei) ) {
        $lfs = 1;
        $step = 2;
    } else { // Error 1
        $step = 1;
        $error = 1;
    }
}

//Eingabe von Step 2 wird verarbeitet
elseif ($_POST['sended'] == 2 && $lfs == 1
    && true
   )
{
     if ( is_writable_array ( add_dotdotslash ( $folders ) ) ) {
        $lfs = 2;
        $step = 2;
    } else{
        include("inc/ftp_login.php");
        unset($folder_arr);
        $folder_arr = $folders;
        foreach ($folder_arr as $value) {
            if ( ftp_chmod($conn, 0777, $root.$value) ) {
                $lfs = 2;
                $step = 2;
            } else { // Error 1
                #break;
                $error_folder[] = $value;
                $step = 2;
                $error = 1;
                break;
            }
        }
        ftp_close($conn);
    }
    
    if ( $step == 2 && $lfs == 2 && !isset($error) ) {
        $datei = file("inc/ftp_data.php");
        $HOST = trim(str_replace('";                //Hostname', '',
            str_replace('$host = "', '', $datei[4])));
        $USER = trim(str_replace('";                //FTP-User', '',
            str_replace('$user = "', '', $datei[5])));
        unset($datei);
        if ( $HOST != "" && $USER != "" ) {
            include("inc/ftp_login.php");
            //FTP-Login löschen
            $datei = file("inc/ftp_data.php");
            $datei[4] = '$host = "";                //Hostname'."\n";
            $datei[5] = '$user = "";                //FTP-User'."\n";
            $datei[6] = '$pass = "";                //Password'."\n";
            $datei[7] = '$root = "";                //Rootdirectory'."\n";

            if ( file_put_contents("inc/ftp_data.php", $datei) ) {
            } elseif ( @ftp_chmod($conn, 0777, $_POST['ftp_root'].'install/inc/ftp_data.php') ) {
                file_put_contents("inc/ftp_data.php", $datei);
                @ftp_chmod($conn, 0644, $_POST['ftp_root'].'install/inc/ftp_data.php');
            }
            ftp_close($conn);
        }
    }
}

//Eingabe von Step 3 wird verarbeitet
elseif ($_POST['sended'] == 3 && $lfs == 2
    && true
   )
{
    if ($_POST['noht'] == 1) {
        $lfs = 3;
        $step = 3;
    } else {
        $lfs = 3;
        $step = 3;
    }
}


///////////////////////////////
//// Contenttitel erzeugen ////
///////////////////////////////
switch ($step) {
  case 2:
    $contenttitle = $_LANG[steps][files][step][2][long_title];
    break;
  case 3:
    $contenttitle = $_LANG[steps][files][step][3][long_title];
    break;
  default:
    $step = 1;
    $contenttitle = $_LANG[steps][files][step][1][long_title];
    break;
}


///////////////////////////
//// Step 1 - Kopieren ////
///////////////////////////
if ($step == 1 && $lfs == 0 && $go == "files")
{
    if ($_POST['sended'] == 1 && $error == 1) {
        $notice = $_LANG[steps][files][step][1][error1];
    }
    else {
        $notice = $_LANG[steps][files][step][1][info_text];
    }

    $template = '

    '.$notice.'<br><br>
    <form action="?go=files&step=1&lang='.$lang.'" method="post">
        <input type="hidden" name="sended" value="1" />
        <input type="hidden" name="lfs" value="'.$lfs.'" />
        <button type="submit" value="" class="button">
            '.$_LANG[main][arrow].' '.$_LANG[steps][files][step][1][button].'
        </button>
    </form>

    ';

    unset($notice);
}

///////////////////////////////////
//// Step 2.1 - Zugriffsrechte ////
///////////////////////////////////
elseif ($step == 2 && $lfs == 1 && $go == "files")
{
    unset($addition);
    if ($_POST['sended'] == 2 && $error == 1) {
    
        $error = $_LANG[steps][files][step][2][error] . insert_tt($_LANG[help][permissions][title],$_LANG[help][permissions][text], 437, 150, 168 );
        $notice = systext ( $error, $_LANG[main][error_long], TRUE, FALSE );
    }
    else {
        $notice = $_LANG[steps][files][step][2][info_text];
    }

    $template = '

    '.$notice.'
    <ul><li>'.implode("</li><li>", add_fs ( $folders_show ) ).'</li></ul><br>
    <form action="?go=files&step=2&lang='.$lang.'" method="post">
        <input type="hidden" name="sended" value="2">
        <input type="hidden" name="lfs" value="'.$lfs.'">
        <button type="submit" value="" class="button">
            '.$_LANG[main][arrow].' '.$_LANG[steps][files][step][2][button].'
        </button>
    </form>

    ';

    unset($notice);
    unset($folder_arr);
}

/////////////////////////////////////////////
//// Step 2.2 - Zugriffsrechte Abschluss ////
/////////////////////////////////////////////
elseif ($step == 2 && $lfs == 2 && $go == "files")
{
    $contenttitle = $_LANG[steps][files][step][2][end_title];
    $notice = $_LANG[steps][files][step][2][end_info];

    $template = '

    '.$notice.'<br><br>'.
    #'<form action="?go=files&step=3&lang='.$lang.'" method="post">
    '<form action="?go=end&lang='.$lang.'" method="post">
        <input type="hidden" name="lfs" value="2">
        <button type="submit" value="" class="button">
            '.$_LANG[main][arrow].' '.$_LANG[steps][files][step][2][end_button].'
        </button>
    </form>

    ';

    unset($notice);
}

//////////////////////////////
//// Step 3.1 - .htaccess ////
//////////////////////////////
elseif ($step == 3 && $lfs == 2 && $go == "files")
{
    if ($_POST['sended'] == 3 && $error == 1) {
        $notice = $_LANG[steps][files][step][3][error1];
    }
    else {
        $notice = $_LANG[steps][files][step][3][info_text]."<br><br>".
        $_LANG[steps][files][step][3][further_info].
        ' <a href="'.$_LANG[steps][files][step][3][further_url].'" target="_blank"><i>'.
        $_LANG[steps][files][step][3][further_url]."</i></a>"."<br><br>".
        "<b>".$_LANG[main][warning]."</b> ".$_LANG[steps][files][step][3][info_text2];
    }

    $template = '

    <b>'.$_LANG[main][htaccess].'</b><br><br><br>'.$notice.'<br><br>
    <form action="?go=files&step=3&lang='.$lang.'" method="post">
        <input type="hidden" name="sended" value="3">
        <input type="hidden" name="lfs" value="'.$lfs.'">
        <button type="submit" value="" class="button">
            '.$_LANG[main][arrow].' '.$_LANG[steps][files][step][3][button].'
        </button>
    </form>
    <br>'.$_LANG[steps][files][step][3][info_text3].'<br><br>
    <form action="?go=files&step=3&lang='.$lang.'" method="post">
        <input type="hidden" name="sended" value="3">
        <input type="hidden" name="lfs" value="'.$lfs.'">
        <button type="submit" value="" class="button">
            '.$_LANG[main][arrow].' '.$_LANG[steps][files][step][3][button2].'
        </button>
    </form>

    ';

    unset($notice);
}


//////////////////////////////
//// Step 3.2 - Abschluss ////
//////////////////////////////
elseif ($step == 3 && $lfs == 3 && $go == "files")
{
    $contenttitle = $_LANG[steps][files][end_title];
    $notice = $_LANG[steps][files][end_info];

    $template = '

    '.$notice.'<br><br>
    <form action="?go=end&lang='.$lang.'" method="post">
        <input type="hidden" name="lfs" value="0" />
        <button type="submit" value="" class="button">
            '.$_LANG[main][arrow].' '.$_LANG[steps][files][end_button].'
        </button>
    </form>

    ';

    unset($notice);

}

?>