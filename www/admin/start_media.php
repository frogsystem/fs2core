<?php
$index = mysql_query ( "
						SELECT COUNT(`cat_id`) AS 'num_gallery'
						FROM ".$global_config_arr['pref'].'screen_cat
						LIMIT 0,1
', $FD->sql()->conn() );
$num_gallery = mysql_result ( $index, 0, 'num_gallery' );

$index = mysql_query ( "
						SELECT COUNT(`screen_id`) AS 'num_gallery_img'
						FROM ".$global_config_arr['pref'].'screen
						LIMIT 0,1
', $FD->sql()->conn() );
$num_gallery_img = mysql_result ( $index, 0, 'num_gallery_img' );

$index = mysql_query ( "
						SELECT COUNT(`wallpaper_id`) AS 'num_gallery_wp'
						FROM ".$global_config_arr['pref'].'wallpaper
						LIMIT 0,1
', $FD->sql()->conn() );
$num_gallery_wp = mysql_result ( $index, 0, 'num_gallery_wp' );

$num_gallery_entries = $num_gallery_wp + $num_gallery_img;

if ( $num_gallery_img > 0 ) {
	$index = mysql_query ( "
							SELECT COUNT(S.`screen_id`) AS 'best_gallery_num', C.`cat_name`
							FROM ".$global_config_arr['pref'].'screen_cat C, '.$global_config_arr['pref'].'screen S
							WHERE S.`cat_id` = C.`cat_id`
							AND C.`cat_type` = 1
							GROUP BY C.`cat_name`
							ORDER BY `best_gallery_num` DESC
							LIMIT 0,1
	', $FD->sql()->conn() );
	$best_gallery = stripslashes ( mysql_result ( $index, 0, 'cat_name' ) );
	$best_gallery_num = mysql_result ( $index, 0, 'best_gallery_num' );
}
if ( $num_gallery_wp > 0 ) {
	$index = mysql_query ( "
							SELECT COUNT(W.`wallpaper_id`) AS 'best_gallery_num', C.`cat_name`
							FROM ".$global_config_arr['pref'].'screen_cat C, '.$global_config_arr['pref'].'wallpaper W
							WHERE W.`cat_id` = C.`cat_id`
							AND C.`cat_type` = 2
							GROUP BY C.`cat_name`
							ORDER BY `best_gallery_num` DESC
							LIMIT 0,1
	', $FD->sql()->conn() );
	$best_gallery2 = stripslashes ( mysql_result ( $index, 0, 'cat_name' ) );
	$best_gallery_num2 = mysql_result ( $index, 0, 'best_gallery_num' );
}

if ( $num_gallery_wp > 0 && $best_gallery_num2 > $best_gallery_num ) {
	$best_gallery = $best_gallery2;
	$best_gallery_num = $best_gallery_num2;
}


$index = mysql_query ( "
						SELECT COUNT(`dl_id`) AS 'num_dl'
						FROM ".$global_config_arr['pref'].'dl
						LIMIT 0,1
', $FD->sql()->conn() );
$num_dl = mysql_result ( $index, 0, 'num_dl' );

$index = mysql_query ( "
						SELECT COUNT(`file_id`) AS 'num_dl_file'
						FROM ".$global_config_arr['pref'].'dl_files
						LIMIT 0,1
', $FD->sql()->conn() );
$num_dl_files = mysql_result ( $index, 0, 'num_dl_file' );


if ( $num_dl  > 0 && $num_dl_files  > 0 ) {
	$index = mysql_query ( "
							SELECT COUNT(F.`file_id`) AS 'best_dl_files_num', D.`dl_name`
							FROM ".$global_config_arr['pref'].'dl D, '.$global_config_arr['pref'].'dl_files F
							WHERE D.`dl_id` = F.`dl_id`
							GROUP BY D.`dl_name`
							ORDER BY `best_dl_files_num` DESC
							LIMIT 0,1
	', $FD->sql()->conn() );
	$best_dl_files = stripslashes ( mysql_result ( $index, 0, 'dl_name' ) );
	$best_dl_files_num = mysql_result ( $index, 0, 'best_dl_files_num' );

	$index = mysql_query ( "
							SELECT SUM(F.`file_count`) AS 'best_dl_count_num', D.`dl_name`
							FROM ".$global_config_arr['pref'].'dl D, '.$global_config_arr['pref'].'dl_files F
							WHERE D.`dl_id` = F.`dl_id`
							GROUP BY D.`dl_name`
							ORDER BY `best_dl_count_num` DESC
							LIMIT 0,1
	', $FD->sql()->conn() );
	$best_dl_count = stripslashes ( mysql_result ( $index, 0, 'dl_name' ) );
	$best_dl_count_num = mysql_result ( $index, 0, 'best_dl_count_num' );

	$index = mysql_query ( "
							SELECT SUM(F.`file_size`)*SUM(F.`file_count`) AS 'best_dl_traffic_num', D.`dl_name`
							FROM ".$global_config_arr['pref'].'dl D, '.$global_config_arr['pref'].'dl_files F
							WHERE D.`dl_id` = F.`dl_id`
							GROUP BY D.`dl_name`
							ORDER BY `best_dl_traffic_num` DESC
							LIMIT 0,1
	', $FD->sql()->conn() );
	$best_dl_traffic = stripslashes ( mysql_result ( $index, 0, 'dl_name' ) );
	$best_dl_traffic_num = getsize ( mysql_result ( $index, 0, 'best_dl_traffic_num' ) );

	$index = mysql_query ( "
							SELECT COUNT(D.`dl_id`) AS 'best_dl_uploader_num', U.`user_name`
							FROM ".$global_config_arr['pref'].'user U, '.$global_config_arr['pref'].'dl D
							WHERE D.`user_id` = U.`user_id`
							GROUP BY U.`user_name`
							ORDER BY `best_dl_uploader_num` DESC
							LIMIT 0,1
	', $FD->sql()->conn() );
	$best_dl_uploader = stripslashes ( mysql_result ( $index, 0, 'user_name' ) );
	$best_dl_uploader_num = mysql_result ( $index, 0, 'best_dl_uploader_num' );
	echo mysql_error();
}


$index = mysql_query ( "
						SELECT COUNT(`video_id`) AS 'num_video'
						FROM ".$global_config_arr['pref'].'player
						LIMIT 0,1
', $FD->sql()->conn() );
$num_video = mysql_result ( $index, 0, 'num_video' );

$index = mysql_query ( "
						SELECT COUNT(`video_id`) AS 'num_video_int'
						FROM ".$global_config_arr['pref'].'player
						WHERE `video_type` = 1
						LIMIT 0,1
', $FD->sql()->conn() );
$num_video_int = mysql_result ( $index, 0, 'num_video_int' );

$num_video_ext = $num_video - $num_video_int;

echo '
                        <table class="configtable" cellpadding="4" cellspacing="0">
							<tr><td class="line" colspan="2">Informationen &amp; Statistik</td></tr>
                            <tr>
                                <td class="configthin" width="200">Anzahl Galerien:</td>
                                <td class="configthin"><b>'.$num_gallery.'</b></td>
                            </tr>
';

if ( $num_gallery_entries  > 0 ) {
	echo '
                            <tr>
                                <td class="configthin" width="200">Gr&ouml;&szlig;te Galerie:</td>
                                <td class="configthin"><b>'.$best_gallery.'</b> mit <b>'.$best_gallery_num.'</b> Bild(ern)/Wallpaper(n)</td>
                            </tr>
	';
}

echo '
                            <tr>
                                <td class="configthin" width="200">Anzahl Bilder:</td>
                                <td class="configthin"><b>'.$num_gallery_img.'</b></td>
                            </tr>
                            <tr>
                                <td class="configthin" width="200">Anzahl Wallpaper:</td>
                                <td class="configthin"><b>'.$num_gallery_wp.'</b></td>
                            </tr>
                            <tr>
                                <td class="configthin" width="200">Anzahl Eintr&auml;ge (gesamt):</td>
                                <td class="configthin"><b>'.$num_gallery_entries.'</b></td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="configthin" width="200">Anzahl Downloads:</td>
                                <td class="configthin"><b>'.$num_dl.'</b></td>
                            </tr>
                            <tr>
                                <td class="configthin" width="200">Anzahl Dateien:</td>
                                <td class="configthin"><b>'.$num_dl_files.'</b></td>
                            </tr>
';

if ( $num_dl  > 0 && $num_dl_files  > 0 ) {
	echo '
                            <tr>
                                <td class="configthin" width="200">Meiste Dateien:</td>
                                <td class="configthin"><b>'.$best_dl_files.'</b> mit <b>'.$best_dl_files_num.'</b> Datei(en)</td>
                            </tr>
                            <tr>
                                <td class="configthin" width="200">Meiste Downloads:</td>
                                <td class="configthin"><b>'.$best_dl_count.'</b> mit <b>'.$best_dl_count_num.'</b> Klick(s)</td>
                            </tr>
                            <tr>
                                <td class="configthin" width="200">Meister Traffic:</td>
                                <td class="configthin"><b>'.$best_dl_traffic.'</b> mit <b>'.$best_dl_traffic_num.'</b></td>
                            </tr>
                            <tr>
                                <td class="configthin" width="200">Flei&szlig;igster Uploader:</td>
                                <td class="configthin"><b>'.$best_dl_uploader.'</b> mit <b>'.$best_dl_uploader_num.'</b> Download(s)</td>
                            </tr>
	';
}

echo '
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="configthin">Anzahl Videos (gesamt):</td>
                                <td class="configthin"><b>'.$num_video.'</b></td>
                            </tr>
                            <tr>
                                <td class="configthin">Anzahl eigene Videos:</td>
                                <td class="configthin"><b>'.$num_video_int.'</b></td>
                            </tr>
                            <tr>
                                <td class="configthin">Anzahl externe Videos:</td>
                                <td class="configthin"><b>'.$num_video_ext.'</b></td>
                            </tr>
						</table>
';
?>
