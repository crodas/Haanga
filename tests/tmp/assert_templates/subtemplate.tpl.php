<?php
$HAANGA_VERSION  = '1.0.4';
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/subtemplate.tpl */
function haanga_8012978a44e77332b744185d044350c7eb89603f($vars, $return=FALSE, $blocks=array())
{
    global $test_global, $global1;
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    $buffer1  = 'My Title - {{block.1b3231655cebb7a1f783eddf27d254ca}}';
    $blocks['title']  = (isset($blocks['title']) ? (strpos($blocks['title'], '{{block.1b3231655cebb7a1f783eddf27d254ca}}') === FALSE ? $blocks['title'] : str_replace('{{block.1b3231655cebb7a1f783eddf27d254ca}}', $buffer1, $blocks['title'])) : $buffer1);
    $buffer1  = '
    {{block.1b3231655cebb7a1f783eddf27d254ca}}

    :-)
';
    $blocks['main.menu']  = (isset($blocks['main.menu']) ? (strpos($blocks['main.menu'], '{{block.1b3231655cebb7a1f783eddf27d254ca}}') === FALSE ? $blocks['main.menu'] : str_replace('{{block.1b3231655cebb7a1f783eddf27d254ca}}', $buffer1, $blocks['main.menu'])) : $buffer1);
    echo Haanga::Load('assert_templates/base.tpl', $vars, TRUE, $blocks);
    if ($return == TRUE) {
        return ob_get_clean();
    }
}