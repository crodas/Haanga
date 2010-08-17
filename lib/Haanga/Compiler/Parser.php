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
#line 2 "lib/Haanga/Compiler/Parser.y"

/*
  +---------------------------------------------------------------------------------+
  | Copyright (c) 2010 César Rodas and Menéame Comunicacions S.L.                   |
  +---------------------------------------------------------------------------------+
  | Redistribution and use in source and binary forms, with or without              |
  | modification, are permitted provided that the following conditions are met:     |
  | 1. Redistributions of source code must retain the above copyright               |
  |    notice, this list of conditions and the following disclaimer.                |
  |                                                                                 |
  | 2. Redistributions in binary form must reproduce the above copyright            |
  |    notice, this list of conditions and the following disclaimer in the          |
  |    documentation and/or other materials provided with the distribution.         |
  |                                                                                 |
  | 3. All advertising materials mentioning features or use of this software        |
  |    must display the following acknowledgement:                                  |
  |    This product includes software developed by César D. Rodas.                  |
  |                                                                                 |
  | 4. Neither the name of the César D. Rodas nor the                               |
  |    names of its contributors may be used to endorse or promote products         |
  |    derived from this software without specific prior written permission.        |
  |                                                                                 |
  | THIS SOFTWARE IS PROVIDED BY CÉSAR D. RODAS ''AS IS'' AND ANY                   |
  | EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED       |
  | WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE          |
  | DISCLAIMED. IN NO EVENT SHALL CÉSAR D. RODAS BE LIABLE FOR ANY                  |
  | DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES      |
  | (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;    |
  | LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND     |
  | ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT      |
  | (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS   |
  | SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE                     |
  +---------------------------------------------------------------------------------+
  | Authors: César Rodas <crodas@php.net>                                           |
  +---------------------------------------------------------------------------------+
*/
#line 136 "lib/Haanga/Compiler/Parser.php"

// declare_class is output here
#line 39 "lib/Haanga/Compiler/Parser.y"
 class Haanga_Compiler_Parser #line 141 "lib/Haanga/Compiler/Parser.php"
{
/* First off, code is included which follows the "include_class" declaration
** in the input file. */
#line 40 "lib/Haanga/Compiler/Parser.y"

    protected $lex;
    protected $file;

    function __construct($lex, $file='')
    {
        $this->lex  = $lex;
        $this->file = $file;
    }

