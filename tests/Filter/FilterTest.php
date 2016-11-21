<?php

namespace BrunoHanai\DataAggregator\Tests;

use BrunoHanai\DataAggregator\Filter\Filter;
use BrunoHanai\DataAggregator\Filter\Rules\EqualsFilterRule;
use Codeception\Specify;

class FilterTest extends \PHPUnit_Framework_TestCase
{
    use Specify;

    public function testIsValid()
    {
        $filter = new Filter();

        verify('sem Rule, retornar true', $filter->isValid(1))->true();

        $filter->setRule(new EqualsFilterRule(1));
        verify($filter->isValid(1))->true();
        verify($filter->isValid(2))->false();
    }
}
