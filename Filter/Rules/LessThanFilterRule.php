<?php

namespace BrunoHanai\DataAggregator\Filter\Rules;

class LessThanFilterRule extends AbstractFilterRule
{
    public function isValid($value)
    {
        if (!is_numeric($value)) {
            throw new \LogicException('The value must be numeric.');
        }

        return $value < $this->value;
    }
}
