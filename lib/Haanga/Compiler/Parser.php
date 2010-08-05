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
  | Copyright (c) 2010 Haanga                                                       |
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


#line 149 "lib/Haanga/Compiler/Parser.php"

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
    const T_OFF                          = 26;
    const T_ON                           = 27;
    const T_END_AUTOESCAPE               = 28;
    const T_CUSTOM_TAG                   = 29;
    const T_AS                           = 30;
    const T_CUSTOM_BLOCK                 = 31;
    const T_CUSTOM_END                   = 32;
    const T_WITH                         = 33;
    const T_ENDWITH                      = 34;
    const T_LOAD                         = 35;
    const T_FOR                          = 36;
    const T_COMMA                        = 37;
    const T_CLOSEFOR                     = 38;
    const T_EMPTY                        = 39;
    const T_IF                           = 40;
    const T_ENDIF                        = 41;
    const T_ELSE                         = 42;
    const T_IFCHANGED                    = 43;
    const T_ENDIFCHANGED                 = 44;
    const T_IFEQUAL                      = 45;
    const T_END_IFEQUAL                  = 46;
    const T_IFNOTEQUAL                   = 47;
    const T_END_IFNOTEQUAL               = 48;
    const T_BLOCK                        = 49;
    const T_END_BLOCK                    = 50;
    const T_NUMERIC                      = 51;
    const T_FILTER                       = 52;
    const T_END_FILTER                   = 53;
    const T_REGROUP                      = 54;
    const T_BY                           = 55;
    const T_PIPE                         = 56;
    const T_COLON                        = 57;
    const T_INTL                         = 58;
    const T_RPARENT                      = 59;
    const T_STRING_SINGLE_INIT           = 60;
    const T_STRING_SINGLE_END            = 61;
    const T_STRING_DOUBLE_INIT           = 62;
    const T_STRING_DOUBLE_END            = 63;
    const T_STRING_CONTENT               = 64;
    const T_LPARENT                      = 65;
    const T_OBJ                          = 66;
    const T_ALPHA                        = 67;
    const T_DOT                          = 68;
    const T_BRACKETS_OPEN                = 69;
    const T_BRACKETS_CLOSE               = 70;
    const YY_NO_ACTION = 314;
    const YY_ACCEPT_ACTION = 313;
    const YY_ERROR_ACTION = 312;

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
    const YY_SZ_ACTTAB = 972;
