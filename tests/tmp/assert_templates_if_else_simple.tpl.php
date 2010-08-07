<?php
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/if_else_simple.tpl */
function haanga_b3fb27d2242a9e85db10c34f0cb971acab6cacc8($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    if (1 + 2 == 3) {
        echo "True";
    } else {
        echo "False";
    }
    echo "\n";
    if (strtoupper($var) == $var) {
        echo "True";
    } else {
        echo "False";
    }
    echo "\n";
    if ($return == TRUE) {
        return ob_get_clean();
    }
}