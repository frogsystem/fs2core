<?php
// Start Session
session_start ();
// Disable magic_quotes_runtime
set_magic_quotes_runtime ( FALSE );

// fs2 include path
set_include_path ( '.' );
define ( FS2_ROOT_PATH, './', TRUE );

// Inlcude DB Connection File
require ( FS2_ROOT_PATH . 'login.inc.php');

if ($FD->sql()->conn() )
{
    //Include Functions-Files
    require ( FS2_ROOT_PATH . 'includes/functions.php' );
    require ( FS2_ROOT_PATH . 'includes/imagefunctions.php' );
    require ( FS2_ROOT_PATH . 'includes/indexfunctions.php' );

    //Include Library-Classes
    require ( FS2_ROOT_PATH . 'libs/class_template.php' );
    require ( FS2_ROOT_PATH . 'libs/class_fileaccess.php' );
    require ( FS2_ROOT_PATH . 'libs/class_langDataInit.php' );

    // Constructor Calls
    set_style ();


    // Security Functions
    $_GET['id'] = ( isset ( $_GET['screenid'] ) ) ? $_GET['screenid'] : $_GET['id'];
    settype( $_GET['id'], 'integer' );
    $_GET['single'] = ( isset ( $_GET['single'] ) ) ? TRUE : FALSE;

    // Config Array
    $FD->loadConfig('screens');
    $config_arr = $FD->configObject('screens')->getConfigArray();

    // No Image found yet
    $image_found = FALSE;
    $data_array['caption'] = '';
    $data_array['prev_url'] = '';
    $data_array['prev_link'] = '';
    $data_array['prev_image_link'] = '';
    $data_array['next_url'] = '';
    $data_array['next_link'] = '';
    $data_array['next_image_link'] = '';

    // Any Image?
    if ( isset ( $_GET['file'] ) && $_GET['file'] != '' ) {
        $path_parts = pathinfo ( $_GET['file'] );
        $data_array['image'] = image_url ( $path_parts['dirname'].'/', $path_parts['filename'], FALSE );
        $data_array['image_url'] = image_url ( $path_parts['dirname'].'/', $path_parts['filename'] );
        $data_array['image_sizeinfo'] = image_url ( $path_parts['dirname'].'/', $path_parts['filename'], FALSE, TRUE );
        $image_found = TRUE;

    // Gallery Image
    } else {
        // Get Image Data
        $index = mysql_query ( '
                                SELECT `screen_name`, `cat_id` FROM `'.$FD->config('pref').'screen`
                                WHERE `screen_id` = '.$_GET['id'].'
                                LIMIT 0,1
        ', $FD->sql()->conn() );

        $data_array['image'] = image_url ( 'images/screenshots/', $_GET['id'], FALSE );
        $data_array['image_url'] = image_url ( 'images/screenshots/', $_GET['id'] );
        $data_array['image_sizeinfo'] = image_url ( 'images/screenshots/', $_GET['id'], FALSE, TRUE );

        if ( mysql_num_rows ( $index ) == 1 ) {
            $data_array['caption'] = stripslashes ( mysql_result ( $index, 0, 'screen_name' ) );
            $cat_id = mysql_result ( $index, 0, 'cat_id' );
            settype( $cat_id, 'integer' );
            $image_found = TRUE;
        }
    }

    // Gallery or Any Image
    if ( $image_found === TRUE ) {

        // Single Image
        if ( $_GET['single'] === TRUE ) {

            // Maybe do somethin'

        // No single Image
        } else {
            // exists a NEXT image?
            $index = mysql_query ( '
                                    SELECT `screen_id`
                                    FROM `'.$FD->config('pref').'screen`
                                    WHERE `cat_id` = '.$cat_id.'
                                    AND `screen_id` > '.$_GET['id'].'
                                    ORDER BY `screen_id`
                                    LIMIT 0,1
            ', $FD->sql()->conn() );

            if ( mysql_num_rows ( $index ) == 1 ) {
                $next_id = mysql_result ( $index, 0, 'screen_id' );

                $data_array['next_url'] = 'imageviewer.php?id='.$next_id;
                $data_array['next_link'] = '<a href="'.$data_array['next_url'].'" target="_self">'.$FD->text('frontend', 'popupviewer_next_text').'</a>';
                $data_array['next_image_link'] = '<a href="'.$data_array['next_url'].'" target="_self">'.$FD->text('frontend', 'popupviewer_next_image').'</a>';
            }

            // exists a PREVIOUS image?
            $index = mysql_query ( '
                                    SELECT `screen_id`
                                    FROM `'.$FD->config('pref').'screen`
                                    WHERE `cat_id` = '.$cat_id.'
                                    AND `screen_id` < '.$_GET['id'].'
                                    ORDER BY `screen_id` DESC
                                    LIMIT 0,1
            ', $FD->sql()->conn() );

            if ( mysql_num_rows ( $index ) == 1 ) {
                $prev_id = mysql_result ( $index, 0, 'screen_id' );

                $data_array['prev_url'] = 'imageviewer.php?id='.$prev_id;
                $data_array['prev_link'] = '<a href="'.$data_array['prev_url'].'" target="_self">'.$FD->text('frontend', 'popupviewer_prev_text').'</a>';
                $data_array['prev_image_link'] = '<a href="'.$data_array['prev_url'].'" target="_self">'.$FD->text('frontend', 'popupviewer_prev_image').'</a>';
            }

        }

        if ( $data_array['image'] != '' ) {
            $max_width = $config_arr['show_img_x'];
            $max_height = $config_arr['show_img_y'];

            if ( @getimagesize ( $data_array['image_sizeinfo'] ) !== FALSE ) {
            $data_array['image_sizeinfo'] = getimagesize ( $data_array['image_sizeinfo'] );
            $data_array['width'] = $data_array['image_sizeinfo'][0];
            $data_array['height'] = $data_array['image_sizeinfo'][1];
            $data_array['ratio'] = $data_array['width'] / $data_array['height'];

                if ( $data_array['width'] <= $config_arr['show_img_x'] && $data_array['height'] <= $config_arr['show_img_y'] ) {
                    $data_array['image'] = '<img src="'.$data_array['image'].'" alt="'.$data_array['caption'].'">';
                } elseif ( $data_array['ratio'] > 1 && ( $config_arr['show_img_x'] / $data_array['ratio'] <= $config_arr['show_img_y'] ) ) { // landscape
                    $data_array['image'] = '<img src="'.$data_array['image'].'" width="'.$config_arr['show_img_x'].'" alt="'.$data_array['caption'].'">';
                } else { // portait
                    $data_array['image'] = '<img src="'.$data_array['image'].'" height="'.$config_arr['show_img_y'].'" alt="'.$data_array['caption'].'">';
                }
            } else {
                $data_array['image'] = '<img src="'.$data_array['image'].'" alt="'.$data_array['caption'].'">';
            }
        }
    }

    // Create PopUp-Viewer-Template
    $template_popupviewer = new template();

    $template_popupviewer->setFile('0_general.tpl');
    $template_popupviewer->load('POPUPVIEWER');

    $template_popupviewer->tag( 'image', $data_array['image'] );
    $template_popupviewer->tag( 'image_url', $data_array['image_url'] );
    $template_popupviewer->tag( 'caption', $data_array['caption'] );
    $template_popupviewer->tag( 'prev_url', $data_array['prev_url'] );
    $template_popupviewer->tag( 'prev_link', $data_array['prev_link'] );
    $template_popupviewer->tag( 'prev_image_link', $data_array['prev_image_link'] );
    $template_popupviewer->tag( 'next_url', $data_array['next_url'] );
    $template_popupviewer->tag( 'next_link', $data_array['next_link'] );
    $template_popupviewer->tag( 'next_image_link', $data_array['next_image_link'] );

    $template_popupviewer = $template_popupviewer->display();
    $template_popupviewer = replace_snippets ( $template_popupviewer );
    $template_popupviewer = replace_navigations ( $template_popupviewer );
    $template_popupviewer = replace_applets ( $template_popupviewer );
    $template_popupviewer = replace_navigations ( $template_popupviewer );
    $template_popupviewer = replace_snippets ( $template_popupviewer );

    $template_popupviewer = replace_globalvars ( $template_popupviewer );

    // Get Main Template
    $template = get_maintemplate ();
    $template = str_replace ( '{..body..}', $template_popupviewer, $template);

    // Display Page
    echo $template;

    // Close Connection
    mysql_close ( $FD->sql()->conn() );
}
?>
