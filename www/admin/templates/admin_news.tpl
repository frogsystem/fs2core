<!--section-start::form_table-->
    <table class="content" cellpadding="0" cellspacing="0">
        <tr><td colspan="2"><h3><!--LANG::news_information_title--></h3><hr></td></tr>

        <tr>
            <td>
                <!--LANG::news_cat-->:<br>
                <span class="small"><!--LANG::news_cat_desc--></span>
            </td>
            <td>
                <select class="third" name="cat_id" id="cat_id">
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
                <input class="third" maxlength="100" id="user_name" name="user_name" value="<!--TEXT::user_name-->">
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
                <input type="button" onClick='popTab("?go=news_preview", "_blank")' value="<!--COMMON::preview-->">
            </td>
        </tr>
        <tr>
            <td class="buttontd" colspan="2">
                <button class="button" type="submit">
                    <!--COMMON::button_arrow--> <!--LANG::news_button-->
                </button>
            </td>
        </tr>
    </table>
<!--section-end::form_table-->

<!--section-start::link_list-->
        <tr>
            <td colspan="2">
                <table class="spacebottom" cellpadding="0" cellspacing="0" width="100%" id="link_list">
                    <!--TEXT::link_entries-->
                    <!--IF::link_edit-->
                    <tr class="hidden">
                        <td>&nbsp;</td>
                        <td class="right top" style="padding-right: 5px; padding-top: 11px;">
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
    <td class="left" width="20">
        #<!--TEXT::num-->&nbsp;&nbsp;
    </td>
    <td width="530">
        <!--TEXT::name--> <span class="small">(<!--TEXT::target_text-->)</span><br>
        <a href="<!--TEXT::url-->" target="_blank" title="<!--TEXT::url-->"><!--TEXT::short_url--></a>
        <input type="hidden" name="link_name[<!--TEXT::id-->]" value="<!--TEXT::name-->">
        <input type="hidden" name="link_url[<!--TEXT::id-->]" value="<!--TEXT::url-->">
        <input type="hidden" name="link_target[<!--TEXT::id-->]" value="<!--TEXT::target-->">
        <!--IF::notscript-->
        <script type="text/javascript">
            link_arr[<!--TEXT::id-->] = new Object();
            link_arr[<!--TEXT::id-->]['name'] = "<!--TEXT::name-->";
            link_arr[<!--TEXT::id-->]['url'] = "<!--TEXT::url-->";
            link_arr[<!--TEXT::id-->]['target'] = <!--TEXT::target-->;
        </script>
        <!--ENDIF-->
    </td>

    <td class="middle" width="140">
        <div class="hidden center">
            <input class="pointer" type="radio" name="link" value="<!--TEXT::id-->">
        </div>
        <div class="nshide right">
            <img class="pointer" src="icons/up.gif" onClick="up($(this).parents(\'tr:first\'));" alt="<!--COMMON::up-->" title="<!--COMMON::up-->">&nbsp;
            <img class="pointer" src="icons/down.gif" onClick="down($(this).parents(\'tr:first\'));" alt="<!--COMMON::down-->" title="<!--COMMON::down-->">
            &nbsp;&nbsp;&nbsp;
            <img class="pointer" src="icons/edit.gif" onClick="edit($(this).parents(\'tr:first\'));" alt="<!--COMMON::edit-->" title="<!--COMMON::edit-->">&nbsp;
            <img class="pointer" src="icons/delete.gif" onClick="removeLink($(this).parents(\'tr:first\'));" alt="<!--COMMON::delete-->" title="<!--COMMON::delete-->">
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
                <!--TEXT::table-->
            </td>
        </tr>
<!--section-end::link_add-->


<!--section-start::link_edit-->
<tr id="edit_link_<!--TEXT::id-->">
    <td colspan="3">
        <!--TEXT::table-->
    </td>
</tr>
<!--section-end::link_edit-->

<!--section-start::edit_table-->
        <table class="<!--TEXT::class-->" cellpadding="3" cellspacing="0" width="100%">
            <tr>
                <td class="middle">
                    <!--LANG::news_link_title-->:
                </td>
                <td class="middle">
                    <input class="half" maxlength="100" name="<!--TEXT::name_name-->" value="<!--TEXT::name-->">
                </td>
                <td class="middle">
                    <!--LANG::news_link_open-->:
                </td>
                <td></td>
            </tr>
            <tr>
                <td class="middle">
                    <!--LANG::news_link_url-->:
                </td>
                <td class="middle half" style="padding-right:10px;">
                    <input class="half" maxlength="255" name="<!--TEXT::url_name-->" value="<!--TEXT::url-->">
                </td>
                <td class="middle left">
                    <select class="quarter" name="<!--TEXT::target_name-->" size="1">
                        <option value="0" <!--IF::target_0-->selected<!--ENDIF-->>
                            <!--LANG::news_link_self-->
                        </option>
                        <option value="1" <!--IF::target_1-->selected<!--ENDIF-->>
                            <!--LANG::news_link_blank-->
                        </option>
                    </select>
                </td>
                <td class="right">
                <!--IF::button-->
                    <input class="hidden" type="submit" name="add_link" value="<!--COMMON::add_button-->">
                    <input class="nshide" type="button" onClick="addLink()" value="<!--COMMON::add_button-->">
                <!--ELSE-->
                    <input type="button" onClick="saveLink(<!--TEXT::id-->)" value="<!--COMMON::save_button-->">
                <!--ENDIF-->
                </td>
            </tr>
        </table>
