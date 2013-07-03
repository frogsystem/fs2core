<?php if (!defined('ACP_GO')) die('Unauthorized access!');

//////////////////////////
//// Locale Functions ////
//////////////////////////
function get_style_ini_data ( $STYLE_INI_FILE ) {

    $ACCESS = new fileaccess();
    $ini_lines = $ACCESS->getFileArray( $STYLE_INI_FILE );
    $ini_lines = array_map ( 'trim', $ini_lines );
    $ini_lines = array_map ( 'killhtml', $ini_lines );
    $ini_lines[1] = ( $ini_lines[1] != '' ) ? $ini_lines[1] : '';
    return $ini_lines;
}


//////////////////////////
//// DB: Update Style ////
//////////////////////////

if (
        isset ( $_POST['sended'] ) && $_POST['sended'] == 'edit'
        && isset ( $_POST['style_action'] ) && $_POST['style_action'] == 'edit'
        && isset ( $_POST['style_id'] )
        && $_POST['style_name'] && $_POST['style_name'] != ''
    )
{
    // Security-Functions
    settype ( $_POST['style_id'], 'integer' );
    settype ( $_POST['style_allow_use'], 'integer' );
    settype ( $_POST['style_allow_edit'], 'integer' );

    // SQL-Queries
    $FD->sql()->conn()->exec ( '
            UPDATE `'.$FD->config('pref')."styles`
            SET
                `style_allow_use` = '".$_POST['style_allow_use']."',
                `style_allow_edit` = '".$_POST['style_allow_edit']."'
            WHERE `style_id` = '".$_POST['style_id']."'" );

    $index = $FD->sql()->conn()->query ( '
                    SELECT `style_tag`
                    FROM `'.$FD->config('pref')."styles`
                    WHERE `style_id` = ".$_POST['style_id'] );

    $new_ini_data = $_POST['style_name']."
".$_POST['style_version']."
".$_POST['style_copyright'];

    $style_ini = FS2_ROOT_PATH . 'styles/' . $index->fetchColumn() . '/style.ini';
    $ACCESS = new fileaccess();
    if ( $ACCESS->putFileData( $style_ini, $new_ini_data ) === FALSE ) {
        $error_extension = '<br>'.$FD->text('admin', 'style_info_not_saved');
    }
    else
    {
        $error_extension = '';
    }

    // Display Message
    systext ( $FD->text('admin', 'changes_saved').$error_extension,
        $FD->text('admin', 'info'), FALSE, $FD->text('admin', 'icon_save_ok') );

    // Unset Vars
    unset ( $_POST );
}

/////////////////////////////
//// DB: Uninstall Style ////
/////////////////////////////
elseif (
        isset ( $_POST['sended'] ) && $_POST['sended'] == 'uninstall'
        && isset ( $_POST['style_action'] ) && $_POST['style_action'] == 'uninstall'
        && isset ( $_POST['style_id'] )
        && isset ( $_POST['style_uninstall'] )
    )
{
    if ( $_POST['style_uninstall'] == 1 ) {

        // Security-Functions
        settype ( $_POST['style_id'], 'integer' );

        // Check if style is last
        $index = $FD->sql()->conn()->query ( '
                        SELECT COUNT(`style_id`)
                        FROM `'.$FD->config('pref').'styles`
                        WHERE `style_allow_use` = 1
                        AND `style_id` != '.$_POST['style_id'] );

        // Not last usable Style
        if ( $index->fetchColumn() >= 1 ) {

            // SQL-Delete-Query
            $FD->sql()->conn()->exec ('
                    DELETE
                    FROM `'.$FD->config('pref').'styles`
                    WHERE `style_id` = '.$_POST['style_id'] );

            if (
                $FD->config('style_id') == $_POST['style_id']
                && isset ( $_POST['new_style_id'] ) && $_POST['new_style_id'] != 0 && $_POST['new_style_id'] != ''
                && is_numeric ( $_POST['new_style_id'] )
            ) {
                // Security-Functions
                settype ( $_POST['new_style_id'], 'integer' );

                $index = $FD->sql()->conn()->query ( '
                                SELECT `style_tag`
                                FROM `'.$FD->config('pref').'styles`
                                WHERE `style_id` = '.$_POST['new_style_id'].'
                                AND `style_id` != 0
                                AND `style_allow_use` = 1
                                LIMIT 0,1' );
                $tag = $index->fetchColumn();
                if ( $tag !== false ) {
                    // SQL-Queries
                    $stmt = $FD->sql()->conn()->prepare('
                                UPDATE
                                    `'.$FD->config('pref')."global_config`
                                SET
                                    `style_id` = '".$_POST['new_style_id']."',
                                    `style_tag` = ?
                                WHERE `id` = '1'");
                    $stmt->execute(array( $tag ));
                }
            }

            systext ( $FD->text("admin", "style_uninstalled"),
                $FD->text("admin", "info"), FALSE, $FD->text("admin", "icon_uninstall_ok") );
        } else {
            // uninstall style is not possible
            systext ( $FD->text("admin", "style_not_uninstalled").'<br>'.$FD->text("admin", "style_is_last_useable"),
                $FD->text("admin", "error"), TRUE, $FD->text("admin", "icon_no_install_action") );
            unset ( $_POST );
        }

    } else {
        systext ( $FD->text("admin", "style_not_uninstalled"),
            $FD->text("admin", "info"), FALSE, $FD->text("admin", "icon_no_install_action") );
    }

    // Unset Vars
    unset ( $_POST );
}

///////////////////////////
//// DB: Install Style ////
///////////////////////////
elseif (
        isset ( $_POST['style_action'] ) && $_POST['style_action'] == 'install'
        && isset ( $_POST['style_tag'] ) && $_POST['style_tag'] != ''
    )
{

    if ( file_exists ( FS2_ROOT_PATH . 'styles/' . $_POST['style_tag'] . '/style.ini' ) ) {

        // SQL-Queries
        $stmt = $FD->sql()->conn()->prepare('
                    INSERT INTO
                        `'.$FD->config('pref')."styles`
                        (`style_tag`, `style_allow_use`, `style_allow_edit`)
                    VALUES
                        ( ?, 1, 1 )");
        $stmt->execute(array($_POST['style_tag']));

        // Display info
        systext ( $FD->text("admin", "style_installed"),
            $FD->text("admin", "info"), FALSE, $FD->text("admin", "icon_install_ok") );

        // Go to Edit-Page of the installed Style
        unset ( $_POST );
        $_POST['style_id'] = $FD->sql()->conn()->lastInsertId();
        $_POST['style_action'] = 'edit';

    } else {
        // Display not found Info
        systext ( $FD->text("admin", "style_not_installed").'<br>'.$FD->text("admin", "style_not_found"),
            $FD->text("admin", "error"), TRUE, $FD->text("admin", "icon_no_install_action") );
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
    $_POST['style_id'] = array_map ( 'intval', $_POST['style_id'] );

    /////////////////////////
    //// Edit Style Form ////
    /////////////////////////
    if ( $_POST['style_action'] == 'edit' && count ( $_POST['style_id'] ) == 1 )
    {
        $_POST['style_id'] = $_POST['style_id'][0];

        // Display Error Messages
        if ( isset($_POST['sended']) && ($_POST['sended'] == 'edit') ) {

            $error_message = $FD->text('admin', 'form_not_filled');
            systext ( $FD->text('admin', 'style_not_edited').'<br>'.$error_message,
                $FD->text('admin', 'error'), TRUE, $FD->text('admin', 'icon_save_error') );

        // Get Data from DB
        } else {
            $index = $FD->sql()->conn()->query ( '
                            SELECT *
                            FROM `'.$FD->config('pref')."styles`
                            WHERE `style_id` = '".$_POST['style_id']."'
                            LIMIT 0,1" );
            $data_arr = $index->fetch(PDO::FETCH_ASSOC);
            $style_ini = FS2_ROOT_PATH . 'styles/' . $data_arr['style_tag'] . '/style.ini';
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

        settype ( $_POST['style_id'], 'integer' );
        settype ( $_POST['style_allow_use'], 'integer' );
        settype ( $_POST['style_allow_edit'], 'integer' );

        // Display Form
        echo '
                    <form action="" method="post">
                        <input type="hidden" name="go" value="style_management">
                        <input type="hidden" name="style_action" value="edit">
                        <input type="hidden" name="sended" value="edit">
                        <input type="hidden" name="style_id" value="'.$_POST['style_id'].'">
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="2">'.$FD->text("admin", "style_info_title").'</td></tr>
                            <tr>
                                <td class="config">
                                    '.$FD->text("admin", "style_tag_title").':<br>
                                    <span class="small">'.$FD->text("admin", "style_tag_desc").'</span>
                                </td>
                                <td class="config">
                                    '.killhtml ( $data_arr['style_tag'] ).'
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$FD->text("admin", "style_name_title").':<br>
                                    <span class="small">'.$FD->text("admin", "style_name_desc").'</span>
                                </td>
                                <td class="config">
                                    <input class="text input_width" name="style_name" maxlength="100" value="'.$_POST['style_name'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$FD->text("admin", "style_version_title").': <span class="small">('.$FD->text("admin", "optional").')</span><br>
                                    <span class="small">'.$FD->text("admin", "style_version_desc").'</span>
                                </td>
                                <td class="config">
                                    <input class="text input_width_mini" name="style_version" maxlength="15" value="'.$_POST['style_version'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$FD->text("admin", "style_copyright_title").': <span class="small">('.$FD->text("admin", "optional").')</span><br>
                                    <span class="small">'.$FD->text("admin", "style_copyright_desc").'</span>
                                </td>
                                <td class="config">
                                    <input class="text input_width" name="style_copyright" maxlength="255" value="'.$_POST['style_copyright'].'">
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>

                            <tr><td class="line" colspan="2">'.$FD->text("admin", "style_config_title").'</td></tr>
                            <tr>
                                <td class="config">
                                    '.$FD->text("admin", "style_allow_use_title").':<br>
                                    <span class="small">'.$FD->text("admin", "style_allow_use_desc").'</span>
                                </td>
                                <td class="config">
                                    <input class="pointer" type="checkbox" name="style_allow_use" value="1" '.getchecked ( 1, $_POST['style_allow_use'] ).'>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$FD->text("admin", "style_allow_edit_title").':<br>
                                    <span class="small">'.$FD->text("admin", "style_allow_edit_desc").'</span>
                                </td>
                                <td class="config">
                                    <input class="pointer" type="checkbox" name="style_allow_edit" value="1" '.getchecked ( 1, $_POST['style_allow_edit'] ).'>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td colspan="2" class="buttontd">
                                    <button class="button_new" type="submit">
                                        '.$FD->text("admin", "button_arrow").' '.$FD->text("admin", "save_changes_button").'
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
    elseif ( $_POST['style_action'] == 'uninstall' && count ( $_POST['style_id'] ) == 1  )
    {
        $_POST['style_id'] = $_POST['style_id'][0];

        // Check if style is last
        $index = $FD->sql()->conn()->query ( '
                        SELECT COUNT(`style_id`)
                        FROM `'.$FD->config('pref').'styles`
                        WHERE `style_id` != 0
                        AND `style_allow_use` = 1
                        AND `style_id` != '.$_POST['style_id'].'
                        ORDER BY `style_tag`' );

        // Not last usable Style
        if ( $index->fetchColumn() >= 1 ) {

            // Display Head of Table
            echo '
                    <form action="" method="post">
                        <input type="hidden" name="go" value="style_management">
                        <input type="hidden" name="style_action" value="uninstall">
                        <input type="hidden" name="sended" value="uninstall">
                        <input type="hidden" name="style_id" value="'.$_POST['style_id'].'">
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="2">'.$FD->text("admin", "style_uninstall_title").'</td></tr>
                            <tr>
                                <td class="configthin">
                                    '.$FD->text("admin", "style_uninstall_question").'
                                    <br><br>
            ';

            // get style from db
            $data = $FD->sql()->conn()->query ( '
                        SELECT *
                        FROM `'.$FD->config('pref').'styles`
                        WHERE `style_id` = '.$_POST['style_id'].'
                        LIMIT 0,1');
            $data_arr = $data->fetch(PDO::FETCH_ASSOC);
            $data_arr['ini_lines'] = get_style_ini_data ( FS2_ROOT_PATH . 'styles/' . $data_arr['style_tag'] . '/style.ini' );

            // display style info
            echo '
                                    <b>'.$data_arr['ini_lines'][0].'</b>, [..]/styles/<b>'.$data_arr['style_tag'].'</b>/
            ';

            // style is active style
            if ( $FD->config('style_id') == $_POST['style_id'] ) {
                echo '
                                    <br><br>
                                    '.$FD->text("admin", "style_is_active").'<br>
                                    <b>'.$FD->text("admin", "style_select_new_active").'</b><br><br>
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        <tr class="middle">
                                            <td class="middle config">
                                                '.$FD->text("admin", "config_style_title").':<br>
                                                <span class="small">'.$FD->text("admin", "config_style_desc").'</span>
                                            </td>
                                            <td class="middle config">
                                                <select class="input_width_mini" name="new_style_id" size="1">
                ';
                $index = $FD->sql()->conn()->query ( '
                        SELECT `style_id`, `style_tag`
                        FROM `'.$FD->config('pref').'styles`
                        WHERE `style_id` != 0
                        AND `style_allow_use` = 1
                        AND `style_id` != '.$_POST['style_id'].'
                        ORDER BY `style_tag`' );
                while ( $style_arr = $index->fetch(PDO::FETCH_ASSOC) ) {
                    settype ( $style_arr['style_id'], 'integer' );
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
                                    '.get_yesno_table ( 'style_uninstall' ).'
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="buttontd" colspan="2">
                                    <button class="button_new" type="submit">
                                        '.$FD->text("admin", "button_arrow").' '.$FD->text("admin", "do_action_button_long").'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
            ';

        } else {
            // Display not possible Info
            systext ( $FD->text("admin", "style_not_uninstalled").'<br>'.$FD->text("admin", "style_is_last_useable"),
                $FD->text("admin", "error"), FALSE, $FD->text("admin", "icon_no_install_action") );
            unset ( $_POST );
        }
    }

    //////////////////////////////////////////////////////////////
    //// Show to much selected Error & Go back to Select Form ////
    //////////////////////////////////////////////////////////////
    elseif ( count ( $_POST['style_id'] ) > 1 ) {
        // Display Error
        systext ( $FD->text("admin", "select_only_one_to_edit"),
            $FD->text("admin", "error"), TRUE, $FD->text("admin", "icon_error") );
        unset ( $_POST['style_id'] );
    }
}


//////////////////////////
//// Show Styles Form ////
//////////////////////////
if ( !isset ( $_POST['style_id'] ) )
{
    // get Styles from db
    $index = $FD->sql()->conn()->query ( '
                    SELECT COUNT(*)
                    FROM `'.$FD->config('pref')."styles`
                    WHERE `style_id` != 0
                    AND `style_tag` != 'default'
                    ORDER BY `style_tag`" );

    $num_of_styles = $index->fetchColumn();

    $index = $FD->sql()->conn()->query ( '
                    SELECT *
                    FROM `'.$FD->config('pref')."styles`
                    WHERE `style_id` != 0
                    AND `style_tag` != 'default'
                    ORDER BY `style_tag`" );

    $style_arr = array();
    $style_tag_arr = array();
    while ( $data_arr = $index->fetch(PDO::FETCH_ASSOC) ) {
        $style_arr[] = $data_arr;
        $style_tag_arr[] = $data_arr['style_tag'];
    }

    // Header for not yet installed Styles
    echo '
                    <form action="" method="post">
                        <input type="hidden" name="go" value="style_management">
                        <table class="configtable select_list" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="4">'.$FD->text("admin", "styles_not_installed_title").'</td></tr>
    ';

    // Search for not yet installed Styles
    $num_not_inc_styles = 0;
    $styles = scandir_filter ( FS2_ROOT_PATH . 'styles', array ( 'default' ) );
    foreach ( $styles as $style ) {
        if ( !in_array ( $style, $style_tag_arr ) && is_dir ( FS2_ROOT_PATH . 'styles/' . $style ) == TRUE ) {
            $style_ini = FS2_ROOT_PATH . 'styles/' . $style . '/style.ini';
            if ( is_readable ( $style_ini ) ) {
                if ( $num_not_inc_styles <= 0 ) {
                    echo '
                            <tr>
                                <td class="config">
                                    '.$FD->text("admin", "style_name_title").'
                                </td>
                                <td class="config">
                                    '.$FD->text("admin", "style_folder_title").' / '.$FD->text("admin", "style_tag_title").'
                                </td>
                                <td class="config" width="50%">
                                    '.$FD->text("admin", "style_copyright_title").'
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
                                    <span class="small">'.$FD->text("admin", "version").'&nbsp;'.$ini_lines[1].'</span>
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
                                        <option class="select_one" value="install" '.getselected( 'install', $_POST['style_action'] ).'>'.$FD->text("admin", "styles_selection_install").'</option>
                                    </select>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="buttontd" colspan="4">
                                    <button class="button_new" type="submit">
                                        '.$FD->text("admin", "button_arrow").' '.$FD->text("admin", "do_action_button_long").'
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
                                <td class="config center" colspan="4">'.$FD->text("admin", "styles_no_not_installed").'</td>
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
                            <tr><td class="line" colspan="4">'.$FD->text("admin", "styles_installed_title").'</td></tr>
    ';


    // Styles found
    if ( $num_of_styles > 0 ) {

        // display table head
        echo '
                            <tr>
                                <td class="config">
                                    '.$FD->text("admin", "style_name_title").'
                                </td>
                                <td class="config">
                                    '.$FD->text("admin", "style_folder_title").' / '.$FD->text("admin", "style_tag_title").'
                                </td>
                                <td class="config" width="50%">
                                    '.$FD->text("admin", "style_copyright_title").'
                                </td>
                                <td class="config" width="20"></td>
                            </tr>
        ';

        // display styles
        foreach ( $style_arr as $data_arr ) {

            // Security Functions
            $data_arr['style_folder'] = $data_arr['style_tag'];
            $data_arr['style_tag'] = killhtml ( $data_arr['style_tag'] );

            $style_ini = FS2_ROOT_PATH . 'styles/' . $data_arr['style_folder'] . '/style.ini';
            $data_arr['ini_lines'] = get_style_ini_data ( $style_ini );

            echo '
                            <tr class="select_entry">
                                <td class="middle config">
                                    '.$data_arr['ini_lines'][0].'<br>
                                    <span class="small">'.$FD->text("admin", "version").'&nbsp;'.$data_arr['ini_lines'][1].'</span>
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

        if (!isset($_POST['style_action']))
          $_POST['style_action'] = '';
        // display footer with button
        echo'
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="right" colspan="4">
                                    <select class="select_type" name="style_action" size="1">
                                        <option class="select_one" value="edit" '.getselected( 'edit', $_POST['style_action'] ).'>'.$FD->text("admin", "selection_edit").'</option>
                                        <option class="select_red select_one" value="uninstall" '.getselected( 'uninstall', $_POST['style_action'] ).'>'.$FD->text("admin", "styles_selection_uninstall").'</option>
                                    </select>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="buttontd" colspan="4">
                                    <button class="button_new" type="submit">
                                        '.$FD->text("admin", "button_arrow").' '.$FD->text("admin", "do_action_button_long").'
                                    </button>
                                </td>
                            </tr>
        ';

    // no styles found
    } else {

           echo'
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="config center" colspan="4">'.$FD->text("admin", "styles_no_installed").'</td>
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
