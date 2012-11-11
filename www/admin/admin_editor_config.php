<?php if (!defined('ACP_GO')) die('Unauthorized access!"');

/////////////////////////////////////
//// Konfiguration aktualisieren ////
/////////////////////////////////////

if (isset($_POST['smilies_rows']) && $_POST['smilies_rows']>0 && isset($_POST['smilies_cols']) && $_POST['smilies_cols']>0
 AND isset($_POST['textarea_width']) && $_POST['textarea_width']>0 && isset($_POST['textarea_height']) && $_POST['textarea_height']>0)
{
    settype($_POST['smilies_rows'], 'integer');
    settype($_POST['smilies_cols'], 'integer');
    settype($_POST['textarea_width'], 'integer');
    settype($_POST['textarea_height'], 'integer');
    $_POST['bold'] = intval($_POST['bold']);
    $_POST['italic'] = intval($_POST['italic']);
    $_POST['underline'] = intval($_POST['underline']);
    $_POST['strike'] = intval($_POST['strike']);
    $_POST['center'] = intval($_POST['center']);
    $_POST['font'] = intval($_POST['font']);
    $_POST['color'] = intval($_POST['color']);
    $_POST['size'] = intval($_POST['size']);
    $_POST['list'] = intval($_POST['list']);
    $_POST['numlist'] = intval($_POST['numlist']);
    $_POST['img'] = intval($_POST['img']);
    $_POST['cimg'] = intval($_POST['cimg']);
    $_POST['url'] = intval($_POST['url']);
    $_POST['home'] = intval($_POST['home']);
    $_POST['email'] = intval($_POST['email']);
    $_POST['code'] = intval($_POST['code']);
    $_POST['quote'] = intval($_POST['quote']);
    $_POST['noparse'] = intval($_POST['noparse']);
    $_POST['smilies'] = intval($_POST['smilies']);
    $_POST['do_bold'] = intval($_POST['do_bold']);
    $_POST['do_italic'] = intval($_POST['do_italic']);
    $_POST['do_underline'] = intval($_POST['do_underline']);
    $_POST['do_strike'] = intval($_POST['do_strike']);
    $_POST['do_center'] = intval($_POST['do_center']);
    $_POST['do_font'] = intval($_POST['do_font']);
    $_POST['do_color'] = intval($_POST['do_color']);
    $_POST['do_size'] = intval($_POST['do_size']);
    $_POST['do_list'] = intval($_POST['do_list']);
    $_POST['do_numlist'] = intval($_POST['do_numlist']);
    $_POST['do_img'] = intval($_POST['do_img']);
    $_POST['do_cimg'] = intval($_POST['do_cimg']);
    $_POST['do_url'] = intval($_POST['do_url']);
    $_POST['do_home'] = intval($_POST['do_home']);
    $_POST['do_email'] = intval($_POST['do_email']);
    $_POST['do_code'] = intval($_POST['do_code']);
    $_POST['do_quote'] = intval($_POST['do_quote']);
    $_POST['do_noparse'] = intval($_POST['do_noparse']);
    $_POST['do_smilies'] = intval($_POST['do_smilies']);

    $update = 'UPDATE '.$FD->config('pref')."editor_config
               SET smilies_rows = '$_POST[smilies_rows]',
                   smilies_cols = '$_POST[smilies_cols]',
                   textarea_width = '$_POST[textarea_width]',
                   textarea_height = '$_POST[textarea_height]',
                   bold = '$_POST[bold]',
                   italic = '$_POST[italic]',
                   underline = '$_POST[underline]',
                   strike = '$_POST[strike]',
                   center = '$_POST[center]',
                   font = '$_POST[font]',
                   color = '$_POST[color]',
                   size = '$_POST[size]',
                   list = '$_POST[list]',
                   numlist = '$_POST[numlist]',
                   img = '$_POST[img]',
                   cimg = '$_POST[cimg]',
                   url = '$_POST[url]',
                   home = '$_POST[home]',
                   email = '$_POST[email]',
                   code = '$_POST[code]',
                   quote = '$_POST[quote]',
                   noparse = '$_POST[noparse]',
                   smilies = '$_POST[smilies]',
                   do_bold = '$_POST[do_bold]',
                   do_italic = '$_POST[do_italic]',
                   do_underline = '$_POST[do_underline]',
                   do_strike = '$_POST[do_strike]',
                   do_center = '$_POST[do_center]',
                   do_font = '$_POST[do_font]',
                   do_color = '$_POST[do_color]',
                   do_size = '$_POST[do_size]',
                   do_list = '$_POST[do_list]',
                   do_numlist = '$_POST[do_numlist]',
                   do_img = '$_POST[do_img]',
                   do_cimg = '$_POST[do_cimg]',
                   do_url = '$_POST[do_url]',
                   do_home = '$_POST[do_home]',
                   do_email = '$_POST[do_email]',
                   do_code = '$_POST[do_code]',
                   do_quote = '$_POST[do_quote]',
                   do_noparse = '$_POST[do_noparse]',
                   do_smilies = '$_POST[do_smilies]'
               WHERE id = 1";
    mysql_query($update, $FD->sql()->conn() );

    systext($FD->text('page', 'changes_saved'), $FD->text('page', 'info'));
}

