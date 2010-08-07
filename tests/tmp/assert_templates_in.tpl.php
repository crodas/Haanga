<?php
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/in.tpl */
function haanga_c8cb9e58c481042372203fbc698a41bae6dcfc47($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    if (strpos("cesar d. rodas", "d.") !== FALSE) {
        echo "\n    Here\n";
    }
    echo "\n";
    if ((is_array($names) ? array_search("d.", $names) : strpos($names, "d.")) !== FALSE) {
        echo "\n    Here\n";
    }
    echo "\n";
    if (strpos("cesar d. rodas", $search) !== FALSE) {
        echo "\n    Here\n";
    }
    echo "\n";
    if ((is_array($names) ? array_search($search, $names) : strpos($names, $search)) !== FALSE) {
        echo "\n    Here\n";
    }
    echo "\n";
    if ($return == TRUE) {
        return ob_get_clean();
    }
}