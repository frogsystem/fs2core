<?php

/**
 * @file     class_sql.php
 * @folder   /libs
 * @version  0.1
 * @author   Satans Krümelmonster
 *
 * this class shows the FS2-API-documentation
 */

class doc{

  private $tpl = null;
  private $sql = null;

  const paramanchor = "param_";

  function __construct($tpl, $sql){
    if(is_a($tpl, "template"))
      $this->tpl = $tpl;

    if(is_a($sql, "sql"))
      $this->sql = $sql;
  }

  public function showFunction($function, $class){
    $this->tpl->setFile("docs_funcdetail.tpl");

    if(is_numeric($function))
      $func = $this->sql->getData("docs_functions", "*", "WHERE `id`=".intval($function),1);
    else{
      if(!is_numeric($class))
        $class = $this->sql->getData("docs_classes", "`id`", "WHERE `name`='".mysql_real_escape_string($class)."'",1);
      $func = $this->sql->getData("docs_functions", "*", "WHERE `name`='".mysql_real_escape_string($function)."' AND `class`=".intval($class),1);
    }
    if((isset($func[0]) && is_array($func[0])) || $func == 0){ // funcktion ist nicht eindeutig oder existiert nicht.
      $this->tpl->load("DOC_FUNCDETAIL_NOFUNC");
      return $this->tpl->display();
    }

    $this->tpl->load("DOC_FUNCDETAIL_VARS");
    $func[params] = $this->sql->getData("docs_params", "*", "WHERE `function`=".$func[id]." ORDER BY `internal_id` ASC");

    $func[params] = $func[params] == 0 ? array() : $func[params];

    $syntax = "";
    $extend = " ";
    $params = "";

    foreach($func[params] as $param){
      // syntax-aufbau
      if($param[initval] != ""){
        $extend .= "]";
        $syntax .= " [";
      }

      $syntax .= ", ".$param[type]." ".($param[isref] == 1 ? "&amp;" : "").
                 "<a href=\"#param_$param[internal_id]\" style=\"font-style: italic;\">&#36;".
                 $param[name]."</a>";

      if($param[initval] != ""){
        $syntax .= " = ".$param[initval];
      }

      //funktionsbeschreibung
      $func[desc] = str_replace(" ".$param[name],
        " <a href=\"#param_$param[internal_id]\" style=\"font-style: italic;\">".$param[name]."</a>",
        $func[desc]);

      // parameter-detailansicht
      $this->tpl->tag("id", $param[internal_id]);
      $this->tpl->tag("name", $param[name]);
      $this->tpl->tag("desc", $param[desc]);

      $params .= $this->tpl->display();
    }

        $func[desc] = preg_replace("#\[php=(.*?)\](.*?)\[/php\]#is", "<a href=\"http://de.php.net/manual/function.\\1.php\">\\2</a>", $func[desc]);
    if(strlen($params) > 0)
      $params = preg_replace("#\[php=(.*?)\](.*?)\[/php\]#is", "<a href=\"http://de.php.net/manual/function.\\1.php\">\\2</a>", $params);
    else{
      $this->tpl->load("DOC_FUNCDETAIL_NOPARAMS");
      $params = $this->tpl->display();
    }

    if(strlen($syntax) == 0)
      $syntax = "  void";

    $syntax = substr($syntax, 1);

    $parclass = $this->sql->getData("docs_classes", "*", "WHERE `id`=".$func['class'], 1);

    // funktionen, variablen & konstanten der elternklasse
    if($func['class'] != 0){
      $this->tpl->setFile("docs_misc.tpl");

      $parclass[consts] = $this->getClassConsts($func['class']);
      $parclass[vars]   = $this->getClassVars($func['class']);
      $parclass[funcs]  = $this->getClassFunction($func['class']);

      $this->tpl->setFile("docs_funcdetail.tpl");
      $class="<a href=\"?go=".$_GET[go]."&amp;c=".$func['class']."\">".$parclass[name]."</a>::";
    } else {
      $class="";
    }

    $type = ($func[type] == "private") ? "&#9679;" : ($func[type] == "protected") ? "&#8722;" : "&#43;";

    $syntax = "<span title=\"Access: ".$func[type]."\" style=\"cursor: pointer;\">".$type."</span> ".$func[ret]." <b>".$class.$func[name]."</b> (".$syntax.$extend." );";

    $this->tpl->load("DOC_FUNCDETAIL");
    $this->tpl->tag("syntax",         $syntax);
    $this->tpl->tag("desc",           fscode($func[desc], true, true));
    $this->tpl->tag("vars",           fscode($params, true, true));
    $this->tpl->tag("parclass_id",    $parclass[id]);
    $this->tpl->tag("parclass_name",  $parclass[name]);
    $this->tpl->tag("funcname",       $func[name]);
    $this->tpl->tag("parclass_const", $parclass[consts]);
    $this->tpl->tag("parclass_vars",  $parclass[vars]);
    $this->tpl->tag("parclass_funcs", $parclass[funcs]);

    $ret = $this->tpl->display();
    if($func['class'] == 0){
      $ret = preg_replace("#<parclass>(.*?)</parclass>#si", "", $ret);
    } else {
      $ret = preg_replace("#<parclass>(.*?)</parclass>#si", "\\1", $ret);
    }
    return $ret;
  }

