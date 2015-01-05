<?php if (!defined('ACP_GO')) die('Unauthorized access!');

  function better_size($len)
  {
    if ($len<1500) return $len.' <!--LANG::bytes-->';
    return getsize($len/1024);
  }

  $op_results = ''; //fill with results from operations
  if (isset($_POST['op']) && isset($_POST['selected_tables']))
  {
    if (!is_array($_POST['selected_tables']))
    {
      $_POST['selected_tables'] = array($_POST['selected_tables']);
    }

    //get valid tables
    $allowed = array();
    $query = $FD->db()->conn()->query('SELECT TABLE_NAME FROM information_schema.tables '
       .'WHERE TABLE_NAME LIKE \''.$FD->env('DB_PREFIX').'%\' AND TABLE_SCHEMA=\''.$FD->db()->getDatabaseName().'\'');
    while ($row = $query->fetch(PDO::FETCH_ASSOC))
    {
      $allowed[] = $row['TABLE_NAME'];
    }//while
    //...and remove non-existing/other tables
    foreach($_POST['selected_tables'] as $key => $value)
    {
      if (!in_array($value, $allowed, true))
      {
        unset($_POST['selected_tables'][$key]);
      }
    }//foreach

    if (!empty($_POST['selected_tables']))
    {
      switch ($_POST['op'])
      {
        case 'check':
             $query = 'CHECK TABLE `';
             break;
        case 'repair':
             $query = 'REPAIR TABLE `';
             break;
        case 'analyze':
             $query = 'ANALYZE TABLE `';
             break;
        default:
             $query = 'OPTIMIZE TABLE `';
             break;
      }//swi

      $query .= implode('`, `', $_POST['selected_tables']).'`';
      $query = $FD->db()->conn()->query($query);
      while ($row = $query->fetch(PDO::FETCH_ASSOC))
      {
        $adminpage->addText('table_name', $row['Table']);
        $adminpage->addText('op', $row['Op']);
        $adminpage->addText('type', $row['Msg_type']);
        $adminpage->addText('msg', $row['Msg_text']);
        $op_results .= $adminpage->get('op_entry');
      }//while

      $adminpage->clearTexts();
      $adminpage->addText('op_entries', $op_results);
      $op_results = $adminpage->get('op_table');
    }//if not empty
  }//if

  //main form/output
  $table_list = '';
  $hasInnoDB = false;
  $total = array('tabs' => 0, 'rows' => 0, 'size' => 0, 'free' => 0);
  $query = $FD->db()->conn()->query('SELECT * FROM information_schema.tables'
    .' WHERE table_name LIKE \''.$FD->env('DB_PREFIX').'%\''
    .' AND TABLE_SCHEMA=\''.$FD->db()->getDatabaseName().'\' ORDER BY table_name ASC');
  while ($row = $query->fetch(PDO::FETCH_ASSOC))
  {
    $adminpage->addText('table_name', $row['TABLE_NAME']);
    $adminpage->addText('table_name_esc', htmlentities($row['TABLE_NAME']));
    $adminpage->addText('table_rows', $row['TABLE_ROWS']);
    $adminpage->addText('table_data', better_size($row['DATA_LENGTH']));
    $adminpage->addText('table_index', better_size($row['INDEX_LENGTH']));
    $adminpage->addText('table_length', better_size($row['DATA_LENGTH']+$row['INDEX_LENGTH']));
    if ($row['ENGINE']==='InnoDB')
    {
      /*MySQL versions before 5.1.28 do not show proper value in DATA_FREE
        for InnoDB tables, so we set it to zero. */
      $row['DATA_FREE'] = 0;
      $adminpage->addText('table_free', '??? (InnoDB*)');
      $hasInnoDB = true;
    }
    else
    {
      $adminpage->addText('table_free', better_size($row['DATA_FREE']));
    }
    $adminpage->addCond('has_free', $row['DATA_FREE']>0);
    $table_list .= $adminpage->get('table_entry');
    ++$total['tabs'];
    $total['rows'] += $row['TABLE_ROWS'];
    $total['size'] += ($row['DATA_LENGTH']+$row['INDEX_LENGTH']);
    $total['free'] += $row['DATA_FREE'];
  }//while

  $adminpage->addText('tabs', $total['tabs']);
  $adminpage->addText('rows', $total['rows']);
  $adminpage->addText('size', $total['size']);
  $adminpage->addText('free', $total['free']);
  $table_list .= $adminpage->get('summary');

  $adminpage->clearTexts();
  $adminpage->addText('table_list', $table_list);
  $adminpage->addText('op_results', $op_results);
  if ($hasInnoDB)
  {
    $adminpage->addText('InnoDB', '<!--LANG::innodb_hint-->');
  }
  else
  {
    $adminpage->addText('InnoDB', '');
  }
  echo $adminpage->get('main');
?>
