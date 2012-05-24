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


  /* configuration "constants" */
  /* lower_level_for_registered_users - if this is true, comments of registered
     users will have a spam level one lower than unregistered users. If this is
     false, those comments don't get the bonus. */
  define('lower_level_for_registered_users', true);

  //functions
  /* returns true, if the first three characters of the given string do not
     contain any vowels. Returns false otherwise.

     parameters:
         $input - a string of at least three (3) characters
  */
  function noVowel($input)
  {
    $sub = strtolower(substr($input, 0, 3));
    $no_vowel = true;
    for($i=0; $i<3 && $no_vowel; $i=$i+1)
    {
      if ($sub[$i]=='a' || $sub[$i]=='e' || $sub[$i]=='i' || $sub[$i]=='o' || $sub[$i]=='u')
      {
        $no_vowel = false;
      }
    }//for
    return $no_vowel;
  }//function

  /* returns true, if the first three characters of the given string do have
     a "strange" change of upper and lower case. Returns false otherwise.

     parameters:
         $input - a string of at least three (3) characters
  */
  function strangeCase($input)
  {
    $sub = substr($input, 0, 3);
    $case_profile = 0;
    for($i=0; $i<3; $i=$i+1)
    {
      if (strtoupper($sub[$i])==$sub[$i])
      {
        $case_profile = $case_profile + (1 << (2-$i));
      }
    }//for
    return ($case_profile!=0 && $case_profile<4);
  }//function

  /* evaluates a comment and returns its "spam level", i.e. an integer value
     that indicates the likeliness of a comment being spam. Main criterion is
     the number of links included in the comment's text.
     A return value of zero means that the comment does not seem to be spam, a
     value of three or higher indicates that the comment is most likely to be
     a spam comment. Values in between indicate that the comment might be spam.

     parameters:
         title        - the title of the comment
         poster_id    - the ID of the user who posted the comment; must be zero
                        for an unregistered user
         poster_name  - the name of the user who posted the comment
         comment_text - the comment's complete text
  */
  function spamEvaluation($title, $poster_id, $poster_name, $comment_text)
  {
    //test for url tags in comment text
    // ---- raise level for every opening url tag
    $comment_text = strtolower($comment_text);
    $spam_level = substr_count($comment_text, '[url=') //URL tag with name
                 + substr_count($comment_text, '[url]') //URL tag w/o name
                 + substr_count($comment_text, '[link') //invalid URL tag, but some bots seem to use that one
                 + substr_count($comment_text, '<a href='); //HTML links
    // ---- if no spam was found so far, check for plain URLs
    if ($spam_level==0)
    {
      $spam_level = substr_count($comment_text, 'http://');
    }
    //test for poster being not a registered user
    if ($poster_id!=0 && strlen($poster_name)>=3)
    {
      //check for name
      if (noVowel($poster_name) || strangeCase($poster_name))
      {
        $spam_level = $spam_level +1;
      }
    }//if
    //test for strange title
    if (($poster_id!=0) && (strlen($title)>=3))
    {
      if (noVowel($title) || strangeCase($title))
      {
        $spam_level = $spam_level +1;
      }
    }//if title
    //lower spam level for registered users?
    if (lower_level_for_registered_users && ($poster_id!=0) && ($spam_level>0))
    {
      $spam_level = $spam_level -1;
    }//if
    return $spam_level;
  }//function

  /* turns the given spam level into a human-readable text with approoriate
     colour and returns that as HTML code snippet

     parameters:
         level - the spam level, an integer value (ideally the one returned by
                 the spamEvaluation() function)
  */
  function spamLevelToText($level)
  {
    if ($level<=0) return '<font color="#00cc00">unwahrscheinlich</font>';
    if ($level==1) return '<font color="#cccc00">gering</font>';
    if ($level==2) return '<font color="#ff8000">mittel</font>';
    //3 or higher
    return '<font color="#ff0000"><b>hoch</b></font>';
  }//function
?>
