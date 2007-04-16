<?php

//////////////////////////////////////////////////
//// Neues Pre-, Re oder Interview einstellen ////
//////////////////////////////////////////////////

if ($_POST[titel] && $_POST[url] && $_POST[tag] && $_POST[monat] && $_POST[jahr])
{
	$datum = mktime(0, 0, 0, $_POST[monat], $_POST[tag], $_POST[jahr]);

    $_POST[titel] = savesql($_POST[titel]);
    $_POST[url] = savesql($_POST[url]);
    $_POST[datum] = savesql($_POST[datum]);
    $_POST[text] = savesql($_POST[text]);
    $_POST[lang] = savesql($_POST[lang]);
    $_POST[spiel] = savesql($_POST[spiel]);
    $_POST[cat] = savesql($_POST[cat]);
    $_POST[wertung] = savesql($_POST[wertung]);
    mysql_query("INSERT INTO fsplus_prereinterviews (prereinterviews_titel, prereinterviews_url, prereinterviews_datum, prereinterviews_text, prereinterviews_lang, prereinterviews_spiel, prereinterviews_cat, prereinterviews_wertung)
                 VALUES ('$_POST[titel]',
                         '$_POST[url]',
                         '$datum',
                         '$_POST[text]',
                         '$_POST[lang]',
                         '$_POST[spiel]',
                         '$_POST[cat]',
                         '$_POST[wertung]');", $db);
    $index = mysql_query("SELECT prereinterviews_id FROM fsplus_prereinterviews WHERE prereinterviews_titel = '".$_POST[titel]."'", $db);
    $id = mysql_result($index, 0, "prereinterviews_id");
	
	systext("Pre-, Re- oder Interview wurde gespeichert.");

}

////////////////////////////////////////////
///// Pre-, Re oder Interview Formular /////
////////////////////////////////////////////

else
{
    echo'
                    <form action="'.$PHP_SELF.'" enctype="multipart/form-data" method="post">
                        <input type="hidden" value="pre-re-interviewadd" name="go">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top">
                                    Title:<br>
                                    <font class="small">Name of the website. It is also in the hotlink (right menu).</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" name="titel" size="51" maxlength="150">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    URL:<br>
                                    <font class="small">Link to article.</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" name="url" size="51" maxlength="150">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Datum:<br>
                                    <font class="small">Date of the original publication. Important for the sorting. (DD MM YYYY)</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="2" name="tag" maxlength="2">
                                    <input class="text" size="2" name="monat" maxlength="2">
                                    <input class="text" size="4" name="jahr" maxlength="4">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Text:<br>
                                    <font class="small">Please copy the first few sentences of the article as extract.</font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea class="text" name="text" rows="7" cols="66"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    In which language:<br>
                                    <font class="small">German or English</font>
                                </td>
                                <td class="config" valign="top">
                                    <table width="100%"><tr><td width="50%"><input type="radio" name="lang" value="1"> German</td>
									                        <td width="50%"><input type="radio" name="lang" value="2"> English</td></tr></table>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    For which game:<br>
                                    <font class="small">Gothic, Gothic II or 3 or an addon.</font>
                                </td>
                                <td class="config" valign="top">
                                    <table width="100%"><tr><td width="50%"><input type="radio" name="spiel" value="1"> Gothic</td>
									                        <td width="50%"><input type="radio" name="spiel" value="4"> Gothic 3</td></tr>
														<tr><td width="50%"><input type="radio" name="spiel" value="2"> Gothic II</td>
									                        <td width="50%"></td></tr>
														<tr><td width="50%"><input type="radio" name="spiel" value="3"> G II Gold & NotR</td>
									                        <td width="50%"></td></tr></table>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Which Category:<br>
                                    <font class="small">Preview, review, interview or an article from the own team.</font>
                                </td>
                                <td class="config" valign="top">
                                    <table width="100%"><tr><td><input type="radio" name="cat" value="1"> Preview</td></tr>
									                    <tr><td><input type="radio" name="cat" value="2"> Review</td></tr>
														<tr><td><input type="radio" name="cat" value="3"> Interview</td></tr>
														<tr><td><input type="radio" name="cat" value="4"> Own Article</td></tr></table>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Rating:<br>
                                    <font class="small">Only for reviews!</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" name="wertung" size="51" maxlength="150">
                                </td>
                            </tr>
                            <tr>
                                <td align="center" colspan="2">
                                    <input class="button" type="submit" value="Add">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>