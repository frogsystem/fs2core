<?php
/**
* @file     class_fscode.php
* @folder   /libs
* @version  0.2
* @author   Satans Krümelmonster
*
* this class is responsible for to fs-code transformation
*/

class fscode{
  private $html   = false;    // enable html-code?
  private $para   = false;    // enable paragraph-handling?
  private $smilie = true;     // anable smilies?
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
    $this->codes = $this->codes == 0 ? array() : $this->codes;
    $this->flags = $sql->getData("fscodes_flag", "*");
    $this->flags = $this->flags == 0 ? array() : $this->flags;
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

  public function disableSmilie($value){
    if(is_bool($value)){
      $this->smilie = $value;
    }
  }

  public function parse($text){
    global $sql;
    if($this->fullyinitialized == false){
      foreach($this->codes as $code){
        if($code[active] == 1){ // fs-code ist definiert
          // callback funktion erzeugen
          if($code[callbacktype] == 0 || $code[callbacktype] == 1)
            $callbackfunc = null;
          elseif($code[php] != "") // php benutzbar
            $callbackfunc = create_function('$action, $attributes, $content, $params, $node_object', $code[php]);
          else
            $callbackfunc = create_function('$action, $attributes, $content, $params, $node_object', 'if($action==\'validate\'){return true;}if(isset($attributes[\'default\'])){return str_replace(array("{..x..}","{..y..}"),array(htmlspecialchars($content),htmlspecialchars($attributes[\'default\'])),"'.addslashes($code[param_2]).'");}return str_replace("{..x..}",htmlspecialchars($content),"'.addslashes($code[param_1]).'");');

          // usercontent? und callback_replace?-attribute
          if($code[callbacktype] == 5)
            $params = array ('usecontent_param' => 'default');
          elseif($code[callbacktype] == 6)
            $params = array ('callback_replace_param' => 'default');
          elseif($code[callbacktype]==0)
            $params = array ('start_tag' => $code[param_1], 'end_tag' => $code[param_2]);
          else
            $params = array();

          // allow in...
          if(!empty($code[allowin])){
            $allowin = explode(",", $code[allowin]);
            $allowin = (is_array($allowin))?array_map("trim", $allowin):array();
          } else
            $allowin = array();

          // disallow in...
          if(!empty($code[disallowin])){
            $disallowin = explode(",", $code[disallowin]);
            $disallowin = (is_array($disallowin))?array_map("trim", $disallowin):array();
          } else
            $disallowin = array();

          // add code
          $this->parser->addCode($code[name], $this->callbacktypes[$code[callbacktype]], $callbackfunc, $params, $code[contenttype], $allowin, $disallowin);

          // unset vars
          unset($callbackfunc, $params, $allowin, $disallowin);

          /*// absatzbehandlung
          if($code[allowparagraphes] == 0)
            $this->parser->setCodeFlag($code[name], 'paragraphs', false);*/
        }
      }

      foreach($this->flags as $flag){
        $codename = $sql->getData("fscodes", "name", "WHERE `id`=".$flag[code],1);
        #print_r($sql->qrystr);
        if($this->codeDefined($codename)){
          $this->parser->setCodeFlag($codename, $flag[name], $flag[value]);
        }
      }
      $this->fullyinitialized = true;
    }
    if($this->para == true)
      $this->parser->setRootParagraphHandling (true);
    if($this->html == false)
      $this->parser->addParser(array ('block', 'inline', 'link', 'listitem'), 'killhtml');
    if($this->smilie == true){
      $smiliefunc = create_function('$text', 'global $sql;$smilies=$sql->getData("smilies","*");foreach($smilies as $smilie){$text=str_replace($smilie[replace_string],\'<img src="\'.image_url("images/smilies/",$smilie[id]).\'" alt="\'.$smilie[replace_string].\'" align="top">\', $text);}return $text;');
      $this->parser->addParser(array ('block', 'inline', 'link', 'listitem'), $smiliefunc);
      unset($smiliefunc);
    }

    $this->parser->addParser (array ('block', 'inline', 'link', 'listitem'), 'html_nl2br');

    return $this->parser->parse($text);
  }
}
?>