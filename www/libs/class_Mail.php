<?php
/**
 * @file     class_Mail.php
 * @folder   /libs
 * @version  0.1
 * @author   Sweil
 *
 * this class represents an email
 */

class Mail {

    // Klassen-Variablen
    private $to;
    private $from;
    private $subject;
    private $content;
    private $rawContent;
    private $html = true;

    // Der Konstruktur
    public function  __construct($FROM, $TO, $SUBJECT, $CONTENT, $HTML = true, $TPL_FUNC = true, $FSCODE = true) {
        $this->from = $FROM;
        $this->to = $TO;
        $this->subject = utf8_encode($SUBJECT);
        $this->html = $HTML;
        $this->content = $rawContent = $CONTENT;

        if ($TPL_FUNC) {
            global $FD;
            require_once(FS2_ROOT_PATH.'includes/indexfunctions.php');
            $this->content = tpl_functions($this->content, $FD->cfg('system', 'var_loop'), array('DATE', 'VAR', 'URL', 'SNP'), true);
        }
        if ($FSCODE && $HTML) {
            require_once(FS2_ROOT_PATH.'includes/fscode.php');
            $this->content = parse_all_fscodes($this->content, array('html'=>true));
        }

        $this->content = utf8_encode($this->content);
    }


    // Mail versenden
    public function send() {
        $header  = 'From: ' . $this->from . "\r\n";
        $header .= 'X-Mailer: PHP/' . phpversion() . "\r\n";
        $header .= 'X-Sender-IP: ' . $_SERVER['REMOTE_ADDR'] . "\r\n";
        $header .= 'MIME-Version: 1.0' . "\r\n";

        if ($this->html) {
            $header .= 'Content-Type: text/html; charset=UTF-8';
            $this->content = '<html><body>' . $this->content . '</body></html>';
        } else  {
            $header .= 'Content-Type: text/plain; charset=UTF-8';
        }

        return @mail($this->to, "=?UTF-8?B?".base64_encode($this->subject)."?=", $this->content, $header);
    }

}
?>
