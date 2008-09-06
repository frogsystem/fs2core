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
    global $db;

    unset ($return_template);
    unset ($select_template);

	if ( !isset ( $_POST['design'] ) ) {
	    $_POST['design'] = $global_config_arr['design'];
	}

    // Design ermittlen
    $select_template .= '
                    <div align="left">
                        <form action="" method="post">
                            <input type="hidden" value="'.$go.'" name="go">
                            <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                            <select name="design" onChange="this.form.submit();">
                                <option value="">Design auswählen</option>
                                <option value="">------------------------</option>
    ';

    $index = mysql_query("SELECT id, name FROM ".$global_config_arr[pref]."template WHERE id != 0 ORDER BY id", $db);
    while ($design_arr = mysql_fetch_assoc($index))
    {
      $select_template .= '<option value="'.$design_arr[id].'"';
      if ($design_arr[id] == $_POST[design])
        $select_template .= ' selected=selected';
      $select_template .= '>'.$design_arr[name];
      if ($design_arr[id] == $global_config_arr[design])
        $select_template .= ' (aktiv)';
      $select_template .= '</option>';
    }

    $select_template .= '
                            </select> <input class="button" value="Los" type="submit">
                        </form>
                    </div>
    ';

    if (isset($_POST['save'])) {
        unset ($_POST['design']);
        unset ($select_template);
    }

    if (isset($_POST['reload'])) {
        $select_template = "<br>" . $select_template;
    }

    if ( $_POST[design] && $_POST[design] != 0 && $_POST[design] != "" )
    {
        foreach ($template_arr as $template_key => $template)
        {
            if ($template == true)
            {
                $index = mysql_query("SELECT $template[name] FROM ".$global_config_arr[pref]."template WHERE id = '$_POST[design]'", $db);
                $template_arr[$template_key][template] = killhtml(mysql_result($index, 0, $template[name]));
            }
        }
        unset ($template_key);
        unset ($template);

        $return_template .= '
        <input type="hidden" value="" name="editwhat">
                    <form action="" method="post">
                        <input type="hidden" value="'.$go.'" name="go">
                        <input type="hidden" value="'.$_POST[design].'" name="design">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
        ';

        foreach ($template_arr as $template_key => $template)
        {
            if ($template != false)
            {
                $return_template .= create_templateeditor($template);
            }
            else
            {
                $return_template .= '
                            <tr>
                                <td class="config" colspan="2">
                                    <hr>
                                </td>
                            </tr>';
            }
        }
        unset ($template_key);
        unset ($template);

        $return_template .= '
                                    <tr>
                                <td colspan="2">
                                    <input class="button" type="submit" value="Speichern" name="save"> <input class="button" type="submit" value="Speichern & Neuladen" name="reload">
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

    $editor_template .= '
                            <tr>
                                <td class="config" valign="top">
                                    '.$editor_arr[title].':<br>
                                    <font class="small">'.$editor_arr[description];

    if (count($editor_arr[help]) >= 1)
    {
        $editor_template .= '<br /><br /><span style="padding-bottom:5px; display:block;">'.$admin_phrases[common][valid_tags].':<br /></span>';
        foreach ($editor_arr[help] as $help)
        {
            $editor_template .= insert_tt($help[tag],$help[text],$editor_arr[name]);
        }
    }

    unset ($help);

    $editor_template .= '
                                    </font>
                                <td class="config" valign="top">
                                    <textarea style="padding:3px;" rows="'.$editor_arr[rows].'" cols="'.$editor_arr[cols].'" name="'.$editor_arr[name].'" id="'.$editor_arr[name].'"
                                    >'.$editor_arr[template].'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top"></td>
                                <td class="config" valign="top">
                                    <input type="button" class="button" Value="Editor" onClick="openedit(\''.$editor_arr[name].'\')"> <input type="button" class="button" Value="Original anzeigen" onClick="openedit_original(\''.$editor_arr[name].'\')">
                                </td>
                            </tr>
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