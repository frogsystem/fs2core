<?php
// Get Data from DB
$index = $FD->sql()->conn()->query ( '
                        SELECT
                            `artikel_id`, `artikel_name`, `artikel_url`, `artikel_preis`
                        FROM
                            `'.$FD->config('pref').'shop`
                        WHERE
                            `artikel_hot` = 1' );

// Security Functions
$applet_items = array();

// Get Item Templates
while ( $shop_arr = $index->fetch( PDO::FETCH_ASSOC ) ) {

    settype ( $shop_arr['artikel_id'], 'integer' );
    $shop_arr['artikel_name'] = stripslashes ( $shop_arr['artikel_name'] );

    $template_item = new template();
    $template_item->setFile('0_shop.tpl');
    $template_item->load('APPLET_ITEM');

    $template_item->tag('item_titel', $shop_arr['artikel_name'] );
    $template_item->tag('item_url', stripslashes ( $shop_arr['artikel_url'] ) );
    $template_item->tag('item_price', stripslashes ( $shop_arr['artikel_preis'] ) );
    $template_item->tag('item_image', get_image_output ( 'images/shop/', $shop_arr['artikel_id'], $shop_arr['artikel_name'] ) );
    $template_item->tag('item_image_url', image_url ( 'images/shop/', $shop_arr['artikel_id'] ) );
    $template_item->tag('item_small_image', get_image_output ( 'images/shop/', $shop_arr['artikel_id'].'_s' , $shop_arr['artikel_name'] ) );
    $template_item->tag('item_small_image_url', image_url ( 'images/shop/', $shop_arr['artikel_id'].'_s' ) );

    $applet_items[] = $template_item->display();
}

// Body Template
$template = new template();
$template->setFile('0_shop.tpl');
$template->load('APPLET_BODY');
$template->tag('applet_items', implode ( '', $applet_items ) );

// Display Page
$template = $template->display();
?>
