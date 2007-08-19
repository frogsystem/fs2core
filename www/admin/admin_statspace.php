<?php

/////////////////////////
//// Grafik ausgeben ////
/////////////////////////

if (isset($_GET[size]))
{
    disk_free_space($_SERVER[DOCUMENT_ROOT]);
    disk_total_space($_SERVER[DOCUMENT_ROOT]);

    define(XRADIUS, 120);
    define(YRADIUS, 60);
    define(XMITTELPUNKT, 70);
    define(YMITTELPUNKT, 50);
    define(DICKE, 20);
    define(SPACE, 1073741824);  // Verfügbarer Platz in Byte (1GB = 1073741824)

    $winkel = 90- ($_GET[size] / SPACE * 360);

    $image = imagecreate(600,100);
    $farbe_weiß = imagecolorallocate($image, 0xEE, 0xEE, 0xEE);
    $farbe_grau = imagecolorallocate($image, 0xCC, 0xCC, 0xCC);
    $farbe_gruen = imagecolorallocate($image, 0xAA, 0xFF, 0xAA);
    $farbe_rot = imagecolorallocate($image, 0xFF, 0x66, 0x66);
    $farbe_schwarz= imagecolorallocate($image,0,0,0);

    imagefilledarc ($image, XMITTELPUNKT, YMITTELPUNKT, XRADIUS, YRADIUS, 90, $winkel, $farbe_gruen, IMG_ARC_EDGED);
    imagefilledarc ($image, XMITTELPUNKT, YMITTELPUNKT, XRADIUS, YRADIUS, 90, $winkel, $farbe_schwarz, IMG_ARC_NOFILL);

    imagefilledarc ($image, XMITTELPUNKT, YMITTELPUNKT, XRADIUS, YRADIUS, $winkel, 90, $farbe_rot, IMG_ARC_EDGED);
    imagefilledarc ($image, XMITTELPUNKT, YMITTELPUNKT, XRADIUS, YRADIUS, $winkel, 90, $farbe_schwarz, IMG_ARC_NOFILL);

    for ($i=1; $i<DICKE+1; $i++)
    {
        imagefilledarc ($image, XMITTELPUNKT, YMITTELPUNKT-$i, XRADIUS, YRADIUS, 90, $winkel, $farbe_gruen, IMG_ARC_EDGED);

        imagefilledarc ($image, XMITTELPUNKT, YMITTELPUNKT-$i, XRADIUS, YRADIUS, $winkel, 90, $farbe_rot, IMG_ARC_EDGED);
    }

    imagefilledarc ($image, XMITTELPUNKT, YMITTELPUNKT-DICKE, XRADIUS, YRADIUS, 90, $winkel, $farbe_gruen, IMG_ARC_EDGED);
    imagefilledarc ($image, XMITTELPUNKT, YMITTELPUNKT-DICKE, XRADIUS, YRADIUS, 90, $winkel, $farbe_schwarz, IMG_ARC_NOFILL);

    imagefilledarc ($image, XMITTELPUNKT, YMITTELPUNKT-DICKE, XRADIUS, YRADIUS, $winkel, 90, $farbe_rot, IMG_ARC_EDGED);
    imagefilledarc ($image, XMITTELPUNKT, YMITTELPUNKT-DICKE, XRADIUS, YRADIUS, $winkel, 90, $farbe_schwarz, IMG_ARC_NOFILL);

    imageline($image,XMITTELPUNKT-XRADIUS/2,YMITTELPUNKT+3,XMITTELPUNKT-XRADIUS/2,YMITTELPUNKT-DICKE,$farbe_schwarz);
    imageline($image,XMITTELPUNKT+XRADIUS/2,YMITTELPUNKT+3,XMITTELPUNKT+XRADIUS/2,YMITTELPUNKT-DICKE,$farbe_schwarz);

    // Texte
    imagefilledrectangle($image, 160, 5, 175, 20, $farbe_gruen);
    imagestring ($image, 2, 180, 6, "freier Speicherplatz (".getsize((SPACE-$size)/1024).")", $farbe_schwarz);

    imagefilledrectangle($image, 160, 35, 175, 50, $farbe_rot);
    imagestring ($image, 2, 180, 36, "belegter Speicherplatz (".getsize($size/1024).")", $farbe_schwarz);

    // Bildausgabe
    imagepng($image); 
}

/////////////////////////
///// Liste ausgeben ////
/////////////////////////

