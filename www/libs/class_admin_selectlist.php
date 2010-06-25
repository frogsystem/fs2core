<?php
/**
* @file     class_admin_selectlist.php
* @folder   /libs
* @version  0.1
* @author   Sweil
*
* provides a simple list for content selection at admin cp
*/
class SelectList
{
    private $title;
    private $go;

    private $formName;
    private $formAction;
    private $formMethod;
    
    private $inputs = array();

    private $cols = 2;
    private $captions = array();
    private $lines = array();
    private $noLines = "DUMMY DEFAULT TEXT FOR NO CONTENT";

    private $selection = FALSE;
    private $actions = array();
    private $defaultAction;
    
    private $button = FALSE;

    
    
    //
    public function __construct ( $formName, $title, $go, $cols = 2, $formMethod = "post", $formAction = "" ) {
        $this->formName = $formName;
        $this->title = $title;
        $this->go = $go;
        $this->cols = $cols;
        $this->formMethod = $formMethod;
        $this->formAction = $formAction;
    }

    public function addInput ( $type, $name, $value = null, $class = null, $id = null ) {
        $value = ( !is_null ( $value ) ) ? ' value="'.$value.'"' : '';
        $class = ( !is_null ( $class ) ) ? ' class="'.$class.'"' : '';
        $id    = ( !is_null ( $id ) )    ? ' id="'.$id.'"' : '';

        $this->addInputHTML ( '<input'.$class.' type="'.$type.'" name="'.$name.'"'.$id.$value.'>' );
    }
    
    public function addInputHTML ( $HTML ) {
        $this->inputs[] = $HTML;
    }

    /**
    * needs Array of this kind:
    * array ( $col_array1, [ $col_array2, [ ... ] ] )
    *
    * $col_array1, $col_array2, ... each representing one col which is an Array of this kind:
    * array ( String $html_label, [ Array $css_classes, [ Integer $col_width ]]  )
    */
    public function addCaptions ( $ARRAY ) {
        try {
            $this->addCaptionsInner ( $ARRAY );
        } catch ( Exception $e ) {
            echo 'Error: ',  $e->getMessage(), "\n";
        }
    }
    private function addCaptionsInner ( $ARRAY ) {
        if ( count ( $ARRAY ) != $this->cols ) {
            throw new Exception('Tried to use more cols than defined.');
        }
        $this->captions = $ARRAY;
    }
    
    /**
    * needs Array of this kind:
    * array ( $col_array1, $col_array2, ... )
    *
    * $col_array1, $col_array2, ... each representing one col which is an Array of this kind:
    * array ( String $html_content, Array $css_classes )
    *
    * Set FALSE instead of a $col_array for the Checkbox!
    */
    public function addLine ( $ARRAY ) {
        try {
            $this->addLineInner ( $ARRAY );
        } catch ( Exception $e ) {
            echo 'Error: ',  $e->getMessage(), "\n";
        }
    }
    private function addLineInner ( $ARRAY ) {
        if ( count ( $ARRAY ) != $this->cols ) {
            throw new Exception('Tried to use more cols than defined.');
        }
        $this->lines[] = $ARRAY;
    }
    
    public function setNoLinesText ( $TEXT ) {
        $this->noLines = $TEXT;
    }

    public function addAction ( $ACTION, $LABEL, $FLAGS = array (), $PERMISSION = TRUE, $DEFAULT = FALSE ) {
       $this->actions[] = array ( "action" => $ACTION, "label" => $LABEL, "flags" => $FLAGS, "perm" => $PERMISSION );
       if ( $DEFAULT ) {
        $this->defaultAction = $ACTION;
       }
    }

    public function addSelection () {
        $this->selection = TRUE;
    }
    
    public function addButon ( $TEXT = "DEFAULT" ) {
        $this->button = $TEXT;
    }
    

    // create HTML/String representation for List
    public function __toString () {

        // Add Default Input for ?go=
        if ( !$this->selection && isset ( $this->defaultAction ) ) {
            $this->addInput ( "hidden", $this->formName."_action", $this->defaultAction );
        }


        // Start Form
        $template = '
                    <form name="'.$this->formName.'" action="'.$this->formAction.'" method="'.$this->formMethod.'">
                        <input type="hidden" name="go" value="'.$this->go.'">';
        // Create Inputs
        foreach ( $this->inputs as $aInput ) {
            $template .= '
                        '.$aInput;
        }
        
        // Start Table
        $template .= '
                        <table class="configtable select_list" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="'.$this->cols.'">'.$this->title.'</td></tr>';
                            
        // Generate Content
        if ( count ( $this->lines ) >= 1 ) {
        
            // Genarate Captions
            $template .= '
                            <tr>';
            foreach ( $this->captions as $aCaption ) {
                $width = ( isset ( $aCaption[2] ) ) ? ' width="'.$aCaption[2].'"' : '';
                $css = ( isset ( $aCaption[1] ) ) ? ' '.implode( " ",  $aCaption[2] ) : '';
                $template .= '
                                <td class="config'.$css.'"'.$width.'>'.$aCaption[0].'</td>';
            }
            $template .= '
                            </tr>';
            
            // Genarate Content
            // TODO

            // Generate Action Selection
            // TODO: default auswahl
            if ( $this->selection !== FALSE && count ( $this->actions ) >= 1 ) {
                $template .= '
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="right" colspan="'.$this->cols.'">
                                    <select class="select_type" name="'.$this->formName.'_action" size="1">';
                foreach ( $this->actions as $aAction ) {
                    if ( $aAction['perm'] ) {
                        $theFlags = "";
                        if ( count ( $aAction['flags'] ) >= 1 ) {
                            $theFlags = ' class="'.implode ( " ", $aAction['flags'] ).'"';
                        }
                        $template .= '
                        <option'.$flag.' value="'.$aAction['action'].'" '.getselected( $aAction['action'], $_POST[$this->formName.'_action'] ).'>'.$aAction['label'].'</option>';
                    }
                }
                $template .= '
                                    </select>
                                </td>
                            </tr>';
            }
            
            // Generate Button
            if ( $this->button !== FALSE ) {
                $template .= '
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="buttontd" colspan="'.$this->cols.'">
                                    <button class="button_new" type="submit">
                                        '.$TEXT["admin"]->get("button_arrow").' '.$this->button.'
                                    </button>
                                </td>
                            </tr>';
            }

        } else {
        // No Content found
        $template .= '
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="config center" colspan="'.$this->cols.'">'.$this->noLines.'</td>
                            </tr>
                            <tr><td class="space"></td></tr>';
        }
        
        // End of Table and Form
        $template .= '
                        </table>
                </form>';
        
        return $template;
    }
}
?>
