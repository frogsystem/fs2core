<?php
// Start Session
session_start();

// fs2 include path
set_include_path ( '.' );
define ( FS2_ROOT_PATH, "./../", TRUE );

require( FS2_ROOT_PATH . "login.inc.php");
require( FS2_ROOT_PATH . "includes/functions.php");
require( FS2_ROOT_PATH . "includes/adminfunctions.php");
require( FS2_ROOT_PATH . "includes/templatefunctions.php");
require( FS2_ROOT_PATH . "phrases/admin_phrases_de.php");

settype ( $_GET['height'], "integer" );
$use_height = ( $_GET['height'] > 600 ) ? ($_GET['height'] - 250) : ($_GET['height'] - 325);

$dropdowns = get_dropdowns ( "frogpad" );

echo'
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <title>Frogsystem 2 - Template-Editor</title>
    <link rel="stylesheet" type="text/css" href="admin.css">
    <link rel="stylesheet" type="text/css" href="html-editor.css">
    <script src="../resources/jquery/jquery.tools.min.js" type="text/javascript"></script>
    <script src="../resources/codemirror/js/codemirror.js" type="text/javascript"></script>
    <script type="text/javascript">
        // Document Ready Functions
        $().ready(function(){
        
            //add hover class
            $(".html-editor-button").hover(
                function () {
                    $(this).addClass("html-editor-button-hover");
                },
                function () {
                    $(this).removeClass("html-editor-button-hover");
                }
            );
        });
    
        var change = window.setInterval("send()", 500);
        var sourceId = $("#section_select", opener.document).val();

        function fill() {
            //newheight = window.innerHeight-150;
            //$(".cs_text_content:first").css("height", newheight+"px");
            //$(".cs_text_content:first iframe").css("height", newheight-31+"px");

            eval ( "$(\"#"+sourceId+"_content\", opener.document).css(\"visibility\", \"hidden\")" );
            eval ( "$(\"#"+sourceId+"_editor-bar\", opener.document).css(\"visibility\", \"hidden\")" );
            eval ( "$(\"#"+sourceId+"_footer\", opener.document).css(\"visibility\", \"hidden\")" );
            eval ( "$(\"#"+sourceId+"_inedit\", opener.document).show()" );

            eval ( "var title = $(\"#"+sourceId+"_title\", opener.document).text()" );
            $("#frogpad_title").text( "Template-Editor - " + title );

            eval ( "var titleLine = $(\"#"+sourceId+"_editor-bar .html-editor-row-header\", opener.document).html()" );
            $(".html-editor-bar .html-editor-row-header").html(titleLine);

            eval ( "var tagLine = $(\"#"+sourceId+"_editor-bar .html-editor-container-list\", opener.document).html()" );
            var textWrapButton = $(".html-editor-bar .html-editor-row").html();
            if (tagLine!="") {
                tagLine = "<div class=\"html-editor-line\"></div><div class=\"html-editor-container-list\">"+tagLine+"</div>";
            }
            //$(".html-editor-bar .html-editor-row").html( ""+textWrapButton+""+""+tagLine+"" );

            eval ( "var footerLine = $(\"#"+sourceId+"_footer\", opener.document).html()" );
            $("#frogpad_footer").html(footerLine);

            var content = eval ( "opener.editor_"+sourceId+".getCode()" );
            frogpad.setCode ( content );
            frogpad.focus();
        }

        function send() {
            var new_content =  frogpad.getCode ();
            eval ( "opener.editor_"+sourceId+".setCode(new_content)" );
        }

        function close_window() {
            window.clearInterval(change);
            send();
            eval ( "$(\"#"+sourceId+"_content\", opener.document).css(\"visibility\", \"visible\")" );
            eval ( "$(\"#"+sourceId+"_editor-bar\", opener.document).css(\"visibility\", \"visible\")" );
            eval ( "$(\"#"+sourceId+"_footer\", opener.document).css(\"visibility\", \"visible\")" );
            eval ( "$(\"#"+sourceId+"_inedit\", opener.document).hide()" );
            eval ( "opener.editor_"+sourceId+".focus()" );
        }
    </script>
    <script src="functions.js" type="text/javascript"></script>
</head>
<body onLoad="fill();" onUnload="close_window();" id="find_body">

    '.get_content_container ( '
        <img src="img/pointer.png" alt="" style="vertical-align: text-top;" border="0">
        <span id="frogpad_title" style="font-weight:bold;">Template-Editor</span>
    ', '
        <div class="html-editor-bar">
            <div class="html-editor-row-header">
            </div>
            <div class="html-editor-row">
                <div class="html-editor-button html-editor-button-active html-editor-button-line-numbers" onClick="toggelLineNumbers(this,\'frogpad\')" title="Zeilen-Nummerierung">
                    <img src="img/null.gif" alt="Zeilen-Nummerierung" border="0">
                </div>
                '.$dropdowns['global_vars'].'
            </div>
        </div>
        
        <div style="background-color:#ffffff; border: 1px solid #999999; width:100%;">
            <textarea id="frogpad" class="codepress html" rows="50" cols="50" style="width:100%;"></textarea>
        </div>
        
        <div class="html-editor-path" id="frogpad_footer">
        </div>
        
        
        <table cellpadding="0" cellspacing="0" width="100%">
            <tr><td class="space"></td></tr>
            <tr>
                <td class="buttontd" align="right">
                    <button class="button_new" onClick="close_window(); self.close();">
                        '.$admin_phrases[common][arrow].' Schließen & übernehmen
                    </button>
                </td>
            </tr>
        </table>

    ', "margin-top:8px;" ).'

    <script type="text/javascript">
      var textarea = document.getElementById("frogpad");
      var frogpad = new CodeMirror(CodeMirror.replace("frogpad"), {
        parserfile: ["parsexml.js", "parsecss.js", "tokenizejavascript.js", "parsejavascript.js", "parsehtmlmixed.js"],
        stylesheet: ["../resources/codemirror/css/xmlcolors.css", "../resources/codemirror/css/jscolors.css", "../resources/codemirror/css/csscolors.css"],
        path: "../resources/codemirror/js/",
        continuousScanning: 500,
        lineNumbers: true,
        tabMode: "shift",
        height: "'.$use_height.'px"
      });
    </script>
    
</body>
</html>
';
?>