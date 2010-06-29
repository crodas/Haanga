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
    const YY_NO_ACTION = 232;
    const YY_ACCEPT_ACTION = 231;
    const YY_ERROR_ACTION = 230;

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
    const YY_SZ_ACTTAB = 473;
static public $yy_action = array(
 /*     0 */   231,  151,   10,   60,   63,   70,  123,  134,  118,  122,
 /*    10 */   167,  158,  163,  115,  162,   47,   61,   67,   50,   51,
 /*    20 */    65,   52,   64,   19,  101,  105,   24,  127,  124,   53,
 /*    30 */   115,   25,  140,   26,  155,   32,   47,   61,   49,   50,
 /*    40 */   129,  100,   44,  145,   19,  124,  116,   24,  114,   51,
 /*    50 */    53,   52,   25,  153,   26,   96,   47,   61,  124,   50,
 /*    60 */   115,  135,  106,  110,   19,   43,  124,   24,  160,  154,
 /*    70 */    53,  161,   25,  136,   26,    8,   28,   47,   61,   49,
 /*    80 */    50,  129,  100,  126,  131,   19,  124,  104,   24,  103,
 /*    90 */    46,   53,   57,   25,    2,   26,  115,   47,   61,   74,
 /*   100 */    50,   18,   18,   18,  133,   19,   56,  124,   24,  125,
 /*   110 */   121,   53,   96,   25,   55,   26,  144,   47,   61,  115,
 /*   120 */    50,   59,   58,   12,   79,   19,  154,  124,   24,  111,
 /*   130 */   115,   53,    7,   25,  115,   26,    4,   47,   61,  115,
 /*   140 */    50,   51,   73,   52,  115,   19,  107,  124,   24,  115,
 /*   150 */   124,   53,  124,   25,  156,   26,  157,   47,   61,   69,
 /*   160 */    50,  109,  132,  139,   71,   19,  143,  124,   24,   72,
 /*   170 */   165,   53,   96,   25,  147,   26,  150,   21,   22,   23,
 /*   180 */    23,   17,   17,   18,   18,   18,  154,  124,  141,   21,
 /*   190 */    22,   23,   23,   17,   17,   18,   18,   18,  115,   47,
 /*   200 */    61,   75,   50,  142,  115,   96,  148,   19,  149,   51,
 /*   210 */    24,   52,  102,   53,   20,   25,  120,   26,  124,  154,
 /*   220 */    47,   61,  159,   50,  164,  161,  124,   33,   19,  124,
 /*   230 */    49,   24,  129,  100,   53,   48,   25,   66,   26,   29,
 /*   240 */    47,   61,   49,   50,  129,  100,   89,   92,   19,    6,
 /*   250 */   124,   24,   97,   90,   53,   86,   25,  187,   26,   82,
 /*   260 */    47,   61,   93,   50,   91,   94,   85,  137,   19,   87,
 /*   270 */   124,   24,  115,  121,   53,   96,   25,  117,   26,  146,
 /*   280 */    47,   61,   95,   50,   88,  108,   99,   77,   19,  154,
 /*   290 */   124,   24,   83,   14,   53,  136,   25,  128,   26,  123,
 /*   300 */   134,  118,  122,  167,  158,  163,    1,  162,   47,   61,
 /*   310 */   124,   50,   34,    5,  136,   49,   19,  129,  100,   24,
 /*   320 */     3,   13,   53,   15,   25,   68,   26,   22,   23,   23,
 /*   330 */    17,   17,   18,   18,   18,    9,   11,  136,  124,  136,
 /*   340 */   136,  130,   23,   23,   17,   17,   18,   18,   18,   54,
 /*   350 */   136,   45,   51,   62,   52,  136,  136,   40,   16,  136,
 /*   360 */    49,  124,  129,  100,  136,  136,   98,   45,   51,  138,
 /*   370 */    52,   45,   51,   35,   52,  136,   49,  124,  129,  100,
 /*   380 */    38,  124,  136,   49,   37,  129,  100,   49,   27,  129,
 /*   390 */   100,   49,   30,  129,  100,   49,   36,  129,  100,   49,
 /*   400 */   136,  129,  100,  121,  121,   96,   96,  121,   31,   96,
 /*   410 */   136,   49,  136,  129,  100,  136,  136,   76,   78,  154,
 /*   420 */   154,   80,  166,  154,   96,  121,   39,   96,  153,   49,
 /*   430 */    96,  129,  100,  153,  121,   96,   96,   84,  154,   81,
 /*   440 */    41,  154,  136,  136,  154,   42,  136,  136,  119,  154,
 /*   450 */   154,  136,  112,  113,   96,   96,  152,  136,   96,  136,
 /*   460 */   136,  136,  136,  136,  136,  136,  136,  136,  154,  154,
 /*   470 */   136,  136,  154,
    );
    static public $yy_lookahead = array(
 /*     0 */    51,   52,   53,   21,   55,   13,   57,   58,   59,   60,
 /*    10 */    61,   62,   63,   48,   65,   19,   20,   13,   22,   40,
 /*    20 */    13,   42,   13,   27,   28,   29,   30,   15,   49,   33,
 /*    30 */    48,   35,   13,   37,   13,   11,   19,   20,   14,   22,
 /*    40 */    16,   17,   38,   13,   27,   49,   29,   30,   31,   40,
 /*    50 */    33,   42,   35,   54,   37,   56,   19,   20,   49,   22,
 /*    60 */    48,   13,   25,   26,   27,   66,   49,   30,   41,   70,
 /*    70 */    33,   44,   35,   13,   37,   53,   11,   19,   20,   14,
 /*    80 */    22,   16,   17,   49,   13,   27,   49,   29,   30,   31,
 /*    90 */    12,   33,   21,   35,   53,   37,   48,   19,   20,   13,
 /*   100 */    22,    7,    8,    9,   13,   27,   24,   49,   30,   13,
 /*   110 */    54,   33,   56,   35,   13,   37,   13,   19,   20,   48,
 /*   120 */    22,   20,   21,   53,   68,   27,   70,   49,   30,   31,
 /*   130 */    48,   33,   53,   35,   48,   37,   53,   19,   20,   48,
 /*   140 */    22,   40,   13,   42,   48,   27,   28,   49,   30,   48,
 /*   150 */    49,   33,   49,   35,   13,   37,   13,   19,   20,   13,
 /*   160 */    22,   23,   18,   13,   13,   27,   13,   49,   30,   13,
 /*   170 */    54,   33,   56,   35,   13,   37,   13,    1,    2,    3,
 /*   180 */     4,    5,    6,    7,    8,    9,   70,   49,   13,    1,
 /*   190 */     2,    3,    4,    5,    6,    7,    8,    9,   48,   19,
 /*   200 */    20,   13,   22,   54,   48,   56,   13,   27,   13,   40,
 /*   210 */    30,   42,   32,   33,   45,   35,   47,   37,   49,   70,
 /*   220 */    19,   20,   46,   22,   43,   44,   49,   11,   27,   49,
 /*   230 */    14,   30,   16,   17,   33,   34,   35,   13,   37,   11,
 /*   240 */    19,   20,   14,   22,   16,   17,   56,   56,   27,   53,
 /*   250 */    49,   30,   31,   56,   33,   56,   35,    0,   37,   56,
 /*   260 */    19,   20,   56,   22,   56,   56,   56,   44,   27,   71,
 /*   270 */    49,   30,   48,   54,   33,   56,   35,   36,   37,   13,
 /*   280 */    19,   20,   56,   22,   71,   56,   25,   68,   27,   70,
 /*   290 */    49,   30,   56,   53,   33,   72,   35,   55,   37,   57,
 /*   300 */    58,   59,   60,   61,   62,   63,   53,   65,   19,   20,
 /*   310 */    49,   22,   11,   53,   72,   14,   27,   16,   17,   30,
 /*   320 */    53,   53,   33,   53,   35,   13,   37,    2,    3,    4,
 /*   330 */     5,    6,    7,    8,    9,   53,   53,   72,   49,   72,
 /*   340 */    72,   13,    3,    4,    5,    6,    7,    8,    9,   21,
 /*   350 */    72,   39,   40,   21,   42,   72,   72,   11,   56,   72,
 /*   360 */    14,   49,   16,   17,   72,   72,   64,   39,   40,   67,
 /*   370 */    42,   39,   40,   11,   42,   72,   14,   49,   16,   17,
 /*   380 */    11,   49,   72,   14,   11,   16,   17,   14,   11,   16,
 /*   390 */    17,   14,   11,   16,   17,   14,   11,   16,   17,   14,
 /*   400 */    72,   16,   17,   54,   54,   56,   56,   54,   11,   56,
 /*   410 */    72,   14,   72,   16,   17,   72,   72,   68,   68,   70,
 /*   420 */    70,   68,   54,   70,   56,   54,   11,   56,   54,   14,
 /*   430 */    56,   16,   17,   54,   54,   56,   56,   69,   70,   68,
 /*   440 */    66,   70,   72,   72,   70,   66,   72,   72,   68,   70,
 /*   450 */    70,   72,   54,   54,   56,   56,   54,   72,   56,   72,
 /*   460 */    72,   72,   72,   72,   72,   72,   72,   72,   70,   70,
 /*   470 */    72,   72,   70,
);
    const YY_SHIFT_USE_DFLT = -36;
    const YY_SHIFT_MAX = 117;
    static public $yy_shift_ofst = array(
 /*     0 */   301,  216,  377,  369,  397,   65,  385,  362,  373,  346,
 /*    10 */   346,   24,  228,  381,  346,  415,  101,  169,  169,  169,
 /*    20 */   169,  169,  169,  169,    9,  -21,  -21,   37,   58,   -4,
 /*    30 */    17,  138,  118,  201,   78,   98,  180,  261,  241,  221,
 /*    40 */   289,  328,  332,  312,  -21,  -21,  -21,  -21,  103,  177,
 /*    50 */   177,  223,  223,  177,  177,  257,  177,  177,  177,  177,
 /*    60 */   177,  177,  177,  -36,  -36,  -36,  -36,  -36,  -36,  -36,
 /*    70 */   -36,  -36,  -36,  -36,  -36,  -36,  188,  176,  325,  339,
 /*    80 */   339,   94,   71,   82,    4,  150,  156,   27,  181,   91,
 /*    90 */    48,  -18,   86,   96,   12,  224,  -35,  141,  153,  193,
 /*   100 */   144,  161,   60,   21,    7,   -8,   30,  266,  -35,   19,
 /*   110 */   129,  163,  143,  146,  195,   34,  151,  175,
);
    const YY_REDUCE_USE_DFLT = -52;
    const YY_REDUCE_MAX = 75;
    static public $yy_reduce_ofst = array(
 /*     0 */   -51,  242,  242,  242,  242,  242,  242,  242,  242,  242,
 /*    10 */   242,  242,  242,  242,  242,  242,  374,  371,  380,  349,
 /*    20 */   219,  350,  353,   56,   -1,  368,  379,  302,  302,  302,
 /*    30 */   302,  302,  302,  302,  302,  302,  302,  302,  302,  302,
 /*    40 */   302,  149,  149,  149,  116,  402,  399,  398,  210,  209,
 /*    50 */   208,  198,  213,  226,  206,  196,  191,  190,  197,  203,
 /*    60 */   199,  236,  229,  282,  268,  270,  253,  267,  260,  240,
 /*    70 */   283,   79,   83,   22,   41,   70,
);
    static public $yyExpectedTokens = array(
        /* 0 */ array(11, 14, 16, 17, ),
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
        /* 15 */ array(11, 14, 16, 17, ),
        /* 16 */ array(13, 20, 21, 40, 42, 48, 49, ),
        /* 17 */ array(40, 42, 45, 47, 49, ),
        /* 18 */ array(40, 42, 45, 47, 49, ),
        /* 19 */ array(40, 42, 45, 47, 49, ),
        /* 20 */ array(40, 42, 45, 47, 49, ),
        /* 21 */ array(40, 42, 45, 47, 49, ),
        /* 22 */ array(40, 42, 45, 47, 49, ),
        /* 23 */ array(40, 42, 45, 47, 49, ),
        /* 24 */ array(13, 40, 42, 49, ),
        /* 25 */ array(40, 42, 49, ),
        /* 26 */ array(40, 42, 49, ),
        /* 27 */ array(19, 20, 22, 25, 26, 27, 30, 33, 35, 37, 49, ),
        /* 28 */ array(19, 20, 22, 27, 29, 30, 31, 33, 35, 37, 49, ),
        /* 29 */ array(19, 20, 22, 27, 28, 29, 30, 33, 35, 37, 49, ),
        /* 30 */ array(19, 20, 22, 27, 29, 30, 31, 33, 35, 37, 49, ),
        /* 31 */ array(19, 20, 22, 23, 27, 30, 33, 35, 37, 49, ),
        /* 32 */ array(19, 20, 22, 27, 28, 30, 33, 35, 37, 49, ),
        /* 33 */ array(19, 20, 22, 27, 30, 33, 34, 35, 37, 49, ),
        /* 34 */ array(12, 19, 20, 22, 27, 30, 33, 35, 37, 49, ),
        /* 35 */ array(19, 20, 22, 27, 30, 31, 33, 35, 37, 49, ),
        /* 36 */ array(19, 20, 22, 27, 30, 32, 33, 35, 37, 49, ),
        /* 37 */ array(19, 20, 22, 25, 27, 30, 33, 35, 37, 49, ),
        /* 38 */ array(19, 20, 22, 27, 30, 33, 35, 36, 37, 49, ),
        /* 39 */ array(19, 20, 22, 27, 30, 31, 33, 35, 37, 49, ),
        /* 40 */ array(19, 20, 22, 27, 30, 33, 35, 37, 49, ),
        /* 41 */ array(13, 21, 39, 40, 42, 49, ),
        /* 42 */ array(21, 39, 40, 42, 49, ),
        /* 43 */ array(13, 39, 40, 42, 49, ),
        /* 44 */ array(40, 42, 49, ),
        /* 45 */ array(40, 42, 49, ),
        /* 46 */ array(40, 42, 49, ),
        /* 47 */ array(40, 42, 49, ),
        /* 48 */ array(13, 49, ),
        /* 49 */ array(49, ),
        /* 50 */ array(49, ),
        /* 51 */ array(44, ),
        /* 52 */ array(44, ),
        /* 53 */ array(49, ),
        /* 54 */ array(49, ),
        /* 55 */ array(0, ),
        /* 56 */ array(49, ),
        /* 57 */ array(49, ),
        /* 58 */ array(49, ),
        /* 59 */ array(49, ),
        /* 60 */ array(49, ),
        /* 61 */ array(49, ),
        /* 62 */ array(49, ),
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
        /* 73 */ array(),
        /* 74 */ array(),
        /* 75 */ array(),
        /* 76 */ array(1, 2, 3, 4, 5, 6, 7, 8, 9, 13, ),
        /* 77 */ array(1, 2, 3, 4, 5, 6, 7, 8, 9, 46, ),
        /* 78 */ array(2, 3, 4, 5, 6, 7, 8, 9, ),
        /* 79 */ array(3, 4, 5, 6, 7, 8, 9, ),
        /* 80 */ array(3, 4, 5, 6, 7, 8, 9, ),
        /* 81 */ array(7, 8, 9, ),
        /* 82 */ array(13, 21, 48, ),
        /* 83 */ array(24, 48, ),
        /* 84 */ array(13, 38, ),
        /* 85 */ array(13, 48, ),
        /* 86 */ array(13, 48, ),
        /* 87 */ array(41, 44, ),
        /* 88 */ array(43, 44, ),
        /* 89 */ array(13, 48, ),
        /* 90 */ array(13, 48, ),
        /* 91 */ array(21, 48, ),
        /* 92 */ array(13, 48, ),
        /* 93 */ array(13, 48, ),
        /* 94 */ array(15, 48, ),
        /* 95 */ array(13, 48, ),
        /* 96 */ array(48, ),
        /* 97 */ array(13, ),
        /* 98 */ array(13, ),
        /* 99 */ array(13, ),
        /* 100 */ array(18, ),
        /* 101 */ array(13, ),
        /* 102 */ array(13, ),
        /* 103 */ array(13, ),
        /* 104 */ array(13, ),
        /* 105 */ array(13, ),
        /* 106 */ array(13, ),
        /* 107 */ array(13, ),
        /* 108 */ array(48, ),
        /* 109 */ array(13, ),
        /* 110 */ array(13, ),
        /* 111 */ array(13, ),
        /* 112 */ array(13, ),
        /* 113 */ array(13, ),
        /* 114 */ array(13, ),
        /* 115 */ array(49, ),
        /* 116 */ array(13, ),
        /* 117 */ array(13, ),
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
        /* 165 */ array(),
        /* 166 */ array(),
        /* 167 */ array(),
);
    static public $yy_default = array(
 /*     0 */   173,  230,  230,  230,  230,  230,  230,  230,  230,  171,
 /*    10 */   169,  230,  230,  230,  170,  230,  230,  230,  230,  230,
 /*    20 */   230,  230,  230,  230,  230,  230,  230,  230,  230,  230,
 /*    30 */   230,  230,  230,  230,  230,  230,  230,  230,  230,  230,
 /*    40 */   230,  230,  207,  230,  230,  230,  230,  230,  230,  230,
 /*    50 */   230,  230,  230,  230,  230,  173,  230,  230,  230,  230,
 /*    60 */   230,  230,  230,  173,  173,  173,  173,  173,  173,  173,
 /*    70 */   173,  173,  173,  173,  173,  173,  230,  230,  221,  223,
 /*    80 */   222,  225,  230,  230,  230,  230,  230,  230,  230,  230,
 /*    90 */   230,  230,  230,  230,  230,  230,  214,  230,  230,  230,
 /*   100 */   230,  230,  230,  230,  230,  230,  230,  230,  208,  230,
 /*   110 */   230,  230,  230,  230,  230,  230,  230,  230,  179,  224,
 /*   120 */   227,  226,  180,  176,  229,  192,  228,  174,  172,  175,
 /*   130 */   191,  188,  178,  189,  177,  190,  203,  219,  194,  205,
 /*   140 */   193,  206,  211,  185,  204,  195,  198,  197,  196,  199,
 /*   150 */   201,  168,  212,  213,  215,  200,  202,  183,  182,  220,
 /*   160 */   216,  218,  186,  184,  217,  209,  210,  181,
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
    const YYNSTATE = 168;
    const YYNRULE = 62;
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
  'extend',        'body',          'var_or_string',  'stmts',       
  'varname',       'for_stmt',      'ifchanged_stmt',  'block_stmt',  
  'filter_stmt',   'custom_stmt',   'if_stmt',       'fnc_call_stmt',
  'stmt',          'alias',         'list',          'cycle',       
  'expr',          'piped_list',    'string',        's_content',   
    );

    /**
     * For tracing reduce actions, the names of all rules are required.
     * @var array
     */
    static public $yyRuleName = array(
 /*   0 */ "start ::= extend",
 /*   1 */ "start ::= body",
 /*   2 */ "extend ::= T_OPEN_TAG T_EXTENDS var_or_string T_CLOSE_TAG body",
 /*   3 */ "extend ::= stmts body",
 /*   4 */ "body ::= body stmts",
 /*   5 */ "body ::=",
 /*   6 */ "stmts ::= T_PRINT_OPEN varname T_PRINT_CLOSE",
 /*   7 */ "stmts ::= T_HTML",
 /*   8 */ "stmts ::= for_stmt",
 /*   9 */ "stmts ::= ifchanged_stmt",
 /*  10 */ "stmts ::= T_COMMENT_OPEN T_COMMENT",
 /*  11 */ "stmts ::= block_stmt",
 /*  12 */ "stmts ::= filter_stmt",
 /*  13 */ "stmts ::= custom_stmt",
 /*  14 */ "stmts ::= if_stmt",
 /*  15 */ "stmts ::= T_OPEN_TAG T_INCLUDE var_or_string T_CLOSE_TAG",
 /*  16 */ "stmts ::= fnc_call_stmt",
 /*  17 */ "stmts ::= T_OPEN_TAG stmt T_CLOSE_TAG",
 /*  18 */ "stmts ::= alias",
 /*  19 */ "fnc_call_stmt ::= T_OPEN_TAG varname T_CLOSE_TAG",
 /*  20 */ "fnc_call_stmt ::= T_OPEN_TAG varname T_FOR varname T_CLOSE_TAG",
 /*  21 */ "fnc_call_stmt ::= T_OPEN_TAG varname T_FOR varname T_AS varname T_CLOSE_TAG",
 /*  22 */ "fnc_call_stmt ::= T_OPEN_TAG varname T_AS varname T_CLOSE_TAG",
 /*  23 */ "fnc_call_stmt ::= T_OPEN_TAG varname list T_CLOSE_TAG",
 /*  24 */ "fnc_call_stmt ::= T_OPEN_TAG varname list T_AS varname T_CLOSE_TAG",
 /*  25 */ "alias ::= T_OPEN_TAG T_WITH varname T_AS varname T_CLOSE_TAG body T_OPEN_TAG T_ENDWITH T_CLOSE_TAG",
 /*  26 */ "stmt ::= cycle",
 /*  27 */ "for_stmt ::= T_OPEN_TAG T_FOR varname T_IN varname T_CLOSE_TAG body T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG",
 /*  28 */ "for_stmt ::= T_OPEN_TAG T_FOR varname T_IN varname T_CLOSE_TAG body T_OPEN_TAG T_EMPTY T_CLOSE_TAG body T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG",
 /*  29 */ "if_stmt ::= T_OPEN_TAG T_IF expr T_CLOSE_TAG body T_OPEN_TAG T_ENDIF T_CLOSE_TAG",
 /*  30 */ "if_stmt ::= T_OPEN_TAG T_IF expr T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIF T_CLOSE_TAG",
 /*  31 */ "ifchanged_stmt ::= T_OPEN_TAG T_IFCHANGED T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  32 */ "ifchanged_stmt ::= T_OPEN_TAG T_IFCHANGED list T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  33 */ "ifchanged_stmt ::= T_OPEN_TAG T_IFCHANGED T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  34 */ "ifchanged_stmt ::= T_OPEN_TAG T_IFCHANGED list T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  35 */ "custom_stmt ::= T_OPEN_TAG varname T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  36 */ "block_stmt ::= T_OPEN_TAG T_BLOCK varname T_CLOSE_TAG body T_OPEN_TAG T_END_BLOCK T_CLOSE_TAG",
 /*  37 */ "block_stmt ::= T_OPEN_TAG T_BLOCK varname T_CLOSE_TAG body T_OPEN_TAG T_END_BLOCK varname T_CLOSE_TAG",
 /*  38 */ "filter_stmt ::= T_OPEN_TAG T_FILTER piped_list T_CLOSE_TAG body T_OPEN_TAG T_END_FILTER T_CLOSE_TAG",
 /*  39 */ "cycle ::= T_CYCLE list",
 /*  40 */ "cycle ::= T_CYCLE list T_AS varname",
 /*  41 */ "piped_list ::= piped_list T_PIPE var_or_string",
 /*  42 */ "piped_list ::= var_or_string",
 /*  43 */ "list ::= list var_or_string",
 /*  44 */ "list ::= list T_COMMA var_or_string",
 /*  45 */ "list ::= var_or_string",
 /*  46 */ "var_or_string ::= varname",
 /*  47 */ "var_or_string ::= string",
 /*  48 */ "string ::= T_STRING_SINGLE_INIT s_content T_STRING_SINGLE_END",
 /*  49 */ "string ::= T_STRING_DOUBLE_INIT s_content T_STRING_DOUBLE_END",
 /*  50 */ "s_content ::= s_content T_STRING_CONTENT",
 /*  51 */ "s_content ::= T_STRING_CONTENT",
 /*  52 */ "expr ::= T_LPARENT expr T_RPARENT",
 /*  53 */ "expr ::= expr T_AND expr",
 /*  54 */ "expr ::= expr T_OR expr",
 /*  55 */ "expr ::= expr T_EQ|T_NE expr",
 /*  56 */ "expr ::= expr T_TIMES|T_DIV|T_MOD expr",
 /*  57 */ "expr ::= expr T_PLUS|T_MINUS expr",
 /*  58 */ "expr ::= var_or_string",
 /*  59 */ "expr ::= T_NUMERIC",
 /*  60 */ "varname ::= varname T_DOT T_ALPHA",
 /*  61 */ "varname ::= T_ALPHA",
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
  array( 'lhs' => 51, 'rhs' => 1 ),
  array( 'lhs' => 52, 'rhs' => 5 ),
  array( 'lhs' => 52, 'rhs' => 2 ),
  array( 'lhs' => 53, 'rhs' => 2 ),
  array( 'lhs' => 53, 'rhs' => 0 ),
  array( 'lhs' => 55, 'rhs' => 3 ),
  array( 'lhs' => 55, 'rhs' => 1 ),
  array( 'lhs' => 55, 'rhs' => 1 ),
  array( 'lhs' => 55, 'rhs' => 1 ),
  array( 'lhs' => 55, 'rhs' => 2 ),
  array( 'lhs' => 55, 'rhs' => 1 ),
  array( 'lhs' => 55, 'rhs' => 1 ),
  array( 'lhs' => 55, 'rhs' => 1 ),
  array( 'lhs' => 55, 'rhs' => 1 ),
  array( 'lhs' => 55, 'rhs' => 4 ),
  array( 'lhs' => 55, 'rhs' => 1 ),
  array( 'lhs' => 55, 'rhs' => 3 ),
  array( 'lhs' => 55, 'rhs' => 1 ),
  array( 'lhs' => 63, 'rhs' => 3 ),
  array( 'lhs' => 63, 'rhs' => 5 ),
  array( 'lhs' => 63, 'rhs' => 7 ),
  array( 'lhs' => 63, 'rhs' => 5 ),
  array( 'lhs' => 63, 'rhs' => 4 ),
  array( 'lhs' => 63, 'rhs' => 6 ),
  array( 'lhs' => 65, 'rhs' => 10 ),
  array( 'lhs' => 64, 'rhs' => 1 ),
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
  array( 'lhs' => 67, 'rhs' => 2 ),
  array( 'lhs' => 67, 'rhs' => 4 ),
  array( 'lhs' => 69, 'rhs' => 3 ),
  array( 'lhs' => 69, 'rhs' => 1 ),
  array( 'lhs' => 66, 'rhs' => 2 ),
  array( 'lhs' => 66, 'rhs' => 3 ),
  array( 'lhs' => 66, 'rhs' => 1 ),
  array( 'lhs' => 54, 'rhs' => 1 ),
  array( 'lhs' => 54, 'rhs' => 1 ),
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
        5 => 5,
        6 => 6,
        7 => 7,
        8 => 8,
        9 => 8,
        11 => 8,
        12 => 8,
        13 => 8,
        14 => 8,
        16 => 8,
        18 => 8,
        26 => 8,
        51 => 8,
        58 => 8,
        59 => 8,
        61 => 8,
        10 => 10,
        15 => 15,
        17 => 17,
        19 => 19,
        20 => 20,
        21 => 21,
        22 => 22,
        23 => 23,
        24 => 24,
        25 => 25,
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
        41 => 41,
        44 => 41,
        42 => 42,
        45 => 42,
        43 => 43,
        46 => 46,
        47 => 47,
        48 => 48,
        49 => 48,
        50 => 50,
        52 => 52,
        53 => 53,
        54 => 53,
        55 => 53,
        56 => 53,
        57 => 53,
        60 => 60,
    );
    /* Beginning here are the reduction cases.  A typical example
    ** follows:
    **  #line <lineno> <grammarfile>
    **   function yy_r0($yymsp){ ... }           // User supplied code
    **  #line <lineno> <thisfile>
    */
