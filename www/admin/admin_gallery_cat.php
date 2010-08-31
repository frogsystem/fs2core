<?php if ( ACP_GO === "gallery_cat" ) {

/////////////////////////////////////
//// Locale Secure Data Function ////
/////////////////////////////////////
function secureData ( $DATA, $OUTPUT = FALSE ) {
    // Common
    settype ( $DATA['viewer_type'], 'integer' );
    $DATA['img_order'] = $OUTPUT ? killhtml ( $DATA['img_order'] ) : savesql ( $DATA['img_order'] );

    return $DATA;
}

/////////////////////
//// Load Config ////
/////////////////////
$config_arr = $sql->getData("gallery_config", "*", 1);


$showdefault = TRUE;


//////////////////////
// Update Database  //
//////////////////////

// Insert Category
if (
        isset ( $_POST['sended'] ) && $_POST['sended'] == "add" &&
        isset ( $_POST['cat_action'] ) && $_POST['cat_action'] == "add" &&
        $_POST['cat_name'] && $_POST['cat_name'] != ""
    )
{
    // Security-Functions
    $_POST['cat_name'] = savesql ( $_POST['cat_name'] );
    $_POST['cat_user'] = $_SESSION['user_id'];
    settype ( $_POST['cat_user'], "integer" );
    $cat_date = time ();

    // MySQL-Update-Query
    $insert_query = mysql_query ("
                    INSERT INTO ".$global_config_arr['pref']."news_cat (cat_name, cat_date, cat_user)
                    VALUES (
                        '".$_POST['cat_name']."',
                        '".$cat_date."',
                        '".$_POST['cat_user']."'
                    )
    ", $db );
    $message = $admin_phrases[news][new_cat_added];
    $id = mysql_insert_id ( $db );

    // Image-Operations
    if ( $_FILES['cat_pic']['name'] != "" ) {
      $upload = upload_img ( $_FILES['cat_pic'], "images/cat/", "news_".$id, $news_config_arr['cat_pic_size']*1024, $news_config_arr['cat_pic_x'], $news_config_arr['cat_pic_y'] );
      $message .= "<br>" . upload_img_notice ( $upload );
    }

    // Display Message
    systext ( $message, $admin_phrases[common][info] );
    
    // Unset Vars
    unset ( $_POST );

    // Set Vars
    $_POST['cat_action'] = "edit";
    $_POST['cat_id'] = mysql_insert_id ( $db );
}

// Update Category
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

// Delete Category
elseif (
        isset ( $_POST['cat_id'] ) &&
        isset ( $_POST['sended'] ) && $_POST['sended'] == "delete" &&
        isset ( $_POST['cat_action'] ) && $_POST['cat_action'] == "delete" &&
        isset ( $_POST['cat_move_to'] ) &&
        isset ( $_POST['cat_delete'] )
    )
{
    if ( $_POST['cat_delete'] == 1 ) {
    
        // Security-Functions
        settype ( $_POST['cat_id'], "integer" );
        settype ( $_POST['cat_move_to'], "integer" );

        // MySQL-Query move News to other Category
        mysql_query ("
                        UPDATE ".$global_config_arr['pref']."news
                         SET
                             cat_id                 = '".$_POST['cat_move_to']."'
                         WHERE
                             cat_id                 = '".$_POST['cat_id']."'
        ", $db );

        // MySQL-Delete-Query
        mysql_query ("
                        DELETE FROM ".$global_config_arr['pref']."news_cat
                         WHERE
                             cat_id                 = '".$_POST['cat_id']."'
        ", $db );
        $message = $admin_phrases[news][cat_deleted];

        // Delete Category Image
        if ( image_delete ( "images/cat/", "news_".$_POST['cat_id'] ) ) {
            $message .= "<br>" . $admin_phrases[common][image_deleted];
        }
        
    } else {
        $message = $admin_phrases[news][cat_not_deleted];
    }

    // Display Message
    systext ( $message, $admin_phrases[common][info] );

    // Unset Vars
    unset ( $_POST );
    $showdefault = FALSE;
}



///////////////////////////
// Display Action-Pages  //
///////////////////////////

// No Data to write into DB
if ( $_POST['cat_id'] && $_POST['cat_action'] )
{
    // Edit Category
    if ( $_POST['cat_action'] == "edit" )
    {
    
        // Load Data from DB
        $index = mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."news_cat WHERE cat_id = '".$_POST['cat_id']."'", $db );
        $cat_arr = mysql_fetch_assoc ( $index );

        // Display Error Messages
        if ( isset ( $_POST['sended'] ) ) {
            $cat_arr = getfrompost ( $cat_arr );
            systext ( $admin_phrases[common][note_notfilled], $admin_phrases[common][error], TRUE );
        }

        // Security-Functions
        $cat_arr['cat_name'] = killhtml ( $cat_arr['cat_name'] );
        $cat_arr['cat_description'] = killhtml ( $cat_arr['cat_description'] );

        // Get User
        $index = mysql_query ( "SELECT user_name FROM ".$global_config_arr['pref']."user WHERE user_id = '".$cat_arr['cat_user']."'", $db );
        $cat_arr['cat_username'] = killhtml ( mysql_result ( $index, 0, "user_name" ) );

        // Create Date-Arrays
        if ( !isset ( $_POST['d'] ) ) {
            $_POST['d'] = date ( "d", $cat_arr['cat_date'] );
            $_POST['m'] = date ( "m", $cat_arr['cat_date'] );
            $_POST['y'] = date ( "Y", $cat_arr['cat_date'] );
        }
        $date_arr = getsavedate ( $_POST['d'], $_POST['m'], $_POST['y'] );
        $nowbutton_array = array( "d", "m", "y" );

        // Display Page

    }
    
    // Delete Category
    elseif ( $_POST['cat_action'] == "delete" )
    {
        $index = mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."news_cat", $db );

        // Not Last Category
        if ( mysql_num_rows ( $index ) > 1 ) {

            $index = mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."news_cat WHERE cat_id = '".$_POST['cat_id']."'", $db );
            $cat_arr = mysql_fetch_assoc ( $index );

            $cat_arr['cat_name'] = killhtml ( $cat_arr['cat_name'] );


        }
        
        // Last Category
        else {
            systext ( $admin_phrases[news][delete_cat_last], $admin_phrases[common][error], TRUE );
            echo '
                        <table class="configtable" cellpadding="4" cellspacing="0">
                               <tr>
                                   <td class="config">
                                    <a class="link_button" href="?go=news_cat">'.$admin_phrases[common][arrow].' '.$admin_phrases[news][delete_back_link].'</a>
                                </td>
                            </tr>
                        </table>';
        }
    }
}



//////////////////////////
// Display Default-Page //
//////////////////////////

// Display New Category & Category Listing
elseif ( $showdefault == TRUE )
{
    // New Caregory
    // Display Error Messages
    if ( isset ( $_POST['sended'] ) ) {
        $_POST['cat_name'] = killhtml ( $_POST['cat_name'] );
        systext ( $admin_phrases[common][note_notfilled], $admin_phrases[common][error], TRUE );
    }

    // Display Add-Form
    echo '

    ';

    // generate list
    $theList = new SelectList ( "cat", $TEXT["admin"]->get("gallery_cat_select_title"), "gallery_cat", 6 );
    $theList->setColumns ( array (
        array ( $TEXT["admin"]->get("Name") ),
        array ( "" ),
        array ( "Art"  ),
        array ( "Sichtbarkeit", array("center") ),
        array ( '&nbsp;&nbsp;'."ID".'&nbsp;&nbsp;', array(), 20 ),
        array ( "", array(), 20 )
    ) );
    $theList->setNoLinesText ( $TEXT["admin"]->get("cats_not_found") );
    $theList->addAction ( "edit", $TEXT["admin"]->get("selection_edit"), array ( "select_one" ), TRUE, TRUE );
    $theList->addAction ( "delete", $TEXT["admin"]->get("selection_delete"), array ( "select_red" ), TRUE );
    $theList->addButton();

    // get applets from db
    $cats = $sql->getData ( "gallery_cat", "*", "ORDER BY `cat_id`" );
    $cats = $sql->isUsefulGet() ? $cats : array();
    
    // applets found
    foreach ( $cats as $data_arr ) {
        $theList->addLine ( array (
            array ( killhtml ( $data_arr['cat_name'] ), array ( "middle" ) ),
            array ( date_loc ( "d.m.Y", $data_arr['cat_date'] ), array ( "middle", "center", "small" ) ),
            array ( $data_arr['cat_type'], array ( "middle", "left" ) ),
            array ( $data_arr['cat_visibility'], array ( "middle", "center" ) ),
            array ( $data_arr['cat_id'], array ( "middle", "center" ) ),
            array ( TRUE, $data_arr['cat_id'] )
        ) );
    }
    // Output
    echo $theList;

}

} ?>