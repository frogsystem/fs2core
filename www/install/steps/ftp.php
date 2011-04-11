<?php
unset($template);
unset($error);
$lfs = $_POST['lfs'];
settype($lfs, "integer");


unset($access_files);
$access_files[] = "login.inc.php";
$access_files[] = "install/inc/install_login.php";
$access_files[] = "install/copy/login.inc.php";

$access_files_show = $folders;

//////////////////////////////
//// Eingaben verarbeiten ////
//////////////////////////////

//Eingabe von Step 1 wird verarbeitet
if ( $_POST['sended'] == 1 && $lfs == 0 )
{
     if ( is_writable_array ( add_dotdotslash ( $access_files ) ) ) {
        $datei = file("inc/install_login.php");
        $datei[10] = '$file = TRUE;'."\n";
        file_put_contents("inc/install_login.php", $datei);
        $lfs = 2;
        $step = 3;
    } elseif ( extension_loaded ( "ftp" ) ) {
        $lfs = 1;
        $step = 2;
    } else {
        $step = 1;
        $error = 1;
    }
}
//Eingabe von Step 2 wird verarbeitet
elseif ($_POST['sended'] == 2 && $lfs == 1
    && (isset($_POST['ftp_host']) AND trim($_POST['ftp_host']) != "")
    && (isset($_POST['ftp_user']) AND trim($_POST['ftp_user']) != "")
   )
{
    if( substr($_POST['ftp_root'], -1, 1) != "/" ) {
        $_POST['ftp_root'] = $_POST['ftp_root'] . "/";
    }
    if( substr($_POST['ftp_root'], 0, 1) != "/" ) {
        $_POST['ftp_root'] = "/" . $_POST['ftp_root'];
    }
    
    $port = $_POST['ftp_port'];
    if ( $port == "" ) {
        $port = 21;
    }

    $conn = @ftp_connect( $_POST['ftp_host'], $port, 10 );

    if ($conn == FALSE) //Error 1 - Keine Verbindung zum Server
    {
        $step = 2;
        $error = 1;
    }
    else
    {
        if ( @ftp_login ( $conn, $_POST['ftp_user'], $_POST['ftp_pass'] ) )
        {
            $handle = fopen ("inc/version.txt", "r");

            if ( @ftp_fget($conn, $handle, $_POST['ftp_root']."install/inc/version.txt", FTP_ASCII) )
            {
                fclose($handle);

                //FTP-Login ändern
                $datei = file("inc/ftp_data.php");
                $datei[4] = '$host = "'.$_POST['ftp_host'].'";                //Hostname'."\n";
                $datei[5] = '$user = "'.$_POST['ftp_user'].'";                //FTP-User'."\n";
                $datei[6] = '$pass = "'.$_POST['ftp_pass'].'";                //Password'."\n";
                $datei[7] = '$root = "'.$_POST['ftp_root'].'";                //Rootdirectory'."\n";
                $datei[8] = '$port = "'.$_POST['ftp_port'].'";                //Port'."\n";
                
                if ( @file_put_contents("inc/ftp_data.php", $datei) ) { // Auf Windows Servern
                    $lfs = 2;
                    $step = 3;
                } elseif ( @ftp_chmod($conn, 0777, $_POST['ftp_root'].'install/inc/ftp_data.php') ) { // Auf Linux Servern
                    if ( @file_put_contents("inc/ftp_data.php", $datei) ) {
                        $lfs = 2;
                        $step = 3;
                    } else { //Error 4 - Datei konnte nicht beschreiben werden
                        $step = 2;
                        $error = 4;
                    }
                    @ftp_chmod($conn, 0644, $_POST['ftp_root'].'install/inc/ftp_data.php');
                } else {
                    $step = 2;
                    $error = 4;
                }
                
                ftp_close($conn);
                
            } else {  //Error 3 - Falsches Root-Verzeichnis
                $step = 2;
                $error = 3;
                ftp_close($conn);
            }
        } else { //Error 2 - Einloggen nicht möglich
            $step = 2;
            $error = 2;
            ftp_close($conn);
        }
        
        if ( $step == 3 ) {
            $datei = file("inc/install_login.php");
            $datei[10] = '$file = FALSE;'."\n";
            @file_write_contents("inc/install_login.php", $datei);
        }
    }
}



///////////////////////////////
//// Contenttitel erzeugen ////
///////////////////////////////
switch ($step) {
  case 3:
    $contenttitle = $_LANG[steps][ftp][step][3][long_title];
    break;
  case 2:
    $contenttitle = $_LANG[steps][ftp][step][2][long_title];
    break;
  default:
    $step = 1;
    $contenttitle = $_LANG[steps][ftp][step][1][long_title];
    break;
}

