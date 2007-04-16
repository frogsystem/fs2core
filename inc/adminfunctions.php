<?php

////////////////////////
//// Insert Tooltip ////
////////////////////////

function insert_tt($title,$text)
{
   return '
'.$title.' <span class="tooltip">
<img border="0" src="img/help.gif" alt="?">&nbsp;
<span>
 <img border="0" src="img/pointer.gif" alt="->"> <b>'.$title.'</b><br />'.$text.'
</span></span>
<br>
   ';
}


////////////////////////////////
//// Systemmeldung ausgeben ////
////////////////////////////////

function systext($text)
{
   echo '
                    <table border="0" cellpadding="4" cellspacing="0" width="400">
                        <tr>
                            <td class="config" style="text-align:center;">
                                '.$text.'
                            </td>
                        </tr>
                    </table>
                    <p>
   ';
}

////////////////////////////////
//// Seitentitel generieren  ///
//// und Berechtigung prüfen ///
////////////////////////////////

function createpage($title, $permission, $page)
{
 global $pagetitle;
 global $filetoinc;
 $pagetitle = $title; 
 if ($permission == 1) $filetoinc = $page; 
 else $filetoinc = 'admin_error.php';
}

////////////////////////////////
//// Menü erzeugen           ///
////////////////////////////////

function createmenu($admin_arr)
{
    if (createmenu_perm($admin_arr[perm])) {
        createmenu_head($admin_arr[title], $admin_arr[id]);
        echo '<tr><td width="100%"><div id="'.$admin_arr[id].'" class="toggle">';
    }
}

////////////////////////////////
//// Menüende erzeugen       ///
////////////////////////////////

function createmenu_end($admin_arr)
{
    if (createmenu_perm($admin_arr[perm])) {
        echo '</div></td></tr>';
    }
}

////////////////////////////////
//// Menüende Permission     ///
////////////////////////////////

function createmenu_perm($perm_arr)
{
    $givePermission = false;
    foreach ($perm_arr as $value) {
        if ($_SESSION[$value] == 1) {
            $givePermission = true;
        } else {
            $givePermission = false;
        }
    }
    if ($perm_arr[0] === true) {
        $givePermission = true;
    }
    return $givePermission;
}




////////////////////////////////
//// Menü-Überschrift        ///
//// erzeugen                ///
////////////////////////////////

function createmenu_head($title, $toggle)
{
 echo '
                <tr>
                    <td width="100%" height="15"></td>
                </tr>
                 <tr>
                    <td width="100%">
                        <a class="menuhead" href="javascript:toggleMenu(\''.$toggle.'\')">
                        <img border="0" src="img/pointer.gif" width="5" height="8" alt="" id="timg_'.$toggle.'">
                        '.$title.'</a>
                    </td>
                </tr>

 ';
}

////////////////////////////////
//// Seitenlink generieren   ///
//// und Berechtigung prüfen ///
////////////////////////////////

function createlink($page_call, $page_link_title = false, $page_link_url = false, $page_link_perm = false)
{
  global $db;
   
  $index = mysql_query("SELECT * FROM fs_admin_cp WHERE page_call = '$page_call' LIMIT 0,1", $db);
  $createlink_arr = mysql_fetch_assoc($index);

  if ($createlink_arr[permission]!=1)
  {
      $createlink_arr[permission] = $_SESSION[$createlink_arr[permission]];
  }

  if ($page_link_perm!=false)
  {
      $createlink_arr[permission] = $page_link_perm;
  }

  if ($page_link_title!=false)
  {
      $createlink_arr[link_title] = $page_link_title;
  }
  
  if ($page_link_url!=false)
  {
      $createlink_arr[page_call] = $page_link_url;
  }
  
  if ($createlink_arr[permission] == 1)
  {
      echo'

                        <a class="menu" href="'.$PHP_SELF.'?go='.$createlink_arr[page_call].'">
                            '.$createlink_arr[link_title].'
                        </a><br />

     ';
  }
}


////////////////////////////
//// Pic Upload Meldung ////
////////////////////////////

