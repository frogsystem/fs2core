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
        if (!isset($_GET['sort']))
            $_GET['sort'] = 'default';

        $order_name = 'asc'; $order_voters = 'asc'; $order_startdate = 'asc'; $order_enddate = 'asc';
        $arrow_name = ''; $arrow_voters = ''; $arrow_startdate = ''; $arrow_enddate = '';
    
        switch($_GET['sort']) {
                case 'name_desc': {
                        $index = mysql_query("select * from fs_poll order by poll_quest desc", $db);
                        $order_name = 'asc';
                        $arrow_name = '<img src="images/icons/pointer_down.gif" alt="" border="0" title="Absteigend" />';
                        break;
                }
                case 'name_asc': {
                        $index = mysql_query("select * from fs_poll order by poll_quest asc", $db);
                        $order_name = 'desc';
                        $arrow_name = '<img src="images/icons/pointer_up.gif" alt="" border="0" title="Aufsteigend" />';
                        break;
                }
                case 'voters_desc': {
                        $index = mysql_query("select * from fs_poll order by poll_participants desc", $db);
                        $order_voters = 'asc';
                        $arrow_voters = '<img src="images/icons/pointer_down.gif" alt="" border="0" title="Absteigend" />';
                        break;
                }
                case 'voters_asc': {
                        $index = mysql_query("select * from fs_poll order by poll_participants asc", $db);
                        $order_voters = 'desc';
                        $arrow_voters = '<img src="images/icons/pointer_up.gif" alt="" border="0" title="Aufsteigend" />';
                        break;
                }
                case 'startdate_desc': {
                        $index = mysql_query("select * from fs_poll order by poll_start desc", $db);
                        $order_startdate = 'asc';
                        $arrow_startdate = '<img src="images/icons/pointer_down.gif" alt="" border="0" title="Absteigend" />';
                        break;
                }
                case 'startdate_asc': {
                        $index = mysql_query("select * from fs_poll order by poll_start asc", $db);
                        $order_startdate = 'desc';
                        $arrow_startdate = '<img src="images/icons/pointer_up.gif" alt="" border="0" title="Aufsteigend" />';
                        break;
                }
                case 'enddate_desc': {
                        $index = mysql_query("select * from fs_poll order by poll_end desc", $db);
                        $order_enddate = 'asc';
                        $arrow_enddate = '<img src="images/icons/pointer_down.gif" alt="" border="0" title="Absteigend" />';
                        break;
                }
                case 'enddate_asc': {
                        $index = mysql_query("select * from fs_poll order by poll_end asc", $db);
                        $order_enddate = 'desc';
                        $arrow_enddate = '<img src="images/icons/pointer_up.gif" alt="" border="0" title="Aufsteigend" />';
                        break;
                }
                default: {
                        $index = mysql_query("select * from fs_poll order by poll_end desc", $db);
                        $order_enddate = 'asc';
                        $arrow_enddate = '<img src="images/icons/pointer_down.gif" alt="" border="0" title="Absteigend" />';
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
    $template = str_replace("{order_startdate}", $order_startdate, $template);
    $template = str_replace("{order_enddate}", $order_enddate, $template);
    $template = str_replace("{arrow_name}", $arrow_name, $template);
    $template = str_replace("{arrow_voters}", $arrow_voters, $template);
    $template = str_replace("{arrow_startdate}", $arrow_startdate, $template);
    $template = str_replace("{arrow_enddate}", $arrow_enddate, $template);

    unset($list_lines);
}

?>