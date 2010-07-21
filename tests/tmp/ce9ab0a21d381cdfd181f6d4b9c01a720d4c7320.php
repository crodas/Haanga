<?php
/* Generated from ./assert_templates/cycle.tpl */
function haanga_ce9ab0a21d381cdfd181f6d4b9c01a720d4c7320($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    $buffer1  = "";
    foreach ($array as  $user) {
        $buffer1 .= "\n    ";
        $def_cycle_0  = Array("uno", "dos", "tres");
        $index_0  = (isset($index_0) == FALSE ? 0 : ($index_0 + 1) % count($def_cycle_0));
        $buffer1 .= $def_cycle_0[$index_0];
        $buffer1 .= "\n";
    }
    $buffer1 .= "\n-----------------------------------------------\n";
    $def_cycle_1  = Array("uno", "dos", "tres");
    $index_1  = -1;
    $buffer1 .= "\n";
    $index_1  = ($index_1 + 1) % count($def_cycle_1);
    $buffer1 .= $def_cycle_1[$index_1];
    $buffer1 .= "\n";
    $index_1  = ($index_1 + 1) % count($def_cycle_1);
    $buffer1 .= $def_cycle_1[$index_1];
    $buffer1 .= "\n";
    $index_1  = ($index_1 + 1) % count($def_cycle_1);
    $buffer1 .= $def_cycle_1[$index_1];
    $buffer1 .= "\n";
    $index_1  = ($index_1 + 1) % count($def_cycle_1);
    $buffer1 .= $def_cycle_1[$index_1];
    $buffer1 .= "\n";
    if ($return == TRUE) {
        return $buffer1;
    } else {
        echo $buffer1;
    }
}