<!--section-end::edit_table-->

<!--section-start::script-->
<script type="text/javascript">
    jQuery(document).ready(function(){
        $("#link_list").delegate("tr.link_entry", "mouseover mouseout", function(event) {
            if ( event.type == "mouseover" ) {
                $(this).css("background-color", "#EEEEEE");
            } else {
                $(this).css("background-color", "transparent");
            }
        });


        renderLinks(link_arr);
    });

    link_arr = new Array();

    function edit(l) {
        var id = parseInt(l.find("input[name=link]").val());

        // insert data
        var line = '<!--TEXT::link_edit-->';
        line = line.replace(/<!--TEXT::id-->/g, id);
        line = line.replace(/<!--TEXT::name-->/g, htmlspecialchars(link_arr[id]['name']));
        line = line.replace(/<!--TEXT::url-->/g, htmlspecialchars(link_arr[id]['url']));
        l.replaceWith(line);

        var edit_tr = $("tr#edit_link_"+id);
        edit_tr.find("select[name=edit_target]").val(link_arr[id]['target']);
    }

    function saveLink(id) {
        // assign vars
        var edit_tr = $("tr#edit_link_"+id);
        var name = edit_tr.find("input[name=edit_name]:first");
        var url = edit_tr.find("input[name=edit_url]:first");
        var target = edit_tr.find("select[name=edit_target]");

        // add link
        if (name.val() != "" && url.val() != "" && url.val() != "http://" && url.val() != "https://") {

            // add new link
            var newlink = new Object();
            link_arr[id]['name'] = name.val();
            link_arr[id]['url'] = url.val();
            link_arr[id]['target'] = target.val();

            //render link
            var line = getLinkHtml(id, link_arr[id]['name'], link_arr[id]['url'], link_arr[id]['target']);
            edit_tr.replaceWith(line);

        // error
        } else {
            alert("<!--LANG::link_not_saved-->\n<!--COMMON::form_not_filled-->");
        }
    }

    function removeLink(l) {
        var id = parseInt(l.find("input[name=link]").val());

        if (id < link_arr.length) {
            link_arr.splice(id, 1);

            renderLinks(link_arr);
        }
    }

    function down(l) {
        var id = parseInt(l.find("input[name=link]").val());

        if (id < link_arr.length-1) {
            var bu = link_arr[id+1];
            link_arr[id+1] = link_arr[id];
            link_arr[id] = bu;

            renderLinks(link_arr);
        }
    }

    function up(l) {
        var id = parseInt(l.find("input[name=link]").val());

        if (id >= 1) {
            var bu = link_arr[id-1];
            link_arr[id-1] = link_arr[id];
            link_arr[id] = bu;

            renderLinks(link_arr);
        }
    }




    function addLink() {
        // assign vars
        var name = $("input[name=new_link_name]:first");
        var url = $("input[name=new_link_url]:first");
        var target = $("select[name=new_link_target]");

        // add link
        if (name.val() != "" && url.val() != "" && url.val() != "http://" && url.val() != "https://") {

            // add new link
            var newlink = new Object();
            newlink['name'] = name.val();
            newlink['url'] = url.val();
            newlink['target'] = target.val();

            link_arr.push(newlink);

            // reset form
            name.val("");
            url.val("http://");
            target.val(0);

            //render links
            renderLinks(link_arr);

        // error
        } else {
            alert("<!--LANG::link_not_added-->\n<!--COMMON::form_not_filled-->");
        }
    }

    function renderLinks(data) {
        var line = "";

        // get HTML for all Links
        for (var i=0; i<data.length; i++) {
            line += getLinkHtml(i, data[i]['name'], data[i]['url'], data[i]['target']);
        }

        // remove old html
        $("#link_list tr.link_entry").remove();

        //insert new one
        $("#link_list").prepend(line);
    }

    function getLinkHtml (id, name, url, target) {
        // insert data
        var line = '<!--TEXT::link_entry-->';
        line = line.replace(/<!--TEXT::id-->/g, id);
        line = line.replace(/<!--TEXT::name-->/g, htmlspecialchars(name));
        line = line.replace(/<!--TEXT::url-->/g, htmlspecialchars(url));
        line = line.replace(/<!--TEXT::target-->/g, target);
        line = line.replace(/<!--TEXT::num-->/g, id+1);
        line = line.replace(/<!--TEXT::short_url-->/g, htmlspecialchars(cut_in_string(url, <!--TEXT::sul-->, "<!--TEXT::sur-->")));
        if (target == 1) {
            line = line.replace(/<!--TEXT::target_text-->/g, '<!--LANG::news_link_blank-->');
        } else {
            line = line.replace(/<!--TEXT::target_text-->/g, '<!--LANG::news_link_self-->');
        }

        return line;
    }

</script>
<!--section-end::script-->
