<?php

$flash = '
     <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"
             codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0"
             width="600" height="600" id="map" >
         <param name="movie" VALUE="res/map.swf">
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
                pluginspage ="http://www.macromedia.com/go/getflashplayer">
         </embed>
     </object>
';

$index = mysql_query("select community_map from fs_template where id = '$global_config_arr[design]'", $db);
$template = stripslashes(mysql_result($index, 0, "community_map"));
$template = str_replace("{karte}", $flash, $template); 
?>