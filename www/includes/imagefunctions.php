<?php
////////////////////////////////
//// Image exists           ////
////////////////////////////////

function image_exists($path, $name)
{
	if ( file_exists("$path"."$name.jpg") || file_exists("$path"."$name.jpeg") || file_exists("$path"."$name.gif") || file_exists("$path"."$name.png") ) {
		return true;
	} else {
		return false;
	}
}

////////////////////////////////
//// Create Image URL       ////
////////////////////////////////

function image_url ( $PATH, $NAME, $ERROR = TRUE )
{
	global $global_config_arr;

	if ( file_exists ( $PATH . $NAME . ".jpg" ) ) {
		$url = $PATH . $NAME . ".jpg";
	}
	elseif ( file_exists ( $PATH . $NAME . ".jpeg" ) ) {
		$url = $PATH . $NAME . ".jpeg";
	}
	elseif ( file_exists ( $PATH . $NAME . ".gif" ) ) {
		$url = $PATH . $NAME . ".gif";
	}
	elseif ( file_exists ( $PATH . $NAME . ".png" ) ) {
		$url = $PATH . $NAME . ".png";
	}
	elseif ( $ERROR == TRUE ) {
		$url = $global_config_arr['virtualhost'] . "images/icons/nopic_small.gif";
	}
	else {
		$url = "";
	}
	
	return $url;
}

////////////////////////////////
//// Delete Image           ////
////////////////////////////////

function image_delete($path, $name)
{
  if ( image_exists($path, $name) )
  {
    unlink(image_url($path, $name, false));
    return true;
  }
  else
  {
    return false;
  }
}

////////////////////////////////
//// Rename Image           ////
////////////////////////////////

function image_rename($path, $name, $newname)
{
  if ( image_exists($path, $name) && !image_exists($path, $newname) )
  {
    $extension = pathinfo(image_url($path, $name, false));
    $extension = $extension[extension];
    rename(image_url($path, $name, false), $path.$newname.".".$extension);
    return true;
  }
  else
  {
    return false;
  }
}


////////////////////////////
//// Pic Upload Meldung ////
////////////////////////////

function upload_img_notice($upload)
{
  global $admin_phrases;

  switch ($upload)
  {
    case 0:
      return $admin_phrases[common][image_0] ;
      break;
    case 1:
      return $admin_phrases[common][image_1] ;
      break;
    case 2:
      return $admin_phrases[common][image_2] ;
      break;
    case 3:
      return $admin_phrases[common][image_3] ;
      break;
    case 4:
      return $admin_phrases[common][image_4] ;
      break;
    case 5:
      return $admin_phrases[common][image_5] ;
      break;
  }
}

////////////////////////////////
///// Pic Upload + Thumbnail ///
////////////////////////////////

function upload_img($image, $image_path, $image_name, $image_max_size, $image_max_width, $image_max_height, $quality=100, $only_this_size = false)
{

  //Dateityp ermitteln
  
  $imgsize = getimagesize( $image['tmp_name'] );
  switch ($imgsize[2])
  {
    // Bedeutung von $imgsize[2]:
    // 1 = GIF, 2 = JPG, 3 = PNG, 4 = SWF, 5 = PSD, 6 = BMP, etc.
    case 1: //GIF
      $source_image = imagecreatefromgif($image['tmp_name']);
      $type="gif";
      break;
    case 2: //JPG
      $source_image = imagecreatefromjpeg($image['tmp_name']);
      $type="jpg";
      break;
    case 3: //PNG
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
  if ( (imagesx($source_image) > $image_max_width) || (imagesy($source_image) > $image_max_height) )
  {
    return 4;  // Fehler 4: Das Bild ist zu groß! (Abmessungen)
    break;
  }
  if ( $only_this_size == true AND ( (imagesx($source_image) != $image_max_width) OR (imagesy($source_image) != $image_max_height) ) )
  {
    return 5;  // Fehler 6: Das Bild ist entspricht nicht den erforderlichen Abmessungen!
    break;
  }

  //Bild erstellen

  $full_path = $image_path . $image_name . "." . $type;
  move_uploaded_file($image['tmp_name'], $full_path);
  chmod ($full_path, 0644);

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
      return $admin_phrases[common][thumb_0];
      break;
    case 1:
      return $admin_phrases[common][thumb_1];
      break;
    case 2:
      return $admin_phrases[common][thumb_2];
      break;
  }
}

