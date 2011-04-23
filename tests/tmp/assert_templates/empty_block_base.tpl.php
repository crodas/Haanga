<?php
$HAANGA_VERSION  = '1.0.4';
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/empty_block_base.tpl */
function haanga_2528569ca0e05d02c2082a15590d5d42ee692207($vars, $return=FALSE, $blocks=array())
{
    global $test_global, $global1;
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    echo 'bar
';
    $buffer1  = '';
    echo (isset($blocks['outer']) ? (strpos($blocks['outer'], '{{block.1b3231655cebb7a1f783eddf27d254ca}}') === FALSE ? $blocks['outer'] : str_replace('{{block.1b3231655cebb7a1f783eddf27d254ca}}', $buffer1, $blocks['outer'])) : $buffer1).'
foo
';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}