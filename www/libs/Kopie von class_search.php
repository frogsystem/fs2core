<?php
/**
 * @file     class_search.php
 * @folder   /libs
 * @version  0.2
 * @author   Sweil
 *
 * this class is responsible for search operations
 */
class Search {

    // Set Class Vars
    private $theConfig;
    private $theSql;
    private $searchTypeArray;
    private $searchTypeArraySQL = array ();
    
    /**
     * Creates an object for specified Search Type
     *
     * @name sql::__construct();
     *
     * @param String $searchType
     *
     * @return bool
     */
    public function  __construct ( $searchTypeArray ) {
        // Include global Data
        global $global_config_arr, $sql;
        $this->theConfig = $global_config_arr;
        $this->theSql = $sql;
        $this->searchTypeArray = $searchTypeArray;
        foreach ( $this->searchTypeArray as $aType ) {
            $this->searchTypeArraySQL[] = str_replace ( '$1', $aType, "FIND_IN_SET('\$1',I.`search_index_type`)" );
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
    
    private function createSearchWordArray ( $ARR, $DEFAULT = "AND" ) {
        $ARR = (array) $ARR;
        $ARR = array_filter ( array_map ( "compressKeyword", $ARR ), "strlen" );

        if ( count ( $ARR ) > 1 ) {
            $search_word_arr = array ();
            $before_op = TRUE;
            foreach ( $ARR as $word ) {
                if ( $this->isSearchOp ( $word ) && $before_op !== TRUE ) {
                    $search_word_arr[] = $word;
                    $before_op = TRUE;
                } elseif ( $before_op === TRUE && !$this->isSearchOp ( $word ) ) {
                    $search_word_arr[] = $word;
                    $before_op = FALSE;
                } elseif ( !$this->isSearchOp ( $word ) )  {
                    $search_word_arr[] = $DEFAULT;
                    $search_word_arr[] = $word;
                    $before_op = FALSE;
                }
            }
            if ( $this->isSearchOp ( end ( $search_word_arr ) ) ) {
                array_pop ( $search_word_arr );
            }
            return $search_word_arr;
        } else {
            return $ARR;
        }
    }
    
    private function compareFoundsWithKeywords ( $FOUNDS, $KEYWORDS ) {
        $bool_arr = array ();
        foreach ( $KEYWORDS as $word ) {
            if ( !$this->isSearchOp ( $word ) ) {
                $bool_arr[] = ( array_key_exists ( $word, $FOUNDS ) ) ? "TRUE" : "FALSE";
            } else {
                switch ( $word ) {
                    case "NOT":
                        $bool_arr[] = " && !";
                        break;
                    case "OR":
                        $bool_arr[] = " || ";
                        break;
                    case "AND":
                        $bool_arr[] = " && ";
                        break;
                    case "XOR":
                        $bool_arr[] = " xor ";
                        break;
                }
            }
        }
        $bool_return = FALSE;
        $bool_string = implode ( "", $bool_arr );
        eval ("\$bool_return = (".$bool_string.");" );
        if ( $bool_return ) {
            return TRUE;
        }
        return  FALSE;
    }


    // make a search
    public function makeSearch ( $KEYWORDS ) {
        // create keywords
        $keyword_arr = explode ( " ", $KEYWORDS );
        $keyword_arr = $this->createSearchWordArray ( $keyword_arr );
        // Get Special SQL-Query for Types
        $type_check = ( count ( $this->searchTypeArraySQL ) > 0 ) ? "AND ( " . implode ( " OR ", $this->searchTypeArraySQL ) . " )" : "";
        
        // Get Founds from Index
        $founds_arr = array ();
        foreach ( $keyword_arr as $word ) {
            if ( !$this->isSearchOp ( $word ) ) {
                $search = $this->theSql->query ( "
                    SELECT
                            I.`search_index_document_id` AS 'document_id',
                            I.`search_index_type` AS 'type',
                            SUM(I.`search_index_count`) AS 'count'

                    FROM
                            `{..pref..}search_index` AS I,
                            `{..pref..}search_words` AS W

                    WHERE   1
                            " . $type_check  . "
                            AND W.`search_word_id` = I.`search_index_word_id`
                            AND W.`search_word` LIKE '%".$word."%'

                    GROUP BY `document_id`, `type`
                    ORDER BY `type`, `count` DESC
                " );

                while ( $data_arr = mysql_fetch_assoc ( $search ) ) {
                    $founds_arr[$data_arr['type']][$data_arr['document_id']][$word] = $data_arr['count'];
                }
            }
        }
        
        
        $results_arr = array ();
        foreach ( $founds_arr as $type => $docs ) {
            foreach ( $docs as $id => $founds ) {
                if ( $this->compareFoundsWithKeywords ( $founds, $keyword_arr ) ) {
                    $results_arr[$type][$id] = array_sum ( $founds );
                }
            }
        }

    }
    
    
    protected function compressSearchData ( $TEXT ) {
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

    protected function removeStopwords ( $TEXT ) {
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

    protected function getStopwords () {
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