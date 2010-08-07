<?php
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/ifequals.tpl */
function haanga_738a8ebcdd95609cb2eff656eefd582f01039524($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    if (1 == 2) {
        echo "\n    Equals\n";
    } else {
        echo "\n    Non Equals\n";
    }
    echo "\n";
    if (1 != 2) {
        echo "\n    Non Equals\n";
    } else {
        echo "\n    Equals\n";
    }
    echo "\n";
    if ($return == TRUE) {
        return ob_get_clean();
    }
}