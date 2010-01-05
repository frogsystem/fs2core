<!--section-start::BUTTON--> <td class="editor_td">
    <div class="editor_button" {..javascript..}>
      <img src="$VAR(style_icons)/editor/{..img_file_name..}" alt="{..alt..}" title="{..title..}" />
    </div>
  </td><!--section-end::BUTTON-->

<!--section-start::SEPERATOR--><td class="editor_td_seperator"></td><!--section-end::SEPERATOR-->

<!--section-start::SMILIES_BODY--><fieldset>
  <legend class="small" align="left">
    Smilies
  </legend>
  {..smilies_table..}
</fieldset>
<!--section-end::SMILIES_BODY-->

<!--section-start::BODY--><table cellpadding="0" cellspacing="0" style="padding-bottom:4px;">
  <tr valign="bottom">
    {..buttons..}
  </tr>
</table>

<table cellpadding="0" cellspacing="0">
  <tr valign="top">
    <td>
      <textarea {..style..}>{..text..}</textarea>
    </td>
    <td style="width:4px; empty-cells:show;">
    </td>
    <td>
      {..smilies..}
    </td>
  </tr>
</table>
<br><!--section-end::BODY-->

