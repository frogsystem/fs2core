<?php
////////////////////////////////////
//// Templatepage Save Template ////
////////////////////////////////////

function templatepage_init ( $TEMPLATE_EDIT, $TEMPLATE_GO, $TEMPLATE_FILE, $SAVE = TRUE, $MANYFILES = FALSE )
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

    return create_templatepage ( $TEMPLATE_EDIT, $TEMPLATE_GO, $TEMPLATE_FILE, $MANYFILES );
}

////////////////////////////////////
//// Templatepage Save Template ////
////////////////////////////////////

function templatepage_save ( $TEMPLATE_ARR, $TEMPLATE_FILE, $MANYFILES = FALSE )
{
    global $TEXT;
    
    $file_data = null;
    if ( $MANYFILES ) {
        if ( $_POST['file'] == "new" ) {
            $_POST['file_name'] = unquote ( $_POST['file_name'] );
            if ( trim ( $_POST['file_name'] ) == "" ) {
                systext ( $TEXT["admin"]->get("changes_not_saved")."<br>".$TEXT["admin"]->get("template_no_filename"),
                    $TEXT["admin"]->get("error"), TRUE, $TEXT["admin"]->get("icon_error") );
                echo "<br>";
                return "file_name";
            }
            $TEMPLATE_FILE = $_POST['file_name'] . "." . $TEMPLATE_FILE;
            $_POST['file'] = $TEMPLATE_FILE;
        } else {
            $TEMPLATE_FILE = unquote ( $_POST['file'] );
        }
        $file_data = unquote ( $_POST[$TEMPLATE_ARR[0]['name']] );
    } else {
        foreach ($TEMPLATE_ARR as $template) {
            $file_data .= "<!--section-start::" . $template['name'] . "-->" . unquote ( $_POST[$template['name']] ) . "<!--section-end::".$template['name'] . "-->

";
        }
    }



    $directory_path = FS2_ROOT_PATH . "styles/" . $_POST['style'] . "/";
    $file_path =  $directory_path . $TEMPLATE_FILE;
    $access = new fileaccess();
    if ( is_writable ( $file_path ) || ( file_exists ( $directory_path ) && is_writable ( $directory_path ) ) ) {
        $access->putFileData ( FS2_ROOT_PATH . "styles/" . $_POST['style'] . "/" . $TEMPLATE_FILE, $file_data );
        return TRUE;
    } else {
        return FALSE;
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

function create_templatepage ( $TEMPLATE_ARR, $GO, $TEMPLATE_FILE, $MANYFILES )
{
    global $global_config_arr;
    global $db, $admin_phrases;
    global $TEXT;

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

    // Set Style Path
    $style_path = FS2_ROOT_PATH . "styles/" . $_POST['style'];

    // Check if style exists
    if ( !is_dir ( $style_path ) ) {
        systext ( $TEXT["admin"]->get("template_style_not_found"),
            $TEXT["admin"]->get("error"), TRUE, $TEXT["admin"]->get("icon_error") );
        $show_editor = FALSE;
    }


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
        $select_forms = get_templatepage_select ( "file", $style_path, $TEMPLATE_FILE );
        if ( $_POST['file'] == "new" ) {
            $select_forms .= get_templatepage_select ( "new", "", $TEMPLATE_FILE );
        }

        // Set Selected File
        if ( $_POST['file'] != "new") {
            $TEMPLATE_FILE = $_POST['file'];
        } else {
            $TEMPLATE_FILE = FALSE;
        }
    }
    
    
    // Set File Path
    $file_path = $style_path . "/" . $TEMPLATE_FILE;
    
    // Create File if not exists
    if ( $show_editor && !file_exists ( $file_path ) ) {
        if ( !$MANYFILES || $TEMPLATE_FILE != FALSE ) {
            if ( file_put_contents ( $file_path, "" ) === FALSE ) {
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
                    <table class="configtable" cellpadding="4" cellspacing="0">
                        <tr><td class="line">Style- & Datei-Auswahl</td></tr>
                        <tr>
                            <td class="config left">
                                <table cellpadding="0" cellspacing="0" border="0" class="config left" width="100%">
                <form action="" method="post">
                    <input type="hidden" name="go" value="'.$GO.'">
                                    '.get_templatepage_select ( "style" ).'
                </form>

                <form action="" method="post">
                    <input type="hidden" name="go" value="'.$GO.'">
                    <input type="hidden" name="style" value="'.$_POST['style'].'">
                                    '.$select_forms.'
                                </table>
                            </td>
                        </tr>
                        <tr><td class="space"></td></tr>
                    </table>
    ';
    
    
    // Editor Template
    if ( $_POST['style'] && is_dir ( $style_path ) ) {

        // Get Data from Post or tpl-File
        if ( templatepage_postcheck ( $TEMPLATE_ARR ) && isset( $_POST['reload'] ) ) {
            foreach ($TEMPLATE_ARR as $template_key => $template_infos) {
                $TEMPLATE_ARR[$template_key]['template'] = killhtml ( unquote ( $_POST[$template_infos['name']] ) );
            }
        } elseif ( $MANYFILES === TRUE ) {
            foreach ($TEMPLATE_ARR as $template_key => $template_infos) {
                if ( is_array ( $template_infos ) === TRUE ) {
                    if ( $TEMPLATE_FILE == FALSE ) {
                        $TEMPLATE_ARR[$template_key]['template'] = "";
                    } else {
                        $ACCESS = new fileaccess ();
                        $TEMPLATE_ARR[$template_key]['template'] = $ACCESS->getFileData ( $file_path );
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
                    $TEMPLATE_ARR[$template_key]['template'] = killhtml ( $template_data );
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
                            <tr>
        ';

        // Create Editor for each Template-Section
        foreach ($TEMPLATE_ARR as $template_key => $template) {
                $return_template .= '
                            <tr><td class="space"></td></tr>
                            
                            ' . create_templateeditor ( $template ) . '

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

    // check $show_editor
    if ( !$show_editor ) {
        $return_template = null;
    }

    // Return Page
    unset ($TEMPLATE_ARR);
    return $select_template . $return_template;
}

////////////////////////////////
//// get ////
////////////////////////////////
function get_templatepage_select ( $TYPE, $STYLE_PATH = "", $FILE_EXT = "" )
{
    global $global_config_arr;
    global $admin_phrases;
    global $TEXT;

    switch ( $TYPE ) {
        case "style":
            $select_template = '
                                    <tr>
                                        <td>
                                            <b>Zu bearbeitenden Style wählen:</b>
                                        </td>
                                        <td>
                                            <select name="style" onChange="this.form.submit();" style="width:200px;">
            ';

            $styles = scandir_filter ( FS2_ROOT_PATH . "styles", array ( "default" ) );
            foreach ( $styles as $style ) {
                if ( is_dir ( FS2_ROOT_PATH . "styles/" . $style ) == TRUE ) {
                    $select_template .= '<option value="'.$style.'" '.getselected ($style, $_POST['style']).'>'.$style;
                    $style == $global_config_arr['style'] ? $select_template .= ' (aktiv)' : $select_template .= "";
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
            $select_template = '
                                    <tr><td class="space"></td></tr>
                                    <tr>
                                        <td>
                                            <b>Zu bearbeitende Datei wählen:</b>
                                        </td>
                                        <td>
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
            $select_template = '
                                    <tr><td class="space"></td></tr>
                                    <tr>
                                        <td>
                                            Dateiname:
                                        </td>
                                        <td>
                                            <input class="text" name="file_name" size="40" maxlength="60"> .'.$FILE_EXT.'
                                        </td>
                                    </tr>
            ';

            return $select_template;
    }


}

////////////////////////////////
//// create template editor ////
////////////////////////////////
function create_templateeditor ( $editor_arr )
{
    global $db, $admin_phrases;
    unset ($editor_template);
    unset ($tag_array);

    $OC = new template ();
    $OC->getOpener();
    $OC->getCloser();

    if ( count ( $editor_arr['help'] ) >= 1 ) {
        foreach ( $editor_arr['help'] as $help ) {
            $tag_array[] = '<tr class="pointer tag_click_class" title="einfügen" onClick="insert_tag(editor_'.$editor_arr['name'].',\''.$OC->getOpener().$help['tag'].$OC->getCloser().'\'); $(this).parents(\'.html-editor-list-popup\').hide();"><td class="tag_click_class"><b class="tag_click_class">'.$OC->getOpener().$help['tag'].$OC->getCloser().'</b><br>'.$help['text'].'</td><td><img class="tag_click_class" border="0" src="icons/pointer.gif" alt="->"></td></tr>';
        }
        $help_template = '<table class="small html-editor-list-table" cellspacing="0">'.implode ( "", $tag_array ).'</table>';
    }
    $editor_arr['height'] = 5 + ( $editor_arr['rows'] * 16 );

    $editor_template .= '
                            <tr>
                                <td class="config" valign="top">

                                    <div id="'.$editor_arr[name].'_inedit" style="display:none; position:absolute;">
                                        <br>
                                        Template in Bearbeitung...<br>
                                        Bitte den Editor schließen oder <a href="javascript:switch2inline_editor(\''.$editor_arr['name'].'\')">hier klicken</a>.
                                    </div>
                                    <div class="html-editor-bar" id="'.$editor_arr[name].'_editor-bar">
                                        <div class="html-editor-row-header">
                                            <span id="'.$editor_arr[name].'_title">'.$editor_arr[title].'</span> <span class="small">('.$editor_arr['description'].')</span>
                                        </div>
                                        <div class="html-editor-row">
                                            <a onClick="open_editor(\''.$editor_arr[name].'\')" class="html-editor-button" style="background-image:url(html-editor/note-edit.gif)" title="In Editor-Fenster öffnen">
                                                <img src="../images/design/null.gif" alt="In Editor-Fenster öffnen" border="0">
                                            </a>
                                            <a onClick="openedit_original(\''.$editor_arr[name].'\')" class="html-editor-button" style="background-image:url(html-editor/doc-search.gif)" title="Original anzeigen">
                                                <img src="../images/design/null.gif" alt="Original anzeigen" border="0">
                                            </a>
                        ';
    if ( $help_template != "" ) {
        $editor_template .= '
                                            <div class="html-editor-line"></div>
                                            <div class="html-editor-container-list">
                                                <a class="html-editor-list">Gültige Tags</a>
                                                <a class="html-editor-list-arrow"></a>
                                                <div class="html-editor-list-popup">
                                                    '.$help_template.'
                                                </div>
                                            </div>
                            ';
    }
    $editor_template .= '
                                        </div>
                                    </div>
                                    <div id="'.$editor_arr[name].'_content" style="background-color:#ffffff; border: 1px solid #999999; width:100%;">
                                        <textarea style="height:'.$editor_arr['height'].';" cols="'.$editor_arr[cols].'" name="'.$editor_arr[name].'" id="'.$editor_arr[name].'"
                                    >'.$editor_arr[template].'</textarea>
                                    <script type="text/javascript">
                                        var editor_'.$editor_arr[name].' = new_editor ( "'.$editor_arr[name].'", "'.$editor_arr['height'].'", false );
                                    </script>
                                    </div>
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