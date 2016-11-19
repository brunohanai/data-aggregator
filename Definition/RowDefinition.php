<?php

namespace BrunoHanai\DataAggregator\Definition;

class RowDefinition
{
    private $sourceColumn;
    private $label;

    public function __construct($sourceColumn, $label)
    {
        $this->sourceColumn = $sourceColumn;
        $this->label = $label;
    }

    public function getSourceColumn()
    {
        return $this->sourceColumn;
    }

    public function getLabel()
    {
        return $this->label;
    }
}