static public $yy_action = array(
 /*     0 */    38,  124,   36,  120,  186,  191,  193,   32,  193,  162,
 /*    10 */   168,   72,  106,   70,   69,   22,   22,   22,   23,  198,
 /*    20 */   129,   33,  209,   29,   63,   30,  135,   61,  130,  227,
 /*    30 */    44,   74,   45,   78,   38,   79,   36,  120,  134,  115,
 /*    40 */    35,   32,  177,  162,  188,   72,   94,   70,   69,  220,
 /*    50 */   213,  179,   23,  151,  141,   33,  193,   29,  193,   30,
 /*    60 */    38,   61,   36,  120,   44,  205,   45,   32,  196,  162,
 /*    70 */   193,   72,  193,   70,   69,  313,   54,   96,   23,  226,
 /*    80 */   137,   33,  138,   29,   46,   30,   38,   61,   36,  120,
 /*    90 */    44,  106,   45,   32,  188,  162,  201,   72,  202,   70,
 /*   100 */    69,   46,  147,  142,   23,  187,  122,   33,  188,   29,
 /*   110 */    46,   30,   38,   61,   36,  120,   44,  106,   45,   32,
 /*   120 */    97,  162,  224,   72,  198,   70,   69,   88,  185,   46,
 /*   130 */    23,  191,  128,   33,  165,   29,  127,   30,   38,   61,
 /*   140 */    36,  120,   44,  184,   45,   32,  175,  162,  163,   72,
 /*   150 */    46,   70,   69,  152,  152,   39,   23,   89,  154,   33,
 /*   160 */   159,   29,  119,   30,  156,   61,  161,   37,   44,  203,
 /*   170 */    45,  118,   38,  106,   36,  120,  125,  197,  145,   32,
 /*   180 */   198,  162,  106,   72,  194,   70,   69,  106,   47,  198,
 /*   190 */    23,   73,   46,   33,  198,   29,   90,   30,   38,   61,
 /*   200 */    36,  120,   44,   81,   45,   32,  189,  162,  178,   72,
 /*   210 */   167,   70,   69,  230,  207,   84,   23,  160,  206,   33,
 /*   220 */   208,   29,  218,   30,   38,   61,   36,  120,   44,  192,
 /*   230 */    45,   32,   87,  162,   91,   72,   83,   70,   69,  211,
 /*   240 */   228,  156,   23,  161,   37,   33,  195,   29,  210,   30,
 /*   250 */   115,   61,  123,  177,   44,   80,   45,  105,   38,  164,
 /*   260 */    36,  120,  190,  175,  109,   32,   59,  162,  183,   72,
 /*   270 */   204,   70,   69,   65,  144,  108,   23,   27,   62,   33,
 /*   280 */    58,   29,  178,   30,   38,   61,   36,  120,   44,  117,
 /*   290 */    45,   32,   55,  162,   64,   72,  178,   70,   69,  112,
 /*   300 */   146,  116,   23,  121,  193,   33,  193,   29,   57,   30,
 /*   310 */   200,   61,   51,  111,   44,  113,   45,  104,   38,   66,
 /*   320 */    36,  120,   56,   60,  107,   32,  173,  162,  143,   72,
 /*   330 */    50,   70,   69,   74,   48,   78,   23,   79,  110,   33,
 /*   340 */    21,   29,  188,   30,   38,   61,   36,  120,   44,   67,
 /*   350 */    45,   32,   49,  162,   53,   72,  178,   70,   69,   52,
 /*   360 */   178,  178,   23,  178,  178,   33,  153,   29,  178,   30,
 /*   370 */    38,   61,   36,  120,   44,  178,   45,   32,  178,  162,
 /*   380 */   178,   72,  178,   70,   69,  178,  178,  178,   23,  178,
 /*   390 */   178,   33,  140,   29,  178,   30,   38,   61,   36,  120,
 /*   400 */    44,  178,   45,   32,  178,  162,  178,   72,  178,   70,
 /*   410 */    69,  178,  178,  178,   23,  178,  178,   33,  178,   29,
 /*   420 */   178,   30,   38,   61,   36,  120,   44,  133,   45,   32,
 /*   430 */   178,  162,  178,   72,  178,   70,   69,  178,  178,  178,
 /*   440 */    23,  178,  178,   33,  178,   29,  178,   30,  131,   61,
 /*   450 */   178,  178,   44,  178,   45,  178,   38,  178,   36,  120,
 /*   460 */   178,  178,  178,   32,  178,  162,  178,   72,  178,   70,
 /*   470 */    69,  178,  178,  178,   23,   42,  178,   33,  178,   29,
 /*   480 */   126,   30,   38,   61,   36,  120,   44,  178,   45,   32,
 /*   490 */   178,  162,  178,   72,  158,   70,   69,  178,  178,  178,
 /*   500 */    23,   71,  178,   33,  178,   29,  178,   30,  178,   61,
 /*   510 */   178,  178,   44,  178,   45,  178,   24,   26,   25,   25,
 /*   520 */    25,   25,   25,   25,   25,   20,   20,   22,   22,   22,
 /*   530 */   156,  178,  161,   37,  178,  178,   86,  178,  178,  178,
 /*   540 */    24,   26,   25,   25,   25,   25,   25,   25,   25,   20,
 /*   550 */    20,   22,   22,   22,  178,  178,  193,  178,  193,  178,
 /*   560 */   178,  178,  178,   38,  178,   36,  120,  178,  178,  227,
 /*   570 */    32,  178,  162,  178,   72,  178,   70,   69,  173,  115,
 /*   580 */    34,   23,  177,  178,   33,   74,   29,   78,   30,   79,
 /*   590 */    61,  178,  178,   44,  188,   45,  182,   24,   26,   25,
 /*   600 */    25,   25,   25,   25,   25,   25,   20,   20,   22,   22,
 /*   610 */    22,   26,   25,   25,   25,   25,   25,   25,   25,   20,
 /*   620 */    20,   22,   22,   22,  214,  178,  178,  148,  166,  174,
 /*   630 */   171,  170,  169,  231,  219,  221,  178,  178,  212,  178,
 /*   640 */    82,   25,   25,   25,   25,   25,   25,   25,   20,   20,
 /*   650 */    22,   22,   22,  222,    9,  178,  215,  178,  178,  193,
 /*   660 */    75,  193,  193,   76,  193,  139,   85,   40,  178,  178,
 /*   670 */   217,  132,  193,   41,  193,   95,  106,  178,  178,  172,
 /*   680 */    40,  176,  157,  198,  176,  178,  178,  178,   74,  178,
 /*   690 */    78,   74,   79,   78,  176,   79,   92,  188,  178,  155,
 /*   700 */   188,   74,  193,   78,  193,   79,  178,  178,  178,  115,
 /*   710 */   188,  139,  177,  178,  193,  178,  193,  225,  156,  178,
 /*   720 */   161,   37,  106,  178,  176,  172,  178,  101,  181,  198,
 /*   730 */   178,   74,  178,   78,  178,   79,  176,  139,  178,  178,
 /*   740 */   188,  178,   16,   74,  178,   78,  178,   79,  106,  178,
 /*   750 */     3,  172,  188,  102,  181,  198,  178,  139,  217,  132,
 /*   760 */   156,   41,  161,   37,  178,  139,  217,  132,  106,   41,
 /*   770 */   178,  172,  178,   98,  181,  198,  106,  139,  178,  172,
 /*   780 */   178,  114,  181,  198,  178,  178,  178,  139,  106,  178,
 /*   790 */    10,  172,  178,  103,  181,  198,  178,  178,  106,  139,
 /*   800 */   178,  172,  178,  100,  181,  198,  217,  132,  139,   41,
 /*   810 */   106,  178,  178,  172,  178,   99,  181,  198,  178,  106,
 /*   820 */   139,  178,  172,  178,  180,  181,  198,  178,  139,  178,
 /*   830 */   139,  106,  178,    6,  172,   68,  178,   28,  198,  106,
 /*   840 */    19,  106,  172,  178,  172,  136,  198,   31,  198,  217,
 /*   850 */   132,   17,   41,  229,  223,  178,  217,  132,  216,   41,
 /*   860 */   178,    5,  178,  115,  178,  178,  177,  217,  132,   13,
 /*   870 */    41,  156,  178,  161,   37,   11,   77,  217,  132,   12,
 /*   880 */    41,  178,  178,  178,  178,  217,  132,   43,   41,  178,
 /*   890 */     2,  217,  132,   93,   41,  217,  132,  156,   41,  161,
 /*   900 */    37,  156,    1,  161,   37,  178,  217,  132,   15,   41,
 /*   910 */   178,  178,  156,  150,  161,   37,    4,  178,  217,  132,
 /*   920 */   178,   41,  178,  115,  217,  132,  177,   41,  178,  178,
 /*   930 */   178,  178,  217,  132,    8,   41,  156,  178,  161,   37,
 /*   940 */    18,  178,  156,  178,  161,   37,   14,  178,  149,  178,
 /*   950 */   217,  132,    7,   41,  199,  178,  217,  132,  115,   41,
 /*   960 */   178,  177,  217,  132,  115,   41,  178,  177,  217,  132,
 /*   970 */   178,   41,
    );
    static public $yy_lookahead = array(
 /*     0 */    22,   76,   24,   25,   63,   64,   29,   29,   31,   31,
 /*    10 */    23,   33,   87,   35,   36,   14,   15,   16,   40,   94,
 /*    20 */    42,   43,   23,   45,   73,   47,   48,   49,   51,   77,
 /*    30 */    52,   58,   54,   60,   22,   62,   24,   25,   51,   87,
 /*    40 */    88,   29,   90,   31,   67,   33,   23,   35,   36,   21,
 /*    50 */    23,   67,   40,   41,   42,   43,   29,   45,   31,   47,
 /*    60 */    22,   49,   24,   25,   52,   23,   54,   29,   23,   31,
 /*    70 */    29,   33,   31,   35,   36,   72,   73,   23,   40,   23,
 /*    80 */    42,   43,   44,   45,   56,   47,   22,   49,   24,   25,
 /*    90 */    52,   87,   54,   29,   67,   31,   23,   33,   94,   35,
 /*   100 */    36,   56,   38,   39,   40,   70,   76,   43,   67,   45,
 /*   110 */    56,   47,   22,   49,   24,   25,   52,   87,   54,   29,
 /*   120 */    23,   31,   23,   33,   94,   35,   36,   23,   61,   56,
 /*   130 */    40,   64,   42,   43,   23,   45,   46,   47,   22,   49,
 /*   140 */    24,   25,   52,   61,   54,   29,   64,   31,   23,   33,
 /*   150 */    56,   35,   36,   26,   27,   57,   40,   23,   42,   43,
 /*   160 */    44,   45,   76,   47,   66,   49,   68,   69,   52,   23,
 /*   170 */    54,   76,   22,   87,   24,   25,   76,   23,   28,   29,
 /*   180 */    94,   31,   87,   33,   23,   35,   36,   87,   73,   94,
 /*   190 */    40,   55,   56,   43,   94,   45,   23,   47,   22,   49,
 /*   200 */    24,   25,   52,   23,   54,   29,   23,   31,   59,   33,
 /*   210 */    23,   35,   36,   23,   23,   23,   40,   41,   23,   43,
 /*   220 */    23,   45,   19,   47,   22,   49,   24,   25,   52,   23,
 /*   230 */    54,   29,   23,   31,   23,   33,   23,   35,   36,   23,
 /*   240 */    77,   66,   40,   68,   69,   43,   23,   45,   23,   47,
 /*   250 */    87,   49,   50,   90,   52,   23,   54,   87,   22,   74,
 /*   260 */    24,   25,   63,   64,   87,   29,   73,   31,   67,   33,
 /*   270 */    23,   35,   36,   73,   38,   87,   40,    2,   73,   43,
 /*   280 */    73,   45,   96,   47,   22,   49,   24,   25,   52,   95,
 /*   290 */    54,   29,   73,   31,   73,   33,   96,   35,   36,   87,
 /*   300 */    90,   87,   40,   95,   29,   43,   31,   45,   73,   47,
 /*   310 */    90,   49,   50,   87,   52,   87,   54,   87,   22,   73,
 /*   320 */    24,   25,   73,   73,   87,   29,   51,   31,   32,   33,
 /*   330 */    73,   35,   36,   58,   73,   60,   40,   62,   87,   43,
 /*   340 */    65,   45,   67,   47,   22,   49,   24,   25,   52,   73,
 /*   350 */    54,   29,   73,   31,   73,   33,   96,   35,   36,   73,
 /*   360 */    96,   96,   40,   96,   96,   43,   44,   45,   96,   47,
 /*   370 */    22,   49,   24,   25,   52,   96,   54,   29,   96,   31,
 /*   380 */    96,   33,   96,   35,   36,   96,   96,   96,   40,   96,
 /*   390 */    96,   43,   44,   45,   96,   47,   22,   49,   24,   25,
 /*   400 */    52,   96,   54,   29,   96,   31,   96,   33,   96,   35,
 /*   410 */    36,   96,   96,   96,   40,   96,   96,   43,   96,   45,
 /*   420 */    96,   47,   22,   49,   24,   25,   52,   53,   54,   29,
 /*   430 */    96,   31,   96,   33,   96,   35,   36,   96,   96,   96,
 /*   440 */    40,   96,   96,   43,   96,   45,   96,   47,   48,   49,
 /*   450 */    96,   96,   52,   96,   54,   96,   22,   96,   24,   25,
 /*   460 */    96,   96,   96,   29,   96,   31,   96,   33,   96,   35,
 /*   470 */    36,   96,   96,   96,   40,   11,   96,   43,   96,   45,
 /*   480 */    46,   47,   22,   49,   24,   25,   52,   96,   54,   29,
 /*   490 */    96,   31,   96,   33,   34,   35,   36,   96,   96,   96,
 /*   500 */    40,   37,   96,   43,   96,   45,   96,   47,   96,   49,
 /*   510 */    96,   96,   52,   96,   54,   96,    3,    4,    5,    6,
 /*   520 */     7,    8,    9,   10,   11,   12,   13,   14,   15,   16,
 /*   530 */    66,   96,   68,   69,   96,   96,   23,   96,   96,   96,
 /*   540 */     3,    4,    5,    6,    7,    8,    9,   10,   11,   12,
 /*   550 */    13,   14,   15,   16,   96,   96,   29,   96,   31,   96,
 /*   560 */    96,   96,   96,   22,   96,   24,   25,   96,   96,   77,
 /*   570 */    29,   96,   31,   96,   33,   96,   35,   36,   51,   87,
 /*   580 */    88,   40,   90,   96,   43,   58,   45,   60,   47,   62,
 /*   590 */    49,   96,   96,   52,   67,   54,   59,    3,    4,    5,
 /*   600 */     6,    7,    8,    9,   10,   11,   12,   13,   14,   15,
 /*   610 */    16,    4,    5,    6,    7,    8,    9,   10,   11,   12,
 /*   620 */    13,   14,   15,   16,   75,   96,   96,   78,   79,   80,
 /*   630 */    81,   82,   83,   84,   85,   86,   96,   96,   89,   96,
 /*   640 */    91,    5,    6,    7,    8,    9,   10,   11,   12,   13,
 /*   650 */    14,   15,   16,   23,    1,   96,   23,   96,   96,   29,
 /*   660 */    30,   31,   29,   30,   31,   76,   23,   37,   96,   96,
 /*   670 */    17,   18,   29,   20,   31,   23,   87,   96,   96,   90,
 /*   680 */    37,   51,   93,   94,   51,   96,   96,   96,   58,   96,
 /*   690 */    60,   58,   62,   60,   51,   62,   23,   67,   96,   77,
 /*   700 */    67,   58,   29,   60,   31,   62,   96,   96,   96,   87,
 /*   710 */    67,   76,   90,   96,   29,   96,   31,   23,   66,   96,
 /*   720 */    68,   69,   87,   96,   51,   90,   96,   92,   93,   94,
 /*   730 */    96,   58,   96,   60,   96,   62,   51,   76,   96,   96,
 /*   740 */    67,   96,    1,   58,   96,   60,   96,   62,   87,   96,
 /*   750 */     1,   90,   67,   92,   93,   94,   96,   76,   17,   18,
 /*   760 */    66,   20,   68,   69,   96,   76,   17,   18,   87,   20,
 /*   770 */    96,   90,   96,   92,   93,   94,   87,   76,   96,   90,
 /*   780 */    96,   92,   93,   94,   96,   96,   96,   76,   87,   96,
 /*   790 */     1,   90,   96,   92,   93,   94,   96,   96,   87,   76,
 /*   800 */    96,   90,   96,   92,   93,   94,   17,   18,   76,   20,
 /*   810 */    87,   96,   96,   90,   96,   92,   93,   94,   96,   87,
 /*   820 */    76,   96,   90,   96,   92,   93,   94,   96,   76,   96,
 /*   830 */    76,   87,   96,    1,   90,   30,   96,   93,   94,   87,
 /*   840 */     1,   87,   90,   96,   90,   93,   94,   93,   94,   17,
 /*   850 */    18,    1,   20,   77,   23,   96,   17,   18,   23,   20,
 /*   860 */    96,    1,   96,   87,   96,   96,   90,   17,   18,    1,
 /*   870 */    20,   66,   96,   68,   69,    1,   30,   17,   18,    1,
 /*   880 */    20,   96,   96,   96,   96,   17,   18,   11,   20,   96,
 /*   890 */     1,   17,   18,   23,   20,   17,   18,   66,   20,   68,
 /*   900 */    69,   66,    1,   68,   69,   96,   17,   18,    1,   20,
 /*   910 */    96,   96,   66,   77,   68,   69,    1,   96,   17,   18,
 /*   920 */    96,   20,   96,   87,   17,   18,   90,   20,   96,   96,
 /*   930 */    96,   96,   17,   18,    1,   20,   66,   96,   68,   69,
 /*   940 */     1,   96,   66,   96,   68,   69,    1,   96,   77,   96,
 /*   950 */    17,   18,    1,   20,   77,   96,   17,   18,   87,   20,
 /*   960 */    96,   90,   17,   18,   87,   20,   96,   90,   17,   18,
 /*   970 */    96,   20,
);
    const YY_SHIFT_USE_DFLT = -60;
    const YY_SHIFT_MAX = 162;
    static public $yy_shift_ofst = array(
 /*     0 */   -60,  116,   90,  -22,   38,   64,   12,  460,  374,  176,
 /*    10 */   236,  202,  150,  400,  262,  434,  348,  322,  296,  541,
 /*    20 */   275,  275,  275,  275,  275,  275,  275,  275,  527,  527,
 /*    30 */   527,  527,  633,  673,  630,  643,  685,  685,  685,  685,
 /*    40 */   685,   41,   41,   41,   41,   41,   41,  933,  951,  945,
 /*    50 */   939,   27,  789,  749,  839,  832,  741,  653,  850,  907,
 /*    60 */   901,  -23,  915,  889,  860,  868,  874,  878,   41,   41,
 /*    70 */   -27,   41,   41,   41,  -27,   41,   41,   41,   82,  199,
 /*    80 */   -60,  -60,  -60,  -60,  -60,  -60,  -60,  -60,  -60,  -60,
 /*    90 */   -60,  -60,  -60,  -60,  -60,  -60,  -60,  -60,  537,  513,
 /*   100 */   594,  607,  636,  636,  464,  876,   98,  652,  870,  846,
 /*   110 */   694,  835,  805,  831,    1,  175,  175,   67,   73,  136,
 /*   120 */   127,  -59,   54,  -13,   45,   28,  197,  191,  192,  213,
 /*   130 */   232,  223,  203,  190,  187,  146,  134,  104,  111,   94,
 /*   140 */   183,  180,  173,   99,  247,  161,  149,  154,  125,   35,
 /*   150 */   216,  225,  211,  195,  209,  206,  201,   97,   56,   42,
 /*   160 */    -1,  -16,   23,
);
    const YY_REDUCE_USE_DFLT = -76;
    const YY_REDUCE_MAX = 97;
    static public $yy_reduce_ofst = array(
 /*     0 */     3,  549,  549,  549,  549,  549,  549,  549,  549,  549,
 /*    10 */   549,  549,  549,  549,  549,  549,  549,  549,  549,  549,
 /*    20 */   689,  681,  732,  723,  635,  661,  701,  711,  752,  754,
 /*    30 */   744,  589,  492,  -48,  776,  776,  622,  871,  836,  877,
 /*    40 */   163,  100,   95,  -75,   30,   86,    4,  185,  185,  185,
 /*    50 */   185,  251,  185,  185,  185,  185,  185,  185,  185,  185,
 /*    60 */   185,  237,  185,  185,  185,  185,  185,  185,  188,  230,
 /*    70 */   220,  170,  212,  177,  210,  228,  226,  214,  194,  208,
 /*    80 */   246,  235,  221,  200,  193,  205,  219,  207,  249,  281,
 /*    90 */   286,  276,  250,  261,  257,  279,  115,  -49,
);
    static public $yyExpectedTokens = array(
        /* 0 */ array(),
        /* 1 */ array(22, 24, 25, 29, 31, 33, 35, 36, 40, 42, 43, 44, 45, 47, 49, 52, 54, ),
        /* 2 */ array(22, 24, 25, 29, 31, 33, 35, 36, 40, 42, 43, 45, 46, 47, 49, 52, 54, ),
        /* 3 */ array(22, 24, 25, 29, 31, 33, 35, 36, 40, 42, 43, 45, 47, 48, 49, 52, 54, ),
        /* 4 */ array(22, 24, 25, 29, 31, 33, 35, 36, 40, 42, 43, 44, 45, 47, 49, 52, 54, ),
        /* 5 */ array(22, 24, 25, 29, 31, 33, 35, 36, 38, 39, 40, 43, 45, 47, 49, 52, 54, ),
        /* 6 */ array(22, 24, 25, 29, 31, 33, 35, 36, 40, 41, 42, 43, 45, 47, 49, 52, 54, ),
        /* 7 */ array(22, 24, 25, 29, 31, 33, 34, 35, 36, 40, 43, 45, 47, 49, 52, 54, ),
        /* 8 */ array(22, 24, 25, 29, 31, 33, 35, 36, 40, 43, 45, 47, 49, 52, 53, 54, ),
        /* 9 */ array(22, 24, 25, 29, 31, 33, 35, 36, 40, 41, 43, 45, 47, 49, 52, 54, ),
        /* 10 */ array(22, 24, 25, 29, 31, 33, 35, 36, 38, 40, 43, 45, 47, 49, 52, 54, ),
        /* 11 */ array(22, 24, 25, 29, 31, 33, 35, 36, 40, 43, 45, 47, 49, 50, 52, 54, ),
        /* 12 */ array(22, 24, 25, 28, 29, 31, 33, 35, 36, 40, 43, 45, 47, 49, 52, 54, ),
        /* 13 */ array(22, 24, 25, 29, 31, 33, 35, 36, 40, 43, 45, 47, 48, 49, 52, 54, ),
        /* 14 */ array(22, 24, 25, 29, 31, 33, 35, 36, 40, 43, 45, 47, 49, 50, 52, 54, ),
        /* 15 */ array(22, 24, 25, 29, 31, 33, 35, 36, 40, 43, 45, 46, 47, 49, 52, 54, ),
        /* 16 */ array(22, 24, 25, 29, 31, 33, 35, 36, 40, 43, 44, 45, 47, 49, 52, 54, ),
        /* 17 */ array(22, 24, 25, 29, 31, 33, 35, 36, 40, 43, 44, 45, 47, 49, 52, 54, ),
        /* 18 */ array(22, 24, 25, 29, 31, 32, 33, 35, 36, 40, 43, 45, 47, 49, 52, 54, ),
        /* 19 */ array(22, 24, 25, 29, 31, 33, 35, 36, 40, 43, 45, 47, 49, 52, 54, ),
        /* 20 */ array(2, 29, 31, 51, 58, 60, 62, 65, 67, ),
        /* 21 */ array(2, 29, 31, 51, 58, 60, 62, 65, 67, ),
        /* 22 */ array(2, 29, 31, 51, 58, 60, 62, 65, 67, ),
        /* 23 */ array(2, 29, 31, 51, 58, 60, 62, 65, 67, ),
        /* 24 */ array(2, 29, 31, 51, 58, 60, 62, 65, 67, ),
        /* 25 */ array(2, 29, 31, 51, 58, 60, 62, 65, 67, ),
        /* 26 */ array(2, 29, 31, 51, 58, 60, 62, 65, 67, ),
        /* 27 */ array(2, 29, 31, 51, 58, 60, 62, 65, 67, ),
        /* 28 */ array(29, 31, 51, 58, 60, 62, 67, ),
        /* 29 */ array(29, 31, 51, 58, 60, 62, 67, ),
        /* 30 */ array(29, 31, 51, 58, 60, 62, 67, ),
        /* 31 */ array(29, 31, 51, 58, 60, 62, 67, ),
        /* 32 */ array(23, 29, 30, 31, 51, 58, 60, 62, 67, ),
        /* 33 */ array(23, 29, 31, 51, 58, 60, 62, 67, ),
        /* 34 */ array(23, 29, 30, 31, 37, 51, 58, 60, 62, 67, ),
        /* 35 */ array(23, 29, 31, 37, 51, 58, 60, 62, 67, ),
        /* 36 */ array(29, 31, 51, 58, 60, 62, 67, ),
        /* 37 */ array(29, 31, 51, 58, 60, 62, 67, ),
        /* 38 */ array(29, 31, 51, 58, 60, 62, 67, ),
        /* 39 */ array(29, 31, 51, 58, 60, 62, 67, ),
        /* 40 */ array(29, 31, 51, 58, 60, 62, 67, ),
        /* 41 */ array(29, 31, 67, ),
        /* 42 */ array(29, 31, 67, ),
        /* 43 */ array(29, 31, 67, ),
        /* 44 */ array(29, 31, 67, ),
        /* 45 */ array(29, 31, 67, ),
        /* 46 */ array(29, 31, 67, ),
        /* 47 */ array(1, 17, 18, 20, ),
        /* 48 */ array(1, 17, 18, 20, ),
        /* 49 */ array(1, 17, 18, 20, ),
        /* 50 */ array(1, 17, 18, 20, ),
        /* 51 */ array(23, 29, 31, 67, ),
        /* 52 */ array(1, 17, 18, 20, ),
        /* 53 */ array(1, 17, 18, 20, ),
        /* 54 */ array(1, 17, 18, 20, ),
        /* 55 */ array(1, 17, 18, 20, ),
        /* 56 */ array(1, 17, 18, 20, ),
        /* 57 */ array(1, 17, 18, 20, ),
        /* 58 */ array(1, 17, 18, 20, ),
        /* 59 */ array(1, 17, 18, 20, ),
        /* 60 */ array(1, 17, 18, 20, ),
        /* 61 */ array(29, 31, 51, 67, ),
        /* 62 */ array(1, 17, 18, 20, ),
        /* 63 */ array(1, 17, 18, 20, ),
        /* 64 */ array(1, 17, 18, 20, ),
        /* 65 */ array(1, 17, 18, 20, ),
        /* 66 */ array(1, 17, 18, 20, ),
        /* 67 */ array(1, 17, 18, 20, ),
        /* 68 */ array(29, 31, 67, ),
        /* 69 */ array(29, 31, 67, ),
        /* 70 */ array(58, 60, 62, ),
        /* 71 */ array(29, 31, 67, ),
        /* 72 */ array(29, 31, 67, ),
        /* 73 */ array(29, 31, 67, ),
        /* 74 */ array(58, 60, 62, ),
        /* 75 */ array(29, 31, 67, ),
        /* 76 */ array(29, 31, 67, ),
        /* 77 */ array(29, 31, 67, ),
        /* 78 */ array(61, 64, ),
        /* 79 */ array(63, 64, ),
        /* 80 */ array(),
        /* 81 */ array(),
        /* 82 */ array(),
        /* 83 */ array(),
        /* 84 */ array(),
        /* 85 */ array(),
        /* 86 */ array(),
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
        /* 98 */ array(3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 59, ),
        /* 99 */ array(3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 23, ),
        /* 100 */ array(3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, ),
        /* 101 */ array(4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, ),
        /* 102 */ array(5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, ),
        /* 103 */ array(5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, ),
        /* 104 */ array(11, 37, 66, 68, 69, ),
        /* 105 */ array(11, 66, 68, 69, ),
        /* 106 */ array(57, 66, 68, 69, ),
        /* 107 */ array(23, 66, 68, 69, ),
        /* 108 */ array(23, 66, 68, 69, ),
        /* 109 */ array(30, 66, 68, 69, ),
        /* 110 */ array(23, 66, 68, 69, ),
        /* 111 */ array(23, 66, 68, 69, ),
        /* 112 */ array(30, 66, 68, 69, ),
        /* 113 */ array(23, 66, 68, 69, ),
        /* 114 */ array(14, 15, 16, ),
        /* 115 */ array(66, 68, 69, ),
        /* 116 */ array(66, 68, 69, ),
        /* 117 */ array(61, 64, ),
        /* 118 */ array(23, 56, ),
        /* 119 */ array(55, 56, ),
        /* 120 */ array(26, 27, ),
        /* 121 */ array(63, 64, ),
        /* 122 */ array(23, 56, ),
        /* 123 */ array(23, 51, ),
        /* 124 */ array(23, 56, ),
        /* 125 */ array(21, 56, ),
        /* 126 */ array(23, ),
        /* 127 */ array(23, ),
        /* 128 */ array(23, ),
        /* 129 */ array(23, ),
        /* 130 */ array(23, ),
        /* 131 */ array(23, ),
        /* 132 */ array(19, ),
        /* 133 */ array(23, ),
        /* 134 */ array(23, ),
        /* 135 */ array(23, ),
        /* 136 */ array(23, ),
        /* 137 */ array(23, ),
        /* 138 */ array(23, ),
        /* 139 */ array(56, ),
        /* 140 */ array(23, ),
        /* 141 */ array(23, ),
        /* 142 */ array(23, ),
        /* 143 */ array(23, ),
        /* 144 */ array(23, ),
        /* 145 */ array(23, ),
        /* 146 */ array(59, ),
        /* 147 */ array(23, ),
        /* 148 */ array(23, ),
        /* 149 */ array(70, ),
        /* 150 */ array(23, ),
        /* 151 */ array(23, ),
        /* 152 */ array(23, ),
        /* 153 */ array(23, ),
        /* 154 */ array(23, ),
        /* 155 */ array(23, ),
        /* 156 */ array(67, ),
        /* 157 */ array(23, ),
        /* 158 */ array(23, ),
        /* 159 */ array(23, ),
        /* 160 */ array(23, ),
        /* 161 */ array(67, ),
        /* 162 */ array(23, ),
        /* 163 */ array(),
        /* 164 */ array(),
        /* 165 */ array(),
        /* 166 */ array(),
        /* 167 */ array(),
        /* 168 */ array(),
        /* 169 */ array(),
        /* 170 */ array(),
        /* 171 */ array(),
        /* 172 */ array(),
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
);
    static public $yy_default = array(
 /*     0 */   234,  312,  312,  312,  312,  312,  312,  312,  312,  312,
 /*    10 */   312,  312,  312,  312,  312,  312,  312,  312,  312,  312,
 /*    20 */   312,  312,  312,  312,  312,  312,  312,  312,  312,  312,
 /*    30 */   312,  312,  312,  312,  312,  312,  312,  312,  312,  312,
 /*    40 */   312,  312,  312,  312,  312,  312,  312,  312,  312,  312,
 /*    50 */   312,  312,  312,  312,  232,  312,  312,  312,  312,  312,
 /*    60 */   312,  312,  312,  312,  312,  312,  312,  312,  312,  312,
 /*    70 */   312,  312,  312,  312,  312,  312,  312,  312,  312,  312,
 /*    80 */   234,  234,  234,  234,  234,  234,  234,  234,  234,  234,
 /*    90 */   234,  234,  234,  234,  234,  234,  234,  234,  312,  312,
 /*   100 */   299,  300,  303,  301,  312,  312,  282,  312,  312,  312,
 /*   110 */   312,  312,  312,  312,  302,  286,  278,  312,  312,  312,
 /*   120 */   312,  312,  312,  312,  312,  312,  312,  312,  312,  312,
 /*   130 */   312,  312,  312,  312,  312,  312,  312,  312,  312,  289,
 /*   140 */   312,  312,  312,  312,  312,  312,  312,  312,  312,  312,
 /*   150 */   312,  312,  312,  312,  312,  312,  312,  312,  312,  312,
 /*   160 */   312,  312,  312,  240,  233,  266,  241,  276,  275,  245,
 /*   170 */   244,  243,  291,  290,  242,  298,  287,  288,  292,  308,
 /*   180 */   304,  306,  305,  307,  293,  295,  296,  309,  310,  268,
 /*   190 */   294,  297,  246,  311,  250,  272,  260,  261,  280,  281,
 /*   200 */   258,  259,  279,  271,  262,  265,  267,  269,  270,  264,
 /*   210 */   263,  239,  257,  273,  235,  251,  252,  236,  237,  248,
 /*   220 */   238,  249,  253,  254,  255,  274,  256,  285,  284,  283,
 /*   230 */   277,  247,
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
    const YYNOCODE = 97;
    const YYSTACKDEPTH = 100;
    const YYNSTATE = 232;
    const YYNRULE = 80;
    const YYERRORSYMBOL = 71;
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
  'T_INCLUDE',     'T_AUTOESCAPE',  'T_OFF',         'T_ON',        
  'T_END_AUTOESCAPE',  'T_CUSTOM_TAG',  'T_AS',          'T_CUSTOM_BLOCK',
  'T_CUSTOM_END',  'T_WITH',        'T_ENDWITH',     'T_LOAD',      
  'T_FOR',         'T_COMMA',       'T_CLOSEFOR',    'T_EMPTY',     
  'T_IF',          'T_ENDIF',       'T_ELSE',        'T_IFCHANGED', 
  'T_ENDIFCHANGED',  'T_IFEQUAL',     'T_END_IFEQUAL',  'T_IFNOTEQUAL',
  'T_END_IFNOTEQUAL',  'T_BLOCK',       'T_END_BLOCK',   'T_NUMERIC',   
  'T_FILTER',      'T_END_FILTER',  'T_REGROUP',     'T_BY',        
  'T_PIPE',        'T_COLON',       'T_INTL',        'T_RPARENT',   
  'T_STRING_SINGLE_INIT',  'T_STRING_SINGLE_END',  'T_STRING_DOUBLE_INIT',  'T_STRING_DOUBLE_END',
  'T_STRING_CONTENT',  'T_LPARENT',     'T_OBJ',         'T_ALPHA',     
  'T_DOT',         'T_BRACKETS_OPEN',  'T_BRACKETS_CLOSE',  'error',       
  'start',         'body',          'code',          'stmts',       
  'filtered_var',  'var_or_string',  'stmt',          'for_stmt',    
  'ifchanged_stmt',  'block_stmt',    'filter_stmt',   'if_stmt',     
  'custom_tag',    'alias',         'ifequal',       'varname',     
  'var_list',      'regroup',       'string',        'for_def',     
  'expr',          'fvar_or_string',  'varname_args',  's_content',   
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
 /*  18 */ "stmts ::= T_AUTOESCAPE T_OFF|T_ON T_CLOSE_TAG body T_OPEN_TAG T_END_AUTOESCAPE T_CLOSE_TAG",
 /*  19 */ "custom_tag ::= T_CUSTOM_TAG T_CLOSE_TAG",
 /*  20 */ "custom_tag ::= T_CUSTOM_TAG T_AS varname T_CLOSE_TAG",
 /*  21 */ "custom_tag ::= T_CUSTOM_TAG var_list T_CLOSE_TAG",
 /*  22 */ "custom_tag ::= T_CUSTOM_TAG var_list T_AS varname T_CLOSE_TAG",
 /*  23 */ "custom_tag ::= T_CUSTOM_BLOCK T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  24 */ "alias ::= T_WITH varname T_AS varname T_CLOSE_TAG body T_OPEN_TAG T_ENDWITH T_CLOSE_TAG",
 /*  25 */ "stmt ::= regroup",
 /*  26 */ "stmt ::= T_LOAD string",
 /*  27 */ "for_def ::= T_FOR varname T_IN filtered_var T_CLOSE_TAG",
 /*  28 */ "for_def ::= T_FOR varname T_COMMA varname T_IN filtered_var T_CLOSE_TAG",
 /*  29 */ "for_stmt ::= for_def body T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG",
 /*  30 */ "for_stmt ::= for_def body T_OPEN_TAG T_EMPTY T_CLOSE_TAG body T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG",
 /*  31 */ "if_stmt ::= T_IF expr T_CLOSE_TAG body T_OPEN_TAG T_ENDIF T_CLOSE_TAG",
 /*  32 */ "if_stmt ::= T_IF expr T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIF T_CLOSE_TAG",
 /*  33 */ "ifchanged_stmt ::= T_IFCHANGED T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  34 */ "ifchanged_stmt ::= T_IFCHANGED var_list T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  35 */ "ifchanged_stmt ::= T_IFCHANGED T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  36 */ "ifchanged_stmt ::= T_IFCHANGED var_list T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  37 */ "ifequal ::= T_IFEQUAL fvar_or_string fvar_or_string T_CLOSE_TAG body T_OPEN_TAG T_END_IFEQUAL T_CLOSE_TAG",
 /*  38 */ "ifequal ::= T_IFEQUAL fvar_or_string fvar_or_string T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_END_IFEQUAL T_CLOSE_TAG",
 /*  39 */ "ifequal ::= T_IFNOTEQUAL fvar_or_string fvar_or_string T_CLOSE_TAG body T_OPEN_TAG T_END_IFNOTEQUAL T_CLOSE_TAG",
 /*  40 */ "ifequal ::= T_IFNOTEQUAL fvar_or_string fvar_or_string T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_END_IFNOTEQUAL T_CLOSE_TAG",
 /*  41 */ "block_stmt ::= T_BLOCK varname T_CLOSE_TAG body T_OPEN_TAG T_END_BLOCK T_CLOSE_TAG",
 /*  42 */ "block_stmt ::= T_BLOCK varname T_CLOSE_TAG body T_OPEN_TAG T_END_BLOCK varname T_CLOSE_TAG",
 /*  43 */ "block_stmt ::= T_BLOCK T_NUMERIC T_CLOSE_TAG body T_OPEN_TAG T_END_BLOCK T_CLOSE_TAG",
 /*  44 */ "block_stmt ::= T_BLOCK T_NUMERIC T_CLOSE_TAG body T_OPEN_TAG T_END_BLOCK T_NUMERIC T_CLOSE_TAG",
 /*  45 */ "filter_stmt ::= T_FILTER filtered_var T_CLOSE_TAG body T_OPEN_TAG T_END_FILTER T_CLOSE_TAG",
 /*  46 */ "regroup ::= T_REGROUP filtered_var T_BY varname T_AS varname",
 /*  47 */ "filtered_var ::= filtered_var T_PIPE varname_args",
 /*  48 */ "filtered_var ::= varname_args",
 /*  49 */ "varname_args ::= varname T_COLON var_or_string",
 /*  50 */ "varname_args ::= varname",
 /*  51 */ "var_list ::= var_list var_or_string",
 /*  52 */ "var_list ::= var_list T_COMMA var_or_string",
 /*  53 */ "var_list ::= var_or_string",
 /*  54 */ "var_or_string ::= varname",
 /*  55 */ "var_or_string ::= T_NUMERIC",
 /*  56 */ "var_or_string ::= string",
 /*  57 */ "fvar_or_string ::= filtered_var",
 /*  58 */ "fvar_or_string ::= T_NUMERIC",
 /*  59 */ "fvar_or_string ::= string",
 /*  60 */ "string ::= T_INTL string T_RPARENT",
 /*  61 */ "string ::= T_STRING_SINGLE_INIT T_STRING_SINGLE_END",
 /*  62 */ "string ::= T_STRING_DOUBLE_INIT T_STRING_DOUBLE_END",
 /*  63 */ "string ::= T_STRING_SINGLE_INIT s_content T_STRING_SINGLE_END",
 /*  64 */ "string ::= T_STRING_DOUBLE_INIT s_content T_STRING_DOUBLE_END",
 /*  65 */ "s_content ::= s_content T_STRING_CONTENT",
 /*  66 */ "s_content ::= T_STRING_CONTENT",
 /*  67 */ "expr ::= T_NOT expr",
 /*  68 */ "expr ::= expr T_AND expr",
 /*  69 */ "expr ::= expr T_OR expr",
 /*  70 */ "expr ::= expr T_PLUS|T_MINUS expr",
 /*  71 */ "expr ::= expr T_EQ|T_NE|T_GT|T_GE|T_LT|T_LE|T_IN expr",
 /*  72 */ "expr ::= expr T_TIMES|T_DIV|T_MOD expr",
 /*  73 */ "expr ::= T_LPARENT expr T_RPARENT",
 /*  74 */ "expr ::= fvar_or_string",
 /*  75 */ "varname ::= varname T_OBJ T_ALPHA",
 /*  76 */ "varname ::= varname T_DOT T_ALPHA",
 /*  77 */ "varname ::= varname T_BRACKETS_OPEN var_or_string T_BRACKETS_CLOSE",
 /*  78 */ "varname ::= T_ALPHA",
 /*  79 */ "varname ::= T_CUSTOM_TAG|T_CUSTOM_BLOCK",
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
  array( 'lhs' => 72, 'rhs' => 1 ),
  array( 'lhs' => 73, 'rhs' => 2 ),
  array( 'lhs' => 73, 'rhs' => 0 ),
  array( 'lhs' => 74, 'rhs' => 2 ),
  array( 'lhs' => 74, 'rhs' => 1 ),
  array( 'lhs' => 74, 'rhs' => 2 ),
  array( 'lhs' => 74, 'rhs' => 3 ),
  array( 'lhs' => 75, 'rhs' => 3 ),
  array( 'lhs' => 75, 'rhs' => 2 ),
  array( 'lhs' => 75, 'rhs' => 1 ),
  array( 'lhs' => 75, 'rhs' => 1 ),
  array( 'lhs' => 75, 'rhs' => 1 ),
  array( 'lhs' => 75, 'rhs' => 1 ),
  array( 'lhs' => 75, 'rhs' => 1 ),
  array( 'lhs' => 75, 'rhs' => 3 ),
  array( 'lhs' => 75, 'rhs' => 1 ),
  array( 'lhs' => 75, 'rhs' => 1 ),
  array( 'lhs' => 75, 'rhs' => 1 ),
  array( 'lhs' => 75, 'rhs' => 7 ),
  array( 'lhs' => 84, 'rhs' => 2 ),
  array( 'lhs' => 84, 'rhs' => 4 ),
  array( 'lhs' => 84, 'rhs' => 3 ),
  array( 'lhs' => 84, 'rhs' => 5 ),
  array( 'lhs' => 84, 'rhs' => 6 ),
  array( 'lhs' => 85, 'rhs' => 9 ),
  array( 'lhs' => 78, 'rhs' => 1 ),
  array( 'lhs' => 78, 'rhs' => 2 ),
  array( 'lhs' => 91, 'rhs' => 5 ),
  array( 'lhs' => 91, 'rhs' => 7 ),
  array( 'lhs' => 79, 'rhs' => 5 ),
  array( 'lhs' => 79, 'rhs' => 9 ),
  array( 'lhs' => 83, 'rhs' => 7 ),
  array( 'lhs' => 83, 'rhs' => 11 ),
  array( 'lhs' => 80, 'rhs' => 6 ),
  array( 'lhs' => 80, 'rhs' => 7 ),
  array( 'lhs' => 80, 'rhs' => 10 ),
  array( 'lhs' => 80, 'rhs' => 11 ),
  array( 'lhs' => 86, 'rhs' => 8 ),
  array( 'lhs' => 86, 'rhs' => 12 ),
  array( 'lhs' => 86, 'rhs' => 8 ),
  array( 'lhs' => 86, 'rhs' => 12 ),
  array( 'lhs' => 81, 'rhs' => 7 ),
  array( 'lhs' => 81, 'rhs' => 8 ),
  array( 'lhs' => 81, 'rhs' => 7 ),
  array( 'lhs' => 81, 'rhs' => 8 ),
  array( 'lhs' => 82, 'rhs' => 7 ),
  array( 'lhs' => 89, 'rhs' => 6 ),
  array( 'lhs' => 76, 'rhs' => 3 ),
  array( 'lhs' => 76, 'rhs' => 1 ),
  array( 'lhs' => 94, 'rhs' => 3 ),
  array( 'lhs' => 94, 'rhs' => 1 ),
  array( 'lhs' => 88, 'rhs' => 2 ),
  array( 'lhs' => 88, 'rhs' => 3 ),
  array( 'lhs' => 88, 'rhs' => 1 ),
  array( 'lhs' => 77, 'rhs' => 1 ),
  array( 'lhs' => 77, 'rhs' => 1 ),
  array( 'lhs' => 77, 'rhs' => 1 ),
  array( 'lhs' => 93, 'rhs' => 1 ),
  array( 'lhs' => 93, 'rhs' => 1 ),
  array( 'lhs' => 93, 'rhs' => 1 ),
  array( 'lhs' => 90, 'rhs' => 3 ),
  array( 'lhs' => 90, 'rhs' => 2 ),
  array( 'lhs' => 90, 'rhs' => 2 ),
  array( 'lhs' => 90, 'rhs' => 3 ),
  array( 'lhs' => 90, 'rhs' => 3 ),
  array( 'lhs' => 95, 'rhs' => 2 ),
  array( 'lhs' => 95, 'rhs' => 1 ),
  array( 'lhs' => 92, 'rhs' => 2 ),
  array( 'lhs' => 92, 'rhs' => 3 ),
  array( 'lhs' => 92, 'rhs' => 3 ),
  array( 'lhs' => 92, 'rhs' => 3 ),
  array( 'lhs' => 92, 'rhs' => 3 ),
  array( 'lhs' => 92, 'rhs' => 3 ),
  array( 'lhs' => 92, 'rhs' => 3 ),
  array( 'lhs' => 92, 'rhs' => 1 ),
  array( 'lhs' => 87, 'rhs' => 3 ),
  array( 'lhs' => 87, 'rhs' => 3 ),
  array( 'lhs' => 87, 'rhs' => 4 ),
  array( 'lhs' => 87, 'rhs' => 1 ),
  array( 'lhs' => 87, 'rhs' => 1 ),
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
        15 => 3,
        16 => 3,
        17 => 3,
        25 => 3,
        50 => 3,
        66 => 3,
        74 => 3,
        78 => 3,
        79 => 3,
        4 => 4,
        5 => 5,
        6 => 6,
        7 => 7,
        8 => 8,
        60 => 8,
        14 => 14,
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
        41 => 41,
        43 => 41,
        42 => 42,
        44 => 42,
        45 => 45,
        46 => 46,
        47 => 47,
        52 => 47,
        48 => 48,
        53 => 48,
        49 => 49,
        51 => 51,
        54 => 54,
        55 => 55,
        58 => 55,
        56 => 56,
        59 => 56,
        57 => 57,
        61 => 61,
        62 => 61,
        63 => 63,
        64 => 63,
        65 => 65,
        67 => 67,
        68 => 68,
        69 => 68,
        70 => 68,
        72 => 68,
        71 => 71,
        73 => 73,
        75 => 75,
        76 => 76,
        77 => 77,
    );
    /* Beginning here are the reduction cases.  A typical example
    ** follows:
    **  #line <lineno> <grammarfile>
    **   function yy_r0($yymsp){ ... }           // User supplied code
    **  #line <lineno> <thisfile>
    */
