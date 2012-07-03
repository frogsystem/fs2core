<?php
/**
 * @file     class_sql.php
 * @folder   /libs
 * @version  0.4
 * @author   Sweil, Satans Krümelmonster
 *
 * this class provides several methodes for database-access
 */


class sql {

    // Properties
    private $sql;                   // the connection-resource
    private $pref;                  // Table-Prefix (see inc_login.php)
    private $db;                    // the selected Databse
    private $error;                 // possible SQL errors
    private $result = false;        // result-resource of a query
    private $query;                 // the built query string


    // Constructor
    // connects the database, saves SQL-Connection, database-name and prefix
    public function __construct($host, $data, $user, $pass, $pref) {
        $this->sql = @mysql_connect($host, $user, $pass);
        if ($this->sql !== false && mysql_select_db($data, $this->sql)) {
            $this->db = $data;
            $this->pref = $pref;
        } else {
            $this->sql = false;
            Throw new ErrorException('No Connection to Database: '.mysql_error());
        }
    }

    // Destructor closes SQL-Connection
    public function __destruct (){
        //mysql_close($this->sql);
    }


    // save sql data
    public function escape ($VAL) {

        // remove fucking magic quotes
        if (get_magic_quotes_gpc())
            $VAL = stripslashes($VAL);

        // fallback
        if (SLASH)
            $VAL = addslashes($VAL);

        // save data
        if (is_numeric($VAL)) {
            if (floatval($VAL) == intval($VAL)) {
                $VAL = intval($VAL);
                settype($VAL, 'integer');
            } else {
                $VAL = floatval($VAL);
                settype($VAL, 'float');
            }
        } else {
            $VAL = mysql_real_escape_string(strval($VAL), $this->conn());
        }

        return $VAL;
    }

    // "unsave" sql data (stripslash if on old systems)
    private function unslash ($VAL) {
        // fallback
        if (SLASH) {
            $VAL = stripslashes($VAL);
        }
        return $VAL;
    }


    // run any query
    public function doQuery ($qrystr) {
        $this->query = str_replace('{..pref..}', $this->pref, $qrystr); // replace {..pref..}
        $this->result = mysql_query($this->query, $this->sql); // execute query

        if ($this->result !== false) {
            unset($this->error);
            return $this->result;
        } else {
            $this->error[0] = mysql_errno($this->sql); // error number
            $this->error[1] = mysql_error($this->sql); // error text
            $this->error[2] = $this->query;            // query causing the error
            Throw new ErrorException('MySQL Error: ['.$this->error[0].'] '.$this->error[1]."\n".$this->error[2]);
            return false;
        }
    }

    // build options
    private function opt ($options) {
        // init array
        $return = array();

        // set options
        if (isset($options['W']) && !empty($options['W']))
           $return[] = 'WHERE '.$options['W'];

        if (isset($options['O']) && !empty($options['O']))
           $return[] = 'ORDER BY '.$options['O'];

        if (isset($options['G']) && !empty($options['G']))
           $return[] = 'GROUP BY '.$options['G'];

        if (isset($options['H']) && !empty($options['H']))
           $return[] = 'HAVING '.$options['H'];

        if (isset($options['L']) && !empty($options['L']))
           $return[] = 'LIMIT '.$options['L'];

        // return as string
        return ' '.implode(' ', $return);
    }

    // build select expression
    /* array (
     * 	array (
     * 		'COL' => 'fieldname',
     * 		'FROM' => 'tablealias',
     * 		'AS' => 'colalias',
     * 		'FUNC' => 'count',
     * 		'ARG' => "last_name,', ',first_name"
     *      'MATH' => '+'
     *      'LEFT' => array (...)
     *      'RIGHT' => array (...)
     * 	)
     * );
     *
     * => make := Funktion die String baut
     * => S = make(LEFT) + MATH + make(RIGHT) END;// if MATH, LEFT && RIGHT
     * => S = FUNC(ARG)// if FUNC && ARG
     * => S = COL // if COL == * && !FUNC && ARG
     * => S = `COL` // if !FUNC && ARG
     * => S = FROM.S  // if FROM
     * => S = FUNC(S) // if FUNC
     * => S = S AS "AS" END;// if AS
     */
    private function select_expr ($col) {
        initstr($cols_list);
        if (isset($col['MATH'], $col['LEFT'], $col['RIGHT'])) {
            $cols_list = '('.$this->select_expr($col['LEFT']).') '.$col['MATH'].' ('.$this->select_expr($col['RIGHT']).')';
        } else {

            //=> S = FUNC(ARG)// if FUNC && ARG
            if  (isset($col['FUNC'], $col['ARG'])) {
                $cols_list = $col['FUNC'].'('.$col['ARG'].')';

            } else {
                //=> S = COL || `COL`
                $cols_list = $col['COL'] == '*' ? $col['COL'] : '`'.$col['COL'].'`';
                //=> S = FROM.S  // if FROM
                $cols_list = isset($col['FROM']) ? $col['FROM'].'.'.$cols_list : $cols_list;
                //=> S = FUNC(S) // if FUNC
                $cols_list = isset($col['FUNC']) ? $col['FUNC'].'('.$cols_list.')' : $cols_list;
            }

            //=> S = S AS "AS" // if AS
            $cols_list = isset($col['AS']) ? $cols_list." AS '".$col['AS']."'" : $cols_list;
        }
        return $cols_list;
    }

