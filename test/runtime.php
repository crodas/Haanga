<?php

require "../haanga/runtime.php";

Haanga::setCacheDir('tmp/');
Haanga::setTEmplateDir('./');

$vars = array(
    'some_list' => array(1, 2, 3, 4),
    'user' => 'crodas',
);

Haanga::load('index.html', $vars);
