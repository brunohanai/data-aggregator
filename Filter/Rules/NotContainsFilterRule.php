<?php

namespace BrunoHanai\DataAggregator\Filter\Rules;

class NotContainsFilterRule extends AbstractFilterRule
{
    public function isValid($value)
    {
        return !in_array($value, (array)$this->value);
    }
}
