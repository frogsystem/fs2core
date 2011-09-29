<?php
/**
 * @file     ConfigEnv.php
 * @folder   /classes/config
 * @version  0.1
 * @author   Sweil
 *
 * this class provides the init of environment vars
 * 
 */

class ConfigEnv extends ConfigData {
    
    // Constructor
    // loading all data
    public function __construct($data) {
        global $sql, $spam, $path;
        
        // set start data
        $this->config = $data;

        // set env data
        $this->setConfig("date", time());
        $this->setConfig("year", date("Y", $this->cfg("date")));
        $this->setConfig("month", date("m", $this->cfg("date")));
        $this->setConfig("day", date("d", $this->cfg("date")));
        $this->setConfig("hour", date("H", $this->cfg("date")));
        $this->setConfig("min", date("i", $this->cfg("date")));
        $this->setConfig("pref", $sql->getPrefix());
        $this->setConfig("spam", $spam);
        $this->setConfig("data", $sql->getDatabaseName());
        $this->setConfig("path", $path);
    }  
}
?>
