<?php
// predefined vars:
// $SCRIPT['argc'] = number of passed arguments
// $SCRIPT['argv'] = array of passed arguments (index 0 is the name of the applet)

////////////////////////////
/// Konfiguration laden ////
////////////////////////////
$index = mysql_query('SELECT * FROM '.$global_config_arr['pref'].'poll_config', $FD->sql()->conn() );
$config_arr = mysql_fetch_assoc($index);


///////////////////////
/// Load Poll Data ////
///////////////////////

//poll id given
if ($SCRIPT['argc'] >= 2 && is_numeric($SCRIPT['argv'][1])) {
    try {
        $poll_arr = $sql->getById('poll', '*', $SCRIPT['argv'][1], 'poll_id');
    } catch (Exception $e) {
    }

// random option
} elseif ($SCRIPT['argc'] >= 2 && $SCRIPT['argv'][1] == 'random') {
    $date = time();
    try {
        $poll_ids = $sql->getData('poll', array('poll_id'), array('W' => '`poll_end` > '.$date.' AND `poll_start` < '.$date));
        $filterd_ids = array_filter($poll_ids, function ($poll) {
            return !checkVotedPoll($poll['poll_id']);
        });
        if (count($filterd_ids) == 0)
            $filterd_ids = $poll_ids;

        $poll_arr = $sql->getById('poll', '*', $poll_ids[array_rand($filterd_ids)]['poll_id'], 'poll_id');
        $poll_arr['random'] = true;
    } catch (Exception $e) {
    }

// last poll
} else {
    $poll_arr = $FD->sql()->getRow('poll', '*', array(
        'W' => '`poll_end` > '.$FD->env('date').' AND `poll_start` < '.$FD->env('date'),
        'O' => '`poll_start` DESC, `poll_id` DESC',
        'L' => '0,1'
    ));
}

//////////////////////////
//// View Result      ////
//////////////////////////
if ((isset($_POST['poll_id']) && ($_POST['poll_id'] === $poll_arr['poll_id'] || $poll_arr['random'] === true))
    || checkVotedPoll($poll_arr['poll_id'])
    || (isset($poll_arr['poll_end']) && time() > $poll_arr['poll_end'])
)
{
    if ($poll_arr['random'] === true && isset($_POST['poll_id'])) {
        $poll_arr['poll_id'] = $_POST['poll_id'];
        settype($poll_arr['poll_id'], 'integer');
    }

    $voted = checkVotedPoll($poll_arr['poll_id']);
    $voter_ip = $_SERVER['REMOTE_ADDR'];

    $date = time();
    $index = mysql_query('SELECT * FROM '.$global_config_arr['pref'].'poll WHERE poll_id = '.$poll_arr['poll_id'], $FD->sql()->conn() );
    $poll_arr = mysql_fetch_assoc($index);

    // Yay! New vote
    if ($poll_arr['poll_end'] > $date && $voted == false)
    {
        if ($poll_arr['poll_type'] == 0)
        {
            settype($_POST['answer'], 'integer');
            mysql_query('UPDATE '.$global_config_arr['pref']."poll_answers SET answer_count = answer_count + 1 WHERE answer_id = '".$_POST['answer']."'", $FD->sql()->conn() );
            if ($_POST['answer'] != 0) {
                registerVoter($poll_arr['poll_id'], $voter_ip); //Register Voter if voted
                mysql_query('UPDATE '.$global_config_arr['pref']."poll SET poll_participants = poll_participants + 1 WHERE poll_id = '".$poll_arr['poll_id']."'", $FD->sql()->conn() );
            }
        }
        elseif (count($_POST['answer']) > 1)
        {
            foreach ($_POST['answer'] as $id)
            {
                settype($id, 'integer');
                mysql_query('UPDATE '.$global_config_arr['pref']."poll_answers SET answer_count = answer_count + 1 WHERE answer_id = '$id'", $FD->sql()->conn() );
            }
            registerVoter($poll_arr['poll_id'], $voter_ip); //Register Voter if voted
            mysql_query('UPDATE '.$global_config_arr['pref']."poll SET poll_participants = poll_participants + 1 WHERE poll_id = '".$poll_arr['poll_id']."'", $FD->sql()->conn() );
        }
        elseif (is_array($_POST['answer']))
        {
            reset($_POST['answer']);
            $id = each($_POST['answer']);
            $id = $id['value'];
            settype($id, 'integer');
            mysql_query('UPDATE '.$global_config_arr['pref']."poll_answers SET answer_count = answer_count + 1 WHERE answer_id = '$id'", $FD->sql()->conn() );
            if (count($_POST['answer']) != 0) {
                registerVoter($poll_arr['poll_id'], $voter_ip); //Register Voter if voted
                mysql_query('UPDATE '.$global_config_arr['pref']."poll SET poll_participants = poll_participants + 1 WHERE poll_id = '".$poll_arr['poll_id']."'", $FD->sql()->conn() );
            }
        }
    }

    $index = mysql_query('SELECT poll_participants FROM '.$global_config_arr['pref'].'poll WHERE poll_id = '.$poll_arr['poll_id'], $FD->sql()->conn() );
    $poll_arr['poll_participants'] = mysql_result($index, 0, 'poll_participants');

    $index = mysql_query('SELECT * FROM '.$global_config_arr['pref'].'poll_answers WHERE poll_id = '.$poll_arr['poll_id'], $FD->sql()->conn() );
    while ($answer_arr = mysql_fetch_assoc($index))
    {
        $all_votes += $answer_arr['answer_count'];
    }

    $index = mysql_query('SELECT * FROM '.$global_config_arr['pref'].'poll_answers WHERE poll_id = '.$poll_arr['poll_id'].' ORDER BY answer_id ASC', $FD->sql()->conn() );
    while ($answer_arr = mysql_fetch_assoc($index))
    {
        if ($all_votes != 0) {
            $answer_arr['percentage'] = round($answer_arr['answer_count'] / $all_votes * 100, 1);
            $answer_arr['bar_width'] = round($answer_arr['answer_count'] / $all_votes * $config_arr['answerbar_width'] );
            if ( $config_arr['answerbar_type'] == 1 ) {
                $answer_arr['bar_width'] .= '%';
            } else {
                $answer_arr['bar_width'] .= 'px';
            }
        } else {
            $answer_arr['percentage'] = 0;
            $answer_arr['bar_width'] = '1px';
        }

        // Get Template
        $template = new template();
        $template->setFile('0_polls.tpl');
        $template->load('APPLET_RESULT_ANSWER_LINE');

        $template->tag('answer', stripslashes ( $answer_arr['answer'] ) );
        $template->tag('votes', $answer_arr['answer_count'] );
        $template->tag('percentage', $answer_arr['percentage'].'%' );
        $template->tag('bar_width', $answer_arr['bar_width'] );

        $template = $template->display ();
        $antworten .= $template;
    }

    // Get Template
    $template = new template();
    $template->setFile('0_polls.tpl');
    $template->load('APPLET_RESULT_BODY');

    $template->tag('question', $poll_arr['poll_quest'] );
    $template->tag('answers', $antworten );
    $template->tag('all_votes', $all_votes );
    $template->tag('participants', $poll_arr['poll_participants'] );

    $template = $template->display ();
}