function upload_img_notice($upload)
{
  switch ($upload)
  {
    case 0:
      return "Das Bild wurde erfolgreich hochgeladen!";
      break;
    case 1:
      return "Ungültiger Dateityp!";
      break;
    case 2:
      return "Fehler bei der Bilderstellung!";
      break;
    case 3:
      return "Das Bild ist zu groß! (Dateigröße)";
      break;
    case 4:
      return "Das Bild ist zu groß! (Abmessungen)";
      break;
    case 5:
      return "Es konnte kein Thumbnail erstellt werden!";
      break;
    case 6:
      return "Das Bild ist entspricht nicht den erforderlichen Abmessungen!";
      break;
  }
}

////////////////////////////////
///// Pic Upload + Thumbnail ///
////////////////////////////////

function upload_img($image, $image_path, $image_name, $image_max_size, $image_max_width, $image_max_height, $thumb_max_width, $thumb_max_height, $create_thumb=true, $quality=100, $only_this_size = false)
{

  //Dateityp ermitteln

  switch ($image['type'])
  {
    case "image/jpeg":
      $source_image = imagecreatefromjpeg($image['tmp_name']);
      $type="jpg";
      break;
    case "image/gif":
      $source_image = imagecreatefromgif($image['tmp_name']);
      $type="gif";
      break;
    case "image/png":
      $source_image = imagecreatefrompng($image['tmp_name']);
      $type="png";
      break;
    default:
      return 1;  // Fehler 1: Ungültiger Dateityp!
      break 2;
  }

  //Fehler überprüfung

  if (!isset($source_image))
  {
    return 2;  // Fehler 2: Fehler bei der Bilderstellung!
    break;
  }
  if ($image['size'] > $image_max_size)
  {
    return 3;  // Fehler 3: Das Bild ist zu groß! (Dateigröße)
    break;
  }
  if ( (imagesx($source_image) > $image_max_width) && (imagesy($source_image) > $image_max_height) )
  {
    return 4;  // Fehler 4: Das Bild ist zu groß! (Abmessungen)
    break;
  }
  if ( $only_this_size == true AND ( (imagesx($source_image) != $image_max_width) OR (imagesy($source_image) != $image_max_height) ) )
  {
    return 6;  // Fehler 6: Das Bild ist entspricht nicht den erforderlichen Abmessungen!
    break;
  }

  //Bild erstellen

  $full_path = $image_path . $image_name . "." . $type;
  move_uploaded_file($image['tmp_name'], $full_path);
  chmod ($full_path, 0644);
  clearstatcache();

  //Thumbnail erstellen

  if ($create_thumb == true)
  {

    //Abmessungen des Thumbnails ermitteln

    $imgratio = imagesx($source_image) / imagesy($source_image);

    if ($imgratio > 1)  //Querformat
    {
      if ($thumb_max_width/$imgratio <= $thumb_max_height)
      {
        $newwidth = $thumb_max_width;
        $newheight = $thumb_max_width/$imgratio;
      }
      else
      {
        $newheight = $thumb_max_height;
        $newwidth = $thumb_max_height*$imgratio;
      }
    }

    else  //Hochformat
    {
      if ($thumb_max_height*$imgratio <= $thumb_max_width)
      {
        $newheight = $thumb_max_height;
        $newwidth = $thumb_max_height*$imgratio;
      }
      else
      {
        $newwidth = $thumb_max_width;
        $newheight = $thumb_max_width/$imgratio;
      }
    }
    
    if (imagesx($source_image) <= $thumb_max_width AND imagesy($source_image) <= $thumb_max_height)
    {
        $newwidth = imagesx($source_image);
        $newheight = imagesy($source_image);
    }

    //Thumbnail je nach Dateityp erstellen

    if ($type=="jpg")
    {
      $thumb = ImageCreateTrueColor($newwidth,$newheight);
      $source = imagecreatefromjpeg($full_path);
      imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, imagesx($source), imagesy($source));
      $thumb_path = "$image_path"."$image_name"."_s.$type";
      imagejpeg($thumb, $thumb_path, $quality);
      chmod ($thumb_path, 0644);
      clearstatcache();
    }
    elseif ($type=="gif")
    {
      $thumb = ImageCreateTrueColor($newwidth,$newheight);
      $source = imagecreatefromgif($full_path);
      imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, imagesx($source), imagesy($source));
      $thumb_path = "$image_path"."$image_name"."_s.$type";
      imagegif($thumb, $thumb_path, $quality);
      chmod ($thumb_path, 0644);
      clearstatcache();
    }
    elseif ($type=="png")
    {
      $thumb = ImageCreateTrueColor($newwidth,$newheight);
      $source = imagecreatefrompng($full_path);
      imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, imagesx($source), imagesy($source));
      $thumb_path = "$image_path"."$image_name"."_s.$type";
      imagepng($thumb, $thumb_path, $quality);
      chmod ($thumb_path, 0644);
      clearstatcache();
    }
    else
    {
      return 5;  // Fehler 5: Es konnte kein Thumbnail erstellt werden!
      break;
    }

  }
  return 0; // Ausgabe 0: Das Bild wurde erfolgreich hochgeladen!
  clearstatcache();
}

