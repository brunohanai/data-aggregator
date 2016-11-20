<?php

namespace BrunoHanai\DataAggregator\Filter;

use BrunoHanai\DataAggregator\Filter\Rules\AbstractFilterRule;

class Filter implements FilterInterface
{
    const FILTER_STRATEGY_AFFIRMATIVE = 'filter.strategy.affirmative'; // valid > 0
    const FILTER_STRATEGY_CONSENSUS = 'filter.strategy.consensus';     // valid > invalid
    const FILTER_STRATEGY_UNANIMOUS = 'filter.strategy.unanimous';     // não pode ter nenhum invalid

    private $strategy;
    private $rules;

    public function __construct(array $rules = array(), $strategy = self::FILTER_STRATEGY_AFFIRMATIVE)
    {
        $this->setRules($rules);
        $this->setStrategy($strategy);
    }

    public static function getStrategies()
    {
        return array(
            self::FILTER_STRATEGY_AFFIRMATIVE,
            self::FILTER_STRATEGY_CONSENSUS,
            self::FILTER_STRATEGY_UNANIMOUS,
        );
    }

    private static function checkStrategy($strategy)
    {
        if (!in_array($strategy, self::getStrategies())) {
            throw new \InvalidArgumentException(sprintf('The strategy "%s" is not valid.', $strategy));
        }
    }

    public function setStrategy($strategy)
    {
        $this->checkStrategy($strategy);

        $this->strategy = $strategy;

        return $this;
    }

    public function setRules(array $rules)
    {
        foreach ($rules as $rule) {
            if (!$rule instanceof AbstractFilterRule) {
                throw new \InvalidArgumentException(sprintf('Invalid rule "%s"', get_class($rule)));
            }
        }

        $this->rules = $rules;

        return $this;
    }

    public function addRule(AbstractFilterRule $rue)
    {
        $this->rules[] = $rue;

        return $this;
    }

    public function getRules()
    {
        return $this->rules;
    }

    public function isValid($value)
    {
        if ($this->rules === null) {
            return true;
        }

        $valid = 0;
        $invalid = 0;

        /** @var  $rule AbstractFilterRule */
        foreach ($this->rules as $rule) {
            $rule->isValid($value) === true ? $valid++ : $invalid++;
        }

        return $this->isValidAccordingToStrategy($valid, $invalid, $this->strategy);
    }

    // TODO: Preciso pensar se esse método (e toda parte de estratégia) deveria estar aqui...
    public static function isValidAccordingToStrategy($valid, $invalid, $strategy)
    {
        self::checkStrategy($strategy);

        switch ($strategy) {
            case self::FILTER_STRATEGY_AFFIRMATIVE:
                return $valid > 0;
            case self::FILTER_STRATEGY_CONSENSUS:
                return $valid > $invalid;
            case self::FILTER_STRATEGY_UNANIMOUS:
                return $invalid === 0;
            default:
                return false;
        }
    }
}