    function Error($text)
    {
        throw new Haanga_Compiler_Exception($text.' in '.$this->file.':'.$this->lex->getLine());
    }

#line 162 "lib/Haanga/Compiler/Parser.php"

/* Next is all token values, as class constants
*/
/* 
** These constants (all generated automatically by the parser generator)
** specify the various kinds of tokens (terminals) that the parser
** understands. 
**
** Each symbol here is a terminal symbol in the grammar.
*/
    const T_OPEN_TAG                     =  1;
    const T_NOT                          =  2;
    const T_AND                          =  3;
    const T_OR                           =  4;
    const T_EQ                           =  5;
    const T_NE                           =  6;
    const T_GT                           =  7;
    const T_GE                           =  8;
    const T_LT                           =  9;
    const T_LE                           = 10;
    const T_IN                           = 11;
    const T_PLUS                         = 12;
    const T_MINUS                        = 13;
    const T_TIMES                        = 14;
    const T_DIV                          = 15;
    const T_MOD                          = 16;
    const T_HTML                         = 17;
    const T_COMMENT_OPEN                 = 18;
    const T_COMMENT                      = 19;
    const T_PRINT_OPEN                   = 20;
    const T_PRINT_CLOSE                  = 21;
    const T_EXTENDS                      = 22;
    const T_CLOSE_TAG                    = 23;
    const T_INCLUDE                      = 24;
    const T_AUTOESCAPE                   = 25;
    const T_CUSTOM_END                   = 26;
    const T_CUSTOM_TAG                   = 27;
    const T_AS                           = 28;
    const T_CUSTOM_BLOCK                 = 29;
    const T_SPACEFULL                    = 30;
    const T_WITH                         = 31;
    const T_LOAD                         = 32;
    const T_FOR                          = 33;
    const T_COMMA                        = 34;
    const T_EMPTY                        = 35;
    const T_IF                           = 36;
    const T_ELSE                         = 37;
    const T_IFCHANGED                    = 38;
    const T_IFEQUAL                      = 39;
    const T_IFNOTEQUAL                   = 40;
    const T_BLOCK                        = 41;
    const T_NUMERIC                      = 42;
    const T_FILTER                       = 43;
    const T_REGROUP                      = 44;
    const T_BY                           = 45;
    const T_PIPE                         = 46;
    const T_COLON                        = 47;
    const T_TRUE                         = 48;
    const T_FALSE                        = 49;
    const T_STRING                       = 50;
    const T_INTL                         = 51;
    const T_RPARENT                      = 52;
    const T_STRING_SINGLE_INIT           = 53;
    const T_STRING_SINGLE_END            = 54;
    const T_STRING_DOUBLE_INIT           = 55;
    const T_STRING_DOUBLE_END            = 56;
    const T_STRING_CONTENT               = 57;
    const T_LPARENT                      = 58;
    const T_OBJ                          = 59;
    const T_ALPHA                        = 60;
    const T_DOT                          = 61;
    const T_BRACKETS_OPEN                = 62;
    const T_BRACKETS_CLOSE               = 63;
    const YY_NO_ACTION = 334;
    const YY_ACCEPT_ACTION = 333;
    const YY_ERROR_ACTION = 332;

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
    const YY_SZ_ACTTAB = 1030;
static public $yy_action = array(
 /*     0 */    40,  113,   44,   83,  150,   34,  198,   36,  151,   58,
 /*    10 */    59,   57,   63,   50,   22,  149,   35,   30,   33,   51,
 /*    20 */    98,   49,   48,   40,  195,   44,   83,  161,   34,   50,
 /*    30 */    36,  151,   58,   59,   57,  228,  171,   22,  238,   35,
 /*    40 */    30,   33,   51,   50,   49,   48,   40,  199,   44,   83,
 /*    50 */   164,   34,  194,   36,  151,   58,   59,   57,  333,   70,
 /*    60 */    22,  158,   35,   30,   33,   51,  100,   49,   48,   40,
 /*    70 */   118,   44,   83,  165,   34,   50,   36,  151,   58,   59,
 /*    80 */    57,  203,   50,   22,  162,   35,   30,   33,   51,   87,
 /*    90 */    49,   48,   40,  122,   44,   83,  167,   34,  120,   36,
 /*   100 */   151,   58,   59,   57,  244,  186,   22,  160,   35,   30,
 /*   110 */    33,   51,  242,   49,   48,   40,  208,   44,   83,  136,
 /*   120 */    34,  180,   36,  151,   58,   59,   57,  221,  232,   22,
 /*   130 */   139,   35,   30,   33,   51,  121,   49,   48,   40,  125,
 /*   140 */    44,   83,  172,   34,   92,   36,  151,   58,   59,   57,
 /*   150 */   231,  201,   22,   50,   35,   30,   33,   51,  234,   49,
 /*   160 */    48,   40,  117,   44,   83,  157,   34,  218,   36,  151,
 /*   170 */    58,   59,   57,  243,  210,   22,  245,   35,   30,   33,
 /*   180 */    51,  224,   49,   48,   40,  123,   44,   83,  130,   34,
 /*   190 */   173,   36,  151,   58,   59,   57,   90,  102,   22,  209,
 /*   200 */    35,   30,   33,   51,  235,   49,   48,   40,  213,   44,
 /*   210 */    83,  166,   34,  119,   36,  151,   58,   59,   57,  177,
 /*   220 */   239,   22,  233,   35,   30,   33,   51,   84,   49,   48,
 /*   230 */    40,   69,   44,   83,  140,   34,   97,   36,  151,   58,
 /*   240 */    59,   57,  104,   77,   22,   73,   35,   30,   33,   51,
 /*   250 */    78,   49,   48,   40,   72,   44,   83,  148,   34,  185,
 /*   260 */    36,  151,   58,   59,   57,   65,   74,   22,  103,   35,
 /*   270 */    30,   33,   51,  115,   49,   48,   40,  155,   44,   83,
 /*   280 */   168,   34,  114,   36,  151,   58,   59,   57,   76,  131,
 /*   290 */    22,  116,   35,   30,   33,   51,   71,   49,   48,   40,
 /*   300 */   132,   44,   83,  147,   34,  229,   36,  151,   58,   59,
 /*   310 */    57,  193,   79,   22,   61,   35,   30,   33,   51,  202,
 /*   320 */    49,   48,   40,   67,   44,   83,   52,   34,   93,   36,
 /*   330 */   151,   58,   59,   57,   62,  196,   22,   66,   35,   30,
 /*   340 */    33,   51,   53,   49,   48,   40,   54,   44,   83,  135,
 /*   350 */    34,  206,   36,  151,   58,   59,   57,   56,   95,   22,
 /*   360 */    75,   35,   30,   33,   51,  176,   49,   48,   40,   64,
 /*   370 */    44,   83,  163,   34,  240,   36,  151,   58,   59,   57,
 /*   380 */   176,  176,   22,  176,   35,   30,   33,   51,  176,   49,
 /*   390 */    48,   40,  176,   44,   83,  169,   34,  176,   36,  151,
 /*   400 */    58,   59,   57,  176,  176,   22,  176,   35,   30,   33,
 /*   410 */    51,  176,   49,   48,   40,  176,   44,   83,  137,   34,
 /*   420 */   176,   36,  151,   58,   59,   57,  176,  176,   22,  176,
 /*   430 */    35,   30,   33,   51,  176,   49,   48,   40,  176,   44,
 /*   440 */    83,  144,   34,  176,   36,  151,   58,   59,   57,  176,
 /*   450 */   176,   22,  176,   35,   30,   33,   51,  176,   49,   48,
 /*   460 */    40,  176,   44,   83,  176,   34,  105,   36,  151,   58,
 /*   470 */    59,   57,  176,  176,   22,  176,   35,   30,   33,   51,
 /*   480 */   176,   49,   48,   28,   27,   23,   23,   23,   23,   23,
 /*   490 */    23,   23,   26,   26,   24,   24,   24,  176,   24,   24,
 /*   500 */    24,  176,  145,   89,  143,   43,   91,   28,   27,   23,
 /*   510 */    23,   23,   23,   23,   23,   23,   26,   26,   24,   24,
 /*   520 */    24,   28,   27,   23,   23,   23,   23,   23,   23,   23,
 /*   530 */    26,   26,   24,   24,   24,  188,  217,  134,  217,  217,
 /*   540 */    82,  217,  145,   29,  143,   43,   41,   60,  120,  211,
 /*   550 */   217,  152,  246,  217,  200,  191,  190,  176,   11,  176,
 /*   560 */   174,  174,  183,   81,  176,   86,  187,   85,  217,  216,
 /*   570 */   217,  142,  216,  176,  230,  156,  126,   47,  145,  175,
 /*   580 */   143,   43,  217,  179,  176,  145,  154,  143,   43,  178,
 /*   590 */   178,  183,   81,  217,   86,  217,   85,  120,  207,   25,
 /*   600 */   181,  216,  109,  189,  191,  154,   96,  217,  126,   39,
 /*   610 */   217,  175,  217,  176,  176,  176,  120,   41,  176,  181,
 /*   620 */   176,  108,  189,  191,  217,  200,  216,  215,  245,  182,
 /*   630 */   176,  174,  174,  183,   81,  176,   86,  154,   85,  126,
 /*   640 */   214,   94,  175,  216,  217,  217,  217,  217,  120,  227,
 /*   650 */   238,  181,   41,  124,  189,  191,  176,  184,  217,  217,
 /*   660 */   200,  217,   80,  217,  176,  176,  174,  174,  183,   81,
 /*   670 */   128,   86,  176,   85,  176,  217,  200,  216,  216,    3,
 /*   680 */   207,  120,  174,  174,  183,   81,  176,   86,  191,   85,
 /*   690 */   126,   38,  176,  175,  216,  230,  156,  176,   47,   27,
 /*   700 */    23,   23,   23,   23,   23,   23,   23,   26,   26,   24,
 /*   710 */    24,   24,   23,   23,   23,   23,   23,   23,   23,   26,
 /*   720 */    26,   24,   24,   24,  101,  176,  192,  176,  176,  141,
 /*   730 */   219,  220,  222,  225,  212,  241,  237,  236,  176,   88,
 /*   740 */   223,  176,   99,  217,  176,  217,  183,   81,  176,   86,
 /*   750 */   145,   85,  143,   43,  176,  106,  176,  217,  200,  217,
 /*   760 */   145,  217,  143,   43,  174,  174,  183,   81,  176,   86,
 /*   770 */   176,   85,   68,  217,  200,  176,  216,  176,  176,  154,
 /*   780 */   174,  174,  183,   81,  176,   86,  217,   85,  217,  176,
 /*   790 */   120,  176,  216,  181,  176,  197,  189,  191,  176,  176,
 /*   800 */   217,  179,  217,  145,  217,  143,   43,  178,  178,  183,
 /*   810 */    81,  176,   86,  176,   85,  176,  217,  200,  176,  216,
 /*   820 */   226,  146,  129,  174,  174,  183,   81,  154,   86,  176,
 /*   830 */    85,  126,    8,  120,  175,  216,  154,  176,  120,  176,
 /*   840 */   191,  181,  176,  112,  189,  191,  154,  120,  230,  156,
 /*   850 */   181,   47,  107,  189,  191,  154,  145,  120,  143,   43,
 /*   860 */   181,  176,  111,  189,  191,  154,  120,  154,  176,  181,
 /*   870 */   176,  110,  189,  191,   45,  133,  120,  154,  120,  181,
 /*   880 */   176,  181,  153,  191,   32,  191,  120,  154,  120,  176,
 /*   890 */     2,  181,  127,  191,  170,  191,   21,   55,  120,  176,
 /*   900 */    19,  181,  205,  120,   31,  191,  230,  156,   46,   47,
 /*   910 */   191,   12,  230,  156,  176,   47,  230,  156,   16,   47,
 /*   920 */   176,  176,  145,  176,  143,   43,    1,  230,  156,  176,
 /*   930 */    47,  176,   20,  176,  230,  156,   17,   47,  145,  176,
 /*   940 */   143,   43,  230,  156,    7,   47,  176,  176,  230,  156,
 /*   950 */     6,   47,  230,  156,   14,   47,  145,  176,  143,   43,
 /*   960 */   230,  156,   15,   47,  204,  176,  230,  156,   13,   47,
 /*   970 */   230,  156,   10,   47,  126,  176,  176,  175,  230,  156,
 /*   980 */    42,   47,    4,  176,  230,  156,   18,   47,  230,  156,
 /*   990 */     5,   47,  145,  176,  143,   43,    9,  176,  230,  156,
 /*  1000 */   176,   47,  230,  156,  176,   47,  230,  156,  207,   47,
 /*  1010 */   176,  176,  230,  156,  138,   47,  159,  176,  126,   37,
 /*  1020 */   176,  175,  176,  176,  126,  176,  126,  175,  176,  175,
    );
    static public $yy_lookahead = array(
 /*     0 */    22,   80,   24,   25,   26,   27,   23,   29,   30,   31,
 /*    10 */    32,   33,   45,   46,   36,   37,   38,   39,   40,   41,
 /*    20 */    23,   43,   44,   22,   67,   24,   25,   26,   27,   46,
 /*    30 */    29,   30,   31,   32,   33,   54,   35,   36,   57,   38,
 /*    40 */    39,   40,   41,   46,   43,   44,   22,   60,   24,   25,
 /*    50 */    26,   27,   23,   29,   30,   31,   32,   33,   65,   66,
 /*    60 */    36,   37,   38,   39,   40,   41,   23,   43,   44,   22,
 /*    70 */    80,   24,   25,   26,   27,   46,   29,   30,   31,   32,
 /*    80 */    33,   23,   46,   36,   37,   38,   39,   40,   41,   23,
 /*    90 */    43,   44,   22,   80,   24,   25,   26,   27,   80,   29,
 /*   100 */    30,   31,   32,   33,   23,   87,   36,   37,   38,   39,
 /*   110 */    40,   41,   23,   43,   44,   22,   63,   24,   25,   26,
 /*   120 */    27,   23,   29,   30,   31,   32,   33,   23,   21,   36,
 /*   130 */    37,   38,   39,   40,   41,   80,   43,   44,   22,   80,
 /*   140 */    24,   25,   26,   27,   23,   29,   30,   31,   32,   33,
 /*   150 */    23,   23,   36,   46,   38,   39,   40,   41,   23,   43,
 /*   160 */    44,   22,   80,   24,   25,   26,   27,   23,   29,   30,
 /*   170 */    31,   32,   33,   54,   23,   36,   57,   38,   39,   40,
 /*   180 */    41,   23,   43,   44,   22,   80,   24,   25,   26,   27,
 /*   190 */    23,   29,   30,   31,   32,   33,   23,   23,   36,   23,
 /*   200 */    38,   39,   40,   41,   23,   43,   44,   22,   83,   24,
 /*   210 */    25,   26,   27,   80,   29,   30,   31,   32,   33,   23,
 /*   220 */    23,   36,   52,   38,   39,   40,   41,   66,   43,   44,
 /*   230 */    22,   66,   24,   25,   26,   27,   23,   29,   30,   31,
 /*   240 */    32,   33,   23,   66,   36,   66,   38,   39,   40,   41,
 /*   250 */    66,   43,   44,   22,   66,   24,   25,   26,   27,   23,
 /*   260 */    29,   30,   31,   32,   33,   66,   66,   36,   23,   38,
 /*   270 */    39,   40,   41,   80,   43,   44,   22,   83,   24,   25,
 /*   280 */    26,   27,   80,   29,   30,   31,   32,   33,   66,   88,
 /*   290 */    36,   80,   38,   39,   40,   41,   66,   43,   44,   22,
 /*   300 */    88,   24,   25,   26,   27,   19,   29,   30,   31,   32,
 /*   310 */    33,   23,   66,   36,   66,   38,   39,   40,   41,   60,
 /*   320 */    43,   44,   22,   66,   24,   25,   26,   27,   23,   29,
 /*   330 */    30,   31,   32,   33,   66,   23,   36,   66,   38,   39,
 /*   340 */    40,   41,   66,   43,   44,   22,   66,   24,   25,   26,
 /*   350 */    27,   23,   29,   30,   31,   32,   33,   66,   23,   36,
 /*   360 */    66,   38,   39,   40,   41,   23,   43,   44,   22,   66,
 /*   370 */    24,   25,   26,   27,   23,   29,   30,   31,   32,   33,
 /*   380 */    89,   89,   36,   89,   38,   39,   40,   41,   89,   43,
 /*   390 */    44,   22,   89,   24,   25,   26,   27,   89,   29,   30,
 /*   400 */    31,   32,   33,   89,   89,   36,   89,   38,   39,   40,
 /*   410 */    41,   89,   43,   44,   22,   89,   24,   25,   26,   27,
 /*   420 */    89,   29,   30,   31,   32,   33,   89,   89,   36,   89,
 /*   430 */    38,   39,   40,   41,   89,   43,   44,   22,   89,   24,
 /*   440 */    25,   26,   27,   89,   29,   30,   31,   32,   33,   89,
 /*   450 */    89,   36,   89,   38,   39,   40,   41,   89,   43,   44,
 /*   460 */    22,   89,   24,   25,   89,   27,   23,   29,   30,   31,
 /*   470 */    32,   33,   89,   89,   36,   89,   38,   39,   40,   41,
 /*   480 */    89,   43,   44,    3,    4,    5,    6,    7,    8,    9,
 /*   490 */    10,   11,   12,   13,   14,   15,   16,   89,   14,   15,
 /*   500 */    16,   89,   59,   23,   61,   62,   23,    3,    4,    5,
 /*   510 */     6,    7,    8,    9,   10,   11,   12,   13,   14,   15,
 /*   520 */    16,    3,    4,    5,    6,    7,    8,    9,   10,   11,
 /*   530 */    12,   13,   14,   15,   16,   23,   27,   69,   29,   27,
 /*   540 */    28,   29,   59,    2,   61,   62,   34,   28,   80,   23,
 /*   550 */    41,   42,   23,   41,   42,   87,   52,   89,    1,   89,
 /*   560 */    48,   49,   50,   51,   89,   53,   70,   55,   27,   60,
 /*   570 */    29,   42,   60,   89,   17,   18,   80,   20,   59,   83,
 /*   580 */    61,   62,   41,   42,   89,   59,   69,   61,   62,   48,
 /*   590 */    49,   50,   51,   27,   53,   29,   55,   80,   70,   58,
 /*   600 */    83,   60,   85,   86,   87,   69,   23,   41,   80,   81,
 /*   610 */    27,   83,   29,   89,   89,   89,   80,   34,   89,   83,
 /*   620 */    89,   85,   86,   87,   41,   42,   60,   56,   57,   70,
 /*   630 */    89,   48,   49,   50,   51,   89,   53,   69,   55,   80,
 /*   640 */    23,   23,   83,   60,   27,   27,   29,   29,   80,   56,
 /*   650 */    57,   83,   34,   85,   86,   87,   89,   23,   41,   41,
 /*   660 */    42,   27,   28,   29,   89,   89,   48,   49,   50,   51,
 /*   670 */    69,   53,   89,   55,   89,   41,   42,   60,   60,    1,
 /*   680 */    70,   80,   48,   49,   50,   51,   89,   53,   87,   55,
 /*   690 */    80,   81,   89,   83,   60,   17,   18,   89,   20,    4,
 /*   700 */     5,    6,    7,    8,    9,   10,   11,   12,   13,   14,
 /*   710 */    15,   16,    5,    6,    7,    8,    9,   10,   11,   12,
 /*   720 */    13,   14,   15,   16,   23,   89,   68,   89,   89,   71,
 /*   730 */    72,   73,   74,   75,   76,   77,   78,   79,   89,   23,
 /*   740 */    82,   89,   84,   27,   89,   29,   50,   51,   89,   53,
 /*   750 */    59,   55,   61,   62,   89,   23,   89,   41,   42,   27,
 /*   760 */    59,   29,   61,   62,   48,   49,   50,   51,   89,   53,
 /*   770 */    89,   55,   28,   41,   42,   89,   60,   89,   89,   69,
 /*   780 */    48,   49,   50,   51,   89,   53,   27,   55,   29,   89,
 /*   790 */    80,   89,   60,   83,   89,   85,   86,   87,   89,   89,
 /*   800 */    41,   42,   27,   59,   29,   61,   62,   48,   49,   50,
 /*   810 */    51,   89,   53,   89,   55,   89,   41,   42,   89,   60,
 /*   820 */    23,   70,   69,   48,   49,   50,   51,   69,   53,   89,
 /*   830 */    55,   80,    1,   80,   83,   60,   69,   89,   80,   89,
 /*   840 */    87,   83,   89,   85,   86,   87,   69,   80,   17,   18,
 /*   850 */    83,   20,   85,   86,   87,   69,   59,   80,   61,   62,
 /*   860 */    83,   89,   85,   86,   87,   69,   80,   69,   89,   83,
 /*   870 */    89,   85,   86,   87,   11,   69,   80,   69,   80,   83,
 /*   880 */    89,   83,   86,   87,   86,   87,   80,   69,   80,   89,
 /*   890 */     1,   83,   69,   87,   86,   87,    1,   34,   80,   89,
 /*   900 */     1,   83,   23,   80,   86,   87,   17,   18,   11,   20,
 /*   910 */    87,    1,   17,   18,   89,   20,   17,   18,    1,   20,
 /*   920 */    89,   89,   59,   89,   61,   62,    1,   17,   18,   89,
 /*   930 */    20,   89,    1,   89,   17,   18,    1,   20,   59,   89,
 /*   940 */    61,   62,   17,   18,    1,   20,   89,   89,   17,   18,
 /*   950 */     1,   20,   17,   18,    1,   20,   59,   89,   61,   62,
 /*   960 */    17,   18,    1,   20,   70,   89,   17,   18,    1,   20,
 /*   970 */    17,   18,    1,   20,   80,   89,   89,   83,   17,   18,
 /*   980 */    47,   20,    1,   89,   17,   18,    1,   20,   17,   18,
 /*   990 */     1,   20,   59,   89,   61,   62,    1,   89,   17,   18,
 /*  1000 */    89,   20,   17,   18,   89,   20,   17,   18,   70,   20,
 /*  1010 */    89,   89,   17,   18,   70,   20,   70,   89,   80,   81,
 /*  1020 */    89,   83,   89,   89,   80,   89,   80,   83,   89,   83,
);
    const YY_SHIFT_USE_DFLT = -34;
    const YY_SHIFT_MAX = 172;
    static public $yy_shift_ofst = array(
 /*     0 */   -34,   93,   47,  -22,   70,    1,   24,  392,  415,  277,
 /*    10 */   369,  185,  162,  139,  116,  231,  300,  254,  323,  346,
 /*    20 */   208,  438,  541,  541,  541,  541,  541,  541,  541,  541,
 /*    30 */   759,  759,  759,  759,  634,  716,  732,  512,  583,  618,
 /*    40 */   775,  775,  775,  775,  775,  566,  566,  566,  566,  566,
 /*    50 */   566,  509,  617,  989,  985,  566,  995,  566,  566,  696,
 /*    60 */   566,  943,  949,  566,  931,  935,  925,  917,  566,  953,
 /*    70 */   895,  831,  678,  557,  889,  910,  899,  981,  967,  961,
 /*    80 */   566,  696,  566,  566,  971,  593,  -19,  -34,  -34,  -34,
 /*    90 */   -34,  -34,  -34,  -34,  -34,  -34,  -34,  -34,  -34,  -34,
 /*   100 */   -34,  -34,  -34,  -34,  -34,  -34,  -34,  480,  504,  518,
 /*   110 */   695,  707,  707,  863,  526,  483,  443,  701,  519,  797,
 /*   120 */   933,  897,  744,  879,  484,  691,  691,  -17,  -33,  107,
 /*   130 */   529,  571,  119,   29,   -3,  144,  158,  176,   53,   43,
 /*   140 */    89,  104,   98,  -13,  328,  259,  312,  288,  342,  335,
 /*   150 */   236,  219,  213,  245,   36,  170,  286,  351,  305,  197,
 /*   160 */   121,   58,  173,  128,  151,  127,  135,  196,  181,  167,
 /*   170 */   174,   66,   81,
);
    const YY_REDUCE_USE_DFLT = -80;
    const YY_REDUCE_MAX = 106;
    static public $yy_reduce_ofst = array(
 /*     0 */    -7,  658,  658,  658,  658,  658,  658,  658,  658,  658,
 /*    10 */   658,  658,  658,  658,  658,  658,  658,  658,  658,  658,
 /*    20 */   658,  658,  767,  758,  710,  536,  568,  777,  786,  517,
 /*    30 */   818,  808,  796,  798,  938,  528,  610,  894,  894,  894,
 /*    40 */   751,  559,  496,  944,  946,  823,  806,  753,  601,  468,
 /*    50 */    18,   82,  133,  -43,  -43,   55,  -43,  -79,  -10,  125,
 /*    60 */   211,  -43,  -43,   13,  -43,  -43,  -43,  -43,   59,  -43,
 /*    70 */   -43,  -43,  -43,  -43,  -43,  -43,  -43,  -43,  -43,  -43,
 /*    80 */   105,  194,  202,  193,  -43,  201,  212,  222,  200,  177,
 /*    90 */   165,  161,  179,  199,  188,  230,  291,  294,  303,  276,
 /*   100 */   248,  257,  268,  271,  246,  280,  184,
);
    static public $yyExpectedTokens = array(
        /* 0 */ array(),
        /* 1 */ array(22, 24, 25, 26, 27, 29, 30, 31, 32, 33, 36, 37, 38, 39, 40, 41, 43, 44, ),
        /* 2 */ array(22, 24, 25, 26, 27, 29, 30, 31, 32, 33, 36, 37, 38, 39, 40, 41, 43, 44, ),
        /* 3 */ array(22, 24, 25, 26, 27, 29, 30, 31, 32, 33, 36, 37, 38, 39, 40, 41, 43, 44, ),
        /* 4 */ array(22, 24, 25, 26, 27, 29, 30, 31, 32, 33, 36, 37, 38, 39, 40, 41, 43, 44, ),
        /* 5 */ array(22, 24, 25, 26, 27, 29, 30, 31, 32, 33, 35, 36, 38, 39, 40, 41, 43, 44, ),
        /* 6 */ array(22, 24, 25, 26, 27, 29, 30, 31, 32, 33, 36, 37, 38, 39, 40, 41, 43, 44, ),
        /* 7 */ array(22, 24, 25, 26, 27, 29, 30, 31, 32, 33, 36, 38, 39, 40, 41, 43, 44, ),
        /* 8 */ array(22, 24, 25, 26, 27, 29, 30, 31, 32, 33, 36, 38, 39, 40, 41, 43, 44, ),
        /* 9 */ array(22, 24, 25, 26, 27, 29, 30, 31, 32, 33, 36, 38, 39, 40, 41, 43, 44, ),
        /* 10 */ array(22, 24, 25, 26, 27, 29, 30, 31, 32, 33, 36, 38, 39, 40, 41, 43, 44, ),
        /* 11 */ array(22, 24, 25, 26, 27, 29, 30, 31, 32, 33, 36, 38, 39, 40, 41, 43, 44, ),
        /* 12 */ array(22, 24, 25, 26, 27, 29, 30, 31, 32, 33, 36, 38, 39, 40, 41, 43, 44, ),
        /* 13 */ array(22, 24, 25, 26, 27, 29, 30, 31, 32, 33, 36, 38, 39, 40, 41, 43, 44, ),
        /* 14 */ array(22, 24, 25, 26, 27, 29, 30, 31, 32, 33, 36, 38, 39, 40, 41, 43, 44, ),
        /* 15 */ array(22, 24, 25, 26, 27, 29, 30, 31, 32, 33, 36, 38, 39, 40, 41, 43, 44, ),
        /* 16 */ array(22, 24, 25, 26, 27, 29, 30, 31, 32, 33, 36, 38, 39, 40, 41, 43, 44, ),
        /* 17 */ array(22, 24, 25, 26, 27, 29, 30, 31, 32, 33, 36, 38, 39, 40, 41, 43, 44, ),
        /* 18 */ array(22, 24, 25, 26, 27, 29, 30, 31, 32, 33, 36, 38, 39, 40, 41, 43, 44, ),
        /* 19 */ array(22, 24, 25, 26, 27, 29, 30, 31, 32, 33, 36, 38, 39, 40, 41, 43, 44, ),
        /* 20 */ array(22, 24, 25, 26, 27, 29, 30, 31, 32, 33, 36, 38, 39, 40, 41, 43, 44, ),
        /* 21 */ array(22, 24, 25, 27, 29, 30, 31, 32, 33, 36, 38, 39, 40, 41, 43, 44, ),
        /* 22 */ array(2, 27, 29, 41, 42, 48, 49, 50, 51, 53, 55, 58, 60, ),
        /* 23 */ array(2, 27, 29, 41, 42, 48, 49, 50, 51, 53, 55, 58, 60, ),
        /* 24 */ array(2, 27, 29, 41, 42, 48, 49, 50, 51, 53, 55, 58, 60, ),
        /* 25 */ array(2, 27, 29, 41, 42, 48, 49, 50, 51, 53, 55, 58, 60, ),
        /* 26 */ array(2, 27, 29, 41, 42, 48, 49, 50, 51, 53, 55, 58, 60, ),
        /* 27 */ array(2, 27, 29, 41, 42, 48, 49, 50, 51, 53, 55, 58, 60, ),
        /* 28 */ array(2, 27, 29, 41, 42, 48, 49, 50, 51, 53, 55, 58, 60, ),
        /* 29 */ array(2, 27, 29, 41, 42, 48, 49, 50, 51, 53, 55, 58, 60, ),
        /* 30 */ array(27, 29, 41, 42, 48, 49, 50, 51, 53, 55, 60, ),
        /* 31 */ array(27, 29, 41, 42, 48, 49, 50, 51, 53, 55, 60, ),
        /* 32 */ array(27, 29, 41, 42, 48, 49, 50, 51, 53, 55, 60, ),
        /* 33 */ array(27, 29, 41, 42, 48, 49, 50, 51, 53, 55, 60, ),
        /* 34 */ array(23, 27, 28, 29, 41, 42, 48, 49, 50, 51, 53, 55, 60, ),
        /* 35 */ array(23, 27, 29, 41, 42, 48, 49, 50, 51, 53, 55, 60, ),
        /* 36 */ array(23, 27, 29, 41, 42, 48, 49, 50, 51, 53, 55, 60, ),
        /* 37 */ array(23, 27, 28, 29, 34, 41, 42, 48, 49, 50, 51, 53, 55, 60, ),
        /* 38 */ array(23, 27, 29, 34, 41, 42, 48, 49, 50, 51, 53, 55, 60, ),
        /* 39 */ array(23, 27, 29, 34, 41, 42, 48, 49, 50, 51, 53, 55, 60, ),
        /* 40 */ array(27, 29, 41, 42, 48, 49, 50, 51, 53, 55, 60, ),
        /* 41 */ array(27, 29, 41, 42, 48, 49, 50, 51, 53, 55, 60, ),
        /* 42 */ array(27, 29, 41, 42, 48, 49, 50, 51, 53, 55, 60, ),
        /* 43 */ array(27, 29, 41, 42, 48, 49, 50, 51, 53, 55, 60, ),
        /* 44 */ array(27, 29, 41, 42, 48, 49, 50, 51, 53, 55, 60, ),
        /* 45 */ array(27, 29, 41, 60, ),
        /* 46 */ array(27, 29, 41, 60, ),
        /* 47 */ array(27, 29, 41, 60, ),
        /* 48 */ array(27, 29, 41, 60, ),
        /* 49 */ array(27, 29, 41, 60, ),
        /* 50 */ array(27, 29, 41, 60, ),
        /* 51 */ array(27, 29, 41, 42, 60, ),
        /* 52 */ array(23, 27, 29, 41, 60, ),
        /* 53 */ array(1, 17, 18, 20, ),
        /* 54 */ array(1, 17, 18, 20, ),
        /* 55 */ array(27, 29, 41, 60, ),
        /* 56 */ array(1, 17, 18, 20, ),
        /* 57 */ array(27, 29, 41, 60, ),
        /* 58 */ array(27, 29, 41, 60, ),
        /* 59 */ array(50, 51, 53, 55, ),
        /* 60 */ array(27, 29, 41, 60, ),
        /* 61 */ array(1, 17, 18, 20, ),
        /* 62 */ array(1, 17, 18, 20, ),
        /* 63 */ array(27, 29, 41, 60, ),
        /* 64 */ array(1, 17, 18, 20, ),
        /* 65 */ array(1, 17, 18, 20, ),
        /* 66 */ array(1, 17, 18, 20, ),
        /* 67 */ array(1, 17, 18, 20, ),
        /* 68 */ array(27, 29, 41, 60, ),
        /* 69 */ array(1, 17, 18, 20, ),
        /* 70 */ array(1, 17, 18, 20, ),
        /* 71 */ array(1, 17, 18, 20, ),
        /* 72 */ array(1, 17, 18, 20, ),
        /* 73 */ array(1, 17, 18, 20, ),
        /* 74 */ array(1, 17, 18, 20, ),
        /* 75 */ array(1, 17, 18, 20, ),
        /* 76 */ array(1, 17, 18, 20, ),
        /* 77 */ array(1, 17, 18, 20, ),
        /* 78 */ array(1, 17, 18, 20, ),
        /* 79 */ array(1, 17, 18, 20, ),
        /* 80 */ array(27, 29, 41, 60, ),
        /* 81 */ array(50, 51, 53, 55, ),
        /* 82 */ array(27, 29, 41, 60, ),
        /* 83 */ array(27, 29, 41, 60, ),
        /* 84 */ array(1, 17, 18, 20, ),
        /* 85 */ array(56, 57, ),
        /* 86 */ array(54, 57, ),
        /* 87 */ array(),
        /* 88 */ array(),
        /* 89 */ array(),
        /* 90 */ array(),
        /* 91 */ array(),
        /* 92 */ array(),
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
        /* 107 */ array(3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 23, ),
        /* 108 */ array(3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 52, ),
        /* 109 */ array(3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, ),
        /* 110 */ array(4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, ),
        /* 111 */ array(5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, ),
        /* 112 */ array(5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, ),
        /* 113 */ array(11, 34, 59, 61, 62, ),
        /* 114 */ array(23, 59, 61, 62, ),
        /* 115 */ array(23, 59, 61, 62, ),
        /* 116 */ array(23, 59, 61, 62, ),
        /* 117 */ array(23, 59, 61, 62, ),
        /* 118 */ array(28, 59, 61, 62, ),
        /* 119 */ array(23, 59, 61, 62, ),
        /* 120 */ array(47, 59, 61, 62, ),
        /* 121 */ array(11, 59, 61, 62, ),
        /* 122 */ array(28, 59, 61, 62, ),
        /* 123 */ array(23, 59, 61, 62, ),
        /* 124 */ array(14, 15, 16, ),
        /* 125 */ array(59, 61, 62, ),
        /* 126 */ array(59, 61, 62, ),
        /* 127 */ array(23, 46, ),
        /* 128 */ array(45, 46, ),
        /* 129 */ array(21, 46, ),
        /* 130 */ array(23, 42, ),
        /* 131 */ array(56, 57, ),
        /* 132 */ array(54, 57, ),
        /* 133 */ array(23, 46, ),
        /* 134 */ array(23, 46, ),
        /* 135 */ array(23, ),
        /* 136 */ array(23, ),
        /* 137 */ array(23, ),
        /* 138 */ array(63, ),
        /* 139 */ array(23, ),
        /* 140 */ array(23, ),
        /* 141 */ array(23, ),
        /* 142 */ array(23, ),
        /* 143 */ array(60, ),
        /* 144 */ array(23, ),
        /* 145 */ array(60, ),
        /* 146 */ array(23, ),
        /* 147 */ array(23, ),
        /* 148 */ array(23, ),
        /* 149 */ array(23, ),
        /* 150 */ array(23, ),
        /* 151 */ array(23, ),
        /* 152 */ array(23, ),
        /* 153 */ array(23, ),
        /* 154 */ array(46, ),
        /* 155 */ array(52, ),
        /* 156 */ array(19, ),
        /* 157 */ array(23, ),
        /* 158 */ array(23, ),
        /* 159 */ array(23, ),
        /* 160 */ array(23, ),
        /* 161 */ array(23, ),
        /* 162 */ array(23, ),
        /* 163 */ array(23, ),
        /* 164 */ array(23, ),
        /* 165 */ array(23, ),
        /* 166 */ array(23, ),
        /* 167 */ array(23, ),
        /* 168 */ array(23, ),
        /* 169 */ array(23, ),
        /* 170 */ array(23, ),
        /* 171 */ array(23, ),
        /* 172 */ array(23, ),
        /* 173 */ array(),
        /* 174 */ array(),
        /* 175 */ array(),
        /* 176 */ array(),
        /* 177 */ array(),
        /* 178 */ array(),
        /* 179 */ array(),
        /* 180 */ array(),
        /* 181 */ array(),
        /* 182 */ array(),
        /* 183 */ array(),
        /* 184 */ array(),
        /* 185 */ array(),
        /* 186 */ array(),
        /* 187 */ array(),
        /* 188 */ array(),
        /* 189 */ array(),
        /* 190 */ array(),
        /* 191 */ array(),
        /* 192 */ array(),
        /* 193 */ array(),
        /* 194 */ array(),
        /* 195 */ array(),
        /* 196 */ array(),
        /* 197 */ array(),
        /* 198 */ array(),
        /* 199 */ array(),
        /* 200 */ array(),
        /* 201 */ array(),
        /* 202 */ array(),
        /* 203 */ array(),
        /* 204 */ array(),
        /* 205 */ array(),
        /* 206 */ array(),
        /* 207 */ array(),
        /* 208 */ array(),
        /* 209 */ array(),
        /* 210 */ array(),
        /* 211 */ array(),
        /* 212 */ array(),
        /* 213 */ array(),
        /* 214 */ array(),
        /* 215 */ array(),
        /* 216 */ array(),
        /* 217 */ array(),
        /* 218 */ array(),
        /* 219 */ array(),
        /* 220 */ array(),
        /* 221 */ array(),
        /* 222 */ array(),
        /* 223 */ array(),
        /* 224 */ array(),
        /* 225 */ array(),
        /* 226 */ array(),
        /* 227 */ array(),
        /* 228 */ array(),
        /* 229 */ array(),
        /* 230 */ array(),
        /* 231 */ array(),
        /* 232 */ array(),
        /* 233 */ array(),
        /* 234 */ array(),
        /* 235 */ array(),
        /* 236 */ array(),
        /* 237 */ array(),
        /* 238 */ array(),
        /* 239 */ array(),
        /* 240 */ array(),
        /* 241 */ array(),
        /* 242 */ array(),
        /* 243 */ array(),
        /* 244 */ array(),
        /* 245 */ array(),
        /* 246 */ array(),
);
    static public $yy_default = array(
 /*     0 */   249,  332,  332,  332,  332,  332,  332,  332,  332,  332,
 /*    10 */   332,  332,  332,  332,  332,  332,  332,  332,  332,  332,
 /*    20 */   332,  332,  332,  332,  332,  332,  332,  332,  332,  332,
 /*    30 */   332,  332,  332,  332,  332,  332,  332,  332,  332,  332,
 /*    40 */   332,  332,  332,  332,  332,  332,  332,  332,  332,  332,
 /*    50 */   332,  332,  332,  332,  332,  332,  332,  332,  332,  332,
 /*    60 */   332,  332,  332,  332,  332,  332,  332,  332,  332,  332,
 /*    70 */   247,  332,  332,  332,  332,  332,  332,  332,  332,  332,
 /*    80 */   332,  332,  332,  332,  332,  332,  332,  249,  249,  249,
 /*    90 */   249,  249,  249,  249,  249,  249,  249,  249,  249,  249,
 /*   100 */   249,  249,  249,  249,  249,  249,  249,  332,  332,  319,
 /*   110 */   320,  321,  323,  332,  332,  332,  332,  332,  332,  332,
 /*   120 */   299,  332,  332,  332,  322,  295,  303,  332,  332,  332,
 /*   130 */   332,  332,  332,  332,  332,  332,  332,  332,  332,  332,
 /*   140 */   332,  332,  332,  332,  332,  332,  332,  332,  332,  332,
 /*   150 */   332,  332,  332,  332,  307,  332,  332,  332,  332,  332,
 /*   160 */   332,  332,  332,  332,  332,  332,  332,  332,  332,  332,
 /*   170 */   332,  332,  332,  265,  305,  306,  272,  280,  309,  308,
 /*   180 */   293,  310,  301,  311,  266,  283,  296,  298,  268,  326,
 /*   190 */   325,  297,  250,  271,  277,  248,  254,  324,  276,  328,
 /*   200 */   304,  279,  327,  278,  300,  267,  285,  302,  329,  289,
 /*   210 */   286,  269,  260,  275,  290,  316,  330,  331,  273,  256,
 /*   220 */   257,  255,  258,  274,  288,  259,  291,  314,  313,  252,
 /*   230 */   251,  282,  253,  312,  281,  287,  264,  263,  318,  261,
 /*   240 */   270,  262,  294,  315,  284,  317,  292,
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
    const YYNOCODE = 90;
    const YYSTACKDEPTH = 100;
    const YYNSTATE = 247;
    const YYNRULE = 85;
    const YYERRORSYMBOL = 64;
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
  '$',             'T_OPEN_TAG',    'T_NOT',         'T_AND',       
  'T_OR',          'T_EQ',          'T_NE',          'T_GT',        
  'T_GE',          'T_LT',          'T_LE',          'T_IN',        
  'T_PLUS',        'T_MINUS',       'T_TIMES',       'T_DIV',       
  'T_MOD',         'T_HTML',        'T_COMMENT_OPEN',  'T_COMMENT',   
  'T_PRINT_OPEN',  'T_PRINT_CLOSE',  'T_EXTENDS',     'T_CLOSE_TAG', 
  'T_INCLUDE',     'T_AUTOESCAPE',  'T_CUSTOM_END',  'T_CUSTOM_TAG',
  'T_AS',          'T_CUSTOM_BLOCK',  'T_SPACEFULL',   'T_WITH',      
  'T_LOAD',        'T_FOR',         'T_COMMA',       'T_EMPTY',     
  'T_IF',          'T_ELSE',        'T_IFCHANGED',   'T_IFEQUAL',   
  'T_IFNOTEQUAL',  'T_BLOCK',       'T_NUMERIC',     'T_FILTER',    
  'T_REGROUP',     'T_BY',          'T_PIPE',        'T_COLON',     
  'T_TRUE',        'T_FALSE',       'T_STRING',      'T_INTL',      
  'T_RPARENT',     'T_STRING_SINGLE_INIT',  'T_STRING_SINGLE_END',  'T_STRING_DOUBLE_INIT',
  'T_STRING_DOUBLE_END',  'T_STRING_CONTENT',  'T_LPARENT',     'T_OBJ',       
  'T_ALPHA',       'T_DOT',         'T_BRACKETS_OPEN',  'T_BRACKETS_CLOSE',
  'error',         'start',         'body',          'code',        
  'stmts',         'filtered_var',  'var_or_string',  'stmt',        
  'for_stmt',      'ifchanged_stmt',  'block_stmt',    'filter_stmt', 
  'if_stmt',       'custom_tag',    'alias',         'ifequal',     
  'varname',       'params',        'regroup',       'string',      
  'for_def',       'expr',          'fvar_or_string',  'varname_args',
  's_content',   
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
 /*   6 */ "code ::= T_PRINT_OPEN filtered_var T_PRINT_CLOSE",
 /*   7 */ "stmts ::= T_EXTENDS var_or_string T_CLOSE_TAG",
 /*   8 */ "stmts ::= stmt T_CLOSE_TAG",
 /*   9 */ "stmts ::= for_stmt",
 /*  10 */ "stmts ::= ifchanged_stmt",
 /*  11 */ "stmts ::= block_stmt",
 /*  12 */ "stmts ::= filter_stmt",
 /*  13 */ "stmts ::= if_stmt",
 /*  14 */ "stmts ::= T_INCLUDE var_or_string T_CLOSE_TAG",
 /*  15 */ "stmts ::= custom_tag",
 /*  16 */ "stmts ::= alias",
 /*  17 */ "stmts ::= ifequal",
 /*  18 */ "stmts ::= T_AUTOESCAPE varname T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  19 */ "custom_tag ::= T_CUSTOM_TAG T_CLOSE_TAG",
 /*  20 */ "custom_tag ::= T_CUSTOM_TAG T_AS varname T_CLOSE_TAG",
 /*  21 */ "custom_tag ::= T_CUSTOM_TAG params T_CLOSE_TAG",
 /*  22 */ "custom_tag ::= T_CUSTOM_TAG params T_AS varname T_CLOSE_TAG",
 /*  23 */ "custom_tag ::= T_CUSTOM_BLOCK T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  24 */ "custom_tag ::= T_CUSTOM_BLOCK params T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  25 */ "custom_tag ::= T_SPACEFULL T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  26 */ "alias ::= T_WITH varname T_AS varname T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  27 */ "stmt ::= regroup",
 /*  28 */ "stmt ::= T_LOAD string",
 /*  29 */ "for_def ::= T_FOR varname T_IN filtered_var T_CLOSE_TAG",
 /*  30 */ "for_def ::= T_FOR varname T_COMMA varname T_IN filtered_var T_CLOSE_TAG",
 /*  31 */ "for_stmt ::= for_def body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  32 */ "for_stmt ::= for_def body T_OPEN_TAG T_EMPTY T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  33 */ "if_stmt ::= T_IF expr T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  34 */ "if_stmt ::= T_IF expr T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  35 */ "ifchanged_stmt ::= T_IFCHANGED T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  36 */ "ifchanged_stmt ::= T_IFCHANGED params T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  37 */ "ifchanged_stmt ::= T_IFCHANGED T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  38 */ "ifchanged_stmt ::= T_IFCHANGED params T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  39 */ "ifequal ::= T_IFEQUAL fvar_or_string fvar_or_string T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  40 */ "ifequal ::= T_IFEQUAL fvar_or_string fvar_or_string T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  41 */ "ifequal ::= T_IFNOTEQUAL fvar_or_string fvar_or_string T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  42 */ "ifequal ::= T_IFNOTEQUAL fvar_or_string fvar_or_string T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  43 */ "block_stmt ::= T_BLOCK varname T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  44 */ "block_stmt ::= T_BLOCK varname T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END varname T_CLOSE_TAG",
 /*  45 */ "block_stmt ::= T_BLOCK T_NUMERIC T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  46 */ "block_stmt ::= T_BLOCK T_NUMERIC T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_NUMERIC T_CLOSE_TAG",
 /*  47 */ "filter_stmt ::= T_FILTER filtered_var T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  48 */ "regroup ::= T_REGROUP filtered_var T_BY varname T_AS varname",
 /*  49 */ "filtered_var ::= filtered_var T_PIPE varname_args",
 /*  50 */ "filtered_var ::= varname_args",
 /*  51 */ "varname_args ::= varname T_COLON var_or_string",
 /*  52 */ "varname_args ::= varname",
 /*  53 */ "params ::= params var_or_string",
 /*  54 */ "params ::= params T_COMMA var_or_string",
 /*  55 */ "params ::= var_or_string",
 /*  56 */ "var_or_string ::= varname",
 /*  57 */ "var_or_string ::= T_NUMERIC",
 /*  58 */ "var_or_string ::= T_TRUE|T_FALSE",
 /*  59 */ "var_or_string ::= string",
 /*  60 */ "fvar_or_string ::= filtered_var",
 /*  61 */ "fvar_or_string ::= T_NUMERIC",
 /*  62 */ "fvar_or_string ::= T_TRUE|T_FALSE",
 /*  63 */ "fvar_or_string ::= string",
 /*  64 */ "string ::= T_STRING",
 /*  65 */ "string ::= T_INTL string T_RPARENT",
 /*  66 */ "string ::= T_STRING_SINGLE_INIT T_STRING_SINGLE_END",
 /*  67 */ "string ::= T_STRING_DOUBLE_INIT T_STRING_DOUBLE_END",
 /*  68 */ "string ::= T_STRING_SINGLE_INIT s_content T_STRING_SINGLE_END",
 /*  69 */ "string ::= T_STRING_DOUBLE_INIT s_content T_STRING_DOUBLE_END",
 /*  70 */ "s_content ::= s_content T_STRING_CONTENT",
 /*  71 */ "s_content ::= T_STRING_CONTENT",
 /*  72 */ "expr ::= T_NOT expr",
 /*  73 */ "expr ::= expr T_AND expr",
 /*  74 */ "expr ::= expr T_OR expr",
 /*  75 */ "expr ::= expr T_PLUS|T_MINUS expr",
 /*  76 */ "expr ::= expr T_EQ|T_NE|T_GT|T_GE|T_LT|T_LE|T_IN expr",
 /*  77 */ "expr ::= expr T_TIMES|T_DIV|T_MOD expr",
 /*  78 */ "expr ::= T_LPARENT expr T_RPARENT",
 /*  79 */ "expr ::= fvar_or_string",
 /*  80 */ "varname ::= varname T_OBJ T_ALPHA",
 /*  81 */ "varname ::= varname T_DOT T_ALPHA",
 /*  82 */ "varname ::= varname T_BRACKETS_OPEN var_or_string T_BRACKETS_CLOSE",
 /*  83 */ "varname ::= T_ALPHA",
 /*  84 */ "varname ::= T_BLOCK|T_CUSTOM_TAG|T_CUSTOM_BLOCK",
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
  array( 'lhs' => 65, 'rhs' => 1 ),
  array( 'lhs' => 66, 'rhs' => 2 ),
  array( 'lhs' => 66, 'rhs' => 0 ),
  array( 'lhs' => 67, 'rhs' => 2 ),
  array( 'lhs' => 67, 'rhs' => 1 ),
  array( 'lhs' => 67, 'rhs' => 2 ),
  array( 'lhs' => 67, 'rhs' => 3 ),
  array( 'lhs' => 68, 'rhs' => 3 ),
  array( 'lhs' => 68, 'rhs' => 2 ),
  array( 'lhs' => 68, 'rhs' => 1 ),
  array( 'lhs' => 68, 'rhs' => 1 ),
  array( 'lhs' => 68, 'rhs' => 1 ),
  array( 'lhs' => 68, 'rhs' => 1 ),
  array( 'lhs' => 68, 'rhs' => 1 ),
  array( 'lhs' => 68, 'rhs' => 3 ),
  array( 'lhs' => 68, 'rhs' => 1 ),
  array( 'lhs' => 68, 'rhs' => 1 ),
  array( 'lhs' => 68, 'rhs' => 1 ),
  array( 'lhs' => 68, 'rhs' => 7 ),
  array( 'lhs' => 77, 'rhs' => 2 ),
  array( 'lhs' => 77, 'rhs' => 4 ),
  array( 'lhs' => 77, 'rhs' => 3 ),
  array( 'lhs' => 77, 'rhs' => 5 ),
  array( 'lhs' => 77, 'rhs' => 6 ),
  array( 'lhs' => 77, 'rhs' => 7 ),
  array( 'lhs' => 77, 'rhs' => 6 ),
  array( 'lhs' => 78, 'rhs' => 9 ),
  array( 'lhs' => 71, 'rhs' => 1 ),
  array( 'lhs' => 71, 'rhs' => 2 ),
  array( 'lhs' => 84, 'rhs' => 5 ),
  array( 'lhs' => 84, 'rhs' => 7 ),
  array( 'lhs' => 72, 'rhs' => 5 ),
  array( 'lhs' => 72, 'rhs' => 9 ),
  array( 'lhs' => 76, 'rhs' => 7 ),
  array( 'lhs' => 76, 'rhs' => 11 ),
  array( 'lhs' => 73, 'rhs' => 6 ),
  array( 'lhs' => 73, 'rhs' => 7 ),
  array( 'lhs' => 73, 'rhs' => 10 ),
  array( 'lhs' => 73, 'rhs' => 11 ),
  array( 'lhs' => 79, 'rhs' => 8 ),
  array( 'lhs' => 79, 'rhs' => 12 ),
  array( 'lhs' => 79, 'rhs' => 8 ),
  array( 'lhs' => 79, 'rhs' => 12 ),
  array( 'lhs' => 74, 'rhs' => 7 ),
  array( 'lhs' => 74, 'rhs' => 8 ),
  array( 'lhs' => 74, 'rhs' => 7 ),
  array( 'lhs' => 74, 'rhs' => 8 ),
  array( 'lhs' => 75, 'rhs' => 7 ),
  array( 'lhs' => 82, 'rhs' => 6 ),
  array( 'lhs' => 69, 'rhs' => 3 ),
  array( 'lhs' => 69, 'rhs' => 1 ),
  array( 'lhs' => 87, 'rhs' => 3 ),
  array( 'lhs' => 87, 'rhs' => 1 ),
  array( 'lhs' => 81, 'rhs' => 2 ),
  array( 'lhs' => 81, 'rhs' => 3 ),
  array( 'lhs' => 81, 'rhs' => 1 ),
  array( 'lhs' => 70, 'rhs' => 1 ),
  array( 'lhs' => 70, 'rhs' => 1 ),
  array( 'lhs' => 70, 'rhs' => 1 ),
  array( 'lhs' => 70, 'rhs' => 1 ),
  array( 'lhs' => 86, 'rhs' => 1 ),
  array( 'lhs' => 86, 'rhs' => 1 ),
  array( 'lhs' => 86, 'rhs' => 1 ),
  array( 'lhs' => 86, 'rhs' => 1 ),
  array( 'lhs' => 83, 'rhs' => 1 ),
  array( 'lhs' => 83, 'rhs' => 3 ),
  array( 'lhs' => 83, 'rhs' => 2 ),
  array( 'lhs' => 83, 'rhs' => 2 ),
  array( 'lhs' => 83, 'rhs' => 3 ),
  array( 'lhs' => 83, 'rhs' => 3 ),
  array( 'lhs' => 88, 'rhs' => 2 ),
  array( 'lhs' => 88, 'rhs' => 1 ),
  array( 'lhs' => 85, 'rhs' => 2 ),
  array( 'lhs' => 85, 'rhs' => 3 ),
  array( 'lhs' => 85, 'rhs' => 3 ),
  array( 'lhs' => 85, 'rhs' => 3 ),
  array( 'lhs' => 85, 'rhs' => 3 ),
  array( 'lhs' => 85, 'rhs' => 3 ),
  array( 'lhs' => 85, 'rhs' => 3 ),
  array( 'lhs' => 85, 'rhs' => 1 ),
  array( 'lhs' => 80, 'rhs' => 3 ),
  array( 'lhs' => 80, 'rhs' => 3 ),
  array( 'lhs' => 80, 'rhs' => 4 ),
  array( 'lhs' => 80, 'rhs' => 1 ),
  array( 'lhs' => 80, 'rhs' => 1 ),
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
        65 => 8,
        9 => 9,
        10 => 9,
        11 => 9,
        12 => 9,
        13 => 9,
        15 => 9,
        16 => 9,
        17 => 9,
        27 => 9,
        52 => 9,
        64 => 9,
        71 => 9,
        79 => 9,
        83 => 9,
        84 => 9,
        14 => 14,
        18 => 18,
        19 => 19,
        20 => 20,
        21 => 21,
        22 => 22,
        23 => 23,
        24 => 24,
        25 => 25,
        26 => 26,
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
        42 => 42,
        43 => 43,
        44 => 44,
        46 => 44,
        45 => 45,
        47 => 47,
        48 => 48,
        49 => 49,
        54 => 49,
        50 => 50,
        55 => 50,
        51 => 51,
        53 => 53,
        56 => 56,
        57 => 57,
        61 => 57,
        58 => 58,
        62 => 58,
        59 => 59,
        63 => 59,
        60 => 60,
        66 => 66,
        67 => 66,
        68 => 68,
        69 => 68,
        70 => 70,
        72 => 72,
        73 => 73,
        74 => 73,
        75 => 73,
        77 => 73,
        76 => 76,
        78 => 78,
        80 => 80,
        81 => 81,
        82 => 82,
    );
    /* Beginning here are the reduction cases.  A typical example
    ** follows:
    **  #line <lineno> <grammarfile>
    **   function yy_r0($yymsp){ ... }           // User supplied code
    **  #line <lineno> <thisfile>
    */
#line 79 "lib/Haanga/Compiler/Parser.y"
    function yy_r0(){ $this->body = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1584 "lib/Haanga/Compiler/Parser.php"
#line 81 "lib/Haanga/Compiler/Parser.y"
    function yy_r1(){ $this->_retvalue=$this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1587 "lib/Haanga/Compiler/Parser.php"
#line 82 "lib/Haanga/Compiler/Parser.y"
    function yy_r2(){ $this->_retvalue = array();     }
#line 1590 "lib/Haanga/Compiler/Parser.php"
#line 85 "lib/Haanga/Compiler/Parser.y"
    function yy_r3(){ if (count($this->yystack[$this->yyidx + 0]->minor)) $this->yystack[$this->yyidx + 0]->minor['line'] = $this->lex->getLine();  $this->_retvalue = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1593 "lib/Haanga/Compiler/Parser.php"
#line 86 "lib/Haanga/Compiler/Parser.y"
    function yy_r4(){
    $this->_retvalue = array('operation' => 'html', 'html' => $this->yystack[$this->yyidx + 0]->minor, 'line' => $this->lex->getLine() ); 
    }
#line 1598 "lib/Haanga/Compiler/Parser.php"
#line 89 "lib/Haanga/Compiler/Parser.y"
    function yy_r5(){
    $this->yystack[$this->yyidx + 0]->minor=rtrim($this->yystack[$this->yyidx + 0]->minor); $this->_retvalue = array('operation' => 'comment', 'comment' => substr($this->yystack[$this->yyidx + 0]->minor, 0, strlen($this->yystack[$this->yyidx + 0]->minor)-2)); 
    }
#line 1603 "lib/Haanga/Compiler/Parser.php"
#line 92 "lib/Haanga/Compiler/Parser.y"
    function yy_r6(){
    $this->_retvalue = array('operation' => 'print_var', 'variable' => $this->yystack[$this->yyidx + -1]->minor, 'line' => $this->lex->getLine() ); 
    }
#line 1608 "lib/Haanga/Compiler/Parser.php"
#line 96 "lib/Haanga/Compiler/Parser.y"
    function yy_r7(){ $this->_retvalue = array('operation' => 'base', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1611 "lib/Haanga/Compiler/Parser.php"
#line 97 "lib/Haanga/Compiler/Parser.y"
    function yy_r8(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1614 "lib/Haanga/Compiler/Parser.php"
#line 98 "lib/Haanga/Compiler/Parser.y"
    function yy_r9(){ $this->_retvalue = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1617 "lib/Haanga/Compiler/Parser.php"
#line 103 "lib/Haanga/Compiler/Parser.y"
    function yy_r14(){ $this->_retvalue = array('operation' => 'include', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1620 "lib/Haanga/Compiler/Parser.php"
#line 107 "lib/Haanga/Compiler/Parser.y"
    function yy_r18(){ 
    $this->yystack[$this->yyidx + -5]->minor = strtolower($this->yystack[$this->yyidx + -5]->minor);
    if ($this->yystack[$this->yyidx + -5]->minor != 'on' && $this->yystack[$this->yyidx + -5]->minor != 'off') {
        $this->Error("Invalid autoescape param (".$this->yystack[$this->yyidx + -5]->minor."), it must be on or off");
    }
    if ($this->yystack[$this->yyidx + -1]->minor != "endautoescape") {
        $this->Error("Invalid close tag ".$this->yystack[$this->yyidx + -1]->minor.", it must be endautoescape");
    }
    $this->_retvalue = array('operation' => 'autoescape', 'value' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1632 "lib/Haanga/Compiler/Parser.php"
#line 121 "lib/Haanga/Compiler/Parser.y"
    function yy_r19(){
    $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -1]->minor, 'list'=>array()); 
    }
#line 1637 "lib/Haanga/Compiler/Parser.php"
#line 124 "lib/Haanga/Compiler/Parser.y"
    function yy_r20(){
    $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -3]->minor, 'as' => $this->yystack[$this->yyidx + -1]->minor, 'list'=>array()); 
    }
#line 1642 "lib/Haanga/Compiler/Parser.php"
#line 127 "lib/Haanga/Compiler/Parser.y"
    function yy_r21(){ 
    $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -2]->minor, 'list' => $this->yystack[$this->yyidx + -1]->minor); 
    }
#line 1647 "lib/Haanga/Compiler/Parser.php"
#line 130 "lib/Haanga/Compiler/Parser.y"
    function yy_r22(){
    $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -4]->minor, 'as' => $this->yystack[$this->yyidx + -1]->minor, 'list' => $this->yystack[$this->yyidx + -3]->minor);
    }
#line 1652 "lib/Haanga/Compiler/Parser.php"
#line 135 "lib/Haanga/Compiler/Parser.y"
    function yy_r23(){
    if ('end'.$this->yystack[$this->yyidx + -5]->minor != $this->yystack[$this->yyidx + -1]->minor) { 
        $this->error("Unexpected ".$this->yystack[$this->yyidx + -1]->minor); 
    } 
    $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor, 'list' => array());
    }
#line 1660 "lib/Haanga/Compiler/Parser.php"
#line 141 "lib/Haanga/Compiler/Parser.y"
    function yy_r24(){
    if ('end'.$this->yystack[$this->yyidx + -6]->minor != $this->yystack[$this->yyidx + -1]->minor) { 
        $this->error("Unexpected ".$this->yystack[$this->yyidx + -1]->minor); 
    } 
    $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -6]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor, 'list' => $this->yystack[$this->yyidx + -5]->minor);
    }
#line 1668 "lib/Haanga/Compiler/Parser.php"
#line 149 "lib/Haanga/Compiler/Parser.y"
    function yy_r25(){
    if ('endspacefull' != $this->yystack[$this->yyidx + -1]->minor) {
        $this->error("Unexpected ".$this->yystack[$this->yyidx + -1]->minor);
    } 
    $this->_retvalue = array('operation' => 'spacefull', 'body' => $this->yystack[$this->yyidx + -3]->minor);
    }
#line 1676 "lib/Haanga/Compiler/Parser.php"
#line 157 "lib/Haanga/Compiler/Parser.y"
    function yy_r26(){
    if ($this->yystack[$this->yyidx + -1]->minor != "endwith") {
        $this->Error("Unexpected ".$this->yystack[$this->yyidx + -1]->minor.", expecting endwith");
    }
    $this->_retvalue = array('operation' => 'alias', 'var' => $this->yystack[$this->yyidx + -7]->minor, 'as' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1684 "lib/Haanga/Compiler/Parser.php"
#line 166 "lib/Haanga/Compiler/Parser.y"
    function yy_r28(){
    if (!is_file($this->yystack[$this->yyidx + 0]->minor) || !Haanga_Compiler::getOption('enable_load')) {
        $this->error($this->yystack[$this->yyidx + 0]->minor." is not a valid file"); 
    } 
    require_once $this->yystack[$this->yyidx + 0]->minor;
    }
#line 1692 "lib/Haanga/Compiler/Parser.php"
#line 174 "lib/Haanga/Compiler/Parser.y"
    function yy_r29(){
    /* Try to get the variable */
    $var = $this->compiler->get_context(is_array($this->yystack[$this->yyidx + -1]->minor[0]) ? $this->yystack[$this->yyidx + -1]->minor[0] : array($this->yystack[$this->yyidx + -1]->minor[0]));
    if (is_array($var)) {
        /* let's check if it is an object or array */
        $this->compiler->set_context($this->yystack[$this->yyidx + -3]->minor, current($var));
    }

    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -3]->minor, 'index' => NULL, 'array' => $this->yystack[$this->yyidx + -1]->minor);
    }
#line 1704 "lib/Haanga/Compiler/Parser.php"
#line 183 "lib/Haanga/Compiler/Parser.y"
    function yy_r30(){
    /* Try to get the variable */
    $var = $this->compiler->get_context(is_array($this->yystack[$this->yyidx + -1]->minor[0]) ? $this->yystack[$this->yyidx + -1]->minor[0] : array($this->yystack[$this->yyidx + -1]->minor[0]));
    if (is_array($var)) {
        /* let's check if it is an object or array */
        $this->compiler->set_context($this->yystack[$this->yyidx + -3]->minor, current($var));
    }
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -3]->minor, 'index' => $this->yystack[$this->yyidx + -5]->minor, 'array' => $this->yystack[$this->yyidx + -1]->minor);
    }
