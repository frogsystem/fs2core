<!--section-start::main--> 
<form action="" method="post">
    <input type="hidden" name="go" value="news_add">
    <input type="hidden" name="sended" value="1">
    
    <table class="content" cellpadding="0" cellspacing="0">
        <tr><td colspan="2"><h3><!--LANG::news_information_title--></h3><hr></td></tr>
        
        <tr>
            <td>
                <!--LANG::news_cat-->:<br>
                <span class="small"><!--LANG::news_cat_desc--></span>
            </td>
            <td>
                <select class="third" name="cat_id">
                    <!--TEXT::cat_options-->
                </select>
            </td>
        </tr>
        
        
        <tr>
            <td>
                <!--LANG::news_date-->:<br>
                <span class="small"><!--LANG::news_date_desc--></span>
            </td>
            <td>
                <span class="small">
                    <input class="center" size="3" maxlength="2" id="d" name="d" value="<!--TEXT::d-->">
                    <input class="center" size="3" maxlength="2" id="m" name="m" value="<!--TEXT::m-->">
                    <input class="center" size="5" maxlength="4" id="y" name="y" value="<!--TEXT::y-->">
                    <!--COMMON::at_time-->
                    <input class="center" size="3" maxlength="2" id="h" name="h" value="<!--TEXT::h-->">
                    :
                    <input class="center" size="3" maxlength="2" id="i" name="i" value="<!--TEXT::i-->">
                    <!--COMMON::time_appendix-->&nbsp;
                </span>
                <input class="nshide" type="button" onClick='setNow("y", "m", "d", "h", "i")' value="<!--COMMON::now-->">
            </td>
        </tr>
                            
        <tr>
            <td>
                <!--LANG::news_poster-->:<br>
                <span class="small"><!--LANG::news_poster_desc--></span>
            </td>
            <td>
                <input size="30" maxlength="100" id="user_name" name="user_name" value="<!--TEXT::user_name-->">
                <input type="hidden" id="user_id" name="user_id" value="<!--TEXT::user_id-->">
                <input class="nshide" type="button" onClick='popUp("?go=find_user&amp;id=user_id&amp;name=user_name", "_blank", 400, 500)' value="<!--COMMON::change-->">
            </td>
        </tr>
        
        
        <tr><td colspan="2"><h3><!--LANG::news_new_title--></h3><hr></td></tr>
        

        <tr>
            <td class="config" colspan="2">
                <!--LANG::news_title-->:
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input class="full" maxlength="255" id="news_title" name="news_title" value="<!--TEXT::news_title-->"><br><br>
            </td>
        </tr>
        
        <tr>
            <td colspan="2">
                                
                <table cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td>
                            <!--LANG::news_text-->:<br>
                            <span class="small">
                                <!--COMMON::html--> <!--COMMON::is--> <!--TEXT::html-->.
                                <!--COMMON::fscode--> <!--COMMON::is--> <!--TEXT::fs-->.
                                <!--COMMON::para--> <!--COMMON::is--> <!--TEXT::para-->.
                            </span>
                        </td>
                        <td class="right bottom">
                            <input class="middle" type="checkbox" id="news_active" name="news_active" value="1" <!--IF::news_active-->checked<!--ENDIF-->>
                            <label for="news_active" class="small middle"><!--LANG::news_active--></label>&nbsp;&nbsp;
                                    
                            <input class="middle" type="checkbox" id="news_comments_allowed" name="news_comments_allowed" value="1" <!--IF::news_comments_allowed-->checked<!--ENDIF-->>
                            <label for="news_comments_allowed" class="small middle"><!--LANG::news_comments_allowed--></label>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
                            
        <tr>
            <td colspan="2">
                <!--TEXT::the_editor-->
            </td>
        </tr>
        
        
        <!--TEXT::link_list-->
        <!--TEXT::link_add-->
        
        <tr>
            <td colspan="2">
                <input type="button" onClick='popUp("admin_news_prev.php?i=.$linkid", "_blank", screen.availWidth, screen.availHeight)' value="<!--COMMON::preview-->">
            </td>
        </tr>
        <tr>
            <td class="buttontd" colspan="2">
                <button class="button" type="submit">
                    <!--COMMON::button_arrow--> <!--COMMON::save_changes_button-->
                </button>
            </td>
        </tr>
    </table>
</form>
<!--section-end::main-->


<!--section-start::link_list-->
        <tr>
            <td colspan="2">
                <table class="spacebottom" cellpadding="0" cellspacing="0" width="100%" id="link_list">
                    <!--TEXT::link_entries-->
                    <!--IF::link_edit-->
                    <tr class="hidden">
                        <td class="right top" style="padding-right: 5px; padding-top: 11px;" colspan="2">
                            <select name="link_action" size="1">
                                <option value="0"><!--LANG::news_link_no--></option>
                                <option value="edit"><!--LANG::news_link_edit--></option>
                                <option value="up"><!--LANG::news_link_up--></option>
                                <option value="down"><!--LANG::news_link_down--></option>
                                <option value="del"><!--LANG::news_link_delete--></option>
                            </select>
                        </td>
                        <td class="center" style="padding-top: 11px;">
                            <input type="submit" name="edit_link" value="<!--COMMON::do_action_button-->">
                        </td>
                    </tr>
                    <!--ENDIF-->
                </table>
            </td>
        </tr>
<!--section-end::link_list-->

