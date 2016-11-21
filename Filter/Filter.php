<?php

namespace BrunoHanai\DataAggregator\Filter;

use BrunoHanai\DataAggregator\Filter\Rules\AbstractFilterRule;

class Filter extends AbstractFilter
{
    private $rule;

    public function __construct(AbstractFilterRule $rule = null)
    {
        $this->rule = $rule;
    }

    public function setRule(AbstractFilterRule $rule)
    {
        $this->rule = $rule;
    }

    public function isValid($value)
    {
        if ($this->rule === null) {
            return true;
        }

        return $this->rule->isValid($value);
    }
}
