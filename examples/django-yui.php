<?php

require "../lib/runtime.php";

Haanga::setCacheDir('tmp/');
Haanga::setTEmplateDir('django-yui-layout-templates/');

$files = array();
foreach (glob("django-yui-layout-templates/*") as $html) {
    if (is_file($html)) {
        $files[] = basename($html);
    }
}

$blocks = array(
    '1' => 'Content on div 1',
    '2' => 'Content on div 2',
    '3' => 'Content on div 3',
    '4' => 'Content on div 4',
    'title' => $_GET['layout']." template",
);

$debug = TRUE;
$sql_queries = array(
    array('sql' => 'select * from foobar', 'time' => '1'),
    array('sql' => 'select * from php', 'time' => '1'),
);

$time = microtime(TRUE);
$mem = memory_get_usage();
Haanga::Load($_GET['layout'], compact('debug', 'files', 'sql_queries'), FALSE, $blocks);
var_dump(array(
 'memory (mb)' => (memory_get_usage()-$mem)/(1024*1024), 
 'time' => microtime(TRUE)-$time
 ));
