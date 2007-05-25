<?php

//////////////////////////
//// DB Aktualisieren ////
//////////////////////////

if ($_POST[tag] && $_POST[monat] && $_POST[jahr])
{

    if(!isset($_POST[delit]))
    {
        $datum = mktime(0, 0, 0, $_POST[monat], $_POST[tag], $_POST[jahr]);
        $_POST[url] = savesql($_POST[url]);
        $index = mysql_query("SELECT prereinterviews_url FROM fsplus_prereinterviews WHERE prereinterviews_url = '$_POST[url]'");
        if ((mysql_num_rows($index) == 0) || ($_POST[oldurl] == $_POST[url]))
        {
			$_POST[titel] = savesql($_POST[titel]);
    		$_POST[oldurl] = savesql($_POST[oldurl]);
    		$_POST[datum] = savesql($_POST[datum]);
    		$_POST[text] = savesql($_POST[text]);
            $_POST[text] = ereg_replace ("&lt;textarea&gt;", "<textarea>", $_POST[text]); 
            $_POST[text] = ereg_replace ("&lt;/textarea&gt;", "</textarea>", $_POST[text]);
    		$_POST[lang] = savesql($_POST[lang]);
    		$_POST[spiel] = savesql($_POST[spiel]);
    		$_POST[cat] = savesql($_POST[cat]);
    		$_POST[wertung] = savesql($_POST[wertung]);

            $update = "UPDATE fsplus_prereinterviews
                       SET prereinterviews_titel  = '".$_POST[titel]."',
                           prereinterviews_url    = '".$_POST[url]."',
                           prereinterviews_datum  = '$datum',
                           prereinterviews_text   = '".$_POST[text]."',
                           prereinterviews_lang   = '".$_POST[lang]."',
                           prereinterviews_spiel  = '".$_POST[spiel]."',
                           prereinterviews_cat    = '".$_POST[cat]."',
                           prereinterviews_wertung= '".$_POST[wertung]."'
                       WHERE prereinterviews_url = '".$_POST[oldurl]."'";

            mysql_query($update, $db);
            systext("Pre-, Re-, Interview is altered");
        }
        else
        {
            systext("Pre-, Re-, Interview is not altered");
        }
    }
    else
    {
        mysql_query("DELETE FROM fsplus_prereinterviews WHERE prereinterviews_url = '$_POST[oldurl]'", $db);
        systext("Tee Pre-, Re-, Interview is deleted");
    }
}

//////////////////////////
//// Update Formular /////
//////////////////////////

