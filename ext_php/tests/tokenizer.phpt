--TEST--
simple test
--FILE--
<?php

$array = haanga_tokenizer("{{foobar}}{% 
            load 1+299.9 %}
        <h1>cesar</h1>{{'cesar \\'foobar\\'\\n
        
        rodas' }}");
var_dump($array);

--EXPECT--
array(13) {
  [0]=>
  array(3) {
    ["token"]=>
    int(19)
    ["value"]=>
    string(2) "{{"
    ["line"]=>
    int(1)
  }
  [1]=>
  array(3) {
    ["token"]=>
    int(54)
    ["value"]=>
    string(6) "foobar"
    ["line"]=>
    int(1)
  }
  [2]=>
  array(3) {
    ["token"]=>
    int(20)
    ["value"]=>
    string(2) "}}"
    ["line"]=>
    int(1)
  }
  [3]=>
  array(3) {
    ["token"]=>
    int(1)
    ["value"]=>
    string(2) "{%"
    ["line"]=>
    int(1)
  }
  [4]=>
  array(3) {
    ["token"]=>
    int(31)
    ["value"]=>
    string(4) "load"
    ["line"]=>
    int(2)
  }
  [5]=>
  array(3) {
    ["token"]=>
    int(41)
    ["value"]=>
    string(1) "1"
    ["line"]=>
    int(2)
  }
  [6]=>
  array(3) {
    ["token"]=>
    int(12)
    ["value"]=>
    string(1) "+"
    ["line"]=>
    int(2)
  }
  [7]=>
  array(3) {
    ["token"]=>
    int(41)
    ["value"]=>
    string(5) "299.9"
    ["line"]=>
    int(2)
  }
  [8]=>
  array(3) {
    ["token"]=>
    int(22)
    ["value"]=>
    string(2) "%}"
    ["line"]=>
    int(2)
  }
  [9]=>
  array(3) {
    ["token"]=>
    int(17)
    ["value"]=>
    string(23) "
        <h1>cesar</h1>"
    ["line"]=>
    int(3)
  }
  [10]=>
  array(3) {
    ["token"]=>
    int(19)
    ["value"]=>
    string(2) "{{"
    ["line"]=>
    int(3)
  }
  [11]=>
  array(3) {
    ["token"]=>
    int(49)
    ["value"]=>
    string(38) "cesar 'foobar'

        
        rodas"
    ["line"]=>
    int(5)
  }
  [12]=>
  array(3) {
    ["token"]=>
    int(20)
    ["value"]=>
    string(2) "}}"
    ["line"]=>
    int(5)
  }
}
