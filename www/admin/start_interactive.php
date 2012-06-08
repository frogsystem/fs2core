<?php
$index = mysql_query('SELECT * FROM '.$global_config_arr['pref'].'poll_config', $FD->sql()->conn() );
$config_arr = mysql_fetch_assoc($index);
$date = date('U');
$index = mysql_query('SELECT * FROM '.$global_config_arr['pref']."poll WHERE poll_end > $date AND poll_start < $date ORDER BY poll_start DESC LIMIT 0,1 ", $FD->sql()->conn() );
if ( $poll_arr = mysql_fetch_assoc($index) ) {

    $poll_arr['poll_start'] = date('d.m.Y' , $poll_arr['poll_start']);
    $poll_arr['poll_end'] = date('d.m.Y' , $poll_arr['poll_end']);

    if ($poll_arr['poll_type'] == 1) {
        $poll_arr['poll_type'] = 'Mehrfachauswahl';
    } else {
        $poll_arr['poll_type'] = 'Einzelauswahl';
    }

    $index = mysql_query ( "
                            SELECT SUM(`answer_count`) AS 'num_votes'
                            FROM ".$global_config_arr['pref']."poll_answers
                            WHERE `poll_id` = '".$poll_arr['poll_id']."'
    ", $FD->sql()->conn() );
    $all_votes = mysql_result ( $index, 0, 'num_votes' );

    $index = mysql_query('SELECT * FROM '.$global_config_arr['pref']."poll_answers WHERE poll_id = '".$poll_arr['poll_id']."' ORDER BY answer_id ASC", $FD->sql()->conn() );
    while ($answer_arr = mysql_fetch_assoc($index))
    {
        if ($all_votes != 0)
        {
            $answer_arr['percentage'] = round($answer_arr['answer_count'] / $all_votes * 100, 1);
            $answer_arr['bar_width'] = $answer_arr['percentage'].'%';
        }
        else
        {
            $answer_arr['percentage'] = 0;
            $answer_arr['bar_width'] = '1px';
        }
        $template = '
                            <tr>
                                <td class="configthin">{answer}</td>
                                <td class="configthin middle"><b>{percentage}</b><br><b>{votes}</b> Stimme(n)</td>
                                <td class="config middle" style="width: 250px;">
                                    <div style="width: 250px;"><div style="width:{bar_width}; height:4px; font-size:1px; background-color:#00FF00;"></div>
                                </td>
                            </tr>
        ';
        $template = str_replace('{answer}', stripslashes ($answer_arr['answer']), $template);
        $template = str_replace('{votes}', $answer_arr['answer_count'], $template);
        $template = str_replace('{percentage}', $answer_arr['percentage'].'%', $template);
        $template = str_replace('{bar_width}', $answer_arr['bar_width'], $template);

        $antworten .= $template;
    }
    unset($answer_arr);

    $template = '
                            <tr>
                                <td class="config" colspan="3">{question}</td>
                            </tr>
                            {answers}
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="configthin">Anzahl der Teilnehmer:</td>
                                <td class="configthin" colspan="2"><b>{participants}</b></td>
                            </tr>
                            <tr>
                                <td class="configthin">Anzahl der Stimmen:</td>
                                <td class="configthin" colspan="2"><b>{all_votes}</b></td>
                            </tr>
                            <tr>
                                <td class="configthin">Art der Umfrage:</td>
                                <td class="configthin" colspan="2"><b>{typ}</b></td>
                            </tr>
                            <tr>
                                <td class="configthin">Umfragedauer:</td>
                                <td class="configthin" colspan="2"><b>{start_datum}</b> bis <b>{end_datum}</b></td>
                            </tr>
    ';
    $template = str_replace('{question}', $poll_arr['poll_quest'], $template);
    $template = str_replace('{answers}', $antworten, $template);
    $template = str_replace('{all_votes}', $all_votes, $template);
    $template = str_replace('{typ}', $poll_arr['poll_type'], $template);
    $template = str_replace('{participants}', $poll_arr['poll_participants'], $template);
    $template = str_replace('{start_datum}', $poll_arr['poll_start'], $template);
    $template = str_replace('{end_datum}', $poll_arr['poll_end'], $template);

    unset($poll_arr);

    echo '
                            <table class="configtable" cellpadding="4" cellspacing="0">
                                <tr><td class="line" colspan="3">Letzte Umfrage</td></tr>
                                '.$template.'
                                <tr><td class="space"></td></tr>
                                <tr><td class="space"></td></tr>
                        </table>
    ';

    unset ( $template );

}

$index = mysql_query ( "
                        SELECT COUNT(DISTINCT(P.`poll_id`)) AS 'num_polls', SUM(DISTINCT(P.`poll_participants`)) AS 'num_participants', SUM(A.`answer_count`) AS 'num_votes'
                        FROM ".$global_config_arr['pref'].'poll P, '.$global_config_arr['pref'].'poll_answers A
                        WHERE P.`poll_id` = A.`poll_id`
', $FD->sql()->conn() );
$num_polls = mysql_result ( $index, 0, 'num_polls' );
$num_participants = mysql_result ( $index, 0, 'num_participants' );
settype ( $num_participants, 'integer' );
$num_votes = mysql_result ( $index, 0, 'num_votes' );
settype ( $num_votes, 'integer' );

if ( $num_polls  > 0 ) {
    $index = mysql_query ( '
                            SELECT `poll_quest`, `poll_participants`
                            FROM '.$global_config_arr['pref'].'poll
                            ORDER BY `poll_participants` DESC
                            LIMIT 0,1
    ', $FD->sql()->conn() );
    $biggest_poll_part = stripslashes ( mysql_result ( $index, 0, 'poll_quest' ) );
    $most_participants = mysql_result ( $index, 0, 'poll_participants' );

    $index = mysql_query ( "
                            SELECT P.`poll_quest`, SUM(A.`answer_count`) AS 'num_votes'
                            FROM ".$global_config_arr['pref'].'poll P, '.$global_config_arr['pref'].'poll_answers A
                            WHERE P.`poll_id` = A.`poll_id`
                            GROUP BY P.`poll_quest`
                            ORDER BY `num_votes` DESC
                            LIMIT 0,1
    ', $FD->sql()->conn() );
    $biggest_poll_vote = stripslashes ( mysql_result ( $index, 0, 'poll_quest' ) );
    $most_votes = mysql_result ( $index, 0, 'num_votes' ); echo mysql_error();
}


echo '
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="2">Informationen &amp; Statistik</td></tr>
                            <tr>
                                <td class="configthin" width="200">Anzahl Umfragen:</td>
                                <td class="configthin"><b>'.$num_polls.'</b></td>
                            </tr>
';

echo '
                            <tr>
                                <td class="configthin">Anzahl Teilnehmer (gesamt):</td>
                                <td class="configthin"><b>'.$num_participants.'</b></td>
                            </tr>
';

if ( $num_polls  > 0 ) {
    echo '
                            <tr>
                                <td class="configthin">Meiste Teilnehmer:</td>
                                <td class="configthin"><b>'.$biggest_poll_part.'</b> mit <b>'.$most_participants.'</b> Teilnehmer(n)</td>
                            </tr>
    ';
}

echo '
                            <tr>
                                <td class="configthin">Anzahl Stimmen (gesamt):</td>
                                <td class="configthin"><b>'.$num_votes.'</b></td>
                            </tr>
';

if ( $num_polls  > 0 ) {
    echo '
                            <tr>
                                <td class="configthin">Meiste Stimmen:</td>
                                <td class="configthin"><b>'.$biggest_poll_vote.'</b> mit <b>'.$most_votes.'</b> Stimme(n)</td>
                            </tr>
    ';
}

echo '
                        </table>
';
?>