///////////////////////////////////
///// Create Thumbnail from IMG ///
///////////////////////////////////

function create_thumb_from($image, $thumb_max_width, $thumb_max_height, $quality=100)
{
  //Bilddaten ermitteln
  $image_info = pathinfo($image);
  $image_info['name'] = basename ($image, ".".$image_info["extension"]);
  $imgsize = getimagesize($image);

  //Dateityp ermitteln
  switch ($imgsize[2])
  {
    // Bedeutung von $imgsize[2]:
    // 1 = GIF, 2 = JPG, 3 = PNG, 4 = SWF, 5 = PSD, 6 = BMP, etc.
    case 1: //GIF
      $source = ImageCreateFromGIF($image);
      break;
    case 2: //JPG
      $source = ImageCreateFromJPEG($image);
      break;
    case 3: //PNG
      $source = ImageCreateFromPNG($image);
      break;
    default:
      return 1;  // Fehler 1: Ungültiger Dateityp!
      break 2;
  }


  //Abmessungen des Thumbnails ermitteln
  $imgratio = $imgsize[0] / $imgsize[1];
  $newwidth = $thumb_max_width;
  $newheight = $thumb_max_height;

  //Querformat
  if ($imgratio > 1)
  {
    if ($thumb_max_width/$imgratio <= $thumb_max_height) {
      $newheight = $thumb_max_width/$imgratio;
    } else {
      $newwidth = $thumb_max_height*$imgratio;
    }
  }
  //Hochformat
  else
  {
    if ($thumb_max_height*$imgratio <= $thumb_max_width) {
      $newwidth = $thumb_max_height*$imgratio;
    } else {
      $newheight = $thumb_max_width/$imgratio;
    }
  }

  //Bild ist kleiner als max. Thumbgröße
  if ($imgsize[0] <= $thumb_max_width AND $imgsize[1] <= $thumb_max_height)
  {
    $newwidth = $imgsize[0];
    $newheight = $imgsize[1];
  }


  //Thumbnail-Container erstellen
  $thumb_path = $image_info['dirname']."/".$image_info['name']."_s.".$image_info['extension'];
  $thumb = ImageCreateTrueColor($newwidth, $newheight);

  //Individuelle Funktionen je nach Dateityp aufrufen
  switch ($imgsize[2])
  {
    case 1: //GIF
      $gif_transparency = imagecolortransparent($source);
      if ($gif_transparency >= 0) {
        ImageColorTransparent($thumb, ImageColorAllocate($thumb, 0, 0, 0));
        ImageAlphaBlending($thumb, true);
        ImageSaveAlpha($thumb, true);
      }
      break;
    case 2: //JPG
      break;
    case 3: //PNG
      ImageColorTransparent($thumb, ImageColorAllocate($thumb, 0, 0, 0));
      ImageAlphaBlending($thumb, false);
      ImageSaveAlpha($thumb, true);
      break;
    default:
      return 1;  // Fehler 1: Ungültiger Dateityp!
      break 2;
  }

  //Thumbnail verkleinern
  imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $imgsize[0], $imgsize[1]);

  //Thumbnail je nach Dateityp erstellen
  switch ($imgsize[2])
  {
    case 1: //GIF
      if (!imagegif($thumb, $thumb_path, $quality)) {
        return 2;  // Fehler 2: Es konnte kein Thumbnail erstellt werden!
        break 2;
      }
      break;
    case 2: //JPG
      if (!imagejpeg($thumb, $thumb_path, $quality)) {
        return 2;  // Fehler 2: Es konnte kein Thumbnail erstellt werden!
        break 2;
      }
      break;
    case 3: //PNG
      if (!imagepng($thumb, $thumb_path)) {
        return 2;  // Fehler 2: Es konnte kein Thumbnail erstellt werden!
        break 2;
      }
      break;
    default:
      return 1;  // Fehler 1: Ungültiger Dateityp!
      break 2;
  }

  //Chmod setzen & Cache leeren
  chmod ($thumb_path, 0644);
  clearstatcache();

  return 0; // Ausgabe 0: Das Thumb wurde erfolgreich erstellt!
}
?>