<?php
/**
* @file     class_template.php
* @folder   /libs
* @version  0.1
* @author   Sweil
*
* this class is responsible for the template operations
* it's the base class for other template-related classes
*/

class template
{
    /**
    * here you may change the values of the tag opener and closer
    * We strictly recommend to not change these values, in all templates the default values {.. and ..} are used
    * opener and closer were changed from { and } to {.. and ..} because of some javascript incompatibilities
    **/
    const OPENER                = "{..";
    const CLOSER                = "..}";

    // vars for class options
    private $style              = "default";
    private $file               = null;
    private $clear_unassigned   = FALSE;

    // other vars
    private $tags               = array();
    private $sections           = array();
    private $sections_content   = array();
    private $template           = null;

    // constructor
    public function  __construct() {
         global $global_config_arr;
         $this->setStyle($global_config_arr['style']);
    }

    // functions to set & get default values
    public function setStyle($style) {
        if (file_exists(FS2_ROOT_PATH."styles/".$style)) {
            $this->style = $style;
            $this->clearSectionCache();
        } elseif ( $style != "default" )  {
            $this->setStyle("default");
        }
    }
    private function getStyle() {
        return $this->style;
    }
    
    public function getOpener() {
        return self::OPENER;
    }
    public function getCloser() {
        return self::CLOSER;
    }
    
    public function setFile($file) {
        if (file_exists(FS2_ROOT_PATH."styles/".$this->getStyle()."/".$file)) {
            $this->file = $file;
            $this->clearSectionCache();
        }
    }
    private function getFile() {
        return $this->file;
    }
    
    private function setSections($sections) {
        $this->sections = $sections;
    }
    private function getSectionNumber($section) {
        return $this->sections[$section];
    }
    private function setSectionsContent($content) {
        $this->sections_content = $content;
    }
    private function getSectionContent($section_number) {
        return $this->sections_content[$section_number];
    }
    public function clearSectionCache() {
        unset ($this->sections);
        unset ($this->sections_content);
        $this->sections = array();
        $this->sections_content = array();
    }

    public function clearTags() {
        unset ($this->tags);
        $this->tags = array();
    }
    
    public function deleteTag($tag) {
        //verbessern
        $this->tags[$tag] = null;
    }

    public function setClearUnassigned($boolean) {
        if (is_bool($boolean)) {
            $this->clear_unassigned = $clear_unassigned;
        }
    }

    private function setTemplate($template) {
        $this->template = $template;
    }
    private function getTemplate() {
        return $this->template;
    }
    
    // functions to access templates
    public function load($section) {
        if (count($this->sections) <= 0) {
            $file_path = FS2_ROOT_PATH."styles/".$this->getStyle()."/".$this->getFile();
            if (file_exists($file_path)) {
                $ACCESS = new fileaccess();
                $search_expression = '/<!--section-start::(.*)-->(.*)<!--section-end::(\1)-->/Uis';
                $number_of_sections = preg_match_all($search_expression, $ACCESS->getFileData($file_path), $sections);
                $this->setSections(array_flip($sections[1]));
                $this->setSectionsContent($sections[2]);
            }
        }
        $this->setTemplate($this->getSectionContent($this->getSectionNumber($section)));
    }
    
    public function display() {
        $template = $this->getTemplate();
        foreach ($this->tags as $tag => $value) {
            if ($value !== null) {
                $template = str_replace( self::OPENER . $tag . self::CLOSER, $value, $template);
            }
        }
        
        //ClearUnassigned if selected
        // todo...
        
        return $template;
    }

    // functions to assign values to tags
    public function tag($tag, $value) {
        $this->tags[$tag] = $value;
    }
    
    public function  __destruct(){
        $this->clearSectionCache();
        $this->clearTags();
    }
}
?>