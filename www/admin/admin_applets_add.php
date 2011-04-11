<?php
/////////////////////////
//// Save Data to DB ////
/////////////////////////

if (
        isset ( $_POST['applet_file'] )
        && $_POST['applet_file'] != ""
        && file_exists ( FS2_ROOT_PATH . "applets/" . $_POST['applet_file'] . ".php" )
    )
{

    $_POST['applet_file'] = savesql ( $_POST['applet_file'] );
    
    settype ( $_POST['applet_active'], "integer" );
    settype ( $_POST['applet_output'], "integer" );

    // Check if Applet exists
    $index = mysql_query ( "SELECT `applet_id` FROM `".$global_config_arr['pref']."applets` WHERE `applet_file` = '".$_POST['applet_file']."'", $db );

    // New Applet
    if ( mysql_num_rows ( $index ) == 0 ) {
        // MySQL-Queries
        mysql_query ( "
                                        INSERT INTO `".$global_config_arr['pref']."applets` (
                                                `applet_file`,
                                                `applet_active`,
                                                `applet_output`
                                        )
                                        VALUES (
                                                '".$_POST['applet_file']."',
                                                '".$_POST['applet_active']."',
                                                '".$_POST['applet_output']."'
                                        )
        ", $db );
        
        systext ( $TEXT["admin"]->get("applet_added"),
            $TEXT["admin"]->get("info"), FALSE, $TEXT["admin"]->get("icon_save_add") );
        unset ( $_POST );
    // Applet already exists
    } else {
        systext ( $TEXT["admin"]->get("applet_exists"),
            $TEXT["admin"]->get("error"), TRUE, $TEXT["admin"]->get("icon_save_error") );
        unset ( $_POST['sended'] );
    }

}

/////////////////////////
//// New Applet Form ////
/////////////////////////

// Security Functions
$_POST['applet_file'] = killhtml ( $_POST['applet_file'] );

settype ( $_POST['applet_active'], "integer" );
settype ( $_POST['applet_output'], "integer" );


// Check for Errors
if ( isset ( $_POST['sended'] ) ) {
    if ( isset ( $_POST['applet_file'] ) && $_POST['applet_file'] !=  "" && !file_exists ( FS2_ROOT_PATH . "applets/" . $_POST['applet_file'] . ".php" ) ) {
        $error_message = $TEXT["admin"]->get("applet_file_not_exists");
    } else {
        $error_message = $TEXT["admin"]->get("form_not_filled");
    }

    // Display Error
    systext ( $TEXT["admin"]->get("applet_not_added")."<br>".$error_message,
        $TEXT["admin"]->get("error"), TRUE, $TEXT["admin"]->get("icon_save_error") );

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
                            <tr><td class="line" colspan="2">'.$TEXT["admin"]->get("applet_add_title").'</td></tr>
                            <tr>
                                <td class="config">
                                    '.$TEXT["admin"]->get("applets_file_title").':<br>
                                    <span class="small">'.$TEXT["admin"]->get("applets_file_desc").'</span>
                                </td>
                                <td class="config">
                                    <input class="text input_width_mini" name="applet_file" id="applet_file" maxlength="100" value="'.$_POST['applet_file'].'">&nbsp;.php
                                    &nbsp;&nbsp;<input class="button" type="button" onClick=\''.openpopup ( "admin_find_applet.php", 400, 400 ).'\' value="'.$TEXT["admin"]->get("file_select_button").'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$TEXT["admin"]->get("applets_active_title").':<br>
                                    <span class="small">'.$TEXT["admin"]->get("applets_active_desc").'</span>
                                </td>
                                <td class="config">
                                    <input class="pointer" type="checkbox" name="applet_active" value="1" '.getchecked ( 1, $_POST['applet_active'] ).'>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$TEXT["admin"]->get("applets_output_title").':<br>
                                    <span class="small">'.$TEXT["admin"]->get("applets_output_desc").'</span>
                                </td>
                                <td class="config">
                                    <input class="pointer" type="checkbox" name="applet_output" value="1" '.getchecked ( 1, $_POST['applet_output'] ).'>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td colspan="2" class="buttontd">
                                    <button class="button_new" type="submit">
                                        '.$TEXT["admin"]->get("button_arrow").' '.$TEXT["admin"]->get("applet_add_title").'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
';
?>