<?php

namespace BrunoHanai\DataAggregator\Tests;

use BrunoHanai\DataAggregator\Filter\Rules\LessThanFilterRule;
use Codeception\Specify;

class LessThanFilterRuleTest extends \PHPUnit_Framework_TestCase
{
    use Specify;

    public function testIsValid()
    {
        $rule = new LessThanFilterRule(5);

        verify($rule->isValid(4))->true();
        verify($rule->isValid('123'))->false();
        verify($rule->isValid(5))->false();

        $this->specify('parametro inválido (texto), lançar exceção', function () use ($rule) {
            $rule->isValid('text');
        }, array('throws' => 'LogicException'));
    }
}
