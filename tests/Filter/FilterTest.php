<?php

namespace BrunoHanai\DataAggregator\Tests;

use BrunoHanai\DataAggregator\Filter\Filter;
use BrunoHanai\DataAggregator\Filter\Rules\EqualsFilterRule;
use BrunoHanai\DataAggregator\Filter\Rules\GreaterThanFilterRule;
use BrunoHanai\DataAggregator\Filter\Rules\LessThanFilterRule;
use BrunoHanai\DataAggregator\Filter\Rules\NotEqualsFilterRule;
use Codeception\Specify;

class FilterTest extends \PHPUnit_Framework_TestCase
{
    use Specify;

    public function testIsValid()
    {
        $this->specify('teste com 1 única regra', function () {
            $filter = new Filter();
            $filter->addRule(new EqualsFilterRule(5));

            $filter->setStrategy(Filter::FILTER_STRATEGY_AFFIRMATIVE);
            verify('affirmative strategy', $filter->isValid(5))->true();

            $filter->setStrategy(Filter::FILTER_STRATEGY_CONSENSUS);
            verify('consensus strategy', $filter->isValid(5))->true();

            $filter->setStrategy(Filter::FILTER_STRATEGY_UNANIMOUS);
            verify('unanimous strategy', $filter->isValid(5))->true();

            $filter->setStrategy(Filter::FILTER_STRATEGY_AFFIRMATIVE);
            verify('affirmative strategy', $filter->isValid(4))->false();

            $filter->setStrategy(Filter::FILTER_STRATEGY_CONSENSUS);
            verify('consensus strategy', $filter->isValid(4))->false();

            $filter->setStrategy(Filter::FILTER_STRATEGY_UNANIMOUS);
            verify('unanimous strategy', $filter->isValid(4))->false();
        });

        $this->specify('teste com 3 regras', function () {
            $filter = new Filter();
            $filter->addRule(new GreaterThanFilterRule(10));
            $filter->addRule(new LessThanFilterRule(20));
            $filter->addRule(new NotEqualsFilterRule(15));
            $filter->addRule(new NotEqualsFilterRule(21));

            $filter->setStrategy(Filter::FILTER_STRATEGY_AFFIRMATIVE);
            verify('affirmative strategy', $filter->isValid(15))->true();

            $filter->setStrategy(Filter::FILTER_STRATEGY_CONSENSUS);
            verify('consensus strategy', $filter->isValid(15))->true();

            $filter->setStrategy(Filter::FILTER_STRATEGY_UNANIMOUS);
            verify('unanimous strategy', $filter->isValid(15))->false();

            $filter->setStrategy(Filter::FILTER_STRATEGY_AFFIRMATIVE);
            verify('affirmative strategy', $filter->isValid(21))->true();

            $filter->setStrategy(Filter::FILTER_STRATEGY_CONSENSUS);
            verify('consensus strategy', $filter->isValid(21))->false();

            $filter->setStrategy(Filter::FILTER_STRATEGY_UNANIMOUS);
            verify('unanimous strategy', $filter->isValid(21))->false();
        });
    }
}
