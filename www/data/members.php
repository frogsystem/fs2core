<?php

function php_multisort($data,$keys){
  // List As Columns
  foreach ($data as $key => $row) {
    foreach ($keys as $k){
      $cols[$k['key']][$key] = $row[$k['key']];
    }
  }
  // List original keys
  $idkeys=array_keys($data);
  // Sort Expression
  $i=0;
  foreach ($keys as $k){
    if($i>0){$sort.=',';}
    $sort.='$cols['.$k['key'].']';
    if($k['sort']){$sort.=',SORT_'.strtoupper($k['sort']);}
    if($k['type']){$sort.=',SORT_'.strtoupper($k['type']);}
    $i++;
  }
  $sort.=',$idkeys';
  // Sort Funct
  $sort='array_multisort('.$sort.');';
  eval($sort);
  // Rebuild Full Array
  foreach($idkeys as $idkey){
    $result[]=$data[$idkey];
  }
  return $result;
}


// arrows & order links
if (!isset($_GET['sort'])) {
  $_GET['sort'] = 'default';
}

function get_sort () {
	switch($_GET['sort']) {
        case 'name_desc': {
            $sort = "user_name";
            break;
        }
        case 'name_asc': {
            $sort = "user_name";
            break;
        }
        case 'regdate_desc': {
            $sort = "user_reg_date";
            break;
        }
        case 'regdate_asc': {
            $sort = "user_reg_date";
            break;
        }
        case 'news_desc': {
            $sort = "num_news";
            break;
        }
        case 'news_asc': {
            $sort = "num_news";
            break;
        }
        case 'articles_desc': {
            $sort = "num_articles";
            break;
        }
        case 'articles_asc': {
            $sort = "num_articles";
            break;
        }
        case 'comments_desc': {
            $sort = "num_comments";
            break;
        }
        case 'comments_asc': {
            $sort = "num_comments";
            break;
        }
        default: {
            $sort = "user_name";
            break;
        }
	}
	return $sort;
}

function get_order () {
	switch($_GET['sort']) {
        case 'name_desc': {
            $order = "desc";
            break;
        }
        case 'name_asc': {
            $order = "asc";
            break;
        }
        case 'regdate_desc': {
            $order = "desc";
            break;
        }
        case 'regdate_asc': {
            $order = "asc";
            break;
        }
        case 'news_desc': {
            $order = "desc";
            break;
        }
        case 'news_asc': {
            $order = "asc";
            break;
        }
        case 'articles_desc': {
            $order = "desc";
            break;
        }
        case 'articles_asc': {
            $order = "asc";
            break;
        }
        case 'comments_desc': {
            $order = "desc";
            break;
        }
        case 'comments_asc': {
            $order = "asc";
            break;
        }
        default: {
            $order = "asc";
            break;
        }
	}
	return $order;
}

//config_arr
$index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."user_config", $db);
$config_arr = mysql_fetch_assoc($index);

