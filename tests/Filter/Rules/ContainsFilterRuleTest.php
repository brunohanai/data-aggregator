<?php

namespace BrunoHanai\DataAggregator\Tests;

use BrunoHanai\DataAggregator\Filter\Rules\ContainsFilterRule;
use Codeception\Specify;

class ContainsFilterRuleTest extends \PHPUnit_Framework_TestCase
{
    use Specify;

    public function testIsValid()
    {
        $this->specify('definindo um array, deve funcionar', function () {
            $rule = new ContainsFilterRule(array(2, 3, 4));

            verify($rule->isValid(1))->false();
            verify($rule->isValid(2))->true();
            verify($rule->isValid(3))->true();
            verify($rule->isValid(4))->true();
            verify($rule->isValid(5))->false();
        });

        $this->specify('definindo um valor normal, deve funcionar também', function () {
            $rule = new ContainsFilterRule(2);

            verify($rule->isValid(1))->false();
            verify($rule->isValid(2))->true();
            verify($rule->isValid(3))->false();
        });
    }
}
