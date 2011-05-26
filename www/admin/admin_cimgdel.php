<?php
echo '<script type="text/javascript">
      function cimgdel (file)
      {
        var Check = confirm("Soll das Bild wirklich gelöscht werden?");
        if (Check == true)
          location.href = "?go=cimg_admin&unlink=" + file + "'.$session_url.'";
      }
      </script>';

if (isset($_GET['unlink']) && $_SESSION['cimg_admin'] == 1 )
{
  unlink("../images/content/".$_GET['unlink']);
  systext("Das Bild \"".$_GET['unlink']."\" wurde gelöscht!");
}

$ordner=opendir("../images/content"); // gib hier den gewünschten pfad an

$ext_arr[] = ".jpg";
$ext_arr[] = ".jpeg";
$ext_arr[] = ".gif";
$ext_arr[] = ".png";
$ext_arr[] = ".JPG";
$ext_arr[] = ".JPEG";
$ext_arr[] = ".GIF";
$ext_arr[] = ".PNG";

while(($datei=readdir($ordner))!== false)
{
  $extension = substr($datei, strrpos($datei, "."));
  if($datei!="." AND $datei!=".." AND in_array($extension,$ext_arr))
  {
    $bildnamen[] = $datei;
  }
}



if (count($bildnamen)!=0)
{
echo '
                        <table class="content" cellpadding="3" cellspacing="0">
                            <tr><td colspan="2"><h3>Inhaltsbilder</h3><hr></td></tr>
';    
    
  sort($bildnamen);
  foreach ($bildnamen as $datei)
  {
    echo '<tr class="left middle" valign="middle">
             <td width="100%">
               '.$datei.' <font class="small">(<a href="../images/content/'.$datei.'" target="_blank">ansehen</a>)</font>
             </td>
             <td>
                <input onClick="cimgdel(\''.$datei.'\')" type="button" value="Löschen">
             </td>
           </tr>';
  }

echo '</table>';
}
else
{
    echo '
        <table class="content" cellpadding="3" cellspacing="0">
            <tr><td><h3>Inhaltsbilder</h3><hr></td></tr>
            <tr><td>Es wurden keine weiteren Bilder gefunden!</td></tr>
        </table>                  
    ';
}



?>
