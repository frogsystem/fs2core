<?php
include("../login.inc.php");
include("../includes/functions.php");
include("../includes/adminfunctions.php");

if ( isset ( $_GET['tpl'] ) ) {
	$_GET['tpl'] = savesql ( $_GET['tpl'] );
	$index = mysql_query ( "SELECT ".$_GET['tpl']." FROM ".$global_config_arr['pref']."template WHERE id = '0'", $db);
	$template = killhtml( mysql_result ( $index, 0 ) );
} else {
	$template = "";
}



echo'
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <title>Frogsystem 2 - Frogpad</title>
    <link rel="stylesheet" type="text/css" href="admin.css">
    <style>
      #pad_container
      {
          background-image:url(img/content_loop.jpg);
          background-repeat:repeat-y;
          width:698px;
          text-align:left;
          margin-top:5px;
      }
      #pad_padding
      {
          width:604px;
          padding-left:35px;
          padding-right:45px;
          text-align:left;
      }
      #pad_top
      {
          background-image:url(img/content_top.jpg);
          background-repeat:no-repeat;
          width:698px;
          height:27px;
          padding-left:19px;
          padding-top:18px;
          font-size:9pt;
          font-family:Verdana;
          color:#000000;
          font-weight:bold;
      }
      #pad_foot
      {
          background-image:url(img/content_foot.jpg);
          background-repeat:no-repeat;
          width:698px;
          height:53px;
      }
    </style>
</head>
<body id="find_body">
  <center><div id="pad_container">
    <div id="pad_top">
      <img border="0" src="img/pointer.png" alt="" align="top" />
      <font style="font-size:8pt;"><b>FROGPAD</b> - Originalansicht</font>
    </div>
    <div id="pad_padding">
      <textarea name="code" style="font-family:monospace; overflow:auto; width:600px; height:525px;">'.$template.'</textarea>
      <br /><br />
      <input type="button" class="button" value="Schließen" onClick="javascript:self.close()">
    </div>
    <div id="pad_foot"></div>
  </div></center>
</body>
</html>
';
?>