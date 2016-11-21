<?php

namespace BrunoHanai\DataAggregator\Filter\Evaluator\Strategy;

class ConsensusStrategy implements EvaluatorStrategyInterface
{
    public function evaluate($valid, $invalid)
    {
        return $valid > $invalid;
    }
}
