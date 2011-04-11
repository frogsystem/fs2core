<?php

unset($template);

$template = '
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="line">{title}</td></tr>
                            <tr>
                                <td class="config">
                                    <div class="normal">{text}</div>
                                </td>
                            </tr>
                        </table>
';

switch ($step) {
  case 2:
    $contenttitle = $_LANG[steps][start][step][2][long_title];
    $text_title = $_LANG[steps][start][step][2][text_title];
    $text = $_LANG[steps][start][step][2][text];
    break;
  case 3:
    $contenttitle = $_LANG[steps][start][step][3][title];
    $text_title = $_LANG[steps][start][step][3][text_title];
    $text = $_LANG[steps][start][step][3][text];
    break;
  case 4:
    $contenttitle = $_LANG[steps][start][step][4][title];
    $text_title = $_LANG[steps][start][step][4][text_title];
    $text = $_LANG[steps][start][step][4][text];
    break;
  default:
    $step = 1;
    $contenttitle = $_LANG[steps][start][step][1][title];
    $text_title = $_LANG[steps][start][step][1][text_title];
    $text = $_LANG[steps][start][step][1][text];
    break;
}

$template = str_replace ( "{title}", $text_title, $template );
$template = str_replace ( "{text}", $text, $template );

$php = FALSE;
$ftp = FALSE;
$mysql = FALSE;
unset ( $req_text );

if ( version_compare ( PHP_VERSION, "5.0.0" ) >= 0 ) {
    $php = TRUE;
    if ( extension_loaded ( "ftp" ) ) {
        $ftp = TRUE;
    }
}

if ( easy_mysql_server_version () >= 4 ) {
    $mysql = TRUE;
}

$req_template = '
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="space"></td></tr>
                            <tr><td class="line">'.$_LANG[steps][start][step][release_title].'</td></tr>
                            <tr>
                                <td class="config">
                                    <div class="normal">{text}</div>
                                </td>
                            </tr>
                            {button}
                        </table>
';

if ( !$php ) {
    $req_text .= $_LANG[steps][start][step][release_php];
}
if ( !$php && !$mysql  ) {
    $req_text .= "<br><br>";
}
if ( !$mysql ) {
    $req_text .= $_LANG[steps][start][step][release_mysql];
}

$button = '
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="buttontd">
                                    <a href="?go=ftp&step=1&lang='.$lang.'" class="link_button">
                                        '.$_LANG[main][arrow].' '.$_LANG[steps][start][step][start_install].'
                                    </a>
                                </td>
                            </tr>
';

if ( $php && $mysql ) {
    $req_text .= $_LANG[steps][start][step][release_ok];
    if ( !$ftp ) {
        $req_text .= "<br><br>" . $_LANG[steps][start][step][release_ftp];
    }
    $req_text .= "<br><br>" . $_LANG[steps][start][step][release_notes];
    $req_template = str_replace ( "{button}", $button, $req_template );
} else {
    $reg_text .= $_LANG[steps][start][step][release_not_ok];
    $req_template = str_replace ( "{button}", "", $req_template );
}

$req_template = str_replace ( "{text}", $req_text, $req_template );
$template .= $req_template;

$lfs = 0;

?>