<?php
echo '<script type="text/javascript">
      function cimgdel (file)
      {
        var Check = confirm("Soll das Bild wirklich gelöscht werden?");
        if (Check == true)
          location.href = "?go=cimgdel&unlink=" + file;
      }
      </script>';

if (isset($_GET['unlink']))
{
  unlink("../images/content/".$_GET['unlink']);
  systext("Das Bild \"".$_GET['unlink']."\" wurde gelöscht!");
}

$ordner=opendir("../images/content"); // gib hier den gewünschten pfad an

while(($datei=readdir($ordner))!== false)
{
  if($datei!="." && $datei!="..")
  {
    $bildnamen[] = $datei;
  }
}

echo '   <table border="0" cellpadding="4" cellspacing="0" width="600">';

if (count($bildnamen)!=0)
{
  sort($bildnamen);
  foreach ($bildnamen as $datei)
  {
    echo '<tr align="left" valign="top">
             <td class="config" width="50%">
               '.$datei.' <font class="small">(<a href="../images/content/'.$datei.'" target="_blank">ansehen</a>)</font>
             </td>
             <td class="config" width="50%">
             <input onClick="cimgdel(\''.$datei.'\')"06.09.2006 class="button" type="button" value="Löschen">
             </td>
           </tr>';
  }
}
else
{
  systext("Es wurden keine weiteren Bilder gefunden!");
}

echo '</table>';



?>