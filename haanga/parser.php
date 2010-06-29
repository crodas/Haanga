<?php
/* Driver template for the PHP_Haanga_rGenerator parser generator. (PHP port of LEMON)
*/

/**
 * This can be used to store both the string representation of
 * a token, and any useful meta-data associated with the token.
 *
 * meta-data should be stored as an array
 */
class Haanga_yyToken implements ArrayAccess
{
    public $string = '';
    public $metadata = array();

    function __construct($s, $m = array())
    {
        if ($s instanceof Haanga_yyToken) {
            $this->string = $s->string;
            $this->metadata = $s->metadata;
        } else {
            $this->string = (string) $s;
            if ($m instanceof Haanga_yyToken) {
                $this->metadata = $m->metadata;
            } elseif (is_array($m)) {
                $this->metadata = $m;
            }
        }
    }

    function __toString()
    {
        return $this->_string;
    }

    function offsetExists($offset)
    {
        return isset($this->metadata[$offset]);
    }

    function offsetGet($offset)
    {
        return $this->metadata[$offset];
    }

    function offsetSet($offset, $value)
    {
        if ($offset === null) {
            if (isset($value[0])) {
                $x = ($value instanceof Haanga_yyToken) ?
                    $value->metadata : $value;
                $this->metadata = array_merge($this->metadata, $x);
                return;
            }
            $offset = count($this->metadata);
        }
        if ($value === null) {
            return;
        }
        if ($value instanceof Haanga_yyToken) {
            if ($value->metadata) {
                $this->metadata[$offset] = $value->metadata;
            }
        } elseif ($value) {
            $this->metadata[$offset] = $value;
        }
    }

    function offsetUnset($offset)
    {
        unset($this->metadata[$offset]);
    }
}

/** The following structure represents a single element of the
 * parser's stack.  Information stored includes:
 *
 *   +  The state number for the parser at this level of the stack.
 *
 *   +  The value of the token stored at this level of the stack.
 *      (In other words, the "major" token.)
 *
 *   +  The semantic value stored at this level of the stack.  This is
 *      the information used by the action routines in the grammar.
 *      It is sometimes called the "minor" token.
 */
class Haanga_yyStackEntry
{
    public $stateno;       /* The state-number */
    public $major;         /* The major token value.  This is the code
                     ** number for the token at this stack level */
    public $minor; /* The user-supplied minor token value.  This
                     ** is the value of the token  */
};

// code external to the class is included here
#line 2 "parser.y"

    // Include files
#line 102 "parser.php"

