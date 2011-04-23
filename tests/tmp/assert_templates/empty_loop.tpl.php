<?php
$HAANGA_VERSION  = '1.0.4';
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/empty_loop.tpl */
function haanga_b81b868120adb871819ede8f37c652aea054b73d($vars, $return=FALSE, $blocks=array())
{
    global $test_global, $global1;
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    if (count($users) == 0) {
        echo '
    Else
';
    } else {
        $forcounter1_1  = 1;
        $forcounter0_1  = 0;
        $psize_1  = count($users);
        $islast_1  = ($forcounter1_1 == $psize_1);
        foreach ($users as  $id => $user) {
            echo '
    '.$islast_1.'
    '.$forcounter0_1.'
    Inside loop
';
            $forcounter1_1  = ($forcounter1_1 + 1);
            $forcounter0_1  = ($forcounter0_1 + 1);
            $islast_1  = ($forcounter1_1 == $psize_1);
        }
    }
    echo '
';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}