<?php

class templateTest extends PHPUnit_Framework_TestCase
{
    function testCompilation()
    {
        /* setup */
        @mkdir("tmp/");
        Haanga::setCacheDir("tmp/");
        Haanga::setTemplateDir(".");

        foreach (glob("templates/*.tpl") as $test_file) {
            $data = array();
            $data_file = substr($test_file, 0, -3)."php";
            $expected  = substr($test_file, 0, -3)."html";
            if (is_file($data_file)) {
                include $data_file;
            }
            $output = Haanga::Load($test_file, $data, TRUE);
            $this->assertEquals($output, file_get_contents($expected));
        }

        foreach (glob("tmp/*") as $file) {
            unlink($file);
        }
    }
}
