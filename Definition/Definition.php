<?php

namespace BrunoHanai\DataAggregator\Definition;

use BrunoHanai\DataAggregator\Filter\FilterInterface;

class Definition
{
    private $rows;
    private $columns;
    private $filter;

    public function __construct(FilterInterface $filter = null)
    {
        $this->filter = $filter;
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

    public function addRow(RowDefinition $definition)
    {
        $this->rows[] = $definition;

        return $this;
    }

    public function getRows()
    {
        return $this->rows;
    }

    public function addColumn(ColumnDefinition $definition)
    {
        $this->columns[] = $definition;

        return $this;
    }

    public function getColumns()
    {
        return $this->columns;
    }
}
