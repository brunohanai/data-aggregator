<?php

namespace BrunoHanai\DataAggregator\Filter\Rules;

class EqualsFilterRule extends AbstractFilterRule
{
    public function isValid($value)
    {
        return $value === $this->value;
    }
}
