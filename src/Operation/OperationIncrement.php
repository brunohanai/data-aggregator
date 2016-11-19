<?php

namespace BrunoHanai\DataAggregator\Operation;

class OperationIncrement implements OperationInterface
{
    public function doOperation($current_value, $new_value = null, array $context = array())
    {
        if (!is_numeric($current_value)) {
            throw new \LogicException('The values must be numeric.');
        }

        return $current_value + 1;
    }
}