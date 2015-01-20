<!--section-start::main-->
<form action="" method="post">
<input type="hidden" name="go" value="social_meta_tags">
<input type="hidden" name="sended" value="1">

    <table class="content config" cellpadding="0" cellspacing="0">
        <tr><td colspan="2"><h3><!--LANG::settings_title--></h3><hr></td></tr>
        <tr>
            <td>
                <!--LANG::site_name--> <span class="small">(<!--COMMON::optional-->)</span><br>
                <span class="small"><!--LANG::site_name_desc--></span>
            </td>
            <td>
                <input class="half" name="site_name" id="site_name" maxlength="100" value="<!--TEXT::site_name-->">
            </td>
        </tr>
        <tr>
            <td>
                <!--LANG::default_image--> <span class="small">(<!--COMMON::optional-->)<br>
                <span class="small"><!--LANG::default_image_desc--></span>
            </td>
            <td>
                <input class="half" name="default_image" id="default_image" maxlength="255" value="<!--TEXT::default_image-->"><br>
                <span class="small"><!--LANG::default_image_info--></span>
            </td>
        </tr>
        <tr>
            <td>
                <!--LANG::use_external_images--><br>
                <span class="small"><!--LANG::use_external_images_desc--></span>
            </td>
            <td>
                <!--COMMON::checkbox-->
                <input class="hidden" type="checkbox" name="use_external_images" value="1" <!--IF::use_external_images-->checked<!--ENDIF-->>
            </td>
        </tr>

        <tr>
            <td>
                <!--LANG::use_news_cat_prepend--><br>
                <span class="small"><!--LANG::use_news_cat_prepend_desc--></span>
            </td>
            <td>
                <!--COMMON::checkbox-->
                <input class="hidden" type="checkbox" name="use_news_cat_prepend" value="1" <!--IF::use_news_cat_prepend-->checked<!--ENDIF-->
                onChange="$('#use_news_cat_prepend_tr').toggle()" >
            </td>
        </tr>
        <tr <!--IF::use_news_cat_prepend--><!--ELSE-->class="hidden"<!--ENDIF--> id="use_news_cat_prepend_tr">
            <td>
                <!--LANG::news_cat_prepend--> <span class="small">(<!--COMMON::optional-->)</span><br>
                <span class="small"><!--LANG::news_cat_prepend_desc--></span>
            </td>
            <td>
                <input class="half" name="news_cat_prepend" id="news_cat_prepend" maxlength="20" value="<!--TEXT::news_cat_prepend-->">
            </td>
        </tr>
        
        
        <tr><td colspan="2"><h3><!--LANG::googleplus_title--></h3><hr></td></tr>
        <tr>
            <td>
                <!--LANG::use_google_plus--><br>
                <span class="small"><!--LANG::use_google_plus_desc--></span>
            </td>
            <td>
                <!--COMMON::checkbox-->
                <input class="hidden" type="checkbox" name="use_google_plus" value="1" <!--IF::use_google_plus-->checked<!--ENDIF-->
                onChange="$('#use_google_plus_tr').toggle()" >
            </td>
        </tr>
        <tr <!--IF::use_google_plus--><!--ELSE-->class="hidden"<!--ENDIF--> id="use_google_plus_tr">
            <td>
                <!--LANG::google_plus_page--><br>
                <span class="small"><!--LANG::google_plus_page_desc--></span>
            </td>
            <td>
                <input class="half" name="google_plus_page" id="google_plus_page" maxlength="100" value="<!--TEXT::google_plus_page-->">
            </td>
        </tr>
        
        
        <tr><td colspan="2"><h3><!--LANG::twitter_title--></h3><hr></td></tr>
        <tr>
            <td>
                <!--LANG::use_twitter_card--><br>
                <span class="small"><!--LANG::use_twitter_card_desc--></span>
            </td>
            <td>
                <!--COMMON::checkbox-->
                <input class="hidden" type="checkbox" name="use_twitter_card" value="1" <!--IF::use_twitter_card-->checked<!--ENDIF-->
                onChange="$('#use_twitter_card_tr').toggle()" >
            </td>
        </tr>
        <tr <!--IF::use_twitter_card--><!--ELSE-->class="hidden"<!--ENDIF--> id="use_twitter_card_tr">
            <td>
                <!--LANG::twitter_site--><br>
                <span class="small"><!--LANG::twitter_site_desc--></span>
            </td>
            <td>
                <input class="half" name="twitter_site" id="twitter_site" maxlength="100" value="<!--TEXT::twitter_site-->">
            </td>
        </tr>  
        
        
        <tr><td colspan="2"><h3><!--LANG::facebook_title--></h3><hr></td></tr>
        <tr>
            <td>
                <!--LANG::use_open_graph--><br>
                <span class="small"><!--LANG::use_open_graph_desc--></span>
            </td>
            <td>
                <!--COMMON::checkbox-->
                <input class="hidden" type="checkbox" name="use_open_graph" value="1" <!--IF::use_open_graph-->checked<!--ENDIF-->
                onChange="$('.use_open_graph_tr').toggle()" >
            </td>
        </tr>
        <tr class="use_open_graph_tr <!--IF::use_open_graph--><!--ELSE-->hidden<!--ENDIF-->">
            <td>
                <!--LANG::fb_admins--><br>
                <span class="small"><!--LANG::fb_admins_desc--></span>
            </td>
            <td>
                <input class="half" name="fb_admins" id="fb_admins" maxlength="100" value="<!--TEXT::fb_admins-->"><br>
                <span class="small"><!--COMMON::csv--></span>
            </td>
        </tr>  
        <tr class="use_open_graph_tr <!--IF::use_open_graph--><!--ELSE-->hidden<!--ENDIF-->">
            <td>
                <!--LANG::og_section--><br>
                <span class="small"><!--LANG::og_section_desc--></span>
            </td>
            <td>
                <input class="half" name="og_section" id="og_section" maxlength="100" value="<!--TEXT::og_section-->">
            </td>
        </tr>  
        
        
        <tr><td colspan="2"><h3><!--LANG::schemaorg_title--></h3><hr></td></tr>
        <tr>
            <td>
                <!--LANG::use_schema_org--><br>
                <span class="small"><!--LANG::use_schema_org_desc--></span>
            </td>
            <td>
                <!--COMMON::checkbox-->
                <input class="hidden middle" type="checkbox" name="use_schema_org" value="1" <!--IF::use_schema_org-->checked<!--ENDIF-->><br>
                <span class="small"><!--LANG::use_schema_org_info--></span>
            </td>
        </tr>
        
        
        <tr><td colspan="2"><h3><!--LANG::enable_for_title--></h3><hr></td></tr>
        <tr>
            <td>
                <!--LANG::enable_news--><br>
                <span class="small"><!--LANG::enable_news_desc--></span>
            </td>
            <td>
                <!--COMMON::checkbox-->
                <input class="hidden" type="checkbox" name="enable_news" value="1" <!--IF::enable_news-->checked<!--ENDIF-->>
            </td>
        </tr>
        <tr>
            <td>
                <!--LANG::enable_articles--><br>
                <span class="small"><!--LANG::enable_articles_desc--></span>
            </td>
            <td>
                <!--COMMON::checkbox-->
                <input class="hidden" type="checkbox" name="enable_articles" value="1" <!--IF::enable_articles-->checked<!--ENDIF-->>
            </td>
        </tr>
        <tr>
            <td>
                <!--LANG::enable_downloads--><br>
                <span class="small"><!--LANG::enable_downloads_desc--></span>
            </td>
            <td>
                <!--COMMON::checkbox-->
                <input class="hidden" type="checkbox" name="enable_downloads" value="1" <!--IF::enable_downloads-->checked<!--ENDIF-->>
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
