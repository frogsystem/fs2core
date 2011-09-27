<?php
// Load Article Config
$index = mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."partner_config", $FD->sql()->conn() );
$config_arr = mysql_fetch_assoc ( $index );

// Get Affiliates
$index = mysql_query ( "
                        SELECT *
                        FROM `".$global_config_arr['pref']."partner`
                        ORDER BY `partner_id`
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
    $template->load("APPLET_ENTRY");
    
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

// Vars for Random-Selections
$rand_arr['shuffle_non_perm'] = ( count ( $non_arr ) < $config_arr['partner_anzahl'] ) ? count ( $non_arr ) : $config_arr['partner_anzahl'];
$rand_arr['shuffle_all'] = ( count ( $all_arr ) < $config_arr['partner_anzahl'] ) ? count ( $all_arr ) : $config_arr['partner_anzahl'];

// Security Functions
$all_affiliates_list = "";
$non_permanents_list = "";

// Random Selection
if ( $rand_arr['shuffle_non_perm'] > 0 ) {
    shuffle ( $non_arr );
    for ( $i = 0; $i < $rand_arr['shuffle_non_perm']; $i++ ) {
        $non_permanents_list .= $non_arr[$i];
    }
}
if ( $rand_arr['shuffle_all'] > 0) {
    shuffle ( $all_arr );
    for ( $i = 0; $i < $rand_arr['shuffle_all']; $i++ ) {
        $all_affiliates_list .= $all_arr[$i];
    }
}
// Permanents List
$permanents_list = implode ( "", $perm_arr);

// Get Template
$template = new template();
$template->setFile("0_affiliates.tpl");
$template->load("APPLET_BODY");

$template->tag("all_affiliates", $all_affiliates_list );
$template->tag("permanents", $permanents_list );
$template->tag("non_permanents", $non_permanents_list );

$template = $template->display ();
?>
