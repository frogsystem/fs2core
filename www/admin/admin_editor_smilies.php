<?php

////////////////////
//// New Smilie ////
////////////////////

if ($_FILES['newsmilie']['name'] != "" AND $_POST['replace_string'])
{
    $_POST[replace_string] = savesql(killhtml($_POST[replace_string]));

    mysql_query("UPDATE ".$global_config_arr[pref]."smilies
                 SET `order`=`order`+1
                 WHERE `order`>$_POST[insert_after]", $db);
    mysql_query("INSERT INTO ".$global_config_arr[pref]."smilies
                 (replace_string, `order`)
                 VALUES ('$_POST[replace_string]', '$_POST[insert_after]'+1)", $db);

    $id = mysql_insert_id();
    $upload = upload_img($_FILES['newsmilie'], "images/smilies/", $id, 1024*1024, 999, 999);
    systext(upload_img_notice($upload));
}

///////////////////////
//// Delete Smilie ////
///////////////////////

elseif ($_POST['delete_smilies'])
{
    foreach($_POST['delsmilie'] as $value)
    {
            $index = mysql_query("SELECT id FROM ".$global_config_arr[pref]."smilies
                                  WHERE `order`=$value", $db);
            $id = mysql_result($index,0,"id");

            mysql_query("DELETE FROM ".$global_config_arr[pref]."smilies
                         WHERE `order`=$value", $db);
            image_delete("images/smilies/", $id);
    }
    $_POST['delsmilie'] = array_reverse($_POST['delsmilie']);
    foreach($_POST['delsmilie'] as $value)
    {
            mysql_query("UPDATE ".$global_config_arr[pref]."smilies
                         SET `order`=`order`-1
                         WHERE `order`>$value", $db);
    }
    systext("Ausgewählte Smilies wurden gelöscht!");
}

////////////////////////////
//// Smilie Positionen  ////
////////////////////////////

elseif (($_GET['action']=="moveup" OR $_GET['action']=="movedown") AND isset($_GET['oid']))
{
    if ($_GET['action']=="moveup")
    {
        $index = "UPDATE ".$global_config_arr[pref]."smilies SET `order`=0 WHERE `order`=$_GET[oid]";
        mysql_query($index);
        $index = "UPDATE ".$global_config_arr[pref]."smilies SET `order`=`order`+1 WHERE `order`=$_GET[oid]-1";
        mysql_query($index);
        $index = "UPDATE ".$global_config_arr[pref]."smilies SET `order`=$_GET[oid]-1 WHERE `order`=0";
        mysql_query($index);
    }

    if ($_GET['action']=="movedown")
    {
        $index = "UPDATE ".$global_config_arr[pref]."smilies SET `order`=0 WHERE `order`=$_GET[oid]";
        mysql_query($index);
        $index = "UPDATE ".$global_config_arr[pref]."smilies SET `order`=`order`-1 WHERE `order`=$_GET[oid]+1";
        mysql_query($index);
        $index = "UPDATE ".$global_config_arr[pref]."smilies SET `order`=$_GET[oid]+1 WHERE `order`=0";
        mysql_query($index);
    }
}

////////////////////////////
////// smilie list    //////
////////////////////////////

  $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."editor_config", $db);
  $config_arr = mysql_fetch_assoc($index);

  $config_arr[num_smilies] = $config_arr[smilies_rows]*$config_arr[smilies_cols];

  $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."smilies ORDER BY `order` ASC", $db);

  echo'<form action="" method="post" enctype="multipart/form-data">
         <input type="hidden" value="editor_smilies" name="go">
         <table class="configtable" cellpadding="4" cellspacing="0">
           <tr><td class="line" colspan="3">'.$admin_phrases[editor][smilie_add_title].'</td></tr>
           <tr>
             <td class="config">
               <span class="small">'.$admin_phrases[editor][smilie_add_select].':</span>
             </td>
             <td class="config">
               <span class="small">'.$admin_phrases[editor][smilie_add_text].':</span>
             </td>
             <td class="config">
               <span class="small">'.$admin_phrases[editor][smilie_add_insert].':</span>
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
                 <option value="0">'.$admin_phrases[editor][smilie_add_at_beginn].'</option>';
                 while ($insert_arr = mysql_fetch_assoc($index))
                 {
                   echo'<option value="'.$insert_arr[order].'">'.$insert_arr[replace_string].'</option>';
                   $insert_last = $insert_arr[order];
                 }
  echo'
                 <option value="'.$insert_last.'" selected="selected">'.$admin_phrases[editor][smilie_add_at_end].'</option>
               </select>
             </td>
           </tr>
           <tr><td class="space"></td></tr>
           <tr>
             <td class="buttontd" colspan="3">
               <button class="button_new" type="submit">
                 '.$admin_phrases[common][arrow].' '.$admin_phrases[editor][smilie_add_button].'
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
                      <tr><td class="line" colspan="3">'.$admin_phrases[editor][smilie_management_title].'</td></tr>
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
                                    '.$admin_phrases[editor][smilies_replacement].'
                                </td>
                                <td class="config" style="padding-right:30px;">
                                    '.$admin_phrases[editor][smilies_order].'
                                </td>
                                <td class="config" style="text-align:center;" width="70">
                                    '.$admin_phrases[editor][smilies_delete].'
                                </td>
                                <td width="175"></td>
                            </tr>
    ';

    // Smilies auslesen
    $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."smilies ORDER BY `order` ASC", $db);
    $smilie_last = mysql_num_rows($index);
    $i=0;
    while ($smilie_arr = mysql_fetch_assoc($index))
    {
        $i++;
        $pointer_up = '
            <a class="image_hover" style="margin-right:3px; float:right; width:24px; height:24px; background-image:url('.$global_config_arr['virtualhost'].'admin/icons/arrow_up.png)" href="'.$PHP_SELF.'?go='.$_GET['go'].'&oid='.$smilie_arr['order'].'&action=moveup" title="'.$admin_phrases[editor][smilies_up].'">
                <img border="0" src="img/null.gif" alt="'.$admin_phrases[editor][smilies_up].'">
            </a>';
        $pointer_down = '
            <a class="image_hover" style="margin-right:36px; float:right; width:24px; height:24px; background-image:url('.$global_config_arr['virtualhost'].'admin/icons/arrow_down.png)" href="'.$PHP_SELF.'?go='.$_GET['go'].'&oid='.$smilie_arr['order'].'&action=movedown" title="'.$admin_phrases[editor][smilies_down].'">
                <img border="0" src="img/null.gif" alt="'.$admin_phrases[editor][smilies_down].'">
            </a>';
        if ($smilie_arr[order]==1) {
            $pointer_up = '<img style="margin-right:3px; float:right; width:24px; height:24px; display:block;" src="img/null.gif" border="0" alt="">';
        }
        if ($smilie_arr[order]>=$smilie_last) {
            $pointer_down = '<img style="margin-right:36px; float:right; width:24px; height:24px; display:block;" src="img/null.gif" border="0" alt="" width="24" height="24">';
        }
        
        echo'
                            <tr
                                onmouseover="
                                    '.color_list_entry ( "input_".$smilie_arr['id'], "#EEEEEE", "#DE5B5B", "td_".$smilie_arr['id'] ).'
                                    '.color_list_entry ( "input_".$smilie_arr['id'], "#EEEEEE", "#EEEEEE", "this" ).'
                                "
                                onmouseout="
                                    '.color_list_entry ( "input_".$smilie_arr['id'], "transparent", "#C24949", "td_".$smilie_arr['id'] ).'
                                    '.color_list_entry ( "input_".$smilie_arr['id'], "transparent", "transparent", "this" ).'
                                "
                            >
                                <td></td>
                                <td align="left">
                                    <img src="'.image_url("images/smilies/", $smilie_arr[id]).'" alt="" />
                                </td>
                                <td class="configthin">
                                    '.$smilie_arr[replace_string].'
                                </td>
                                <td class="center middle" style="">
                                    '.$pointer_down.''.$pointer_up.'

                                </td>
                                <td class="center pointer" id="td_'.$smilie_arr[id].'"
                                    onmouseover="'.color_list_entry ( "input_".$smilie_arr['id'], "#EEEEEE", "#DE5B5B", "this" ).'"
                                    onmouseout="'.color_list_entry ( "input_".$smilie_arr['id'], "transparent", "#C24949", "this" ).'"
                                    onclick="'.color_click_entry ( "input_".$smilie_arr['id'], "#EEEEEE", "#DE5B5B", "this" ).'"
                                >
                                    <input class="pointer" type="checkbox" name="delsmilie[]" id="input_'.$smilie_arr[id].'" value="'.$smilie_arr[order].'"
                                        onclick="'.color_click_entry ( "this", "#EEEEEE", "#DE5B5B", "td_".$smilie_arr['id'] ).'"
                                    >
                                </td>
                                <td></td>
                            </tr>
        ';
        if ($config_arr[num_smilies]==$i) {
            echo'
            <tr>
              <td colspan="6">
                <span class="small" style="float:left">'.$admin_phrases[editor][smilies_shown].'</span>
                <span class="small" style="float:right">'.$admin_phrases[editor][smilies_shown].'</span>
                <br /><hr>
                <span class="small" style="float:left">'.$admin_phrases[editor][smilies_not_shown].'</span>
                <span class="small" style="float:right">'.$admin_phrases[editor][smilies_not_shown].'</span>
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
                               <option value="0">'.$admin_phrases[editor][smilies_delnotconfirm].'</option>
                               <option value="1">'.$admin_phrases[editor][smilies_delconfirm].'</option>
                             </select>
                           </td>
                           <td class="buttontd" style="width:100%;">
                             <button class="button_new" type="submit">
                               '.$admin_phrases[common][arrow].' '.$admin_phrases[common][do_button_long].'
                             </button>
                           </td>
                         </tr>
                       </table>
                    </form>
    ';
}
else
{
    systext($admin_phrases[editor][smilies_no_smilies],$admin_phrases[common][info]);
}
?>