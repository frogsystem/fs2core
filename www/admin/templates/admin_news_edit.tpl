<!--section-start::main-->
<form action="" method="post">
    <input type="hidden" name="go" value="news_edit">
    <input type="hidden" name="news_action" value="edit">
    <input type="hidden" name="news_id[0]" value="<!--TEXT::news_id-->">
    <input type="hidden" name="sended" value="edit">
    <!--section-import::admin_news::form_table-->
</form>    
<!--section-end::main-->

<!--section-start::link_list-->
<!--section-import::admin_news::link_list-->
<!--section-end::link_list-->

<!--section-start::link_entry-->
<!--section-import::admin_news::link_entry-->
<!--section-end::link_entry-->

<!--section-start::link_add-->
<!--section-import::admin_news::link_add-->
<!--section-end::link_add-->


<!--section-start::link_edit-->
<!--section-import::admin_news::link_edit-->
<!--section-end::link_edit-->

<!--section-start::edit_table-->
<!--section-import::admin_news::edit_table--> 
<!--section-end::edit_table-->

<!--section-start::script-->
<!--section-import::admin_news::script--> 
<!--section-end::script-->

<!--section-start::list-->
<form action="" method="post">
    <input type="hidden" name="go" value="news_edit">
    <input type="hidden" name="order" value="<!--TEXT::order-->" >
    <input type="hidden" name="sort" value="<!--TEXT::sort-->">
    <input type="hidden" name="cat_filter" value="<!--TEXT::cat_filter-->">
    
    <table class="content select_list" cellpadding="0" cellspacing="0">
        <tr>
            <td colspan="5">
                <span class="small atright">(<!--TEXT::total_entries--> <!--IF::total_entries--><!--COMMON::records_found--><!--ELSE--><!--COMMON::record_found--><!--ENDIF-->)</span>            
                <h3><!--LANG::select_news--></h3>
                <hr>
            </td>
        </tr>

<!--TEXT::entries-->

        <!--IF::entries-->
        <tr>
            <td colspan="4">default_display_pagenav(default_get_pagenav_data())</td>
        </tr>
        <tr>
            <td class="right" colspan="4">
                <select class="select_type" name="news_action" size="1">
                    <option class="select_one" value="edit" <!--IF::action_edit-->selected<!--ENDIF-->><!--COMMON::selection_edit--></option>
                    <!--IF::perm_delete-->
                    <option class="select_red" value="delete" <!--IF::action_delete-->selected<!--ENDIF-->><!--COMMON::selection_delete--></option>
                    <!--ENDIF-->
                    <!--IF::perm_comments-->
                    <option class="select_one" value="comments" <!--IF::action_comments-->selected<!--ENDIF-->><!--LANG::selection_comments--></option>
                    <!--ENDIF-->
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <button class="button" type="submit">
                    <!--COMMON::button_arrow--> <!--COMMON::do_action_button_long-->
                </button>
            </td>
        </tr>
        <!--ENDIF-->
    </table>
</form>
<!--section-end::list--> 

<!--section-start::list_no_entry-->
        <tr >
            <td colspan="3" class="center">
                <!--TEXT::error-->
            </td>
        </tr>
<!--section-end::list_no_entry--> 

<!--section-start::list_entry_simple-->
        <tr class="select_entry">
            <td class="justify twothird" style="padding-right:25px;">
                #<!--TEXT::id--> <!--TEXT::title-->
            </td>
            <td class="middle right quarter">
                <span class="small"><!--COMMON::at_date--> <b><!--TEXT::date--></b> <!--COMMON::at_time--> <b><!--TEXT::time--></b></span>
            </td>
            <td class="middle center">
                <input class="select_box" type="checkbox" name="news_id[]" value="<!--TEXT::id-->">
            </td>
        </tr>
<!--section-end::list_entry_simple--> 

