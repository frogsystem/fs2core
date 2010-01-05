<?php
// Load Config Array
$index = mysql_query ( "
                        SELECT *
                        FROM `".$global_config_arr['pref']."screen_random_config`
                        WHERE `id` = 1
", $db);
$config_arr = mysql_fetch_assoc ( $index );

// Load Config Array
$index = mysql_query ( "
                        SELECT *
                        FROM `".$global_config_arr['pref']."screen_config`
                        WHERE `id` = 1
", $db);
$config_arr = array_merge ( (array)$config_arr, (array)mysql_fetch_assoc ( $index ) );

// Check System
if ( $config_arr['active'] == 1 ) {

    // Select Preview Image System
    if ( $config_arr['type_priority'] == 1 ) {
        $data = get_timed_pic ();
    } else {
        $data = get_random_pic ();
    }

    // Select other System if use both Systems
    if ( $data == FALSE && $config_arr['use_priority_only'] != 1 ) {
        if ( $config_arr['type_priority'] == 1 ) {
            $data = get_random_pic ();
        } else {
            $data = get_timed_pic ();
        }
    }

    if ( $data != FALSE ) {

        if ( $data['type'] == 1 ) {
            $link = "showimg.php?id=".$data['id']."&single";
        } else {
            $link = "showimg.php?id=".$data['id'];
        }
        
        if ( $config_arr['show_type'] == 1 ) {
            $half_x = floor ( $config_arr['show_size_x'] / 2 );
            $half_y = floor ( $config_arr['show_size_y'] / 2 );
            $link = "javascript:popUp('".$link."','popupviewer','".$config_arr['show_size_x']."','".$config_arr['show_size_y']."');";
        }

        // Get Template
        $template = new template();
        $template->setFile("0_previewimg.tpl");
        $template->load("BODY");
        
        $template->tag("previewimg", get_image_output ( "images/screenshots/", $data['id'] . "_s", $data['caption'] ) );
        $template->tag("previewimg_url", image_url ( "images/screenshots/", $data['id'] . "_s" ) );
        $template->tag("image_url", image_url ( "images/screenshots/", $data['id'] ) );
        $template->tag("viewer_url", $link);
        $template->tag("caption", $data['caption']);
        $template->tag("cat_title", $data['cat_title']);
        
        $template = $template->display();
    } else {
        // Get Template
        $template = new template();
        $template->setFile("0_previewimg.tpl");
        $template->load("NOIMAGE_BODY");
        $template = $template->display();
    }
} else {
  $template = "";
}
?>