////////////////////////////
/// Create Thumb Meldung ///
////////////////////////////

function create_thumb_notice($upload)
{
  switch ($upload)
  {
    case 0:
      return "Das Thumbnail wurde erfolgreich erstellt!";
      break;
    case 1:
      return "Thumbnail: Ungültiger Dateityp!";
      break;
    case 2:
      return "Fehler bei der Thumbnailerstellung!";
      break;
  }
}


///////////////////////////////////
///// Create Thumbnail from IMG ///
///////////////////////////////////

function create_thumb_from($image, $thumb_max_width, $thumb_max_height, $quality=100)
{
  $image_info = pathinfo($image);

  //Dateityp ermitteln

  switch ($image_info['extension'])
  {
    case "jpeg":
      $source_image = imagecreatefromjpeg($image);
      $image_info['name'] = basename ($image,".jpeg");
      break;
    case "jpg":
      $source_image = imagecreatefromjpeg($image);
      $image_info['name'] = basename ($image,".jpg");
      break;
    case "gif":
      $source_image = imagecreatefromgif($image);
      $image_info['name'] = basename ($image,".gif");
      break;
    case "png":
      $source_image = imagecreatefrompng($image);
      $image_info['name'] = basename ($image,".png");
      break;
    default:
      return 1;  // Fehler 1: Ungültiger Dateityp!
      break 2;
  }

  //Thumbnail erstellen

    //Abmessungen des Thumbnails ermitteln

    $imgratio = imagesx($source_image) / imagesy($source_image);

    if ($imgratio > 1)  //Querformat
    {
      if ($thumb_max_width/$imgratio <= $thumb_max_height)
      {
        $newwidth = $thumb_max_width;
        $newheight = $thumb_max_width/$imgratio;
      }
      else
      {
        $newheight = $thumb_max_height;
        $newwidth = $thumb_max_height*$imgratio;
      }
    }

    else  //Hochformat
    {
      if ($thumb_max_height*$imgratio <= $thumb_max_width)
      {
        $newheight = $thumb_max_height;
        $newwidth = $thumb_max_height*$imgratio;
      }
      else
      {
        $newwidth = $thumb_max_width;
        $newheight = $thumb_max_width/$imgratio;
      }
    }
    

    if (imagesx($source_image) <= $thumb_max_width AND imagesy($source_image) <= $thumb_max_height)
    {
        $newwidth = imagesx($source_image);
        $newheight = imagesy($source_image);
    }


    //Thumbnail je nach Dateityp erstellen

    if ($image_info['extension']=="jpg" OR $image_info['extension']=="jpeg")
    {
      $thumb = ImageCreateTrueColor($newwidth,$newheight);
      $source = imagecreatefromjpeg($image);
      imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, imagesx($source), imagesy($source));
      $thumb_path = $image_info['dirname']."/".$image_info['name']."_s.".$image_info['extension'];
      imagejpeg($thumb, $thumb_path, $quality);
      chmod ($thumb_path, 0644);
      clearstatcache();
    }
    elseif ($image_info['extension']=="gif")
    {
      $thumb = ImageCreateTrueColor($newwidth,$newheight);
      $source = imagecreatefromgif($image);
      imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, imagesx($source), imagesy($source));
      $thumb_path = $image_info['dirname']."/".$image_info['name']."_s.".$image_info['extension'];
      imagegif($thumb, $thumb_path, $quality);
      chmod ($thumb_path, 0644);
      clearstatcache();
    }
    elseif ($image_info['extension']=="png")
    {
      $thumb = ImageCreateTrueColor($newwidth,$newheight);
      $source = imagecreatefrompng($image);
      imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, imagesx($source), imagesy($source));
      $thumb_path = $image_info['dirname']."/".$image_info['name']."_s.".$image_info['extension'];
      imagepng($thumb, $thumb_path, $quality);
      chmod ($thumb_path, 0644);
      clearstatcache();
    }
    else
    {
      return 2;  // Fehler 2: Es konnte kein Thumbnail erstellt werden!
      break;
    }

  return 0; // Ausgabe 0: Das Bild wurde erfolgreich hochgeladen!
  clearstatcache();
}

