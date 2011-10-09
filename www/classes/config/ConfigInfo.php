<?php
/**
 * @file     ConfigInfo.php
 * @folder   /classes/config
 * @version  0.1
 * @author   Sweil
 *
 * this class provides the init for the page informations array
 * 
 */

class ConfigInfo extends ConfigData {
    
    // Constructor
    // loading all data
    public function __construct($data) {
        
        // set start data
        $this->config = $data;

        // set env data
        $this->setConfig("canonical", false);
    }  
}
?>
