<?php
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/loop.tpl */
function haanga_4726e18009acee8a1c86a79b620c7ded71be5ddf($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    $psize_1  = count($array);
    $revcount0_1  = $psize_1 - 1;
    foreach ($array as  $i) {
        echo "\n    ".$revcount0_1."\n";
        $revcount0_1  = $revcount0_1 - 1;
    }
    echo "\n\n";
    $psize_1  = count($array);
    $revcount_1  = $psize_1;
    foreach ($array as  $i) {
        echo "\n    ".$revcount_1."\n";
        $revcount_1  = $revcount_1 - 1;
    }
    echo "\n\n";
    $forcounter1_1  = 1;
    $psize_1  = count($array);
    $islast_1  = $forcounter1_1 == $psize_1;
    foreach ($array as  $i) {
        $buffer1  = "\n    ";
        if (empty($islast_1) === FALSE) {
            $buffer1 .= " Last ".htmlentities($i);
        }
        $buffer1 .= "\n\n";
        echo trim($buffer1);
        $forcounter1_1  = $forcounter1_1 + 1;
        $islast_1  = $forcounter1_1 == $psize_1;
    }
    echo "\n\n";
    $forcounter1_1  = 1;
    $psize_1  = count($array_nested);
    $islast_1  = $forcounter1_1 == $psize_1;
    foreach ($array_nested as  $k => $sub) {
        $buffer1  = "\n\n    ";
        foreach ($sub as  $arr) {
            $buffer1 .= "\n        ";
            foreach ($arr as  $val) {
                $buffer1 .= "\n            ";
                if (empty($islast_1) === FALSE) {
                    $buffer1 .= " Last ".htmlentities($k);
                }
                $buffer1 .= "\n        ";
            }
            $buffer1 .= "\n    ";
        }
        $buffer1 .= "\n\n";
        echo trim($buffer1);
        $forcounter1_1  = $forcounter1_1 + 1;
        $islast_1  = $forcounter1_1 == $psize_1;
    }
    echo "\n\n";
    $isfirst_1  = TRUE;
    foreach ($array_nested as  $k => $sub) {
        $buffer1  = "\n\n    ";
        foreach ($sub as  $arr) {
            $buffer1 .= "\n        ";
            foreach ($arr as  $val) {
                $buffer1 .= "\n            ";
                if (empty($isfirst_1) === FALSE) {
                    $buffer1 .= " first ".htmlentities($k);
                }
                $buffer1 .= "\n        ";
            }
            $buffer1 .= "\n    ";
        }
        $buffer1 .= "\n\n";
        echo trim($buffer1);
        $isfirst_1  = FALSE;
    }
    echo "\n";
    if ($return == TRUE) {
        return ob_get_clean();
    }
}