<?php
/* Generated from ./assert_templates/empty_loop.tpl */
function haanga_b81b868120adb871819ede8f37c652aea054b73d($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    $buffer1  = "";
    if (count($users) == 0) {
        $buffer1 .= "\n    Else\n";
    } else {
        $forcounter1_1  = 1;
        $forcounter0_1  = 0;
        $psize_1  = count($users);
        $islast_1  = $forcounter1_1 == $psize_1;
        foreach ($users as  $id => $user) {
            $buffer1 .= "\n    ".$islast_1."\n    ".$forcounter0_1."\n    Inside loop\n";
            $forcounter1_1  = $forcounter1_1 + 1;
            $forcounter0_1  = $forcounter0_1 + 1;
            $islast_1  = $forcounter1_1 == $psize_1;
        }
    }
    $buffer1 .= "\n";
    if ($return == TRUE) {
        return $buffer1;
    } else {
        print($buffer1);
    }
}