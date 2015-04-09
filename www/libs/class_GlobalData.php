<?php
/**
 * @file     class_global_data.php
 * @folder   /libs/
 * @version  0.4
 * @author   Sweil
 *
 * this class provides access to the frogsystem 2 global data
 * including global config, page informations, applet data, etc..
 */

use Frogsystem2\Event\EventManagerInterface;

class GlobalData {

    // Properties
    /**
     * Database connection
     * @var sql
     */
    private $db = null;

    /**
     * Text objects
     * @var lang[]
     */
    private $text = array();

    /**
     * config data
     * @var ConfigData[]
     */
    private $config = array();

    /**
     * @var EventManagerInterface
     */
    private $systemEventManager;

    /**
     * @return EventManagerInterface
     */
    public function getSystemEventManager()
    {
        return $this->systemEventManager;
    }

    /**
     * @param EventManagerInterface $systemEventManager
     * @return $this
     */
    public function setSystemEventManager(EventManagerInterface $systemEventManager)
    {
        $this->systemEventManager = $systemEventManager;
        return $this;
    }

    // Constructor
    //
    public function __construct() {
        // get env cfg
        require_once(FS2SOURCE.'/libs/config/ConfigEnv.php');
        $this->config['env'] = new ConfigEnv();
    }

    // Destructor closes DB-Connection
    public function __destruct (){
        $this->closeConnection();
    }
    

    // connect to Database
    public function connect() {
        $this->db = new sql($this->env('DB_HOST'), $this->env('DB_NAME'), $this->env('DB_USER'), $this->env('DB_PASSWORD'), $this->env('DB_PREFIX'));
        return $this->db;
    }
    // get db Database connection
    public function db() {
        return $this->db;
    }
    public function sql() {
        trigger_error('Use of $FD->sql is deprecated. Please use $FD->db.', E_USER_DEPRECATED);
        return $this->db();
    }
    // Destruct Database Connection => Close Connection
    private function closeConnection() {
        $this->db->__destruct();
        return $this;
    }
    
    
    // startup the system
    public function startup() {
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
        
        return $this;
    }


    // load config
    // use reloadConfig if you want to get the data fresh from the databse
    public function loadConfig($name) {
        // only if config not yet exists
        if (!$this->configExists($name))
            $this->config[$name] = $this->getConfigObjectFromDatabase($name);
    }

    // reload config
    private function reloadConfig($name, $data = null, $json = false) {
        // get from DB
        if (empty($data)) {
            $this->config[$name] = $this->getConfigObjectFromDatabase($name);

        // set data from input
        } else {
            $this->config[$name] = $this->createConfigObject($name, $data, $json);
        }
    }

    // load configs by hook
    public function loadConfigsByHook($hook, $reload = false) {

        // include ConfigData
        require_once(FS2SOURCE . '/libs/class_ConfigData.php');

        // Load configs from DB
        $data = $this->db->conn()->prepare(
                        'SELECT * FROM '.$this->db->getPrefix().'config
                         WHERE `config_loadhook` = ?');
        $data->execute(array($hook));
        $data = $data->fetchAll(PDO::FETCH_ASSOC);
        foreach ($data as $config) {
            // Load corresponding class and get config array
            if ($reload || !$this->configExists($config['config_name']))
                $this->config[$config['config_name']] = $this->createConfigObject($config['config_name'], $config['config_data'], true);
        }
    }

    // create config object
    private function createConfigObject($name, $data, $json) {
        // Load corresponding class and get config array
        $class_name = "Config".ucfirst(strtolower($name));
        require_once(FS2SOURCE.'/libs/class_ConfigData.php');
        @include_once(FS2SOURCE.'/libs/config/'.$class_name.'.php');
        if (!class_exists($class_name, false))
            $class_name = 'ConfigData';
        return new $class_name($data, $json);
    }

    // create config object from db
    private function getConfigObjectFromDatabase($name) {
        // Load config from DB
        $config = $this->db->conn()->prepare(
                         'SELECT * FROM '.$this->db->getPrefix().'config
                          WHERE `config_name` = ? LIMIT 1');
        $config->execute(array($name));
        $config = $config->fetch(PDO::FETCH_ASSOC);

        // Load corresponding class and get config array
        return $this->createConfigObject($config['config_name'], $config['config_data'], true);
    }


    // get access on a config object
    public function configObject($name) {
        // Load corresponding class and get config array
        return  $this->config[$name];
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
            Throw new Exception('Invalid Call of method "setConfig"');
        }
    }

    // set config
    public function saveConfig($name, $newdata) {
        try {
            //get original data from db
            $original_data = $this->db->getField('config', 'config_data', array('W' => "`config_name` = '".$name."'"));
            if (!empty($original_data))
                $original_data = json_array_decode($original_data);
            else {
                $original_data = array();
            }


            // update data
            foreach ($newdata as $key => $value) {
                $original_data[$key] = $value;
            }

            // convert back to json
            $newdata = array(
                'config_name' => $name,
                'config_data' => json_array_encode($original_data),
            );

            // save to db
            $this->db->save('config', $newdata, 'config_name', false);

            // Reload Data
            $this->reloadConfig($name, $newdata['config_data'], true);

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
            Throw new Exception('Invalid Call of method "config"');
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

    // config and/or key exists
    public function configExists() {

        // check for config
        if (func_num_args() == 1) {
            return isset($this->config[func_get_arg(0)]);

        // check for config-key
        } else {
            return isset($this->config[func_get_arg(0)]) && $this->config[func_get_arg(0)]->exists(func_get_arg(1));
        }
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

}
