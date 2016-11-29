<?php

namespace BrunoHanai\DataAggregator;

use BrunoHanai\DataAggregator\Operation\OperationInterface;
use Cocur\Slugify\Slugify;

class AggregatorResult
{
    private $slugify;
    private $items;
    private $memoryColumns;

    public function __construct(Slugify $slugify)
    {
        $this->slugify = $slugify;
        $this->items = array();
        $this->memoryColumns = array();
    }

    public function appendValue($row_label, OperationInterface $operation, $new_value, $column_name)
    {
        $rowId = $this->createRowId($row_label);
        $columnName = $this->adjustColumnName($column_name);

        $currentValue = $this->getItemValue($rowId, $columnName);
        $currentValue = $currentValue === null ? 0 : $currentValue;

        $context = (array)$this->getItem($rowId);

        $this->items[$rowId]['_label'] = $row_label;
        $this->items[$rowId][$columnName] = $operation->doOperation($currentValue, $new_value, $context);
    }

    public function getItem($id)
    {
        return isset($this->items[$id]) ? $this->items[$id] : null;
    }

    public function getItemValue($id, $column)
    {
        return isset($this->items[$id][$column]) ? $this->items[$id][$column] : null;
    }

    public function getArrayResult()
    {
        return array_values($this->items);
    }

    private function createRowId($row_id)
    {
        return base64_encode($row_id);
    }

    /**
     * Saved in memory to avoid unnecessary slugify() calls
     *
     * @param $column_name
     * @return mixed|string
     */
    private function adjustColumnName($column_name)
    {
        if (isset($this->memoryColumns[$column_name])) {
            return $this->memoryColumns[$column_name];
        }

        $columnName = $this->slugify->slugify($column_name);

        $this->memoryColumns[$column_name] = $columnName;

        return $columnName;
    }
}
