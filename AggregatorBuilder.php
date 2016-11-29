<?php

namespace BrunoHanai\DataAggregator;

use BrunoHanai\DataAggregator\Definition\Definition;
use Symfony\Component\PropertyAccess\PropertyAccess;

class AggregatorBuilder
{
    private $definition = null;

    public function setDefinition(Definition $definition)
    {
        $this->definition = $definition;

        return $this;
    }

    public function getAggregator()
    {
        return new Aggregator(
            new AggregatorResultFactory(),
            PropertyAccess::createPropertyAccessor(),
            $this->definition
        );
    }
}
