<?php
////////////////////////////////
//// Systemmeldung ausgeben ////
////////////////////////////////

function systext ( $MESSAGE, $TITLE = FALSE, $RED = FALSE )
{
    global $admin_phrases;

	if ( $TITLE == FALSE ) {
		$TITLE = $admin_phrases[common][system_message];
	}

	if ( $RED == TRUE ) {
		$class = "line_red";
	} else {
		$class = "line";
	}
	

	echo '
					<table class="configtable" cellpadding="4" cellspacing="0">
						<tr><td class="'.$class.'">'.$TITLE.'</td></tr>
						<tr><td class="config">'.$MESSAGE.'</td></tr>
						<tr><td class="space"></td></tr>
                    </table>
	';
}

////////////////////////////////
//// Systemmeldung ausgeben ////
////////////////////////////////

function js_timebutton ( $DATA, $CAPTION, $CLASS = "button" )
{
	$template = '<input class="'.$CLASS.'" type="button" value="'.$CAPTION.'" onClick="';

	foreach ( $DATA as $key => $value )
    {
		$template .= "document.getElementById('".$key."').value='".$value."';";
	}

    $template .= '">';

	return $template;
}

////////////////////////////
//// Update from $_POST ////
////////////////////////////

function getfrompost ( $ARRAY )
{
	foreach ( $ARRAY as $key => $value  )
	{
        $ARRAY[$key] = $_POST[$key];
	}
	return $ARRAY;
}

////////////////////////////////
//// Create textarea        ////
////////////////////////////////

function create_editor($name, $text="", $width="", $height="", $class="", $do_smilies=true)
{
    global $global_config_arr;
    global $db;

    if ($name != "") {
        $name2 = 'name="'.$name.'" id="'.$name.'"';
    } else {
        return false;
    }

    if ( $width != "" && is_int ( $width ) ) {
        $width2 = 'width:'.$width.'px;';
    } elseif ( $width != "" ) {
        $width2 = 'width:'.$width.';';
	}

    if ( $height != "" && is_int ( $height ) ) {
        $height2 = 'height:'.$height.'px;';
    } elseif ( $width != "" ) {
        $height2 = 'height:'.$height.';';
	}

    if ($class != "") {
        $class2 = 'class="'.$class.'"';
    }

    $style = $name2.' '.$class2.' style="'.$width2.' '.$height2.'"';

  $smilies = "";
  if ($do_smilies == true)
  {
    $smilies = '
    <td style="padding-left: 4px;">
      <fieldset style="width:46px;">
        <legend class="small" align="left"><font class="small">Smilies</font></legend>
          <table cellpadding="2" cellspacing="0" border="0" width="100%">';

    $zaehler = 0;
    $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."smilies ORDER by `order` ASC LIMIT 0, 10", $db);
    while ($smilie_arr = mysql_fetch_assoc($index))
    {
        $smilie_arr[url] = image_url("../images/smilies/", $smilie_arr[id]);

        $smilie_template = '<td><img src="'.$smilie_arr[url].'" alt="'.$smilie_arr[replace_string].'" onClick="insert(\''.$name.'\', \''.$smilie_arr[replace_string].'\', \'\')" class="editor_smilies" /></td>';

        $zaehler += 1;
        switch ($zaehler)
        {
            case 1:
                $smilies .= "<tr align=\"center\">\n\r";
                $smilies .= $smilie_template;
                break;
             case 2:
                $zaehler = 0;
                $smilies .= $smilie_template;
                $smilies .= "</tr>\n\r";
                break;
        }
    }
    unset($smilie_arr);
    unset($smilie_template);
    unset($config_arr);

    $smilies .= '</table></fieldset></td>';
  }
  
    $buttons = "";
    $buttons .= create_editor_button('images/icons/bold.gif', "B", "fett", "insert('$name', '[b]', '[/b]')");
    $buttons .= create_editor_button('images/icons/italic.gif', "I", "kursiv", "insert('$name', '[i]', '[/i]')");
    $buttons .= create_editor_button('images/icons/underline.gif', "U", "unterstrichen", "insert('$name','[u]','[/u]')");
    $buttons .= create_editor_button('images/icons/strike.gif', "S", "durgestrichen", "insert('$name', '[s]', '[/s]')");
    $buttons .= create_editor_seperator();
    $buttons .= create_editor_button('images/icons/center.gif', "CENTER", "zentriert", "insert('$name', '[center]', '[/center]')");
    $buttons .= create_editor_seperator();
    $buttons .= create_editor_button('images/icons/font.gif', "FONT", "Schriftart", "insert_com('$name', 'font', 'Bitte gib die gewünschte Schriftart ein:', '')");
    $buttons .= create_editor_button('images/icons/color.gif', "COLOR", "Schriftfarbe", "insert_com('$name', 'color', 'Bitte gib die gewünschte Schriftfarbe (englisches Wort) ein:', '')");
    $buttons .= create_editor_button('images/icons/size.gif', "SIZE", "Schriftgröße", "insert_com('$name', 'size', 'Bitte gib die gewünschte Schriftgröße (Zahl von 0-7) ein:', '')");
    $buttons .= create_editor_seperator();
    $buttons .= create_editor_button('images/icons/img.gif', "IMG", "Bild einfügen", "insert_mcom('$name', '[img]', '[/img]', 'Bitte gib die URL zu der Grafik ein:', 'http://')");
    $buttons .= create_editor_button('images/icons/cimg.gif', "CIMG", "Content-Image einfügen", "insert_mcom('$name', '[cimg]', '[/cimg]', 'Bitte gib den Namen des Content-Images (mit Endung) ein:', '')");
    $buttons .= create_editor_seperator();
    $buttons .= create_editor_button('images/icons/url.gif', "URL", "Link einfügen", "insert_com('$name', 'url', 'Bitte gib die URL ein:', 'http://')");
    $buttons .= create_editor_button('images/icons/home.gif', "HOME", "Projektinternen Link einfügen", "insert_com('$name', 'home', 'Bitte gib den projektinternen Verweisnamen ein:', '')");
    $buttons .= create_editor_button('images/icons/email.gif', "@", "Email-Link einfügen", "insert_com('$name', 'email', 'Bitte gib die Email-Adresse ein:', '')");
    $buttons .= create_editor_seperator();
    $buttons .= create_editor_button('images/icons/code.gif', "C", "Code-Bereich einfügen", "insert('$name', '[code]', '[/code]')");
    $buttons .= create_editor_button('images/icons/quote.gif', "Q", "Zitat einfügen", "insert('$name', '[quote]', '[/quote]')");
    $buttons .= create_editor_button('images/icons/noparse.gif', "N", "Nicht umzuwandelnden Bereich einfügen", "insert('$name', '[noparse]', '[/noparse]')");


    $textarea = '<table cellpadding="0" cellspacing="0" border="0" style="padding-bottom:4px">
                     <tr valign="bottom">
                         {buttons}
                     </tr>
                 </table>
                 <table cellpadding="0" cellspacing="0" border="0" width="100%">
                     <tr valign="top">
                         <td width="100%">
                             <textarea {style}>{text}</textarea>
                         </td>
                         {smilies}
                     </tr>
                 </table><br />';
    
    $textarea = str_replace("{style}", $style, $textarea);
    $textarea = str_replace("{text}", $text, $textarea);
    $textarea = str_replace("{buttons}", $buttons, $textarea);
    $textarea = str_replace("{smilies}", $smilies, $textarea);

    return $textarea;
}


