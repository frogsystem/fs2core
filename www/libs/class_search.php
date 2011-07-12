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
    private $original_query;
    private $tree; 
      
    private $result;    
    private $order = array();
    private $inprogress = false; 
    private $error = false; 
    
    // return the search tree
    public function getSet() {
        return $this->tree->getSet();
    }
    public function getQuery() {
        return (string) $this->tree;
    }     

    // constructor
    public function  __construct ($type, $query) {
        // get searchtree classe if not loaded
        require_once(FS2_ROOT_PATH . "libs/class_searchquery.php");               
        
        // assign global vars
        global $sql;
        $this->sql = $sql;

        // assign vars
        $this->type = $type;
        $this->original_query = $query;
        
        // Create SearchQuery
        $sq = new SearchQuery();
        $sq->parse($_REQUEST['keyword']);        
        $this->tree = $sq->getTree();
        
        // execute the search
        $this->execute();
        $this->setOrder();     
    }
    
    
    // return next result entry id
    public function next() {
        if(!$this->inprogress && !$this->error)
            $this->loadResult();
        
        if (!$this->inprogress || $this->error)
            return false;

        return mysql_fetch_assoc($this->result);
    }
    
    // define order for result output
    public function setOrder() {
        if (func_num_args() == 0) {
            $this->setOrder("rank DESC");
            return 1;
        }
        
        // set order array
        $this->order = array();
        $args = func_get_args();
        foreach ($args as $arg) {
            $this->order[] = $arg;
        }
        return 1;
    }    
  
    // execute the search
    private function execute() {
        
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
            $result = $this->sql->doQuery($query);
            
            // go through results
            $words = array();
            while ($found = mysql_fetch_assoc($result)) {
                // create array for each word
                if (!isset($words[$found['word']]) || !is_array($words[$found['word']]))
                    $words[$found['word']] = array();
            
                $words[$found['word']][] = array('id' =>$found['id'], 'rank' =>$found['rank']);
            }
            
            // add DB data to searchtree
            while($leaf = $this->tree->nextLeaf()) {
                $leaf->setDBData($this->getResultsForLeaf($leaf, $words));
            }
            $this->tree->reset();

        } catch (Exception $e) {
            $error = true;
            Throw $e;
        }
    }
    
    // get results orderd by 
    private function loadResult() {
        // create SQL-pseude SELECTS
        $set = $this->tree->getSet();

        $selects = array("SELECT 0 AS `id`, 0 AS `rank`");
        foreach ($set as $result) {
            $selects[] = "SELECT ".$result['id']." AS `id`, ".$result['rank']." AS `rank`";
        }
        
        //switch search type
        switch ($this->type) {
            case "news":     $table = "news"; $id = "news"; break;
            case "articles": $table = "articles"; $id = "article"; break;
            case "dl":       $table = "dl"; $id = "dl"; break;
        }
        
        
        $query = "
            SELECT
                T.`id`, T.`rank`
            FROM (
                ".implode(" UNION ALL ", $selects)."
            ) T
                
            INNER JOIN
                `{..pref..}".$table."` O
            ON
                T.`id` = O.`".$id."_id`
            ORDER BY
                ".implode(", ", $this->order)."
        ";
        
        // try to execute the query
        try {
            $this->result = $this->sql->doQuery($query);
            $this->inprogress = true;
        } catch (Exception $e) {
            $this->error = true;
            Throw $e;
        }
    }    

    
    // combine results for leafs
    private function getResultsForLeaf(&$leaf, &$wordarr) {
        // no wildcards
        if ($leaf->getType() == SQEXACT) {
            return isset($wordarr[$leaf->label()]) ? $wordarr[$leaf->label()] : array();
        }
        
        //some wildcards
        // Front or Both
        $keys = array_keys($wordarr);
        $front = $end = array();
        if ($leaf->getType() == SQFRONT || $leaf->getType() == SQBOTH) {
            $front = preg_grep('/(.+)'.$leaf->label().'/', $keys);
        }
        // End or Both
        if ($leaf->getType() == SQEND || $leaf->getType() == SQBOTH) {
            $end = preg_grep('/'.$leaf->label().'(.+)/', $keys);
        }
        $keys = array_unique(array_merge($front, $end), SORT_STRING);
        
        // fucntion to compare found-data-arrays
        $cmp = function ($v1, $v2) {
            if ($v1['id'] > $v2['id']) return -1;
            if ($v1['id'] == $v2['id']) return 0;    
            return 1;
        };
        // fucntion to compare found-data-arrays and update rank
        $cmp_newrank = function (&$v1, $v2) {
            if ($v1['id'] > $v2['id'])
                return -1;
            if ($v1['id'] == $v2['id']) {
                $v1['rank'] = $v1['rank']+$v2['rank'];
                return 0;
            }
            return 1;
        };
        
        //compare and add rank 
        $cmp_plus = function (&$v1, $v2) {
            return compare_update_rank ($v1, $v2, function ($v1, $v2) {return $v1+$v2;});
        };        
        
        // get data for matching keys 
        $return_array = array();
        foreach($keys as $key) {
            $data = array_values($wordarr[$key]);
            $return_array = array_real_merge($return_array, $data, $cmp_plus, "compare_found_data");
        }

        // return found data
        return $return_array;
    }  
}
