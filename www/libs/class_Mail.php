<?php
/**
 * @file     class_Mail.php
 * @folder   /libs
 * @version  0.2
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
    private $html = true;

    // Der Konstruktur
    public function  __construct($FROM, $TO, $SUBJECT, $CONTENT, $HTML = true) {
        $this->from = $FROM;
        $this->to = $TO;
        $this->subject = utf8_encode($SUBJECT);
        $this->content = utf8_encode($CONTENT);
        $this->html = $HTML;
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
