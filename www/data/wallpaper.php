<?php # aoe3settlers.de ^ CMS-Version 1.0 ^ Erweiterung: Wallpaperbereich
# modifiziert für the-witcher.de

    if (!isset($_GET['page']))
    {$_GET['page']=1;}

    $oldpage = $_GET['page']-1;
    $newpage = $_GET['page']+1;

    //Wieviele Wallpaper
    $data = mysql_query("select * from fsplus_wallpaper order by wallpaper_id ASC", $db);
    $number = mysql_num_rows($data);

    $limit = 12;
    $number_of_pages = ceil($number/$limit);

    $start = ($_GET['page']-1)*$limit;

    $index = mysql_query("select * from fsplus_wallpaper order by wallpaper_id DESC LIMIT $start,$limit", $db);
    while ($wallpaper_arr = mysql_fetch_assoc($index))
    {
        $wallpaper_arr[wallpaper_thumb] = "images/wallpaper/$wallpaper_arr[wallpaper_name]_s.jpg";

        $template = '
  <td align="center" valign="top"><img alt="" src="{thumbnail}" /><br /><br />
   <strong>Verfügbare Größen:</strong><br />
   - <a href="images/wallpaper/{name}_'.$wallpaper_arr[size1].'.jpg" target="_blank">'.$wallpaper_arr[size1].'</a>';
        if ($wallpaper_arr[size2] != "") $template .= '<br />
   - <a href="images/wallpaper/{name}_'.$wallpaper_arr[size2].'.jpg" target="_blank">'.$wallpaper_arr[size2].'</a>';
        if ($wallpaper_arr[size3] != "") $template .= '<br />
   - <a href="images/wallpaper/{name}_'.$wallpaper_arr[size3].'.jpg" target="_blank">'.$wallpaper_arr[size3].'</a>';
        if ($wallpaper_arr[size4] != "") $template .= '<br />
   - <a href="images/wallpaper/{name}_'.$wallpaper_arr[size4].'.jpg" target="_blank">'.$wallpaper_arr[size4].'</a>';
        if ($wallpaper_arr[size5] != "") $template .= '<br />
   - <a href="images/wallpaper/{name}_'.$wallpaper_arr[size5].'.jpg" target="_blank">'.$wallpaper_arr[size5].'</a>';
$template .= '<br /><br />
  </td>';

        $template = str_replace("{name}", $wallpaper_arr[wallpaper_name], $template);
        $template = str_replace("{thumbnail}", $wallpaper_arr[wallpaper_thumb], $template);
        
        $zaehler += 1;
        switch ($zaehler)
        {
            case 3:
                $zaehler = 0;
                $paper .= $template;
                $paper .= "</tr>";
                break;
            case 1:
                $paper .= "<tr>";
                $paper .= $template;
                break;
            default:
                $paper .= $template;
                break;
        }
    }
    unset($wallpaper_arr);

$template = '
<img src="images/design/null.gif" width="25px">
<b><img src="images/design/galerie.gif" alt="Bildergalerie"></b>
<br /><br />
<center>
<table cellpadding="0" cellspacing="0">
  <tr>
    <td rowspan="7" style="background-image: url(images/design/news/rahmen_vertikal_links.jpg); background-repeat: repeat-y; background-position: top left;" width="2px"></td>
    <td colspan="5" style="background-image: url(images/design/news/rahmen_oben_oben.jpg); background-repeat: repeat-x; background-position: top left;" height="2px"></td>
    <td rowspan="7" style="background-image: url(images/design/news/rahmen_vertikal_rechts.jpg); background-repeat: repeat-y; background-position: top left;" width="2px"></td>
  </tr>
  <tr>
    <td colspan="5" style="background-image: url(images/design/news/headline_bg.jpg); background-repeat: repeat; background-position: center;" height="10px"></td>
  </tr>
  <tr>
    <td rowspan="3" style="background-image: url(images/design/news/headline_bg.jpg); background-repeat: repeat; background-position: top left;" width="10px"></td>
    <td rowspan="3" style="background-image: url(images/design/news/rahmen_vertikal_rechts.jpg); background-repeat: repeat-y; background-position: top left;" width="2px"></td>
    <td style="background-image: url(images/design/news/rahmen_oben_unten.jpg); background-repeat: repeat-x; background-position: top left;" height="2px"></td>
    <td rowspan="3" style="background-image: url(images/design/news/rahmen_vertikal_links.jpg); background-repeat: repeat-y; background-position: top left;" width="2px"></td>
    <td rowspan="3" style="background-image: url(images/design/news/headline_bg.jpg); background-repeat: repeat; background-position: top left;" width="10px"></td>
  </tr>
  <tr>
    <td style="background-image: url(images/design/news/bg_dark.jpg); background-repeat: repeat; background-position: top left; padding: 5px 10px;" align="center" valign="top">

<table width="500px">
<tr align="center">
    <td>
        <a href="?go=screenshots&catid=1"><img src="images/design/screenshots.gif" alt="Screenshots"></a>
    </td>
    <td>
        <a href="?go=screenshots&catid=2"><img src="images/design/artworks.gif" alt="Artworks"></a>
    </td>
    <td>
        <a href="?go=screenshots&catid=4"><img src="images/design/gc2006.gif" alt="GC 2006"></a>
    </td>
    <td>
        <a href="?go=wallpaper"><img src="images/design/wallpaper2.gif" alt="Wallpaper"></a>
    </td>
</tr>
<tr align="center">
    <td colspan="4">
      <b>{zurück}</b>{page}<b>{vor}</b>
    </td>
</tr>
</table>

</td>
  </tr>
  <tr>
    <td style="background-image: url(images/design/news/rahmen_oben_oben.jpg); background-repeat: repeat-x; background-position: top left;" height="2px"></td>
  </tr>
  <tr>
    <td colspan="5" style="background-image: url(images/design/news/headline_bg.jpg); background-repeat: repeat; background-position: center;" height="10px"></td>
  </tr>
  <tr>
    <td colspan="5" style="background-image: url(images/design/news/rahmen_oben_unten.jpg); background-repeat: repeat-x; background-position: top left;" height="2px"></td>
  </tr>
</table>
</center>
<br />
<table border="0" cellpadding="0" cellspacing="10" width="100%">{wallpaper}</table>';

$template = str_replace("{wallpaper}", $paper, $template);
$template = str_replace("{page}", "Seite $_GET[page] von $number_of_pages", $template);
if ($_GET['page'] > 1)
   $template = str_replace("{zurück}", "<a href='?go=wallpaper&page=$oldpage'><< </a>", $template);
else
    $template = str_replace("{zurück}", "", $template);

if (($_GET['page']*$limit) < $number)
    $template = str_replace("{vor}", "<a href='?go=wallpaper&page=$newpage'> >></a>", $template);
else
    $template = str_replace("{vor}", "", $template);

echo $template;
unset($template);