<?php
/**
 * @file     class_MailManager.php
 * @folder   /libs
 * @version  0.2
 * @author   Sweil
 *
 * this class provides methods for mail creation
 */

class MailManager
{
    // Der Konstruktur
    public function  __construct() {
        //~ global $FD;
    }


    // Get Html Config
    public static function getHtmlConfig()  {
        global $FD;

        try {
            $html = $FD->sql()->conn()->query('SELECT html FROM '.$FD->config('pref').'email LIMIT 1');
            $html = $html->fetchColumn();
            return (boolean) $html;
        } catch (Exception $e) {
            throw $e;
        }
    }

    // Get Default Mail
    public static function getDefaultSender()  {
        global $FD;

        try {
            $data = $FD->sql()->conn()->query(
                          'SELECT use_admin_mail, email FROM '.$FD->config('pref').'email LIMIT 1');
            $data = $data->fetch(PDO::FETCH_ASSOC);
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
