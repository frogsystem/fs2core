<?php


////////////////////////////
//// get email template ////
////////////////////////////

function get_email_template ( $TEMPLATE_NAME )
{
    global $FD;

    $index = $FD->db()->conn()->query ( '
                    SELECT `'.$TEMPLATE_NAME.'`
                    FROM '.$FD->env('DB_PREFIX')."email
                    WHERE `id` = '1'" );
    $result = $index->fetch(PDO::FETCH_ASSOC);
    return $result[$TEMPLATE_NAME];
}

/////////////////////////
//// Create textarea ////
/////////////////////////

function create_textarea($name, $text='', $width='', $height='', $class='', $all=true, $fs_smilies=0, $fs_b=0, $fs_i=0, $fs_u=0, $fs_s=0, $fs_center=0, $fs_font=0, $fs_color=0, $fs_size=0, $fs_img=0, $fs_cimg=0, $fs_url=0, $fs_home=0, $fs_email=0, $fs_code=0, $fs_quote=0, $fs_noparse=0)
{
    global $FD;

    if ($name != '') {
        $name2 = 'name="'.$name.'" id="'.$name.'"';
    } else {
        return false;
    }

    if ($width != '') {
        $width2 = 'width:'.$width.'px;';
    }

    if ($height != '') {
        $height2 = 'height:'.$height.'px';
    }

    if ($class != '') {
        $class2 = 'class="'.$class.'"';
    }

    $style = $name2.' '.$class2.' style="'.$width2.' '.$height2.'"';

  if ($all==true OR $fs_smilies==1) {
    $smilies_table = '
          <table cellpadding="2" cellspacing="0" border="0">';

    $index =$FD->db()->conn()->query ( 'SELECT * FROM `'.$FD->env('DB_PREFIX').'editor_config`' );
    $config_arr = $index->fetch(PDO::FETCH_ASSOC);
    $config_arr['num_smilies'] = $config_arr['smilies_rows']*$config_arr['smilies_cols'];

    $zaehler = 0;
    $index = $FD->db()->conn()->query ( '
                            SELECT *
                            FROM `'.$FD->env('DB_PREFIX').'smilies`
                            ORDER BY `order` ASC
                            LIMIT 0, '.$config_arr['num_smilies'].' ' );
    while ( $smilie_arr = $index->fetch(PDO::FETCH_ASSOC) )
    {
        $smilie_arr['url'] = image_url ( '/smilies', $smilie_arr['id'] );
        $smilie_template = '<td><img src="'.$smilie_arr['url'].'" alt="'.$smilie_arr['replace_string'].'" onClick="insert(\''.$name.'\', \''.$smilie_arr['replace_string'].'\', \'\')" class="editor_smilies"></td>';
        $zaehler += 1;

        switch ( $zaehler )
        {
            case $config_arr['smilies_cols'] == 1:
                $zaehler = 0;
                $smilies_table .= "<tr align=\"center\">\n\r";
                $smilies_table .= $smilie_template;
                $smilies_table .= "</tr>\n\r";
                break;
            case $config_arr['smilies_cols']:
                $zaehler = 0;
                $smilies_table .= $smilie_template;
                $smilies_table .= "</tr>\n\r";
                break;
            case 1:
                $smilies_table .= "<tr align=\"center\">\n\r";
                $smilies_table .= $smilie_template;
                break;
            default:
                $smilies_table .= $smilie_template;
                break;
        }
    }
    $smilies_table .= '</table>';

    // Get Smilie Template
    $smilies = new template();
    $smilies->setFile('0_editor.tpl');
    $smilies->load('SMILIES_BODY');

    $smilies->tag('smilies_table', $smilies_table );

    $smilies = $smilies->display ();
  } else {
    $smilies = '';
  }

$buttons = '';

if ($all==true OR $fs_b==1) {
  $buttons .= create_textarea_button('bold.gif', 'B', 'fett', "insert('$name', '[b]', '[/b]')");
}
if ($all==true OR $fs_i==1) {
  $buttons .= create_textarea_button('italic.gif', 'I', 'kursiv', "insert('$name', '[i]', '[/i]')");
}
if ($all==true OR $fs_u==1) {
  $buttons .= create_textarea_button('underline.gif', 'U', 'unterstrichen', "insert('$name','[u]','[/u]')");
}
if ($all==true OR $fs_s==1) {
  $buttons .= create_textarea_button('strike.gif', 'S', 'durgestrichen', "insert('$name', '[s]', '[/s]')");
}


if ($all==true OR $fs_b==1 OR $fs_i==1 OR $fs_u==1 OR $fs_s==1) {
  $buttons .= create_textarea_seperator();
}


if ($all==true OR $fs_center==1) {
  $buttons .= create_textarea_button('center.gif', 'CENTER', 'zentriert', "insert('$name', '[center]', '[/center]')");
}


if ($all==true OR $fs_center==1) {
  $buttons .= create_textarea_seperator();
}


if ($all==true OR $fs_font==1) {
  $buttons .= create_textarea_button('font.gif', 'FONT', 'Schriftart', "insert_com('$name', 'font', 'Bitte gib die gewünschte Schriftart ein:', '')");
}
if ($all==true OR $fs_color==1) {
  $buttons .= create_textarea_button('color.gif', 'COLOR', 'Schriftfarbe', "insert_com('$name', 'color', 'Bitte gib die gewünschte Schriftfarbe (englisches Wort) ein:', '')");
}
if ($all==true OR $fs_size==1) {
  $buttons .= create_textarea_button('size.gif', 'SIZE', 'Schriftgröße', "insert_com('$name', 'size', 'Bitte gib die gewünschte Schriftgröße (Zahl von 0-7) ein:', '')");
}


if ($all==true OR $fs_font==1 OR $fs_color==1 OR $fs_size==1) {
  $buttons .= create_textarea_seperator();
}


if ($all==true OR $fs_img==1) {
  $buttons .= create_textarea_button('img.gif', 'IMG', 'Bild einfügen', "insert_mcom('$name', '[img]', '[/img]', 'Bitte gib die URL zu der Grafik ein:', 'http://')");
}
if ($all==true OR $fs_cimg==1) {
  $buttons .= create_textarea_button('cimg.gif', 'CIMG', 'Content-Image einfügen', "insert_mcom('$name', '[cimg]', '[/cimg]', 'Bitte gib den Namen des Content-Images (mit Endung) ein:', '')");
}


if ($all==true OR $fs_img==1 OR $fs_cimg==1) {
  $buttons .= create_textarea_seperator();
}


if ($all==true OR $fs_url==1) {
  $buttons .= create_textarea_button('url.gif', 'URL', 'Link einfügen', "insert_com('$name', 'url', 'Bitte gib die URL ein:', 'http://')");
}
if ($all==true OR $fs_home==1) {
  $buttons .= create_textarea_button('home.gif', 'HOME', 'Projektinternen Link einfügen', "insert_com('$name', 'home', 'Bitte gib den projektinternen Verweisnamen ein:', '')");
}
if ($all==true OR $fs_email==1) {
  $buttons .= create_textarea_button('email.gif', '@', 'Email-Link einfügen', "insert_com('$name', 'email', 'Bitte gib die Email-Adresse ein:', '')");
}


if ($all==true OR $fs_url==1 OR $fs_home==1 OR $fs_email==1) {
  $buttons .= create_textarea_seperator();
}


if ($all==true OR $fs_code==1) {
  $buttons .= create_textarea_button('code.gif', 'C', 'Code-Bereich einfügen', "insert('$name', '[code]', '[/code]')");
}
if ($all==true OR $fs_quote==1) {
  $buttons .= create_textarea_button('quote.gif', 'Q', 'Zitat einfügen', "insert('$name', '[quote]', '[/quote]')");
}
if ($all==true OR $fs_noparse==1) {
  $buttons .= create_textarea_button('nofscode.gif', 'N', 'Nicht umzuwandelnden Bereich einfügen', "insert('$name', '[nofscode]', '[/nofscode]')");
}

    // Get Template
    $textarea = new template();
    $textarea->setFile('0_editor.tpl');
    $textarea->load('BODY');

    $textarea->tag('style', $style );
    $textarea->tag('text', $text );
    $textarea->tag('buttons', $buttons );
    $textarea->tag('smilies', $smilies );

    $textarea = $textarea->display ();

    return $textarea;
}


////////////////////////////////
//// Create textarea Button ////
////////////////////////////////

function create_textarea_button($img_file_name, $alt, $title, $insert)
{
    $javascript = 'onClick="'.$insert.'"';

    // Get Button
    $button = new template();
    $button->setFile('0_editor.tpl');
    $button->load('BUTTON');

    $button->tag('img_file_name', $img_file_name );
    $button->tag('alt', $alt );
    $button->tag('title', $title );
    $button->tag('javascript', $javascript );

    $button = $button->display ();

    return $button;
}


////////////////////////////////////
//// Create textarea  Seperator ////
////////////////////////////////////

function create_textarea_seperator()
{
    // Get Seperator
    $seperator = new template();
    $seperator->setFile('0_editor.tpl');
    $seperator->load('SEPERATOR');
    $seperator = $seperator->display ();

    return $seperator;
}


/////////////////////////
//// System Message ////
/////////////////////////

function sys_message ($TITLE, $MESSAGE, $STATUS = '')
{
    //check for addition HTTP Status
	if (!empty($STATUS) && false !== ($text = http_response_text($STATUS)))
		header($text, true, $STATUS);


    $template = new template();

    $template->setFile ( '0_general.tpl' );
    $template->load ( 'SYSTEMMESSAGE' );

    $template->tag ( 'message_title', $TITLE );
    $template->tag ( 'message', $MESSAGE );

    return (string) $template;
}

/////////////////////////
//// Forward Message ////
/////////////////////////

function forward_message ( $TITLE, $MESSAGE, $URL, $STATUS = '')
{
    global $FD;

    //check for addition HTTP Status
	if (!empty($STATUS) && false !== ($text = http_response_text($STATUS)))
		header($text, true, $STATUS);

    $forward_script = '
<noscript>
    <meta http-equiv="Refresh" content="'.$FD->cfg('auto_forward').'; URL='.$URL.'">
</noscript>
<script type="text/javascript">
    function auto_forward() {
        window.location = "'.$URL.'";
    }
    window.setTimeout("auto_forward()", '.($FD->cfg('auto_forward')*1000).');
</script>
    ';

    $template = new template();

    $template->setFile ( '0_general.tpl' );
    $template->load ( 'FORWARDMESSAGE' );

    $template->tag ( 'message_title', $TITLE );
    $template->tag ( 'message', $MESSAGE );
    $template->tag ( 'forward_url', $URL );
    $template->tag ( 'forward_time', $FD->cfg('auto_forward') );

    $template = $template->display ();
    return $forward_script.$template;
}


///////////////////////////////
//// create copyright note ////
///////////////////////////////
function get_copyright ()
{
        return '<span class="copyright">Powered by <a class="copyright" href="http://www.frogsystem.de/" target="_blank">Frogsystem&nbsp;2</a> &copy; 2007 - '.date('Y').' Frogsystem-Team</span>';
}



////////////////////////
/// Designs & Zones ////
////////////////////////
function set_style ()
{
    global $FD;

    if (isset($_COOKIE['style']) && !isset($_GET['style'])) {
      $_GET['style'] = $_COOKIE['style'];
    }

    if ( isset ( $_GET['style'] ) && $FD->cfg('allow_other_designs') == 1 ) {
        $index = $FD->db()->conn()->prepare ( '
                        SELECT `style_id`, `style_tag`
                        FROM `'.$FD->env('DB_PREFIX')."styles`
                        WHERE `style_tag` = ?
                        AND `style_allow_use` = 1
                        LIMIT 0,1");
        $index->execute(array($_GET['style']));
        $row = $index->fetch(PDO::FETCH_ASSOC);
        if ( $row !== false ) {
            $FD->setConfig('style', $row['style_tag'] );
            $FD->setConfig('style_tag', $row['style_tag'] );
            $FD->setConfig('style_id', $row['style_id'] );
        }
    } elseif ( isset ( $_GET['style_id'] ) && $FD->config('allow_other_designs') == 1 ) {
        settype ( $_GET['style_id'], 'integer' );
        $index = $FD->db()->conn()->query ( '
                        SELECT `style_id`, `style_tag`
                        FROM `'.$FD->env('DB_PREFIX')."styles`
                        WHERE `style_id` = '".$_GET['style_id']."'
                        AND `style_allow_use` = 1
                        LIMIT 0,1" );
        $row = $index->fetch(PDO::FETCH_ASSOC);
        if ( $row !== false ) {
            $FD->setConfig('style', $row['style_tag'] );
            $FD->setConfig('style_tag', $row['style_tag'] );
            $FD->setConfig('style_id', $row['style_id'] );
        }
    }
}

?>
