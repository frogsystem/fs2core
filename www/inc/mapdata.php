<?php 
include("config.inc.php");
include("functions.php");

////////////////////////
//// Daten einfügen ////
////////////////////////

if ($_POST[action] == "input")
{
    $_POST[username] = savesql($_POST[username]);
    $_POST[ort] = savesql($_POST[ort]);
    settype($_POST[posx], 'integer');
    settype($_POST[posy], 'integer');
    settype($_POST[landid], 'integer');

    mysql_query("INSERT INTO fs_cmap_user (land_id, user_name, x_pos, y_pos, user_ort)
                 VALUES ('".$_POST[landid]."',
                         '".$_POST[username]."',
                         '".$_POST[posx]."',
                         '".$_POST[posy]."',
                         '".$_POST[ort]."');", $db);
}

////////////////////////
////// Daten lesen /////
////////////////////////

if ($_POST['action'] == "getit")
{
    settype($_POST[landid], 'integer');

  $landid = $_POST[landid];

  $userindex = mysql_query("select user_name from fs_cmap_user where land_id = $landid order by user_name");
  $i = 0;
  while($row = mysql_fetch_array($userindex))
  {
    $usersname[$i] = $row['user_name'];
    $i++;
  }
  $userindex = mysql_query("select user_ort from fs_cmap_user where land_id = $landid order by user_name");
  $i = 0;
  while($row = mysql_fetch_array($userindex))
  {
    $usersort[$i] = $row['user_ort'];
    $i++;
  }
  $userindex = mysql_query("select x_pos from fs_cmap_user where land_id = $landid order by user_name");
  $i = 0;
  while($row = mysql_fetch_array($userindex))
  {
    $usersxpos[$i] = $row['x_pos'];
    $i++;
  }
  $userindex = mysql_query("select y_pos from fs_cmap_user where land_id = $landid order by user_name");
  $i = 0;
  while($row = mysql_fetch_array($userindex))
  {
    $usersypos[$i] = $row['y_pos'];
    $i++;
  }
 
  $usersname = urlencode(implode($usersname, "|:|"));
  $usersort = urlencode(implode($usersort, "|:|"));
  $usersxpos = urlencode(utf8_encode(implode($usersxpos, "|:|")));
  $usersypos = urlencode(utf8_encode(implode($usersypos, "|:|")));

  echo "&namess=".$usersname; 
  echo "&orts=".$usersort; 
  echo "&xposs=".$usersxpos; 
  echo "&yposs=".$usersypos; 
  echo "&dump="; 
}

mysql_close($db);
?> 