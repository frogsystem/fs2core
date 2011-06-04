<?php if (ACP_GO == "gen_config") {
    
#TODO: fileaccess
    
###################
## Page Settings ##
###################
$used_cols = array("id", "title", "dyn_title", "dyn_title_ext", "virtualhost", "admin_mail", "description", "keywords", "publisher", "copyright", "style_id", "allow_other_designs", "show_favicon", "home", "home_text", "language_text", "feed", "date", "time", "datetime", "timezone", "auto_forward", "page", "page_prev", "page_next");
    

/////////////////////////////////////
//// Konfiguration aktualisieren ////
/////////////////////////////////////
if (
                $_POST['title'] && $_POST['title'] != ""
                && $_POST['virtualhost'] && $_POST['virtualhost'] != ""
                && $_POST['admin_mail'] && $_POST['admin_mail'] != ""
                && $_POST['date'] && $_POST['date'] != ""
                && $_POST['page'] && $_POST['page'] != ""
                && $_POST['page_next'] && $_POST['page_next'] != ""
                && $_POST['page_prev'] && $_POST['page_prev'] != ""
                && is_language_text ( $_POST['language_text'] )
                && ( $_POST['home'] == 0 || ( $_POST['home'] == 1 && $_POST['home_text'] != "" ) )
        )
{
    // virtualhost slash
    if (substr($_POST['virtualhost'], -1) != "/") {
      $_POST['virtualhost'] = $_POST['virtualhost']."/";
    }
     
    // prepare data
    $data = frompost($used_cols);
    $data['id'] = 1;
    
    // style tag
    try {
        $data['style_tag'] = $sql->getField("styles", "style_tag",
            array('W' => "`style_id` = ".$_POST['style_id']." AND `style_id` != 0 AND `style_allow_use` = 1")
        );
    } catch (Exception $e) {
        unset($data['style_tag'], $data['style_id']);
    }
    
    // save to db
    try {
        $sql->save("global_config", $data);
        systext($TEXT['admin']->get("changes_saved").'<br>'.$TEXT['admin']->get("form_not_filled"), $TEXT['admin']->get("info"), "green", $TEXT['admin']->get("icon_save_ok"));
    } catch (Exception $e) {}
    
    // Unset Vars
    unset($_POST);
}

/////////////////////////////////////
////// Konfiguration Formular ///////
/////////////////////////////////////

if ( TRUE )
{
    // Display Error Messages
    if (isset($_POST['sended'])) {
        systext($TEXT['admin']->get("changes_not_saved").'<br>'.$TEXT['admin']->get("form_not_filled"), $TEXT['admin']->get("error"), "red", $TEXT['admin']->get("icon_save_error"));

    // Load Data from DB into Post
    } else {
        $data = $sql->getRow("global_config", $used_cols, array('W' => "`id` = 1"));
        putintopost($data);
    }

    // security functions
    $_POST = array_map("killhtml", $_POST);


    // Conditions
    $adminpage->addCond("dyn_title_ext", !($_POST['dyn_title'] == 1));
    $adminpage->addCond("dyn_title", $_POST['dyn_title'] === 1);
    $adminpage->addCond("allow_other_designs", $_POST['allow_other_designs'] === 1);
    $adminpage->addCond("show_favicon", $_POST['show_favicon'] === 1);
    $adminpage->addCond("feed_rss091", $_POST['feed'] == "rss091");
    $adminpage->addCond("feed_rss10", $_POST['feed'] == "rss10");
    $adminpage->addCond("feed_rss20", $_POST['feed'] == "rss20");
    $adminpage->addCond("feed_atom10", $_POST['feed'] == "atom10");
    $adminpage->addCond("home_0", $_POST['home'] === 0);
    $adminpage->addCond("home_1", $_POST['home'] === 1);
    $adminpage->addCond("timezone", $_POST['timezone'] === "default");
 
    // Values
    foreach ($_POST as $key => $value) {
        $adminpage->addText($key, $value);
    }
    
    // Dyntitle
    $adminpage->addText("dyn_title_ext_tt",
        insert_tt( "{..title..}", $TEXT['page']->get("dyn_title_page_title"), "dyn_title_ext", FALSE )."&nbsp;".
        insert_tt( "{..ext..}", $TEXT['page']->get("dyn_title_page_title_ext"), "dyn_title_ext", FALSE )
    );

    // styles
    $active_style = $sql->getFieldById("global_config", "style_id", 1);
    settype($active_style, "integer");

    $styles = $sql->get("styles", array("style_id", "style_tag"),
        array('W' => "`style_id` != 0 AND `style_allow_use` = 1", 'O' => "`style_tag`")
    );
   
    initstr($style_options);
    foreach ($styles['data'] as $style) {
        settype($style['style_id'], "integer");
        $style_options .= 
        '<option value="'.$style['style_id'].'" '
        .getselected($style['style_id'], $_POST['style_id']).'>'
            .killhtml($style['style_tag'])
            .($style['style_id'] == $active_style ? ' ('.$TEXT['admin']->get("active").')' : '')
        .'</option>'."\n";
    }
    $adminpage->addText("style_options", $style_options);
   
    // languages
    initstr($lang_options);
    $lang_dirs = scandir_filter(FS2_ROOT_PATH."lang");
    foreach($lang_dirs as $lang_dir) {
        if (is_dir(FS2_ROOT_PATH."lang/".$lang_dir) && is_language_text($lang_dir)) {
            $lang_options .=
            '<option value="'.$lang_dir.'" '
            .getselected($lang_dir, $_POST['language_text'])
            .'>'.$lang_dir.'</option>'."\n";
        }
    }
    $adminpage->addText("language_options", $lang_options); 
    
    //timezones
    initstr($timezone_options);
    foreach(get_timezones() as $timezone => $val) {
            $timezone_options .= '<option value="'.$timezone.'" '
            .getselected($timezone, $_POST['timezone'])
            .'>'.$timezone.'</option>'."\n";
    }
    $adminpage->addText("timezones", $timezone_options); 

    //pagenav
    $adminpage->addText("page_tt",
        insert_tt("{..page_number..}", $TEXT['page']->get("page_text_page_num"), "page").
        insert_tt("{..total_pages..}", $TEXT['page']->get("page_text_total_pages"), "page").
        insert_tt("{..prev..}", $TEXT['page']->get("page_text_next"), "page").
        insert_tt("{..next..}", $TEXT['page']->get("page_text_prev"), "page")
    ); 
    $adminpage->addText("page_prev_tt", insert_tt("{..url..}", $TEXT['page']->get("page_prev_text"), "page_prev")); 
    $adminpage->addText("page_next_tt", insert_tt("{..url..}", $TEXT['page']->get("page_next_text"), "page_next")); 

    // Display page
    echo $adminpage->get("main");
}

} ?>
