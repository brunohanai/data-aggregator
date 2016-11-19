<?php

namespace BrunoHanai\DataAggregator\Filter\Rules;

class NotEqualsFilterRule extends AbstractFilterRule
{
    public function isValid($value)
    {
        return $value !== $this->value;
    }
}
