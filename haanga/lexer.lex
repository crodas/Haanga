<?php

require dirname(__FILE__)."/parser.php";

function do_parsing($template)
{
    $a = new Haanga_Lexer($template);
    $parser = new Parser;
    try {
        for($i=0; ; $i++) {
            if  (!$a->yylex()) {
                break;
            }
            $parser->doParse($a->token, $a->value);
        }
    } catch (Exception $e) {
        throw new Exception($e->getMessage(). ' on line '.$a->getLine());
    }
    $parser->doParse(0, 0);
    return $parser->body;
}

class Haanga_Lexer
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

    function getLine()
    {
        return $this->line;
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
whitespace      = /[ \r\t\n]+/
html            = /([^{]+(.[^%{#])?)+/
comment         = /([^\#]+\#\})+/
custom_tag_end  = /end([a-zA-Z][a-zA-Z0-9]*)/
token_end       = /[^a-zA-Z0-9]/
single_string   = /[^'\\]+/
double_string   = /[^"\\]+/
*/
/*!lex2php
%statename IN_HTML
"{%" {
    $this->token = Parser::T_OPEN_TAG;
    $this->yypushstate(self::IN_CODE);
}

"{#" {
    $this->token = Parser::T_COMMENT_OPEN;
    $this->yypushstate(self::IN_COMMENT);
}


"{{" {
    $this->token = Parser::T_PRINT_OPEN;
    $this->yypushstate(self::IN_PRINT);
}

whitespace {
    $this->token = Parser::T_HTML;
}

html {
    $this->token = Parser::T_HTML;
}

*/
/*!lex2php
%statename IN_CODE
"%}" {
    $this->token = Parser::T_CLOSE_TAG;
    $this->yypopstate();
}

"." {
    $this->token = Parser::T_DOT;
}

"for" token_end {
    $this->token = Parser::T_FOR;
}

"empty" token_end {
    $this->token = Parser::T_EMPTY;
}

"cycle" token_end {
    $this->token = Parser::T_CYCLE;
}

"block" token_end {
    $this->token = Parser::T_BLOCK;
}

"|" {
    $this->token = Parser::T_PIPE;
}

"filter" token_end {
    $this->token = Parser::T_FILTER;
}

"endfilter" token_end {
    $this->token = Parser::T_END_FILTER;
}


"endblock" token_end {
    $this->token = Parser::T_END_BLOCK;
}

"ifchanged" token_end {
    $this->token = Parser::T_IFCHANGED;
}

"else" token_end {
    $this->token = Parser::T_ELSE;
}

"endifchanged" token_end {
    $this->token = Parser::T_ENDIFCHANGED;
}


"in" token_end {
    $this->token = Parser::T_IN;
}

"endfor" token_end {
    $this->token = Parser::T_CLOSEFOR;
}

"if" token_end {
    $this->token = Parser::T_IF;
} 

"else" token_end {
    $this->token = Parser::T_ELSE;
}

"endif" token_end {
    $this->token = Parser::T_ENDIF;
}

"(" {
    $this->token = Parser::T_LPARENT;
}

")" {
    $this->token = Parser::T_RPARENT;
}

"%" {
    $this->token = Parser::T_MOD;
}

"&&" { 
    $this->token = Parser::T_AND;
}

"==" {
    $this->token = Parser::T_EQ;
}

"!=" {
    $this->token = Parser::T_NE;
}

"+" {
    $this->token = Parser::T_PLUS;
}

"*" {
    $this->token = Parser::T_TIMES;
}

"/" {
    $this->token = Parser::T_DIV;
}

"'" {
    $this->token = Parser::T_STRING_SINGLE_INIT;
    $this->yypushstate(self::IN_STRING_SINGLE);
}

"\"" {
    $this->token = Parser::T_STRING_DOUBLE_INIT;
    $this->yypushstate(self::IN_STRING_DOUBLE);
}

custom_tag_end {
    $this->token = Parser::T_CUSTOM_END;
}

"extends" token_end {
    $this->token = Parser::T_EXTENDS;
}

numerals {
    $this->token = Parser::T_NUMERIC;
}

numerals "."  numerals {
    $this->token = Parser::T_NUMERIC;
}

alpha {
    $this->token = Parser::T_ALPHA;
}

whitespace {
    return FALSE;
}

*/
/*!lex2php
%statename IN_PRINT
"}}" {
    $this->token = Parser::T_PRINT_CLOSE;
    $this->yypopstate();
}

"|" {
    $this->token = Parser::T_PIPE;
}

"." {
    $this->token = Parser::T_DOT;
}

alpha {
    $this->token = Parser::T_ALPHA;
}

whitespace {
    return FALSE;
}
*/

/*!lex2php
%statename IN_STRING_DOUBLE

"\\" "\""  {
    $this->token = Parser::T_STRING_CONTENT;
    $this->value = "\"";
    $this->N    += 1;
}

"\'"  {
    $this->token = Parser::T_STRING_CONTENT;
    $this->value = "'";
    $this->N    += 1;
}


"\"" {
    $this->token = Parser::T_STRING_DOUBLE_END;
    $this->yypopstate();
}

double_string {
    $this->token = Parser::T_STRING_CONTENT;
}

*/

/*!lex2php
%statename IN_STRING_SINGLE
"\'"  {
    $this->token = Parser::T_STRING_CONTENT;
    $this->value = "'";
    $this->N    += 1;
}

"\\" "\""  {
    $this->token = Parser::T_STRING_CONTENT;
    $this->value = "\"";
    $this->N    += 1;
}


"'" {
    $this->token = Parser::T_STRING_SINGLE_END;
    $this->yypopstate();
}

single_string {
    $this->token = Parser::T_STRING_CONTENT;
}

*/

/*!lex2php
%statename IN_COMMENT
comment {
    $this->token = Parser::T_COMMENT;
    $this->yypopstate();
}
*/
}
