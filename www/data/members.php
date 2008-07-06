<?php

    //config_arr
    $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."userlist_config", $db);
    $config_arr = mysql_fetch_assoc($index);

    //Wieviele User
    $index = mysql_query("SELECT COUNT(*) AS number FROM ".$global_config_arr[pref]."user", $db);
    $config_arr[number_of_users] = mysql_result($index, 0, "number");
    if ($config_arr[user_per_page]==-1) {
        $config_arr[user_per_page] = $config_arr[number_of_users];
    }
    $config_arr[number_of_pages] = ceil($config_arr[number_of_users]/$config_arr[user_per_page]);

    if (!isset($_GET['page']))
    {$_GET['page']=1;}
    if ($_GET['page']<1)
    {$_GET['page']=1;}
    if ($_GET['page']>$config_arr[number_of_pages])
    {$_GET['page']=$config_arr[number_of_pages];}

    $config_arr[oldpage] = $_GET['page']-1;
    $config_arr[newpage] = $_GET['page']+1;
    $config_arr[page_start] = ($_GET['page']-1)*$config_arr[user_per_page];

    if (!isset($_GET['sort'])) {
      $_GET['sort'] = 'default';
    }

    $order_name = 'asc'; $order_regdate = 'asc'; $order_news = 'desc'; $order_articles = 'desc'; $order_comments = 'desc';
    $arrow_name = ''; $arrow_regdate = ''; $arrow_news = ''; $arrow_articles = ''; $arrow_comments = '';

        switch($_GET['sort']) {
                case 'name_desc': {
                    $users_sql = mysql_query("SELECT user_id,user_name,user_mail,is_admin,reg_date,show_mail FROM ".$global_config_arr[pref]."user ORDER BY user_name DESC, reg_date ASC LIMIT $config_arr[page_start],$config_arr[user_per_page]");
                    $order_name = 'asc';
                    $arrow_name = '<img src="images/icons/pointer_down.gif" alt="" border="0" title="Absteigend" />';
                    break;
                }
                case 'name_asc': {
                    $users_sql = mysql_query("SELECT user_id,user_name,user_mail,is_admin,reg_date,show_mail FROM ".$global_config_arr[pref]."user ORDER BY user_name ASC, reg_date ASC LIMIT $config_arr[page_start],$config_arr[user_per_page]");
                    $order_name = 'desc';
                    $arrow_name = '<img src="images/icons/pointer_up.gif" alt="" border="0" title="Aufsteigend" />';
                    break;
                }
                case 'regdate_desc': {
                    $users_sql = mysql_query("SELECT user_id,user_name,user_mail,is_admin,reg_date,show_mail FROM ".$global_config_arr[pref]."user ORDER BY reg_date DESC, user_name ASC LIMIT $config_arr[page_start],$config_arr[user_per_page]");
                    $order_regdate = 'asc';
                    $arrow_regdate = '<img src="images/icons/pointer_down.gif" alt="" border="0" title="Absteigend" />';
                    break;
                }
                case 'regdate_asc': {
                    $users_sql = mysql_query("SELECT user_id,user_name,user_mail,is_admin,reg_date,show_mail FROM ".$global_config_arr[pref]."user ORDER BY reg_date ASC, user_name ASC LIMIT $config_arr[page_start],$config_arr[user_per_page]");
                    $order_regdate = 'desc';
                    $arrow_regdate = '<img src="images/icons/pointer_up.gif" alt="" border="0" title="Aufsteigend" />';
                    break;
                }
                case 'news_desc': {
                    $users_sql = mysql_query("SELECT SUM(a.user_id = b.user_id) AS number, a.user_id,a.user_name,a.user_mail,a.is_admin,a.reg_date,a.show_mail FROM ".$global_config_arr[pref]."user a, ".$global_config_arr[pref]."news b GROUP BY a.user_id,a.user_name,a.user_mail,a.is_admin,a.reg_date,a.show_mail ORDER BY number DESC, a.user_name ASC LIMIT $config_arr[page_start],$config_arr[user_per_page]");
                    $order_news = 'asc';
                    $arrow_news = '<img src="images/icons/pointer_down.gif" alt="" border="0" title="Absteigend" />';
                    break;
                }
                case 'news_asc': {
                    $users_sql = mysql_query("SELECT SUM(a.user_id = b.user_id) AS number, a.user_id,a.user_name,a.user_mail,a.is_admin,a.reg_date,a.show_mail FROM ".$global_config_arr[pref]."user a, ".$global_config_arr[pref]."news b GROUP BY a.user_id,a.user_name,a.user_mail,a.is_admin,a.reg_date,a.show_mail ORDER BY number ASC, a.user_name ASC LIMIT $config_arr[page_start],$config_arr[user_per_page]");
                    $order_news = 'desc';
                    $arrow_news = '<img src="images/icons/pointer_up.gif" alt="" border="0" title="Aufsteigend" />';
                    break;
                }
                case 'articles_desc': {
                    $users_sql = mysql_query("SELECT SUM(a.user_id = b.artikel_user) AS number, a.user_id,a.user_name,a.user_mail,a.is_admin,a.reg_date,a.show_mail FROM ".$global_config_arr[pref]."user a, ".$global_config_arr[pref]."artikel b GROUP BY a.user_id,a.user_name,a.user_mail,a.is_admin,a.reg_date,a.show_mail ORDER BY number DESC, a.user_name ASC LIMIT $config_arr[page_start],$config_arr[user_per_page]", $db);
                    $order_articles = 'asc';
                    $arrow_articles = '<img src="images/icons/pointer_down.gif" alt="" border="0" title="Absteigend" />';
                    break;
                }
                case 'articles_asc': {
                    $users_sql = mysql_query("SELECT SUM(a.user_id = b.artikel_user) AS number, a.user_id,a.user_name,a.user_mail,a.is_admin,a.reg_date,a.show_mail FROM ".$global_config_arr[pref]."user a, ".$global_config_arr[pref]."artikel b GROUP BY a.user_id,a.user_name,a.user_mail,a.is_admin,a.reg_date,a.show_mail ORDER BY number ASC, a.user_name ASC LIMIT $config_arr[page_start],$config_arr[user_per_page]", $db);
                    $order_articles = 'desc';
                    $arrow_articles = '<img src="images/icons/pointer_up.gif" alt="" border="0" title="Aufsteigend" />';
                    break;
                }
                case 'comments_desc': {
                    $users_sql = mysql_query("SELECT SUM(a.user_id = b.comment_poster_id) AS number, a.user_id,a.user_name,a.user_mail,a.is_admin,a.reg_date,a.show_mail FROM ".$global_config_arr[pref]."user a, ".$global_config_arr[pref]."news_comments b GROUP BY a.user_id,a.user_name,a.user_mail,a.is_admin,a.reg_date,a.show_mail ORDER BY number DESC, a.user_name ASC LIMIT $config_arr[page_start],$config_arr[user_per_page]", $db);
                    $order_comments = 'asc';
                    $arrow_comments = '<img src="images/icons/pointer_down.gif" alt="" border="0" title="Absteigend" />';
                    break;
                }
                case 'comments_asc': {
                    $users_sql = mysql_query("SELECT SUM(a.user_id = b.comment_poster_id) AS number, a.user_id,a.user_name,a.user_mail,a.is_admin,a.reg_date,a.show_mail FROM ".$global_config_arr[pref]."user a, ".$global_config_arr[pref]."news_comments b GROUP BY a.user_id,a.user_name,a.user_mail,a.is_admin,a.reg_date,a.show_mail ORDER BY number ASC, a.user_name ASC LIMIT $config_arr[page_start],$config_arr[user_per_page]", $db);
                    $order_comments = 'desc';
                    $arrow_comments = '<img src="images/icons/pointer_up.gif" alt="" border="0" title="Aufsteigend" />';
                    break;
                }
                default: {
                    $users_sql = mysql_query("SELECT user_id,user_name,user_mail,is_admin,reg_date,show_mail FROM ".$global_config_arr[pref]."user ORDER BY user_name, reg_date ASC LIMIT $config_arr[page_start],$config_arr[user_per_page]");
                    $order_name = 'desc';
                    $arrow_name = '<img src="images/icons/pointer_up.gif" alt="" border="0" title="Aufsteigend" />';
                    break;
                }
    }


