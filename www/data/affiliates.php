<?php
// Load Article Config
$FD->loadConfig('affiliates');
$config_arr = $FD->configObject('affiliates')->getConfigArray();

// Get Affiliates
$index = $FD->db()->conn()->query ( '
                SELECT *
                FROM `'.$FD->config('pref').'partner`
                ORDER BY `partner_name`' );

$all_arr = array();
$perm_arr = array();
$non_arr = array();

while ( $affiliates_arr = $index->fetch( PDO::FETCH_ASSOC ) ) {
    // Security Functions
    settype ( $affiliates_arr['partner_id'], 'integer' );
    settype ( $affiliates_arr['partner_permanent'], 'integer' );

    // Get Template
    $template = new template();
    $template->setFile('0_affiliates.tpl');
    $template->load('ENTRY');

    $template->tag('url', $affiliates_arr['partner_link'] );
    $template->tag('img_url', image_url ( 'images/partner/', $affiliates_arr['partner_id'].'_big' ) );
    $template->tag('button_url', image_url ( 'images/partner/', $affiliates_arr['partner_id'].'_small' ) );
    $template->tag('name', $affiliates_arr['partner_name'] );
    $template->tag('text', $affiliates_arr['partner_beschreibung'] );

    $partner = $template->display ();

    $all_arr[] = $partner;
    ( $affiliates_arr['partner_permanent'] == 1 ) ? ( $perm_arr[] = $partner ) : null;
    ( $affiliates_arr['partner_permanent'] == 0 ) ? ( $non_arr[] = $partner ) : null;
}

// Get Template
$template = new template();
$template->setFile('0_affiliates.tpl');
$template->load('BODY');

$template->tag('all_affiliates', implode ( '', $all_arr) );
$template->tag('permanents', implode ( '', $perm_arr) );
$template->tag('non_permanents', implode ( '', $non_arr) );

$template = $template->display ();
?>
