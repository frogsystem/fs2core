<?php
/**
 * @file     ConfigMain.php
 * @folder   /classes/config/
 * @version  0.2
 * @author   Sweil
 *
 * this class provides the init of main config data
 *
 */

class ConfigMain extends ConfigData {

    // startup
    protected function startup() {
        global $sql, $spam, $path;

        // TODO: remove backwards compatibility, (soll in Zukunft nur in env)
        $this->setConfig('pref',        $sql->getPrefix());
        $this->setConfig('spam',        $spam);
        $this->setConfig('data',        $sql->getDatabaseName());
        $this->setConfig('path',        $path);

        // rewrite to other protocol if allowd
        if ($this->get('other_protocol')) {

            // script called by https
            if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == '1' || strtolower($_SERVER['HTTPS'])=='on')) {
                if ($this->get('protocol') == 'http://') {
                    $this->setConfig('protocol', 'https://');
                }

            // script called with http
            } else {
                if ($this->get('protocol') == 'https://') {
                    $this->setConfig('protocol', 'http://');
                }
            }
        }

        // write some other config data
        $this->setConfig('virtualhost',     $this->get('protocol').$this->get('url'));
        $this->setConfig('home_real',       $this->getRealHome($this->get('home'), $this->get('home_text')));
        $this->setConfig('language',        $this->getLanguage($this->get('language_text')));
        $this->setConfig('style',           $this->get('style_tag'));
        $this->setConfig('db_style_id',     $this->get('style_id')); // always contains db value
        $this->setConfig('db_style_tag',    $this->get('style_tag')); // always contains db value
    }


    // get real home
    private function getRealHome ($home, $home_text) {
        return ($home == 1) ? $home_text : 'news';
    }

    // get language
    private function getLanguage ($language_text) {
        return (is_language_text($language_text)) ? substr($language_text, 0, 2) : $language_text;
    }
}
?>
