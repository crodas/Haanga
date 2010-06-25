%name Haanga_
%include {
    // Include files
}

%declare_class { class Parser }
%include_class {

}

%parse_accept {
}

%left T_AND.
%left T_OR.
%nonassoc T_EQ T_NE.
%left T_PLUS T_MINUS.
%left T_TIMES T_DIV T_MOD.

%syntax_error {
    $expect = array();
    foreach ($this->yy_get_expected_tokens($yymajor) as $token) {
        $expect[] = self::$yyTokenName[$token];
    }
    throw new Exception('Unexpected ' . $this->tokenName($yymajor) . '(' . $TOKEN. '), expected one of: ' . implode(',', $expect));
}

%right TAGOPEN.

start ::= T_OPEN_TAG T_EXTENDS var_or_string(B) T_CLOSE_TAG body(A). { A['base'] = B; $this->body = A; }
start ::= body(B). { $this->body = B; }

body(A) ::= body(B) stmts(C). { A=B; A[] = C; }
body(A) ::= . { A = array(); }

/* List of statements */
stmts(A) ::= T_OPEN_TAG stmt(B) T_CLOSE_TAG. { A = B; }
stmts(A) ::= T_PRINT_OPEN varname(B) T_PRINT_CLOSE.  { A = array('operation' => 'print', 'variable' => B); }
stmts(A) ::= T_HTML(B). {A = array('operation' => 'html', 'html' => B); } 
stmts(A) ::= for_stmt(B). { A = B; }
stmts(A) ::= ifchanged_stmt(B). { A = B; }
stmts(A) ::= T_COMMENT_OPEN T_COMMENT(B). { B=rtrim(B); A = array('operation' => 'php', 'php' => "/*".substr(B, 0, strlen(B)-2)."*/"); }
stmts(A) ::= block_stmt(B). { A = B; }
stmts(A) ::= filter_stmt(B). { A = B; }
stmts(A) ::= custom_stmt(B). { A = B; }
stmts(A) ::= if_stmt(B). { A = B; }

/* Statement */

/* Cycle */
stmt(A) ::= cycle(B). { A = B; }

/* FOR loop */
for_stmt(A) ::= T_OPEN_TAG T_FOR varname(B) T_IN varname(C) T_CLOSE_TAG body(D) T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG. { 
    A = array('operation' => 'loop', 'variable' => B, 'array' => C, 'body' => D); 
}
for_stmt(A) ::= T_OPEN_TAG T_FOR varname(B) T_IN varname(C) T_CLOSE_TAG body(D) T_OPEN_TAG T_EMPTY T_CLOSE_TAG body(E)  T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG. { 
    A = array('operation' => 'loop', 'variable' => B, 'array' => C, 'body' => D, 'empty' => E); 
}
/* IF */
if_stmt(A) ::= T_OPEN_TAG T_IF expr(B) T_CLOSE_TAG body(X) T_OPEN_TAG T_ENDIF T_CLOSE_TAG. { A = array('operation' => 'if', 'expr' => B, 'body' => X); }
if_stmt(A) ::= T_OPEN_TAG T_IF expr(B) T_CLOSE_TAG body(X) T_OPEN_TAG T_ELSE T_CLOSE_TAG body(Y) T_OPEN_TAG T_ENDIF  T_CLOSE_TAG. { A = array('operation' => 'if', 'expr' => B, 'body' => X, 'else' => Y); }

/* ifchanged */
ifchanged_stmt(A) ::= T_OPEN_TAG T_IFCHANGED T_CLOSE_TAG body(B) T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG. { 
    A = array('operation' => 'ifchanged', 'body' => B); 
}

ifchanged_stmt(A) ::= T_OPEN_TAG T_IFCHANGED list(X) T_CLOSE_TAG body(B) T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG. { 
    A = array('operation' => 'ifchanged', 'body' => B, 'check' => X);
}
ifchanged_stmt(A) ::= T_OPEN_TAG T_IFCHANGED T_CLOSE_TAG body(B) T_OPEN_TAG T_ELSE T_CLOSE_TAG body(C) T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG. { 
    A = array('operation' => 'ifchanged', 'body' => B, 'else' => C); 
}

