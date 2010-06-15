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
    private $searchType;
    
    /**
     * Creates an object for specified Search Type
     *
     * @name sql::__construct();
     *
     * @param String $searchType
     *
     * @return bool
     */
    public function  __construct ( $searchType ) {
        // Include global Data
        global $global_config_arr, $sql;
        $this->theConfig = $global_config_arr;
        $this->theSql = $sql;
        $this->searchType = $searchType;
    }

    // function for rebuilding the Search-Index
    public function rebuildIndex () {
        $this->deleteIndex ();
        $this->updateIndex ();
    }

    // function for deleting the Search-Index
    public function deleteIndex () {
        $this->theSql->deleteData ( "search_index", "`search_index_type` = '".$this->searchType."'" );
        $this->theSql->deleteData ( "search_time", "`search_time_type` = '".$this->searchType."'" );
    }
    
    public function deleteIndexForContent ( $ID ) {
        $this->theSql->deleteData ( "search_index", "`search_index_type` = '".$this->searchType."' AND `search_index_document_id` = '".$ID."'" );
        $this->theSql->deleteData ( "search_time", "`search_time_type` = '".$this->searchType."' AND `search_time_document_id` = '".$ID."'" );
    }


    public function clearWordTable () {
        $this->theSql->query ( "TRUNCATE TABLE `{..pref..}search_words`" );
    }

    public function updateIndex () {

        $data = $this->get_make_search_index ( $FOR );
        while ( $data_arr = mysql_fetch_assoc ( $data ) ) {
            // Compress Text and filter Stopwords
            $data_arr['search_data'] = $this->removeStopwords ( $this->compressSearchData ( $data_arr['search_data'] ) );

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
                
                $word_id = $this->getSearchWordId ( $word );
                if ( $word_id === FALSE ) {
                    $word_id = $this->addSearchWord ( $word );
                }

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

    private function getSearchWordId ( $WORD ) {
        $theData = $this->theSql->getData ( "search_words", "search_word_id", "WHERE `search_word` = '".savesql ( $WORD )."'", 1 );
        if ( count ( $theData ) >= 1 ) {
            return $theData[0]['search_word_id'];
        } else {
            $this->addSearchWord ( $WORD );
            return FALSE;
        }
    }
    
    private function addSearchWord ( $WORD ) {
        if ( $this->theSql->setData ( "search_words", "search_word", savesql ( $WORD ) ) ) {
            return $this->getInsertId ();
        } else {
            return FALSE;
        }
    }

    private function compressSearchData ( $TEXT ) {
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
        $locSearch[] = "=([^A-Za-z0-9])=";
        $locSearch[] = "= +=";
        #$locSearch[] = "=([0-9/.,+-]*\s)=";

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
        $locReplace[] = " ";
        $locReplace[] = " ";
        #$locReplace[] = " ";

        $TEXT = trim ( strtolower ( stripslashes ( killfs ( $TEXT ) ) ) );
        $TEXT = preg_replace ( $locSearch, $locReplace, $TEXT );
        return $TEXT;
    }

    private function removeStopwords ( $TEXT ) {
        $locSearch[] = "=(\s[A-Za-z0-9]{1,2})\s=";
        $locSearch[] = "= " . implode ( " | ", $this->getStopwords () ) . " =i";
        $locSearch[] = "= +=";

        $locReplace[] = " ";
        $locReplace[] = " ";
        $locReplace[] = " ";

        $TEXT = " " . str_replace ( " ", "  ", $TEXT ) . " ";
        $TEXT = trim ( preg_replace ( $locSearch, $locReplace, $TEXT ) );
        return $TEXT;
    }


    private function getStopwords () {
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