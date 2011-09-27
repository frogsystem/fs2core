<?php
/**
 * @file     class_hash.php
 * @folder   /libs
 * @version  0.1
 * @author   Sweil
 *
 * this class represents a confirment hash
 */

class Hash
{
    // Klassen-Variablen    
    private $id;
    private $hash;
    private $type;
    private $typeId;
    private $deleteTime;

    // Der Konstruktur
    public function  __construct($opt_arr = array()) {
        $this->setOptions($opt_arr);
    }
    
    // magic set function
    public function __set($name, $value)
    {
        $method = "set".$name;
        if (!method_exists($this, $method)) {
            throw new Exception("Invalid property");
        }
        $this->$method($value);
    }
    
    // magic get function
    public function __get($name)
    {
        $method = "get".$name;
        if (!method_exists($this, $method)) {
            throw new Exception("Invalid property");
        }
        return $this->$method();
    }    
    
    // alle Options setzen
    public function setOptions(array $opt_arr) {
        
        foreach($opt_arr as $op => $value) {
            $method = "set".$op;
            if(method_exists($this, $method)) {
                $this->$method($opt_arr[$op]);
            }
        }
    }
    
    // setter
    public function setId($data) {
        $this->id = (integer) $data;
    }
    public function setHash($data) {
        $this->hash = (string) $data;
    }
    public function setType($data) {
        $this->type = $data;  
    }
    public function setTypeId($data) {
        $this->typeId = (integer) $data;
    }
    public function setDeleteTime($data) {
        $this->deleteTime = (integer) $data;
    }
    
    // getter
    public function getId() {
        return $this->id;
    }
    public function getHash() {
        return $this->hash;
    }
    public function getType() {
        return $this->type;
    }
    public function getTypeId() {
        return $this->typeId;
    }
    public function getDeleteTime() {
        return $this->deleteTime;
    }
    
    public function getURL() {
        return "?go=confirm&h=".$this->getHash();
    }

}
?>
