<?php
//TODO: Beinhaltet fileaccess

/**
 * @file     class_adminpage.php
 * @folder   /libs
 * @version  0.6
 * @author   Satans Krümelmonster, Sweil
 *
 * provides functions to manage admin-cp display-issues
 */

class adminpage {

    private $name;
    private $tpl    = array();
    private $cond   = array();
    private $text   = array();
    private $lang   = null;
    private $common = null;


    function __construct ($pagefile) {
        global $FD;
        $this->name = substr($pagefile, 0, -4);

        // load tpl file
        $path = FS2_ROOT_PATH.'admin/templates/'.$this->name.'.tpl';

        if (is_readable($path)) {
            $this->loadTpl(file_get_contents($path));
        }
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

    public function getRaw ($tplname) {
        if (array_key_exists($tplname, $this->tpl)) {
            return $this->tpl[$tplname];
        } else {
            return "ERROR: Template '$tplname' does not exist!";
        }
    }

    public function get ($tplname, $clearempty = true, $conds = true, $lang = true) {

        if (array_key_exists($tplname, $this->tpl)) {

            $tmpval = $this->tpl[$tplname];

            // Get Importet Templates
            //<!--section-import::tpl_file::section_name-->
            preg_match_all('/<!--section-import(\-nolang)?::([a-z-_]+)::([a-z-_]+)-->/is', $tmpval, $imports, PREG_SET_ORDER);
            foreach ($imports as $import) {
                $importlang = (empty($import[1]) ? true: false);
                $page = new adminpage($import[2].'.tpl');
                $tmpval = preg_replace('/<!--section-import'.$import[1].'::'.$import[2].'::'.$import[3].'-->/is', $page->get($import[3], false, false, $importlang), $tmpval);
                // replace all imports, recursive but don't touch conds or TEXTs
            }
            unset($imports);


            // Get Template with Lambda-Style-IFs
            if ($conds) {
                $lambdas = array();
                $tmpval = $this->lambdavars($tmpval, $lambdas);

                // closure for replace callback
                
                $GLOBALS["AP_cond"] = $this->cond;
                $GLOBALS["AP_lambdas"] = $lambdas;

                $GLOBALS["getcond"] = create_function ('$match', ' 
                    if ($GLOBALS["AP_cond"][$GLOBALS["AP_lambdas"][$match[1]]]) { // IF-branch
                        return adminpage::replacer($match[2], $GLOBALS["getcond"]); // call replacer recursiv
                    } elseif (isset($match[3])) { // ELSE-branch
                        return adminpage::replacer($match[3], $GLOBALS["getcond"]);
                    }
                    return ""; // remove all undefined conds
                ');

                //replace ifs
                $tmpval = adminpage::replacer($tmpval, $GLOBALS["getcond"]);
                unset($GLOBALS["AP_cond"], $GLOBALS["AP_lambdas"]);
            }


            // replace texts
            foreach($this->text as $key => $value)
                $tmpval = str_replace("<!--TEXT::$key-->", $value, $tmpval);

            // replace data from langfiles
            if ($lang) {
                // replace language
                $tmpval = preg_replace("/<!--LANG::(.*?)-->/e", '$this->langValue(\'$1\')', $tmpval);

                // replace common
                $tmpval = preg_replace("/<!--COMMON::(.*?)-->/e", '$this->commonValue(\'$1\')', $tmpval);
            }

            // clear rest
            if ($clearempty == true)
                $tmpval = preg_replace("#<!--TEXT::[^-]+-->#is", "", $tmpval);

        } else {
            throw new ErrorException("Template '$tplname' does not exist!");
        }

        $this->clearConds();
        $this->clearTexts();

        return $tmpval;
    }


    public static function replacer($string, $callback) {
        return preg_replace_callback('/<!\-\-IF::([0-9]+?)\-\->(.*?)(?:<!\-\-ELSE::\1\-\->(.*?))?<!\-\-ENDIF::\1\-\->/s', $callback, $string);
    }

    private function lambdavars($tpl, &$name) {
        $num = 0;
        $push = array();
        
        $tokenizer = create_function("\$match,&\$num,&\$name,&\$push", "
            if (\$match[1] == \"IF\") {
                \$name[\$num] = \$match[2];
                array_push(\$push, \$num);
                return \"<!--IF::\".\$num++.\"-->\";

            } elseif (\$match[1] == \"ELSE\") {
                return \"<!--ELSE::\".end(\$push).\"-->\";

            } elseif (\$match[1] == \"ENDIF\") {
                return \"<!--ENDIF::\".array_pop(\$push).\"-->\";
            }
            return \$match[0];       
        ");

        $tpl = preg_replace('/(?|<!\-\-(IF)::(.+?)\-\->|<!\-\-(ELSE)\-\->|<!\-\-(ENDIF)\-\->)/e', '$tokenizer(array(\'$0\',\'$1\',\'$2\'),$num,$name,$push)', $tpl);

        return $tpl;
    }

    private function condValue ($name) {
        return $this->cond[$name];
    }

    private function langValue ($name) {
        // get from local lang
        if (!is_null($this->lang)) {
            return $this->lang->get($name);

        // get from default lang
        } else {
            global $FD;
            return $FD->text('page', $name);
        }
    }

    private function commonValue ($name) {
        // get from local lang
        if (!is_null($this->common)) {
            return $this->common->get($name);

        // get from default lang
        } else {
            global $FD;
            return $FD->text('admin', $name);
        }
    }

    private function loadTpl ($tplcontents) {
        preg_match_all('/<!--section-start::([a-z-_]+)-->(.*?)<!--section-end::(\1)-->/is', $tplcontents, $dev);
        for ($i=0; $i < count($dev[1]); $i++) {
            $this->tpl[$dev[1][$i]] = $dev[2][$i];
        }
        unset($dev);
    }

    public function setLang ($lang = null) {
        $this->lang = $lang;
    }

    public function setCommon ($common = null) {
        $this->common = $common;
    }
    public function getLang () {
        return $this->lang;
    }
}
?>
