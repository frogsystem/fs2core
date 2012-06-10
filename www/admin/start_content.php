<?php
$index = mysql_query ( "
                        SELECT COUNT(`news_id`) AS 'num_news'
                        FROM ".$global_config_arr['pref'].'news
                        LIMIT 0,1
', $FD->sql()->conn() );
$num_news = mysql_result ( $index, 0, 'num_news' );

$index = mysql_query ( "
                        SELECT COUNT(`cat_id`) AS 'num_news_cat'
                        FROM ".$global_config_arr['pref'].'news_cat
                        LIMIT 0,1
', $FD->sql()->conn() );
$num_news_cat = mysql_result ( $index, 0, 'num_news_cat' );

$index = mysql_query ( "
                        SELECT COUNT(`comment_id`) AS 'num_comments'
                        FROM ".$global_config_arr['pref'].'news_comments
                        LIMIT 0,1
', $FD->sql()->conn() );
$num_comments = mysql_result ( $index, 0, 'num_comments' );

$index = mysql_query ( "
                        SELECT COUNT(`link_id`) AS 'num_links'
                        FROM ".$global_config_arr['pref'].'news_links
                        LIMIT 0,1
', $FD->sql()->conn() );
$num_links = mysql_result ( $index, 0, 'num_links' );

if ( $num_news  > 0 ) {
    $index = mysql_query ( "
                            SELECT COUNT(C.`cat_id`) AS 'best_news_cat_num', C.`cat_name`
                            FROM ".$global_config_arr['pref'].'news_cat C, '.$global_config_arr['pref'].'news N
                            WHERE N.`cat_id` = C.`cat_id`
                            GROUP BY C.`cat_name`
                            ORDER BY `best_news_cat_num` DESC
                            LIMIT 0,1
    ', $FD->sql()->conn() );
    $best_news_cat = stripslashes ( mysql_result ( $index, 0, 'cat_name' ) );
    $best_news_cat_num = mysql_result ( $index, 0, 'best_news_cat_num' );

    if ( $num_comments  > 0 ) {
        $index = mysql_query ( "
                                SELECT COUNT(C.`comment_id`) AS 'best_news_com_num', N.`news_title`
                                FROM ".$global_config_arr['pref'].'news_comments C, '.$global_config_arr['pref'].'news N
                                WHERE N.`news_id` = C.`news_id`
                                GROUP BY N.`news_title`
                                ORDER BY `best_news_com_num` DESC
                                LIMIT 0,1
        ', $FD->sql()->conn() );
        $best_news_com = stripslashes ( mysql_result ( $index, 0, 'news_title' ) );
        $best_news_com_num = mysql_result ( $index, 0, 'best_news_com_num' );

        $index = mysql_query ( "
                                SELECT COUNT(C.`comment_id`) AS 'best_com_poster_num', U.`user_name`
                                FROM `".$global_config_arr['pref'].'user` U, `'.$global_config_arr['pref'].'news_comments` C
                                WHERE C.`comment_poster_id` = U.`user_id`
                                AND C.`comment_poster_id` > 0
                                GROUP BY U.`user_name`
                                ORDER BY `best_com_poster_num` DESC
                                LIMIT 0,1
        ', $FD->sql()->conn() );
        $best_com_poster_rows = mysql_num_rows ( $index );
        if ( $best_com_poster_rows >= 1 ) {
            $best_com_poster = stripslashes ( mysql_result ( $index, 0, 'user_name' ) );
            $best_com_poster_num = mysql_result ( $index, 0, 'best_com_poster_num' );
        }
    }

    $index = mysql_query ( "
                            SELECT COUNT(L.`link_id`) AS 'best_news_link_num', N.`news_title`
                            FROM ".$global_config_arr['pref'].'news_links L, '.$global_config_arr['pref'].'news N
                            WHERE N.`news_id` = L.`news_id`
                            GROUP BY N.`news_title`
                            ORDER BY `best_news_link_num` DESC
                            LIMIT 0,1
    ', $FD->sql()->conn() );
    if (mysql_num_rows($index) == 1) {
        $best_news_link = stripslashes ( mysql_result ( $index, 0, 'news_title' ) );
        $best_news_link_num = mysql_result ( $index, 0, 'best_news_link_num' );
    }


    $index = mysql_query ( "
                            SELECT COUNT(N.`news_id`) AS 'best_news_poster_num', U.`user_name`
                            FROM ".$global_config_arr['pref'].'user U, '.$global_config_arr['pref'].'news N
                            WHERE N.`user_id` = U.`user_id`
                            GROUP BY U.`user_name`
                            ORDER BY `best_news_poster_num` DESC
                            LIMIT 0,1
    ', $FD->sql()->conn() );
    $best_news_poster = stripslashes ( mysql_result ( $index, 0, 'user_name' ) );
    $best_news_poster_num = mysql_result ( $index, 0, 'best_news_poster_num' );
}


$index = mysql_query ( "
                        SELECT COUNT(`article_id`) AS 'num_articles'
                        FROM ".$global_config_arr['pref'].'articles
                        LIMIT 0,1
', $FD->sql()->conn() );
$num_articles = mysql_result ( $index, 0, 'num_articles' );

$index = mysql_query ( "
                        SELECT COUNT(`cat_id`) AS 'num_articles_cat'
                        FROM ".$global_config_arr['pref'].'articles_cat
                        LIMIT 0,1
', $FD->sql()->conn() );
$num_articles_cat = mysql_result ( $index, 0, 'num_articles_cat' );

$index = mysql_query ( "
                        SELECT COUNT(A.`article_id`) AS 'best_article_poster_num', U.`user_name`
                        FROM ".$global_config_arr['pref'].'user U, '.$global_config_arr['pref'].'articles A
                        WHERE A.`article_user` = U.`user_id`
                        AND A.`article_user` > 0
                        GROUP BY U.`user_name`
                        ORDER BY `best_article_poster_num` DESC
                        LIMIT 0,1
', $FD->sql()->conn() );
if ( mysql_num_rows ( $index) > 0 ) {
    $best_article_poster = stripslashes ( mysql_result ( $index, 0, 'user_name' ) );
    $best_article_poster_num = mysql_result ( $index, 0, 'best_article_poster_num' );
    settype ( $best_article_poster_num, 'integer' );
}

$index = mysql_query ( "
                        SELECT COUNT(`press_id`) AS 'num_press'
                        FROM ".$global_config_arr['pref'].'press
                        LIMIT 0,1
', $FD->sql()->conn() );
$num_press = mysql_result ( $index, 0, 'num_press' );

if ( $num_press  > 0 ) {
    $index = mysql_query ( "
                            SELECT COUNT(V.`id`) AS 'best_press_lang_num', V.`title`
                            FROM ".$global_config_arr['pref'].'press P, '.$global_config_arr['pref']."press_admin V
                            WHERE P.`press_lang` = V.`id`
                            AND V.`type` = '3'
                            GROUP BY V.`title`
                            ORDER BY `best_press_lang_num` DESC
                            LIMIT 0,1
    ", $FD->sql()->conn() );
    $best_press_lang = stripslashes ( mysql_result ( $index, 0, 'title' ) );
    $best_press_lang_num = mysql_result ( $index, 0, 'best_press_lang_num' );
}

echo '
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="2">Informationen &amp; Statistik</td></tr>
                            <tr>
                                <td class="configthin" width="200">Anzahl News:</td>
                                <td class="configthin"><b>'.$num_news.'</b> News in <b>'.$num_news_cat.'</b> Kategorie(n)</td>
                            </tr>
                            <tr>
                                <td class="configthin" width="200">Anzahl Kommentare:</td>
                                <td class="configthin"><b>'.$num_comments.'</b></td>
                            </tr>
                            <tr>
                                <td class="configthin" width="200">Anzahl Links:</td>
                                <td class="configthin"><b>'.$num_links.'</b></td>
                            </tr>
';

if ( $num_news  > 0 ) {
    echo '
                            <tr>
                                <td class="configthin">Gr&ouml;&szlig;te Kategorie:</td>
                                <td class="configthin"><b>'.$best_news_cat.'</b> mit <b>'.$best_news_cat_num.'</b> News</td>
                            </tr>
    ';

    if ( $num_comments  > 0 ) {
        echo '
                            <tr>
                                <td class="configthin">Meisten Kommentare:</td>
                                <td class="configthin"><b>'.$best_news_com.'</b> mit <b>'.$best_news_com_num.'</b> Kommentar(en)</td>
                            </tr>
        ';
    }

    if ( $best_news_link_num  > 0 ) {
        echo '
                                <tr>
                                    <td class="configthin">Meisten Links:</td>
                                    <td class="configthin"><b>'.$best_news_link.'</b> mit <b>'.$best_news_link_num.'</b> Link(s)</td>
                                </tr>
        ';
    }

    echo '
                            <tr>
                                <td class="configthin">Flei&szlig;igster News-Poster:</td>
                                <td class="configthin"><b>'.$best_news_poster.'</b> mit <b>'.$best_news_poster_num.'</b> News</td>
                            </tr>
    ';

    if ( $num_comments  > 0 && $best_com_poster_rows >= 1 ) {
        echo '
                            <tr>
                                <td class="configthin">Flei&szlig;igster Kommentar-Poster:</td>
                                <td class="configthin"><b>'.$best_com_poster.'</b> mit <b>'.$best_com_poster_num.'</b> Kommentar(en)</td>
                            </tr>
        ';
    }
}

echo '
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="configthin" width="200">Anzahl Artikel:</td>
                                <td class="configthin"><b>'.$num_articles.'</b> Artikel in <b>'.$num_articles_cat.'</b> Kategorie(n)</td>
                            </tr>
';

if ( $num_articles  > 0 && $best_article_poster_num > 0 ) {
    echo '
                            <tr>
                                <td class="configthin">Flei&szlig;igster Artikel-Autor:</td>
                                <td class="configthin"><b>'.$best_article_poster.'</b> mit <b>'.$best_article_poster_num.'</b> Artikel(n)</td>
                            </tr>
    ';
}

echo '
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="configthin" width="200">Anzahl Presseberichte:</td>
                                <td class="configthin"><b>'.$num_press.'</b></td>
                            </tr>
';

if ( $num_press  > 0 ) {
    echo '
                            <tr>
                                <td class="configthin">H&auml;ufigste Sprache:</td>
                                <td class="configthin"><b>'.$best_press_lang.'</b> mit <b>'.$best_press_lang_num.'</b> Pressebericht(en)</td>
                            </tr>
    ';
}

echo '
                        </table>
';
?>
