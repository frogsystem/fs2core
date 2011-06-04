<?php if (ACP_GO == "news_add") {

    
###################
## Page Settings ##
###################
$news_cols = array("cat_id", "user_id", "news_date", "news_title", "news_text", "news_active", "news_comments_allowed", "news_search_update");

$config_arr = $sql->getById("news_config", array("html_code", "fs_code", "para_handling", "acp_force_cat_selection"), 1);
$config_arr['html'] = in_array($config_arr['html_code'], array(2, 4)) ? $TEXT['admin']->get("on") : $TEXT['admin']->get("off");
$config_arr['fs'] = in_array($config_arr['fs_code'], array(2, 4)) ? $TEXT['admin']->get("on") : $TEXT['admin']->get("off");
$config_arr['para'] = in_array($config_arr['para_handling'], array(2, 4)) ? $TEXT['admin']->get("on") : $TEXT['admin']->get("off");



/////////////////////////////
//// Insert News into DB ////
/////////////////////////////

if (
        !isset($_POST['dolinkbutton']) && !isset($_POST['addlink']) &&
        $_POST['title'] && $_POST['title'] != "" &&
        $_POST['news_text'] && $_POST['news_text'] != "" &&

        $_POST['d'] && $_POST['d'] != "" && $_POST['d'] > 0 &&
        $_POST['m'] && $_POST['m'] != "" && $_POST['m'] > 0 &&
        $_POST['y'] && $_POST['y'] != "" && $_POST['y'] > 0 &&
        $_POST['h'] && $_POST['h'] != "" && $_POST['h'] >= 0 &&
        $_POST['i'] && $_POST['i'] != "" && $_POST['i'] >= 0 &&

        isset ( $_POST['cat_id'] ) && $_POST['cat_id'] != -1 &&
        isset ( $_POST['posterid'] )
    )
{
    // Prepare data
    $_POST['news_date'] = mktime($_POST['h'], $_POST['i'], 0, $_POST['m'], $_POST['d'], $_POST['y']);
    $_POST['news_search_update'] = 0;
    $data = frompost($news_cols);
    unset($data['news_id']);

    // MySQL-Insert-Query
    try {
        $newsid = $sql->save("news", $data, "news_id");
        
        // Update Search Index (or not)
        if ( $global_config_arr['search_index_update'] === 1 ) {
            // Include searchfunctions.php
            require ( FS2_ROOT_PATH . "includes/searchfunctions.php" );
            update_search_index ("news");
        }

        // Insert Links to database
        foreach ($_POST['linkname'] as $key => $value)
        {
            if (!empty($_POST['linkname'][$key]) && !empty($_POST['linkurl'][$key]) && !in_array($_POST['linkurl'][$key], array("http://", "https://"))) {
                
                // secure link target
                switch ($_POST['linktarget'][$key]) {
                    case 1: settype ( $_POST['linktarget'][$key], "integer" ); break;
                    default: $_POST['linktarget'][$key] = 0; break;
                }                
                
                $linkdata = array(
                    'news_id' => $newsid,
                    'link_name' => $_POST['linkname'][$key],
                    'link_url' => $_POST['linkurl'][$key],
                    'link_target' => $_POST['linktarget'][$key]
                );
                
                // insert into db                
                try {
                    $sql->save("news_links", $linkdata, "link_id");
                } catch (Exception $e) {
                    Throw $e;
                }
                
            }
        }

        // update counter
        try {
            $sql->doQuery("UPDATE `{..pref..}counter` SET `news` = `news` + 1 WHERE `id` = 1");
        } catch (Exception $e) {}
        
        
        echo get_systext($TEXT['page']->get("news_added"), $TEXT['admin']->get("info"), "green", $TEXT['admin']->get("icon_save_add"));

        // Unset Vars
        unset ($_POST);

    } catch (Exception $e) {
        echo get_systext($TEXT['page']->get("news_not_added")."<br>Caught exception: ".$e->getMessage(), $TEXT['admin']->get("error"), "red", $TEXT['admin']->get("icon_save_error"));
    }

}

/////////////////////
///// News Form /////
/////////////////////

if ( TRUE ) {
    
    // link functions or error
    if (isset($_POST['sended'])) {
        
        // display error
        if (!isset($_POST['dolinkbutton']) && !isset($_POST['addlink'])) {
            echo get_systext($TEXT['page']->get("news_not_added")."<br>".$TEXT['admin']->get("form_not_filled"), $TEXT['admin']->get("error"), "red", $TEXT['admin']->get("icon_save_error"));
        }
        
    // Set default value
    } else {
        $_POST['news_active'] = 1;
        $_POST['news_comments_allowed'] = 1;
        $_POST['user_id'] = $_SESSION['user_id'];
        
        $_POST['d'] = date("d");
        $_POST['m'] = date("m");
        $_POST['y'] = date("Y");
        $_POST['h'] = date("H");
        $_POST['i'] = date("i");
    }
    
    // Get User
    $_POST['user_name'] = $sql->getFieldById("user", "user_name", $_POST['user_id'], "user_id");
    
    // security functions
    $_POST = array_map("killhtml", $_POST);

    // Create Date-Arrays
    list($_POST['d'], $_POST['m'], $_POST['y'], $_POST['h'], $_POST['i']) 
        = array_values(getsavedate($_POST['d'], $_POST['m'], $_POST['y'], $_POST['h'], $_POST['i'], 0, true));

    // cat options
    initstr($cat_options);
    if ($config_arr['acp_force_cat_selection'] == 1) {
        $cat_options .= '<option value="-1" '.getselected(-1, $_POST['cat_id']).'>'.$TEXT['admin']->get("please_select").'</option>'."\n";
        $cat_options .= '<option value="-1">'.$TEXT['admin']->get("select_hr").'</option>'."\n";
    }

    $cats = $sql->get("news_cat", array("cat_id", "cat_name"));
    foreach ($cats['data'] as $cat) {
        settype ($cat['cat_id'], "integer");
        $cat_options .= '<option value="'.$cat['cat_id'].'" '.getselected($cat['cat_id'], $_POST['cat_id']).'>'.$cat['cat_name'].'</option>'."\n";
    }



    // Conditions
    $adminpage->addCond("news_active", $_POST['news_active'] === 1);
    $adminpage->addCond("news_comments_allowed", $_POST['news_comments_allowed'] === 1);
        
    // Values
    foreach ($_POST as $key => $value) {
        $adminpage->addText($key, $value);
    }
    
    $adminpage->addText("cat_options", $cat_options);
    $adminpage->addText("html", $config_arr['html']);
    $adminpage->addText("fs", $config_arr['fs']);
    $adminpage->addText("para", $config_arr['para']);
    $adminpage->addText("the_editor", create_editor("news_text", $_POST['news_text'], "100%", "250px", "", FALSE));

    // display page
    echo $adminpage->get("main");
    

/*


                            <tr>
                                <td class="config" colspan="2">
                                    <table cellpadding="0" cellspacing="0" width="100%">
    ';

        //Zu löschende Links löschen
        if ( isset ( $_POST['sended'] ) &&  isset ( $_POST['dolinkbutton'] ) && $_POST['do_links'] == "del" && count ( $_POST['dolink'] ) > 0 )
        {
                foreach ( $_POST['dolink'] as $key => $value )
            {
                        if ( $value == 1 )
                        {
                                $_POST['linkname'][$key] = "";
                        $_POST['linkurl'][$key] = "";
                        $_POST['linktarget'][$key] = "";
                        }
            }
        }
        
        //Links nach oben verschieben
        if ( isset ( $_POST['sended'] ) &&  isset ( $_POST['dolinkbutton'] ) && $_POST['do_links'] == "up" && count ( $_POST['dolink'] ) > 0 )
        {
                foreach ( $_POST['dolink'] as $key => $value )
            {
                        if ( $value == 1 && $key != 0 )
                        {
                                $up_name = $_POST['linkname'][$key];
                        $up_url = $_POST['linkurl'][$key];
                        $up_target = $_POST['linktarget'][$key];
                        $_POST['linkname'][$key] = $_POST['linkname'][$key-1];
                        $_POST['linkurl'][$key] = $_POST['linkurl'][$key-1];
                        $_POST['linktarget'][$key] = $_POST['linktarget'][$key-1];
                        $_POST['linkname'][$key-1] = $up_name;
                        $_POST['linkurl'][$key-1] = $up_url;
                        $_POST['linktarget'][$key-1] = $up_target;
                        }
            }
        }
        
        //Links nach unten verschieben
        if ( isset ( $_POST['sended'] ) &&  isset ( $_POST['dolinkbutton'] ) && $_POST['do_links'] == "down" && count ( $_POST['dolink'] ) > 0 )
        {
                foreach ( $_POST['dolink'] as $key => $value )
            {
                        if ( $value == 1 && $key != count ( $_POST['linkname'] ) - 1 )
                        {
                                $down_name = $_POST['linkname'][$key];
                        $down_url = $_POST['linkurl'][$key];
                        $down_target = $_POST['linktarget'][$key];
                        $_POST['linkname'][$key] = $_POST['linkname'][$key+1];
                        $_POST['linkurl'][$key] = $_POST['linkurl'][$key+1];
                        $_POST['linktarget'][$key] = $_POST['linktarget'][$key+1];
                        $_POST['linkname'][$key+1] = $down_name;
                        $_POST['linkurl'][$key+1] = $down_url;
                        $_POST['linktarget'][$key+1] = $down_target;
                        }
            }
        }
        
        //Zu bearbeitende Links löschen & Daten sichern
        unset ( $edit_name );
        unset ( $edit_url );
        unset ( $edit_target );
        
        if ( isset ( $_POST['sended'] ) &&  isset ( $_POST['dolinkbutton'] ) && $_POST['do_links'] == "edit" && count ( $_POST['dolink'] ) > 0 )
        {
                foreach ( $_POST['dolink'] as $key => $value )
            {
                        if ( $value == 1 )
                        {
                                $edit_name = $_POST['linkname'][$key];
                        $edit_url = $_POST['linkurl'][$key];
                        $edit_target = $_POST['linktarget'][$key];
                                $_POST['linkname'][$key] = "";
                        $_POST['linkurl'][$key] = "";
                        $_POST['linktarget'][$key] = "";
                        }
            }
        }

        // Erstellte Linkfelder ausgeben
        if ( !isset ($_POST['linkname']) )
         {
        $_POST['linkname'][0] = "";
        }
        $linkid = 0;
        
    foreach ( $_POST['linkname'] as $key => $value )
    {
        if ( $_POST['linkname'][$key] != "" && $_POST['linkurl'][$key] != "" && ( $_POST['linknew'][$key] == 0 || isset ( $_POST['addlink'] ) ) )
        {
                        $counter = $linkid + 1;

                        $link_name = killhtml ( $_POST['linkname'][$key] );

                        $link_maxlenght = 60;
            $_POST['linkurl'][$key] = killhtml ( $_POST['linkurl'][$key] );
                        $link_fullurl = $_POST['linkurl'][$key];
                        if ( strlen ( $_POST['linkurl'][$key] ) > $link_maxlenght )
                {
                    $_POST['linkurl'][$key] = substr ( $link_fullurl, 0, $link_maxlenght ) . "...";
                }

                        switch ( $_POST['linktarget'][$key] )
                    {
                        case 1: $link_target = $admin_phrases[news][news_link_blank]; break;
                        default:
                                        $_POST['linktarget'][$key] = 0;
                                        $link_target = $admin_phrases[news][news_link_self];
                                        break;
                    }

            echo'
                                                                                <tr class="pointer" id="tr_'.$linkid.'"
                                                                                        onmouseover="'.color_list_entry ( "input_".$linkid, "#EEEEEE", "#64DC6A", "this" ).'"
                                                                                        onmouseout="'.color_list_entry ( "input_".$linkid, "transparent", "#49c24f", "this" ).'"
                                                        onclick="'.color_click_entry ( "input_".$linkid, "#EEEEEE", "#64DC6A", "this", TRUE ).'"
                                                                                >
                                                                                        <td class="config" style="padding-left: 7px; padding-right: 7px; padding-bottom: 2px; padding-top: 2px;">
                                                                                                #'.$counter.'
                                                                                        </td>
                                                                                        <td class="config" width="100%" style="padding-right: 5px; padding-bottom: 2px; padding-top: 2px;">
                                                             '.$link_name.' <span class="small">('.$link_target.')</span><br>
                                                            <a href="'.$link_fullurl.'" target="_blank" title="'.$link_fullurl.'">'.$_POST['linkurl'][$key].'</a>
                                                            <input type="hidden" name="linkname['.$linkid.']" value="'.$link_name.'">
                                                            <input type="hidden" name="linkurl['.$linkid.']" value="'.$link_fullurl.'">
                                                            <input type="hidden" name="linktarget['.$linkid.']" value="'.$_POST['linktarget'][$key].'">
                                                            <input type="hidden" name="linknew['.$linkid.']" value="0">
                                                                                        </td>

                                                        <td align="center">
                                                            <input class="pointer" type="radio" name="dolink['.$linkid.']" id="input_'.$linkid.'" value="1"
                                                                                                        onclick="'.color_click_entry ( "this", "#EEEEEE", "#64DC6A", "tr_".$linkid, TRUE ).'"
                                                                                                >
                                                                                        </td>
                                                                                </tr>
            ';
                        $linkid++;
        }
        }

        if ( $linkid > 0 )
        {
                echo'
                                                                                <tr valign="top">
                                                                                        <td style="padding-right: 5px; padding-top: 11px;" align="right" colspan="2">
                                                                                            <select name="do_links" size="1">
                                                    <option value="0">'.$admin_phrases[news][news_link_no].'</option>
                                                    <option value="del">'.$admin_phrases[news][news_link_delete].'</option>
                                                    <option value="up">'.$admin_phrases[news][news_link_up].'</option>
                                                    <option value="down">'.$admin_phrases[news][news_link_down].'</option>
                                                                                                        <option value="edit">'.$admin_phrases[news][news_link_edit].'</option>
                                                                                                </select>
                                                                                        </td>
                                                                                        <td style="padding-top: 11px;" align="center">
                                                <input class="button" type="submit" name="dolinkbutton" value="'.$admin_phrases[common][do_button].'">
                                                                                        </td>
                                                                                </tr>
                ';
        }

        if ( $edit_url == "" ) {
            $edit_url = "http://";
        }
    
        settype ( $edit_target, "integer" );
    
        echo'
                                                                        </table>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                                                        <tr>
                                <td class="config" colspan="2">
                                    '.$admin_phrases[news][news_link_add].':
                                </td>
                            </tr>
                            <tr>
                                <td class="config" colspan="2">
                                    <table cellpadding="0" cellspacing="0" width="100%">
                                                                                <tr>
                                                                                        <td class="config" style="padding-right: 5px;">
                                                '.$admin_phrases[news][news_link_title].':
                                                                                        </td>
                                                                                        <td class="config" style="padding-bottom: 4px;" width="100%">
                                                <input class="text" style="width: 100%;" maxlength="100" name="linkname['.$linkid.']" value="'.$edit_name.'">
                                                                                        </td>
                                                                                        <td class="config"style="padding-left: 5px;">
                                                '.$admin_phrases[news][news_link_open].':
                                                                                        </td>
                                                                                </tr>
                                                                                <tr>
                                                                                        <td class="config">
                                                '.$admin_phrases[news][news_link_url].':
                                                                                        </td>
                                                                                        <td class="config" style="padding-bottom: 4px;">
                                                <input class="text" style="width: 100%;" maxlength="255" name="linkurl['.$linkid.']" value="'.$edit_url.'">
                                                                                        </td>
                                                                                        <td style="padding-left: 5px;" valign="top">
                                                                                                <select name="linktarget['.$linkid.']" size="1">
                                                    <option value="0" '.getselected(0, $edit_target).'>'.$admin_phrases[news][news_link_self].'</option>
                                                    <option value="1" '.getselected(1, $edit_target).'>'.$admin_phrases[news][news_link_blank].'</option>
                                                                                                </select>
                                                                                        </td>
                                                                                        <td align="right" valign="top" style="padding-left: 10px;">
                                                                                                <input type="hidden" name="linknew['.$linkid.']" value="1">
                                                <input class="button" type="submit" name="addlink" value="'.$admin_phrases[common][add_button].'">
                                                                                        </td>
                                                                                </tr>
                                                                        </table>
                                                                </td>
                            </tr>
        ';


*/
}

} ?>
