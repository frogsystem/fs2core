<?php
include("config.inc.php");
include("functions.php");
include("adminfunctions.php");

echo'
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <title>Frog System - Frogpad</title>
    <link rel="stylesheet" type="text/css" href="admin.css">
    <style>
        #shadow
        {
            background-color:#575757;
            width:900px;
            height:660px;
            position:absolute;
            left:50%;
            top:50%;
            margin-left:-449px;
            margin-top:-329px;
        }
        #mainpad
        {
            position:relative;
            padding-left:20px;
            top:-2px;
            left:-2px;
            width:900px;
            height:660px;
            background-color:#EEEEEE;
            border:1px solid black;
        }
    </style>
    <script>
        <!--
        function fill()
        {
            what = opener.document.getElementsByName("editwhat")[0].value;
            document.getElementsByName("code")[0].value = opener.document.getElementsByName(what)[0].value;
        }
        function send()
        {
            what = opener.document.getElementsByName("editwhat")[0].value;
            opener.document.getElementsByName(what)[0].value = document.getElementsByName("code")[0].value;
            self.close();
        }
        // -->
    </script>
</head>
<body onLoad="fill()">
    <div id="shadow">
        <div id="mainpad">
            <img border="0" src="img/pointer.gif" alt="">
            <font style="font-size:8pt;"><b>FROGPAD</b></font><p>
            <textarea name="code" style="font-family:monospace; overflow:auto;" cols="122" rows="38"></textarea>
            <input type="button" class="button" value="Ändern" onClick="send();">
            <input type="button" class="button" value="Abbrechen" onClick="javascript:self.close()">
        </div>
    </div>
</body>
</html>
';

?>