// declare_class is output here
#line 6 "parser.y"
 class Parser #line 107 "parser.php"
{
/* First off, code is included which follows the "include_class" declaration
** in the input file. */
#line 7 "parser.y"


#line 115 "parser.php"

/* Next is all token values, as class constants
*/
/* 
** These constants (all generated automatically by the parser generator)
** specify the various kinds of tokens (terminals) that the parser
** understands. 
**
** Each symbol here is a terminal symbol in the grammar.
*/
    const T_AND                          =  1;
    const T_OR                           =  2;
    const T_EQ                           =  3;
    const T_NE                           =  4;
    const T_PLUS                         =  5;
    const T_MINUS                        =  6;
    const T_TIMES                        =  7;
    const T_DIV                          =  8;
    const T_MOD                          =  9;
    const TAGOPEN                        = 10;
    const T_OPEN_TAG                     = 11;
    const T_HTML                         = 12;
    const T_COMMENT_OPEN                 = 13;
    const T_COMMENT                      = 14;
    const T_PRINT_OPEN                   = 15;
    const T_PRINT_CLOSE                  = 16;
    const T_EXTENDS                      = 17;
    const T_CLOSE_TAG                    = 18;
    const T_INCLUDE                      = 19;
    const T_FOR                          = 20;
    const T_AS                           = 21;
    const T_WITH                         = 22;
    const T_ENDWITH                      = 23;
    const T_IN                           = 24;
    const T_CLOSEFOR                     = 25;
    const T_EMPTY                        = 26;
    const T_IF                           = 27;
    const T_ENDIF                        = 28;
    const T_ELSE                         = 29;
    const T_IFCHANGED                    = 30;
    const T_ENDIFCHANGED                 = 31;
    const T_CUSTOM_END                   = 32;
    const T_BLOCK                        = 33;
    const T_END_BLOCK                    = 34;
    const T_FILTER                       = 35;
    const T_END_FILTER                   = 36;
    const T_CYCLE                        = 37;
    const T_PIPE                         = 38;
    const T_COMMA                        = 39;
    const T_STRING_SINGLE_INIT           = 40;
    const T_STRING_SINGLE_END            = 41;
    const T_STRING_DOUBLE_INIT           = 42;
    const T_STRING_DOUBLE_END            = 43;
    const T_STRING_CONTENT               = 44;
    const T_LPARENT                      = 45;
    const T_RPARENT                      = 46;
    const T_NUMERIC                      = 47;
    const T_DOT                          = 48;
    const T_ALPHA                        = 49;
    const YY_NO_ACTION = 227;
    const YY_ACCEPT_ACTION = 226;
    const YY_ERROR_ACTION = 225;

/* Next are that tables used to determine what action to take based on the
** current state and lookahead token.  These tables are used to implement
** functions that take a state number and lookahead value and return an
** action integer.  
**
** Suppose the action integer is N.  Then the action is determined as
** follows
**
**   0 <= N < self::YYNSTATE                              Shift N.  That is,
**                                                        push the lookahead
**                                                        token onto the stack
**                                                        and goto state N.
**
**   self::YYNSTATE <= N < self::YYNSTATE+self::YYNRULE   Reduce by rule N-YYNSTATE.
**
**   N == self::YYNSTATE+self::YYNRULE                    A syntax error has occurred.
**
**   N == self::YYNSTATE+self::YYNRULE+1                  The parser accepts its
**                                                        input. (and concludes parsing)
**
**   N == self::YYNSTATE+self::YYNRULE+2                  No such action.  Denotes unused
**                                                        slots in the yy_action[] table.
**
** The action table is constructed as a single large static array $yy_action.
** Given state S and lookahead X, the action is computed as
**
**      self::$yy_action[self::$yy_shift_ofst[S] + X ]
**
** If the index value self::$yy_shift_ofst[S]+X is out of range or if the value
** self::$yy_lookahead[self::$yy_shift_ofst[S]+X] is not equal to X or if
** self::$yy_shift_ofst[S] is equal to self::YY_SHIFT_USE_DFLT, it means that
** the action is not in the table and that self::$yy_default[S] should be used instead.  
**
** The formula above is for computing the action when the lookahead is
** a terminal symbol.  If the lookahead is a non-terminal (as occurs after
** a reduce action) then the static $yy_reduce_ofst array is used in place of
** the static $yy_shift_ofst array and self::YY_REDUCE_USE_DFLT is used in place of
** self::YY_SHIFT_USE_DFLT.
**
** The following are the tables generated in this section:
**
**  self::$yy_action        A single table containing all actions.
**  self::$yy_lookahead     A table containing the lookahead for each entry in
**                          yy_action.  Used to detect hash collisions.
**  self::$yy_shift_ofst    For each state, the offset into self::$yy_action for
**                          shifting terminals.
**  self::$yy_reduce_ofst   For each state, the offset into self::$yy_action for
**                          shifting non-terminals after a reduce.
**  self::$yy_default       Default action for each state.
*/
    const YY_SZ_ACTTAB = 498;
static public $yy_action = array(
 /*     0 */   137,   14,  140,  104,  120,  134,  163,  155,  154,  152,
 /*    10 */   162,  161,   31,  150,   28,   53,   68,   50,  118,  116,
 /*    20 */    99,  100,   20,   40,   58,   22,   55,  131,   56,   16,
 /*    30 */    23,  113,   24,  119,  107,   31,   29,   28,   53,   34,
 /*    40 */    50,   18,   18,   18,  119,   20,  102,  108,   22,  106,
 /*    50 */   114,   56,   38,   23,  133,   24,   31,   54,   28,   53,
 /*    60 */   124,   50,   71,  116,  125,  129,   20,  119,   97,   22,
 /*    70 */    95,   70,   56,   32,   23,   46,   24,   31,   35,   28,
 /*    80 */    53,   36,   50,   58,  107,   55,  107,   20,  119,   98,
 /*    90 */    22,  112,  119,   56,   37,   23,  119,   24,   31,  107,
 /*   100 */    28,   53,   62,   50,  103,  106,  139,   39,   20,  119,
 /*   110 */   143,   22,  106,  146,   56,  148,   23,   65,   24,   31,
 /*   120 */   125,   28,   53,   25,   50,   49,   67,  125,  121,   20,
 /*   130 */   119,  126,   22,  106,  114,   56,  153,   23,   93,   24,
 /*   140 */    31,  149,   28,   53,  135,   50,   73,  107,  125,  158,
 /*   150 */    20,  119,  107,   22,  144,   92,   56,  142,   23,  117,
 /*   160 */    24,   31,   87,   28,   53,  122,   50,  132,  159,  101,
 /*   170 */    69,   20,  119,  160,   22,  106,  141,   56,  119,   23,
 /*   180 */   128,   24,   31,   90,   28,   53,   43,   50,   64,   88,
 /*   190 */   125,  182,   20,  119,  151,   22,   96,  107,   56,  135,
 /*   200 */    23,   94,   24,   31,  127,   28,   53,  115,   50,   86,
 /*   210 */   107,   80,   84,   20,  119,   89,   22,  110,  107,   56,
 /*   220 */    44,   23,   79,   24,   31,  135,   28,   53,   83,   50,
 /*   230 */   106,  114,  157,   85,   20,  119,   63,   22,  106,  114,
 /*   240 */    56,   45,   23,   76,   24,  125,   33,   31,   77,   28,
 /*   250 */    53,   74,   50,  125,  226,   42,  119,   20,  111,   81,
 /*   260 */    22,  136,  107,   56,   78,   23,  107,   24,   82,   17,
 /*   270 */    19,   15,   15,   21,   21,   18,   18,   18,  135,  119,
 /*   280 */    41,   17,   19,   15,   15,   21,   21,   18,   18,   18,
 /*   290 */    31,  107,   28,   53,  135,   50,  106,  146,   60,  135,
 /*   300 */    20,  106,  146,   22,  135,  135,   56,   27,   23,  135,
 /*   310 */    24,  125,   26,  135,  138,  135,  125,  135,  135,   66,
 /*   320 */   135,  135,  119,  135,  135,   19,   15,   15,   21,   21,
 /*   330 */    18,   18,   18,   15,   15,   21,   21,   18,   18,   18,
 /*   340 */    30,   58,  135,   55,   52,  135,   57,   51,  135,  130,
 /*   350 */   119,  135,   59,   13,  147,   91,  135,   48,   47,    5,
 /*   360 */   147,   91,  135,   48,  135,  135,   58,  135,   55,  135,
 /*   370 */    30,   58,  135,   55,  107,  119,   30,   58,  135,   55,
 /*   380 */   119,  135,  135,   12,  147,   91,  119,   48,    2,  147,
 /*   390 */    91,  135,   48,  135,  135,    6,  147,   91,  135,   48,
 /*   400 */    10,  147,   91,  135,   48,   61,  135,    7,  147,   91,
 /*   410 */   135,   48,    3,  147,   91,  135,   48,  135,  135,    9,
 /*   420 */   147,   91,  135,   48,    4,  147,   91,   58,   48,   55,
 /*   430 */   135,    8,  147,   91,  135,   48,  119,   11,  147,   91,
 /*   440 */   135,   48,  135,  106,  114,  135,  106,  114,  106,  145,
 /*   450 */   135,  135,  106,  114,  135,  135,   75,  135,  125,  123,
 /*   460 */   135,  125,  135,  125,  135,   72,  135,  125,    1,  147,
 /*   470 */    91,  135,   48,  135,  135,  135,  106,  109,  135,  106,
 /*   480 */   156,  135,  106,  105,  135,  135,  135,  135,  135,  135,
 /*   490 */   135,  125,  135,  135,  125,  135,  135,  125,
    );
    static public $yy_lookahead = array(
 /*     0 */    54,   55,   16,   57,   58,   59,   60,   61,   62,   63,
 /*    10 */    64,   65,   17,   67,   19,   20,   18,   22,   43,   44,
 /*    20 */    25,   26,   27,   52,   40,   30,   42,   18,   33,   45,
 /*    30 */    35,   47,   37,   49,   48,   17,   38,   19,   20,   52,
 /*    40 */    22,    7,    8,    9,   49,   27,   28,   29,   30,   55,
 /*    50 */    56,   33,   52,   35,   18,   37,   17,   21,   19,   20,
 /*    60 */    41,   22,   68,   44,   70,   18,   27,   49,   29,   30,
 /*    70 */    31,   18,   33,   52,   35,   24,   37,   17,   52,   19,
 /*    80 */    20,   52,   22,   40,   48,   42,   48,   27,   49,   29,
 /*    90 */    30,   31,   49,   33,   52,   35,   49,   37,   17,   48,
 /*   100 */    19,   20,   18,   22,   23,   55,   56,   52,   27,   49,
 /*   110 */    18,   30,   55,   56,   33,   18,   35,   18,   37,   17,
 /*   120 */    70,   19,   20,   66,   22,   21,   18,   70,   18,   27,
 /*   130 */    49,   18,   30,   55,   56,   33,   18,   35,   36,   37,
 /*   140 */    17,   14,   19,   20,   49,   22,   68,   48,   70,   18,
 /*   150 */    27,   49,   48,   30,   18,   32,   33,   18,   35,   18,
 /*   160 */    37,   17,   55,   19,   20,   18,   22,   18,   18,   25,
 /*   170 */    18,   27,   49,   18,   30,   55,   56,   33,   49,   35,
 /*   180 */    18,   37,   17,   55,   19,   20,   52,   22,   18,   69,
 /*   190 */    70,    0,   27,   49,   18,   30,   31,   48,   33,   72,
 /*   200 */    35,   55,   37,   17,   53,   19,   20,   44,   22,   55,
 /*   210 */    48,   55,   55,   27,   49,   55,   30,   31,   48,   33,
 /*   220 */    52,   35,   55,   37,   17,   72,   19,   20,   55,   22,
 /*   230 */    55,   56,   18,   55,   27,   49,   18,   30,   55,   56,
 /*   240 */    33,   34,   35,   68,   37,   70,   52,   17,   55,   19,
 /*   250 */    20,   68,   22,   70,   51,   52,   49,   27,   28,   71,
 /*   260 */    30,   18,   48,   33,   55,   35,   48,   37,   71,    1,
 /*   270 */     2,    3,    4,    5,    6,    7,    8,    9,   72,   49,
 /*   280 */    52,    1,    2,    3,    4,    5,    6,    7,    8,    9,
 /*   290 */    17,   48,   19,   20,   72,   22,   55,   56,   18,   72,
 /*   300 */    27,   55,   56,   30,   72,   72,   33,   66,   35,   72,
 /*   310 */    37,   70,   66,   72,   46,   72,   70,   72,   72,   18,
 /*   320 */    72,   72,   49,   72,   72,    2,    3,    4,    5,    6,
 /*   330 */     7,    8,    9,    3,    4,    5,    6,    7,    8,    9,
 /*   340 */    39,   40,   72,   42,   18,   72,   20,   21,   72,   18,
 /*   350 */    49,   72,   21,   11,   12,   13,   72,   15,   21,   11,
 /*   360 */    12,   13,   72,   15,   72,   72,   40,   72,   42,   72,
 /*   370 */    39,   40,   72,   42,   48,   49,   39,   40,   72,   42,
 /*   380 */    49,   72,   72,   11,   12,   13,   49,   15,   11,   12,
 /*   390 */    13,   72,   15,   72,   72,   11,   12,   13,   72,   15,
 /*   400 */    11,   12,   13,   72,   15,   18,   72,   11,   12,   13,
 /*   410 */    72,   15,   11,   12,   13,   72,   15,   72,   72,   11,
 /*   420 */    12,   13,   72,   15,   11,   12,   13,   40,   15,   42,
 /*   430 */    72,   11,   12,   13,   72,   15,   49,   11,   12,   13,
 /*   440 */    72,   15,   72,   55,   56,   72,   55,   56,   55,   56,
 /*   450 */    72,   72,   55,   56,   72,   72,   68,   72,   70,   68,
 /*   460 */    72,   70,   72,   70,   72,   68,   72,   70,   11,   12,
 /*   470 */    13,   72,   15,   72,   72,   72,   55,   56,   72,   55,
 /*   480 */    56,   72,   55,   56,   72,   72,   72,   72,   72,   72,
 /*   490 */    72,   70,   72,   72,   70,   72,   72,   70,
);
    const YY_SHIFT_USE_DFLT = -26;
    const YY_SHIFT_MAX = 112;
    static public $yy_shift_ofst = array(
 /*     0 */   -26,   -5,   18,   60,   39,  165,  186,  207,  230,  144,
 /*    10 */   102,   81,  123,  273,  326,  -16,  -16,  -16,  -16,  -16,
 /*    20 */   -16,  -16,  387,   43,   43,  331,  337,  301,   43,   43,
 /*    30 */    43,   43,  413,  401,  384,  426,  457,  408,  420,  396,
 /*    40 */   389,  348,  342,  372,  377,   47,  129,  129,  129,  129,
 /*    50 */   129,  129,  191,  129,  129,  163,  129,  129,  163,  129,
 /*    60 */   -26,  -26,  -26,  -26,  -26,  -26,  -26,  -26,  -26,  -26,
 /*    70 */   -26,  280,  268,  323,  330,  330,   34,   36,  218,  214,
 /*    80 */    51,   19,  -25,  149,  162,  243,  104,  170,   -2,   99,
 /*    90 */   -14,  127,  141,  147,   38,  150,  118,   84,   53,   92,
 /*   100 */   108,  136,   97,  176,  110,  113,   38,   95,  152,  131,
 /*   110 */     9,  139,  155,
);
    const YY_REDUCE_USE_DFLT = -55;
    const YY_REDUCE_MAX = 70;
    static public $yy_reduce_ofst = array(
 /*     0 */   203,  -54,  -54,  -54,  -54,  -54,  -54,  -54,  -54,  -54,
 /*    10 */   -54,  -54,  -54,  -54,   57,  388,  397,   78,  391,  183,
 /*    20 */    -6,  175,  241,  120,  246,  393,  393,  393,  421,   50,
 /*    30 */   424,  427,  151,  151,  151,  151,  151,  151,  151,  151,
 /*    40 */   151,  151,  151,  151,  151,  167,  160,  146,  128,  107,
 /*    50 */   154,  157,  134,  156,  173,  197,  209,  193,  188,  178,
 /*    60 */   168,  194,  228,   55,   26,   29,   21,   42,  -29,    0,
 /*    70 */   -13,
);
    static public $yyExpectedTokens = array(
        /* 0 */ array(),
        /* 1 */ array(17, 19, 20, 22, 25, 26, 27, 30, 33, 35, 37, 49, ),
        /* 2 */ array(17, 19, 20, 22, 27, 28, 29, 30, 33, 35, 37, 49, ),
        /* 3 */ array(17, 19, 20, 22, 27, 29, 30, 31, 33, 35, 37, 49, ),
        /* 4 */ array(17, 19, 20, 22, 27, 29, 30, 31, 33, 35, 37, 49, ),
        /* 5 */ array(17, 19, 20, 22, 27, 30, 31, 33, 35, 37, 49, ),
        /* 6 */ array(17, 19, 20, 22, 27, 30, 31, 33, 35, 37, 49, ),
        /* 7 */ array(17, 19, 20, 22, 27, 30, 33, 34, 35, 37, 49, ),
        /* 8 */ array(17, 19, 20, 22, 27, 28, 30, 33, 35, 37, 49, ),
        /* 9 */ array(17, 19, 20, 22, 25, 27, 30, 33, 35, 37, 49, ),
        /* 10 */ array(17, 19, 20, 22, 27, 30, 33, 35, 36, 37, 49, ),
        /* 11 */ array(17, 19, 20, 22, 23, 27, 30, 33, 35, 37, 49, ),
        /* 12 */ array(17, 19, 20, 22, 27, 30, 32, 33, 35, 37, 49, ),
        /* 13 */ array(17, 19, 20, 22, 27, 30, 33, 35, 37, 49, ),
        /* 14 */ array(18, 20, 21, 40, 42, 48, 49, ),
        /* 15 */ array(40, 42, 45, 47, 49, ),
        /* 16 */ array(40, 42, 45, 47, 49, ),
        /* 17 */ array(40, 42, 45, 47, 49, ),
        /* 18 */ array(40, 42, 45, 47, 49, ),
        /* 19 */ array(40, 42, 45, 47, 49, ),
        /* 20 */ array(40, 42, 45, 47, 49, ),
        /* 21 */ array(40, 42, 45, 47, 49, ),
        /* 22 */ array(18, 40, 42, 49, ),
        /* 23 */ array(40, 42, 49, ),
        /* 24 */ array(40, 42, 49, ),
        /* 25 */ array(18, 21, 39, 40, 42, 49, ),
        /* 26 */ array(21, 39, 40, 42, 49, ),
        /* 27 */ array(18, 39, 40, 42, 49, ),
        /* 28 */ array(40, 42, 49, ),
        /* 29 */ array(40, 42, 49, ),
        /* 30 */ array(40, 42, 49, ),
        /* 31 */ array(40, 42, 49, ),
        /* 32 */ array(11, 12, 13, 15, ),
        /* 33 */ array(11, 12, 13, 15, ),
        /* 34 */ array(11, 12, 13, 15, ),
        /* 35 */ array(11, 12, 13, 15, ),
        /* 36 */ array(11, 12, 13, 15, ),
        /* 37 */ array(11, 12, 13, 15, ),
        /* 38 */ array(11, 12, 13, 15, ),
        /* 39 */ array(11, 12, 13, 15, ),
        /* 40 */ array(11, 12, 13, 15, ),
        /* 41 */ array(11, 12, 13, 15, ),
        /* 42 */ array(11, 12, 13, 15, ),
        /* 43 */ array(11, 12, 13, 15, ),
        /* 44 */ array(11, 12, 13, 15, ),
        /* 45 */ array(18, 49, ),
        /* 46 */ array(49, ),
        /* 47 */ array(49, ),
        /* 48 */ array(49, ),
        /* 49 */ array(49, ),
        /* 50 */ array(49, ),
        /* 51 */ array(49, ),
        /* 52 */ array(0, ),
        /* 53 */ array(49, ),
        /* 54 */ array(49, ),
        /* 55 */ array(44, ),
        /* 56 */ array(49, ),
        /* 57 */ array(49, ),
        /* 58 */ array(44, ),
        /* 59 */ array(49, ),
        /* 60 */ array(),
        /* 61 */ array(),
        /* 62 */ array(),
        /* 63 */ array(),
        /* 64 */ array(),
        /* 65 */ array(),
        /* 66 */ array(),
        /* 67 */ array(),
        /* 68 */ array(),
        /* 69 */ array(),
        /* 70 */ array(),
        /* 71 */ array(1, 2, 3, 4, 5, 6, 7, 8, 9, 18, ),
        /* 72 */ array(1, 2, 3, 4, 5, 6, 7, 8, 9, 46, ),
        /* 73 */ array(2, 3, 4, 5, 6, 7, 8, 9, ),
        /* 74 */ array(3, 4, 5, 6, 7, 8, 9, ),
        /* 75 */ array(3, 4, 5, 6, 7, 8, 9, ),
        /* 76 */ array(7, 8, 9, ),
        /* 77 */ array(18, 21, 48, ),
        /* 78 */ array(18, 48, ),
        /* 79 */ array(18, 48, ),
        /* 80 */ array(24, 48, ),
        /* 81 */ array(41, 44, ),
        /* 82 */ array(43, 44, ),
        /* 83 */ array(18, 48, ),
        /* 84 */ array(18, 48, ),
        /* 85 */ array(18, 48, ),
        /* 86 */ array(21, 48, ),
        /* 87 */ array(18, 48, ),
        /* 88 */ array(18, 38, ),
        /* 89 */ array(18, 48, ),
        /* 90 */ array(16, 48, ),
        /* 91 */ array(14, ),
        /* 92 */ array(18, ),
        /* 93 */ array(18, ),
        /* 94 */ array(48, ),
        /* 95 */ array(18, ),
        /* 96 */ array(18, ),
        /* 97 */ array(18, ),
        /* 98 */ array(18, ),
        /* 99 */ array(18, ),
        /* 100 */ array(18, ),
        /* 101 */ array(18, ),
        /* 102 */ array(18, ),
        /* 103 */ array(18, ),
        /* 104 */ array(18, ),
        /* 105 */ array(18, ),
        /* 106 */ array(48, ),
        /* 107 */ array(49, ),
        /* 108 */ array(18, ),
        /* 109 */ array(18, ),
        /* 110 */ array(18, ),
        /* 111 */ array(18, ),
        /* 112 */ array(18, ),
        /* 113 */ array(),
        /* 114 */ array(),
        /* 115 */ array(),
        /* 116 */ array(),
        /* 117 */ array(),
        /* 118 */ array(),
        /* 119 */ array(),
        /* 120 */ array(),
        /* 121 */ array(),
        /* 122 */ array(),
        /* 123 */ array(),
        /* 124 */ array(),
        /* 125 */ array(),
        /* 126 */ array(),
        /* 127 */ array(),
        /* 128 */ array(),
        /* 129 */ array(),
        /* 130 */ array(),
        /* 131 */ array(),
        /* 132 */ array(),
        /* 133 */ array(),
        /* 134 */ array(),
        /* 135 */ array(),
        /* 136 */ array(),
        /* 137 */ array(),
        /* 138 */ array(),
        /* 139 */ array(),
        /* 140 */ array(),
        /* 141 */ array(),
        /* 142 */ array(),
        /* 143 */ array(),
        /* 144 */ array(),
        /* 145 */ array(),
        /* 146 */ array(),
        /* 147 */ array(),
        /* 148 */ array(),
        /* 149 */ array(),
        /* 150 */ array(),
        /* 151 */ array(),
        /* 152 */ array(),
        /* 153 */ array(),
        /* 154 */ array(),
        /* 155 */ array(),
        /* 156 */ array(),
        /* 157 */ array(),
        /* 158 */ array(),
        /* 159 */ array(),
        /* 160 */ array(),
        /* 161 */ array(),
        /* 162 */ array(),
        /* 163 */ array(),
);
    static public $yy_default = array(
 /*     0 */   166,  225,  225,  225,  225,  225,  225,  225,  225,  225,
 /*    10 */   225,  225,  225,  225,  225,  225,  225,  225,  225,  225,
 /*    20 */   225,  225,  225,  225,  225,  225,  202,  225,  225,  225,
 /*    30 */   225,  225,  225,  225,  225,  225,  225,  225,  225,  225,
 /*    40 */   225,  225,  164,  225,  225,  225,  225,  225,  225,  225,
 /*    50 */   225,  225,  166,  225,  225,  225,  225,  225,  225,  225,
 /*    60 */   166,  166,  166,  166,  166,  166,  166,  166,  166,  166,
 /*    70 */   166,  225,  225,  216,  217,  218,  220,  225,  225,  225,
 /*    80 */   225,  225,  225,  225,  225,  225,  225,  225,  225,  225,
 /*    90 */   225,  225,  225,  225,  203,  225,  225,  225,  225,  225,
 /*   100 */   225,  225,  225,  225,  225,  225,  209,  225,  225,  225,
 /*   110 */   225,  225,  225,  222,  221,  214,  213,  198,  212,  224,
 /*   120 */   173,  172,  201,  219,  211,  210,  171,  165,  185,  199,
 /*   130 */   186,  196,  184,  183,  174,  223,  187,  167,  215,  204,
 /*   140 */   170,  205,  193,  190,  191,  206,  208,  168,  192,  169,
 /*   150 */   189,  188,  178,  197,  177,  176,  207,  200,  179,  195,
 /*   160 */   194,  181,  180,  175,
);
/* The next thing included is series of defines which control
** various aspects of the generated parser.
**    self::YYNOCODE      is a number which corresponds
**                        to no legal terminal or nonterminal number.  This
**                        number is used to fill in empty slots of the hash 
**                        table.
**    self::YYFALLBACK    If defined, this indicates that one or more tokens
**                        have fall-back values which should be used if the
**                        original value of the token will not parse.
**    self::YYSTACKDEPTH  is the maximum depth of the parser's stack.
**    self::YYNSTATE      the combined number of states.
**    self::YYNRULE       the number of rules in the grammar
**    self::YYERRORSYMBOL is the code number of the error symbol.  If not
**                        defined, then do no error processing.
*/
    const YYNOCODE = 73;
    const YYSTACKDEPTH = 100;
    const YYNSTATE = 164;
    const YYNRULE = 61;
    const YYERRORSYMBOL = 50;
    const YYERRSYMDT = 'yy0';
    const YYFALLBACK = 0;
    /** The next table maps tokens into fallback tokens.  If a construct
     * like the following:
     * 
     *      %fallback ID X Y Z.
     *
     * appears in the grammer, then ID becomes a fallback token for X, Y,
     * and Z.  Whenever one of the tokens X, Y, or Z is input to the parser
     * but it does not parse, the type of the token is changed to ID and
     * the parse is retried before an error is thrown.
     */
    static public $yyFallback = array(
    );
    /**
     * Turn parser tracing on by giving a stream to which to write the trace
     * and a prompt to preface each trace message.  Tracing is turned off
     * by making either argument NULL 
     *
     * Inputs:
     * 
     * - A stream resource to which trace output should be written.
     *   If NULL, then tracing is turned off.
     * - A prefix string written at the beginning of every
     *   line of trace output.  If NULL, then tracing is
     *   turned off.
     *
     * Outputs:
     * 
     * - None.
     * @param resource
     * @param string
     */
    static function Trace($TraceFILE, $zTracePrompt)
    {
        if (!$TraceFILE) {
            $zTracePrompt = 0;
        } elseif (!$zTracePrompt) {
            $TraceFILE = 0;
        }
        self::$yyTraceFILE = $TraceFILE;
        self::$yyTracePrompt = $zTracePrompt;
    }