#line 1715 "lib/Haanga/Compiler/Parser.php"
#line 192 "lib/Haanga/Compiler/Parser.y"
    function yy_r31(){ 
    if ($this->yystack[$this->yyidx + -1]->minor != "endfor") {
        $this->Error("Unexpected ".$this->yystack[$this->yyidx + -1]->minor.", expecting endfor");
    }
    $this->_retvalue = $this->yystack[$this->yyidx + -4]->minor;
    $this->_retvalue['body'] = $this->yystack[$this->yyidx + -3]->minor;
    }
#line 1724 "lib/Haanga/Compiler/Parser.php"
#line 200 "lib/Haanga/Compiler/Parser.y"
    function yy_r32(){ 
    if ($this->yystack[$this->yyidx + -1]->minor != "endfor") {
        $this->Error("Unexpected ".$this->yystack[$this->yyidx + -1]->minor.", expecting endfor");
    }
    $this->_retvalue = $this->yystack[$this->yyidx + -8]->minor;
    $this->_retvalue['body']  = $this->yystack[$this->yyidx + -7]->minor;
    $this->_retvalue['empty'] = $this->yystack[$this->yyidx + -3]->minor;
    }
#line 1734 "lib/Haanga/Compiler/Parser.php"
#line 209 "lib/Haanga/Compiler/Parser.y"
    function yy_r33(){
    if ($this->yystack[$this->yyidx + -1]->minor != "endif") {
        $this->Error("Unexpected ".$this->yystack[$this->yyidx + -1]->minor.", expecting endif");
    }
    $this->_retvalue = array('operation' => 'if', 'expr' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);
    }
