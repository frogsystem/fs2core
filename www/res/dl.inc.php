<?php

// Download
if ($_GET[fileid] && $_GET[dl])
{
    //Config einlesen
    $index = mysql_query("select * from fs_dl_config", $db);
    $dl_config_arr = mysql_fetch_assoc($index);
    
    //Is Mirror?
    $index = mysql_query("select file_is_mirror from fs_dl_files where file_id = '$_GET[fileid]'", $db);
    $check_file_is_mirror = mysql_result($index, 0, "file_is_mirror");

    if ($dl_config_arr[dl_rights] == 2
        OR ($dl_config_arr[dl_rights] == 1 AND $_SESSION[user_level] == "loggedin")
        OR $check_file_is_mirror == 1)
    {
      settype($_GET[fileid], 'integer');
      $index = mysql_query("select * from fs_dl_files where file_id = $_GET[fileid]", $db);
      $file = mysql_fetch_array($index);
      mysql_query("update fs_dl_files set file_count=file_count+1 where file_id = $file[file_id]", $db);
      header('Location: '.$file[file_url]);
    }
    else
    {
      header('Location: ?go=403');
    }


}
?>