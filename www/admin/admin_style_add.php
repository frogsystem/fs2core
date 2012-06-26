<?php

/////////////////////////
//// Save Data to DB ////
/////////////////////////

if (
        $_POST['style_tag'] && preg_match ( '/^[0-9a-z_\-]+$/', $_POST['style_tag'] ) === 1
        && $_POST['style_tag'] != '' && strlen ( $_POST['style_tag'] ) >= 1
        && $_POST['style_name'] && $_POST['style_name'] != ''
        && ( $_POST['style_create_as'] == 'new' || ( $_POST['style_create_as'] == 'copy' && $_POST['copy_style_id'] ) )
    )
{
    // Security Functions
    $_POST['style_folder'] = $_POST['style_tag'];
    $_POST['style_tag'] = savesql ( $_POST['style_tag'] );
    $_POST['style_create_as'] = ( $_POST['style_create_as'] == 'copy' ) ? 'copy' : 'new';
    settype ( $_POST['style_allow_use'], 'integer' );
    settype ( $_POST['style_allow_edit'], 'integer' );
    settype ( $_POST['copy_style_id'], 'integer' );

    // Folder Operations
    $new_ini_data = $_POST['style_name']."
".$_POST['style_version']."
".$_POST['style_copyright'];

    // New Style Path
    $new_style_path = FS2_ROOT_PATH . 'styles/' . $_POST['style_folder'];

    // Create Sytle Folder
    $ACCESS = new fileaccess();
    if (
            @$ACCESS->createDir( $new_style_path , 0777 )
            && @$ACCESS->putFileData( $new_style_path . '/style.ini', $new_ini_data )
    ) {
        // MySQL-Queries
        mysql_query ( '
                        INSERT INTO
                            `'.$global_config_arr['pref']."styles`
                            ( `style_tag`, `style_allow_use`, `style_allow_edit` )
                        VALUES
                            ( '".$_POST['style_tag']."', '".$_POST['style_allow_use']."', '".$_POST['style_allow_edit']."' )
        ", $FD->sql()->conn() );

        // Copy Style recursive
        if ( $_POST['style_create_as'] == 'copy' && $_POST['copy_style_id'] ) {
            // MySQL-Queries
            $index = mysql_query ( '
                                    SELECT
                                        `style_tag`
                                    FROM
                                        `'.$global_config_arr['pref'].'styles`
                                    WHERE
                                        `style_id` = '.$_POST['copy_style_id'].'
                                    LIMIT 0,1
            ', $FD->sql()->conn() );
            $copy_style_path = FS2_ROOT_PATH . 'styles/' . stripslashes ( mysql_result ( $index, 0, 'style_tag' ) );
            if (
                    $ACCESS->copyAny( $copy_style_path, $new_style_path, 0777, 0644 )
                    && $ACCESS->putFileData( $new_style_path . '/style.ini', $new_ini_data )
            ) {
                systext ( $FD->text("admin", "style_added"),
                    $FD->text("admin", "info"), FALSE, $FD->text("admin", "icon_save_add") );
            } else {
                systext ( $FD->text("admin", "style_added").'<br>'.$FD->text("admin", "style_error_copy").'<br>'.$FD->text("admin", "error_file_access"),
                    $FD->text("admin", "info"), FALSE, $FD->text("admin", "icon_save_add") );
            }
        // Create New Style
        } else {
            if (
                    @$ACCESS->createDir( $new_style_path . '/images', 0777 )
                    && @$ACCESS->createDir( $new_style_path . '/icons', 0777 )
            ) {
                systext ( $FD->text("admin", "style_added"),
                    $FD->text("admin", "info"), FALSE, $FD->text("admin", "icon_save_add") );
            } else {
                systext ( $FD->text("admin", "style_added").'<br>'.$FD->text("admin", "style_error_folder_creation").'<br>'.$FD->text("admin", "error_file_access"),
                    $FD->text("admin", "info"), FALSE, $FD->text("admin", "icon_save_add") );
            }
        }

    } else {
        @deleteAny ( $new_style_path );
        systext ( $FD->text("admin", "style_not_added").'<br>'.$FD->text("admin", "error_file_access"),
            $FD->text("admin", "error"), TRUE, $FD->text("admin", "icon_error") );
    }
    unset ( $_POST );
}

////////////////////////
//// Add Stlye Form ////
////////////////////////

// Check for file rights
if ( !is_writable ( FS2_ROOT_PATH . 'styles/' ) ) {
    systext ( $FD->text("admin", "style_folder_not_writable").'<br>'.$FD->text("admin", "error_file_access"),
        $FD->text("admin", "error"), TRUE, $FD->text("admin", "icon_error") );
} else {

    // Check for Errors
    if ( isset ( $_POST['sended'] ) ) {

        $error_message = array();
        if ( $_POST['style_name'] == '' || $_POST['style_tag'] == '' ) {
            $error_message[] = $FD->text("admin", "form_not_filled");
        }
        if ( preg_match ( '/^[0-9a-z_\-]+$/', $_POST['style_tag'] ) !== 1 && $_POST['style_tag'] != '' ) {
            $error_message[] = $FD->text("admin", "form_only_allowed_values");
        }

        systext ( $FD->text("admin", "style_not_added").'<br>'.implode ( '<br>', $error_message ),
            $FD->text("admin", "error"), TRUE, $FD->text("admin", "icon_save_error") );

    // Set Data
    } else {
        $_POST['style_allow_use'] = 1;
        $_POST['style_allow_edit'] = 1;
        $_POST['copy_style_id'] = $global_config_arr['style_id'];
        $_POST['style_create_as'] = 'new';
    }


    // Security Functions
    $_POST['style_name'] = killhtml ( $_POST['style_name'] );
    $_POST['style_version'] = killhtml ( $_POST['style_version'] );
    $_POST['style_copyright'] = killhtml ( $_POST['style_copyright'] );

    $_POST['style_tag'] = killhtml ( $_POST['style_tag'] );
    $_POST['style_create_as'] = ( $_POST['style_create_as'] == 'copy' ) ? 'copy' : 'new';
    settype ( $_POST['style_allow_use'], 'integer' );
    settype ( $_POST['style_allow_edit'], 'integer' );
    settype ( $_POST['copy_style_id'], 'integer' );


    // Display Form
    echo '
                    <form action="" method="post">
                        <input type="hidden" name="go" value="style_add">
                        <input type="hidden" name="sended" value="1">
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="2">'.$FD->text("admin", "style_content_title").'</td></tr>
                                <td class="config">
                                    '.$FD->text("admin", "style_create_as_title").':<br>
                                    <span class="small">'.$FD->text("admin", "style_create_as_desc").'</span>
                                </td>
                                <td class="config">
                                    <input class="pointer middle" type="radio" name="style_create_as" id="style_create_as_new" value="new" '.getchecked ( 'new', $_POST['style_create_as'] ).'>
                                    <label class="pointer middle" for="style_create_as_new">'.$FD->text("admin", "style_create_as_empty").'</label><br><br>
                                    <input class="pointer middle" type="radio" name="style_create_as" id="style_create_as_copy" value="copy" '.getchecked ( 'copy', $_POST['style_create_as'] ).'>
                                    <label class="pointer middle" for="style_create_as_copy">'.$FD->text("admin", "style_create_as_copy").':</label>
                                    <br><br>
                                    <div align="right">
                                        <select class="input_width pointer middle" name="copy_style_id" size="1">';

    $index = mysql_query ( '
                            SELECT `style_id`, `style_tag`
                            FROM `'.$global_config_arr['pref'].'styles`
                            ORDER BY `style_id`
    ', $FD->sql()->conn() );
    while ( $style_arr = mysql_fetch_assoc ( $index ) ) {
        settype ( $style_arr['style_id'], 'integer' );
        echo '<option value="'.$style_arr['style_id'].'" '.getselected( $style_arr['style_id'], $_POST['copy_style_id'] ).'>'.killhtml ( $style_arr['style_tag'] );
        echo ( $style_arr['style_id'] == $global_config_arr['style_id'] ) ? ' ('.$FD->text("admin", "active").')' : '';
        echo '</option>';
    }
    echo'
                                        </select>
                                    </div>
                                </td>
                            <tr><td class="space"></td></tr>

                            <tr><td class="line" colspan="2">'.$FD->text("admin", "style_info_title").'</td></tr>
                            <tr>
                                <td class="config">
                                    '.$FD->text("admin", "style_tag_title").':<br>
                                    <span class="small">'.$FD->text("admin", "style_tag_desc").'</span>
                                </td>
                                <td class="config">
                                    <input class="text input_width_small" name="style_tag" maxlength="30" value="'.$_POST['style_tag'].'"><br>
                                    <span class="small">'.$FD->text("admin", "folder_name_info").'</span>
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
                                        '.$FD->text("admin", "button_arrow").' '.$FD->text("admin", "style_add_title").'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>
