<?php

namespace BrunoHanai\DataAggregator\Filter\Evaluator\Strategy;

class UnanimousStrategy implements EvaluatorStrategyInterface
{
    public function evaluate($valid, $invalid)
    {
        return ($valid > 0 && $invalid === 0);
    }
}
