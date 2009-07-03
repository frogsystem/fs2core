<?php
////////////////////////////////////
//// Templatepage Save Template ////
////////////////////////////////////

function templatepage_init($TEMPLATE_EDIT, $TEMPLATE_GO, $SAVE=TRUE)
{
    if ( templatepage_postcheck($TEMPLATE_EDIT) && $SAVE ) {
        templatepage_save($TEMPLATE_EDIT);
        systext("Template wurde aktualisiert");
        return create_templatepage ($TEMPLATE_EDIT, $TEMPLATE_GO);
    } else {
        if ( $SAVE == FALSE && templatepage_postcheck($TEMPLATE_EDIT) ) {
            systext("Der Copyright-Hinweis darf nicht entfernt werden.<br />Die Änderungen wurden nicht gespeichert.");
        }
        return create_templatepage ($TEMPLATE_EDIT, $TEMPLATE_GO);
    }

    unset ($TEMPLATE_EDIT);
    unset ($TEMPLATE_GO);
}

////////////////////////////////////
//// Templatepage Save Template ////
////////////////////////////////////

function templatepage_save($template_arr)
{
    global $global_config_arr;
    global $db;

    foreach ($template_arr as $template)
    {
        $save_template = savesql($_POST[$template[name]]);
        mysql_query("update ".$global_config_arr[pref]."template
                    set $template[name] = '".$_POST[$template[name]]."'
                    where id = '$_POST[design]'", $db);
    }

    unset ($template);
    unset ($template_arr);
}


///////////////////////////////////
//// Templatepage $_POST-Check ////
///////////////////////////////////

function templatepage_postcheck($template_arr)
{
    global $db;
    $return_true = false;

    foreach ($template_arr as $template)
    {
        if ($_POST[$template[name]]) {
            $return_true = true;
        }
    }

    unset ($template);
    unset ($template_arr);

    if ($return_true) {
        return true;
    } else {
        return false;
    }
}


/////////////////////////////
//// Create Templatepage ////
/////////////////////////////

function create_templatepage($template_arr, $go)
{
    global $global_config_arr;
    global $db, $admin_phrases;

    unset ($return_template);
    unset ($select_template);

    if ( !isset ( $_POST['style'] ) ) {
        $_POST['style'] = $global_config_arr['style'];
    }

    // Design ermittlen
    $select_template .= '
                    <table class="configtable" cellpadding="4" cellspacing="0">
                        <tr><td class="line">Style-Auswahl</td></tr>
                        <tr>
                            <td class="config left">
                                <form action="" method="post">
                                    <input type="hidden" value="'.$go.'" name="go">
                                    <b>Zu bearbeitenden Style wählen:</b>
                                    <select name="style" onChange="this.form.submit();" style="width:200px;">
    ';

    $styles = scandir_filter ( FS2_ROOT_PATH."styles", array ( "default" ) );
    foreach ($styles as $style) {
        if ( is_dir ( FS2_ROOT_PATH."styles/".$style ) == TRUE ) {
            $select_template .= '<option value="'.$style.'" '.getselected ($style, $_POST['design']).'>'.$style;
            $style == $global_config_arr['style'] ? $select_template .= ' (aktiv)' : $select_template .= "";
            $select_template .= '</option>';
        }
    }

    $select_template .= '
                                    </select>
                                    <input class="button" value="Wähle" type="submit">
                                </form>
                            </td>
                        </tr>
                        <tr><td class="space"></td></tr>
                        <tr><td class="line">Templates bearbeiten</td></tr>
                        <tr>
                    </table>
    ';

    if (isset($_POST['save'])) {
        unset ($_POST['style']);
        unset ($select_template);
    }

    if (isset($_POST['reload'])) {
        $select_template = "<br>" . $select_template;
    }

    if ( $_POST['style'] && is_dir ( FS2_ROOT_PATH."styles/".$_POST['style'] ) )
    {
        foreach ($template_arr as $template_key => $template)
        {
            if ( is_array ( $template ) === true )
            {
                $template_data = new template();
                $template_data->setFile("0_general.tpl");
                $template_data->load($template['name']);
                $template_data = $template_data->display();
                $template_arr[$template_key][template] = killhtml ( $template_data );
            }
        }
        unset ($template_key);
        unset ($template);

        $return_template .= '
                    <script src="../resources/codemirror/js/codemirror.js" type="text/javascript"></script>
                    <form action="" method="post">
                        <input type="hidden" value="'.$go.'" name="go">
                        <input type="hidden" value="'.$_POST[design].'" name="design">
                        <input type="hidden" id="section_select" value="">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
        ';

        foreach ($template_arr as $template_key => $template) {
            if ($template != false) {
                $return_template .= create_templateeditor($template);
            } else {
                $return_template .= '
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="buttontd" align="right">
                                    <button class="button_new" type="submit" name="reload">
                                        '.$admin_phrases[common][arrow].' '.$admin_phrases[common][save_long].'
                                    </button>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr><td class="space"></td></tr>';
            }
        }
        unset ($template_key);
        unset ($template);

        $return_template .= '
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="buttontd" align="right">
                                    <button class="button_new" type="submit" name="reload">
                                        '.$admin_phrases[common][arrow].' '.$admin_phrases[common][save_long].'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
        ';

    }

    unset ($template_arr);
    return $select_template.$return_template;
}

////////////////////////////////
//// create template editor ////
////////////////////////////////
function create_templateeditor($editor_arr)
{
    global $db, $admin_phrases;
    unset ($editor_template);
    unset ($tag_array);

    if ( count ( $editor_arr['help'] ) >= 1 ) {
        foreach ( $editor_arr['help'] as $help ) {
            $tag_array[] = "<b>".$help['tag']."</b><br>".$help['text']."</td><td>->";
        }
        $help_template = '<table class="small html-editor-list-table" cellspacing="0"><tr><td>'.implode ( "</td></tr><tr><td>", $tag_array ).'</td></tr></table>';
    }
    $editor_arr['height'] = 5 + ( $editor_arr['rows'] * 16 );

    $editor_template .= '
                            <tr>
                                <td class="config" valign="top">
                                    <span id="'.$editor_arr[name].'_title">'.$editor_arr[title].'</span> <span class="small">('.$editor_arr[description].')</span>
                                    <div id="'.$editor_arr[name].'_inedit" style="display:none; position:absolute;">
                                        <br>
                                        Template in Bearbeitung...<br>
                                        Bitte den Editor schließen oder <a href="javascript:switch2inline_editor(\''.$editor_arr[name].'\')">hier klicken</a>.
                                    </div>
                                    <div class="html-editor-bar" id="'.$editor_arr[name].'_editor-bar">
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
                                            <div class="html-editor-list-container">
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
                                            <a onClick="editor_'.$editor_arr[name].'.undo()" class="html-editor-button" style="background-image:url(html-editor/action-undo.gif)" title="Rückgängig (Strg+Z)">
                                                <img src="../images/design/null.gif" alt="Rückgängig (Strg+Z)" border="0">
                                            </a>
                                            <a onClick="editor_'.$editor_arr[name].'.redo()" class="html-editor-button" style="background-image:url(html-editor/action-redo.gif)" title="Wiederholen (Strg+Y)">
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
                            <tr><td class="space"></td></tr>
    ';

    return $editor_template;
}

/////////////////////////////////
//// Ensure Use of Copyright ////
/////////////////////////////////

function ensure_copyright($TEMPLATE_NAME)
{
    if (strpos ($_POST[$TEMPLATE_NAME], "{copyright}") == FALSE) {
        return FALSE;
    }

    unset ($TEMPLATE_NAME);
    return TRUE;
}

?>