<?php
/* Generated from ./assert_templates/in.tpl */
function haanga_8815cff61dc42c8002f44fd73612611e6bc333e6($vars, $return=FALSE, $blocks=array())
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