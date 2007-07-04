<?php

$flash = '
     <object classid="CLSID:D27CDB6E-AE6D-11cf-96B8-444553540000"
             codebase="http://active.macromedia.com/flash2/cabs/swflash.cab#version=4,0,0,0"
             width="600" height="600">
         <param name="movie" VALUE="inc/map.swf">
         <param name="quality" value="high">
         <param name="scale" value="exactfit">
         <param name="menu" value="false">
         <param name="WMODE" value="transparent">
         <embed src="res/map.swf" quality="high"
                WMODE="transparent"
                scale="exactfit"
                menu="false"
                width="600" height="600"
                swLiveConnect="false"
                type="application/x-shockwave-flash"
                pluginspage ="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash">
         </embed>
     </object>
';

$index = mysql_query("select community_map from fs_template where id = '$global_config_arr[design]'", $db);
$template = stripslashes(mysql_result($index, 0, "community_map"));
$template = str_replace("{karte}", $flash, $template); 
?>