  private function getClassConsts($class){
    $constants = $this->sql->getData("docs_variables", "*", "WHERE `type`='const' and `class`=".$class);
    if($constants != 0){
      $ret = "";
      $this->tpl->load("DOC_PARCLASS_CONST");
      foreach($constants as $constant){
        $this->tpl->tag("id", $constant[id]);
        $this->tpl->tag("name", $constant[name]);
        $ret .= $this->tpl->display();
      }
    } else {
      $this->tpl->load("DOC_PARCLASS_NOCONST");
      $ret = $this->tpl->display();
    }
    return $ret;
  }

  private function getClassVars($class){
    $vars = $this->sql->getData("docs_variables", "*", "WHERE (`type`='public' or `type`='private' or `type`='protected') and `class`=".$class);

    if($vars != 0){
      $ret = "";
      $this->tpl->load("DOC_PARCLASS_CONST");
      foreach($vars as $var){
        $this->tpl->tag("id", $var[id]);
        $this->tpl->tag("name", $var[name]);
        $ret .= $this->tpl->display();
      }
    } else {
      $this->tpl->load("DOC_PARCLASS_NOCONST");
      $ret = $this->tpl->display();
    }
    return $ret;
  }

  private function getClassFunction($class){
    $funcs = $this->sql->getData("docs_functions", "*", "WHERE `class`=".$class);

    if($funcs != 0){
      $ret = "";
      $this->tpl->load("DOC_PARCLASS_FUNCS");
      foreach($funcs as $func){
        $this->tpl->tag("id", $func[id]);
        $this->tpl->tag("name", $func[name]);
        $ret .= $this->tpl->display();
      }
    } else {
      $this->tpl->load("DOC_PARCLASS_NOFUNCS");
      $ret = $this->tpl->display();
    }

    return $ret;
  }

  public function showIndex(){
    $this->tpl->setFile("docs_index.tpl");
    // klassen laden
    $classes = $this->sql->getData("docs_classes", "*");
    if($classes != 0){
      foreach($classes as $class){
        $functions = $this->sql->getData("docs_functions", "*", "WHERE `class`=".$class[id]." ORDER BY `name` ASC");
        if($functions != 0){
          foreach($functions as $function){
            $this->tpl->load("DOC_MAINPAGE_CLASSES_FUNCTION");
            $this->tpl->tag("name", $function[name]);
            $this->tpl->tag("id", $function[id]);
            $this->tpl->tag("access", $function[type]);
            $func .= $this->tpl->display();
          }
        } else {
          $this->tpl->load("DOC_MAINPAGE_CLASSES_NOFUNCTION");
          $func = $this->tpl->display();
        }
        $this->tpl->load("DOC_MAINPAGE_CLASSES");
        $this->tpl->tag("subfunctions", $func);
        $this->tpl->tag("name", $class[name]);
        $this->tpl->tag("desc", $class[desc]);
        $this->tpl->tag("id", $class[id]);
        $tpl['class'] .= $this->tpl->display();
        unset($functions, $func);
      }
    } else {
      $this->tpl->load("DOC_MAINPAGE_NOCLASSES");
      $tpl['class'] = $this->tpl->display();
    }

    // funktionen laden
    $functions = $this->sql->getData("docs_functions", "*", "WHERE `class`=0 ORDER BY `name` ASC");
    if($functions != 0){
      foreach($functions as $function){
        $this->tpl->load("DOC_MAINPAGE_FUNCS");
        $this->tpl->tag("name", $function[name]);
        $this->tpl->tag("id", $function[id]);
        $tpl['func'] .= $this->tpl->display();
      }
    } else {
      $this->tpl->load("DOC_MAINPAGE_NOFUNCS");
      $tpl['func'] = $this->tpl->display();
    }

    // seite initialisieren
    $this->tpl->load("DOC_MAINPAGE");
    $this->tpl->tag("classes", $tpl['class']);
    $this->tpl->tag("functions", $tpl['func']);

    return $this->tpl->display();
  }

