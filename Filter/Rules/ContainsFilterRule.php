<?php

namespace BrunoHanai\DataAggregator\Filter\Rules;

class ContainsFilterRule extends AbstractFilterRule
{
    public function isValid($value)
    {
        return in_array($value, (array)$this->value);
    }
}
