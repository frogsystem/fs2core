<?php

/////////////////////////////////////
//// Template einfügen           ////
/////////////////////////////////////

if ($_POST['name'] AND !file_exists("../css/$_POST[name].css"))
{
  $_POST[name] = savesql($_POST[name]);
  $file = "../css/$_POST[name].css";

  //Leeres Template
  if ($_POST['create_as'] == "new")
  {

    if (!$handle = fopen($file, "w"))
    {
      systext("Das Template konnte nicht erstellt werden!");
      exit;
    }
    else
    {
      $index = mysql_query("select id from fs_template ORDER BY id DESC", $db);
      $id = mysql_result($index, "id");
      $id++;
      mysql_query("INSERT INTO fs_template
                   (id, name)
                   VALUES ('$id', '$_POST[name]')", $db);
      systext("Das Template wurde erfolgreich erstellt!");
    }
    fclose($handle);
  }
  
  //Kopie
  elseif ($_POST['create_as'] == "copy")
  {
    $index = mysql_query("select name from fs_template WHERE id = '$_POST[design_id]'", $db);
    $design_name = mysql_result($index, "name");

    $css_content = file_get_contents("../css/$design_name.css");
    
    if (!$handle = fopen($file, "w"))
    {
      systext("Das Template konnte nicht erstellt werden!");
      exit;
    }
    else
    {
      if (!fwrite($handle, $css_content) AND $css_content != "")
      {
        systext("Das Template konnte nicht erstellt werden!");
        exit;
      }
      
      mysql_query("INSERT INTO fs_template
                     SELECT *
                     FROM fs_template
                     WHERE id = '$_POST[design_id]'", $db);

      $index = mysql_query("select id from fs_template ORDER BY id DESC", $db);
      $id = mysql_result($index, "id");
      $id++;
      mysql_query("UPDATE fs_template
                   SET name = '$_POST[name]',
                       id = '$id'
                   WHERE id = '$_POST[design_id]'
                   LIMIT 1", $db);

      systext("Das Template wurde erfolgreich erstellt!");
    }
    fclose($handle);
  }
  
}

/////////////////////////////////////
////// Template Formular ////////////
/////////////////////////////////////

else
{

  $error_message = "";

  if (isset($_POST['sended']))
  {
    $error_message = "Bitte füllen Sie <b>alle Pflichfelder</b> aus!";
  }
  if (file_exists("../css/$_POST[name].css"))
  {
    $error_message = "Es existiert bereits ein <b>Template mit diesem Namen</b>!";
  }

  systext($error_message);
  echo'<form action="" method="post">
         <input type="hidden" value="template_create" name="go">
         <input type="hidden" name="sended" value="">
         <input type="hidden" value="'.session_id().'" name="PHPSESSID">
         <table border="0" cellpadding="4" cellspacing="0" width="600">
           <tr align="left" valign="top">
             <td class="config" valign="top" width="30%">
               Name:<br>
               <font class="small">Der Name des Designs</font>
             </td>
             <td class="config" valign="top">
               <input class="text" size="40" name="name" maxlength="100" value="'.$_POST['name'].'" />
             </td>
           </tr>
           <tr>
             <td class="config" valign="top" width="30%">
               Erstellen als:
             </td>
             <td class="config" valign="top">
               <input type="radio" name="create_as" value="new" checked="checked" /> leeres Design<br>
               <input type="radio" name="create_as" value="copy" /> Kopie eines bestehenden Designs:
               <select name="design_id" size="1">';

               $index = mysql_query("select id, name from fs_template ORDER BY id", $db);
               while ($admin_design_arr = mysql_fetch_assoc($index))
               {
                 echo '<option value="'.$admin_design_arr[id].'"';
                 if ($admin_design_arr[id] == $global_config_arr[design]) {
                   echo ' selected=selected'; }
                 echo '>'.$admin_design_arr[name];
                 if ($admin_design_arr[id] == $global_config_arr[design]) {
                   echo ' (aktiv)'; }
                 echo '</option>';
               }
  echo'
           </select><br><br>
           
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