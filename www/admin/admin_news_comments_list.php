<?php if (!defined('ACP_GO')) die('Unauthorized access!');
/*
    This file is part of the Frogsystem Spam Detector.
    Copyright (C) 2011  Thoronador
    Copyright (C) 2011  Sweil (minor modifications)

    The Frogsystem Spam Detector is free software: you can redistribute it
    and/or modify it under the terms of the GNU General Public License as
    published by the Free Software Foundation, either version 3 of the License,
    or (at your option) any later version.

    The Frogsystem Spam Detector is distributed in the hope that it will be
    useful, but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

    Additional permission under GNU GPL version 3 section 7

    If you modify this Program, or any covered work, by linking or combining it
    with Frogsystem 2 (or a modified version of Frogsystem 2), containing parts
    covered by the terms of Creative Commons Attribution-ShareAlike 3.0, the
    licensors of this Program grant you additional permission to convey the
    resulting work. Corresponding Source for a non-source form of such a
    combination shall include the source code for the parts of Frogsystem used
    as well as that of the covered work.
*/

// perform comment actions

    // Edit Comments
    if (
        isset ( $_POST['news_id'] ) &&
        count ( $_POST['news_id'] ) == 1 &&
        isset ( $_POST['comment_id'] ) &&
        isset ( $_POST['sended'] ) && $_POST['sended'] == 'edit' &&
        isset ( $_POST['news_action'] ) && $_POST['news_action'] == 'comments' &&
        isset ( $_POST['comment_action'] ) && $_POST['comment_action'] == 'edit' &&

        isset ( $_POST['title'] ) && $_POST['title'] != '' &&
        isset ( $_POST['text'] ) && $_POST['text'] != ''
       )
    {
        // unset data, so admin_news_edit.php doesnt perform anything
        $POSTDATA = $_POST;
        unset ($_POST);

        ob_start();
        require_once(FS2SOURCE.'/admin/admin_news_edit.php');
        ob_end_clean();

        db_edit_comment ($POSTDATA);

        // Unset Vars
        unset ($POSTDATA);
    }

    // Delete Comments
    elseif (
            isset ( $_POST['news_id'] ) &&
            isset ( $_POST['comment_id'] ) &&
            isset ( $_POST['sended'] ) && $_POST['sended'] == 'delete' &&
            isset ( $_POST['news_action'] ) && $_POST['news_action'] == 'comments' &&
            isset ( $_POST['comment_action'] ) && $_POST['comment_action'] == 'delete' &&
            isset ( $_POST['comment_delete'] )
           )
    {
        // unset data, so admin_news_edit.php doesnt perform anything
        $POSTDATA = $_POST;
        unset ($_POST);

        ob_start();
        require_once(FS2SOURCE.'/admin/admin_news_edit.php');
        ob_end_clean();

        if ( $POSTDATA['comment_delete'] == 1 ) {
            db_delete_comment ( $POSTDATA );
        } else {
             systext( 'Kommentare wurden nicht gel&ouml;scht', $FD->text('admin', 'info'), "green", $FD->text('page', 'trash_error') );
        }

        // Unset Vars
        unset ($POSTDATA);
    }
