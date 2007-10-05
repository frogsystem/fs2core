<?php

/////////////////////////////////////
//// Konfiguration aktualisieren ////
/////////////////////////////////////

if ($_POST[smilies_rows] && $_POST[smilies_rows]>0 AND $_POST[smilies_cols] && $_POST[smilies_cols]>0
 AND $_POST[textarea_width] && $_POST[textarea_width]>0  AND $_POST[textarea_height] && $_POST[textarea_height]>0)
{
    settype($_POST[smilies_rows], 'integer');
    settype($_POST[smilies_cols], 'integer');
    settype($_POST[textarea_width], 'integer');
    settype($_POST[textarea_height], 'integer');
    
    $update = "UPDATE ".$global_config_arr[pref]."editor_config
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
                   list = '$_POST[numlist]',
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
    mysql_query($update, $db);
    systext("Die Konfiguration wurde aktualisiert");
}

/////////////////////////////////////
////// Konfiguration Formular ///////
/////////////////////////////////////

else
{
    $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."editor_config", $db);
    $config_arr = mysql_fetch_assoc($index);
    echo'
                    <form action="" method="post">
                        <input type="hidden" value="editorconfig" name="go">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top" width="50%">
                                    Öffentliche Buttons:<br>
                                    <font class="small">Buttons, die im öffentlichen Teil angezeigt werden.</font>
                                </td>
                                <td class="config" valign="top" width="50%">

                                    <table cellpadding="0" cellspacing="0">
                                      <tr>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="'.$global_config_arr[virtualhost].'images/icons/bold.gif" alt="" title="fett">
    </div></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="'.$global_config_arr[virtualhost].'images/icons/italic.gif" alt="" title="kursiv">
    </div></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="'.$global_config_arr[virtualhost].'images/icons/underline.gif" alt="" title="unterstrichen">
    </div></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="'.$global_config_arr[virtualhost].'images/icons/strike.gif" alt="" title="durchgestrichen">
    </div></td>
    <td class="editor_td_seperator"></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="'.$global_config_arr[virtualhost].'images/icons/center.gif" alt="" title="zentriert">
    </div></td>
    <td class="editor_td_seperator"></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="'.$global_config_arr[virtualhost].'images/icons/font.gif" alt="" title="Schriftart">
    </div></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="'.$global_config_arr[virtualhost].'images/icons/color.gif" alt="" title="Schriftfarbe">
    </div></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="'.$global_config_arr[virtualhost].'images/icons/size.gif" alt="" title="Schriftgröße">
    </div></td>
                                      </tr>
                                      <tr>
    <td><input type="checkbox" name="bold" value="1"';
    if ($config_arr[bold] == 1)
      echo " checked=checked";
    echo'/></td>
    <td><input type="checkbox" name="italic" value="1"';
    if ($config_arr[italic] == 1)
      echo " checked=checked";
    echo'/></td>
    <td><input type="checkbox" name="underline" value="1"';
    if ($config_arr[underline] == 1)
      echo " checked=checked";
    echo'/></td>
    <td><input type="checkbox" name="strike" value="1"';
    if ($config_arr[strike] == 1)
      echo " checked=checked";
    echo'/></td>
    
    <td></td>
    
    <td><input type="checkbox" name="center" value="1"';
    if ($config_arr[center] == 1)
      echo " checked=checked";
    echo'/></td>
    
    <td></td>
    
    <td><input type="checkbox" name="font" value="1"';
    if ($config_arr[font] == 1)
      echo " checked=checked";
    echo'/></td>
    <td><input type="checkbox" name="color" value="1"';
    if ($config_arr[color] == 1)
      echo " checked=checked";
    echo'/></td>
        <td><input type="checkbox" name="size" value="1"';
    if ($config_arr[size] == 1)
      echo " checked=checked";
    echo'/></td>
                                      </tr>
                                    </table>

                                    <table cellpadding="0" cellspacing="0" style="padding-top:5px;">
                                      <tr>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="'.$global_config_arr[virtualhost].'images/icons/img.gif" alt="" title="Bild">
    </div></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="'.$global_config_arr[virtualhost].'images/icons/cimg.gif" alt="" title="Content-Image">
    </div></td>
    <td class="editor_td_seperator"></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="'.$global_config_arr[virtualhost].'images/icons/url.gif" alt="" title="Link">
    </div></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="'.$global_config_arr[virtualhost].'images/icons/home.gif" alt="" title="Home-Link">
    </div></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="'.$global_config_arr[virtualhost].'images/icons/email.gif" alt="" title="Email">
    </div></td>
    <td class="editor_td_seperator"></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="'.$global_config_arr[virtualhost].'images/icons/code.gif" alt="" title="Code">
    </div></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="'.$global_config_arr[virtualhost].'images/icons/quote.gif" alt="" title="Zitat">
    </div></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="'.$global_config_arr[virtualhost].'images/icons/noparse.gif" alt="" title="Noparse-Bereich">
    </div></td>
    <td class="editor_td_seperator"></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="'.$global_config_arr[virtualhost].'images/icons/smilie.gif" alt="" title="Smilies">
    </div></td>
                                      </tr>
                                      <tr>
    <td><input type="checkbox" name="img" value="1"';
    if ($config_arr[img] == 1)
      echo " checked=checked";
    echo'/></td>
    <td><input type="checkbox" name="cimg" value="1"';
    if ($config_arr[cimg] == 1)
      echo " checked=checked";
    echo'/></td>

    <td></td>

    <td><input type="checkbox" name="url" value="1"';
    if ($config_arr[url] == 1)
      echo " checked=checked";
    echo'/></td>
    <td><input type="checkbox" name="home" value="1"';
    if ($config_arr[home] == 1)
      echo " checked=checked";
    echo'/></td>
    <td><input type="checkbox" name="email" value="1"';
    if ($config_arr[email] == 1)
      echo " checked=checked";
    echo'/></td>
    
    <td></td>

    <td><input type="checkbox" name="code" value="1"';
    if ($config_arr[code] == 1)
      echo " checked=checked";
    echo'/></td>
    <td><input type="checkbox" name="quote" value="1"';
    if ($config_arr[quote] == 1)
      echo " checked=checked";
    echo'/></td>
        <td><input type="checkbox" name="noparse" value="1"';
    if ($config_arr[noparse] == 1)
      echo " checked=checked";
    echo'/></td>
    
    <td></td>

    <td><input type="checkbox" name="smilies" value="1"';
    if ($config_arr[smilies] == 1)
      echo " checked=checked";
    echo'/></td>
                                      </tr>
                                    </table>

                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top" width="50%">
                                    Textfeld Ausmaße: <font class="small">(Breite x Höhe)</font><br>
                                    <font class="small">Welche Größe soll das Textfeld haben?</font>
                                </td>
                                <td class="config" valign="top" width="50%">
                                    <input class="text" size="2" name="textarea_width" value="'.$config_arr[textarea_width].'" maxlength="3"> x <input class="text" size="2" name="textarea_height" value="'.$config_arr[textarea_height].'" maxlength="3"> Pixel<br /><font class="small">(0 ist nicht zulässig)</font>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top" width="50%">
                                    Smilies:<br>
                                    <font class="small">Wie viele Smilies werden im Editor angezeigt?</font>
                                </td>
                                <td class="config" valign="top" width="50%">
                                    <input class="text" size="1" name="smilies_rows" value="'.$config_arr[smilies_rows].'" maxlength="2"> Reihen à <input class="text" size="1" name="smilies_cols" value="'.$config_arr[smilies_cols].'" maxlength="2"> Smilies<br /><font class="small">(0 ist nicht zulässig)</font>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top" width="50%">
                                    Von Usern verwendbare FS-Codes:<br>
                                    <font class="small">FS-Codes, die von Usern verwendet werden können.<br />
                                    <b>Nicht gewählte FS-Codes werden in von Usern erstellten Beiträgen (z.B. Kommentaren) nicht umgewandelt!</b></font>
                                </td>
                                <td class="config" valign="top" width="50%">

                                    <table cellpadding="0" cellspacing="0">
                                      <tr>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="'.$global_config_arr[virtualhost].'images/icons/bold.gif" alt="" title="[b]text[/b]">
    </div></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="'.$global_config_arr[virtualhost].'images/icons/italic.gif" alt="" title="[i]text[/i]">
    </div></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="'.$global_config_arr[virtualhost].'images/icons/underline.gif" alt="" title="[u]text[/u]">
    </div></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="'.$global_config_arr[virtualhost].'images/icons/strike.gif" alt="" title="[s]text[/s]">
    </div></td>
    <td class="editor_td_seperator"></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="'.$global_config_arr[virtualhost].'images/icons/center.gif" alt="" title="[center]text[/center]">
    </div></td>
    <td class="editor_td_seperator"></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="'.$global_config_arr[virtualhost].'images/icons/font.gif" alt="" title="[font=xzy]text[/font]">
    </div></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="'.$global_config_arr[virtualhost].'images/icons/color.gif" alt="" title="[color=xzy]text[/font]">
    </div></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="'.$global_config_arr[virtualhost].'images/icons/size.gif" alt="" title="[size=xzy]text[/font]">
    </div></td>
    <td class="editor_td_seperator"></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="'.$global_config_arr[virtualhost].'images/icons/list.gif" alt="" title="[list][*]text1[*]text2[/list]">
    </div></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="'.$global_config_arr[virtualhost].'images/icons/numlist.gif" alt="" title="[numlist][*]text1[*]text2[/numlist]">
    </div></td>
                                      </tr>
                                      <tr>
    <td><input type="checkbox" name="do_bold" value="1"';
    if ($config_arr[do_bold] == 1)
      echo " checked=checked";
    echo'/></td>
    <td><input type="checkbox" name="do_italic" value="1"';
    if ($config_arr[do_italic] == 1)
      echo " checked=checked";
    echo'/></td>
    <td><input type="checkbox" name="do_underline" value="1"';
    if ($config_arr[do_underline] == 1)
      echo " checked=checked";
    echo'/></td>
    <td><input type="checkbox" name="do_strike" value="1"';
    if ($config_arr[do_strike] == 1)
      echo " checked=checked";
    echo'/></td>

    <td></td>

    <td><input type="checkbox" name="do_center" value="1"';
    if ($config_arr[do_center] == 1)
      echo " checked=checked";
    echo'/></td>

    <td></td>

    <td><input type="checkbox" name="do_font" value="1"';
    if ($config_arr[do_font] == 1)
      echo " checked=checked";
    echo'/></td>
    <td><input type="checkbox" name="do_color" value="1"';
    if ($config_arr[do_color] == 1)
      echo " checked=checked";
    echo'/></td>
        <td><input type="checkbox" name="do_size" value="1"';
    if ($config_arr[do_size] == 1)
      echo " checked=checked";
    echo'/></td>
    
    <td></td>
    
    <td><input type="checkbox" name="do_list" value="1"';
    if ($config_arr[do_list] == 1)
      echo " checked=checked";
    echo'/></td>
    <td><input type="checkbox" name="do_numlist" value="1"';
    if ($config_arr[do_numlist] == 1)
      echo " checked=checked";
    echo'/></td>
    
                                      </tr>
                                    </table>

                                    <table cellpadding="0" cellspacing="0" style="padding-top:5px;">
                                      <tr>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="'.$global_config_arr[virtualhost].'images/icons/img.gif" alt="" title="[img]Img-URL[/img]">
    </div></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="'.$global_config_arr[virtualhost].'images/icons/cimg.gif" alt="" title="[cimg]CImg-Name[/cimg]">
    </div></td>
    <td class="editor_td_seperator"></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="'.$global_config_arr[virtualhost].'images/icons/url.gif" alt="" title="[url=Link-URL]text[/url]">
    </div></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="'.$global_config_arr[virtualhost].'images/icons/home.gif" alt="" title="[url=Homelink]text[/url]">
    </div></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="'.$global_config_arr[virtualhost].'images/icons/email.gif" alt="" title="[email=e@mail.de]text[/email]">
    </div></td>
    <td class="editor_td_seperator"></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="'.$global_config_arr[virtualhost].'images/icons/code.gif" alt="" title="[code]text[/code]">
    </div></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="'.$global_config_arr[virtualhost].'images/icons/quote.gif" alt="" title="[quote]text[/quote]">
    </div></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="'.$global_config_arr[virtualhost].'images/icons/noparse.gif" alt="" title="[noparse]text[/noparse]">
    </div></td>
    <td class="editor_td_seperator"></td>
    <td class="editor_td"><div class="editor_button" style="cursor:default;">
      <img src="'.$global_config_arr[virtualhost].'images/icons/smilie.gif" alt="" title=":-), ;-), :-p, etc.">
    </div></td>
                                      </tr>
                                      <tr>
    <td><input type="checkbox" name="do_img" value="1"';
    if ($config_arr[do_img] == 1)
      echo " checked=checked";
    echo'/></td>
    <td><input type="checkbox" name="do_cimg" value="1"';
    if ($config_arr[do_cimg] == 1)
      echo " checked=checked";
    echo'/></td>

    <td></td>

    <td><input type="checkbox" name="do_url" value="1"';
    if ($config_arr[do_url] == 1)
      echo " checked=checked";
    echo'/></td>
    <td><input type="checkbox" name="do_home" value="1"';
    if ($config_arr[do_home] == 1)
      echo " checked=checked";
    echo'/></td>
    <td><input type="checkbox" name="do_email" value="1"';
    if ($config_arr[do_email] == 1)
      echo " checked=checked";
    echo'/></td>

    <td></td>

    <td><input type="checkbox" name="do_code" value="1"';
    if ($config_arr[do_code] == 1)
      echo " checked=checked";
    echo'/></td>
    <td><input type="checkbox" name="do_quote" value="1"';
    if ($config_arr[do_quote] == 1)
      echo " checked=checked";
    echo'/></td>
        <td><input type="checkbox" name="do_noparse" value="1"';
    if ($config_arr[do_noparse] == 1)
      echo " checked=checked";
    echo'/></td>

    <td></td>

    <td><input type="checkbox" name="do_smilies" value="1"';
    if ($config_arr[do_smilies] == 1)
      echo " checked=checked";
    echo'/></td>
                                      </tr>
                                    </table>

                                </td>
                            </tr>
                            <tr>
                                <td align="center" colspan="2">
                                    <input class="button" type="submit" value="Absenden">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>