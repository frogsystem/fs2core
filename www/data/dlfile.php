<?php
// Set canonical parameters
$FD->setConfig('info', 'canonical', array('id'));

// Load Config Array
$data = $sql->getField('config', 'config_data', array('W' => "`config_name` = 'downloads'"));
$config_arr = json_array_decode($data);

$index = mysql_query ( '
                        SELECT `show_type`, `show_size_x`, `show_size_y`
                        FROM `'.$FD->config('pref').'screen_config`
                        WHERE `id` = 1
', $FD->sql()->conn() );
$screen_config_arr = mysql_fetch_assoc ( $index );

// Security Functions
$_GET['id'] = ( isset ( $_GET['fileid'] ) && !isset ( $_GET['id'] ) ) ? $_GET['fileid'] : $_GET['id'];
settype( $_GET['id'], 'integer' );

$index = mysql_query('SELECT * FROM '.$FD->config('pref')."dl WHERE dl_id = $_GET[id] AND dl_open = 1", $FD->sql()->conn() );
if (mysql_num_rows($index) > 0)
{
    $dl_arr = mysql_fetch_assoc($index);

    //Seitentitel
    $FD->setConfig('dyn_title_page', stripslashes ( $dl_arr['dl_name'] ));

    //Config einlesen
    $dl_config_arr = $config_arr;

    // Username auslesen
    $index = mysql_query('SELECT user_name FROM '.$FD->config('pref')."user WHERE user_id = $dl_arr[user_id]", $FD->sql()->conn() );
    $dl_arr['user_name'] = kill_replacements ( mysql_result($index, 0, 'user_name'), TRUE );
    $dl_arr['user_url'] = url('user', array('id' => $dl_arr['user_id']));

    // Link zum Autor generieren
    if (!isset($dl_arr['dl_autor'])) {
        $dl_arr['dl_autor_link'] = '-';
    } else {
        $dl_arr['dl_autor_link'] = '<a href="'.$dl_arr['dl_autor_url'].'" target="_blank">'.$dl_arr['dl_autor'].'</a>';
    }

    $dl_arr['dl_bild'] = image_url( 'images/downloads/', $dl_arr['dl_id'] );
    if ( image_exists ( 'images/downloads/', $dl_arr['dl_id'] ) ) {
        $dl_arr['viewer_link'] = 'imageviewer.php?file=images/downloads/'. basename ( $dl_arr['dl_bild'] ).'&single';
    } else {
        $dl_arr['viewer_link'] = 'imageviewer.php?file=styles/'.$FD->config('style').'/icons/image_error.gif&single';
    }

    if ( $screen_config_arr['show_type'] == 1 ) {
        $dl_arr['viewer_link'] = "javascript:popUp('".$dl_arr['viewer_link']."','popupviewer','".$screen_config_arr['show_size_x']."','".$screen_config_arr['show_size_y']."');";
    }
    $dl_arr['dl_thumb'] = image_url('images/downloads/', $dl_arr['dl_id'].'_s');

    // Sonstige Daten ermitteln
    $dl_arr['dl_date'] = date_loc ( $FD->config('date'), $dl_arr['dl_date'] );
    $dl_arr['dl_text'] = fscode($dl_arr['dl_text']);
    $index3 = mysql_query('SELECT cat_name FROM '.$FD->config('pref')."dl_cat WHERE cat_id = '$dl_arr[cat_id]'", $FD->sql()->conn() );
    $dl_arr['cat_name'] = stripslashes(mysql_result($index3, 0, 'cat_name'));



    if ($dl_config_arr['dl_rights']==2) {
      $dl_use = '';
    } elseif ($dl_config_arr['dl_rights']==1 AND $_SESSION['user_level'] == 'loggedin') {
      $dl_use = '';
    } else {
      $dl_use = "AND file_is_mirror = '1'";
    }

    //Messages generieren
    if ($dl_config_arr['dl_rights']==0) {
      if ($messages_template != '')
        $messages_template .= '<br>';
      $messages_template .= $FD->text('frontend', 'dl_not_allowed');
    }

    if ($dl_config_arr['dl_rights']==1 AND $_SESSION['user_level'] != 'loggedin') {
      if ($messages_template != '')
        $messages_template .= '<br>';
      $messages_template .= $FD->text('frontend', 'dl_not_logged_in');
    }

    if ($messages_template != '')
      $messages_template .= '<br>';
    $messages_template .= $FD->text('frontend', 'dl_not_save_as');


    // Files auslesen
    if ( $index = mysql_query('SELECT * FROM '.$FD->config('pref')."dl_files WHERE dl_id = $dl_arr[dl_id] $dl_use", $FD->sql()->conn() )) {
        $stats_arr['number'] = mysql_num_rows($index);

        while ($file_arr = mysql_fetch_assoc($index)) {
            $stats_arr['size'] = $stats_arr['size'] + $file_arr['file_size'];
            $stats_arr['hits'] = $stats_arr['hits'] + $file_arr['file_count'];
            $stats_arr['traffic'] = $stats_arr['traffic'] + ($file_arr['file_count']*$file_arr['file_size']);

            $file_arr['file_traffic'] = getsize ( $file_arr['file_size'] * $file_arr['file_count'] );
            $file_arr['file_size'] = getsize ( $file_arr['file_size'] );

            $mirror_template = '';
            $mirror_col = ' colspan="2"';
            if ( $file_arr['file_is_mirror'] == 1 ) {
                // Get Template
                $mirror_template = new template();
                $mirror_template->setFile('0_downloads.tpl');
                $mirror_template->load('ENTRY_FILE_IS_MIRROR');
                $mirror_template = $mirror_template->display ();
                $mirror_col = '';
            }

            // Get Template
            $template = new template();
            $template->setFile('0_downloads.tpl');
            $template->load('ENTRY_FILE_LINE');

            $template->tag('name', stripslashes ( $file_arr['file_name'] ) );
            $template->tag('url', url($_GET['go'], array('id' => $file_arr['file_id'], 'dl' => 'TRUE')));
            $template->tag('size', $file_arr['file_size'] );
            $template->tag('traffic', $file_arr['file_traffic'] );
            $template->tag('hits', $file_arr['file_count'] );
            $template->tag('mirror_ext', $mirror_template );
            $template->tag('mirror_col', $mirror_col );

            $template = $template->display ();
            $files .= $template;
        }
    }

    // Stats erstellen
    $stats_arr['number'] = ( $stats_arr['number'] == 1 ) ? $stats_arr['number'].' '.$FD->text("frontend", "download_file") : $stats_arr['number'].' '.$FD->text("frontend", "download_files");
    $stats_arr['traffic'] = getsize($stats_arr['traffic']);
    $stats_arr['size'] = getsize($stats_arr['size']);


    // Get Template
    $template = new template();
    $template->setFile('0_downloads.tpl');
    $template->load('ENTRY_STATISTICS');

    $template->tag('number', $stats_arr['number'] );
    $template->tag('size', $stats_arr['size'] );
    $template->tag('traffic', $stats_arr['traffic'] );
    $template->tag('hits', $stats_arr['hits'] );

    $template = $template->display ();
    $stats = $template;


    // Suchfeld auslesen
    if ( is_numeric ( $dl_arr['cat_id'] ) && $dl_arr['cat_id'] > 0 ) {
        settype ( $dl_arr['cat_id'], 'integer' );
    } else {
        $dl_arr['cat_id'] = 'all';
    }

    $suchfeld = new template();
    $suchfeld->setFile('0_downloads.tpl');
    $suchfeld->load('SEARCH');

    $suchfeld->tag('input_cat', '<input name="cat_id" value="'.$dl_arr['cat_id'].'" type="hidden">' );
    $suchfeld->tag('keyword', '' );
    $suchfeld->tag('all_url', url('download', array('cat_id' => $dl_arr['cat_id'])));

    $suchfeld = $suchfeld->display ();

    // Navigation erzeugen
    $valid_ids = array();
    get_dl_categories ($valid_ids, $dl_arr['cat_id'], $config_arr['dl_show_sub_cats'] );

    foreach ( $valid_ids as $cat ) {
        if ($cat['cat_id'] == $dl_arr['cat_id']) {
            $icon_url = $FD->config('virtualhost').'styles/'.$FD->config('style').'/icons/folder_open.gif';
        } else {
            $icon_url = $FD->config('virtualhost').'styles/'.$FD->config('style').'/icons/folder.gif';
        }
        // Get Navigation Line Template
        $template = new template();
        $template->setFile('0_downloads.tpl');
        $template->load('NAVIGATION_LINE');

        $template->tag('icon_url', $icon_url );
        $template->tag('cat_url', url('download', array('cat_id' => $cat['cat_id'])));
        $template->tag('cat_name', stripslashes ( $cat['cat_name'] ) );

        $template = $template->display ();
        $navi_lines .= str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $cat['level']) . $template;
    }

    // Get Navigation Template
    $template = new template();
    $template->setFile('0_downloads.tpl');
    $template->load('NAVIGATION_BODY');
    $template->tag('lines', $navi_lines );
    $navi = $template->display ();



    // Get Body Template
    $template = new template();
    $template->setFile('0_downloads.tpl');
    $template->load('ENTRY_BODY');

    $template->tag('title', stripslashes ( $dl_arr['dl_name'] ) );
    $template->tag('img_url', $dl_arr['dl_bild'] );
    $template->tag('thumb_url', $dl_arr['dl_thumb'] );
    $template->tag('viewer_link', $dl_arr['viewer_link'] );
    $template->tag('navigation', $navi );
    $template->tag('search', $suchfeld );
    $template->tag('uploader', $dl_arr['user_name'] );
    $template->tag('uploader_url', $dl_arr['user_url'] );
    $template->tag('author', $dl_arr['dl_autor'] );
    $template->tag('author_url', $dl_arr['dl_autor_url'] );
    $template->tag('author_link', $dl_arr['dl_autor_link'] );
    $template->tag('date', $dl_arr['dl_date'] );
    $template->tag('cat_name', $dl_arr['cat_name'] );
    $template->tag('text', $dl_arr['dl_text'] );
    $template->tag('files', $files );
    $template->tag('statistics', $stats );
    $template->tag('messages', $messages_template );

    $template = $template->display ();
} else {
    $template = sys_message($FD->text('frontend', 'sysmessage'), $FD->text('frontend', 'dl_not_exist'), 404);
}
?>
