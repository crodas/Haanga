<?php
$HAANGA_VERSION  = '1.0.4';
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/concat.tpl */
function haanga_d4ac2b21a364b7d698afe669b918b6fdcc7d2396($vars, $return=FALSE, $blocks=array())
{
    global $test_global, $global1;
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    $bar  = 'bar';
    $vars['bar']  = $bar;
    echo '
';
    $foo  = ('foo' . 'bar' . $bar);
    $vars['foo']  = $foo;
    echo '
'.htmlspecialchars($foo).'
';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}