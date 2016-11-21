<?php

namespace BrunoHanai\DataAggregator\Tests;

use BrunoHanai\DataAggregator\Aggregator;
use BrunoHanai\DataAggregator\AggregatorResultFactory;
use BrunoHanai\DataAggregator\Definition\ColumnDefinition;
use BrunoHanai\DataAggregator\Definition\Definition;
use BrunoHanai\DataAggregator\Definition\RowDefinition;
use BrunoHanai\DataAggregator\Definition\RowDefinitionFilter;
use BrunoHanai\DataAggregator\Filter\Evaluator\Strategy\AffirmativeStrategy;
use BrunoHanai\DataAggregator\Filter\Filter;
use BrunoHanai\DataAggregator\Filter\Rules\GreaterThanFilterRule;
use BrunoHanai\DataAggregator\Filter\Rules\LessThanFilterRule;
use BrunoHanai\DataAggregator\Operation\OperationIncrement;
use BrunoHanai\DataAggregator\Operation\OperationSum;
use BrunoHanai\DataAggregator\Operation\OperationText;
use Codeception\Specify;
use Symfony\Component\PropertyAccess\PropertyAccess;

class AggregatorTest extends \PHPUnit_Framework_TestCase
{
    use Specify;

    public function testAggregate()
    {
        $data = array(
            array('grupo' => 'Grupo 1', 'fila' => 'Fila 1', 'atendidas' => 10, 'abandonadas' => 1),
            array('grupo' => 'Grupo 1', 'fila' => 'Fila 2', 'atendidas' => 11, 'abandonadas' => 2),
            array('grupo' => 'Grupo 1', 'fila' => 'Fila 3', 'atendidas' => 12, 'abandonadas' => 3),
            array('grupo' => 'Grupo 2', 'fila' => 'Fila 4', 'atendidas' => 13, 'abandonadas' => 4),
        );

        $this->specify('com linhas virtuais', function () use ($data) {
            $rowDefinition = new RowDefinition('[virtual]', 'Abandonadas (De boas)');
            $rowDefinition->setRowDefinitionFilter(
                (new RowDefinitionFilter(new AffirmativeStrategy()))
                    ->setRowColumnFilter('[abandonadas]', new Filter(new LessThanFilterRule(3)))
            );
            $rowDefinition2 = new RowDefinition('[virtual]', 'Abandonadas (Crítico)');
            $rowDefinition2->setRowDefinitionFilter(
                (new RowDefinitionFilter(new AffirmativeStrategy()))
                    ->setRowColumnFilter('[abandonadas]', new Filter(new GreaterThanFilterRule(2)))
            );

            $columnDefinition = new ColumnDefinition('[abandonadas]', new OperationSum());
            $columnDefinition2 = new ColumnDefinition('[atendidas]', new OperationSum());
            $columnDefinition3 = new ColumnDefinition('[grupo]', new OperationText());

            $definition = new Definition();
            $definition->addRow($rowDefinition)->addRow($rowDefinition2)
                ->addColumn($columnDefinition3)
                ->addColumn($columnDefinition2)
                ->addColumn($columnDefinition);

            $propertyAccessor = PropertyAccess::createPropertyAccessor();
            $aggregator = new Aggregator(new AggregatorResultFactory(), $propertyAccessor, $definition);

            $results = $aggregator->aggregate($data)->getArrayResult();

            verify($results[0]['abandonadas'])->equals(3);
            verify($results[1]['abandonadas'])->equals(7);
        });

        $this->specify('normal, agrupando por grupo', function () {
            $data = array(
                array('grupo' => 'Grupo 1', 'fila' => 'Fila 1', 'atendidas' => 10, 'abandonadas' => 1),
                array('grupo' => 'Grupo 1', 'fila' => 'Fila 2', 'atendidas' => 11, 'abandonadas' => 2),
                array('grupo' => 'Grupo 1', 'fila' => 'Fila 3', 'atendidas' => 12, 'abandonadas' => 3),
                array('grupo' => 'Grupo 2', 'fila' => 'Fila 4', 'atendidas' => 13, 'abandonadas' => 4),
            );

            $rowDefinition = new RowDefinition('[grupo]', 'Grupo');
            $columnDefinition1 = new ColumnDefinition('[atendidas]', new OperationSum(), 'Atendidas');
            $columnDefinition2 = new ColumnDefinition('[abandonadas]', new OperationSum(), 'Abandonadas');
            $columnDefinition3 = new ColumnDefinition('[contagem]', new OperationIncrement(), 'Contagem');

            $definition = new Definition();
            $definition->addRow($rowDefinition);
            $definition->addColumn($columnDefinition1)->addColumn($columnDefinition2)->addColumn($columnDefinition3);

            $propertyAccessor = PropertyAccess::createPropertyAccessor();
            $aggregator = new Aggregator(new AggregatorResultFactory(), $propertyAccessor, $definition);

            $results = $aggregator->aggregate($data)->getArrayResult();

            verify($results[0]['atendidas'])->equals(33);
            verify($results[0]['abandonadas'])->equals(6);
            verify($results[0]['contagem'])->equals(3);

            verify($results[1]['atendidas'])->equals(13);
            verify($results[1]['abandonadas'])->equals(4);
            verify($results[1]['contagem'])->equals(1);
        });

        $this->specify('agrupar por fila', function () {
            $data = array(
                array('grupo' => 'Grupo 1', 'fila' => 'Fila 1', 'atendidas' => 10, 'abandonadas' => 1),
                array('grupo' => 'Grupo 1', 'fila' => 'Fila 2', 'atendidas' => 11, 'abandonadas' => 2),
                array('grupo' => 'Grupo 1', 'fila' => 'Fila 3', 'atendidas' => 12, 'abandonadas' => 3),
                array('grupo' => 'Grupo 2', 'fila' => 'Fila 4', 'atendidas' => 13, 'abandonadas' => 4),
            );

            $rowDefinition = new RowDefinition('[fila]', 'Fila');
            $columnDefinition1 = new ColumnDefinition('[grupo]', new OperationText(), 'Grupo');
            $columnDefinition2 = new ColumnDefinition('[atendidas]', new OperationSum(), 'Atendidas');
            $columnDefinition3 = new ColumnDefinition('[abandonadas]', new OperationSum(), 'Abandonadas');
            $columnDefinition4 = new ColumnDefinition('[contagem]', new OperationIncrement(), 'Contagem');

            $definition = new Definition();
            $definition->addRow($rowDefinition);
            $definition
                ->addColumn($columnDefinition1)
                ->addColumn($columnDefinition2)
                ->addColumn($columnDefinition3)
                ->addColumn($columnDefinition4);

            $propertyAccessor = PropertyAccess::createPropertyAccessor();
            $aggregator = new Aggregator(new AggregatorResultFactory(), $propertyAccessor, $definition);

            $results = $aggregator->aggregate($data)->getArrayResult();

            verify($results[0]['grupo'])->equals('Grupo 1');
            verify($results[0]['atendidas'])->equals(10);
            verify($results[0]['abandonadas'])->equals(1);
            verify($results[0]['contagem'])->equals(1);

            verify($results[1]['grupo'])->equals('Grupo 1');
            verify($results[1]['atendidas'])->equals(11);
            verify($results[1]['abandonadas'])->equals(2);
            verify($results[1]['contagem'])->equals(1);
        });
    }
}
