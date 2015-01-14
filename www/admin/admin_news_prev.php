<?php if (!defined('ACP_GO')) die('Unauthorized access!');

    // Reload Page
    if ( !isset($_POST['sended']) ) {

        // Reload Page Template
        $template = '
        <script type="text/javascript">
            $().ready(function(){
                loaddata();
                document.getElementById(\'form\').submit();
            });

            function loaddata() {
                $("#news_title").val($(opener.document).find("#news_title").val());
                $("#news_text").val($(opener.document).find("#news_text").val());
                $("#news_user").val($(opener.document).find("#user_id").val());
                $("#news_user_name").val($(opener.document).find("#user_name").val());
                $("#news_cat_id").val($(opener.document).find("#cat_id").val());

                $("#d").val($(opener.document).find("#d").val());
                $("#m").val($(opener.document).find("#m").val());
                $("#y").val($(opener.document).find("#y").val());
                $("#h").val($(opener.document).find("#h").val());
                $("#i").val($(opener.document).find("#i").val());

                $(opener.document).find("[name^=link_name]").each(function (num, ele) {
                    $("#form").append(\'<input id="link_name[\'+num+\']" name="link_name[\'+num+\']" type="hidden" value="\'+$(ele).val()+\'">\');
                });
                $(opener.document).find("[name^=link_url]").each(function (num, ele) {
                    $("#form").append(\'<input id="link_url[\'+num+\']" name="link_url[\'+num+\']" type="hidden" value="\'+$(ele).val()+\'">\');
                });
                $(opener.document).find("[name^=link_target]").each(function (num, ele) {
                    $("#form").append(\'<input id="link_target[\'+num+\']" name="link_target[\'+num+\']" type="hidden" value="\'+$(ele).val()+\'">\');
                });
            }
        </script>

        <form action="" method="post" id="form">
            <input type="hidden" name="go" value="news_preview">
            <input type="hidden" name="sended" value="1">

            <input type="hidden" name="news_title" id="news_title" value="">
            <input type="hidden" name="news_text" id="news_text" value="">

            <input type="hidden" name="news_user" id="news_user" value="">
            <input type="hidden" name="news_user_name" id="news_user_name" value="">

            <input type="hidden" name="news_cat_id" id="news_cat_id" value="">

            <input type="hidden" name="d" id="d" value="">
            <input type="hidden" name="m" id="m" value="">
            <input type="hidden" name="y" id="y" value="">
            <input type="hidden" name="h" id="h" value="">
            <input type="hidden" name="i" id="i" value="">

        </form>

        '.get_content_container('&nbsp;', $FD->text("page", "preview_note")).'
        ';

        // "Display" Reload Page
        echo $template;
    }

    // Preview Page
    else {
        // goto
        $goto = 'news_preview';
        $FD->setConfig('env', 'get_go', $goto);
        $FD->setConfig('goto', $goto);
        $FD->setConfig('env', 'goto', $goto);  
    
        // Get News Config
        $FD->loadConfig('news');
        $config_arr = $FD->configObject('news')->getConfigArray();

        // Load Data from $_POST
        $news_arr['comment_url'] = '?go=news_preview';
        $news_arr['kommentare'] = '?';

        // Create New-Date
        if (
                ( $_POST['d'] && $_POST['d'] != '' && $_POST['d'] > 0 ) &&
                ( $_POST['m'] && $_POST['m'] != '' && $_POST['m'] > 0 ) &&
                ( $_POST['y'] && $_POST['y'] != '' && $_POST['y'] > 0 ) &&
                ( $_POST['h'] && $_POST['h'] != '' && $_POST['h'] >= 0 ) &&
                ( $_POST['i'] && $_POST['i'] != '' && $_POST['i'] >= 0 ) &&
                ( isset ( $_POST['d'] ) && isset ( $_POST['m'] ) && isset ( $_POST['y'] ) && isset ( $_POST['h'] ) && isset ( $_POST['i'] ))
            )
        {
            settype ( $_POST['d'], 'integer' );
            settype ( $_POST['m'], 'integer' );
            settype ( $_POST['y'], 'integer' );
            settype ( $_POST['h'], 'integer' );
            settype ( $_POST['i'], 'integer' );
            $news_arr['news_date'] = mktime ( $_POST['h'], $_POST['i'], 0, $_POST['m'], $_POST['d'], $_POST['y'] );
        } else {
            $news_arr['news_date'] = 0;
        }
        $news_arr['news_date'] = date_loc( $FD->config('datetime') , $news_arr['news_date']);

        // Create User Template
        $news_arr['user_name'] = killhtml($_POST['news_user_name']);
        settype($_POST['news_user'], 'integer');
        $news_arr['user_url'] = '../?go=user&amp;id='.$_POST['news_user'];

        // Format Text
        $html = ($config_arr['html_code'] == 2 || $config_arr['html_code'] == 4) ? TRUE : FALSE;
        $fs = ($config_arr['fs_code'] == 2 || $config_arr['fs_code'] == 4) ? TRUE : FALSE;
        $para = ($config_arr['para_handling'] == 2 || $config_arr['para_handling'] == 4) ? TRUE : FALSE;

        $news_arr['news_text'] = fscode ( $_POST['news_text'], $fs, $html, $para );
        $news_arr['news_title'] = killhtml ( $_POST['news_title'] );

        // Read category from DB
        settype($_POST['news_cat_id'], 'integer');
        $index = $FD->db()->conn()->query('SELECT `cat_name`, `cat_id` FROM `'.$FD->env('DB_PREFIX')."news_cat` WHERE `cat_id` = '".$_POST['news_cat_id']."'");
        $cat_arr = $index->fetch(PDO::FETCH_ASSOC);
        if (!empty($cat_arr)) {
			$cat_arr['cat_name'] = killhtml($cat_arr['cat_name']);
		} else {
			$cat_arr['cat_name'] = '?';
			$cat_arr['cat_id'] = -1;
		}
        $cat_arr['cat_pic'] = image_url('/cat', 'news_'.$cat_arr['cat_id']);


        // Get Related Links
        $link_tpl = '';

        if (isset($_POST['link_name'],$_POST['link_url'],$_POST['link_target'])) {
            foreach($_POST['link_name'] as $key => $linkname)
            {
                if ( $_POST['link_name'][$key] != '' && $_POST['link_url'][$key] != '' ) {
                    $link_arr['link_name'] = killhtml ($_POST['link_name'][$key] );
                    $link_arr['link_url'] = killhtml ($_POST['link_url'][$key]);
                    $link_arr['link_target'] = ( $_POST['link_target'][$key] == 1 ) ? '_blank' : '_self';

                    // Get Link Line Template
                    $link = new template();
                    $link->setFile('0_news.tpl');
                    $link->load('LINKS_LINE');

                    $link->tag('title', $link_arr['link_name'] );
                    $link->tag('url', $link_arr['link_url'] );
                    $link->tag('target', $link_arr['link_target'] );

                    $link = $link->display ();
                    $link_tpl .= $link;
                }
            }
        }
        if ($link_tpl != '') {
            // Get Links Body Template
            $related_links = new template();
            $related_links->setFile('0_news.tpl');
            $related_links->load('LINKS_BODY');
            $related_links->tag('links', $link_tpl );
            $related_links = $related_links->display ();
        } else {
            $related_links = '';
        }

        // Create Template
        $template = new template();
        $template->setFile('0_news.tpl');
        $template->load('NEWS_BODY');

        $template->tag('news_id', 0 );
        $template->tag('titel', $news_arr['news_title'] );
        $template->tag('date', $news_arr['news_date'] );
        $template->tag('text', $news_arr['news_text'] );
        $template->tag('user_name', $news_arr['user_name'] );
        $template->tag('user_url', $news_arr['user_url'] );
        $template->tag('cat_name', $cat_arr['cat_name'] );
        $template->tag('cat_image', $cat_arr['cat_pic'] );
        $template->tag('comments_url', $news_arr['comment_url'] );
        $template->tag('comments_number', $news_arr['kommentare'] );
        $template->tag('related_links', $related_links );
        $template_preview = $template->display();


        // Preview Page Template
        $FD->setConfig('dyn_title', 1);
        $FD->setConfig('dyn_title_ext', '{..ext..}');
        $FD->setConfig('info', 'page_title', $FD->text('page', 'preview_title').': '.$news_arr['news_title']);

        $theTemplate = new template();
        $theTemplate->setFile('0_main.tpl');
        $theTemplate->load('MAIN');
        $theTemplate->tag('content', $template_preview);
        $theTemplate->tag('copyright', get_copyright());

        $template_general = (string) $theTemplate;
        $template_general = tpl_functions_init($template_general);

        // Get Main Template
        echo get_maintemplate ($template_general, '../');
        $JUST_CONTENT = true; //preview has own HTML head
    }

?>
