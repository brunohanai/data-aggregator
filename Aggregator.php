<?php

namespace BrunoHanai\DataAggregator;

use BrunoHanai\DataAggregator\Definition\ColumnDefinition;
use BrunoHanai\DataAggregator\Definition\Definition;
use BrunoHanai\DataAggregator\Definition\RowDefinition;
use BrunoHanai\DataAggregator\Definition\RowDefinitionFilter;
use BrunoHanai\DataAggregator\Filter\Evaluator\FilterEvaluator;
use Symfony\Component\PropertyAccess\PropertyAccessor;

class Aggregator
{
    private $resultFactory;
    private $dataAccessor;
    private $definition;

    public function __construct(
        AggregatorResultFactory $result_factory,
        PropertyAccessor $property_accessor,
        Definition $definition = null
    ) {
        $this->resultFactory = $result_factory;
        $this->dataAccessor = $property_accessor;
        $this->definition = $definition;
    }

    public function setDefinition(Definition $definition)
    {
        $this->definition = $definition;

        return $this;
    }

    public function aggregate($data) // TODO: Por enquanto só aceita array()
    {
        if ($this->definition === null) {
            throw new \LogicException('The "Definition" must be set.');
        }

        $result = $this->resultFactory->create();

        foreach ($data as $item) {
            /** @var $rowDefinition RowDefinition */
            foreach ($this->definition->getRows() as $rowDefinition) {
                if ($this->checkItem($item, $rowDefinition->getFilter()) === false) {
                    continue;
                }

                /** @var $columnDefinition ColumnDefinition */
                foreach ($this->definition->getColumns() as $columnDefinition) {
                    // TODO: isso está ruim:
                    $sourceColumn = $rowDefinition->getSourceColumn();
                    $rowId = $sourceColumn === '[virtual]' ?
                        $rowDefinition->getLabel() :
                        $this->dataAccessor->getValue($item, $sourceColumn);

                    $result->appendValue(
                        $rowId,
                        $columnDefinition->getOperation(),
                        $this->dataAccessor->getValue($item, $columnDefinition->getSourceColumn()),
                        $columnDefinition->getNewColumnName()
                    );
                }
            }
        }

        return $result;
    }

    // TODO: Esse método deveria estar aqui? E ser dessa forma?
    private function checkItem($item, RowDefinitionFilter $row_definition_filter = null)
    {
        if ($row_definition_filter === null) {
            return true;
        }

        $evaluator = new FilterEvaluator();

        foreach ($row_definition_filter->getColumns() as $column => $filter) {
            $value = $this->dataAccessor->getValue($item, $column);

            $evaluator->appendItem($filter, $value);
        }

        return $evaluator->evaluate($row_definition_filter->getEvaluatorStrategy());
    }
}
