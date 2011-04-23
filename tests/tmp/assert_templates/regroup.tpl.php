<?php
/* Load filter dictsort definition */
require_once('/home/crodas/projects/playground/haanga/lib/Haanga/Extension/Filter/Dictsort.php');
$HAANGA_VERSION  = '1.0.4';
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/regroup.tpl */
function haanga_e3288a8c38d2925df1b81c50c72b7eee31f8c2f9($vars, $return=FALSE, $blocks=array())
{
    global $test_global, $global1;
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    echo '
';
    /* Temporary sorting */
    $sorted_users  = Haanga_Extension_Filter_Dictsort::main($users, $regroup_by);
    $temp_group  = Array();
    foreach ($sorted_users as  $item) {
        $temp_group[$item['age']][]  = $item;
    }
    /* Proper format */
    $sorted_users  = Array();
    foreach ($temp_group as  $group => $item) {
        $sorted_users[]  = Array('grouper' => $group, 'list' => $item);
    }
    /* Sorting done */
    echo '
';
    $t_users  = $users;
    $field  = Array();
    foreach ($t_users as  $key => $item) {
        $field[$key]  = $item[$regroup_by];
    }
    array_multisort($field, SORT_REGULAR, $t_users);
    echo '
';
    /* Temporary sorting */
    $temp_group  = Array();
    foreach ($t_users as  $item) {
        $temp_group[$item['age']][]  = $item;
    }
    /* Proper format */
    $sorted_users1  = Array();
    foreach ($temp_group as  $group => $item) {
        $sorted_users1[]  = Array('grouper' => $group, 'list' => $item);
    }
    /* Sorting done */
    echo '

';
    if ($sorted_users != $sorted_users1) {
        echo '
    Error
';
    }
    echo '

';
    $forcounter1_1  = 1;
    foreach ($sorted_users as  $user) {
        echo '
    '.htmlspecialchars($user['grouper']).'
    ';
        $forcounter1_2  = 1;
        $psize_2  = count($user['list']);
        $islast_2  = ($forcounter1_2 == $psize_2);
        $isfirst_2  = TRUE;
        $revcount_2  = $psize_2;
        $revcount0_2  = ($psize_2 - 1);
        foreach ($user['list'] as  $u) {
            echo '
        '.$forcounter1_2.'-'.$revcount_2.'-'.$revcount0_2.' ('.$forcounter1_1.'). '.htmlspecialchars(ucfirst($u['name'])).' (';
            if (empty($isfirst_2) === FALSE) {
                echo 'first';
            } else {
                if (empty($islast_2) === FALSE) {
                    echo 'last';
                }
            }
            echo ')
    ';
            $forcounter1_2  = ($forcounter1_2 + 1);
            $islast_2  = ($forcounter1_2 == $psize_2);
            $isfirst_2  = FALSE;
            $revcount_2  = ($revcount_2 - 1);
            $revcount0_2  = ($revcount0_2 - 1);
        }
        echo '
';
        $forcounter1_1  = ($forcounter1_1 + 1);
    }
    echo '
';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}