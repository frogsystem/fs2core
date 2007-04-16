<?php

////////////////////////////
///// Umfrage anzeigen /////
////////////////////////////

if ($_GET[pollid])
{
    settype($_GET[pollid], 'integer');
    $index = mysql_query("select * from fs_poll where poll_id = $_GET[pollid]", $db);
    $poll_arr = mysql_fetch_assoc($index);

    $poll_arr[poll_start] = date("d.m.Y" , $poll_arr[poll_start]);
    $poll_arr[poll_end] = date("d.m.Y" , $poll_arr[poll_end]);

    if ($poll_arr[poll_type] == 1)
    {
        $poll_arr[poll_type] = $phrases[multiple_choise];
    }
    else
    {
        $poll_arr[poll_type] = $phrases[single_choice];
    }

    // Antworten auswerten
    $index = mysql_query("select * from fs_poll_answers where poll_id = $_GET[pollid]", $db);
    while($answer_arr = mysql_fetch_assoc($index))
    {
        $stimmen_gesamt += $answer_arr[answer_count];
    }

    //Prozentzahlen errechnen und template generieren
    $index = mysql_query("select * from fs_poll_answers where poll_id = $_GET[pollid]", $db);
    while($answer_arr = mysql_fetch_assoc($index))
    {
        if ($stimmen_gesamt != 0)
        {
            $answer_arr[prozent] = $answer_arr[answer_count] / $stimmen_gesamt * 100;
            $answer_arr[balken] = round($answer_arr[prozent] * 2);
        }
        else
        {
            $answer_arr[prozent] = 0;
            $answer_arr[balken] = 1;
        }

        $index2 = mysql_query("select poll_main_line from fs_template where id = '$global_config_arr[design]'", $db);
        $template = stripslashes(mysql_result($index2, 0, "poll_main_line"));
        $template = str_replace("{antwort}", $answer_arr[answer], $template); 
        $template = str_replace("{stimmen}", $answer_arr[answer_count], $template); 
        $template = str_replace("{prozent}", $answer_arr[prozent]."%", $template); 
        $template = str_replace("{balken_breite}", $answer_arr[balken], $template); 

        $antworten .= $template;
    }
    unset($answer_arr);

    $index = mysql_query("select poll_main_body from fs_template where id = '$global_config_arr[design]'", $db);
    $template = stripslashes(mysql_result($index, 0, "poll_main_body"));
    $template = str_replace("{frage}", $poll_arr[poll_quest], $template); 
    $template = str_replace("{antworten}", $antworten, $template); 
    $template = str_replace("{typ}", $poll_arr[poll_type], $template); 
    $template = str_replace("{stimmen}", $stimmen_gesamt, $template);
    $template = str_replace("{participants}", $poll_arr[poll_participants], $template);
    $template = str_replace("{start_datum}", $poll_arr[poll_start], $template); 
    $template = str_replace("{end_datum}", $poll_arr[poll_end], $template);

    unset($antworten);
}

////////////////////////////
//// Umfragen auflisten ////
////////////////////////////

else
{
	if (!isset($_GET['orderby']))
    	$_GET['orderby'] = 'default';

    $order_name = 'desc'; $order_voters = 'desc'; $order_date = 'desc';
    
	switch($_GET['orderby']) {
		case 'name_desc': {
			$index = mysql_query("select * from fs_poll order by poll_quest desc", $db);
			$order_name = 'asc';
			break;
		}
		case 'name_asc': {
			$index = mysql_query("select * from fs_poll order by poll_quest asc", $db);
			$order_name = 'desc';
			break;
		}
		case 'voters_desc': {
			$index = mysql_query("select * from fs_poll order by poll_participants desc", $db);
			$order_voters = 'asc';
			break;
		}
		case 'voters_asc': {
			$index = mysql_query("select * from fs_poll order by poll_participants asc", $db);
			$order_voters = 'desc';
			break;
		}
		case 'date_desc': {
			$index = mysql_query("select * from fs_poll order by poll_end desc", $db);
			$order_date = 'asc';
			break;
		}
		case 'date_asc': {
			$index = mysql_query("select * from fs_poll order by poll_end asc", $db);
			$order_date = 'desc';
			break;
		}
		default: {
			$index = mysql_query("select * from fs_poll order by poll_end desc", $db);
			$order_date = 'desc';
			break;
		}
    }
    
    while ($poll_arr = mysql_fetch_assoc($index))
    {
        $poll_arr[poll_url] = "?go=pollarchiv&pollid=" . $poll_arr[poll_id];
        $poll_arr[poll_start] = date("d.m.Y" , $poll_arr[poll_start]);
        $poll_arr[poll_end] = date("d.m.Y" , $poll_arr[poll_end]);

        $index2 = mysql_query("select poll_list_line from fs_template where id = '$global_config_arr[design]'", $db);
        $template = stripslashes(mysql_result($index2, 0, "poll_list_line"));
        $template = str_replace("{frage}", $poll_arr[poll_quest], $template); 
        $template = str_replace("{url}", $poll_arr[poll_url], $template); 
        $template = str_replace("{start_datum}", $poll_arr[poll_start], $template); 
        $template = str_replace("{end_datum}", $poll_arr[poll_end], $template); 
        $template = str_replace("{voters}", $poll_arr['poll_participants'], $template);

        $list_lines .= $template;
    }
    unset($poll_arr);

    $index = mysql_query("select poll_list from fs_template where id = '$global_config_arr[design]'", $db);
    $template = stripslashes(mysql_result($index, 0, "poll_list"));
    $template = str_replace("{umfragen}", $list_lines, $template);
    $template = str_replace("{order_name}", $order_name, $template);
    $template = str_replace("{order_voters}", $order_voters, $template);
    $template = str_replace("{order_date}", $order_date, $template);

    unset($list_lines);
}

?>