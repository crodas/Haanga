<?php
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/empty_loop.tpl */
function haanga_b81b868120adb871819ede8f37c652aea054b73d($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    if (count($users) == 0) {
        echo "\n    Else\n";
    } else {
        $forcounter1_1  = 1;
        $forcounter0_1  = 0;
        $psize_1  = count($users);
        $islast_1  = $forcounter1_1 == $psize_1;
        foreach ($users as  $id => $user) {
            echo "\n    ".$islast_1."\n    ".$forcounter0_1."\n    Inside loop\n";
            $forcounter1_1  = $forcounter1_1 + 1;
            $forcounter0_1  = $forcounter0_1 + 1;
            $islast_1  = $forcounter1_1 == $psize_1;
        }
    }
    echo "\n";
    if ($return == TRUE) {
        return ob_get_clean();
    }
}