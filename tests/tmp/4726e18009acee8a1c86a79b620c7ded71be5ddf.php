<?php
/* Generated from ./assert_templates/loop.tpl */
function haanga_4726e18009acee8a1c86a79b620c7ded71be5ddf($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    $buffer1  = "";
    $psize_1  = count($array);
    $revcount0_1  = $psize_1 - 1;
    foreach ($array as  $i) {
        $buffer1 .= "\n    ".$revcount0_1."\n";
        $revcount0_1  = $revcount0_1 - 1;
    }
    $buffer1 .= "\n\n";
    $psize_1  = count($array);
    $revcount_1  = $psize_1;
    foreach ($array as  $i) {
        $buffer1 .= "\n    ".$revcount_1."\n";
        $revcount_1  = $revcount_1 - 1;
    }
    $buffer1 .= "\n\n";
    $forcounter1_1  = 1;
    $psize_1  = count($array);
    $islast_1  = $forcounter1_1 == $psize_1;
    foreach ($array as  $i) {
        $buffer2  = "\n    ";
        if (empty($islast_1) === FALSE) {
            $buffer2 .= " Last ".htmlentities($i);
        }
        $buffer2 .= "\n\n";
        $buffer1 .= trim($buffer2);
        $forcounter1_1  = $forcounter1_1 + 1;
        $islast_1  = $forcounter1_1 == $psize_1;
    }
    $buffer1 .= "\n\n";
    $forcounter1_1  = 1;
    $psize_1  = count($array_nested);
    $islast_1  = $forcounter1_1 == $psize_1;
    foreach ($array_nested as  $k => $sub) {
        $buffer2  = "\n\n    ";
        foreach ($sub as  $arr) {
            $buffer2 .= "\n        ";
            foreach ($arr as  $val) {
                $buffer2 .= "\n            ";
                if (empty($islast_1) === FALSE) {
                    $buffer2 .= " Last ".htmlentities($k);
                }
                $buffer2 .= "\n        ";
            }
            $buffer2 .= "\n    ";
        }
        $buffer2 .= "\n\n";
        $buffer1 .= trim($buffer2);
        $forcounter1_1  = $forcounter1_1 + 1;
        $islast_1  = $forcounter1_1 == $psize_1;
    }
    $buffer1 .= "\n\n";
    $isfirst_1  = TRUE;
    foreach ($array_nested as  $k => $sub) {
        $buffer2  = "\n\n    ";
        foreach ($sub as  $arr) {
            $buffer2 .= "\n        ";
            foreach ($arr as  $val) {
                $buffer2 .= "\n            ";
                if (empty($isfirst_1) === FALSE) {
                    $buffer2 .= " first ".htmlentities($k);
                }
                $buffer2 .= "\n        ";
            }
            $buffer2 .= "\n    ";
        }
        $buffer2 .= "\n\n";
        $buffer1 .= trim($buffer2);
        $isfirst_1  = FALSE;
    }
    $buffer1 .= "\n";
    if ($return == TRUE) {
        return $buffer1;
    } else {
        print($buffer1);
    }
}