//

  //Number of DB entries that should be updated per page load.
  // Value can be adjusted arbitrarily, but I guess it should not exceed 100,
  // if you want to avoid too much strain on the server.
  $update_limit = 30;

  //no b8 at first
  $b8 = NULL;
  //put b8-related GET parameters into POST, so we need to check $_POST only
  if (isset($_GET['commentid']) && !isset($_POST['commentid']))
  {
    $_POST['commentid'] = $_GET['commentid'];
    unset($_GET['commentid']);
  }
  if (isset($_GET['b8_action']) && !isset($_POST['b8_action']))
  {
    $_POST['b8_action'] = $_GET['b8_action'];
    unset($_GET['b8_action']);
  }

  //include b8 stuff
  require_once(FS2SOURCE . '/libs/spamdetector/b8/b8.php');

  //Is there something to do for b8?
  if (isset($_POST['commentid']) && isset($_POST['b8_action']))
  {
    //got work to do
    settype($_POST['commentid'], 'integer');
    $_POST['commentid'] = (int) $_POST['commentid'];
    //check comment's current status
    $query = $FD->db()->conn()->query('SELECT comment_id, comment_title, comment_poster,
                  comment_poster_id, comment_text, comment_classification
                  FROM `'.$FD->env('DB_PREFIX').'comments` WHERE comment_id=\''.$_POST['commentid'].'\'');
    if ($result = $query->fetch(PDO::FETCH_ASSOC))
    {
      //found it, go on
      if (($result['comment_classification']!=0) && ($_POST['b8_action']!='unclassify'))
      {
        //already has classification
        echo '<center><b>Fehler:</b> Der Kommentar mit der angegebenen ID ist '
          .'schon als ';
        if ($result['comment_classification']>0)
        {
          echo 'spamfrei';
        }
        else
        {
          echo 'Spam';
        }
        echo ' klassifiert!</center>';
      }//if classification<>0
      else
      {
        //no classification, go for it!
        // -- retrieve name, if applicable
        if ($result['comment_poster_id'] != 0)
        {
          $userindex = $FD->db()->conn()->query('SELECT user_name FROM `'.$FD->env('DB_PREFIX').'user` WHERE user_id = \''.$result['comment_poster_id'].'\'');
          $comment_arr['comment_poster'] = $userindex->fetchColumn();
        }
        //create b8 object
        $success = true;
        try {
          $b8 = new b8(array('storage' => 'mysql'), array('table_name' => $FD->env('DB_PREFIX').'b8_wordlist', 'connection' => $FD->db()->conn()));
        }
        catch (Exception $e)
        {
          $success = false;
          $b8 = NULL; //free it
          echo '<center><b>'.$FD->text('admin', 'error').':</b> '.$FD->text('page', 'b8_no_start').' '.$e->getMessage().'</center>';
        }
        //check if construction was successful
        if ($success)
	    {
	      switch ($_POST['b8_action'])
	      {
	        case 'mark_as_ham':
                 $query = $FD->db()->conn()->query('UPDATE `'.$FD->env('DB_PREFIX').'comments` SET comment_classification=\'1\' WHERE comment_id=\''.$_POST['commentid'].'\'');
                 if (!$query)
                 {
                   //SQL error?
                   $info = $FD->db()->conn()->errorInfo();
                   echo $info[2];
                 }
	             $b8->learn(strtolower($result['comment_title'].' '.$result['comment_poster'].' '.$result['comment_text']), b8::HAM);
	             break;
	        case 'mark_as_spam':
	             $query = $FD->db()->conn()->query('UPDATE `'.$FD->env('DB_PREFIX').'comments` SET comment_classification=\'-1\' WHERE comment_id=\''.$_POST['commentid'].'\'');
	             if (!$query)
                 {
                   //SQL error?
                   $info = $FD->db()->conn()->errorInfo();
                   echo $info[2];
                 }
                 $b8->learn(strtolower($result['comment_title'].' '.$result['comment_poster'].' '.$result['comment_text']), b8::SPAM);
	             break;
	        case 'unclassify':
	             if ($result['comment_classification']!=0)
	             {
	               $query = $FD->db()->conn()->query('UPDATE `'.$FD->env('DB_PREFIX')."comments` SET comment_classification='0' WHERE comment_id='".$_POST['commentid']."'");
	               if ($result['comment_classification']>0)
	               {
	                 //it's marked as ham, revoke it
	                 $b8->unlearn(strtolower($result['comment_title'].' '.$result['comment_poster'].' '.$result['comment_text']), b8::HAM);
	               }
	               else
	               {
	                 //it's marked as spam, revoke it
	                 $b8->unlearn(strtolower($result['comment_title'].' '.$result['comment_poster'].' '.$result['comment_text']), b8::SPAM);
	               }
	             }
	             else
	             {
	               //cannot unclassify a comment that has no classification
	               echo '<center><b>'.$FD->text('page', 'b8_error').':</b> '.$FD->text('page', 'b8_not_classified').'</center>';
	             }
	             break;
	        default:
	             //Form manipulation or programmer's stupidity? I don't like it either way!
	             echo '<center><b>'.$FD->text('page', 'b8_error').':</b> '.$FD->text('page', 'b8_invalid_action').'</center>';
                 break;
	      }//swi
	    }//else (b8 init successful)
      }//else
    }
    else
    {
      //not found, there is no such comment
      echo '<center>'.$FD->text('page', 'b8_no_comment').'</center>';
    }//else
  }//if b8

  // ---- update probability values in DB, if required
  //check update limit
  settype($update_limit, 'integer');
  if ($update_limit<10)
  {
    //prevent negative and ridiculously small values
    $update_limit = 10;
  }
  else if ($update_limit>100)
  {
    //avoid higher values to reduce server load
    $update_limit = 100;
  }
  //evaluation functions
  require_once(FS2SOURCE . '/libs/spamdetector/eval_spam.inc.php');
  //create b8 object
  if ($b8==NULL)
  {
    try {
      $b8 = new b8(array('storage' => 'mysql'), array('table_name' => $FD->env('DB_PREFIX').'b8_wordlist', 'connection' => $FD->db()->conn()));
    }
    catch (Exception $e)
    {
      $b8 = NULL;
    }
  }
  if ($b8===NULL)
  {
    echo '<center>'.$FD->text('admin', 'error').':</b> '.$FD->text('page', 'b8_no_start').'</center>';
  }
  else
  {
    //get comments that need an update
    $update_query = $FD->db()->conn()->query('SELECT comment_id, comment_title, comment_poster, comment_poster_id, comment_text,
                        IF(comment_poster_id=0, comment_poster, `'.$FD->env('DB_PREFIX').'user`.user_name) AS real_name
                        FROM `'.$FD->env('DB_PREFIX').'comments` LEFT JOIN `'.$FD->env('DB_PREFIX').'user`
                        ON `'.$FD->env('DB_PREFIX').'comments`.comment_poster_id=`'.$FD->env('DB_PREFIX').'user`.user_id
                        WHERE needs_update=1 ORDER BY ABS(0.5-spam_probability) LIMIT '.$update_limit);
    while ($row=$update_query->fetch(PDO::FETCH_ASSOC))
    {
      $prob = spamEvaluation($row['comment_title'], $row['comment_poster_id'],
                             $row['real_name'], $row['comment_text'],
                             true, $b8);
      //this check is needed to distinguish fallback values (integer) from b8 values (float)
      if (is_float($prob))
      {
        $FD->db()->conn()->exec('UPDATE `'.$FD->env('DB_PREFIX')."comments`
                   SET needs_update='0', spam_probability='".$prob."'
                   WHERE comment_id='".$row['comment_id']."' LIMIT 1");
      }
    }//while
  }//else

  //statistics requested?
  if (isset($_REQUEST['b8_stats']))
  {
    $query = $FD->db()->conn()->query('SELECT * FROM `'.$FD->env('DB_PREFIX').'b8_wordlist` WHERE token LIKE \'b8*%\' LIMIT 2');
    $b8_info = array();
    while ($result = $query->fetch(PDO::FETCH_ASSOC))
    {
      switch ($result['token'])
      {
        case 'b8*texts':
             $b8_info['b8*texts.ham'] = $result['count_ham'];
             $b8_info['b8*texts.spam'] = $result['count_spam'];
             break;
        case 'b8*dbversion':
             $b8_info['b8*dbversion'] = $result['count_ham'];
             break;
      }//swi
    }//while
    echo '
    <table class="configtable" cellpadding="4" cellspacing="0">
      <tr>
        <td style="text-align:center;" class="line" colspan="3">
           <strong>'.$FD->text('page', 'stat_wordlist').'</strong>
        </td>
      </tr>
      <tr>
        <td class="config" width="33%">
          '.$FD->text('page', 'learned_ham').'
        </td>
        <td class="config" width="33%">
          '.$FD->text('page', 'learned_spam').'
        </td>
        <td class="config">
           '.$FD->text('page', 'b8_db_version').'
        </td>
      </tr>
      <tr>
        <td class="configthin" style="text-align:center;">'.$b8_info['b8*texts.ham'].'</td>
        <td class="configthin" style="text-align:center;">'.$b8_info['b8*texts.spam'].'</td>
        <td class="configthin" style="text-align:center;">'.$b8_info['b8*dbversion'].'</td>
      </tr>
    </table>';
    //get number of comments that need a probability update
    $query = $FD->db()->conn()->query('SELECT COUNT(*) AS update_count
                    FROM `'.$FD->env('DB_PREFIX').'comments` WHERE needs_update=1');
    $update_count = $query->fetchColumn();
    //get total number of comments in DB
    $query = $FD->db()->doQuery('SELECT COUNT(*) AS total_count
                    FROM `'.$FD->env('DB_PREFIX').'comments`');
    $total_count = $query->fetchColumn();
    if ($total_count>0)
    {
      $percentage = round(((float)$update_count) / ((float)$total_count) * 100.0, 1);
    }
    else
    {
      $percentage = 0;
    }
    echo '
    <table class="configtable" cellpadding="4" cellspacing="0">
      <tr>
        <td class="config" width="50%">
          '.$FD->text('page', 'comments_not_up_to_date').'
        </td>
        <td class="config" width="50%">
          '.$FD->text('page', 'comments_total').'
        </td>
      </tr>
      <tr>
        <td class="configthin" style="text-align:center;">'.$update_count.' ('.$percentage.'%)<br>
          <small>'.$FD->text('page', 'not_up_to_date_note').'</small>
        </td>
        <td class="configthin" style="text-align:center;">'.$total_count.'</td>
      </tr>
    </table>';
    //get most used ham words
    $query = $FD->db()->conn()->query('SELECT token, count_ham
                    FROM `'.$FD->env('DB_PREFIX').'b8_wordlist` WHERE token NOT LIKE \'b8*%\'
                    ORDER BY count_ham DESC LIMIT 30');
    $ham_words = array();
    while ($result = $query->fetch(PDO::FETCH_ASSOC))
    {
      $ham_words[] = array('token' => $result['token'], 'ham' => (int) $result['count_ham']);
    }//while
    //get most used spam words
    $query = $FD->db()->conn()->query('SELECT token, count_spam
                    FROM `'.$FD->env('DB_PREFIX').'b8_wordlist` WHERE token NOT LIKE \'b8*%\'
                    ORDER BY count_spam DESC LIMIT 30');
    $spam_words = array();
    while ($result = $query->fetch(PDO::FETCH_ASSOC))
    {
      $spam_words[] = array('token' => $result['token'], 'spam' => (int) $result['count_spam']);
    }//while
    $ham_count = count($ham_words);
    $spam_count = count($spam_words);
    $max_count = max($ham_count, $spam_count);
    //print table
    echo '<br><br>
    <table border="0" cellpadding="2" cellspacing="0" class="configtable">
      <tr>
        <td style="text-align:center;" class="config" colspan="2" width="50%">
           '.$FD->text('page', 'frequent_spam').'
        </td>
        <td style="text-align:center;" class="config" colspan="2" width="50%">
           '.$FD->text('page', 'frequent_ham').'
        </td>
      </tr>
      <tr>
        <td class="config">
           '.$FD->text('page', 'token').'
        </td>
        <td style="text-align:center;" class="config">
           '.$FD->text('page', 'number').'
        </td>
        <td class="config">
           '.$FD->text('page', 'token').'
        </td>
        <td style="text-align:center;" class="config">
           '.$FD->text('page', 'number').'
        </td>
      </tr>';
    if ($max_count==0)
    {
      echo '<tr>
        <td style="text-align:center;" class="configthin" colspan="4">
           <strong>'.$FD->text('page', 'no_tokens_available').'</strong>
        </td>
      </tr>';
    }
    else
    {
      for ($i=0; $i<$max_count; $i = $i +1)
      {
        //Spam
        if ($i<$spam_count)
        {
          echo '<tr>
        <td class="configthin">'.htmlspecialchars($spam_words[$i]['token']).'</td>
        <td class="configthin" style="text-align:center;">'.$spam_words[$i]['spam'].'</td>';
        }
        else
        {
          echo '<tr>
        <td class="configthin" colspan="2"> </td>';
        }
        //Ham
        if ($i<$ham_count)
        {
          echo '<td class="configthin">'.htmlspecialchars($ham_words[$i]['token']).'</td>
        <td class="configthin" style="text-align:center;">'.$ham_words[$i]['ham'].'</td>
      </tr>';
        }
        else
        {
          echo '<td class="configthin" colspan="2"> </td></tr>';
        }
      }//for
    }//else (Tokens present)

    echo '</table>
    <br>
    <center><a href="'.$_SERVER['PHP_SELF'].'?go=news_comments_list">'.$FD->text('page', 'back_to_list').'</a></center><br>';
  }//if stats requested
  else
  {
    //no stats, normal list

  //check GET parameter start
  if (!isset($_GET['start']) || $_GET['start']<0)
  {
    $_GET['start'] = 0;
  }
  $_GET['start'] = (int) $_GET['start'];
  settype($_GET['start'], 'integer');
  //check GET parameter order
  if (isset($_POST['order']) && !isset($_GET['order']))
  {
    //value of order can be sent via POST (form), too
    $_GET['order'] = $_POST['order'];
  }
  if (!isset($_GET['order']))
  {
    $_GET['order'] = 1;
  }
  settype($_GET['order'], 'integer');
  //check allowed values
  if ($_GET['order']!=1)
  {
    $_GET['order'] = 0;
  }//if
  //sort criterion set?
  if (!isset($_GET['sort']))
  {
    $_GET['sort'] = 'date';
  }
  settype($_GET['sort'], 'string');

  //get number of comments
  $query = $FD->db()->conn()->query('SELECT COUNT(comment_id) AS cc FROM `'.$FD->env('DB_PREFIX').'comments` WHERE content_type=\'news\'');
  $cc = (int) $query->fetchColumn();
  if ($_GET['start']>=$cc)
  {
    $_GET['start'] = $cc - ($cc % 30);
  }
  //check for valid parameters and set order clause
  switch ($_GET['sort'])
  {
    case 'date':
         $order = 'comment_date';
         break;
    case 'name':
         $order = 'real_name';
         break;
    case 'title':
         $order = 'comment_title';
         break;
    case 'prob':
         $order = 'spam_probability';
         break;
    default:
         $_GET['sort'] = 'date';
         $order = 'comment_date';
         break;
  }//swi
  if ($_GET['order']===0)
  {
    $order .= ' ASC';
  }
  else
  {
    $order .= ' DESC';
  }

  //Read comments from DB
  $query = $FD->db()->conn()->query('SELECT COUNT(comment_id)
                  FROM `'.$FD->env('DB_PREFIX').'comments`, `'.$FD->env('DB_PREFIX').'news`
                  WHERE `'.$FD->env('DB_PREFIX').'comments`.content_id=`'.$FD->env('DB_PREFIX').'news`.news_id
                         AND content_type=\'news\'
                  ORDER BY comment_date DESC LIMIT '.$_GET['start'].', 30');
  $rows = $query->fetchColumn();
  $query = $FD->db()->conn()->query('SELECT comment_id, comment_title, comment_date, comment_poster, comment_poster_id, comment_text,
                  `'.$FD->env('DB_PREFIX').'comments`.content_id AS news_id, `'.$FD->env('DB_PREFIX').'news`.news_id, news_title,
                  IF(comment_poster_id=0, comment_poster, `'.$FD->env('DB_PREFIX').'user`.user_name) AS real_name,
                  comment_classification, needs_update
                  FROM `'.$FD->env('DB_PREFIX').'comments` LEFT JOIN `'.$FD->env('DB_PREFIX').'user`
                  ON `'.$FD->env('DB_PREFIX').'comments`.comment_poster_id=`'.$FD->env('DB_PREFIX').'user`.user_id, `'.$FD->env('DB_PREFIX').'news`
                  WHERE `'.$FD->env('DB_PREFIX').'comments`.content_id=`'.$FD->env('DB_PREFIX').'news`.news_id
                         AND content_type=\'news\'
                  ORDER BY '.$order.' LIMIT '.$_GET['start'].', 30');

  //Range (numbers)
  $bereich = '<font class="small">'.($_GET['start']+1).' ... '.($_GET['start'] + $rows).'</font>';
  //Is this not the first page?
  if ($_GET['start']>0)
  {
    $prev_start = $_GET['start']-30;
    if ($prev_start<0)
    {
      $prev_start = 0;
    }
    $prev_page = '<a href="'.$_SERVER['PHP_SELF'].'?go=news_comments_list&amp;sort='.$_GET['sort'].'&amp;order='.$_GET['order'].'&amp;start='.$prev_start.'">&lt;- '.$FD->text('page', 'prev').'</a>';
  }//if not first page
  //Is this not the last page?
  if ($_GET['start']+30<$cc)
  {
    $next_page = '<a href="'.$_SERVER['PHP_SELF'].'?go=news_comments_list&amp;sort='.$_GET['sort'].'&amp;order='.$_GET['order'].'&amp;start='.($_GET['start']+30).'">'.$FD->text('page', 'next').' -&gt;</a>';
  }//if not the last page

  $inverse_order = ($_GET['order']+1) % 2;

echo '
  <table class="configtable" cellpadding="4" cellspacing="0">
    <tr>
      <td class="line" colspan="5">'.$FD->text('page', 'comments_list').'</td>
    </tr>
    <tr>
      <td class="config" width="30%">
          <a href="'.$_SERVER['PHP_SELF'].'?go=news_comments_list&amp;sort=title&amp;order='.$inverse_order.'&amp;start='.$_GET['start'].'">'.$FD->text('page', 'title').'</a>
      </td>
      <td class="config" width="30%">
          <a href="'.$_SERVER['PHP_SELF'].'?go=news_comments_list&amp;sort=name&amp;order='.$inverse_order.'&amp;start='.$_GET['start'].'">'.$FD->text('page', 'poster').'</a>
      </td>
      <td class="config" width="20%">
          <a href="'.$_SERVER['PHP_SELF'].'?go=news_comments_list&amp;sort=date&amp;order='.$inverse_order.'&amp;start='.$_GET['start'].'">'.$FD->text('page', 'date').'</a>
      </td>
      <td class="config" width="10%">
          <a href="'.$_SERVER['PHP_SELF'].'?go=news_comments_list&amp;sort=prob&amp;order='.$inverse_order.'&amp;start='.$_GET['start'].'">'.$FD->text('page', 'spam_prob').'</a>
      </td>
      <td class="config" width="10%">
          '.$FD->text('admin', 'edit').'
      </td>
    </tr>
  ';
  require_once(FS2SOURCE . '/libs/spamdetector/eval_spam.inc.php');

  while ($comment_arr = $query->fetch(PDO::FETCH_ASSOC))
  {
    if ($comment_arr['comment_poster_id'] != 0)
    {
      $comment_arr['comment_poster'] = $comment_arr['real_name'];
    }
    $comment_arr['comment_date'] = date($FD->text('admin', 'date_time'), $comment_arr['comment_date']);
    echo '<tr>
           <td class="configthin">
               '.$comment_arr['comment_title'].'
           </td>
           <td class="configthin">
               '.$comment_arr['comment_poster'];
    if ($comment_arr['comment_poster_id'] == 0)
    {
      echo '<br><small>('.$FD->text('page', 'not_registered').')</small>';
    }
    echo '           </td>
           <td class="configthin">
               <span class="small">'.$comment_arr['comment_date'].'</span>
           </td>
           <td class="configthin">
               ';
    $prob = spamEvaluation($comment_arr['comment_title'],
            $comment_arr['comment_poster_id'], $comment_arr['real_name'],
            $comment_arr['comment_text'], ($b8!==NULL), $b8);
    if (($comment_arr['needs_update']==1) && is_float($prob))
    {
      $FD->db()->conn()->exec('UPDATE `'.$FD->env('DB_PREFIX')."comments`
                 SET needs_update='0', spam_probability='".$prob."'
                 WHERE comment_id='".$comment_arr['comment_id']."' LIMIT 1");
    }
    echo spamLevelToText($prob).'
           </td>
           <td class="configthin" rowspan="2">
             <form action="" method="post">
               <input type="hidden" name="sended" value="comment">
               <input type="hidden" name="news_action" value="comments">
               <input type="hidden" name="news_id[]" value="'.$comment_arr['news_id'].'">
               <input type="hidden" name="go" value="news_edit">
               <input type="hidden" name="comment_id[]" value="'.$comment_arr['comment_id'].'">
               <input type="hidden" name="comment_action" value="edit">
               <input class="button" type="submit" value="'.htmlspecialchars($FD->text('admin', 'edit')).'">
             </form>

             <form action="" method="post">
               <input type="hidden" name="sended" value="comment">
               <input type="hidden" name="news_action" value="comments">
               <input type="hidden" name="news_id[]" value="'.$comment_arr['news_id'].'">
               <input type="hidden" name="go" value="news_edit">
               <input type="hidden" name="comment_id[]" value="'.$comment_arr['comment_id'].'">
               <input type="hidden" name="comment_action" value="delete">
               <input class="button" type="submit" value="'.htmlspecialchars($FD->text('admin', 'delete')).'">
             </form>
           </td>
         </tr>
         <tr>
           <td style="text-align:center;" colspan="4"><font size="1">'.$FD->text('page', 'related_news').': <a href="../?go=comments&amp;id='
                                              .$comment_arr['news_id'].'" target="_blank">&quot;'
                                              .htmlentities($comment_arr['news_title'], ENT_QUOTES).'&quot;</a></font>
           </td>
         </tr>
         <tr>
           <td style="text-align:center;" colspan="5">';
    if ($comment_arr['comment_classification']==0)
    {
      //unclassified comment
      echo '         <form action="'.$_SERVER['PHP_SELF'].'" method="post" style="display:inline;">
               <input type="hidden" value="news_comments_list" name="go">
               <input type="hidden" value="'.$_GET['start'].'" name="start">
               <input type="hidden" value="'.$_GET['sort'].'" name="sort">
               <input type="hidden" value="'.$_GET['order'].'" name="order">
               <input type="hidden" name="commentid" value="'.$comment_arr['comment_id'].'">
               <input type="hidden" name="b8_action" value="mark_as_ham">
               <input class="button" type="submit" value="'.$FD->text('page', 'no_spam').'">
             </form><form action="'.$_SERVER['PHP_SELF'].'" method="post" style="display:inline;">
               <input type="hidden" value="news_comments_list" name="go">
               <input type="hidden" value="'.$_GET['start'].'" name="start">
               <input type="hidden" value="'.$_GET['sort'].'" name="sort">
               <input type="hidden" value="'.$_GET['order'].'" name="order">
               <input type="hidden" name="commentid" value="'.$comment_arr['comment_id'].'">
               <input type="hidden" name="b8_action" value="mark_as_spam">
               <input class="button" type="submit" value="'.$FD->text('page', 'it_is_spam').'">
             </form>';
    }//if class==0
    else if ($comment_arr['comment_classification']>0)
    {
      //comment classified as ham
      echo '<font color="#008000" size="1">'.$FD->text('page', 'marked_as_ham').'</font> <a href="'
          .$_SERVER['PHP_SELF'].'?go=news_comments_list&amp;b8_action=unclassify&amp;commentid='
          .$comment_arr['comment_id'].'&amp;start='.$_GET['start'].'&amp;sort='.$_GET['sort']
          .'&amp;order='.$_GET['order'].'"><font size="1">('.$FD->text('page', 'revert').')</font></a>';
    }
    else if ($comment_arr['comment_classification']<0)
    {
      //comment classified as spam
      echo '<font color="#C00000" size="1">'.$FD->text('page', 'marked_as_spam').'</font> <a href="'
          .$_SERVER['PHP_SELF'].'?go=news_comments_list&amp;b8_action=unclassify&amp;commentid='
          .$comment_arr['comment_id'].'&amp;start='.$_GET['start'].'&amp;sort='.$_GET['sort']
          .'&amp;order='.$_GET['order'].'"><font size="1">('.$FD->text('page', 'revert').')</font></a>';
    }
echo '         </td>
         </tr>
         <tr>
           <td colspan="5"><hr width="95%" style="color: #cccccc; background-color: #cccccc;"></td>
         </tr>';
  }//while
echo <<<EOT
    <tr>
      <td colspan="5">
          &nbsp;
      </td>
    </tr>
  </table>

                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr valign="middle">
                                <td width="33%" class="configthin middle">
EOT;
  if (isset($prev_page))
  {
    echo $prev_page;
  }
echo <<<EOT
                                </td>
                                <td width="33%" align="center" class="middle">
EOT;
  if (isset($bereich))
  {
    echo $bereich;
  }
echo <<<EOT
                                </td>
                                <td width="33%" style="text-align:right;" class="configthin middle">
EOT;
  if (isset($next_page))
  {
    echo $next_page;
  }
echo '
                                </td>
                            </tr>
                            <tr>
                            <td colspan="3" style="text-align:center;" class="configthin">
                              <a href="'.$_SERVER['PHP_SELF'].'?go=news_comments_list&amp;b8_stats=1">'.$FD->text('page', 'show_stats').'</a>
                            </td>
                          </tr>
                        </table>';
  } //else
?>
