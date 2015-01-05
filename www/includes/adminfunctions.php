<?php

/////////////////////////////////////////////////////////////////////////////////////////////////
//// get timezonelist                                                                        ////
//// thx@Rob Kaper <http://de.php.net/manual/en/function.date-default-timezone-set.php#84459>////
/////////////////////////////////////////////////////////////////////////////////////////////////
function get_timezones () {
    $timezones = DateTimeZone::listAbbreviations();

    $cities = array();
    foreach( $timezones as $key => $zones )
    {
        foreach( $zones as $zone )
        {
            if ( preg_match( '/^(America|Antartica|Arctic|Asia|Atlantic|Europe|Indian|Pacific)\//', $zone['timezone_id'] ) )
                $cities[$zone['timezone_id']][] = $key;
        }
    }

    // For each city, have a comma separated list of all possible timezones for that city.
    foreach( $cities as $key => $value )
        $cities[$key] = join( ', ', $value);

    // Only keep one city (the first and also most important) for each set of possibilities.
    $cities = array_unique( $cities );

    // Sort by area/city name.
    ksort($cities);

    return $cities;
}

//////////////////////////////////
//// create content container ////
//////////////////////////////////
function get_content_container ($TOP_TEXT, $CONTENT_TEXT, $OVERALL_STYLE = 'width:100%;', $TOP_STYLE = FALSE, $CONTENT_STYLE = FALSE)
{
    // $top_style = ( $TOP_STYLE === FALSE ? '' : ' style="'.$TOP_STYLE.'"' );
    // $content_style = ( $CONTENT_STYLE === FALSE ? '' : ' style="'.$CONTENT_STYLE.'"' );

    $template = '
        <div class="cb">
            <div class="cb-title">
                '.$TOP_TEXT.'
            </div>
            <div class="cb-content">
                '.$CONTENT_TEXT.'
            </div>
        </div>
    ';

    return $template;
}


/////////////////////////
//// Get Yes/NO Table////
/////////////////////////

function get_yesno_table ( $NAME )
{
  global $FD;

        return '
            <table width="100%" cellpadding="4" cellspacing="0">
                <tr class="bottom pointer" id="yes">
                    <td>
                        <script type="text/javascript">
                            jQuery(document).ready(function(){
                                $("tr#yes").hover(function(event) {
                                    if ($("input#del_yes").prop("checked")) {
                                        $("tr#yes").css("background-color", "#64DC6A");
                                    } else {
                                        $("tr#yes").css("background-color", "#EEEEEE");
                                    }
                                }, function(event) {
                                    if ($("input#del_yes").prop("checked")) {
                                        $("tr#yes").css("background-color", "#49C24f");
                                    } else {
                                        $("tr#yes").css("background-color", "transparent");
                                    }
                                });
                                $("tr#no").hover(function(event) {
                                    if ($("input#del_no").prop("checked")) {
                                        $("tr#no").css("background-color", "#DE5B5B");
                                    } else {
                                        $("tr#no").css("background-color", "#EEEEEE");
                                    }
                                }, function(event) {
                                       if ($("input#del_no").prop("checked")) {
                                        $("tr#no").css("background-color", "#C24949");
                                    } else {
                                        $("tr#no").css("background-color", "transparent");
                                    }
                                });

                                $("input#del_yes").change(function(event) {
                                    if ($(this).prop("checked")) {
                                        $("tr#yes").css("background-color", "#49C24f");
                                        $("input#del_no").trigger("change");
                                        $("tr#yes").trigger("mouseenter");
                                    } else {
                                        $("tr#yes").css("background-color", "transparent");
                                        $("tr#yes").trigger("mouseout");
                                    }
                                });
                                $("input#del_no").change(function(event) {
                                    if ($(this).prop("checked")) {
                                        $("tr#no").css("background-color", "#C24949");
                                        $("input#del_yes").trigger("change");
                                        $("tr#no").trigger("mouseenter");
                                    } else {
                                        $("tr#no").css("background-color", "transparent");
                                        $("tr#no").trigger("mouseout");
                                    }
                                });

                                $("input#del_yes").trigger("change");
                                $("input#del_no").trigger("change");
                                $("tr#no").trigger("mouseout");

                            });


                        </script>

                        <input class="pointer" type="radio" name="'.$NAME.'" id="del_yes" value="1">
                    </td>
                    <td class="config middle">
                            <label for="del_yes">'.$FD->text("admin", "yes").'</label>
                    </td>
                </tr>
                <tr class="bottom pointer" id="no">
                    <td>
                        <input class="pointer" type="radio" name="'.$NAME.'" id="del_no" value="0" checked>
                    </td>
                    <td class="config middle">
                            <label for="del_no">'.$FD->text("admin", "no").'</label>
                    </td>
                </tr>
                </table>
        ';
}

