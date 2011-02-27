%name Haanga_
%include {
/*
  +---------------------------------------------------------------------------------+
  | Copyright (c) 2010 César Rodas and Menéame Comunicacions S.L.                   |
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

%declare_class { class Haanga_Compiler_Parser }
%include_class {
    protected $lex;
    protected $file;

    function __construct($lex, $file='')
    {
        $this->lex  = $lex;
        $this->file = $file;
    }

    function Error($text)
    {
        throw new Haanga_Compiler_Exception($text.' in '.$this->file.':'.$this->lex->getLine());
    }

}

%parse_accept {
}

%right T_TAG_OPEN.
%right T_NOT.
%left T_AND.
%left T_OR.
%nonassoc T_EQ T_NE.
%nonassoc T_GT T_GE T_LT T_LE.
%nonassoc T_IN.
%left T_PLUS T_MINUS T_CONCAT.
%left T_TIMES T_DIV T_MOD.
%left T_PIPE T_BITWISE.

%syntax_error {
    $expect = array();
    foreach ($this->yy_get_expected_tokens($yymajor) as $token) {
        $expect[] = self::$yyTokenName[$token];
    }
    $this->Error('Unexpected ' . $this->tokenName($yymajor) . '(' . $TOKEN. '), expected one of: ' . implode(',', $expect));
}


start ::= body(B). { $this->body = B; }

body(A) ::= body(B) code(C). { A=B; A[] = C; }
body(A) ::= . { A = array(); }

/* List of statements */
code(A) ::= T_TAG_OPEN stmts(B). {
    if (!is_object(B)) {
        var_dump(B);exit;
    }
    B->setLine($this->lex->getLine());
    A = B; 
}
code(A) ::= T_HTML(B). {
    A = array('operation' => 'html', 'html' => B, 'line' => $this->lex->getLine() ); 
}
code(A) ::= T_COMMENT(B). {
    B=rtrim(B); A = array('operation' => 'comment', 'comment' => B); 
} 
code(A) ::= T_PRINT_OPEN filtered_var(B) T_PRINT_CLOSE.  {
    A = new Haanga_Node_PrintOut(B);
}

stmts(A) ::= T_EXTENDS var_or_string(B) T_TAG_CLOSE. { A = array('operation' => 'base', B); }
stmts(A) ::= stmt(B) T_TAG_CLOSE. { A = B; }
stmts(A) ::= for_stmt(B). { A = B; }
stmts(A) ::= ifchanged_stmt(B). { A = B; }
stmts(A) ::= block_stmt(B). { A = B; }
stmts(A) ::= filter_stmt(B). { A = B; }
stmts(A) ::= if_stmt(B). { A = B; }
stmts(A) ::= T_INCLUDE var_or_string(B) T_TAG_CLOSE. { A = array('operation' => 'include', B); }
stmts(A) ::= custom_tag(B). { A = B; }
stmts(A) ::= alias(B). { A = B; }
stmts(A) ::= ifequal(B). { A = B; }
stmts(A) ::= T_AUTOESCAPE varname(B) T_TAG_CLOSE body(X) T_TAG_OPEN T_CUSTOM_END(E) T_TAG_CLOSE. { 
    B = strtolower(B);
    if (B != 'on' && B != 'off') {
        $this->Error("Invalid autoescape param (".B."), it must be on or off");
    }
    if (E != "endautoescape") {
        $this->Error("Invalid close tag ".E.", it must be endautoescape");
    }
    A = array('operation' => 'autoescape', 'value' => B, 'body' => X); 
}

/* Statement */

/* CUSTOM TAGS */
custom_tag(A) ::= T_CUSTOM_TAG(B) T_TAG_CLOSE. {
    A = new Haanga_Node_Exec(B);
}
custom_tag(A) ::= T_CUSTOM_TAG(B) T_AS varname(C) T_TAG_CLOSE. {
    A = new Haanga_Node_Assign(C, new Haanga_Node_Exec(B));
}
custom_tag(A) ::= T_CUSTOM_TAG(B) params(X) T_TAG_CLOSE. { 
    A = new Haanga_Node_Exec(B, X);
}
custom_tag(A) ::= T_CUSTOM_TAG(B) params(X) T_AS varname(C) T_TAG_CLOSE. {
    A = new Haanga_Node_Assign(C, new Haanga_Node_Exec(B, X));
}

/* tags as blocks */
custom_tag(A) ::= T_CUSTOM_BLOCK(B) T_TAG_CLOSE body(X) T_TAG_OPEN T_CUSTOM_END(C) T_TAG_CLOSE. {
    if ('end'.B != C) { 
        $this->error("Unexpected ".C); 
    } 
    A = array('operation' => 'custom_tag', 'name' => B, 'body' => X, 'list' => array());
}
custom_tag(A) ::= T_CUSTOM_BLOCK(B) params(L) T_TAG_CLOSE body(X) T_TAG_OPEN T_CUSTOM_END(C) T_TAG_CLOSE. {
    if ('end'.B != C) { 
        $this->error("Unexpected ".C); 
    } 
    A = array('operation' => 'custom_tag', 'name' => B, 'body' => X, 'list' => L);
}

/* Spacefull is very special, and it is handled in the compiler class */
custom_tag(A) ::= T_SPACEFULL T_TAG_CLOSE body(X) T_TAG_OPEN T_CUSTOM_END(C) T_TAG_CLOSE. {
    if ('endspacefull' != C) {
        $this->error("Unexpected ".C);
    } 
    A = array('operation' => 'spacefull', 'body' => X);
}

/* variable alias (easier to handle in the compiler class) */
alias(A) ::= T_WITH varname(B) T_AS varname(C) T_TAG_CLOSE body(X) T_TAG_OPEN T_CUSTOM_END(Z) T_TAG_CLOSE. {
    if (Z != "endwith") {
        $this->Error("Unexpected ".Z.", expecting endwith");
    }
    A = array('operation' => 'alias', 'var' => B, 'as' => C, 'body' => X); 
}

/* Simple statements (don't require a end_tag or a body ) */
stmt(A) ::= T_SET varname(C) T_ASSIGN expr(X). { A = array('operation' => 'set', 'var' => C,'expr' => X); }
stmt ::= T_LOAD string(B). {
    if (!is_file(B) || !Haanga_Compiler::getOption('enable_load')) {
        $this->error(B." is not a valid file"); 
    } 
    require_once B;
}

/* FOR loop */

for_def(A) ::= T_FOR varname(B) T_IN filtered_var(C) T_TAG_CLOSE . {
    A = new Haanga_Node_Foreach(C, NULL, B);
    return;
    $var = $this->compiler->get_context(C[0]);
    if (is_array($var) || $var instanceof Iterator) {
        /* let's check if it is an object or array */
        $this->compiler->set_context(B, current($var));
    }
    A = array('operation' => 'loop', 'variable' => B, 'index' => NULL, 'array' => C);
}

for_def(A) ::= T_FOR varname(I) T_COMMA varname(B) T_IN filtered_var(C) T_TAG_CLOSE . {
    A = new Haanga_Node_Foreach(C, I, B);
}


for_stmt(A) ::= for_def(B) body(D) T_TAG_OPEN T_CUSTOM_END(Z) T_TAG_CLOSE. { 
    if (Z != "endfor") {
        $this->Error("Unexpected ".Z.", expecting endfor");
    }
    A = B;
    A->setBody(D);
}

for_stmt(A) ::= T_FOR varname(B) T_IN range(X) T_TAG_CLOSE body(E) T_TAG_OPEN T_CUSTOM_END(Z) T_TAG_CLOSE. {
    if (Z != "endfor") {
        $this->Error("Unexpected ".Z.", expecting endfor");
    }
    A = array('operation' => 'loop', 'variable' => B, 'range' => X, 'body' => E, 'variable' => B, 'step' => 1);
}

for_stmt(A) ::= T_FOR varname(B) T_IN range(X) T_STEP numvar(S) T_TAG_CLOSE body(E) T_TAG_OPEN T_CUSTOM_END(Z) T_TAG_CLOSE. {
    if (Z != "endfor") {
        $this->Error("Unexpected ".Z.", expecting endfor");
    }
    A = array('operation' => 'loop', 'variable' => B, 'range' => X, 'body' => E, 'variable' => B, 'step' => S);
}

for_stmt(A) ::= for_def(B) body(D) T_TAG_OPEN T_EMPTY T_TAG_CLOSE body(E)  T_TAG_OPEN T_CUSTOM_END(Z) T_TAG_CLOSE. { 
    if (Z != "endfor") {
        $this->Error("Unexpected ".Z.", expecting endfor");
    }
    A = B;
    A['body']  = D;
    A['empty'] = E;
}
/* IF */
if_stmt(A) ::= T_IF expr(B) T_TAG_CLOSE body(X) T_TAG_OPEN T_CUSTOM_END(Z) T_TAG_CLOSE. {
    if (Z != "endif") {
        $this->Error("Unexpected ".Z.", expecting endif");
    }
    A = new Haanga_Node_If(B, X);
}
if_stmt(A) ::= T_IF expr(B) T_TAG_CLOSE body(X) T_TAG_OPEN T_ELSE T_TAG_CLOSE body(Y) T_TAG_OPEN T_CUSTOM_END(Z)  T_TAG_CLOSE. {
    if (Z != "endif") {
        $this->Error("Unexpected ".Z.", expecting endif");
    }
    A = array('operation' => 'if', 'expr' => B, 'body' => X, 'else' => Y);
}

/* ifchanged */
ifchanged_stmt(A) ::= T_IFCHANGED T_TAG_CLOSE body(B) T_TAG_OPEN T_CUSTOM_END(Z) T_TAG_CLOSE. { 
    if (Z != "endifchanged") {
        $this->Error("Unexpected ".Z.", expecting endifchanged");
    }
    A = array('operation' => 'ifchanged', 'body' => B); 
}

ifchanged_stmt(A) ::= T_IFCHANGED params(X) T_TAG_CLOSE body(B) T_TAG_OPEN T_CUSTOM_END(Z) T_TAG_CLOSE. { 
    if (Z != "endifchanged") {
        $this->Error("Unexpected ".Z.", expecting endifchanged");
    }
    A = array('operation' => 'ifchanged', 'body' => B, 'check' => X);
}
ifchanged_stmt(A) ::= T_IFCHANGED T_TAG_CLOSE body(B) T_TAG_OPEN T_ELSE T_TAG_CLOSE body(C) T_TAG_OPEN T_CUSTOM_END(Z) T_TAG_CLOSE. { 
    if (Z != "endifchanged") {
        $this->Error("Unexpected ".Z.", expecting endifchanged");
    }
    A = array('operation' => 'ifchanged', 'body' => B, 'else' => C); 
}

ifchanged_stmt(A) ::= T_IFCHANGED params(X) T_TAG_CLOSE body(B) T_TAG_OPEN T_ELSE T_TAG_CLOSE body(C) T_TAG_OPEN T_CUSTOM_END(Z) T_TAG_CLOSE. { 
    if (Z != "endifchanged") {
        $this->Error("Unexpected ".Z.", expecting endifchanged");
    }
    A = array('operation' => 'ifchanged', 'body' => B, 'check' => X, 'else' => C);
}

/* ifequal */
ifequal(A) ::= T_IFEQUAL var_or_string(B) var_or_string(C) T_TAG_CLOSE body(X) T_TAG_OPEN T_CUSTOM_END(Z) T_TAG_CLOSE. {
    if (Z != "endifequal") {
        $this->Error("Unexpected ".Z.", expecting endifequal");
    }
    A = array('operation' => 'ifequal', 'cmp' => '==', 1 => B, 2 => C, 'body' => X); 
}
ifequal(A) ::= T_IFEQUAL var_or_string(B) var_or_string(C) T_TAG_CLOSE body(X) T_TAG_OPEN T_ELSE T_TAG_CLOSE body(Y) T_TAG_OPEN T_CUSTOM_END(Z) T_TAG_CLOSE. {
    if (Z != "endifequal") {
        $this->Error("Unexpected ".Z.", expecting endifequal");
    }
    A = array('operation' => 'ifequal', 'cmp' => '==', 1 => B, 2 => C, 'body' => X, 'else' => Y); 
}
ifequal(A) ::= T_IFNOTEQUAL var_or_string(B) var_or_string(C) T_TAG_CLOSE body(X) T_TAG_OPEN T_CUSTOM_END(Z) T_TAG_CLOSE. {
    if (Z != "endifnotequal") {
        $this->Error("Unexpected ".Z.", expecting endifnotequal");
    }
    A = array('operation' => 'ifequal', 'cmp' => '!=', 1 => B, 2 => C, 'body' => X);
}
ifequal(A) ::= T_IFNOTEQUAL var_or_string(B) var_or_string(C) T_TAG_CLOSE body(X) T_TAG_OPEN T_ELSE T_TAG_CLOSE body(Y) T_TAG_OPEN T_CUSTOM_END(Z) T_TAG_CLOSE. {
    if (Z != "endifnotequal") {
        $this->Error("Unexpected ".Z.", expecting endifnotequal");
    }
    A = array('operation' => 'ifequal', 'cmp' => '!=', 1 => B, 2 => C, 'body' => X, 'else' => Y); 
}

/* block stmt */
block_stmt(A) ::= T_BLOCK varname(B) T_TAG_CLOSE body(C) T_TAG_OPEN T_CUSTOM_END(Z) T_TAG_CLOSE. { 
    if (Z != "endblock") {
        $this->Error("Unexpected ".Z.", expecting endblock");
    }
    A = array('operation' => 'block', 'name' => B, 'body' => C); 
}

block_stmt(A) ::= T_BLOCK varname(B) T_TAG_CLOSE body(C) T_TAG_OPEN T_CUSTOM_END(Z) varname T_TAG_CLOSE. {
    if (Z != "endblock") {
        $this->Error("Unexpected ".Z.", expecting endblock");
    }
    A = array('operation' => 'block', 'name' => B, 'body' => C); 
}

block_stmt(A) ::= T_BLOCK number(B) T_TAG_CLOSE body(C) T_TAG_OPEN T_CUSTOM_END(Z) T_TAG_CLOSE. {
    if (Z != "endblock") {
        $this->Error("Unexpected ".Z.", expecting endblock");
    }
    A = array('operation' => 'block', 'name' => B, 'body' => C); 
}

block_stmt(A) ::= T_BLOCK number(B) T_TAG_CLOSE body(C) T_TAG_OPEN T_CUSTOM_END(Z) number T_TAG_CLOSE. {
    if (Z != "endblock") {
        $this->Error("Unexpected ".Z.", expecting endblock");
    }
    A = array('operation' => 'block', 'name' => B, 'body' => C); 
}

/* filter stmt */
filter_stmt(A) ::= T_FILTER filtered_var(B) T_TAG_CLOSE body(X) T_TAG_OPEN T_CUSTOM_END(Z) T_TAG_CLOSE. {
    if (Z != "endfilter") {
        $this->Error("Unexpected ".Z.", expecting endfilter");
    }
    A = array('operation' => 'filter', 'functions' => B, 'body' => X);
}

/* variables with filters */
filtered_var(A) ::= varname(B) T_PIPE filters(C). { 
    C[0]->addParameter(B);
    $len = count(C);
    for ($i=1; $i < $len; $i++) {
        C[$i]->addParameter(C[$i-1]);
    }
    A = C[$i-1];
}

filtered_var(A) ::= varname(B). { A = B; }

filters(A) ::= filters(B) T_PIPE filter_args(C). { A = B; A[] = C; }
filters(A) ::= T_PIPE filter_args(B). { A = array(B); }

filter_args(A) ::= alpha(B) T_COLON var_or_string(X) . { A = new Haanga_Node_Exec(B, new Haanga_Node_StmtList(array(X))); }
filter_args(A) ::= alpha(B). { A = new Haanga_Node_Exec(B); }

/* List of variables */
params(A)  ::=  iparams(B). { A = new Haanga_Node_StmtList(B); }
iparams(A) ::= iparams(B) var_or_string(C).           { A = B; A[] = C; }
iparams(A) ::= iparams(B) T_COMMA var_or_string(C).   { A = B; A[] = C; }
iparams(A) ::= var_or_string(B).                       { A = array(B); }


/* variable or string (used on params) */
var_or_string(A) ::= filtered_var(B).          { A = B; }  
var_or_string(A) ::= number(B).           { A = B; }  
var_or_string(A) ::= string(B).           { A = B; }
var_or_string(A) ::= T_TRUE|T_FALSE(B).   { A = new Haanga_Node_Bool(trim(@B)); }  

/* */
string(A)    ::= T_STRING(B).   { A = new Haanga_Node_String(B); }
string(A)    ::= T_INTL T_STRING(B) T_RPARENT. { A = new Haanga_Node_String(B); }

/* expr */
expr(A) ::= T_NOT expr(B). { A = new Haanga_Node_Expr(array(new Haanga_Node_Operator('!'), B)); }
expr(A) ::= expr(B) T_AND expr(C).  { A = new Haanga_Node_Expr(array(B, new Haanga_Node_Operator('&&'), C)); }
expr(A) ::= expr(B) T_OR  expr(C).  { A = new Haanga_Node_Expr(array(B, new Haanga_Node_Operator('||'), C)); }
expr(A) ::= expr(B) T_PLUS|T_MINUS|T_CONCAT(X)  expr(C).  { A = new Haanga_Node_Expr(array(B, new Haanga_Node_Operator(@X), C)); }
expr(A) ::= expr(B) T_EQ|T_NE|T_GT|T_GE|T_LT|T_LE|T_IN(X)  expr(C).  { A = new Haanga_Node_Expr(array(B, new Haanga_Node_Operator(@X), C)); }
expr(A) ::= expr(B) T_TIMES|T_DIV|T_MOD(X)  expr(C).  { A = new Haanga_Node_Expr(array(B, new Haanga_Node_Operator(@X), C)); }
expr(A) ::= expr(B) T_BITWISE|T_PIPE(X)  expr(C).  { A = new Haanga_Node_Expr(array(B, new Haanga_Node_Operator(@X), C)); }
expr(A) ::= T_LPARENT expr(B) T_RPARENT. { A = new Haanga_Node_Expr(array(B)); }
expr(A) ::= var_or_string(B). { A = B; }

/* Variable name */
varname(A) ::= varpart(B). { 
    A = new Haanga_Node_Variable(B);
}
varpart(A) ::= varpart(B) T_OBJ|T_DOT alpha(C). { 
    B[] = new Haanga_Node_Property(C);
    A   = B;
}
varpart(A) ::= varpart(B) T_CLASS alpha(C). { 
    B[] = C; 
    A   = B;
}
varpart(A) ::= varpart(B) T_BRACKETS_OPEN var_or_string(C) T_BRACKETS_CLOSE. {
    B[] = C; 
    A   = B;
}
varpart(A) ::= alpha(B). {
    A = array(B); 
} 

alpha(A) ::= T_ALPHA(A)|T_BLOCK|T_CUSTOM_TAG|T_CUSTOM_BLOCK(B). { A = B; }

/* T_BLOCK|T_CUSTOM|T_CUSTOM_BLOCK are also T_ALPHA */

range(A)  ::= numvar(B) T_DOTDOT numvar(C). { A = array(B, C); }

numvar(A) ::= number(B).  { A = B; }
numvar(A) ::= varname(B). { A = B; }

number(A) ::= T_NUMERIC(B). { A = new Haanga_Node_Number(B); }
number(A) ::= T_MINUS T_NUMERIC(B). { A = new Haanga_Node_Number(-1 * (B)); }
