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
    const T_EXTENDS                      = 12;
    const T_CLOSE_TAG                    = 13;
    const T_PRINT_OPEN                   = 14;
    const T_PRINT_CLOSE                  = 15;
    const T_HTML                         = 16;
    const T_COMMENT_OPEN                 = 17;
    const T_COMMENT                      = 18;
    const T_INCLUDE                      = 19;
    const T_FOR                          = 20;
    const T_IN                           = 21;
    const T_CLOSEFOR                     = 22;
    const T_EMPTY                        = 23;
    const T_IF                           = 24;
    const T_ENDIF                        = 25;
    const T_ELSE                         = 26;
    const T_IFCHANGED                    = 27;
    const T_ENDIFCHANGED                 = 28;
    const T_CUSTOM_END                   = 29;
    const T_BLOCK                        = 30;
    const T_END_BLOCK                    = 31;
    const T_FILTER                       = 32;
    const T_END_FILTER                   = 33;
    const T_CYCLE                        = 34;
    const T_AS                           = 35;
    const T_PIPE                         = 36;
    const T_STRING_SINGLE_INIT           = 37;
    const T_STRING_SINGLE_END            = 38;
    const T_STRING_DOUBLE_INIT           = 39;
    const T_STRING_DOUBLE_END            = 40;
    const T_STRING_CONTENT               = 41;
    const T_LPARENT                      = 42;
    const T_RPARENT                      = 43;
    const T_NUMERIC                      = 44;
    const T_DOT                          = 45;
    const T_ALPHA                        = 46;
    const YY_NO_ACTION = 190;
    const YY_ACCEPT_ACTION = 189;
    const YY_ERROR_ACTION = 188;

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
    const YY_SZ_ACTTAB = 367;
