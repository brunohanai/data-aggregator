<?php

namespace BrunoHanai\DataAggregator\Filter\Evaluator;

use BrunoHanai\DataAggregator\Filter\Evaluator\Strategy\EvaluatorStrategyInterface;
use BrunoHanai\DataAggregator\Filter\FilterInterface;

class FilterEvaluator
{
    private $valid;
    private $invalid;

    public function __construct()
    {
        $this->valid = 0;
        $this->invalid = 0;
    }

    public function appendItem(FilterInterface $filter, $value)
    {
        if ($filter->isValid($value) === true) {
            $this->valid++;
        } else {
            $this->invalid++;
        }
    }

    public function evaluate(EvaluatorStrategyInterface $strategy)
    {
        return $strategy->evaluate($this->valid, $this->invalid);
    }
}
