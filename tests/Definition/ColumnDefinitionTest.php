<?php

namespace BrunoHanai\DataAggregator\Tests;

use BrunoHanai\DataAggregator\Definition\ColumnDefinition;
use Codeception\Specify;

class ColumnDefinitionTest extends \PHPUnit_Framework_TestCase
{
    use Specify;

    public function test()
    {
        $this->specify('teste do constructor e getters, $new_column_name será omitido, usar fallback', function () {
            $sourceColumn = 'Source-Column';
            $operation = $this->getMockBuilder('BrunoHanai\DataAggregator\Operation\OperationInterface')->getMock();

            $definition = new ColumnDefinition($sourceColumn, $operation);

            verify($definition)->isInstanceOf('BrunoHanai\DataAggregator\Definition\ColumnDefinition');
            verify($definition->getSourceColumn())->equals($sourceColumn);
            verify($definition->getOperation())->equals($operation);
        });

        $this->specify('teste do constructor e getters', function () {
            $sourceColumn = 'Source-Column';
            $newColumn = 'New-Column';
            $operation = $this->getMockBuilder('BrunoHanai\DataAggregator\Operation\OperationInterface')->getMock();

            $definition = new ColumnDefinition($sourceColumn, $operation, $newColumn);

            verify($definition)->isInstanceOf('BrunoHanai\DataAggregator\Definition\ColumnDefinition');
            verify($definition->getSourceColumn())->equals($sourceColumn);
            verify($definition->getNewColumnName())->equals($newColumn);
            verify($definition->getOperation())->equals($operation);
        });
    }
}