#line 66 "lib/Haanga/Compiler/Parser.y"
    function yy_r0(){ $this->body = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1536 "lib/Haanga/Compiler/Parser.php"
#line 68 "lib/Haanga/Compiler/Parser.y"
    function yy_r1(){ $this->_retvalue=$this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1539 "lib/Haanga/Compiler/Parser.php"
#line 69 "lib/Haanga/Compiler/Parser.y"
    function yy_r2(){ $this->_retvalue = array();     }
#line 1542 "lib/Haanga/Compiler/Parser.php"
#line 72 "lib/Haanga/Compiler/Parser.y"
    function yy_r3(){ $this->_retvalue = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1545 "lib/Haanga/Compiler/Parser.php"
#line 73 "lib/Haanga/Compiler/Parser.y"
    function yy_r4(){ $this->_retvalue = array('operation' => 'html', 'html' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1548 "lib/Haanga/Compiler/Parser.php"
#line 74 "lib/Haanga/Compiler/Parser.y"
    function yy_r5(){ $this->yystack[$this->yyidx + 0]->minor=rtrim($this->yystack[$this->yyidx + 0]->minor); $this->_retvalue = array('operation' => 'comment', 'comment' => substr($this->yystack[$this->yyidx + 0]->minor, 0, strlen($this->yystack[$this->yyidx + 0]->minor)-2));     }
#line 1551 "lib/Haanga/Compiler/Parser.php"
#line 75 "lib/Haanga/Compiler/Parser.y"
    function yy_r6(){ $this->_retvalue = array('operation' => 'print_var', 'variable' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1554 "lib/Haanga/Compiler/Parser.php"
#line 77 "lib/Haanga/Compiler/Parser.y"
    function yy_r7(){ $this->_retvalue = array('operation' => 'base', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1557 "lib/Haanga/Compiler/Parser.php"
#line 78 "lib/Haanga/Compiler/Parser.y"
    function yy_r8(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1560 "lib/Haanga/Compiler/Parser.php"
#line 84 "lib/Haanga/Compiler/Parser.y"
    function yy_r14(){ $this->_retvalue = array('operation' => 'include', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1563 "lib/Haanga/Compiler/Parser.php"
#line 88 "lib/Haanga/Compiler/Parser.y"
    function yy_r18(){ $this->_retvalue = array('operation' => 'autoescape', 'value' => strtolower(@$this->yystack[$this->yyidx + -5]->minor), 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1566 "lib/Haanga/Compiler/Parser.php"
#line 93 "lib/Haanga/Compiler/Parser.y"
    function yy_r19(){ $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -1]->minor, 'list'=>array());     }
#line 1569 "lib/Haanga/Compiler/Parser.php"
#line 94 "lib/Haanga/Compiler/Parser.y"
    function yy_r20(){ $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -3]->minor, 'as' => $this->yystack[$this->yyidx + -1]->minor, 'list'=>array());     }
#line 1572 "lib/Haanga/Compiler/Parser.php"
#line 95 "lib/Haanga/Compiler/Parser.y"
    function yy_r21(){ $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -2]->minor, 'list' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1575 "lib/Haanga/Compiler/Parser.php"
#line 96 "lib/Haanga/Compiler/Parser.y"
    function yy_r22(){ $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -4]->minor, 'as' => $this->yystack[$this->yyidx + -1]->minor, 'list' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1578 "lib/Haanga/Compiler/Parser.php"
#line 98 "lib/Haanga/Compiler/Parser.y"
    function yy_r23(){ if ('end'.$this->yystack[$this->yyidx + -5]->minor != $this->yystack[$this->yyidx + -1]->minor) { throw new Exception("Unexpected ".$this->yystack[$this->yyidx + -1]->minor); } $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor, 'list' => array());    }
#line 1581 "lib/Haanga/Compiler/Parser.php"
#line 101 "lib/Haanga/Compiler/Parser.y"
    function yy_r24(){ $this->_retvalue = array('operation' => 'alias', 'var' => $this->yystack[$this->yyidx + -7]->minor, 'as' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1584 "lib/Haanga/Compiler/Parser.php"
#line 105 "lib/Haanga/Compiler/Parser.y"
    function yy_r26(){
    if (!is_file($this->yystack[$this->yyidx + 0]->minor)) {
        throw new Haanga_Compiler_Exception($this->yystack[$this->yyidx + 0]->minor." is not a valid file"); 
    } 
    require_once $this->yystack[$this->yyidx + 0]->minor;
    }
#line 1592 "lib/Haanga/Compiler/Parser.php"
#line 113 "lib/Haanga/Compiler/Parser.y"
    function yy_r27(){
    $this->compiler->set_context($this->yystack[$this->yyidx + -3]->minor, array());
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -3]->minor, 'index' => NULL, 'array' => $this->yystack[$this->yyidx + -1]->minor);
    }
#line 1598 "lib/Haanga/Compiler/Parser.php"
#line 118 "lib/Haanga/Compiler/Parser.y"
    function yy_r28(){
    $this->compiler->set_context($this->yystack[$this->yyidx + -3]->minor, array());
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -3]->minor, 'index' => $this->yystack[$this->yyidx + -5]->minor, 'array' => $this->yystack[$this->yyidx + -1]->minor);
    }
#line 1604 "lib/Haanga/Compiler/Parser.php"
#line 124 "lib/Haanga/Compiler/Parser.y"
    function yy_r29(){ 
    $this->_retvalue = $this->yystack[$this->yyidx + -4]->minor;
    $this->_retvalue['body'] = $this->yystack[$this->yyidx + -3]->minor;
    }
#line 1610 "lib/Haanga/Compiler/Parser.php"
#line 129 "lib/Haanga/Compiler/Parser.y"
    function yy_r30(){ 
    $this->_retvalue = $this->yystack[$this->yyidx + -8]->minor;
    $this->_retvalue['body']  = $this->yystack[$this->yyidx + -7]->minor;
    $this->_retvalue['empty'] = $this->yystack[$this->yyidx + -3]->minor;
    }
#line 1617 "lib/Haanga/Compiler/Parser.php"
#line 135 "lib/Haanga/Compiler/Parser.y"
    function yy_r31(){ $this->_retvalue = array('operation' => 'if', 'expr' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1620 "lib/Haanga/Compiler/Parser.php"
#line 136 "lib/Haanga/Compiler/Parser.y"
    function yy_r32(){ $this->_retvalue = array('operation' => 'if', 'expr' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1623 "lib/Haanga/Compiler/Parser.php"
#line 139 "lib/Haanga/Compiler/Parser.y"
    function yy_r33(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1628 "lib/Haanga/Compiler/Parser.php"
#line 143 "lib/Haanga/Compiler/Parser.y"
    function yy_r34(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -3]->minor, 'check' => $this->yystack[$this->yyidx + -5]->minor);
    }
#line 1633 "lib/Haanga/Compiler/Parser.php"
#line 146 "lib/Haanga/Compiler/Parser.y"
    function yy_r35(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1638 "lib/Haanga/Compiler/Parser.php"
#line 150 "lib/Haanga/Compiler/Parser.y"
    function yy_r36(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -7]->minor, 'check' => $this->yystack[$this->yyidx + -9]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);
    }
#line 1643 "lib/Haanga/Compiler/Parser.php"
#line 155 "lib/Haanga/Compiler/Parser.y"
    function yy_r37(){  $this->_retvalue = array('operation' => 'ifequal', 'cmp' => '==', 1 => $this->yystack[$this->yyidx + -6]->minor, 2 => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1646 "lib/Haanga/Compiler/Parser.php"
#line 156 "lib/Haanga/Compiler/Parser.y"
    function yy_r38(){  $this->_retvalue = array('operation' => 'ifequal', 'cmp' => '==', 1 => $this->yystack[$this->yyidx + -10]->minor, 2 => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1649 "lib/Haanga/Compiler/Parser.php"
#line 157 "lib/Haanga/Compiler/Parser.y"
    function yy_r39(){  $this->_retvalue = array('operation' => 'ifequal', 'cmp' => '!=', 1 => $this->yystack[$this->yyidx + -6]->minor, 2 => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1652 "lib/Haanga/Compiler/Parser.php"
#line 158 "lib/Haanga/Compiler/Parser.y"
    function yy_r40(){  $this->_retvalue = array('operation' => 'ifequal', 'cmp' => '!=', 1 => $this->yystack[$this->yyidx + -10]->minor, 2 => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1655 "lib/Haanga/Compiler/Parser.php"
#line 162 "lib/Haanga/Compiler/Parser.y"
    function yy_r41(){ $this->_retvalue = array('operation' => 'block', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1658 "lib/Haanga/Compiler/Parser.php"
#line 164 "lib/Haanga/Compiler/Parser.y"
    function yy_r42(){ $this->_retvalue = array('operation' => 'block', 'name' => $this->yystack[$this->yyidx + -6]->minor, 'body' => $this->yystack[$this->yyidx + -4]->minor);     }
#line 1661 "lib/Haanga/Compiler/Parser.php"
#line 171 "lib/Haanga/Compiler/Parser.y"
    function yy_r45(){ $this->_retvalue = array('operation' => 'filter', 'functions' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1664 "lib/Haanga/Compiler/Parser.php"
#line 174 "lib/Haanga/Compiler/Parser.y"
    function yy_r46(){ $this->_retvalue=array('operation' => 'regroup', 'array' => $this->yystack[$this->yyidx + -4]->minor, 'row' => $this->yystack[$this->yyidx + -2]->minor, 'as' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1667 "lib/Haanga/Compiler/Parser.php"
#line 177 "lib/Haanga/Compiler/Parser.y"
    function yy_r47(){ $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1670 "lib/Haanga/Compiler/Parser.php"
#line 178 "lib/Haanga/Compiler/Parser.y"
    function yy_r48(){ $this->_retvalue = array($this->yystack[$this->yyidx + 0]->minor);     }
#line 1673 "lib/Haanga/Compiler/Parser.php"
#line 180 "lib/Haanga/Compiler/Parser.y"
    function yy_r49(){ $this->_retvalue = array($this->yystack[$this->yyidx + -2]->minor, 'args'=>array($this->yystack[$this->yyidx + 0]->minor));     }
#line 1676 "lib/Haanga/Compiler/Parser.php"
#line 184 "lib/Haanga/Compiler/Parser.y"
    function yy_r51(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1679 "lib/Haanga/Compiler/Parser.php"
#line 190 "lib/Haanga/Compiler/Parser.y"
    function yy_r54(){ $this->_retvalue = array('var' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1682 "lib/Haanga/Compiler/Parser.php"
#line 191 "lib/Haanga/Compiler/Parser.y"
    function yy_r55(){ $this->_retvalue = array('number' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1685 "lib/Haanga/Compiler/Parser.php"
#line 192 "lib/Haanga/Compiler/Parser.y"
    function yy_r56(){ $this->_retvalue = array('string' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1688 "lib/Haanga/Compiler/Parser.php"
#line 194 "lib/Haanga/Compiler/Parser.y"
    function yy_r57(){ $this->_retvalue = array('var_filter' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1691 "lib/Haanga/Compiler/Parser.php"
#line 200 "lib/Haanga/Compiler/Parser.y"
    function yy_r61(){  $this->_retvalue = "";     }
#line 1694 "lib/Haanga/Compiler/Parser.php"
#line 202 "lib/Haanga/Compiler/Parser.y"
    function yy_r63(){  $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1697 "lib/Haanga/Compiler/Parser.php"
#line 204 "lib/Haanga/Compiler/Parser.y"
    function yy_r65(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor.$this->yystack[$this->yyidx + 0]->minor;     }
#line 1700 "lib/Haanga/Compiler/Parser.php"
#line 208 "lib/Haanga/Compiler/Parser.y"
    function yy_r67(){ $this->_retvalue = array('op_expr' => 'not', $this->yystack[$this->yyidx + 0]->minor);     }
#line 1703 "lib/Haanga/Compiler/Parser.php"
#line 209 "lib/Haanga/Compiler/Parser.y"
    function yy_r68(){ $this->_retvalue = array('op_expr' => @$this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1706 "lib/Haanga/Compiler/Parser.php"
#line 212 "lib/Haanga/Compiler/Parser.y"
    function yy_r71(){ $this->_retvalue = array('op_expr' => trim(@$this->yystack[$this->yyidx + -1]->minor), $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1709 "lib/Haanga/Compiler/Parser.php"
#line 214 "lib/Haanga/Compiler/Parser.y"
    function yy_r73(){ $this->_retvalue = array('op_expr' => 'expr', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1712 "lib/Haanga/Compiler/Parser.php"
#line 218 "lib/Haanga/Compiler/Parser.y"
    function yy_r75(){ if (!is_array($this->yystack[$this->yyidx + -2]->minor)) { $this->_retvalue = array($this->yystack[$this->yyidx + -2]->minor); } else { $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; }  $this->_retvalue[]=array('object' => $this->yystack[$this->yyidx + 0]->minor);    }
#line 1715 "lib/Haanga/Compiler/Parser.php"
#line 219 "lib/Haanga/Compiler/Parser.y"
    function yy_r76(){ if (!is_array($this->yystack[$this->yyidx + -2]->minor)) { $this->_retvalue = array($this->yystack[$this->yyidx + -2]->minor); } else { $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; } $this->_retvalue[] = ($this->compiler->var_is_object($this->_retvalue)) ? array('object' => $this->yystack[$this->yyidx + 0]->minor) : $this->yystack[$this->yyidx + 0]->minor;    }
#line 1718 "lib/Haanga/Compiler/Parser.php"
#line 220 "lib/Haanga/Compiler/Parser.y"
    function yy_r77(){ if (!is_array($this->yystack[$this->yyidx + -3]->minor)) { $this->_retvalue = array($this->yystack[$this->yyidx + -3]->minor); } else { $this->_retvalue = $this->yystack[$this->yyidx + -3]->minor; }  $this->_retvalue[]=$this->yystack[$this->yyidx + -1]->minor;    }
#line 1721 "lib/Haanga/Compiler/Parser.php"

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
#line 57 "lib/Haanga/Compiler/Parser.y"

    $expect = array();
    foreach ($this->yy_get_expected_tokens($yymajor) as $token) {
        $expect[] = self::$yyTokenName[$token];
    }
    throw new Exception('Unexpected ' . $this->tokenName($yymajor) . '(' . $TOKEN. '), expected one of: ' . implode(',', $expect));
#line 1841 "lib/Haanga/Compiler/Parser.php"
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
#line 44 "lib/Haanga/Compiler/Parser.y"

#line 1862 "lib/Haanga/Compiler/Parser.php"
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