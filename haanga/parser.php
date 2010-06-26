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
    const T_AS                           = 20;
    const T_FOR                          = 21;
    const T_IN                           = 22;
    const T_CLOSEFOR                     = 23;
    const T_EMPTY                        = 24;
    const T_IF                           = 25;
    const T_ENDIF                        = 26;
    const T_ELSE                         = 27;
    const T_IFCHANGED                    = 28;
    const T_ENDIFCHANGED                 = 29;
    const T_CUSTOM_END                   = 30;
    const T_BLOCK                        = 31;
    const T_END_BLOCK                    = 32;
    const T_FILTER                       = 33;
    const T_END_FILTER                   = 34;
    const T_CYCLE                        = 35;
    const T_PIPE                         = 36;
    const T_COMMA                        = 37;
    const T_STRING_SINGLE_INIT           = 38;
    const T_STRING_SINGLE_END            = 39;
    const T_STRING_DOUBLE_INIT           = 40;
    const T_STRING_DOUBLE_END            = 41;
    const T_STRING_CONTENT               = 42;
    const T_LPARENT                      = 43;
    const T_RPARENT                      = 44;
    const T_NUMERIC                      = 45;
    const T_DOT                          = 46;
    const T_ALPHA                        = 47;
    const YY_NO_ACTION = 207;
    const YY_ACCEPT_ACTION = 206;
    const YY_ERROR_ACTION = 205;

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
    const YY_SZ_ACTTAB = 375;
