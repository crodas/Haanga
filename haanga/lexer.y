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
%input          $this->data
%counter        $this->N
%token          $this->token
%value          $this->value
%line           $this->line
alpha           = /([a-zA-Z_][a-zA-Z_0-9]*)/
number          = /[0-9]/
numerals        = /([0-9])+/
whitespace      = /[ \t\n]+/
single_string   = /'[^']+'/
double_string   = /"[^"]+"/
anything        = Z([^{{|{%]+)Z
*/
/*!lex2php
%statename IN_HTML
"{%" {
    $this->yypushstate(self::IN_CODE);
}

"{{" {
    $this->yypushstate(self::IN_PRINT);
}

whitespace {
    return FALSE;
}

anything {
    $this->token = Parser::T_HTML;
}
    
*/
/*!lex2php
%statename IN_CODE
"%}" {
    $this->yypopstate();
}

"for" {
    $this->token = Parser::T_FOR;
}

"cycle" {
    $this->token = Parser::T_CYCLE;
}

"in" {
    $this->token = Parser::T_IN;
}

"endfor" {
    $this->token = Parser::T_ENDFOR;
}

alpha {
    $this->token = Parser::T_ALPHA;
}

single_string {
    $this->token = Parser::T_STRING;
}

double_string {
    $this->token = Parser::T_STRING;
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

require "parser.php";
$a = new TestLexer(file_get_contents('../template.tpl'));
for($i=0; $i < 20; $i++) {
    if  (!$a->yylex()) {
        break;
    }
    var_dump('advance: ' . $a->value);
}

