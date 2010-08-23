<?php
$HAANGA_VERSION  = '1.0.3';
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/ifchanged.tpl */
function haanga_be17029b5fd2998df7c922a92652b6886d7780fd($vars, $return=FALSE, $blocks=array())
{
    global $test_global, $global1;
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    $sorted_users  = $users;
    $field  = Array();
    foreach ($sorted_users as  $key => $item) {
        $field[$key]  = $item[$regroup_field];
    }
    array_multisort($field, SORT_REGULAR, $sorted_users);
    echo '
';
    foreach ($sorted_users as  $user) {
        echo '
    ';
        $buffer1  = 'Users with '.htmlspecialchars($user['age']).' years';
        if (isset($ifchanged3) == FALSE || $ifchanged3 != $buffer1) {
            echo $buffer1;
            $ifchanged3  = $buffer1;
        }
        echo '
    '.htmlspecialchars($user['name']).'
';
    }
    echo '

';
    foreach ($sorted_users as  $user) {
        echo '
    ';
        if ((isset($ifchanged4[0]) == FALSE || $ifchanged4[0] != $user['age']) && (isset($ifchanged4[1]) == FALSE || $ifchanged4[1] != $user['foo'])) {
            echo 'Users with '.htmlspecialchars($user['age']).' years';
            $ifchanged4  = Array($user['age'], $user['foo']);
        } else {
            echo 'continue';
        }
        echo '
    '.htmlspecialchars($user['name']).'
';
    }
    echo '
';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}