elseif ($_SESSION[user_level] == "authorised")
{

function list_dir (&$files, $dirname, $dirs=NULL, $ebene=-1)
{
    $dir  = opendir($dirname); 
    $size = 0; 
    while($file = readdir($dir))
    {
        if ($file != '.' && $file != '..')
        {
            if (is_dir($dirname . '/' . $file))
            {
                $datei[ebene] = $ebene + 1;
                $datei[type] = "dir";
                $datei[name] = $file;
                $datei[type] = @in_array($file, $dirs) ? "diropen" : "dirclose";
                $files[] = $datei;
                if (@in_array($file, $dirs) || !$dirs)
                {
                    $size += list_dir (&$files, $dirname . '/' . $file, $dirs, $datei[ebene]);
                }
            }
            else
            {
                $datei[ebene] = $ebene + 1;
                $datei[type] = "file";
                $datei[name] = $file;
                $datei[size] = filesize($dirname . '/' . $file);
                $files[] = $datei;
                $size += $datei[size];
            }
        }
    }
    closedir($dir); 
    return $size;
}

    // Gesamt Größe errechnen
    $files = array();
    $size = list_dir($files, $_SERVER[DOCUMENT_ROOT]);

    // Verzeichnis schließen
    if ($_POST[closedir] != "")
    {
        $wo = array_search($_POST[closedir], $_POST[dirs]);
        $_POST[dirs][$wo] = "";
        $_POST[dirs] = array_unique( $_POST[dirs]); 
    }

    // Ausgabe beginnen
    echo'
                    <img border="0" src="admin_statspace.php?size='.$size.'" alt="">
                    <p>
                    <form id="form1" action="'.$PHP_SELF.'" method="post">
                        <input type="hidden" value="statspace" name="go">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <input type="hidden" id="closedir" value="" name="closedir">
                        <input type="hidden" id="newdir" value="" name="dirs[]">
    ';
    if (isset($_POST[dirs]))
    {
        foreach ($_POST[dirs] as $dir)
        {
            echo'
                        <input type="hidden" value="'.$dir.'" name="dirs[]">
            ';
        }
    }
    else
    {
        $_POST[dirs][0] = ".";
    }
    echo'
                        <table border="0" cellpadding="2" cellspacing="1" width="500">
                            <tr style="background-color:#BBBBBB;">
                                <td align="center" class="menu"><b>Name</b></td>
                                <td align="center" class="menu"><b>Größe</b></td>
                            </tr>
    ';

    // Offene Verzeichnisse lesen
    $files = array();
    $size = list_dir($files, $_SERVER[DOCUMENT_ROOT], $_POST[dirs]);


    // Dateien Auflisten
    foreach ($files as $file)
    {
    $count += 1;
        if ($file[size] > 1024*1024)
        {
            $color = "ff6666";
        }
        elseif ($count % 2 == 0)
        {
            $color = "DDDDDD";
        }
        else
        {
            $color = "CCCCCC";
        }
        if ($file[type] == "diropen")
        {
            echo'
                            <tr style="background-color:#'.$color.';">
                                <td align="left" class="menu" style="padding-left:'.(5+$file[ebene]*20).'px;">
                                    <img border="0" src="../images/design/dl_ordner_offen.gif" alt="" style="cursor:pointer;"
                                         onClick="javascript:document.getElementById(\'closedir\').value=\''.$file[name].'\';
                                                             document.getElementById(\'form1\').submit();">
                                    '.$file[name].'
                                </td>
                                <td></td>
                            </tr>
            ';
        }
        elseif ($file[type] == "dirclose")
        {
            echo'
                            <tr style="background-color:#'.$color.';">
                                <td align="left" class="menu" style="padding-left:'.(5+$file[ebene]*20).'px;">
                                    <img border="0" src="../images/design/dl_ordner.gif" alt="" style="cursor:pointer;"
                                         onClick="javascript:document.getElementById(\'newdir\').value=\''.$file[name].'\';
                                                             document.getElementById(\'form1\').submit();">
                                    '.$file[name].'
                                </td>
                                <td></td>
                            </tr>
            ';
        }
        else
        {
            echo'
                            <tr style="background-color:#'.$color.';">
                                <td align="left" class="menu" style="padding-left:'.(5+$file[ebene]*20).'px;">
                                    <img border="0" src="../images/design/dl_file.gif" alt="">
                                    '.$file[name].'
                                </td>
                                <td align="right" class="menu">'.getsize($file[size]/1024).'</td>
                            </tr>
            ';
        }
    }

    echo '
                            <tr style="background-color:#BBBBBB;">
                                <td></td>
                                <td align="right" class="menu"><b>'.getsize($size/1024).'</b></td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>