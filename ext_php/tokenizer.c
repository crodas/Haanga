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
  |                                             OR"                                    |
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

#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include "haanga.h"
#include "parser.h"
#include <stdarg.h>


typedef struct Keyword Keyword;
typedef struct Operator Operator;

struct Keyword {
    char * zName;
    int tokenType;
    int len;
    int iNext;
};

struct Operator {
    char zOp;
    int tokenType;
};


/* keywords (key sensitive) */
static Keyword aKeywordTable[] = {
    {"AND",         T_AND          },
    {"FALSE",       T_FALSE        },
    {"NOT",         T_NOT          },
    {"OR",          T_OR           },
    {"TRUE",        T_TRUE         },
    {"_(",          T_INTL         },
    {"as",          T_AS           },
    {"autoescape",  T_AUTOESCAPE   },
    {"block",       T_BLOCK        },
    {"by",          T_BY           },
    {"else",        T_ELSE         },
    {"empty",       T_EMPTY        },
    {"extends",     T_EXTENDS      },
    {"filter",      T_FILTER       },
    {"for",         T_FOR          },
    {"if",          T_IF           },
    {"ifchanged",   T_IFCHANGED    },
    {"ifequal",     T_IFEQUAL      },
    {"ifnotequal",  T_IFNOTEQUAL   },
    {"in",          T_IN           },
    {"include",     T_INCLUDE      },
    {"load",        T_LOAD         },
    {"not",         T_NOT          },
    {"regroup",     T_REGROUP      },
    {"spacefull",   T_SPACEFULL    },
    {"with",        T_WITH         },
};

/* operators that has more than one letter */
static Keyword aOperatorsTable[] = {
    {"!=",      T_NE   },
    {"&&",      T_AND  },
    {"->",      T_OBJ  },
    {"<=",      T_LE   },
    {"==",      T_EQ   },
    {"===",     T_EQ   },
    {">=",      T_GE   },
    {"||",      T_OR   },
};

static Operator iOperatorsTable[] = {
    {'!',   T_NOT               },
    {'%',   T_MOD               },
    {'(',   T_LPARENT           },
    {')',   T_RPARENT           },
    {'*',   T_TIMES             },
    {'+',   T_PLUS              },
    {',',   T_COMMA             },
    {'-',   T_MINUS             },
    {'.',   T_DOT               },
    {'/',   T_DIV               },
    {':',   T_COLON             },
    {'<',   T_LT                },
    {'>',   T_GT                },
    {'[',   T_BRACKETS_OPEN     },
    {']',   T_BRACKETS_CLOSE    },
    {'|',   T_PIPE              },
};


#define HAANGA_TK_NONE       0x00
#define HAANGA_TK_HTML       0x01
#define HAANGA_TK_ECHO       0x02
#define HAANGA_TK_TAG        0x03
#define HAANGA_TK_COMMENT    0x04

/* Invalid or malformed number */
#define HAANGA_TK_ERR_NUM      0x01

/* TRUE|FALSE */
#define True    0x001
#define False   0x002

#define SWITCH_STATE_IF(str, token, type, new_state, do_return) \
    if (strncmp(str, token, strlen(token)) == 0) { \
        ztok->tType   = type; \
        ztok->state   = HAANGA_TK_##new_state;  \
        ztok->tLength = strlen(token);  \
        ztok->offset += ztok->tLength; \
        strcpy(ztok->tValue,  token); \
        if (do_return) return True; \
    }

static int haanga_gettoken_html(iTokenize * ztok);
static int haanga_gettoken_main(iTokenize * ztok);
static int _is_token_end(char z);
static unsigned char * _get_first_occurrence(unsigned char * z, int n, ...);
static int _get_keyword(unsigned char *z, Keyword * table, int n, int * token, int * len);
static int _get_id(unsigned char *z, int * len);

iTokenize *  haanga_tk_init(const char *z, int length, int alloc)
{
    iTokenize * ztok;
    ztok = (iTokenize *) malloc(sizeof(struct iTokenize));

    if (ztok == NULL) {
        return NULL;
    }

    ztok->tValue = malloc((length+2) * sizeof(char));
    if (ztok->tValue == NULL) {
        free(ztok);
        return NULL;
    }


    if (alloc) {
        ztok->str = (unsigned char *) malloc((length+2) * sizeof(char));
        if (ztok->str == NULL) {
            free(ztok->tValue);
            free(ztok);
            return NULL;
        }
        strncpy(ztok->str, z, length); 
        *(ztok->str+length) = '\0';
        ztok->free = 1;
    } else {
        ztok->str  = z;
        ztok->free = 0;
    }

    strcpy(ztok->open_tag,      "{%");
    strcpy(ztok->open_echo,     "{{");
    strcpy(ztok->open_comment,  "{#");
    strcpy(ztok->close_tag,     "%}");
    strcpy(ztok->close_echo,    "}}");
    strcpy(ztok->close_comment, "#}");

    ztok->tType   = 0;
    ztok->tLength = 0; 
    ztok->length  = length;
    ztok->offset  = 0;
    ztok->line    = 1;
    ztok->tErr    = 0; /* no error (so far :P) */
    ztok->state   = HAANGA_TK_NONE;

    return ztok;
}

