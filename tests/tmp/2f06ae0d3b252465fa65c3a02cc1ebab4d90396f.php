<?php
/* Generated from ./assert_templates/inheritence_nested_block_duplicated.tpl */
function haanga_2f06ae0d3b252465fa65c3a02cc1ebab4d90396f($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    $buffer1  = "";
    $buffer2  = "";
    $buffer2 .= "\n{{block.1b3231655cebb7a1f783eddf27d254ca}}\nnew stuff\n";
    $buffer3  = "";
    $buffer3 .= "\nnew inner2\n";
    $blocks["inner2"]  = (isset($blocks["inner2"]) == TRUE ? (strpos($blocks["inner2"], "{{block.1b3231655cebb7a1f783eddf27d254ca}}") === FALSE ? $blocks["inner2"] : str_replace("{{block.1b3231655cebb7a1f783eddf27d254ca}}", $buffer3, $blocks["inner2"])) : $buffer3);
    $buffer2 .= $blocks["inner2"]."\n";
    $blocks["outer"]  = (isset($blocks["outer"]) == TRUE ? (strpos($blocks["outer"], "{{block.1b3231655cebb7a1f783eddf27d254ca}}") === FALSE ? $blocks["outer"] : str_replace("{{block.1b3231655cebb7a1f783eddf27d254ca}}", $buffer2, $blocks["outer"])) : $buffer2);
    $buffer1 .= Haanga::Load("assert_templates/nested_block.tpl", $vars, TRUE, $blocks);
    if ($return == TRUE) {
        return $buffer1;
    } else {
        echo $buffer1;
    }
}