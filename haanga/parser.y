%name Haanga_
%include {
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
}

%declare_class { class Parser }
%include_class {

}

%parse_accept {
}

%right T_OPEN_TAG.
%left T_AND.
%left T_OR.
%nonassoc T_EQ T_NE.
%nonassoc T_GT T_GE T_LT T_LE.
%nonassoc T_IN.
%left T_PLUS T_MINUS.
%left T_TIMES T_DIV T_MOD.

%syntax_error {
    $expect = array();
    foreach ($this->yy_get_expected_tokens($yymajor) as $token) {
        $expect[] = self::$yyTokenName[$token];
    }
    throw new Exception('Unexpected ' . $this->tokenName($yymajor) . '(' . $TOKEN. '), expected one of: ' . implode(',', $expect));
}


start ::= body(B). { $this->body = B; }

body(A) ::= body(B) code(C). { A=B; A[] = C; }
body(A) ::= . { A = array(); }

/* List of statements */
code(A) ::= T_OPEN_TAG stmts(B). { A = B; }
code(A) ::= T_HTML(B). { A = array('operation' => 'html', 'html' => B); }
code(A) ::= T_COMMENT_OPEN T_COMMENT(B). { B=rtrim(B); A = array('operation' => 'comment', 'comment' => substr(B, 0, strlen(B)-2)); } 
code(A) ::= T_PRINT_OPEN piped_list(B) T_PRINT_CLOSE.  { A = array('operation' => 'print_var', 'variable' => B); }

stmts(A) ::= T_EXTENDS var_or_string(B) T_CLOSE_TAG. { A = array('operation' => 'base', B); }
stmts(A) ::= stmt(B) T_CLOSE_TAG. { A = B; }
stmts(A) ::= for_stmt(B). { A = B; }
stmts(A) ::= ifchanged_stmt(B). { A = B; }
stmts(A) ::= block_stmt(B). { A = B; }
stmts(A) ::= filter_stmt(B). { A = B; }
stmts(A) ::= custom_stmt(B). { A = B; }
stmts(A) ::= if_stmt(B). { A = B; }
stmts(A) ::= T_INCLUDE var_or_string(B) T_CLOSE_TAG. { A = array('operation' => 'include', B); }
stmts(A) ::= fnc_call_stmt(B). { A = B; }
stmts(A) ::= alias(B). { A = B; }

/* Statement */

/* function call */
fnc_call_stmt(A) ::= varname(B) T_CLOSE_TAG. { A = array('operation' => 'function', 'name' => B, 'list'=>array()); }
fnc_call_stmt(A) ::= varname(B) T_FOR varname(C) T_CLOSE_TAG. { A = array('operation' => 'function', 'name' => B, 'for' => C, 'list' => array()); }
fnc_call_stmt(A) ::= varname(B) T_FOR varname(C) T_AS varname(X) T_CLOSE_TAG. { A = array('operation' => 'function', 'name' => B, 'for' => C, 'list' => array(),'as' => X); }
fnc_call_stmt(A) ::= varname(B) T_AS varname(C) T_CLOSE_TAG. { A = array('operation' => 'function', 'name' => B, 'as' => C); }
fnc_call_stmt(A) ::= varname(B) list(X) T_CLOSE_TAG. { A = array('operation' => 'function', 'name' => B, 'list' => X); }
fnc_call_stmt(A) ::= varname(B) list(X) T_AS varname(C) T_CLOSE_TAG. { A = array('operation' => 'function', 'name' => B, 'as' => C, 'list' => X); }

/* variable alias */
alias(A) ::= T_WITH varname(B) T_AS varname(C) T_CLOSE_TAG body(X) T_OPEN_TAG T_ENDWITH T_CLOSE_TAG. { A = array('operation' => 'alias', 'var' => B, 'as' => C, 'body' => X); }

/* Simple statements (don't require a end_tag or a body ) */
stmt(A) ::= cycle(B). { A = B; }
stmt(A) ::= regroup(B). { A = B; }
stmt(A) ::= first_of(B). { A = B; }

/* FOR loop */
for_stmt(A) ::= T_FOR varname(B) T_IN varname(C) T_CLOSE_TAG body(D) T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG. { 
    A = array('operation' => 'loop', 'variable' => B, 'array' => C, 'body' => D); 
}
for_stmt(A) ::= T_FOR varname(I) T_COMMA varname(B) T_IN varname(C) T_CLOSE_TAG body(D) T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG. { 
    A = array('operation' => 'loop', 'variable' => B, 'array' => C, 'body' => D, 'index' => I); 
}
for_stmt(A) ::= T_FOR varname(B) T_IN varname(C) T_CLOSE_TAG body(D) T_OPEN_TAG T_EMPTY T_CLOSE_TAG body(E)  T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG. { 
    A = array('operation' => 'loop', 'variable' => B, 'array' => C, 'body' => D, 'empty' => E); 
}
for_stmt(A) ::= T_FOR varname(I) T_COMMA varname(B) T_IN varname(C) T_CLOSE_TAG body(D) T_OPEN_TAG T_EMPTY T_CLOSE_TAG body(E)  T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG. { 
    A = array('operation' => 'loop', 'variable' => B, 'array' => C, 'body' => D, 'empty' => E, 'index' => I); 
}
/* IF */
if_stmt(A) ::= T_IF expr(B) T_CLOSE_TAG body(X) T_OPEN_TAG T_ENDIF T_CLOSE_TAG. { A = array('operation' => 'if', 'expr' => B, 'body' => X); }
if_stmt(A) ::= T_IF expr(B) T_CLOSE_TAG body(X) T_OPEN_TAG T_ELSE T_CLOSE_TAG body(Y) T_OPEN_TAG T_ENDIF  T_CLOSE_TAG. { A = array('operation' => 'if', 'expr' => B, 'body' => X, 'else' => Y); }

