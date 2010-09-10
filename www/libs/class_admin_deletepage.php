<?php
/**
* @file     class_admin_deletepage.php
* @folder   /libs
* @version  0.3
* @author   Sweil
*
* provides a simple Window for deleting Content
*/
class DeletePage
{
    private $text;
    
    private $title;
    private $question;
    private $go;

    private $formName;
    private $formAction;
    private $formMethod;
    
    private $ids = array();
    private $previewList;

    
    // Constructor
    public function __construct ( $formName, $title, $question, $ids, $previewList, $go = TRUE, $formMethod = "post", $formAction = "" ) {
        // Include global Data
        global $TEXT;
        $this->text = $TEXT;

        $this->formName = $formName;
        $this->title = $title;
        $this->question = $question;
        $this->IDs = $ids;
        $this->previewList = $previewList;
        
        $this->go = ( $go === TRUE ) ? $_REQUEST['go'] : $go;
        $this->formMethod = $formMethod;
        $this->formAction = $formAction;
    }

    

    // create HTML/String representation for List
    public function __toString () {

        // Display Head of Table
        $template = '
                    <form action="'.$this->formAction.'" method="'.$this->formMethod.'">
                        <input type="hidden" name="go" value="'.$this->go.'">
                        <input type="hidden" name="'.$this->formName.'_action" value="delete">
                        <input type="hidden" name="sended" value="delete">
                        <input type="hidden" name="'.$this->formName.'_id" value="'.implode ( ",", $this->IDs ).'">
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="2">'.$this->title.'</td></tr>
                            <tr>
                                <td class="configthin">
                                    <p><b>'.$this->question.'</b></p>';

        // display previews
        $template .= $this->previewList;

        // Display End of Table
        $template .= '
                                </td>
                                <td class="config right top">
                                    '.$this->getYesNo($this->formName."_delete").'
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="buttontd" colspan="2">
                                    <button class="button_new" type="submit">
                                        '.$this->text["admin"]->get("button_arrow").' '.$this->text["admin"]->get("do_action_button_long").'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>';
        
        return $template;
    }
    
    private function getYesNo($formName) {
        // Create HTML
        return '
                                    <table class="yesno_table select_one" cellpadding="4" cellspacing="0" width="100%">
                                        <tr class="yesno_entry pointer">
                                            <td class="middle">
                                                <input class="pointer select_box" type="radio" name="'.$formName.'" value="1">
                                            </td>
                                            <td class="config middle">
                                                '.$this->text["admin"]->get("yes").'
                                            </td>
                                        </tr>
                                        <tr class="yesno_entry red_entry pointer" style="background-color:#C24949;">
                                            <td class="middle">
                                                <input class="pointer select_box" type="radio" name="'.$formName.'" value="0" checked>
                                            </td>
                                            <td class="config middle">
                                                '.$this->text["admin"]->get("no").'
                                            </td>
                                        </tr>
                                    </table>';
    }
}
?>