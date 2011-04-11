<?php
unset($template);
unset($error);
$lfs = $_POST['lfs'];

//////////////////////////////
//// Eingaben verarbeiten ////
//////////////////////////////

//Eingabe von Step 1 wird verarbeitet
if ($_POST['sended'] == 1 && $lfs == 0
    && (isset($_POST['db_host']) AND trim($_POST['db_host']) != "")
    && (isset($_POST['db_user']) AND trim($_POST['db_user']) != "")
    && (isset($_POST['db_data']) AND trim($_POST['db_data']) != "")
    && (isset($_POST['db_pass']))
   )
{
    @$db_try = mysql_connect($_POST['db_host'], $_POST['db_user'], $_POST['db_pass']);
    if ($db_try)
    {
        //Install-Login ändern
        $datei = file("inc/install_login.php");
        $datei[4] = '$host = "'.$_POST['db_host'].'";                //Hostname'."\n";
        $datei[5] = '$user = "'.$_POST['db_user'].'";                //Database User'."\n";
        $datei[7] = '$pass = "'.$_POST['db_pass'].'";                //Password'."\n";
        file_write_contents("inc/install_login.php", $datei);

        //Seiten-Login ändern
        $datei = file("copy/login.inc.php");
        $datei[4] = '$dbc[\'host\'] = "'.$_POST['db_host'].'"; //Database Hostname'."\n";
        $datei[5] = '$dbc[\'user\'] = "'.$_POST['db_user'].'"; //Database Username'."\n";
        $datei[6] = '$dbc[\'pass\'] = "'.$_POST['db_pass'].'"; //Database User-Password'."\n";
        file_write_contents("copy/login.inc.php", $datei);
        
        if (mysql_select_db($_POST['db_data'], $db_try))
        {
            //Install-Login ändern
            $datei = file("inc/install_login.php");
            $datei[6] = '$data = "'.$_POST['db_data'].'";                //Database Name'."\n";
            file_write_contents("inc/install_login.php", $datei);
            
            //Seiten-Login ändern
            $datei = file("copy/login.inc.php");
            $datei[7] = '$dbc[\'data\'] = "'.$_POST['db_data'].'"; //Database Name'."\n";
            file_write_contents("copy/login.inc.php", $datei);
            
            $lfs = 1;
            $step = 2;
        }
        else // Error 2
        {
            $db_list = implode(", ", list_db());
            $step = 1;
            $error = 2;
        }
    }
    else // Error 1
    {
        $step = 1;
        $error = 1;
    }
}

//Eingabe von Step 2.1 wird verarbeitet
elseif ($_POST['sended'] == 2 && $lfs == 1
    && (isset($_POST['db_pref']) AND trim($_POST['db_pref']) != "")
   )
{
    if (count(check_dbtables($_POST['db_pref'])) > 0 && $_POST['db_del'] != 1)
    {
      $table_list = implode(", ", check_dbtables($_POST['db_pref']));
      $step = 2;
      $error = 1;
    }
    else
    {
        //Install-Login ändern
        $datei = file("inc/install_login.php");
        $datei[8] = '$pref = "'.$_POST['db_pref'].'";                //Tabellenpräfix'."\n";
        file_write_contents("inc/install_login.php", $datei);

        //Seiten-Login ändern
        $datei = file("copy/login.inc.php");
        $datei[8] = '$dbc[\'pref\'] = "'.$_POST['db_pref'].'"; //Table Prefix'."\n";
        file_write_contents("copy/login.inc.php", $datei);

        $lfs = 2;
        $step = 2;
    }
}

//Eingabe von Step 2.2 wird verarbeitet
elseif ($_POST['sended'] == 2 && $lfs == 2
    && true
   )
{
    $lfs = 2;
    $step = 3;
}

