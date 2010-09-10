<?php
$HAANGA_VERSION  = '1.0.4';
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/custom_tag.tpl */
function haanga_d10dbccd9d65b519706f053a50a078dbb3e14070($vars, $return=FALSE, $blocks=array())
{
    global $test_global, $global1;
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    echo date('Y').'
';
    $foo  = date('U');
    echo htmlspecialchars(date('Y', $foo)).'
';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}