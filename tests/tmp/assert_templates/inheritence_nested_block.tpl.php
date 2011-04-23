<?php
$HAANGA_VERSION  = '1.0.4';
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/inheritence_nested_block.tpl */
function haanga_a2c536c1d9b6f09d66feff81ca9b1e993d15d32e($vars, $return=FALSE, $blocks=array())
{
    global $test_global, $global1;
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    $buffer1  = '
{{block.1b3231655cebb7a1f783eddf27d254ca}}
new stuff
';
    $blocks['outer']  = (isset($blocks['outer']) ? (strpos($blocks['outer'], '{{block.1b3231655cebb7a1f783eddf27d254ca}}') === FALSE ? $blocks['outer'] : str_replace('{{block.1b3231655cebb7a1f783eddf27d254ca}}', $buffer1, $blocks['outer'])) : $buffer1);
    echo Haanga::Load('assert_templates/nested_block.tpl', $vars, TRUE, $blocks);
    if ($return == TRUE) {
        return ob_get_clean();
    }
}