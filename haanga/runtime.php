<?php


class Haanga_Exception extends Exception
{
}

/**
 *  Haanga Runtime class
 *
 *  Load a template, if the template does not exists or it 
 *  has changed, this class will compile it and update the cache
 */
class Haanga
{
    protected static $cache_dir;
    protected static $templates_dir;
    public static $has_compiled;

    private function __construct()
    {
        /* The class can't be instanced */
    }

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

    public static function setTemplateDir($dir)
    {
        if (!is_dir($dir)) {
            throw new Haanga_Exception("{$dir} is not a valid directory");
        }
        self::$templates_dir = $dir;
    }

    // doInclude(string $file) {{{
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
                $compiler = new Haanga_Main_Runtime;
            }
            $compiler->reset();
            //$compiler->setDebug($php.".dump");
            $code = $compiler->compile_file($tpl, $tpl);
            file_put_contents($php, "<?php".$code);
            self::$has_compiled = TRUE;
        }
        if (!is_callable($callback)) {
            require_once $php;
        }

        return $callback($vars, $return, $blocks);
    }
}

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 * vim600: sw=4 ts=4 fdm=marker
 * vim<600: sw=4 ts=4
 */
