<!--DEF::main-->          <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="go" value="fscode_groups">
            <table border="0" cellpadding="4" cellspacing="0" width="600">
              <tbody>
                <tr>
                  <td class="line" colspan="2">
                    <!--LANG::add_head-->
                  </td>
                </tr>
                <tr>
                  <td colspan="2" class="space"></td>
                </tr>
                <tr>
                  <td class="config" valign="top" style="width: 100%;">
                    <!--LANG::add_name-->:
                  </td>
                  <td class="config" valign="top">
                    <input type="text" name="name" class="text input_width" value="<!--TEXT::name-->">
                  </td>
                </tr>
                <tr><td class="space"></td></tr>
                <tr>
                  <td colspan="2" class="buttontd">
                    <button class="button_new" type="submit" name="addgroup">
                      <!--LANG::submitarrow-->
                      <!--LANG::add_submittext-->
                    </button>
                  </td>
                </tr>
                <tr><td class="space"></td></tr>
                <tr>
                  <td class="line" colspan="2">
                    <!--LANG::edit_head-->
                  </td>
                </tr>
                <tr>
                  <td class="config" valign="top">
                    <!--LANG::edit_name-->:
                  </td>
                  <td class="config" valign="top">
                    <!--LANG::edit_action-->:
                  </td>
                </tr>
                <!--TEXT::edit_rows-->
              </tbody>
            </table>
          </form><!--ENDDEF-->
<!--DEF::edit_rows--><tr>
                  <td class="config" valign="top">
                    <!--TEXT::name-->
                  </td>
                  <td class="config" valign="top">
                    [<a href="?go=fscode_groups&amp;group=<!--TEXT::id-->&amp;action=edit"><!--LANG::row_edit--></a>]<!--IF::delete?1--><br>
                    [<a href="?go=fscode_groups&amp;group=<!--TEXT::id-->&amp;action=delete"><!--LANG::row_delete--></a>]<!--ENDIF-->
                  </td>
                </tr><!--ENDDEF-->
<!--DEF::nogroups-->                <tr>
                  <td class="config" colspan="2" style="text-align: center;">
                    <!--LANG::edit_nogroups-->
                  </td>
                </tr><!--ENDDEF-->
<!--DEF::confirm_deletion-->          <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="go" value="fscode_groups">
            <table border="0" cellpadding="4" cellspacing="0" width="600">
              <tbody>
                <tr>
                  <td class="line" colspan="2">
                    <!--LANG::delete_head-->
                  </td>
                </tr>
                <tr>
                  <td colspan="2" class="space"></td>
                </tr>
                <tr>
                  <td class="config" valign="top" rowspan="2">
                    <!--LANG::delete_text-->
                  </td>
                  <td class="config" valign="top" id="td_yes">
                    <input type="radio" name="delete" value="1" id="in_yes">
                    <!--LANG::yes-->
                  </td>
                </tr>
                <tr>
                  <td class="config" valign="top" id="td_no">
                    <input type="radio" name="delete" value="0" checked id="in_no">
                    <!--LANG::no-->
                  </td>
                </tr>
                <tr><td class="space"></td></tr>
                <tr>
                  <td colspan="2" class="buttontd">
                    <button class="button_new" type="submit" name="deletegroup">
                      <!--LANG::submitarrow-->
                      <!--LANG::delete_submit-->
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </form>
          <script type="text/javascript">
            <!--
              yesNoColors("td_yes", "td_no", "in_yes", "in_no");
            //-->
          </script><!--ENDDEF-->
<!--DEF::editpage-->          <form action="" method="post">
            <input type="hidden" name="go" value="fscode_groups">
            <table border="0" cellpadding="4" cellspacing="0" width="600">
              <tbody>
                <tr>
                  <td class="line" colspan="2">
                    <!--LANG::edit_head-->
                  </td>
                </tr>
                <tr>
                  <td colspan="2" class="space"></td>
                </tr>
                <tr>
                  <td class="config" valign="top" style="width: 100%;">
                    <!--LANG::add_name-->:
                  </td>
                  <td class="config" valign="top">
                    <input type="text" name="name" class="text input_width" value="<!--TEXT::name-->">
                  </td>
                </tr>
                <tr><td class="space"></td></tr>
                <tr>
                  <td colspan="2" class="buttontd">
                    <button class="button_new" type="submit" name="editgroup">
                      <!--COMMON::button_arrow-->
                      <!--COMMON::save_changes_button-->
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </form><!--ENDDEF-->
<!--DEF::sqlerror--><!--IF::add?1--><!--LANG::added_error--><!--ELSE--><!--IF::edit?1--><!--LANG::edited_error--><!--ELSE--><!--LANG::deleted_error--><!--ENDIF--><!--ENDIF--><!--ENDDEF-->