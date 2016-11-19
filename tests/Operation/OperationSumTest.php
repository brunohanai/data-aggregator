<?php

namespace BrunoHanai\DataAggregator\Tests;

use BrunoHanai\DataAggregator\Operation\OperationSum;
use Codeception\Specify;

class OperationSumTest extends \PHPUnit_Framework_TestCase
{
    use Specify;

    /** @var $operation OperationSum */
    private $operation;

    public function setUp()
    {
        $this->operation = new OperationSum();
    }

    public function testDoOperation()
    {
        $this->specify('$current_value não numérico, deve lançar uma exceção', function () {
            $this->operation->doOperation('a', 0);
        }, array('throws' => 'LogicException'));

        $this->specify('$new_value não numérico, deve lançar uma exceção', function () {
            $this->operation->doOperation(0, 'a');
        }, array('throws' => 'LogicException'));

        $this->specify('numérico formatado como texto, não deve lançar uma exceção', function () {
            verify($this->operation->doOperation(0, '1'))->equals(1);
            verify($this->operation->doOperation('1', 0))->equals(1);
            verify($this->operation->doOperation('1', '1'))->equals(2);
        });

        $this->specify('deve calcular corretamente', function () {
            verify($this->operation->doOperation(1, 1))->equals(2);
            verify($this->operation->doOperation(3, 7))->equals(10);
            verify($this->operation->doOperation(7, 3))->equals(10);
            verify($this->operation->doOperation(10, -5))->equals(5);
            verify($this->operation->doOperation(-5, -5))->equals(-10);
        });
    }
}
