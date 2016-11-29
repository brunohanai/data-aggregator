<?php

namespace BrunoHanai\DataAggregator\Filter;

interface FilterInterface
{
    public function isValid($value);
}
