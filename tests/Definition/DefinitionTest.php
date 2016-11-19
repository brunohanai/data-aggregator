<?php

namespace BrunoHanai\DataAggregator\Tests;

use BrunoHanai\DataAggregator\Definition\Definition;
use Codeception\Specify;

class DefinitionTest extends \PHPUnit_Framework_TestCase
{
    use Specify;

    public function test()
    {
        $this->specify('teste do constructor, setters e getters', function () {
            $definition = new Definition();

            $rowDefinition1 = $this
                ->getMockBuilder('BrunoHanai\DataAggregator\Definition\RowDefinition')
                ->disableOriginalConstructor()
                ->getMock();
            $rowDefinition2 = clone $rowDefinition1;

            $columnDefinition1 = $this
                ->getMockBuilder('BrunoHanai\DataAggregator\Definition\ColumnDefinition')
                ->disableOriginalConstructor()
                ->getMock();
            $columnDefinition2 = clone $columnDefinition1;
            $columnDefinition3 = clone $columnDefinition1;

            $filter = $this->getMockBuilder('BrunoHanai\DataAggregator\Filter\FilterInterface')->getMock();

            $definition->addRow($rowDefinition1)->addRow($rowDefinition2);
            $definition->addColumn($columnDefinition1)->addColumn($columnDefinition2)->addColumn($columnDefinition3);

            verify($definition->getRows())->count(2);
            verify($definition->getRows()[0])->equals($rowDefinition1);
            verify($definition->getRows()[1])->equals($rowDefinition2);

            verify($definition->getColumns())->count(3);
            verify($definition->getColumns()[0])->equals($columnDefinition1);
            verify($definition->getColumns()[1])->equals($columnDefinition2);
            verify($definition->getColumns()[2])->equals($columnDefinition3);

            verify($definition->getFilter())->null();
            $definition->setFilter($filter);
            verify($definition->getFilter())->equals($filter);
        });
    }
}
