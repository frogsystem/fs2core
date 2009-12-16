<?php

////////////////////////////////
//// Template aktualisieren ////
////////////////////////////////

if ($_POST['design_id'] AND $_POST['name'] AND $_POST['sended'] == "edit")
{
  $index = mysql_query("SELECT COUNT(id) AS number FROM ".$global_config_arr[pref]."template WHERE name = '$_POST[name]'", $db);
  if (mysql_result($index,0,"number") == 0)
  {
    mysql_query("UPDATE ".$global_config_arr[pref]."template
                 SET name = '$_POST[name]'
                 WHERE id = '$_POST[design_id]'", $db);
    systext("Das Design wurde aktualisiert!");
  }
  else
  {
    systext("Es existiert bereits ein Design mit diesem Namen!");
  }
}

//////////////////////////
//// Template löschen ////
//////////////////////////

elseif ($_POST['design_id'] AND $_POST['sended'] == "delete")
{
    mysql_query("DELETE FROM ".$global_config_arr[pref]."template
                 WHERE id = '$_POST[design_id]'", $db);

    if ($_POST[design_id] == $global_config_arr[design] AND ($_POST[new_page_design] OR $_POST[new_page_design]==0))
    {
    mysql_query("UPDATE ".$global_config_arr[pref]."global_config
                 SET design = '$_POST[new_page_design]'
                 WHERE id = '1'", $db);
    }
    systext("Das Design wurde gelöscht!");

}

//////////////////
//// Formular ////
//////////////////

elseif ($_POST['design_id'] AND $_POST['template_action'])
{

  if ($_POST['template_action'] == "edit")
  {
    $index = mysql_query("select id, name from ".$global_config_arr[pref]."template WHERE id = '$_POST[design_id]'", $db);
    $admin_design_arr = mysql_fetch_assoc($index);
  
    $admin_design_arr['name'] = killhtml($admin_design_arr['name']);
  
    $error_message = "";

    if (isset($_POST['sended']))
    {
      $error_message = "Bitte füllen Sie <b>alle Pflichfelder</b> aus!";
    }

    systext($error_message);
    echo'<form action="" method="post">
           <input type="hidden" value="design_admin" name="go">
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
    $index = mysql_query("select id, name from ".$global_config_arr[pref]."template WHERE id = '$_POST[design_id]'", $db);
    $admin_design_arr = mysql_fetch_assoc($index);

    $admin_design_arr['name'] = killhtml($admin_design_arr['name']);

    echo'<form action="" method="post">
           <input type="hidden" value="design_admin" name="go">
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
               <input type="submit" value="Ja" class="button" />  <input type="button" onclick=\'location.href="?go=design_admin";\' value="Nein" class="button" />
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

               $index = mysql_query("select id, name from ".$global_config_arr[pref]."template WHERE id != '$admin_design_arr[id]' ORDER BY name", $db);
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
             Wählen Sie das Design aus, dass Sie bearbeiten möchten:<br>
             <font class="small"><b>Achtung!</b> Das Standard-Design <b>default</b> kann nicht umbenannt
             und gelöscht werden!</font>
           </td>
         </tr>
         <tr><td></td></tr>';

         $index = mysql_query("select id, name from ".$global_config_arr[pref]."template WHERE id != '0' ORDER BY id", $db);
         if (mysql_num_rows($index) <= 0)
         {
           echo '<tr>
                  <td class="config" colspan="2" align="center" valign="middle">
                    '.systext("Es wurden keine weiteren Designs gefunden!").'
                  </td>
                 </tr>';
         }
         else
         {
           while ($admin_design_arr = mysql_fetch_assoc($index))
           {
             echo '<form action="" method="post">
                     <input type="hidden" value="design_admin" name="go">
                     <input type="hidden" name="design_id" value="'.$admin_design_arr[id].'" />

           <tr align="left" valign="top" valign="middle">
             <td width="20%" class="config">
               '.$admin_design_arr[name];
               if ($admin_design_arr[id] == $global_config_arr[design]) {
                 echo ' (aktiv)'; }
    echo '   </td>
             <td class="config">
               <select name="template_action" size="1" class="text">
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