<!--section-start::link_entry-->
<tr class="link_entry">
    <td width="20">
        #<!--TEXT::num-->
    </td>
    <td width="530">
        <!--TEXT::name--> <span class="small">(<!--TEXT::target_text-->)</span><br>
        <a href="<!--TEXT::url-->" target="_blank" title="<!--TEXT::url-->"><!--TEXT::short_url--></a>
        <input type="hidden" name="link_name[<!--TEXT::id-->]" value="<!--TEXT::name-->">
        <input type="hidden" name="link_url[<!--TEXT::id-->]" value="<!--TEXT::url-->">
        <input type="hidden" name="link_target[<!--TEXT::id-->]" value="<!--TEXT::target-->">
    </td>

    <td class="middle" width="140">
        <div class="hidden center">
            <input class="pointer" type="radio" name="link" value="<!--TEXT::id-->">
        </div>
        <div class="ns_hide right middle">
            <img class="pointer" src="icons/up.gif" onClick="up($(this).parents(\'tr:first\'))" alt="<!--COMMON::up-->" title="<!--COMMON::up-->">&nbsp;
            <img class="pointer" src="icons/down.gif" onClick="down($(this).parents(\'tr:first\'))" alt="<!--COMMON::down-->" title="<!--COMMON::down-->">
            &nbsp;&nbsp;&nbsp;
            <img class="pointer" src="icons/edit.gif" onClick="edit($(this).parents(\'tr:first\'))" alt="<!--COMMON::edit-->" title="<!--COMMON::edit-->">&nbsp;
            <img class="pointer" src="icons/delete.gif" onClick="remove($(this).parents(\'tr:first\'))" alt="<!--COMMON::delete-->" title="<!--COMMON::delete-->">&nbsp;
        </div>
    </td>    
</tr>
<!--section-end::link_entry-->

<!--section-start::link_add-->
        <tr>
            <td colspan="2">
                <!--LANG::news_link_add-->:
            </td>
        </tr>
        
        <tr>
            <td colspan="2">
                <table class="spacebottom" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td class="middle" style="padding-right: 5px;">
                            <!--LANG::news_link_title-->:
                        </td>
                        <td class="middle">
                            <input class="half" maxlength="100" name="new_link_name" value="<!--TEXT::name-->">
                        </td>
                        <td style="padding-left:5px; padding-right:5px;" class="middle">
                            <!--LANG::news_link_open-->:
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="middle">
                            <!--LANG::news_link_url-->:
                        </td>
                        <td class="middle">
                            <input class="half" maxlength="255" name="new_link_url" value="<!--TEXT::url-->"><!--TEXT::-->
                        </td>
                        <td class="middle" style="padding-left:5px; padding-right:5px;">
                            <select name="new_link_target" size="1">
                                <option value="0" <!--IF::target_0-->selected<!--ENDIF-->>
                                    <!--LANG::news_link_self-->
                                </option>
                                <option value="1" <!--IF::target_1-->selected<!--ENDIF-->>
                                    <!--LANG::news_link_blank-->
                                </option>
                            </select>
                        </td>
                        <td class="right">
                            <input class="hidden" type="submit" name="add_link" value="<!--COMMON::add_button-->">
                            <input class="ns_hide" type="button" onClick="addLink()" value="<!--COMMON::add_button-->">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
<!--section-end::link_add-->


<!--section-start::script-->
<script type="text/javascript">
    jQuery(document).ready(function(){
        $("tr.link_entry").live("mouseover mouseout", function(event) {
            if ( event.type == "mouseover" ) {
                $(this).css("background-color", "#EEEEEE");
            } else {
                $(this).css("background-color", "transparent");
            }
        });
    });
    
    function addLink() {
        // add link
        if ($("input[name=new_link_name]:first").val() != ""
            && $("input[name=new_link_url]:first").val() != ""
            && $("input[name=new_link_url]:first").val() != "http://"
            && $("input[name=new_link_url]:first").val() != "https://") {
            
            // assign vars
            var name = $("input[name=new_link_name]:first");
            var url = $("input[name=new_link_url]:first");
            var target = $("select[name=new_link_target]");
            var insert = $("#link_list tr:not([class~=hidden])");
            
            //get id
            var id = $("input[name=link]").length;
            
            // insert data
            var line = '<!--TEXT::link_entry-->';
            line = line.replace(/<!--TEXT::id-->/g, id);
            line = line.replace(/<!--TEXT::name-->/g, name.val());
            line = line.replace(/<!--TEXT::url-->/g, url.val());
            line = line.replace(/<!--TEXT::target-->/g, target.val());
            line = line.replace(/<!--TEXT::num-->/g, id+1);
            line = line.replace(/<!--TEXT::short_url-->/g, cut_in_string(url.val(), <!--TEXT::sul-->, "<!--TEXT::sur-->"));
            if (target.val() == 1) {
                line = line.replace(/<!--TEXT::target_text-->/g, '<!--LANG::news_link_blank-->');
            } else {
                line = line.replace(/<!--TEXT::target_text-->/g, '<!--LANG::news_link_self-->');
            }
            
            if (insert.length >= 1) {
                insert.filter(":last").after(line);
            } else {
                $("#link_list").prepend(line);
            }
                        
            
            // reset form                
            name.val("");
            url.val("http://");
            target.val(0);        
        
        // error
        } else {
            alert("<!--LANG::link_not_added-->\n<!--COMMON::form_not_filled-->");            
        }        
    }
</script>
<!--section-end::script-->
