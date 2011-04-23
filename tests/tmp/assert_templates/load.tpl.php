<?php
$HAANGA_VERSION  = '1.0.4';
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/load.tpl */
function haanga_8d56a9a504af63b0aa1f9e966ad860de9c65c99b($vars, $return=FALSE, $blocks=array())
{
    global $test_global, $global1;
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    echo '
';
    $mnm_current  = $page;
    $mnm_total  = ceil(($total / $results_per_page));
    $mnm_start  = max(($mnm_current - intval((5 / 2))), 1);
    $mnm_end  = ($mnm_start + 5 - 1);
    $mnm_prev  = (1 == $mnm_current ? FALSE : ($mnm_current - 1));
    $mnm_next  = ($total < 0 || $mnm_current < $mnm_total ? ($mnm_current + 1) : FALSE);
    $mnm_pages  = range($mnm_start, ($mnm_end < $mnm_total ? $mnm_end : $mnm_total));
    echo '
';
    if (empty($mnm_prev) === FALSE) {
        echo '
    <span class="nextprev">&#171; Previous</span>
';
    } else {
        echo '
    <a href="?page'.htmlspecialchars($mnm_prev).'">&#171; Previous</a>
';
    }
    echo '

';
    if ($mnm_start > 1) {
        echo '
    <a href="?page=1">1</a>\';
    <span>...</span>
';
    }
    echo '

';
    foreach ($mnm_pages as  $page) {
        echo '
    ';
        if ($mnm_current == $page) {
            echo '
        <span class="current">'.htmlspecialchars($page).'</span>
    ';
        } else {
            echo '
        <a href="?page='.htmlspecialchars($page).'">'.htmlspecialchars($page).'</a>
    ';
        }
        echo '
';
    }
    echo '

';
    if ($mnm_total > $mnm_end) {
        echo '
    <span>...</span>
    <a href="?page='.htmlspecialchars($mnm_total).'">'.htmlspecialchars($mnm_total).'</a>
';
    }
    echo '

';
    if (empty($mnm_next) === FALSE) {
        echo '
    <a href="?page='.htmlspecialchars($mnm_next).'">&#187; Next</a>
';
    } else {
        echo '
    <span class="nextprev">&#187; Next</span>
';
    }
    echo '
';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}