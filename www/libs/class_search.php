<?php
/**
* @file     class_searchquery.php
* @folder   /libs
* @version  0.1
* @author   Sweil
*
* this class actually makes the search
* search query objects are intened to used by the search-class
* 
*/




class Search
{
    // global vars
    private $sql;
    
    // vars for class options
    private $type;
    private $tree;   
    private $inprogress = false;
    private $error = false; 
    private $result;

    // constructor
    public function  __construct ($type, $tree) {
        // assign global vars
        global $sql;
        $this->sql = $sql;

        // assign vars
        $this->type = $type;
        $this->tree = $tree;
        
        // execute the search
        $this->execute();
    }
  
    // return next result entry
    public function execute() {
        
        // query to get all entries from db
        $query = "
            SELECT
                `search_index_document_id` AS 'id',
                `search_index_type` AS 'type',
                `search_index_count` AS 'rank',
                `search_word` AS 'word'
            FROM
                `{..pref..}search_index`
            INNER JOIN
                `{..pref..}search_words`
            ON
                `search_index_word_id` = `search_word_id`
                
            WHERE `search_index_type` = '".$this->type."'
            AND ( 0 ";
        
        // get all words
        while ($word = $this->tree->nextLeaf()) {
            $query .= "   
                OR `search_word` LIKE '".$word->evaluate()."'";
        }
        $this->tree->reset();
        
        $query .= "
            )";
        
        // try to execute the query
        try {
            // execute query
            $this->result = $this->sql->doQuery($query);
            
            // go through results
            $words = array();
            while ($found = mysql_fetch_assoc($this->result)) {
                // create array for each word
                if (!is_array($words[$found['word']]))
                    $words[$found['word']] = array();
            
                $words[$found['word']][] = array('id' =>$found['id'], 'rank' =>$found['rank']);
            }
                            var_dump($words);
            // add DB data to searchtree
            while($leaf = $this->tree->nextLeaf()) {
                if (isset($words[$leaf->label()]))
                    $leaf->setDBData($words[$leaf->label()]);
            }
            $this->tree->reset();
            
        } catch (Exception $e) {
            $error = true;
            Throw $e;
        }
    }
    
    // return next result entry id
    public function next() {
        if (!$this->inprogress || $this->error)
            return false;

        return mysql_fetch_assoc($this->result);
    }
    
    // return the search tree
    public function getResult() {
        return $this->tree;
    }    
}
