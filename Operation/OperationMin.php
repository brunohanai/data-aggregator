<?php

namespace BrunoHanai\DataAggregator\Operation;

class OperationMin implements OperationInterface
{
    public function doOperation($current_value = null, $new_value = null, array $context = array())
    {
        if (!is_numeric($current_value) && !is_numeric($new_value)) {
            return null;
        }

        if (!is_numeric($current_value)) {
            return $new_value;
        }

        if (!is_numeric($new_value)) {
            return $current_value;
        }
        
        return min($current_value, $new_value);
    }
}