//load user
$index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."user ORDER BY user_name ASC", $db);
while ( $tmp_user_arr = mysql_fetch_assoc ( $index ) ) {
    // Written Comments
    $index2 = mysql_query ( "
								SELECT COUNT(`comment_id`) AS 'number'
								FROM `".$global_config_arr['pref']."news_comments`
								WHERE `comment_poster_id` = '".$tmp_user_arr['user_id']."'
	", $db);
    $tmp_user_arr['num_comments'] = mysql_result($index2, 0, "number");
    // Written Articles
    $index2 = mysql_query ( "
								SELECT COUNT(`article_id`) AS 'number'
								FROM `".$global_config_arr['pref']."articles`
								WHERE `article_user` = '".$tmp_user_arr['user_id']."'
	", $db);
    $tmp_user_arr['num_articles'] = mysql_result($index2, 0, "number");
    // Written News
    $index2 = mysql_query ( "
								SELECT COUNT(`news_id`) AS 'number'
								FROM `".$global_config_arr['pref']."news`
								WHERE `user_id` = '".$tmp_user_arr['user_id']."'
	", $db);
    $tmp_user_arr['num_news'] = mysql_result($index2, 0, "number");

	$DATA[] = $tmp_user_arr;
}
$user_arr = php_multisort($DATA, array  ( array ( 'key'=>get_sort(), 'sort'=>get_order() ), array ( 'key'=>'user_name', 'sort'=>'asc') ) );


$order_name = 'asc'; $order_regdate = 'asc'; $order_news = 'desc'; $order_articles = 'desc'; $order_comments = 'desc';
$arrow_name = ''; $arrow_regdate = ''; $arrow_news = ''; $arrow_articles = ''; $arrow_comments = '';

switch($_GET['sort']) {
        case 'name_desc': {
            $order_name = 'asc';
            $arrow_name = '<img src="images/icons/pointer_down.gif" alt="" border="0" title="Absteigend">';
            break;
        }
        case 'name_asc': {
            $order_name = 'desc';
            $arrow_name = '<img src="images/icons/pointer_up.gif" alt="" border="0" title="Aufsteigend">';
            break;
        }
        case 'regdate_desc': {
            $order_regdate = 'asc';
            $arrow_regdate = '<img src="images/icons/pointer_down.gif" alt="" border="0" title="Absteigend">';
            break;
        }
        case 'regdate_asc': {
            $order_regdate = 'desc';
            $arrow_regdate = '<img src="images/icons/pointer_up.gif" alt="" border="0" title="Aufsteigend">';
            break;
        }
        case 'news_desc': {
            $order_news = 'asc';
            $arrow_news = '<img src="images/icons/pointer_down.gif" alt="" border="0" title="Absteigend">';
            break;
        }
        case 'news_asc': {
            $order_news = 'desc';
            $arrow_news = '<img src="images/icons/pointer_up.gif" alt="" border="0" title="Aufsteigend">';
            break;
        }
        case 'articles_desc': {
            $order_articles = 'asc';
            $arrow_articles = '<img src="images/icons/pointer_down.gif" alt="" border="0" title="Absteigend">';
            break;
        }
        case 'articles_asc': {
            $order_articles = 'desc';
            $arrow_articles = '<img src="images/icons/pointer_up.gif" alt="" border="0" title="Aufsteigend" />';
            break;
        }
        case 'comments_desc': {
            $order_comments = 'asc';
            $arrow_comments = '<img src="images/icons/pointer_down.gif" alt="" border="0" title="Absteigend" />';
            break;
        }
        case 'comments_asc': {
            $order_comments = 'desc';
            $arrow_comments = '<img src="images/icons/pointer_up.gif" alt="" border="0" title="Aufsteigend" />';
            break;
        }
        default: {
            $order_name = 'desc';
            $arrow_name = '<img src="images/icons/pointer_up.gif" alt="" border="0" title="Aufsteigend">';
            break;
        }
}

//Wieviele User
$config_arr[number_of_users] = count ( $user_arr );
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

// templates laden
$user_temp = get_template ( "user_memberlist_userline" );
$admin_temp = get_template ( "user_memberlist_adminline" );

// security functions
unset ( $members_list );

// display users
$maximum = $config_arr[page_start]+$config_arr[user_per_page];
if ( $maximum > count ( $user_arr ) ) {
    $maximum = count ( $user_arr );
}
for ( $i = $config_arr[page_start]; $i < $maximum; $i++ )
{
    if ( $user_arr[$i]['user_is_staff'] == 1 || $user_arr[$i]['user_is_admin'] == 1 ) {
      $temp = $admin_temp;
    } else {
      $temp = $user_temp;
    }

    $temp = str_replace("{username}", $user_arr[$i]['user_name'], $temp);
    $temp = str_replace("{userlink}", "?go=profil&userid=".$user_arr[$i]['user_id'], $temp);
    if (image_exists("images/avatare/",$user_arr[$i]['user_id'])) {
      $temp = str_replace("{avatar}", '<img src="'.image_url("images/avatare/",$user_arr[$i]['user_id'], false).'">', $temp);
    } else {
      $temp = str_replace("{avatar}", "", $temp);
    }
    if ($user['show_mail']==1) {
      $temp = str_replace("{email}", $user_arr[$i]['user_mail'], $temp);
    } else {
      $temp = str_replace("{email}", "", $temp);
    }
    $temp = str_replace("{reg_date}", date('d.m.Y', $user_arr[$i]['user_reg_date']), $temp);
    $temp = str_replace("{comments}", $user_arr[$i]['num_comments'], $temp);
    $temp = str_replace("{articles}", $user_arr[$i]['num_articles'], $temp);
    $temp = str_replace("{news}", $user_arr[$i]['num_news'], $temp);
    
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
$template = get_template ( "user_memberlist_body" );
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