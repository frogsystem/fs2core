<?php
include("config.inc.php");
include("functions.php");
include("adminfunctions.php");

if (isset($_GET['page'])) {
	echo '<img border="0" src="img/pointer.gif" width="5" height="8" alt=""> <font style="font-size:8pt;"><b>'.$_GET['title'].'</b></font><div align="center">';
	include $_GET['page'];
	echo '</div>';
}

?>