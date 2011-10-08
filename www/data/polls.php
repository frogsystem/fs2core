<?php
//////////////////////////
//// Locale Functions ////
//////////////////////////
function get_poll_list_order ( $SORT, $GET_SORT, $GET_ORDER, $DEFAULT = 1 ) {
    $not_get_order = ( $GET_ORDER == "ASC" ) ? 0 : 1;
    return ( $SORT == $GET_SORT ) ? $not_get_order : $DEFAULT;
}

function get_poll_list_arrows ( $SORT, $GET_SORT, $GET_ORDER ) {
    $arrow_direction = ( $GET_ORDER == "DESC" ) ? "down" : "up";
    return ( $SORT == $GET_SORT ) ? '<img src="$VAR(style_icons)arrow-' . $arrow_direction . '.gif" alt="">' : "";
}

// Get Config Array
$index = mysql_query ( "SELECT * FROM `".$global_config_arr['pref']."poll_config`", $FD->sql()->conn() );
$config_arr = mysql_fetch_assoc ( $index );

////////////////////////////
///// Umfrage anzeigen /////
////////////////////////////
if ( isset ($_GET['pollid']) && !isset($_GET['id']) ) {
    $_GET['id'] = $_GET['pollid'];
}


if ( $_GET['id'] ) {
    settype ( $_GET['id'], 'integer' );
    $index = mysql_query ( "SELECT * FROM `".$global_config_arr['pref']."poll` WHERE `poll_id` = ".$_GET['id']."", $FD->sql()->conn() );
    $poll_arr = mysql_fetch_assoc($index);

    $poll_arr[poll_start] = date_loc ( $global_config_arr['date'] , $poll_arr[poll_start]);
    $poll_arr[poll_end] = date_loc ( $global_config_arr['date'] , $poll_arr[poll_end]);
    $poll_arr[poll_type] = ( $poll_arr[poll_type] == 1 ) ? $TEXT['frontend']->get('multiple_choise') : $TEXT['frontend']->get('single_choice');
    // all votes
    $index = mysql_query ( "
                            SELECT SUM(`answer_count`) AS 'all_votes'
                            FROM `".$global_config_arr['pref']."poll_answers`
                            WHERE `poll_id` = ".$poll_arr['poll_id']."
    ", $FD->sql()->conn() );
    $poll_arr['all_votes'] = mysql_result ( $index, 0, "all_votes");
        
    //Prozentzahlen errechnen und template generieren
    $index = mysql_query ( "SELECT * FROM `".$global_config_arr['pref']."poll_answers` WHERE `poll_id` = ".$_GET['id']."", $FD->sql()->conn() );
    while($answer_arr = mysql_fetch_assoc($index))
    {
        if ($poll_arr['all_votes'] != 0) {
            $answer_arr[prozent] = round ( $answer_arr[answer_count] / $poll_arr['all_votes'] * 100, 1 );
            $answer_arr[bar_width] = round ( $answer_arr[answer_count] / $poll_arr['all_votes']* $config_arr['answerbar_width'] );
            $answer_arr[bar_width] .= ( $config_arr['answerbar_type'] == 1 ) ? "%" : "px" ;
        } else {
            $answer_arr[prozent] = 0;
            $answer_arr[bar_width] = "1px";
        }


        // Get Template
        $template = new template();
        $template->setFile("0_polls.tpl");
        $template->load("ANSWER_LINE");
        
        $template->tag("answer", stripslashes ( $answer_arr['answer'] ) );
        $template->tag("votes", $answer_arr['answer_count'] );
        $template->tag("percentage", $answer_arr['prozent']."%" );
        $template->tag("bar_width", $answer_arr['bar_width'] );
        
        $template = $template->display ();
        $antworten .= $template;
    }
    unset($answer_arr);
    
    // Get Template
    $template = new template();
    $template->setFile("0_polls.tpl");
    $template->load("BODY");

    $template->tag("question", stripslashes ( $poll_arr['poll_quest'] ) );
    $template->tag("answers", $antworten );
    $template->tag("all_votes", $poll_arr['all_votes'] );
    $template->tag("participants", $poll_arr['poll_participants'] );
    $template->tag("type", $poll_arr['poll_type'] );
    $template->tag("start_date", $poll_arr['poll_start'] );
    $template->tag("end_date", $poll_arr['poll_end'] );

    $template = $template->display ();
}

////////////////////////////
//// Umfragen auflisten ////
////////////////////////////

else {
    $_GET['order'] = ( in_array ( $_GET['order'], array ( "1", "asc", "ASC", "up", "UP" ) ) ) ? "ASC" : "DESC";
    $_GET['sort'] = ( in_array ( $_GET['sort'], array ( "question", "all_votes", "participants", "type", "start_date", "end_date" ) ) ) ? $_GET['sort'] : "end_date";

    switch ( $_GET['sort'] ) {
        case "question": {
            $index = mysql_query ( "SELECT * FROM `".$global_config_arr['pref']."poll` ORDER BY `poll_quest` ".$_GET['order']."", $FD->sql()->conn() );
            break;
        }
        case "all_votes": {
            $index = mysql_query ( "
                                    SELECT *, SUM(`A.answer_count`) AS 'all_votes'
                                    FROM `".$global_config_arr['pref']."poll` P, `".$global_config_arr['pref']."poll_answers` A
                                    WHERE P.`poll_id` = A.`poll_id`
                                    ORDER BY `all_votes` ".$_GET['order'].", P.`poll_quest` ASC
            ", $FD->sql()->conn() );
            break;
        }
        case "participants": {
            $index = mysql_query ( "SELECT * FROM `".$global_config_arr['pref']."poll` ORDER BY `poll_participants` ".$_GET['order'].", `poll_quest` ASC", $FD->sql()->conn() );
            break;
        }
        case "type": {
            $index = mysql_query ( "SELECT * FROM `".$global_config_arr['pref']."poll` ORDER BY `poll_type` ".$_GET['order'].", `poll_quest` ASC", $FD->sql()->conn() );
            break;
        }
        case "start_date": {
            $index = mysql_query ( "SELECT * FROM `".$global_config_arr['pref']."poll` ORDER BY `poll_start` ".$_GET['order'].", `poll_quest` ASC", $FD->sql()->conn() );
            break;
        }
        case "end_date": {
            $index = mysql_query ( "SELECT * FROM `".$global_config_arr['pref']."poll` ORDER BY `poll_end` ".$_GET['order'].", `poll_quest` ASC", $FD->sql()->conn() );
            break;
        }
    }

    $list_lines = "";
    while ( $poll_arr = mysql_fetch_assoc ( $index ) ) {
        $poll_arr[poll_url] = url("polls", array('id' => $poll_arr['poll_id']));
        $poll_arr[poll_start] = date_loc ( $global_config_arr['date'] , $poll_arr[poll_start] );
        $poll_arr[poll_end] = date_loc ( $global_config_arr['date'] , $poll_arr[poll_end] );
        $poll_arr[poll_type] = ( $poll_arr[poll_type] == 1 ) ? $TEXT['frontend']->get('multiple_choise') : $TEXT['frontend']->get('single_choice');

        // all votes
        $index2 = mysql_query ( "
                                SELECT SUM(`answer_count`) AS 'all_votes'
                                FROM `".$global_config_arr['pref']."poll_answers`
                                WHERE `poll_id` = ".$poll_arr['poll_id']."
        ", $FD->sql()->conn() );
        $poll_arr['all_votes'] = mysql_result ( $index2, 0, "all_votes");
        
        // Get Template
        $template = new template();
        $template->setFile("0_polls.tpl");
        $template->load("LIST_LINE");

        $template->tag("question", stripslashes ( $poll_arr['poll_quest'] ) );
        $template->tag("url", $poll_arr['poll_url'] );
        $template->tag("all_votes", $poll_arr['all_votes'] );
        $template->tag("participants", $poll_arr['poll_participants'] );
        $template->tag("type", $poll_arr['poll_type'] );
        $template->tag("start_date", $poll_arr['poll_start'] );
        $template->tag("end_date", $poll_arr['poll_end'] );

        $template = $template->display ();
        $list_lines .= $template;
    }

    // Get Template
    $template = new template();
    $template->setFile("0_polls.tpl");
    $template->load("LIST_BODY");

    $template->tag("polls", $list_lines );
    $template->tag("order_question", get_poll_list_order ( "question", $_GET['sort'], $_GET['order'] ) );
    $template->tag("order_all_votes", get_poll_list_order ( "all_votes", $_GET['sort'], $_GET['order'], 0 ) );
    $template->tag("order_participants", get_poll_list_order ( "participants", $_GET['sort'], $_GET['order'], 0 ) );
    $template->tag("order_type", get_poll_list_order ( "type", $_GET['sort'], $_GET['order'] ) );
    $template->tag("order_start_date", get_poll_list_order ( "start_date", $_GET['sort'], $_GET['order'], 0 ) );
    $template->tag("order_end_date", get_poll_list_order ( "end_date", $_GET['sort'], $_GET['order'], 0 ) );
    
    $template->tag("arrow_question", get_poll_list_arrows ( "question", $_GET['sort'], $_GET['order'] ) );
    $template->tag("arrow_all_votes", get_poll_list_arrows ( "all_votes", $_GET['sort'], $_GET['order'] ) );
    $template->tag("arrow_participants", get_poll_list_arrows ( "participants", $_GET['sort'], $_GET['order'] ) );
    $template->tag("arrow_type", get_poll_list_arrows ( "type", $_GET['sort'], $_GET['order'] ) );
    $template->tag("arrow_start_date", get_poll_list_arrows ( "start_date", $_GET['sort'], $_GET['order'] ) );
    $template->tag("arrow_end_date", get_poll_list_arrows ( "end_date", $_GET['sort'], $_GET['order'] ) );

    $template = $template->display ();
}

?>
