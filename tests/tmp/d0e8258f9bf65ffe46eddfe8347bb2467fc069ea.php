<?php
/* Generated from ./assert_templates/variable_existe.tpl */
function haanga_d0e8258f9bf65ffe46eddfe8347bb2467fc069ea($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    $buffer1  = "";
    if ((empty($var["exists"]) == TRUE ? "" : $var["exists"])) {
        $buffer1 .= " Yes ";
    } else {
        $buffer1 .= " No ";
    }
    $buffer1 .= "\n";
    if ($return == TRUE) {
        return $buffer1;
    } else {
        print($buffer1);
    }
}