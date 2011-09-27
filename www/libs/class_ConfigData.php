<?php
/**
 * @file     class_ConfigData.php
 * @folder   /libs
 * @version  0.1
 * @author   Sweil
 *
 * this class provides abstract class data for Config Objects
 * each config object has to implent its own constructor
 */
 
abstract class ConfigData {
    
    // Properties
    protected $config = array();      // config data
        
    // Force Extending class to define this method
    abstract public function __construct($data);

    // Common methods
    
    // set config 
    protected function setConfig($name, $value) {
        $this->config[$name] = $value;
    }
    
    // return config array
    public function getConfigArray() {
        return $this->config;
    }
    
    // get config
    protected function config($name) {
        return $this->config[$name];
    }
    protected function cfg($name) {
        return $this->config($name);
    }     
    
}
?>