static public $yy_action = array(
 /*     0 */    38,   44,   54,   85,   77,   19,   58,   46,   21,   38,
 /*    10 */    44,   42,  113,   22,   19,   23,   79,   21,   80,  117,
 /*    20 */    42,   47,   22,   45,   23,   39,   15,  100,   99,  103,
 /*    30 */   100,   95,  110,   38,   44,  189,  100,    7,   19,   93,
 /*    40 */    91,   21,   38,   44,   42,  100,   22,   19,   23,   97,
 /*    50 */    21,   94,   57,   42,   90,   22,   40,   23,  101,  110,
 /*    60 */   100,   16,   16,   18,   18,   20,   20,   20,  122,  100,
 /*    70 */   119,   17,   14,   16,   16,   18,   18,   20,   20,   20,
 /*    80 */    20,   20,   20,   60,   95,   17,   14,   16,   16,   18,
 /*    90 */    18,   20,   20,   20,   38,   44,   51,    3,   31,   19,
 /*   100 */   109,   48,   21,  135,   82,   42,   41,   22,   50,   23,
 /*   110 */   133,   38,   44,   95,   96,  120,   19,   53,  112,   21,
 /*   120 */    84,  100,   42,   37,   22,  104,   23,  107,   95,   38,
 /*   130 */    44,   59,  121,   56,   19,  134,    1,   21,  100,   87,
 /*   140 */    42,   47,   22,   45,   23,  123,   38,   44,   95,  137,
 /*   150 */   100,   19,   92,   96,   21,   55,  100,   42,   43,   22,
 /*   160 */    47,   23,   45,   73,  104,   95,   38,   44,  131,  100,
 /*   170 */   115,   19,   98,  100,   21,   88,   47,   42,   45,   22,
 /*   180 */    72,   23,   78,   70,  102,  100,   38,   44,  118,   86,
 /*   190 */   105,   19,  116,  100,   21,   38,   44,   42,  124,   22,
 /*   200 */    19,   23,   95,   21,   49,  108,   42,   71,   22,   76,
 /*   210 */    23,  114,  100,  100,  136,  132,  127,  126,  128,  129,
 /*   220 */     8,   74,  100,    9,   12,   14,   16,   16,   18,   18,
 /*   230 */    20,   20,   20,   38,   44,  125,   68,   25,   19,   96,
 /*   240 */    48,   21,  135,   82,   42,    5,   22,   81,   23,   28,
 /*   250 */   104,   96,   48,   29,  135,   82,   48,   67,  135,   82,
 /*   260 */   100,   26,  104,   83,   48,   33,  135,   82,   48,  111,
 /*   270 */   135,   82,   34,   96,   75,   48,  111,  135,   82,   10,
 /*   280 */    96,   63,  111,  111,  104,   69,   96,   96,   61,    6,
 /*   290 */     4,  104,  118,    2,   64,   62,   24,  104,  104,   48,
 /*   300 */    35,  135,   82,   48,  111,  135,   82,   13,   96,  111,
 /*   310 */    52,  118,   30,   96,   11,   48,   65,  135,   82,  104,
 /*   320 */   118,   66,  133,  130,  104,   27,   96,   96,   48,  118,
 /*   330 */   135,   82,  118,  118,   47,   36,   45,  104,  104,  118,
 /*   340 */   118,  118,   32,  100,  118,   48,  118,  135,   82,  111,
 /*   350 */   118,   89,  118,   96,  118,   96,  118,  118,  118,  118,
 /*   360 */   118,  106,  118,  118,  104,  118,  104,
    );
    static public $yy_lookahead = array(
 /*     0 */    19,   20,   13,   22,   23,   24,   13,   21,   27,   19,
 /*    10 */    20,   30,   13,   32,   24,   34,   26,   27,   28,   13,
 /*    20 */    30,   37,   32,   39,   34,   36,   42,   46,   44,   38,
 /*    30 */    46,   45,   41,   19,   20,   48,   46,   50,   24,   25,
 /*    40 */    26,   27,   19,   20,   30,   46,   32,   24,   34,   26,
 /*    50 */    27,   28,   13,   30,   11,   32,   12,   34,   40,   41,
 /*    60 */    46,    3,    4,    5,    6,    7,    8,    9,   13,   46,
 /*    70 */    13,    1,    2,    3,    4,    5,    6,    7,    8,    9,
 /*    80 */     7,    8,    9,   13,   45,    1,    2,    3,    4,    5,
 /*    90 */     6,    7,    8,    9,   19,   20,   13,   50,   11,   24,
 /*   100 */    46,   14,   27,   16,   17,   30,   31,   32,   13,   34,
 /*   110 */    49,   19,   20,   45,   53,   13,   24,   13,   15,   27,
 /*   120 */    28,   46,   30,   62,   32,   64,   34,   43,   45,   19,
 /*   130 */    20,   13,   13,   13,   24,   13,   50,   27,   46,   29,
 /*   140 */    30,   37,   32,   39,   34,   13,   19,   20,   45,   49,
 /*   150 */    46,   24,   25,   53,   27,   13,   46,   30,   35,   32,
 /*   160 */    37,   34,   39,   63,   64,   45,   19,   20,   18,   46,
 /*   170 */    13,   24,   13,   46,   27,   28,   37,   30,   39,   32,
 /*   180 */    65,   34,   52,   53,   13,   46,   19,   20,   13,   22,
 /*   190 */    60,   24,   13,   46,   27,   19,   20,   30,   13,   32,
 /*   200 */    24,   34,   45,   27,   13,   41,   30,   53,   32,   33,
 /*   210 */    34,   51,   46,   46,   54,   55,   56,   57,   58,   59,
 /*   220 */    50,   65,   46,   50,   50,    2,    3,    4,    5,    6,
 /*   230 */     7,    8,    9,   19,   20,   49,   53,   11,   24,   53,
 /*   240 */    14,   27,   16,   17,   30,   50,   32,   49,   34,   11,
 /*   250 */    64,   53,   14,   11,   16,   17,   14,   53,   16,   17,
 /*   260 */    46,   11,   64,   53,   14,   11,   16,   17,   14,   49,
 /*   270 */    16,   17,   11,   53,   53,   14,   49,   16,   17,   50,
 /*   280 */    53,   61,   49,   49,   64,   53,   53,   53,   61,   50,
 /*   290 */    50,   64,   66,   50,   61,   61,   11,   64,   64,   14,
 /*   300 */    11,   16,   17,   14,   49,   16,   17,   50,   53,   49,
 /*   310 */    13,   66,   11,   53,   50,   14,   61,   16,   17,   64,
 /*   320 */    66,   61,   49,   49,   64,   11,   53,   53,   14,   66,
 /*   330 */    16,   17,   66,   66,   37,   62,   39,   64,   64,   66,
 /*   340 */    66,   66,   11,   46,   66,   14,   66,   16,   17,   49,
 /*   350 */    66,   49,   66,   53,   66,   53,   66,   66,   66,   66,
 /*   360 */    66,   61,   66,   66,   64,   66,   64,
);
    const YY_SHIFT_USE_DFLT = -20;
    const YY_SHIFT_MAX = 97;
    static public $yy_shift_ofst = array(
 /*     0 */    43,  226,  254,  250,  242,   87,  238,  289,  331,  314,
 /*    10 */   301,  285,  261,  289,  -16,  -16,  -16,  -16,  -16,  -16,
 /*    20 */   -16,  297,  139,  139,  -19,   23,   14,  -10,   75,  167,
 /*    30 */   176,  147,   92,  127,  110,  214,  104,  123,  139,  139,
 /*    40 */   139,   -1,  166,  166,  166,  164,  166,  164,  166,  -20,
 /*    50 */   -20,  -20,  -20,  -20,  -20,  -20,  -20,  -20,  -20,  -20,
 /*    60 */   -20,   70,   84,  223,   58,   58,   73,  157,  120,  103,
 /*    70 */    83,   39,   -9,  -11,   18,  -14,    6,   -7,   55,  191,
 /*    80 */   159,  142,  150,   68,  171,  185,  179,  175,  132,  122,
 /*    90 */    44,  118,  102,   57,  119,   54,   68,   95,
);
    const YY_REDUCE_USE_DFLT = -14;
    const YY_REDUCE_MAX = 60;
    static public $yy_reduce_ofst = array(
 /*     0 */   -13,  160,  160,  160,  160,  160,  160,  160,  160,  160,
 /*    10 */   160,  160,  160,  160,  255,  234,  233,  220,  260,  227,
 /*    20 */   300,  273,  100,   61,  130,  130,  130,  130,  130,  130,
 /*    30 */   130,  130,  130,  130,  130,  130,  186,  186,  302,  274,
 /*    40 */   198,  204,  183,  210,  221,  156,  154,  115,  232,  170,
 /*    50 */   195,  174,   86,  173,  229,  257,  239,  264,  240,  243,
 /*    60 */    47,
);
    static public $yyExpectedTokens = array(
        /* 0 */ array(11, ),
        /* 1 */ array(11, 14, 16, 17, ),
        /* 2 */ array(11, 14, 16, 17, ),
        /* 3 */ array(11, 14, 16, 17, ),
        /* 4 */ array(11, 14, 16, 17, ),
        /* 5 */ array(11, 14, 16, 17, ),
        /* 6 */ array(11, 14, 16, 17, ),
        /* 7 */ array(11, 14, 16, 17, ),
        /* 8 */ array(11, 14, 16, 17, ),
        /* 9 */ array(11, 14, 16, 17, ),
        /* 10 */ array(11, 14, 16, 17, ),
        /* 11 */ array(11, 14, 16, 17, ),
        /* 12 */ array(11, 14, 16, 17, ),
        /* 13 */ array(11, 14, 16, 17, ),
        /* 14 */ array(37, 39, 42, 44, 46, ),
        /* 15 */ array(37, 39, 42, 44, 46, ),
        /* 16 */ array(37, 39, 42, 44, 46, ),
        /* 17 */ array(37, 39, 42, 44, 46, ),
        /* 18 */ array(37, 39, 42, 44, 46, ),
        /* 19 */ array(37, 39, 42, 44, 46, ),
        /* 20 */ array(37, 39, 42, 44, 46, ),
        /* 21 */ array(13, 37, 39, 46, ),
        /* 22 */ array(37, 39, 46, ),
        /* 23 */ array(37, 39, 46, ),
        /* 24 */ array(19, 20, 22, 23, 24, 27, 30, 32, 34, 46, ),
        /* 25 */ array(19, 20, 24, 26, 27, 28, 30, 32, 34, 46, ),
        /* 26 */ array(19, 20, 24, 25, 26, 27, 30, 32, 34, 46, ),
        /* 27 */ array(19, 20, 24, 26, 27, 28, 30, 32, 34, 46, ),
        /* 28 */ array(19, 20, 24, 27, 30, 31, 32, 34, 46, ),
        /* 29 */ array(19, 20, 22, 24, 27, 30, 32, 34, 46, ),
        /* 30 */ array(19, 20, 24, 27, 30, 32, 33, 34, 46, ),
        /* 31 */ array(19, 20, 24, 27, 28, 30, 32, 34, 46, ),
        /* 32 */ array(19, 20, 24, 27, 28, 30, 32, 34, 46, ),
        /* 33 */ array(19, 20, 24, 25, 27, 30, 32, 34, 46, ),
        /* 34 */ array(19, 20, 24, 27, 29, 30, 32, 34, 46, ),
        /* 35 */ array(19, 20, 24, 27, 30, 32, 34, 46, ),
        /* 36 */ array(13, 37, 39, 46, ),
        /* 37 */ array(35, 37, 39, 46, ),
        /* 38 */ array(37, 39, 46, ),
        /* 39 */ array(37, 39, 46, ),
        /* 40 */ array(37, 39, 46, ),
        /* 41 */ array(13, 46, ),
        /* 42 */ array(46, ),
        /* 43 */ array(46, ),
        /* 44 */ array(46, ),
        /* 45 */ array(41, ),
        /* 46 */ array(46, ),
        /* 47 */ array(41, ),
        /* 48 */ array(46, ),
        /* 49 */ array(),
        /* 50 */ array(),
        /* 51 */ array(),
        /* 52 */ array(),
        /* 53 */ array(),
        /* 54 */ array(),
        /* 55 */ array(),
        /* 56 */ array(),
        /* 57 */ array(),
        /* 58 */ array(),
        /* 59 */ array(),
        /* 60 */ array(),
        /* 61 */ array(1, 2, 3, 4, 5, 6, 7, 8, 9, 13, ),
        /* 62 */ array(1, 2, 3, 4, 5, 6, 7, 8, 9, 43, ),
        /* 63 */ array(2, 3, 4, 5, 6, 7, 8, 9, ),
        /* 64 */ array(3, 4, 5, 6, 7, 8, 9, ),
        /* 65 */ array(3, 4, 5, 6, 7, 8, 9, ),
        /* 66 */ array(7, 8, 9, ),
        /* 67 */ array(13, 45, ),
        /* 68 */ array(13, 45, ),
        /* 69 */ array(15, 45, ),
        /* 70 */ array(13, 45, ),
        /* 71 */ array(13, 45, ),
        /* 72 */ array(38, 41, ),
        /* 73 */ array(13, 36, ),
        /* 74 */ array(40, 41, ),
        /* 75 */ array(21, 45, ),
        /* 76 */ array(13, ),
        /* 77 */ array(13, ),
        /* 78 */ array(13, ),
        /* 79 */ array(13, ),
        /* 80 */ array(13, ),
        /* 81 */ array(13, ),
        /* 82 */ array(18, ),
        /* 83 */ array(45, ),
        /* 84 */ array(13, ),
        /* 85 */ array(13, ),
        /* 86 */ array(13, ),
        /* 87 */ array(13, ),
        /* 88 */ array(13, ),
        /* 89 */ array(13, ),
        /* 90 */ array(12, ),
        /* 91 */ array(13, ),
        /* 92 */ array(13, ),
        /* 93 */ array(13, ),
        /* 94 */ array(13, ),
        /* 95 */ array(46, ),
        /* 96 */ array(45, ),
        /* 97 */ array(13, ),
        /* 98 */ array(),
        /* 99 */ array(),
        /* 100 */ array(),
        /* 101 */ array(),
        /* 102 */ array(),
        /* 103 */ array(),
        /* 104 */ array(),
        /* 105 */ array(),
        /* 106 */ array(),
        /* 107 */ array(),
        /* 108 */ array(),
        /* 109 */ array(),
        /* 110 */ array(),
        /* 111 */ array(),
        /* 112 */ array(),
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
);
    static public $yy_default = array(
 /*     0 */   141,  188,  188,  188,  188,  188,  188,  139,  188,  188,
 /*    10 */   188,  188,  188,  138,  188,  188,  188,  188,  188,  188,
 /*    20 */   188,  188,  188,  188,  188,  188,  188,  188,  188,  188,
 /*    30 */   188,  188,  188,  188,  188,  188,  188,  166,  188,  188,
 /*    40 */   188,  188,  188,  188,  188,  188,  188,  188,  188,  141,
 /*    50 */   141,  141,  141,  141,  141,  141,  141,  141,  141,  141,
 /*    60 */   141,  188,  188,  179,  181,  180,  183,  188,  188,  188,
 /*    70 */   188,  188,  188,  188,  188,  188,  188,  188,  188,  188,
 /*    80 */   188,  188,  188,  167,  188,  188,  188,  188,  188,  188,
 /*    90 */   188,  188,  188,  188,  188,  188,  172,  188,  159,  185,
 /*   100 */   187,  175,  161,  174,  173,  153,  182,  178,  177,  186,
 /*   110 */   176,  184,  143,  163,  140,  164,  155,  165,  162,  156,
 /*   120 */   157,  158,  142,  160,  154,  170,  149,  148,  150,  151,
 /*   130 */   168,  147,  146,  171,  152,  144,  145,  169,
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
    const YYNOCODE = 67;
    const YYSTACKDEPTH = 100;
    const YYNSTATE = 138;
    const YYNRULE = 50;
    const YYERRORSYMBOL = 47;
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
  'T_EXTENDS',     'T_CLOSE_TAG',   'T_PRINT_OPEN',  'T_PRINT_CLOSE',
  'T_HTML',        'T_COMMENT_OPEN',  'T_COMMENT',     'T_INCLUDE',   
  'T_FOR',         'T_IN',          'T_CLOSEFOR',    'T_EMPTY',     
  'T_IF',          'T_ENDIF',       'T_ELSE',        'T_IFCHANGED', 
  'T_ENDIFCHANGED',  'T_CUSTOM_END',  'T_BLOCK',       'T_END_BLOCK', 
  'T_FILTER',      'T_END_FILTER',  'T_CYCLE',       'T_AS',        
  'T_PIPE',        'T_STRING_SINGLE_INIT',  'T_STRING_SINGLE_END',  'T_STRING_DOUBLE_INIT',
  'T_STRING_DOUBLE_END',  'T_STRING_CONTENT',  'T_LPARENT',     'T_RPARENT',   
  'T_NUMERIC',     'T_DOT',         'T_ALPHA',       'error',       
  'start',         'var_or_string',  'body',          'stmts',       
  'stmt',          'varname',       'for_stmt',      'ifchanged_stmt',
  'block_stmt',    'filter_stmt',   'custom_stmt',   'if_stmt',     
  'cycle',         'expr',          'list',          'piped_list',  
  'string',        's_content',   
    );

    /**
     * For tracing reduce actions, the names of all rules are required.
     * @var array
     */
    static public $yyRuleName = array(
 /*   0 */ "start ::= T_OPEN_TAG T_EXTENDS var_or_string T_CLOSE_TAG body",
 /*   1 */ "start ::= body",
 /*   2 */ "body ::= body stmts",
 /*   3 */ "body ::=",
 /*   4 */ "stmts ::= T_OPEN_TAG stmt T_CLOSE_TAG",
 /*   5 */ "stmts ::= T_PRINT_OPEN varname T_PRINT_CLOSE",
 /*   6 */ "stmts ::= T_HTML",
 /*   7 */ "stmts ::= for_stmt",
 /*   8 */ "stmts ::= ifchanged_stmt",
 /*   9 */ "stmts ::= T_COMMENT_OPEN T_COMMENT",
 /*  10 */ "stmts ::= block_stmt",
 /*  11 */ "stmts ::= filter_stmt",
 /*  12 */ "stmts ::= custom_stmt",
 /*  13 */ "stmts ::= if_stmt",
 /*  14 */ "stmts ::= T_OPEN_TAG T_INCLUDE var_or_string T_CLOSE_TAG",
 /*  15 */ "stmt ::= cycle",
 /*  16 */ "for_stmt ::= T_OPEN_TAG T_FOR varname T_IN varname T_CLOSE_TAG body T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG",
 /*  17 */ "for_stmt ::= T_OPEN_TAG T_FOR varname T_IN varname T_CLOSE_TAG body T_OPEN_TAG T_EMPTY T_CLOSE_TAG body T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG",
 /*  18 */ "if_stmt ::= T_OPEN_TAG T_IF expr T_CLOSE_TAG body T_OPEN_TAG T_ENDIF T_CLOSE_TAG",
 /*  19 */ "if_stmt ::= T_OPEN_TAG T_IF expr T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIF T_CLOSE_TAG",
 /*  20 */ "ifchanged_stmt ::= T_OPEN_TAG T_IFCHANGED T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  21 */ "ifchanged_stmt ::= T_OPEN_TAG T_IFCHANGED list T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  22 */ "ifchanged_stmt ::= T_OPEN_TAG T_IFCHANGED T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  23 */ "ifchanged_stmt ::= T_OPEN_TAG T_IFCHANGED list T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  24 */ "custom_stmt ::= T_OPEN_TAG varname T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  25 */ "block_stmt ::= T_OPEN_TAG T_BLOCK varname T_CLOSE_TAG body T_OPEN_TAG T_END_BLOCK T_CLOSE_TAG",
 /*  26 */ "block_stmt ::= T_OPEN_TAG T_BLOCK varname T_CLOSE_TAG body T_OPEN_TAG T_END_BLOCK varname T_CLOSE_TAG",
 /*  27 */ "filter_stmt ::= T_OPEN_TAG T_FILTER piped_list T_CLOSE_TAG body T_OPEN_TAG T_END_FILTER T_CLOSE_TAG",
 /*  28 */ "cycle ::= T_CYCLE list",
 /*  29 */ "cycle ::= T_CYCLE list T_AS varname",
 /*  30 */ "piped_list ::= piped_list T_PIPE var_or_string",
 /*  31 */ "piped_list ::= var_or_string",
 /*  32 */ "list ::= list var_or_string",
 /*  33 */ "list ::= var_or_string",
 /*  34 */ "var_or_string ::= varname",
 /*  35 */ "var_or_string ::= string",
 /*  36 */ "string ::= T_STRING_SINGLE_INIT s_content T_STRING_SINGLE_END",
 /*  37 */ "string ::= T_STRING_DOUBLE_INIT s_content T_STRING_DOUBLE_END",
 /*  38 */ "s_content ::= s_content T_STRING_CONTENT",
 /*  39 */ "s_content ::= T_STRING_CONTENT",
 /*  40 */ "expr ::= T_LPARENT expr T_RPARENT",
 /*  41 */ "expr ::= expr T_AND expr",
 /*  42 */ "expr ::= expr T_OR expr",
 /*  43 */ "expr ::= expr T_EQ|T_NE expr",
 /*  44 */ "expr ::= expr T_TIMES|T_DIV|T_MOD expr",
 /*  45 */ "expr ::= expr T_PLUS|T_MINUS expr",
 /*  46 */ "expr ::= var_or_string",
 /*  47 */ "expr ::= T_NUMERIC",
 /*  48 */ "varname ::= varname T_DOT T_ALPHA",
 /*  49 */ "varname ::= T_ALPHA",
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
  array( 'lhs' => 48, 'rhs' => 5 ),
  array( 'lhs' => 48, 'rhs' => 1 ),
  array( 'lhs' => 50, 'rhs' => 2 ),
  array( 'lhs' => 50, 'rhs' => 0 ),
  array( 'lhs' => 51, 'rhs' => 3 ),
  array( 'lhs' => 51, 'rhs' => 3 ),
  array( 'lhs' => 51, 'rhs' => 1 ),
  array( 'lhs' => 51, 'rhs' => 1 ),
  array( 'lhs' => 51, 'rhs' => 1 ),
  array( 'lhs' => 51, 'rhs' => 2 ),
  array( 'lhs' => 51, 'rhs' => 1 ),
  array( 'lhs' => 51, 'rhs' => 1 ),
  array( 'lhs' => 51, 'rhs' => 1 ),
  array( 'lhs' => 51, 'rhs' => 1 ),
  array( 'lhs' => 51, 'rhs' => 4 ),
  array( 'lhs' => 52, 'rhs' => 1 ),
  array( 'lhs' => 54, 'rhs' => 10 ),
  array( 'lhs' => 54, 'rhs' => 14 ),
  array( 'lhs' => 59, 'rhs' => 8 ),
  array( 'lhs' => 59, 'rhs' => 12 ),
  array( 'lhs' => 55, 'rhs' => 7 ),
  array( 'lhs' => 55, 'rhs' => 8 ),
  array( 'lhs' => 55, 'rhs' => 11 ),
  array( 'lhs' => 55, 'rhs' => 12 ),
  array( 'lhs' => 58, 'rhs' => 7 ),
  array( 'lhs' => 56, 'rhs' => 8 ),
  array( 'lhs' => 56, 'rhs' => 9 ),
  array( 'lhs' => 57, 'rhs' => 8 ),
  array( 'lhs' => 60, 'rhs' => 2 ),
  array( 'lhs' => 60, 'rhs' => 4 ),
  array( 'lhs' => 63, 'rhs' => 3 ),
  array( 'lhs' => 63, 'rhs' => 1 ),
  array( 'lhs' => 62, 'rhs' => 2 ),
  array( 'lhs' => 62, 'rhs' => 1 ),
  array( 'lhs' => 49, 'rhs' => 1 ),
  array( 'lhs' => 49, 'rhs' => 1 ),
  array( 'lhs' => 64, 'rhs' => 3 ),
  array( 'lhs' => 64, 'rhs' => 3 ),
  array( 'lhs' => 65, 'rhs' => 2 ),
  array( 'lhs' => 65, 'rhs' => 1 ),
  array( 'lhs' => 61, 'rhs' => 3 ),
  array( 'lhs' => 61, 'rhs' => 3 ),
  array( 'lhs' => 61, 'rhs' => 3 ),
  array( 'lhs' => 61, 'rhs' => 3 ),
  array( 'lhs' => 61, 'rhs' => 3 ),
  array( 'lhs' => 61, 'rhs' => 3 ),
  array( 'lhs' => 61, 'rhs' => 1 ),
  array( 'lhs' => 61, 'rhs' => 1 ),
  array( 'lhs' => 53, 'rhs' => 3 ),
  array( 'lhs' => 53, 'rhs' => 1 ),
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
        4 => 4,
        40 => 4,
        5 => 5,
        6 => 6,
        7 => 7,
        8 => 7,
        10 => 7,
        11 => 7,
        12 => 7,
        13 => 7,
        15 => 7,
        39 => 7,
        46 => 7,
        47 => 7,
        49 => 7,
        9 => 9,
        14 => 14,
        16 => 16,
        17 => 17,
        18 => 18,
        19 => 19,
        20 => 20,
        21 => 21,
        22 => 22,
        23 => 23,
        24 => 24,
        25 => 25,
        26 => 26,
        27 => 27,
        28 => 28,
        29 => 29,
        30 => 30,
        31 => 31,
        33 => 31,
        32 => 32,
        34 => 34,
        35 => 35,
        36 => 36,
        37 => 36,
        38 => 38,
        41 => 41,
        42 => 41,
        43 => 41,
        44 => 41,
        45 => 41,
        48 => 48,
    );
    /* Beginning here are the reduction cases.  A typical example
    ** follows:
    **  #line <lineno> <grammarfile>
    **   function yy_r0($yymsp){ ... }           // User supplied code
    **  #line <lineno> <thisfile>
    */
