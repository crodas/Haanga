<?php
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/subtemplate.tpl */
function haanga_b38c184f42191295c5b3ed7fc48f68e1bea8e63a($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    $buffer1  = "My Title - {{block.1b3231655cebb7a1f783eddf27d254ca}}";
    $blocks["title"]  = (isset($blocks["title"]) ? (strpos($blocks["title"], "{{block.1b3231655cebb7a1f783eddf27d254ca}}") === FALSE ? $blocks["title"] : str_replace("{{block.1b3231655cebb7a1f783eddf27d254ca}}", $buffer1, $blocks["title"])) : $buffer1);
    $buffer1  = "\n    {{block.1b3231655cebb7a1f783eddf27d254ca}}\n\n    :-)\n";
    $blocks["main.menu"]  = (isset($blocks["main.menu"]) ? (strpos($blocks["main.menu"], "{{block.1b3231655cebb7a1f783eddf27d254ca}}") === FALSE ? $blocks["main.menu"] : str_replace("{{block.1b3231655cebb7a1f783eddf27d254ca}}", $buffer1, $blocks["main.menu"])) : $buffer1);
    echo Haanga::Load("assert_templates/base.tpl", $vars, TRUE, $blocks);
    if ($return == TRUE) {
        return ob_get_clean();
    }
}