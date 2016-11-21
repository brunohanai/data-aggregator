<?php

namespace BrunoHanai\DataAggregator\Filter\Evaluator\Strategy;

interface EvaluatorStrategyInterface
{
    public function evaluate($valid, $invalid);
}