    /**
     * Output debug information to output (php://output stream)
     */
    static function PrintTrace()
    {
        self::$yyTraceFILE = fopen('php://output', 'w');
        self::$yyTracePrompt = '';
    }

    /**
     * @var resource|0
     */
    static public $yyTraceFILE;
    /**
     * String to prepend to debug output
     * @var string|0
     */
    static public $yyTracePrompt;
    /**
     * @var int
     */
    public $yyidx;                    /* Index of top element in stack */
    /**
     * @var int
     */
    public $yyerrcnt;                 /* Shifts left before out of the error */
    /**
     * @var array
     */
    public $yystack = array();  /* The parser's stack */

    /**
     * For tracing shifts, the names of all terminals and nonterminals
     * are required.  The following table supplies these names
     * @var array
     */
    static public $yyTokenName = array( 
  '$',             'T_AND',         'T_OR',          'T_EQ',        
  'T_NE',          'T_PLUS',        'T_MINUS',       'T_TIMES',     
  'T_DIV',         'T_MOD',         'TAGOPEN',       'T_OPEN_TAG',  
  'T_HTML',        'T_COMMENT_OPEN',  'T_COMMENT',     'T_PRINT_OPEN',
  'T_PRINT_CLOSE',  'T_EXTENDS',     'T_CLOSE_TAG',   'T_INCLUDE',   
  'T_FOR',         'T_AS',          'T_WITH',        'T_ENDWITH',   
  'T_IN',          'T_CLOSEFOR',    'T_EMPTY',       'T_IF',        
  'T_ENDIF',       'T_ELSE',        'T_IFCHANGED',   'T_ENDIFCHANGED',
  'T_CUSTOM_END',  'T_BLOCK',       'T_END_BLOCK',   'T_FILTER',    
  'T_END_FILTER',  'T_CYCLE',       'T_PIPE',        'T_COMMA',     
  'T_STRING_SINGLE_INIT',  'T_STRING_SINGLE_END',  'T_STRING_DOUBLE_INIT',  'T_STRING_DOUBLE_END',
  'T_STRING_CONTENT',  'T_LPARENT',     'T_RPARENT',     'T_NUMERIC',   
  'T_DOT',         'T_ALPHA',       'error',         'start',       
  'body',          'code',          'stmts',         'varname',     
  'var_or_string',  'stmt',          'for_stmt',      'ifchanged_stmt',
  'block_stmt',    'filter_stmt',   'custom_stmt',   'if_stmt',     
  'fnc_call_stmt',  'alias',         'list',          'cycle',       
  'expr',          'piped_list',    'string',        's_content',   
    );

