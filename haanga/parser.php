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
    const T_STRING_SINGLE_INIT           = 53;
    const T_STRING_SINGLE_END            = 54;
    const T_STRING_DOUBLE_INIT           = 55;
    const T_STRING_DOUBLE_END            = 56;
    const T_STRING_CONTENT               = 57;
    const T_LPARENT                      = 58;
    const T_RPARENT                      = 59;
    const T_NUMERIC                      = 60;
    const T_DOT                          = 61;
    const T_ALPHA                        = 62;
    const T_BRACKETS_OPEN                = 63;
    const T_BRACKETS_CLOSE               = 64;
    const T_CUSTOM                       = 65;
    const YY_NO_ACTION = 279;
    const YY_ACCEPT_ACTION = 278;
    const YY_ERROR_ACTION = 277;

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
    const YY_SZ_ACTTAB = 781;
static public $yy_action = array(
 /*     0 */    36,   55,   35,  117,   19,   19,   19,   24,   62,  199,
 /*    10 */   134,  163,   59,   65,  128,   96,  138,   21,  110,   31,
 /*    20 */    25,   64,   58,  162,   38,  164,   68,   84,   26,   27,
 /*    30 */    36,  168,   35,  117,  131,  173,   32,   24,   62,   57,
 /*    40 */   134,  112,   59,   70,  123,  111,  120,   21,  278,   45,
 /*    50 */    25,  100,   58,   78,   38,  100,   68,  202,   26,   27,
 /*    60 */    36,  202,   35,  117,  131,  146,   32,   24,   62,  131,
 /*    70 */   134,   32,   59,  149,  131,   63,   32,   21,  127,  137,
 /*    80 */    25,  100,   58,  178,   38,   85,   68,  198,   26,   27,
 /*    90 */    36,  165,   35,  117,  170,  192,  152,   24,   62,  146,
 /*   100 */   134,  183,   59,   67,  146,   79,  131,   21,   32,  140,
 /*   110 */    25,  143,   58,   82,   38,  199,   68,  160,   26,   27,
 /*   120 */    36,  109,   35,  117,  110,   30,  185,   24,   62,  184,
 /*   130 */   134,  164,   59,   77,   39,  152,  194,   21,  146,  119,
 /*   140 */    25,  126,   58,  177,   38,  182,   68,  158,   26,   27,
 /*   150 */    36,  188,   35,  117,  131,   99,   32,   24,   62,  199,
 /*   160 */   134,  187,   59,   88,  118,  157,  170,   21,  110,   29,
 /*   170 */    25,   74,   58,   39,   38,  164,   68,  169,   26,   27,
 /*   180 */    36,  159,   35,  117,  131,  199,   32,   24,   62,  181,
 /*   190 */   134,  155,   59,  180,  110,   28,  186,   21,   60,  193,
 /*   200 */    25,  164,   58,   53,   38,  121,   68,  105,   26,   27,
 /*   210 */    36,  103,   35,  117,  171,   33,  141,   24,   62,  104,
 /*   220 */   134,  197,   59,  107,  131,  113,   32,   21,  190,  131,
 /*   230 */    25,   32,   58,   49,   38,  116,   68,  115,   26,   27,
 /*   240 */    51,   23,   22,   18,   18,   18,   18,   18,   18,   18,
 /*   250 */    20,   20,   19,   19,   19,  124,   36,  102,   35,  117,
 /*   260 */   131,   80,   32,   24,   62,  100,  134,  131,   59,   32,
 /*   270 */    91,  202,  167,   21,  203,   50,   25,   54,   58,   42,
 /*   280 */    38,   83,   68,  110,   26,   27,   36,   47,   35,  117,
 /*   290 */   164,   75,   95,   24,   62,   97,  134,  135,   59,  142,
 /*   300 */   142,   98,  191,   21,  189,   94,   25,  106,   58,  101,
 /*   310 */    38,   87,   68,  114,   26,   27,   36,   43,   35,  117,
 /*   320 */   131,   81,   32,   24,   62,   56,  134,  164,   59,  132,
 /*   330 */   131,   52,   32,   21,   40,   39,   25,  164,   58,   41,
 /*   340 */    38,  131,   68,   32,   26,   27,   36,   46,   35,  117,
 /*   350 */   131,  164,   32,   24,   62,  200,  134,  164,   59,   44,
 /*   360 */   131,   48,   32,   21,  110,  164,   25,  139,   58,  164,
 /*   370 */    38,  164,   68,  164,   26,   27,   36,  164,   35,  117,
 /*   380 */   164,  164,  164,   24,   62,  144,  134,  164,   59,  164,
 /*   390 */   164,  164,  164,   21,  110,  164,   25,  125,   58,  164,
 /*   400 */    38,  164,   68,  133,   26,   27,   36,  164,   35,  117,
 /*   410 */   164,  164,  110,   24,   62,  201,  134,  164,   59,  164,
 /*   420 */   129,  164,  164,   21,  110,  164,   25,  164,   58,  164,
 /*   430 */    38,  164,   68,  164,   26,   27,  164,   23,   22,   18,
 /*   440 */    18,   18,   18,   18,   18,   18,   20,   20,   19,   19,
 /*   450 */    19,  124,   36,  164,   35,  117,  164,  164,  164,   24,
 /*   460 */    62,  100,  134,  164,   59,  164,   93,  202,  167,   21,
 /*   470 */   145,  164,   25,  130,   58,  164,   38,  164,   68,  164,
 /*   480 */    26,   27,  110,  146,  164,  124,  164,  164,  164,  164,
 /*   490 */   164,  164,  164,  164,  172,  100,   36,  164,   35,  117,
 /*   500 */   108,  202,  167,   24,   62,   72,  134,   73,   59,  164,
 /*   510 */   164,  164,  164,   21,  152,  164,   25,  146,   58,  164,
 /*   520 */    38,  164,   68,  164,   26,   27,   22,   18,   18,   18,
 /*   530 */    18,   18,   18,   18,   20,   20,   19,   19,   19,  164,
 /*   540 */   161,  164,  164,  136,  156,  150,  154,  153,  151,  148,
 /*   550 */   204,   66,  146,  176,  174,  175,  164,   34,   18,   18,
 /*   560 */    18,   18,   18,   18,   18,   20,   20,   19,   19,   19,
 /*   570 */   195,  164,  164,  164,   72,  146,   73,   61,   71,  146,
 /*   580 */   164,  196,  164,  152,  164,  164,  146,  164,  164,   69,
 /*   590 */   146,  164,  164,  164,  164,   34,  164,   72,   86,   73,
 /*   600 */   164,   72,   17,   73,  166,  164,  152,  146,  164,  146,
 /*   610 */   152,  146,   72,  146,   73,  164,   34,  164,   76,  164,
 /*   620 */   164,  152,  164,  164,  146,  164,  164,  146,  164,   72,
 /*   630 */   164,   73,   34,   72,  164,   73,  164,  124,  152,  164,
 /*   640 */   124,  146,  152,  164,  164,  146,  164,  100,  164,   72,
 /*   650 */   100,   73,   92,  202,  167,   89,  202,  167,  152,  164,
 /*   660 */   164,  146,  124,  164,  164,  164,  164,  164,  164,  164,
 /*   670 */   124,  164,  100,  164,   13,  164,  164,  147,  202,  167,
 /*   680 */   100,   16,  164,  164,  164,   90,  202,  167,   10,  179,
 /*   690 */   122,  164,   37,  164,    3,  164,  179,  122,    1,   37,
 /*   700 */   164,  164,  164,  179,  122,    6,   37,  164,  164,  179,
 /*   710 */   122,    4,   37,  179,  122,   15,   37,  164,  164,  164,
 /*   720 */   179,  122,    9,   37,  164,  164,  179,  122,   11,   37,
 /*   730 */   179,  122,    5,   37,  164,  164,  164,  179,  122,   12,
 /*   740 */    37,  164,  164,  179,  122,    7,   37,  179,  122,   14,
 /*   750 */    37,  164,  164,  164,  179,  122,    8,   37,  164,  164,
 /*   760 */   179,  122,    2,   37,  179,  122,  164,   37,  164,  164,
 /*   770 */   164,  179,  122,  164,   37,  164,  164,  179,  122,  164,
 /*   780 */    37,
    );
    static public $yy_lookahead = array(
 /*     0 */    21,   68,   23,   24,   13,   14,   15,   28,   29,   72,
 /*    10 */    31,   69,   33,   10,   35,   81,   37,   38,   81,   82,
 /*    20 */    41,   48,   43,   22,   45,   88,   47,   22,   49,   50,
 /*    30 */    21,   64,   23,   24,   61,   22,   63,   28,   29,   36,
 /*    40 */    31,   71,   33,   30,   35,   71,   37,   38,   67,   68,
 /*    50 */    41,   81,   43,   22,   45,   81,   47,   87,   49,   50,
 /*    60 */    21,   87,   23,   24,   61,   31,   63,   28,   29,   61,
 /*    70 */    31,   63,   33,   22,   61,   30,   63,   38,   39,   40,
 /*    80 */    41,   81,   43,   22,   45,   22,   47,   87,   49,   50,
 /*    90 */    21,   54,   23,   24,   57,   22,   62,   28,   29,   65,
 /*   100 */    31,   22,   33,   10,   31,   22,   61,   38,   63,   40,
 /*   110 */    41,   42,   43,   22,   45,   72,   47,   22,   49,   50,
 /*   120 */    21,   81,   23,   24,   81,   82,   22,   28,   29,   22,
 /*   130 */    31,   88,   33,   22,   51,   62,   22,   38,   65,   40,
 /*   140 */    41,   42,   43,   22,   45,   22,   47,   22,   49,   50,
 /*   150 */    21,   18,   23,   24,   61,   81,   63,   28,   29,   72,
 /*   160 */    31,   22,   33,   22,   35,   56,   57,   38,   81,   82,
 /*   170 */    41,   22,   43,   51,   45,   88,   47,   22,   49,   50,
 /*   180 */    21,   62,   23,   24,   61,   72,   63,   28,   29,   22,
 /*   190 */    31,   22,   33,   22,   81,   82,   22,   38,   30,   22,
 /*   200 */    41,   88,   43,   68,   45,   46,   47,   81,   49,   50,
 /*   210 */    21,   81,   23,   24,   57,   52,   27,   28,   29,   81,
 /*   220 */    31,   22,   33,   81,   61,   89,   63,   38,   22,   61,
 /*   230 */    41,   63,   43,   68,   45,   89,   47,   81,   49,   50,
 /*   240 */    68,    2,    3,    4,    5,    6,    7,    8,    9,   10,
 /*   250 */    11,   12,   13,   14,   15,   71,   21,   81,   23,   24,
 /*   260 */    61,   22,   63,   28,   29,   81,   31,   61,   33,   63,
 /*   270 */    86,   87,   88,   38,   72,   68,   41,   68,   43,   44,
 /*   280 */    45,   22,   47,   81,   49,   50,   21,   68,   23,   24,
 /*   290 */    88,   22,   81,   28,   29,   81,   31,   32,   33,   25,
 /*   300 */    26,   81,   22,   38,   20,   81,   41,   81,   43,   81,
 /*   310 */    45,   22,   47,   81,   49,   50,   21,   68,   23,   24,
 /*   320 */    61,   22,   63,   28,   29,   68,   31,   90,   33,   34,
 /*   330 */    61,   68,   63,   38,   68,   51,   41,   90,   43,   68,
 /*   340 */    45,   61,   47,   63,   49,   50,   21,   68,   23,   24,
 /*   350 */    61,   90,   63,   28,   29,   72,   31,   90,   33,   68,
 /*   360 */    61,   68,   63,   38,   81,   90,   41,   42,   43,   90,
 /*   370 */    45,   88,   47,   90,   49,   50,   21,   90,   23,   24,
 /*   380 */    90,   90,   90,   28,   29,   72,   31,   90,   33,   90,
 /*   390 */    90,   90,   90,   38,   81,   90,   41,   42,   43,   90,
 /*   400 */    45,   88,   47,   72,   49,   50,   21,   90,   23,   24,
 /*   410 */    90,   90,   81,   28,   29,   72,   31,   90,   33,   88,
 /*   420 */    35,   90,   90,   38,   81,   90,   41,   90,   43,   90,
 /*   430 */    45,   88,   47,   90,   49,   50,   90,    2,    3,    4,
 /*   440 */     5,    6,    7,    8,    9,   10,   11,   12,   13,   14,
 /*   450 */    15,   71,   21,   90,   23,   24,   90,   90,   90,   28,
 /*   460 */    29,   81,   31,   90,   33,   90,   86,   87,   88,   38,
 /*   470 */    39,   90,   41,   72,   43,   90,   45,   90,   47,   90,
 /*   480 */    49,   50,   81,   31,   90,   71,   90,   90,   90,   88,
 /*   490 */    90,   90,   90,   90,   59,   81,   21,   90,   23,   24,
 /*   500 */    86,   87,   88,   28,   29,   53,   31,   55,   33,   90,
 /*   510 */    90,   90,   90,   38,   62,   90,   41,   65,   43,   90,
 /*   520 */    45,   90,   47,   90,   49,   50,    3,    4,    5,    6,
 /*   530 */     7,    8,    9,   10,   11,   12,   13,   14,   15,   90,
 /*   540 */    70,   90,   90,   73,   74,   75,   76,   77,   78,   79,
 /*   550 */    80,   30,   31,   83,   84,   85,   90,   36,    4,    5,
 /*   560 */     6,    7,    8,    9,   10,   11,   12,   13,   14,   15,
 /*   570 */    22,   90,   90,   90,   53,   31,   55,   29,   30,   31,
 /*   580 */    90,   22,   90,   62,   90,   90,   65,   90,   90,   30,
 /*   590 */    31,   90,   90,   90,   90,   36,   90,   53,   22,   55,
 /*   600 */    90,   53,   58,   55,   60,   90,   62,   31,   90,   65,
 /*   610 */    62,   31,   53,   65,   55,   90,   36,   90,   22,   90,
 /*   620 */    90,   62,   90,   90,   65,   90,   90,   31,   90,   53,
 /*   630 */    90,   55,   36,   53,   90,   55,   90,   71,   62,   90,
 /*   640 */    71,   65,   62,   90,   90,   65,   90,   81,   90,   53,
 /*   650 */    81,   55,   86,   87,   88,   86,   87,   88,   62,   90,
 /*   660 */    90,   65,   71,   90,   90,   90,   90,   90,   90,   90,
 /*   670 */    71,   90,   81,   90,    1,   90,   90,   86,   87,   88,
 /*   680 */    81,    1,   90,   90,   90,   86,   87,   88,    1,   16,
 /*   690 */    17,   90,   19,   90,    1,   90,   16,   17,    1,   19,
 /*   700 */    90,   90,   90,   16,   17,    1,   19,   90,   90,   16,
 /*   710 */    17,    1,   19,   16,   17,    1,   19,   90,   90,   90,
 /*   720 */    16,   17,    1,   19,   90,   90,   16,   17,    1,   19,
 /*   730 */    16,   17,    1,   19,   90,   90,   90,   16,   17,    1,
 /*   740 */    19,   90,   90,   16,   17,    1,   19,   16,   17,    1,
 /*   750 */    19,   90,   90,   90,   16,   17,    1,   19,   90,   90,
 /*   760 */    16,   17,    1,   19,   16,   17,   90,   19,   90,   90,
 /*   770 */    90,   16,   17,   90,   19,   90,   90,   16,   17,   90,
 /*   780 */    19,
);
    const YY_SHIFT_USE_DFLT = -34;
    const YY_SHIFT_MAX = 145;
    static public $yy_shift_ofst = array(
 /*     0 */   -34,   99,   39,   69,  -21,    9,  431,  265,  189,  385,
 /*    10 */   159,  129,  235,  295,  355,  325,  475,  544,  544,  544,
 /*    20 */   544,  544,  544,  544,  548,  576,  452,  452,  559,  596,
 /*    30 */   521,  580,  452,  452,  452,  452,  452,   34,   34,   34,
 /*    40 */   704,  673,   73,  693,  687,  680,  761,  721,  731,  710,
 /*    50 */   755,  697,  744,  738,  748,  727,  714,   34,   34,   34,
 /*    60 */    34,   34,   34,   34,   34,   34,   34,   34,   34,   34,
 /*    70 */    34,   34,  157,  157,  -34,  -34,  -34,  -34,  -34,  -34,
 /*    80 */   -34,  -34,  -34,  -34,  -34,  -34,  -34,  -34,  -34,  435,
 /*    90 */   239,  523,  554,  554,    3,   13,  123,  168,  289,  199,
 /*   100 */   163,   45,  299,  -27,  259,  206,  269,  280,   -9,   93,
 /*   110 */     8,   83,  284,  109,    8,    8,   37,  274,    1,  149,
 /*   120 */   141,  139,  133,  125,  122,  155,  177,  174,  171,  167,
 /*   130 */   169,  119,  121,  -33,   63,   61,   51,    5,   31,   79,
 /*   140 */    91,  114,  111,  107,   95,  104,
);
    const YY_REDUCE_USE_DFLT = -68;
    const YY_REDUCE_MAX = 88;
    static public $yy_reduce_ofst = array(
 /*     0 */   -19,  470,  470,  470,  470,  470,  470,  470,  470,  470,
 /*    10 */   470,  470,  470,  470,  470,  470,  470,  569,  566,  591,
 /*    20 */   414,  599,  380,  184,  113,   87,   43,  -63,  343,  343,
 /*    30 */   343,  343,  331,  202,  283,  401,  313,  -30,  -26,    0,
 /*    40 */   -58,  -58,  -66,  -58,  -58,  -58,  -58,  -58,  -58,  -58,
 /*    50 */   -58,  -58,  -58,  -58,  -58,  -58,  -58,   40,  220,  214,
 /*    60 */   176,  211,  224,  232,  228,  226,  156,  138,  130,   74,
 /*    70 */   126,  142,  146,  136,  209,  165,  172,  207,  219,  291,
 /*    80 */   279,  271,  257,  293,  266,  263,  249,  135,  -67,
);
    static public $yyExpectedTokens = array(
        /* 0 */ array(),
        /* 1 */ array(21, 23, 24, 28, 29, 31, 33, 38, 40, 41, 42, 43, 45, 47, 49, 50, ),
        /* 2 */ array(21, 23, 24, 28, 29, 31, 33, 38, 39, 40, 41, 43, 45, 47, 49, 50, ),
        /* 3 */ array(21, 23, 24, 28, 29, 31, 33, 38, 40, 41, 42, 43, 45, 47, 49, 50, ),
        /* 4 */ array(21, 23, 24, 28, 29, 31, 33, 35, 37, 38, 41, 43, 45, 47, 49, 50, ),
        /* 5 */ array(21, 23, 24, 28, 29, 31, 33, 35, 37, 38, 41, 43, 45, 47, 49, 50, ),
        /* 6 */ array(21, 23, 24, 28, 29, 31, 33, 38, 39, 41, 43, 45, 47, 49, 50, ),
        /* 7 */ array(21, 23, 24, 28, 29, 31, 32, 33, 38, 41, 43, 45, 47, 49, 50, ),
        /* 8 */ array(21, 23, 24, 27, 28, 29, 31, 33, 38, 41, 43, 45, 47, 49, 50, ),
        /* 9 */ array(21, 23, 24, 28, 29, 31, 33, 35, 38, 41, 43, 45, 47, 49, 50, ),
        /* 10 */ array(21, 23, 24, 28, 29, 31, 33, 38, 41, 43, 45, 46, 47, 49, 50, ),
        /* 11 */ array(21, 23, 24, 28, 29, 31, 33, 35, 38, 41, 43, 45, 47, 49, 50, ),
        /* 12 */ array(21, 23, 24, 28, 29, 31, 33, 38, 41, 43, 44, 45, 47, 49, 50, ),
        /* 13 */ array(21, 23, 24, 28, 29, 31, 33, 34, 38, 41, 43, 45, 47, 49, 50, ),
        /* 14 */ array(21, 23, 24, 28, 29, 31, 33, 38, 41, 42, 43, 45, 47, 49, 50, ),
        /* 15 */ array(21, 23, 24, 28, 29, 31, 33, 38, 41, 42, 43, 45, 47, 49, 50, ),
        /* 16 */ array(21, 23, 24, 28, 29, 31, 33, 38, 41, 43, 45, 47, 49, 50, ),
        /* 17 */ array(31, 53, 55, 58, 60, 62, 65, ),
        /* 18 */ array(31, 53, 55, 58, 60, 62, 65, ),
        /* 19 */ array(31, 53, 55, 58, 60, 62, 65, ),
        /* 20 */ array(31, 53, 55, 58, 60, 62, 65, ),
        /* 21 */ array(31, 53, 55, 58, 60, 62, 65, ),
        /* 22 */ array(31, 53, 55, 58, 60, 62, 65, ),
        /* 23 */ array(31, 53, 55, 58, 60, 62, 65, ),
        /* 24 */ array(22, 29, 30, 31, 53, 55, 62, 65, ),
        /* 25 */ array(22, 31, 53, 55, 62, 65, ),
        /* 26 */ array(31, 53, 55, 62, 65, ),
        /* 27 */ array(31, 53, 55, 62, 65, ),
        /* 28 */ array(22, 30, 31, 36, 53, 55, 62, 65, ),
        /* 29 */ array(22, 31, 36, 53, 55, 62, 65, ),
        /* 30 */ array(30, 31, 36, 53, 55, 62, 65, ),
        /* 31 */ array(31, 36, 53, 55, 62, 65, ),
        /* 32 */ array(31, 53, 55, 62, 65, ),
        /* 33 */ array(31, 53, 55, 62, 65, ),
        /* 34 */ array(31, 53, 55, 62, 65, ),
        /* 35 */ array(31, 53, 55, 62, 65, ),
        /* 36 */ array(31, 53, 55, 62, 65, ),
        /* 37 */ array(31, 62, 65, ),
        /* 38 */ array(31, 62, 65, ),
        /* 39 */ array(31, 62, 65, ),
        /* 40 */ array(1, 16, 17, 19, ),
        /* 41 */ array(1, 16, 17, 19, ),
        /* 42 */ array(22, 31, 62, 65, ),
        /* 43 */ array(1, 16, 17, 19, ),
        /* 44 */ array(1, 16, 17, 19, ),
        /* 45 */ array(1, 16, 17, 19, ),
        /* 46 */ array(1, 16, 17, 19, ),
        /* 47 */ array(1, 16, 17, 19, ),
        /* 48 */ array(1, 16, 17, 19, ),
        /* 49 */ array(1, 16, 17, 19, ),
        /* 50 */ array(1, 16, 17, 19, ),
        /* 51 */ array(1, 16, 17, 19, ),
        /* 52 */ array(1, 16, 17, 19, ),
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
        /* 72 */ array(57, ),
        /* 73 */ array(57, ),
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
        /* 89 */ array(2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 59, ),
        /* 90 */ array(2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 22, ),
        /* 91 */ array(3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, ),
        /* 92 */ array(4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, ),
        /* 93 */ array(4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, ),
        /* 94 */ array(10, 36, 61, 63, ),
        /* 95 */ array(22, 30, 61, 63, ),
        /* 96 */ array(22, 61, 63, ),
        /* 97 */ array(30, 61, 63, ),
        /* 98 */ array(22, 61, 63, ),
        /* 99 */ array(22, 61, 63, ),
        /* 100 */ array(52, 61, 63, ),
        /* 101 */ array(30, 61, 63, ),
        /* 102 */ array(22, 61, 63, ),
        /* 103 */ array(48, 61, 63, ),
        /* 104 */ array(22, 61, 63, ),
        /* 105 */ array(22, 61, 63, ),
        /* 106 */ array(22, 61, 63, ),
        /* 107 */ array(22, 61, 63, ),
        /* 108 */ array(13, 14, 15, ),
        /* 109 */ array(10, 61, 63, ),
        /* 110 */ array(61, 63, ),
        /* 111 */ array(22, 51, ),
        /* 112 */ array(20, 51, ),
        /* 113 */ array(56, 57, ),
        /* 114 */ array(61, 63, ),
        /* 115 */ array(61, 63, ),
        /* 116 */ array(54, 57, ),
        /* 117 */ array(25, 26, ),
        /* 118 */ array(22, ),
        /* 119 */ array(22, ),
        /* 120 */ array(22, ),
        /* 121 */ array(22, ),
        /* 122 */ array(18, ),
        /* 123 */ array(22, ),
        /* 124 */ array(51, ),
        /* 125 */ array(22, ),
        /* 126 */ array(22, ),
        /* 127 */ array(22, ),
        /* 128 */ array(22, ),
        /* 129 */ array(22, ),
        /* 130 */ array(22, ),
        /* 131 */ array(62, ),
        /* 132 */ array(22, ),
        /* 133 */ array(64, ),
        /* 134 */ array(22, ),
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
);
    static public $yy_default = array(
 /*     0 */   207,  277,  277,  277,  277,  277,  277,  277,  277,  277,
 /*    10 */   277,  277,  277,  277,  277,  277,  277,  277,  277,  277,
 /*    20 */   277,  277,  277,  277,  277,  277,  277,  277,  277,  277,
 /*    30 */   248,  250,  277,  277,  277,  277,  277,  277,  277,  277,
 /*    40 */   277,  277,  277,  277,  277,  205,  277,  277,  277,  277,
 /*    50 */   277,  277,  277,  277,  277,  277,  277,  277,  277,  277,
 /*    60 */   277,  277,  277,  277,  277,  277,  277,  277,  277,  277,
 /*    70 */   277,  277,  277,  277,  207,  207,  207,  207,  207,  207,
 /*    80 */   207,  207,  207,  207,  207,  207,  207,  207,  207,  277,
 /*    90 */   277,  264,  267,  265,  277,  277,  277,  277,  277,  277,
 /*   100 */   254,  277,  277,  277,  277,  277,  277,  277,  266,  277,
 /*   110 */   258,  277,  277,  277,  247,  249,  277,  277,  277,  277,
 /*   120 */   277,  277,  277,  277,  269,  277,  277,  277,  277,  277,
 /*   130 */   277,  277,  277,  277,  277,  277,  277,  277,  277,  277,
 /*   140 */   277,  277,  277,  277,  277,  277,  276,  268,  220,  213,
 /*   150 */   215,  218,  275,  217,  216,  219,  214,  261,  235,  273,
 /*   160 */   212,  208,  237,  206,  259,  260,  272,  271,  274,  243,
 /*   170 */   262,  263,  270,  224,  232,  233,  231,  230,  229,  209,
 /*   180 */   234,  236,  245,  242,  240,  239,  238,  246,  210,  211,
 /*   190 */   225,  226,  244,  241,  222,  223,  227,  228,  251,  257,
 /*   200 */   256,  255,  252,  253,  221,
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
    const YYNSTATE = 205;
    const YYNRULE = 72;
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
  'T_COLON',       'T_STRING_SINGLE_INIT',  'T_STRING_SINGLE_END',  'T_STRING_DOUBLE_INIT',
  'T_STRING_DOUBLE_END',  'T_STRING_CONTENT',  'T_LPARENT',     'T_RPARENT',   
  'T_NUMERIC',     'T_DOT',         'T_ALPHA',       'T_BRACKETS_OPEN',
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
 /*  53 */ "var_or_string ::= varname",
 /*  54 */ "var_or_string ::= string",
 /*  55 */ "string ::= T_STRING_SINGLE_INIT s_content T_STRING_SINGLE_END",
 /*  56 */ "string ::= T_STRING_DOUBLE_INIT s_content T_STRING_DOUBLE_END",
 /*  57 */ "s_content ::= s_content T_STRING_CONTENT",
 /*  58 */ "s_content ::= T_STRING_CONTENT",
 /*  59 */ "expr ::= expr T_AND expr",
 /*  60 */ "expr ::= expr T_OR expr",
 /*  61 */ "expr ::= expr T_PLUS|T_MINUS expr",
 /*  62 */ "expr ::= expr T_EQ|T_NE|T_GT|T_GE|T_LT|T_LE|T_IN expr",
 /*  63 */ "expr ::= expr T_TIMES|T_DIV|T_MOD expr",
 /*  64 */ "expr ::= piped_list",
 /*  65 */ "expr ::= T_LPARENT expr T_RPARENT",
 /*  66 */ "expr ::= string",
 /*  67 */ "expr ::= T_NUMERIC",
 /*  68 */ "varname ::= varname T_DOT T_ALPHA",
 /*  69 */ "varname ::= varname T_BRACKETS_OPEN var_or_string T_BRACKETS_CLOSE",
 /*  70 */ "varname ::= T_ALPHA",
 /*  71 */ "varname ::= T_CUSTOM|T_CUSTOM_BLOCK",
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
        58 => 3,
        67 => 3,
        70 => 3,
        71 => 3,
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
        66 => 54,
        55 => 55,
        56 => 55,
        57 => 57,
        59 => 59,
        60 => 59,
        61 => 59,
        63 => 59,
        62 => 62,
        64 => 64,
        65 => 65,
        68 => 68,
        69 => 69,
    );
    /* Beginning here are the reduction cases.  A typical example
    ** follows:
    **  #line <lineno> <grammarfile>
    **   function yy_r0($yymsp){ ... }           // User supplied code
    **  #line <lineno> <thisfile>
    */
