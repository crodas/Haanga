<?php
$HAANGA_VERSION  = '1.0.3';
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/cycle.tpl */
function haanga_ce9ab0a21d381cdfd181f6d4b9c01a720d4c7320($vars, $return=FALSE, $blocks=array())
{
    global $test_global;
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    foreach ($array as  $user) {
        echo '
    ';
        if (isset($def_cycle_6) == FALSE) {
            $def_cycle_6  = Array('uno', 'dos', 'tres');
        }
        $index_6  = (isset($index_6) == FALSE ? 0 : ($index_6 + 1) % count($def_cycle_6));
        echo $def_cycle_6[$index_6].'
';
    }
    echo '
-----------------------------------------------
';
    $def_cycle_7  = Array('uno', 'dos', 'tres');
    $index_7  = -1;
    echo '
';
    $index_7  = ($index_7 + 1) % count($def_cycle_7);
    echo $def_cycle_7[$index_7].'
';
    $index_7  = ($index_7 + 1) % count($def_cycle_7);
    echo $def_cycle_7[$index_7].'
';
    $index_7  = ($index_7 + 1) % count($def_cycle_7);
    echo $def_cycle_7[$index_7].'
';
    $index_7  = ($index_7 + 1) % count($def_cycle_7);
    echo $def_cycle_7[$index_7].'
';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}