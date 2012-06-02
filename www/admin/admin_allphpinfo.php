<?php
if ( isset ( $_GET['info'] ) ) {
	// Start Session
	session_start();
	if ( $_SESSION['gen_phpinfo'] == 1 ) {
	    phpinfo();
	}

} else {
    if (!defined("ACP_GO")) die("Unauthorized access!");
    
    echo '
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="4">'.$FD->text("page", "phpinfo_title").'</td></tr>
                            <tr>
                                <td class="config" width="150">
                                    '.$FD->text("page", "phpinfo_version").':
                                </td>
                                <td class="configthin" width="150">
                                    '.phpversion().'
                                </td>
                                <td class="config" width="150">
                                    '.$FD->text("page", "phpinfo_zendversion").':
                                </td>
                                <td class="configthin" width="150">
                                    '.zend_version().'
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$FD->text("page", "phpinfo_phpuser").':
                                </td>
                                <td class="configthin" colspan="3">
                                    '.get_current_user().'
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="config">
                                    '.$FD->text("page", "phpinfo_servername").':
                                </td>
                                <td class="configthin">
                                    '.$_SERVER['SERVER_NAME'].'
                                </td>
                                <td class="config">
                                </td>
                                <td class="configthin">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$FD->text("page", "phpinfo_serverip").':
                                </td>
                                <td class="configthin">
                                    '.$_SERVER['SERVER_ADDR'].':'.$_SERVER['SERVER_PORT'].'
                                </td>
                                <td class="config">
                                    '.$FD->text("page", "phpinfo_serverprotocol").':
                                </td>
                                <td class="configthin" >
                                    '.$_SERVER['SERVER_PROTOCOL'].'
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="config">
                                    '.$FD->text("page", "phpinfo_serversoftware").':
                                </td>
                                <td class="configthin" colspan="3">
                                    '.$_SERVER['SERVER_SOFTWARE'].'
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="buttontd" colspan="4">
                                    <a class="link_button" href="admin_allphpinfo.php?info" target="_blank">
                                        '.$FD->text("admin", "button_arrow").' '.$FD->text("page", "phpinfo_show_link").'
                                    </a>
                                </td>
                            </tr>
                        </table>
	';
}
?>
