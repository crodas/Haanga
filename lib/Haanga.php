<?php
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


/**
 *  Haanga Runtime class
 *
 *  Simple class to call templates efficiently. This class aims
 *  to reduce the compilation of a template as less a possible. Also
 *  it will not load in memory the compiler, except when there is not
 *  cache (compiled template) or it is out-dated.
 *
 */
class Haanga
{
    protected static $cache_dir;
    protected static $templates_dir='.';
    protected static $debug;
    protected static $onCompile = NULL;
    protected static $check_ttl;
    protected static $check_get;
    protected static $check_set;
    protected static $use_autoload  = TRUE;
    protected static $hash_filename = TRUE;

    public static $has_compiled;

    private function __construct()
    {
        /* The class can't be instanced */
    }

    final public static function AutoLoad($class)
    {
        static $loaded = array();
        static $path;

        if (!isset($loaded[$class]) && substr($class, 0, 6) === 'Haanga' && !class_exists($class, false)) {
            if ($path === NULL) {
                $path = dirname(__FILE__);
            }
            $file = $path.DIRECTORY_SEPARATOR.str_replace('_', DIRECTORY_SEPARATOR, $class).'.php';
            if (is_file($file)) {
                require $file;
            }
            $loaded[$class] = TRUE;
            return;
        }

        return FALSE;
    }

    // configure(Array $opts) {{{
    /**
     *  Configuration to load Haanga
     *
     *  Options:
     *
     *      - (string)   cache_dir 
     *      - (string)   tempalte_dir
     *      - (callback) on_compile
     *      - (boolean)  debug
     *      - (int)      check_ttl
     *      - (callback) check_get
     *      - (callback) check_set
     *      - (boolean)  autoload
     *      - (boolean)  use_hash_filename
     *
     *  @return void
     */
    final public static function configure(Array $opts)
    {
        foreach ($opts as $option => $value) {
            switch (strtolower($option)) {
            case 'cache_dir':
                self::setCacheDir($value);
                break;
            case 'template_dir':
                self::setTemplateDir($value);
                break;
            case 'on_compile':
                if (is_callable($value)) {
                    self::$onCompile = $value;
                }
                break;
            case 'debug':
                self::enableDebug((bool)$value);
                break;
            case 'check_ttl':
                self::$check_ttl = (int)$value;
                break;
            case 'check_get':
                if (is_callable($value)) {
                    self::$check_get = $value;
                }
                break;
            case 'check_set':
                if (is_callable($value)) {
                    self::$check_set = $value;
                }
                break;
            case 'autoload':
                self::$use_autoload = (bool)$value;
                break;
            case 'use_hash_filename':
                self::$hash_filename = (bool)$value;
            default:
                continue;
            }
        }
    }
    // }}}

    // setCacheDir(string $dir) {{{
    /**
     *  Set the directory where the compiled templates
     *  are stored.
     *
     *  @param string $dir 
     *
     *  @return void
     */
    public static function setCacheDir($dir)
    {
        if (!is_dir($dir)) {
            throw new Haanga_Exception("{$dir} is not a valid directory");
        }
        if (!is_writable($dir)) {
            throw new Haanga_Exception("{$dir} can't be written");
        }
        self::$cache_dir = $dir;
    }
    // }}}

    // setTemplateDir(string $dir) {{{
    /**
     *  Set the directory where the templates are located.
     *
     *  @param string $dir
     *
     *  @return void
     */
    public static function setTemplateDir($dir)
    {
        if (!is_dir($dir)) {
            throw new Haanga_Exception("{$dir} is not a valid directory");
        }
        self::$templates_dir = $dir;
    }
    // }}}

    // enableDebug($bool) {{{
    public static function enableDebug($bool)
    {
        self::$debug = $bool;
    }
    // }}}

    // load(string $file, array $vars, bool $return, array $blocks) {{{
    /**
     *  Load
     *
     *  Load template. If the template is already compiled, just the compiled
     *  PHP file will be included an used. If the template is new, or it 
     *  had changed, the Haanga compiler is loaded in memory, and the template
     *  is compiled.
     *
     *
     *  @param string $file
     *  @param array  $vars 
     *  @param bool   $return
     *  @param array  $blocks   
     *
     *  @return string|NULL
     */
    public static function Load($file, $vars = array(), $return=FALSE, $blocks=array())
    {
        static $compiler;
        if (empty(self::$cache_dir)) {
            throw new Haanga_Exception("Cache dir or template dir is missing");
        }

        self::$has_compiled = FALSE;

        $tpl      = self::$templates_dir.'/'.$file;
        $fnc      = sha1($tpl);
        $callback = "haanga_".$fnc;
        $php = self::$cache_dir.'/'.(self::$hash_filename ? $fnc : str_replace(DIRECTORY_SEPARATOR, '_', $file)).'.php';

        if (is_callable($callback)) {
            return $callback($vars, $return, $blocks);
        }

        $check = TRUE;

        if (self::$check_ttl && self::$check_get && self::$check_set) {
            /* */
            if (call_user_func(self::$check_get, $callback)) {
                /* disable checking for the next $check_ttl seconds */
                $check = FALSE;
            } else {
                $result = call_user_func(self::$check_set, $callback, TRUE, self::$check_ttl);
            }
        } 
        
        if (!is_file($php) || ($check && filemtime($tpl) > filemtime($php))) {

            if (!is_file($tpl)) {
                /* There is no template nor compiled file */
                throw new Exception("View {$file} doesn't exists");
            }

            /* recompile */
            if (!$compiler) {
                /* load compiler (done just once) */
                if (self::$use_autoload) {
                    spl_autoload_register(array(__CLASS__, 'AutoLoad'));
                }

                $compiler = new Haanga_Compiler_Runtime;

                if (self::$onCompile) {
                    /* call onCompile hook, just the first time */
                    call_user_func(self::$onCompile);
                }
            }

            $compiler->reset();

            if (self::$debug) {
                $compiler->setDebug($php.".dump");
            }

            $code = $compiler->compile_file($tpl, FALSE);

            file_put_contents($php, "<?php".$code);
            self::$has_compiled = TRUE;
        }

        if (!is_callable($callback)) {
            require $php;
        }

        return $callback($vars, $return, $blocks);
    }
    // }}}

}

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 * vim600: sw=4 ts=4 fdm=marker
 * vim<600: sw=4 ts=4
 */
