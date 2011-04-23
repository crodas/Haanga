<?php
$HAANGA_VERSION  = '1.0.4';
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/set.tpl */
function haanga_f5ad40d56c2438ea6bb3882d3b5e5ebf18352938($vars, $return=FALSE, $blocks=array())
{
    global $test_global, $global1;
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    $foo  = (5 + 1);
    $vars['foo']  = $foo;
    echo '
';
    $bar  = 'testing';
    $vars['bar']  = $bar;
    echo '
'.htmlspecialchars($foo).'
'.Haanga::Load('assert_templates/sub_set.tpl', $vars, TRUE, $blocks).'
';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}