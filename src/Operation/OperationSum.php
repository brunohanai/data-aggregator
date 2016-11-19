<?php

namespace BrunoHanai\DataAggregator\Operation;

class OperationSum implements OperationInterface
{
    public function doOperation($current_value = null, $new_value = null, array $context = array())
    {
        if (!is_numeric($current_value) || !is_numeric($new_value)) {
            throw new \LogicException('The values must be numeric.');
        }

        return $current_value + $new_value;
    }
}