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
    const YY_SZ_ACTTAB = 451;
static public $yy_action = array(
 /*     0 */    43,   59,  164,   58,   53,  154,  109,  107,   16,   43,
 /*    10 */    59,   23,   58,   48,   54,   49,   24,   16,   25,  100,
 /*    20 */    23,   95,  150,   54,   92,   24,  150,   25,   93,   48,
 /*    30 */   150,   49,   43,   59,   18,   58,  126,   45,  150,  150,
 /*    40 */    16,  131,  102,   23,  103,  159,   54,  125,   24,   51,
 /*    50 */    25,   22,   22,   22,   30,   43,   59,   56,   58,  138,
 /*    60 */    97,  141,  150,   16,  104,  110,   23,   44,   48,   54,
 /*    70 */    49,   24,  153,   25,   65,   43,   59,  150,   58,  114,
 /*    80 */    15,   61,   93,   16,  151,  150,   23,  117,   99,   54,
 /*    90 */   135,   24,  113,   25,  147,   43,   59,   71,   58,   42,
 /*   100 */    88,  118,   72,   16,  124,  150,   23,   98,   48,   54,
 /*   110 */    49,   24,   50,   25,  121,   43,   59,  150,   58,   66,
 /*   120 */   123,   64,   93,   16,  140,  150,   23,  146,   96,   54,
 /*   130 */   150,   24,   93,   25,   57,   43,   59,   93,   58,   93,
 /*   140 */   163,  106,   90,   16,  139,  150,   23,   44,   48,   54,
 /*   150 */    49,   24,   60,   25,   93,   43,   59,  150,   58,   47,
 /*   160 */    52,   93,   93,   16,  108,  150,   23,  105,  226,   54,
 /*   170 */     9,   24,  155,   25,   81,   43,   59,   93,   58,   48,
 /*   180 */    85,   49,   80,   16,  112,  150,   23,   93,  150,   54,
 /*   190 */   122,   24,   87,   25,   78,   17,   21,   19,   19,   20,
 /*   200 */    20,   22,   22,   22,  134,  150,   91,   67,  127,   17,
 /*   210 */    21,   19,   19,   20,   20,   22,   22,   22,   43,   59,
 /*   220 */    70,   58,  152,  154,  137,   93,   16,   69,   99,   23,
 /*   230 */    82,  119,   54,   46,   24,  128,   25,   41,    2,   43,
 /*   240 */    59,  118,   58,  111,  144,    7,   27,   16,  150,   56,
 /*   250 */    23,  138,   97,   54,  116,   24,  129,   25,    5,  148,
 /*   260 */   149,  158,  160,  161,  132,  162,  157,   43,   59,  150,
 /*   270 */    58,   38,  142,   86,   56,   16,  138,   97,   23,    6,
 /*   280 */   143,   54,    8,   24,   84,   25,   21,   19,   19,   20,
 /*   290 */    20,   22,   22,   22,  182,  137,   83,  150,    4,   99,
 /*   300 */    55,   19,   19,   20,   20,   22,   22,   22,   40,   62,
 /*   310 */    12,   33,  118,   93,   56,   63,  138,   97,   44,   48,
 /*   320 */    34,   49,   11,   56,   28,  138,   97,   56,  150,  138,
 /*   330 */    97,   68,  101,   14,  130,  145,   10,   89,   99,  137,
 /*   340 */   133,   37,   13,   99,   56,    3,  138,   97,    1,   73,
 /*   350 */   133,  118,   39,  133,  133,   36,  118,  133,   56,   29,
 /*   360 */   138,   97,   56,   31,  138,   97,   56,   32,  138,   97,
 /*   370 */    56,   35,  138,   97,   56,   26,  138,   97,   56,  130,
 /*   380 */   138,   97,  133,   99,  133,  133,  133,  130,  133,  133,
 /*   390 */   133,   99,  133,  133,   75,  133,  118,  130,  133,   94,
 /*   400 */   133,   99,   79,   99,  118,  130,  133,  133,  133,   99,
 /*   410 */   133,  130,   76,  133,  118,   99,  118,  130,  133,  133,
 /*   420 */   120,   99,  118,   99,  133,  115,   77,  136,  118,   99,
 /*   430 */   133,   99,   74,  156,  118,  133,  118,   99,  133,  133,
 /*   440 */   133,  133,  118,  133,  118,  133,  133,  133,  133,  133,
 /*   450 */   118,
    );
    static public $yy_lookahead = array(
 /*     0 */    19,   20,   41,   22,   24,   44,   25,   26,   27,   19,
 /*    10 */    20,   30,   22,   40,   33,   42,   35,   27,   37,   29,
 /*    20 */    30,   31,   49,   33,   56,   35,   49,   37,   48,   40,
 /*    30 */    49,   42,   19,   20,   45,   22,   47,   12,   49,   49,
 /*    40 */    27,   13,   29,   30,   31,   18,   33,   13,   35,   21,
 /*    50 */    37,    7,    8,    9,   11,   19,   20,   14,   22,   16,
 /*    60 */    17,   13,   49,   27,   28,   29,   30,   39,   40,   33,
 /*    70 */    42,   35,   13,   37,   13,   19,   20,   49,   22,   55,
 /*    80 */    56,   13,   48,   27,   52,   49,   30,   13,   56,   33,
 /*    90 */    66,   35,   36,   37,   13,   19,   20,   13,   22,   38,
 /*   100 */    68,   69,   13,   27,   13,   49,   30,   31,   40,   33,
 /*   110 */    42,   35,   21,   37,   13,   19,   20,   49,   22,   13,
 /*   120 */    13,   13,   48,   27,   13,   49,   30,   13,   32,   33,
 /*   130 */    49,   35,   48,   37,   21,   19,   20,   48,   22,   48,
 /*   140 */    13,   25,   56,   27,   15,   49,   30,   39,   40,   33,
 /*   150 */    42,   35,   13,   37,   48,   19,   20,   49,   22,   20,
 /*   160 */    21,   48,   48,   27,   11,   49,   30,   31,   51,   33,
 /*   170 */    53,   35,   44,   37,   56,   19,   20,   48,   22,   40,
 /*   180 */    56,   42,   56,   27,   28,   49,   30,   48,   49,   33,
 /*   190 */    13,   35,   70,   37,   56,    1,    2,    3,    4,    5,
 /*   200 */     6,    7,    8,    9,   13,   49,   56,   13,   13,    1,
 /*   210 */     2,    3,    4,    5,    6,    7,    8,    9,   19,   20,
 /*   220 */    13,   22,   43,   44,   52,   48,   27,   13,   56,   30,
 /*   230 */    70,   49,   33,   34,   35,   13,   37,   65,   53,   19,
 /*   240 */    20,   69,   22,   23,   13,   53,   11,   27,   49,   14,
 /*   250 */    30,   16,   17,   33,   46,   35,   54,   37,   53,   57,
 /*   260 */    58,   59,   60,   61,   62,   63,   64,   19,   20,   49,
 /*   270 */    22,   11,   13,   56,   14,   27,   16,   17,   30,   53,
 /*   280 */    13,   33,   53,   35,   56,   37,    2,    3,    4,    5,
 /*   290 */     6,    7,    8,    9,    0,   52,   56,   49,   53,   56,
 /*   300 */    21,    3,    4,    5,    6,    7,    8,    9,   65,   13,
 /*   310 */    53,   11,   69,   48,   14,   13,   16,   17,   39,   40,
 /*   320 */    11,   42,   53,   14,   11,   16,   17,   14,   49,   16,
 /*   330 */    17,   13,   56,   53,   52,   13,   53,   56,   56,   52,
 /*   340 */    71,   11,   53,   56,   14,   53,   16,   17,   53,   67,
 /*   350 */    71,   69,   65,   71,   71,   11,   69,   71,   14,   11,
 /*   360 */    16,   17,   14,   11,   16,   17,   14,   11,   16,   17,
 /*   370 */    14,   11,   16,   17,   14,   11,   16,   17,   14,   52,
 /*   380 */    16,   17,   71,   56,   71,   71,   71,   52,   71,   71,
 /*   390 */    71,   56,   71,   71,   67,   71,   69,   52,   71,   52,
 /*   400 */    71,   56,   67,   56,   69,   52,   71,   71,   71,   56,
 /*   410 */    71,   52,   67,   71,   69,   56,   69,   52,   71,   52,
 /*   420 */    67,   56,   69,   56,   71,   52,   67,   52,   69,   56,
 /*   430 */    71,   56,   67,   52,   69,   71,   69,   56,   71,   71,
 /*   440 */    71,   71,   69,   71,   69,   71,   71,   71,   71,   71,
 /*   450 */    69,
);
    const YY_SHIFT_USE_DFLT = -40;
    const YY_SHIFT_MAX = 115;
    static public $yy_shift_ofst = array(
 /*     0 */   153,  235,   43,  352,  348,  356,  360,  364,  344,  260,
 /*    10 */   330,  300,  260,  309,  313,  139,  -11,  -11,  -11,  -11,
 /*    20 */   -11,  -11,  -11,   68,  -27,  -27,   13,   36,  -19,  -10,
 /*    30 */   220,  199,  136,  156,   56,   76,   96,  116,  248,   28,
 /*    40 */   108,  279,  -27,  -27,  -27,  -27,   81,  -23,  128,  128,
 /*    50 */   -23,  -23,  -23,  -23,  -23,  -23,  -23,  -23,  -23,  -23,
 /*    60 */   294,  -40,  -40,  -40,  -40,  -40,  -40,  -40,  -40,  -40,
 /*    70 */   -40,  -40,  -40,  194,  208,  284,  298,  298,   91,   44,
 /*    80 */    34,   84,  179,  -20,  113,  177,  129,  -39,   61,   89,
 /*    90 */   106,  114,   74,  182,  222,   59,  101,   27,  107,  265,
 /*   100 */   302,  265,  296,  259,  267,  231,  322,  318,   25,   48,
 /*   110 */   207,  191,  127,  111,  195,  214,
);
    const YY_REDUCE_USE_DFLT = -33;
    const YY_REDUCE_MAX = 72;
    static public $yy_reduce_ofst = array(
 /*     0 */   117,  202,  202,  202,  202,  202,  202,  202,  202,  202,
 /*    10 */   202,  202,  202,  202,  202,  287,  282,  327,  365,  345,
 /*    20 */   335,  359,  353,  243,   32,  172,   24,   24,   24,   24,
 /*    30 */    24,   24,   24,   24,   24,   24,   24,   24,   24,  367,
 /*    40 */   367,  367,  381,  347,  375,  373,  150,  138,  122,  160,
 /*    50 */   124,  -32,  126,  118,   86,  276,  217,  281,  228,  240,
 /*    60 */   229,  192,  205,  226,  245,  289,  292,  295,  283,  257,
 /*    70 */   269,  280,  185,
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
        /* 14 */ array(11, 14, 16, 17, ),
        /* 15 */ array(13, 20, 21, 40, 42, 48, 49, ),
        /* 16 */ array(40, 42, 45, 47, 49, ),
        /* 17 */ array(40, 42, 45, 47, 49, ),
        /* 18 */ array(40, 42, 45, 47, 49, ),
        /* 19 */ array(40, 42, 45, 47, 49, ),
        /* 20 */ array(40, 42, 45, 47, 49, ),
        /* 21 */ array(40, 42, 45, 47, 49, ),
        /* 22 */ array(40, 42, 45, 47, 49, ),
        /* 23 */ array(13, 40, 42, 49, ),
        /* 24 */ array(40, 42, 49, ),
        /* 25 */ array(40, 42, 49, ),
        /* 26 */ array(19, 20, 22, 27, 29, 30, 31, 33, 35, 37, 49, ),
        /* 27 */ array(19, 20, 22, 27, 28, 29, 30, 33, 35, 37, 49, ),
        /* 28 */ array(19, 20, 22, 25, 26, 27, 30, 33, 35, 37, 49, ),
        /* 29 */ array(19, 20, 22, 27, 29, 30, 31, 33, 35, 37, 49, ),
        /* 30 */ array(19, 20, 22, 23, 27, 30, 33, 35, 37, 49, ),
        /* 31 */ array(19, 20, 22, 27, 30, 33, 34, 35, 37, 49, ),
        /* 32 */ array(19, 20, 22, 27, 30, 31, 33, 35, 37, 49, ),
        /* 33 */ array(19, 20, 22, 27, 28, 30, 33, 35, 37, 49, ),
        /* 34 */ array(19, 20, 22, 27, 30, 33, 35, 36, 37, 49, ),
        /* 35 */ array(19, 20, 22, 27, 30, 31, 33, 35, 37, 49, ),
        /* 36 */ array(19, 20, 22, 27, 30, 32, 33, 35, 37, 49, ),
        /* 37 */ array(19, 20, 22, 25, 27, 30, 33, 35, 37, 49, ),
        /* 38 */ array(19, 20, 22, 27, 30, 33, 35, 37, 49, ),
        /* 39 */ array(13, 21, 39, 40, 42, 49, ),
        /* 40 */ array(13, 39, 40, 42, 49, ),
        /* 41 */ array(21, 39, 40, 42, 49, ),
        /* 42 */ array(40, 42, 49, ),
        /* 43 */ array(40, 42, 49, ),
        /* 44 */ array(40, 42, 49, ),
        /* 45 */ array(40, 42, 49, ),
        /* 46 */ array(13, 49, ),
        /* 47 */ array(49, ),
        /* 48 */ array(44, ),
        /* 49 */ array(44, ),
        /* 50 */ array(49, ),
        /* 51 */ array(49, ),
        /* 52 */ array(49, ),
        /* 53 */ array(49, ),
        /* 54 */ array(49, ),
        /* 55 */ array(49, ),
        /* 56 */ array(49, ),
        /* 57 */ array(49, ),
        /* 58 */ array(49, ),
        /* 59 */ array(49, ),
        /* 60 */ array(0, ),
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
        /* 71 */ array(),
        /* 72 */ array(),
        /* 73 */ array(1, 2, 3, 4, 5, 6, 7, 8, 9, 13, ),
        /* 74 */ array(1, 2, 3, 4, 5, 6, 7, 8, 9, 46, ),
        /* 75 */ array(2, 3, 4, 5, 6, 7, 8, 9, ),
        /* 76 */ array(3, 4, 5, 6, 7, 8, 9, ),
        /* 77 */ array(3, 4, 5, 6, 7, 8, 9, ),
        /* 78 */ array(13, 21, 48, ),
        /* 79 */ array(7, 8, 9, ),
        /* 80 */ array(13, 48, ),
        /* 81 */ array(13, 48, ),
        /* 82 */ array(43, 44, ),
        /* 83 */ array(24, 48, ),
        /* 84 */ array(21, 48, ),
        /* 85 */ array(13, 48, ),
        /* 86 */ array(15, 48, ),
        /* 87 */ array(41, 44, ),
        /* 88 */ array(13, 38, ),
        /* 89 */ array(13, 48, ),
        /* 90 */ array(13, 48, ),
        /* 91 */ array(13, 48, ),
        /* 92 */ array(13, 48, ),
        /* 93 */ array(49, ),
        /* 94 */ array(13, ),
        /* 95 */ array(13, ),
        /* 96 */ array(13, ),
        /* 97 */ array(18, ),
        /* 98 */ array(13, ),
        /* 99 */ array(48, ),
        /* 100 */ array(13, ),
        /* 101 */ array(48, ),
        /* 102 */ array(13, ),
        /* 103 */ array(13, ),
        /* 104 */ array(13, ),
        /* 105 */ array(13, ),
        /* 106 */ array(13, ),
        /* 107 */ array(13, ),
        /* 108 */ array(12, ),
        /* 109 */ array(13, ),
        /* 110 */ array(13, ),
        /* 111 */ array(13, ),
        /* 112 */ array(13, ),
        /* 113 */ array(13, ),
        /* 114 */ array(13, ),
        /* 115 */ array(13, ),
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
        /* 164 */ array(),
);
    static public $yy_default = array(
 /*     0 */   168,  225,  225,  225,  225,  225,  225,  225,  225,  166,
 /*    10 */   225,  225,  165,  225,  225,  225,  225,  225,  225,  225,
 /*    20 */   225,  225,  225,  225,  225,  225,  225,  225,  225,  225,
 /*    30 */   225,  225,  225,  225,  225,  225,  225,  225,  225,  225,
 /*    40 */   225,  202,  225,  225,  225,  225,  225,  225,  225,  225,
 /*    50 */   225,  225,  225,  225,  225,  225,  225,  225,  225,  225,
 /*    60 */   168,  168,  168,  168,  168,  168,  168,  168,  168,  168,
 /*    70 */   168,  168,  168,  225,  225,  216,  218,  217,  225,  220,
 /*    80 */   225,  225,  225,  225,  225,  225,  225,  225,  225,  225,
 /*    90 */   225,  225,  225,  225,  225,  225,  225,  225,  225,  209,
 /*   100 */   225,  203,  225,  225,  225,  225,  225,  225,  225,  225,
 /*   110 */   225,  225,  225,  225,  225,  225,  215,  187,  210,  223,
 /*   120 */   219,  198,  184,  197,  183,  185,  222,  169,  179,  167,
 /*   130 */   221,  186,  178,  206,  188,  189,  207,  208,  171,  170,
 /*   140 */   201,  190,  194,  192,  196,  191,  200,  199,  172,  173,
 /*   150 */   224,  205,  212,  195,  213,  214,  204,  181,  175,  174,
 /*   160 */   176,  177,  180,  193,  211,
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
    const YYNOCODE = 72;
    const YYSTACKDEPTH = 100;
    const YYNSTATE = 165;
    const YYNRULE = 60;
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
  'T_EXTENDS',     'T_CLOSE_TAG',   'T_PRINT_OPEN',  'T_PRINT_CLOSE',
  'T_HTML',        'T_COMMENT_OPEN',  'T_COMMENT',     'T_INCLUDE',   
  'T_FOR',         'T_AS',          'T_WITH',        'T_ENDWITH',   
  'T_IN',          'T_CLOSEFOR',    'T_EMPTY',       'T_IF',        
  'T_ENDIF',       'T_ELSE',        'T_IFCHANGED',   'T_ENDIFCHANGED',
  'T_CUSTOM_END',  'T_BLOCK',       'T_END_BLOCK',   'T_FILTER',    
  'T_END_FILTER',  'T_CYCLE',       'T_PIPE',        'T_COMMA',     
  'T_STRING_SINGLE_INIT',  'T_STRING_SINGLE_END',  'T_STRING_DOUBLE_INIT',  'T_STRING_DOUBLE_END',
  'T_STRING_CONTENT',  'T_LPARENT',     'T_RPARENT',     'T_NUMERIC',   
  'T_DOT',         'T_ALPHA',       'error',         'start',       
  'var_or_string',  'body',          'stmts',         'stmt',        
  'varname',       'for_stmt',      'ifchanged_stmt',  'block_stmt',  
  'filter_stmt',   'custom_stmt',   'if_stmt',       'fnc_call_stmt',
  'alias',         'list',          'cycle',         'expr',        
  'piped_list',    'string',        's_content',   
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
 /*  16 */ "stmts ::= alias",
 /*  17 */ "fnc_call_stmt ::= T_OPEN_TAG varname T_CLOSE_TAG",
 /*  18 */ "fnc_call_stmt ::= T_OPEN_TAG varname T_FOR varname T_CLOSE_TAG",
 /*  19 */ "fnc_call_stmt ::= T_OPEN_TAG varname T_FOR varname T_AS varname T_CLOSE_TAG",
 /*  20 */ "fnc_call_stmt ::= T_OPEN_TAG varname T_AS varname T_CLOSE_TAG",
 /*  21 */ "fnc_call_stmt ::= T_OPEN_TAG varname list T_CLOSE_TAG",
 /*  22 */ "fnc_call_stmt ::= T_OPEN_TAG varname list T_AS varname T_CLOSE_TAG",
 /*  23 */ "alias ::= T_OPEN_TAG T_WITH varname T_AS varname T_CLOSE_TAG body T_OPEN_TAG T_ENDWITH T_CLOSE_TAG",
 /*  24 */ "stmt ::= cycle",
 /*  25 */ "for_stmt ::= T_OPEN_TAG T_FOR varname T_IN varname T_CLOSE_TAG body T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG",
 /*  26 */ "for_stmt ::= T_OPEN_TAG T_FOR varname T_IN varname T_CLOSE_TAG body T_OPEN_TAG T_EMPTY T_CLOSE_TAG body T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG",
 /*  27 */ "if_stmt ::= T_OPEN_TAG T_IF expr T_CLOSE_TAG body T_OPEN_TAG T_ENDIF T_CLOSE_TAG",
 /*  28 */ "if_stmt ::= T_OPEN_TAG T_IF expr T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIF T_CLOSE_TAG",
 /*  29 */ "ifchanged_stmt ::= T_OPEN_TAG T_IFCHANGED T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  30 */ "ifchanged_stmt ::= T_OPEN_TAG T_IFCHANGED list T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  31 */ "ifchanged_stmt ::= T_OPEN_TAG T_IFCHANGED T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  32 */ "ifchanged_stmt ::= T_OPEN_TAG T_IFCHANGED list T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  33 */ "custom_stmt ::= T_OPEN_TAG varname T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  34 */ "block_stmt ::= T_OPEN_TAG T_BLOCK varname T_CLOSE_TAG body T_OPEN_TAG T_END_BLOCK T_CLOSE_TAG",
 /*  35 */ "block_stmt ::= T_OPEN_TAG T_BLOCK varname T_CLOSE_TAG body T_OPEN_TAG T_END_BLOCK varname T_CLOSE_TAG",
 /*  36 */ "filter_stmt ::= T_OPEN_TAG T_FILTER piped_list T_CLOSE_TAG body T_OPEN_TAG T_END_FILTER T_CLOSE_TAG",
 /*  37 */ "cycle ::= T_CYCLE list",
 /*  38 */ "cycle ::= T_CYCLE list T_AS varname",
 /*  39 */ "piped_list ::= piped_list T_PIPE var_or_string",
 /*  40 */ "piped_list ::= var_or_string",
 /*  41 */ "list ::= list var_or_string",
 /*  42 */ "list ::= list T_COMMA var_or_string",
 /*  43 */ "list ::= var_or_string",
 /*  44 */ "var_or_string ::= varname",
 /*  45 */ "var_or_string ::= string",
 /*  46 */ "string ::= T_STRING_SINGLE_INIT s_content T_STRING_SINGLE_END",
 /*  47 */ "string ::= T_STRING_DOUBLE_INIT s_content T_STRING_DOUBLE_END",
 /*  48 */ "s_content ::= s_content T_STRING_CONTENT",
 /*  49 */ "s_content ::= T_STRING_CONTENT",
 /*  50 */ "expr ::= T_LPARENT expr T_RPARENT",
 /*  51 */ "expr ::= expr T_AND expr",
 /*  52 */ "expr ::= expr T_OR expr",
 /*  53 */ "expr ::= expr T_EQ|T_NE expr",
 /*  54 */ "expr ::= expr T_TIMES|T_DIV|T_MOD expr",
 /*  55 */ "expr ::= expr T_PLUS|T_MINUS expr",
 /*  56 */ "expr ::= var_or_string",
 /*  57 */ "expr ::= T_NUMERIC",
 /*  58 */ "varname ::= varname T_DOT T_ALPHA",
 /*  59 */ "varname ::= T_ALPHA",
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
  array( 'lhs' => 51, 'rhs' => 5 ),
  array( 'lhs' => 51, 'rhs' => 1 ),
  array( 'lhs' => 53, 'rhs' => 2 ),
  array( 'lhs' => 53, 'rhs' => 0 ),
  array( 'lhs' => 54, 'rhs' => 3 ),
  array( 'lhs' => 54, 'rhs' => 3 ),
  array( 'lhs' => 54, 'rhs' => 1 ),
  array( 'lhs' => 54, 'rhs' => 1 ),
  array( 'lhs' => 54, 'rhs' => 1 ),
  array( 'lhs' => 54, 'rhs' => 2 ),
  array( 'lhs' => 54, 'rhs' => 1 ),
  array( 'lhs' => 54, 'rhs' => 1 ),
  array( 'lhs' => 54, 'rhs' => 1 ),
  array( 'lhs' => 54, 'rhs' => 1 ),
  array( 'lhs' => 54, 'rhs' => 4 ),
  array( 'lhs' => 54, 'rhs' => 1 ),
  array( 'lhs' => 54, 'rhs' => 1 ),
  array( 'lhs' => 63, 'rhs' => 3 ),
  array( 'lhs' => 63, 'rhs' => 5 ),
  array( 'lhs' => 63, 'rhs' => 7 ),
  array( 'lhs' => 63, 'rhs' => 5 ),
  array( 'lhs' => 63, 'rhs' => 4 ),
  array( 'lhs' => 63, 'rhs' => 6 ),
  array( 'lhs' => 64, 'rhs' => 10 ),
  array( 'lhs' => 55, 'rhs' => 1 ),
  array( 'lhs' => 57, 'rhs' => 10 ),
  array( 'lhs' => 57, 'rhs' => 14 ),
  array( 'lhs' => 62, 'rhs' => 8 ),
  array( 'lhs' => 62, 'rhs' => 12 ),
  array( 'lhs' => 58, 'rhs' => 7 ),
  array( 'lhs' => 58, 'rhs' => 8 ),
  array( 'lhs' => 58, 'rhs' => 11 ),
  array( 'lhs' => 58, 'rhs' => 12 ),
  array( 'lhs' => 61, 'rhs' => 7 ),
  array( 'lhs' => 59, 'rhs' => 8 ),
  array( 'lhs' => 59, 'rhs' => 9 ),
  array( 'lhs' => 60, 'rhs' => 8 ),
  array( 'lhs' => 66, 'rhs' => 2 ),
  array( 'lhs' => 66, 'rhs' => 4 ),
  array( 'lhs' => 68, 'rhs' => 3 ),
  array( 'lhs' => 68, 'rhs' => 1 ),
  array( 'lhs' => 65, 'rhs' => 2 ),
  array( 'lhs' => 65, 'rhs' => 3 ),
  array( 'lhs' => 65, 'rhs' => 1 ),
  array( 'lhs' => 52, 'rhs' => 1 ),
  array( 'lhs' => 52, 'rhs' => 1 ),
  array( 'lhs' => 69, 'rhs' => 3 ),
  array( 'lhs' => 69, 'rhs' => 3 ),
  array( 'lhs' => 70, 'rhs' => 2 ),
  array( 'lhs' => 70, 'rhs' => 1 ),
  array( 'lhs' => 67, 'rhs' => 3 ),
  array( 'lhs' => 67, 'rhs' => 3 ),
  array( 'lhs' => 67, 'rhs' => 3 ),
  array( 'lhs' => 67, 'rhs' => 3 ),
  array( 'lhs' => 67, 'rhs' => 3 ),
  array( 'lhs' => 67, 'rhs' => 3 ),
  array( 'lhs' => 67, 'rhs' => 1 ),
  array( 'lhs' => 67, 'rhs' => 1 ),
  array( 'lhs' => 56, 'rhs' => 3 ),
  array( 'lhs' => 56, 'rhs' => 1 ),
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
        50 => 4,
        5 => 5,
        6 => 6,
        7 => 7,
        8 => 7,
        10 => 7,
        11 => 7,
        12 => 7,
        13 => 7,
        15 => 7,
        16 => 7,
        24 => 7,
        49 => 7,
        56 => 7,
        57 => 7,
        59 => 7,
        9 => 9,
        14 => 14,
        17 => 17,
        18 => 18,
        19 => 19,
        20 => 20,
        21 => 21,
        22 => 22,
        23 => 23,
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
        36 => 36,
        37 => 37,
        38 => 38,
        39 => 39,
        42 => 39,
        40 => 40,
        43 => 40,
        41 => 41,
        44 => 44,
        45 => 45,
        46 => 46,
        47 => 46,
        48 => 48,
        51 => 51,
        52 => 51,
        53 => 51,
        54 => 51,
        55 => 51,
        58 => 58,
    );
    /* Beginning here are the reduction cases.  A typical example
    ** follows:
    **  #line <lineno> <grammarfile>
    **   function yy_r0($yymsp){ ... }           // User supplied code
    **  #line <lineno> <thisfile>
    */
