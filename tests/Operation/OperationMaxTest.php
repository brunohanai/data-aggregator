<?php

namespace BrunoHanai\DataAggregator\Tests;

use BrunoHanai\DataAggregator\Operation\OperationMax;
use Codeception\Specify;

class OperationMaxTest extends \PHPUnit_Framework_TestCase
{
    use Specify;

    /** @var $operation OperationMax */
    private $operation;

    public function setUp()
    {
        $this->operation = new OperationMax();
    }

    public function testDoOperation()
    {
        $this->specify('testes passando valores númericos, deve funcionar', function () {
            verify($this->operation->doOperation(1, 1))->equals(1);
            verify($this->operation->doOperation(1, 2))->equals(2);
            verify($this->operation->doOperation(2, 1))->equals(2);
        });

        $this->specify('testes passando valores não numéricos, deve considerar o valor como 0', function () {
            verify($this->operation->doOperation(1, null))->equals(1);
            verify($this->operation->doOperation(null, 1))->equals(1);
            verify($this->operation->doOperation(null, null))->equals(0);
            verify($this->operation->doOperation('texto', 'texto'))->equals(0);
        });
    }
}
