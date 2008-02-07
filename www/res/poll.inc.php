<?php
////////////////////////////
/// Konfiguration laden ////
////////////////////////////
$index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."poll_config", $db);
$config_arr = mysql_fetch_assoc($index);


///////////////////////
/// Load Poll Data ////
///////////////////////
$date = date("U");
$index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."poll WHERE poll_end > $date AND poll_start < $date ORDER BY poll_start DESC LIMIT 0,1 ", $db);
$poll_arr = mysql_fetch_assoc($index);


//////////////////////////
//// Display Poll     ////
//////////////////////////

if (!$_POST[pollid] AND !checkVotedPoll($poll_arr['poll_id']) AND mysql_num_rows($index) > 0)
{


            $checked = "";
            if (checkVotedPoll($poll_arr['poll_id'])) {
                $button_state = "disabled";
            } else {
                $button_state = "";
            }


            $index2 = mysql_query("select * from ".$global_config_arr[pref]."poll_answers where poll_id = $poll_arr[poll_id] ORDER BY answer_id ASC", $db);
            while ($answer_arr = mysql_fetch_assoc($index2))
            {
                if ($poll_arr[poll_type] == 0)
                {
                    $poll_arr[poll_type2] = "radio";
                    $poll_arr[poll_type3] = "";
                }
                if ($poll_arr[poll_type] == 1)
                {
                    $poll_arr[poll_type2] = "checkbox";
                    $poll_arr[poll_type3] = "[]";
                }
                $index3 = mysql_query("select poll_line from ".$global_config_arr[pref]."template where id = '$global_config_arr[design]'", $db);
                $template = stripslashes(mysql_result($index3, 0, "poll_line"));
                $template = str_replace("{answer_id}", $answer_arr[answer_id], $template);
                $template = str_replace("{answer}", $answer_arr[answer], $template);
                $template = str_replace("{type}", $poll_arr[poll_type2], $template);
                $template = str_replace("{multiple}", $poll_arr[poll_type3], $template);

                $antworten .= $template;
            }
            unset($answer_arr);

            $index2 = mysql_query("select poll_body from ".$global_config_arr[pref]."template where id = '$global_config_arr[design]'", $db);
            $template = stripslashes(mysql_result($index2, 0, "poll_body"));
            $template = str_replace("{poll_id}", $poll_arr[poll_id], $template);
            $template = str_replace("{question}", $poll_arr[poll_quest], $template);
            $template = str_replace("{answers}", $antworten, $template);
            $template = str_replace("{button_state}", $button_state, $template);

        unset($poll_arr);
}


//////////////////////////
//// View Result      ////
//////////////////////////

elseif ($_POST[pollid] OR checkVotedPoll($poll_arr['poll_id']))
{
    if (!$_POST[pollid]) {
        $_POST[pollid] = $poll_arr['poll_id'];
    }

    $voted = checkVotedPoll($_POST['pollid']);
                
    settype($_POST[pollid], 'integer');
    $voter_ip = $_SERVER['REMOTE_ADDR'];

    $date = date("U");
    $index = mysql_query("select * from ".$global_config_arr[pref]."poll where poll_id = $_POST[pollid]", $db);
    $poll_arr = mysql_fetch_assoc($index);

    if ($poll_arr[poll_end] > $date && $voted == false)
    {
        if ($poll_arr[poll_type] == 0)
        {
            settype($_POST[answer], 'integer');
            mysql_query("update ".$global_config_arr[pref]."poll_answers set answer_count = answer_count + 1 where answer_id = '$_POST[answer]'", $db);
            if ($_POST[answer] != 0) {
                registerVoter($_POST['pollid'], $voter_ip); //Register Voter if voted
                mysql_query("update ".$global_config_arr[pref]."poll set poll_participants = poll_participants + 1 where poll_id = '$_POST[pollid]'", $db);
            }
        }
        elseif (count($_POST[answer]) > 1)
        {
            foreach ($_POST[answer] as $id)
            {
                settype($id, 'integer');
                mysql_query("update ".$global_config_arr[pref]."poll_answers set answer_count = answer_count + 1 where answer_id = '$id'", $db);
            }
            registerVoter($_POST['pollid'], $voter_ip); //Register Voter if voted
            mysql_query("update ".$global_config_arr[pref]."poll set poll_participants = poll_participants + 1 where poll_id = '$_POST[pollid]'", $db);
        }
        elseif (is_array($_POST[answer]))
        {
            reset($_POST[answer]);
            $id = each($_POST[answer]);
            $id = $id[value];
            settype($id, 'integer');
            mysql_query("update ".$global_config_arr[pref]."poll_answers set answer_count = answer_count + 1 where answer_id = '$id'", $db);
            if (count($_POST[answer]) != 0) {
                registerVoter($_POST['pollid'], $voter_ip); //Register Voter if voted
                mysql_query("update ".$global_config_arr[pref]."poll set poll_participants = poll_participants + 1 where poll_id = '$_POST[pollid]'", $db);
            }
        }
    }

    $index = mysql_query("select poll_participants from ".$global_config_arr[pref]."poll where poll_id = $_POST[pollid]", $db);
    $poll_arr[poll_participants] = mysql_result($index, 0, "poll_participants");

    $index = mysql_query("select * from ".$global_config_arr[pref]."poll_answers where poll_id = $_POST[pollid]", $db);
    while ($answer_arr = mysql_fetch_assoc($index))
    {
        $all_votes += $answer_arr[answer_count];
    }

    $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."poll_answers WHERE poll_id = $_POST[pollid] ORDER BY answer_id ASC", $db);
    while ($answer_arr = mysql_fetch_assoc($index))
    {
        if ($all_votes != 0)
        {
            $answer_arr[percentage] = round($answer_arr[answer_count] / $all_votes * 100, 1);
            $answer_arr[bar_width] = round($answer_arr[answer_count] / $all_votes * $config_arr['answerbar_width'] );
            if ( $config_arr['answerbar_type'] == 1 ) {
                $answer_arr[bar_width] .= "%";
			} else {
                $answer_arr[bar_width] .= "px";
			}
        }
        else
        {
            $answer_arr[percentage] = 0;
            $answer_arr[bar_width] = "1px";
        }
        $index2 = mysql_query("select poll_result_line from ".$global_config_arr[pref]."template where id = '$global_config_arr[design]'", $db);
        $template = stripslashes(mysql_result($index2, 0, "poll_result_line"));
        $template = str_replace("{answer}", $answer_arr[answer], $template);
        $template = str_replace("{votes}", $answer_arr[answer_count], $template);
        $template = str_replace("{percentage}", $answer_arr[percentage]."%", $template);
        $template = str_replace("{bar_width}", $answer_arr[bar_width], $template);

        $antworten .= $template;
    }
    unset($answer_arr);

    $index = mysql_query("select poll_result from ".$global_config_arr[pref]."template where id = '$global_config_arr[design]'", $db);
    $template = stripslashes(mysql_result($index, 0, "poll_result"));
    $template = str_replace("{question}", $poll_arr[poll_quest], $template);
    $template = str_replace("{answers}", $antworten, $template);
    $template = str_replace("{all_votes}", $all_votes, $template);
    $template = str_replace("{participants}", $poll_arr[poll_participants], $template);

    unset($poll_arr);
}


//////////////////////////
//// No active poll   ////
//////////////////////////

else
{
    $index = mysql_query("select poll_no_poll from ".$global_config_arr[pref]."template where id = '$global_config_arr[design]'", $db);
    $template = stripslashes(mysql_result($index, 0, "poll_no_poll"));

    unset($poll_arr);
}
?>