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
define(SQEXACT, 1);
define(SQFRONT, 2);
define(SQEND,   3);
define(SQBOTH,  4);


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
                    Throw Exception("Prohibited use of NOT in your Searchquery."
                    ."Don't use NOT on both sides of AND.");
                break;
                
            // No not here
            default:
                if ($leftnot || $rightnot)
                    Throw Exception("Prohibited use of NOT in your Searchquery."
                    ."Neither use NOT with OR nor XOR.");
                break;
        }
        
        
        $left = $this->left->getSet();
        $right = $this->right->getSet();
        var_dump($left, $right);
        // fucntion to compare found-data-arrays
        $cmp = function ($v1, $v2) {
            if ($v1['id'] > $v2['id']) return -1;
            if ($v1['id'] == $v2['id']) return 0;    
            return 1;
        };
        
        $cmp_newrank = function (&$v1, $v2) {
            if ($v1['id'] > $v2['id'])
                return -1;
            if ($v1['id'] == $v2['id']) {
                $v1['rank'] = ($v1['rank']+$v2['rank'])/2;
                return 0;
            }
            return 1;
        };
        
        switch ($this->operation) {
            case "and":
                // ziehe linke elemente ab
                if ($leftnot)
                    return array_udiff($right, $left, $cmp);
                // ziehe rechte elemente ab
                if ($rightnot)
                    return array_udiff($left, $right, $cmp);
                // normaler schnitt
                // rank = avg(rank)                
                else
                    return array_cross($left, $right, $cmp_newrank);
                break;
            case "or":
                // verinigung des schnitts und der symetrische differenz
                // zwecks rank berechnung und entfernen doppelter werte
                return array_merge(
                    array_cross($left, $right, $cmp_newrank),
                    array_udiff(
                        array_merge($left, $right),
                        array_uintersect($left, $right, $cmp),
                        $cmp
                    )
                );
                break;
            case "xor":
                // symetrische differenz
                // rank bleibt unverändert
                return array_udiff(
                    array_merge($left, $right),
                    array_uintersect($left, $right, $cmp),
                    $cmp
                ); 
                break;               
                
                
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
        return "(".$this->left.") ".$this->operation." (".$this->right.")";
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
        return $this->dbdata;
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
    
    // to string
    public function __toString() {
        $pref = "";
        if ($this->not)
            $pref = "!";

        return $pref.$this->evaluate();
    }    
     
}
