<!--section-start::APPLET--><label for="mini_search_keyword"><b>Suche</b></label><br>
<form method="get" action="">
  <input type="hidden" name="go" value="search">
  <input type="hidden" name="in_news" value="1">
  <input type="hidden" name="in_articles" value="1">
  <input type="hidden" name="in_downloads" value="1">  
  <input class="small input input_highlight middle" id="mini_search_keyword" name="keyword" size="13" maxlength="100" value="{..keyword..}">
  <input class="small pointer middle" type="submit" value="Go">
</form>
<!--section-end::APPLET-->

<!--section-start::SEARCH--><b>Suche</b>
 <a href="?go=search" class="small" style="float:right;">(Neue Suche)</a>
 <br><br>
 
 <fieldset>
   <legend style="color:#000000;"><b>Nach Inhalten mit dem Schlüsselwort...</b></legend>
   <form method="get" action="">
     <input type="hidden" name="go" value="search">
     <input class="input input_highlight middle" name="keyword" size="30" maxlength="100" value="{..keyword..}">
     <input class="pointer middle" type="submit" value="Suchen">
     <b class="middle">in</b>
     <input class="pointer middle" type="checkbox" id="search_news" name="in_news" value="1" {..search_in_news..}>
     <label class="pointer middle" for="search_news">News</label>
     <input class="pointer middle" type="checkbox" id="search_articles" name="in_articles" value="1" {..search_in_articles..}>
     <label class="pointer middle" for="search_articles">Artikeln</label>
     <input class="pointer middle" type="checkbox" id="search_downloads" name="in_downloads" value="1" {..search_in_downloads..}>
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

