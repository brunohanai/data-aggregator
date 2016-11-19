<?php

namespace BrunoHanai\DataAggregator\Operation;

interface OperationInterface
{
    public function doOperation($current_value, $new_value, array $context = array());
}
