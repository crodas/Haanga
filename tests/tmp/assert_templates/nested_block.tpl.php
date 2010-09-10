<?php
$HAANGA_VERSION  = '1.0.4';
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/nested_block.tpl */
function haanga_57c4ad33715ae7aa88250c99f9339224979afde7($vars, $return=FALSE, $blocks=array())
{
    global $test_global, $global1;
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    $buffer1  = '
';
    $buffer2  = '
this is inner1
';
    $buffer1 .= (isset($blocks['inner1']) ? (strpos($blocks['inner1'], '{{block.1b3231655cebb7a1f783eddf27d254ca}}') === FALSE ? $blocks['inner1'] : str_replace('{{block.1b3231655cebb7a1f783eddf27d254ca}}', $buffer2, $blocks['inner1'])) : $buffer2).'
';
    $buffer2  = '
this is inner2
';
    $buffer1 .= (isset($blocks['inner2']) ? (strpos($blocks['inner2'], '{{block.1b3231655cebb7a1f783eddf27d254ca}}') === FALSE ? $blocks['inner2'] : str_replace('{{block.1b3231655cebb7a1f783eddf27d254ca}}', $buffer2, $blocks['inner2'])) : $buffer2).'
';
    echo (isset($blocks['outer']) ? (strpos($blocks['outer'], '{{block.1b3231655cebb7a1f783eddf27d254ca}}') === FALSE ? $blocks['outer'] : str_replace('{{block.1b3231655cebb7a1f783eddf27d254ca}}', $buffer1, $blocks['outer'])) : $buffer1).'
';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}