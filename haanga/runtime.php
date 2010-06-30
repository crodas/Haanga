<?php


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

    private function __construct()
    {
        /* The class can't be instanced */
    }

    public static function setCacheDir($dir)
    {
        if (!is_dir($dir)) {
            throw new Exception("{$dir} is not a valid directory");
        }
        if (!is_writable($dir)) {
            throw new Exception("{$dir} can't be written");
        }
        self::$cache_dir = $dir;
    }

    public static function setTemplateDir($dir)
    {
        if (!is_dir($dir)) {
            throw new Exception("{$dir} is not a valid directory");
        }
        if (!is_writable($dir)) {
            throw new Exception("{$dir} can't be written");
        }
        self::$templates_dir = $dir;
    }

    public static function Load($file, $vars = array(), $blocks=array(), $return=FALSE)
    {
        static $compiler;
        if (empty(self::$cache_dir) || empty(self::$templates_dir)) {
            throw new Exception("Cache dir or template dir is missing");
        }
        $tpl = self::$templates_dir.'/'.$file;
        $fnc = sha1($tpl);
        $php = self::$cache_dir.'/'.$fnc.'.php';

        if (!is_file($php) && !is_file($tpl)) {
            throw new Exception("View {$file} doesn't exists");
        }

        if (!is_file($php) || filemtime($tpl) > filemtime($php)) {
            if (!$compiler) {
                require_once dirname(__FILE__)."/haanga.php";
                $compiler = new Haanga_Main_Runtime;
            }
            $code = $compiler->compile_file($tpl, $tpl);
            file_put_contents($php, "<?php\n\n".$code);
        }
        $callback = "haanga_".$fnc;
        if (!is_callable($callback)) {
            require_once $php;
        }
        return $callback($vars, $blocks, $return);
    }
}