<!--section-start::list_entry_extended-->
        <tr class="select_entry">
            <td class="justify twothird" style="padding-right:25px;">
                #<!--TEXT::id--> <!--TEXT::title--><br>
                <span class="small">
                    <!--COMMON::by--> <b><!--TEXT::user_name--></b>, 
                    <!--COMMON::in--> <b><!--TEXT::cat_name--></b>,
                    <b><!--TEXT::num_comments--></b> <!--LANG::comments-->,
                    <b><!--TEXT::num_links--></b> <!--LANG::links-->
                </span>                
            </td>
            <td class="middle right quarter" style="width:180x;">
                <span class="small"><!--COMMON::at_date--> <b><!--TEXT::date--></b> <!--COMMON::at_time--> <b><!--TEXT::time--></b></span>
            </td>
            <td class="middle center">
                <input class="select_box" type="checkbox" name="news_id[]" value="<!--TEXT::id-->">
            </td>
        </tr>
<!--section-end::list_entry_extended--> 

<!--section-start::list_entry_full-->
        <tr class="select_entry">
            <td class="justify twothird" style="padding-right:15px;">
                #<!--TEXT::id--> <!--TEXT::title--><br>
                <span class="small"><!--TEXT::text_preview--></span>
            </td>
            <td class="middle quarter" style="padding-right:10px;">
                <span class="small">
                    <!--COMMON::by--> <b><!--TEXT::user_name--></b><br>
                    <!--COMMON::at_date--> <b><!--TEXT::date--></b> <!--COMMON::at_time--> <b><!--TEXT::time--></b><br>
                    <!--COMMON::in--> <b><!--TEXT::cat_name--></b><br>
                    <b><!--TEXT::num_comments--></b> <!--LANG::comments-->,
                    <b><!--TEXT::num_links--></b> <!--LANG::links-->
                </span>
            </td>
            <td class="middle center">
                <input class="select_box" type="checkbox" name="news_id[]" value="<!--TEXT::id-->">
            </td>
        </tr>
<!--section-end::list_entry_full--> 


<!--section-start::filter-->
<form action="" method="get">
    <input type="hidden" name="go" value="news_edit">

    <table class="content" cellpadding="3" cellspacing="0">
        <tr><td colspan="2"><h3><!--LANG::filter_title--></h3><hr></td></tr>

        <tr>
            <td class="middle">               
                <p>
                    <!--COMMON::search_for-->:
                    <input name="filter_string" class="half" value="<!--TEXT::filter_string-->">
                    <!--COMMON::in-->
                    <select name="search_type">
                        <option value="0" <!--IF::search_type_0-->selected<!--ENDIF-->><!--LANG::search_fulltext--></option>
                        <option value="1" <!--IF::search_type_1-->selected<!--ENDIF-->><!--LANG::search_id--></option>
                    </select>
                    <input class="atright" type="submit" value="<!--COMMON::do_action_button-->">               
                </p>
                
            </td>
        </tr>

        <tr>
            <td class="middle" colspan="2">
                <p>
                    <!--COMMON::cat-->:
                    <select name="filter_cat">
                        <option value="0" <!--IF::filter_cat-->selected<!--ENDIF-->><!--LANG::all_cats--></option>
                        <option value="0"><!--COMMON::select_hr--></option>
                        <!--TEXT::filter_cat_options-->
                        
                    </select><span class="atright">
                    <!--LANG::filter_order-->:
                    <select name="order">
                        <option value="news_id" <!--IF::order_id-->selected<!--ENDIF-->><!--LANG::filter_id--></option>
                        <option value="news_date" <!--IF::order_date-->selected<!--ENDIF-->><!--LANG::filter_date--></option>
                        <option value="news_title" <!--IF::order_title-->selected<!--ENDIF-->><!--LANG::filter_newstitle--></option>
                    </select>
                    <select name="sort">
                        <option value="ASC" <!--IF::sort_asc-->selected<!--ENDIF-->><!--COMMON::asc--></option>
                        <option value="DESC" <!--IF::sort_desc-->selected<!--ENDIF-->><!--COMMON::desc--></option>
                    </select></span>
                </p>
            </td>
        </tr>
    </table>
    <p>&nbsp;</p>
</form>
<!--section-end::filter--> 
