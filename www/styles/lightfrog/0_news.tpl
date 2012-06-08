<!--section-start::APPLET_LINE--><span class="small">{..date..} - </span><a class="small" href="#news_{..news_id..}">{..title..}</a><br><!--section-end::APPLET_LINE-->

<!--section-start::APPLET_BODY--><table style="margin-left:-2px; width:100%;" cellpadding="2" cellspacing="0">
  <tr valign="top">
    <td width="50%">
      <b>Aktuelle News:</b><br>
      {..news_lines..}
    </td>
    <td width="50%">
      <b>Downloads:</b><br>
      {..download_lines..}
    </td>
  </tr>
</table>
<!--section-end::APPLET_BODY-->

<!--section-start::LINKS_LINE--><li><a href="{..url..}" target="{..target..}">{..title..}</a></li><!--section-end::LINKS_LINE-->

<!--section-start::LINKS_BODY--><b>Weiterf&uuml;hrende Links:</b>
<ul>
  {..links..}
</ul>
<!--section-end::LINKS_BODY-->

<!--section-start::NEWS_BODY--><table width="100%" cellpadding="0" cellspacing="0">
  <tr>
    <td>
      <b class="atleft" id="news_{..news_id..}">{..titel..}</b>
      <span class="small atright">
        ({..cat_name..})
      </span><br>
      <span class="small">von <a href="{..user_url..}">{..user_name..}</a>, am {..date..}</span>

      {..text..}
      <div>
        {..related_links..}
        <span class="small atright">
          <a href="{..comments_url..}">
             Kommentare ({..comments_number..})
           </a>
        </span>
      </div>

    </td>
  </tr>
</table>
<br><!--section-end::NEWS_BODY-->

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
    <td class="comment_td comment_left" style="border-left:1px solid #A5ACB2;">
      {..user..}
    </td>
    <td class="comment_td">
      <div class="comment_top">
        <span class="atleft">
          <b>{..titel..}</b>
        </span>
        <span class="small atright">
          {..date..}
        </span>
      </div>
      {..text..}
    </td>
  </tr>
</table><!--section-end::COMMMENT_ENTRY-->

<!--section-start::COMMENT_CAPTCHA-->    <tr>
      <td>
        <img src="{..captcha_url..}" alt="CAPTCHA">
      </td>
      <td>
        <input class="small input input_highlight" name="spam" size="30" maxlength="10">
        <span class="small">Bitte die Rechenaufgabe l&ouml;sen!</span>
        <a class="small" href="#captcha_note">(Hinweis)</a>
      </td>
    </tr><!--section-end::COMMENT_CAPTCHA-->

<!--section-start::COMMENT_CAPTCHA_TEXT-->    <tr>
      <td></td>
      <td>
        <p class="small" id="captcha_note">
          <b>Hinweis:</b> Die Rechenaufgabe verhindert, dass Spam-Bots auf dieser Seite Werbung als Kommentar einstellen k&ouml;nnen. Um die Abfrage zu umgehen, kannst du dich <a href="?go=register">registrieren</a>.
        </p>
      </td>
    </tr>
<!--section-end::COMMENT_CAPTCHA_TEXT-->

<!--section-start::COMMENT_FORM_NAME--><input class="small input input_highlight" id="comment_name" name="name" size="30" maxlength="100">
<span class="small">Jetzt</span>
<a class="small" href="?go=login">anmelden?</a><!--section-end::COMMENT_FORM_NAME-->

<!--section-start::COMMENT_FORM--><p>
  <b>Kommentar hinzuf&uuml;gen</b>
</p>

<form action="" method="post" onSubmit="return checkCommentForm()">
  <input type="hidden" name="go" value="comments">
  <input type="hidden" name="add_comment" value="1">
  <input type="hidden" name="id" value="{..news_id..}">

  <table style="margin-left:-2px; width:100%;" cellpadding="2" cellspacing="0">
    <tr>
      <td>
        <b>Name: </b>
      </td>
      <td>
        {..name_input..}
      </td>
    </tr>
    <tr>
      <td>
        <b>Titel:</b>
      </td>
      <td>
        <input class="small input input_highlight" id="comment_title" name="title" size="30" maxlength="100">
      </td>
    </tr>
    <tr>
      <td valign="top">
        <b>Text:</b>
        <p class="small">
          HTML&nbsp;ist&nbsp;<b>{..html..}</b>.<br>
          <a href="?go=fscode">FScode</a>&nbsp;ist&nbsp;<b>{..fs_code..}.</b>
        </p>
      </td>
      <td>
        {..textarea..}
      </td>
    </tr>
    {..captcha..}
    <tr>
      <td></td>
      <td>
        <input class="pointer" type="submit" value="Abschicken">
      </td>
    </tr>
    {..captcha_text..}
  </table>
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
      <option value="3">M&auml;rz</option>
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
  <legend style="color:#000000;"><b>Nach News mit dem Schl&uuml;sselwort...</b></legend>
  <form method="get" onSubmit="return checkNewsSearchForm()">
    <input type="hidden" name="go" value="news_search">
    <input class="input input_highlight" id="news_search_keyword" name="keyword" size="30" maxlength="100" value="{..keyword..}">
    <input class="pointer" type="submit" value="Suchen">
  </form>
</fieldset>

<br><br>
<!--section-end::SEARCH-->

