<?php

///////////////////////////////////////
//// Kategorie in die DB eintragen ////
///////////////////////////////////////

if (isset($_POST[catname]))
{
    $_POST[catname] = savesql($_POST[catname]);

    settype($_POST[subcatof], 'integer');
    mysql_query("INSERT INTO ".$global_config_arr[pref]."dl_cat (subcat_id, cat_name)
                 VALUES ('".$_POST[subcatof]."',
                         '".$_POST[catname]."');", $db);
    systext("Kategorie wurde hinzugefügt");
}

///////////////////////////////////////
///////// Kategorie Formular //////////
///////////////////////////////////////

else
{
    echo'
                    <form action="" method="post">
                        <input type="hidden" value="dl_newcat" name="go">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
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
    get_dl_categories (&$valid_ids, -1, 1 );

    foreach ($valid_ids as $cat)
    {
        echo'
                                        <option value="'.$cat['cat_id'].'">'.str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;", $cat['level']).$cat['cat_name'].'</option>
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