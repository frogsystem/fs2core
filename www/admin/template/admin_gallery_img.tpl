<!--DEF::add-->                    <form action="" enctype="multipart/form-data" method="post">
                        <input type="hidden" name="go" value="<!--TEXT::ACP_GO-->">
                        <input type="hidden" name="img_action" value="add">
                        <input type="hidden" name="num_of_lines" value="3">
                        <input name="MAX_FILE_SIZE" value="<!--TEXT::MAX_FILE_SIZE-->" type="hidden">
                         
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr>
                                <td class="line" colspan="3">
                                    <!--LANG::add_title-->
                                </td>
                            </tr>
                            <tr>
                                <td class="config " colspan="3">
                                    <!--LANG::note_php_upload_limit-->
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            
                            <tr>
                                <td class="config " colspan="2">
                                    <!--LANG::add_select_images-->:
                                    <span class="small">
                                         [<!--COMMON::max-->
                                         <!--TEXT::config_max_x-->
                                         <!--COMMON::resolution_x-->
                                         <!--TEXT::config_max_y-->
                                         <!--COMMON::pixel-->]
                                         [<!--COMMON::max-->
                                         <!--TEXT::config_max_size-->
                                         <!--COMMON::kib-->]
                                    </span>
                                </td>
                                <td class="config">
                                    <!--LANG::add_img_title-->:
                                    <span class="small">(<!--COMMON::optional-->)</span>
                                </td>
                            </tr>
                            <!--TEXT::lines-->
                            <tr id="after_add_lines"><td class="space"></td></tr>
                            
                            <tr>
                                <td class="config">
                                    <!--COMMON::cat-->:
                                </td>
                                <td class="config right right_space">
                                    <select class="input_width" name="cat_id">
                                        <option value="0"><!--LANG::unsorted--></option>
                                        <option value="-1"><!--COMMON::select_hr--></option>
                                        <!--TEXT::cat_options-->
                                    </select>
                                </td>
                                <td class="config right">
                                    <!--LANG::more_uploads-->:
                                    <select class="center" name="new_lines">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3" selected>3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                    </select>
                                    <button type="button" class="button" name="sended" value="add_lines" title="<!--LANG::more_uploads_title-->"<!--TEXT::more_uploads_js-->>
                                        <!--LANG::more_uploads_button-->
                                    </button>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            
                            <tr>
                                <td class="buttontd" colspan="3">
                                    <button type="submit" name="sended" value="add" class="button_new">
                                        <!--COMMON::button_arrow-->
                                        <!--LANG::upload_images-->
                                    </button>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                        </table>
                    </form><!--ENDDEF-->
                    
                    
<!--DEF::add_line-->                            <tr>
                                <td class="config" colspan="2">
                                   <input type="file" class="text" name="img_file[<!--TEXT::line_number-->]" size="45">
                                </td>
                                <td class="config">
                                    <input type="text" class="text full_width" name= "img_title[<!--TEXT::line_number-->]" size="30" maxlength="100">
                                </td>
                            </tr><!--ENDDEF-->
