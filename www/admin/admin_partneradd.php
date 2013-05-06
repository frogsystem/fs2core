<?php if (!defined('ACP_GO')) die('Unauthorized access!');

//////////////////////////////
/// Config laden /////////////
//////////////////////////////
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


///////////////////////////////
//// Partnerbild hochladen ////
///////////////////////////////
if (isset($_FILES['bild_small']['name']) && $_FILES['bild_small']['name'] != ''
    && isset($_FILES['bild_big']['name']) && $_FILES['bild_big']['name'] != ''
    && (isset($_POST['name']) AND $_POST['name'] != '')
    && (isset($_POST['link']) AND $_POST['link'] != '')
   )
{
    $_POST['permanent'] = isset($_POST['permanent']) ? 1 : 0;

    $stmt = $FD->sql()->conn()->prepare(
                'INSERT INTO '.$FD->config('pref')."partner
                        (partner_name,
                         partner_link,
                         partner_beschreibung,
                         partner_permanent)
                 VALUES (?,
                         ?,
                         ?,
                         '".$_POST['permanent']."')");
    $stmt->execute(array($_POST['name'], $_POST['link'], $_POST['description']));
    $id = $FD->sql()->conn()->lastInsertId();

    $upload1 = upload_img($_FILES['bild_small'], 'images/partner/', $id.'_small', $config_arr['file_size']*1024, $config_arr['small_x'], $config_arr['small_y'], 100, $config_arr['small_allow_bool']);

    switch ($upload1)
    {
      case 0:
        $upload2 = upload_img($_FILES['bild_big'], 'images/partner/', $id.'_big', $config_arr['file_size']*1024, $config_arr['big_x'], $config_arr['big_y'], 100, $config_arr['big_allow_bool']);

        switch ($upload2)
        {
        case 0:
          systext ($FD->text('page', 'note_added') .'<br />'.
                   $FD->text('page', 'note_uploaded').'<br />'.
                   $FD->text('page', 'note_addmore'));

          unset($_POST['bild_small']);
          unset($_POST['bild_big']);
          unset($_POST['name']);
          unset($_POST['link']);
          unset($_POST['description']);
          unset($_POST['permanent']);

          break;
        default:
          systext ($FD->text('page', 'big_pic'). ': ' . upload_img_notice($upload2));
          systext ($FD->text('page', 'note_notadded'));
          $FD->sql()->conn()->exec('DELETE FROM '.$FD->config('pref')."partner WHERE partner_id = '$id'");
          image_delete('images/partner/', $id.'_small');
          image_delete('images/partner/', $id.'_big');
        }

        break;
      default:
        systext ($FD->text('page', 'small_pic') . ': ' . upload_img_notice($upload1));
        systext ($FD->text('page', 'note_notadded'));
        $FD->sql()->conn()->exec('DELETE FROM '.$FD->config(pref)."partner WHERE partner_id = '$id'");
        image_delete('images/partner/', $id.'_small');
        image_delete('images/partner/', $id.'_big');
    }

}


//////////////////////////
//// Error Message    ////
//////////////////////////
elseif (isset($_POST['sended'])) {
    echo get_systext($FD->text('admin', 'changes_not_saved').'<br>'.$FD->text('admin', 'form_not_filled'), $FD->text('admin', 'error'), 'red', $FD->text('admin', 'icon_save_error'));

    $_POST['name'] = killhtml($_POST['name']);
    $_POST['link'] = killhtml($_POST['link']);
    $_POST['description'] = killhtml($_POST['description']);
    $_POST['permanent'] = isset($_POST['permanent']) ? ' checked="checked"' : '';
}

if (!isset($_POST['name'])) $_POST['name'] = '';
if (!isset($_POST['description'])) $_POST['description'] = '';
if (!isset($_POST['permanent'])) $_POST['permanent'] = '';

//////////////////////////
//// Partner Formular ////
//////////////////////////
echo'
                    <form action="" enctype="multipart/form-data" method="post">
                        <input type="hidden" value="partner_add" name="go">
                        <input type="hidden" value="1" name="sended">
                        <table class="content" cellpadding="3" cellspacing="0">
                            <tr><td colspan="2"><h3>'.$FD->text('page', 'add').'</h3><hr></td></tr>
                            <tr>
                                <td class="config" valign="top">
                                    '.$FD->text('page', 'small_pic').':<br />
                                    <font class="small">'.$FD->text('page', 'small_pic_desc').'</font>
                                </td>
                                <td class="config" valign="top">
                                    <input type="file" class="text" name="bild_small" size="50"><br />
                                    <font class="small">
                                      ['.$config_arr['small_allow_text'].' '.$config_arr['small_x'].' x '.$config_arr['small_y'].' '.$FD->text('page', 'px').'] [max. '.$config_arr['file_size'].' '.$FD->text('page', 'kb').']
                                    </font>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    '.$FD->text('page', 'big_pic').':<br />
                                    <font class="small">'.$FD->text('page', 'big_pic_desc').'</font>
                                </td>
                                <td class="config" valign="top">
                                    <input type="file" class="text" name="bild_big" size="50"><br />
                                    <font class="small">
                                      ['.$config_arr['big_allow_text'].' '.$config_arr['big_x'].' x '.$config_arr['big_y'].' '.$FD->text('page', 'px').'] [max. '.$config_arr['file_size'].' '.$FD->text('page', 'kb').']
                                    </font>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    '.$FD->text('page', 'name').':<br />
                                    <font class="small">'.$FD->text('page', 'name_desc').'</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" name="name" value="'.$_POST['name'].'" size="50" maxlength="100">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    '.$FD->text('page', 'link').':<br />
                                    <font class="small">'.$FD->text('page', 'link_desc').'</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" name="link" size="50" value="http://" maxlength="100">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    '.$FD->text('page', 'desc').': <font class="small">'.$FD->text('admin', 'optional').'</font><br />
                                    <font class="small">'.$FD->text('page', 'desc_desc').'</font>
                                </td>
                                <td class="config" valign="top">
                                    '.create_editor('description', $_POST['description'], 330, 130).'
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    '.$FD->text('page', 'perm').':<br />
                                    <font class="small">'.$FD->text('page', 'perm_desc').'</font>
                                </td>
                                <td class="config" valign="top">
                                    <input type="checkbox" value="1" name="permanent" '.$_POST['permanent'].'>
                                </td>
                            </tr>

                            <tr>
                                <td align="left" colspan="2">
                                    <input class="button" type="submit" value="'.$FD->text('page', 'add').'">
                                </td>
                            </tr>
                        </table>
                    </form>
';
?>
