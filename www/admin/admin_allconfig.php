<?php

/////////////////////////////////////
//// Konfiguration aktualisieren ////
/////////////////////////////////////

if ($_POST['title'] AND $_POST['virtualhost'] AND $_POST['admin_mail'])
{
  $_POST[title] = savesql($_POST[title]);
  $_POST[virtualhost] = savesql($_POST[virtualhost]);
  $_POST[description] = savesql($_POST[description]);
  $_POST[author] = savesql($_POST[author]);
  $_POST[admin_mail] = savesql($_POST[admin_mail]);
  $_POST[keywords] = savesql($_POST[keywords]);

  mysql_query("UPDATE fs_global_config
               SET virtualhost = '$_POST[virtualhost]',
                   admin_mail = '$_POST[admin_mail]',
                   title = '$_POST[title]',
                   description = '$_POST[description]',
                   keywords = '$_POST[keywords]',
                   author = '$_POST[author]',
                   design = '$_POST[design]',
                   allow_other_designs = '$_POST[allow_other_designs]',
                   show_announcement = '$_POST[show_announcement]'
               WHERE id = '1'", $db);
    systext("Die Konfiguration wurde aktualisiert");
}

/////////////////////////////////////
////// Konfiguration Formular ///////
/////////////////////////////////////

else
{
  $index = mysql_query("SELECT * FROM fs_global_config", $db);
  $config_arr = mysql_fetch_assoc($index);
    
  $error_message = "";

  if (isset($_POST['sended']))
  {
    $config_arr[title] = $_POST['title'];
    $config_arr[virtualhost] = $_POST['virtualhost'];
    $config_arr[description] = $_POST['description'];
    $config_arr[author] = $_POST['author'];
    $config_arr[admin_mail] = $_POST['admin_mail'];
    $config_arr[keywords] = $_POST['keywords'];
    $config_arr[design] = $_POST['design'];
    $config_arr[allow_other_designs] = $_POST['allow_other_designs'];

    $error_message = "Bitte füllen Sie alle Pflichfelder aus!";
  }

  systext($error_message);
  echo'<form action="'.$PHP_SELF.'" method="post">
         <input type="hidden" value="allconfig" name="go">
         <input type="hidden" name="sended" value="">
         <input type="hidden" value="'.session_id().'" name="PHPSESSID">
         <table border="0" cellpadding="4" cellspacing="0" width="600">
           <tr align="left" valign="top">
             <td class="config" valign="top" width="50%">
               Titel:<br>
               <font class="small">Der Titel der Seite</font>
             </td>
             <td class="config" valign="top" width="50%">
               <input class="text" size="40" name="title" maxlength="100" value="'.$config_arr[title].'" />
             </td>
           </tr>
           <tr>
             <td class="config" valign="top" width="50%">
               URL:<br>
               <font class="small">URL der Seite, auf die die Links umgeschaltet werden</font>
             </td>
             <td class="config" valign="top" width="50%">
               <input class="text" size="40" name="virtualhost" maxlength="255" value="'.$config_arr[virtualhost].'">
             </td>
           </tr>
           <tr>
             <td class="config" valign="top" width="50%">
               Admin Email:<br>
               <font class="small">Email Adresse an die Probleme und Meldungen gesendet werden</font>
             </td>
             <td class="config" valign="top" width="50%">
               <input class="text" size="40" name="admin_mail" maxlength="100" value="'.$config_arr[admin_mail].'">
             </td>
           </tr>
           <tr>
             <td class="config" valign="top" width="50%">
               Beschreibung: <font class="small">(optional)</font><br>
               <font class="small">Ein kurzer Text über die Seite</font>
             </td>
             <td class="config" valign="top" width="50%">
               <input class="text" size="40" name="description" maxlength="255" value="'.$config_arr[description].'">
             </td>
           </tr>
           <tr>
             <td class="config" valign="top" width="50%">
               Autor: <font class="small">(optional)</font><br>
               <font class="small">Webmaster der Seite</font>
             </td>
             <td class="config" valign="top" width="50%">
               <input class="text" size="40" name="author" maxlength="100" value="'.$config_arr[author].'">
             </td>
           </tr>
           <tr>
             <td class="config" valign="top" width="50%">
               Keywords: <font class="small">(optional)</font><br>
               <font class="small">Stichwörter zur Seite, bitte mit Kommas trennen<br>
               Wichtig für Suchmaschinen!</font>
             </td>
             <td class="config" valign="top" width="50%">
               <input class="text" size="40" name="keywords" maxlength="255" value="'.$config_arr[keywords].'">
             </td>
           </tr>
           <tr>
             <td class="config" valign="top" width="50%">
               Design:<br>
               <font class="small">Design, in dem die Seite angezeigt wird</font>
             </td>
             <td class="config" valign="top" width="50%">
               <select name="design" size="1">';
               
               $index = mysql_query("select id, name from fs_template ORDER BY id", $db);
               while ($design_arr = mysql_fetch_assoc($index))
               {
                 echo '<option value="'.$design_arr[id].'"';
                 if ($design_arr[id] == $global_config_arr[design])
                   echo ' selected=selected';
                 echo '>'.$design_arr[name];
                 if ($design_arr[id] == $global_config_arr[design])
                    echo ' (aktiv)';
                 echo '</option>';
               }
               echo'
               
               </select>
             </td>
           </tr>
           <tr>
             <td class="config" valign="top" width="50%">
               Andere Designs erlauben:<br>
               <font class="small">Soll das Anzeigen der Seite in anderen Designs erlaubt werden?<br>
               (http://www.seite.de/index.php?design={design_id})</font>
             </td>
             <td class="config" valign="top" width="50%">
               <input type="checkbox" name="allow_other_designs" value="1"';
               if ($config_arr[allow_other_designs] == 1)
                 echo " checked=checked";
               echo'/>
             </td>
           </tr>
           <tr>
             <td class="config" valign="top" width="50%">
               Ankündigung anzeigen:<br>
               <font class="small">Wo soll die Ankündigugn angezeigt werden?</font>
             </td>
             <td class="config" valign="top" width="50%">
               <select name="show_announcement">
                 <option value="1"';
                 if ($config_arr[show_announcement] == 1)
                   echo ' selected="selected"';
                 echo'>überall</option>
                 <option value="2"';
                 if ($config_arr[show_announcement] == 2)
                   echo ' selected="selected"';
                 echo'>nur auf der Startseite (News)</option>
                 <option value="0"';
                   if ($config_arr[show_announcement] == 0)
                   echo ' selected="selected"';
                 echo'>nie</option>
               </select>
             </td>
           </tr>
           
           <tr>
             <td align="center" colspan="2">
               <input class="button" type="submit" value="Absenden">
             </td>
           </tr>
         </table>
       </form>
      ';
}
?>