    // execute SELECT
    private function select ($table, $cols, $options = array(), $distinct = false, $total_rows = false) {
        // empty cols
        if (empty($cols))
            Throw new ErrorException('MySQL Error: Can\'t select nothing.');
        if (is_array($table) && count($table) <= 0)
            Throw new ErrorException('MySQL Error: Can\'t select from nothing.');


        // Table list
        if (is_array($table)) {
            // Computes to FROM `table1` ONE, `table2` TWO ...
            $table_list = array();
            foreach ($table as $as => $name) {
                $table_list[] = '`'.$this->pref.$name.'` '.$as;
            }
            $table_list = implode(', ', $table_list);
        } else {
            $table_list = '`'.$this->pref.$table.'`';
        }

        // prepare data
        if (is_array($cols)) {
            $cols_list = array();
            foreach ($cols as $col) {
                if (is_array($col)) {
                    $cols_list[] = $this->select_expr($col);
                } else {
                    $cols_list[] = '`'.$col.'`';
                }
            }

            $cols_list = implode(', ', $cols_list);

        // error
        } elseif ($cols == '*') {
            $cols_list = $cols;
        } else {
            Throw new ErrorException('MySQL Error: Cannot select because of bad data.');
        }

        // DISTINCT or not
        $select = ($distinct) ? 'SELECT DISTINCT ' : 'SELECT ';
        // Total Rows?
        $select .= ($total_rows) ? ' SQL_CALC_FOUND_ROWS' : '';

        // build query string...
        $qrystr = $select.$cols_list.' FROM '.$table_list.$this->opt($options);

        try {
            return $this->doQuery($qrystr); // ... and execute
        } catch (Exception $e) {
            print_d($e->getMessage());
        }
    }




    // get data from database
    public function get ($table, $cols, $options = array(), $distinct = false, $total_rows = false) {
        // Get Data
        $rows = array();
        $result = $this->select($table, $cols, $options, $distinct, $total_rows);
        while ($row = mysql_fetch_assoc($result)) {
            $rows[] = $row;
        }
        $num = count($rows);

        // Total rows?
        if ($total_rows) {
            $result = $this->doQuery('SELECT FOUND_ROWS()');
            list ($total_rows) = mysql_fetch_row ($result);
        } else {
            $total_rows = $num;
        }

        // Unslash the result
        if ($num > 0) {
			require_once(FS2_ROOT_PATH.'libs/class_fullaccesswrapper.php');
			$self = giveAccess($this);  // $self := $this
			$lokal = function ($row) use ($self) {
				return array_map(function($r) use($self) {
					return $self->unslash($r);
				}, $row);
			};
            $rows = array_map($lokal, $rows);
        }

        // Return the result
        return array (
            'data' => $rows,
            'num' => $num,
            'num_all' => $total_rows,
        );
    }

    // get data from database
    public function getData ($table, $cols, $options = array(), $distinct = false) {
        // Get Result
        $result = $this->get($table, $cols, $options, $distinct);
        return $result['data'];
    }


    // only a single data row
    public function getRow ($table, $cols, $options = array(), $start = 0) {
        // Set Limit
        $options['L'] = "$start,1";

        // Get Result
        $result = $this->get($table, $cols, $options);
        if (count($result['data']) >= 1) {
            return $result['data'][0];
        } else {
            return array();
        }
    }
    // single row by Id
    public function getById ($table, $cols, $id, $id_col = 'id') {
        $options = array ('W' => '`'.$id_col."`='".$this->escape($id)."'");
        return $this->getRow($table, $cols, $options);
    }

