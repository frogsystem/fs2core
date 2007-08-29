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
    $filter = savesql($_POST[filter]);
    $_POST[filter] = killhtml($_POST[filter]);

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
                    <form action="" method="post">
                        <input type="hidden" value="statref" name="go">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" colspan="2">
                                    Zeige
                                    <input name="limit" size="4" class="text" value="'.$_POST[limit].'">
                                    Einträge sortiert nach 
                                    <select name="order">
                                        <option value="u" '.$usel.'>URL</option>
                                        <option value="d" '.$dsel.'>Datum</option>
                                        <option value="c" '.$csel.'>Counter</option>
                                    </select>
                                    &nbsp;Filter: <input name="filter" size="35" class="text" value="'.$_POST[filter].'">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <font style="font-size:7pt;">Setzte im Filter ein ! an erster Stelle um den Suchbegriff komplett auszuschließen.<br />Mehrere Suchbegriffe können mit , oder Leerzeichen getrennt werden.</font>
                                </td>
                                <td align="right">
                                    <input type="submit" value="Anzeigen" class="button">
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

    $filter = str_replace(" ",",",$filter);
    $filterarray = explode(",", $filter);

    $query = "";
    $and_query = "";
    $or_query = "";

    $first_and = true;
    $first_or = true;
    foreach ($filterarray as $string)
    {
        if (substr($string, 0, 1) == "!" AND substr($string, 1) != "")
        {
            $like = "ref_url NOT LIKE";
            $string = substr($string, 1);
            if (!$first_and)
            {
                $and_query .= " AND ";
            }
            $and_query .= $like . " '%" . $string . "%'";
            $first_and = false;
        }
        elseif (substr($string, 0, 1) != "!" AND $string != "")
        {
            $like = "ref_url LIKE";
            if (!$first_or)
            {
                $or_query .= " OR ";
            }
            $or_query .= $like . " '%" . $string . "%'";
            $first_or = false;
        }
        $i++;
    }
    
    if ($or_query!="") {
        $or_query = "(".$or_query.")";
        if ($and_query!="") {
            $and_query = " AND ".$and_query;
        }
    }
    
    if ($or_query != "" OR $and_query != "") {
        $query = " WHERE ";
    }
    $query .= $or_query . $and_query;

    switch ($order)
    {
        case "u":
            $query .=  " ORDER BY ref_url LIMIT " . $_POST[limit];
            break;
        case "c":
            $query .=  " ORDER BY ref_count DESC LIMIT " . $_POST[limit];
            break;
        default:
            $query .=  " ORDER BY ref_date DESC LIMIT " . $_POST[limit];
            break;
    }

    $index = mysql_query("SELECT * FROM fs_counter_ref $query", $db);
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
                    <form action="" method="post">
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