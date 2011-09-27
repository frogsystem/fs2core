<?php
/**
 * @file     ConfigSystem.php
 * @folder   /classes/config
 * @version  0.1
 * @author   Sweil
 *
 * this class provides the init of system config data
 * 
 */

class ConfigSystem extends ConfigData {
    
    // Constructor
    // loading all data
    public function __construct($data) {
        // set start data
        $this->config = $data;
    }  
}
?>
