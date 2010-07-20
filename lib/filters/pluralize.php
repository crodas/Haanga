<?php

class Pluralize_Filter
{
    function generator($compiler, $args)
    {
        if (count($args) > 1) {
            if (!$compiler->is_string($args[1])) {
                throw new Haanga_CompilerException("pluralize: First parameter must be an string");
            }
            $parts    = explode(",", $args[1]['string']);
            $singular = "";
            if (count($parts) == 1) {
                $plural = $parts[0];
            } else {
                $singular = $parts[0];
                $plural   = $parts[1];
            }
        } else {
            $singular = "";
            $plural   = "s";
        }

        return hexpr_cond(hexpr($args[0], '<=', 1), $singular, $plural);
    }
}
