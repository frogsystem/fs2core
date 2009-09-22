<?php
////////////////////////////////////
//// Templatepage Save Template ////
////////////////////////////////////

function templatepage_init ( $TEMPLATE_EDIT, $TEMPLATE_GO, $TEMPLATE_FILE, $SAVE = TRUE )
{
    global $admin_phrases;
    
    if ( templatepage_postcheck ( $TEMPLATE_EDIT ) && isset( $_POST['reload'] ) ) {
        if ( $SAVE === FALSE ) {
            systext ( $admin_phrases[common][changes_not_saved]."<br>Der Copyright-Hinweis darf nicht entfernt werden", $admin_phrases[common][error], TRUE, '<img src="icons/error.jpg" alt="" align="absmiddle">' );
        } elseif ( templatepage_save ( $TEMPLATE_EDIT, $TEMPLATE_FILE ) ) {
            systext ( "Template wurde aktualisiert", $admin_phrases[common][changes_saved], FALSE, '<img src="icons/save_ok.jpg" alt="" align="absmiddle">' );
            unset ( $_POST );
        } else {
            systext ( $admin_phrases[common][changes_not_saved]."<br>Vermutlich liegt einer Fehler bei den Dateiberechtigungen vor", $admin_phrases[common][error], TRUE, '<img src="icons/error.jpg" alt="" align="absmiddle">' );
        }
    }

    return create_templatepage ( $TEMPLATE_EDIT, $TEMPLATE_GO, $TEMPLATE_FILE );
}

////////////////////////////////////
//// Templatepage Save Template ////
////////////////////////////////////

function templatepage_save ( $TEMPLATE_ARR, $TEMPLATE_FILE )
{
    $file_data = null;
    foreach ($TEMPLATE_ARR as $template) {
        $file_data .= "<!--section-start::" . $template['name'] . "-->" . unquote ( $_POST[$template['name']] ) . "<!--section-end::".$template['name'] . "-->

";
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

function create_templatepage ( $TEMPLATE_ARR, $GO, $TEMPLATE_FILE )
{
    global $global_config_arr;
    global $db, $admin_phrases;

    unset ($return_template);
    unset ($select_template);
    unquote ( $_POST['style'] );


    // Set Default Style
    if ( !isset ( $_POST['style'] ) ) {
        $_POST['style'] = $global_config_arr['style'];
    }

    // Style-Selection Template
    if ( isset ( $_POST['reload'] ) ) {
        $select_template = "<br>";
    }

    $select_template .= '
                    <table class="configtable" cellpadding="4" cellspacing="0">
                        <tr><td class="line">Style-Auswahl</td></tr>
                        <tr>
                            <td class="config left">
                                <form action="" method="post">
                                    <input type="hidden" value="'.$GO.'" name="go">
                                    <b>Zu bearbeitenden Style wählen:</b>
                                    <select name="style" onChange="this.form.submit();" style="width:200px;">
    ';

    $styles = scandir_filter ( FS2_ROOT_PATH . "styles", array ( "default" ) );
    foreach ( $styles as $style ) {
        if ( is_dir ( FS2_ROOT_PATH . "styles/" . $style ) == TRUE ) {
            $select_template .= '<option value="'.$style.'" '.getselected ($style, $_POST['design']).'>'.$style;
            $style == $global_config_arr['style'] ? $select_template .= ' (aktiv)' : $select_template .= "";
            $select_template .= '</option>';
        }
    }

    $select_template .= '
                                    </select>
                                    <input class="button" value="Auswählen" type="submit">
                                </form>
                            </td>
                        </tr>
                        <tr><td class="space"></td></tr>
                    </table>
    ';
    
    
    // Editor Template
    if ( $_POST['style'] && is_dir ( FS2_ROOT_PATH . "styles/" . $_POST['style'] ) ) {

        // Get Data from Post or tpl-File
        if ( templatepage_postcheck ( $TEMPLATE_ARR ) && isset( $_POST['reload'] ) ) {
            foreach ($TEMPLATE_ARR as $template_key => $template_infos) {
                $TEMPLATE_ARR[$template_key]['template'] = killhtml ( unquote ( $_POST[$template_infos['name']] ) );
            }
        } else {
            foreach ($TEMPLATE_ARR as $template_key => $template_infos) {
                if ( is_array ( $template_infos ) === TRUE ) {
                    $template_data = new template();
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
                    <form action="" method="post">
                        <input type="hidden" value="'.$GO.'" name="go">
                        <input type="hidden" value="'.$_POST['style'].'" name="style">
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

    }

    // Return Page
    unset ($TEMPLATE_ARR);
    return $select_template . $return_template;
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

                                            <div class="html-editor-line"></div>
                                            <a onClick="html_editor_undo(editor_'.$editor_arr[name].', this);" class="html-editor-button undo" style="background-image:url(html-editor/action-undo.gif)" title="Rückgängig (Strg+Z)">
                                                <img src="../images/design/null.gif" alt="Rückgängig (Strg+Z)" border="0">
                                            </a>
                                            <a onClick="html_editor_redo(editor_'.$editor_arr[name].', this);" class="html-editor-button redo" style="background-image:url(html-editor/action-redo.gif)" title="Wiederholen (Strg+Y)">
                                                <img src="../images/design/null.gif" alt="Wiederholen (Strg+Y)" border="0">
                                            </a>
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
                            <tr><td class="space">
                            <a onClick="alert(editor_'.$editor_arr[name].'.historySize()[\'redo\']);">test</a>
                            </td></tr>
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