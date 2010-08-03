<?php
/* Generated from ./assert_templates/ifchanged.tpl */
function haanga_be17029b5fd2998df7c922a92652b6886d7780fd($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    $buffer1  = "";
    $sorted_users  = $users;
    $field  = Array();
    foreach ($sorted_users as  $key => $item) {
        $field[$key]  = $item[$regroup_field];
    }
    array_multisort($field, SORT_REGULAR, $sorted_users);
    $buffer1 .= "\n";
    foreach ($sorted_users as  $user) {
        $buffer1 .= "\n    ";
        $buffer2  = "Users with ".htmlentities($user["age"])." years";
        if (isset($ifchanged1) == FALSE || $ifchanged1 != $buffer2) {
            $buffer1 .= $buffer2;
            $ifchanged1  = $buffer2;
        }
        $buffer1 .= "\n    ".htmlentities($user["name"])."\n";
    }
    $buffer1 .= "\n\n";
    foreach ($sorted_users as  $user) {
        $buffer1 .= "\n    ";
        if ((isset($ifchanged2[0]) == FALSE || $ifchanged2[0] != $user["age"]) && (isset($ifchanged2[1]) == FALSE || $ifchanged2[1] != $user["foo"])) {
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
        print($buffer1);
    }
}