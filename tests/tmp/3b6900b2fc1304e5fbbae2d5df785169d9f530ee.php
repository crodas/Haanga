<?php
/* Generated from ./assert_templates/autoescape.tpl */
function haanga_3b6900b2fc1304e5fbbae2d5df785169d9f530ee($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    $buffer1  = "".htmlentities($variable)."\n".htmlentities($variable)."\n".$variable."\n\n    ".$variable."\n    \n        ".htmlentities($variable)."\n    \n\n".htmlentities($variable)."\n";
    if ($return == TRUE) {
        return $buffer1;
    } else {
        echo $buffer1;
    }
}