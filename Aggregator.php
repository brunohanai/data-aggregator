<?php

namespace BrunoHanai\DataAggregator;

use BrunoHanai\DataAggregator\Definition\ColumnDefinition;
use BrunoHanai\DataAggregator\Definition\Definition;
use BrunoHanai\DataAggregator\Definition\RowDefinition;
use BrunoHanai\DataAggregator\Definition\RowDefinitionFilter;
use BrunoHanai\DataAggregator\Filter\Filter;
use Cocur\Slugify\Slugify;
use Symfony\Component\PropertyAccess\PropertyAccessor;

class Aggregator
{
    private $resultFactory;
    private $dataAccessor;
    private $definition;

    public function __construct(
        AggregatorResultFactory $result_factory,
        PropertyAccessor $property_acessor,
        Definition $definition = null
    ) {
        $this->resultFactory = $result_factory;
        $this->dataAccessor = $property_acessor;
        $this->definition = $definition;
    }

    public function setDefinition(Definition $definition)
    {
        $this->definition = $definition;

        return $this;
    }

    public function aggregate(array $data) // TODO: Por enquanto só aceita array()
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

    // TODO: esse método não deveria estar aqui (e talvez não deveria ser assim!)
    private function checkItem($item, RowDefinitionFilter $filter = null)
    {
        if ($filter === null) {
            return true;
        }

        $result = array(true => 0, false => 0);

        /** @var $rule \BrunoHanai\DataAggregator\Filter\Rules\AbstractFilterRule */
        foreach ($filter->getColumns() as $column => $rule) {
            $value = $this->dataAccessor->getValue($item, $column);

            $result[$rule->isValid($value)]++;
        }

        return Filter::isValidAccordingToStrategy($result[true], $result[false], $filter->getStrategy());
    }
}
