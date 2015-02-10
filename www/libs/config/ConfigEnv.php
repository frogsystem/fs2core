<?php
/**
 * @file     ConfigEnv.php
 * @folder   /libs/config/
 * @version  0.4
 * @author   Sweil
 *
 * this class provides the init of environment vars
 *
 */

class ConfigEnv extends ConfigData {

    // startup
    protected function startup() {
        // Load env config
        $this->setConfigByFile('env');
        
        // set env data
        $this->setConfig('date', time());
        $this->setConfig('time', $this->get('date'));
        $this->setConfig('year', date('Y', $this->get('date')));
        $this->setConfig('month', date('m', $this->get('date')));
        $this->setConfig('day', date('d', $this->get('date')));
        $this->setConfig('hour', date('H', $this->get('date')));
        $this->setConfig('minute', date('i', $this->get('date')));
        $this->setConfig('path', FS2CONTENT.'/');
        
        // DEPRECATED
        $this->setConfig('min', $this->get('minute'));
        $this->setConfig('pref', $this->get('DB_PREFIX'));
        $this->setConfig('spam', $this->get('SPAM_KEY'));
        $this->setConfig('data', $this->get('DB_NAME'));
    }
    
    // get config entry
    public function get($name) {
        if (oneof($name, 'pref', 'spam', 'data', 'min')) {
            trigger_error("Usage of config value env/{$name} is deprecated.", E_USER_DEPRECATED);
        }
        return $this->config[$name];
    } 
}
?>
