<?php

///////////////////////////////////////
//// Kategorie in die DB eintragen ////
///////////////////////////////////////

if (!empty($_POST[catname]))
{
    $_POST[catname] = savesql($_POST[catname]);

    settype($_POST[subcatof], 'integer');
    mysql_query("INSERT INTO ".$global_config_arr[pref]."dl_cat (subcat_id, cat_name)
                 VALUES ('".$_POST[subcatof]."',
                         '".$_POST[catname]."');", $db);
    systext("Kategorie wurde hinzugefügt");
    
    unset($_POST);
}

///////////////////////////////////////
///////// Kategorie Formular //////////
///////////////////////////////////////

if(true)
{
    if(isset($_POST['sended'])) {
        echo get_systext($TEXT['admin']->get("changes_not_saved")."<br>".$TEXT['admin']->get("form_not_filled"), $TEXT['admin']->get("error"), "red", $TEXT['admin']->get("icon_save_error"));
    }       
    
    echo'
                    <form action="" method="post">
                        <input type="hidden" value="dl_newcat" name="go">
                        <input type="hidden" value="add" name="sended">
                        <table class="content" cellpadding="3" cellspacing="0">
                            <tr><td colspan="2"><h3>Kategorie hinzufügen</h3><hr></td></tr>
                            <tr>
                                <td class="config" valign="top">
                                    Name:<br>
                                    <font class="small">Name der neuen Kategorie</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" name="catname" size="33" maxlength="100">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Subkategorie von:<br>
                                    <font class="small">Macht diese Kategorie zu einer Unterkategorie einer anderen</font>
                                </td>
                                <td class="config" valign="top">
                                    <select name="subcatof">
                                        <option value="0">Keine Subkategorie</option>
                                        <option value="0">--------------------------------------</option>
    ';

    $valid_ids = array();
    get_dl_categories ($valid_ids, -1);

    foreach ($valid_ids as $cat)
    {
        echo'
                                        <option value="'.$cat[cat_id].'">'.str_repeat("&nbsp;&nbsp;&nbsp;", $cat['level']).$cat[cat_name].'</option>
        ';
    }
    echo'
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" colspan="2">
                                    <br><input class="button" type="submit" value="Hinzufügen">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>
