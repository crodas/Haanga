<?php
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/nested_block_second_parent.tpl */
function haanga_3cfcb5c76e7bdc24390f92db90deac9364b22a7d($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    $buffer1  = "\n    inner2's new value\n    ";
    $buffer2  = "\n        2.1\n    ";
    $blocks["inner2_1"]  = (isset($blocks["inner2_1"]) ? (strpos($blocks["inner2_1"], "{{block.1b3231655cebb7a1f783eddf27d254ca}}") === FALSE ? $blocks["inner2_1"] : str_replace("{{block.1b3231655cebb7a1f783eddf27d254ca}}", $buffer2, $blocks["inner2_1"])) : $buffer2);
    $buffer1 .= $blocks["inner2_1"]."\n";
    $blocks["inner2"]  = (isset($blocks["inner2"]) ? (strpos($blocks["inner2"], "{{block.1b3231655cebb7a1f783eddf27d254ca}}") === FALSE ? $blocks["inner2"] : str_replace("{{block.1b3231655cebb7a1f783eddf27d254ca}}", $buffer1, $blocks["inner2"])) : $buffer1);
    echo Haanga::Load("assert_templates/nested_block.tpl", $vars, TRUE, $blocks);
    if ($return == TRUE) {
        return ob_get_clean();
    }
}