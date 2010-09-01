<!--section-start::MAIN--><body>
  <div id="main">
    
    <div id="header">
      <h1 id="title">&nbsp;Frogsystem 2 (Alix 5)</h1>
    </div>

    <div id="menu_left">
    $NAV(left.nav)
    $APP(mini-search.php)
    </div>
    
    <div id="menu_right">
      $APP(user-menu.php)
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
</body><!--section-end::MAIN-->

<!--section-start::MATRIX-->{..doctype..}
<html lang="{..language..}">
  <head>
    {..base..}
    {..title..}
    {..meta..}
    {..link..}
    {..script..}
  </head>
  {..body..}
</html><!--section-end::MATRIX-->

<!--section-start::DOCTYPE--><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"><!--section-end::DOCTYPE-->

