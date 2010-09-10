<?php
$HAANGA_VERSION  = '1.0.4';
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/autoescape.tpl */
function haanga_3b6900b2fc1304e5fbbae2d5df785169d9f530ee($vars, $return=FALSE, $blocks=array())
{
    global $test_global, $global1;
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    echo htmlspecialchars($variable).'
'.htmlspecialchars($variable).'
{ '.$variable.' }

    '.$variable.'
    
        '.htmlspecialchars($variable).'
    

'.htmlspecialchars($variable).'
';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}