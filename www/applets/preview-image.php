<?php
$index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."screen_random_config WHERE id = 1", $db);
$config_arr = mysql_fetch_assoc($index);

if ( $config_arr['active'] == 1 ) {
	if ( $config_arr['type_priority'] == 1 ) {
		$data = get_timed_pic ();
	}
	else {
		$data = get_random_pic ();
	}

	if ( $data == FALSE && $config_arr['use_priority_only'] != 1 ) {
		if ($config_arr[type_priority] == 1) {
			$data = get_random_pic ();
		} else {
			$data = get_timed_pic ();
		}
	}

	if ( $data != FALSE ) {
		$dbscreenid = $data['id'];
		$dbscreenname = $data['name'];
		$dbscreencat = $data['cat'];

		$bild = image_url("images/screenshots/", $dbscreenid);
		$mini = image_url("images/screenshots/", $dbscreenid."_s");

		if ($type==1) {
			$link = 'showimg.php?pic='.$bild.'&amp;title='.$dbscreenname;
		} else {
			$link = "showimg.php?screen=1&amp;catid=$dbscreencat&amp;screenid=$dbscreenid";
		}

		$body = get_template ( "randompic_body" );
		$body = str_replace("{titel}", $dbpotmtitle, $body);
		$body = str_replace("{thumb}", $mini, $body);
		$body = str_replace("{link}", $link, $body);

		$template = $body;
	} else {
		$template = get_template ( "randompic_nobody" );
	}
} else {
  $template = "";
}
?>