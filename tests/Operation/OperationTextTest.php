<?php

namespace BrunoHanai\DataAggregator\Tests;

use BrunoHanai\DataAggregator\Operation\OperationText;
use Codeception\Specify;

class OperationTextTest extends \PHPUnit_Framework_TestCase
{
    use Specify;

    /** @var $operation OperationText */
    private $operation;

    public function setUp()
    {
        $this->operation = new OperationText();
    }

    public function testDoOperation()
    {
        $this->specify('sobrescrever valor atual pelo novo', function () {
            verify($this->operation->doOperation('a', 'b'))->equals('b');
        });
    }
}
