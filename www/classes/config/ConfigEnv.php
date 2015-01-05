<?php
/**
 * @file     ConfigEnv.php
 * @folder   /classes/config/
 * @version  0.2
 * @author   Sweil
 *
 * this class provides the init of environment vars
 *
 */

class ConfigEnv extends ConfigData {

    // startup
    protected function startup() {
        global $sql, $spam, $path;

        // set env data
        $this->setConfig('date', time());
        $this->setConfig('time', $this->get('date'));
        $this->setConfig('year', date('Y', $this->get('date')));
        $this->setConfig('month', date('m', $this->get('date')));
        $this->setConfig('day', date('d', $this->get('date')));
        $this->setConfig('hour', date('H', $this->get('date')));
        $this->setConfig('min', date('i', $this->get('date')));
        $this->setConfig('pref', $sql->getPrefix());
        $this->setConfig('spam', $spam);
        $this->setConfig('data', $sql->getDatabaseName());
        $this->setConfig('path', $path);
    }
}
?>
