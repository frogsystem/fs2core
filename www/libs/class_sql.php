<?php
/**
 * @file     class_sql.php
 * @folder   /libs
 * @version  0.1
 * @author   Satans Kr�melmonster
 *
 * this class provides several methods to improve sql-query-coding
 */
class sql{
  private $sql   = null;
  private $pref  = null;
  public $error = null;
  public $qrystr;

  /**
   * Speichert Die SQL-Verbindung, den Datenbank-Namen und das Pr�fix zur sp�tern Verwendung
   *
   * @name sql::__construct();
   *
   * @param resource $mysql_res
   * @param String $mysql_db
   * @param String $pref
   *
   * @return bool
   */
  public function __construct($host, $data, $user, $pass, $pref){
	$this->sql = @mysql_connect($host, $user, $pass);
    if($this->sql && mysql_select_db($data, $this->sql)){
      $this->db = $data;
      $this->pref = $pref;
    } else {
      $this->sql = null;
    }
  }
  
  /**
   * Gibt die MySQL-Ressource zur�ck
   *
   * @name sql::__construct();
   *
   * @param void
   *
   * @return mixed
   */
  public function getRes(){
    if($this->sql !== null)
      return $this->sql;
    else
      return false;
  }

  /**
  * F�hrt ein einfaches Query durch
  *
  * @name sql::query();
  *
  * @param String $qrystr
  * @return resource
  */
  public function query($qrystr){
    unset($this->error, $this->qrystr);                       // Error leeren
    $this->qrystr = str_replace("{..pref..}", $this->pref, $qrystr);
    @$qry = mysql_query($this->qrystr, $this->sql);  // Query durchf�hren
    if(mysql_error($this->sql) !== ""){              // Fehler listen
      $this->error[0] = mysql_errno($this->sql);
      $this->error[1] = mysql_error($this->sql);
      return false;
    } else {
      return $qry;
    }
  }

  /**
  * F�hrt ein SELECT-Query durch
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
      $qrystr.=" ".$optional;                           // Optionale Angaben (WHERE, LIMT, etc.) anh�ngen)
    }
    $this->qrystr = $qrystr;
    $qry = mysql_query($qrystr, $this->sql);       // Query durchf�hren
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
        case 0:             // Keine zus�tzlichen Angaben
          return $ret;
          break;
        case 1:             // Einzelnes Resultat zur�ckgeben
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
  * F�hrt ein Insert-Query durch
  *
  * @name sql::setData();
  *
  * @param String $table
  * @param String $rows
  * @param String $values
  *
  * @return bool
  */
  public function setData($table, $rows, $values){
    unset($this->error, $this->qrystr);
    $this->qrystr = "INSERT INTO `".$this->pref.$table."`(".$rows.") VALUES(".$values.")";
    @mysql_query($this->qrystr, $this->sql);
    if(mysql_error($this->sql) == ""){
      return true;
    } else {
      $this->error[0] = mysql_errno($this->sql);
      $this->error[1] = mysql_error($this->sql);
      return false;
    }
  }

  /**
  * F�hrt ein Update-Query durch
  *
  * @name sql::updateData();
  *
  * @param String $table
  * @param String $rows
  * @param String $values
  * @param String $addititional = ""
  * @return bool
  */
  public function updateData($table, $rows, $values, $addititional=""){
    unset($this->error, $this->qrystr);
    $qrystr="UPDATE ".$this->pref.$table." SET ";
    $rows   = explode(",", $rows);
    $values = explode(",", $values);
    if(count($rows) !== count($values) || count($rows) === 0){
      return false;
    }
    $this->arraytrim($rows);
    $this->arraytrim($values);
    for($i = 0; $i < count($rows); $i++){
      $qrystr .= $rows[$i]."=".$values[$i];
      if($i != count($rows)-1){
        $qrystr .= ", ";
      }
    }
    $qrystr .= " ".$addititional;
    $this->qrystr=$qrystr;
    @mysql_query($qrystr, $this->sql);
    if(mysql_error($this->sql)==""){
      return true;
    } else {
      $this->error[0] = mysql_errno($this->sql);
      $this->error[1] = mysql_error($this->sql);
      return false;
    }
  }

  /**
  * Wendet die Methode "trim" auf alle Werte in einem Array an.
  *
  * @name sql::arraytrim();
  * @param Array &$array
  * @return void
  */
  public function arraytrim(&$array){
    foreach($array as $key => $value){
      if(is_array($array[$key])){
        $this->arraytrim($array[$key]);
      } else {
        $array[$key] = trim($value);
      }
    }
  }
}
?>