<!--section-start::main-->
<form action="" method="post">
<input type="hidden" name="go" value="gen_config">
<input type="hidden" name="sended" value="1">

    <table class="content config" cellpadding="0" cellspacing="0">
        <tr><td colspan="2"><h3><!--LANG::pageinfo_title--></h3><hr></td></tr>

        <tr>
            <td>
                <!--LANG::title-->:<br>
                <span class="small"><!--LANG::title_desc--></span>
            </td>
            <td>
                <input class="half" name="title" maxlength="100" value="<!--TEXT::title-->">
            </td>
        </tr>

        <tr>
            <td>
                <!--LANG::dyn_title--><br>
                <span class="small"><!--LANG::dyn_title_desc--></span>
            </td>
            <td>
                <!--COMMON::checkbox-->
                <input class="hidden" type="checkbox" name="dyn_title" value="1" <!--IF::dyn_title-->checked<!--ENDIF-->
                onChange="$('#dyn_title_ext_tr').toggle($(this).prop('checked'))" >
            </td>
        </tr>


        <tr <!--IF::dyn_title_ext-->class="hidden"<!--ENDIF--> id="dyn_title_ext_tr">
            <td>
                <!--LANG::dyn_title_ext--><br>
                <span class="small"><!--LANG::dyn_title_ext_desc--></span>
            </td>
            <td>
                <input class="half" name="dyn_title_ext" id="dyn_title_ext" maxlength="100" value="<!--TEXT::dyn_title_ext-->"><br>
                <span class="small" style="padding-top: 3px; display: block;">
                    <strong><!--COMMON::valid_tags-->:</strong>&nbsp;&nbsp;
                    <!--TEXT::dyn_title_ext_tt-->
                </span>
            </td>
        </tr>

        <tr>
            <td>
                <!--LANG::virtualhost-->:<br>
                <span class="small"><!--LANG::virtualhost_desc--></span>
            </td>
            <td>
                <select name="protocol">
                    <option value="http://" <!--IF::protocol_http-->selected<!--ENDIF-->>http://</option>
                    <option value="https://" <!--IF::protocol_https-->selected<!--ENDIF-->>https://</option>
                </select>
                <input class="third" name="url" maxlength="255" value="<!--TEXT::url-->">
            </td>
        </tr>
        <tr>
            <td>
                <!--LANG::other_protocol-->:<br>
                <span class="small"><!--LANG::other_protocol_desc--></span>
            </td>
            <td>
                <!--COMMON::checkbox-->
                <input class="hidden" type="checkbox" name="other_protocol" value="1" <!--IF::other_protocol-->checked<!--ENDIF-->>
            </td>
        </tr>


        <tr>
            <td>
                <!--LANG::admin_mail-->:<br>
                <span class="small"><!--LANG::admin_mail_desc--></span>
            </td>
            <td>
                <input class="half" name="admin_mail" maxlength="100" value="<!--TEXT::admin_mail-->">
            </td>
        </tr>

        <tr>
            <td>
                <!--LANG::description-->: <span class="small">(<!--COMMON::optional-->)</span><br>
                <span class="small"><!--LANG::description_desc--></span>
            </td>
            <td>
                <textarea class="half nomono" name="description" rows="6"><!--TEXT::description--></textarea>
            </td>
        </tr>


        <tr>
            <td>
                <!--LANG::keywords-->: <span class="small">(<!--COMMON::optional-->)</span><br>
                <span class="small"><!--LANG::keywords_desc--></span>
            </td>
            <td>
                <textarea class="half nomono" name="keywords" rows="6"><!--TEXT::keywords--></textarea>
            </td>
        </tr>

        <tr>
            <td>
                <!--LANG::config_publisher_title-->: <span class="small">(<!--COMMON::optional-->)</span><br>
                <span class="small"><!--LANG::config_publisher_desc--></span>
            </td>
            <td>
                <input class="half" name="publisher" maxlength="100" value="<!--TEXT::publisher-->">
            </td>
        </tr>

        <tr>
            <td>
                <!--LANG::config_copyright_title-->: <span class="small">(<!--COMMON::optional-->)</span><br>
                <span class="small"><!--LANG::config_copyright_desc--></span>
            </td>
            <td>
                <textarea class="half nomono" name="copyright" rows="3"><!--TEXT::copyright--></textarea>
            </td>
        </tr>

        <tr><td colspan="2"><h3><!--LANG::design_title--></h3><hr></td></tr>

        <tr>
            <td>
                <!--LANG::style_title-->:<br>
                <span class="small"><!--LANG::style_desc--></span>
            </td>
            <td>
                <select class="half" name="style_id" size="1">
                    <!--TEXT::style_options-->
                </select>
            </td>
        </tr>

        <tr>
            <td>
                <!--LANG::allow_other_styles-->:<br>
                <span class="small"><!--LANG::allow_other_styles_desc--></span>
            </td>
            <td>
                <!--COMMON::checkbox-->
                <input class="hidden" type="checkbox" name="allow_other_designs" value="1" <!--IF::allow_other_designs-->checked<!--ENDIF-->>
            </td>
        </tr>

        <tr>
            <td>
                <!--LANG::show_favicon-->:<br>
                <span class="small"><!--LANG::show_favicon_desc--></span>
            </td>
            <td>
                <img class="checkbox pointer" src="img/test.png">
                <input class="hidden pointer" type="checkbox" name="show_favicon" value="1"<!--IF::show_favicon-->checked<!--ENDIF-->>
            </td>
        </tr>

        <tr><td colspan="2"><h3><!--LANG::settings_title--></h3><hr></td></tr>

        <tr>
            <td>
                <!--LANG::home_page-->:<br>
                <span class="small"><!--LANG::home_page_desc--></span>
            </td>
            <td>
                <p>
                    <span style="display:table-cell" class="middle">
                        <!--COMMON::radio-->
                        <input class="hidden" type="radio" id="home_0" name="home" value="0"
                        <!--IF::home_0-->checked<!--ENDIF-->>
                    </span>
                    <span style="display:table-cell" class="middle">
                        &nbsp;
                        <label for="home_0"><!--LANG::home_page_default--></label>
                    </span>
                </p>

                <p>
                    <span style="display:table-cell" class="middle">
                        <!--COMMON::radio-->
                        <input class="hidden" type="radio" id="home_1" name="home" value="1"
                        <!--IF::home_1-->checked<!--ENDIF-->>
                    </span>
                    <span style="display:table-cell" class="middle">
                        &nbsp;
                        <label for="home_1">
                            ?go = <input class="third" name="home_text" maxlength="100" value="<!--TEXT::home_text-->">
                        </label>
                    </span>
                </p>
                <p></p>
            </td>
        </tr>

        <tr>
            <td>
                <!--LANG::language-->:<br>
                <span class="small"><!--LANG::language_desc--></span>
            </td>
            <td>
                <select class="half" name="language_text" size="1">
                    <!--TEXT::language_options-->
                </select>
            </td>
        </tr>

        <tr>
            <td>
                <!--LANG::feed-->:<br>
                <span class="small"><!--LANG::feed_desc--></span>
            </td>
            <td>
                <select class="half" name="feed" size="1">
                    <option value="rss091" <!--IF::feed_rss091-->selected<!--ENDIF-->>
                        <!--LANG::feed_rss091-->
                    </option>
                    <option value="rss10" <!--IF::feed_rss10-->selected<!--ENDIF-->>
                        <!--LANG::feed_rss10-->
                    </option>
                    <option value="rss20" <!--IF::feed_rss20-->selected<!--ENDIF-->>
                        <!--LANG::feed_rss20-->
                    </option>
                    <option value="atom10" <!--IF::feed_atom10-->selected<!--ENDIF-->>
                        <!--LANG::feed_atom10-->
                    </option>
                </select>
            </td>
        </tr>

        <tr>
            <td>
                <!--LANG::url_style-->:<br>
                <span class="small"><!--LANG::url_style_desc--></span>
            </td>
            <td>
                <select class="half" name="url_style" size="1">
                    <option value="default" <!--IF::url_style_default-->selected<!--ENDIF-->>
                        <!--LANG::url_style_default-->
                    </option>
                    <option value="seo" <!--IF::url_style_seo-->selected<!--ENDIF-->>
                        <!--LANG::url_style_seo-->
                    </option>
                </select>
                <br>
                <span class="small"><!--LANG::url_style_info--></span>
            </td>
        </tr>

        <tr>
            <td>
                <!--LANG::date-->: <br>
                <span class="small"><!--LANG::date_desc--></span>
            </td>
            <td>
                <input class="half" name="date" maxlength="255" value="<!--TEXT::date-->"><br>
                <span class="small"><!--COMMON::date_info--></span>
            </td>
        </tr>

        <tr>
            <td>
                <!--LANG::time-->: <br>
                <span class="small"><!--LANG::time_desc--></span>
            </td>
            <td>
                <input class="half" name="time" maxlength="255" value="<!--TEXT::time-->"><br>
                <span class="small"><!--COMMON::date_info--></span>
            </td>
        </tr>

        <tr>
            <td>
                <!--LANG::date_time-->: <br>
                <span class="small"><!--LANG::date_time_desc--></span>
            </td>
            <td>
                <input class="half" name="datetime" maxlength="255" value="<!--TEXT::datetime-->"><br>
                <span class="small"><!--COMMON::date_info--></span>
            </td>
        </tr>

        <tr>
            <td>
                <!--LANG::timezone-->: <br>
                <span class="small"><!--LANG::timezone_desc--></span>
            </td>
            <td>
                <select class="half" name="timezone">
                    <option value="default" <!--IF::timezone-->selected<!--ENDIF-->><!--LANG::server_default--></option>
                    <!--TEXT::timezones-->
                </select>
            </td>
        </tr>

        <tr>
            <td>
                <!--LANG::auto_forward-->: <br>
                <span class="small"><!--LANG::auto_forward_desc--></span>
            </td>
            <td>
                <input class="center" size="2" name="auto_forward" maxlength="2" value="<!--TEXT::auto_forward-->"> <!--COMMON::seconds-->
            </td>
        </tr>

        <tr>
            <td>
                <!--LANG::referer-->:<br>
                <span class="small"><!--LANG::referer_desc--></span>
            </td>
            <td>
                <select class="half" name="count_referers" size="1">
                    <option value="1" <!--IF::ref_active-->selected<!--ENDIF-->>
                        <!--LANG::referer_active-->
                    </option>
                    <option value="0" <!--IF::ref_inactive-->selected<!--ENDIF-->>
                        <!--LANG::referer_inactive-->
                    </option>
                </select>
            </td>
        </tr>

        <tr><td colspan="2"><h3><!--LANG::pagenav_title--></h3><hr></td></tr>

        <tr>
            <td>
                <p>
                    <!--LANG::page-->: <br>
                    <span class="small"><!--LANG::page_desc-->
                </p>
                <p class="small">
                    <strong><!--COMMON::valid_tags-->:</strong><br>
                    <!--TEXT::page_tt-->
                </p>
            </td>
            <td>
                <textarea class="half" name="page" id="page" rows="7"><!--TEXT::page--></textarea>
            </td>
        </tr>

        <tr>
            <td>
                <p>
                    <!--LANG::page_prev-->: <br>
                    <span class="small"><!--LANG::page_prev_desc-->
                </p>
                <p class="small">
                    <strong><!--COMMON::valid_tags-->:</strong><br>
                    <!--TEXT::page_prev_tt-->
                </p>
            </td>
            <td>
                <textarea class="half" name="page_prev" id="page_prev" rows="4"><!--TEXT::page_prev--></textarea>
            </td>
        </tr>

        <tr>
            <td>
                <p>
                    <!--LANG::page_next-->: <br>
                    <span class="small"><!--LANG::page_next_desc-->
                </p>
                <p class="small">
                    <strong><!--COMMON::valid_tags-->:</strong><br>
                    <!--TEXT::page_next_tt-->
                </p>
            </td>
            <td>
                <textarea class="half" name="page_next" id="page_next" rows="4"><!--TEXT::page_next--></textarea>
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
