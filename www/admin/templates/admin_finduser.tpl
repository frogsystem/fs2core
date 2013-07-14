<!--section-start::main-->
<table class="content config" cellpadding="0" cellspacing="0">
    <tr><td><h3><!--LANG::select_user--></h3><hr></td></tr>

    <!--TEXT::lines-->
</table>
<!--section-end::main-->

<!--section-start::line-->
    <tr class="pointer thin">
        <td>
            &nbsp;&raquo; <span><!--TEXT::user--></span>
            <input type="hidden" value="<!--TEXT::user_id-->">
        </td>
    </tr>

<!--section-end::line-->

<!--section-start::no-->
<table class="content" cellpadding="0" cellspacing="0">
    <tr><td><h3><!--LANG::select_user--></h3><hr></td></tr>
    <tr>
        <td class="center thin">
            <!--LANG::no_users_found-->
        </td>
    </tr>
</table>
<!--section-end::no-->

<!--section-start::search-->
<form action="" method="post">
    <table class="content" cellpadding="0" cellspacing="0">
        <tr>
            <td class="center">
                <input value="<!--TEXT::filter-->" name="filter" size="30">
                <input type="submit" value="<!--COMMON::search_button-->">
            </td>
        </tr>
    </table>
</form>
<!--section-end::search-->

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
                $(opener.document).find("#<!--TEXT::name-->").val( $(this).find("span:first").text() );
                $(opener.document).find("#<!--TEXT::id-->").val( $(this).find("input:hidden").val() );
                self.close();
            }
        );
    });
</script>
<!--section-end::script-->
