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
    const T_FOR                          = 19;
    const T_IN                           = 20;
    const T_CLOSEFOR                     = 21;
    const T_EMPTY                        = 22;
    const T_IF                           = 23;
    const T_ENDIF                        = 24;
    const T_ELSE                         = 25;
    const T_IFCHANGED                    = 26;
    const T_ENDIFCHANGED                 = 27;
    const T_CUSTOM_END                   = 28;
    const T_BLOCK                        = 29;
    const T_END_BLOCK                    = 30;
    const T_FILTER                       = 31;
    const T_END_FILTER                   = 32;
    const T_CYCLE                        = 33;
    const T_AS                           = 34;
    const T_PIPE                         = 35;
    const T_STRING                       = 36;
    const T_LPARENT                      = 37;
    const T_RPARENT                      = 38;
    const T_NUMERIC                      = 39;
    const T_DOT                          = 40;
    const T_ALPHA                        = 41;
    const YY_NO_ACTION = 174;
    const YY_ACCEPT_ACTION = 173;
    const YY_ERROR_ACTION = 172;

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
    const YY_SZ_ACTTAB = 300;
static public $yy_action = array(
 /*     0 */    32,   34,   35,   35,   37,   37,   36,   36,   36,   32,
 /*    10 */    34,   35,   35,   37,   37,   36,   36,   36,   31,   44,
 /*    20 */    94,   56,  112,   33,  119,   90,   26,   91,   44,   42,
 /*    30 */    48,   28,   33,   27,   72,   26,   71,   93,   42,   44,
 /*    40 */    28,  112,   27,   33,   78,   79,   26,   52,   95,   42,
 /*    50 */   112,   28,   44,   27,   84,   80,   33,   74,  173,   26,
 /*    60 */    11,  112,   42,   44,   28,  126,   27,   33,   86,   75,
 /*    70 */    26,   47,   44,   42,  112,   28,   33,   27,   92,   26,
 /*    80 */    66,   87,   42,   44,   28,  112,   27,   33,   96,  103,
 /*    90 */    26,   70,  104,   42,  112,   28,  108,   27,   74,  125,
 /*   100 */   120,  115,  114,  116,  117,  112,    5,   39,   34,   35,
 /*   110 */    35,   37,   37,   36,   36,   36,   40,   44,   50,  123,
 /*   120 */    25,   33,   74,   41,   26,  124,   73,   42,   82,   28,
 /*   130 */    88,   27,   75,   44,  101,   77,   74,   33,  121,  112,
 /*   140 */    26,  122,   75,   42,   74,   28,  112,   27,  105,   44,
 /*   150 */    43,   29,  122,   33,   54,  112,   26,  112,  102,   42,
 /*   160 */    45,   28,   57,   27,  113,   44,   83,   68,   75,   33,
 /*   170 */    81,  112,   26,   76,  109,   42,   44,   28,   63,   27,
 /*   180 */    33,   74,  100,   26,  122,  110,   42,  112,   28,  112,
 /*   190 */    27,   35,   35,   37,   37,   36,   36,   36,  112,   55,
 /*   200 */    15,   13,   89,   41,   19,  124,   73,   41,   24,  124,
 /*   210 */    73,   41,   17,  124,   73,   41,   21,  124,   73,   41,
 /*   220 */    23,  124,   73,   41,   22,  124,   73,   41,   14,  124,
 /*   230 */    73,   41,   18,  124,   73,   41,   20,  124,   73,   41,
 /*   240 */    16,  124,   73,   41,   51,  124,   73,   36,   36,   36,
 /*   250 */   121,   49,   81,  112,   75,  118,   81,  106,   81,   75,
 /*   260 */    60,   99,   81,   30,   58,   53,   62,  122,   81,  107,
 /*   270 */    59,   81,  112,   38,   46,  111,   97,   98,    8,   61,
 /*   280 */     7,    4,   12,  107,    6,  107,  107,  107,  107,   65,
 /*   290 */    67,   64,    1,   69,   85,   10,    9,  107,    2,    3,
    );
    static public $yy_lookahead = array(
 /*     0 */     1,    2,    3,    4,    5,    6,    7,    8,    9,    1,
 /*    10 */     2,    3,    4,    5,    6,    7,    8,    9,   37,   19,
 /*    20 */    39,   13,   41,   23,   18,   25,   26,   27,   19,   29,
 /*    30 */    13,   31,   23,   33,   25,   26,   27,   38,   29,   19,
 /*    40 */    31,   41,   33,   23,   24,   25,   26,   13,   13,   29,
 /*    50 */    41,   31,   19,   33,   21,   22,   23,   40,   43,   26,
 /*    60 */    45,   41,   29,   19,   31,   44,   33,   23,   24,   48,
 /*    70 */    26,   13,   19,   29,   41,   31,   23,   33,   11,   26,
 /*    80 */    59,   28,   29,   19,   31,   41,   33,   23,   13,   41,
 /*    90 */    26,   27,   13,   29,   41,   31,   46,   33,   40,   49,
 /*   100 */    50,   51,   52,   53,   54,   41,   45,   12,    2,    3,
 /*   110 */     4,    5,    6,    7,    8,    9,   20,   19,   13,   15,
 /*   120 */    11,   23,   40,   14,   26,   16,   17,   29,   44,   31,
 /*   130 */    32,   33,   48,   19,   13,   21,   40,   23,   44,   41,
 /*   140 */    26,   36,   48,   29,   40,   31,   41,   33,   13,   19,
 /*   150 */    34,   57,   36,   23,   13,   41,   26,   41,   13,   29,
 /*   160 */    30,   31,   13,   33,   44,   19,   47,   48,   48,   23,
 /*   170 */    48,   41,   26,   27,   55,   29,   19,   31,   56,   33,
 /*   180 */    23,   40,   13,   26,   36,   13,   29,   41,   31,   41,
 /*   190 */    33,    3,    4,    5,    6,    7,    8,    9,   41,   13,
 /*   200 */    11,   45,   58,   14,   11,   16,   17,   14,   11,   16,
 /*   210 */    17,   14,   11,   16,   17,   14,   11,   16,   17,   14,
 /*   220 */    11,   16,   17,   14,   11,   16,   17,   14,   11,   16,
 /*   230 */    17,   14,   11,   16,   17,   14,   11,   16,   17,   14,
 /*   240 */    11,   16,   17,   14,   13,   16,   17,    7,    8,    9,
 /*   250 */    44,   13,   48,   41,   48,   44,   48,   13,   48,   48,
 /*   260 */    56,   13,   48,   57,   56,   13,   56,   36,   48,   13,
 /*   270 */    56,   48,   41,   35,   13,   13,   56,   13,   45,   56,
 /*   280 */    45,   45,   45,   60,   45,   60,   60,   60,   60,   48,
 /*   290 */    48,   48,   45,   48,   48,   45,   45,   60,   45,   45,
);
    const YY_SHIFT_USE_DFLT = -20;
    const YY_SHIFT_MAX = 92;
    static public $yy_shift_ofst = array(
 /*     0 */    67,  205,  201,  197,  189,  213,  193,  209,  221,  229,
 /*    10 */   225,  109,  217,  109,    9,    0,   33,   20,   53,   98,
 /*    20 */    44,   64,  146,  130,  114,  157,  231,  148,  148,  116,
 /*    30 */   105,  -19,  -19,  -19,  -19,  -19,  -19,  -19,  148,  148,
 /*    40 */   212,  212,  212,  212,  212,  264,  -20,  -20,  -20,  -20,
 /*    50 */   -20,  -20,  -20,  -20,  -20,  -20,  -20,  -20,   -1,    8,
 /*    60 */   106,  188,  188,  240,  141,   96,  238,  104,   58,   17,
 /*    70 */    75,   35,   34,    6,   48,   82,  248,  262,  244,  186,
 /*    80 */   252,   82,  261,  256,  172,   82,  135,  121,   79,  145,
 /*    90 */   149,  169,   95,
);
    const YY_REDUCE_USE_DFLT = -1;
    const YY_REDUCE_MAX = 57;
    static public $yy_reduce_ofst = array(
 /*     0 */    15,   50,   50,   50,   50,   50,   50,   50,   50,   50,
 /*    10 */    50,   50,   50,   50,  119,  119,  119,  119,  119,  119,
 /*    20 */   119,  119,  119,  119,  119,  119,  206,   94,   21,  120,
 /*    30 */   120,  208,  204,  214,  210,  223,  220,  122,  211,   84,
 /*    40 */   243,  242,  245,  246,  241,  144,  156,  233,  235,  239,
 /*    50 */   237,  236,  247,  254,  251,  250,  253,   61,
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
        /* 14 */ array(19, 23, 25, 26, 27, 29, 31, 33, 41, ),
        /* 15 */ array(19, 23, 25, 26, 27, 29, 31, 33, 41, ),
        /* 16 */ array(19, 21, 22, 23, 26, 29, 31, 33, 41, ),
        /* 17 */ array(19, 23, 24, 25, 26, 29, 31, 33, 41, ),
        /* 18 */ array(19, 23, 26, 28, 29, 31, 33, 41, ),
        /* 19 */ array(19, 23, 26, 29, 31, 32, 33, 41, ),
        /* 20 */ array(19, 23, 24, 26, 29, 31, 33, 41, ),
        /* 21 */ array(19, 23, 26, 27, 29, 31, 33, 41, ),
        /* 22 */ array(19, 23, 26, 27, 29, 31, 33, 41, ),
        /* 23 */ array(19, 23, 26, 29, 30, 31, 33, 41, ),
        /* 24 */ array(19, 21, 23, 26, 29, 31, 33, 41, ),
        /* 25 */ array(19, 23, 26, 29, 31, 33, 41, ),
        /* 26 */ array(13, 36, 41, ),
        /* 27 */ array(36, 41, ),
        /* 28 */ array(36, 41, ),
        /* 29 */ array(34, 36, 41, ),
        /* 30 */ array(13, 36, 41, ),
        /* 31 */ array(37, 39, 41, ),
        /* 32 */ array(37, 39, 41, ),
        /* 33 */ array(37, 39, 41, ),
        /* 34 */ array(37, 39, 41, ),
        /* 35 */ array(37, 39, 41, ),
        /* 36 */ array(37, 39, 41, ),
        /* 37 */ array(37, 39, 41, ),
        /* 38 */ array(36, 41, ),
        /* 39 */ array(36, 41, ),
        /* 40 */ array(41, ),
        /* 41 */ array(41, ),
        /* 42 */ array(41, ),
        /* 43 */ array(41, ),
        /* 44 */ array(41, ),
        /* 45 */ array(13, ),
        /* 46 */ array(),
        /* 47 */ array(),
        /* 48 */ array(),
        /* 49 */ array(),
        /* 50 */ array(),
        /* 51 */ array(),
        /* 52 */ array(),
        /* 53 */ array(),
        /* 54 */ array(),
        /* 55 */ array(),
        /* 56 */ array(),
        /* 57 */ array(),
        /* 58 */ array(1, 2, 3, 4, 5, 6, 7, 8, 9, 38, ),
        /* 59 */ array(1, 2, 3, 4, 5, 6, 7, 8, 9, 13, ),
        /* 60 */ array(2, 3, 4, 5, 6, 7, 8, 9, ),
        /* 61 */ array(3, 4, 5, 6, 7, 8, 9, ),
        /* 62 */ array(3, 4, 5, 6, 7, 8, 9, ),
        /* 63 */ array(7, 8, 9, ),
        /* 64 */ array(13, 40, ),
        /* 65 */ array(20, 40, ),
        /* 66 */ array(13, 35, ),
        /* 67 */ array(15, 40, ),
        /* 68 */ array(13, 40, ),
        /* 69 */ array(13, 40, ),
        /* 70 */ array(13, ),
        /* 71 */ array(13, ),
        /* 72 */ array(13, ),
        /* 73 */ array(18, ),
        /* 74 */ array(41, ),
        /* 75 */ array(40, ),
        /* 76 */ array(13, ),
        /* 77 */ array(13, ),
        /* 78 */ array(13, ),
        /* 79 */ array(13, ),
        /* 80 */ array(13, ),
        /* 81 */ array(40, ),
        /* 82 */ array(13, ),
        /* 83 */ array(13, ),
        /* 84 */ array(13, ),
        /* 85 */ array(40, ),
        /* 86 */ array(13, ),
        /* 87 */ array(13, ),
        /* 88 */ array(13, ),
        /* 89 */ array(13, ),
        /* 90 */ array(13, ),
        /* 91 */ array(13, ),
        /* 92 */ array(12, ),
        /* 93 */ array(),
        /* 94 */ array(),
        /* 95 */ array(),
        /* 96 */ array(),
        /* 97 */ array(),
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
);
    static public $yy_default = array(
 /*     0 */   130,  172,  172,  172,  172,  172,  172,  172,  172,  172,
 /*    10 */   172,  128,  172,  127,  172,  172,  172,  172,  172,  172,
 /*    20 */   172,  172,  172,  172,  172,  172,  172,  172,  172,  154,
 /*    30 */   172,  172,  172,  172,  172,  172,  172,  172,  172,  172,
 /*    40 */   172,  172,  172,  172,  172,  172,  130,  130,  130,  130,
 /*    50 */   130,  130,  130,  130,  130,  130,  130,  130,  172,  172,
 /*    60 */   163,  165,  164,  167,  172,  172,  172,  172,  172,  172,
 /*    70 */   172,  172,  172,  172,  172,  161,  172,  172,  172,  172,
 /*    80 */   172,  168,  172,  172,  172,  155,  172,  172,  172,  172,
 /*    90 */   172,  172,  172,  162,  169,  147,  149,  166,  151,  148,
 /*   100 */   146,  150,  152,  170,  153,  145,  144,  131,  129,  141,
 /*   110 */   142,  143,  171,  158,  138,  137,  139,  140,  156,  136,
 /*   120 */   135,  159,  160,  132,  133,  134,  157,
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
    const YYNOCODE = 61;
    const YYSTACKDEPTH = 100;
    const YYNSTATE = 127;
    const YYNRULE = 45;
    const YYERRORSYMBOL = 42;
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
  'T_HTML',        'T_COMMENT_OPEN',  'T_COMMENT',     'T_FOR',       
  'T_IN',          'T_CLOSEFOR',    'T_EMPTY',       'T_IF',        
  'T_ENDIF',       'T_ELSE',        'T_IFCHANGED',   'T_ENDIFCHANGED',
  'T_CUSTOM_END',  'T_BLOCK',       'T_END_BLOCK',   'T_FILTER',    
  'T_END_FILTER',  'T_CYCLE',       'T_AS',          'T_PIPE',      
  'T_STRING',      'T_LPARENT',     'T_RPARENT',     'T_NUMERIC',   
  'T_DOT',         'T_ALPHA',       'error',         'start',       
  'var_or_string',  'body',          'stmts',         'stmt',        
  'varname',       'for_stmt',      'ifchanged_stmt',  'block_stmt',  
  'filter_stmt',   'custom_stmt',   'if_stmt',       'cycle',       
  'expr',          'list',          'var_name',      'piped_list',  
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
 /*  14 */ "stmt ::= cycle",
 /*  15 */ "for_stmt ::= T_OPEN_TAG T_FOR varname T_IN varname T_CLOSE_TAG body T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG",
 /*  16 */ "for_stmt ::= T_OPEN_TAG T_FOR varname T_IN varname T_CLOSE_TAG body T_OPEN_TAG T_EMPTY T_CLOSE_TAG body T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG",
 /*  17 */ "if_stmt ::= T_OPEN_TAG T_IF expr T_CLOSE_TAG body T_OPEN_TAG T_ENDIF T_CLOSE_TAG",
 /*  18 */ "if_stmt ::= T_OPEN_TAG T_IF expr T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIF T_CLOSE_TAG",
 /*  19 */ "ifchanged_stmt ::= T_OPEN_TAG T_IFCHANGED T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  20 */ "ifchanged_stmt ::= T_OPEN_TAG T_IFCHANGED list T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  21 */ "ifchanged_stmt ::= T_OPEN_TAG T_IFCHANGED T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  22 */ "ifchanged_stmt ::= T_OPEN_TAG T_IFCHANGED list T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  23 */ "custom_stmt ::= T_OPEN_TAG varname T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  24 */ "block_stmt ::= T_OPEN_TAG T_BLOCK varname T_CLOSE_TAG body T_OPEN_TAG T_END_BLOCK T_CLOSE_TAG",
 /*  25 */ "block_stmt ::= T_OPEN_TAG T_BLOCK varname T_CLOSE_TAG body T_OPEN_TAG T_END_BLOCK var_name T_CLOSE_TAG",
 /*  26 */ "filter_stmt ::= T_OPEN_TAG T_FILTER piped_list T_CLOSE_TAG body T_OPEN_TAG T_END_FILTER T_CLOSE_TAG",
 /*  27 */ "cycle ::= T_CYCLE list",
 /*  28 */ "cycle ::= T_CYCLE list T_AS varname",
 /*  29 */ "piped_list ::= piped_list T_PIPE var_or_string",
 /*  30 */ "piped_list ::= var_or_string",
 /*  31 */ "list ::= list var_or_string",
 /*  32 */ "list ::= var_or_string",
 /*  33 */ "var_or_string ::= T_STRING",
 /*  34 */ "var_or_string ::= varname",
 /*  35 */ "expr ::= T_LPARENT expr T_RPARENT",
 /*  36 */ "expr ::= expr T_AND expr",
 /*  37 */ "expr ::= expr T_OR expr",
 /*  38 */ "expr ::= expr T_EQ|T_NE expr",
 /*  39 */ "expr ::= expr T_TIMES|T_DIV|T_MOD expr",
 /*  40 */ "expr ::= expr T_PLUS|T_MINUS expr",
 /*  41 */ "expr ::= varname",
 /*  42 */ "expr ::= T_NUMERIC",
 /*  43 */ "varname ::= varname T_DOT T_ALPHA",
 /*  44 */ "varname ::= T_ALPHA",
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
  array( 'lhs' => 43, 'rhs' => 5 ),
  array( 'lhs' => 43, 'rhs' => 1 ),
  array( 'lhs' => 45, 'rhs' => 2 ),
  array( 'lhs' => 45, 'rhs' => 0 ),
  array( 'lhs' => 46, 'rhs' => 3 ),
  array( 'lhs' => 46, 'rhs' => 3 ),
  array( 'lhs' => 46, 'rhs' => 1 ),
  array( 'lhs' => 46, 'rhs' => 1 ),
  array( 'lhs' => 46, 'rhs' => 1 ),
  array( 'lhs' => 46, 'rhs' => 2 ),
  array( 'lhs' => 46, 'rhs' => 1 ),
  array( 'lhs' => 46, 'rhs' => 1 ),
  array( 'lhs' => 46, 'rhs' => 1 ),
  array( 'lhs' => 46, 'rhs' => 1 ),
  array( 'lhs' => 47, 'rhs' => 1 ),
  array( 'lhs' => 49, 'rhs' => 10 ),
  array( 'lhs' => 49, 'rhs' => 14 ),
  array( 'lhs' => 54, 'rhs' => 8 ),
  array( 'lhs' => 54, 'rhs' => 12 ),
  array( 'lhs' => 50, 'rhs' => 7 ),
  array( 'lhs' => 50, 'rhs' => 8 ),
  array( 'lhs' => 50, 'rhs' => 11 ),
  array( 'lhs' => 50, 'rhs' => 12 ),
  array( 'lhs' => 53, 'rhs' => 7 ),
  array( 'lhs' => 51, 'rhs' => 8 ),
  array( 'lhs' => 51, 'rhs' => 9 ),
  array( 'lhs' => 52, 'rhs' => 8 ),
  array( 'lhs' => 55, 'rhs' => 2 ),
  array( 'lhs' => 55, 'rhs' => 4 ),
  array( 'lhs' => 59, 'rhs' => 3 ),
  array( 'lhs' => 59, 'rhs' => 1 ),
  array( 'lhs' => 57, 'rhs' => 2 ),
  array( 'lhs' => 57, 'rhs' => 1 ),
  array( 'lhs' => 44, 'rhs' => 1 ),
  array( 'lhs' => 44, 'rhs' => 1 ),
  array( 'lhs' => 56, 'rhs' => 3 ),
  array( 'lhs' => 56, 'rhs' => 3 ),
  array( 'lhs' => 56, 'rhs' => 3 ),
  array( 'lhs' => 56, 'rhs' => 3 ),
  array( 'lhs' => 56, 'rhs' => 3 ),
  array( 'lhs' => 56, 'rhs' => 3 ),
  array( 'lhs' => 56, 'rhs' => 1 ),
  array( 'lhs' => 56, 'rhs' => 1 ),
  array( 'lhs' => 48, 'rhs' => 3 ),
  array( 'lhs' => 48, 'rhs' => 1 ),
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
        5 => 5,
        6 => 6,
        7 => 7,
        8 => 7,
        10 => 7,
        11 => 7,
        12 => 7,
        13 => 7,
        14 => 7,
        41 => 7,
        42 => 7,
        44 => 7,
        9 => 9,
        15 => 15,
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
        32 => 30,
        31 => 31,
        33 => 33,
        34 => 34,
        35 => 35,
        36 => 36,
        37 => 36,
        38 => 36,
        39 => 36,
        40 => 36,
        43 => 43,
    );
    /* Beginning here are the reduction cases.  A typical example
    ** follows:
    **  #line <lineno> <grammarfile>
    **   function yy_r0($yymsp){ ... }           // User supplied code
    **  #line <lineno> <thisfile>
    */
