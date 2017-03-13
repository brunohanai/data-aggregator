<?php

namespace BrunoHanai\DataAggregator\Tests;

use BrunoHanai\DataAggregator\Operation\OperationManualCalc;
use Codeception\Specify;

class OperationManualCalcTest extends \PHPUnit_Framework_TestCase
{
    use Specify;

    public function testDoOperation()
    {
        $data = array('f1' => 1, 'f2' => 2);

//        $calc = new OperationManualCalc('[f1] + [f2]');
//        verify($calc->doOperation(null, null, $data))->equals(3);
//
//        $calc = new OperationManualCalc('([f1] / [f2]) * 100');
//        verify($calc->doOperation(null, null, $data))->equals(50);
    }

    public function testDoOperationAgg()
    {
        $data = array(
            array(
                'recebidas' => 30,
                'kpi_atend_meta' => 70,
            ),
            array(
                'recebidas' => 40,
                'kpi_atend_meta' => 80,
            ),
            array(
                'recebidas' => 100,
                'kpi_atend_meta' => 80,
            ),
        );

        $calc = new OperationManualCalc('[_current] + ([recebidas] * [kpi_atend_meta])');
        $current = 0;

        foreach ($data as $item) {
            $current = $calc->doOperation($current, null, $item);
        }

        verify($current)->equals(13300);
    }

    public function testCalcIsValid()
    {
        $this->specify('calc inválido', function () {
            $calc = new OperationManualCalc('rm -rf .');
        }, array('throws' => 'LogicException'));

        $this->specify('calc inválido', function () {
            $calc = new OperationManualCalc('abc');
        }, array('throws' => 'LogicException'));

        $this->specify('calc válidos', function () {
            $calc = new OperationManualCalc('[f1] + [f2]');
            verify($calc)->isInstanceOf('BrunoHanai\DataAggregator\Operation\OperationManualCalc');

            $calc = new OperationManualCalc('[f1] - [f2]');
            verify($calc)->isInstanceOf('BrunoHanai\DataAggregator\Operation\OperationManualCalc');

            $calc = new OperationManualCalc('[f1] / [f2]');
            verify($calc)->isInstanceOf('BrunoHanai\DataAggregator\Operation\OperationManualCalc');

            $calc = new OperationManualCalc('[f1] * [f2]');
            verify($calc)->isInstanceOf('BrunoHanai\DataAggregator\Operation\OperationManualCalc');

            $calc = new OperationManualCalc('[f1] / [f2] * 100');
            verify($calc)->isInstanceOf('BrunoHanai\DataAggregator\Operation\OperationManualCalc');
        });
    }
}