//////////////////////////////////////
//// Noscript - Do not use hidden ////
//////////////////////////////////////

function noscript_nohidden ()
{
        return '
                <noscript>
                    <style type="text/css">
                        .hidden {display: table-row;}
                    </style>
                </noscript>
        ';
}

////////////////////////////////////////////
//// add zero to figures lower than 10  ////
////////////////////////////////////////////

function add_zero ( $FIGURE )
{
    settype ( $FIGURE, 'integer' );
    if ( $FIGURE >= 0 && $FIGURE < 10 ) {
        $FIGURE = '0'.$FIGURE;
    }
        return $FIGURE;
}

//////////////////////////
//// Get Article URLs ////
//////////////////////////

function get_article_urls ()
{
    global $FD;

    $index = $FD->db()->conn()->query ( '
                    SELECT article_url FROM '.$FD->env('DB_PREFIX').'articles');

    while ( $result = $index->fetch(PDO::FETCH_ASSOC) ) {
        if ( $result['article_url'] != '' ) {
            $url_arr[] = $result['article_url'];
        }
    }

    return $url_arr;
}

//////////////////////////////
//// Color List Functions ////
//////////////////////////////

function color_list_entry ( $CHECK_ID, $DEFAULTCOLOR, $CHECKEDCOLOR, $ELEMENT_ID )
{
        if ( $CHECK_ID != 'this' ) { $CHECK_ID = "document.getElementById('".$CHECK_ID."')"; }
        if ( $ELEMENT_ID != 'this' ) { $ELEMENT_ID = "document.getElementById('".$ELEMENT_ID."')"; }

        return 'colorEntry ( '.$CHECK_ID.", '".$DEFAULTCOLOR."', '".$CHECKEDCOLOR."', ".$ELEMENT_ID.' );';
}

function color_click_entry ( $CHECK_ID, $DEFAULTCOLOR, $CHECKEDCOLOR, $ELEMENT_ID, $RESET = FALSE, $RESETCOLOR = 'transparent' )
{
        if ( $CHECK_ID != 'this' ) { $CHECK_ID = "document.getElementById('".$CHECK_ID."')"; }
        if ( $ELEMENT_ID != 'this' ) { $ELEMENT_ID = "document.getElementById('".$ELEMENT_ID."')"; }

        $js = 'createClick ( '.$CHECK_ID.", '".$DEFAULTCOLOR."', '".$CHECKEDCOLOR."', ".$ELEMENT_ID.' );';

        if ( $RESET == TRUE ) {
            $js .= " resetOld ( '".$RESETCOLOR."', last, lastBox, ".$ELEMENT_ID.' );';
        }

        $js .= ' saveLast ( '.$CHECK_ID.', '.$ELEMENT_ID.' );';

        return $js;
}

function color_pre_selected ( $CHECK_ID, $ELEMENT_ID )
{
        $CHECK_ID = "document.getElementById('".$CHECK_ID."')";
        $ELEMENT_ID = "document.getElementById('".$ELEMENT_ID."')";

        return '
                <script type="text/javascript">
                        <!--
                    savePreSelectedLast ( '.$CHECK_ID.', '.$ELEMENT_ID.' );
                        //-->
                </script>
        ';
}

///////////////////////
//// Get Save Date ////
///////////////////////

function getsavedate ( $D, $M, $Y, $H = 0, $I = 0, $S = 0, $WITHOUT_MKTIME = FALSE )
{
    settype ( $D, 'integer' );
    settype ( $M, 'integer' );
    settype ( $Y, 'integer' );
    settype ( $H, 'integer' );
    settype ( $I, 'integer' );
    settype ( $S, 'integer' );
	
	$savedate_arr = array();
    if ($WITHOUT_MKTIME !== TRUE) {

        $new_date = mktime ( $H, $I, $S, $M, $D, $Y );

        $savedate_arr['d'] = date ( 'd', $new_date );
        $savedate_arr['m'] = date ( 'm', $new_date );
        $savedate_arr['y'] = date ( 'Y', $new_date );
        $savedate_arr['h'] = date ( 'H', $new_date );
        $savedate_arr['i'] = date ( 'i', $new_date );
        $savedate_arr['s'] = date ( 's', $new_date );

    } else {

        $savedate_arr['d'] = $D;
        $savedate_arr['m'] = $M;
        $savedate_arr['y'] = $Y;
        $savedate_arr['h'] = $H;
        $savedate_arr['i'] = $I;
        $savedate_arr['s'] = $S;

        $savedate_arr = array_map(create_function('$ele', '
            if ($ele == 0)
                return "";
        return sprintf("%02d", $ele);

        '), $savedate_arr);
    }

    return $savedate_arr;
}

////////////////////////
//// Create JS-PoUp ////
////////////////////////

function openpopup ( $FILE, $WIDTH, $HEIGHT )
{
        /* $half_width = $WIDTH / 2;
        $half_height = $HEIGHT / 2;
        $javascript = 'open("'.$FILE.'","_blank","width='.$WIDTH.',height='.$HEIGHT.',top="+((screen.height/2)-'.$half_height.')+",left="+((screen.width/2)-'.$half_width.')+",scrollbars=YES,location=YES,status=YES")'; */
        $javascript = 'popUp("'.$FILE.'", "_blank", '.$WIDTH.', '.$HEIGHT.')';

        return $javascript;
}

///////////////////////////////////
//// Create JS-FullScreen-PoUp ////
///////////////////////////////////

function open_fullscreenpopup ( $FILE )
{
        $javascript = 'open("'.$FILE.'","_blank","width="+screen.availWidth+",height="+screen.availHeight+",top=0,left=0,scrollbars=YES,location=YES,status=YES")';

        return $javascript;
}

/////////////////////////////
//// selected="selected" ////
/////////////////////////////

function getselected ( $VALUE, $COMPAREWITH )
{
        if ( $VALUE === $COMPAREWITH ) {
            return 'selected';
        } else {
                return '';
        }
}

///////////////////////////
//// checked="checked" ////
///////////////////////////

function getchecked ( $VALUE, $COMPAREWITH )
{
        if ( $VALUE === $COMPAREWITH ) {
            return 'checked';
        } else {
                return '';
        }
}

/////////////////////////////
//// disabled="disabled" ////
/////////////////////////////

function getdisabled ( $VALUE, $COMPAREWITH )
{
        if ( $VALUE === $COMPAREWITH ) {
            return 'disabled';
        } else {
                return '';
        }
}

/////////////////////////////
//// readonly="readonly" ////
/////////////////////////////

function getreadonly ( $VALUE, $COMPAREWITH )
{
        if ( $VALUE === $COMPAREWITH ) {
            return 'readonly';
        } else {
                return '';
        }
}

////////////////////////////////
//// Systemmeldung ausgeben ////
////////////////////////////////

function get_systext ($MESSAGE, $TITLE = false, $COLOR = 'green', $IMAGE = false)
{
    global $FD;

    if (!$TITLE)
        $TITLE = $FD->text("admin", "info");

    // TRUE was old for "red"
    $COLOR = $COLOR === TRUE ? 'red' : $COLOR;
    // FALSE was old for "green"
    $COLOR = $COLOR === FALSE ? 'green' : $COLOR;


    if ($IMAGE == false) {
        return '
            <div class="systext">
                <h4>'.$TITLE.'</h4>
                <hr class="'.$COLOR.'">
                <div>'.$MESSAGE.'</div>
            </div>
        ';
    } else {
        return '
            <div class="systext">
                <h4>'.$TITLE.'</h4>
                <hr class="'.$COLOR.'">
                <div>
                    '.$IMAGE.'<span class="middle">'.$MESSAGE.'</span>
                </div>
            </div>
        ';
    }
}

function systext ( $MESSAGE, $TITLE = FALSE, $COLOR = 'green', $IMAGE = FALSE )
{
    echo get_systext ( $MESSAGE, $TITLE, $COLOR, $IMAGE );
}

///////////////////////////////
//// Create JS Time button ////
///////////////////////////////

function js_timebutton ( $DATA, $CAPTION, $CLASS = "button" )
{
        $template = '<input class="'.$CLASS.'" type="button" value="'.$CAPTION.'" onClick="';

        foreach ( $DATA as $key => $value ) {
                $template .= "document.getElementById('".$key."').value='".$value."';";
        }

    $template .= '">';

        return $template;
}

//////////////////////////////
//// Create JS Now button ////
//////////////////////////////

function js_nowbutton ( $DATA, $CAPTION, $CLASS = 'button' )
{
        $template = '<input class="'.$CLASS.'" type="button" value="'.$CAPTION.'" onClick="';

        foreach ( $DATA as $value ) {
                $id[] = $value;
        }
        unset ( $value );

        $value[] = 'getCurDate()';
        $value[] = 'getCurMonth()';
        $value[] = 'getCurYear()';
        $value[] = 'getCurHours()';
        $value[] = 'getCurMinutes()';
        $value[] = 'getCurSeconds()';

        for ( $i = 0; $i < count ( $id ) && $i < 6; $i++ ) {
                $template .= "document.getElementById('".$id[$i]."').value=".$value[$i].';';
        }

    $template .= '">';

        return $template;
}

//////////////////////////////
//// Create JS Now button ////
//////////////////////////////

function get_datebutton($DATA, $CAPTION, $CLASS = 'button')
{
    $template = '<input class="'.$CLASS.'" type="button" value="'.$CAPTION.'" onClick="$(\'#'.$DATA[0].'\').data(\'dateinput\').setValue(new Date('.$DATA[1].'));">';
    return $template;
}

////////////////////////////
//// Update from $_POST ////
////////////////////////////

function getfrompost ( $ARRAY )
{
        foreach ( $ARRAY as $key => $value  ) {
        $ARRAY[$key] = $_POST[$key];
        }
        return $ARRAY;
}
function frompost ($KEYS) {
    $return = array();
    foreach ($KEYS as $key) {
        $return[$key] = isset($_POST[$key]) ? $_POST[$key] : 0;
    }
    return $return;
}

///////////////////////////////
//// Update $_POST from DB ////
///////////////////////////////

function putintopost ($ARRAY)
{
    foreach ($ARRAY as $key => $value ) {
        $_POST[$key] = $ARRAY[$key];
    }
}

/////////////////////////
//// Create textarea ////
/////////////////////////

function create_editor($name, $text='', $width='', $height='', $class='', $do_smilies=true)
{
    global $FD;

    if ($name != '') {
        $name2 = 'name="'.$name.'" id="'.$name.'"';
    } else {
        return false;
    }

    if ( $width != '' && is_int ( $width ) ) {
        $width2 = 'width:'.$width.'px;';
    } elseif ( $width != '' ) {
        $width2 = 'width:'.$width.';';
    }

    if ($height != '' && is_int($height)) {
        $height2 = 'height:'.$height.'px;';
    } elseif ( $height != '' ) {
        $height2 = 'height:'.$height.';';
    }

    if ($class != '') {
        $class2 = 'class="nomonospace '.$class.'"';
    } else {
        $class2 = 'class="nomonospace"';
    }

    if (!isset($width2))
      $width2 = '';
    $style = $name2.' '.$class2.' style="'.$width2.' '.$height2.'"';

  $smilies = '';
  if ($do_smilies == true)
  {
    $smilies = '
    <td style="padding-left: 4px;">
      <fieldset style="width:46px;">
        <legend class="small" align="left"><font class="small">Smilies</font></legend>
          <table cellpadding="2" cellspacing="0" border="0" width="100%">';

    $zaehler = 0;
    $index = $FD->db()->conn()->query('SELECT * FROM '.$FD->env('DB_PREFIX').'smilies ORDER by `order` ASC LIMIT 0, 10');
    while ($smilie_arr = $index->fetch(PDO::FETCH_ASSOC))
    {
        $smilie_arr['url'] = image_url('images/smilies/', $smilie_arr['id'], false);

        $smilie_template = '<td><img src="'.$smilie_arr['url'].'" alt="'.$smilie_arr['replace_string'].'" onClick="insert(\''.$name.'\', \''.$smilie_arr['replace_string'].'\', \'\')" class="editor_smilies" /></td>';

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

    $smilies .= '</table></fieldset></td>';
  }

    $buttons = '';
    $buttons .= create_editor_button_new('admin/editor/b.jpg', 'B', 'fett', "insert('$name', '[b]', '[/b]')");
    $buttons .= create_editor_button_new('admin/editor/i.jpg', 'I', 'kursiv', "insert('$name', '[i]', '[/i]')");
    $buttons .= create_editor_button_new('admin/editor/u.jpg', 'U', 'unterstrichen', "insert('$name','[u]','[/u]')");
    $buttons .= create_editor_button_new('admin/editor/s.jpg', 'S', 'durgestrichen', "insert('$name', '[s]', '[/s]')");
    $buttons .= create_editor_seperator();
    $buttons .= create_editor_button_new('admin/editor/center.jpg', 'CENTER', 'zentriert', "insert('$name', '[center]', '[/center]')");
    $buttons .= create_editor_seperator();
    $buttons .= create_editor_button_new('admin/editor/font.jpg', 'FONT', 'Schriftart', "insert_com('$name', 'font', 'Bitte gib die gewünschte Schriftart ein:', '')");
    $buttons .= create_editor_button_new('admin/editor/color.jpg', 'COLOR', 'Schriftfarbe', "insert_com('$name', 'color', 'Bitte gib die gewünschte Schriftfarbe (englisches Wort) ein:', '')");
    $buttons .= create_editor_button_new('admin/editor/size.jpg', 'SIZE', 'Schriftgröße', "insert_com('$name', 'size', 'Bitte gib die gewünschte Schriftgröße (Zahl von 0-7) ein:', '')");
    $buttons .= create_editor_seperator();
    $buttons .= create_editor_button_new('admin/editor/img.jpg', 'IMG', 'Bild einfügen', "insert_mcom('$name', '[img]', '[/img]', 'Bitte gib die URL zu der Grafik ein:', 'http://')");
    $buttons .= create_editor_button_new('admin/editor/cimg.jpg', 'CIMG', 'Content-Image einfügen', "insert_mcom('$name', '[cimg]', '[/cimg]', 'Bitte gib den Namen des Content-Images (mit Endung) ein:', '')");
    $buttons .= create_editor_seperator();
    $buttons .= create_editor_button_new('admin/editor/url.jpg', 'URL', 'Link einfügen', "insert_com('$name', 'url', 'Bitte gib die URL ein:', 'http://')");
    $buttons .= create_editor_button_new('admin/editor/home.jpg', 'HOME', 'Projektinternen Link einfügen', "insert_com('$name', 'home', 'Bitte gib den projektinternen Verweisnamen ein:', '')");
    $buttons .= create_editor_button_new('admin/editor/email.jpg', '@', 'Email-Link einfügen', "insert_com('$name', 'email', 'Bitte gib die Email-Adresse ein:', '')");
    $buttons .= create_editor_seperator();
    $buttons .= create_editor_button_new('admin/editor/code.jpg', 'C', 'Code-Bereich einfügen', "insert('$name', '[code]', '[/code]')");
    $buttons .= create_editor_button_new('admin/editor/quote.jpg', 'Q', 'Zitat einfügen', "insert('$name', '[quote]', '[/quote]')");
    $buttons .= create_editor_button_new('admin/editor/nofscode.jpg', 'N', 'Nicht umzuwandelnden Bereich einfügen', "insert('$name', '[nofscode]', '[/nofscode]')");


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

    $textarea = str_replace('{style}', $style, $textarea);
    $textarea = str_replace('{text}', $text, $textarea);
    $textarea = str_replace('{buttons}', $buttons, $textarea);
    $textarea = str_replace('{smilies}', $smilies, $textarea);

    return $textarea;
}


////////////////////////////////
//// Create textarea Button ////
////////////////////////////////

function create_editor_button($img_url, $alt, $title, $insert)
{
    global $FD;

    $javascript = 'onClick="'.$insert.'"';

    $button = '
    <td class="editor_td">
        <div class="ed_button" {javascript}>
            <img src="{img_url}" alt="{alt}" title="{title}" />
        </div>
    </td>';
    $button = str_replace('{img_url}', $FD->config('virtualhost').$img_url, $button);
    $button = str_replace('{alt}', $alt, $button);
    $button = str_replace('{title}', $title, $button);
    $button = str_replace('{javascript}', $javascript, $button);

    return $button;
}

////////////////////////////////
//// Create textarea Button ////
////////////////////////////////

function create_editor_button_new($img_url, $alt, $title, $insert)
{
    global $FD;
    $javascript = 'javascript:'.$insert;

    $button = '
    <td class="editor_td">
        <a class="ed_button_new" style="background-image:url({img_url});"  href="{javascript}" title="{title}">
            <img border="0" src="img/null.gif" alt="{alt}">
        </a>
    </td>';
    $button = str_replace('{img_url}', $FD->config('virtualhost').$img_url, $button);
    $button = str_replace('{alt}', $alt, $button);
    $button = str_replace('{title}', $title, $button);
    $button = str_replace('{javascript}', $javascript, $button);

    return $button;
}


///////////////////////////////////
//// Create textarea Seperator ////
///////////////////////////////////

function create_editor_seperator()
{
    $seperator = '<td class="editor_td_seperator"></td>';
    return $seperator;
}


////////////////////////
//// Insert Tooltip ////
////////////////////////

function insert_tt ( $TITLE, $TEXT, $FORM_ID, $NEW_LINE = TRUE, $INSERT = TRUE, $BOLD_TITLE = TRUE, $SHOW_TITLE = TRUE   )
{
    initstr($span_end);
    initstr($span_start);

    if ( $NEW_LINE == TRUE ) {
        $span_start = '<span style="padding-bottom:3px; display:block;">';
        $span_end = '</span>';
    }
    if ( $INSERT == TRUE ) {
        $insert_link = 'javascript:insert(\''.$FORM_ID.'\',\''.$TITLE.'\',\'\');';
        $insert_text = '*klicken*';
    } else {
        $insert_link = '#?';
        $insert_text = '';
    }
    if ( $SHOW_TITLE == TRUE ) {
        $first_title = $TITLE.'';
    }
    if ( $BOLD_TITLE == TRUE ) {
        $second_title = ' <b>'.$TITLE.'</b>';
    } else {
        $second_title = '&nbsp;'.$TITLE;
    }

    $template = $span_start.'<a class="tooltip" href="'.$insert_link.'">'.$first_title.'<span><img class="atright" border="0" alt="-&gt;" src="icons/pointer.gif">'.$second_title.'<br>'.$TEXT.'</span></a>'.$span_end.'
    ';

   return $template;
}

/////////////////////////////
//// Generate page title  ///
//// and check permission ///
/////////////////////////////

function createpage ($TITLE, $PERMISSION, $FILE, $ACTIVE_MENU)
{
    global $FD;

    if ($PERMISSION) {
        $page_data = array(
            'title' => $TITLE,
            'file'  => $FILE,
            'menu'  => $ACTIVE_MENU
        );
    } else {
        $page_data = array(
            'title' => $FD->text('menu', 'admin_error_page_title'),
            'file'  => 'admin_403.php',
            'menu'  => 'error'
        );
    }
    $page_data['created'] = true;
    return $page_data;
}

/////////////////////////////////
//// Create HTML for topmenu ////
/////////////////////////////////
function get_topmenu ($ACTIVE_MENU)
{
    global $FD;

    $menu_arr = $FD->db()->conn()->query(
                     'SELECT page_id, page_file FROM '.$FD->env('DB_PREFIX')."admin_cp
                      WHERE `group_id` = '-1' AND `page_int_sub_perm` = 0
                      ORDER BY `page_pos`, `page_file`");
    $menu_arr = $menu_arr->fetchAll(PDO::FETCH_ASSOC);

    $template = '<ul class="topmenu">';
    foreach($menu_arr as $menu) {
        // check permissions
        if (is_authorized() && check_topmenu_permissions($menu['page_file'])) {
            // highlight the active menu
            initstr($class);
            if ($ACTIVE_MENU == $menu['page_file'])
                $class = ' class="selected"';

            $template .= "\n".'        <li'.$class.'><a href="?go='.$menu['page_id'].'" target="_self">'.$FD->text('menu', 'menu_'.$menu['page_file']).'</a></li>';
        }
    }

    $template .= "\n".'    </ul>';

    return $template;
}


/////////////////////////////////////////////////////////
//// Check rights, wheter user may see topmenu entry ////
/////////////////////////////////////////////////////////
function check_topmenu_permissions ($MENU_ID)
{
    global $FD;

    $page_arr = $FD->db()->conn()->prepare(
                    'SELECT P.page_id AS page_id
                     FROM '.$FD->db()->getPrefix().'admin_cp P, '.$FD->db()->getPrefix().'admin_groups G
                     WHERE G.`menu_id` = ? AND P.`group_id` = G.`group_id` AND P.`page_int_sub_perm` = 0
                     ORDER BY P.`page_id`');
    $page_arr->execute(array($MENU_ID));
    $page_arr = $page_arr->fetchAll(PDO::FETCH_ASSOC);

    foreach($page_arr as $page) {
        if (has_perm($page['page_id'])) {
            return true;
        }
    }

    return false;
}

//////////////////////////////////
//// Create HTML for Leftmenu ////
//////////////////////////////////
function get_leftmenu ($ACTIVE_MENU, $GO)
{
    global $FD;

    // get data from db
    $group_arr = $FD->db()->conn()->prepare(
                       'SELECT group_id FROM '.$FD->db()->getPrefix()."admin_groups
                        WHERE `menu_id` = ? AND `group_id` NOT IN ('0', '-1')
                        ORDER BY `group_pos`");
    $group_arr->execute(array($ACTIVE_MENU));
    $group_arr = $group_arr->fetchAll(PDO::FETCH_ASSOC);

    // get template
    initstr($template);
    foreach($group_arr as $group) {
        $template .= get_leftmenu_group($group['group_id'], empty($template), $GO);
    }

    return $template;
}

//////////////////////////////////////////////
//// Create Leftmenu Groups from Database ////
//////////////////////////////////////////////
function get_leftmenu_group ($GROUP_ID, $IS_FIRST, $GO)
{
    global $FD;

    // get links from database
    $page_arr = $FD->db()->conn()->prepare(
                       'SELECT page_id FROM '.$FD->env('DB_PREFIX').'admin_cp
                        WHERE `group_id` = ? AND `page_int_sub_perm` = 0
                        ORDER BY `page_pos`, `page_id`');
    $page_arr->execute(array($GROUP_ID));
    $page_arr = $page_arr->fetchAll(PDO::FETCH_ASSOC);

    // get template
    initstr($template);
    foreach($page_arr as $page) {
        $template .= get_link($page['page_id'], $GO);
    }

    // is group first in navi?
    initstr($class);
    if ($IS_FIRST) {
        $class = ' top';
    }

    // put links into group
    if (!empty($template)) {
        $template = '
        <div class="leftmenu'.$class.'">
            <img src="icons/arrow.gif" alt="->" class="middle">&nbsp;<strong class="middle">'.$FD->text('menu', 'group_'.$GROUP_ID).'</strong>
            <ul>'.$template.'
            </ul>
        </div>';
    }

    return $template;
}


/////////////////////////////
//// Generate page link   ///
//// and check permission ///
/////////////////////////////

function get_link ($PAGE_ID, $GO)
{
    global $FD;

    // permission ok?
    if (has_perm($PAGE_ID)) {
        // active page?
        $class = ($PAGE_ID == $GO) ? ' class="selected"' : '';

        return "\n".'               <li'.$class.'><a href="?go='.$PAGE_ID.'">'.$FD->text('menu', 'page_link_'.$PAGE_ID).'</a></li>';
    } else {
        return '';
    }
}



/////////////////////////////
//////// Set Cookie /////////
/////////////////////////////

function admin_set_cookie($username, $password)
{
    global $FD;

    $index = $FD->db()->conn()->prepare('SELECT * FROM '.$FD->env('DB_PREFIX').'user WHERE user_name = ?');
    $index->execute(array($username));
    $USER_ARR = $index->fetch(PDO::FETCH_ASSOC);
    if ($USER_ARR === false)
    {
        return false;
    }
    else
    {
        if ( $USER_ARR['user_is_staff'] == 1 || $USER_ARR['user_is_admin'] == 1 || $USER_ARR['user_id'] == 1 ) {
            $dbisadmin = 1;
        } else {
            $dbisadmin = 0;
        }

        if ($dbisadmin == 1)
        {
            $dbuserpass = $USER_ARR['user_password'];
            //$dbuserid = $USER_ARR['user_id'];
            $dbusersalt= $USER_ARR['user_salt'];
            $password = md5 ( $password.$dbusersalt );

            if ($password == $dbuserpass)
            {
                $inhalt = $password . $username;
                setcookie ('login', $inhalt, time()+2592000, '/');
                return true;  // login accepted
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

///////////////////////////////
/////// Check Login Data //////
///////////////////////////////

function admin_login($username, $password, $iscookie)
{
    global $FD;

    $index = $FD->db()->conn()->prepare('SELECT * FROM '.$FD->env('DB_PREFIX').'user WHERE user_name = ? LIMIT 1');
    $index->execute(array($username));
    $USER_ARR = $index->fetch(PDO::FETCH_ASSOC);
    if ($USER_ARR === false)
    {
        return 1;  // error code 1: user does not exist
    }
    else
    {
        if ( $USER_ARR['user_is_staff'] == 1 || $USER_ARR['user_is_admin'] == 1 || $USER_ARR['user_id'] == 1 ) {
            $dbisadmin = 1;
        } else {
            $dbisadmin = 0;
        }

        if ($dbisadmin == 1)
        {
            $dbuserpass = $USER_ARR['user_password'];
            $dbuserid = $USER_ARR['user_id'];
            $dbusersalt = $USER_ARR['user_salt'];

            if ($iscookie===false)
            {
                $password = md5 ( $password.$dbusersalt );
            }

            if ($password == $dbuserpass)
            {
                $_SESSION['user_level'] = 'authorized';
                fillsession($dbuserid);
                return 0;  // login accepted
            }
            else
            {
                return 2;  // error code 2: wrong password
            }
        }
        else
        {
            return 3;  // error code 3: no access privileges for admin area
        }
    }
}

//////////////////////////////
//////// Fill Session ////////
//////////////////////////////

function fillsession ($uid) {
    global $FD;

    $USER_ARR = $FD->db()->conn()->query(
                     'SELECT user_id, user_name, user_is_staff, user_group, user_is_admin
                      FROM '.$FD->env('DB_PREFIX').'user
                      WHERE `user_id` = '.intval($uid).' LIMIT 1');
    $USER_ARR = $USER_ARR->fetch(PDO::FETCH_ASSOC);

    $_SESSION['user_id'] =  intval($USER_ARR['user_id']);
    $_SESSION['user_name'] =  $USER_ARR['user_name'];
    $_SESSION['user_is_staff'] =  $USER_ARR['user_is_staff'];

    // get user permissions
    $group_granted = $FD->db()->conn()->query(
                         'SELECT perm_id FROM '.$FD->env('DB_PREFIX')."user_permissions
                          WHERE `perm_for_group` = '1' AND `x_id` = '".intval($USER_ARR['user_group'])."' AND `x_id` != '0'");
    $group_granted = $group_granted->fetchAll(PDO::FETCH_ASSOC);
    $user_granted = $FD->db()->conn()->query(
                          'SELECT perm_id FROM '.$FD->env('DB_PREFIX')."user_permissions
                           WHERE `perm_for_group` = '0' AND `x_id` = '".intval($USER_ARR['user_id'])."' AND `x_id` != '0'");
    $user_granted = $user_granted->fetchAll(PDO::FETCH_ASSOC);

    $fold_perms = create_function ('$arr, $ele', '
        array_push($arr, $ele[\'perm_id\']);
        return $arr;');

    $group_granted = array_reduce ($group_granted, $fold_perms, array());
    $user_granted = array_reduce ($user_granted, $fold_perms, array());

    $granted = array_unique(array_merge($group_granted, $user_granted));


    $inherited = $FD->db()->conn()->query(
                     'SELECT pass_to AS perm_id
                      FROM '.$FD->env('DB_PREFIX').'admin_inherited I, '.$FD->env('DB_PREFIX')."admin_cp A
                      WHERE A.`group_id`= I.`group_id` AND A.`page_id` IN ('".implode("','", $granted)."')");
    $inherited = $inherited->fetchAll(PDO::FETCH_ASSOC);
    $inherited = array_reduce ($inherited, $fold_perms, array());
    $granted = array_unique(array_merge($granted, $inherited));

    // pages permissions
    $permissions = $FD->db()->conn()->query(
                         'SELECT page_id FROM '.$FD->env('DB_PREFIX').'admin_cp
                          WHERE `group_id` != -1 ORDER BY `page_id`');
    $permissions = $permissions->fetchAll(PDO::FETCH_ASSOC);

    foreach ($permissions as $permission) {
        $permission = $permission['page_id'];

        // admin
        if($USER_ARR['user_id'] == 1 || $USER_ARR['user_is_admin'] == 1) {
            $_SESSION[$permission] = 1;

        // user
        } else {
            if (in_array($permission, $granted)) {
                $_SESSION[$permission] = 1;
            } else {
                $_SESSION[$permission] = 0;
            }
        }
    }

    // startpage permissions
    $permissions = $FD->db()->conn()->query(
                         'SELECT page_id, page_file FROM '.$FD->env('DB_PREFIX').'admin_cp
                          WHERE `group_id` = -1 ORDER BY `page_id`');
    $permissions = $permissions->fetchAll(PDO::FETCH_ASSOC);

    foreach ($permissions as $permission) {
        // admin
        if($USER_ARR['user_id'] == 1 || $USER_ARR['user_is_admin'] == 1) {
            $_SESSION[$permission['page_id']] = 1;

        // user
        } else {
            if (check_topmenu_permissions($permission['page_file'])) {
                $_SESSION[$permission['page_id']] = 1;
            } else {
                $_SESSION[$permission['page_id']] = 0;
            }
        }
    }
}

?>
