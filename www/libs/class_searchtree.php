<?php
/**
* @file     class_searchtree.php
* @folder   /libs
* @version  0.2
* @author   Sweil
*
* in this file you can find all classes for the search tree
* 
*/
define("SQEXACT", 1);
define("SQFRONT", 2);
define("SQEND",   3);
define("SQBOTH",  4);


abstract class SearchTree
{
    public abstract function evaluate();
    public abstract function getSet();
    public abstract function nextLeaf();
    public abstract function reset();
    public abstract function isLeaf();
}

class SearchOperator extends SearchTree
{
    private $left;
    private $right;
    private $operation;
    
    // constructor
    public function  __construct ($operation, $left, $right) {
        // get searchfunctions if not loaded   
        require_once(FS2_ROOT_PATH . "includes/searchfunctions.php"); 
        
        $this->left = $left;
        $this->right = $right;
        $this->operation = $operation;
    }
    
    // exectue
    public function evaluate() {
        return "(".$this->left->evaluate().") ".$this->operation." (".$this->right->evaluate().")";
    }
    
    // get set
    public function getSet() {
        
        // check for wrong use of not
        $leftnot = ($this->left->isLeaf() && $this->left->hasNot());
        $rightnot = ($this->right->isLeaf() && $this->right->hasNot());
        
        switch ($this->operation) {
            case "and":
                if ($leftnot && $rightnot)
                    Throw new Exception("Prohibited use of NOT in your Searchquery."
                    ."Don't use NOT on both sides of AND.");
                break;
                
            // No not here
            default:
                if ($leftnot || $rightnot)
                    Throw new Exception("Prohibited use of NOT in your Searchquery."
                    ."Neither use NOT with OR nor XOR.");
                break;
        }
        
        // Get left and right Set
        $left = $this->left->getSet();
        $right = $this->right->getSet();

        //compare on average
        $cmp_avg = function (&$v1, $v2) {
            return compare_update_rank ($v1, $v2, function ($r1, $r2) {return ($r1+$r2)/2;});
        };
        
        
        // switch through operations and call set-functions
        switch ($this->operation) {
            case "and":
                // ziehe linke elemente ab
                if ($leftnot)
                    return array_udiff($right, $left, "compare_found_data");
                // ziehe rechte elemente ab
                if ($rightnot)
                    return array_udiff($left, $right,"compare_found_data");
                // normaler schnitt
                // rank = avg(rank)                
                else
                    return array_cross($left, $right, $cmp_avg);

            case "or":
                // verinigung des schnitts und der symetrische differenz
                // zwecks rank berechnung und entfernen doppelter werte
                return array_real_merge($left, $right, $cmp_avg, "compare_found_data");

            case "xor":
                // symetrische differenz
                // rank bleibt unverändert
                return array_symdiff($left, $right, "compare_found_data");         
                
            default:
                return array();
                
        }
    }    
    
    // get next leaf
    public function nextLeaf() {
        $next = $this->left->nextLeaf();
        if ($next !== false)
            return $next;
        else
            return $this->right->nextLeaf();
    }
    // reset leaf iterator
    public function reset() {
        $this->left->reset();
        $this->right->reset();
    } 
    
    // no leaf
    public function isLeaf() {
        return false;
    }
    
    // operator?
    public function isOperator() {
        return true;
    } 
    
    // to string
    public function __toString() {
        $ops = get_default_operators();
        
        return "(".$this->left.' <span class="search-operator">'.$ops[$this->operation].'</span> '.$this->right.")";
    }    
}


class SearchLeaf extends SearchTree
{
    private $label;
    private $type;
    private $not;
    private $read = false;
    private $dbdata = array();

    // constructor
    public function  __construct ($label, $type, $not) {        
        $this->label = $label;
        $this->type = $type;
        $this->not = $not;
    }
    
    // exectue
    public function evaluate() {
        
        switch ($this->type) {
            case SQEXACT:
                return $this->label;
                break;
            case SQFRONT:
                return '%'.$this->label;
                break;
            case SQEND:
                return $this->label.'%';
                break;
            case SQBOTH:
                return '%'.$this->label.'%';
                break;
            default:
                Throw new ErrorException("Unknown Type in SearchQueryLeaf");
        }
        
        
    }
    
    //set DB Data
    public function setDBData($dbdata) {
        $this->dbdata = $dbdata;
    }

    // get set
    public function getSet() {
        if (is_array($this->dbdata))
            return $this->dbdata;
        
        return array();
    }    
    
    
    // get label
    public function label() {
        return $this->label;
    }
    
    // get next leaf
    public function nextLeaf() {
        if (!$this->read) {
            $this->read = true;
            return $this;
        } else {
            return false;
        }
    }
    // reset leaf iterator
    public function reset() {
        $this->read = false;
    }      
    
    // leaf is leaf ;)
    public function isLeaf() {
        return true;
    }
    // operator?
    public function isOperator() {
        return false;
    } 
    // has Not modifier?
    public function hasNot() {
        return $this->not;
    }
     
    // getter for type
    public function getType() {
        return $this->type;
    }    
    
    // to string
    public function __toString() {
        $ops = get_default_operators();

        $pref = "";
        if ($this->not)
            $pref = '<span class="search-modifier">'.$ops['not'].'</span>';

        return '<span class="search-leaf">'.$pref.str_replace("%", '<span class="search-modifier">'.$ops['wildcard'].'</span>', $this->evaluate()).'</span>';
    }    
     
}
