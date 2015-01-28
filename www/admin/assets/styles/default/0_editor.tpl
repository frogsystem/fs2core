<!--section-start::BUTTON--> <td class="editor_td">
    <div class="editor_button" {..javascript..}>
      <img src="$VAR(style_icons)/editor/{..img_file_name..}" alt="{..alt..}" title="{..title..}">
    </div>
  </td><!--section-end::BUTTON-->

<!--section-start::SEPERATOR--><td class="editor_td_seperator"></td><!--section-end::SEPERATOR-->

<!--section-start::SMILIES_BODY--><fieldset style="padding:0px;">
  <legend style="color:#000000;">Smilies</legend>
  {..smilies_table..}
</fieldset>
<!--section-end::SMILIES_BODY-->

<!--section-start::BODY--><table cellpadding="0" cellspacing="0">
  <tr>
    <td>

      <table cellpadding="0" cellspacing="0" style="padding-bottom:4px;">
        <tr valign="bottom">
          {..buttons..}
        </tr>
      </table>

    </td>
    <td></td>
  </tr>
  <tr>
    <td>
      <textarea rows="7" cols="50" {..style..}>{..text..}</textarea>
    </td>
    <td style="padding-left:3px;" valign="top">
      {..smilies..}
    </td>
  </tr>
</table>
<!--section-end::BODY-->

