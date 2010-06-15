<?php
/**
 * @file     class_sql.php
 * @folder   /libs
 * @version  0.1
 * @author   Satans Krümelmonster
 *
 * this class provides several methods to improve sql-query-coding
 */
class sql {

    private $sql;
    private $pref;
    private $error;
    private $qrystr;

    /**
    * Speichert Die SQL-Verbindung, den Datenbank-Namen und das Präfix zur spätern Verwendung
    *
    * @name sql::__construct();
    *
    * @param resource $mysql_res
    * @param String $mysql_db
    * @param String $pref
    *
    * @return bool
    */
    public function __construct ( $host, $data, $user, $pass, $pref ){
        $this->sql = @mysql_connect ( $host, $user, $pass );
        if ( $this->sql && mysql_select_db ( $data, $this->sql ) ) {
            $this->db = $data;
            $this->pref = $pref;
        } else {
            $this->sql = null;
        }
    }
  
    /**
    * Gibt die MySQL-Ressource zurück
    *
    * @name sql::getRes();
    *
    * @param void
    *
    * @return mixed
    */
    public function getRes () {
        if ( isset ( $this->sql ) && $this->sql !== null ) {
            return $this->sql;
        } else {
            return FALSE;
        }
    }
    
    /**
    * Gibt einen den Error zurück
    *
    * @name sql::getError();
    *
    * @param void
    *
    * @return mixed
    */
    public function getError () {
        if ( isset ( $this->error ) && $this->error !== null ) {
            return $this->error;
        } else {
            return FALSE;
        }
    }
    
    /**
    * Gibt den Query-String zurück
    *
    * @name sql::getQueryString();
    *
    * @param void
    *
    * @return mixed
    */
    public function getQueryString () {
        if ( isset ( $this->qrystr ) && $this->qrystr !== null ) {
            return $this->qrystr;
        } else {
            return FALSE;
        }
    }
  
