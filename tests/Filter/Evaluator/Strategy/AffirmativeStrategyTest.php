<?php

namespace BrunoHanai\DataAggregator\Tests;

use BrunoHanai\DataAggregator\Filter\Evaluator\Strategy\AffirmativeStrategy;

class AffirmativeStrategyTest extends \PHPUnit_Framework_TestCase
{
    public function testEvaluate()
    {
        $evaluator = new AffirmativeStrategy();

        verify($evaluator->evaluate(1, 0))->true();
        verify($evaluator->evaluate(10, 10))->true();
        verify($evaluator->evaluate(1, 100))->true();
    }
}