static public $yy_action = array(
 /*     0 */    40,   51,   50,   53,   95,   96,   16,  127,  132,   22,
 /*    10 */   122,   40,   52,   50,   24,  112,   23,   16,  132,  102,
 /*    20 */    22,   84,  144,   52,   40,   24,   50,   23,  122,   73,
 /*    30 */    16,   56,   98,   22,   91,  104,   52,  113,   24,  122,
 /*    40 */    23,   15,   20,   21,   21,   19,   19,   18,   18,   18,
 /*    50 */    63,  148,  122,   97,   15,   20,   21,   21,   19,   19,
 /*    60 */    18,   18,   18,   40,   97,   50,   59,   65,   97,   16,
 /*    70 */    92,   88,   22,   41,   40,   52,   50,   24,   93,   23,
 /*    80 */    16,  142,  141,   22,  111,  100,   52,   64,   24,  122,
 /*    90 */    23,  122,   40,   39,   50,  138,   99,  110,   16,  100,
 /*   100 */    97,   22,  122,   40,   52,   50,   24,  101,   23,   16,
 /*   110 */    72,  110,   22,  103,  121,   52,   48,   24,  114,   23,
 /*   120 */   122,   40,  107,   50,   89,   14,  100,   16,  115,   78,
 /*   130 */    22,  122,   87,   52,  128,   24,   69,   23,  110,   40,
 /*   140 */    97,   50,  142,   79,   76,   16,  100,   97,   22,  122,
 /*   150 */    82,   52,   44,   24,   38,   23,  133,   40,  110,   50,
 /*   160 */   100,   97,   43,   16,   90,   58,   22,  122,   40,   52,
 /*   170 */    50,   24,  110,   23,   16,  123,   57,   22,   83,  116,
 /*   180 */    52,   97,   24,  118,   23,  122,  147,  146,  140,  135,
 /*   190 */   134,  136,  137,   18,   18,   18,  122,  117,   60,   20,
 /*   200 */    21,   21,   19,   19,   18,   18,   18,   40,  142,   50,
 /*   210 */   165,  108,  100,   16,   61,  105,   22,  119,   13,   52,
 /*   220 */    37,   24,   45,   23,  110,   21,   21,   19,   19,   18,
 /*   230 */    18,   18,  206,   62,    7,  122,   49,  107,  120,   42,
 /*   240 */    51,  100,   53,   54,  124,   51,  130,   53,   46,  122,
 /*   250 */    17,   71,  109,  110,  122,   94,  125,   42,   51,  100,
 /*   260 */    53,   51,  131,   53,  129,   42,   51,  122,   53,   97,
 /*   270 */   122,  110,  122,   32,  126,  122,   47,   30,  145,   86,
 /*   280 */    47,   25,  145,   86,   47,   29,  145,   86,   47,   36,
 /*   290 */   145,   86,   47,   35,  145,   86,   47,   27,  145,   86,
 /*   300 */    47,   34,  145,   86,   47,   33,  145,   86,   47,   31,
 /*   310 */   145,   86,   47,   26,  145,   86,   47,  107,  145,   86,
 /*   320 */    55,  100,   28,   80,    1,   47,  107,  145,   86,   81,
 /*   330 */   100,   70,   77,  110,  107,  107,  126,   74,  100,  100,
 /*   340 */   106,   75,  110,    2,    9,   51,   10,   53,   67,   68,
 /*   350 */   110,  110,    4,  107,  122,  143,   85,  100,  139,  100,
 /*   360 */   100,    5,  100,    3,   11,   12,    8,   66,    6,  110,
 /*   370 */   126,  110,  110,  126,  110,
    );
    static public $yy_lookahead = array(
 /*     0 */    19,   38,   21,   40,   23,   24,   25,   41,   42,   28,
 /*    10 */    47,   19,   31,   21,   33,   39,   35,   25,   42,   27,
 /*    20 */    28,   29,   15,   31,   19,   33,   21,   35,   47,   54,
 /*    30 */    25,   13,   27,   28,   29,   13,   31,   13,   33,   47,
 /*    40 */    35,    1,    2,    3,    4,    5,    6,    7,    8,    9,
 /*    50 */    13,   13,   47,   46,    1,    2,    3,    4,    5,    6,
 /*    60 */     7,    8,    9,   19,   46,   21,   13,   13,   46,   25,
 /*    70 */    26,   27,   28,   36,   19,   31,   21,   33,   23,   35,
 /*    80 */    25,   50,   18,   28,   44,   54,   31,   13,   33,   47,
 /*    90 */    35,   47,   19,   62,   21,   50,   11,   66,   25,   54,
 /*   100 */    46,   28,   47,   19,   31,   21,   33,   34,   35,   25,
 /*   110 */    65,   66,   28,   29,   13,   31,   22,   33,   13,   35,
 /*   120 */    47,   19,   50,   21,   53,   54,   54,   25,   13,   54,
 /*   130 */    28,   47,   30,   31,   63,   33,   64,   35,   66,   19,
 /*   140 */    46,   21,   50,   54,   54,   25,   54,   46,   28,   47,
 /*   150 */    54,   31,   32,   33,   62,   35,   50,   19,   66,   21,
 /*   160 */    54,   46,   12,   25,   26,   13,   28,   47,   19,   31,
 /*   170 */    21,   33,   66,   35,   25,   42,   13,   28,   29,   13,
 /*   180 */    31,   46,   33,   52,   35,   47,   55,   56,   57,   58,
 /*   190 */    59,   60,   61,    7,    8,    9,   47,   13,   13,    2,
 /*   200 */     3,    4,    5,    6,    7,    8,    9,   19,   50,   21,
 /*   210 */     0,   47,   54,   25,   13,   13,   28,   13,   51,   31,
 /*   220 */    62,   33,   20,   35,   66,    3,    4,    5,    6,    7,
 /*   230 */     8,    9,   49,   13,   51,   47,   13,   50,   13,   37,
 /*   240 */    38,   54,   40,   20,   13,   38,   13,   40,   20,   47,
 /*   250 */    43,   64,   45,   66,   47,   50,   13,   37,   38,   54,
 /*   260 */    40,   38,   13,   40,   13,   37,   38,   47,   40,   46,
 /*   270 */    47,   66,   47,   11,   13,   47,   14,   11,   16,   17,
 /*   280 */    14,   11,   16,   17,   14,   11,   16,   17,   14,   11,
 /*   290 */    16,   17,   14,   11,   16,   17,   14,   11,   16,   17,
 /*   300 */    14,   11,   16,   17,   14,   11,   16,   17,   14,   11,
 /*   310 */    16,   17,   14,   11,   16,   17,   14,   50,   16,   17,
 /*   320 */    13,   54,   11,   67,   51,   14,   50,   16,   17,   54,
 /*   330 */    54,   64,   67,   66,   50,   50,   68,   54,   54,   54,
 /*   340 */    64,   54,   66,   51,   51,   38,   51,   40,   64,   64,
 /*   350 */    66,   66,   51,   50,   47,   50,   50,   54,   50,   54,
 /*   360 */    54,   51,   54,   51,   51,   51,   51,   64,   51,   66,
 /*   370 */    68,   66,   66,   68,   66,
);
    const YY_SHIFT_USE_DFLT = -38;
    const YY_SHIFT_MAX = 103;
    static public $yy_shift_ofst = array(
 /*     0 */    85,  262,  270,  266,  302,  311,  298,  278,  290,  286,
 /*    10 */   294,  282,  274,  278,  223,  207,  207,  207,  207,  207,
 /*    20 */   207,  207,  307,  -37,  -37,   44,  -19,   -8,    5,  120,
 /*    30 */    55,   84,  138,   73,  149,  102,  188,  202,  220,  228,
 /*    40 */   -37,  -37,  -37,  -37,  225,   42,   42,   42,   42,  210,
 /*    50 */    42,  133,   42,  133,   42,  -38,  -38,  -38,  -38,  -38,
 /*    60 */   -38,  -38,  -38,  -38,  -38,  -38,   53,   40,  197,  222,
 /*    70 */   222,  186,   37,  101,  115,   94,   54,  -34,   22,    7,
 /*    80 */   -24,   18,  135,   24,   38,   74,   64,  105,  152,  233,
 /*    90 */   231,  204,  243,  249,  261,  251,  201,  164,  163,  150,
 /*   100 */   135,  166,  185,  184,
);
    const YY_REDUCE_USE_DFLT = -26;
    const YY_REDUCE_MAX = 65;
    static public $yy_reduce_ofst = array(
 /*     0 */   183,  131,  131,  131,  131,  131,  131,  131,  131,  131,
 /*    10 */   131,  131,  131,  131,  158,  285,  303,  284,  276,  187,
 /*    20 */    72,  267,   92,   31,   45,   71,   71,   71,   71,   71,
 /*    30 */    71,   71,   71,   71,   71,   71,   71,  106,  106,  106,
 /*    40 */   205,  308,  305,  306,  -25,   75,   96,   89,   90,  313,
 /*    50 */   287,  256,  275,  265,  283,  310,  314,  317,  273,  292,
 /*    60 */   315,  312,  293,  295,  167,  301,
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
        /* 14 */ array(13, 20, 38, 40, 46, 47, ),
        /* 15 */ array(38, 40, 43, 45, 47, ),
        /* 16 */ array(38, 40, 43, 45, 47, ),
        /* 17 */ array(38, 40, 43, 45, 47, ),
        /* 18 */ array(38, 40, 43, 45, 47, ),
        /* 19 */ array(38, 40, 43, 45, 47, ),
        /* 20 */ array(38, 40, 43, 45, 47, ),
        /* 21 */ array(38, 40, 43, 45, 47, ),
        /* 22 */ array(13, 38, 40, 47, ),
        /* 23 */ array(38, 40, 47, ),
        /* 24 */ array(38, 40, 47, ),
        /* 25 */ array(19, 21, 25, 26, 27, 28, 31, 33, 35, 47, ),
        /* 26 */ array(19, 21, 23, 24, 25, 28, 31, 33, 35, 47, ),
        /* 27 */ array(19, 21, 25, 27, 28, 29, 31, 33, 35, 47, ),
        /* 28 */ array(19, 21, 25, 27, 28, 29, 31, 33, 35, 47, ),
        /* 29 */ array(19, 21, 25, 28, 31, 32, 33, 35, 47, ),
        /* 30 */ array(19, 21, 23, 25, 28, 31, 33, 35, 47, ),
        /* 31 */ array(19, 21, 25, 28, 29, 31, 33, 35, 47, ),
        /* 32 */ array(19, 21, 25, 26, 28, 31, 33, 35, 47, ),
        /* 33 */ array(19, 21, 25, 28, 31, 33, 34, 35, 47, ),
        /* 34 */ array(19, 21, 25, 28, 29, 31, 33, 35, 47, ),
        /* 35 */ array(19, 21, 25, 28, 30, 31, 33, 35, 47, ),
        /* 36 */ array(19, 21, 25, 28, 31, 33, 35, 47, ),
        /* 37 */ array(13, 20, 37, 38, 40, 47, ),
        /* 38 */ array(13, 37, 38, 40, 47, ),
        /* 39 */ array(20, 37, 38, 40, 47, ),
        /* 40 */ array(38, 40, 47, ),
        /* 41 */ array(38, 40, 47, ),
        /* 42 */ array(38, 40, 47, ),
        /* 43 */ array(38, 40, 47, ),
        /* 44 */ array(13, 47, ),
        /* 45 */ array(47, ),
        /* 46 */ array(47, ),
        /* 47 */ array(47, ),
        /* 48 */ array(47, ),
        /* 49 */ array(0, ),
        /* 50 */ array(47, ),
        /* 51 */ array(42, ),
        /* 52 */ array(47, ),
        /* 53 */ array(42, ),
        /* 54 */ array(47, ),
        /* 55 */ array(),
        /* 56 */ array(),
        /* 57 */ array(),
        /* 58 */ array(),
        /* 59 */ array(),
        /* 60 */ array(),
        /* 61 */ array(),
        /* 62 */ array(),
        /* 63 */ array(),
        /* 64 */ array(),
        /* 65 */ array(),
        /* 66 */ array(1, 2, 3, 4, 5, 6, 7, 8, 9, 13, ),
        /* 67 */ array(1, 2, 3, 4, 5, 6, 7, 8, 9, 44, ),
        /* 68 */ array(2, 3, 4, 5, 6, 7, 8, 9, ),
        /* 69 */ array(3, 4, 5, 6, 7, 8, 9, ),
        /* 70 */ array(3, 4, 5, 6, 7, 8, 9, ),
        /* 71 */ array(7, 8, 9, ),
        /* 72 */ array(13, 36, ),
        /* 73 */ array(13, 46, ),
        /* 74 */ array(13, 46, ),
        /* 75 */ array(22, 46, ),
        /* 76 */ array(13, 46, ),
        /* 77 */ array(41, 42, ),
        /* 78 */ array(13, 46, ),
        /* 79 */ array(15, 46, ),
        /* 80 */ array(39, 42, ),
        /* 81 */ array(13, 46, ),
        /* 82 */ array(46, ),
        /* 83 */ array(13, ),
        /* 84 */ array(13, ),
        /* 85 */ array(13, ),
        /* 86 */ array(18, ),
        /* 87 */ array(13, ),
        /* 88 */ array(13, ),
        /* 89 */ array(13, ),
        /* 90 */ array(13, ),
        /* 91 */ array(13, ),
        /* 92 */ array(13, ),
        /* 93 */ array(13, ),
        /* 94 */ array(13, ),
        /* 95 */ array(13, ),
        /* 96 */ array(13, ),
        /* 97 */ array(47, ),
        /* 98 */ array(13, ),
        /* 99 */ array(12, ),
        /* 100 */ array(46, ),
        /* 101 */ array(13, ),
        /* 102 */ array(13, ),
        /* 103 */ array(13, ),
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
);
    static public $yy_default = array(
 /*     0 */   152,  205,  205,  205,  205,  205,  205,  150,  205,  205,
 /*    10 */   205,  205,  205,  149,  205,  205,  205,  205,  205,  205,
 /*    20 */   205,  205,  205,  205,  205,  205,  205,  205,  205,  205,
 /*    30 */   205,  205,  205,  205,  205,  205,  205,  205,  205,  182,
 /*    40 */   205,  205,  205,  205,  205,  205,  205,  205,  205,  152,
 /*    50 */   205,  205,  205,  205,  205,  152,  152,  152,  152,  152,
 /*    60 */   152,  152,  152,  152,  152,  152,  205,  205,  196,  197,
 /*    70 */   198,  200,  205,  205,  205,  205,  205,  205,  205,  205,
 /*    80 */   205,  205,  183,  205,  205,  205,  205,  205,  205,  205,
 /*    90 */   205,  205,  205,  205,  205,  205,  205,  205,  205,  205,
 /*   100 */   189,  205,  205,  205,  168,  167,  199,  201,  203,  202,
 /*   110 */   190,  195,  191,  177,  178,  166,  181,  176,  151,  174,
 /*   120 */   179,  180,  204,  194,  173,  172,  163,  192,  169,  170,
 /*   130 */   153,  171,  193,  186,  161,  160,  162,  164,  185,  184,
 /*   140 */   159,  158,  188,  187,  154,  155,  157,  156,  175,
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
    const YYNOCODE = 69;
    const YYSTACKDEPTH = 100;
    const YYNSTATE = 149;
    const YYNRULE = 56;
    const YYERRORSYMBOL = 48;
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
  'T_AS',          'T_FOR',         'T_IN',          'T_CLOSEFOR',  
  'T_EMPTY',       'T_IF',          'T_ENDIF',       'T_ELSE',      
  'T_IFCHANGED',   'T_ENDIFCHANGED',  'T_CUSTOM_END',  'T_BLOCK',     
  'T_END_BLOCK',   'T_FILTER',      'T_END_FILTER',  'T_CYCLE',     
  'T_PIPE',        'T_COMMA',       'T_STRING_SINGLE_INIT',  'T_STRING_SINGLE_END',
  'T_STRING_DOUBLE_INIT',  'T_STRING_DOUBLE_END',  'T_STRING_CONTENT',  'T_LPARENT',   
  'T_RPARENT',     'T_NUMERIC',     'T_DOT',         'T_ALPHA',     
  'error',         'start',         'var_or_string',  'body',        
  'stmts',         'stmt',          'varname',       'for_stmt',    
  'ifchanged_stmt',  'block_stmt',    'filter_stmt',   'custom_stmt', 
  'if_stmt',       'fnc_call_stmt',  'list',          'cycle',       
  'expr',          'piped_list',    'string',        's_content',   
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
 /*  15 */ "stmts ::= fnc_call_stmt",
 /*  16 */ "fnc_call_stmt ::= T_OPEN_TAG varname T_CLOSE_TAG",
 /*  17 */ "fnc_call_stmt ::= T_OPEN_TAG varname T_AS varname T_CLOSE_TAG",
 /*  18 */ "fnc_call_stmt ::= T_OPEN_TAG varname list T_CLOSE_TAG",
 /*  19 */ "fnc_call_stmt ::= T_OPEN_TAG varname list T_AS varname T_CLOSE_TAG",
 /*  20 */ "stmt ::= cycle",
 /*  21 */ "for_stmt ::= T_OPEN_TAG T_FOR varname T_IN varname T_CLOSE_TAG body T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG",
 /*  22 */ "for_stmt ::= T_OPEN_TAG T_FOR varname T_IN varname T_CLOSE_TAG body T_OPEN_TAG T_EMPTY T_CLOSE_TAG body T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG",
 /*  23 */ "if_stmt ::= T_OPEN_TAG T_IF expr T_CLOSE_TAG body T_OPEN_TAG T_ENDIF T_CLOSE_TAG",
 /*  24 */ "if_stmt ::= T_OPEN_TAG T_IF expr T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIF T_CLOSE_TAG",
 /*  25 */ "ifchanged_stmt ::= T_OPEN_TAG T_IFCHANGED T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  26 */ "ifchanged_stmt ::= T_OPEN_TAG T_IFCHANGED list T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  27 */ "ifchanged_stmt ::= T_OPEN_TAG T_IFCHANGED T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  28 */ "ifchanged_stmt ::= T_OPEN_TAG T_IFCHANGED list T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  29 */ "custom_stmt ::= T_OPEN_TAG varname T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  30 */ "block_stmt ::= T_OPEN_TAG T_BLOCK varname T_CLOSE_TAG body T_OPEN_TAG T_END_BLOCK T_CLOSE_TAG",
 /*  31 */ "block_stmt ::= T_OPEN_TAG T_BLOCK varname T_CLOSE_TAG body T_OPEN_TAG T_END_BLOCK varname T_CLOSE_TAG",
 /*  32 */ "filter_stmt ::= T_OPEN_TAG T_FILTER piped_list T_CLOSE_TAG body T_OPEN_TAG T_END_FILTER T_CLOSE_TAG",
 /*  33 */ "cycle ::= T_CYCLE list",
 /*  34 */ "cycle ::= T_CYCLE list T_AS varname",
 /*  35 */ "piped_list ::= piped_list T_PIPE var_or_string",
 /*  36 */ "piped_list ::= var_or_string",
 /*  37 */ "list ::= list var_or_string",
 /*  38 */ "list ::= list T_COMMA var_or_string",
 /*  39 */ "list ::= var_or_string",
 /*  40 */ "var_or_string ::= varname",
 /*  41 */ "var_or_string ::= string",
 /*  42 */ "string ::= T_STRING_SINGLE_INIT s_content T_STRING_SINGLE_END",
 /*  43 */ "string ::= T_STRING_DOUBLE_INIT s_content T_STRING_DOUBLE_END",
 /*  44 */ "s_content ::= s_content T_STRING_CONTENT",
 /*  45 */ "s_content ::= T_STRING_CONTENT",
 /*  46 */ "expr ::= T_LPARENT expr T_RPARENT",
 /*  47 */ "expr ::= expr T_AND expr",
 /*  48 */ "expr ::= expr T_OR expr",
 /*  49 */ "expr ::= expr T_EQ|T_NE expr",
 /*  50 */ "expr ::= expr T_TIMES|T_DIV|T_MOD expr",
 /*  51 */ "expr ::= expr T_PLUS|T_MINUS expr",
 /*  52 */ "expr ::= var_or_string",
 /*  53 */ "expr ::= T_NUMERIC",
 /*  54 */ "varname ::= varname T_DOT T_ALPHA",
 /*  55 */ "varname ::= T_ALPHA",
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
  array( 'lhs' => 49, 'rhs' => 5 ),
  array( 'lhs' => 49, 'rhs' => 1 ),
  array( 'lhs' => 51, 'rhs' => 2 ),
  array( 'lhs' => 51, 'rhs' => 0 ),
  array( 'lhs' => 52, 'rhs' => 3 ),
  array( 'lhs' => 52, 'rhs' => 3 ),
  array( 'lhs' => 52, 'rhs' => 1 ),
  array( 'lhs' => 52, 'rhs' => 1 ),
  array( 'lhs' => 52, 'rhs' => 1 ),
  array( 'lhs' => 52, 'rhs' => 2 ),
  array( 'lhs' => 52, 'rhs' => 1 ),
  array( 'lhs' => 52, 'rhs' => 1 ),
  array( 'lhs' => 52, 'rhs' => 1 ),
  array( 'lhs' => 52, 'rhs' => 1 ),
  array( 'lhs' => 52, 'rhs' => 4 ),
  array( 'lhs' => 52, 'rhs' => 1 ),
  array( 'lhs' => 61, 'rhs' => 3 ),
  array( 'lhs' => 61, 'rhs' => 5 ),
  array( 'lhs' => 61, 'rhs' => 4 ),
  array( 'lhs' => 61, 'rhs' => 6 ),
  array( 'lhs' => 53, 'rhs' => 1 ),
  array( 'lhs' => 55, 'rhs' => 10 ),
  array( 'lhs' => 55, 'rhs' => 14 ),
  array( 'lhs' => 60, 'rhs' => 8 ),
  array( 'lhs' => 60, 'rhs' => 12 ),
  array( 'lhs' => 56, 'rhs' => 7 ),
  array( 'lhs' => 56, 'rhs' => 8 ),
  array( 'lhs' => 56, 'rhs' => 11 ),
  array( 'lhs' => 56, 'rhs' => 12 ),
  array( 'lhs' => 59, 'rhs' => 7 ),
  array( 'lhs' => 57, 'rhs' => 8 ),
  array( 'lhs' => 57, 'rhs' => 9 ),
  array( 'lhs' => 58, 'rhs' => 8 ),
  array( 'lhs' => 63, 'rhs' => 2 ),
  array( 'lhs' => 63, 'rhs' => 4 ),
  array( 'lhs' => 65, 'rhs' => 3 ),
  array( 'lhs' => 65, 'rhs' => 1 ),
  array( 'lhs' => 62, 'rhs' => 2 ),
  array( 'lhs' => 62, 'rhs' => 3 ),
  array( 'lhs' => 62, 'rhs' => 1 ),
  array( 'lhs' => 50, 'rhs' => 1 ),
  array( 'lhs' => 50, 'rhs' => 1 ),
  array( 'lhs' => 66, 'rhs' => 3 ),
  array( 'lhs' => 66, 'rhs' => 3 ),
  array( 'lhs' => 67, 'rhs' => 2 ),
  array( 'lhs' => 67, 'rhs' => 1 ),
  array( 'lhs' => 64, 'rhs' => 3 ),
  array( 'lhs' => 64, 'rhs' => 3 ),
  array( 'lhs' => 64, 'rhs' => 3 ),
  array( 'lhs' => 64, 'rhs' => 3 ),
  array( 'lhs' => 64, 'rhs' => 3 ),
  array( 'lhs' => 64, 'rhs' => 3 ),
  array( 'lhs' => 64, 'rhs' => 1 ),
  array( 'lhs' => 64, 'rhs' => 1 ),
  array( 'lhs' => 54, 'rhs' => 3 ),
  array( 'lhs' => 54, 'rhs' => 1 ),
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
        46 => 4,
        5 => 5,
        6 => 6,
        7 => 7,
        8 => 7,
        10 => 7,
        11 => 7,
        12 => 7,
        13 => 7,
        15 => 7,
        20 => 7,
        45 => 7,
        52 => 7,
        53 => 7,
        55 => 7,
        9 => 9,
        14 => 14,
        16 => 16,
        17 => 17,
        18 => 18,
        19 => 19,
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
        32 => 32,
        33 => 33,
        34 => 34,
        35 => 35,
        38 => 35,
        36 => 36,
        39 => 36,
        37 => 37,
        40 => 40,
        41 => 41,
        42 => 42,
        43 => 42,
        44 => 44,
        47 => 47,
        48 => 47,
        49 => 47,
        50 => 47,
        51 => 47,
        54 => 54,
    );
    /* Beginning here are the reduction cases.  A typical example
    ** follows:
    **  #line <lineno> <grammarfile>
    **   function yy_r0($yymsp){ ... }           // User supplied code
    **  #line <lineno> <thisfile>
    */
