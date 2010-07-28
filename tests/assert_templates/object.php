<?php

$obj->name = 'foo';
$obj->obj->name = 'bar';

$data = compact('obj');
