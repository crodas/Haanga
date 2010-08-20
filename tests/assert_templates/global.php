<?php

$data = array();
$obj  = new Stdclass;
$obj->foo = array('bar' => 'c');

global $test_global, $global1;

$test_global = array('b' => 'string');
$global1     = array('foo' => $obj);
