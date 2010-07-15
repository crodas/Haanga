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
    const T_FOR                          = 29;
    const T_AS                           = 30;
    const T_CUSTOM_BLOCK                 = 31;
    const T_CUSTOM_END                   = 32;
    const T_WITH                         = 33;
    const T_ENDWITH                      = 34;
    const T_CLOSEFOR                     = 35;
    const T_COMMA                        = 36;
    const T_EMPTY                        = 37;
    const T_IF                           = 38;
    const T_ENDIF                        = 39;
    const T_ELSE                         = 40;
    const T_IFCHANGED                    = 41;
    const T_ENDIFCHANGED                 = 42;
    const T_BLOCK                        = 43;
    const T_END_BLOCK                    = 44;
    const T_FILTER                       = 45;
    const T_END_FILTER                   = 46;
    const T_REGROUP                      = 47;
    const T_BY                           = 48;
    const T_CYCLE                        = 49;
    const T_FIRST_OF                     = 50;
    const T_PIPE                         = 51;
    const T_COLON                        = 52;
    const T_NUMERIC                      = 53;
    const T_STRING_SINGLE_INIT           = 54;
    const T_STRING_SINGLE_END            = 55;
    const T_STRING_DOUBLE_INIT           = 56;
    const T_STRING_DOUBLE_END            = 57;
    const T_STRING_CONTENT               = 58;
    const T_LPARENT                      = 59;
    const T_RPARENT                      = 60;
    const T_DOT                          = 61;
    const T_ALPHA                        = 62;
    const T_BRACKETS_OPEN                = 63;
    const T_BRACKETS_CLOSE               = 64;
    const T_CUSTOM                       = 65;
    const YY_NO_ACTION = 281;
    const YY_ACCEPT_ACTION = 280;
    const YY_ERROR_ACTION = 279;

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
    const YY_SZ_ACTTAB = 794;
