<?php

namespace BrunoHanai\DataAggregator\Filter;

use BrunoHanai\DataAggregator\Filter\Evaluator\FilterEvaluator;
use BrunoHanai\DataAggregator\Filter\Evaluator\Strategy\EvaluatorStrategyInterface;

class GroupFilter extends AbstractFilter
{
    private $evaluatorStrategy;

    /** @var array AbstractFilter[] */
    private $filters = array();

    public function __construct(EvaluatorStrategyInterface $evaluator_strategy)
    {
        // TODO: qual é a melhor forma de definir um Evaluator padrão? (com Container seria mais fácil)
        $this->evaluatorStrategy = $evaluator_strategy;
    }

    public function setEvaluatorStrategy(EvaluatorStrategyInterface $evaluator_strategy)
    {
        $this->evaluatorStrategy = $evaluator_strategy;
    }

    public function addFilter(AbstractFilter $filter)
    {
        $this->filters[] = $filter;

        return $this;
    }

    public function isValid($value)
    {
        if (count($this->filters) === 0) {
            return true;
        }

        $evaluator = new FilterEvaluator();

        foreach ($this->filters as $filter) {
            $evaluator->appendItem($filter, $value);
        }

        return $evaluator->evaluate($this->evaluatorStrategy);
    }
}
