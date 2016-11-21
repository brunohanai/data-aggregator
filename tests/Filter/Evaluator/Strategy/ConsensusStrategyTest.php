<?php

namespace BrunoHanai\DataAggregator\Tests;

use BrunoHanai\DataAggregator\Filter\Evaluator\Strategy\ConsensusStrategy;

class ConsensusStrategyTest extends \PHPUnit_Framework_TestCase
{
    public function testEvaluate()
    {
        $evaluator = new ConsensusStrategy();

        verify($evaluator->evaluate(1, 0))->true();
        verify($evaluator->evaluate(10, 10))->false();
        verify($evaluator->evaluate(1, 100))->false();
    }
}
