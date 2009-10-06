<!--section-start::SYSTEMMESSAGE--><b>{..message_title..}</b><br>
{..message..}<!--section-end::SYSTEMMESSAGE-->

<!--section-start::FORWARDMESSAGE--><b>{..message_title..}</b><br>
{..message..}<br>
<br>Du wirst jetzt automatisch weitergeleitet.<br>
Falls dein Browser keine automatische Weiterleitung unterstützt, <a href="{..forward_url..}">klicke bitte hier</a>.<!--section-end::FORWARDMESSAGE-->

<!--section-start::DOCTYPE--><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"><!--section-end::DOCTYPE-->

<!--section-start::MAINPAGE--><body>
    <div id="head_shadow"></div>
    <div id="head"></div>

    <div id="menu_l_shadow">
        <div id="menu_l">
{..main_menu..}
        </div>
    </div>
    <div id="main_container">
        <div id="main_shadow">
            <div id="main">
{..announcement..}
{..content..}
            </div>
        </div>
        <div style="width:100%; text-align:center; margin-top:10px; font-size:7pt; padding-bottom:10px;">{..copyright..}</div>
    </div>

    <div id="menu_r_shadow">
        <div id="menu_r">
{..user..}<br><br>
Zufallsbild:<br>
{..randompic..}<br>
Shop:<br>
{..shop..}<br><br>
Umfrage:<br>
{..poll..}<br>
Partner:<br>
{..partner..}
Statistik:<br>
$APP[mini_statistics.php]<br><br>
News-Feeds:<br>
[%feeds%]
        </div>
    </div>
</body><!--section-end::MAINPAGE-->

<!--section-start::MENU1--><b>Allgemein</b><br>
<a class="small" href="{virtualhost}?go=news">- News</a><br>
<a class="small" href="{virtualhost}?go=newsarchiv">- News Archiv</a><br>
<a class="small" href="{virtualhost}?go=members">- Mitgliederliste</a><br>
<a class="small" href="{virtualhost}?go=pollarchiv">- Umfragen Archiv</a><br>
<a class="small" href="{virtualhost}?go=gallery">- Galerie</a><br>
<a class="small" href="{virtualhost}?go=download">- Downloads</a><br>
<a class="small" href="{virtualhost}?go=press">- Presseberichte</a><br>
<a class="small" href="{virtualhost}?go=fscode">- FSCode</a><br>
<a class="small" href="{virtualhost}?go=partner">- Partnerseiten</a><br>
<a class="small" href="{virtualhost}?go=shop">- Shop</a><br><!--section-end::MENU1-->

<!--section-start::PICTUREVIEWER--><body leftmargin="0" topmargin="0">

<center>
<table cellspacing="0" cellpadding="3">
 <tr align="center">
  <td>
   <a href="{bild_url}" target="_blank">{bild}</a><br><b>{text}</b>
  </td>
 </tr>
</table>
  
<table cellspacing="0" cellpadding="3">
 <tr>
  <td width="33%" align="right">
   <b>{weiter_grafik}</b>
  </td>
  <td width="33%" align="center">
   <b>{close}</b>
  </td>
  <td width="33%" align="left">
   <b>{zurück_grafik}</b>
  </td>
 </tr>
</table>
</center>

</body><!--section-end::PICTUREVIEWER-->

<!--section-start::ANNOUNCEMENT--><b>Ankündigung:</b>
<br><br>
    {announcement_text}
<br><br><!--section-end::ANNOUNCEMENT-->

<!--section-start::STATISTICS-->- <b>{..visits..}</b> Visits<br>
- <b>{..visits_today..}</b> Visits heute<br>
- <b>{..hits..}</b> Hits<br>
- <b>{..hits_today..}</b> Hits heute<br><br>

- <b>{..visitors_online..}</b> Besucher online<br>
- <b>{..registered_online..}</b> registrierte <br>
- <b>{..guests_online..}</b> Gäste<br><br>

- <b>{..registered_users..}</b> registrierte User<br>
- <b>{..news..}</b> News<br>
- <b>{..comments..}</b> Kommentare<br>
- <b>{..articles..}</b> Artikel
<!--section-end::STATISTICS-->

