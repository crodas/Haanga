<?php

class errorTest extends PHPUnit_Framework_TestCase
{
    /** 
     * @dataProvider tplProvider
     *  
     */
    function testInvalidForloop($tpl)
    {
        $this->setExpectedException('CompileException');
        Haanga::Load($tpl);
    }

    public function tplProvider()
    {
        $datas = array();
        foreach (glob("err_templates/*.tpl") as $err_file) {
            $datas[] = array($err_file);
        }

        return $datas;
    }

}

