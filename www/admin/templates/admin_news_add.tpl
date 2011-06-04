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
                <select class="third" name="cat_id">'
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
                <input class="full" maxlength="255" id="news_title" name="title" value="<!--TEXT::title-->"><br><br>
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
        
        
        
        
        
        
        <tr>
            <td colspan="2">
                <input type="button" onClick='open_fullscreenpopup( "admin_news_prev.php?i=".$linkid )' value="<!--COMMON::preview-->">
                
                 <input type="submit" name="dolinkbutton" value="text">
                 <input type="submit" name="addlink" value="auch">
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


<!--section-start::script-->
<script type="text/javascript">
    jQuery(document).ready(function(){
        $("tr.pointer").hover(
            function () {
                $(this).css("background-color", "#EEEEEE");
            },
            function () {
                $(this).css("background-color", "transparent");
            }
        );
        $("tr.pointer").click(
            function () {
                $(opener.document).find("#username").val( $(this).find("span:first").text() );
                $(opener.document).find("#userid").val( $(this).find("input:hidden").val() );
                self.close();
            }
        );
    });
</script>
<!--section-end::script-->
