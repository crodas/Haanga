<?php
/* Generated from ./assert_templates/load.tpl */
function haanga_8d56a9a504af63b0aa1f9e966ad860de9c65c99b($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    $buffer1  = "\n";
    $mnm_current  = $page;
    $mnm_total  = ceil($total / $results_per_page);
    $mnm_start  = max($mnm_current - intval(5 / 2), 1);
    $mnm_end  = $mnm_start + 5 - 1;
    $mnm_prev  = (1 == $mnm_current ? FALSE : $mnm_current - 1);
    $mnm_next  = ($total < 0 || $mnm_current < $mnm_total ? $mnm_current + 1 : FALSE);
    $mnm_pages  = range($mnm_start, ($mnm_end < $mnm_total ? $mnm_end : $mnm_total));
    $buffer1 .= "\n";
    if (empty($mnm_prev) === FALSE) {
        $buffer1 .= "\n    <span class=\"nextprev\">&#171; Previous</span>\n";
    } else {
        $buffer1 .= "\n    <a href=\"?page".htmlentities($mnm_prev)."\">&#171; Previous</a>\n";
    }
    $buffer1 .= "\n\n";
    if ($mnm_start > 1) {
        $buffer1 .= "\n    <a href=\"?page=1\">1</a>';\n    <span>...</span>\n";
    }
    $buffer1 .= "\n\n";
    foreach ($mnm_pages as  $page) {
        $buffer1 .= "\n    ";
        if ($mnm_current == $page) {
            $buffer1 .= "\n        <span class=\"current\">".htmlentities($page)."</span>\n    ";
        } else {
            $buffer1 .= "\n        <a href=\"?page=".htmlentities($page)."\">".htmlentities($page)."</a>\n    ";
        }
        $buffer1 .= "\n";
    }
    $buffer1 .= "\n\n";
    if ($mnm_total > $mnm_end) {
        $buffer1 .= "\n    <span>...</span>\n    <a href=\"?page=".htmlentities($mnm_total)."\">".htmlentities($mnm_total)."</a>\n";
    }
    $buffer1 .= "\n\n";
    if (empty($mnm_next) === FALSE) {
        $buffer1 .= "\n    <a href=\"?page=".htmlentities($mnm_next)."\">&#187; Next</a>\n";
    } else {
        $buffer1 .= "\n    <span class=\"nextprev\">&#187; Next</span>\n";
    }
    $buffer1 .= "\n";
    if ($return == TRUE) {
        return $buffer1;
    } else {
        print($buffer1);
    }
}