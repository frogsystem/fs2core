<?php
/**
* @file     class_langDataInit.php
* @folder   /libs
* @version  0.1
* @author   Sweil
*
* this class is responsible for the initialisation of languages data
* it calls the the pharse-resources in the /lang-folder
*/

class langDataInit
{
    // vars for class options
    private $local              = null;
    private $type               = null;
    private $langData;

    // constructor
    public function  __construct ( $local, $type ) {
        global $global_config_arr;
        
        // set vars
        $this->local = $local;
        $this->type = $type;

        // include lang-class & create object
        require_once ( FS2_ROOT_PATH . "libs/class_lang.php");
        $this->langData = new lang($type);

        // include language data file
        $filepath = FS2_ROOT_PATH . "lang/" . $this->local . "/" . $this->type . ".php";
        if ( file_exists ( $filepath ) ) {
            unset ( $TEXT );
            include ( $filepath );

            // map data to object
            foreach ( $TEXT as $tag => $phrase ) {
                $this->langData->add($tag,$phrase);
            }
            unset ( $TEXT );
        }
        // secure object for manipulation
        $this->langData->disableAdd();
    }
    
    // map get fucntion on langDataInit
    public function get($tag) {
        return $this->langData->get($tag);
    }
    
    // destructor
    public function  __destruct(){
        $this->local = null;
        $this->type = null;
        $this->langData = null;
    }
}