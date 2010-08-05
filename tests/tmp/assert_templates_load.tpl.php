<?php
/* Generated from ./assert_templates/load.tpl */
function haanga_8d56a9a504af63b0aa1f9e966ad860de9c65c99b($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    echo "\n";
    $mnm_current  = $page;
    $mnm_total  = ceil($total / $results_per_page);
    $mnm_start  = max($mnm_current - intval(5 / 2), 1);
    $mnm_end  = $mnm_start + 5 - 1;
    $mnm_prev  = (1 == $mnm_current ? FALSE : $mnm_current - 1);
    $mnm_next  = ($total < 0 || $mnm_current < $mnm_total ? $mnm_current + 1 : FALSE);
    $mnm_pages  = range($mnm_start, ($mnm_end < $mnm_total ? $mnm_end : $mnm_total));
    echo "\n";
    if (empty($mnm_prev) === FALSE) {
        echo "\n    <span class=\"nextprev\">&#171; Previous</span>\n";
    } else {
        echo "\n    <a href=\"?page".htmlentities($mnm_prev)."\">&#171; Previous</a>\n";
    }
    echo "\n\n";
    if ($mnm_start > 1) {
        echo "\n    <a href=\"?page=1\">1</a>';\n    <span>...</span>\n";
    }
    echo "\n\n";
    foreach ($mnm_pages as  $page) {
        echo "\n    ";
        if ($mnm_current == $page) {
            echo "\n        <span class=\"current\">".htmlentities($page)."</span>\n    ";
        } else {
            echo "\n        <a href=\"?page=".htmlentities($page)."\">".htmlentities($page)."</a>\n    ";
        }
        echo "\n";
    }
    echo "\n\n";
    if ($mnm_total > $mnm_end) {
        echo "\n    <span>...</span>\n    <a href=\"?page=".htmlentities($mnm_total)."\">".htmlentities($mnm_total)."</a>\n";
    }
    echo "\n\n";
    if (empty($mnm_next) === FALSE) {
        echo "\n    <a href=\"?page=".htmlentities($mnm_next)."\">&#187; Next</a>\n";
    } else {
        echo "\n    <span class=\"nextprev\">&#187; Next</span>\n";
    }
    echo "\n";
    if ($return == TRUE) {
        return ob_get_clean();
    }
}