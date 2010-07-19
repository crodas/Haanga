<?php

class Meneame_Pagination_Tag
{
    public $is_block = FALSE;

    function generator($cmp, $args, $redirected)
    {
        if (count($args) != 3 && count($args) != 4) {
            throw new Haanga_CompilerException("Memeame_Pagination requires 3 parameters");
        }
        if (count($args) == 3) {
            $args[3] = $cmp->expr_number(5);
        }
        $one   = $cmp->expr_number(1);
        $out   = array();
        $out[] = $cmp->op_declare('mnm_total', $cmp->expr_exec('ceil', $cmp->expr('/', $args[2], $args[1]))); 
        $out[] = $cmp->op_declare('mnm_start', $cmp->expr_exec('max', $cmp->expr('-', $args[0], $cmp->expr_exec('intval', $args[3])), $one));
        $out[] = $cmp->op_declare('mnm_end', $cmp->expr('+', $cmp->expr_var('mnm_start'), $cmp->expr('-', $args[3], $one)));

        return new ArrayIterator($out);
    }

}
