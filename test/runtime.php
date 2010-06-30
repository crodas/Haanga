<?php

require "../haanga/runtime.php";

Haanga::setCacheDir('tmp/');
Haanga::setTEmplateDir('./');

$vars = array(
    'some_list' => array(1, 2, 3, 4, 4, 4, 5),
    'user' => 'crodas',
    'base_template' => 'subtemplate.html',
);

Haanga::load('index.html', $vars);
