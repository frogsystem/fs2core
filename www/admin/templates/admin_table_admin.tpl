<!--section-start::main-->
<form method="post" action="">
<table class="content small" cellpadding="1" cellspacing="1" id="table_list">
    <tr><td colspan="7"><h3><!--LANG::pageinfo_title--></h3><hr></td></tr>
    <tr>
        <td colspan="7" align="center">
          <!--TEXT::op_results-->
        </td>
    </tr>   
    <tr>
        <td></td>
        <td><b><!--LANG::table_name--></b></td>
        <td><b><!--LANG::table_rows--></b></td>
        <td><b><!--LANG::table_length--></b></td>
        <td><b><!--LANG::table_data--></b></td>
        <td><b><!--LANG::table_index--></b></td>
        <td><b><!--LANG::table_free--></b></td>
    </tr>
    <!--TEXT::table_list-->
    <tr>
        <td colspan="7">
            <small><!--TEXT::InnoDB--></small>
        </td>
    </tr>
    <tr>
        <td class="space"></td>
    </tr>
    <tr>
        <td class="right" colspan="7">
        <!--LANG::selected_tables-->
        <select name="op" class="select_type">
            <option value="check"><!--LANG::op_check--></option>
            <option value="analyze"><!--LANG::op_analyze--></option>
            <option value="repair"><!--LANG::op_repair--></option>
            <option value="optimize"><!--LANG::op_optimize--></option>
        </select>
        </td>
    </tr>
    <tr>
      <td class="space" colspan="7"></td>
    </tr>
    <tr>
        <td class="buttontd" colspan="7">
            <button class="button_new" type="submit">
                <img class="middle" alt="->" src="img/pointer.png">
                Aktion ausf&uuml;hren
            </button>
         </td>
    </tr>
</table>
</form>
<!--section-end::main-->

<!--section-start::table_entry-->
    <tr>
        <td class="center"><input type="checkbox" id="table_id_<!--TEXT::table_name_esc-->" value="<!--TEXT::table_name_esc-->" name="selected_tables[]"></td>
        <td><label for="table_id_<!--TEXT::table_name_esc-->"><b><!--TEXT::table_name--></b></label></td>
        <td style="margin: 0.1em; padding: 0.3em; text-align: center;"><!--TEXT::table_rows--></td>
        <td><!--TEXT::table_length--></td>
        <td><!--TEXT::table_data--></td>
        <td><!--TEXT::table_index--></td>
        <td><!--IF::has_free--><span style="color: #cc0000"><!--ENDIF--><!--TEXT::table_free--><!--IF::has_free--></span><!--ENDIF--></td>
    </tr>
<!--section-end::table_entry-->

<!--section-start::op_table-->
  <table>
    <tr>
      <td><b><!--LANG::table_name--></b></td>
      <td><b><!--LANG::operation--></b></td>
      <td><b><!--LANG::type--></b></td>
      <td><b><!--LANG::message--></b></td>
    </tr>
    <!--TEXT::op_entries-->
    <tr>
      <td class="space" colspan="4"></td>
    </tr>
  </table>
<!--section-end::op_table-->

<!--section-start::op_entry-->
    <tr>
        <td><b><!--TEXT::table_name--></b></td>
        <td><!--TEXT::op--></td>
        <td><!--TEXT::type--></td>
        <td><!--TEXT::msg--></td>
    </tr>
<!--section-end::op_entry-->

<!--section-start::summary-->
    <tr>
        <td></td>
        <td colspan="6"><span class="small">(<span class="link" onclick="groupselect('#table_list', true)"><!--COMMON::selection_all--></span>/<span class="link" onclick="groupselect('#table_list', false)"><!--COMMON::selection_none--></span>/<span class="link" onclick="groupselect('#table_list', 'invert')"><!--COMMON::selection_invert--></span>)</span></td>
    </tr>
    <tr>
        <td colspan="2"><b>Total: <!--TEXT::tabs--> <!--LANG::tables--></b></td>
        <td><b><!--TEXT::rows--> <!--LANG::rows--></b></td>
        <td colspan="3" align="center"><b><!--TEXT::size--> <!--LANG::bytes--></b></td>
        <td><b><!--TEXT::free--> <!--LANG::bytes--> <!--LANG::table_free--></b></td>
    </tr>
<!--section-end::summary-->
