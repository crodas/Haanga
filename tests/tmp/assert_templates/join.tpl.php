<?php
$HAANGA_VERSION  = '1.0.4';
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/join.tpl */
function haanga_1d992f3d68f25e0f67960320816915d87f8e6120($vars, $return=FALSE, $blocks=array())
{
    global $test_global, $global1;
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    echo htmlspecialchars(implode(' // ', $array)).'
'.htmlspecialchars(implode('', $array)).'
'.htmlspecialchars(implode(' // ', array_reverse($array, TRUE))).'
';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}