/* ifchanged */
ifchanged_stmt(A) ::= T_IFCHANGED T_CLOSE_TAG body(B) T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG. { 
    A = array('operation' => 'ifchanged', 'body' => B); 
}

ifchanged_stmt(A) ::= T_IFCHANGED list(X) T_CLOSE_TAG body(B) T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG. { 
    A = array('operation' => 'ifchanged', 'body' => B, 'check' => X);
}
ifchanged_stmt(A) ::= T_IFCHANGED T_CLOSE_TAG body(B) T_OPEN_TAG T_ELSE T_CLOSE_TAG body(C) T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG. { 
    A = array('operation' => 'ifchanged', 'body' => B, 'else' => C); 
}

ifchanged_stmt(A) ::= T_IFCHANGED list(X) T_CLOSE_TAG body(B) T_OPEN_TAG T_ELSE T_CLOSE_TAG body(C) T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG. { 
    A = array('operation' => 'ifchanged', 'body' => B, 'check' => X, 'else' => C);
}

/* custom stmt */
custom_stmt(A) ::= varname(B) T_CLOSE_TAG body(X) T_OPEN_TAG T_CUSTOM_END(C) T_CLOSE_TAG. { if ('end'.B != C) { throw new Exception("Unexpected ".C); } A = array('operation' => 'filter', 'functions' =>array(B), 'body' => X);}
 
/* block stmt */
block_stmt(A) ::= T_BLOCK varname(B) T_CLOSE_TAG body(C) T_OPEN_TAG T_END_BLOCK T_CLOSE_TAG. { A = array('operation' => 'block', 'name' => B, 'body' => C); }

block_stmt(A) ::= T_BLOCK varname(B) T_CLOSE_TAG body(C) T_OPEN_TAG T_END_BLOCK varname T_CLOSE_TAG. { A = array('operation' => 'block', 'name' => B, 'body' => C); }

/* filter stmt */
filter_stmt(A) ::= T_FILTER piped_list(B) T_CLOSE_TAG body(X) T_OPEN_TAG T_END_FILTER T_CLOSE_TAG. { A = array('operation' => 'filter', 'functions' => B, 'body' => X); }

/* regroup stmt */
regroup(A) ::= T_REGROUP varname(B) T_BY varname(C) T_AS varname(X). { A=array('operation' => 'regroup', 'array' => B, 'row' => C, 'as' => X); }

/* Cycle */ 
cycle(A) ::= T_CYCLE list(B). { A = array('operation' => 'cycle', 'vars' => B); } 
cycle(A) ::= T_CYCLE list(B) T_AS varname(C). { A = array('operation' => 'cycle', 'vars' => B, 'as' => C); } 

/* first_of */
first_of(A) ::= T_FIRST_OF list(B). { A = array('operation' => 'first_of', 'vars' => B); }


/* Piped filters */
piped_list(A) ::= piped_list(B) T_PIPE varname_args(C). { A = B; A[] = C; }
piped_list(A) ::= varname_args(B). { A = array(B); }

varname_args(A) ::= varname(B) T_COLON var_or_string(X) . { A = array(B, 'args'=>array(X)); }
varname_args(A) ::= varname(B). { A = B; }

/* List of variables */
list(A) ::= list(B) var_or_string(C).  { A = B; A[] = C; }
list(A) ::= list(B) T_COMMA var_or_string(C).  { A = B; A[] = C; }
list(A) ::= var_or_string(B). { A = array(B); }

var_or_string(A) ::= varname(B).   { A = array('var' => B); }  
var_or_string(A) ::= string(B).    { A = array('string' => B); }

string(A)    ::= T_STRING_SINGLE_INIT s_content(B)  T_STRING_SINGLE_END. {  A = B; }
string(A)    ::= T_STRING_DOUBLE_INIT s_content(B)  T_STRING_DOUBLE_END. {  A = B; }
s_content(A) ::= s_content(B) T_STRING_CONTENT(C). { A = B.C; }
s_content(A) ::= T_STRING_CONTENT(B). { A = B; }

/* expr */
expr(A) ::= expr(B) T_AND(X)  expr(C).  { A = array('op' => @X, B, C); }
expr(A) ::= expr(B) T_OR(X)  expr(C).  { A = array('op' => @X, B, C); }
expr(A) ::= expr(B) T_PLUS|T_MINUS(X)  expr(C).  { A = array('op' => @X, B, C); }
expr(A) ::= expr(B) T_EQ|T_NE|T_GT|T_GE|T_LT|T_LE|T_IN(X)  expr(C).  { A = array('op' => trim(@X), B, C); }
expr(A) ::= expr(B) T_TIMES|T_DIV|T_MOD(X)  expr(C).  { A = array('op' => @X, B, C); }
expr(A) ::= piped_list(B). {A = array('var_filter' => B);}
expr(A) ::= T_LPARENT expr(B) T_RPARENT. { A = array('op' => 'expr', B); }
//expr(A) ::= var_or_string(B). { A = B; }
expr(A) ::= string(B).   { A = array('string' => B); }
expr(A) ::= T_NUMERIC(B). { A = B; }


/* Variable name */
varname(A) ::= varname(B) T_DOT T_ALPHA(C). { if (!is_array(B)) { A = array(B); } else { A = B; }  A[]=C;}
varname(A) ::= varname(B) T_BRACKETS_OPEN var_or_string(C) T_BRACKETS_CLOSE. { if (!is_array(B)) { A = array(B); } else { A = B; }  A[]=C;}
varname(A) ::= T_ALPHA(B). { A = B; } 
