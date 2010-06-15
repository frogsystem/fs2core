<?php
/**
 * @file     class_search.php
 * @folder   /libs
 * @version  0.1
 * @author   Sweil
 *
 * this class is responsible for search operations
 */
class search {

    // Set Class Consts


    // Set Class Vars
    private $theConfig;
    private $theSql;
    private $searchTypes = array ( "news", "articles", "downloads" );

    // constructor
    public function  __construct() {
        // Include global Data
        global $global_config_arr, $sql;
        $this->theConfig = $global_config_arr;
        $this->theSql = $sql;
    }
    
    public function new_search_index ( $FOR ) {
        $this->delete_search_index ( $FOR );
        $this->update_search_index ( $FOR );
    }

    public function delete_search_index ( $FOR ) {
        global $db;

        mysql_query ( "
                        DELETE FROM `".$this->theConfig['pref']."search_index`
                        WHERE `search_index_type` = '".$FOR."'
        ", $db );
        mysql_query ( "
                        DELETE FROM `".$this->theConfig['pref']."search_time`
                        WHERE `search_time_type` = '".$FOR."'
        ", $db );
    }
    
    public function delete_search_index_for_one ( $ID, $TYPE ) {
        global  $db;

        mysql_query ( "
                        DELETE FROM `".$this->theConfig['pref']."search_index`
                        WHERE `search_index_type` = '".$TYPE."'
                        AND `search_index_document_id` = '".$ID."'
        ", $db );
        mysql_query ( "
                        DELETE FROM `".$this->theConfig['pref']."search_time`
                        WHERE `search_time_type` = '".$TYPE."'
                        AND `search_time_document_id` = '".$$ID."'
        ", $db );
    }


    public function delete_word_list () {
        global  $db;

        mysql_query ( "
                        TRUNCATE TABLE `".$this->theConfig['pref']."search_words`
        ", $db );
    }

    public function update_search_index ( $FOR ) {
        global  $db;

        $data = $this->get_make_search_index ( $FOR );
        while ( $data_arr = mysql_fetch_assoc ( $data ) ) {
            // Compress Text and filter Stopwords
            $data_arr['search_data'] = $this->delete_stopwords ( $this->compress_search_data ( $data_arr['search_data'] ) );

            // Remove Old Indexes & Update Timestamp
            if ( $data_arr['search_time_id'] != null ) {
                 mysql_query ( "
                                DELETE FROM `".$this->theConfig['pref']."search_index`
                                WHERE `search_index_type` = '".$data_arr['search_time_type']."'
                                AND `search_index_document_id` = ".$data_arr['search_time_document_id']."
                 ", $db );
                 mysql_query ( "
                                UPDATE `".$this->theConfig['pref']."search_time`
                                SET `search_time_date` = '".time()."'
                                WHERE `search_time_id` = '".$data_arr['search_time_id']."'
                 ", $db );
            } else {
                 mysql_query ( "
                                INSERT INTO
                                    `".$this->theConfig['pref']."search_time`
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
                $word_id = $this->get_search_word_id ( $word );

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
                                `".$this->theConfig['pref']."search_index`
                                (`search_index_word_id`, `search_index_type`, `search_index_document_id`, `search_index_count`)
                            VALUES
                                " . implode ( ",", $insert_values ) . "
            ", $db );
        }
    }


    private function get_make_search_index ( $FOR ) {
        global  $db;

        switch ( $FOR ) {
            case "dl":
                // DL
                return mysql_query ( "
                    SELECT
                        `dl_id` AS 'search_time_document_id',
                        `search_time_id`,
                        'dl' AS 'search_time_type',
                        CONCAT(`dl_name`, ' ', `dl_text`) AS 'search_data'
                    FROM `".$this->theConfig['pref']."dl`
                    LEFT JOIN `".$this->theConfig['pref']."search_time`
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
                    FROM `".$this->theConfig['pref']."articles`
                    LEFT JOIN `".$this->theConfig['pref']."search_time`
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
                    FROM `".$this->theConfig['pref']."news`
                    LEFT JOIN `".$this->theConfig['pref']."search_time`
                        ON `search_time_document_id` = `news_id`
                        AND FIND_IN_SET('news', `search_time_type`)
                    WHERE 1
                        AND ( `search_time_id` IS NULL OR `news_search_update` > `search_time_date` )
                    ORDER BY `news_search_update`
                ", $db );
                break;
        }
    }

    private function get_search_word_id ( $WORD ) {
        global $db;

        $index = mysql_query ( "
                                SELECT `search_word_id` FROM `".$this->theConfig['pref']."search_words`
                                WHERE `search_word` = '".savesql ( $WORD )."'
        ", $db );
        if ( mysql_num_rows ( $index ) >= 1 ) {
            return mysql_result ( $index, 0, "search_word_id" );
        } else {
            mysql_query ( "
                            INSERT INTO `".$this->theConfig['pref']."search_words` (`search_word`)
                            VALUES ('".savesql ( $WORD )."')
            ", $db );
            return mysql_insert_id ( $db );
        }
    }

    private function compress_search_data ( $TEXT ) {
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

    private function delete_stopwords ( $TEXT ) {
        $locSearch[] = "=(\s[A-Za-z0-9]{1,2})\s=";
        $locSearch[] = "= " . implode ( " | ", $this->get_stopwords () ) . " =i";
        $locSearch[] = "= +=";

        $locReplace[] = " ";
        $locReplace[] = " ";
        $locReplace[] = " ";

        $TEXT = " " . str_replace ( " ", "  ", $TEXT ) . " ";
        $TEXT = trim ( preg_replace ( $locSearch, $locReplace, $TEXT ) );
        return $TEXT;
    }


    private function get_stopwords () {
        $stopfilespath =  FS2_ROOT_PATH . "resources/stopwords/";
        $stopfiles = scandir_ext ( $stopfilespath, ".txt" );
        $ACCESS = new fileaccess();
        
        $return_arr = array ();
        foreach ( $stopfiles as $file ) {
            $return_arr = array_merge ( $return_arr, $ACCESS->getFileArray( $stopfilespath.$file ) );
        }
        return $return_arr;
    }

}
?>