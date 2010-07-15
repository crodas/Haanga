<?php
/* Generated from ./assert_templates/with.tpl */
function haanga_6b7e79ed219629bc512aa130b0742545436edf01($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    $buffer1  = "";
    foreach ($users as  $user) {
        $buffer1 .= "\n    \n        ".htmlentities(strtoupper($user["name"]))." == ".htmlentities(strtoupper($user["name"]))."\n    \n";
    }
    $buffer1 .= "\n";
    if ($return == TRUE) {
        return $buffer1;
    } else {
        echo $buffer1;
    }
}