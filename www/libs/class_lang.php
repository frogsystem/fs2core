<?php
/**
* @file     class_lang.php
* @folder   /libs
* @version  0.3
* @author   Sweil
*
* this class is responsible for the language operations
* 
*/

class lang
{
    // vars for class options
    private $local              = null;
    private $type               = null;
    
    // other vars
    private $phrases            = array();    
    

    // constructor
    public function  __construct ($local, $type = false) {
        global $global_config_arr;
        $this->local = $local;
        
        if ($type !== false)
            $this->setType($type);
    }
    
    // destructor
    public function  __destruct(){
        unset($this->local, $this->type, $this->phrases);
    }    
    
    
    // function to assign phrases to tags
    private function add($tag, $text) {
        $this->phrases[$tag] = $text;
    }

    // load text data
    private function load() {    
        // reset phrases
        $this->phrases = array();
        
        // set file path
        $langDataPath = FS2_ROOT_PATH . "lang/" . $this->local . "/" . $this->type . ".txt";
        
        // include language data file
        if (file_exists($langDataPath)) {
            // load content
            $langData = file_get_contents($langDataPath);
            $langData = str_replace(array("\r\n", "\r"), "\n", $langData); // unify linebreaks
            $langData = preg_replace("/#.*?\n/is", "", $langData);
            $langData = explode("\n", $langData);
            
            // Run through lines
            foreach ($langData as $line) {
                preg_match ("#([a-z0-9_-]+?)\s*?:\s*(.*)#is", $line, $match);
                $this->add($match[1], $match[2]);
                unset($match);
            }
        } else {
            Throw new Exception("Language File not found: ".$langDataPath); 
        } 
    }
    
    

    // set used file
    public function setType($type) {
        $this->type = $type;
        try {
            $this->load();
        } catch (Exception $e) {
            $this->phrases = array();
        }
    }
    
    // function to display phrases
    public function get($tag) {
        if ( !isset($this->phrases[$tag]) || $this->phrases[$tag] == "" ) {
            return "LOCALIZE [".$this->local."]: " . $tag;
        } else {
            return $this->phrases[$tag];
        }
    }

}
