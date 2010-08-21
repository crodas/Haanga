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

#include "haanga.h"
#include "ext/standard/php_smart_str.h"
#include <string.h>
#include <ctype.h>
 
/* {{{ PHP_MINIT_FUNCTION */
PHP_MINIT_FUNCTION(haanga)
{
}
/* }}} */

PHP_FUNCTION(haanga_tokenizer)
{
    char * text;
    int text_len;
    iTokenize * tk;

    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "s",
        &text, &text_len) == FAILURE) {
        return;
    }

    array_init(return_value);

    tk = haanga_tk_init(text, text_len, 0); 

    while (1) {
        zval *subarray;
        haanga_gettoken(tk, NULL);

        if (tk->tType == 0) {
            break;
        }

        MAKE_STD_ZVAL(subarray);
        array_init(subarray);

        add_assoc_long(subarray, "token", tk->tType);
        add_assoc_string(subarray, "value", tk->tValue, 1);
        add_assoc_long(subarray, "line", tk->line);

        add_next_index_zval(return_value, subarray);
    }

    haanga_tk_destroy(&tk);
}

static function_entry haanga_functions[] = {
    PHP_FE(haanga_tokenizer, NULL)
    { NULL, NULL, NULL }
};

/* {{{ haanga_module_entry
 */
zend_module_entry haanga_module_entry = {
    STANDARD_MODULE_HEADER,
    "haanga",
    haanga_functions,
    PHP_MINIT(haanga),
    NULL,
    NULL,
    NULL,
    PHP_MINFO(haanga),
    PHP_HAANGA_VERSION,
    STANDARD_MODULE_PROPERTIES
};
/* }}} */

/* {{{ PHP_MINFO_FUNCTION */
PHP_MINFO_FUNCTION(haanga)
{
    php_info_print_table_start();
    php_info_print_table_header(2, "haanga native parser", "enabled");
    php_info_print_table_row(2, "Version", PHP_HAANGA_VERSION);
    php_info_print_table_end();
}
/* }}} */

#ifdef COMPILE_DL_HAANGA
ZEND_GET_MODULE(haanga)
#endif

