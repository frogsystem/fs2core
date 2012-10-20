<?php
/**
* @file     class_search.php
* @folder   /libs
* @version  0.1
* @author   Sweil
*
* this class actually runs the search
* search query objects are intened to used by the search-class
*
*/


class Search
{
    // global vars
    private $sql;
    private $config;

    // vars for class options
    private $type;
    private $original_query;
    private $tree;

    private $result;
    private $order = array();
    private $limit = "";
    private $where = array();
    private $numberOfFounds;

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
    public function  __construct ($type, $query, $phonetic = false) {
        // get searchtree classe if not loaded
        require_once(FS2_ROOT_PATH . 'libs/class_searchquery.php');
        require_once(FS2_ROOT_PATH . 'includes/searchfunctions.php');

        // assign global vars
        global $sql;
        $this->sql = $sql;
        $config_cols = array('search_num_previews', 'search_and', 'search_or', 'search_xor', 'search_not', 'search_wildcard', 'search_min_word_length', 'search_allow_phonetic', 'search_use_stopwords');
        $config = $sql->getRow('config', array('config_data'), array('W' => "`config_name` = 'search'"));
        $this->config = json_array_decode($config['config_data']); 

        // assign vars
        $this->type = $type;
        $this->phonetic = $phonetic;
        $this->original_query = $query;

        //compute operators and modifiers
        $rectrim = create_function ('$ele', '
            return array_map(\'trim\', $ele);');

        $operators = array (
            'and' => explode(',', $this->config['search_and']),
            'or' => explode(',', $this->config['search_or']),
            'xor' => explode(',', $this->config['search_xor']),
        );
        $operators = array_map($rectrim, $operators);

        $modifiers = array (
            'not' => explode(',', $this->config['search_not']),
            'wc' => explode(',', $this->config['search_wildcard']),
        );
        $modifiers = array_map($rectrim, $modifiers);

        // Create SearchQuery
        $sq = new SearchQuery($operators, $modifiers);
        $sq->parse($query);
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

    // return number of all found rows
    public function getNumberOfFounds() {
        return $this->numberOfFounds;
    }

    // define order for result output
    public function setOrder() {
        if (func_num_args() == 0) {
            $this->setOrder('rank DESC');
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

    // define sql limit for output [ [$offset,] $rowcount ]
    public function setLimit() {
        if (func_num_args() == 1) {
            $this->limit = 'LIMIT '.func_get_arg(0);
        } elseif (func_num_args() == 2) {
            $this->limit = 'LIMIT '.func_get_arg(0).', '.func_get_arg(1);
        } else {
            $this->limit = '';
        }
        return 1;
    }

        // define order for result output
    public function setWhere() {
        // set where array
        $this->where = array();
        $args = func_get_args();
        foreach ($args as $arg) {
            $this->where[] = $arg;
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

            $query .= '
                OR `search_word`';

            if ($this->phonetic)
                $query .= ' SOUNDS';

            $query .= " LIKE '".$word->evaluate()."'";
        }
        $this->tree->reset();

        $query .= '
            )';

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
                $wordlist = $this->getResultsForLeaf($leaf, $words);
                //sort wordlist by id
                usort($wordlist, create_function('$word1, $word2', '
                    $a = $word1[\'id\'];
                    $b = $word2[\'id\'];

                    return ($a == $b) ? 0 : (($a < $b) ? -1 : 1);'));

                $leaf->setDBData($wordlist);
            }
            $this->tree->reset();

        } catch (Exception $e) {
            $error = true;
            Throw $e;
        }
    }

    // get results orderd by
    private function loadResult() {
        // create SQL-pseudo SELECTS
        $set = $this->tree->getSet();

        $selects = array('SELECT 0 AS `id`, 0 AS `rank`');
        foreach ($set as $result) {
            $selects[] = 'SELECT '.$result['id'].' AS `id`, '.$result['rank'].' AS `rank`';
        }

        //switch search type
        switch ($this->type) {
            case 'news':     $table = 'news'; $id = 'news'; break;
            case 'articles': $table = 'articles'; $id = 'article'; break;
            case 'dl':       $table = 'dl'; $id = 'dl'; break;
        }

        // set where & limit
        $where = implode(' ', $this->where);
        $where = !empty($where) ? 'WHERE '.$where : '';
        $limit = $this->limit;

        $query = '
            SELECT SQL_CALC_FOUND_ROWS
                T.`id`, T.`rank`
            FROM (
                '.implode(' UNION ALL ', $selects).'
            ) T

            INNER JOIN
                `{..pref..}'.$table.'` O
            ON
                T.`id` = O.`'.$id.'_id`

            '.$where.'

            ORDER BY
                '.implode(', ', $this->order).'

            '.$limit.'
        ';

        // try to execute the query
        try {
            $this->result = $this->sql->doQuery($query);
            $this->inprogress = true;

            // Get total num of affacted rows
            $num_result = $this->sql->doQuery('SELECT FOUND_ROWS()');
            list ($this->numberOfFounds) = mysql_fetch_row ($num_result);

        } catch (Exception $e) {
            $this->error = true;
            Throw $e;
        }
    }


    // combine results for leafs
    private function getResultsForLeaf(&$leaf, &$wordarr) {
        // no wildcards
        if ($leaf->getType() == SQEXACT && !$this->phonetic) {
            return isset($wordarr[$leaf->label()]) ? $wordarr[$leaf->label()] : array();
        }

        //some wildcards or phonetic
        // Front or Both
        $keys = $search_keys = array_keys($wordarr);
        $front = $end = array();
        $label = $leaf->label();

        //phonetic search
        if ($this->phonetic) {
            $label = soundex($leaf->label());
            $search_keys = array_map('soundex', $keys);
        }


        if ($leaf->getType() == SQFRONT || $leaf->getType() == SQBOTH) {
            $front = preg_grep('/(.+)'.$label.'/', $search_keys);
            if ($this->phonetic)
                $front = array_values_by_keys($keys, array_keys($front));
        }
        // End or Both
        elseif ($leaf->getType() == SQEND || $leaf->getType() == SQBOTH) {
            $end = preg_grep('/'.$label.'(.+)/', $search_keys);
            if ($this->phonetic)
                $end = array_values_by_keys($keys, array_keys($end));
        }
        // "Exact"  phonetic
        else {
            $front = preg_grep('/'.$label.'/', $search_keys);
            if ($this->phonetic)
                $front = array_values_by_keys($keys, array_keys($front));
        }

        $keys = array_unique(array_merge($front, $end), SORT_STRING);

        // fucntion to compare found-data-arrays
        $cmp = create_function ('$v1, $v2', '
            if ($v1[\'id\'] > $v2[\'id\']) return -1;
            if ($v1[\'id\'] == $v2[\'id\']) return 0;
            return 1;');
        
        // fucntion to compare found-data-arrays and update rank
        $cmp_newrank = create_function ('&$v1, $v2', '
            if ($v1[\'id\'] > $v2[\'id\'])
                return -1;
            if ($v1[\'id\'] == $v2[\'id\']) {
                $v1[\'rank\'] = $v1[\'rank\']+$v2[\'rank\'];
                return 0;
            }
            return 1;');

        //compare and add rank
        $cmp_plus = create_function ('&$v1, $v2', '
            return compare_update_rank ($v1, $v2, create_function(\'$v1, $v2\', \'return $v1+$v2;\'));');

        // get data for matching keys
        $return_array = array();
        foreach($keys as $key) {
            $data = array_values($wordarr[$key]);
            $return_array = array_real_merge($return_array, $data, $cmp_plus, 'compare_found_data');
        }

        // return found data
        return $return_array;
    }
}
?>
