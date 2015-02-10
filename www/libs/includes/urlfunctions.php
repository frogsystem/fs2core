<?php
////////////////////
//// create URL ////
////////////////////
function url ($go, $args = array(), $full = false, $safeargs = array()) {
    global $FD;

    switch ($FD->cfg('url_style')) {
        case 'seo':
            $url = url_seo($go, $args, false, $safeargs);
            break;

        default:
            // check for empty go
            if (!empty($go))
                $args = array('go' => $go)+$args+$safeargs;

            $url = http_build_query($args, 'p', '&amp;');
            if (!empty($url))
                $url = '?'.$url;
            break;
    }

    // create full url?
    if ($full)
        $url = $FD->cfg('virtualhost').$url;

    // return url
    return $url;
}


////////////////////////
//// create SEO URL ////
////////////////////////
function url_seo ($go, $args, $go_in_args = false, $safeargs = array()) {

	$urlencodeext = create_function ('$url', '
		// Folge von Bindestriche um zwei Striche erweitern
		return rawurlencode(preg_replace(\'/-+/\', \'$0--\', $url));');

    if ($go_in_args) {
        unset($args['go']);
    }

	$seourl = $urlencodeext($go);

	if (count($args) > 0)
	{
		$seourl .= '--';

		ksort($args);

		foreach ($args as $key => $val)
			$seourl .= $urlencodeext($key) . '-' . $urlencodeext($val) . '-';

		$seourl = substr($seourl, 0, strlen($seourl) - 1);
	}
    
    //trim ending hyphen
    if (substr($seourl, -1, 1) == '-' && substr($seourl, -2, 1) != '-')
		$seourl = substr($seourl, 0, -1);

	if (!empty($seourl))
		$seourl .= '.html';

    $safeargs = http_build_query($safeargs, 'p', '&amp;');
	if (!empty($safeargs))
        $seourl .= '?'.$safeargs;

    return $seourl;
}

////////////////////////////////////
//// parse query part of an url ////
////////////////////////////////////
function parse_url_query($query) {
    $query = explode('&', $query);

    $params = array();
    foreach ($query as $param) {
        $pair = explode('=', $param);
        $params[$pair[0]] = $pair[1];
    }

    return $params;
}





// fs2seourl Version 1.01 (27.08.2001)
function get_seo () {

    global $FD;

    // Anzahl der mittel ? übergegebenen Parameter speichern
    if (isset($_GET))
        $numparams = count($_GET);
    else
        $numparams = 0;

    $redirect = false;

    // Wurde dieser Skript direkt aufgrufen werden oder indirekt ueber mod_rewrite?
    $calledbyrewrite = isset($_SERVER['REDIRECT_QUERY_STRING']);

    // mod_rewrite schreibt in seoq den Dateinamen der fiktiven HTML-Datei (ohne die .html-Dateiendung).
    // Dieser Name muss nun zerlegt und in die Parameter uebersetzt werden, welche das FrogSystem erwaretet.
    if ((isset($_GET['seoq'])) && ($calledbyrewrite)) {
        // seoq wurde von mod_rewrite eingefuegt und ist daher kein echter Parameter
        $numparams--;

        // Drei oder mehr Bindestriche temporaer durch zwei weniger \x1 ersetzen, um sie von Seperatoren unterscheiden zu koennen
        $_GET['seoq'] = preg_replace_callback('/---+/', create_function('$matches', 'return str_repeat("\x1", strlen($matches[0]) - 2);'), $_GET['seoq']);

        $paramdelim = strpos($_GET['seoq'], '--');

        if ($numparams > 0 && isset($_GET['go'])) {
            //Wurden hinter das .html noch Parameter gepackt, sind diese massgeblich => Den Rest verwerfen und weiterleiten
            $redirect =	true;
        }
        else if ($paramdelim === false) {
            // Kein -- => Keine Parameter => Der komplette Dateiname ist der go-Parameter
            if (!isset($_GET['go']))
                $_GET['go'] = str_replace("\x1", '-', $_GET['seoq']);
        }
        else {
            // -- vorhanden => Alles davor ist der go-Parameter, alles dahinter sind weitere Parameter.
            // Diese muessen allerdings ein bestimmtes Format einhalten, ansonsten wird auf das richtige Format weitergeleitet

            if (!isset($_GET['go']))
                $_GET['go'] = substr($_GET['seoq'], 0, $paramdelim);

            $seoparamstr = substr($_GET['seoq'], $paramdelim + 2);

            // Hinter dem -- muss noch etwas kommen, sonst Weiterleitung
            if (strlen($seoparamstr) > 0)
            {
                $seoparams = explode('-', $seoparamstr);
                for ($i = 0; $i < count($seoparams); $i++)
                    $seoparams[$i] = str_replace("\x1", '-', $seoparams[$i]);

                // Die Anzahl der mit "-" getrennten Werte muss gerade sein, sonst Weiterleitung
                // letzer paramter hat keinen wert, strich am ende fällt weg
                if ((count($seoparams) % 2 != 0) && (count($seoparams) > 0)) {
                    //$redirect = true;
                    array_push($seoparams, null);
                }

                for ($i = 0; $i < count($seoparams); $i += 2)
                {
                    // i ist der Name des Parameters, i+1 ist der Wert des Parameters
                    if (!isset($_GET[$seoparams[$i]]))
                        $_GET[$seoparams[$i]] = $seoparams[$i+1];

                    // Die Parameter muessen alphabetisch sortiert sein, sonst Weiterleitung
                    if (($i >= 2) && (strcmp($seoparams[$i - 2], $seoparams[$i]) >= 0))
                        $redirect = true;
                }
            }
            else {
                $redirect = true;
            }
        }

        unset($seoparams);
        unset($seoparamstr);
        unset($paramdelim);
    }
    elseif ($numparams > 0) {
        $redirect = true;
    }

    unset($_GET['seoq']);
    unset($_REQUEST['seoq']);

    // Expliziter Aufruf von index.php bzw. indexseo.php => Weiterleitung erzwingen
    if ((!$calledbyrewrite) && (substr($_SERVER['REQUEST_URI'], -1) != '/')) {
        $redirect = true;
    }
    // Bei Bedarf Weiterleitung auf die neue URL im richtigen Format
    if ($redirect && isset($_GET['go'])) {
        header('Location: ' . $FD->cfg('virtualhost') . url_seo($_GET['go'], $_GET, true), true, 301);
        die();
    }

    // Inhalt von $_GET nach $_REQUEST kopieren
    foreach ($_GET as $k => $v)
        $_REQUEST[$k] = $v;

    // Query-String anpassen
    $_SERVER['QUERY_STRING'] = '';
    foreach ($_GET as $k => $v)
        $_SERVER['QUERY_STRING'] .= urlencode($k) . '=' . urlencode($v) . '&';
    $_SERVER['REQUEST_URI'] = '/index.php?' . $_SERVER['QUERY_STRING'];

    // Hotlinkingschutz vom FS2 zufrieden stellen
    if (isset($_SERVER['HTTP_REFERER']))
      if (preg_match('/\/dlfile--.*\.html$/', $_SERVER['HTTP_REFERER']))
          $_SERVER['HTTP_REFERER'] .= '?go=dlfile';
}



?>
