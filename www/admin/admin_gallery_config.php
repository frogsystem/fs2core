<?php if ( ACP_GO === "gallery_config" ) {

/////////////////////////////////////
//// Locale Secure Data Function ////
/////////////////////////////////////
function secureData ( $DATA, $OUTPUT = FALSE ) {
    // Common
    settype ( $DATA['viewer_type'], 'integer' );
    settype ( $DATA['viewer_x'], 'integer' );
    settype ( $DATA['viewer_y'], 'integer' );
    settype ( $DATA['viewer_img_x'], 'integer' );
    settype ( $DATA['viewer_img_y'], 'integer' );

    // Images
    settype ( $DATA['img_max_x'], 'integer' );
    settype ( $DATA['img_max_y'], 'integer' );
    settype ( $DATA['img_small_max_x'], 'integer' );
    settype ( $DATA['img_small_max_y'], 'integer' );
    settype ( $DATA['img_max_size'], 'integer' );
    settype ( $DATA['img_rows'], 'integer' );
    settype ( $DATA['img_cols'], 'integer' );
    $DATA['img_order'] = $OUTPUT ? killhtml ( $DATA['img_order'] ) : savesql ( $DATA['img_order'] );
    $DATA['img_sort'] = $OUTPUT ? killhtml ( $DATA['img_sort'] ) : savesql ( $DATA['img_sort'] );
    $DATA['img_group'] = $OUTPUT ? killhtml ( $DATA['img_group'] ) : savesql ( $DATA['img_group'] );

    // Wallpapers
    settype ( $DATA['wp_max_x'], 'integer' );
    settype ( $DATA['wp_max_y'], 'integer' );
    settype ( $DATA['wp_small_max_x'], 'integer' );
    settype ( $DATA['wp_small_max_y'], 'integer' );
    settype ( $DATA['wp_max_size'], 'integer' );
    settype ( $DATA['wp_rows'], 'integer' );
    settype ( $DATA['wp_cols'], 'integer' );
    $DATA['wp_order'] = $OUTPUT ? killhtml ( $DATA['wp_order'] ) : savesql ( $DATA['wp_order'] );
    $DATA['wp_sort'] = $OUTPUT ? killhtml ( $DATA['img_sort'] ) : savesql ( $DATA['wp_sort'] );
    $DATA['wp_group'] = $OUTPUT ? killhtml ( $DATA['wp_group'] ) : savesql ( $DATA['wp_group'] );

    // Categories
    settype ( $DATA['cat_img_x'], 'integer' );
    settype ( $DATA['cat_img_y'], 'integer' );
    settype ( $DATA['cat_img_size'], 'integer' );

    return $DATA;
}

///////////////////////
//// Update Config ////
///////////////////////
if ( TRUE
    && validateFormData( $_POST['viewer_type'], "required,integer,between", array(0,2) )
    && validateFormData( array($_POST['viewer_x'], $_POST['viewer_y'], $_POST['viewer_img_x'], $_POST['viewer_img_y']), "required,integer,positive" )
    && validateFormData( array($_POST['img_max_x'], $_POST['img_max_y'], $_POST['img_small_max_x'], $_POST['img_small_max_y'], $_POST['img_max_size']), "required,integer,positive,notzero" )
    && validateFormData( array($_POST['wp_max_x'], $_POST['wp_max_y'], $_POST['wp_small_max_x'], $_POST['wp_small_max_y'], $_POST['wp_max_size']), "required,integer,positive,notzero" )
    && validateFormData( array($_POST['cat_img_x'], $_POST['cat_img_y'], $_POST['cat_img_size']), "required,integer,positive,notzero" )
    && validateFormData( array($_POST['img_rows'], $_POST['img_cols'], $_POST['wp_rows'], $_POST['wp_cols']), "required,integer,positive,notzero" )
    && validateFormData( array($_POST['img_order'], $_POST['img_sort'], $_POST['img_group'], $_POST['wp_order'], $_POST['wp_sort'], $_POST['wp_group']), "required" )
) {
    // Update Query
    $updateCols = array( "viewer_type", "viewer_x", "viewer_y", "viewer_img_x", "viewer_img_y", "img_max_x", "img_max_y", "img_small_max_x", "img_small_max_y", "img_max_size", "img_rows", "img_cols", "img_order", "img_group", "img_sort", "wp_max_x", "wp_max_y", "wp_small_max_x", "wp_small_max_y", "wp_max_size", "wp_rows", "wp_cols", "wp_order", "wp_sort", "wp_group", "cat_img_x", "cat_img_y", "cat_img_size" );
    $updateValues = array( $_POST['viewer_type'], $_POST['viewer_x'], $_POST['viewer_y'], $_POST['viewer_img_x'], $_POST['viewer_img_y'], $_POST['img_max_x'], $_POST['img_max_y'], $_POST['img_small_max_x'], $_POST['img_small_max_y'], $_POST['img_max_size'], $_POST['img_rows'], $_POST['img_cols'], $_POST['img_order'], $_POST['img_group'], $_POST['img_sort'], $_POST['wp_max_x'], $_POST['wp_max_y'], $_POST['wp_small_max_x'], $_POST['wp_small_max_y'], $_POST['wp_max_size'], $_POST['wp_rows'], $_POST['wp_cols'], $_POST['wp_order'], $_POST['wp_sort'], $_POST['wp_group'], $_POST['cat_img_x'], $_POST['cat_img_y'], $_POST['cat_img_size'] );
    
    if ( FALSE !== $sql->updateData ( "gallery_config", $updateCols, $updateValues, "WHERE `id` = 1" ) ) {
        // Update ok
        systext( $TEXT['admin']->get("changes_saved"), $TEXT['admin']->get("info"), FALSE, $TEXT["admin"]->get("icon_save_ok") );
    } else {
        // Update failed
        systext( $TEXT['admin']->get("changes_not_saved"), $TEXT["admin"]->get("error"), TRUE, $TEXT["admin"]->get("icon_save_error") );
    }
}

//////////////////////////
//// Show Config Form ////
//////////////////////////

// Display Error Messages
elseif ( isset($_POST['sended']) ) {
    systext( $TEXT['admin']->get("changes_not_saved")."<br>".$TEXT['admin']->get("form_not_filled")."<br>".$TEXT['admin']->get("form_only_allowed_values"), $TEXT["admin"]->get("error"), TRUE, $TEXT["admin"]->get("icon_save_error") );
// Load Data from DB into Post
} else {
    $config_arr = $sql->getData ( "gallery_config", "*", "", 1 );
    putintopost ( $config_arr );
}

// Secure Data for Output
secureData(&$_POST, TRUE);

// Template Conditions
$adminpage->addCond("viewer_type",      $_POST['viewer_type']);
$adminpage->addCond("img_order",        $_POST['img_order']);
$adminpage->addCond("img_sort",         $_POST['img_sort']);
$adminpage->addCond("img_group",        $_POST['img_group']);
$adminpage->addCond("wp_order",         $_POST['wp_order']);
$adminpage->addCond("wp_sort",          $_POST['wp_sort']);
$adminpage->addCond("wp_group",         $_POST['wp_group']);

// Template Texts
$adminpage->addText("ACP_GO",           ACP_GO);

$adminpage->addText("viewer_x",         $_POST['viewer_x']);
$adminpage->addText("viewer_y",         $_POST['viewer_y']);
$adminpage->addText("viewer_img_x",     $_POST['viewer_img_x']);
$adminpage->addText("viewer_img_y",     $_POST['viewer_img_y']);

$adminpage->addText("img_max_x",        $_POST['img_max_x']);
$adminpage->addText("img_max_y",        $_POST['img_max_y']);
$adminpage->addText("img_small_max_x",  $_POST['img_small_max_x']);
$adminpage->addText("img_small_max_y",  $_POST['img_small_max_y']);
$adminpage->addText("img_max_size",     $_POST['img_max_size']);
$adminpage->addText("img_rows",         $_POST['img_rows']);
$adminpage->addText("img_cols",         $_POST['img_cols']);

$adminpage->addText("wp_max_x",         $_POST['wp_max_x']);
$adminpage->addText("wp_max_y",         $_POST['wp_max_y']);
$adminpage->addText("wp_small_max_x",   $_POST['wp_small_max_x']);
$adminpage->addText("wp_small_max_y",   $_POST['wp_small_max_y']);
$adminpage->addText("wp_max_size",      $_POST['wp_max_size']);
$adminpage->addText("wp_rows",          $_POST['wp_rows']);
$adminpage->addText("wp_cols",          $_POST['wp_cols']);

$adminpage->addText("cat_img_x",        $_POST['cat_img_x']);
$adminpage->addText("cat_img_y",        $_POST['cat_img_y']);
$adminpage->addText("cat_img_size",     $_POST['cat_img_size']);

// Display Template
echo $adminpage->get("main");

} ?>