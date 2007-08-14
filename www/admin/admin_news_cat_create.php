<?php

//////////////////////////////////
//// Neue Kategorie eintragen ////
//////////////////////////////////

if ($_POST['name'])
{
  $_POST[name] = savesql($_POST[name]);
  $_POST[description] = savesql($_POST[description]);

  mysql_query("INSERT INTO fs_news_cat
               (cat_name, cat_description)
               VALUES ('$_POST[name]', '$_POST[description]')", $db);

  systext("Kategorie wurde hinzugefügt");

  $index = mysql_query("select * from fs_news_config", $db);
  $admin_news_config_arr = mysql_fetch_assoc($index);

  $id = mysql_insert_id();

  if ($_FILES['cat_pic']['name'] != "")
  {
    $upload = upload_img($_FILES['cat_pic'], "../images/news_cat/", $id, 1024*1024, $admin_news_config_arr[cat_pic_x], $admin_news_config_arr[cat_pic_y], 0, 0, false);
    systext(upload_img_notice($upload));
  }
  else
  {
    systext('Es wurde kein Bild zum Upload ausgewählt.');
  }
  
}
else
{

  $error_message = "";

  if (isset($_POST['sended']))
  {
    $error_message = "Bitte füllen Sie alle Pflichfelder aus!";
  }
  
  systext($error_message);
  echo'<form action="'.$PHP_SELF.'" method="post" enctype="multipart/form-data">
         <input type="hidden" value="news_cat_create" name="go">
         <input type="hidden" name="sended" value="">
         <input type="hidden" value="'.session_id().'" name="PHPSESSID">
         <table border="0" cellpadding="4" cellspacing="0" width="600">
           <tr align="left" valign="top">
             <td class="config" valign="top" width="50%">
               Name:<br>
               <font class="small">Name der Kategorie</font>
             </td>
             <td class="config" valign="top" width="50%">
               <input class="text" size="40" name="name" maxlength="100" value="'.$_POST['name'].'" />
             </td>
           </tr>
           <tr align="left" valign="top">
             <td class="config" valign="top" width="50%">
               Bild: <font class="small">(optional)</font><br>
               <font class="small">Kategorie-Bild</font>
             </td>
             <td class="config" valign="top" width="50%">
               <input class="text" size="40" name="cat_pic" type="file" />
             </td>
           </tr>
           <tr align="left" valign="top">
             <td class="config" valign="top" width="50%">
               Beschreibung: <font class="small">(optional)</font><br>
               <font class="small">Beschreibung der Kategorie</font>
             </td>
             <td class="config" valign="top" width="50%">
               <textarea class="text" rows="2" cols="50" name="description" wrap="virtual">'.$_POST['description'].'</textarea>
             </td>
           </tr>
           <tr>
             <td colspan="2">
               <input class="button" type="submit" value="Hinzufügen">
             </td>
           </tr>
         </table>
       </form>
       ';
}
?>