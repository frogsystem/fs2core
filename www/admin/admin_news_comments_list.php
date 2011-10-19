<?php
/*
    This file is part of the Frogsystem Spam Detector.
    Copyright (C) 2011  Thoronador

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

  //statistics requested?
  if (isset($_REQUEST['b8_stats']))
  {
    $query = mysql_query('SELECT * FROM b8_wordlist WHERE token LIKE \'bayes*%\'' , $db);
    $b8_info = array();
    while ($result = mysql_fetch_assoc($query))
    {
      $b8_info[$result['token']] = $result['count'];
    }//while
    echo '
    <table class="configtable" cellpadding="4" cellspacing="0">
      <tr>
        <td style="text-align:center;" class="line" colspan="3">
           <strong>Statistik zur Wortliste</strong>
        </td>
      </tr>
      <tr>
        <td class="config" width="33%">
          Gelernte spamfreie Kommentare
        </td>
        <td class="config" width="33%">
          Gelernte Spamkommentare
        </td>
        <td class="config">
           BayesDB-Version
        </td>
      </tr>
      <tr>
        <td class="configthin" style="text-align:center;">'.$b8_info['bayes*texts.ham'].'</td>
        <td class="configthin" style="text-align:center;">'.$b8_info['bayes*texts.spam'].'</td>
        <td class="configthin" style="text-align:center;">'.$b8_info['bayes*dbversion'].'</td>
      </tr>
    </table>';
    //get most used ham words
    $query = mysql_query('SELECT token, count, LPAD(SUBSTRING(count, 1, LOCATE(\' \', count)-1), 10,\'0\') AS ham '
                        .'FROM b8_wordlist WHERE token NOT LIKE \'bayes*%\' '
                        .'ORDER BY ham DESC LIMIT 30', $db);
    $ham_words = array();
    while ($result = mysql_fetch_assoc($query))
    {
      $ham_words[] = array('token' => $result['token'], 'ham' => (int) $result['ham']);
    }//while
    //get most used spam words
    $query = mysql_query('SELECT token, count, LOCATE(\' \', count) AS first_space, LOCATE(\' \', count, LOCATE(\' \', count)+1) AS second_space '
                        .'FROM b8_wordlist WHERE token NOT LIKE \'bayes*%\' '
                        .'ORDER BY LPAD(SUBSTRING(count, first_space+1, second_space-first_space-1),10,\'0\') DESC LIMIT 30', $db);
    $spam_words = array();
    while ($result = mysql_fetch_assoc($query))
    {
      $sub = (int) substr($result['count'], $result['first_space'], $result['first_space']-$result['second_space']-1);
      $spam_words[] = array('token' => $result['token'], 'spam' => $sub);
    }//while
    $ham_count = count($ham_words);
    $spam_count = count($spam_words);
    $max_count = max($ham_count, $spam_count);
    //print table
    echo '<br><br>
    <table border="0" cellpadding="2" cellspacing="0" class="configtable">
      <tr>
        <td style="text-align:center;" class="config" colspan="2" width="50%">
           H&auml;ufigste Spamtokens
        </td>
        <td style="text-align:center;" class="config" colspan="2" width="50%">
           H&auml;ufigste spamfreie Tokens
        </td>
      </tr>
      <tr>
        <td class="config">
           Token
        </td>
        <td style="text-align:center;" class="config">
           Anzahl
        </td>
        <td class="config">
           Token
        </td>
        <td style="text-align:center;" class="config">
           Anzahl
        </td>
      </tr>';
    if ($max_count==0)
    {
      echo '<tr>
        <td style="text-align:center;" class="configthin" colspan="4">
           <strong>Es sind noch keine Tokens in der Wortliste vorhanden.</strong>
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
    }//else (Tokens vorhanden)

    echo '</table>
    <br>
    <center><a href="'.$PHP_SELF.'?go=news_comments_list">Zur&uuml;ck zur Kommentarliste</a></center><br>';
  }//if stats requested
  else
  {
    //no stats, normal list


  //no b8 at first
  $b8 = NULL;
  //Ist für b8 etwas zu tun?
  if (isset($_POST['commentid']) && isset($_POST['b8_action']))
  {
    //got work to do
    settype($_POST['commentid'], 'integer');
    $_POST['commentid'] = (int) $_POST['commentid'];
    //check comment's current status
    $query = mysql_query('SELECT comment_id, comment_title, comment_poster, '
                        .'comment_poster_id, comment_text, comment_classification '
                        .'FROM `'.$global_config_arr['pref'].'news_comments` WHERE comment_id=\''.$_POST['commentid'].'\'', $db);
    if ($result = mysql_fetch_assoc($query))
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
          $userindex = mysql_query('SELECT user_name FROM `'.$global_config_arr['pref'].'user` WHERE user_id = \''.$result['comment_poster_id'].'\'', $db);
          $comment_arr['comment_poster'] = mysql_result($userindex, 0, 'user_name');
        }
        //include b8 stuff
        require_once $_SERVER['DOCUMENT_ROOT'].'/b8/b8.php';
        //create b8 object
        $b8 = new b8(array('storage' => 'mysql'), array('connection' => $db));
        //check if construction was successful
        $success = $b8->validate();
        if ($success!==true)
        {
		  echo '<center><b>Fehler:</b> Konnte b8 nicht starten!</center>';
		  $b8 = NULL; //free it
	    }
	    else
	    {
	      switch ($_POST['b8_action'])
	      {
	        case 'mark_as_ham':
                 $query = mysql_query('UPDATE `'.$global_config_arr['pref'].'news_comments` SET comment_classification=\'1\' WHERE comment_id=\''.$_POST['commentid'].'\'', $db);
                 if (!$query)
                 {
                   //MySQL error?
                   echo mysql_error();
                 }
	             $b8->learn(strtolower($result['comment_title'].' '.$result['comment_poster'].' '.$result['comment_text']), b8::HAM);
	             break;
	        case 'mark_as_spam':
	             $query = mysql_query('UPDATE `'.$global_config_arr['pref'].'news_comments` SET comment_classification=\'-1\' WHERE comment_id=\''.$_POST['commentid'].'\'', $db);
	             if (!$query)
                 {
                   //MySQL error?
                   echo mysql_error();
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

  //GET-Parameter start prüfen
  if (isset($_POST['start']) && !isset($_GET['start']))
  {
    //Wert von start kann auch via POST (Formular) kommen
    $_GET['start'] = $_POST['start'];
  }
  if (!isset($_GET['start']) || $_GET['start']<0)
  {
    $_GET['start'] = 0;
  }
  $_GET['start'] = (int) $_GET['start'];
  settype($_GET['start'], "integer");
  //Anzahl der Kommentare auslesen
  $query = mysql_query('SELECT COUNT(comment_id) AS cc FROM `'.$global_config_arr['pref'].'news_comments`', $db);
  $cc = mysql_fetch_assoc($query);
  $cc = (int) $cc['cc'];
  if ($_GET['start']>=$cc)
  {
    $_GET['start'] = $cc - ($cc % 30);
  }

  //Kommentare auslesen
  $query = mysql_query('SELECT comment_id, comment_title, comment_date, comment_poster, comment_poster_id, comment_text, comment_classification, '
                      .'`'.$global_config_arr['pref'].'news_comments`.news_id AS news_id, `'.$global_config_arr['pref'].'news`.news_id, news_title '
                      .'FROM `'.$global_config_arr['pref'].'news_comments`, `'.$global_config_arr['pref'].'news` '
                      .'WHERE `'.$global_config_arr['pref'].'news_comments`.news_id=`'.$global_config_arr['pref'].'news`.news_id '
                      .'ORDER BY comment_date DESC LIMIT '.$_GET['start'].', 30', $db);
  if (!$query)
  {
    //MySQL error
    echo mysql_error();
  }
  $rows = mysql_num_rows($query);

  //Bereich (zahlenmäßig)
  $bereich = '<font class="small">'.($_GET['start']+1).' ... '.($_GET[start] + $rows).'</font>';
  //Ist dies nicht die erste Seite?
  if ($_GET['start']>0)
  {
    $prev_start = $_GET['start']-30;
    if ($prev_start<0)
    {
      $prev_start = 0;
    }
    $prev_page = '<a href="'.$PHP_SELF.'?go=news_comments_list&start='.$prev_start.'"><- zurück</a>';
  }//if nicht erste Seite
  //Ist dies nicht die letzte Seite?
  if ($_GET['start']+30<$cc)
  {
    $next_page = '<a href="'.$PHP_SELF.'?go=news_comments_list&start='.($_GET['start']+30).'">weiter -></a>';
  }//if nicht die letzte Seite

?>
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
<?php
  require_once 'eval_spam.inc.php';

  while ($comment_arr = mysql_fetch_assoc($query))
  {
    if ($comment_arr['comment_poster_id'] != 0)
    {
      $userindex = mysql_query('SELECT user_name FROM `'.$global_config_arr['pref'].'user` WHERE user_id = \''.$comment_arr['comment_poster_id'].'\'', $db);
      $comment_arr['comment_poster'] = mysql_result($userindex, 0, 'user_name');
    }
    $comment_arr['comment_date'] = date('d.m.Y' , $comment_arr['comment_date'])
                                      ." um ".date('H:i' , $comment_arr['comment_date']);
    echo'<tr>
           <td class="config">
               '.$comment_arr['comment_title'].'
           </td>
           <td class="config">
               '.$comment_arr['comment_poster'];
    if ($comment_arr['comment_poster_id'] == 0)
    {
      echo '<br><small>(unregistriert)</small>';
    }
    echo '           </td>
           <td class="config">
               '.$comment_arr['comment_date'].'
           </td>
           <td class="config">
               '.spamLevelToText(spamEvaluation($comment_arr['comment_title'],
                 $comment_arr['comment_poster_id'], $comment_arr['comment_poster'],
                 $comment_arr['comment_text'], true, $db)).'
           </td>
           <td class="config" rowspan="2">
             <form action="'.$PHP_SELF.'" method="post">
               <input type="hidden" name="sended" value="comment">
               <input type="hidden" name="news_action" value="comments">
               <input type="hidden" name="news_id" value="'.$comment_arr['news_id'].'">
               <input type="hidden" name="go" value="news_edit">
               <input type="hidden" name="comment_id[]" value="'.$comment_arr['comment_id'].'">
               <input type="hidden" name="comment_action" value="edit">
               <input class="button" type="submit" value="Editieren">
             </form>
             <form action="'.$PHP_SELF.'" method="post">
               <input type="hidden" name="sended" value="comment">
               <input type="hidden" name="news_action" value="comments">
               <input type="hidden" name="news_id" value="'.$comment_arr['news_id'].'">
               <input type="hidden" name="go" value="news_edit">
               <input type="hidden" name="comment_id[]" value="'.$comment_arr['comment_id'].'">
               <input type="hidden" name="comment_action" value="delete">
               <input class="button" type="submit" value="L&ouml;schen">
             </form><br>';

echo '           </td>
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
echo '             <form action="'.$PHP_SELF.'" method="post" style="display:inline";>
               <input type="hidden" value="news_comments_list" name="go">
               <input type="hidden" value="'.$_GET['start'].'" name="start">
               <input type="hidden" name="commentid" value="'.$comment_arr['comment_id'].'">
               <input type="hidden" name="b8_action" value="mark_as_ham">
               <input class="button" type="submit" value="Kein Spam :)">
             </form><form action="'.$PHP_SELF.'" method="post" style="display:inline";>
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
?>
    <tr>
      <td colspan="5">
          &nbsp;
      </td>
    </tr>
  </table>

                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr valign="middle">
                                <td width="33%" class="configthin middle">
<?php
  if (isset($prev_page))
  {
    echo $prev_page;
  }
?>
                                </td>
                                <td width="33%" align="center" class="middle">
<?php
  if (isset($bereich))
  {
    echo $bereich;
  }
?>
                                </td>
                                <td width="33%" style="text-align:right;" class="configthin middle">
<?php
  if (isset($next_page))
  {
    echo $next_page;
  }
?>
                                </td>
                            </tr>
                            <tr>
                            <td colspan="3" style="text-align:center;" class="configthin">
                              <a href="<?php echo $PHP_SELF; ?>?go=news_comments_list&b8_stats=1">Statistik anzeigen</a>
                            </td>
                          </tr>
                        </table>
<?php
  } //else
?>