void haanga_tk_destroy(iTokenize ** ztok)
{
    if ((*ztok)->free) {
        free((*ztok)->str);
    }
    free((*ztok)->tValue);
    free(*ztok);
    *ztok = NULL;
}

int haanga_gettoken(iTokenize * ztok, int * tokenType)
{
    int i;
    unsigned char * start;

    ztok->tType   = 0;
    ztok->tLength = 0;

    if (ztok->state == HAANGA_TK_NONE) {
        /* get information about the next state */
        start = ztok->str + ztok->offset; 

        /* select correct state */
        SWITCH_STATE_IF(start, ztok->open_tag,  T_TAG_OPEN,  TAG,0);
        SWITCH_STATE_IF(start, ztok->open_comment, T_COMMENT, COMMENT, 0);
        SWITCH_STATE_IF(start, ztok->open_echo, T_PRINT_OPEN, ECHO, 0);

        if (ztok->tType == 0) {
            /* by default */
            ztok->state = HAANGA_TK_HTML;
        }

        if (ztok->state != HAANGA_TK_HTML) {
            *(ztok->tValue + ztok->tLength) = '\0';
            return;
        }

    }

    switch (ztok->state) {
    case HAANGA_TK_HTML:
        haanga_gettoken_html(ztok);
        break;
    case HAANGA_TK_ECHO:
    case HAANGA_TK_TAG:
        haanga_gettoken_main(ztok);
        break;
    }

    *(ztok->tValue + ztok->tLength) = '\0';

}

static int haanga_gettoken_main(iTokenize * ztok)
{
    unsigned char * str;
    unsigned char * start, cchar;
    int dot = -1;
    int n,i;

    str   = ztok->str + ztok->offset;
    start = str;

    ztok->tLength = 0;
    ztok->tErr    = 0; /* No error */

    for (; *str && ztok->tType == 0; str++, ztok->offset++) {
        switch (*str) {

        /* whitespace {{{ */
        case '\n':
            ztok->line++;
            /* new line, increment line */
        case ' ': case '\t': case '\r': case '\f': 
            /* whitespaces are ignored */
            break;
        /* }}} */

        /* string {{{ */
        case '"':
        case '\'':
            cchar = *str;
            for (n=0, str++; *str && *str!=cchar; str++, n++, ztok->offset++) {
                switch (*str) {
                case '\\':
                    str++;
                    ztok->offset++;
                    switch (*str) {
                    case 'n':
                        ztok->tValue[n] =  '\n';
                        break;
                    case 't':
                        ztok->tValue[n] =  '\t';
                        break;
                    default:
                        ztok->tValue[n] =  *str;
                        break;
                    }
                    break;
                default: 
                    if (*str == '\n') {
                        ztok->line++;
                    }
                    ztok->tValue[n] =  *str;
                    break;
                }
            }

            if (*str != cchar) {
                ztok->tErr = 1;
                return False;
            }


            ztok->tLength = n;
            ztok->tType   = T_STRING;
            ztok->offset+=2; /* missing offset last char and cchar */

            return True;


        /* }}} */

        /* number {{{ */
        case '0': case '1': case '2': case '3': case '4':
        case '5': case '6': case '7': case '8': case '9': 
            n = 1;
            start = str;
            for (; n && *str; str++, ztok->offset++) {
                switch (*str) {
                case '0': case '1': case '2': case '3': case '4':
                case '5': case '6': case '7': case '8': case '9': 
                    ztok->tLength++;
                    break;
                case '.':
                    if (dot == -1) {
                        ztok->tLength++;
                        dot = 1;
                    } else {
                        /* error */
                        ztok->tErr = HAANGA_TK_ERR_NUM;
                        return False;
                    }
                    break;
                default:
                    ztok->offset--;
                    n = 0; /* break loop */
                    break;
                }
            }

            str--;

            if (*str == '.' || !_is_token_end(*str)) {
                /* error */
                ztok->tErr = HAANGA_TK_ERR_NUM;
                return False;
            }

            strncpy(ztok->tValue, start, ztok->tLength);

            ztok->tType = T_NUMERIC;

            return True; /* token detected successfully */

        /* number }}} */

        default:
            /* look for end tags */
            SWITCH_STATE_IF(str, ztok->close_tag,  T_TAG_CLOSE,    NONE, 1);
            SWITCH_STATE_IF(str, ztok->close_echo, T_PRINT_CLOSE,  NONE, 1);

            /* try to get keyword */
            if (_get_keyword(str, aKeywordTable, sizeof(aKeywordTable)/sizeof(aKeywordTable[0]), &ztok->tType, &ztok->tLength) == True) {
                ztok->offset += ztok->tLength;
                strncpy(ztok->tValue, str, ztok->tLength);
                return True;
            }

            /* try to get a identifier */
            if (_get_id(str, &ztok->tLength) == True) {
                ztok->tType   = T_ALPHA;
                ztok->offset += ztok->tLength;
                strncpy(ztok->tValue, str, ztok->tLength);
                return True;
            }

            n = sizeof(iOperatorsTable)/sizeof(iOperatorsTable[0]);
            for (i=0; i < n; i++) {
                if (iOperatorsTable[i].zOp == *str) {
                    ztok->tType     = iOperatorsTable[i].tokenType;            
                    ztok->tValue[0] = *str;
                    ztok->tLength   = 1;
                    ztok->offset++;
                    return True;
                }
                if (iOperatorsTable[i].zOp > *str) {
                    break;
                }
            }

            return False;
        }
    }
    
}

