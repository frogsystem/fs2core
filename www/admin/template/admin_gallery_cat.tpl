<!--DEF::add-->                    <form action="" method="post">
                        <input type="hidden" name="go" value="<!--TEXT::ACP_GO-->">
                        <input type="hidden" name="cat_action" value="add">
                        
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr>
                                <td class="line" colspan="2">
                                    <!--LANG::viewer_title-->
                                </td>
                            </tr>
                            <tr>
                                <td class="config right_space">
                                    <span class="small">'.$admin_phrases[news][new_cat_name].':</span>
                                </td>
                                <td class="config">
                                    <span class="small">'.$admin_phrases[news][new_cat_image].': '.$admin_phrases[common][optional].'</span>
                                </td>
                            </tr>
                            <tr valign="top">
                                <td class="config">
                                    <input class="text" name="cat_name" size="40" maxlength="100" value="'.$_POST['cat_name'].'">
                                </td>
                                <td class="config">
                                    <input name="cat_pic" type="file" size="30" class="text"><br>
                                    <span class="small">
                                        ['.$admin_phrases[common][max].' '.$news_config_arr[cat_pic_x].' '.$admin_phrases[common][resolution_x].' '.$news_config_arr[cat_pic_y].' '.$admin_phrases[common][pixel].'] ['.$admin_phrases[common][max].' '.$news_config_arr[cat_pic_size].' '.$admin_phrases[common][kib].']
                                    </span>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="buttontd" colspan="2">
                                    <button type="submit" name="sended" value="1" class="button_new">
                                        <!--COMMON::button_arrow-->
                                        <!--COMMON::save_changes_button-->
                                    </button>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                        </table>
                    </form><!--ENDDEF-->

<!--DEF::edit-->                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="sended" value="edit">
                        <input type="hidden" name="cat_action" value="'.$_POST['cat_action'].'">
                        <input type="hidden" name="cat_id" value="'.$cat_arr['cat_id'].'">
                        <input type="hidden" name="go" value="news_cat">
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="2">'.$admin_phrases[news][edit_cat_title].'</td></tr>
                               <tr>
                                   <td class="config">
                                       '.$admin_phrases[news][edit_cat_name].':<br>
                                       <span class="small">'.$admin_phrases[news][edit_cat_name_desc].'</span>
                                   </td>
                                   <td>
                                     <input class="text" name="cat_name" size="40" maxlength="100" value="'.$cat_arr['cat_name'].'">
                                   </td>
                               </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[news][edit_cat_date].':<br>
                                    <span class="small">'.$admin_phrases[news][edit_cat_date_desc].'</span>
                                </td>
                                <td class="config" valign="top">
                                    <span class="small">
                                        <input class="text" size="3" maxlength="2" id="d" name="d" value="'.$date_arr['d'].'"> .
                                        <input class="text" size="3" maxlength="2" id="m" name="m" value="'.$date_arr['m'].'"> .
                                        <input class="text" size="5" maxlength="4" id="y" name="y" value="'.$date_arr['y'].'">&nbsp;
                                    </span>
                                    '.js_nowbutton ( $nowbutton_array, $admin_phrases[common][today] ).'
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    '.$admin_phrases[news][edit_cat_created_by].':<br>
                                    <span class="small">'.$admin_phrases[news][edit_cat_created_by_desc].'</span>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="30" maxlength="100" readonly="readonly" id="username" name="cat_username" value="'.$cat_arr['cat_username'].'">
                                    <input type="hidden" id="userid" name="cat_user" value="'.$cat_arr['cat_user'].'">
                                    <input class="button" type="button" onClick=\''.openpopup ( "admin_finduser.php", 400, 400 ).'\' value="'.$admin_phrases[common][change_button].'">
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                               <tr><td class="line" colspan="2">'.$admin_phrases[news][edit_cat_title_optional].'</td></tr>
                               <tr>
                                   <td class="config">
                                     '.$admin_phrases[news][edit_cat_image].': <span class="small">'.$admin_phrases[common][optional].'</span><br><br>
         ';
        if ( image_exists ( "images/cat/", "news_".$cat_arr['cat_id'] ) ) {
            echo '
                                    <img src="'.image_url ( "images/cat/", "news_".$cat_arr['cat_id'] ).'" alt="'.$cat_arr['cat_name'].'" border="0">
                                    <table>
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="cat_pic_delete" id="cpd" value="1" onClick=\'delalert ("cpd", "'.$admin_phrases[common][js_delete_image].'")\'>
                                            </td>
                                            <td>
                                                <span class="small"><b>'.$admin_phrases[common][delete_image].'</b></span>
                                            </td>
                                        </tr>
                                    </table>
            ';
        } else {
            echo '<span class="small">'.$admin_phrases[common][no_image].'</span><br>';
        }
        echo'                       <br>
                                </td>
                                <td class="config">
                                    <input name="cat_pic" type="file" size="40" class="text"><br>
        ';
        if ( image_exists ( "images/cat/", "news_".$cat_arr['cat_id'] ) ) {
            echo '<span class="small"><b>'.$admin_phrases[common][replace_img].'</b></span><br>';
        }
        echo'
                                    <span class="small">
                                        ['.$admin_phrases[common][max].' '.$news_config_arr[cat_pic_x].' '.$admin_phrases[common][resolution_x].' '.$news_config_arr[cat_pic_y].' '.$admin_phrases[common][pixel].'] ['.$admin_phrases[common][max].' '.$news_config_arr[cat_pic_size].' '.$admin_phrases[common][kib].']
                                    </span>
                                </td>
                            </tr>
                            <tr align="left" valign="top">
                                <td class="config">
                                    '.$admin_phrases[news][edit_cat_description].': <span class="small">'.$admin_phrases[common][optional].'</span><br>
                                    <span class="small">'.$admin_phrases[news][edit_cat_description_desc].'</span>
                                </td>
                                <td class="config">
                                    <textarea class="text" name="cat_description" rows="5" cols="50" wrap="virtual">'.$cat_arr['cat_description'].'</textarea>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="buttontd" colspan="2">
                                    <button class="button_new" type="submit">
                                        '.$admin_phrases[common][arrow].' '.$admin_phrases[common][save_long].'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form><!--ENDDEF-->
                    
