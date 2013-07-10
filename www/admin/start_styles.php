<?php if (!defined('ACP_GO')) die('Unauthorized access!');

$active_style = $FD->config('style_tag');

$index = $FD->sql()->conn()->query ( "
                SELECT COUNT(`style_id`) AS 'num_styles'
                FROM `".$FD->config('pref')."styles`
                WHERE `style_id` != 0
                AND `style_tag` != 'default'");
$row = $index->fetch(PDO::FETCH_ASSOC);
$num_styles = $row['num_styles'];

$index = $FD->sql()->conn()->query ( '
                SELECT `style_tag`
                FROM `'.$FD->config('pref').'styles`
                WHERE `style_id` != 0
                AND `style_tag` != \'default\'
                ORDER BY `style_id` DESC
                LIMIT 0,1');
$row = $index->fetch(PDO::FETCH_ASSOC);
$last_style = killhtml ( $row['style_tag'] );

// Values
$adminpage->addText('title', $FD->config('title'));
$adminpage->addText('active_style', $active_style);
$adminpage->addText('num_styles', $num_styles);
$adminpage->addText('last_style', $last_style);

echo $adminpage->get('main');

?>