    /**
     * For tracing reduce actions, the names of all rules are required.
     * @var array
     */
    static public $yyRuleName = array(
 /*   0 */ "start ::= body",
 /*   1 */ "body ::= body code",
 /*   2 */ "body ::=",
 /*   3 */ "code ::= T_OPEN_TAG stmts",
 /*   4 */ "code ::= T_HTML",
 /*   5 */ "code ::= T_COMMENT_OPEN T_COMMENT",
 /*   6 */ "code ::= T_PRINT_OPEN varname T_PRINT_CLOSE",
 /*   7 */ "stmts ::= T_EXTENDS var_or_string T_CLOSE_TAG",
 /*   8 */ "stmts ::= stmt T_CLOSE_TAG",
 /*   9 */ "stmts ::= for_stmt",
 /*  10 */ "stmts ::= ifchanged_stmt",
 /*  11 */ "stmts ::= block_stmt",
 /*  12 */ "stmts ::= filter_stmt",
 /*  13 */ "stmts ::= custom_stmt",
 /*  14 */ "stmts ::= if_stmt",
 /*  15 */ "stmts ::= T_INCLUDE var_or_string T_CLOSE_TAG",
 /*  16 */ "stmts ::= fnc_call_stmt",
 /*  17 */ "stmts ::= alias",
 /*  18 */ "fnc_call_stmt ::= varname T_CLOSE_TAG",
 /*  19 */ "fnc_call_stmt ::= varname T_FOR varname T_CLOSE_TAG",
 /*  20 */ "fnc_call_stmt ::= varname T_FOR varname T_AS varname T_CLOSE_TAG",
 /*  21 */ "fnc_call_stmt ::= varname T_AS varname T_CLOSE_TAG",
 /*  22 */ "fnc_call_stmt ::= varname list T_CLOSE_TAG",
 /*  23 */ "fnc_call_stmt ::= varname list T_AS varname T_CLOSE_TAG",
 /*  24 */ "alias ::= T_WITH varname T_AS varname T_CLOSE_TAG body T_OPEN_TAG T_ENDWITH T_CLOSE_TAG",
 /*  25 */ "stmt ::= cycle",
 /*  26 */ "for_stmt ::= T_FOR varname T_IN varname T_CLOSE_TAG body T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG",
 /*  27 */ "for_stmt ::= T_FOR varname T_IN varname T_CLOSE_TAG body T_OPEN_TAG T_EMPTY T_CLOSE_TAG body T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG",
 /*  28 */ "if_stmt ::= T_IF expr T_CLOSE_TAG body T_OPEN_TAG T_ENDIF T_CLOSE_TAG",
 /*  29 */ "if_stmt ::= T_IF expr T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIF T_CLOSE_TAG",
 /*  30 */ "ifchanged_stmt ::= T_IFCHANGED T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  31 */ "ifchanged_stmt ::= T_IFCHANGED list T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  32 */ "ifchanged_stmt ::= T_IFCHANGED T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  33 */ "ifchanged_stmt ::= T_IFCHANGED list T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  34 */ "custom_stmt ::= varname T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  35 */ "block_stmt ::= T_BLOCK varname T_CLOSE_TAG body T_OPEN_TAG T_END_BLOCK T_CLOSE_TAG",
 /*  36 */ "block_stmt ::= T_BLOCK varname T_CLOSE_TAG body T_OPEN_TAG T_END_BLOCK varname T_CLOSE_TAG",
 /*  37 */ "filter_stmt ::= T_FILTER piped_list T_CLOSE_TAG body T_OPEN_TAG T_END_FILTER T_CLOSE_TAG",
 /*  38 */ "cycle ::= T_CYCLE list",
 /*  39 */ "cycle ::= T_CYCLE list T_AS varname",
 /*  40 */ "piped_list ::= piped_list T_PIPE var_or_string",
 /*  41 */ "piped_list ::= var_or_string",
 /*  42 */ "list ::= list var_or_string",
 /*  43 */ "list ::= list T_COMMA var_or_string",
 /*  44 */ "list ::= var_or_string",
 /*  45 */ "var_or_string ::= varname",
 /*  46 */ "var_or_string ::= string",
 /*  47 */ "string ::= T_STRING_SINGLE_INIT s_content T_STRING_SINGLE_END",
 /*  48 */ "string ::= T_STRING_DOUBLE_INIT s_content T_STRING_DOUBLE_END",
 /*  49 */ "s_content ::= s_content T_STRING_CONTENT",
 /*  50 */ "s_content ::= T_STRING_CONTENT",
 /*  51 */ "expr ::= T_LPARENT expr T_RPARENT",
 /*  52 */ "expr ::= expr T_AND expr",
 /*  53 */ "expr ::= expr T_OR expr",
 /*  54 */ "expr ::= expr T_EQ|T_NE expr",
 /*  55 */ "expr ::= expr T_TIMES|T_DIV|T_MOD expr",
 /*  56 */ "expr ::= expr T_PLUS|T_MINUS expr",
 /*  57 */ "expr ::= var_or_string",
 /*  58 */ "expr ::= T_NUMERIC",
 /*  59 */ "varname ::= varname T_DOT T_ALPHA",
 /*  60 */ "varname ::= T_ALPHA",
    );

