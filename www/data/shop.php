<?php
// Set canonical parameters
$FD->setConfig('info', 'canonical', array());

// Load Config Array
$FD->loadConfig('screens');
$screen_config_arr = $FD->configObject('screens')->getConfigArray();

// Get Data from DB
$index = $FD->db()->conn()->query ( '
                SELECT *
                FROM `'.$FD->config('pref').'shop`' );

// Security Functions
$shop_items = array();

// Get Item Templates
while ( $shop_arr = $index->fetch( PDO::FETCH_ASSOC ) ) {

    settype ( $shop_arr['artikel_id'], 'integer' );
    $shop_arr['artikel_text'] = fscode ( $shop_arr['artikel_text'], 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1 );

    if (image_exists('images/shop/', $shop_arr['artikel_id'])) {
        $imgurl = 'images/shop/'.basename(image_url('images/shop/', $shop_arr['artikel_id']));
    } else {
        $imgurl = 'styles/'.$FD->config('style').'/icons/image_error.gif';
    }
    $shop_arr['viewer_url'] = url('viewer', array('single' => 1), false, array('file' => $imgurl));
    
    if ( $screen_config_arr['show_type'] == 1 ) {
        $shop_arr['viewer_url'] = "javascript:popUp('".urlencode($shop_arr['viewer_url'])."','popupviewer','".$screen_config_arr['show_size_x']."','".$screen_config_arr['show_size_y']."');";
    }

    $template_item = new template();
    $template_item->setFile('0_shop.tpl');
    $template_item->load('SHOP_ITEM');

    $template_item->tag('item_titel', $shop_arr['artikel_name'] );
    $template_item->tag('item_text', $shop_arr['artikel_text'] );
    $template_item->tag('item_url', $shop_arr['artikel_url'] );
    $template_item->tag('item_price', $shop_arr['artikel_preis'] );
    $template_item->tag('item_image', get_image_output ( 'images/shop/', $shop_arr['artikel_id'], $shop_arr['artikel_name'] ) );
    $template_item->tag('item_image_url', image_url ( 'images/shop/', $shop_arr['artikel_id'] ) );
    $template_item->tag('item_image_viewer_url', $shop_arr['viewer_url'] );
    $template_item->tag('item_small_image', get_image_output ( 'images/shop/', $shop_arr['artikel_id'].'_s' , $shop_arr['artikel_name'] ) );
    $template_item->tag('item_small_image_url', image_url ( 'images/shop/', $shop_arr['artikel_id'].'_s' ) );

    $shop_items[] = $template_item->display();
}

// Body Template
$template = new template();
$template->setFile('0_shop.tpl');
$template->load('SHOP_BODY');
$template->tag('shop_items', implode ( '', $shop_items ) );

// Display Page
$template = $template->display();
?>
