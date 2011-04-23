<?php
$HAANGA_VERSION  = '1.0.4';
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/bitwise.tpl */
function haanga_49e8d0a4f387f3c9583f254234500e05c2b533a2($vars, $return=FALSE, $blocks=array())
{
    global $test_global, $global1;
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    if ((15 & 7) == 7) {
        echo '
    Match
';
    }
    echo '
';
    if ((13 & 2) == 0) {
        echo '
    Match
';
    }
    echo '
';
    if ((15 | 8) == 15) {
        echo '
    Match
';
    }
    echo '
';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}