elseif (isset($_POST[prereinterviewsurl]))
{
    $_POST[prereinterviewsurl] = savesql($_POST[prereinterviewsurl]);

    // Pre-, Re-, Interview aus der DB holen
    $index = mysql_query("SELECT * FROM fsplus_prereinterviews WHERE prereinterviews_url = '$_POST[prereinterviewsurl]'", $db);
    $prereinterviews_arr = mysql_fetch_assoc($index);
    $prereinterviews_arr[prereinterviews_text] = ereg_replace ("<textarea>", "&lt;textarea&gt;", $prereinterviews_arr[prereinterviews_text]); 
    $prereinterviews_arr[prereinterviews_text] = ereg_replace ("</textarea>", "&lt;/textarea&gt;", $prereinterviews_arr[prereinterviews_text]); 

    $prereinterviews_arr[prereinterviews_text] = stripslashes($prereinterviews_arr[prereinterviews_text]);
	
	// Datum erzeugen
    if ($prereinterviews_arr[prereinterviews_datum] != 0)
    {
        $nowtag = date("d", $prereinterviews_arr[prereinterviews_datum]);
        $nowmonat = date("m", $prereinterviews_arr[prereinterviews_datum]);
        $nowjahr = date("Y", $prereinterviews_arr[prereinterviews_datum]);
    }

    echo'
                    <form id="send1" action="'.$PHP_SELF.'" method="post" target="_self">
                        <input type="hidden" value="pre-re-interviewedit" name="go">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <input type="hidden" value="'.$_POST[prereinterviewsurl].'" name="oldurl">
						
						<table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top">
                                    Title:<br>
                                    <font class="small">Name of the website. It is also in the hotlink (right menu).</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" value="'.$prereinterviews_arr[prereinterviews_titel].'" name="titel" size="51" maxlength="150">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    URL:<br>
                                    <font class="small">Link to article.</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" value="'.$_POST[prereinterviewsurl].'" name="url" size="51" maxlength="150">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Datum:<br>
                                    <font class="small">Date of the original publication. Important for the sorting. (DD MM YYYY)</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" value="'.$nowtag.'" size="2" name="tag" maxlength="2">
                                    <input class="text" value="'.$nowmonat.'" size="2" name="monat" maxlength="2">
                                    <input class="text" value="'.$nowjahr.'" size="4" name="jahr" maxlength="4">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Text:<br>
                                    <font class="small">Please copy the first few sentences of the article as extract.</font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea class="text" name="text" rows="7" cols="66">'.$prereinterviews_arr[prereinterviews_text].'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    In which language:<br>
                                    <font class="small">German or English</font>
                                </td>
                                <td class="config" valign="top">
		';			
	if ($prereinterviews_arr[prereinterviews_lang] == 1)
		echo' <table width="100%"><tr><td width="50%"><input type="radio" name="lang" value="1" checked="checked"> German</td>
									  <td width="50%"><input type="radio" name="lang" value="2"> English</td></tr></table>';
	elseif ($prereinterviews_arr[prereinterviews_lang] == 2)
		echo' <table width="100%"><tr><td width="50%"><input type="radio" name="lang" value="1"> German</td>
									  <td width="50%"><input type="radio" name="lang" value="2" checked="checked"> English</td></tr></table>';
	else
		echo' <table width="100%"><tr><td width="50%"><input type="radio" name="lang" value="1"> German</td>
									  <td width="50%"><input type="radio" name="lang" value="2"> English</td></tr></table>';		
	echo'                       </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    For which game:<br>
                                    <font class="small">Gothic, Gothic II or 3 or an addon.</font>
                                </td>
                                <td class="config" valign="top">
		';			
	if ($prereinterviews_arr[prereinterviews_spiel] == 1)
		echo' <table width="100%"><tr><td width="50%"><input type="radio" name="spiel" value="1" checked="checked"> Gothic</td>
									  <td width="50%"><input type="radio" name="spiel" value="4"> Gothic 3</td></tr>
								  <tr><td width="50%"><input type="radio" name="spiel" value="2"> Gothic II</td>
									  <td width="50%"></td></tr>
								  <tr><td width="50%"><input type="radio" name="spiel" value="3"> G II Gold & NotR</td>
									  <td width="50%"></td></tr></table>';
	elseif ($prereinterviews_arr[prereinterviews_spiel] == 2)
		echo' <table width="100%"><tr><td width="50%"><input type="radio" name="spiel" value="1"> Gothic</td>
									  <td width="50%"><input type="radio" name="spiel" value="4"> Gothic 3</td></tr>
								  <tr><td width="50%"><input type="radio" name="spiel" value="2" checked="checked"> Gothic II</td>
									  <td width="50%"></td></tr>
								  <tr><td width="50%"><input type="radio" name="spiel" value="3"> G II Gold & NotR</td>
									  <td width="50%"></td></tr></table>';	
	elseif ($prereinterviews_arr[prereinterviews_spiel] == 3)
		echo' <table width="100%"><tr><td width="50%"><input type="radio" name="spiel" value="1"> Gothic</td>
									  <td width="50%"><input type="radio" name="spiel" value="4"> Gothic 3</td></tr>
								  <tr><td width="50%"><input type="radio" name="spiel" value="2"> Gothic II</td>
									  <td width="50%"></td></tr>
								  <tr><td width="50%"><input type="radio" name="spiel" value="3" checked="checked"> G II Gold & NotR</td>
									  <td width="50%"></td></tr></table>';
	elseif ($prereinterviews_arr[prereinterviews_spiel] == 4)
		echo' <table width="100%"><tr><td width="50%"><input type="radio" name="spiel" value="1"> Gothic</td>
									  <td width="50%"><input type="radio" name="spiel" value="4" checked="checked"> Gothic 3</td></tr>
								  <tr><td width="50%"><input type="radio" name="spiel" value="2"> Gothic II</td>
									  <td width="50%"></td></tr>
								  <tr><td width="50%"><input type="radio" name="spiel" value="3"> G II Gold & NotR</td>
									  <td width="50%"></td></tr></table>';
	else
		echo' <table width="100%"><tr><td width="50%"><input type="radio" name="spiel" value="1"> Gothic</td>
									  <td width="50%"><input type="radio" name="spiel" value="4"> Gothic 3</td></tr>
								  <tr><td width="50%"><input type="radio" name="spiel" value="2"> Gothic II</td>
									  <td width="50%"></td></tr>
								  <tr><td width="50%"><input type="radio" name="spiel" value="3"> G II Gold & NotR</td>
									  <td width="50%"></td></tr></table>';	
	echo'						</td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Welche Kategorie:<br>
                                    <font class="small">Preview, review, interview or an article from the own team.</font>
                                </td>
                                <td class="config" valign="top">
		';
	if ($prereinterviews_arr[prereinterviews_cat] == 1)
		    echo'               <table width="100%"><tr><td><input type="radio" name="cat" value="1" checked="checked"> Preview</td></tr>
									                <tr><td><input type="radio" name="cat" value="2"> Review</td></tr>
													<tr><td><input type="radio" name="cat" value="3"> Interview</td></tr>
													<tr><td><input type="radio" name="cat" value="4"> Own article</td></tr></table>';
	elseif ($prereinterviews_arr[prereinterviews_cat] == 2)
		    echo'               <table width="100%"><tr><td><input type="radio" name="cat" value="1"> Preview</td></tr>
									                <tr><td><input type="radio" name="cat" value="2" checked="checked"> Review</td></tr>
													<tr><td><input type="radio" name="cat" value="3"> Interview</td></tr>
													<tr><td><input type="radio" name="cat" value="4"> Own article</td></tr></table>';
	elseif ($prereinterviews_arr[prereinterviews_cat] == 3)
		    echo'               <table width="100%"><tr><td><input type="radio" name="cat" value="1"> Preview</td></tr>
									                <tr><td><input type="radio" name="cat" value="2"> Review</td></tr>
													<tr><td><input type="radio" name="cat" value="3" checked="checked"> Interview</td></tr>
													<tr><td><input type="radio" name="cat" value="4"> Own article</td></tr></table>';
	elseif ($prereinterviews_arr[prereinterviews_cat] == 4)
		    echo'               <table width="100%"><tr><td><input type="radio" name="cat" value="1"> Preview</td></tr>
									                <tr><td><input type="radio" name="cat" value="2"> Review</td></tr>
													<tr><td><input type="radio" name="cat" value="3"> Interview</td></tr>
													<tr><td><input type="radio" name="cat" value="4" checked="checked"> Own article</td></tr></table>';
	else
		    echo'               <table width="100%"><tr><td><input type="radio" name="cat" value="1"> Preview</td></tr>
									                <tr><td><input type="radio" name="cat" value="2"> Review</td></tr>
													<tr><td><input type="radio" name="cat" value="3"> Interview</td></tr>
													<tr><td><input type="radio" name="cat" value="4"> Own article</td></tr></table>';
     echo'                      </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Rating:<br>
                                    <font class="small">Only for reviews!</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" value="'.$prereinterviews_arr[prereinterviews_wertung].'" name="wertung" size="51" maxlength="150">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    Pre-, Re-, Interview delete:
                                </td>
                                <td class="config">
                                    <input onClick="alert(this.value)" type="checkbox" name="delit" value="Sure?">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input class="button" type="button" value="Preview" onClick="javascript:open(\'about:blank\',\'prev\',\'width=700,height=710,screenX=0,screenY=0,scrollbars=yes\'); document.getElementById(\'send1\').action=\'admin_artikelprev.php\'; document.getElementById(\'send1\').target=\'prev\'; document.getElementById(\'send1\').submit();">
                                    <input class="button" type="button" value="Send" onClick="javascript:document.getElementById(\'send1\').target=\'_self\'; document.getElementById(\'send1\').action=\''.$PHP_SELF.'\'; document.getElementById(\'send1\').submit();">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}

