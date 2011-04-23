<?php
$HAANGA_VERSION  = '1.0.4';
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/spaceless.tpl */
function haanga_51446bb05a294ee636668b4fd94a6dd706202215($vars, $return=FALSE, $blocks=array())
{
    global $test_global, $global1;
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    $buffer1  = '
<p>
    <a href="foo/"> Foo </a>
            </p>    ';
    echo preg_replace(Array('/>[ \\t\\r\\n]+</sU', '/^[ \\t\\r\\n]+</sU', '/>[ \\t\\r\\n]+$/sU'), Array('><', '<', '>'), $buffer1).'
===========================
';
    $buffer1  = '
<b>
    <pre>
    Something cool

    </pre>








</b> ';
    echo preg_replace(Array('/>[ \\t\\r\\n]+</sU', '/^[ \\t\\r\\n]+</sU', '/>[ \\t\\r\\n]+$/sU'), Array('><', '<', '>'), $buffer1).'
';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}