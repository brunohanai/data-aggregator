<?php

namespace BrunoHanai\DataAggregator\Filter;

abstract class AbstractFilter
{
    abstract public function isValid($value);
}
