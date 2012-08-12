<!--section-start::SYSTEMMESSAGE--><p class="systemmessage">
  <b>{..message_title..}</b><br>
  {..message..}
</p><!--section-end::SYSTEMMESSAGE-->

<!--section-start::FORWARDMESSAGE--><p class="systemmessage">
  <b>{..message_title..}</b><br>
  {..message..}<br>
  <br>Du wirst jetzt automatisch weitergeleitet.<br>
  Falls dein Browser keine automatische Weiterleitung unterstützt, <a href="{..forward_url..}">klicke bitte hier</a>.
</p>
<!--section-end::FORWARDMESSAGE-->

<!--section-start::DOCTYPE--><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"><!--section-end::DOCTYPE-->

<!--section-start::MAINPAGE--><body>
  <div id="main">
    
    <div id="header">
      <h1 id="title">&nbsp;Frogsystem 2 (Alix 5)</h1>
    </div> 

    <div id="menu_left">
    $NAV(left.nav)<br>
    $APP(mini-search.php)
    </div>
    
    <div id="menu_right">
      $APP(user-menu.php)
      $APP(topdownloads.php)
      $APP(preview-image.php)
      $APP(shop-system.php)      
      $APP(poll-system.php)
      $APP(affiliates.php)
      $APP(mini-statistics.php)
      [%feeds%]
    </div>

    <div id="content">
      <div id="content_inner">
        $APP(announcement.php)
        {..content..}
      </div>
    </div>

    <div id="footer">
      <span class="copyright">&bdquo;Light Frog&ldquo;-Style &copy; Stoffel &amp; Sweil | Frog-Photo &copy; <a href="http://www.flickr.com/photos/joi/1157708196/" target="_blank">Joi</a><br>
       {..copyright..}</span>
    </div>

  </div>
</body><!--section-end::MAINPAGE-->

<!--section-start::POPUPVIEWER--><body id="imageviewer">

  <div style="width:100%;" align="center">
    <p><b>&nbsp;{..caption..}</b>&nbsp;</p>
    <table style="width:100%;" cellspacing="0" cellpadding="3">
      <tr valign="middle" align="center">
        <td style="width:800px; height:600px;">
          {..image..}
        </td>
      </tr>
    </table>
    <table style="width:100%;" cellspacing="0" cellpadding="3">
      <tr valign="middle">
        <td width="40%" align="right">
          {..prev_image_link..}
        </td>
        <td width="20%" align="center">
          <a href="javascript:self.close()"><img src="$VAR(style_icons)close.gif" alt="Fenster schließen" title="Fenster schließen"></a>   
        </td>
        <td width="40%" align="left">
           {..next_image_link..}
        </td>
      </tr>
    </table>    
  </div>
  
</body>
<!--section-end::POPUPVIEWER-->

<!--section-start::ANNOUNCEMENT--><b>Ankündigung:</b>
<p>
  {..announcement_text..}
  <br><br>
</p><!--section-end::ANNOUNCEMENT-->

<!--section-start::STATISTICS--><p>
  <b>Statistik:</b>
</p>
<p class="small">
  - <b>{..visits..}</b> Visits<br>
  - <b>{..visits_today..}</b> Visits heute<br>
  - <b>{..hits..}</b> Hits<br>
  - <b>{..hits_today..}</b> Hits heute
</p>
<p class="small">  
  - <b>{..visitors_online..}</b> Besucher online<br>
  - <b>{..registered_online..}</b> registrierte <br>
  - <b>{..guests_online..}</b> Gäste
</p>
<p class="small">  
  - <b>{..num_users..}</b> registrierte User<br>
  - <b>{..num_news..}</b> News<br>
  - <b>{..num_comments..}</b> Kommentare<br>
  - <b>{..num_articles..}</b> Artikel
</p>
<!--section-end::STATISTICS-->

