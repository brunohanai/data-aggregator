<?php

namespace BrunoHanai\DataAggregator\Definition;

class Definition
{
    private $rows;
    private $columns;

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