#line 30 "parser.y"
    function yy_r0(){ $this->body = $this->yystack[$this->yyidx + 0]->minor;    }
#line 1243 "parser.php"
#line 31 "parser.y"
    function yy_r1(){ $this->body = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1246 "parser.php"
#line 33 "parser.y"
    function yy_r2(){ $this->yystack[$this->yyidx + 0]->minor['base'] = $this->yystack[$this->yyidx + -2]->minor; $this->_retvalue = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1249 "parser.php"
#line 34 "parser.y"
    function yy_r3(){ $this->_retvalue=array_merge(array($this->yystack[$this->yyidx + -1]->minor),$this->yystack[$this->yyidx + 0]->minor);     }
#line 1252 "parser.php"
#line 36 "parser.y"
    function yy_r4(){ $this->_retvalue=$this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1255 "parser.php"
#line 37 "parser.y"
    function yy_r5(){ $this->_retvalue = array();     }
#line 1258 "parser.php"
#line 40 "parser.y"
    function yy_r6(){ $this->_retvalue = array('operation' => 'print', 'variable' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1261 "parser.php"
#line 41 "parser.y"
    function yy_r7(){$this->_retvalue = array('operation' => 'html', 'html' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1264 "parser.php"
#line 42 "parser.y"
    function yy_r8(){ $this->_retvalue = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1267 "parser.php"
#line 44 "parser.y"
    function yy_r10(){ $this->yystack[$this->yyidx + 0]->minor=rtrim($this->yystack[$this->yyidx + 0]->minor); $this->_retvalue = array('operation' => 'comment', 'comment' => substr($this->yystack[$this->yyidx + 0]->minor, 0, strlen($this->yystack[$this->yyidx + 0]->minor)-2));     }
#line 1270 "parser.php"
#line 49 "parser.y"
    function yy_r15(){ $this->_retvalue = array('operation' => 'include', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1273 "parser.php"
#line 51 "parser.y"
    function yy_r17(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1276 "parser.php"
#line 57 "parser.y"
    function yy_r19(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -1]->minor, 'list'=>array());     }
#line 1279 "parser.php"
#line 58 "parser.y"
    function yy_r20(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -3]->minor, 'for' => $this->yystack[$this->yyidx + -1]->minor, 'list' => array());     }
#line 1282 "parser.php"
#line 59 "parser.y"
    function yy_r21(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'for' => $this->yystack[$this->yyidx + -3]->minor, 'list' => array(),'as' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1285 "parser.php"
#line 60 "parser.y"
    function yy_r22(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -3]->minor, 'as' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1288 "parser.php"
#line 61 "parser.y"
    function yy_r23(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -2]->minor, 'list' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1291 "parser.php"
#line 62 "parser.y"
    function yy_r24(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -4]->minor, 'as' => $this->yystack[$this->yyidx + -1]->minor, 'list' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1294 "parser.php"
#line 65 "parser.y"
    function yy_r25(){ $this->_retvalue = array('operation' => 'alias', 'var' => $this->yystack[$this->yyidx + -7]->minor, 'as' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1297 "parser.php"
#line 71 "parser.y"
    function yy_r27(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -7]->minor, 'array' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1302 "parser.php"
#line 74 "parser.y"
    function yy_r28(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -11]->minor, 'array' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'empty' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1307 "parser.php"
#line 78 "parser.y"
    function yy_r29(){ $this->_retvalue = array('operation' => 'if', 'expr' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1310 "parser.php"
#line 79 "parser.y"
    function yy_r30(){ $this->_retvalue = array('operation' => 'if', 'expr' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1313 "parser.php"
#line 82 "parser.y"
    function yy_r31(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1318 "parser.php"
#line 86 "parser.y"
    function yy_r32(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -3]->minor, 'check' => $this->yystack[$this->yyidx + -5]->minor);
    }
#line 1323 "parser.php"
#line 89 "parser.y"
    function yy_r33(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1328 "parser.php"
#line 93 "parser.y"
    function yy_r34(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -7]->minor, 'check' => $this->yystack[$this->yyidx + -9]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);
    }
#line 1333 "parser.php"
#line 98 "parser.y"
    function yy_r35(){ if ('end'.$this->yystack[$this->yyidx + -5]->minor != $this->yystack[$this->yyidx + -1]->minor) { throw new Exception("Unexpected ".$this->yystack[$this->yyidx + -1]->minor); } $this->_retvalue = array('operation' => 'filter', 'functions' => array(array('var'=>$this->yystack[$this->yyidx + -5]->minor)), 'body' => $this->yystack[$this->yyidx + -3]->minor);    }
#line 1336 "parser.php"
#line 101 "parser.y"
    function yy_r36(){ $this->_retvalue = array('operation' => 'block', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1339 "parser.php"
#line 103 "parser.y"
    function yy_r37(){ $this->_retvalue = array('operation' => 'block', 'name' => $this->yystack[$this->yyidx + -6]->minor, 'body' => $this->yystack[$this->yyidx + -4]->minor);     }
#line 1342 "parser.php"
#line 106 "parser.y"
    function yy_r38(){ $this->_retvalue = array('operation' => 'filter', 'functions' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1345 "parser.php"
#line 110 "parser.y"
    function yy_r39(){ $this->_retvalue = array('operation' => 'cycle', 'vars' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1348 "parser.php"
#line 111 "parser.y"
    function yy_r40(){ $this->_retvalue = array('operation' => 'cycle', 'vars' => $this->yystack[$this->yyidx + -2]->minor, 'as' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1351 "parser.php"
#line 114 "parser.y"
    function yy_r41(){ $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1354 "parser.php"
#line 115 "parser.y"
    function yy_r42(){ $this->_retvalue = array($this->yystack[$this->yyidx + 0]->minor);     }
#line 1357 "parser.php"
#line 118 "parser.y"
    function yy_r43(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1360 "parser.php"
#line 122 "parser.y"
    function yy_r46(){ $this->_retvalue = array('var' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1363 "parser.php"
#line 123 "parser.y"
    function yy_r47(){ $this->_retvalue = array('string' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1366 "parser.php"
#line 125 "parser.y"
    function yy_r48(){  $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1369 "parser.php"
#line 127 "parser.y"
    function yy_r50(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor.$this->yystack[$this->yyidx + 0]->minor;     }
#line 1372 "parser.php"
#line 131 "parser.y"
    function yy_r52(){ $this->_retvalue = array('op' => 'expr', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1375 "parser.php"
#line 132 "parser.y"
    function yy_r53(){ $this->_retvalue = array('op' => @$this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1378 "parser.php"
#line 142 "parser.y"
    function yy_r60(){ if (!is_array($this->yystack[$this->yyidx + -2]->minor)) { $this->_retvalue = array($this->yystack[$this->yyidx + -2]->minor); } else { $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; }  $this->_retvalue[]=$this->yystack[$this->yyidx + 0]->minor;    }
#line 1381 "parser.php"

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
#line 1501 "parser.php"
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

#line 1522 "parser.php"
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