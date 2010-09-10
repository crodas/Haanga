<?php
$HAANGA_VERSION  = '1.0.4';
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/nested_block_second_parent_override.tpl */
function haanga_d905488f199a96b638d52d62c0fc424fd291ed39($vars, $return=FALSE, $blocks=array())
{
    global $test_global, $global1;
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    $buffer1  = '
    2.1-overrided
';
    $blocks['inner2_1']  = (isset($blocks['inner2_1']) ? (strpos($blocks['inner2_1'], '{{block.1b3231655cebb7a1f783eddf27d254ca}}') === FALSE ? $blocks['inner2_1'] : str_replace('{{block.1b3231655cebb7a1f783eddf27d254ca}}', $buffer1, $blocks['inner2_1'])) : $buffer1);
    echo Haanga::Load('assert_templates/nested_block_second_parent.tpl', $vars, TRUE, $blocks);
    if ($return == TRUE) {
        return ob_get_clean();
    }
}