#line 30 "parser.y"
    function yy_r0(){ $this->yystack[$this->yyidx + 0]->minor['base'] = $this->yystack[$this->yyidx + -2]->minor; $this->body = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1179 "parser.php"
#line 31 "parser.y"
    function yy_r1(){ $this->body = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1182 "parser.php"
#line 33 "parser.y"
    function yy_r2(){ $this->_retvalue=$this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1185 "parser.php"
#line 34 "parser.y"
    function yy_r3(){ $this->_retvalue = array();     }
#line 1188 "parser.php"
#line 37 "parser.y"
    function yy_r4(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1191 "parser.php"
#line 38 "parser.y"
    function yy_r5(){ $this->_retvalue = array('operation' => 'print', 'variable' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1194 "parser.php"
#line 39 "parser.y"
    function yy_r6(){$this->_retvalue = array('operation' => 'html', 'html' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1197 "parser.php"
#line 40 "parser.y"
    function yy_r7(){ $this->_retvalue = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1200 "parser.php"
#line 42 "parser.y"
    function yy_r9(){ $this->yystack[$this->yyidx + 0]->minor=rtrim($this->yystack[$this->yyidx + 0]->minor); $this->_retvalue = array('operation' => 'php', 'php' => "/*".substr($this->yystack[$this->yyidx + 0]->minor, 0, strlen($this->yystack[$this->yyidx + 0]->minor)-2)."*/");     }
#line 1203 "parser.php"
#line 47 "parser.y"
    function yy_r14(){ $this->_retvalue = array('operation' => 'include', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1206 "parser.php"
#line 53 "parser.y"
    function yy_r16(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1209 "parser.php"
#line 54 "parser.y"
    function yy_r17(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -3]->minor, 'as' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1212 "parser.php"
#line 55 "parser.y"
    function yy_r18(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -2]->minor, 'list' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1215 "parser.php"
#line 56 "parser.y"
    function yy_r19(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -4]->minor, 'as' => $this->yystack[$this->yyidx + -1]->minor, 'list' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1218 "parser.php"
#line 62 "parser.y"
    function yy_r21(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -7]->minor, 'array' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1223 "parser.php"
#line 65 "parser.y"
    function yy_r22(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -11]->minor, 'array' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'empty' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1228 "parser.php"
#line 69 "parser.y"
    function yy_r23(){ $this->_retvalue = array('operation' => 'if', 'expr' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1231 "parser.php"
#line 70 "parser.y"
    function yy_r24(){ $this->_retvalue = array('operation' => 'if', 'expr' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1234 "parser.php"
#line 73 "parser.y"
    function yy_r25(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1239 "parser.php"
#line 77 "parser.y"
    function yy_r26(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -3]->minor, 'check' => $this->yystack[$this->yyidx + -5]->minor);
    }
#line 1244 "parser.php"
#line 80 "parser.y"
    function yy_r27(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1249 "parser.php"
#line 84 "parser.y"
    function yy_r28(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -7]->minor, 'check' => $this->yystack[$this->yyidx + -9]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);
    }
#line 1254 "parser.php"
#line 89 "parser.y"
    function yy_r29(){ if ('end'.$this->yystack[$this->yyidx + -5]->minor != $this->yystack[$this->yyidx + -1]->minor) { throw new Exception("Unexpected ".$this->yystack[$this->yyidx + -1]->minor); } $this->_retvalue = array('operation' => 'filter', 'functions' => array(array('var'=>$this->yystack[$this->yyidx + -5]->minor)), 'body' => $this->yystack[$this->yyidx + -3]->minor);    }
#line 1257 "parser.php"
#line 92 "parser.y"
    function yy_r30(){ $this->_retvalue = array('operation' => 'block', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1260 "parser.php"
#line 94 "parser.y"
    function yy_r31(){ $this->_retvalue = array('operation' => 'block', 'name' => $this->yystack[$this->yyidx + -6]->minor, 'body' => $this->yystack[$this->yyidx + -4]->minor);     }
#line 1263 "parser.php"
#line 97 "parser.y"
    function yy_r32(){ $this->_retvalue = array('operation' => 'filter', 'functions' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1266 "parser.php"
#line 101 "parser.y"
    function yy_r33(){ $this->_retvalue = array('operation' => 'cycle', 'vars' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1269 "parser.php"
#line 102 "parser.y"
    function yy_r34(){ $this->_retvalue = array('operation' => 'cycle', 'vars' => $this->yystack[$this->yyidx + -2]->minor, 'as' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1272 "parser.php"
#line 105 "parser.y"
    function yy_r35(){ $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1275 "parser.php"
#line 106 "parser.y"
    function yy_r36(){ $this->_retvalue = array($this->yystack[$this->yyidx + 0]->minor);     }
#line 1278 "parser.php"
#line 109 "parser.y"
    function yy_r37(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1281 "parser.php"
#line 113 "parser.y"
    function yy_r40(){ $this->_retvalue = array('var' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1284 "parser.php"
#line 114 "parser.y"
    function yy_r41(){ $this->_retvalue = array('string' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1287 "parser.php"
#line 116 "parser.y"
    function yy_r42(){  $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1290 "parser.php"
#line 118 "parser.y"
    function yy_r44(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor.$this->yystack[$this->yyidx + 0]->minor;     }
#line 1293 "parser.php"
#line 123 "parser.y"
    function yy_r47(){ $this->_retvalue = array('op' => @$this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1296 "parser.php"
#line 133 "parser.y"
    function yy_r54(){ if (!is_array($this->yystack[$this->yyidx + -2]->minor)) { $this->_retvalue = array($this->yystack[$this->yyidx + -2]->minor); } else { $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; }  $this->_retvalue[]=$this->yystack[$this->yyidx + 0]->minor;    }
#line 1299 "parser.php"

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
#line 1419 "parser.php"
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

#line 1440 "parser.php"
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