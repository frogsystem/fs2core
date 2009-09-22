<?php
/**
* @file     class_lang.php
* @folder   /libs
* @version  0.1
* @author   Sweil
*
* this class is responsible for the language operations
* it is used by langDataInit class
*/

class lang
{
    // vars for class options
    private $local              = null;
    private $type               = null;
    private $allow_add          = TRUE;
    
    // other vars
    private $phrases            = array();
    
    // constructor
    public function  __construct($local) {
         global $global_config_arr;
         $this->local = $local;
    }

    public function disableAdd() {
        $this->allow_add = FALSE;
    }
    public function getAllowState() {
        return $this->allow_add;
    }
    
    // function to assign phrases to tags
    public function add($tag, $text) {
        if ( $this->allow_add ) {
            $this->phrases[$tag] = $text;
        }
    }
    // function to display phrases
    public function get($tag) {
        if ( !isset($this->phrases[$tag]) || $this->phrases[$tag] == "" ) {
            return "LOCALIZE: " . $tag;
        } else {
            return $this->phrases[$tag];
        }
    }

    // destructor
    public function  __destruct(){
        $this->phrases = null;
        $this->local = null;
    }
}