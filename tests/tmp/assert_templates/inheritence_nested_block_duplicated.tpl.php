<?php
$HAANGA_VERSION  = '1.0.4';
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/inheritence_nested_block_duplicated.tpl */
function haanga_2f06ae0d3b252465fa65c3a02cc1ebab4d90396f($vars, $return=FALSE, $blocks=array())
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
    $buffer2  = '
new inner2
';
    $blocks['inner2']  = (isset($blocks['inner2']) ? (strpos($blocks['inner2'], '{{block.1b3231655cebb7a1f783eddf27d254ca}}') === FALSE ? $blocks['inner2'] : str_replace('{{block.1b3231655cebb7a1f783eddf27d254ca}}', $buffer2, $blocks['inner2'])) : $buffer2);
    $buffer1 .= $blocks['inner2'].'
';
    $blocks['outer']  = (isset($blocks['outer']) ? (strpos($blocks['outer'], '{{block.1b3231655cebb7a1f783eddf27d254ca}}') === FALSE ? $blocks['outer'] : str_replace('{{block.1b3231655cebb7a1f783eddf27d254ca}}', $buffer1, $blocks['outer'])) : $buffer1);
    echo Haanga::Load('assert_templates/nested_block.tpl', $vars, TRUE, $blocks);
    if ($return == TRUE) {
        return ob_get_clean();
    }
}