<?php if (!defined('ACP_GO')) die('Unauthorized access!');

$index = $FD->sql()->conn()->query ( "
				SELECT COUNT(`cat_id`) AS 'num_gallery'
				FROM ".$FD->config('pref').'screen_cat
				LIMIT 0,1' );
$num_gallery = $index->fetchColumn();

$index = $FD->sql()->conn()->query ( "
				SELECT COUNT(`screen_id`) AS 'num_gallery_img'
				FROM ".$FD->config('pref').'screen
				LIMIT 0,1');
$num_gallery_img = $index->fetchColumn();

$index = $FD->sql()->conn()->query ( "
				SELECT COUNT(`wallpaper_id`) AS 'num_gallery_wp'
				FROM ".$FD->config('pref').'wallpaper
				LIMIT 0,1' );
$num_gallery_wp = $index->fetchColumn();

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
    $best_gallery = $row['cat_name'];
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
	$best_gallery2 = $row['cat_name'];
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
$num_dl = $index->fetchColumn();

$index = $FD->sql()->conn()->query ( "
				SELECT COUNT(`file_id`) AS 'num_dl_file'
				FROM ".$FD->config('pref').'dl_files
				LIMIT 0,1' );
$num_dl_files = $index->fetchColumn();


if ( $num_dl  > 0 && $num_dl_files  > 0 ) {
    $index = $FD->sql()->conn()->query ( "
					SELECT COUNT(F.`file_id`) AS 'best_dl_files_num', D.`dl_name`
					FROM ".$FD->config('pref').'dl D, '.$FD->config('pref').'dl_files F
					WHERE D.`dl_id` = F.`dl_id`
					GROUP BY D.`dl_name`
					ORDER BY `best_dl_files_num` DESC
					LIMIT 0,1' );
    $row = $index->fetch(PDO::FETCH_ASSOC);
    $best_dl_files = $row['dl_name'];
    $best_dl_files_num = $row['best_dl_files_num'];

    $index = $FD->sql()->conn()->query ( "
					SELECT SUM(F.`file_count`) AS 'best_dl_count_num', D.`dl_name`
					FROM ".$FD->config('pref').'dl D, '.$FD->config('pref').'dl_files F
					WHERE D.`dl_id` = F.`dl_id`
					GROUP BY D.`dl_name`
					ORDER BY `best_dl_count_num` DESC
					LIMIT 0,1' );
    $row = $index->fetch(PDO::FETCH_ASSOC);
    $best_dl_count = $row['dl_name'];
    $best_dl_count_num = $row['best_dl_count_num'];

    $index = $FD->sql()->conn()->query ( "
					SELECT SUM(F.`file_size`)*SUM(F.`file_count`) AS 'best_dl_traffic_num', D.`dl_name`
					FROM ".$FD->config('pref').'dl D, '.$FD->config('pref').'dl_files F
					WHERE D.`dl_id` = F.`dl_id`
					GROUP BY D.`dl_name`
					ORDER BY `best_dl_traffic_num` DESC
					LIMIT 0,1' );
    $row = $index->fetch(PDO::FETCH_ASSOC);
    $best_dl_traffic = $row['dl_name'];
    $best_dl_traffic_num = getsize ( $row['best_dl_traffic_num'] );

    $index = $FD->sql()->conn()->query ( "
					SELECT COUNT(D.`dl_id`) AS 'best_dl_uploader_num', U.`user_name`
					FROM ".$FD->config('pref').'user U, '.$FD->config('pref').'dl D
					WHERE D.`user_id` = U.`user_id`
					GROUP BY U.`user_name`
					ORDER BY `best_dl_uploader_num` DESC
					LIMIT 0,1' );
    $row = $index->fetch(PDO::FETCH_ASSOC);
    $best_dl_uploader =  $row['user_name'];
    $best_dl_uploader_num = $row['best_dl_uploader_num'];
}


$index = $FD->sql()->conn()->query ( "
				SELECT COUNT(`video_id`) AS 'num_video'
				FROM ".$FD->config('pref').'player
				LIMIT 0,1' );
$num_video = $index->fetchColumn();

$index = $FD->sql()->conn()->query ( "
				SELECT COUNT(`video_id`) AS 'num_video_int'
				FROM ".$FD->config('pref').'player
				WHERE `video_type` = 1
				LIMIT 0,1' );
$num_video_int = $index->fetchColumn();

$num_video_ext = $num_video - $num_video_int;


// Conditions
$adminpage->addCond('has_galleries', ($num_gallery_entries  > 0));
$adminpage->addCond('has_dl', ($num_dl  > 0 && $num_dl_files  > 0));

// Values
$adminpage->addText('num_gallery', $num_gallery);
if ( $num_gallery_entries  > 0 ) {
  $adminpage->addText('best_gallery', $best_gallery);
  $adminpage->addText('best_gallery_num', $best_gallery_num);
}
$adminpage->addText('num_gallery_img', $num_gallery_img);
$adminpage->addText('num_gallery_wp', $num_gallery_wp);
$adminpage->addText('num_gallery_entries', $num_gallery_entries);
$adminpage->addText('num_dl', $num_dl);
$adminpage->addText('num_dl_files', $num_dl_files);
if ( $num_dl  > 0 && $num_dl_files  > 0 ) {
  $adminpage->addText('best_dl_files', $best_dl_files);
  $adminpage->addText('best_dl_files_num', $best_dl_files_num);
  $adminpage->addText('best_dl_count', $best_dl_count);
  $adminpage->addText('best_dl_count_num', $best_dl_count_num);
  $adminpage->addText('best_dl_traffic', $best_dl_traffic);
  $adminpage->addText('best_dl_traffic_num', $best_dl_traffic_num);
  $adminpage->addText('best_dl_uploader', $best_dl_uploader);
  $adminpage->addText('best_dl_uploader_num', $best_dl_uploader_num);
}
$adminpage->addText('num_video', $num_video);
$adminpage->addText('num_video_int', $num_video_int);
$adminpage->addText('num_video_ext', $num_video_ext);

echo $adminpage->get('main');
?>
