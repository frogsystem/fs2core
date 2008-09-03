<?php

function get_player ( $MULTI, $WIDTH = 400, $HEIGHT = 320 ) {

	global $global_config_arr, $db;

	$display = FALSE;
	
	if ( is_numeric ( $MULTI ) ) {
	    settype ( $MULTI, "integer" );
		$index = mysql_query ( "
								SELECT
									*
								FROM
									".$global_config_arr['pref']."player
								WHERE
									video_id = '".$MULTI."'
								LIMIT
									0,1
		", $db );
		if ( mysql_num_rows ( $index ) == 1 ) {
			$url = mysql_result ( $index, 0, "video_url" );
			$TITLE = mysql_result ( $index, 0, "video_title" );
			$display = TRUE;
		}
	} else {
    	$input = explode ( "|", $MULTI, 2 );
		$url = $input[0];
		$TITLE = $input[1];
		$display = TRUE;
	}

	$url = htmlspecialchars ( $url );
	$TITLE = htmlspecialchars ( $TITLE );
 	settype ( $WIDTH, "integer" );
 	settype ( $HEIGHT, "integer" );

	if ( $display ) {
		$template = '
<table cellpadding="0" cellspacing="0">
	<tr>
		<td style="background-image: url(images/design/player_lo.jpg); background-repeat: no-repeat; width: 15px; height: 17px;"></td>
		<td style="background-image: url(images/design/player_o.jpg); background-repeat: repeat-x; height: 17px;" align="left">
			<img src="images/design/player_o_extra.jpg" alt="">
		</td>
		<td style="background-image: url(images/design/player_ro.jpg); background-repeat: no-repeat; width: 16px; height: 17px;"></td>
	</tr>
	<tr>
		<td style="background-image: url(images/design/player_l.jpg); background-repeat: repeat-y; width: 15px;"></td>
		<td style="background-color: #000000;">

		<object type="application/x-shockwave-flash" data="'.$global_config_arr['virtualhost'].'res/player_flv_maxi.swf" width="'.$WIDTH.'" height="'.$HEIGHT.'">
		    <param name="movie" value="'.$global_config_arr['virtualhost'].'res/player_flv_maxi.swf" />
		    <param name="allowFullScreen" value="true" />
		    <param name="FlashVars" value="config='.$global_config_arr['virtualhost'].'res/player_flv_config.txt&amp;flv='.$url.'&amp;title='.$TITLE.'&amp;width='.$WIDTH.'&amp;height='.$HEIGHT.'" />
		</object>

		</td>
		<td style="background-image: url(images/design/player_r.jpg); background-repeat: repeat-y; width: 16px;"></td>
	</tr>
	<tr>
		<td style="background-image: url(images/design/player_lu.jpg); background-repeat: no-repeat; width: 15px; height: 18px;"></td>
		<td style="background-image: url(images/design/player_u.jpg); background-repeat: repeat-x; height: 18px;"></td>
		<td style="background-image: url(images/design/player_ru.jpg); background-repeat: no-repeat; width: 16px; height: 18px;"></td>
	</tr>
</table>
		';
	} else {
		$template = "";
	}
	
	return $template;
}
?>