  public function showClass($class){
    $this->tpl->setFile("docs_classdetail.tpl");
    // klasse laden
    $class = $this->sql->getData("docs_classes", "*", "WHERE `id`=".intval($class),1);
    if($class == 0){ // klasse existiert nicht
      $this->tpl->load("DOC_NOCLASS");
      return $this->tpl->display();
    }
    // variablen laden
    $vars = $this->sql->getData("docs_variables", "*", "WHERE (`type`='public' OR `type`='private' OR `type`='protected') AND `class`=".$class[id]);

    if($vars == 0){ // klasse enthält keine variablen
      $this->tpl->load("DOC_NOVARS");
      $tpl[vars] = $this->tpl->display();
    } else {
      $this->tpl->load("DOC_VARS");
      foreach($vars as $var){
        $this->tpl->clearTags();
        foreach($var as $key => $value)
          $this->tpl->tag($key, $value);

        $this->tpl->deleteTag("class");
        $this->tpl->tag("type_symbol", ($var[type] == "private") ? "&#9679;" : ($var[type] == "protected") ? "&#8722;" : "&#43;");

        $tpl[vars] .= $this->tpl->display();
      }
    }

    // konstanten laden
    $constants = $this->sql->getData("docs_variables", "*", "WHERE `type`='const' AND `class`=".$class[id]);

    if($constants == 0){ // klasse enthält keine konstanten
      $this->tpl->load("DOC_NOCONSTS");
      $tpl[consts] = $this->tpl->display();
    } else {
      $this->tpl->load("DOC_CONSTS");
      foreach($constants as $constant){
        $this->tpl->clearTags();
        foreach($constant as $key => $value)
          $this->tpl->tag($key, $value);

        $this->tpl->deleteTag("class");
        $this->tpl->deleteTag("type");

        $tpl[consts] .= $this->tpl->display();
      }
    }

    // funktionen laden
    $functions = $this->sql->getData("docs_functions", "*", "WHERE `class`=".$class[id]);

    if($functions == 0){
      $this->tpl->load("DOC_NOFUNCS");
      $tpl[func] = $this->tpl->display();
    } else {
      $this->tpl->load("DOC_FUNCS");
      foreach($functions as $function){
        $this->tpl->clearTags();
        foreach($function as $key => $value)
          $this->tpl->tag($key, $value);

        $this->tpl->deleteTag("class");
        $this->tpl->tag("type_symbol", ($function[type] == "private") ? "&#9679;" : ($function[type] == "protected") ? "&#8722;" : "&#43;");

        $tpl[func] .= $this->tpl->display();
      }
    }

    // klasse laden & anzeigen
    $this->tpl->load("DOC_CLASS");
    $this->tpl->tag("name", $class[name]);
    $this->tpl->tag("desc", fscode($class[desc], true, true, true));
    $this->tpl->tag("constants", $tpl[consts]);
    $this->tpl->tag("variables", $tpl[vars]);
    $this->tpl->tag("functions", $tpl[func]);

    return $this->tpl->display();
  }

  public function showVariable($var, $class){
    $this->tpl->setFile("docs_vardetail.tpl");
    // variable laden
    if(is_numeric($var))
      $var = $this->sql->getData("docs_variables", "*", "WHERE `id`=".intval($var), 1);
    else{
      if(!is_numeric($class))
        $class = $this->sql->getData("docs_classes", "`id`", "WHERE `name`='".mysql_real_escape_string($class)."'",1);
      $var = $this->sql->getData("docs_variables", "*", "WHERE `name`='".mysql_real_escape_string($var)."' AND `class`=".intval($class), 1);
    }
    if((isset($var[0]) && is_array($var[0])) || $var == 0){ // variable ist nicht eindeutig oder existiert nicht.
      $this->tpl->load("DOC_NOVAR");
      return $this->tpl->display();
    }

    // navigation
    $this->tpl->setFile("docs_misc.tpl");
    $var[class_const] = $this->getClassConsts($var['class']);
    $var[class_vars]  = $this->getClassVars($var['class']);
    $var[class_funcs] = $this->getClassFunction($var['class']);

    // seite
    $this->tpl->setFile("docs_vardetail.tpl");

    $var[class_id] = $var['class'];
    $var['class'] = $this->sql->getData("docs_classes", "name", "WHERE `id`=".$var['class'],1);
    if($var[type] == "const"){ // kontante
      $this->tpl->load("DOC_CONST");
      $this->tpl->deleteTag("type");
    } else { // variable
      $this->tpl->load("DOC_VAR");
    }
    foreach($var as $key => $val){
      if($key == "desc"){
        $val = fscode($val, true, true, true);
        $val = preg_replace("#\[php=(.*?)\](.*?)\[/php\]#is", "<a href=\"http://de.php.net/manual/function.\\1.php\">\\2</a>", $val);
      }
      $this->tpl->tag($key, $val);
    }

    $this->tpl->deleteTag("id");

    return $this->tpl->display();
  }
}
?>