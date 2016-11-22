<?php

namespace BrunoHanai\DataAggregator\Operation;

// TODO: Tenho que melhorar essa classe
class OperationManualCalc implements OperationInterface
{
    private $calc;

    public function __construct($calc)
    {
        if ($this->calcIsValid($calc) === false) {
            throw new \LogicException('The calc is not valid.');
        }

        $this->calc = $calc;
    }

    public function doOperation($current_value = null, $new_value = null, array $context = array())
    {
        preg_match_all('/\[([a-z0-9A-Z]{1,})\]/', $this->calc, $placeholders);

        $calc = $this->calc;

        foreach ($placeholders[1] as $placeholder) {
            $replace = isset($context[$placeholder]) ? $context[$placeholder] : 0;

            $calc = str_replace(sprintf('[%s]', $placeholder), $replace, $calc);
        }

        $result = null;
        eval(sprintf('$result = %s;', $calc));

        return $result;
    }

    private function calcIsValid($calc)
    {
        $resultCount = preg_grep('/(\[.+\]|[0-9]{1,3}) ?(\+|\-|\*|\/){1} ?(\[.+\]|[0-9]{1,3})/', array($calc));

        return count($resultCount) > 0;
    }
}
