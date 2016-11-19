<?php

namespace BrunoHanai\DataAggregator\Tests;

use BrunoHanai\DataAggregator\Definition\RowDefinition;
use Codeception\Specify;

class RowDefinitionTest extends \PHPUnit_Framework_TestCase
{
    use Specify;

    public function test()
    {
        $this->specify('teste do constructor e getters', function () {
            $column = 'Column';
            $label = 'Label';

            $definition = new RowDefinition($column, $label);

            verify($definition)->isInstanceOf('BrunoHanai\DataAggregator\Definition\RowDefinition');
            verify($definition->getSourceColumn())->equals($column);
            verify($definition->getLabel())->equals($label);
        });
    }
}
