<?php

namespace BrunoHanai\DataAggregator;

final class DataAggregator
{
    public static function createAggregator()
    {
        return self::createAggregatorBuilder()->getAggregator();
    }

    public static function createAggregatorBuilder()
    {
        return new AggregatorBuilder();
    }

    private function __construct()
    {
    }
}
