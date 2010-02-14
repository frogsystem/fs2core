<?php
////////////////////////////////////
//// Templatepage Save Template ////
////////////////////////////////////

function templatepage_init ( $TEMPLATE_EDIT, $TEMPLATE_GO, $TEMPLATE_FILE, $SAVE = TRUE, $MANYFILES = FALSE, $HIGHLIGHTER = 1 )
{
    global $TEXT;

    if ( templatepage_postcheck ( $TEMPLATE_EDIT ) && isset( $_POST['reload'] ) ) {
        if ( $SAVE === FALSE ) {
            systext ( $TEXT["admin"]->get("changes_not_saved")."<br>".$TEXT["admin"]->get("template_dont_remove_copyright"),
                $TEXT["admin"]->get("error"), TRUE, $TEXT["admin"]->get("icon_error") );
            echo "<br>";
        } else {
            $save_var = templatepage_save ( $TEMPLATE_EDIT, $TEMPLATE_FILE, $MANYFILES );
            if ( $save_var === TRUE ) {
                systext ( $TEXT["admin"]->get("changes_saved"),
                    $TEXT["admin"]->get("info"), FALSE, $TEXT["admin"]->get("icon_save_ok") );
                echo "<br>";
                $style = $_POST['style'];
                $file = $_POST['file'];
                unset ( $_POST );
                $_POST['style'] = $style;
                $_POST['file'] = $file;
            } elseif ( $save_var === FALSE ) {
                systext ( $TEXT["admin"]->get("changes_not_saved")."<br>".$TEXT["admin"]->get("error_file_access"),
                    $TEXT["admin"]->get("error"), TRUE, $TEXT["admin"]->get("icon_error") );
                echo "<br>";
            }
        }
    }

    return create_templatepage ( $TEMPLATE_EDIT, $TEMPLATE_GO, $TEMPLATE_FILE, $MANYFILES, $HIGHLIGHTER );
}

////////////////////////////////////
//// Templatepage Save Template ////
////////////////////////////////////

