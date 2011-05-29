<!--section-start::main--> 
<table class="content" cellpadding="3" cellspacing="0">
    <tr><td colspan="3"><h3><!--LANG::select_file--></h3><hr></td></tr>
    <tr>
        <td colspan="3" class="thin">
            <!--TEXT::connection_ok-->
        </td>
    </tr>
    <tr class="thin">
        <td>
            <!--COMMON::checkbox-->
            <input class="hidden" type="checkbox" id="size" value="1" checked>
        </td>                        
        <td colspan="2" class="middle">
            &nbsp;<label for="size"><!--LANG::send_file_size--></label>
        </td>
    </tr>
    <tr>
        <td width="40"></td><td width="100%"></td><td width="60"></td>
    </tr>  
    <tr>
        <td colspan="2">
            <!--LANG::path-->: <!--TEXT::url_links-->
        </td>
        <td>
            <!--LANG::file_size-->
        </td>
    </tr>
    
    <tr class="pointer thin" style="cursor:default !important;">
        <td class="center"><img src="icons/folder.gif" alt="[<!--COMMON::folder-->]"></td>
        <td colspan="2">
            &nbsp;<a href="<!--TEXT::up_url-->">[<!--LANG::up-->]</a>
        </td>
    </tr>
    <tr>
        <td colspan="3"></td>
    </tr>
                       
    <!--TEXT::lines-->
</table>
<!--section-end::main-->

<!--section-start::folder--> 
    <tr class="pointer thin" style="cursor:default !important;">
        <td class="center"><img src="icons/folder.gif" alt="[<!--COMMON::folder-->]"></td>
        <td>
            &nbsp;<a href="<!--TEXT::folder_url-->" title="<!--LANG::change_dir-->"><!--TEXT::folder_name--></a>
            <input class="url" type="hidden" value="<!--TEXT::http_url-->">
            <input class="size" type="hidden" value="0">
        </td>
        <td>
            <span class="folder link small" title="<!--LANG::get_folderpath-->">(<!--COMMON::select-->)</span>
        </td>
    </tr>
    
<!--section-end::folder-->

<!--section-start::file--> 
    <tr class="pointer file thin" title="<!--LANG::get_filepath-->">
        <td class="center"><img src="icons/file.gif" alt="[<!--COMMON::file-->]"></td>
        <td>
            &nbsp;<!--TEXT::file_name-->
            <input class="url" type="hidden" value="<!--TEXT::http_url-->">
            <input class="size" type="hidden" value="<!--TEXT::size-->">
        </td>
        <td>
        <!--TEXT::size--> <!--COMMON::kib--> 
        </td>
    </tr>
    
<!--section-end::file-->

<!--section-start::no_conn--> 
<table class="content" cellpadding="0" cellspacing="0">
    <tr><td><h3><!--LANG::select_file--></h3><hr></td></tr>
    <tr>
        <td class="center thin">
            <!--LANG::no_connection-->
        </td>
    </tr>
</table>
<!--section-end::no_conn-->

<!--section-start::conn_error--> 
<table class="content" cellpadding="0" cellspacing="0">
    <tr><td><h3><!--LANG::select_file--></h3><hr></td></tr>
    <tr>
        <td class="thin">
            <!--LANG::connection_error--><br>
            <!--TEXT::connection_error_text-->
        </td>
    </tr>
</table>
<!--section-end::conn_error-->

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

            $("tr.pointer.file").click(
                function () {
                    $(opener.document).find("#furl<!--TEXT::file_id-->").val( $(this).find("input:hidden.url").val() );
                    
                    if($("#size:checked").length >= 1) {
                        $(opener.document).find("#fsize<!--TEXT::file_id-->").val( $(this).find("input:hidden.size").val() );
                    }
                    
                    self.close();
                }
            );
            
            $("tr.pointer span.folder").click(
                function () {
                    $(opener.document).find("#furl<!--TEXT::file_id-->").val( $(this).parents("tr.pointer").find("input:hidden.url").val() );
                    
                    if($("#size:checked").length >= 1) {
                        $(opener.document).find("#fsize<!--TEXT::file_id-->").val( $(this).parents("tr.pointer").find("input:hidden.size").val() );
                    }                    
                    
                    self.close();               
                }
            );
        });
</script>
<!--section-end::script-->
