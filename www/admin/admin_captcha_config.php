<?php if (!defined('ACP_GO')) die('Unauthorized access!');

###################
## Page Settings ##
###################
$used_cols = array('captcha_bg_color', 'captcha_bg_transparent', 'captcha_text_color', 'captcha_first_lower', 'captcha_first_upper', 'captcha_second_lower', 'captcha_second_upper', 'captcha_use_addition', 'captcha_use_subtraction', 'captcha_use_multiplication', 'captcha_create_easy_arithmetics', 'captcha_x', 'captcha_y', 'captcha_show_questionmark', 'captcha_use_spaces', 'captcha_show_multiplication_as_x', 'captcha_start_text_x', 'captcha_start_text_y', 'captcha_font_size', 'captcha_font_file');


/////////////////////////////////////
//// Konfiguration aktualisieren ////
/////////////////////////////////////

if (true
        && is_hexcolor ( '#'.$_POST['captcha_bg_color'] )
        && is_hexcolor ( '#'.$_POST['captcha_text_color'] )
        && $_POST['captcha_first_lower'] != ''
        && $_POST['captcha_first_upper'] != ''
        && $_POST['captcha_first_lower'] <= $_POST['captcha_first_upper']
        && $_POST['captcha_second_lower'] != ''
        && $_POST['captcha_second_upper'] != ''
        && $_POST['captcha_second_lower'] <= $_POST['captcha_second_upper']
        && $_POST['captcha_x'] != '' && $_POST['captcha_x'] > 0
        && $_POST['captcha_y'] != '' && $_POST['captcha_y'] > 0
        && $_POST['captcha_start_text_x'] != ''
        && $_POST['captcha_start_text_y'] != ''
        && ( in_array ( $_POST['captcha_font'], array ( 1, 2, 3, 4, 5 ) ) || $_POST['captcha_font'] != '' )
        && ( $_POST['captcha_use_addition'] || $_POST['captcha_use_subtraction'] || $_POST['captcha_use_multiplication'] )
    )
{
    // create missing Data
    if ( in_array ( $_POST['captcha_font'], array ( 1, 2, 3, 4, 5 ) ) ) {
        $_POST['captcha_font_size'] = $_POST['captcha_font'];
        $_POST['captcha_font_file'] = '';
    } else {
        $_POST['captcha_font_size'] = 0;
        $_POST['captcha_font_file'] = $_POST['captcha_font'];
    }
    // security functions
    $_POST['captcha_bg_color'] = savesql ( $_POST['captcha_bg_color'] );
    $_POST['captcha_text_color'] = savesql ( $_POST['captcha_text_color'] );
    $_POST['captcha_font_file'] = savesql ( $_POST['captcha_font_file'] );

    settype ( $_POST['captcha_bg_transparent'], 'integer' );
    settype ( $_POST['captcha_first_lower'], 'integer' );
    settype ( $_POST['captcha_first_upper'], 'integer' );
    settype ( $_POST['captcha_second_lower'], 'integer' );
    settype ( $_POST['captcha_second_upper'], 'integer' );
    settype ( $_POST['captcha_use_addition'], 'integer' );
    settype ( $_POST['captcha_use_subtraction'], 'integer' );
    settype ( $_POST['captcha_use_multiplication'], 'integer' );
    settype ( $_POST['captcha_create_easy_arithmetics'], 'integer' );
    settype ( $_POST['captcha_x'], 'integer' );
    settype ( $_POST['captcha_y'], 'integer' );
    settype ( $_POST['captcha_show_questionmark'], 'integer' );
    settype ( $_POST['captcha_use_spaces'], 'integer' );
    settype ( $_POST['captcha_show_multiplication_as_x'], 'integer' );
    settype ( $_POST['captcha_start_text_x'], 'integer' );
    settype ( $_POST['captcha_start_text_y'], 'integer' );
    settype ( $_POST['captcha_font_size'], 'integer' );

    // prepare data
    $data = frompost($used_cols);

    // save config
    try {
        $FD->saveConfig('captcha', $data);
        systext($FD->text('admin', 'changes_saved'), $FD->text('admin', 'info'), 'green', $FD->text('admin', 'icon_save_ok'));
    } catch (Exception $e) {}

    // Unset Vars
    unset($_POST);
}

/////////////////////////////////////
////// Konfiguration Formular ///////
/////////////////////////////////////

