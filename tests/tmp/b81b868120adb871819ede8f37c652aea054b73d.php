<?php
/* Generated from ./assert_templates/empty_loop.tpl */
function haanga_b81b868120adb871819ede8f37c652aea054b73d($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    $buffer1  = "";
    if (count($users) == 0) {
        $buffer1 .= "\n    Else\n";
    } else {
        $forcounter1_3  = 1;
        $forcounter0_3  = 0;
        $psize_3  = count($users);
        $islast_3  = $forcounter1_3 == $psize_3;
        foreach ($users as  $id => $user) {
            $buffer1 .= "\n    ".htmlentities($islast_3)."\n    ".htmlentities($forcounter0_3)."\n    Inside loop\n";
            $forcounter1_3++;
            $forcounter0_3++;
            $islast_3  = $forcounter1_3 == $psize_3;
        }
    }
    $buffer1 .= "\n";
    if ($return == TRUE) {
        return $buffer1;
    } else {
        echo $buffer1;
    }
}