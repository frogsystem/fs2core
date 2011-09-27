<?php

///////////////////////////
//// Display User Menü ////
///////////////////////////

if ( $_SESSION['user_level'] == "loggedin" ) {
    // Get some data
    $user_id = $_SESSION["user_id"];
    settype ( $user_id, "integer" );
    $image_url = image_url ( "media/user-images/", $user_id ) ;
    if ( image_exists ( "media/user-images/", $user_id ) ) {
        $image_link = '<img src="'.$image_url .'" alt="'.$TEXT['frontend']->get("user_image_of").' '.kill_replacements ( $_SESSION['user_name'], TRUE ).'">';
    } else {
        $image_link = '';
    }

    // Get Template
    $template = new template();
    $template->setFile("0_user.tpl");
    $template->load("APPLET_MENU");

    $template->tag("user_name", kill_replacements ( $_SESSION['user_name'], TRUE ));
    $template->tag("user_id", $user_id);
    $template->tag("user_image", $image_link);
    $template->tag("user_image_url", $image_url);
    $template->tag("user_edit_url", "?go=user_edit");
    $template->tag("logout_url", "?go=logout");

    // Admin-Link
    $index = mysql_query ("
                            SELECT `user_id`, `user_is_staff`, `user_is_admin`
                            FROM ".$global_config_arr['pref']."user
                            WHERE `user_id` = '".$user_id."'
    ", $FD->sql()->conn() );
    $data_arr = mysql_fetch_assoc ( $index );
    if ( $data_arr['user_is_staff'] == 1 || $data_arr['user_is_admin'] == 1 || $data_arr['user_id'] == 1 ) {
        $template_admincp = new template();
        $template_admincp->setFile("0_user.tpl");
        $template_admincp->load("APPLET_ADMINLINE");

        $template_admincp->tag("admincp_link", '<a href="'.$global_config_arr['virtualhost'].'admin/">'.$TEXT['frontend']->get("user_admincp_title").'</a>');
        $template_admincp->tag("admincp_url", $global_config_arr['virtualhost']."admin/");
        $template_admincp = $template_admincp->display();
    } else {
        $template_admincp = '';
    }
    
    $template->tag("admincp_line", $template_admincp);
    $template = $template->display();
}

////////////////////////////
//// Display Login-Menu ////
////////////////////////////
else {
    $template = new template();
    $template->setFile("0_user.tpl");
    $template->load("APPLET_LOGIN");
    $template = $template->display();
}
?>