static public $yy_action = array(
 /*     0 */    32,   55,   35,  112,   75,  168,  171,   24,   67,  107,
 /*    10 */   133,   53,   57,   65,   80,  199,   36,   20,   66,  144,
 /*    20 */    25,  142,   63,  160,   38,  129,   62,   33,   27,   26,
 /*    30 */    32,  153,   35,  112,  129,  184,   33,   24,   67,   58,
 /*    40 */   133,  110,   57,  129,  147,   33,   81,   20,  127,  140,
 /*    50 */    25,  107,   63,  129,   38,   33,   62,  203,   27,   26,
 /*    60 */    32,   48,   35,  112,  129,   86,   33,   24,   67,  129,
 /*    70 */   133,   33,   57,  280,   49,  146,  191,   20,  147,  119,
 /*    80 */    25,  125,   63,  149,   38,   83,   62,  201,   27,   26,
 /*    90 */    32,   39,   35,  112,   39,  178,  117,   24,   67,  189,
 /*   100 */   133,  114,   57,  165,  128,   76,  137,   20,  117,   29,
 /*   110 */    25,  107,   63,   82,   38,  165,   62,  203,   27,   26,
 /*   120 */    32,  164,   35,  112,  129,  173,   33,   24,   67,  189,
 /*   130 */   133,   77,   57,   69,  123,  179,  121,   20,  117,   31,
 /*   140 */    25,   64,   63,   87,   38,  165,   62,  186,   27,   26,
 /*   150 */    32,  109,   35,  112,  129,  147,   33,   24,   67,  189,
 /*   160 */   133,  185,   57,  196,  129,   60,   33,   20,  117,   28,
 /*   170 */    25,  156,   63,   52,   38,  165,   62,  177,   27,   26,
 /*   180 */    32,  170,   35,  112,  171,  189,  146,   24,   67,  147,
 /*   190 */   133,  135,   57,   61,  117,   30,  129,   20,   33,  159,
 /*   200 */    25,  165,   63,   88,   38,  204,   62,  169,   27,   26,
 /*   210 */    32,   41,   35,  112,  117,  157,  202,   24,   67,  136,
 /*   220 */   133,  165,   57,  131,  129,   85,   33,   20,  117,  188,
 /*   230 */    25,  194,   63,  182,   38,  165,   62,  181,   27,   26,
 /*   240 */   190,   23,   21,   17,   17,   17,   17,   17,   17,   17,
 /*   250 */    19,   19,   22,   22,   22,  129,   32,   33,   35,  112,
 /*   260 */    22,   22,   22,   24,   67,  134,  133,  187,   57,  163,
 /*   270 */   130,   39,  162,   20,  117,  115,   25,   99,   63,   94,
 /*   280 */    38,  165,   62,   97,   27,   26,   32,   95,   35,  112,
 /*   290 */    46,  200,  141,   24,   67,  143,  133,   44,   57,  172,
 /*   300 */   117,  113,  116,   20,  117,  103,   25,  165,   63,  105,
 /*   310 */    38,  165,   62,  104,   27,   26,   32,  111,   35,  112,
 /*   320 */    40,  139,  139,   24,   67,  106,  133,  197,   57,  102,
 /*   330 */   126,   47,  108,   20,  183,   96,   25,  100,   63,   98,
 /*   340 */    38,   51,   62,   54,   27,   26,   45,   23,   21,   17,
 /*   350 */    17,   17,   17,   17,   17,   17,   19,   19,   22,   22,
 /*   360 */    22,  122,   32,  165,   35,  112,  129,   74,   33,   24,
 /*   370 */    67,  107,  133,  129,   57,   33,   92,  203,  167,   20,
 /*   380 */   165,   50,   25,   56,   63,   42,   38,  124,   62,   43,
 /*   390 */    27,   26,   32,  165,   35,  112,   84,  192,  165,   24,
 /*   400 */    67,  165,  133,  165,   57,  165,  165,  165,  165,   20,
 /*   410 */   145,  165,   25,  165,   63,  165,   38,  165,   62,  165,
 /*   420 */    27,   26,   32,  165,   35,  112,  165,  165,  165,   24,
 /*   430 */    67,  165,  133,  165,   57,  129,  129,   33,   33,   20,
 /*   440 */   165,  165,   25,  120,   63,  165,   38,  165,   62,  165,
 /*   450 */    27,   26,   32,  165,   35,  112,  165,  165,  165,   24,
 /*   460 */    67,  165,  133,  165,   57,  165,  165,  165,  165,   20,
 /*   470 */   165,  165,   25,  138,   63,  165,   38,  165,   62,  165,
 /*   480 */    27,   26,   32,  165,   35,  112,  165,  165,  165,   24,
 /*   490 */    67,  165,  133,  165,   57,  165,  165,  165,  165,   20,
 /*   500 */   165,  165,   25,  165,   63,  165,   38,  165,   62,  165,
 /*   510 */    27,   26,   21,   17,   17,   17,   17,   17,   17,   17,
 /*   520 */    19,   19,   22,   22,   22,  161,  165,   78,  132,  150,
 /*   530 */   155,  154,  151,  152,  205,  195,  147,  165,  174,  175,
 /*   540 */   176,   34,  165,   17,   17,   17,   17,   17,   17,   17,
 /*   550 */    19,   19,   22,   22,   22,  193,  165,  165,  158,   73,
 /*   560 */   165,   72,   68,   70,  147,  165,  165,  146,  198,  165,
 /*   570 */   147,  165,   79,  165,  165,  165,   71,  147,  165,  165,
 /*   580 */   165,  147,   34,  165,  165,  165,  158,   73,  165,   72,
 /*   590 */    59,  147,  165,  165,  165,  146,   34,  165,  147,  158,
 /*   600 */    73,  165,   72,  158,   73,  165,   72,  165,  146,  147,
 /*   610 */   165,  147,  146,  158,   73,  147,   72,  165,  165,  147,
 /*   620 */   165,  165,  146,  147,   34,  147,  165,  165,  165,  165,
 /*   630 */   165,  166,   73,  165,   72,  165,  165,   18,  165,  165,
 /*   640 */   146,  158,   73,  147,   72,  158,   73,    8,   72,  165,
 /*   650 */   146,  165,  165,  147,  146,  165,  165,  147,  122,  165,
 /*   660 */   165,  122,  180,  118,  165,   37,  165,  165,  107,  165,
 /*   670 */   122,  107,  165,   93,  203,  167,  101,  203,  167,  165,
 /*   680 */   107,  122,  165,  165,  122,   90,  203,  167,    9,  165,
 /*   690 */   165,  107,  165,  165,  107,  122,   91,  203,  167,   89,
 /*   700 */   203,  167,    6,  180,  118,  107,   37,    5,  165,  165,
 /*   710 */   148,  203,  167,   14,  165,  165,  165,  180,  118,   13,
 /*   720 */    37,  165,  180,  118,   11,   37,  165,  165,  180,  118,
 /*   730 */     1,   37,  165,  165,  180,  118,    3,   37,  165,  180,
 /*   740 */   118,    4,   37,  165,  165,  180,  118,    2,   37,  165,
 /*   750 */   165,  180,  118,   15,   37,  165,  180,  118,   12,   37,
 /*   760 */   165,  165,  180,  118,    7,   37,  165,  165,  180,  118,
 /*   770 */    16,   37,  165,  180,  118,   10,   37,  165,  165,  180,
 /*   780 */   118,  165,   37,  165,  165,  180,  118,  165,   37,  165,
 /*   790 */   180,  118,  165,   37,
    );
    static public $yy_lookahead = array(
 /*     0 */    21,   68,   23,   24,   22,   57,   58,   28,   29,   81,
 /*    10 */    31,   68,   33,   10,   22,   87,   52,   38,   10,   40,
 /*    20 */    41,   42,   43,   22,   45,   61,   47,   63,   49,   50,
 /*    30 */    21,   64,   23,   24,   61,   22,   63,   28,   29,   36,
 /*    40 */    31,   71,   33,   61,   31,   63,   22,   38,   39,   40,
 /*    50 */    41,   81,   43,   61,   45,   63,   47,   87,   49,   50,
 /*    60 */    21,   68,   23,   24,   61,   22,   63,   28,   29,   61,
 /*    70 */    31,   63,   33,   67,   68,   62,   22,   38,   65,   40,
 /*    80 */    41,   42,   43,   22,   45,   22,   47,   72,   49,   50,
 /*    90 */    21,   51,   23,   24,   51,   22,   81,   28,   29,   72,
 /*   100 */    31,   71,   33,   88,   35,   22,   37,   38,   81,   82,
 /*   110 */    41,   81,   43,   22,   45,   88,   47,   87,   49,   50,
 /*   120 */    21,   62,   23,   24,   61,   22,   63,   28,   29,   72,
 /*   130 */    31,   22,   33,   30,   35,   18,   37,   38,   81,   82,
 /*   140 */    41,   48,   43,   22,   45,   88,   47,   22,   49,   50,
 /*   150 */    21,   81,   23,   24,   61,   31,   63,   28,   29,   72,
 /*   160 */    31,   22,   33,   22,   61,   30,   63,   38,   81,   82,
 /*   170 */    41,   22,   43,   44,   45,   88,   47,   22,   49,   50,
 /*   180 */    21,   55,   23,   24,   58,   72,   62,   28,   29,   65,
 /*   190 */    31,   32,   33,   30,   81,   82,   61,   38,   63,   22,
 /*   200 */    41,   88,   43,   22,   45,   72,   47,   22,   49,   50,
 /*   210 */    21,   68,   23,   24,   81,   58,   22,   28,   29,   72,
 /*   220 */    31,   88,   33,   34,   61,   22,   63,   38,   81,   22,
 /*   230 */    41,   22,   43,   22,   45,   88,   47,   22,   49,   50,
 /*   240 */    20,    2,    3,    4,    5,    6,    7,    8,    9,   10,
 /*   250 */    11,   12,   13,   14,   15,   61,   21,   63,   23,   24,
 /*   260 */    13,   14,   15,   28,   29,   72,   31,   22,   33,   69,
 /*   270 */    35,   51,   22,   38,   81,   89,   41,   81,   43,   81,
 /*   280 */    45,   88,   47,   81,   49,   50,   21,   81,   23,   24,
 /*   290 */    68,   72,   27,   28,   29,   72,   31,   68,   33,   60,
 /*   300 */    81,   89,   81,   38,   81,   81,   41,   88,   43,   81,
 /*   310 */    45,   88,   47,   81,   49,   50,   21,   81,   23,   24,
 /*   320 */    68,   25,   26,   28,   29,   81,   31,   22,   33,   81,
 /*   330 */    35,   68,   81,   38,   22,   81,   41,   81,   43,   81,
 /*   340 */    45,   68,   47,   68,   49,   50,   68,    2,    3,    4,
 /*   350 */     5,    6,    7,    8,    9,   10,   11,   12,   13,   14,
 /*   360 */    15,   71,   21,   90,   23,   24,   61,   22,   63,   28,
 /*   370 */    29,   81,   31,   61,   33,   63,   86,   87,   88,   38,
 /*   380 */    90,   68,   41,   68,   43,   68,   45,   46,   47,   68,
 /*   390 */    49,   50,   21,   90,   23,   24,   22,   22,   90,   28,
 /*   400 */    29,   90,   31,   90,   33,   90,   90,   90,   90,   38,
 /*   410 */    39,   90,   41,   90,   43,   90,   45,   90,   47,   90,
 /*   420 */    49,   50,   21,   90,   23,   24,   90,   90,   90,   28,
 /*   430 */    29,   90,   31,   90,   33,   61,   61,   63,   63,   38,
 /*   440 */    90,   90,   41,   42,   43,   90,   45,   90,   47,   90,
 /*   450 */    49,   50,   21,   90,   23,   24,   90,   90,   90,   28,
 /*   460 */    29,   90,   31,   90,   33,   90,   90,   90,   90,   38,
 /*   470 */    90,   90,   41,   42,   43,   90,   45,   90,   47,   90,
 /*   480 */    49,   50,   21,   90,   23,   24,   90,   90,   90,   28,
 /*   490 */    29,   90,   31,   90,   33,   90,   90,   90,   90,   38,
 /*   500 */    90,   90,   41,   90,   43,   90,   45,   90,   47,   90,
 /*   510 */    49,   50,    3,    4,    5,    6,    7,    8,    9,   10,
 /*   520 */    11,   12,   13,   14,   15,   70,   90,   22,   73,   74,
 /*   530 */    75,   76,   77,   78,   79,   80,   31,   90,   83,   84,
 /*   540 */    85,   36,   90,    4,    5,    6,    7,    8,    9,   10,
 /*   550 */    11,   12,   13,   14,   15,   22,   90,   90,   53,   54,
 /*   560 */    90,   56,   29,   30,   31,   90,   90,   62,   22,   90,
 /*   570 */    65,   90,   22,   90,   90,   90,   30,   31,   90,   90,
 /*   580 */    90,   31,   36,   90,   90,   90,   53,   54,   90,   56,
 /*   590 */    30,   31,   90,   90,   90,   62,   36,   90,   65,   53,
 /*   600 */    54,   90,   56,   53,   54,   90,   56,   90,   62,   31,
 /*   610 */    90,   65,   62,   53,   54,   65,   56,   90,   90,   31,
 /*   620 */    90,   90,   62,   31,   36,   65,   90,   90,   90,   90,
 /*   630 */    90,   53,   54,   90,   56,   90,   90,   59,   90,   90,
 /*   640 */    62,   53,   54,   65,   56,   53,   54,    1,   56,   90,
 /*   650 */    62,   90,   90,   65,   62,   90,   90,   65,   71,   90,
 /*   660 */    90,   71,   16,   17,   90,   19,   90,   90,   81,   90,
 /*   670 */    71,   81,   90,   86,   87,   88,   86,   87,   88,   90,
 /*   680 */    81,   71,   90,   90,   71,   86,   87,   88,    1,   90,
 /*   690 */    90,   81,   90,   90,   81,   71,   86,   87,   88,   86,
 /*   700 */    87,   88,    1,   16,   17,   81,   19,    1,   90,   90,
 /*   710 */    86,   87,   88,    1,   90,   90,   90,   16,   17,    1,
 /*   720 */    19,   90,   16,   17,    1,   19,   90,   90,   16,   17,
 /*   730 */     1,   19,   90,   90,   16,   17,    1,   19,   90,   16,
 /*   740 */    17,    1,   19,   90,   90,   16,   17,    1,   19,   90,
 /*   750 */    90,   16,   17,    1,   19,   90,   16,   17,    1,   19,
 /*   760 */    90,   90,   16,   17,    1,   19,   90,   90,   16,   17,
 /*   770 */     1,   19,   90,   16,   17,    1,   19,   90,   90,   16,
 /*   780 */    17,   90,   19,   90,   90,   16,   17,   90,   19,   90,
 /*   790 */    16,   17,   90,   19,
);
    const YY_SHIFT_USE_DFLT = -53;
    const YY_SHIFT_MAX = 145;
    static public $yy_shift_ofst = array(
 /*     0 */   -53,   99,   39,   69,  -21,    9,  431,  401,  265,  189,
 /*    10 */   159,  129,  235,  371,  295,  341,  461,  578,  578,  578,
 /*    20 */   578,  578,  578,  578,  533,  550,  592,  592,  546,  560,
 /*    30 */   505,  588,  592,  592,  592,  592,  592,  124,  124,  124,
 /*    40 */   774,  746,  718,  729,  706,  687,  735,  757,  752,  769,
 /*    50 */   763,  740,   13,  701,  646,  712,  723,  124,  124,  124,
 /*    60 */   124,  124,  124,  124,  124,  124,  124,  124,  124,  124,
 /*    70 */   124,  124,  157,  157,  -53,  -53,  -53,  -53,  -53,  -53,
 /*    80 */   -53,  -53,  -53,  -53,  -53,  -53,  -53,  -53,  -53,  239,
 /*    90 */   345,  509,  539,  539,  103,    3,  374,  375,  312,  305,
 /*   100 */    93,  247,   -8,   63,  135,    8,  -18,  -36,  163,  194,
 /*   110 */   220,  -27,  296,  126,   43,  -52,  -27,  -27,  117,  203,
 /*   120 */   185,  181,   40,  177,  207,  209,  250,  245,  215,   59,
 /*   130 */   211,  155,  149,   83,  -33,   73,   61,   24,   54,   91,
 /*   140 */   109,  141,  139,    1,  121,  125,
);
    const YY_REDUCE_USE_DFLT = -73;
    const YY_REDUCE_MAX = 88;
    static public $yy_reduce_ofst = array(
 /*     0 */     6,  455,  455,  455,  455,  455,  455,  455,  455,  455,
 /*    10 */   455,  455,  455,  455,  455,  455,  455,  290,  613,  590,
 /*    20 */   599,  587,  624,  610,   87,  113,   57,   27,   15,   15,
 /*    30 */    15,   15,  223,  193,  219,  147,  133,  -30,   30,  -72,
 /*    40 */   200,  200,  200,  200,  200,  200,  200,  200,  200,  200,
 /*    50 */   200,  200,  258,  200,  200,  200,  200,  232,  228,  221,
 /*    60 */   224,  236,  256,  254,  251,  244,  248,  206,  198,  202,
 /*    70 */   196,   70,  186,  212,  229,  222,  252,  317,  143,  273,
 /*    80 */   321,  263,  275,  278,  315,  313,   -7,  -57,  -67,
);
    static public $yyExpectedTokens = array(
        /* 0 */ array(),
        /* 1 */ array(21, 23, 24, 28, 29, 31, 33, 35, 37, 38, 41, 43, 45, 47, 49, 50, ),
        /* 2 */ array(21, 23, 24, 28, 29, 31, 33, 38, 40, 41, 42, 43, 45, 47, 49, 50, ),
        /* 3 */ array(21, 23, 24, 28, 29, 31, 33, 35, 37, 38, 41, 43, 45, 47, 49, 50, ),
        /* 4 */ array(21, 23, 24, 28, 29, 31, 33, 38, 40, 41, 42, 43, 45, 47, 49, 50, ),
        /* 5 */ array(21, 23, 24, 28, 29, 31, 33, 38, 39, 40, 41, 43, 45, 47, 49, 50, ),
        /* 6 */ array(21, 23, 24, 28, 29, 31, 33, 38, 41, 42, 43, 45, 47, 49, 50, ),
        /* 7 */ array(21, 23, 24, 28, 29, 31, 33, 38, 41, 42, 43, 45, 47, 49, 50, ),
        /* 8 */ array(21, 23, 24, 27, 28, 29, 31, 33, 38, 41, 43, 45, 47, 49, 50, ),
        /* 9 */ array(21, 23, 24, 28, 29, 31, 33, 34, 38, 41, 43, 45, 47, 49, 50, ),
        /* 10 */ array(21, 23, 24, 28, 29, 31, 32, 33, 38, 41, 43, 45, 47, 49, 50, ),
        /* 11 */ array(21, 23, 24, 28, 29, 31, 33, 38, 41, 43, 44, 45, 47, 49, 50, ),
        /* 12 */ array(21, 23, 24, 28, 29, 31, 33, 35, 38, 41, 43, 45, 47, 49, 50, ),
        /* 13 */ array(21, 23, 24, 28, 29, 31, 33, 38, 39, 41, 43, 45, 47, 49, 50, ),
        /* 14 */ array(21, 23, 24, 28, 29, 31, 33, 35, 38, 41, 43, 45, 47, 49, 50, ),
        /* 15 */ array(21, 23, 24, 28, 29, 31, 33, 38, 41, 43, 45, 46, 47, 49, 50, ),
        /* 16 */ array(21, 23, 24, 28, 29, 31, 33, 38, 41, 43, 45, 47, 49, 50, ),
        /* 17 */ array(31, 53, 54, 56, 59, 62, 65, ),
        /* 18 */ array(31, 53, 54, 56, 59, 62, 65, ),
        /* 19 */ array(31, 53, 54, 56, 59, 62, 65, ),
        /* 20 */ array(31, 53, 54, 56, 59, 62, 65, ),
        /* 21 */ array(31, 53, 54, 56, 59, 62, 65, ),
        /* 22 */ array(31, 53, 54, 56, 59, 62, 65, ),
        /* 23 */ array(31, 53, 54, 56, 59, 62, 65, ),
        /* 24 */ array(22, 29, 30, 31, 53, 54, 56, 62, 65, ),
        /* 25 */ array(22, 31, 53, 54, 56, 62, 65, ),
        /* 26 */ array(31, 53, 54, 56, 62, 65, ),
        /* 27 */ array(31, 53, 54, 56, 62, 65, ),
        /* 28 */ array(22, 30, 31, 36, 53, 54, 56, 62, 65, ),
        /* 29 */ array(30, 31, 36, 53, 54, 56, 62, 65, ),
        /* 30 */ array(22, 31, 36, 53, 54, 56, 62, 65, ),
        /* 31 */ array(31, 36, 53, 54, 56, 62, 65, ),
        /* 32 */ array(31, 53, 54, 56, 62, 65, ),
        /* 33 */ array(31, 53, 54, 56, 62, 65, ),
        /* 34 */ array(31, 53, 54, 56, 62, 65, ),
        /* 35 */ array(31, 53, 54, 56, 62, 65, ),
        /* 36 */ array(31, 53, 54, 56, 62, 65, ),
        /* 37 */ array(31, 62, 65, ),
        /* 38 */ array(31, 62, 65, ),
        /* 39 */ array(31, 62, 65, ),
        /* 40 */ array(1, 16, 17, 19, ),
        /* 41 */ array(1, 16, 17, 19, ),
        /* 42 */ array(1, 16, 17, 19, ),
        /* 43 */ array(1, 16, 17, 19, ),
        /* 44 */ array(1, 16, 17, 19, ),
        /* 45 */ array(1, 16, 17, 19, ),
        /* 46 */ array(1, 16, 17, 19, ),
        /* 47 */ array(1, 16, 17, 19, ),
        /* 48 */ array(1, 16, 17, 19, ),
        /* 49 */ array(1, 16, 17, 19, ),
        /* 50 */ array(1, 16, 17, 19, ),
        /* 51 */ array(1, 16, 17, 19, ),
        /* 52 */ array(22, 31, 62, 65, ),
        /* 53 */ array(1, 16, 17, 19, ),
        /* 54 */ array(1, 16, 17, 19, ),
        /* 55 */ array(1, 16, 17, 19, ),
        /* 56 */ array(1, 16, 17, 19, ),
        /* 57 */ array(31, 62, 65, ),
        /* 58 */ array(31, 62, 65, ),
        /* 59 */ array(31, 62, 65, ),
        /* 60 */ array(31, 62, 65, ),
        /* 61 */ array(31, 62, 65, ),
        /* 62 */ array(31, 62, 65, ),
        /* 63 */ array(31, 62, 65, ),
        /* 64 */ array(31, 62, 65, ),
        /* 65 */ array(31, 62, 65, ),
        /* 66 */ array(31, 62, 65, ),
        /* 67 */ array(31, 62, 65, ),
        /* 68 */ array(31, 62, 65, ),
        /* 69 */ array(31, 62, 65, ),
        /* 70 */ array(31, 62, 65, ),
        /* 71 */ array(31, 62, 65, ),
        /* 72 */ array(58, ),
        /* 73 */ array(58, ),
        /* 74 */ array(),
        /* 75 */ array(),
        /* 76 */ array(),
        /* 77 */ array(),
        /* 78 */ array(),
        /* 79 */ array(),
        /* 80 */ array(),
        /* 81 */ array(),
        /* 82 */ array(),
        /* 83 */ array(),
        /* 84 */ array(),
        /* 85 */ array(),
        /* 86 */ array(),
        /* 87 */ array(),
        /* 88 */ array(),
        /* 89 */ array(2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 60, ),
        /* 90 */ array(2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 22, ),
        /* 91 */ array(3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, ),
        /* 92 */ array(4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, ),
        /* 93 */ array(4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, ),
        /* 94 */ array(22, 30, 61, 63, ),
        /* 95 */ array(10, 36, 61, 63, ),
        /* 96 */ array(22, 61, 63, ),
        /* 97 */ array(22, 61, 63, ),
        /* 98 */ array(22, 61, 63, ),
        /* 99 */ array(22, 61, 63, ),
        /* 100 */ array(48, 61, 63, ),
        /* 101 */ array(13, 14, 15, ),
        /* 102 */ array(22, 61, 63, ),
        /* 103 */ array(22, 61, 63, ),
        /* 104 */ array(30, 61, 63, ),
        /* 105 */ array(10, 61, 63, ),
        /* 106 */ array(22, 61, 63, ),
        /* 107 */ array(52, 61, 63, ),
        /* 108 */ array(30, 61, 63, ),
        /* 109 */ array(22, 61, 63, ),
        /* 110 */ array(20, 51, ),
        /* 111 */ array(61, 63, ),
        /* 112 */ array(25, 26, ),
        /* 113 */ array(55, 58, ),
        /* 114 */ array(22, 51, ),
        /* 115 */ array(57, 58, ),
        /* 116 */ array(61, 63, ),
        /* 117 */ array(61, 63, ),
        /* 118 */ array(18, ),
        /* 119 */ array(22, ),
        /* 120 */ array(22, ),
        /* 121 */ array(22, ),
        /* 122 */ array(51, ),
        /* 123 */ array(22, ),
        /* 124 */ array(22, ),
        /* 125 */ array(22, ),
        /* 126 */ array(22, ),
        /* 127 */ array(22, ),
        /* 128 */ array(22, ),
        /* 129 */ array(62, ),
        /* 130 */ array(22, ),
        /* 131 */ array(22, ),
        /* 132 */ array(22, ),
        /* 133 */ array(22, ),
        /* 134 */ array(64, ),
        /* 135 */ array(22, ),
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
);
    static public $yy_default = array(
 /*     0 */   208,  279,  279,  279,  279,  279,  279,  279,  279,  279,
 /*    10 */   279,  279,  279,  279,  279,  279,  279,  279,  279,  279,
 /*    20 */   279,  279,  279,  279,  279,  279,  279,  279,  279,  249,
 /*    30 */   279,  251,  279,  279,  279,  279,  279,  279,  279,  279,
 /*    40 */   279,  279,  279,  279,  279,  279,  279,  279,  279,  206,
 /*    50 */   279,  279,  279,  279,  279,  279,  279,  279,  279,  279,
 /*    60 */   279,  279,  279,  279,  279,  279,  279,  279,  279,  279,
 /*    70 */   279,  279,  279,  279,  208,  208,  208,  208,  208,  208,
 /*    80 */   208,  208,  208,  208,  208,  208,  208,  208,  208,  279,
 /*    90 */   279,  266,  269,  267,  279,  279,  279,  279,  279,  279,
 /*   100 */   279,  268,  279,  279,  279,  279,  279,  255,  279,  279,
 /*   110 */   279,  248,  279,  279,  279,  279,  250,  260,  279,  279,
 /*   120 */   279,  279,  271,  279,  279,  279,  279,  279,  279,  279,
 /*   130 */   279,  279,  279,  279,  279,  279,  279,  279,  279,  279,
 /*   140 */   279,  279,  279,  279,  279,  279,  277,  278,  270,  220,
 /*   150 */   215,  218,  219,  276,  217,  216,  214,  265,  259,  236,
 /*   160 */   213,  209,  238,  207,  275,  261,  274,  273,  263,  244,
 /*   170 */   262,  264,  272,  225,  232,  233,  234,  231,  230,  211,
 /*   180 */   210,  235,  237,  246,  245,  241,  240,  239,  247,  258,
 /*   190 */   212,  243,  226,  224,  242,  222,  223,  227,  228,  252,
 /*   200 */   257,  256,  229,  253,  254,  221,
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
    const YYNOCODE = 91;
    const YYSTACKDEPTH = 100;
    const YYNSTATE = 206;
    const YYNRULE = 73;
    const YYERRORSYMBOL = 66;
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
  'T_CUSTOM_TAG',  'T_FOR',         'T_AS',          'T_CUSTOM_BLOCK',
  'T_CUSTOM_END',  'T_WITH',        'T_ENDWITH',     'T_CLOSEFOR',  
  'T_COMMA',       'T_EMPTY',       'T_IF',          'T_ENDIF',     
  'T_ELSE',        'T_IFCHANGED',   'T_ENDIFCHANGED',  'T_BLOCK',     
  'T_END_BLOCK',   'T_FILTER',      'T_END_FILTER',  'T_REGROUP',   
  'T_BY',          'T_CYCLE',       'T_FIRST_OF',    'T_PIPE',      
  'T_COLON',       'T_NUMERIC',     'T_STRING_SINGLE_INIT',  'T_STRING_SINGLE_END',
  'T_STRING_DOUBLE_INIT',  'T_STRING_DOUBLE_END',  'T_STRING_CONTENT',  'T_LPARENT',   
  'T_RPARENT',     'T_DOT',         'T_ALPHA',       'T_BRACKETS_OPEN',
  'T_BRACKETS_CLOSE',  'T_CUSTOM',      'error',         'start',       
  'body',          'code',          'stmts',         'piped_list',  
  'var_or_string',  'stmt',          'for_stmt',      'ifchanged_stmt',
  'block_stmt',    'filter_stmt',   'if_stmt',       'custom_tag',  
  'alias',         'varname',       'list',          'cycle',       
  'regroup',       'first_of',      'expr',          'varname_args',
  'string',        's_content',   
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
 /*   6 */ "code ::= T_PRINT_OPEN piped_list T_PRINT_CLOSE",
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
 /*  17 */ "stmts ::= T_AUTOESCAPE T_OFF|T_ON T_CLOSE_TAG body T_OPEN_TAG T_END_AUTOESCAPE T_CLOSE_TAG",
 /*  18 */ "custom_tag ::= T_CUSTOM_TAG T_CLOSE_TAG",
 /*  19 */ "custom_tag ::= T_CUSTOM_TAG T_FOR varname T_CLOSE_TAG",
 /*  20 */ "custom_tag ::= T_CUSTOM_TAG T_FOR varname T_AS varname T_CLOSE_TAG",
 /*  21 */ "custom_tag ::= T_CUSTOM_TAG T_AS varname T_CLOSE_TAG",
 /*  22 */ "custom_tag ::= T_CUSTOM_TAG list T_CLOSE_TAG",
 /*  23 */ "custom_tag ::= T_CUSTOM_TAG list T_AS varname T_CLOSE_TAG",
 /*  24 */ "custom_tag ::= T_CUSTOM_BLOCK T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  25 */ "alias ::= T_WITH varname T_AS varname T_CLOSE_TAG body T_OPEN_TAG T_ENDWITH T_CLOSE_TAG",
 /*  26 */ "stmt ::= cycle",
 /*  27 */ "stmt ::= regroup",
 /*  28 */ "stmt ::= first_of",
 /*  29 */ "for_stmt ::= T_FOR varname T_IN varname T_CLOSE_TAG body T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG",
 /*  30 */ "for_stmt ::= T_FOR varname T_COMMA varname T_IN varname T_CLOSE_TAG body T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG",
 /*  31 */ "for_stmt ::= T_FOR varname T_IN varname T_CLOSE_TAG body T_OPEN_TAG T_EMPTY T_CLOSE_TAG body T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG",
 /*  32 */ "for_stmt ::= T_FOR varname T_COMMA varname T_IN varname T_CLOSE_TAG body T_OPEN_TAG T_EMPTY T_CLOSE_TAG body T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG",
 /*  33 */ "if_stmt ::= T_IF expr T_CLOSE_TAG body T_OPEN_TAG T_ENDIF T_CLOSE_TAG",
 /*  34 */ "if_stmt ::= T_IF expr T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIF T_CLOSE_TAG",
 /*  35 */ "ifchanged_stmt ::= T_IFCHANGED T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  36 */ "ifchanged_stmt ::= T_IFCHANGED list T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  37 */ "ifchanged_stmt ::= T_IFCHANGED T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  38 */ "ifchanged_stmt ::= T_IFCHANGED list T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  39 */ "block_stmt ::= T_BLOCK varname T_CLOSE_TAG body T_OPEN_TAG T_END_BLOCK T_CLOSE_TAG",
 /*  40 */ "block_stmt ::= T_BLOCK varname T_CLOSE_TAG body T_OPEN_TAG T_END_BLOCK varname T_CLOSE_TAG",
 /*  41 */ "filter_stmt ::= T_FILTER piped_list T_CLOSE_TAG body T_OPEN_TAG T_END_FILTER T_CLOSE_TAG",
 /*  42 */ "regroup ::= T_REGROUP varname T_BY varname T_AS varname",
 /*  43 */ "cycle ::= T_CYCLE list",
 /*  44 */ "cycle ::= T_CYCLE list T_AS varname",
 /*  45 */ "first_of ::= T_FIRST_OF list",
 /*  46 */ "piped_list ::= piped_list T_PIPE varname_args",
 /*  47 */ "piped_list ::= varname_args",
 /*  48 */ "varname_args ::= varname T_COLON var_or_string",
 /*  49 */ "varname_args ::= varname",
 /*  50 */ "list ::= list var_or_string",
 /*  51 */ "list ::= list T_COMMA var_or_string",
 /*  52 */ "list ::= var_or_string",
 /*  53 */ "var_or_string ::= T_NUMERIC",
 /*  54 */ "var_or_string ::= varname",
 /*  55 */ "var_or_string ::= string",
 /*  56 */ "string ::= T_STRING_SINGLE_INIT s_content T_STRING_SINGLE_END",
 /*  57 */ "string ::= T_STRING_DOUBLE_INIT s_content T_STRING_DOUBLE_END",
 /*  58 */ "s_content ::= s_content T_STRING_CONTENT",
 /*  59 */ "s_content ::= T_STRING_CONTENT",
 /*  60 */ "expr ::= expr T_AND expr",
 /*  61 */ "expr ::= expr T_OR expr",
 /*  62 */ "expr ::= expr T_PLUS|T_MINUS expr",
 /*  63 */ "expr ::= expr T_EQ|T_NE|T_GT|T_GE|T_LT|T_LE|T_IN expr",
 /*  64 */ "expr ::= expr T_TIMES|T_DIV|T_MOD expr",
 /*  65 */ "expr ::= piped_list",
 /*  66 */ "expr ::= T_LPARENT expr T_RPARENT",
 /*  67 */ "expr ::= string",
 /*  68 */ "expr ::= T_NUMERIC",
 /*  69 */ "varname ::= varname T_DOT T_ALPHA",
 /*  70 */ "varname ::= varname T_BRACKETS_OPEN var_or_string T_BRACKETS_CLOSE",
 /*  71 */ "varname ::= T_ALPHA",
 /*  72 */ "varname ::= T_CUSTOM|T_CUSTOM_BLOCK",
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
  array( 'lhs' => 67, 'rhs' => 1 ),
  array( 'lhs' => 68, 'rhs' => 2 ),
  array( 'lhs' => 68, 'rhs' => 0 ),
  array( 'lhs' => 69, 'rhs' => 2 ),
  array( 'lhs' => 69, 'rhs' => 1 ),
  array( 'lhs' => 69, 'rhs' => 2 ),
  array( 'lhs' => 69, 'rhs' => 3 ),
  array( 'lhs' => 70, 'rhs' => 3 ),
  array( 'lhs' => 70, 'rhs' => 2 ),
  array( 'lhs' => 70, 'rhs' => 1 ),
  array( 'lhs' => 70, 'rhs' => 1 ),
  array( 'lhs' => 70, 'rhs' => 1 ),
  array( 'lhs' => 70, 'rhs' => 1 ),
  array( 'lhs' => 70, 'rhs' => 1 ),
  array( 'lhs' => 70, 'rhs' => 3 ),
  array( 'lhs' => 70, 'rhs' => 1 ),
  array( 'lhs' => 70, 'rhs' => 1 ),
  array( 'lhs' => 70, 'rhs' => 7 ),
  array( 'lhs' => 79, 'rhs' => 2 ),
  array( 'lhs' => 79, 'rhs' => 4 ),
  array( 'lhs' => 79, 'rhs' => 6 ),
  array( 'lhs' => 79, 'rhs' => 4 ),
  array( 'lhs' => 79, 'rhs' => 3 ),
  array( 'lhs' => 79, 'rhs' => 5 ),
  array( 'lhs' => 79, 'rhs' => 6 ),
  array( 'lhs' => 80, 'rhs' => 9 ),
  array( 'lhs' => 73, 'rhs' => 1 ),
  array( 'lhs' => 73, 'rhs' => 1 ),
  array( 'lhs' => 73, 'rhs' => 1 ),
  array( 'lhs' => 74, 'rhs' => 9 ),
  array( 'lhs' => 74, 'rhs' => 11 ),
  array( 'lhs' => 74, 'rhs' => 13 ),
  array( 'lhs' => 74, 'rhs' => 15 ),
  array( 'lhs' => 78, 'rhs' => 7 ),
  array( 'lhs' => 78, 'rhs' => 11 ),
  array( 'lhs' => 75, 'rhs' => 6 ),
  array( 'lhs' => 75, 'rhs' => 7 ),
  array( 'lhs' => 75, 'rhs' => 10 ),
  array( 'lhs' => 75, 'rhs' => 11 ),
  array( 'lhs' => 76, 'rhs' => 7 ),
  array( 'lhs' => 76, 'rhs' => 8 ),
  array( 'lhs' => 77, 'rhs' => 7 ),
  array( 'lhs' => 84, 'rhs' => 6 ),
  array( 'lhs' => 83, 'rhs' => 2 ),
  array( 'lhs' => 83, 'rhs' => 4 ),
  array( 'lhs' => 85, 'rhs' => 2 ),
  array( 'lhs' => 71, 'rhs' => 3 ),
  array( 'lhs' => 71, 'rhs' => 1 ),
  array( 'lhs' => 87, 'rhs' => 3 ),
  array( 'lhs' => 87, 'rhs' => 1 ),
  array( 'lhs' => 82, 'rhs' => 2 ),
  array( 'lhs' => 82, 'rhs' => 3 ),
  array( 'lhs' => 82, 'rhs' => 1 ),
  array( 'lhs' => 72, 'rhs' => 1 ),
  array( 'lhs' => 72, 'rhs' => 1 ),
  array( 'lhs' => 72, 'rhs' => 1 ),
  array( 'lhs' => 88, 'rhs' => 3 ),
  array( 'lhs' => 88, 'rhs' => 3 ),
  array( 'lhs' => 89, 'rhs' => 2 ),
  array( 'lhs' => 89, 'rhs' => 1 ),
  array( 'lhs' => 86, 'rhs' => 3 ),
  array( 'lhs' => 86, 'rhs' => 3 ),
  array( 'lhs' => 86, 'rhs' => 3 ),
  array( 'lhs' => 86, 'rhs' => 3 ),
  array( 'lhs' => 86, 'rhs' => 3 ),
  array( 'lhs' => 86, 'rhs' => 1 ),
  array( 'lhs' => 86, 'rhs' => 3 ),
  array( 'lhs' => 86, 'rhs' => 1 ),
  array( 'lhs' => 86, 'rhs' => 1 ),
  array( 'lhs' => 81, 'rhs' => 3 ),
  array( 'lhs' => 81, 'rhs' => 4 ),
  array( 'lhs' => 81, 'rhs' => 1 ),
  array( 'lhs' => 81, 'rhs' => 1 ),
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
        26 => 3,
        27 => 3,
        28 => 3,
        49 => 3,
        59 => 3,
        68 => 3,
        71 => 3,
        72 => 3,
        4 => 4,
        5 => 5,
        6 => 6,
        7 => 7,
        8 => 8,
        14 => 14,
        17 => 17,
        18 => 18,
        19 => 19,
        20 => 20,
        21 => 21,
        22 => 22,
        23 => 23,
        24 => 24,
        25 => 25,
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
        45 => 45,
        46 => 46,
        51 => 46,
        47 => 47,
        52 => 47,
        48 => 48,
        50 => 50,
        53 => 53,
        54 => 54,
        55 => 55,
        67 => 55,
        56 => 56,
        57 => 56,
        58 => 58,
        60 => 60,
        61 => 60,
        62 => 60,
        64 => 60,
        63 => 63,
        65 => 65,
        66 => 66,
        69 => 69,
        70 => 70,
    );
    /* Beginning here are the reduction cases.  A typical example
    ** follows:
    **  #line <lineno> <grammarfile>
    **   function yy_r0($yymsp){ ... }           // User supplied code
    **  #line <lineno> <thisfile>
    */