////////////////////////////////
//////// Cookie setzen /////////
////////////////////////////////

function admin_set_cookie($username, $password)
{
    global $db;

    $username = savesql($username);
    $password = savesql($password);
    $index = mysql_query("select * from fs_user where user_name = '$username'", $db);
    $rows = mysql_num_rows($index);
    if ($rows == 0)
    {
        return false;
    }
    else
    {
        $dbisadmin = mysql_result($index, 0, "is_admin");
        if ($dbisadmin == 1)
        {
            $password = md5($password);
            $dbuserpass = mysql_result($index, 0, "user_password");
            $dbuserid = mysql_result($index, 0, "user_id");
            if ($password == $dbuserpass)
            {
                $inhalt = $password . $username;
                setcookie ("login", $inhalt, time()+2592000, "/");
                return true;  // Login akzeptiert
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }
}

////////////////////////////////
/////// Logindaten prüfen //////
////////////////////////////////

function admin_login($username, $password, $iscookie)
{
    global $db;

    $username = savesql($username);
    $password = savesql($password);
    $index = mysql_query("select * from fs_user where user_name = '$username'", $db);
    $rows = mysql_num_rows($index);
    if ($rows == 0)
    {
        return 1;  // Fehlercode 1: User nicht vorhanden
    }
    else
    {
        $dbisadmin = mysql_result($index, 0, "is_admin");
        if ($dbisadmin == 1)
        {
            if ($iscookie===false)
            {
                $password = md5($password);
            }
            $dbuserpass = mysql_result($index, 0, "user_password");
            $dbuserid = mysql_result($index, 0, "user_id");
            if ($password == $dbuserpass)
            {
                $_SESSION["user_level"] = "authorised";
                fillsession($dbuserid);
                return 0;  // Login akzeptiert
            }
            else
            {
                return 2;  // Fehlercode 2: Falsches Passwort
            }
        }
        else
        {
            return 3;  // Fehlercode 3: Keine Zugriffsrechte auf die Admin
        }
    }
}

////////////////////////////////
//////// Session füllen ////////
////////////////////////////////

function fillsession($uid)
{
   global $db;
   global $data;
   $dbaction = "select * from fs_user where user_id = " . $uid;
   $usertableindex2 = mysql_query($dbaction, $db);

   $_SESSION["user_id"] = $uid;
   $dbusername = mysql_result($usertableindex2, 0, "user_name");
   $_SESSION["user_name"] = $dbusername;
   $dbuserpass = mysql_result($usertableindex2, 0, "user_password");
   $_SESSION["user_pass"] = $dbuserpass;
   $dbusermail = mysql_result($usertableindex2, 0, "user_mail");
   $_SESSION["user_mail"] = $dbusermail;

   $result = mysql_list_fields($data,"fs_permissions");
   $menge = mysql_num_fields($result);
   for($x=1;$x<$menge;$x++)
   {
    $fieldname = mysql_field_name($result,$x);
    $index = mysql_query("select $fieldname from fs_permissions where user_id = $uid", $db);
    $_SESSION[$fieldname] = mysql_result($index, 0, $fieldname);
   }
}

function fetchTemplateTags($template) {
        preg_match_all('/{(.*?)}/', $template, $matches);
        $string = '';
        $array = array_unique($matches['0']);
        //$array = $matches['0'];
        foreach ($array as $match)
                $string .= " ".$match;
        
        return $string;
}

?>