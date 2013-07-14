<!--section-start::main-->
<table class="configtable" cellpadding="4" cellspacing="0">
    <tr><td class="line" colspan="2"><!--COMMON::informations_and_statistics--></td></tr>
    <tr>
        <td class="configthin" width="200"><!--LANG::num_news-->:</td>
        <td class="configthin"><b><!--TEXT::num_news--></b> <!--LANG::news_in--> <b><!--TEXT::num_news_cat--></b> <!--LANG::categories--></td>
    </tr>
    <tr>
        <td class="configthin" width="200"><!--LANG::num_comments-->:</td>
        <td class="configthin"><b><!--TEXT::num_comments--></b></td>
    </tr>
    <tr>
        <td class="configthin" width="200"><!--LANG::num_links-->:</td>
        <td class="configthin"><b><!--TEXT::num_links--></b></td>
    </tr>
    <!--IF::has_news-->
    <tr>
        <td class="configthin"><!--LANG::best_news_cat-->:</td>
        <td class="configthin"><b><!--TEXT::best_news_cat--></b> <!--LANG::with--> <b><!--TEXT::best_news_cat_num--></b> <!--LANG::news--></td>
    </tr>
    <!--ENDIF-->
    <!--IF::has_best_news_com-->
    <tr>
        <td class="configthin"><!--LANG::best_news_com-->:</td>
        <td class="configthin"><b><!--TEXT::best_news_com--></b> <!--LANG::with--> <b><!--TEXT::best_news_com_num--></b> <!--LANG::comments--></td>
    </tr>
    <!--ENDIF-->
    <!--IF::has_best_news_link-->
    <tr>
        <td class="configthin"><!--LANG::best_news_link-->:</td>
        <td class="configthin"><b><!--TEXT::best_news_link--></b> <!--LANG::with--> <b><!--TEXT::best_news_link_num--></b> <!--LANG::links--></td>
    </tr>
    <!--ENDIF-->
    <!--IF::has_news-->
    <tr>
        <td class="configthin"><!--LANG::best_news_poster-->:</td>
        <td class="configthin"><b><!--TEXT::best_news_poster--></b> <!--LANG::with--> <b><!--TEXT::best_news_poster_num--></b> <!--LANG::news--></td>
    </tr>
    <!--ENDIF-->
    <!--IF::has_best_com_poster-->
    <tr>
        <td class="configthin"><!--LANG::best_com_poster-->:</td>
        <td class="configthin"><b><!--TEXT::best_com_poster--></b> <!--LANG::with--> <b><!--TEXT::best_com_poster_num--></b> <!--LANG::comments--></td>
    </tr>
    <!--ENDIF-->
    <tr><td class="space"></td></tr>
    <tr>
        <td class="configthin" width="200"><!--LANG::num_articles-->:</td>
        <td class="configthin"><b><!--TEXT::num_articles--></b> <!--LANG::articles_in--> <b><!--TEXT::num_articles_cat--></b> <!--LANG::categories--></td>
    </tr>
<!--IF::has_best_article_poster-->
    <tr>
        <td class="configthin"><!--LANG::best_article_poster-->:</td>
        <td class="configthin"><b><!--TEXT::best_article_poster--></b> <!--LANG::with--> <b><!--TEXT::best_article_poster_num--></b> <!--LANG::articles--></td>
    </tr>
<!--ENDIF-->
    <tr><td class="space"></td></tr>
    <tr>
        <td class="configthin" width="200"><!--LANG::num_press-->:</td>
        <td class="configthin"><b><!--TEXT::num_press--></b></td>
    </tr>
<!--IF::has_press-->
    <tr>
        <td class="configthin"><!--LANG::best_press_lang-->:</td>
        <td class="configthin"><b><!--TEXT::best_press_lang--></b> <!--LANG::with--> <b><!--TEXT::best_press_lang_num--></b> <!--LANG::press_reports--></td>
    </tr>
<!--ENDIF-->
</table>
<!--section-end::main-->
