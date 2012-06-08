<?php
function get_default_operators () {
    global $sql;
    $config_arr = $sql->getById('search_config', array('search_and', 'search_or', 'search_xor', 'search_not', 'search_wildcard'), 1);

    $and = explode(',', $config_arr['search_and']);
    $or  = explode(',', $config_arr['search_or']);
    $xor = explode(',', $config_arr['search_xor']);
    $not = explode(',', $config_arr['search_not']);
    $wc  = explode(',', $config_arr['search_wildcard']);

    $ops = array(
        'and' => trim(array_shift($and)),
        'or'  => trim(array_shift($or)),
        'xor' => trim(array_shift($xor)),
        'not' => trim(array_shift($not)),
        'wildcard' => trim(array_shift($wc))
    );

    return $ops;
}


function new_search_index ( $FOR ) {
    delete_search_index ( $FOR );
    update_search_index ( $FOR );
}

function delete_search_index ( $FOR ) {
    global $global_config_arr, $FD;

    mysql_query ( '
                    DELETE FROM `'.$global_config_arr['pref']."search_index`
                    WHERE `search_index_type` = '".$FOR."'
    ", $FD->sql()->conn() );
    mysql_query ( '
                    DELETE FROM `'.$global_config_arr['pref']."search_time`
                    WHERE `search_time_type` = '".$FOR."'
    ", $FD->sql()->conn() );
}

function delete_search_index_for_one ( $ID, $TYPE ) {
    global $global_config_arr, $FD;

    mysql_query ( '
                    DELETE FROM `'.$global_config_arr['pref']."search_index`
                    WHERE `search_index_type` = '".$TYPE."'
                    AND `search_index_document_id` = '".$ID."'
    ", $FD->sql()->conn() );
    mysql_query ( '
                    DELETE FROM `'.$global_config_arr['pref']."search_time`
                    WHERE `search_time_type` = '".$TYPE."'
                    AND `search_time_document_id` = '".$$ID."'
    ", $FD->sql()->conn() );
}


function delete_word_list () {
    global $global_config_arr, $FD;

    mysql_query ( '
                    TRUNCATE TABLE `'.$global_config_arr['pref'].'search_words`
    ', $FD->sql()->conn() );
}

function update_search_index ( $FOR ) {
    global $global_config_arr, $FD;

    $data = get_make_search_index ( $FOR );
    while ( $data_arr = mysql_fetch_assoc ( $data ) ) {
        // Compress Text and filter Stopwords
        $data_arr['search_data'] = delete_stopwords ( compress_search_data ( $data_arr['search_data'] ) );

        // Remove Old Indexes & Update Timestamp
        if ( $data_arr['search_time_id'] != null ) {
             mysql_query ( '
                            DELETE FROM `'.$global_config_arr['pref']."search_index`
                            WHERE `search_index_type` = '".$data_arr['search_time_type']."'
                            AND `search_index_document_id` = ".$data_arr['search_time_document_id']."
             ", $FD->sql()->conn() );
             mysql_query ( '
                            UPDATE `'.$global_config_arr['pref']."search_time`
                            SET `search_time_date` = '".time()."'
                            WHERE `search_time_id` = '".$data_arr['search_time_id']."'
             ", $FD->sql()->conn() );
        } else {
             mysql_query ( '
                            INSERT INTO
                                `'.$global_config_arr['pref']."search_time`
                                (`search_time_type`, `search_time_document_id`, `search_time_date`)
                            VALUES (
                                '".$data_arr['search_time_type']."',
                                '".$data_arr['search_time_document_id']."',
                                '".time()."'
                            )
             ", $FD->sql()->conn() );
        }

        // Pass through word list
        $word_arr = explode ( ' ', $data_arr['search_data'] );
        $index_arr = array();
        foreach ( $word_arr  as $word )  {
            if (strlen ( $word ) > 32) {
                $word = substr ( $word, 0, 32 );
            }
            $word_id = get_search_word_id ( $word );

            if ( isset ( $index_arr[$word_id] ) ) {
                $index_arr[$word_id]['search_index_count'] = $index_arr[$word_id]['search_index_count'] + 1;
            }
            else {
                $index_arr[$word_id]['search_index_word_id' ] = $word_id;
                $index_arr[$word_id]['search_index_type'] = $data_arr['search_time_type'];
                $index_arr[$word_id]['search_index_document_id'] = $data_arr['search_time_document_id'];
                $index_arr[$word_id]['search_index_count'] = 1;
            }
        }
        sort ( $index_arr );

        $insert_values = array();
        foreach ( $index_arr as $word_data ) {
            $insert_values[] = '('.$word_data['search_index_word_id'].", '".$word_data['search_index_type']."', ".$word_data['search_index_document_id'].', '.$word_data['search_index_count'].' )';
        }

        // Insert Indexes
        mysql_query ( '
                        INSERT INTO
                            `'.$global_config_arr['pref'].'search_index`
                            (`search_index_word_id`, `search_index_type`, `search_index_document_id`, `search_index_count`)
                        VALUES
                            ' . implode ( ',', $insert_values ) . '
        ', $FD->sql()->conn() );
    }
}


function get_make_search_index ( $FOR ) {
    global $global_config_arr, $FD;

    switch ( $FOR ) {
        case 'dl':
            // DL
            return mysql_query ( "
                SELECT
                    `dl_id` AS 'search_time_document_id',
                    `search_time_id`,
                    'dl' AS 'search_time_type',
                    CONCAT(`dl_name`, ' ', `dl_text`) AS 'search_data'
                FROM `".$global_config_arr['pref'].'dl`
                LEFT JOIN `'.$global_config_arr['pref']."search_time`
                    ON `search_time_document_id` = `dl_id`
                    AND FIND_IN_SET('dl', `search_time_type`)
                WHERE 1
                    AND ( `search_time_id` IS NULL OR `dl_search_update` > `search_time_date` )
                ORDER BY `dl_search_update`
            ", $FD->sql()->conn() );
            break;
        case 'articles':
            // Articles
            return mysql_query ( "
                SELECT
                    `article_id` AS 'search_time_document_id',
                    `search_time_id`,
                    'articles' AS 'search_time_type',
                    CONCAT(`article_title`, ' ', `article_text`) AS 'search_data'
                FROM `".$global_config_arr['pref'].'articles`
                LEFT JOIN `'.$global_config_arr['pref']."search_time`
                    ON `search_time_document_id` = `article_id`
                    AND FIND_IN_SET('articles', `search_time_type`)
                WHERE 1
                    AND ( `search_time_id` IS NULL OR `article_search_update` > `search_time_date` )
                ORDER BY `article_search_update`
            ", $FD->sql()->conn() );
            break;
        case 'news':
            // News
            return mysql_query ( "
                SELECT
                    `news_id` AS 'search_time_document_id',
                    `search_time_id`,
                    'news' AS 'search_time_type',
                    CONCAT(`news_title`, ' ', `news_text`) AS 'search_data'
                FROM `".$global_config_arr['pref'].'news`
                LEFT JOIN `'.$global_config_arr['pref']."search_time`
                    ON `search_time_document_id` = `news_id`
                    AND FIND_IN_SET('news', `search_time_type`)
                WHERE 1
                    AND ( `search_time_id` IS NULL OR `news_search_update` > `search_time_date` )
                ORDER BY `news_search_update`
            ", $FD->sql()->conn() );
            break;
    }
}

function get_search_word_id ( $WORD ) {
    global $global_config_arr, $FD;

    $index = mysql_query ( '
                            SELECT `search_word_id` FROM `'.$global_config_arr['pref']."search_words`
                            WHERE `search_word` = '".savesql ( $WORD )."'
    ", $FD->sql()->conn() );
    if ( mysql_num_rows ( $index ) >= 1 ) {
        return mysql_result ( $index, 0, 'search_word_id' );
    } else {
        mysql_query ( '
                        INSERT INTO `'.$global_config_arr['pref']."search_words` (`search_word`)
                        VALUES ('".savesql ( $WORD )."')
        ", $FD->sql()->conn() );
        return mysql_insert_id ( $FD->sql()->conn() );
    }
}

function compress_search_data ( $TEXT ) {
    $locSearch[] = "=ß=i";
    $locSearch[] = "=ä|Ä=i";
    $locSearch[] = "=ö|Ö=i";
    $locSearch[] = "=ü|Ü=i";
    $locSearch[] = "=á|à|â|Â|Á|À=i";
    $locSearch[] = "=ó|ò|ô|Ô|Ó|Ò=i";
    $locSearch[] = "=ú|ù|û|Û|Ú|Ù=i";
    $locSearch[] = "=é|è|ê|Ê|É|È|ë=i";
    $locSearch[] = "=í|ì|î|Î|Í|Ì|ï=i";
    $locSearch[] = "=ñ=i";
    $locSearch[] = "=ç=i";
    $locSearch[] = "=([0-9/.,+-]*\s)=";
    $locSearch[] = "=([^A-Za-z])=";
    $locSearch[] = "=\s+=";

    $locReplace[] = 'ss';
    $locReplace[] = 'ae';
    $locReplace[] = 'oe';
    $locReplace[] = 'ue';
    $locReplace[] = 'a';
    $locReplace[] = 'o';
    $locReplace[] = 'u';
    $locReplace[] = 'e';
    $locReplace[] = 'i';
    $locReplace[] = 'n';
    $locReplace[] = 'c';
    $locReplace[] = ' ';
    $locReplace[] = ' ';
    $locReplace[] = ' ';

    $TEXT = trim(strtolower (stripslashes (killfs ($TEXT))));
    $TEXT = preg_replace ( $locSearch, $locReplace, $TEXT );
    return $TEXT;
}

function delete_stopwords ($TEXT) {
    global $sql;
    $config_cols = array('search_min_word_length', 'search_use_stopwords');
    $config_arr = $sql->getById('search_config', $config_cols, 1);

    $locSearch = array();
    $locReplace = array();

    $locSearch[] = "=(\s[A-Za-z]{1,".($config_arr['search_min_word_length']-1)."})\s=";
    $locReplace[] = ' ';

    // Use Stopwords?
    if ( $config_arr['search_use_stopwords'] == 1 ) {
        $locSearch[] = '= ' . implode ( ' | ', get_stopwords() ) . " =i";
        $locReplace[] = ' ';
    }

    $locSearch[] = "= +=";
    $locReplace[] = ' ';

    $TEXT = ' '.str_replace (' ','  ', $TEXT).' ';
    $TEXT = trim(preg_replace($locSearch, $locReplace, $TEXT));
    return $TEXT;
}


function get_stopwords () {
    $stopfilespath =  FS2_ROOT_PATH . 'resources/stopwords/';
    $stopfiles = scandir_ext ( $stopfilespath, 'txt' );
    $ACCESS = new fileaccess();

    $return_arr = array ();
    foreach ( $stopfiles as $file ) {
        $return_arr = array_merge ( $return_arr, $ACCESS->getFileArray( $stopfilespath.$file ) );
    }
    return array_map('trim', $return_arr);
}

// fucntion to compare found-data-arrays
function compare_found_data ($v1, $v2) {
    return compare_update_rank($v1, $v2, function ($r1, $r2) {return $r1;});
};

// fucntion to compare found-data-arrays and update rank
function compare_update_rank (&$v1, $v2, $func) {
    if ($v1['id'] > $v2['id'])
        return -1;
    if ($v1['id'] == $v2['id']) {
        $v1['rank'] = $func($v1['rank'], $v2['rank']);
        return 0;
    }
    return 1;
};
?>
