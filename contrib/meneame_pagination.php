<?php

class Meneame_Pagination_Tag
{
    public $is_block = FALSE;

    function generator($cmp, $args, $redirected)
    {
        if (count($args) != 3 && count($args) != 4) {
            throw new Haanga_CompilerException("Memeame_Pagination requires 3 or 4 parameters");
        }
        if (count($args) == 3) {
            $args[3] = $cmp->expr_number(5);
        }

        $current = $cmp->expr_var('mnm_current');
        $total   = $cmp->expr_var('mnm_total');
        $start   = $cmp->expr_var('mnm_start');
        $end     = $cmp->expr_var('mnm_end');
        $next    = $cmp->expr_var('mnm_next');
        $prev    = $cmp->expr_var('mnm_prev');
        $pages   = $cmp->expr_var('mnm_pages');
        $zero    = $cmp->expr_number(0);
        $one     = $cmp->expr_number(1);
        $two     = $cmp->expr_number(2);
        $false   = $cmp->expr_FALSE();

        $cmp->set_safe($current);
        $cmp->set_safe($total);
        $cmp->set_safe($prev);
        $cmp->set_safe($next);
        $cmp->set_safe($pages);
        

        $code   = array();
        $code[] = $cmp->op_declare($current, $args[0]);
        $code[] = $cmp->op_declare($total, $cmp->expr_exec('ceil', $cmp->expr('/', $args[2], $args[1]))); 
        $code[] = $cmp->op_declare($start, $cmp->expr_exec('max', $cmp->expr('-', $current, $cmp->expr_exec('intval', $cmp->expr('/',$args[3], $two))), $one));
        $code[] = $cmp->op_declare($end, $cmp->expr('+', $start, $cmp->expr('-', $args[3], $one)));
        $code[] = $cmp->op_declare($prev, $cmp->expr_cond($cmp->expr('==', $one, $current), $false, $cmp->expr('-', $current, $one)));
        $code[] = $cmp->op_declare($next, $cmp->expr_cond(
            $cmp->expr('||', $cmp->expr('<', $args[2], $zero), $cmp->expr('<', $current, $total)),
            $cmp->expr('+', $current, $one),
            $false));

        $code[] = $cmp->op_declare($pages, $cmp->expr_exec('range', $start, $cmp->expr_cond($cmp->expr('<', $end, $total), $end, $total)));

        return new ArrayIterator($code);
    }

}