$index = mysql_query("SELECT user_memberlist_userline FROM ".$global_config_arr[pref]."template WHERE id = '$global_config_arr[design]'");
$user_temp = stripslashes(mysql_result($index, 0, "user_memberlist_userline"));
        
$index = mysql_query("SELECT user_memberlist_adminline FROM ".$global_config_arr[pref]."template WHERE id = '$global_config_arr[design]'");
$admin_temp = stripslashes(mysql_result($index, 0, "user_memberlist_adminline"));

while ($user = mysql_fetch_assoc($users_sql))
{
    if ($user['is_admin']==1) {
      $temp = $admin_temp;
    } else {
      $temp = $user_temp;
    }

    $temp = str_replace("{username}", $user['user_name'], $temp);
    $temp = str_replace("{userlink}", "?go=profil&userid=".$user['user_id'], $temp);
    if (image_exists("images/avatare/",$user['user_id'])) {
      $temp = str_replace("{avatar}", '<img src="'.image_url("images/avatare/",$user['user_id'], false).'" />', $temp);
    } else {
      $temp = str_replace("{avatar}", "", $temp);
    }
    if ($user['show_mail']==1) {
      $temp = str_replace("{email}", $user['user_mail'], $temp);
    } else {
      $temp = str_replace("{email}", "", $temp);
    }
    $temp = str_replace("{reg_date}", date('d.m.Y', $user['reg_date']), $temp);


    // Written Comments
    $index = mysql_query("SELECT COUNT(comment_id) AS number FROM ".$global_config_arr[pref]."news_comments WHERE comment_poster_id = ".$user['user_id']."", $db);
    $temp = str_replace("{comments}", mysql_result($index, 0, "number"), $temp);
    // Written Articles
    $index = mysql_query("SELECT COUNT(article_id) AS number FROM ".$global_config_arr[pref]."articles WHERE article_user = ".$user['user_id']."", $db);
    $temp = str_replace("{articles}", mysql_result($index, 0, "number"), $temp);
    // Written News
    $index = mysql_query("SELECT COUNT(news_id) AS number FROM ".$global_config_arr[pref]."news WHERE user_id = ".$user['user_id']."", $db);
    $temp = str_replace("{news}", mysql_result($index, 0, "number"), $temp);

    $members_list .= $temp;
}