/////////////////////////////////
//// Step 1 - Berechtigungen ////
/////////////////////////////////
if ($step == 1 && $lfs == 0 && $go == "ftp")
{
    if ($_POST['sended'] == 1 && $error == 1) {
        $error = $_LANG[steps][ftp][step][1][no_ftp_error] . insert_tt($_LANG[help][permissions][title],$_LANG[help][permissions][text], 437, 150, 168 ). '
        <ul><li>' . implode ( '</li><li>', add_fs ( $access_files_show ) ) . '</li></ul>';
        $notice = systext ( $error, $_LANG[main][error_long], TRUE );
        
    } else {
        $notice = systext ( $_LANG[steps][ftp][step][1][info_text], $_LANG[steps][ftp][step][1][long_title] );
    }

    $template = '
        '.$notice.'
                    <form action="?go=ftp&step=1&lang='.$lang.'" method="post">
                        <input type="hidden" name="lfs" value="0">
                        <input type="hidden" name="sended" value="1">
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr>
                                <td class="buttontd">
                                    <button type="submit" value="" class="button">
                                        '.$_LANG[main][arrow].' '.$_LANG[steps][ftp][step][1][button].'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
    
    unset($error);
    unset($notice);
}


/////////////////////////////
//// Step 2 - Logindaten ////
/////////////////////////////
if ($step == 2 && $lfs == 1 && $go == "ftp")
{
    if ($_POST['sended'] == 2 && $error == 1) {
        $notice = $_LANG[steps][ftp][step][2][error1];
        $notice = systext ( $notice, $_LANG[main][error_long], TRUE );
    }
    elseif ($_POST['sended'] == 2 && $error == 2) {
        $notice = $_LANG[steps][ftp][step][2][error2];
        $notice = systext ( $notice, $_LANG[main][error_long], TRUE );
    }
    elseif ($_POST['sended'] == 2 && $error == 3) {
        $notice = $_LANG[steps][ftp][step][2][error3];
        $notice = systext ( $notice, $_LANG[main][error_long], TRUE );
    }
    elseif ($_POST['sended'] == 2 && $error == 4) {
        $notice = $_LANG[steps][ftp][step][2][error4];
        $notice = systext ( $notice, $_LANG[main][error_long], TRUE );
    }
    elseif ($_POST['sended'] == 2) {
        $notice = $_LANG[steps][ftp][step][2][error5];
        $notice = systext ( $notice, $_LANG[main][error_long], TRUE );
    }
    else {
        $notice = $_LANG[steps][ftp][step][2][info_text];
        $datei = file("inc/ftp_data.php");
        $HOST = trim(str_replace('";                //Hostname', '',
            str_replace('$host = "', '', $datei[4])));
        $USER = trim(str_replace('";                //FTP-User', '',
            str_replace('$user = "', '', $datei[5])));
        $PASS = trim(str_replace('";                //Password', '',
            str_replace('$pass = "', '', $datei[6])));
        $ROOT = trim(str_replace('";                //Rootdirectory', '',
            str_replace('$root = "', '', $datei[7])));
        $PORT = trim(str_replace('";                //Port', '',
            str_replace('$port = "', '', $datei[8])));
        unset($datei);
        if ( $HOST != "" && $USER != "" ) {
            if (check_ftpcon() == true) {
                $_POST['ftp_host'] = $HOST;
                $_POST['ftp_user'] = $USER;
                $_POST['ftp_pass'] = $PASS;
                $_POST['ftp_root'] = $ROOT;
                $_POST['ftp_port'] = $PORT;
                $notice = $_LANG[steps][ftp][step][2][info_text2];
            }
        } else {
            $notice = $notice . "<br><br>" . $_LANG[steps][ftp][step][2][info_text3];
            $_POST['ftp_root'] = substr($_SERVER['SCRIPT_NAME'], 0, -17);
        }
        $notice = systext ( $notice, $_LANG[steps][ftp][step][2][long_title] );
    }

    $_POST['ftp_host'] = killhtml ( $_POST['ftp_host'] );
    $_POST['ftp_user'] = killhtml ( $_POST['ftp_user'] );
    $_POST['ftp_pass'] = killhtml ( $_POST['ftp_pass'] );
    $_POST['ftp_root'] = killhtml ( $_POST['ftp_root'] );
    $_POST['ftp_port'] = killhtml ( $_POST['ftp_port'] );

    $template = '

    '.$notice.'
    <form action="?go=ftp&step=2&lang='.$lang.'" method="post" autocomplete="off">
        <input type="hidden" name="sended" value="2">
        <input type="hidden" name="lfs" value="1">
        <table border="0" cellpadding="0" cellspacing="0" width="400" align="center">
            <tr>
                <td class="config">
                    '.$_LANG[steps][ftp][step][2][host].':<br>
                    <span class="small">'.$_LANG[steps][ftp][step][2][host_desc].'</span>
                </td>
                <td class="input">
                    <input class="input" name="ftp_host" value="'.$_POST['ftp_host'].'" autocomplete="off">
                </td>
            </tr>
            <tr>
                <td class="config">
                    '.$_LANG[steps][ftp][step][2][port].': '.$_LANG[main][optional].'<br>
                    <span class="small">'.$_LANG[steps][ftp][step][2][port_desc].'</span>
                </td>
                <td class="input">
                    <input class="input" name="ftp_port" value="'.$_POST['ftp_port'].'" autocomplete="off"><br>
                    <span class="small">'.$_LANG[steps][ftp][step][2][port_info].'</span>
                </td>
            </tr>
            <tr>
                <td class="config">
                    '.$_LANG[steps][ftp][step][2][user].':<br>
                    <span class="small">'.$_LANG[steps][ftp][step][2][user_desc].'</span>
                </td>
                <td class="input">
                        <input class="input" name="ftp_user" value="'.$_POST['ftp_user'].'" autocomplete="off">
                </td>
            </tr>
            <tr>
                <td class="config">
                    '.$_LANG[steps][ftp][step][2][pass].':<br>
                    <span class="small">'.$_LANG[steps][ftp][step][2][pass_desc].'</span>
                </td>
                <td class="input">
                    <input class="input" type="password" name="ftp_pass" value="'.$_POST['ftp_pass'].'" autocomplete="off">
                </td>
            </tr>
            <tr>
                <td class="config">
                    '.$_LANG[steps][ftp][step][2][root].':<br>
                    <span class="small">'.$_LANG[steps][ftp][step][2][root_desc].'</span>
                </td>
                <td class="input">
                    <input class="input" name="ftp_root" value="'.$_POST['ftp_root'].'" autocomplete="off"><br>
                    <span class="small">'.$_LANG[steps][ftp][step][2][root_info].'</span>
                </td>
            </tr>
        </table><br>
        <button type="submit" value="" class="button">
            '.$_LANG[main][arrow].' '.$_LANG[steps][ftp][step][2][button].'
        </button>
    </form>

    ';
    unset($error);
    unset($notice);
}

