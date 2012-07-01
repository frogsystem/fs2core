<?php if (!defined('ACP_GO')) die('Unauthorized access!');

////////////////////
//// New Smilie ////
////////////////////

if ($_FILES['newsmilie']['name'] != '' AND isset($_POST['replace_string']))
{
    $_POST['replace_string'] = savesql(killhtml($_POST['replace_string']));
    settype($_POST['insert_after'], 'integer');

    mysql_query('UPDATE '.$FD->config('pref')."smilies
                 SET `order`=`order`+1
                 WHERE `order`>$_POST[insert_after]", $FD->sql()->conn() );
    mysql_query('INSERT INTO '.$FD->config('pref')."smilies
                 (replace_string, `order`)
                 VALUES ('$_POST[replace_string]', '$_POST[insert_after]'+1)", $FD->sql()->conn() );

    $id = mysql_insert_id();
    $upload = upload_img($_FILES['newsmilie'], 'images/smilies/', $id, 1024*1024, 999, 999);
    systext(upload_img_notice($upload));
}

///////////////////////
//// Delete Smilie ////
///////////////////////

elseif (isset($_POST['delete_smilies']))
{
    foreach($_POST['delsmilie'] as $value)
    {
            $value = intval($value);
            $index = mysql_query('SELECT id FROM '.$FD->config('pref')."smilies
                                  WHERE `order`=$value", $FD->sql()->conn() );
            $id = mysql_result($index,0,'id');

            mysql_query('DELETE FROM '.$FD->config('pref')."smilies
                         WHERE `order`=$value", $FD->sql()->conn() );
            image_delete('images/smilies/', $id);
    }
    $_POST['delsmilie'] = array_reverse($_POST['delsmilie']);
    foreach($_POST['delsmilie'] as $value)
    {
            $value = intval($value);
            mysql_query('UPDATE '.$FD->config('pref')."smilies
                         SET `order`=`order`-1
                         WHERE `order`>$value", $FD->sql()->conn() );
    }
    systext('Ausgew&auml;hlte Smilies wurden gel&ouml;scht!');
}

////////////////////////////
//// Smilie Positionen  ////
////////////////////////////

elseif (($_GET['action']=='moveup' OR $_GET['action']=='movedown') AND isset($_GET['oid']))
{
    $_GET['oid'] = intval($_GET['oid']);
    if ($_GET['action']=='moveup')
    {
        $index = 'UPDATE '.$FD->config('pref')."smilies SET `order`=0 WHERE `order`=$_GET[oid]";
        mysql_query($index);
        $index = 'UPDATE '.$FD->config('pref')."smilies SET `order`=`order`+1 WHERE `order`=$_GET[oid]-1";
        mysql_query($index);
        $index = 'UPDATE '.$FD->config('pref')."smilies SET `order`=$_GET[oid]-1 WHERE `order`=0";
        mysql_query($index);
    }

    if ($_GET['action']=='movedown')
    {
        $index = 'UPDATE '.$FD->config('pref')."smilies SET `order`=0 WHERE `order`=$_GET[oid]";
        mysql_query($index);
        $index = 'UPDATE '.$FD->config('pref')."smilies SET `order`=`order`-1 WHERE `order`=$_GET[oid]+1";
        mysql_query($index);
        $index = 'UPDATE '.$FD->config('pref')."smilies SET `order`=$_GET[oid]+1 WHERE `order`=0";
        mysql_query($index);
    }
}

////////////////////////////
////// smilie list    //////
////////////////////////////

  $index = mysql_query('SELECT * FROM '.$FD->config('pref').'editor_config', $FD->sql()->conn() );
  $config_arr = mysql_fetch_assoc($index);

  $config_arr['num_smilies'] = $config_arr['smilies_rows']*$config_arr['smilies_cols'];

  $index = mysql_query('SELECT * FROM '.$FD->config('pref').'smilies ORDER BY `order` ASC', $FD->sql()->conn() );

  echo'<form action="" method="post" enctype="multipart/form-data">
         <input type="hidden" value="editor_smilies" name="go">
         <table class="configtable" cellpadding="4" cellspacing="0">
           <tr><td class="line" colspan="3">'.$FD->text('page', 'smilie_add_title').'</td></tr>
           <tr>
             <td class="config">
               <span class="small">'.$FD->text('page', 'smilie_add_select').':</span>
             </td>
             <td class="config">
               <span class="small">'.$FD->text('page', 'smilie_add_text').':</span>
             </td>
             <td class="config">
               <span class="small">'.$FD->text('page', 'smilie_add_insert').':</span>
             </td>
           </tr>
           <tr align="left" valign="top">
             <td class="config">
               <input class="text" size="30" name="newsmilie" type="file" />
             </td>
             <td class="config">
               <input class="text" size="15" name="replace_string" maxlength="15" value="" />
             </td>
             <td class="config">
               <select name="insert_after" size="1">
                 <option value="0">'.$FD->text('page', 'smilie_add_at_beginn').'</option>';
                 while ($insert_arr = mysql_fetch_assoc($index))
                 {
                   echo'<option value="'.$insert_arr['order'].'">'.$insert_arr['replace_string'].'</option>';
                   $insert_last = $insert_arr['order'];
                 }
  echo'
                 <option value="'.$insert_last.'" selected="selected">'.$FD->text('page', 'smilie_add_at_end').'</option>
               </select>
             </td>
           </tr>
           <tr><td class="space"></td></tr>
           <tr>
             <td class="buttontd" colspan="3">
               <button class="button_new" type="submit">
                 '.$FD->text('page', 'arrow').' '.$FD->text('page', 'smilie_add_button').'
               </button>
             </td>
           </tr>
           <tr><td class="space"></td></tr>
         </table>
       </form>
       ';

if (mysql_num_rows($index)>0)
{


    echo'
                    <table class="configtable" cellpadding="4" cellspacing="0">
                      <tr><td class="line" colspan="3">'.$FD->text('page', 'smilie_management_title').'</td></tr>
                      <tr><td class="space"></td></tr>
                    </table>

                    <form action="" method="post">
                        <input type="hidden" value="editor_smilies" name="go">
                        <table class="configtable" cellpadding="2" cellspacing="0">
                           <tr>
                                <td width="175"></td>
                                <td class="config" width="30">
                                </td>
                                <td class="config" width="100">
                                    '.$FD->text('page', 'smilies_replacement').'
                                </td>
                                <td class="config" style="padding-right:30px;">
                                    '.$FD->text('page', 'smilies_order').'
                                </td>
                                <td class="config" style="text-align:center;" width="70">
                                    '.$FD->text('page', 'smilies_delete').'
                                </td>
                                <td width="175"></td>
                            </tr>
    ';

    // Smilies auslesen
    $index = mysql_query('SELECT * FROM '.$FD->config('pref').'smilies ORDER BY `order` ASC', $FD->sql()->conn() );
    $smilie_last = mysql_num_rows($index);
    $i=0;
    while ($smilie_arr = mysql_fetch_assoc($index))
    {
        $i++;
        $pointer_up = '
            <a class="image_hover" style="margin-right:3px; float:right; width:24px; height:24px; background-image:url('.$FD->config('virtualhost').'admin/icons/arrow_up.png)" href="'.$_SERVER['PHP_SELF'].'?go='.$_GET['go'].'&oid='.$smilie_arr['order'].'&action=moveup" title="'.$FD->text('page', 'smilies_up').'">
                <img border="0" src="img/null.gif" alt="'.$FD->text('page', 'smilies_up').'">
            </a>';
        $pointer_down = '
            <a class="image_hover" style="margin-right:36px; float:right; width:24px; height:24px; background-image:url('.$FD->config('virtualhost').'admin/icons/arrow_down.png)" href="'.$_SERVER['PHP_SELF'].'?go='.$_GET['go'].'&oid='.$smilie_arr['order'].'&action=movedown" title="'.$FD->text('page', 'smilies_down').'">
                <img border="0" src="img/null.gif" alt="'.$FD->text('page', 'smilies_down').'">
            </a>';
        if ($smilie_arr['order']==1) {
            $pointer_up = '<img style="margin-right:3px; float:right; width:24px; height:24px; display:block;" src="img/null.gif" border="0" alt="">';
        }
        if ($smilie_arr['order']>=$smilie_last) {
            $pointer_down = '<img style="margin-right:36px; float:right; width:24px; height:24px; display:block;" src="img/null.gif" border="0" alt="" width="24" height="24">';
        }

        echo'
                            <tr
                                onmouseover="
                                    '.color_list_entry ( 'input_'.$smilie_arr['id'], '#EEEEEE', '#DE5B5B', 'td_'.$smilie_arr['id'] ).'
                                    '.color_list_entry ( 'input_'.$smilie_arr['id'], '#EEEEEE', '#EEEEEE', 'this' ).'
                                "
                                onmouseout="
                                    '.color_list_entry ( 'input_'.$smilie_arr['id'], 'transparent', '#C24949', 'td_'.$smilie_arr['id'] ).'
                                    '.color_list_entry ( 'input_'.$smilie_arr['id'], 'transparent', 'transparent', 'this' ).'
                                "
                            >
                                <td></td>
                                <td align="left">
                                    <img src="'.image_url('images/smilies/', $smilie_arr['id']).'" alt="" />
                                </td>
                                <td class="configthin">
                                    '.$smilie_arr['replace_string'].'
                                </td>
                                <td class="center middle" style="">
                                    '.$pointer_down.''.$pointer_up.'

                                </td>
                                <td class="center pointer" id="td_'.$smilie_arr['id'].'"
                                    onmouseover="'.color_list_entry ( 'input_'.$smilie_arr['id'], '#EEEEEE', '#DE5B5B', 'this' ).'"
                                    onmouseout="'.color_list_entry ( 'input_'.$smilie_arr['id'], 'transparent', '#C24949', 'this' ).'"
                                    onclick="'.color_click_entry ( 'input_'.$smilie_arr['id'], '#EEEEEE', '#DE5B5B', 'this' ).'"
                                >
                                    <input class="pointer" type="checkbox" name="delsmilie[]" id="input_'.$smilie_arr['id'].'" value="'.$smilie_arr['order'].'"
                                        onclick="'.color_click_entry ( 'this', '#EEEEEE', '#DE5B5B', 'td_'.$smilie_arr['id'] ).'"
                                    >
                                </td>
                                <td></td>
                            </tr>
        ';
        if ($config_arr['num_smilies']==$i) {
            echo'
            <tr>
              <td colspan="6">
                <span class="small" style="float:left">'.$FD->text('page', 'smilies_shown').'</span>
                <span class="small" style="float:right">'.$FD->text('page', 'smilies_shown').'</span>
                <br /><hr>
                <span class="small" style="float:left">'.$FD->text('page', 'smilies_not_shown').'</span>
                <span class="small" style="float:right">'.$FD->text('page', 'smilies_not_shown').'</span>
              </td>
            </tr>';
        }

    }
    echo'
                       </table>
                       <table class="configtable" cellpadding="4" cellspacing="0">
                         <tr><td class="space"></td></tr>
                         <tr><td class="space"></td></tr>
                         <tr>
                           <td>
                             <select name="delete_smilies" size="1">
                               <option value="0">'.$FD->text('page', 'smilies_delnotconfirm').'</option>
                               <option value="1">'.$FD->text('page', 'smilies_delconfirm').'</option>
                             </select>
                           </td>
                           <td class="buttontd" style="width:100%;">
                             <button class="button_new" type="submit">
                               '.$FD->text('admin', 'button_arrow').' '.$FD->text('page', 'do_button_long').'
                             </button>
                           </td>
                         </tr>
                       </table>
                    </form>
    ';
}
else
{
    systext($FD->text('page', 'smilies_no_smilies'),$FD->text('page', 'info'));
}
?>
