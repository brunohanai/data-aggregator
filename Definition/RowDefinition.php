<?php

namespace BrunoHanai\DataAggregator\Definition;

use BrunoHanai\DataAggregator\Filter\FilterInterface;

class RowDefinition
{
    private $sourceColumn;
    private $label;
    private $filter; // TODO: será implementado depois

    public function __construct($sourceColumn, $label, FilterInterface $filter)
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

    public function getFilter()
    {
        return $this->filter;
    }
}
