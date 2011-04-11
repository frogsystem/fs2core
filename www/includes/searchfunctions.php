<?php
function new_search_index ( $FOR ) {
    delete_search_index ( $FOR );
    update_search_index ( $FOR );
}

function delete_search_index ( $FOR ) {
    global $global_config_arr, $db;
    
    mysql_query ( "
                    DELETE FROM `".$global_config_arr['pref']."search_index`
                    WHERE `search_index_type` = '".$FOR."'
    ", $db );
    mysql_query ( "
                    DELETE FROM `".$global_config_arr['pref']."search_time`
                    WHERE `search_time_type` = '".$FOR."'
    ", $db );
}

function delete_search_index_for_one ( $ID, $TYPE ) {
    global $global_config_arr, $db;

    mysql_query ( "
                    DELETE FROM `".$global_config_arr['pref']."search_index`
                    WHERE `search_index_type` = '".$TYPE."'
                    AND `search_index_document_id` = '".$ID."'
    ", $db );
    mysql_query ( "
                    DELETE FROM `".$global_config_arr['pref']."search_time`
                    WHERE `search_time_type` = '".$TYPE."'
                    AND `search_time_document_id` = '".$$ID."'
    ", $db );
}


function delete_word_list () {
    global $global_config_arr, $db;

    mysql_query ( "
                    TRUNCATE TABLE `".$global_config_arr['pref']."search_words`
    ", $db );
}

function update_search_index ( $FOR ) {
    global $global_config_arr, $db;
    
    $data = get_make_search_index ( $FOR );
    while ( $data_arr = mysql_fetch_assoc ( $data ) ) {
        // Compress Text and filter Stopwords
        $data_arr['search_data'] = delete_stopwords ( compress_search_data ( $data_arr['search_data'] ) );

        // Remove Old Indexes & Update Timestamp
        if ( $data_arr['search_time_id'] != null ) {
             mysql_query ( "
                            DELETE FROM `".$global_config_arr['pref']."search_index`
                            WHERE `search_index_type` = '".$data_arr['search_time_type']."'
                            AND `search_index_document_id` = ".$data_arr['search_time_document_id']."
             ", $db );
             mysql_query ( "
                            UPDATE `".$global_config_arr['pref']."search_time`
                            SET `search_time_date` = '".time()."'
                            WHERE `search_time_id` = '".$data_arr['search_time_id']."'
             ", $db );
        } else {
             mysql_query ( "
                            INSERT INTO
                                `".$global_config_arr['pref']."search_time`
                                (`search_time_type`, `search_time_document_id`, `search_time_date`)
                            VALUES (
                                '".$data_arr['search_time_type']."',
                                '".$data_arr['search_time_document_id']."',
                                '".time()."'
                            )
             ", $db );
        }
        
        // Pass through word list
        $word_arr = explode ( " ", $data_arr['search_data'] );
        $index_arr = array();
        foreach ( $word_arr  as $word )  {
            if (strlen ( $word ) > 32) {
                $word = substr ( $word, 0, 32 );
            }
            $word_id = get_search_word_id ( $word );

            if ( isset ( $index_arr[$word_id] ) ) {
                $index_arr[$word_id]["search_index_count"] = $index_arr[$word_id]["search_index_count"] + 1;
            }
            else {
                $index_arr[$word_id]["search_index_word_id" ] = $word_id;
                $index_arr[$word_id]["search_index_type"] = $data_arr['search_time_type'];
                $index_arr[$word_id]["search_index_document_id"] = $data_arr['search_time_document_id'];
                $index_arr[$word_id]["search_index_count" ] = 1;
            }
        }
        sort ( $index_arr );
        
        $insert_values = array();
        foreach ( $index_arr as $word_data ) {
            $insert_values[] = "(".$word_data['search_index_word_id'].", '".$word_data['search_index_type']."', ".$word_data['search_index_document_id'].", ".$word_data['search_index_count']." )";
        }
        
        // Insert Indexes
        mysql_query ( "
                        INSERT INTO
                            `".$global_config_arr['pref']."search_index`
                            (`search_index_word_id`, `search_index_type`, `search_index_document_id`, `search_index_count`)
                        VALUES
                            " . implode ( ",", $insert_values ) . "
        ", $db );
    }
}


function get_make_search_index ( $FOR ) {
    global $global_config_arr, $db;

    switch ( $FOR ) {
        case "dl":
            // DL
            return mysql_query ( "
                SELECT
                    `dl_id` AS 'search_time_document_id',
                    `search_time_id`,
                    'dl' AS 'search_time_type',
                    CONCAT(`dl_name`, ' ', `dl_text`) AS 'search_data'
                FROM `".$global_config_arr['pref']."dl`
                LEFT JOIN `".$global_config_arr['pref']."search_time`
                    ON `search_time_document_id` = `dl_id`
                    AND FIND_IN_SET('dl', `search_time_type`)
                WHERE 1
                    AND ( `search_time_id` IS NULL OR `dl_search_update` > `search_time_date` )
                ORDER BY `dl_search_update`
            ", $db );
            break;
        case "articles":
            // Articles
            return mysql_query ( "
                SELECT
                    `article_id` AS 'search_time_document_id',
                    `search_time_id`,
                    'articles' AS 'search_time_type',
                    CONCAT(`article_title`, ' ', `article_text`) AS 'search_data'
                FROM `".$global_config_arr['pref']."articles`
                LEFT JOIN `".$global_config_arr['pref']."search_time`
                    ON `search_time_document_id` = `article_id`
                    AND FIND_IN_SET('articles', `search_time_type`)
                WHERE 1
                    AND ( `search_time_id` IS NULL OR `article_search_update` > `search_time_date` )
                ORDER BY `article_search_update`
            ", $db );
            break;
        case "news":
            // News
            return mysql_query ( "
                SELECT
                    `news_id` AS 'search_time_document_id',
                    `search_time_id`,
                    'news' AS 'search_time_type',
                    CONCAT(`news_title`, ' ', `news_text`) AS 'search_data'
                FROM `".$global_config_arr['pref']."news`
                LEFT JOIN `".$global_config_arr['pref']."search_time`
                    ON `search_time_document_id` = `news_id`
                    AND FIND_IN_SET('news', `search_time_type`)
                WHERE 1
                    AND ( `search_time_id` IS NULL OR `news_search_update` > `search_time_date` )
                ORDER BY `news_search_update`
            ", $db );
            break;
    }
}

function get_search_word_id ( $WORD ) {
    global $global_config_arr, $db;
    
    $index = mysql_query ( "
                            SELECT `search_word_id` FROM `".$global_config_arr['pref']."search_words`
                            WHERE `search_word` = '".savesql ( $WORD )."'
    ", $db );
    if ( mysql_num_rows ( $index ) >= 1 ) {
        return mysql_result ( $index, 0, "search_word_id" );
    } else {
        mysql_query ( "
                        INSERT INTO `".$global_config_arr['pref']."search_words` (`search_word`)
                        VALUES ('".savesql ( $WORD )."')
        ", $db );
        return mysql_insert_id ( $db );
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
    #$locSearch[] = "=([0-9/.,+-]*\s)=";
    $locSearch[] = "=([^A-Za-z])=";
    $locSearch[] = "= +=";

    $locReplace[] = "ss";
    $locReplace[] = "ae";
    $locReplace[] = "oe";
    $locReplace[] = "ue";
    $locReplace[] = "a";
    $locReplace[] = "o";
    $locReplace[] = "u";
    $locReplace[] = "e";
    $locReplace[] = "i";
    $locReplace[] = "n";
    $locReplace[] = "c";
    #$locReplace[] = " ";
    $locReplace[] = " ";
    $locReplace[] = " ";

    $TEXT = trim ( strtolower ( stripslashes ( killfs ( $TEXT ) ) ) );
    $TEXT = preg_replace ( $locSearch, $locReplace, $TEXT );
    return $TEXT;
}

function delete_stopwords ( $TEXT ) {
    $locSearch[] = "=(\s[A-Za-z0-9]{1,2})\s=";
    $locSearch[] = "= " . implode ( " | ", get_stopwords () ) . " =i";
    $locSearch[] = "= +=";

    $locReplace[] = " ";
    $locReplace[] = " ";
    $locReplace[] = " ";

    $TEXT = " " . str_replace ( " ", "  ", $TEXT ) . " ";
    $TEXT = trim ( preg_replace ( $locSearch, $locReplace, $TEXT ) );
    return $TEXT;
}


function get_stopwords () {
    $stopwords["de"][] = "aber";
    $stopwords["de"][] = "alle";
    $stopwords["de"][] = "allen";
    $stopwords["de"][] = "alles";
    $stopwords["de"][] = "als";
    $stopwords["de"][] = "also";
    $stopwords["de"][] = "andere";
    $stopwords["de"][] = "anderem";
    $stopwords["de"][] = "anderer";
    $stopwords["de"][] = "anderes";
    $stopwords["de"][] = "anders";
    $stopwords["de"][] = "auch";
    $stopwords["de"][] = "auf";
    $stopwords["de"][] = "aus";
    $stopwords["de"][] = "ausser";
    $stopwords["de"][] = "ausserdem";
    $stopwords["de"][] = "bei";
    $stopwords["de"][] = "beide";
    $stopwords["de"][] = "beiden";
    $stopwords["de"][] = "beides";
    $stopwords["de"][] = "beim";
    $stopwords["de"][] = "bereits";
    $stopwords["de"][] = "bestehen";
    $stopwords["de"][] = "besteht";
    $stopwords["de"][] = "bevor";
    $stopwords["de"][] = "bin";
    $stopwords["de"][] = "bis";
    $stopwords["de"][] = "bloss";
    $stopwords["de"][] = "brauchen";
    $stopwords["de"][] = "braucht";
    $stopwords["de"][] = "dabei";
    $stopwords["de"][] = "dadurch";
    $stopwords["de"][] = "dagegen";
    $stopwords["de"][] = "daher";
    $stopwords["de"][] = "damit";
    $stopwords["de"][] = "danach";
    $stopwords["de"][] = "dann";
    $stopwords["de"][] = "darf";
    $stopwords["de"][] = "darueber";
    $stopwords["de"][] = "darum";
    $stopwords["de"][] = "darunter";
    $stopwords["de"][] = "das";
    $stopwords["de"][] = "dass";
    $stopwords["de"][] = "davon";
    $stopwords["de"][] = "dazu";
    $stopwords["de"][] = "dem";
    $stopwords["de"][] = "den";
    $stopwords["de"][] = "denn";
    $stopwords["de"][] = "der";
    $stopwords["de"][] = "des";
    $stopwords["de"][] = "deshalb";
    $stopwords["de"][] = "dessen";
    $stopwords["de"][] = "die";
    $stopwords["de"][] = "dies";
    $stopwords["de"][] = "diese";
    $stopwords["de"][] = "diesem";
    $stopwords["de"][] = "diesen";
    $stopwords["de"][] = "dieser";
    $stopwords["de"][] = "dieses";
    $stopwords["de"][] = "doch";
    $stopwords["de"][] = "dort";
    $stopwords["de"][] = "duerfen";
    $stopwords["de"][] = "durch";
    $stopwords["de"][] = "durfte";
    $stopwords["de"][] = "durften";
    $stopwords["de"][] = "ebenfalls";
    $stopwords["de"][] = "ebenso";
    $stopwords["de"][] = "ein";
    $stopwords["de"][] = "eine";
    $stopwords["de"][] = "einem";
    $stopwords["de"][] = "einen";
    $stopwords["de"][] = "einer";
    $stopwords["de"][] = "eines";
    $stopwords["de"][] = "einige";
    $stopwords["de"][] = "einiges";
    $stopwords["de"][] = "einzig";
    $stopwords["de"][] = "entweder";
    $stopwords["de"][] = "erst";
    $stopwords["de"][] = "erste";
    $stopwords["de"][] = "ersten";
    $stopwords["de"][] = "etwa";
    $stopwords["de"][] = "etwas";
    $stopwords["de"][] = "falls";
    $stopwords["de"][] = "fast";
    $stopwords["de"][] = "ferner";
    $stopwords["de"][] = "folgender";
    $stopwords["de"][] = "folglich";
    $stopwords["de"][] = "fuer";
    $stopwords["de"][] = "ganz";
    $stopwords["de"][] = "geben";
    $stopwords["de"][] = "gegen";
    $stopwords["de"][] = "gehabt";
    $stopwords["de"][] = "gekonnt";
    $stopwords["de"][] = "gemaess";
    $stopwords["de"][] = "getan";
    $stopwords["de"][] = "gewesen";
    $stopwords["de"][] = "gewollt";
    $stopwords["de"][] = "geworden";
    $stopwords["de"][] = "gibt";
    $stopwords["de"][] = "habe";
    $stopwords["de"][] = "haben";
    $stopwords["de"][] = "haette";
    $stopwords["de"][] = "haetten";
    $stopwords["de"][] = "hallo";
    $stopwords["de"][] = "hat";
    $stopwords["de"][] = "hatte";
    $stopwords["de"][] = "hatten";
    $stopwords["de"][] = "heraus";
    $stopwords["de"][] = "herein";
    $stopwords["de"][] = "hier";
    $stopwords["de"][] = "hin";
    $stopwords["de"][] = "hinein";
    $stopwords["de"][] = "hinter";
    $stopwords["de"][] = "ich";
    $stopwords["de"][] = "ihm";
    $stopwords["de"][] = "ihn";
    $stopwords["de"][] = "ihnen";
    $stopwords["de"][] = "ihr";
    $stopwords["de"][] = "ihre";
    $stopwords["de"][] = "ihrem";
    $stopwords["de"][] = "ihren";
    $stopwords["de"][] = "ihres";
    $stopwords["de"][] = "immer";
    $stopwords["de"][] = "indem";
    $stopwords["de"][] = "infolge";
    $stopwords["de"][] = "innen";
    $stopwords["de"][] = "innerhalb";
    $stopwords["de"][] = "ins";
    $stopwords["de"][] = "inzwischen";
    $stopwords["de"][] = "irgend";
    $stopwords["de"][] = "irgendwas";
    $stopwords["de"][] = "irgendwen";
    $stopwords["de"][] = "irgendwer";
    $stopwords["de"][] = "irgendwie";
    $stopwords["de"][] = "irgendwo";
    $stopwords["de"][] = "ist";
    $stopwords["de"][] = "jede";
    $stopwords["de"][] = "jedem";
    $stopwords["de"][] = "jeden";
    $stopwords["de"][] = "jeder";
    $stopwords["de"][] = "jedes";
    $stopwords["de"][] = "jedoch";
    $stopwords["de"][] = "jene";
    $stopwords["de"][] = "jenem";
    $stopwords["de"][] = "jenen";
    $stopwords["de"][] = "jener";
    $stopwords["de"][] = "jenes";
    $stopwords["de"][] = "kann";
    $stopwords["de"][] = "kein";
    $stopwords["de"][] = "keine";
    $stopwords["de"][] = "keinem";
    $stopwords["de"][] = "keinen";
    $stopwords["de"][] = "keiner";
    $stopwords["de"][] = "keines";
    $stopwords["de"][] = "koennen";
    $stopwords["de"][] = "koennte";
    $stopwords["de"][] = "koennten";
    $stopwords["de"][] = "konnte";
    $stopwords["de"][] = "konnten";
    $stopwords["de"][] = "kuenftig";
    $stopwords["de"][] = "leer";
    $stopwords["de"][] = "machen";
    $stopwords["de"][] = "macht";
    $stopwords["de"][] = "machte";
    $stopwords["de"][] = "machten";
    $stopwords["de"][] = "man";
    $stopwords["de"][] = "mehr";
    $stopwords["de"][] = "mein";
    $stopwords["de"][] = "meine";
    $stopwords["de"][] = "meinen";
    $stopwords["de"][] = "meinem";
    $stopwords["de"][] = "meiner";
    $stopwords["de"][] = "meist";
    $stopwords["de"][] = "meiste";
    $stopwords["de"][] = "meisten";
    $stopwords["de"][] = "mich";
    $stopwords["de"][] = "mit";
    $stopwords["de"][] = "moechte";
    $stopwords["de"][] = "moechten";
    $stopwords["de"][] = "muessen";
    $stopwords["de"][] = "muessten";
    $stopwords["de"][] = "muss";
    $stopwords["de"][] = "musste";
    $stopwords["de"][] = "mussten";
    $stopwords["de"][] = "nach";
    $stopwords["de"][] = "nachdem";
    $stopwords["de"][] = "nacher";
    $stopwords["de"][] = "naemlich";
    $stopwords["de"][] = "neben";
    $stopwords["de"][] = "nein";
    $stopwords["de"][] = "nicht";
    $stopwords["de"][] = "nichts";
    $stopwords["de"][] = "noch";
    $stopwords["de"][] = "nuetzt";
    $stopwords["de"][] = "nur";
    $stopwords["de"][] = "nutzt";
    $stopwords["de"][] = "obgleich";
    $stopwords["de"][] = "obwohl";
    $stopwords["de"][] = "oder";
    $stopwords["de"][] = "ohne";
    $stopwords["de"][] = "per";
    $stopwords["de"][] = "pro";
    $stopwords["de"][] = "rund";
    $stopwords["de"][] = "schon";
    $stopwords["de"][] = "sehr";
    $stopwords["de"][] = "seid";
    $stopwords["de"][] = "sein";
    $stopwords["de"][] = "seine";
    $stopwords["de"][] = "seinem";
    $stopwords["de"][] = "seinen";
    $stopwords["de"][] = "seiner";
    $stopwords["de"][] = "seit";
    $stopwords["de"][] = "seitdem";
    $stopwords["de"][] = "seither";
    $stopwords["de"][] = "selber";
    $stopwords["de"][] = "sich";
    $stopwords["de"][] = "sie";
    $stopwords["de"][] = "siehe";
    $stopwords["de"][] = "sind";
    $stopwords["de"][] = "sobald";
    $stopwords["de"][] = "solange";
    $stopwords["de"][] = "solch";
    $stopwords["de"][] = "solche";
    $stopwords["de"][] = "solchem";
    $stopwords["de"][] = "solchen";
    $stopwords["de"][] = "solcher";
    $stopwords["de"][] = "solches";
    $stopwords["de"][] = "soll";
    $stopwords["de"][] = "sollen";
    $stopwords["de"][] = "sollte";
    $stopwords["de"][] = "sollten";
    $stopwords["de"][] = "somit";
    $stopwords["de"][] = "sondern";
    $stopwords["de"][] = "soweit";
    $stopwords["de"][] = "sowie";
    $stopwords["de"][] = "spaeter";
    $stopwords["de"][] = "stets";
    $stopwords["de"][] = "such";
    $stopwords["de"][] = "ueber";
    $stopwords["de"][] = "ums";
    $stopwords["de"][] = "und";
    $stopwords["de"][] = "uns";
    $stopwords["de"][] = "unser";
    $stopwords["de"][] = "unsere";
    $stopwords["de"][] = "unserem";
    $stopwords["de"][] = "unseren";
    $stopwords["de"][] = "viel";
    $stopwords["de"][] = "viele";
    $stopwords["de"][] = "vollstaendig";
    $stopwords["de"][] = "vom";
    $stopwords["de"][] = "von";
    $stopwords["de"][] = "vor";
    $stopwords["de"][] = "vorbei";
    $stopwords["de"][] = "vorher";
    $stopwords["de"][] = "vorueber";
    $stopwords["de"][] = "waehrend";
    $stopwords["de"][] = "waere";
    $stopwords["de"][] = "waeren";
    $stopwords["de"][] = "wann";
    $stopwords["de"][] = "war";
    $stopwords["de"][] = "waren";
    $stopwords["de"][] = "warum";
    $stopwords["de"][] = "was";
    $stopwords["de"][] = "wegen";
    $stopwords["de"][] = "weil";
    $stopwords["de"][] = "weiter";
    $stopwords["de"][] = "weitere";
    $stopwords["de"][] = "weiterem";
    $stopwords["de"][] = "weiteren";
    $stopwords["de"][] = "weiterer";
    $stopwords["de"][] = "weiteres";
    $stopwords["de"][] = "weiterhin";
    $stopwords["de"][] = "welche";
    $stopwords["de"][] = "welchem";
    $stopwords["de"][] = "welchen";
    $stopwords["de"][] = "welcher";
    $stopwords["de"][] = "welches";
    $stopwords["de"][] = "wem";
    $stopwords["de"][] = "wen";
    $stopwords["de"][] = "wenigstens";
    $stopwords["de"][] = "wenn";
    $stopwords["de"][] = "wenngleich";
    $stopwords["de"][] = "wer";
    $stopwords["de"][] = "werde";
    $stopwords["de"][] = "werden";
    $stopwords["de"][] = "weshalb";
    $stopwords["de"][] = "wessen";
    $stopwords["de"][] = "wie";
    $stopwords["de"][] = "wieder";
    $stopwords["de"][] = "will";
    $stopwords["de"][] = "wir";
    $stopwords["de"][] = "wird";
    $stopwords["de"][] = "wodurch";
    $stopwords["de"][] = "wohin";
    $stopwords["de"][] = "wollen";
    $stopwords["de"][] = "wollte";
    $stopwords["de"][] = "wollten";
    $stopwords["de"][] = "worin";
    $stopwords["de"][] = "wuerde";
    $stopwords["de"][] = "wuerden";
    $stopwords["de"][] = "wurde";
    $stopwords["de"][] = "wurden";
    $stopwords["de"][] = "zufolge";
    $stopwords["de"][] = "zum";
    $stopwords["de"][] = "zusammen";
    $stopwords["de"][] = "zur";
    $stopwords["de"][] = "zwar";
    $stopwords["de"][] = "zwischen";
    
    $stopwords["en"][] = "about";
    $stopwords["en"][] = "above";
    $stopwords["en"][] = "across";
    $stopwords["en"][] = "after";
    $stopwords["en"][] = "afterwards";
    $stopwords["en"][] = "again";
    $stopwords["en"][] = "against";
    $stopwords["en"][] = "albeit";
    $stopwords["en"][] = "all";
    $stopwords["en"][] = "almost";
    $stopwords["en"][] = "alone";
    $stopwords["en"][] = "along";
    $stopwords["en"][] = "already";
    $stopwords["en"][] = "also";
    $stopwords["en"][] = "although";
    $stopwords["en"][] = "always";
    $stopwords["en"][] = "among";
    $stopwords["en"][] = "amongst";
    $stopwords["en"][] = "and";
    $stopwords["en"][] = "another";
    $stopwords["en"][] = "any";
    $stopwords["en"][] = "anyhow";
    $stopwords["en"][] = "anyone";
    $stopwords["en"][] = "anything";
    $stopwords["en"][] = "anywhere";
    $stopwords["en"][] = "are";
    $stopwords["en"][] = "around";
    $stopwords["en"][] = "became";
    $stopwords["en"][] = "because";
    $stopwords["en"][] = "become";
    $stopwords["en"][] = "becomes";
    $stopwords["en"][] = "becoming";
    $stopwords["en"][] = "been";
    $stopwords["en"][] = "before";
    $stopwords["en"][] = "beforehand";
    $stopwords["en"][] = "behind";
    $stopwords["en"][] = "being";
    $stopwords["en"][] = "below";
    $stopwords["en"][] = "beside";
    $stopwords["en"][] = "besides";
    $stopwords["en"][] = "between";
    $stopwords["en"][] = "beyond";
    $stopwords["en"][] = "both";
    $stopwords["en"][] = "but";
    $stopwords["en"][] = "cannot";
    $stopwords["en"][] = "comprises";
    $stopwords["en"][] = "corresponding";
    $stopwords["en"][] = "could";
    $stopwords["en"][] = "described";
    $stopwords["en"][] = "desired";
    $stopwords["en"][] = "does";
    $stopwords["en"][] = "down";
    $stopwords["en"][] = "during";
    $stopwords["en"][] = "each";
    $stopwords["en"][] = "either";
    $stopwords["en"][] = "else";
    $stopwords["en"][] = "elsewhere";
    $stopwords["en"][] = "enough";
    $stopwords["en"][] = "etc";
    $stopwords["en"][] = "even";
    $stopwords["en"][] = "ever";
    $stopwords["en"][] = "every";
    $stopwords["en"][] = "everyone";
    $stopwords["en"][] = "everything";
    $stopwords["en"][] = "everywhere";
    $stopwords["en"][] = "except";
    $stopwords["en"][] = "few";
    $stopwords["en"][] = "first";
    $stopwords["en"][] = "for";
    $stopwords["en"][] = "former";
    $stopwords["en"][] = "formerly";
    $stopwords["en"][] = "from";
    $stopwords["en"][] = "further";
    $stopwords["en"][] = "generally";
    $stopwords["en"][] = "had";
    $stopwords["en"][] = "has";
    $stopwords["en"][] = "have";
    $stopwords["en"][] = "having";
    $stopwords["en"][] = "hence";
    $stopwords["en"][] = "her";
    $stopwords["en"][] = "here";
    $stopwords["en"][] = "hereafter";
    $stopwords["en"][] = "hereby";
    $stopwords["en"][] = "herein";
    $stopwords["en"][] = "hereupon";
    $stopwords["en"][] = "hers";
    $stopwords["en"][] = "herself";
    $stopwords["en"][] = "him";
    $stopwords["en"][] = "himself";
    $stopwords["en"][] = "his";
    $stopwords["en"][] = "how";
    $stopwords["en"][] = "however";
    $stopwords["en"][] = "indeed";
    $stopwords["en"][] = "into";
    $stopwords["en"][] = "its";
    $stopwords["en"][] = "itself";
    $stopwords["en"][] = "last";
    $stopwords["en"][] = "latter";
    $stopwords["en"][] = "latterly";
    $stopwords["en"][] = "least";
    $stopwords["en"][] = "less";
    $stopwords["en"][] = "many";
    $stopwords["en"][] = "may";
    $stopwords["en"][] = "means";
    $stopwords["en"][] = "meanwhile";
    $stopwords["en"][] = "might";
    $stopwords["en"][] = "more";
    $stopwords["en"][] = "moreover";
    $stopwords["en"][] = "most";
    $stopwords["en"][] = "mostly";
    $stopwords["en"][] = "much";
    $stopwords["en"][] = "must";
    $stopwords["en"][] = "myself";
    $stopwords["en"][] = "namely";
    $stopwords["en"][] = "neither";
    $stopwords["en"][] = "never";
    $stopwords["en"][] = "nevertheless";
    $stopwords["en"][] = "next";
    $stopwords["en"][] = "nobody";
    $stopwords["en"][] = "none";
    $stopwords["en"][] = "noone";
    $stopwords["en"][] = "nor";
    $stopwords["en"][] = "not";
    $stopwords["en"][] = "nothing";
    $stopwords["en"][] = "now";
    $stopwords["en"][] = "nowhere";
    $stopwords["en"][] = "off";
    $stopwords["en"][] = "often";
    $stopwords["en"][] = "once";
    $stopwords["en"][] = "one";
    $stopwords["en"][] = "only";
    $stopwords["en"][] = "onto";
    $stopwords["en"][] = "other";
    $stopwords["en"][] = "others";
    $stopwords["en"][] = "otherwise";
    $stopwords["en"][] = "our";
    $stopwords["en"][] = "ours";
    $stopwords["en"][] = "ourselves";
    $stopwords["en"][] = "out";
    $stopwords["en"][] = "over";
    $stopwords["en"][] = "own";
    $stopwords["en"][] = "particularly";
    $stopwords["en"][] = "per";
    $stopwords["en"][] = "perhaps";
    $stopwords["en"][] = "preferably";
    $stopwords["en"][] = "preferred";
    $stopwords["en"][] = "present";
    $stopwords["en"][] = "rather";
    $stopwords["en"][] = "relatively";
    $stopwords["en"][] = "respectively";
    $stopwords["en"][] = "said";
    $stopwords["en"][] = "same";
    $stopwords["en"][] = "seem";
    $stopwords["en"][] = "seemed";
    $stopwords["en"][] = "seeming";
    $stopwords["en"][] = "seems";
    $stopwords["en"][] = "several";
    $stopwords["en"][] = "she";
    $stopwords["en"][] = "should";
    $stopwords["en"][] = "since";
    $stopwords["en"][] = "some";
    $stopwords["en"][] = "somehow";
    $stopwords["en"][] = "someone";
    $stopwords["en"][] = "something";
    $stopwords["en"][] = "sometime";
    $stopwords["en"][] = "sometimes";
    $stopwords["en"][] = "somewhere";
    $stopwords["en"][] = "still";
    $stopwords["en"][] = "such";
    $stopwords["en"][] = "suitable";
    $stopwords["en"][] = "than";
    $stopwords["en"][] = "that";
    $stopwords["en"][] = "the";
    $stopwords["en"][] = "their";
    $stopwords["en"][] = "them";
    $stopwords["en"][] = "themselves";
    $stopwords["en"][] = "then";
    $stopwords["en"][] = "thence";
    $stopwords["en"][] = "there";
    $stopwords["en"][] = "thereafter";
    $stopwords["en"][] = "thereby";
    $stopwords["en"][] = "therefor";
    $stopwords["en"][] = "therefore";
    $stopwords["en"][] = "therein";
    $stopwords["en"][] = "thereof";
    $stopwords["en"][] = "thereto";
    $stopwords["en"][] = "thereupon";
    $stopwords["en"][] = "these";
    $stopwords["en"][] = "they";
    $stopwords["en"][] = "this";
    $stopwords["en"][] = "those";
    $stopwords["en"][] = "though";
    $stopwords["en"][] = "through";
    $stopwords["en"][] = "throughout";
    $stopwords["en"][] = "thru";
    $stopwords["en"][] = "thus";
    $stopwords["en"][] = "together";
    $stopwords["en"][] = "too";
    $stopwords["en"][] = "toward";
    $stopwords["en"][] = "towards";
    $stopwords["en"][] = "under";
    $stopwords["en"][] = "until";
    $stopwords["en"][] = "upon";
    $stopwords["en"][] = "use";
    $stopwords["en"][] = "various";
    $stopwords["en"][] = "very";
    $stopwords["en"][] = "was";
    $stopwords["en"][] = "well";
    $stopwords["en"][] = "were";
    $stopwords["en"][] = "what";
    $stopwords["en"][] = "whatever";
    $stopwords["en"][] = "whatsoever";
    $stopwords["en"][] = "when";
    $stopwords["en"][] = "whence";
    $stopwords["en"][] = "whenever";
    $stopwords["en"][] = "whensoever";
    $stopwords["en"][] = "where";
    $stopwords["en"][] = "whereafter";
    $stopwords["en"][] = "whereas";
    $stopwords["en"][] = "whereat";
    $stopwords["en"][] = "whereby";
    $stopwords["en"][] = "wherefrom";
    $stopwords["en"][] = "wherein";
    $stopwords["en"][] = "whereinto";
    $stopwords["en"][] = "whereof";
    $stopwords["en"][] = "whereon";
    $stopwords["en"][] = "whereto";
    $stopwords["en"][] = "whereunto";
    $stopwords["en"][] = "whereupon";
    $stopwords["en"][] = "wherever";
    $stopwords["en"][] = "wherewith";
    $stopwords["en"][] = "whether";
    $stopwords["en"][] = "which";
    $stopwords["en"][] = "whichever";
    $stopwords["en"][] = "whichsoever";
    $stopwords["en"][] = "while";
    $stopwords["en"][] = "whilst";
    $stopwords["en"][] = "whither";
    $stopwords["en"][] = "who";
    $stopwords["en"][] = "whoever";
    $stopwords["en"][] = "whole";
    $stopwords["en"][] = "whom";
    $stopwords["en"][] = "whomever";
    $stopwords["en"][] = "whomsoever";
    $stopwords["en"][] = "whose";
    $stopwords["en"][] = "whosoever";
    $stopwords["en"][] = "why";
    $stopwords["en"][] = "will";
    $stopwords["en"][] = "with";
    $stopwords["en"][] = "within";
    $stopwords["en"][] = "without";
    $stopwords["en"][] = "would";
    $stopwords["en"][] = "yet";
    $stopwords["en"][] = "you";
    $stopwords["en"][] = "your";
    $stopwords["en"][] = "yours";
    $stopwords["en"][] = "yourself";
    $stopwords["en"][] = "yourselves";
    
    $return_arr = array ();
    foreach ( $stopwords as $lang ) {
        $return_arr = array_merge ( $return_arr, $lang );
    }
    return $return_arr;
}
?>