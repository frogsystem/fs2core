<?php
//////////////////////////
//// Locale Functions ////
//////////////////////////
function get_style_ini_data ( $STYLE_INI_FILE ) {
    global $TEXT;

    $ACCESS = new fileaccess();
    $ini_lines = $ACCESS->getFileArray( $STYLE_INI_FILE );
    $ini_lines = array_map ( killhtml, $ini_lines );
    $ini_lines[1] = ( $ini_lines[1] != "" ) ? $TEXT["admin"]->get("version").'&nbsp;'.$ini_lines[1] : "";
    return $ini_lines;
}


//////////////////////////
//// DB: Update Style ////
//////////////////////////

if (
        isset ( $_POST['sended'] ) && $_POST['sended'] == "edit"
        && isset ( $_POST['style_action'] ) && $_POST['style_action'] == "edit"
        && isset ( $_POST['style_id'] )
        && $_POST['style_name'] && $_POST['style_name'] != ""
    )
{
    // Security-Functions
    settype ( $_POST['style_id'], "integer" );
    settype ( $_POST['style_allow_use'], "integer" );
    settype ( $_POST['style_allow_edit'], "integer" );

    // MySQL-Queries
    mysql_query ( "
                    UPDATE `".$global_config_arr['pref']."styles`
                    SET
                        `style_allow_use` = '".$_POST['style_allow_use']."',
                        `style_allow_edit` = '".$_POST['style_allow_edit']."'
                    WHERE `style_id` = '".$_POST['style_id']."'
    ", $db );

    $index = mysql_query ( "
                            SELECT `style_tag`
                            FROM `".$global_config_arr['pref']."styles`
                            WHERE `style_id` = ".$_POST['style_id']."
    ", $db );
    
    $new_ini_data = $_POST['style_name']."
".$_POST['style_version']."
".$_POST['style_copyright'];
    
    $style_ini = FS2_ROOT_PATH . "styles/" . stripslashes ( mysql_result ( $index, 0, "style_tag" ) ) . "/style.ini";
    $ACCESS = new fileaccess();
    if ( $ACCESS->putFileData( $style_ini, $new_ini_data ) === FALSE ) {
        $error_extenion = "<br>".$TEXT["admin"]->get("style_info_not_saved");
    }

    // Display Message
    systext ( $TEXT["admin"]->get("changes_saved").$error_extenion,
        $TEXT["admin"]->get("info"), FALSE, $TEXT["admin"]->get("icon_save_ok") );

    // Unset Vars
    unset ( $_POST );
}

/////////////////////////////
//// DB: Uninstall Style ////
/////////////////////////////
elseif (
        isset ( $_POST['sended'] ) && $_POST['sended'] == "uninstall"
        && isset ( $_POST['style_action'] ) && $_POST['style_action'] == "uninstall"
        && isset ( $_POST['style_id'] )
        && isset ( $_POST['style_uninstall'] )
    )
{
    if ( $_POST['style_uninstall'] == 1 ) {

        // Security-Functions
        settype ( $_POST['style_id'], "integer" );

        // Check if style is last
        $index = mysql_query ( "
                                SELECT `style_id`
                                FROM `".$global_config_arr['pref']."styles`
                                WHERE `style_allow_use` = 1
                                AND `style_id` != ".$_POST['style_id']."
        ", $db );

        // Not last usable Style
        if ( mysql_num_rows ( $index ) >= 1 ) {

            // MySQL-Delete-Query
            mysql_query ("
                            DELETE
                            FROM `".$global_config_arr['pref']."styles`
                            WHERE `style_id` = ".$_POST['style_id']."
            ", $db );
            
            if (
                $global_config_arr['style_id'] == $_POST['style_id']
                && isset ( $_POST['new_style_id'] ) && $_POST['new_style_id'] != 0 && $_POST['new_style_id'] != ""
                && is_numeric ( $_POST['new_style_id'] )
            ) {
                // Security-Functions
                settype ( $_POST['new_style_id'], "integer" );

                $index = mysql_query ( "
                                        SELECT `style_tag`
                                        FROM `".$global_config_arr['pref']."styles`
                                        WHERE `style_id` = ".$_POST['new_style_id']."
                                        AND `style_id` != 0
                                        AND `style_allow_use` = 1
                                        LIMIT 0,1
                ", $db );
                if ( mysql_num_rows ( $index ) == 1 ) {
                    // MySQL-Queries
                    mysql_query ( "
                                    UPDATE
                                        `".$global_config_arr['pref']."global_config`
                                    SET
                                        `style_id` = '".$_POST['new_style_id']."',
                                        `style_tag` = '".stripslashes ( mysql_result ( $index, 0, "style_tag" ) )."'
                                    WHERE `id` = '1'
                    ", $db );
                }
            }

            systext ( $TEXT["admin"]->get("style_uninstalled"),
                $TEXT["admin"]->get("info"), FALSE, $TEXT["admin"]->get("icon_uninstall_ok") );
        } else {
            // uninstall style is not possible
            systext ( $TEXT["admin"]->get("style_not_uninstalled")."<br>".$TEXT["admin"]->get("style_is_last_useable"),
                $TEXT["admin"]->get("error"), TRUE, $TEXT["admin"]->get("icon_no_install_action") );
            unset ( $_POST );
        }

    } else {
        systext ( $TEXT["admin"]->get("style_not_uninstalled"),
            $TEXT["admin"]->get("info"), FALSE, $TEXT["admin"]->get("icon_no_install_action") );
    }

    // Unset Vars
    unset ( $_POST );
}

///////////////////////////
//// DB: Install Style ////
///////////////////////////
elseif (
        isset ( $_POST['style_action'] ) && $_POST['style_action'] == "install"
        && isset ( $_POST['style_tag'] ) && $_POST['style_tag'] != ""
    )
{
    if ( file_exists ( FS2_ROOT_PATH . "styles/" . $_POST['style_tag'] . "/style.ini" ) ) {
        // Security-Functions
        $_POST['style_tag'] = savesql ( $_POST['style_tag'] );

        // MySQL-Queries
        mysql_query ( "
                        INSERT INTO
                            `".$global_config_arr['pref']."styles`
                            (`style_tag`, `style_allow_use`, `style_allow_edit`)
                        VALUES
                            ( '".$_POST['style_tag']."', 1, 1 )
        ", $db );

        // Display info
        systext ( $TEXT["admin"]->get("style_installed"),
            $TEXT["admin"]->get("info"), FALSE, $TEXT["admin"]->get("icon_install_ok") );
            
        // Go to Edit-Page of the installed Style
        unset ( $_POST );
        $_POST['style_id'] = mysql_insert_id ();
        $_POST['style_action'] = "edit";
        
    } else {
        // Display not found Info
        systext ( $TEXT["admin"]->get("style_not_installed")."<br>".$TEXT["admin"]->get("style_not_found"),
            $TEXT["admin"]->get("error"), TRUE, $TEXT["admin"]->get("icon_no_install_action") );
        unset ( $_POST );
    }
}

///////////////////////
//// Display Forms ////
///////////////////////
if ( isset ( $_POST['style_id'] ) && $_POST['style_action'] )
{
    // Security Functions
    $_POST['style_id'] = ( is_array ( $_POST['style_id'] ) ) ? $_POST['style_id'] : array ( $_POST['style_id'] );
    $_POST['style_id'] = array_map ( "intval", $_POST['style_id'] );
    
    /////////////////////////
    //// Edit Style Form ////
    /////////////////////////
    if ( $_POST['style_action'] == "edit" && count ( $_POST['style_id'] ) == 1 )
    {
        $_POST['style_id'] = $_POST['style_id'][0];

        // Display Error Messages
        if ( $_POST['sended'] == "edit" ) {

            $error_message = $TEXT["admin"]->get("form_not_filled");
            systext ( $TEXT["admin"]->get("style_not_edited")."<br>".$error_message,
                $TEXT["admin"]->get("error"), TRUE, $TEXT["admin"]->get("icon_save_error") );

        // Get Data from DB
        } else {
            $index = mysql_query ( "
                                    SELECT *
                                    FROM `".$global_config_arr['pref']."styles`
                                    WHERE `style_id` = '".$_POST['style_id']."'
                                    LIMIT 0,1
            ", $db );
            $data_arr = mysql_fetch_assoc ( $index );
            $style_ini = FS2_ROOT_PATH . "styles/" . stripslashes ( $data_arr['style_tag'] ) . "/style.ini";
            $ACCESS = new fileaccess();
            $ini_lines = $ACCESS->getFileArray( $style_ini );
            $data_arr['style_name'] = $ini_lines[0];
            $data_arr['style_version'] = $ini_lines[1];
            $data_arr['style_copyright'] = $ini_lines[2];
            putintopost ( $data_arr );
        }

        // Security Functions
        $_POST['style_name'] = killhtml ( $_POST['style_name'] );
        $_POST['style_version'] = killhtml ( $_POST['style_version'] );
        $_POST['style_copyright'] = killhtml ( $_POST['style_copyright'] );

        settype ( $_POST['style_id'], "integer" );
        settype ( $_POST['style_allow_use'], "integer" );
        settype ( $_POST['style_allow_edit'], "integer" );

        // Display Form
        echo '
                    <form action="" method="post">
                        <input type="hidden" name="go" value="style_management">
                        <input type="hidden" name="style_action" value="edit">
                        <input type="hidden" name="sended" value="edit">
                        <input type="hidden" name="style_id" value="'.$_POST['style_id'].'">
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="2">'.$TEXT["admin"]->get("style_info_title").'</td></tr>
                            <tr>
                                <td class="config">
                                    '.$TEXT["admin"]->get("style_tag_title").':<br>
                                    <span class="small">'.$TEXT["admin"]->get("style_tag_desc").'</span>
                                </td>
                                <td class="config">
                                    '.killhtml ( $data_arr['style_tag'] ).'
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$TEXT["admin"]->get("style_name_title").':<br>
                                    <span class="small">'.$TEXT["admin"]->get("style_name_desc").'</span>
                                </td>
                                <td class="config">
                                    <input class="text input_width" name="style_name" maxlength="100" value="'.$_POST['style_name'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$TEXT["admin"]->get("style_version_title").': <span class="small">('.$TEXT["admin"]->get("optional").')</span><br>
                                    <span class="small">'.$TEXT["admin"]->get("style_version_desc").'</span>
                                </td>
                                <td class="config">
                                    <input class="text input_width_mini" name="style_version" maxlength="15" value="'.$_POST['style_version'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$TEXT["admin"]->get("style_copyright_title").': <span class="small">('.$TEXT["admin"]->get("optional").')</span><br>
                                    <span class="small">'.$TEXT["admin"]->get("style_copyright_desc").'</span>
                                </td>
                                <td class="config">
                                    <input class="text input_width" name="style_copyright" maxlength="255" value="'.$_POST['style_copyright'].'">
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>

                            <tr><td class="line" colspan="2">'.$TEXT["admin"]->get("style_config_title").'</td></tr>
                            <tr>
                                <td class="config">
                                    '.$TEXT["admin"]->get("style_allow_use_title").':<br>
                                    <span class="small">'.$TEXT["admin"]->get("style_allow_use_desc").'</span>
                                </td>
                                <td class="config">
                                    <input class="pointer" type="checkbox" name="style_allow_use" value="1" '.getchecked ( 1, $_POST['style_allow_use'] ).'>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$TEXT["admin"]->get("style_allow_edit_title").':<br>
                                    <span class="small">'.$TEXT["admin"]->get("style_allow_edit_desc").'</span>
                                </td>
                                <td class="config">
                                    <input class="pointer" type="checkbox" name="style_allow_edit" value="1" '.getchecked ( 1, $_POST['style_allow_edit'] ).'>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td colspan="2" class="buttontd">
                                    <button class="button_new" type="submit">
                                        '.$TEXT["admin"]->get("button_arrow").' '.$TEXT["admin"]->get("save_changes_button").'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
        ';
    }
    

    //////////////////////////
    //// Unsinstall Style ////
    //////////////////////////
    elseif ( $_POST['style_action'] == "uninstall" && count ( $_POST['style_id'] ) == 1  )
    {
        $_POST['style_id'] = $_POST['style_id'][0];

        // Check if style is last
        $index = mysql_query ( "
                                SELECT `style_id`, `style_tag`
                                FROM `".$global_config_arr['pref']."styles`
                                WHERE `style_id` != 0
                                AND `style_allow_use` = 1
                                AND `style_id` != ".$_POST['style_id']."
                                ORDER BY `style_tag`
        ", $db );
        
        // Not last usable Style
        if ( mysql_num_rows ( $index ) >= 1 ) {
        
            // Display Head of Table
            echo '
                    <form action="" method="post">
                        <input type="hidden" name="go" value="style_management">
                        <input type="hidden" name="style_action" value="uninstall">
                        <input type="hidden" name="sended" value="uninstall">
                        <input type="hidden" name="style_id" value="'.$_POST['style_id'].'">
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="2">'.$TEXT["admin"]->get("style_uninstall_title").'</td></tr>
                            <tr>
                                <td class="configthin">
                                    '.$TEXT["admin"]->get("style_uninstall_question").'
                                    <br><br>
            ';

            // get style from db
            $data = mysql_query ( "
                                    SELECT *
                                    FROM `".$global_config_arr['pref']."styles`
                                    WHERE `style_id` = ".$_POST['style_id']."
                                    LIMIT 0,1
            ", $db );
            $data_arr = mysql_fetch_assoc ( $data );
            $data_arr['ini_lines'] = get_style_ini_data ( FS2_ROOT_PATH . "styles/" . stripslashes ( $data_arr['style_tag'] ) . "/style.ini" );

            // display style info
            echo '
                                    <b>'.$data_arr['ini_lines'][0].'</b>, [..]/styles/<b>'.$data_arr['style_tag'].'</b>/
            ';
            
            // style is active style
            if ( $global_config_arr['style_id'] == $_POST['style_id'] ) {
                echo '
                                    <br><br>
                                    '.$TEXT["admin"]->get("style_is_active").'<br>
                                    <b>'.$TEXT["admin"]->get("style_select_new_active").'</b><br><br>
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        <tr class="middle">
                                            <td class="middle config">
                                                '.$TEXT['admin']->get("config_style_title").':<br>
                                                <span class="small">'.$TEXT['admin']->get("config_style_desc").'</span>
                                            </td>
                                            <td class="middle config">
                                                <select class="input_width_mini" name="new_style_id" size="1">
                ';
                while ( $style_arr = mysql_fetch_assoc ( $index ) ) {
                    settype ( $style_arr['style_id'], "integer" );
                    echo '<option value="'.$style_arr['style_id'].'">'.killhtml ( $style_arr['style_tag'] ).'</option>';
                }
                echo '
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                ';
            }
            
            // Display End of Table
            echo '
                                </td>
                                <td class="config right top" style="padding: 0px;">
                                    '.get_yesno_table ( "style_uninstall" ).'
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="buttontd" colspan="2">
                                    <button class="button_new" type="submit">
                                        '.$TEXT["admin"]->get("button_arrow").' '.$TEXT["admin"]->get("do_action_button_long").'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
            ';
            
        } else {
            // Display not possible Info
            systext ( $TEXT["admin"]->get("style_not_uninstalled")."<br>".$TEXT["admin"]->get("style_is_last_useable"),
                $TEXT["admin"]->get("error"), FALSE, $TEXT["admin"]->get("icon_no_install_action") );
            unset ( $_POST );
        }
    }

    //////////////////////////////////////////////////////////////
    //// Show to much selected Error & Go back to Select Form ////
    //////////////////////////////////////////////////////////////
    elseif ( count ( $_POST['style_id'] ) > 1 ) {
        // Display Error
        systext ( $TEXT["admin"]->get("select_only_one_to_edit"),
            $TEXT["admin"]->get("error"), TRUE, $TEXT["admin"]->get("icon_error") );
        unset ( $_POST['style_id'] );
    }
}


//////////////////////////
//// Show Styles Form ////
//////////////////////////
if ( !isset ( $_POST['style_id'] ) )
{
    // get Styles from db
    $index = mysql_query ( "
                            SELECT *
                            FROM `".$global_config_arr['pref']."styles`
                            WHERE `style_id` != 0
                            AND `style_tag` != 'default'
                            ORDER BY `style_tag`
    ", $db );
    
    $num_of_styles = mysql_num_rows ( $index );
    
    $style_arr = array();
    $style_tag_arr = array();
    while ( $data_arr = mysql_fetch_assoc ( $index ) ) {
        $style_arr[] = $data_arr;
        $style_tag_arr[] = $data_arr['style_tag'];
    }

    // Header for not yet installed Styles
    echo '
                    <form action="" method="post">
                        <input type="hidden" name="go" value="style_management">
                        <table class="configtable select_list" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="4">'.$TEXT["admin"]->get("styles_not_installed_title").'</td></tr>
    ';

    // Search for not yet installed Styles
    $num_not_inc_styles = 0;
    $styles = scandir_filter ( FS2_ROOT_PATH . "styles", array ( "default" ) );
    foreach ( $styles as $style ) {
        if ( !in_array ( $style, $style_tag_arr ) && is_dir ( FS2_ROOT_PATH . "styles/" . $style ) == TRUE ) {
            $style_ini = FS2_ROOT_PATH . "styles/" . $style . "/style.ini";
            if ( is_readable ( $style_ini ) ) {
                if ( $num_not_inc_style <= 0 ) {
                    echo '
                            <tr>
                                <td class="config">
                                    '.$TEXT["admin"]->get("style_name_title").'
                                </td>
                                <td class="config">
                                    '.$TEXT["admin"]->get("style_folder_title").' / '.$TEXT["admin"]->get("style_tag_title").'
                                </td>
                                <td class="config" width="50%">
                                    '.$TEXT["admin"]->get("style_copyright_title").'
                                </td>
                                <td class="config" width="20"></td>
                            </tr>
                    ';
                }

                $num_not_inc_styles++;
                $ini_lines = get_style_ini_data ( $style_ini );
                echo '
                            <tr class="select_entry">
                                <td class="middle config">
                                    '.$ini_lines[0].'<br>
                                    <span class="small">'.$TEXT["admin"]->get("version").'&nbsp;'.$ini_lines[1].'</span>
                                </td>
                                <td class="middle configthin">[..]/styles/<b>'.$style.'</b>/</td>
                                <td class="middle configthin">
                                    '.$ini_lines[2].'
                                </td>
                                <td class="config middle center">
                                    <input class="pointer select_box" type="checkbox" name="style_tag" value="'.$style.'">
                                </td>
                            </tr>
                ';
            }
        }
    }
    // Footer for not yet installed Styles
    if ( $num_not_inc_styles > 0 ) {
        echo'
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="right" colspan="4">
                                    <select class="select_type" name="style_action" size="1">
                                        <option class="select_one" value="install" '.getselected( "install", $_POST['style_action'] ).'>'.$TEXT["admin"]->get("styles_selection_install").'</option>
                                    </select>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="buttontd" colspan="4">
                                    <button class="button_new" type="submit">
                                        '.$TEXT["admin"]->get("button_arrow").' '.$TEXT["admin"]->get("do_action_button_long").'
                                    </button>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
        ';
    // No not yet installed Styles found
    } else {
        echo '
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="config center" colspan="4">'.$TEXT["admin"]->get("styles_no_not_installed").'</td>
                            </tr>
                            <tr><td class="space"></td></tr>
        ';
    }
    echo '
                        </table>
                </form>
    ';

    

    // Header for installed Styles
    echo '
                    <form action="" method="post">
                        <input type="hidden" name="go" value="style_management">
                        <table class="select_list configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="4">'.$TEXT["admin"]->get("styles_installed_title").'</td></tr>
    ';


    // Styles found
    if ( $num_of_styles > 0 ) {

        // display table head
        echo '
                            <tr>
                                <td class="config">
                                    '.$TEXT["admin"]->get("style_name_title").'
                                </td>
                                <td class="config">
                                    '.$TEXT["admin"]->get("style_folder_title").' / '.$TEXT["admin"]->get("style_tag_title").'
                                </td>
                                <td class="config" width="50%">
                                    '.$TEXT["admin"]->get("style_copyright_title").'
                                </td>
                                <td class="config" width="20"></td>
                            </tr>
        ';

        // display styles
        foreach ( $style_arr as $data_arr ) {

            // Security Functions
            $data_arr['style_folder'] = stripslashes ( $data_arr['style_tag'] );
            $data_arr['style_tag'] = killhtml ( $data_arr['style_tag'] );

            $style_ini = FS2_ROOT_PATH . "styles/" . $data_arr['style_folder'] . "/style.ini";
            $data_arr['ini_lines'] = get_style_ini_data ( $style_ini );
            
            echo '
                            <tr class="select_entry">
                                <td class="middle config">
                                    '.$data_arr['ini_lines'][0].'<br>
                                    <span class="small">'.$TEXT["admin"]->get("version").'&nbsp;'.$data_arr['ini_lines'][1].'</span>
                                </td>
                                <td class="middle configthin">[..]/styles/<b>'.$data_arr['style_tag'].'</b>/</td>
                                <td class="middle configthin">
                                    '.$data_arr['ini_lines'][2].'
                                </td>
                                <td class="config middle center">
                                    <input class="pointer select_box" type="checkbox" name="style_id[]" value="'.$data_arr['style_id'].'">
                                </td>
                            </tr>
            ';
        }

        // display footer with button
        echo'
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="right" colspan="4">
                                    <select class="select_type" name="style_action" size="1">
                                        <option class="select_one" value="edit" '.getselected( "edit", $_POST['style_action'] ).'>'.$TEXT["admin"]->get("selection_edit").'</option>
                                        <option class="select_red select_one" value="uninstall" '.getselected( "uninstall", $_POST['style_action'] ).'>'.$TEXT["admin"]->get("styles_selection_uninstall").'</option>
                                    </select>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="buttontd" colspan="4">
                                    <button class="button_new" type="submit">
                                        '.$TEXT["admin"]->get("button_arrow").' '.$TEXT["admin"]->get("do_action_button_long").'
                                    </button>
                                </td>
                            </tr>
        ';

    // no styles found
    } else {

           echo'
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="config center" colspan="4">'.$TEXT["admin"]->get("styles_no_installed").'</td>
                            </tr>
                            <tr><td class="space"></td></tr>
        ';
    }
    echo '
                        </table>
                </form>
    ';
}
?>