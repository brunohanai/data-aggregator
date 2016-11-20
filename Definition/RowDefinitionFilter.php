<?php

namespace BrunoHanai\DataAggregator\Definition;

use BrunoHanai\DataAggregator\Filter\Filter;
use BrunoHanai\DataAggregator\Filter\Rules\AbstractFilterRule;

class RowDefinitionFilter
{
    private $strategy;
    private $columns;

    public function __construct($strategy = Filter::FILTER_STRATEGY_AFFIRMATIVE)
    {
        $this->setStrategy($strategy);
        $this->columns = array();
    }

    public function setStrategy($strategy)
    {
        if (!in_array($strategy, Filter::getStrategies())) {
            throw new \InvalidArgumentException(sprintf('The strategy "%s" is not valid.', $strategy));
        }

        $this->strategy = $strategy;

        return $this;
    }

    public function getStrategy()
    {
        return $this->strategy;
    }

    public function setRowColumnFilterRule($sourceColumn, AbstractFilterRule $filter_rule)
    {
        $this->columns[$sourceColumn] = $filter_rule;

        return $this;
    }

    public function getColumns()
    {
        return $this->columns;
    }
}
