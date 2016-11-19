<?php

namespace BrunoHanai\DataAggregator\Tests;

use BrunoHanai\DataAggregator\Filter\Rules\GreaterThanFilterRule;
use Codeception\Specify;

class GreaterThanFilterRuleTest extends \PHPUnit_Framework_TestCase
{
    use Specify;

    public function testIsValid()
    {
        $rule = new GreaterThanFilterRule(5);

        verify($rule->isValid(6))->true();
        verify($rule->isValid('123'))->true();
        verify($rule->isValid(5))->false();

        $this->specify('parametro inválido (texto), lançar exceção', function () use ($rule) {
            $rule->isValid('text');
        }, array('throws' => 'LogicException'));
    }
}
