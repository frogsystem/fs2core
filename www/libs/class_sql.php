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
            Throw new Exception("No Connection to Database"); 
        }
    }
    
    // Destructor closes SQL-Connection
    public function __destruct (){
        mysql_close($this->sql);
    }    
    
    
    // run any query
    public function doQuery ($qrystr) {
        $this->query = str_replace("{..pref..}", $this->pref, $qrystr); // replace {..pref..}
        $this->result = mysql_query($this->query, $this->sql); // execute query
        
        if ($this->result !== false) {
            unset($this->error);
            return $this->result;
        } else {
            $this->error[0] = mysql_errno($this->sql); // error number
            $this->error[1] = mysql_error($this->sql); // error text
            $this->error[2] = $this->query;            // query causing the error
            Throw new Exception("MySQL Error: [".$this->error[0]."] ".$this->error[1]."\n".$this->error[2]); 
        }
    }
    
    // build options
    private function opt ($options) {
        // init array
        $return = array();

        // set options
        if (isset($options['W']) && !empty($options['W']))
           $return[] = "WHERE ".$options['W'];

        if (isset($options['O']) && !empty($options['O']))
           $return[] = "ORDER BY ".$options['O'];

        if (isset($options['G']) && !empty($options['G']))
           $return[] = "GROUP BY ".$options['G'];

        if (isset($options['H']) && !empty($options['H']))
           $return[] = "HAVING ".$options['H'];

        if (isset($options['L']) && !empty($options['L']))
           $return[] = "LIMIT ".$options['L'];

        // return as string
        return " ".implode(" ", $return);
    }
    
    // execute SELECT
    private function select ($table, $cols, $options = array(), $distinct = false) {
        // empty cols
        if (empty($cols))
            Throw new Exception("MySQL Error: Can't select nothing.");
        if (is_array($table) && count($table) <= 0)
            Throw new Exception("MySQL Error: Can't select from nothing.");                
                    
                    
        // Table list
        if (is_array($table)) {
            // Computes to FROM `table1` ONE, `table2` TWO ...
            $table_list = array();
            foreach ($table as $as => $name) {
                $table_list[] = "`".$this->pref.$name."` ".$as;
            }
            $table_list = implode(", ", $table_list);
        } else {
            $table_list = "`".$this->pref.$table."`";
        }
                
        // prepare data
        if (is_array($cols)) {
            #if (is_array($table) && false !== ($r = array_diff_key($cols, $table)) && empty($r)) {
            if (is_array($table) && array_diff_key($cols, $table) === array()) {
                // Computes to SELECT ONE.`field1`, TWO.`field2` ...
                $cols_list = array();
                foreach ($cols as $from => $targets) {
                    foreach($targets as $name) {
                        $cols_list[] = $from.".`".$name."`";
                    }
                }
                $cols_list = implode(", ", $cols_list);
            } else {
                $cols_list = "`".implode("`, `", $cols)."`";
            }
            
        // error
        } elseif ($cols == "*") {
            $cols_list = $cols;
        } else {
            Throw new Exception("MySQL Error: Can't select because of bad data.");
        }

        // DISTINCT or not
        $select = ($distinct) ? "SELECT DISTINCT " : "SELECT ";
        
        // build query string...
        $qrystr = $select.$cols_list." FROM ".$table_list.$this->opt($options);
        
        try {
            return $this->doQuery($qrystr); // ... and execute
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
    }    
    
    
    
    
    // get data from database
    public function get ($table, $cols, $options = array(), $distinct = false) {
        // Get Data
        $rows = array();
        $result = $this->select($table, $cols, $options, $distinct);
        while ($row = mysql_fetch_assoc($result)) {
            $rows[] = $row;
        }
        
        // Return the result
        return array (
            'data' => $rows,
            'num' => count($rows),
        );
    }

    // only a single data row
    public function getRow ($table, $cols, $options = array(), $start = 0) {
        // Set Limit
        $options['L'] = "$start,1";

        // Get Result
        $result = $this->get($table, $cols, $options);
        if (count($result['data']) >= 1) 
            return $result['data'][0];
        else
            return array();
    }
    // single row by Id  
    public function getById ($table, $cols, $id) {
        $options = array ('W' => "`id`=".$id);
        return $this->getRow($table, $cols, $options);
    }
    
    // only a single data field
    public function getField ($table, $field, $options = array(), $start = 0) {
        // check for string
        if (!is_string($field))
            Throw new Exception("MySQL Error: Can't select because of bad data.");         
        
        // Set Limit
        $options['L'] = "$start,1";
    
        // Get Result
        $result = $this->select($table, array($field), $options);
        if (mysql_num_rows($result) > 0)     
            return mysql_result($result, 0, $field);
        else
            Throw new Exception("MySQL Error: Field not found");
    }
    // single field by Id  
    public function getFieldById ($table, $field, $id) {
        $options = array ('W' => "`id`=".$id);
        
        try {
            return $this->getField($table, $field, $options);
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
    }
    
    // num of rows
    public function num ($table, $cols, $options = array(), $distinct = false) {
        return mysql_num_rows($this->select($table, $cols, $options, $distinct));
    }

    // Saving to DB by Id
    // existing entry => update, else => insert
    public function save ($table, $data) {
        // Update
        if (isset($data['id']) && $this->getFieldById($table, "id", $data['id']) !== false) {
            return $this->updateById($table, $data);
                    
        // Insert
        } else  {
            unset($data['id']);
            return $this->insertId($table, $data);
        }
    }

    // insert statement
    public function insert ($table, $data) {
        // empty data
        if (empty($data))
            Throw new Exception("MySQL Error: Can't insert empty data."); 
        
        // prepare data
        $cols = ($vals = array());
        foreach($data as $column => $value) {
            $cols[] = "`".$column."`";
            $vals[] = "'".$value."'";            
        }

        // build query string...
        $qrystr = "INSERT INTO `".$this->pref.$table."` (".implode(",", $cols).") VALUES (".implode(",", $vals).")";
        
        try {
            return $this->doQuery($qrystr); // ... and execute
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
    }
    // insert with returning auto increment value
    public function insertId ($table, $data) {
        $this->insert($table, $data);
        
        try {
            return mysql_insert_id($this->sql);
        } catch (Exception $e) {
            print_r($e->getMessage());
        } 
    }    

    // update statement
    public function update ($table, $data, $options = array()) {
        // empty data
        if (empty($data))
            Throw new Exception("MySQL Error: Can't update empty data.");         
        
        // prepare data
        $list = array();
        foreach($data as $column => $value) {
            $list[] = "`".$column."` = '".$value."'";        
        }
        
        // build query string...
        $qrystr = "UPDATE `".$this->pref.$table."` SET ".implode(",", $list).$this->opt($options);
        
        try {
            return $this->doQuery($qrystr); // ... and execute
        } catch (Exception $e) {
            print_r($e->getMessage());
        }         
    }
    // update by Id
    public function updateById ($table, $data) {
        // check for id
        if (!isset($data['id']))
            Throw new Exception("MySQL Error: Can't update because of bad data.");             
        
        $options = array ('W' => "`id`=".$data['id']);
        
        try {
            return $this->update($table, $data, $options);
        } catch (Exception $e) {
            print_r($e->getMessage());
        }         
    }
    
    // delete statement
    public function delete ($table, $options = array()) {
        $qrystr = "DELETE FROM `".$this->pref.$table."`".$this->opt($options);
        
        try {
            return $this->doQuery($qrystr);
        } catch (Exception $e) {
            print_r($e->getMessage());
        }        
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
            Throw new Exception("Lost Connection to Database");
    }
}
?>
