<?php
/* Generated from ./assert_templates/ifequals.tpl */
function haanga_0c118610d6837670c71af0327fb53e43cea00877($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    $buffer1  = "";
    if (1 == 2) {
        $buffer1 .= "\n    Equals\n";
    } else {
        $buffer1 .= "\n    Non Equals\n";
    }
    $buffer1 .= "\n";
    if (1 != 2) {
        $buffer1 .= "\n    Non Equals\n";
    } else {
        $buffer1 .= "\n    Equals\n";
    }
    $buffer1 .= "\n";
    if ($return == TRUE) {
        return $buffer1;
    } else {
        print($buffer1);
    }
}