/////////////////////////////////////
////// Konfiguration Formular ///////
/////////////////////////////////////

else
{
    $index = mysql_query('SELECT * FROM '.$FD->config('pref').'editor_config', $FD->sql()->conn() );
    $config_arr = mysql_fetch_assoc($index);

    if (isset($_POST['sended']))
    {
        $config_arr['smilies_rows'] = $_POST['smilies_rows'];
        $config_arr['smilies_cols'] = $_POST['smilies_cols'];
        $config_arr['textarea_width'] = $_POST['textarea_width'];
        $config_arr['textarea_height'] = $_POST['textarea_height'];
        $config_arr['bold'] = $_POST['bold'];
        $config_arr['italic'] = $_POST['italic'];
        $config_arr['underline'] = $_POST['underline'];
        $config_arr['strike'] = $_POST['strike'];
        $config_arr['center'] = $_POST['center'];
        $config_arr['font'] = $_POST['font'];
        $config_arr['color'] = $_POST['color'];
        $config_arr['size'] = $_POST['size'];
        $config_arr['list'] = $_POST['numlist'];
        $config_arr['numlist'] = $_POST['numlist'];
        $config_arr['img'] = $_POST['img'];
        $config_arr['cimg'] = $_POST['cimg'];
        $config_arr['url'] = $_POST['url'];
        $config_arr['home'] = $_POST['home'];
        $config_arr['email'] = $_POST['email'];
        $config_arr['code'] = $_POST['code'];
        $config_arr['quote'] = $_POST['quote'];
        $config_arr['noparse'] = $_POST['noparse'];
        $config_arr['smilies'] = $_POST['smilies'];
        $config_arr['do_bold'] = $_POST['do_bold'];
        $config_arr['do_italic'] = $_POST['do_italic'];
        $config_arr['do_underline'] = $_POST['do_underline'];
        $config_arr['do_strike'] = $_POST['do_strike'];
        $config_arr['do_center'] = $_POST['do_center'];
        $config_arr['do_font'] = $_POST['do_font'];
        $config_arr['do_color'] = $_POST['do_color'];
        $config_arr['do_size'] = $_POST['do_size'];
        $config_arr['do_list'] = $_POST['do_list'];
        $config_arr['do_numlist'] = $_POST['do_numlist'];
        $config_arr['do_img'] = $_POST['do_img'];
        $config_arr['do_cimg'] = $_POST['do_cimg'];
        $config_arr['do_url'] = $_POST['do_url'];
        $config_arr['do_home'] = $_POST['do_home'];
        $config_arr['do_email'] = $_POST['do_email'];
        $config_arr['do_code'] = $_POST['do_code'];
        $config_arr['do_quote'] = $_POST['do_quote'];
        $config_arr['do_noparse'] = $_POST['do_noparse'];
        $config_arr['do_smilies'] = $_POST['do_smilies'];

        systext($FD->text('page', 'note_notfilled').'<br />'.$FD->text('page', 'only_allowed_values'), $FD->text('page', 'error'), TRUE);
    }

    $config_arr['smilies_rows'] = killhtml ( $config_arr['smilies_rows'] );
    $config_arr['smilies_cols'] = killhtml ( $config_arr['smilies_cols'] );
    $config_arr['textarea_width'] = killhtml ( $config_arr['textarea_width'] );
    $config_arr['textarea_height'] = killhtml ( $config_arr['textarea_height'] );

    echo'
                    <form action="" method="post">
                        <input type="hidden" value="editor_config" name="go">
                        <input type="hidden" name="sended" value="1">
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="2">'.$FD->text('page', 'view_settings_title').'</td></tr>
                            <tr>
                                <td class="config" valign="top" width="50%">
                                    '.$FD->text('page', 'textarea_size').': <span class="small">('.$FD->text('page', 'width_x_height').')</span><br>
                                    <span class="small">'.$FD->text('page', 'textarea_size_desc').'</span>
                                </td>
                                <td class="config" valign="top" width="50%">
                                    <input class="text" size="2" name="textarea_width" value="'.$config_arr['textarea_width'].'" maxlength="3"> '.$FD->text('page', 'resolution_x').' <input class="text" size="2" name="textarea_height" value="'.$config_arr['textarea_height'].'" maxlength="3"> '.$FD->text('page', 'pixel').'<br>
                                    <span class="small">('.$FD->text('page', 'zero_not_allowed').')</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top" width="50%">
                                    '.$FD->text('page', 'smilies').':<br>
                                    <span class="small">'.$FD->text('page', 'smilies_desc').'</span>
                                </td>
                                <td class="config" valign="top" width="50%">
                                    <input class="text" size="1" name="smilies_rows" value="'.$config_arr['smilies_rows'].'" maxlength="2"> '.$FD->text('page', 'smilies_rows').' <input class="text" size="1" name="smilies_cols" value="'.$config_arr['smilies_cols'].'" maxlength="2"> '.$FD->text('page', 'smilies_smilies').'<br>
                                    <span class="small">('.$FD->text('page', 'zero_not_allowed').')</span>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr><td class="line" colspan="2">'.$FD->text('page', 'buttons_settings_title').'</td></tr>
                            <tr>
                                <td class="config">
                                    '.$FD->text('page', 'buttons').':<br>
                                    <span class="small">'.$FD->text('page', 'buttons_desc').'</span>
                                </td>
                                <td class="config">

                                    <table cellpadding="0" cellspacing="0">
                                      <tr>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="icons/editor/bold.gif" alt="" title="'.$FD->text('fscode', 'b').'">
    </div></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="icons/editor/italic.gif" alt="" title="'.$FD->text('fscode', 'i').'">
    </div></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="icons/editor/underline.gif" alt="" title="'.$FD->text('fscode', 'u').'">
    </div></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="icons/editor/strike.gif" alt="" title="'.$FD->text('fscode', 's').'">
    </div></td>
    <td class="editor_td_seperator"></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="icons/editor/center.gif" alt="" title="'.$FD->text('fscode', 'center').'">
    </div></td>
    <td class="editor_td_seperator"></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="icons/editor/font.gif" alt="" title="'.$FD->text('fscode', 'font').'">
    </div></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="icons/editor/color.gif" alt="" title="'.$FD->text('fscode', 'color').'">
    </div></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="icons/editor/size.gif" alt="" title="'.$FD->text('fscode', 'size').'">
    </div></td>
                                      </tr>
                                      <tr>
    <td><input type="checkbox" name="bold" value="1"';
    if ($config_arr['bold'] == 1)
      echo ' checked=checked';
    echo'/></td>
    <td><input type="checkbox" name="italic" value="1"';
    if ($config_arr['italic'] == 1)
      echo ' checked=checked';
    echo'/></td>
    <td><input type="checkbox" name="underline" value="1"';
    if ($config_arr['underline'] == 1)
      echo ' checked=checked';
    echo'/></td>
    <td><input type="checkbox" name="strike" value="1"';
    if ($config_arr['strike'] == 1)
      echo ' checked=checked';
    echo'/></td>

    <td></td>

    <td><input type="checkbox" name="center" value="1"';
    if ($config_arr['center'] == 1)
      echo ' checked=checked';
    echo'/></td>

    <td></td>

    <td><input type="checkbox" name="font" value="1"';
    if ($config_arr['font'] == 1)
      echo ' checked=checked';
    echo'/></td>
    <td><input type="checkbox" name="color" value="1"';
    if ($config_arr['color'] == 1)
      echo ' checked=checked';
    echo'/></td>
        <td><input type="checkbox" name="size" value="1"';
    if ($config_arr['size'] == 1)
      echo ' checked=checked';
    echo'/></td>
                                      </tr>
                                    </table>

                                    <table cellpadding="0" cellspacing="0" style="padding-top:5px;">
                                      <tr>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="icons/editor/img.gif" alt="" title="'.$FD->text('fscode', 'img').'">
    </div></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="icons/editor/cimg.gif" alt="" title="'.$FD->text('fscode', 'cimg').'">
    </div></td>
    <td class="editor_td_seperator"></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="icons/editor/url.gif" alt="" title="'.$FD->text('fscode', 'url').'">
    </div></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="icons/editor/home.gif" alt="" title="'.$FD->text('fscode', 'home').'">
    </div></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="icons/editor/email.gif" alt="" title="'.$FD->text('fscode', 'email').'">
    </div></td>
    <td class="editor_td_seperator"></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="icons/editor/code.gif" alt="" title="'.$FD->text('fscode', 'code').'">
    </div></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="icons/editor/quote.gif" alt="" title="'.$FD->text('fscode', 'quote').'">
    </div></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="icons/editor/noparse.gif" alt="" title="'.$FD->text('fscode', 'noparse').'">
    </div></td>
    <td class="editor_td_seperator"></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="icons/editor/smilie.gif" alt="" title="'.$FD->text('fscode', 'smilies').'">
    </div></td>
                                      </tr>
                                      <tr>
    <td><input type="checkbox" name="img" value="1"';
    if ($config_arr['img'] == 1)
      echo ' checked=checked';
    echo'/></td>
    <td><input type="checkbox" name="cimg" value="1"';
    if ($config_arr['cimg'] == 1)
      echo ' checked=checked';
    echo'/></td>

    <td></td>

    <td><input type="checkbox" name="url" value="1"';
    if ($config_arr['url'] == 1)
      echo ' checked=checked';
    echo'/></td>
    <td><input type="checkbox" name="home" value="1"';
    if ($config_arr['home'] == 1)
      echo ' checked=checked';
    echo'/></td>
    <td><input type="checkbox" name="email" value="1"';
    if ($config_arr['email'] == 1)
      echo ' checked=checked';
    echo'/></td>

    <td></td>

    <td><input type="checkbox" name="code" value="1"';
    if ($config_arr['code'] == 1)
      echo ' checked=checked';
    echo'/></td>
    <td><input type="checkbox" name="quote" value="1"';
    if ($config_arr['quote'] == 1)
      echo ' checked=checked';
    echo'/></td>
        <td><input type="checkbox" name="noparse" value="1"';
    if ($config_arr['noparse'] == 1)
      echo ' checked=checked';
    echo'/></td>

    <td></td>

    <td><input type="checkbox" name="smilies" value="1"';
    if ($config_arr['smilies'] == 1)
      echo ' checked=checked';
    echo'/></td>
                                      </tr>
                                    </table>

                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr><td class="line" colspan="2">'.$FD->text('page', 'fscode_settings_title').'</td></tr>
                            <tr>
                                <td class="config" valign="top" width="50%">
                                    '.$FD->text('page', 'fscode').':<br>
                                    <span class="small">'.$FD->text('page', 'fscode_desc').'</span>
                                    <br /><br />
                                    <span class="small"><b>'.$FD->text('page', 'fscode_info').'</b></span>
                                </td>
                                <td class="config" valign="top" width="50%">

                                    <table cellpadding="0" cellspacing="0">
                                      <tr>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="icons/editor/bold.gif" alt="" title="'.$FD->text('fscode', 'example_b').'">
    </div></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="icons/editor/italic.gif" alt="" title="'.$FD->text('fscode', 'example_i').'">
    </div></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="icons/editor/underline.gif" alt="" title="'.$FD->text('fscode', 'example_u').'">
    </div></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="icons/editor/strike.gif" alt="" title="'.$FD->text('fscode', 'example_s').'">
    </div></td>
    <td class="editor_td_seperator"></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="icons/editor/center.gif" alt="" title="'.$FD->text('fscode', 'example_center').'">
    </div></td>
    <td class="editor_td_seperator"></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="icons/editor/font.gif" alt="" title="'.$FD->text('fscode', 'example_font').'">
    </div></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="icons/editor/color.gif" alt="" title="'.$FD->text('fscode', 'example_color').'">
    </div></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="icons/editor/size.gif" alt="" title="'.$FD->text('fscode', 'example_size').'">
    </div></td>
    <td class="editor_td_seperator"></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="icons/editor/list.gif" alt="" title="'.$FD->text('fscode', 'example_list').'">
    </div></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="icons/editor/numlist.gif" alt="" title="'.$FD->text('fscode', 'example_numlist').'">
    </div></td>
                                      </tr>
                                      <tr>
    <td><input type="checkbox" name="do_bold" value="1"';
    if ($config_arr['do_bold'] == 1)
      echo ' checked=checked';
    echo'/></td>
    <td><input type="checkbox" name="do_italic" value="1"';
    if ($config_arr['do_italic'] == 1)
      echo ' checked=checked';
    echo'/></td>
    <td><input type="checkbox" name="do_underline" value="1"';
    if ($config_arr['do_underline'] == 1)
      echo ' checked=checked';
    echo'/></td>
    <td><input type="checkbox" name="do_strike" value="1"';
    if ($config_arr['do_strike'] == 1)
      echo ' checked=checked';
    echo'/></td>

    <td></td>

    <td><input type="checkbox" name="do_center" value="1"';
    if ($config_arr['do_center'] == 1)
      echo ' checked=checked';
    echo'/></td>

    <td></td>

    <td><input type="checkbox" name="do_font" value="1"';
    if ($config_arr['do_font'] == 1)
      echo ' checked=checked';
    echo'/></td>
    <td><input type="checkbox" name="do_color" value="1"';
    if ($config_arr['do_color'] == 1)
      echo ' checked=checked';
    echo'/></td>
        <td><input type="checkbox" name="do_size" value="1"';
    if ($config_arr['do_size'] == 1)
      echo ' checked=checked';
    echo'/></td>

    <td></td>

    <td><input type="checkbox" name="do_list" value="1"';
    if ($config_arr['do_list'] == 1)
      echo ' checked=checked';
    echo'/></td>
    <td><input type="checkbox" name="do_numlist" value="1"';
    if ($config_arr['do_numlist'] == 1)
      echo ' checked=checked';
    echo'/></td>

                                      </tr>
                                    </table>

                                    <table cellpadding="0" cellspacing="0" style="padding-top:5px;">
                                      <tr>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="icons/editor/img.gif" alt="" title="'.$FD->text('fscode', 'example_img').'">
    </div></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="icons/editor/cimg.gif" alt="" title="'.$FD->text('fscode', 'example_cimg').'">
    </div></td>
    <td class="editor_td_seperator"></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="icons/editor/url.gif" alt="" title="'.$FD->text('fscode', 'example_url').'">
    </div></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="icons/editor/home.gif" alt="" title="'.$FD->text('fscode', 'example_home').'">
    </div></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="icons/editor/email.gif" alt="" title="'.$FD->text('fscode', 'example_email').'">
    </div></td>
    <td class="editor_td_seperator"></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="icons/editor/code.gif" alt="" title="'.$FD->text('fscode', 'example_code').'">
    </div></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="icons/editor/quote.gif" alt="" title="'.$FD->text('fscode', 'example_quote').'">
    </div></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="icons/editor/noparse.gif" alt="" title="'.$FD->text('fscode', 'example_noparse').'">
    </div></td>
    <td class="editor_td_seperator"></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="icons/editor/smilie.gif" alt="" title="'.$FD->text('fscode', 'example_smilies').'">
    </div></td>
                                      </tr>
                                      <tr>
    <td><input type="checkbox" name="do_img" value="1"';
    if ($config_arr['do_img'] == 1)
      echo ' checked=checked';
    echo'/></td>
    <td><input type="checkbox" name="do_cimg" value="1"';
    if ($config_arr['do_cimg'] == 1)
      echo ' checked=checked';
    echo'/></td>

    <td></td>

    <td><input type="checkbox" name="do_url" value="1"';
    if ($config_arr['do_url'] == 1)
      echo ' checked=checked';
    echo'/></td>
    <td><input type="checkbox" name="do_home" value="1"';
    if ($config_arr['do_home'] == 1)
      echo ' checked=checked';
    echo'/></td>
    <td><input type="checkbox" name="do_email" value="1"';
    if ($config_arr['do_email'] == 1)
      echo ' checked=checked';
    echo'/></td>

    <td></td>

    <td><input type="checkbox" name="do_code" value="1"';
    if ($config_arr['do_code'] == 1)
      echo ' checked=checked';
    echo'/></td>
    <td><input type="checkbox" name="do_quote" value="1"';
    if ($config_arr['do_quote'] == 1)
      echo ' checked=checked';
    echo'/></td>
        <td><input type="checkbox" name="do_noparse" value="1"';
    if ($config_arr['do_noparse'] == 1)
      echo ' checked=checked';
    echo'/></td>

    <td></td>

    <td><input type="checkbox" name="do_smilies" value="1"';
    if ($config_arr['do_smilies'] == 1)
      echo ' checked=checked';
    echo'/></td>
                                      </tr>
                                    </table>

                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="buttontd" colspan="2">
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
