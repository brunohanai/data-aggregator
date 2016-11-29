<?php

namespace BrunoHanai\DataAggregator\Tests;

use BrunoHanai\DataAggregator\AggregatorBuilder;
use Codeception\Specify;

class AggregatorBuilderTest extends \PHPUnit_Framework_TestCase
{
    use Specify;

    public function testGetAggregator()
    {
        $builder = new AggregatorBuilder();

        $this->assertInstanceOf('BrunoHanai\DataAggregator\Aggregator', $builder->getAggregator());

        $definition = $this->getMockBuilder('BrunoHanai\DataAggregator\Definition\Definition')->getMock();

        $this->assertInstanceOf(
            'BrunoHanai\DataAggregator\Aggregator',
            $builder->setDefinition($definition)->getAggregator()
        );
    }
}
