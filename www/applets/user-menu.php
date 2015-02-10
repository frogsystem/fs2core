<?php

///////////////////////////
//// Display User Menü ////
///////////////////////////

if ( is_loggedin() ) {
    // Get some data
    $user_id = $_SESSION['user_id'];
    settype ( $user_id, 'integer' );
    $image_url = image_url ( '/user-images', $user_id ) ;
    if ( image_exists ( '/user-images', $user_id ) ) {
        $image_link = '<img src="'.$image_url .'" alt="'.$FD->text('frontend', 'user_image_of').' '.kill_replacements ( $_SESSION['user_name'], TRUE ).'">';
    } else {
        $image_link = '';
    }

    // Get Template
    $template = new template();
    $template->setFile('0_user.tpl');
    $template->load('APPLET_MENU');

    $template->tag('user_name', kill_replacements ( $_SESSION['user_name'], TRUE ));
    $template->tag('user_id', $user_id);
    $template->tag('user_image', $image_link);
    $template->tag('user_image_url', $image_url);
    $template->tag('user_edit_url', url('user_edit'));
    $template->tag('logout_url', url('logout'));

    // Admin-Link
    $index = $FD->db()->conn()->query ('
                            SELECT `user_id`, `user_is_staff`, `user_is_admin`
                            FROM '.$FD->env('DB_PREFIX')."user
                            WHERE `user_id` = '".$user_id."'" );
    $data_arr = $index->fetch( PDO::FETCH_ASSOC );
    if ( $data_arr['user_is_staff'] == 1 || $data_arr['user_is_admin'] == 1 || $data_arr['user_id'] == 1 ) {
        $template_admincp = new template();
        $template_admincp->setFile('0_user.tpl');
        $template_admincp->load('APPLET_ADMINLINE');
        $template_admincp->tag('admincp_link', '<a href="'.$FD->config('virtualhost').'admin/">'.$FD->text('frontend', 'user_admincp_title').'</a>');

        $template_admincp->tag('admincp_url', $FD->config('virtualhost').'admin/');
        $template_admincp = $template_admincp->display();
    } else {
        $template_admincp = '';
    }

    $template->tag('admincp_line', $template_admincp);
    $template = $template->display();
}

////////////////////////////
//// Display Login-Menu ////
////////////////////////////
else {
    $template = new template();
    $template->setFile('0_user.tpl');
    $template->load('APPLET_LOGIN');
    $template = $template->display();
}
?>
