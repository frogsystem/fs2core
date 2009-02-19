<?php
////////////////////////////////
//// Image exists           ////
////////////////////////////////

function image_exists ( $PATH, $NAME )
{
    global $global_config_arr;

    $CHECK_PATH = $global_config_arr['path'] . $PATH;
    
    if (
            file_exists ( $CHECK_PATH . $NAME . ".jpg" ) ||
            file_exists ( $CHECK_PATH . $NAME . ".jpeg" ) ||
            file_exists ( $CHECK_PATH . $NAME . ".gif" ) ||
            file_exists ( $CHECK_PATH . $NAME . ".png" )
        )
    {
        return true;
    } else {
        return false;
    }
}

////////////////////////////////
//// Create Image URL       ////
////////////////////////////////

function image_url ( $PATH, $NAME, $ERROR = TRUE, $NO_URL = FALSE )
{
    global $global_config_arr;

    $CHECK_PATH = $global_config_arr['path'] . $PATH;
    
    if ( file_exists ( $CHECK_PATH . $NAME . ".jpg" ) ) {
        $url = $PATH . $NAME . ".jpg";
    }
    elseif ( file_exists ( $CHECK_PATH . $NAME . ".jpeg" ) ) {
        $url = $PATH . $NAME . ".jpeg";
    }
    elseif ( file_exists ( $CHECK_PATH . $NAME . ".gif" ) ) {
        $url = $PATH . $NAME . ".gif";
    }
    elseif ( file_exists ( $CHECK_PATH . $NAME . ".png" ) ) {
        $url = $PATH . $NAME . ".png";
    }
    elseif ( $ERROR == TRUE ) {
        $url = "images/icons/nopic_small.gif";
    }
    else {
        $url = "";
    }
    
    if ( $NO_URL == TRUE ) {
        $url = $global_config_arr['path'] . $url;
    } else {
        $url = $global_config_arr['virtualhost'] . $url;
    }

    return $url;
}

////////////////////////////////
//// Delete Image           ////
////////////////////////////////

function image_delete ( $PATH, $NAME )
{
    global $global_config_arr;

    $CHECK_PATH = $global_config_arr['path'] . $PATH;

    if ( file_exists ( $CHECK_PATH . $NAME . ".jpg" ) ) {
        $file = $CHECK_PATH . $NAME . ".jpg";
    }
    elseif ( file_exists ( $CHECK_PATH . $NAME . ".jpeg" ) ) {
        $file = $CHECK_PATH . $NAME . ".jpeg";
    }
    elseif ( file_exists ( $CHECK_PATH . $NAME . ".gif" ) ) {
        $file = $CHECK_PATH . $NAME . ".gif";
    }
    elseif ( file_exists ( $CHECK_PATH . $NAME . ".png" ) ) {
        $file = $CHECK_PATH . $NAME . ".png";
    } else {
        return false;
    }

    unlink ( $file );
    return true;
}

////////////////////////////////
//// Rename Image           ////
////////////////////////////////

function image_rename ( $PATH, $NAME, $NEWNAME )
{
    global $global_config_arr;

    if ( image_exists ( $PATH, $NAME ) && !image_exists ( $PATH, $NEWNAME ) ) {
        $extension = pathinfo ( image_url ( $PATH, $NAME, FALSE, TRUE ) );
        $extension = $extension['extension'];
        rename ( image_url ( $PATH, $NAME, FALSE, TRUE ), $global_config_arr['path'] . $PATH . $NEWNAME . "." . $extension );
        return true;
    } else {
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
    case 6:
      return $admin_phrases[common][image_6] ;
      break;
  }
}

////////////////////////////////
///// Pic Upload + Thumbnail ///
////////////////////////////////

function upload_img ( $IMAGE, $PATH, $NAME, $MAX_SIZE, $MAX_WIDTH, $MAX_HEIGHT, $QUALITY = 100, $THIS_SIZE = false )
{
    global $global_config_arr;
    
    // Get Image Data
    $image_data = getimagesize ( $IMAGE['tmp_name'] );
    switch ( $image_data[2] )
    {
        // Meaning of $image_data[2]:
        // 1 = GIF, 2 = JPG, 3 = PNG, 4 = SWF, 5 = PSD, 6 = BMP, etc.
        case 1: //GIF
            $type = "gif";
            break;
        case 2: //JPG
            $type = "jpg";
            break;
        case 3: //PNG
             $type = "png";
             break;
         default:
            return 1;  // Error 1: Ungültiger Dateityp!
             break 2;
    }

    // Check Options
     if ( $IMAGE['tmp_name'] != 0 ) {
        return 2;  // Error 2: Fehler beim Datei-Upload!
        break;
    }
    if ( $IMAGE['size'] > $MAX_SIZE ) {
        return 3;  // Error 3: Das Bild ist zu groß! (Dateigröße)
        break;
    }
    if ( $image_data[0] > $MAX_WIDTH || $image_data[1] > $MAX_HEIGHT ) {
        return 4;  // Error 4: Das Bild ist zu groß! (Abmessungen)
        break;
    }
     if ( $THIS_SIZE == TRUE && ( $image_data[0] != $MAX_WIDTH || $image_data[1] != $MAX_HEIGHT ) ) {
        return 5;  // Error 5: Das Bild ist entspricht nicht den erforderlichen Abmessungen!
        break;
    }

    // Create Image
    $full_path = $global_config_arr['path'] . $PATH . $NAME . "." . $type;
    move_uploaded_file ( $IMAGE['tmp_name'], $full_path );
    chmod ( $full_path, 0644 );
    clearstatcache();
    
    if ( image_exists ( $PATH, $NAME) ) {
        return 0; // Display 0: Das Bild wurde erfolgreich hochgeladen!
    } else {
        return 6; // Error 6: Fehler bei der Bild erstellung
    }
}

////////////////////////////
/// Create Thumb Meldung ///
////////////////////////////

function create_thumb_notice($upload)
{
  global $admin_phrases;
  
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