    /**
     * This function returns the symbolic name associated with a token
     * value.
     * @param int
     * @return string
     */
    function tokenName($tokenType)
    {
        if ($tokenType === 0) {
            return 'End of Input';
        }
        if ($tokenType > 0 && $tokenType < count(self::$yyTokenName)) {
            return self::$yyTokenName[$tokenType];
        } else {
            return "Unknown";
        }
    }

    /**
     * The following function deletes the value associated with a
     * symbol.  The symbol can be either a terminal or nonterminal.
     * @param int the symbol code
     * @param mixed the symbol's value
     */
    static function yy_destructor($yymajor, $yypminor)
    {
        switch ($yymajor) {
        /* Here is inserted the actions which take place when a
        ** terminal or non-terminal is destroyed.  This can happen
        ** when the symbol is popped from the stack during a
        ** reduce or during error processing or when a parser is 
        ** being destroyed before it is finished parsing.
        **
        ** Note: during a reduce, the only symbols destroyed are those
        ** which appear on the RHS of the rule, but which are not used
        ** inside the C code.
        */
            default:  break;   /* If no destructor action specified: do nothing */
        }
    }

    /**
     * Pop the parser's stack once.
     *
     * If there is a destructor routine associated with the token which
     * is popped from the stack, then call it.
     *
     * Return the major token number for the symbol popped.
     * @param Haanga_yyParser
     * @return int
     */
    function yy_pop_parser_stack()
    {
        if (!count($this->yystack)) {
            return;
        }
        $yytos = array_pop($this->yystack);
        if (self::$yyTraceFILE && $this->yyidx >= 0) {
            fwrite(self::$yyTraceFILE,
                self::$yyTracePrompt . 'Popping ' . self::$yyTokenName[$yytos->major] .
                    "\n");
        }
        $yymajor = $yytos->major;
        self::yy_destructor($yymajor, $yytos->minor);
        $this->yyidx--;
        return $yymajor;
    }

    /**
     * Deallocate and destroy a parser.  Destructors are all called for
     * all stack elements before shutting the parser down.
     */
    function __destruct()
    {
        while ($this->yyidx >= 0) {
            $this->yy_pop_parser_stack();
        }
        if (is_resource(self::$yyTraceFILE)) {
            fclose(self::$yyTraceFILE);
        }
    }

