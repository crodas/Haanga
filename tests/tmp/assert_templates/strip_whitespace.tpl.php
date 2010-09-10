<?php
$HAANGA_VERSION  = '1.0.4';
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/strip_whitespace.tpl */
function haanga_d7c4d5b38d3a7e0818e446612beff5c975ed8985($vars, $return=FALSE, $blocks=array())
{
    global $test_global, $global1;
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    if (empty($test_global) === FALSE) {
        
        foreach ($test_global as  $i) {
            echo ' '.htmlspecialchars($i).' '.htmlspecialchars($i).' ';
        }
        
    }
    echo ' <b> Texto laargo </b> <pre>
Este es un texto 

con
        espacios

</pre> Another text ';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}