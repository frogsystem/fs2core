<?php
//////////////////////////////
/// Config laden /////////////
//////////////////////////////
$index = mysql_query('SELECT * FROM '.$global_config_arr['pref'].'partner_config', $FD->sql()->conn() );
$config_arr = mysql_fetch_assoc($index);
if ($config_arr['small_allow'] == 0) {
    $config_arr['small_allow_bool'] = true;
    $config_arr['small_allow_text'] = $admin_phrases['partner']['exact'];
} else {
    $config_arr['small_allow_bool'] = false;
    $config_arr['small_allow_text'] = $admin_phrases['partner']['max'];
}
if ($config_arr['big_allow'] == 0) {
    $config_arr['big_allow_bool'] = true;
    $config_arr['big_allow_text'] = $admin_phrases['partner']['exact'];
} else {
    $config_arr['big_allow_bool'] = false;
    $config_arr['big_allow_text'] = $admin_phrases['partner']['max'];
}


//////////////////////////////
/// Partnerseite editieren ///
//////////////////////////////
if (($_POST['name'] AND $_POST['name'] != '')
    && ($_POST['link'] AND $_POST['link'] != '')
    && $_POST['partner_action'] == 'edit'
    && $_POST['sended'] == 'edit'
    && isset($_POST['partner_id'])
   )
{
    unset($message);

    $_POST['name'] = savesql($_POST['name']);
    $_POST['link'] = savesql($_POST['link']);
    $_POST['description'] = savesql($_POST['description']);
    settype($_POST['partner_id'], 'integer');
    $_POST['permanent'] = isset($_POST['permanent']) ? 1 : 0;

    $update = 'UPDATE '.$global_config_arr['pref']."partner
               SET partner_name = '$_POST[name]',
                   partner_link = '$_POST[link]',
                   partner_beschreibung = '$_POST[description]',
                   partner_permanent = '$_POST[permanent]'
               WHERE partner_id = '$_POST[partner_id]'";
    mysql_query($update, $FD->sql()->conn() );

    if ($_FILES['bild_small']['name'] != '')
    {
      $upload = upload_img($_FILES['bild_small'], 'images/partner/', $_POST['partner_id'].'_small', $config_arr['file_size']*1024, $config_arr['small_x'], $config_arr['small_y'], 100, $config_arr['small_allow_bool']);
      $message .= $admin_phrases['partner']['small_pic'] . ': ' . upload_img_notice($upload) . '<br />';
    }

    if ($_FILES['bild_big']['name'] != '')
    {
      $upload = upload_img($_FILES['bild_big'], 'images/partner/', $_POST['partner_id'].'_big', $config_arr['file_size']*1024, $config_arr['big_x'], $config_arr['big_y'], 100, $config_arr['big_allow_bool']);
      $message .= $admin_phrases['partner']['big_pic'] . ': ' . upload_img_notice($upload) . '<br />';
    }

    $message .= $admin_phrases['partner']['note_edited'];
    systext($message);

    unset($message);
    unset($_POST['partner_action']);
    unset($_POST['sended']);
    unset($_POST['partner_id']);
}


//////////////////////////////
/// Partnerseite löschen /////
//////////////////////////////
elseif ($_POST['partner_action'] == 'delete'
    && $_POST['sended'] == 'delete'
    && isset($_POST['partner_id'])
   )
{
    settype($_POST['partner_id'], 'integer');

    if ($_POST['delete_partner'])   // Partnerseite löschen
    {
        mysql_query('DELETE FROM '.$global_config_arr['pref']."partner WHERE partner_id = '$_POST[partner_id]'", $FD->sql()->conn() );
        image_delete('images/partner/', $_POST['partner_id'].'_small');
        image_delete('images/partner/', $_POST['partner_id'].'_big');
        systext($admin_phrases['partner']['note_deleted']);
    }
    else
    {
        systext($admin_phrases['partner']['note_notdeleted']);
    }

    unset($_POST['delete_partner']);
    unset($_POST['partner_action']);
    unset($_POST['sended']);
    unset($_POST['partner_id']);
}


