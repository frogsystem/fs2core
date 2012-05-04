<!--section-start::SEARCH--><b>Suche</b>
 <a href="?go=search" class="small" style="float:right;">(Neue Suche)</a>
 <br><br>
 
 <fieldset>
   <legend style="color:#000000;"><b>Nach Inhalten mit dem Schl&uuml;sselwort...</b></legend>
   <form method="get">
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

<!--section-start::RESULT_LINE--><p>
  <a href="{..url..}">{..title..}</a>
  vom {..date..} <span class="small">(Funde: {..num_results..})</span>
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
  <b>{..type_title..}</b><br>
  {..results..}
  {..more_results..}
</div>
<!--section-end::RESULTS_BODY-->

<!--section-start::BODY-->{..search..}
{..news..}
{..articles..}
{..downloads..}
<!--section-end::BODY-->