#line 65 "parser.y"
    function yy_r0(){ $this->body = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1435 "parser.php"
#line 67 "parser.y"
    function yy_r1(){ $this->_retvalue=$this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1438 "parser.php"
#line 68 "parser.y"
    function yy_r2(){ $this->_retvalue = array();     }
#line 1441 "parser.php"
#line 71 "parser.y"
    function yy_r3(){ $this->_retvalue = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1444 "parser.php"
#line 72 "parser.y"
    function yy_r4(){ $this->_retvalue = array('operation' => 'html', 'html' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1447 "parser.php"
#line 73 "parser.y"
    function yy_r5(){ $this->yystack[$this->yyidx + 0]->minor=rtrim($this->yystack[$this->yyidx + 0]->minor); $this->_retvalue = array('operation' => 'comment', 'comment' => substr($this->yystack[$this->yyidx + 0]->minor, 0, strlen($this->yystack[$this->yyidx + 0]->minor)-2));     }
#line 1450 "parser.php"
#line 74 "parser.y"
    function yy_r6(){ $this->_retvalue = array('operation' => 'print_var', 'variable' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1453 "parser.php"
#line 76 "parser.y"
    function yy_r7(){ $this->_retvalue = array('operation' => 'base', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1456 "parser.php"
#line 77 "parser.y"
    function yy_r8(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1459 "parser.php"
#line 83 "parser.y"
    function yy_r14(){ $this->_retvalue = array('operation' => 'include', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1462 "parser.php"
#line 86 "parser.y"
    function yy_r17(){ $this->_retvalue = array('operation' => 'autoescape', 'value' => @$this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1465 "parser.php"
#line 91 "parser.y"
    function yy_r18(){ $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -1]->minor, 'list'=>array());     }
#line 1468 "parser.php"
#line 92 "parser.y"
    function yy_r19(){ $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -3]->minor, 'for' => $this->yystack[$this->yyidx + -1]->minor, 'list' => array());     }
#line 1471 "parser.php"
#line 93 "parser.y"
    function yy_r20(){ $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'for' => $this->yystack[$this->yyidx + -3]->minor, 'list' => array(),'as' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1474 "parser.php"
#line 94 "parser.y"
    function yy_r21(){ $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -3]->minor, 'as' => $this->yystack[$this->yyidx + -1]->minor, 'list'=>array());     }
#line 1477 "parser.php"
#line 95 "parser.y"
    function yy_r22(){ $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -2]->minor, 'list' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1480 "parser.php"
#line 96 "parser.y"
    function yy_r23(){ $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -4]->minor, 'as' => $this->yystack[$this->yyidx + -1]->minor, 'list' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1483 "parser.php"
#line 98 "parser.y"
    function yy_r24(){ if ('end'.$this->yystack[$this->yyidx + -5]->minor != $this->yystack[$this->yyidx + -1]->minor) { throw new Exception("Unexpected ".$this->yystack[$this->yyidx + -1]->minor); } $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor, 'list' => array());    }
#line 1486 "parser.php"
#line 101 "parser.y"
    function yy_r25(){ $this->_retvalue = array('operation' => 'alias', 'var' => $this->yystack[$this->yyidx + -7]->minor, 'as' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1489 "parser.php"
#line 109 "parser.y"
    function yy_r29(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -7]->minor, 'array' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor, 'index' => NULL); 
    }
#line 1494 "parser.php"
#line 112 "parser.y"
    function yy_r30(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -7]->minor, 'array' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor, 'index' => $this->yystack[$this->yyidx + -9]->minor); 
    }
#line 1499 "parser.php"
#line 115 "parser.y"
    function yy_r31(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -11]->minor, 'array' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'empty' => $this->yystack[$this->yyidx + -3]->minor, 'index' => NULL); 
    }
#line 1504 "parser.php"
#line 118 "parser.y"
    function yy_r32(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -11]->minor, 'array' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'empty' => $this->yystack[$this->yyidx + -3]->minor, 'index' => $this->yystack[$this->yyidx + -13]->minor); 
    }
#line 1509 "parser.php"
#line 122 "parser.y"
    function yy_r33(){ $this->_retvalue = array('operation' => 'if', 'expr' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1512 "parser.php"
#line 123 "parser.y"
    function yy_r34(){ $this->_retvalue = array('operation' => 'if', 'expr' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1515 "parser.php"
#line 126 "parser.y"
    function yy_r35(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1520 "parser.php"
#line 130 "parser.y"
    function yy_r36(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -3]->minor, 'check' => $this->yystack[$this->yyidx + -5]->minor);
    }
#line 1525 "parser.php"
#line 133 "parser.y"
    function yy_r37(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1530 "parser.php"
#line 137 "parser.y"
    function yy_r38(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -7]->minor, 'check' => $this->yystack[$this->yyidx + -9]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);
    }
#line 1535 "parser.php"
#line 143 "parser.y"
    function yy_r39(){ $this->_retvalue = array('operation' => 'block', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1538 "parser.php"
#line 145 "parser.y"
    function yy_r40(){ $this->_retvalue = array('operation' => 'block', 'name' => $this->yystack[$this->yyidx + -6]->minor, 'body' => $this->yystack[$this->yyidx + -4]->minor);     }
#line 1541 "parser.php"
#line 148 "parser.y"
    function yy_r41(){ $this->_retvalue = array('operation' => 'filter', 'functions' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1544 "parser.php"
#line 151 "parser.y"
    function yy_r42(){ $this->_retvalue=array('operation' => 'regroup', 'array' => $this->yystack[$this->yyidx + -4]->minor, 'row' => $this->yystack[$this->yyidx + -2]->minor, 'as' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1547 "parser.php"
#line 154 "parser.y"
    function yy_r43(){ $this->_retvalue = array('operation' => 'cycle', 'vars' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1550 "parser.php"
#line 155 "parser.y"
    function yy_r44(){ $this->_retvalue = array('operation' => 'cycle', 'vars' => $this->yystack[$this->yyidx + -2]->minor, 'as' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1553 "parser.php"
#line 158 "parser.y"
    function yy_r45(){ $this->_retvalue = array('operation' => 'first_of', 'vars' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1556 "parser.php"
#line 162 "parser.y"
    function yy_r46(){ $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1559 "parser.php"
#line 163 "parser.y"
    function yy_r47(){ $this->_retvalue = array($this->yystack[$this->yyidx + 0]->minor);     }
#line 1562 "parser.php"
#line 165 "parser.y"
    function yy_r48(){ $this->_retvalue = array($this->yystack[$this->yyidx + -2]->minor, 'args'=>array($this->yystack[$this->yyidx + 0]->minor));     }
#line 1565 "parser.php"
#line 169 "parser.y"
    function yy_r50(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1568 "parser.php"
#line 173 "parser.y"
    function yy_r53(){ $this->_retvalue = array('var' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1571 "parser.php"
#line 174 "parser.y"
    function yy_r54(){ $this->_retvalue = array('string' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1574 "parser.php"
#line 176 "parser.y"
    function yy_r55(){  $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1577 "parser.php"
#line 178 "parser.y"
    function yy_r57(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor.$this->yystack[$this->yyidx + 0]->minor;     }
#line 1580 "parser.php"
#line 182 "parser.y"
    function yy_r59(){ $this->_retvalue = array('op' => @$this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1583 "parser.php"
#line 185 "parser.y"
    function yy_r62(){ $this->_retvalue = array('op' => trim(@$this->yystack[$this->yyidx + -1]->minor), $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1586 "parser.php"
#line 187 "parser.y"
    function yy_r64(){$this->_retvalue = array('var_filter' => $this->yystack[$this->yyidx + 0]->minor);    }
#line 1589 "parser.php"
#line 188 "parser.y"
    function yy_r65(){ $this->_retvalue = array('op' => 'expr', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1592 "parser.php"
#line 195 "parser.y"
    function yy_r68(){ if (!is_array($this->yystack[$this->yyidx + -2]->minor)) { $this->_retvalue = array($this->yystack[$this->yyidx + -2]->minor); } else { $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; }  $this->_retvalue[]=$this->yystack[$this->yyidx + 0]->minor;    }
#line 1595 "parser.php"
#line 196 "parser.y"
    function yy_r69(){ if (!is_array($this->yystack[$this->yyidx + -3]->minor)) { $this->_retvalue = array($this->yystack[$this->yyidx + -3]->minor); } else { $this->_retvalue = $this->yystack[$this->yyidx + -3]->minor; }  $this->_retvalue[]=$this->yystack[$this->yyidx + -1]->minor;    }
#line 1598 "parser.php"

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
#line 1718 "parser.php"
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

#line 1739 "parser.php"
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