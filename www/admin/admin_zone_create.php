<?php

//////////////////////////////
///// insert zone
//////////////////////////////

$index = mysql_query("select name from fs_zones ORDER BY name", $db);
while ($data = mysql_fetch_assoc($index))
{
  $forbidden_names_array[] = $data[name];
}
$forbidden_names_array[] = "admin";
$forbidden_names_array[] = "css";
$forbidden_names_array[] = "data";
$forbidden_names_array[] = "images";
$forbidden_names_array[] = "inc";

if ($_POST['name'] AND !in_array($_POST['name'], $forbidden_names_array))
{
  $_POST[name] = savesql($_POST[name]);
  

  if (mysql_query("INSERT INTO fs_zones
                          (name, design_id)
                          VALUES ('$_POST[name]', '$_POST[design_id]')", $db))
  {
    // read .htaccess
    $file = file ("../.htaccess");

    // edit .htaccess
    $file[] ='

';
    $file[] = 'RewriteRule ^'.$_POST[name].' $1/
';
    $file[] = 'RewriteRule ^'.$_POST[name].'/ index.php?zone='.$_POST[name].' [QSA]';

    
    // save .htaccess
    file_put_contents("../.htaccess", $file);

    systext("Die Zone wurde erfolgreich erstellt!");
  }
  else
  {
    systext("Es existiert bereits eine <b>Zone mit diesem Namen</b>!");
  }

}

//////////////////////////////
///// zone form
//////////////////////////////

else
{

$error_message = "";

if (isset($_POST['sended']))
{
  $error_message = "Bitte füllen Sie <b>alle Pflichfelder</b> aus!";
}

if (in_array($_POST['name'], $forbidden_names_array))
{
  $error_message = "Es existiert bereits eine <b>Zone mit diesem Namen</b> oder dieser <b>Name darf nicht verwendet werden</b>!";
}


  systext($error_message);
  echo'<form action="" method="post">
         <input type="hidden" value="zone_create" name="go">
         <input type="hidden" name="sended" value="">
         <table border="0" cellpadding="4" cellspacing="0" width="600">
           <tr align="left" valign="top">
             <td class="config" valign="top" width="30%">
               Name:<br>
               <font class="small">Der Name der Zone</font>
             </td>
             <td class="config" valign="top">
               <input class="text" size="40" name="name" maxlength="100" value="'.$_POST['name'].'" /><br>
               <font class="small"><b>Verbotene Namen:</b> admin, css, data, images, inc</font>
             </td>
           </tr>
           <tr>
             <td class="config" valign="top" width="30%">
               Design:<br>
               <font class="small">Die Darstellung der Zone</font>
             </td>
             <td class="config" valign="top">
               <select name="design_id" size="1">';

               $index = mysql_query("select id, name from fs_template ORDER BY id", $db);
               while ($admin_design_arr = mysql_fetch_assoc($index))
               {
                 echo '<option value="'.$admin_design_arr[id].'"';
                 if ($admin_design_arr[id] == $_POST[design_id]) {
                   echo ' selected=selected'; }
                 echo '>'.$admin_design_arr[name];
                 if ($admin_design_arr[id] == $global_config_arr[design]) {
                   echo ' (Standard Design)'; }
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