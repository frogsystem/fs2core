<?php
//TODO: Beinhaltet fileaccess

/**
* @file     class_template.php
* @folder   /libs
* @version  0.3
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
         global $global_config_arr;
         $this->setStyle($global_config_arr['style']);
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
        // Wenn der Section-Cache wurde noch nicht befüllt wurde => alle Sections in den Cache laden
        if ( count ( $this->sections ) <= 0 ) {
            $file_path = FS2_ROOT_PATH . 'styles/' . $this->getStyle() . '/' . $this->getFile (); // Pfad zur Template-Datei
            $ACCESS = new fileaccess (); // Object für Dateizugriff erzeugen
            $search_expression = '/<!--section-start::(.*)-->(.*)<!--section-end::(\1)-->/Uis'; // Regulärer Ausruck um Sections auszuwählen
            $number_of_sections = preg_match_all ( $search_expression, $ACCESS->getFileData($file_path), $sections ); // Regulären Ausruck ausführen, Anzahl in $number_of_sections, Inhalte in $sections
            $this->setSections ( array_flip ( $sections[1] ) ); // array_flip damit die Keys auch die Section-Namen sind
            $this->setSectionsContent ( $sections[2] ); // Section Inhalte speichern
        }

        // Section-Cache wurde bereits befüllt => einfach auslesen
        if ( $this->sectionExists ( $section ) ) {
            $this->setTemplate ( $this->getSectionContent ( $this->getSectionNumber ( $section ) ) );
            return TRUE;
        } else { // Falls die Section nicht gefunden wurde
            return FALSE;
        }
    }

    // toString-Methode um das Template als String auszugeben
    public function __toString() {
        $data = $this->getTemplate (); // aktuelles Template laden
        foreach ( $this->tags as $theTag => $value ) { // Tag-Liste durchgehen
            if ( $value !== null ) {
                $data = str_replace ( self::OPENER . $theTag . self::CLOSER, $value, $data ); // Tags durch Werte ersetzen
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

    // Setzt Template-Tag mit zugehöriger Ersetzung
    public function tag ( $tag, $value ) {
        $this->tags[$tag] = $value;
    }

    // Destruktor
    public function  __destruct(){
        $this->clearSectionCache();
        $this->clearTags();
    }
}
?>