//Seitennavigation
$pagenav = stripslashes($global_config_arr[page]);
$prev = stripslashes($global_config_arr[page_prev]);
$next = stripslashes($global_config_arr[page_next]);
$pagenav = str_replace("{page_number}", $_GET[page], $pagenav );
$pagenav = str_replace("{total_pages}", $config_arr[number_of_pages], $pagenav );
//Zurück-Schaltfläche
if ($_GET['page'] > 1) {
  $prev = str_replace("{url}", "?go=members&sort=$_GET[sort]&page=$config_arr[oldpage]", $prev);
  $pagenav = str_replace("{prev}", $prev, $pagenav);
} else {
  $pagenav = str_replace("{prev}", "", $pagenav);
}
//Weiter-Schaltfläche
if (($_GET['page']*$config_arr[user_per_page]) < $config_arr[number_of_users]) {
  $next = str_replace("{url}", "?go=members&sort=$_GET[sort]&page=$config_arr[newpage]", $next);
  $pagenav = str_replace("{next}", $next, $pagenav);
} else {
  $pagenav = str_replace("{next}", "", $pagenav);
}

//Ausgabe der Seite
$index = mysql_query("SELECT user_memberlist_body FROM ".$global_config_arr[pref]."template WHERE id = '$global_config_arr[design]'");
$template = stripslashes(mysql_result($index, 0, "user_memberlist_body"));
$template = str_replace("{members}", $members_list, $template);
$template = str_replace("{page}", $pagenav, $template);
//Sort & Arrow replace
$template = str_replace("{order_name}", $order_name, $template);
$template = str_replace("{arrow_name}", $arrow_name, $template);
$template = str_replace("{order_regdate}", $order_regdate, $template);
$template = str_replace("{arrow_regdate}", $arrow_regdate, $template);
$template = str_replace("{order_news}", $order_news, $template);
$template = str_replace("{arrow_news}", $arrow_news, $template);
$template = str_replace("{order_articles}", $order_articles, $template);
$template = str_replace("{arrow_articles}", $arrow_articles, $template);
$template = str_replace("{order_comments}", $order_comments, $template);
$template = str_replace("{arrow_comments}", $arrow_comments, $template);

?>