    // only a single data field
    public function getField ($table, $field, $options = array(), $start = 0) {
        // Get Result
        $result = $this->getRow($table, array($field), $options);
        if (count($result) >= 1)
            return array_shift($result);
        else
            return false;
    }
    // single field by Id
    public function getFieldById ($table, $field, $id, $id_col = 'id') {
        $options = array ('W' => '`'.$id_col."`='".$this->escape($id)."'");

        try {
            return $this->getField($table, $field, $options);
        } catch (Exception $e) {
            Throw $e;
        }
    }

    // num of rows
    public function num ($table, $cols, $options = array(), $distinct = false) {
        return mysql_num_rows($this->select($table, $cols, $options, $distinct));
    }

    // Saving to DB by Id
    // existing entry => update, else => insert
    public function save ($table, $data, $id = 'id', $auto_id = true) {
        // Update
        if (isset($data[$id]) && $this->getFieldById($table, $id, $this->escape($data[$id]), $id) !== false) {
            try {
                return $this->updateById($table, $data, $id);
            } catch (Exception $e) {
                throw $e;
            }

        // Insert
        } else  {
            try {
                if ($auto_id) {
                    unset($data[$id]);
                }
                return $this->insertId($table, $data);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    // insert statement
    public function insert ($table, $data) {
        // empty data
        if (empty($data))
            Throw new ErrorException("MySQL Error: Can't insert empty data.");

        // prepare data
        $cols = ($vals = array());
        foreach($data as $column => $value) {
            $cols[] = '`'.$column.'`';
            $vals[] = "'".$this->escape($value)."'";
        }

        // build query string...
        $qrystr = 'INSERT INTO `'.$this->pref.$table.'` ('.implode(',', $cols).') VALUES ('.implode(',', $vals).')';

        return $this->doQuery($qrystr); // ... and execute
    }
    // insert with returning auto increment value
    public function insertId ($table, $data) {
        try {        
            $this->insert($table, $data);
            return mysql_insert_id($this->sql);
        } catch (Exception $e) {
            Throw $e;
        }
    }

    // update statement
    public function update ($table, $data, $options = array()) {
        // empty data
        if (empty($data))
            Throw new ErrorException("MySQL Error: Can't update empty data.");

        // prepare data
        $list = array();
        foreach($data as $column => $value) {
            $list[] = '`'.$column."` = '".$this->escape($value)."'";
        }

        // build query string...
        $qrystr = 'UPDATE `'.$this->pref.$table.'` SET '.implode(',', $list).$this->opt($options);

        try {
            return $this->doQuery($qrystr); // ... and execute
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
    }
    // update by Id
    public function updateById ($table, $data, $id = "id") {
        // check for id
        if (!isset($data[$id]))
            Throw new ErrorException("MySQL Error: Can't update because of bad data.");

        $options = array ('W' => '`'.$id."`='".$this->escape($data[$id])."'");

        try {
            $this->update($table, $data, $options);
            return $data[$id];
        } catch (Exception $e) {
            throw $e;
        }
    }

    // delete statement
    public function delete ($table, $options = array()) {
        $qrystr = 'DELETE FROM `'.$this->pref.$table.'`'.$this->opt($options);

        try {
            $this->doQuery($qrystr);
            return mysql_affected_rows($this->conn());
        } catch (Exception $e) {
            print_r($e->getMessage());
            return false;
        }
    }

    // delete statement
    public function deleteById ($table, $id, $id_col = 'id') {
        $options = array (
            'W' => '`'.$id_col."`='".$this->escape($id)."'",
            'L' => '1',
        );
        return $this->delete($table, $options);
    }

    // print or return last error
    public function error ($return = false) {
        if (!empty($this->error)) {
            if ($return)
                return $this->error;
            else
                var_dump($this->error);
        } else {
            return false;
        }
    }

    // print or return last query
    public function last ($return = false) {
        if (!empty($this->query)) {
            if ($return)
                return $this->query;
            else
                var_dump($this->query);
        } else {
            return false;
        }
    }

    // return sql-resource
    public function conn() {
        if ($this->sql !== false)
            return $this->sql;
        else
            Throw new ErrorException('Lost Connection to Database');
    }

    // return prefix
    public function getPrefix() {
        return $this->pref;
    }

    // return database name
    public function getDatabaseName() {
        return $this->db;
    }
}
?>
