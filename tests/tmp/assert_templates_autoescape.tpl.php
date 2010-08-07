<?php
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/autoescape.tpl */
function haanga_3b6900b2fc1304e5fbbae2d5df785169d9f530ee($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    echo htmlentities($variable)."\n".htmlentities($variable)."\n".$variable."\n\n    ".$variable."\n    \n        ".htmlentities($variable)."\n    \n\n".htmlentities($variable)."\n";
    if ($return == TRUE) {
        return ob_get_clean();
    }
}