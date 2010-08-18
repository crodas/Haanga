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
#include "parser.h"

typedef struct Keyword Keyword;
typedef struct Operator Operator;
typedef struct iTokenize iTokenize;

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
    {"block",       T_BLOCK        },
    {"load",        T_LOAD         },
    {"for",         T_FOR          },
    {"empty",       T_EMPTY        },
    {"TRUE",        T_TRUE         },
    {"FALSE",       T_FALSE        },
    {"AND",         T_AND          },
    {"OR",          T_OR           },
    {"NOT",         T_NOT          },
    {"not",         T_NOT          },
    {"if",          T_IF           },
    {"else",        T_ELSE         },
    {"ifequal",     T_IFEQUAL      },
    {"ifnotequal",  T_IFNOTEQUAL   },
    {"ifchanged",   T_IFCHANGED    },
    {"spacefull",   T_SPACEFULL    },
    {"autoescape",  T_AUTOESCAPE   },
    {"filter",      T_FILTER       },
    {"include",     T_INCLUDE      },
    {"in",          T_IN           },
    {"as",          T_AS           },
    {"by",          T_BY           },
    {"extends",     T_EXTENDS      },
    {"regroup",     T_REGROUP      },
    {"with",        T_WITH         },
    {"_(",          T_INTL         },
};

/* operators that has more than one letter */
static Keyword aOperatorsTable[] = {
    {"&&",      T_AND  },
    {"===",     T_EQ   },
    {"==",      T_EQ   },
    {"->",      T_OBJ  },
    {"||",      T_OR   },
    {"<=",      T_LE   },
    {">=",      T_GE   },
    {"!=",      T_NE   },
};

static Operator iOperatorsTable[] = {
    {'<',   T_LT                },
    {'>',   T_GT                },
    {',',   T_COMMA             },
    {'(',   T_LPARENT           },
    {')',   T_RPARENT           },
    {'%',   T_MOD               },
    {'!',   T_NOT               },
    {'|',   T_PIPE              },
    {'+',   T_PLUS              },
    {'-',   T_MINUS             },
    {'*',   T_TIMES             },
    {'/',   T_DIV               },
    {'.',   T_DOT               },
    {':',   T_COLON             },
    {'[',   T_BRACKETS_OPEN     },
    {']',   T_BRACKETS_CLOSE    },
};


struct iTokenize {
    /* string */
    unsigned char * str; 

    /* string length */
    int length;

    /* should be free the str? */
    int free;

    /* init/end */
    unsigned char open_tag[20];
    unsigned char open_echo[20];
    unsigned char open_comment[20];
    unsigned char close_tag[20];
    unsigned char close_echo[20];
    unsigned char close_comment[20];

    /* current offset */
    int offset;

    /* where is the tokenizer? */
    int state;

    /* Last token information */
    int tType;
    int tErr;
    unsigned char * tValue;
    int tLength;
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

static int haanga_gettoken_html(iTokenize * ztok);
static int haanga_gettoken_main(iTokenize * ztok);
static int _is_token_end(char z);

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
        if (strncmp(start, ztok->open_tag, strlen(ztok->open_tag)) == 0) {
            ztok->state   = HAANGA_TK_TAG;
            ztok->tLength = strlen(ztok->open_tag); 
            strcpy(ztok->tValue, ztok->open_tag);
        } else if (strncmp(start, ztok->open_echo, strlen(ztok->open_echo)) == 0) {
            ztok->state   = HAANGA_TK_ECHO;
            ztok->tLength = strlen(ztok->open_echo); 
            strcpy(ztok->tValue, ztok->open_echo);
        } else if (strncmp(start, ztok->open_comment, strlen(ztok->open_comment)) == 0) {
        } else {
            ztok->state = HAANGA_TK_HTML;
        }

        if (ztok->state != HAANGA_TK_HTML) {
            ztok->offset += ztok->tLength;
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
    unsigned char * start, *token;
    int dot = -1;
    int n,i;

    str   = ztok->str + ztok->offset;
    token = ztok->tValue;
    start = str;

    ztok->tLength = 0;
    ztok->tErr    = 0; /* No error */

    for (; *str && ztok->tType == 0; str++, ztok->offset++) {
        switch (*str) {

        /* number {{{ */
        case '0': case '1': case '2': case '3': case '4':
        case '5': case '6': case '7': case '8': case '9': 
            n = 1;
            for (; n && *str; str++, ztok->offset++) {
                switch (*str) {
                case '0': case '1': case '2': case '3': case '4':
                case '5': case '6': case '7': case '8': case '9': 
                    *token = *str;
                    token++;
                    ztok->tLength++;
                    break;
                case '.':
                    if (dot == -1) {
                        *token = *str;
                        ztok->tLength++;
                        token++;
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
            if (*token == '.' || !_is_token_end(*token)) {
                /* error */
                ztok->tErr = HAANGA_TK_ERR_NUM;
                return False;
            }

            return True; /* token detected successfully */

        /* number }}} */

        default:

            n = sizeof(iOperatorsTable)/sizeof(iOperatorsTable[0]);
            for (i=0; i < n; i++) {
                if (iOperatorsTable[i].zOp == *str) {
                    ztok->tType     = iOperatorsTable[i].tokenType;            
                    ztok->tValue[0] = *str;
                    ztok->tLength   = 1;
                    ztok->offset++;
                    return True;
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

    /* Search in the HTML open tag,echo and comment */
    str     = ztok->str + ztok->offset;
    tag     = strstr(str, ztok->open_tag);
    echo    = strstr(str, ztok->open_echo);
    comment = strstr(str, ztok->open_comment);


    /* select the first comment */
    if (tag != NULL) {
        zLowest = tag;
    }
    if (echo != NULL && (zLowest == -1 || zLowest > echo)) {
        zLowest = echo;
    }
    if (comment != NULL && (zLowest == -1 || zLowest > comment)) {
        zLowest = comment;
    }


    if (zLowest == -1) {
        /* no tags were found, everything is HTML */
        ztok->tLength = ztok->length - ztok->offset; /* token end */
    } else {
        /* Length = pointer to tag - pointer to the string */
        ztok->tLength = zLowest - ztok->str;
    }
    
    strncpy(ztok->tValue, str, ztok->tLength); 
    ztok->offset =+ ztok->tLength;

    /* reset tokenizer state */
    ztok->state  = HAANGA_TK_NONE;

    return 1;

}

int main()
{
    iTokenize * tk;
    char * str, *tmp;
#define s "<br>\n<html>{{15+1}}\n\n{% custom tag %}"
    tk = haanga_tk_init(s,strlen(s),1); 

    haanga_gettoken(tk, NULL);
    printf("token = %s, offset=%d\n", tk->tValue, tk->offset);
    haanga_gettoken(tk, NULL);
    printf("token = %s, offset=%d\n", tk->tValue, tk->offset);
    haanga_gettoken(tk, NULL);
    printf("token = %s, offset=%d\n", tk->tValue, tk->offset);
    haanga_gettoken(tk, NULL);
    printf("token = %s, offset=%d\n", tk->tValue, tk->offset);
    haanga_gettoken(tk, NULL);
    printf("token = %s, offset=%d\n", tk->tValue, tk->offset);

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
