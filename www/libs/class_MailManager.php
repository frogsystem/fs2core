<?php
/**
 * @file     class_MailManager.php
 * @folder   /libs
 * @version  0.1
 * @author   Sweil
 *
 * this class provides methods for mail creation
 */

class MailManager
{
    // Der Konstruktur
    public function  __construct() {
        global $FD;     
    } 
    
    
    // Get Html Config
    public function getHtmlConfig()  {
        global $FD;
        
        try {
            $html = $FD->sql()->getField("email", "html");
            return (boolean) $html;                
        } catch (Exception $e) {
            throw $e;
        } 
    }
    
    // Get Default Mail
    public function getDefaultSender()  {
        global $FD;
        
        try {
            $data = $FD->sql()->getRow("email", array("use_admin_mail", "email"));
            if ($data['use_admin_mail'] == 1)
                return $FD->cfg('admin_mail');
            else
                return $data['email'];
                
        } catch (Exception $e) {
            throw $e;
        }
    }    
    
}
?>
