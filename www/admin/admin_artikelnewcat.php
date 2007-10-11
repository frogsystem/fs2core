<?php

if (isset($_POST[catname]))
{
    $_POST[catname] = savesql($_POST[catname]);

    $index = mysql_query("SELECT cat_name FROM ".$global_config_arr[pref]."artikel_cat WHERE cat_name = '$_POST[catname]'", $db);
    $rows = mysql_num_rows($index);

    if ($rows == 0)
    {
        mysql_query("INSERT INTO ".$global_config_arr[pref]."artikel_cat (cat_name) VALUES ('".$_POST[catname]."');", $db);
        systext("Kategorie wurde hinzugefügt");
    }
    else
    {
        systext("Kategorie existiert bereits");
    }
} else {
	echo '
	    <form action="" method="post">
	        <input type="hidden" value="artikelnewcat" name="go">
	        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
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
                    <td align="center" colspan="2">
                        <br><input class="button" type="submit" value="Hinzufügen">
                    </td>
                </tr>
            </table>
        </form>	            
	';
}

?>