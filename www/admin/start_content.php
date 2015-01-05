<?php if (!defined('ACP_GO')) die('Unauthorized access!');

$index = $FD->db()->conn()->query ( "
                SELECT COUNT(`news_id`) AS 'num_news'
                FROM `".$FD->env('DB_PREFIX').'news`
                LIMIT 0,1' );
$num_news = $index->fetchColumn();

$index = $FD->db()->conn()->query ( "
                SELECT COUNT(`cat_id`) AS 'num_news_cat'
                FROM `".$FD->env('DB_PREFIX').'news_cat`
                LIMIT 0,1' );
$num_news_cat = $index->fetchColumn();

$index = $FD->db()->conn()->query ( "
                SELECT COUNT(`comment_id`) AS 'num_comments'
                FROM `".$FD->env('DB_PREFIX').'comments`
                LIMIT 0,1' );
$num_comments = $index->fetchColumn();

$index = $FD->db()->conn()->query ( "
                SELECT COUNT(`link_id`) AS 'num_links'
                FROM `".$FD->env('DB_PREFIX').'news_links`
                LIMIT 0,1' );
$num_links = $index->fetchColumn();

if ( $num_news > 0 ) {
    $index = $FD->db()->conn()->query ( "
                    SELECT COUNT(C.`cat_id`) AS 'best_news_cat_num', C.`cat_name`
                    FROM ".$FD->env('DB_PREFIX').'news_cat C, '.$FD->env('DB_PREFIX').'news N
                    WHERE N.`cat_id` = C.`cat_id`
                    GROUP BY C.`cat_name`
                    ORDER BY `best_news_cat_num` DESC
                    LIMIT 0,1' );
    $row = $index->fetch(PDO::FETCH_ASSOC);
    $best_news_cat = $row['cat_name'];
    $best_news_cat_num = $row['best_news_cat_num'];

    if ( $num_comments > 0 ) {
        $index = $FD->db()->conn()->query ( "
                        SELECT COUNT(C.`comment_id`) AS 'best_news_com_num', N.`news_title`
                        FROM ".$FD->env('DB_PREFIX').'comments C, '.$FD->env('DB_PREFIX').'news N
                        WHERE N.`news_id` = C.`content_id` AND C.`content_type`=\'news\'
                        GROUP BY N.`news_title`
                        ORDER BY `best_news_com_num` DESC
                        LIMIT 0,1' );
        $row = $index->fetch(PDO::FETCH_ASSOC);
        $best_news_com = $row['news_title'];
        $best_news_com_num = $row['best_news_com_num'];

        $index = $FD->db()->conn()->query ( "
                        SELECT COUNT(C.`comment_id`) AS 'best_com_poster_num', U.`user_name`
                        FROM `".$FD->env('DB_PREFIX').'user` U, `'.$FD->env('DB_PREFIX').'comments` C
                        WHERE C.`comment_poster_id` = U.`user_id`
                        AND C.`comment_poster_id` > 0
                        GROUP BY U.`user_name`
                        ORDER BY `best_com_poster_num` DESC
                        LIMIT 0,1' );
        $row = $index->fetch(PDO::FETCH_ASSOC);
        $best_com_poster_rows = false;
        if ( $row !== false ) {
            $best_com_poster_rows = true;
            $best_com_poster = $row['user_name'];
            $best_com_poster_num = $row['best_com_poster_num'];
        }
    }

    $index = $FD->db()->conn()->query ( "
                    SELECT COUNT(L.`link_id`) AS 'best_news_link_num', N.`news_title`
                    FROM ".$FD->env('DB_PREFIX').'news_links L, '.$FD->env('DB_PREFIX').'news N
                    WHERE N.`news_id` = L.`news_id`
                    GROUP BY N.`news_title`
                    ORDER BY `best_news_link_num` DESC
                    LIMIT 0,1' );
    $row = $index->fetch(PDO::FETCH_ASSOC);
    if ($row !== false) {
        $best_news_link = $row['news_title'];
        $best_news_link_num = $row['best_news_link_num'];
    }


    $index = $FD->db()->conn()->query ( "
                    SELECT COUNT(N.`news_id`) AS 'best_news_poster_num', U.`user_name`
                    FROM ".$FD->env('DB_PREFIX').'user U, '.$FD->env('DB_PREFIX').'news N
                    WHERE N.`user_id` = U.`user_id`
                    GROUP BY U.`user_name`
                    ORDER BY `best_news_poster_num` DESC
                    LIMIT 0,1' );
    $row = $index->fetch(PDO::FETCH_ASSOC);
    $best_news_poster =  $row['user_name'];
    $best_news_poster_num = $row['best_news_poster_num'];
}


$index = $FD->db()->conn()->query ( "
                SELECT COUNT(`article_id`) AS 'num_articles'
                FROM ".$FD->env('DB_PREFIX').'articles
                LIMIT 0,1' );
$num_articles = $index->fetchColumn();

$index = $FD->db()->conn()->query ( "
                SELECT COUNT(`cat_id`) AS 'num_articles_cat'
                FROM ".$FD->env('DB_PREFIX').'articles_cat
                LIMIT 0,1' );
$num_articles_cat = $index->fetchColumn();

$index = $FD->db()->conn()->query ( "
                SELECT COUNT(A.`article_id`) AS 'best_article_poster_num', U.`user_name`
                FROM ".$FD->env('DB_PREFIX').'user U, '.$FD->env('DB_PREFIX').'articles A
                WHERE A.`article_user` = U.`user_id`
                AND A.`article_user` > 0
                GROUP BY U.`user_name`
                ORDER BY `best_article_poster_num` DESC
                LIMIT 0,1' );
$row = $index->fetch(PDO::FETCH_ASSOC);
if ( $row !== false ) {
    $best_article_poster = $row['user_name'];
    $best_article_poster_num = $row['best_article_poster_num'];
    settype ( $best_article_poster_num, 'integer' );
}

$index = $FD->db()->conn()->query ( "
                SELECT COUNT(`press_id`) AS 'num_press'
                FROM ".$FD->env('DB_PREFIX').'press
                LIMIT 0,1' );
$num_press = $index->fetchColumn();

if ( $num_press > 0 ) {
    $index = $FD->db()->conn()->query ( "
                    SELECT COUNT(V.`id`) AS 'best_press_lang_num', V.`title`
                    FROM ".$FD->env('DB_PREFIX').'press P, '.$FD->env('DB_PREFIX')."press_admin V
                    WHERE P.`press_lang` = V.`id`
                    AND V.`type` = '3'
                    GROUP BY V.`title`
                    ORDER BY `best_press_lang_num` DESC
                    LIMIT 0,1" );
    $row = $index->fetch(PDO::FETCH_ASSOC);
    $best_press_lang = $row['title'];
    $best_press_lang_num = $row['best_press_lang_num'];
}

// Conditions
$adminpage->addCond('has_news', ($num_news > 0));
$adminpage->addCond('has_best_news_com', ($num_news > 0) && ($num_comments > 0));
$adminpage->addCond('has_best_news_link', ($num_news > 0) && ($best_news_link_num > 0));
$adminpage->addCond('has_best_com_poster', ($num_news > 0) && ($num_comments > 0 && $best_com_poster_rows));
$adminpage->addCond('has_best_article_poster', ($num_articles > 0 && $best_article_poster_num > 0));
$adminpage->addCond('has_press', ($num_press > 0));

// Values
$adminpage->addText('num_news', $num_news);
$adminpage->addText('num_news_cat', $num_news_cat);
$adminpage->addText('num_comments', $num_comments);
$adminpage->addText('num_links', $num_links);
if ($num_news > 0) {
    $adminpage->addText('best_news_cat', $best_news_cat);
    $adminpage->addText('best_news_cat_num', $best_news_cat_num);
    if ($num_comments > 0) {
        $adminpage->addText('best_news_com', $best_news_com);
        $adminpage->addText('best_news_com_num', $best_news_com_num);
    }
    if ( $best_news_link_num > 0 ) {
        $adminpage->addText('best_news_link', $best_news_link);
        $adminpage->addText('best_news_link_num', $best_news_link_num);
    }
    $adminpage->addText('best_news_poster', $best_news_poster);
    $adminpage->addText('best_news_poster_num', $best_news_poster_num);
    if ( $num_comments > 0 && $best_com_poster_rows ) {
        $adminpage->addText('best_com_poster', $best_com_poster);
        $adminpage->addText('best_com_poster_num', $best_com_poster_num);
    }
}
$adminpage->addText('num_articles', $num_articles);
$adminpage->addText('num_articles_cat', $num_articles_cat);
if ( $num_articles > 0 && $best_article_poster_num > 0 ) {
  $adminpage->addText('best_article_poster', $best_article_poster);
  $adminpage->addText('best_article_poster_num', $best_article_poster_num);
}
$adminpage->addText('num_press', $num_press);
if ( $num_press > 0 ) {
  $adminpage->addText('best_press_lang', $best_press_lang);
  $adminpage->addText('best_press_lang_num', $best_press_lang_num);
}

echo $adminpage->get('main');
?>
