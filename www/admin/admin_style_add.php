<?php

/*

if ($_POST['name'])
{
    $_POST[name] = savesql($_POST[name]);

    $index = mysql_query("SELECT COUNT(id) AS number FROM ".$global_config_arr[pref]."template WHERE name = '$_POST[name]'", $db);
    if (mysql_result($index,0,"number") == 0)
    {
        //Leeres Template
        if ($_POST['create_as'] == "new")
        {
            $index = mysql_query("SELECT id FROM ".$global_config_arr[pref]."template ORDER BY id DESC", $db);
            $id = mysql_result($index, "id");
            $id++;
            mysql_query("INSERT INTO ".$global_config_arr[pref]."template(id, name) VALUES ('$id', '$_POST[name]')", $db);
            systext("Das Design wurde erfolgreich erstellt!");
        }

        //Kopie
        elseif ($_POST['create_as'] == "copy")
        {
            mysql_query("INSERT INTO ".$global_config_arr[pref]."template
                         SELECT *
                         FROM ".$global_config_arr[pref]."template
                         WHERE id = '$_POST[design_id]'", $db);

            $index = mysql_query("SELECT id FROM ".$global_config_arr[pref]."template ORDER BY id DESC", $db);
            $id = mysql_result($index, "id");
            $id++;
            mysql_query("UPDATE ".$global_config_arr[pref]."template
                         SET name = '$_POST[name]',
                             id = '$id'
                         WHERE id = '$_POST[design_id]'
                         LIMIT 1", $db);
            systext("Das Design wurde erfolgreich erstellt!");
        }
    }
    else
    {
        systext("Es existiert bereits ein Design mit diesem Namen!");
    }
}


/////////////////////////////////////
////// Template Formular ////////////
/////////////////////////////////////

else
{

  systext($error_message);
  echo'<form action="" method="post">
         <input type="hidden" value="design_create" name="go">
         <table border="0" cellpadding="4" cellspacing="0" width="600">
           <tr align="left" valign="top">
             <td class="config" valign="top" width="30%">
               Name:<br>
               <font class="small">Der Name des Designs</font>
             </td>
             <td class="config" valign="top">
               <input class="text" size="40" name="name" maxlength="100" value="'.$_POST['name'].'" />
             </td>
           </tr>
           <tr>
             <td class="config" valign="top" width="30%">
               Erstellen als:
             </td>
             <td class="config" valign="top">
               <input type="radio" name="create_as" value="new" checked="checked" /> leeres Design<br>
               <input type="radio" name="create_as" value="copy" /> Kopie eines bestehenden Designs:
               <select name="design_id" size="1">';

               $index = mysql_query("select id, name from ".$global_config_arr[pref]."template ORDER BY id", $db);
               while ($admin_design_arr = mysql_fetch_assoc($index))
               {
                 echo '<option value="'.$admin_design_arr[id].'"';
                 if ($admin_design_arr[id] == $global_config_arr[design]) {
                   echo ' selected=selected'; }
                 echo '>'.$admin_design_arr[name];
                 if ($admin_design_arr[id] == $global_config_arr[design]) {
                   echo ' (aktiv)'; }
                 echo '</option>';
               }
  echo'
           </select><br><br>
           
             </td>
           </tr>
           <tr>
             <td align="center" colspan="2">
               <input class="button" type="submit" value="Absenden">
             </td>
           </tr>
         </table>
       </form>
      ';
}
   */

/////////////////////////
//// Save Data to DB ////
/////////////////////////