//Eingabe von Step 3 wird verarbeitet
elseif ($_POST['sended'] == 3 && $lfs == 2
    && (isset($_POST['admin_user']) AND trim($_POST['admin_user']) != "")
    && (isset($_POST['admin_mail']) AND trim($_POST['admin_mail']) != "")
    && (isset($_POST['admin_pass']) AND trim($_POST['admin_pass']) != "")
    && (isset($_POST['admin_pwwh']) AND trim($_POST['admin_pwwh']) != "")
   )
{
    if ($_POST['admin_pass'] == $_POST['admin_pwwh'])
    {
        $user_salt = generate_spamcode ( 10 );
        $userpass = md5 ( $_POST['admin_pass'].$user_salt );

        include("inc/install_login.php");
        mysql_query("DELETE FROM `".$pref."user` WHERE `user_id` = 1", $db);
        mysql_query("INSERT INTO `".$pref."user`
        (`user_id`, `user_name`, `user_password`, `user_salt`, `user_mail`, `user_is_staff`, `user_group`, `user_is_admin`, `user_reg_date`, `user_show_mail`)
        VALUES ('1', '".savesql($_POST['admin_user'])."', '".$userpass."', '".$user_salt."', '".savesql($_POST['admin_mail'])."', 1, 0, 1, ".time().", 0)", $db);
        mysql_close();
        
        // Mail versenden
        $template_mail = file_get_contents("doc/de/mail.txt");
        $template_mail = str_replace("{..username..}", $_POST['admin_user'], $template_mail);
        $template_mail = str_replace("{..password..}", $_POST['admin_pass'], $template_mail);
        $header  = "From: ".$_POST['admin_mail']."\n";
        $header .= "Reply-To: ".$_POST['admin_mail']."\n";
        $header .= "X-Mailer: PHP/".phpversion()."\n";
        $header .= "X-Sender-IP: ".$_SERVER['REMOTE_ADDR']."\n";
        $header .= "Content-Type: text/plain";
        @mail($_POST['admin_mail'], $_LANG[main][install_mail], $template_mail, $header);

        $lfs = 3;
        $step = 3;
    }
    else {
        $step = 3;
        $error = 1;
    }
}


///////////////////////////////
//// Contenttitel erzeugen ////
///////////////////////////////
switch ($step) {
  case 2:
    $contenttitle = $_LANG[steps][database][step][2][long_title];
    break;
  case 3:
    $contenttitle = $_LANG[steps][database][step][3][long_title];
    break;
  default:
    $step = 1;
    $contenttitle = $_LANG[steps][database][step][1][long_title];
    break;
}


/////////////////////////////
//// Step 1 - Verbindung ////
/////////////////////////////
if ($step == 1 && $lfs == 0 && $go == "database")
{
    if ($_POST['sended'] == 1 && $error == 1) {
        $notice = $_LANG[steps][database][step][1][error1];
    }
    elseif ($_POST['sended'] == 1 && $error == 2) {
        $notice = $_LANG[steps][database][step][1][error2][1].' '.$_LANG[steps][database][step][1][error2][2].'<br><br>
        <div style="padding-left:20px; padding-right:20px;"><i>'.$db_list.'</i></div><br>
        '.$_LANG[steps][database][step][1][error2][3];
    }
    elseif ($_POST['sended'] == 1) {
        $notice = $_LANG[steps][database][step][1][error3];
    }
    else {
        $notice = $_LANG[steps][database][step][1][info_text];
        if (check_dbcon() == true) {
            $datei = file("inc/install_login.php");
            $_POST['db_host'] = trim(str_replace('";                //Hostname', '',
                str_replace('$host = "', '', $datei[4])));
            $_POST['db_user'] = trim(str_replace('";                //Database User', '',
                str_replace('$user = "', '', $datei[5])));
            $_POST['db_data'] = trim(str_replace('";                //Database Name', '',
                str_replace('$data = "', '', $datei[6])));
            $_POST['db_pass'] = trim(str_replace('";                //Password', '',
                str_replace('$pass = "', '', $datei[7])));
            unset($datei);
            $notice = $_LANG[steps][database][step][1][info_text2];
        }
    }

    $template = '

    '.$notice.'<br><br>
    <form action="?go=database&step=1&lang='.$lang.'" method="post" autocomplete="off">
        <input type="hidden" name="sended" value="1">
        <input type="hidden" name="lfs" value="'.$lfs.'">
        <table border="0" cellpadding="0" cellspacing="0" width="400" align="center">
            <tr>
                <td class="config">
                    '.$_LANG[steps][database][step][1][host].':<br>
                    <span class="small">'.$_LANG[steps][database][step][1][host_desc].'</span>
                </td>
                <td class="input">
                    <input class="input" name="db_host" value="'.$_POST['db_host'].'" autocomplete="off"><br>
                    <span class="small">'.$_LANG[steps][database][step][1][host_info].'</span>
                </td>
            </tr>
            <tr>
                <td class="config">
                    '.$_LANG[steps][database][step][1][user].':<br>
                    <span class="small">'.$_LANG[steps][database][step][1][user_desc].'</span>
                </td>
                <td class="input">
                    <input class="input" name="db_user" value="'.$_POST['db_user'].'" autocomplete="off">
                </td>
            </tr>
            <tr>
                <td class="config">
                    '.$_LANG[steps][database][step][1][pass].':<br>
                    <span class="small">'.$_LANG[steps][database][step][1][pass_desc].'</span>
                </td>
                <td class="input">
                    <input class="input" type="password" name="db_pass" value="'.$_POST['db_pass'].'" autocomplete="off">
                </td>
            </tr>
            <tr>
                <td class="config">
                    '.$_LANG[steps][database][step][1][data].':<br>
                    <span class="small">'.$_LANG[steps][database][step][1][data_desc].'</span>
                </td>
                <td class="input">
                    <input class="input" name="db_data" value="'.$_POST['db_data'].'" autocomplete="off">
                </td>
            </tr>
        </table>
        <button type="submit" value="" class="button">
            '.$_LANG[main][arrow].' '.$_LANG[steps][database][step][1][button].'
        </button>
    </form>
    
    ';
    
    unset($notice);
}

///////////////////////////
//// Step 2.1 - Präfix ////
///////////////////////////
elseif ($step == 2 && $lfs == 1 && $go == "database")
{
    if ($_POST['sended'] == 2 && $error == 1)
    {
        $notice = $_LANG[steps][database][step][2][error1][1].' <b><i>'.$_POST['pref'].'</i></b><br><br>
        <div style="padding-left:20px; padding-right:20px;"><i>'.$table_list.'</i></div><br>
        '.$_LANG[steps][database][step][2][error1][2];
        
        $addition = '
        <br><br>'.$_LANG[steps][database][step][2][info_text3].'<br><br>
        <form action="?go=database&step=2&lang='.$lang.'" method="post" autocomplete="off">
            <input type="hidden" name="sended" value="2">
            <input type="hidden" name="lfs" value="'.$lfs.'">
            <input type="hidden" name="db_del" value="1">
            <input type="hidden" name="db_pref" value="'.$_POST['db_pref'].'">
            <button type="submit" value="" class="button">
                '.$_LANG[main][arrow].' '.$_LANG[steps][database][step][2][button2].'
            </button>
        </form>';
    }
    elseif ($_POST['sended'] == 2) {
        $notice = $_LANG[steps][database][step][2][info_text]."<br>".$_LANG[steps][database][step][2][error1];
    }
    else {
        $notice = $_LANG[steps][database][step][2][info_text];
        if (check_pref() != false) {;
            $_POST['db_pref'] = check_pref();
            $notice = $_LANG[steps][database][step][2][info_text2];
        } else {
            $_POST['db_pref'] = "fs2_";
        }
    }

    $template = '

    '.$notice.'<br><br>
    <form action="?go=database&step=2&lang='.$lang.'" method="post" autocomplete="off">
        <input type="hidden" name="sended" value="2" />
        <input type="hidden" name="lfs" value="'.$lfs.'" />
        <table border="0" cellpadding="0" cellspacing="0" width="400" align="center">
            <tr>
                <td class="config">
                    '.$_LANG[steps][database][step][2][pref].':<br>
                    <span class="small">'.$_LANG[steps][database][step][2][pref_desc].'</span>
                </td>
                <td class="input">
                    <input class="input" name="db_pref" value="'.$_POST['db_pref'].'" autocomplete="off">
                </td>
            </tr>
        </table>
        <button type="submit" value="" class="button">
            '.$_LANG[main][arrow].' '.$_LANG[steps][database][step][2][button].'
        </button>
    </form>
    '.$addition.'

    ';

    unset($notice);
    unset($addition);
}

/////////////////////////////
//// Step 2.2 - Tabellen ////
/////////////////////////////
elseif ($step == 2 && $lfs == 2 && $go == "database")
{
    $notice = $_LANG[db_insert][info_text]." "."<b>".getdbname()."</b>";
    
    $THE_TIME = time();
    
    unset($db_action_template);
    include("db/db_insert1.php");
    $db_action_template .= $template;
    unset($template);
    include("db/db_insert2.php");
    $db_action_template .= $template;
    unset($template);

    $template = '

    '.$notice.'<br><ul type="circle">'.$db_action_template.'</ul><br>
    <form action="?go=database&step=2&lang='.$lang.'" method="post">
        <input type="hidden" name="sended" value="2" />
        <input type="hidden" name="lfs" value="'.$lfs.'" />
        <button type="submit" value="" class="button">
            '.$_LANG[main][arrow].' '.$_LANG[db_insert][button].'
        </button>
    </form>
    ';

    unset($db_action_template);
    unset($notice);
}

//////////////////////////////////
//// Step 3.1 - Administrator ////
//////////////////////////////////
elseif ($step == 3 && $lfs == 2 && $go == "database")
{
    if ($_POST['sended'] == 3 && $error == 1) {
        $notice = $_LANG[steps][database][step][3][error1];
        unset($_POST['admin_pass']);
        unset($_POST['admin_pwwh']);
    }
    elseif ($_POST['sended'] == 3 ) {
        $notice = $_LANG[steps][database][step][3][error2];
    }
    else {
        $notice = $_LANG[steps][database][step][3][info_text];
    }

    $template = '

    '.$notice.'<br><br>
    <form action="?go=database&step=3&lang='.$lang.'" method="post" autocomplete="off">
        <input type="hidden" name="sended" value="3">
        <input type="hidden" name="lfs" value="'.$lfs.'">
        <table border="0" cellpadding="0" cellspacing="0" width="400" align="center">
            <tr>
                <td class="config">
                    '.$_LANG[steps][database][step][3][user].':<br>
                    <span class="small">'.$_LANG[steps][database][step][3][user_desc].'</span>
                </td>
                <td class="input">
                    <input class="input" name="admin_user" value="'.$_POST['admin_user'].'" autocomplete="off">
                </td>
            </tr>
            <tr>
                <td class="config">
                    '.$_LANG[steps][database][step][3][mail].':<br>
                    <span class="small">'.$_LANG[steps][database][step][3][mail_desc].'</span>
                </td>
                <td class="input">
                        <input class="input" name="admin_mail" value="'.$_POST['admin_mail'].'" autocomplete="off">
                </td>
            </tr>
            <tr>
                <td class="config">
                    '.$_LANG[steps][database][step][3][pass].':<br>
                    <span class="small">'.$_LANG[steps][database][step][3][pass_desc].'</span>
                </td>
                <td class="input">
                    <input class="input" type="password" name="admin_pass" value="'.$_POST['admin_pass'].'" autocomplete="off">
                </td>
            </tr>
            <tr>
                <td class="config">
                    '.$_LANG[steps][database][step][3][pwwh].':<br>
                    <span class="small">'.$_LANG[steps][database][step][3][pwwh_desc].'</span>
                </td>
                <td class="input">
                    <input class="input" name="admin_pwwh" value="'.$_POST['admin_pwwh'].'" type="password" autocomplete="off">
                </td>
            </tr>
        </table>
        <button type="submit" value="" class="button">
            '.$_LANG[main][arrow].' '.$_LANG[steps][database][step][3][button].'
        </button>
    </form>

    ';

    unset($notice);
}

//////////////////////////////
//// Step 3.2 - Abschluss ////
//////////////////////////////
elseif ($step == 3 && $lfs == 3 && $go == "database")
{
    $notice = $_LANG[steps][database][end_info];

    $template = '

    '.$notice.'<br><br>
    <form action="?go=settings&step=1&lang='.$lang.'" method="post">
        <input type="hidden" name="lfs" value="0" />
        <button type="submit" value="" class="button">
            '.$_LANG[main][arrow].' '.$_LANG[steps][database][end_button].'
        </button>
    </form>

    ';

    unset($notice);
    
}

?>