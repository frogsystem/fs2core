<!--section-start::MAIN--><body>
  <div id="main">

    <div id="header">
      <h1 id="title">&nbsp;$VAR(page_title)</h1>
    </div>

    <div id="menu_left">
    $APP(mini-search.php)<br>
    
    <b>Allgemein</b><br>
    <a class="small" href="?go=news">- News</a><br>
    <a class="small" href="?go=news_search">- News-Suche</a><br>
    <a class="small" href="?go=user_list">- Mitgliederliste</a><br>
    <a class="small" href="?go=polls">- Umfragen</a><br>
    <a class="small" href="?go=search">- Suche</a><br>
    <a class="small" href="?go=style_selection">- Stylewahl</a><br>
    <br>

    <b>Inhalt &amp; Media</b><br>
    <a class="small" href="?go=fscode">- FSCode</a><br>
    <a class="small" href="?go=gallery">- Galerie</a><br>
    <a class="small" href="?go=download&amp;cat_id=all">- Downloads</a><br>
    <a class="small" href="?go=press">- Presseberichte</a><br>
    <br>

    <b>Promotion</b><br>
    <a class="small" href="?go=shop">- Shop</a><br>
    <a class="small" href="?go=affiliates">- Partnerseiten</a><br>

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
    {..javascript..}
  </head>
  {..body..}
</html><!--section-end::MATRIX-->

<!--section-start::DOCTYPE--><!DOCTYPE html><!--section-end::DOCTYPE-->
