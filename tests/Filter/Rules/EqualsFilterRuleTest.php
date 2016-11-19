<?php

namespace BrunoHanai\DataAggregator\Tests;

use BrunoHanai\DataAggregator\Filter\Rules\EqualsFilterRule;

class EqualsFilterRuleTest extends \PHPUnit_Framework_TestCase
{
    public function testIsValid()
    {
        $rule = new EqualsFilterRule(123);

        verify($rule->isValid(123))->true();
        verify($rule->isValid(1234))->false();
        verify($rule->isValid('123'))->false();
    }
}
