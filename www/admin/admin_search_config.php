<?php if (!defined("ACP_GO")) die("Unauthorized access!");

#TODO: 
    
###################
## Page Settings ##
###################
$search_cols = array("id", "search_num_previews", "search_and", "search_or", "search_xor", "search_not", "search_wildcard", "search_min_word_length", "search_allow_phonetic", "search_use_stopwords");
$global_cols = array("search_index_update");
      

///////////////////////
//// Update Config ////
///////////////////////
if (
        isset ( $_POST['search_num_previews'] )
        && $_POST['search_num_previews'] > 0
        && $_POST['search_num_previews'] <= 25
        && !emptystr($_POST['search_and'])
        && !emptystr($_POST['search_or'])
        && !emptystr($_POST['search_xor'])
        && !emptystr($_POST['search_not'])
        && !emptystr($_POST['search_wildcard'])
    )
{
    // prepare data
    $search = frompost($search_cols);
    $search['id'] = 1;
    $global = frompost($global_cols);  
 
     // save to db
    try {
        $sql->save("search_config", $search);
        $FD->saveConfig("main", $global);
        systext($FD->text("admin", "changes_saved"), $FD->text("admin", "info"), "green", $FD->text("admin", "icon_save_ok"));
    } catch (Exception $e) {}
    
    // Unset Vars
    unset($_POST);
}

/////////////////////
//// Config Form ////
/////////////////////

if ( TRUE )
{
    // Display Error Messages
    if (isset($_POST['sended'])) {
        systext($FD->text("admin", "changes_not_saved").'<br>'.$FD->text("admin", "form_not_filled"), $FD->text("admin", "error"), "red", $FD->text("admin", "icon_save_error"));

    // Load Data from DB into Post
    } else {
        $search = $sql->getRow("search_config", $search_cols, array('W' => "`id` = 1"));
        $global = $sql->getRow("global_config", $global_cols, array('W' => "`id` = 1"));
        
        $global = $sql->getRow("config", array("config_data"), array('W' => "`config_name` = 'main'"));
        $global = json_array_decode($global['config_data']);
        $global = array_filter_keys($global, $global_cols);
        
        $data = array_merge($global, $search);
        putintopost($data);
    }   
    
    // security functions
    $_POST = array_map("killhtml", $_POST);    
     
    // Conditions
    $adminpage->addCond("search_allow_phonetic", $_POST['search_allow_phonetic'] == 1);
    $adminpage->addCond("search_use_stopwords", $_POST['search_use_stopwords'] == 1);
    for ($i=1;$i<=3;$i++)
        $adminpage->addCond("search_index_update_".$i, $_POST['search_index_update'] == $i);  
    
    // Values
    foreach ($_POST as $key => $value) {
        $adminpage->addText($key, $value);
    }

    // Display page
    echo $adminpage->get("main");
}

?>
