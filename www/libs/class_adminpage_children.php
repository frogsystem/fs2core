<?php

/**
 * @file     class_adminpage_children.php
 * @folder   /libs
 * @version  0.1
 * @author   Satans Krümelmonster
 *
 * privides classes to manage adminpage-children.
 */

class adminpage_text {

    protected $text;

    function __construct ($TEXT){
        $this->text = strval($TEXT);
    }

    public function get (){
        return $this->text;
    }
}

class adminpage_condition {

    protected $condition = "";
    protected $condval = "";
    protected $childs = array("if" => array(), "else" => array());

    function __construct (&$array) {
        $id = $array[0];
        $array[0] = $array[0]+1;
        if ($id != -1) {
            $this->condition = $array[1][$id][cond];
            $this->condval   = $array[1][$id][condval];
            unset($array[1][$id]);
        }
        
        $i = 0;
        while ($i < count($array[2])) {
            if ($array[2][$i][used] == false){
                if ($array[2][$i][parent] == $id) {
                    $array[2][$i][used] = true;
                    if($array[2][$i][type] == 1){
                        $this->addChild(0, $array[2][$i][content]);
                    } else {
                        $this->addChild(1, $array[2][$i][content]);
                    }
                } elseif (isset($array[1][$array[2][$i][parent]]) && $array[1][$array[2][$i][parent]][parent] == $id) { // unterknoten
                    $array[0] = $array[2][$i][parent];
                    if($array[1][$array[2][$i][parent]][inif] == true){
                        $this->addChild(2, $array);
                    } else {
                        $this->addChild(3, $array);
                    }
                }
            }
            $i++;
        }
    }

    public function addChild ($type, &$values){
        if ($type < 2){ // textknoten
            if ($type == 0){ // IF-kind
                $this->childs['if'][]   = new adminpage_text($values);
            } else { // ELSE-kind
                $this->childs['else'][] = new adminpage_text($values);
            }
        } else { // bedingungsknoten
            if ($type == 2){ // IF-kind
                $this->childs['if'][]   = new adminpage_condition($values);
            } else { // ELSE-kind
                $this->childs['else'][] = new adminpage_condition($values);
            }
        }
    }

    public function get ($conditions) {
        if (array_key_exists($this->condition, $conditions) && $conditions[$this->condition] == $this->condval){ // bedingung stimmt
            $childs = $this->childs['if'];
        } else { // bedingung nicht vorhanden oder existiert nicht
            $childs = $this->childs['else'];
        }
        initstr($return);
        
        foreach ($childs as $child) {
            if (is_a($child, "adminpage_condition"))
                $return .= $child->get($conditions);
            else
                $return .= $child->get();
        }
        
        return $return;
    }
}
?>
