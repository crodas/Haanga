<?php
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/autoescape.tpl */
function haanga_9f328ab33a95f88c4be986568c7ec6d5c60efa76($vars, $return=FALSE, $blocks=array())
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