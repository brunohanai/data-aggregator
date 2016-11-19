<?php

namespace BrunoHanai\DataAggregator\Definition;

use BrunoHanai\DataAggregator\Filter\FilterInterface;

class RowDefinition
{
    private $sourceColumn;
    private $label;
    private $filter;

    public function __construct($sourceColumn, $label, FilterInterface $filter = null)
    {
        $this->sourceColumn = $sourceColumn;
        $this->label = $label;
        $this->filter = $filter;
    }

    public function getSourceColumn()
    {
        return $this->sourceColumn;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function setFilter(FilterInterface $filter)
    {
        $this->filter = $filter;

        return $this;
    }

    public function getFilter()
    {
        return $this->filter;
    }
}
