<?php

namespace BrunoHanai\DataAggregator\Tests;

use BrunoHanai\DataAggregator\Filter\Evaluator\FilterEvaluator;
use BrunoHanai\DataAggregator\Filter\Evaluator\Strategy\AffirmativeStrategy;
use BrunoHanai\DataAggregator\Filter\Evaluator\Strategy\ConsensusStrategy;
use BrunoHanai\DataAggregator\Filter\Evaluator\Strategy\UnanimousStrategy;
use BrunoHanai\DataAggregator\Filter\Filter;
use BrunoHanai\DataAggregator\Filter\Rules\EqualsFilterRule;
use Codeception\Specify;

class FilterEvaluatorTest extends \PHPUnit_Framework_TestCase
{
    use Specify;

    public function testAppendItem()
    {
        $this->specify('Alternando as estratégias', function () {
            $evaluator = new FilterEvaluator();

            $evaluator->appendItem(new Filter(new EqualsFilterRule(1)), 1);
            verify($evaluator->evaluate(new AffirmativeStrategy()))->true();
            verify($evaluator->evaluate(new ConsensusStrategy()))->true();
            verify($evaluator->evaluate(new UnanimousStrategy()))->true();

            $evaluator->appendItem(new Filter(new EqualsFilterRule(10)), 1);
            verify($evaluator->evaluate(new AffirmativeStrategy()))->true();
            verify($evaluator->evaluate(new ConsensusStrategy()))->false();
            verify($evaluator->evaluate(new UnanimousStrategy()))->false();
        });
    }
}
