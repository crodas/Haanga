<?php
$HAANGA_VERSION  = '1.0.3';
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/autoescape.tpl */
function haanga_3b6900b2fc1304e5fbbae2d5df785169d9f530ee($vars, $return=FALSE, $blocks=array())
{
    global $test_global;
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    echo htmlentities($variable).'
'.htmlentities($variable).'
{ '.$variable.' }

    '.$variable.'
    
        '.htmlentities($variable).'
    

'.htmlentities($variable).'
';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}