#line 30 "parser.y"
    function yy_r0(){ $this->yystack[$this->yyidx + 0]->minor['base'] = $this->yystack[$this->yyidx + -2]->minor; $this->body = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1145 "parser.php"
#line 31 "parser.y"
    function yy_r1(){ $this->body = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1148 "parser.php"
#line 33 "parser.y"
    function yy_r2(){ $this->_retvalue=$this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1151 "parser.php"
#line 34 "parser.y"
    function yy_r3(){ $this->_retvalue = array();     }
#line 1154 "parser.php"
#line 37 "parser.y"
    function yy_r4(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1157 "parser.php"
#line 38 "parser.y"
    function yy_r5(){ $this->_retvalue = array('operation' => 'print', 'variable' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1160 "parser.php"
#line 39 "parser.y"
    function yy_r6(){$this->_retvalue = array('operation' => 'html', 'html' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1163 "parser.php"
#line 40 "parser.y"
    function yy_r7(){ $this->_retvalue = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1166 "parser.php"
#line 42 "parser.y"
    function yy_r9(){ $this->yystack[$this->yyidx + 0]->minor=rtrim($this->yystack[$this->yyidx + 0]->minor); $this->_retvalue = array('operation' => 'php', 'php' => "/*".substr($this->yystack[$this->yyidx + 0]->minor, 0, strlen($this->yystack[$this->yyidx + 0]->minor)-2)."*/");     }
#line 1169 "parser.php"
#line 47 "parser.y"
    function yy_r14(){ $this->_retvalue = array('operation' => 'include', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1172 "parser.php"
#line 55 "parser.y"
    function yy_r16(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -7]->minor, 'array' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1177 "parser.php"
#line 58 "parser.y"
    function yy_r17(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -11]->minor, 'array' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'empty' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1182 "parser.php"
#line 62 "parser.y"
    function yy_r18(){ $this->_retvalue = array('operation' => 'if', 'expr' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1185 "parser.php"
#line 63 "parser.y"
    function yy_r19(){ $this->_retvalue = array('operation' => 'if', 'expr' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1188 "parser.php"
#line 66 "parser.y"
    function yy_r20(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1193 "parser.php"
#line 70 "parser.y"
    function yy_r21(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -3]->minor, 'check' => $this->yystack[$this->yyidx + -5]->minor);
    }
#line 1198 "parser.php"
#line 73 "parser.y"
    function yy_r22(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1203 "parser.php"
#line 77 "parser.y"
    function yy_r23(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -7]->minor, 'check' => $this->yystack[$this->yyidx + -9]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);
    }
#line 1208 "parser.php"
#line 82 "parser.y"
    function yy_r24(){ if ('end'.$this->yystack[$this->yyidx + -5]->minor != $this->yystack[$this->yyidx + -1]->minor) { throw new Exception("Unexpected ".$this->yystack[$this->yyidx + -1]->minor); } $this->_retvalue = array('operation' => 'filter', 'functions' => array(array('var'=>$this->yystack[$this->yyidx + -5]->minor)), 'body' => $this->yystack[$this->yyidx + -3]->minor);    }
#line 1211 "parser.php"
#line 85 "parser.y"
    function yy_r25(){ $this->_retvalue = array('operation' => 'block', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1214 "parser.php"
#line 87 "parser.y"
    function yy_r26(){ $this->_retvalue = array('operation' => 'block', 'name' => $this->yystack[$this->yyidx + -6]->minor, 'body' => $this->yystack[$this->yyidx + -4]->minor);     }
#line 1217 "parser.php"
#line 90 "parser.y"
    function yy_r27(){ $this->_retvalue = array('operation' => 'filter', 'functions' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1220 "parser.php"
#line 94 "parser.y"
    function yy_r28(){ $this->_retvalue = array('operation' => 'cycle', 'vars' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1223 "parser.php"
#line 95 "parser.y"
    function yy_r29(){ $this->_retvalue = array('operation' => 'cycle', 'vars' => $this->yystack[$this->yyidx + -2]->minor, 'as' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1226 "parser.php"
#line 98 "parser.y"
    function yy_r30(){ $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1229 "parser.php"
#line 99 "parser.y"
    function yy_r31(){ $this->_retvalue = array($this->yystack[$this->yyidx + 0]->minor);     }
#line 1232 "parser.php"
#line 102 "parser.y"
    function yy_r32(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1235 "parser.php"
#line 105 "parser.y"
    function yy_r34(){ $this->_retvalue = array('var' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1238 "parser.php"
#line 106 "parser.y"
    function yy_r35(){ $this->_retvalue = array('string' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1241 "parser.php"
#line 108 "parser.y"
    function yy_r36(){  $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1244 "parser.php"
#line 110 "parser.y"
    function yy_r38(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor.$this->yystack[$this->yyidx + 0]->minor;     }
#line 1247 "parser.php"
#line 115 "parser.y"
    function yy_r41(){ $this->_retvalue = array('op' => @$this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1250 "parser.php"
#line 125 "parser.y"
    function yy_r48(){ if (!is_array($this->yystack[$this->yyidx + -2]->minor)) { $this->_retvalue = array($this->yystack[$this->yyidx + -2]->minor); } else { $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; }  $this->_retvalue[]=$this->yystack[$this->yyidx + 0]->minor;    }
#line 1253 "parser.php"

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
#line 1373 "parser.php"
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

#line 1394 "parser.php"
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