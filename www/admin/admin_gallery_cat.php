<?php if ( ACP_GO === "gallery_cat" ) {

/////////////////////////////////////
//// Locale Secure Data Function ////
/////////////////////////////////////
function secureData ( $DATA, $OUTPUT = FALSE ) {
    global $sql;

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
    /*

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

/////////////////////
//// Load Config ////
/////////////////////
$config_arr = $sql->getData("gallery_config", "*", "", 1);


/////////////////////
//// DB: Add Cat ////
/////////////////////
if ( TRUE
    && validateFormData( $_POST['sended'], "required,oneof", array("add") )
    && validateFormData( $_POST['cat_action'], "required,oneof", array("add") )

    && validateFormData( $_POST['cat_name'], "required,text", "(.{3,100})" )
    && validateFormData( array($_POST['cat_subcat_of'], $_POST['cat_visibility']), "required,integer,positive" )
    && validateFormData( $_POST['cat_type'], "required,oneof", array("img", "wp") )
) {
    // Secure Data
    secureData(&$_POST);

    // Insert Data
    $insertCols= array("cat_name", "cat_subcat_of", "cat_type", "cat_visibility", "cat_date", "cat_user", "cat_preview", "cat_order");
    $insertValues = array($_POST['cat_name'], $_POST['cat_subcat_of'], $_POST['cat_type'], $_POST['cat_visibility'], time(), $_SESSION['user_id'], 0, 7);

    if ( FALSE !== $sql->setData("gallery_cat", $insertCols, $insertValues) ) {
        // Insert ok
        systext( $TEXT['admin']->get("cat_added"), $TEXT['admin']->get("info"), FALSE, $TEXT["admin"]->get("icon_save_add") );
        // Set Vars For Edit
        unset($_POST);
        $_POST['cat_action'] = "edit";
        $_POST['cat_id'] = array($sql->lastInsertId());
    } else {
        // Insert failed
        unset($_POST['cat_action'],$_POST['cat_id']);
        systext( $TEXT['admin']->get("cat_not_added"), $TEXT["admin"]->get("error"), TRUE, $TEXT["admin"]->get("icon_save_error") );
    }
}

//////////////////////
//// DB: Edit Cat ////
//////////////////////
elseif (
        isset ( $_POST['cat_id'] ) &&
        isset ( $_POST['sended'] ) && $_POST['sended'] == "edit" &&
        isset ( $_POST['cat_action'] ) && $_POST['cat_action'] == "edit" &&
        
        $_POST['d'] && $_POST['d'] != "" && $_POST['d'] > 0 &&
        $_POST['m'] && $_POST['m'] != "" && $_POST['m'] > 0 &&
        $_POST['y'] && $_POST['y'] != "" && $_POST['y'] > 0 &&
        
        $_POST['cat_name'] && $_POST['cat_name'] != "" &&
        isset ( $_POST['cat_user'] )
    )
{
    // Security-Functions
    $_POST['cat_name'] = savesql ( $_POST['cat_name'] );
    $_POST['cat_description'] = savesql ( $_POST['cat_description'] );
    settype ( $_POST['cat_id'], "integer" );
    settype ( $_POST['cat_user'], "integer" );
    $date_arr = getsavedate ( $_POST['d'], $_POST['m'], $_POST['y'] );
    $cat_date = mktime ( 0, 0, 0, $date_arr['m'], $date_arr['d'], $date_arr['y'] );

    // MySQL-Update-Query
    mysql_query ("
                    UPDATE ".$global_config_arr['pref']."news_cat
                     SET
                         cat_name             = '".$_POST['cat_name']."',
                         cat_description     = '".$_POST['cat_description']."',
                         cat_date             = '".$cat_date."',
                         cat_user             = '".$_POST['cat_user']."'
                     WHERE
                         cat_id                 = '".$_POST['cat_id']."'
    ", $db );
    $message = $admin_phrases[common][changes_saved];

    // Image-Operations
    if ( $_POST['cat_pic_delete'] == 1 ) {
      if ( image_delete ( "images/cat/", "news_".$_POST['cat_id'] ) ) {
        $message .= "<br>" . $admin_phrases[common][image_deleted];
      } else {
        $message .= "<br>" . $admin_phrases[common][image_not_deleted];
      }
    } elseif ( $_FILES['cat_pic']['name'] != "" ) {
      image_delete ( "images/cat/", "news_".$_POST['cat_id'] );
      $upload = upload_img ( $_FILES['cat_pic'], "images/cat/", "news_".$_POST['cat_id'], $news_config_arr['cat_pic_size']*1024, $news_config_arr['cat_pic_x'], $news_config_arr['cat_pic_y'] );
      $message .= "<br>" . upload_img_notice ( $upload );
    }
    
    // Display Message
    systext ( $message, $admin_phrases[common][info] );
    
    // Unset Vars
    unset ( $_POST );
    $showdefault = FALSE;
}

////////////////////////
//// DB: Delete Cat ////
////////////////////////
elseif ( TRUE
    && validateFormData( $_POST['sended'], "required,oneof", array("delete") )
    && validateFormData( $_POST['cat_action'], "required,oneof", array("delete") )
) {
    // Check Yes-No-Ansert
    if ($_POST['cat_delete'] == 1) { // Yes

        // Security Function
        $_POST['cat_id'] = array_map("intval", explode(",", $_POST['cat_id']));
        $messages = array();

        // get cats from db
        $cat_arr = $sql->getData("gallery_cat", "cat_id,cat_subcat_of", "WHERE `cat_id` IN (".implode(",", $_POST['cat_id']).") ORDER BY `cat_id`");

        // cats found
        if ($sql->isUsefulGet()) {
            $successful = array("db" => TRUE, "img" => TRUE);
            foreach ($cat_arr as $aCat) {
                 if (TRUE
                     && FALSE !== $sql->updateData("gallery_cat", "cat_subcat_of", $aCat['cat_subcat_of'], "WHERE `cat_subcat_of` = '".$aCat['cat_id']."'")
                     #&& FALSE !== $sql->updateData("gallery_img", "cat_id", 0, "WHERE `cat_id` = '".$aCat['cat_id']."'")
                     #&& FALSE !== $sql->updateData("gallery_wp", "cat_id", 0, "WHERE `cat_id` = '".$aCat['cat_id']."'")
                     && FALSE !== $sql->deleteData("gallery_cat", "`cat_id` = '".$aCat['cat_id']."'", "LIMIT 1")
                 ) {
                    // Delete Cat Image
                    if (image_exists("media/gallery/cat/", $aCat['cat_id']) && !image_delete("media/gallery/cat/", $aCat['cat_id'])) {
                        $successful['img'] = FALSE;
                    }
                 } else {
                    $successful['db'] = FALSE;
                 }
            }
        }
        $messages[] = $successful['db'] ? $TEXT["admin"]->get("cats_deleted") : $TEXT["admin"]->get("cats_not_all_deleted");
        $messages[] = $successful['img'] ? $TEXT["admin"]->get("images_deleted") : $TEXT["admin"]->get("images_not_all_deleted");

        $color = !$successful['db'] ? "red"                                   : (!$successful['img'] ? "yellow"                                  : "green");
        $title = !$successful['db'] ? $TEXT["admin"]->get("error")            : (!$successful['img'] ? $TEXT["admin"]->get("caution")            : $TEXT["admin"]->get("info"));
        $icon  = !$successful['db'] ? $TEXT["admin"]->get("icon_trash_error") : (!$successful['img'] ? $TEXT["admin"]->get("icon_trash_caution") : $TEXT["admin"]->get("icon_trash_ok"));
        
        systext(implode("<br>", $messages), $title, $color, $icon);

    // Don't delete
    } else {
        //TODO
        systext ( $TEXT["admin"]->get("cats_not_deleted"), $TEXT["admin"]->get("info"), "green", $TEXT["admin"]->get("icon_trash_error") );
    }

    // Unset Vars
    unset($_POST);
}

// ???  //TODO
if ($_POST['cat_action']=="add") {
    unset ( $_POST['cat_action'], $_POST['cat_id'] );
}

//////////////////////
//// DB: Order Up ////
//////////////////////

////////////////////////
//// DB: Order Down ////
////////////////////////


//////////////////////////////
//// Display Action-Pages ////
//////////////////////////////
if (is_array($_POST['cat_id']) && isset($_POST['cat_action'])) {

    // Security Function
    $_POST['cat_id'] = array_map ( "intval", $_POST['cat_id'] );

    ///////////////////////
    //// Edit Cat Form ////
    ///////////////////////
    if ($_POST['cat_action'] == "edit" && count($_POST['cat_id']) == 1) {

        // Only First ID of Array
        $_POST['cat_id'] = $_POST['cat_id'][0];

        // Display Error Messages
        if($_POST['sended']=="edit") {
            systext($TEXT["admin"]->get("note_notfilled"), $TEXT["admin"]->get("error"), TRUE, $TEXT["admin"]->get("icon_save_error") );

        // Get Data from DB
        } else {
            $cat_arr = $sql->getData("gallery_cat", "*", "WHERE `cat_id` = '".$_POST['cat_id']."'", 1);
            $cat_arr = $sql->lastUseful() ? $cat_arr : array();
            putintopost($cat_arr);
        }
        
        // Secure Data for Output
        secureData(&$_POST, TRUE);

        // Get Subcats
        $subcat_arr = array();
        $sub_cat_ids = array();
        $subcat_options = array();
        
        $SQL = array("table" => "gallery_cat", "select" => "*", "id" => "cat_id", "sub" => "cat_subcat_of", "order" => "ORDER BY `cat_order`, `cat_id`");
        get_cat_system(&$subcat_arr, $SQL);
        get_all_sub_cats($_POST['cat_id'], $SQL, $sub_cat_ids);
        foreach ($subcat_arr as $aCat) {
            if ($aCat['cat_id'] != $_POST['cat_id'] && !in_array($aCat['cat_id'], $sub_cat_ids)) {
                settype($aCat['cat_id'], "integer");
                $subcat_options[] = '
                                            <option value="'.$aCat['cat_id'].'" '.getselected($aCat['cat_id'], $_POST['cat_subcat_of']).'>'.str_repeat("&nbsp;&nbsp;&nbsp;", $aCat['level']).killhtml($aCat['cat_name']).'</option>';
            }
        }

        // Display Page

        // Template Conditions
        $adminpage->addCond("image_exists",     image_exists("media/gallery/cat/", $_POST['cat_id']));
        $adminpage->addCond("type",             $_POST['cat_type']);
        $adminpage->addCond("visibility",       $_POST['cat_visibility']);
        
        // Template Texts
        $adminpage->addText("ACP_GO",           ACP_GO);
        $adminpage->addText("cat_id",           $_POST['cat_id']);
        $adminpage->addText("cat_name",         $_POST['cat_name']);
        $adminpage->addText("subcat_options",   implode("", $subcat_options));
        $adminpage->addText("cat_date",         date("Y-m-d", $cat_arr['cat_date']));
        $adminpage->addText("today",            get_datebutton(array("cat_date", ""), $TEXT["admin"]->get("today")));
        $adminpage->addText("reset_date",       get_datebutton(array("cat_date", $cat_arr['cat_date']*1000), $TEXT["admin"]->get("reset")));
        $adminpage->addText("cat_user",         $_POST['cat_user']);
        $adminpage->addText("cat_user_name",    $_POST['cat_user_name']);
        $adminpage->addText("find_user_popup",  openpopup("admin_finduser.php", 400, 400));
        $adminpage->addText("image_url",        $_POST['cat_id']);
        $adminpage->addText("cat_text",         $_POST['cat_text']);

        $adminpage->addText("config_img_x",     $config_arr['cat_img_x']);
        $adminpage->addText("config_img_y",     $config_arr['cat_img_y']);
        $adminpage->addText("config_img_size",  $config_arr['cat_img_size']);
        
        // Display Template
        echo $adminpage->get("edit");
    
    }
    //////////////////////////////////////////////////////////////
    //// Show to much selected Error & Go back to Select Form ////
    //////////////////////////////////////////////////////////////
    elseif ($_POST['cat_action'] == "edit" && count($_POST['cat_id']) > 1) {
        // Display Error
        systext( $TEXT["admin"]->get("select_only_one_to_edit"), $TEXT["admin"]->get("error"), TRUE, $TEXT["admin"]->get("icon_error") );
        unset($_POST['cat_id']);
    }
    
    
    
    //////////////////////////
    //// Delete Cats Form ////
    //////////////////////////
    elseif ($_POST['cat_action'] == "delete" && count($_POST['cat_id']) >= 1) {

        // get cats from db
        array_map("intval", $_POST['cat_id']);
        $cat_arr = $sql->getData("gallery_cat", "*", "WHERE `cat_id` IN (".implode(",", $_POST['cat_id']).") ORDER BY `cat_order`,`cat_id`");
        
        // cats found
        $cat_ids = array();
        $cat_preview = array();
        if ($sql->isUsefulGet()) {
            // Get Data
            foreach ($cat_arr as $aCat) {
                // Secutity Functions
                settype($aCat['cat_id'], "integer");
                $aCat['cat_name'] = killhtml($aCat['cat_name']);

                // Cat-ID-Array
                $cat_ids[]      = $aCat['cat_id'];

                // Create Entry
                // Template Texts
                $adminpage->addText("cat_id",           $aCat['cat_id']);
                $adminpage->addText("cat_name",         '<span title="'.$aCat['cat_name'].'"><b>'.shortening_string($aCat['cat_name'], 40, "...").'</b></span>');
                $adminpage->addText("cat_url",          $global_config_arr['virtualhost'].'?go=gallery&amp;cat_id='.$aCat['cat_id']);
                $adminpage->addText("cat_type",         str_replace(array("img", "wp"), array($TEXT["page"]->get("type_img"), $TEXT["page"]->get("type_wp")), $aCat['cat_type']));
                $adminpage->addText("cat_visibility",   str_replace(array(0, 1, 2), array($TEXT["page"]->get("visibility_none_long"), $TEXT["page"]->get("visibility_full_long"), $TEXT["page"]->get("visibility_notinlist_long")), $aCat['cat_visibility']));
                // Display Template
                $cat_preview[] = $adminpage->get("delete_entry");
            }

            // Create Preivew-List
            $adminpage->clearCond();
            $adminpage->clearTexts();
            $adminpage->addText("previews",         implode("<br>", $cat_preview));

            // Get DeletePage
            $deletePage = new DeletePage("cat", $TEXT["page"]->get("delete_title"), $TEXT["page"]->get("delete_question"), $cat_ids, $adminpage->get("delete"));
            echo $deletePage;
            
        } else {
            unset($_POST['cat_id'], $_POST['cat_action']);
        }
    }
    
    // Reset data and go to default page
    else {
        unset($_POST['cat_id'], $_POST['cat_action']);
    }
}

// Reset data and go to default page
else {
    unset($_POST['cat_id'], $_POST['cat_action']);
}

//////////////////////////////
//// Display Default-Page ////
//////////////////////////////
if (!isset($_POST['cat_id']) && !isset($_POST['cat_action'])) {

    /////////////////////////
    //// Load Cat-System ////
    /////////////////////////
    $cat_arr = array();
    get_cat_system( &$cat_arr, array("table" => "gallery_cat", "select" => "*", "id" => "cat_id", "sub" => "cat_subcat_of", "order" => "ORDER BY `cat_order`, `cat_id`") );


    //////////////////////
    //// New Category ////
    //////////////////////

    // Display Error Messages
    if (isset($_POST['sended']) && $_POST['sended'] == "add") {
        systext( $TEXT['admin']->get("changes_not_saved")."<br>".$TEXT['admin']->get("form_not_filled"), $TEXT["admin"]->get("error"), TRUE, $TEXT["admin"]->get("icon_save_error") );
    // Set Defaults
    } else {
        $_POST['cat_type'] = "img";
        $_POST['cat_visibility'] = 1;
        $_POST['cat_subcat_of'] = 0;
    }

    // Secure Data
    secureData(&$_POST, TRUE);

    // Get Options
    $subcat_options = array();
    foreach ($cat_arr as $aCat) {
        settype($aCat['cat_id'], "integer");
        $subcat_options[] = '
                                        <option value="'.$aCat['cat_id'].'" '.getselected($aCat['cat_id'], $_POST['cat_subcat_of']).'>'.str_repeat("&nbsp;&nbsp;&nbsp;", $aCat['level']).killhtml($aCat['cat_name']).'</option>';
    }

    // Display Add-Form
    // Template Conditions
    $adminpage->addCond("cat_subcat_of",    $_POST['cat_subcat_of']);
    $adminpage->addCond("cat_type",         $_POST['cat_type']);
    $adminpage->addCond("cat_visibility",   $_POST['cat_visibility']);
    // Template Texts
    $adminpage->addText("ACP_GO",           ACP_GO);
    $adminpage->addText("cat_name",         $_POST['cat_name']);
    $adminpage->addText("subcat_options",   implode("", $subcat_options));
    // Display Template
    echo $adminpage->get("add");


    /////////////////////////
    //// Select Category ////
    /////////////////////////
    
    // Get the List
    $theList = new SelectList ( "cat", $TEXT["admin"]->get("cats_select"), "gallery_cat", 6 );
    $theList->setColumns ( array (
        array ( '&nbsp;&nbsp;'.$TEXT["page"]->get("id").'&nbsp;&nbsp;', array(), 20 ),
        array ( $TEXT["admin"]->get("cat") ),
        array ( "" ),
        array ( $TEXT["page"]->get("select_type") ),
        array ( $TEXT["page"]->get("select_viewable") ),
        array ( "", array(), 20 )
    ) );
    $theList->setNoLinesText($TEXT["admin"]->get("cats_not_found"));
    $theList->addAction("0", $TEXT["admin"]->get("selection_noaction"), array(), TRUE, TRUE);
    $theList->addAction("edit", $TEXT["admin"]->get("selection_edit"), array("select_one"));
    $theList->addAction("delete", $TEXT["admin"]->get("selection_delete"), array("select_red"));
    $theList->addAction("up", $TEXT["admin"]->get("selection_up"), array());
    $theList->addAction("down", $TEXT["admin"]->get("selection_down"), array());
    $theList->addButton();

    // Display Cats
    foreach ($cat_arr as $aCat) {
        
        // Arrow for Sub-Cats
        $sub_arrow = ($aCat['level'] >= 1) ? $TEXT["admin"]->get("sub_arrow")."&nbsp;" : "";
        $aCat['new_level'] = $aCat['level'] >= 1 ? $aCat['level']-1 : $aCat['level'];
        $aCat['level_add'] = str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;", $aCat['new_level']).$sub_arrow;
         // Cat-Name
        $aCat['cat_name_text'] = ($aCat['level'] >= 5) ? shortening_string($aCat['cat_name'],25,"...") : shortening_string($aCat['cat_name'],45,"...");
        $aCat['cat_name_text'] = $aCat['level_add'].'<span title="'.killhtml($aCat['cat_name']).'">'.killhtml($aCat['cat_name_text']).'</span>';
        // Cat-Type-Text
        $aCat['cat_type_text'] = str_replace(array("img", "wp"), array($TEXT["page"]->get("type_img"), $TEXT["page"]->get("type_wp")), $aCat['cat_type']);
        // Visibility-Text
        $aCat['cat_visibility_text'] = str_replace(array(0, 1, 2), array($TEXT["page"]->get("visibility_none"), $TEXT["page"]->get("visibility_full"), $TEXT["page"]->get("visibility_notinlist")), $aCat['cat_visibility']);
        
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
