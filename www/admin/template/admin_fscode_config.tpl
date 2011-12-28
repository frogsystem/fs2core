<!--DEF::main-->                    <form action="" method="post">
                      <input name="go" value="fscode_settings" type="hidden">
                      <table class="configtable" cellpadding="4" cellspacing="0">
                        <tbody>
                          <tr>
                            <td class="line" colspan="2"><!--LANG::pagetitle--></td>
                          </tr>
                          <tr>
                            <td class="config right_space">
                                <!--LANG::file_max_size-->:<br>
                                <span class="small"><!--LANG::file_max_size_info--></span>
                            </td>
                            <td class="config" style="width: 50%;">
                                <input class="text" name="file_max_size" maxlength="3" value="<!--TEXT::file_max_size-->" style="width: 30px;"> Byte
                            </td>
                          </tr>
                          <tr>
                            <td class="config">
                                <!--LANG::file_max_width-->:<br>
                                <span class="small"><!--LANG::file_max_width_info--></span>
                            </td>
                            <td class="config" style="width: 50%;">
                                <input class="text" name="file_max_width" maxlength="3" value="<!--TEXT::file_max_width-->" style="width: 30px;"> px
                            </td>
                          </tr>
                          <tr>
                            <td class="config right_space">
                                <!--LANG::file_max_height-->:<br>
                                <span class="small"><!--LANG::file_max_height_info--></span>
                            </td>
                            <td class="config" style="width: 50%;">
                                <input class="text" name="file_max_height" maxlength="3" value="<!--TEXT::file_max_height-->" style="width: 30px;"> px
                            </td>
                          </tr>
                          <tr>
                            <td class="space" colspan="2"></td>
                          </tr>
                          <tr>
                            <td class="config right_space">
                                <!--LANG::image-->:<br>
                                <span class="small"><!--LANG::image_info--></span>
                            </td>
                            <td class="config" style="width: 50%;">
                              <select name="image">
                                <option value="0"<!--IF::image?0--> selected<!--ENDIF-->><!--LANG::image_1--></option>
                                <option value="1"<!--IF::image?1--> selected<!--ENDIF-->><!--LANG::image_2--></option>
                              </select>
                            </td>
                          </tr>
                          <tr><td class="space"></td></tr>
                          <tr>
                            <td colspan="2" class="buttontd">
                              <button class="button_new" type="submit" name="save">
                                <!--TEXT::submitarrow-->
                                <!--TEXT::submittext-->
                              </button>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </form><!--ENDDEF-->