#line 65 "parser.y"
    function yy_r0(){ $this->body = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1441 "parser.php"
#line 67 "parser.y"
    function yy_r1(){ $this->_retvalue=$this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1444 "parser.php"
#line 68 "parser.y"
    function yy_r2(){ $this->_retvalue = array();     }
#line 1447 "parser.php"
#line 71 "parser.y"
    function yy_r3(){ $this->_retvalue = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1450 "parser.php"
#line 72 "parser.y"
    function yy_r4(){ $this->_retvalue = array('operation' => 'html', 'html' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1453 "parser.php"
#line 73 "parser.y"
    function yy_r5(){ $this->yystack[$this->yyidx + 0]->minor=rtrim($this->yystack[$this->yyidx + 0]->minor); $this->_retvalue = array('operation' => 'comment', 'comment' => substr($this->yystack[$this->yyidx + 0]->minor, 0, strlen($this->yystack[$this->yyidx + 0]->minor)-2));     }
#line 1456 "parser.php"
#line 74 "parser.y"
    function yy_r6(){ $this->_retvalue = array('operation' => 'print_var', 'variable' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1459 "parser.php"
#line 76 "parser.y"
    function yy_r7(){ $this->_retvalue = array('operation' => 'base', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1462 "parser.php"
#line 77 "parser.y"
    function yy_r8(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1465 "parser.php"
#line 83 "parser.y"
    function yy_r14(){ $this->_retvalue = array('operation' => 'include', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1468 "parser.php"
#line 86 "parser.y"
    function yy_r17(){ $this->_retvalue = array('operation' => 'autoescape', 'value' => @$this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1471 "parser.php"
#line 91 "parser.y"
    function yy_r18(){ $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -1]->minor, 'list'=>array());     }
#line 1474 "parser.php"
#line 92 "parser.y"
    function yy_r19(){ $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -3]->minor, 'for' => $this->yystack[$this->yyidx + -1]->minor, 'list' => array());     }
#line 1477 "parser.php"
#line 93 "parser.y"
    function yy_r20(){ $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'for' => $this->yystack[$this->yyidx + -3]->minor, 'list' => array(),'as' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1480 "parser.php"
#line 94 "parser.y"
    function yy_r21(){ $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -3]->minor, 'as' => $this->yystack[$this->yyidx + -1]->minor, 'list'=>array());     }
#line 1483 "parser.php"
#line 95 "parser.y"
    function yy_r22(){ $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -2]->minor, 'list' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1486 "parser.php"
#line 96 "parser.y"
    function yy_r23(){ $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -4]->minor, 'as' => $this->yystack[$this->yyidx + -1]->minor, 'list' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1489 "parser.php"
#line 98 "parser.y"
    function yy_r24(){ if ('end'.$this->yystack[$this->yyidx + -5]->minor != $this->yystack[$this->yyidx + -1]->minor) { throw new Exception("Unexpected ".$this->yystack[$this->yyidx + -1]->minor); } $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor, 'list' => array());    }
#line 1492 "parser.php"
#line 101 "parser.y"
    function yy_r25(){ $this->_retvalue = array('operation' => 'alias', 'var' => $this->yystack[$this->yyidx + -7]->minor, 'as' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1495 "parser.php"
#line 109 "parser.y"
    function yy_r29(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -7]->minor, 'array' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor, 'index' => NULL); 
    }
#line 1500 "parser.php"
#line 112 "parser.y"
    function yy_r30(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -7]->minor, 'array' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor, 'index' => $this->yystack[$this->yyidx + -9]->minor); 
    }
#line 1505 "parser.php"
#line 115 "parser.y"
    function yy_r31(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -11]->minor, 'array' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'empty' => $this->yystack[$this->yyidx + -3]->minor, 'index' => NULL); 
    }
#line 1510 "parser.php"
#line 118 "parser.y"
    function yy_r32(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -11]->minor, 'array' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'empty' => $this->yystack[$this->yyidx + -3]->minor, 'index' => $this->yystack[$this->yyidx + -13]->minor); 
    }
#line 1515 "parser.php"
#line 122 "parser.y"
    function yy_r33(){ $this->_retvalue = array('operation' => 'if', 'expr' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1518 "parser.php"
#line 123 "parser.y"
    function yy_r34(){ $this->_retvalue = array('operation' => 'if', 'expr' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1521 "parser.php"
#line 126 "parser.y"
    function yy_r35(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1526 "parser.php"
#line 130 "parser.y"
    function yy_r36(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -3]->minor, 'check' => $this->yystack[$this->yyidx + -5]->minor);
    }
#line 1531 "parser.php"
#line 133 "parser.y"
    function yy_r37(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1536 "parser.php"
#line 137 "parser.y"
    function yy_r38(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -7]->minor, 'check' => $this->yystack[$this->yyidx + -9]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);
    }
#line 1541 "parser.php"
#line 143 "parser.y"
    function yy_r39(){ $this->_retvalue = array('operation' => 'block', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1544 "parser.php"
#line 145 "parser.y"
    function yy_r40(){ $this->_retvalue = array('operation' => 'block', 'name' => $this->yystack[$this->yyidx + -6]->minor, 'body' => $this->yystack[$this->yyidx + -4]->minor);     }
#line 1547 "parser.php"
#line 148 "parser.y"
    function yy_r41(){ $this->_retvalue = array('operation' => 'filter', 'functions' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1550 "parser.php"
#line 151 "parser.y"
    function yy_r42(){ $this->_retvalue=array('operation' => 'regroup', 'array' => $this->yystack[$this->yyidx + -4]->minor, 'row' => $this->yystack[$this->yyidx + -2]->minor, 'as' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1553 "parser.php"
#line 154 "parser.y"
    function yy_r43(){ $this->_retvalue = array('operation' => 'cycle', 'vars' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1556 "parser.php"
#line 155 "parser.y"
    function yy_r44(){ $this->_retvalue = array('operation' => 'cycle', 'vars' => $this->yystack[$this->yyidx + -2]->minor, 'as' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1559 "parser.php"
#line 158 "parser.y"
    function yy_r45(){ $this->_retvalue = array('operation' => 'first_of', 'vars' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1562 "parser.php"
#line 162 "parser.y"
    function yy_r46(){ $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1565 "parser.php"
#line 163 "parser.y"
    function yy_r47(){ $this->_retvalue = array($this->yystack[$this->yyidx + 0]->minor);     }
#line 1568 "parser.php"
#line 165 "parser.y"
    function yy_r48(){ $this->_retvalue = array($this->yystack[$this->yyidx + -2]->minor, 'args'=>array($this->yystack[$this->yyidx + 0]->minor));     }
#line 1571 "parser.php"
#line 169 "parser.y"
    function yy_r50(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1574 "parser.php"
#line 173 "parser.y"
    function yy_r53(){ $this->_retvalue = array('number' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1577 "parser.php"
#line 174 "parser.y"
    function yy_r54(){ $this->_retvalue = array('var' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1580 "parser.php"
#line 175 "parser.y"
    function yy_r55(){ $this->_retvalue = array('string' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1583 "parser.php"
#line 177 "parser.y"
    function yy_r56(){  $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1586 "parser.php"
#line 179 "parser.y"
    function yy_r58(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor.$this->yystack[$this->yyidx + 0]->minor;     }
#line 1589 "parser.php"
#line 183 "parser.y"
    function yy_r60(){ $this->_retvalue = array('op_expr' => @$this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1592 "parser.php"
#line 186 "parser.y"
    function yy_r63(){ $this->_retvalue = array('op_expr' => trim(@$this->yystack[$this->yyidx + -1]->minor), $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1595 "parser.php"
#line 188 "parser.y"
    function yy_r65(){$this->_retvalue = array('var_filter' => $this->yystack[$this->yyidx + 0]->minor);    }
#line 1598 "parser.php"
#line 189 "parser.y"
    function yy_r66(){ $this->_retvalue = array('op_expr' => 'expr', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1601 "parser.php"
#line 196 "parser.y"
    function yy_r69(){ if (!is_array($this->yystack[$this->yyidx + -2]->minor)) { $this->_retvalue = array($this->yystack[$this->yyidx + -2]->minor); } else { $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; }  $this->_retvalue[]=$this->yystack[$this->yyidx + 0]->minor;    }
#line 1604 "parser.php"
#line 197 "parser.y"
    function yy_r70(){ if (!is_array($this->yystack[$this->yyidx + -3]->minor)) { $this->_retvalue = array($this->yystack[$this->yyidx + -3]->minor); } else { $this->_retvalue = $this->yystack[$this->yyidx + -3]->minor; }  $this->_retvalue[]=$this->yystack[$this->yyidx + -1]->minor;    }
#line 1607 "parser.php"

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
#line 1727 "parser.php"
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

#line 1748 "parser.php"
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