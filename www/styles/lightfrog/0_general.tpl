<!--section-start::SYSTEMMESSAGE--><b>{..message_title..}</b><br>
{..message..}<!--section-end::SYSTEMMESSAGE-->

<!--section-start::FORWARDMESSAGE--><b>{..message_title..}</b><br>
{..message..}<br>
<br>Du wirst jetzt automatisch weitergeleitet.<br>
Falls dein Browser keine automatische Weiterleitung unterstützt, <a href="{..forward_url..}">klicke bitte hier</a>.<!--section-end::FORWARDMESSAGE-->

<!--section-start::DOCTYPE--><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"><!--section-end::DOCTYPE-->

<!--section-start::MAINPAGE--><body>
  <div id="main">
    
    <div id="header">
      <div id="title">&nbsp;Frogsystem 2 (Alix 5)</div>
    </div> 

    <div id="menu_left">
    $NAV(left.nav)  
    </div>
    
    <div id="menu_right">
      $APP(usermenu.php)<br><br>
      Zufallsbild:<br>
      $APP(preview-image.php)<br>
      $APP(shop-system.php)<br><br>
      Umfrage:<br>
      $APP(poll-system.php)<br>
      Partner:<br>
      $APP(affiliates.php)
      Statistik:<br>
      $APP(mini-statistics.php)<br><br>
      News-Feeds:<br>
      [%feeds%]      
    </div>   
    
    <div id="content">
      $APP(announcement.php)
      {..content..}
    </div>
    
    <div id="footer">
      <span class="copyright">„Light Frog“-Style &copy; Stoffel &amp; Sweil | Frog-Photo &copy; <a href="http://www.flickr.com/photos/joi/1157708196/" target="_blank">Joi</a><br>
      {..copyright..}</span>
    </div>
    
  </div>
</body><!--section-end::MAINPAGE-->

<!--section-start::POPUPVIEWER-->
<!--section-end::POPUPVIEWER-->

<!--section-start::ANNOUNCEMENT--><b>Ankündigung:</b>
<p>
  {..announcement_text..}
  <br><br>
</p><!--section-end::ANNOUNCEMENT-->

<!--section-start::STATISTICS-->- <b>{..visits..}</b> Visits<br>
- <b>{..visits_today..}</b> Visits heute<br>
- <b>{..hits..}</b> Hits<br>
- <b>{..hits_today..}</b> Hits heute<br><br>

- <b>{..visitors_online..}</b> Besucher online<br>
- <b>{..registered_online..}</b> registrierte <br>
- <b>{..guests_online..}</b> Gäste<br><br>

- <b>{..num_users..}</b> registrierte User<br>
- <b>{..num_news..}</b> News<br>
- <b>{..num_comments..}</b> Kommentare<br>
- <b>{..num_articles..}</b> Artikel
<!--section-end::STATISTICS-->