<!--DEF::delete-->                    <form action="" method="post">
                        <input type="hidden" name="sended" value="delete">
                        <input type="hidden" name="cat_action" value="'.$_POST['cat_action'].'">
                        <input type="hidden" name="cat_id" value="'.$cat_arr['cat_id'].'">
                        <input type="hidden" name="go" value="news_cat">
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="2">'.$admin_phrases[news][delete_cat_title].'</td></tr>
                            <tr>
                                <td class="config" style="width: 100%;">
                                    '.$admin_phrases[news][delete_cat_question].': "'.$cat_arr['cat_name'].'"
                                </td>
                                <td class="config" style="text-align: right;">
                                    <table>
                                        <tr valign="bottom">
                                            <td>
                                                <input type="radio" name="cat_delete" id="del_yes" value="1" style="cursor:pointer;" onClick=\'createClick(this);\'>
                                            </td>
                                            <td class="config" style="vertical-align: middle; cursor:pointer;"
    onClick=\'
        createClick (document.getElementById("del_yes"));
        resetUnclicked ("transparent", last, lastBox, this);\'
                                            >
                                                '.$admin_phrases[common][yes].'
                                            </td>
                                            <td style="width: 20px;"></td>
                                            <td>
                                                <input type="radio" name="cat_delete" id="del_no" value="0" style="cursor:pointer;" onClick=\'createClick(this);\' checked="checked">
                                            </td>
                                            <td class="config" style="vertical-align: middle; cursor:pointer;"
    onClick=\'
        createClick (document.getElementById("del_no"));
        resetUnclicked ("transparent", last, lastBox, this);\'
>
                                                '.$admin_phrases[common][no].'
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[news][delete_cat_move_to].':
                                </td>
                                <td style="text-align: right;">
                                    <select class="text" name="cat_move_to" size="1">
            ';

            $index = mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."news_cat WHERE cat_id != '".$cat_arr['cat_id']."' ORDER BY cat_name", $db );
            while ( $move_arr = mysql_fetch_assoc ( $index ) ) {
                echo '<option value="'.$move_arr['cat_id'].'">'.killhtml ( $move_arr['cat_name'] ).'</option>';
            }
            echo'
                                    </select>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="buttontd" colspan="2">
                                    <button class="button_new" type="submit">
                                        '.$admin_phrases[common][arrow].' '.$admin_phrases[common][do_button_long].'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form><!--ENDDEF-->