<?php
/**
 *  Autoloader function generated by crodas/Autoloader
 *
 *  https://github.com/crodas/Autoloader
 *
 *  This is a generated file, do not modify it.
 */

spl_autoload_register(function ($class) {

    /*
        This array has a map of (class => file)
    */

    // classes {{{
    static $classes = array (
  'haanga' => '/../Haanga.php',
  'haanga_extension' => '/Extension.php',
  'haanga_exception' => '/Exception.php',
  'haanga_compiler' => '/Compiler.php',
  'hg_parser' => '/Compiler/Tokenizer.php',
  'haanga_compiler_parser' => '/Compiler/Parser.php',
  'haanga_compiler_tokenizer' => '/Compiler/Tokenizer.php',
  'haanga_compiler_runtime' => '/Compiler/Runtime.php',
  'haanga_compiler_exception' => '/Compiler/Exception.php',
  'haanga_yytoken' => '/Compiler/Parser.php',
  'haanga_yystackentry' => '/Compiler/Parser.php',
  'haanga_generator_php' => '/Generator/PHP.php',
  'haanga_extension_filter' => '/Extension/Filter.php',
  'haanga_extension_filter_pluralize' => '/Extension/Filter/Pluralize.php',
  'haanga_extension_filter_count' => '/Extension/Filter/Count.php',
  'haanga_extension_filter_json' => '/Extension/Filter/Json.php',
  'haanga_extension_filter_translation' => '/Extension/Filter/Translation.php',
  'haanga_extension_filter_trans' => '/Extension/Filter/Trans.php',
  'haanga_extension_filter_upper' => '/Extension/Filter/Upper.php',
  'haanga_extension_filter_date' => '/Extension/Filter/Date.php',
  'haanga_extension_filter_datef' => '/Extension/Filter/Datef.php',
  'haanga_extension_filter_empty' => '/Extension/Filter/Empty.php',
  'haanga_extension_filter_reverse' => '/Extension/Filter/Reverse.php',
  'haanga_extension_filter_capfirst' => '/Extension/Filter/Capfirst.php',
  'haanga_extension_filter_exists' => '/Extension/Filter/Exists.php',
  'haanga_extension_filter_intval' => '/Extension/Filter/Intval.php',
  'haanga_extension_filter_null' => '/Extension/Filter/Null.php',
  'haanga_extension_filter_safe' => '/Extension/Filter/Safe.php',
  'haanga_extension_filter_truncatechars' => '/Extension/Filter/Truncatechars.php',
  'haanga_extension_filter_hostname' => '/Extension/Filter/Hostname.php',
  'haanga_extension_filter_length' => '/Extension/Filter/Length.php',
  'haanga_extension_filter_trim' => '/Extension/Filter/Trim.php',
  'haanga_extension_filter_title' => '/Extension/Filter/Title.php',
  'haanga_extension_filter_escape' => '/Extension/Filter/Escape.php',
  'haanga_extension_filter_stringformat' => '/Extension/Filter/Stringformat.php',
  'haanga_extension_filter_join' => '/Extension/Filter/Join.php',
  'haanga_extension_filter_linebreaksbr' => '/Extension/Filter/Linebreaksbr.php',
  'haanga_extension_filter_default' => '/Extension/Filter/Default.php',
  'haanga_extension_filter_dictsort' => '/Extension/Filter/Dictsort.php',
  'haanga_extension_filter_substr' => '/Extension/Filter/Substr.php',
  'haanga_extension_filter_urlencode' => '/Extension/Filter/Urlencode.php',
  'haanga_extension_filter_cut' => '/Extension/Filter/Cut.php',
  'haanga_extension_filter_lower' => '/Extension/Filter/Lower.php',
  'haanga_extension_filter_truncatewords' => '/Extension/Filter/Truncatewords.php',
  'haanga_extension_filter_explode' => '/Extension/Filter/Explode.php',
  'haanga_extension_filter_isarray' => '/Extension/Filter/Isarray.php',
  'haanga_extension_filter_slugify' => '/Extension/Filter/Slugify.php',
  'haanga_extension_filter_inarray' => '/Extension/Filter/Inarray.php',
  'haanga_extension_tag' => '/Extension/Tag.php',
  'haanga_extension_tag_min' => '/Extension/Tag/Min.php',
  'haanga_extension_tag_upper' => '/Extension/Tag/Upper.php',
  'haanga_extension_tag_tryinclude' => '/Extension/Tag/Tryinclude.php',
  'haanga_extension_tag_setsafe' => '/Extension/Tag/Setsafe.php',
  'haanga_extension_tag_trans' => '/Extension/Tag/Trans.php',
  'haanga_extension_tag_inline' => '/Extension/Tag/Inline.php',
  'haanga_extension_tag_exec' => '/Extension/Tag/Exec.php',
  'haanga_extension_tag_buffer' => '/Extension/Tag/Buffer.php',
  'haanga_extension_tag_currenttime' => '/Extension/Tag/Currenttime.php',
  'haanga_extension_tag_spaceless' => '/Extension/Tag/Spaceless.php',
  'haanga_extension_tag_templatetag' => '/Extension/Tag/Templatetag.php',
  'haanga_extension_tag_cycle' => '/Extension/Tag/Cycle.php',
  'haanga_extension_tag_dictsort' => '/Extension/Tag/Dictsort.php',
  'haanga_extension_tag_firstof' => '/Extension/Tag/Firstof.php',
  'haanga_extension_tag_lower' => '/Extension/Tag/Lower.php',
  'haanga_extension_tag_css' => '/Extension/Tag/Css.php',
  'haanga_extension_tag_js' => '/Extension/Tag/Js.php',
  'haanga_extension_tag_def' => '/Extension/Tag/Def.php',
  'haanga_extension_tag_partial' => '/Extension/Tag/Partial.php',
  'haanga_ast' => '/AST.php',
);
    // }}}

    // deps {{{
    static $deps    = array (
  'hg_parser' => 
  array (
    0 => 'haanga_compiler_parser',
  ),
  'haanga_compiler_runtime' => 
  array (
    0 => 'haanga_compiler',
  ),
  'haanga_extension_filter' => 
  array (
    0 => 'haanga_extension',
  ),
  'haanga_extension_filter_translation' => 
  array (
    0 => 'haanga_extension_filter_trans',
  ),
  'haanga_extension_tag' => 
  array (
    0 => 'haanga_extension',
  ),
);
    // }}}

    $class = strtolower($class);
    if (isset($classes[$class])) {
        if (!empty($deps[$class])) {
            foreach ($deps[$class] as $zclass) {
                if (!class_exists($zclass, false)) {
                    require __DIR__  . $classes[$zclass];
                }
            }
        }

        if (!class_exists($class, false)) {

            require __DIR__  . $classes[$class];

        }
        return true;
    }

    return false;
});


