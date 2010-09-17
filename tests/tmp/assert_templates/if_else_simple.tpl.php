<?php
$HAANGA_VERSION  = '1.0.4';
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/if_else_simple.tpl */
function haanga_e7733880179030f69680f92d682d991e9f93c62e($vars, $return=FALSE, $blocks=array())
{
    global $test_global, $global1;
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    if (1 == 2 || 1 + 2 == 3) {
        echo 'True';
    } else {
        echo 'False';
    }
    echo '
';
    if (strtoupper($var) == $var) {
        echo 'True';
    } else {
        echo 'False';
    }
    echo '
';
    if (1 === 2 || 1 + 2 === 3) {
        echo 'True';
    } else {
        echo 'False';
    }
    echo '
';
    if (1 !== 2) {
        echo 'True';
    } else {
        echo 'False';
    }
    echo '
';
    if (1 > 2) {
        echo 'True';
    } else {
        echo 'False';
    }
    echo '
';
    if (1 >= 2) {
        echo 'True';
    } else {
        echo 'False';
    }
    echo '
';
    if (1 <= 2) {
        echo 'True';
    } else {
        echo 'False';
    }
    echo '
';
    if (1 < 2) {
        echo 'True';
    } else {
        echo 'False';
    }
    echo '
';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}