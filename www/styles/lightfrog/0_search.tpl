<!--section-start::APPLET--><label for="mini_search_keyword"><b>Suche</b></label><br>
<form method="get" action="">
  <input type="hidden" name="go" value="search">
  <input type="hidden" name="in_news" value="1">
  <input type="hidden" name="in_articles" value="1">
  <input type="hidden" name="in_downloads" value="1">
  <input class="small input input_highlight middle" id="mini_search_keyword" name="keyword" size="13" maxlength="100" value="">
  <input class="small pointer middle" type="submit" value="Go">
</form>
<!--section-end::APPLET-->

<!--section-start::SEARCH--><b class="atleft">Suche</b>
<a href="?go=search" class="small atright">(Neue Suche)</a>
<br><br>

<fieldset>
  <legend style="color:#000000;"><b>Nach Inhalten mit dem Schl&uuml;sselwort...</b></legend>
  <form method="get" action="">

    <input type="hidden" name="go" value="search">
    <input class="input input_highlight middle" name="keyword" size="55" maxlength="100" value="{..keyword..}">
    <input class="pointer middle" type="submit" value="Suchen">
    &nbsp;<span class="link small middle" onclick="$('#extended_search').slideToggle()">(Erweitert)</span>
    <span class="small">Erlaubte Operatoren: <a href="$URL(search_help)"><b>{..operators..}</b></a></span>


    <p id="extended_search" class="hidden" style="width:100%">
      <b class="middle">Suche in</b>
      <input class="pointer middle" type="checkbox" id="search_news" name="in_news" value="1" {..search_in_news..}>
      <label class="pointer middle" for="search_news">News</label>
      <input class="pointer middle" type="checkbox" id="search_articles" name="in_articles" value="1" {..search_in_articles..}>
      <label class="pointer middle" for="search_articles">Artikeln</label>
      <input class="pointer middle" type="checkbox" id="search_downloads" name="in_downloads" value="1" {..search_in_downloads..}>
      <label class="pointer middle" for="search_downloads">Downloads</label>

      <span class="atright">
        <input class="pointer middle" type="checkbox" id="phonetic_search" name="phonetic_search" value="1" {..phonetic_search..}>
        <label class="pointer middle" for="phonetic_search"><b>Phonetische Suche</b></label>
      </span>
    </p>

    </form>
</fieldset>
<!--section-end::SEARCH-->

<!--section-start::RESULT_DATE_TEMPLATE-->vom {..date..}
<!--section-end::RESULT_DATE_TEMPLATE-->

<!--section-start::RESULT_LINE--><p>
  <a href="{..url..}">{..title..}</a>
  {..date_template..}<span class="small">(Relevanz: {..rank..})</span>
</p>
<!--section-end::RESULT_LINE-->

<!--section-start::NO_RESULTS--><p>
  Keine &Uuml;bereinstimmungen gefunden!
</p>
<!--section-end::NO_RESULTS-->

<!--section-start::MORE_RESULTS--><p class="small" align="right">
  <a href="{..main_search_url..}">
    (mehr Ergebnisse)
  </a>
</p>
<!--section-end::MORE_RESULTS-->

<!--section-start::RESULTS_BODY--><br>
<div>
  <b>{..type_title..}</b> <span class="small">(Gefundene Inhalte: <b>{..num_results..}</b>)</span><br>
  {..results..}
  {..more_results..}
</div>
<!--section-end::RESULTS_BODY-->

<!--section-start::INFO--><p>
  <b>Berechnete Suchanfrage:</b> {..query..}<br>
  <b>Gefundene Inhalte:</b> {..num_results..}
</p>

<!--section-end::INFO-->

<!--section-start::BODY-->{..search..}
{..info..}
{..news..}
{..articles..}
{..downloads..}
<!--section-end::BODY-->

