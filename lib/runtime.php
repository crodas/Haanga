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


// Haanga_Exception {{{
/**
 *  General exception class. It is thrown 
 *  when something is not configured properly
 *
 */
class Haanga_Exception extends Exception
{
}
// }}}

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
    public static $has_compiled;

    private function __construct()
    {
        /* The class can't be instanced */
    }

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

    // doInclude(s tring $file) {{{
    /**
     *  Load a PHP file using Haanga's root dir as 
     *  base dir.
     *
     *  @param string $file File
     *
     *  @return void
     */
    public static function doInclude($file)
    {
        require_once dirname(__FILE__)."/".$file;
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
        if (empty(self::$cache_dir) || empty(self::$templates_dir)) {
            throw new Haanga_Exception("Cache dir or template dir is missing");
        }

        self::$has_compiled = FALSE;

        $tpl      = self::$templates_dir.'/'.$file;
        $fnc      =  sha1($tpl);
        $php      = self::$cache_dir.'/'.$fnc.'.php';
        $callback = "haanga_".$fnc;

        if (is_callable($callback)) {
            return $callback($vars, $return, $blocks);
        }

        if (!is_file($php) && !is_file($tpl)) {
            throw new Exception("View {$file} doesn't exists");
        }

        if (!is_file($php) || filemtime($tpl) > filemtime($php)) {
            if (!$compiler) {
                require_once dirname(__FILE__)."/haanga.php";
                $compiler = new Haanga_Compiler_Runtime;
            }
            $compiler->reset();
            if (self::$debug) {
                $compiler->setDebug($php.".dump");
            }

            try {
                $code = $compiler->compile_file($tpl, FALSE);
            } catch (Exception $e) {
                throw new Haanga_CompilerException($tpl.' :'.$e->getMessage());
            }

            file_put_contents($php, "<?php".$code);
            self::$has_compiled = TRUE;
        }
        if (!is_callable($callback)) {
            require_once $php;
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
