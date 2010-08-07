<?php
/* Load tag dummy definition */
require_once("/home/crodas/projects/playground/haanga/contrib/dummy.php");
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/dummy.tpl */
function haanga_e4a8e6ccc0848675d501c0030846156150bb3058($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    echo "\n";
    $buffer1  = "\n    testing DUMMY TaG\n";
    echo Haanga_Extension_Tag_Dummy::main($buffer1)."\n";
    if ($return == TRUE) {
        return ob_get_clean();
    }
}