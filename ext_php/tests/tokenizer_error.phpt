--TEST--
simple test
--FILE--
<?php

$array = haanga_tokenizer("{{'cesar }}");

--EXPECT--
Fatal error: Uncaught exception 'Exception' with message 'Invalid string at line 1' in /home/crodas/projects/playground/haanga/ext_php/tests/tokenizer_error.php:3
Stack trace:
#0 /home/crodas/projects/playground/haanga/ext_php/tests/tokenizer_error.php(3): haanga_tokenizer('{{'cesar }}')
#1 {main}
  thrown in /home/crodas/projects/playground/haanga/ext_php/tests/tokenizer_error.php on line 3
