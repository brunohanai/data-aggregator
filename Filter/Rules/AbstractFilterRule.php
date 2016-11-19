<?php

namespace BrunoHanai\DataAggregator\Filter\Rules;

abstract class AbstractFilterRule
{
    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    abstract public function isValid($value);
}
