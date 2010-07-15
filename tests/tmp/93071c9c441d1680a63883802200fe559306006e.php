<?php
/* Generated from ./assert_templates/nested_block_second_parent.tpl */
function haanga_93071c9c441d1680a63883802200fe559306006e($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    $buffer1  = "";
    $buffer2  = "";
    $buffer2 .= "\n    inner2's new value\n    ";
    $buffer3  = "";
    $buffer3 .= "\n        2.1\n    ";
    $blocks["inner2_1"]  = (isset($blocks["inner2_1"]) == TRUE ? (strpos($blocks["inner2_1"], "{{block.1b3231655cebb7a1f783eddf27d254ca}}") === FALSE ? $blocks["inner2_1"] : str_replace("{{block.1b3231655cebb7a1f783eddf27d254ca}}", $buffer3, $blocks["inner2_1"])) : $buffer3);
    $buffer2 .= $blocks["inner2_1"]."\n";
    $blocks["inner2"]  = (isset($blocks["inner2"]) == TRUE ? (strpos($blocks["inner2"], "{{block.1b3231655cebb7a1f783eddf27d254ca}}") === FALSE ? $blocks["inner2"] : str_replace("{{block.1b3231655cebb7a1f783eddf27d254ca}}", $buffer2, $blocks["inner2"])) : $buffer2);
    $buffer1 .= Haanga::Load("assert_templates/nested_block.tpl", $vars, TRUE, $blocks);
    if ($return == TRUE) {
        return $buffer1;
    } else {
        echo $buffer1;
    }
}