    /**
     * Based on the current state and parser stack, get a list of all
     * possible lookahead tokens
     * @param int
     * @return array
     */
    function yy_get_expected_tokens($token)
    {
        $state = $this->yystack[$this->yyidx]->stateno;
        $expected = self::$yyExpectedTokens[$state];
        if (in_array($token, self::$yyExpectedTokens[$state], true)) {
            return $expected;
        }
        $stack = $this->yystack;
        $yyidx = $this->yyidx;
        do {
            $yyact = $this->yy_find_shift_action($token);
            if ($yyact >= self::YYNSTATE && $yyact < self::YYNSTATE + self::YYNRULE) {
                // reduce action
                $done = 0;
                do {
                    if ($done++ == 100) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        // too much recursion prevents proper detection
                        // so give up
                        return array_unique($expected);
                    }
                    $yyruleno = $yyact - self::YYNSTATE;
                    $this->yyidx -= self::$yyRuleInfo[$yyruleno]['rhs'];
                    $nextstate = $this->yy_find_reduce_action(
                        $this->yystack[$this->yyidx]->stateno,
                        self::$yyRuleInfo[$yyruleno]['lhs']);
                    if (isset(self::$yyExpectedTokens[$nextstate])) {
                        $expected += self::$yyExpectedTokens[$nextstate];
                            if (in_array($token,
                                  self::$yyExpectedTokens[$nextstate], true)) {
                            $this->yyidx = $yyidx;
                            $this->yystack = $stack;
                            return array_unique($expected);
                        }
                    }
                    if ($nextstate < self::YYNSTATE) {
                        // we need to shift a non-terminal
                        $this->yyidx++;
                        $x = new Haanga_yyStackEntry;
                        $x->stateno = $nextstate;
                        $x->major = self::$yyRuleInfo[$yyruleno]['lhs'];
                        $this->yystack[$this->yyidx] = $x;
                        continue 2;
                    } elseif ($nextstate == self::YYNSTATE + self::YYNRULE + 1) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        // the last token was just ignored, we can't accept
                        // by ignoring input, this is in essence ignoring a
                        // syntax error!
                        return array_unique($expected);
                    } elseif ($nextstate === self::YY_NO_ACTION) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        // input accepted, but not shifted (I guess)
                        return $expected;
                    } else {
                        $yyact = $nextstate;
                    }
                } while (true);
            }
            break;
        } while (true);
        return array_unique($expected);
    }

    /**
     * Based on the parser state and current parser stack, determine whether
     * the lookahead token is possible.
     * 
     * The parser will convert the token value to an error token if not.  This
     * catches some unusual edge cases where the parser would fail.
     * @param int
     * @return bool
     */
    function yy_is_expected_token($token)
    {
        if ($token === 0) {
            return true; // 0 is not part of this
        }
        $state = $this->yystack[$this->yyidx]->stateno;
        if (in_array($token, self::$yyExpectedTokens[$state], true)) {
            return true;
        }
        $stack = $this->yystack;
        $yyidx = $this->yyidx;
        do {
            $yyact = $this->yy_find_shift_action($token);
            if ($yyact >= self::YYNSTATE && $yyact < self::YYNSTATE + self::YYNRULE) {
                // reduce action
                $done = 0;
                do {
                    if ($done++ == 100) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        // too much recursion prevents proper detection
                        // so give up
                        return true;
                    }
                    $yyruleno = $yyact - self::YYNSTATE;
                    $this->yyidx -= self::$yyRuleInfo[$yyruleno]['rhs'];
                    $nextstate = $this->yy_find_reduce_action(
                        $this->yystack[$this->yyidx]->stateno,
                        self::$yyRuleInfo[$yyruleno]['lhs']);
                    if (isset(self::$yyExpectedTokens[$nextstate]) &&
                          in_array($token, self::$yyExpectedTokens[$nextstate], true)) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        return true;
                    }
                    if ($nextstate < self::YYNSTATE) {
                        // we need to shift a non-terminal
                        $this->yyidx++;
                        $x = new Haanga_yyStackEntry;
                        $x->stateno = $nextstate;
                        $x->major = self::$yyRuleInfo[$yyruleno]['lhs'];
                        $this->yystack[$this->yyidx] = $x;
                        continue 2;
                    } elseif ($nextstate == self::YYNSTATE + self::YYNRULE + 1) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        if (!$token) {
                            // end of input: this is valid
                            return true;
                        }
                        // the last token was just ignored, we can't accept
                        // by ignoring input, this is in essence ignoring a
                        // syntax error!
                        return false;
                    } elseif ($nextstate === self::YY_NO_ACTION) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        // input accepted, but not shifted (I guess)
                        return true;
                    } else {
                        $yyact = $nextstate;
                    }
                } while (true);
            }
            break;
        } while (true);
        $this->yyidx = $yyidx;
        $this->yystack = $stack;
        return true;
    }

    /**
     * Find the appropriate action for a parser given the terminal
     * look-ahead token iLookAhead.
     *
     * If the look-ahead token is YYNOCODE, then check to see if the action is
     * independent of the look-ahead.  If it is, return the action, otherwise
     * return YY_NO_ACTION.
     * @param int The look-ahead token
     */
    function yy_find_shift_action($iLookAhead)
    {
        $stateno = $this->yystack[$this->yyidx]->stateno;
     
        /* if ($this->yyidx < 0) return self::YY_NO_ACTION;  */
        if (!isset(self::$yy_shift_ofst[$stateno])) {
            // no shift actions
            return self::$yy_default[$stateno];
        }
        $i = self::$yy_shift_ofst[$stateno];
        if ($i === self::YY_SHIFT_USE_DFLT) {
            return self::$yy_default[$stateno];
        }
        if ($iLookAhead == self::YYNOCODE) {
            return self::YY_NO_ACTION;
        }
        $i += $iLookAhead;
        if ($i < 0 || $i >= self::YY_SZ_ACTTAB ||
              self::$yy_lookahead[$i] != $iLookAhead) {
            if (count(self::$yyFallback) && $iLookAhead < count(self::$yyFallback)
                   && ($iFallback = self::$yyFallback[$iLookAhead]) != 0) {
                if (self::$yyTraceFILE) {
                    fwrite(self::$yyTraceFILE, self::$yyTracePrompt . "FALLBACK " .
                        self::$yyTokenName[$iLookAhead] . " => " .
                        self::$yyTokenName[$iFallback] . "\n");
                }
                return $this->yy_find_shift_action($iFallback);
            }
            return self::$yy_default[$stateno];
        } else {
            return self::$yy_action[$i];
        }
    }

    /**
     * Find the appropriate action for a parser given the non-terminal
     * look-ahead token $iLookAhead.
     *
     * If the look-ahead token is self::YYNOCODE, then check to see if the action is
     * independent of the look-ahead.  If it is, return the action, otherwise
     * return self::YY_NO_ACTION.
     * @param int Current state number
     * @param int The look-ahead token
     */
    function yy_find_reduce_action($stateno, $iLookAhead)
    {
        /* $stateno = $this->yystack[$this->yyidx]->stateno; */

        if (!isset(self::$yy_reduce_ofst[$stateno])) {
            return self::$yy_default[$stateno];
        }
        $i = self::$yy_reduce_ofst[$stateno];
        if ($i == self::YY_REDUCE_USE_DFLT) {
            return self::$yy_default[$stateno];
        }
        if ($iLookAhead == self::YYNOCODE) {
            return self::YY_NO_ACTION;
        }
        $i += $iLookAhead;
        if ($i < 0 || $i >= self::YY_SZ_ACTTAB ||
              self::$yy_lookahead[$i] != $iLookAhead) {
            return self::$yy_default[$stateno];
        } else {
            return self::$yy_action[$i];
        }
    }

    /**
     * Perform a shift action.
     * @param int The new state to shift in
     * @param int The major token to shift in
     * @param mixed the minor token to shift in
     */
    function yy_shift($yyNewState, $yyMajor, $yypMinor)
    {
        $this->yyidx++;
        if ($this->yyidx >= self::YYSTACKDEPTH) {
            $this->yyidx--;
            if (self::$yyTraceFILE) {
                fprintf(self::$yyTraceFILE, "%sStack Overflow!\n", self::$yyTracePrompt);
            }
            while ($this->yyidx >= 0) {
                $this->yy_pop_parser_stack();
            }
            /* Here code is inserted which will execute if the parser
            ** stack ever overflows */
            return;
        }
        $yytos = new Haanga_yyStackEntry;
        $yytos->stateno = $yyNewState;
        $yytos->major = $yyMajor;
        $yytos->minor = $yypMinor;
        array_push($this->yystack, $yytos);
        if (self::$yyTraceFILE && $this->yyidx > 0) {
            fprintf(self::$yyTraceFILE, "%sShift %d\n", self::$yyTracePrompt,
                $yyNewState);
            fprintf(self::$yyTraceFILE, "%sStack:", self::$yyTracePrompt);
            for($i = 1; $i <= $this->yyidx; $i++) {
                fprintf(self::$yyTraceFILE, " %s",
                    self::$yyTokenName[$this->yystack[$i]->major]);
            }
            fwrite(self::$yyTraceFILE,"\n");
        }
    }

    /**
     * The following table contains information about every rule that
     * is used during the reduce.
     *
     * <pre>
     * array(
     *  array(
     *   int $lhs;         Symbol on the left-hand side of the rule
     *   int $nrhs;     Number of right-hand side symbols in the rule
     *  ),...
     * );
     * </pre>
     */
    static public $yyRuleInfo = array(
  array( 'lhs' => 51, 'rhs' => 1 ),
  array( 'lhs' => 52, 'rhs' => 2 ),
  array( 'lhs' => 52, 'rhs' => 0 ),
  array( 'lhs' => 53, 'rhs' => 2 ),
  array( 'lhs' => 53, 'rhs' => 1 ),
  array( 'lhs' => 53, 'rhs' => 2 ),
  array( 'lhs' => 53, 'rhs' => 3 ),
  array( 'lhs' => 54, 'rhs' => 3 ),
  array( 'lhs' => 54, 'rhs' => 2 ),
  array( 'lhs' => 54, 'rhs' => 1 ),
  array( 'lhs' => 54, 'rhs' => 1 ),
  array( 'lhs' => 54, 'rhs' => 1 ),
  array( 'lhs' => 54, 'rhs' => 1 ),
  array( 'lhs' => 54, 'rhs' => 1 ),
  array( 'lhs' => 54, 'rhs' => 1 ),
  array( 'lhs' => 54, 'rhs' => 3 ),
  array( 'lhs' => 54, 'rhs' => 1 ),
  array( 'lhs' => 54, 'rhs' => 1 ),
  array( 'lhs' => 64, 'rhs' => 2 ),
  array( 'lhs' => 64, 'rhs' => 4 ),
  array( 'lhs' => 64, 'rhs' => 6 ),
  array( 'lhs' => 64, 'rhs' => 4 ),
  array( 'lhs' => 64, 'rhs' => 3 ),
  array( 'lhs' => 64, 'rhs' => 5 ),
  array( 'lhs' => 65, 'rhs' => 9 ),
  array( 'lhs' => 57, 'rhs' => 1 ),
  array( 'lhs' => 58, 'rhs' => 9 ),
  array( 'lhs' => 58, 'rhs' => 13 ),
  array( 'lhs' => 63, 'rhs' => 7 ),
  array( 'lhs' => 63, 'rhs' => 11 ),
  array( 'lhs' => 59, 'rhs' => 6 ),
  array( 'lhs' => 59, 'rhs' => 7 ),
  array( 'lhs' => 59, 'rhs' => 10 ),
  array( 'lhs' => 59, 'rhs' => 11 ),
  array( 'lhs' => 62, 'rhs' => 6 ),
  array( 'lhs' => 60, 'rhs' => 7 ),
  array( 'lhs' => 60, 'rhs' => 8 ),
  array( 'lhs' => 61, 'rhs' => 7 ),
  array( 'lhs' => 67, 'rhs' => 2 ),
  array( 'lhs' => 67, 'rhs' => 4 ),
  array( 'lhs' => 69, 'rhs' => 3 ),
  array( 'lhs' => 69, 'rhs' => 1 ),
  array( 'lhs' => 66, 'rhs' => 2 ),
  array( 'lhs' => 66, 'rhs' => 3 ),
  array( 'lhs' => 66, 'rhs' => 1 ),
  array( 'lhs' => 56, 'rhs' => 1 ),
  array( 'lhs' => 56, 'rhs' => 1 ),
  array( 'lhs' => 70, 'rhs' => 3 ),
  array( 'lhs' => 70, 'rhs' => 3 ),
  array( 'lhs' => 71, 'rhs' => 2 ),
  array( 'lhs' => 71, 'rhs' => 1 ),
  array( 'lhs' => 68, 'rhs' => 3 ),
  array( 'lhs' => 68, 'rhs' => 3 ),
  array( 'lhs' => 68, 'rhs' => 3 ),
  array( 'lhs' => 68, 'rhs' => 3 ),
  array( 'lhs' => 68, 'rhs' => 3 ),
  array( 'lhs' => 68, 'rhs' => 3 ),
  array( 'lhs' => 68, 'rhs' => 1 ),
  array( 'lhs' => 68, 'rhs' => 1 ),
  array( 'lhs' => 55, 'rhs' => 3 ),
  array( 'lhs' => 55, 'rhs' => 1 ),
    );

    /**
     * The following table contains a mapping of reduce action to method name
     * that handles the reduction.
     * 
     * If a rule is not set, it has no handler.
     */
    static public $yyReduceMap = array(
        0 => 0,
        1 => 1,
        2 => 2,
        3 => 3,
        9 => 3,
        10 => 3,
        11 => 3,
        12 => 3,
        13 => 3,
        14 => 3,
        16 => 3,
        17 => 3,
        25 => 3,
        50 => 3,
        57 => 3,
        58 => 3,
        60 => 3,
        4 => 4,
        5 => 5,
        6 => 6,
        7 => 7,
        8 => 8,
        15 => 15,
        18 => 18,
        19 => 19,
        20 => 20,
        21 => 21,
        22 => 22,
        23 => 23,
        24 => 24,
        26 => 26,
        27 => 27,
        28 => 28,
        29 => 29,
        30 => 30,
        31 => 31,
        32 => 32,
        33 => 33,
        34 => 34,
        35 => 35,
        36 => 36,
        37 => 37,
        38 => 38,
        39 => 39,
        40 => 40,
        43 => 40,
        41 => 41,
        44 => 41,
        42 => 42,
        45 => 45,
        46 => 46,
        47 => 47,
        48 => 47,
        49 => 49,
        51 => 51,
        52 => 52,
        53 => 52,
        54 => 52,
        55 => 52,
        56 => 52,
        59 => 59,
    );
    /* Beginning here are the reduction cases.  A typical example
    ** follows:
    **  #line <lineno> <grammarfile>
    **   function yy_r0($yymsp){ ... }           // User supplied code
    **  #line <lineno> <thisfile>
    */