////////////////////////////////////
//// Step 3 - Verbindung testen ////
////////////////////////////////////
elseif ($step == 3 && $lfs == 2 && $go == "ftp")
{
    include("inc/install_login.php");
    if ( $file ) {
        $notice = $_LANG[steps][ftp][step][3][info_text1];
        $notice = systext ( $notice, $_LANG[steps][ftp][step][3][info_title] );
        $template = '

        '.$notice.'
        <form action="?go=database&step=1&lang='.$lang.'" method="post">
            <input type="hidden" name="lfs" value="0">
            <button type="submit" value="" class="button">
                '.$_LANG[main][arrow].' '.$_LANG[main][continue_install].'
            </button>
        </form>
        ';
    } elseif ( check_ftpcon() ) {
        $notice = $_LANG[steps][ftp][step][3][info_text2];
        $notice = systext ( $notice, $_LANG[steps][ftp][step][3][info_title] );
        $template = '

        '.$notice.'
        <form action="?go=database&step=1&lang='.$lang.'" method="post">
            <input type="hidden" name="lfs" value="0">
            <button type="submit" value="" class="button">
                '.$_LANG[main][arrow].' '.$_LANG[main][continue_install].'
            </button>
        </form>
        ';
    } else {
        $notice = $_LANG[steps][ftp][step][3][info_text3];
        $notice = systext ( $notice, $_LANG[main][error_long], TRUE );
        $template = '

        '.$notice.'
        <form action="?go=ftp&step=1&lang='.$lang.'" method="post">
            <input type="hidden" name="lfs" value="0">
            <button type="submit" value="" class="button">
                '.$_LANG[main][arrow].' '.$_LANG[steps][ftp][step][3][button].'
            </button>
        </form>
        ';
    }

    unset($notice);
}

?>