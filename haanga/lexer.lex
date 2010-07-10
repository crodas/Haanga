<?php
/*
  +---------------------------------------------------------------------------------+
  | Copyright (c) 2010 Haanga                                                       |
  +---------------------------------------------------------------------------------+
  | Redistribution and use in source and binary forms, with or without              |
  | modification, are permitted provided that the following conditions are met:     |
  | 1. Redistributions of source code must retain the above copyright               |
  |    notice, this list of conditions and the following disclaimer.                |
  |                                                                                 |
  | 2. Redistributions in binary form must reproduce the above copyright            |
  |    notice, this list of conditions and the following disclaimer in the          |
  |    documentation and/or other materials provided with the distribution.         |
  |                                                                                 |
  | 3. All advertising materials mentioning features or use of this software        |
  |    must display the following acknowledgement:                                  |
  |    This product includes software developed by César D. Rodas.                  |
  |                                                                                 |
  | 4. Neither the name of the César D. Rodas nor the                               |
  |    names of its contributors may be used to endorse or promote products         |
  |    derived from this software without specific prior written permission.        |
  |                                                                                 |
  | THIS SOFTWARE IS PROVIDED BY CÉSAR D. RODAS ''AS IS'' AND ANY                   |
  | EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED       |
  | WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE          |
  | DISCLAIMED. IN NO EVENT SHALL CÉSAR D. RODAS BE LIABLE FOR ANY                  |
  | DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES      |
  | (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;    |
  | LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND     |
  | ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT      |
  | (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS   |
  | SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE                     |
  +---------------------------------------------------------------------------------+
  | Authors: César Rodas <crodas@php.net>                                           |
  +---------------------------------------------------------------------------------+
*/

require dirname(__FILE__)."/parser.php";

function do_parsing($template, $ignore_whitespace=FALSE)
{
    $lexer  = new Haanga_Lexer($template, $ignore_whitespace);
    $parser = new Parser;
    try {
        for($i=0; ; $i++) {
            if  (!$lexer->yylex()) {
                break;
            }
            //var_dump(array($lexer->token, $lexer->value));
            $parser->doParse($lexer->token, $lexer->value);
        }
    } catch (Exception $e) {
        throw new Exception($e->getMessage(). ' on line '.$lexer->getLine());
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
    private $ignore_whitespace;

    function __construct($data, $whitespace=FALSE)
    {
        $this->data              = $data;
        $this->N                 = 0;
        $this->ignore_whitespace = $whitespace;
        $this->line              = 1;
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

"firstof" token_end {
    $this->token = Parser::T_FIRST_OF;
}

"block" token_end {
    $this->token = Parser::T_BLOCK;
}

"&&" { 
    $this->token = Parser::T_AND;
}

"AND" {
    $this->token = Parser::T_AND;
}

"||" {
    $this->token = Parser::T_OR;
}

"OR" {
    $this->token = Parser::T_OR;
}

"==" {
    $this->token = Parser::T_EQ;
}

"!=" {
    $this->token = Parser::T_NE;
}

">=" {
    $this->token = Parser::T_GE;
}

"[" {
    $this->token = Parser::T_BRACKETS_OPEN;
}

"]" {
    $this->token = Parser::T_BRACKETS_CLOSE;
}

">" {
    $this->token = Parser::T_GT;
}

"<" {
    $this->token = Parser::T_LT;
}
"=<" {
    $this->token = Parser::T_LE;
}

"|" {
    $this->token = Parser::T_PIPE;
}

":" {
    $this->token = Parser::T_COLON;
}

"filter" token_end {
    $this->token = Parser::T_FILTER;
}

"regroup" token_end {
    $this->token = Parser::T_REGROUP;
}

"endfilter" token_end {
    $this->token = Parser::T_END_FILTER;
}

"autoescape" token_end {
    $this->token = Parser::T_AUTOESCAPE;
}


"endautoescape" token_end {
    $this->token = Parser::T_END_AUTOESCAPE;
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

"with" token_end {
    $this->token = Parser::T_WITH;
}

"endwith" token_end {
    $this->token = Parser::T_ENDWITH;
}

"as" {
    $this->token = Parser::T_AS;
}

"on" {
    $this->token = Parser::T_ON;
}

"off" {
    $this->token = Parser::T_OFF;
}

"by" {
    $this->token = Parser::T_BY;
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

"," {
    $this->token = Parser::T_COMMA;
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

"include" token_end {
    $this->token = Parser::T_INCLUDE;
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

":" {
    $this->token = Parser::T_COLON;
}


"." {
    $this->token = Parser::T_DOT;
}

"[" {
    $this->token = Parser::T_BRACKETS_OPEN;
}

"]" {
    $this->token = Parser::T_BRACKETS_CLOSE;
}

"'" {
    $this->token = Parser::T_STRING_SINGLE_INIT;
    $this->yypushstate(self::IN_STRING_SINGLE);
}

"\"" {
    $this->token = Parser::T_STRING_DOUBLE_INIT;
    $this->yypushstate(self::IN_STRING_DOUBLE);
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