#line 30 "parser.y"
    function yy_r0(){ $this->yystack[$this->yyidx + 0]->minor['base'] = $this->yystack[$this->yyidx + -2]->minor; $this->body = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1230 "parser.php"
#line 31 "parser.y"
    function yy_r1(){ $this->body = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1233 "parser.php"
#line 33 "parser.y"
    function yy_r2(){ $this->_retvalue=$this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1236 "parser.php"
#line 34 "parser.y"
    function yy_r3(){ $this->_retvalue = array();     }
#line 1239 "parser.php"
#line 37 "parser.y"
    function yy_r4(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1242 "parser.php"
#line 38 "parser.y"
    function yy_r5(){ $this->_retvalue = array('operation' => 'print', 'variable' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1245 "parser.php"
#line 39 "parser.y"
    function yy_r6(){$this->_retvalue = array('operation' => 'html', 'html' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1248 "parser.php"
#line 40 "parser.y"
    function yy_r7(){ $this->_retvalue = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1251 "parser.php"
#line 42 "parser.y"
    function yy_r9(){ $this->yystack[$this->yyidx + 0]->minor=rtrim($this->yystack[$this->yyidx + 0]->minor); $this->_retvalue = array('operation' => 'php', 'php' => "/*".substr($this->yystack[$this->yyidx + 0]->minor, 0, strlen($this->yystack[$this->yyidx + 0]->minor)-2)."*/");     }
#line 1254 "parser.php"
#line 47 "parser.y"
    function yy_r14(){ $this->_retvalue = array('operation' => 'include', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1257 "parser.php"
#line 54 "parser.y"
    function yy_r17(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -1]->minor, 'list'=>array());     }
#line 1260 "parser.php"
#line 55 "parser.y"
    function yy_r18(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -3]->minor, 'for' => $this->yystack[$this->yyidx + -1]->minor, 'list' => array());     }
#line 1263 "parser.php"
#line 56 "parser.y"
    function yy_r19(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'for' => $this->yystack[$this->yyidx + -3]->minor, 'list' => array(),'as' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1266 "parser.php"
#line 57 "parser.y"
    function yy_r20(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -3]->minor, 'as' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1269 "parser.php"
#line 58 "parser.y"
    function yy_r21(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -2]->minor, 'list' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1272 "parser.php"
#line 59 "parser.y"
    function yy_r22(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -4]->minor, 'as' => $this->yystack[$this->yyidx + -1]->minor, 'list' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1275 "parser.php"
#line 62 "parser.y"
    function yy_r23(){ $this->_retvalue = array('operation' => 'alias', 'var' => $this->yystack[$this->yyidx + -7]->minor, 'as' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1278 "parser.php"
#line 68 "parser.y"
    function yy_r25(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -7]->minor, 'array' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1283 "parser.php"
#line 71 "parser.y"
    function yy_r26(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -11]->minor, 'array' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'empty' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1288 "parser.php"
#line 75 "parser.y"
    function yy_r27(){ $this->_retvalue = array('operation' => 'if', 'expr' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1291 "parser.php"
#line 76 "parser.y"
    function yy_r28(){ $this->_retvalue = array('operation' => 'if', 'expr' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1294 "parser.php"
#line 79 "parser.y"
    function yy_r29(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1299 "parser.php"
#line 83 "parser.y"
    function yy_r30(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -3]->minor, 'check' => $this->yystack[$this->yyidx + -5]->minor);
    }
#line 1304 "parser.php"
#line 86 "parser.y"
    function yy_r31(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1309 "parser.php"
#line 90 "parser.y"
    function yy_r32(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -7]->minor, 'check' => $this->yystack[$this->yyidx + -9]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);
    }
#line 1314 "parser.php"
#line 95 "parser.y"
    function yy_r33(){ if ('end'.$this->yystack[$this->yyidx + -5]->minor != $this->yystack[$this->yyidx + -1]->minor) { throw new Exception("Unexpected ".$this->yystack[$this->yyidx + -1]->minor); } $this->_retvalue = array('operation' => 'filter', 'functions' => array(array('var'=>$this->yystack[$this->yyidx + -5]->minor)), 'body' => $this->yystack[$this->yyidx + -3]->minor);    }
#line 1317 "parser.php"
#line 98 "parser.y"
    function yy_r34(){ $this->_retvalue = array('operation' => 'block', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1320 "parser.php"
#line 100 "parser.y"
    function yy_r35(){ $this->_retvalue = array('operation' => 'block', 'name' => $this->yystack[$this->yyidx + -6]->minor, 'body' => $this->yystack[$this->yyidx + -4]->minor);     }
#line 1323 "parser.php"
#line 103 "parser.y"
    function yy_r36(){ $this->_retvalue = array('operation' => 'filter', 'functions' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1326 "parser.php"
#line 107 "parser.y"
    function yy_r37(){ $this->_retvalue = array('operation' => 'cycle', 'vars' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1329 "parser.php"
#line 108 "parser.y"
    function yy_r38(){ $this->_retvalue = array('operation' => 'cycle', 'vars' => $this->yystack[$this->yyidx + -2]->minor, 'as' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1332 "parser.php"
#line 111 "parser.y"
    function yy_r39(){ $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1335 "parser.php"
#line 112 "parser.y"
    function yy_r40(){ $this->_retvalue = array($this->yystack[$this->yyidx + 0]->minor);     }
#line 1338 "parser.php"
#line 115 "parser.y"
    function yy_r41(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1341 "parser.php"
#line 119 "parser.y"
    function yy_r44(){ $this->_retvalue = array('var' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1344 "parser.php"
#line 120 "parser.y"
    function yy_r45(){ $this->_retvalue = array('string' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1347 "parser.php"
#line 122 "parser.y"
    function yy_r46(){  $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1350 "parser.php"
#line 124 "parser.y"
    function yy_r48(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor.$this->yystack[$this->yyidx + 0]->minor;     }
#line 1353 "parser.php"
#line 129 "parser.y"
    function yy_r51(){ $this->_retvalue = array('op' => @$this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1356 "parser.php"
#line 139 "parser.y"
    function yy_r58(){ if (!is_array($this->yystack[$this->yyidx + -2]->minor)) { $this->_retvalue = array($this->yystack[$this->yyidx + -2]->minor); } else { $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; }  $this->_retvalue[]=$this->yystack[$this->yyidx + 0]->minor;    }
#line 1359 "parser.php"

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
#line 1479 "parser.php"
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

#line 1500 "parser.php"
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