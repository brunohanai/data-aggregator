<?php

namespace BrunoHanai\DataAggregator\Tests;

use BrunoHanai\DataAggregator\Definition\RowDefinition;
use BrunoHanai\DataAggregator\Filter\Filter;
use Codeception\Specify;

class RowDefinitionTest extends \PHPUnit_Framework_TestCase
{
    use Specify;

    public function test()
    {
        $this->specify('teste do constructor e getters', function () {
            $column = 'Column';
            $label = 'Label';
            $filter = new Filter();

            $definition = new RowDefinition($column, $label, $filter);

            verify($definition)->isInstanceOf('BrunoHanai\DataAggregator\Definition\RowDefinition');
            verify($definition->getSourceColumn())->equals($column);
            verify($definition->getLabel())->equals($label);
            verify($definition->getFilter())->equals($filter);
        });
    }
}
