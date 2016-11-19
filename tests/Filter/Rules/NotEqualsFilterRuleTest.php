<?php

namespace BrunoHanai\DataAggregator\Tests;

use BrunoHanai\DataAggregator\Filter\Rules\NotEqualsFilterRule;

class NotEqualsFilterRuleTest extends \PHPUnit_Framework_TestCase
{
    public function testIsValid()
    {
        $rule = new NotEqualsFilterRule(123);

        verify($rule->isValid(123))->false();
        verify($rule->isValid(1234))->true();
        verify($rule->isValid('123'))->true();
    }
}
