<?php
$HAANGA_VERSION  = '1.0.4';
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/concat1.tpl */
function haanga_11c8df5ae845da7ed78f1fb1c0bbb317bc451777($vars, $return=FALSE, $blocks=array())
{
    global $test_global, $global1;
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    if ('foo' . 'bar' == 'foobar') {
        echo '
    Match
';
    } else {
        echo '
    Error
';
    }
    echo '
';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}