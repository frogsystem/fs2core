<?php if (!defined('ACP_GO')) die('Unauthorized access!');

// get script
$adminpage->clearConds();
$adminpage->clearTexts();

$adminpage->addText('name', isset($_GET['name']) ? $_GET['name'] : 'username');
$adminpage->addText('id', isset($_GET['id']) ? $_GET['id'] : 'userid');
echo $adminpage->get('script');

// get search
$adminpage->clearConds();
$adminpage->clearTexts();
if (!empty($_POST['filter'])) {
    $adminpage->addText('filter', killhtml($_POST['filter']));
}
echo $adminpage->get('search');


if (!empty($_POST['filter'])) {

    //get users by filter
    $users = $FD->db()->conn()->prepare(
                  'SELECT user_name, user_id, user_is_admin, user_is_staff
                   FROM '.$FD->env('DB_PREFIX').'user
                   WHERE user_name LIKE ?
                   ORDER BY `user_name`');
    $users->execute(array('%'.$_POST['filter'].'%'));
    $users = $users->fetchAll(PDO::FETCH_ASSOC);

    if (count($users) < 1) {
        // display error
        $adminpage->clearConds();
        $adminpage->clearTexts();
        $content = $adminpage->get('no');
    } else {
        // get lines
        initstr($lines);
        foreach ($users as $user) {
            $user['user_name'] = killhtml($user['user_name']);
            $user['user_name'] = ($user['user_is_staff'] == 1) ? htmlenclose($user['user_name'], 'strong') : $user['user_name'];
            $user['user_name'] = ($user['user_is_admin'] == 1) ? htmlenclose($user['user_name'], 'em') : $user['user_name'];

            // get line tpl
            $adminpage->clearConds();
            $adminpage->clearTexts();
            $adminpage->addText('user', $user['user_name']);
            $adminpage->addText('user_id', $user['user_id']);
            $lines .= $adminpage->get('line');
        }

        //get main tpl
        $adminpage->clearConds();
        $adminpage->clearTexts();
        $adminpage->addText('lines', $lines);
        $content = $adminpage->get('main');
    }

    echo get_content_container('&nbsp;', $content);
}

?>