//////////////////////////////
/// Partnerseite anzeigen ////
//////////////////////////////
elseif ($_POST['partner_action'] == 'edit'
        && isset($_POST['partner_id'])
       )
{
    $_POST['partner_id'] = $_POST['partner_id'][0];
    settype($_POST['partner_id'], 'integer');

    $index = mysql_query('SELECT * FROM '.$global_config_arr['pref']."partner WHERE partner_id = $_POST[partner_id]", $FD->sql()->conn() );
    $partner_arr = mysql_fetch_assoc($index);

    $partner_arr['partner_name'] = killhtml($partner_arr['partner_name']);
    $partner_arr['partner_link'] = killhtml($partner_arr['partner_link']);
    $partner_arr['partner_beschreibung'] = killhtml($partner_arr['partner_beschreibung']);
    $partner_arr['partner_perm'] = ($partner_arr['partner_permanent'] == 1) ? ' checked="checked"' : '';


    //Error Message
    if ($_POST['sended'] == 'edit') {
        systext ($admin_phrases['common']['note_notfilled']);

        $partner_arr['partner_name'] = killhtml($_POST['name']);
        $partner_arr['partner_link'] = killhtml($_POST['link']);
        $partner_arr['partner_beschreibung'] = killhtml($_POST['description']);
        $partner_arr['partner_perm'] = isset($_POST['permanent']) ? ' checked="checked"' : '';
    }

    echo'
                    <form action="" enctype="multipart/form-data" method="post">
                        <input type="hidden" value="partner_edit" name="go">
                        <input type="hidden" value="edit" name="partner_action">
                        <input type="hidden" value="edit" name="sended">
                        <input type="hidden" value="'.$partner_arr['partner_id'].'" name="partner_id">
                        <table class="content" cellpadding="3" cellspacing="0">
                            <tr><td colspan="2"><h3>'.$admin_phrases['partner']['delpage'].'</h3><hr></td></tr>
                            <tr>
                                <td class="config" valign="top">
                                    '.$admin_phrases['partner']['small_pic'].':<br />
                                    <font class="small">'.$admin_phrases['partner']['small_pic_desc'].'</font>
                                </td>
                                <td class="config" valign="top">
                                   <img src="'.image_url('images/partner/', $_POST['partner_id'].'_small').'">
                                   <br /><br />
                                   <input type="file" class="text" name="bild_small" size="50"><br />
                                   <font class="small">
                                     ['.$config_arr['small_allow_text'].' '.$config_arr['small_x'].' x '.$config_arr['small_y'].' '.$admin_phrases['partner']['px'].'] [max. '.$config_arr['file_size'].' '.$admin_phrases['partner']['kb'].']
                                    </font><br />
                                    <font class="small">
                                      <b>'.$admin_phrases['common']['replace_img'].'</b>
                                    </font>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    '.$admin_phrases['partner']['big_pic'].':<br />
                                    <font class="small">'.$admin_phrases['partner']['big_pic_desc'].'</font>
                                </td>
                                <td class="config" valign="top">
                                   <img src="'.image_url('images/partner/', $_POST['partner_id'].'_big').'">
                                   <br /><br />
                                   <input type="file" class="text" name="bild_big" size="50"><br />
                                   <font class="small">
                                     ['.$config_arr['big_allow_text'].' '.$config_arr['big_x'].' x '.$config_arr['big_y'].' '.$admin_phrases['partner']['px'].'] [max. '.$config_arr['file_size'].' '.$admin_phrases['partner']['kb'].']
                                   </font><br />
                                    <font class="small">
                                      <b>'.$admin_phrases['common']['replace_img'].'</b>
                                    </font>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    '.$admin_phrases['partner']['name'].':<br />
                                    <font class="small">'.$admin_phrases['partner']['name_desc'].'</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" name="name" size="33" value="'.$partner_arr['partner_name'].'" maxlength="100">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    '.$admin_phrases['partner']['link'].':<br />
                                    <font class="small">'.$admin_phrases['partner']['link_desc'].'</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" name="link" size="50" value="'.$partner_arr['partner_link'].'" maxlength="100">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    '.$admin_phrases['partner']['desc'].': <font class="small">'.$admin_phrases['common']['optional'].'</font><br />
                                    <font class="small">'.$admin_phrases['partner']['desc_desc'].'</font>
                                </td>
                                <td class="config" valign="top">
                                    '.create_editor('description', $partner_arr['partner_beschreibung'], 330, 130).'
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    '.$admin_phrases['partner']['perm'].':<br />
                                    <font class="small">'.$admin_phrases['partner']['perm_desc'].'</font>
                                </td>
                                <td class="config" valign="top">
                                    <input type="checkbox" value="1" name="permanent" '.$partner_arr['partner_perm'].'>
                                </td>
                            </tr>
                            <tr><td></td></tr>
                            <tr>
                                <td align="left" colspan="2">
                                    <input class="button" type="submit" value="'.$admin_phrases['partner']['save'].'">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}

