<?php if (!defined('ACP_GO')) die('Unauthorized access!');

$index = $FD->sql()->conn()->query ( "
				SELECT COUNT(`cat_id`) AS 'num_gallery'
				FROM ".$FD->config('pref').'screen_cat
				LIMIT 0,1' );
$row = $index->fetch(PDO::FETCH_ASSOC);
$num_gallery = $row['num_gallery'];

$index = $FD->sql()->conn()->query ( "
				SELECT COUNT(`screen_id`) AS 'num_gallery_img'
				FROM ".$FD->config('pref').'screen
				LIMIT 0,1');
$row = $index->fetch(PDO::FETCH_ASSOC);
$num_gallery_img = $row['num_gallery_img'];

$index = $FD->sql()->conn()->query ( "
				SELECT COUNT(`wallpaper_id`) AS 'num_gallery_wp'
				FROM ".$FD->config('pref').'wallpaper
				LIMIT 0,1' );
$row = $index->fetch(PDO::FETCH_ASSOC);
$num_gallery_wp = $row['num_gallery_wp'];

$num_gallery_entries = $num_gallery_wp + $num_gallery_img;

if ( $num_gallery_img > 0 ) {
    $index = $FD->sql()->conn()->query ( "
					SELECT COUNT(S.`screen_id`) AS 'best_gallery_num', C.`cat_name`
					FROM ".$FD->config('pref').'screen_cat C, '.$FD->config('pref').'screen S
					WHERE S.`cat_id` = C.`cat_id`
					AND C.`cat_type` = 1
					GROUP BY C.`cat_name`
					ORDER BY `best_gallery_num` DESC
					LIMIT 0,1' );
    $row = $index->fetch(PDO::FETCH_ASSOC);
    $best_gallery =  ( $row['cat_name'] );
    $best_gallery_num = $row['best_gallery_num'];
}
if ( $num_gallery_wp > 0 ) {
	$index = $FD->sql()->conn()->query ( "
					SELECT COUNT(W.`wallpaper_id`) AS 'best_gallery_num', C.`cat_name`
					FROM ".$FD->config('pref').'screen_cat C, '.$FD->config('pref').'wallpaper W
					WHERE W.`cat_id` = C.`cat_id`
					AND C.`cat_type` = 2
					GROUP BY C.`cat_name`
					ORDER BY `best_gallery_num` DESC
					LIMIT 0,1' );
    $row = $index->fetch(PDO::FETCH_ASSOC);
	$best_gallery2 =  ( $row['cat_name'] );
	$best_gallery_num2 = $row['best_gallery_num'];
}

if ( $num_gallery_wp > 0 && $best_gallery_num2 > $best_gallery_num ) {
	$best_gallery = $best_gallery2;
	$best_gallery_num = $best_gallery_num2;
}


$index = $FD->sql()->conn()->query ( "
				SELECT COUNT(`dl_id`) AS 'num_dl'
				FROM ".$FD->config('pref').'dl
				LIMIT 0,1' );
$row = $index->fetch(PDO::FETCH_ASSOC);
$num_dl = $row['num_dl'];

$index = $FD->sql()->conn()->query ( "
				SELECT COUNT(`file_id`) AS 'num_dl_file'
				FROM ".$FD->config('pref').'dl_files
				LIMIT 0,1' );
$row = $index->fetch(PDO::FETCH_ASSOC);
$num_dl_files = $row['num_dl_file'];


if ( $num_dl  > 0 && $num_dl_files  > 0 ) {
    $index = $FD->sql()->conn()->query ( "
					SELECT COUNT(F.`file_id`) AS 'best_dl_files_num', D.`dl_name`
					FROM ".$FD->config('pref').'dl D, '.$FD->config('pref').'dl_files F
					WHERE D.`dl_id` = F.`dl_id`
					GROUP BY D.`dl_name`
					ORDER BY `best_dl_files_num` DESC
					LIMIT 0,1' );
    $row = $index->fetch(PDO::FETCH_ASSOC);
    $best_dl_files =  ( $row['dl_name'] );
    $best_dl_files_num = $row['best_dl_files_num'];

    $index = $FD->sql()->conn()->query ( "
					SELECT SUM(F.`file_count`) AS 'best_dl_count_num', D.`dl_name`
					FROM ".$FD->config('pref').'dl D, '.$FD->config('pref').'dl_files F
					WHERE D.`dl_id` = F.`dl_id`
					GROUP BY D.`dl_name`
					ORDER BY `best_dl_count_num` DESC
					LIMIT 0,1' );
    $row = $index->fetch(PDO::FETCH_ASSOC);
    $best_dl_count =  ( $row['dl_name'] );
    $best_dl_count_num = $row['best_dl_count_num'];

    $index = $FD->sql()->conn()->query ( "
					SELECT SUM(F.`file_size`)*SUM(F.`file_count`) AS 'best_dl_traffic_num', D.`dl_name`
					FROM ".$FD->config('pref').'dl D, '.$FD->config('pref').'dl_files F
					WHERE D.`dl_id` = F.`dl_id`
					GROUP BY D.`dl_name`
					ORDER BY `best_dl_traffic_num` DESC
					LIMIT 0,1' );
    $row = $index->fetch(PDO::FETCH_ASSOC);
    $best_dl_traffic =  ( $row['dl_name'] );
    $best_dl_traffic_num = getsize ( $row['best_dl_traffic_num'] );

    $index = $FD->sql()->conn()->query ( "
					SELECT COUNT(D.`dl_id`) AS 'best_dl_uploader_num', U.`user_name`
					FROM ".$FD->config('pref').'user U, '.$FD->config('pref').'dl D
					WHERE D.`user_id` = U.`user_id`
					GROUP BY U.`user_name`
					ORDER BY `best_dl_uploader_num` DESC
					LIMIT 0,1' );
    $row = $index->fetch(PDO::FETCH_ASSOC);
    $best_dl_uploader =  ( $row['user_name'] );
    $best_dl_uploader_num = $row['best_dl_uploader_num'];
}


$index = $FD->sql()->conn()->query ( "
				SELECT COUNT(`video_id`) AS 'num_video'
				FROM ".$FD->config('pref').'player
				LIMIT 0,1' );
$row = $index->fetch(PDO::FETCH_ASSOC);
$num_video = $row['num_video'];

$index = $FD->sql()->conn()->query ( "
				SELECT COUNT(`video_id`) AS 'num_video_int'
				FROM ".$FD->config('pref').'player
				WHERE `video_type` = 1
				LIMIT 0,1' );
$row = $index->fetch(PDO::FETCH_ASSOC);
$num_video_int = $row['num_video_int'];

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
