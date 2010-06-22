%name Haanga_
%include {
    // Include files
}
%declare_class { class Parser }
%include_class {

}

%parse_accept {
}

%syntax_error {
    $expect = array();
    foreach ($this->yy_get_expected_tokens($yymajor) as $token) {
        $expect[] = self::$yyTokenName[$token];
    }
    throw new Exception('Unexpected ' . $this->tokenName($yymajor) . '(' . $TOKEN. '), expected one of: ' . implode(',', $expect));
}

%right TAGOPEN.

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

/* Cycle */ 
cycle(A) ::= T_CYCLE list(B). { A = array('operation' => 'cycle', 'vars' => B); } 
cycle(A) ::= T_CYCLE list(B) T_AS varname(C). { A = array('operation' => 'cycle', 'vars' => B, 'as' => C); } 

/* List of variables */
list(A) ::= list(B) var_or_string(C).  { A = B; A[] = C; }
list(A) ::= var_or_string(B). { A = array(B); }

var_or_string(A) ::= T_STRING(C).  { A = array('string' => C); }
var_or_string(A) ::= varname(B).   { A = array('var' => B); }  

/* Variable name */
varname(A) ::= T_ALPHA(B). { A = B; } 