//////////////////////////
//// Display Poll     ////
//////////////////////////

elseif (!checkVotedPoll($poll_arr['poll_id']) && isset($poll_arr['poll_id'])) {

    $poll_arr['poll_type_text'] = ( $poll_arr['poll_type'] == 1 ) ? $TEXT['frontend']->get('multiple_choise') : $TEXT['frontend']->get('single_choice');

    $index2 = mysql_query('SELECT * FROM '.$global_config_arr['pref'].'poll_answers WHERE poll_id = '.$poll_arr['poll_id'].' ORDER BY answer_id ASC', $FD->sql()->conn() );
    initstr($antworten);
    while ($answer_arr = mysql_fetch_assoc($index2)) {
        if ($poll_arr['poll_type'] == 0) {
            $poll_arr['poll_type2'] = 'radio';
            $poll_arr['poll_type3'] = '';
        }
        if ($poll_arr['poll_type'] == 1) {
            $poll_arr['poll_type2'] = 'checkbox';
            $poll_arr['poll_type3'] = '[]';
        }

        // Get Template
        $template = new template();
        $template->setFile('0_polls.tpl');
        $template->load('APPLET_POLL_ANSWER_LINE');

        $template->tag('answer_id', $answer_arr['answer_id'] );
        $template->tag('answer', stripslashes ( $answer_arr['answer'] ) );
        $template->tag('type', $poll_arr['poll_type2'] );
        $template->tag('multiple', $poll_arr['poll_type3'] );

        $template = $template->display ();
        $antworten .= $template;
    }

    // Get Template
    $template = new template();
    $template->setFile('0_polls.tpl');
    $template->load('APPLET_POLL_BODY');

    $template->tag('poll_id', $poll_arr['poll_id'] );
    $template->tag('question', $poll_arr['poll_quest'] );
    $template->tag('answers', $antworten );
    $template->tag('type', $poll_arr['poll_type_text'] );

    $template = $template->display ();
}


//////////////////////////
//// No active poll   ////
//////////////////////////
else {
    // Get Template
    $template = new template();
    $template->setFile('0_polls.tpl');
    $template->load('APPLET_NO_POLL');
    $template = $template->display ();
}


echo $template;
unset($template);

?>
