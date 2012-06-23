<?php
/**
 * @file     class_ConfigData.php
 * @folder   /libs/
 * @version  0.3
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
    final public function __construct($data, $json = false) {
        // set start data
        if ($json) {
            $data = json_decode($data, true);
            // empty json creates null instead of emtpy array => error
            if (empty($data)) // prevent this
                $data = array();
            $this->config = array_map("utf8_decode", $data);
        } else {
            $this->config = $data;
        }
            
        // call startup method
        $this->startup();
    }

    // Common methods

    // methode called on object init
    // override this methode
    public function startup() {
        // do something here if you want
    }

    // set specific config entry to value in local copy
    // does not change any database data
    public function setConfig($name, $value) {
        $this->config[$name] = $value;
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
