<?php

namespace BrunoHanai\DataAggregator\Definition;

use BrunoHanai\DataAggregator\Operation\OperationInterface;

class ColumnDefinition
{
    private $sourceColumn;
    private $newColumnName;
    private $operation;

    public function __construct($source_column, OperationInterface $operation, $new_column_name = null)
    {
        $this->sourceColumn = $source_column;
        $this->operation = $operation;
        $this->newColumnName = $new_column_name;
    }

    public function getSourceColumn()
    {
        return $this->sourceColumn;
    }

    public function getNewColumnName()
    {
        if ($this->newColumnName !== null) {
            return $this->newColumnName;
        }

        return $this->sourceColumn;
    }

    public function getOperation()
    {
        return $this->operation;
    }
}