///////////////////////////////////////
/// Pre-, Re-, Interview ausflisten ///
///////////////////////////////////////

else
{
    if (isset($_POST[prereinterviewcatid]))
    {
        settype($_POST[prereinterviewcatid], 'integer');
        $wherecat = "WHERE prereinterviews_cat = " . $_POST[prereinterviewcatid];
    }

    echo'
                    <form action="'.$PHP_SELF.'" method="post">
                        <input type="hidden" value="pre-re-interviewedit" name="go">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="2" cellspacing="0" width="600">
                            <tr>
                                <td class="config" width="40%">
                                    Only files from Category:
                                    <select name="prereinterviewcatid" size="1">
									<option value="1">Previews</option>
									<option value="2">Reviews</option>
									<option value="3">Interviews</option>
									<option value="4">Own Article</option>
									</select>
                                    <input class="button" type="submit" value="Show">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';

////////////////////////////////////////
//// Pre-, Re-, Interview auswählen ////
////////////////////////////////////////

    if (isset($_POST[prereinterviewcatid]))
    {
    echo'
                    <form action="'.$PHP_SELF.'" method="post">
                        <input type="hidden" value="pre-re-interviewedit" name="go">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="2" cellspacing="0" width="600">
                            <tr>
                                <td class="config" width="30%">
                                    Title
                                </td>
                                <td class="config" width="30%">
                                    Game
                                </td>
                                <td class="config" width="20%">
                                    Date
                                </td>
                                <td class="config" width="20%">
                                    edit
                                </td>
                            </tr>
    ';
    $index = mysql_query("SELECT prereinterviews_titel, prereinterviews_datum, prereinterviews_url, prereinterviews_spiel FROM fsplus_prereinterviews $wherecat ORDER BY prereinterviews_datum", $db);
    while ($prereinterviews_arr = mysql_fetch_assoc($index))
    {
        $nowtag = date("d", $prereinterviews_arr[prereinterviews_datum]);
        $nowmonat = date("m", $prereinterviews_arr[prereinterviews_datum]);
        $nowjahr = date("Y", $prereinterviews_arr[prereinterviews_datum]);

		switch ($prereinterviews_arr[prereinterviews_spiel])
		{
			case 1:
				$spiel = "Gothic";
				break;
			case 2:
				$spiel = "Gothic II";
				break;
			case 3:
				$spiel = "G II Gold & NotR";
				break;
			case 4:
				$spiel = "Gothic 3";
				break;
		}			
			
        echo'
                            <tr>
                                <td class="configthin">
                                    '.$prereinterviews_arr[prereinterviews_titel].'
                                </td>
                                <td class="configthin">
                                    '.$spiel.'
                                </td>
                                <td class="configthin">
                                    '.$nowtag.'.'.$nowmonat.'.'.$nowjahr.'
                                </td>
                                <td class="config">
                                    <input type="radio" name="prereinterviewsurl" value="'.$prereinterviews_arr[prereinterviews_url].'">
                                </td>
                            </tr>
        ';
    }
    echo'
                            <tr>
                                <td colspan="3">
                                    &nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" align="center">
                                    <input class="button" type="submit" value="edit">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
	}
}
?>