//////////////////////////////
/// Partnerseite löschen /////
//////////////////////////////
elseif ($_POST['partner_action'] == 'delete'
        && isset($_POST['partner_id'])
       )
{
    $_POST['partner_id'] = $_POST['partner_id'][0];
    settype($_POST['partner_id'], 'integer');

    $index = mysql_query('SELECT * FROM '.$global_config_arr['pref']."partner WHERE partner_id = $_POST[partner_id]", $FD->sql()->conn() );
    $partner_arr = mysql_fetch_assoc($index);

    $partner_arr['partner_name'] = killhtml($partner_arr['partner_name']);
    $partner_arr['partner_link'] = killhtml($partner_arr['partner_link']);

    echo'
                    <form action="" method="post">
                        <input type="hidden" value="partner_edit" name="go">
                        <input type="hidden" value="delete" name="partner_action">
                        <input type="hidden" value="delete" name="sended">
                        <input type="hidden" value="'.$partner_arr['partner_id'].'" name="partner_id">
                        <table class="content" cellpadding="3" cellspacing="0">
                            <tr><td colspan="2"><h3>'.$admin_phrases['partner']['delpage'].'</h3><hr></td></tr>
                            <tr align="left" valign="top">
                                <td class="config" colspan="2">
                                    '.$partner_arr['partner_name'].'
                                    <span class="small">('.$partner_arr['partner_link'].')</span>
                                </td>
                            </tr>
                            <tr align="left" valign="top">
                                <td class="config" colspan="2">
                                    <img src="'.image_url('images/partner/', $partner_arr['partner_id'].'_big').'">
                                    <br /><br />
                                </td>
                            </tr>
                            <tr valign="top">
                                <td width="50%" class="config">
                                    '.$admin_phrases['partner']['delpage_question'].'
                                </td>
                                <td width="50%" align="right">
                                    <select name="delete_partner" size="1">
                                        <option value="0">'.$admin_phrases['partner']['delnotconfirm'].'</option>
                                        <option value="1">'.$admin_phrases['partner']['delconfirm'].'</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input type="submit" value="'.$admin_phrases['common']['do_button'].'" class="button">
                                </td>
                            </tr>
                        </table>
                    </form>';
}


//////////////////////////////
/// Partnerseite auswählen ///
//////////////////////////////
if (!isset($_POST['partner_id']))
{
    $config_arr['small_x_width'] = $config_arr['small_x'] + 20;

    $index = mysql_query('SELECT * FROM '.$global_config_arr['pref'].'partner ORDER BY partner_name', $FD->sql()->conn() );

    if (mysql_num_rows($index) > 0)
    {
        echo'
                    <form action="" method="post">
                        <input type="hidden" value="partner_edit" name="go">
                        <table class="content select_list" cellpadding="3" cellspacing="0">
                            <tr><td colspan="3"><h3>Partnerseite ausw&auml;hlen</h3><hr></td></tr>
                            <tr>
                                <td class="config" width="'.$config_arr['small_x_width'].'">
                                    Bild
                                </td>
                                <td class="config">
                                    '.$admin_phrases['partner']['partnerpage'].'
                                </td>
                                <td class="config" style="text-align:right;">
                                    '.$admin_phrases['common']['selection'].'
                                </td>
                            </tr>
        ';

        while ($partner_arr = mysql_fetch_assoc($index))
        {
            echo'
                            <tr class="select_entry thin">
                                <td class="configthin" height="'.$config_arr['small_y'].'">
                                    <img src="'.image_url('images/partner/',$partner_arr['partner_id'].'_small').'" alt="" />
                                </td>
                                <td class="configthin">
                                    '.$partner_arr['partner_name'].'
                                </td>
                                <td class="configthin" style="text-align:right;">
                                    <input class="select_box" type="checkbox" name="partner_id[]"  value="'.$partner_arr['partner_id'].'">
                                </td>
                            </tr>
            ';
        }
        echo'
                            <tr><td>&nbsp;</td></tr>
                            <tr>
                                <td class="right" colspan="4">
                                   <select class="select_type" name="partner_action" size="1">
                                     <option class="select_one" value="edit">'.$admin_phrases['common']['selection_edit'].'</option>
                                     <option class="select_red" value="delete">'.$admin_phrases['common']['selection_del'].'</option>
                                   </select>
                                   <input class="button" type="submit" value="'.$admin_phrases['common']['do_button'].'">
                                </td>
                            </tr>
                        </table>
                    </form>
        ';
    }
    else
    {
        echo $admin_phrases['partner']['note_nopages'];
    }
}
?>
