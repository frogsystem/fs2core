<?php if (!defined('ACP_GO')) die('Unauthorized access!');

///////////////////
/// Load Config ///
///////////////////
$FD->loadConfig('affiliates');
$config_arr = $FD->configObject('affiliates')->getConfigArray();

if ($config_arr['small_allow'] == 0) {
    $config_arr['small_allow_bool'] = true;
    $config_arr['small_allow_text'] = $FD->text('page', 'exact');
} else {
    $config_arr['small_allow_bool'] = false;
    $config_arr['small_allow_text'] = $FD->text('page', 'max');
}
if ($config_arr['big_allow'] == 0) {
    $config_arr['big_allow_bool'] = true;
    $config_arr['big_allow_text'] = $FD->text('page', 'exact');
} else {
    $config_arr['big_allow_bool'] = false;
    $config_arr['big_allow_text'] = $FD->text('page', 'max');
}


////////////////////////////
/// Edit affiliated site ///
////////////////////////////
if ((isset($_POST['name']) AND $_POST['name'] != '')
    && (isset($_POST['link']) AND $_POST['link'] != '')
    && $_POST['partner_action'] == 'edit'
    && $_POST['sended'] == 'edit'
    && isset($_POST['partner_id'])
   )
{
    $message = '';

    settype($_POST['partner_id'], 'integer');
    $_POST['permanent'] = isset($_POST['permanent']) ? 1 : 0;

    $stmt = $FD->db()->conn()->prepare(
              'UPDATE '.$FD->env('DB_PREFIX')."partner
               SET partner_name = ?,
                   partner_link = ?,
                   partner_beschreibung = ?,
                   partner_permanent = '$_POST[permanent]'
               WHERE partner_id = '$_POST[partner_id]'");
    $stmt->execute(array($_POST['name'], $_POST['link'], $_POST['description']));

    if ($_FILES['bild_small']['name'] != '')
    {
      $upload = upload_img($_FILES['bild_small'], 'images/partner/', $_POST['partner_id'].'_small', $config_arr['file_size']*1024, $config_arr['small_x'], $config_arr['small_y'], 100, $config_arr['small_allow_bool']);
      $message .= $FD->text('page', 'small_pic') . ': ' . upload_img_notice($upload) . '<br />';
    }

    if ($_FILES['bild_big']['name'] != '')
    {
      $upload = upload_img($_FILES['bild_big'], 'images/partner/', $_POST['partner_id'].'_big', $config_arr['file_size']*1024, $config_arr['big_x'], $config_arr['big_y'], 100, $config_arr['big_allow_bool']);
      $message .= $FD->text('page', 'big_pic') . ': ' . upload_img_notice($upload) . '<br />';
    }

    $message .= $FD->text('page', 'note_edited');
    systext($message);

    unset($message);
    unset($_POST['partner_action']);
    unset($_POST['sended']);
    unset($_POST['partner_id']);
}


////////////////////////////////
/// Delete affiliated site /////
////////////////////////////////
elseif (isset($_POST['partner_action'])
    && $_POST['partner_action'] == 'delete'
    && isset($_POST['sended'])
    && $_POST['sended'] == 'delete'
    && isset($_POST['partner_id'])
   )
{
    settype($_POST['partner_id'], 'integer');

    if ($_POST['delete_partner'])   // Delete affiliated site
    {
        $FD->db()->conn()->exec('DELETE FROM '.$FD->env('DB_PREFIX')."partner WHERE partner_id = '$_POST[partner_id]'");
        image_delete('images/partner/', $_POST['partner_id'].'_small');
        image_delete('images/partner/', $_POST['partner_id'].'_big');
        systext($FD->text('page', 'note_deleted'));
    }
    else
    {
        systext($FD->text('page', 'note_notdeleted'));
    }

    unset($_POST['delete_partner']);
    unset($_POST['partner_action']);
    unset($_POST['sended']);
    unset($_POST['partner_id']);
}


/////////////////////////////
/// Show affiliated site ////
/////////////////////////////
elseif (isset($_POST['partner_action'])
        && $_POST['partner_action'] == 'edit'
        && isset($_POST['partner_id'])
       )
{
    $_POST['partner_id'] = $_POST['partner_id'][0];
    settype($_POST['partner_id'], 'integer');

    $index = $FD->db()->conn()->query('SELECT * FROM '.$FD->env('DB_PREFIX')."partner WHERE partner_id = $_POST[partner_id]");
    $partner_arr = $index->fetch(PDO::FETCH_ASSOC);

    $partner_arr['partner_name'] = killhtml($partner_arr['partner_name']);
    $partner_arr['partner_link'] = killhtml($partner_arr['partner_link']);
    $partner_arr['partner_beschreibung'] = killhtml($partner_arr['partner_beschreibung']);
    $partner_arr['partner_perm'] = ($partner_arr['partner_permanent'] == 1) ? ' checked="checked"' : '';


    //Error Message
    if ( isset($_POST['sended']) && $_POST['sended'] == 'edit') {
        systext ($FD->text('admin', 'note_notfilled'));

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
                            <tr><td colspan="2"><h3>'.$FD->text("page", "delpage").'</h3><hr></td></tr>
                            <tr>
                                <td class="config" valign="top">
                                    '.$FD->text("page", "small_pic").':<br />
                                    <font class="small">'.$FD->text("page", "small_pic_desc").'</font>
                                </td>
                                <td class="config" valign="top">
                                    '.get_image_output('images/partner/', $_POST['partner_id'].'_small', "", '<span class="small">['.$FD->text("admin", "error").': '.$FD->text("admin", "image_not_found").']</span>', false).'
                                   <br /><br />
                                   <input type="file" class="text" name="bild_small" size="50"><br />
                                   <font class="small">
                                     ['.$config_arr['small_allow_text'].' '.$config_arr['small_x'].' x '.$config_arr['small_y'].' '.$FD->text("page", "px").'] [max. '.$config_arr['file_size'].' '.$FD->text("page", "kb").']
                                    </font><br />
                                    <font class="small">
                                      <b>'.$FD->text("admin", "replace_img").'</b>
                                    </font>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    '.$FD->text("page", "big_pic").':<br />
                                    <font class="small">'.$FD->text("page", "big_pic_desc").'</font>
                                </td>
                                <td class="config" valign="top">
                                    '.get_image_output('images/partner/', $_POST['partner_id'].'_big', "", '<span class="small">['.$FD->text("admin", "error").': '.$FD->text("admin", "image_not_found").']</span>', false).'
                                   <br /><br />
                                   <input type="file" class="text" name="bild_big" size="50"><br />
                                   <font class="small">
                                     ['.$config_arr['big_allow_text'].' '.$config_arr['big_x'].' x '.$config_arr['big_y'].' '.$FD->text("page", "px").'] [max. '.$config_arr['file_size'].' '.$FD->text("page", "kb").']
                                   </font><br />
                                    <font class="small">
                                      <b>'.$FD->text("admin", "replace_img").'</b>
                                    </font>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    '.$FD->text("page", "name").':<br />
                                    <font class="small">'.$FD->text("page", "name_desc").'</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" name="name" size="33" value="'.$partner_arr['partner_name'].'" maxlength="100">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    '.$FD->text("page", "link").':<br />
                                    <font class="small">'.$FD->text("page", "link_desc").'</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" name="link" size="50" value="'.$partner_arr['partner_link'].'" maxlength="100">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    '.$FD->text("page", "desc").': <font class="small">'.$FD->text("admin", "optional").'</font><br />
                                    <font class="small">'.$FD->text("page", "desc_desc").'</font>
                                </td>
                                <td class="config" valign="top">
                                    '.create_editor('description', $partner_arr['partner_beschreibung'], 330, 130).'
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    '.$FD->text("page", "perm").':<br />
                                    <font class="small">'.$FD->text("page", "perm_desc").'</font>
                                </td>
                                <td class="config" valign="top">
                                    <input type="checkbox" value="1" name="permanent" '.$partner_arr['partner_perm'].'>
                                </td>
                            </tr>
                            <tr><td></td></tr>
                            <tr>
                                <td align="left" colspan="2">
                                    <input class="button" type="submit" value="'.$FD->text("page", "save").'">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}

////////////////////////////////
/// Delete affiliated site /////
////////////////////////////////
elseif (isset($_POST['partner_action'])
        && $_POST['partner_action'] == 'delete'
        && isset($_POST['partner_id'])
       )
{
    $_POST['partner_id'] = $_POST['partner_id'][0];
    settype($_POST['partner_id'], 'integer');

    $index = $FD->db()->conn()->query('SELECT * FROM '.$FD->env('DB_PREFIX')."partner WHERE partner_id = $_POST[partner_id]");
    $partner_arr = $index->fetch(PDO::FETCH_ASSOC);

    $partner_arr['partner_name'] = killhtml($partner_arr['partner_name']);
    $partner_arr['partner_link'] = killhtml($partner_arr['partner_link']);

    echo'
                    <form action="" method="post">
                        <input type="hidden" value="partner_edit" name="go">
                        <input type="hidden" value="delete" name="partner_action">
                        <input type="hidden" value="delete" name="sended">
                        <input type="hidden" value="'.$partner_arr['partner_id'].'" name="partner_id">
                        <table class="content" cellpadding="3" cellspacing="0">
                            <tr><td colspan="2"><h3>'.$FD->text('page', 'delpage').'</h3><hr></td></tr>
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
                                    '.$FD->text('page', 'delpage_question').'
                                </td>
                                <td width="50%" align="right">
                                    <select name="delete_partner" size="1">
                                        <option value="0">'.$FD->text('page', 'delnotconfirm').'</option>
                                        <option value="1">'.$FD->text('page', 'delconfirm').'</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input type="submit" value="'.$FD->text('admin', 'do_button').'" class="button">
                                </td>
                            </tr>
                        </table>
                    </form>';
}


//////////////////////////////
/// Select affiliated site ///
//////////////////////////////
if (!isset($_POST['partner_id']))
{
    $config_arr['small_x_width'] = $config_arr['small_x'] + 20;

    $index = $FD->db()->conn()->query('SELECT COUNT(*) FROM '.$FD->env('DB_PREFIX').'partner');

    if ($index->fetchColumn() > 0)
    {
        $index = $FD->db()->conn()->query('SELECT * FROM '.$FD->env('DB_PREFIX').'partner ORDER BY partner_name');
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
                                    '.$FD->text('page', 'partnerpage').'
                                </td>
                                <td class="config" style="text-align:right;">
                                    '.$FD->text('admin', 'selection').'
                                </td>
                            </tr>
        ';

        while ($partner_arr = $index->fetch(PDO::FETCH_ASSOC))
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
                                     <option class="select_one" value="edit">'.$FD->text('admin', 'selection_edit').'</option>
                                     <option class="select_red" value="delete">'.$FD->text('admin', 'selection_delete').'</option>
                                   </select>
                                   <input class="button" type="submit" value="'.$FD->text('admin', 'do_action_button').'">
                                </td>
                            </tr>
                        </table>
                    </form>
        ';
    }
    else
    {
        echo $FD->text('page', 'note_nopages');
    }
}
?>
