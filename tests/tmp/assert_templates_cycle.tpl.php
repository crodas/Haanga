<?php
/* Generated from ./assert_templates/cycle.tpl */
function haanga_ce9ab0a21d381cdfd181f6d4b9c01a720d4c7320($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    foreach ($array as  $user) {
        echo "\n    ";
        $def_cycle_0  = Array("uno", "dos", "tres");
        $index_0  = (isset($index_0) == FALSE ? 0 : ($index_0 + 1) % count($def_cycle_0));
        echo $def_cycle_0[$index_0]."\n";
    }
    echo "\n-----------------------------------------------\n";
    $def_cycle_1  = Array("uno", "dos", "tres");
    $index_1  = -1;
    echo "\n";
    $index_1  = ($index_1 + 1) % count($def_cycle_1);
    echo $def_cycle_1[$index_1]."\n";
    $index_1  = ($index_1 + 1) % count($def_cycle_1);
    echo $def_cycle_1[$index_1]."\n";
    $index_1  = ($index_1 + 1) % count($def_cycle_1);
    echo $def_cycle_1[$index_1]."\n";
    $index_1  = ($index_1 + 1) % count($def_cycle_1);
    echo $def_cycle_1[$index_1]."\n";
    if ($return == TRUE) {
        return ob_get_clean();
    }
}