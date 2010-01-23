<?php
// Start Session
session_start();

// fs2 include path
set_include_path ( '.' );
define ( FS2_ROOT_PATH, "./../", TRUE );

require( FS2_ROOT_PATH . "login.inc.php");
require( FS2_ROOT_PATH . "includes/functions.php");
require( FS2_ROOT_PATH . "includes/adminfunctions.php");

echo'
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <title>Frogsystem 2 - Frogpad</title>
    <link rel="stylesheet" type="text/css" href="admin.css">
    <script src="../resources/jquery/jquery-1.4.min.js" type="text/javascript"></script>
    <script src="../resources/codemirror/js/codemirror.js" type="text/javascript"></script>
    <script type="text/javascript">
        var change = window.setInterval("send()", 500);
        var sourceId = $("#section_select", opener.document).val();
        
        function fill() {
            newheight = window.innerHeight-150;
            $(".cs_text_content:first").css("height", newheight+"px");
            $(".cs_text_content:first iframe").css("height", newheight-31+"px");

            eval ( "$(\"#"+sourceId+"_content\", opener.document).css(\"visibility\", \"hidden\")" );
            eval ( "$(\"#"+sourceId+"_editor-bar\", opener.document).css(\"visibility\", \"hidden\")" );
            eval ( "$(\"#"+sourceId+"_inedit\", opener.document).show()" );

            eval ( "var title = $(\"#"+sourceId+"_title\", opener.document).text()" );
            $("#frogpad_title").text( "Frogpad - " + title );

            var content = eval ( "opener.editor_"+sourceId+".getCode()" );
            frogpad.setCode ( content );
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
            eval ( "$(\"#"+sourceId+"_inedit\", opener.document).hide()" );
        }
    </script>
</head>
<body onLoad="fill();" onUnload="close_window();" id="find_body">

    '.get_content_container ( '
        <img src="img/pointer.png" alt="" style="vertical-align: text-top;" border="0">
        <span id="frogpad_title" style="font-weight:bold;">Frogpad</span>
    ', '
        <div id="frogpad_div" style="background-color:#ffffff; border: 1px solid black;">
            <textarea id="frogpad" class="codepress html autocomplete-off" style="width:100%; height:100%;">d</textarea>
        </div>
            <br>
            <input type="button" class="button" value="Schließen" onClick="close_window(); self.close();">
    ', "margin-top:8px;" ).'

    <script type="text/javascript">
      var frogpad = CodeMirror.fromTextArea("frogpad", {
        parserfile: "parsexml.js",
        stylesheet: "../resources/codemirror/css/xmlcolors.css",
        path: "../resources/codemirror/js/",
        continuousScanning: 500,
        lineNumbers: true,
        textWrapping: false,
        tabMode: "shift",
        width: "100%",
        height: "100%"
      });
    </script>
    
</body>
</html>
';
?>