function templatepage_save ( $TEMPLATE_ARR, $TEMPLATE_FILE, $MANYFILES = FALSE )
{
    global $global_config_arr, $db, $TEXT;

    $_POST['style'] = savesql ( $_POST['style'] );
    
    $file_data = null;
    $access = new fileaccess();
    $directory_path = FS2_ROOT_PATH . "styles/" . $_POST['style'] . "/";

    $index = mysql_query ( "
                            SELECT `style_id`
                            FROM `".$global_config_arr['pref']."styles`
                            WHERE `style_tag` = '".$_POST['style']."'
                            AND `style_allow_edit` = 1
                            LIMIT 0,1
    ", $db );

    if ( mysql_num_rows ( $index ) == 1 ) {
        if ( $MANYFILES ) {
            if ( $_POST['file'] == "new" ) {
                $_POST['file_name'] = unquote ( $_POST['file_name'] );
                if ( trim ( $_POST['file_name'] ) == "" ) {
                    systext ( $TEXT["admin"]->get("changes_not_saved")."<br>".$TEXT["admin"]->get("template_no_filename"),
                        $TEXT["admin"]->get("error"), TRUE, $TEXT["admin"]->get("icon_error") );
                    echo "<br>";
                    $_POST[$TEMPLATE_ARR[0]['name']] = unquote ( $_POST[$TEMPLATE_ARR[0]['name']] );
                    return "file_name";
                }
                $TEMPLATE_FILE = $_POST['file_name'] . "." . $TEMPLATE_FILE;
                $_POST['file'] = $TEMPLATE_FILE;
            } elseif ( trim ( $_POST[$TEMPLATE_ARR[0]['name']] ) == "" ) {
                $TEMPLATE_FILE = unquote ( $_POST['file'] );
                $file_path =  $directory_path . $TEMPLATE_FILE;
                if ( $access->deleteFile ( $file_path ) ) {
                    systext ( $TEXT["admin"]->get("file_deleted"),
                        $TEXT["admin"]->get("info"), FALSE, $TEXT["admin"]->get("icon_trash_ok") );
                    echo "<br>";
                    $style = $_POST['style'];
                    unset ( $_POST );
                    $_POST['style'] = $style;
                    return "file_delete";
                } else {
                    systext ( $TEXT["admin"]->get("file_not_deleted")."<br>".$TEXT["admin"]->get("error_file_access"),
                        $TEXT["admin"]->get("error"), TRUE, $TEXT["admin"]->get("icon_trash_error") );
                    echo "<br>";
                    return "file_delete_error";
                }
            } else {
                $TEMPLATE_FILE = unquote ( $_POST['file'] );
            }
            $file_data = "".unquote ( $_POST[$TEMPLATE_ARR[0]['name']] )."";
        } else {
            foreach ($TEMPLATE_ARR as $template) {
                $file_data .= "<!--section-start::" . $template['name'] . "-->" . unquote ( $_POST[$template['name']] ) . "<!--section-end::".$template['name'] . "-->

";
            }
        }

        $file_path =  $directory_path . $TEMPLATE_FILE;
        if ( is_writable ( $file_path ) || ( file_exists ( $directory_path ) && is_writable ( $directory_path ) ) ) {
            $access->putFileData ( $file_path, $file_data );
            return TRUE;
        } else {
            return FALSE;
        }
     }
}


///////////////////////////////////
//// Templatepage $_POST-Check ////
///////////////////////////////////

function templatepage_postcheck ( $TEMPLATE_ARR )
{
    foreach ( $TEMPLATE_ARR as $template ) {
        if ( !array_key_exists ( $template['name'], $_POST ) && $template !== FALSE ) {
            return FALSE;
        }
    }
    return TRUE;
}


/////////////////////////////
//// Create Templatepage ////
/////////////////////////////

function create_templatepage ( $TEMPLATE_ARR, $GO, $TEMPLATE_FILE, $MANYFILES, $HIGHLIGHTER )
{
    global $global_config_arr, $db, $TEXT;
    global $admin_phrases;

    unset ($return_template);
    unset ($select_template);
    
    $select_forms = "";
    $show_editor = TRUE;


    // Set Default Style
    if ( !isset ( $_POST['style'] ) ) {
        $_POST['style'] = $global_config_arr['style'];
    } else {
        $_POST['style'] = unquote ( $_POST['style'] );
    }

    // Check Edit Allowed
    $index = mysql_query ( "
                            SELECT COUNT(`style_id`) AS 'number'
                            FROM `".$global_config_arr['pref']."styles`
                            WHERE `style_tag` = '".savesql ( $_POST['style'] )."'
                            AND `style_allow_edit` = 1
                            LIMIT 0,1
    ", $db );
    if ( mysql_result ( $index, 0, "number" ) != 1 ) {
        // Check Edit Allowed
        $index = mysql_query ( "
                                SELECT COUNT(`style_id`) AS 'number'
                                FROM `".$global_config_arr['pref']."styles`
                                WHERE `style_allow_edit` = 1
                                LIMIT 0,1
        ", $db );
        if ( mysql_result ( $index, 0, "number" ) != 1 ) {
            systext ( $TEXT["admin"]->get("template_no_editable_template"),
                $TEXT["admin"]->get("error"), TRUE, $TEXT["admin"]->get("icon_error") );
            $show_selection = FALSE;
        } elseif ( $show_editor !== FALSE ) {
            systext ( $TEXT["admin"]->get("template_select_template"),
                $TEXT["admin"]->get("info"), FALSE, $TEXT["admin"]->get("icon_info") );
        }
        $show_editor = FALSE;
    }

    // Set Style Path
    $style_path = FS2_ROOT_PATH . "styles/" . $_POST['style'];

    // Check if style exists
    if ( ! ( is_dir ( $style_path ) ) ) {
        systext ( $TEXT["admin"]->get("template_style_not_found"),
            $TEXT["admin"]->get("error"), TRUE, $TEXT["admin"]->get("icon_error") );
        $show_editor = FALSE;
    }

    // Set Selection-Titel
    $selection_title = $TEXT["admin"]->get("template_selection_title_template");


    // Special MANYFILES-Things
    if ( $MANYFILES === TRUE ) {
        // Just Load First Entry of Array
        $TMP = $TEMPLATE_ARR[0];
        unset ( $TEMPLATE_ARR );
        $TEMPLATE_ARR[0] = $TMP;

        // Get File Array
        $file_arr = array();
        $files = scandir_filter ( $style_path );
        foreach ( $files as $file ) {
            if ( pathinfo ( $file, PATHINFO_EXTENSION ) == $TEMPLATE_FILE ) {
                $file_arr[] = pathinfo ( $file, PATHINFO_BASENAME );
            }
        }

        // Set Default File
        if ( isset ( $_POST['file'] ) ) {
            $_POST['file'] = unquote ( $_POST['file'] );
            if ( !in_array ( unquote ( $_POST['file'] ), $file_arr ) && $_POST['file'] != "new" ) {
                 $_POST['file'] = $file_arr[0];
            }
        } else {
            if ( count ( $file_arr ) < 1 ) {
                $_POST['file'] = "new";
            } else {
                $_POST['file'] = $file_arr[0];
            }
        }

        // Selection-Forms
        $select_forms = get_templatepage_select ( "file", $style_path, $TEMPLATE_FILE, $show_editor );
        if ( $_POST['file'] == "new" ) {
            $select_forms .= get_templatepage_select ( "new", "", $TEMPLATE_FILE, $show_editor );
        }

        // Set Selected File
        if ( $_POST['file'] != "new") {
            $TEMPLATE_FILE = $_POST['file'];
        } else {
            $TEMPLATE_FILE = FALSE;
        }

        // Set Selection-Titel
        $selection_title = $TEXT["admin"]->get("template_selection_title_template_file");
    }


    // Set File Path
    $file_path = $style_path . "/" . $TEMPLATE_FILE;

    // Create File if not exists
    $access = new fileaccess();
    if ( $show_editor && !file_exists ( $file_path ) ) {
        if ( !$MANYFILES || $TEMPLATE_FILE != FALSE ) {
            if ( $access->putFileData ( $file_path, "" ) === FALSE ) {
                systext ( $TEXT["admin"]->get("template_file_not_found")."<br>".$TEXT["admin"]->get("template_file_not_created")."<br>".$TEXT["admin"]->get("error_file_access"),
                    $TEXT["admin"]->get("error"), TRUE, $TEXT["admin"]->get("icon_error") );
                $show_editor = FALSE;
            } else {
                systext ( $TEXT["admin"]->get("template_file_not_found")."<br>".$TEXT["admin"]->get("template_file_created"),
                    $TEXT["admin"]->get("info"), FALSE, $TEXT["admin"]->get("icon_save_add")  );
            }
        }
    } elseif ( $show_editor && !is_writable  ( $file_path )  ) {
        systext ( $TEXT["admin"]->get("template_file_not_writable")."<br>".$TEXT["admin"]->get("error_file_access"),
            $TEXT["admin"]->get("error"), TRUE, $TEXT["admin"]->get("icon_error") );
        $show_editor = FALSE;
    }


    // Selection Template
    $select_template = '
                <form action="" method="post">
                    <input type="hidden" name="go" value="'.$GO.'">
                    <table class="configtable" cellpadding="4" cellspacing="0">
                        <tr><td class="line">'.$selection_title.'</td></tr>
                        <tr>
                            <td class="config left">
                                <table cellpadding="0" cellspacing="0" border="0" class="config left" width="100%">
                                        '.get_templatepage_select ( "style" ).'
                                </table>
                            </td>
                        </tr>
                    </table>
                </form>

                <form action="" method="post">
                    <input type="hidden" name="go" value="'.$GO.'">
                    <input type="hidden" name="style" value="'.$_POST['style'].'">
                    <table class="configtable" cellpadding="4" cellspacing="0" style="margin-top:-19px;">
                        <tr>
                            <td class="config left">
    ';
    if ( $select_forms != "" ) {
        $select_template .= '
                                <table cellpadding="0" cellspacing="0" border="0" class="config left" width="100%">
                                    '.$select_forms.'
                                </table>
        ';
    }
    $select_template .= '
                            </td>
                        </tr>
                        <tr><td class="space"></td></tr>
                    </table>
    ';


    // Editor Template
    if ( $_POST['style'] && is_dir ( $style_path ) && $show_editor ) {

        // Get Data from Post or tpl-File
        if ( templatepage_postcheck ( $TEMPLATE_ARR ) && isset( $_POST['reload'] ) ) {
            foreach ($TEMPLATE_ARR as $template_key => $template_infos) {
                $TEMPLATE_ARR[$template_key]['template'] = htmlspecialchars ( unquote ( $_POST[$template_infos['name']] ) );
            }
        } elseif ( $MANYFILES === TRUE ) {
            foreach ($TEMPLATE_ARR as $template_key => $template_infos) {
                if ( is_array ( $template_infos ) === TRUE ) {
                    if ( $TEMPLATE_FILE == FALSE ) {
                        $TEMPLATE_ARR[$template_key]['template'] = "";
                    } else {
                        $ACCESS = new fileaccess ();
                        $TEMPLATE_ARR[$template_key]['template'] = htmlspecialchars ( $ACCESS->getFileData ( $file_path ) );
                    }
                }
            }
        } else {
            foreach ($TEMPLATE_ARR as $template_key => $template_infos) {
                if ( is_array ( $template_infos ) === TRUE ) {
                    $template_data = new template();
                    $template_data->setStyle( $_POST['style'] );
                    $template_data->setFile($TEMPLATE_FILE);
                    $template_data->load($template_infos['name']);
                    $template_data = $template_data->display();
                    $TEMPLATE_ARR[$template_key]['template'] = htmlspecialchars ( $template_data );
                }
            }
        }

        unset ($template_key);
        unset ($template);

        // Editor Form
        $return_template .= '
                    <script src="../resources/codemirror/js/codemirror.js" type="text/javascript"></script>
                    <input type="hidden" id="section_select" value="">
                    <table border="0" cellpadding="4" cellspacing="0" width="600">
                        <tr><td class="line">Templates bearbeiten</td></tr>
        ';

        // Special MANYFILES-Things
        if ( $MANYFILES === TRUE ) {
            $return_template .= '
                        <tr>
                            <td class="configthin">
                                '.$TEXT["admin"]->get("template_manyfile_delete_note").'
                            </td>
                        </tr>

            ';
        }

        // Create Editor for each Template-Section
        foreach ($TEMPLATE_ARR as $template_key => $template) {
                $return_template .= '
                        <tr><td class="space"></td></tr>

                        ' . create_templateeditor ( $template, $HIGHLIGHTER, $TEMPLATE_FILE, $MANYFILES ) . '

                        <tr><td class="space"></td></tr>
                        <tr>
                            <td class="buttontd" align="right">
                                <button class="button_new" type="submit" name="reload">
                                    '.$admin_phrases[common][arrow].' '.$admin_phrases[common][save_long].'
                                </button>
                            </td>
                        </tr>
                        <tr><td class="space"></td></tr>
                ';
        }
        unset ($template_key);
        unset ($template);

        // End of Editor Form
        $return_template .= '
                    </table>
                </form>
        ';

    } else {
        $return_template = '
                </form>
        ';
    }

    // check $show_selection
    if ( $show_selection === FALSE ) {
        $select_template = null;
    }

    // Return Page
    unset ($TEMPLATE_ARR);
    return $select_template . $return_template;
}

/////////////////////////////////
//// get_templatepage_select ////
/////////////////////////////////
function get_templatepage_select ( $TYPE, $STYLE_PATH = "", $FILE_EXT = "", $SHOW_REST = TRUE )
{
    global $global_config_arr, $db, $TEXT;
    global $admin_phrases;

    switch ( $TYPE ) {
        case "style":
            $select_template = '
                                    <tr>
                                        <td>
                                            <b>Zu bearbeitenden Style wählen:</b>
                                        </td>
                                        <td style="width:350px;">
                                            <select name="style" onChange="this.form.submit();" style="width:200px;">
            ';

            $index = mysql_query ( "
                                    SELECT `style_tag`
                                    FROM `".$global_config_arr['pref']."styles`
                                    WHERE `style_id` != 0
                                    AND `style_allow_edit` = 1
                                    ORDER BY `style_tag`
            ", $db );
            while ( $style_arr = mysql_fetch_assoc ( $index ) ) {
                $style_arr['style_tag'] = stripslashes ( $style_arr['style_tag'] );
                if ( is_dir ( FS2_ROOT_PATH . "styles/" . $style_arr['style_tag'] ) == TRUE ) {
                    $select_template .= '<option value="'.$style_arr['style_tag'].'" '.getselected ($style_arr['style_tag'], $_POST['style']).'>'.$style_arr['style_tag'];
                    $style_arr['style_tag'] == $global_config_arr['style'] ? $select_template .= ' (aktiv)' : $select_template .= "";
                    $select_template .= '</option>';
                }
            }

            $select_template .= '
                                            </select>
                                            <input class="button" value="Auswählen" type="submit">
                                        </td>
                                    </tr>
            ';
            
            return $select_template;
        
        case "file":
            if ( $SHOW_REST === FALSE ) {
                return "";
            }
        
            $select_template = '
                                    <tr><td class="space"></td></tr>
                                    <tr>
                                        <td>
                                            <b>Zu bearbeitende Datei wählen:</b>
                                        </td>
                                        <td style="width:350px;">
                                            <select name="file" onChange="this.form.submit();" style="width:200px;">
            ';

            $files = scandir_ext ( $STYLE_PATH, $FILE_EXT );
            foreach ( $files as $file ) {
                $select_template .= '<option value="'.$file.'" '.getselected ($file, $_POST['file']).'>'.$file.'</option>';
            }

            $select_template .= '
                                                <option value="new" '.getselected ( "new", $_POST['file'] ).'>Neue Datei erstellen...</option>
                                            </select>
                                            <input class="button" value="Auswählen" type="submit">
                                        </td>
                                    </tr>
            ';

            return $select_template;
        case "new":
            if ( $SHOW_REST === FALSE ) {
                return "";
            }
            $select_template = '
                                    <tr><td class="space"></td></tr>
                                    <tr>
                                        <td>
                                            Dateiname:
                                        </td>
                                        <td style="width:350px;">
                                            <input class="text" name="file_name" size="40" maxlength="60"> .'.$FILE_EXT.'
                                        </td>
                                    </tr>
            ';

            return $select_template;
    }


}

//////////////////////////////
//// create dropdown-menu ////
//////////////////////////////
function create_dropdown ( $TITLE, $CONTENT )
{
        return '
                                            <div class="html-editor-line"></div>
                                            <div class="html-editor-container-list">
                                                <a class="html-editor-list">'.$TITLE.'</a>
                                                <a class="html-editor-list-arrow"></a>
                                                <div class="html-editor-list-popup">
                                                     <table class="small html-editor-list-table" cellspacing="0">
                                                        '.$CONTENT.'
                                                     </table>
                                                </div>
                                            </div>
        ';
}

///////////////////////////
//// get all dropdowns ////
//////////////////////////
function get_dropdowns ( $EDITOR_NAME )
{
    global $db, $global_config_arr, $TEXT;
    
    // Security Functions
    $global_vars_array = array ();
    $applets_array = array ();
    $snippets_array = array ();
    $navs_array = array ();
    
    // Global Vars
    $global_vars = array ( "url", "style_url", "style_images", "style_icons", "page_title", "page_dyn_title", "date", "time", "date_time" );
    foreach ( $global_vars as $var ) {
        $the_var = '$VAR('.$var.')';
        $global_vars_array[] = '<tr class="pointer tag_click_class" title="'.$the_var.' einfügen" onClick="insert_editor_tag('.$EDITOR_NAME.',\''.$the_var.'\'); $(this).parents(\'.html-editor-list-popup\').hide();"><td class="tag_click_class"><span class="tag_click_class">$VAR(<b>'.$var.'</b>)</span></td><td><img class="tag_click_class" border="0" src="icons/pointer.gif" alt="->"></td></tr>';
    }
    $dropdowns['global_vars'] = create_dropdown ( "Globale Variablen", implode ( "", $global_vars_array ) );

    // Applets
    $index = mysql_query ( "
                            SELECT `applet_file` FROM `".$global_config_arr['pref']."applets` WHERE `applet_active` = 1
    ", $db );
    while ( $app_arr = mysql_fetch_assoc ( $index ) ) {
        $app = stripslashes ( $app_arr['applet_file'] );
        $the_app = '$APP('.$app.'.php)';
        $applets_array[] = '<tr class="pointer tag_click_class" title="'.$the_app.' einfügen" onClick="insert_editor_tag('.$EDITOR_NAME.',\''.$the_app.'\'); $(this).parents(\'.html-editor-list-popup\').hide();"><td class="tag_click_class"><span class="tag_click_class">$APP(<b>'.$app.'.php</b>)</span></td><td><img class="tag_click_class" border="0" src="icons/pointer.gif" alt="->"></td></tr>';
    }
    $dropdowns['applets'] = create_dropdown ( "Applets", implode ( "", $applets_array ) );

    // Snippets
    $index = mysql_query ( "
                            SELECT `snippet_tag` FROM `".$global_config_arr['pref']."snippets` WHERE `snippet_active` = 1
    ", $db );
    while ( $snippets_arr = mysql_fetch_assoc ( $index ) ) {
        $the_snippet = stripslashes ( $snippets_arr['snippet_tag'] );
        $snippets_array[] = '<tr class="pointer tag_click_class" title="'.$the_snippet.' einfügen" onClick="insert_editor_tag('.$EDITOR_NAME.',\''.$the_snippet.'\'); $(this).parents(\'.html-editor-list-popup\').hide();"><td class="tag_click_class"><b class="tag_click_class">'.$the_snippet.'</b></td><td><img class="tag_click_class" border="0" src="icons/pointer.gif" alt="->"></td></tr>';
    }
    $dropdowns['snippets'] = create_dropdown ( "Schnipsel", implode ( "", $snippets_array ) );

    // Navigationen
    $navs_arr = scandir_ext ( FS2_ROOT_PATH . "styles/" . $_POST['style'], "nav" );
    foreach ( $navs_arr as $nav ) {
        $the_nav = '$NAV('.$nav.')';
        $navs_array[] = '<tr class="pointer tag_click_class" title="'.$the_nav.' einfügen" onClick="insert_editor_tag('.$EDITOR_NAME.',\''.$the_nav.'\'); $(this).parents(\'.html-editor-list-popup\').hide();"><td class="tag_click_class"><span class="tag_click_class">$NAV(<b>'.$nav.'</b>)</span></td><td><img class="tag_click_class" border="0" src="icons/pointer.gif" alt="->"></td></tr>';
    }
    $dropdowns['navigations'] = create_dropdown ( "Navigationen", implode ( "", $navs_array ) );
    
    return $dropdowns;
}

//////////////////////
//// get tag list ////
//////////////////////
function get_taglist ( $TAG_ARR, $EDITOR_NAME )
{
    global $TEXT;

    $OC = new template ();
    $OC->getOpener();
    $OC->getCloser();
    $tag_array = array ();

    if ( count ( $TAG_ARR ) >= 1 ) {
        foreach ( $TAG_ARR as $help ) {
            $the_tag = $OC->getOpener().$help['tag'].$OC->getCloser();
            $tag_array[] = '<tr class="pointer tag_click_class" title="'.$the_tag.' einfügen" onClick="insert_editor_tag(editor_'.$EDITOR_NAME.',\''.$the_tag.'\'); $(this).parents(\'.html-editor-list-popup\').hide();"><td class="tag_click_class"><b class="tag_click_class">'.$the_tag.'</b><br>'.$help['text'].'</td><td><img class="tag_click_class" border="0" src="icons/pointer.gif" alt="->"></td></tr>';
        }
        $help_template = create_dropdown ( "Gültige Tags", implode ( "", $tag_array ) );
    } else {
        $help_template = "";
    }
    
    return $help_template;
}

/////////////////////////
//// get footer line ////
/////////////////////////
function get_footer_line ( $EDITOR_NAME, $STYLE, $HIGHLIGHTER, $FILE, $MANYFILES )
{
    global $TEXT;

    $highlighter_text = ( $HIGHLIGHTER == 3 ) ? "Javascript" : ( ( $HIGHLIGHTER == 2 ) ? "CSS" : "HTML" );
    $section_text = ( $MANYFILES == FALSE ) ? ' &gt; '.$EDITOR_NAME : "";
    $footer_template = '
                                    <div class="html-editor-path" id="'.$EDITOR_NAME.'_footer">
                                        <div style="padding:2px;" class="small">
                                            <span>Pfad: '.$STYLE.' &gt; '.$FILE . $section_text .'</span>
                                            <span class="html-editor-highlighter">'.$highlighter_text.'</span>
                                        </div>
                                    </div>
    ';

    return $footer_template;
}

/////////////////////////////
//// get original things ////
/////////////////////////////
function get_original_array ( $EDITOR_NAME, $FILE, $ROWS, $COLS )
{
    global $TEXT;

    if ( file_exists ( FS2_ROOT_PATH . "styles/default/" . $FILE ) ) {
        $original['button'] = '
                                            <a class="html-editor-button html-editor-button-original" onClick="toggelOriginal(\''.$EDITOR_NAME.'\')" title="Original anzeigen">
                                                <img src="img/null.gif" alt="Original anzeigen" border="0">
                                            </a>
        ';

        $original['template'] = new template();
        $original['template']->setStyle("default");
        $original['template']->setFile($FILE);
        $original['template']->load($EDITOR_NAME);
        $original['template'] = htmlspecialchars ( $original['template']->display() );

        $original['template'] = '
                                    <div id="'.$EDITOR_NAME.'_original" style="background-color:#ffffff; border: 1px solid #999999; width:100%; display:none;">
                                        <textarea class="no-js-html-editor" wrap="off"  rows="'.$ROWS.'" cols="'.$COLS.'" name="'.$EDITOR_NAME.'_org" readonly>'.$original['template'].'</textarea>
                                    </div>
        ';
        $original['row'] = '
                                        <div class="html-editor-row" id="'.$EDITOR_NAME.'_original-row" style="display:none;">
                                            '.$original['button'].'
                                        </div>
        ';
        return $original;
    }

    return array ( "button" => "", "template" => "", "row" => "" );
}

////////////////////////////////
//// create template editor ////
////////////////////////////////
function create_templateeditor ( $editor_arr, $HIGHLIGHTER, $FILE, $MANYFILES )
{
    global $db, $global_config_arr, $TEXT;
    global $admin_phrases;
    
    // Get Tag-Menu
    $help_template = get_taglist ( $editor_arr['help'], $editor_arr['name'] );

    // Get dropdowns
    $dropdowns = get_dropdowns ( "editor_".$editor_arr['name'] );
    if ( $MANYFILES == TRUE && $editor_arr['name'] == "NAV" ) {
        $dropdowns['navigations'] = "";
    }

    // Make Editor Height
    $editor_arr['height'] = 5 + ( $editor_arr['rows'] * 16 );

    // Get Higlight text
    $footer_template = get_footer_line ( $editor_arr['name'], $_POST['style'], $HIGHLIGHTER, $FILE, $MANYFILES );


    // get original template array
    if ( $MANYFILES == FALSE ) {
        $original = get_original_array ( $editor_arr['name'], $FILE, $editor_arr['rows'], $editor_arr['cols'] );
    } else {
        $original = array ( "button" => "", "template" => "", "row" => "" );
    }


    // create the final template
    $editor_template = '
                            <tr>
                                <td class="config" valign="top">

                                    <!-- CSS-Definitions for Non-JS-Editor -->

                                    <noscript>
                                        <style type="text/css">
                                            .html-editor-row {
                                                display:none;
                                            }
                                            .html-editor-row-header {
                                                border:none;
                                            }
                                            .html-editor-path .html-editor-highlighter {
                                                display:none;
                                            }
                                        </style>
                                    </noscript>
                                    
                                    <!-- Info while Frogpad is open -->
                                    
                                    <div id="'.$editor_arr['name'].'_inedit" style="display:none; position:absolute;">
                                        <br>
                                        Template in Bearbeitung...<br>
                                        Bitte den Editor schließen oder <a href="javascript:switch2inline_editor(\''.$editor_arr['name'].'\')">hier klicken</a>.
                                    </div>

                                    <!-- Editor-Bars with Buttons and Dropdowns -->
                                    
                                    <div class="html-editor-bar" id="'.$editor_arr['name'].'_editor-bar">
                                        <div class="html-editor-row-header">
                                            <span id="'.$editor_arr['name'].'_title">'.$editor_arr['title'].'</span> <span class="small">('.$editor_arr['description'].')</span>
                                        </div>
                                        '.$original['row'].'
                                        <div class="html-editor-row">
                                            <a class="html-editor-button html-editor-button-big" onClick="open_editor(\''.$editor_arr['name'].'\')" title="In Editor-Fenster öffnen">
                                                <img src="img/null.gif" alt="In Editor-Fenster öffnen" border="0">
                                            </a>
                                            '.$original['button'].'
                                            <div class="html-editor-line"></div>
                                            <a class="html-editor-button html-editor-button-active html-editor-button-line-numbers" onClick="toggelLineNumbers(this,\'editor_'.$editor_arr['name'].'\')" title="Zeilen-Nummerierung">
                                                <img src="img/null.gif" alt="Zeilen-Nummerierung" border="0">
                                            </a>
                                            '.$help_template.'
                                            '.$dropdowns['global_vars'].'
                                            '.$dropdowns['applets'].'
                                            '.$dropdowns['snippets'].'
                                            '.$dropdowns['navigations'].'
                                        </div>
                                    </div>
                                    
                                    <!-- Editor and original Editor -->
                                    
                                    <div id="'.$editor_arr['name'].'_content" style="background-color:#ffffff; border: 1px solid #999999; width:100%;">
                                        <textarea class="no-js-html-editor" wrap="off"  rows="'.$editor_arr['rows'].'" cols="'.$editor_arr['cols'].'" name="'.$editor_arr['name'].'" id="'.$editor_arr['name'].'">'.$editor_arr['template'].'</textarea>
                                    </div>
                                    <script type="text/javascript">
                                        editor_'.$editor_arr['name'].' = new_editor ( "'.$editor_arr['name'].'", "'.$editor_arr['height'].'", false, '.$HIGHLIGHTER.' );
                                    </script>
                                    '.$original['template'].'

                                    <!-- Footer and the rest -->

                                    '.$footer_template.'
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
    ';

    return $editor_template;
}



/////////////////////////////////
//// Ensure Use of Copyright ////
/////////////////////////////////

function ensure_copyright ( $TEMPLATE_NAME )
{
    $OC = new template ();
    if ( strpos ( $_POST[$TEMPLATE_NAME], $OC->getOpener()."copyright".$OC->getCloser() ) === FALSE ) {
        return FALSE;
    }

    unset ( $TEMPLATE_NAME );
    return TRUE;
}

?>