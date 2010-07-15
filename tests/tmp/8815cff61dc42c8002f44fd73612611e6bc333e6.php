<?php
/* Generated from ./assert_templates/in.tpl */
function haanga_8815cff61dc42c8002f44fd73612611e6bc333e6($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    $buffer1  = "";
    if (strpos("cesar d. rodas", "d.") !== FALSE) {
        $buffer1 .= "\n    Here\n";
    }
    $buffer1 .= "\n";
    if ((is_array($names) == TRUE ? array_search("d.", $names) : strpos($names, "d.")) !== FALSE) {
        $buffer1 .= "\n    Here\n";
    }
    $buffer1 .= "\n";
    if (strpos("cesar d. rodas", $search) !== FALSE) {
        $buffer1 .= "\n    Here\n";
    }
    $buffer1 .= "\n";
    if ((is_array($names) == TRUE ? array_search($search, $names) : strpos($names, $search)) !== FALSE) {
        $buffer1 .= "\n    Here\n";
    }
    $buffer1 .= "\n";
    if ($return == TRUE) {
        return $buffer1;
    } else {
        echo $buffer1;
    }
}