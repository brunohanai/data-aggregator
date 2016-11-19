<?php

namespace BrunoHanai\DataAggregator\Operation;

class OperationIncrement implements OperationInterface
{
    public function doOperation($current_value, $new_value = null, array $context = array())
    {
        $current_value = empty($current_value) || is_null($current_value) ? 0 : $current_value;

        if (!is_numeric($current_value)) {
            throw new \LogicException('The values must be numeric.');
        }

        return $current_value + 1;
    }
}
