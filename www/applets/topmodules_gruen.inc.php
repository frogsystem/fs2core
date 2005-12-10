<?php
/*
    Frogsystem top modules applet
    Copyright (C) 2005  Stefan Bollmann

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

  $index = mysql_query('SELECT t1.dl_id, t1.dl_name, t1.dl_loads + SUM( t2.mirror_count )  AS summir
					FROM fs_dl t1
					INNER  JOIN fs_dl_mirrors t2
					USING ( dl_id )
					WHERE cat_id=2
					GROUP  BY t1.dl_id, t1.dl_name, t1.dl_loads
					ORDER  BY summir DESC
					LIMIT 10', $db);

  for ($i=0; $i<10; $i++)
  {
    $name = mysql_result($index, $i, 'dl_name');
    $file_id = mysql_result($index, $i, 'dl_id');

    echo'
	<tr>
  	  <td valign="top" width="16"><img src="images/design/dot2_gruen.gif" width="16" height="10" alt=""></td>
  	  <td class="font-10"><a href="http://www.planetneverwinter.de/nwn/?go=dlfile2&amp;fileid='.$file_id.'">'.$name.'</a></td>
	<tr>
	';
  }
?>
