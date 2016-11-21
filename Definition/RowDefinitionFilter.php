<?php

namespace BrunoHanai\DataAggregator\Definition;

use BrunoHanai\DataAggregator\Filter\AbstractFilter;
use BrunoHanai\DataAggregator\Filter\Evaluator\Strategy\EvaluatorStrategyInterface;

class RowDefinitionFilter
{
    private $evaluatorStrategy;
    private $columns;

    public function __construct(EvaluatorStrategyInterface $evaluator_strategy)
    {
        $this->evaluatorStrategy = $evaluator_strategy;
        $this->columns = array();
    }

    public function setEvaluatorStrategy(EvaluatorStrategyInterface $evaluator_strategy)
    {
        $this->evaluatorStrategy = $evaluator_strategy;

        return $this;
    }

    public function getEvaluatorStrategy()
    {
        return $this->evaluatorStrategy;
    }

    public function setRowColumnFilter($sourceColumn, AbstractFilter $filter)
    {
        $this->columns[$sourceColumn] = $filter;

        return $this;
    }

    public function getColumns()
    {
        return $this->columns;
    }
}
