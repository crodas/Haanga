%name Haanga_
%include {
    // Include files
}
%declare_class { class Parser }
%include_class {

}

%parse_accept {
    var_dump($this->body);
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

body(A) ::= body(B) stmt(C). { A=B; A[] = C; }
body(A) ::= stmt(B). { A = array(B); }

/* FOR loop */
stmt(A) ::= T_FOR varname(B) T_IN varname(C) body(D) T_ENDFOR.  { A = array('operation' => 'loop', 'variable' => B, 'array' => C, 'body' => D); }
/* HTML */
stmt(A) ::= T_HTML(B).  { A = array('operation' => 'html', 'html' => B); }
/* Cycle */
stmt(A) ::= cicle(B). { A = B; }
/* Print variable */
stmt(A) ::= T_PRINT_OPEN varname(B) T_PRINT_CLOSE.  { A = array('operation' => 'print', 'variable' => B); }
/* Nothing */
stmt(A) ::= . { A = NULL; }

/* Cicle */ 
cicle(A) ::= T_CICLE vars(B). { A = array('operation' => 'cicle', 'vars' => B); } 
cicle(A) ::= T_CICLE vars(B) T_AS varname(C). { A = array('operation' => 'cicle', 'vars' => B, 'as' => C); } 

/* List of variables */
vars(A) ::= vars(B) varname(C). { A = B; A[] = C; }
vars(A) ::= varname(B).   { A = array(B); }  

/* Variable name */
varname(A) ::= T_VAR(B). { A = B; } 
