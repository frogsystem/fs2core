<?php if (ACP_GO === "gallery_cat") {

//TODO
//- nach oben/unten von den 2. obersten/untersten kategorien führt zum tausch der beiden kategorien
//- Ordner


/////////////////////////////////////
//// Locale Secure Data Function ////
/////////////////////////////////////
function secureData(&$DATA, $OUTPUT = FALSE) {
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

    $DATA['cat_user_name'] = killhtml($sql->getData("user", "user_name", "WHERE `user_id` = '".$DATA['cat_user']."' LIMIT 0,1", 1));

    $DATA['cat_date'] = strtotime($DATA['cat_date']);
    $DATA['cat_date_format'] = date("Y-m-d", $DATA['cat_date']);


    $DATA['content_order'] = $OUTPUT ? killhtml($DATA['content_order']) : savesql($DATA['content_order']);
    $DATA['content_sort'] = $OUTPUT ? killhtml($DATA['content_sort']) : savesql($DATA['content_sort']);
    $DATA['content_group'] = $OUTPUT ? killhtml($DATA['content_group']) : savesql($DATA['content_group']);
    $DATA['content_sub_contents'] = $OUTPUT ? killhtml($DATA['content_sub_contents']) : savesql($DATA['content_sub_contents']);
    $DATA['content_default_folder'] = $OUTPUT ? killhtml($DATA['content_default_folder']) : savesql($DATA['content_default_folder']);

    return $DATA;
}

function orderSubCategories($cat_id) {
    global $sql;
    
    settype($cat_id, "integer");
    $cat_arr = $sql->getData("gallery_cat", "cat_id", "WHERE `cat_subcat_of` = '".$cat_id."' ORDER BY `cat_order`, `cat_id`");
    
    $i = 0;
            
    foreach($cat_arr as $aCat){
        $sql->updateData("gallery_cat", "cat_order", $i, "WHERE `cat_id` = '".$aCat['cat_id']."'");
        $i++;
    }
    
}

/////////////////////
//// Load Config ////
/////////////////////
$config_arr = $sql->getData("gallery_config", "*", "", 1);


/////////////////////
//// DB: Add Cat ////
/////////////////////
if (TRUE
    && validateFormData( $_POST['sended'], "required,oneof", array("add") )
    && validateFormData( $_POST['cat_action'], "required,oneof", array("add") )

    && validateFormData( $_POST['cat_name'], "required,text", "(.{3,100})" )
    && validateFormData( array($_POST['cat_subcat_of'], $_POST['cat_visibility']), "required,integer,positive" )
    && validateFormData( $_POST['cat_type'], "required,oneof", array("img", "wp") )
) {
    // Secure Data
    secureData($_POST);

    // Insert Data
    $insertCols= array("cat_name", "cat_subcat_of", "cat_type", "cat_visibility", "cat_date", "cat_user", "cat_preview", "cat_order", "content_order", "content_sort", "content_group", "content_sub_contents", "content_default_folder");
    $insertValues = array($_POST['cat_name'], $_POST['cat_subcat_of'], $_POST['cat_type'], $_POST['cat_visibility'], time(), $_SESSION['user_id'], 0, 32767, 0, 0, 0, 0, 0);

    if ( FALSE !== $sql->setData("gallery_cat", $insertCols, $insertValues) ) {
        // Get Insert ID
        $new_id = $sql->lastInsertId();
        // Insert ok
        systext( $TEXT['admin']->get("cat_added"), $TEXT['admin']->get("info"), FALSE, $TEXT["admin"]->get("icon_save_add") );
        orderSubCategories($_POST['cat_subcat_of']);
        // Set Vars For Edit
        unset($_POST);
        $_POST['cat_action'] = "edit";
        $_POST['cat_id'] = array($new_id);
    } else {
        // Insert failed
        unset($_POST['cat_action'],$_POST['cat_id']);
        systext( $TEXT['admin']->get("cat_not_added"), $TEXT["admin"]->get("error"), TRUE, $TEXT["admin"]->get("icon_save_error") );
    }
}

//////////////////////
//// DB: Edit Cat ////
//////////////////////
elseif (TRUE
        && is_array($_POST['cat_id'])
        && validateFormData($_POST['cat_id'][0], "required,integer")
        && validateFormData($_POST['sended'], "required,oneof", array("edit"))
        && validateFormData($_POST['cat_action'], "required,oneof", array("edit"))        

        && validateFormData($_POST['cat_name'], "required,text", "(.{3,100})")
        && validateFormData(array($_POST['cat_subcat_of'], $_POST['cat_visibility']), "required,integer,positive")
        && validateFormData($_POST['cat_type'], "required,oneof", array("img", "wp"))        
        
        && validateFormData($_POST['cat_date'], "required")
        && (validateFormData($_POST['cat_user'], "required,integer,positive,notzero") || validateFormData($_POST['cat_user_name'], "required,text", "(.{1,100})"))
        
        && validateFormData( $_POST['content_order'], "required,oneof", array("0", "date", "id", "title") )
        && validateFormData( $_POST['content_sort'], "required,oneof", array("0", "ASC", "DESC") )
        && validateFormData( $_POST['content_group'], "required,oneof", array("0", "none", "date", "title", "user") )
        && validateFormData( $_POST['content_sub_contents'], "required,oneof", array("0", "none", "first", "all") )
        && validateFormData( $_POST['content_default_folder'], "required" )
    )
{
    // Get User Data
    settype($_POST['cat_user'], 'integer');
    $_POST['cat_user_name'] = savesql($_POST['cat_user_name']);
    $user_arr = $sql->getData("user", "user_id", "WHERE `user_name` = '".$_POST['cat_user_name']."'", 1);
    if (FALSE !== $user_arr) {
        $_POST['cat_user'] = $user_arr['user_id'];
    }
    
    // Secure Data
    $_POST['cat_id'] = $_POST['cat_id'][0];
    secureData($_POST);

    // MySQL-Update-Query
    $cols   = "cat_name,cat_text,cat_subcat_of,cat_type,cat_visibility,cat_date,cat_user,content_order,content_sort,content_group,content_sub_contents,content_default_folder";
    $values = array($_POST['cat_name'], $_POST['cat_text'], $_POST['cat_subcat_of'], $_POST['cat_type'], $_POST['cat_visibility'], $_POST['cat_date'], $_POST['cat_user'], $_POST['content_order'], $_POST['content_sort'], $_POST['content_group'], $_POST['content_sub_contents'], $_POST['content_default_folder']);
    
    if (FALSE !== $sql->updateData("gallery_cat", $cols, $values, "WHERE `cat_id` = '".$_POST['cat_id']."' LIMIT 1")) {
        // Messages
        $messages = array ($TEXT['admin']->get("changes_saved"));
        $color = "green";
        
        // Image Operations
        $image_folder = "media/gallery/cat/";
        if ($_POST['cat_img_delete'] == 1) {
            // Delete Image
            if (image_delete($image_folder, $_POST['cat_id'])) {
                $messages[] = $TEXT["admin"]->get("cat_image_deleted");
            } elseif(image_exists($image_folder, $_POST['cat_id'])) {
                $messages[] = $TEXT["admin"]->get("cat_image_not_deleted");
                $color = "yellow";
            }
            
        // Upload new Image
        } elseif($_FILES['cat_img']['name'] != "") {
            image_delete($image_folder, $_POST['cat_id']);
            $upload = upload_img($_FILES['cat_img'], $image_folder, $_POST['cat_id'], $config_arr['cat_img_size']*1024, $config_arr['cat_img_x'], $config_arr['cat_img_y']);
            $messages[] = upload_img_notice($upload);
        }        
        
        // Update ok        
        systext(implode("<br>", $messages), $TEXT['admin']->get("info"), $color, $TEXT["admin"]->get("icon_save_ok"));
        orderSubCategories($_POST['cat_subcat_of']);
        
        // Reset Vars
        unset($_POST);
    } else {
        // Update failed
        systext( $TEXT['admin']->get("changes_not_saved"), $TEXT["admin"]->get("error"), TRUE, $TEXT["admin"]->get("icon_save_error") );
    }
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
                     && FALSE !== $sql->updateData("gallery_img", "cat_id", 0, "WHERE `cat_id` = '".$aCat['cat_id']."'")
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
        $messages[] = $successful['img'] ? $TEXT["admin"]->get("cat_images_deleted") : $TEXT["admin"]->get("cat_images_not_all_deleted");

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


//////////////////////
//// DB: Order Up ////
//////////////////////
elseif ( TRUE
    && !isset($_POST['sended'])
    && validateFormData($_POST['cat_action'], "required,oneof", array("up"))
    && is_array($_POST['cat_id'])
) {
    // Security Function
    $_POST['cat_id'] = array_map ( "intval", $_POST['cat_id'] );    
    
    // Update for each Category
    foreach($_POST['cat_id'] as $catId) {
        $cat_arr = $sql->getData("gallery_cat", "cat_id,cat_order,cat_subcat_of", "WHERE `cat_id` = '".$catId."'", 1);
        if (FALSE !== $cat_arr) {
            if ($cat_arr['cat_order'] != 0) {
                // Update Categories, above the selected
                if ($sql->updateData("gallery_cat", "cat_order", $cat_arr['cat_order'], "WHERE `cat_subcat_of` = '".$cat_arr['cat_subcat_of']."' AND `cat_order` = '".($cat_arr['cat_order']-1)."'")
                    && $sql->updateData("gallery_cat", "cat_order", ($cat_arr['cat_order']-1), "WHERE `cat_id` = '".$cat_arr['cat_id']."'")) {
                }
                orderSubCategories($cat_arr['cat_subcat_of']);
            }
        }
    }
    systext($TEXT["admin"]->get("cats_up"), $TEXT["admin"]->get("info"), "green", $TEXT["admin"]->get("icon_up"));
}


////////////////////////
//// DB: Order Down ////
////////////////////////
elseif ( TRUE
    && !isset($_POST['sended'])
    && validateFormData($_POST['cat_action'], "required,oneof", array("down"))
    && is_array($_POST['cat_id'])
) {
    // Security Function
    $_POST['cat_id'] = array_reverse(array_map("intval", $_POST['cat_id']));    
    
    // Update for each Category
    foreach($_POST['cat_id'] as $catId) {
        $cat_arr = $sql->getData("gallery_cat", "cat_id,cat_order,cat_subcat_of", "WHERE `cat_id` = '".$catId."'", 1);
        if (FALSE !== $cat_arr) {
            // Update Categories, below the selected
            if ($sql->updateData("gallery_cat", "cat_order", $cat_arr['cat_order'], "WHERE `cat_subcat_of` = '".$cat_arr['cat_subcat_of']."' AND `cat_order` = '".($cat_arr['cat_order']+1)."'")
                && $sql->updateData("gallery_cat", "cat_order", ($cat_arr['cat_order']+1), "WHERE `cat_id` = '".$cat_arr['cat_id']."'")) {
            }
            orderSubCategories($cat_arr['cat_subcat_of']);
        }
    }
    systext($TEXT["admin"]->get("cats_down"), $TEXT["admin"]->get("info"), "green", $TEXT["admin"]->get("icon_down"));
}

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
            systext($TEXT["admin"]->get("form_not_filled")."<br>".$TEXT["admin"]->get("form_only_allowed_values"), $TEXT["admin"]->get("error"), TRUE, $TEXT["admin"]->get("icon_save_error") );

        // Get Data from DB
        } else {
            $cat_arr = $sql->getData("gallery_cat", "*", "WHERE `cat_id` = '".$_POST['cat_id']."'", 1);
            $cat_arr = $sql->lastUseful() ? $cat_arr : array();
            $cat_arr['cat_date'] = date("Y-m-d", $cat_arr['cat_date']);
            putintopost($cat_arr);
        }
        
        // Secure Data for Output
        secureData($_POST, TRUE);

        // Get Subcats
        $subcat_arr = array();
        $sub_cat_ids = array();
        $subcat_options = array();
        
        $SQL = array("table" => "gallery_cat", "select" => "*", "id" => "cat_id", "sub" => "cat_subcat_of", "order" => "ORDER BY `cat_order`, `cat_id`");
        get_cat_system($subcat_arr, $SQL);
        get_all_sub_cats($_POST['cat_id'], $SQL, $sub_cat_ids);
        foreach ($subcat_arr as $aCat) {
            if ($aCat['cat_id'] != $_POST['cat_id'] && !in_array($aCat['cat_id'], $sub_cat_ids)) {
                settype($aCat['cat_id'], "integer");
                $subcat_options[] = '
                                            <option value="'.$aCat['cat_id'].'" '.getselected($aCat['cat_id'], $_POST['cat_subcat_of']).'>'.str_repeat("&nbsp;&nbsp;&nbsp;", $aCat['level']).killhtml($aCat['cat_name']).'</option>';
            }
        }
        
        // Get Old Date
        $cat_arr['date_old'] = $sql->getData("gallery_cat", "cat_date", "WHERE `cat_id` = '".$_POST['cat_id']."'", 1);

        // Display Page

        // Template Conditions
        $adminpage->addCond("image_exists",     image_exists("media/gallery/cat/", $_POST['cat_id']));
        $adminpage->addCond("type",                         $_POST['cat_type']);
        $adminpage->addCond("visibility",                   $_POST['cat_visibility']);
        $adminpage->addCond("content_order",                $_POST['content_order']);
        $adminpage->addCond("content_sort",                 $_POST['content_sort']);
        $adminpage->addCond("content_group",                $_POST['content_group']);
        $adminpage->addCond("content_sub_contents",         $_POST['content_sub_contents']);
        $adminpage->addCond("content_default_folder",       $_POST['content_default_folder']);
        
        // Template Texts
        $adminpage->addText("ACP_GO",           ACP_GO);
        $adminpage->addText("cat_id",           $_POST['cat_id']);
        $adminpage->addText("cat_name",         $_POST['cat_name']);
        $adminpage->addText("subcat_options",   implode("", $subcat_options));
        $adminpage->addText("cat_date_format",  $_POST['cat_date_format']);
        $adminpage->addText("today",            get_datebutton(array("cat_date_format", ""), $TEXT["admin"]->get("today")));
        $adminpage->addText("reset_date",       get_datebutton(array("cat_date_format", $cat_arr['date_old']*1000), $TEXT["admin"]->get("reset")));
        $adminpage->addText("cat_user",         $_POST['cat_user']);
        $adminpage->addText("cat_user_name",    $_POST['cat_user_name']);
        $adminpage->addText("find_user_popup",  openpopup("admin_finduser.php", 400, 400));
        $adminpage->addText("image_url",        image_url("media/gallery/cat/", $_POST['cat_id']));
        $adminpage->addText("cat_text",         $_POST['cat_text']);

        $adminpage->addText("config_img_x",     $config_arr['cat_img_x']);
        $adminpage->addText("config_img_y",     $config_arr['cat_img_y']);
        $adminpage->addText("config_img_size",  $config_arr['cat_img_size']);
        
        $adminpage->addText("folder_options",   "");
        
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
        unset($_POST);
    }
}

