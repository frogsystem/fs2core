<?php
// Load Article Config
$index = mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."partner_config", $FD->sql()->conn() );
$config_arr = mysql_fetch_assoc ( $index );

// Get Affiliates
$index = mysql_query ( "
                        SELECT *
                        FROM `".$global_config_arr['pref']."partner`
                        ORDER BY `partner_name`
", $FD->sql()->conn() );

$all_arr = array();
$perm_arr = array();
$non_arr = array();

while ( $affiliates_arr = mysql_fetch_assoc( $index ) ) {
    // Security Functions
    settype ( $affiliates_arr['partner_id'], "integer" );
    settype ( $affiliates_arr['partner_permanent'], "integer" );
    $affiliates_arr['partner_link'] = stripslashes ( $affiliates_arr['partner_link'] );
    $affiliates_arr['partner_name'] = stripslashes ( $affiliates_arr['partner_name'] );
    $affiliates_arr['partner_beschreibung'] = stripslashes ( $affiliates_arr['partner_beschreibung'] );

    // Get Template
    $template = new template();
    $template->setFile("0_affiliates.tpl");
    $template->load("ENTRY");

    $template->tag("url", $affiliates_arr['partner_link'] );
    $template->tag("img_url", image_url ( "images/partner/", $affiliates_arr['partner_id']."_big" ) );
    $template->tag("button_url", image_url ( "images/partner/", $affiliates_arr['partner_id']."_small" ) );
    $template->tag("name", $affiliates_arr['partner_name'] );
    $template->tag("text", $affiliates_arr['partner_beschreibung'] );

    $partner = $template->display ();

    $all_arr[] = $partner;
    ( $affiliates_arr['partner_permanent'] == 1 ) ? ( $perm_arr[] = $partner ) : null;
    ( $affiliates_arr['partner_permanent'] == 0 ) ? ( $non_arr[] = $partner ) : nul;
}

// Get Template
$template = new template();
$template->setFile("0_affiliates.tpl");
$template->load("BODY");

$template->tag("all_affiliates", implode ( "", $all_arr) );
$template->tag("permanents", implode ( "", $perm_arr) );
$template->tag("non_permanents", implode ( "", $non_arr) );

$template = $template->display ();
?>
