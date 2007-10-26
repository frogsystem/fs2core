<?php
header("Content-type: text/css");

include("login.inc.php");

if ($db)
{
    if (isset ($_GET['id']) AND $global_config_arr[allow_other_designs] == 1)
    {
        $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."template WHERE id = $_GET[id]", $db);
        if (mysql_num_rows($index) > 0)
        {
            $global_config_arr[design] =  $_GET['id'];
            settype($global_config_arr[design], "integer");
        }
    }

    $index = mysql_query("SELECT style_css FROM ".$global_config_arr[pref]."template WHERE id = ".$global_config_arr[design]."", $db);
    $template = mysql_result($index, 0, "style_css");
    echo $template;

mysql_close($db);
}
?>