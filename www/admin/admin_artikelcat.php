<?php

/*********
* Edit Category
*********/
if (isset($_POST[catname]))
{
    if (isset($_POST[delcat]))
    {
        settype($_POST[catid], "integer");
        mysql_query("DELETE FROM ".$global_config_arr[pref]."artikel_cat WHERE cat_id = ".$_POST[catid], $db);
        systext("Die Kategorie wurde gelöscht");
    }
    else
    {
        $_POST[catname] = savesql($_POST[catname]);

        $update = "UPDATE ".$global_config_arr[pref]."artikel_cat
                   SET cat_name = '$_POST[catname]'
                   WHERE cat_id = $_POST[catid]";
        mysql_query($update, $db);
        systext("Die Kategorie wurde editiert");
    }
} elseif (isset($_POST[editcatid])) {
	settype ($_POST[editcatid], 'integer');
	
	$index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."artikel_cat WHERE cat_id = '".$_POST[editcatid]."'", $db);
	$cat_arr = mysql_fetch_assoc($index);
	
	echo '
	    <form action="" method="post">
	        <input type="hidden" value="artikelcat" name="go">
	        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
	        <input type="hidden" value="'.$cat_arr[cat_id].'" name="catid">
	        <table border="0" cellpadding="4" cellspacing="0" width="600">
                <tr>
                    <td class="config" valign="top">
                        Name:<br>
                        <font class="small">Name der neuen Kategorie</font>
                    </td>
                    <td class="config" valign="top">
                        <input class="text" name="catname" size="33" value="'.$cat_arr[cat_name].'" maxlength="100">
                    </td>
                </tr>
                <tr>
                    <td class="config">
                        Kategorie löschen:
                    </td>
                    <td class="config">
                        <input onClick=\'delalert ("delcat", "Soll die Downloadkategorie wirklich gelöscht werden?")\' type="checkbox" name="delcat" id="delcat" value="1">
                    </td>
                </tr>
                <tr>
                    <td align="center" colspan="2">
                        <br><input class="button" type="submit" value="Absenden">
                    </td>
                </tr>
            </table>
        </form>
	';

} else {
	$index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."artikel_cat ORDER BY cat_name");
	$rows = '';
	
	while ($arr = mysql_fetch_assoc($index)) {
		$rows .= '
					<tr>
						<td class="configthin">'.$arr[cat_name].'</td>
						<td class="config"><input type="radio" name="editcatid" value="'.$arr[cat_id].'" /></td>
					</tr>
		';
	}
	
	echo '
	    <form action="" method="post">
	        <input type="hidden" value="artikelcat" name="go" />
	        <input type="hidden" value="'.session_id().'" name="PHPSESSID" />
	        <table border="0" cellpadding="2" cellspacing="0" width="600">	
                <tr>
                    <td class="config" width="40%">
                        Name
                    </td>
                    <td class="config" width="40%">
                        bearbeiten
                    </td>
				</tr>
				'.$rows.'
                <tr>
                    <td colspan="2">
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <input class="button" type="submit" value="editieren">
                    </td>
                </tr>				
			</table>
		</form>
	';
}

?>