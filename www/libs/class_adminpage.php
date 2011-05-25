<?php
//TODO: Beinhaltet fileaccess

/**
 * @file     class_adminpage.php
 * @folder   /libs
 * @version  0.5
 * @author   Satans Krümelmonster, Sweil
 *
 * provides functions to manage admin-cp display-issues
 */

class adminpage {
    
    private $name;
    private $tpl    = array();
    private $cond   = array();
    private $text   = array();
    private $lang   = array();
    private $common = array();

    function __construct ($pagefile) {
        global $global_config_arr, $TEXT;
        $this->name = substr($pagefile, 0, -4);
        
        // load tpl file
        $path = FS2_ROOT_PATH."admin/templates/".$this->name.".tpl";
                    
        if (is_readable($path)) {
            $this->loadTpl(file_get_contents($path));
        }
        // Set Lang-Classes for Template
        $this->setLang(); // page-file
        $this->setCommon(); // common admin-text
    }

    public function addCond ($name, $value) {
        $this->cond[$name] = $value;
    }

    public function clearConds () {
        unset($this->cond);
        $this->cond = array();
    }

    public function addText ($name, $value) {
        $this->text[$name] = $value;
    }

    public function clearTexts () {
        unset($this->text);
        $this->text = array();
    }

    public function get ($tplname, $clearempty = true) {
        
        if (array_key_exists($tplname, $this->tpl)) {
            
            // Get Template with Lambda-Style-IFs
            $lambdas = array();
            $tmpval = $this->lambdavars($this->tpl[$tplname], $lambdas);
            
            // closure for replace callback
            require_once(FS2_ROOT_PATH."libs/class_fullaccesswrapper.php");
            $self = giveAccess($this);  
            $getcond = function ($match) use ($lambdas, $self, &$getcond) {
                if ($self->cond[$lambdas[$match[1]]]) { // IF-branch
                    return $self->replacer($match[2], $getcond); // call replacer recursiv
                } elseif (isset($match[3])) { // ELSE-branch
                    return $self->replacer($match[3], $getcond);
                }
                return "";
            };
            
            //replace ifs
            $tmpval = $this->replacer($tmpval, $getcond);


            // replace texts
            foreach($this->text as $key => $value)
                $tmpval = str_replace("<!--TEXT::$key-->", $value, $tmpval);
                
            // replace language
            $tmpval = preg_replace("/<!--LANG::(.*?)-->/e", '$this->langValue(\'$1\')', $tmpval);
        
            // replace common
            $tmpval = preg_replace("/<!--COMMON::(.*?)-->/e", '$this->commonValue(\'$1\')', $tmpval);

            // clear rest
            if ($clearempty == true)
                $tmpval = preg_replace("#<!--TEXT::[^-]+-->#is", "", $tmpval);
                
        } else {
            throw new ErrorException("Template does not exist!");
        }

        $this->clearConds();
        $this->clearTexts();

        return $tmpval;
    }
    
    
    public function replacer($string, $callback) {
        return preg_replace_callback('/<!\-\-IF::([0-9]+?)\-\->(.*?)(?:<!\-\-ELSE::\1\-\->(.*?))?<!\-\-ENDIF::\1\-\->/s', $callback, $string);
    }
    
    private function lambdavars($tpl, &$name) {
        $num = 0;
        $push = array();
        
        $tokenizer = function ($match) use (&$num, &$name, &$push) {

            if ($match[1] == "IF") {
                $name[$num] = $match[2];
                array_push($push, $num);
                return "<!--IF::".$num++."-->";
                
            } elseif ($match[1] == "ELSE") {               
                return "<!--ELSE::".end($push)."-->";
                
            } elseif ($match[1] == "ENDIF") {
                return "<!--ENDIF::".array_pop($push)."-->";
            }
            
            return $match[0];
        };
        
        $tpl = preg_replace_callback('/(?|<!\-\-(IF)::(.+?)\-\->|<!\-\-(ELSE)\-\->|<!\-\-(ENDIF)\-\->)/', $tokenizer, $tpl);
        
        return $tpl;
    }    

    private function condValue ($name) {
        return $this->cond[$name];
    }

    private function langValue ($name) {
        return $this->lang->get($name);
    }
  
    private function commonValue ($name) {
        return $this->common->get($name);
    }

    private function loadTpl ($tplcontents) {
        preg_match_all('/<!--section-start::([a-z-_]+)-->(.*?)<!--section-end::(\1)-->/is', $tplcontents, $dev);
        for ($i=0; $i < count($dev[1]); $i++) {
            $this->tpl[$dev[1][$i]] = $dev[2][$i];
        }
        unset($dev);
    }


    private function getLang() {
        return $this->lang;
    }
    
    private function setLang() {
        global $global_config_arr, $TEXT;
        require_once(FS2_ROOT_PATH."libs/class_lang.php");

        $this->lang = new lang($global_config_arr['language_text'], "admin/".$this->name);
        $TEXT['page'] = $this->lang;
    }    

    private function getCommon() {
        return $this->common;
    }
    
    private function setCommon() {
        global $global_config_arr, $TEXT;
        if (!isset($TEXT['admin'])) {
            require_once(FS2_ROOT_PATH."libs/class_lang.php");
            $TEXT['admin'] = new lang($global_config_arr['language_text'], "admin");
        }        

        $this->common = $TEXT['admin'];
    }
}
?>
