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

    // Set Class Vars
    private $theConfig;
    private $theSql;
    private $searchType;
    private $searchDataArray;

    // set search data for preconfiged searchTypes
    private $preconfigedSearchData = array (
        "dl" => array (
            "table" => "dl",
            "contentIdField" => "dl_id",
            "updateTimeField" => "dl_search_update",
            "searchData" => array (
                array ( "field", "dl_name" ),
                array ( "text", " " ),
                array ( "field", "dl_text" )
            )
        ),
        "articles" => array (
            "table" => "articles",
            "contentIdField" => "article_id",
            "updateTimeField" => "article_search_update",
            "searchData" => array (
                array ( "field", "article_title" ),
                array ( "text", " " ),
                array ( "field", "article_text" )
            )
        )
    );
    
    /**
     * Creates an object for specified Search Type
     *
     * @name sql::__construct();
     *
     * @param String $searchType
     *
     * @return bool
     */
    public function  __construct ( $searchType, $searchDataArray = null ) {
        // Include global Data
        global $global_config_arr, $sql;
        $this->theConfig = $global_config_arr;
        $this->theSql = $sql;
        $this->searchType = $searchType;
        if ( !is_null ( $searchDataArray ) ) {
            $this->searchDataArray = $searchDataArray;
        } else  {
            $this->searchDataArray = $this->getPreconfigedSearchData();
        }
    }
    
    // check for search opertors
    private function isSearchOp ( $CHECK, $OP_ARR = array ( "AND", "OR", "NOT", "XOR" ) ) {
        return in_array ( $CHECK, $OP_ARR );
    }
    
    private function compressKeyword ( $TEXT ) {
        if ( $this->isSearchOp ( $TEXT ) ) {
            return $TEXT;
        }
        return $this->removeStopwords ( $this->compressSearchData ( $TEXT ) );
    }
    
    

    // function for rebuilding the Search-Index
    private function getPreconfigedSearchData () {
        if ( isset ( $this->preconfigedSearchData[$this->searchType] ) ) {
            return $this->preconfigedSearchData[$this->searchType];
        } else  {
            return array (
                "table" => $this->searchType,
                "contentIdField" => $this->searchType."_id",
                "updateTimeField" => $this->searchType."_search_update",
                "searchData" => array (
                    array ( "field", $this->searchType."_title" ),
                    array ( "text", " " ),
                    array ( "field", $this->searchType."_text" )
                )
            );
        }
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

        $data = $this->getIndexQuery ();
        print_r ( $this->theSql->getError() );
        while ( $data_arr = mysql_fetch_assoc ( $data ) ) {
            // Compress Text and filter Stopwords
            $data_arr['search_data'] = $this->removeStopwords ( $this->compressSearchData ( $data_arr['search_data'] ) );

            // Remove Old Indexes & Update Timestamp
            if ( $data_arr['search_time_id'] != null ) {
                 $this->theSql->deleteData ( "search_index", "`search_index_type` = '".$data_arr['search_time_type']."' AND `search_index_document_id` = ".$data_arr['search_time_document_id'] );
                 $this->theSql->updateData ( "search_time", "search_time_date", time(), "WHERE `search_time_id` = '".$data_arr['search_time_id']."'" );
            } else {
                $this->theSql->setData ( "search_time", "search_time_type,search_time_document_id,search_time_date", $data_arr['search_time_type'].",".$data_arr['search_time_type'].",".time() );
            }

            // Pass through word list
            $word_arr = explode ( " ", $data_arr['search_data'] );
            $index_arr = array();
            foreach ( $word_arr  as $word )  {
                $word = substr ( $word, 0, 32 );
                
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
            $this->theSql->setData ( "search_index", "search_index_word_id,search_index_type,search_index_document_id,search_index_count", implode ( ",", $insert_values ) );
        }
    }

    private function getIndexQuery () {
        $theConcatedData = array ();
        foreach ( $this->searchDataArray['searchData'] as $aConcatData ) {
            if ( $aConcatData[0] == "field" ) $theConcatedData[] = "`".$aConcatData[1]."`";
            if ( $aConcatData[0] == "text" ) $theConcatedData[] = "'".$aConcatData[1]."'";
        }
        $theConcatedData = "CONCAT(" . implode ( ", ", $theConcatedData ) . ")";

        return $this->theSql->query ( "
            SELECT
                `".$this->searchDataArray['contentIdField']."` AS 'search_time_document_id',
                `search_time_id`,
                '".$this->searchType."' AS 'search_time_type',
                ".$theConcatedData." AS 'search_data'
            FROM `{..pref..}".$this->searchDataArray['table']."`
            LEFT JOIN `{..pref..}search_time`
                ON `search_time_document_id` = `".$this->searchDataArray['contentIdField']."`
                AND FIND_IN_SET('".$this->searchType."', `search_time_type`)
            WHERE 1
                AND ( `search_time_id` IS NULL OR `".$this->searchDataArray['updateTimeField']."` > `search_time_date` )
            ORDER BY `".$this->searchDataArray['updateTimeField']."`
        " );
    }

    private function getSearchWordId ( $WORD ) {
        $theData = $this->theSql->query ( "SELECT `search_word_id` FROM `{..pref..}search_words` WHERE `search_word` = '".savesql ( $WORD )."'" );
        if ( mysql_num_rows ( $theData ) >= 1 ) {
            return mysql_result ( $theData, 0, "search_word_id" );
        } else {
            return FALSE;
        }
    }
    
    private function addSearchWord ( $WORD ) {
        if ( $this->theSql->setData ( "search_words", "search_word", savesql ( $WORD ) ) ) {
            return $this->theSql->getInsertId ();
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

    /**********************************************************
    / No need for news, because it is also represented by default data-structure
    /**********************************************************
        static $preconfigedSearchData = array (
            "news" => array (
                "table" => "news",
                "contentIdField" => "news_id",
                "updateTimeField" => "news_search_update",
                "searchData" => array (
                    array ( "field", "news_title" ),
                    array ( "text", " " ),
                    array ( "field", "news_text" )
                )
            )
        );
    /*********************************************************/
}
?>