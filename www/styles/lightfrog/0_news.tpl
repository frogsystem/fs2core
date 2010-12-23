<!--section-start::APPLET_LINE--><li><a href="#news_{..news_id..}">{..title..}</a></li><!--section-end::APPLET_LINE-->

<!--section-start::APPLET_BODY--><table style="margin-left:-2px; width:100%;" cellpadding="2" cellspacing="0">
  <tr valign="top">
    <td width="50%">
      <h3><b>Aktuelle News</b></h3>
      <ul class="related">
        {..news_lines..}
      </ul>
    </td>
    <td width="50%">
      <h3><b>Letzte Downloads</b></h3>
      {..download_lines..}
    </td>
  </tr>
</table>
<!--section-end::APPLET_BODY-->

<!--section-start::LINKS_LINE--><li><a href="{..url..}" target="{..target..}">{..title..}</a></li><!--section-end::LINKS_LINE-->

<!--section-start::LINKS_BODY--><h3><b>Weiterführende Links</b></h3>
<ul class="related">
  {..links..}
</ul>
<!--section-end::LINKS_BODY-->

<!--section-start::NEWS_BODY--><div style="position:relative;">
  <h2 id="news_{..news_id..}">{..titel..}</h2>
  <span class="atright" style="position:absolute;top:0px;right:0px;">
    ({..cat_name..})
  </span>
  
  <span>
    von <a href="{..user_url..}">{..user_name..}</a>,
    am {..date..}
  </span>
</div>

{..text..}
{..related_links..}

<p align="right">
  <a href="{..comments_url..}">
    Kommentare ({..comments_number..})
  </a>
</p>
<!--section-end::NEWS_BODY-->

<!--section-start::BODY-->{..headlines..}
<br>
{..news..}<!--section-end::BODY-->

<!--section-start::COMMENT_USER--><a style="font-size:120%;" href="{..url..}">
  {..name..}
</a><br>
{..rank..}
<a href="{..url..}">
  {..user_image..}
</a>


<!--section-end::COMMENT_USER-->

<!--section-start::COMMMENT_ENTRY--><table align="center" class="comment_table" cellpadding="0" cellspacing="0">
  <tr>
    <td class="comment_td comment_left">
      {..user..}
    </td>
    <td class="comment_td">
      <div class="comment_top">
        <h4 class="atleft"><b>{..titel..}</b></h4>
        <span class="atright">
          {..date..}
        </span>      
      </div>
      {..text..}
    </td>    
  </tr>  
</table><!--section-end::COMMMENT_ENTRY-->

<!--section-start::COMMENT_CAPTCHA--><div class="comment_right" style="height:20px; text-align:right;">
  <span class="atleft">
    <label for="comment_captcha">
      <img src="{..captcha_url..}" alt="CAPTCHA" class="bottom">
    </label>
    <input class="input input_highlight" name="spam" 
id="comment_captcha" size="10" maxlength="5">
  </span>
  <span class="atright">
    Bitte die Rechenaufgabe lösen!
  </span>
</div>
<!--section-end::COMMENT_CAPTCHA-->

<!--section-start::COMMENT_CAPTCHA_TEXT--><p class="small" id="captcha_note">
  <b>Hinweis:</b> Die Rechenaufgabe verhindert, dass Spam-Bots auf dieser Seite Werbung einstellen können. Um die Abfrage zu umgehen, kannst du dich <a href="?go=register">registrieren</a>.
</p>
<!--section-end::COMMENT_CAPTCHA_TEXT-->

<!--section-start::COMMENT_FORM_NAME-->Name:<br>
<input class="small input input_highlight" id="comment_name" name="name" size="30" maxlength="100">
<a class="small" href="?go=login">Jetzt anmelden?</a><!--section-end::COMMENT_FORM_NAME-->

<!--section-start::COMMENT_FORM--><p>
  <b>Kommentar hinzufügen</b>
</p>

<form action="" method="post" onSubmit="return checkCommentForm()">
  <input type="hidden" name="go" value="comments">
  <input type="hidden" name="add_comment" value="1">
  <input type="hidden" name="id" value="{..news_id..}">
  
  <table align="center" class="comment_table" cellpadding="0" cellspacing="0">
    <tr>
      <td class="comment_td comment_left" style="font-size:120%; font-weight:bold;">
        {..name_input..}
      </td>
      <td class="comment_td">
        <div class="comment_top">
          <span class="atleft">
            <span class="small">Titel:</span>
            <input class="input input_highlight" id="comment_title" name="title" size="27" maxlength="100">
          </span>
          <span class="atright">
            $VAR(date_time)
          </span>     
        </div>
        {..textarea..}
        <div class="comment_right small" style="margin-top:-3px;">
          Html&nbsp;ist&nbsp;<b>{..html..}</b>.
          <a href="?go=fscode" title="neues Fenster">FSCode</a>&nbsp;ist&nbsp;<b>{..fs_code..}.</b>
        </div>        
        {..captcha..}
        <div class="comment_right center" style="border:none; margin-bottom:-3px; padding-top:8px; padding-bottom:8px;">
          <input class="pointer" type="submit" value="Abschicken">
        </div>
      </td>
    </tr>
  </table>
{..captcha_text..}
</form>
<!--section-end::COMMENT_FORM-->

<!--section-start::COMMENT_BODY-->{..news..}
{..comments..}
{..comment_form..}
<!--section-end::COMMENT_BODY-->

<!--section-start::SEARCH--><b class="atleft">News-Suche</b>
<a href="?go=news_search" class="small atright">(Neue Suche)</a>
<br><br>

<fieldset>
  <legend style="color:#000000;"><b>News aus dem...</b></legend>
  <form method="get">
    <input type="hidden" name="go" value="news_search">
    <select class="input" name="month">
      <option value="1">Januar</option>
      <option value="2">Februar</option>
      <option value="3">März</option>
      <option value="4">April</option>
      <option value="5">Mai</option>
      <option value="6">Juni</option>
      <option value="7">Juli</option>
      <option value="8">August</option>
      <option value="9">September</option>
      <option value="10">Oktober</option>
      <option value="11">November</option>
      <option value="12">Dezember</option>
    </select>
    <select class="input" name="year">
      {..years..}
    </select>
    <input class="pointer" type="submit" value="Anzeigen">
  </form>
</fieldset>

<br><br>

<fieldset>
  <legend style="color:#000000;"><b>Nach News mit dem Schlüsselwort...</b></legend>
  <form method="get" onSubmit="return checkNewsSearchForm()">
    <input type="hidden" name="go" value="news_search">
    <input class="input input_highlight" id="news_search_keyword" name="keyword" size="30" maxlength="100" value="{..keyword..}">
    <input class="pointer" type="submit" value="Suchen">
  </form>
</fieldset>

<br><br>
<!--section-end::SEARCH-->

