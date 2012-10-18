<?php if (!defined('ACP_GO')) die('Unauthorized access!');

###################
## Page Settings ##
###################
$used_cols = array('user_per_page', 'registration_antispam', 'avatar_x', 'avatar_y', 'avatar_size', 'reg_date_format', 'user_list_reg_date_format');

///////////////////////
//// Update Config ////
///////////////////////

if (
        isset($_POST['user_per_page']) && ( $_POST['user_per_page'] > 0 || $_POST['user_per_page'] == -1 )
        && isset($_POST['avatar_x']) && $_POST['avatar_x'] > 0
        && isset($_POST['avatar_y']) && $_POST['avatar_y'] > 0
        && isset($_POST['avatar_size']) && $_POST['avatar_size'] > 0
        && isset($_POST['reg_date_format']) && $_POST['reg_date_format'] != ''
        && isset($_POST['user_list_reg_date_format']) && $_POST['user_list_reg_date_format'] != ''
    )
{
    // prepare data
    $data = frompost($used_cols);
      
    // save config
    try {
        $FD->saveConfig('users', $data);
        systext($FD->text('admin', 'config_saved'), $FD->text('admin', 'info'), 'green', $FD->text('admin', 'icon_save_ok'));
    } catch (Exception $e) {
        systext(
            $FD->text('admin', 'config_not_saved').'<br>'.
            (DEBUG ? $e->getMessage() : $FD->text('admin', 'unknown_error')),
            $FD->text('admin', 'error'), 'red', $FD->text('admin', 'icon_save_error')
        );        
    }

    // Unset Vars
    unset($_POST); 
}

/////////////////////
//// Config Form ////
/////////////////////

if ( TRUE )
{
    // Display Error Messages
    if (isset($_POST['sended'])) {
        systext($FD->text('admin', 'changes_not_saved').'<br>'.$FD->text('admin', 'form_not_filled'), $FD->text('admin', 'error'), 'red', $FD->text('admin', 'icon_save_error'));

    // Load Data from DB into Post
    } else {
        $data = $sql->getRow('config', array('config_data'), array('W' => "`config_name` = 'users'"));
        $data = json_array_decode($data['config_data']);
        putintopost($data);
    }    
    
    // security functions
    $_POST = array_map('killhtml', $_POST);

    // Display Form
    echo'
                    <form action="" method="post">
                        <input type="hidden" name="go" value="user_config">
                        <input type="hidden" name="sended" value="1">
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="4">Allgemeine Einstellungen</td></tr>
                            <tr>
                                <td class="config">
                                    '.$FD->text("page", "reg_antispam").':<br>
                                    <span class="small">'.$FD->text("page", "reg_antispam_desc").'</span>
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
                                    <input class="text center" size="3" maxlength="3" name="avatar_y" value="'.$_POST['avatar_y'].'"> '.$FD->text("admin", "pixel").'<br>
                                    <span class="small">(Breite x H&ouml;he; '.$FD->text("admin", "zero_not_allowed").')</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '."Benutzer-Bild - max. Dateigr&ouml;&szlig;e".':<br>
                                    <span class="small">'."Die max. Dateigr&ouml;&szlig;e eines Benutzer-Bildes.".'</span>
                                </td>
                                <td class="config">
                                    <input class="text center" size="4" maxlength="4" name="avatar_size" value="'.$_POST['avatar_size'].'"> KiB<br>
                                    <span class="small">('.$FD->text("admin", "zero_not_allowed").')</span>
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
                                    <span class="small">'.$FD->text("page", "date_info").'</span>
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
                                    <span class="small">(0 ist nicht zul&auml;ssig)</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '."Registrierungs-Datum".':<br>
                                    <span class="small">'."Datumsformat, das in der Userliste verwendet wird.".'</span>
                                </td>
                                <td class="config">
                                    <input class="text input_width" size="40" name="user_list_reg_date_format" maxlength="50" value="'.$_POST['user_list_reg_date_format'].'"><br>
                                    <span class="small">'.$FD->text("page", "date_info").'</span>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="buttontd" colspan="2">
                                    <button class="button_new" type="submit">
                                        '.$FD->text("admin", "button_arrow").' '.$FD->text("admin", "save_changes_button").'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>
