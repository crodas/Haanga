<?php
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/inheritence_nested_block_duplicated.tpl */
function haanga_41332bba378ec4202564b8a41c93af48567b2781($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    $buffer1  = "\n{{block.1b3231655cebb7a1f783eddf27d254ca}}\nnew stuff\n";
    $buffer2  = "\nnew inner2\n";
    $blocks["inner2"]  = (isset($blocks["inner2"]) ? (strpos($blocks["inner2"], "{{block.1b3231655cebb7a1f783eddf27d254ca}}") === FALSE ? $blocks["inner2"] : str_replace("{{block.1b3231655cebb7a1f783eddf27d254ca}}", $buffer2, $blocks["inner2"])) : $buffer2);
    $buffer1 .= $blocks["inner2"]."\n";
    $blocks["outer"]  = (isset($blocks["outer"]) ? (strpos($blocks["outer"], "{{block.1b3231655cebb7a1f783eddf27d254ca}}") === FALSE ? $blocks["outer"] : str_replace("{{block.1b3231655cebb7a1f783eddf27d254ca}}", $buffer1, $blocks["outer"])) : $buffer1);
    echo Haanga::Load("assert_templates/nested_block.tpl", $vars, TRUE, $blocks);
    if ($return == TRUE) {
        return ob_get_clean();
    }
}