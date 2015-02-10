<!--section-start::MAIN--><body>
  <div id="main">

    <div id="header">
      <h1 id="title">&nbsp;$VAR(page_title)</h1>
    </div>

    <div id="menu_left">
    $APP(mini-search.php)<br>
    $NAV(left.nav)
    [%feeds%]
    </div>

    <div id="menu_right">
      $APP(user-menu.php)
      $APP(preview-image.php)
      $APP(shop-system.php)
      $APP(poll-system.php[random])
      $APP(affiliates.php)
      $APP(topdownloads.php)
      $APP(mini-statistics.php)
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
    {..base_tag..}
    {..title_tag..}
    {..meta_tags..}
    {..css_links..}
    {..favicon_link..}
    {..feed_link..}
    {..javascript..}
    $APP(social-meta-tags.php)
  </head>
  {..body..}
</html><!--section-end::MATRIX-->

<!--section-start::DOCTYPE--><!DOCTYPE html><!--section-end::DOCTYPE-->

