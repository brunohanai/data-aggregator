<?php

namespace BrunoHanai\DataAggregator;

use Cocur\Slugify\Slugify;

class AggregatorResultFactory
{
    public function create()
    {
        return new AggregatorResult(new Slugify());
    }
}
