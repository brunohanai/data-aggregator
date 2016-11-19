<?php

namespace BrunoHanai\DataAggregator\Tests;

use BrunoHanai\DataAggregator\Operation\OperationIncrement;
use Codeception\Specify;

class OperationIncrementTest extends \PHPUnit_Framework_TestCase
{
    use Specify;

    /** @var $operation OperationIncrement */
    private $operation;

    public function setUp()
    {
        $this->operation = new OperationIncrement();
    }

    public function testDoOperation()
    {
        $this->specify('$current_value não numérico, deve lançar uma exceção', function () {
            $this->operation->doOperation('a');
        }, array('throws' => 'LogicException'));

        $this->specify('numérico formatado como texto, não deve lançar uma exceção', function () {
            verify($this->operation->doOperation('1'))->equals(2);
        });

        $this->specify('deve calcular corretamente', function () {
            verify($this->operation->doOperation(1))->equals(2);
            verify($this->operation->doOperation(3))->equals(4);
            verify($this->operation->doOperation(-1))->equals(0);
            verify($this->operation->doOperation(-5))->equals(-4);
        });
    }
}
