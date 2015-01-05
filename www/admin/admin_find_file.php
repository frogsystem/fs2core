<?php if (!defined('ACP_GO')) die('Unauthorized access!');

//identify directories
function ftp_is_dir($conn, $dir) {
  if (@ftp_chdir($conn, $dir)) {
    @ftp_chdir($conn, '..');
    return true;
  } else {
    return false;
  }
}

// get script
$adminpage->clearConds();
$adminpage->clearTexts();
$adminpage->addText('file_id', $_GET['id']);
echo $adminpage->get('script');

try {
    $ftp = $FD->db()->conn()->query('SELECT * FROM '.$FD->env('DB_PREFIX').'ftp WHERE `ftp_id` = 1 LIMIT 1');
    $ftp = $ftp->fetch(PDO::FETCH_ASSOC);

    // establish connection
    if($ftp['ftp_ssl']) {
        $_SESSION['ftp_conn'] = @ftp_ssl_connect($ftp['ftp_url']);
    } else {
        $_SESSION['ftp_conn'] = @ftp_connect($ftp['ftp_url']);
    }

    // Login with user name and password
    $login_result = @ftp_login($_SESSION['ftp_conn'], $ftp['ftp_user'], $ftp['ftp_pw']);

    // check connection
    if ((!$_SESSION['ftp_conn']) || (!$login_result)) {
        // display error
        $adminpage->clearConds();
        $adminpage->clearTexts();
        $adminpage->addText('connection_error_text', sprintf($FD->text('page', 'connection_error_text'), htmlenclose($ftp['ftp_url'], 'strong'), htmlenclose($ftp['ftp_user'], 'strong')));
        $content = $adminpage->get('conn_error');

    } else {

        // get list
        $_GET['f'] = isset($_GET['f']) ? $_GET['f'] : '/';
        ftp_chdir($_SESSION['ftp_conn'], $_GET['f']);
        $_GET['f'] = ftp_pwd($_SESSION['ftp_conn']);
        $_GET['f'] = $_GET['f'] == '/' ? $_GET['f'] : $_GET['f'].'/';
        $files = ftp_nlist($_SESSION['ftp_conn'], '.');

        // create breadcombs
        $furllist = explode('/', $_GET['f']);
        unset($furllinks, $fpath);
        $furllinks = '<a href="?go=find_file&amp;id='.$_GET['id'].'&amp;f=/" title="'.$FD->text("page", "change_dir").'">&nbsp;.&nbsp;</a>';
        foreach($furllist as $furl) {
            if (!empty($furl)) {
                $fpath .= '/'.$furl;
                $furllinks .= '/<a href="?go=find_file&amp;id='.$_GET['id'].'&amp;f='.$fpath.'" title="'.$FD->text("page", "change_dir").'">'.$furl.'</a>';
            }
        }

        // display list
        $file_list = array();
        $folder_list = array();

        foreach($files as $file) {

            $file_path =  $_GET['f'].$file;
            $http_url = $ftp['ftp_http_url'].$file_path;

            if (ftp_is_dir($_SESSION['ftp_conn'],$file_path)) {

                $adminpage->clearConds();
                $adminpage->clearTexts();
                $adminpage->addText('folder_url', '?go=find_file&amp;id='.$_GET['id'].'&amp;f='.$file_path);
                $adminpage->addText('folder_name', $file);
                $adminpage->addText('http_url', $http_url);
                $folder_list[strtolower($file)] = $adminpage->get('folder');

            } else {
                $size = ftp_size($_SESSION['ftp_conn'],$file);
                $size = round($size/1024);

                $adminpage->clearConds();
                $adminpage->clearTexts();
                $adminpage->addText('file_name', $file);
                $adminpage->addText('http_url', $http_url);
                $adminpage->addText('size', $size );
                $file_list[strtolower($file)] = $adminpage->get('file');
            }
        }

        ksort($folder_list, SORT_STRING);
        ksort($file_list, SORT_STRING);

        // display page
        $adminpage->clearConds();
        $adminpage->clearTexts();
        $adminpage->addText('connection_ok', sprintf($FD->text('page', 'connection_ok'), htmlenclose($ftp['ftp_url'], 'strong'), htmlenclose($ftp['ftp_user'], 'strong')));
        $adminpage->addText('url_links', $furllinks);
        $adminpage->addText('up_url', '?go=find_file&amp;id='.$_GET['id'].'&amp;f='.$_GET['f'].'..');
        $adminpage->addText('lines', implode($folder_list).implode($file_list));

        $content = $adminpage->get('main');
    }

    // close connection
    @ftp_close($_SESSION['ftp_conn']);

} catch (Exception $e) {
    // display error
    $adminpage->clearConds();
    $adminpage->clearTexts();
    $content = $adminpage->get('no_conn');
}

echo get_content_container('&nbsp;', $content);

?>
