<?php
// Set canonical parameters
$FD->setConfig('info', 'canonical', array('pollid', 'id'));

//////////////////////////
//// Locale Functions ////
//////////////////////////
function get_poll_list_order ( $SORT, $GET_SORT, $GET_ORDER, $DEFAULT = 1 ) {
    $not_get_order = ( $GET_ORDER == 'ASC' ) ? 0 : 1;
    return ( $SORT == $GET_SORT ) ? $not_get_order : $DEFAULT;
}

function get_poll_list_arrows ( $SORT, $GET_SORT, $GET_ORDER ) {
    $arrow_direction = ( $GET_ORDER == 'DESC' ) ? 'down' : 'up';
    return ( $SORT == $GET_SORT ) ? '<img src="$VAR(style_icons)arrow-' . $arrow_direction . '.gif" alt="">' : '';
}

// Get Config Array
$FD->loadConfig('polls');

////////////////////////////
///// Umfrage anzeigen /////
////////////////////////////
if ( isset ($_GET['pollid']) && !isset($_GET['id']) ) {
    $_GET['id'] = $_GET['pollid'];
}


if ( isset($_GET['id']) ) {
    settype ( $_GET['id'], 'integer' );
    $index = $FD->sql()->conn()->query ( 'SELECT * FROM `'.$FD->config('pref').'poll` WHERE `poll_id` = '.$_GET['id'] );
    $poll_arr = $index->fetch(PDO::FETCH_ASSOC);

    if ($poll_arr!==false)
    {
        $poll_arr['poll_start'] = date_loc ( $FD->config('date') , $poll_arr['poll_start']);
        $poll_arr['poll_end'] = date_loc ( $FD->config('date') , $poll_arr['poll_end']);
        $poll_arr['poll_type'] = ( $poll_arr['poll_type'] == 1 ) ? $FD->text("frontend", "multiple_choise") : $FD->text("frontend", "single_choice");
        // all votes
        $index = $FD->sql()->conn()->query ( "
                        SELECT SUM(`answer_count`) AS 'all_votes'
                        FROM `".$FD->config('pref').'poll_answers`
                        WHERE `poll_id` = '.$poll_arr['poll_id'] );
        $poll_arr['all_votes'] = $index->fetchColumn();

        //Prozentzahlen errechnen und template generieren
        $antworten = '';
        $index = $FD->sql()->conn()->query ( 'SELECT * FROM `'.$FD->config('pref').'poll_answers` WHERE `poll_id` = '.$_GET['id'] );
        while($answer_arr = $index->fetch(PDO::FETCH_ASSOC))
        {
            if ($poll_arr['all_votes'] != 0) {
                $answer_arr['prozent'] = round ( $answer_arr['answer_count'] / $poll_arr['all_votes'] * 100, 1 );
                $answer_arr['bar_width'] = round ( $answer_arr['answer_count'] / $poll_arr['all_votes']* $FD->cfg('polls', 'answerbar_width'));
                $answer_arr['bar_width'] .= ( $FD->cfg('polls', 'answerbar_type') == 1 ) ? '%' : 'px' ;
            } else {
                $answer_arr['prozent'] = 0;
                $answer_arr['bar_width'] = '1px';
            }

            // Get Template
            $template = new template();
            $template->setFile('0_polls.tpl');
            $template->load('ANSWER_LINE');

            $template->tag('answer', $answer_arr['answer'] );
            $template->tag('votes', $answer_arr['answer_count'] );
            $template->tag('percentage', $answer_arr['prozent']."%" );
            $template->tag('bar_width', $answer_arr['bar_width'] );

            $template = $template->display ();
            $antworten .= $template;
        }
        unset($answer_arr);

        // Get Template
        $template = new template();
        $template->setFile('0_polls.tpl');
        $template->load('BODY');

        $template->tag('question', $poll_arr['poll_quest'] );
        $template->tag('answers', $antworten );
        $template->tag('all_votes', $poll_arr['all_votes'] );
        $template->tag('participants', $poll_arr['poll_participants'] );
        $template->tag('type', $poll_arr['poll_type'] );
        $template->tag('start_date', $poll_arr['poll_start'] );
        $template->tag('end_date', $poll_arr['poll_end'] );

        $template = $template->display ();
    }
    else
    {
      $template = sys_message($FD->text('frontend', 'error'), $FD->text('frontend', 'poll_not_found'));
    }
}

////////////////////////////
//// Umfragen auflisten ////
////////////////////////////

else {
    $_GET['order'] = ( in_array ( isset($_GET['order']) ? $_GET['order'] : '', array ( '1', 'asc', 'ASC', 'up', 'UP' ) ) ) ? 'ASC' : 'DESC';
    $_GET['sort'] = ( in_array ( isset($_GET['sort']) ? $_GET['sort'] : '', array ( 'question', 'all_votes', 'participants', 'type', 'start_date', 'end_date' ) ) ) ? $_GET['sort'] : 'end_date';

    switch ( $_GET['sort'] ) {
        case 'question': {
            $index = $FD->sql()->conn()->query ( 'SELECT * FROM `'.$FD->config('pref').'poll` ORDER BY `poll_quest` '.$_GET['order'] );
            break;
        }
        case 'all_votes': {
            $index = $FD->sql()->conn()->query ( "
                            SELECT *, SUM(`A.answer_count`) AS 'all_votes'
                            FROM `".$FD->config('pref').'poll` P, `'.$FD->config('pref').'poll_answers` A
                            WHERE P.`poll_id` = A.`poll_id`
                            ORDER BY `all_votes` '.$_GET['order'].', P.`poll_quest` ASC' );
            break;
        }
        case 'participants': {
            $index = $FD->sql()->conn()->query ( 'SELECT * FROM `'.$FD->config('pref').'poll` ORDER BY `poll_participants` '.$_GET['order'].', `poll_quest` ASC' );
            break;
        }
        case 'type': {
            $index = $FD->sql()->conn()->query ( 'SELECT * FROM `'.$FD->config('pref').'poll` ORDER BY `poll_type` '.$_GET['order'].', `poll_quest` ASC' );
            break;
        }
        case 'start_date': {
            $index = $FD->sql()->conn()->query ( 'SELECT * FROM `'.$FD->config('pref').'poll` ORDER BY `poll_start` '.$_GET['order'].', `poll_quest` ASC' );
            break;
        }
        case 'end_date': {
            $index = $FD->sql()->conn()->query ( 'SELECT * FROM `'.$FD->config('pref').'poll` ORDER BY `poll_end` '.$_GET['order'].', `poll_quest` ASC' );
            break;
        }
    }

    $list_lines = '';
    while ( $poll_arr = $index->fetch(PDO::FETCH_ASSOC) ) {
        $poll_arr['poll_url'] = url('polls', array('id' => $poll_arr['poll_id']));
        $poll_arr['poll_start'] = date_loc ( $FD->config('date') , $poll_arr['poll_start'] );
        $poll_arr['poll_end'] = date_loc ( $FD->config('date') , $poll_arr['poll_end'] );
        $poll_arr['poll_type'] = ( $poll_arr['poll_type'] == 1 ) ? $FD->text("frontend", "multiple_choise") : $FD->text("frontend", "single_choice");

        // all votes
        $index2 = $FD->sql()->conn()->query ( "
                        SELECT SUM(`answer_count`) AS 'all_votes'
                        FROM `".$FD->config('pref').'poll_answers`
                        WHERE `poll_id` = '.$poll_arr['poll_id'] );
        $poll_arr['all_votes'] = $index2->fetchColumn();

        // Get Template
        $template = new template();
        $template->setFile('0_polls.tpl');
        $template->load('LIST_LINE');

        $template->tag('question', $poll_arr['poll_quest'] );
        $template->tag('url', $poll_arr['poll_url'] );
        $template->tag('all_votes', $poll_arr['all_votes'] );
        $template->tag('participants', $poll_arr['poll_participants'] );
        $template->tag('type', $poll_arr['poll_type'] );
        $template->tag('start_date', $poll_arr['poll_start'] );
        $template->tag('end_date', $poll_arr['poll_end'] );

        $template = $template->display ();
        $list_lines .= $template;
    }

    // Get Template
    $template = new template();
    $template->setFile('0_polls.tpl');
    $template->load('LIST_BODY');

    $template->tag('polls', $list_lines );
    $template->tag('order_question', get_poll_list_order ( 'question', $_GET['sort'], $_GET['order'] ) );
    $template->tag('order_all_votes', get_poll_list_order ( 'all_votes', $_GET['sort'], $_GET['order'], 0 ) );
    $template->tag('order_participants', get_poll_list_order ( "participants", $_GET['sort'], $_GET['order'], 0 ) );
    $template->tag('order_type', get_poll_list_order ( 'type', $_GET['sort'], $_GET['order'] ) );
    $template->tag('order_start_date', get_poll_list_order ( 'start_date', $_GET['sort'], $_GET['order'], 0 ) );
    $template->tag('order_end_date', get_poll_list_order ( 'end_date', $_GET['sort'], $_GET['order'], 0 ) );

    $template->tag('arrow_question', get_poll_list_arrows ( 'question', $_GET['sort'], $_GET['order'] ) );
    $template->tag('arrow_all_votes', get_poll_list_arrows ( 'all_votes', $_GET['sort'], $_GET['order'] ) );
    $template->tag('arrow_participants', get_poll_list_arrows ( 'participants', $_GET['sort'], $_GET['order'] ) );
    $template->tag('arrow_type', get_poll_list_arrows ( 'type', $_GET['sort'], $_GET['order'] ) );
    $template->tag('arrow_start_date', get_poll_list_arrows ( 'start_date', $_GET['sort'], $_GET['order'] ) );
    $template->tag('arrow_end_date', get_poll_list_arrows ( 'end_date', $_GET['sort'], $_GET['order'] ) );

    $template = $template->display ();
}

?>
