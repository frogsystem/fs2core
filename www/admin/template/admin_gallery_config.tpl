<!--DEF::main-->                    <form action="" method="post">
                        <input type="hidden" name="go" value="<!--TEXT::ACP_GO-->">

                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr>
                                <td colspan="2" class="line">
                                    <!--LANG::viewer_title-->
                                </td>
                            </tr>
                            <tr>
                                <td class="config right_space">
                                    <!--LANG::viewer_type--><br>
                                    <span class="small"><!--LANG::viewer_type_info--></span>
                                </td>
                                <td class="config">
                                    <select name="viewer_type">
                                        <option value="0"<!--IF::viewer_type?0--> selected<!--ENDIF-->><!--LANG::viewer_type_link--></option>
                                        <option value="1"<!--IF::viewer_type?1--> selected<!--ENDIF-->><!--LANG::viewer_type_popup--></option>
                                        <option value="2"<!--IF::viewer_type?2--> selected<!--ENDIF-->><!--LANG::viewer_type_lightbox--></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    <!--LANG::viewer_size--><br>
                                    <span class="small"><!--LANG::viewer_size_info--></span>
                                </td>
                                <td class="config">
                                    <input class="text" size="5" name="viewer_x" value="<!--TEXT::viewer_x-->" maxlength="4">
                                    <!--COMMON::resolution_x-->
                                    <input class="text" size="5" name="viewer_y" value="<!--TEXT::viewer_y-->" maxlength="4"> <!--COMMON::pixel-->
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    <!--LANG::viewer_img_size--><br>
                                    <span class="small"><!--LANG::viewer_img_size_info--></span>
                                </td>
                                <td class="config">
                                    <input class="text" size="5" name="viewer_img_x" value="<!--TEXT::viewer_img_x-->" maxlength="4">
                                    <!--COMMON::resolution_x-->
                                    <input class="text" size="5" name="viewer_img_y" value="<!--TEXT::viewer_img_y-->" maxlength="4"> <!--COMMON::pixel-->
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            
                            
                            <tr><td colspan="2" class="line"><!--LANG::img_title--></td></tr>
                            <tr>
                                <td class="config">
                                    <!--LANG::img_res--><br>
                                    <span class="small"><!--LANG::img_res_info--></span>
                                </td>
                                <td class="config">
                                    <input class="text" size="5" name="img_max_x" value="<!--TEXT::img_max_x-->" maxlength="4">
                                    <!--COMMON::resolution_x-->
                                    <input class="text" size="5" name="img_max_y" value="<!--TEXT::img_max_y-->" maxlength="4"> <!--COMMON::pixel-->
                                    <span class="small">(<!--COMMON::zero_not_allowed-->)</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    <!--LANG::img_size--><br>
                                    <span class="small"><!--LANG::img_size_info--></span>
                                </td>
                                <td class="config">
                                    <input class="text" size="12" name="img_max_size" value="<!--TEXT::img_max_size-->" maxlength="7"> <!--COMMON::kib-->
                                    <span class="small">(<!--COMMON::zero_not_allowed-->)</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    <!--LANG::img_mid_res--><br>
                                    <span class="small"><!--LANG::img_mid_res_info--></span>
                                </td>
                                <td class="config">
                                    <input class="text" size="5" name="img_mid_x" value="<!--TEXT::img_mid_x-->" maxlength="3">
                                    <!--COMMON::resolution_x-->
                                    <input class="text" size="5" name="img_mid_y" value="<!--TEXT::img_mid_y-->" maxlength="3"> <!--COMMON::pixel-->
                                    <span class="small">(<!--COMMON::zero_not_allowed-->)</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    <!--LANG::img_small_res--><br>
                                    <span class="small"><!--LANG::img_small_res_info--></span>
                                </td>
                                <td class="config">
                                    <input class="text" size="5" name="img_small_x" value="<!--TEXT::img_small_x-->" maxlength="3">
                                    <!--COMMON::resolution_x-->
                                    <input class="text" size="5" name="img_small_y" value="<!--TEXT::img_small_y-->" maxlength="3"> <!--COMMON::pixel-->
                                    <span class="small">(<!--COMMON::zero_not_allowed-->)</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    <!--LANG::img_number--><br>
                                    <span class="small"><!--LANG::img_number_info--></span>
                                </td>
                                <td class="config">
                                    <input class="text" size="1" name="img_rows" value="<!--TEXT::img_rows-->" maxlength="2"> <!--COMMON::rows_at-->
                                    <input class="text" size="1" name="img_cols" value="<!--TEXT::img_cols-->" maxlength="2"> <!--LANG::images--><br>
                                    <span class="small">(<!--COMMON::zero_not_allowed-->)</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    <!--LANG::img_order--><br>
                                    <span class="small"><!--LANG::img_order_info--></span>
                                </td>
                                <td class="config">
                                    <select name="img_order">
                                        <option value="date"<!--IF::img_order?date--> selected<!--ENDIF-->><!--LANG::img_order_date--></option>
                                        <option value="id"<!--IF::img_order?id--> selected<!--ENDIF-->><!--LANG::img_order_id--></option>
                                        <option value="title"<!--IF::img_order?title--> selected<!--ENDIF-->><!--LANG::img_order_title--></option>
                                    </select><br><br>
                                    <select name="img_sort">
                                        <option value="ASC"<!--IF::img_sort?ASC--> selected<!--ENDIF-->><!--COMMON::asc--></option>
                                        <option value="DESC"<!--IF::img_sort?DESC--> selected<!--ENDIF-->><!--COMMON::desc--></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    <!--LANG::img_group--><br>
                                    <span class="small"><!--LANG::img_group_info--></span>
                                </td>
                                <td class="config">
                                    <select name="img_group">
                                        <option value="0"<!--IF::img_group?0--> selected<!--ENDIF-->><!--LANG::img_group_none--></option>
                                        <option value="date"<!--IF::img_group?date--> selected<!--ENDIF-->><!--LANG::img_group_date--></option>
                                        <option value="id"<!--IF::img_group?id--> selected<!--ENDIF-->><!--LANG::img_group_id--></option>
                                        <option value="title"<!--IF::img_group?title--> selected<!--ENDIF-->><!--LANG::img_group_title--></option>
                                    </select>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>


                            <tr><td colspan="2" class="line"><!--LANG::wp_title--></td></tr>
                            <tr>
                                <td class="config">
                                    <!--LANG::wp_res--><br>
                                    <span class="small"><!--LANG::wp_res_info--></span>
                                </td>
                                <td class="config">
                                    <input class="text" size="5" name="wp_max_x" value="<!--TEXT::wp_max_x-->" maxlength="4">
                                    <!--COMMON::resolution_x-->
                                    <input class="text" size="5" name="wp_max_y" value="<!--TEXT::wp_max_y-->" maxlength="4"> <!--COMMON::pixel-->
                                    <span class="small">(<!--COMMON::zero_not_allowed-->)</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    <!--LANG::wp_small_res--><br>
                                    <span class="small"><!--LANG::wp_small_res_info--></span>
                                </td>
                                <td class="config">
                                    <input class="text" size="5" name="wp_small_max_x" value="<!--TEXT::wp_small_max_x-->" maxlength="3">
                                    <!--COMMON::resolution_x-->
                                    <input class="text" size="5" name="wp_small_max_y" value="<!--TEXT::wp_small_max_y-->" maxlength="3"> <!--COMMON::pixel-->
                                    <span class="small">(<!--COMMON::zero_not_allowed-->)</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    <!--LANG::wp_size--><br>
                                    <span class="small"><!--LANG::wp_size_info--></span>
                                </td>
                                <td class="config">
                                    <input class="text" size="12" name="wp_max_size" value="<!--TEXT::wp_max_size-->" maxlength="7"> <!--COMMON::kib-->
                                    <span class="small">(<!--COMMON::zero_not_allowed-->)</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    <!--LANG::wp_number--><br>
                                    <span class="small"><!--LANG::wp_number_info--></span>
                                </td>
                                <td class="config">
                                    <input class="text" size="1" name="wp_rows" value="<!--TEXT::wp_rows-->" maxlength="2"> <!--COMMON::rows_at-->
                                    <input class="text" size="1" name="wp_cols" value="<!--TEXT::wp_cols-->" maxlength="2"> <!--LANG::wallpapers--><br>
                                    <span class="small">(<!--COMMON::zero_not_allowed-->)</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    <!--LANG::wp_order--><br>
                                    <span class="small"><!--LANG::wp_order_info--></span>
                                </td>
                                <td class="config"
                                    <select name="wp_order">
                                        <option value="date"<!--IF::wp_order?date--> selected<!--ENDIF-->><!--LANG::wp_order_date--></option>
                                        <option value="id"<!--IF::wp_order?id--> selected<!--ENDIF-->><!--LANG::wp_order_id--></option>
                                        <option value="title"<!--IF::wp_order?title--> selected<!--ENDIF-->><!--LANG::wp_order_title--></option>
                                    </select><br><br>
                                    <select name="wp_sort">
                                        <option value="ASC"<!--IF::wp_sort?ASC--> selected<!--ENDIF-->><!--COMMON::asc--></option>
                                        <option value="DESC"<!--IF::wp_sort?DESC--> selected<!--ENDIF-->><!--COMMON::desc--></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    <!--LANG::wp_group--><br>
                                    <span class="small"><!--LANG::wp_group_info--></span>
                                </td>
                                <td class="config">
                                    <select name="wp_group">
                                        <option value="0"<!--IF::wp_group?0--> selected<!--ENDIF-->><!--LANG::wp_group_none--></option>
                                        <option value="date"<!--IF::wp_group?date--> selected<!--ENDIF-->><!--LANG::wp_group_date--></option>
                                        <option value="id"<!--IF::wp_group?id--> selected<!--ENDIF-->><!--LANG::wp_group_id--></option>
                                        <option value="title"<!--IF::wp_group?title--> selected<!--ENDIF-->><!--LANG::wp_group_title--></option>
                                    </select>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>

                            <tr><td colspan="2" class="line"><!--LANG::cat_title--></td></tr>
                            <tr>
                                <td class="config">
                                    <!--LANG::cat_res--><br>
                                    <span class="small"><!--LANG::cat_res_info--></span>
                                </td>
                                <td class="config">
                                    <input class="text" size="5" name="cat_img_x" value="<!--TEXT::cat_img_x-->" maxlength="4">
                                    <!--COMMON::resolution_x-->
                                    <input class="text" size="5" name="cat_img_y" value="<!--TEXT::cat_img_y-->" maxlength="4"> <!--COMMON::pixel-->
                                    <span class="small">(<!--COMMON::zero_not_allowed-->)</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    <!--LANG::cat_size--><br>
                                    <span class="small"><!--LANG::cat_size_info--></span>
                                </td>
                                <td class="config">
                                    <input class="text" size="12" name="cat_img_size" value="<!--TEXT::cat_img_size-->" maxlength="7"> <!--COMMON::kib-->
                                    <span class="small">(<!--COMMON::zero_not_allowed-->)</span>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            
                            <tr>
                                <td colspan="2" class="buttontd">
                                    <button type="submit" name="sended" value="1" class="button_new">
                                        <!--COMMON::button_arrow-->
                                        <!--COMMON::save_changes_button-->
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form><!--ENDDEF-->
