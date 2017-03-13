<?php

namespace BrunoHanai\DataAggregator\Operation;

class OperationAverage implements OperationInterface
{
    public function doOperation($current_value = null, $new_value = null, array $context = array())
    {
        $first = false;

        if (is_null($current_value) || $current_value === '') {
            $first = true;
            $current_value = 0;
        }

        if (is_null($new_value) || $new_value === '') {
            return $first === true ? null : $current_value;
        }

        if (!is_numeric($current_value) || !is_numeric($new_value)) {
            throw new \LogicException('The values must be numeric.');
        }

        return $first === true ? $new_value : ($current_value + $new_value) / 2;
    }
}
