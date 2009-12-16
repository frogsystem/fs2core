<?php
///////////////////////
//// Update Config ////
///////////////////////

if (
        $_POST['user_per_page'] && ( $_POST['user_per_page'] > 0 || $_POST['user_per_page'] == -1 )
        && $_POST['avatar_x'] && $_POST['avatar_x'] > 0
        && $_POST['avatar_y'] && $_POST['avatar_y'] > 0
        && $_POST['avatar_size'] && $_POST['avatar_size'] > 0
        && $_POST['reg_date_format'] && $_POST['reg_date_format'] != ""
        && $_POST['user_list_reg_date_format'] && $_POST['user_list_reg_date_format'] != ""
    )
{
    // security functions
    settype ( $_POST['user_per_page'], "integer" );
    settype ( $_POST['registration_antispam'], "integer" );
    settype ( $_POST['avatar_x'], "integer" );
    settype ( $_POST['avatar_y'], "integer" );
    settype ( $_POST['avatar_size'], "integer" );
    $_POST['reg_date_format'] = savesql ( $_POST['reg_date_format'] );
    $_POST['user_list_reg_date_format'] = savesql ( $_POST['user_list_reg_date_format'] );

    // MySQL-Queries
    mysql_query ( "
                    UPDATE `".$global_config_arr['pref']."user_config`
                    SET
                        `user_per_page` = '".$_POST['user_per_page']."',
                        `registration_antispam` = '".$_POST['registration_antispam']."',
                        `avatar_x` = '".$_POST['avatar_x']."',
                        `avatar_y` = '".$_POST['avatar_y']."',
                        `avatar_size` = '".$_POST['avatar_size']."',
                        `reg_date_format` = '".$_POST['reg_date_format']."',
                        `user_list_reg_date_format` = '".$_POST['user_list_reg_date_format']."'
                    WHERE `id` = '1'
    ", $db );
    
    // system messages
    systext($admin_phrases[common][changes_saved], $admin_phrases[common][info]);

    // Unset Vars
    unset ( $_POST );
}

/////////////////////
//// Config Form ////
/////////////////////

if ( TRUE )
{
    // Display Error Messages
    if ( isset ( $_POST['sended'] ) ) {
        systext ( $admin_phrases[common][note_notfilled], $admin_phrases[common][error], TRUE );

    // Load Data from DB into Post
    } else {
        $index = mysql_query ( "
                                SELECT *
                                FROM ".$global_config_arr['pref']."user_config
                                WHERE `id` = '1'
        ", $db);
        $config_arr = mysql_fetch_assoc($index);
        putintopost ( $config_arr );
    }
    
    // security functions
    settype ( $_POST['user_per_page'], "integer" );
    settype ( $_POST['registration_antispam'], "integer" );
    settype ( $_POST['avatar_x'], "integer" );
    settype ( $_POST['avatar_y'], "integer" );
    settype ( $_POST['avatar_size'], "integer" );
    $_POST['reg_date_format'] = killhtml ( $_POST['reg_date_format'] );
    $_POST['user_list_reg_date_format'] = killhtml ( $_POST['user_list_reg_date_format'] );
    
    // Display Form
    echo'
                    <form action="" method="post">
                        <input type="hidden" name="go" value="user_config">
                        <input type="hidden" name="sended" value="1">
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="4">Allgemeine Einstellungen</td></tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[general][reg_antispam].':<br>
                                    <span class="small">'.$admin_phrases[general][reg_antispam_desc].'</span>
                                </td>
                                <td class="config">
                                    <input type="checkbox" name="registration_antispam" value="1" '.getchecked ( 1, $_POST['registration_antispam'] ).'>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr><td class="line" colspan="4">Benutzer</td></tr>
                            <tr>
                                <td class="config">
                                    '."Benutzer-Bild - max. Abmessungen".':<br>
                                    <span class="small">'."Die max. Abmessungen eines Benutzer-Bildes.".'</span>
                                </td>
                                <td class="config">
                                    <input class="text center" size="3" maxlength="3" name="avatar_x" value="'.$_POST['avatar_x'].'">
                                    x
                                    <input class="text center" size="3" maxlength="3" name="avatar_y" value="'.$_POST['avatar_y'].'"> '.$admin_phrases[common][pixel].'<br>
                                    <span class="small">(Breite x Höhe; '.$admin_phrases[common][zero_not_allowed].')</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '."Benutzer-Bild - max. Dateigröße".':<br>
                                    <span class="small">'."Die max. Dateigröße eines Benutzer-Bildes.".'</span>
                                </td>
                                <td class="config">
                                    <input class="text center" size="4" maxlength="4" name="avatar_size" value="'.$_POST['avatar_size'].'"> KiB<br>
                                    <span class="small">('.$admin_phrases[common][zero_not_allowed].')</span>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr><td class="line" colspan="4">Benutzerprofil</td></tr>
                            <tr>
                                <td class="config">
                                    '."Registrierungs-Datum".':<br>
                                    <span class="small">'."Datumsformat, das auf der Profilseite verwendet wird.".'</span>
                                </td>
                                <td class="config">
                                    <input class="text input_width" size="40" name="reg_date_format" maxlength="50" value="'.$_POST['reg_date_format'].'"><br>
                                    <span class="small">'.$admin_phrases[general][date_info].'</span>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr><td class="line" colspan="4">Benutzerliste</td></tr>
                            <tr>
                                <td class="config">
                                    User pro Seite:<br>
                                    <span class="small">Gibt die Anzahl an Usern auf einer Seite an.<br>
                                    <b>-1 um alle User auf einer Seite anzeigen zu lassen</b></span>
                                </td>
                                <td class="config">
                                    <input class="text center" size="3" maxlength="3" name="user_per_page" value="'.$_POST['user_per_page'].'"> User<br>
                                    <span class="small">(0 ist nicht zulässig)</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '."Registrierungs-Datum".':<br>
                                    <span class="small">'."Datumsformat, das in der Userliste verwendet wird.".'</span>
                                </td>
                                <td class="config">
                                    <input class="text input_width" size="40" name="user_list_reg_date_format" maxlength="50" value="'.$_POST['user_list_reg_date_format'].'"><br>
                                    <span class="small">'.$admin_phrases[general][date_info].'</span>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="buttontd" colspan="2">
                                    <button class="button_new" type="submit">
                                        '.$admin_phrases[common][arrow].' '.$admin_phrases[common][save_long].'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>