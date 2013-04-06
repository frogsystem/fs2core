<?php if (!defined('ACP_GO')) die('Unauthorized access!');

$index = $FD->sql()->conn()->query ( "
                SELECT COUNT(`news_id`) AS 'num_news'
                FROM ".$FD->config('pref').'news
                LIMIT 0,1' );
$row = $index->fetch(PDO::FETCH_ASSOC);
$num_news = $row['num_news'];

$index = $FD->sql()->conn()->query ( "
                SELECT COUNT(`cat_id`) AS 'num_news_cat'
                FROM ".$FD->config('pref').'news_cat
                LIMIT 0,1' );
$row = $index->fetch(PDO::FETCH_ASSOC);
$num_news_cat = $row['num_news_cat'];

$index = $FD->sql()->conn()->query ( "
                SELECT COUNT(`comment_id`) AS 'num_comments'
                FROM ".$FD->config('pref').'comments
                LIMIT 0,1' );
$row = $index->fetch(PDO::FETCH_ASSOC);
$num_comments = $row['num_comments'];

$index = $FD->sql()->conn()->query ( "
                SELECT COUNT(`link_id`) AS 'num_links'
                FROM ".$FD->config('pref').'news_links
                LIMIT 0,1' );
$row = $index->fetch(PDO::FETCH_ASSOC);
$num_links = $row['num_links'];

if ( $num_news  > 0 ) {
    $index = $FD->sql()->conn()->query ( "
                    SELECT COUNT(C.`cat_id`) AS 'best_news_cat_num', C.`cat_name`
                    FROM ".$FD->config('pref').'news_cat C, '.$FD->config('pref').'news N
                    WHERE N.`cat_id` = C.`cat_id`
                    GROUP BY C.`cat_name`
                    ORDER BY `best_news_cat_num` DESC
                    LIMIT 0,1' );
    $row = $index->fetch(PDO::FETCH_ASSOC);
    $best_news_cat = stripslashes ( $row['cat_name'] );
    $best_news_cat_num = $row['best_news_cat_num'];

    if ( $num_comments  > 0 ) {
        $index = $FD->sql()->conn()->query ( "
                        SELECT COUNT(C.`comment_id`) AS 'best_news_com_num', N.`news_title`
                        FROM ".$FD->config('pref').'comments C, '.$FD->config('pref').'news N
                        WHERE N.`news_id` = C.`content_id` AND C.`content_type`=\'news\' 
                        GROUP BY N.`news_title`
                        ORDER BY `best_news_com_num` DESC
                        LIMIT 0,1' );
        $row = $index->fetch(PDO::FETCH_ASSOC);
        $best_news_com = stripslashes ( $row['news_title'] );
        $best_news_com_num = $row['best_news_com_num'];

        $index = $FD->sql()->conn()->query ( "
                        SELECT COUNT(C.`comment_id`) AS 'best_com_poster_num', U.`user_name`
                        FROM `".$FD->config('pref').'user` U, `'.$FD->config('pref').'comments` C
                        WHERE C.`comment_poster_id` = U.`user_id`
                        AND C.`comment_poster_id` > 0
                        GROUP BY U.`user_name`
                        ORDER BY `best_com_poster_num` DESC
                        LIMIT 0,1' );
        $row = $index->fetch(PDO::FETCH_ASSOC);
        $best_com_poster_rows = false;
        if ( $row !== false ) {
            $best_com_poster_rows = true;
            $best_com_poster = stripslashes ( $row['user_name'] );
            $best_com_poster_num = $row['best_com_poster_num'];
        }
    }

    $index = $FD->sql()->conn()->query ( "
                    SELECT COUNT(L.`link_id`) AS 'best_news_link_num', N.`news_title`
                    FROM ".$FD->config('pref').'news_links L, '.$FD->config('pref').'news N
                    WHERE N.`news_id` = L.`news_id`
                    GROUP BY N.`news_title`
                    ORDER BY `best_news_link_num` DESC
                    LIMIT 0,1' );
    $row = $index->fetch(PDO::FETCH_ASSOC);
    if ($row !== false) {
        $best_news_link = stripslashes ( $row['news_title'] );
        $best_news_link_num = $row['best_news_link_num'];
    }


    $index = $FD->sql()->conn()->query ( "
                    SELECT COUNT(N.`news_id`) AS 'best_news_poster_num', U.`user_name`
                    FROM ".$FD->config('pref').'user U, '.$FD->config('pref').'news N
                    WHERE N.`user_id` = U.`user_id`
                    GROUP BY U.`user_name`
                    ORDER BY `best_news_poster_num` DESC
                    LIMIT 0,1' );
    $row = $index->fetch(PDO::FETCH_ASSOC);
    $best_news_poster = stripslashes ( $row['user_name'] );
    $best_news_poster_num = $row['best_news_poster_num'];
}


$index = $FD->sql()->conn()->query ( "
                SELECT COUNT(`article_id`) AS 'num_articles'
                FROM ".$FD->config('pref').'articles
                LIMIT 0,1' );
$row = $index->fetch(PDO::FETCH_ASSOC);
$num_articles = $row['num_articles'];

$index = $FD->sql()->conn()->query ( "
                SELECT COUNT(`cat_id`) AS 'num_articles_cat'
                FROM ".$FD->config('pref').'articles_cat
                LIMIT 0,1' );
$row = $index->fetch(PDO::FETCH_ASSOC);
$num_articles_cat = $row['num_articles_cat'];

$index = $FD->sql()->conn()->query ( "
                SELECT COUNT(A.`article_id`) AS 'best_article_poster_num', U.`user_name`
                FROM ".$FD->config('pref').'user U, '.$FD->config('pref').'articles A
                WHERE A.`article_user` = U.`user_id`
                AND A.`article_user` > 0
                GROUP BY U.`user_name`
                ORDER BY `best_article_poster_num` DESC
                LIMIT 0,1' );
$row = $index->fetch(PDO::FETCH_ASSOC);
if ( $row !== false ) {
    $best_article_poster = stripslashes ( $row['user_name'] );
    $best_article_poster_num = $row['best_article_poster_num'];
    settype ( $best_article_poster_num, 'integer' );
}

$index = $FD->sql()->conn()->query ( "
                SELECT COUNT(`press_id`) AS 'num_press'
                FROM ".$FD->config('pref').'press
                LIMIT 0,1' );
$row = $index->fetch(PDO::FETCH_ASSOC);
$num_press = $row['num_press'];

if ( $num_press  > 0 ) {
    $index = $FD->sql()->conn()->query ( "
                    SELECT COUNT(V.`id`) AS 'best_press_lang_num', V.`title`
                    FROM ".$FD->config('pref').'press P, '.$FD->config('pref')."press_admin V
                    WHERE P.`press_lang` = V.`id`
                    AND V.`type` = '3'
                    GROUP BY V.`title`
                    ORDER BY `best_press_lang_num` DESC
                    LIMIT 0,1" );
    $row = $index->fetch(PDO::FETCH_ASSOC);
    $best_press_lang = stripslashes ($row['title'] );
    $best_press_lang_num = $row['best_press_lang_num'];
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

    if ( $num_comments  > 0 && $best_com_poster_rows ) {
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
