<?php
//////////////////////////////
/// Config laden /////////////
//////////////////////////////
$index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."partner_config", $db);
$config_arr = mysql_fetch_assoc($index);
if ($config_arr[small_allow] == 0) {
    $config_arr[small_allow_bool] = true;
    $config_arr[small_allow_text] = $admin_phrases[partner][exact];
} else {
    $config_arr[small_allow_bool] = false;
    $config_arr[small_allow_text] = $admin_phrases[partner][max];
}
if ($config_arr[big_allow] == 0) {
    $config_arr[big_allow_bool] = true;
    $config_arr[big_allow_text] = $admin_phrases[partner][exact];
} else {
    $config_arr[big_allow_bool] = false;
    $config_arr[big_allow_text] = $admin_phrases[partner][max];
}


///////////////////////////////
//// Partnerbild hochladen ////
///////////////////////////////
if ($_FILES['bild_small']['name'] != ""
    && $_FILES['bild_big']['name'] != ""
    && ($_POST['name'] AND $_POST['name'] != "")
    && ($_POST['link'] AND $_POST['link'] != "")
   )
{
    $_POST[name] = savesql($_POST[name]);
    $_POST[link] = savesql($_POST[link]);
    $_POST[description] = savesql($_POST[description]);
    $_POST[permanent] = isset($_POST[permanent]) ? 1 : 0;
    
    mysql_query("INSERT INTO ".$global_config_arr[pref]."partner
                        (partner_name,
                         partner_link,
                         partner_beschreibung,
                         partner_permanent)
                 VALUES ('".$_POST[name]."',
                         '".$_POST[link]."',
                         '".$_POST[description]."',
                         '".$_POST[permanent]."')", $db);
    $id = mysql_insert_id();

    $upload1 = upload_img($_FILES['bild_small'], "images/partner/", $id."_small", $config_arr[file_size]*1024, $config_arr[small_x], $config_arr[small_y], 100, $config_arr[small_allow_bool]);
    
    switch ($upload1)
    {
      case 0:
        $upload2 = upload_img($_FILES['bild_big'], "images/partner/", $id."_big", $config_arr[file_size]*1024, $config_arr[big_x], $config_arr[big_y], 100, $config_arr[big_allow_bool]);

        switch ($upload2)
        {
        case 0:
          systext ($admin_phrases[partner][note_added] ."<br />".
                   $admin_phrases[partner][note_uploaded]."<br />".
                   $admin_phrases[partner][note_addmore]);

          unset($_POST['bild_small']);
          unset($_POST['bild_big']);
          unset($_POST['name']);
          unset($_POST['link']);
          unset($_POST['description']);
          unset($_POST['permanent']);

          break;
        default:
          systext ($admin_phrases[partner][big_pic]. ": " . upload_img_notice($upload2));
          systext ($admin_phrases[partner][note_notadded]);
          mysql_query("DELETE FROM ".$global_config_arr[pref]."partner WHERE partner_id = '$id'");
          image_delete("images/partner/", $id."_small");
          image_delete("images/partner/", $id."_big");
        }
    
        break;
      default:
        systext ($admin_phrases[partner][small_pic] . ": " . upload_img_notice($upload1));
        systext ($admin_phrases[partner][note_notadded]);
        mysql_query("DELETE FROM ".$global_config_arr[pref]."partner WHERE partner_id = '$id'");
        image_delete("images/partner/", $id."_small");
        image_delete("images/partner/", $id."_big");
    }
    
}


//////////////////////////
//// Error Message    ////
//////////////////////////
elseif ($_POST['sended']) {
    systext ($admin_phrases[common][note_notfilled]);
    
    $_POST['name'] = killhtml($_POST['name']);
    $_POST['link'] = killhtml($_POST['link']);
    $_POST['description'] = killhtml($_POST['description']);
    $_POST['permanent'] = isset($_POST['permanent']) ? ' checked="checked"' : '';
}


//////////////////////////
//// Partner Formular ////
//////////////////////////
echo'
                    <form action="" enctype="multipart/form-data" method="post">
                        <input type="hidden" value="partner_add" name="go">
                        <input type="hidden" value="1" name="sended">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top">
                                    '.$admin_phrases[partner][small_pic].':<br />
                                    <font class="small">'.$admin_phrases[partner][small_pic_desc].'</font>
                                </td>
                                <td class="config" valign="top">
                                    <input type="file" class="text" name="bild_small" size="50"><br />
                                    <font class="small">
                                      ['.$config_arr[small_allow_text].' '.$config_arr[small_x].' x '.$config_arr[small_y].' '.$admin_phrases[partner][px].'] [max. '.$config_arr[file_size].' '.$admin_phrases[partner][kb].']
                                    </font>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    '.$admin_phrases[partner][big_pic].':<br />
                                    <font class="small">'.$admin_phrases[partner][big_pic_desc].'</font>
                                </td>
                                <td class="config" valign="top">
                                    <input type="file" class="text" name="bild_big" size="50"><br />
                                    <font class="small">
                                      ['.$config_arr[big_allow_text].' '.$config_arr[big_x].' x '.$config_arr[big_y].' '.$admin_phrases[partner][px].'] [max. '.$config_arr[file_size].' '.$admin_phrases[partner][kb].']
                                    </font>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    '.$admin_phrases[partner][name].':<br />
                                    <font class="small">'.$admin_phrases[partner][name_desc].'</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" name="name" value="'.$_POST['name'].'" size="50" maxlength="100">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    '.$admin_phrases[partner][link].':<br />
                                    <font class="small">'.$admin_phrases[partner][link_desc].'</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" name="link" size="50" value="http://" maxlength="100">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    '.$admin_phrases[partner][desc].': <font class="small">'.$admin_phrases[common][optional].'</font><br />
                                    <font class="small">'.$admin_phrases[partner][desc_desc].'</font>
                                </td>
                                <td class="config" valign="top">
                                    '.create_editor("description", $_POST['description'], 330, 130).'
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    '.$admin_phrases[partner][perm].':<br />
                                    <font class="small">'.$admin_phrases[partner][perm_desc].'</font>
                                </td>
                                <td class="config" valign="top">
                                    <input type="checkbox" value="1" name="permanent" '.$_POST[permanent].'>
                                </td>
                            </tr>
                            <tr><td></td></tr>
                            <tr>
                                <td></td>
                                <td align="left">
                                    <input class="button" type="submit" value="'.$admin_phrases[partner][add].'">
                                </td>
                            </tr>
                        </table>
                    </form>
';
?>