%name Haanga_
%include {
    // Include files
}
%declare_class { class Parser }
%include_class {

}

%parse_accept {
    var_dump(array('body' => $this->body));
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
body(A) ::= stmts(B). { A = array(B); }
body(A) ::= . { A = array(); }

/* List of statements */
stmts(A) ::= T_OPEN_TAG stmt(B) T_CLOSE_TAG. { A = array(B); }
stmts(A) ::= T_PRINT_OPEN varname(B) T_PRINT_CLOSE.  { A = array('operation' => 'print', 'variable' => B); }
stmts(A) ::= T_HTML(B). {A = array('operation' => 'html', 'html' => B); } 
stmts(A) ::= for_stmt(B). { A = B; }

/* Statement */

/* Cycle */
stmt(A) ::= cycle(B). { A = B; }

/* FOR loop */
for_stmt(A) ::= T_OPEN_TAG T_FOR varname(B) T_IN varname(C) T_CLOSE_TAG body(D) T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG. { 
    A = array('operation' => 'loop', 'variable' => B, 'array' => C, 'body' => D); 
}

/* Cycle */ 
cycle(A) ::= T_CYCLE vars(B). { A = array('operation' => 'cycle', 'vars' => B); } 
cycle(A) ::= T_CYCLE vars(B) T_AS varname(C). { A = array('operation' => 'cycle', 'vars' => B, 'as' => C); } 

/* List of variables */
vars(A) ::= vars(B) varname(C). { A = B; A[] = C; }
vars(A) ::= vars(B) T_STRING(C). { A = B; A[] = C; }
vars(A) ::= T_STRING(C).  { A = array(C); }
vars(A) ::= varname(B).   { A = array(B); }  

/* Variable name */
varname(A) ::= T_ALPHA(B). { A = B; } 
