<?php
////////////////////////////
/// Konfiguration laden ////
////////////////////////////
$index = mysql_query("SELECT * FROM ".$global_config_arr['pref']."poll_config", $db);
$config_arr = mysql_fetch_assoc($index);


///////////////////////
/// Load Poll Data ////
///////////////////////
$date = date("U");
$index = mysql_query("SELECT * FROM ".$global_config_arr['pref']."poll WHERE poll_end > $date AND poll_start < $date ORDER BY poll_start DESC LIMIT 0,1 ", $db);
$poll_arr = mysql_fetch_assoc($index);


//////////////////////////
//// Display Poll     ////
//////////////////////////

if (!isset($_POST['poll']) && !checkVotedPoll($poll_arr['poll_id']) && mysql_num_rows($index) > 0) {

    $poll_arr['poll_type_text'] = ( $poll_arr['poll_type'] == 1 ) ? $TEXT['frontend']->get("multiple_choise") : $TEXT['frontend']->get("single_choice");

    $index2 = mysql_query("select * from ".$global_config_arr['pref']."poll_answers where poll_id = ".$poll_arr['poll_id']." ORDER BY answer_id ASC", $db);
    initstr($antworten);
    while ($answer_arr = mysql_fetch_assoc($index2)) {
        if ($poll_arr['poll_type'] == 0) {
            $poll_arr['poll_type2'] = "radio";
            $poll_arr['poll_type3'] = "";
        }
        if ($poll_arr['poll_type'] == 1) {
            $poll_arr['poll_type2'] = "checkbox";
            $poll_arr['poll_type3'] = "[]";
        }

        // Get Template
        $template = new template();
        $template->setFile("0_polls.tpl");
        $template->load("APPLET_POLL_ANSWER_LINE");

        $template->tag("answer_id", $answer_arr['answer_id'] );
        $template->tag("answer", stripslashes ( $answer_arr['answer'] ) );
        $template->tag("type", $poll_arr['poll_type2'] );
        $template->tag("multiple", $poll_arr['poll_type3'] );

        $template = $template->display ();
        $antworten .= $template;
    }

    // Get Template
    $template = new template();
    $template->setFile("0_polls.tpl");
    $template->load("APPLET_POLL_BODY");

    $template->tag("poll_id", $poll_arr['poll_id'] );
    $template->tag("question", $poll_arr['poll_quest'] );
    $template->tag("answers", $antworten );
    $template->tag("type", $poll_arr['poll_type_text'] );

    $template = $template->display ();
}


//////////////////////////
//// View Result      ////
//////////////////////////

elseif ( ( isset($_POST['poll']) &&  isset($_POST['id']) ) || checkVotedPoll($poll_arr['poll_id']))
{
    if ( isset($_POST['poll']) &&  isset($_POST['id']) ) {
        $poll_arr['poll_id'] = $_POST['id'];
    }
    $voted = checkVotedPoll($poll_arr['poll_id']);
                
    settype($poll_arr['poll_id'], 'integer');
    $voter_ip = $_SERVER['REMOTE_ADDR'];

    $date = date("U");
    $index = mysql_query("select * from ".$global_config_arr['pref']."poll where poll_id = ".$poll_arr['poll_id']."", $db);
    $poll_arr = mysql_fetch_assoc($index);

    if ($poll_arr['poll_end'] > $date && $voted == false)
    {
        if ($poll_arr['poll_type'] == 0)
        {
            settype($_POST['answer'], 'integer');
            mysql_query("update ".$global_config_arr['pref']."poll_answers set answer_count = answer_count + 1 where answer_id = '".$_POST['answer']."'", $db);
            if ($_POST['answer'] != 0) {
                registerVoter($poll_arr['poll_id'], $voter_ip); //Register Voter if voted
                mysql_query("update ".$global_config_arr['pref']."poll set poll_participants = poll_participants + 1 where poll_id = '".$poll_arr['poll_id']."'", $db);
            }
        }
        elseif (count($_POST['answer']) > 1)
        {
            foreach ($_POST['answer'] as $id)
            {
                settype($id, 'integer');
                mysql_query("update ".$global_config_arr['pref']."poll_answers set answer_count = answer_count + 1 where answer_id = '$id'", $db);
            }
            registerVoter($poll_arr['poll_id'], $voter_ip); //Register Voter if voted
            mysql_query("update ".$global_config_arr['pref']."poll set poll_participants = poll_participants + 1 where poll_id = '".$poll_arr['poll_id']."'", $db);
        }
        elseif (is_array($_POST['answer']))
        {
            reset($_POST['answer']);
            $id = each($_POST['answer']);
            $id = $id['value'];
            settype($id, 'integer');
            mysql_query("update ".$global_config_arr['pref']."poll_answers set answer_count = answer_count + 1 where answer_id = '$id'", $db);
            if (count($_POST['answer']) != 0) {
                registerVoter($poll_arr['poll_id'], $voter_ip); //Register Voter if voted
                mysql_query("update ".$global_config_arr['pref']."poll set poll_participants = poll_participants + 1 where poll_id = '".$poll_arr['poll_id']."'", $db);
            }
        }
    }

    $index = mysql_query("select poll_participants from ".$global_config_arr['pref']."poll where poll_id = ".$poll_arr['poll_id']."", $db);
    $poll_arr['poll_participants'] = mysql_result($index, 0, "poll_participants");

    $index = mysql_query("select * from ".$global_config_arr['pref']."poll_answers where poll_id = ".$poll_arr['poll_id']."", $db);
    while ($answer_arr = mysql_fetch_assoc($index))
    {
        $all_votes += $answer_arr['answer_count'];
    }

    $index = mysql_query("SELECT * FROM ".$global_config_arr['pref']."poll_answers WHERE poll_id = ".$poll_arr['poll_id']." ORDER BY answer_id ASC", $db);
    while ($answer_arr = mysql_fetch_assoc($index))
    {
        if ($all_votes != 0) {
            $answer_arr['percentage'] = round($answer_arr['answer_count'] / $all_votes * 100, 1);
            $answer_arr['bar_width'] = round($answer_arr['answer_count'] / $all_votes * $config_arr['answerbar_width'] );
            if ( $config_arr['answerbar_type'] == 1 ) {
                $answer_arr['bar_width'] .= "%";
            } else {
                $answer_arr['bar_width'] .= "px";
            }
        } else {
            $answer_arr['percentage'] = 0;
            $answer_arr['bar_width'] = "1px";
        }

        // Get Template
        $template = new template();
        $template->setFile("0_polls.tpl");
        $template->load("APPLET_RESULT_ANSWER_LINE");

        $template->tag("answer", stripslashes ( $answer_arr['answer'] ) );
        $template->tag("votes", $answer_arr['answer_count'] );
        $template->tag("percentage", $answer_arr['percentage']."%" );
        $template->tag("bar_width", $answer_arr['bar_width'] );

        $template = $template->display ();
        $antworten .= $template;
    }
    
    // Get Template
    $template = new template();
    $template->setFile("0_polls.tpl");
    $template->load("APPLET_RESULT_BODY");

    $template->tag("question", $poll_arr['poll_quest'] );
    $template->tag("answers", $antworten );
    $template->tag("all_votes", $all_votes );
    $template->tag("participants", $poll_arr['poll_participants'] );

    $template = $template->display ();
}


//////////////////////////
//// No active poll   ////
//////////////////////////
else {
    // Get Template
    $template = new template();
    $template->setFile("0_polls.tpl");
    $template->load("APPLET_NO_POLL");
    $template = $template->display ();
}
?>
