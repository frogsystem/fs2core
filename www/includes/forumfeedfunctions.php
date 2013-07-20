<?php
/*
    This file is part of the Frogsystem Forum Feed applet.
    Copyright (C) 2012  Thoronador

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
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

/* tries to get the contents of a remote file via cURL.
   Returns content as string in case of success, or false if an error occured.
*/
function getRemoteFileCURL($url)
{
  if (!function_exists('curl_init')) return false;
  $ch = curl_init();
  if ($ch===false) return false;
  // set the url to fetch
  $s = curl_setopt($ch, CURLOPT_URL, $url);
  // We don't want the headers but just the content.
  $s &= curl_setopt($ch, CURLOPT_HEADER, 0);
  // return the value instead of printing the response to browser
  $s &= curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  if ($s===false)
  {
    curl_close($ch);
    return false;
  }

  $content = curl_exec($ch);
  curl_close($ch);
  return $content;
}

/* class that handles parsing of XML feed */
class ForumFeedParser
{
  public $xml_elements = array();
  public $thread_elem = array();
  public $feedThreadList = array();
  public $baseURL = '';

  public function startHandler($parser, $name, $attr)
  {
    $this->xml_elements[] = $name;
    if ($name==='thread')
    {
      $this->thread_elem = array('id' => intval($attr['id']));
    }
  }

  public function endHandler($parser, $name)
  {
    if ($name==='thread')
    {
      $this->feedThreadList[] = $this->thread_elem;
    }
    array_pop($this->xml_elements);
  }

  public function cdataHandler($parser, $data)
  {
    $current_elem = end($this->xml_elements);
    if ($current_elem===NULL) return;
    switch ($current_elem)
    {
      case 'title':
      case 'author':
      case 'date':
      case 'time':
           if (!isset($this->thread_elem[$current_elem]))
             $this->thread_elem[$current_elem] = $data;
           else $this->thread_elem[$current_elem] .= $data;
           break;
      case 'url':
           $this->baseURL .= $data;
           break;
    }//swi
    return;
  }

  public function parse($url)
  {
    $xml_content = getRemoteFileCURL($url);
    if ($xml_content===false) return false;

    $parser = xml_parser_create('ISO-8859-1');
    xml_set_object($parser, $this);
    xml_set_element_handler($parser, 'startHandler', 'endHandler');
    xml_set_character_data_handler($parser, 'cdataHandler');
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
    xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, 'ISO-8859-1');
    $status = xml_parse($parser, $xml_content, true);
    xml_parser_free($parser);
    if ($status===0) return false; //xml_parse failed, if status is zero
    return $this->feedThreadList;
  }

} //end of class

?>
