<!--section-start::APPLET--><label for="mini_search_keyword"><h2>Suche</h2></label>
<form method="get" action="">
  <input type="hidden" name="go" value="search">
  <input type="hidden" name="in[]" value="news">
  <input type="hidden" name="in[]" value="articles">
  <input type="hidden" name="in[]" value="downloads">
  <input class="small input input_highlight middle" id="mini_search_keyword" name="keyword" size="13" maxlength="100" value="{..keyword..}">
  <input class="small pointer middle" type="submit" value="Go">
</form>
<!--section-end::APPLET-->

<!--section-start::SEARCH--><b class="atleft">Suche</b>
<a href="?go=search" class="small atright">(Neue Suche)</a>
<br><br>

<fieldset>
  <legend style="color:#000000;"><b>Nach Inhalten mit dem Schlüsselwort...</b></legend>
  <form method="get" action="">
    <input type="hidden" name="go" value="search">
    <input class="input input_highlight middle" name="keyword" size="30" maxlength="100" value="{..keyword..}">
    <input class="pointer middle" type="submit" value="Suchen">
    
    <b class="middle">in</b>
    
    <input class="pointer middle" type="checkbox" id="search_news" name="in[]" value="news" {..search_in_news..}>
    <label class="pointer middle" for="search_news">News</label>
    
    <input class="pointer middle" type="checkbox" id="search_articles" name="in[]" value="articles" {..search_in_articles..}>
    <label class="pointer middle" for="search_articles">Artikeln</label>
    
    <input class="pointer middle" type="checkbox" id="search_downloads" name="in[]" value="downloads" {..search_in_downloads..}>
    <label class="pointer middle" for="search_downloads">Downloads</label>
  </form>
  <span class="small">Erlaubte Operatoren: <b>AND</b>, <b>OR</b>, <b>XOR</b>, <b>NOT</b></span>
</fieldset>
<!--section-end::SEARCH-->

<!--section-start::RESULT_DATE_TEMPLATE-->vom {..date..} 
<!--section-end::RESULT_DATE_TEMPLATE-->

<!--section-start::RESULT_LINE--><p>
  <a href="{..url..}">{..title..}</a>
  {..date_template..}<span class="small">(Funde: {..num_matches..})</span>
</p>
<!--section-end::RESULT_LINE-->

<!--section-start::NO_RESULTS--><p>
  Keine Übereinstimmungen gefunden!
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

<!--section-start::BODY-->{..search..}
{..news..}
{..articles..}
{..downloads..}
<!--section-end::BODY-->