#line 1742 "lib/Haanga/Compiler/Parser.php"
#line 215 "lib/Haanga/Compiler/Parser.y"
    function yy_r34(){
    if ($this->yystack[$this->yyidx + -1]->minor != "endif") {
        $this->Error("Unexpected ".$this->yystack[$this->yyidx + -1]->minor.", expecting endif");
    }
    $this->_retvalue = array('operation' => 'if', 'expr' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);
    }
#line 1750 "lib/Haanga/Compiler/Parser.php"
#line 223 "lib/Haanga/Compiler/Parser.y"
    function yy_r35(){ 
    if ($this->yystack[$this->yyidx + -1]->minor != "endifchanged") {
        $this->Error("Unexpected ".$this->yystack[$this->yyidx + -1]->minor.", expecting endifchanged");
    }
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1758 "lib/Haanga/Compiler/Parser.php"
#line 230 "lib/Haanga/Compiler/Parser.y"
    function yy_r36(){ 
    if ($this->yystack[$this->yyidx + -1]->minor != "endifchanged") {
        $this->Error("Unexpected ".$this->yystack[$this->yyidx + -1]->minor.", expecting endifchanged");
    }
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -3]->minor, 'check' => $this->yystack[$this->yyidx + -5]->minor);
    }
#line 1766 "lib/Haanga/Compiler/Parser.php"
#line 236 "lib/Haanga/Compiler/Parser.y"
    function yy_r37(){ 
    if ($this->yystack[$this->yyidx + -1]->minor != "endifchanged") {
        $this->Error("Unexpected ".$this->yystack[$this->yyidx + -1]->minor.", expecting endifchanged");
    }
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1774 "lib/Haanga/Compiler/Parser.php"
#line 243 "lib/Haanga/Compiler/Parser.y"
    function yy_r38(){ 
    if ($this->yystack[$this->yyidx + -1]->minor != "endifchanged") {
        $this->Error("Unexpected ".$this->yystack[$this->yyidx + -1]->minor.", expecting endifchanged");
    }
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -7]->minor, 'check' => $this->yystack[$this->yyidx + -9]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);
    }