// Reset data and go to default page
else {
    unset($_POST);
}

//////////////////////////////
//// Display Default-Page ////
//////////////////////////////
if (!isset($_POST['cat_id']) && !isset($_POST['cat_action'])) {

    /////////////////////////
    //// Load Cat-System ////
    /////////////////////////
    $cat_arr = array();
    get_cat_system( $cat_arr, array("table" => "gallery_cat", "select" => "*", "id" => "cat_id", "sub" => "cat_subcat_of", "order" => "ORDER BY `cat_order`, `cat_id`") );


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
    secureData($_POST, TRUE);

    // Get Options
    $subcat_options = array();
    foreach ($cat_arr as $aCat) {
        settype($aCat['cat_id'], "integer");
        $subcat_options[] = '
                                        <option value="'.$aCat['cat_id'].'" '.getselected($aCat['cat_id'], $_POST['cat_subcat_of']).'>'.str_repeat("&nbsp;&nbsp;&nbsp;", $aCat['level']).killhtml($aCat['cat_name']).'</option>';
    }

    // Display Add-Form
    // Template Conditions
    $adminpage->addCond("subcat_of",        $_POST['cat_subcat_of']);
    $adminpage->addCond("type",             $_POST['cat_type']);
    $adminpage->addCond("visibility",       $_POST['cat_visibility']);
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
        array ( '&nbsp;&nbsp;'.$TEXT["admin"]->get("id").'&nbsp;&nbsp;', array(), 20 ),
        array ( $TEXT["admin"]->get("cat") ),
        array ( "" ),
        array ( $TEXT["page"]->get("type") ),
        array ( $TEXT["page"]->get("visibility") ),
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
