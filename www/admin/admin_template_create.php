<?php

/////////////////////////////////////
//// Template einfügen           ////
/////////////////////////////////////

if ($_POST['name'])
{
    $_POST[name] = savesql($_POST[name]);

    $index = mysql_query("SELECT COUNT(id) AS number FROM ".$global_config_arr[pref]."template WHERE name = '$_POST[name]'", $db);
    if (mysql_result($index,0,"number") == 0)
    {
        //Leeres Template
        if ($_POST['create_as'] == "new")
        {
            $index = mysql_query("SELECT id FROM ".$global_config_arr[pref]."template ORDER BY id DESC", $db);
            $id = mysql_result($index, "id");
            $id++;
            mysql_query("INSERT INTO ".$global_config_arr[pref]."template(id, name) VALUES ('$id', '$_POST[name]')", $db);
            systext("Das Design wurde erfolgreich erstellt!");
        }

        //Kopie
        elseif ($_POST['create_as'] == "copy")
        {
            mysql_query("INSERT INTO ".$global_config_arr[pref]."template
                         SELECT *
                         FROM ".$global_config_arr[pref]."template
                         WHERE id = '$_POST[design_id]'", $db);

            $index = mysql_query("SELECT id FROM ".$global_config_arr[pref]."template ORDER BY id DESC", $db);
            $id = mysql_result($index, "id");
            $id++;
            mysql_query("UPDATE ".$global_config_arr[pref]."template
                         SET name = '$_POST[name]',
                             id = '$id'
                         WHERE id = '$_POST[design_id]'
                         LIMIT 1", $db);
            systext("Das Design wurde erfolgreich erstellt!");
        }
    }
    else
    {
        systext("Es existiert bereits ein Design mit diesem Namen!");
    }
}


/////////////////////////////////////
////// Template Formular ////////////
/////////////////////////////////////

else
{

  systext($error_message);
  echo'<form action="" method="post">
         <input type="hidden" value="design_create" name="go">
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

               $index = mysql_query("select id, name from ".$global_config_arr[pref]."template ORDER BY id", $db);
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