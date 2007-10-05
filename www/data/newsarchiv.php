<?php

////////////////////////////////
////// Suchfeld erzeugen ///////
////////////////////////////////

$index = mysql_query("select news_search_form from ".$global_config_arr[pref]."template where id = '$global_config_arr[design]'", $db);
$template = stripslashes(mysql_result($index, 0, "news_search_form"));

$index = mysql_query("select news_date from ".$global_config_arr[pref]."news order by news_date asc LIMIT 0,1", $db);
if (mysql_num_rows($index) == 0) {
    $years = date("Y");
    $years = '<option value="'.$years.'">'.$years.'</option>';
} else {
    $years_arr = mysql_fetch_assoc($index);
    for ($years_arr[i]=date("Y",$years_arr[news_date]);$years_arr[i]<=date("Y");$years_arr[i]++) {
        $years .= '<option value="'.$years_arr[i].'">'.$years_arr[i].'</option>';
    }
}
$template = str_replace("{years}", $years, $template);

$searchform_template = $template;
unset($template);
////////////////////////////////
/// News nach Datum anzeigen ///
////////////////////////////////

if ($_POST[jahr] && $_POST[monat])
{
    settype($_POST[jahr], 'integer');
    settype($_POST[monat], 'integer');

    $starttime = mktime(0, 0, 0, $_POST[monat], 0, $_POST[jahr]);
    $endtime = mktime(0, 0, 0, $_POST[monat]+1, 0, $_POST[jahr]);

    // News Konfiguration lesen
    $index = mysql_query("select * from ".$global_config_arr[pref]."news_config", $db);
    $config_arr = mysql_fetch_assoc($index);

    // News lesen und ausgeben
    $index = mysql_query("select * from ".$global_config_arr[pref]."news
                          where news_date > $starttime and
                                news_date < $endtime
                          order by news_date desc", $db);
    if (mysql_num_rows($index) > 0)  // News vorhanden?
    {
        while ($news_arr = mysql_fetch_assoc($index))
        {
            $news_template .= display_news($news_arr, $config_arr[html_code], $config_arr[fs_code], $config_arr[para_handling]);
        }
        unset($news_arr);
    }
    else
    {
        $news_template = sys_message($phrases[sysmessage], $phrases[no_result_time]);
    }
}

////////////////////////////////
// News nach Keyword anzeigen //
////////////////////////////////

if ($_POST[keyword])
{
    $_POST[keyword] = savesql($_POST[keyword]);

    // News Konfiguration lesen
    $index = mysql_query("select * from ".$global_config_arr[pref]."news_config", $db);
    $config_arr = mysql_fetch_assoc($index);

    // News lesen und ausgeben
    $index = mysql_query("select * from ".$global_config_arr[pref]."news
                          where news_text like '%$_POST[keyword]%'
                          order by news_date desc", $db);
    if (mysql_num_rows($index) > 0)  // News vorhanden?
    {
        while ($news_arr = mysql_fetch_assoc($index))
        {
            $news_template .= display_news($news_arr, $config_arr[html_code], $config_arr[fs_code], $config_arr[para_handling]);
        }
        unset($news_arr);
    }
    else
    {
        $news_template = sys_message($phrases[sysmessage], $phrases[no_result_word]);
    }
}

$template = $searchform_template.$news_template;

?>