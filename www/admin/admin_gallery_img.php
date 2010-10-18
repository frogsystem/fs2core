<?php if ( ACP_GO === "gallery_img" ) {

/////////////////////////////////////
//// Locale Secure Data Function ////
/////////////////////////////////////
function secureData ( &$DATA, $OUTPUT = FALSE ) {
    global $sql;
/*
    // Common
    settype($DATA['cat_id'], 'integer');
    settype($DATA['cat_subcat_of'], 'integer');
    settype($DATA['cat_visibility'], 'integer');
    settype($DATA['cat_user'], 'integer');
    settype($DATA['cat_preview'], 'integer');
    settype($DATA['cat_order'], 'integer');

    $DATA['cat_name'] = $OUTPUT ? killhtml($DATA['cat_name']) : savesql($DATA['cat_name']);
    $DATA['cat_text'] = $OUTPUT ? killhtml($DATA['cat_text']) : savesql($DATA['cat_text']);
    $DATA['cat_type'] = $OUTPUT ? killhtml($DATA['cat_type']) : savesql($DATA['cat_type']);

    $DATA['cat_date'] = strtotime ( $DATA['cat_date'] );
    $DATA['cat_user_name'] = killhtml($sql->getData("user", "user_name", "WHERE `user_id` = '".$DATA['cat_user']."' LIMIT 0,1", 1));


    // TODO cat_date
    

        // Create Date-Arrays
        if ( !isset ( $_POST['d'] ) ) {
            $_POST['d'] = date ( "d", $cat_arr['cat_date'] );
            $_POST['m'] = date ( "m", $cat_arr['cat_date'] );
            $_POST['y'] = date ( "Y", $cat_arr['cat_date'] );
        }
        $date_arr = getsavedate ( $_POST['d'], $_POST['m'], $_POST['y'] );
        $nowbutton_array = array( "d", "m", "y" );*/
    return $DATA;
}
    
////////////////////
//// Get Config ////
////////////////////
$config_arr = $sql->getData("gallery_config", "img_max_x,img_max_y,img_max_size,img_mid_x,img_mid_y,img_small_x,img_small_y", "WHERE `id`=1", 1);


///////////////////////
//// Upload Images ////
///////////////////////
if (isset($_FILES['img_file']) && $_POST['sended'] == "add") {
    // Security
    settype($_POST['cat_id'], 'integer');
        
    // Create File Arr
    $upload_files = array();
    foreach($_FILES['img_file'] as $content_key => $data) {
        foreach($data as $data_key => $value) {
            $upload_files[$data_key][$content_key] = $value;
        }
    }
    
    // Image-Operations
    $messages = array();
    foreach ($upload_files as $key => $aFile) {
        
        // Check if File exists
        if ($aFile['name'] != "") {
            // Set File Data
            $aFile['img_title'] = savesql($_POST['img_title'][$key]);
            $aFile['img_date'] = time();
            $aFile['img_user'] = $_SESSION['user_id'];              
            $messages[$key]['name'] = $aFile['name'];
            
            // Insert into DB
            $upload_sql = $sql->setData("gallery_img", "img_title,img_date,img_user,cat_id", array($aFile['img_title'], $aFile['img_date'], $aFile['img_user'], $_POST['cat_id']));
            $new_id = $sql->lastInsertId();
            
            // Upload Image
            $upload = upload_img($aFile, "media/gallery/img/", $new_id, $config_arr['img_max_size']*1024, $config_arr['img_max_x'], $config_arr['img_max_y']);
            $messages[$key]['upload'] = upload_img_notice($upload);
            
            // Create other Versions on Success
            if ($upload === 0) {
                $mid = create_img_from(image_url("media/gallery/img/", $new_id, FALSE, TRUE), $config_arr['img_mid_x'], $config_arr['img_mid_y'], "_m");
                $messages[$key]['mid'] = create_thumb_notice($mid);
                $small = create_img_from(image_url("media/gallery/img/", $new_id, FALSE, TRUE), $config_arr['img_small_x'], $config_arr['img_small_y'], "_s");
                $messages[$key]['small'] = create_thumb_notice($small);
            // On Fail: Delete DB entry
            } else {
                $sql->deleteData("gallery_img", "WHERE `img_id` = '".$new_id."'", "LIMIT 0,1");
            }
        }
    }
    print_r($messages);
}



////////////////////
//// Edit Image ////
////////////////////

///////////////////////
//// Delete Images ////
///////////////////////

//////////////////////////////
//// Display Default-Page ////
//////////////////////////////
if (!isset($_POST['img_id']) && !isset($_POST['img_action'])) {

    /////////////////////////
    //// Load Cat-System ////
    /////////////////////////
    $cat_arr = array();
    get_cat_system( $cat_arr, array("table" => "gallery_cat", "select" => "cat_id,cat_name", "id" => "cat_id", "sub" => "cat_subcat_of", "order" => "ORDER BY `cat_order`, `cat_id`") );

    ////////////////////
    //// New Images ////
    ////////////////////

    // Display Error Messages
    if (isset($_POST['sended']) && in_array($_POST['sended'], array("add", "add_lines"))) {
        systext( $TEXT['admin']->get("changes_not_saved")."<br>".$TEXT['admin']->get("form_not_filled"), $TEXT["admin"]->get("error"), TRUE, $TEXT["admin"]->get("icon_save_error") );        
    // Set Defaults
    } else {
        $_POST['num_of_lines'] = 3;
        $_POST['new_lines'] = 0;
    }

    // Secure Data
    secureData($_POST, TRUE);

    // Get Options
    $cat_options = array();
    foreach ($cat_arr as $aCat) {
         // Cat-Name
        $aCat['cat_name_text'] = shortening_string($aCat['cat_name'],50,"...");
        $aCat['cat_name_text'] = killhtml($aCat['cat_name_text']);
                
        settype($aCat['cat_id'], "integer");
        $cat_options[] = '
                                        <option value="'.$aCat['cat_id'].'" '.getselected($aCat['cat_id'], $_POST['cat_id']).'>'.str_repeat("&nbsp;&nbsp;&nbsp;", $aCat['level']).$aCat['cat_name_text'].'</option>';
    }
    
    // Get Lines
    if ($_POST['sended'] == "add_lines") {
        $_POST['num_of_lines'] += $_POST['new_lines'];
        settype($_POST['num_of_lines'], "integer");
    }
    $add_lines = array();
    for ($i=0; $i<$_POST['num_of_lines']; $i++) {
        $adminpage->addText("line_number", $i);
        $add_lines[] = $adminpage->get("add_line");       
    }
    
    
    // Display Add-Form
    // Template Conditions
    #$adminpage->addCond("cat_subcat_of",    $_POST['cat_subcat_of']);

    // Template Texts
    $adminpage->addText("ACP_GO",           ACP_GO);
    $adminpage->addText("cat_options",      implode("", $cat_options));
    $adminpage->addText("lines",            implode("", $add_lines));
    $adminpage->addText("more_uploads_js",  ' onClick="galleryImgAddUploadLines();"');
    $adminpage->addText("config_max_x",     $config_arr['img_max_x']);
    $adminpage->addText("config_max_y",     $config_arr['img_max_y']);
    $adminpage->addText("config_max_size",  $config_arr['img_max_size']);
    $adminpage->addText("MAX_FILE_SIZE",    $config_arr['img_max_size']*1024);
    // Display Template
    echo $adminpage->get("add");
    
    
    ///////////////////////
    //// Select Images ////
    ///////////////////////
    
    // Get Images for selected Category
    $img_arr = $sql->getData("gallery_img", "img_id", "WHERE `cat_id` = 1"); 
    $img_arr = $sql->lastUseful() ? $img_arr : array();

    // Get the List
    $theList = new SelectList ( "img", $TEXT["page"]->get("select_images"), "gallery_img", 5 );
    $theList->setColumns ( array (
        array ( '&nbsp;&nbsp;'.$TEXT["page"]->get("id").'&nbsp;&nbsp;', array(), 20 ),
        array ( $TEXT["page"]->get("img") ),
        array ( $TEXT["page"]->get("title") ),
        array ( $TEXT["admin"]->get("cat") ),
        array ( "", array(), 20 )
    ) );
    $theList->setNoLinesText($TEXT["page"]->get("imgs_not_found"));
    $theList->addAction("0", $TEXT["admin"]->get("selection_noaction"), array(), TRUE, TRUE);
    $theList->addAction("edit", $TEXT["admin"]->get("selection_edit"), array("select_one"));
    $theList->addAction("delete", $TEXT["admin"]->get("selection_delete"), array("select_red"));
    $theList->addAction("change_cat", $TEXT["page"]->get("selection_change_cat"), array());
    $theList->addAction("rebuild_mid", $TEXT["page"]->get("selection_rebuild_mid"), array());
    $theList->addAction("rebuild_small", $TEXT["page"]->get("selection_rebuild_small"), array());
    $theList->addButton();

    // Display Cats
    foreach ($img_arr as $aImg) {
        // Get Image Data
        $aImg = $sql->getData("gallery_img", "img_id,img_title,img_caption,cat_id", "WHERE `img_id` = '".$aImg['img_id']."'"); 
        $theCat = $sql->getData("gallery_cat", "cat_name", "WHERE `cat_id` = '".$aImg['cat_id']."'"); 
        
        // do something
        
        $theList->addLine ( array (
            array ( "#".$aCat['cat_id'], array ( "middle", "center" ) ),
            array ( $aCat['cat_name_text'], array ( "middle" ) ),
            array ( '<a href="'.$global_config_arr['virtualhost'].'?go=gallery&amp;cat_id='.$aCat['cat_id'].'" target="_blank">»&nbsp;'.$TEXT["admin"]->get("show").'</a>', array ( "middle", "left", "small" ) ),
            array ( $aCat['cat_type_text'], array ( "middle", "left" ) ),
            array ( $aCat['cat_visibility_text'], array ( "middle", "left" ) ),
            array ( TRUE, $aCat['cat_id'] )
        ) );
    }
    // Output
    echo $theList;    
}

} ?>
