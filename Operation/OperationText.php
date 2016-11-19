<?php

namespace BrunoHanai\DataAggregator\Operation;

class OperationText implements OperationInterface
{
    public function doOperation($current_value = null, $new_value = null, array $context = array())
    {
        return $new_value;
    }
}
