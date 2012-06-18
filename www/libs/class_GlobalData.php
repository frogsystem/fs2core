<?php
/**
 * @file     class_global_data.php
 * @folder   /libs/
 * @version  0.3
 * @author   Sweil
 *
 * this class provides access to the frogsystem 2 global data
 * including global config, page informations, applet data, etc..
 */

class GlobalData {

    // Properties
    private $sql;                   // sql connectin
    private $text = array();        // Text objects
    private $config = array();      // config data

    // Constructor
    //
    public function __construct(&$sql) {

        // Set sql connection
        $this->sql = $sql;

        // set config data
        $this->loadConfigsByHook('startup');

        //get Text object
        $this->text = array(
            'frontend'  => new lang ($this->config('language_text'), 'frontend'),
            'admin'     => new lang ($this->config('language_text'), 'admin'),
            'template'  => new lang ($this->config('language_text'), 'template'),
            'menu'      => new lang ($this->config('language_text'), 'menu'),
            'fscode'    => new lang ($this->config('language_text'), 'fscode'),
        );
    }

    // Destructor closes SQL-Connection
    public function __destruct (){
        $this->closeSql();
    }


    // load configs
    public function loadConfig($name) {
        // Load config from DB
        $data = $this->sql->getRow('config', '*', array('W' => "`config_name` = '".$name."'"));
        
        // Load corresponding class and get config array
        $class_name = "Config".ucfirst(strtolower($config['config_name']));
        require_once(FS2_ROOT_PATH.'libs/class_ConfigData.php');
        @include_once(FS2_ROOT_PATH.'classes/config/'.$class_name.'.php');
        if (!class_exists($class_name))
            $class_name = "ConfigData";
        $this->config[$config['config_name']] = new $class_name($config['config_data'], true);
    }
    
    // load configs by hook
    private function loadConfigsByHook($hook) {

        // include ConfigData
        require_once(FS2_ROOT_PATH . 'libs/class_ConfigData.php');

        // Load configs from DB
        $data = $this->sql->getData('config', '*', array('W' => "`config_loadhook` = '".$hook."'") );
        foreach ($data as $config) {
            // Load corresponding class and get config array
            $class_name = "Config".ucfirst(strtolower($config['config_name']));
            require_once(FS2_ROOT_PATH.'libs/class_ConfigData.php');
            @include_once(FS2_ROOT_PATH.'classes/config/'.$class_name.'.php');
            if (!class_exists($class_name))
                $class_name = "ConfigData";
            $this->config[$config['config_name']] = new $class_name($config['config_data'], true);
        }

        $this->setOldArray();   // TODO remove backwards compatibility
    }

    // set config
    public function setConfig() {
        // default global config
        if (func_num_args() == 2) {
            $this->config['main']->setConfig(func_get_arg(0), func_get_arg(1));

        // return other configs
        } elseif (func_num_args() == 3) {
            $this->config[func_get_arg(0)]->setConfig(func_get_arg(1), func_get_arg(2));

        // error
        } else {
            Throw Exception('Invalid Call of method "setConfig"');
        }

        //TODO backwards update $global_config_att
        $this->setOldArray();
    }

    // set config
    public function saveConfig($type, $newdata) {
        try {
            //get data from db
            $olddata = $this->sql->getRow('config', array('config_data'), array('W' => "`config_name` = '".$type."'"));
            $olddata = array_map('utf8_decode', json_decode($olddata['config_data'], true));

            // update data
            foreach ($newdata as $name => $value) {
                $olddata[$name] = $value;
            }

            // convert back to json
            $newdata = array(
                'config_name' => $type,
                'config_data' => json_array_encode($olddata),
            );

            // save to db
            $this->sql->save('config', $newdata, 'config_name');

            // Reload Data
            $this->loadConfig($this->cfg('env', 'spam'), $this->cfg('env', 'path'));

        } catch (Exception $e) {
            throw $e;
        }
    }

    // get config
    public function config() {

        // default global config
        if (func_num_args() == 1) {
            return $this->config['main']->get(func_get_arg(0));

        // return other configs
        } elseif (func_num_args() == 2) {
            return $this->config[func_get_arg(0)]->get(func_get_arg(1));

        // error
        } else {
            Throw Exception('Invalid Call of method "config"');
        }

    }
    // Aliases
    public function cfg() {
        return call_user_func_array(array($this, 'config'), func_get_args());
    }
    public function env($arg) {
        return $this->cfg('env', $arg);
    }
    public function system($arg) {
        return $this->cfg('system', $arg);
    }
    public function info($arg) {
        return $this->cfg('info', $arg);
    }




    // get sql
    public function sql() {
        return $this->sql;
    }
    // Destruct SQL => Close Connection
    private function closeSql() {
        $this->sql->__destruct();
    }


    // get lang phrase object
    public function text($type, $tag) {
        if (isset($this->text[$type]))
            return $this->text[$type]->get($tag);

        return null;
    }

    // get lang phrase object
    public function setPageText($obj) {
        return $this->text['page'] = $obj;
    }





    // TODO backwards, create global config array
    public function setOldArray() {
        global $global_config_arr;

        $global_config_arr = $this->config['main']->getConfigArray();
        $global_config_arr['system'] = $this->config['system']->getConfigArray();
        $global_config_arr['env'] = $this->config['env']->getConfigArray();
    }
    public function getOldTetxt() {
        return $this->text['frontend'];
    }

}


?>
