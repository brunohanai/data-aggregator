<?php

namespace BrunoHanai\DataAggregator\Tests;

use BrunoHanai\DataAggregator\Filter\Rules\NotContainsFilterRule;
use Codeception\Specify;

class NotContainsFilterRuleTest extends \PHPUnit_Framework_TestCase
{
    use Specify;

    public function testIsValid()
    {
        $this->specify('definindo um array, deve funcionar', function () {
            $rule = new NotContainsFilterRule(array(2, 3, 4));

            verify($rule->isValid(1))->true();
            verify($rule->isValid(2))->false();
            verify($rule->isValid(3))->false();
            verify($rule->isValid(4))->false();
            verify($rule->isValid(5))->true();
        });

        $this->specify('definindo um valor normal, deve funcionar também', function () {
            $rule = new NotContainsFilterRule(2);

            verify($rule->isValid(1))->true();
            verify($rule->isValid(2))->false();
            verify($rule->isValid(3))->true();
        });
    }
}