if ( TRUE )
{
    // Display Error Messages
    if ( isset ( $_POST['sended'] ) ) {
        $error_message = array();
        if (
                trim( $_POST['captcha_first_lower'] ) == ''
                || trim( $_POST['captcha_first_upper'] ) == ''
                || trim( $_POST['captcha_second_lower'] ) == ''
                || trim( $_POST['captcha_second_upper'] ) == ''
                || trim( $_POST['captcha_x'] ) == ''
                || trim( $_POST['captcha_y'] ) == ''
                || trim( $_POST['captcha_start_text_x'] ) == ''
                || trim( $_POST['captcha_start_text_y'] ) == ''
            )
        {
            $error_messages[] = $FD->text('admin', 'form_not_filled');
        }

        if (
                !is_hexcolor ( $_POST['captcha_bg_color'] )
                || !is_hexcolor ( $_POST['captcha_text_color'] )
                || $_POST['captcha_first_lower'] > $_POST['captcha_first_upper']
                || $_POST['captcha_second_lower'] > $_POST['captcha_second_upper']
                || $_POST['captcha_x'] <= 0
                || $_POST['captcha_y'] <= 0
            )
        {
            $error_messages[] = $FD->text('admin', 'form_only_allowed_values');
        }

        if (
                !( $_POST['captcha_use_addition'] || $_POST['captcha_use_subtraction'] || $_POST['captcha_use_multiplication'] )
            )
        {
            $error_messages[] = $FD->text('admin', 'captcha_config_one_operation');
        }

        systext ( $FD->text('admin', 'changes_not_saved').'<br>'.implode ( '<br>', $error_messages ),
            $FD->text('admin', 'error'), TRUE, $FD->text('admin', 'icon_save_error') );

    // Load Data from DB into Post
    } else {
        $data = $sql->getRow('config', array('config_data'), array('W' => "`config_name` = 'captcha'"));
        $data = json_array_decode($data['config_data']);
        
        // create missing Data
        if ( in_array ( $data['captcha_font_size'], array ( 1, 2, 3, 4, 5 ) ) ) {
            $data['captcha_font'] = $data['captcha_font_size'];
        } else {
            $data['captcha_font'] = $data['captcha_font_file'];
        }
        unset($data['captcha_font_size'], $data['captcha_font_file']);
        putintopost($data);    
    }

    // security functions
    $_POST['captcha_bg_color'] = '#'.$_POST['captcha_bg_color'];
    $_POST['captcha_text_color'] = '#'.$_POST['captcha_text_color'];
    $_POST = array_map('killhtml', $_POST);
    $_POST['captcha_bg_color'] = substr($_POST['captcha_bg_color'], 1);
    $_POST['captcha_text_color'] = substr($_POST['captcha_text_color'], 1);

    // Display Form
    echo '
                    <form action="" method="post">
                        <input type="hidden" name="go" value="gen_captcha">
                        <input type="hidden" name="sended" value="1">
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="2">'.$FD->text('admin', 'captcha_config_title').'</td></tr>
                            <tr>
                                <td class="config">
                                    '.$FD->text('admin', 'captcha_config_first_title').':<br>
                                    <span class="small">'.$FD->text('admin', 'captcha_config_first_desc').'</span>
                                </td>
                                <td class="config">
                                    '.$FD->text('admin', 'from').' <input class="text center" name="captcha_first_lower" maxlength="3" size="3" value="'.$_POST['captcha_first_lower'].'">
                                    '.$FD->text('admin', 'to').' <input class="text center" name="captcha_first_upper" maxlength="3" size="3" value="'.$_POST['captcha_first_upper'].'"><br>
                                    <span class="small">('.$FD->text('admin', 'with').' x1 <= x2)</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="config right_space">
                                    '.$FD->text('admin', 'captcha_config_second_title').':<br>
                                    <span class="small">'.$FD->text('admin', 'captcha_config_second_desc').'</span>
                                </td>
                                <td class="config">
                                    '.$FD->text('admin', 'from').' <input class="text center" name="captcha_second_lower" maxlength="3" size="3" value="'.$_POST['captcha_second_lower'].'">
                                    '.$FD->text('admin', 'to').' <input class="text center" name="captcha_second_upper" maxlength="3" size="3" value="'.$_POST['captcha_second_upper'].'"><br>
                                    <span class="small">('.$FD->text('admin', 'with').' x1 <= x2)</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="config right_space">
                                    '.$FD->text('admin', 'captcha_config_use_operations_title').':<br>
                                    <span class="small">'.$FD->text('admin', 'captcha_config_use_operations_desc').'</span>
                                </td>
                                <td class="config">
                                    <input class="pointer middle" type="checkbox" name="captcha_use_addition" id="captcha_use_addition" value="1" '.getchecked ( 1, $_POST['captcha_use_addition'] ).'>
                                    <label class="pointer middle" for="captcha_use_addition">'.$FD->text('admin', 'captcha_config_addition').'</label><br>

                                    <input class="pointer middle" type="checkbox" name="captcha_use_subtraction" id="captcha_use_subtraction" value="1" '.getchecked ( 1, $_POST['captcha_use_subtraction'] ).'>
                                    <label class="pointe middle" for="captcha_use_subtraction">'.$FD->text('admin', 'captcha_config_subtraction').'</label><br>

                                    <input class="pointer middle" type="checkbox" name="captcha_use_multiplication" id="captcha_use_multiplication" value="1" '.getchecked ( 1, $_POST['captcha_use_multiplication'] ).'>
                                    <label class="pointer middle" for="captcha_use_multiplication">'.$FD->text('admin', 'captcha_config_multiplication').'</label>
                                </td>
                            </tr>
                            <tr>
                                <td class="config right_space">
                                    '.$FD->text('admin', 'captcha_config_easy_arithmetics_title').':<br>
                                    <span class="small">'.$FD->text('admin', 'captcha_config_easy_arithmetics_desc').'</span>
                                </td>
                                <td class="config">
                                    <input class="pointer" type="checkbox" name="captcha_create_easy_arithmetics" value="1" '.getchecked ( 1, $_POST['captcha_create_easy_arithmetics'] ).'>
                                </td>
                            </tr>

                            <tr><td class="space"></td></tr>
                            <tr><td class="line" colspan="2">'.$FD->text('admin', 'captcha_config_design_title').'</td></tr>
                            <tr>
                                <td class="config right_space">
                                    '.$FD->text('admin', 'captcha_config_bg_color_title').':<br>
                                    <span class="small">'.$FD->text('admin', 'captcha_config_bg_color_desc').'</span>
                                </td>
                                <td class="config">
                                    <table>
                                        <tr valign="bottom">
                                            <td class="config middle">
                                                <input class="pointer middle" type="radio" name="captcha_bg_transparent" id="captcha_bg_transparent"  value="1" '.getchecked ( 1, $_POST['captcha_bg_transparent'] ).'>
                                            </td>
                                            <td class="config middle">
                                                <label class="pointer middle" for="captcha_bg_transparent">'.$FD->text('admin', 'captcha_config_bg_transparent').'</label>
                                            </td>
                                        </tr>
                                        <tr onClick="$(this).find(\'td input#captcha_bg_color\').prop(\'checked\', true);">
                                            <td class="config middle">
                                                <input class="pointer middle" type="radio" name="captcha_bg_transparent" id="captcha_bg_color" value="0" '.getchecked ( 0, $_POST['captcha_bg_transparent'] ).'>
                                            </td>
                                            <td class="config middle">
                                                <div class="colorpickerParent">
                                                    <span class="atleft">#<input class="colorpickerInput" name="captcha_bg_color" maxlength="6" size="6" value="'.$_POST['captcha_bg_color'].'" onFocus ="$(this).parents(\'tr\').find(\'input#captcha_bg_color\').prop(\'checked\', true);"></span>

                                                    <div class="colorpickerSelector atleft"><div style="background-color: #'.$_POST['captcha_bg_color'].';"></div></div>

                                                    <span class="small">('.$FD->text('admin', 'hex_color').')</span>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                    <br>
                                </td>
                            </tr>
                            <tr>
                                <td class="config right_space">
                                    '.$FD->text('admin', 'captcha_config_text_color_title').':<br>
                                    <span class="small">'.$FD->text('admin', 'captcha_config_text_color_desc').'</span>
                                </td>
                                <td class="config">
                                    <div class="colorpickerParent">
                                        <span class="atleft">#<input class="colorpickerInput" name="captcha_text_color" maxlength="6" size="6" value="'.$_POST['captcha_text_color'].'"></span>

                                        <div class="colorpickerSelector atleft"><div style="background-color: #'.$_POST['captcha_text_color'].';"></div></div>

                                        <span class="small">('.$FD->text('admin', 'hex_color').')</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="config right_space">
                                    '.$FD->text('admin', 'captcha_config_dimensions_title').':<br>
                                    <span class="small">'.$FD->text('admin', 'captcha_config_dimensions_desc').'</span>
                                </td>
                                <td class="config">
                                    <input class="text center" name="captcha_x" maxlength="3" size="3" value="'.$_POST['captcha_x'].'"> '.$FD->text('admin', 'resolution_x').'
                                    <input class="text center" name="captcha_y" maxlength="2" size="3" value="'.$_POST['captcha_y'].'"> '.$FD->text('admin', 'pixel').'
                                    <span class="small">('.$FD->text('admin', 'width_x_height').')</span><br>
                                    <span class="small">('.$FD->text('admin', 'zero_not_allowed').')</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="config right_space">
                                    '.$FD->text("admin", "captcha_config_text_position_title").':<br>
                                    <span class="small">'.$FD->text('admin', 'captcha_config_text_position_desc').'</span>
                                </td>
                                <td class="config">
                                    <input class="text center" name="captcha_start_text_x" maxlength="3" size="3" value="'.$_POST['captcha_start_text_x'].'"> '.$FD->text('admin', 'resolution_x').'
                                    <input class="text center" name="captcha_start_text_y" maxlength="2" size="3" value="'.$_POST['captcha_start_text_y'].'"> '.$FD->text('admin', 'pixel').'
                                    <span class="small">('.$FD->text('admin', 'captcha_config_text_position_help').')</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$FD->text('admin', 'captcha_config_text_style_title').':<br>
                                    <span class="small">'.$FD->text('admin', 'captcha_config_text_style_desc').'</span>
                                </td>
                                <td class="config">
                                    <select name="captcha_font" size="1">
                                        <option value="1" '.getselected ( 1, $_POST['captcha_font'] ).'>'.$FD->text('admin', 'captcha_config_text_style_default').' 1</option>
                                        <option value="2" '.getselected ( 2, $_POST['captcha_font'] ).'>'.$FD->text('admin', 'captcha_config_text_style_default').' 2</option>
                                        <option value="3" '.getselected ( 3, $_POST['captcha_font'] ).'>'.$FD->text('admin', 'captcha_config_text_style_default').' 3</option>
                                        <option value="4" '.getselected ( 4, $_POST['captcha_font'] ).'>'.$FD->text('admin', 'captcha_config_text_style_default').' 4</option>
                                        <option value="5" '.getselected ( 5, $_POST['captcha_font'] ).'>'.$FD->text('admin', 'captcha_config_text_style_default').' 5</option>
    ';
    $php_fonts = scandir_ext ( FS2_ROOT_PATH . 'media/php-fonts', 'gdf');
    foreach ( $php_fonts as $php_font ) {
        echo '
                                        <option value="'.$php_font.'" '.getselected ( $php_font, $_POST['captcha_font'] ).'>'.$php_font.'</option>
        ';
    }
    echo '
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config right_space">
                                    '.$FD->text('admin', 'captcha_config_text_options_title').':<br>
                                    <span class="small">'.$FD->text('admin', 'captcha_config_text_options_desc').'</span>
                                </td>
                                <td class="config">
                                    <input class="pointer middle" type="checkbox" name="captcha_show_questionmark" id="captcha_show_questionmark" value="1" '.getchecked ( 1, $_POST['captcha_show_questionmark'] ).'>
                                    <label class="pointer middle" for="captcha_show_questionmark">'.$FD->text('admin', 'captcha_config_questionmark').'</label><br>

                                    <input class="pointer middle" type="checkbox" name="captcha_use_spaces" id="captcha_use_spaces" value="1" '.getchecked ( 1, $_POST['captcha_use_spaces'] ).'>
                                    <label class="pointer middle" for="captcha_use_spaces">'.$FD->text('admin', 'captcha_config_spaces').'</label><br>

                                    <input class="pointer middle" type="checkbox" name="captcha_show_multiplication_as_x" id="captcha_show_multiplication_as_x" value="1" '.getchecked ( 1, $_POST['captcha_show_multiplication_as_x'] ).'>
                                    <label class="pointer middle" for="captcha_show_multiplication_as_x">'.$FD->text('admin', 'captcha_config_multiplication_as_x').'</label>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td colspan="2" class="buttontd">
                                    <button class="button_new" type="submit">
                                        '.$FD->text('admin', 'button_arrow').' '.$FD->text('admin', 'save_changes_button').'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>
