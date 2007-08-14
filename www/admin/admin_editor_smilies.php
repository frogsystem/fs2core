<?php

////////////////////////////
//// New Smilie         ////
////////////////////////////

if ($_FILES['newsmilie']['name'] != "" AND $_POST['replace_string'])
{
    $_POST[replace_string] = savesql(killhtml($_POST[replace_string]));

    mysql_query("UPDATE fs_smilies
                 SET `order`=`order`+1
                 WHERE `order`>$_POST[insert_after]", $db);
    mysql_query("INSERT INTO fs_smilies
                 (replace_string, `order`)
                 VALUES ('$_POST[replace_string]', '$_POST[insert_after]'+1)", $db);

    $id = mysql_insert_id();
    $upload = upload_img($_FILES['newsmilie'], "../images/smilies/", $id, 1024*1024, 9999, 9999, 0, 0, false);
    systext(upload_img_notice($upload));
}

////////////////////////////
//// Del Smilie         ////
////////////////////////////

elseif ($_POST['delsmilie'])
{
    foreach($_POST['delsmilie'] as $value)
    {
            $index = mysql_query("SELECT id FROM fs_smilies
                                  WHERE `order`=$value", $db);
            $id = mysql_result($index,0,"id");

            mysql_query("DELETE FROM fs_smilies
                         WHERE `order`=$value", $db);
            image_delete("../images/smilies/", $id);
    }
    $_POST['delsmilie'] = array_reverse($_POST['delsmilie']);
    foreach($_POST['delsmilie'] as $value)
    {
            mysql_query("UPDATE fs_smilies
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
        $index = "UPDATE fs_smilies SET `order`=0 WHERE `order`=$_GET[oid]";
        mysql_query($index);
        $index = "UPDATE fs_smilies SET `order`=`order`+1 WHERE `order`=$_GET[oid]-1";
        mysql_query($index);
        $index = "UPDATE fs_smilies SET `order`=$_GET[oid]-1 WHERE `order`=0";
        mysql_query($index);
    }

    if ($_GET['action']=="movedown")
    {
        $index = "UPDATE fs_smilies SET `order`=0 WHERE `order`=$_GET[oid]";
        mysql_query($index);
        $index = "UPDATE fs_smilies SET `order`=`order`-1 WHERE `order`=$_GET[oid]+1";
        mysql_query($index);
        $index = "UPDATE fs_smilies SET `order`=$_GET[oid]+1 WHERE `order`=0";
        mysql_query($index);
    }
}

////////////////////////////
////// smilie list    //////
////////////////////////////
  $index = mysql_query("select * from fs_editor_config", $db);
  $config_arr = mysql_fetch_assoc($index);

  $config_arr[num_smilies] = $config_arr[smilies_rows]*$config_arr[smilies_cols];

  $index = mysql_query("SELECT * FROM fs_smilies ORDER BY `order` ASC", $db);

  echo'<form action="'.$PHP_SELF.'" method="post" enctype="multipart/form-data">
         <input type="hidden" value="editorsmilies" name="go">
         <input type="hidden" name="sended" value="">
         <input type="hidden" value="'.session_id().'" name="PHPSESSID">
         <table border="0" cellpadding="4" cellspacing="0" width="600">
           <tr align="left" valign="top">
             <td class="config" valign="top" colspan="4">
               Neuen Smilie hinzufügen:
             </td>
           </tr>
           <tr align="left" valign="top">
             <td valign="top">
               <span class="small">Smilie auswählen:</span>
             </td>
             <td valign="top">
               <span class="small">Ersetungstext:</span>
             </td>
             <td valign="top">
               <span class="small">Einfügen nach:</span>
             </td>
             <td valign="top">
             </td>
           </tr>
           <tr align="left" valign="top">
             <td class="config" valign="top">
               <input class="text" size="20" name="newsmilie" type="file" />
             </td>
             <td class="config" valign="top">
               <input class="text" size="15" name="replace_string" maxlength="15" value="" />
             </td>
             <td class="config" valign="top">
               <select name="insert_after" size="1">
                 <option value="0">am Anfang</option>';
                 while ($insert_arr = mysql_fetch_assoc($index))
                 {
                   echo'<option value="'.$insert_arr[order].'">'.$insert_arr[replace_string].'</option>';
                   $insert_last = $insert_arr[order];
                 }
echo'
                 <option value="'.$insert_last.'" selected="selected">am Ende</option>
               </select>
             </td>
             <td class="config" valign="top">
               <input class="button" type="submit" value="Hinzufügen">
             </td>
           </tr>
         </table>
       </form>
       ';

if (mysql_num_rows($index)>0)
{


    echo'
                    <form action="'.$PHP_SELF.'" method="post">
                        <input type="hidden" value="editorsmilies" name="go">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="2" cellspacing="0">
                            <tr>
                                <td width="175"></td>
                                <td class="config" width="30">
                                </td>
                                <td class="config" width="100">
                                    Text
                                </td>
                                <td class="config">
                                    Sortierung
                                </td>
                                <td class="config" style="padding-left:30px;">
                                    Löschen
                                </td>
                                <td width="175"></td>
                            </tr>
    ';

    // Smilies auslesen
    $index = mysql_query("SELECT * FROM fs_smilies ORDER BY `order` ASC", $db);
    $smilie_last = mysql_num_rows($index);
    $i=0;
    while ($smilie_arr = mysql_fetch_assoc($index))
    {
        $i++;
        $pointer_up = '<a href="'.$PHP_SELF.'?mid='.$_GET['mid'].'&go='.$_GET['go'].'&oid='.$smilie_arr[order].'&action=moveup&sid='.$_GET['sid'].'"><img src="img/bigpointer_up.png" border="0" alt="" title="nach oben" /></a>';
        $pointer_down = '<a href="'.$PHP_SELF.'?mid='.$_GET['mid'].'&go='.$_GET['go'].'&oid='.$smilie_arr[order].'&action=movedown&sid='.$_GET['sid'].'"><img src="img/bigpointer_down.png" border="0" alt="" title="nach unten" /></a>';
        if ($smilie_arr[order]==1) {
            $pointer_up = '<img src="img/bigpointer_up_grey.png" border="0" alt="" />';
        }
        if ($smilie_arr[order]>=$smilie_last) {
            $pointer_down = '<img src="img/bigpointer_down_grey.png" border="0" alt="" />';
        }
        
        echo'
                            <tr>
                                <td></td>
                                <td align="left">
                                    <img src="'.image_url("../images/smilies/", $smilie_arr[id]).'" alt="" />
                                </td>
                                <td class="configthin">
                                    '.$smilie_arr[replace_string].'
                                </td>
                                <td align="center">
                                    '.$pointer_up.'
                                    '.$pointer_down.'
                                </td>
                                <td align="center" style="padding-left:30px;">
                                    <input onClick=\'delalert ("delsmilie'.$smilie_arr[id].'","Soll der Smilie wirklich gelöscht werden?")\' type="checkbox" name="delsmilie[]" id="delsmilie'.$smilie_arr[id].'" value="'.$smilie_arr[order].'">
                                </td>
                                <td></td>
                            </tr>
        ';
        if ($config_arr[num_smilies]==$i) {
            echo'
            <tr>
              <td colspan="6">
                <span class="small" style="float:left">werden angezeigt</span>
                <span class="small" style="float:right">werden angezeigt</span>
                <br /><hr>
                <span class="small" style="float:left">werden nicht angezeigt</span>
                <span class="small" style="float:right">werden nicht angezeigt</span>
              </td>
            </tr>';
        }
        
    }
    echo'
                            <tr>
                                <td colspan="4"></td>
                                <td align="center" style="padding-left:30px;">
                                    <input class="button" type="submit" value="Löschen">
                                </td>
                                <td></td>
                            </tr>
                        </table>
                    </form>
    ';
}
else
{
    systext("Es wurden keine Smilies gefunden!");
}
?>