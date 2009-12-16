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
        $_POST['alias_go'] && $_POST['alias_go'] != ""
        && $_POST['alias_forward_to'] && $_POST['alias_forward_to'] != ""
    )
{
    // Security Functions
    $_POST['alias_go'] = savesql ( $_POST['alias_go'] );
    $_POST['alias_forward_to'] = savesql ( $_POST['alias_forward_to'] );

    settype ( $_POST['alias_active'], "integer" );

    // MySQL-Queries
    mysql_query ( "
                    INSERT INTO `".$global_config_arr['pref']."aliases` (
                            `alias_go`,
                            `alias_forward_to`,
                            `alias_active`
                    )
                    VALUES (
                            '".$_POST['alias_go']."',
                            '".$_POST['alias_forward_to']."',
                            '".$_POST['alias_active']."'
                    )
    ", $db );

    systext ( $TEXT["admin"]->get("alias_added"),
        $TEXT["admin"]->get("info"), FALSE, $TEXT["admin"]->get("icon_save_add") );
    unset ( $_POST );
}

////////////////////////
//// Add Stlye Form ////
////////////////////////

// Security Functions
$_POST['style_name'] = killhtml ( $_POST['style_name'] );
$_POST['style_version'] = killhtml ( $_POST['style_version'] );
$_POST['style_copyright'] = killhtml ( $_POST['style_copyright'] );

$_POST['style_tag'] = killhtml ( $_POST['style_tag'] );
settype ( $_POST['style_allow_use'], "integer" );
settype ( $_POST['style_allow_edit'], "integer" );

// Check for Errors
if ( isset ( $_POST['sended'] ) ) {

    $error_message = $TEXT["admin"]->get("form_not_filled");
    systext ( $TEXT["admin"]->get("alias_not_added")."<br>".$error_message,
        $TEXT["admin"]->get("error"), TRUE, $TEXT["admin"]->get("icon_save_error") );

// Set Data
} else {
    $_POST['style_allow_use'] = 1;
    $_POST['style_allow_edit'] = 1;
}


// Display Form
echo '
                    <form action="" method="post">
                        <input type="hidden" name="go" value="style_add">
                        <input type="hidden" name="sended" value="1">
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="2">'.$TEXT["admin"]->get("style_info_title").'</td></tr>
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
                                    '.$TEXT["admin"]->get("style_version_title").':<br>
                                    <span class="small">'.$TEXT["admin"]->get("style_version_desc").'</span>
                                </td>
                                <td class="config">
                                    <input class="text input_width_mini" name="style_version" maxlength="15" value="'.$_POST['style_version'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$TEXT["admin"]->get("style_copyright_title").':<br>
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
                                        <select class="pointer middle" name="style_id" size="1">';

                           $index = mysql_query ( "
                                                    SELECT
                                                        `style_tag`
                                                    FROM
                                                        `".$global_config_arr['pref']."styles`
                                                    WHERE
                                                        `style_id` != 0
                                                    ORDER BY
                                                        `style_tag`
                           ", $db );
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
                                        </select>
                                    </div>
                                </td>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td colspan="2" class="buttontd">
                                    <button class="button_new" type="submit">
                                        '.$admin_phrases[common][arrow].' '.$TEXT["admin"]->get("style_add_title").'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
';
?>