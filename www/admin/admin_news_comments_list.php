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

                    $_POST['title'] && $_POST['title'] != '' &&
                    $_POST['text'] && $_POST['text'] != ''
            )
    {
        // unset data, so admin_news_edit.php doesnt perform anything
        $POSTDATA = $_POST;
        unset ($_POST);

        ob_start();
        require_once(FS2_ROOT_PATH.'admin/admin_news_edit.php');
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
        require_once(FS2_ROOT_PATH.'admin/admin_news_edit.php');
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

  //no b8 at first
  $b8 = NULL;
  //Is there something to do for b8?
  if (isset($_POST['commentid']) && isset($_POST['b8_action']))
  {
    //got work to do
    settype($_POST['commentid'], 'integer');
    $_POST['commentid'] = (int) $_POST['commentid'];
    //check comment's current status
    $query = $FD->sql()->conn()->query('SELECT comment_id, comment_title, comment_poster,
                  comment_poster_id, comment_text, comment_classification
                  FROM `'.$FD->config('pref').'comments` WHERE comment_id=\''.$_POST['commentid'].'\'');
    if ($result = $query->fetch(PDO::FETCH_ASSOC))
    {
      //found it, go on
      if ($result['comment_classification']!=0)
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
          $userindex = $FD->sql()->conn()->query('SELECT user_name FROM `'.$FD->config('pref').'user` WHERE user_id = \''.$result['comment_poster_id'].'\'');
          $comment_arr['comment_poster'] = $userindex->fetchColumn();
        }
        //include b8 stuff
        require_once FS2_ROOT_PATH.'resources/spamdetector/b8/b8.php';
        //create b8 object
        $success = true;
        try {
          $b8 = new b8(array('storage' => 'mysql'), array('connection' => $FD->sql()->conn()));
        }
        catch (Exception $e)
        {
          $success = false;
          $b8 = NULL; //free it
          echo '<center><b>Fehler:</b> Konnte b8 nicht starten! '.$e->getMessage().'</center>';
        }
        //check if construction was successful
        if ($success)
	    {
	      switch ($_POST['b8_action'])
	      {
	        case 'mark_as_ham':
                 $query = $FD->sql()->conn()->query('UPDATE `'.$FD->config('pref').'comments` SET comment_classification=\'1\' WHERE comment_id=\''.$_POST['commentid'].'\'');
                 if (!$query)
                 {
                   //SQL error?
                   $info = $FD->sql()->conn()->errorInfo();
                   echo $info[2];
                 }
	             $b8->learn(strtolower($result['comment_title'].' '.$result['comment_poster'].' '.$result['comment_text']), b8::HAM);
	             break;
	        case 'mark_as_spam':
	             $query = $FD->sql()->conn()->query('UPDATE `'.$FD->config('pref').'comments` SET comment_classification=\'-1\' WHERE comment_id=\''.$_POST['commentid'].'\'');
	             if (!$query)
                 {
                   //SQL error?
                   $info = $FD->sql()->conn()->errorInfo();
                   echo $info[2];
                 }
                 $b8->learn(strtolower($result['comment_title'].' '.$result['comment_poster'].' '.$result['comment_text']), b8::SPAM);
	             break;
	        default:
	             //Form manipulation or programmer's stupidity? I don't like it either way!
	             echo '<center><b>b8-Fehler:</b> Die angegebene Aktion ist nicht'
                     .'g&uuml;ltig.</center>';
                 break;
	      }//swi
	    }//else (b8 init successful)
      }//else
    }
    else
    {
      //not found, there is no such comment
      echo '<center><b>Fehler:</b> Kein Kommentar mit der angegebenen ID ist '
          .'vorhanden! Es wird keine Klassifizierung vorgenommen.</center>';
    }//else
  }//if b8

  //check GET parameter start
  if (!isset($_GET['start']) || $_GET['start']<0)
  {
    $_GET['start'] = 0;
  }
  $_GET['start'] = (int) $_GET['start'];
  settype($_GET['start'], 'integer');
  //Anzahl der Kommentare auslesen
  $query = $FD->sql()->conn()->query('SELECT COUNT(comment_id) AS cc FROM `'.$FD->config('pref').'comments` WHERE content_type=\'news\'');
  $cc = (int) $query->fetchColumn();
  if ($_GET['start']>=$cc)
  {
    $_GET['start'] = $cc - ($cc % 30);
  }

  //Kommentare auslesen
  $query = $FD->sql()->conn()->query('SELECT COUNT(comment_id)
                  FROM `'.$FD->config('pref').'comments`, `'.$FD->config('pref').'news`
                  WHERE `'.$FD->config('pref').'comments`.content_id=`'.$FD->config('pref').'news`.news_id
                         AND content_type=\'news\' 
                  ORDER BY comment_date DESC LIMIT '.$_GET['start'].', 30');
  $rows = $query->fetchColumn();
  $query = $FD->sql()->conn()->query('SELECT comment_id, comment_title, comment_date, comment_poster, comment_poster_id, comment_text,
                  `'.$FD->config('pref').'comments`.content_id AS news_id, `'.$FD->config('pref').'news`.news_id, news_title,
                  comment_classification
                  FROM `'.$FD->config('pref').'comments`, `'.$FD->config('pref').'news`
                  WHERE `'.$FD->config('pref').'comments`.content_id=`'.$FD->config('pref').'news`.news_id
                         AND content_type=\'news\' 
                  ORDER BY comment_date DESC LIMIT '.$_GET['start'].', 30');

  //Bereich (zahlenm‰ﬂig)
  $bereich = '<font class="small">'.($_GET['start']+1).' ... '.($_GET['start'] + $rows).'</font>';
  //Is this not the first page?
  if ($_GET['start']>0)
  {
    $prev_start = $_GET['start']-30;
    if ($prev_start<0)
    {
      $prev_start = 0;
    }
    $prev_page = '<a href="'.$_SERVER['PHP_SELF'].'?go=news_comments_list&start='.$prev_start.'"><- zur&uuml;ck</a>';
  }//if not first page
  //Is this not the last page?
  if ($_GET['start']+30<$cc)
  {
    $next_page = '<a href="'.$_SERVER['PHP_SELF'].'?go=news_comments_list&start='.($_GET['start']+30).'">weiter -></a>';
  }//if not the last page

echo <<<EOT
  <table class="configtable" cellpadding="4" cellspacing="0">
    <tr>
      <td class="line" colspan="5">Kommentarliste</td>
    </tr>
    <tr>
      <td class="config" width="30%">
          Titel
      </td>
      <td class="config" width="30%">
          Poster
      </td>
      <td class="config" width="20%">
          Datum
      </td>
      <td class="config" width="10%">
          Spamwahrscheinlichkeit
      </td>
      <td class="config" width="10%">
          bearbeiten
      </td>
    </tr>
EOT;
  require_once(FS2_ROOT_PATH . 'resources/spamdetector/eval_spam.inc.php');

  while ($comment_arr = $query->fetch(PDO::FETCH_ASSOC))
  {
    if ($comment_arr['comment_poster_id'] != 0)
    {
      $userindex = $FD->sql()->conn()->query('SELECT user_name FROM `'.$FD->config('pref').'user` WHERE user_id = \''.$comment_arr['comment_poster_id'].'\'');
      $comment_arr['comment_poster'] = $userindex->fetchColumn();
    }
    $comment_arr['comment_date'] = date('d.m.Y' , $comment_arr['comment_date'])
                                      .' um '.date('H:i' , $comment_arr['comment_date']);
    echo '<tr>
           <td class="configthin">
               '.$comment_arr['comment_title'].'
           </td>
           <td class="configthin">
               '.$comment_arr['comment_poster'];
    if ($comment_arr['comment_poster_id'] == 0)
    {
      echo '<br><small>(unregistriert)</small>';
    }
    echo '           </td>
           <td class="configthin">
               <span class="small">'.$comment_arr['comment_date'].'</span>
           </td>
           <td class="configthin">
               '.spamLevelToText(spamEvaluation($comment_arr['comment_title'],
                 $comment_arr['comment_poster_id'], $comment_arr['comment_poster'],
                 $comment_arr['comment_text'], true, $FD->sql()->conn())).'
           </td>
           <td class="configthin" rowspan="2">
             <form action="" method="post">
               <input type="hidden" name="sended" value="comment">
               <input type="hidden" name="news_action" value="comments">
               <input type="hidden" name="news_id[]" value="'.$comment_arr['news_id'].'">
               <input type="hidden" name="go" value="news_edit">
               <input type="hidden" name="comment_id[]" value="'.$comment_arr['comment_id'].'">
               <input type="hidden" name="comment_action" value="edit">
               <input class="button" type="submit" value="Editieren">
             </form>

             <form action="" method="post">
               <input type="hidden" name="sended" value="comment">
               <input type="hidden" name="news_action" value="comments">
               <input type="hidden" name="news_id[]" value="'.$comment_arr['news_id'].'">
               <input type="hidden" name="go" value="news_edit">
               <input type="hidden" name="comment_id[]" value="'.$comment_arr['comment_id'].'">
               <input type="hidden" name="comment_action" value="delete">
               <input class="button" type="submit" value="L&ouml;schen">
             </form>
           </td>
         </tr>
         <tr>
           <td style="text-align:center;" colspan="4"><font size="1">Zugeh&ouml;rige Newsmeldung: <a href="../?go=comments&id='
                                              .$comment_arr['news_id'].'" target="_blank">&quot;'
                                              .htmlentities($comment_arr['news_title'], ENT_QUOTES).'&quot;</a></font>
           </td>
         </tr>
         <tr>
           <td style="text-align:center;" colspan="5">';
    if ($comment_arr['comment_classification']==0)
    {
      //unclassified comment
      echo '         <form action="'.$_SERVER['PHP_SELF'].'" method="post" style="display:inline";>
               <input type="hidden" value="news_comments_list" name="go">
               <input type="hidden" value="'.$_GET['start'].'" name="start">
               <input type="hidden" name="commentid" value="'.$comment_arr['comment_id'].'">
               <input type="hidden" name="b8_action" value="mark_as_ham">
               <input class="button" type="submit" value="Kein Spam :)">
             </form><form action="'.$_SERVER['PHP_SELF'].'" method="post" style="display:inline";>
               <input type="hidden" value="news_comments_list" name="go">
               <input type="hidden" value="'.$_GET['start'].'" name="start">
               <input type="hidden" name="commentid" value="'.$comment_arr['comment_id'].'">
               <input type="hidden" name="b8_action" value="mark_as_spam">
               <input class="button" type="submit" value="Das ist Spam!">
             </form>';
    }//if class==0
    else if ($comment_arr['comment_classification']>0)
    {
      //comment classified as ham
      echo '<font color="#008000" size="1">Als spamfrei markiert</font>';
    }
    else if ($comment_arr['comment_classification']<0)
    {
      //comment classified as spam
      echo '<font color="#C00000" size="1">Als Spam markiert</font>';
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
echo <<<EOT
                                </td>
                            </tr>
                        </table>
EOT;


?>
