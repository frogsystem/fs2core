<?php

//////////////////////////
//// Referrer Löschen ////
//////////////////////////

if ($_POST[tage] && $_POST[hits])
{
    settype($_POST[tage], "integer");
    settype($_POST[hits], "integer");
    if ($_POST[tage] < 2)
    {
        systext("Es können nicht weniger als 2 Tage angegeben werden");
    }
    else
    {
        $deldate = time() - ($_POST[tage] * 86400);
        mysql_query("DELETE FROM fs_counter_ref
                     WHERE ref_date < '$deldate' AND
                           ref_count < '$_POST[hits]'", $db);
        systext("Alle Einträge älter als $_POST[tage] Tage und mit weniger als $_POST[hits] Hits wurden gelöscht<br>Dies betraf ".mysql_affected_rows()." Datensätze");
    }
}

//////////////////////////
/// Referrer anzeigen ////
//////////////////////////

else
{
    if (!isset($_POST[limit]))
    {
        $_POST[limit] = 50;
    }

    settype($_POST[limit], 'integer');
    $_POST[filter] = savesql($_POST[filter]);

    switch ($_POST[order])
    {
        case "u":
            $usel = "selected";
            break;
        case "c":
            $csel = "selected";
            break;
        default:
            $dsel = "selected";
            break;
    }

    echo'
                    <form action="'.$PHP_SELF.'" method="post">
                        <input type="hidden" value="statref" name="go">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="4" cellspacing="0">
                            <tr>
                                <td class="config">
                                    Zeige
                                    <input name="limit" size="4" class="text" value="'.$_POST[limit].'">
                                    Einträge sortiert nach 
                                    <select name="order">
                                        <option value="u" '.$usel.'>URL</option>
                                        <option value="d" '.$dsel.'>Datum</option>
                                        <option value="c" '.$csel.'>Counter</option>
                                    </select>
                                    ( Filter:
                                    <input name="filter" size="10" class="text" value="'.$_POST[filter].'">
                                    )
                                    <input type="submit" value="Anzeigen" class="button">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <font style="font-size:7pt;">Setzte im Filter ein ! an erster Stelle um den Suchbegriff auszuschließen.</font>
                                </td>
                            </tr>
                        </table>
                    </form>
                    <table width="600" align="center" border="1" cellpadding="1" cellspacing="0" style="border-collapse: collapse" bordercolor="#000000">
                        <tr>
                            <td class="h" align="center" colspan="4">
                                <b>Referrer von externen Seiten</b>
                            </td>
                        </tr>
                        <tr>
                            <td class="h" align="center">
                                <b>Referrer URL</b>
                            </td>
                            <td class="h" align="center">
                                <b>Counter</b>
                            </td>
                            <td class="h" align="center">
                                <b>Erstkontakt</b>
                            </td>
                        </tr>
    ';

    $filter = str_replace(" ","",$filter);
    $filterarray = explode(",", $filter);

    foreach ($filterarray as $string)
    {
        if (substr($string, 0, 1) == "!")
        {
            $like = " ref_url NOT LIKE";
            $string = substr($string, 1);
            if ($i > 0)
            {
                $query .= " AND";
            }
        }
        else
        {
            $like = " ref_url LIKE";
            if ($i > 0)
            {
                $query .= " OR";
            }
        }
        $query .= $like . " '%" . $string . "%'";
    }

    switch ($order)
    {
        case "u":
            $query .=  " order by ref_url LIMIT " . $_POST[limit];
            break;
        case "c":
            $query .=  " order by ref_count desc LIMIT " . $_POST[limit];
            break;
        default:
            $query .=  " order by ref_date desc LIMIT " . $_POST[limit];
            break;
    }

    $index = mysql_query("select * from fs_counter_ref where $query", $db);
    while ($referrer_arr = mysql_fetch_assoc($index))
    {
        $dburlfull = $referrer_arr[ref_url];
        if (strlen($referrer_arr[ref_url]) > 60)
        {
            $referrer_arr[ref_url] = substr($referrer_arr[ref_url],0, 60) . "...";
        }
        $referrer_arr[ref_date] = date("d.m.Y H:i", $referrer_arr[ref_date]);
        if($referrer_arr[ref_url] == "")
        {
            echo'
                        <tr>
                            <td class="n" align="left">
                                Unbekannt
                            </td>
                            <td class="n" align="center">
                                '.$referrer_arr[ref_count].'
                            </td>
                            <td class="n" align="center">
                                '.$referrer_arr[ref_date].'
                            </td>
                        </tr>
            ';
        }
        else
        {
            echo'
                        <tr>
                            <td class="n" align="left">
                                <a href="'.$dburlfull.'" style="text-decoration:none;" target="_blank" title="'.$dburlfull.'">
                                   '.$referrer_arr[ref_url].'
                                </a>
                            </td>
                            <td class="n" align="center">
                                '.$referrer_arr[ref_count].'
                            </td>
                            <td class="n" align="center">
                                '.$referrer_arr[ref_date].'
                            </td>
                        </tr>
            ';
        }
    }

    echo'
                    </table>
                    <p>
                    <form action="'.$PHP_SELF.'" method="post">
                        <input type="hidden" value="statref" name="go">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="2" cellspacing="0" width="600">
                            <tr>
                                <td align="center" class="configthin" width="50%">
                                    Einträge älter als 
                                    <input class="text" name="tage" size="3" value="5">
                                    Tage und weniger als
                                    <input class="text" name="hits" size="3" value="3">
                                    Hits
                                    <input class="button" type="submit" value="entfernen">
                                </td>
                            </tr>
                        </table>
                    </form>
                    <p>
    ';
}
?>