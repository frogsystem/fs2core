<!--section-start::CATEGORY--><tr>
  <td align="left">
    <a href="{..url..}">{..name..}</a>
  </td>
  <td align="left">
    erstellt am {..date..}
  </td>
  <td align="left">
    {..number..} Bilder
  </td>
</tr><!--section-end::CATEGORY-->

<!--section-start::CATEGORY_LIST_BODY--><b>Galerie</b><br><br>

<table style="margin-left:-2px; width:100%;" cellpadding="2" cellspacing="0">
{..cats..}
</table><!--section-end::CATEGORY_LIST_BODY-->

<!--section-start::IMAGE-->  <td align="center" valign="top">
    <a href="{..viewer_link..}">
      <img class="pointer" src="{..thumb_url..}" alt="{..caption..}">
    </a><br>    
    {..caption..}
  </td><!--section-end::IMAGE-->

<!--section-start::BODY--><b>Galerie: {..name..}</b>
<a href="?go=gallery" class="small" style="float:right;">(Alle Kategorien)</a>
<br><br>

<table border="0" cellpadding="" cellspacing="10" width="100%">
{..screenshots..}
</table>

<div align="center">
  {..page_nav..}
</div><!--section-end::BODY-->

