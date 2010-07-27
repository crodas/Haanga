<?php
$data = array('text' => 'hello');

if (!is_callable('bindtextdomain')) {
    throw new Exception('no gettext enabled');
}

$locale='es_ES.UTF-8';
putenv("LC_ALL=$locale");
setlocale(LC_ALL, $locale);

bindtextdomain("messages", dirname(__FILE__)."/locale");
textdomain("messages");
