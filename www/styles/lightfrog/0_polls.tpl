<!--section-start::APPLET_POLL_ANSWER_LINE-->    <tr>
      <td valign="top">
        <input class="pointer" id="id_{..answer_id..}" type="{..type..}" name="answer{..multiple..}" value="{..answer_id..}">
      </td>
      <td align="left" class="small">
        <label class="pointer" for="id_{..answer_id..}">{..answer..}</label>
      </td>
    </tr><!--section-end::APPLET_POLL_ANSWER_LINE-->

<!--section-start::APPLET_POLL_BODY--><p>
  <b>Umfrage:</b>
</p>

<form method="post">
  <input type="hidden" name="poll_id" value="{..poll_id..}">
  <table style="margin-left:-1px; width:100%;"  align="center" cellpadding="1" cellspacing="0">
    <tr>
      <td class="small" colspan="2" align="center">
        <b>{..question..}</b>
      </td>
    </tr>
    {..answers..}
    <tr>
      <td colspan="2" align="center">
        <input class="pointer" type="submit" value="Abstimmen"><br>
        <a class="small" href="?go=polls&amp;id={..poll_id..}">
          (Ergebnis anzeigen)
        </a>
      </td>
    </tr>
  </table>
</form><!--section-end::APPLET_POLL_BODY-->

<!--section-start::APPLET_NO_POLL--><p>
  <b>Umfrage:</b>
</p>
<p align="center">
    Keine Umfrage gefunden!
</p><!--section-end::APPLET_NO_POLL-->

<!--section-start::APPLET_RESULT_ANSWER_LINE-->  <tr>
    <td align="left" class="small" colspan="2">
      {..answer..}
    </td>
  </tr>
  <tr>
    <td align="right" class="small">
      {..percentage..}
    </td>
    <td align="left" style="padding-left:3px; width:100%;">
      <div style="width:{..bar_width..}; height:10px; background-color:#008800;"></div>
    </td>
  </tr><!--section-end::APPLET_RESULT_ANSWER_LINE-->

<!--section-start::APPLET_RESULT_BODY--><p>
  <b>Umfrage:</b>
</p>
<table style="margin-left:-2px; width:100%;" align="center" cellpadding="2" cellspacing="0">
  <tr>
    <td class="small" colspan="2" align="center">
      <b>{..question..}</b>
    </td>
  </tr>
{..answers..}
</table>
<p>
  Teilnehmer: {..participants..}<br>
  <b>Bereits abgestimmt!</b>
</p><!--section-end::APPLET_RESULT_BODY-->

<!--section-start::LIST_LINE-->  <tr>
    <td align="left">
      <a href="{..url..}">
        {..question..}
      </a>
    </td>
    <td align="left">
      {..participants..}
    </td>
    <td align="left">
      {..start_date..}
    </td>
    <td align="center">
      -
    </td>
    <td align="left">
      {..end_date..}
    </td>
  </tr><!--section-end::LIST_LINE-->

<!--section-start::LIST_BODY--><b>Umfragen</b><br><br>

<table style="margin-left:-2px; width:100%;" cellpadding="2" cellspacing="0">
  <tr align="center">
    <td class="left bottom">
      <a href="?go=polls&amp;sort=question&amp;order={..order_question..}">
        <img src="$VAR(style_icons)poll/question.gif" alt="Frage" title="Frage" align="bottom">
        <br>{..arrow_question..}
      </a>
    </td>

    <td class="left bottom" width="100">
      <a href="?go=polls&amp;sort=participants&amp;order={..order_participants..}">
        <img src="$VAR(style_icons)poll/users.gif" alt="Teilnehmer" title="Teilnehmer" align="bottom">
        <br>{..arrow_participants..}
      </a>
    </td>

    <td class="left bottom" width="58">
      <a href="?go=polls&amp;sort=start_date&amp;order={..order_start_date..}">
        <img src="$VAR(style_icons)poll/date-from.gif" alt="von" title="von" align="bottom">
        <br>{..arrow_start_date..}
      </a>
    </td>

    <td class="left bottom" width="10"></td>

    <td class="left bottom" width="70">
      <a href="?go=polls&amp;sort=end_date&amp;order={..order_end_date..}">
        <img src="$VAR(style_icons)poll/date-to.gif" alt="bis" title="bis" align="bottom">
        <br>{..arrow_end_date..}
      </a>
    </td>

  </tr>
{..polls..}
</table>
<!--section-end::LIST_BODY-->

<!--section-start::ANSWER_LINE-->  <tr>
    <td align="left">{..answer..}</td>
    <td align="right" width="1">{..percentage..}</td>
    <td align="left"width="1">({..votes..})</td>
    <td style="padding-left:5px;"  align="left">
      <div style="width:{..bar_width..}; height:10px; background-color:#008800;"></div>
    </td>
  </tr><!--section-end::ANSWER_LINE-->

<!--section-start::BODY--><b class="atleft">Umfragen</b>
<a href="?go=polls" class="small atright">(Alle Umfragen)</a>
<br><br>

<table style="margin-left:-2px; width:100%;" cellpadding="2" cellspacing="0">
  <tr>
    <td colspan="4">
      <b>{..question..}</b>
    </td>
  </tr>
{..answers..}
  <tr><td>&nbsp;</td></tr>
  <tr><td align="left">Anzahl der Teilnehmer: </td><td align="left" colspan="3"><b>{..participants..}</b></td></tr>
  <tr><td align="left">Anzahl der Stimmen: </td><td align="left" colspan="3"><b>{..all_votes..}</b></td></tr>
  <tr><td align="left">Art der Umfrage: </td><td align="left" colspan="3">{..type..}</td></tr>
  <tr><td align="left">Umfragedauer:</td><td align="left" colspan="3">{..start_date..} bis {..end_date..}</td></tr>
</table><!--section-end::BODY-->