if (
        $_POST['style_tag'] && preg_match ( '/^[0-9a-z_\-]+$/', $_POST['style_tag'] ) === 1
        && $_POST['style_tag'] != "" && strlen ( $_POST['style_tag'] ) >= 1
        && $_POST['style_name'] && $_POST['style_name'] != ""
        && ( $_POST['style_create_as'] == "new" || ( $_POST['style_create_as'] == "copy" && $_POST['copy_style_id'] ) )
    )
{
    // Security Functions
    $_POST['style_folder'] = $_POST['style_tag'];
    $_POST['style_tag'] = savesql ( $_POST['style_tag'] );
    $_POST['style_create_as'] = ( $_POST['style_create_as'] == "copy" ) ? "copy" : "new";
    settype ( $_POST['style_allow_use'], "integer" );
    settype ( $_POST['style_allow_edit'], "integer" );
    settype ( $_POST['copy_style_id'], "integer" );

    // Folder Operations
    $new_ini_data = $_POST['style_name']."
".$_POST['style_version']."
".$_POST['style_copyright'];
    
    // New Style Path
    $new_style_path = FS2_ROOT_PATH . "styles/" . $_POST['style_folder'];
    
    // Create Sytle Folder
    $ACCESS = new fileaccess();
    if (
            @$ACCESS->createDir( $new_style_path , 0755 )
            && @$ACCESS->putFileData( $new_style_path . "/style.ini", $new_ini_data )
    ) {
    
        // MySQL-Queries
        mysql_query ( "
                        INSERT INTO
                            `".$global_config_arr['pref']."styles`
                            ( `style_tag`, `style_allow_use`, `style_allow_edit` )
                        VALUES
                            ( '".$_POST['style_tag']."', '".$_POST['style_allow_use']."', '".$_POST['style_allow_edit']."' )
        ", $db );

        // Copy Style recursive
        if ( $_POST['style_create_as'] == "copy" && $_POST['copy_style_id'] ) {
            // MySQL-Queries
            $index = mysql_query ( "
                                    SELECT
                                        `style_tag`
                                    FROM
                                        `".$global_config_arr['pref']."styles`
                                    WHERE
                                        `style_id` = ".$_POST['copy_style_id']."
                                    LIMIT 0,1
            ", $db );
            $copy_style_path = FS2_ROOT_PATH . "styles/" . stripslashes ( mysql_result ( $index, 0, "style_tag" ) );
            if (
                    $ACCESS->copyAny( $copy_style_path, $new_style_path, 0755, 0644 )
                    && $ACCESS->putFileData( $new_style_path . "/style.ini", $new_ini_data )
            ) {
                systext ( $TEXT["admin"]->get("style_added"),
                    $TEXT["admin"]->get("info"), FALSE, $TEXT["admin"]->get("icon_save_add") );
            } else {
                systext ( $TEXT["admin"]->get("style_added")."<br>".$TEXT["admin"]->get("style_error_copy")."<br>".$TEXT["admin"]->get("error_file_access"),
                    $TEXT["admin"]->get("info"), FALSE, $TEXT["admin"]->get("icon_save_add") );
            }
        // Create New Style
        } else {
            if (
                    @$ACCESS->createDir( $new_style_path . "/images", 0755 )
                    && @$ACCESS->createDir( $new_style_path . "/icons", 0755 )
            ) {
                systext ( $TEXT["admin"]->get("style_added"),
                    $TEXT["admin"]->get("info"), FALSE, $TEXT["admin"]->get("icon_save_add") );
            } else {
                systext ( $TEXT["admin"]->get("style_added")."<br>".$TEXT["admin"]->get("style_error_folder_creation")."<br>".$TEXT["admin"]->get("error_file_access"),
                    $TEXT["admin"]->get("info"), FALSE, $TEXT["admin"]->get("icon_save_add") );
            }
        }

    } else {
        @deleteAny ( $new_style_path );
        systext ( $TEXT["admin"]->get("style_not_added")."<br>".$TEXT["admin"]->get("error_file_access"),
            $TEXT["admin"]->get("error"), TRUE, $TEXT["admin"]->get("icon_error") );
    }
    unset ( $_POST );
}

////////////////////////
//// Add Stlye Form ////
////////////////////////

// Check for file rights
if ( !is_writable ( FS2_ROOT_PATH . "styles/" ) ) {
    systext ( $TEXT["admin"]->get("style_folder_not_writable")."<br>".$TEXT["admin"]->get("error_file_access"),
        $TEXT["admin"]->get("error"), TRUE, $TEXT["admin"]->get("icon_error") );
} else {

    // Check for Errors
    if ( isset ( $_POST['sended'] ) ) {

        $error_message = array();
        if ( $_POST['style_name'] == "" || $_POST['style_tag'] == "" ) {
            $error_message[] = $TEXT["admin"]->get("form_not_filled");
        }
        if ( preg_match ( '/^[0-9a-z_\-]+$/', $_POST['style_tag'] ) !== 1 && $_POST['style_tag'] != "" ) {
            $error_message[] = $TEXT["admin"]->get("form_only_allowed_values");
        }

        systext ( $TEXT["admin"]->get("style_not_added")."<br>".implode ( "<br>", $error_message ),
            $TEXT["admin"]->get("error"), TRUE, $TEXT["admin"]->get("icon_save_error") );

    // Set Data
    } else {
        $_POST['style_allow_use'] = 1;
        $_POST['style_allow_edit'] = 1;
        $_POST['copy_style_id'] = $global_config_arr['style_id'];
        $_POST['style_create_as'] = "new";
    }


    // Security Functions
    $_POST['style_name'] = killhtml ( $_POST['style_name'] );
    $_POST['style_version'] = killhtml ( $_POST['style_version'] );
    $_POST['style_copyright'] = killhtml ( $_POST['style_copyright'] );

    $_POST['style_tag'] = killhtml ( $_POST['style_tag'] );
    $_POST['style_create_as'] = ( $_POST['style_create_as'] == "copy" ) ? "copy" : "new";
    settype ( $_POST['style_allow_use'], "integer" );
    settype ( $_POST['style_allow_edit'], "integer" );
    settype ( $_POST['copy_style_id'], "integer" );


    // Display Form
    echo '
                    <form action="" method="post">
                        <input type="hidden" name="go" value="style_add">
                        <input type="hidden" name="sended" value="1">
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="2">'.$TEXT["admin"]->get("style_content_title").'</td></tr>
                                <td class="config">
                                    '.$TEXT["admin"]->get("style_create_as_title").':<br>
                                    <span class="small">'.$TEXT["admin"]->get("style_create_as_desc").'</span>
                                </td>
                                <td class="config">
                                    <input class="pointer middle" type="radio" name="style_create_as" id="style_create_as_new" value="new" '.getchecked ( "new", $_POST['style_create_as'] ).'>
                                    <label class="pointer middle" for="style_create_as_new">'.$TEXT["admin"]->get("style_create_as_empty").'</label><br><br>
                                    <input class="pointer middle" type="radio" name="style_create_as" id="style_create_as_copy" value="copy" '.getchecked ( "copy", $_POST['style_create_as'] ).'>
                                    <label class="pointer middle" for="style_create_as_copy">'.$TEXT["admin"]->get("style_create_as_copy").':</label>
                                    <br><br>
                                    <div align="right">
                                        <select class="input_width pointer middle" name="copy_style_id" size="1">';

    $index = mysql_query ( "
                            SELECT `style_id`, `style_tag`
                            FROM `".$global_config_arr['pref']."styles`
                            ORDER BY `style_id`
    ", $db );
    while ( $style_arr = mysql_fetch_assoc ( $index ) ) {
        settype ( $style_arr['style_id'], "integer" );
        echo '<option value="'.$style_arr['style_id'].'" '.getselected( $style_arr['style_id'], $_POST['copy_style_id'] ).'>'.killhtml ( $style_arr['style_tag'] );
        echo ( $style_arr['style_id'] == $global_config_arr['style_id'] ) ? ' ('.$TEXT['admin']->get("active").')' : "";
        echo '</option>';
    }
    echo'
                                        </select>
                                    </div>
                                </td>
                            <tr><td class="space"></td></tr>
                        
                            <tr><td class="line" colspan="2">'.$TEXT["admin"]->get("style_info_title").'</td></tr>
                            <tr>
                                <td class="config">
                                    '.$TEXT["admin"]->get("style_tag_title").':<br>
                                    <span class="small">'.$TEXT["admin"]->get("style_tag_desc").'</span>
                                </td>
                                <td class="config">
                                    <input class="text input_width_small" name="style_tag" maxlength="30" value="'.$_POST['style_tag'].'"><br>
                                    <span class="small">'.$TEXT["admin"]->get("folder_name_info").'</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$TEXT["admin"]->get("style_name_title").':<br>
                                    <span class="small">'.$TEXT["admin"]->get("style_name_desc").'</span>
                                </td>
                                <td class="config">
                                    <input class="text input_width" name="style_name" maxlength="100" value="'.$_POST['style_name'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$TEXT["admin"]->get("style_version_title").': <span class="small">('.$TEXT["admin"]->get("optional").')</span><br>
                                    <span class="small">'.$TEXT["admin"]->get("style_version_desc").'</span>
                                </td>
                                <td class="config">
                                    <input class="text input_width_mini" name="style_version" maxlength="15" value="'.$_POST['style_version'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$TEXT["admin"]->get("style_copyright_title").': <span class="small">('.$TEXT["admin"]->get("optional").')</span><br>
                                    <span class="small">'.$TEXT["admin"]->get("style_copyright_desc").'</span>
                                </td>
                                <td class="config">
                                    <input class="text input_width" name="style_copyright" maxlength="255" value="'.$_POST['style_copyright'].'">
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>

                            <tr><td class="line" colspan="2">'.$TEXT["admin"]->get("style_config_title").'</td></tr>
                            <tr>
                                <td class="config">
                                    '.$TEXT["admin"]->get("style_allow_use_title").':<br>
                                    <span class="small">'.$TEXT["admin"]->get("style_allow_use_desc").'</span>
                                </td>
                                <td class="config">
                                    <input class="pointer" type="checkbox" name="style_allow_use" value="1" '.getchecked ( 1, $_POST['style_allow_use'] ).'>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$TEXT["admin"]->get("style_allow_edit_title").':<br>
                                    <span class="small">'.$TEXT["admin"]->get("style_allow_edit_desc").'</span>
                                </td>
                                <td class="config">
                                    <input class="pointer" type="checkbox" name="style_allow_edit" value="1" '.getchecked ( 1, $_POST['style_allow_edit'] ).'>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td colspan="2" class="buttontd">
                                    <button class="button_new" type="submit">
                                        '.$TEXT["admin"]->get("button_arrow").' '.$TEXT["admin"]->get("style_add_title").'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>