#line 1782 "lib/Haanga/Compiler/Parser.php"
#line 251 "lib/Haanga/Compiler/Parser.y"
    function yy_r39(){
    if ($this->yystack[$this->yyidx + -1]->minor != "endifequal") {
        $this->Error("Unexpected ".$this->yystack[$this->yyidx + -1]->minor.", expecting endifequal");
    }
    $this->_retvalue = array('operation' => 'ifequal', 'cmp' => '==', 1 => $this->yystack[$this->yyidx + -6]->minor, 2 => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1790 "lib/Haanga/Compiler/Parser.php"
#line 257 "lib/Haanga/Compiler/Parser.y"
    function yy_r40(){
    if ($this->yystack[$this->yyidx + -1]->minor != "endifequal") {
        $this->Error("Unexpected ".$this->yystack[$this->yyidx + -1]->minor.", expecting endifequal");
    }
    $this->_retvalue = array('operation' => 'ifequal', 'cmp' => '==', 1 => $this->yystack[$this->yyidx + -10]->minor, 2 => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1798 "lib/Haanga/Compiler/Parser.php"
#line 263 "lib/Haanga/Compiler/Parser.y"
    function yy_r41(){
    if ($this->yystack[$this->yyidx + -1]->minor != "endifnotequal") {
        $this->Error("Unexpected ".$this->yystack[$this->yyidx + -1]->minor.", expecting endifnotequal");
    }
    $this->_retvalue = array('operation' => 'ifequal', 'cmp' => '!=', 1 => $this->yystack[$this->yyidx + -6]->minor, 2 => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);
    }
#line 1806 "lib/Haanga/Compiler/Parser.php"
#line 269 "lib/Haanga/Compiler/Parser.y"
    function yy_r42(){
    if ($this->yystack[$this->yyidx + -1]->minor != "endifnotequal") {
        $this->Error("Unexpected ".$this->yystack[$this->yyidx + -1]->minor.", expecting endifnotequal");
    }
    $this->_retvalue = array('operation' => 'ifequal', 'cmp' => '!=', 1 => $this->yystack[$this->yyidx + -10]->minor, 2 => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1814 "lib/Haanga/Compiler/Parser.php"
#line 277 "lib/Haanga/Compiler/Parser.y"
    function yy_r43(){ 
    if ($this->yystack[$this->yyidx + -1]->minor != "endblock") {
        $this->Error("Unexpected ".$this->yystack[$this->yyidx + -1]->minor.", expecting endblock");
    }
    $this->_retvalue = array('operation' => 'block', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1822 "lib/Haanga/Compiler/Parser.php"
#line 284 "lib/Haanga/Compiler/Parser.y"
    function yy_r44(){
    if ($this->yystack[$this->yyidx + -2]->minor != "endblock") {
        $this->Error("Unexpected ".$this->yystack[$this->yyidx + -2]->minor.", expecting endblock");
    }
    $this->_retvalue = array('operation' => 'block', 'name' => $this->yystack[$this->yyidx + -6]->minor, 'body' => $this->yystack[$this->yyidx + -4]->minor); 
    }
#line 1830 "lib/Haanga/Compiler/Parser.php"
#line 291 "lib/Haanga/Compiler/Parser.y"
    function yy_r45(){
    if ($this->yystack[$this->yyidx + -1]->minor != "endblock") {
        $this->Error("Unexpected ".$this->yystack[$this->yyidx + -1]->minor.", expecting endblock");
    }
    $this->_retvalue = array('operation' => 'block', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1838 "lib/Haanga/Compiler/Parser.php"
#line 306 "lib/Haanga/Compiler/Parser.y"
    function yy_r47(){
    if ($this->yystack[$this->yyidx + -1]->minor != "endfilter") {
        $this->Error("Unexpected ".$this->yystack[$this->yyidx + -1]->minor.", expecting endfilter");
    }
    $this->_retvalue = array('operation' => 'filter', 'functions' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);
    }
#line 1846 "lib/Haanga/Compiler/Parser.php"
#line 314 "lib/Haanga/Compiler/Parser.y"
    function yy_r48(){ $this->_retvalue=array('operation' => 'regroup', 'array' => $this->yystack[$this->yyidx + -4]->minor, 'row' => $this->yystack[$this->yyidx + -2]->minor, 'as' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1849 "lib/Haanga/Compiler/Parser.php"
#line 317 "lib/Haanga/Compiler/Parser.y"
    function yy_r49(){ $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1852 "lib/Haanga/Compiler/Parser.php"
#line 318 "lib/Haanga/Compiler/Parser.y"
    function yy_r50(){ $this->_retvalue = array($this->yystack[$this->yyidx + 0]->minor);     }
#line 1855 "lib/Haanga/Compiler/Parser.php"
#line 320 "lib/Haanga/Compiler/Parser.y"
    function yy_r51(){ $this->_retvalue = array($this->yystack[$this->yyidx + -2]->minor, 'args'=>array($this->yystack[$this->yyidx + 0]->minor));     }
#line 1858 "lib/Haanga/Compiler/Parser.php"
#line 324 "lib/Haanga/Compiler/Parser.y"
    function yy_r53(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1861 "lib/Haanga/Compiler/Parser.php"
#line 330 "lib/Haanga/Compiler/Parser.y"
    function yy_r56(){ $this->_retvalue = array('var' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1864 "lib/Haanga/Compiler/Parser.php"
#line 331 "lib/Haanga/Compiler/Parser.y"
    function yy_r57(){ $this->_retvalue = array('number' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1867 "lib/Haanga/Compiler/Parser.php"
#line 332 "lib/Haanga/Compiler/Parser.y"
    function yy_r58(){ $this->_retvalue = trim(@$this->yystack[$this->yyidx + 0]->minor);     }
#line 1870 "lib/Haanga/Compiler/Parser.php"
#line 333 "lib/Haanga/Compiler/Parser.y"
    function yy_r59(){ $this->_retvalue = array('string' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1873 "lib/Haanga/Compiler/Parser.php"
#line 336 "lib/Haanga/Compiler/Parser.y"
    function yy_r60(){ $this->_retvalue = array('var_filter' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1876 "lib/Haanga/Compiler/Parser.php"
#line 344 "lib/Haanga/Compiler/Parser.y"
    function yy_r66(){  $this->_retvalue = "";     }
#line 1879 "lib/Haanga/Compiler/Parser.php"
#line 346 "lib/Haanga/Compiler/Parser.y"
    function yy_r68(){  $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1882 "lib/Haanga/Compiler/Parser.php"
#line 348 "lib/Haanga/Compiler/Parser.y"
    function yy_r70(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor.$this->yystack[$this->yyidx + 0]->minor;     }
#line 1885 "lib/Haanga/Compiler/Parser.php"
#line 352 "lib/Haanga/Compiler/Parser.y"
    function yy_r72(){ $this->_retvalue = array('op_expr' => 'not', $this->yystack[$this->yyidx + 0]->minor);     }
#line 1888 "lib/Haanga/Compiler/Parser.php"
#line 353 "lib/Haanga/Compiler/Parser.y"
    function yy_r73(){ $this->_retvalue = array('op_expr' => @$this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1891 "lib/Haanga/Compiler/Parser.php"
#line 356 "lib/Haanga/Compiler/Parser.y"
    function yy_r76(){ $this->_retvalue = array('op_expr' => trim(@$this->yystack[$this->yyidx + -1]->minor), $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1894 "lib/Haanga/Compiler/Parser.php"
#line 358 "lib/Haanga/Compiler/Parser.y"
    function yy_r78(){ $this->_retvalue = array('op_expr' => 'expr', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1897 "lib/Haanga/Compiler/Parser.php"
#line 362 "lib/Haanga/Compiler/Parser.y"
    function yy_r80(){ if (!is_array($this->yystack[$this->yyidx + -2]->minor)) { $this->_retvalue = array($this->yystack[$this->yyidx + -2]->minor); } else { $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; }  $this->_retvalue[]=array('object' => $this->yystack[$this->yyidx + 0]->minor);    }
#line 1900 "lib/Haanga/Compiler/Parser.php"
#line 363 "lib/Haanga/Compiler/Parser.y"
    function yy_r81(){ if (!is_array($this->yystack[$this->yyidx + -2]->minor)) { $this->_retvalue = array($this->yystack[$this->yyidx + -2]->minor); } else { $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; } $this->_retvalue[] = ($this->compiler->var_is_object($this->_retvalue)) ? array('object' => $this->yystack[$this->yyidx + 0]->minor) : $this->yystack[$this->yyidx + 0]->minor;    }
#line 1903 "lib/Haanga/Compiler/Parser.php"
#line 364 "lib/Haanga/Compiler/Parser.y"
    function yy_r82(){ if (!is_array($this->yystack[$this->yyidx + -3]->minor)) { $this->_retvalue = array($this->yystack[$this->yyidx + -3]->minor); } else { $this->_retvalue = $this->yystack[$this->yyidx + -3]->minor; }  $this->_retvalue[]=$this->yystack[$this->yyidx + -1]->minor;    }
#line 1906 "lib/Haanga/Compiler/Parser.php"

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
#line 70 "lib/Haanga/Compiler/Parser.y"

    $expect = array();
    foreach ($this->yy_get_expected_tokens($yymajor) as $token) {
        $expect[] = self::$yyTokenName[$token];
    }
    $this->Error('Unexpected ' . $this->tokenName($yymajor) . '(' . $TOKEN. '), expected one of: ' . implode(',', $expect));
#line 2026 "lib/Haanga/Compiler/Parser.php"
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
#line 57 "lib/Haanga/Compiler/Parser.y"

#line 2047 "lib/Haanga/Compiler/Parser.php"
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