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
#line 136 "parser.php"

// declare_class is output here
#line 39 "parser.y"
 class Parser #line 141 "parser.php"
{
/* First off, code is included which follows the "include_class" declaration
** in the input file. */
#line 40 "parser.y"


#line 149 "parser.php"

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
    const T_AND                          =  2;
    const T_OR                           =  3;
    const T_EQ                           =  4;
    const T_NE                           =  5;
    const T_GT                           =  6;
    const T_GE                           =  7;
    const T_LT                           =  8;
    const T_LE                           =  9;
    const T_IN                           = 10;
    const T_PLUS                         = 11;
    const T_MINUS                        = 12;
    const T_TIMES                        = 13;
    const T_DIV                          = 14;
    const T_MOD                          = 15;
    const T_HTML                         = 16;
    const T_COMMENT_OPEN                 = 17;
    const T_COMMENT                      = 18;
    const T_PRINT_OPEN                   = 19;
    const T_PRINT_CLOSE                  = 20;
    const T_EXTENDS                      = 21;
    const T_CLOSE_TAG                    = 22;
    const T_INCLUDE                      = 23;
    const T_AUTOESCAPE                   = 24;
    const T_OFF                          = 25;
    const T_ON                           = 26;
    const T_END_AUTOESCAPE               = 27;
    const T_CUSTOM_TAG                   = 28;
    const T_AS                           = 29;
    const T_CUSTOM_BLOCK                 = 30;
    const T_CUSTOM_END                   = 31;
    const T_WITH                         = 32;
    const T_ENDWITH                      = 33;
    const T_FOR                          = 34;
    const T_CLOSEFOR                     = 35;
    const T_COMMA                        = 36;
    const T_EMPTY                        = 37;
    const T_IF                           = 38;
    const T_ENDIF                        = 39;
    const T_ELSE                         = 40;
    const T_IFCHANGED                    = 41;
    const T_ENDIFCHANGED                 = 42;
    const T_IFEQUAL                      = 43;
    const T_END_IFEQUAL                  = 44;
    const T_IFNOTEQUAL                   = 45;
    const T_END_IFNOTEQUAL               = 46;
    const T_BLOCK                        = 47;
    const T_END_BLOCK                    = 48;
    const T_NUMERIC                      = 49;
    const T_FILTER                       = 50;
    const T_END_FILTER                   = 51;
    const T_REGROUP                      = 52;
    const T_BY                           = 53;
    const T_PIPE                         = 54;
    const T_COLON                        = 55;
    const T_STRING_SINGLE_INIT           = 56;
    const T_STRING_SINGLE_END            = 57;
    const T_STRING_DOUBLE_INIT           = 58;
    const T_STRING_DOUBLE_END            = 59;
    const T_STRING_CONTENT               = 60;
    const T_LPARENT                      = 61;
    const T_RPARENT                      = 62;
    const T_DOT                          = 63;
    const T_ALPHA                        = 64;
    const T_BRACKETS_OPEN                = 65;
    const T_BRACKETS_CLOSE               = 66;
    const YY_NO_ACTION = 306;
    const YY_ACCEPT_ACTION = 305;
    const YY_ERROR_ACTION = 304;

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
    const YY_SZ_ACTTAB = 916;
static public $yy_action = array(
 /*     0 */    39,  196,   40,  120,  205,  148,  148,   33,  216,  144,
 /*    10 */   190,   74,  190,   78,  185,   42,  190,   23,  190,  140,
 /*    20 */    34,  162,   29,  157,   30,   39,   50,   40,  120,   44,
 /*    30 */   108,   46,   33,  122,  144,  211,   74,  152,   78,  197,
 /*    40 */   198,   73,   23,  202,  130,   34,  191,   29,   17,   30,
 /*    50 */   132,   50,  191,  177,   44,  190,   46,  190,   39,   76,
 /*    60 */    40,  120,   51,  213,  135,   33,   45,  144,  159,   74,
 /*    70 */    37,   78,  143,   90,  151,   23,  212,  222,   34,  174,
 /*    80 */    29,   93,   30,   39,   50,   40,  120,   44,   99,   46,
 /*    90 */    33,  191,  144,  159,   74,   37,   78,   24,   24,   24,
 /*   100 */    23,   84,  165,   34,  164,   29,  131,   30,   39,   50,
 /*   110 */    40,  120,   44,   47,   46,   33,  173,  144,  159,   74,
 /*   120 */    37,   78,  139,   70,  142,   23,  210,  203,   34,  159,
 /*   130 */    29,   37,   30,   39,   50,   40,  120,   44,  218,   46,
 /*   140 */    33,  159,  144,   37,   74,   48,   78,  225,  122,   36,
 /*   150 */    23,   43,  155,   34,  197,   29,  153,   30,   39,   50,
 /*   160 */    40,  120,   44,  218,   46,   33,   86,  144,  159,   74,
 /*   170 */    37,   78,   52,  122,   35,   23,  161,  136,   34,  197,
 /*   180 */    29,  192,   30,   39,   50,   40,  120,   44,   77,   46,
 /*   190 */    33,   38,  144,   49,   74,   64,   78,  129,   47,  159,
 /*   200 */    23,   37,   92,   34,  159,   29,   37,   30,   39,   50,
 /*   210 */    40,  120,   44,  147,   46,   33,   60,  144,  138,   74,
 /*   220 */   100,   78,  159,  122,   37,   23,  194,  206,   34,  197,
 /*   230 */    29,  215,   30,   39,   50,   40,  120,   44,  226,   46,
 /*   240 */    33,  122,  144,  159,   74,   37,   78,  197,   72,   47,
 /*   250 */    23,  223,   47,   34,  149,   29,  221,   30,   39,   50,
 /*   260 */    40,  120,   44,  146,   46,   33,  122,  144,  159,   74,
 /*   270 */    37,   78,  197,  122,  176,   23,  220,   83,   34,  197,
 /*   280 */    29,   89,   30,   81,   50,   55,  122,   44,  170,   46,
 /*   290 */   124,   39,  197,   40,  120,   87,  118,  229,   33,   47,
 /*   300 */   144,  108,   74,   58,   78,  141,  214,  108,   23,  109,
 /*   310 */   119,   34,  214,   29,   91,   30,   39,   50,   40,  120,
 /*   320 */    44,  108,   46,   33,  217,  144,  214,   74,  137,   78,
 /*   330 */    88,   47,   85,   23,  208,  123,   34,  209,   29,  169,
 /*   340 */    30,   39,   50,   40,  120,   44,  108,   46,   33,  207,
 /*   350 */   144,  214,   74,  126,   78,  305,   62,  114,   23,  113,
 /*   360 */    98,   34,  110,   29,  108,   30,  133,   50,  117,  214,
 /*   370 */    44,  111,   46,  128,   39,   66,   40,  120,  200,  202,
 /*   380 */   112,   33,  115,  144,  108,   74,  116,   78,  160,  214,
 /*   390 */   166,   23,  106,   94,   34,   53,   29,   67,   30,   63,
 /*   400 */    50,  121,  201,   44,  184,   46,  128,   39,   69,   40,
 /*   410 */   120,  219,   56,   68,   33,   59,  144,  108,   74,  228,
 /*   420 */    78,   31,  214,  166,   23,  199,  227,   34,  175,   29,
 /*   430 */   125,   30,   39,   50,   40,  120,   44,  134,   46,   33,
 /*   440 */    97,  144,   54,   74,   65,   78,   57,  182,  127,   23,
 /*   450 */    61,  167,   34,  154,   29,  167,   30,  167,   50,  167,
 /*   460 */   167,   44,  167,   46,   25,   26,   22,   22,   22,   22,
 /*   470 */    22,   22,   22,   27,   27,   24,   24,   24,   39,  167,
 /*   480 */    40,  120,  190,  167,  190,   33,  167,  144,  167,   74,
 /*   490 */   167,   78,  167,  167,  167,   23,  163,  167,   34,  167,
 /*   500 */    29,  167,   30,  172,   50,  167,  167,   44,  167,   46,
 /*   510 */    80,  167,   79,  167,  167,   28,  167,  167,  191,  167,
 /*   520 */    39,  167,   40,  120,  167,  167,  150,   33,  167,  144,
 /*   530 */    95,   74,  167,   78,  167,  167,  190,   23,  190,  167,
 /*   540 */    34,  167,   29,  167,   30,   39,   50,   40,  120,   44,
 /*   550 */   167,   46,   33,  167,  144,  167,   74,  193,   78,  167,
 /*   560 */   167,  167,   23,  167,   80,   34,   79,   29,  156,   30,
 /*   570 */   167,   50,  191,  167,   44,  167,   46,   25,   26,   22,
 /*   580 */    22,   22,   22,   22,   22,   22,   27,   27,   24,   24,
 /*   590 */    24,   39,  167,   40,  120,  167,  167,   82,   33,  167,
 /*   600 */   144,  167,   74,  167,   78,  167,  167,  167,   23,  167,
 /*   610 */   167,   34,  167,   29,  167,   30,  167,   50,  167,  167,
 /*   620 */    44,  167,   46,  167,   26,   22,   22,   22,   22,   22,
 /*   630 */    22,   22,   27,   27,   24,   24,   24,   22,   22,   22,
 /*   640 */    22,   22,   22,   22,   27,   27,   24,   24,   24,  195,
 /*   650 */   167,  167,  145,  181,  180,  178,  179,  183,  189,  188,
 /*   660 */   187,  204,  167,  224,  186,  167,  167,  190,   75,  190,
 /*   670 */   190,   71,  190,  167,  167,   41,  167,  167,   96,  167,
 /*   680 */   167,  190,  167,  190,  190,  167,  190,  167,  193,  167,
 /*   690 */   167,  193,   41,  167,  167,   80,  167,   79,   80,  167,
 /*   700 */    79,  167,  172,  191,  167,  193,  191,  128,  167,   80,
 /*   710 */   167,   79,   80,  190,   79,  190,  128,  191,  108,  167,
 /*   720 */   191,  107,  168,  214,  166,  167,  167,  108,  167,  167,
 /*   730 */   104,  168,  214,  166,  193,  167,  128,  167,  167,  167,
 /*   740 */   167,   80,  167,   79,  128,  167,  167,  108,  167,  191,
 /*   750 */   102,  168,  214,  166,  128,  108,  167,  167,  105,  168,
 /*   760 */   214,  166,  167,  167,  128,  108,  167,  167,  103,  168,
 /*   770 */   214,  166,  167,  128,  167,  108,  167,  167,  101,  168,
 /*   780 */   214,  166,  128,  167,  108,  128,  167,  171,  168,  214,
 /*   790 */   166,    7,  167,  108,  167,    6,  108,   32,  214,  166,
 /*   800 */   158,  214,  166,   16,  167,  167,  213,  135,   13,   45,
 /*   810 */   213,  135,    3,   45,  167,  167,  167,  167,  213,  135,
 /*   820 */    20,   45,  167,  213,  135,    9,   45,  213,  135,   10,
 /*   830 */    45,  167,  167,  167,  167,  213,  135,   11,   45,  167,
 /*   840 */   213,  135,   14,   45,  213,  135,    1,   45,  167,  167,
 /*   850 */   167,  167,  213,  135,   21,   45,  167,  213,  135,   19,
 /*   860 */    45,  213,  135,   12,   45,  167,  167,  167,  167,  213,
 /*   870 */   135,    8,   45,  167,  213,  135,    4,   45,  213,  135,
 /*   880 */    15,   45,  167,  167,  167,  167,  213,  135,    2,   45,
 /*   890 */   167,  213,  135,   18,   45,  213,  135,    5,   45,  167,
 /*   900 */   167,  167,  167,  213,  135,  167,   45,  167,  213,  135,
 /*   910 */   167,   45,  213,  135,  167,   45,
    );
    static public $yy_lookahead = array(
 /*     0 */    21,   70,   23,   24,   22,   25,   26,   28,   22,   30,
 /*    10 */    28,   32,   30,   34,   22,   10,   28,   38,   30,   40,
 /*    20 */    41,   42,   43,   73,   45,   21,   47,   23,   24,   50,
 /*    30 */    83,   52,   28,   83,   30,   88,   32,   49,   34,   89,
 /*    40 */    57,   36,   38,   60,   40,   41,   64,   43,    1,   45,
 /*    50 */    46,   47,   64,   22,   50,   28,   52,   30,   21,   29,
 /*    60 */    23,   24,   69,   16,   17,   28,   19,   30,   63,   32,
 /*    70 */    65,   34,   35,   22,   37,   38,   18,   22,   41,   22,
 /*    80 */    43,   22,   45,   21,   47,   23,   24,   50,   22,   52,
 /*    90 */    28,   64,   30,   63,   32,   65,   34,   13,   14,   15,
 /*   100 */    38,   22,   40,   41,   42,   43,   49,   45,   21,   47,
 /*   110 */    23,   24,   50,   54,   52,   28,   22,   30,   63,   32,
 /*   120 */    65,   34,   35,   69,   37,   38,   22,   22,   41,   63,
 /*   130 */    43,   65,   45,   21,   47,   23,   24,   50,   73,   52,
 /*   140 */    28,   63,   30,   65,   32,   69,   34,   22,   83,   84,
 /*   150 */    38,   10,   40,   41,   89,   43,   44,   45,   21,   47,
 /*   160 */    23,   24,   50,   73,   52,   28,   22,   30,   63,   32,
 /*   170 */    65,   34,   69,   83,   84,   38,   39,   40,   41,   89,
 /*   180 */    43,   64,   45,   21,   47,   23,   24,   50,   29,   52,
 /*   190 */    28,   55,   30,   69,   32,   69,   34,   35,   54,   63,
 /*   200 */    38,   65,   22,   41,   63,   43,   65,   45,   21,   47,
 /*   210 */    23,   24,   50,   73,   52,   28,   69,   30,   31,   32,
 /*   220 */    22,   34,   63,   83,   65,   38,   22,   22,   41,   89,
 /*   230 */    43,   73,   45,   21,   47,   23,   24,   50,   22,   52,
 /*   240 */    28,   83,   30,   63,   32,   65,   34,   89,   53,   54,
 /*   250 */    38,   22,   54,   41,   42,   43,   73,   45,   21,   47,
 /*   260 */    23,   24,   50,   73,   52,   28,   83,   30,   63,   32,
 /*   270 */    65,   34,   89,   83,   22,   38,   73,   22,   41,   89,
 /*   280 */    43,   22,   45,   22,   47,   48,   83,   50,   22,   52,
 /*   290 */    72,   21,   89,   23,   24,   22,   72,   20,   28,   54,
 /*   300 */    30,   83,   32,   69,   34,   35,   88,   83,   38,   83,
 /*   310 */    72,   41,   88,   43,   22,   45,   21,   47,   23,   24,
 /*   320 */    50,   83,   52,   28,   22,   30,   88,   32,   33,   34,
 /*   330 */    22,   54,   22,   38,   22,   72,   41,   22,   43,   22,
 /*   340 */    45,   21,   47,   23,   24,   50,   83,   52,   28,   22,
 /*   350 */    30,   88,   32,   72,   34,   68,   69,   83,   38,   83,
 /*   360 */    22,   41,   83,   43,   83,   45,   46,   47,   83,   88,
 /*   370 */    50,   83,   52,   72,   21,   69,   23,   24,   59,   60,
 /*   380 */    83,   28,   83,   30,   83,   32,   83,   34,   87,   88,
 /*   390 */    89,   38,   83,   22,   41,   69,   43,   69,   45,   69,
 /*   400 */    47,   48,   60,   50,   22,   52,   72,   21,   69,   23,
 /*   410 */    24,   22,   69,   69,   28,   69,   30,   83,   32,   22,
 /*   420 */    34,   87,   88,   89,   38,   66,   22,   41,   22,   43,
 /*   430 */    90,   45,   21,   47,   23,   24,   50,   51,   52,   28,
 /*   440 */    22,   30,   69,   32,   69,   34,   69,   22,   90,   38,
 /*   450 */    69,   91,   41,   42,   43,   91,   45,   91,   47,   91,
 /*   460 */    91,   50,   91,   52,    2,    3,    4,    5,    6,    7,
 /*   470 */     8,    9,   10,   11,   12,   13,   14,   15,   21,   91,
 /*   480 */    23,   24,   28,   91,   30,   28,   91,   30,   91,   32,
 /*   490 */    91,   34,   91,   91,   91,   38,   39,   91,   41,   91,
 /*   500 */    43,   91,   45,   49,   47,   91,   91,   50,   91,   52,
 /*   510 */    56,   91,   58,   91,   91,   61,   91,   91,   64,   91,
 /*   520 */    21,   91,   23,   24,   62,   91,   27,   28,   91,   30,
 /*   530 */    22,   32,   91,   34,   91,   91,   28,   38,   30,   91,
 /*   540 */    41,   91,   43,   91,   45,   21,   47,   23,   24,   50,
 /*   550 */    91,   52,   28,   91,   30,   91,   32,   49,   34,   91,
 /*   560 */    91,   91,   38,   91,   56,   41,   58,   43,   44,   45,
 /*   570 */    91,   47,   64,   91,   50,   91,   52,    2,    3,    4,
 /*   580 */     5,    6,    7,    8,    9,   10,   11,   12,   13,   14,
 /*   590 */    15,   21,   91,   23,   24,   91,   91,   22,   28,   91,
 /*   600 */    30,   91,   32,   91,   34,   91,   91,   91,   38,   91,
 /*   610 */    91,   41,   91,   43,   91,   45,   91,   47,   91,   91,
 /*   620 */    50,   91,   52,   91,    3,    4,    5,    6,    7,    8,
 /*   630 */     9,   10,   11,   12,   13,   14,   15,    4,    5,    6,
 /*   640 */     7,    8,    9,   10,   11,   12,   13,   14,   15,   71,
 /*   650 */    91,   91,   74,   75,   76,   77,   78,   79,   80,   81,
 /*   660 */    82,   22,   91,   85,   22,   91,   91,   28,   29,   30,
 /*   670 */    28,   29,   30,   91,   91,   36,   91,   91,   22,   91,
 /*   680 */    91,   28,   91,   30,   28,   91,   30,   91,   49,   91,
 /*   690 */    91,   49,   36,   91,   91,   56,   91,   58,   56,   91,
 /*   700 */    58,   91,   49,   64,   91,   49,   64,   72,   91,   56,
 /*   710 */    91,   58,   56,   28,   58,   30,   72,   64,   83,   91,
 /*   720 */    64,   86,   87,   88,   89,   91,   91,   83,   91,   91,
 /*   730 */    86,   87,   88,   89,   49,   91,   72,   91,   91,   91,
 /*   740 */    91,   56,   91,   58,   72,   91,   91,   83,   91,   64,
 /*   750 */    86,   87,   88,   89,   72,   83,   91,   91,   86,   87,
 /*   760 */    88,   89,   91,   91,   72,   83,   91,   91,   86,   87,
 /*   770 */    88,   89,   91,   72,   91,   83,   91,   91,   86,   87,
 /*   780 */    88,   89,   72,   91,   83,   72,   91,   86,   87,   88,
 /*   790 */    89,    1,   91,   83,   91,    1,   83,   87,   88,   89,
 /*   800 */    87,   88,   89,    1,   91,   91,   16,   17,    1,   19,
 /*   810 */    16,   17,    1,   19,   91,   91,   91,   91,   16,   17,
 /*   820 */     1,   19,   91,   16,   17,    1,   19,   16,   17,    1,
 /*   830 */    19,   91,   91,   91,   91,   16,   17,    1,   19,   91,
 /*   840 */    16,   17,    1,   19,   16,   17,    1,   19,   91,   91,
 /*   850 */    91,   91,   16,   17,    1,   19,   91,   16,   17,    1,
 /*   860 */    19,   16,   17,    1,   19,   91,   91,   91,   91,   16,
 /*   870 */    17,    1,   19,   91,   16,   17,    1,   19,   16,   17,
 /*   880 */     1,   19,   91,   91,   91,   91,   16,   17,    1,   19,
 /*   890 */    91,   16,   17,    1,   19,   16,   17,    1,   19,   91,
 /*   900 */    91,   91,   91,   16,   17,   91,   19,   91,   16,   17,
 /*   910 */    91,   19,   16,   17,   91,   19,
);
    const YY_SHIFT_USE_DFLT = -22;
    const YY_SHIFT_MAX = 165;
    static public $yy_shift_ofst = array(
 /*     0 */   -22,  112,  137,   62,  -21,   87,    4,   37,  187,  212,
 /*    10 */   295,  457,  411,  386,  353,  237,  320,  524,  499,  270,
 /*    20 */   162,  570,  454,  454,  454,  454,  454,  454,  454,  653,
 /*    30 */   653,  653,  653,  642,  508,  639,  656,  685,  685,  685,
 /*    40 */   685,  685,   27,   27,   27,   27,   27,   27,  824,  828,
 /*    50 */   -12,  807,  875,  819,  836,  -18,  879,  887,  896,  862,
 /*    60 */   858,  845,  853,  870,  892,  841,  794,  790,   47,  802,
 /*    70 */   811,   27,   27,   27,   27,   27,   27,   27,   27,  342,
 /*    80 */   342,  -22,  -22,  -22,  -22,  -22,  -22,  -22,  -22,  -22,
 /*    90 */   -22,  -22,  -22,  -22,  -22,  -22,  -22,  -22,  -22,  -22,
 /*   100 */   -22,  575,  462,  621,  633,  633,    5,   84,  136,  105,
 /*   110 */    66,   55,   30,  159,  180,  141,  205,   78,  277,  144,
 /*   120 */   -20,   57,   78,   59,  198,  -17,  195,  319,  245,  266,
 /*   130 */   259,  252,  312,  327,  104,   58,   79,  229,  389,  397,
 /*   140 */   371,  404,  418,  406,  310,  425,  359,  382,  338,   94,
 /*   150 */    -8,  273,  261,  -14,   31,  292,  315,  204,  308,  117,
 /*   160 */   255,  216,  317,  125,  302,   51,
);
    const YY_REDUCE_USE_DFLT = -70;
    const YY_REDUCE_MAX = 100;
    static public $yy_reduce_ofst = array(
 /*     0 */   287,  578,  578,  578,  578,  578,  578,  578,  578,  578,
 /*    10 */   578,  578,  578,  578,  578,  578,  578,  578,  578,  578,
 /*    20 */   578,  578,  644,  692,  701,  682,  672,  635,  664,  334,
 /*    30 */   710,  301,  713,   90,   65,  183,  183,  190,  158,  -50,
 /*    40 */   140,  203,  263,  238,  218,  224,  281,  -53,  -69,  -69,
 /*    50 */   274,  -69,  -69,  -69,  -69,  303,  -69,  -69,  -69,  -69,
 /*    60 */   -69,  -69,  -69,  -69,  -69,  -69,  -69,  -69,  -69,  -69,
 /*    70 */   -69,  226,  276,  299,  297,  288,  279,  285,  309,  358,
 /*    80 */   340,  375,  377,  381,  373,  330,  328,  326,  306,  339,
 /*    90 */   346,  344,  343,  234,   76,   54,  103,  147,  126,  124,
 /*   100 */    -7,
);
    static public $yyExpectedTokens = array(
        /* 0 */ array(),
        /* 1 */ array(21, 23, 24, 28, 30, 32, 34, 38, 40, 41, 43, 44, 45, 47, 50, 52, ),
        /* 2 */ array(21, 23, 24, 28, 30, 32, 34, 38, 39, 40, 41, 43, 45, 47, 50, 52, ),
        /* 3 */ array(21, 23, 24, 28, 30, 32, 34, 38, 40, 41, 42, 43, 45, 47, 50, 52, ),
        /* 4 */ array(21, 23, 24, 28, 30, 32, 34, 38, 40, 41, 42, 43, 45, 47, 50, 52, ),
        /* 5 */ array(21, 23, 24, 28, 30, 32, 34, 35, 37, 38, 41, 43, 45, 47, 50, 52, ),
        /* 6 */ array(21, 23, 24, 28, 30, 32, 34, 38, 40, 41, 43, 45, 46, 47, 50, 52, ),
        /* 7 */ array(21, 23, 24, 28, 30, 32, 34, 35, 37, 38, 41, 43, 45, 47, 50, 52, ),
        /* 8 */ array(21, 23, 24, 28, 30, 31, 32, 34, 38, 41, 43, 45, 47, 50, 52, ),
        /* 9 */ array(21, 23, 24, 28, 30, 32, 34, 38, 41, 42, 43, 45, 47, 50, 52, ),
        /* 10 */ array(21, 23, 24, 28, 30, 32, 33, 34, 38, 41, 43, 45, 47, 50, 52, ),
        /* 11 */ array(21, 23, 24, 28, 30, 32, 34, 38, 39, 41, 43, 45, 47, 50, 52, ),
        /* 12 */ array(21, 23, 24, 28, 30, 32, 34, 38, 41, 42, 43, 45, 47, 50, 52, ),
        /* 13 */ array(21, 23, 24, 28, 30, 32, 34, 38, 41, 43, 45, 47, 50, 51, 52, ),
        /* 14 */ array(21, 23, 24, 28, 30, 32, 34, 38, 41, 43, 45, 47, 48, 50, 52, ),
        /* 15 */ array(21, 23, 24, 28, 30, 32, 34, 38, 41, 43, 45, 47, 48, 50, 52, ),
        /* 16 */ array(21, 23, 24, 28, 30, 32, 34, 38, 41, 43, 45, 46, 47, 50, 52, ),
        /* 17 */ array(21, 23, 24, 28, 30, 32, 34, 38, 41, 43, 44, 45, 47, 50, 52, ),
        /* 18 */ array(21, 23, 24, 27, 28, 30, 32, 34, 38, 41, 43, 45, 47, 50, 52, ),
        /* 19 */ array(21, 23, 24, 28, 30, 32, 34, 35, 38, 41, 43, 45, 47, 50, 52, ),
        /* 20 */ array(21, 23, 24, 28, 30, 32, 34, 35, 38, 41, 43, 45, 47, 50, 52, ),
        /* 21 */ array(21, 23, 24, 28, 30, 32, 34, 38, 41, 43, 45, 47, 50, 52, ),
        /* 22 */ array(28, 30, 49, 56, 58, 61, 64, ),
        /* 23 */ array(28, 30, 49, 56, 58, 61, 64, ),
        /* 24 */ array(28, 30, 49, 56, 58, 61, 64, ),
        /* 25 */ array(28, 30, 49, 56, 58, 61, 64, ),
        /* 26 */ array(28, 30, 49, 56, 58, 61, 64, ),
        /* 27 */ array(28, 30, 49, 56, 58, 61, 64, ),
        /* 28 */ array(28, 30, 49, 56, 58, 61, 64, ),
        /* 29 */ array(28, 30, 49, 56, 58, 64, ),
        /* 30 */ array(28, 30, 49, 56, 58, 64, ),
        /* 31 */ array(28, 30, 49, 56, 58, 64, ),
        /* 32 */ array(28, 30, 49, 56, 58, 64, ),
        /* 33 */ array(22, 28, 29, 30, 49, 56, 58, 64, ),
        /* 34 */ array(22, 28, 30, 49, 56, 58, 64, ),
        /* 35 */ array(22, 28, 29, 30, 36, 49, 56, 58, 64, ),
        /* 36 */ array(22, 28, 30, 36, 49, 56, 58, 64, ),
        /* 37 */ array(28, 30, 49, 56, 58, 64, ),
        /* 38 */ array(28, 30, 49, 56, 58, 64, ),
        /* 39 */ array(28, 30, 49, 56, 58, 64, ),
        /* 40 */ array(28, 30, 49, 56, 58, 64, ),
        /* 41 */ array(28, 30, 49, 56, 58, 64, ),
        /* 42 */ array(28, 30, 64, ),
        /* 43 */ array(28, 30, 64, ),
        /* 44 */ array(28, 30, 64, ),
        /* 45 */ array(28, 30, 64, ),
        /* 46 */ array(28, 30, 64, ),
        /* 47 */ array(28, 30, 64, ),
        /* 48 */ array(1, 16, 17, 19, ),
        /* 49 */ array(1, 16, 17, 19, ),
        /* 50 */ array(28, 30, 49, 64, ),
        /* 51 */ array(1, 16, 17, 19, ),
        /* 52 */ array(1, 16, 17, 19, ),
        /* 53 */ array(1, 16, 17, 19, ),
        /* 54 */ array(1, 16, 17, 19, ),
        /* 55 */ array(22, 28, 30, 64, ),
        /* 56 */ array(1, 16, 17, 19, ),
        /* 57 */ array(1, 16, 17, 19, ),
        /* 58 */ array(1, 16, 17, 19, ),
        /* 59 */ array(1, 16, 17, 19, ),
        /* 60 */ array(1, 16, 17, 19, ),
        /* 61 */ array(1, 16, 17, 19, ),
        /* 62 */ array(1, 16, 17, 19, ),
        /* 63 */ array(1, 16, 17, 19, ),
        /* 64 */ array(1, 16, 17, 19, ),
        /* 65 */ array(1, 16, 17, 19, ),
        /* 66 */ array(1, 16, 17, 19, ),
        /* 67 */ array(1, 16, 17, 19, ),
        /* 68 */ array(1, 16, 17, 19, ),
        /* 69 */ array(1, 16, 17, 19, ),
        /* 70 */ array(1, 16, 17, 19, ),
        /* 71 */ array(28, 30, 64, ),
        /* 72 */ array(28, 30, 64, ),
        /* 73 */ array(28, 30, 64, ),
        /* 74 */ array(28, 30, 64, ),
        /* 75 */ array(28, 30, 64, ),
        /* 76 */ array(28, 30, 64, ),
        /* 77 */ array(28, 30, 64, ),
        /* 78 */ array(28, 30, 64, ),
        /* 79 */ array(60, ),
        /* 80 */ array(60, ),
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
        /* 98 */ array(),
        /* 99 */ array(),
        /* 100 */ array(),
        /* 101 */ array(2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 22, ),
        /* 102 */ array(2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 62, ),
        /* 103 */ array(3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, ),
        /* 104 */ array(4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, ),
        /* 105 */ array(4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, ),
        /* 106 */ array(10, 36, 63, 65, ),
        /* 107 */ array(13, 14, 15, ),
        /* 108 */ array(55, 63, 65, ),
        /* 109 */ array(22, 63, 65, ),
        /* 110 */ array(22, 63, 65, ),
        /* 111 */ array(22, 63, 65, ),
        /* 112 */ array(29, 63, 65, ),
        /* 113 */ array(29, 63, 65, ),
        /* 114 */ array(22, 63, 65, ),
        /* 115 */ array(10, 63, 65, ),
        /* 116 */ array(22, 63, 65, ),
        /* 117 */ array(63, 65, ),
        /* 118 */ array(20, 54, ),
        /* 119 */ array(22, 54, ),
        /* 120 */ array(25, 26, ),
        /* 121 */ array(22, 49, ),
        /* 122 */ array(63, 65, ),
        /* 123 */ array(22, 54, ),
        /* 124 */ array(22, 54, ),
        /* 125 */ array(57, 60, ),
        /* 126 */ array(53, 54, ),
        /* 127 */ array(59, 60, ),
        /* 128 */ array(54, ),
        /* 129 */ array(22, ),
        /* 130 */ array(22, ),
        /* 131 */ array(22, ),
        /* 132 */ array(22, ),
        /* 133 */ array(22, ),
        /* 134 */ array(22, ),
        /* 135 */ array(18, ),
        /* 136 */ array(22, ),
        /* 137 */ array(22, ),
        /* 138 */ array(22, ),
        /* 139 */ array(22, ),
        /* 140 */ array(22, ),
        /* 141 */ array(22, ),
        /* 142 */ array(22, ),
        /* 143 */ array(22, ),
        /* 144 */ array(22, ),
        /* 145 */ array(22, ),
        /* 146 */ array(66, ),
        /* 147 */ array(22, ),
        /* 148 */ array(22, ),
        /* 149 */ array(22, ),
        /* 150 */ array(22, ),
        /* 151 */ array(22, ),
        /* 152 */ array(22, ),
        /* 153 */ array(22, ),
        /* 154 */ array(22, ),
        /* 155 */ array(22, ),
        /* 156 */ array(22, ),
        /* 157 */ array(22, ),
        /* 158 */ array(22, ),
        /* 159 */ array(64, ),
        /* 160 */ array(22, ),
        /* 161 */ array(22, ),
        /* 162 */ array(22, ),
        /* 163 */ array(22, ),
        /* 164 */ array(22, ),
        /* 165 */ array(22, ),
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
);
    static public $yy_default = array(
 /*     0 */   232,  304,  304,  304,  304,  304,  304,  304,  304,  304,
 /*    10 */   304,  304,  304,  304,  304,  304,  304,  304,  304,  304,
 /*    20 */   304,  304,  304,  304,  304,  304,  304,  304,  304,  304,
 /*    30 */   304,  304,  304,  304,  304,  304,  304,  304,  304,  304,
 /*    40 */   304,  304,  304,  304,  304,  304,  304,  304,  304,  304,
 /*    50 */   304,  304,  304,  304,  304,  304,  304,  304,  304,  304,
 /*    60 */   304,  304,  230,  304,  304,  304,  304,  304,  304,  304,
 /*    70 */   304,  304,  304,  304,  304,  304,  304,  304,  304,  304,
 /*    80 */   304,  232,  232,  232,  232,  232,  232,  232,  232,  232,
 /*    90 */   232,  232,  232,  232,  232,  232,  232,  232,  232,  232,
 /*   100 */   232,  304,  304,  293,  296,  294,  304,  295,  279,  304,
 /*   110 */   304,  304,  304,  304,  304,  304,  304,  275,  304,  304,
 /*   120 */   304,  304,  283,  304,  304,  304,  304,  304,  286,  304,
 /*   130 */   304,  304,  304,  304,  304,  304,  304,  304,  304,  304,
 /*   140 */   304,  304,  304,  304,  304,  304,  304,  304,  304,  304,
 /*   150 */   304,  304,  304,  304,  304,  304,  304,  304,  304,  304,
 /*   160 */   304,  304,  304,  304,  304,  304,  288,  298,  299,  263,
 /*   170 */   259,  297,  287,  265,  272,  257,  273,  264,  241,  242,
 /*   180 */   240,  239,  238,  243,  244,  248,  249,  247,  246,  245,
 /*   190 */   303,  302,  300,  284,  237,  233,  231,  285,  289,  301,
 /*   200 */   290,  292,  291,  250,  251,  270,  271,  269,  268,  267,
 /*   210 */   274,  276,  235,  234,  277,  278,  266,  262,  282,  253,
 /*   220 */   281,  280,  252,  254,  255,  261,  260,  258,  256,  236,
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
    const YYNOCODE = 92;
    const YYSTACKDEPTH = 100;
    const YYNSTATE = 230;
    const YYNRULE = 74;
    const YYERRORSYMBOL = 67;
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
  '$',             'T_OPEN_TAG',    'T_AND',         'T_OR',        
  'T_EQ',          'T_NE',          'T_GT',          'T_GE',        
  'T_LT',          'T_LE',          'T_IN',          'T_PLUS',      
  'T_MINUS',       'T_TIMES',       'T_DIV',         'T_MOD',       
  'T_HTML',        'T_COMMENT_OPEN',  'T_COMMENT',     'T_PRINT_OPEN',
  'T_PRINT_CLOSE',  'T_EXTENDS',     'T_CLOSE_TAG',   'T_INCLUDE',   
  'T_AUTOESCAPE',  'T_OFF',         'T_ON',          'T_END_AUTOESCAPE',
  'T_CUSTOM_TAG',  'T_AS',          'T_CUSTOM_BLOCK',  'T_CUSTOM_END',
  'T_WITH',        'T_ENDWITH',     'T_FOR',         'T_CLOSEFOR',  
  'T_COMMA',       'T_EMPTY',       'T_IF',          'T_ENDIF',     
  'T_ELSE',        'T_IFCHANGED',   'T_ENDIFCHANGED',  'T_IFEQUAL',   
  'T_END_IFEQUAL',  'T_IFNOTEQUAL',  'T_END_IFNOTEQUAL',  'T_BLOCK',     
  'T_END_BLOCK',   'T_NUMERIC',     'T_FILTER',      'T_END_FILTER',
  'T_REGROUP',     'T_BY',          'T_PIPE',        'T_COLON',     
  'T_STRING_SINGLE_INIT',  'T_STRING_SINGLE_END',  'T_STRING_DOUBLE_INIT',  'T_STRING_DOUBLE_END',
  'T_STRING_CONTENT',  'T_LPARENT',     'T_RPARENT',     'T_DOT',       
  'T_ALPHA',       'T_BRACKETS_OPEN',  'T_BRACKETS_CLOSE',  'error',       
  'start',         'body',          'code',          'stmts',       
  'filtered_var',  'var_or_string',  'stmt',          'for_stmt',    
  'ifchanged_stmt',  'block_stmt',    'filter_stmt',   'if_stmt',     
  'custom_tag',    'alias',         'ifequal',       'varname',     
  'var_list',      'regroup',       'expr',          'fvar_or_string',
  'varname_args',  'string',        's_content',   
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
 /*  26 */ "for_stmt ::= T_FOR varname T_IN filtered_var T_CLOSE_TAG body T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG",
 /*  27 */ "for_stmt ::= T_FOR varname T_COMMA varname T_IN filtered_var T_CLOSE_TAG body T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG",
 /*  28 */ "for_stmt ::= T_FOR varname T_IN filtered_var T_CLOSE_TAG body T_OPEN_TAG T_EMPTY T_CLOSE_TAG body T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG",
 /*  29 */ "for_stmt ::= T_FOR varname T_COMMA varname T_IN filtered_var T_CLOSE_TAG body T_OPEN_TAG T_EMPTY T_CLOSE_TAG body T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG",
 /*  30 */ "if_stmt ::= T_IF expr T_CLOSE_TAG body T_OPEN_TAG T_ENDIF T_CLOSE_TAG",
 /*  31 */ "if_stmt ::= T_IF expr T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIF T_CLOSE_TAG",
 /*  32 */ "ifchanged_stmt ::= T_IFCHANGED T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  33 */ "ifchanged_stmt ::= T_IFCHANGED var_list T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  34 */ "ifchanged_stmt ::= T_IFCHANGED T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  35 */ "ifchanged_stmt ::= T_IFCHANGED var_list T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  36 */ "ifequal ::= T_IFEQUAL fvar_or_string fvar_or_string T_CLOSE_TAG body T_OPEN_TAG T_END_IFEQUAL T_CLOSE_TAG",
 /*  37 */ "ifequal ::= T_IFEQUAL fvar_or_string fvar_or_string T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_END_IFEQUAL T_CLOSE_TAG",
 /*  38 */ "ifequal ::= T_IFNOTEQUAL fvar_or_string fvar_or_string T_CLOSE_TAG body T_OPEN_TAG T_END_IFNOTEQUAL T_CLOSE_TAG",
 /*  39 */ "ifequal ::= T_IFNOTEQUAL fvar_or_string fvar_or_string T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_END_IFNOTEQUAL T_CLOSE_TAG",
 /*  40 */ "block_stmt ::= T_BLOCK varname T_CLOSE_TAG body T_OPEN_TAG T_END_BLOCK T_CLOSE_TAG",
 /*  41 */ "block_stmt ::= T_BLOCK varname T_CLOSE_TAG body T_OPEN_TAG T_END_BLOCK varname T_CLOSE_TAG",
 /*  42 */ "block_stmt ::= T_BLOCK T_NUMERIC T_CLOSE_TAG body T_OPEN_TAG T_END_BLOCK T_CLOSE_TAG",
 /*  43 */ "block_stmt ::= T_BLOCK T_NUMERIC T_CLOSE_TAG body T_OPEN_TAG T_END_BLOCK T_NUMERIC T_CLOSE_TAG",
 /*  44 */ "filter_stmt ::= T_FILTER filtered_var T_CLOSE_TAG body T_OPEN_TAG T_END_FILTER T_CLOSE_TAG",
 /*  45 */ "regroup ::= T_REGROUP filtered_var T_BY varname T_AS varname",
 /*  46 */ "filtered_var ::= filtered_var T_PIPE varname_args",
 /*  47 */ "filtered_var ::= varname_args",
 /*  48 */ "varname_args ::= varname T_COLON var_or_string",
 /*  49 */ "varname_args ::= varname",
 /*  50 */ "var_list ::= var_list var_or_string",
 /*  51 */ "var_list ::= var_list T_COMMA var_or_string",
 /*  52 */ "var_list ::= var_or_string",
 /*  53 */ "var_or_string ::= varname",
 /*  54 */ "var_or_string ::= T_NUMERIC",
 /*  55 */ "var_or_string ::= string",
 /*  56 */ "fvar_or_string ::= filtered_var",
 /*  57 */ "fvar_or_string ::= T_NUMERIC",
 /*  58 */ "fvar_or_string ::= string",
 /*  59 */ "string ::= T_STRING_SINGLE_INIT s_content T_STRING_SINGLE_END",
 /*  60 */ "string ::= T_STRING_DOUBLE_INIT s_content T_STRING_DOUBLE_END",
 /*  61 */ "s_content ::= s_content T_STRING_CONTENT",
 /*  62 */ "s_content ::= T_STRING_CONTENT",
 /*  63 */ "expr ::= expr T_AND expr",
 /*  64 */ "expr ::= expr T_OR expr",
 /*  65 */ "expr ::= expr T_PLUS|T_MINUS expr",
 /*  66 */ "expr ::= expr T_EQ|T_NE|T_GT|T_GE|T_LT|T_LE|T_IN expr",
 /*  67 */ "expr ::= expr T_TIMES|T_DIV|T_MOD expr",
 /*  68 */ "expr ::= T_LPARENT expr T_RPARENT",
 /*  69 */ "expr ::= fvar_or_string",
 /*  70 */ "varname ::= varname T_DOT T_ALPHA",
 /*  71 */ "varname ::= varname T_BRACKETS_OPEN var_or_string T_BRACKETS_CLOSE",
 /*  72 */ "varname ::= T_ALPHA",
 /*  73 */ "varname ::= T_CUSTOM_TAG|T_CUSTOM_BLOCK",
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
  array( 'lhs' => 68, 'rhs' => 1 ),
  array( 'lhs' => 69, 'rhs' => 2 ),
  array( 'lhs' => 69, 'rhs' => 0 ),
  array( 'lhs' => 70, 'rhs' => 2 ),
  array( 'lhs' => 70, 'rhs' => 1 ),
  array( 'lhs' => 70, 'rhs' => 2 ),
  array( 'lhs' => 70, 'rhs' => 3 ),
  array( 'lhs' => 71, 'rhs' => 3 ),
  array( 'lhs' => 71, 'rhs' => 2 ),
  array( 'lhs' => 71, 'rhs' => 1 ),
  array( 'lhs' => 71, 'rhs' => 1 ),
  array( 'lhs' => 71, 'rhs' => 1 ),
  array( 'lhs' => 71, 'rhs' => 1 ),
  array( 'lhs' => 71, 'rhs' => 1 ),
  array( 'lhs' => 71, 'rhs' => 3 ),
  array( 'lhs' => 71, 'rhs' => 1 ),
  array( 'lhs' => 71, 'rhs' => 1 ),
  array( 'lhs' => 71, 'rhs' => 1 ),
  array( 'lhs' => 71, 'rhs' => 7 ),
  array( 'lhs' => 80, 'rhs' => 2 ),
  array( 'lhs' => 80, 'rhs' => 4 ),
  array( 'lhs' => 80, 'rhs' => 3 ),
  array( 'lhs' => 80, 'rhs' => 5 ),
  array( 'lhs' => 80, 'rhs' => 6 ),
  array( 'lhs' => 81, 'rhs' => 9 ),
  array( 'lhs' => 74, 'rhs' => 1 ),
  array( 'lhs' => 75, 'rhs' => 9 ),
  array( 'lhs' => 75, 'rhs' => 11 ),
  array( 'lhs' => 75, 'rhs' => 13 ),
  array( 'lhs' => 75, 'rhs' => 15 ),
  array( 'lhs' => 79, 'rhs' => 7 ),
  array( 'lhs' => 79, 'rhs' => 11 ),
  array( 'lhs' => 76, 'rhs' => 6 ),
  array( 'lhs' => 76, 'rhs' => 7 ),
  array( 'lhs' => 76, 'rhs' => 10 ),
  array( 'lhs' => 76, 'rhs' => 11 ),
  array( 'lhs' => 82, 'rhs' => 8 ),
  array( 'lhs' => 82, 'rhs' => 12 ),
  array( 'lhs' => 82, 'rhs' => 8 ),
  array( 'lhs' => 82, 'rhs' => 12 ),
  array( 'lhs' => 77, 'rhs' => 7 ),
  array( 'lhs' => 77, 'rhs' => 8 ),
  array( 'lhs' => 77, 'rhs' => 7 ),
  array( 'lhs' => 77, 'rhs' => 8 ),
  array( 'lhs' => 78, 'rhs' => 7 ),
  array( 'lhs' => 85, 'rhs' => 6 ),
  array( 'lhs' => 72, 'rhs' => 3 ),
  array( 'lhs' => 72, 'rhs' => 1 ),
  array( 'lhs' => 88, 'rhs' => 3 ),
  array( 'lhs' => 88, 'rhs' => 1 ),
  array( 'lhs' => 84, 'rhs' => 2 ),
  array( 'lhs' => 84, 'rhs' => 3 ),
  array( 'lhs' => 84, 'rhs' => 1 ),
  array( 'lhs' => 73, 'rhs' => 1 ),
  array( 'lhs' => 73, 'rhs' => 1 ),
  array( 'lhs' => 73, 'rhs' => 1 ),
  array( 'lhs' => 87, 'rhs' => 1 ),
  array( 'lhs' => 87, 'rhs' => 1 ),
  array( 'lhs' => 87, 'rhs' => 1 ),
  array( 'lhs' => 89, 'rhs' => 3 ),
  array( 'lhs' => 89, 'rhs' => 3 ),
  array( 'lhs' => 90, 'rhs' => 2 ),
  array( 'lhs' => 90, 'rhs' => 1 ),
  array( 'lhs' => 86, 'rhs' => 3 ),
  array( 'lhs' => 86, 'rhs' => 3 ),
  array( 'lhs' => 86, 'rhs' => 3 ),
  array( 'lhs' => 86, 'rhs' => 3 ),
  array( 'lhs' => 86, 'rhs' => 3 ),
  array( 'lhs' => 86, 'rhs' => 3 ),
  array( 'lhs' => 86, 'rhs' => 1 ),
  array( 'lhs' => 83, 'rhs' => 3 ),
  array( 'lhs' => 83, 'rhs' => 4 ),
  array( 'lhs' => 83, 'rhs' => 1 ),
  array( 'lhs' => 83, 'rhs' => 1 ),
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
        49 => 3,
        62 => 3,
        69 => 3,
        72 => 3,
        73 => 3,
        4 => 4,
        5 => 5,
        6 => 6,
        7 => 7,
        8 => 8,
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
        42 => 40,
        41 => 41,
        43 => 41,
        44 => 44,
        45 => 45,
        46 => 46,
        51 => 46,
        47 => 47,
        52 => 47,
        48 => 48,
        50 => 50,
        53 => 53,
        54 => 54,
        57 => 54,
        55 => 55,
        58 => 55,
        56 => 56,
        59 => 59,
        60 => 59,
        61 => 61,
        63 => 63,
        64 => 63,
        65 => 63,
        67 => 63,
        66 => 66,
        68 => 68,
        70 => 70,
        71 => 71,
    );
    /* Beginning here are the reduction cases.  A typical example
    ** follows:
    **  #line <lineno> <grammarfile>
    **   function yy_r0($yymsp){ ... }           // User supplied code
    **  #line <lineno> <thisfile>
    */
#line 65 "parser.y"
    function yy_r0(){ $this->body = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1499 "parser.php"
#line 67 "parser.y"
    function yy_r1(){ $this->_retvalue=$this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1502 "parser.php"
#line 68 "parser.y"
    function yy_r2(){ $this->_retvalue = array();     }
#line 1505 "parser.php"
#line 71 "parser.y"
    function yy_r3(){ $this->_retvalue = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1508 "parser.php"
#line 72 "parser.y"
    function yy_r4(){ $this->_retvalue = array('operation' => 'html', 'html' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1511 "parser.php"
#line 73 "parser.y"
    function yy_r5(){ $this->yystack[$this->yyidx + 0]->minor=rtrim($this->yystack[$this->yyidx + 0]->minor); $this->_retvalue = array('operation' => 'comment', 'comment' => substr($this->yystack[$this->yyidx + 0]->minor, 0, strlen($this->yystack[$this->yyidx + 0]->minor)-2));     }
#line 1514 "parser.php"
#line 74 "parser.y"
    function yy_r6(){ $this->_retvalue = array('operation' => 'print_var', 'variable' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1517 "parser.php"
#line 76 "parser.y"
    function yy_r7(){ $this->_retvalue = array('operation' => 'base', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1520 "parser.php"
#line 77 "parser.y"
    function yy_r8(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1523 "parser.php"
#line 83 "parser.y"
    function yy_r14(){ $this->_retvalue = array('operation' => 'include', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1526 "parser.php"
#line 87 "parser.y"
    function yy_r18(){ $this->_retvalue = array('operation' => 'autoescape', 'value' => strtolower(@$this->yystack[$this->yyidx + -5]->minor), 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1529 "parser.php"
#line 92 "parser.y"
    function yy_r19(){ $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -1]->minor, 'list'=>array());     }
#line 1532 "parser.php"
#line 93 "parser.y"
    function yy_r20(){ $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -3]->minor, 'as' => $this->yystack[$this->yyidx + -1]->minor, 'list'=>array());     }
#line 1535 "parser.php"
#line 94 "parser.y"
    function yy_r21(){ $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -2]->minor, 'list' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1538 "parser.php"
#line 95 "parser.y"
    function yy_r22(){ $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -4]->minor, 'as' => $this->yystack[$this->yyidx + -1]->minor, 'list' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1541 "parser.php"
#line 97 "parser.y"
    function yy_r23(){ if ('end'.$this->yystack[$this->yyidx + -5]->minor != $this->yystack[$this->yyidx + -1]->minor) { throw new Exception("Unexpected ".$this->yystack[$this->yyidx + -1]->minor); } $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor, 'list' => array());    }
#line 1544 "parser.php"
#line 100 "parser.y"
    function yy_r24(){ $this->_retvalue = array('operation' => 'alias', 'var' => $this->yystack[$this->yyidx + -7]->minor, 'as' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1547 "parser.php"
#line 106 "parser.y"
    function yy_r26(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -7]->minor, 'array' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor, 'index' => NULL); 
    }
#line 1552 "parser.php"
#line 109 "parser.y"
    function yy_r27(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -7]->minor, 'array' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor, 'index' => $this->yystack[$this->yyidx + -9]->minor); 
    }
#line 1557 "parser.php"
#line 112 "parser.y"
    function yy_r28(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -11]->minor, 'array' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'empty' => $this->yystack[$this->yyidx + -3]->minor, 'index' => NULL); 
    }
#line 1562 "parser.php"
#line 115 "parser.y"
    function yy_r29(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -11]->minor, 'array' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'empty' => $this->yystack[$this->yyidx + -3]->minor, 'index' => $this->yystack[$this->yyidx + -13]->minor); 
    }
#line 1567 "parser.php"
#line 119 "parser.y"
    function yy_r30(){ $this->_retvalue = array('operation' => 'if', 'expr' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1570 "parser.php"
#line 120 "parser.y"
    function yy_r31(){ $this->_retvalue = array('operation' => 'if', 'expr' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1573 "parser.php"
#line 123 "parser.y"
    function yy_r32(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1578 "parser.php"
#line 127 "parser.y"
    function yy_r33(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -3]->minor, 'check' => $this->yystack[$this->yyidx + -5]->minor);
    }
#line 1583 "parser.php"
#line 130 "parser.y"
    function yy_r34(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1588 "parser.php"
#line 134 "parser.y"
    function yy_r35(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -7]->minor, 'check' => $this->yystack[$this->yyidx + -9]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);
    }
#line 1593 "parser.php"
#line 139 "parser.y"
    function yy_r36(){  $this->_retvalue = array('operation' => 'ifequal', 'cmp' => '==', 1 => $this->yystack[$this->yyidx + -6]->minor, 2 => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1596 "parser.php"
#line 140 "parser.y"
    function yy_r37(){  $this->_retvalue = array('operation' => 'ifequal', 'cmp' => '==', 1 => $this->yystack[$this->yyidx + -10]->minor, 2 => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1599 "parser.php"
#line 141 "parser.y"
    function yy_r38(){  $this->_retvalue = array('operation' => 'ifequal', 'cmp' => '!=', 1 => $this->yystack[$this->yyidx + -6]->minor, 2 => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1602 "parser.php"
#line 142 "parser.y"
    function yy_r39(){  $this->_retvalue = array('operation' => 'ifequal', 'cmp' => '!=', 1 => $this->yystack[$this->yyidx + -10]->minor, 2 => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1605 "parser.php"
#line 146 "parser.y"
    function yy_r40(){ $this->_retvalue = array('operation' => 'block', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1608 "parser.php"
#line 148 "parser.y"
    function yy_r41(){ $this->_retvalue = array('operation' => 'block', 'name' => $this->yystack[$this->yyidx + -6]->minor, 'body' => $this->yystack[$this->yyidx + -4]->minor);     }
#line 1611 "parser.php"
#line 155 "parser.y"
    function yy_r44(){ $this->_retvalue = array('operation' => 'filter', 'functions' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1614 "parser.php"
#line 158 "parser.y"
    function yy_r45(){ $this->_retvalue=array('operation' => 'regroup', 'array' => $this->yystack[$this->yyidx + -4]->minor, 'row' => $this->yystack[$this->yyidx + -2]->minor, 'as' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1617 "parser.php"
#line 161 "parser.y"
    function yy_r46(){ $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1620 "parser.php"
#line 162 "parser.y"
    function yy_r47(){ $this->_retvalue = array($this->yystack[$this->yyidx + 0]->minor);     }
#line 1623 "parser.php"
#line 164 "parser.y"
    function yy_r48(){ $this->_retvalue = array($this->yystack[$this->yyidx + -2]->minor, 'args'=>array($this->yystack[$this->yyidx + 0]->minor));     }
#line 1626 "parser.php"
#line 168 "parser.y"
    function yy_r50(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1629 "parser.php"
#line 174 "parser.y"
    function yy_r53(){ $this->_retvalue = array('var' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1632 "parser.php"
#line 175 "parser.y"
    function yy_r54(){ $this->_retvalue = array('number' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1635 "parser.php"
#line 176 "parser.y"
    function yy_r55(){ $this->_retvalue = array('string' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1638 "parser.php"
#line 178 "parser.y"
    function yy_r56(){ $this->_retvalue = array('var_filter' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1641 "parser.php"
#line 183 "parser.y"
    function yy_r59(){  $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1644 "parser.php"
#line 185 "parser.y"
    function yy_r61(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor.$this->yystack[$this->yyidx + 0]->minor;     }
#line 1647 "parser.php"
#line 189 "parser.y"
    function yy_r63(){ $this->_retvalue = array('op_expr' => @$this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1650 "parser.php"
#line 192 "parser.y"
    function yy_r66(){ $this->_retvalue = array('op_expr' => trim(@$this->yystack[$this->yyidx + -1]->minor), $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1653 "parser.php"
#line 194 "parser.y"
    function yy_r68(){ $this->_retvalue = array('op_expr' => 'expr', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1656 "parser.php"
#line 198 "parser.y"
    function yy_r70(){ if (!is_array($this->yystack[$this->yyidx + -2]->minor)) { $this->_retvalue = array($this->yystack[$this->yyidx + -2]->minor); } else { $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; }  $this->_retvalue[]=$this->yystack[$this->yyidx + 0]->minor;    }
#line 1659 "parser.php"
#line 199 "parser.y"
    function yy_r71(){ if (!is_array($this->yystack[$this->yyidx + -3]->minor)) { $this->_retvalue = array($this->yystack[$this->yyidx + -3]->minor); } else { $this->_retvalue = $this->yystack[$this->yyidx + -3]->minor; }  $this->_retvalue[]=$this->yystack[$this->yyidx + -1]->minor;    }
#line 1662 "parser.php"

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
#line 56 "parser.y"

    $expect = array();
    foreach ($this->yy_get_expected_tokens($yymajor) as $token) {
        $expect[] = self::$yyTokenName[$token];
    }
    throw new Exception('Unexpected ' . $this->tokenName($yymajor) . '(' . $TOKEN. '), expected one of: ' . implode(',', $expect));
#line 1782 "parser.php"
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
#line 44 "parser.y"

#line 1803 "parser.php"
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