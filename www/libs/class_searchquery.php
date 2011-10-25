<?php
/**
* @file     class_searchquery.php
* @folder   /libs
* @version  0.1
* @author   Sweil
*
* this class creates an search query object from an search string
* search query objects are intened to used by the search-class
* 
*/
class SearchQuery
{
    // global vars
    private $sql;
    
    // vars for class options
    private $searchstring;
    private $tokens = array();
    private $operators = array (
        'and' => array("AND"),
        'or'  => array("OR"),
        'xor' => array("XOR")
    );
    private $modifiers = array (
        'wc' => array("*"),
        'not'  => array("!")
    );    
    private $seperator = "\s";
    private $root;

    // constructor
    public function  __construct ($operators = array(), $modifiers = array()) {
        // get searchtree classe if not loaded
        require_once(FS2_ROOT_PATH . "libs/class_searchtree.php");      
        
        // assign global vars
        global $sql;
        $this->sql = $sql;
        
        // set local vars
        if (!empty($operators)) 
          $this->setOperators($operators);
        if (!empty($modifiers)) 
          $this->setModifiers($modifiers);     
    }
    
    // destructor
    public function  __destruct(){
        unset($this->searchstring, $this->tokens, $this->operators, $this->seperator, $this->root);
    }
    
    // parser 
    public function parse($searchstring) {
        global $FD;
        
        $this->searchstring = trim($searchstring);
        $this->tokenize();
        $this->root = $this->interpret();
        
        $tree = (string) $this->root;
        if (empty($tree))
            Throw new Exception($FD->text('frontend', 'sq_invalid_searchstring'));
            //"Invalid searchstring. "."No valid input data found.");
    }
    
    // get searchquery tree 
    public function getTree() {
        return $this->root;
    }    
    
    // tokenize querystring
    private function tokenize() {
        // get some search functions
        require_once(FS2_ROOT_PATH . "includes/searchfunctions.php");

        // reset tokens
        $this->tokens = array();
        
        // split on seperator
        $tokenarr = array();
        $tokenarr = preg_split("/".$this->seperator."/", $this->searchstring);
        $lasttoken = array();

    
        // Go through string stream
        foreach($tokenarr as $string) {
            // get bool for type of current and last token
            $isop = in_arrayr($string, $this->operators);
            $wasop = isset($lasttoken['type']) && in_array($lasttoken['type'], array_keys($this->operators));
        
            //check for and/or/not
            if (in_array($string, $this->operators['and'])) {
                $lasttoken = array(
                    'type'   => "and",
                    'string' => $string
                );
            }
            if (in_array($string, $this->operators['or'])) {
                $lasttoken = array(
                    'type'   => "or",
                    'string' => $string
                ); 
            }
            if (in_array($string, $this->operators['xor'])) {
                $lasttoken = array(
                    'type'   => "xor",
                    'string' => $string
                );
            }  
            
            // token is operator
            if($isop) {
                if ($wasop) // remove if last token was op too
                    array_pop($this->tokens);  

                $this->tokens[] =  $lasttoken;
                continue;            
            }
            
            
            //String seems to be normal => check for modifiers
            
            // First maybe a not
            if (in_array(substr($string, 0, 1), $this->modifiers['not'])) {
                $not = true;  
                $string = substr($string, 1);
            } else {
                $not = false; 
            }
            
            // now check wildecards
            if (in_array(substr($string, 0, 1), $this->modifiers['wc'])
                && in_array(substr($string, -1), $this->modifiers['wc'])) {
                $type = SQBOTH;  
                $string = substr($string, 1, -1);
                    
            } elseif (in_array(substr($string, 0, 1), $this->modifiers['wc'])) {
                $type = SQFRONT;
                $string = substr($string, 1);
                
            } elseif (in_array(substr($string, -1), $this->modifiers['wc'])) {
                $type = SQEND;
                $string = substr($string, 0, -1);
                
            } else {
                $type = SQEXACT;
            }
            
            // compress the keyword
            $string = $this->compressKeyword($string);
            
            //add keyword
            if (!empty($string)) {
                 
                // add default "and" between strings
                if (!$wasop) {
                    $lasttoken = array(
                        'type'   => "and",
                        'string' => "and"
                    ); 
                    $this->tokens[] =  $lasttoken;
                }
                                  
                //add string token
                $lasttoken = array(
                    'type'   => $type,
                    'string' => $string,
                    'not'    => $not
                );
                $this->tokens[] = $lasttoken;
                
            // remove operator when keyword is empty
            } else {
                if ($wasop) {
                    array_pop($this->tokens);
                    $lasttoken = end($this->tokens);
                    reset($this->tokens);
                }
            }
        }
        
        //remove leading and-token
        array_shift($this->tokens);
    }
    
    // interpret tokens
    private function interpret() {
        
        // call Helper
        return $this->interpretHelper(0, "");
    }
    
    // combine tokens
    private function interpretHelper($pos, $old) {
       
        //check for last token
        if ($pos >= count($this->tokens))
            return $old;
        
        
        // take next token
        $token = $this->tokens[$pos];

        // switch type
        switch ($token['type']) {
            case "and":
				if (isset($this->tokens[$pos+2])) {
					return $this->interpretHelper($pos+2, new SearchOperator($token['type'], $old, $this->createSearchLeaf($this->tokens[$pos+1])));	
				} else {
					return new SearchOperator($token['type'], $old, $this->interpretHelper(++$pos, ""));
				}
            
            case "or":
                return new SearchOperator($token['type'], $old, $this->interpretHelper(++$pos, ""));
            case "xor":
                return new SearchOperator($token['type'], $old, $this->interpretHelper(++$pos, ""));
            default:
                return $this->interpretHelper(++$pos, $this->createSearchLeaf($token));
                break;
        }

    }
    
    // return a SearchLeaf build from a Token
    private function createSearchLeaf($token) {
		return new SearchLeaf($token['string'], $token['type'], $token['not']);
	} 
    
    // set operations
    private function setOperators($operators) {
        $this->operators = $operators;
    }
    // set modifiers
    private function setModifiers($modifiers) {
        $this->modifiers = $modifiers;
    }
    
    private function compressKeyword ($text) {
        return delete_stopwords(compress_search_data($text));
    }    
}
