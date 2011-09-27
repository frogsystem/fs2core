<?php
/**
 * @file     ConfigMain.php
 * @folder   /classes/config
 * @version  0.1
 * @author   Sweil
 *
 * this class provides the init of main config data
 * 
 */

class ConfigMain extends ConfigData {
    
    // Constructor
    // loading all data
    public function __construct($data) {
        global $sql, $spam, $path;
        
        // set start data
        $this->config = $data;
        
        //write some env vars into config for backwards
        // TODO: backwards, muss raus (soll in Zukunft in env)
        $this->setConfig("pref",        $sql->getPrefix());
        $this->setConfig("spam",        $spam);
        $this->setConfig("data",        $sql->getDatabaseName());
        $this->setConfig("path",        $path);

        // write some other config data
        $this->setConfig("home_real",   $this->getRealHome($this->cfg("home"), $this->cfg("home_text")));
        $this->setConfig("language",    $this->getLanguage($this->cfg("language_text")));
        $this->setConfig("style",       $this->cfg("style_tag"));
    }


    // get real home
    private function getRealHome ($home, $home_text) {
        return ($home == 1) ? $home_text : "news";
    }

    // get language
    private function getLanguage ($language_text) {
        return (is_language_text($language_text)) ? substr($language_text, 0, 2) : $language_text;
    }    
}
?>
