<?php

namespace BrunoHanai\DataAggregator\Filter;

class Filter implements FilterInterface
{
    public function isValid($row_fields)
    {
        return true; // TODO: Por enquanto aceita tudo
    }
}