ifchanged_stmt(A) ::= T_OPEN_TAG T_IFCHANGED list(X) T_CLOSE_TAG body(B) T_OPEN_TAG T_ELSE T_CLOSE_TAG body(C) T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG. { 
    A = array('operation' => 'ifchanged', 'body' => B, 'check' => X, 'else' => C);
}

/* custom stmt */
custom_stmt(A) ::= T_OPEN_TAG varname(B) T_CLOSE_TAG body(X) T_OPEN_TAG T_CUSTOM_END(C) T_CLOSE_TAG. { if ('end'.B != C) { throw new Exception("Unexpected ".C); } A = array('operation' => 'filter', 'functions' => array(array('var'=>B)), 'body' => X);}
 
/* block stmt */
block_stmt(A) ::= T_OPEN_TAG T_BLOCK varname(B) T_CLOSE_TAG body(C) T_OPEN_TAG T_END_BLOCK T_CLOSE_TAG. { A = array('operation' => 'block', 'name' => B, 'body' => C); }

block_stmt(A) ::= T_OPEN_TAG T_BLOCK varname(B) T_CLOSE_TAG body(C) T_OPEN_TAG T_END_BLOCK varname T_CLOSE_TAG. { A = array('operation' => 'block', 'name' => B, 'body' => C); }

/* filter stmt */
filter_stmt(A) ::= T_OPEN_TAG T_FILTER piped_list(B) T_CLOSE_TAG body(X) T_OPEN_TAG T_END_FILTER T_CLOSE_TAG. { A = array('operation' => 'filter', 'functions' => B, 'body' => X); }


/* Cycle */ 
cycle(A) ::= T_CYCLE list(B). { A = array('operation' => 'cycle', 'vars' => B); } 
cycle(A) ::= T_CYCLE list(B) T_AS varname(C). { A = array('operation' => 'cycle', 'vars' => B, 'as' => C); } 

/* Piped filters */
piped_list(A) ::= piped_list(B) T_PIPE var_or_string(C). { A = B; A[] = C; }
piped_list(A) ::= var_or_string(B). { A = array(B); }

/* List of variables */
list(A) ::= list(B) var_or_string(C).  { A = B; A[] = C; }
list(A) ::= var_or_string(B). { A = array(B); }

var_or_string(A) ::= varname(B).   { A = array('var' => B); }  
var_or_string(A) ::= string(B).    { A = array('string' => B); }

string(A)    ::= T_STRING_SINGLE_INIT s_content(B)  T_STRING_SINGLE_END. {  A = B; }
string(A)    ::= T_STRING_DOUBLE_INIT s_content(B)  T_STRING_DOUBLE_END. {  A = B; }
s_content(A) ::= s_content(B) T_STRING_CONTENT(C). { A = B.C; }
s_content(A) ::= T_STRING_CONTENT(B). { A = B; }

/* expr */
expr(A) ::= T_LPARENT expr(B) T_RPARENT. { A = B; }
expr(A) ::= expr(B) T_AND(X)  expr(C).  { A[] = array(@X, B, C); }
expr(A) ::= expr(B) T_OR(X)  expr(C).  { A[] = array(@X, B, C); }
expr(A) ::= expr(B) T_EQ|T_NE(X)  expr(C).  { A[] = array(@X, B, C); }
expr(A) ::= expr(B) T_TIMES|T_DIV|T_MOD(X)  expr(C).  { A[] = array(@X, B, C); }
expr(A) ::= expr(B) T_PLUS|T_MINUS(X)  expr(C).  { A[] = array(@X, B, C); }
expr(A) ::= var_or_string(B). { A = B; }
expr(A) ::= T_NUMERIC(B). { A = B; }


/* Variable name */
varname(A) ::= varname(B) T_DOT T_ALPHA(C). { if (!is_array(B)) { A = array(B); } else { A = B; }  A[]=C;}
varname(A) ::= T_ALPHA(B). { A = B; } 
