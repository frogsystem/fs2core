<?php
/**
 * @file     ConfigInfo.php
 * @folder   /libs/config/
 * @version  0.2
 * @author   Sweil
 *
 * this class provides the init for the page informations array
 *
 */

class ConfigInfo extends ConfigData {

    // startup
    protected function startup() {
        // set canonical paramters default to null (= no paramters)
        $this->setConfig('canonical', null);
    }
}
?>
