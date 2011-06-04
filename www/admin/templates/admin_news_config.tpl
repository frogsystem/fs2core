<!--section-start::main-->
<form action="" method="post">
    <input type="hidden" name="go" value="news_config">
    <input type="hidden" name="sended" value="1">
    
    <table class="content config" cellpadding="0" cellspacing="0">
        <tr><td colspan="2"><h3><!--LANG::settings_title--></h3><hr></td></tr>

        <tr>
            <td>
                <!--LANG::news_per_page-->:<br>
                <span class="small"><!--LANG::news_per_page_desc--></span>
            </td>
            <td>
                <input class="center" size="2" name="num_news" maxlength="2" value="<!--TEXT::num_news-->"><br>
                <span class="small">(<!--COMMON::zero_not_allowed-->)</span>
            </td>
        </tr>
        
        <tr>
            <td>
                <!--LANG::num_headlines-->:<br>
                <span class="small"><!--LANG::num_headlines_desc--></span>
            </td>
            <td>
                <input class="center" size="2" name="num_head" maxlength="2" value="<!--TEXT::num_head-->"><br>
                <span class="small">(<!--COMMON::zero_not_allowed-->)</span>
            </td>
        </tr>
        
        <tr>
            <td>
                <!--LANG::headline_lenght-->:<br>
                <span class="small"><!--LANG::headline_lenght_desc--></span>
            </td>
            <td>
                <input class="center" size="3" name="news_headline_lenght" maxlength="3" value="<!--TEXT::news_headline_lenght-->"> <!--COMMON::chars--><br>
                <span class="small">(<!--LANG::headline_lenght_info-->)</span>
            </td>
        </tr>

        <tr>
            <td>
                <!--LANG::headline_extension-->: <span class="small">(<!--COMMON::optional-->)</span><br>
                <span class="small"><!--LANG::headline_extension_desc--></span>
            </td>
            <td>
                <input class="half" size="20" name="news_headline_ext" maxlength="30" value="<!--TEXT::news_headline_ext-->">
            </td>
        </tr>
        
        
        <tr><td colspan="2"><h3><!--LANG::post_settings_title--></h3><hr></td></tr>
                            
        <tr>
            <td>
                <!--LANG::allow_html-->:<br>
                <span class="small"><!--LANG::allow_html_desc--></span>
            </td>
            <td>
                <select name="html_code">
                    <option value="1" <!--IF::html_code_1-->selected<!--ENDIF-->><!--LANG::allow_code_no--></option>
                    <option value="2" <!--IF::html_code_2-->selected<!--ENDIF-->><!--LANG::allow_code_news--></option>
                    <option value="3" <!--IF::html_code_3-->selected<!--ENDIF-->><!--LANG::allow_code_comments--></option>
                    <option value="4" <!--IF::html_code_4-->selected<!--ENDIF-->><!--LANG::allow_code_both--></option>
                </select>
            </td>
        </tr>
                            
        <tr>
            <td>
                <!--LANG::allow_fs-->:<br>
                <span class="small"><!--LANG::allow_fs_desc--></span>
            </td>
            <td>
                <select name="fs_code">
                    <option value="1" <!--IF::fs_code_1-->selected<!--ENDIF-->><!--LANG::allow_code_no--></option>
                    <option value="2" <!--IF::fs_code_2-->selected<!--ENDIF-->><!--LANG::allow_code_news--></option>
                    <option value="3" <!--IF::fs_code_3-->selected<!--ENDIF-->><!--LANG::allow_code_comments--></option>
                    <option value="4" <!--IF::fs_code_4-->selected<!--ENDIF-->><!--LANG::allow_code_both--></option>
                </select>
            </td>
        </tr>
                            
        <tr>
            <td>
                <!--LANG::allow_para-->:<br>
                <span class="small"><!--LANG::allow_para_desc--></span>
            </td>
            <td>
                <select name="para_handling">
                    <option value="1" <!--IF::para_handling_1-->selected<!--ENDIF-->><!--LANG::allow_code_no--></option>
                    <option value="2" <!--IF::para_handling_2-->selected<!--ENDIF-->><!--LANG::allow_code_news--></option>
                    <option value="3" <!--IF::para_handling_3-->selected<!--ENDIF-->><!--LANG::allow_code_comments--></option>
                    <option value="4" <!--IF::para_handling_4-->selected<!--ENDIF-->><!--LANG::allow_code_both--></option>
                </select>
            </td>
        </tr>

        
        <tr><td colspan="2"><h3><!--LANG::cat_settings_title--></h3><hr></td></tr>
                            
        <tr>
            <td>
                <!--LANG::cat_img_max_width-->:<br>
                <span class="small"><!--LANG::cat_img_max_width_desc--></span>
            </td>
            <td>
                <input class="center" size="3" name="cat_pic_x" maxlength="3" value="<!--TEXT::cat_pic_x-->"> <!--COMMON::pixel--><br>
                <span class="small">(<!--COMMON::zero_not_allowed-->)</span>
            </td>
        </tr>
        
        <tr>
            <td>
                <!--LANG::cat_img_max_height-->:<br>
                <span class="small"><!--LANG::cat_img_max_height_desc--></span>
            </td>
            <td>
                <input class="center" size="3" name="cat_pic_y" maxlength="3" value="<!--TEXT::cat_pic_y-->"> <!--COMMON::pixel--><br>
                <span class="small">(<!--COMMON::zero_not_allowed-->)</span>
            </td>
        </tr>
        
        <tr>
            <td>
                <!--LANG::cat_img_max_size-->:<br>
                <span class="small"><!--LANG::cat_img_max_size_desc--></span>
            </td>
            <td>
                <input class="text center" size="4" name="cat_pic_size" maxlength="4" value="<!--TEXT::cat_pic_size-->"> <!--COMMON::kib--><br>
                <span class="small">(<!--COMMON::zero_not_allowed-->)</span>
            </td>
        </tr>
                            
                            
        <tr><td colspan="2"><h3><!--LANG::comment_settings_title--></h3><hr></td></tr>
                        
        <tr>
            <td>
                <!--LANG::allow_comments-->:<br>
                <span class="small"><!--LANG::allow_comments_desc--></span>
            </td>
            <td>
                <select name="com_rights">
                    <option value="2" <!--IF::com_rights_2-->selected<!--ENDIF-->><!--LANG::allow_comments_all--></option>
                    <option value="1" <!--IF::com_rights_1-->selected<!--ENDIF-->><!--LANG::allow_comments_reg--></option>
                    <option value="3" <!--IF::com_rights_3-->selected<!--ENDIF-->><!--LANG::allow_comments_staff--></option>
                    <option value="4" <!--IF::com_rights_4-->selected<!--ENDIF-->><!--LANG::allow_comments_admins--></option>
                    <option value="0" <!--IF::com_rights_0-->selected<!--ENDIF-->><!--LANG::allow_comments_nobody--></option>
                </select>
            </td>
        </tr>
        
        <tr>
            <td>
                <!--LANG::sort_comments-->:<br>
                <span class="small"><!--LANG::sort_comments_desc--></span>
            </td>
            <td>
                <select name="com_sort">
                    <option value="ASC" <!--IF::com_sort_asc-->selected<!--ENDIF-->><!--LANG::sort_comments_old_first--></option>
                    <option value="DESC" <!--IF::com_sort_desc-->selected<!--ENDIF-->><!--LANG::sort_comments_new_first--></option>
                </select>
            </td>
        </tr>
        
        <tr>
            <td>
                <!--LANG::anti_spam_comments-->:<br>
                <span class="small"><!--LANG::anti_spam_comments_desc--></span>
            </td>
            <td>
                <select name="com_antispam">
                    <option value="2" <!--IF::com_antispam_2-->selected<!--ENDIF-->><!--LANG::anti_spam_comments_all--></option>
                    <option value="4" <!--IF::com_antispam_4-->selected<!--ENDIF-->><!--LANG::anti_spam_comments_admins--></option>
                    <option value="3" <!--IF::com_antispam_3-->selected<!--ENDIF-->><!--LANG::anti_spam_comments_staff--></option>
                    <option value="1" <!--IF::com_antispam_1-->selected<!--ENDIF-->><!--LANG::anti_spam_comments_reg--></option>
                    <option value="0" <!--IF::com_antispam_0-->selected<!--ENDIF-->><!--LANG::anti_spam_comments_nobody--></option>
                </select>
            </td>
        </tr>
        
        
        <tr><td colspan="2"><h3><!--LANG::admincp_settings_title--></h3><hr></td></tr>
        
        <tr>
            <td>
                <!--LANG::entry_view-->:<br>
                <span class="small"><!--LANG::entry_view_desc--></span>
            </td>
            <td>
                <select name="acp_view">
                    <option value="0" <!--IF::acp_view_0-->selected<!--ENDIF-->><!--LANG::entry_view_simple--></option>
                    <option value="2" <!--IF::acp_view_2-->selected<!--ENDIF-->><!--LANG::entry_view_extended--></option>
                    <option value="1" <!--IF::acp_view_1-->selected<!--ENDIF-->><!--LANG::entry_view_full-->t</option>
                </select>
            </td>
        </tr>
        
        <tr>
            <td>
                <!--LANG::entries_per_page-->:<br>
                <span class="small"><!--LANG::entries_per_page_desc--></span>
            </td>
            <td>
                <input class="center" size="3" name="acp_per_page" maxlength="3" value="<!--TEXT::acp_per_page-->"> <!--COMMON::entries--><br>
                <span class="small">(<!--COMMON::zero_not_allowed-->)</span>
            </td>
        </tr>
        
        <tr>
            <td>
                <!--LANG::force_cat_selection-->:<br>
                <span class="small"><!--LANG::force_cat_selection_desc--></span>
            </td>
            <td>
                <!--COMMON::checkbox-->
                <input class="hidden" type="checkbox" name="acp_force_cat_selection" value="1" <!--IF::force_cat_selection-->checked<!--ENDIF-->>
            </td>
        </tr>        
                            
        <tr>
            <td colspan="2">
                <button class="button" type="submit">
                    <!--COMMON::button_arrow--> <!--COMMON::save_changes_button-->                    
                </button>
            </td>
        </tr>
    </table>
</form>                           
<!--section-end::main-->
