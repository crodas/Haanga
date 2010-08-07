<?php
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/inheritence_nested_block.tpl */
function haanga_7f54318a61253651f70eb094d4f67e59d393f33a($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    $buffer1  = "\n{{block.1b3231655cebb7a1f783eddf27d254ca}}\nnew stuff\n";
    $blocks["outer"]  = (isset($blocks["outer"]) ? (strpos($blocks["outer"], "{{block.1b3231655cebb7a1f783eddf27d254ca}}") === FALSE ? $blocks["outer"] : str_replace("{{block.1b3231655cebb7a1f783eddf27d254ca}}", $buffer1, $blocks["outer"])) : $buffer1);
    echo Haanga::Load("assert_templates/nested_block.tpl", $vars, TRUE, $blocks);
    if ($return == TRUE) {
        return ob_get_clean();
    }
}