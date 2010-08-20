<?php
$HAANGA_VERSION  = '1.0.3';
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/global.tpl */
function haanga_7a375fb2704088e2b14f656c72d527d8203027fe($vars, $return=FALSE, $blocks=array())
{
    global $test_global, $global1;
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    echo htmlentities($test_global['b']).' '.htmlentities($global1['foo']->foo['bar']).' '.(empty($global1['bar']->xxx) == TRUE ? 'xxx' : $global1['bar']->xxx).'
';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}