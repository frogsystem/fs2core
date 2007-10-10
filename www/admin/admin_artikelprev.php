<?php
include("config.inc.php");
include("functions.php");
include("adminfunctions.php");

echo'
<html>
<head>
    <title>Frogsystem 2 - Vorschau</title>

    <link rel="stylesheet" type="text/css" href="../sytle_css.php">
    <script>
        function loaddata()
        {
            document.getElementByName(\'title\').value = opener.document.getElementByName(\'title\').value;
            document.getElementByName(\'posterid\').value = opener.document.getElementByName(\'posterid\').value;

            document.getElementByName(\'tag\').value = opener.document.getElementByName(\'tag\').value;
            document.getElementByName(\'monat\').value = opener.document.getElementByName(\'monat\').value;
            document.getElementByName(\'jahr\').value = opener.document.getElementByName(\'jahr\').value;
            
            document.getElementByName(\'fscode\').value = opener.document.getElementByName(\'fscode\').value;

            document.getElementByName(\'text\').value = "abc";

            document.getElementById(\'form\').submit();
        }
    </script>


</head>
';

if (!$_POST[text])
{
    echo'
<body onLoad="loaddata()">
    <form action="" method="post" id="form">
        <input type="hidden" name="title" value="">
        <input type="hidden" name="posterid" value="">
        <input type="hidden" name="tag" value="">
        <input type="hidden" name="monat" value="">
        <input type="hidden" name="jahr" value="">
        <input type="hidden" name="text" value="">
        <input type="hidden" name="fscode" value="">
    </form>
    ';
}

echo'
<body>
    <div align="left" style="margin:20px">
    ';

if ($_POST[tag] && $_POST[monat] && $_POST[jahr])
{
    $date = mktime(0, 0, 0, $_POST[monat], $_POST[tag], $_POST[jahr]);
}
else
{
    $date = 0;
}

settype($_POST[posterid], 'integer');
$_POST[fscode] = isset($_POST[fscode]) ? 1 : 0;

$index = mysql_query("SELECT user_id, user_name FROM ".$global_config_arr[pref]."user WHERE user_id = '$_POST[posterid]'", $db);
if (mysql_num_rows($index) == 1)
{
    $dbusername = mysql_result($index, 0, "user_name");
    $userlink = '?go=profil&amp;userid=' . mysql_result($index, 0, "user_id");

    // Template für Artikel Autor abrufen und füllen
    $index = mysql_query("select artikel_autor from ".$global_config_arr[pref]."template where id = '$global_config_arr[design]'", $db);
    $autor = stripslashes(mysql_result($index, 0, "artikel_autor"));
    $autor = str_replace("{profillink}", $userlink, $autor); 
    $autor = str_replace("{username}", $dbusername, $autor); 
}

if ($date != 0)
{
    $date = date("d.m.Y", $date);
}
else
{
    $date = "";
}

if ($_POST[fscode] == 1)
{
    $_POST[text] = fscode($_POST[text], true, true, false);
}
$_POST[text] = stripslashes($_POST[text]);

// Template für Artikel Body abrufen und füllen
$index = mysql_query("select artikel_body from ".$global_config_arr[pref]."template where id = '$global_config_arr[design]'", $db);
$body = stripslashes(mysql_result($index, 0, "artikel_body"));
$body = str_replace("{titel}", $_POST[title], $body); 
$body = str_replace("{datum}", $date, $body); 
$body = str_replace("{text}", $_POST[text], $body); 
$body = str_replace("{autor}", $autor, $body);

echo $body;

echo'
    </div>
</body>
</html>
';
mysql_close($db);
?>