<!--section-start::APPLET_ITEM--><p align="center">
  <a href="{..item_url..}" target="_blank">
    {..item_small_image..}
  </a><br>
  <span class="small">
    <a class="small" href="{..item_url..}" target="_blank">
      <b>{..item_titel..}</b>
    </a><br>
    Preis: <b>{..item_price..}</b>
  </span>
</p><!--section-end::APPLET_ITEM-->

<!--section-start::APPLET_BODY--><p>
  <b>Shop:</b>
</p>
{..applet_items..}
<!--section-end::APPLET_BODY-->

<!--section-start::SHOP_ITEM-->  <tr align="left">
    <td colspan="2">
      <a style="font-size:150%; font-weight:bold;" href="{..item_url..}" target="_blank">
        {..item_titel..}
      </a>
    </td>
  </tr>
  <tr align="left" valign="top">
    <td width="150">
      <p>
        {..item_small_image..}
      </p>
      <p>
        <a href="{..item_image_viewer_url..}">
          Bild in gro&szlig; betrachten...
        </a>
      </p>
      <p>
        Preis: <b>{..item_price..}</b>
      </p>
    </td>
    <td valign="top">
      {..item_text..}
      <a href="{..item_url..}" target="_blank">Jetzt kaufen!</a>
    </td>
  </tr>
  <tr><td>&nbsp;</td></tr><!--section-end::SHOP_ITEM-->

<!--section-start::SHOP_BODY--><b>Shop</b><br><br>

<table style="margin-left:-2px;" border="0" cellpadding="2" cellspacing="0">
  {..shop_items..}
</table><!--section-end::SHOP_BODY-->

