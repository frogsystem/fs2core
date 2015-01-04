<?php
// predefined vars:
// $SCRIPT['argc'] = number of passed arguments
// $SCRIPT['argv'] = array of passed arguments (index 0 is the name of the applet)

////////////////////////////
/// Konfiguration laden ////
////////////////////////////
$FD->loadConfig('polls');

///////////////////////
/// Load Poll Data ////
///////////////////////

//poll id given
if ($SCRIPT['argc'] >= 2 && is_numeric($SCRIPT['argv'][1])) {
    try {
        $poll_arr = $FD->db()->conn()->query('SELECT * FROM '.$FD->config('pref').'poll WHERE poll_id = '.intval($SCRIPT['argv'][1]).' LIMIT 1');
        $poll_arr = $poll_arr->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $poll_arr = array();
    }

// random option
} elseif ($SCRIPT['argc'] >= 2 && $SCRIPT['argv'][1] == 'random') {
    $date = time();
    try {
        $poll_ids = $FD->db()->conn()->query(
                         'SELECT poll_id FROM '.$FD->config('pref').'poll
                          WHERE `poll_end` > '.$date.' AND `poll_start` < '.$date);
        $poll_ids = $poll_ids->fetchAll(PDO::FETCH_ASSOC);
        $filterd_ids = array_filter($poll_ids, create_function('$poll',
            'return !checkVotedPoll($poll[\'poll_id\']);'));

        if (count($filterd_ids) == 0)
            $filterd_ids = $poll_ids;

        // still no poll
        if (count($filterd_ids) == 0)
            Throw new ErrorException('No active Poll in Database');

        $poll_arr = $FD->db()->conn()->query(
                     'SELECT * FROM '.$FD->config('pref').'poll
                      WHERE poll_id = '.intval($poll_ids[array_rand($filterd_ids)]['poll_id']).'
                      LIMIT 1');
        $poll_arr = $poll_arr->fetch(PDO::FETCH_ASSOC);
        $poll_arr['random'] = true;
    } catch (Exception $e) {
        $poll_arr = array();
    }

// last poll
} else {
    $poll_arr = $FD->db()->conn()->query(
                     'SELECT * FROM '.$FD->config('pref').'poll
                      WHERE `poll_end` > '.$FD->env('date').' AND `poll_start` < '.$FD->env('date').'
                      ORDER BY `poll_start` DESC, `poll_id` DESC
                      LIMIT 0,1');
    $poll_arr = $poll_arr->fetch(PDO::FETCH_ASSOC);
}

//////////////////////////
//// View Result      ////
//////////////////////////
if (
    (
        isset($_POST['poll_id']) && ($_POST['poll_id'] === $poll_arr['poll_id'] || $poll_arr['random'] === true)
        || (isset($poll_arr['poll_id']) && checkVotedPoll($poll_arr['poll_id']))
        || (isset($poll_arr['poll_end']) && time() > $poll_arr['poll_end'])
    )
)
{
    if (isset($_POST['random']) && $poll_arr['random'] === true && isset($_POST['poll_id'])) {
        $poll_arr['poll_id'] = $_POST['poll_id'];
        settype($poll_arr['poll_id'], 'integer');
    }

    $voted = checkVotedPoll($poll_arr['poll_id']);
    $voter_ip = $_SERVER['REMOTE_ADDR'];

    $date = time();
    $index = $FD->db()->conn()->query('SELECT * FROM '.$FD->config('pref').'poll WHERE poll_id = '.$poll_arr['poll_id']);
    $poll_arr = $index->fetch(PDO::FETCH_ASSOC);

    // Yay! New vote
    if ($poll_arr['poll_end'] > $date && $voted == false)
    {
        if ($poll_arr['poll_type'] == 0)
        {
            settype($_POST['answer'], 'integer');
            $FD->db()->conn()->exec('UPDATE '.$FD->config('pref')."poll_answers SET answer_count = answer_count + 1 WHERE answer_id = '".$_POST['answer']."'");
            if ($_POST['answer'] != 0) {
                registerVoter($poll_arr['poll_id'], $voter_ip); //Register Voter if voted
                $FD->db()->conn()->exec('UPDATE '.$FD->config('pref')."poll SET poll_participants = poll_participants + 1 WHERE poll_id = '".$poll_arr['poll_id']."'");
            }
        }
        elseif (count($_POST['answer']) > 1)
        {
            $stmt = $FD->db()->conn()->prepare('UPDATE '.$FD->config('pref').'poll_answers SET answer_count = answer_count + 1 WHERE answer_id = ?');
            foreach ($_POST['answer'] as $id)
            {
                settype($id, 'integer');
                $stmt->execute(array($id));
            }
            registerVoter($poll_arr['poll_id'], $voter_ip); //Register Voter if voted
            $FD->db()->conn()->exec('UPDATE '.$FD->config('pref')."poll SET poll_participants = poll_participants + 1 WHERE poll_id = '".$poll_arr['poll_id']."'");
        }
        elseif (is_array($_POST['answer']))
        {
            reset($_POST['answer']);
            $id = each($_POST['answer']);
            $id = $id['value'];
            settype($id, 'integer');
            $FD->db()->conn()->exec('UPDATE '.$FD->config('pref')."poll_answers SET answer_count = answer_count + 1 WHERE answer_id = '$id'");
            if (count($_POST['answer']) != 0) {
                registerVoter($poll_arr['poll_id'], $voter_ip); //Register Voter if voted
                $FD->db()->conn()->exec('UPDATE '.$FD->config('pref')."poll SET poll_participants = poll_participants + 1 WHERE poll_id = '".$poll_arr['poll_id']."'");
            }
        }
    }

    $index = $FD->db()->conn()->query('SELECT poll_participants FROM '.$FD->config('pref').'poll WHERE poll_id = '.$poll_arr['poll_id']);
    $result_poll = $index->fetch(PDO::FETCH_ASSOC);
    $poll_arr['poll_participants'] = $result_poll['poll_participants'];

    $index = $FD->db()->conn()->query('SELECT SUM(answer_count) AS all_votes FROM '.$FD->config('pref').'poll_answers WHERE poll_id = '.$poll_arr['poll_id']);
    $answer_arr = $index->fetch(PDO::FETCH_ASSOC);
    $all_votes = $answer_arr['all_votes'];

    $antworten = '';
    $index = $FD->db()->conn()->query('SELECT * FROM '.$FD->config('pref').'poll_answers WHERE poll_id = '.$poll_arr['poll_id'].' ORDER BY answer_id ASC');
    while ($answer_arr = $index->fetch(PDO::FETCH_ASSOC))
    {
        if ($all_votes != 0) {
            $answer_arr['percentage'] = round($answer_arr['answer_count'] / $all_votes * 100, 1);
            $answer_arr['bar_width'] = round($answer_arr['answer_count'] / $all_votes * $FD->cfg('polls', 'answerbar_width'));
            if ( $FD->cfg('polls', 'answerbar_type') == 1 ) {
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

        $template->tag('answer', $answer_arr['answer'] );
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

elseif (isset($poll_arr['poll_id']) && !checkVotedPoll($poll_arr['poll_id'])) {

    $poll_arr['poll_type_text'] = ( $poll_arr['poll_type'] == 1 ) ? $FD->text("frontend", "multiple_choise") : $FD->text("frontend", "single_choice");

    $index2 = $FD->db()->conn()->query('SELECT * FROM '.$FD->config('pref').'poll_answers WHERE poll_id = '.$poll_arr['poll_id'].' ORDER BY answer_id ASC');
    initstr($antworten);
    while ($answer_arr = $index2->fetch(PDO::FETCH_ASSOC)) {
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
        $template->tag('answer', $answer_arr['answer'] );
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
