<?php
/* Generated from ./assert_templates/inheritence_nested_block.tpl */
function haanga_a2c536c1d9b6f09d66feff81ca9b1e993d15d32e($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    $buffer1  = "";
    $buffer2  = "\n{{block.1b3231655cebb7a1f783eddf27d254ca}}\nnew stuff\n";
    $blocks["outer"]  = (isset($blocks["outer"]) ? (strpos($blocks["outer"], "{{block.1b3231655cebb7a1f783eddf27d254ca}}") === FALSE ? $blocks["outer"] : str_replace("{{block.1b3231655cebb7a1f783eddf27d254ca}}", $buffer2, $blocks["outer"])) : $buffer2);
    $buffer1 .= Haanga::Load("assert_templates/nested_block.tpl", $vars, TRUE, $blocks);
    if ($return == TRUE) {
        return $buffer1;
    } else {
        print($buffer1);
    }
}