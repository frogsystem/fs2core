<?php if (ACP_GO == 'applets_add') {

#TODO: fileaccess

###################
## Page Settings ##
###################
define('INCLUDE_ALWAYS', 1);
define('INCLUDE_ONDEMAND', 2);


/////////////////////////
//// Save Data to DB ////
/////////////////////////

if (
        isset ( $_POST['applet_file'] )
        && $_POST['applet_file'] != ''
        && file_exists ( FS2_ROOT_PATH . 'applets/' . $_POST['applet_file'] . '.php' )
    )
{

    $_POST['applet_file'] = savesql ( $_POST['applet_file'] );

    settype ( $_POST['applet_active'], 'integer' );
    settype ( $_POST['applet_output'], 'integer' );
    settype ( $_POST['applet_include'], 'integer' );

    // Check if Applet exists
    $index = mysql_query ( 'SELECT `applet_id` FROM `'.$FD->config('pref')."applets` WHERE `applet_file` = '".$_POST['applet_file']."'", $sql->conn() );

    // New Applet
    if ( mysql_num_rows ( $index ) === 0 ) {
        // MySQL-Queries
        mysql_query ( '                 INSERT INTO `'.$FD->config('pref')."applets` (
                                                `applet_file`,
                                                `applet_active`,
                                                `applet_include`,
                                                `applet_output`
                                        )
                                        VALUES (
                                                '".$_POST['applet_file']."',
                                                '".$_POST['applet_active']."',
                                                '".$_POST['applet_include']."',
                                                '".$_POST['applet_output']."'
                                        )
        ", $sql->conn() );

        systext ( $FD->text("admin", "applet_added"),
            $FD->text("admin", "info"), FALSE, $FD->text("admin", "icon_save_add") );
        unset ( $_POST );
    // Applet already exists
    } else {
        systext ( $FD->text("admin", "applet_exists"),
            $FD->text("admin", "error"), TRUE, $FD->text("admin", "icon_save_error") );
        unset ( $_POST['sended'] );
    }

}

/////////////////////////
//// New Applet Form ////
/////////////////////////

// Security Functions
$_POST['applet_file'] = killhtml ( $_POST['applet_file'] );

settype ( $_POST['applet_active'], 'integer' );
settype ( $_POST['applet_output'], 'integer' );


// Check for Errors
if ( isset ( $_POST['sended'] ) ) {
    if ( isset ( $_POST['applet_file'] ) && $_POST['applet_file'] !=  '' && !file_exists ( FS2_ROOT_PATH . 'applets/' . $_POST['applet_file'] . '.php' ) ) {
        $error_message = $FD->text("admin", "applet_file_not_exists");
    } else {
        $error_message = $FD->text("admin", "form_not_filled");
    }

    // Display Error
    systext ( $FD->text("admin", "applet_not_added").'<br>'.$error_message,
        $FD->text("admin", "error"), TRUE, $FD->text("admin", "icon_save_error") );

// Set Data
} else {
    $_POST['applet_active'] = 1;
    $_POST['applet_output'] = 1;
}


// Display Form
echo '
                    <form action="" method="post">
                        <input type="hidden" name="go" value="applets_add">
                        <input type="hidden" name="sended" value="1">
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="2">'.$FD->text("admin", "applet_add_title").'</td></tr>
                            <tr>
                                <td class="config">
                                    '.$FD->text("admin", "applets_active_title").':<br>
                                    <span class="small">'.$FD->text("admin", "applets_active_desc").'</span>
                                </td>
                                <td class="config">
                                    '.$FD->text("admin", "checkbox").'
                                    <input class="hidden" type="checkbox" name="applet_active" value="1" '.getchecked ( 1, $_POST['applet_active'] ).'>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$FD->text("admin", "applets_file_title").':<br>
                                    <span class="small">'.$FD->text("admin", "applets_file_desc").'</span>
                                </td>
                                <td class="config">
                                    <input class="text input_width_mini" name="applet_file" id="applet_file" maxlength="100" value="'.$_POST['applet_file'].'">&nbsp;.php
                                    &nbsp;&nbsp;<input class="button" type="button" onClick=\''.openpopup ( '?go=find_applet', 400, 400 ).'\' value="'.$FD->text("admin", "file_select_button").'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$FD->text("page", "applets_include_title").':<br>
                                    <span class="small">'.$FD->text("page", "applets_include_desc").'</span>
                                </td>
                                <td class="config">
                                    <select name="applet_include">
                                        <option value="'.INCLUDE_ALWAYS.'" '.getselected(INCLUDE_ALWAYS, $_POST['applet_include']).'>'.$FD->text("page", "applets_include_always").'</option>
                                        <option value="'.INCLUDE_ONDEMAND.'" '.getselected(INCLUDE_ONDEMAND, $_POST['applet_include']).'>'.$FD->text("page", "applets_include_ondemand").'</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$FD->text("admin", "applets_output_title").':<br>
                                    <span class="small">'.$FD->text("admin", "applets_output_desc").'</span>
                                </td>
                                <td class="config">
                                    '.$FD->text("admin", "checkbox").'
                                    <input class="hidden" type="checkbox" name="applet_output" value="1" '.getchecked ( 1, $_POST['applet_output'] ).'>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td colspan="2" class="buttontd">
                                    <button class="button_new" type="submit">
                                        '.$FD->text("admin", "button_arrow").' '.$FD->text("admin", "applet_add_title").'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
';

} ?>
