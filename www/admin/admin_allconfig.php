<?php

/////////////////////////////////////
//// Konfiguration aktualisieren ////
/////////////////////////////////////

if ($_POST['title'] AND $_POST['virtualhost'] AND $_POST['admin_mail']
AND $_POST['date'] AND $_POST['page'] AND $_POST['page_next'] AND $_POST['page_prev'] )
{

  if (substr($_POST[virtualhost], -1) != "/")
  {
      $_POST[virtualhost] = $_POST[virtualhost]."/";
  }

  $_POST[title] = savesql($_POST[title]);
  $_POST[virtualhost] = savesql($_POST[virtualhost]);
  $_POST[description] = savesql($_POST[description]);
  $_POST[author] = savesql($_POST[author]);
  $_POST[admin_mail] = savesql($_POST[admin_mail]);
  $_POST[keywords] = savesql($_POST[keywords]);
  $_POST[date] = savesql($_POST[date]);
  $_POST[page] = savesql($_POST[page]);
  $_POST[page_next] = savesql($_POST[page_next]);
  $_POST[page_prev] = savesql($_POST[page_prev]);
  
  mysql_query("UPDATE fs_global_config
               SET virtualhost = '$_POST[virtualhost]',
                   admin_mail = '$_POST[admin_mail]',
                   title = '$_POST[title]',
                   description = '$_POST[description]',
                   keywords = '$_POST[keywords]',
                   author = '$_POST[author]',
                   show_favicon = '$_POST[show_favicon]',
                   design = '$_POST[design]',
                   allow_other_designs = '$_POST[allow_other_designs]',
                   show_announcement = '$_POST[show_announcement]',
                   date = '$_POST[date]',
                   page = '$_POST[page]',
                   page_next = '$_POST[page_next]',
                   page_prev = '$_POST[page_prev]',
                   registration_antispam = '$_POST[registration_antispam]'
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
    $config_arr[date] = $_POST['date'];
    $config_arr[page] = $_POST['page'];
    $config_arr[page_next] = $_POST['page_next'];
    $config_arr[page_prev] = $_POST['page_prev'];
    
    $error_message = "Bitte füllen Sie alle Pflichfelder aus!";
  }
  
    $config_arr[title] = killhtml($config_arr[title]);
    $config_arr[virtualhost] = killhtml($config_arr[virtualhost]);
    $config_arr[description] = killhtml($config_arr[description]);
    $config_arr[author] = killhtml($config_arr[author]);
    $config_arr[admin_mail] = killhtml($config_arr[admin_mail]);
    $config_arr[keywords] = killhtml($config_arr[keywords]);
    $config_arr[design] = killhtml($config_arr[design]);
    $config_arr[allow_other_designs] = killhtml($config_arr[allow_other_designs]);
    $config_arr[date] = killhtml($config_arr[date]);
    $config_arr[page] = killhtml($config_arr[page]);
    $config_arr[page_next] = killhtml($config_arr[page_next]);
    $config_arr[page_prev] = killhtml($config_arr[page_prev]);

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
               Favicon verwenden:<br>
               <font class="small">Soll das Favicon eingebunden werden?<br>
               ([FS-Verzeichnis]/images/icons/favicon.ico)</font>
             </td>
             <td class="config" valign="top" width="50%">
               <input type="checkbox" name="show_favicon" value="1"';
               if ($config_arr[show_favicon] == 1)
                 echo " checked=checked";
               echo'/>
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
             <td class="config" valign="top" width="50%">
               Anti Spam bei Registrierung:<br>
               <font class="small">Soll Anti Spam bei der Registrierung werden?</font>
             </td>
             <td class="config" valign="top" width="50%">
               <select name="registration_antispam">
                 <option value="1"';
                 if ($config_arr[registration_antispam] == 1)
                   echo ' selected="selected"';
                 echo'>ein</option>
                 <option value="0"';
                   if ($config_arr[registration_antispam] == 0)
                   echo ' selected="selected"';
                 echo'>aus</option>
               </select>
             </td>
           </tr>
           <tr>
             <td class="config" valign="top" width="50%">
               Datum: <br>
               <font class="small">Datumsformat, das auf der Seite verwendet werden soll.</font>
             </td>
             <td class="config" valign="top" width="50%">
               <input class="text" size="40" name="date" maxlength="255" value="'.$config_arr[date].'"><br />
               <font class="small">verwendet den Syntax der PHP-Funktion <a href="http://www.php.net/manual/de/function.date.php" target="_blank" class="small">date()</a></font>
             </td>
           </tr>
           <tr>
             <td class="config" valign="top" width="50%">
               Seitenanzeige: <br>
               <font class="small">Design der Seitenanzeige bei mehrseitigen Anzeigen.</font>
             </td>
             <td class="config" valign="top" width="50%">
               <input class="text" size="40" name="page" maxlength="255" value="'.$config_arr[page].'"><br />
               <font class="small">{page_number} = aktuelle Seite; {prev} = Seite zurück <br />
               {total_pages} = Seitenzahl; {next} = Seite weiter</font>
             </td>
           </tr>
           <tr>
             <td class="config" valign="top" width="50%">
               Seite zurück: <br>
               <font class="small">Design der "Seite zurück" Schaltfläche.</font>
             </td>
             <td class="config" valign="top" width="50%">
               <input class="text" size="40" name="page_prev" maxlength="255" value="'.$config_arr[page_prev].'"><br />
               <font class="small">{url} = URL zur vorherigen Seite</font>
             </td>
           </tr>
           <tr>
             <td class="config" valign="top" width="50%">
               Seiter weiter: <br>
               <font class="small">Design der "Seite weiter" Schaltfläche.</font>
             </td>
             <td class="config" valign="top" width="50%">
               <input class="text" size="40" name="page_next" maxlength="255" value="'.$config_arr[page_next].'"><br />
               <font class="small">{url} = URL zur nächsten Seite</font>
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