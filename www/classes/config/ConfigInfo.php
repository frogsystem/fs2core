<?php
/**
 * @file     ConfigInfo.php
 * @folder   /classes/config/
 * @version  0.2
 * @author   Sweil
 *
 * this class provides the init for the page informations array
 *
 */

class ConfigInfo extends ConfigData {

    // startup
    public function startup() {
        // set canonical paramters default to null (= no paramters)
        $this->setConfig('canonical', null);
    }
}
?>
