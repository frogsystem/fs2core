<?php if (!defined('ACP_GO')) die('Unauthorized access!');

###################
## Page Settings ##
###################
$used_cols = array('screen_x', 'screen_y', 'screen_thumb_x', 'screen_thumb_y', 'screen_size', 'screen_rows', 'screen_cols', 'screen_order', 'screen_sort', 'show_type', 'show_size_x', 'show_size_y', 'show_img_x', 'show_img_y', 'wp_x', 'wp_y', 'wp_thumb_x', 'wp_thumb_y', 'wp_size', 'wp_rows', 'wp_cols', 'wp_order', 'wp_sort');

/////////////////////////////////////
//// Konfiguration aktualisieren ////
/////////////////////////////////////

if (TRUE
    && isset ($_POST['show_type'])
    && (isset($_POST['show_size_x']) AND $_POST['show_size_x'] != '')
    && (isset($_POST['show_size_y']) AND $_POST['show_size_y'] != '')
    && (isset($_POST['show_img_x']) AND $_POST['show_img_x'] != '')
    && (isset($_POST['show_img_y']) AND $_POST['show_img_y'] != '')

    && (isset($_POST['screen_x']) AND $_POST['screen_x'] != '')
    && (isset($_POST['screen_y']) AND $_POST['screen_y'] != '')
    && (isset($_POST['screen_thumb_x']) AND $_POST['screen_thumb_x'] != '')
    && (isset($_POST['screen_thumb_y']) AND $_POST['screen_thumb_y'] != '')
    && (isset($_POST['screen_size']) AND $_POST['screen_size'] != '')
    && (isset($_POST['screen_rows']) AND $_POST['screen_rows'] != '' AND $_POST['screen_rows'] != '0')
    && (isset($_POST['screen_cols']) AND $_POST['screen_cols'] != '' AND $_POST['screen_cols'] != '0')

    && (isset($_POST['wp_x']) AND $_POST['wp_x'] != '')
    && (isset($_POST['wp_y']) AND $_POST['wp_y'] != '')
    && (isset($_POST['wp_thumb_x']) AND $_POST['wp_thumb_x'] != '')
    && (isset($_POST['wp_thumb_y']) AND $_POST['wp_thumb_y'] != '')
    && (isset($_POST['wp_size']) AND $_POST['wp_size'] != '')
    && (isset($_POST['wp_rows']) AND $_POST['wp_rows'] != '' AND $_POST['wp_rows'] != '0')
    && (isset($_POST['wp_cols']) AND $_POST['wp_cols'] != '' AND $_POST['wp_cols'] != '0')
   )
{
    // prepare data
    $data = frompost($used_cols);
      
    // save config
    try {
        $FD->saveConfig('screens', $data);
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

/////////////////////////////////////
////// Konfiguration Formular ///////
/////////////////////////////////////

if (true) {
    
    // Display Error Messages
    if (isset($_POST['sended'])) {
        systext($FD->text('admin', 'changes_not_saved').'<br>'.$FD->text('admin', 'form_not_filled'), $FD->text('admin', 'error'), 'red', $FD->text('admin', 'icon_save_error'));

    // Load Data from DB into Post
    } else {
        $data = $sql->getRow('config', array('config_data'), array('W' => "`config_name` = 'screens'"));
        $data = json_array_decode($data['config_data']);
        putintopost($data);
    }    
    
    // security functions
    $_POST = array_map('killhtml', $_POST);

    echo'
                    <form action="" method="post">
                        <input type="hidden" value="gallery_config" name="go">
                        <table class="content" cellpadding="0" cellspacing="0">
                            <tr><td colspan="2"><h3>Bildbetrachter</h3><hr></td></tr>
                            <tr>
                                <td class="config" valign="top">
                                    Bildbetrachter &ouml;ffnen:<br>
                                    <font class="small">Die Art, in der der Bildbetrachter angezeigt wird.</font>
                                </td>
                                <td class="config" valign="top">
                                    <select name="show_type">
                                        <option value="0"';
                                        if ($_POST['show_type'] === 0)
                                          echo ' selected="selected"';
                                        echo'>im Fenster (normaler Link)</option>
                                        <option value="1"';
                                        if ($_POST['show_type'] === 1)
                                          echo ' selected="selected"';
                                        echo'>als PopUp-Fenster</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    PopUp-Gr&ouml;&szlig;e:<br>
                                    <font class="small">Die Gr&ouml;&szlig;e des PopUps, falls diese Variante gew&auml;hlt ist.</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="5" name="show_size_x" value="'.$_POST['show_size_x'].'" maxlength="4">
                                    x
                                    <input class="text" size="5" name="show_size_y" value="'.$_POST['show_size_y'].'" maxlength="4"> Pixel
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    max. Bilder-Anzeigegr&ouml;&szlig;e:<br>
                                    <font class="small">Die Gr&ouml;&szlig;e, in der die Bilder im Bilderbetrachter max. angezeigt werden.</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="5" name="show_img_x" value="'.$_POST['show_img_x'].'" maxlength="4">
                                    x
                                    <input class="text" size="5" name="show_img_y" value="'.$_POST['show_img_y'].'" maxlength="4"> Pixel
                                </td>
                            </tr>
                            <tr><td colspan="2"><h3>Bilder</h3><hr></td></tr>
                            <tr>
                                <td class="config" valign="top" width="65%">
                                    max. Abmessungen:<br>
                                    <font class="small">Die max. Abmessungen, bis zu denen Bilder hochgeladen werden k&ouml;nnen.</font>
                                </td>
                                <td class="config" valign="top" width="35%">
                                    <input class="text" size="5" name="screen_x" value="'.$_POST['screen_x'].'" maxlength="4">
                                    x
                                    <input class="text" size="5" name="screen_y" value="'.$_POST['screen_y'].'" maxlength="4"> Pixel
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Vorschaubildergr&ouml;&szlig;e:<br>
                                    <font class="small">Die Gr&ouml;&szlig;e der Bilder-Thumbnails.</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="5" name="screen_thumb_x" value="'.$_POST['screen_thumb_x'].'" maxlength="3">
                                    x
                                    <input class="text" size="5" name="screen_thumb_y" value="'.$_POST['screen_thumb_y'].'" maxlength="3"> Pixel
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    max. Dateigr&ouml;&szlig;e:<br>
                                    <font class="small">Die max. Dateigr&ouml;&szlig;e, bis zu der Bilder hochgeladen werden k&ouml;nnen.</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="12" name="screen_size" value="'.$_POST['screen_size'].'" maxlength="7"> KB
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Anzahl pro Seite:<br>
                                    <font class="small">Die Anzahl der Bildern die auf einer Seite angezeigt werden.</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="1" name="screen_rows" value="'.$_POST['screen_rows'].'" maxlength="2"> Reihen à <input class="text" size="1" name="screen_cols" value="'.$_POST['screen_cols'].'" maxlength="2"> Bilder<br /><font class="small">(0 ist nicht zul&auml;ssig)</font>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Sortieren nach:<br>
                                    <font class="small">Die Reihenfolge, in der die Bilder angezeigt werden.</font>
                                </td>
                                <td class="config" valign="top">
                                    <select name="screen_order">
                                        <option value="id"';
                                        if ($_POST['screen_order'] == 'id')
                                          echo ' selected="selected"';
                                        echo'>Datum</option>
                                        <option value="title"';
                                        if ($_POST['screen_order'] == 'title')
                                          echo ' selected="selected"';
                                        echo'>Title</option>
                                    </select>
                                    <select name="screen_sort">
                                        <option value="asc"';
                                        if ($_POST['screen_sort'] == 'asc')
                                          echo ' selected="selected"';
                                        echo'>aufsteigend</option>
                                        <option value="desc"';
                                        if ($_POST['screen_sort'] == 'desc')
                                          echo ' selected="selected"';
                                        echo'>absteigend</option>
                                    </select>
                                </td>
                            </tr>


                            <tr><td colspan="2"><h3>Wallpaper</h3><hr></td></tr>
                            <tr>
                                <td class="config" valign="top">
                                    max. Abmessungen:<br>
                                    <font class="small">Die max. Abmessungen, bis zu denen Wallpaper hochgeladen werden k&ouml;nnen.</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="5" name="wp_x" value="'.$_POST['wp_x'].'" maxlength="4">
                                    x
                                    <input class="text" size="5" name="wp_y" value="'.$_POST['wp_y'].'" maxlength="4"> Pixel
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Vorschaubildergr&ouml;&szlig;e:<br>
                                    <font class="small">Die Gr&ouml;&szlig;e der Wallpaper-Thumbnails.</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="5" name="wp_thumb_x" value="'.$_POST['wp_thumb_x'].'" maxlength="3">
                                    x
                                    <input class="text" size="5" name="wp_thumb_y" value="'.$_POST['wp_thumb_y'].'" maxlength="3"> Pixel
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    max. Dateigr&ouml;&szlig;e:<br>
                                    <font class="small">Die max. Dateigr&ouml;&szlig;e, bis zu der Wallpaper hochgeladen werden k&ouml;nnen.</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="12" name="wp_size" value="'.$_POST['wp_size'].'" maxlength="7"> KB
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Anzahl pro Seite:<br>
                                    <font class="small">Die Anzahl der Wallpaper die auf einer Seite angezeigt werden.</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="1" name="wp_rows" value="'.$_POST['wp_rows'].'" maxlength="2"> Reihen à <input class="text" size="1" name="wp_cols" value="'.$_POST['wp_cols'].'" maxlength="2"> Wallpaper<br /><font class="small">(0 ist nicht zul&auml;ssig)</font>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Sortieren nach:<br>
                                    <font class="small">Die Reihenfolge, in der Wallpaper angezeigt werden.</font>
                                </td>
                                <td class="config" valign="top">
                                    <select name="wp_order">
                                        <option value="id"';
                                        if ($_POST['wp_order'] == 'id')
                                          echo ' selected="selected"';
                                        echo'>Datum</option>
                                        <option value="title"';
                                        if ($_POST['wp_order'] == 'title')
                                          echo ' selected="selected"';
                                        echo'>Titel</option>
                                    </select>
                                    <select name="wp_sort">
                                        <option value="asc"';
                                        if ($_POST['wp_sort'] == 'asc')
                                          echo ' selected="selected"';
                                        echo'>aufsteigend</option>
                                        <option value="desc"';
                                        if ($_POST['wp_sort'] == 'desc')
                                          echo ' selected="selected"';
                                        echo'>absteigend</option>
                                    </select>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td colspan="2" class="buttontd">
                                    <button type="submit" value="" class="button_new">
                                        '.$FD->text('admin', 'button_arrow').' '.$FD->text('admin', 'save_changes_button').'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>
