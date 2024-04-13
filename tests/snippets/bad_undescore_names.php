<?php

namespace mrsatik\CodestyleTest\snippets;

// Для мягких проверок файл плохой
// Для жестких проверок -- хороший
class TestUnderscore
{
    public $a;
    protected $_b;
    private $_c;

    public function __contruct()
    {
        $this->a = 1;
        $this->_b = [];
        $this->_c = 'asd';
    }

    protected function getC()
    {
        return $this->_c;
    }

    public function _getB()
    {
        return $this->_b;
    }
}
