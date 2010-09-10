<?php
$HAANGA_VERSION  = '1.0.4';
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/empty_block.tpl */
function haanga_464bf9fc69ec3d748e58e59c7b427e138da5ab9b($vars, $return=FALSE, $blocks=array())
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
    $blocks['inner1']  = (isset($blocks['inner1']) ? (strpos($blocks['inner1'], '{{block.1b3231655cebb7a1f783eddf27d254ca}}') === FALSE ? $blocks['inner1'] : str_replace('{{block.1b3231655cebb7a1f783eddf27d254ca}}', $buffer2, $blocks['inner1'])) : $buffer2);
    $buffer1 .= $blocks['inner1'].'
';
    $buffer2  = '
this is inner2
';
    $blocks['inner2']  = (isset($blocks['inner2']) ? (strpos($blocks['inner2'], '{{block.1b3231655cebb7a1f783eddf27d254ca}}') === FALSE ? $blocks['inner2'] : str_replace('{{block.1b3231655cebb7a1f783eddf27d254ca}}', $buffer2, $blocks['inner2'])) : $buffer2);
    $buffer1 .= $blocks['inner2'].'
';
    $blocks['outer']  = (isset($blocks['outer']) ? (strpos($blocks['outer'], '{{block.1b3231655cebb7a1f783eddf27d254ca}}') === FALSE ? $blocks['outer'] : str_replace('{{block.1b3231655cebb7a1f783eddf27d254ca}}', $buffer1, $blocks['outer'])) : $buffer1);
    echo Haanga::Load('assert_templates/empty_block_base.tpl', $vars, TRUE, $blocks);
    if ($return == TRUE) {
        return ob_get_clean();
    }
}