    /**
    * Executes the actual query
    *
    * @name sql::doQuery();
    *
    * @param void
    *
    * @return boolean
    */
    private function doQuery () {
        if ( !isset ( $this->qrystr ) ) {                   // break if no query string exists
            return FALSE;
        }
        
        mysql_query ( $this->qrystr, $this->sql );          // execute the query
        unset( $this->qrystr, $this->error );               // unset query string and error
        if ( mysql_error ( $this->sql ) !== "" ) {          // list errors
            $this->error[0] = mysql_errno ( $this->sql );
            $this->error[1] = mysql_error ( $this->sql );
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
    * Führt ein einfaches Query durch
    *
    * @name sql::query();
    *
    * @param String $qrystr
    * @return resource
    */
    public function query ( $qrystr ){
        $this->qrystr = str_replace ( "{..pref..}", $this->pref, $qrystr );
        return $this->doQuery();
    }
    
    /**
    * Gibt die Insert ID zurück
    *
    * @name sql::getInsertId();
    *
    * @param String $qrystr
    * @return resource
    */
    public function getInsertId (){
        if ( !$this->getRes () ) {
            return FALSE;
        }
        return mysql_insert_id ( $this->sql );
    }

  /**
  * Führt ein SELECT-Query durch
  *
  * @name sql::getData();
  *
  * @param String $table
  * @param String $row
  * @param String $optional
  * @param int $addititional
  * @return mixed
  */
  public function getData($table, $row, $optional="", $addititional=0){
    unset($this->error, $this->qrystr);                            // Error leeren
    $qrystr="SELECT ".$row." FROM `".$this->pref.$table."`";  // Querystring aufbauen
    if(!empty($optional)){
      $qrystr.=" ".$optional;                           // Optionale Angaben (WHERE, LIMT, etc.) anhängen)
    }
    $this->qrystr = $qrystr;
    $qry = mysql_query($qrystr, $this->sql);       // Query durchführen
    if(mysql_error($this->sql) !== ""){             // Fehler listen
      $this->error[0] = mysql_errno($this->sql);
      $this->error[1] = mysql_error($this->sql);
      return false;
    } else {
      if(mysql_num_rows($qry) == 0 || $addititional == 2){
        return mysql_num_rows($qry);
      }
      $ret=array();
      while($erg=mysql_fetch_assoc($qry)){
        $ret[]=array_map("stripslashes", $erg);
      }
      switch($addititional){
        case 0:             // Keine zusätzlichen Angaben
          return $ret;
          break;
        case 1:             // Einzelnes Resultat zurückgeben
          if(count($ret[0]) === 1){                 // eine oder mehrere Zeilen angegeben?
            $keys = array_keys($ret[0]);
            return $ret[0][$keys[0]];
          } else {
            return $ret[0];
          }
          break;
        case 3:
          return $qry;
          break;
        default:            // nicht implementierte Angabe
          return false;
          break;
      }
    }
  }

  /**
  * Führt ein Insert-Query durch
  *
  * @name sql::setData();
  *
  * @param String $table
  * @param String $rows
  * @param String $values
  *
  * @return bool
  */
  public function setData ( $table, $rows, $values ) {

    $rows   = explode ( ",", $rows );
    $values = explode ( ",", $values );
    if ( count ( $rows ) !== count ( $values ) || count ( $rows ) === 0 || count ( $values ) === 0 ) {
      return FALSE;
    }
    $this->arraytrim ( $rows );
    $this->arraytrim ( $values );
    $rows   = "`" . implode ( "`, `", $rows ) . "`";
    $values = "'" . implode ( "', '", $values ) . "'";
    
    $this->qrystr = "INSERT INTO `".$this->pref.$table."` (".$rows.") VALUES (".$values.")";
    return $this->doQuery();
  }

    /**
    * Führt ein Update-Query durch
    *
    * @name sql::updateData();
    *
    * @param String $table
    * @param String $rows
    * @param String $values
    * @param String $additional = ""
    * @return bool
    */
    public function updateData ( $table, $rows, $values, $additional = "" ) {
        $qrystr = "UPDATE `".$this->pref.$table."` SET ";
        $rows   = explode ( ",", $rows );
        $values = explode ( ",", $values );
        if ( count ( $rows ) !== count ( $values ) || count ( $rows ) === 0 ) {
            return FALSE;
        }
        $this->arraytrim ( $rows );
        $this->arraytrim ( $values );
        for ( $i = 0; $i < count($rows); $i++ ) {
            $qrystr .= "`".$rows[$i]."` = '".$values[$i]."'";
            if ( $i != count($rows)-1 ){
                $qrystr .= ", ";
            }
        }
        $qrystr .= ( $additional != "" ) ? " ".$additional : "";
        $this->qrystr = $qrystr;
        return $this->doQuery();
    }
  
    /**
    * Führt ein Delete-Query durch
    *
    * @name sql::deleteData();
    *
    * @param String $conditions = ""
    * @param String $additional = ""
    * @return bool
    */
    public function deleteData ( $table, $conditions = "", $additional = "" ) {
        $qrystr = "DELETE FROM `".$this->pref.$table."`";
        $qrystr .= ( $conditions != "" ) ? " WHERE ".$conditions : "";
        $qrystr .= ( $additional != "" ) ? " ".$additional : "";

        $this->qrystr=$qrystr;
        return $this->doQuery();
    }

    /**
    * Wendet die Methode "trim" rekrusiv auf alle Werte in einem Array an.
    *
    * @name sql::arraytrim();
    * @param Array &$array
    * @return void
    */
    public function arraytrim ( &$array ) {
        foreach ( $array as $key => $value ) {
            if ( is_array($array[$key] ) ) {
                $this->arraytrim ( $array[$key] );
            } else {
                $array[$key] = trim ( $value );
            }
        }
    }
}
?>