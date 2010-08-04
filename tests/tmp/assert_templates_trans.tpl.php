<?php
/* Generated from ./assert_templates/trans.tpl */
function haanga_8d35b55be0c9b118eda2226b6b520297156d8d6d($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    $buffer1  = ""._("Translation")."\n"._("Translation")."\n".htmlentities(_($text))."\n".htmlentities(ucfirst(_($text)))."\n";
    if ($return == TRUE) {
        return $buffer1;
    } else {
        print($buffer1);
    }
}