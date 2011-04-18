<?php

class Foo_Bar {
    static $Bar = 'haanga';
    static $Arr = array('foo', 'Bar' => 'Foo');
    protected $foo = 'foo';
    public $bar = 'bar';

    static function something()
    {
        return 'something';
    }

    function method() {
        return $this->foo;
    }

    function bar() {
        return "something else";
    }
}

/**
 *  @runTestsInSeparateProcess
 */
class templateTest extends PHPUnit_Framework_TestCase
{
    public function testInit()
    {
        /* setup */
        @mkdir("tmp/");
        foreach (glob("tmp/*/*") as $file) {
            @unlink($file);
        }
        TestSuite::init();
    }

    public function init($test_file, &$expected)
    {
        if ($test_file == 'assert_templates/strip_whitespace.tpl') {
            Haanga_Compiler::setOption('strip_whitespace', TRUE);
            $expected = rtrim($expected). ' '; /* weird output */
        } else {
            Haanga_Compiler::setOption('strip_whitespace', FALSE);
        }
    }
    /** 
     * @dataProvider tplProvider
     */
    public function testRuntime($test_file, $data, $expected)
    {
        $this->init($test_file, $expected);
        $output = Haanga::Load($test_file, $data, TRUE);
        $this->assertEquals($output, $expected);
    }

    /** 
     * @dataProvider tplProvider
     */
    public function testLambda($test_file, $data, $expected)
    {
        $this->init($test_file, $expected);
        $callback = Haanga::compile(file_get_contents($test_file), $data);
        $output   = $callback($data);
        $this->assertEquals($output, $expected);
    }


    /** 
     * @dataProvider tplProvider
     */
    public function testIsCached($test_file, $data, $expected)
    {
        /* same as above, but we ensure that the file wasn't compiled */
        $this->init($test_file, $expected);
        $output = Haanga::Load($test_file, $data, TRUE);
        $this->assertEquals($output, $expected);
        $this->assertFalse(Haanga::$has_compiled);
    }

    /** 
     * @dataProvider tplProvider 
     * /
    public function testCLICompiler($test_file, $data, $expected)
    {
        TestSuite::init();
        $GLOBALS['argv'][1] = $test_file;
        $GLOBALS['argv'][2] = '--notags';

        ob_start();
        Haanga_Compiler::main_cli();
        $code = ob_get_clean();

        eval($code);

        $file     = basename($test_file);
        $pos      = strpos($file,'.');
        $function = substr($file, 0, $pos).'_template';
        $output   = call_user_func($function, $data, TRUE);

        $this->assertEquals($output, $expected);
    }
    /* */

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
                try {
                    include $data_file;
                } Catch (Exception $e) {
                    continue;
                }
            }
            $datas[] = array($test_file, $data, $expected);
        }

        return $datas;
    }
}
