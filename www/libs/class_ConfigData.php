<?php
/**
 * @file     class_ConfigData.php
 * @folder   /libs/
 * @version  0.4
 * @author   Sweil
 *
 * this class provides data for Config Objects
 * a config object may have its own implemantation of startup()
 */

class ConfigData {

    // Properties
    protected $config = array();      // config data

    // create config object
    // DO NOT OVERRIDE
    // use startup() for your code
    final public  function __construct($data = array(), $json = false) {      
        // set start data
        if ($json) {
            $this->config = json_array_decode($data);
        } else {
            $this->config = $data;
        }
            
        // call startup method
        $this->startup();
    }

    // Common methods

    // methode called on object init
    // override this methode
    protected function startup() {
        // do something here if you want
    }

    // set specific config entry to value in local copy
    // does not change any database data
    public function setConfig($name, $value) {
        $this->config[$name] = $value;        
        return $this;
    }
    
    // set multiple config entries to value in local copy
    // does not change any database data
    public function setConfigByArray($config) {
        $this->config += $config;        
        return $this;
    }
    
    // set multiple config entries from a confog file
    // does not change any database data
    public function setConfigByFile($name) {
        
        $file = "/{$name}.cfg.php";
        if ('production' !== FS2_ENV) {
            $file_env = "/{$name}-{FS2_ENV}.cfg.php";
            if (file_exists(FS2CONFIG.$file_env)) {
                $file = $file_env;
            }
        }
        
        $config = array();
        include(FS2CONFIG."/".$file);
        return $this->setConfigByArray($config);
    }



    // return config as array
    public function getConfigArray() {
        return $this->config;
    }
    
    // return config as json
    public function getConfigJson() {
        return json_array_encode($this->config);
    }

    // get config entry
    public function get($name) {
        return $this->config[$name];
    }
    
    // isset config entry
    public function exists($name) {
        return isset($this->config[$name]);
    }
}
?>