#line 30 "parser.y"
    function yy_r0(){ $this->body = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1240 "parser.php"
#line 32 "parser.y"
    function yy_r1(){ $this->_retvalue=$this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1243 "parser.php"
#line 33 "parser.y"
    function yy_r2(){ $this->_retvalue = array();     }
#line 1246 "parser.php"
#line 36 "parser.y"
    function yy_r3(){ $this->_retvalue = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1249 "parser.php"
#line 37 "parser.y"
    function yy_r4(){ $this->_retvalue = array('operation' => 'html', 'html' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1252 "parser.php"
#line 38 "parser.y"
    function yy_r5(){ $this->yystack[$this->yyidx + 0]->minor=rtrim($this->yystack[$this->yyidx + 0]->minor); $this->_retvalue = array('operation' => 'comment', 'comment' => substr($this->yystack[$this->yyidx + 0]->minor, 0, strlen($this->yystack[$this->yyidx + 0]->minor)-2));     }
#line 1255 "parser.php"
#line 39 "parser.y"
    function yy_r6(){ $this->_retvalue = array('operation' => 'print', 'variable' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1258 "parser.php"
#line 41 "parser.y"
    function yy_r7(){ $this->_retvalue = array('operation' => 'base', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1261 "parser.php"
#line 42 "parser.y"
    function yy_r8(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1264 "parser.php"
#line 49 "parser.y"
    function yy_r15(){ $this->_retvalue = array('operation' => 'include', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1267 "parser.php"
#line 56 "parser.y"
    function yy_r18(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -1]->minor, 'list'=>array());     }
#line 1270 "parser.php"
#line 57 "parser.y"
    function yy_r19(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -3]->minor, 'for' => $this->yystack[$this->yyidx + -1]->minor, 'list' => array());     }
#line 1273 "parser.php"
#line 58 "parser.y"
    function yy_r20(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'for' => $this->yystack[$this->yyidx + -3]->minor, 'list' => array(),'as' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1276 "parser.php"
#line 59 "parser.y"
    function yy_r21(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -3]->minor, 'as' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1279 "parser.php"
#line 60 "parser.y"
    function yy_r22(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -2]->minor, 'list' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1282 "parser.php"
#line 61 "parser.y"
    function yy_r23(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -4]->minor, 'as' => $this->yystack[$this->yyidx + -1]->minor, 'list' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1285 "parser.php"
#line 64 "parser.y"
    function yy_r24(){ $this->_retvalue = array('operation' => 'alias', 'var' => $this->yystack[$this->yyidx + -7]->minor, 'as' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1288 "parser.php"
#line 70 "parser.y"
    function yy_r26(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -7]->minor, 'array' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1293 "parser.php"
#line 73 "parser.y"
    function yy_r27(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -11]->minor, 'array' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'empty' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1298 "parser.php"
#line 77 "parser.y"
    function yy_r28(){ $this->_retvalue = array('operation' => 'if', 'expr' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1301 "parser.php"
#line 78 "parser.y"
    function yy_r29(){ $this->_retvalue = array('operation' => 'if', 'expr' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1304 "parser.php"
#line 81 "parser.y"
    function yy_r30(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1309 "parser.php"
#line 85 "parser.y"
    function yy_r31(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -3]->minor, 'check' => $this->yystack[$this->yyidx + -5]->minor);
    }
#line 1314 "parser.php"
#line 88 "parser.y"
    function yy_r32(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1319 "parser.php"
#line 92 "parser.y"
    function yy_r33(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -7]->minor, 'check' => $this->yystack[$this->yyidx + -9]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);
    }
#line 1324 "parser.php"
#line 97 "parser.y"
    function yy_r34(){ if ('end'.$this->yystack[$this->yyidx + -5]->minor != $this->yystack[$this->yyidx + -1]->minor) { throw new Exception("Unexpected ".$this->yystack[$this->yyidx + -1]->minor); } $this->_retvalue = array('operation' => 'filter', 'functions' => array(array('var'=>$this->yystack[$this->yyidx + -5]->minor)), 'body' => $this->yystack[$this->yyidx + -3]->minor);    }
#line 1327 "parser.php"
#line 100 "parser.y"
    function yy_r35(){ $this->_retvalue = array('operation' => 'block', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1330 "parser.php"
#line 102 "parser.y"
    function yy_r36(){ $this->_retvalue = array('operation' => 'block', 'name' => $this->yystack[$this->yyidx + -6]->minor, 'body' => $this->yystack[$this->yyidx + -4]->minor);     }
#line 1333 "parser.php"
#line 105 "parser.y"
    function yy_r37(){ $this->_retvalue = array('operation' => 'filter', 'functions' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1336 "parser.php"
#line 109 "parser.y"
    function yy_r38(){ $this->_retvalue = array('operation' => 'cycle', 'vars' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1339 "parser.php"
#line 110 "parser.y"
    function yy_r39(){ $this->_retvalue = array('operation' => 'cycle', 'vars' => $this->yystack[$this->yyidx + -2]->minor, 'as' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1342 "parser.php"
#line 113 "parser.y"
    function yy_r40(){ $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1345 "parser.php"
#line 114 "parser.y"
    function yy_r41(){ $this->_retvalue = array($this->yystack[$this->yyidx + 0]->minor);     }
#line 1348 "parser.php"
#line 117 "parser.y"
    function yy_r42(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1351 "parser.php"
#line 121 "parser.y"
    function yy_r45(){ $this->_retvalue = array('var' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1354 "parser.php"
#line 122 "parser.y"
    function yy_r46(){ $this->_retvalue = array('string' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1357 "parser.php"
#line 124 "parser.y"
    function yy_r47(){  $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1360 "parser.php"
#line 126 "parser.y"
    function yy_r49(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor.$this->yystack[$this->yyidx + 0]->minor;     }
#line 1363 "parser.php"
#line 130 "parser.y"
    function yy_r51(){ $this->_retvalue = array('op' => 'expr', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1366 "parser.php"
#line 131 "parser.y"
    function yy_r52(){ $this->_retvalue = array('op' => @$this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1369 "parser.php"
#line 141 "parser.y"
    function yy_r59(){ if (!is_array($this->yystack[$this->yyidx + -2]->minor)) { $this->_retvalue = array($this->yystack[$this->yyidx + -2]->minor); } else { $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; }  $this->_retvalue[]=$this->yystack[$this->yyidx + 0]->minor;    }
#line 1372 "parser.php"

    /**
     * placeholder for the left hand side in a reduce operation.
     * 
     * For a parser with a rule like this:
     * <pre>
     * rule(A) ::= B. { A = 1; }
     * </pre>
     * 
     * The parser will translate to something like:
     * 
     * <code>
     * function yy_r0(){$this->_retvalue = 1;}
     * </code>
     */
    private $_retvalue;

    /**
     * Perform a reduce action and the shift that must immediately
     * follow the reduce.
     * 
     * For a rule such as:
     * 
     * <pre>
     * A ::= B blah C. { dosomething(); }
     * </pre>
     * 
     * This function will first call the action, if any, ("dosomething();" in our
     * example), and then it will pop three states from the stack,
     * one for each entry on the right-hand side of the expression
     * (B, blah, and C in our example rule), and then push the result of the action
     * back on to the stack with the resulting state reduced to (as described in the .out
     * file)
     * @param int Number of the rule by which to reduce
     */
    function yy_reduce($yyruleno)
    {
        //int $yygoto;                     /* The next state */
        //int $yyact;                      /* The next action */
        //mixed $yygotominor;        /* The LHS of the rule reduced */
        //Haanga_yyStackEntry $yymsp;            /* The top of the parser's stack */
        //int $yysize;                     /* Amount to pop the stack */
        $yymsp = $this->yystack[$this->yyidx];
        if (self::$yyTraceFILE && $yyruleno >= 0 
              && $yyruleno < count(self::$yyRuleName)) {
            fprintf(self::$yyTraceFILE, "%sReduce (%d) [%s].\n",
                self::$yyTracePrompt, $yyruleno,
                self::$yyRuleName[$yyruleno]);
        }

        $this->_retvalue = $yy_lefthand_side = null;
        if (array_key_exists($yyruleno, self::$yyReduceMap)) {
            // call the action
            $this->_retvalue = null;
            $this->{'yy_r' . self::$yyReduceMap[$yyruleno]}();
            $yy_lefthand_side = $this->_retvalue;
        }
        $yygoto = self::$yyRuleInfo[$yyruleno]['lhs'];
        $yysize = self::$yyRuleInfo[$yyruleno]['rhs'];
        $this->yyidx -= $yysize;
        for($i = $yysize; $i; $i--) {
            // pop all of the right-hand side parameters
            array_pop($this->yystack);
        }
        $yyact = $this->yy_find_reduce_action($this->yystack[$this->yyidx]->stateno, $yygoto);
        if ($yyact < self::YYNSTATE) {
            /* If we are not debugging and the reduce action popped at least
            ** one element off the stack, then we can push the new element back
            ** onto the stack here, and skip the stack overflow test in yy_shift().
            ** That gives a significant speed improvement. */
            if (!self::$yyTraceFILE && $yysize) {
                $this->yyidx++;
                $x = new Haanga_yyStackEntry;
                $x->stateno = $yyact;
                $x->major = $yygoto;
                $x->minor = $yy_lefthand_side;
                $this->yystack[$this->yyidx] = $x;
            } else {
                $this->yy_shift($yyact, $yygoto, $yy_lefthand_side);
            }
        } elseif ($yyact == self::YYNSTATE + self::YYNRULE + 1) {
            $this->yy_accept();
        }
    }

    /**
     * The following code executes when the parse fails
     * 
     * Code from %parse_fail is inserted here
     */
    function yy_parse_failed()
    {
        if (self::$yyTraceFILE) {
            fprintf(self::$yyTraceFILE, "%sFail!\n", self::$yyTracePrompt);
        }
        while ($this->yyidx >= 0) {
            $this->yy_pop_parser_stack();
        }
        /* Here code is inserted which will be executed whenever the
        ** parser fails */
    }

    /**
     * The following code executes when a syntax error first occurs.
     * 
     * %syntax_error code is inserted here
     * @param int The major type of the error token
     * @param mixed The minor type of the error token
     */
    function yy_syntax_error($yymajor, $TOKEN)
    {
#line 20 "parser.y"

    $expect = array();
    foreach ($this->yy_get_expected_tokens($yymajor) as $token) {
        $expect[] = self::$yyTokenName[$token];
    }
    throw new Exception('Unexpected ' . $this->tokenName($yymajor) . '(' . $TOKEN. '), expected one of: ' . implode(',', $expect));
#line 1492 "parser.php"
    }

    /**
     * The following is executed when the parser accepts
     * 
     * %parse_accept code is inserted here
     */
    function yy_accept()
    {
        if (self::$yyTraceFILE) {
            fprintf(self::$yyTraceFILE, "%sAccept!\n", self::$yyTracePrompt);
        }
        while ($this->yyidx >= 0) {
            $stack = $this->yy_pop_parser_stack();
        }
        /* Here code is inserted which will be executed whenever the
        ** parser accepts */
#line 11 "parser.y"

#line 1513 "parser.php"
    }

    /**
     * The main parser program.
     * 
     * The first argument is the major token number.  The second is
     * the token value string as scanned from the input.
     *
     * @param int the token number
     * @param mixed the token value
     * @param mixed any extra arguments that should be passed to handlers
     */
    function doParse($yymajor, $yytokenvalue)
    {
//        $yyact;            /* The parser action. */
//        $yyendofinput;     /* True if we are at the end of input */
        $yyerrorhit = 0;   /* True if yymajor has invoked an error */
        
        /* (re)initialize the parser, if necessary */
        if ($this->yyidx === null || $this->yyidx < 0) {
            /* if ($yymajor == 0) return; // not sure why this was here... */
            $this->yyidx = 0;
            $this->yyerrcnt = -1;
            $x = new Haanga_yyStackEntry;
            $x->stateno = 0;
            $x->major = 0;
            $this->yystack = array();
            array_push($this->yystack, $x);
        }
        $yyendofinput = ($yymajor==0);
        
        if (self::$yyTraceFILE) {
            fprintf(self::$yyTraceFILE, "%sInput %s\n",
                self::$yyTracePrompt, self::$yyTokenName[$yymajor]);
        }
        
        do {
            $yyact = $this->yy_find_shift_action($yymajor);
            if ($yymajor < self::YYERRORSYMBOL &&
                  !$this->yy_is_expected_token($yymajor)) {
                // force a syntax error
                $yyact = self::YY_ERROR_ACTION;
            }
            if ($yyact < self::YYNSTATE) {
                $this->yy_shift($yyact, $yymajor, $yytokenvalue);
                $this->yyerrcnt--;
                if ($yyendofinput && $this->yyidx >= 0) {
                    $yymajor = 0;
                } else {
                    $yymajor = self::YYNOCODE;
                }
            } elseif ($yyact < self::YYNSTATE + self::YYNRULE) {
                $this->yy_reduce($yyact - self::YYNSTATE);
            } elseif ($yyact == self::YY_ERROR_ACTION) {
                if (self::$yyTraceFILE) {
                    fprintf(self::$yyTraceFILE, "%sSyntax Error!\n",
                        self::$yyTracePrompt);
                }
                if (self::YYERRORSYMBOL) {
                    /* A syntax error has occurred.
                    ** The response to an error depends upon whether or not the
                    ** grammar defines an error token "ERROR".  
                    **
                    ** This is what we do if the grammar does define ERROR:
                    **
                    **  * Call the %syntax_error function.
                    **
                    **  * Begin popping the stack until we enter a state where
                    **    it is legal to shift the error symbol, then shift
                    **    the error symbol.
                    **
                    **  * Set the error count to three.
                    **
                    **  * Begin accepting and shifting new tokens.  No new error
                    **    processing will occur until three tokens have been
                    **    shifted successfully.
                    **
                    */
                    if ($this->yyerrcnt < 0) {
                        $this->yy_syntax_error($yymajor, $yytokenvalue);
                    }
                    $yymx = $this->yystack[$this->yyidx]->major;
                    if ($yymx == self::YYERRORSYMBOL || $yyerrorhit ){
                        if (self::$yyTraceFILE) {
                            fprintf(self::$yyTraceFILE, "%sDiscard input token %s\n",
                                self::$yyTracePrompt, self::$yyTokenName[$yymajor]);
                        }
                        $this->yy_destructor($yymajor, $yytokenvalue);
                        $yymajor = self::YYNOCODE;
                    } else {
                        while ($this->yyidx >= 0 &&
                                 $yymx != self::YYERRORSYMBOL &&
        ($yyact = $this->yy_find_shift_action(self::YYERRORSYMBOL)) >= self::YYNSTATE
                              ){
                            $this->yy_pop_parser_stack();
                        }
                        if ($this->yyidx < 0 || $yymajor==0) {
                            $this->yy_destructor($yymajor, $yytokenvalue);
                            $this->yy_parse_failed();
                            $yymajor = self::YYNOCODE;
                        } elseif ($yymx != self::YYERRORSYMBOL) {
                            $u2 = 0;
                            $this->yy_shift($yyact, self::YYERRORSYMBOL, $u2);
                        }
                    }
                    $this->yyerrcnt = 3;
                    $yyerrorhit = 1;
                } else {
                    /* YYERRORSYMBOL is not defined */
                    /* This is what we do if the grammar does not define ERROR:
                    **
                    **  * Report an error message, and throw away the input token.
                    **
                    **  * If the input token is $, then fail the parse.
                    **
                    ** As before, subsequent error messages are suppressed until
                    ** three input tokens have been successfully shifted.
                    */
                    if ($this->yyerrcnt <= 0) {
                        $this->yy_syntax_error($yymajor, $yytokenvalue);
                    }
                    $this->yyerrcnt = 3;
                    $this->yy_destructor($yymajor, $yytokenvalue);
                    if ($yyendofinput) {
                        $this->yy_parse_failed();
                    }
                    $yymajor = self::YYNOCODE;
                }
            } else {
                $this->yy_accept();
                $yymajor = self::YYNOCODE;
            }            
        } while ($yymajor != self::YYNOCODE && $this->yyidx >= 0);
    }
}