////////////////////////////////
//// Create textarea Button ////
////////////////////////////////

function create_editor_button($img_url, $alt, $title, $insert)
{
    global $global_config_arr;
    $javascript = 'onClick="'.$insert.'"';

    $button = '
    <td class="editor_td">
        <div class="ed_button" {javascript}>
            <img src="{img_url}" alt="{alt}" title="{title}" />
        </div>
    </td>';
    $button = str_replace("{img_url}", $global_config_arr[virtualhost].$img_url, $button);
    $button = str_replace("{alt}", $alt, $button);
    $button = str_replace("{title}", $title, $button);
    $button = str_replace("{javascript}", $javascript, $button);

    return $button;
}


////////////////////////////////////
//// Create textarea  Seperator ////
////////////////////////////////////

function create_editor_seperator()
{
    $seperator = '<td class="editor_td_seperator"></td>';
    return $seperator;
}


////////////////////////
//// Insert Tooltip ////
////////////////////////

function insert_tt($title,$text,$form)
{
   return '
'.$title.' <a class="tooltip" href="#">
<img border="0" src="img/help.png" align="top" />&nbsp;
<span>
 <img border="0" src="img/pointer.png" align="top" alt="->" /> <b>'.$title.'</b><br />'.$text.'
</span></a>
&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:insert(\''.$form.'\',\''.$title.'\',\'\');"><img border="0" src="img/pointer.png" alt="->" title="einfügen" align="top" /></a>
<br />
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

function createmenu($menu_arr)
{
    global $go;
    global $session_url;
    
    end ($menu_arr);
    $end = key($menu_arr);
    reset ($menu_arr);

    foreach ($menu_arr as $key => $value)
    {
        if ($value[show] == true AND $_SESSION["user_level"] == "authorised")
        {
        	if ($key == $end) {
         		$align = "_right";
            }
            $menu_class = "menu_link".$align ;
            if ($_REQUEST['mid']==$value[id] AND ($go!="login" OR $_SESSION["user_level"] == "authorised")) {
                $menu_class = "menu_link_selected".$align;
            }
            $template .= '<td align="right"><a href="'.$PHP_SELF.'?mid='.$value[id].$session_url.'" target="_self" class="'.$menu_class.'">'.$value[title].'</a></td>';
        }
    }

    echo $template;
    unset($template);
}

////////////////////////////////
//// Menu ermitteln          ///
////////////////////////////////

function createmenu_show2arr($navi_arr)
{
    unset($template);

    foreach ($navi_arr[link] as $value)
    {
        $template .= createlink($value);
    }


    if ($template == "") {
        $show_arr[state] = false;
    } else {
        $show_arr[state] = true;
    }
    $show_arr[menu_id] = $navi_arr[menu_id];
    return $show_arr;
}

////////////////////////////////
//// Menü anzeigen           ///
////////////////////////////////

function createmenu_show($show_arr,$menu_id)
{
    foreach ($show_arr as $value)
    {
        if ($value[menu_id] == $menu_id AND $value[state] == true) {
            return true;
        }
    }
    return false;
}

////////////////////////////////
//// Navi erzeugen           ///
////////////////////////////////

function createnavi($navi_arr, $first)
{
    unset($template);

    if ($navi_arr[menu_id] == $_REQUEST['mid'] AND $_SESSION["user_level"] == "authorised") {
        foreach ($navi_arr[link] as $value)
        {
            $template .= createlink($value);
        }

        if ($first == true) {
            $headline_img = "navi_top";
        } else {
            $headline_img = "navi_headline";
        }
    }
    
    if ($template != "") {
        $template = '
            <div id="'.$headline_img.'">
                <img src="img/pointer.png" alt="" style="vertical-align:text-bottom">&nbsp;<b>'.$navi_arr[title].'</b>
                <div id="navi_link">
                    '.$template.'
                </div>
            </div>';
    }
    
    return $template;
}


////////////////////////////////
//// Seitenlink generieren   ///
//// und Berechtigung prüfen ///
////////////////////////////////

function createlink($page_call, $page_link_title = false, $page_link_url = false, $page_link_perm = false)
{
  global $global_config_arr;
  global $db;
  global $session_url;

  $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."admin_cp WHERE page_call = '$page_call' LIMIT 0,1", $db);
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

  $link_class = "navi";
  if ($_GET['go'] == $page_call)
  {
      $link_class = "navi_selected";
  }
  
  if ($createlink_arr[permission] == 1)
  {
      return'
      <a href="'.$PHP_SELF.'?mid='.$_REQUEST['mid'].'&go='.$createlink_arr[page_call].$session_url.'" class="navi">- </a>
      <a href="'.$PHP_SELF.'?mid='.$_REQUEST['mid'].'&go='.$createlink_arr[page_call].$session_url.'" class="'.$link_class.'">
          '.$createlink_arr[link_title].'</a><br />';
  }
  else
  {
      return "";
  }
}

////////////////////////////////
//// Navi first              ///
////////////////////////////////

function createnavi_first($template)
{
    if (strlen($template) == 0) {
        return true;
    } else {
        return false;
    }
}

////////////////////////////////
//// Navi Permission         ///
////////////////////////////////

function createnavi_perm($perm_arr)
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
//////// Cookie setzen /////////
////////////////////////////////

function admin_set_cookie($username, $password)
{
    global $global_config_arr;
    global $db;

    $username = savesql($username);
    $password = savesql($password);
    $index = mysql_query("select * from ".$global_config_arr[pref]."user where user_name = '$username'", $db);
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
            $dbuserpass = mysql_result($index, 0, "user_password");
            $dbuserid = mysql_result($index, 0, "user_id");
            $dbusersalt= mysql_result($index, 0, "user_salt");
            $password = md5 ( $password.$dbusersalt );
            
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
    global $global_config_arr;
    global $db;

    $username = savesql($username);
    $password = savesql($password);
    $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."user WHERE user_name = '$username'", $db);
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
            $dbuserpass = mysql_result($index, 0, "user_password");
            $dbuserid = mysql_result($index, 0, "user_id");
            $dbusersalt = mysql_result($index, 0, "user_salt");
            
            if ($iscookie===false)
            {
                $password = md5 ( $password.$dbusersalt );
            }

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
   global $global_config_arr;
   global $db;
   global $data;
   
   $dbaction = "select * from ".$global_config_arr[pref]."user where user_id = " . $uid;
   $usertableindex2 = mysql_query($dbaction, $db);

   $_SESSION["user_id"] = $uid;
   $dbusername = mysql_result($usertableindex2, 0, "user_name");
   $_SESSION["user_name"] = $dbusername;
   $dbuserpass = mysql_result($usertableindex2, 0, "user_password");
   $_SESSION["user_pass"] = $dbuserpass;
   $dbusermail = mysql_result($usertableindex2, 0, "user_mail");
   $_SESSION["user_mail"] = $dbusermail;

   $result = mysql_list_fields($data,"".$global_config_arr[pref]."permissions");
   $menge = mysql_num_fields($result);
   for($x=1;$x<$menge;$x++)
   {
    $fieldname = mysql_field_name($result,$x);
    $index = mysql_query("select $fieldname from ".$global_config_arr[pref]."permissions where user_id = $uid", $db);
    $_SESSION[$fieldname] = mysql_result($index, 0, $fieldname);
   }
}

?>