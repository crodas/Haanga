<?php
/* Generated from ./assert_templates/ifchanged.tpl */
function haanga_be17029b5fd2998df7c922a92652b6886d7780fd($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    $buffer1  = "";
    foreach ($users as  $user) {
        $buffer1 .= "\n    ";
        $buffer2  = "Users with ".htmlentities($user["age"])." years";
        if (isset($ifchanged1) == FALSE OR $ifchanged1 != $buffer2) {
            $buffer1 .= $buffer2;
            $ifchanged1  = $buffer2;
        }
        $buffer1 .= "\n    ".htmlentities($user["name"])."\n";
    }
    $buffer1 .= "\n\n";
    foreach ($users as  $user) {
        $buffer1 .= "\n    ";
        if ((isset($ifchanged2[1]) == FALSE OR $ifchanged2[1] != $user["foo"]) AND isset($ifchanged2[0]) == FALSE OR $ifchanged2[0] != $user["age"]) {
            $buffer1 .= "Users with ".htmlentities($user["age"])." years";
            $ifchanged2  = Array($user["age"], $user["foo"]);
        } else {
            $buffer1 .= "continue";
        }
        $buffer1 .= "\n    ".htmlentities($user["name"])."\n";
    }
    $buffer1 .= "\n";
    if ($return == TRUE) {
        return $buffer1;
    } else {
        echo $buffer1;
    }
}