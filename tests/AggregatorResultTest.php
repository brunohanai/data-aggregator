<?php

namespace BrunoHanai\DataAggregator\Tests;

use BrunoHanai\DataAggregator\AggregatorResult;
use BrunoHanai\DataAggregator\Definition\ColumnDefinition;
use BrunoHanai\DataAggregator\Definition\RowDefinition;
use BrunoHanai\DataAggregator\Operation\OperationIncrement;
use BrunoHanai\DataAggregator\Operation\OperationSum;
use Cocur\Slugify\Slugify;

class AggregatorResultTest extends \PHPUnit_Framework_TestCase
{
    public function testAppendValue()
    {
        $slugify = new Slugify();

        $rowDefinition = new RowDefinition('grupo_descricao', 'Grupo');
        $columnDefinition1 = new ColumnDefinition('atendidas', new OperationSum(), 'Atendidas');
        $columnDefinition2 = new ColumnDefinition('contagem', new OperationIncrement(), 'Contagem');

        $aggregatorResult = new AggregatorResult($slugify);
        $aggregatorResult->appendValue(
            $rowDefinition->getLabel(),
            $columnDefinition1->getOperation(),
            10,
            $columnDefinition1->getNewColumnName()
        );
        $aggregatorResult->appendValue(
            $rowDefinition->getLabel(),
            $columnDefinition1->getOperation(),
            10,
            $columnDefinition1->getNewColumnName()
        );
        $aggregatorResult->appendValue(
            $rowDefinition->getLabel(),
            $columnDefinition2->getOperation(),
            null,
            $columnDefinition2->getNewColumnName()
        );

        $results = $aggregatorResult->getArrayResult();

        verify($results[0]['_label'])->equals('Grupo');
        verify($results[0]['atendidas'])->equals(20);
        verify($results[0]['contagem'])->equals(1);
    }
}
