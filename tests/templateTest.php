<?php

class templateTest extends PHPUnit_Framework_TestCase
{
    public function testInit()
    {
        /* setup */
        @mkdir("tmp/");
        Haanga::setCacheDir("tmp/");
        Haanga::setTemplateDir(".");
        Haanga::enableDebug(TRUE);
        foreach (glob("tmp/*") as $file) {
            unlink($file);
        }
    }

    /** 
     * @dataProvider tplProvider
     */
    public function testRuntime($test_file, $data, $expected)
    {
        $output   = Haanga::Load($test_file, $data, TRUE);
        /*$output   = str_replace(" ", '\s', $output);
        $expected = str_replace(" ", '\s', $expected);/**/
        $this->assertEquals($output, $expected);
    }

    /** 
     * @dataProvider tplProvider
     */
    public function testIsCached($test_file, $data, $expected)
    {
        /* same as above, but we ensure that the file wasn't compiled */
        $output = Haanga::Load($test_file, $data, TRUE);
        $this->assertEquals($output, $expected);
        $this->assertFalse(Haanga::$has_compiled);
    }


    /** 
     * @dataProvider tplProvider
     */
    public function testCompiler($test_file, $data, $expected)
    {
        $GLOBALS['argv'][1] = $test_file;
        $GLOBALS['argv'][2] = '--notags';
        $GLOBALS['argv'][3] = '--save';

        ob_start();
        Haanga_Compiler::main_cli();
        $code = ob_get_clean();

        eval($code);

        $file     = basename($test_file);
        $pos      = strpos($file,'.');
        $function = substr($file, 0, $pos).'_template';
        $output   = call_user_func($function, $data, TRUE);

        if ($output != $expected) {
            die($code);
        }
        $this->assertEquals($output, $expected);
    }

    public function tplProvider()
    {
        $datas = array();
        foreach (glob("assert_templates/*.tpl") as $test_file) {
            $data = array();
            $data_file = substr($test_file, 0, -3)."php";
            $expected  = substr($test_file, 0, -3)."html";
            if (!is_file($expected)) {
                if (!is_file($expected.".php")) {
                    continue;
                } 
                $expected .= ".php";
                ob_start();
                require $expected;
                $expected = ob_get_clean();
            } else {
                $expected = file_get_contents($expected);
            }

            if (is_file($data_file)) {
                include $data_file;
            }
            $datas[] = array($test_file, $data, $expected);
        }

        return $datas;
    }
}
