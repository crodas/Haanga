<?php
$HAANGA_VERSION  = '1.0.4';
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/loop.tpl */
function haanga_4726e18009acee8a1c86a79b620c7ded71be5ddf($vars, $return=FALSE, $blocks=array())
{
    global $test_global, $global1;
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    $psize_1  = count($array);
    $revcount0_1  = ($psize_1 - 1);
    foreach ($array as  $i) {
        echo '
    '.$revcount0_1.'
';
        $revcount0_1  = ($revcount0_1 - 1);
    }
    echo '

';
    $psize_1  = count($array);
    $revcount_1  = $psize_1;
    foreach ($array as  $i) {
        echo '
    '.$revcount_1.'
';
        $revcount_1  = ($revcount_1 - 1);
    }
    echo '

';
    $forcounter1_1  = 1;
    $psize_1  = count($array);
    $islast_1  = ($forcounter1_1 == $psize_1);
    foreach ($array as  $i) {
        $buffer1  = '
    ';
        if (empty($islast_1) === FALSE) {
            $buffer1 .= ' Last '.htmlspecialchars($i);
        }
        $buffer1 .= '

';
        echo trim($buffer1);
        $forcounter1_1  = ($forcounter1_1 + 1);
        $islast_1  = ($forcounter1_1 == $psize_1);
    }
    echo '

';
    $forcounter1_1  = 1;
    $psize_1  = count($array_nested);
    $islast_1  = ($forcounter1_1 == $psize_1);
    foreach ($array_nested as  $k => $sub) {
        $buffer1  = '

    ';
        foreach ($sub as  $arr) {
            $buffer1 .= '
        ';
            foreach ($arr as  $val) {
                $buffer1 .= '
            ';
                if (empty($islast_1) === FALSE) {
                    $buffer1 .= ' Last '.htmlspecialchars($k);
                }
                $buffer1 .= '
        ';
            }
            $buffer1 .= '
    ';
        }
        $buffer1 .= '

';
        echo trim($buffer1);
        $forcounter1_1  = ($forcounter1_1 + 1);
        $islast_1  = ($forcounter1_1 == $psize_1);
    }
    echo '

';
    $isfirst_1  = TRUE;
    foreach ($array_nested as  $k => $sub) {
        $buffer1  = '

    ';
        foreach ($sub as  $arr) {
            $buffer1 .= '
        ';
            foreach ($arr as  $val) {
                $buffer1 .= '
            ';
                if (empty($isfirst_1) === FALSE) {
                    $buffer1 .= ' first '.htmlspecialchars($k);
                }
                $buffer1 .= '
        ';
            }
            $buffer1 .= '
    ';
        }
        $buffer1 .= '

';
        echo trim($buffer1);
        $isfirst_1  = FALSE;
    }
    echo '
';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}