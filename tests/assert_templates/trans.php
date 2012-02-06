<?php
$data = array('text' => 'hello');

if (!is_callable('bindtextdomain')) {
    throw new Exception('no gettext enabled');
}


bindtextdomain("messages", dirname(__FILE__)."/locale");
bind_textdomain_codeset("messages", "UTF-8");
textdomain("messages");

$locale='es_ES.UTF-8';
putenv("LC_ALL=$locale");

setlocale(LC_ALL, $locale);
