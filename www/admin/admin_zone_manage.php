<?php

////////////////////////////////
//// Template aktualisieren ////
////////////////////////////////

if ($_POST['design_id'] AND $_POST['name'] AND $_POST['sended'] == "edit")
{
  if (rename("../css/$_POST[oldname].css", "../css/$_POST[name].css"))
  {
    mysql_query("UPDATE fs_template
                 SET name = '$_POST[name]'
                 WHERE id = '$_POST[design_id]'", $db);
    systext("Das Template wurde aktualisiert!");
  }
  else
  {
    systext("Das Template konnte nicht aktualisiert werden!");
  }
}

//////////////////////////
//// Template löschen ////
//////////////////////////

elseif ($_POST['design_id'] AND $_POST['sended'] == "delete")
{
  if (unlink("../css/$_POST[oldname].css"))
  {
    mysql_query("DELETE FROM fs_template
                 WHERE id = '$_POST[design_id]'", $db);

    if ($_POST[design_id] == $global_config_arr[design] AND ($_POST[new_page_design] OR $_POST[new_page_design]==0))
    {
    mysql_query("UPDATE fs_global_config
                 SET design = '$_POST[new_page_design]'
                 WHERE id = '1'", $db);
    }
    systext("Das Template wurde gelöscht!");
  }
  else
  {
    systext("Das Template konnte nicht gelöscht werden!");
  }
}

//////////////////
//// Formular ////
//////////////////

elseif ($_POST['design_id'] AND $_POST['template_action'])
{

  if ($_POST['template_action'] == "edit")
  {
    $index = mysql_query("select id, name from fs_template WHERE id = '$_POST[design_id]'", $db);
    $admin_design_arr = mysql_fetch_assoc($index);
  
    $admin_design_arr['name'] = killhtml($admin_design_arr['name']);
  
    $error_message = "";

    if (isset($_POST['sended']))
    {
      $error_message = "Bitte füllen Sie <b>alle Pflichfelder</b> aus!";
    }

    systext($error_message);
    echo'<form action="" method="post">
           <input type="hidden" value="template_manage" name="go">
           <input type="hidden" value="'.session_id().'" name="PHPSESSID">
           <input type="hidden" name="sended" value="edit" />
           <input type="hidden" name="template_action" value="'.$_POST[template_action].'" />
           <input type="hidden" name="design_id" value="'.$admin_design_arr[id].'" />
           <input type="hidden" name="oldname" value="'.$admin_design_arr[name].'" />
           <table border="0" cellpadding="4" cellspacing="0" width="600">
             <tr>
               <td class="config" width="30%" valign="top" align="left">
                 Name: <font class="small">(umbenennen)</font>
               </td>
               <td class="config" valign="top" align="left">
                 <input class="text" size="40" name="name" maxlength="100" value="'.$admin_design_arr['name'].'" />
               </td>
             </tr>
             <tr>
               <td></td>
               <td class="config" valign="top" align="left">
                 <input type="submit" value="Speichern" class="button" /> <input type="reset" value="Zurücksetzen" class="button" />
               </td>
             </tr>
           </table>
         </form>
        ';
  }
  elseif ($_POST['template_action'] == "delete")
  {
    $index = mysql_query("select id, name from fs_template WHERE id = '$_POST[design_id]'", $db);
    $admin_design_arr = mysql_fetch_assoc($index);

    $admin_design_arr['name'] = killhtml($admin_design_arr['name']);

    echo'<form action="" method="post">
           <input type="hidden" value="template_manage" name="go">
           <input type="hidden" value="'.session_id().'" name="PHPSESSID">
           <input type="hidden" name="sended" value="delete" />
           <input type="hidden" name="design_id" value="'.$admin_design_arr[id].'" />
           <input type="hidden" name="oldname" value="'.$admin_design_arr[name].'" />
           <table width="100%" cellpadding="4" cellspacing="0">
           <tr align="left" valign="top">
             <td class="config">
               <b>Design löschen:</b><br><br>
             </td>
             <td></td>
           </tr>
           <tr align="left" valign="top">
             <td width="50%" class="config">
               Soll das Design "'.$admin_design_arr[name].'" wirklich gelöscht werden?
             </td>
             <td width="50%">
               <input type="submit" value="Ja" class="button" />  <input type="button" onclick="history.back(1);" value="Nein" class="button" />
             </td>
           </tr>';
       
    if ($admin_design_arr[id] == $global_config_arr[design])
    {
      echo'<tr>
             <td height="10px">
             </td>
           </tr>
           <tr align="left" valign="top">
             <td class="config">
               Dieses Design ist das aktuelle Seiten-Design. In welchem Design soll die Seite nach dem Löschvorgang erscheinen?
             </td>
             <td valign="middle">
               <select name="new_page_design" size="1"  class="text">';

               $index = mysql_query("select id, name from fs_template WHERE id != '$admin_design_arr[id]' ORDER BY name", $db);
               while ($admin_new_page_design_arr = mysql_fetch_assoc($index))
               {
                 echo'<option value="'.$admin_new_page_design_arr[id].'">'.$admin_new_page_design_arr[name].'</option>';
               }

      echo'    </select>
             </td>
           </tr>';
    }
       
    echo'  </table>
         </form>';
  }
}

//////////////////////////
//// Template Auswahl ////
//////////////////////////

else
{
  echo '<table width="100%" cellspacing="0" cellpadding="4">
         <tr>
           <td class="config" colspan="2">
             Wählen Sie die Zone aus, die Sie bearbeiten möchten:
           </td>
         </tr>
         <tr><td></td></tr>';

         $index = mysql_query("select * from fs_zones ORDER BY name", $db);
         if (mysql_num_rows($index) <= 0)
         {
           echo '<tr>
                  <td class="config" colspan="2" align="center" valign="middle">
                    '.systext("Es wurde keine weitere Zone gefunden!").'
                  </td>
                 </tr>';
         }
         else
         {
           while ($admin_zone_arr = mysql_fetch_assoc($index))
           {
             echo '<form action="'.$PHP_SELF.'" method="post">
                     <input type="hidden" value="zone_manage" name="go">
                     <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                     <input type="hidden" name="zone_id" value="'.$admin_zone_arr[id].'" />

           <tr align="left" valign="top" valign="middle">
             <td width="20%" class="config">
               '.$admin_zone_arr[name];
    echo '   </td>
             <td class="config">
               <select name="zone_action" size="1" class="text">
                <option value="edit">Bearbeiten</option>
                <option value="delete">Löschen</option>
               </select> <input class="button" type="submit" value="Los" />
             </td>
           </tr>
                   </form>';
           }
         }
  echo '</table>';
}
?>