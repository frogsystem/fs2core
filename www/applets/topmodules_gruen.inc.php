<?php
/*
    Frogsystem top modules applet
    Copyright (C) 2005  Stefan Bollmann
    Copyright (C) 2012  Thoronador (adjustments for alix5)

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

  $index = mysql_query('SELECT t1.dl_id AS id, t1.dl_name AS name, SUM(t2.file_count) AS sum_loads
        FROM '.$global_config_arr['pref'].'dl_files t2
        LEFT JOIN '.$global_config_arr['pref'].'dl t1 ON t2.dl_id=t1.dl_id
        GROUP  BY t2.dl_id
        ORDER  BY sum_loads DESC
        LIMIT 10', $db);

  $entries = '';
  while ($row=mysql_fetch_assoc($index))
  {
    $template = new template();
    $template->setFile('0_top_modules.tpl');
    $template->load('module_entry');
    $template->tag('dl_id', $row['id'] );
    $template->tag('name', $row['name'] );

    $entries .= $template->display();
  }

  if ($entries==='')
  {
    $template = new template();
    $template->setFile('0_top_modules.tpl');
    $template->load('no_entries');

    $entries = $template->display();
  }

  $template = new template();
  $template->setFile('0_top_modules.tpl');
  $template->load('modules');
  $template->tag('entries', $entries );

  $template = $template->display();
?>
