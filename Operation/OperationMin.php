<?php

namespace BrunoHanai\DataAggregator\Operation;

class OperationMin implements OperationInterface
{
    public function doOperation($current_value = null, $new_value = null, array $context = array())
    {
        $current_value = is_numeric($current_value) ? $current_value : 0;
        $new_value = is_numeric($new_value) ? $new_value : 0;

        return min($current_value, $new_value);
    }
}
