<?php if (!defined('ACP_GO')) die('Unauthorized access!');

    $TEMPLATE_GO = 'tpl_poll';
    $TEMPLATE_FILE = '0_polls.tpl';
    $TEMPLATE_EDIT = null;

    $tmp['name'] = 'APPLET_POLL_ANSWER_LINE';
    $tmp['title'] = $FD->text("template", "poll_line_title");
    $tmp['description'] = $FD->text("template", "poll_line_description");
    $tmp['rows'] = '15';
    $tmp['cols'] = '66';
        $tmp['help'][0]['tag'] = 'answer';
        $tmp['help'][0]['text'] = $FD->text("template", "poll_line_help_1");
        $tmp['help'][1]['tag'] = 'answer_id';
        $tmp['help'][1]['text'] = $FD->text("template", "poll_line_help_2");
        $tmp['help'][2]['tag'] = 'type';
        $tmp['help'][2]['text'] = $FD->text("template", "poll_line_help_3");
        $tmp['help'][3]['tag'] = 'multiple';
        $tmp['help'][3]['text'] = $FD->text("template", "poll_line_help_4");
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp['name'] = 'APPLET_POLL_BODY';
    $tmp['title'] = $FD->text("template", "poll_body_title");
    $tmp['description'] = $FD->text("template", "poll_body_description");
    $tmp['rows'] = '20';
    $tmp['cols'] = '66';
        $tmp['help'][0]['tag'] = 'question';
        $tmp['help'][0]['text'] = $FD->text("template", "poll_body_help_1");
        $tmp['help'][1]['tag'] = 'answers';
        $tmp['help'][1]['text'] = $FD->text("template", "poll_body_help_2");
        $tmp['help'][2]['tag'] = 'poll_id';
        $tmp['help'][2]['text'] = $FD->text("template", "poll_body_help_3");
        $tmp['help'][3]['tag'] = 'type';
        $tmp['help'][3]['text'] = $FD->text("template", "poll_body_help_4");
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp['name'] = 'APPLET_NO_POLL';
    $tmp['title'] = $FD->text("template", "poll_no_poll_title");
    $tmp['description'] = $FD->text("template", "poll_no_poll_description");
    $tmp['rows'] = '10';
    $tmp['cols'] = '66';
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);



    $tmp['name'] = 'APPLET_RESULT_ANSWER_LINE';
    $tmp['title'] = $FD->text("template", "poll_result_line_title");
    $tmp['description'] = $FD->text("template", "poll_result_line_description");
    $tmp['rows'] = '15';
    $tmp['cols'] = '66';
        $tmp['help'][0]['tag'] = 'answer';
        $tmp['help'][0]['text'] = $FD->text("template", "poll_result_line_help_1");
        $tmp['help'][1]['tag'] = 'votes';
        $tmp['help'][1]['text'] = $FD->text("template", "poll_result_line_help_2");
        $tmp['help'][2]['tag'] = 'percentage';
        $tmp['help'][2]['text'] = $FD->text("template", "poll_result_line_help_3");
        $tmp['help'][3]['tag'] = 'bar_width';
        $tmp['help'][3]['text'] = $FD->text("template", "poll_result_line_help_4");
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp['name'] = 'APPLET_RESULT_BODY';
    $tmp['title'] = $FD->text("template", "poll_result_title");
    $tmp['description'] = $FD->text("template", "poll_result_description");
    $tmp['rows'] = '20';
    $tmp['cols'] = '66';
        $tmp['help'][0]['tag'] = 'question';
        $tmp['help'][0]['text'] = $FD->text("template", "poll_result_help_1");
        $tmp['help'][1]['tag'] = 'answers';
        $tmp['help'][1]['text'] = $FD->text("template", "poll_result_help_2");
        $tmp['help'][2]['tag'] = 'all_votes';
        $tmp['help'][2]['text'] = $FD->text("template", "poll_result_help_3");
        $tmp['help'][3]['tag'] = 'participants';
        $tmp['help'][3]['text'] = $FD->text("template", "poll_result_help_4");
        $tmp['help'][4]['tag'] = 'type';
        $tmp['help'][4]['text'] = $FD->text("template", "poll_result_help_5");
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);



    $tmp['name'] = 'LIST_LINE';
    $tmp['title'] = $FD->text("template", "poll_list_line_title");
    $tmp['description'] = $FD->text("template", "poll_list_line_description");
    $tmp['rows'] = '15';
    $tmp['cols'] = '66';
        $tmp['help'][0]['tag'] = 'question';
        $tmp['help'][0]['text'] = $FD->text("template", "poll_list_line_help_1");
        $tmp['help'][1]['tag'] = 'url';
        $tmp['help'][1]['text'] = $FD->text("template", "poll_list_line_help_2");
        $tmp['help'][2]['tag'] = 'all_votes';
        $tmp['help'][2]['text'] = $FD->text("template", "poll_list_line_help_3");
        $tmp['help'][3]['tag'] = 'participants';
        $tmp['help'][3]['text'] = $FD->text("template", "poll_list_line_help_4");
        $tmp['help'][4]['tag'] = 'type';
        $tmp['help'][4]['text'] = $FD->text("template", "poll_list_line_help_5");
        $tmp['help'][5]['tag'] = 'start_date';
        $tmp['help'][5]['text'] = $FD->text("template", "poll_list_line_help_6");
        $tmp['help'][6]['tag'] = 'end_date';
        $tmp['help'][6]['text'] = $FD->text("template", "poll_list_line_help_7");
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp['name'] = 'LIST_BODY';
    $tmp['title'] = $FD->text("template", "poll_list_title");
    $tmp['description'] = $FD->text("template", "poll_list_description");
    $tmp['rows'] = '20';
    $tmp['cols'] = '66';
        $tmp['help'][0]['tag'] = 'polls';
        $tmp['help'][0]['text'] = $FD->text("template", "poll_list_help_1");
        $tmp['help'][1]['tag'] = 'order_question';
        $tmp['help'][1]['text'] = $FD->text("template", "poll_list_help_2");
        $tmp['help'][3]['tag'] = 'order_all_votes';
        $tmp['help'][3]['text'] = $FD->text("template", "poll_list_help_4");
        $tmp['help'][5]['tag'] = 'order_participants';
        $tmp['help'][5]['text'] = $FD->text("template", "poll_list_help_6");
        $tmp['help'][7]['tag'] = 'order_type';
        $tmp['help'][7]['text'] = $FD->text("template", "poll_list_help_8");
        $tmp['help'][9]['tag'] = 'order_start_date';
        $tmp['help'][9]['text'] = $FD->text("template", "poll_list_help_10");
        $tmp['help'][11]['tag'] = 'order_end_date';
        $tmp['help'][11]['text'] = $FD->text("template", "poll_list_help_12");

        $tmp['help'][2]['tag'] = 'arrow_question';
        $tmp['help'][2]['text'] = $FD->text("template", "poll_list_help_3");
        $tmp['help'][4]['tag'] = 'arrow_all_votes';
        $tmp['help'][4]['text'] = $FD->text("template", "poll_list_help_5");
        $tmp['help'][6]['tag'] = 'arrow_participants';
        $tmp['help'][6]['text'] = $FD->text("template", "poll_list_help_7");
        $tmp['help'][8]['tag'] = 'arrow_type';
        $tmp['help'][8]['text'] = $FD->text("template", "poll_list_help_9");
        $tmp['help'][10]['tag'] = 'arrow_start_date';
        $tmp['help'][10]['text'] = $FD->text("template", "poll_list_help_11");
        $tmp['help'][12]['tag'] = 'arrow_end_date';
        $tmp['help'][12]['text'] = $FD->text("template", "poll_list_help_13");
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);


    $tmp['name'] = 'ANSWER_LINE';
    $tmp['title'] = $FD->text("template", "poll_main_line_title");
    $tmp['description'] = $FD->text("template", "poll_main_line_description");
    $tmp['rows'] = '15';
    $tmp['cols'] = '66';
        $tmp['help'][0]['tag'] = 'answer';
        $tmp['help'][0]['text'] = $FD->text("template", "poll_main_line_help_1");
        $tmp['help'][1]['tag'] = 'votes';
        $tmp['help'][1]['text'] = $FD->text("template", "poll_main_line_help_2");
        $tmp['help'][2]['tag'] = 'percentage';
        $tmp['help'][2]['text'] = $FD->text("template", "poll_main_line_help_3");
        $tmp['help'][3]['tag'] = 'bar_width';
        $tmp['help'][3]['text'] = $FD->text("template", "poll_main_line_help_4");
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp['name'] = 'BODY';
    $tmp['title'] = $FD->text("template", "poll_main_body_title");
    $tmp['description'] = $FD->text("template", "poll_main_body_description");
    $tmp['rows'] = '20';
    $tmp['cols'] = '66';
        $tmp['help'][0]['tag'] = 'question';
        $tmp['help'][0]['text'] = $FD->text("template", "poll_main_body_help_1");
        $tmp['help'][1]['tag'] = 'answers';
        $tmp['help'][1]['text'] = $FD->text("template", "poll_main_body_help_2");
        $tmp['help'][2]['tag'] = 'all_votes';
        $tmp['help'][2]['text'] = $FD->text("template", "poll_main_body_help_3");
        $tmp['help'][3]['tag'] = 'participants';
        $tmp['help'][3]['text'] = $FD->text("template", "poll_main_body_help_4");
        $tmp['help'][4]['tag'] = 'type';
        $tmp['help'][4]['text'] = $FD->text("template", "poll_main_body_help_5");
        $tmp['help'][5]['tag'] = 'start_date';
        $tmp['help'][5]['text'] = $FD->text("template", "poll_main_body_help_6");
        $tmp['help'][6]['tag'] = 'end_date';
        $tmp['help'][6]['text'] = $FD->text("template", "poll_main_body_help_7");
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);


echo templatepage_init ($TEMPLATE_EDIT, $TEMPLATE_GO, $TEMPLATE_FILE);
?>
