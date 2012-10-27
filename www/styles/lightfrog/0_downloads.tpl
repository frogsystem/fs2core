<!--section-start::APPLET_LINE--><span class="small">{..date..} - </span><a class="small" href="{..url..}">{..title..}</a><br><!--section-end::APPLET_LINE-->

<!--section-start::SEARCH--><table style="margin-left:-2px;" cellpadding="2" cellspacing="0">
  <tr>
    <td align="right">
      <b>Kategorie durchsuchen:</b>
    </td>
    <td align="left">
      <form action="" method="get">
        <input type="hidden" name="go" value="download">
        {..input_cat..}
        <input class="input input_highlight" size="25" maxlen="255" name="keyword" value="{..keyword..}">
        <input class="pointer" type="submit" value="Suchen">
        <input class="pointer" type="button" value="Alle anzeigen" onclick="location='{..all_url..}'">
      </form>
    </td>
  </tr>
</table>
<!--section-end::SEARCH-->

<!--section-start::NAVIGATION_LINE--><img style="margin:3px 2px 3px 0px;" src="{..icon_url..}" alt="{..cat_name..}" align="absmiddle">
<a class="middle" href="{..cat_url..}">
  {..cat_name..}
</a><br><!--section-end::NAVIGATION_LINE-->

<!--section-start::NAVIGATION_BODY--><p>
  {..lines..}
</p>
<!--section-end::NAVIGATION_BODY-->

<!--section-start::PREVIEW_LINE-->  <tr>
    <td class="dl_cell"><a href="{..url..}"><b>{..title..}</b></a></td>
    <td class="dl_cell" align="center" valign="middle">{..cat_name..}</td>
    <td class="dl_cell" align="center" valign="middle">{..date..}</td>
    <td class="dl_cell">{..text..}</td>
  </tr><!--section-end::PREVIEW_LINE-->

<!--section-start::NO_PREVIEW_LINE-->  <tr>
    <td colspan="4" class="dl_cell" align="center" valign="middle">Keine Downloads gefunden!</td>
  </tr><!--section-end::NO_PREVIEW_LINE-->

<!--section-start::PREVIEW_LIST--><p>
  <b>{..page_title..}</b>
</p>

<table style="margin-left:-2px; width:100%;" cellpadding="0" cellspacing="2">
  <tr>
    <td class="dl_cell"><b>Titel</b></td>
    <td class="dl_cell"><b>Kategorie</b></td>
    <td class="dl_cell"><b>Datum</b></td>
    <td class="dl_cell"><b>Beschreibung</b></td>
  </tr>
{..entries..}
</table>
<br><!--section-end::PREVIEW_LIST-->

<!--section-start::BODY--><b class="atleft">Downloads</b>
<a href="?go=download&cat_id=all" class="small atright">(Alle Downloads)</a><br>

{..navigation..}
{..entries..}
{..search..}<!--section-end::BODY-->

<!--section-start::ENTRY_FILE_LINE-->  <tr>
    <td {..mirror_col..} class="dl_cell">
      <a target="_blank" href="{..url..}" rel="nofollow">
        <b>{..name..}</b>
      </a>
    </td>
    {..mirror_ext..}
    <td class="dl_cell">{..size..}</td>
    <td class="dl_cell">{..traffic..}</td>
    <td class="dl_cell">{..hits..}</td>
  </tr><!--section-end::ENTRY_FILE_LINE-->

<!--section-start::ENTRY_FILE_IS_MIRROR--><td class="dl_cell" align="center" valign="middle"><b>Mirror!</b></td><!--section-end::ENTRY_FILE_IS_MIRROR-->

<!--section-start::ENTRY_STATISTICS-->  <tr>
    <td colspan="2" class="dl_cell"><b>{..number..}</b></td>
    <td class="dl_cell">{..size..}</td>
    <td class="dl_cell">{..traffic..}</td>
    <td class="dl_cell">{..hits..}</td>
  </tr><!--section-end::ENTRY_STATISTICS-->

<!--section-start::ENTRY_BODY--><b class="atleft">Downloads</b>
<a href="?go=download&cat_id=all" class="small atright">(Alle Downloads)</a><br>

{..navigation..}
<p>
  <b>{..title..}</b>
</p>

<table style="margin-left:-2px; width:100%;" cellpadding="2" cellspacing="0">
  <tr>
    <td valign="top" width="130" rowspan="4">
      <a href="{..viewer_link..}">
        <img src="{..thumb_url..}" alt="{..title..}">
      </a>
    </td>
    <td width="75">
      <b>Kategorie:</b>
    </td>
    <td>
      {..cat_name..}
    </td>
  </tr>
  <tr>
    <td>
      <b>Datum:</b>
    </td>
    <td>
      {..date..}
    </td>
  </tr>
  <tr>
    <td>
      <b>Uploader:</b>
    </td>
    <td>
      <a href="{..uploader_url..}">{..uploader..}</a>
    </td>
  </tr>
  <tr>
    <td>
      <b>Autor:</b>
    </td>
    <td>
      {..author_link..}
    </td>
  </tr>
  <tr><td style="height:5px;"></td></tr>  
  <tr valign="top">
    <td>
      <b>Beschreibung:</b>
    </td>
    <td colspan="2">
      {..text..}
    </td>
  </tr>
  <tr><td style="height:5px;"></td></tr>
  <tr>
    <td>
      <b>Dateien:</b>
    </td>
    <td colspan="2">
      {..messages..}
    </td>
  </tr>
  <tr><td style="height:5px;"></td></tr>
</table>

<table style="margin-left:-2px; width:100%;" cellpadding="0" cellspacing="2">
  <tr>
    <td colspan="2" class="dl_cell"><b>Datei (Download)</b></td>
    <td class="dl_cell"><b>Größe</b></td>
    <td class="dl_cell"><b>Traffic</b></td>
    <td class="dl_cell"><b>Hits</b></td>
  </tr>
  {..files..}
  <tr>
    <td colspan="5" class="dl_cell" style="height:1px;"></td>
  </tr>
  {..statistics..}
</table>
<br>
{..search..}
<br>
<a href="{..comments_url..}">Kommentare ({..comments_number..})</a>
<br><!--section-end::ENTRY_BODY-->

