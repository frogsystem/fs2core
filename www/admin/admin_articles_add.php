<?php if (!defined('ACP_GO')) die('Unauthorized access!');

// Load existing "article_url"s in Array
$url_arr = get_article_urls ();

/////////////////////
//// Add Article ////
/////////////////////

if (
        isset ( $_POST['sended'] ) &&
        isset ( $_POST['article_cat_id'] ) &&
        isset($_POST['article_title']) && $_POST['article_title'] != '' &&
        (empty($url_arr) || !in_array ( $_POST['article_url'], $url_arr )) &&

        ( ( $_POST['d'] && $_POST['d'] > 0 && $_POST['d'] <= 31 ) || ( $_POST['d'] == '' && $_POST['m'] == '' && $_POST['y'] == '' ) ) &&
        ( ( $_POST['m'] && $_POST['m'] > 0 && $_POST['m'] <= 12 ) || ( $_POST['d'] == '' && $_POST['m'] == '' && $_POST['y'] == '' ) ) &&
        ( ( $_POST['y'] && $_POST['y'] > 0 ) || ( $_POST['d'] == '' && $_POST['m'] == '' && $_POST['y'] == '' ) )
    )
{
    // No User
    if ( !isset ( $_POST['article_user'] ) ) {
        $_POST['article_user'] = 0;
    }

    $_POST['article_url'] = trim ( $_POST['article_url'] );
    $_POST['article_title'] = trim ( $_POST['article_title'] );
    $_POST['article_text'] = trim ( $_POST['article_text'] );

    // Security Functions
    settype ( $_POST['article_cat_id'], 'integer' );
    settype ( $_POST['article_html'], 'integer' );
    settype ( $_POST['article_user'], 'integer' );
    settype ( $_POST['article_fscode'], 'integer' );
    settype ( $_POST['article_para'], 'integer' );

    // Create Date
    if ( $_POST['d'] != '' && $_POST['m'] != '' && $_POST['y'] != '' ) {
            $date_arr = getsavedate ( $_POST['d'], $_POST['m'], $_POST['y'] );
            $articledate = mktime ( 0, 0, 0, $date_arr['m'], $date_arr['d'], $date_arr['y'] );
    } else {
            $articledate = 0;
    }

    // SQL-Insert-Query
    $stmt = $FD->sql()->conn()->prepare ('
                INSERT INTO
                    '.$FD->config('pref')."articles
                    (article_url, article_title, article_date, article_user, article_text, article_html, article_fscode, article_para, article_cat_id, article_search_update)
                VALUES (
                    ?,
                    ?,
                    '".$articledate."',
                    '".$_POST['article_user']."',
                    ?,
                    '".$_POST['article_html']."',
                    '".$_POST['article_fscode']."',
                    '".$_POST['article_para']."',
                    '".$_POST['article_cat_id']."',
                    '".time()."'
                )" );
    $stmt->execute(array($_POST['article_url'], $_POST['article_title'], $_POST['article_text']));

    // Update Search Index (or not)
    if ( $FD->config('cronjobs', 'search_index_update') === 1 ) {
        // Include searchfunctions.php
        require ( FS2_ROOT_PATH . 'includes/searchfunctions.php' );
        update_search_index ( 'articles' );
    }

    $FD->sql()->conn()->exec ( 'UPDATE '.$FD->config('pref').'counter SET artikel = artikel + 1' );
    systext( $FD->text('page', 'articles_added'), $FD->text('admin', 'info'));
}

//////////////////////////////
//// Display Article Form ////
//////////////////////////////

else
{
    // Display Error Messages
    if ( isset ( $_POST['sended'] ) ) {
        if ( in_array ( $_POST['article_url'], $url_arr ) ) {
            systext ( $FD->text('page', 'existing_url'), $FD->text('admin', 'error'), TRUE );
        } else {
            systext ( $FD->text('admin', 'note_notfilled'), $FD->text('admin', 'error'), TRUE );
        }
    } else {
        $_POST['article_html'] = 1;
        $_POST['article_fscode'] = 1;
        $_POST['article_para'] = 1;
    }

    // Load Article Config
    $FD->loadConfig('articles');
    $config_arr = $FD->configObject('articles')->getConfigArray();

    // Create HTML, FSCode & Para-Handling Vars
    $config_arr['html_code_bool'] = ($config_arr['html_code'] == 2 || $config_arr['html_code'] == 4);
    $config_arr['fs_code_bool'] = ($config_arr['fs_code'] == 2 || $config_arr['fs_code'] == 4);
    $config_arr['para_handling_bool'] = ($config_arr['para_handling'] == 2 || $config_arr['para_handling'] == 4);

    $config_arr['html_code_text'] = ( $config_arr['html_code_bool'] ) ? $FD->text("admin", "on") : $FD->text("admin", "off");
    $config_arr['fs_code_text'] = ( $config_arr['fs_code_bool'] ) ? $FD->text("admin", "on") : $FD->text("admin", "off");
    $config_arr['para_handling_text'] = ( $config_arr['para_handling_bool'] ) ? $FD->text("admin", "on") : $FD->text("admin", "off");

    // Get User ID
    if ( !isset ( $_POST['article_user'] ) ) {
            $_POST['article_user'] = $_SESSION['user_id'];
    }

    // Security-Functions
    $_POST['article_url'] = isset($_POST['article_url']) ? killhtml ( $_POST['article_url'] ) : '';
    $_POST['article_title'] = isset($_POST['article_title']) ? killhtml ( $_POST['article_title'] ) : '';
    $_POST['article_text'] = isset($_POST['article_text']) ? killhtml ( $_POST['article_text'] ) : '';
    settype ( $_POST['article_user'], 'integer' );
    settype ( $_POST['article_html'], 'integer' );
    settype ( $_POST['article_fscode'], 'integer' );
    settype ( $_POST['article_para'], 'integer' );
    settype ( $_POST['article_cat_id'], 'integer' );

    // Get User
    if ( $_POST['article_user'] != 0 ) {
        $index = $FD->sql()->conn()->query ( 'SELECT user_name, user_id FROM '.$FD->config('pref')."user WHERE user_id = '".$_POST['article_user']."'" );
        $ur = $index->fetch(PDO::FETCH_ASSOC);
        $_POST['article_user_name'] = killhtml ( $ur['user_name'] );
    } else {
        $_POST['article_user_name'] = '';
    }


    // Create Date-Arrays
    if ( !isset ( $_POST['sended'] ) )
    {
        $_POST['d'] = date ( 'd' );
        $_POST['m'] = date ( 'm' );
        $_POST['y'] = date ( 'Y' );
    }
    $date_arr = getsavedate ( $_POST['d'], $_POST['m'], $_POST['y'], 0, 0, 0, TRUE );
    $nowbutton_array = array( 'd', 'm', 'y' );

    // Display Page
    echo'
                                        <form action="" method="post">
                                                <input type="hidden" name="go" value="articles_add">
                        <input type="hidden" name="sended" value="1">
                        <table class="configtable" cellpadding="4" cellspacing="0">
                                                        <tr><td class="line" colspan="2">'.$FD->text("page", "articles_info_title").'</td></tr>
                            <tr>
                                <td class="config" width="250">
                                    '.$FD->text("page", "articles_url").': <span class="small">('.$FD->text("admin", "optional").')</span><br>
                                    <span class="small">'.$FD->text("page", "articles_url_desc").'</span>
                                </td>
                                <td class="config" width="350">
                                    ?go = <input class="text" size="40" maxlength="100" name="article_url" value="'.$_POST['article_url'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$FD->text("page", "articles_cat").':<br>
                                    <span class="small">'.$FD->text("page", "articles_cat_desc").'</span>
                                </td>
                                <td class="config">
                                    <select name="article_cat_id">
        ';
    // List categories
    $index = $FD->sql()->conn()->query ( 'SELECT * FROM '.$FD->config('pref').'articles_cat' );
    while ( $cat_arr = $index->fetch(PDO::FETCH_ASSOC) )
    {
        settype ( $cat_arr['cat_id'], 'integer' );
        echo '<option value="'.$cat_arr['cat_id'].'" '.getselected($cat_arr['cat_id'], $_POST['article_cat_id']).'>'.$cat_arr['cat_name'].'</option>';
    }
    echo '
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$FD->text("page", "articles_date").': <span class="small">('.$FD->text("admin", "optional").')</span><br>
                                    <span class="small">'.$FD->text("page", "articles_date_desc").'</span>
                                </td>
                                <td class="config">
                                                                        <span class="small">
                                                                                <input class="text" size="3" maxlength="2" id="d" name="d" value="'.$date_arr['d'].'"> .
                                            <input class="text" size="3" maxlength="2" id="m" name="m" value="'.$date_arr['m'].'"> .
                                            <input class="text" size="5" maxlength="4" id="y" name="y" value="'.$date_arr['y'].'">&nbsp;
                                                                        </span>
                                                                        '.js_nowbutton ( $nowbutton_array, $FD->text("admin", "today") ).'
                                    <input onClick=\'document.getElementById("d").value="";
                                                     document.getElementById("m").value="";
                                                     document.getElementById("y").value="";\' class="button" type="button" value="'.$FD->text("admin", "delete").'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$FD->text("page", "articles_poster").': <span class="small">('.$FD->text("admin", "optional").')</span><br>
                                    <span class="small">'.$FD->text("page", "articles_poster_desc").'</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="30" maxlength="100" disabled="disabled" readonly="readonly" id="username" name="article_user_name" value="'.$_POST['article_user_name'].'">
                                    <input type="hidden" id="userid" name="article_user" value="'.$_POST['article_user'].'">
                                    <input class="button" type="button" onClick=\''.openpopup ( '?go=find_user', 400, 400 ).'\' value="'.$FD->text("admin", "change").'">
                                    <input onClick=\'document.getElementById("username").value="";
                                                     document.getElementById("userid").value="0";\' class="button" type="button" value="'.$FD->text("admin", "delete").'">
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                                                        <tr><td class="line" colspan="2">'.$FD->text("page", "articles_new_title").'</td></tr>
                            <tr>
                                <td class="config" colspan="2">
                                    '.$FD->text("page", "articles_title").':
                                </td>
                            </tr>
                            <tr>
                                <td class="config" colspan="2">
                                    <input class="text" size="75" maxlength="255" name="article_title" id="article_title" value="'.$_POST['article_title'].'"><br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" colspan="2">

                                    <table cellpadding="0" cellspacing="0" width="100%">
                                        <tr>
                                            <td class="config">
                                                '.$FD->text('page', 'articles_text').':
                                            </td>
                                            <td class="config" style="text-align:right;">
        ';

        if ( $config_arr['html_code_bool'] ) {
            echo '<input class="pointer middle" type="checkbox" name="article_html" id="article_html" value="1" '.getchecked ( 1, $_POST['article_html'] ).'>
                <span class="small middle">'.$FD->text("page", "articles_use_html").'</span>&nbsp;&nbsp;';
        } else {
            echo '<input class="middle" type="checkbox" name="article_html" id="article_html" value="0" disabled="disabled">
                <span class="small middle">'.$FD->text("admin", "html").' '.$config_arr['html_code_text'].'</span>&nbsp;&nbsp;';
        }
        if ( $config_arr['fs_code_bool'] ) {
            echo '<input class="pointer middle" type="checkbox" name="article_fscode" id="article_fscode" value="1" '.getchecked ( 1, $_POST['article_fscode'] ).'>
                <span class="small middle">'.$FD->text("page", "articles_use_fscode").'</span>&nbsp;&nbsp;';
        } else {
            echo '<input class="middle" type="checkbox" name="article_fscode" id="article_fscode" value="0" disabled="disabled">
                <span class="small middle">'.$FD->text("admin", "fscode").' '.$config_arr['fs_code_text'].'</span>&nbsp;&nbsp;';
        }
        if ( $config_arr['para_handling_bool'] ) {
            echo '<input class="pointer middle" type="checkbox" name="article_para" id="article_para" value="1" '.getchecked ( 1, $_POST['article_para'] ).'>
                <span class="small middle">'.$FD->text("page", "articles_use_para").'</span>';
        } else {
            echo '<input class="middle" type="checkbox" name="article_para" id="article_para" value="0" disabled="disabled">
                <span class="small middle">'.$FD->text("admin", "para").' '.$config_arr['para_handling_text'].'</span>';
        }

        echo '
                                                                                        </td>
                                                                                </tr>
                                                                        </table>

                                </td>
                            </tr>
                            <tr>
                                <td class="config" colspan="2">
                                    '.create_editor ( 'article_text', $_POST['article_text'], '100%', '500px', '', FALSE).'
                                </td>
                            </tr>
                            <tr>
                                                                <td class="config" colspan="2">
                                    <input class="button" type="button" onClick=\'popTab("?go=article_preview", "_blank")\' value="'.$FD->text("admin", "preview").'">
                                                                </td>
                                                        </tr>
                                                        <tr><td class="space"></td></tr>
                            <tr>
                                <td class="buttontd" colspan="2">
                                    <button class="button_new" type="submit">
                                        '.$FD->text("admin", "button_arrow").' '.$FD->text("page", "articles_add_button").'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}


//////////////////////////////
//// Save article into DB ////
//////////////////////////////

if (isset($_POST['url']) && isset($_POST['title']) && isset($_POST['text']) && isset($_POST['cat_id']))
{
    if (isset($_POST['tag']) && isset($_POST['monat']) && isset($_POST['jahr']))  // check date
    {
       $date = mktime(0, 0, 0, $_POST['monat'], $_POST['tag'], $_POST['jahr']);
    }
    else
    {
        $date = 0;
    }

    $_POST['url'] = trim($_POST['url']);
    $index = $FD->sql()->conn()->prepare('SELECT artikel_url FROM '.$FD->config('pref').'artikel WHERE artikel_url = ?');
    $index->execute(array($_POST['url']));
    $art_row = $index->fetch(PDO::FETCH_ASSOC);
    if ($art_row === false)
    {
        $_POST['title'] = trim($_POST['title']);
        $_POST['text'] = trim($_POST['text']);
        settype($_POST['cat_id'], 'integer');
        settype($_POST['posterid'], 'integer');
        $_POST['search'] = isset($_POST['search']) ? 1 : 0;
        $_POST['fscode'] = isset($_POST['fscode']) ? 1 : 0;

        $stmt = $FD->sql()->conn()->prepare('INSERT INTO '.$FD->config('pref')."artikel
                     VALUES (NULL,
                             ?,
                             ?,
                             '$date',
                             '$_POST[posterid]',
                             ?,
                             '$_POST[search]',
                             '$_POST[fscode]',
                             '$_POST[cat_id]');");
        $stmt->execute(array($_POST['url'], $_POST['title'], $_POST['text']));
        $FD->sql()->conn()->exec('UPDATE '.$FD->config('pref').'counter SET artikel = artikel + 1');
        systext('Artikel wurde gespeichert');
    }
    else
    {
        systext('Diese Artikel-URL exitiert bereits');
    }
}
?>