/**
 *  Return 1 if the character is considered as "token end" (not 
 *  part of a valid ID). It is useful to avoid treat TRUEfoo (T_ALPHA) as 
 *  TRUE (T_TRUE) and foo (T_ALPHA);
 *
 *  @crodas
 */
static int _is_token_end(char z)
{
    /* [^a-zA-Z0-9_] */
    return !(
        ('a' <= z && 'z' >= z) ||
        ('A' <= z && 'Z' >= z) || 
        ('0' <= z && '9' >= z) || 
        z == '_' 
    );
}

static int haanga_gettoken_html(iTokenize * ztok)
{
    unsigned char *str, * tag, *comment, *echo;
    unsigned char * zLowest =-1;
    int zLength;


    str     = ztok->str + ztok->offset;
    zLowest = _get_first_occurrence(str, 3, ztok->open_tag, ztok->open_echo, ztok->open_comment);

    if (zLowest == NULL) {
        /* no tags were found, everything is HTML */
        ztok->tLength = ztok->length - ztok->offset; /* token end */
    } else {
        /* Length = pointer to tag - pointer to the string */
        ztok->tLength = zLowest - str;
    }


    strncpy(ztok->tValue, str, ztok->tLength); 
    ztok->offset += ztok->tLength;
    ztok->tType  = T_HTML;

    /* line counts */
    int e;
    for (e=0; e < ztok->tLength; e++) {
        if (str[e] == '\n') {
            ztok->line++;
        }
    }

    if (ztok->tLength == 0) {
        ztok->tType = 0;
    }

    /* reset tokenizer state */
    ztok->state  = HAANGA_TK_NONE;

    return True;
}

static int _get_keyword(unsigned char *z, Keyword * table, int n, int * token, int * len)
{
    int i, loop=1;
    for (i=0; i < n; i++) {
        *len = strlen(table[i].zName); 
        switch (strncmp(z, table[i].zName, *len)) {
        case -1:
            i = n; /* break loop */
            break;
        case 0:
            if (_is_token_end(*(z+ *len))) {
                *token = table[i].tokenType;
                return True;
            }
            return False;
        }
    }

    /* custom end */
    if (strncmp(z, "end", 3) == 0 && _get_id(z, len) == True) {
        *token = T_CUSTOM_END;
        return True;
    }

    *len   = 0;
    *token = 0;
    return False;
}

/* [a-zA-Z_][a-zA-Z0-9_]* */
static int _get_id(unsigned char *z, int * len)
{
    int i;
    if (  !('a' <= *z && 'z' >= *z) &&
        !('A' <= *z && 'Z' >= *z) && *z != '_') {
        return False;
    }

    for (*len=0; *z; z++, *len+=1) {
        if ( !('a' <= *z && 'z' >= *z) && !('A' <= *z && 'Z' >= *z) && 
             !('0' <= *z && '9' >= *z) && *z != "_") {
            break;
        }
    }

    return *len == 0 ? False : True;
}

static unsigned char * _get_first_occurrence(unsigned char * z, int n, ...)
{
    unsigned char * zLowest = NULL, *tmp, *ptr;
    va_list ap;
    int i;

    va_start(ap, n);
    for (i=0; i < n; i++) {
        ptr = va_arg(ap, unsigned char *);
        tmp = strstr(z, ptr);
        if (tmp != NULL && (zLowest == NULL || zLowest > tmp)) {
            zLowest = tmp;
        }
    }
    va_end(ap);

    return zLowest; 
}

/**

int main()
{
    iTokenize * tk;
    char * str, *tmp;
    int i;
#define s "<br>\n<html><title>foobar</title>{{ 15   +1 }}\ncesar\n{{ 9.4545 * (9211.442 / 2)}}{% load loading endfoo  \"cesar.html\" %} cesar"
    tk = haanga_tk_init(s,strlen(s),1); 

    for (i=0; i < 22; i++) {
        haanga_gettoken(tk, NULL);
        printf("token = (%d, %s)\toffset=%d\n", tk->tType, tk->tValue, tk->offset);
    }

    haanga_tk_destroy(&tk);
    return;

    str = strdup("token end!");
    tmp = str;
    while (*str) {
        printf("%c %d\n", *str, _is_token_end(*str));
        str++;
    }
    printf("%d", sizeof(iOperatorsTable)/sizeof(iOperatorsTable[0]));
    free(tmp);
}
**/
