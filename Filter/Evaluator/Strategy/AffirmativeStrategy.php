<?php

namespace BrunoHanai\DataAggregator\Filter\Evaluator\Strategy;

class AffirmativeStrategy implements EvaluatorStrategyInterface
{
    public function evaluate($valid, $invalid)
    {
        return $valid > 0;
    }
}
