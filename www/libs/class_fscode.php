<?php
/**
* @file     class_fscode.php
* @folder   /libs
* @version  0.1
* @author   Sweil
*
* this class is responsible for to fs-code transformation
*/

class fscode{
  private $html   = false;    // enable html-code?
  private $para   = false;    // enable paragraph-handling?
  private $codes  = array();  // the defined fs-codes
  private $flags  = array();  // flags
  private $callbacktypes = array("simple_replace",
                                "simple_replace_single",
                                "callback_replace",
                                "callback_replace_single",
                                "usecontent",
                                "usecontent?",
                                "callback_replace?");
  private $parser = null;
  private $fullyinitialized = false;
	public function __construct(){
    global $sql;
    //load codes and flags
    $this->codes = $sql->getData("fscodes", "*", "WHERE `active`=1");
    $this->flags = $sql->getData("fscode_flags", "*");
    // initialize parser
    include_once ( FS2_ROOT_PATH . 'includes/bbcodefunctions.php');
    $this->parser = new StringParser_BBCode ();
    // defaultsettings
    $this->parser->addFilter (STRINGPARSER_FILTER_PRE, 'convertlinebreaks');
    $this->parser->addParser ('list', 'bbcode_stripcontents');
    $this->parser->setGlobalCaseSensitive (false);
	}
  
  public function disableCode($codename){
  // delete code
    if(in_array($codename, $this->codes)){
      $codeid = 0;
      foreach($this->codes as $code){
        if($code[name] == $codename)
          break;
        else
          $codeid++;
      }
      unset($this->codes[$codeid]);
    }
  }
  
  public function setHTML($value){
    if(is_bool($value)){
      $this->html = $value;
    }
  }
  
  public function setPara($value){
    if(is_bool($value)){
      $this->para = $value;
    }
  }
  
  public function parse($text){
    if($this->fullyinitialized == false){
      foreach($this->codes as $code){
        if($code[isactive] && (!$this->isRef($code[name]) || ($this->isRef($code[name]) && $this->refDefined($code[name])))){ // fs-code ist definiert
          // callback funktion erzeugen
          if($code[callbacktype] == 0 || $code[callbacktype] == 1)
            $callbackfunc = null;
          elseif($code[php] != "") // php benutzbar
            $callbackfunc = create_function('$action, $attributes, $content, $params, $node_object', $code[php]);
          else
            $callbackfunc = create_function('$action, $attributes, $content, $params, $node_object', 'if($action==\'validate\'){return true;}if(!isset($attributes[default])){return str_replace(array("{..x..}","{..y..}"),array($content,$attributes[\'default\']),"'.addslashes($code[param_2]).'");}return str_replace("{..x..}",$content,"'.addslashes($code[param_1]).'");');
          
          // usercontent? und callback_replace?-attribute
          if($code[callbacktype] == 5)
            $params = array ('usecontent_param' => 'default');
          elseif($code[callbacktype] == 6)
            $params = array ('callback_replace_param' => 'default');
          elseif($code[callbacktype]==0)
            $params = array ('start_tag' => $code[param_1], 'end_tag' => $code[param_2]);
          else
            $params = array();
          
          $this->parser->addCode($code[name], $this->callbacktypes[$code[callbacktype]], $callbackfunc, $params, $code[contenttype], array_map("trim", explode($code[allowin], ",")), array_map("trim", explode($code[disallowin], ",")));
        }
      }
      $this->fullyinitialized = true;
    }
    return $this->parser->parse($text);
  }
}
?>