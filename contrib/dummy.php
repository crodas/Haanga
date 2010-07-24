<?php

Class Dummy_Tag
{
    public $is_block = TRUE;

    function main($html)
    {
        return strtolower($html);
    }
}
