<!--section-start::main-->
<table class="content config" cellpadding="0" cellspacing="0">
    <tr><td><h3><!--LANG::select_applet--></h3><hr></td></tr>

    <!--TEXT::lines-->
</table>
<!--section-end::main-->

<!--section-start::line-->
    <tr class="pointer thin">
        <td>
            &nbsp;&raquo; <!--TEXT::file-->
            <input type="hidden" value="<!--TEXT::filename-->">
        </td>
    </tr>

<!--section-end::line-->

<!--section-start::no-->
<table class="content" cellpadding="0" cellspacing="0">
    <tr><td><h3><!--LANG::select_applet--></h3><hr></td></tr>
    <tr>
        <td class="center thin">
            <!--LANG::no_applets_found-->
        </td>
    </tr>
</table>
<!--section-end::no-->

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
                $(opener.document).find("#applet_file").val( $(this).find("input:hidden").val() );
                self.close();
            }
        );
    });
</script>
<!--section-end::script-->
