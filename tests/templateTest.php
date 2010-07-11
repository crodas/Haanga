<?php

class templateTest extends PHPUnit_Framework_TestCase
{
    public function testInit()
    {
        /* setup */
        @mkdir("tmp/");
        Haanga::setCacheDir("tmp/");
        Haanga::setTemplateDir(".");
        foreach (glob("tmp/*") as $file) {
            unlink($file);
        }
    }


    /** 
     * @dataProvider tplProvider
     */
    public function testCompilation($test_file, $data, $expected)
    {
        $output   = Haanga::Load($test_file, $data, TRUE);
        $expected = file_get_contents($expected);
        /*$output   = str_replace(" ", '\s', $output);
        $expected = str_replace(" ", '\s', $expected);*/
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
                continue;
            }
            if (is_file($data_file)) {
                include $data_file;
            }
            $datas[] = array($test_file, $data, $expected);
        }

        return $datas;
    }
}
