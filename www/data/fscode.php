<?php
$template[title] = "FSCode Liste";
$template[header] = 'Das System dieser Webseite bietet dir die Möglichkeit einfache Codes zur besseren Darstellung deiner Beiträge zu verwenden. Diese sogenannten [b]FSCodes[/b] erlauben dir daher HTML-Formatierungen zu verwenden, ohne dass du dich mit HTML auskennen musst. Mit ihnen hast du die Möglichkeit verschiedene Elemente in deine Beiträge einzubauen bzw. ihren Text zu formatieren.

Hier findest du eine [b]Übersicht über alle verfügbaren FSCodes[/b] und ihre Verwendung. Allerdings ist es möglich, dass nicht alle Codes zur Verwendung freigeschaltet sind.

<table width="100%" cellpadding="0" cellspacing="10" border="0"><tr><td width="50%">[size=3][u][b]FS-Code:[/b][/u][/size]</td><td width="50%">[size=3][u][b]Beispiel:[/b][/u][/size]</td></tr>';
$template[footer] = '</table>';

$template[repeat] = '<tr><td>[noparse]{..x..}[/noparse]</td><td>{..y..}</td></tr>';
$template[spacer] = '<tr><td colspan="2"><hr></td></tr>';

$codes = $sql->getData("fscodes", "example, group", "WHERE `example`!='' ORDER BY `group` ASC, `name` ASC");
$lastgroup = 0;
$content = '';
foreach($codes as $code){
    if(intval($code[group]) != $lastgroup && $content != ''){
        $content .= $template[spacer];
    }
    $lastgroup = intval($code[group]);
    $code = explode("|", $code[example]);
    foreach($code as $piece){
        $tmp = str_replace("{..x..}", $piece, $template[repeat]);
        $tmp = str_replace("{..y..}", $piece, $tmp);
        $content.= $tmp;
        unset($tmp);
    }
}

$tpl = new template();
$tpl->setFile("0_articles.tpl");
$tpl->load("BODY");
$tpl->tag("title", $template[title]);
$tpl->tag("text", fscode($template[header].$content.$template[footer], true, true));
$tpl->tag("date_template", "");
$tpl->tag("author_template", "");

unset($template, $code, $group, $content);
$template = $tpl->display();
?>