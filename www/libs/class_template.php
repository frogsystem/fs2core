<?php
//TODO: Contains fileaccess

/**
* @file     class_template.php
* @folder   /libs/
* @version  0.3
* @author   Sweil
*
* This class is responsible for the template operations.
* It's the base class for other template-related classes.
*/

class template
{
    /**
    * Here you may change the values of the tag opener and closer.
    * We strictly recommend to not change these values, in all templates the default values {.. and ..} are used.
    * Opener and closer were changed from { and } to {.. and ..} because of some JavaScript incompatibilities.
    **/
    const OPENER                = '{..';
    const CLOSER                = '..}';

    // vars for class options
    private $style              = 'default';
    private $file               = null;
    private $clear_unassigned   = FALSE;

    // other vars
    private $tags               = array();
    private $sections           = array();
    private $sections_content   = array();
    private $template           = null;

    // constructor
    public function  __construct() {
         global $FD;
         $this->setStyle($FD->cfg('style'));
    }

    // functions to set & get default values
    public function setStyle($style) {
        if (file_exists(FS2_ROOT_PATH.'styles/'.$style)) {
            $this->style = $style;
        } else  {
            $this->style = 'default';
        }
        $this->clearSectionCache();
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
        if ( is_readable ( FS2_ROOT_PATH.'styles/'.$this->getStyle().'/'.$file ) ) {
            $this->file = $file;
            $this->clearSectionCache ();
        } else {
            $this->__destruct ();
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

    private function sectionExists ( $section ) {
        if ( isset ( $this->sections[$section] ) ) {
            return TRUE;
        }
        return FALSE;
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
        $this->tags[$tag] = null;
    }

    public function setClearUnassigned($boolean) {
        $this->clear_unassigned = $clear_unassigned;
    }

    private function setTemplate($template) {
        $this->template = $template;
    }
    private function getTemplate() {
        return $this->template;
    }

    // functions to access templates
    public function load($section) {
        // If the section cache has not been filled yet => load all sections into cache
        if ( count ( $this->sections ) <= 0 ) {
            $file_path = FS2_ROOT_PATH . 'styles/' . $this->getStyle() . '/' . $this->getFile (); // Path of Template file
            $ACCESS = new fileaccess (); // Create object for file access
            $search_expression = '/<!--section-start::(.*)-->(.*)<!--section-end::(\1)-->/Uis'; // Regular expression to select Sections
            $number_of_sections = preg_match_all ( $search_expression, $ACCESS->getFileData($file_path), $sections ); // apply regular expression, count into $number_of_sections, contents into $sections
            $this->setSections ( array_flip ( $sections[1] ) ); // array_flip damit die Keys auch die Section-Namen sind
            $this->setSectionsContent ( $sections[2] ); // save Section contents
        }

        // Section Cache already filled => just read it
        if ( $this->sectionExists ( $section ) ) {
            $this->setTemplate ( $this->getSectionContent ( $this->getSectionNumber ( $section ) ) );
            return TRUE;
        } else { // If Section was not found
            return FALSE;
        }
    }

    // toString-Methode to return the template as string
    public function __toString() {
        $data = $this->getTemplate (); // load current Template
        foreach ( $this->tags as $theTag => $value ) { // iterate through tag list
            if ( $value !== null ) {
                $data = str_replace ( self::OPENER . $theTag . self::CLOSER, $value, $data ); // replace tags by values
            }
        }

        if ( $this->clear_unassigned ) {
            /*$replacement_arr = array (
                array ( '[',']','(',')','{','}','|','?','+','-','*','^','$','.' ),
                array ( "\[","\]","\(","\)","\{","\}","\|","\?","\+","\-","\*","\^","\$","\." )
            );*/

            //$safe_opener = str_replace ( $replacement_arr[0], $replacement_arr[1], self::OPENER );
            //$safe_closer = str_replace ( $replacement_arr[0], $replacement_arr[1], self::CLOSER );
            $safe_opener = preg_quote(self::OPENER);
            $safe_closer = preg_quote(self::CLOSER);
            $regexp = '/'.$safe_opener.'(.+)'.$safe_closer.'/U';
            preg_replace ( $regexp, '', $data );
        }

        return (string) $data;
    }
    public function display() {
        return $this->__toString();
    }

    // Sets template tag and corresponding replacement value
    public function tag ( $tag, $value ) {
        $this->tags[$tag] = $value;
    }

    // Destructor
    public function  __destruct(){
        $this->clearSectionCache();
        $this->clearTags();
    }
}
?>
