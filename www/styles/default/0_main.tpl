<!--section-start::MAIN--><body>
  <div id="main">

    <div id="header">
      <div id="title">&nbsp;$VAR(page_title)</div>
    </div>

    <div id="menu_left">
    $NAV(left.nav)
    </div>

    <div id="menu_right">
      $APP(user-menu.php)
      $APP(preview-image.php)
      $APP(shop-system.php)
      $APP(poll-system.php)
      $APP(affiliates.php)
      $APP(mini-statistics.php)
    </div>

    <div id="content">
      $APP(announcement.php)
      {..content..}
    </div>

    <div id="footer">
      <span class="copyright">{..copyright..}</span>
    </div>

  </div>
</body><!--section-end::MAIN-->

<!--section-start::MATRIX-->{..doctype..}
<html lang="{..language..}">
  <head>
    {..base_tag..}
    {..title_tag..}
    {..meta_tags..}
    {..css_links..}
    {..favicon_link..}
    {..feed_link..}
    {..jquery..}
    {..javascript..}
  </head>
  {..body..}
</html><!--section-end::MATRIX-->

<!--section-start::DOCTYPE--><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"><!--section-end::DOCTYPE-->
