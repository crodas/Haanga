<?php
$HAANGA_VERSION  = '1.0.4';
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/class_static.tpl */
function haanga_e5111161052e0480a9a2c62368c1510eb7d28820($vars, $return=FALSE, $blocks=array())
{
    global $test_global, $global1;
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    echo htmlspecialchars(Foo_Bar::$Bar).'
'.htmlspecialchars(Foo_Bar::$Arr['0']).'
'.htmlspecialchars(Foo_Bar::$Arr['Bar']).'
';
    $foo  = Foo_Bar::something();
    echo '
'.htmlspecialchars($foo).'
';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}