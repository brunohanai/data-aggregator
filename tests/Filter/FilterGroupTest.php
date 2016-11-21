<?php

namespace BrunoHanai\DataAggregator\Tests;

use BrunoHanai\DataAggregator\Filter\Evaluator\Strategy\AffirmativeStrategy;
use BrunoHanai\DataAggregator\Filter\Evaluator\Strategy\ConsensusStrategy;
use BrunoHanai\DataAggregator\Filter\Evaluator\Strategy\UnanimousStrategy;
use BrunoHanai\DataAggregator\Filter\Filter;
use BrunoHanai\DataAggregator\Filter\FilterGroup;
use BrunoHanai\DataAggregator\Filter\Rules\EqualsFilterRule;
use BrunoHanai\DataAggregator\Filter\Rules\GreaterThanFilterRule;
use BrunoHanai\DataAggregator\Filter\Rules\LessThanFilterRule;
use BrunoHanai\DataAggregator\Filter\Rules\NotEqualsFilterRule;
use Codeception\Specify;

class FilterGroupTest extends \PHPUnit_Framework_TestCase
{
    use Specify;

    public function testIsValid()
    {
        $this->specify('Sem regras', function () {
            $filter = new FilterGroup(new AffirmativeStrategy());
            verify('sem Rule, retornar true', $filter->isValid(1))->true();
        });

        $this->specify('Apenas 1 regra, alternando o evaluator', function () {
            $filter = new FilterGroup(new AffirmativeStrategy());
            $filter->addFilter(new Filter(new EqualsFilterRule(1)));

            $filter->setEvaluatorStrategy(new AffirmativeStrategy());
            verify($filter->isValid(1))->true();
            verify($filter->isValid(0))->false();

            $filter->setEvaluatorStrategy(new ConsensusStrategy());
            verify($filter->isValid(1))->true();
            verify($filter->isValid(0))->false();

            $filter->setEvaluatorStrategy(new UnanimousStrategy());
            verify($filter->isValid(1))->true();
            verify($filter->isValid(0))->false();
        });

        $this->specify('Três regras, alternando o evaluator', function () {
            $filter = new FilterGroup(new AffirmativeStrategy());

            $filter->addFilter(new Filter(new GreaterThanFilterRule(0)));
            $filter->addFilter(new Filter(new LessThanFilterRule(10)));
            $filter->addFilter(new Filter(new NotEqualsFilterRule(5)));

            $filter->setEvaluatorStrategy(new AffirmativeStrategy());
            verify($filter->isValid(9))->true();
            verify($filter->isValid(11))->true();

            $filter->setEvaluatorStrategy(new ConsensusStrategy());
            verify($filter->isValid(5))->true();
            verify($filter->isValid(11))->true();

            $filter->setEvaluatorStrategy(new UnanimousStrategy());
            verify($filter->isValid(5))->false();
            verify($filter->isValid(11))->false();
            verify($filter->isValid(9))->true();
        });
    }
}
