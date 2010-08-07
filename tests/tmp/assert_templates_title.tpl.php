<?php
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/title.tpl */
function haanga_861397d1caf7f12c39b6e9cf53ac5ac87ad3551f($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    echo htmlentities(ucwords(strtolower($title)))."\n";
    if ($return == TRUE) {
        return ob_get_clean();
    }
}