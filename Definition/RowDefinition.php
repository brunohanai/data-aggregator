<?php

namespace BrunoHanai\DataAggregator\Definition;

/*
 * TODO: Criar algo como "VirtualRowDefinition" onde $sourceColumn não é necessário pois será definido [virtual]
 * e o método getSourceColumn deve retornar o getLabel()
 * A RowDefinition atual serve para os casos normais onde as linhas são definidas através dos valores distintos
 */
class RowDefinition
{
    private $sourceColumn;
    private $label;
    private $filter;

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

    public function setRowDefinitionFilter(RowDefinitionFilter $row_definition_filter)
    {
        $this->filter = $row_definition_filter;

        return $this;
    }

    public function getFilter()
    {
        return $this->filter;
    }
}
