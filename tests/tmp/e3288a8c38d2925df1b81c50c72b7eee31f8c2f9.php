<?php
/* Load filter dictsort definition */
require_once("/home/crodas/projects/playground/haanga/lib/Haanga/Extension/Filter/Dictsort.php");
/* Generated from ./assert_templates/regroup.tpl */
function haanga_e3288a8c38d2925df1b81c50c72b7eee31f8c2f9($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    $buffer1  = "";
    /*  Test regroup with filters, and without filters  */
    $buffer1 .= "\n";
    /* Temporary sorting */
    $sorted_users  = Haanga_Extension_Filter_Dictsort::main($users, $regroup_by);
    $temp_group  = Array();
    foreach ($sorted_users as  $item) {
        $temp_group[$item["age"]][]  = $item;
    }
    /* Proper format */
    $sorted_users  = Array();
    foreach ($temp_group as  $group => $item) {
        $sorted_users[]  = Array("grouper" => $group, "list" => $item);
    }
    /* Sorting done */
    $buffer1 .= "\n";
    $t_users  = $users;
    $field  = Array();
    foreach ($t_users as  $key => $item) {
        $field[$key]  = $item[$regroup_by];
    }
    array_multisort($field, SORT_REGULAR, $t_users);
    $buffer1 .= "\n";
    /* Temporary sorting */
    $temp_group  = Array();
    foreach ($t_users as  $item) {
        $temp_group[$item["age"]][]  = $item;
    }
    /* Proper format */
    $sorted_users1  = Array();
    foreach ($temp_group as  $group => $item) {
        $sorted_users1[]  = Array("grouper" => $group, "list" => $item);
    }
    /* Sorting done */
    $buffer1 .= "\n\n";
    if ($sorted_users != $sorted_users1) {
        $buffer1 .= "\n    Error\n";
    }
    $buffer1 .= "\n\n";
    $forcounter1_1  = 1;
    foreach ($sorted_users as  $user) {
        $buffer1 .= "\n    ".htmlentities($user["grouper"])."\n    ";
        $forcounter1_2  = 1;
        $psize_2  = count($user["list"]);
        $islast_2  = $forcounter1_2 == $psize_2;
        $isfirst_2  = TRUE;
        $revcount_2  = $psize_2;
        $revcount0_2  = $psize_2 - 1;
        foreach ($user["list"] as  $u) {
            $buffer1 .= "\n        ".$forcounter1_2."-".$revcount_2."-".$revcount0_2." (".$forcounter1_1."). ".htmlentities(ucfirst($u["name"]))." (";
            if ((empty($isfirst_2) == TRUE ? "" : $isfirst_2)) {
                $buffer1 .= "first";
            } else {
                if ((empty($islast_2) == TRUE ? "" : $islast_2)) {
                    $buffer1 .= "last";
                }
            }
            $buffer1 .= ")\n    ";
            $forcounter1_2  = $forcounter1_2 + 1;
            $islast_2  = $forcounter1_2 == $psize_2;
            $isfirst_2  = FALSE;
            $revcount_2  = $revcount_2 - 1;
            $revcount0_2  = $revcount0_2 - 1;
        }
        $buffer1 .= "\n";
        $forcounter1_1  = $forcounter1_1 + 1;
    }
    $buffer1 .= "\n";
    if ($return == TRUE) {
        return $buffer1;
    } else {
        print($buffer1);
    }
}