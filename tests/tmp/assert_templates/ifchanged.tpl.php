<?php
$HAANGA_VERSION  = '1.0.4';
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
        if (isset($ifchanged1) == FALSE || $ifchanged1 != $buffer1) {
            echo $buffer1;
            $ifchanged1  = $buffer1;
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
        if ((isset($ifchanged2[0]) == FALSE || $ifchanged2[0] != $user['age']) && (isset($ifchanged2[1]) == FALSE || $ifchanged2[1] != $user['foo'])) {
            echo 'Users with '.htmlspecialchars($user['age']).' years';
            $ifchanged2  = Array($user['age'], $user['foo']);
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