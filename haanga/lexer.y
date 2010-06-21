<?php
class TestLexer
{
    private $data;
    private $N;
    public $token;
    public $value;
    private $line;
    private $state = 1;

    function __construct($data)
    {
        $this->data = $data;
        $this->N = 0;
        $this->line = 1;
    }

/*!lex2php
%input      $this->data
%counter    $this->N
%token      $this->token
%value      $this->value
%line       $this->line
alpha = /([a-zA-Z_0-9]+)/
anything = /.+/
number = /[0-9]/
numerals = /([0-9])+/
whitespace = /[ \t\n]+/
*/
/*!lex2php
%statename IN_HTML
"{%" {
    $this->yypushstate(self::IN_CODE);
}

"{{" {
    $this->yypushstate(self::IN_PRINT);
}

anything {
   var_dump('here'); 
}
    
*/
/*!lex2php
%statename IN_CODE
"%}" {
    $this->yypopstate();
}

"for" {
}

"in" {
}

"endfor" {
    
}

alpha {
}

whitespace {
    return FALSE;
}

*/
/*!lex2php
%statename IN_PRINT
"}}" {
    $this->yypopstate();
}


alpha {
    
}

whitespace {
    return FALSE;
}
*/
}

$a = new TestLexer(file_get_contents('../template.tpl'));
$a->yylex();
var_dump('advance: ' . $a->value);
$a->yylex();
var_dump('advance: ' . $a->value);
$a->yylex();
var_dump('advance: ' . $a->value);
$a->yylex();
var_dump('advance: ' . $a->value);
$a->yylex();
var_dump('advance: ' . $a->value);
$a->yylex();
var_dump('advance: ' . $a->value);
$a->yylex();
var_dump('advance: ' . $a->value);
$a->yylex();
var_dump('advance: ' . $a->value);
$a->yylex();
var_dump('advance: ' . $a->value);
