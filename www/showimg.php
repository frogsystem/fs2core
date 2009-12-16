<?php
// Start Session
session_start ();
// Disable magic_quotes_runtime
set_magic_quotes_runtime ( FALSE );

// fs2 include path
set_include_path ( '.' );
define ( FS2_ROOT_PATH, "./", TRUE );

// Inlcude DB Connection File
require ( FS2_ROOT_PATH . "login.inc.php");

if ($db)
{
    //Include Functions-Files
    require ( FS2_ROOT_PATH . "includes/functions.php" );
    require ( FS2_ROOT_PATH . "includes/imagefunctions.php" );
    require ( FS2_ROOT_PATH . "includes/indexfunctions.php" );
    
    //Include Library-Classes
    require ( FS2_ROOT_PATH . "libs/class_template.php" );
    require ( FS2_ROOT_PATH . "libs/class_fileaccess.php" );
    require ( FS2_ROOT_PATH . "libs/class_langDataInit.php" );
    
    //Get TEXT-Data
    $TEXT = new langDataInit ( $global_config_arr['language_text'], "frontend" );

    // Constructor Calls
    set_style ();


    // Security Functions
    $_GET['cat_id'] = ( isset ( $_GET['catid'] ) ) ? $_GET['catid'] : $_GET['cat_id'];
    $_GET['img_id'] = ( isset ( $_GET['screenid'] ) ) ? $_GET['screenid'] : $_GET['img_id'];
    settype( $_GET['cat_id'], "integer" );
    settype( $_GET['img_id'], "integer" );

    // Config Array
    $index = mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."screen_config", $db );
    $config_arr = mysql_fetch_assoc ( $index ) ;

    // Get Image Data
    if ( isset ( $_GET['screen'] ) ) {
        $index = mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."screen WHERE screen_id = ".$_GET['img_id']."", $db );
        $data_array['caption'] = stripslashes ( mysql_result ( $index, 0, "screen_name" ) );
        $data_array['image'] = image_url ( "images/screenshots/", $_GET['img_id'], FALSE );
        $data_array['image_url'] = image_url ( "images/screenshots/", $_GET['img_id'] );

        // exists a NEXT image?
        $index = mysql_query ( "
                                SELECT * FROM `".$global_config_arr['pref']."screen`
                                WHERE `cat_id` = ".$_GET['cat_id']."
                                AND `screen_id` > ".$_GET['img_id']."
                                ORDER BY `screen_id`
                                LIMIT 1
        ", $db );
        
        if ( mysql_num_rows ( $index ) > 0 ) {
            $next_id = mysql_result ( $index, 0, "screen_id" );
            // Do some stuff for next image
        }

        // exists a PREVIOUS image?
        $index = mysql_query ( "
                                SELECT * FROM `".$global_config_arr['pref']."screen`
                                WHERE `cat_id` = ".$_GET['cat_id']."
                                AND `screen_id` < ".$_GET['img_id']."
                                ORDER BY `screen_id` DESC
                                LIMIT 1
        ", $db );
        
        if ( mysql_num_rows ( $index ) > 0 ) {
            $prev_id = mysql_result ( $index, 0, "screen_id" );
            // Do some stuff for prev image
        }

    }

    $max_width = $config_arr['show_img_x'];
    $max_height = $config_arr['show_img_y'];

    list ( $data_array['width'], $data_array['height'] ) = getimagesize ( $data_array['image_url'] );
    $data_array['ratio'] = $data_array['width'] / $data_array['height'];
    
    if ( $data_array['width'] <= $config_arr['show_img_x'] && $data_array['height'] <= $config_arr['show_img_y'] ) {
        $data_array['image'] = '<img src="'.$data_array['image'].'" alt="'.$data_array['caption'].'">';
    } elseif ( $data_array['ratio'] > 1 && ( $config_arr['show_img_x'] / $data_array['ratio'] <= $config_arr['show_img_y'] ) ) { // landscape
        $data_array['image'] = '<img src="'.$data_array['image'].'" width="'.$config_arr['show_img_x'].'" alt="'.$data_array['caption'].'">';
    } else { // portait
        $data_array['image'] = '<img src="'.$data_array['image'].'" height="'.$config_arr['show_img_y'].'" alt="'.$data_array['caption'].'">';
    }


    $template_viewer = str_replace("{weiter_grafik}", $next, $template_viewer);
    $template_viewer = str_replace("{zurück_grafik}", $prev, $template_viewer);


    // Create PopUp-Viewer-Template
    $template_popupviewer = new template();

    $template_popupviewer->setFile("0_general.tpl");
    $template_popupviewer->load("POPUPVIEWER");

    $template_popupviewer->tag( "image", $data_array['image'] );
    $template_popupviewer->tag( "image_url", $data_array['image_url'] );
    $template_popupviewer->tag( "caption", $data_array['caption'] );
    $template_popupviewer->tag( "prev_url", $data_array[''] );
    $template_popupviewer->tag( "prev_link", $data_array[''] );
    $template_popupviewer->tag( "prev_image_link", $data_array[''] );
    $template_popupviewer->tag( "next_url", $data_array[''] );
    $template_popupviewer->tag( "next_link", $data_array[''] );
    $template_popupviewer->tag( "next_image_link", $data_array[''] );

    $template_popupviewer = $template_popupviewer->display();


    // Get Main Template
    $template = get_maintemplate ();
    $template = str_replace ( "{..body..}", $template_popupviewer, $template);

    // Display Page
    echo $template;

    // Close Connection
    mysql_close ( $db );
}
?>