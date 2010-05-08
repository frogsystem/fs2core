<?php

include("./libs/class_doc.php");
$tpl = new template();
$doc = new doc($tpl, $sql);
if(isset($_GET[v])){
  $template = $doc->showVariable($_GET[v], $_GET[c]);
} elseif(isset($_GET[f])){
  $template = $doc->showFunction($_GET[f], $_GET[c]);
} elseif(isset($_GET[c])){
  $template = $doc->showClass($_GET[c]);
} else {
  $template = $doc->showIndex();
}
?>