#line 30 "parser.y"
    function yy_r0(){ $this->yystack[$this->yyidx + 0]->minor['base'] = $this->yystack[$this->yyidx + -2]->minor; $this->body = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1096 "parser.php"
#line 31 "parser.y"
    function yy_r1(){ $this->body = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1099 "parser.php"
#line 33 "parser.y"
    function yy_r2(){ $this->_retvalue=$this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1102 "parser.php"
#line 34 "parser.y"
    function yy_r3(){ $this->_retvalue = array();     }
#line 1105 "parser.php"
#line 37 "parser.y"
    function yy_r4(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1108 "parser.php"
#line 38 "parser.y"
    function yy_r5(){ $this->_retvalue = array('operation' => 'print', 'variable' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1111 "parser.php"
#line 39 "parser.y"
    function yy_r6(){$this->_retvalue = array('operation' => 'html', 'html' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1114 "parser.php"
#line 40 "parser.y"
    function yy_r7(){ $this->_retvalue = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1117 "parser.php"
#line 42 "parser.y"
    function yy_r9(){ $this->yystack[$this->yyidx + 0]->minor=rtrim($this->yystack[$this->yyidx + 0]->minor); $this->_retvalue = array('operation' => 'php', 'php' => "/*".substr($this->yystack[$this->yyidx + 0]->minor, 0, strlen($this->yystack[$this->yyidx + 0]->minor)-2)."*/");     }
#line 1120 "parser.php"
#line 54 "parser.y"
    function yy_r15(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -7]->minor, 'array' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1125 "parser.php"
#line 57 "parser.y"
    function yy_r16(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -11]->minor, 'array' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'empty' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1130 "parser.php"
#line 61 "parser.y"
    function yy_r17(){ $this->_retvalue = array('operation' => 'if', 'expr' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1133 "parser.php"
#line 62 "parser.y"
    function yy_r18(){ $this->_retvalue = array('operation' => 'if', 'expr' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1136 "parser.php"
#line 65 "parser.y"
    function yy_r19(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1141 "parser.php"
#line 69 "parser.y"
    function yy_r20(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -3]->minor, 'check' => $this->yystack[$this->yyidx + -5]->minor);
    }
#line 1146 "parser.php"
#line 72 "parser.y"
    function yy_r21(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1151 "parser.php"
#line 76 "parser.y"
    function yy_r22(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -7]->minor, 'check' => $this->yystack[$this->yyidx + -9]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);
    }
#line 1156 "parser.php"
#line 81 "parser.y"
    function yy_r23(){ if ('end'.$this->yystack[$this->yyidx + -5]->minor != $this->yystack[$this->yyidx + -1]->minor) { throw new Exception("Unexpected ".$this->yystack[$this->yyidx + -1]->minor); } $this->_retvalue = array('operation' => 'filter', 'functions' => array(array('var'=>$this->yystack[$this->yyidx + -5]->minor)), 'body' => $this->yystack[$this->yyidx + -3]->minor);    }
#line 1159 "parser.php"
#line 84 "parser.y"
    function yy_r24(){ $this->_retvalue = array('operation' => 'block', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1162 "parser.php"
#line 86 "parser.y"
    function yy_r25(){ $this->_retvalue = array('operation' => 'block', 'name' => $this->yystack[$this->yyidx + -6]->minor, 'body' => $this->yystack[$this->yyidx + -4]->minor);     }
#line 1165 "parser.php"
#line 89 "parser.y"
    function yy_r26(){ $this->_retvalue = array('operation' => 'filter', 'functions' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1168 "parser.php"
#line 93 "parser.y"
    function yy_r27(){ $this->_retvalue = array('operation' => 'cycle', 'vars' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1171 "parser.php"
#line 94 "parser.y"
    function yy_r28(){ $this->_retvalue = array('operation' => 'cycle', 'vars' => $this->yystack[$this->yyidx + -2]->minor, 'as' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1174 "parser.php"
#line 97 "parser.y"
    function yy_r29(){ $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1177 "parser.php"
#line 98 "parser.y"
    function yy_r30(){ $this->_retvalue = array($this->yystack[$this->yyidx + 0]->minor);     }
#line 1180 "parser.php"
#line 101 "parser.y"
    function yy_r31(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1183 "parser.php"
#line 104 "parser.y"
    function yy_r33(){ $this->_retvalue = array('string' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1186 "parser.php"
#line 105 "parser.y"
    function yy_r34(){ $this->_retvalue = array('var' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1189 "parser.php"
#line 108 "parser.y"
    function yy_r35(){ $this->_retvalue[] = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1192 "parser.php"
#line 109 "parser.y"
    function yy_r36(){ $this->_retvalue[] = array(@$this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1195 "parser.php"
#line 119 "parser.y"
    function yy_r43(){ if (!is_array($this->yystack[$this->yyidx + -2]->minor)) { $this->_retvalue = array($this->yystack[$this->yyidx + -2]->minor); } else { $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; }  $this->_retvalue[]=$this->yystack[$this->yyidx + 0]->minor;    }
#line 1198 "parser.php"

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
#line 1318 "parser.php"
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

#line 1339 "parser.php"
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